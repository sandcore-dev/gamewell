// eslint-disable-next-line import/no-extraneous-dependencies
const mix = require('laravel-mix');
// eslint-disable-next-line import/no-extraneous-dependencies
const EslintWebpackPlugin = require('eslint-webpack-plugin');

mix.webpackConfig({
    plugins: [
        new EslintWebpackPlugin({
            extensions: ['js', 'vue'],
            fix: true,
        }),
    ],
});

mix.js('resources/js/app.js', 'public/js')
    .sass('resources/sass/app.scss', 'public/css');

mix.vue();

if (mix.inProduction()) {
    mix.version();
}
