import React, { useState, useEffect } from "react";
import Select from "react-select";
import { Formik } from "formik";
import axios from "axios";
import { DatePickerField as DatePicker } from "../common";
import {stylesSelect} from "../common/stylesSelect.js";


const path = window.jQuery("#base_url").attr("data-base-url");
const ModalFiltro = ({ actionOpen, start, reference, callBack }) => {
  const periodos = [
    { id: 1, value: "Mensual" },
    { id: 2, value: "Bimestral" },
    { id: 3, value: "Trimestral" },
    { id: 6, value: "Semestral" },
    { id: 12, value: "Anual" }
  ];

  const [state, setState] = useState({
    filter: [],
    filterDefault: [],
    chartName: "",
    chartTitle: "",
    uriFilter: "",
    isMulti: false,
    model: {
      empresa: "",
      puesto: [],
      colaborador: [],
      fecha: "",
      periodo: 0,
      periodos:0
    }
  });
  
useEffect(() => {
    if (actionOpen != "") {
      window.jQuery(document).on("click", actionOpen, function (e) {
        e.preventDefault();
        const _filter = window.jQuery(e.currentTarget).attr("data-filter");
        const charName = window.jQuery(e.currentTarget).attr("data-chart-name");
        const chartTitle = window
          .jQuery(e.currentTarget)
          .attr("data-chart-title");
        const uri = window.jQuery(e.currentTarget).attr("data-uri-filter");
        const _filterDefault = window
          .jQuery(e.currentTarget)
          .attr("data-filter-default");
        const _multi = window.jQuery(e.currentTarget).attr("data-chart-multiple");
        const _atModel = window
          .jQuery(`#graficos_${charName}`)
          .attr("data-chart-filter");
        const _clientes=window.jQuery("#clientes").val();

        var _model = {
          empresa: "",
          puesto: [],
          colaborador: [],
          fecha: new Date(),
          periodo: "0",
          periodos:"0",
          clientes:''
        };

        if (_atModel != undefined) {
          _model = JSON.parse(_atModel);
          _model.fecha = moment(_model.fecha);
        }

        const _FD = _.split(_filterDefault, ",");

        _.forEach(_FD, (i, k) => {
          const ifd = _.split(i, ":");
          if (ifd.length > 1) {
            _model[ifd[0]] = _.isNumber(ifd[1]) ? ifd[1] : parseInt(ifd[1]);
          }
        });

        const filter = _.split(_filter, ",");
        setState({
          chartName: charName,
          filter: filter,
          uriFilter: uri,
          chartTitle: chartTitle,
          isMulti: _multi != undefined ? true : false,
          filterDefault: [],
          model: _model
        });

        document.getElementById("modalModalFoltro").style.width = "280px";
      });
    }
  }, [])

  const handleClose = e => {
    e.preventDefault();
    document.getElementById("modalModalFoltro").style.width = "0px";
  };

  return (
    <div id="modalModalFoltro" className="sidenav">
      <section className="container-fluid">
        <div className="row">
          <div className="col-md-12">
            <h4>
              {" "}
              Filtros
              <a onClick={handleClose}>
                <i className="glyphicon glyphicon-remove pull-right"></i>
              </a>
            </h4>
          </div>
        </div>
        <div className="row">
          <div className="col-md-12">
            <h5> {state.chartTitle}</h5>
          </div>
        </div>
        <Formik
          enableReinitialize
          initialValues={{
            charName: state.chartName,
            empresa: "",
            colaborador: state.model.colaborador,
            puesto: state.model.puesto,
            fecha: state.model.fecha,
            periodo: state.model.periodo,
            periodos: state.model.periodos,
            clientes:state.model.clientes
          }}
          onSubmit={(values, actions) => {
            values.clientes=window.jQuery("#clientes").val()||"";
            axios
              .post(state.uriFilter, values)
              .then(response => {
                values.fecha = moment(values.fecha, "YYYY-MM-DD");
                window
                  .jQuery(`#graficos_${state.chartName}`)
                  .attr("data-chart-filter", JSON.stringify(values));
                document.getElementById("modalModalFoltro").style.width = "0px";
                callBack(state.chartName, response.data.data);
                actions.resetForm();
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
            isSubmitting,
            styles
          }) => (
            <form onSubmit={handleSubmit} className="form">
              <div className="modal-body">
                {_.indexOf(state.filter, "fecha") > -1 ? (
                  <div className="form-group">
                    <label className="control-label" htmlFor="txFechaInicio">
                      Fecha
                    </label>
                    <DatePicker
                      dateFormat="yyyy-MM-dd"
                      className="form-control input-sm"
                      showPopperArrow={true}
                      showMonthYearPicker
                      name="fecha"
                      id="txFecha"
                      selected={values.fecha}
                      placeholder="Fecha"
                      title="Fecha"
                      autoComplete="off"
                    />
                  </div>
                ) : (
                  ""
                )}
                {_.indexOf(state.filter, "empresa") > -1 ? (
                  <div className="form-group">
                    <label className="control-label" htmlFor="cbEmpresa">
                      Empresa
                    </label>
                    <Select
                      placeholder="Selecione la empresa."
                      id="cbEmpresa"
                      styles={stylesSelect(250,1)}
                      //   closeMenuOnSelect={false}
                      onChange={v => {
                        setFieldValue("empresa", v);
                      }}
                      value={values.empresa}
                      // options={[]}
                    />
                  </div>
                ) : (
                  ""
                )}
                {_.indexOf(state.filter, "periodo") > -1 ? (
                  <div className="form-group">
                    <label htmlFor="txMotivo">Periodo</label>
                    <select
                      type="text"
                      className="form-control"
                      id="txPeriodo"
                      name="periodo"
                      placeholder="Periodo"
                      value={values.periodo}
                      onChange={handleChange}
                    >
                      {periodo.map((i, k) => (
                        <option key={k} value={i.id}>
                          {i.value}
                        </option>
                      ))}
                    </select>
                  </div>
                ) : (
                  ""
                )}

                {_.indexOf(state.filter, "puesto") > -1 ? (
                  <div className="form-group">
                    <label className="control-label" htmlFor="cbPuesto">
                      Puesto
                    </label>
                    <Select
                      placeholder="Selecione el puesto."
                      id="cbPuesto"
                      styles={stylesSelect(200,1,"puesto")}
                      //   closeMenuOnSelect={false}
                      onChange={v => {
                        setFieldValue("puesto", v);
                      }}
                      value={values.puesto}
                      options={_puestos2}
                    />
                  </div>
                ) : (
                  ""
                )}
                {_.indexOf(state.filter, "colaborador") > -1 ? (
                  <div className="form-group">
                    <label className="control-label" htmlFor="cbColaborador">
                      Colaborador
                    </label>
                    <Select 
                      placeholder="Selecione el empleado."
                      id="cbColaborador"
                      isMulti={state.isMulti}
                      styles={stylesSelect(250,1)}
                      //   closeMenuOnSelect={false}
                      onChange={v => {
                        setFieldValue("colaborador", v);
                      }}
                      value={values.colaborador}
                      options={_empleados}
                    />
                  </div>
                ) : (
                  ""
                )}
                {_.indexOf(state.filter, "periodos") > -1 ? (
                  <div className="form-group">
                    <label className="control-label" htmlFor="cbPeriodos">
                      Periodos
                    </label>
                    <Select 
                      placeholder="Selecione un periodo."
                      id="cbPeriodos"
                      isMulti={state.isMulti}
                      styles={stylesSelect(250,1)}
                      //   closeMenuOnSelect={false}
                      onChange={v => {
                        setFieldValue("periodos", v);
                      }}
                      value={values.periodos}
                      options={_periodos}
                    />
                  </div>
                ) : (
                  ""
                )}
              </div>
              <div className="modal-footer">
                <button type="submit" className="btn btn-primary">
                  Aplicar
                </button>
              </div>
            </form>
          )}
        </Formik>
      </section>
    </div>
  );
};

export default ModalFiltro;
