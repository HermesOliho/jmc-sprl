<script setup lang="ts">
import Header from '@/Components/layout/Header.vue'
import Footer from '@/Components/layout/Footer.vue'
</script>

<template>
    <div class="flex min-h-screen flex-col">
        <Header />
        <main class="flex-1 pt-20">
            <slot />
        </main>
        <Footer />
    </div>
</template>
