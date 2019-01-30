const gulp = require('gulp');
const postcss = require('gulp-postcss');
const sass = require('gulp-sass');
const sourcemaps = require('gulp-sourcemaps');
const autoprefixer = require('autoprefixer');
const cssnano = require('cssnano');
const bro = require('gulp-bro');
const babelify = require('babelify');
const gap = require('gulp-append-prepend');

gulp.task('sass', () => {
    const plugins = [
        autoprefixer({browsers: ['> 0%']}),
        cssnano({
            preset: 'default',
            zindex: false
        }),
    ];

    const sassTask = sass();
    sassTask.on('error', e => {
        console.log(e);
    });

    return gulp
        .src('scss/**/*.scss')
        .pipe(sourcemaps.init())
        .pipe(sassTask)
        .pipe(postcss(plugins))
        .pipe(sourcemaps.write('.'))
        .pipe(gulp.dest('../web/assets/css/'));
});

gulp.task('browserify', () => {
    return gulp.src('js/main.js')
        .pipe(bro({
            transform: [
                babelify.configure({
                    presets: ['@babel/preset-env']
                }),
                ['uglifyify', {global: true}]
            ]
        }))
        .pipe(gap.appendFile('js/vendor/prism.js'))
        .pipe(gap.appendFile('node_modules/materialize-css/dist/js/materialize.min.js'))
        .pipe(gulp.dest('../web/assets/js/'))
});

gulp.task('watch', () => {
    gulp.watch('scss/**/*.scss', gulp.series('sass'));
    gulp.watch('js/**/*.js', gulp.series('browserify'));
});

gulp.task('default', gulp.parallel('sass', 'browserify'));
