<script setup lang="ts">
import { Input } from "@/components/ui/input";
import {
    Select,
    SelectContent,
    SelectItem,
    SelectTrigger,
    SelectValue,
} from "@/components/ui/select";
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

    <Select>
        <SelectTrigger class="w-40">
            <SelectValue placeholder="Status"/>
        </SelectTrigger>

        <SelectContent>
            <SelectItem value="open">Open</SelectItem>
            <SelectItem value="pending">Pending</SelectItem>
            <SelectItem value="resolved">Resolved</SelectItem>
        </SelectContent>
    </Select>

    <Select>
        <SelectTrigger class="w-40">
            <SelectValue placeholder="Priority"/>
        </SelectTrigger>

        <SelectContent>
            <SelectItem value="Low">Low</SelectItem>
            <SelectItem value="Medium">Medium</SelectItem>
            <SelectItem value="High">High</SelectItem>
        </SelectContent>
    </Select>

    <Select>
        <SelectTrigger class="w-40">
            <SelectValue placeholder="Category"/>
        </SelectTrigger>

        <SelectContent>
            <SelectItem value="IT">IT</SelectItem>
            <SelectItem value="Maintenance">Maintenance</SelectItem>
            <SelectItem value="Electrical">Electrical</SelectItem>
        </SelectContent>
    </Select>

</div>

</template>