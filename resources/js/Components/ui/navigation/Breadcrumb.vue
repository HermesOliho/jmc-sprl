<script setup lang="ts">
import { Link } from '@inertiajs/vue3'
import { classNames } from '@/utils'
import Icon from '@/Components/ui/icons/Icon.vue'
import type { BreadcrumbItem } from '@/types'

defineProps<{
    items: BreadcrumbItem[]
    class?: string
}>()
</script>

<template>
    <nav :class="classNames('flex items-center gap-2 text-sm', $props.class)" aria-label="Fil d'Ariane">
        <Link
            href="/"
            class="text-[var(--color-ccm-gray-500)] transition-colors hover:text-[var(--color-ccm-blue)]"
        >
            <Icon name="home" :size="16" />
        </Link>
        <template v-for="(item, index) in items" :key="index">
            <Icon name="chevron-right" :size="14" class="text-[var(--color-ccm-gray-400)]" />
            <component
                :is="item.href ? Link : 'span'"
                :href="item.href"
                :class="classNames(
                    'transition-colors',
                    item.href
                        ? 'text-[var(--color-ccm-gray-500)] hover:text-[var(--color-ccm-blue)]'
                        : 'font-medium text-[var(--color-ccm-gray-900)]',
                )"
                :aria-current="!item.href ? 'page' : undefined"
            >
                {{ item.label }}
            </component>
        </template>
    </nav>
</template>
