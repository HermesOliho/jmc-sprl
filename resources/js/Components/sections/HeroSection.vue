<script setup lang="ts">
import { Link } from '@inertiajs/vue3'
import { classNames } from '@/utils'
import Container from '@/Components/ui/Container.vue'
import PrimaryButton from '@/Components/ui/buttons/PrimaryButton.vue'
import SecondaryButton from '@/Components/ui/buttons/SecondaryButton.vue'

defineProps<{
    title: string
    subtitle: string
    primaryCta?: { label: string; href: string }
    secondaryCta?: { label: string; href: string }
    class?: string
}>()
</script>

<template>
    <section
        :class="classNames(
            'relative flex min-h-[80vh] items-center overflow-hidden bg-gradient-to-br from-[var(--color-ccm-blue-dark)] via-[var(--color-ccm-blue)] to-[var(--color-ccm-blue-light)]',
            $props.class,
        )"
    >
        <div
            class="absolute inset-0 opacity-5"
            style="background-image: radial-gradient(circle at 50% 50%, white 1px, transparent 1px); background-size: 30px 30px;"
        />
        <Container class="relative z-10 py-20">
            <div class="max-w-3xl">
                <h1
                    class="text-4xl font-bold leading-tight text-white md:text-5xl lg:text-6xl"
                >
                    {{ title }}
                </h1>
                <p
                    class="mt-6 max-w-2xl text-lg text-white/80 md:text-xl"
                >
                    {{ subtitle }}
                </p>
                <div v-if="primaryCta || secondaryCta" class="mt-10 flex flex-wrap gap-4">
                    <Link v-if="primaryCta" :href="primaryCta.href">
                        <PrimaryButton size="lg" class="bg-[var(--color-ccm-yellow)] text-[var(--color-ccm-blue-dark)] hover:bg-[var(--color-ccm-yellow-light)]">
                            {{ primaryCta.label }}
                        </PrimaryButton>
                    </Link>
                    <Link v-if="secondaryCta" :href="secondaryCta.href">
                        <SecondaryButton size="lg" class="border-2 border-white/30 bg-transparent text-white hover:bg-white/10">
                            {{ secondaryCta.label }}
                        </SecondaryButton>
                    </Link>
                </div>
            </div>
        </Container>
    </section>
</template>
