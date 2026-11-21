<script setup lang="ts">
import { classNames } from '@/utils'
import Icon from '@/Components/ui/icons/Icon.vue'

defineProps<{
    icon: string
    title: string
    description?: string
    class?: string
}>()
</script>

<template>
    <div :class="classNames('flex gap-4', $props.class)">
        <div
            class="flex h-12 w-12 shrink-0 items-center justify-center rounded-lg bg-[var(--color-action)]/10"
        >
            <Icon :name="icon" :size="24" class="text-[var(--color-link)]" />
        </div>
        <div>
            <h3 class="font-semibold text-[var(--color-content)]">{{ title }}</h3>
            <p v-if="description" class="mt-1 text-sm text-[var(--color-content-muted)]">
                {{ description }}
            </p>
        </div>
    </div>
</template>
