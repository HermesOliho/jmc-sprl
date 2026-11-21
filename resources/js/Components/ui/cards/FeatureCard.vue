<script setup lang="ts">
import { classNames } from '@/utils'
import Icon from '@/Components/ui/icons/Icon.vue'
import ServiceIllustration from '@/Components/illustrations/ServiceIllustration.vue'

defineProps<{
    title: string
    description: string
    icon?: string
    class?: string
}>()
</script>

<template>
    <div
        :class="classNames(
            'group rounded-xl border border-[var(--color-border)] bg-[var(--color-surface)] p-6 shadow-sm transition-all duration-200 hover:shadow-md hover:-translate-y-1',
            $props.class,
        )"
    >
        <ServiceIllustration v-if="icon" :icon="icon" />
        <div
            v-if="icon"
            class="mb-4 flex h-12 w-12 items-center justify-center rounded-lg bg-[var(--color-action)]/10 transition-colors duration-200 group-hover:bg-[var(--color-action)]"
        >
            <Icon
                :name="icon"
                :size="24"
                class="text-[var(--color-link)] transition-colors duration-200 group-hover:text-white"
            />
        </div>
        <h3 class="text-lg font-semibold text-[var(--color-content)]">{{ title }}</h3>
        <p class="mt-2 text-sm leading-relaxed text-[var(--color-content-muted)]">{{ description }}</p>
        <slot />
    </div>
</template>
