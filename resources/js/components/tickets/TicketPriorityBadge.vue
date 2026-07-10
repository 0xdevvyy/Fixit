<script setup lang="ts">
const props = defineProps<{
    priority:string
}>()

const colors = {
    low: 'bg-green-100 text-green-700',
    medium: 'bg-yellow-100 text-yellow-700',
    high: 'bg-orange-100 text-orange-700',
    critical: 'bg-red-100 text-red-700',
}
</script>

<template>

    <span
        class="rounded-md px-3 py-1 text-xs font-semibold"
        :class="colors[priority]"
    >
    {{ priority }}
    </span>

</template>