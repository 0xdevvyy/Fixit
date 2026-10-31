<script setup lang="ts">
import { Head, router } from '@inertiajs/vue3';
import { Download } from '@lucide/vue';
import { computed, ref, watch } from 'vue';
import ReportDatePicker from '@/components/tickets/ReportDatePicker.vue';
import { Button } from '@/components/ui/button';
import {
    Card,
    CardContent,
    CardDescription,
    CardHeader,
    CardTitle,
} from '@/components/ui/card';
import reportsRoute from '@/routes/reports';

defineOptions({
    layout: {
        breadcrumbs: [
            {
                title: 'Reports',
                href: reportsRoute.index(),
            },
        ],
    },
});

type ReportPeriod = 'monthly' | 'weekly';

interface Props {
    report: {
        total: number;
        statuses: Record<string, number>;
        priorities: Record<string, number>;
        categories: Record<string, number>;
    };
    reportPeriod: ReportPeriod;
    reportDate: string;
    reportLabel: string;
}

const props = defineProps<Props>();
const selectedPeriod = ref<ReportPeriod>(props.reportPeriod);
const selectedDate = ref(props.reportDate);

watch(selectedPeriod, () => {
    selectedDate.value = selectedPeriod.value === 'monthly'
        ? currentMonth()
        : currentWeek();
});

watch([selectedPeriod, selectedDate], ([period, date]) => {
    if (!date) {
        return;
    }

    router.get(reportsRoute.index.url(), {
        reportPeriod: period,
        reportDate: date,
    }, {
        preserveScroll: true,
        preserveState: true,
        replace: true,
    });
});

function currentMonth() {
    const now = new Date();
    return `${now.getFullYear()}-${String(now.getMonth() + 1).padStart(2, '0')}`;
}

function currentWeek() {
    const now = new Date();
    const date = new Date(Date.UTC(now.getFullYear(), now.getMonth(), now.getDate()));
    const weekday = date.getUTCDay() || 7;
    date.setUTCDate(date.getUTCDate() + 4 - weekday);
    const yearStart = new Date(Date.UTC(date.getUTCFullYear(), 0, 1));
    const week = Math.ceil(((date.getTime() - yearStart.getTime()) / 86400000 + 1) / 7);
    return `${date.getUTCFullYear()}-W${String(week).padStart(2, '0')}`;
}

const downloadUrl = computed(() => reportsRoute.download.url({
    query: {
        reportPeriod: selectedPeriod.value,
        reportDate: selectedDate.value,
    },
}));

const statusRows = computed(() => Object.entries(props.report.statuses));
const priorityRows = computed(() => Object.entries(props.report.priorities));
const categoryRows = computed(() => Object.entries(props.report.categories));

function label(value: string) {
    return value.replaceAll('_', ' ').replace(/\b\w/g, (letter) => letter.toUpperCase());
}
</script>

<template>
    <Head title="Reports" />

    <div class="space-y-6 p-6">
        <div class="flex flex-col gap-4 sm:flex-row sm:items-end sm:justify-between">
            <div>
                <h1 class="text-3xl font-bold tracking-tight">Ticket reports</h1>
                <p class="mt-1 text-muted-foreground">
                    Review ticket activity and download a report for the selected period.
                </p>
            </div>

            <div class="flex flex-col gap-2 sm:flex-row sm:items-center">
                <ReportDatePicker
                    v-model:period="selectedPeriod"
                    v-model:date="selectedDate"
                />
                <Button as="a" :href="downloadUrl" class="cursor-pointer">
                    <Download class="h-4 w-4" />
                    Download PDF
                </Button>
            </div>
        </div>

        <p class="text-sm font-medium text-muted-foreground">
            Report period: {{ reportLabel }}
        </p>

        <div class="grid gap-4 sm:grid-cols-2 lg:grid-cols-4">
            <Card>
                <CardHeader>
                    <CardDescription>Total tickets</CardDescription>
                    <CardTitle class="text-3xl">{{ report.total }}</CardTitle>
                </CardHeader>
            </Card>
            <Card
                v-for="(total, status) in report.statuses"
                :key="status"
            >
                <CardHeader>
                    <CardDescription>{{ label(status) }}</CardDescription>
                    <CardTitle class="text-3xl">{{ total }}</CardTitle>
                </CardHeader>
            </Card>
        </div>

        <div class="grid gap-4 lg:grid-cols-3">
            <Card>
                <CardHeader>
                    <CardTitle>Status breakdown</CardTitle>
                </CardHeader>
                <CardContent class="space-y-2">
                    <div
                        v-for="[status, total] in statusRows"
                        :key="status"
                        class="flex justify-between border-b py-2 last:border-0"
                    >
                        <span>{{ label(status) }}</span>
                        <span class="font-semibold">{{ total }}</span>
                    </div>
                </CardContent>
            </Card>
            <Card>
                <CardHeader>
                    <CardTitle>Priority breakdown</CardTitle>
                </CardHeader>
                <CardContent class="space-y-2">
                    <div
                        v-for="[priority, total] in priorityRows"
                        :key="priority"
                        class="flex justify-between border-b py-2 last:border-0"
                    >
                        <span>{{ label(priority) }}</span>
                        <span class="font-semibold">{{ total }}</span>
                    </div>
                </CardContent>
            </Card>
            <Card>
                <CardHeader>
                    <CardTitle>Category breakdown</CardTitle>
                </CardHeader>
                <CardContent class="space-y-2">
                    <div
                        v-for="[category, total] in categoryRows"
                        :key="category"
                        class="flex justify-between border-b py-2 last:border-0"
                    >
                        <span>{{ label(category) }}</span>
                        <span class="font-semibold">{{ total }}</span>
                    </div>
                </CardContent>
            </Card>
        </div>
    </div>
</template>
