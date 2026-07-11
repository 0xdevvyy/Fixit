<script setup lang="ts">
import {
    Dialog,
    DialogContent,
} from '@/components/ui/dialog'

defineProps<{
    open: boolean
    image: string
}>()

const emit = defineEmits<{
    (e: 'update:open', value: boolean): void
}>()
</script>

<template>
    <Dialog
        :open="open"
        @update:open="emit('update:open', $event)"
    >
        <DialogContent class="max-w-5xl border-0 bg-transparent p-0 shadow-none">
            <img
                :src="image"
                alt="Ticket Image"
                class="max-h-[90vh] w-full rounded-lg object-contain"
            />
        </DialogContent>
    </Dialog>
</template>