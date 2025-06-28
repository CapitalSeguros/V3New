import React from 'react';

export default function Recibos() {
    return (
        <div id="ModalRecibos" className="modal fade" role="dialog">
            <div className="modal-dialog modal-lg">
                <div className="modal-content">
                    <div className="modal-body">
                        <div className='row'>
                            <div className='col-md-12'>
                                <button type="button" className="close" data-dismiss="modal">&times;</button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    )
}
