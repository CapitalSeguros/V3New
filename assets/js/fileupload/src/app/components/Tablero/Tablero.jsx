import React, { useState, useEffect } from 'react';
import { CallApiGet, CallApiPost } from '../../Helpers/Calls.js';
import { ShowLoading, UpperCaseField } from '../../Helpers/FGeneral.js';
import Paginate from '../captura/Paginate.jsx';
import { isMobile } from 'react-device-detect';

export default function Tablero(props) {
    const { UrlServicio, UrlPagina, Modulo } = props;
    const [registros, SetRegistros] = useState([]);
    const [itemOffset, setItemOffset] = useState(0);
    const [pageCount, setPageCount] = useState(0);
    const [totalRows, setTotalRows] = useState(0);
    const [state, SetState] = useState({
        txSearch: '',
        TipoDocto: '0',
        FDesde: '',
        FHasta: '',
    });
    const itemsPerPage = 10;

    useEffect(async () => {
        //console.log("props", props)
        getData();
    }, []);

    //Paginacion
    useEffect(() => {
        // Fetch items from another resources.
        const endOffset = itemOffset + itemsPerPage;
        //setPageCount(Math.ceil(registros.length / itemsPerPage));
    }, [itemOffset, itemsPerPage]);

    const handlePageClick = (event) => {
        const newOffset = (event.selected * itemsPerPage) % totalRows;
        setItemOffset(newOffset);
        getData(newOffset);
    };

    async function getData(Offset = 0) {
        ShowLoading();
        var params = {
            Modulo: Modulo,
            TipoDocumento: state.TipoDocto,
            FDesde: state.FDesde,
            FHasta: state.FHasta,
            Offset: Offset,
            Busqueda: state.txSearch
        };
        const res = await CallApiGet(`${UrlServicio}capture/otV2`, params, null);
        if (res.status != 200) {
            toastr.error(`Error ${res.error.Mensaje}`);
        } else {
            setPageCount(Math.ceil(res.success.Count / itemsPerPage));
            setTotalRows(res.success.Count);
            SetRegistros(res.success.Datos);
        }
        ShowLoading(false);
    }

    function ParseItem(value) {
        var check = true;
        if (value == undefined) {
            value = '0000-00-00 00:00:00';
            check = false;
        }
        if (value == '0000-00-00 00:00:00') {
            check = false;
        }

        if (check) {
            return moment(value).format('DD/MM/YYYY');
        } else {
            return 'N/A';
        }
    }


    function EditItem(Id) {
        window.location = UrlPagina + `servicioSistema/${Modulo == 'P' ? 'OrdenTrabajoEdit' : 'FianzaEdit'}/` + Id;
    }

    function TableroRecibos(Id) {
        window.location = UrlPagina + `servicioSistema/${'recibos/' + Id + '/' + Modulo}`;
    }

    function DowloadFile() {
        //var Filter = $("#txSearch").val();
        return window.open(`${UrlServicio}capture/${Modulo == "P" ? 'docPolizas' : 'docFianzas'}?search=${state.txSearch}&Tipo=${state.TipoDocto}&FDesde=${state.FDesde}&FHasta=${state.FHasta}`, '_blank');
    }

    function handleInput(e) {
        const { value, name } = e.target;
        SetState({ ...state, [name]: UpperCaseField(value) });
    }

    function cutString(value, length = 20) {
        return value?.length > length ? value = value.substring(0, length) + "..." : value;
    }

    return (
        <>
            <div className='row'>
                <div className="col-sm-2 col-md-2 col-sm-6">
                    <label>Buscar </label>
                    <input type="text" placeholder="Buscar..." id="txSearch" className="form-control input-sm" name="txSearch" value={state.txSearch ? state.txSearch : ''} onChange={handleInput} />
                </div>
                <div className="col-sm-2 col-md-2 col-sm-6">
                    <div className="form-group">
                        <label>Tipo Documento</label>
                        <select className="form-control form-control-sm fieldForm" name="TipoDocto" id="TipoDocto" value={state.TipoDocto ? state.TipoDocto : ''} onChange={handleInput}>
                            <option value="">Seleccione una opcion</option>
                            <option value="0">Solicitud</option>
                            <option value="1">{Modulo == "P" ? 'Póliza' : 'Fianza'}</option>
                        </select>
                        <span id="e_Active" className="error"></span>
                    </div>
                </div>
                <div className="col-md-2 col-sm-6">
                    <label>Desde </label>
                    <input type="date" placeholder="FDesde" id="FDesde" className="form-control input-sm" name="FDesde" value={state.FDesde ? moment(state.FDesde).format("YYYY-MM-DD") : ''} onChange={handleInput} />
                </div>
                <div className="col-md-2 col-sm-6">
                    <label>Hasta </label>
                    <input type="date" placeholder="FHasta" id="FHasta" className="form-control input-sm" name="FHasta" value={state.FHasta ? moment(state.FHasta).format("YYYY-MM-DD") : ''} onChange={handleInput} />
                </div>
                <div className='col-md-1 col-sm-6' style={{ paddingTop: '25px' }}>
                    <a id="btnADD" className="btn btn-primary Nuevo" onClick={async () => getData()}><i className="fa fa-search" aria-hidden="true"></i></a>
                </div>
                <div className="col-md-3 col-sm-6 text-right" style={{ marginTop: '15px' }}>
                    <a id="btnADD" className="btn btn-primary Nuevo" style={{ 'marginRight': '5px' }} onClick={() => DowloadFile()}><i className="fa fa-download" aria-hidden="true"></i> Descargar</a>
                    <a id="btnADD" className="btn btn-primary Nuevo" href={`${UrlPagina}servicioSistema/${Modulo == "P" ? 'OrdenTrabajoNew' : 'FianzaAdd'}`}><i className="fa fa-plus" aria-hidden="true"></i> Nuevo</a>
                </div>
            </div>
            <div className="row">
                <div className="col-md-12">
                    <div className={'table-responsive'}>
                        <table className="table table-condensed" >
                            <thead>
                                <tr>
                                    {/* <th scope="col">Id</th> */}
                                    <th scope="col" style={!isMobile ? { width: '200px' } : {}} >Estatus usuario</th>
                                    <th scope="col" style={!isMobile ? { width: '200px' } : {}} >Dias</th>
                                    <th scope="col" style={!isMobile ? { width: '200px' } : {}} >Documento</th>
                                    <th scope="col" style={!isMobile ? { width: '200px' } : {}} >SubRamo</th>
                                    <th scope="col" style={!isMobile ? { width: '200px' } : {}} >FDesde</th>
                                    <th scope="col" style={!isMobile ? { width: '200px' } : {}} >FHasta</th>
                                    <th scope="col" style={!isMobile ? { width: '200px' } : {}} >FCaptura</th>
                                    <th scope="col" style={!isMobile ? { width: '200px' } : {}} >Cliente</th>
                                    <th scope="col" style={!isMobile ? { width: '200px' } : {}} >Estatus</th>
                                    <th scope="col" style={!isMobile ? { width: '200px' } : {}} >Acciones</th>
                                </tr>
                            </thead>
                            <tbody style={!isMobile ? { maxHeight: '400px', overflow: 'auto' } : {}}>
                                {registros.length == 0 && (
                                    <tr className='text-center'><td colSpan={11}>No hay registros de captura.</td></tr>
                                )}
                                {registros && registros.map((item, key) => (
                                    <tr key={key}>
                                        {/*  <td>{item.IDDocto}</td> */}
                                        <td>{item.EstatusUsuario ? item.EstatusUsuario : 'N/A'}</td>
                                        <td>{item.Dias ? item.Dias : 'N/A'}</td>
                                        <td style={{ cursor: 'pointer' }} onDoubleClick={() => EditItem(item.IDDocto)} >{item.Documento ? item.Documento : item.Solicitud}</td>
                                        <td>{item.SubRamo}</td>
                                        <td>{moment(item.FDesde).format("DD/MM/YYYY")}</td>
                                        <td>{moment(item.FHasta).format("DD/MM/YYYY")}</td>
                                        <td>{ParseItem(item.FCaptura)}</td>
                                        <td>{item.Cliente}</td>
                                        <td>{item.Status_TXT}</td>
                                        <td>
                                            <div className="col-md-12">
                                                <div className='row' title={item.Concepto}>
                                                    <div style={{ textAlign: 'left' }} >
                                                        {item.Concepto && item.Concepto != null ? cutString(item.Concepto, 8) : ''}
                                                    </div>
                                                    <div style={{ textAlign: 'right' }} >
                                                        <div className="dropdown">
                                                            <button className="btn btn-link dropdown-toggle" type="button" id={`Id_${item.IDDocto}`} data-toggle="dropdown" aria-haspopup="true" aria-expanded="true" >
                                                                <i className="fa fa-ellipsis-v" aria-hidden="true"></i>
                                                            </button>
                                                            <ul className="dropdown-menu dropdown-menu-right" aria-labelledby={`Id_${item.IDDocto}`}>
                                                                <li><a className="bn-bono-view" style={{ cursor: 'pointer' }} onClick={() => EditItem(item.IDDocto)} data-permiso="permiso" data-accion-permiso="Editar">Editar</a></li>
                                                                <li><a className="bn-bono-view" style={{ cursor: 'pointer' }} onClick={() => TableroRecibos(item.IDDocto)} data-permiso="permiso" data-accion-permiso="Editar">Ver recibos</a></li>
                                                            </ul>
                                                        </div>
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