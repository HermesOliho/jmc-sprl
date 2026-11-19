<script setup lang="ts">
import { computed } from 'vue'
import { classNames } from '@/utils'

const props = withDefaults(defineProps<{
    modelValue?: string
    label?: string
    error?: string
    placeholder?: string
    type?: string
    disabled?: boolean
    required?: boolean
    class?: string
}>(), {
    modelValue: '',
    type: 'text',
    disabled: false,
    required: false,
})

const emit = defineEmits<{
    'update:modelValue': [value: string]
}>()

function handleInput(e: Event) {
    const target = e.target as HTMLInputElement
    emit('update:modelValue', target.value)
}
</script>

<template>
    <div :class="$props.class">
        <label
            v-if="label"
            :for="label"
            class="mb-1.5 block text-sm font-medium text-[var(--color-ccm-gray-700)]"
        >
            {{ label }}
            <span v-if="required" class="text-red-500">*</span>
        </label>
        <input
            :id="label"
            :type="type"
            :value="modelValue"
            :placeholder="placeholder"
            :disabled="disabled"
            :required="required"
            :aria-invalid="!!error"
            :aria-describedby="error ? `${label}-error` : undefined"
            :class="classNames(
                'block w-full rounded-lg border px-4 py-3 text-sm transition-all duration-200',
                'bg-white text-[var(--color-ccm-gray-900)]',
                'placeholder:text-[var(--color-ccm-gray-400)]',
                'focus:border-[var(--color-ccm-blue)] focus:ring-2 focus:ring-[var(--color-ccm-blue)]/20 focus:outline-none',
                error
                    ? 'border-red-300 focus:border-red-500 focus:ring-red-500/20'
                    : 'border-[var(--color-ccm-gray-300)]',
                disabled && 'cursor-not-allowed bg-[var(--color-ccm-gray-100)] opacity-60',
            )"
            @input="handleInput"
        />
        <p
            v-if="error"
            :id="`${label}-error`"
            class="mt-1 text-sm text-red-600"
            role="alert"
        >
            {{ error }}
        </p>
    </div>
</template>
