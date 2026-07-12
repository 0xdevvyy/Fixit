<script setup lang="ts">
import Button from '@/components/ui/button/Button.vue'

import {
    Dialog,
    DialogContent,
    DialogDescription,
    DialogFooter,
    DialogHeader,
    DialogTitle,
    DialogTrigger,
    DialogClose,
} from '@/components/ui/dialog'

const emit = defineEmits<{
    (e: 'accept'): void
}>()
</script>

<template>
    <Dialog>
        <DialogTrigger as-child>
            <Button class="cursor-pointer">
                Accept Ticket
            </Button>
        </DialogTrigger>

        <DialogContent class="sm:max-w-md">
            <DialogHeader>
                <DialogTitle>
                    Accept Ticket
                </DialogTitle>

                <DialogDescription>
                    Are you sure you want to accept this ticket? This action will
                    allow the maintenance team to begin working on it.
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
                        class="cursor-pointer"
                        @click="emit('accept')"
                    >
                        Accept
                    </Button>
                </DialogClose>
            </DialogFooter>
        </DialogContent>
    </Dialog>
</template>