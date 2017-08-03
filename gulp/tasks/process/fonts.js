'use strict';

const paths = {
    src: [
        'assets/src/fonts/**/*',
        '!assets/src/fonts/generator_config.txt'
    ],
    dest: 'assets/fonts'
};

module.exports = (gulp, done) => {
    return gulp.src(paths.src)
        .pipe(gulp.dest(paths.dest));
}
