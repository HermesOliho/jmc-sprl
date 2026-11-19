<script setup lang="ts">
import { Link } from '@inertiajs/vue3'
import { classNames } from '@/utils'
import { COMPANY } from '@/config/company'
import { FOOTER_QUICK_LINKS, FOOTER_SERVICES } from '@/config/navigation'
import Container from '@/Components/ui/Container.vue'
import Icon from '@/Components/ui/icons/Icon.vue'
import logoSrc from '../../../images/logo.png'

function scrollToTop() {
    window.scrollTo({ top: 0, behavior: 'smooth' })
}
</script>

<template>
    <footer class="bg-[var(--color-ccm-anthracite)] text-white" role="contentinfo">
        <Container class="py-16">
            <div class="grid gap-10 md:grid-cols-2 lg:grid-cols-4">
                <div class="space-y-4">
                    <div class="flex items-center gap-3">
                        <img
                            :src="logoSrc"
                            alt="CCM SARL"
                            class="h-10 w-auto"
                        />
                        <div>
                            <p class="text-lg font-bold">{{ COMPANY.name }}</p>
                            <p class="text-xs text-white/60">{{ COMPANY.slogan }}</p>
                        </div>
                    </div>
                    <p class="text-sm leading-relaxed text-white/70">
                        {{ COMPANY.description }}
                    </p>
                </div>

                <div>
                    <h3 class="mb-4 text-sm font-semibold uppercase tracking-wider text-white/80">
                        Liens rapides
                    </h3>
                    <ul class="space-y-3">
                        <li v-for="link in FOOTER_QUICK_LINKS" :key="link.href">
                            <Link
                                :href="link.href"
                                class="text-sm text-white/60 transition-colors hover:text-[var(--color-ccm-yellow)]"
                            >
                                {{ link.label }}
                            </Link>
                        </li>
                    </ul>
                </div>

                <div>
                    <h3 class="mb-4 text-sm font-semibold uppercase tracking-wider text-white/80">
                        Services
                    </h3>
                    <ul class="space-y-3">
                        <li v-for="service in FOOTER_SERVICES" :key="service.href">
                            <Link
                                :href="service.href"
                                class="text-sm text-white/60 transition-colors hover:text-[var(--color-ccm-yellow)]"
                            >
                                {{ service.label }}
                            </Link>
                        </li>
                    </ul>
                </div>

                <div>
                    <h3 class="mb-4 text-sm font-semibold uppercase tracking-wider text-white/80">
                        Contact
                    </h3>
                    <ul class="space-y-4">
                        <li class="flex items-start gap-3">
                            <Icon name="map-pin" :size="16" class="mt-0.5 shrink-0 text-[var(--color-ccm-yellow)]" />
                            <span class="text-sm text-white/60">
                                {{ COMPANY.address.street }}<br>
                                {{ COMPANY.address.city }}, {{ COMPANY.address.country }}
                            </span>
                        </li>
                        <li class="flex items-center gap-3">
                            <Icon name="phone" :size="16" class="shrink-0 text-[var(--color-ccm-yellow)]" />
                            <a
                                :href="`tel:${COMPANY.phone}`"
                                class="text-sm text-white/60 transition-colors hover:text-[var(--color-ccm-yellow)]"
                            >
                                {{ COMPANY.phone }}
                            </a>
                        </li>
                        <li class="flex items-center gap-3">
                            <Icon name="mail" :size="16" class="shrink-0 text-[var(--color-ccm-yellow)]" />
                            <a
                                :href="`mailto:${COMPANY.email}`"
                                class="text-sm text-white/60 transition-colors hover:text-[var(--color-ccm-yellow)]"
                            >
                                {{ COMPANY.email }}
                            </a>
                        </li>
                        <li class="flex items-center gap-3">
                            <Icon name="clock" :size="16" class="shrink-0 text-[var(--color-ccm-yellow)]" />
                            <span class="text-sm text-white/60">{{ COMPANY.hours }}</span>
                        </li>
                    </ul>
                </div>
            </div>

            <div class="mt-12 flex flex-col items-center justify-between gap-4 border-t border-white/10 pt-8 md:flex-row">
                <p class="text-sm text-white/40">
                    &copy; {{ new Date().getFullYear() }} {{ COMPANY.legalName }}. Tous droits réservés.
                </p>
                <div class="flex items-center gap-4">
                    <a
                        v-for="social in COMPANY.social"
                        :key="social.name"
                        :href="social.url"
                        target="_blank"
                        rel="noopener noreferrer"
                        class="flex h-9 w-9 items-center justify-center rounded-full border border-white/20 text-white/60 transition-all duration-200 hover:border-[var(--color-ccm-yellow)] hover:text-[var(--color-ccm-yellow)]"
                        :aria-label="social.name"
                    >
                        <Icon :name="social.icon" :size="16" />
                    </a>
                </div>
            </div>
        </Container>

        <button
            type="button"
            class="fixed bottom-6 right-6 z-30 flex h-12 w-12 items-center justify-center rounded-full bg-[var(--color-ccm-blue)] text-white shadow-lg transition-all duration-200 hover:bg-[var(--color-ccm-blue-light)] hover:-translate-y-1"
            aria-label="Retour en haut"
            @click="scrollToTop"
        >
            <Icon name="arrow-up" :size="20" />
        </button>
    </footer>
</template>
