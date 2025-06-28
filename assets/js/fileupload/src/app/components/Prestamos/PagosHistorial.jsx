import React, { useState, useEffect, forwardRef, useImperativeHandle, useRef } from 'react';
import { CallApiGet, CallApiPost } from '../../Helpers/Calls.js';
import { ShowLoading, UpperCaseField,FormatItem } from '../../Helpers/FGeneral.js';

const PagosHistorial = forwardRef((props, ref) => {
    const { callback, UrlServicio, UrlPagina, Reload, Title } = props;
    const [tabla, SetTabla] = useState([]);

    useImperativeHandle(ref, () => {
        return {
            Initial: (ID) => {
                getInitial(ID)
            }
        }
    });

    async function getInitial(Id) {
        ShowLoading();
        const res = await CallApiGet(`${UrlServicio}prestamos/historial`, { Id: Id }, null);
        if (res.status != 200) {
            toastr.error(`Error ${res.error.Mensaje}`);
        } else {
            setTimeout(() => {
                SetTabla(res.success.Datos);
            }, 50);
        }
        await $('#HistorialPrestamos').modal('show');
        ShowLoading(false);
    }


    return (
        <div id="HistorialPrestamos" className="modal fade" role="dialog">
            <div className="modal-dialog modal-lg">
                <div className="modal-content">
                    <div className="modal-header">
                        <h4 className="modal-title" id="myModalLabel">Historial de Pagos</h4>
                        <a type="button" className="close" data-dismiss="modal">
                            <span aria-hidden="true">&times;</span><span className="sr-only">Cerrar</span>
                        </a>

                    </div>
                    <div className="modal-body">
                        <div className="row tablaPagos">
                            <div className="col-md-12">
                                <table className="table table-condensed" id="polizas">
                                    <thead>
                                        <tr>
                                            {/* <th scope="col">Id</th> */}
                                            <th scope="col" style={{ width: '200px' }}>Fecha</th>
                                            <th scope="col" style={{ width: '200px' }}>Importe</th>
                                            <th scope="col" style={{ width: '200px' }}>Referencia</th>
                                        </tr>
                                    </thead>
                                    <tbody style={{ maxHeight: '400px', overflow: 'auto' }}>
                                        {tabla.length == 0 && (
                                            <tr className='text-center'><td colSpan={3}>No hay registros de captura.</td></tr>
                                        )}
                                        {tabla && tabla.map((item, key) => (
                                            <tr key={key}>
                                                <td>{moment(item.FPago).format("DD/MM/YYYY")}</td>
                                                <td>{FormatItem(item.Importe)}</td>
                                                <td>{item.Referencia}</td>
                                            </tr>
                                        ))}
                                    </tbody>
                                </table>
                            </div>
                        </div>

                    </div>
                    <div className="modal-footer">
                        <div className="btn btn-secondary" style={{ backgroundColor: "#e8e8e8" }} data-dismiss="modal">Cerrar</div>
                    </div>
                </div>
            </div>
        </div>
    )
})
export default PagosHistorial;

