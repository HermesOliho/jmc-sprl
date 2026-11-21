<script setup lang="ts">
import { computed } from 'vue'
import { classNames } from '@/utils'
import type { BadgeVariant } from '@/types'

const props = withDefaults(defineProps<{
    variant?: BadgeVariant
    size?: 'sm' | 'md'
    class?: string
}>(), {
    variant: 'default',
    size: 'md',
})

const variantClass = computed(() => {
    switch (props.variant) {
        case 'primary':
            return 'bg-[var(--color-action)] text-white'
        case 'secondary':
            return 'bg-[var(--color-brand-orange)] text-[var(--color-on-accent)]'
        case 'success':
            return 'bg-[var(--color-success)]/15 text-[var(--color-success)]'
        case 'warning':
            return 'bg-[var(--color-warning)]/15 text-[var(--color-warning)]'
        case 'error':
            return 'bg-[var(--color-error)]/15 text-[var(--color-error)]'
        case 'info':
            return 'bg-[var(--color-info)]/15 text-[var(--color-info)]'
        default:
            return 'bg-[var(--color-border)] text-[var(--color-content)]'
    }
})

const sizeClass = computed(() => {
    switch (props.size) {
        case 'sm':
            return 'px-2 py-0.5 text-xs'
        default:
            return 'px-3 py-1 text-sm'
    }
})
</script>

<template>
    <span
        :class="classNames(
            'inline-flex items-center rounded-full font-medium',
            variantClass,
            sizeClass,
            $props.class,
        )"
    >
        <slot />
    </span>
</template>
