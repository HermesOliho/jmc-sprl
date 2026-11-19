import { defineStore } from 'pinia'
import { ref, computed } from 'vue'
import { NAVIGATION } from '@/config/navigation'
import type { NavigationItem } from '@/types'

export const useNavigationStore = defineStore('navigation', () => {
    const items = ref<NavigationItem[]>(NAVIGATION)
    const currentRoute = ref('')

    function setCurrentRoute(path: string) {
        currentRoute.value = path
    }

    const isActive = computed(() => (href: string) => {
        if (href === '/') return currentRoute.value === '/'
        return currentRoute.value.startsWith(href)
    })

    return { items, currentRoute, setCurrentRoute, isActive }
})
