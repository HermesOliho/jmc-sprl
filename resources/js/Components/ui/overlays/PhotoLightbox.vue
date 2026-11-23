<script setup lang="ts">
import { computed, nextTick, onBeforeUnmount, ref, watch } from 'vue'
import Icon from '@/Components/ui/icons/Icon.vue'
import type { AlbumPhoto } from '@/types'

const props = withDefaults(defineProps<{
    photos: AlbumPhoto[]
    open: boolean
    startIndex?: number
}>(), {
    startIndex: 0,
})

const emit = defineEmits<{
    close: []
}>()

const dialog = ref<HTMLElement | null>(null)
const closeButton = ref<HTMLButtonElement | null>(null)
const currentIndex = ref(0)
const previousFocus = ref<HTMLElement | null>(null)
const previousOverflow = ref('')

const photo = computed<AlbumPhoto | null>(
    () => props.photos[currentIndex.value] ?? null,
)

const hasMultiple = computed<boolean>(() => props.photos.length > 1)

function close(): void {
    emit('close')
}

function showPrevious(): void {
    if (!hasMultiple.value) {
        return
    }

    currentIndex.value = (currentIndex.value - 1 + props.photos.length) % props.photos.length
}

function showNext(): void {
    if (!hasMultiple.value) {
        return
    }

    currentIndex.value = (currentIndex.value + 1) % props.photos.length
}

function handleKeydown(event: KeyboardEvent): void {
    if (!props.open) {
        return
    }

    if (event.key === 'Escape') {
        event.preventDefault()
        close()

        return
    }

    if (event.key === 'ArrowLeft') {
        event.preventDefault()
        showPrevious()
    }

    if (event.key === 'ArrowRight') {
        event.preventDefault()
        showNext()
    }

    if (event.key !== 'Tab' || !dialog.value) {
        return
    }

    const focusable = Array.from(
        dialog.value.querySelectorAll<HTMLElement>(
            'button:not([disabled]), [href], [tabindex]:not([tabindex="-1"])',
        ),
    )

    if (focusable.length === 0) {
        return
    }

    const first = focusable[0]
    const last = focusable[focusable.length - 1]
    const active = document.activeElement

    if (event.shiftKey && active === first) {
        event.preventDefault()
        last.focus()
    } else if (!event.shiftKey && active === last) {
        event.preventDefault()
        first.focus()
    }
}

function release(): void {
    if (typeof document === 'undefined') {
        return
    }

    document.removeEventListener('keydown', handleKeydown)
    document.body.style.overflow = previousOverflow.value
    previousFocus.value?.focus()
}

watch(
    () => props.open,
    async (open) => {
        if (typeof document === 'undefined') {
            return
        }

        if (open) {
            previousFocus.value = document.activeElement as HTMLElement | null
            previousOverflow.value = document.body.style.overflow
            currentIndex.value = Math.min(
                Math.max(props.startIndex, 0),
                Math.max(props.photos.length - 1, 0),
            )
            document.body.style.overflow = 'hidden'
            document.addEventListener('keydown', handleKeydown)

            await nextTick()
            closeButton.value?.focus()
        } else {
            release()
        }
    },
)

onBeforeUnmount(() => {
    release()
})
</script>

<template>
    <Teleport to="body">
        <Transition name="lightbox">
            <div
                v-if="open && photo"
                ref="dialog"
                class="fixed inset-0 z-[60] flex flex-col text-white"
                role="dialog"
                aria-modal="true"
                aria-label="Visionneuse photo"
            >
                <div
                    class="absolute inset-0 bg-black/95"
                    @click="close"
                />

                <div class="relative flex items-center justify-between gap-4 px-4 py-3 md:px-6">
                    <span class="text-sm font-medium text-white/70">
                        {{ currentIndex + 1 }} / {{ photos.length }}
                    </span>

                    <button
                        ref="closeButton"
                        type="button"
                        class="rounded-full p-2.5 text-white/80 transition hover:bg-white/10 hover:text-white focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-white"
                        aria-label="Fermer la visionneuse"
                        @click="close"
                    >
                        <Icon name="x" :size="22" />
                    </button>
                </div>

                <div class="relative flex min-h-0 flex-1 items-center justify-center px-4 pb-4 md:px-20">
                    <img
                        :key="photo.id"
                        :src="photo.large_url || photo.card_url || ''"
                        :alt="photo.alt"
                        class="max-h-full max-w-full rounded-lg object-contain shadow-2xl"
                        loading="eager"
                        decoding="async"
                    />

                    <template v-if="hasMultiple">
                        <button
                            type="button"
                            class="absolute top-1/2 left-3 -translate-y-1/2 rounded-full bg-white/10 p-3 text-white backdrop-blur-sm transition hover:bg-white/20 focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-white md:left-6"
                            aria-label="Photo précédente"
                            @click="showPrevious"
                        >
                            <Icon name="chevron-left" :size="24" />
                        </button>

                        <button
                            type="button"
                            class="absolute top-1/2 right-3 -translate-y-1/2 rounded-full bg-white/10 p-3 text-white backdrop-blur-sm transition hover:bg-white/20 focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-white md:right-6"
                            aria-label="Photo suivante"
                            @click="showNext"
                        >
                            <Icon name="chevron-right" :size="24" />
                        </button>
                    </template>
                </div>

                <div class="relative px-6 pb-6 text-center">
                    <p v-if="photo.caption" class="mx-auto max-w-3xl text-base font-medium text-white">
                        {{ photo.caption }}
                    </p>
                    <p class="mx-auto mt-1 max-w-3xl text-sm text-white/60">
                        {{ photo.alt }}
                    </p>
                </div>
            </div>
        </Transition>
    </Teleport>
</template>

<style scoped>
.lightbox-enter-active,
.lightbox-leave-active {
    transition: opacity 0.2s ease;
}

.lightbox-enter-from,
.lightbox-leave-to {
    opacity: 0;
}
</style>
