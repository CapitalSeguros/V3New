import React from "react";
import * as Yup from "yup";
import { Formik } from "formik";
import Select from "react-select";
import DatePicker, { registerLocale } from "react-datepicker";
import es from "date-fns/locale/es";
registerLocale("es", es);

const ModalForm = ({ Titulo, state, Submit }) => {
  const colourStyles = {
    control: styles => ({
      ...styles,
      backgroundColor: "white",
      borderRadius: "0px",
      minHeight: "34px"
    })
  };
  const colourStylesErr = {
    control: styles => ({
      ...styles,
      backgroundColor: "white",
      borderRadius: "0px",
      // height: "34px",
      minHeight: "34px",
      borderColor: "#A94442"
    })
  };

  function submitForm(values) {
    window.autorizar.login(function(response) {
      if (response.code == "200") {
        values["data"] = response.data;
        Submit(values);
      } else {
        window.toastr.error(response.message);
      }
    });
    //Submit(values);
  }

  const validationSchema = Yup.object({
    importe: Yup.number("Debe de ingresar un valor numerico")
      .moreThan(0, "Debe de ser mayor a 0")
      .nullable("Debe de ingresar un valor numerico")
      .integer("Debe de ser un número entero")
      .required("El importe es requerido."),
    motivo: Yup.string().required("El comentario es requerido."),
    estado: Yup.string().required("El estado es requerido"),
    Puntos: Yup.number("Debe de ingresar un valor numerico")
    .moreThan(0, "Debe de ser mayor a 0")
    .max(100,"No debe ser mayor a 100")
    .nullable("Debe de ingresar un valor numerico")
    .integer("Debe de ser un número entero")
    .required("El puntaje es requerido.")
  });
  return (
    <div
      className="modal fade bd-example-modal-lg"
      id="ModalVerificacion"
      tabIndex="-1"
      role="dialog"
      aria-labelledby="exampleModalCenterTitle"
      aria-hidden="true"
    >
      <div className="modal-dialog modal-lg" role="document">
        <div className="modal-content">
          <Formik
            initialValues={state}
            validationSchema={validationSchema}
            enableReinitialize="true"
            onSubmit={(values, { resetForm }) => {
              submitForm(values);
              $("#Logueo").modal("show");
            }}
          >
            {({
              values,
              errors,
              status,
              setFieldValue,
              handleBlur,
              handleChange,
              handleSubmit,
              resetForm
            }) => (
              <form
                onSubmit={e => handleSubmit(e)}
                className="form"
                autoComplete="off"
              >
                <div className="modal-header">{Titulo}</div>
                <div className="modal-body">
                  <div className="row">
                    <div className="col-md-12" style={{ paddingBottom: 10 }}>
                      <strong>
                        <span
                          className="fa fa-info-circle"
                          aria-hidden="true"
                        ></span>
                        Información del registro seleccionado
                      </strong>
                    </div>
                  </div>
                  <div className="row" style={{ paddingBottom: 10 }}>
                    <div className="col-md-4">
                      <strong>
                        <span className="fa fa-user" aria-hidden="true"></span>
                        Puesto
                      </strong>
                      <br />

                      {state.Puesto}
                    </div>
                    <div className="col-md-4">
                      <strong>
                        <span
                          className="fa fa-star"
                          aria-hidden="true"
                        ></span>
                        Puntos 
                      </strong>
                      <br />
                      {state.Puntos} Pts.
                    </div>
                    <div className="col-md-4">
                      <strong>
                        <span className="fa fa-usd" aria-hidden="true"></span>
                        Importe
                      </strong>
                      <br />${state.importe}.00
                    </div>
                  </div>
                  <div className="row" style={{ paddingBottom: 10 }}>
                    <div className="col-md-4">
                      <strong>
                        <span className="fa fa-user" aria-hidden="true"></span>
                        Creado por
                      </strong>
                      <br />
                      {state.Creado}
                    </div>
                  </div>
                  <hr />
                  <div className="row">
                    <div className="col-md-12" style={{ paddingBottom: 10 }}>
                      <strong>
                        <span
                          className="fa fa-info-circle"
                          aria-hidden="true"
                        ></span>
                        Aprobación de la información
                      </strong>
                    </div>
                  </div>
                  {state.status === "PENDIENTE" ? (
                    <div>
                      <div className="row">
                        <div className="col-md-4">
                          <div
                            className={
                              errors.estado
                                ? "form-group has-error"
                                : "form-group"
                            }
                          >
                            <label className="control-label">
                              <strong>Estatus</strong>
                            </label>
                            <Select
                              placeholder="Selecione una opción"
                              id="estado"
                              name="estado"
                              styles={
                                errors.estado ? colourStylesErr : colourStyles
                              }
                              onChange={v => {
                                setFieldValue("estado", v);
                              }}
                              value={values.estado || {}}
                              options={values.Estados}
                            />
                            <span className="help-block">{errors.estado}</span>
                          </div>
                        </div>
                        <div className="col-md-4">
                            <div
                            className={
                                errors.Puntos ? "form-group has-error" : "form-group"
                            }
                            >
                            <label className="control-label">
                                <strong>Puntaje</strong>
                            </label>
                            <div
                                className={
                                errors.Puntos ? "input-group has-error" : "input-group"
                                }
                            >
                                <input
                                name="Puntos"
                                value={values.Puntos || ""}
                                onChange={handleChange}
                                type="number"
                                className="form-control fielhth"
                                />
                                <span className="input-group-addon">Pts</span>
                            </div>
                            <span className="help-block">{errors.Puntos}</span>
                            </div>
                        </div>
                        <div className="col-md-4">
                          <div
                            className={
                              errors.importe
                                ? "form-group has-error"
                                : "form-group"
                            }
                          >
                            <label className="control-label">
                              <strong>Importe</strong>
                            </label>
                            <div
                              className={
                                errors.importe
                                  ? "input-group has-error"
                                  : "input-group"
                              }
                            >
                              <span className="input-group-addon">$</span>
                              <input
                                value={values.importe || ""}
                                name="importe"
                                onChange={handleChange}
                                type="number"
                                className="form-control fielhth"
                              />
                            </div>
                            <span className="help-block">{errors.importe}</span>
                          </div>
                        </div>
                      </div>

                      <div className="row">
                        <div className="col-md-12">
                          <div
                            className={
                              errors.motivo
                                ? "form-group has-error"
                                : "form-group"
                            }
                          >
                            <label className="control-label">
                              <strong>Comentarios</strong>
                            </label>
                            <textarea
                              name="motivo"
                              value={values.motivo || ""}
                              onChange={handleChange}
                              maxLength={400}
                              className="form-control"
                            ></textarea>
                            <label className="control-label">
                              Caracteres ingresados:{values.motivo.length} de
                              400
                            </label>
                            <span className="help-block">{errors.motivo}</span>
                          </div>
                        </div>
                      </div>
                      <div className="modal-footer">
                        <button
                          type="button"
                          className="btn btn-secondary"
                          data-dismiss="modal"
                          onClick={resetForm}
                        >
                          Cerrar
                        </button>
                        <button type="submit" className="btn btn-primary">
                          <i className="fa fa-floppy-o" aria-hidden="true"></i>
                          Guardar
                        </button>
                      </div>
                    </div>
                  ) : (
                    <div className="row">
                      <div className="col-md-12">
                        <div>
                          Esta solicitud tiene un estado de {state.status}
                          <br />
                          {state.status === "AUTORIZADO" ? (
                            <div>
                              El importe autorizado es: ${state.importeF}.00 en
                              la fecha {state.fechaF}
                            </div>
                          ) : (
                            ""
                          )}
                        </div>
                      </div>
                    </div>
                  )}
                </div>
              </form>
            )}
          </Formik>
        </div>
      </div>
    </div>
  );
};

export default ModalForm;
