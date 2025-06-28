import React, { useState, useEffect, useRef } from 'react';
import Select from "react-select";
import { CallApiGet, CallApiPost } from '../../Helpers/Calls.js';
import { colourStyles, displayitemText, ShowLoading, mapitems, FocusInput, displayitem, UpperCaseField, round } from '../../Helpers/FGeneral.js';
import { validacionFormCobranza } from '../../Helpers/Validations.js';
import ModalCorteHon from './ModalCorteHon.jsx';

export default function Honorarios(props) {

    useEffect(() => {
        getInitial();
    }, []);
    const { UrlServicio, UrlPagina, Modulo } = props;
    const HonCorte = useRef(null);
    let Usuarios = [];
    const [errores, setErrores] = useState([]);
    const [generalEstate, SetGeneralState] = useState(true);
    const [state, SetState] = useState({
        Tipo: 'Recibos',
        RTipohon: '',
        RConciliados: false,
        FiltroFechas: false,
        FDesde: "",
        FHasta: "",
        FFiltro: "",
        Clave: "",
        IDVend: 0,
        EstadoU: 0,
        FDocumento: moment().format("YYYY-MM-DD"),
        DocumentoComision: ""
    });
    const [tabla, SetTabla] = useState([]);
    const [prestamos, SetPrestamos] = useState([]);
    const [catalogos, SetCatalogos] = useState({
        TiposHonorarios: [],
        FiltroFecha: [],
        Vendedores: [],
        Estatus: []
    });
    useEffect(() => {
        Concentrado();
    }, [tabla])

    function handleChange(e, Campo = '') {
        //console.log(`${e} | ${Campo}`)
        if (Campo != '')
            SetState({ ...state, [Campo]: e });
        else
            SetState({ ...state, [e.target.name]: e.target.value });

    }

    async function getTablero() {
        ShowLoading();
        var Check = false;
        var CopyDta = { ...state };
        delete CopyDta.Tipo;
        delete CopyDta.FiltroFechas;
        delete CopyDta.RConciliados;
        delete CopyDta.FDocumento;
        delete CopyDta.TotalRegistros;
        delete CopyDta.TotalRegistrosAplicados;
        delete CopyDta.Pendientes;
        delete CopyDta.PendientesAplicado;
        let validateObject = Object.values(CopyDta);
        for (let value of validateObject) {
            //console.log("value", value)
            if (value) {
                Check = true;
            }
        }
        if (!Check) {
            ShowLoading(false);
            return toastr.error(`Ingrese al menos un filtro.`);

        }
        const res = await CallApiGet(`${UrlServicio}honorarios/honorariosTablero`, state, null);
        if (res.status != 200) {
            toastr.error(`Error ${res.error.Mensaje}`);
        } else {
            SetTabla(res.success.Datos.Honorarios);
            SetPrestamos(res.success.Datos.Prestamos);
        }
        ShowLoading(false);
    }

    async function getInitial() {
        ShowLoading();
        const res = await CallApiGet(`${UrlServicio}honorarios/initialHonorarios`, {}, null);
        if (res.status != 200) {
            toastr.error(`Error ${res.error.Mensaje}`);
        } else {
            SetCatalogos(res.success.Datos.Catalogos);
        }
        ShowLoading(false);
    }
    function FormatItem(value) {
        var _return = parseFloat(value ? value : 0);
        return (_return).toLocaleString('es-MX', { style: 'currency', currency: 'MXN' })
    }

    function selectAll() {
        SetGeneralState(!generalEstate);
        //console.log("General", generalEstate)
        let clone = [...tabla];
        clone.forEach(element => {
            element.Select = generalEstate;
            element.Pagado = generalEstate ? 1 : 0;
        });
        SetTabla(clone);
    }

    function CheckIndividual(index) {
        let clone = [...tabla];
        clone[index].Select = !clone[index].Select;
        clone[index].Pagado = clone[index].Select == true ? 1 : 0;
        SetTabla(clone);
    }

    function Concentrado() {
        let ClonState = { ...state };
        if (tabla.length > 0) {
            let TotalRegistros = tabla.length;
            let TotalAplicados = tabla.filter(x => x.Select == true).length;
            let TotalCantidadTabla = tabla.reduce((accumulator, current) => accumulator + (current.ImporteConvertido ? current.ImporteConvertido : 0), 0);
            let TotalCantidadtablaAplicados = tabla.filter(x => x.Select == true).reduce((accumulator, current) => accumulator + (current.ImporteConvertido ? current.ImporteConvertido : 0), 0);
            //let TotalCantidadTabla = tabla.reduce((accumulator, current) => accumulator + (current.Importe ? current.Importe : 0), 0);
            //let TotalCantidadtablaAplicados = tabla.filter(x => x.Select == true).reduce((accumulator, current) => accumulator + (current.Importe ? current.Importe : 0), 0);

            SetState({
                ...state,
                TotalRegistros: TotalRegistros,
                TotalRegistrosAplicados: TotalAplicados,
                Pendientes: FormatItem(TotalCantidadTabla),
                PendientesAplicado: FormatItem(TotalCantidadtablaAplicados)
            })
        }
    }

    async function Save() {

        if (state.TotalRegistrosAplicados == 0) {
            return swal({
                title: "Aplicar registros",
                text: "No se ha seleccionado ningún registro de la tabla.",
                icon: "warning",
                confirmButtonText: "Aceptar",
                confirmButtonColor: "#472380"
            });
        }
        validacionFormCobranza.validate(state, { abortEarly: false })
            .then(async (responseData) => {
                let CloneTabla = [...tabla];
                let Comisones = CloneTabla.filter(x => x.Select == true).map((x) => {
                    return x.Id;
                });
                var data = {
                    "Comisiones": Comisones,
                    "CDocumento": state.DocumentoComision,
                    "CFolio": state.Folio,
                    "FDocumento": state.FDocumento
                }

                ShowLoading();
                const res = await CallApiPost(`${UrlServicio}honorarios/postHonorarios`, { data: data }, null);
                if (res.status != 200) {
                    toastr.error(`Error ${res.error.Mensaje}`);
                } else {
                    SetTabla(res.success.Datos);
                    SetState({
                        Tipo: 'Recibos',
                        RTipohon: '',
                        RConciliados: false,
                        FiltroFechas: false,
                        FDesde: "",
                        FHasta: "",
                        FFiltro: "",
                        Clave: "",
                        IDVend: 0,
                        EstadoU: 0
                    });
                }
                ShowLoading(false);
                setErrores([]);
            })
            .catch((err) => {
                const errors = err.inner.reduce((acc, error) => {
                    return {
                        ...acc,
                        [error.path]: true,
                    }
                }, {})
                setErrores(errors);
                //setErrores(err.errors);
            });

    }

    function DowloadFile() {
        //var Filter = $("#txSearch").val();
        var Qparams = new URLSearchParams(state);
        return window.open(`${UrlServicio}honorarios/honorariosReporte?${Qparams}`, '_blank');
    }

    function OpenCorte() {
        //$("#ModalCorteHon").modal('show');
        HonCorte.current.Initial();
    }

    return (
        <div className='row'>
            {/* <div className='col-md-6'>
                <div className='row'>
                    <div className='col-md-12'>
                        <ul className="nav nav-tabs nav-justified" id="general" role="tablist">
                            <li className="nav-item navr">
                                <a className="nav-link active" onClick={() => handleChange("Anticipos", 'Tipo')} id="home-tab" data-toggle="tab" href="#datos-anticipos" role="tab" aria-controls="datos-anticipos" aria-selected="true">Anticipos</a>
                            </li>
                            <li className="nav-item navr">
                                <a className="nav-link" onClick={() => handleChange("Documentos", 'Tipo')} id="home-documentos" data-toggle="tab" href="#datos-documentos" role="tab" aria-controls="datos-documentos" aria-selected="true">Documentos</a>
                            </li>
                            <li className="nav-item navr">
                                <a className="nav-link" onClick={() => handleChange("Recibos", 'Tipo')} id="home-recibos" data-toggle="tab" href="#datos-recibos" role="tab" aria-controls="datos-recibos" aria-selected="true">Recibos</a>
                            </li>
                        </ul>
                    </div>
                    <div className='col-md-12'>
                        <div className="tab-content" id="generalTabContent">
                            <div className="tab-pane fade active show in" id="datos-anticipos" role="tabpanel" aria-labelledby="datos-anticipos-tab">
                                <div className="row">
                                    <div className="col-md-12">
                                        <div>
                                            <input className="form-check-input" type="checkbox" value="" id="ADocumentos" />
                                            <label className="form-check-label" htmlFor="ADocumentos" style={{ paddingLeft: "20px", paddingBottom: '10px' }}>
                                                Documentos
                                            </label>
                                        </div>
                                    </div>
                                    <div className="col-md-12">
                                        <div>
                                            <input className="form-check-input" type="checkbox" value="" id="AEndosos" />
                                            <label className="form-check-label" htmlFor="AEndosos" style={{ paddingLeft: "20px", paddingBottom: '10px' }}>
                                                Endosos
                                            </label>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div className="tab-pane fade" id="datos-documentos" role="tabpanel" aria-labelledby="datos-documentos-tab">
                                <div className='row'>
                                    <div className='col-md-12'>
                                        <div className="form-group">
                                            <label>Tipo Honorario</label>
                                            <Select
                                                placeholder="Selecione una opción"
                                                id="DTipohon"
                                                name="DTipohon"
                                                styles={colourStyles}
                                                onChange={v => { handleChange(v.label, 'RTipohon') }}
                                                //onBlur={handleBlur}
                                                value={displayitemText(state.DTipohon, catalogos.TiposHonorarios)}
                                                options={mapitems(catalogos.TiposHonorarios ? catalogos.TiposHonorarios : [], '')}
                                                noOptionsMessage={() => "Sin opciones"}
                                            />
                                        </div>
                                    </div>
                                    <div className="col-md-12">
                                        <div>
                                            <input className="form-check-input" type="checkbox" value="" id="DDocumentos" />
                                            <label className="form-check-label" htmlFor="DDocumentos" style={{ paddingLeft: "20px", paddingBottom: '10px' }}>
                                                Documentos
                                            </label>
                                        </div>
                                    </div>
                                    <div className="col-md-12">
                                        <div>
                                            <input className="form-check-input" type="checkbox" value="" id="DEndosos" />
                                            <label className="form-check-label" htmlFor="DEndosos" style={{ paddingLeft: "20px", paddingBottom: '10px' }}>
                                                Endosos
                                            </label>
                                        </div>
                                    </div>
                                    <div className="col-md-12">
                                        <div>
                                            <input className="form-check-input" type="checkbox" value="" id="DPagoPrima" />
                                            <label className="form-check-label" htmlFor="DPagoPrima" style={{ paddingLeft: "20px", paddingBottom: '10px' }}>
                                                Validar Pago de Prima
                                            </label>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div className="tab-pane fade" id="datos-recibos" role="tabpanel" aria-labelledby="datos-recibos-tab">
                                <div className='row'>
                                    <div className='col-md-12'>
                                        <div className="form-group">
                                            <label>Tipo Honorario</label>
                                            <Select
                                                placeholder="Selecione una opción"
                                                id="RTipohon"
                                                name="RTipohon"
                                                styles={colourStyles}
                                                onChange={v => { handleChange(v.label, 'RTipohon') }}
                                                //onBlur={handleBlur}
                                                value={displayitemText(state.RTipohon, catalogos.TiposHonorarios)}
                                                options={mapitems(catalogos.TiposHonorarios ? catalogos.TiposHonorarios : [], '')}
                                                noOptionsMessage={() => "Sin opciones"}
                                            />
                                        </div>
                                    </div>
                                    <div className="col-md-12">
                                        <div>
                                            <input className="form-check-input" type="checkbox" value="" id="RConciliados" />
                                            <label className="form-check-label" htmlFor="RConciliados" style={{ paddingLeft: "20px", paddingBottom: '10px' }}>
                                                Solo recibos conciliados
                                            </label>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div> */}
            <div className='col-md-3'>
                <div className='row'>
                    <div className='col-md-12'>
                        <div className="form-group">
                            <label>Tipo Honorario</label>
                            <Select
                                placeholder="Selecione una opción"
                                id="RTipohon"
                                name="RTipohon"
                                styles={colourStyles}
                                onChange={v => { handleChange(v.value, 'RTipohon') }}
                                //onBlur={handleBlur}
                                value={displayitem(state.RTipohon, catalogos.TiposHonorarios)}
                                options={mapitems(catalogos.TiposHonorarios ? catalogos.TiposHonorarios : [], '')}
                                noOptionsMessage={() => "Sin opciones"}
                            />
                        </div>
                    </div>
                    <div className="col-md-12">
                        <div>
                            {/* <a className='btn' onClick={()=>console.log("test",state)}>state</a> */}
                            <input className="form-check-input" type="checkbox" value={state.RConciliados} checked={state.RConciliados} onChange={(e) => handleChange(e.target.checked, 'RConciliados')} id="RConciliados" />
                            <label className="form-check-label" htmlFor="RConciliados" style={{ paddingLeft: "20px", paddingBottom: '10px' }}>
                                Solo recibos conciliados
                            </label>
                        </div>
                    </div>
                </div>
            </div>
            <div className='col-md-4'>
                <div className='row'>
                    <div className='col-md-12'>
                        <div className='form-group'>
                            <label htmlFor="txMotivo">Filtros de Vendedor</label>
                            <Select
                                placeholder="Selecione un vendedor"
                                id="IDVend"
                                name="IDVend"
                                styles={colourStyles}
                                onChange={v => {
                                    handleChange(v.value, "IDVend")
                                }}
                                value={displayitem(state.IDVend, catalogos.Vendedores)}
                                options={mapitems(catalogos.Vendedores ? catalogos.Vendedores : [], '')}
                                noOptionsMessage={() => "Sin opciones"}
                            />
                        </div>
                    </div>
                    <div className='col-md-12'>
                        <div className='form-group'>
                            {/* <label> Clave</label> */}
                            <input
                                className="form-control input-sm"
                                type="text"
                                name="Clave"
                                id="Clave"
                                placeholder='Ingrese una Clave'
                                //onChange={handleChange}
                                onChange={(e) => { handleChange(UpperCaseField(e.target.value), 'Clave') }}
                                onFocus={FocusInput}
                                value={state.Clave ? state.Clave : ''}
                            />
                        </div>
                    </div>
                    <div className='col-md-12'>
                        <div className='form-group'>
                            {/*  <label htmlFor="txMotivo">Estatus</label> */}
                            <Select
                                placeholder="Selecione un estatus"
                                id="EstadoU"
                                name="EstadoU"
                                styles={colourStyles}
                                onChange={v => {
                                    handleChange(v.value, "EstadoU")
                                }}
                                //onBlur={() => GetAllConfig()}
                                value={displayitem(state.EstadoU, catalogos.Estatus)}
                                options={mapitems(catalogos.Estatus ? catalogos.Estatus : [], '')}
                                noOptionsMessage={() => "Sin opciones"}
                            />
                        </div>
                    </div>
                    {/* <div className='col-md-12'>
                        <button className='btn' onClick={() => console.log('test', state)}>test</button>
                    </div> */}
                </div>
            </div>
            <div className="col-md-5">
                <div className="row">
                    <div className="col-md-12">
                        <div>
                            <input className="form-check-input" type="checkbox" value={state.FiltroFechas} onChange={(e) => handleChange(e.target.checked, 'FiltroFechas')} id="FiltroFechas" />
                            <label className="form-check-label" htmlFor="FiltroFechas" style={{ paddingLeft: "20px", paddingBottom: '10px' }}>
                                Aplicar rango de Fechas
                            </label>
                        </div>
                    </div>
                </div>
                <div className="row">
                    <div className="col-md-6">
                        <div className="form-group">
                            <label>Desde</label>
                            <input disabled={!state.FiltroFechas} type="date" id="FDesde" name="FDesde" value={state.FDesde} onChange={handleChange} className="form-control input-sm" />
                        </div>
                    </div>
                    <div className="col-md-6">
                        <div className="form-group">
                            <label>Hasta</label>
                            <input disabled={!state.FiltroFechas} type="date" id="FHasta" name="FHasta" value={state.FHasta} onChange={handleChange} className="form-control input-sm" />
                        </div>
                    </div>
                </div>
                <div className="row">
                    <div className="col-md-6">
                        <div className='form-group'>
                            <label>Filtro de Fecha</label>
                            <Select
                                isDisabled={!state.FiltroFechas}
                                placeholder="Selecione Opc"
                                id="FFiltro"
                                name="FFiltro"
                                styles={colourStyles}
                                onChange={v => { handleChange(v.label, 'FFiltro') }}
                                //onBlur={handleBlur}
                                value={displayitemText(state.FFiltro, catalogos.FiltroFecha)}
                                options={mapitems(catalogos.FiltroFecha ? catalogos.FiltroFecha : [], '')}
                                noOptionsMessage={() => "Sin opciones"}
                            />
                            {/* <span className="help-block">{errors.Estatus}</span> */}
                        </div>
                    </div>
                    <div className="col-md-6">
                        <a className="btn btn-primary" onClick={() => getTablero()} style={{ marginTop: '20px', width: '100%' }}><i className="fa fa-file-text-o"></i> Buscar</a>
                        {/* <a className="btn btn-primary" onClick={()=>console.log(state)}>test</a> */}
                    </div>
                </div>
            </div>

            <div className="col-md-12 pt-3">
                <div className="row">
                    <div className="col-md-6">
                        <h5>FILTRADO DE LA INFORMACIÓN</h5>
                    </div>
                    <div className="col-md-6">
                        <div className="row">
                            <div className="col-md-12 btn-row text-right">
                                <a className="btn btn-primary btn-s mr-2" disabled={tabla.length == 0 ? true : false} data-toggle="tooltip" data-placement="bottom" title="Seleccionar todo" onClick={() => selectAll()}><i className="fa fa-check-square-o" aria-hidden="true"></i></a>
                                <a className="btn btn-primary btn-s mr-2" disabled={tabla.length == 0 ? true : false} data-toggle="tooltip" data-placement="bottom" title="Descargar Documento" onClick={() => DowloadFile()}><i className="fa fa-file-o" aria-hidden="true"></i></a>
                                <a className="btn btn-primary btn-s mr-2" type="submit" data-toggle="tooltip" data-placement="bottom" title="Cortes" onClick={() => OpenCorte()}><i className="fa fa-archive" aria-hidden="true"></i></a>
                                <a className="btn btn-primary btn-s mr-2" disabled={tabla.length == 0 ? true : false} type="submit" data-toggle="tooltip" data-placement="bottom" title="Guardar/Aplicar" onClick={() => Save()}><i className="fa fa-floppy-o" aria-hidden="true"></i></a>
                                {/* <a className="btn btn-primary btn-s mr-2" onClick={()=>console.log("Estado",state)}>test</a> */}
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div className="col-md-12">
                <div className="row">
                    <div className="col-md-12" style={{ maxHeight: '1117px' }}>
                        <div className="table-wrapperH" id="Honorarios">
                            <table className="table">
                                <thead>
                                    <tr>
                                        <th scope="col" style={{ width: '75px' }}>Pagado</th>
                                        <th scope="col" style={{ width: '200px' }}>Documento</th>
                                        <th scope="col" style={{ width: '100px' }}>Endoso</th>
                                        <th scope="col" style={{ width: '100px' }}>Desde</th>
                                        <th scope="col" style={{ width: '100px' }}>Serie</th>
                                        <th scope="col" style={{ width: '200px' }}>Tipo Honorario</th>
                                        <th scope="col" style={{ width: '100px' }}>Tipo Valor</th>
                                        <th scope="col" style={{ width: '100px' }}>Participación</th>
                                        <th scope="col" style={{ width: '100px' }}>Importe</th>
                                        <th scope="col" style={{ width: '150px' }}>Moneda Documento</th>
                                        <th scope="col" style={{ width: '100px' }}>TC Documento</th>
                                        <th scope="col" style={{ width: '150px' }}>Moneda Pago</th>
                                        <th scope="col" style={{ width: '100px' }}>TC Pago</th>
                                        <th scope="col" style={{ width: '100px' }}>Importe Pago</th>
                                        <th scope="col" style={{ width: '100px' }}>Importe Honorario</th>
                                        {/* <th scope="col" style={{ width: '200px' }}>Cliente</th> */}
                                        <th scope="col" style={{ width: '200px' }}>Compañia</th>
                                        <th scope="col" style={{ width: '150px' }}>Forma Pago</th>
                                        <th scope="col" style={{ width: '100px' }}>Fecha Estatus</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    {tabla.length == 0 && (
                                        <tr>
                                            <td className='text-center' colSpan={18}>NO SE HA FILTRADO INFORMACIÓN</td>
                                        </tr>
                                    )}
                                    {tabla && tabla.map((item, key) => (

                                        <>
                                            {!Usuarios.includes(item.VendNom) && (
                                                <tr key={`Cliente-${key}`}>
                                                    <th scope="row" colSpan="14">{item.VendNom}</th>
                                                    <th scope="row" colSpan="2">Total Honorarios: {FormatItem(tabla.filter(x => x.VendNom === item.VendNom).reduce((accumulator, current) => accumulator + (current.ImporteConvertido ? current.ImporteConvertido : 0), 0))}</th>
                                                    <th scope="row" colSpan="2">Total Prestamos: {FormatItem(prestamos.filter(x => x.VendNom === item.VendNom).reduce((accumulator, current) => accumulator + (current.ImporteFpago ? current.ImporteFpago : 0), 0))}</th>
                                                </tr>
                                            )}
                                            {Usuarios.push(item.VendNom) && (null)}
                                            <tr key={key}>
                                                {/*  <td><input type="checkbox" onClick={() => CheckIndividual(key)} onChange={() => ''} checked={item.Select ? 'checked' : ''} value={item.Select ? true : false} /> {item.Select ? "SI" : "NO"}</td> */}
                                                <td>
                                                    {item.CFolio == null ? (
                                                        <>
                                                            <input type="checkbox" onClick={() => CheckIndividual(key)} onChange={() => ''} checked={item.Select ? 'checked' : ''} value={item.Select ? true : false} /> {item.Select == 1 ? "SI" : "NO"}
                                                        </>
                                                    ) : (
                                                        <label>SI</label>
                                                    )}
                                                </td>
                                                <td>{item.Documento}</td>
                                                <td>{item.Endoso}</td>
                                                <td>{moment(item.Desde).format("DD/MM/YYYY")}</td>
                                                <td>{item.Serie}</td>
                                                <td>{item.TipoComision}</td>
                                                <td>{item.TipoValor}</td>
                                                <td>{item.Participacion}</td>
                                                <td>{FormatItem(item.Importe)}</td>
                                                <td>{item.MonedaDoc}</td>
                                                <td>{item.TCDocumento}</td>
                                                <td>{item.MonedaPago}</td>
                                                <td>{item.TCPago}</td>
                                                <td>{FormatItem(item.ImportePago)}</td>
                                                <td>{FormatItem((item.TCDocumento * round(item.Importe, 2)), 2)}</td>
                                                {/*<td>{FormatItem(item.ImporteConvertido)}</td>*/}
                                                <td>{item.Compañia}</td>
                                                <td>{item.FormaPago}</td>
                                                <td>{item.FEstatus}</td>
                                            </tr>
                                        </>
                                    ))}
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
                <div className="row pt-5">
                    <div className="col-md-2">
                        <div className="form-group">
                            <label>Fecha Documento</label>
                            <input autoComplete="off" type="date" id="FDocumento" name="FDocumento" value={state.FDocumento ? state.FDocumento : ''} onChange={handleChange} className="form-control input-sm" />
                            <span className="help-block">{errores.FDocumento ? 'Requerido.' : ''}</span>
                        </div>
                    </div>
                    <div className="col-md-2">
                        <div className="form-group">
                            <label>Documento</label>
                            <input autoComplete="off" type="text" id="DocumentoComision" name="DocumentoComision" value={state.DocumentoComision ? state.DocumentoComision : ''} onChange={(e) => { handleChange(UpperCaseField(e.target.value), 'DocumentoComision') }} className="form-control input-sm" />
                            <span className="help-block">{errores.Documento ? 'Requerido.' : ''}</span>
                        </div>
                    </div>
                    <div className="col-md-2">
                        <div className="form-group">
                            <label>Folio</label>
                            <input autoComplete="off" type="text" id="Folio" name="Folio" value={state.Folio ? state.Folio : ''} onChange={(e) => { handleChange(UpperCaseField(e.target.value), 'Folio') }} className="form-control input-sm" />
                            <span className="help-block">{errores.Folio ? 'Requerido.' : ''}</span>
                        </div>
                    </div>
                    <div className="col-md-6">
                        <div className="row">
                            <div className="col-md-6">
                                <div className="form-group">
                                    <label>Total Registros</label>
                                    <input type="text" disabled id="TotalRegistros" name="TotalRegistros" value={state.TotalRegistros ? state.TotalRegistros : ''} onChange={handleChange} className="form-control input-sm" />
                                </div>
                            </div>
                            <div className="col-md-6">
                                <div className="form-group">
                                    <label>Aplicados</label>
                                    <input type="text" disabled id="Aplicados" name="Aplicados" value={state.TotalRegistrosAplicados ? state.TotalRegistrosAplicados : ''} onChange={handleChange} className="form-control input-sm" />
                                </div>
                            </div>
                        </div>
                        <div className="row">
                            <div className="col-md-6">
                                <div className="form-group">
                                    <label>Honorarios Pendientes</label>
                                    <input type="text" disabled id="TotalRegistros" name="TotalRegistros" value={state.Pendientes ? state.Pendientes : ''} onChange={handleChange} className="form-control input-sm" />
                                </div>
                            </div>
                            <div className="col-md-6">
                                <div className="form-group">
                                    <label>Aplicados</label>
                                    <input type="text" disabled id="Aplicado" name="Aplicado" value={state.PendientesAplicado ? state.PendientesAplicado : ''} onChange={handleChange} className="form-control input-sm" />
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <ModalCorteHon ref={HonCorte} UrlServicio={UrlServicio} />
        </div>
    )
}
