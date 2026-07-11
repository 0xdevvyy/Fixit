<script setup lang="ts">
import { computed, ref } from 'vue'
import { Upload, X } from '@lucide/vue'
import { Button } from '@/components/ui/button'

const props = defineProps<{
    form: any
}>()

const fileInput = ref<HTMLInputElement | null>(null)

const preview = computed(() => {
    return props.form.before_image
        ? URL.createObjectURL(props.form.before_image)
        : null
})

function uploadImage(event: Event) {
    const target = event.target as HTMLInputElement

    if (!target.files?.length) return

    props.form.before_image = target.files[0]
}

function removeImage() {
    props.form.before_image = null

    if (fileInput.value) {
        fileInput.value.value = ''
    }
}
</script>

<template>

    <div>

        <p class="mb-2 text-sm font-medium">
            Before
        </p>

        <input
            ref="fileInput"
            type="file"
            accept="image/*"
            class="hidden"
            @change="uploadImage"
        >

        <div
            class="relative flex aspect-video cursor-pointer items-center justify-center rounded-lg border-2 border-dashed transition hover:bg-muted/50"
            @click="fileInput?.click()"
        >

            <template v-if="preview">

                <img
                    :src="preview"
                    class="h-full w-full rounded-lg object-cover"
                >

                <Button
                    size="icon"
                    variant="destructive"
                    class="absolute right-2 top-2 h-8 w-8"
                    @click.stop="removeImage"
                >
                    <X class="h-4 w-4" />
                </Button>

            </template>

            <template v-else>

                <div class="text-center">

                    <Upload class="mx-auto mb-3 h-8 w-8 text-muted-foreground" />

                    <p class="font-medium">
                        Upload Before Photo
                    </p>

                    <p class="text-xs text-muted-foreground">
                        Click or drag an image here
                    </p>

                </div>

            </template>

        </div>

    </div>

</template>