import React, { useState } from "react";
import PropTypes from "prop-types";

function searchCompetencia(props) {
  const NumRespuestas = props => {
    return (
      <div className="col-sm-12">
        <div className="row">
          <div className="col-md-12">
            <label>Numero de respuestas</label>
            <div className="form-group">
              <select
                className="form-control"
                id="numRespuesta"
                name="numRespuesta"
                defaultValue={props.state.NumResp}
               /*  value={props.state.NumResp} */
                onChange={e => {
                  props.onChange(e);
                }}
              >
                <option value="1">1</option>
                <option value="2">2</option>
                <option value="3">3</option>
                <option value="4">4</option>
              </select>
            </div>
          </div>
        </div>
      </div>
    );
  };
  return (
    <>
      <div className="row">
      {/* <div className="col-sm-12">
          <div className="form-group">
            <label>Título</label>
            <input type="text" className="form-control" name="search" id="search" onChange={props.onChange}/>
          </div>
        </div> */}
        <div className="col-sm-12">
          <div className="form-group">
            <label>Seleccione un tipo de pregunta</label>
            <select
              className="form-control"
              id="TipoPregunta"
              name="TipoPregunta"
              onChange={props.onChange}
            >
              <option disabled value="">
                Seleccione una opción
              </option>
              <option value="">Todos</option>
              {props.Tipopregunta &&
                props.Tipopregunta.map((item, i) => {
                  return (
                    <option key={i} value={item.nombre}>
                      {item.nombre}
                    </option>
                  );
                })}
                
            </select>
          </div>
        </div>
        
        {props.Tipo === "Matrix Rubic" ? (
          <NumRespuestas onChange={props.onChange} state={props.state} />
        ) : (
          ""
        )}
      </div>
    </>
  );
}
searchCompetencia.propTypes = {
  //children: PropTypes.element.isRequired,
};

export default searchCompetencia;
