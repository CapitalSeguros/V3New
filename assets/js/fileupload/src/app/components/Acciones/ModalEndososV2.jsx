import React, { useState, useEffect, forwardRef, useImperativeHandle, useRef } from 'react';
import { CallApiGet, CallApiPost } from '../../Helpers/Calls';
import Paginate from '../captura/Paginate.jsx';
import { ShowLoading, UpperCaseField } from '../../Helpers/FGeneral';

const ModalEndososV2 = forwardRef((props, ref) => {
    const { IDDocto, UrlPagina, UrlServicio, Modulo,Documento } = props;
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
    const [state, setState] = useState([]);
    const [inputs, setInputs] = useState({
        Busqueda: ''
    })
    const [Endosos, setEndosos] = useState([]);


    useImperativeHandle(ref, () => {
        return {
            InitialLoad: InitialLoad
        }
    });

    async function InitialLoad(IsOpen = true) {
        ShowLoading();
        let dta = {
            "Busqueda": inputs.Busqueda,
            "IDDocto": IDDocto,
            "Modulo": Modulo,
            "Documento":Documento
        }
        const res = await CallApiPost(`${UrlServicio}capture/findEndoso`, dta, null);
        if (res.status != 200) {
            swal({
                title: "Advertencia",
                text: res.error.Mensaje,
                icon: "warning",
                confirmButtonText: "Aceptar",
                confirmButtonColor: "#472380"
            });
        } else {
            //setEndosos(res.success.Datos);
            setState(res.success.Datos);
            setPageCount(Math.ceil(res.success.Count / itemsPerPage));
            setTotalRows(res.success.Count);
        }

        if (IsOpen) {
            $('#ModalEndosov2').modal('show');
        }
        ShowLoading(false);
        $('#ModalEndosov2').modal('handleUpdate');
    }

    function verEndoso(Item) {
        $("#ModalEndosov2").modal('hide');
        window.open(`${UrlPagina}servicioSistema/EndosoEdit/${Item.IDDocto}/${Item.IDEnd}/${Modulo}`);
    }

    function Nuevo() {
        $('#ModalEndosov2').modal('hide');
        window.open(`${UrlPagina}servicioSistema/EndosoAdd/${IDDocto}/${Modulo}`);
    }

    function handleInput(e) {
        const { value, name } = e.target;
        setInputs({ ...state, [name]: UpperCaseField(value) });
    }

    const handlePageClick = (event) => {
        const newOffset = (event.selected * itemsPerPage) % totalRows;
        setItemOffset(newOffset);
        CallData(Tipo, newOffset);
    };
    return (
        <div id="ModalEndosov2" className="modal fade" role="dialog">
            <div className="modal-dialog modal-lg modal-dialog-centered">
                <div className="modal-content">
                    <div className='modal-body'>
                        <div className='row'>
                            <div className='col-md-10 labelSpecial'>
                                <h4>ENDOSOS</h4>
                            </div>
                            <div className='col-md-2' style={{ textAlign: 'end' }}>
                                <a className='btn btn-primary btn-sm' onClick={() => Nuevo()}><i className="fa fa-floppy-o" aria-hidden="true"></i> Nuevo</a>
                            </div>

                        </div>
                        <div className='row mb-4'>
                            <div className='col-md-6'>
                                <div className='form-group'>
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
                            </div>
                            <div className='col-md-6'>
                                <a className='btn btn-primary btn-sm' onClick={() => InitialLoad(false)}>Buscar</a>
                            </div>
                        </div>
                        <div className='row'>
                            <div className='col-md-12'>
                                <table className="table" id="comisionesagente">
                                    <thead style={{ fontSize: '12px' }}>
                                        <tr>
                                            <th scope="col">ID</th>
                                            <th scope="col">Endoso</th>
                                            <th scope="col">FDesde</th>
                                            <th scope="col">FHasta</th>
                                            <th scope="col" style={{ textAlign: 'center' }}>Acciones</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        {state.length == 0 && (
                                            <tr>
                                                <td className='text-center' colSpan={5}>NO EXISTEN REGISTROS</td>
                                            </tr>
                                        )}
                                        {state && state.map((item, key) => (
                                            <tr key={key}>
                                                <td>{item.IDEnd}</td>
                                                <td>{(item.Endoso != null && item.Endoso != '') ? item.Endoso : item.Solicitud}</td>
                                                <td>{moment(item.FDesde).format("DD/MM/YYYY")}</td>
                                                <td>{moment(item.FHasta).format("DD/MM/YYYY")}</td>
                                                <td style={{ textAlign: 'center' }}>
                                                    <a className='btn btn-primary btn-sm' onClick={() => verEndoso(item)} data-toggle="tooltip" data-placement="bottom" title="Ver"><i className="fa fa-eye" aria-hidden="true"></i></a>
                                                </td>
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
                    <div className='modal-footer'>
                        <button type="button" className="btn btn-primary" data-dismiss="modal">Cerrar</button>
                    </div>
                </div>
            </div>
        </div>
    )
})

export default ModalEndososV2;
