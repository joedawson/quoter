let mix = require('laravel-mix');
let build = require('./tasks/build.js');
let tailwindcss = require('tailwindcss');

mix.disableSuccessNotifications();
mix.setPublicPath('source/assets/build');

mix.webpackConfig({
    plugins: [
        build.jigsaw,
        build.browserSync(),
        build.watch([
            'source/**/*.md',
            'source/**/*.php',
            'source/**/*.scss',
            '!source/**/_tmp/*']
        ),
    ]
});

mix.sass('source/_assets/sass/app.scss', 'css/app.css')
  .options({
    processCssUrls: false,
    postCss: [ tailwindcss() ],
  }).version()