<script setup lang="ts">
import Icon from '@/Components/ui/icons/Icon.vue'
import { classNames } from '@/utils'

defineProps<{
    icon: string
    class?: string
}>()
</script>

<template>
    <div
        :class="classNames(
            'group/illustration relative flex aspect-[16/9] items-center justify-center overflow-hidden bg-[var(--color-brand-navy-dark)]',
            $props.class,
        )"
        aria-hidden="true"
    >
        <div
            class="absolute inset-0 opacity-30"
            style="background-image: linear-gradient(135deg, transparent 49.5%, rgba(255,255,255,.18) 50%, transparent 50.5%), linear-gradient(45deg, transparent 49.5%, rgba(255,255,255,.12) 50%, transparent 50.5%); background-size: 36px 36px;"
        />
        <div class="absolute -top-12 -right-8 h-44 w-44 rounded-full border border-white/15" />
        <div class="absolute -right-2 -bottom-16 h-48 w-48 rounded-full bg-[var(--color-brand-orange)]/15 blur-2xl" />
        <div class="absolute top-0 right-0 h-full w-1/3 bg-gradient-to-l from-white/5 to-transparent" />

        <div class="relative flex h-24 w-24 items-center justify-center rounded-3xl border border-white/20 bg-white/10 text-[var(--color-brand-orange-light)] shadow-xl backdrop-blur-sm transition-transform duration-300 group-hover/illustration:scale-105">
            <Icon :name="icon" :size="48" />
        </div>

        <span class="absolute right-4 bottom-3 text-[10px] font-semibold uppercase tracking-[0.16em] text-white/60">
            Représentation symbolique
        </span>
    </div>
</template>
