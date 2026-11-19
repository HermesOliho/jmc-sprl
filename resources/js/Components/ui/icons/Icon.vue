<script setup lang="ts">
import { computed } from 'vue'
import { classNames } from '@/utils'
import { iconRegistry } from '@/lib/icons'

const props = withDefaults(defineProps<{
    name: string
    size?: number
    class?: string
}>(), {
    size: 20,
})

const iconComponent = computed(() => iconRegistry[props.name])
</script>

<template>
    <component
        :is="iconComponent"
        v-if="iconComponent"
        :size="size"
        :class="classNames('inline-flex shrink-0', $props.class)"
        aria-hidden="true"
    />
    <svg
        v-else
        :width="size"
        :height="size"
        :class="classNames('inline-flex shrink-0', $props.class)"
        viewBox="0 0 24 24"
        fill="none"
        stroke="currentColor"
        stroke-width="1.5"
        stroke-linecap="round"
        stroke-linejoin="round"
        aria-hidden="true"
    >
        <slot />
    </svg>
</template>
