<script setup lang="ts">
import BrandLogo from '@/Components/common/BrandLogo.vue';
import Icon from '@/Components/ui/icons/Icon.vue';
import { useTheme } from '@/composables/useTheme';
import { Head, Link } from '@inertiajs/vue3';

const { isDark, toggle } = useTheme();
</script>

<template>
    <div
        class="relative flex min-h-screen flex-col items-center bg-[var(--color-surface-muted)] px-4 pt-6 sm:justify-center sm:pt-0"
    >
        <Head>
            <meta name="robots" content="noindex, nofollow" />
        </Head>

        <button
            type="button"
            class="absolute top-4 right-4 rounded-lg p-2.5 text-[var(--color-content-muted)] transition-colors hover:bg-[var(--color-surface-elevated)] hover:text-[var(--color-content)]"
            :aria-label="isDark ? 'Activer le thème clair' : 'Activer le thème sombre'"
            :aria-pressed="isDark"
            @click="toggle"
        >
            <Icon :name="isDark ? 'sun' : 'moon'" :size="20" />
        </button>

        <div>
            <Link href="/" aria-label="Retour à l'accueil">
                <BrandLogo context="auth" />
            </Link>
        </div>

        <div
            class="mt-6 w-full overflow-hidden rounded-lg border border-[var(--color-border)] bg-[var(--color-surface)] px-6 py-6 shadow-md sm:max-w-md"
        >
            <slot />
        </div>
    </div>
</template>
