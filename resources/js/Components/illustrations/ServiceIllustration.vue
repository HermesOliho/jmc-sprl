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
        <div class="absolute inset-0 opacity-35" style="background-image: radial-gradient(circle, rgba(255,255,255,.55) 1px, transparent 1.5px); background-size: 20px 20px;" />
        <div class="absolute -top-16 -right-8 h-52 w-52 rounded-full border border-white/15" />
        <div class="absolute -right-2 -bottom-20 h-56 w-56 rounded-full bg-[var(--color-brand-orange)]/15 blur-2xl" />
        <svg
            class="absolute inset-0 h-full w-full"
            viewBox="0 0 640 360"
            fill="none"
            xmlns="http://www.w3.org/2000/svg"
            aria-hidden="true"
        >
            <path d="M42 292H598M76 318H564" stroke="white" stroke-opacity=".22" stroke-width="2" />
            <path d="M125 292V218L182 187L239 218V292H125Z" fill="#101A79" stroke="white" stroke-opacity=".5" stroke-width="2" />
            <path d="M239 292V160L320 117L401 160V292H239Z" fill="#25309B" stroke="white" stroke-opacity=".68" stroke-width="2" />
            <path d="M401 292V220L457 190L513 220V292H401Z" fill="#101A79" stroke="white" stroke-opacity=".48" stroke-width="2" />
            <path d="M239 160L320 201L401 160M320 201V292" stroke="white" stroke-opacity=".38" stroke-width="2" />
            <path d="M151 231V267M182 231V267M213 231V267M265 178V219M292 192V235M348 192V235M375 178V219M427 234V267M457 234V267M487 234V267" stroke="#FF7A2F" stroke-opacity=".8" stroke-width="4" />
            <path d="M182 187V148M182 156H320M202 156L182 187M294 156L320 187" stroke="#FF7A2F" stroke-opacity=".7" stroke-width="3" />
            <path d="M78 292L124 266M514 292L562 267" stroke="white" stroke-opacity=".14" stroke-width="2" />
        </svg>

        <div class="relative flex h-20 w-20 items-center justify-center rounded-[1.5rem] border border-white/30 bg-[var(--color-brand-navy)]/90 text-[var(--color-brand-orange-light)] shadow-xl ring-8 ring-white/5 backdrop-blur-sm transition-transform duration-200 group-hover/illustration:scale-105 md:h-24 md:w-24">
            <Icon :name="icon" :size="48" />
        </div>
    </div>
</template>
