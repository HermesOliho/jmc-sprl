<script setup lang="ts">
import Section from '@/Components/sections/Section.vue'
import SectionTitle from '@/Components/ui/typography/SectionTitle.vue'
import Icon from '@/Components/ui/icons/Icon.vue'
import FadeIn from '@/Components/animations/FadeIn.vue'
import Stagger from '@/Components/animations/Stagger.vue'
import type { TimelineItem } from '@/types'

defineProps<{
    steps: TimelineItem[]
}>()
</script>

<template>
    <Section background="white">
        <SectionTitle subtitle="Notre méthode de travail">
            Notre processus
        </SectionTitle>

        <div class="relative mx-auto max-w-5xl">
            <div
                class="absolute left-8 top-0 hidden h-full w-0.5 bg-[var(--color-ccm-gray-200)] md:block"
            />

            <Stagger :stagger="0.15" :delay="0.1">
                <div class="space-y-8 md:space-y-12">
                    <div
                        v-for="(step, index) in steps"
                        :key="step.step"
                        class="relative flex flex-col items-start gap-4 md:flex-row md:items-center md:gap-8"
                    >
                        <div
                            class="relative z-10 flex h-16 w-16 shrink-0 items-center justify-center rounded-2xl bg-[var(--color-ccm-blue)] text-white shadow-md"
                        >
                            <Icon :name="step.icon" :size="26" />
                        </div>

                        <div
                            v-if="index < steps.length - 1"
                            class="absolute left-8 top-16 hidden h-8 w-0.5 bg-[var(--color-ccm-gray-200)] md:block"
                        />

                        <div class="min-w-0 flex-1">
                            <span
                                class="mb-1 block text-sm font-semibold uppercase tracking-wider text-[var(--color-ccm-yellow)]"
                            >
                                Étape {{ step.step }}
                            </span>
                            <h3 class="text-xl font-bold text-[var(--color-ccm-gray-900)]">
                                {{ step.title }}
                            </h3>
                            <p class="mt-1 text-base text-[var(--color-ccm-gray-600)]">
                                {{ step.description }}
                            </p>
                        </div>
                    </div>
                </div>
            </Stagger>
        </div>
    </Section>
</template>
