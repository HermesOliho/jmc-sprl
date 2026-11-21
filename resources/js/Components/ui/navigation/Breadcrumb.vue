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
            class="text-[var(--color-content-subtle)] transition-colors hover:text-[var(--color-link)]"
        >
            <Icon name="home" :size="16" />
        </Link>
        <template v-for="(item, index) in items" :key="index">
            <Icon name="chevron-right" :size="14" class="text-[var(--color-content-placeholder)]" />
            <component
                :is="item.href ? Link : 'span'"
                :href="item.href"
                :class="classNames(
                    'transition-colors',
                    item.href
                        ? 'text-[var(--color-content-subtle)] hover:text-[var(--color-link)]'
                        : 'font-medium text-[var(--color-content)]',
                )"
                :aria-current="!item.href ? 'page' : undefined"
            >
                {{ item.label }}
            </component>
        </template>
    </nav>
</template>
