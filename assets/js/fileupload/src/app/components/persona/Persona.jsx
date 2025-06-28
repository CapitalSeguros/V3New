import React, { useState, useEffect } from "react";
import { Formik } from "formik";
import axios from "axios";

const path = window.jQuery("#base_url").attr("data-base-url");
const Persona = ({ actionOpen, start, reference, callBack }) => {
  const [motivos, setMotivo] = useState([]);
  const [empleado, setEmpleado] = useState({ id: 0, nombre: "" });
  useEffect(() => {
    axios.get(`${path}personas/get_baja`).then(response => {
      setMotivo(response.data.data);
    });
  }, []);

  if (actionOpen != "") {
    window.jQuery(document).on("click", actionOpen, function(e) {
      e.preventDefault();
      const id = window.jQuery(e.currentTarget).attr("data-per-id");
      if (id == undefined) return;
      const nombre = window.jQuery(e.currentTarget).attr("data-per-name");
      if (id != empleado.id) {
        setEmpleado({ id: id, nombre: nombre });
      }
      window.jQuery("#modalEmpleadoBaja").modal("show");
    });
  }

  return (
    <div
      id="modalEmpleadoBaja"
      className="modal fade"
      tabIndex="-1"
      role="dialog"
    >
      <div className="modal-dialog" role="document">
        <div className="modal-content">
          <Formik
            enableReinitialize
            initialValues={{
              nombre: empleado.nombre,
              empleadoId: empleado.id,
              motivoId: 0,
              descripcion: ""
            }}
            onSubmit={(values, actions) => {
              axios
                .post(`${path}personas/baja_empleado`, values)
                .then(response => {
                  if (response.data.code == "200") {
                    window.toastr.success(response.data.message);
                    window.jQuery("#modalEmpleadoBaja").modal("hide");
                  } else {
                    window.toastr.error(response.data.message);
                  }
                })
                .error(error => console.error(error));
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
                <div className="modal-header">
                  <button
                    type="button"
                    className="close"
                    data-dismiss="modal"
                    aria-label="Close"
                  >
                    <span aria-hidden="true">&times;</span>
                  </button>
                  <h4 className="modal-title">Baja del empleado</h4>
                </div>
                <div className="modal-body">
                  <div className="form-group">
                    <label htmlFor="txEmpleado">Nombre</label>
                    <input
                      type="empleado"
                      disabled
                      className="form-control"
                      id="txEmpleado"
                      name="empleado"
                      value={values.nombre}
                      placeholder="Empleado"
                      onChange={handleChange}
                    />
                    <input
                      type="hidden"
                      name="empleadoId"
                      value={values.empleadoId}
                      onChange={handleChange}
                    />
                  </div>
                  <div className="form-group">
                    <label htmlFor="txMotivo">Motivo</label>
                    <select
                      type="text"
                      className="form-control"
                      id="txMotivo"
                      name="motivoId"
                      placeholder="Motivo"
                      value={values.motivoId}
                      onChange={handleChange}
                    >
                      {motivos.map((i, k) => (
                        <option key={k} value={i.id}>
                          {i.nombre}
                        </option>
                      ))}
                    </select>
                  </div>
                  <div className="form-group">
                    <label htmlFor="txaDescripcion">Descripción</label>
                    <textarea
                      className="form-control"
                      name="descripcion"
                      id="txaDescripcion"
                      cols="30"
                      rows="5"
                      onChange={handleChange}
                      value={values.descripcion}
                    ></textarea>
                  </div>
                </div>
                <div className="modal-footer">
                  <button
                    type="button"
                    className="btn btn-default"
                    data-dismiss="modal"
                  >
                    Cancelar
                  </button>
                  <button type="submit" className="btn btn-primary">
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

export default Persona;
