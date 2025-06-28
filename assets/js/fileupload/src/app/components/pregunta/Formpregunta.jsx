import React from "react";
function Formpregunta(props) {
  return (
    <div className="row">
      <div className="col-md-7">
        <div className="form-group">
          <label>Título</label>
          <input
            className="form-control"
            value={props.state.Titulo || ""}
            name="Titulo"
            placeholder="Título"
            autoComplete="off"
            onChange={e => props.handleInput(e)}
          />
        </div>
      </div>
      <div className="col-md-3">
        <div className="form-group">
          <label>Tipo</label>
          <select
            value={props.state.Tipo || ""}
            className="form-control"
            name="Tipo"
            id="Tipo"
            onChange={e => props.handleInput(e)}
          >
            <option value={""} defaultValue>
              Seleccione una opción
            </option>
            {props.ListaTipo.map((it, k) => (
              <option key={k} value={it.id}>
                {it.nombre}
              </option>
            ))}
          </select>
        </div>
      </div>
      <div className="col-md-2">
        <div
          className="form-group"
          style={{ textAlign: "center", paddingTop: "20px", paddingRight: 30 }}
        >
          <input
            type="checkbox"
            name="Required"
            value={props.state.Required || ""}
            onChange={e => props.handleInput(e)}
          />{" "}
          Requerido
        </div>
      </div>
    </div>
  );
}

export default Formpregunta;
