var gulp = require('gulp');
var plumber = require('gulp-plumber');
var notify = require('gulp-notify');
var cache = require('gulp-cached');
var sass = require('gulp-sass');
var sassGlob = require('gulp-sass-glob');
var cssbeautify = require('gulp-cssbeautify');
var postcss = require('gulp-postcss');
var autoprefixer = require('autoprefixer');
var minifycss = require('gulp-clean-css');

// path
var assets = './public/assets';
var scssDir = '/scss/**/*.scss';
var cssDir = '/css/';
var dir = {
    scss: assets + scssDir,
    css: assets + cssDir
};

var postcssPlugin = [
    autoprefixer()
];

gulp.task('sass', function () {
    gulp.src([dir.scss])
        .pipe(plumber({
            errorHandler: notify.onError('Error: <%= error.message %>')
        }))
        .pipe(cache(sass))
        .pipe(sassGlob())
        .pipe(sass())
        .pipe(postcss(postcssPlugin))
        .pipe(cssbeautify({
            indent: '\t'
        }))
        // .pipe(minifycss())
        .pipe(gulp.dest(dir.css));
});

// 檔案監聽
gulp.task('default', ['sass'], function () {
    gulp.watch([dir.scss], ['sass']);
});
