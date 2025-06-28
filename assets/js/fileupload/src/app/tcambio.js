import React from 'react';
import ReactDOM from 'react-dom';
import ModalTCambio from './components/Acciones/ModalTCambio.jsx';
const e = React.createElement;
var defaults = defaults || {};
//const TCambioRef = useRef(null);

(function () {
    window.TCambioComponente = function () {
        defaults = {
            classRender: '',
            UrlServicio: '',
            Tipo: null
            //callbackSuccess: {}
        };

        // Create options by extending defaults with the passed in arugments
        if (arguments[0] && typeof arguments[0] === "object") {
            this.options = extendDefaults(defaults, arguments[0]);
        }
    }

    TCambioComponente.prototype.init = function () {
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
        ReactDOM.render(<ModalTCambio Tipo={this.options.UrlServicio} UrlServicio={this.options.UrlServicio} />, domContainer);
    }
})();