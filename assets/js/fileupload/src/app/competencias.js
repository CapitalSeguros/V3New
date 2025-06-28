import React from 'react'
import Preview from './components/competencia/Competencias.jsx';
//import Preview from './components/evaluacion/Evaluaciones.jsx';
import ReactDOM from 'react-dom';
const e = React.createElement;
var defaults = defaults || {};

(function () {

    window.Competencias = function () {
        defaults = {
            selector:'',
            getData: '',
            postData: '',
            getUpdate:'',
            id:'',
            returnUrl:'',
            callbackSuccess: {}
        };

        // Create options by extending defaults with the passed in arugments
        if (arguments[0] && typeof arguments[0] === "object") {
            this.options = extendDefaults(defaults, arguments[0]);
        }
    }

    Competencias.prototype.init = function () {
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

    /* FilePreview.prototype.show = function(urlFile,description){
        const domContainer = document.querySelector(this.options.classRender);
        ReactDOM.render( <Preview classRender={this.options.classRender} download={this.options.site+urlFile} site={this.options.site} urlFile={urlFile} description={description} reference={this.options.reference} actionOpen={this.options.actionOpen} actionPost={this.options.actionPost} callBack={this.options.callbackSuccess} /> , domContainer);

        $('#mdPrevies').modal({
            backdrop: 'static',
            keyboard: false
          });
    } */

    function buildInit() {
        const domContainer = document.querySelector(this.options.selector);
        ReactDOM.render( <Preview getData={this.options.getData} postData={this.options.postData} getUpdate={this.options.getUpdate} callbackSuccess={this.options.callbackSuccess} id={this.options.id} returnUrl={this.options.returnUrl}/>, domContainer);
    }
})();