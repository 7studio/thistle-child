'use strict';

// Thanks to https://github.com/gulpjs/gulp/blob/master/docs/recipes/browserify-multiple-destination.md

import browserify from 'browserify';
import babelify from 'babelify';

const paths = {
    src: [
        'assets/src/scripts/**/*.js',
        '!assets/src/scripts/**/*.bkp',
        '!assets/src/scripts/{partials,partials/**}'
    ],
    dest: 'assets/scripts'
};

module.exports = (gulp, done) => {
    return gulp.src(paths.src, {read: false})
        .pipe($.if(!args.all, $.changed(paths.dest)))
        .pipe($.tap((file) => {
            file.contents = browserify(file.path, {debug: true})
                .transform(babelify.configure(project.babel))
                .bundle();

            $.util.log(`browserify: ${$.util.colors['green']('✔')} ${file.relative}`);
        }))
        .pipe($.buffer())
        .pipe($.sourcemaps.init({loadMaps: true}))
        .pipe($.sourcemaps.write('.'))
        .pipe(gulp.dest(paths.dest));
}
