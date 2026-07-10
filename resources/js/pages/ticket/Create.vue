<script setup lang="ts">
import { Head, useForm } from '@inertiajs/vue3';
import TicketForm from '@/components/tickets/TicketForm.vue';
import Button from '@/components/ui/button/Button.vue';
import { CardContent } from '@/components/ui/card';
import Card from '@/components/ui/card/Card.vue';
import CardHeader from '@/components/ui/card/CardHeader.vue';
import CardTitle from '@/components/ui/card/CardTitle.vue';
import tickets from '@/routes/tickets';

    defineOptions({
        layout: {
            breadcrumbs:[
                {
                    title: 'Tickets',
                    href: tickets.index(),
                },
                {
                    title: 'Create Ticket',
                    href: tickets.create(),
                }
            ]
        }
    })

    const props = defineProps<{
        categories: any[]
        users: any[]
        buildings: any[]
        status: any[]
        priority: any[]
    }>()

    const form = useForm({
        'title': '',
        'assigned_to': null,
        'building_id': null, 
        'description': '',
        'room' : '',
        'category': '',
        'priority': '',
        'status': ''
    })

    const submit = () => {
        form.post('/tickets/store')
    }
</script>

<template>
    <Head title="Create Ticket" />

  <div class="container mx-auto p-6">

        <div class="mb-8">
            <h1 class="text-3xl font-bold tracking-tight">
                Create Ticket
            </h1>

            <p class="text-muted-foreground mt-2">
                Submit a new support ticket for maintenance or technical issues.
            </p>
        </div>

        <div class="grid gap-6 lg:grid-cols-4">

            <!-- Left -->

            <form
                class="lg:col-span-3"
                @submit.prevent="submit"
            >
                <Card class="p-6">
                    <CardHeader>
                        <CardTitle class="text-lg font-semibold">
                            Ticket Information
                        </CardTitle>

                        <p class="text-sm text-muted-foreground">
                            Fill in the details below to create a new support ticket.
                        </p>
                    </CardHeader>
                    <CardContent>
                    <TicketForm
                        :form="form"
                        :categories="props.categories"
                        :users="props.users"
                        :buildings="props.buildings"
                        :statuses="props.status"
                        :priorities="props.priority"
                    />
                    <div class="flex justify-end mt-6">
                        <Button type="submit" :disabled="form.processing" class="cursor-pointer">
                            Create Ticket
                        </Button>
                    </div>
                    </CardContent>
                </Card>
            </form>

            <!-- Right Sidebar -->

            <div class="space-y-6">
                <!-- Ticket Preview -->
                <Card class="sticky top-6 overflow-hidden rounded-xl border shadow-sm">

                    <!-- Header -->
                    <div class="bg-muted/40 border-b px-6 py-5">
                        <h3 class="text-lg font-semibold">Ticket Preview</h3>
                        <p class="text-sm text-muted-foreground">
                            Review your ticket information before submitting.
                        </p>
                    </div>

                    <CardContent class="p-6 space-y-6">

                        <!-- Title -->
                        <div class="space-y-2">
                            <p class="text-xs font-medium uppercase tracking-wider text-muted-foreground">
                                Title
                            </p>

                            <div class="rounded-lg border bg-muted/30 p-3 min-h-14 flex items-center">
                                <p class="font-medium break-words">
                                    {{ form.title || 'No title provided' }}
                                </p>
                            </div>
                        </div>

                        <!-- Details -->
                        <div class="grid gap-4">

                            <!-- Category -->
                            <div class="flex items-center justify-between rounded-lg border p-3">
                                <span class="text-sm text-muted-foreground">
                                    Category
                                </span>

                                <span
                                    class="rounded-full bg-primary/10 px-3 py-1 text-xs font-semibold text-primary"
                                >
                                    {{ form.category || 'Not selected' }}
                                </span>
                            </div>

                            <!-- Priority -->
                            <div class="flex items-center justify-between rounded-lg border p-3">
                                <span class="text-sm text-muted-foreground">
                                    Priority
                                </span>

                                <span
                                    class="rounded-full bg-amber-100 px-3 py-1 text-xs font-semibold text-amber-700 dark:bg-amber-500/20 dark:text-amber-300"
                                >
                                    {{ form.priority || 'Not selected' }}
                                </span>
                            </div>

                            <!-- Building -->
                            <div class="flex items-center justify-between rounded-lg border p-3">
                                <span class="text-sm text-muted-foreground">
                                    Building
                                </span>

                                <span class="font-medium">
                                    {{ form.building_id || 'Not selected' }}
                                </span>
                            </div>

                        </div>

                        <!-- Summary -->
                        <div class="rounded-lg border bg-muted/30 p-4 space-y-2">
                            <p class="text-sm font-semibold">
                                Summary
                            </p>

                            <p class="text-sm text-muted-foreground leading-relaxed">
                                {{
                                    form.title
                                        ? `Your ${form.priority || 'standard'} priority ticket for ${
                                            form.category || 'an issue'
                                        } will be submitted${
                                            form.building_id ? ` in ${form.building_id}` : ''
                                        }.`
                                        : 'Start filling out the form to see a live summary of your ticket.'
                                }}
                            </p>
                        </div>

                    </CardContent>

                </Card>
            </div>

        </div>

    </div>
</template>