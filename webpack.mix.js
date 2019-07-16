// eslint-disable-next-line import/no-extraneous-dependencies
const mix = require('laravel-mix')
const tailwindcss = require('tailwindcss')

/*
 |--------------------------------------------------------------------------
 | Mix Asset Management
 |--------------------------------------------------------------------------
 |
 | Mix provides a clean, fluent API for defining some Webpack build steps
 | for your Laravel application. By default, we are compiling the Sass
 | file for the application as well as bundling up all the JS files.
 |
 */

mix.js('resources/assets/js/app.js', 'public/js')
    .sass('resources/assets/sass/app.scss', 'public/css')
    .options({
        processCssUrls: false,
        postCss: [ tailwindcss('./tailwind.config.js') ],
    })
    .copyDirectory('resources/assets/images', 'public/images')
    .version()
    .sourceMaps()

mix.webpackConfig({
    watchOptions: {
        ignored: [
            /node_modules/,
            /vendor/,
        ],
    },
})

mix.browserSync({
    proxy: process.env.APP_URL,
})
