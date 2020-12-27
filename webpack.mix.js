let mix = require('laravel-mix');

mix.webpackConfig({    
   resolve: {      
     alias: {
       '@': __dirname + '/resources/assets/js',
       '@static' : __dirname + '/resources/assets/static',
     },    
   },  
 });

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
   .sass('resources/assets/sass/app.scss', 'public/css');

mix.disableNotifications();
