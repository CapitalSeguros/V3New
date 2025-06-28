import React, { useState } from "react";
import PropTypes from "prop-types";

const MainCustom = props => {
  const { children } = props;

  const updateChildrenWithProps = React.Children.map(children, (child, i) => {
    return React.cloneElement(child, {
      //this properties are available as a props in child components
      index: i
    });
  });

  return (
    <div {...props}>
      <div className="">{updateChildrenWithProps}</div>
    </div>
  );
};
MainCustom.propTypes = {};

export default MainCustom;
