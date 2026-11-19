<script setup lang="ts">
import { classNames } from '@/utils'

const props = withDefaults(defineProps<{
    class?: string
}>(), {})
</script>

<template>
    <hr
        :class="classNames(
            'border-t border-[var(--color-ccm-gray-200)]',
            $props.class,
        )"
    >
</template>
