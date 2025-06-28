import React from 'react';
import Select from "react-select";
import CurrencyInputField from 'react-currency-input-field';
import { UpperCaseField } from '../../Helpers/FGeneral';


export default function DetalleFianza() {
    return (
        <div className="tab-pane fade" id="detalle-fianza" role="tabpanel" aria-labelledby="detalle-fianza-tab">
            <div className='row'>
                <div className='col-md-12'>
                    <div className="form-group">
                        <label htmlFor="txMotivo">Beneficiario</label>
                        <Select
                            placeholder="Selecione"
                            id="IDConductor"
                            name="IDConductor"
                            styles={colourStyles}
                            onChange={v => { setFieldValue("IDConductor", v.value) }}
                            onBlur={handleBlur}
                            value={displayitem(values.TipoDocto, state.InitialData.TipoDocumento)}
                            options={mapitems(state.InitialData.TipoDocumento ? state.InitialData.TipoDocumento : [], '')}
                            noOptionsMessage={() => "Sin opciones"}
                        />
                    </div>
                </div>
            </div>
            <div className='row'>
                <div className='col-md-8'>
                    <div className='row'>
                        <div className='col-md-6'>
                            <div className="form-group">
                                <label htmlFor="txMotivo">Tipo Fianza</label>
                                <Select
                                    placeholder="Selecione"
                                    id="IDConductor"
                                    name="IDConductor"
                                    styles={colourStyles}
                                    onChange={v => { setFieldValue("IDConductor", v.value) }}
                                    onBlur={handleBlur}
                                    value={displayitem(values.TipoDocto, state.InitialData.TipoDocumento)}
                                    options={mapitems(state.InitialData.TipoDocumento ? state.InitialData.TipoDocumento : [], '')}
                                    noOptionsMessage={() => "Sin opciones"}
                                />
                            </div>
                        </div>
                        <div className='col-md-6'>
                            <div className="form-group">
                                <label htmlFor="txMotivo">Producto</label>
                                <Select
                                    placeholder="Selecione"
                                    id="IDConductor"
                                    name="IDConductor"
                                    styles={colourStyles}
                                    onChange={v => { setFieldValue("IDConductor", v.value) }}
                                    onBlur={handleBlur}
                                    value={displayitem(values.TipoDocto, state.InitialData.TipoDocumento)}
                                    options={mapitems(state.InitialData.TipoDocumento ? state.InitialData.TipoDocumento : [], '')}
                                    noOptionsMessage={() => "Sin opciones"}
                                />
                            </div>
                        </div>
                        <div className='col-md-6'>
                            <div className="form-group">
                                <label htmlFor="txMotivo">Contrato</label>
                                <input
                                    className="form-control input-sm"
                                    type="text"
                                    name="Contrato"
                                    id="Contrato"
                                    onChange={handleChange}
                                    value={values.Contrato ? values.Contrato : ''}
                                />
                            </div>
                        </div>
                        <div className='col-md-6'>
                            <div className="form-group">
                                <label htmlFor="txMotivo">Folio</label>
                                <input
                                    className="form-control input-sm"
                                    type="text"
                                    name="FolioDFianza"
                                    id="FolioDFianza"
                                    onChange={handleChange}
                                    value={values.FolioDFianza ? values.FolioDFianza : ''}
                                />
                            </div>
                        </div>
                        <div className='col-md-4'>
                            <div className="form-group">
                                <label htmlFor="txMotivo">Inicio Obligación</label>
                                <input
                                    className="form-control input-sm"
                                    type="date"
                                    name="IObligacion"
                                    id="IObligacion"
                                    onChange={handleChange}
                                    value={values.FRecepcion ? moment(values.IObligacion).format("YYYY-MM-DD") : ''}
                                />
                            </div>
                        </div>
                        <div className='col-md-4'>
                            <div className="form-group">
                                <label htmlFor="txMotivo">Fin Obligación</label>
                                <input
                                    className="form-control input-sm"
                                    type="date"
                                    name="FObligacion"
                                    id="FObligacion"
                                    onChange={handleChange}
                                    value={values.FObligacion ? moment(values.FObligacion).format("YYYY-MM-DD") : ''}
                                />
                            </div>
                        </div>
                        <div className='col-md-4'>
                            <div className="form-group">
                                <label htmlFor="txMotivo">Dias obligacion</label>
                                <input
                                    className="form-control input-sm"
                                    type="text"
                                    name="DObligacion"
                                    id="DObligacion"
                                    onChange={handleChange}
                                    value={values.DObligacion ? moment(values.DObligacion).format("YYYY-MM-DD") : ''}
                                />
                            </div>
                        </div>
                        <div className='col-md-12'>
                            <div className="form-group">
                                <label htmlFor="txMotivo">Relativo</label>
                                <textarea name="Relativo" className='form-control input-sm'
                                    onChange={handleChange}
                                    value={values.Relativo ? values.Relativo : ''}
                                    style={{ height: '250px' }}>
                                    {values.Relativo ? values.Relativo : ''}
                                </textarea>
                            </div>
                        </div>
                        <div className='col-md-12'>
                            <div className="form-group">
                                <label htmlFor="txMotivo">Base</label>
                                <input
                                    className="form-control input-sm"
                                    type="date"
                                    name="Base"
                                    id="Base"
                                    onChange={handleChange}
                                    value={values.Base ? moment(values.Base).format("YYYY-MM-DD") : ''}
                                />
                            </div>
                        </div>
                        <div className='col-md-12'>
                            <div className="form-group">
                                <label htmlFor="txMotivo">Solicitante</label>
                                <Select
                                    placeholder="Selecione"
                                    id="Solicitante"
                                    name="Solicitante"
                                    styles={colourStyles}
                                    onChange={v => { setFieldValue("Solicitante", v.value) }}
                                    onBlur={handleBlur}
                                    value={displayitem(values.Solicitante, state.InitialData.TipoDocumento)}
                                    options={mapitems(state.InitialData.TipoDocumento ? state.InitialData.TipoDocumento : [], '')}
                                    noOptionsMessage={() => "Sin opciones"}
                                />
                            </div>
                        </div>
                        <div className='col-md-6'>
                            <div className="form-group">
                                <label htmlFor="txMotivo">Puesto</label>
                                <input
                                    className="form-control input-sm"
                                    type="text"
                                    name="FPuesto"
                                    id="FPuesto"
                                    onChange={handleChange}
                                    value={values.FPuesto ? values.FPuesto : ''}
                                />
                            </div>
                        </div>
                        <div className='col-md-6'>
                            <div className="form-group">
                                <label htmlFor="txMotivo">Referencia</label>
                                <input
                                    className="form-control input-sm"
                                    type="text"
                                    name="FReferencia"
                                    id="FReferencia"
                                    onChange={handleChange}
                                    value={values.FReferencia ? values.FReferencia : ''}
                                />
                            </div>
                        </div>
                        <div className='col-md-12'>
                            <div className="form-group">
                                <label htmlFor="txMotivo">Proyecto fianzas</label>
                                <Select
                                    placeholder="Selecione"
                                    id="IDPFianzas"
                                    name="IDPFianzas"
                                    styles={colourStyles}
                                    onChange={v => { setFieldValue("IDPFianzas", v.value) }}
                                    onBlur={handleBlur}
                                    value={displayitem(values.IDPFianzas, state.InitialData.TipoDocumento)}
                                    options={mapitems(state.InitialData.TipoDocumento ? state.InitialData.TipoDocumento : [], '')}
                                    noOptionsMessage={() => "Sin opciones"}
                                />
                            </div>
                        </div>
                    </div>
                </div>
                <div className='col-md-4'>
                    <div className='row'>
                        <div className='col-md-6'>
                            <div className="form-group">
                                <label htmlFor="txMotivo">Valor Contratado</label>
                                <CurrencyInputField
                                    className='form-control input-sm numeric'
                                    //style={{ width: '80px' }}
                                    onBlur={handleBlur}
                                    min={0}
                                    maxLength={10}
                                    prefix=''
                                    decimalSeparator='.'
                                    groupSeparator=','
                                    onFocus={FocusInput}
                                    allowNegativeValue={false}
                                    value={item.VContrato}
                                    onValueChange={(value, name) => setFieldValue(name, value)}
                                    id='VContrato'
                                    name='VContrato'
                                    autoComplete='off'
                                />
                            </div>
                        </div>
                        <div className='col-md-6'>
                            <div className="form-group">
                                <label htmlFor="txMotivo">% de contrato</label>
                                <CurrencyInputField
                                    className='form-control input-sm numeric'
                                    //style={{ width: '80px' }}
                                    onBlur={handleBlur}
                                    min={0}
                                    maxLength={10}
                                    prefix=''
                                    decimalSeparator='.'
                                    groupSeparator=','
                                    onFocus={FocusInput}
                                    allowNegativeValue={false}
                                    value={item.PContrato}
                                    onValueChange={(value, name) => setFieldValue(name, value)}
                                    id='PContrato'
                                    name='PContrato'
                                    autoComplete='off'
                                />
                            </div>
                        </div>
                        <div className='col-md-6'>
                            <div className="form-group">
                                <label htmlFor="txMotivo">Monto</label>
                                <CurrencyInputField
                                    className='form-control input-sm numeric'
                                    //style={{ width: '80px' }}
                                    onBlur={handleBlur}
                                    min={0}
                                    maxLength={10}
                                    prefix=''
                                    decimalSeparator='.'
                                    groupSeparator=','
                                    onFocus={FocusInput}
                                    allowNegativeValue={false}
                                    value={item.FMonto}
                                    onValueChange={(value, name) => setFieldValue(name, value)}
                                    id='FMonto'
                                    name='FMonto'
                                    autoComplete='off'
                                />
                            </div>
                        </div>
                        <div className='col-md-6'>
                            <div className="form-group">
                                <label htmlFor="txMotivo">Tarifa</label>
                                <CurrencyInputField
                                    className='form-control input-sm numeric'
                                    //style={{ width: '80px' }}
                                    onBlur={handleBlur}
                                    min={0}
                                    maxLength={10}
                                    prefix=''
                                    decimalSeparator='.'
                                    groupSeparator=','
                                    onFocus={FocusInput}
                                    allowNegativeValue={false}
                                    value={item.FTarifa}
                                    onValueChange={(value, name) => setFieldValue(name, value)}
                                    id='FTarifa'
                                    name='FTarifa'
                                    autoComplete='off'
                                />
                            </div>
                        </div>
                        <div className='col-md-12'>
                            <div className="form-group">
                                <label htmlFor="txMotivo">Autorizacion</label>
                                <CurrencyInputField
                                    className='form-control input-sm numeric'
                                    //style={{ width: '80px' }}
                                    onBlur={handleBlur}
                                    min={0}
                                    maxLength={10}
                                    prefix=''
                                    decimalSeparator='.'
                                    groupSeparator=','
                                    onFocus={FocusInput}
                                    allowNegativeValue={false}
                                    value={item.FAutorizacion}
                                    onValueChange={(value, name) => setFieldValue(name, value)}
                                    id='FAutorizacion'
                                    name='FAutorizacion'
                                    autoComplete='off'
                                />
                            </div>
                        </div>
                        <div className='col-md-6'>
                            <div className="form-group">
                                <label htmlFor="txMotivo">Bonificacion CIA</label>
                                <CurrencyInputField
                                    className='form-control input-sm numeric'
                                    //style={{ width: '80px' }}
                                    onBlur={handleBlur}
                                    min={0}
                                    maxLength={10}
                                    prefix=''
                                    decimalSeparator='.'
                                    groupSeparator=','
                                    onFocus={FocusInput}
                                    allowNegativeValue={false}
                                    value={item.FBonCia}
                                    onValueChange={(value, name) => setFieldValue(name, value)}
                                    id='FBonCia'
                                    name='FBonCia'
                                    autoComplete='off'
                                />
                            </div>
                        </div>
                        <div className='col-md-6'>
                            <div className="form-group">
                                <label htmlFor="txMotivo">%</label>
                                <CurrencyInputField
                                    className='form-control input-sm numeric'
                                    //style={{ width: '80px' }}
                                    onBlur={handleBlur}
                                    min={0}
                                    maxLength={10}
                                    prefix=''
                                    decimalSeparator='.'
                                    groupSeparator=','
                                    onFocus={FocusInput}
                                    allowNegativeValue={false}
                                    value={item.FPBonCia}
                                    onValueChange={(value, name) => setFieldValue(name, value)}
                                    id='FPBonCia'
                                    name='FPBonCia'
                                    autoComplete='off'
                                />
                            </div>
                        </div>
                        <div className='col-md-6'>
                            <div className="form-group">
                                <label htmlFor="txMotivo">Bonificacion</label>
                                <CurrencyInputField
                                    className='form-control input-sm numeric'
                                    //style={{ width: '80px' }}
                                    onBlur={handleBlur}
                                    min={0}
                                    maxLength={10}
                                    prefix=''
                                    decimalSeparator='.'
                                    groupSeparator=','
                                    onFocus={FocusInput}
                                    allowNegativeValue={false}
                                    value={item.FBon}
                                    onValueChange={(value, name) => setFieldValue(name, value)}
                                    id='FBon'
                                    name='FBon'
                                    autoComplete='off'
                                />
                            </div>
                        </div>
                        <div className='col-md-6'>
                            <div className="form-group">
                                <label htmlFor="txMotivo">%</label>
                                <CurrencyInputField
                                    className='form-control input-sm numeric'
                                    //style={{ width: '80px' }}
                                    onBlur={handleBlur}
                                    min={0}
                                    maxLength={10}
                                    prefix=''
                                    decimalSeparator='.'
                                    groupSeparator=','
                                    onFocus={FocusInput}
                                    allowNegativeValue={false}
                                    value={item.FPCIA}
                                    onValueChange={(value, name) => setFieldValue(name, value)}
                                    id='FPBon'
                                    name='FPBon'
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
