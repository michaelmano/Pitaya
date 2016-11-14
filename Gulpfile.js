'use strict';

const gulp    = require('gulp');
const sass    = require('gulp-sass');
const prefix  = require('gulp-autoprefixer');
const uglify  = require('gulp-uglifyjs');
const concat  = require('gulp-concat');

const paths = {
  styles: {
    src: './assets/stylesheets/scss/',
    files: './assets/stylesheets/scss/**/*.scss',
    dest: './assets/stylesheets/'
  },
  scripts: {
    src: './assets/javascripts/',
    files: ['./assets/javascripts/vendors/*.js', './assets/javascripts/*.js'],
    dest: './assets/javascripts/'
  }
}
gulp.task('serve', ['development'], function() {
  gulp.watch(['./assets/stylesheets/scss/*.scss', './assets/javascripts/**/*.js'], ['development']);
});

gulp.task('development', function () {
  output({
    sourceComments: 'map',
    includePaths : [paths.styles.src]
  });
})

gulp.task('production', function (){
  output({
    production: true,
    outputStyle: 'compressed',
    includePaths : [paths.styles.src]
  });
})

gulp.task('default', ['development'], function() {
  gulp.watch(['./assets/stylesheets/scss/**/*.scss', './assets/javascripts/**/*.js'], ['development'])
  .on('change', function(evt) {
    console.log( '[watcher] File ' + evt.path.replace(/.*(?=sass)/,'') + ' was ' + evt.type + ', compiling...')
  })
})

function output(args) {
  if (args.production === true) {
    gulp.src(paths.scripts.files)
      .pipe(uglify())
      .pipe(concat('site.js'))
      .pipe(gulp.dest(paths.scripts.dest))
  } else {
    gulp.src(paths.scripts.files)
      .pipe(concat('site.js'))
      .pipe(gulp.dest(paths.scripts.dest))
  }
  gulp.src(paths.styles.files)
  .pipe(sass(args))
  .on('error', function(err) {
    console.log(err)
  })
  .pipe(prefix(
    'last 2 version', 'safari 5', 'ie 8', 'ie 9', 'opera 12.1', 'ios 6', 'android 4'
  ))
  .pipe(gulp.dest(paths.styles.dest))
}