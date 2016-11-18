'use strict';

const gulp    = require('gulp');
const sass    = require('gulp-sass');
const prefix  = require('gulp-autoprefixer');
const uglify  = require('gulp-uglifyjs');
const concat  = require('gulp-concat');
const svgs    = require('gulp-svgstore');
const svgmin  = require('gulp-svgmin');
const path    = require('path');

const paths = {
  styles: {
    src: './assets/stylesheets/scss/',
    files: './assets/stylesheets/scss/style.scss',
    dest: './assets/stylesheets/'
  },
  scripts: {
    src: './assets/javascripts/',
    files: ['./assets/javascripts/core/*.js', './assets/javascripts/vendors/*.js','./assets/javascripts/main.js'],
    dest: './assets/javascripts/'
  },
  svgs: {
    src: './assets/images/icons/sprite/',
    files: ['./assets/images/icons/sprite/*.svg'],
    dest: './assets/images/icons/'
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

gulp.task('svgstore', function () {
  output({
    svgs: true
  });
});

gulp.task('default', ['development'], function() {
  gulp.watch(['./assets/stylesheets/scss/**/*.scss', './assets/javascripts/**/*.js'], ['development'])
  .on('change', function(evt) {
    console.log( '[watcher] File ' + evt.path.replace(/.*(?=sass)/,'') + ' was ' + evt.type + ', compiling...')
  })
  gulp.watch(['./assets/images/icons/sprite/*.svg'], ['svgstore'])
  .on('change', function(evt) {
    console.log( '[watcher] File ' + evt.path.replace(/.*(?=sass)/,'') + ' was ' + evt.type + ', compiling...')
  })
})

function output(args) {
  if(args.svgs === true) {
    gulp.src(paths.svgs.files)
    .pipe(svgmin(function (file) {
    var prefix = path.basename(file.relative, path.extname(file.relative));
    return {
      plugins: [{
        cleanupIDs: {
          prefix: prefix + '-',
          minify: true
        }
      }]
    }
    }))
    .pipe(svgs())
    .pipe(gulp.dest(paths.svgs.dest));
  } else {
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
      'last 10 version', 'safari 5', 'ie 8', 'ie 9', 'opera 12.1', 'ios 6', 'android 4'
    ))
    .pipe(gulp.dest(paths.styles.dest))
  }
}
