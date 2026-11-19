export function formatDate(date: Date | string | number, options?: Intl.DateTimeFormatOptions): string {
    const d = typeof date === 'string' || typeof date === 'number' ? new Date(date) : date
    const locale = 'fr-FR'

    const defaults: Intl.DateTimeFormatOptions = {
        day: 'numeric',
        month: 'long',
        year: 'numeric',
    }

    return d.toLocaleDateString(locale, { ...defaults, ...options })
}

export function formatDateShort(date: Date | string | number): string {
    const d = typeof date === 'string' || typeof date === 'number' ? new Date(date) : date
    return d.toLocaleDateString('fr-FR', {
        day: 'numeric',
        month: 'short',
        year: 'numeric',
    })
}

export function formatDateISO(date: Date | string | number): string {
    const d = typeof date === 'string' || typeof date === 'number' ? new Date(date) : date
    return d.toISOString().split('T')[0]
}
