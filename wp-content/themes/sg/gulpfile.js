var gulp = require('gulp');
var plumber = require('gulp-plumber');
var sass = require('gulp-sass');
var rename = require('gulp-rename');
var autoprefixer = require('gulp-autoprefixer');
var minifyCSS = require('gulp-minify-css');
var uglify = require('gulp-uglify');
var concat = require('gulp-concat');
var gutil = require('gulp-util');
var browsersync = require('browser-sync');
var sourcemaps = require('gulp-sourcemaps');
var wpPot = require('gulp-wp-pot');
var postCSS = require('gulp-postcss');
var objectFitImages = require('postcss-object-fit-images');

gulp.task('styles', function () {
  gulp.src('sass/**/*.scss')
    .pipe(sourcemaps.init())
    .pipe(plumber(function (error) {
      console.log(error);
      this.emit('end');
    }))
    .pipe(sass())
    .pipe(postCSS([objectFitImages]))
    .pipe(autoprefixer({
      browsers: ['defaults', 'iOS >= 8']
    }))
    .pipe(minifyCSS())
    .pipe(rename('main.min.css'))
    .pipe(sourcemaps.write('/'))
    .pipe(gulp.dest('dist/css'))
    .pipe(browsersync.stream({
      match: '**/*.css'
    }));
});

gulp.task('scripts', function () {
  return gulp.src([
      'js/[^_]*.js',
    ])
    .pipe(concat('main.js'))
    .pipe(rename({
      suffix: '.min'
    }))
    // .pipe(uglify().on('error', function(error){
    //     gutil.log(gutil.colors.red('[Error]'), error.toString());
    //     this.emit('end');
    // }))
    .pipe(gulp.dest('dist/js'));
});


gulp.task('scripts_fireworks', function () {
  return gulp.src([
      'js/_fireworks.js',
    ])
    .pipe(concat('_fireworks.js'))
    .pipe(rename({
      suffix: '.min'
    }))
    // .pipe(uglify().on('error', function(error){
    //     gutil.log(gutil.colors.red('[Error]'), error.toString());
    //     this.emit('end');
    // }))
    .pipe(gulp.dest('dist/js'));
});


gulp.task('scripts_game_dictation', function () {
  return gulp.src([
      'js/_game_dictation.js',
    ])
    .pipe(concat('_game_dictation.js'))
    .pipe(rename({
      suffix: '.min'
    }))
    // .pipe(uglify().on('error', function(error){
    //     gutil.log(gutil.colors.red('[Error]'), error.toString());
    //     this.emit('end');
    // }))
    .pipe(gulp.dest('dist/js'));
});
gulp.task('scripts_game_sentence', function () {
  return gulp.src([
      'js/_game_sentence.js',
    ])
    .pipe(concat('_game_sentence.js'))
    .pipe(rename({
      suffix: '.min'
    }))
    // .pipe(uglify().on('error', function(error){
    //     gutil.log(gutil.colors.red('[Error]'), error.toString());
    //     this.emit('end');
    // }))
    .pipe(gulp.dest('dist/js'));
});
gulp.task('scripts_library', function () {
  return gulp.src([
      'js/_library.js',
    ])
    .pipe(concat('_library.js'))
    .pipe(rename({
      suffix: '.min'
    }))
    // .pipe(uglify().on('error', function(error){
    //     gutil.log(gutil.colors.red('[Error]'), error.toString());
    //     this.emit('end');
    // }))
    .pipe(gulp.dest('dist/js'));
});


gulp.task('browser-sync', function () {
  browsersync({
    proxy: {
      target: 'http://sg.local'
    },
    snippetOptions: {
      whitelist: ['/wp-admin/admin-ajax.php']
    }
  });
});

gulp.task('vendor', function () {
  return gulp.src([
      'js/vendor/[^_]*.js',
    ])
    .pipe(concat('vendor.js'))
    .pipe(rename({
      suffix: '.min'
    }))
    .pipe(uglify().on('error', function (error) {
      gutil.log(gutil.colors.red('[Error]'), error.toString());
      this.emit('end');
    }))
    .pipe(gulp.dest('dist/js'));
});

gulp.task('translations', function () {
  var domain = 'sg';

  return gulp.src('./**/*.php')
    .pipe(wpPot({
      domain: domain,
      package: 'SG',
      headers: {
        NOTES: 'CMS = content management system, Copy = text content, Lead = text before something',
      },
    }))
    .pipe(gulp.dest('languages/' + domain + '.pot'));
});

// gulp.task('default', ['watch']);

gulp.task('watch', ['browser-sync'], function () {
  gulp.watch('sass/**/*.scss', ['styles']);
  gulp.watch('js/**/[^_]*.js', ['scripts']);
  gulp.watch('js/**/_fireworks.js', ['scripts_fireworks']);
  gulp.watch('js/**/_game_dictation.js', ['scripts_game_dictation']);
  gulp.watch('js/**/_game_sentence.js', ['scripts_game_sentence']);
  gulp.watch('js/**/_library.js', ['scripts_library']);
  gulp.watch('js/vendor/[^_]*.js', ['vendor']);
  gulp.watch('../**/*.php', function () {
    browsersync.reload();
  });
});