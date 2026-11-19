<script setup lang="ts">
import Container from '@/Components/ui/Container.vue'
import Icon from '@/Components/ui/icons/Icon.vue'
import { COMPANY } from '@/config/company'

export interface ContactInfoItem {
    icon: string
    label: string
    value: string
    href?: string
}

const items: ContactInfoItem[] = [
    {
        icon: 'phone',
        label: 'Téléphone',
        value: COMPANY.phone,
        href: `tel:${COMPANY.phone.replace(/\s/g, '')}`,
    },
    {
        icon: 'mail',
        label: 'Email',
        value: COMPANY.email,
        href: `mailto:${COMPANY.email}`,
    },
    {
        icon: 'map-pin',
        label: 'Adresse',
        value: `${COMPANY.address.street}, ${COMPANY.address.city}`,
    },
    {
        icon: 'clock',
        label: 'Horaires',
        value: COMPANY.hours,
    },
]
</script>

<template>
    <div class="space-y-6">
        <div
            v-for="item in items"
            :key="item.label"
            class="flex gap-4 rounded-xl border border-[var(--color-ccm-gray-200)] bg-white p-5 shadow-sm"
        >
            <div
                class="flex h-12 w-12 shrink-0 items-center justify-center rounded-lg bg-[var(--color-ccm-blue)]/10"
            >
                <Icon :name="item.icon" :size="22" class="text-[var(--color-ccm-blue)]" />
            </div>
            <div class="min-w-0">
                <p class="text-sm font-medium text-[var(--color-ccm-gray-500)]">
                    {{ item.label }}
                </p>
                <component
                    :is="item.href ? 'a' : 'p'"
                    :href="item.href"
                    :class="[
                        'mt-0.5 text-base font-semibold text-[var(--color-ccm-gray-900)]',
                        item.href && 'transition-colors hover:text-[var(--color-ccm-blue)]',
                    ]"
                >
                    {{ item.value }}
                </component>
            </div>
        </div>
    </div>
</template>
