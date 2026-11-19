<script setup lang="ts">
import { ref, onMounted, nextTick } from 'vue'
import { animate } from 'motion-v'

const props = withDefaults(defineProps<{
    delay?: number
    stagger?: number
    duration?: number
    once?: boolean
}>(), {
    delay: 0,
    stagger: 0.1,
    duration: 0.4,
    once: true,
})

const container = ref<HTMLElement | null>(null)

onMounted(async () => {
    await nextTick()
    if (!container.value) return
    const items = Array.from(container.value.children) as HTMLElement[]

    items.forEach((child, i) => {
        animate(
            child,
            { opacity: [0, 1], y: [20, 0] },
            { delay: props.delay + i * props.stagger, duration: props.duration },
        )
    })
})
</script>

<template>
    <div ref="container">
        <slot />
    </div>
</template>
