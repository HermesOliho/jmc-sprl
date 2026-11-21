<script setup lang="ts">
import Section from '@/Components/sections/Section.vue'
import SlideLeft from '@/Components/animations/SlideLeft.vue'
import SlideRight from '@/Components/animations/SlideRight.vue'
import BrandIllustration from '@/Components/illustrations/BrandIllustration.vue'
import type { MissionVision } from '@/types'

defineProps<{
    data: MissionVision
    reversed?: boolean
}>()
</script>

<template>
    <Section :background="reversed ? 'gray' : 'white'">
        <div class="grid items-center gap-12 lg:grid-cols-2 lg:gap-16">
            <SlideLeft :class="reversed ? 'lg:order-2' : ''">
                <img
                    v-if="data.image"
                    :src="data.image"
                    :alt="data.title"
                    class="w-full rounded-2xl object-cover shadow-lg"
                    width="800"
                    height="600"
                    loading="lazy"
                />
                <div v-else class="overflow-hidden rounded-2xl bg-[var(--color-brand-navy-dark)] p-5 shadow-lg md:p-8">
                    <BrandIllustration :variant="reversed ? 'planning' : 'construction'" />
                    <p class="mt-2 text-center text-xs font-medium tracking-wide text-white/60">
                        Illustration conceptuelle
                    </p>
                </div>
            </SlideLeft>

            <SlideRight :class="reversed ? 'lg:order-1' : ''">
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

        </div>
    </Section>
</template>
