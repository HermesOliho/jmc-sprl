<script setup lang="ts">
import { ref, onMounted } from 'vue'
import { animate } from 'motion-v'

const props = withDefaults(defineProps<{
    delay?: number
    duration?: number
    once?: boolean
}>(), {
    delay: 0,
    duration: 0.4,
    once: true,
})

const target = ref<HTMLElement | null>(null)

onMounted(() => {
    if (!target.value) return
    animate(
        target.value,
        { opacity: [0, 1], scale: [0.9, 1] },
        { delay: props.delay, duration: props.duration },
    )
})
</script>

<template>
    <div ref="target">
        <slot />
    </div>
</template>
