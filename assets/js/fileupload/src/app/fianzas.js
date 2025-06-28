import React from 'react'
import ReactDOM from 'react-dom';
import Fianza from './components/fianzas/Fianza.jsx';
const e = React.createElement;
var defaults = defaults || {};

(function () {
        window.FianzaComponente = function () {
            defaults = {
                classRender: '',
                UrlServicio:'',
                UrlPagina:'',
                Tipo:'',
                callbackSuccess: {}
            };

            // Create options by extending defaults with the passed in arugments
            if (arguments[0] && typeof arguments[0] === "object") {
                this.options = extendDefaults(defaults, arguments[0]);
            }
        }

        FianzaComponente.prototype.init = function () {
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
            ReactDOM.render( <Fianza
               Tipo={this.Tipo} UrlServicio = {this.options.UrlServicio} UrlPagina={this.options.UrlPagina} callbackSuccess={this.options.callbackSuccess}  /> , domContainer);
            }
        })();