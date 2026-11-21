<script setup lang="ts">
import { Link, usePage } from '@inertiajs/vue3'
import { computed } from 'vue'
import { useSite } from '@/composables'
import { FOOTER_QUICK_LINKS, FOOTER_LEGAL_LINKS } from '@/config/navigation'
import Container from '@/Components/ui/Container.vue'
import Icon from '@/Components/ui/icons/Icon.vue'
import BrandLogo from '@/Components/common/BrandLogo.vue'
import { formatAddress } from '@/utils'

const site = useSite()
const page = usePage()

const footerServices = computed<Array<{ slug: string; title: string }>>(
    () => (page.props.footer_services as Array<{ slug: string; title: string }> | undefined) ?? [],
)

function scrollToTop() {
    window.scrollTo({ top: 0, behavior: 'smooth' })
}
</script>

<template>
    <footer class="bg-[var(--color-footer)] text-white" role="contentinfo">
        <Container class="py-16">
            <div class="grid gap-10 md:grid-cols-2 lg:grid-cols-4">
                <div class="space-y-4">
                    <Link href="/" :aria-label="`Accueil ${site.name}`">
                        <BrandLogo variant="dark" context="footer" />
                    </Link>
                    <p class="text-sm leading-relaxed text-white/70">
                        {{ site.description }}
                    </p>
                    <p
                        v-if="site.slogan"
                        lang="en"
                        class="text-xs font-semibold uppercase tracking-wider text-[var(--color-brand-orange-light)]"
                    >
                        {{ site.slogan }}
                    </p>
                </div>

                <div>
                    <h2 class="mb-4 text-sm font-semibold uppercase tracking-wider text-white/80">
                        Liens rapides
                    </h2>
                    <ul class="space-y-3">
                        <li v-for="link in FOOTER_QUICK_LINKS" :key="link.href">
                            <Link
                                :href="link.href"
                                class="text-sm text-white/70 transition-colors hover:text-[var(--color-brand-orange-light)]"
                            >
                                {{ link.label }}
                            </Link>
                        </li>
                    </ul>
                </div>

                <div>
                    <h2 class="mb-4 text-sm font-semibold uppercase tracking-wider text-white/80">
                        Services
                    </h2>
                    <ul v-if="footerServices.length > 0" class="space-y-3">
                        <li v-for="service in footerServices" :key="service.slug">
                            <Link
                                :href="`/services#${service.slug}`"
                                class="text-sm text-white/70 transition-colors hover:text-[var(--color-brand-orange-light)]"
                            >
                                {{ service.title }}
                            </Link>
                        </li>
                    </ul>
                </div>

                <div>
                    <h2 class="mb-4 text-sm font-semibold uppercase tracking-wider text-white/80">
                        Contact
                    </h2>
                    <ul class="space-y-4">
                        <li v-if="site.contact.address.city" class="flex items-start gap-3">
                            <Icon name="map-pin" :size="16" class="mt-0.5 shrink-0 text-[var(--color-brand-orange-light)]" />
                            <span class="text-sm text-white/70">
                                {{ formatAddress(site.contact.address) }}
                            </span>
                        </li>
                        <li v-if="site.contact.phones.length > 0" class="flex items-start gap-3">
                            <Icon name="phone" :size="16" class="mt-0.5 shrink-0 text-[var(--color-brand-orange-light)]" />
                            <span class="space-y-1 text-sm text-white/70">
                                <a
                                    v-for="phone in site.contact.phones"
                                    :key="phone.e164"
                                    :href="`tel:${phone.e164}`"
                                    class="block transition-colors hover:text-[var(--color-brand-orange-light)]"
                                >
                                    {{ phone.display }}
                                    <span class="text-white/50">({{ phone.label }})</span>
                                </a>
                            </span>
                        </li>
                        <li v-if="site.contact.whatsapp" class="flex items-center gap-3">
                            <Icon name="message-circle" :size="16" class="shrink-0 text-[var(--color-brand-orange-light)]" />
                            <a
                                :href="site.contact.whatsapp.url"
                                target="_blank"
                                rel="noopener noreferrer"
                                class="text-sm text-white/70 transition-colors hover:text-[var(--color-brand-orange-light)]"
                            >
                                {{ site.contact.whatsapp.display }}
                            </a>
                        </li>
                        <li v-if="site.contact.email" class="flex items-center gap-3">
                            <Icon name="mail" :size="16" class="shrink-0 text-[var(--color-brand-orange-light)]" />
                            <a
                                :href="`mailto:${site.contact.email}`"
                                class="text-sm text-white/70 transition-colors hover:text-[var(--color-brand-orange-light)]"
                            >
                                {{ site.contact.email }}
                            </a>
                        </li>
                        <li v-if="site.contact.hours" class="flex items-center gap-3">
                            <Icon name="clock" :size="16" class="shrink-0 text-[var(--color-brand-orange-light)]" />
                            <span class="text-sm text-white/70">{{ site.contact.hours }}</span>
                        </li>
                        <li class="flex items-center gap-3">
                            <Icon name="send" :size="16" class="shrink-0 text-[var(--color-brand-orange-light)]" />
                            <Link
                                href="/contact"
                                class="text-sm text-white/70 transition-colors hover:text-[var(--color-brand-orange-light)]"
                            >
                                Contactez-nous
                            </Link>
                        </li>
                    </ul>
                </div>
            </div>

            <div class="mt-12 flex flex-col items-center justify-between gap-4 border-t border-white/10 pt-8 md:flex-row">
                <p class="text-sm text-white/70">
                    &copy; {{ new Date().getFullYear() }} {{ site.legal_name }}. Tous droits réservés.
                </p>
                <div class="flex flex-wrap items-center gap-4">
                    <Link
                        v-for="link in FOOTER_LEGAL_LINKS"
                        :key="link.href"
                        :href="link.href"
                        class="text-sm text-white/70 transition-colors hover:text-[var(--color-brand-orange-light)]"
                    >
                        {{ link.label }}
                    </Link>
                    <a
                        v-for="social in site.social"
                        :key="social.name"
                        :href="social.url"
                        target="_blank"
                        rel="noopener noreferrer"
                        class="flex h-9 w-9 items-center justify-center rounded-full border border-white/20 text-white/70 transition-all duration-200 hover:border-[var(--color-brand-orange-light)] hover:text-[var(--color-brand-orange-light)]"
                        :aria-label="social.name"
                    >
                        <Icon :name="social.icon ?? 'globe'" :size="16" />
                    </a>
                </div>
            </div>
        </Container>

        <button
            type="button"
            class="fixed bottom-6 right-6 z-30 flex h-12 w-12 items-center justify-center rounded-full bg-[var(--color-brand-orange)] text-[var(--color-on-accent)] shadow-lg transition-all duration-200 hover:bg-[var(--color-brand-orange-light)] hover:-translate-y-1"
            aria-label="Retour en haut"
            @click="scrollToTop"
        >
            <Icon name="arrow-up" :size="20" />
        </button>
    </footer>
</template>
