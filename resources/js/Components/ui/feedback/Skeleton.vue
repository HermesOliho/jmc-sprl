<script setup lang="ts">
import { classNames } from '@/utils'

const props = withDefaults(defineProps<{
    class?: string
    variant?: 'text' | 'circular' | 'rectangular'
    width?: string
    height?: string
}>(), {
    variant: 'text',
})
</script>

<template>
    <div
        :class="classNames(
            'animate-pulse bg-[var(--color-border)]',
            variant === 'circular' && 'rounded-full',
            variant === 'rectangular' && 'rounded-lg',
            variant === 'text' && 'h-4 w-full rounded',
            $props.class,
        )"
        :style="{ width, height }"
        aria-hidden="true"
    />
</template>
