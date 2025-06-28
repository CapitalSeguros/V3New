import React from 'react'
import Seguimiento from './components/common/Modal.jsx';
import ReactDOM from 'react-dom';
var show = 0;
var defaults = defaults || {};

(function () {

    window.ModalSeguimiento = function () {
        defaults = {
            title: 'Default',
            id: 'md-seguimiento',
            classRender: '',
            actionOpen: '',
            callback: function () {},
            callbackSuccess: function () {}
        };

        // Create options by extending defaults with the passed in arugments
        if (arguments[0] && typeof arguments[0] === "object") {
            defaults = extendDefaults(defaults, arguments[0]);
        }
    }

    ModalSeguimiento.prototype.init = function () {
        buildInit.call(this);
    }

    // Utility method to extend defaults with user options
    function extendDefaults(source, properties) {
        var property;
        for (property in properties) {
            if (properties.hasOwnProperty(property)) {
                source[property] = properties[property];
            }
        }
        return source;
    }

    ModalSeguimiento.prototype.show = function (titulo, source) {
        const domContainer = document.querySelector(defaults.classRender);
        const element = < Seguimiento titulo = {
            titulo
        }
        show = {
            ++show
        }
        state = {
            source
        }
        evento = {
            defaults.callback
        }
        id = {
            defaults.id
        }
        />;
        ReactDOM.render(element, domContainer);
    }

    function buildInit() {
        const domContainer = document.querySelector(defaults.classRender);
        const element = < Seguimiento
        titulo = {
            defaults.title
        }
        id = {
            defaults.id
        }
        />;
        ReactDOM.render(element, domContainer);
    }
})();

window.modalModalSeguimiento = new ModalSeguimiento({
    classRender: ".modal-seguimiento-container",
    title: "Seguimiento Bonos",
    id: "modal-seguimiento"
});
window.modalModalSeguimiento.init();