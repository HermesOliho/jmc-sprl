<script setup lang="ts">
import Section from '@/Components/sections/Section.vue'
import SectionTitle from '@/Components/ui/typography/SectionTitle.vue'
import Icon from '@/Components/ui/icons/Icon.vue'
import Stagger from '@/Components/animations/Stagger.vue'
import type { HistoryItem } from '@/types'

defineProps<{
    items: HistoryItem[]
}>()
</script>

<template>
    <Section background="gray">
        <SectionTitle subtitle="Notre parcours">
            Notre histoire
        </SectionTitle>

        <div class="relative mx-auto max-w-4xl">
            <div class="absolute left-[23px] top-0 hidden h-full w-0.5 bg-[var(--color-ccm-blue)]/20 md:block" />

            <Stagger :stagger="0.15" :delay="0.1">
                <div class="space-y-10 md:space-y-14">
                    <div
                        v-for="item in items"
                        :key="item.year"
                        class="relative flex flex-col gap-4 md:flex-row md:gap-8"
                    >
                        <div class="flex items-start gap-4 md:w-44 md:shrink-0 md:pt-1 md:text-right">
                            <div
                                class="relative z-10 flex h-12 w-12 shrink-0 items-center justify-center rounded-xl bg-[var(--color-ccm-blue)] text-white shadow-md md:mx-auto"
                            >
                                <Icon :name="item.icon" :size="20" />
                            </div>
                            <span
                                class="mt-2.5 text-lg font-bold text-[var(--color-ccm-blue)] md:hidden"
                            >
                                {{ item.year }}
                            </span>
                        </div>

                        <div class="hidden pt-2.5 md:block md:w-20 md:text-right">
                            <span class="text-lg font-bold text-[var(--color-ccm-yellow)]">
                                {{ item.year }}
                            </span>
                        </div>

                        <div class="min-w-0 flex-1">
                            <h3 class="text-xl font-bold text-[var(--color-ccm-gray-900)]">
                                {{ item.title }}
                            </h3>
                            <p class="mt-2 text-base leading-relaxed text-[var(--color-ccm-gray-600)]">
                                {{ item.description }}
                            </p>
                        </div>
                    </div>
                </div>
            </Stagger>
        </div>
    </Section>
</template>
