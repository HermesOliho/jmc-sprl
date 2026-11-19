<script setup lang="ts">
import { computed } from 'vue'
import { classNames } from '@/utils'
import type { HeadingLevel } from '@/types'

const props = withDefaults(defineProps<{
    as?: HeadingLevel
    class?: string
}>(), {
    as: 2,
})

const tag = computed(() => `h${props.as}` as const)

const sizeClass = computed(() => {
    switch (props.as) {
        case 1:
            return 'text-4xl md:text-5xl font-bold tracking-tight'
        case 3:
            return 'text-2xl font-semibold'
        case 4:
            return 'text-xl font-semibold'
        default:
            return 'text-3xl md:text-4xl font-bold tracking-tight'
    }
})
</script>

<template>
    <component
        :is="tag"
        :class="classNames('text-[var(--color-ccm-gray-900)]', sizeClass, $props.class)"
    >
        <slot />
    </component>
</template>
