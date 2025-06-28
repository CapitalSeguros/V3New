import React from "react";
import PropTypes from "prop-types";

const CollectionEvaluacionItemCustom = ({ item, removeItem, handleChange }) => {
  return (
    <li data-id-item={item.id} className="card card-item">
      <div className="card-header">
        <h1>{item.nombre}</h1>
        {/* <select
          name={"grado" + item.id}
          style={{
            marginTop: "-20px",
            marginRight: "20px",
            width: "100px"
          }}
          className="form-control input-sm pull-right"
          onChange={value => handleChange(value, item)}
        >
          <option value="A">A</option>
          <option value="B">B</option>
          <option value="C">C</option>
          <option value="D">D</option>
        </select> */}
        <a className="remove" onClick={() => removeItem(item)}>
          <i className="fa fa-times" aria-hidden="true"></i>
        </a>
      </div>
      <h2 className="card-description">
        <em>{item.descripcion}</em>
      </h2>
      <div className="card-detail">
        <p>Puesto de trabajo:{item.puesto ? item.puesto : "Sin asignar"}</p>
        <p>Número de reactivos: 4</p>
      </div>
    </li>
  );
};
CollectionEvaluacionItemCustom.prototype = {
  item: PropTypes.object.isRequired,
  removeItem: PropTypes.func.isRequired
};

export default CollectionEvaluacionItemCustom;
