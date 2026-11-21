<script setup lang="ts">
import { classNames } from '@/utils'
import type { BreadcrumbItem } from '@/types'
import Container from '@/Components/ui/Container.vue'
import Breadcrumb from '@/Components/ui/navigation/Breadcrumb.vue'
import BrandIllustration from '@/Components/illustrations/BrandIllustration.vue'

defineProps<{
    title: string
    subtitle?: string
    breadcrumbs?: BreadcrumbItem[]
    illustration?: 'construction' | 'planning' | 'location' | 'organization'
    class?: string
}>()
</script>

<template>
    <section
        :class="classNames(
            'relative overflow-hidden bg-[var(--color-brand-navy)] py-16 md:py-24',
            $props.class,
        )"
    >
        <div
            class="absolute inset-0 opacity-10"
            style="background-image: radial-gradient(circle at 25% 25%, white 1px, transparent 1px); background-size: 40px 40px;"
        />
        <Container>
            <div :class="illustration ? 'grid items-center gap-8 md:grid-cols-[minmax(0,1fr)_minmax(14rem,0.65fr)] md:gap-12' : ''">
                <div>
                    <Breadcrumb
                        v-if="breadcrumbs"
                        :items="breadcrumbs"
                        class="mb-6"
                    />
                    <h1 class="text-3xl font-bold text-white md:text-5xl">
                        {{ title }}
                    </h1>
                    <p v-if="subtitle" class="mt-4 max-w-2xl text-lg text-white/80">
                        {{ subtitle }}
                    </p>
                </div>
                <div
                    v-if="illustration"
                    class="mx-auto w-full max-w-xs rounded-3xl border border-white/15 bg-white/5 p-3 md:max-w-none"
                >
                    <BrandIllustration :variant="illustration" />
                    <p class="pb-1 text-center text-[10px] font-semibold uppercase tracking-[0.16em] text-white/55">
                        Illustration conceptuelle
                    </p>
                </div>
            </div>
        </Container>
    </section>
</template>
