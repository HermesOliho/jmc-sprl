<script setup lang="ts">
import { Link } from '@inertiajs/vue3'
import Container from '@/Components/ui/Container.vue'
import PrimaryButton from '@/Components/ui/buttons/PrimaryButton.vue'

defineProps<{
    status?: number
    title?: string
    description?: string
}>()

const errorMessages: Record<number, { title: string; description: string }> = {
    404: {
        title: 'Page introuvable',
        description: 'Désolé, la page que vous recherchez n\'existe pas ou a été déplacée.',
    },
    403: {
        title: 'Accès refusé',
        description: 'Vous n\'avez pas les autorisations nécessaires pour accéder à cette page.',
    },
    500: {
        title: 'Erreur serveur',
        description: 'Une erreur interne s\'est produite. Veuillez réessayer plus tard.',
    },
    503: {
        title: 'Service indisponible',
        description: 'Le service est temporairement indisponible. Veuillez réessayer plus tard.',
    },
}
</script>

<template>
    <div class="flex min-h-screen flex-col items-center justify-center bg-[var(--color-ccm-gray-50)] p-4">
        <Container class="text-center">
            <p class="text-8xl font-bold text-[var(--color-ccm-blue)] md:text-9xl">
                {{ status || 404 }}
            </p>
            <h1 class="mt-4 text-3xl font-bold text-[var(--color-ccm-gray-900)] md:text-4xl">
                {{ title || errorMessages[status || 404]?.title || 'Erreur' }}
            </h1>
            <p class="mx-auto mt-4 max-w-md text-lg text-[var(--color-ccm-gray-600)]">
                {{ description || errorMessages[status || 404]?.description || 'Une erreur est survenue.' }}
            </p>
            <div class="mt-8">
                <Link href="/">
                    <PrimaryButton>
                        Retour à l'accueil
                    </PrimaryButton>
                </Link>
            </div>
        </Container>
    </div>
</template>
