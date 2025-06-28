import React from 'react'
import Preview from './components/TabuladorBono/TabuladorBono.jsx';
import ReactDOM from 'react-dom';
const e = React.createElement;
var defaults = defaults || {};

(function () {

        window.Tabulador = function () {
            defaults = {
                selector: '',
                selectorAction: '',
                selectorView: '',
                selectorEdit:'',
                callBack: function () {},
                tipo: '',
            };

            // Create options by extending defaults with the passed in arugments
            if (arguments[0] && typeof arguments[0] === "object") {
                defaults = extendDefaults(defaults, arguments[0]);
            }
        }

        Tabulador.prototype.init = function () {
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
            const domContainer = document.querySelector(defaults.selector);
            ReactDOM.render( < Preview Tipo = {
                    defaults.tipo
                }
                selectorView = {
                    defaults.selectorView
                }
                callBack = {
                    defaults.callBack
                }
                selectorAction = {
                    defaults.selectorAction
                }
                selectorEdit={
                    defaults.selectorEdit
                }
                />, domContainer);
            }
        })();