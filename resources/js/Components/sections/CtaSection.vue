<script setup lang="ts">
import { Link } from '@inertiajs/vue3'
import Container from '@/Components/ui/Container.vue'
import PrimaryButton from '@/Components/ui/buttons/PrimaryButton.vue'
import Icon from '@/Components/ui/icons/Icon.vue'

defineProps<{
    title: string
    description: string
    buttonLabel: string
    buttonHref: string
    secondaryButtonLabel?: string
    secondaryButtonHref?: string
}>()
</script>

<template>
    <section class="bg-gradient-to-r from-[var(--color-brand-navy)] to-[var(--color-brand-navy-dark)] py-16 md:py-20">
        <Container class="text-center">
            <h2 class="text-3xl font-bold text-white md:text-4xl">
                {{ title }}
            </h2>
            <p class="mx-auto mt-4 max-w-2xl text-lg text-white/80">
                {{ description }}
            </p>
            <div class="mt-8 flex flex-wrap items-center justify-center gap-4">
                <Link :href="buttonHref">
                    <PrimaryButton size="lg" class="bg-[var(--color-brand-orange)] text-[var(--color-on-accent)] hover:bg-[var(--color-brand-orange-light)]">
                        <Icon name="arrow-right" :size="20" />
                        {{ buttonLabel }}
                    </PrimaryButton>
                </Link>
                <Link v-if="secondaryButtonLabel && secondaryButtonHref" :href="secondaryButtonHref">
                    <PrimaryButton size="lg" class="border-2 border-white/30 bg-transparent text-white hover:bg-white/10">
                        <Icon name="phone" :size="20" />
                        {{ secondaryButtonLabel }}
                    </PrimaryButton>
                </Link>
            </div>
        </Container>
    </section>
</template>
