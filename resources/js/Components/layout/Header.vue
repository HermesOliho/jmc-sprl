<script setup lang="ts">
import Container from '@/Components/ui/Container.vue';
import PrimaryButton from '@/Components/ui/buttons/PrimaryButton.vue';
import Icon from '@/Components/ui/icons/Icon.vue';
import { useScroll } from '@/composables';
import { NAVIGATION } from '@/config/navigation';
import { useAppStore } from '@/stores';
import { classNames } from '@/utils';
import { Link, usePage } from '@inertiajs/vue3';
import { ref, watch } from 'vue';
import logoSrc from '../../../images/logo.png';

const { isScrolled, scrollDirection } = useScroll();
const appStore = useAppStore();
const page = usePage();

const isHidden = ref(false);

watch(scrollDirection, (dir) => {
    if (dir === 'down' && isScrolled.value) {
        isHidden.value = true;
    } else {
        isHidden.value = false;
    }
});

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
                'fixed top-0 right-0 left-0 z-40 transition-all duration-700 ease-in-out',
                isScrolled
                    ? 'bg-white/80 shadow-sm backdrop-blur-2xl'
                    : 'bg-white/70 backdrop-blur-md',
                isHidden ? '-translate-y-full' : 'translate-y-0',
            )
        "
    >
        <Container>
            <nav
                class="flex h-20 items-center justify-between"
                aria-label="Navigation principale"
            >
                <Link
                    href="/"
                    class="flex shrink-0 items-center gap-3"
                    aria-label="Accueil CCM SARL"
                >
                    <img :src="logoSrc" alt="CCM SARL" class="h-10 w-auto" />
                    <div class="hidden sm:block">
                        <span
                            class="text-lg font-bold tracking-tight text-[var(--color-ccm-blue)]"
                        >
                            CCM
                        </span>
                        <span
                            class="block text-[10px] leading-tight font-medium tracking-wider text-[var(--color-ccm-blue)]/60 uppercase"
                        >
                            Congo Construction &amp; Métallique
                        </span>
                    </div>
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
                                    ? 'bg-[var(--color-ccm-blue)]/10 text-[var(--color-ccm-blue)]'
                                    : 'text-[var(--color-ccm-blue)]/70 hover:bg-[var(--color-ccm-blue)]/10 hover:text-[var(--color-ccm-blue)]',
                            )
                        "
                        :aria-current="isActive(item.href) ? 'page' : undefined"
                    >
                        {{ item.label }}
                    </Link>
                </div>

                <div class="flex items-center gap-3">
                    <Link href="/demande-devis" class="hidden lg:block">
                        <PrimaryButton
                            size="sm"
                            class="bg-[var(--color-ccm-yellow)] text-[var(--color-ccm-blue-dark)] hover:bg-[var(--color-ccm-yellow-light)]"
                        >
                            Demander un devis
                            <Icon name="arrow-right" :size="16" />
                        </PrimaryButton>
                    </Link>

                    <button
                        type="button"
                        class="rounded-lg p-2 text-[var(--color-ccm-blue)] transition-colors hover:bg-[var(--color-ccm-blue)]/10 lg:hidden"
                        aria-label="Menu"
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
                class="border-t border-[var(--color-ccm-gray-200)] bg-white lg:hidden"
            >
                <Container class="py-4">
                    <div class="flex flex-col gap-1">
                        <Link
                            v-for="item in NAVIGATION"
                            :key="item.href"
                            :href="item.href"
                            class="rounded-lg px-4 py-3 text-sm font-medium text-[var(--color-ccm-gray-700)] transition-colors hover:bg-[var(--color-ccm-gray-100)] hover:text-[var(--color-ccm-blue)]"
                            :class="{
                                'bg-[var(--color-ccm-blue)]/10 font-semibold text-[var(--color-ccm-blue)]':
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
                        class="mt-4 border-t border-[var(--color-ccm-gray-200)] pt-4"
                    >
                        <Link
                            href="/demande-devis"
                            @click="appStore.closeMobileMenu()"
                        >
                            <PrimaryButton
                                class="w-full bg-[var(--color-ccm-yellow)] text-[var(--color-ccm-blue-dark)] hover:bg-[var(--color-ccm-yellow-light)]"
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
