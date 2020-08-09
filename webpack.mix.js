/* eslint-disable import/no-extraneous-dependencies */
const mix = require('laravel-mix');
const tailwindcss = require('tailwindcss');
require('laravel-mix-purgecss');
/* eslint-enable import/no-extraneous-dependencies */

/*
 |--------------------------------------------------------------------------
 | JavaScript Configuration
 |--------------------------------------------------------------------------
 */

mix.js('resources/js/app.js', 'public/js');

/*
 |--------------------------------------------------------------------------
 | CSS Configuration
 |--------------------------------------------------------------------------
 */

mix.sass('resources/sass/app.scss', 'public/css').options({
    processCssUrls: false,
    postCss: [tailwindcss('./tailwind.config.js')],
});

/*
 |--------------------------------------------------------------------------
 | PurgeCSS Configuration
 |--------------------------------------------------------------------------
 */

mix.purgeCss({
    whitelistPatterns: [/pl-/],
    whitelistPatternsChildren: [/markdown-/],
});

/*
 |--------------------------------------------------------------------------
 | Webpack Configuration
 |--------------------------------------------------------------------------
 */

mix.webpackConfig({
    watchOptions: {
        ignored: [/node_modules/, /vendor/],
    },
});

/*
 |--------------------------------------------------------------------------
 | BrowserSync Configuration
 |--------------------------------------------------------------------------
 */

mix.browserSync({
    proxy: process.env.APP_URL,
});

/*
 |--------------------------------------------------------------------------
 | General Configuration
 |--------------------------------------------------------------------------
 */

mix.copyDirectory('resources/images', 'public/images').version().sourceMaps();
