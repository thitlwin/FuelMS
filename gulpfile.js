var gulp = require('gulp');
var rename = require('gulp-rename');
var elixir = require('laravel-elixir');

/*
 |--------------------------------------------------------------------------
 | Elixir Asset Management
 |--------------------------------------------------------------------------
 |
 | Elixir provides a clean, fluent API for defining some basic Gulp tasks
 | for your Laravel application. By default, we are compiling the Less
 | file for our application, as well as publishing vendor resources.
 |
 */

  gulp.src("vendor/bower_dl/selectize/dist/css/**")
      .pipe(gulp.dest("public/assets/selectize/css"));

  gulp.src("vendor/bower_dl/selectize/dist/js/standalone/selectize.min.js")
      .pipe(gulp.dest("public/assets/selectize/"));

elixir(function(mix) {
    mix.less('app.less');
    mix.less('admin-lte/AdminLTE.less');
    mix.less('bootstrap/bootstrap.less');
});
