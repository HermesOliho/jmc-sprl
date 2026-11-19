<script setup lang="ts">
import { reactive } from 'vue'
import Container from '@/Components/ui/Container.vue'
import TextInput from '@/Components/ui/inputs/TextInput.vue'
import TextArea from '@/Components/ui/inputs/TextArea.vue'
import PrimaryButton from '@/Components/ui/buttons/PrimaryButton.vue'
import Icon from '@/Components/ui/icons/Icon.vue'
import { CONTACT_SUBJECTS } from '@/config/contact'
import type { ContactFormData } from '@/types'

const form = reactive<ContactFormData>({
    name: '',
    company: '',
    email: '',
    phone: '',
    subject: '',
    message: '',
    consent: false,
})

const errors = reactive<Partial<Record<keyof ContactFormData, string>>>({})

function validate(): boolean {
    Object.keys(errors).forEach((k) => delete errors[k as keyof ContactFormData])

    if (!form.name.trim()) errors.name = 'Le nom est requis.'
    if (!form.email.trim()) {
        errors.email = 'L\'email est requis.'
    } else if (!/^[^\s@]+@[^\s@]+\.[^\s@]+$/.test(form.email)) {
        errors.email = 'Email invalide.'
    }
    if (!form.subject) errors.subject = 'Veuillez choisir un sujet.'
    if (!form.message.trim()) errors.message = 'Le message est requis.'
    if (!form.consent) errors.consent = 'Vous devez accepter le traitement de vos données.'

    return Object.keys(errors).length === 0
}

function handleSubmit() {
    if (!validate()) return
    console.log('Form submitted (placeholder):', { ...form })
}
</script>

<template>
    <form class="space-y-5" @submit.prevent="handleSubmit" novalidate>
        <div class="grid gap-5 sm:grid-cols-2">
            <TextInput
                v-model="form.name"
                label="Nom complet"
                placeholder="Votre nom"
                required
                :error="errors.name"
            />
            <TextInput
                v-model="form.company"
                label="Entreprise"
                placeholder="Votre entreprise (optionnel)"
            />
        </div>

        <div class="grid gap-5 sm:grid-cols-2">
            <TextInput
                v-model="form.email"
                label="Email"
                type="email"
                placeholder="votre@email.com"
                required
                :error="errors.email"
            />
            <TextInput
                v-model="form.phone"
                label="Téléphone"
                type="tel"
                placeholder="+243 XX XXX XXXX"
            />
        </div>

        <div>
            <label class="mb-1.5 block text-sm font-medium text-[var(--color-ccm-gray-700)]">
                Sujet
                <span class="text-red-500">*</span>
            </label>
            <select
                v-model="form.subject"
                class="block w-full rounded-lg border border-[var(--color-ccm-gray-300)] bg-white px-4 py-3 text-sm text-[var(--color-ccm-gray-900)] transition-all duration-200 focus:border-[var(--color-ccm-blue)] focus:ring-2 focus:ring-[var(--color-ccm-blue)]/20 focus:outline-none"
                :class="{ 'border-red-300': errors.subject }"
                aria-label="Sujet"
            >
                <option value="" disabled>Sélectionnez un sujet</option>
                <option
                    v-for="s in CONTACT_SUBJECTS"
                    :key="s.value"
                    :value="s.value"
                >
                    {{ s.label }}
                </option>
            </select>
            <p
                v-if="errors.subject"
                class="mt-1 text-sm text-red-600"
                role="alert"
            >
                {{ errors.subject }}
            </p>
        </div>

        <TextArea
            v-model="form.message"
            label="Message"
            placeholder="Décrivez votre projet ou votre demande..."
            :rows="5"
            required
            :error="errors.message"
        />

        <div>
            <label class="flex items-start gap-3">
                <input
                    v-model="form.consent"
                    type="checkbox"
                    class="mt-1 h-4 w-4 rounded border-[var(--color-ccm-gray-300)] text-[var(--color-ccm-blue)] focus:ring-[var(--color-ccm-blue)]"
                />
                <span class="text-sm text-[var(--color-ccm-gray-600)]">
                    J'accepte que mes données soient traitées pour répondre à ma demande.
                    <span class="text-red-500">*</span>
                </span>
            </label>
            <p
                v-if="errors.consent"
                class="mt-1 text-sm text-red-600"
                role="alert"
            >
                {{ errors.consent }}
            </p>
        </div>

        <PrimaryButton type="submit" size="lg">
            <Icon name="send" :size="18" />
            Envoyer le message
        </PrimaryButton>
    </form>
</template>
