const mix = require('laravel-mix');
const tailwindcss = require('tailwindcss');

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
