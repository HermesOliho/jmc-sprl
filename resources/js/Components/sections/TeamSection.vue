<script setup lang="ts">
import Section from '@/Components/sections/Section.vue'
import SectionTitle from '@/Components/ui/typography/SectionTitle.vue'
import Stagger from '@/Components/animations/Stagger.vue'
import type { TeamMember } from '@/types'

defineProps<{
    members: TeamMember[]
}>()

const initials = (name: string): string =>
    name
        .split(/\s+/)
        .filter(Boolean)
        .slice(0, 2)
        .map((part) => part[0]?.toUpperCase() ?? '')
        .join('')
</script>

<template>
    <Section v-if="members.length" background="gray">
        <SectionTitle subtitle="Les personnes derrière nos projets">
            Notre équipe
        </SectionTitle>

        <Stagger :stagger="0.08" :delay="0.1">
            <div class="grid gap-6 sm:grid-cols-2 lg:grid-cols-3">
                <article
                    v-for="member in members"
                    :key="member.name"
                    class="rounded-xl border border-[var(--color-border)] bg-[var(--color-surface)] p-6 shadow-sm"
                >
                    <div class="flex items-center gap-4">
                        <img
                            v-if="member.avatar"
                            :src="member.avatar"
                            :alt="member.name"
                            class="h-16 w-16 rounded-full object-cover"
                            width="64"
                            height="64"
                            loading="lazy"
                        />
                        <div
                            v-else
                            class="flex h-16 w-16 items-center justify-center rounded-full bg-[var(--color-action)]/10 text-lg font-semibold text-[var(--color-link)]"
                        >
                            {{ initials(member.name) }}
                        </div>
                        <div>
                            <h3 class="text-lg font-semibold text-[var(--color-content)]">
                                {{ member.name }}
                            </h3>
                            <p class="text-sm text-[var(--color-content-muted)]">
                                {{ member.role }}
                            </p>
                        </div>
                    </div>

                    <p v-if="member.description" class="mt-4 text-sm leading-relaxed text-[var(--color-content-muted)]">
                        {{ member.description }}
                    </p>

                    <div v-if="member.email || member.phone" class="mt-4 space-y-1 text-sm text-[var(--color-content-muted)]">
                        <a
                            v-if="member.email"
                            :href="`mailto:${member.email}`"
                            class="block hover:text-[var(--color-link)]"
                        >
                            {{ member.email }}
                        </a>
                        <a
                            v-if="member.phone"
                            :href="`tel:${member.phone}`"
                            class="block hover:text-[var(--color-link)]"
                        >
                            {{ member.phone }}
                        </a>
                    </div>

                    <div v-if="member.social?.length" class="mt-4 flex flex-wrap gap-2">
                        <a
                            v-for="link in member.social"
                            :key="`${member.name}-${link.name}-${link.url}`"
                            :href="link.url"
                            target="_blank"
                            rel="noopener noreferrer"
                            class="inline-flex rounded-full border border-[var(--color-border)] px-3 py-1 text-xs font-medium text-[var(--color-content-muted)] transition hover:border-[var(--color-link)] hover:text-[var(--color-link)]"
                        >
                            {{ link.name }}
                        </a>
                    </div>
                </article>
            </div>
        </Stagger>
    </Section>
</template>
