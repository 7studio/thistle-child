'use strict';

const paths = {
    src: 'assets/media/**/*',
    dest: 'assets/media'
};

module.exports = (gulp, done) => {
    const IMAGEMIN = [
        $.imagemin.gifsicle({
            interlaced: true
        }),
        $.imagemin.jpegtran({
            progressive: true
        }),
        $.imagemin.optipng(),
        $.imagemin.svgo({
            plugins: [{
                cleanupIDs: {
                    remove: false
                },
                removeUselessStrokeAndFill: {
                    stroke: false,
                    fill: false
                }
            }]
        })
    ];

    return gulp.src(paths.src)
        .pipe($.if(/\.(png|jpg|jpeg|gif|svg)$/i, $.imagemin(IMAGEMIN, {verbose: true})))
        .pipe(gulp.dest(paths.dest));
}
