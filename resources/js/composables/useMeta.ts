import { computed } from 'vue'
import type { MetaInfo } from '@/types'
import { APP_NAME, APP_DESCRIPTION } from '@/constants'

export function useMeta(customMeta?: Partial<MetaInfo>) {
    const defaults: MetaInfo = {
        title: APP_NAME,
        description: APP_DESCRIPTION,
        ogType: 'website',
        twitterCard: 'summary_large_image',
    }

    const meta = computed<MetaInfo>(() => ({
        ...defaults,
        ...customMeta,
    }))

    const title = computed(() => {
        const t = meta.value.title
        return t === APP_NAME ? t : `${t} — ${APP_NAME}`
    })

    return { meta, title }
}
