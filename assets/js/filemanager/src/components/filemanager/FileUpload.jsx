import React, { useState, useEffect } from "react";
import Select from "react-select";
import {stylesSelect} from "./stylesSelect";

/* const colourStyles = {
  control: (styles) => ({
    ...styles,
    backgroundColor: "white",
    borderRadius: "0px",
    minHeight: "34px",
  }),
};
 */
const FileUpload = ({
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
    if (isPermissions) {
      setVisible(isPermissions);
    }
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
    $(`#${id}`).modal("hide");
  }

  return (
    <div id={id} className="modal" tabIndex="-1" role="dialog">
      <div className="modal-dialog modal-lg" role="document">
        <div className="modal-content">
          <form onSubmit={onSubmit} className="form">
            <div className="modal-header titulos">
              <h4 className="modal-title" id="exampleModalLabel">
                {isPermissions
                  ? "Modificar permisos..."
                  : isFolder
                  ? "Nuevo archivo..."
                  : "Nueva carpeta..."}
              </h4>
            </div>
            <div className="modal-body">
            {/* <button onClick={()=>console.log(state.puestos)}>pruestos</button> */}
              {isPermissions == undefined ? (
                <div className="row">
                  <div className="col-sm-10 col-md-10">
                    <div className="form-group">
                      <label
                        htmlFor="recipient-name"
                        className="col-form-label titulos"
                      >
                        Nombre
                      </label>
                      <input
                        type="text"
                        className="form-control"
                        name="nombre"
                        placeholder="Nombre"
                        onChange={handleChange}
                        autoComplete="off"
                        value={state.nombre}
                      />
                    </div>
                  </div>
                  <div className="checkbox col-sm-2 col-md-2">
                    <label htmlFor="checkbox"></label>
                    <label>
                      <input
                        type="checkbox"
                        name="privado"
                        onChange={handleChange}
                        value={state.privado}
                      />
                      ¿Es Privado?
                    </label>
                  </div>
                </div>
              ) : (
                ""
              )}
              <div className="row">
                <div
                  className={
                    visible
                      ? "col-sm-12 col-md-12"
                      : "col-sm-12 col-md-12 hidden"
                  }
                >
                  <div className="form-group">
                    <label
                      htmlFor="recipient-name"
                      className="col-form-label titulos"
                    >
                      Seleccione quien puede ver
                    </label>
                    <Select
                      placeholder="Selecione una opción"
                      styles={stylesSelect(null,1,1)}
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
              {isFolder ? (
                <div className="row">
                  <div className="col-sm-8 col-md-8">
                    <div className="form-group">
                      <label
                        htmlFor="recipient-name"
                        className="col-form-label titulos"
                      >
                        Subir Archivos
                      </label>
                      <div className="file-upload">
                        <div className="file-select">
                          <div className="file-select-button" id="fileName">
                            Seleccionar archivo
                          </div>
                          <div className="file-select-name" id="noFile">
                            Archivo no seleccionado...
                          </div>
                          <input
                            type="file"
                            name="archivos"
                            onChange={(event) => {
                              var filename = event.currentTarget.files[0].name;
                              $("#noFile").text(
                                filename.replace("C:\\fakepath\\", "")
                              );
                              $(".file-upload").addClass("active");

                              handleChange(event);
                            }}
                          />
                        </div>
                      </div>
                    </div>
                  </div>
                </div>
              ) : (
                ""
              )}

              {isPermissions == undefined ? (
                <div className="row">
                  <div className="col-sm-12 col-md-12">
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
                        placeholder="Escriba Aqui"
                      ></textarea>
                      <p id="contSmsText">
                        Caracteres usados:{" "}
                        {state.descripcion == null
                          ? 0
                          : state.descripcion.length}{" "}
                        de 300
                      </p>
                    </div>
                  </div>
                </div>
              ) : (
                ""
              )}
            </div>
            <div className="modal-footer">
              <button
                type="button"
                id="close"
                className="btn btn-secondary"
                data-dismiss="modal"
              >
                Cerrar
              </button>
              <button type="submit" className="btn btn-primary">
                {isPermissions ? "Guardar" : "Subir"}
              </button>
            </div>
          </form>
        </div>
      </div>
    </div>
  );
};

export default FileUpload;
