export function scrollToTop(behavior: ScrollBehavior = 'smooth'): void {
    window.scrollTo({ top: 0, behavior })
}

export function scrollToElement(el: HTMLElement | string, offset = 80, behavior: ScrollBehavior = 'smooth'): void {
    const element = typeof el === 'string' ? document.querySelector(el) : el
    if (!element) return

    const top = element.getBoundingClientRect().top + window.scrollY - offset
    window.scrollTo({ top, behavior })
}
