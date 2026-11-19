export function truncate(text: string, maxLength: number, suffix = '...'): string {
    if (text.length <= maxLength) return text

    const truncated = text.slice(0, maxLength - suffix.length).trimEnd()
    return `${truncated}${suffix}`
}
