<script setup lang="ts">
import { ref, onMounted } from 'vue'
import { animate } from 'motion-v'

const props = withDefaults(defineProps<{
    delay?: number
    duration?: number
    distance?: number
    once?: boolean
}>(), {
    delay: 0,
    duration: 0.5,
    distance: 40,
    once: true,
})

const target = ref<HTMLElement | null>(null)

onMounted(() => {
    if (!target.value) return
    animate(
        target.value,
        { opacity: [0, 1], y: [props.distance, 0] },
        { delay: props.delay, duration: props.duration },
    )
})
</script>

<template>
    <div ref="target">
        <slot />
    </div>
</template>
