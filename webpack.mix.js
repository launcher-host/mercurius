let mix = require('laravel-mix');
var path = require('path');


mix.js('resources/js/bootstrap.js', 'publishable/public/js/mercurius.js')
    .sass('resources/sass/mercurius.scss', 'publishable/public/css/mercurius.css')
    .options({
        processCssUrls: false
    })
    .webpackConfig({
        resolve: {
            modules: [
                path.resolve(__dirname, 'vendor/launcher/mercurius/resources/js'),
                'node_modules'
            ],
            alias: {
                'vue$': 'vue/dist/vue.js'
            }
        }
    });
