import React from 'react'
import Preview from './components/liberarPeriodo/ModaLiberar.jsx';
import ReactDOM from 'react-dom';
const e = React.createElement;
var defaults = defaults || {};

(function () {

    window.ModalLiberar = function () {
        defaults = {
            selector:'',
            AccionOpen:'',
            callback: function(){}
        };

        // Create options by extending defaults with the passed in arugments
        if (arguments[0] && typeof arguments[0] === "object") {
            this.options = extendDefaults(defaults, arguments[0]);
        }
    }

    ModalLiberar.prototype.init = function () {
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

    function buildInit() {
        const domContainer = document.querySelector(this.options.selector);
        ReactDOM.render( <Preview callback={defaults.callback} AccionOpen = {this.options.AccionOpen} />, domContainer);
    }
})();