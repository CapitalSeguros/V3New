import React from 'react'
import Siniestro from './components/cliente/Cliente.jsx';
import ReactDOM from 'react-dom';
const e = React.createElement;
var defaults = defaults || {};

(function () {
        window.Cliente = function () {
            defaults = {
                classRender: '',
                AccionNuevoE:'',
                AccionEditarE:'',
                AccionNuevoN:'',
                AccionEditarN:'',
                AccionNuevoI:'',
                AccionEditarI:'',
                callbackSuccess: {}
            };

            // Create options by extending defaults with the passed in arugments
            if (arguments[0] && typeof arguments[0] === "object") {
                this.options = extendDefaults(defaults, arguments[0]);
            }
        }

        Cliente.prototype.init = function () {
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
                ReactDOM.render( <Siniestro
                    AccionEditarE = {this.options.AccionEditarE}
                    AccionNuevoE = {this.options.AccionNuevoE}
                    AccionEditarN = {this.options.AccionEditarN}
                    AccionNuevoN = {this.options.AccionNuevoN}
                    AccionEditarI = {this.options.AccionEditarI}
                    AccionNuevoI = {this.options.AccionNuevoI}
                    callBack = {this.options.callbackSuccess} /> , domContainer);
                }
            })();