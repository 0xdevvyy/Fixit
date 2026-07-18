<script setup lang="ts">
import { Input } from "@/components/ui/input";
import { Search } from "@lucide/vue";

const props = defineProps({
    modelValue: String,

})

let emit = defineEmits(['update:modelValue'])

// console.log(props.modelValue)

</script>

<template>

<div class="flex flex-wrap gap-3">

    <div class="relative w-72">
        <Search class="absolute left-3 top-2.5 h-4 w-4 text-primary"/>

        <Input
            placeholder="Search Tickets#...."
            class="pl-9"
            @keyup="emit('update:modelValue', $event.target.value)"
            :model-value="modelValue"
        />
    </div>


</div>

</template>