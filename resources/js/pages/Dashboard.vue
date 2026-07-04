<script setup lang="ts">
import { Head, usePage } from '@inertiajs/vue3';
import PlaceholderPattern from '@/components/PlaceholderPattern.vue';
import { dashboard } from '@/routes';
import {
  Card,
  CardHeader,
  CardTitle,
  CardDescription,
  CardContent,
  CardFooter,
} from '@/components/ui/card'

import {
    Ticket,
    CircleCheckBig,
    CircleAlert,
    Hammer,
} from '@lucide/vue'

import { Button } from '@/components/ui/button';
import { computed } from 'vue';

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
interface Props {
    totalTickets: number
    openTickets: number
    inProgressTickets: number
    completedTickets: number
    title: string
    completedThisMonth: number
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

            <Button class="cursor-pointer">
                + New Ticket
            </Button>
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
                        {{ totalTickets }}
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
                        {{ openTickets }}
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
                        {{ inProgressTickets }}
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
                        {{ completedTickets }}
                    </div>

                    <p class="mt-1 text-sm text-muted-foreground">
                        Successfully resolved
                    </p>
                </CardContent>
            </Card>
        </div>

        <!-- Middle -->
        <div class="grid gap-4 lg:grid-cols-3">

            <!-- Chart -->
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

            <!-- Announcements -->
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
