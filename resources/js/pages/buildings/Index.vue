<script setup lang="ts">
import { Head, router, useForm } from '@inertiajs/vue3'
import { Eye, Pencil, Plus, Trash2, Wrench } from '@lucide/vue'
import { ref } from 'vue'
import InputError from '@/components/InputError.vue'
import { Button } from '@/components/ui/button'
import { Card, CardContent } from '@/components/ui/card'
import {
    Dialog,
    DialogClose,
    DialogContent,
    DialogDescription,
    DialogFooter,
    DialogHeader,
    DialogTitle,
} from '@/components/ui/dialog'
import { Input } from '@/components/ui/input'
import { Label } from '@/components/ui/label'
import {
    Table,
    TableBody,
    TableCell,
    TableHead,
    TableHeader,
    TableRow,
} from '@/components/ui/table'

interface MaintenanceUser {
    id: number
    name: string
}

interface Building {
    id: number
    name: string
    maintenance: {
        id: number
        name: string
        email: string
    } | null
    tickets_count: number
}

defineProps<{
    buildings: Building[]
    maintenanceUsers: MaintenanceUser[]
    canManage: boolean
}>()

const formOpen = ref(false)
const detailOpen = ref(false)
const deleteOpen = ref(false)
const editingBuilding = ref<Building | null>(null)
const selectedBuilding = ref<Building | null>(null)
const deleteTarget = ref<Building | null>(null)

const form = useForm({
    name: '',
    user_id: null as number | null,
})

function openCreateDialog() {
    editingBuilding.value = null
    form.reset()
    form.clearErrors()
    formOpen.value = true
}

function openEditDialog(building: Building) {
    editingBuilding.value = building
    form.name = building.name
    form.user_id = building.maintenance?.id ?? null
    form.clearErrors()
    formOpen.value = true
}

function saveBuilding() {
    if (editingBuilding.value) {
        form.patch(`/buildings/${editingBuilding.value.id}`, {
            onSuccess: () => {
                formOpen.value = false
                form.reset()
            },
        })
        return
    }

    form.post('/buildings', {
        onSuccess: () => {
            formOpen.value = false
            form.reset()
        },
    })
}

function showBuilding(building: Building) {
    selectedBuilding.value = building
    detailOpen.value = true
}

function confirmDelete(building: Building) {
    deleteTarget.value = building
    deleteOpen.value = true
}

function deleteBuilding() {
    if (!deleteTarget.value) {
        return
    }

    router.delete(`/buildings/${deleteTarget.value.id}`, {
        onSuccess: () => {
            deleteOpen.value = false
            deleteTarget.value = null
        },
    })
}
</script>

<template>
    <Head title="Buildings" />

    <div class="space-y-6 p-6">
        <div class="flex flex-col gap-4 sm:flex-row sm:items-center sm:justify-between">
            <div>
                <h1 class="text-3xl font-bold tracking-tight">Buildings</h1>
                <p class="mt-1 text-muted-foreground">
                    View buildings and the maintenance staff assigned to each one.
                </p>
            </div>
            <Button v-if="canManage" class="cursor-pointer" @click="openCreateDialog">
                <Plus class="mr-2 h-4 w-4" />
                Add building
            </Button>
        </div>

        <Card>
            <CardContent class="p-0">
                <Table>
                    <TableHeader>
                        <TableRow>
                            <TableHead>Building</TableHead>
                            <TableHead>Maintenance</TableHead>
                            <TableHead class="text-right">
                                {{ canManage ? 'Actions' : 'View' }}
                            </TableHead>
                        </TableRow>
                    </TableHeader>
                    <TableBody>
                        <TableRow v-for="building in buildings" :key="building.id">
                            <TableCell class="font-medium">{{ building.name }}</TableCell>
                            <TableCell>
                                <span v-if="building.maintenance">
                                    {{ building.maintenance.name }}
                                </span>
                                <span v-else class="text-muted-foreground">Unassigned</span>
                            </TableCell>
                            <TableCell v-if="canManage" class="text-right">
                                <div class="flex justify-end gap-2">
                                    <Button
                                        variant="outline"
                                        size="sm"
                                        class="cursor-pointer"
                                        @click="showBuilding(building)"
                                    >
                                        <Eye class="mr-2 h-4 w-4" />
                                        View
                                    </Button>
                                    <Button
                                        variant="outline"
                                        size="sm"
                                        class="cursor-pointer"
                                        @click="openEditDialog(building)"
                                    >
                                        <Pencil class="mr-2 h-4 w-4" />
                                        Edit
                                    </Button>
                                    <Button
                                        variant="destructive"
                                        size="sm"
                                        class="cursor-pointer"
                                        @click="confirmDelete(building)"
                                    >
                                        <Trash2 class="mr-2 h-4 w-4" />
                                        Delete
                                    </Button>
                                </div>
                            </TableCell>
                            <TableCell v-else>
                                <Button
                                    variant="outline"
                                    size="sm"
                                    class="cursor-pointer"
                                    @click="showBuilding(building)"
                                >
                                    <Eye class="mr-2 h-4 w-4" />
                                    View
                                </Button>
                            </TableCell>
                        </TableRow>
                        <TableRow v-if="buildings.length === 0">
                            <TableCell
                                :colspan="3"
                                class="py-12 text-center text-muted-foreground"
                            >
                                No buildings have been added yet.
                            </TableCell>
                        </TableRow>
                    </TableBody>
                </Table>
            </CardContent>
        </Card>
    </div>

    <Dialog v-model:open="formOpen">
        <DialogContent class="sm:max-w-lg">
            <form class="space-y-6" @submit.prevent="saveBuilding">
                <DialogHeader>
                    <DialogTitle>
                        {{ editingBuilding ? 'Edit building' : 'Add building' }}
                    </DialogTitle>
                    <DialogDescription>
                        Set the building name and assign its maintenance staff.
                    </DialogDescription>
                </DialogHeader>

                <div class="space-y-4">
                    <div class="space-y-2">
                        <Label for="building-name">Building name</Label>
                        <Input
                            id="building-name"
                            v-model="form.name"
                            placeholder="e.g. Main Building"
                            required
                            maxlength="255"
                        />
                        <InputError :message="form.errors.name" />
                    </div>

                    <div class="space-y-2">
                        <Label for="building-maintenance">Maintenance</Label>
                        <select
                            id="building-maintenance"
                            v-model="form.user_id"
                            class="border-input bg-background ring-offset-background focus-visible:ring-ring flex h-9 w-full rounded-md border px-3 py-1 text-sm shadow-xs outline-none focus-visible:ring-2 focus-visible:ring-offset-2"
                        >
                            <option :value="null">Unassigned</option>
                            <option
                                v-for="maintenance in maintenanceUsers"
                                :key="maintenance.id"
                                :value="maintenance.id"
                            >
                                {{ maintenance.name }}
                            </option>
                        </select>
                        <InputError :message="form.errors.user_id" />
                    </div>
                </div>

                <DialogFooter>
                    <DialogClose as-child>
                        <Button type="button" variant="outline" :disabled="form.processing">
                            Cancel
                        </Button>
                    </DialogClose>
                    <Button type="submit" :disabled="form.processing">
                        {{ form.processing ? 'Saving...' : editingBuilding ? 'Save changes' : 'Add building' }}
                    </Button>
                </DialogFooter>
            </form>
        </DialogContent>
    </Dialog>

    <Dialog v-model:open="detailOpen">
        <DialogContent class="sm:max-w-md">
            <DialogHeader>
                <DialogTitle>{{ selectedBuilding?.name }}</DialogTitle>
                <DialogDescription>
                    Building details and assigned maintenance staff.
                </DialogDescription>
            </DialogHeader>
            <div class="space-y-3 rounded-lg border p-4">
                <div class="flex items-center gap-3">
                    <Wrench class="h-5 w-5 text-muted-foreground" />
                    <div>
                        <p class="text-sm font-medium">Maintenance</p>
                        <p class="text-sm text-muted-foreground">
                            {{ selectedBuilding?.maintenance?.name ?? 'Unassigned' }}
                        </p>
                        <p
                            v-if="selectedBuilding?.maintenance"
                            class="text-sm text-muted-foreground"
                        >
                            {{ selectedBuilding.maintenance.email }}
                        </p>
                    </div>
                </div>
                <div class="border-t pt-3">
                    <p class="text-sm font-medium">Linked tickets</p>
                    <p class="text-sm text-muted-foreground">
                        {{ selectedBuilding?.tickets_count ?? 0 }}
                    </p>
                </div>
            </div>
            <DialogFooter>
                <DialogClose as-child>
                    <Button variant="outline">Close</Button>
                </DialogClose>
            </DialogFooter>
        </DialogContent>
    </Dialog>

    <Dialog v-model:open="deleteOpen">
        <DialogContent class="sm:max-w-md">
            <DialogHeader>
                <DialogTitle>Delete {{ deleteTarget?.name }}?</DialogTitle>
                <DialogDescription>
                    This cannot be undone. Any tickets linked to this building will also be deleted.
                </DialogDescription>
            </DialogHeader>
            <DialogFooter>
                <DialogClose as-child>
                    <Button variant="outline">Cancel</Button>
                </DialogClose>
                <Button variant="destructive" class="cursor-pointer" @click="deleteBuilding">
                    <Trash2 class="mr-2 h-4 w-4" />
                    Delete building
                </Button>
            </DialogFooter>
        </DialogContent>
    </Dialog>
</template>
