<script setup lang="ts">
import { ref, onMounted } from 'vue'
import Section from '@/Components/sections/Section.vue'
import SectionTitle from '@/Components/ui/typography/SectionTitle.vue'
import Icon from '@/Components/ui/icons/Icon.vue'
import { animate } from 'motion-v'
import type { Statistic } from '@/types'

const props = defineProps<{
    statistics: Statistic[]
}>()

const sectionRef = ref<HTMLElement | null>(null)
const hasAnimated = ref(false)
const counts = ref<number[]>(props.statistics.map(() => 0))

onMounted(() => {
    if (!sectionRef.value) return

    const observer = new IntersectionObserver(
        (entries) => {
            entries.forEach((entry) => {
                if (entry.isIntersecting && !hasAnimated.value) {
                    hasAnimated.value = true

                    props.statistics.forEach((stat, index) => {
                        animate(0, stat.value, {
                            duration: 2,
                            ease: [0.25, 0.1, 0.25, 1],
                            onUpdate: (latest: number) => {
                                counts.value[index] = Math.round(latest)
                            },
                        })
                    })

                    observer.disconnect()
                }
            })
        },
        { threshold: 0.3 },
    )

    observer.observe(sectionRef.value)
})
</script>

<template>
    <Section ref="sectionRef" background="blue">
        <SectionTitle subtitle="Chiffres clés" class="text-white">
            <span class="text-white">CCM SARL en chiffres</span>
        </SectionTitle>

        <div class="grid gap-8 sm:grid-cols-2 lg:grid-cols-4">
            <div
                v-for="(stat, index) in statistics"
                :key="stat.label"
                class="flex flex-col items-center text-center"
            >
                <div
                    class="mb-4 flex h-16 w-16 items-center justify-center rounded-full bg-white/10"
                >
                    <Icon :name="stat.icon" :size="30" class="text-white" />
                </div>
                <span class="text-4xl font-bold text-white md:text-5xl">
                    {{ counts[index] }}{{ stat.suffix }}
                </span>
                <span class="mt-2 text-base text-white/70">
                    {{ stat.label }}
                </span>
            </div>
        </div>
    </Section>
</template>
