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
mix.js('resources/js/app.js', 'public/js/app.js')

mix
.scripts([
        'resources/js/dashboard/core/jquery.min.js',
        'resources/js/dashboard/core/popper.min.js',
        'resources/js/dashboard/core/bootstrap-material-design.min.js',
        'resources/js/dashboard/plugins/default-passive-events.min.js',
        'resources/js/dashboard/plugins/perfect-scrollbar.jquery.min.js',
        'resources/js/dashboard/plugins/github-buttons.min.js',
        'resources/js/dashboard/plugins/chartist.min.js',
        'resources/js/dashboard/plugins/bootstrap-notify.js',
        'resources/js/dashboard/plugins/bootstrap-select.js',
        'resources/js/dashboard/plugins/fileinput.js',
        'node_modules/clipboard/dist/clipboard.js',
        'resources/js/dashboard/material-dashboard.js',
        'resources/js/dashboard/demo.js',
        'resources/js/vue-compiled.js',
        'resources/js/scripts.js'], 'public/js/scripts.js')
    .sass('resources/sass/app.scss', 'public/css').sourceMaps()
     .browserSync('localhost:8000');
