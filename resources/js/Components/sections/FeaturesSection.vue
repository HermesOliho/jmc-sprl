<script setup lang="ts">
import Section from '@/Components/sections/Section.vue'
import SectionTitle from '@/Components/ui/typography/SectionTitle.vue'
import FadeIn from '@/Components/animations/FadeIn.vue'
import Stagger from '@/Components/animations/Stagger.vue'
import Icon from '@/Components/ui/icons/Icon.vue'
import { useSite } from '@/composables'
import type { Feature } from '@/types'

withDefaults(defineProps<{
    features: Feature[]
    image?: string
    title?: string
    subtitle?: string
}>(), {
    subtitle: 'Ce qui fait notre force',
})

const site = useSite()
</script>

<template>
    <Section background="white">
        <div
            :class="image
                ? 'grid items-center gap-12 lg:grid-cols-2 lg:gap-16'
                : ''"
        >
            <div :class="image ? 'order-2 lg:order-1' : ''">
                <SectionTitle :as="2" align="left" :subtitle="subtitle">
                    {{ title ?? `Pourquoi choisir ${site.name} ?` }}
                </SectionTitle>

                <Stagger :stagger="0.08" :delay="0.1">
                    <div :class="image ? 'space-y-6' : 'grid gap-6 sm:grid-cols-2 lg:grid-cols-3'">
                        <div
                            v-for="feature in features"
                            :key="feature.title"
                            class="flex gap-5"
                        >
                            <div
                                class="flex h-12 w-12 shrink-0 items-center justify-center rounded-xl bg-[var(--color-action)] text-white"
                            >
                                <Icon :name="feature.icon" :size="22" />
                            </div>
                            <div>
                                <h3 class="text-lg font-semibold text-[var(--color-content)]">
                                    {{ feature.title }}
                                </h3>
                                <p class="mt-1 text-base leading-relaxed text-[var(--color-content-muted)]">
                                    {{ feature.description }}
                                </p>
                            </div>
                        </div>
                    </div>
                </Stagger>
            </div>

            <div v-if="image" class="order-1 lg:order-2">
                <FadeIn>
                    <img
                        :src="image"
                        :alt="title ?? `Pourquoi choisir ${site.name}`"
                        class="w-full rounded-2xl object-cover shadow-lg"
                        width="800"
                        height="900"
                        loading="lazy"
                    />
                </FadeIn>
            </div>
        </div>
    </Section>
</template>
