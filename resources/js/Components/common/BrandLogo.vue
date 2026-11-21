<script setup lang="ts">
import { computed } from 'vue'
import { useTheme } from '@/composables/useTheme'
import { useSite } from '@/composables/useSite'
import logoLight from '../../../images/logo.svg'
import logoDark from '../../../images/logo_for_dark_bg-512.webp'

type Variant = 'auto' | 'light' | 'dark'
type Context = 'header' | 'footer' | 'hero' | 'auth'

const props = withDefaults(defineProps<{
    variant?: Variant
    context?: Context
    alt?: string
}>(), {
    variant: 'auto',
    context: 'header',
})

const { theme } = useTheme()
const site = useSite()

const resolvedVariant = computed<'light' | 'dark'>(() => {
    if (props.variant === 'light' || props.variant === 'dark') {
        return props.variant
    }

    return theme.value === 'dark' ? 'dark' : 'light'
})

const src = computed(() => (resolvedVariant.value === 'dark' ? logoDark : logoLight))
const alt = computed(() => props.alt ?? site.name)

const sizeClass = computed(() => {
    switch (props.context) {
        case 'footer':
            return 'h-14 w-auto'
        case 'hero':
            return 'h-28 w-auto md:h-36'
        case 'auth':
            return 'h-24 w-auto'
        default:
            return 'h-14 w-auto md:h-16'
    }
})
</script>

<template>
    <img
        :src="src"
        :alt="alt"
        :class="sizeClass"
        decoding="async"
        :fetchpriority="context === 'header' ? 'high' : 'auto'"
    />
</template>
