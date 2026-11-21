<script setup lang="ts">
import { Link } from '@inertiajs/vue3'
import Section from '@/Components/sections/Section.vue'
import SectionTitle from '@/Components/ui/typography/SectionTitle.vue'
import FeatureCard from '@/Components/ui/cards/FeatureCard.vue'
import Icon from '@/Components/ui/icons/Icon.vue'
import PrimaryButton from '@/Components/ui/buttons/PrimaryButton.vue'
import Stagger from '@/Components/animations/Stagger.vue'
import type { ServiceItem } from '@/types'

defineProps<{
    services: ServiceItem[]
}>()
</script>

<template>
    <Section background="gray" id="services">
        <SectionTitle subtitle="Notre savoir-faire">
            Nos domaines d'expertise
        </SectionTitle>

        <Stagger :stagger="0.08" :delay="0.1">
            <div class="grid gap-6 sm:grid-cols-2 lg:grid-cols-3">
                <FeatureCard
                    v-for="service in services"
                    :key="service.title"
                    :icon="service.icon"
                    :title="service.title"
                    :description="service.description"
                >
                    <div class="mt-4">
                        <Link
                            :href="`/services#${service.slug}`"
                            class="inline-flex items-center gap-1.5 text-sm font-medium text-[var(--color-link)] transition-colors hover:text-[var(--color-action-hover)]"
                        >
                            En savoir plus
                            <Icon name="chevron-right" :size="16" />
                        </Link>
                    </div>
                </FeatureCard>
            </div>
        </Stagger>

        <div class="mt-12 text-center">
            <Link href="/services">
                <PrimaryButton size="lg">
                    Voir tous nos services
                    <Icon name="arrow-right" :size="20" />
                </PrimaryButton>
            </Link>
        </div>
    </Section>
</template>
