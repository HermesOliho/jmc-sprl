<script setup lang="ts">
import { computed } from 'vue'
import { classNames } from '@/utils'
import type { AlertType } from '@/types'
import Icon from '@/Components/ui/icons/Icon.vue'

const props = withDefaults(defineProps<{
    type?: AlertType
    dismissible?: boolean
    class?: string
}>(), {
    type: 'info',
    dismissible: false,
})

const emit = defineEmits<{
    dismiss: []
}>()

const visible = ref(true)

const typeConfig = computed(() => {
    switch (props.type) {
        case 'success':
            return {
                bg: 'bg-[var(--color-success)]/10 border-[var(--color-success)]/30',
                text: 'text-[var(--color-success)]',
                icon: 'circle-check',
            }
        case 'warning':
            return {
                bg: 'bg-[var(--color-warning)]/10 border-[var(--color-warning)]/30',
                text: 'text-[var(--color-warning)]',
                icon: 'triangle-alert',
            }
        case 'error':
            return {
                bg: 'bg-[var(--color-error)]/10 border-[var(--color-error)]/30',
                text: 'text-[var(--color-error)]',
                icon: 'circle-x',
            }
        default:
            return {
                bg: 'bg-[var(--color-info)]/10 border-[var(--color-info)]/30',
                text: 'text-[var(--color-info)]',
                icon: 'info',
            }
    }
})

import { ref } from 'vue'

function handleDismiss() {
    visible.value = false
    emit('dismiss')
}
</script>

<template>
    <div
        v-if="visible"
        role="alert"
        :class="classNames(
            'flex items-start gap-3 rounded-lg border p-4',
            typeConfig.bg,
            typeConfig.text,
            $props.class,
        )"
    >
        <Icon :name="typeConfig.icon" :size="20" class="mt-0.5 shrink-0" />
        <div class="flex-1 text-sm">
            <slot />
        </div>
        <button
            v-if="dismissible"
            type="button"
            class="shrink-0 opacity-60 hover:opacity-100"
            aria-label="Fermer"
            @click="handleDismiss"
        >
            <Icon name="x" :size="16" />
        </button>
    </div>
</template>
