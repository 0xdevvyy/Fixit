<script setup lang="ts">
import TicketInfo from '@/components/tickets/TicketInfo.vue';
import TicketTimeline from '@/components/tickets/TicketTimeline.vue';
import tickets from '@/routes/tickets';
import { Head } from '@inertiajs/vue3';

    const props = defineProps<{
        ticket: object
    }>()

    defineOptions({
        layout:{
            breadcrumbs:[
                {
                    title: 'Tickets',
                    href: tickets.index(),
                },
                // {
                //     title: 'Tickets',
                //     href: tickets.show(),
                // },

            ]
        }
    })


    
</script>


<template>
    <Head title="Tickets Show" />
    <div class="w-full max-w-7xl mx-auto px-8 py-8">

        <div class="grid gap-6 lg:grid-cols-3">

            <div class="lg:col-span-2">
                <TicketInfo
                    :ticket="ticket"
                />
            </div>

            <div>
                <TicketTimeline
                    :ticket="ticket"
                />
            </div>

            <!-- <pre>{{ props.ticket }}</pre> -->

        </div>

    </div>
</template>