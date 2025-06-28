import React, { useState, useEffect } from 'react';
import Paginate from '../captura/Paginate.jsx';
import axios from "axios";
import { UpperCaseField } from '../../Helpers/FGeneral.js';

export default function ModalDocumentos(props) {
    const { UrlServicio, UrlPagina, Modulo, OnSelect, Data, ModuloPadre } = props;
    const itemsPerPage = 10;

    //Paginacion
    useEffect(() => {
        // Fetch items from another resources.
        const endOffset = itemOffset + itemsPerPage;
        setPageCount(Math.ceil(state.length / itemsPerPage));
    }, [itemOffset, itemsPerPage]);

    const [itemOffset, setItemOffset] = useState(0);
    const [pageCount, setPageCount] = useState(0);
    const [totalRows, setTotalRows] = useState(0);
    const [Tipo, setTipo] = useState('');
    const [state, setState] = useState([]);
    const [inputs, setInputs] = useState({
        Busqueda: ''
    })

    function OpenModal() {
        setState([]);
        setInputs({
            ...state,
            Busqueda: ''
        })
        $("#ModalDocumentos").modal("show");
    }

    function SetValue(e) {
        OnSelect(e);
        $("#ModalDocumentos").modal("hide");
    }

    const handlePageClick = (event) => {
        const newOffset = (event.selected * itemsPerPage) % totalRows;
        setItemOffset(newOffset);
        CallData(Tipo, newOffset);
    };

    function handleInput(e) {
        const { value, name } = e.target;
        setInputs({ ...state, [name]: UpperCaseField(value) });
    }

    function CallData(tipo, offset) {
        axios
            .post(`${UrlServicio}capture/findDocumento`, { Offset: offset, Modulo: Modulo, Busqueda: inputs.Busqueda, ModuloPadre: ModuloPadre ? ModuloPadre : '' })
            .then(function (response) {
                setState(response.data.Datos);
                setPageCount(Math.ceil(response.data.Count / itemsPerPage));
                setTotalRows(response.data.Count);
                $('#ModalDocumentos').modal('handleUpdate');
            });
    }

    function verEndoso(Item) {
        $("#ModalDocumentos").modal('hide');
        switch (Modulo) {
            case 'P':
                window.location = `${UrlPagina}servicioSistema/OrdenTrabajoEdit/${Item.IDDocto}`;
                break;
            case 'F':
                window.location = `${UrlPagina}servicioSistema/FianzaEdit/${Item.IDDocto}`;
                break;
            case 'E':
                //window.location = `${UrlPagina}servicioSistema/EndosoEdit/${Item.IDDocto}/${Item.IDEnd}/${Item.Modulo}`;
                window.location = `${UrlPagina}servicioSistema/EndosoEdit/${Item.IDDocto}/${Item.IDEnd}/${ModuloPadre}`;
                break;

            default:
                break;
        }
    }

    return (
        <>
            <div className="input-group">
                <input type="text" className="form-control" value={Data} readOnly={true} />
                <span className="input-group-btn">
                    <a className="btn btn-primary" type="button" onClick={() => OpenModal()}><i className="fa fa-search" aria-hidden="true"></i></a>
                </span>
            </div>
            <div id="ModalDocumentos" className="modal fade" role="dialog">
                <div className="modalLarge modal-dialog modal-lg">
                    <div className="modal-content">
                        <div className="modal-header">
                            <h4 className="modal-title">Seleccione un documento</h4>
                            <button type="button" className="close" data-dismiss="modal">&times;</button>
                        </div>
                        <div className="modal-body">
                            <div className='row mb-4'>
                                <div className='col-md-3'>
                                    <input
                                        className="form-control input-sm"
                                        type="text"
                                        name="Busqueda"
                                        id="Busqueda"
                                        placeholder='Elemento a buscar'
                                        onChange={handleInput}
                                        value={inputs.Busqueda ? inputs.Busqueda : ''}
                                    />
                                </div>
                                <div className='col-md-3'>
                                    <a className='btn btn-primary btn-sm' onClick={() => CallData(Tipo, 0)}>Buscar</a>
                                </div>

                            </div>
                            <div className='row'>
                                <div className='col-md-12'>
                                    <table className="table table-bordered" id="dataTable" width="100%" cellSpacing="0" style={{ fontSize: 'xx-small' }}>
                                        <thead>
                                            <tr>
                                                <th>IDDocto</th>
                                                <th>Solicitud</th>
                                                <th>Documento</th>
                                                <th>Cliente</th>
                                                <th>Desde</th>
                                                <th>Hasta</th>
                                                <th>Estatus</th>
                                                <th>Acción</th>
                                            </tr>
                                        </thead>
                                        <tbody style={{ maxHeight: '400px', overflow: 'auto' }}>
                                            {state.length == 0 && (
                                                <tr className='text-center'><td colSpan={8}>No hay registros de captura.</td></tr>
                                            )}
                                            {state && state.map((item, key) => (
                                                <tr key={key}>
                                                    <td>{item.IDDocto}</td>
                                                    <td>{item.Solicitud}</td>
                                                    <td>{item.Documento}</td>
                                                    <td>{item.Cliente}</td>
                                                    <td>{moment(item.FDesde).format('DD/MM/YYYY')}</td>
                                                    <td>{moment(item.FHasta).format('DD/MM/YYYY')}</td>
                                                    <td>{item.Status_TXT ? item.Status_TXT : 'N/A'}</td>
                                                    <td>
                                                        <a className='btn btn-primary btn-sm' onClick={() => verEndoso(item)} data-toggle="tooltip" data-placement="bottom" title="Ver"><i className="fa fa-eye" aria-hidden="true"></i></a>
                                                    </td>
                                                    {/* <td style={{ cursor: 'pointer' }} onClick={() => SetValue(item)}>{item.Nombre}</td> */}

                                                </tr>
                                            ))}
                                        </tbody>
                                    </table>
                                </div>
                                <div className='col-md-12' style={{ textAlign: 'end' }}>
                                    <Paginate handlePageClick={handlePageClick} pageCount={pageCount} />
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </>
    )
}
