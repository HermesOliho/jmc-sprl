<script setup lang="ts">
import { Link } from '@inertiajs/vue3'
import Icon from '@/Components/ui/icons/Icon.vue'
import Badge from '@/Components/ui/badges/Badge.vue'
import type { ServiceDetail } from '@/types'

defineProps<{
    service: ServiceDetail
}>()
</script>

<template>
    <div class="group overflow-hidden rounded-xl border border-[var(--color-ccm-gray-200)] bg-white shadow-sm transition-all duration-200 hover:shadow-md">
        <div class="relative aspect-[16/9] overflow-hidden">
            <img
                :src="service.image"
                :alt="service.title"
                class="h-full w-full object-cover transition-transform duration-500 group-hover:scale-105"
                width="800"
                height="600"
                loading="lazy"
            />
            <div class="absolute inset-0 bg-gradient-to-t from-black/40 to-transparent" />
            <div
                class="absolute bottom-4 left-4 flex h-12 w-12 items-center justify-center rounded-xl bg-white shadow-lg"
            >
                <Icon :name="service.icon" :size="24" class="text-[var(--color-ccm-blue)]" />
            </div>
        </div>

        <div class="p-6">
            <h3 class="text-xl font-bold text-[var(--color-ccm-gray-900)]">
                {{ service.title }}
            </h3>
            <p class="mt-2 text-sm leading-relaxed text-[var(--color-ccm-gray-600)]">
                {{ service.description }}
            </p>

            <div v-if="service.deliverables?.length" class="mt-5">
                <h4 class="mb-2 text-sm font-semibold uppercase tracking-wider text-[var(--color-ccm-gray-700)]">
                    Nos prestations
                </h4>
                <ul class="space-y-1.5">
                    <li
                        v-for="item in service.deliverables"
                        :key="item"
                        class="flex items-start gap-2 text-sm text-[var(--color-ccm-gray-600)]"
                    >
                        <Icon name="circle-check" :size="16" class="mt-0.5 shrink-0 text-[var(--color-ccm-blue)]" />
                        {{ item }}
                    </li>
                </ul>
            </div>

            <div v-if="service.benefits?.length" class="mt-5 flex flex-wrap gap-2">
                <Badge
                    v-for="benefit in service.benefits"
                    :key="benefit"
                    variant="primary"
                    size="sm"
                >
                    {{ benefit }}
                </Badge>
            </div>

            <div class="mt-6 pt-4 border-t border-[var(--color-ccm-gray-200)] flex items-center gap-3">
                <Link
                    :href="`/services/${service.slug}`"
                    class="inline-flex items-center gap-1.5 text-sm font-medium text-[var(--color-ccm-blue)] transition-colors hover:text-[var(--color-ccm-blue-light)]"
                >
                    En savoir plus
                    <Icon name="arrow-right" :size="14" />
                </Link>
                <Link
                    :href="`/contact?subject=${service.slug}`"
                    class="inline-flex items-center gap-1.5 rounded-lg bg-[var(--color-ccm-yellow)] px-4 py-2 text-sm font-semibold text-[var(--color-ccm-blue-dark)] transition-colors hover:bg-[var(--color-ccm-yellow-light)]"
                >
                    Demander un devis
                    <Icon name="arrow-right" :size="14" />
                </Link>
            </div>
        </div>
    </div>
</template>
