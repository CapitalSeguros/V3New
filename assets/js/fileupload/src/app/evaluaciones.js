import React from 'react'
import Evaluacion from './components/evaluacion/Evaluaciones.jsx'
import ReactDOM from 'react-dom';
const e = React.createElement;
var defaults = defaults || {};

(function () {

    window.Evaluaciones = function () {
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

    Evaluaciones.prototype.init = function () {
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
        ReactDOM.render( <Evaluacion classRender={this.options.classRender} site={this.options.site} urlFile={this.options.urlFile} reference={this.options.reference} actionOpen={this.options.actionOpen} actionPost={this.options.actionPost} callBack={this.options.callbackSuccess} id={this.options.id} /> , domContainer);
    }
})();