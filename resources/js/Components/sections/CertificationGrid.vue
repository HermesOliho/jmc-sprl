<script setup lang="ts">
import Section from '@/Components/sections/Section.vue'
import SectionTitle from '@/Components/ui/typography/SectionTitle.vue'
import Stagger from '@/Components/animations/Stagger.vue'
import type { Certification } from '@/types'

defineProps<{
    certifications: Certification[]
}>()
</script>

<template>
    <Section background="white">
        <SectionTitle subtitle="Nos engagements certifiés">
            Certifications
        </SectionTitle>

        <Stagger :stagger="0.1" :delay="0.1">
            <div class="grid gap-6 sm:grid-cols-2 lg:grid-cols-4">
                <div
                    v-for="cert in certifications"
                    :key="cert.name"
                    class="flex flex-col items-center rounded-xl border border-[var(--color-ccm-gray-200)] bg-white p-6 text-center shadow-sm transition-all duration-200 hover:shadow-md"
                >
                    <img
                        :src="cert.logo"
                        :alt="cert.name"
                        class="mb-4 h-20 w-20 rounded-lg object-cover"
                        width="200"
                        height="200"
                        loading="lazy"
                    />
                    <h3 class="text-base font-semibold text-[var(--color-ccm-gray-900)]">
                        {{ cert.name }}
                    </h3>
                    <p class="mt-2 text-sm leading-relaxed text-[var(--color-ccm-gray-600)]">
                        {{ cert.description }}
                    </p>
                </div>
            </div>
        </Stagger>
    </Section>
</template>
