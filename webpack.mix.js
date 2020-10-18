const mix = require('laravel-mix');
const tailwindcss = require('tailwindcss');
require('laravel-mix-purgecss');

/*
 |--------------------------------------------------------------------------
 | JavaScript Configuration
 |--------------------------------------------------------------------------
 */

mix.ts('resources/js/app.ts', 'public/js');

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

mix.purgeCss();

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
