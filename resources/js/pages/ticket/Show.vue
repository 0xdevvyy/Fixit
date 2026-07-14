<script setup lang="ts">
import { Head, Link, useForm, usePage } from '@inertiajs/vue3';
import { ArrowRight } from '@lucide/vue';
import { computed, ref } from 'vue';
import TicketAfterUpload from '@/components/tickets/TicketAfterUpload.vue';
import TicketBeforeUpload from '@/components/tickets/TicketBeforeUpload.vue';
import TicketInfo from '@/components/tickets/TicketInfo.vue';
import TicketPhotos from '@/components/tickets/TicketPhotos.vue';
import TicketTimeline from '@/components/tickets/TicketTimeline.vue';
import Button from '@/components/ui/button/Button.vue';
import tickets from '@/routes/tickets';
import TicketAcceptDialog from '@/components/tickets/TicketAcceptDialog.vue';


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

    const hasBefore = computed(() => !!props.ticket.before);
    const hasAfter = computed(() => !!props.ticket.after);

    const showBeforeUpload = computed(() =>
        user.value.role === 'maintenance' &&
         props.ticket.status === 'assigned' &&
        !hasBefore.value
    );

    const showAfterUpload = computed(() =>
        user.value.role === 'maintenance' &&
        hasBefore.value && !hasAfter.value
    );

    const showPhotos = computed(() =>
        hasBefore.value && hasAfter.value
    );


    const imageViewerOpen = ref(false)
    const selectedImage = ref('')

    function openImage(path: string | null) {
        if (!path) {
            return
        }

        selectedImage.value = `/storage/${path}`
        imageViewerOpen.value = true
    }

    function submit() {
        form.post(`/tickets/${props.ticket.id}/attachment`, {
            forceFormData: true,
            onSuccess: () => {
                form.reset()
            },
        })
    }

    function acceptTicket() {
        form.post(`/tickets/${props.ticket.id}/accept`)
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
                <div
                    v-if="user.role === 'admin' && ticket.status === 'pending'"
                    class="flex justify-end my-2"
                >
                    <TicketAcceptDialog
                        @accept="acceptTicket"
                    />
                </div>
                
            </div>
            
            
            <!-- <TicketPhotos class="space-y-6  col-span-3" v-show="user.role === 'maintenance'"/> -->
            <!-- Upload Section -->
            <div
                class="space-y-6 col-span-3"
                v-if="showBeforeUpload || showAfterUpload"
            >
                <div class="rounded-xl border bg-background p-6 shadow-sm">
                    <div class="mb-6">
                        <h3 class="text-lg font-semibold">
                            Before & After Photos
                        </h3>

                        <p class="text-sm text-muted-foreground">
                            Upload photos showing the maintenance work.
                        </p>
                    </div>

                    <div :class="[
                        'grid items-center gap-6',
                        showBeforeUpload && !showAfterUpload
                            ? 'md:grid-cols-1'
                            : showAfterUpload
                                ? 'md:grid-cols-1'
                                : 'md:grid-cols-[1fr_auto_1fr]'
                    ]">

                        <!-- BEFORE -->
                        <TicketBeforeUpload
                            v-if="showBeforeUpload"
                            :form="form"
                        />
                       

                        <!-- AFTER -->
                        <TicketAfterUpload
                            v-if="showAfterUpload"
                            :form="form"
                        />
                    </div>

                    <div
                        v-if="form.before_image || form.after_image"
                        class="mt-6 flex justify-end"
                    >
                        <Button
                            class="cursor-pointer"
                            :disabled="form.processing"
                            @click="submit"
                        >
                            Upload Photo
                        </Button>
                    </div>
                </div>
            </div>

            <!-- <pre>{{ props.ticket}}</pre> -->
            <div
                class="space-y-6 col-span-3"
                v-if="showPhotos"
            >
                <div class="rounded-xl border bg-background p-6 shadow-sm">
                    <div class="mb-6">
                        <h3 class="text-lg font-semibold">
                            Before & After Photos
                        </h3>

                        <p class="text-sm text-muted-foreground">
                            Uploaded maintenance photos.
                        </p>
                    </div>

                    <div class="grid items-center gap-6 md:grid-cols-[1fr_auto_1fr]">

                        <!-- Before -->
                        <div>
                            <h4 class="mb-2 text-sm font-semibold text-center text-muted-foreground">
                                Before
                            </h4>

                            <img
                                :src="`/storage/${ticket.before}`"
                                alt="Before"
                                class="h-64 w-full cursor-pointer rounded-lg border object-cover transition hover:scale-[1.02] hover:shadow-lg"
                                @click="openImage(ticket.before)"
                            />
                        </div>

                        <!-- Arrow -->
                        <div class="hidden items-center justify-center md:flex">
                            <div
                                class="flex h-12 w-12 items-center justify-center rounded-full border bg-background shadow-sm"
                            >
                                <ArrowRight class="h-5 w-5" />
                            </div>
                        </div>

                        <!-- After -->
                        <div>
                            <h4 class="mb-2 text-sm font-semibold text-center text-muted-foreground">
                                After
                            </h4>

                            <img
                                :src="`/storage/${ticket.after}`"
                                alt="After"
                                class="h-64 w-full cursor-pointer rounded-lg border object-cover transition hover:scale-[1.02] hover:shadow-lg"
                                @click="openImage(ticket.after)"
                            />
                        </div>

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