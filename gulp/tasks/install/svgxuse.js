'use strict';

const SVGXUSE_DIR = 'node_modules/svgxuse';

module.exports = (gulp, done) => {
    return gulp.src([
            SVGXUSE_DIR+'/*.js'
        ])
        .pipe(gulp.dest('assets/src/vendor/svgxuse'));
}
