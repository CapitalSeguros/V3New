import React, { useState, useEffect } from 'react';
import { CallApiGet, CallApiPost } from '../../Helpers/Calls.js';
import { ShowLoading, UpperCaseField } from '../../Helpers/FGeneral.js';
import Paginate from '../captura/Paginate.jsx';

export default function TableroRecibos(props) {
    const { UrlServicio, UrlPagina } = props;
    const Id = window.jQuery("#idRegistro").val();
    const Modulo = window.jQuery("#modulo").val();
    const [registros, SetRegistros] = useState([]);
    const [itemOffset, setItemOffset] = useState(0);
    const [pageCount, setPageCount] = useState(0);
    const [totalRows, setTotalRows] = useState(0);
    const [state, SetState] = useState({
        idDocto: Id,
        txSearch: '',
        fInicial: moment().format('YYYY-MM-DD'),
        fFinal: moment().format('YYYY-MM-DD')
    });
    const itemsPerPage = 10;

    const handlePageClick = (event) => {
        const newOffset = (event.selected * itemsPerPage) % totalRows;
        setItemOffset(newOffset);
        getData(newOffset);
    };

    async function getData(Offset = 0) {
        ShowLoading();
        var params = {
            Offset: Offset,
            IDDocto: Id,
            Busqueda: state.txSearch,
            //fInicial: state.fInicial.toString(),
            //fFinal: state.fFinal.toString()
        };
        const res = await CallApiGet(`${UrlServicio}conciliacion/getallrecibo`, params, null);
        if (res.status != 200) {
            toastr.error(`Error ${res.error.Mensaje}`);
        } else {
            setPageCount(Math.ceil(res.success.Count / itemsPerPage));
            setTotalRows(res.success.Count);
            SetRegistros(res.success.Datos);
        }
        ShowLoading(false);
    }

    function EditItem(Id, Documento) {
        window.location = UrlPagina + `servicioSistema/recibo/` + Id + "/" + Documento + "/" + Modulo;
    }


    function handleInput(e) {
        const { value, name } = e.target;
        SetState({ ...state, [name]: UpperCaseField(value) });
    }

    function FormatItem(value) {
        var _return = parseFloat(value ? value : 0);
        return (_return).toLocaleString('es-MX', { style: 'currency', currency: 'MXN' })
    }
    function ReturnDocument() {
        var page = Modulo == "P" ? `servicioSistema/OrdenTrabajoEdit/${Id}` : `servicioSistema/FianzaEdit/${Id}`;
        window.location = UrlPagina + page;
    }

    function getEstatus(Estatus) {
        var rEstatus = "N/A";
        var CEstatus = Estatus != null ? 'Conciliado' : 'N/A';
        /*  switch (CEstatus) {
             case 'Aplicado':
             case 'Liquidado':
                 rEstatus = "Conciliado";
                 break;
 
             default:
                 break;
         } */
        //return rEstatus;
        return CEstatus;
    }

    useEffect(async () => {
        getData();
    }, []);

    return (
        <>
            <div className='row mb-3'>
                <div className="col-sm-2">
                    <label>Buscar </label>
                    <input type="text" placeholder="Buscar..." id="txSearch" className="form-control input-sm" name="txSearch" value={state.txSearch ? state.txSearch : ''} onChange={handleInput} />
                </div>
                {/*<div className="col-sm-2">
                    <label>Fecha inicial </label>
                    <input type="date" id="fInicial" className="form-control input-sm" name="fInicial" value={state.fInicial ? state.fInicial : moment().format('YYYY-MM-DD')} onChange={handleInput} />
                </div>
                <div className="col-sm-2">
                    <label>Fecha final </label>
                    <input type="date" id="fFinal" className="form-control input-sm" name="fFinal" value={state.fFinal ? state.fFinal : moment().format("YYYY-MM-DD")} onChange={handleInput} />
                </div>*/}
                <div className='col-sm-2' style={{ paddingTop: '25px' }}>
                    <a id="btnADD" className="btn btn-primary Nuevo" onClick={async () => getData()}><i className="fa fa-search" aria-hidden="true"></i></a>
                </div>
                <div className="col-md-8 text-right" style={{ marginTop: '15px' }}>
                    {/*<a id="btnADD" className="btn btn-primary Nuevo" onClick={() => DowloadFile()}><i className="fa fa-download" aria-hidden="true"></i> Descargar</a>
                    <a id="btnADD" className="btn btn-primary Nuevo" href={`${UrlPagina}servicioSistema/${Modulo == "P" ? 'OrdenTrabajoNew' : 'FianzaAdd'}`}><i className="fa fa-plus" aria-hidden="true"></i> Nuevo</a>*/}
                    <a id="btnDocumento" className="btn btn-primary" onClick={async () => ReturnDocument()}><i className="fa fa-reply" aria-hidden="true"></i> Regresar al documento</a>
                </div>
            </div>
            <div className="row">
                <div className="col-md-12">
                    <table className="table table-condensed" id="recibos">
                        <thead>
                            <tr>
                                {/* <th scope="col">Id</th> */}
                                <th scope="col" style={{ width: '200px' }}>Documento</th>
                                <th scope="col" style={{ width: '200px' }}>Endoso</th>
                                <th scope="col" style={{ width: '200px' }}>Serie</th>
                                <th scope="col" style={{ width: '200px' }}>FDesde</th>
                                <th scope="col" style={{ width: '200px' }}>FHasta</th>
                                <th scope="col" style={{ width: '200px' }}>FLimPago</th>
                                <th scope="col" style={{ width: '200px' }}>PrimaTotal</th>
                                <th scope="col" style={{ width: '200px' }}>Derechos</th>
                                <th scope="col" style={{ width: '200px' }}>Estatus</th>
                                <th scope="col" style={{ width: '200px' }}>Comisión</th>
                                <th scope="col" style={{ width: '100px' }}>Acciones</th>
                            </tr>
                        </thead>
                        <tbody style={{ maxHeight: '400px', overflow: 'auto' }}>
                            {registros.length == 0 && (
                                <tr className='text-center'><td colSpan={11}>No hay registros de captura.</td></tr>
                            )}
                            {registros && registros.map((item, key) => (
                                <tr key={key}>
                                    <td>{item.Documento ? item.Documento : 'N/A'}</td>
                                    <td>{item.Endoso ? item.Endoso : 'N/A'}</td>
                                    <td>{item.Serie ? item.Serie : 'N/A'}</td>
                                    <td>{moment(item.FDesde).format("DD/MM/YYYY")}</td>
                                    <td>{moment(item.FHasta).format("DD/MM/YYYY")}</td>
                                    <td>{moment(item.FLimPago).format("DD/MM/YYYY")}</td>
                                    <td>{item.PrimaTotal ? FormatItem(item.PrimaTotal) : 'N/A'}</td>
                                    <td>{item.Derechos ? item.Derechos : 'N/A'}</td>
                                    <td>{item.Status_TXT ? item.Status_TXT : 'N/A'}</td>
                                    <td>{getEstatus(item.CFolio)}</td>
                                    <td>
                                        <div className="col-md-12">
                                            <div style={{ textAlign: 'right' }} >
                                                <div className="dropdown">
                                                    <button className="btn btn-link dropdown-toggle" type="button" id={`Id_${item.IDDocto}`} data-toggle="dropdown" aria-haspopup="true" aria-expanded="true" >
                                                        <i className="fa fa-ellipsis-v" aria-hidden="true"></i>
                                                    </button>
                                                    <ul className="dropdown-menu dropdown-menu-right" aria-labelledby={`Id_${item.IDDocto}`}>
                                                        <li><a className="bn-bono-view" style={{ cursor: 'pointer' }} onClick={() => EditItem(item.IDRecibo, item.Documento.trim())} data-permiso="permiso" data-accion-permiso="Editar">Editar</a></li>
                                                    </ul>
                                                </div>
                                            </div>
                                        </div>
                                    </td>
                                </tr>
                            ))}
                        </tbody>
                    </table>
                </div>
            </div>
            <div className='col-md-5'>
                Mostrando registros del {itemOffset == 0 ? registros.length == 10 ? 1 : registros.length : itemOffset + 1} al {itemOffset == 0 ? (registros.length == 10 ? itemsPerPage : registros.length) : registros.length === 10 ? (itemOffset + (itemsPerPage + 1)) : (itemOffset + (registros.length))} de un total de {totalRows} registros
            </div>
            <div className='col-md-7' style={{ textAlign: 'end' }}>
                <Paginate handlePageClick={handlePageClick} pageCount={pageCount} />
            </div>
        </>
    )
}
