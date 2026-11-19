import { defineStore } from 'pinia'
import { ref, computed } from 'vue'

export const useAppStore = defineStore('app', () => {
    const isLoading = ref(false)
    const isMobileMenuOpen = ref(false)

    const isMenuOpen = computed(() => isMobileMenuOpen.value)

    function setLoading(value: boolean) {
        isLoading.value = value
    }

    function toggleMobileMenu() {
        isMobileMenuOpen.value = !isMobileMenuOpen.value
    }

    function closeMobileMenu() {
        isMobileMenuOpen.value = false
    }

    function openMobileMenu() {
        isMobileMenuOpen.value = true
    }

    return {
        isLoading,
        isMobileMenuOpen,
        isMenuOpen,
        setLoading,
        toggleMobileMenu,
        closeMobileMenu,
        openMobileMenu,
    }
})
