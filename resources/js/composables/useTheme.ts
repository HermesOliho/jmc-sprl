import { computed, ref } from 'vue'

type ThemeMode = 'light' | 'dark'

const STORAGE_KEY = 'jmc-theme'
const theme = ref<ThemeMode>('light')
let initialized = false

function systemPrefersDark(): boolean {
    return typeof window !== 'undefined'
        && window.matchMedia('(prefers-color-scheme: dark)').matches
}

function storedTheme(): ThemeMode | null {
    if (typeof window === 'undefined') {
        return null
    }

    const stored = window.localStorage.getItem(STORAGE_KEY)

    return stored === 'light' || stored === 'dark' ? stored : null
}

function applyTheme(mode: ThemeMode): void {
    theme.value = mode

    if (typeof document === 'undefined') {
        return
    }

    document.documentElement.setAttribute('data-theme', mode === 'dark' ? 'jmc-dark' : 'jmc-light')
    document.documentElement.style.colorScheme = mode
}

export function initTheme(): void {
    if (initialized) {
        return
    }

    initialized = true
    applyTheme(storedTheme() ?? (systemPrefersDark() ? 'dark' : 'light'))

    if (typeof window !== 'undefined') {
        window.matchMedia('(prefers-color-scheme: dark)').addEventListener('change', (event) => {
            if (!storedTheme()) {
                applyTheme(event.matches ? 'dark' : 'light')
            }
        })
    }
}

export function useTheme() {
    function toggle(): void {
        const next = theme.value === 'light' ? 'dark' : 'light'
        applyTheme(next)

        if (typeof window !== 'undefined') {
            window.localStorage.setItem(STORAGE_KEY, next)
        }
    }

    function set(mode: ThemeMode): void {
        applyTheme(mode)

        if (typeof window !== 'undefined') {
            window.localStorage.setItem(STORAGE_KEY, mode)
        }
    }

    return {
        theme,
        isDark: computed(() => theme.value === 'dark'),
        toggle,
        set,
    }
}
