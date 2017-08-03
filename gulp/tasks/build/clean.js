'use strict';

import del from 'del';

module.exports = (gulp, done) => {
    return del([
        'assets/{styles,scripts}/**/*.+(map|css|js)',
        '!assets/{styles,scripts}/**/*.min.+(css|js)'
    ]);
}
