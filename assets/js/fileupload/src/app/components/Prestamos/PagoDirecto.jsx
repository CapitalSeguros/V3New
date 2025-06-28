import React, { useState, useEffect, forwardRef, useImperativeHandle, useRef } from 'react';
import Select from "react-select";
import { Form, Formik } from "formik";
import { LockEnter, colourStyles, FocusInput, displayitem, mapitems, displayitemText, FormatItem } from '../../Helpers/FGeneral.js';
import CurrencyInputField from 'react-currency-input-field';
import { CallApiGet, CallApiPost } from '../../Helpers/Calls.js';
import { validationPrestamo } from '../../Helpers/Validations.js';

const PagoDirecto = forwardRef((props, ref) => {
    useImperativeHandle(ref, () => {
        return {
            Initial: (ID) => {
                getInitial(ID)
            }
        }
    });


    const { callback, UrlServicio, UrlPagina, Reload } = props;
    const formikRef = useRef(null);
    let initial = {
        Item: {
            FormaPPago: "",
            ImportePago: "",
            FPPago: ""
        },
        Pagado: "",
        Pendiente: [],
        FormasPago: []
    };
    const [catalogos, SetCatalogos] = useState(initial);

    async function getInitial(Id) {
        const res = await CallApiGet(`${UrlServicio}prestamos/pagoInitial`, { ID: Id }, null);
        if (res.status != 200) {
            toastr.error(`Error ${res.error.Mensaje}`);
        } else {
            setTimeout(() => {
                SetCatalogos(res.success.Datos);
            }, 50);
        }
    }

    async function Save(values) {
        const res = await CallApiPost(`${UrlServicio}prestamos/pagoDirecto`, { data: values }, null);
        if (res.status != 200) {
            toastr.error(`Error ${res.error.Mensaje}`);
        } else {
            SetCatalogos(initial);
            Reload();
            $('#ModalPagoDirecto').modal('hide');
        }
    }


    return (
        <>
            <Formik
                innerRef={formikRef}
                initialValues={catalogos.Item}
                enableReinitialize="true"
                //validationSchema={validationPrestamo}
                onSubmit={(values, actions) => {
                    //console.log("valores", values);
                    let ConvertItem = {
                        RefId: values.ID,
                        Referencia: values.FormaPPago,
                        Importe: values.ImportePago,
                        FPago: values.FPPago
                    };
                    //console.log(ConvertItem)
                    Save(ConvertItem);
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
                    <div id="ModalPagoDirecto" className="modal fade" role="dialog">
                        <form onKeyDown={LockEnter} onSubmit={handleSubmit} className="form" autoComplete="off">
                            <div className="modal-dialog modal-lg">
                                <div className="modal-content">
                                    <div className="modal-header">
                                        <h5 className="modal-title">Pago Directo</h5>
                                        <a className='btn' onClick={() => console.log(values)}>test</a>
                                        <button type="button" className="close" data-dismiss="modal"><span style={{ color: "white" }}>&times;</span></button>
                                    </div>
                                    <div className="modal-body">
                                        <dl className="row">
                                            <dt className={"col-sm-12 text-left"} style={{paddingBottom:'10px'}}>INFORMACIÓN DEL PRESTAMO</dt>
                                            <dt className={"col-sm-2 text-left"}>Vendedor:</dt>
                                            <dd className={"col-sm-4 text-left"} style={{ color: "#000000" }}>{values.VendNom}</dd>
                                            <dt className={"col-sm-2 text-left"}>F Prestamo:</dt>
                                            <dd className={"col-sm-4 text-left"} style={{ color: "#000000" }}>{moment(values.FCaptura).format("DD/MM/YYYY")}</dd>
                                            <dt className={"col-sm-2 text-left"}>Importe:</dt>
                                            <dd className={"col-sm-2 text-left"} style={{ color: "#000000" }}>{FormatItem(values.Importe)}</dd>
                                            <dt className={"col-sm-2 text-left"}>Pagado:</dt>
                                            <dd className={"col-sm-2 text-left"} style={{ color: "#000000" }}>{FormatItem((catalogos.Pagado))}</dd>
                                            <dt className={"col-sm-2 text-left"}>Pediente:</dt>
                                            <dd className={"col-sm-2 text-left"} style={{ color: "#000000" }}>{FormatItem((values.Importe - catalogos.Pagado))}</dd>
                                        </dl>
                                        <dl className='row'>
                                            <div className='col-md-4'>
                                                <div className='form-group'>
                                                    <label>Forma Pago</label>
                                                    <Select
                                                        placeholder="Selecione"
                                                        id="FormaPPago"
                                                        name="FormaPPago"
                                                        styles={colourStyles}
                                                        onChange={v => { setFieldValue("FormaPPago", v.label) }}
                                                        onBlur={handleBlur}
                                                        value={displayitemText(values.FormaPPago, catalogos.FormasPago)}
                                                        options={mapitems(catalogos.FormasPago ? catalogos.FormasPago : [], '')}
                                                        noOptionsMessage={() => "Sin opciones"}
                                                    />
                                                    <span className="help-block">{errors.VendNom}</span>
                                                </div>
                                            </div>
                                            <div className='col-md-4'>
                                                <div className='form-group'>
                                                    <label>Importe</label>
                                                    <CurrencyInputField
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
                                                        value={values.ImportePago ? values.ImportePago : '0'}
                                                        onValueChange={(value, name) => { setFieldValue(name, value)/* ,ReloadPrices(values) */ }}
                                                        id='ImportePago'
                                                        name='ImportePago'
                                                        autoComplete='off'
                                                    />
                                                    <span className="help-block">{errors.Importe}</span>
                                                </div>
                                            </div>
                                            <div className='col-md-4'>
                                                <div className='form-group'>
                                                    <label>Fecha pago</label>
                                                    <input type="date" id='FPPago' name='FPPago' className='form-control' onChange={handleChange} value={values.FPPago ? moment(values.FPPago).format("YYYY-MM-DD") : ''} />
                                                    <span className="help-block">{errors.FPPago}</span>
                                                </div>
                                            </div>
                                        </dl>


                                    </div>
                                    <div className="modal-footer">
                                        <div className="btn btn-secondary" style={{ backgroundColor: "#e8e8e8" }} data-dismiss="modal">Cerrar</div>
                                        <button type='submit' className="btn btn-primary">Guardar</button>
                                    </div>
                                </div>
                            </div>
                        </form>
                    </div>
                )}
            </Formik>
        </>
    )
})
export default PagoDirecto;
