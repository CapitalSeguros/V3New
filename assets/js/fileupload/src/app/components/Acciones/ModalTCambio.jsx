import React, { useState, useEffect, useRef, forwardRef, useImperativeHandle } from 'react';
import { CallApiGet, CallApiPost } from '../../Helpers/Calls';
import { Form, Formik } from "formik";
import { ShowLoading } from '../../Helpers/FGeneral';


const ModalTCambio = forwardRef((props, ref) => {
    const { UrlServicio, Tipo } = props;
    const [TCambio, setTCambio] = useState([]);
    const [element, setElement] = useState({ Id: 0 });
    const [isEdit, setisEdit] = useState(false);
    const InputTCambio = useRef(null);


    useImperativeHandle(ref, () => {
        return {
            Init: Init
        }
    });

    async function Init() {
        ShowLoading();
        Cancel();
        const res = await CallApiGet(`${UrlServicio}catalogos/getTCambio`, {}, null);
        if (res.status != 200) {
            toastr.error(`Error, intente mas tarde. ${res.error}`);
        } else {
            setTCambio(res.success.Datos);
        }
        ShowLoading(false);
        $("#ModalTCambio").modal('show');
    }

    function EditItem(item) {
        //console.log('setItem');
        setElement(item);
    }
    function Cancel() {
        setElement({ Id: 0 });
    }

    function InputChange(input) {
        console.log("test");
        /*  const { name, value } = input.target;
         console.log("test",value );
         setElement({ ...element, [name]: value }); */
    }

    async function Save() {
        ShowLoading();
        if (element.TCambio >= 1) {
            let Cpp={...element};
            Cpp.TCambio=InputTCambio.current.value;
             const res = await CallApiPost(`${UrlServicio}catalogos/updateTCambio`, Cpp, null);
             if (res.status != 200) {
                 toastr.error(`Error, intente mas tarde. ${res.error}`);
             } else {
                 Cancel();
                 Init();
                 //setTCambio(res.success.Datos);
             }
        } else {
            toastr.error(`Error, La cantidad no puede ser menor o igual a 0.`);
        }
        ShowLoading(false);
        $("#ModalTCambio").modal('show');
    }

    const FocusInput = (e) => {
        InputTCambio.current.select();
    }



    return (
        <>
            {Tipo != null && (
                <center>
                    <a onClick={() => Init()}>
                        <div>
                            <i className="fa fa-money fa-5x" aria-hidden="true"></i>
                            <h4>Tipo de cambio</h4>
                        </div>
                    </a>
                </center>
            )}
            <div id="ModalTCambio" className="modal fade" role="dialog">
                <div className="modal-dialog modal-dialog-centered">
                    <div className="modal-content">
                        <div className='modal-body'>
                            <div className='row'>
                                <div className='col-md-10 labelSpecial'>
                                    <h4>Tipo de Cambio</h4>
                                </div>
                                <div className='col-md-2'>
                                    <button type="button" className="close" data-dismiss="modal">&times;</button>
                                </div>

                            </div>
                            <div className='row'>
                                <div className='col-md-12'>
                                    <table className="table" id="comisionesagente">
                                        {/* <a className='btn' onClick={()=>console.log('Pruebas',element)}>prueba</a> */}
                                        <thead style={{ fontSize: '12px' }}>
                                            <tr>
                                                <th scope="col" className='text-center'>Moneda</th>
                                                <th scope="col" className='text-center'>Fecha</th>
                                                <th scope="col" className='text-center'>Cambio</th>
                                                <th scope="col" className='text-center'>Acciones</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            {TCambio && TCambio.map((item, key) => (
                                                <tr key={key}>
                                                    <td className='text-center'>{item.Moneda}</td>
                                                    <td className='text-center'>{moment(item.FDesde).format("DD/MM/YYYY")}</td>
                                                    <td className='text-center'>
                                                        <div className='row'>
                                                            <div className='col-md-12'>
                                                                {item.Id == element.Id && (
                                                                    <input ref={InputTCambio} className='form-control numeric input-sm' type='text' style={{ width: '70px' }} onFocus={FocusInput} onChange={()=>''} name="TCambio" id="TCambio" value={element.TCambio ? element.TCambio : ''} />
                                                                )}
                                                                {item.Id != element.Id && (
                                                                    <>{item.TCambio == null ? 0 : item.TCambio}</>
                                                                )}
                                                            </div>
                                                        </div>
                                                    </td>
                                                    <td className='text-center'>
                                                        {item.Id == element.Id && (
                                                            <>
                                                                <a className='btn btn-primary btn-sm' style={{ marginRight: '5px' }} onClick={() => Save()} data-toggle="tooltip" data-placement="bottom" title="Guarda"><i className="fa fa-save" aria-hidden="true"></i></a>
                                                                <a className='btn btn-primary btn-sm' onClick={() => Cancel(item)} data-toggle="tooltip" data-placement="bottom" title="Cancelar"><i className="fa fa-times" aria-hidden="true"></i></a>
                                                            </>
                                                        )}
                                                        {item.Id != element.Id && (
                                                            <a className='btn btn-primary btn-sm' onClick={() => EditItem(item)} data-toggle="tooltip" data-placement="bottom" title="Editar"><i className="fa fa-edit" aria-hidden="true"></i></a>
                                                        )}
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
        </>
    )
});

export default ModalTCambio;
