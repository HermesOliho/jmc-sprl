<script setup lang="ts">
import { classNames } from '@/utils'
import Icon from '@/Components/ui/icons/Icon.vue'

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
            'group rounded-xl border border-[var(--color-ccm-gray-200)] bg-white p-6 shadow-sm transition-all duration-200 hover:shadow-md hover:-translate-y-1',
            $props.class,
        )"
    >
        <div
            v-if="icon"
            class="mb-4 flex h-12 w-12 items-center justify-center rounded-lg bg-[var(--color-ccm-blue)]/10 transition-colors duration-200 group-hover:bg-[var(--color-ccm-blue)]"
        >
            <Icon
                :name="icon"
                :size="24"
                class="text-[var(--color-ccm-blue)] transition-colors duration-200 group-hover:text-white"
            />
        </div>
        <h3 class="text-lg font-semibold text-[var(--color-ccm-gray-900)]">{{ title }}</h3>
        <p class="mt-2 text-sm leading-relaxed text-[var(--color-ccm-gray-600)]">{{ description }}</p>
        <slot />
    </div>
</template>
