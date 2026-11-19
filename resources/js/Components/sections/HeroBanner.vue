<script setup lang="ts">
import { Link } from '@inertiajs/vue3'
import { animate } from 'motion-v'
import { onMounted, ref } from 'vue'
import Container from '@/Components/ui/Container.vue'
import Icon from '@/Components/ui/icons/Icon.vue'
import { classNames } from '@/utils'
import type { HomeHero } from '@/types'
import logoSrc from '../../../images/logo-full.png'

const props = withDefaults(defineProps<{
    data: HomeHero
    backgroundImage?: string
    class?: string
}>(), {
    backgroundImage: '',
})

const heroRef = ref<HTMLElement | null>(null)
const contentRef = ref<HTMLElement | null>(null)
const statsRef = ref<HTMLElement | null>(null)

onMounted(() => {
    if (contentRef.value) {
        animate(
            contentRef.value,
            { opacity: [0, 1], y: [30, 0] },
            { duration: 0.8, ease: [0.25, 0.1, 0.25, 1] },
        )
    }
    if (statsRef.value) {
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
        ref="heroRef"
        :class="classNames(
            'relative flex min-h-[85vh] items-center overflow-hidden',
            $props.class,
        )"
    >
        <div
            class="absolute inset-0 bg-cover bg-center bg-no-repeat"
            :style="{ backgroundImage: `url(${backgroundImage})` }"
        />
        <div class="absolute inset-0 bg-gradient-to-br from-[var(--color-ccm-blue-dark)]/90 via-[var(--color-ccm-blue)]/85 to-[var(--color-ccm-blue-dark)]/90" />
        <div
            class="absolute inset-0 opacity-[0.04]"
            style="background-image: radial-gradient(circle at 50% 50%, white 1px, transparent 1px); background-size: 40px 40px;"
        />
        <Container class="relative z-10 py-24 md:py-32">
            <div ref="contentRef" class="lg:flex lg:gap-16 lg:items-start">
                <div class="flex-1">
                    <img
                        :src="logoSrc"
                        alt="CCM SARL"
                        class="mb-4 h-12 w-auto md:mb-6 md:h-16 lg:hidden"
                    />
                    <span
                        class="inline-flex items-center gap-2 rounded-full border border-white/20 bg-white/10 px-4 py-1.5 text-sm font-medium text-white/90 backdrop-blur-sm"
                    >
                        <Icon name="star" :size="14" class="text-[var(--color-ccm-yellow)]" />
                        {{ data.badge }}
                    </span>
                    <h1
                        class="mt-6 max-w-4xl text-4xl font-bold leading-tight text-white md:text-5xl lg:text-6xl xl:text-7xl"
                    >
                        {{ data.title }}
                    </h1>
                    <p class="mt-6 max-w-2xl text-lg leading-relaxed text-white/75 md:text-xl">
                        {{ data.subtitle }}
                    </p>
                    <div class="mt-10 flex flex-wrap gap-4">
                        <Link :href="data.primaryCta.href">
                            <span
                                class="inline-flex items-center gap-2 rounded-lg bg-[var(--color-ccm-yellow)] px-8 py-3.5 text-lg font-semibold text-[var(--color-ccm-blue-dark)] transition-all duration-200 hover:bg-[var(--color-ccm-yellow-light)] hover:shadow-lg"
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
                <div class="hidden shrink-0 lg:block">
                    <img
                        :src="logoSrc"
                        alt="CCM SARL"
                        class="h-44 w-auto"
                    />
                </div>
            </div>
            <div
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
                    <span class="mt-1 block text-sm font-medium text-white/60">
                        {{ stat.label }}
                    </span>
                </div>
            </div>
        </Container>
    </section>
</template>
