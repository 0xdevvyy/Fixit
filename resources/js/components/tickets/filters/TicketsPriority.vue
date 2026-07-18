<script setup lang="ts">
    import {
        Select,
        SelectContent,
        SelectItem,
        SelectTrigger,
        SelectValue,
    } from "@/components/ui/select";

    let emit = defineEmits(['update:modelValue'])

    const props = defineProps({
        options: Array<string>,
        modelValue: String,
    })
</script>


<template>
    <Select 
        :model-value="modelValue" 
        @update:model-value="value => emit('update:modelValue', value)">
        <SelectTrigger class="w-40">
            <SelectValue placeholder="Priority"/>
        </SelectTrigger>

        <SelectContent>
            <SelectItem 
                v-for="option in options"
                :key="option"
                :value="option"
                >
            {{ option.replace(/_/g, ' ').replace(/\b\w/g, c => c.toUpperCase()) }}
            </SelectItem>

        </SelectContent>
    </Select>
</template>