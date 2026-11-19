<script setup lang="ts">
import { ref } from 'vue'
import { Link } from '@inertiajs/vue3'
import Section from '@/Components/sections/Section.vue'
import SectionTitle from '@/Components/ui/typography/SectionTitle.vue'
import Icon from '@/Components/ui/icons/Icon.vue'
import Badge from '@/Components/ui/badges/Badge.vue'
import type { Project } from '@/types'

defineProps<{
    projects: Project[]
}>()

const scrollContainer = ref<HTMLElement | null>(null)

function scroll(direction: 'left' | 'right') {
    if (!scrollContainer.value) return
    const amount = 320
    scrollContainer.value.scrollBy({
        left: direction === 'left' ? -amount : amount,
        behavior: 'smooth',
    })
}
</script>

<template>
    <Section background="gray" id="realisations">
        <div class="mb-10 flex items-end justify-between">
            <SectionTitle :as="2" align="left" class="mb-0">
                Quelques réalisations
            </SectionTitle>

            <div class="hidden items-center gap-2 sm:flex">
                <button
                    type="button"
                    class="flex h-10 w-10 items-center justify-center rounded-full border border-[var(--color-ccm-gray-300)] bg-white text-[var(--color-ccm-gray-700)] transition-colors hover:bg-[var(--color-ccm-gray-100)]"
                    aria-label="Défiler vers la gauche"
                    @click="scroll('left')"
                >
                    <Icon name="chevron-right" :size="18" class="rotate-180" />
                </button>
                <button
                    type="button"
                    class="flex h-10 w-10 items-center justify-center rounded-full border border-[var(--color-ccm-gray-300)] bg-white text-[var(--color-ccm-gray-700)] transition-colors hover:bg-[var(--color-ccm-gray-100)]"
                    aria-label="Défiler vers la droite"
                    @click="scroll('right')"
                >
                    <Icon name="chevron-right" :size="18" />
                </button>
            </div>
        </div>

        <div
            ref="scrollContainer"
            class="flex gap-6 overflow-x-auto pb-4 scrollbar-hide snap-x snap-mandatory"
            style="-webkit-overflow-scrolling: touch; scrollbar-width: none;"
        >
            <div
                v-for="project in projects"
                :key="project.id"
                class="group w-[300px] shrink-0 snap-start md:w-[340px]"
            >
                <div
                    class="overflow-hidden rounded-xl bg-white shadow-sm transition-all duration-300 group-hover:shadow-md"
                >
                    <div class="relative aspect-[4/3] overflow-hidden">
                        <img
                            :src="project.image"
                            :alt="project.title"
                            class="h-full w-full object-cover transition-transform duration-500 group-hover:scale-105"
                            width="400"
                            height="300"
                            loading="lazy"
                        />
                        <div
                            class="absolute inset-0 bg-gradient-to-t from-black/50 to-transparent opacity-0 transition-opacity duration-300 group-hover:opacity-100"
                        />
                    </div>
                    <div class="space-y-2 p-5">
                        <Badge variant="primary" size="sm">
                            {{ project.category }}
                        </Badge>
                        <h3 class="text-lg font-semibold text-[var(--color-ccm-gray-900)]">
                            {{ project.title }}
                        </h3>
                        <div class="flex items-center gap-1.5 text-sm text-[var(--color-ccm-gray-500)]">
                            <Icon name="map-pin" :size="14" />
                            {{ project.city }}
                        </div>
                        <div class="pt-2">
                            <Link
                                :href="`/realisations#${project.id}`"
                                class="inline-flex items-center gap-1.5 text-sm font-medium text-[var(--color-ccm-blue)] transition-colors hover:text-[var(--color-ccm-blue-light)]"
                            >
                                Voir le projet
                                <Icon name="arrow-right" :size="14" />
                            </Link>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="mt-10 text-center">
            <Link href="/realisations">
                <span
                    class="inline-flex items-center gap-2 rounded-lg border-2 border-[var(--color-ccm-blue)] px-6 py-3 font-semibold text-[var(--color-ccm-blue)] transition-all duration-200 hover:bg-[var(--color-ccm-blue)] hover:text-white"
                >
                    Voir toutes nos réalisations
                    <Icon name="arrow-right" :size="18" />
                </span>
            </Link>
        </div>
    </Section>
</template>

<style scoped>
.scrollbar-hide::-webkit-scrollbar {
    display: none;
}
</style>
