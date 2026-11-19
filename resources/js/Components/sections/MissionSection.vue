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
        <div class="grid items-center gap-12 lg:grid-cols-2 lg:gap-16">
            <SlideLeft v-if="!reversed">
                <div class="relative">
                    <img
                        :src="data.image"
                        :alt="data.title"
                        class="w-full rounded-2xl object-cover shadow-lg"
                        width="800"
                        height="600"
                        loading="lazy"
                    />
                    <div
                        class="absolute -bottom-4 -right-4 hidden h-24 w-24 rounded-2xl border-8 border-white bg-[var(--color-ccm-yellow)] lg:block"
                    />
                </div>
            </SlideLeft>

            <SlideRight v-if="!reversed" class="order-first">
                <h2 class="text-3xl font-bold tracking-tight text-[var(--color-ccm-gray-900)] md:text-4xl">
                    {{ data.title }}
                </h2>
                <p class="mt-6 text-base leading-relaxed text-[var(--color-ccm-gray-600)] md:text-lg">
                    {{ data.description }}
                </p>
                <div
                    v-if="data.callout"
                    class="mt-8 rounded-xl border-l-4 border-[var(--color-ccm-yellow)] bg-[var(--color-ccm-yellow)]/5 p-5"
                >
                    <p class="text-base font-medium italic text-[var(--color-ccm-gray-900)]">
                        {{ data.callout }}
                    </p>
                </div>
            </SlideRight>

            <SlideRight v-if="reversed">
                <h2 class="text-3xl font-bold tracking-tight text-[var(--color-ccm-gray-900)] md:text-4xl">
                    {{ data.title }}
                </h2>
                <p class="mt-6 text-base leading-relaxed text-[var(--color-ccm-gray-600)] md:text-lg">
                    {{ data.description }}
                </p>
                <div
                    v-if="data.callout"
                    class="mt-8 rounded-xl border-l-4 border-[var(--color-ccm-yellow)] bg-[var(--color-ccm-yellow)]/5 p-5"
                >
                    <p class="text-base font-medium italic text-[var(--color-ccm-gray-900)]">
                        {{ data.callout }}
                    </p>
                </div>
            </SlideRight>

            <SlideLeft v-if="reversed">
                <div class="relative">
                    <img
                        :src="data.image"
                        :alt="data.title"
                        class="w-full rounded-2xl object-cover shadow-lg"
                        width="800"
                        height="600"
                        loading="lazy"
                    />
                    <div
                        class="absolute -bottom-4 -left-4 hidden h-24 w-24 rounded-2xl border-8 border-white bg-[var(--color-ccm-yellow)] lg:block"
                    />
                </div>
            </SlideLeft>
        </div>
    </Section>
</template>
