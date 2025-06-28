import React from "react";
import PropTypes from "prop-types";

const DescripcionMonitoreo = props => {
  return (
    <div className="row">
      <div className="col-md-12">
        <div className="col-sm-2 text-right">
          <strong>
            <span className="fa fa-exclamation" aria-hidden="true"></span>{" "}
            Evidencia encontrada
          </strong>
        </div>
        <div className="col-sm-10">{props.Evidencia}</div>
      </div>
      <div className="col-md-12">
        <div className="col-sm-2 text-right">
          <strong>
            <span className="fa fa-star" aria-hidden="true"></span> Mejora
            Esperada
          </strong>
        </div>
        <div className="col-sm-10">{props.Mejora}</div>
      </div>
      <div className="col-md-12">
        <div className="col-sm-2 text-right">
          <strong>
            <span className="fa fa-calendar" aria-hidden="true"></span> Fecha
          </strong>
        </div>
        <div className="col-sm-10">{props.Fecha}</div>
      </div>
    </div>
  );
};
DescripcionMonitoreo.prototype = {};

export default DescripcionMonitoreo;
