import React from 'react'
import Upload from './components/FileUpload.jsx'
import ReactDOM from 'react-dom';
const e = React.createElement;
var defaults = defaults || {};

(function () {

  window.FileUpload = function () {
    defaults = {
      selector: '',
      reference: '',
      referenceId: '',
      getFiles: '',
      postFiles: '',
      type: ''
    };

    // Create options by extending defaults with the passed in arugments
    if (arguments[0] && typeof arguments[0] === "object") {
      this.options = extendDefaults(defaults, arguments[0]);
    }
  }

  FileUpload.prototype.init = function() {
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
    const domContainer = document.querySelector(this.options.selector);
    ReactDOM.render(<Upload selector={this.options.selector} reference={this.options.reference} referenceId={this.options.referenceId} getFiles={this.options.getFiles} postFiles={this.options.postFiles} type="" />, domContainer);
  }
})();