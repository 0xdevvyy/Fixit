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
import ReportDatePicker from "@/components/tickets/ReportDatePicker.vue"
import { router } from "@inertiajs/vue3"
import { computed, ref, watch } from "vue"

interface Props {
    charts: {
        ticketsPerDay: {
            date: string
            total: number
        }[]
    }
    reportPeriod: ReportPeriod
    reportDate: string
}

const props = defineProps<Props>()


const chartData = computed(() =>
    props.charts.ticketsPerDay.map(item => ({
        date: new Date(item.date),
        tickets: item.total,
        sourceDate: item.date,
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

type ReportPeriod = 'monthly' | 'weekly'

function currentMonth() {
    const now = new Date()
    return `${now.getFullYear()}-${String(now.getMonth() + 1).padStart(2, '0')}`
}

function isoWeekKey(dateString: string) {
    const match = /^(\d{4})-(\d{2})-(\d{2})$/.exec(dateString)
    if (!match) {
        return ''
    }

    const [, year, month, day] = match
    const date = new Date(Date.UTC(Number(year), Number(month) - 1, Number(day)))
    const weekday = date.getUTCDay() || 7
    date.setUTCDate(date.getUTCDate() + 4 - weekday)

    const weekYear = date.getUTCFullYear()
    const yearStart = new Date(Date.UTC(weekYear, 0, 1))
    const week = Math.ceil(((date.getTime() - yearStart.getTime()) / 86400000 + 1) / 7)

    return `${weekYear}-W${String(week).padStart(2, '0')}`
}

function currentWeek() {
    const now = new Date()
    const localDate = `${now.getFullYear()}-${String(now.getMonth() + 1).padStart(2, '0')}-${String(now.getDate()).padStart(2, '0')}`
    return isoWeekKey(localDate)
}

const selectedPeriod = ref<ReportPeriod>(props.reportPeriod)
const selectedMonth = ref(props.reportPeriod === 'monthly' ? props.reportDate : currentMonth())
const selectedWeek = ref(props.reportPeriod === 'weekly' ? props.reportDate : currentWeek())
const selectedDate = computed({
    get: () => selectedPeriod.value === 'monthly' ? selectedMonth.value : selectedWeek.value,
    set: (value: string) => {
        if (selectedPeriod.value === 'monthly') {
            selectedMonth.value = value
        } else {
            selectedWeek.value = value
        }
    },
})

const filterRange = computed(() =>
    chartData.value.filter((item) =>
        selectedPeriod.value === 'monthly'
            ? selectedDate.value !== '' && item.sourceDate.startsWith(selectedDate.value)
            : isoWeekKey(item.sourceDate) === selectedDate.value
    )
)

const reportLabel = computed(() => selectedPeriod.value === 'monthly' ? 'month' : 'week')

watch([selectedPeriod, selectedDate], ([period, date]) => {
    if (!date) {
        return
    }

    router.get('/dashboard', {
        reportPeriod: period,
        reportDate: date,
    }, {
        only: ['charts', 'reportPeriod', 'reportDate'],
        preserveScroll: true,
        preserveState: true,
        replace: true,
    })
})

const maxTickets = computed(() =>
  Math.max(...filterRange.value.map(d => d.tickets), 1)
)
</script>

<template>
  <Card class="pt-0">
    <CardHeader class="flex items-center gap-2 space-y-0 border-b py-5 sm:flex-row">
      <div class="grid flex-1 gap-1">
        <CardTitle>Tickets Chart - Fixit</CardTitle>
        <CardDescription>
          Showing total tickets for this {{ reportLabel }}.
        </CardDescription>
      </div>
      <ReportDatePicker
        v-model:period="selectedPeriod"
        v-model:date="selectedDate"
      />
    </CardHeader>
    <CardContent class="px-2 pt-4 sm:px-6 sm:pt-6 pb-4">
        <div
            v-if="filterRange.length === 0"
            class="flex h-[250px] items-center justify-center text-muted-foreground"
        >
            No tickets for this {{ reportLabel }}.
        </div>
      <ChartContainer :config="chartConfig" class="aspect-auto h-[250px] w-full" :cursor="false" v-else>
        <VisXYContainer
          :data="filterRange"
          :svg-defs="svgDefs"
          :margin="{ left: -40 }"
          :y-domain="[0, maxTickets]" 
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
            :num-ticks="filterRange.length"
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
