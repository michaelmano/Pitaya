'use strict';

const gulp             = require('gulp');
const sass             = require('gulp-sass');
const prefix           = require('gulp-autoprefixer');
const browserSync      = require('browser-sync').create();
const paths = {
  styles: {
    src: './assets/stylesheets/',
    files: './assets/stylesheets/**/*.scss',
    dest: ''
  }
}
gulp.task('serve', ['sass'], function() {

    browserSync.init({
        server: "./"
    });

    gulp.watch("./assets/stylesheets/*.scss", ['sass']);
    gulp.watch("./*.html").on('change', browserSync.reload);
});

gulp.task('sass', function () {
  output({
    sourceComments: 'map',
    includePaths : [paths.styles.src]
  });
})

gulp.task('production', function (){
  output({
    outputStyle: 'compressed',
    includePaths : [paths.styles.src]
  });
})

gulp.task('default', ['sass'], function() {
  gulp.watch(paths.styles.files, ['sass'])
  .on('change', function(evt) {
    console.log( '[watcher] File ' + evt.path.replace(/.*(?=sass)/,'') + ' was ' + evt.type + ', compiling...')
  })
})

function output(args) {
  gulp.src(paths.styles.files)
  .pipe(sass(args))
  .on('error', function(err) {
    console.log(err)
  })
  .pipe(prefix(
    'last 2 version', 'safari 5', 'ie 8', 'ie 9', 'opera 12.1', 'ios 6', 'android 4'
  ))
  .pipe(gulp.dest(paths.styles.dest))
  .pipe(browserSync.stream())
}
