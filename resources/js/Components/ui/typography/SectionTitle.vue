<script setup lang="ts">
import { classNames } from '@/utils'
import type { HeadingLevel } from '@/types'

const props = withDefaults(defineProps<{
    as?: HeadingLevel
    align?: 'left' | 'center' | 'right'
    subtitle?: string
    class?: string
}>(), {
    as: 2,
    align: 'center',
})

const tag = computed(() => `h${props.as}` as const)
const sizeClass = computed(() => {
    switch (props.as) {
        case 1:
            return 'text-4xl md:text-5xl lg:text-6xl'
        case 3:
            return 'text-2xl md:text-3xl'
        case 4:
            return 'text-xl md:text-2xl'
        default:
            return 'text-3xl md:text-4xl'
    }
})

import { computed } from 'vue'
</script>

<template>
    <div :class="classNames('mb-12', align === 'center' && 'text-center', align === 'right' && 'text-right')">
        <component
            :is="tag"
            :class="classNames('font-bold tracking-tight text-[var(--color-content)]', sizeClass, $props.class)"
        >
            <slot />
        </component>
        <p
            v-if="subtitle"
            class="mx-auto mt-4 max-w-2xl text-lg text-[var(--color-content-muted)]"
        >
            {{ subtitle }}
        </p>
    </div>
</template>
