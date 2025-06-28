import React, { useState, useEffect } from "react";
import Select from "react-select";
import { stylesSelect } from "./stylesSelect";

const FileShare = ({
  id,
  file,
  show,
  isFolder,
  isPermissions,
  eventSubmit,
  eventClose,
  puestos,
}) => {
  const [visible, setVisible] = useState(false);
  const [state, setState] = useState({
    id: "",
    nombre: "",
    descripcion: "",
    isFolder:isFolder,
    archivo: "",
    privado: false,
    puestos: [],
  });

  function handleChange(e) {
    if (Array.isArray(e)) {
      setState({
        ...state,
        ["puestos"]: e,
      });
    } else {
      if (e.currentTarget.name == "privado") {
        setVisible(!visible);
        setState({ ...state, [e.currentTarget.name]: !visible });
      } else {
        setState({
          ...state,
          [e.currentTarget.name]:
            e.currentTarget.files == null
              ? e.currentTarget.value
              : e.currentTarget.files,
        });
      }
    }
  }
  function stateReset(isPermissions, file) {
    setState({
      id: file.file != undefined ? file.file.id : "",
      nombre: "",
      descripcion: "",
      archivo: "",
      privado: false,
      puestos: file.file != undefined ? file.file.puestos : [],
    });
  }

  useEffect(() => {
    if (show) {
      stateReset(isPermissions, file);
      $(`#${id}`).modal({
        backdrop: false,
      });
    }
  }, [show]);

  useEffect(() => {
    $(`#${id}`).on("hidden.bs.modal", function (e) {
      eventClose();
    });
  }, []);

  function onSubmit(e) {
    e.preventDefault();
    eventSubmit(state);
    setState({
        ...state,
        id: "",
        nombre: "",
        descripcion: "",
        isFolder:isFolder,
        archivo: "",
        privado: false,
        puestos: [],
    });
    $(`#modal-file-share`).modal("hide");
  }

  return (
    <div id="modal-file-share" className="modal" tabIndex="-1" role="dialog">
      <div className="modal-dialog modal-lg" role="document">
        <div className="modal-content">
          <form onSubmit={onSubmit} className="form">
            <div className="modal-header titulos">
              <h4 className="modal-title" id="exampleModalLabel">
                Compartir...
              </h4>
            </div>
            <div className="modal-body">
              <div className="row">
                <div className="col-md-12">
                  <div className="form-group">
                    <label
                      htmlFor="recipient-name"
                      className="col-form-label titulos"
                    >
                      Escriba un comentario referente
                    </label>
                    <textarea
                      style={{ height: "100px" }}
                      name="descripcion"
                      onChange={handleChange}
                      value={state.descripcion}
                      className="form-control input-sm"
                      required
                      placeholder="Escriba Aqui"
                    ></textarea>
                    <p id="contSmsText">
                      Caracteres usados:{" "}
                      {state.descripcion == null ? 0 : state.descripcion.length}{" "}
                      de 300
                    </p>
                  </div>
                </div>
                <div className="col-md-12">
                  <div className="form-group">
                    <label
                      htmlFor="recipient-name"
                      className="col-form-label titulos"
                    >
                      Seleccione los puestos a compartir la información
                    </label>
                    <Select
                      placeholder="Selecione una opción"
                      styles={stylesSelect(null, 1, 1)}
                      name="puestos"
                      isMulti
                      onChange={handleChange}
                      value={state.puestos}
                      defaultValue={state.puestos}
                      options={puestos}
                    />
                  </div>
                </div>
              </div>
            </div>
            <div className="modal-footer">
              <a
                type="button"
                id="close"
                className="btn btn-secondary"
                data-dismiss="modal"
              >
                Cerrar
              </a>
              <a type="submit" className="btn btn-primary" disabled={state.puestos.length>0?false:true}>
                Enviar
              </a>
            </div>
          </form>
        </div>
      </div>
    </div>
  );
};

export default FileShare;
