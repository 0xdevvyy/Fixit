<script setup lang="ts">
import type { ChartConfig } from "@/components/ui/chart"

// import { Area, AreaChart, CartesianGrid, XAxis, YAxis } from "recharts"
import { VisArea, VisAxis, VisLine, VisXYContainer } from "@unovis/vue"
import {
  Card,
  CardContent,
  CardDescription,
  CardHeader,
  CardTitle,
} from "@/components/ui/card"
import {

  ChartContainer,
  ChartCrosshair,
  ChartLegendContent,
  ChartTooltip,
  ChartTooltipContent,
  componentToString,
} from "@/components/ui/chart"
import {
  Select,
  SelectContent,
  SelectItem,
  SelectTrigger,
  SelectValue,
} from "@/components/ui/select"
import { computed, ref } from "vue"

interface Props {
    charts: {
        ticketsPerDay: {
            date: string
            total: number
        }[]
    }
}

const props = defineProps<Props>()


const chartData = computed(() =>
    props.charts.ticketsPerDay.map(item => ({
        date: new Date(item.date),
        tickets: item.total,
    }))
)
type Data = typeof chartData[number]

const chartConfig = {
  tickets: {
    label: "Tickets",
    color: "var(--chart-1)",
  },
} satisfies ChartConfig
const svgDefs = `
  <linearGradient id="fillTickets" x1="0" y1="0" x2="0" y2="1">
    <stop offset="5%" stop-color="var(--color-tickets)" stop-opacity="0.8" />
    <stop offset="95%" stop-color="var(--color-tickets)" stop-opacity="0.1" />
  </linearGradient>
`

const selectedMonth = ref(new Date().getMonth().toString())
const filterRange = computed(() => {
    return chartData.value.filter((item) => {
        const date = new Date(item.date)

        return (
            date.getMonth() === Number(selectedMonth.value) &&
            date.getFullYear() === new Date().getFullYear()
        )
    })
})
</script>

<template>
  <Card class="pt-0">
    <CardHeader class="flex items-center gap-2 space-y-0 border-b py-5 sm:flex-row">
      <div class="grid flex-1 gap-1">
        <CardTitle>Tickets Chart - Fixit</CardTitle>
        <CardDescription>
          Showing total Tickets for this month
        </CardDescription>
      </div>
      
    <Select v-model="selectedMonth">
        <SelectTrigger
            class="hidden w-[180px] rounded-lg sm:ml-auto sm:flex"
            aria-label="Select month"
        >
            <SelectValue placeholder="Select Month" />
        </SelectTrigger>

        <SelectContent class="rounded-xl">
            <SelectItem value="0" class="rounded-lg">
            January
            </SelectItem>
            <SelectItem value="1" class="rounded-lg">
            February
            </SelectItem>
            <SelectItem value="2" class="rounded-lg">
            March
            </SelectItem>
            <SelectItem value="3" class="rounded-lg">
            April
            </SelectItem>
            <SelectItem value="4" class="rounded-lg">
            May
            </SelectItem>
            <SelectItem value="5" class="rounded-lg">
            June
            </SelectItem>
            <SelectItem value="6" class="rounded-lg">
            July
            </SelectItem>
            <SelectItem value="7" class="rounded-lg">
            August
            </SelectItem>
            <SelectItem value="8" class="rounded-lg">
            September
            </SelectItem>
            <SelectItem value="9" class="rounded-lg">
            October
            </SelectItem>
            <SelectItem value="10" class="rounded-lg">
            November
            </SelectItem>
            <SelectItem value="11" class="rounded-lg">
            December
            </SelectItem>
        </SelectContent>
    </Select>
    </CardHeader>
    <CardContent class="px-2 pt-4 sm:px-6 sm:pt-6 pb-4">
        <div
            v-if="filterRange.length === 0"
            class="flex h-[250px] items-center justify-center text-muted-foreground"
        >
            No tickets for this month.
        </div>
      <ChartContainer :config="chartConfig" class="aspect-auto h-[250px] w-full" :cursor="false" v-else>
        <VisXYContainer
          :data="filterRange"
          :svg-defs="svgDefs"
          :margin="{ left: -40 }"
          :y-domain="[0, 100]" 
        >
          <VisArea 
                :x="(d: Data) => d.date"
                :y="(d: Data) => d.tickets"
                color="url(#fillTickets)"
                :opacity="0.6"
            />
          <VisLine
                :x="(d: Data) => d.date"
                :y="(d: Data) => d.tickets"
                :color="chartConfig.tickets.color"
                :line-width="2"
            />
          <VisAxis
            type="x"
            :x="(d: Data) => d.date"
            :tick-line="false"
            :domain-line="false"
            :grid-line="false"
            :num-ticks="6"
            :tick-format="(d: number, index: number) => {
              const date = new Date(d)
              return date.toLocaleDateString('en-US', {
                month: 'short',
                day: 'numeric',
              })
            }"
          />
          <VisAxis
            type="y"
            :num-ticks="3"
            :tick-line="false"
            :domain-line="false"
          />
          <ChartTooltip />
         <ChartCrosshair
            :color="() => chartConfig.tickets.color"
            :template="componentToString(
                chartConfig,
                ChartTooltipContent,
                {
                    indicator: 'line',
                    labelFormatter: (value) =>
                        new Date(value).toLocaleDateString('en-US', {
                            month: 'short',
                            day: 'numeric',
                            year: 'numeric'
                        }),
                }
            )"
        />
        </VisXYContainer>

        <ChartLegendContent />
      </ChartContainer>
    </CardContent>
  </Card>
</template>
