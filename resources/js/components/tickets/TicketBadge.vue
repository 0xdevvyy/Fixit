<script setup lang="ts">
const props = defineProps<{
    status:string
}>()

const colors = {
    open: 'bg-yellow-100 text-yellow-700',
    pending: 'bg-yellow-100 text-yellow-700',
    in_progress: 'bg-blue-100 text-blue-700',
    completed: 'bg-green-100 text-green-700',
    closed: 'bg-gray-200 text-gray-700',
}
</script>

<template>

    <span
        class="rounded-md px-3 py-1 text-xs font-semibold"
        :class="colors[status]"
    >
    {{ status.replace('_',' ') }}
    </span>

</template>