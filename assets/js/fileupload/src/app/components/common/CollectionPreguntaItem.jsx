import React from "react";
import PropTypes from "prop-types";

const CollectionPreguntaItemCustom = ({ item, addToList, index, especial }) => {
  return (
    <li data-id-item={item.Idp} className="card card-item">
      <div className="card-header">
        <h1>{item.titulo}</h1>
        {especial !== true ? (
          ""
        ) : (
          <a className="remove" onClick={() => addToList(index, item)}>
            <i className="fa fa-times" aria-hidden="true"></i>
          </a>
        )}
      </div>
      <h2 className="card-description">
        <em>Sin descripción</em>
      </h2>
      <div className="card-detail">
        <p>Tipo de pregunta: {item.nombre}</p>
        <p>Número de reactivos: {item.cantidad}</p>
      </div>
    </li>
  );
};
CollectionPreguntaItemCustom.prototype = {
  item: PropTypes.object.isRequired,
  addToList: PropTypes.func.isRequired,
  especial: PropTypes.bool.isRequired
};

export default CollectionPreguntaItemCustom;
