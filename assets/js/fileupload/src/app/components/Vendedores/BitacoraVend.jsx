import React from 'react';

export default function BitacoraVend(props) {
    const { data } = props;
    return (
        <div id="ModalBitacora" className="modal fade" role="dialog">
            <div className="modal-dialog modal-md">
                <div className="modal-content">
                    <div className="modal-header">
                        <h4 className="modal-title">Bitácora</h4>
                        <button type="button" className="close" data-dismiss="modal">&times;</button>
                    </div>
                    <div className='modal-body' style={{ maxHeight: '300px', overflow: 'auto', height: '300px' }}>
                        <div className='row' style={{ paddingLeft: '10px', paddingRight: '10px' }}>
                            {data.length == 0 && (
                                <div className='col-md-12 col-sm-12 col-xs-12'>
                                    No hay registros
                                </div>
                            )}
                            {data && data.map((itm, key) => (
                                <div key={key} className="col-md-12 col-sm-12 col-xs-12" style={{ border: '1px solid black', marginBottom: '5px' }}>
                                    <div className="col-md-2 col-sm-2 col-xs-2">
                                        <i className="glyphicon glyphicon-user" style={{ fontSize: '30px', cursor: 'pointer', textAlign: 'center' }}></i>
                                    </div>
                                    <div className="col-md-10 col-sm-10 col-xs-10" style={{ fontSize: '8px' }}>
                                        <div className="row">
                                            <div style={{ display: 'inline-table' }}>
                                                <b>{itm.UserGen ? itm.UserGen : 'AUTOMATICO'}</b>
                                            </div>
                                            <div style={{ float: 'inline-end' }}>
                                                <b>{itm.FechaHora}</b>
                                            </div>
                                        </div>
                                        <div className="row">
                                            {itm.Comentario}
                                        </div>
                                    </div>
                                </div>
                            ))}
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
