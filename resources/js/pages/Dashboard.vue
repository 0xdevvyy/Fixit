<script setup lang="ts">
import { Head, Link, usePage } from '@inertiajs/vue3';
import {
    Ticket,
    CircleCheckBig,
    CircleAlert,
    Hammer,
    Plus,
} from '@lucide/vue'
import { computed } from 'vue';
import { Button } from '@/components/ui/button';
import {
  Card,
  CardHeader,
  CardTitle,
  CardContent,

} from '@/components/ui/card'
import { dashboard } from '@/routes';


import tickets from '@/routes/tickets';

defineOptions({
    layout: {
        breadcrumbs: [
            {
                title: 'Dashboard',
                href: dashboard(),
            },
        ],
    },
});


interface MonthlyTicket {
    month: string
    total: number
    open: number
    inProgress: number
    completed: number
}


interface DashboardStats {
    totalTickets: number
    openTickets: number
    inProgressTickets: number
    completedTickets: number
}

interface Props {
    title: string
    stats: DashboardStats
    charts: MonthlyTicket[]
}

const props = defineProps<Props>()

const page = usePage();
const user = computed(()=> page.props.auth.user)
</script>

<template>  
    <Head title="Dashboard" />

      <div class="space-y-6 p-6">

        <!-- Header -->
        <div class="flex items-center justify-between">
            <div>
                <h1 class="text-3xl font-bold">{{title}}</h1>
                <p class="text-muted-foreground">
                    Welcome back {{ user.name }}({{ user.role }}),  Here's what's happening today.
                </p>
            </div>

            <Link :href="tickets.create()">
                <Button class="cursor-pointer">
                    <Plus class="mr-2 h-4 w-4" />
                    Create Ticket
                </Button>
            </Link>
        </div>

        <!-- Stats -->
      <div class="grid gap-4 md:grid-cols-2 xl:grid-cols-4">
            <!-- Total Tickets -->
            <Card class="transition-shadow hover:shadow-md">
                <CardHeader class="flex flex-row items-center justify-between space-y-0 pb-2">
                    <CardTitle class="text-sm font-medium">
                        Total Tickets
                    </CardTitle>

                    <Ticket class="h-5 w-5 text-blue-500" />
                </CardHeader>

                <CardContent>
                    <div class="text-3xl font-bold">
                        {{ props.stats.totalTickets }}
                    </div>

                    <p class="mt-1 text-sm text-muted-foreground">
                        All submitted tickets
                    </p>
                </CardContent>
            </Card>

            <!-- Open Tickets -->
            <Card class="transition-shadow hover:shadow-md">
                <CardHeader class="flex flex-row items-center justify-between space-y-0 pb-2">
                    <CardTitle class="text-sm font-medium">
                        Open Tickets
                    </CardTitle>

                    <CircleAlert class="h-5 w-5 text-orange-500" />
                </CardHeader>

                <CardContent>
                    <div class="text-3xl font-bold text-orange-500">
                        {{ props.stats.openTickets }}
                    </div>

                    <p class="mt-1 text-sm text-muted-foreground">
                        Waiting to be assigned
                    </p>
                </CardContent>
            </Card>

            <!-- In Progress -->
            <Card class="transition-shadow hover:shadow-md">
                <CardHeader class="flex flex-row items-center justify-between space-y-0 pb-2">
                    <CardTitle class="text-sm font-medium">
                        In Progress
                    </CardTitle>

                    <Hammer class="h-5 w-5 text-blue-500" />
                </CardHeader>

                <CardContent>
                    <div class="text-3xl font-bold text-blue-500">
                        {{ props.stats.inProgressTickets }}
                    </div>

                    <p class="mt-1 text-sm text-muted-foreground">
                        Currently being repaired
                    </p>
                </CardContent>
            </Card>

            <!-- Completed -->
            <Card class="transition-shadow hover:shadow-md">
                <CardHeader class="flex flex-row items-center justify-between space-y-0 pb-2">
                    <CardTitle class="text-sm font-medium">
                        Completed
                    </CardTitle>

                    <CircleCheckBig class="h-5 w-5 text-green-500" />
                </CardHeader>

                <CardContent>
                    <div class="text-3xl font-bold text-green-500">
                        {{ props.stats.completedTickets }}
                    </div>

                    <p class="mt-1 text-sm text-muted-foreground">
                        Successfully resolved
                    </p>
                </CardContent>
            </Card>
        </div>

        <!-- Middle -->
        <div class="grid gap-4 lg:grid-cols-3">

            <!-- Chart, i should add this as a component-->
            <Card class="lg:col-span-2">
                <CardHeader>
                    <CardTitle>Ticket Activity</CardTitle>
                </CardHeader>

                <CardContent>
                    <div
                        class="flex h-72 items-center justify-center rounded-md border border-dashed"
                    >
                        Chart Placeholder
                    </div>
                </CardContent>
            </Card>

            <!-- Announcements, this also -->
            <Card>
                <CardHeader>
                    <CardTitle>Recent Announcements</CardTitle>
                </CardHeader>

                <CardContent class="space-y-3">
                    <div
                        v-for="i in 3"
                        :key="i"
                        class="flex gap-3"
                    >
                        <div
                            class="h-12 w-12 rounded-md bg-muted"
                        />

                        <div class="flex-1 space-y-2">
                            <div class="h-4 w-3/4 rounded bg-muted" />
                            <div class="h-3 w-1/2 rounded bg-muted" />
                        </div>
                    </div>

                    <Button class="w-full" variant="outline">
                        View All Announcements
                    </Button>
                </CardContent>
            </Card>

        </div>

        <!-- Recent Tickets -->
        <Card>
            <CardHeader>
                <CardTitle>Recent Tickets</CardTitle>
            </CardHeader>

            <CardContent>
                <div
                    class="flex h-72 items-center justify-center rounded-md border border-dashed"
                >
                    {{ completedThisMonth }}
                </div>
            </CardContent>
        </Card>  
    </div>
</template>
