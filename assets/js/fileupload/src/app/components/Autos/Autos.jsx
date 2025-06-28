import React, { useState, useEffect, useRef, forwardRef, useImperativeHandle } from 'react';
import { CallApiGet, CallApiPost } from '../../Helpers/Calls.js';
import Paginate from '../captura/Paginate.jsx';
import { ShowLoading } from '../../Helpers/FGeneral.js';
import { color, Colorbarra } from '../../Helpers/SiniestrrosHelpers.js';
import { Formik } from "formik";



const Autos = forwardRef((props, ref) => {
    const path = window.jQuery("#base_url").attr("data-base-url");
    const Id = window.jQuery("#idRegistro").val();

    //$("#menu").css("z-index", '-1');
    const { callbackSuccess, UrlServicio, UrlPagina } = props;
    const formikRef = useRef(null);//componente 1
    const childrenRef = useRef(null);//Componente 2
    const [RegistrosTabla, SetRegistrosTabla] = useState([]);
    const [itemOffset, setItemOffset] = useState(0);
    const [pageCount, setPageCount] = useState(0);
    const [totalRows, setTotalRows] = useState(0);
    const itemsPerPage = 10;
    var data = {
        Offset: itemOffset,
        Month: '',
        Id_estatus: '',
        Search: '',
        Year: '',
        FInicio: '',
        FFin: '',
        Evento: [],
        Aseguradora: [],
        Agente: '',
        TTramite: '',
        ESiniestro: '',
        ETramite: ''
    }
    const [DFields, SetFields] = useState(data);
    useImperativeHandle(ref, () => ({
        ReloadData: ReloadData
    }));

    //Iniciamos las llamadas al cargar el componente
    useEffect(() => {
        getAutos(null);
    }, []);

    async function getAutos(Offset) {
        ShowLoading();
        let fields = formikRef.current.values;
        if (Offset != null) {
            fields.Offset = Offset;
        }
        let itemsEvento = $('#Evento option:selected').toArray().map(item => item.value);
        let itemAseguradora = $('#Aseguradora option:selected').toArray().map(item => item.value);
        fields.Evento = itemsEvento;
        fields.Aseguradora = itemAseguradora;
        const res = await CallApiPost(`${UrlPagina}Autos/getAutosV2_1`, fields, null);
        if (res.status != 200) {
            toastr.error(`Error ${res.error.Mensaje}`);
        } else {
            SetRegistrosTabla(res.success.data.Data);
            setPageCount(Math.ceil(res.success.data.Count / itemsPerPage));
            setTotalRows(res.success.data.Count);
            //toastr.error(`Lammada`);
        }
        ShowLoading(false);
    }

    const handlePageClick = (event) => {
        const newOffset = (event.selected * itemsPerPage) % totalRows;
        //console.log("new", newOffset)
        formikRef.current.setFieldValue("Offset", newOffset);
        setItemOffset(newOffset);
        getAutos(newOffset);
    };

    //ReloadTable
    const ReloadData = (parametros) => {
        //console.log('Método llamado con:', parametros);
        //formikRef.current.setFieldValue("Offset", 0);
        getAutos(null);
    };

    const Test = () => {
        /*  let fields = formikRef.current.values;
         fields.Offset = itemOffset;
         let itemsEvento = $('#Evento option:selected').toArray().map(item => item.value);
         let itemAseguradora = $('#Aseguradora option:selected').toArray().map(item => item.value);
         fields.Evento = itemsEvento;
         fields.Aseguradora = itemAseguradora;
         console.log("Fields", fields) */

    }




    return (
        <div className='row'>
            <div className='col-md-12'>{/*parte de los filtros del modulo*/}
                <Formik
                    innerRef={formikRef}
                    initialValues={DFields}
                    enableReinitialize="true"
                    onSubmit={(values, actions) => {
                        //SaveData(values);
                        ReloadData();
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
                        <form className="form" autoComplete="off">
                            <div className='row'>
                                <div className="col-sm-2">
                                    <label>Buscar </label>
                                    <input type="text" onChange={(e) => { setFieldValue("Search", e.target.value), setFieldValue("Offset", 0) }} value={values.Search ? values.Search : ''} placeholder="Buscar..." id="Search" className="form-control input-sm" name="Search" />
                                </div>
                                <div className="col-sm-2">
                                    <label>Año</label>
                                    <select className="form-control input-sm" id="Year" name="Year" value={values.Year ? values.Year : ''} onChange={(e) => { setFieldValue("Year", e.target.value), setFieldValue("Offset", 0) }}>
                                        <option value="0">Todos</option>
                                        {_years.map((item, key) => (
                                            <option key={key} value={item.opcion}>{item.opcion}</option>
                                        ))}
                                    </select>
                                </div>
                                <div className="col-sm-2">
                                    <label>Fecha inicio </label>
                                    <input type="date" value={values.FInicio ? values.FInicio : ''} onChange={(e) => { setFieldValue("FInicio", e.target.value), setFieldValue("Offset", 0) }} className="form-control input-sm" id="FInicio" name="FInicio" />
                                </div>
                                <div className="col-sm-2">
                                    <label>Fecha fin </label>
                                    <input type="date" value={values.FFin ? values.FFin : ''} onChange={(e) => { setFieldValue("FFin", e.target.value), setFieldValue("Offset", 0) }} className="form-control input-sm" id="Ffin" name="FFin" />
                                </div>
                                <div className="col-sm-2">
                                    <label>Evento </label>
                                    <select id="Evento" name="Evento" value={values.Evento ? values.Evento : ''} className="multiselect-ui form-control" multiple="multiple" onChange={(e) => { setFieldValue("Evento", e.target.value), setFieldValue("Offset", 0) }}>
                                        {_siniestroT.map((item, key) => (
                                            <option key={key} value={item.id}>{item.nombre}</option>
                                        ))}
                                    </select>
                                </div>
                                <div className="col-sm-2">
                                    <label>Aseguradora </label>
                                    <select id="Aseguradora" name="Aseguradora" value={values.Aseguradora ? values.Aseguradora : ''} onChange={(e) => { const options = Array.from(e.target.selectedOptions, option => option.value); setFieldValue("Aseguradora", options), setFieldValue("Offset", 0) }} className="multiselect-ui form-control" multiple="multiple">
                                        {_Aseguradoras.map((item, key) => (
                                            <option key={key} value={item.id}>{item.nombre}</option>
                                        ))}
                                    </select>
                                </div>
                            </div>
                            <div className="row">
                                <div className="col-sm-2">
                                    <label>Tipo tramite </label>
                                    <select id="TTramite" name="TTramite" value={values.TTramite ? values.TTramite : ''} onChange={(e) => { setFieldValue("TTramite", e.target.value), setFieldValue("Offset", 0) }} className="form-control input-sm" >
                                        <option value="">Todos</option>
                                        {_TramAutos.map((item, key) => (
                                            <option key={key} value={item.id}>{item.nombre}</option>
                                        ))}
                                    </select>
                                </div>
                                <div className="col-sm-2">
                                    <label>Estatus siniestro</label>
                                    <select className="form-control input-sm" value={values.ESiniestro ? values.ESiniestro : ''} id="ESiniestro" name="ESiniestro" onChange={(e) => { setFieldValue("ESiniestro", e.target.value), setFieldValue("Offset", 0) }}>
                                        <option value="">Todos</option>
                                        
                                        {_estatus.map((item, key) => (
                                            <option key={key} value={item.nombre}>{item.nombre}</option>
                                        ))}
                                    </select>
                                </div>
                                <div className="col-sm-2">
                                    <label>Estatus tramite </label>
                                    <select className="form-control input-sm" value={values.ETramite ? values.ETramite : ''} id="ETramite" name="ETramite" onChange={(e) => { setFieldValue("ETramite", e.target.value), setFieldValue("Offset", 0) }}>
                                        <option value="">Todos</option>
                                        <option value="NULL">N/A</option>
                                        {_estatus.map((item, key) => (
                                            <option key={key} value={item.nombre}>{item.nombre}</option>
                                        ))}
                                    </select>
                                </div>
                                <div className="col-sm-2">
                                    <a className="btn btn-primary" onClick={() => ReloadData()} style={{ marginTop: '22px' }}  ><i className="fa fa-search" aria-hidden="true"></i> Buscar</a>
                                </div>
                                <div className="col-md-4 text-right" style={{ marginTop: '10px' }}>
                                    <a className="btn btn-primary" href={`${UrlPagina}Autos/RegistroAutos`}>Nuevo</a>
                                </div>
                            </div>
                        </form>
                    )}
                </Formik>
                <div className='row'>
                    <div className='col-md-12'>
                        <table className="table mt-5" id="example">
                            <thead>
                                <tr>
                                    <th scope="col" style={{ width: '150px' }}>Estatus</th>
                                    <th scope="col">Tipo</th>
                                    <th scope="col" style={{ width: '200px' }}>Progreso</th>
                                    <th style={{ textAlign: 'center', width: '120px' }} scope="col">Acciones</th>
                                </tr>
                            </thead>
                            <tbody>

                                {RegistrosTabla && RegistrosTabla.map((Item, Key) => {
                                    let PercentColor = Colorbarra(Item.dias, Item.progreso, Item.inicio_ajuste, Item.fecha_fin, Item.siniestro_estatus);
                                    return (
                                        <tr key={Key}>
                                            <td>
                                                <div className="col-md-1 center-aling-items ">
                                                    <div className="card-round" style={{ background: Item.siniestro_estatus != 'ACTIVO' ? color(Item.siniestro_estatus) : Item.tram_est_nom == null ? '#8c8787' : Item.tram_est_col }}>
                                                        <h6 className="text-uppercase fw-bold text-center label_estatus" style={{ paddingTop: '9px', paddingBottom: '9px', fontSize: '9px', color: 'white !important' }} >{Item.siniestro_estatus != 'ACTIVO' ? Item.siniestro_estatus : Item.tram_est_nom == null ? 'N/A' : Item.tram_est_nom}  </h6>
                                                    </div>
                                                </div>
                                            </td>
                                            <td>
                                                <div className="row">
                                                    <div className="col-md-12">
                                                        <div>
                                                            <div className="media-body">
                                                                <h5 className="media-heading"><strong>Tipo: {Item.tipo_siniestro_nombre}, Trámite: {Item.nombre_tramite == null ? 'N/A' : Item.nombre_tramite}</strong> </h5>
                                                                <div className="Siniestro-body">
                                                                    <div className="box first">Fechas Siniestro: {Item.inicio_ajuste == null ? 'N/A' : moment(Item.inicio_ajuste).format("DD/MM/YYYY")} al {Item.fecha_fin == null ? 'N/A' : moment(Item.fecha_fin).format("DD/MM/YYYY")} </div>
                                                                    <div className="box first" style={{ paddingLeft: '15px' }}>Fecha Tramite: {Item.tram_ini == null ? 'N/A' : moment(Item.tram_ini).format("DD/MM/YYYY")} al {Item.tram_fin == null ? 'N/A' : moment(Item.tram_fin).format("DD/MM/YYYY")}</div>
                                                                    <div className="box first" style={{ paddingLeft: '15px' }}> Número de siniestro: {Item.siniestro_id}</div>
                                                                    <div className="box first" style={{ paddingLeft: '15px' }}> Poliza: {Item.poliza}</div>
                                                                    <div className="box first" style={{ paddingLeft: '15px' }}> Asegurado: {Item.asegurado_nombre}</div>
                                                                    {Item.nombre_tramite == 'REPARACIÓN' && (
                                                                        <div className="box first" style={{ paddingLeft: '15px' }}> Estatus Reparación: {Item.Estatus_Reparacion != '' ? Item.Estatus_Reparacion : 'N/A'}</div>
                                                                    )}
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </td>
                                            <td>
                                                <div className="row">
                                                    <div className="col-md-12">
                                                        <div className="progressBar">
                                                            <div className="progressb" style={{ width: PercentColor.porcentaje, backgroundColor: PercentColor.color }} data-row="40%">
                                                            </div>
                                                            <span>{PercentColor.mensaje}</span>
                                                        </div>
                                                    </div>
                                                </div>
                                            </td>
                                            <td>
                                                <div style={{ float: 'left', fontSize: '20px' }} className="text-center">
                                                    <div style={{ fontSize: '12px' }}> Duración</div>
                                                    <div style={{ height: '30px', width: '30px', backgroundColor: PercentColor.color, color: 'white', borderRadius: '50%', display: 'inline-block' }}>
                                                        {PercentColor.dias}
                                                    </div>
                                                    <div style={{ fontSize: '12px' }}> Dias </div>
                                                </div>
                                                <div style={{ textAlign: 'center' }} >
                                                    <div className="dropdown">
                                                        <button className="btn btn-link dropdown-toggle" type="button" id={`dp${Item.id}`} data-toggle="dropdown" aria-haspopup="true" aria-expanded="true">
                                                            <i className="fa fa-ellipsis-v" aria-hidden="true"></i>
                                                        </button>
                                                        <ul className="dropdown-menu" aria-labelledby={`dp${Item.id}`}>
                                                            <li><a className="bn-bono-view" style={{ cursor: 'pointer' }} onClick={() => { callbackSuccess(1, { Id: Item.id }) }}  >Ver</a></li>
                                                            <li><a className="bn-bono-view" style={{ cursor: 'pointer' }} onClick={() => { callbackSuccess(2, { Id: Item.id, id_tramite: Item.id_tramite, tipo_tramite: Item.tipo_tramite, tram_estatus: Item.tram_estatus }) }} data-permiso="permiso" data-accion-permiso="Seguimiento" >Seguimiento</a></li>

                                                            {Item.fecha_fin == null && (
                                                                <>
                                                                    <li><a className="bn-bono-view" style={{ cursor: 'pointer' }} href={`${UrlPagina}Autos/RegistroAutos/${Item.id}`} data-permiso="permiso" data-accion-permiso="Editar">Editar siniestro</a></li>
                                                                    {Item.tram_close == null && Item.id_tramite != null && (
                                                                        <li><a className="bn-bono-view" style={{ cursor: 'pointer' }} onClick={() => { callbackSuccess(3, { id_tramite: Item.id_tramite, tipo_tramite: Item.tipo_tramite }) }} data-permiso="permiso" data-accion-permiso="Editar-tramite">Editar Trámite</a></li>
                                                                    )}
                                                                    {Item.tram_close == '1' || Item.id_tramite == null && (
                                                                        <li><a className="bn-bono-view" style={{ cursor: 'pointer' }} onClick={() => { callbackSuccess(4, { Id: Item.id }) }} data-permiso="permiso" data-accion-permiso="Nuevo-tramite">Nuevo Trámite</a></li>
                                                                    )}
                                                                    {Item.tram_close == null && Item.id_tramite != null && (
                                                                        <li><a className="bn-bono-view" style={{ cursor: 'pointer' }} onClick={() => { callbackSuccess(5, { tram_estatus: Item.tram_estatus, Id: Item.id, id_tramite: Item.id_tramite, tram_ini: Item.tram_ini, tipo_tramite: Item.tipo_tramite }) }} data-permiso="permiso" data-accion-permiso="Cambiar-estatus"  >Cambiar Estatus Trámite</a></li>
                                                                    )}
                                                                    {Item.tram_close != null || Item.id_tramite == null && (
                                                                        <li><a className="bn-bono-view" style={{ cursor: 'pointer' }} onClick={() => { callbackSuccess(6, { status_id: Item.status_id, orden: Item.orden, Id: Item.id, inicio_ajuste: Item.inicio_ajuste }) }} data-permiso="permiso" data-accion-permiso="Cambiar-estatus"  >Cambiar Estatus Siniestro</a></li>
                                                                    )}
                                                                </>
                                                            )}
                                                            {Item.fecha_fin != null && (
                                                                <>
                                                                    {Item.fecha_fin != null && (
                                                                        <li><a className="bn-bono-view" style={{ cursor: 'pointer' }} onClick={() => { callbackSuccess(7, { Id: Item.id }) }} data-permiso="permiso" data-accion-permiso="Reingreso" >Reingreso</a></li>
                                                                    )}
                                                                    {Item.tram_close == null && Item.id_tramite != null && (
                                                                        <li><a className="bn-bono-view" style={{ cursor: 'pointer' }} onClick={() => { callbackSuccess(3, { id_tramite: Item.id_tramite, tipo_tramite: Item.tipo_tramite }) }} data-permiso="permiso" data-accion-permiso="Editar-tramite">Editar Trámite</a></li>
                                                                    )}
                                                                    {Item.tram_close == null && Item.id_tramite != null && (
                                                                        <li><a className="bn-bono-view" style={{ cursor: 'pointer' }} onClick={() => { callbackSuccess(5, { tram_estatus: Item.tram_estatus, Id: Item.id, id_tramite: Item.id_tramite, tram_ini: Item.tram_ini, tipo_tramite: Item.tipo_tramite }) }} data-permiso="permiso" data-accion-permiso="Cambiar-estatus" >Cambiar Estatus Trámite r</a></li>
                                                                    )}
                                                                    {(Item.tram_close != null || Item.id_tramite == null) && Item.fecha_fin == null && (
                                                                        <li><a className="bn-bono-view" style={{ cursor: 'pointer' }} onClick={() => { callbackSuccess(6, { status_id: Item.status_id, orden: Item.orden, Id: Item.id, inicio_ajuste: Item.inicio_ajuste }) }} data-permiso="permiso" data-accion-permiso="Cambiar-estatus"  >Cambiar Estatus Siniestro</a></li>
                                                                    )}
                                                                </>
                                                            )}
                                                            <li><a className="bn-bono-view Editar" style={{ cursor: 'pointer' }} onClick={() => { callbackSuccess(8, { Id: Item.id }) }} data-permiso="permiso" data-accion-permiso="Administrar-documentos">Administrar Documentos</a></li>
                                                            <li role="presentation" className="dropdown-header">Notas</li>
                                                            <li><a className="bn-bono-view show-notes-modal" data-type="autos" data-id={`${Item.id}`} data-number={`${Item.siniestro_id}`} data-insured={`${Item.asegurado_nombre}`} data-policy={`${Item.poliza}`} data-type-sinister={`${Item.tipo_siniestro_nombre}`} style={{ cursor: 'pointer' }} >Generar nota</a></li>
                                                            <li><a className="bn-bono-view show-list-notes-modal" data-type="autos" data-id={`${Item.id}`} style={{ cursor: 'pointer' }} >Mostrar notas creadas</a></li>
                                                        </ul>
                                                    </div>
                                                </div>
                                            </td>
                                        </tr>
                                    )
                                })}
                                {RegistrosTabla.length == 0 && (
                                    <tr>
                                        <td className='text-center' colSpan={4}>NO SE HAN GENERADO LOS RECIBOS</td>
                                    </tr>
                                )}
                            </tbody>
                        </table>
                    </div>
                </div>
                <div className='row'>
                    <div className='col-md-5'>
                        Mostrando registros del {itemOffset == 0 ? RegistrosTabla.length == 10 ? 1 : RegistrosTabla.length : itemOffset + 1} al {itemOffset == 0 ? (RegistrosTabla.length == 10 ? itemsPerPage : RegistrosTabla.length) : RegistrosTabla.length === 10 ? (itemOffset + (itemsPerPage + 1)) : (itemOffset + (RegistrosTabla.length))} de un total de {totalRows} registros
                    </div>
                    <div className='col-md-7' style={{ textAlign: 'end' }}>
                        <Paginate handlePageClick={handlePageClick} pageCount={pageCount} />
                    </div>
                </div>
            </div>
        </div >
    )
});

export default Autos;