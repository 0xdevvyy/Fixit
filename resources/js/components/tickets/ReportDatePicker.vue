<script setup lang="ts">
import {
    Select,
    SelectContent,
    SelectItem,
    SelectTrigger,
    SelectValue,
} from '@/components/ui/select';

type ReportPeriod = 'monthly' | 'weekly';

defineProps<{
    period: ReportPeriod;
    date: string;
}>();

const emit = defineEmits<{
    'update:period': [value: ReportPeriod];
    'update:date': [value: string];
}>();

function updatePeriod(value: unknown) {
    if (value === 'monthly' || value === 'weekly') {
        emit('update:period', value);
    }
}
</script>

<template>
    <div class="flex flex-col gap-2 sm:flex-row sm:items-center">
        <Select
            :model-value="period"
            @update:model-value="updatePeriod"
        >
            <SelectTrigger class="w-full rounded-lg sm:w-[180px]" aria-label="Report period">
                <SelectValue placeholder="Select report period" />
            </SelectTrigger>

            <SelectContent class="rounded-xl">
                <SelectItem value="monthly">Monthly report</SelectItem>
                <SelectItem value="weekly">Weekly report</SelectItem>
            </SelectContent>
        </Select>

        <label for="report-date" class="sr-only">
            {{ period === 'monthly' ? 'Select report month' : 'Select report week' }}
        </label>
        <input
            id="report-date"
            :type="period === 'monthly' ? 'month' : 'week'"
            :value="date"
            :aria-label="period === 'monthly' ? 'Select report month' : 'Select report week'"
            class="h-10 w-full rounded-lg border border-input bg-background px-3 py-2 text-sm shadow-sm sm:w-auto"
            @input="emit('update:date', ($event.target as HTMLInputElement).value)"
        />
    </div>
</template>
