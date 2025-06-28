import React from "react";

function ModeloPregunta(props) {
  function validate(e) {
    var t = e.target.value;
    e.target.value =
      t.indexOf(".") >= 0
        ? t.substr(0, t.indexOf(".")) + t.substr(t.indexOf("."), 3)
        : t;
  }
  switch (props.Tipo) {
    case "1":
      return (
        <input
          placeholder="Respuesta corta"
          className="form-control"
          type="text"
          disabled
        />
      );
      break;
    case "2":
      return (
        <textarea
          placeholder="Respuesta larga"
          className="form-control"
          disabled
        ></textarea>
      );
      break;
    case "6":
      return (
        <div className="row">
          <div className="col-md-7">
            <input
              className="form-control"
              placeholder="Ingrese una opción"
              id="Value"
              name="Value"
              onKeyPress={props.handleInputChangeMt}
              value={props.state.Value || ""}
              onChange={e => props.handleInput(e)}
            />
          </div>
          <div className="col-md-3">
            <input
              className="form-control"
              type="number"
              disabled={props.state.checked !== true}
              placeholder="Puntaje"
              id="Ponderacion"
              name="Ponderacion"
              onKeyPress={props.handleInputChangeMt}
              value={props.state.Ponderacion || ""}
              onChange={e => props.handleInput(e)}
              onInput={e => validate(e)}
              min={1}
            />
          </div>
          <div
            className="col-md-2"
            style={{ textAlign: "center", paddingRight: "30px" }}
          >
            <input
              type="checkbox"
              /* disabled={props.Filas.length>0} */ checked={
                props.state.checked
              }
              onChange={props.toggleChange}
              name="Required"
            />{" "}
            Ponderación manual
          </div>
        </div>
      );
      break;
    case "3":
    case "4":
    case "7":
    case "8":
      return (
        <>
        <div className="row">
          <div className="col-md-8">
            <input
              className="form-control"
              placeholder="Ingrese una opción"
              id="Value"
              name="Value"
              onKeyPress={props.handleInputChange}
              value={props.state.Value || ""}
              onChange={e => props.handleInput(e)}
            />
          </div>
          <div className="col-md-4">
            <button className="btn btn-primary btn-sm" onClick={props.addValue}>
              Agregar
            </button>
          </div>
        </div>
        <div className="row">
        <div className="col-md-12 text-center">
          <div className={"note"}>
            <b><em >Nota: Seleccione el círculo para marcar la respuesta correcta.</em></b>
          </div>
        </div>
      </div>
      </>
      );
    default:
      return (
        <div className="text-center">
          <br />
          Seleccione algún tipo de pregunta
        </div>
      );
      break;
  }
}
export default ModeloPregunta;
