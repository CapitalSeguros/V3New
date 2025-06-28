import React from 'react'
import Incidencia from './components/incidencias/Incidencias.jsx'
import ReactDOM from 'react-dom';
const e = React.createElement;
var defaults = defaults || {};
let obIncidencias;
var domContainer;
(function () {

    window.Incidencias = function () {
        defaults = {
            classRender: '',
            actionOpen: '',
            reference: '',
            actionPost: '',
            callbackSuccess: {}
        };

        // Create options by extending defaults with the passed in arugments
        if (arguments[0] && typeof arguments[0] === "object") {
            this.options = extendDefaults(defaults, arguments[0]);
        }
        domContainer = document.querySelector(this.options.classRender);
    }

    Incidencias.prototype.init = function () {
        buildInit.call(this);
    }

    Incidencias.prototype.show = function (empleadoId, fecha) {
        ReactDOM.render(<Incidencia 
            classRender={this.options.classRender} 
            reference={this.options.reference} 
            actionOpen={this.options.actionOpen} 
            empleadoId={empleadoId}
            fecha={fecha}
            actionPost={this.options.actionPost} 
            callBack={this.options.callbackSuccess} /> , domContainer);
            // window.jQuery('#modalIncidecias').modal("show");
    }

    Incidencias.prototype.edit = function (incidencia) {
        ReactDOM.render(<Incidencia 
            classRender={this.options.classRender} 
            reference={this.options.reference} 
            actionOpen={this.options.actionOpen} 
            incidencia={incidencia}
            actionPost={this.options.actionPost} 
            callBack={this.options.callbackSuccess} /> , domContainer);
            // window.jQuery('#modalIncidecias').modal("show");
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
        if(this.options.actionOpen != ""){
            const el = document.querySelector(this.options.actionOpen);
            let self = this;
            if(el != undefined)
            {
                el.addEventListener('click',function(e){
                    ReactDOM.render(obIncidencias, domContainer);
                    window.jQuery('#modalIncidecias').modal("show");
                },false);
            }
        }

        obIncidencias = <Incidencia classRender={this.options.classRender} empleadoId={this.options.empleadoId} reference={this.options.reference} actionOpen={this.options.actionOpen} actionPost={this.options.actionPost} callBack={this.options.callbackSuccess} />
        ReactDOM.render(obIncidencias , domContainer);
    }
})();