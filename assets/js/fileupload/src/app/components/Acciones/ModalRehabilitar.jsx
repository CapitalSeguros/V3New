import React, { useState, useEffect, useRef } from 'react';
import { CallApiPost } from '../../Helpers/Calls';


export default function ModalRehabilitar(props) {
    const { Id, Documento, Modulo, Estatus, Motivos, UrlServicio, Callback } = props;
    const [recibos, setRecibos] = useState(false);
    const [endosos, setEndosos] = useState(false);


    async function Save() {
        var dta = {
            "IDDocto": Id,
            "Documento": Documento,
            "Modulo": Modulo,
            "Data": [],
            "Recibos": recibos,
            "Endosos": endosos
        };

        const res = await CallApiPost(`${UrlServicio}capture/rehabilitarDocumento`, dta, null);
        if (res.status != 200) {
            toastr.error(`Error, intente mas tarde. ${res.error}`);
        } else {
            toastr.success("Exíto");
            $('#ModalRehabilitar').modal('hide');
            setRecibos(false);
            setEndosos(false);
            Callback();
        }

        //console.log("data", dta);
    }

    return (
        <div id="ModalRehabilitar" className="modal fade" role="dialog">
            <div className="modal-dialog modal-dialog-centered">
                <div className="modal-content">
                    <div className='modal-body'>
                        <div className='row'>
                            <div className='col-md-10 labelSpecial'>
                                <h4>Rehabilitar</h4>
                            </div>
                            <div className='col-md-2'>
                                <button type="button" className="close" data-dismiss="modal">&times;</button>
                            </div>

                        </div>
                        <div className='row'>
                            <div className='col-md-12'>
                                <div className="checkbox disabled">
                                    <label><input type="checkbox" disabled checked={true} />Documento</label>
                                </div>
                                <div className="checkbox">
                                    <label><input type="checkbox" checked={endosos} value={endosos} onChange={(e) => setEndosos(e.target.checked)} />Endoso</label>
                                </div>
                                <div className="checkbox">
                                    <label><input type="checkbox" checked={recibos} value={recibos} onChange={(e) => setRecibos(e.target.checked)} />Recibos</label>
                                </div>
                            </div>
                            <div className='col-md-12 pt-3'>
                                <div className='row'>
                                    <div className='col-md-6 text-center'>
                                        <a className='btn btn-primary' onClick={()=>Save()}>ACEPTAR</a>
                                    </div>
                                    <div className='col-md-6 text-center'>
                                        <a className='btn btn-seconadary' data-dismiss="modal">Cancelar</a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    )
}
