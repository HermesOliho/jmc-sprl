import type { Address } from '@/types'

export function formatAddress(address: Address, options: { withCountry?: boolean } = {}): string {
    const { withCountry = true } = options

    return [address.street, address.city, address.province, withCountry ? address.country : '']
        .filter((part) => Boolean(part?.trim()))
        .join(', ')
}
