<script setup lang="ts">
import { Head, Link, router } from '@inertiajs/vue3'

import { Filter, Plus } from '@lucide/vue'
import Pagination from '@/components/Pagination.vue'
import TicketsFilters from '@/components/tickets/TicketsFilters.vue'
import TicketTable from '@/components/tickets/TicketTable.vue'

import { Button } from '@/components/ui/button'
import ticketsRoute from '@/routes/tickets'
import { reactive, ref, watch } from 'vue'
import TicketStatus from '@/components/tickets/filters/TicketStatus.vue'


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
  links: {
    first: string | null
    last: string | null
    prev: string | null
    next: string | null
  }
  meta: {
    current_page: number
    last_page: number
    per_page: number
    total: number
    links: {
      url: string | null
      label: string
      active: boolean
    }[]
  }
}



interface Options {
  category: string[]
  priority: string[]
  status: string[]
}

interface TicketFilters {
  search: string
  status: string | null
  priority: string | null
  category: string | null
}

interface Props {
  tickets: PaginatedTickets
  filtersOption:  Options,
  filters: TicketFilters,
}

const props = defineProps<Props>()

const query = reactive<TicketFilters>({
  search: props.filters.search,
  status: props.filters.status,
  priority: props.filters.priority,
  category: props.filters.category,
})

function filterTickets() {
    router.get('/tickets', {
        search: query.search,
        status: query.status,
        priority: query.priority,
        category: query.category,

    }, {
        preserveState: true,
        preserveScroll: true,
        replace: true,
    })
}

watch(() => query.search, () => {
  filterTickets()
})


</script>

<template>
  <Head title="Tickets" />
  

  <div class="space-y-6 p-6">
    <div class="flex items-start justify-between">
      <div>
        <h1 class="text-3xl font-bold tracking-tight">
          Tickets
        </h1>
        <!-- <pre>{{ props.filtersOption }}</pre> -->

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
    <div class="flex flex-wrap gap-3">
      <TicketsFilters v-model="query.search"/>
      <TicketStatus :options="props.filtersOption.status" v-model="query.status" />
      <Button class="cursor-pointer" @click="filterTickets">
        <Filter />
        Filter
      </Button>
    </div>

    <TicketTable :tickets="props.tickets.data" />
    <Pagination :links="props.tickets.meta.links" />
  </div>
</template>