<script setup lang="ts">
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue'
import AlbumForm from '@/Pages/Admin/Albums/Partials/AlbumForm.vue'
import { Head } from '@inertiajs/vue3'
</script>

<template>
    <Head title="Nouvel album" />

    <AuthenticatedLayout>
        <template #header>
            <div>
                <h2 class="text-xl font-semibold leading-tight text-[var(--color-content)]">
                    Nouvel album
                </h2>
                <p class="mt-1 text-sm text-[var(--color-content-muted)]">
                    Créez l’album, puis ajoutez-y des photos depuis la page de gestion.
                </p>
            </div>
        </template>

        <div class="py-12">
            <div class="mx-auto max-w-3xl sm:px-6 lg:px-8">
                <div class="bg-[var(--color-surface)] p-6 shadow-sm sm:rounded-lg">
                    <AlbumForm />
                </div>
            </div>
        </div>
    </AuthenticatedLayout>
</template>
