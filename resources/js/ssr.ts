import { createInertiaApp } from '@inertiajs/vue3'
import createServer from '@inertiajs/vue3/server'
import { renderToString } from '@vue/server-renderer'
import { resolvePageComponent } from 'laravel-vite-plugin/inertia-helpers'
import { createSSRApp, DefineComponent, h } from 'vue'
import { createPinia } from 'pinia'
import { ZiggyVue } from '../../vendor/tightenco/ziggy'

createServer((page) =>
    createInertiaApp({
        page,
        render: renderToString,
        resolve: (name) =>
            resolvePageComponent(
                `./Pages/${name}.vue`,
                import.meta.glob<DefineComponent>('./Pages/**/*.vue'),
            ),
        setup({ App, props, plugin }) {
            const pinia = createPinia()
            const ziggy = page.props.ziggy as Record<string, unknown> | undefined

            return createSSRApp({ render: () => h(App, props) })
                .use(plugin)
                .use(pinia)
                .use(ZiggyVue, {
                    ...(typeof ziggy === 'object' ? ziggy : {}),
                    location: new URL(
                        typeof ziggy?.location === 'string'
                            ? ziggy.location
                            : 'http://localhost',
                    ),
                } as never)
        },
    }),
)
