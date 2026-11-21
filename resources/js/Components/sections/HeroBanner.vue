<script setup lang="ts">
import { Link } from '@inertiajs/vue3'
import { animate } from 'motion-v'
import { onMounted, ref } from 'vue'
import Container from '@/Components/ui/Container.vue'
import Icon from '@/Components/ui/icons/Icon.vue'
import BrandIllustration from '@/Components/illustrations/BrandIllustration.vue'
import { useSite } from '@/composables'
import { classNames, shouldReduceMotion } from '@/utils'
import type { HomeHero } from '@/types'

const props = withDefaults(defineProps<{
    data: HomeHero
    backgroundImage?: string
    class?: string
}>(), {
    backgroundImage: '',
})

const site = useSite()

const contentRef = ref<HTMLElement | null>(null)
const statsRef = ref<HTMLElement | null>(null)

onMounted(() => {
    if (!shouldReduceMotion() && contentRef.value) {
        animate(
            contentRef.value,
            { opacity: [0, 1], y: [30, 0] },
            { duration: 0.8, ease: [0.25, 0.1, 0.25, 1] },
        )
    }
    if (!shouldReduceMotion() && statsRef.value && props.data.stats.length > 0) {
        animate(
            statsRef.value,
            { opacity: [0, 1], y: [20, 0] },
            { duration: 0.6, delay: 0.4, ease: [0.25, 0.1, 0.25, 1] },
        )
    }
})
</script>

<template>
    <section
        :class="classNames(
            'relative flex min-h-[78vh] items-center overflow-hidden',
            $props.class,
        )"
    >
        <div
            v-if="backgroundImage"
            class="absolute inset-0 bg-cover bg-center bg-no-repeat"
            :style="{ backgroundImage: `url(${backgroundImage})` }"
        />
        <div class="absolute inset-0 bg-gradient-to-br from-[var(--color-brand-navy-dark)]/95 via-[var(--color-brand-navy)]/90 to-[var(--color-brand-navy-dark)]/95" />
        <div
            class="absolute inset-0 opacity-[0.05]"
            style="background-image: radial-gradient(circle at 50% 50%, white 1px, transparent 1px); background-size: 40px 40px;"
        />
        <Container class="relative z-10 py-24 md:py-32">
            <div ref="contentRef" class="grid items-center gap-10 lg:grid-cols-[minmax(0,1.1fr)_minmax(20rem,0.9fr)] lg:gap-16">
                <div>
                    <span
                        class="inline-flex items-center gap-2 rounded-full border border-white/20 bg-white/10 px-4 py-1.5 text-sm font-medium text-white/90 backdrop-blur-sm"
                    >
                        <Icon name="star" :size="14" class="text-[var(--color-brand-orange-light)]" />
                        {{ data.badge }}
                    </span>
                    <h1
                        class="mt-6 max-w-4xl text-4xl font-bold leading-tight text-white md:text-5xl lg:text-6xl xl:text-7xl"
                    >
                        {{ data.title }}
                    </h1>
                    <p class="mt-6 max-w-2xl text-lg leading-relaxed text-white/80 md:text-xl">
                        {{ data.subtitle }}
                    </p>
                    <p
                        v-if="site.slogan"
                        lang="en"
                        class="mt-6 text-xs font-semibold uppercase tracking-[0.2em] text-[var(--color-brand-orange-light)] md:text-sm"
                    >
                        {{ site.slogan }}
                    </p>
                    <div class="mt-10 flex flex-wrap gap-4">
                        <Link :href="data.primaryCta.href">
                            <span
                                class="inline-flex items-center gap-2 rounded-lg bg-[var(--color-brand-orange)] px-8 py-3.5 text-lg font-semibold text-[var(--color-on-accent)] transition-all duration-200 hover:bg-[var(--color-brand-orange-light)] hover:shadow-lg"
                            >
                                {{ data.primaryCta.label }}
                                <Icon name="arrow-right" :size="20" />
                            </span>
                        </Link>
                        <Link :href="data.secondaryCta.href">
                            <span
                                class="inline-flex items-center gap-2 rounded-lg border-2 border-white/30 bg-transparent px-8 py-3.5 text-lg font-semibold text-white transition-all duration-200 hover:border-white/50 hover:bg-white/10"
                            >
                                {{ data.secondaryCta.label }}
                            </span>
                        </Link>
                    </div>
                </div>
                <div class="mx-auto w-full max-w-md lg:max-w-none">
                    <div class="overflow-hidden rounded-[2rem] border border-white/15 bg-white/5 p-4 shadow-2xl shadow-black/20 backdrop-blur-sm md:p-6">
                        <BrandIllustration variant="construction" class="w-full" />
                    </div>
                </div>
            </div>
            <div
                v-if="data.stats.length > 0"
                ref="statsRef"
                class="mt-16 grid grid-cols-3 gap-6 border-t border-white/10 pt-10 md:gap-10"
            >
                <div
                    v-for="stat in data.stats"
                    :key="stat.label"
                    class="text-center md:text-left"
                >
                    <span class="block text-3xl font-bold text-white md:text-4xl">
                        {{ stat.value }}
                    </span>
                    <span class="mt-1 block text-sm font-medium text-white/70">
                        {{ stat.label }}
                    </span>
                </div>
            </div>
        </Container>
    </section>
</template>
