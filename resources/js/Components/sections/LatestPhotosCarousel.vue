<script setup lang="ts">
import { computed, onBeforeUnmount, onMounted, ref, watch } from 'vue'
import { Link } from '@inertiajs/vue3'
import Section from '@/Components/sections/Section.vue'
import Icon from '@/Components/ui/icons/Icon.vue'
import { formatDate, shouldReduceMotion } from '@/utils'
import type { LatestAlbumPhoto } from '@/types'

const props = defineProps<{
    photos: LatestAlbumPhoto[]
}>()

const track = ref<HTMLElement | null>(null)
const activeIndex = ref(0)
const userPaused = ref(false)
const isHovering = ref(false)
const isFocusWithin = ref(false)
const isDocumentHidden = ref(false)
const reducedMotion = shouldReduceMotion()

let autoplayTimer: number | null = null

const canAutoplay = computed<boolean>(
    () =>
        props.photos.length > 1 &&
        !userPaused.value &&
        !isHovering.value &&
        !isFocusWithin.value &&
        !isDocumentHidden.value &&
        !reducedMotion,
)

const activePhoto = computed<LatestAlbumPhoto | null>(
    () => props.photos[activeIndex.value] ?? null,
)

function goTo(index: number): void {
    const element = track.value

    if (!element) {
        return
    }

    const target = (index + props.photos.length) % props.photos.length
    activeIndex.value = target

    element.scrollTo({
        left: element.clientWidth * target,
        behavior: reducedMotion ? 'auto' : 'smooth',
    })
}

function previous(): void {
    goTo(activeIndex.value - 1)
}

function next(): void {
    goTo(activeIndex.value + 1)
}

function handleScroll(): void {
    const element = track.value

    if (!element || element.clientWidth === 0) {
        return
    }

    const index = Math.round(element.scrollLeft / element.clientWidth)
    activeIndex.value = Math.min(Math.max(index, 0), props.photos.length - 1)
}

function stopAutoplay(): void {
    if (autoplayTimer !== null) {
        window.clearInterval(autoplayTimer)
        autoplayTimer = null
    }
}

function restartAutoplay(): void {
    stopAutoplay()

    if (!canAutoplay.value) {
        return
    }

    autoplayTimer = window.setInterval(() => {
        goTo(activeIndex.value + 1)
    }, 6000)
}

function handleVisibilityChange(): void {
    isDocumentHidden.value = document.hidden
}

function handleResize(): void {
    const element = track.value

    if (!element) {
        return
    }

    element.scrollTo({
        left: element.clientWidth * activeIndex.value,
        behavior: 'auto',
    })
}

onMounted(() => {
    document.addEventListener('visibilitychange', handleVisibilityChange)
    window.addEventListener('resize', handleResize)
    restartAutoplay()
})

onBeforeUnmount(() => {
    stopAutoplay()
    document.removeEventListener('visibilitychange', handleVisibilityChange)
    window.removeEventListener('resize', handleResize)
})

watch(canAutoplay, restartAutoplay)
</script>

<template>
    <Section v-if="photos.length > 0" id="album" background="gray">
        <div class="mb-10 flex flex-col gap-4 sm:flex-row sm:items-end sm:justify-between">
            <div>
                <p class="text-sm font-semibold uppercase tracking-[0.2em] text-[var(--color-link)]">
                    Album photo
                </p>
                <h2 class="mt-2 text-3xl font-bold tracking-tight text-[var(--color-content)] md:text-4xl">
                    Nos dernières photos
                </h2>
                <p class="mt-3 max-w-2xl text-base text-[var(--color-content-muted)]">
                    Chantiers, réalisations et temps forts de JMC Services S.P.R.L.
                </p>
            </div>

            <Link
                href="/album"
                class="inline-flex shrink-0 items-center gap-1.5 rounded-lg border border-[var(--color-action)] px-5 py-2.5 text-sm font-semibold text-[var(--color-link)] transition-colors hover:bg-[var(--color-action)] hover:text-white focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-[var(--color-action)]"
            >
                Voir tout l’album
                <Icon name="arrow-right" :size="16" />
            </Link>
        </div>

        <div
            class="relative"
            @mouseenter="isHovering = true"
            @mouseleave="isHovering = false"
            @focusin="isFocusWithin = true"
            @focusout="isFocusWithin = false"
        >
            <div
                ref="track"
                class="carousel-track flex snap-x snap-mandatory overflow-x-auto focus-visible:outline-2 focus-visible:outline-offset-4 focus-visible:outline-[var(--color-action)]"
                role="region"
                aria-roledescription="carrousel"
                aria-label="Dernières photos publiées"
                tabindex="0"
                @scroll.passive="handleScroll"
                @keydown.left.prevent="previous"
                @keydown.right.prevent="next"
            >
                <Link
                    v-for="(photo, index) in photos"
                    :key="photo.id"
                    :href="photo.album.url"
                    :tabindex="index === activeIndex ? 0 : -1"
                    :aria-hidden="index !== activeIndex"
                    class="group w-full shrink-0 snap-center snap-always focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-[var(--color-action)]"
                >
                    <div class="relative aspect-[4/3] overflow-hidden rounded-2xl bg-[var(--color-surface-muted)] md:aspect-[16/9]">
                        <img
                            v-if="photo.card_url"
                            :src="photo.card_url"
                            :alt="photo.alt"
                            class="h-full w-full object-cover transition duration-500 group-hover:scale-[1.02]"
                            :loading="index === 0 ? 'eager' : 'lazy'"
                            decoding="async"
                        />
                        <div
                            v-else
                            class="flex h-full w-full items-center justify-center"
                        >
                            <Icon
                                name="images"
                                :size="56"
                                class="text-[var(--color-content-placeholder)]"
                            />
                        </div>

                        <div class="absolute inset-x-0 bottom-0 bg-gradient-to-t from-[var(--color-brand-navy)]/95 via-[var(--color-brand-navy)]/55 to-transparent p-6 pt-20 md:p-10 md:pt-28">
                            <span class="inline-flex items-center gap-2 rounded-full bg-white/15 px-3 py-1 text-xs font-semibold text-white backdrop-blur-sm">
                                <Icon name="image" :size="13" />
                                {{ photo.album.title }}
                            </span>
                            <p
                                v-if="photo.caption"
                                class="mt-3 max-w-3xl text-lg font-semibold text-white md:text-2xl"
                            >
                                {{ photo.caption }}
                            </p>
                            <div class="mt-2 flex flex-wrap items-center gap-2 text-sm text-white/80">
                                <time
                                    v-if="photo.album.event_date"
                                    :datetime="photo.album.event_date"
                                >
                                    {{ formatDate(photo.album.event_date) }}
                                </time>
                                <span aria-hidden="true">•</span>
                                <span class="inline-flex items-center gap-1">
                                    Voir l’album
                                    <Icon name="arrow-right" :size="14" />
                                </span>
                            </div>
                        </div>
                    </div>
                </Link>
            </div>

            <template v-if="photos.length > 1">
                <button
                    type="button"
                    class="absolute top-1/2 left-3 z-10 -translate-y-1/2 rounded-full bg-black/35 p-2.5 text-white backdrop-blur-sm transition hover:bg-black/55 focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-white md:left-5 md:p-3"
                    aria-label="Photo précédente"
                    @click="previous"
                >
                    <Icon name="chevron-left" :size="22" />
                </button>

                <button
                    type="button"
                    class="absolute top-1/2 right-3 z-10 -translate-y-1/2 rounded-full bg-black/35 p-2.5 text-white backdrop-blur-sm transition hover:bg-black/55 focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-white md:right-5 md:p-3"
                    aria-label="Photo suivante"
                    @click="next"
                >
                    <Icon name="chevron-right" :size="22" />
                </button>
            </template>
        </div>

        <div
            v-if="photos.length > 1"
            class="mt-4 flex items-center justify-between gap-4"
        >
            <div class="flex items-center gap-2">
                <button
                    v-for="(photo, index) in photos"
                    :key="`dot-${photo.id}`"
                    type="button"
                    class="h-2 rounded-full transition-all duration-300 focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-[var(--color-action)]"
                    :class="index === activeIndex
                        ? 'w-8 bg-[var(--color-action)]'
                        : 'w-2 bg-[var(--color-border-strong)] hover:bg-[var(--color-content-placeholder)]'"
                    :aria-label="`Afficher la photo ${index + 1} sur ${photos.length}`"
                    :aria-current="index === activeIndex ? 'true' : undefined"
                    @click="goTo(index)"
                />
            </div>

            <div class="flex items-center gap-3 text-sm text-[var(--color-content-muted)]">
                <span>{{ activeIndex + 1 }} / {{ photos.length }}</span>
                <button
                    type="button"
                    class="rounded-full p-2 transition-colors hover:bg-[var(--color-surface-elevated)] hover:text-[var(--color-content)] focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-[var(--color-action)]"
                    :aria-label="userPaused ? 'Reprendre le diaporama' : 'Mettre le diaporama en pause'"
                    :aria-pressed="userPaused"
                    @click="userPaused = !userPaused"
                >
                    <Icon :name="userPaused ? 'play' : 'pause'" :size="16" />
                </button>
            </div>
        </div>

        <p class="sr-only" aria-live="polite">
            <template v-if="activePhoto">
                Photo {{ activeIndex + 1 }} sur {{ photos.length }} —
                {{ activePhoto.caption || activePhoto.album.title }}
            </template>
        </p>
    </Section>
</template>

<style scoped>
.carousel-track {
    scrollbar-width: none;
    -ms-overflow-style: none;
}

.carousel-track::-webkit-scrollbar {
    display: none;
}
</style>
