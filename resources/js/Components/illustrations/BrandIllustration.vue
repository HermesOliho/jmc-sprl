<script setup lang="ts">
import { classNames } from '@/utils'

withDefaults(
    defineProps<{
        variant?: 'construction' | 'planning' | 'location' | 'organization'
        class?: string
    }>(),
    {
        variant: 'construction',
    },
)
</script>

<template>
    <svg
        :class="classNames('h-auto w-full', $props.class)"
        viewBox="0 0 520 380"
        fill="none"
        xmlns="http://www.w3.org/2000/svg"
        aria-hidden="true"
    >
        <circle cx="394" cy="90" r="72" fill="#FE5900" fill-opacity=".12" />
        <circle cx="394" cy="90" r="48" stroke="#FF7A2F" stroke-opacity=".4" />
        <path d="M40 320H480" stroke="white" stroke-opacity=".24" stroke-width="2" />
        <path d="M70 342H450" stroke="white" stroke-opacity=".12" />

        <path
            d="M195 320V145L286 98L376 145V320H195Z"
            fill="#25309B"
            stroke="white"
            stroke-opacity=".76"
            stroke-width="3"
        />
        <path d="M195 145L286 190L376 145" stroke="white" stroke-opacity=".7" stroke-width="3" />
        <path d="M286 190V320" stroke="white" stroke-opacity=".7" stroke-width="3" />
        <path d="M221 164V292M253 180V292M318 180V292M350 164V292" stroke="white" stroke-opacity=".42" stroke-width="3" />
        <path d="M195 222H376M195 270H376" stroke="white" stroke-opacity=".32" stroke-width="3" />
        <path d="M211 320V292H244V320M300 320V292H333V320" fill="#0A1152" stroke="white" stroke-opacity=".52" stroke-width="2" />

        <path d="M86 320V234L138 207L190 234V320H86Z" fill="#101A79" stroke="white" stroke-opacity=".62" stroke-width="2" />
        <path d="M104 250V303M138 250V303M172 250V303" stroke="#FF7A2F" stroke-opacity=".8" stroke-width="5" />
        <path d="M86 264H190" stroke="white" stroke-opacity=".34" stroke-width="2" />

        <g v-if="$props.variant === 'construction'" stroke="#FF7A2F" stroke-linecap="round" stroke-linejoin="round">
            <path d="M286 98V55M286 62H435M315 62L286 98M402 62L435 98" stroke-width="5" />
            <path d="M422 62V112M410 112H434" stroke-width="4" />
            <path d="M270 55H302M274 45H298" stroke-width="4" />
        </g>

        <g v-else-if="$props.variant === 'planning'">
            <path d="M54 103L119 68L184 103V174L119 209L54 174V103Z" fill="#0A1152" stroke="white" stroke-opacity=".55" stroke-width="2" />
            <path d="M73 111L119 86L165 111M73 132L119 157L165 132M119 86V157M94 99V144M144 99V144" stroke="#FF7A2F" stroke-opacity=".9" stroke-width="3" />
            <circle cx="119" cy="157" r="5" fill="white" />
        </g>

        <g v-else-if="$props.variant === 'location'">
            <path d="M45 177C91 177 98 217 138 217C176 217 180 187 219 187" stroke="#FF7A2F" stroke-width="5" stroke-dasharray="9 10" stroke-linecap="round" />
            <circle cx="64" cy="177" r="10" fill="#FF7A2F" />
            <circle cx="219" cy="187" r="10" fill="white" />
            <path d="M138 183C125 183 114 194 114 207C114 225 138 244 138 244C138 244 162 225 162 207C162 194 151 183 138 183Z" fill="#FE5900" stroke="white" stroke-width="2" />
            <circle cx="138" cy="207" r="6" fill="white" />
        </g>

        <g v-else-if="$props.variant === 'organization'">
            <path d="M106 91H168M118 76H156M130 61H144" stroke="white" stroke-opacity=".45" stroke-width="3" stroke-linecap="round" />
            <path d="M79 194L138 164L197 194" stroke="#FF7A2F" stroke-opacity=".75" stroke-width="3" stroke-linecap="round" stroke-linejoin="round" />
            <circle cx="138" cy="164" r="6" fill="#FF7A2F" />
        </g>
    </svg>
</template>
