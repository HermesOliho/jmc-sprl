<script setup lang="ts">
import { classNames } from '@/utils'
import ServiceIllustration from '@/Components/illustrations/ServiceIllustration.vue'

defineProps<{
    title: string
    description: string
    icon?: string
    image?: string | null
    imageAlt?: string | null
    imagePosition?: string | null
    class?: string
}>()
</script>

<template>
    <div
        :class="classNames(
            'group overflow-hidden rounded-xl border border-[var(--color-border)] bg-[var(--color-surface)] shadow-sm transition-all duration-200 hover:shadow-md hover:-translate-y-1',
            $props.class,
        )"
    >
        <div v-if="image" class="aspect-[16/9] w-full overflow-hidden bg-[var(--color-surface-muted)]">
            <img
                :src="image"
                :alt="imageAlt || title"
                class="h-full w-full object-cover transition-transform duration-200 group-hover:scale-105"
                :style="imagePosition ? { objectPosition: imagePosition } : undefined"
                width="640"
                height="360"
                loading="lazy"
                decoding="async"
            />
        </div>
        <ServiceIllustration v-else-if="icon" :icon="icon" />
        <div class="p-6">
        <h3 class="text-lg font-semibold text-[var(--color-content)]">{{ title }}</h3>
        <p class="mt-2 text-sm leading-relaxed text-[var(--color-content-muted)]">{{ description }}</p>
        <slot />
        </div>
    </div>
</template>
