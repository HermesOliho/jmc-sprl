<script setup lang="ts">
import { classNames } from '@/utils'

const props = withDefaults(defineProps<{
    padding?: 'none' | 'sm' | 'md' | 'lg'
    hover?: boolean
    class?: string
}>(), {
    padding: 'md',
    hover: false,
})

const paddingClass = computed(() => {
    switch (props.padding) {
        case 'none':
            return ''
        case 'sm':
            return 'p-4'
        case 'lg':
            return 'p-8'
        default:
            return 'p-6'
    }
})

import { computed } from 'vue'
</script>

<template>
    <div
        :class="classNames(
            'rounded-xl border border-[var(--color-border)] bg-[var(--color-surface)] shadow-sm',
            hover && 'transition-all duration-200 hover:shadow-md hover:-translate-y-0.5',
            paddingClass,
            $props.class,
        )"
    >
        <slot />
    </div>
</template>
