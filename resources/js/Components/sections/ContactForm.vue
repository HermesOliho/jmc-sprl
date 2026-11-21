<script setup lang="ts">
import { computed, onMounted, ref } from 'vue'
import { useForm, usePage } from '@inertiajs/vue3'
import TextInput from '@/Components/ui/inputs/TextInput.vue'
import TextArea from '@/Components/ui/inputs/TextArea.vue'
import PrimaryButton from '@/Components/ui/buttons/PrimaryButton.vue'
import Icon from '@/Components/ui/icons/Icon.vue'
import { useSite } from '@/composables'
import { ALL_SERVICES } from '@/config/services'

const site = useSite()
const page = usePage()

const form = useForm({
    name: '',
    company: '',
    email: '',
    phone: '',
    subject: '',
    message: '',
    consent: false,
    website: '',
})

const flash = computed(() => page.props.flash as { status?: string; error?: string } | undefined)
const successMessage = ref('')

onMounted(() => {
    if (typeof window === 'undefined') {
        return
    }

    const params = new URLSearchParams(window.location.search)
    const subject = params.get('subject')
    const service = params.get('service')

    if (subject && site.contact_subjects.some((item) => item.value === subject)) {
        form.subject = subject
    }

    if (service) {
        const selected = ALL_SERVICES.find((item) => item.slug === service)

        if (selected && !form.message) {
            form.subject = form.subject || 'devis'
            form.message = `Je souhaite obtenir un devis pour le service : ${selected.title}.`
        }
    }
})

function submit(): void {
    successMessage.value = ''
    form.post('/contact', {
        preserveScroll: true,
        onSuccess: (page) => {
            const incoming = page.props.flash as { status?: string; error?: string } | undefined
            successMessage.value = incoming?.error ? '' : (incoming?.status ?? 'Votre message a bien été transmis.')
            form.reset('name', 'company', 'email', 'phone', 'subject', 'message', 'consent', 'website')
        },
    })
}
</script>

<template>
    <div>
        <div
            v-if="successMessage || flash?.status"
            class="mb-5 rounded-lg border border-[var(--color-success)]/30 bg-[var(--color-success)]/10 px-4 py-3 text-sm text-[var(--color-success)]"
            role="status"
        >
            {{ successMessage || flash?.status }}
        </div>
        <div
            v-if="flash?.error"
            class="mb-5 rounded-lg border border-[var(--color-error)]/30 bg-[var(--color-error)]/10 px-4 py-3 text-sm text-[var(--color-error)]"
            role="alert"
        >
            {{ flash.error }}
        </div>

        <form class="space-y-5" @submit.prevent="submit" novalidate>
            <div class="hidden" aria-hidden="true">
                <label for="website">Site web</label>
                <input
                    id="website"
                    v-model="form.website"
                    type="text"
                    tabindex="-1"
                    autocomplete="off"
                />
            </div>

            <div class="grid gap-5 sm:grid-cols-2">
                <TextInput
                    v-model="form.name"
                    label="Nom complet"
                    placeholder="Votre nom"
                    required
                    :error="form.errors.name"
                />
                <TextInput
                    v-model="form.company"
                    label="Entreprise"
                    placeholder="Votre entreprise (optionnel)"
                    :error="form.errors.company"
                />
            </div>

            <div class="grid gap-5 sm:grid-cols-2">
                <TextInput
                    v-model="form.email"
                    label="E-mail"
                    type="email"
                    placeholder="votre@email.com"
                    required
                    :error="form.errors.email"
                />
                <TextInput
                    v-model="form.phone"
                    label="Téléphone"
                    type="tel"
                    placeholder="+243 XX XXX XXXX"
                    :error="form.errors.phone"
                />
            </div>

            <div>
                <label for="subject" class="mb-1.5 block text-sm font-medium text-[var(--color-content)]">
                    Sujet
                    <span class="text-[var(--color-error)]">*</span>
                </label>
                <select
                    id="subject"
                    v-model="form.subject"
                    class="block w-full rounded-lg border border-[var(--color-border-strong)] bg-[var(--color-surface)] px-4 py-3 text-sm text-[var(--color-content)] transition-all duration-200 focus:border-[var(--color-action)] focus:ring-2 focus:ring-[var(--color-action)]/20 focus:outline-none"
                    :aria-invalid="!!form.errors.subject"
                    :aria-describedby="form.errors.subject ? 'subject-error' : undefined"
                    required
                >
                    <option value="" disabled>Sélectionnez un sujet</option>
                    <option
                        v-for="subject in site.contact_subjects"
                        :key="subject.value"
                        :value="subject.value"
                    >
                        {{ subject.label }}
                    </option>
                </select>
                <p
                    v-if="form.errors.subject"
                    id="subject-error"
                    class="mt-1 text-sm text-[var(--color-error)]"
                    role="alert"
                >
                    {{ form.errors.subject }}
                </p>
            </div>

            <TextArea
                v-model="form.message"
                label="Message"
                placeholder="Décrivez votre projet ou votre demande..."
                :rows="6"
                required
                :error="form.errors.message"
            />

            <div>
                <label class="flex items-start gap-3">
                    <input
                        v-model="form.consent"
                        type="checkbox"
                        class="mt-1 h-4 w-4 rounded border-[var(--color-border-strong)] text-[var(--color-action)] focus:ring-[var(--color-action)]"
                    />
                    <span class="text-sm text-[var(--color-content-muted)]">
                        J'accepte que mes données soient traitées pour répondre à ma demande.
                        <span class="text-[var(--color-error)]">*</span>
                    </span>
                </label>
                <p
                    v-if="form.errors.consent"
                    class="mt-1 text-sm text-[var(--color-error)]"
                    role="alert"
                >
                    {{ form.errors.consent }}
                </p>
            </div>

            <PrimaryButton type="submit" size="lg" :disabled="form.processing">
                <Icon name="send" :size="18" />
                {{ form.processing ? 'Envoi en cours…' : 'Envoyer le message' }}
            </PrimaryButton>
        </form>
    </div>
</template>
