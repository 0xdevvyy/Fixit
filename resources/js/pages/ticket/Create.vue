<script setup lang="ts">
import TicketForm from '@/components/tickets/TicketForm.vue';
import tickets from '@/routes/tickets';
import { useForm } from '@inertiajs/vue3';

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

    const form = useForm({
        'title': '',
        'assigned_to': null,
        'building': null, 
        'description': '',
        'room' : '',
        'category': '',
        'priority': '',
        'status': ''
    })
</script>

<template>
    //when choosing a building number it will fill the assigned to dropdown
    //will do this tommorow
    <TicketForm />
</template>