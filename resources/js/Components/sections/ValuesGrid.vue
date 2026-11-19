<script setup lang="ts">
import Section from '@/Components/sections/Section.vue'
import SectionTitle from '@/Components/ui/typography/SectionTitle.vue'
import Icon from '@/Components/ui/icons/Icon.vue'
import Stagger from '@/Components/animations/Stagger.vue'
import type { CompanyValue } from '@/types'

defineProps<{
    values: CompanyValue[]
}>()
</script>

<template>
    <Section background="white">
        <SectionTitle subtitle="Ce qui nous anime">
            Nos valeurs
        </SectionTitle>

        <Stagger :stagger="0.08" :delay="0.1">
            <div class="grid gap-6 sm:grid-cols-2 lg:grid-cols-3">
                <div
                    v-for="value in values"
                    :key="value.title"
                    class="group rounded-xl border border-[var(--color-ccm-gray-200)] bg-white p-6 shadow-sm transition-all duration-200 hover:-translate-y-1 hover:shadow-md"
                >
                    <div
                        class="mb-4 flex h-12 w-12 items-center justify-center rounded-lg bg-[var(--color-ccm-blue)]/10 transition-colors duration-200 group-hover:bg-[var(--color-ccm-blue)]"
                    >
                        <Icon
                            :name="value.icon"
                            :size="24"
                            class="text-[var(--color-ccm-blue)] transition-colors duration-200 group-hover:text-white"
                        />
                    </div>
                    <h3 class="text-lg font-semibold text-[var(--color-ccm-gray-900)]">
                        {{ value.title }}
                    </h3>
                    <p class="mt-2 text-sm leading-relaxed text-[var(--color-ccm-gray-600)]">
                        {{ value.description }}
                    </p>
                </div>
            </div>
        </Stagger>
    </Section>
</template>
