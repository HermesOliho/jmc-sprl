/// <reference types="vite/client" />

declare module '*.vue' {
    import type { DefineComponent } from 'vue'
    const component: DefineComponent<Record<string, unknown>, Record<string, unknown>, unknown>
    export default component
}

import type { AxiosStatic } from 'axios'

declare global {
    interface Window {
        axios: AxiosStatic
    }

    interface RouteController {
        current(name?: string): boolean
        has(name: string): boolean
        params: Record<string, string | number | undefined>
    }

    function route(
        name: string,
        params?: Record<string, string | number> | string | number,
        absolute?: boolean,
    ): string
    function route(): RouteController
}

declare module 'vue' {
    interface ComponentCustomProperties {
        route: typeof route
    }
}

declare module '@inertiajs/core' {
    interface InertiaConfig {
        sharedPageProps: {
            auth: {
                user: {
                    id: number
                    name: string
                    email: string
                    email_verified_at: string | null
                } | null
            }
        }
    }
}

export {}
