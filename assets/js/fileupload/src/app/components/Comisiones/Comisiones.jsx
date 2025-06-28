import React, { useState, useEffect, useRef } from 'react';
import Select from "react-select";
import { CallApiGet, CallApiPost } from '../../Helpers/Calls.js';
import { colourStyles, displayitemText, ShowLoading, mapitems, FocusInput, displayitem, UpperCaseField, round } from '../../Helpers/FGeneral';
import { validacionFormCobranza } from '../../Helpers/Validations.js';
import ModalCorteCom from './ModalCorteCom.jsx';

export default function Comisiones(props) {

    useEffect(() => {
        getInitial();
    }, []);
    const { UrlServicio, UrlPagina, Modulo } = props;
    const ComCorte = useRef(null);
    let Usuarios = [];
    const [generalEstate, SetGeneralState] = useState(true);
    const [errores, setErrores] = useState([]);
    const [state, SetState] = useState({
        Tipo: '',
        RTipohon: '',
        RConciliados: false,
        FiltroFechas: false,
        FDesde: "",
        FHasta: "",
        FFiltro: "",
        Opcion: "CT",
        DocumentoComision: "",
        Cliente: "",
        Compania: 0,
        FDocumento: moment().format("YYYY-MM-DD"),
    });
    const [tabla, SetTabla] = useState([]);
    const [catalogos, SetCatalogos] = useState({
        TiposHonorarios: [],
        FiltroFecha: [],
        Companias: []
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
        let data = {
            Opcion: state.Opcion,
            FiltroFechas: state.FiltroFechas,
            FDesde: state.FDesde,
            FHasta: state.FHasta,
            FFiltro: state.FFiltro,
            Compania: state.Compania,
            Cliente: state.Cliente,
            Documento: state.Documento
        };
        // valiadomso que al menos un filtro tenga valor
        var Check = false;
        var CopyDta = { ...data };
        delete CopyDta.Opcion;
        delete CopyDta.FiltroFechas;
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
        const res = await CallApiGet(`${UrlServicio}comisiones/comisionesTablero`, data, null);
        if (res.status != 200) {
            toastr.error(`Error ${res.error.Mensaje}`);
        } else {
            //console.log('espuesta', res.success)
            SetTabla(res.success.Datos);
        }
        ShowLoading(false);
    }

    async function getInitial() {
        ShowLoading();
        const res = await CallApiGet(`${UrlServicio}comisiones/initialComisiones`, {}, null);
        if (res.status != 200) {
            toastr.error(`Error ${res.error.Mensaje}`);
        } else {
            SetCatalogos(res.success.Datos.Catalogos);
        }
        ShowLoading(false);
    }
    function FormatItem(value, decimal = null) {
        var _return = parseFloat(value ? value : 0);
        return (_return).toLocaleString('es-MX', { style: 'currency', currency: 'MXN', minimumFractionDigits: decimal == null ? 2 : decimal })
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
            let TotalCantidadTabla = tabla.reduce((accumulator, current) => accumulator + (current.ImporteConvertido ? (current.Importe * current.TCDocumento) : 0), 0);
            let TotalCantidadtablaAplicados = tabla.filter(x => x.Select == true).reduce((accumulator, current) => accumulator + (current.ImporteConvertido ? (current.Importe * current.TCDocumento) : 0), 0);
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
                const res = await CallApiPost(`${UrlServicio}comisiones/postComisiones`, { data: data }, null);
                if (res.status != 200) {
                    toastr.error(`Error ${res.error.Mensaje}`);
                } else {
                    SetTabla(res.success.Datos);
                    //SetState({});
                    SetState({
                        Tipo: '',
                        RTipohon: '',
                        RConciliados: false,
                        FiltroFechas: false,
                        FDesde: "",
                        FHasta: "",
                        FFiltro: "",
                        Opcion: "CT",
                        Documento: "",
                        Compania: 0,
                        FDocumento: moment().format("YYYY-MM-DD"),
                    })
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



        //console.log("Data",data);
    }

    function DowloadFile() {
        //var Filter = $("#txSearch").val();
        let data = {
            Opcion: state.Opcion,
            FiltroFechas: state.FiltroFechas,
            FDesde: state.FDesde,
            FHasta: state.FHasta,
            FFiltro: state.FFiltro,
            Compania: state.Compania,
            Cliente: state.Cliente,
            Documento: state.Documento
        };
        var Qparams = new URLSearchParams(data);
        return window.open(`${UrlServicio}comisiones/comisionReporte?${Qparams}`, '_blank');
    }

    function OpenCorte() {
        //$("#ModalCorteHon").modal('show');
        ComCorte.current.Initial();
    }

    return (
        <div className='row'>
            {/*  <div className='col-md-4'>
                <div className="row">
                    <div className="col-md-12">
                        <h5>Se considerará:</h5>
                    </div>
                    <div className="col-md-12">
                        <div className="radio ">
                            <label htmlFor="CToda"><input type="radio" name="opcion" id="CToda" value={state.Opcion ? state.Opcion : ''} onChange={(e) => handleChange("CT", 'Opcion')} checked={state.Opcion == "CT" ? 'cheked' : ''} />Toda la Cobranza</label>
                        </div>
                        <div className="radio">
                            <label htmlFor="CEfectuada"><input type="radio" name="opcion" id="CEfectuada" value={state.Opcion ? state.Opcion : ''} onChange={(e) => handleChange("CE", 'Opcion')} checked={state.Opcion == "CE" ? true : false} />Cobranza Efectuada</label>
                        </div>
                        <div className="radio">
                            <label htmlFor="CPendiente"><input type="radio" name="opcion" id="CPendiente" value={state.Opcion ? state.Opcion : ''} onChange={(e) => handleChange("CP", 'Opcion')} checked={state.Opcion == "CP" ? true : false} /> Cobranza Pendiente</label>
                        </div>
                    </div>
                </div>
            </div> */}
            <div className="col-md-12">
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
                    <div className="col-md-4">
                        <div className="form-group">
                            <label>Desde</label>
                            <input disabled={!state.FiltroFechas} type="date" id="FDesde" name="FDesde" value={state.FDesde} onChange={handleChange} className="form-control input-sm" />
                        </div>
                    </div>
                    <div className="col-md-4">
                        <div className="form-group">
                            <label>Hasta</label>
                            <input disabled={!state.FiltroFechas} type="date" id="FHasta" name="FHasta" value={state.FHasta} onChange={handleChange} className="form-control input-sm" />
                        </div>
                    </div>
                    <div className="col-md-4">
                        <div className='form-group'>
                            <label>Filtro de Fecha</label>
                            <Select
                                isDisabled={!state.FiltroFechas}
                                placeholder="Selecione"
                                id="FFiltro"
                                name="FFiltro"
                                styles={colourStyles}
                                onChange={v => { handleChange(v.value, 'FFiltro') }}
                                //onBlur={handleBlur}
                                value={displayitemText(state.FFiltro, catalogos.FiltroFecha)}
                                options={mapitems(catalogos.FiltroFecha ? catalogos.FiltroFecha : [], '')}
                                noOptionsMessage={() => "Sin opciones"}
                            />
                            {/* <span className="help-block">{errors.Estatus}</span> */}
                        </div>
                    </div>
                </div>
                <div className='row'>
                    <div className='col-md-3'>
                        <div className='form-group'>
                            <label htmlFor="txMotivo">Compañia</label>
                            <Select
                                placeholder="Selecione un estatus"
                                id="Compania"
                                name="Compania"
                                styles={colourStyles}
                                onChange={v => {
                                    handleChange(v.value, "Compania")
                                }}
                                //onBlur={() => GetAllConfig()}
                                value={displayitem(state.Compania, catalogos.Companias)}
                                options={mapitems(catalogos.Companias ? catalogos.Companias : [], '')}
                                noOptionsMessage={() => "Sin opciones"}
                            />
                        </div>
                    </div>
                    <div className='col-md-3'>
                        <div className='form-group'>
                            <label>Cliente</label>
                            <input
                                className="form-control input-sm"
                                type="text"
                                name="Cliente"
                                id="Cliente"
                                //placeholder='Ingrese un Documento'
                                //onChange={handleChange}
                                onChange={(e) => { handleChange(UpperCaseField(e.target.value), 'Cliente') }}
                                onFocus={FocusInput}
                                value={state.Cliente ? state.Cliente : ''}
                            />
                        </div>
                    </div>
                    <div className='col-md-3'>
                        <div className='form-group'>
                            <label>Documento</label>
                            <input
                                className="form-control input-sm"
                                type="text"
                                name="Documento"
                                id="Documento"
                                //placeholder='Ingrese un Documento'
                                //onChange={handleChange}
                                onChange={(e) => { handleChange(UpperCaseField(e.target.value), 'Documento') }}
                                onFocus={FocusInput}
                                value={state.Documento ? state.Documento : ''}
                            />
                        </div>
                    </div>
                    <div className="col-md-3">
                        <a className="btn btn-primary" onClick={() => getTablero()} style={{ marginTop: '20px', width: '100%' }}><i className="fa fa-file-text-o"></i> Generar</a>
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
                                        <th scope="col" style={{ width: '200px' }}>Tipo Comisión</th>
                                        <th scope="col" style={{ width: '100px' }}>Tipo Valor</th>
                                        <th scope="col" style={{ width: '100px' }}>Participacion</th>
                                        <th scope="col" style={{ width: '100px' }}>Importe</th>
                                        <th scope="col" style={{ width: '150px' }}>Moneda Documento</th>
                                        <th scope="col" style={{ width: '100px' }}>TC Documento</th>
                                        <th scope="col" style={{ width: '150px' }}>Moneda Pago</th>
                                        <th scope="col" style={{ width: '100px' }}>TC Pago</th>
                                        {/* <th scope="col" style={{ width: '100px' }}>Importe Pago</th> */}
                                        <th scope="col" style={{ width: '100px' }}>Comisión</th>
                                        {/* <th scope="col" style={{ width: '100px' }}>Importe Convertido</th> */}
                                        {/* <th scope="col" style={{ width: '200px' }}>Cliente</th> */}
                                        <th scope="col" style={{ width: '200px' }}>Compañia</th>
                                        <th scope="col" style={{ width: '150px' }}>Forma Pago</th>
                                        <th scope="col" style={{ width: '100px' }}>Fecha Estatus</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    {tabla.length == 0 && (
                                        <tr key={'randoim'}>
                                            <td className='text-center' colSpan={18}>NO SE HA FILTRADO INFORMACIÓN</td>
                                        </tr>
                                    )}
                                    {tabla && tabla.map((item, key) => (
                                        <>
                                            {!Usuarios.includes(item.Compañia) && (
                                                <tr key={`Cliente-${key}_${item.Id}`}>
                                                    <th scope="row" colSpan="18">{item.Compañia}</th>
                                                </tr>
                                            )}
                                            {Usuarios.push(item.Compañia) && (null)}
                                            <tr key={`row-${key}_${item.Id}`}>
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
                                                <td>{moment(item.FDesde).format("DD/MM/YYYY")}</td>
                                                <td>{item.Serie}</td>
                                                <td>{item.TipoComision}</td>
                                                <td>{item.TipoValor}</td>
                                                <td>{item.Participacion}</td>
                                                <td>{FormatItem(item.Importe)}</td>
                                                <td>{item.MonedaDoc}</td>
                                                <td>{item.TCDocumento}</td>
                                                <td>{item.MonedaPago}</td>
                                                <td>{item.TCPago}</td>
                                                {/* <td>{FormatItem(item.ImportePago)}</td> */}
                                                {/* <td>{FormatItem(item.ImporteConvertido, 2)}</td> */}
                                                <td>{FormatItem((item.TCDocumento * round(item.Importe, 2)), 2)}</td>
                                                <td>{item.Compañia}</td>
                                                <td>{item.FormaPago}</td>
                                                <td>{moment(item.FEstatus).format("DD/MM/YYYY")}</td>
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
                            <input autocomplete="off" type="date" id="FDocumento" name="FDocumento" value={state.FDocumento ? state.FDocumento : ''} onChange={handleChange} className="form-control input-sm" />
                            <span className="help-block">{errores.FDocumento ? 'Requerido.' : ''}</span>
                        </div>
                    </div>
                    <div className="col-md-2">
                        <div className="form-group">
                            <label>Documento</label>
                            <input autocomplete="off" type="text" id="DocumentoComision" name="DocumentoComision" value={state.DocumentoComision ? state.DocumentoComision : ''} onChange={(e) => { handleChange(UpperCaseField(e.target.value), 'DocumentoComision') }} className="form-control input-sm" />
                            <span className="help-block">{errores.DocumentoComision ? 'Requerido.' : ''}</span>
                        </div>
                    </div>
                    <div className="col-md-2">
                        <div className="form-group">
                            <label>Folio</label>
                            <input autocomplete="off" type="text" id="Folio" name="Folio" value={state.Folio ? state.Folio : ''} onChange={(e) => { handleChange(UpperCaseField(e.target.value), 'Folio') }} className="form-control input-sm" />
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
            <ModalCorteCom ref={ComCorte} UrlServicio={UrlServicio} Companias={catalogos.Companias} />
        </div>
    )
}
