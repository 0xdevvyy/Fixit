<script setup lang="ts">
// import { Search } from "lucide-vue-next";
import { Input } from "@/components/ui/input";
import {
    Select,
    SelectContent,
    SelectItem,
    SelectTrigger,
    SelectValue,
} from "@/components/ui/select";

</script>

<template>

<div class="flex flex-wrap gap-3">

    <div class="relative w-72">
        <Search class="absolute left-3 top-3 h-4 w-4 text-gray-400"/>

        <Input
            placeholder="Search tickets..."
            class="pl-9"
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