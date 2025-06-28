import React, { useState, useEffect } from "react";
import * as Yup from "yup";
import { Formik } from "formik";
import { DatePickerField as DatePicker } from "../common";

const path = window.jQuery("#base_url").attr("data-base-url");
const validationSchema = Yup.object({
  Agente: Yup.number("Debe de ingresar un valor numerico")
    .typeError('Oficina debe ser un numero')
    .moreThan(-1, "Debe de ser positivo")
    .nullable("Debe de ingresar un valor numerico")
    .required("El Agente es requerido."),
  Oficina: Yup.number("Debe de ingresar un valor numerico")
    .typeError('Oficina debe ser un numero')
    .moreThan(-1, "Debe de ser positivo")
    .nullable("Debe de ingresar un valor numerico")
    .integer("Debe de ser un número entero")
    .required("La oficina es requerido."),
  Fechainicio: Yup.date("Ingrese una fecha valida").required(
    "La Fecha inicio es requerido."
  ),
  FechaFin: Yup.date("Ingrese una fecha valida")
    .min(Yup.ref("Fechainicio"), "Debe de ser mayor a Fecha inicio")
    .required("La Fecha inicio es requerido."),
  Supervisor: Yup.bool()
});

function submitForm(values, actions) {
    console.log("valoresForm", values);
  }

const NewSiniestro = ({ data, Titulo }) => {
  return (
    <>
      <div className="modal-header">{Titulo}</div>
      <div className="modal-body">
        <Formik
          initialValues={{
            Agente: null,
            Oficina: null,
            Fechainicio: '',
            FechaFin: '',
            Supervisor: false
          }}
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
          }) => 
          <form onSubmit={handleSubmit} className="form" autoComplete="off">
              <div className="row">
                <div className="col-sm-3 col-md-3">
                    <div className={errors.Agente ? "form-group has-error" : "form-group"}>
                        <label className="control-label">
                            Agente
                        </label>
                        <input onChange={handleChange} value={values.Agente|| ""} type="text" name="Agente" className="form-control" />
                        <span className="help-block">{errors.Agente}</span>
                    </div>
                </div>
                <div className="col-sm-3 col-md-3">
                    <div className={errors.Oficina ? "form-group has-error" : "form-group"}>
                        <label  className="control-label">
                            Oficina
                        </label>
                        <input onChange={handleChange} value={values.Oficina|| ""} type="text" name="Oficina" className="form-control" />
                        <span className="help-block">{errors.Oficina}</span>
                    </div>
                </div>
                <div className="col-sm-3 col-md-3">
                    <div className={errors.Fechainicio ? "form-group has-error" : "form-group"}>
                        <label className="control-label">
                            Fecha inicio
                        </label>
                        <DatePicker
                        dateFormat="yyyy-MM-dd"
                        className="form-control input-sm"
                        showPopperArrow={true}
                        name="Fechainicio"
                        id="txFechaInicio"
                        selected={values.Fechainicio}
                        placeholder="Fechainicio"
                        //   disabled={values.fechaInicio != ""}
                        title="Fechainicio"
                        autoComplete="off"
                      />
                        <span className="help-block">{errors.Fechainicio}</span>
                    </div>
                </div>
                <div className="col-sm-3 col-md-3">
                    <div className={errors.FechaFin ? "form-group has-error" : "form-group"}>
                        <label className="control-label">
                            Fecha fin
                        </label>
                        <DatePicker
                        dateFormat="yyyy-MM-dd"
                        className="form-control input-sm"
                        showPopperArrow={true}
                        name="FechaFin"
                        id="txFechaFin"
                        selected={values.FechaFin}
                        placeholder="FechaFin"
                        //   disabled={values.fechaInicio != ""}
                        title="FechaFin"
                        autoComplete="off"
                      />
                        <span className="help-block">{errors.FechaFin}</span>
                    </div>
                </div>
              </div>
              <div className="row">
                    <div className="col-sm-3 col-md-3">
                        <div className={errors.Supervisor? "form-group has-error" : "form-group"}>
                            <div className="checkbox">
                                <label><input className="Supervisor" onChange={handleChange} type="checkbox" value={values.Supervisor}/>Supervisor</label>
                            </div>
                            <span className="help-block">{errors.Supervisor}</span>
                        </div>
                    </div>
                    <div className="col-sm-9 col-md-9">
                        <button style={{float:"right"}} className="btn btn-primary" type="submit">Consultar</button>
                    </div>
                </div>
          </form>}
        </Formik>
      </div>
    </>
  );
};

export default NewSiniestro;
