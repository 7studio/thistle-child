'use strict';

// Thanks to https://github.com/gulpjs/gulp/blob/master/docs/recipes/running-task-steps-per-folder.md

import glob from 'glob';
import path from 'path';
import del from 'del';

const paths = {
    src: [
        'assets/src/media/svgs/**/*',
        '!assets/src/media/svgs/**/*.bkp',
        '!assets/src/media/svgs/**/spr-*/**/*',

    ],
    dest: 'assets/media/svgs'
};

module.exports = (gulp, done) => {
    const sprites = glob.sync('assets/src/media/svgs/**/spr-*/');
    const tasks = sprites.map((sprite) => {
        const destpath = path.dirname(sprite).replace(/\/src\//, '/');

        return gulp.src([
                path.join(sprite, '/**/*.svg'),
                path.join('!', sprite, '/**/*.bkp'),
            ])
            .pipe($.svgstore())
            .pipe(gulp.dest(destpath));
    });

    return gulp.src(paths.src)
        .pipe(gulp.dest(paths.dest))
        .on('end', () => {
            del(path.join(paths.dest, '/**/spr-*/'));
        });
}
