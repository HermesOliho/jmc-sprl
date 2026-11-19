<script setup lang="ts">
import { classNames } from '@/utils'
import type { BreadcrumbItem } from '@/types'
import Container from '@/Components/ui/Container.vue'
import Breadcrumb from '@/Components/ui/navigation/Breadcrumb.vue'

defineProps<{
    title: string
    subtitle?: string
    breadcrumbs?: BreadcrumbItem[]
    class?: string
}>()
</script>

<template>
    <section
        :class="classNames(
            'relative overflow-hidden bg-[var(--color-ccm-blue)] py-16 md:py-24',
            $props.class,
        )"
    >
        <div
            class="absolute inset-0 opacity-10"
            style="background-image: radial-gradient(circle at 25% 25%, white 1px, transparent 1px); background-size: 40px 40px;"
        />
        <Container>
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
        </Container>
    </section>
</template>
