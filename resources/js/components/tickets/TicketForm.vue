<script setup lang="ts">
import { computed } from 'vue'
import { CardContent } from '@/components/ui/card'
import Input from '@/components/ui/input/Input.vue'
import { Label } from '@/components/ui/label'
// import Textarea from '@/components/ui/textarea/Textarea.vue'

import {
    Select,
    SelectContent,
    SelectItem,
    SelectTrigger,
    SelectValue,
} from '@/components/ui/select'

const props = defineProps({
    form: {
        type: Object,
        required: true,
    },
    categories: {
        type: Array,
        default: () => [],
    },
    priorities: {
        type: Array,
        default: () => [],
    },
    users: {
        type: Array,
        default: () => [],
    },
    buildings: {
        type: Array,
        default: () => [],
    },
    statuses: {
        type: Array,
        default: () => [],
    },
})
const form = computed(() => props.form)
</script>

<template>
    <hr class="mb-4"/>

    <CardContent class="space-y-6">
        <!-- Title -->
        <div class="space-y-2">
            <Label>
                Title
                <span class="text-destructive">*</span>
            </Label>

            <div class="h-10 rounded-md border bg-muted/30">
                <Input
                    v-model="form.title"
                    class="h-full w-full border-0 bg-transparent px-4 shadow-none focus-visible:ring-0"
                    placeholder="Ticket Title..."
                />
            </div>

            <p
                v-if="form.errors.title"
                class="text-sm text-destructive"
            >
                {{ form.errors.title }}
            </p>
        </div>

        <!-- Category -->
        <div class="space-y-2">
            <Label>
                Category
                <span class="text-destructive">*</span>
            </Label>

            <div class="rounded-md border bg-muted/30">
                <Select v-model="form.category">
                    <SelectTrigger class="h-full w-full border-0 bg-transparent px-4 shadow-none focus-visible:ring-0">
                        <SelectValue placeholder="Select Category" />
                    </SelectTrigger>

                    <SelectContent>
                        <SelectItem
                            v-for="category in categories"
                            :key="category.value"
                            :value="category.value"
                        >
                            {{ category.label }}
                        </SelectItem>
                    </SelectContent>
                </Select>
            </div>

            <p
                v-if="form.errors.category"
                class="text-sm text-destructive"
            >
                {{ form.errors.category }}
            </p>
        </div>

        <!-- Priority / Status -->
        <div class="grid gap-5 md:grid-cols-2">
            <!-- Priority -->
            <div class="space-y-2">
                <Label>Priority</Label>

                <div class="rounded-md border bg-muted/30">
                    <Select v-model="form.priority">
                        <SelectTrigger class="h-full w-full border-0 bg-transparent px-4 shadow-none focus-visible:ring-0">
                            <SelectValue placeholder="Select Priority" />
                        </SelectTrigger>

                        <SelectContent>
                            <SelectItem
                                v-for="priority in priorities"
                                :key="priority.value"
                                :value="priority.value"
                            >
                                {{ priority.label }}
                            </SelectItem>
                        </SelectContent>
                    </Select>
                </div>

                <p
                    v-if="form.errors.priority"
                    class="text-sm text-destructive"
                >
                    {{ form.errors.priority }}
                </p>
            </div>

            <!-- Status -->
            <div class="space-y-2">
                <Label>Status</Label>

                <div class="rounded-md border bg-muted/30">
                    <Select v-model="form.status">
                        <SelectTrigger class="h-full w-full border-0 bg-transparent px-4 shadow-none focus-visible:ring-0">
                            <SelectValue placeholder="Select Status" />
                        </SelectTrigger>

                        <SelectContent>
                            <SelectItem
                                v-for="status in statuses"
                                :key="status.value"
                                :value="status.value"
                            >
                                {{ status.label }}
                            </SelectItem>
                        </SelectContent>
                    </Select>
                </div>

                <p
                    v-if="form.errors.status"
                    class="text-sm text-destructive"
                >
                    {{ form.errors.status }}
                </p>
            </div>
        </div>

        <!-- Assigned -->
        <div class="grid gap-5 md:grid-cols-2">
            <div class="space-y-2">
                <Label>Assigned To</Label>

                <div class="rounded-md border bg-muted/30">
                    <Select v-model="form.assigned_to">
                        <SelectTrigger class="h-full w-full border-0 bg-transparent px-4 shadow-none focus-visible:ring-0">
                            <SelectValue placeholder="Assign User" />
                        </SelectTrigger>

                        <SelectContent>
                            <SelectItem
                                v-for="user in users"
                                :key="user.id"
                                :value="user.id"
                            >
                                {{ user.name }}
                            </SelectItem>
                        </SelectContent>
                    </Select>
                </div>

                <p
                    v-if="form.errors.assigned_to"
                    class="text-sm text-destructive"
                >
                    {{ form.errors.assigned_to }}
                </p>
            </div>

            <div class="space-y-2">
                <Label>Building</Label>

                <div class="rounded-md border bg-muted/30">
                    <Select v-model="form.building_id">
                    <SelectTrigger
                        class="h-full w-full border-0 bg-transparent px-4 shadow-none focus-visible:ring-0"
                    >
                        <SelectValue placeholder="Select Building" />
                    </SelectTrigger>

                        <SelectContent>
                            <SelectItem
                                v-for="building in buildings"
                                :key="building.id"
                                :value="building.id"
                            >
                                {{ building.name }}
                            </SelectItem>
                        </SelectContent>
                    </Select>
                </div>

                <p
                    v-if="form.errors.building_id"
                    class="text-sm text-destructive"
                >
                    {{ form.errors.building_id }}
                </p>
            </div>
        </div>

        <!-- Room -->
        <div class="space-y-2">
            <Label>Room</Label>

            <div class="h-10 rounded-md border bg-muted/30">
                <Input
                    v-model="form.room"
                    class="h-full w-full border-0 bg-transparent px-4 shadow-none focus-visible:ring-0"
                    placeholder="Room Name..."
                />
            </div>

            <p
                v-if="form.errors.room"
                class="text-sm text-destructive"
            >
                {{ form.errors.room }}
            </p>
        </div>

        <!-- Description -->
        <div class="space-y-2">
            <Label>Description</Label>

            <div class="overflow-hidden rounded-lg border">
                <textarea
                    v-model="form.description"
                    rows="8"
                    class="h-full w-full pl-4 border-0 shadow-none focus-visible:ring-0"
                    placeholder="Describe the issue..."
                />
            </div>

            <p
                v-if="form.errors.description"
                class="text-sm text-destructive"
            >
                {{ form.errors.description }}
            </p>
        </div>
    </CardContent>
</template>