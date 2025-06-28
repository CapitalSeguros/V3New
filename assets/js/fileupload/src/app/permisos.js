import React from 'react'
import Permiso from './components/Permisos/Permisos.jsx';
import ReactDOM from 'react-dom';
const e = React.createElement;
var defaults = defaults || {};

(function () {
        window.Permisos = function () {
            defaults = {
                classRender: '',
                AccionNuevo:'',
                callbackSuccess: {}
            };

            // Create options by extending defaults with the passed in arugments
            if (arguments[0] && typeof arguments[0] === "object") {
                this.options = extendDefaults(defaults, arguments[0]);
            }
        }

        Permisos.prototype.init = function () {
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
            ReactDOM.render( <Permiso
                AccionNuevo = {this.options.AccionNuevo} callbackSuccess={this.options.callbackSuccess} /> , domContainer);
            }
        })();