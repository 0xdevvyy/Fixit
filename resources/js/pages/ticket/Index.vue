<script setup lang="ts">
import { Head } from '@inertiajs/vue3'

import TicketTable from '@/components/tickets/TicketTable.vue'
import ticketsRoute from '@/routes/tickets'

defineOptions({
  layout: {
    breadcrumbs: [
      {
        title: 'Tickets',
        href: ticketsRoute.index(),
      },
      
    ],
  },
})

interface Ticket {
  id: number
  ticket_number: string
  title: string
  description: string
  category: string
  priority: string
  status: string
  assigned_to: string | null
  reporter: string
  room: string
//   created_at?: string should i add it?
}

interface Props{
    tickets: Ticket[]
}

const props = defineProps<Props>()


</script>

<template>
  <Head title="Tickets" />

  <div class="space-y-6 p-6">
    <div>
      <h1 class="text-3xl font-bold tracking-tight">
        Tickets
      </h1>

      <p class="text-muted-foreground">
        Manage and track support tickets.
      </p>
    </div>

    <TicketTable :tickets="tickets" />
  </div>
</template>