import React from 'react'
import Filtro from './components/common/ModalDetalle.jsx';
import ReactDOM from 'react-dom';
var show = 0;
var defaults = defaults || {};

(function () {
    

    window.ModalDetail = function () {
        defaults = {
            classRender: '',
            actionOpen: '',
            site: '',
            urlFile: '',
            reference: '',
            actionPost: '',
            callbackSuccess: {}
        };

        // Create options by extending defaults with the passed in arugments
        if (arguments[0] && typeof arguments[0] === "object") {
            this.options = extendDefaults(defaults, arguments[0]);
        }
    }

    ModalDetail.prototype.init = function () {
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

    ModalDetail.prototype.show = function (title, source) {
        const domContainer = document.querySelector(this.options.classRender);
        ReactDOM.render( <Filtro title={title} show={++show} source={source} /> , domContainer);
    }

    function buildInit() {
        const domContainer = document.querySelector(this.options.classRender);
        ReactDOM.render( <Filtro title={this.options.title} source={this.options.source} /> , domContainer);
    }
})();