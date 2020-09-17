const mix = require('laravel-mix');

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

mix
    .setResourceRoot('../')
    .setPublicPath('public')
    .js('resources/js/app.js', 'public/js')
    .autoload({
        jquery: ['$', 'window.jQuery', 'jQuery'],
    })
    ;
    // .sass('resources/sass/style.scss', 'public/css', {
    //     includePaths: ['node_modules']
    // })
    // .sass('resources/sass/colors/yellow.scss', 'public/css');

