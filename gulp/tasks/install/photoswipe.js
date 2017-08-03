'use strict';

import fs from 'fs';
import merge from 'merge-stream';

const CSSCOMB = {
    'remove-empty-rulesets': true,
    'always-semicolon': true,
    'color-case': 'lower',
    'block-indent': '  ',
    'color-shorthand': false,
    'element-case': 'lower',
    'eof-newline': true,
    'leading-zero': true,
    'quotes': 'double',
    'sort-order-fallback': 'abc',
    'space-before-colon': '',
    'space-after-colon': ' ',
    'space-before-combinator': ' ',
    'space-after-combinator': ' ',
    'space-between-declarations': '\n',
    'space-before-opening-brace': ' ',
    'space-after-opening-brace': '\n',
    'space-after-selector-delimiter': '\n',
    'space-before-selector-delimiter': '',
    'space-before-closing-brace': '\n',
    'strip-spaces': true,
    'tab-size': true,
    'unitless-zero': true,
    'vendor-prefix-align': true
};
const PSWP_SKIN_DIR = 'node_modules/photoswipe/dist/default-skin';

module.exports = (gulp, done) => {
    const processors = [
        require('postcss-url')({'url': 'copy', 'assetsPath': '../vendor/photoswipe/default-skin'}),
        require('autoprefixer')({'add': false, 'browsers': []})
    ];

    let stream = merge();

    stream.add(gulp.src('assets/src/styles/imagegallery.css'));

    fs.writeFileSync('.csscomb.json', JSON.stringify(CSSCOMB));

    let skin = gulp.src(PSWP_SKIN_DIR+'/default-skin.css')
        .pipe($.postcss(processors, {to: 'assets/src/styles/*.css'}))
        .pipe($.csscomb());

    stream.add(skin);

    fs.unlinkSync('.csscomb.json');

    return stream
        .pipe($.concat('imagegallery.css'))
        .pipe(gulp.dest('assets/src/styles'));
}
