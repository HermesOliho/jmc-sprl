import { ref, onMounted, onUnmounted } from 'vue'

export function useScroll() {
    const scrollY = ref(0)
    const isScrolled = ref(false)
    const scrollDirection = ref<'up' | 'down'>('up')

    let lastScrollY = 0

    function handleScroll() {
        scrollY.value = window.scrollY
        isScrolled.value = window.scrollY > 50
        scrollDirection.value = window.scrollY > lastScrollY ? 'down' : 'up'
        lastScrollY = window.scrollY
    }

    onMounted(() => {
        handleScroll()
        window.addEventListener('scroll', handleScroll, { passive: true })
    })

    onUnmounted(() => {
        window.removeEventListener('scroll', handleScroll)
    })

    return { scrollY, isScrolled, scrollDirection }
}
