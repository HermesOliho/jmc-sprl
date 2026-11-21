<script setup lang="ts">
import { classNames } from '@/utils'
import Container from '@/Components/ui/Container.vue'

const props = withDefaults(defineProps<{
    class?: string
    background?: 'white' | 'gray' | 'blue' | 'none'
    containerWidth?: 'default' | 'narrow' | 'wide' | 'full'
    id?: string
}>(), {
    background: 'white',
    containerWidth: 'default',
})

const bgClass = computed(() => {
    switch (props.background) {
        case 'gray':
            return 'bg-[var(--color-surface-muted)]'
        case 'blue':
            return 'bg-[var(--color-brand-navy)] text-white'
        case 'none':
            return ''
        default:
            return 'bg-[var(--color-surface)]'
    }
})

import { computed } from 'vue'
</script>

<template>
    <section :id="id" :class="classNames('py-16 md:py-24', bgClass, $props.class)">
        <Container :width="containerWidth">
            <slot />
        </Container>
    </section>
</template>
