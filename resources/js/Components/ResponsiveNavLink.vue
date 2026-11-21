<script setup lang="ts">
import { computed } from 'vue';
import { Link } from '@inertiajs/vue3';

const props = defineProps<{
    href: string;
    active?: boolean;
}>();

const classes = computed(() =>
    props.active
        ? 'block w-full ps-3 pe-4 py-2 border-l-4 border-[var(--color-brand-orange)] text-start text-base font-medium text-[var(--color-link)] bg-[var(--color-action)]/10 focus:outline-none focus:text-[var(--color-link)] focus:bg-[var(--color-action)]/15 focus:border-[var(--color-brand-orange)] transition duration-150 ease-in-out'
        : 'block w-full ps-3 pe-4 py-2 border-l-4 border-transparent text-start text-base font-medium text-[var(--color-content-muted)] hover:text-[var(--color-content)] hover:bg-[var(--color-surface-elevated)] hover:border-[var(--color-border-strong)] focus:outline-none focus:text-[var(--color-content)] focus:bg-[var(--color-surface-elevated)] focus:border-[var(--color-border-strong)] transition duration-150 ease-in-out',
);
</script>

<template>
    <Link :href="href" :class="classes">
        <slot />
    </Link>
</template>
