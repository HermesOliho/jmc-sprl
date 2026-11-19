<script setup lang="ts">
import { ref } from 'vue'
import { animate } from 'motion-v'
import Container from '@/Components/ui/Container.vue'
import Icon from '@/Components/ui/icons/Icon.vue'
import type { FaqItem } from '@/types'

defineProps<{
    items: FaqItem[]
}>()

const openIndex = ref<number | null>(null)

function toggle(index: number) {
    openIndex.value = openIndex.value === index ? null : index
}
</script>

<template>
    <div class="mx-auto max-w-3xl space-y-3">
        <div
            v-for="(item, index) in items"
            :key="index"
            class="overflow-hidden rounded-xl border border-[var(--color-ccm-gray-200)] bg-white shadow-sm transition-all duration-200"
        >
            <button
                type="button"
                class="flex w-full items-center justify-between gap-4 px-6 py-4 text-left transition-colors hover:bg-[var(--color-ccm-gray-50)]"
                :aria-expanded="openIndex === index"
                :aria-controls="`faq-answer-${index}`"
                @click="toggle(index)"
            >
                <span class="text-base font-semibold text-[var(--color-ccm-gray-900)]">
                    {{ item.question }}
                </span>
                <Icon
                    :name="openIndex === index ? 'x' : 'chevron-right'"
                    :size="18"
                    class="shrink-0 text-[var(--color-ccm-blue)] transition-transform duration-200"
                />
            </button>
            <div
                :id="`faq-answer-${index}`"
                v-show="openIndex === index"
                class="border-t border-[var(--color-ccm-gray-200)] px-6 py-4"
            >
                <p class="text-sm leading-relaxed text-[var(--color-ccm-gray-600)]">
                    {{ item.answer }}
                </p>
            </div>
        </div>
    </div>
</template>
