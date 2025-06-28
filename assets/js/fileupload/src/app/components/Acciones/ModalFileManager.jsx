import React, { forwardRef, useImperativeHandle, useRef } from 'react';
import FileManager from '../Fmanager/FileManager.jsx';

const ModalFileManager = forwardRef((props, ref) => {
    const { referencia, referenciaId,IDCli, Documento } = props;
    const refComponent = useRef(null);
    useImperativeHandle(ref, () => {
        return {
            Open: Open
        }
    });

    function Open() {
        //alert("Modal");
        refComponent.current.OpenModal();
    }
    return (
        <div id="ModalFileUpload" className="modal fade" role="dialog">
            <div className="modalLarge modal-dialog modal-lg">
                <div className="modal-content">
                    <div className='modal-body'>
                        <div className='row'>
                            <div className='col-md-10 labelSpecial'>
                                <h4>Documentos</h4>
                            </div>
                            <div className='col-md-2'>
                                <button type="button" className="close" data-dismiss="modal">&times;</button>
                            </div>

                        </div>
                        <div className='row'>
                            <div className='col-md-12'>
                                <FileManager ref={refComponent} Documento={Documento} referencia={referencia} referenciaId={referenciaId} IDCli={IDCli}/>
                            </div>
                        </div>
                    </div>
                    <div className="modal-footer">
                        <button type="button" className="btn btn-primary" data-dismiss="modal">Cerrar</button>
                    </div>
                </div>
            </div>
        </div>
    )
})

export default ModalFileManager;
