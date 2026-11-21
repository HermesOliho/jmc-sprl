<script setup lang="ts">
import { computed } from 'vue'
import { classNames } from '@/utils'

const props = withDefaults(defineProps<{
    size?: 'lg' | 'base' | 'sm' | 'xs'
    as?: 'p' | 'span' | 'div'
    class?: string
}>(), {
    size: 'base',
    as: 'p',
})

const sizeClass = computed(() => {
    switch (props.size) {
        case 'lg':
            return 'text-lg leading-relaxed'
        case 'sm':
            return 'text-sm leading-relaxed'
        case 'xs':
            return 'text-xs leading-relaxed'
        default:
            return 'text-base leading-relaxed'
    }
})
</script>

<template>
    <component
        :is="as"
        :class="classNames('text-[var(--color-content-muted)]', sizeClass, $props.class)"
    >
        <slot />
    </component>
</template>
