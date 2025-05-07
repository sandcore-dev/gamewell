import pluginVue from 'eslint-plugin-vue'
import globals from 'globals'
import vueParser from 'vue-eslint-parser';
import pluginAirbnb from 'eslint-config-airbnb-base';

export default [
    ...pluginVue.configs['flat/strongly-recommended'],
    pluginAirbnb,
    {
        files: ["*.vue", "**/*.vue"],

        languageOptions: {
            globals: {
                ...globals.browser
            },
            sourceType: 'module',
            parser: vueParser,
        },
    },
    {
        rules: {
            indent: ["error", 4],
            // "no-alert": "warn",
            // "no-console": "warn",
            // "vue/multi-word-component-names": 0
        },
    }
]
