'use strict';

const paths = {
    src: [
        'assets/src/media/**/*',
        '!assets/src/media/**/*.bkp',
        '!assets/src/media/{svgs,svgs/**}'
    ],
    dest: 'assets/media'
};

module.exports = (gulp, done) => {
    return gulp.src(paths.src)
        .pipe(gulp.dest(paths.dest));
}
