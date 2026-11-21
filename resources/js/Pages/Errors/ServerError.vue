<script setup lang="ts">
import ErrorLayout from '@/Layouts/ErrorLayout.vue'

withDefaults(defineProps<{ status?: number }>(), {
    status: 500,
})
</script>

<template>
    <ErrorLayout :status="status" />
</template>
