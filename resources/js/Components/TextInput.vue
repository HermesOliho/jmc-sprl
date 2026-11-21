<script setup lang="ts">
import { onMounted, ref } from 'vue';

const model = defineModel<string | number>({ required: true });

const input = ref<HTMLInputElement | null>(null);

onMounted(() => {
    if (input.value?.hasAttribute('autofocus')) {
        input.value?.focus();
    }
});

defineExpose({ focus: () => input.value?.focus() });
</script>

<template>
    <input
        class="rounded-md border-[var(--color-border-strong)] bg-[var(--color-surface)] text-[var(--color-content)] shadow-sm focus:border-[var(--color-action)] focus:ring-[var(--color-action)]"
        v-model="model"
        ref="input"
    />
</template>
