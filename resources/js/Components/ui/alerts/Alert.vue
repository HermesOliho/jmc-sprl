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
                bg: 'bg-green-50 border-green-200',
                text: 'text-green-800',
                icon: 'circle-check',
            }
        case 'warning':
            return {
                bg: 'bg-amber-50 border-amber-200',
                text: 'text-amber-800',
                icon: 'triangle-alert',
            }
        case 'error':
            return {
                bg: 'bg-red-50 border-red-200',
                text: 'text-red-800',
                icon: 'circle-x',
            }
        default:
            return {
                bg: 'bg-blue-50 border-blue-200',
                text: 'text-blue-800',
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
