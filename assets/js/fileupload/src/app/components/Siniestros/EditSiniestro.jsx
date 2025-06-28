import React, { useState, useEffect } from "react";
import * as Yup from "yup";
import { Formik } from "formik";
import Select from "react-select";

const colourStyles = {
  control: styles => ({
    ...styles,
    backgroundColor: "white",
    borderRadius: "0px",
    minHeight: "34px",
    maxHeight: 50,
    color: '#472380 !important'
  })
};

const colourStyles2 = {
  control: styles => ({
    ...styles,
    backgroundColor: "white",
    borderRadius: "0px",
    minHeight: "34px",
    maxHeight: 50,
    borderColor: '#a94442 !important'
  })
};

const initial = {
  cabina_id: '',
  siniestro_id: '',
  declara_conductor: false,
  certificado: '',
  evento: '',
  sub_evento: '',
  status_id: '',
  ajustador_id: '',
  estado_id: '',
  municipio_id: '',
  ajustador_nombre: '',
  asegurado_nombre: '',
  tipo_siniestro_id: '',
  causa_siniestro_id: '',
  autoridad_id: '',
  responsable_autoridad: '',
  responsable_ajustador: '',
  atencion_lugar: false,
  fecha_repote: '',
  fecha_ocurrencia: '',
  inicio_ajuste: '',
  fin_ajuste: '',
  cita: '',
  poliza: '',
  paquete_poliza_id: 0,
  paquete_descripcion: '',
  aseguradora_id: '',
  cliente_id: '',
}

const validationSchema = Yup.object({
  cabina_id: Yup.number("Ingrese una valor ")
    .typeError('El campo debe ser un número'),
  siniestro_id: Yup.number("Ingrese una valor ")
    .required("Es requerido.")
    .nullable("Seleccione una fecha valida")
    .typeError('El campo debe ser un número'),
  declara_conductor: Yup.boolean("Ingrese un valor ")
    .required("Es requerido.")
    .typeError('El campo debe ser True o false'),
  certificado: Yup.number("Ingrese una valor ")
    .required("Es requerido.")
    .typeError('El campo debe ser un número'),
  evento: Yup.string("Ingrese un evento valido")
    .required("Es requerido.")
    .typeError('El campo debe ser texto'),
  sub_evento: Yup.string("Ingrese un sub-evento ")
    .required("Es requerido.")
    .typeError('El campo debe ser un número'),
  status_id: Yup.string("Ingrese un valor ")
    .required("Es requerido.")
    .typeError('El campo debe ser un número'),
  ajustador_id: Yup.number("Ingrese un valor ")
    .required("Es requerido.")
    .typeError('El campo debe ser un número'),
  estado_id: Yup.number("Ingrese un valor valido")
    .required("Es requerido.")
    .typeError('El campo debe ser un número'),
  municipio_id: Yup.number("Ingrese un valor ")
    .required("Es requerido.")
    .typeError('El campo debe ser un número'),
  ajustador_nombre: Yup.string("Ingrese una valor")
    .required("Es requerido.")
    .typeError('El campo debe ser texto'),
  asegurado_nombre: Yup.string("Ingrese un valor")
    .required("Es requerido.")
    .typeError('El campo debe ser texto'),
  tipo_siniestro_id: Yup.number("Ingrese un valor")
    .required("Es requerido."),
  causa_siniestro_id: Yup.number("Ingrese un valor")
    .required("Es requerido.")
    .typeError('El campo debe ser un número'),
  autoridad_id: Yup.number("Ingrese un valor")
    .required("Es requerido.")
    .typeError('El campo debe ser un número'),
  responsable_autoridad: Yup.number("Ingrese un valor ")
    .required("Es requerido.")
    .typeError('El campo debe ser un número'),
  responsable_ajustador: Yup.number("Ingrese un valor")
    .required("Es requerido.")
    .typeError('El campo debe ser un número'),
  atencion_lugar: Yup.boolean("Ingrese un valor")
    .required("Es requerido.")
    .typeError('El campo debe ser True o false'),
  fecha_repote: Yup.date("Ingrese una fecha valida")
    .required("Es requerido.")
    .typeError('El campo debe ser una fecha'),
  fecha_ocurrencia: Yup.date("Ingrese una fecha valida")
    .required("Es requerido.")
    .typeError('El campo debe ser una fecha'),
  inicio_ajuste: Yup.date("Ingrese una fecha valida")
    .required("Es requerido.")
    .typeError('El campo debe ser una fecha'),
  fin_ajuste: Yup.date("Ingrese una fecha valida")
    .required("Es requerido.")
    .min(Yup.ref("inicio_ajuste"), "Debe de ser mayor a inicio ajuste")
    .typeError('El campo debe ser una fecha'),
  cita: Yup.date("Ingrese una fecha valida")
    .required("Es requerido.")
    .typeError('El campo debe ser una fecha'),
  poliza: Yup.number("Ingrese un valor ")
    .required("Es requerido.")
    .typeError('El campo debe ser un número'),
  paquete_poliza_id: Yup.number("Ingrese un valor ")
    .required("Es requerido.")
    .typeError('El campo debe ser un número'),
  paquete_descripcion: Yup.string("Ingrese una fecha")
    .typeError('El campo debe ser un número')
    .required("Es requerido."),
  aseguradora_id: Yup.number("Ingrese un valor ")
    .required("Es requerido.")
    .typeError('El campo debe ser un número'),
  cliente_id: Yup.number("Ingrese un valor ")
    .required("Es requerido.")
    .typeError('El campo debe ser un número')

});

//metodo para dar formato a las fechas
function formatDate(date) {
  var current_datetime = new Date(date);
  var d = current_datetime.getDate();
  var m = current_datetime.getMonth() + 1;
  var y = current_datetime.getFullYear();
  var Hr = current_datetime.getHours();
  var min = current_datetime.getMinutes();
  return '' + y + '-' + (m <= 9 ? '0' + m : m) + '-' + (d <= 9 ? '0' + d : d) + " " + (Hr <= 9 ? '0' + Hr : Hr) + ":" + (min <= 9 ? '0' + min : min);
}

function clickinput(input) {
  console.log("elemento", input);
  window.jQuery(`#${input}`).focus();
}

export function displayitemC(id, array) {
  const _array = array;
  const newData = _array.filter((item, index) => item.aseguradora === id);
  const r = mapitems(newData);
  return r;
}

function mapitems(respuesta) {
  const _ps = respuesta.map(i => {
    return { value: i.id, label: i.nombre };
  });
  return _ps;
}
function mapitemsCausa(respuesta, idpadre) {
  const nuevo = respuesta;
  const itemspadre = nuevo.filter((item, index) => item.tipo_siniestro_id === idpadre);
  const _ps = itemspadre.map(i => {
    return { value: i.id, label: i.nombre };
  });
  return _ps;
}

function displayitem(id, array) {
  const _array = array;
  const newData = _array.filter((item, index) => item.id === id);
  const r = mapitems(newData);
  return r;
}
function displayitemCausa(id, idPadre, array) {
  const _array = array;
  const alltipo = _array.filter((item, index) => item.tipo_siniestro_id === idPadre);
  const newData = alltipo.filter((item, index) => item.id === id);
  const r = mapitems(newData);
  return r;
}


const EditSiniestro = ({ data, Titulo, postEdit, Accion }) => {
  return (
    <>
      <div className="modal-header">
        <button type="button" className="close" data-dismiss="modal"><span style={{ color: "white" }}>&times;</span></button>
        <h5 className="modal-title">{Titulo}</h5>
      </div>
      <Formik
        initialValues={Accion == "2" ? data : initial}
        validationSchema={validationSchema}
        enableReinitialize="true"
        onSubmit={(values, actions) => {
          //console.log("values",values);
          postEdit(values, actions);
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
          resetForm,
          touched
        }) =>
          <form onSubmit={handleSubmit} autoComplete="off">
            <div className="modal-body">
              <dl className="row">
                <div className="col-md-12">
                  <strong>
                    <span className="fa fa-info-circle" aria-hidden="true"></span>
                    INFORMACIÓN DEL REGISTRO SELECCIONADO
                  </strong>
                </div>
              </dl>
              <dl className="row edit" style={{ fontSize: 12 }}>
                <dt className={errors.aseguradora_id && touched.aseguradora_id ? "col-sm-2 text-right erorrT" : "col-sm-2 text-right"}>Aseguradora:</dt>
                <dd className={errors.aseguradora_id && touched.aseguradora_id ? "col-sm-4 erorrI" : "col-sm-4"}>
                  <Select
                    placeholder="Selecione una opción"
                    id="aseguradora_id"
                    name="aseguradora_id"
                    styles={errors.aseguradora_id ? colourStyles2 : colourStyles}
                    onChange={v => { setFieldValue("aseguradora_id", v.value), setFieldValue("cliente_id", '') }}
                    onBlur={handleBlur}
                    value={displayitem(values.aseguradora_id, _Aseg)}
                    options={mapitems(_Aseg)}
                    noOptionsMessage={() => "Sin opciones"}
                  />
                  {/*  <input onChange={handleChange} type="text" value={values.responsable_ajustador} name="responsable_ajustador" className="form-control input-sm" data-toggle="tooltip" data-placement="bottom" title={errors.responsable_ajustador}/> */}
                </dd>
                <dt className={errors.cliente_id && touched.cliente_id ? "col-sm-2 text-right erorrT" : "col-sm-2 text-right"}>Cliente:</dt>
                <dd className={errors.cliente_id && touched.cliente_id ? "col-sm-4 erorrI" : "col-sm-4"}>
                  <Select
                    placeholder="Selecione una opción"
                    id="cliente_id"
                    name="cliente_id"
                    styles={errors.cliente_id && touched.cliente_id ? colourStyles2 : colourStyles}
                    onChange={v => { setFieldValue("cliente_id", v.value) }}
                    onBlur={handleBlur}
                    value={displayitem(values.cliente_id, _clienteT)}
                    options={displayitemC(values.aseguradora_id, _clienteT)}
                    noOptionsMessage={() => "Sin opciones"}
                  />
                  {/*  <input onChange={handleChange} type="text" value={values.responsable_ajustador} name="responsable_ajustador" className="form-control input-sm" data-toggle="tooltip" data-placement="bottom" title={errors.responsable_ajustador}/> */}
                </dd>
                {/* <dt className={errors.cabina_id ? "col-sm-2 text-right erorrT" : "col-sm-2 text-right"}>N.º reporte:</dt>
                <dd className={errors.cabina_id ? "col-sm-10 erorrI" : "col-sm-10"}><input disabled={Accion=="3"?false:true} onChange={handleChange} type="text" name="cabina_id" id="cabina_id" value={values.cabina_id||''} className="form-control input-sm col-M2" data-toggle="tooltip" data-placement="bottom" title={errors.cabina_id}/></dd><br/> */}
                <dt className={errors.siniestro_id && touched.siniestro_id ? "col-sm-2 text-right erorrT" : "col-sm-2 text-right"}>N.º siniestro:</dt>
                <dd className={errors.siniestro_id && touched.siniestro_id ? "col-sm-2 erorrI" : "col-sm-2"}><input disabled={Accion == "3" ? false : true} onChange={handleChange} type="text" value={values.siniestro_id || ''} name="siniestro_id" className="form-control input-sm" data-toggle="tooltip" data-placement="bottom" title={errors.siniestro_id} /></dd>
                <dt className={errors.declara_conductor && touched.declara_conductor ? "col-sm-2 text-right erorrT" : "col-sm-2 text-right"}>Declaración:</dt>
                <dd className={errors.declara_conductor && touched.declara_conductor ? "col-sm-2 erorrI" : "col-sm-2"}><input onChange={() => setFieldValue('declara_conductor', !values.declara_conductor)} type="checkbox" name="declara_conductor" checked={values.declara_conductor == "1" || values.declara_conductor == true ? true : false} value={values.declara_conductor} data-toggle="tooltip" data-placement="bottom" title={errors.declara_conductor} /></dd>
                <dt className={errors.certificado && touched.certificado ? "col-sm-2 text-right erorrT" : "col-sm-2 text-right"}>Certificado:</dt>
                <dd className={errors.certificado && touched.certificado ? "col-sm-2 erorrI" : "col-sm-2"}><input disabled={Accion == "3" ? false : true} onChange={handleChange} type="text" value={values.certificado || ''} name="certificado" className="form-control input-sm" data-toggle="tooltip" data-placement="bottom" title={errors.certificado} /></dd>
                <dt className={errors.ajustador_id && touched.ajustador_id ? "col-sm-2 text-right erorrT" : "col-sm-2 text-right"}>Ajustador clave:</dt>
                <dd className={errors.ajustador_id && touched.ajustador_id ? "col-sm-2 erorrI" : "col-sm-2"}><input disabled={Accion == "3" ? false : true} onChange={handleChange} type="text" value={values.ajustador_id || ''} name="ajustador_id" className="form-control input-sm" data-toggle="tooltip" data-placement="bottom" title={errors.ajustador_id} /></dd>
                <dt className={errors.evento && touched.evento ? "col-sm-2 text-right erorrT" : "col-sm-2 text-right"}>Evento:</dt>
                <dd className={errors.evento && touched.evento ? "col-sm-2 erorrI" : "col-sm-2"}><input onChange={handleChange} type="text" value={values.evento || ''} name="evento" className="form-control input-sm" data-toggle="tooltip" data-placement="bottom" title={errors.evento} /></dd>
                <dt className={errors.sub_evento && touched.sub_evento ? "col-sm-2 text-right erorrT" : "col-sm-2 text-right"}>Sub evento:</dt>
                <dd className={errors.sub_evento && touched.sub_evento ? "col-sm-2 erorrI" : "col-sm-2"}><input onChange={handleChange} type="text" value={values.sub_evento || ''} name="sub_evento" className="form-control input-sm col-M2" data-toggle="tooltip" data-placement="bottom" title={errors.sub_evento} /></dd>
                <dt className={errors.ajustador_nombre && touched.ajustador_nombre ? "col-sm-2 text-right erorrT" : "col-sm-2 text-right"}>Nombre ajustador:</dt>
                <dd className={errors.ajustador_nombre && touched.ajustador_nombre ? "col-sm-10 erorrI" : "col-sm-10"}><input onChange={handleChange} type="text" value={values.ajustador_nombre || ''} name="ajustador_nombre" className="form-control input-sm" data-toggle="tooltip" data-placement="bottom" title={errors.ajustador_nombre} /></dd>
                <dt className={errors.asegurado_nombre && touched.asegurado_nombre ? "col-sm-2 text-right erorrT" : "col-sm-2 text-right"}>Asegurado:</dt>
                <dd className={errors.asegurado_nombre && touched.asegurado_nombre ? "col-sm-10 erorrI" : "col-sm-10"}><input onChange={handleChange} type="text" value={values.asegurado_nombre || ''} name="asegurado_nombre" className="form-control input-sm" data-toggle="tooltip" data-placement="bottom" title={errors.asegurado_nombre} /></dd><br />
                <dt className={errors.status_id && touched.status_id ? "col-sm-2 text-right erorrT" : "col-sm-2 text-right"}>Estatus:</dt>
                <dd className={errors.status_id && touched.status_id ? "col-sm-10 erorrI" : "col-sm-10"}>
                  <Select
                    placeholder="Selecione una opción"
                    id="status_id"
                    name="status_id"
                    styles={errors.status_id && touched.status_id ? colourStyles2 : colourStyles}
                    onChange={v => { setFieldValue("status_id", v.value) }}
                    onBlur={handleBlur}
                    value={displayitem(values.status_id, _estatus)}
                    options={mapitems(_estatus)}
                    noOptionsMessage={() => "Sin opciones"}
                  />
                  {/* <input onChange={handleChange} type="text" value={values.status_id} name="status_id" className="form-control input-sm" data-toggle="tooltip" data-placement="bottom" title={errors.status_id}/> */}
                </dd>
                <dt className={errors.estado_id && touched.estado_id ? "col-sm-2 text-right erorrT" : "col-sm-2 text-right"}>Estado:</dt>
                <dd className={errors.estado_id && touched.estado_id ? "col-sm-4 erorrI" : "col-sm-4"}>
                  <Select
                    placeholder="Selecione una opción"
                    id="estado_id"
                    name="estado_id"
                    styles={errors.estado_id && touched.estado_id ? colourStyles2 : colourStyles}
                    onChange={v => { setFieldValue("estado_id", v.value), setFieldValue("municipio_id", '') }}
                    onBlur={handleBlur}
                    value={displayitem(values.estado_id, _estados)}
                    options={mapitems(_estados)}
                    noOptionsMessage={() => "Sin opciones"}
                  />
                  {/* <input onChange={handleChange} type="text" value={values.estado_id} name="estado_id" className="form-control input-sm " data-toggle="tooltip" data-placement="bottom" title={errors.estado_id}/> */}
                </dd>
                <dt className={errors.municipio_id && touched.municipio_id ? "col-sm-2 text-right erorrT" : "col-sm-2 text-right"}>Municipio:</dt>
                <dd className={errors.municipio_id && touched.municipio_id ? "col-sm-4 erorrI" : "col-sm-4"}>
                  <Select
                    placeholder="Selecione una opción"
                    id="municipio_id"
                    name="municipio_id"
                    styles={errors.municipio_id && touched.municipio_id ? colourStyles2 : colourStyles}
                    onChange={v => { setFieldValue("municipio_id", v.value) }}
                    onBlur={handleBlur}
                    value={displayitem(values.municipio_id, _mun)}
                    options={mapitems(_mun)}
                    noOptionsMessage={() => "Sin opciones"}
                  />
                  {/*  <input onChange={handleChange} type="text" value={values.municipio_id} name="municipio_id" className="form-control input-sm" data-toggle="tooltip" data-placement="bottom" title={errors.municipio_id}/> */}
                </dd>
                <br /><br /><br />
                <dt className="col-sm-12 text-left">INFORME DEL AJUSTADOR</dt>
                <dt className={errors.tipo_siniestro_id && touched.tipo_siniestro_id ? "col-sm-2 text-right erorrT" : "col-sm-2 text-right"}>Tipo siniestro:</dt>
                <dd className={errors.tipo_siniestro_id && touched.tipo_siniestro_id ? "col-sm-4 erorrI" : "col-sm-4"}>
                  <Select
                    placeholder="Selecione una opción"
                    id="tipo_siniestro_id"
                    name="tipo_siniestro_id"
                    styles={errors.tipo_siniestro_id && touched.tipo_siniestro_id ? colourStyles2 : colourStyles}
                    onChange={v => { setFieldValue("tipo_siniestro_id", v.value), setFieldValue("causa_siniestro_id", '') }}
                    onBlur={handleBlur}
                    value={displayitem(values.tipo_siniestro_id, _siniestroT)}
                    options={mapitems(_siniestroT)}
                    noOptionsMessage={() => "Sin opciones"}
                  />
                  {/* <input onChange={handleChange}  type="text" value={values.tipo_siniestro_id} name="tipo_siniestro_id" className="form-control input-sm" data-toggle="tooltip" data-placement="bottom" title={errors.tipo_siniestro_id}/> */}
                </dd>
                <dt className={errors.causa_siniestro_id && touched.causa_siniestro_id ? "col-sm-2 text-right erorrT" : "col-sm-2 text-right"}>Causa siniestro:</dt>
                <dd className={errors.causa_siniestro_id && touched.causa_siniestro_id ? "col-sm-4 erorrI" : "col-sm-4"}>
                  <Select
                    placeholder="Selecione una opción"
                    id="causa_siniestro_id"
                    name="causa_siniestro_id"
                    styles={errors.causa_siniestro_id && touched.causa_siniestro_id ? colourStyles2 : colourStyles}
                    onChange={v => { setFieldValue("causa_siniestro_id", v.value) }}
                    onBlur={handleBlur}
                    value={displayitemCausa(values.causa_siniestro_id, values.tipo_siniestro_id, _causaS)}
                    options={mapitemsCausa(_causaS, values.tipo_siniestro_id)}
                    noOptionsMessage={() => "Sin opciones"}
                  />
                  {/*  <input onChange={handleChange}  type="text" value={values.causa_siniestro_id} name="causa_siniestro_id" className="form-control input-sm" data-toggle="tooltip" data-placement="bottom" title={errors.causa_siniestro_id}/> */}
                </dd>
                <dt className={errors.autoridad_id && touched.autoridad_id ? "col-sm-2 text-right erorrT" : "col-sm-2 text-right"}>Autoridad presente:</dt>
                <dd className={errors.autoridad_id && touched.autoridad_id ? "col-sm-4 erorrI" : "col-sm-4"}>
                  <Select
                    placeholder="Selecione una opción"
                    id="autoridad_id"
                    name="autoridad_id"
                    styles={errors.autoridad_id && touched.autoridad_id ? colourStyles2 : colourStyles}
                    onChange={v => { setFieldValue("autoridad_id", v.value) }}
                    onBlur={handleBlur}
                    value={displayitem(values.autoridad_id, _autoridadS)}
                    options={mapitems(_autoridadS)}
                    noOptionsMessage={() => "Sin opciones"}
                  />
                  {/* <input onChange={handleChange}  type="text" value={values.autoridad_id} name="autoridad_id" className="form-control input-sm" data-toggle="tooltip" data-placement="bottom" title={errors.autoridad_id}/> */}
                </dd>
                <dt className={errors.responsable_ajustador && touched.responsable_ajustador ? "col-sm-2 text-right erorrT" : "col-sm-2 text-right"}>Tipo ajustador:</dt>
                <dd className={errors.responsable_ajustador && touched.responsable_ajustador ? "col-sm-4 erorrI" : "col-sm-4"}>
                  <Select
                    placeholder="Selecione una opción"
                    id="responsable_ajustador"
                    name="responsable_ajustador"
                    styles={errors.responsable_ajustador && touched.responsable_ajustador ? colourStyles2 : colourStyles}
                    onChange={v => { setFieldValue("responsable_ajustador", v.value) }}
                    onBlur={handleBlur}
                    value={displayitem(values.responsable_ajustador, _segunS)}
                    options={mapitems(_segunS)}
                    noOptionsMessage={() => "Sin opciones"}
                  />
                  {/*  <input onChange={handleChange} type="text" value={values.responsable_ajustador} name="responsable_ajustador" className="form-control input-sm" data-toggle="tooltip" data-placement="bottom" title={errors.responsable_ajustador}/> */}
                </dd>
                <dt className={errors.responsable_autoridad && touched.responsable_autoridad ? "col-sm-2 text-right erorrT" : "col-sm-2 text-right"}>Tipo autoridad:</dt>
                <dd className={errors.responsable_autoridad && touched.responsable_autoridad ? "col-sm-4 erorrI" : "col-sm-4"}>
                  <Select
                    placeholder="Selecione una opción"
                    id="responsable_autoridad"
                    name="responsable_autoridad"
                    styles={errors.responsable_autoridad && touched.responsable_autoridad ? colourStyles2 : colourStyles}
                    onChange={v => { setFieldValue("responsable_autoridad", v.value) }}
                    onBlur={handleBlur}
                    value={displayitem(values.responsable_autoridad, _segunS)}
                    options={mapitems(_segunS)}
                    noOptionsMessage={() => "Sin opciones"}
                  />
                  {/* <input onChange={handleChange} type="text" value={values.responsable_autoridad} name="responsable_autoridad" className="form-control input-sm" data-toggle="tooltip" data-placement="bottom" title={errors.responsable_autoridad}/> */}
                </dd>
                <dt className={errors.atencion_lugar && touched.atencion_lugar ? "col-sm-2 text-right erorrT" : "col-sm-2 text-right"}>Atencion en lugar:</dt>
                <dd className={errors.atencion_lugar && touched.atencion_lugar ? "col-sm-4 erorrI" : "col-sm-4"}><input onChange={() => setFieldValue('atencion_lugar', !values.atencion_lugar)} checked={values.atencion_lugar == "1" || values.atencion_lugar == true ? true : false} type="checkbox" name="atencion_lugar" value={values.atencion_lugar} data-toggle="tooltip" data-placement="bottom" title={errors.atencion_lugar} /></dd>
                <dt className="col-sm-12 text-left">FECHA DEL REPORTE</dt>
                <dt className={errors.fecha_repote && touched.fecha_repote ? "col-sm-2 text-right erorrT" : "col-sm-2 text-right"}>Reporte:</dt>
                <dd className={errors.fecha_repote && touched.fecha_repote ? "col-sm-4 erorrI" : "col-sm-4"}><input data-date={values.fecha_repote == "" || values.fecha_repote == null ? '' : moment(values.fecha_repote).format("YYYY-MM-DD HH:mm")} onChange={handleChange} type="datetime-local" value={values.fecha_repote == "" || values.fecha_repote == null ? '' : moment(values.fecha_repote).format("YYYY-MM-DDTHH:mm")} name="fecha_repote" className="form-control input-sm ls" data-toggle="tooltip" data-placement="bottom" title={errors.fecha_repote} /></dd>
                <dt className={errors.fecha_ocurrencia && touched.fecha_ocurrencia ? "col-sm-2 text-right erorrT" : "col-sm-2 text-right"}>Ocurrencia:</dt>
                <dd className={errors.fecha_ocurrencia && touched.fecha_ocurrencia ? "col-sm-4 erorrI" : "col-sm-4"}><input data-date={values.fecha_ocurrencia == "" || values.fecha_ocurrencia == null ? '' : moment(values.fecha_ocurrencia).format("YYYY-MM-DD HH:mm")} onChange={handleChange} type="datetime-local" value={moment(values.fecha_ocurrencia).format("YYYY-MM-DDTHH:mm")} name="fecha_ocurrencia" className="form-control input-sm ls" data-toggle="tooltip" data-placement="bottom" title={errors.fecha_ocurrencia} /></dd>
                <dt className={errors.inicio_ajuste && touched.inicio_ajuste ? "col-sm-2 text-right erorrT" : "col-sm-2 text-right"}>Inicio ajuste:</dt>
                <dd className={errors.inicio_ajuste && touched.inicio_ajuste ? "col-sm-4 erorrI" : "col-sm-4"}><input data-date={values.inicio_ajuste == "" || values.inicio_ajuste == null ? '' : moment(values.inicio_ajuste).format("YYYY-MM-DD HH:mm")} onChange={handleChange} type="datetime-local" value={moment(values.inicio_ajuste).format("YYYY-MM-DDTHH:mm")} name="inicio_ajuste" className="form-control input-sm ls" data-toggle="tooltip" data-placement="bottom" title={errors.inicio_ajuste} /></dd>
                <dt className={errors.fin_ajuste && touched.fin_ajuste ? "col-sm-2 text-right erorrT" : "col-sm-2 text-right"}>Fin ajuste:</dt>
                <dd className={errors.fin_ajuste && touched.fin_ajuste ? "col-sm-4 erorrI" : "col-sm-4"}><input data-date={values.fin_ajuste == "" || values.fin_ajuste == null ? '' : moment(values.fin_ajuste).format("YYYY-MM-DD HH:mm")} onChange={handleChange} type="datetime-local" value={moment(values.fin_ajuste).format("YYYY-MM-DDTHH:mm")} name="fin_ajuste" className="form-control input-sm ls" data-toggle="tooltip" data-placement="bottom" title={errors.fin_ajuste} /></dd><br /><br /><br />
                <dt className={errors.cita && touched.cita ? "col-sm-2 text-right erorrT" : "col-sm-2 text-right"}>Cita:</dt>
                <dd className={errors.cita && touched.cita ? "col-sm-10 erorrI col-M2" : "col-sm-10 col-M2"}><input data-date={values.cita == "" || values.cita == null ? '' : moment(values.cita).format("YYYY-MM-DD HH:mm")} onChange={handleChange} type="datetime-local" value={values.cita == "" || values.cita == null ? '' : moment(values.cita).format("YYYY-MM-DDTHH:mm")} name="cita" className="form-control input-sm datetimeI ls" data-toggle="tooltip" data-placement="bottom" title={errors.cita} /></dd><br />
                <dt className="col-sm-12 text-left">INFORMACIÓN DE LA PÓLIZA</dt>
                <dt className={errors.poliza && touched.poliza ? "col-sm-2 text-right erorrT" : "col-sm-2 text-right"}>Póliza:</dt>
                <dd className={errors.poliza && touched.poliza ? "col-sm-10 erorrI" : "col-sm-10"}><input disabled={Accion == "3" ? false : true} onChange={handleChange} type="text" value={values.poliza} name="poliza" className="form-control input-sm col-M2" data-toggle="tooltip" data-placement="bottom" title={errors.poliza} /></dd>
                <dt className={errors.paquete_descripcion && touched.paquete_descripcion ? "col-sm-2 text-right erorrT" : "col-sm-2 text-right"}>Paquete:</dt>
                <dd className={errors.paquete_descripcion && touched.paquete_descripcion ? "col-sm-10 erorrI" : "col-sm-10"}><input onChange={handleChange} type="text" value={values.paquete_descripcion} name="paquete_descripcion" className="form-control input-sm" data-toggle="tooltip" data-placement="bottom" title={errors.paquete_descripcion} /></dd>
                {/*  <dd className="col-sm-12 text-right">
                  <div className="btn btn-primary" onClick={()=>console.log(values)}>check</div>
                  <button type="submit" className="btn btn-primary">Guardar</button>
                </dd> */}

              </dl>
            </div>
            <div className="modal-footer">
              {/* <div className="btn" onClick={()=>console.log(values)}>value</div> */}
              <div className="btn btn-secondary" style={{ backgroundColor: "#e8e8e8" }} data-dismiss="modal">Cerrar</div>
              <button type="submit" className="btn btn-primary">Guardar</button>
            </div>
          </form>}
      </Formik>
    </>
  );
};

export default EditSiniestro;
