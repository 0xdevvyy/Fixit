<script setup lang="ts">
import { Head, Link } from '@inertiajs/vue3'

import { Plus } from '@lucide/vue'
import Pagination from '@/components/Pagination.vue'
import TicketsFilters from '@/components/tickets/TicketsFilters.vue'
import TicketTable from '@/components/tickets/TicketTable.vue'

import { Button } from '@/components/ui/button'
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
  // created_at?: string
}

interface PaginatedTickets {
  data: Ticket[]
  current_page: number
  last_page: number
  per_page: number
  total: number
  from: number | null
  to: number | null
  first_page_url: string
  last_page_url: string
  next_page_url: string | null
  prev_page_url: string | null
  path: string
  links: {
    url: string | null
    label: string
    active: boolean
  }[]
}

interface Props {
  tickets: PaginatedTickets
}

const props = defineProps<Props>()


</script>

<template>
  <Head title="Tickets" />

  <div class="space-y-6 p-6">
    <div class="flex items-start justify-between">
      <div>
        <h1 class="text-3xl font-bold tracking-tight">
          Tickets
        </h1>

        <p class="text-muted-foreground">
          Manage and track support tickets.
        </p>
      </div>
        <Link :href="ticketsRoute.create()">
          <Button class="cursor-pointer">
              <Plus class="mr-2 h-4 w-4" />
              Create Ticket
          </Button>
        </Link>
      
    </div>
    <!-- <TicketsFilters /> -->

    <TicketTable :tickets="props.tickets.data" />
    <Pagination :links="props.tickets.links" />
  </div>
</template>