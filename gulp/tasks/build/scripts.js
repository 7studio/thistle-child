'use strict';

import prettyBytes from 'pretty-bytes';

const paths = {
    src: [
        'assets/scripts/**/*.js',
        '!assets/scripts/**/debug.js',
    ],
    dest: 'assets/scripts'
};

module.exports = (gulp, done) => {
    return gulp.src(paths.src)
        .pipe($.bytediff.start())
        .pipe($.uglify({output: {comments: /^!|@preserve|@license|@cc_on/i}}))
        .pipe($.rename({suffix: '.min'}))
        .pipe($.bytediff.stop((data) => {
            const savedMsg = `saved ${prettyBytes(data.savings)} - ${(data.percent * 100).toFixed(1).replace(/\.0$/, '')}%`;
            const msg = data.savings > 0 ? savedMsg : 'already optimized';

            return `gulp-uglify: ${$.util.colors['green']('✔')} ${data.fileName} ` + $.util.colors['grey'](`(${msg})`);
        }))
        .pipe(gulp.dest(paths.dest));
}
