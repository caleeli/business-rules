const mix = require('laravel-mix');

mix.setPublicPath('public')
  .js('resources/js/package.js', 'js')
  .sass('resources/sass/package.scss', 'css')
  .js('resources/js/screen-builder-form-components.js', 'js')
  .version();
