'use strict';

import fontloader from './partials/fontloader';

const isCute = ('querySelector' in document) && ('addEventListener' in window) && ('getComputedStyle' in window);
const isPolyfillsNeeded = ('Promise' in window) && ('findIndex' in Array.prototype) && ('assign' in Object);
const polyfills = 'default,Array.prototype.findIndex';
const fonts = {
    'Lato': [
        {weight: 400},
        {weight: 700},
        {weight: 900},
    ]
};

window.Queue = function() {
    let isInit = false;
    const queue = [];

    return {
        push: (callback) => {
            if (isInit) {
                callback();
            } else {
                queue.push(callback);
            }
        },
        init: () => {
            while (queue.length) {
                (queue.shift())();
            }

            isInit = true;
        }
    }
}();

window.main = function () {
    window.addEventListener('load', () => fontloader.load(fonts));

    Queue.init();
}

function loadPolyfills () {
    const min = ! window.THISTLE.debug ? '.min' : '';
    const html = document.documentElement;

    let js = document.createElement('script');
        js.src = `https://cdn.polyfill.io/v2/polyfill${min}.js?features=${THISTLE.polyfills}&flags=gated,always&callback=main`;
        js.defer = true;
        js.onerror = function() {
            html.classList.remove('js');
            html.classList.add('no-js');
        };

    document.head.appendChild(js);
}

if (isCute) {
    let defaultAction = isPolyfillsNeeded ? main : loadPolyfills;

    document.addEventListener('DOMContentLoaded', defaultAction);
} else {
    html.classList.remove('js');
    html.classList.add('no-js');
}
