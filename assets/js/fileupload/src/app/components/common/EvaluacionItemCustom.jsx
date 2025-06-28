import React from "react";
import PropTypes from "prop-types";
import Select from "react-select";
import {stylesSelect} from "../common/stylesSelect.js";
const EvaluacionItemCustom = ({
  item,
  removeItem,
  setFieldValue,
  handleChangePuesto,
  puestos,
  puestos2,
  puesto_evaluados,
  puesto_evaluadores
}) => {
  return (
    <li data-id-item={item.id} className="card card-item">
      <div className="card-header">
        <h1>{item.titulo}</h1>
        {removeItem != undefined ? (
          <a className="remove" onClick={() => removeItem(item)}>
            <i className="fa fa-times" aria-hidden="true"></i>
          </a>
        ) : (
          ""
        )}
      </div>
      <div className="card-description">
        <small>{item.tipo_evaluacion ? item.tipo_evaluacion : ""}</small>
      </div>
      {puestos ? (
        <>
          <small>Puestos que serán evaluados</small>
          <Select
            placeholder="Selecione una opción para asignar puestos."
            id="cbPuestoEvaluadores"
            styles={stylesSelect(650,1,"puesto")}
            isMulti
            isSearchable
            closeMenuOnSelect={false}
            onChange={(v, action) => {
              //console.log(action);
              var ob = {};
              ob[item.id] = v;
              if (action.action == "remove-value") {
                ob["item"] = action.removedValue;
              }
              handleChangePuesto("puesto_evaluados", ob);
              setFieldValue(`puesto_evaluados.${item.id}`, v);
            }}
            value={
              puesto_evaluados != undefined
                ? puesto_evaluados[item.id]
                : puesto_evaluados
            }
            options={puestos2}
            noOptionsMessage={()=>"Sin opciones"}
          />
          <small>Puestos que evaluarán</small>
          <Select
            placeholder="Selecione una opción para asignar puestos."
            id="cbPuestoEvaluadores"
            styles={stylesSelect(650,1,"puesto")}
            isMulti
            closeMenuOnSelect={false}
            name="puesto_evaluadores"
            menuPosition="top"
            onChange={v => {
              var ob = {};
              ob[item.id] = v;
              handleChangePuesto("puesto_evaluadores", ob);
              setFieldValue(`puesto_evaluadores[${item.id}]`, v);
            }}
            value={
              puesto_evaluadores != undefined
                ? puesto_evaluadores[item.id]
                : puesto_evaluadores
            }
            options={puestos2}
            noOptionsMessage={()=>"Sin opciones"}
          />
        </>
      ) : (
        ""
      )}
    </li>
  );
};
EvaluacionItemCustom.prototype = {
  item: PropTypes.object.isRequired,
  addToList: PropTypes.func.isRequired
};

export default EvaluacionItemCustom;
