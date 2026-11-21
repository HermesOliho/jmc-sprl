<script setup lang="ts">
import Section from '@/Components/sections/Section.vue'
import SlideLeft from '@/Components/animations/SlideLeft.vue'
import SlideRight from '@/Components/animations/SlideRight.vue'
import type { MissionVision } from '@/types'

defineProps<{
    data: MissionVision
    reversed?: boolean
}>()
</script>

<template>
    <Section :background="reversed ? 'gray' : 'white'">
        <div
            :class="data.image
                ? 'grid items-center gap-12 lg:grid-cols-2 lg:gap-16'
                : 'mx-auto max-w-3xl'"
        >
            <SlideLeft v-if="data.image && !reversed">
                <img
                    :src="data.image"
                    :alt="data.title"
                    class="w-full rounded-2xl object-cover shadow-lg"
                    width="800"
                    height="600"
                    loading="lazy"
                />
            </SlideLeft>

            <SlideRight :class="data.image && !reversed ? 'order-first' : ''">
                <h2 class="text-3xl font-bold tracking-tight text-[var(--color-content)] md:text-4xl">
                    {{ data.title }}
                </h2>
                <p class="mt-6 text-base leading-relaxed text-[var(--color-content-muted)] md:text-lg">
                    {{ data.description }}
                </p>
                <div
                    v-if="data.callout"
                    class="mt-8 rounded-xl border-l-4 border-[var(--color-brand-orange)] bg-[var(--color-brand-orange)]/5 p-5"
                >
                    <p class="text-base font-medium italic text-[var(--color-content)]">
                        {{ data.callout }}
                    </p>
                </div>
            </SlideRight>

            <SlideLeft v-if="data.image && reversed">
                <img
                    :src="data.image"
                    :alt="data.title"
                    class="w-full rounded-2xl object-cover shadow-lg"
                    width="800"
                    height="600"
                    loading="lazy"
                />
            </SlideLeft>
        </div>
    </Section>
</template>
