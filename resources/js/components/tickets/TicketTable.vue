<script setup lang="ts">
import { Badge } from '@/components/ui/badge'
import { Button } from '@/components/ui/button'
import { Card, CardContent } from '@/components/ui/card'
import { Checkbox } from '@/components/ui/checkbox'

import {
  DropdownMenu,
  DropdownMenuContent,
  DropdownMenuItem,
  DropdownMenuTrigger,
} from '@/components/ui/dropdown-menu'

import {
  Table,
  TableBody,
  TableCell,
  TableHead,
  TableHeader,
  TableRow,
} from '@/components/ui/table'
import { Eye, MoreHorizontal, Pencil, Trash2 } from '@lucide/vue'


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
//   created_at?: string 
}

interface Props{
    tickets: Ticket[]
}

const props = defineProps<Props>()


const priorityVariant = (priority: string) => {
  switch (priority.toLowerCase()) {
    case 'low':
      return 'secondary'

    case 'medium':
      return 'default'

    case 'high':
      return 'destructive'

    default:
      return 'outline'
  }
}

const statusVariant = (status: string) => {
  switch (status.toLowerCase()) {
    case 'open':
      return 'secondary'

    case 'in_progress':
      return 'default'

    case 'completed':
      return 'outline'

    default:
      return 'outline'
  }
}
</script>

<template>
  <Card>
    <CardContent>
      <Table>
        <TableHeader class="bg-muted w-10">
          <TableRow >

            <TableHead>Ticket #</TableHead>
            <TableHead>Title</TableHead>
            <TableHead>Category</TableHead>
            <TableHead>Room</TableHead>
            <TableHead>Priority</TableHead>
            <TableHead>Status</TableHead>
            <TableHead>Assigned To</TableHead>
            <TableHead>Reported By</TableHead>
            <TableHead class="text-center">Action</TableHead>
          </TableRow>
        </TableHeader>

        <TableBody>
          <TableRow
            v-for="ticket in tickets"
            :key="ticket.id"
          >

            <TableCell class="font-medium">
              {{ ticket.ticket_number }}
            </TableCell>

            <TableCell>
              {{ ticket.title }}
            </TableCell>

            <TableCell class="capitalize">
              {{ ticket.category }}
            </TableCell>

            <TableCell>
              {{ ticket.room }}
            </TableCell>

            <TableCell>
              <Badge :variant="priorityVariant(ticket.priority)">
                {{ ticket.priority }}
              </Badge>
            </TableCell>

            <TableCell>
              <Badge :variant="statusVariant(ticket.status)">
                {{ ticket.status.replace('_', ' ') }}
              </Badge>
            </TableCell>

            <TableCell>
              {{ ticket.assigned_to ?? 'Unassigned' }}
            </TableCell>

            <TableCell>
              {{ ticket.reporter }}
            </TableCell>

            <!-- should add links -->
            <TableCell>
                <div class="flex items-center justify-center gap-2 ">
                    <Button
                        variant="outline"
                        size="sm"
                        class="cursor-pointer"
                        >
                        <Eye class="mr-2 h-4 w-4" />
                        View
                    </Button>

                    <Button
                        variant="secondary"
                        size="sm"
                        class="cursor-pointer"
                        >
                        <Pencil class="mr-2 h-4 w-4" />
                        Edit
                    </Button>

                    <Button
                        variant="destructive"
                        size="sm"
                        class="cursor-pointer"
                        >
                        <Trash2 class="mr-2 h-4 w-4" />
                        Delete
                    </Button>
                </div>

            </TableCell>
          </TableRow>

          <TableRow v-if="tickets.length === 0">
            <TableCell
              colspan="10"
              class="h-24 text-center text-muted-foreground"
            >
              No tickets found.
            </TableCell>
          </TableRow>
        </TableBody>
      </Table>
    </CardContent>
  </Card>
</template>