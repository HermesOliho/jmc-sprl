<script setup lang="ts">
import { computed } from 'vue'
import { classNames } from '@/utils'
import type { ContainerWidth } from '@/types'

const props = withDefaults(defineProps<{
    width?: ContainerWidth
    class?: string
}>(), {
    width: 'default',
})

const widthClass = computed(() => {
    switch (props.width) {
        case 'narrow':
            return 'max-w-(--container-narrow)'
        case 'wide':
            return 'max-w-(--container-wide)'
        case 'full':
            return 'max-w-full'
        default:
            return 'max-w-(--container-max)'
    }
})
</script>

<template>
    <div
        :class="classNames('mx-auto w-full px-4 sm:px-6 lg:px-8', widthClass, $props.class)"
    >
        <slot />
    </div>
</template>
