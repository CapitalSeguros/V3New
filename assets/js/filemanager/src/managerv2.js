import React from 'react';
import ReactDOM from 'react-dom';
import Manager from './components/filemanager/FileManager.jsx';
const e = React.createElement;
var defaults = defaults || {};
//const TCambioRef = useRef(null);

(function () {
    window.ManagerComponente = function () {
        defaults = {
            classRender: '',
            selectorAction: '',
            referencia: '',
            referenciaId: '',
            callBack: function () {},
        };

        // Create options by extending defaults with the passed in arugments
        if (arguments[0] && typeof arguments[0] === "object") {
            this.options = extendDefaults(defaults, arguments[0]);
        }
    }

    ManagerComponente.prototype.init = function () {
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
        ReactDOM.render(<Manager selectorAction={this.options.selectorAction} referencia={this.options.referencia} referenciaId={this.options.referenciaId} />, domContainer);
    }
})();