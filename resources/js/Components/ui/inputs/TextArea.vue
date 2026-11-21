<script setup lang="ts">
import { classNames } from '@/utils'

const props = withDefaults(defineProps<{
    modelValue?: string
    label?: string
    error?: string
    placeholder?: string
    rows?: number
    disabled?: boolean
    required?: boolean
    class?: string
}>(), {
    modelValue: '',
    rows: 4,
    disabled: false,
    required: false,
})

const emit = defineEmits<{
    'update:modelValue': [value: string]
}>()

function handleInput(e: Event) {
    const target = e.target as HTMLTextAreaElement
    emit('update:modelValue', target.value)
}
</script>

<template>
    <div :class="$props.class">
        <label
            v-if="label"
            :for="label"
            class="mb-1.5 block text-sm font-medium text-[var(--color-content)]"
        >
            {{ label }}
            <span v-if="required" class="text-[var(--color-error)]">*</span>
        </label>
        <textarea
            :id="label"
            :value="modelValue"
            :placeholder="placeholder"
            :rows="rows"
            :disabled="disabled"
            :required="required"
            :aria-invalid="!!error"
            :aria-describedby="error ? `${label}-error` : undefined"
            :class="classNames(
                'block w-full rounded-lg border px-4 py-3 text-sm transition-all duration-200',
                'bg-[var(--color-surface)] text-[var(--color-content)]',
                'placeholder:text-[var(--color-content-placeholder)]',
                'resize-y',
                'focus:border-[var(--color-action)] focus:ring-2 focus:ring-[var(--color-action)]/20 focus:outline-none',
                error
                    ? 'border-[var(--color-error)]/40 focus:border-[var(--color-error)] focus:ring-[var(--color-error)]/20'
                    : 'border-[var(--color-border-strong)]',
                disabled && 'cursor-not-allowed bg-[var(--color-surface-elevated)] opacity-60',
            )"
            @input="handleInput"
        />
        <p
            v-if="error"
            :id="`${label}-error`"
            class="mt-1 text-sm text-[var(--color-error)]"
            role="alert"
        >
            {{ error }}
        </p>
    </div>
</template>
