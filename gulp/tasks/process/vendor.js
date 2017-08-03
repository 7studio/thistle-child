'use strict';

const paths = {
    src: 'assets/src/vendor/**/*',
    dest: 'assets/vendor'
};

module.exports = (gulp, done) => {
    return gulp.src(paths.src)
        .pipe(gulp.dest(paths.dest));
}
