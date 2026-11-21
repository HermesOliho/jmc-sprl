<script setup lang="ts">
import { computed } from 'vue';
import { Link } from '@inertiajs/vue3';

const props = defineProps<{
    href: string;
    active?: boolean;
}>();

const classes = computed(() =>
    props.active
        ? 'inline-flex items-center px-1 pt-1 border-b-2 border-[var(--color-brand-orange)] text-sm font-medium leading-5 text-[var(--color-content)] focus:outline-none focus:border-[var(--color-brand-orange)] transition duration-150 ease-in-out'
        : 'inline-flex items-center px-1 pt-1 border-b-2 border-transparent text-sm font-medium leading-5 text-[var(--color-content-muted)] hover:text-[var(--color-content)] hover:border-[var(--color-border-strong)] focus:outline-none focus:text-[var(--color-content)] focus:border-[var(--color-border-strong)] transition duration-150 ease-in-out',
);
</script>

<template>
    <Link :href="href" :class="classes">
        <slot />
    </Link>
</template>
