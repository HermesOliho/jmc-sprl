<script setup lang="ts">
import Section from '@/Components/sections/Section.vue'
import SectionTitle from '@/Components/ui/typography/SectionTitle.vue'
import FadeIn from '@/Components/animations/FadeIn.vue'
import Stagger from '@/Components/animations/Stagger.vue'
import Icon from '@/Components/ui/icons/Icon.vue'
import type { Feature } from '@/types'

defineProps<{
    features: Feature[]
    image?: string
}>()
</script>

<template>
    <Section background="white">
        <div class="grid items-center gap-12 lg:grid-cols-2 lg:gap-16">
            <div class="order-2 lg:order-1">
                <SectionTitle :as="2" align="left" subtitle="Ce qui fait notre force">
                    Pourquoi choisir CCM SARL ?
                </SectionTitle>

                <Stagger :stagger="0.08" :delay="0.1">
                    <div class="space-y-6">
                        <div
                            v-for="feature in features"
                            :key="feature.title"
                            class="flex gap-5"
                        >
                            <div
                                class="flex h-12 w-12 shrink-0 items-center justify-center rounded-xl bg-[var(--color-ccm-blue)] text-white"
                            >
                                <Icon :name="feature.icon" :size="22" />
                            </div>
                            <div>
                                <h3 class="text-lg font-semibold text-[var(--color-ccm-gray-900)]">
                                    {{ feature.title }}
                                </h3>
                                <p class="mt-1 text-base leading-relaxed text-[var(--color-ccm-gray-600)]">
                                    {{ feature.description }}
                                </p>
                            </div>
                        </div>
                    </div>
                </Stagger>
            </div>

            <div class="order-1 lg:order-2">
                <FadeIn>
                    <div class="relative">
                        <img
                            :src="image || 'https://placehold.co/800x900/1a3a5c/ffffff?text=Pourquoi+CCM'"
                            alt="Pourquoi choisir CCM SARL"
                            class="w-full rounded-2xl object-cover shadow-lg"
                            width="800"
                            height="900"
                            loading="lazy"
                        />
                        <div
                            class="absolute -bottom-4 -left-4 hidden h-24 w-24 rounded-2xl border-8 border-white bg-[var(--color-ccm-yellow)] lg:block"
                        />
                    </div>
                </FadeIn>
            </div>
        </div>
    </Section>
</template>
