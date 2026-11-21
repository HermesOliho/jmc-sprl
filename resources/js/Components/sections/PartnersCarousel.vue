<script setup lang="ts">
import Section from '@/Components/sections/Section.vue';
import SectionTitle from '@/Components/ui/typography/SectionTitle.vue';
import type { Partner } from '@/types';

defineProps<{
    partners: Partner[];
}>();
</script>

<template>
    <Section v-if="partners.length" background="gray">
        <SectionTitle subtitle="Ils nous font confiance">
            Nos partenaires
        </SectionTitle>

        <div class="group relative overflow-hidden">
            <div class="animate-infinite-scroll flex gap-12">
                <template v-for="i in 2" :key="i">
                    <component
                        :is="partner.website_url ? 'a' : 'div'"
                        v-for="(partner, index) in partners"
                        :key="`${partner.name}-${i}-${index}`"
                        v-bind="
                            partner.website_url
                                ? {
                                      href: partner.website_url,
                                      target: '_blank',
                                      rel: 'noopener noreferrer',
                                  }
                                : {}
                        "
                        class="shrink-0"
                        :title="partner.description || partner.name"
                    >
                        <img
                            :src="partner.logo"
                            :alt="partner.name"
                            class="h-20 w-auto object-contain opacity-50 grayscale transition-all duration-200 group-hover:opacity-100 group-hover:grayscale-0 md:h-20"
                            width="220"
                            height="100"
                            loading="lazy"
                        />
                    </component>
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

@media (prefers-reduced-motion: reduce) {
    .animate-infinite-scroll {
        animation: none;
    }
}
</style>
