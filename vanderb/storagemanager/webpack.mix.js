let mix = require('laravel-mix');

/*
 |--------------------------------------------------------------------------
 | Mix Asset Management
 |--------------------------------------------------------------------------
 |
 | Mix provides a clean, fluent API for defining some Webpack build steps
 | for your Laravel application. By default, we are compiling the Sass
 | file for your application, as well as bundling up your JS files.
 |
 */

mix.js('src/resources/js/storagemanager.js', 'dist/').webpackConfig({
    resolve: {
        extensions: ['*', '.js', '.jsx', '.vue'],
        alias: {
            'bootstrap': path.resolve(__dirname, './node_modules/bootstrap/scss/bootstrap.scss')
        }
    }
});
