import React, { useState, useEffect, forwardRef, useImperativeHandle, useRef } from 'react';
import Select from "react-select";
import { Form, Formik } from "formik";
import { LockEnter, colourStyles, FocusInput, displayitem, mapitems, displayitemText } from '../../Helpers/FGeneral.js';
import CurrencyInputField from 'react-currency-input-field';
import { CallApiGet, CallApiPost } from '../../Helpers/Calls.js';
import { validationPrestamo } from '../../Helpers/Validations.js';

const ModalPrestamo = forwardRef((props, ref) => {
    useImperativeHandle(ref, () => {
        return {
            Initial: (ID) => {
                getInitial(ID)
            }
        }
    });


    const { callback, UrlServicio, UrlPagina, Reload, Title } = props;
    const formikRef = useRef(null);
    const Initial = {
        ID: "",
        IDVend: '',
        Importe: 0,
        Estatus: 'PENDIENTE',
        ImportePendiente: '',
        FDescuento: '',
        ImporteFpago: 0,
        FPago: '',
        FPrestamo: moment().format('YYYY-MM-DD'),
        FCaptura: moment().format('YYYY-MM-DD'),
        FCancelacion: '',
        Concepto: '',
        VendNom: '',
        ImportePagado: 0
    }
    const [state, Setstate] = useState(Initial);
    const [IdItem, SetIdItem] = useState(null);
    const [catalogos, SetCatalogos] = useState({
        Vendedores: [],
        Estatus: [],
        FormaPago: []
    });

    async function getInitial(Id) {
        //console.log(`ID ${Id}`);
        const res = await CallApiGet(`${UrlServicio}prestamos/prestamosInitial`, { ID: Id }, null);
        if (res.status != 200) {
            toastr.error(`Error ${res.error.Mensaje}`);
        } else {
            setTimeout(() => {
                SetCatalogos(res.success.Datos.Catalogos);
                if (Id != null) {
                    Setstate(res.success.Datos.Item);
                } else {
                    Setstate(Initial);
                }
            }, 50);
        }
    }

    async function SavePrestamo(values) {
        const res = await CallApiPost(`${UrlServicio}prestamos/prestamosUpdate`, { data: values }, null);
        if (res.status != 200) {
            toastr.error(`Error ${res.error.Mensaje}`);
        } else {
            Reload();
            $('#ModalPrestamo').modal('hide');
        }
    }


    return (
        <>
            <Formik
                innerRef={formikRef}
                initialValues={state}
                enableReinitialize="true"
                validationSchema={validationPrestamo}
                onSubmit={(values, actions) => {
                    //console.log("valores", values);
                    SavePrestamo(values);
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
                    <div id="ModalPrestamo" className="modal fade" role="dialog">
                        <form onKeyDown={LockEnter} onSubmit={handleSubmit} className="form" autoComplete="off">
                            <div className="modal-dialog modal-lg">
                                <div className="modal-content">
                                    <div className="modal-header">
                                        <h4 className="modal-title" id="myModalLabel">{Title}</h4>
                                        <a type="button" className="close" data-dismiss="modal">
                                            <span aria-hidden="true">&times;</span><span className="sr-only">Cerrar</span>
                                        </a>

                                    </div>
                                    <div className="modal-body">
                                        <div className="row">
                                            <div className='col-md-8'>
                                                <div className='form-group'>
                                                    <label>Vendedor</label>
                                                    <Select
                                                        isDisabled={(values.ID ? values.ID : 0) > 0 ? true : false}
                                                        placeholder="Selecione"
                                                        id="IDVend"
                                                        name="IDVend"
                                                        styles={colourStyles}
                                                        onChange={v => { setFieldValue("IDVend", v.value), setFieldValue('VendNom', v.label) }}
                                                        onBlur={handleBlur}
                                                        value={displayitem(values.IDVend, catalogos.Vendedores)}
                                                        options={mapitems(catalogos.Vendedores ? catalogos.Vendedores : [], '')}
                                                        noOptionsMessage={() => "Sin opciones"}
                                                    />
                                                    <span className="help-block">{errors.VendNom}</span>
                                                </div>
                                            </div>
                                            <div className='col-md-4'>
                                                <div className='form-group'>
                                                    <label>Importe</label>
                                                    <CurrencyInputField
                                                        //disabled={IsDisabledP}
                                                        disabled={(values.Estatus ? values.Estatus : "") != "PENDIENTE" ? true : false}
                                                        className='form-control input-sm numeric'
                                                        min={0}
                                                        maxLength={10}
                                                        //prefix='$'
                                                        decimalSeparator='.'
                                                        groupSeparator=','
                                                        decimalsLimit={2}
                                                        decimalScale={2}
                                                        onFocus={FocusInput}
                                                        allowNegativeValue={false}
                                                        value={values.Importe ? values.Importe : '0'}
                                                        onValueChange={(value, name) => { setFieldValue(name, value)/* ,ReloadPrices(values) */ }}
                                                        id='Importe'
                                                        name='Importe'
                                                        autoComplete='off'
                                                    />
                                                    <span className="help-block">{errors.Importe}</span>
                                                </div>
                                            </div>
                                        </div>
                                        <div className='row'>
                                            <div className='col-md-4'>
                                                <div className='form-group'>
                                                    <label>Fecha prestamo</label>
                                                    <input disabled={(values.Estatus ? values.Estatus : "") != "PENDIENTE" ? true : false} type="date" id='FPrestamo' name='FPrestamo' className='form-control' onChange={handleChange} value={values.FPrestamo ? moment(values.FPrestamo).format("YYYY-MM-DD") : ''} />
                                                    <span className="help-block">{errors.FPrestamo}</span>
                                                </div>
                                            </div>
                                            <div className='col-md-4'>
                                                <div className='form-group'>
                                                    <label>Estatus</label>
                                                    <Select
                                                        isDisabled={(values.Estatus ? values.Estatus : "") != "PENDIENTE" ? true : false}
                                                        placeholder="Selecione"
                                                        id="Estatus"
                                                        name="Estatus"
                                                        styles={colourStyles}
                                                        onChange={v => { console.log(v), setFieldValue("Estatus", v.value) }}
                                                        onBlur={handleBlur}
                                                        value={displayitemText(values.Estatus, catalogos.Estatus)}
                                                        options={mapitems(catalogos.Estatus ? catalogos.Estatus : [], '')}
                                                        noOptionsMessage={() => "Sin opciones"}
                                                    />
                                                    <span className="help-block">{errors.Estatus}</span>
                                                </div>
                                            </div>
                                            <div className='col-md-4'>
                                                <div className='form-group'>
                                                    <label>Importe Pendiente</label>
                                                    <CurrencyInputField
                                                        disabled={true}
                                                        className='form-control input-sm numeric'
                                                        min={0}
                                                        maxLength={10}
                                                        //prefix='$'
                                                        decimalSeparator='.'
                                                        groupSeparator=','
                                                        decimalsLimit={2}
                                                        decimalScale={2}
                                                        onFocus={FocusInput}
                                                        allowNegativeValue={false}
                                                        value={values.ImportePendiente ? values.ImportePendiente : '0'}
                                                        onValueChange={(value, name) => { setFieldValue(name, value)/* ,ReloadPrices(values) */ }}
                                                        id='ImportePendiente'
                                                        name='ImportePendiente'
                                                        autoComplete='off'
                                                    />
                                                </div>
                                            </div>
                                        </div>
                                        <div className='row'>
                                            <div className='col-md-4'>
                                                <div className='form-group'>
                                                    <label>Fecha descuento</label>
                                                    <input disabled={(values.Estatus ? values.Estatus : "") != "PENDIENTE" ? true : false} type="date" name='FDescuento' id='FDescuento' className='form-control' onChange={handleChange} value={values.FDescuento ? moment(values.FDescuento).format("YYYY-MM-DD") : ''} />
                                                    <span className="help-block">{errors.FDescuento}</span>
                                                </div>
                                            </div>
                                            <div className='col-md-4'>
                                                <div className='form-group'>
                                                    <label>Forma pago</label>
                                                    <Select
                                                        isDisabled={(values.Estatus ? values.Estatus : "") != "PENDIENTE" ? true : false}
                                                        placeholder="Selecione"
                                                        id="FPago"
                                                        name="FPago"
                                                        styles={colourStyles}
                                                        onChange={v => { setFieldValue("FPago", v.value) }}
                                                        onBlur={handleBlur}
                                                        value={displayitemText(values.FPago, catalogos.FormaPago)}
                                                        options={mapitems(catalogos.FormaPago ? catalogos.FormaPago : [], '')}
                                                        noOptionsMessage={() => "Sin opciones"}
                                                    />
                                                    <span className="help-block">{errors.FPago}</span>
                                                </div>
                                            </div>
                                            <div className='col-md-4'>
                                                <div className='form-group'>
                                                    <label>Importe Pagado</label>
                                                    <CurrencyInputField
                                                        disabled={true}
                                                        className='form-control input-sm numeric'
                                                        min={0}
                                                        maxLength={10}
                                                        //prefix='$'
                                                        decimalSeparator='.'
                                                        groupSeparator=','
                                                        decimalsLimit={2}
                                                        decimalScale={2}
                                                        onFocus={FocusInput}
                                                        allowNegativeValue={false}
                                                        value={values.ImportePagado ? values.ImportePagado : '0'}
                                                        onValueChange={(value, name) => { setFieldValue(name, value)/* ,ReloadPrices(values) */ }}
                                                        id='ImportePagado'
                                                        name='ImportePagado'
                                                        autoComplete='off'
                                                    />
                                                </div>
                                            </div>
                                        </div>
                                        <div className='row'>
                                            <div className='col-md-4'>
                                                <div className='form-group'>
                                                    <label>Fecha Cancelacion</label>
                                                    <input type="date" id='FCancelacion' disabled={true} name='FCancelacion' className='form-control' onChange={handleChange} value={values.FCancelacion ? moment(values.FCancelacion).format("YYYY-MM-DD") : ''} />
                                                </div>
                                            </div>
                                            <div className='col-md-4'>
                                                <div className='form-group'>
                                                    <label>Fecha Captura</label>
                                                    <input type="date" id='FCaptura' name='FCaptura' disabled={(values.ID ? values.ID : 0) > 0 ? true : false} className='form-control' onChange={handleChange} value={values.FCaptura ? moment(values.FCaptura).format("YYYY-MM-DD") : ''} />
                                                    <span className="help-block">{errors.FCaptura}</span>
                                                </div>
                                            </div>
                                            <div className='col-md-4'>
                                                <div className='form-group'>
                                                    <label>Importe Forma Pago</label>
                                                    <CurrencyInputField
                                                        disabled={(values.Estatus ? values.Estatus : "") != "PENDIENTE" ? true : false}
                                                        className='form-control input-sm numeric'
                                                        min={0}
                                                        maxLength={10}
                                                        //prefix='$'
                                                        decimalSeparator='.'
                                                        groupSeparator=','
                                                        decimalsLimit={2}
                                                        decimalScale={2}
                                                        onFocus={FocusInput}
                                                        allowNegativeValue={false}
                                                        value={values.ImporteFpago ? values.ImporteFpago : '0'}
                                                        onValueChange={(value, name) => { setFieldValue(name, value)/* ,ReloadPrices(values) */ }}
                                                        id='ImporteFpago'
                                                        name='ImporteFpago'
                                                        autoComplete='off'
                                                    />
                                                    <span className="help-block">{errors.ImporteFpago}</span>
                                                </div>
                                            </div>
                                        </div>
                                        <div className='row'>
                                            <div className='col-md-12'>
                                                <div className='form-group'>
                                                    <label>Concepto</label>
                                                    <textarea disabled={(values.Estatus ? values.Estatus : "") != "PENDIENTE" ? true : false} name="Concepto" className='form-control' onChange={(e) => setFieldValue('Concepto', e.target.value)} value={values.Concepto ? values.Concepto : ''} id="Concepto" style={{ height: '50px', width: '100%' }}>{values.Concepto}</textarea>
                                                    <span className="help-block">{errors.Concepto}</span>
                                                </div>
                                            </div>
                                        </div>

                                    </div>
                                    {state.Estatus == "PENDIENTE" && (
                                        <div className="modal-footer">
                                            <div className="btn btn-secondary" style={{ backgroundColor: "#e8e8e8" }} data-dismiss="modal">Cerrar</div>
                                            <button type='submit' className="btn btn-primary">Guardar</button>
                                        </div>
                                    )}
                                </div>
                            </div>
                        </form>
                    </div>
                )}
            </Formik>
        </>
    )
})
export default ModalPrestamo;
