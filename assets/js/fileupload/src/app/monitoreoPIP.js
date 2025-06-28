import React from 'react'
import Preview from './components/PIP/MonitoreoPIP.jsx';
import ReactDOM from 'react-dom';
const e = React.createElement;
var defaults = defaults || {};

(function () {

    window.MonitoreoPIP = function () {
        defaults = {
            selector:'',
            getData: '',
            postUpdate:'',
        };

        // Create options by extending defaults with the passed in arugments
        if (arguments[0] && typeof arguments[0] === "object") {
            this.options = extendDefaults(defaults, arguments[0]);
        }
    }

    MonitoreoPIP.prototype.init = function () {
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
        ReactDOM.render( <Preview postUpdate={this.options.postUpdate} />, domContainer);
    }
})();