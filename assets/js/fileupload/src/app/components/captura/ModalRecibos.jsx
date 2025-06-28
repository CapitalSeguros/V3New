import React, { useState, useEffect, useRef } from 'react';
import CurrencyInputField from 'react-currency-input-field';
import { CallApiGet, CallApiPost } from '../../Helpers/Calls.js';
import AllowElement from '../Acciones/AllowElements.jsx';
import { round } from '../../Helpers/FGeneral.js';


export default function ModalRecibos(props) {
    const { Item, SetItemRecibo, ItemInfoRecibo, ChangeValueRecibo, NewChangeValueRecibo,
        handleBlur, FocusInput, IndexRecibo, Tipo, ReloadAll,
        UrlServicio, ReloadRecibosSubsecuentes, itemSelected, setItemSelected, cancelAction, closeModal } = props;
    const [registros, SetRegistros] = useState([]);
    var test = Item.IDTemp ? Item.IDTemp : 0;
    const [Find, SetFind] = useState(0);
    async function FindPago(Id) {
        const res = await CallApiGet(`${UrlServicio}conciliacion/getpagobyrecibo`, { IdRecibo: Id }, null);
        if (res.status != 200) {
            //toastr.error(`Error ${res.error.Mensaje}`);
        } else {
            SetRegistros(res.success.Datos);
        }
    }
    if (test > 0 && test != Find) {
        SetFind(test);
        FindPago(test);
    }

    function sumaMontos() {
        if(Tipo == "F"){
            return round(parseFloat(Item.ComN) + parseFloat(Item.CGastosMaq) + parseFloat(Item.CGastosAdm) + parseFloat(Item.ComD) + parseFloat(Item.Especial) || 0, 4);
        }
        else if(Tipo == "P"){
            return round(parseFloat(Item.ComN) + parseFloat(Item.ComR) + parseFloat(Item.ComD) + parseFloat(Item.Especial) || 0, 4);
        }
        else{
            return 0;
        }
    }

    function sumaPorcentaje() {
        let porcentajeTotal = 0;

        if(Tipo == "F"){
            porcentajeTotal = round(parseFloat(Item.PComN) + parseFloat(Item.PCGastosMaq) + parseFloat(Item.PCGastosAdm) + parseFloat(Item.PComD) + parseFloat(Item.PEspecial) || 0, 4);
        }
        else if(Tipo == "P"){
            porcentajeTotal = round(parseFloat(Item.PComN) + parseFloat(Item.PComR) + parseFloat(Item.PComD) + parseFloat(Item.PEspecial) || 0, 4);
        }
        else{
            porcentajeTotal = 0;
        }

        if(Tipo == "F"){
            return round(parseFloat(porcentajeTotal / 5) || 0, 4);
        }
        else if(Tipo == "P"){
            return round(parseFloat(porcentajeTotal / 4) || 0, 4);
        }
        else{
            return 0;
        }
    }

    return (
        <div id="ModalRecibos" className="modal fade" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
            <div className="modal-dialog modal-xl" style={{ width: '100vw' }}>
                {/* <div className="modal-content" style={{ width: '85vw', marginLeft: '-12vw' }}> */}
                <div className="modal-content">
                    <div className="modal-body">
                        <div className='row'>
                            <div className='col-md-12'>
                                <button onClick={() => cancelAction(IndexRecibo, itemSelected)} type="button" className="close" data-dismiss="modal">&times;</button>
                            </div>
                        </div>
                        <div className='row'>
                            <div className='col-md-12'>
                                <ul className="nav nav-tabs nav-justified" id="generalRecibos" role="tablist">
                                    <li className="nav-item navr">
                                        <a className="nav-link active" id="home-tab" data-toggle="tab" href="#recibo-generales" role="tab" aria-controls="recibo-generales" aria-selected="true">Detalle del recibo</a>
                                    </li>
                                    {/*  <li className="nav-item navr">
                                        <a className="nav-link" id="detalle-recibo-tab" data-toggle="tab" href="#detalle-recibo" role="tab" aria-controls="detalle-recibo" aria-selected="false">Detalle Unidad</a>
                                    </li> */}
                                </ul>
                            </div>
                            <div className='col-md-12'>
                                <div className="tab-content" id="generalTabContentRecibos">
                                    <div className="tab-pane fade active show in" id="recibo-generales" role="tabpanel" aria-labelledby="recibo-generales-tab">
                                        <div className='row'>
                                            <div className='col-md-6'>
                                                <div className='row'>
                                                    <div className='col-md-9'>
                                                        <div className='form-group'>
                                                            <label>Documento</label>
                                                            <input type="text" className='form-control input-sm' name="Doc" id="Doc" disabled={true} value={Item.Documento ? Item.Documento : ''} onChange={() => ''} />
                                                        </div>
                                                    </div>
                                                    <div className='col-md-3'>
                                                        <div className='form-group'>
                                                            <label>Inciso</label>
                                                            <input type="text" className='form-control input-sm' name="Inc" id="Inc" disabled={true} value={Item.IncisoDoc ? Item.IncisoDoc : ''} onChange={() => ''} />
                                                        </div>
                                                    </div>
                                                </div>
                                                <div className='row'>
                                                    <div className='col-md-12'>
                                                        <div className='form-group'>
                                                            <label>Cliente</label>
                                                            <input type="text" className='form-control input-sm' name="clte" id="clte" disabled={true} value={ItemInfoRecibo.Cliente ? ItemInfoRecibo.Cliente : ''} onChange={() => ''} />
                                                        </div>
                                                    </div>
                                                </div>
                                                <div className='row'>
                                                    <div className='col-md-6'>
                                                        <div className='form-group'>
                                                            <label>Ejecutivo</label>
                                                            <input type="text" className='form-control input-sm' name="Ejc" id="Ejc" disabled={true} value={ItemInfoRecibo.Ejecutivo ? ItemInfoRecibo.Ejecutivo : ''} onChange={() => ''} />
                                                        </div>
                                                    </div>
                                                    <div className='col-md-6'>
                                                        <div className='form-group'>
                                                            <label>Vendedor</label>
                                                            <input type="text" className='form-control input-sm' name="Vend" id="Vend" disabled={true} value={ItemInfoRecibo.Vendedor ? ItemInfoRecibo.Vendedor : ''} onChange={() => ''} />
                                                        </div>
                                                    </div>
                                                </div>
                                                <div className='row'>
                                                    <div className='col-md-10'>
                                                        <div className='form-group'>
                                                            <label>Referencia de pago</label>
                                                            <input type="text" className='form-control input-sm' name="RefPago" id="RefPago" disabled={true} value={ItemInfoRecibo.ReferenciaPago ? ItemInfoRecibo.ReferenciaPago : ''} onChange={() => ''} />
                                                        </div>
                                                    </div>
                                                    <div className='col-md-2'>
                                                        <div className='form-group'>
                                                            <label>Int pago</label>
                                                            <input type="text" className='form-control input-sm' name="IntPago" id="IntPago" disabled={true} value={ItemInfoRecibo.IntPago ? ItemInfoRecibo.IntPago : ''} onChange={() => ''} />
                                                        </div>
                                                    </div>
                                                </div>
                                                <div className='row'>
                                                    <div className='col-md-6'>
                                                        <div className='form-group'>
                                                            <label>Ejecutivo de cobranza</label>
                                                            <input type="text" className='form-control input-sm' name="EjecC" id="EjecC" disabled={true} value={ItemInfoRecibo.EjecutivoCobranza ? ItemInfoRecibo.EjecutivoCobranza : ''} onChange={() => ''} />
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div className='col-md-6'>
                                                <div className='row'>
                                                    <div className='col-md-4'>
                                                        <div className='form-group'>
                                                            <label>Endoso</label>
                                                            <input type="text" className='form-control input-sm' name="End" id="End" disabled={true} value={Item.Endoso ? tem.Endoso : ''} onChange={() => ''} />
                                                        </div>
                                                    </div>
                                                    <div className='col-md-4'>
                                                        <div className='form-group'>
                                                            <label>Tipo Endoso</label>
                                                            <input type="text" className='form-control input-sm' name="TEnd" id="TEnd" disabled={true} value={ItemInfoRecibo.TipoEndoso ? ItemInfoRecibo.TipoEndoso : ''} onChange={() => ''} />
                                                        </div>
                                                    </div>
                                                    <div className='col-md-2'>
                                                        <div className='form-group'>
                                                            <label>Serie</label>
                                                            <input type="text" className='form-control input-sm' name="Serie" id="Serie" disabled={true} value={Item.Serie ? Item.Serie : ''} onChange={() => ''} />
                                                        </div>
                                                    </div>
                                                    <div className='col-md-2'>
                                                        <div className='form-group'>
                                                            <label>Periodo</label>
                                                            <input type="text" className='form-control input-sm' name="Periodo" id="Periodo" disabled={true} value={Item.Periodo ? Item.Periodo : ''} onChange={() => ''} />
                                                        </div>
                                                    </div>
                                                </div>
                                                <div className='row'>
                                                    <div className='col-md-12'>
                                                        <div className='form-group'>
                                                            <label>Ramo</label>
                                                            <input type="text" className='form-control input-sm' name="Ramo" id="Ramo" disabled={true} value={ItemInfoRecibo.Ramo ? ItemInfoRecibo.Ramo : ''} onChange={() => ''} />
                                                        </div>
                                                    </div>
                                                    <div className='col-md-12'>
                                                        <div className='form-group'>
                                                            <label>Compañia</label>
                                                            <input type="text" className='form-control input-sm' name="Comp" id="Comp" disabled={true} value={ItemInfoRecibo.Compania ? ItemInfoRecibo.Compania : ''} onChange={() => ''} />
                                                        </div>
                                                    </div>
                                                    <div className='col-md-12'>
                                                        <div className='form-group'>
                                                            <label>Agente</label>
                                                            <input type="text" className='form-control input-sm' name="Agente" id="Agente" disabled={true} value={ItemInfoRecibo.Agente ? ItemInfoRecibo.Agente : ''} onChange={() => ''} />
                                                        </div>
                                                    </div>
                                                </div>
                                                <div className='row'>
                                                    <div className='col-md-6'>
                                                        <div className='form-group'>
                                                            <label>Moneda</label>
                                                            <input type="text" className='form-control input-sm' name="Moneda" id="Moneda" disabled={true} value={ItemInfoRecibo.Moneda ? ItemInfoRecibo.Moneda : ''} onChange={() => ''} />
                                                        </div>
                                                    </div>
                                                    <div className='col-md-6'>
                                                        <div className='form-group'>
                                                            <label>Forma Pago</label>
                                                            <input type="text" className='form-control input-sm' name="Fpago" id="Fpago" disabled={true} value={ItemInfoRecibo.FormaPago ? ItemInfoRecibo.FormaPago : ''} onChange={() => ''} />
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div className="tab-pane fade" id="detalle-recibo" role="tabpanel" aria-labelledby="detalle-recibo-tab">
                                        <p>2</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div className='row'>
                            <br />
                            <div className='col-md-12 text-right'>
                                <AllowElement PermisoAccion="Editar">
                                    <a className="btn btn-primary btn-s" type="submit" data-toggle="tooltip" data-placement="bottom" title="Guardar"
                                        onClick={() => { ReloadRecibosSubsecuentes(IndexRecibo, Item) }}>
                                        <i className="fa fa-floppy-o" aria-hidden="true"></i>
                                    </a>
                                </AllowElement>
                            </div>
                            <br />
                            <div className='col-md-4'>
                                <div className='row'>
                                    <div className='col-md-12'>
                                        <h6>DETALLE DE PRIMAS</h6>
                                        <hr />
                                    </div>
                                    <div className='col-md-12'>
                                        <div className="form-group">
                                            <div className='col-sm-3' style={{ paddingRight: 'unset' }}>
                                                <label className='col-form-label titulo'>P Neta</label>
                                            </div>
                                            <div className="col-sm-8" style={{ paddingRight: 'unset' }}>
                                                {/* <input type="text" className="form-control input-sm numeric" name="PrimaNeta" id="PrimaNeta" onFocus={e => e.target.select()} onChange={handleChange} value={values.PrimaNeta ? values.PrimaNeta : '0'} /> */}
                                                <CurrencyInputField
                                                    className='form-control input-sm numeric'
                                                    //onBlur={() => { handleBlur, ReloadAll(IndexRecibo, null) }}
                                                    min={0}
                                                    maxLength={10}
                                                    //prefix='$'3
                                                    decimalSeparator='.'
                                                    groupSeparator=','
                                                    decimalsLimit={4}
                                                    decimalScale={4}
                                                    onFocus={FocusInput}
                                                    allowNegativeValue={false}
                                                    value={Item.PrimaNeta || 0}
                                                    //onValueChange={(value, name) => { ChangeValueRecibo(IndexRecibo, 'PrimaNeta', value, null) }}
                                                    onValueChange={(value, name) => NewChangeValueRecibo(IndexRecibo, name, value)}
                                                    id='PrimaNeta'
                                                    name='PrimaNeta'
                                                    autoComplete='off'
                                                />
                                            </div>
                                        </div>
                                    </div>
                                    <div className='col-md-12'>
                                        <div className="form-groug">
                                            <div className='col-sm-3' style={{ paddingRight: 'unset' }}>
                                                <label className='col-form-label titulo'>Descuento</label>
                                            </div>
                                            <div className="col-sm-4" style={{ paddingRight: 'unset' }}>
                                                <CurrencyInputField
                                                    className='form-control input-sm numeric'
                                                    //onBlur={() => { handleBlur, ReloadAll(IndexRecibo, '') }}
                                                    min={0}
                                                    maxLength={10}
                                                    //prefix='$'
                                                    decimalSeparator='.'
                                                    groupSeparator=','
                                                    decimalsLimit={4}
                                                    decimalScale={4}
                                                    onFocus={FocusInput}
                                                    allowNegativeValue={false}
                                                    value={Item.Descuento ? Item.Descuento : '0'}
                                                    //onValueChange={(value, name) => { ChangeValueRecibo(IndexRecibo, 'Descuento', value, '') }}
                                                    onValueChange={(value, name) => NewChangeValueRecibo(IndexRecibo, name, value)}
                                                    id='Descuento'
                                                    name='Descuento'
                                                    autoComplete='off'
                                                />
                                            </div>
                                            <div className="col-sm-4 unsetPadding" style={{ paddingRight: 'unset' }}>
                                                <CurrencyInputField
                                                    className='form-control input-sm numeric'
                                                    //onBlur={() => { handleBlur, ReloadAll(IndexRecibo, null) }}
                                                    min={0}
                                                    maxLength={10}
                                                    prefix=''
                                                    decimalSeparator='.'
                                                    groupSeparator=','
                                                    decimalsLimit={4}
                                                    decimalScale={4}
                                                    onFocus={FocusInput}
                                                    allowNegativeValue={false}
                                                    value={Item.PDescuento ? Item.PDescuento : '0'}
                                                    //onValueChange={(value, name) => { ChangeValueRecibo(IndexRecibo, 'PDescuento', value, null) }}
                                                    onValueChange={(value, name) => NewChangeValueRecibo(IndexRecibo, name, value)}
                                                    id='PDescuento'
                                                    name='PDescuento'
                                                    autoComplete='off'
                                                />
                                            </div>
                                        </div>
                                    </div>
                                    {Tipo == "P" && (
                                        <div className='col-md-12'>
                                            <div className="form-groug">
                                                <div className='col-sm-3' style={{ paddingRight: 'unset' }}>
                                                    <label className='col-form-label titulo'>Recargos</label>
                                                </div>
                                                <div className="col-sm-4" style={{ paddingRight: 'unset' }}>
                                                    <CurrencyInputField
                                                        className='form-control input-sm numeric'
                                                        //onBlur={() => { handleBlur, ReloadAll(IndexRecibo, '') }}
                                                        min={0}
                                                        maxLength={10}
                                                        //prefix='$'
                                                        decimalSeparator='.'
                                                        groupSeparator=','
                                                        decimalsLimit={4}
                                                        decimalScale={4}
                                                        onFocus={FocusInput}
                                                        allowNegativeValue={false}
                                                        value={Item.Recargos ? Item.Recargos : '0'}
                                                        //onValueChange={(value, name) => { ChangeValueRecibo(IndexRecibo, 'Recargos', value, '') }}
                                                        onValueChange={(value, name) => NewChangeValueRecibo(IndexRecibo, name, value)}
                                                        id='Recargos'
                                                        name='Recargos'
                                                        autoComplete='off'
                                                    />
                                                </div>
                                                <div className="col-sm-4 unsetPadding" style={{ paddingRight: 'unset' }}>
                                                    <CurrencyInputField
                                                        className='form-control input-sm numeric'
                                                        //onBlur={() => { handleBlur, ReloadAll(IndexRecibo, null) }}
                                                        min={0}
                                                        maxLength={10}
                                                        prefix=''
                                                        decimalSeparator='.'
                                                        groupSeparator=','
                                                        decimalsLimit={4}
                                                        decimalScale={4}
                                                        onFocus={FocusInput}
                                                        allowNegativeValue={false}
                                                        value={Item.PorRecargos ? Item.PorRecargos : '0'}
                                                        //onValueChange={(value, name) => { ChangeValueRecibo(IndexRecibo, 'PorRecargos', value, null) }}
                                                        onValueChange={(value, name) => NewChangeValueRecibo(IndexRecibo, name, value)}
                                                        id='PorRecargos'
                                                        name='PorRecargos'
                                                        autoComplete='off'
                                                    />
                                                </div>
                                            </div>
                                        </div>
                                    )}
                                    {Tipo == "F" && (
                                        <>
                                            <div className='col-md-12'>
                                                <div className="form-groug">
                                                    <div className='col-sm-3' style={{ paddingRight: 'unset' }}>
                                                        <label className='col-form-label titulo'>Gstos Maq</label>
                                                    </div>
                                                    <div className="col-sm-8" style={{ paddingRight: 'unset' }}>
                                                        <CurrencyInputField
                                                            className='form-control input-sm numeric'
                                                            //onBlur={() => { handleBlur, ReloadAll(IndexRecibo, null) }}
                                                            min={0}
                                                            maxLength={10}
                                                            //prefix='$'
                                                            decimalSeparator='.'
                                                            groupSeparator=','
                                                            decimalsLimit={4}
                                                            decimalScale={4}
                                                            onFocus={FocusInput}
                                                            allowNegativeValue={false}
                                                            value={Item.GastosMaq ? Item.GastosMaq : '0'}
                                                            //onValueChange={(value, name) => { ChangeValueRecibo(IndexRecibo, 'GastosMaq', value, null) }}
                                                            onValueChange={(value, name) => NewChangeValueRecibo(IndexRecibo, 'GastosMaq', value)}
                                                            id='GastosMaq'
                                                            name='GastosMaq'
                                                            autoComplete='off'
                                                        />
                                                    </div>
                                                </div>
                                            </div>
                                            <div className='col-md-12'>
                                                <div className="form-groug">
                                                    <div className='col-sm-3' style={{ paddingRight: 'unset' }}>
                                                        <label className='col-form-label titulo'>Gstos Adm</label>
                                                    </div>
                                                    <div className="col-sm-8" style={{ paddingRight: 'unset' }}>
                                                        <CurrencyInputField
                                                            className='form-control input-sm numeric'
                                                            //onBlur={() => { handleBlur, ReloadAll(IndexRecibo, null) }}
                                                            min={0}
                                                            maxLength={10}
                                                            //prefix='$'
                                                            decimalSeparator='.'
                                                            groupSeparator=','
                                                            decimalsLimit={4}
                                                            decimalScale={4}
                                                            onFocus={FocusInput}
                                                            allowNegativeValue={false}
                                                            value={Item.GastosAdm ? Item.GastosAdm : '0'}
                                                            //onValueChange={(value, name) => { ChangeValueRecibo(IndexRecibo, 'GastosAdm', value, null) }}
                                                            onValueChange={(value, name) => NewChangeValueRecibo(IndexRecibo, 'GastosAdm', value)}
                                                            id='GastosAdm'
                                                            name='GastosAdm'
                                                            autoComplete='off'
                                                        />
                                                    </div>
                                                </div>
                                            </div>
                                        </>
                                    )}
                                    <div className='col-md-12'>
                                        <div className="form-group">
                                            <div className='col-sm-3' style={{ paddingRight: 'unset' }}>
                                                <label className='col-form-label titulo'>Derechos</label>
                                            </div>
                                            <div className="col-sm-8" style={{ paddingRight: 'unset' }}>
                                                {/* <input type="text" className="form-control input-sm numeric" name="PrimaNeta" id="PrimaNeta" onFocus={e => e.target.select()} onChange={handleChange} value={values.PrimaNeta ? values.PrimaNeta : '0'} /> */}
                                                <CurrencyInputField
                                                    className='form-control input-sm numeric'
                                                    //onBlur={() => { handleBlur, ReloadAll(IndexRecibo, null) }}
                                                    min={0}
                                                    maxLength={10}
                                                    //prefix='$'
                                                    decimalSeparator='.'
                                                    groupSeparator=','
                                                    decimalsLimit={4}
                                                    decimalScale={4}
                                                    onFocus={FocusInput}
                                                    allowNegativeValue={false}
                                                    value={Item.Derechos ? Item.Derechos : '0'}
                                                    //onValueChange={(value, name) => { ChangeValueRecibo(IndexRecibo, 'Derechos', value, null) }}
                                                    onValueChange={(value, name) => NewChangeValueRecibo(IndexRecibo, name, value)}
                                                    id='Derechos'
                                                    name='Derechos'
                                                    autoComplete='off'
                                                />
                                            </div>
                                        </div>
                                    </div>
                                    <div className='col-md-12'>
                                        <div className="form-group">
                                            <div className='col-sm-3' style={{ paddingRight: 'unset' }}>
                                                <label className='col-form-label titulo'>Subtotal</label>
                                            </div>
                                            <div className="col-sm-8" style={{ paddingRight: 'unset' }}>
                                                {/* <input type="text" className="form-control input-sm numeric" name="PrimaNeta" id="PrimaNeta" onFocus={e => e.target.select()} onChange={handleChange} value={values.PrimaNeta ? values.PrimaNeta : '0'} /> */}
                                                <CurrencyInputField
                                                    disabled={true}
                                                    className='form-control input-sm numeric'
                                                    //onBlur={() => { 'ReloadPrices(values)' }}
                                                    min={0}
                                                    maxLength={10}
                                                    //prefix='$'
                                                    decimalSeparator='.'
                                                    groupSeparator=','
                                                    decimalsLimit={4}
                                                    decimalScale={4}
                                                    onFocus={FocusInput}
                                                    allowNegativeValue={false}
                                                    value={Item.SubTotal || 0}
                                                    //onValueChange={(value, name) => { ChangeValueRecibo(IndexRecibo, 'SubTotal', value, null) }}
                                                    //onValueChange={(value, name) => NewChangeValueRecibo(IndexRecibo, 'SubTotal', value)}
                                                    id='SubTotal'
                                                    name='SubTotal'
                                                    autoComplete='off'
                                                />
                                            </div>
                                        </div>
                                    </div>
                                    <div className='col-md-12'>
                                        <div className="form-groug">
                                            <div className='col-sm-3' style={{ paddingRight: 'unset' }}>
                                                <label className='col-form-label titulo'>IVA</label>
                                            </div>
                                            <div className="col-sm-4" style={{ paddingRight: 'unset' }}>
                                                <CurrencyInputField
                                                    className='form-control input-sm numeric'
                                                    //onBlur={() => { handleBlur, ReloadAll(IndexRecibo, 'IVA') }}
                                                    min={0}
                                                    maxLength={10}
                                                    //prefix='$'
                                                    decimalSeparator='.'
                                                    groupSeparator=','
                                                    decimalsLimit={4}
                                                    decimalScale={4}
                                                    onFocus={FocusInput}
                                                    allowNegativeValue={false}
                                                    value={Item.IVA || 0}
                                                    //onValueChange={(value, name) => { ChangeValueRecibo(IndexRecibo, 'IVA', value, '') }}
                                                    onValueChange={(value, name) => NewChangeValueRecibo(IndexRecibo, name, value)}
                                                    id='IVA'
                                                    name='IVA'
                                                    autoComplete='off'
                                                />
                                            </div>
                                            <div className="col-sm-4 unsetPadding" style={{ paddingRight: 'unset' }}>
                                                <CurrencyInputField
                                                    className='form-control input-sm numeric'
                                                    //onBlur={() => { handleBlur, ReloadAll(IndexRecibo, null) }}
                                                    min={0}
                                                    maxLength={10}
                                                    prefix=''
                                                    decimalSeparator='.'
                                                    groupSeparator=','
                                                    decimalsLimit={4}
                                                    decimalScale={4}
                                                    onFocus={FocusInput}
                                                    allowNegativeValue={false}
                                                    value={Item.PorIVA ? Item.PorIVA : '0'}
                                                    //onValueChange={(value, name) => { ChangeValueRecibo(IndexRecibo, 'PorIVA', value, null) }}
                                                    onValueChange={(value, name) => NewChangeValueRecibo(IndexRecibo, name, value)}
                                                    id='PorIVA'
                                                    name='PorIVA'
                                                    autoComplete='off'
                                                />
                                            </div>
                                        </div>
                                    </div>
                                    {Tipo == "P" && (
                                        <div className='col-md-12'>
                                            <div className="form-group">
                                                <div className='col-sm-3' style={{ paddingRight: 'unset' }}>
                                                    <label className='col-form-label titulo'>Ajuste</label>
                                                </div>
                                                <div className="col-sm-8" style={{ paddingRight: 'unset' }}>
                                                    {/* <input type="text" className="form-control input-sm numeric" name="PrimaNeta" id="PrimaNeta" onFocus={e => e.target.select()} onChange={handleChange} value={values.PrimaNeta ? values.PrimaNeta : '0'} /> */}
                                                    <CurrencyInputField
                                                        className='form-control input-sm numeric'
                                                        //onBlur={() => { 'ReloadPrices(values)' }}
                                                        min={0}
                                                        maxLength={10}
                                                        //prefix='$'
                                                        decimalSeparator='.'
                                                        groupSeparator=','
                                                        decimalsLimit={4}
                                                        decimalScale={4}
                                                        onFocus={FocusInput}
                                                        allowNegativeValue={false}
                                                        value={Item.Ajuste ? Item.Ajuste : '0'}
                                                        //onValueChange={(value, name) => { ChangeValueRecibo(IndexRecibo, 'Ajuste', value, null) }}
                                                        onValueChange={(value, name) => NewChangeValueRecibo(IndexRecibo, name, value)}
                                                        id='Ajuste'
                                                        name='Ajuste'
                                                        autoComplete='off'
                                                    />
                                                </div>
                                            </div>
                                        </div>
                                    )}
                                    <div className='col-md-12'>
                                        <div className="form-group">
                                            <div className='col-sm-3' style={{ paddingRight: 'unset' }}>
                                                <label className='col-form-label titulo'>Prima Total</label>
                                            </div>
                                            <div className="col-sm-8" style={{ paddingRight: 'unset' }}>
                                                {/* <input type="text" className="form-control input-sm numeric" name="PrimaNeta" id="PrimaNeta" onFocus={e => e.target.select()} onChange={handleChange} value={values.PrimaNeta ? values.PrimaNeta : '0'} /> */}
                                                <CurrencyInputField
                                                    className='form-control input-sm numeric'
                                                    //onBlur={() => { 'ReloadPrices(values)' }}
                                                    min={0}
                                                    maxLength={10}
                                                    //prefix='$'
                                                    decimalSeparator='.'
                                                    groupSeparator=','
                                                    decimalsLimit={4}
                                                    decimalScale={4}
                                                    onFocus={FocusInput}
                                                    allowNegativeValue={false}
                                                    value={Item.PrimaTotal || 0}
                                                    //onValueChange={(value, name) => { ChangeValueRecibo(IndexRecibo, 'PrimaTotal', value, null) }}
                                                    onValueChange={(value, name) => NewChangeValueRecibo(IndexRecibo, name, value)}
                                                    id='PrimaTotal'
                                                    name='PrimaTotal'
                                                    autoComplete='off'
                                                />
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div className='col-md-8'>
                                <div className='row'>
                                    <div className='col-md-6'>
                                        <div className='col-md-12'>
                                            <h6>DETALLE DE COMISIONES</h6>
                                            <hr />
                                        </div>
                                        <div className='row'>
                                            <div className='col-md-12'>
                                                <div className="form-groug">
                                                    <div className='col-sm-3' style={{ paddingRight: 'unset' }}>
                                                        <label className='col-form-label titulo'>Neta</label>
                                                    </div>
                                                    <div className="col-sm-4" style={{ paddingRight: 'unset' }}>
                                                        <CurrencyInputField
                                                            className='form-control input-sm numeric'
                                                            //onBlur={() => { handleBlur, ReloadAll(IndexRecibo, '') }}
                                                            min={0}
                                                            maxLength={10}
                                                            //prefix='$'
                                                            decimalSeparator='.'
                                                            groupSeparator=','
                                                            decimalsLimit={4}
                                                            decimalScale={4}
                                                            onFocus={FocusInput}
                                                            allowNegativeValue={false}
                                                            value={Item.ComN ? Item.ComN : '0'}
                                                            //onValueChange={(value, name) => { ChangeValueRecibo(IndexRecibo, 'ComN', value, '') }}
                                                            onValueChange={(value, name) => NewChangeValueRecibo(IndexRecibo, name, value)}
                                                            id='ComN'
                                                            name='ComN'
                                                            autoComplete='off'
                                                        />
                                                    </div>
                                                    <div className="col-sm-4 unsetPadding" style={{ paddingRight: 'unset' }}>
                                                        <CurrencyInputField
                                                            className='form-control input-sm numeric'
                                                            //onBlur={() => { handleBlur, ReloadAll(IndexRecibo, null) }}
                                                            min={0}
                                                            maxLength={10}
                                                            prefix=''
                                                            decimalSeparator='.'
                                                            groupSeparator=','
                                                            decimalsLimit={4}
                                                            decimalScale={4}
                                                            onFocus={FocusInput}
                                                            allowNegativeValue={false}
                                                            value={Item.PComN ? Item.PComN : '0'}
                                                            //onValueChange={(value, name) => { ChangeValueRecibo(IndexRecibo, 'PComN', value, null) }}
                                                            onValueChange={(value, name) => NewChangeValueRecibo(IndexRecibo, name, value)}
                                                            id='PComN'
                                                            name='PComN'
                                                            autoComplete='off'
                                                        />
                                                    </div>
                                                </div>
                                            </div>
                                            {Tipo == 'P' && (
                                                <div className='col-md-12'>
                                                    <div className="form-groug">
                                                        <div className='col-sm-3' style={{ paddingRight: 'unset' }}>
                                                            <label className='col-form-label titulo'>Recargos</label>
                                                        </div>
                                                        <div className="col-sm-4" style={{ paddingRight: 'unset' }}>
                                                            <CurrencyInputField
                                                                className='form-control input-sm numeric'
                                                                //onBlur={() => { handleBlur, ReloadAll(IndexRecibo, '') }}
                                                                min={0}
                                                                maxLength={10}
                                                                //prefix='$'
                                                                decimalSeparator='.'
                                                                groupSeparator=','
                                                                decimalsLimit={4}
                                                                decimalScale={4}
                                                                onFocus={FocusInput}
                                                                allowNegativeValue={false}
                                                                value={Item.ComR ? Item.ComR : '0'}
                                                                //onValueChange={(value, name) => { ChangeValueRecibo(IndexRecibo, 'ComR', value, '') }}
                                                                onValueChange={(value, name) => NewChangeValueRecibo(IndexRecibo, name, value)}
                                                                id='ComR'
                                                                name='ComR'
                                                                autoComplete='off'
                                                            />
                                                        </div>
                                                        <div className="col-sm-4 unsetPadding" style={{ paddingRight: 'unset' }}>
                                                            <CurrencyInputField
                                                                className='form-control input-sm numeric'
                                                                //onBlur={() => { handleBlur, ReloadAll(IndexRecibo, null) }}
                                                                min={0}
                                                                maxLength={10}
                                                                prefix=''
                                                                decimalSeparator='.'
                                                                groupSeparator=','
                                                                decimalsLimit={4}
                                                                decimalScale={4}
                                                                onFocus={FocusInput}
                                                                allowNegativeValue={false}
                                                                value={Item.PComR ? Item.PComR : '0'}
                                                                //onValueChange={(value, name) => { ChangeValueRecibo(IndexRecibo, 'PComR', value, null) }}
                                                                onValueChange={(value, name) => NewChangeValueRecibo(IndexRecibo, name, value)}
                                                                id='PComR'
                                                                name='PComR'
                                                                autoComplete='off'
                                                            />
                                                        </div>
                                                    </div>
                                                </div>
                                            )}
                                            {Tipo == "F" && (
                                                <>
                                                    <div className='col-md-12'>
                                                        <div className="form-groug">
                                                            <div className='col-sm-3' style={{ paddingRight: 'unset' }}>
                                                                <label className='col-form-label titulo'>Gstos Maq</label>
                                                            </div>
                                                            <div className="col-sm-4" style={{ paddingRight: 'unset' }}>
                                                                <CurrencyInputField
                                                                    className='form-control input-sm numeric'
                                                                    //onBlur={() => { handleBlur, ReloadAll(IndexRecibo, '') }}
                                                                    min={0}
                                                                    maxLength={10}
                                                                    //prefix='$'
                                                                    decimalSeparator='.'
                                                                    groupSeparator=','
                                                                    decimalsLimit={4}
                                                                    decimalScale={4}
                                                                    onFocus={FocusInput}
                                                                    allowNegativeValue={false}
                                                                    value={Item.CGastosMaq ? Item.CGastosMaq : '0'}
                                                                    //onValueChange={(value, name) => { ChangeValueRecibo(IndexRecibo, 'CGastosMaq', value, '') }}
                                                                    onValueChange={(value, name) => NewChangeValueRecibo(IndexRecibo, name, value)}
                                                                    id='CGastosMaq'
                                                                    name='CGastosMaq'
                                                                    autoComplete='off'
                                                                />
                                                            </div>
                                                            <div className="col-sm-4 unsetPadding" style={{ paddingRight: 'unset' }}>
                                                                <CurrencyInputField
                                                                    className='form-control input-sm numeric'
                                                                    //onBlur={() => { handleBlur, ReloadAll(IndexRecibo, null) }}
                                                                    min={0}
                                                                    maxLength={10}
                                                                    prefix=''
                                                                    decimalSeparator='.'
                                                                    groupSeparator=','
                                                                    decimalsLimit={4}
                                                                    decimalScale={4}
                                                                    onFocus={FocusInput}
                                                                    allowNegativeValue={false}
                                                                    value={Item.PCGastosMaq ? Item.PCGastosMaq : '0'}
                                                                    //onValueChange={(value, name) => { ChangeValueRecibo(IndexRecibo, 'PCGastosMaq', value, null) }}
                                                                    onValueChange={(value, name) => NewChangeValueRecibo(IndexRecibo, name, value)}
                                                                    id='PCGastosMaq'
                                                                    name='PCGastosMaq'
                                                                    autoComplete='off'
                                                                />
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div className='col-md-12'>
                                                        <div className="form-groug">
                                                            <div className='col-sm-3' style={{ paddingRight: 'unset' }}>
                                                                <label className='col-form-label titulo'>Gstos Adm</label>
                                                            </div>
                                                            <div className="col-sm-4" style={{ paddingRight: 'unset' }}>
                                                                <CurrencyInputField
                                                                    className='form-control input-sm numeric'
                                                                    //onBlur={() => { handleBlur, ReloadAll(IndexRecibo, '') }}
                                                                    min={0}
                                                                    maxLength={10}
                                                                    //prefix='$'
                                                                    decimalSeparator='.'
                                                                    groupSeparator=','
                                                                    decimalsLimit={4}
                                                                    decimalScale={4}
                                                                    onFocus={FocusInput}
                                                                    allowNegativeValue={false}
                                                                    value={Item.CGastosAdm ? Item.CGastosAdm : '0'}
                                                                    //onValueChange={(value, name) => { ChangeValueRecibo(IndexRecibo, 'CGastosAdm', value, '') }}
                                                                    onValueChange={(value, name) => NewChangeValueRecibo(IndexRecibo, name, value)}
                                                                    id='CGastosAdm'
                                                                    name='CGastosAdm'
                                                                    autoComplete='off'
                                                                />
                                                            </div>
                                                            <div className="col-sm-4 unsetPadding" style={{ paddingRight: 'unset' }}>
                                                                <CurrencyInputField
                                                                    className='form-control input-sm numeric'
                                                                    //onBlur={() => { handleBlur, ReloadAll(IndexRecibo, null) }}
                                                                    min={0}
                                                                    maxLength={10}
                                                                    prefix=''
                                                                    decimalSeparator='.'
                                                                    groupSeparator=','
                                                                    decimalsLimit={4}
                                                                    decimalScale={4}
                                                                    onFocus={FocusInput}
                                                                    allowNegativeValue={false}
                                                                    value={Item.PCGastosAdm ? Item.PCGastosAdm : '0'}
                                                                    //onValueChange={(value, name) => { ChangeValueRecibo(IndexRecibo, 'PCGastosAdm', value, null) }}
                                                                    onValueChange={(value, name) => NewChangeValueRecibo(IndexRecibo, name, value)}
                                                                    id='PCGastosAdm'
                                                                    name='PCGastosAdm'
                                                                    autoComplete='off'
                                                                />
                                                            </div>
                                                        </div>
                                                    </div>
                                                </>
                                            )}
                                            <div className='col-md-12'>
                                                <div className="form-groug">
                                                    <div className='col-sm-3' style={{ paddingRight: 'unset' }}>
                                                        <label className='col-form-label titulo'>Derechos</label>
                                                    </div>
                                                    <div className="col-sm-4" style={{ paddingRight: 'unset' }}>
                                                        <CurrencyInputField
                                                            className='form-control input-sm numeric'
                                                            //onBlur={() => { handleBlur, ReloadAll(IndexRecibo, '') }}
                                                            min={0}
                                                            maxLength={10}
                                                            //prefix='$'
                                                            decimalSeparator='.'
                                                            groupSeparator=','
                                                            decimalsLimit={4}
                                                            decimalScale={4}
                                                            onFocus={FocusInput}
                                                            allowNegativeValue={false}
                                                            value={Item.ComD ? Item.ComD : '0'}
                                                            //onValueChange={(value, name) => { ChangeValueRecibo(IndexRecibo, 'ComD', value, '') }}
                                                            onValueChange={(value, name) => NewChangeValueRecibo(IndexRecibo, name, value)}
                                                            id='ComD'
                                                            name='ComD'
                                                            autoComplete='off'
                                                        />
                                                    </div>
                                                    <div className="col-sm-4 unsetPadding" style={{ paddingRight: 'unset' }}>
                                                        <CurrencyInputField
                                                            className='form-control input-sm numeric'
                                                            //onBlur={() => { handleBlur, ReloadAll(IndexRecibo, null) }}
                                                            min={0}
                                                            maxLength={10}
                                                            prefix=''
                                                            decimalSeparator='.'
                                                            groupSeparator=','
                                                            decimalsLimit={4}
                                                            decimalScale={4}
                                                            onFocus={FocusInput}
                                                            allowNegativeValue={false}
                                                            value={Item.PComD ? Item.PComD : '0'}
                                                            //onValueChange={(value, name) => { ChangeValueRecibo(IndexRecibo, 'PComD', value, null) }}
                                                            onValueChange={(value, name) => NewChangeValueRecibo(IndexRecibo, name, value)}
                                                            id='PComD'
                                                            name='PComD'
                                                            autoComplete='off'
                                                        />
                                                    </div>
                                                </div>
                                            </div>
                                            <div className='col-md-12' style={{ display: 'none' }}>
                                                <div className="form-groug">
                                                    <div className='col-sm-3' style={{ paddingRight: 'unset' }}>
                                                        <label className='col-form-label titulo'>Promotor</label>
                                                    </div>
                                                    <div className="col-sm-4" style={{ paddingRight: 'unset' }}>
                                                        <CurrencyInputField
                                                            className='form-control input-sm numeric'
                                                            //onBlur={() => { /* handleBlur, */ ReloadPrices(values) }}
                                                            min={0}
                                                            maxLength={10}
                                                            //prefix='$'
                                                            decimalSeparator='.'
                                                            groupSeparator=','
                                                            decimalsLimit={4}
                                                            decimalScale={4}
                                                            onFocus={FocusInput}
                                                            allowNegativeValue={false}
                                                            value={Item.ComDer ? Item.ComDer : '0'}
                                                            onValueChange={(value, name) => { ChangeValueRecibo(IndexRecibo, 'ComDer', value, '') }}
                                                            id='ComDer'
                                                            name='ComDer'
                                                            autoComplete='off'
                                                        />
                                                    </div>
                                                    <div className="col-sm-4 unsetPadding" style={{ paddingRight: 'unset' }}>
                                                        <CurrencyInputField
                                                            className='form-control input-sm numeric'
                                                            //onBlur={() => { /* handleBlur, */ ReloadPrices(values) }}
                                                            min={0}
                                                            maxLength={10}
                                                            prefix=''
                                                            decimalSeparator='.'
                                                            groupSeparator=','
                                                            decimalsLimit={4}
                                                            decimalScale={4}
                                                            onFocus={FocusInput}
                                                            allowNegativeValue={false}
                                                            //value={values.PComDer ? values.PComDer : '0'}
                                                            onValueChange={(value, name) => { ChangeValueRecibo(IndexRecibo, 'PComDer', value, null) }}
                                                            id='PComDer'
                                                            name='PComDer'
                                                            autoComplete='off'
                                                        />
                                                    </div>
                                                </div>
                                            </div>

                                            <div className='col-md-12'>
                                                <div className="form-groug">
                                                    <div className='col-sm-3' style={{ paddingRight: 'unset' }}>
                                                        <label className='col-form-label titulo'>Especial</label>
                                                    </div>
                                                    <div className="col-sm-4" style={{ paddingRight: 'unset' }}>
                                                        <CurrencyInputField
                                                            className='form-control input-sm numeric'
                                                            //onBlur={() => { /* handleBlur, */ ReloadPrices(values) }}
                                                            min={0}
                                                            maxLength={10}
                                                            //prefix='$'
                                                            decimalSeparator='.'
                                                            groupSeparator=','
                                                            decimalsLimit={4}
                                                            decimalScale={4}
                                                            onFocus={FocusInput}
                                                            allowNegativeValue={false}
                                                            value={Item.Especial ? Item.Especial : '0'}
                                                            //onValueChange={(value, name) => { ChangeValueRecibo(IndexRecibo, 'Especial', value, '') }}
                                                            onValueChange={(value, name) => NewChangeValueRecibo(IndexRecibo, name, value)}
                                                            id='Especial'
                                                            name='Especial'
                                                            autoComplete='off'
                                                        />
                                                    </div>
                                                    <div className="col-sm-4 unsetPadding" style={{ paddingRight: 'unset' }}>
                                                        <CurrencyInputField
                                                            className='form-control input-sm numeric'
                                                            //onBlur={() => { /* handleBlur, */ ReloadPrices(values) }}
                                                            min={0}
                                                            maxLength={10}
                                                            prefix=''
                                                            decimalSeparator='.'
                                                            groupSeparator=','
                                                            decimalsLimit={4}
                                                            decimalScale={4}
                                                            onFocus={FocusInput}
                                                            allowNegativeValue={false}
                                                            value={Item.PEspecial ? Item.PEspecial : '0'}
                                                            //onValueChange={(value, name) => { ChangeValueRecibo(IndexRecibo, 'PEspecial', value, null) }}
                                                            onValueChange={(value, name) => NewChangeValueRecibo(IndexRecibo, name, value)}
                                                            id='PEspecial'
                                                            name='PEspecial'
                                                            autoComplete='off'
                                                        />
                                                    </div>
                                                </div>
                                            </div>
                                            <br />
                                            <br />
                                            <div className='col-md-12'>
                                                <div className="form-groug">
                                                    <div className='col-sm-3' style={{ paddingRight: 'unset' }}>
                                                        <label className='col-form-label titulo'>Total</label>
                                                    </div>
                                                    <div className="col-sm-4" style={{ paddingRight: 'unset' }}>
                                                        <CurrencyInputField
                                                            className='form-control input-sm numeric'
                                                            min={0}
                                                            maxLength={10}
                                                            //prefix='$'
                                                            decimalSeparator='.'
                                                            groupSeparator=','
                                                            decimalsLimit={4}
                                                            decimalScale={4}
                                                            onFocus={FocusInput}
                                                            disabled={true}
                                                            allowNegativeValue={false}
                                                            value={sumaMontos()}
                                                            id='MontoTotal'
                                                            name='MontoTotal'
                                                            autoComplete='off'
                                                        />
                                                    </div>
                                                    <div className="col-sm-4 unsetPadding" style={{ paddingRight: 'unset' }}>
                                                        <CurrencyInputField
                                                            className='form-control input-sm numeric'
                                                            min={0}
                                                            maxLength={10}
                                                            prefix=''
                                                            decimalSeparator='.'
                                                            groupSeparator=','
                                                            decimalsLimit={4}
                                                            decimalScale={4}
                                                            onFocus={FocusInput}
                                                            disabled={true}
                                                            allowNegativeValue={false}
                                                            value={sumaPorcentaje()}
                                                            id='PorcentajeTotal'
                                                            name='PorcentajeTotal'
                                                            autoComplete='off'
                                                        />
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div className='col-md-6'>
                                        <div className='row'>
                                            <div className='col-md-12'>
                                                <div className='form-group'>
                                                    <label>Estatus</label>
                                                    <input type="text"
                                                        className='form-control input-sm'
                                                        value={Item.Status_TXT ? Item.Status_TXT : ''}
                                                        name="Status_TXT" id="Status_TXT" disabled={true} />
                                                </div>
                                            </div>
                                        </div>
                                        <div className='row'>
                                            <div className='col-md-6'>
                                                <div className='form-group'>
                                                    <label>Desde</label>
                                                    <input type="date"
                                                        className='form-control input-sm'
                                                        name="FDesde"
                                                        id="FDesde"
                                                        value={Item.FDesde ? moment(Item.FDesde).format("YYYY-MM-DD") : ''}
                                                        //onChange={(e) => ChangeValueRecibo(IndexRecibo, 'Desde', e.target.value)} />
                                                        onChange={(e) => NewChangeValueRecibo(IndexRecibo, 'FDesde', e.target.value)} />
                                                </div>
                                            </div>
                                            <div className='col-md-6'>
                                                <div className='form-group'>
                                                    <label>Hasta</label>
                                                    <input type="date"
                                                        className='form-control input-sm'
                                                        name="FHasta"
                                                        id="FHasta"
                                                        value={Item.FHasta ? moment(Item.FHasta).format("YYYY-MM-DD") : ''}
                                                        //onChange={(e) => ChangeValueRecibo(IndexRecibo, 'FHasta', e.target.value)} />
                                                        onChange={(e) => NewChangeValueRecibo(IndexRecibo, 'FHasta', e.target.value)} />
                                                </div>
                                            </div>
                                            <div className='col-md-6'>
                                                <div className='form-group'>
                                                    <label>Generación</label>
                                                    <input type="date"
                                                        className='form-control input-sm'
                                                        name="FGeneracion"
                                                        id="FGeneracion"
                                                        value={Item.FGeneracion ? moment(Item.FGeneracion).format("YYYY-MM-DD") : ''}
                                                        //onChange={(e) => ChangeValueRecibo(IndexRecibo, 'FGeneracion', e.target.value)} />
                                                        onChange={(e) => NewChangeValueRecibo(IndexRecibo, 'FGeneracion', e.target.value)} />
                                                </div>
                                            </div>
                                            <div className='col-md-6'>
                                                <div className='form-group'>
                                                    <label>Limite Pago</label>
                                                    <input type="date"
                                                        className='form-control input-sm'
                                                        name="FLimPago"
                                                        id="FLimPago"
                                                        value={Item.FLimPago ? moment(Item.FLimPago).format("YYYY-MM-DD") : ''}
                                                        //onChange={(e) => ChangeValueRecibo(IndexRecibo, 'FLimPago', e.target.value)} />
                                                        onChange={(e) => NewChangeValueRecibo(IndexRecibo, 'FLimPago', e.target.value)} />
                                                </div>
                                            </div>
                                        </div>

                                    </div>
                                </div>
                                {/* <div className='row'>
                                    <div className='col-md-12'>
                                        <div className='col-md-12'>
                                            <h6>DETALLE DE PAGO COMISIONES</h6>
                                            <hr />
                                        </div>
                                        <div className='row'>
                                            <table style={{ width: '95% !important' }} className="table table-condensed" id="TCRecibos">
                                                <thead>
                                                    <tr>
                                                        <th scope="col" style={{ width: '100px' }}>Fecha Aplicación</th>
                                                        <th scope="col" style={{ width: '100px' }}>Documento Cobro</th>
                                                        <th scope="col" style={{ width: '100px' }}>Folio Liquidación</th>
                                                        <th scope="col" style={{ width: '100px' }}>Moneda Docto</th>

                                                    </tr>
                                                </thead>
                                                <tbody style={{ maxHeight: '400px', overflow: 'auto' }}>
                                                    {registros.length == 0 && (
                                                        <tr className='text-center'><td colSpan={11}>No hay registros de captura.</td></tr>
                                                    )}
                                                    {registros && registros.map((item, key) => (
                                                        <tr key={key}>
                                                            <td>{item.FechaAplica ? moment(item.FechaAplica).format("DD/MM/YYYY") : 'N/A'}</td>
                                                            <td>{item.DTipoDocumento ? item.DTipoDocumento : 'N/A'}</td>
                                                            <td>{item.NoLiq ? item.NoLiq : 'N/A'}</td>
                                                            <td>{item.DMonedaPago?item.DMonedaPago:'N/A'}</td>

                                                        </tr>
                                                    ))}
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                </div> */}
                            </div>

                        </div>
                    </div>
                </div>
            </div>
        </div>
    )
}
