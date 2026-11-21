<script setup lang="ts">
withDefaults(
    defineProps<{
        type?: 'button' | 'submit' | 'reset';
    }>(),
    {
        type: 'button',
    },
);
</script>

<template>
    <button
        :type="type"
        class="inline-flex items-center rounded-md border border-[var(--color-border-strong)] bg-[var(--color-surface)] px-4 py-2 text-xs font-semibold uppercase tracking-widest text-[var(--color-content-muted)] shadow-sm transition duration-150 ease-in-out hover:bg-[var(--color-surface-muted)] focus:outline-none focus:ring-2 focus:ring-[var(--color-action)] focus:ring-offset-2 disabled:opacity-25"
    >
        <slot />
    </button>
</template>
