<script setup lang="ts">
import TicketAfterUpload from '@/components/tickets/TicketAfterUpload.vue';
import TicketBeforeUpload from '@/components/tickets/TicketBeforeUpload.vue';
import TicketInfo from '@/components/tickets/TicketInfo.vue';
import TicketPhotos from '@/components/tickets/TicketPhotos.vue';
// import TicketPhotos from '@/components/tickets/TicketPhotos.vue';
import TicketTimeline from '@/components/tickets/TicketTimeline.vue';
import Button from '@/components/ui/button/Button.vue';
import tickets from '@/routes/tickets';
import { Head, useForm, usePage } from '@inertiajs/vue3';
import { ArrowRight } from '@lucide/vue';
import { computed, ref } from 'vue';

    const props = defineProps<{
        ticket: object
    }>()

    defineOptions({
        layout:{
            breadcrumbs:[
                {
                    title: 'Tickets',
                    href: tickets.index(),
                },
                // {
                //     title: 'Tickets',
                //     href: ticketUrl.url,
                // },

            ]
        }
    })

    const form = useForm({
        before_image: null as File | null, 
        after_image: null as File | null,
    })
    

    const page = usePage();
    const user = computed( () => page.props.auth.user)

    const hasBefore = computed(() => ! !props.ticket.before)
    const hasAfter = computed(() => !! props.ticket.after)

    const canUpload = computed(() =>
        !hasBefore.value || !hasAfter.value
    )


    const imageViewerOpen = ref(false)
    const selectedImage = ref('')

    function openImage(path: string | null) {
        if (!path) return

        selectedImage.value = `/storage/${path}`
        imageViewerOpen.value = true
    }

    function submit() {
        form.post(`/tickets/${props.ticket.id}/attachment`, {
            forceFormData: true,
        })
    }
    
</script>


<template>
    <Head title="Tickets Show" />
    <div class="w-full max-w-7xl mx-auto px-8 py-8">

        <div class="grid gap-6 lg:grid-cols-3">

            <div class="lg:col-span-2 mb-2">
                <TicketInfo
                    :ticket="ticket"
                />
                 
            </div>

            <div>
                <TicketTimeline
                    :ticket="ticket"
                />
            </div>
            
            <!-- <TicketPhotos class="space-y-6  col-span-3" v-show="user.role === 'maintenance'"/> -->
            <div class="space-y-6  col-span-3"  v-if="user.role === 'maintenance' && canUpload">
                <div class="rounded-xl border bg-background p-6 shadow-sm">
                    <div class="mb-6">
                        <h3 class="text-lg font-semibold">
                            Before & After Photos
                        </h3>

                        <p class="text-sm text-muted-foreground">
                            Upload photos showing the maintenance work.
                        </p>
                    </div>

                    <div class="grid items-center gap-6 md:grid-cols-[1fr_auto_1fr]">
                        <TicketBeforeUpload :form="form" v-if="!hasBefore"/>

                        <div class="hidden items-center justify-center md:flex">
                            <div class="flex h-12 w-12 items-center justify-center rounded-full border bg-background shadow-sm">
                                <ArrowRight class="h-5 w-5" />
                            </div>
                        </div>

                        <TicketAfterUpload :form="form" v-if="!hasAfter"/>
                    </div>
                    <div
                        v-if="form.before_image || form.after_image"
                        class="mt-6 flex justify-end"
                        >
                        <Button 
                            :disabled="form.processing"
                            @click="submit"
                            class="cursor-pointer"
                        >
                            Upload Photos
                        </Button>
                    </div>
                </div>
            </div> 

            <!-- <pre>{{ props.ticket}}</pre> -->
             <div class="space-y-6  col-span-3"  v-if="!canUpload">
                <div class="rounded-xl border bg-background p-6 shadow-sm">
                    <div class="mb-6">
                        <h3 class="text-lg font-semibold">
                            Before & After Photos
                        </h3>

                        <p class="text-sm text-muted-foreground">
                            Upload photos showing the maintenance work.
                        </p>
                    </div>

                    <div class="grid items-center gap-6 md:grid-cols-[1fr_auto_1fr]">
                        <!-- <TicketBeforeUpload :form="form" v-if="!hasBefore"/> -->
                          <img
                            :src="`/storage/${ticket.before}`"
                            alt="Before"
                            class="h-64 w-full cursor-pointer rounded-lg border object-cover transition hover:scale-[1.02] hover:shadow-lg"
                            @click="openImage(ticket.before)"
                        />

                        <div class="hidden items-center justify-center md:flex">
                            <div class="flex h-12 w-12 items-center justify-center rounded-full border bg-background shadow-sm">
                                <ArrowRight class="h-5 w-5" />
                            </div>
                        </div>

                        <!-- <TicketAfterUpload :form="form" v-if="!hasAfter"/> -->
                          <img
                            :src="`/storage/${ticket.after}`"
                            alt="after"
                            class="h-64 w-full cursor-pointer rounded-lg border object-cover transition hover:scale-[1.02] hover:shadow-lg"
                            @click="openImage(ticket.after)"
                        />
                    </div>
                   
                </div>
            </div> 
        </div>
    </div>
    <TicketPhotos 
         v-model:open="imageViewerOpen"
        :image="selectedImage"
    />
</template>