type ClassValue = string | number | boolean | null | undefined | ClassValue[]

export function classNames(...args: ClassValue[]): string {
    const classes: string[] = []

    for (const arg of args) {
        if (!arg) continue

        if (typeof arg === 'string' || typeof arg === 'number') {
            classes.push(String(arg))
        } else if (Array.isArray(arg)) {
            const inner = classNames(...arg)
            if (inner) classes.push(inner)
        }
    }

    return classes.join(' ')
}
