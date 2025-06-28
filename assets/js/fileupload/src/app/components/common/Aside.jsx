import React, { useState } from "react";
import PropTypes from "prop-types";

function AsideCustom(props) {
  const { children } = props;

  const updateChildrenWithProps = React.Children.map(children, (child, i) => {
    return React.cloneElement(child, {
      //this properties are available as a props in child components
      index: i
    });
  });

  return (
    <div {...props}>
      <div className="panel panel-default">
        <div className="panel-body">{updateChildrenWithProps}</div>
      </div>
    </div>
  );
}
AsideCustom.propTypes = {};

export default AsideCustom;
