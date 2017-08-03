'use strict';

import project from '../package.json';
import gulp from 'gulp';
import plugins from 'gulp-load-plugins';
import tasksLoader from 'gulp-require-tasks';
import runSequence from 'run-sequence';
import minimist from 'minimist';
import browserSync from 'browser-sync';

const reload = browserSync.reload;

global.project = project;
global.args = minimist(process.argv.slice(2), {
    boolean: 'all',
    default: { all: false }
});
global.$ = plugins();

tasksLoader({
    path: process.cwd() + '/gulp/tasks',
    gulp: gulp
});

gulp.task('install', ['install:photoswipe', 'install:svgxuse']);

gulp.task('process', ['clean'], (done) => {
    runSequence(
        ['process:fonts'],
        ['process:media'],
        ['process:styles'],
        ['process:scripts'],
        ['process:vendor'],
        done
    );
});

gulp.task('build', (done) => {
    runSequence(
        ['process'],
        ['build:media'],
        ['build:styles'],
        ['build:scripts'],
      //['build:clean'],
        done
    );
});

// create task that ensures the called task is complete before
// reloading browsers
gulp.task('watch:styles', ['process:styles'], reload);
gulp.task('watch:scripts', ['process:scripts'], reload);

// Static Server + watching css/html files
gulp.task('serve', () => {
    browserSync.init({
        proxy: project.serverName,
        snippetOptions: {
            whitelist: ['/wp-admin/admin-ajax.php'],
            blacklist: ['/wp-admin/**']
        }
    });

    // add browserSync.reload to the tasks array to make
    // all browsers reload after tasks are complete.
    gulp.watch(['assets/src/styles/**/*.css'], ['watch:styles']);
    gulp.watch(['assets/src/scripts/**/*.js'], ['watch:scripts']);
    gulp.watch(['assets/src/media/**/*'], ['watch:media']);
    gulp.watch(['*.php']).on('change', reload);
});

gulp.task('default', (done) => {
    runSequence(
        ['install'],
        ['build'],
        done
    );
});
