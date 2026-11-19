<script setup lang="ts">
import { classNames } from '@/utils'

const props = withDefaults(defineProps<{
    class?: string
}>(), {})
</script>

<template>
    <span
        :class="classNames(
            'inline-flex items-center rounded-md bg-[var(--color-ccm-gray-100)] px-2.5 py-1 text-sm font-medium text-[var(--color-ccm-gray-700)]',
            $props.class,
        )"
    >
        <slot />
    </span>
</template>
