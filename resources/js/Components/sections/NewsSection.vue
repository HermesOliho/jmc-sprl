<script setup lang="ts">
import { Link } from '@inertiajs/vue3'
import Section from '@/Components/sections/Section.vue'
import SectionTitle from '@/Components/ui/typography/SectionTitle.vue'
import Badge from '@/Components/ui/badges/Badge.vue'
import Icon from '@/Components/ui/icons/Icon.vue'
import Stagger from '@/Components/animations/Stagger.vue'
import { formatDateShort } from '@/utils'
import type { NewsArticle } from '@/types'

defineProps<{
    articles: NewsArticle[]
}>()
</script>

<template>
    <Section background="white" id="actualites">
        <SectionTitle subtitle="Restez informé">
            Actualités
        </SectionTitle>

        <Stagger :stagger="0.1" :delay="0.1">
            <div class="grid gap-8 md:grid-cols-2 lg:grid-cols-3">
                <article
                    v-for="article in articles"
                    :key="article.id"
                    class="group flex flex-col overflow-hidden rounded-xl border border-[var(--color-ccm-gray-200)] bg-white shadow-sm transition-all duration-200 hover:shadow-md"
                >
                    <div class="relative aspect-[16/10] overflow-hidden">
                        <img
                            :src="article.image"
                            :alt="article.title"
                            class="h-full w-full object-cover transition-transform duration-500 group-hover:scale-105"
                            width="800"
                            height="500"
                            loading="lazy"
                        />
                    </div>
                    <div class="flex flex-1 flex-col gap-3 p-6">
                        <div class="flex items-center gap-3">
                            <Badge variant="primary" size="sm">
                                {{ article.category }}
                            </Badge>
                            <span class="text-sm text-[var(--color-ccm-gray-500)]">
                                {{ formatDateShort(article.date) }}
                            </span>
                        </div>
                        <h3 class="text-lg font-semibold leading-snug text-[var(--color-ccm-gray-900)]">
                            {{ article.title }}
                        </h3>
                        <p class="flex-1 text-sm leading-relaxed text-[var(--color-ccm-gray-600)]">
                            {{ article.summary }}
                        </p>
                        <div>
                            <Link
                                :href="`/actualites#${article.id}`"
                                class="inline-flex items-center gap-1.5 text-sm font-medium text-[var(--color-ccm-blue)] transition-colors hover:text-[var(--color-ccm-blue-light)]"
                            >
                                Lire l'article
                                <Icon name="arrow-right" :size="14" />
                            </Link>
                        </div>
                    </div>
                </article>
            </div>
        </Stagger>

        <div class="mt-12 text-center">
            <Link href="/actualites">
                <span
                    class="inline-flex items-center gap-2 rounded-lg border-2 border-[var(--color-ccm-blue)] px-6 py-3 font-semibold text-[var(--color-ccm-blue)] transition-all duration-200 hover:bg-[var(--color-ccm-blue)] hover:text-white"
                >
                    Voir toutes les actualités
                    <Icon name="arrow-right" :size="18" />
                </span>
            </Link>
        </div>
    </Section>
</template>
