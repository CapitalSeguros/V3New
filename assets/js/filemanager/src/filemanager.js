import React from 'react'
import Manager from './components/filemanager/FileManager.jsx';
import ReactDOM from 'react-dom';
const e = React.createElement;
var defaults = defaults || {};

(function () {
        window.FileManager = function () {
            defaults = {
                classRender: '',
                selectorAction: '',
                referencia: '',
                referenciaId: '',
                callBack: function () {},
            };
            if (arguments[0] && typeof arguments[0] === "object") {
                defaults = extendDefaults(defaults, arguments[0]);
            }
        }
        FileManager.prototype.init = function () {
            buildInit.call(this);
        }

        FileManager.prototype.Referenia = function (referencia, referenciaId) {
            if (defaults.classRender == "")
                return;
            var domContainer = document.querySelector(defaults.classRender);

            if (domContainer == undefined) {
                return;
            }

            ReactDOM.render( < Manager Tipo = {
                    defaults.tipo
                }
                callBack = {
                    defaults.callBack
                }
                referencia = {
                    referencia
                }
                referenciaId = {
                    referenciaId
                }
                selectorAction = {
                    defaults.selectorAction
                }
                />, domContainer);
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
                if (defaults.classRender == "")
                    return;

                var domContainer = document.querySelector(defaults.classRender);

                if (domContainer == undefined) {
                    return;
                }

                defaults.referencia = domContainer.dataset.referencia;
                defaults.referenciaId = domContainer.dataset.referenciaid;
                defaults.full = domContainer.dataset.full;
                defaults.trashed = domContainer.dataset.trashed;

                ReactDOM.render( < Manager Tipo = {
                        defaults.tipo
                    }
                    callBack = {
                        defaults.callBack
                    }
                    referencia = {
                        defaults.referencia
                    }
                    referenciaId = {
                        defaults.referenciaId
                    }
                    full = {
                        defaults.full
                    }
                    isTrash  = {
                        defaults.trashed
                    }
                    selectorAction = {
                        defaults.selectorAction
                    }
                    />, domContainer);
                }
            })();

        /* window.Manager = new FileManager({
            classRender: ".file-manager-container",
            id: "file-manager"
        });
        window.Manager.init(); */