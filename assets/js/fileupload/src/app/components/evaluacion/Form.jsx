import React, { useState, useEffect } from "react";
import { Formik } from "formik";
import Select from "react-select";
import * as Yup from "yup";
import axios from "axios";
const path = window.jQuery("#base_url").attr("data-base-url");

const colourStyles = {
  control: styles => ({
    ...styles,
    backgroundColor: "white",
    borderRadius: "0px",
    // height: "34px",
    minHeight: "34px"
  })
};

const validationSchema = Yup.object({
  titulo: Yup.string().required("El titulo es requerido."),
  // fecha_inicio: Yup.date()
  //   .typeError("El formato de la fecha inicio no es valido.")
  //   .required("Por favor indique la fecha inicio."),
  // dias_previos: Yup.number(),
  tiempo_evaluacion: Yup.string().required(
    "El tiempo de evaluacion es requerido"
  ),
  tipos_evaluaciones: Yup.string().required(
    "El tipo de evaluacion es requerido"
  ),
  // puesto_evaluados: Yup.array()
  //   .typeError("Por favor indice los empleados a evaluar")
  //   .required("Por favor indice los empleados a evaluar"),
  // puesto_evaluadores: Yup.array()
  //   .typeError("Por favor indique a los evaluadores")
  //   .required("Por favor indique a los evaluadores"),
  descripcion: Yup.string().required("La descripción es requerida")
});

const CustomForm = ({ children, model, submit, proState }) => {
  const [state, setState] = useState(proState);
  const [evaluados, setEvaluado] = useState([]);
  const [evaluadores, setEvaluadores] = useState([]);

  const handleChangePuesto = (name, data) => {
    var id = "";
    data.forEach(v => (id += `${v.value},`));
    id = id.substr(0, id.length - 1);
    if (name === "puesto_evaluados") {
      if (data.length == 0) {
        setEvaluado([]);
        return;
      }
      axios
        .get(`${path}evaluaciones/getEmpleadoByPuesto/`, {
          params: {
            id: id
          }
        })
        .then(response => setEvaluado(response.data.data))
        .catch(error => console.log(error));
    } else {
      if (data.length == 0) {
        setEvaluadores([]);
        return;
      }
      axios
        .get(`${path}evaluaciones/getEmpleadoByPuesto/`, {
          params: {
            id: id
          }
        })
        .then(response => setEvaluadores(response.data.data))
        .catch(error => console.log(error));
    }
  };

  useEffect(() => {
    setState(proState);
  }, [proState]);

  const handleNext = (e, action) => {
    e.preventDefault();
    e.stopPropagation();
    const tab = window.jQuery(".nav-tabs li.active a");
    const hasError = window.jQuery(tab.attr("href")).find(".has-error").length;
    const hasErrorLength = window.jQuery("#txTitulo").val().length;
    if (hasError > 0 || hasErrorLength == 0) {
      return;
    }

    const items = window.jQuery(".nav-tabs a").length;
    let index = window.jQuery(tab).attr("data-index");
    var next = 0;
    if (action) next = parseInt(index) + 1;
    else next = parseInt(index) - 1;

    window.jQuery(`.nav-tabs a[data-index="${next}"]`).tab("show");
    if (next == items) {
      window.jQuery(this).hide();
      window.jQuery("#bnNext").hide();
      window.jQuery("#bnSubmit").show();
    } else {
      window.jQuery("#bnSubmit").hide();
      window.jQuery("#bnNext").show();
    }
  };

  return (
    <Formik
      initialValues={{
        titulo: state.model.titulo || "",
        tiempo_evaluacion: state.model.tipo_periodo || 0,
        tipos_evaluaciones: state.model.tipo_evaluacion_id,
        descripcion: state.model.descripcion || ""
      }}
      enableReinitialize
      validationSchema={validationSchema}
      onSubmit={(values, actions) => {
        values["evaluados"] = evaluados;
        values["evaluadores"] = evaluadores;
        submit(values, actions);
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
        isSubmitting
      }) => (
        <form onSubmit={handleSubmit} className="form">
          <div className="tab-content tab-size">
            <div id="home" className="tab-pane fade in active">
              <div className="row">
                <div className="col-md-7">
                  <div
                    className={
                      errors.titulo ? "form-group has-error" : "form-group"
                    }
                  >
                    <label className="control-label" htmlFor="txTitulo">
                      Título *
                    </label>
                    <input
                      type="text"
                      className="form-control"
                      id="txTitulo"
                      name="titulo"
                      placeholder="Título"
                      onChange={handleChange}
                      value={values.titulo}
                    />
                    <span className="help-block">{errors.titulo}</span>
                  </div>
                </div>
              </div>
              <div className="row">
                <div className="col-md-3">
                  <div className="form-group">
                    <label htmlFor="txFechaInicio">Periodicidad</label>
                    <select
                      className="form-control"
                      name="tiempo_evaluacion"
                      id="cbTiempoEvaluacion"
                      onChange={handleChange}
                      value={values.tiempo_evaluacion}
                    >
                      <option value="1">Mensual</option>
                      <option value="2">Bimestral</option>
                      <option value="3">Trimestral</option>
                      <option value="6">Semestral</option>
                      <option value="12">Anual</option>
                    </select>
                  </div>
                </div>
                <div className="col-md-5">
                  <div
                    className={
                      errors.tipos_evaluaciones
                        ? "form-group has-error"
                        : "form-group"
                    }
                  >
                    <label className="control-label" htmlFor="cbTipoEvaluacion">
                      Tipos de evaluación *
                    </label>
                    <select
                      className="form-control"
                      placeholder="Selecione una opción"
                      onChange={handleChange}
                      name="tipos_evaluaciones"
                      id="cbTipoEvaluacion"
                      value={values.tipos_evaluaciones}
                    >
                      {_.map(state.tipos, it => (
                        <option key={it.value} value={it.value}>
                          {it.label}
                        </option>
                      ))}
                    </select>

                    <span className="help-block">
                      {errors.tipos_evaluaciones}
                    </span>
                  </div>
                </div>
              </div>
              <div className="row">
                <div className="col-md-12">
                  <div
                    className={
                      errors.descripcion ? "form-group has-error" : "form-group"
                    }
                  >
                    <label htmlFor="txDiasPtxDescripcionrevios">
                      Descripción
                    </label>
                    <textarea
                      className="form-control"
                      id="txDescripcion"
                      name="descripcion"
                      placeholder="Descripción"
                      style={{ height: 150 }}
                      maxLength={255}
                      onChange={handleChange}
                      value={values.descripcion}
                    ></textarea>
                    <span className="help-block">{errors.descripcion}</span>
                  </div>
                </div>
              </div>
            </div>
            <div id="menu2" className="tab-pane fade">
              {children}
            </div>
          </div>
          <div className="row">
            <div className="col-md-4 col-md-offset-8">
              <button
                id="bnSubmit"
                className="btn btn-default pull-right"
                type="submit"
                style={{ display: "none" }}
              >
                Guardar
              </button>
              <button
                id="bnNext"
                style={{ marginLeft: "8px" }}
                className="next btn btn-default pull-right"
                onClick={e => handleNext(e, true)}
                type="button"
              >
                Siguiente
              </button>
              <button
                id="bnPrev"
                className="next btn btn-default pull-right"
                onClick={e => handleNext(e, false)}
                type="button"
              >
                Anterior
              </button>
            </div>
          </div>
        </form>
      )}
    </Formik>
  );
};

export default CustomForm;
