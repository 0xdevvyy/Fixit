<script setup lang="ts">
import { CheckCircle2, Circle } from '@lucide/vue';
import { Card, CardContent } from '@/components/ui/card'


defineProps<{
    ticket:any
}>()
</script>

<template>

    <Card>

        <CardContent class="p-6">

            <h3 class="font-semibold mb-6">
            Status Progress
            </h3>

        <div class="space-y-6">

            <div class="flex gap-4">

                <CheckCircle2 class="h-5 w-5 text-green-600"/>

                <div>

                    <p class="font-medium">
                    Ticket Created
                    </p>

                    <p class="text-xs text-muted-foreground">
                    {{ ticket.created_at }}
                    </p>

                </div>

            </div>

            <div class="flex gap-4">

                <CheckCircle2
                v-if="ticket.assigned_at"
                class="h-5 w-5 text-green-600"/>

                <Circle
                v-else
                class="h-5 w-5 text-muted-foreground"/>

                <div>

                    <p class="font-medium">
                    Assigned to Technician
                    </p>

                    <p class="text-xs text-muted-foreground">

                    {{ ticket.assigned_at ?? 'Pending' }}

                    </p>

                </div>

            </div>

            <div class="flex gap-4">

                <CheckCircle2
                v-if="ticket.accepted_at"
                class="h-5 w-5 text-green-600"/>

                <Circle
                v-else
                class="h-5 w-5 text-muted-foreground"/>

                <div>

                    <p class="font-medium">
                        Repair Started
                    </p>

                    <p class="text-xs text-muted-foreground">

                        {{ ticket.accepted_at ?? 'Pending' }}

                    </p>

                </div>

            </div>

            <div class="flex gap-4">

                <CheckCircle2
                v-if="ticket.completed_at"
                class="h-5 w-5 text-green-600"/>

                <Circle
                v-else
                class="h-5 w-5 text-muted-foreground"/>

                <div>

                    <p class="font-medium">
                        Completed
                    </p>

                    <p class="text-xs text-muted-foreground">

                        {{ ticket.completed_at ?? 'Pending' }}

                    </p>

                </div>

            </div>

        </div>

        </CardContent>

    </Card>

</template>