<script setup lang="ts">
import { computed } from 'vue'
import { classNames } from '@/utils'

const props = withDefaults(defineProps<{
    size?: 'sm' | 'md' | 'lg'
    class?: string
}>(), {
    size: 'md',
})

const sizeClass = computed(() => {
    switch (props.size) {
        case 'sm':
            return 'h-5 w-5 border-2'
        case 'lg':
            return 'h-10 w-10 border-3'
        default:
            return 'h-8 w-8 border-2'
    }
})
</script>

<template>
    <div
        role="status"
        aria-label="Chargement"
        :class="classNames(
            'animate-spin rounded-full border-[var(--color-ccm-gray-200)] border-t-[var(--color-ccm-blue)]',
            sizeClass,
            $props.class,
        )"
    >
        <span class="sr-only">Chargement…</span>
    </div>
</template>
