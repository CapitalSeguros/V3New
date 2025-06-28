import React, { useState, useEffect, useRef } from 'react';
import { CallApiGet, CallApiPost } from '../../Helpers/Calls';
import { Form, Formik } from "formik";


export default function ModalEndosos(props) {
    const { IDDocto,UrlPagina, ListaEndosos, Modulo } = props;

    function verEndoso(Item) {
        $("#ModalEndoso").modal('hide');
        window.open(`${UrlPagina}servicioSistema/EndosoEdit/${Item.IDDocto}/${Item.IDEnd}/${Modulo}`);
    }

    function Nuevo(){
        $('#ModalEndoso').modal('hide');
        window.open(`${UrlPagina}servicioSistema/EndosoAdd/${IDDocto}/${Modulo}`);
    }
    return (
        <div id="ModalEndoso" className="modal fade" role="dialog">
            <div className="modal-dialog modal-lg modal-dialog-centered">
                <div className="modal-content">
                    <div className='modal-body'>
                        <div className='row'>
                            <div className='col-md-10 labelSpecial'>
                                <h4>ENDOSOS</h4>
                            </div>
                            <div className='col-md-2' style={{textAlign:'end'}}>
                                <a className='btn btn-primary btn-sm' onClick={()=>Nuevo()}><i className="fa fa-floppy-o" aria-hidden="true"></i> Nuevo</a>
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
                                        {ListaEndosos.length == 0 && (
                                            <tr>
                                                <td className='text-center' colSpan={5}>NO EXISTEN REGISTROS</td>
                                            </tr>
                                        )}
                                        {ListaEndosos && ListaEndosos.map((item, key) => (
                                            <tr key={key}>
                                                <td>{item.IDEnd}</td>
                                                <td>{item.Endoso != null || item.Endoso != '' ? item.Endoso : item.Solicitud}</td>
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
                        </div>
                    </div>
                    <div className='modal-footer'>
                        <button type="button" className="btn btn-primary" data-dismiss="modal">Cerrar</button>
                    </div>
                </div>
            </div>
        </div>
    )
}
