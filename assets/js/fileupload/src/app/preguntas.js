import React from "react";
import Question from "./components/pregunta/prueba.jsx";
//import Question from "./components/Pregunta.jsx";
import ReactDOM from "react-dom";
const e = React.createElement;
var defaults = defaults || {};
var domContainer;

(function() {
  window.Pregunta = function() {
    defaults = {
      selector: "",
      reference: "",
      referenceId: "",
      getFiles: "",
      postFiles: ""
      // type: ''
    };

    // Create options by extending defaults with the passed in arugments
    if (arguments[0] && typeof arguments[0] === "object") {
      this.options = extendDefaults(defaults, arguments[0]);
    }
  };

  Pregunta.prototype.init = function() {
    buildInit.call(this);
  };

  Pregunta.prototype.show = function (id) {
    domContainer = document.querySelector(this.options.selector);
    ReactDOM.render(
      <Question
        selector={this.options.selector}
        reference={this.options.reference}
        referenceId={this.options.referenceId}
        getFiles={id}
        postFiles={this.options.postFiles}
      />,
      domContainer
    );
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
    domContainer = document.querySelector(this.options.selector);
    ReactDOM.render(
      <Question
        selector={this.options.selector}
        reference={this.options.reference}
        referenceId={this.options.referenceId}
        getFiles={this.options.getFiles}
        postFiles={this.options.postFiles}
      />,
      domContainer
    );
  }
})();
