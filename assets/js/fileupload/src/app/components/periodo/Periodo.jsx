import React, { useState, useEffect } from "react";
import { Formik, Form, Field } from "formik";
import { ReactSortable } from "react-sortablejs";
import { EvaluacionItemCustom, DatePickerField as DatePicker } from "../common";
import update from "immutability-helper";
import axios from "axios";
import * as Yup from "yup";

const path = window.jQuery("#base_url").attr("data-base-url");
const validationSchema = Yup.object({
  titulo: Yup.string().required("El titulo es requerido."),
  fecha_inicio: Yup.date()
    .typeError("El formato de la fecha inicio no es valido.")
    .required("Por favor indique la fecha inicio."),
  tiempo_evaluacion: Yup.date()
    .typeError("El formato del fecha no es valido.")
    .required("Por favor indique fecha limite de evaluación."),
  dias_previos: Yup.number(),
  tiempo_periodo: Yup.number().required("La periodicidad es requerida"),
  comentario: Yup.string().required("La descripción es requerida")
});


const CustomPeriodo = ({ id }) => {
  const [state, setState] = useState({
    evaluacion_tipo: [],
    puestos: [],
    puestos2:[],
    model: {
      id: 0,
      titulo: "",
      fecha_inicio: "",
      dias_previos: 0,
      tiempo_periodo: 1,
      tipo_periodo: "O",
      comentario: "",
      tiempo_evaluacion: "",
      configuraciones: [],
      puesto_evaluados: [],
      puesto_evaluadores: []
    }
  });
  const [configuracion, setConfiguracion] = useState([]);
  const [competencias, setCompetencia] = useState([]);
  const [evaluaciones, setEvaluaciones] = useState([]);
  const [periodoEvaluacion, setPeriodoEvaluacion] = useState([]);
  const [temp, setTemp] = useState([]);

  const handleChangePuesto = (name, data) => {
    const keyData = [Object.keys(data)[0]];
    let rs = data[Object.keys(data)[0]];
    if (name == "puesto_evaluados") {
      let _newConfigurations = configuracion;

      for (const key in rs) {
        const element = rs[key];
        var _config = _.find(configuracion, it => it.value == element.value);

        if (_config == undefined) {
          _config = element;
          const _ev = _.find(evaluaciones, it => it.id == keyData[0]);
          _config.evaluados = [_ev];
          _newConfigurations.push(_config);
        } else {
          const idx = _.findIndex(_config.evaluados, it => it.id == keyData[0]);
          if (idx == -1) {
            const _ev = _.find(evaluaciones, it => it.id == keyData[0]);
            _config.evaluados.push(_ev);
          }
        }
      }

      if (data.item != undefined) {
        var _tmpConfig = _.find(
          _newConfigurations,
          it => it.value == data.item.value
        );
        _.remove(_tmpConfig.evaluados, it => it.id == keyData[0]);

        if (_tmpConfig.evaluados.length == 0)
          _.remove(_newConfigurations, it => it.value == data.item.value);
      }

      console.log(_newConfigurations);
      setConfiguracion(_newConfigurations);
    } else {
      // setEvaluadores({
      //   ...evaluadores,
      //   [keyData]: rs
      // });
    }
  };
  useEffect(() => {
    axios
      .get(`${path}evaluaciones/get`, {
        params: { tipo: "periodo" }
      })
      .then(response => {
        console.log("Pdata",response.data.data);
        //asigna los datos que trae del contralodaor
        var _evaluaciones = response.data.data.evaluaciones;
        let _evaluacionesTmp = _.clone(_evaluaciones);
        let _competencias = response.data.data.competencia;

        //asinga los puestos que hay en el sistema
        const _ps = response.data.data.puesto.map(i => {
          return { value: i.id, label: i.name, parent: i.parent };
        });

        const _ps2 = response.data.data.puestos2;
        //console.log("ps2",_ps2)

        //asinga los tipos de evaluacion deñ módulo
        var _tipos = _.map(response.data.data.tipos, i => ({
          label: i.nombre,
          value: i.id
        }));

        //id del periodo en casod e que este en edición
        id = _.toNumber(id);
        if (_.isNumber(id) && id > 0) {
          axios
            .get(`${path}periodo/get`, { params: { id: id, full: "" } })
            .then(response => {
              var _mdl = response.data.data;
              let _periodoEvaluacion = [];
              let _puesto_evaluados = [];
              let _puesto_evaluadores = [];
              const oEP = _.maxBy(_mdl.evaluacion_puesto, it =>
                parseInt(it.evaluacion_id)
              );
              const max = parseInt(oEP.evaluacion_id);

              for (let index = 0; index < max; index++) {
                _puesto_evaluados.push(null);
                _puesto_evaluadores.push(null);
              }
              var _eGroup = _.groupBy(
                _mdl.evaluacion_puesto,
                it => it.evaluacion_id
              );

              for (const key in _eGroup) {
                const element = _eGroup[key];
                var _evIt = _.find(_evaluaciones, it => it.id == key);
                _.remove(_evaluacionesTmp, it => it.id == key);
                _periodoEvaluacion.push(_evIt);
                for (const ky in element) {
                  const el = element[ky];
                  const idx = parseInt(key);
                  const ps = _.find(_ps, im => im.value == el.puesto_id);

                  if (el.tipo == "EVALUADO") {
                    if (_puesto_evaluados[idx] == null)
                      _puesto_evaluados[idx] = [];
                    _puesto_evaluados[idx].push(ps);
                  } else {
                    if (_puesto_evaluadores[idx] == null)
                      _puesto_evaluadores[idx] = [];
                    _puesto_evaluadores[idx].push(ps);
                  }
                }
              }

              _mdl.puesto_evaluados = _puesto_evaluados;
              _mdl.puesto_evaluadores = _puesto_evaluadores;

              let _newConfigurations = configuracion;
              var _configuraciones = [];

              var _peGroup = _.groupBy(
                _mdl.evaluacion_competencias,
                it => it.puesto_id
              );

              _.forEach(_peGroup, (it, ky) => {
                var _pepGroup = _.groupBy(it, it => it.evaluacion_id);
                const ps = _.find(_ps, im => im.value == ky);
                ps.evaluados = [];
                if (_configuraciones[ky] == null) _configuraciones[ky] = [];

                _.forEach(_pepGroup, (i, k) => {
                  if (_configuraciones[ky][k] == null)
                    _configuraciones[ky][k] = [];
                  var _cmpt = [];
                  _.forEach(i, _i => {
                    _cmpt[_i.competencias_id] = { grado: _i.grado };
                  });
                  const iep = _.find(
                    _mdl.evaluacion_puesto,
                    iep => iep.evaluacion_id == k
                  );
                  _configuraciones[ky][k] = {
                    porcentaje: iep.valor,
                    competencia: _cmpt
                  };
                  const _ev = _.find(_evaluaciones, it => it.id == k);
                  ps.evaluados.push(_ev);
                });

                _newConfigurations.push(ps);
              });

              _mdl.configuraciones = _configuraciones;
              setPeriodoEvaluacion(_periodoEvaluacion);
              setCompetencia(_competencias);
              setEvaluaciones(_evaluaciones);
              setTemp(_evaluacionesTmp);
              setState({
                ...state,
                puestos: _ps,
                puestos2:_ps2,
                evaluacion_tipo: _tipos,
                model: _mdl
              });
              setConfiguracion(_newConfigurations);
            })
            .catch(err => console.error(err));
        } else {
          setCompetencia(_competencias);
          setEvaluaciones(_evaluaciones);
          setTemp(_evaluaciones);
          setState({
            ...state,
            puestos: _ps,
            puestos2:_ps2,
            evaluacion_tipo: _tipos
          });
        }
      })
      .catch(err =>
        window.toaster.error("Ocurrio un error al recuperar las competencias")
      )
      .finally(() => {});
  }, []);

  const handleInputChange = (e, data) => {
    const { value } = e.target;
    const newTemp = data.filter(item => {
      const text = item.nombre.toUpperCase();
      return text.indexOf(value.toUpperCase()) > -1;
    });
    setTemp(newTemp);
  };
  const removeItem = item => {
    const idx = periodoEvaluacion.findIndex(i => i.id == item.id);
    setPeriodoEvaluacion(update(periodoEvaluacion, { $splice: [[idx, 1]] }));
    setTemp(update(temp, { $push: [item] }));
  };
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
        titulo: state.model.titulo,
        fecha_inicio: state.model.fecha_inicio,
        dias_previos: state.model.dias_previos,
        tiempo_periodo: state.model.tiempo_periodo,
        empleado_id: 0,
        tiempo_evaluacion: state.model.tiempo_evaluacion,
        configuraciones: state.model.configuraciones,
        tipo_periodo: state.model.tipo_periodo,
        puesto_evaluados: state.model.puesto_evaluados,
        puesto_evaluadores: state.model.puesto_evaluadores,
        comentario: state.model.comentario
      }}
      enableReinitialize
      validationSchema={validationSchema}
      onSubmit={(values, actions) => {
        var evaluacion_periodos_puesto = [];
        var evaluacion_competencias = [];

        _.forEach(values.configuraciones, (it, ky) => {
          if (it != undefined) {
            console.log(configuracion);

            var _exst = _.find(configuracion, _t => _t.value == ky);
            if (_exst != undefined) {
              let puesto_id = ky;
              _.forEach(it, (i, k) => {
                if (i != undefined) {
                  let evaluacion_id = k;
                  _.forEach(i.competencia, (_i, _k) => {
                    if (_i != undefined) {
                      let competencias_id = _k;
                      evaluacion_competencias.push({
                        evaluacion_id,
                        puesto_id,
                        competencias_id,
                        grado: _i.grado
                      });
                    }
                  });
                  evaluacion_periodos_puesto.push({
                    puesto_id,
                    evaluacion_id,
                    tipo: "EVALUADO",
                    valor: i.porcentaje
                  });
                }
              });
            }
          }
        });

        _.forEach(values.puesto_evaluadores, (it, ky) => {
          let evaluacion_id = ky;
          _.forEach(it, (i, k) => {
            evaluacion_periodos_puesto.push({
              puesto_id: i.value,
              evaluacion_id,
              tipo: "EVALUADOR",
              valor: 0
            });
          });
        });
        values.evaluacion_competencias = evaluacion_competencias;
        values.evaluacion_periodos_puesto = evaluacion_periodos_puesto;
        values.id = state.model.id;
        console.log("values",values);
        axios
          .post(`${path}periodo/save`, values)
          .then(response => {
            if (response.data.code == "200") {
              window.toastr.success(response.data.message);
              window.setTimeout(
                window.alert,
                2000,
                (window.location = `${path}periodo`)
              );
            } else {
              window.toastr.error(response.data.message);
            }
          })
          .catch(error => console.error(error));
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
        <Form onSubmit={handleSubmit} className="form" autoComplete="off">
          <div className="col-md-12">
            <ul className="nav nav-tabs" role="tablist">
              <li role="presentation" className="active">
                <a data-index="1" href="#home" aria-controls="home" role="tab">
                  General
                </a>
              </li>
              <li role="presentation">
                <a
                  data-index="2"
                  href="#evaluaciones"
                  aria-controls="evaluaciones"
                  role="tab"
                >
                  Evaluación
                </a>
              </li>

              <li role="presentation">
                <a
                  data-index="3"
                  href="#configuracion"
                  aria-controls="configuracion"
                  role="tab"
                >
                  Configuración
                </a>
              </li>
            </ul>

            <div className="tab-content">
              <div role="tabpanel" className="tab-pane active" id="home">
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
                      <Field
                        type="text"
                        className="form-control"
                        id="txTitulo"
                        name="titulo"
                        placeholder="Título"
                        onChange={handleChange}
                      />
                      <span className="help-block">{errors.titulo}</span>
                    </div>
                  </div>
                  <div className="col-md-3">
                    <div
                      className={
                        errors.fecha_inicio
                          ? "form-group has-error"
                          : "form-group"
                      }
                    >
                      <label className="control-label" htmlFor="txFechaInicio">
                        Fecha Inicio *
                      </label>
                      <DatePicker
                        dateFormat="yyyy-MM-dd"
                        className="form-control input-sm"
                        showPopperArrow={true}
                        name="fecha_inicio"
                        id="txFechaInicio"
                        selected={values.fecha_inicio}
                        placeholder="Fecha Inicio"
                        //   disabled={values.fechaInicio != ""}
                        title="Fecha Inicio"
                        autoComplete="off"
                      />
                      <span className="help-block">{errors.fecha_inicio}</span>
                    </div>
                  </div>
                </div>
                <div className="row">
                  <div className="col-md-2">
                    <div
                      className={
                        errors.tiempo_evaluacion
                          ? "form-group has-error"
                          : "form-group"
                      }
                    >
                      <label
                        className="control-label"
                        htmlFor="txTiempoEvaluacion"
                      >
                        Fecha limite 
                      </label>
                      <DatePicker
                        dateFormat="yyyy-MM-dd"
                        className="form-control input-sm"
                        showPopperArrow={true}
                        name="tiempo_evaluacion"
                        id="txTiempoEvaluacion"
                        selected={values.tiempo_evaluacion}
                        placeholder="Tiempo de evaluación"
                        //   disabled={values.fechaInicio != ""}
                        title="Tiempo de evaluación"
                        autoComplete="off"
                      />
                      <span className="help-block">
                        {errors.tiempo_evaluacion}
                      </span>
                    </div>
                  </div>
                  <div className="col-md-2">
                    <div
                      className={
                        errors.dias_previos
                          ? "form-group has-error"
                          : "form-group"
                      }
                    >
                      <label className="control-label" htmlFor="txDiasPrevios">
                        Días previos
                      </label>
                      <Field
                        type="number"
                        pattern="[0-9]*"
                        className="form-control"
                        id="txDiasPrevios"
                        name="dias_previos"
                        placeholder="Dìas previos"
                        onChange={handleChange}
                      />
                      <span className="help-block">{errors.dias_previos}</span>
                    </div>
                  </div>
                  <div className="col-md-3">
                    <div className="form-group">
                      <label
                        className="control-label"
                        htmlFor="cbTiempoPeriodo"
                      >
                        Periodicidad
                      </label>
                      <Field
                        as="select"
                        className="form-control"
                        name="tiempo_periodo"
                        id="cbTiempoPeriodo"
                        onChange={handleChange}
                      >
                        <option value="1">Mensual</option>
                        <option value="2">Bimestral</option>
                        <option value="3">Trimestral</option>
                        <option value="6">Semestral</option>
                        <option value="12">Anual</option>
                      </Field>
                    </div>
                  </div>
                  <div className="col-md-2">
                    <div className="form-group">
                      <label className="control-label" htmlFor="cbTipoPeriodo">
                        Tipo
                      </label>
                      <Field
                        as="select"
                        className="form-control"
                        name="tipo_periodo"
                        id="cbTipoPeriodo"
                        onChange={handleChange}
                      >
                        <option value="O">Ordinaria</option>
                        <option value="E">Extraordinaria</option>
                      </Field>
                    </div>
                  </div>
                </div>
                <div className="row">
                  <div className="col-md-12">
                    <div
                      className={
                        errors.comentario
                          ? "form-group has-error"
                          : "form-group"
                      }
                    >
                      <label className="control-label" htmlFor="txcomentario">
                        Comentario *
                      </label>
                      <Field
                        as="textarea"
                        className="form-control"
                        id="txcomentario"
                        name="comentario"
                        placeholder="Descripción"
                        style={{ height: 120 }}
                        maxLength={255}
                        onChange={handleChange}
                      ></Field>
                      <span className="help-block">{errors.comentario}</span>
                    </div>
                  </div>
                </div>
              </div>
              <div role="tabpanel" className="tab-pane" id="evaluaciones">
                <div className="row">
                  <div className="col-md-3">
                    <section className="">
                      <input
                        type="text"
                        className="form-control"
                        placeholder="Buscar..."
                        onChange={e => handleInputChange(e, competencias)}
                      />
                    </section>
                    <div style={{maxHeight:"60vh", overflow:"auto"}}>
                      <ReactSortable
                        tag="ul"
                        className="cards aside-size "
                        list={temp}
                        style={{ height: "40vh" }}
                        sort={false}
                        setList={setTemp}
                        animation={150}
                        group={{
                          name: "shared-group-name",
                          put: false
                        }}
                      >
                        {temp.map((item, key) => (
                          <EvaluacionItemCustom
                            key={key}
                            item={item}
                          ></EvaluacionItemCustom>
                        ))}
                      </ReactSortable>
                    </div>
                  </div>
                  <div className="col-md-9" /* style={{maxHeight:"60vh", overflow:"auto"}} */>
                    <ReactSortable
                      tag="ul"
                      className="cards card-container"
                      list={periodoEvaluacion}
                      setList={(newList, sortable, store) => {
                        setPeriodoEvaluacion(newList);
                      }}
                      sort={false}
                      animation={150}
                      group="shared-group-name"
                    >
                      {periodoEvaluacion.map((item, key) => (
                        <EvaluacionItemCustom
                          key={key}
                          item={item}
                          removeItem={removeItem}
                          handleChangePuesto={handleChangePuesto}
                          setFieldValue={setFieldValue}
                          puestos={state.puestos}
                          puestos2={state.puestos2}
                          puesto_evaluados={values.puesto_evaluados}
                          puesto_evaluadores={values.puesto_evaluadores}
                        ></EvaluacionItemCustom>
                      ))}
                    </ReactSortable>
                    <span className="help-block">
                      Arrastra las evaluaciones aquí.
                    </span>
                  </div>
                </div>
              </div>
              <div role="tabpanel" className="tab-pane" id="configuracion">
                <div className="tb-periodo">
                  {_.map(configuracion, (psto, ky) => (
                    <div key={ky}>
                      <div>
                        <strong>{psto.label}</strong>
                      </div>
                      <div>
                        {_.map(psto.evaluados, (_ev, k) => (
                          <div className="row" key={k}>
                            <div className="col-md-6">
                              <div className="panel panel-default">
                                <div className="panel-body">
                                  <dl className="dl-horizontal">
                                    <dt>Evaluación</dt>
                                    <dd>{_ev.titulo}</dd>
                                    <dt>Porcentaje</dt>
                                    <dd>
                                      <Field
                                        type="number"
                                        name={`configuraciones.${psto.value}.${_ev.id}.porcentaje`}
                                        onChange={handleChange}
                                        className="form-control input-sm"
                                        placeholder="%"
                                        min="0"
                                        max="100"
                                      />
                                    </dd>
                                  </dl>
                                </div>
                              </div>
                            </div>
                            <div className="col-md-6">
                              <div className="panel panel-default">
                                <div className="panel-body">
                                  <strong>Competencias</strong>
                                  <ul className="list-group">
                                    {_.map(_ev.competencia, (_com, _k) => {
                                      const _compe = _.find(
                                        competencias,
                                        _ci => _com.competencias_id == _ci.id
                                      );
                                      if (_compe == null) return;
                                      return (
                                        <li
                                          key={_k}
                                          className="list-group-item"
                                        >
                                          <div className="row">
                                            <div className="col-md-9">
                                              <small>{_compe.nombre}</small>
                                              <small
                                                style={{ paddingTop: "4px" }}
                                                className="pull-right"
                                              >
                                                Grado requerido
                                              </small>
                                            </div>
                                            <div className="col-md-3">
                                              <Field
                                                  as="select"
                                                  name={`configuraciones.${psto.value}.${_ev.id}.competencia.${_compe.id}.grado`}
                                                  onChange={handleChange}
                                                  className="form-control input-sm"
                                                  required={"required"}
                                                >
                                                  {_compe.Tipo==7?<><option value="">-</option>
                                                  <option value="A">A</option>
                                                  <option value="B">B</option>
                                                  <option value="C">C</option>
                                                  <option value="D">D</option></>:<><option value="">-</option>
                                                  <option value="A">A</option></>}
                                                </Field>
                                            </div>
                                          </div>
                                        </li>
                                      );
                                    })}
                                  </ul>
                                </div>
                              </div>
                            </div>
                          </div>
                        ))}
                      </div>
                    </div>
                  ))}
                </div>
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
          </div>
        </Form>
      )}
    </Formik>
  );
};

export default CustomPeriodo;
