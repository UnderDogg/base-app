var dir, elixir = require('laravel-elixir');

/*
 |--------------------------------------------------------------------------
 | Elixir Asset Management
 |--------------------------------------------------------------------------
 |
 | Elixir provides a clean, fluent API for defining some basic Gulp tasks
 | for your Laravel application. By default, we are compiling the Sass
 | file for our application, as well as publishing vendor resources.
 |
 */

dir = {
    asset: {
        css: 'public/css',
        img: 'public/img',
        js: 'public/js'
    },
    vendor: 'vendor/bower_components'
};

elixir(function(mix) {
    mix.scripts([
        'libs/jquery.min.js',
        'libs/bootstrap.min.js',
        'libs/dropzone.min.js',
        'libs/sweetalert.min.js',
        'libs/bootstrap-editable.min.js',
        'libs/bootstrap-markdown.js',
        'libs/bootstrap-switch.min.js',
        'libs/markdown.js',
        'libs/to-markdown.js',
        'libs/select2.min.js',
        'app.js'
    ]).styles([
        'libs/bootstrap.min.css',
        'libs/dropzone.min.css',
        'libs/font-awesome.min.css',
        'libs/sweetalert.css',
        'libs/bootstrap-editable.css',
        'libs/bootstrap-markdown.min.css',
        'libs/bootstrap-switch.min.css',
        'libs/select2.css',
        'libs/select2-bootstrap.css',
        'app.css'
    ])
        .copy('resources/assets/fonts/libs/font-awesome/', 'public/fonts')
        .copy('resources/assets/fonts/libs/bootstrap/', 'public/fonts')
        .copy('resources/assets/img/libs/', 'public/css');
});
