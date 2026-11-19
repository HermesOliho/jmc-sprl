export function throttle<T extends (...args: unknown[]) => unknown>(
    fn: T,
    delay = 300,
): (...args: Parameters<T>) => void {
    let lastCall = 0

    return (...args: Parameters<T>) => {
        const now = Date.now()
        if (now - lastCall < delay) return
        lastCall = now
        fn(...args)
    }
}
