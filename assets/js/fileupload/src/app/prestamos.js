import React from 'react'
import ReactDOM from 'react-dom';
import Prestamos from './components/Prestamos/Prestamos.jsx';

const e = React.createElement;
var defaults = defaults || {};

(function () {
    window.PrestamosComponente = function () {
        defaults = {
            classRender: '',
            UrlServicio: '',
            callbackSuccess: {}
        };

        // Create options by extending defaults with the passed in arugments
        if (arguments[0] && typeof arguments[0] === "object") {
            this.options = extendDefaults(defaults, arguments[0]);
        }
    }

    PrestamosComponente.prototype.init = function () {
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
        const domContainer = document.querySelector(this.options.classRender);
        ReactDOM.render(<Prestamos
            UrlServicio={this.options.UrlServicio} callbackSuccess={this.options.callbackSuccess} />, domContainer);
    }
})();