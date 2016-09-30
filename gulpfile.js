var gulp = require('gulp'),
    useref = require('gulp-useref'),
    uglify = require('gulp-uglify'),
    gulpif = require('gulp-if'),
    cleanCSS = require('gulp-clean-css');

// Use usehref to load files in order, minify css and js
gulp.task('build', function() {
    return gulp.src('index.html')
        .pipe(useref())
        .pipe(gulpif('*.js', uglify()))
        .pipe(gulpif('*.css', cleanCSS({compatibility: 'ie8'})))
        .pipe(gulp.dest('build'));
});

// Default task
gulp.task('default', ['build'], function() {});