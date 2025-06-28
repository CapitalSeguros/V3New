import React, { useState, useEffect, useRef, forwardRef, useImperativeHandle } from 'react';
import { CallApiGet, CallApiPost } from '../../Helpers/Calls';
import { Form, Formik } from "formik";
import { validacionPagosEdicion } from '../../Helpers/Validations.js';
import { UpperCaseField } from '../../Helpers/FGeneral';


const ModalPagoHon = forwardRef((props, ref) => {
    const { PagoHonfunction, Tipo, Item, Callback } = props;
    const [Initial, SetInitial] = useState({
        FDocumento: '',
        Documento: null,
        Folio: '',
        IdRegistro: 0
    });
    const formikRef = useRef(null);


    useImperativeHandle(ref, () => {
        return {
            Initial: (Item) => {
                Init(Item)
            }
        }
    });

    function Init(Item) {
        formikRef.current.resetForm();
        SetInitial(Item);
    }

    function Save() {
        //console.log(formikRef.current)
        if (formikRef.current.isValid && formikRef.current.values.Documento != null) {
            PagoHonfunction(formikRef.current.values);
        }
        //console.log(props);
    }


    return (
        <Formik
            innerRef={formikRef}
            initialValues={Initial}
            enableReinitialize="true"
            validationSchema={validacionPagosEdicion}
        /* onSubmit={(values, actions) => {
            Save();
        }} */
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

                <div id="ModalPagoHon" className="modal fade" role="dialog">
                    <form onSubmit={handleSubmit} className="form" autoComplete="off" >
                        <div className="modal-dialog modal-dialog-centered">
                            <div className="modal-content">
                                <div className='modal-body'>
                                    <div className='row'>
                                        <div className='col-md-10 labelSpecial'>
                                            <h4>{Tipo == "HON" ? "Registro de honorario" : "Registro de Comisiones"}</h4>
                                        </div>
                                        <div className='col-md-2'>
                                            <button type="button" className="close" data-dismiss="modal">&times;</button>
                                        </div>

                                    </div>
                                    <div className='row'>
                                        <div className='col-md-4'>
                                            <div className='form-group'>
                                                <label htmlFor="">Documento</label>
                                                <input id='Documento' name='Documento' value={values.Documento ? values.Documento : ''} onChange={(e) => setFieldValue('Documento', UpperCaseField(e.target.value))} type="text" className='form-control input-sm' />
                                                <span className="help-block">{errors.Documento}</span>
                                            </div>
                                        </div>
                                        <div className='col-md-4'>
                                            <div className='form-group'>
                                                <label htmlFor="">Folio</label>
                                                <input id='Folio' name='Folio' value={values.Folio ? values.Folio : ''} onChange={(e) => setFieldValue('Folio', UpperCaseField(e.target.value))} type="text" className='form-control input-sm' />
                                                <span className="help-block">{errors.Folio}</span>
                                            </div>
                                        </div>
                                        <div className='col-md-4'>
                                            <div className='form-group'>
                                                <label htmlFor="">Fecha Pago</label>
                                                <input id='FDocumento' name='FDocumento' value={values.FDocumento ? values.FDocumento : ''} onChange={(e) => setFieldValue('FDocumento', UpperCaseField(e.target.value))} type="date" className='form-control input-sm' />
                                                <span className="help-block">{errors.FDocumento}</span>
                                            </div>
                                        </div>
                                    </div>
                                    <div className='col-md-12 text-right pt-5'>
                                        <a type='submit' className="btn btn-primary btn-s" data-toggle="tooltip" data-placement="bottom" title="Editar" onClick={() => { Save() }} ><i className="fa fa-floppy-o" aria-hidden="true"></i> Guardar</a>
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
})
export default ModalPagoHon;
