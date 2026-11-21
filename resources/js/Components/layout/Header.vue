<script setup lang="ts">
import Container from '@/Components/ui/Container.vue';
import PrimaryButton from '@/Components/ui/buttons/PrimaryButton.vue';
import Icon from '@/Components/ui/icons/Icon.vue';
import BrandLogo from '@/Components/common/BrandLogo.vue';
import { useScroll, useSite, useTheme } from '@/composables';
import { NAVIGATION } from '@/config/navigation';
import { useAppStore } from '@/stores';
import { classNames } from '@/utils';
import { Link, usePage } from '@inertiajs/vue3';
import { ref } from 'vue';

const { isScrolled } = useScroll();
const { isDark, toggle } = useTheme();
const appStore = useAppStore();
const page = usePage();
const site = useSite();
const mobileMenuButton = ref<HTMLButtonElement | null>(null);

function closeMobileMenu(): void {
    if (!appStore.isMobileMenuOpen) {
        return;
    }

    appStore.closeMobileMenu();
    mobileMenuButton.value?.focus();
}

function isActive(href: string): boolean {
    const url = page.url;
    if (href === '/') return url === '/';
    return url.startsWith(href);
}
</script>

<template>
    <header
        :class="
            classNames(
                'fixed top-0 right-0 left-0 z-40 border-b border-[var(--color-border)] transition-[background-color,box-shadow] duration-200',
                isScrolled
                    ? 'bg-[var(--color-surface)]/90 shadow-sm backdrop-blur-xl'
                    : 'bg-[var(--color-surface)]/80 backdrop-blur-md',
            )
        "
        @keydown.esc="closeMobileMenu"
    >
        <Container>
            <nav
                class="flex h-20 items-center justify-between gap-4"
                aria-label="Navigation principale"
            >
                <Link
                    href="/"
                    class="flex shrink-0 items-center"
                    :aria-label="`Accueil ${site.name}`"
                >
                    <BrandLogo context="header" />
                </Link>

                <div class="hidden items-center gap-1 lg:flex">
                    <Link
                        v-for="item in NAVIGATION"
                        :key="item.href"
                        :href="item.href"
                        :class="
                            classNames(
                                'rounded-lg px-4 py-2 text-sm font-medium transition-all duration-200',
                                isActive(item.href)
                                    ? 'bg-[var(--color-action)]/10 text-[var(--color-link)]'
                                    : 'text-[var(--color-content-muted)] hover:bg-[var(--color-action)]/10 hover:text-[var(--color-link)]',
                            )
                        "
                        :aria-current="isActive(item.href) ? 'page' : undefined"
                    >
                        {{ item.label }}
                    </Link>
                </div>

                <div class="flex items-center gap-2">
                    <button
                        ref="mobileMenuButton"
                        type="button"
                        class="rounded-lg p-2.5 text-[var(--color-content-muted)] transition-colors hover:bg-[var(--color-action)]/10 hover:text-[var(--color-link)] focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-[var(--color-brand-orange)]"
                        :aria-label="isDark ? 'Activer le thème clair' : 'Activer le thème sombre'"
                        :aria-pressed="isDark"
                        @click="toggle"
                    >
                        <Icon :name="isDark ? 'sun' : 'moon'" :size="20" />
                    </button>

                    <Link href="/contact?subject=devis" class="hidden lg:block">
                        <PrimaryButton
                            size="sm"
                            class="bg-[var(--color-brand-orange)] text-[var(--color-on-accent)] hover:bg-[var(--color-brand-orange-light)]"
                        >
                            Demander un devis
                            <Icon name="arrow-right" :size="16" />
                        </PrimaryButton>
                    </Link>

                    <button
                        type="button"
                        class="rounded-lg p-2 text-[var(--color-content-muted)] transition-colors hover:bg-[var(--color-action)]/10 hover:text-[var(--color-link)] lg:hidden"
                        :aria-label="appStore.isMobileMenuOpen ? 'Fermer le menu' : 'Ouvrir le menu'"
                        aria-controls="mobile-navigation"
                        :aria-expanded="appStore.isMobileMenuOpen"
                        @click="appStore.toggleMobileMenu()"
                    >
                        <Icon
                            :name="appStore.isMobileMenuOpen ? 'x' : 'menu'"
                            :size="24"
                        />
                    </button>
                </div>
            </nav>
        </Container>

        <Transition
            enter-from-class="opacity-0 -translate-y-4"
            enter-active-class="transition-all duration-200"
            enter-to-class="opacity-100 translate-y-0"
            leave-from-class="opacity-100 translate-y-0"
            leave-active-class="transition-all duration-200"
            leave-to-class="opacity-0 -translate-y-4"
        >
            <div
                v-if="appStore.isMobileMenuOpen"
                id="mobile-navigation"
                class="border-t border-[var(--color-border)] bg-[var(--color-surface)] lg:hidden"
            >
                <Container class="max-h-[calc(100dvh-5rem)] overflow-y-auto overscroll-contain py-4">
                    <div class="flex flex-col gap-1">
                        <Link
                            v-for="item in NAVIGATION"
                            :key="item.href"
                            :href="item.href"
                            class="rounded-lg px-4 py-3 text-sm font-medium text-[var(--color-content)] transition-colors hover:bg-[var(--color-surface-elevated)] hover:text-[var(--color-link)]"
                            :class="{
                                'bg-[var(--color-action)]/10 font-semibold text-[var(--color-link)]':
                                    isActive(item.href),
                            }"
                            :aria-current="
                                isActive(item.href) ? 'page' : undefined
                            "
                            @click="appStore.closeMobileMenu()"
                        >
                            {{ item.label }}
                        </Link>
                    </div>
                    <div
                        class="mt-4 border-t border-[var(--color-border)] pt-4"
                    >
                        <Link
                            href="/contact?subject=devis"
                            @click="appStore.closeMobileMenu()"
                        >
                            <PrimaryButton
                                class="w-full bg-[var(--color-brand-orange)] text-[var(--color-on-accent)] hover:bg-[var(--color-brand-orange-light)]"
                            >
                                Demander un devis
                                <Icon name="arrow-right" :size="16" />
                            </PrimaryButton>
                        </Link>
                    </div>
                </Container>
            </div>
        </Transition>
    </header>
</template>
