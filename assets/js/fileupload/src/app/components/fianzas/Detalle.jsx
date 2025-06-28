import React, { useEffect, useState, useRef } from 'react'
import Select from "react-select";
import { mapitemsHijos,UpperCaseField } from '../../Helpers/FGeneral';
import CurrencyInputField from 'react-currency-input-field';

export default function Detalle(props) {
    const { values, state, handleChange, handleKeyDown, handleBlur, setFieldValue, displayitem, mapitems, GeConfigEspecial, ReloadPrices } = props;

    const colourStyles = {
        control: styles => ({
            ...styles,
            backgroundColor: "white",
            borderRadius: "0px",
            minHeight: "30px",
            maxHeight: 30,
            color: '#472380 !important'
        })
    };

    const FocusInput = (e) => {
        e.target.select();
    }

    function CalculateFunction() {
        var a = moment(values.IObligacion);
        var b = moment(values.FObligacion);
        //console.log("Calculo",b.diff(a, 'days'))
        setFieldValue('DObligacion', b.diff(a, 'days'));
    }
    function CalculoContrato() {
        var VContrato = parseFloat(values.VContato ? values.VContato : 0);
        var PContrato = parseFloat(values.PContrato ? values.PContrato : 0) / 100;
        var VMonto = (VContrato * PContrato).toFixed(2);

        var VAmortizacion = parseFloat(values.Amortizacion);
        var VTarifa = parseFloat(values.Monto);
        var VBonificacionCia = parseFloat(values.BCia);
        var PBonificacionCia = parseFloat(values.PBCia) / 100;
        var VBonificacion = parseFloat(values.Bonificacion);
        var PBonificacion = parseFloat(values.PBonificacion) / 100;
        var MontoContrato = parseFloat(values.TcContrato);
        var Tarifa = parseFloat(values.Tarifa ? values.Tarifa : 0);
        var MontoConcentrado = parseFloat();

        //Ponemos los valores
        setFieldValue('Monto', VMonto);
        setFieldValue('Mconcentrado', VMonto);
        //se calcula la parte de la prima neta

        setFieldValue('PrimaNeta', (VContrato * Tarifa) / 100);
        setTimeout(() => {
            ReloadPrices(null);
        }, 100);


    }

    function displayOther(Id, array) {
        const _array = array;
        var rArray = [];
        const newData = _array.filter((item, index) => parseInt(item.Id) === parseInt(Id));
        //console.log("NewData", newData);
        if (newData.length > 0) {
            rArray = newData[0];
        }
        return rArray;
    }

    return (
        <div className="tab-pane fade" id="detalle-fianza" role="tabpanel" aria-labelledby="detalle-fianza-tab">
            <div className='row' style={{ height: '620px' }}>
                <div className='col-md-8'>
                    <div className='row'>
                        <div className='col-md-12'>
                            <div className='form-group'>
                                <label htmlFor="txMotivo">Beneficiario</label>
                                <Select
                                    placeholder="Selecione"
                                    id="Beneficiario"
                                    name="Beneficiario"
                                    styles={colourStyles}
                                    onChange={v => { setFieldValue("Beneficiario", v.value) }}
                                    onBlur={handleBlur}
                                    //value={displayitem(values.Beneficiario, state.InitialData.TipoDocumento)}
                                    //options={mapitems(state.InitialData.TipoDocumento ? state.InitialData.TipoDocumento : [], '')}
                                    noOptionsMessage={() => "Sin opciones"}
                                />
                            </div>
                        </div>
                    </div>
                    <div className='row'>
                        <div className='col-md-6'>
                            <div className='form-group'>
                                <label htmlFor="txMotivo">Tipo Fianza</label>
                                <Select
                                    placeholder="Selecione"
                                    id="TipoFianza"
                                    name="TipoFianza"
                                    styles={colourStyles}
                                    onChange={v => { setFieldValue("TipoFianza", v.value), setFieldValue("Producto", '') }}
                                    onBlur={handleBlur}
                                    value={displayitem(values.TipoFianza, state.InitialData.TipoFianza)}
                                    options={mapitems(state.InitialData.TipoFianza ? state.InitialData.TipoFianza : [], '')}
                                    noOptionsMessage={() => "Sin opciones"}
                                />
                            </div>
                        </div>
                        <div className='col-md-6'>
                            <div className='form-group'>
                                <label htmlFor="txMotivo">Producto</label>
                                <Select
                                    placeholder="Selecione"
                                    id="Producto"
                                    name="Producto"
                                    styles={colourStyles}
                                    onChange={v => { setFieldValue("Producto", v.value) }}
                                    onBlur={(e) => { handleBlur(e), GeConfigEspecial() }}
                                    value={displayitem(values.Producto, state.InitialData.FianzaProducto)}
                                    options={mapitemsHijos(state.InitialData.FianzaProducto ? state.InitialData.FianzaProducto : [], values.TipoFianza)}
                                    noOptionsMessage={() => "Sin opciones"}
                                />
                            </div>
                        </div>
                    </div>
                    <div className='row'>
                        <div className='col-md-6'>
                            <div className='form-group'>
                                <label htmlFor="txMotivo">Contrato</label>
                                <input
                                    className="form-control input-sm"
                                    type="text"
                                    name="Contrato"
                                    id="Contrato"
                                    //onChange={handleChange}
                                    onChange={e=> setFieldValue("Contrato", UpperCaseField(e.target.value))}
                                    value={values.Contrato ? values.Contrato : ''}
                                />
                            </div>
                        </div>
                        <div className='col-md-6'>
                            <div className='form-group'>
                                <label htmlFor="txMotivo">Folio </label>
                                <input
                                    className="form-control input-sm"
                                    type="text"
                                    name="FolioC"
                                    id="FolioC"
                                    //onChange={handleChange}
                                    onChange={e=> setFieldValue("FolioC", UpperCaseField(e.target.value))}
                                    value={values.FolioC ? values.FolioC : ''}
                                />
                            </div>
                        </div>
                    </div>
                    <div className='row'>
                        <div className='col-md-5'>
                            <div className='form-group'>
                                <label htmlFor="txMotivo">Inicio obligación </label>
                                <input
                                    className="form-control input-sm"
                                    type="date"
                                    name="IObligacion"
                                    id="IObligacion"
                                    onBlur={() => CalculateFunction()}
                                    onChange={handleChange}
                                    //onChange={e=> setFieldValue("IObligacion", UpperCaseField(e.target.value))}
                                    value={values.IObligacion ? moment(values.IObligacion).format("YYYY-MM-DD") : ''}
                                //value={values.IObligacion ? values.IObligacion : ''}
                                />
                            </div>
                        </div>
                        <div className='col-md-5'>
                            <div className='form-group'>
                                <label htmlFor="txMotivo">Fin obligación </label>
                                <input
                                    className="form-control input-sm"
                                    type="date"
                                    onBlur={() => CalculateFunction()}
                                    name="FObligacion"
                                    id="FObligacion"
                                    onChange={handleChange}
                                    value={values.FObligacion ? moment(values.FObligacion).format("YYYY-MM-DD") : ''}
                                //value={values.FObligacion ? values.FObligacion : ''}
                                />
                            </div>
                        </div>
                        <div className='col-md-2'>
                            <div className='form-group'>
                                <label htmlFor="txMotivo">Dias O </label>
                                <input
                                    disabled={true}
                                    className="form-control input-sm"
                                    type="text"
                                    name="DObligacion"
                                    id="DObligacion"
                                    onChange={handleChange}
                                    value={values.DObligacion ? values.DObligacion : '0'}
                                />
                            </div>
                        </div>
                    </div>
                    <div className='row'>
                        <div className='col-md-12'>
                            <div className='form-group'>
                                <label htmlFor="txMotivo">Relativo </label>
                                <textarea
                                    className="form-control input-sm"
                                    name="Relativo"
                                    id="Relativo"
                                    value={values.Relativo ? values.Relativo : ''}
                                    //onChange={handleChange}
                                    onChange={e=> setFieldValue("Relativo", UpperCaseField(e.target.value))}
                                    >
                                    {values.Relativo ? values.Relativo : ''}
                                </textarea>
                            </div>
                        </div>
                    </div>
                    <div className='row'>
                        <div className='col-md-12'>
                            <div className='form-group'>
                                <label htmlFor="txMotivo">Base</label>
                                <input
                                    className="form-control input-sm"
                                    type="text"
                                    name="Base"
                                    id="Base"
                                    //onChange={handleChange}
                                    onChange={e=> setFieldValue("Base", UpperCaseField(e.target.value))}
                                    value={values.Base ? values.Base : ''}
                                />
                            </div>
                        </div>
                    </div>
                    <div className='row'>
                        <div className='col-md-12'>
                            <div className='form-group'>
                                <label htmlFor="txMotivo">Solicitante</label>
                                <Select
                                    placeholder="Selecione"
                                    id="Solicitante"
                                    name="Solicitante"
                                    styles={colourStyles}
                                    onChange={v => { setFieldValue("Solicitante", v.value) }}
                                    onBlur={handleBlur}
                                    value={displayitem(values.Solicitante, state.InitialData.TipoDocumento)}
                                    options={mapitems([] ? [] : [], '')}
                                    noOptionsMessage={() => "Sin opciones"}
                                />
                            </div>
                        </div>
                    </div>
                    <div className='row'>
                        <div className='col-md-6'>
                            <div className='form-group'>
                                <label htmlFor="txMotivo">Puesto</label>
                                <input
                                    className="form-control input-sm"
                                    type="text"
                                    name="Puesto"
                                    id="Puesto"
                                    //onChange={handleChange}
                                    onChange={e=> setFieldValue("Puesto", UpperCaseField(e.target.value))}
                                    value={values.Puesto ? values.Puesto : ''}
                                />
                            </div>
                        </div>
                        <div className='col-md-6'>
                            <div className='form-group'>
                                <label htmlFor="txMotivo">Referencia</label>
                                <input
                                    className="form-control input-sm"
                                    type="text"
                                    name="Referencia"
                                    id="Referencia"
                                    //onChange={handleChange}
                                    onChange={e=> setFieldValue("Referencia", UpperCaseField(e.target.value))}
                                    value={values.Referencia ? values.Referencia : ''}
                                />
                            </div>
                        </div>
                    </div>
                    <div className='row'>
                        <div className='col-md-12'>
                            <div className='form-group'>
                                <label htmlFor="txMotivo">Proyecto Fianzas</label>
                                <Select
                                    placeholder="Selecione"
                                    id="PFianza"
                                    name="PFianza"
                                    styles={colourStyles}
                                    onChange={v => { setFieldValue("PFianza", v.value) }}
                                    onBlur={handleBlur}
                                    value={displayitem(values.PFianza, state.InitialData.TipoDocumento)}
                                    options={mapitems([] ? [] : [], '')}
                                    noOptionsMessage={() => "Sin opciones"}
                                />
                            </div>
                        </div>
                    </div>
                </div>
                <div className='col-md-4'>
                    <div className='row'>
                        <div className='col-md-6'>
                            <div className='form-group'>
                                <label htmlFor="txMotivo">Valor contrato</label>
                                <CurrencyInputField
                                    className='form-control input-sm numeric'
                                    onBlur={() => { CalculoContrato() }}
                                    min={0}
                                    maxLength={10}
                                    //prefix='$'
                                    decimalSeparator='.'
                                    groupSeparator=','
                                    onFocus={FocusInput}
                                    allowNegativeValue={false}
                                    value={values.VContato ? values.VContato : '0'}
                                    onValueChange={(value, name) => { setFieldValue(name, value)/* ,ReloadPrices(values) */ }}
                                    id='VContato'
                                    name='VContato'
                                    autoComplete='off'
                                />
                            </div>
                        </div>
                        <div className='col-md-6'>
                            <div className='form-group'>
                                <label htmlFor="txMotivo">% contrato</label>
                                <CurrencyInputField
                                    className='form-control input-sm numeric'
                                    onBlur={() => { CalculoContrato() }}
                                    min={0}
                                    maxLength={10}
                                    //prefix='$'
                                    decimalSeparator='.'
                                    groupSeparator=','
                                    onFocus={FocusInput}
                                    allowNegativeValue={false}
                                    value={values.PContrato ? values.PContrato : '0'}
                                    onValueChange={(value, name) => { setFieldValue(name, value)/* ,ReloadPrices(values) */ }}
                                    id='PContrato'
                                    name='PContrato'
                                    autoComplete='off'
                                />
                            </div>
                        </div>
                    </div>
                    <div className='row'>
                        <div className='col-md-6'>
                            <div className='form-group'>
                                <label htmlFor="txMotivo">Monto</label>
                                <CurrencyInputField
                                    className='form-control input-sm numeric'
                                    onBlur={() => { CalculoContrato() }}
                                    min={0}
                                    maxLength={10}
                                    //prefix='$'
                                    decimalSeparator='.'
                                    groupSeparator=','
                                    onFocus={FocusInput}
                                    allowNegativeValue={false}
                                    value={values.Monto ? values.Monto : '0'}
                                    onValueChange={(value, name) => { setFieldValue(name, value)/* ,ReloadPrices(values) */ }}
                                    id='Monto'
                                    name='Monto'
                                    autoComplete='off'
                                />
                            </div>
                        </div>
                        <div className='col-md-6'>
                            <div className='form-group'>
                                <label htmlFor="txMotivo">Tarifa</label>
                                <CurrencyInputField
                                    className='form-control input-sm numeric'
                                    onBlur={() => { CalculoContrato() }}
                                    min={0}
                                    maxLength={10}
                                    //prefix='$'
                                    decimalSeparator='.'
                                    groupSeparator=','
                                    onFocus={FocusInput}
                                    allowNegativeValue={false}
                                    value={values.Tarifa ? values.Tarifa : '0'}
                                    onValueChange={(value, name) => { setFieldValue(name, value)/* ,ReloadPrices(values) */ }}
                                    id='Tarifa'
                                    name='Tarifa'
                                    autoComplete='off'
                                />
                            </div>
                        </div>
                    </div>
                    <div className='row'>
                        <div className='col-md-6'>
                            <div className='form-group'>
                                <label htmlFor="txMotivo">Amortización</label>
                                <CurrencyInputField
                                    className='form-control input-sm numeric'
                                    onBlur={() => { CalculoContrato() }}
                                    min={0}
                                    maxLength={10}
                                    //prefix='$'
                                    decimalSeparator='.'
                                    groupSeparator=','
                                    onFocus={FocusInput}
                                    allowNegativeValue={false}
                                    value={values.Amortizacion ? values.Amortizacion : '0'}
                                    onValueChange={(value, name) => { setFieldValue(name, value)/* ,ReloadPrices(values) */ }}
                                    id='Amortizacion'
                                    name='Amortizacion'
                                    autoComplete='off'
                                />
                            </div>
                        </div>
                    </div>
                    <div className='row'>
                        <div className='col-md-6'>
                            <div className='form-group'>
                                <label htmlFor="txMotivo">Bonificación Cia</label>
                                <CurrencyInputField
                                    className='form-control input-sm numeric'
                                    onBlur={() => { CalculoContrato() }}
                                    min={0}
                                    maxLength={10}
                                    //prefix='$'
                                    decimalSeparator='.'
                                    groupSeparator=','
                                    onFocus={FocusInput}
                                    allowNegativeValue={false}
                                    value={values.BCia ? values.BCia : '0'}
                                    onValueChange={(value, name) => { setFieldValue(name, value)/* ,ReloadPrices(values) */ }}
                                    id='BCia'
                                    name='BCia'
                                    autoComplete='off'
                                />
                            </div>
                        </div>
                        <div className='col-md-6'>
                            <div className='form-group'>
                                <label htmlFor="txMotivo">% </label>
                                <CurrencyInputField
                                    className='form-control input-sm numeric'
                                    onBlur={() => { CalculoContrato() }}
                                    min={0}
                                    maxLength={10}
                                    //prefix='$'
                                    decimalSeparator='.'
                                    groupSeparator=','
                                    onFocus={FocusInput}
                                    allowNegativeValue={false}
                                    value={values.PBCia ? values.PBCia : '0'}
                                    onValueChange={(value, name) => { setFieldValue(name, value)/* ,ReloadPrices(values) */ }}
                                    id='PBCia'
                                    name='PBCia'
                                    autoComplete='off'
                                />
                            </div>
                        </div>
                    </div>
                    <div className='row'>
                        <div className='col-md-6'>
                            <div className='form-group'>
                                <label htmlFor="txMotivo">Bonificación</label>
                                <CurrencyInputField
                                    className='form-control input-sm numeric'
                                    onBlur={() => { CalculoContrato() }}
                                    min={0}
                                    maxLength={10}
                                    //prefix='$'
                                    decimalSeparator='.'
                                    groupSeparator=','
                                    onFocus={FocusInput}
                                    allowNegativeValue={false}
                                    value={values.Bonificacion ? values.Bonificacion : '0'}
                                    onValueChange={(value, name) => { setFieldValue(name, value)/* ,ReloadPrices(values) */ }}
                                    id='Bonificacion'
                                    name='Bonificacion'
                                    autoComplete='off'
                                />
                            </div>
                        </div>
                        <div className='col-md-6'>
                            <div className='form-group'>
                                <label htmlFor="txMotivo">% </label>
                                <CurrencyInputField
                                    className='form-control input-sm numeric'
                                    onBlur={() => { CalculoContrato() }}
                                    min={0}
                                    maxLength={10}
                                    //prefix='$'
                                    decimalSeparator='.'
                                    groupSeparator=','
                                    onFocus={FocusInput}
                                    allowNegativeValue={false}
                                    value={values.PBonificacion ? values.PBonificacion : '0'}
                                    onValueChange={(value, name) => { setFieldValue(name, value)/* ,ReloadPrices(values) */ }}
                                    id='PBonificacion'
                                    name='PBonificacion'
                                    autoComplete='off'
                                />
                            </div>
                        </div>
                    </div>
                    <div className='row'>
                        <div className='col-md-6'>
                            <div className='form-group'>
                                <label htmlFor="txMotivo">Moneda Contrato</label>
                                <Select
                                    placeholder="Selecione"
                                    id="MonContrato"
                                    name="MonContrato"
                                    styles={colourStyles}
                                    onChange={v => {
                                        setFieldValue("MonContrato", v.value),
                                            //console.log("TcCambio",displayOther(v.value, state.InitialData.Monedas).TipoCambio),
                                            setFieldValue('TcContrato', displayOther(v.value, state.InitialData.Monedas).TipoCambio ? displayOther(v.value, state.InitialData.Monedas).TipoCambio : '')
                                    }}
                                    onBlur={handleBlur}
                                    value={displayitem(values.MonContrato, state.InitialData.Monedas)}
                                    options={mapitems(state.InitialData.Monedas ? state.InitialData.Monedas : [], '')}
                                    noOptionsMessage={() => "Sin opciones"}
                                />
                            </div>
                        </div>
                        <div className='col-md-6'>
                            <div className='form-group'>
                                <label htmlFor="txMotivo">Tc contrato</label>
                                <input
                                    className="form-control input-sm numeric"
                                    type="text"
                                    name="TcContrato"
                                    id="TcContrato"
                                    onChange={handleChange}
                                    value={values.TcContrato ? values.TcContrato : '0'}
                                />
                            </div>
                        </div>
                    </div>
                    <div className='row'>
                        <div className='col-md-12'>
                            <div className='form-group'>
                                <label htmlFor="txMotivo">Monto Contrato</label>
                                <CurrencyInputField
                                    className='form-control input-sm numeric'
                                    onBlur={() => { CalculoContrato() }}
                                    min={0}
                                    maxLength={10}
                                    //prefix='$'
                                    decimalSeparator='.'
                                    groupSeparator=','
                                    onFocus={FocusInput}
                                    allowNegativeValue={false}
                                    value={values.Mcontrato ? values.Mcontrato : '0'}
                                    onValueChange={(value, name) => { setFieldValue(name, value)/* ,ReloadPrices(values) */ }}
                                    id='Mcontrato'
                                    name='Mcontrato'
                                    autoComplete='off'
                                />
                            </div>
                        </div>
                    </div>
                    <div className='row'>
                        <div className='col-md-12'>
                            <div className='form-group'>
                                <label htmlFor="txMotivo">Monto Concentrado</label>
                                <CurrencyInputField
                                    className='form-control input-sm numeric'
                                    onBlur={() => { CalculoContrato() }}
                                    min={0}
                                    maxLength={10}
                                    //prefix='$'
                                    decimalSeparator='.'
                                    groupSeparator=','
                                    onFocus={FocusInput}
                                    allowNegativeValue={false}
                                    value={values.Mconcentrado ? values.Mconcentrado : '0'}
                                    onValueChange={(value, name) => { setFieldValue(name, value)/* ,ReloadPrices(values) */ }}
                                    id='Mconcentrado'
                                    name='Mconcentrado'
                                    autoComplete='off'
                                />
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    )
}
