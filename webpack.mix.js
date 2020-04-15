// eslint-disable-next-line import/no-extraneous-dependencies
const mix = require('laravel-mix')
const tailwindcss = require('tailwindcss')
require('laravel-mix-purgecss')

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

mix.js('resources/js/app.js', 'public/js')
    .sass('resources/sass/app.scss', 'public/css')
    .options({
        processCssUrls: false,
        postCss: [ tailwindcss('./tailwind.config.js') ],
    })
    .purgeCss()
    .copyDirectory('resources/images', 'public/images')
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
