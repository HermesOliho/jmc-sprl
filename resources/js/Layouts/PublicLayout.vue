<script setup lang="ts">
import Header from '@/Components/layout/Header.vue'
import Footer from '@/Components/layout/Footer.vue'
</script>

<template>
    <div class="flex min-h-screen flex-col">
        <a
            href="#main-content"
            class="sr-only focus:not-sr-only focus:fixed focus:top-4 focus:left-4 focus:z-50 focus:rounded-lg focus:bg-[var(--color-surface)] focus:px-4 focus:py-2 focus:text-[var(--color-content)] focus:shadow-lg"
        >
            Aller au contenu principal
        </a>
        <Header />
        <main id="main-content" class="flex-1 pt-20">
            <slot />
        </main>
        <Footer />
    </div>
</template>
