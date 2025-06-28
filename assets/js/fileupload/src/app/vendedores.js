import React from 'react'
import ReactDOM from 'react-dom';
import Vendedor from './components/Vendedores/Vendedor.jsx';
const e = React.createElement;
var defaults = defaults || {};

(function () {
        window.VendedorComponente = function () {
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

        VendedorComponente.prototype.init = function () {
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
            ReactDOM.render( <Vendedor
               Tipo={this.Tipo} UrlServicio = {this.options.UrlServicio} UrlPagina={this.options.UrlPagina} callbackSuccess={this.options.callbackSuccess}  /> , domContainer);
            }
        })();