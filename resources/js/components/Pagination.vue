<script setup lang="ts">
import { Link } from '@inertiajs/vue3'

interface PaginationLink {
  url: string | null
  label: string
  active: boolean
}

defineProps<{
  links: PaginationLink[]
}>()
</script>

<template>
  <div class="flex items-center justify-center gap-2 mt-4">
    <Component
      :is="link.url ? Link : 'span'"
      v-for="link in links"
      :key="link.label"
      :href="link.url ?? ''"
      v-html="link.label"
      class="rounded-md border px-3 py-2 text-sm"
      :class="{
        'pointer-events-none text-muted-foreground': !link.url,
        'bg-primary text-primary-foreground': link.active,
      }"
    />
  </div>
</template>