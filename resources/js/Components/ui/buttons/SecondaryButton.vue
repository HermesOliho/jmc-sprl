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
            return 'px-4 py-2 text-sm'
        case 'lg':
            return 'px-8 py-3.5 text-lg'
        default:
            return 'px-6 py-3 text-base'
    }
})
</script>

<template>
    <button
        :type="type"
        :disabled="disabled || loading"
        :class="classNames(
            'btn rounded-lg border-0 font-semibold transition-all duration-200',
            'bg-[var(--color-brand-orange)] text-[var(--color-on-accent)] hover:bg-[var(--color-brand-orange-light)]',
            'focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-[var(--color-brand-orange)]',
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
