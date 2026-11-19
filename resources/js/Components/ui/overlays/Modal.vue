<script setup lang="ts">
import { ref, watch, onMounted, onUnmounted } from 'vue'
import { classNames } from '@/utils'
import Icon from '@/Components/ui/icons/Icon.vue'

const props = withDefaults(defineProps<{
    open?: boolean
    title?: string
    maxWidth?: 'sm' | 'md' | 'lg' | 'xl'
    closeable?: boolean
    class?: string
}>(), {
    open: false,
    maxWidth: 'md',
    closeable: true,
})

const emit = defineEmits<{
    close: []
    'update:open': [value: boolean]
}>()

const visible = ref(false)
const showing = ref(false)

const widthClass = computed(() => {
    switch (props.maxWidth) {
        case 'sm':
            return 'max-w-sm'
        case 'lg':
            return 'max-w-lg'
        case 'xl':
            return 'max-w-xl'
        default:
            return 'max-w-md'
    }
})

import { computed } from 'vue'

watch(
    () => props.open,
    (value) => {
        if (value) {
            visible.value = true
            requestAnimationFrame(() => {
                showing.value = true
            })
            document.body.style.overflow = 'hidden'
        } else {
            showing.value = false
            setTimeout(() => {
                visible.value = false
                document.body.style.overflow = ''
            }, 200)
        }
    },
)

function close() {
    if (!props.closeable) return
    emit('close')
    emit('update:open', false)
}

function handleKeydown(e: KeyboardEvent) {
    if (e.key === 'Escape' && props.closeable) close()
}

onMounted(() => document.addEventListener('keydown', handleKeydown))
onUnmounted(() => {
    document.removeEventListener('keydown', handleKeydown)
    document.body.style.overflow = ''
})
</script>

<template>
    <Teleport to="body">
        <Transition name="modal">
            <div
                v-if="visible"
                class="fixed inset-0 z-50 flex items-center justify-center p-4"
                role="dialog"
                :aria-modal="true"
                :aria-label="title"
            >
                <div
                    class="fixed inset-0 bg-black/50 transition-opacity duration-200"
                    @click="close"
                />
                <div
                    :class="classNames(
                        'relative w-full rounded-xl bg-white shadow-xl transition-all duration-200',
                        widthClass,
                        showing ? 'scale-100 opacity-100' : 'scale-95 opacity-0',
                        $props.class,
                    )"
                >
                    <div
                        v-if="title"
                        class="flex items-center justify-between border-b border-[var(--color-ccm-gray-200)] px-6 py-4"
                    >
                        <h2 class="text-lg font-semibold text-[var(--color-ccm-gray-900)]">
                            {{ title }}
                        </h2>
                        <button
                            v-if="closeable"
                            type="button"
                            class="rounded-lg p-1 text-[var(--color-ccm-gray-400)] hover:bg-[var(--color-ccm-gray-100)] hover:text-[var(--color-ccm-gray-600)]"
                            aria-label="Fermer"
                            @click="close"
                        >
                            <Icon name="x" :size="20" />
                        </button>
                    </div>
                    <div class="p-6">
                        <slot />
                    </div>
                </div>
            </div>
        </Transition>
    </Teleport>
</template>
