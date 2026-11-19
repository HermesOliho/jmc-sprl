<script setup lang="ts">
import { Head } from '@inertiajs/vue3'
import { computed } from 'vue'
import type { MetaInfo } from '@/types'
import { APP_NAME, APP_DESCRIPTION } from '@/constants'

const props = withDefaults(defineProps<{
    title?: string
    description?: string
    canonical?: string
    ogImage?: string
    ogType?: string
    twitterCard?: string
}>(), {
    description: APP_DESCRIPTION,
    ogType: 'website',
    twitterCard: 'summary_large_image',
})

const pageTitle = computed(() => {
    if (!props.title || props.title === APP_NAME) return APP_NAME
    return `${props.title} — ${APP_NAME}`
})
</script>

<template>
    <Head>
        <title>{{ pageTitle }}</title>
        <meta name="description" :content="description" />
        <meta property="og:title" :content="pageTitle" />
        <meta property="og:description" :content="description" />
        <meta property="og:type" :content="ogType" />
        <meta v-if="ogImage" property="og:image" :content="ogImage" />
        <meta v-if="canonical" property="og:url" :content="canonical" />
        <meta name="twitter:card" :content="twitterCard" />
        <meta name="twitter:title" :content="pageTitle" />
        <meta name="twitter:description" :content="description" />
        <link v-if="canonical" rel="canonical" :href="canonical" />
    </Head>
    <slot />
</template>
