import React, { useState, useEffect, useRef } from 'react';
import { CallApiGet, CallApiPost } from '../../Helpers/Calls.js';
import { ShowLoading, UpperCaseField } from '../../Helpers/FGeneral.js';
import Paginate from '../captura/Paginate.jsx';
import ModalPrestamo from './ModalPrestamo.jsx';
import PagoDirecto from './PagoDirecto.jsx';
import PagosHistorial from './PagosHistorial.jsx';

export default function Prestamos(props) {
    const { UrlServicio, UrlPagina, Modulo } = props;
    const ModalRef = useRef(null);
    const PagoRef = useRef(null);
    const HisPagoRef = useRef(null);
    const [registros, SetRegistros] = useState([]);
    const [title, SetTitle] = useState("");
    const [itemOffset, setItemOffset] = useState(0);
    const [pageCount, setPageCount] = useState(0);
    const [totalRows, setTotalRows] = useState(0);
    const [state, SetState] = useState({
        txSearch: '',
        Estatus: ''
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
            Estatus: state.Estatus,
            Offset: Offset,
            Busqueda: state.txSearch
        };
        const res = await CallApiGet(`${UrlServicio}prestamos/prestamos`, params, null);
        if (res.status != 200) {
            toastr.error(`Error ${res.error.Mensaje}`);
        } else {
            setPageCount(Math.ceil(res.success.Count / itemsPerPage));
            setTotalRows(res.success.Count);
            SetRegistros(res.success.Datos);
        }
        ShowLoading(false);
    }

    function FormatItem(value) {
        var _return = parseFloat(value ? value : 0);
        return (_return).toLocaleString('es-MX', { style: 'currency', currency: 'MXN' })
    }


    async function EditItem(Id) {
        SetTitle("Editar Prestamo");
        await ModalRef.current.Initial(Id);
        $('#ModalPrestamo').modal('show');
        //window.location = UrlPagina + `servicioSistema/${Modulo == 'P' ? 'OrdenTrabajoEdit' : 'FianzaEdit'}/` + Id;
    }

    async function Cancelar(Id) {
        swal({
            title: "¿Está seguro de que quiere cancelar el prestamo?",
            text: "Una vez realizado, no podra actualizar ninguna informacion.",
            icon: "warning",
            buttons: ["Cancelar", "Aceptar"],
        }).then(async (value) => {
            if (value) {
                ShowLoading();
                const res = await CallApiPost(`${UrlServicio}prestamos/prestamosCancel`, { Id: Id }, null);
                if (res.status != 200) {
                    toastr.error(`Error, intente mas tarde. ${res.error}`);
                } else {
                    getData();
                }
                ShowLoading(false);
            }
        });
    }

    async function Rehabilitar(Id) {
        swal({
            title: "¿Está seguro de que quiere rehabiltar el prestamo?",
            text: "Una vez realizado, se podra realizar las acciones correspondientes.",
            icon: "warning",
            buttons: ["Cancelar", "Aceptar"],
        }).then(async (value) => {
            if (value) {
                ShowLoading();
                const res = await CallApiPost(`${UrlServicio}prestamos/rehabilitarPrestamo`, { Id: Id }, null);
                if (res.status != 200) {
                    toastr.error(`Error, intente mas tarde. ${res.error}`);
                } else {
                    getData();
                }
                ShowLoading(false);
            }
        });
    }


    function DowloadFile() {
        //var Filter = $("#txSearch").val();
        return window.open(`${UrlServicio}capture/${Modulo == "P" ? 'docPolizas' : 'docFianzas'}?search=${state.txSearch}`, '_blank');
    }

    function handleInput(e) {
        const { value, name } = e.target;
        SetState({ ...state, [name]: UpperCaseField(value) });
    }

    async function OpenModal() {
        SetTitle("Nuevo Prestamo");
        await ModalRef.current.Initial(null);
        setTimeout(async () => {
            await $('#ModalPrestamo').modal('show');
        }, 100);
    }

    async function OpenPagoDirecto(Id) {
        await PagoRef.current.Initial(Id);
        setTimeout(async () => {
            await $('#ModalPagoDirecto').modal('show');
        }, 100);
    }

    async function Reload() {
        getData();
    }

    async function VerHistorial(Id) {
        await HisPagoRef.current.Initial(Id);
    }

    return (
        <>
            <div className='row'>
                <div className="col-sm-2">
                    <label>Buscar </label>
                    <input type="text" placeholder="Buscar..." id="txSearch" className="form-control input-sm" name="txSearch" value={state.txSearch ? state.txSearch : ''} onChange={handleInput} />
                </div>
                <div className="col-sm-2">
                    <div className="form-group">
                        <label>Estatus</label>
                        <select className="form-control form-control-sm fieldForm" name="Estatus" id="Estatus" value={state.Estatus ? state.Estatus : ''} onChange={handleInput}>
                            <option value="">Seleccione una opcion</option>
                            <option value="PENDIENTE">PENDIENTE</option>
                            <option value="PAGADO">PAGADO</option>
                            <option value="CANCELADO">CANCELADO</option>
                            {/* <option value="1">{Modulo == "P" ? 'Póliza' : 'Fianza'}</option> */}
                        </select>
                        <span id="e_Active" className="error"></span>
                    </div>
                </div>
                <div className='col-sm-2' style={{ paddingTop: '25px' }}>
                    <a id="btnADD" className="btn btn-primary Nuevo" onClick={async () => getData()}><i className="fa fa-search" aria-hidden="true"></i></a>
                </div>
                <div className="col-md-6 text-right" style={{ marginTop: '15px' }}>
                    <a id="btnADD" className="btn btn-primary Nuevo" onClick={() => OpenModal()}><i className="fa fa-plus" aria-hidden="true"></i> Nuevo</a>
                </div>
            </div>
            <div className="row">
                <div className="col-md-12">
                    <table className="table table-condensed" id="polizas">
                        <thead>
                            <tr>
                                {/* <th scope="col">Id</th> */}
                                <th scope="col" style={{ width: '200px' }}>ID</th>
                                <th scope="col" style={{ width: '200px' }}>Vendedor</th>
                                <th scope="col" style={{ width: '200px' }}>FCaptura</th>
                                <th scope="col" style={{ width: '200px' }}>Importe</th>
                                <th scope="col" style={{ width: '200px' }}>Concepto</th>
                                <th scope="col" style={{ width: '200px' }}>Forma Pago</th>
                                <th scope="col" style={{ width: '200px' }}>Estatus</th>
                                <th scope="col" style={{ width: '200px' }} className="text-right">Acciones</th>
                            </tr>
                        </thead>
                        <tbody style={{ maxHeight: '400px', overflow: 'auto' }}>
                            {registros.length == 0 && (
                                <tr className='text-center'><td colSpan={7}>No hay registros de captura.</td></tr>
                            )}
                            {registros && registros.map((item, key) => (
                                <tr key={key}>
                                    {/*  <td>{item.IDDocto}</td> */}
                                    <td>{item.ID}</td>
                                    <td>{item.VendNom ? item.VendNom : 'N/A'}</td>
                                    <td>{moment(item.FCaptura).format("DD/MM/YYYY")}</td>
                                    <td>{FormatItem(item.Importe)}</td>
                                    <td>{item.Concepto}</td>
                                    <td>{item.FPago}</td>
                                    <td>{item.Estatus}</td>
                                    <td>
                                        <div className="col-md-12">
                                            <div style={{ textAlign: 'right' }} >
                                                <div className="dropdown">
                                                    <button className="btn btn-link dropdown-toggle" type="button" id={`Id_${item.ID}`} data-toggle="dropdown" aria-haspopup="true" aria-expanded="true" >
                                                        <i className="fa fa-ellipsis-v" aria-hidden="true"></i>
                                                    </button>
                                                    <ul className="dropdown-menu dropdown-menu-center" aria-labelledby={`Id_${item.ID}`}>
                                                        <li><a className="bn-bono-view" style={{ cursor: 'pointer' }} onClick={() => EditItem(item.ID)} data-permiso="permiso" data-accion-permiso="Editar">Editar</a></li>
                                                        <li><a className="bn-bono-view" style={{ cursor: 'pointer' }} onClick={() => VerHistorial(item.ID)} data-permiso="permiso" data-accion-permiso="Editar">Historial de pagos</a></li>
                                                        {item.Estatus == "PENDIENTE" && (
                                                            <>
                                                                <li><a className="bn-bono-view" style={{ cursor: 'pointer' }} onClick={() => OpenPagoDirecto(item.ID)} data-permiso="permiso" data-accion-permiso="Editar">Pago Directo</a></li>
                                                                <li><a className="bn-bono-view" style={{ cursor: 'pointer' }} onClick={() => Cancelar(item.ID)} data-permiso="permiso" data-accion-permiso="Editar">Cancelar</a></li>
                                                            </>
                                                        )}
                                                        {item.Estatus == "CANCELADO" && (
                                                            <>
                                                                <li><a className="bn-bono-view" style={{ cursor: 'pointer' }} onClick={() => Rehabilitar(item.ID)} data-permiso="permiso" data-accion-permiso="Rehabilitar">Rehabilitar</a></li>
                                                            </>
                                                        )}
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
            <ModalPrestamo ref={ModalRef} UrlServicio={UrlServicio} UrlPagina={UrlPagina} Reload={Reload} Title={title} />
            <PagoDirecto ref={PagoRef} UrlServicio={UrlServicio} UrlPagina={UrlPagina} Reload={Reload} />
            <PagosHistorial ref={HisPagoRef} UrlServicio={UrlServicio} UrlPagina={UrlPagina} />
        </>
    )
}
