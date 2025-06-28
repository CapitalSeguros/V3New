import React from "react";
import * as Yup from "yup";
import { Formik } from "formik";
import Select from "react-select";
import DatePicker, { registerLocale } from "react-datepicker";
import {stylesSelect} from "../common/stylesSelect.js";
import es from "date-fns/locale/es";
registerLocale("es", es);

const ModalForm = ({ Titulo, state, postData }) => {


  function submitForm(values, actions) {
    postData(values, actions);
  }

  function displayitemPuesto(id,array){
    const _array=array;
    const newData = _array.filter((item, index) => item.puesto === id);
    return newData;
  }

  const validationSchema = Yup.object({
    importe: Yup.number("Debe de ingresar un valor numerico")
      .moreThan(0, "Debe de ser mayor a 0")
      .nullable("Debe de ingresar un valor numerico")
      .integer("Debe de ser un número entero")
      .required("El importe es requerido."),
    motivo: Yup.string().required("El motivo es requerido."),
    empleado: Yup.string().required("El empleado es requerido"),
    fecha: Yup.date()
      .typeError("El formato de la fecha inicio no es valido.")
      .required("Por favor indique la fecha inicio.")
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
            {typeof values.idUsuario=='undefined' && values.idPeticion=="" &&
            <div className="col-md-4">
                <div
                  className={
                    errors.puesto ? "form-group has-error" : "form-group"
                  }
                >
                  <label className="control-label">
                    <strong>Puesto</strong>
                  </label>
                  
                  <Select
                    placeholder="Selecione una opción"
                    id="empleado"
                    name="empleado"
                    styles={errors.puesto ? stylesSelect(250,1,"puesto") : stylesSelect(250,1,"puesto")}
                    //isDisabled={values.puesto != "" }
                    isDisabled={values.idPeticion != "" }
                    onChange={v => {
                      setFieldValue("puesto", v.value),setFieldValue("empleado", ''),setFieldValue("puestoF", v)
                    }}
                    value={values.puestoF||""}
                    options={_puestos}
                  />
                  <span className="help-block">{errors.empleado}</span>
                </div>
              </div>}
              <div className="col-md-4">
                <div
                  className={
                    errors.empleado ? "form-group has-error" : "form-group"
                  }
                >
                  <label className="control-label">
                    <strong>Empleado</strong>
                  </label>
                  <Select
                    placeholder="Selecione una opción"
                    id="empleado"
                    name="empleado"
                    styles={errors.empleado ? stylesSelect(250,2) : stylesSelect(250,1)}
                    isDisabled={typeof values.idUsuario!='undefined' && values.idPeticion!="" }
                    onChange={v => {
                      setFieldValue("empleado", v);
                    }}
                    value={values.empleado||""}
                    options={displayitemPuesto(values.puesto,_empleados)}
                  />
                  <span className="help-block">{errors.empleado}</span>
                </div>
              </div>
              <div className="col-md-4">
                <div
                  className={
                    errors.fecha ? "form-group has-error" : "form-group"
                  }
                >
                  <label className="control-label">
                    <strong>Fecha</strong>
                  </label>
                  <DatePicker
                    locale="es"
                    peekNextMonth
                    showMonthDropdown
                    showYearDropdown
                    name="fecha"
                    dropdownMode="select"
                    dateFormat="yyyy-MM-dd"
                    className="form-control input-sm fielhth"
                    placeholderText="YYYY-MM-DD"
                    showPopperArrow={true}
                    selected={values.fecha ||""}
                    onChange={e => {
                      setFieldValue("fecha", e);
                    }}
                  />
                  <span className="help-block">{errors.fecha}</span>
                </div>
              </div>
              <div className="col-md-4">
                <div
                  className={
                    errors.importe ? "form-group has-error" : "form-group"
                  }
                >
                  <label className="control-label">
                    <strong>Importe</strong>
                  </label>
                  <div
                    className={
                      errors.importe ? "input-group has-error" : "input-group"
                    }
                  >
                    <span className="input-group-addon">$</span>
                    <input
                      style={{zIndex:"0"}}
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
                    errors.motivo ? "form-group has-error" : "form-group"
                  }
                >
                  <label className="control-label">
                    <strong>Motivo</strong>
                  </label>
                  <textarea
                    name="motivo"
                    value={values.motivo||""}
                    onChange={handleChange}
                    maxLength={400}
                    className="form-control"
                  ></textarea>
                  <label className="control-label">
                    Caracteres ingresados:{values.motivo.length} de 400
                  </label>
                  <span className="help-block">{errors.motivo}</span>
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
              <i className="fa fa-floppy-o" aria-hidden="true"></i> Solicitar
            </button>
          </div>
        </form>
      )}
    </Formik>
  );
};

export default ModalForm;
