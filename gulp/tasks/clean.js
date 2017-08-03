'use strict';

import del from 'del';

module.exports = (gulp, done) => {
    return del(['assets/{styles,scripts,fonts,media,vendor}']);
}
