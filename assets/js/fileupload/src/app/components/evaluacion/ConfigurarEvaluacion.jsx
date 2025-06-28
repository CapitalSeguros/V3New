import React, { useEffect, useState } from "react";
import { Formik } from "formik";
import * as Yup from "yup";
import axios from "axios";
import Select from "react-select";

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
  fecha_inicio: Yup.date()
    .typeError("El formato de la fecha inicio no es valido.")
    .required("Por favor indique la fecha inicio."),
  dias_previos: Yup.number(),
  tiempo_evaluacion: Yup.number().required("La periodicidad es requerida"),
  descripcion: Yup.string().required("La descripción es requerida")
});

const path = window.jQuery("#base_url").attr("data-base-url");
const ConfigurarEvaluacion = ({
  actionOpen,
  start,
  reference,
  callBack,
  id
}) => {
  const [state, setState] = useState({ puestos: [], id: 0 });
  const [evaluadores, setEvaluadores] = useState([]);
  const [evaluados, setEvaluados] = useState([]);

  useEffect(() => {
    axios
      .get(`${path}evaluaciones/get`)
      .then(response => {
        const _ps = response.data.data.puesto.map(i => {
          return { value: i.id, label: i.name, parent: i.parent };
        });
        setState({ puestos: _ps });
      })
      .catch(err =>
        window.toaster.error("Ocurrio un error al recuperar las competencias")
      );
  }, []);

  if (actionOpen != "") {
    window.jQuery(document).on("click", actionOpen, function(e) {
      const id = window.jQuery(e.currentTarget).attr("data-in-id");
      if (id != state.id) {
        setState({ ...state, id: id });
      }
      window.jQuery("#modalEvaluacionConfigurar").modal("show");
    });
  }

  const handleChangePuesto = (name, data) => {
    var id = "";
    data.forEach(v => (id += `${v.value},`));
    id = id.substr(0, id.length - 1);
    if (name === "puesto_evaluados") {
      if (data.length == 0) {
        setEvaluados([]);
        return;
      }
      axios
        .get(`${path}evaluaciones/getEmpleadoByPuesto/`, {
          params: { id: id }
        })
        .then(response => setEvaluados(response.data.data))
        .catch(error => console.log(error));
    } else {
      if (data.length == 0) {
        setEvaluadores([]);
        return;
      }
      axios
        .get(`${path}evaluaciones/getEmpleadoByPuesto/`, {
          params: { id: id }
        })
        .then(response => setEvaluadores(response.data.data))
        .catch(error => console.log(error));
    }
  };

  return (
    <div
      id="modalEvaluacionConfigurar"
      className="modal"
      tabIndex="-1"
      role="dialog"
      aria-labelledby="myLargeModalLabel"
      aria-hidden="true"
    >
      <div className="modal-dialog modal-lg">
        <div className="modal-content">
          <Formik
            initialValues={{
              id: id,
              empleado_id: 0,
              evaluadores: [],
              tipo_evaluacion: 1,
              puesto_evaluados: []
            }}
            validationSchema={validationSchema}
            onSubmit={(values, actions) => {
              console.log(values);
              console.log(actions);
              //   submit(values, actions);
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
                <div class="modal-header">
                  <button
                    type="button"
                    class="close"
                    data-dismiss="modal"
                    aria-label="Close"
                  >
                    <span aria-hidden="true">&times;</span>
                  </button>
                  <h4 class="modal-title">Configurar evaluaciones</h4>
                </div>
                <div class="modal-body">
                  <div className="row">
                    <div className="col-md-6">
                      <h4>Personal evaluado</h4>
                      <div className="row">
                        <div className="col-md-12">
                          <div
                            className={
                              errors.puesto_evaluados
                                ? "form-group has-error"
                                : "form-group"
                            }
                          >
                            <label
                              className="control-label"
                              htmlFor="cbPuestoEvaluados"
                            >
                              Puestos
                            </label>
                            <Select
                              placeholder="Selecione una opción"
                              id="cbPuestoEvaluados"
                              styles={colourStyles}
                              isMulti
                              name="puesto_evaluados"
                              onChange={v => {
                                handleChangePuesto("puesto_evaluados", v);
                                setFieldValue("puesto_evaluados", v);
                              }}
                              onBlur={handleBlur}
                              value={values.puesto_evaluados}
                              options={state.puestos}
                            />
                            <span className="help-block">
                              {errors.puesto_evaluados}
                            </span>
                          </div>
                        </div>
                      </div>
                      <div className="row">
                        <div className="col-md-12">
                          <p>Empleados</p>
                          <table className="table">
                            <thead>
                              <tr>
                                <th></th>
                                <th>Nombre</th>
                                <th>Antiguedad</th>
                              </tr>
                            </thead>
                            <tbody>
                              {evaluados.map((item, key) => (
                                <tr key={key}>
                                  <td>{item.id}</td>
                                  <td>{item.nombre}</td>
                                  <td>{item.fecha_ingreso}</td>
                                </tr>
                              ))}
                            </tbody>
                          </table>
                        </div>
                      </div>
                    </div>
                    <div className="col-md-6">
                      <h4>Evaluadores</h4>
                      <div className="row">
                        <div className="col-md-12">
                          <div
                            className={
                              errors.puesto_evaluados
                                ? "form-group has-error"
                                : "form-group"
                            }
                          >
                            <label
                              className="control-label"
                              htmlFor="cbPuestoEvaluadores"
                            >
                              Puestos
                            </label>
                            <Select
                              placeholder="Selecione una opción"
                              id="cbPuestoEvaluadores"
                              styles={colourStyles}
                              isMulti
                              name="puesto_evaluadores"
                              onChange={v => {
                                handleChangePuesto("puesto_evaluadores", v);
                                setFieldValue("puesto_evaluadores", v);
                              }}
                              onBlur={handleBlur}
                              value={values.puesto_evaluadores}
                              options={state.puestos}
                            />
                            <span className="help-block">
                              {errors.puesto_evaluadores}
                            </span>
                          </div>
                        </div>
                      </div>
                      <div className="row">
                        <div className="col-md-12">
                          <p>Empleados</p>
                          <table className="table">
                            <thead>
                              <tr>
                                <th></th>
                                <th>Nombre</th>
                                <th>Antiguedad</th>
                              </tr>
                            </thead>
                            <tbody>
                              {evaluadores.map((item, key) => (
                                <tr key={key}>
                                  <td>{item.id}</td>
                                  <td>{item.nombre}</td>
                                  <td>{item.fecha_ingreso}</td>
                                </tr>
                              ))}
                            </tbody>
                          </table>
                        </div>
                      </div>
                    </div>
                  </div>
                </div>
                <div class="modal-footer">
                  <button
                    type="button"
                    class="btn btn-default"
                    data-dismiss="modal"
                  >
                    Cancelar
                  </button>
                  <button type="submit" class="btn btn-primary">
                    Guardar
                  </button>
                </div>
              </form>
            )}
          </Formik>
        </div>
      </div>
    </div>
  );
};

export default ConfigurarEvaluacion;
