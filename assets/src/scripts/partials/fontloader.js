'use strict';

import FontFaceObserver from 'fontfaceobserver';
import Fg from 'fg-loadcss';

class FontLoader {
    constructor() {
        if (!FontLoader.instance) {
            this.fonts = [];
            this.min = ! window.THISTLE.debug ? '.min' : '';
            this.path = `${window.THISTLE.url}/assets/styles/fonts.async${this.min}.css`;

            FontLoader.instance = this;
        }
    }

    load(fonts) {
        const html = document.documentElement;

        Fg.loadCSS(this.path);

        for (let name in fonts) {
            const obs = fonts[name].map(desc => (new FontFaceObserver(name, desc)).load());

            Promise.all(obs).then(values => {
                const familyName = values[0].family.toLocaleLowerCase().replace(/\W/g, '');

                const attr = (html.getAttribute('fonts') || '')
                    .split(/\s/g)
                    .concat([familyName])
                    .filter(v => v !== '')
                    .join(' ');

                html.setAttribute('fonts', attr);

                this.fonts.push(values[0].family);
            });
        }
    }
}

const instance = new FontLoader();
Object.freeze(instance);

export default instance;
