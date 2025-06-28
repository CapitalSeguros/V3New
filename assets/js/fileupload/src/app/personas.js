import React from 'react'
import Persona from './components/persona/Persona.jsx';
import ReactDOM from 'react-dom';
const e = React.createElement;
var defaults = defaults || {};

(function () {
        window.Personas = function () {
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

        Personas.prototype.init = function () {
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

        Personas.prototype.show = function (urlFile, description) {
            const domContainer = document.querySelector(this.options.classRender);
            ReactDOM.render( < Persona classRender = {this.options.classRender}
                download = {this.options.site + urlFile}
                description = {description}
                reference = {this.options.reference}
                actionOpen = {this.options.actionOpen}
                actionPost = {this.options.actionPost}
                callBack = {this.options.callbackSuccess} /> , domContainer);
            }

            function buildInit() {
                const domContainer = document.querySelector(this.options.classRender);
                ReactDOM.render( <Persona classRender = {this.options.classRender}
                    reference = {this.options.reference}
                    actionOpen = {this.options.actionOpen}
                    actionPost = {this.options.actionPost}
                    callBack = {this.options.callbackSuccess} /> , domContainer);
                }
            })();