<script setup lang="ts">
import { ref } from 'vue';
import BrandLogo from '@/Components/common/BrandLogo.vue';
import Icon from '@/Components/ui/icons/Icon.vue';
import { useTheme } from '@/composables/useTheme';
import Dropdown from '@/Components/Dropdown.vue';
import DropdownLink from '@/Components/DropdownLink.vue';
import NavLink from '@/Components/NavLink.vue';
import ResponsiveNavLink from '@/Components/ResponsiveNavLink.vue';
import { Head, Link } from '@inertiajs/vue3';

const showingNavigationDropdown = ref(false);
const { isDark, toggle } = useTheme();
</script>

<template>
    <div>
        <Head>
            <meta name="robots" content="noindex, nofollow" />
        </Head>

        <div class="min-h-screen bg-[var(--color-surface-muted)]">
            <nav
                class="border-b border-[var(--color-border)] bg-[var(--color-surface)]"
            >
                <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
                    <div class="flex h-16 justify-between">
                        <div class="flex">
                            <div class="flex shrink-0 items-center">
                                <Link :href="route('dashboard')">
                                    <BrandLogo context="header" class="h-9 w-auto" />
                                </Link>
                            </div>

                            <div
                                class="hidden space-x-8 sm:-my-px sm:ms-10 sm:flex"
                            >
                                <NavLink
                                    :href="route('dashboard')"
                                    :active="route().current('dashboard')"
                                >
                                    Tableau de bord
                                </NavLink>
                                <NavLink
                                    v-if="$page.props.auth.can.accessAdmin"
                                    :href="route('admin.users.index')"
                                    :active="route().current('admin.users.*')"
                                >
                                    Utilisateurs
                                </NavLink>
                                <NavLink
                                    v-if="$page.props.auth.can.accessAdmin"
                                    :href="route('admin.partners.index')"
                                    :active="route().current('admin.partners.*')"
                                >
                                    Partenaires
                                </NavLink>
                                <NavLink
                                    v-if="$page.props.auth.can.accessAdmin"
                                    :href="route('admin.team-members.index')"
                                    :active="route().current('admin.team-members.*')"
                                >
                                    Membres
                                </NavLink>
                                <NavLink
                                    v-if="$page.props.auth.can.accessAdmin"
                                    :href="route('admin.services.index')"
                                    :active="route().current('admin.services.*')"
                                >
                                    Services
                                </NavLink>
                            </div>
                        </div>

                        <div class="flex items-center gap-2 sm:ms-6">
                            <button
                                type="button"
                                class="rounded-lg p-2 text-[var(--color-content-muted)] transition-colors hover:bg-[var(--color-surface-elevated)] hover:text-[var(--color-content)]"
                                :aria-label="isDark ? 'Activer le thème clair' : 'Activer le thème sombre'"
                                :aria-pressed="isDark"
                                @click="toggle"
                            >
                                <Icon :name="isDark ? 'sun' : 'moon'" :size="18" />
                            </button>

                            <div class="hidden sm:flex sm:items-center">
                            <div class="relative ms-3">
                                <Dropdown align="right" width="48">
                                    <template #trigger>
                                        <span class="inline-flex rounded-md">
                                            <button
                                                type="button"
                                                class="inline-flex items-center rounded-md border border-transparent bg-[var(--color-surface)] px-3 py-2 text-sm font-medium leading-4 text-[var(--color-content-muted)] transition duration-150 ease-in-out hover:text-[var(--color-content)] focus:outline-none"
                                            >
                                                {{ $page.props.auth.user?.name }}

                                                <svg
                                                    class="-me-0.5 ms-2 h-4 w-4"
                                                    xmlns="http://www.w3.org/2000/svg"
                                                    viewBox="0 0 20 20"
                                                    fill="currentColor"
                                                >
                                                    <path
                                                        fill-rule="evenodd"
                                                        d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z"
                                                        clip-rule="evenodd"
                                                    />
                                                </svg>
                                            </button>
                                        </span>
                                    </template>

                                    <template #content>
                                        <DropdownLink
                                            :href="route('profile.edit')"
                                        >
                                            Profil
                                        </DropdownLink>
                                        <DropdownLink
                                            :href="route('logout')"
                                            method="post"
                                            as="button"
                                        >
                                            Déconnexion
                                        </DropdownLink>
                                    </template>
                                </Dropdown>
                            </div>
                            </div>
                        </div>

                        <div class="-me-2 flex items-center sm:hidden">
                            <button
                                @click="
                                    showingNavigationDropdown =
                                        !showingNavigationDropdown
                                "
                                class="inline-flex items-center justify-center rounded-md p-2 text-[var(--color-content-muted)] transition duration-150 ease-in-out hover:bg-[var(--color-surface-elevated)] focus:outline-none"
                                aria-label="Menu"
                                :aria-expanded="showingNavigationDropdown"
                            >
                                <svg
                                    class="h-6 w-6"
                                    stroke="currentColor"
                                    fill="none"
                                    viewBox="0 0 24 24"
                                >
                                    <path
                                        :class="{
                                            hidden: showingNavigationDropdown,
                                            'inline-flex':
                                                !showingNavigationDropdown,
                                        }"
                                        stroke-linecap="round"
                                        stroke-linejoin="round"
                                        stroke-width="2"
                                        d="M4 6h16M4 12h16M4 18h16"
                                    />
                                    <path
                                        :class="{
                                            hidden: !showingNavigationDropdown,
                                            'inline-flex':
                                                showingNavigationDropdown,
                                        }"
                                        stroke-linecap="round"
                                        stroke-linejoin="round"
                                        stroke-width="2"
                                        d="M6 18L18 6M6 6l12 12"
                                    />
                                </svg>
                            </button>
                        </div>
                    </div>
                </div>

                <div
                    :class="{
                        block: showingNavigationDropdown,
                        hidden: !showingNavigationDropdown,
                    }"
                    class="sm:hidden"
                >
                    <div class="space-y-1 pb-3 pt-2">
                        <ResponsiveNavLink
                            :href="route('dashboard')"
                            :active="route().current('dashboard')"
                        >
                            Tableau de bord
                        </ResponsiveNavLink>
                        <ResponsiveNavLink
                            v-if="$page.props.auth.can.accessAdmin"
                            :href="route('admin.users.index')"
                            :active="route().current('admin.users.*')"
                        >
                            Utilisateurs
                        </ResponsiveNavLink>
                        <ResponsiveNavLink
                            v-if="$page.props.auth.can.accessAdmin"
                            :href="route('admin.partners.index')"
                            :active="route().current('admin.partners.*')"
                        >
                            Partenaires
                        </ResponsiveNavLink>
                        <ResponsiveNavLink
                            v-if="$page.props.auth.can.accessAdmin"
                            :href="route('admin.team-members.index')"
                            :active="route().current('admin.team-members.*')"
                        >
                            Membres
                        </ResponsiveNavLink>
                        <ResponsiveNavLink
                            v-if="$page.props.auth.can.accessAdmin"
                            :href="route('admin.services.index')"
                            :active="route().current('admin.services.*')"
                        >
                            Services
                        </ResponsiveNavLink>
                    </div>

                    <div
                        class="border-t border-[var(--color-border)] pb-1 pt-4"
                    >
                        <div class="px-4">
                            <div
                                class="text-base font-medium text-[var(--color-content)]"
                            >
                                {{ $page.props.auth.user?.name }}
                            </div>
                            <div class="text-sm font-medium text-[var(--color-content-muted)]">
                                {{ $page.props.auth.user?.email }}
                            </div>
                        </div>

                        <div class="mt-3 space-y-1">
                            <ResponsiveNavLink :href="route('profile.edit')">
                                Profil
                            </ResponsiveNavLink>
                            <ResponsiveNavLink
                                :href="route('logout')"
                                method="post"
                                as="button"
                            >
                                Déconnexion
                            </ResponsiveNavLink>
                        </div>
                    </div>
                </div>
            </nav>

            <header
                class="bg-[var(--color-surface)] shadow"
                v-if="$slots.header"
            >
                <div class="mx-auto max-w-7xl px-4 py-6 sm:px-6 lg:px-8">
                    <slot name="header" />
                </div>
            </header>

            <main>
                <div
                    v-if="$page.props.flash?.status || $page.props.flash?.error"
                    class="mx-auto mt-6 max-w-7xl px-4 sm:px-6 lg:px-8"
                >
                    <div
                        v-if="$page.props.flash?.status"
                        class="rounded-md border border-green-200 bg-green-50 px-4 py-3 text-sm text-green-800"
                    >
                        {{ $page.props.flash.status }}
                    </div>
                    <div
                        v-if="$page.props.flash?.error"
                        class="rounded-md border border-red-200 bg-red-50 px-4 py-3 text-sm text-red-800"
                    >
                        {{ $page.props.flash.error }}
                    </div>
                </div>
                <slot />
            </main>
        </div>
    </div>
</template>
