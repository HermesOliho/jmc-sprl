<script setup lang="ts">
import { Link } from '@inertiajs/vue3'
import Section from '@/Components/sections/Section.vue'
import SectionTitle from '@/Components/ui/typography/SectionTitle.vue'
import Icon from '@/Components/ui/icons/Icon.vue'
import IconBox from '@/Components/sections/IconBox.vue'
import OutlineButton from '@/Components/ui/buttons/OutlineButton.vue'
import FadeIn from '@/Components/animations/FadeIn.vue'
import SlideLeft from '@/Components/animations/SlideLeft.vue'
import SlideRight from '@/Components/animations/SlideRight.vue'
import type { AboutPreview } from '@/types'

defineProps<{
    data: AboutPreview
}>()
</script>

<template>
    <Section background="white">
        <div class="grid items-center gap-12 lg:grid-cols-2 lg:gap-16">
            <SlideLeft>
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

            <SlideRight>
                <SectionTitle :as="2" align="left" :subtitle="data.title">
                    Une entreprise congolaise au service du développement
                </SectionTitle>

                <FadeIn :delay="0.2">
                    <p class="text-base leading-relaxed text-[var(--color-ccm-gray-600)] md:text-lg">
                        {{ data.content }}
                    </p>
                </FadeIn>

                <div class="mt-8 space-y-5">
                    <IconBox
                        v-for="value in data.values"
                        :key="value.title"
                        :icon="value.icon"
                        :title="value.title"
                        :description="value.description"
                    />
                </div>

                <div class="mt-10">
                    <Link :href="data.cta.href">
                        <OutlineButton size="lg">
                            {{ data.cta.label }}
                            <Icon name="arrow-right" :size="18" />
                        </OutlineButton>
                    </Link>
                </div>
            </SlideRight>
        </div>
    </Section>
</template>
