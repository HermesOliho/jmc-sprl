<script setup lang="ts">
import Container from '@/Components/ui/Container.vue'
import Icon from '@/Components/ui/icons/Icon.vue'
import { COMPANY } from '@/config/company'
</script>

<template>
    <div
        class="flex h-80 items-center justify-center rounded-xl bg-[var(--color-ccm-gray-100)] md:h-96"
    >
        <div class="text-center">
            <div
                class="mx-auto flex h-16 w-16 items-center justify-center rounded-full bg-[var(--color-ccm-blue)]/10"
            >
                <Icon name="map-pin" :size="32" class="text-[var(--color-ccm-blue)]" />
            </div>
            <p class="mt-4 text-sm font-medium text-[var(--color-ccm-gray-600)]">
                Carte interactive
            </p>
            <p class="mt-1 text-xs text-[var(--color-ccm-gray-500)]">
                {{ COMPANY.address.street }}, {{ COMPANY.address.city }}
            </p>
            <p class="mt-1 text-xs text-[var(--color-ccm-gray-400)]">
                (Intégration Google Maps à venir)
            </p>
        </div>
    </div>
</template>
