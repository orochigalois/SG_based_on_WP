var gulp = require('gulp');
var plumber = require('gulp-plumber');
var sass = require('gulp-sass');
var rename = require('gulp-rename');
var autoprefixer = require('gulp-autoprefixer');
var minifyCSS = require('gulp-minify-css');
var uglify = require('gulp-uglify');
var concat = require('gulp-concat');
var gutil = require('gulp-util');
var browsersync = require('browser-sync').create();
var sourcemaps = require('gulp-sourcemaps');
var postCSS = require('gulp-postcss');
var objectFitImages = require('postcss-object-fit-images');



function styles() {
  return gulp.src('sass/**/*.scss')
    .pipe(sourcemaps.init())
    .pipe(plumber(function (error) {
      console.log(error);
      this.emit('end');
    }))
    .pipe(sass())
    .pipe(postCSS([objectFitImages]))
    .pipe(autoprefixer())
    .pipe(minifyCSS())
    .pipe(rename('main.min.css'))
    .pipe(sourcemaps.write('/'))
    .pipe(gulp.dest('dist/css'))
    .pipe(browsersync.stream({
      match: '**/*.css'
    }));
}

exports.styles = styles;


function scripts() {
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
}

exports.scripts = scripts;


function scripts_game_dictation() {
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
}

exports.scripts_game_dictation = scripts_game_dictation;


function scripts_game_sentence() {
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
}

exports.scripts_game_sentence = scripts_game_sentence;





function scripts_library() {
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
}

exports.scripts_library = scripts_library;


function vendor() {
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
}

exports.vendor = vendor;



function watch() {
  browsersync.init({
    proxy: {
      target: 'http://sg.local'
    },
    snippetOptions: {
      whitelist: ['/wp-admin/admin-ajax.php']
    }
  });




  gulp.watch('sass/**/*.scss', styles);
  gulp.watch('js/**/*.js', scripts);
  gulp.watch('js/**/_game_dictation.js', scripts_game_dictation);
  gulp.watch('js/**/_game_sentence.js', scripts_game_sentence);
  gulp.watch('js/**/_library.js', scripts_library);
  gulp.watch('js/vendor/[^_]*.js', vendor);
  gulp.watch('../**/*.php').on('change', browsersync.reload);
}


exports.watch = watch;