<script setup lang="ts">
import Icon from '@/Components/ui/icons/Icon.vue'
import { useSite } from '@/composables'
import { formatAddress } from '@/utils'

interface ContactLine {
    text: string
    href?: string
    external?: boolean
}

interface ContactInfoItem {
    icon: string
    label: string
    lines: ContactLine[]
}

const site = useSite()

const websiteLabel = site.contact.website.replace(/^https?:\/\//, '').replace(/\/$/, '')

const items: ContactInfoItem[] = [
    ...(site.contact.phones.length > 0
        ? [{
            icon: 'phone',
            label: 'Téléphone',
            lines: site.contact.phones.map((phone) => ({
                text: `${phone.display} (${phone.label})`,
                href: `tel:${phone.e164}`,
            })),
        }]
        : []),
    ...(site.contact.whatsapp
        ? [{
            icon: 'message-circle',
            label: 'WhatsApp',
            lines: [{
                text: site.contact.whatsapp.display,
                href: site.contact.whatsapp.url,
                external: true,
            }],
        }]
        : []),
    ...(site.contact.email
        ? [{
            icon: 'mail',
            label: 'E-mail',
            lines: [{ text: site.contact.email, href: `mailto:${site.contact.email}` }],
        }]
        : []),
    ...(site.contact.website
        ? [{
            icon: 'globe',
            label: 'Site web',
            lines: [{ text: websiteLabel, href: site.contact.website, external: true }],
        }]
        : []),
    ...(site.contact.address.city
        ? [{
            icon: 'map-pin',
            label: 'Localisation',
            lines: [{ text: formatAddress(site.contact.address) }],
        }]
        : []),
    ...(site.contact.hours
        ? [{ icon: 'clock', label: 'Horaires', lines: [{ text: site.contact.hours }] }]
        : []),
]
</script>

<template>
    <div class="space-y-6">
        <div
            v-for="item in items"
            :key="item.label"
            class="flex gap-4 rounded-xl border border-[var(--color-border)] bg-[var(--color-surface)] p-5 shadow-sm"
        >
            <div
                class="flex h-12 w-12 shrink-0 items-center justify-center rounded-lg bg-[var(--color-action)]/10"
            >
                <Icon :name="item.icon" :size="22" class="text-[var(--color-link)]" />
            </div>
            <div class="min-w-0">
                <p class="text-sm font-medium text-[var(--color-content-subtle)]">
                    {{ item.label }}
                </p>
                <p
                    v-for="line in item.lines"
                    :key="line.text"
                    class="mt-0.5 text-base font-semibold text-[var(--color-content)]"
                >
                    <component
                        :is="line.href ? 'a' : 'span'"
                        :href="line.href"
                        :target="line.external ? '_blank' : undefined"
                        :rel="line.external ? 'noopener noreferrer' : undefined"
                        :class="line.href && 'transition-colors hover:text-[var(--color-link)]'"
                    >
                        {{ line.text }}
                    </component>
                </p>
            </div>
        </div>

        <p v-if="items.length === 0" class="rounded-xl border border-[var(--color-border)] bg-[var(--color-surface)] p-5 text-sm text-[var(--color-content-muted)]">
            Les coordonnées détaillées seront publiées prochainement. Utilisez le formulaire pour nous contacter.
        </p>
    </div>
</template>
