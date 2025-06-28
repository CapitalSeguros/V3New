import React, { useEffect, useState } from "react";
import { Formik } from "formik";
import DatePicker from "../common/DatePickerField.jsx";
import Select from "react-select";
import {stylesSelect} from "../common/stylesSelect.js";


const Form = ({
  mode,
  id,
  type,
  employee,
  start,
  days,
  comment,
  types,
  employees,
  file,
  submit,
  reset
}) => {
  const isEdit = id == undefined ? false : id == -1 ? false : true;
  //const emple=employee.label===undefined?'':employee;
  const [dateOptions, updateOptions] = useState({
    validMinDate: 0,
    startBlock: "",
    daysBlock: 0,
    minDate: null,
    enableValidDate: false
  });
  function displayitemPuesto(id,array){
    const _array=array;
    const newData = _array.filter((item, index) => item.puesto === id);
    return newData;
  }
  var dYear = 0;
  const validVacations = date => {
    if (dateOptions.enableValidDate) {
      var sDate = `${date.getFullYear()}-${dateOptions.startBlock}`;

      const startDate = moment(sDate, "YYYY-MM-DD");
      const endDate = moment(sDate, "YYYY-MM-DD").add(
        dateOptions.daysBlock,
        "day"
      );

      return !moment(date, "YYYY-MM-DD").isBetween(
        startDate,
        endDate,
        null,
        "[]"
      );
    }
    return true;
  };
  useEffect(() => {
    if (mode == "vacaciones") {
      var options = { minDate: null, enableValidDate: false };
      options.minDate = moment()
        .add(dateOptions.validMinDate, "months")
        .toDate();
      options.enableValidDate = true;

      updateOptions({
        ...dateOptions,
        minDate: options.minDate,
        enableValidDate: options.enableValidDate
      });
    }
  }, [mode]);

  useEffect(() => {
    const dvOp = window.jQuery("#vOptions");
    const sBlock = dvOp.attr("data-start-block");

    updateOptions({
      ...dateOptions,
      startBlock: sBlock,
      daysBlock: parseInt(dvOp.attr("data-days-block")),
      validMinDate: dvOp.attr("data-min-date")
    });
  }, []);

  return (
    <Formik
      enableReinitialize
      initialValues={{
        id,
        type,
        employee,
        start,
        days,
        comment,
        file: null,
        puestoF:''
      }}
      onSubmit={(values, actions) => {
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
          <div className="modal-header titulos">
            <h4 className="modal-title" id="exampleModalLabel">
              Agregar nueva incidencia
            </h4>
          </div>
          <div className="modal-body">
            <div className="row">
              <div className="col-sm-4 col-md-4">
                <div className="form-group">
                  <label
                    htmlFor="recipient-name"
                    className="col-form-label titulos"
                  >
                    Seleccione un tipo de incidencia
                  </label>
                  <select
                    name="type"
                    id="type"
                    onChange={value => {
                      handleChange(value);
                      let options = { minDate: null, enableValidDate: false };
                      if (value.currentTarget.value == "1") {
                        options.minDate = moment()
                          .add(dateOptions.validMinDate, "months")
                          .toDate();
                        options.enableValidDate = true;
                      }
                      updateOptions({
                        ...dateOptions,
                        minDate: options.minDate,
                        enableValidDate: options.enableValidDate
                      });
                    }}
                    onBlur={handleBlur}
                    value={values.type}
                    disabled={isEdit}
                    className="form-control input-sm is-invalid"
                  >
                    <option value="">Seleccione una opción</option>
                    {types.map((item, key) => (
                      <option key={key} value={item.id}>
                        {item.nombre}
                      </option>
                    ))}
                  </select>
                </div>
              </div>
              <div className="col-sm-4 col-md-4">
                <div className="form-group">
                  <label
                    htmlFor="recipient-name"
                    className="col-form-label titulos"
                  >
                    Fecha de inicio
                  </label>
                  <DatePicker
                    dateFormat="yyyy-MM-dd"
                    className="form-control input-sm"
                    showPopperArrow={false}
                    name="start"
                    id="start"
                    selected={values.star}
                    placeholder=""
                    disabled={mode == "vacaciones" ? false : isEdit}
                    minDate={dateOptions.minDate}
                    filterDate={validVacations}
                    title="Fecha de Inicio"
                    autoComplete="off"
                  />
                </div>
              </div>
              <div className="col-sm-4 col-md-4">
                <div className="form-group">
                  <label
                    htmlFor="recipient-name"
                    className="col-form-label titulos"
                  >
                    Duración en días
                  </label>
                  <input
                    type="number"
                    name="days"
                    id="days"
                    onChange={handleChange}
                    value={values.days}
                    disabled={mode == "vacaciones" ? false : isEdit}
                    className="form-control input-sm"
                    title="dias"
                    autoComplete="off"
                  />
                </div>
              </div>
            </div>
            <div className="row">
            {!isEdit &&
            <div className="col-sm-4 col-md-4">
                <div className="form-group">
                  <label
                    htmlFor="recipient-name"
                    className="col-form-label titulos"
                  >
                    Seleccione un puesto
                  </label>
                  <Select
                    placeholder="Selecione una opción"
                    isDisabled={isEdit}
                    styles={stylesSelect(250,1,"puesto")}
                    id="puesto"
                    name="puesto"
                    onChange={v => (setFieldValue("puesto", v.value),setFieldValue("puestoF", v),setFieldValue("employee", ''))}
                    onBlur={handleBlur}
                    value={values.puestoF||''}
                    options={_puestos}
                  />
                </div>
              </div>}
              <div className="col-sm-4 col-md-4">
                <div className="form-group">
                  <label
                    htmlFor="recipient-name"
                    className="col-form-label titulos"
                  >
                    Seleccione un empleado
                  </label>
                  <Select
                    placeholder="Selecione una opción"
                    isDisabled={isEdit}
                    styles={stylesSelect(250,1)}
                    id="employee"
                    name="employee"
                    onChange={value => setFieldValue("employee", value)}
                    onBlur={handleBlur}
                    value={values.employee||""}
                    options={displayitemPuesto(values.puesto,employees)}
                  />
                </div>
              </div>
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
                        name="file"
                        id="file"
                        onChange={event => {
                          var filename = event.currentTarget.files[0].name;
                          $("#noFile").text(
                            filename.replace("C:\\fakepath\\", "")
                          );
                          $(".file-upload").addClass("active");
                          setFieldValue("file", event.currentTarget.files);
                        }}
                      />
                    </div>
                  </div>
                </div>
              </div>
            </div>
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
                    id="comment"
                    name="comment"
                    onChange={handleChange}
                    value={values.comment}
                    className="form-control input-sm"
                    placeholder="Escriba Aqui"
                  ></textarea>
                  <p id="contSmsText">
                    Caracteres usados:{" "}
                    {values.comment == null ? 0 : values.comment.length} de 300
                  </p>
                </div>
              </div>
            </div>
          </div>
          <div className="modal-footer">
            <button
              type="button"
              id="close"
              className="btn btn-secondary"
              data-dismiss="modal"
              onClick={()=>reset()}
            >
              Cerrar
            </button>
            <button type="submit" className="btn btn-primary">
              Guardar
            </button>
          </div>
        </form>
      )}
    </Formik>
  );
};
export default Form;
