<script setup lang="ts">
import { classNames } from '@/utils'
import Icon from '@/Components/ui/icons/Icon.vue'

defineProps<{
    icon?: string
    title: string
    description?: string
    class?: string
}>()
</script>

<template>
    <div
        :class="classNames(
            'flex flex-col items-center justify-center py-16 text-center',
            $props.class,
        )"
    >
        <div
            v-if="icon"
            class="mb-4 flex h-16 w-16 items-center justify-center rounded-full bg-[var(--color-surface-elevated)]"
        >
            <Icon :name="icon" :size="32" class="text-[var(--color-content-placeholder)]" />
        </div>
        <h3 class="text-lg font-semibold text-[var(--color-content)]">{{ title }}</h3>
        <p v-if="description" class="mt-2 max-w-md text-sm text-[var(--color-content-subtle)]">
            {{ description }}
        </p>
        <div v-if="$slots.default" class="mt-6">
            <slot />
        </div>
    </div>
</template>
