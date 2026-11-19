<script setup lang="ts">
import Section from '@/Components/sections/Section.vue'
import SectionTitle from '@/Components/ui/typography/SectionTitle.vue'
import Icon from '@/Components/ui/icons/Icon.vue'
import Stagger from '@/Components/animations/Stagger.vue'
import type { TeamMember } from '@/types'

defineProps<{
    members: TeamMember[]
}>()
</script>

<template>
    <Section background="gray">
        <SectionTitle subtitle="Ceux qui font CCM SARL">
            Notre équipe
        </SectionTitle>

        <Stagger :stagger="0.1" :delay="0.1">
            <div class="grid gap-8 sm:grid-cols-2 lg:grid-cols-4">
                <div
                    v-for="member in members"
                    :key="member.name"
                    class="group overflow-hidden rounded-xl border border-[var(--color-ccm-gray-200)] bg-white shadow-sm transition-all duration-200 hover:shadow-md"
                >
                    <div class="aspect-square overflow-hidden">
                        <img
                            :src="member.avatar"
                            :alt="member.name"
                            class="h-full w-full object-cover transition-transform duration-500 group-hover:scale-105"
                            width="400"
                            height="400"
                            loading="lazy"
                        />
                    </div>
                    <div class="p-5">
                        <h3 class="text-lg font-semibold text-[var(--color-ccm-gray-900)]">
                            {{ member.name }}
                        </h3>
                        <p class="mt-0.5 text-sm font-medium text-[var(--color-ccm-yellow)]">
                            {{ member.role }}
                        </p>
                        <p v-if="member.description" class="mt-3 text-sm leading-relaxed text-[var(--color-ccm-gray-600)]">
                            {{ member.description }}
                        </p>
                        <div v-if="member.social?.length" class="mt-4 flex items-center gap-3">
                            <a
                                v-for="s in member.social"
                                :key="s.name"
                                :href="s.url"
                                class="flex h-8 w-8 items-center justify-center rounded-full bg-[var(--color-ccm-gray-100)] text-[var(--color-ccm-gray-500)] transition-colors hover:bg-[var(--color-ccm-blue)] hover:text-white"
                                :aria-label="s.name"
                                target="_blank"
                                rel="noopener noreferrer"
                            >
                                <Icon :name="s.icon" :size="14" />
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </Stagger>
    </Section>
</template>
