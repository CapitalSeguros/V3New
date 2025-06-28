import React from 'react'
import Autorizacion from './components/common/AlertForm.jsx';
import ReactDOM from 'react-dom';
var show = 0;
var defaults = defaults || {};

(function () {

    window.Autorizar = function () {
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

    Autorizar.prototype.init = function () {
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

    Autorizar.prototype.login = function (callback) {
        const domContainer = document.querySelector(defaults.classRender);
        const element = < Autorizacion
        show = {
            ++show
        }
        Credenciales = {
            callback
        }
        id = {
            defaults.id
        }
        />;
        ReactDOM.render(element, domContainer);
    }

    function buildInit() {
        const domContainer = document.querySelector(defaults.classRender);
        const element = < Autorizacion

        id = {
            defaults.id
        }
        />;
        ReactDOM.render(element, domContainer);
    }
})();

window.autorizar = new Autorizar({
    classRender: ".modal-autorizar-container",
    id: "modal-autorizacion"
});
window.autorizar.init();