const mix = require('laravel-mix');

/*
 |--------------------------------------------------------------------------
 | Mix Asset Management
 |--------------------------------------------------------------------------
 |
 | Mix provides a clean, fluent API for defining some Webpack build steps
 | for your Laravel applications. By default, we are compiling the CSS
 | file for the application as well as bundling up all the JS files.
 |
 */
require('dotenv').config();

let proxy_url = process.env.BROWSERSYNC_PROXY_URL || 'http://my-project.local/';

mix
    .js('resources/js/app.js', 'public/js')
    .sass('resources/scss/style.scss', 'css')
    .options({
        autoprefixer: {
            options: {
                browsers: [
                    'last 6 versions',
                ]
            }
        }
    })
    .minify('public/css/style.css')
    .minify('public/js/app.js')
    .browserSync({
        proxy: proxy_url,
        files: [
            'public/js/**/*.js',
            'public/css/**/*.css',
            'app/**/*.php',
            'resources/views/**/*.php'
        ],
    })
    .autoload({
        jquery: ['$', 'window.jQuery']
    })
    .setPublicPath('public')
    .sourceMaps()
    .version()
    .webpackConfig(require('./webpack.config'));
