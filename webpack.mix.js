const mix = require("laravel-mix");

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

mix.js("resources/js/app.js", "public/js").version();
mix.styles("public/css/main.css", "public/css/main-mix.css").version();
mix.styles(
    "public/css/main-print.css",
    "public/css/main-mix-print.css"
).version();
mix.sass("resources/sass/app.scss", "public/css").version();
