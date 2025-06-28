import React from 'react'
import Siniestro from './components/Siniestros/Siniestros.jsx';
import ReactDOM from 'react-dom';
const e = React.createElement;
var defaults = defaults || {};

(function () {
        window.Siniestros = function () {
            defaults = {
                classRender: '',
                AccionNuevo:'',
                AccionEditar:'',
                AccionVer:'',
                AccionCargar:'',
                AccionActualizar:'',
                callbackSuccess: {}
            };

            // Create options by extending defaults with the passed in arugments
            if (arguments[0] && typeof arguments[0] === "object") {
                this.options = extendDefaults(defaults, arguments[0]);
            }
        }

        Siniestros.prototype.init = function () {
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
                    AccionVer = {this.options.AccionVer}
                    AccionEditar = {this.options.AccionEditar}
                    AccionNuevo = {this.options.AccionNuevo}
                    AccionActualizar={this.options.AccionActualizar}
                    AccionCargar={this.options.AccionCargar}
                    callBack = {this.options.callbackSuccess} /> , domContainer);
                }
            })();