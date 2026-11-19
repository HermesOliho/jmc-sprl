<script setup lang="ts">
import Section from '@/Components/sections/Section.vue'
import SectionTitle from '@/Components/ui/typography/SectionTitle.vue'
import type { Partner } from '@/types'

defineProps<{
    partners: Partner[]
}>()
</script>

<template>
    <Section background="gray">
        <SectionTitle subtitle="Ils nous font confiance">
            Nos partenaires
        </SectionTitle>

        <div
            class="group relative overflow-hidden"
        >
            <div
                class="flex animate-infinite-scroll gap-10"
            >
                <template v-for="i in 2" :key="i">
                    <img
                        v-for="partner in partners"
                        :key="partner.name + i"
                        :src="partner.logo"
                        :alt="partner.name"
                        class="h-12 w-auto shrink-0 object-contain opacity-50 grayscale transition-all duration-300 group-hover:opacity-100 group-hover:grayscale-0 md:h-16"
                        width="180"
                        height="80"
                        loading="lazy"
                    />
                </template>
            </div>
        </div>
    </Section>
</template>

<style scoped>
@keyframes infinite-scroll {
    0% {
        transform: translateX(0);
    }
    100% {
        transform: translateX(-50%);
    }
}

.animate-infinite-scroll {
    animation: infinite-scroll 30s linear infinite;
}

.group:hover .animate-infinite-scroll {
    animation-play-state: paused;
}
</style>
