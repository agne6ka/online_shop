import $ from 'jquery';
require('bootstrap');

class Component {
    constructor() {
        this.init();
    }

    init() {
        this.initCarousel();
    }

    initCarousel() {

        $('.carousel').carousel({
            interval: 5000
        });
    }

}

export default Component;
