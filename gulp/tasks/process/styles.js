'use strict';

const paths = {
    src: [
        'assets/src/styles/**/*.css',
        '!assets/src/styles/**/*.bkp',
        '!assets/src/styles/{partials,partials/**}'
    ],
    dest: 'assets/styles'
};

module.exports = (gulp, done) => {
    const props = require(process.cwd()+'/assets/src/styles/properties.json');
    const processors = [
        require('postcss-import')(),
        require('postcss-url')({'url': 'rebase'}),
        require('postcss-custom-properties')({'variables': props.properties}),
        require('postcss-custom-media')({'extensions': props.media}),
        require('postcss-media-minmax')(),
        require('postcss-calc')({'precision': 3}),
        require('postcss-color-rgb')(),
        require('autoprefixer')(),
        require('postcss-reporter')({clearReportedMessages: true})
    ];

    return gulp.src(paths.src)
        .pipe($.sourcemaps.init({loadMaps: true}))
        .pipe($.postcss(processors))
        .pipe($.sourcemaps.write('.'))
        .pipe(gulp.dest(paths.dest));
}
