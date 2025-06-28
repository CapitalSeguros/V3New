import React from 'react';
import ReactDOM from 'react-dom';
import ModalRPago from "./components/Acciones/ModalRPago.jsx";
var defaults = defaults || {};

(function () {
    window.RPagoComponente = function () {
        defaults = {
            classRender: '',
            UrlServicio: '',
            Tipo: null
        };

        if (arguments[0] && typeof arguments[0] === "object") {
            this.options = extendedDefaults(defaults, arguments[0]);
        }
    }

    RPagoComponente.prototype.init = function () {
        buildInit.call(this);
    }

    function extendedDefaults(source, properties) {
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
        ReactDOM.render(<ModalRPago Tipo={this.options.UrlServicio} UrlServicio={this.options.UrlServicio} />, domContainer);
    }
})();