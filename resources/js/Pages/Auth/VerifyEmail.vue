<script setup lang="ts">
import { computed } from 'vue';
import GuestLayout from '@/Layouts/GuestLayout.vue';
import PrimaryButton from '@/Components/PrimaryButton.vue';
import { Head, Link, useForm } from '@inertiajs/vue3';

const props = defineProps<{
    status?: string;
}>();

const form = useForm({});

const submit = () => {
    form.post(route('verification.send'));
};

const verificationLinkSent = computed(
    () => props.status === 'verification-link-sent',
);
</script>

<template>
    <GuestLayout>
        <Head title="Vérification de l’e-mail" />

        <div class="mb-4 text-sm text-[var(--color-content-muted)]">
            Merci de votre inscription. Vérifiez votre adresse e-mail en cliquant sur le lien que nous venons de vous envoyer. Si vous ne l’avez pas reçu, nous pouvons vous en envoyer un nouveau.
        </div>

        <div
            class="mb-4 text-sm font-medium text-[var(--color-success)]"
            v-if="verificationLinkSent"
        >
            Un nouveau lien de vérification a été envoyé à l’adresse indiquée lors de l’inscription.
        </div>

        <form @submit.prevent="submit">
            <div class="mt-4 flex items-center justify-between">
                <PrimaryButton
                    :class="{ 'opacity-25': form.processing }"
                    :disabled="form.processing"
                >
                    Renvoyer l’e-mail de vérification
                </PrimaryButton>

                <Link
                    :href="route('logout')"
                    method="post"
                    as="button"
                    class="rounded-md text-sm text-[var(--color-content-muted)] underline hover:text-[var(--color-content)] focus:outline-none focus:ring-2 focus:ring-[var(--color-action)] focus:ring-offset-2"
                    >Se déconnecter</Link
                >
            </div>
        </form>
    </GuestLayout>
</template>
