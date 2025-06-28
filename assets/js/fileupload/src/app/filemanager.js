import React from 'react'
import ReactDOM from 'react-dom';
import FileManager from './components/Fmanager/FileManager.jsx';

const e = React.createElement;
var defaults = defaults || {};

(function () {
        window.FmanagerComponente = function () {
            defaults = {
                classRender: '',
                selectorAction: '',
                referencia: '',
                referenciaId: '',
                callbackSuccess: {}
            };

            // Create options by extending defaults with the passed in arugments
            if (arguments[0] && typeof arguments[0] === "object") {
                this.options = extendDefaults(defaults, arguments[0]);
            }
        }

        FmanagerComponente.prototype.init = function () {
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
            ReactDOM.render( <FileManager
                selectorAction={this.options.selectorAction} referencia={this.options.referencia} referenciaId={this.options.referenciaId} callbackSuccess={this.options.callbackSuccess}  /> , domContainer);
            }
        })();