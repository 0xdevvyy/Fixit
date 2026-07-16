<script setup lang="ts">
import type {
  ChartConfig,
} from "@/components/ui/chart"

import { TrendingUp } from "@lucide/vue"
import { Donut } from "@unovis/ts"
import { VisDonut, VisSingleContainer } from "@unovis/vue"
import {
  Card,
  CardContent,
  CardDescription,
  CardFooter,
  CardHeader,
  CardTitle,
} from "@/components/ui/card"
import {
  ChartContainer,
  ChartTooltip,
  ChartTooltipContent,
  componentToString,
} from "@/components/ui/chart"
import { computed } from "vue"

interface Props {
    statusBreakdown: {
        open: number
        in_progress: number
        completed: number
    }
}

const props = defineProps<Props>()

const chartData = computed(() => [
    {
        key: "open",
        status: "Open",
        tickets: props.statusBreakdown.open,
    },
    {
        key: "in_progress",
        status: "In Progress",
        tickets: props.statusBreakdown.in_progress,
    },
    {
        key: "completed",
        status: "Completed",
        tickets: props.statusBreakdown.completed,
    },
])

type Data = (typeof chartData.value)[number]

const chartConfig = {
    tickets: {
        label: "Tickets",
    },

    open: {
        label: "Open",
        color: "var(--chart-1)",
    },

    in_progress: {
        label: "In Progress",
        color: "var(--chart-2)",
    },

    completed: {
        label: "Completed",
        color: "var(--chart-3)",
    },
} satisfies ChartConfig
</script>

<template>
  <Card class="flex flex-col">
    <CardHeader class="items-center pb-0">
      <CardTitle>Tickets Pie Chart</CardTitle>
      <CardDescription>For this month</CardDescription>
    </CardHeader>
    <CardContent class="flex-1 pb-0">
      <ChartContainer
        :config="chartConfig"
        class="mx-auto aspect-square max-h-[250px]"
      >
        <VisSingleContainer
          :data="chartData"
          :margin="{ top: 30, bottom: 30 }"
        >
          <VisDonut
                :value="(d: Data) => d.tickets"
                :color="(d: Data) => chartConfig[d.key as keyof typeof chartConfig].color"
                :arc-width="30"
            />
          <ChartTooltip
                :triggers="{
                    [Donut.selectors.segment]:
                        componentToString(chartConfig, ChartTooltipContent, {
                            nameKey: 'status',
                            hideLabel: true,
                        })!,
                }"
            />
        </VisSingleContainer>
      </ChartContainer>
    </CardContent>
    <CardFooter class="flex-col gap-2 text-sm">

      <div class="leading-none text-muted-foreground">
        Showing Tickets Status Beakdown for the month
      </div>
    </CardFooter>
  </Card>
</template>
