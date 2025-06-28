import React, { forwardRef, useImperativeHandle, useRef, useState } from 'react';

const ModalLiquidar= forwardRef((props, ref) => {
    const {AplicarLiquidar}=props;
    const [FechaLiquidacion, setFechaLiquidacion]=useState(moment());
    useImperativeHandle(ref, () => {
        return {
            Open: Open
        }
    });

    function Open() {
        setFechaLiquidacion(moment());
        $('#ModalLiquidar').modal('show');
    }

    function Aplicar(){
        AplicarLiquidar(FechaLiquidacion);
    }

    return (
        <div className="modal fade" id="ModalLiquidar" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
            <div className="modal-dialog modal-dialog-centered" role="document">
                <div className="modal-content">
                    <div className="modal-body">
                        <div className='row'>
                            <div className='col-md-12'>
                                <h6>Liquidar</h6>
                            </div>
                            <div className='col-md-12'>
                                <div className='form-goup'>
                                    <label>Fecha Liquidación</label>
                                    <input type="date" className='form-control' name="FechaLiquidacion" id="FechaLiquidacion" onChange={(e)=>setFechaLiquidacion(e.target.value)} value={FechaLiquidacion ? moment(FechaLiquidacion).format("YYYY-MM-DD") : ''} max={moment().format("YYYY-MM-DD")} />
                                </div>
                            </div>
                        </div>
                    </div>
                    <div className="modal-footer">
                        <a type="button" className="btn btn-secondary" data-dismiss="modal">Cerrar</a>
                        <a type="button" className="btn btn-primary" onClick={()=>Aplicar()}>Guardar</a>
                    </div>
                </div>
            </div>
        </div>
    )
})

export default ModalLiquidar;