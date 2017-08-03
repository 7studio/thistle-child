'use strict';

import PhotoSwipe from 'photoswipe';
import PhotoSwipeUI_Default from 'photoswipe/dist/photoswipe-ui-default';

class Pswp {
    constructor(gallery, options = window.PSWP_OPTIONS) {
        this.template = null;
        this.gallery = null;

        this.items = {};

        this.options = Object.assign({}, options);

        this.initTemplateObject();
        this.initGalleryObject(gallery);
        this.initItemList();
    }

    init() {
        const self = this;
        const links = this.gallery.getElementsByClassName('ImageGallery-link');

        Array.prototype.forEach.call(links, link => {
            link.addEventListener('click', function (event) {
                event.preventDefault();

                const index = self.getSrcIndex(this.href);

                self.openPhotoSwipe(index);
            });
        });
    }

    initTemplateObject() {
        this.template = document.querySelector('.pswp');

        if (!this.template) {
            throw new Error('Pswp needs its template (.pswp) to work.');
        }
    }

    initGalleryObject(elem) {
        if (typeof elem === 'string') {
            this.gallery = document.querySelector(elem);
        }
        else {
            this.gallery = elem;
        }

        if (!this.gallery) {
            throw new Error('Pswp first argument should be a valid CSS selector.');
        }
    }

    initItemList() {
        const script = this.gallery.getElementsByTagName('script')[0];

        if (!script) {
            throw new Error('!!');
        }

        try {
            this.items = JSON.parse(script.textContent);
        }
        catch (e) {
            throw new Error(e);
        }
    }

    openPhotoSwipe(index) {
        let pswp = null;

        index = parseInt(index, 10) || 0;

        if (isNaN(index)) {
            return;
        }

        this.options.index = index;

        pswp = new PhotoSwipe(this.template, PhotoSwipeUI_Default, this.items, this.options);
        pswp.init();
    }

    getSrcIndex(src) {
        const index = this.items.findIndex(elem => elem.src == src);

        return index;
    }
}



let main = () => {
    const galleries = document.querySelectorAll('.ImageGallery');

    if (galleries.length) {
        Array.prototype.forEach.call(galleries, (elem, index) => {
            elem.setAttribute('data-pswp-uid', index+1);
            (new Pswp(elem)).init();
        });
    }
};

Queue.push(main);
