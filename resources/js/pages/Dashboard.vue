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
import TicketCharts from '@/components/tickets/TicketCharts.vue';
import TicketStatusChart from '@/components/tickets/TicketStatusChart.vue';

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


interface TicketPerDay {
    date: string
    total: number
}

interface StatusBreakdown {
    open: number
    in_progress: number
    completed: number
}

interface TicketsByBuilding {
    name: string
    total: number
}

interface DashboardCharts {
    ticketsPerDay: TicketPerDay[]
    statusBreakdown: StatusBreakdown
    ticketsByBuilding: TicketsByBuilding[]
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
    charts: DashboardCharts
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
                    <TicketCharts :charts="props.charts"/>
                </CardContent>
            </Card>
            <!--Tickets Chart -->            
            <TicketStatusChart  :status-breakdown="props.charts.statusBreakdown" />
        </div>
    </div>
</template>
