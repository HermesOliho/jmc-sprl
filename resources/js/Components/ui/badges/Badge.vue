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
            return 'bg-[var(--color-ccm-blue)] text-white'
        case 'secondary':
            return 'bg-[var(--color-ccm-yellow)] text-[var(--color-ccm-blue-dark)]'
        case 'success':
            return 'bg-green-100 text-green-800'
        case 'warning':
            return 'bg-amber-100 text-amber-800'
        case 'error':
            return 'bg-red-100 text-red-800'
        case 'info':
            return 'bg-blue-100 text-blue-800'
        default:
            return 'bg-[var(--color-ccm-gray-200)] text-[var(--color-ccm-gray-700)]'
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
