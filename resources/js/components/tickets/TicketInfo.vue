<script setup lang="ts">
import { Card, CardContent } from '@/components/ui/card'
import TicketPriorityBadge from './TicketPriorityBadge.vue';
import TicketBadge from './TicketBadge.vue';


defineProps<{
    ticket:any
}>()
</script>

<template>

<Card>

    <CardContent class="space-y-6 p-6">

    <div>

    <h1 class="text-3xl font-bold">
        {{ ticket.title }}
    </h1>

    <hr class="border-2 mt-1">

    <div class="mt-3 flex gap-2">

    <TicketPriorityBadge
        :priority="ticket.priority"
    />

    <TicketBadge
        :status="ticket.status"
    />

    </div>

    </div>

    <div class="grid grid-cols-2 gap-y-5">

    <div>
        <p class="text-sm text-muted-foreground">
            Reported By
        </p>

        <p class="font-medium">
            {{ ticket.assigned_to }}
        </p>
    </div>

    <div>
        <p class="text-sm text-muted-foreground">
            Location
        </p>

        <p class="font-medium">
            {{ ticket.building }}
            {{ ticket.room }}
        </p>
    </div>

    <div>
        <p class="text-sm text-muted-foreground">
            Category
        </p>

        <p class="font-medium">
            {{ ticket.category }}
        </p>
    </div>

    <div>
        <p class="text-sm text-muted-foreground">
            Date Reported
        </p>

        <p class="font-medium">
            {{ ticket.created_at }}
        </p>
    </div>

    </div>

    <div>

    <p class="mb-2 text-sm text-muted-foreground">
    Description
    </p>

    <div class="rounded-md border bg-muted p-4">

    {{ ticket.description }}

    </div>

    </div>

    </CardContent>

</Card>

</template>