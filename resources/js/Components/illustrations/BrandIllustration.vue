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
        viewBox="0 0 640 440"
        fill="none"
        xmlns="http://www.w3.org/2000/svg"
        aria-hidden="true"
    >
        <circle cx="504" cy="84" r="84" fill="#FE5900" fill-opacity=".1" />
        <circle cx="504" cy="84" r="56" stroke="#FF7A2F" stroke-opacity=".28" stroke-width="2" />
        <circle cx="92" cy="102" r="3" fill="white" fill-opacity=".5" />
        <circle cx="116" cy="102" r="3" fill="white" fill-opacity=".3" />
        <circle cx="140" cy="102" r="3" fill="white" fill-opacity=".18" />
        <path d="M42 374H598M78 398H562" stroke="white" stroke-opacity=".18" stroke-width="2" />
        <path d="M74 350L137 314M521 350L584 314" stroke="white" stroke-opacity=".12" stroke-width="2" />

        <g v-if="$props.variant === 'construction'" stroke-linecap="round" stroke-linejoin="round">
            <path d="M214 356V210L320 151L427 210V356H214Z" fill="#25309B" stroke="white" stroke-opacity=".72" stroke-width="3" />
            <path d="M214 210L320 264L427 210M320 264V356" stroke="white" stroke-opacity=".72" stroke-width="3" />
            <path d="M238 222V332M279 243V332M361 243V332M402 222V332M214 285H427" stroke="white" stroke-opacity=".42" stroke-width="3" />
            <path d="M266 356V332H300V356M340 356V332H374V356" fill="#0A1152" stroke="white" stroke-opacity=".5" stroke-width="2" />
            <path d="M320 151V68M320 83H526M351 83L320 151M485 83L526 122" stroke="#FF7A2F" stroke-width="6" />
            <path d="M510 83V149M496 149H524M300 68H340M306 54H334" stroke="#FF7A2F" stroke-width="4" />
            <path d="M112 356V267L165 238L218 267V356H112Z" fill="#101A79" stroke="white" stroke-opacity=".45" stroke-width="2" />
            <path d="M133 278V328M165 278V328M197 278V328M112 303H218" stroke="#FF7A2F" stroke-opacity=".8" stroke-width="3" />
            <path d="M74 374L163 356H453L560 374" stroke="#FF7A2F" stroke-opacity=".42" stroke-width="3" />
        </g>

        <g v-else-if="$props.variant === 'planning'">
            <path d="M142 126L353 76L512 155V325L300 375L142 296V126Z" fill="#151F78" stroke="white" stroke-opacity=".68" stroke-width="3" />
            <path d="M169 143L347 101L485 168V304L307 347L169 279V143Z" fill="#0A1152" stroke="#FF7A2F" stroke-opacity=".72" stroke-width="2" />
            <path d="M194 161L347 124L460 179M194 194L347 157L460 212M194 227L307 283L460 245M307 124V283M354 145V271M242 149V251" stroke="white" stroke-opacity=".36" stroke-width="2" />
            <path d="M196 260L270 207L316 225L382 168L456 204" stroke="#FF7A2F" stroke-width="5" stroke-linecap="round" stroke-linejoin="round" />
            <circle cx="270" cy="207" r="6" fill="white" />
            <circle cx="382" cy="168" r="6" fill="#FF7A2F" />
            <path d="M96 175V318M82 191H110M82 214H102M82 237H110M82 260H102M82 283H110M82 306H102" stroke="white" stroke-opacity=".58" stroke-width="3" stroke-linecap="round" />
            <path d="M125 365H526" stroke="#FF7A2F" stroke-opacity=".7" stroke-width="3" />
            <circle cx="125" cy="365" r="6" fill="#FF7A2F" />
            <circle cx="526" cy="365" r="6" fill="#FF7A2F" />
        </g>

        <g v-else-if="$props.variant === 'location'">
            <path d="M64 300L174 221L259 245L370 142L485 183L582 117V355H64V300Z" fill="#151F78" />
            <path d="M64 300L174 221L259 245L370 142L485 183L582 117" stroke="white" stroke-opacity=".46" stroke-width="3" />
            <path d="M65 330L173 254L258 278L370 175L485 216L582 150M64 355L174 286L259 311L370 208L485 249L582 183" stroke="white" stroke-opacity=".18" stroke-width="2" />
            <path d="M106 350C150 337 155 292 204 282C249 273 271 313 319 295C373 275 359 230 414 216C460 204 489 231 535 198" stroke="#0A1152" stroke-width="24" stroke-linecap="round" />
            <path d="M106 350C150 337 155 292 204 282C249 273 271 313 319 295C373 275 359 230 414 216C460 204 489 231 535 198" stroke="#FF7A2F" stroke-width="5" stroke-dasharray="2 15" stroke-linecap="round" />
            <circle cx="204" cy="282" r="10" fill="#FF7A2F" stroke="white" stroke-width="3" />
            <circle cx="414" cy="216" r="10" fill="#FF7A2F" stroke="white" stroke-width="3" />
            <path d="M319 243C300 243 285 258 285 277C285 303 319 330 319 330C319 330 353 303 353 277C353 258 338 243 319 243Z" fill="#FE5900" stroke="white" stroke-width="3" />
            <circle cx="319" cy="277" r="9" fill="white" />
        </g>

        <g v-else>
            <path d="M125 355V247L209 204L293 247V355H125Z" fill="#25309B" stroke="white" stroke-opacity=".65" stroke-width="3" />
            <path d="M293 355V205L395 151L497 205V355H293Z" fill="#101A79" stroke="white" stroke-opacity=".78" stroke-width="3" />
            <path d="M497 355V253L545 228L593 253V355H497Z" fill="#25309B" stroke="white" stroke-opacity=".52" stroke-width="2" />
            <path d="M125 247L209 290L293 247M293 205L395 257L497 205M395 257V355" stroke="white" stroke-opacity=".62" stroke-width="3" />
            <path d="M151 265V332M181 280V332M237 280V332M267 265V332M323 225V330M359 244V330M431 244V330M467 225V330M516 268V331M545 282V331M574 268V331" stroke="#FF7A2F" stroke-opacity=".82" stroke-width="4" />
            <path d="M293 180L395 127L497 180" stroke="#FF7A2F" stroke-width="4" stroke-linecap="round" stroke-linejoin="round" />
            <path d="M158 355V330H190V355M356 355V329H389V355M426 355V329H459V355" fill="#0A1152" stroke="white" stroke-opacity=".5" stroke-width="2" />
            <path d="M72 355H600" stroke="white" stroke-opacity=".28" stroke-width="2" />
            <circle cx="395" cy="90" r="10" fill="#FF7A2F" />
            <path d="M395 55V39M430 90H446M420 65L432 53M370 65L358 53" stroke="#FF7A2F" stroke-opacity=".8" stroke-width="3" stroke-linecap="round" />
        </g>
    </svg>
</template>
