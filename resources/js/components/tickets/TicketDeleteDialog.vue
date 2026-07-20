<script setup lang="ts">
import Button from '@/components/ui/button/Button.vue'

import {
    Dialog,
    DialogClose,
    DialogContent,
    DialogDescription,
    DialogFooter,
    DialogHeader,
    DialogTitle,
    DialogTrigger,
} from '@/components/ui/dialog'

import { Trash2 } from '@lucide/vue'

const emit = defineEmits<{
    (e: 'delete'): void
}>()
</script>

<template>
    <Dialog>
        <DialogTrigger as-child>
            <Button
                variant="destructive"
                size="sm"
                class="cursor-pointer"
            >
                <Trash2 class="mr-2 h-4 w-4" />
                Delete
            </Button>
        </DialogTrigger>

        <DialogContent class="sm:max-w-md">
            <DialogHeader>
                <DialogTitle>
                    Delete Ticket
                </DialogTitle>

                <DialogDescription>
                    Are you sure you want to delete this ticket? This action cannot
                    be undone.
                </DialogDescription>
            </DialogHeader>

            <DialogFooter>
                <DialogClose as-child>
                    <Button
                        variant="outline"
                        class="cursor-pointer"
                    >
                        Cancel
                    </Button>
                </DialogClose>

                <DialogClose as-child>
                    <Button
                        variant="destructive"
                        class="cursor-pointer"
                        @click="emit('delete')"
                    >
                        Delete
                    </Button>
                </DialogClose>
            </DialogFooter>
        </DialogContent>
    </Dialog>
</template>