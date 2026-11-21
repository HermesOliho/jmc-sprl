<script setup lang="ts">
import { ref, onMounted } from 'vue'
import { animate } from 'motion-v'
import { shouldReduceMotion } from '@/utils'

const props = withDefaults(defineProps<{
    delay?: number
    duration?: number
    once?: boolean
}>(), {
    delay: 0,
    duration: 0.5,
    once: true,
})

const target = ref<HTMLElement | null>(null)

onMounted(() => {
    if (!target.value || shouldReduceMotion()) return
    animate(
        target.value,
        { opacity: [0, 1] },
        { delay: props.delay, duration: props.duration },
    )
})
</script>

<template>
    <div ref="target">
        <slot />
    </div>
</template>
