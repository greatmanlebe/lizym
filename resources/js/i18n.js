import { createI18n } from 'vue-i18n/dist/vue-i18n.esm-bundler.js'
import en from './lang/en.json'
import fr from './lang/fr.json'

export default function setupI18n(locale = 'en') {
    return createI18n({
        legacy: false,
        locale,
        fallbackLocale: 'en',
        messages: { en, fr }
    })
}
