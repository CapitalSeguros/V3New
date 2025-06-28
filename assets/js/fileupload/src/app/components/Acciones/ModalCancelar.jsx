import React, { useState, useEffect, useRef } from 'react';
import { CallApiGet, CallApiPost } from '../../Helpers/Calls';
import { Form, Formik } from "formik";


export default function ModalCancelar(props) {
    const { Id, Documento, Modulo, Estatus, Motivos,UrlServicio, Callback } = props;
    const [motivosS, SetMotivosS] = useState([]);
    const [item, Setitem] = useState({});
    const formikRef = useRef(null);

    function displayitem(Id, array, tipo = null) {
        //console.log("id",Id)
        const _array = array;
        var rArray = [];

        const newData = _array.filter((item, index) => parseInt(item.Id_Cancelacion) === parseInt(Id));
        //console.log("NewData", newData);
        newData.forEach(element => {
            rArray.push(element);
        });
        return rArray;
    }

    useEffect(()=>{
        formikRef.current.setFieldValue('FEstatus',  moment().format('YYYY-MM-DD'));
    },[]);


    async function Cancelar(values,actions) {
        var dta = {
            "IDDocto": Id,
            "Documento": Documento,
            "Modulo": Modulo,
            "Data": values
        };
        const res = await CallApiPost(`${UrlServicio}capture/cancelarDocumento`, dta, null);
        if (res.status != 200) {
            toastr.error(`Error, intente mas tarde. ${res.error}`);
        } else {
            toastr.success("Exíto");
            $('#ModalCancelar').modal('hide');
            actions.resetForm();
            formikRef.current.setFieldValue('FEstatus',  moment().format('YYYY-MM-DD'));
            Callback();
        }
    }



    return (
        <Formik
            innerRef={formikRef}
            initialValues={item}
            enableReinitialize="true"
            //validationSchema={validationSchemaPoliza}
            onSubmit={(values, actions) => {
                //alert('Sin errores');
                //console.log("valores", values);
                Cancelar(values, actions);
            }}
        >
            {({
                values,
                errors,
                status,
                setFieldValue,
                handleBlur,
                handleChange,
                handleSubmit,
                isSubmitting
            }) => (

                <div id="ModalCancelar" className="modal fade" role="dialog">
                    <form onSubmit={handleSubmit} className="form" autoComplete="off" >
                        <div className="modal-dialog modal-dialog-centered">
                            <div className="modal-content">
                                <div className='modal-body'>
                                    <div className='row'>
                                        <div className='col-md-10 labelSpecial'>
                                            <h4>Cancelación</h4>
                                        </div>
                                        <div className='col-md-2'>
                                            <button type="button" className="close" data-dismiss="modal">&times;</button>
                                        </div>

                                    </div>
                                    <div className='row'>
                                        <div className='col-md-12'>
                                            <div className='form-group'>
                                                <label htmlFor="">Estatus</label>
                                                <select className='form-control' onChange={(e) => { setFieldValue('Status_TXT', e.target.options[e.target.selectedIndex].text), setFieldValue('Status', e.target.value), setFieldValue('IDMotivo', ''), SetMotivosS(displayitem(e.target.value, Motivos, '')) }} name="Status" id="Status" value={values.Status ? values.Status : ''}>
                                                    <option value="">Seleccione una opcion</option>
                                                    {Estatus && Estatus.map((item, key) => (
                                                        <option key={key} value={item.Id}>{item.Nombre}</option>
                                                    ))}
                                                </select>
                                            </div>
                                        </div>
                                        <div className='col-md-12'>
                                            <div className='form-group'>
                                                <label htmlFor="">Motivo</label>
                                                <select className='form-control' onChange={handleChange} name="IDMotivo" id="IDMotivo" value={values.IDMotivo ? values.IDMotivo : ''}>
                                                    <option value="">Seleccione una opcion</option>
                                                    {motivosS && motivosS.map((item, key) => (
                                                        <option key={key} value={item.Id}>{item.Nombre}</option>
                                                    ))}
                                                </select>
                                            </div>
                                        </div>
                                        <div className='col-md-12'>
                                            <div className='form-group'>
                                                <label htmlFor="">Fecha</label>
                                                <input type="date" onChange={handleChange} className='form-control' name="FEstatus" id="FEstatus" value={values.FEstatus ? values.FEstatus : ''} />
                                            </div>
                                        </div>
                                        <div className='col-md-12 pt-3'>
                                            <div className='row'>
                                                <div className='col-md-6 text-center'>
                                                    <button className='btn btn-primary'>ACEPTAR</button>
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
                    </form>
                </div>

            )
            }
        </Formik >
    )
}
