import React from "react";
import PropTypes from "prop-types";

const CollectionCompetenciaItemCustom = ({ item, addToList }) => {
  return (
    <li data-id-item={item.id} className="card card-item">
      <div className="card-header">
        <h1>{item.nombre}</h1>
      </div>
      <h2 className="card-description">
        <small>{item.descripcion ? item.descripcion : "Sin descripción"}</small>
      </h2>
      <div className="card-detail">
        <p>Puesto:{item.puesto ? item.puesto : "Sin asignar"}</p>
        <p>No. reactivos: 4</p>
      </div>
    </li>
  );
};
CollectionCompetenciaItemCustom.prototype = {
  item: PropTypes.object.isRequired,
  addToList: PropTypes.func.isRequired
};

export default CollectionCompetenciaItemCustom;
