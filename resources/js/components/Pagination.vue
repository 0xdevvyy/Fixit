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
  <div class="mt-4 flex items-center justify-center gap-2">
    <template
      v-for="link in links"
      :key="link.label"
    >
      <Link
        v-if="link.url"
        :href="link.url"
        class="rounded-md border px-3 py-2 text-sm"
        :class="{
          'bg-primary text-primary-foreground': link.active,
        }"
      >
        <span v-html="link.label" />
      </Link>

      <span
        v-else
        class="pointer-events-none rounded-md border px-3 py-2 text-sm text-muted-foreground"
      >
        <span v-html="link.label" />
      </span>
    </template>
  </div>
</template>