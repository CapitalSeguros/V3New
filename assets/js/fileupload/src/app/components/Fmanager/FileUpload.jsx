import React, { useState, useEffect } from "react";
import Select from "react-select";
import { stylesSelect } from "./stylesSelect";

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

  function Onclose() {
    $(`#${id}`).modal('hide');
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
              {!isFolder && (
                <div className="row">
                  <div className="col-sm-12 col-md-12">
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
                </div>
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
              {isFolder ? (
                <div className="row">
                  <div className="col-sm-12 col-md-12">
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
                            multiple={true}
                            name="archivos"
                            onChange={(event) => {
                              //var filename = event.currentTarget.files[0].name;
                              var filename = event.currentTarget.files;
                              let text = "";
                              console.log(`cantidad ${filename.length}`)
                              if (filename.length > 4) {
                                text = `Se han cargado ${filename.length} archivos.`;
                              } else {
                                var all = [];
                                console.log("Filename", filename)
                                Array.from(filename).forEach(element => {
                                  all.push(element.name.replace("C:\\fakepath\\", ""));
                                });
                                text = all.join(',');
                              }
                              console.log(text);
                              $("#noFile").text(text);
                              /*  $("#noFile").text(
                                 filename.replace("C:\\fakepath\\", "")
                               ); */
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
            </div>
            <div className="modal-footer">
              <a
                type="button"
                id="close"
                className="btn btn-secondary"
                onClick={() => Onclose()}
              >
                Cerrar
              </a>
              <a type="submit" onClick={(e)=>onSubmit(e)} className="btn btn-primary">
                {isPermissions ? "Guardar" : "Subir"}
              </a>
            </div>
          </form>
        </div>
      </div>
    </div>
  );
};

export default FileUpload;
