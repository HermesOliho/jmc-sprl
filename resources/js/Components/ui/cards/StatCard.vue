<script setup lang="ts">
import { classNames } from '@/utils'
import Icon from '@/Components/ui/icons/Icon.vue'

defineProps<{
    label: string
    value: string
    icon?: string
    class?: string
}>()
</script>

<template>
    <div
        :class="classNames(
            'flex flex-col items-center rounded-xl border border-[var(--color-ccm-gray-200)] bg-white p-8 text-center shadow-sm',
            $props.class,
        )"
    >
        <div
            v-if="icon"
            class="mb-4 flex h-14 w-14 items-center justify-center rounded-full bg-[var(--color-ccm-blue)]/10"
        >
            <Icon :name="icon" :size="28" class="text-[var(--color-ccm-blue)]" />
        </div>
        <span class="text-4xl font-bold text-[var(--color-ccm-blue)]">{{ value }}</span>
        <span class="mt-2 text-sm text-[var(--color-ccm-gray-600)]">{{ label }}</span>
    </div>
</template>
