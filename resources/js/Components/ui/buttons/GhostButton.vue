<script setup lang="ts">
import { computed } from 'vue'
import { classNames } from '@/utils'
import type { ButtonSize } from '@/types'

const props = withDefaults(defineProps<{
    size?: ButtonSize
    disabled?: boolean
    loading?: boolean
    class?: string
    type?: 'button' | 'submit' | 'reset'
}>(), {
    size: 'md',
    disabled: false,
    loading: false,
    type: 'button',
})

const emit = defineEmits<{
    click: [e: MouseEvent]
}>()

const sizeClass = computed(() => {
    switch (props.size) {
        case 'sm':
            return 'px-3 py-1.5 text-sm'
        case 'lg':
            return 'px-6 py-3 text-lg'
        default:
            return 'px-4 py-2 text-base'
    }
})
</script>

<template>
    <button
        :type="type"
        :disabled="disabled || loading"
        :class="classNames(
            'rounded-lg font-medium transition-all duration-200',
            'text-[var(--color-ccm-gray-600)] hover:bg-[var(--color-ccm-gray-100)] hover:text-[var(--color-ccm-blue)]',
            'focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-[var(--color-ccm-blue)]',
            'disabled:cursor-not-allowed disabled:opacity-50',
            'inline-flex items-center justify-center gap-2',
            sizeClass,
            $props.class,
        )"
        @click="emit('click', $event)"
    >
        <span v-if="loading" class="loading loading-spinner loading-sm" />
        <slot />
    </button>
</template>
