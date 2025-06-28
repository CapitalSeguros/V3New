import React from "react";
import * as Yup from "yup";
import { Formik } from "formik";
import Select from "react-select";
import {stylesSelect} from "../common/stylesSelect.js";


const ModalForm = ({ Titulo, state, postData }) => {

  function submitForm(values, actions) {
    postData(values, actions);
  }

  const validationSchema = Yup.object({
    Puntos: Yup.number("Debe de ingresar un valor numerico")
      .moreThan(0, "Debe de ser mayor a 0")
      .max(100,"No debe ser mayor a 100")
      .nullable("Debe de ingresar un valor numerico")
      .integer("Debe de ser un número entero")
      .required("El puntaje es requerido."),
    importe: Yup.number("Debe de ingresar un valor numerico")
    .moreThan(0, "Debe de ser mayor a 0")
    .nullable("Debe de ingresar un valor numerico")
    .integer("Debe de ser un número entero")
    .required("El importe es requerido."),
    Puesto: Yup.string().required("El puesto es requerido")
  });
  return (
    <Formik
      initialValues={state}
      validationSchema={validationSchema}
      enableReinitialize="true"
      onSubmit={(values, actions) => {
        /* console.log('actions',actions); */
        submitForm(values, actions);
        //resetForm();
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
        <form onSubmit={handleSubmit} className="form" autoComplete="off">
          <div className="modal-header">{Titulo}</div>
          <div className="modal-body">
            <div className="row">
              <div className="col-md-4">
                <div
                  className={
                    errors.empleado ? "form-group has-error" : "form-group"
                  }
                >
                  <label className="control-label">
                    <strong>Seleccione un puesto</strong>
                  </label>
                  <Select
                    placeholder="Selecione una opción"
                    id="empleado"
                    name="empleado"
                    styles={errors.Puesto ? stylesSelect(250,2,"puesto") : stylesSelect(250,1,"puesto")}
                    isDisabled={state.edit}
                    onChange={v => {
                      setFieldValue("Puesto", v);
                    }}
                    value={values.Puesto}
                    options={_puestos2}
                  />
                  <span className="help-block">{errors.Puesto}</span>
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
                    errors.importe ? "form-group has-error" : "form-group"
                  }
                >
                  <label className="control-label">
                    <strong>Bono</strong>
                  </label>
                  <div
                    className={
                      errors.importe ? "input-group has-error" : "input-group"
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
          </div>
          <div className="modal-footer">
            <button
              type="button"
              className="btn btn-secondary"
              data-dismiss="modal"
            >
              Cerrar
            </button>
            <button type="submit" className="btn btn-primary" id="save">
              <i className="fa fa-floppy-o" aria-hidden="true"></i> Guardar
            </button>
          </div>
        </form>
      )}
    </Formik>
  );
};

export default ModalForm;
