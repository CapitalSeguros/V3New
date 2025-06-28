import React, { useState, useEffect } from "react";
import axios from "axios";

function AlertForm({ id, Credenciales, show }) {
  const path = window.jQuery("#base_url").attr("data-base-url");
  const [state, setState] = useState({
    Usuario: "",
    Contrasena: ""
  });

  function ValidarUsuario() {
    const params = { Usuario: state.Usuario, Contrasena: state.Contrasena };
    axios
      .post(`${path}Bonos/ValidacionLogeo`, params)
      .then(response => {
        if (response.data.code == "200") {
          window.jQuery(`#${id}`).modal("hide");
        }
        Credenciales(response.data);
      })
      .catch(error => console.log(error));
  }

  useEffect(() => {
    if (show > 0) {
      window.jQuery(`#${id}`).modal("show");
    } else {
      window.jQuery(`#${id}`).modal("hide");
    }
  }, [show]);

  function closeModal() {
    setState({ ...state, Usuario: "", Contrasena: "" });
    $(`#${id}`).modal("hide");
  }

  $(`#${id}`).on("hidden.bs.modal", function() {
    if (state.Usuario !== "") {
      setState({ ...state, Usuario: "", Contrasena: "" });
    }
  });

  return (
    <>
      <div
        className="modal fade bd-example-modal-lg"
        id={id}
        tabIndex="-1"
        role="dialog"
        aria-labelledby="exampleModalCenterTitle"
        aria-hidden="true"
      >
        <div className="modal-dialog modal-sm">
          <div className="modal-content">
            <div className="modal-header">
              <h4 className="modal-title">Ingrese sus credenciales</h4>
            </div>
            <div className="modal-body">
              <div className="row">
                <div className="col-sm-12" style={{ paddingBottom: 10 }}>
                  <label htmlFor="basic-url">Usuario</label>
                  <div className="input-group">
                    <span className="input-group-addon">
                      <i className="fa fa-user" aria-hidden="true"></i>
                    </span>
                    <input
                      value={state.Usuario || ""}
                      onChange={e =>
                        setState({ ...state, Usuario: e.target.value })
                      }
                      id="usuario"
                      name="usuario"
                      autoComplete="off"
                      type="text"
                      className="form-control"
                    />
                  </div>
                </div>
                <div className="col-sm-12">
                  <label htmlFor="basic-url">Contraseña</label>
                  <div className="input-group">
                    <span className="input-group-addon">
                      <i className="fa fa-key" aria-hidden="true"></i>
                    </span>
                    <input
                      value={state.Contrasena || ""}
                      onChange={e =>
                        setState({ ...state, Contrasena: e.target.value })
                      }
                      id="Contrasena"
                      name="Contrasena"
                      autoComplete="off"
                      type="text"
                      className="form-control pw"
                    />
                  </div>
                </div>
              </div>
            </div>
            <div className="modal-footer">
              <button className="btn btn-default" onClick={() => closeModal()}>
                Cerrar
              </button>
              <button
                onClick={() => ValidarUsuario()}
                disabled={!state.Usuario || !state.Contrasena}
                className="btn btn-primary"
              >
                Validar
              </button>
            </div>
          </div>
        </div>
      </div>
    </>
  );
}

export default AlertForm;
