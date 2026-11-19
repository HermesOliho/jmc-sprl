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
            return 'bg-[var(--color-ccm-gray-50)]'
        case 'blue':
            return 'bg-[var(--color-ccm-blue)] text-white'
        case 'none':
            return ''
        default:
            return 'bg-white'
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
