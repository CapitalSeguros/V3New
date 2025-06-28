import React, { useState, useEffect } from "react";
import axios from "axios";
import Select from "react-select";
import { Formik } from "formik";

function Captura(props) {
    const path = window.jQuery("#base_url").attr("data-base-url");
    const Id = window.jQuery("#idRegistro").val();
    const { callback, UrlServicio, UrlPagina } = props;


    const [state, setState] = useState({
        InitialData: {
            Monedas: [],
            TipoDocumento: [],
            Grupo: [],
            SubGrupo: [],
            FormaPago: [],
            Ejecutivos: [],
            Vendedores: [],
            Companias: [],
            Agentes: [],
            Estatus: [],
            EstatusCobro: [],
            EstatusDoc: [],
            ConductoCobro: [],
            LineaNegocio: [],
            TipoDocumento: [],
            TipoPago: [],
            TipoVenta: [],
            Gerencias: [],
            SubRamo: []

        },
        selected: { value: "", label: "" },
    });
    const [evaluadores, setEvaluad] = useState([]);
    const [ordenTrabajo, SetordenTrabajo] = useState({
        OT: {},
        Usuario: {}
    });

    function mapitems(respuesta, Tipo) {
        const _ps = respuesta.map(i => {
            var obj = {};
            switch (Tipo) {
                default:
                    obj = { value: i.Id, label: i.Nombre };
                    break;
            }
            return obj;
        });
        return _ps;
    }

    function mapitemsHijos(respuesta, IdPadre) {
        const nuevo = respuesta;
        const itemspadre = nuevo.filter((item, index) => parseInt(item.IdPadre) === parseInt(IdPadre));
        const _ps = itemspadre.map(i => {
            return { value: i.Id, label: i.Nombre };
        });
        return _ps;
    }

    //useEffect
    useEffect(() => {
        InitialData();
        InitialDataRegistro();
    }, []);

    function displayitem(Id, array,) {
        //console.log("id",Id)
        const _array = array;
        var rArray = [];
        const newData = _array.filter((item, index) => parseInt(item.Id) === parseInt(Id));
        //console.log("NewData", newData);
        newData.forEach(element => {
            rArray.push({ value: element.Id, label: element.Nombre });
        });
        return rArray;
    }

    //Obtner initial data
    function InitialData() {
        //console.log("url Api --->",UrlServicio);
        axios
            .get(`${UrlServicio}capture/getInitialData`, null)
            .then(function (response) {
                setState({
                    ...state,
                    InitialData: response.data.Datos
                })
                console.log(response);
            });
    }

    function InitialDataRegistro() {
        //console.log("url Api --->",UrlServicio);
        axios
            .get(`${UrlServicio}capture/singleot?Id=${Id}`, { id: Id })
            .then(function (response) {
                SetordenTrabajo({
                    ...state,
                    OT: response.data.Datos.OT,
                    Usuario: response.data.Datos.Usuario
                });
                console.log("OTINICIAL", response);
            });
    }

    function SaveData(data) {
        var dta = {
            "data": data,
            "Id": Id
        };
        axios
            .post(`${UrlServicio}capture/saveot`, dta)
            .then(function (response) {
                //console.log(response);
                toastr.success("Exíto");
                //console.log(path)
                window.location = path + 'servicioSistema/OrdenTrabajo';
            })
            .catch(error => {
                toastr.error("Error, intente mas tarde.");
            });
    }

    function test() {
        console.log(ordenTrabajo);
    }

    function OpenAction(Accion) {
        window.open(`${UrlPagina}servicioSistema/AccionPestana/${Id}/${Accion}`, 'newwindow', 'toolbar=no,menubar=no,scrollbars=yes,dialog=yes,resizable=no,width=400,height=450'); return false;
    }


    //Estilos
    const colourStyles = {
        control: styles => ({
            ...styles,
            backgroundColor: "white",
            borderRadius: "0px",
            minHeight: "30px",
            maxHeight: 30,
            color: '#472380 !important'
        })
    };

    const colourStyles2 = {
        control: styles => ({
            ...styles,
            backgroundColor: "white",
            borderRadius: "0px",
            minHeight: "30px",
            maxHeight: 30,
            borderColor: '#a94442 !important'
        })
    };



    return (
        <Formik
            initialValues={ordenTrabajo.OT}
            enableReinitialize="true"
            //validationSchema={validationSchema}
            onSubmit={(values, actions) => {
                //submit(values, actions);
                //console.log("elementos",JSON.stringify(values));
                SaveData(values);
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
                <form onSubmit={handleSubmit} className="form" autoComplete="off">
                    <div className="row">
                        <div className="col-md-12 btn-row">
                            <a className="btn btn-primary btn-s" onClick={() => OpenAction("DOCUMENT")} data-toggle="tooltip" data-placement="bottom" title="Documentos"><i className="fa fa-folder-open" aria-hidden="true"></i></a>
                            <a className="btn btn-primary btn-s" onClick={() => OpenAction("BITACORA")} data-toggle="tooltip" data-placement="bottom" title="Bitacora"><i className="fa fa-file-text-o" aria-hidden="true"></i></a>
                            <button className="btn btn-primary btn-s" type="submit" data-toggle="tooltip" data-placement="bottom" title="Guardar"><i className="fa fa-floppy-o" aria-hidden="true"></i></button>
                        </div>

                    </div>
                    <div className="row">
                        <div className="col-md-3">
                            <div className="form-group">
                                <label htmlFor="txMotivo">Tipo Documento</label>
                                <Select
                                    placeholder="Selecione una opción"
                                    id="TipoDocto"
                                    name="TipoDocto"
                                    styles={colourStyles}
                                    onChange={v => { setFieldValue("TipoDocto", v.value) }}
                                    onBlur={handleBlur}
                                    value={displayitem(values.TipoDocto, state.InitialData.TipoDocumento)}
                                    options={mapitems(state.InitialData.TipoDocumento ? state.InitialData.TipoDocumento : [], '')}
                                    noOptionsMessage={() => "Sin opciones"}
                                />
                            </div>
                        </div>
                        <div className="col-md-3">
                            <div className="form-group">
                                <label htmlFor="txMotivo">Poliza maestra</label>
                                <input
                                    className="form-control input-sm"
                                    type="text"
                                    name="PolizaMaestra"
                                    id="PolizaMaestra"
                                    onChange={handleChange}
                                    value={values.PolizaMaestra ? values.PolizaMaestra : ''}
                                />
                            </div>
                        </div>
                        <div className="col-md-3">
                            <div className="form-group">
                                <label htmlFor="txMotivo">Estatus</label>
                                <Select
                                    placeholder="Selecione una opción"
                                    id="IDEstatus"
                                    name="IDEstatus"
                                    styles={colourStyles}
                                    onChange={v => { setFieldValue("IDEstatus", v.value) }}
                                    onBlur={handleBlur}
                                    value={displayitem(values.IDEstatus, state.InitialData.Estatus)}
                                    options={mapitems(state.InitialData.Estatus ? state.InitialData.Estatus : [], '')}
                                    noOptionsMessage={() => "Sin opciones"}
                                />
                            </div>
                        </div>
                        <div className="col-md-3">
                            <div className="form-group">
                                <label htmlFor="txMotivo">No De Folio</label>
                                <input
                                    className="form-control input-sm"
                                    type="text"
                                    name="NFolio"
                                    id="NFolio"
                                    onChange={handleChange}
                                    value={values.NFolio ? values.NFolio : ''}
                                />
                            </div>
                        </div>
                    </div>
                    <div className="row">
                        <div className="col-md-3">
                            <div className="form-group">
                                <label htmlFor="txMotivo">Documento</label>
                                <input
                                    className="form-control input-sm"
                                    type="text"
                                    name="Documento"
                                    id="Documento"
                                    onChange={handleChange}
                                    value={values.Documento ? values.Documento : ''}
                                />
                            </div>
                        </div>
                        <div className="col-md-3">
                            <div className="form-group">
                                <label htmlFor="txMotivo">Inciso</label>
                                <input
                                    className="form-control input-sm"
                                    type="text"
                                    name="Inciso"
                                    id="Inciso"
                                    onChange={handleChange}
                                    value={values.Inciso ? values.Inciso : ''}
                                />
                            </div>
                        </div>
                        <div className="col-md-3">
                            <div className="form-group">
                                <label htmlFor="txMotivo">Anterior</label>
                                <input
                                    className="form-control input-sm"
                                    type="text"
                                    name="DAnterior"
                                    id="DAnterior"
                                    onChange={handleChange}
                                    value={values.DAnterior ? values.DAnterior : ''}
                                />
                            </div>
                        </div>
                        <div className="col-md-3">
                            <div className="form-group">
                                <label htmlFor="txMotivo">Posterior</label>
                                <input
                                    className="form-control input-sm"
                                    type="text"
                                    name="DPosterior"
                                    id="DPosterior"
                                    onChange={handleChange}
                                    value={values.DPosterior ? values.DPosterior : ''}
                                />
                            </div>
                        </div>
                    </div>
                    <div className="row">
                        <div className="col-md-8">
                            <div className="form-group">
                                <label htmlFor="txMotivo">Cliente</label>
                                <input
                                    className="form-control input-sm"
                                    type="text"
                                    name="Cliente"
                                    id="Cliente"
                                    onChange={() => null}
                                    value={ordenTrabajo.Usuario.NombreCompleto ? ordenTrabajo.Usuario.NombreCompleto : ""}
                                    disabled={true}
                                />
                            </div>
                        </div>
                        <div className="col-md-4">
                            <div className="form-group">
                                <label htmlFor="txMotivo">RFC</label>
                                <input
                                    className="form-control input-sm"
                                    type="text"
                                    name="RFC"
                                    id="RFC"
                                    onChange={() => null}
                                    value={ordenTrabajo.Usuario.RFC ? ordenTrabajo.Usuario.RFC : ''}
                                    disabled={true}
                                />
                            </div>
                        </div>
                    </div>
                    <div className="row">
                        <div className="col-md-3">
                            <div className="form-group">
                                <label htmlFor="txMotivo">Grupo</label>
                                <Select
                                    placeholder="Selecione una opción"
                                    id="IDGrupo"
                                    name="IDGrupo"
                                    styles={colourStyles}
                                    onChange={v => { setFieldValue("IDGrupo", v.value), setFieldValue("IDSubGrupo", '') }}
                                    onBlur={handleBlur}
                                    value={displayitem(values.IDGrupo, state.InitialData.Grupo)}
                                    options={mapitems(state.InitialData.Grupo ? state.InitialData.Grupo : [], '')}
                                    noOptionsMessage={() => "Sin opciones"}
                                />
                            </div>
                        </div>
                        <div className="col-md-3">
                            <div className="form-group">
                                <label htmlFor="txMotivo">Subgrupo</label>
                                <Select
                                    placeholder="Selecione una opción"
                                    id="IDSubGrupo"
                                    name="IDSubGrupo"
                                    styles={colourStyles}
                                    onChange={v => { setFieldValue("IDSubGrupo", v.value) }}
                                    onBlur={handleBlur}
                                    value={displayitem(values.IDSubGrupo, state.InitialData.SubGrupo)}
                                    options={mapitemsHijos(state.InitialData.SubGrupo ? state.InitialData.SubGrupo : [], values.IDGrupo)}
                                    noOptionsMessage={() => "Sin opciones"}
                                />
                            </div>
                        </div>
                        <div className="col-md-3">
                            <div className="form-group">
                                <label htmlFor="txMotivo">Sub Subgrupo</label>
                                <input
                                    className="form-control input-sm"
                                    type="text"
                                    name="IDSubSubGrupo"
                                    id="IDSubSubGrupo"
                                    onChange={handleChange}
                                    value={values.IDSubSubGrupo ? values.IDSubSubGrupo : ''}
                                />
                            </div>
                        </div>
                        <div className="col-md-3">
                            <div className="form-group">
                                <label htmlFor="txMotivo">Expediente</label>
                                <input
                                    className="form-control input-sm"
                                    type="text"
                                    name="Expediente"
                                    id="Expediente"
                                    onChange={handleChange}
                                    value={values.Expediente ? values.Expediente : ''}
                                />
                            </div>
                        </div>
                    </div>
                    <div className="row">
                        <div className="col-md-8">
                            <div className="form-group">
                                <label htmlFor="txMotivo">Direccion</label>
                                <input
                                    className="form-control input-sm"
                                    type="text"
                                    name="empleadoId"
                                    value={ordenTrabajo.Usuario.Calle ? ordenTrabajo.Usuario.Calle : ''}
                                    onChange={() => null}
                                />
                            </div>
                        </div>
                        <div className="col-md-4">
                            <div className="form-group">
                                <label htmlFor="txMotivo">Subramo</label>
                                <Select
                                    placeholder="Selecione una opción"
                                    id="IDSRamo"
                                    name="IDSRamo"
                                    styles={colourStyles}
                                    onChange={v => { setFieldValue("IDSRamo", v.value) }}
                                    onBlur={handleBlur}
                                    value={displayitem(values.IDSRamo, state.InitialData.SubRamo)}
                                    options={mapitems(state.InitialData.SubRamo ? state.InitialData.SubRamo : [], '')}
                                    noOptionsMessage={() => "Sin opciones"}
                                />
                            </div>
                        </div>
                    </div>
                    <div className="row">
                        <div className="col-md-8">
                            <div className="row">
                                <div className="col-md-12">
                                    <div className="form-group">
                                        <label htmlFor="txMotivo">Agente</label>
                                        <Select
                                            placeholder="Selecione una opción"
                                            id="IDAgente"
                                            name="IDAgente"
                                            //styles={errors.aseguradora_id ? colourStyles2 : colourStyles}
                                            styles={colourStyles}
                                            onChange={v => { setFieldValue("IDAgente", v.value) }}
                                            onBlur={handleBlur}
                                            value={displayitem(values.IDAgente, state.InitialData.Agentes)}
                                            options={mapitems(state.InitialData.Agentes ? state.InitialData.Agentes : [], '')}
                                            noOptionsMessage={() => "Sin opciones"}
                                        />
                                    </div>
                                </div>
                                <div className="col-md-12">
                                    <div className="form-group">
                                        <label htmlFor="txMotivo">Compañia</label>
                                        <Select
                                            placeholder="Selecione una opción"
                                            id="IDCompania"
                                            name="IDCompania"
                                            styles={colourStyles}
                                            onChange={v => { setFieldValue("IDCompania", v.value) }}
                                            onBlur={handleBlur}
                                            value={displayitem(values.IDCompania, state.InitialData.Companias)}
                                            options={mapitems(state.InitialData.Companias ? state.InitialData.Companias : [], '')}
                                            noOptionsMessage={() => "Sin opciones"}
                                        />
                                    </div>
                                </div>
                                <div className="col-md-6">
                                    <div className="form-group">
                                        <label htmlFor="txMotivo">Ejecutivo</label>
                                        <Select
                                            placeholder="Selecione una opción"
                                            id="IDEjecut"
                                            name="IDEjecut"
                                            styles={colourStyles}
                                            onChange={v => { setFieldValue("IDEjecut", v.value) }}
                                            onBlur={handleBlur}
                                            value={displayitem(values.IDEjecut, state.InitialData.Ejecutivos)}
                                            options={mapitems(state.InitialData.Ejecutivos ? state.InitialData.Ejecutivos : [], '')}
                                            noOptionsMessage={() => "Sin opciones"}
                                        />
                                        {/* <input
                                    className="form-control input-sm"
                                    type="text"
                                    name="empleadoId"
                                /> */}
                                    </div>
                                </div>
                                <div className="col-md-6">
                                    <div className="form-group">
                                        <label htmlFor="txMotivo">Forma pago</label>
                                        <Select
                                            placeholder="Selecione una opción"
                                            id="IDFPago"
                                            name="IDFPago"
                                            styles={colourStyles}
                                            onChange={v => { setFieldValue("IDFPago", v.value) }}
                                            onBlur={handleBlur}
                                            value={displayitem(values.IDFPago, state.InitialData.FormaPago)}
                                            options={mapitems(state.InitialData.FormaPago ? state.InitialData.FormaPago : [], '')}
                                            noOptionsMessage={() => "Sin opciones"}
                                        />
                                    </div>
                                </div>
                                <div className="col-md-6">
                                    <div className="form-group">
                                        <label htmlFor="txMotivo">Vendedor</label>
                                        <Select
                                            placeholder="Selecione una opción"
                                            id="IDVend"
                                            name="IDVend"
                                            styles={colourStyles}
                                            onChange={v => { setFieldValue("IDVend", v.value) }}
                                            onBlur={handleBlur}
                                            value={displayitem(values.IDVend, state.InitialData.Vendedores)}
                                            options={mapitems(state.InitialData.Vendedores ? state.InitialData.Vendedores : [], '')}
                                            noOptionsMessage={() => "Sin opciones"}
                                        />
                                    </div>
                                </div>
                                <div className="col-md-6">
                                    <div className="form-group">
                                        <label htmlFor="txMotivo">Moneda</label>
                                        <Select
                                            placeholder="Selecione una opción"
                                            id="Moneda"
                                            name="Moneda"
                                            styles={colourStyles}
                                            onChange={v => { setFieldValue("IDMon", v.value) }}
                                            onBlur={handleBlur}
                                            value={displayitem(values.IDMon, state.InitialData.Monedas)}
                                            options={mapitems(state.InitialData.Monedas ? state.InitialData.Monedas : [], '')}
                                            noOptionsMessage={() => "Sin opciones"}
                                        />
                                    </div>
                                </div>
                                <div className="col-md-12">
                                    <div className="form-group">
                                        <label htmlFor="txMotivo">Concepto</label>
                                        <input
                                            className="form-control input-sm"
                                            type="text"
                                            name="empleadoId"
                                            value={values.Concepto ? values.Concepto : ''}
                                            onChange={handleChange}
                                        />
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div className="col-md-4">
                            <div className="row">
                                <div className="col-md-6">
                                    <div className="form-group">
                                        <label htmlFor="txMotivo">Desde</label>
                                        <input
                                            className="form-control input-sm"
                                            type="date"
                                            name="FDesde"
                                            id="FDesde"
                                            onChange={handleChange}
                                            value={values.FDesde ? values.FDesde : ''}
                                        />
                                    </div>
                                </div>
                                <div className="col-md-6">
                                    <div className="form-group">
                                        <label htmlFor="txMotivo">Hasta</label>
                                        <input
                                            className="form-control input-sm"
                                            type="date"
                                            name="FHasta"
                                            id="FHasta"
                                            onChange={handleChange}
                                            value={values.FHasta ? values.FHasta : ''}
                                        />
                                    </div>
                                </div>
                                <div className="col-md-6">
                                    <div className="form-group">
                                        <label htmlFor="txMotivo">Renovacion</label>
                                        <input
                                            className="form-control input-sm"
                                            type="date"
                                            name="FRenovacion"
                                            id="FRenovacion"
                                            onChange={handleChange}
                                            value={values.FRenovacion ? values.FRenovacion : ''}
                                        />
                                    </div>
                                </div>
                                <div className="col-md-6">
                                    <div className="form-group">
                                        <label htmlFor="txMotivo">Fecha antiguedad</label>
                                        <input
                                            className="form-control input-sm"
                                            type="date"
                                            name="FAntiguedad"
                                            id="FAntiguedad"
                                            onChange={handleChange}
                                            value={values.FAntiguedad ? values.FAntiguedad : ''}
                                        />
                                    </div>
                                </div>
                                <div className="col-md-6">
                                    <div className="form-group">
                                        <label htmlFor="txMotivo">Captura</label>
                                        <input
                                            className="form-control input-sm"
                                            type="date"
                                            name="FCaptura"
                                            id="FCaptura"
                                            onChange={handleChange}
                                            value={values.FCaptura ? values.FCaptura : ''}
                                        />
                                    </div>
                                </div>
                                <div className="col-md-6">
                                    <div className="form-group">
                                        <label htmlFor="txMotivo">Envio</label>
                                        <input
                                            className="form-control input-sm"
                                            type="date"
                                            name="FEnvio"
                                            id="FEnvio"
                                            onChange={handleChange}
                                            value={values.FEnvio ? values.FEnvio : ''}
                                        />
                                    </div>
                                </div>
                                <div className="col-md-6">
                                    <div className="form-group">
                                        <label htmlFor="txMotivo">Recepcion</label>
                                        <input
                                            className="form-control input-sm"
                                            type="date"
                                            name="FRecepcion"
                                            id="FRecepcion"
                                            onChange={handleChange}
                                            value={values.FRecepcion ? values.FRecepcion : ''}
                                        />
                                    </div>
                                </div>
                                <div className="col-md-6">
                                    <div className="form-group">
                                        <label htmlFor="txMotivo">Emision</label>
                                        <input
                                            className="form-control input-sm"
                                            type="date"
                                            name="FEmision"
                                            id="FEmision"
                                            onChange={handleChange}
                                            value={values.FEmision ? values.FEmision : ''}
                                        />
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div className="row">
                        <div className="col-md-8">
                            <div className="row">
                                <div className="col-md-6">
                                    <div className="form-group">
                                        <label htmlFor="txMotivo">Referencia 1</label>
                                        <input
                                            type="text"
                                            name="Referencia1"
                                            id="Referencia1"
                                            onChange={handleChange}
                                            value={values.Referencia1 ? values.Referencia1 : ''}
                                            className="form-control input-sm"
                                            autoComplete="off"
                                        />
                                    </div>
                                </div>
                                <div className="col-md-6">
                                    <div className="form-group">
                                        <label htmlFor="txMotivo">Estatus cobro</label>
                                        <Select
                                            placeholder="Selecione una opción"
                                            id="IDEstatusCobro"
                                            name="IDEstatusCobro"
                                            styles={colourStyles}
                                            onChange={v => { setFieldValue("IDEstatusCobro", v.value) }}
                                            onBlur={handleBlur}
                                            value={displayitem(values.IDEstatusCobro, state.InitialData.EstatusCobro)}
                                            options={mapitems(state.InitialData.EstatusCobro ? state.InitialData.EstatusCobro : [], '')}
                                            noOptionsMessage={() => "Sin opciones"}
                                        />
                                    </div>
                                </div>
                                <div className="col-md-6">
                                    <div className="form-group">
                                        <label htmlFor="txMotivo">Referencia 2</label>
                                        <input
                                            type="text"
                                            name="Referencia2"
                                            id="Referencia2"
                                            onChange={handleChange}
                                            value={values.Referencia2 ? values.Referencia2 : ''}
                                            className="form-control input-sm"
                                            autoComplete="off"
                                        />
                                    </div>
                                </div>
                                <div className="col-md-6">
                                    <div className="form-group">
                                        <label htmlFor="txMotivo">Estatus usuario</label>
                                        <Select
                                            placeholder="Selecione una opción"
                                            id="IDEstatusUsuario"
                                            name="IDEstatusUsuario"
                                            styles={colourStyles}
                                            onChange={v => { setFieldValue("IDEstatusUsuario", v.value) }}
                                            onBlur={handleBlur}
                                            value={displayitem(values.IDEstatusUsuario, state.InitialData.Estatus)}
                                            options={mapitems(state.InitialData.Estatus ? state.InitialData.Estatus : [], '')}
                                            noOptionsMessage={() => "Sin opciones"}
                                        />
                                    </div>
                                </div>
                                <div className="col-md-6">
                                    <div className="form-group">
                                        <label htmlFor="txMotivo">Referencia 3</label>
                                        <input
                                            type="text"
                                            name="Referencia3"
                                            id="Referencia3"
                                            onChange={handleChange}
                                            value={values.Referencia3 ? values.Referencia3 : ''}
                                            className="form-control input-sm"
                                            autoComplete="off"
                                        />
                                    </div>
                                </div>
                                <div className="col-md-6">
                                    <div className="form-group">
                                        <label htmlFor="txMotivo">Clasificacion documento</label>
                                        <Select
                                            placeholder="Selecione una opción"
                                            id="IDClasificiacionDocumento"
                                            name="IDClasificiacionDocumento"
                                            styles={colourStyles}
                                            onChange={v => { setFieldValue("IDClasificiacionDocumento", v.value) }}
                                            onBlur={handleBlur}
                                            value={displayitem(values.IDClasificiacionDocumento, state.InitialData.EstatusDoc)}
                                            options={mapitems(state.InitialData.EstatusDoc ? state.InitialData.EstatusDoc : [], '')}
                                            noOptionsMessage={() => "Sin opciones"}
                                        />
                                    </div>
                                </div>
                                <div className="col-md-6">
                                    <div className="form-group">
                                        <label htmlFor="txMotivo">Referencia 4</label>
                                        <input
                                            className="form-control input-sm"
                                            type="text"
                                            name="Referencia4"
                                            id="Referencia4"
                                            onChange={handleChange}
                                            value={values.Referencia4 ? values.Referencia4 : ''}
                                        />
                                    </div>
                                </div>
                                <div className="col-md-6">
                                    <div className="form-group">
                                        <label htmlFor="txMotivo">Gerencia</label>
                                        <Select
                                            placeholder="Selecione una opción"
                                            id="IDGerencia"
                                            name="IDGerencia"
                                            styles={colourStyles}
                                            onChange={v => { setFieldValue("IDGerencia", v.value) }}
                                            onBlur={handleBlur}
                                            value={displayitem(values.IDGerencia, state.InitialData.Gerencias)}
                                            options={mapitems(state.InitialData.Gerencias ? state.InitialData.Gerencias : [], '')}
                                            noOptionsMessage={() => "Sin opciones"}
                                        />
                                    </div>
                                </div>
                                <div className="col-md-6">
                                    <div className="form-group">
                                        <label htmlFor="txMotivo">Oficina</label>
                                        <input
                                            className="form-control input-sm"
                                            type="text"
                                            name="Oficina"
                                            id="Oficina"
                                            onChange={handleChange}
                                            value={values.Oficina ? values.Oficina : ''}
                                        />
                                    </div>
                                </div>
                                <div className="col-md-6">
                                    <div className="form-group">
                                        <label htmlFor="txMotivo">Linea Negocio</label>
                                        <Select
                                            placeholder="Selecione una opción"
                                            id="IDLineaNegocio"
                                            name="IDLineaNegocio"
                                            styles={colourStyles}
                                            onChange={v => { setFieldValue("IDLineaNegocio", v.value) }}
                                            onBlur={handleBlur}
                                            value={displayitem(values.IDLineaNegocio, state.InitialData.LineaNegocio)}
                                            options={mapitems(state.InitialData.LineaNegocio ? state.InitialData.LineaNegocio : [], '')}
                                            noOptionsMessage={() => "Sin opciones"}
                                        />
                                    </div>
                                </div>
                                <div className="col-md-6">
                                    <div className="form-group">
                                        <label htmlFor="txMotivo">Despacho</label>
                                        <input
                                            className="form-control input-sm"
                                            type="text"
                                            name="Despacho"
                                            id="Despacho"
                                            onChange={handleChange}
                                            value={values.Despacho ? values.Despacho : ''}
                                        />
                                    </div>
                                </div>
                                <div className="col-md-6">
                                    <div className="form-group">
                                        <label htmlFor="txMotivo">Tipo Conducto cobro</label>
                                        <input
                                            className="form-control input-sm"
                                            type="text"
                                            name="IDTipoConductoCobro"
                                            id="IDTipoConductoCobro"
                                            onChange={handleChange}
                                            value={values.IDTipoConductoCobro ? values.IDTipoConductoCobro : ''}
                                        />
                                    </div>
                                </div>
                                <div className="col-md-6">
                                    <div className="form-group">
                                        <label htmlFor="txMotivo">Conducto cobro</label>
                                        <Select
                                            placeholder="Selecione una opción"
                                            id="IDCoductoCobro"
                                            name="IDCoductoCobro"
                                            styles={colourStyles}
                                            onChange={v => { setFieldValue("IDCoductoCobro", v.value) }}
                                            onBlur={handleBlur}
                                            value={displayitem(values.IDCoductoCobro, state.InitialData.ConductoCobro)}
                                            options={mapitems(state.InitialData.ConductoCobro ? state.InitialData.ConductoCobro : [], '')}
                                            noOptionsMessage={() => "Sin opciones"}
                                        />
                                    </div>
                                </div>
                                <div className="col-md-6">
                                    <div className="form-group">
                                        <label htmlFor="txMotivo">Endoso</label>
                                        <input
                                            className="form-control input-sm"
                                            type="text"
                                            name="Endoso"
                                            id="Endoso"
                                            onChange={handleChange}
                                            value={values.Endoso ? values.Endoso : ''}
                                        />
                                    </div>
                                </div>
                                <div className="col-md-6">
                                    <div className="form-group">
                                        <label htmlFor="txMotivo">Tipo pago</label>
                                        <Select
                                            placeholder="Selecione una opción"
                                            id="IDTipoPago"
                                            name="IDTipoPago"
                                            styles={colourStyles}
                                            onChange={v => { setFieldValue("IDTipoPago", v.value) }}
                                            onBlur={handleBlur}
                                            value={displayitem(values.IDTipoPago, state.InitialData.TipoPago)}
                                            options={mapitems(state.InitialData.TipoPago ? state.InitialData.TipoPago : [], '')}
                                            noOptionsMessage={() => "Sin opciones"}
                                        />
                                    </div>
                                </div>
                                <div className="col-md-6">
                                    <div className="form-group">
                                        <label htmlFor="txMotivo">Tipo venta</label>
                                        <Select
                                            placeholder="Selecione una opción"
                                            id="TipoVenta"
                                            name="TipoVenta"
                                            styles={colourStyles}
                                            onChange={v => { setFieldValue("IDTipoVenta", v.value) }}
                                            onBlur={handleBlur}
                                            value={displayitem(values.IDTipoVenta, state.InitialData.TipoVenta)}
                                            options={mapitems(state.InitialData.TipoVenta ? state.InitialData.TipoVenta : [], '')}
                                            noOptionsMessage={() => "Sin opciones"}
                                        />
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div className="col-md-4">
                            <div className="row">
                                <div className="col-md-12">
                                    <div className="form-group">
                                        <label htmlFor="txMotivo">Prima neta</label>
                                        <input
                                            className="form-control input-sm numeric"
                                            type="text"
                                            name="PrimaNeta"
                                            id="PrimaNeta"
                                            onChange={handleChange}
                                            value={values.PrimaNeta ? values.PrimaNeta : ''}
                                        />
                                    </div>
                                </div>
                                <div className="col-md-12">
                                    <div className="form-group">
                                        <label htmlFor="txMotivo">Descuento</label>
                                        <input
                                            className="form-control input-sm numeric"
                                            type="text"
                                            name="Descuento"
                                            id="Descuento"
                                            onChange={handleChange}
                                            value={values.Descuento ? values.Descuento : ''}
                                        />
                                    </div>
                                </div>
                                <div className="col-md-12">
                                    <div className="form-group">
                                        <label htmlFor="txMotivo">Recargos</label>
                                        <input
                                            className="form-control input-sm numeric"
                                            type="text"
                                            name="Recargos"
                                            id="Recargos"
                                            onChange={handleChange}
                                            value={values.Recargos ? values.Recargos : ''}
                                        />
                                    </div>
                                </div>
                                <div className="col-md-12">
                                    <div className="form-group">
                                        <label htmlFor="txMotivo">Derechos</label>
                                        <input
                                            className="form-control input-sm numeric"
                                            type="text"
                                            name="Derechos"
                                            id="Derechos"
                                            onChange={handleChange}
                                            value={values.Derechos ? values.Derechos : ''}
                                        />
                                    </div>
                                </div>
                                <div className="col-md-12">
                                    <div className="form-group">
                                        <label htmlFor="txMotivo">SubTotal</label>
                                        <input
                                            className="form-control input-sm numeric"
                                            type="text"
                                            name="STotal"
                                            id="STotal"
                                            onChange={handleChange}
                                            value={values.STotal ? values.STotal : ''}
                                        />
                                    </div>
                                </div>
                                <div className="col-md-12">
                                    <div className="form-group">
                                        <label htmlFor="txMotivo">Iva</label>
                                        <input
                                            className="form-control input-sm numeric"
                                            type="text"
                                            name="IVA"
                                            id="IVA"
                                            onChange={handleChange}
                                            value={values.IVA ? values.IVA : ''}
                                        />
                                    </div>
                                </div>
                                <div className="col-md-12">
                                    <div className="form-group">
                                        <label htmlFor="txMotivo">Ajuste</label>
                                        <input
                                            className="form-control input-sm numeric"
                                            type="text"
                                            name="Ajuste"
                                            id="Ajuste"
                                            onChange={handleChange}
                                            value={values.Ajuste ? values.Ajuste : ''}

                                        />
                                    </div>
                                </div>
                                <div className="col-md-12">
                                    <div className="form-group">
                                        <label htmlFor="txMotivo">Prima total</label>
                                        <input
                                            className="form-control input-sm numeric"
                                            type="text"
                                            name="PrimaTotal"
                                            id="PrimaTotal"
                                            onChange={handleChange}
                                            value={values.PrimaTotal ? values.PrimaTotal : ''}
                                        />
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </form >
            )}
        </Formik>
    );
}

export default Captura;
