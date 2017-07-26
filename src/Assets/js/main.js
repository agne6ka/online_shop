import Component from './components/Component';

class App {
    constructor() {
        this.init();
    }

    init() {
        let component = new Component();
        component.printMessage();
    }
}

document.addEventListener('DOMContentLoaded', () => new App());
