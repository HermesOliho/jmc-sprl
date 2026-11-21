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
    <div class="group flex h-full flex-col overflow-hidden rounded-xl border border-[var(--color-border)] bg-[var(--color-surface)] shadow-sm transition-all duration-200 hover:shadow-md">
        <div class="flex items-center gap-4 border-b border-[var(--color-border)] bg-[var(--color-surface-muted)] p-6">
            <div class="flex h-14 w-14 shrink-0 items-center justify-center rounded-xl bg-[var(--color-action)] text-white">
                <Icon :name="service.icon" :size="26" />
            </div>
            <h3 class="text-xl font-bold text-[var(--color-content)]">
                {{ service.title }}
            </h3>
        </div>

        <div class="flex flex-1 flex-col p-6">
            <p class="text-sm leading-relaxed text-[var(--color-content-muted)]">
                {{ service.description }}
            </p>

            <div v-if="service.deliverables?.length" class="mt-5">
                <h4 class="mb-2 text-sm font-semibold uppercase tracking-wider text-[var(--color-content)]">
                    Nos prestations
                </h4>
                <ul class="space-y-1.5">
                    <li
                        v-for="item in service.deliverables"
                        :key="item"
                        class="flex items-start gap-2 text-sm text-[var(--color-content-muted)]"
                    >
                        <Icon name="circle-check" :size="16" class="mt-0.5 shrink-0 text-[var(--color-link)]" />
                        {{ item }}
                    </li>
                </ul>
            </div>

            <div v-if="service.benefits?.length" class="mt-5 flex flex-wrap gap-2">
                <Badge
                    v-for="benefit in service.benefits"
                    :key="benefit"
                    variant="default"
                    size="sm"
                >
                    {{ benefit }}
                </Badge>
            </div>

            <div class="mt-auto border-t border-[var(--color-border)] pt-5">
                <Link
                    :href="`/contact?subject=devis&service=${service.slug}`"
                    class="inline-flex items-center gap-1.5 rounded-lg bg-[var(--color-brand-orange)] px-4 py-2 text-sm font-semibold text-[var(--color-on-accent)] transition-colors hover:bg-[var(--color-brand-orange-light)]"
                >
                    Demander un devis
                    <Icon name="arrow-right" :size="14" />
                </Link>
            </div>
        </div>
    </div>
</template>
