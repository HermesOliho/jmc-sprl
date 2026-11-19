import { ref, computed, onMounted, onUnmounted } from 'vue'
import { BREAKPOINTS } from '@/constants'

type Breakpoint = keyof typeof BREAKPOINTS

export function useBreakpoint() {
    const width = ref(window.innerWidth)

    function handleResize() {
        width.value = window.innerWidth
    }

    onMounted(() => window.addEventListener('resize', handleResize))
    onUnmounted(() => window.removeEventListener('resize', handleResize))

    const current = computed<Breakpoint>(() => {
        const entries = Object.entries(BREAKPOINTS) as [Breakpoint, number][]
        let result: Breakpoint = 'xs'

        for (const [key, value] of entries) {
            if (width.value >= value) result = key
        }

        return result
    })

    const isMobile = computed(() => width.value < BREAKPOINTS.md)
    const isTablet = computed(() => width.value >= BREAKPOINTS.md && width.value < BREAKPOINTS.lg)
    const isDesktop = computed(() => width.value >= BREAKPOINTS.lg)

    const isAbove = (bp: Breakpoint) => width.value >= BREAKPOINTS[bp]
    const isBelow = (bp: Breakpoint) => width.value < BREAKPOINTS[bp]

    return { width, current, isMobile, isTablet, isDesktop, isAbove, isBelow }
}
