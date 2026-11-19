import { ref } from 'vue'

type ThemeMode = 'light' | 'dark'

const theme = ref<ThemeMode>('light')

export function useTheme() {
    function toggle() {
        theme.value = theme.value === 'light' ? 'dark' : 'light'
        applyTheme()
    }

    function set(mode: ThemeMode) {
        theme.value = mode
        applyTheme()
    }

    function applyTheme() {
        document.documentElement.setAttribute('data-theme', theme.value)
    }

    return { theme, toggle, set }
}
