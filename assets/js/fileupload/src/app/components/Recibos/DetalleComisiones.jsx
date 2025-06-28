import React from 'react';
import CurrencyInputField from 'react-currency-input-field';
import { round } from '../../Helpers/FGeneral';

export default function DetalleComisiones({ handleBlur, setFieldValue, disabled, NewReloadPrices,
    FocusInput, values, Modulo, moduloOrigen, isEditar, TComisines }) {
    return (
        <>
            {
                !isEditar ?
                    <>
                        <div className='row'>
                            <div className='col-md-12'>
                                <div className="form-groug">
                                    <div className='col-sm-3' style={{ paddingRight: 'unset' }}>
                                        <label className='col-form-label titulo'>Neta</label>
                                    </div>
                                    <div className="col-sm-4" style={{ paddingRight: 'unset' }}>
                                        <CurrencyInputField
                                            className='form-control input-sm numeric'
                                            //onBlur={(e) => { handleBlur, NewReloadPrices("ComN", e.target.value, values) }}
                                            min={0}
                                            maxLength={10}
                                            disabled={true}
                                            //prefix='$'
                                            decimalSeparator='.'
                                            groupSeparator=','
                                            decimalsLimit={2}
                                            decimalScale={2}
                                            onFocus={FocusInput}
                                            allowNegativeValue={false}
                                            value={values.ComN ? round(values.ComN, 2) : '0'}
                                            //onValueChange={(value, name) => { setFieldValue(name, value) /* ChangeValueRecibo(values, 'PrimaNeta', value, null) */ }}
                                            id='ComN'
                                            name='ComN'
                                            autoComplete='off'
                                        />
                                    </div>
                                    <div className="col-sm-4 unsetPadding" style={{ paddingRight: 'unset' }}>
                                        <CurrencyInputField
                                            className='form-control input-sm numeric'
                                            //onBlur={(e) => { handleBlur, NewReloadPrices("PComN", e.target.value, values)/* , ReloadAll(values, null) */ }}
                                            min={0}
                                            maxLength={10}
                                            disabled={true}
                                            prefix=''
                                            decimalSeparator='.'
                                            groupSeparator=','
                                            decimalsLimit={2}
                                            decimalScale={2}
                                            onFocus={FocusInput}
                                            allowNegativeValue={false}
                                            value={values.PComN ? round(values.PComN, 2) : '0'}
                                            //onValueChange={(value, name) => { setFieldValue(name, value) /* ChangeValueRecibo(values, 'PrimaNeta', value, null) */ }}
                                            id='PComN'
                                            name='PComN'
                                            autoComplete='off'
                                        />
                                    </div>
                                </div>
                            </div>
                            {Modulo == 'P' && (
                                <div className='col-md-12'>
                                    <div className="form-groug">
                                        <div className='col-sm-3' style={{ paddingRight: 'unset' }}>
                                            <label className='col-form-label titulo'>Recargos</label>
                                        </div>
                                        <div className="col-sm-4" style={{ paddingRight: 'unset' }}>
                                            <CurrencyInputField
                                                className='form-control input-sm numeric'
                                                //onBlur={(e) => { handleBlur, NewReloadPrices("ComR", e.target.value, values)/* , ReloadAll(values, '') */ }}
                                                min={0}
                                                maxLength={10}
                                                disabled={true}
                                                //prefix='$'
                                                decimalSeparator='.'
                                                groupSeparator=','
                                                decimalsLimit={2}
                                                decimalScale={2}
                                                onFocus={FocusInput}
                                                allowNegativeValue={false}
                                                value={values.ComR ? round(values.ComR, 2) : '0'}
                                                //onValueChange={(value, name) => { setFieldValue(name, value) /* ChangeValueRecibo(values, 'PrimaNeta', value, null) */ }}
                                                id='ComR'
                                                name='ComR'
                                                autoComplete='off'
                                            />
                                        </div>
                                        <div className="col-sm-4 unsetPadding" style={{ paddingRight: 'unset' }}>
                                            <CurrencyInputField
                                                className='form-control input-sm numeric'
                                                //onBlur={(e) => { handleBlur, NewReloadPrices("PComR", e.target.value, values)/* , ReloadAll(values, null) */ }}
                                                min={0}
                                                maxLength={10}
                                                disabled={true}
                                                prefix=''
                                                decimalSeparator='.'
                                                groupSeparator=','
                                                decimalsLimit={2}
                                                decimalScale={2}
                                                onFocus={FocusInput}
                                                allowNegativeValue={false}
                                                value={values.PComR ? round(values.PComR, 2) : '0'}
                                                //onValueChange={(value, name) => { setFieldValue(name, value) /* ChangeValueRecibo(values, 'PrimaNeta', value, null) */ }}
                                                id='PComR'
                                                name='PComR'
                                                autoComplete='off'
                                            />
                                        </div>
                                    </div>
                                </div>
                            )}
                            {Modulo == "E" && moduloOrigen == "P" && (
                                <div className='col-md-12'>
                                    <div className="form-groug">
                                        <div className='col-sm-3' style={{ paddingRight: 'unset' }}>
                                            <label className='col-form-label titulo'>Recargos</label>
                                        </div>
                                        <div className="col-sm-4" style={{ paddingRight: 'unset' }}>
                                            <CurrencyInputField
                                                className='form-control input-sm numeric'
                                                //onBlur={(e) => { handleBlur, NewReloadPrices("ComR", e.target.value, values)/* , ReloadAll(values, '') */ }}
                                                min={0}
                                                maxLength={10}
                                                disabled={true}
                                                //prefix='$'
                                                decimalSeparator='.'
                                                groupSeparator=','
                                                decimalsLimit={2}
                                                decimalScale={2}
                                                onFocus={FocusInput}
                                                allowNegativeValue={false}
                                                value={values.ComR ? round(values.ComR, 2) : '0'}
                                                //onValueChange={(value, name) => { setFieldValue(name, value) /* ChangeValueRecibo(values, 'PrimaNeta', value, null) */ }}
                                                id='ComR'
                                                name='ComR'
                                                autoComplete='off'
                                            />
                                        </div>
                                        <div className="col-sm-4 unsetPadding" style={{ paddingRight: 'unset' }}>
                                            <CurrencyInputField
                                                className='form-control input-sm numeric'
                                                //onBlur={(e) => { handleBlur, NewReloadPrices("PComR", e.target.value, values)/* , ReloadAll(values, null) */ }}
                                                min={0}
                                                maxLength={10}
                                                disabled={true}
                                                prefix=''
                                                decimalSeparator='.'
                                                groupSeparator=','
                                                decimalsLimit={2}
                                                decimalScale={2}
                                                onFocus={FocusInput}
                                                allowNegativeValue={false}
                                                value={values.PComR ? round(values.PComR, 2) : '0'}
                                                //onValueChange={(value, name) => { setFieldValue(name, value) /* ChangeValueRecibo(values, 'PrimaNeta', value, null) */ }}
                                                id='PComR'
                                                name='PComR'
                                                autoComplete='off'
                                            />
                                        </div>
                                    </div>
                                </div>
                            )}
                            {Modulo == "F" && (
                                <>
                                    <div className='col-md-12'>
                                        <div className="form-groug">
                                            <div className='col-sm-3' style={{ paddingRight: 'unset' }}>
                                                <label className='col-form-label titulo'>Gstos Maq</label>
                                            </div>
                                            <div className="col-sm-4" style={{ paddingRight: 'unset' }}>
                                                <CurrencyInputField
                                                    className='form-control input-sm numeric'
                                                    //onBlur={(e) => { handleBlur, NewReloadPrices("CGastosMaq", e.target.value, values)/* , ReloadAll(values, '')  */ }}
                                                    min={0}
                                                    maxLength={10}
                                                    disabled={true}
                                                    //prefix='$'
                                                    decimalSeparator='.'
                                                    groupSeparator=','
                                                    decimalsLimit={2}
                                                    decimalScale={2}
                                                    onFocus={FocusInput}
                                                    allowNegativeValue={false}
                                                    value={values.CGastosMaq ? round(values.CGastosMaq, 2) : '0'}
                                                    //onValueChange={(value, name) => { setFieldValue(name, value) /* ChangeValueRecibo(values, 'PrimaNeta', value, null) */ }}
                                                    id='CGastosMaq'
                                                    name='CGastosMaq'
                                                    autoComplete='off'
                                                />
                                            </div>
                                            <div className="col-sm-4 unsetPadding" style={{ paddingRight: 'unset' }}>
                                                <CurrencyInputField
                                                    className='form-control input-sm numeric'
                                                    //onBlur={(e) => { handleBlur, NewReloadPrices("PCGastosMaq", e.target.value, values)/* , ReloadAll(values, null)  */ }}
                                                    min={0}
                                                    maxLength={10}
                                                    disabled={true}
                                                    prefix=''
                                                    decimalSeparator='.'
                                                    groupSeparator=','
                                                    decimalsLimit={2}
                                                    decimalScale={2}
                                                    onFocus={FocusInput}
                                                    allowNegativeValue={false}
                                                    value={values.PCGastosMaq ? round(values.PCGastosMaq, 2) : '0'}
                                                    //onValueChange={(value, name) => { setFieldValue(name, value) /* ChangeValueRecibo(values, 'PrimaNeta', value, null) */ }}
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
                                                    //onBlur={(e) => { handleBlur, NewReloadPrices("CGastosAdm", e.target.value, values)/* , ReloadAll(values, '')  */ }}
                                                    min={0}
                                                    maxLength={10}
                                                    disabled={true}
                                                    //prefix='$'
                                                    decimalSeparator='.'
                                                    groupSeparator=','
                                                    decimalsLimit={2}
                                                    decimalScale={2}
                                                    onFocus={FocusInput}
                                                    allowNegativeValue={false}
                                                    value={values.CGastosAdm ? round(values.CGastosAdm, 2) : '0'}
                                                    //onValueChange={(value, name) => { setFieldValue(name, value) /* ChangeValueRecibo(values, 'PrimaNeta', value, null) */ }}
                                                    id='CGastosAdm'
                                                    name='CGastosAdm'
                                                    autoComplete='off'
                                                />
                                            </div>
                                            <div className="col-sm-4 unsetPadding" style={{ paddingRight: 'unset' }}>
                                                <CurrencyInputField
                                                    className='form-control input-sm numeric'
                                                    //onBlur={(e) => { handleBlur, NewReloadPrices("PCGastosAdm", e.target.value, values)/* , ReloadAll(values, null) */ }}
                                                    min={0}
                                                    maxLength={10}
                                                    disabled={true}
                                                    prefix=''
                                                    decimalSeparator='.'
                                                    groupSeparator=','
                                                    decimalsLimit={2}
                                                    decimalScale={2}
                                                    onFocus={FocusInput}
                                                    allowNegativeValue={false}
                                                    value={values.PCGastosAdm ? round(values.PCGastosAdm, 2) : '0'}
                                                    //onValueChange={(value, name) => { setFieldValue(name, value) /* ChangeValueRecibo(values, 'PrimaNeta', value, null) */ }}
                                                    id='PCGastosAdm'
                                                    name='PCGastosAdm'
                                                    autoComplete='off'
                                                />
                                            </div>
                                        </div>
                                    </div>
                                </>
                            )}
                            {Modulo == "E" && moduloOrigen == "F" && (
                                <>
                                    <div className='col-md-12'>
                                        <div className="form-groug">
                                            <div className='col-sm-3' style={{ paddingRight: 'unset' }}>
                                                <label className='col-form-label titulo'>Gstos Maq</label>
                                            </div>
                                            <div className="col-sm-4" style={{ paddingRight: 'unset' }}>
                                                <CurrencyInputField
                                                    className='form-control input-sm numeric'
                                                    //onBlur={(e) => { handleBlur, NewReloadPrices("CGastosMaq", e.target.value, values)/* , ReloadAll(values, '')  */ }}
                                                    min={0}
                                                    maxLength={10}
                                                    disabled={true}
                                                    //prefix='$'
                                                    decimalSeparator='.'
                                                    groupSeparator=','
                                                    decimalsLimit={2}
                                                    decimalScale={2}
                                                    onFocus={FocusInput}
                                                    allowNegativeValue={false}
                                                    value={values.CGastosMaq ? round(values.CGastosMaq, 2) : '0'}
                                                    //onValueChange={(value, name) => { setFieldValue(name, value) /* ChangeValueRecibo(values, 'PrimaNeta', value, null) */ }}
                                                    id='CGastosMaq'
                                                    name='CGastosMaq'
                                                    autoComplete='off'
                                                />
                                            </div>
                                            <div className="col-sm-4 unsetPadding" style={{ paddingRight: 'unset' }}>
                                                <CurrencyInputField
                                                    className='form-control input-sm numeric'
                                                    //onBlur={(e) => { handleBlur, NewReloadPrices("PCGastosMaq", e.target.value, values)/* , ReloadAll(values, null)  */ }}
                                                    min={0}
                                                    maxLength={10}
                                                    disabled={true}
                                                    prefix=''
                                                    decimalSeparator='.'
                                                    groupSeparator=','
                                                    decimalsLimit={2}
                                                    decimalScale={2}
                                                    onFocus={FocusInput}
                                                    allowNegativeValue={false}
                                                    value={values.PCGastosMaq ? round(values.PCGastosMaq, 2) : '0'}
                                                    //onValueChange={(value, name) => { setFieldValue(name, value) /* ChangeValueRecibo(values, 'PrimaNeta', value, null) */ }}
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
                                                    //onBlur={(e) => { handleBlur, NewReloadPrices("CGastosAdm", e.target.value, values)/* , ReloadAll(values, '')  */ }}
                                                    min={0}
                                                    maxLength={10}
                                                    disabled={true}
                                                    //prefix='$'
                                                    decimalSeparator='.'
                                                    groupSeparator=','
                                                    decimalsLimit={2}
                                                    decimalScale={2}
                                                    onFocus={FocusInput}
                                                    allowNegativeValue={false}
                                                    value={values.CGastosAdm ? round(values.CGastosAdm, 2) : '0'}
                                                    //onValueChange={(value, name) => { setFieldValue(name, value) /* ChangeValueRecibo(values, 'PrimaNeta', value, null) */ }}
                                                    id='CGastosAdm'
                                                    name='CGastosAdm'
                                                    autoComplete='off'
                                                />
                                            </div>
                                            <div className="col-sm-4 unsetPadding" style={{ paddingRight: 'unset' }}>
                                                <CurrencyInputField
                                                    className='form-control input-sm numeric'
                                                    //onBlur={(e) => { handleBlur, NewReloadPrices("PCGastosAdm", e.target.value, values)/* , ReloadAll(values, null) */ }}
                                                    min={0}
                                                    maxLength={10}
                                                    disabled={true}
                                                    prefix=''
                                                    decimalSeparator='.'
                                                    groupSeparator=','
                                                    decimalsLimit={2}
                                                    decimalScale={2}
                                                    onFocus={FocusInput}
                                                    allowNegativeValue={false}
                                                    value={values.PCGastosAdm ? round(values.PCGastosAdm, 2) : '0'}
                                                    //onValueChange={(value, name) => { setFieldValue(name, value) /* ChangeValueRecibo(values, 'PrimaNeta', value, null) */ }}
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
                                            //onBlur={(e) => { handleBlur, NewReloadPrices("ComD", e.target.value, values)/* , ReloadAll(values, '') */ }}
                                            min={0}
                                            maxLength={10}
                                            disabled={true}
                                            //prefix='$'
                                            decimalSeparator='.'
                                            groupSeparator=','
                                            decimalsLimit={2}
                                            decimalScale={2}
                                            onFocus={FocusInput}
                                            allowNegativeValue={false}
                                            value={values.ComD ? round(values.ComD, 2) : '0'}
                                            //onValueChange={(value, name) => { setFieldValue(name, value) /* NewReloadPrices(name, value, values) */ /* ChangeValueRecibo(values, 'PrimaNeta', value, null) */ }}
                                            id='ComD'
                                            name='ComD'
                                            autoComplete='off'
                                        />
                                    </div>
                                    <div className="col-sm-4 unsetPadding" style={{ paddingRight: 'unset' }}>
                                        <CurrencyInputField
                                            className='form-control input-sm numeric'
                                            //onBlur={(e) => { handleBlur, NewReloadPrices("PComD", e.target.value, values)/* , ReloadAll(values, null)  */ }}
                                            min={0}
                                            maxLength={10}
                                            disabled={true}
                                            prefix=''
                                            decimalSeparator='.'
                                            groupSeparator=','
                                            decimalsLimit={2}
                                            decimalScale={2}
                                            onFocus={FocusInput}
                                            allowNegativeValue={false}
                                            value={values.PComD ? round(values.PComD, 2) : '0'}
                                            //onValueChange={(value, name) => { setFieldValue(name, value) /* NewReloadPrices(name, value, values) */ /* ChangeValueRecibo(values, 'PrimaNeta', value, null) */ }}
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
                                            //onBlur={(e) => { handleBlur, NewReloadPrices("ComD", e.target.value, values) /* ReloadPrices(values) */ }}
                                            min={0}
                                            maxLength={10}
                                            disabled={true}
                                            //prefix='$'
                                            decimalSeparator='.'
                                            groupSeparator=','
                                            decimalsLimit={2}
                                            decimalScale={2}
                                            onFocus={FocusInput}
                                            allowNegativeValue={false}
                                            value={values.ComD ? round(values.ComD, 2) : '0'}
                                            //onValueChange={(value, name) => { setFieldValue(name, value) /* NewReloadPrices(name, value, values) */ /* ChangeValueRecibo(values, 'PrimaNeta', value, null) */ }}
                                            id='ComD'
                                            name='ComD'
                                            autoComplete='off'
                                        />
                                    </div>
                                    <div className="col-sm-4 unsetPadding" style={{ paddingRight: 'unset' }}>
                                        <CurrencyInputField
                                            className='form-control input-sm numeric'
                                            //onBlur={(e) => { handleBlur, NewReloadPrices("PComD", e.target.value, values)/* ,  ReloadPrices(values)*/ }}
                                            min={0}
                                            maxLength={10}
                                            disabled={true}
                                            prefix=''
                                            decimalSeparator='.'
                                            groupSeparator=','
                                            decimalsLimit={2}
                                            decimalScale={2}
                                            onFocus={FocusInput}
                                            allowNegativeValue={false}
                                            value={values.PComD ? round(values.PComD, 2) : '0'}
                                            //onValueChange={(value, name) => { setFieldValue(name, value) /* NewReloadPrices(name, value, values) */ /* ChangeValueRecibo(values, 'PrimaNeta', value, null) */ }}
                                            id='PComD'
                                            name='PComD'
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
                                            //onBlur={(e) => { handleBlur, NewReloadPrices("Especial", e.target.value, values)/* , ReloadPrices(values)*/ }}
                                            min={0}
                                            maxLength={10}
                                            disabled={true}
                                            //prefix='$'
                                            decimalSeparator='.'
                                            groupSeparator=','
                                            decimalsLimit={2}
                                            decimalScale={2}
                                            onFocus={FocusInput}
                                            allowNegativeValue={false}
                                            value={values.Especial ? round(values.Especial, 2) : '0'}
                                            //onValueChange={(value, name) => { setFieldValue(name, value) /* NewReloadPrices(name, value, values) */ /* ChangeValueRecibo(values, 'PrimaNeta', value, null) */ }}
                                            id='Especial'
                                            name='Especial'
                                            autoComplete='off'
                                        />
                                    </div>
                                    <div className="col-sm-4 unsetPadding" style={{ paddingRight: 'unset' }}>
                                        <CurrencyInputField
                                            className='form-control input-sm numeric'
                                            //onBlur={(e) => { handleBlur, NewReloadPrices("PEspecial", e.target.value, values)/* ,  ReloadPrices(values)*/ }}
                                            min={0}
                                            maxLength={10}
                                            disabled={true}
                                            prefix=''
                                            decimalSeparator='.'
                                            groupSeparator=','
                                            decimalsLimit={2}
                                            decimalScale={2}
                                            onFocus={FocusInput}
                                            allowNegativeValue={false}
                                            value={values.PEspecial ? round(values.PEspecial, 2) : '0'}
                                            //onValueChange={(value, name) => { setFieldValue(name, value) /* NewReloadPrices(name, value, values) */ /* ChangeValueRecibo(values, 'PrimaNeta', value, null) */ }}
                                            id='PEspecial'
                                            name='PEspecial'
                                            autoComplete='off'
                                        />
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div className='row'>
                            <div className='col-md-12'>
                                <div className="form-groug">
                                    <div className='col-sm-3' style={{ paddingRight: 'unset' }}>
                                        <label className='col-form-label titulo'>Total Comisiones</label>
                                    </div>
                                    <div className="col-sm-8" style={{ paddingRight: 'unset' }}>
                                        <CurrencyInputField
                                            className='form-control input-sm numeric'
                                            //onBlur={() => { handleBlur, ReloadAll(values, '') }}
                                            min={0}
                                            maxLength={10}
                                            disabled={true}
                                            //prefix='$'
                                            decimalSeparator='.'
                                            groupSeparator=','
                                            decimalsLimit={2}
                                            decimalScale={2}
                                            onFocus={FocusInput}
                                            allowNegativeValue={false}
                                            value={TComisines ? round(TComisines, 2) : '0'}
                                            //onValueChange={(value, name) => { ChangeValueRecibo(values, 'ComN', value, '') }}
                                            id='TComisines'
                                            name='TComisines'
                                            autoComplete='off'
                                        />
                                    </div>
                                </div>
                            </div>
                        </div>
                    </>


                    :


                    <>
                        <div className='row'>
                            <div className='col-md-12'>
                                <div className="form-groug">
                                    <div className='col-sm-3' style={{ paddingRight: 'unset' }}>
                                        <label className='col-form-label titulo'>Neta</label>
                                    </div>
                                    <div className="col-sm-4" style={{ paddingRight: 'unset' }}>
                                        <CurrencyInputField
                                            className='form-control input-sm numeric'
                                            onBlur={(e) => { handleBlur, NewReloadPrices("ComN", e.target.value, values) }}
                                            min={0}
                                            maxLength={10}
                                            disabled={disabled}
                                            //prefix='$'
                                            decimalSeparator='.'
                                            groupSeparator=','
                                            decimalsLimit={4}
                                            decimalScale={4}
                                            onFocus={FocusInput}
                                            allowNegativeValue={false}
                                            value={values.ComN ? values.ComN : '0'}
                                            onValueChange={(value, name) => { setFieldValue(name, value) /* ChangeValueRecibo(values, 'PrimaNeta', value, null) */ }}
                                            id='ComN'
                                            name='ComN'
                                            autoComplete='off'
                                        />
                                    </div>
                                    <div className="col-sm-4 unsetPadding" style={{ paddingRight: 'unset' }}>
                                        <CurrencyInputField
                                            className='form-control input-sm numeric'
                                            onBlur={(e) => { handleBlur, NewReloadPrices("PComN", e.target.value, values)/* , ReloadAll(values, null) */ }}
                                            min={0}
                                            maxLength={10}
                                            disabled={disabled}
                                            prefix=''
                                            decimalSeparator='.'
                                            groupSeparator=','
                                            decimalsLimit={4}
                                            decimalScale={4}
                                            onFocus={FocusInput}
                                            allowNegativeValue={false}
                                            value={values.PComN ? values.PComN : '0'}
                                            onValueChange={(value, name) => { setFieldValue(name, value) /* ChangeValueRecibo(values, 'PrimaNeta', value, null) */ }}
                                            id='PComN'
                                            name='PComN'
                                            autoComplete='off'
                                        />
                                    </div>
                                </div>
                            </div>
                            {Modulo == 'P' && (
                                <div className='col-md-12'>
                                    <div className="form-groug">
                                        <div className='col-sm-3' style={{ paddingRight: 'unset' }}>
                                            <label className='col-form-label titulo'>Recargos</label>
                                        </div>
                                        <div className="col-sm-4" style={{ paddingRight: 'unset' }}>
                                            <CurrencyInputField
                                                className='form-control input-sm numeric'
                                                onBlur={(e) => { handleBlur, NewReloadPrices("ComR", e.target.value, values)/* , ReloadAll(values, '') */ }}
                                                min={0}
                                                maxLength={10}
                                                disabled={disabled}
                                                //prefix='$'
                                                decimalSeparator='.'
                                                groupSeparator=','
                                                decimalsLimit={4}
                                                decimalScale={4}
                                                onFocus={FocusInput}
                                                allowNegativeValue={false}
                                                value={values.ComR ? values.ComR : '0'}
                                                onValueChange={(value, name) => { setFieldValue(name, value) /* ChangeValueRecibo(values, 'PrimaNeta', value, null) */ }}
                                                id='ComR'
                                                name='ComR'
                                                autoComplete='off'
                                            />
                                        </div>
                                        <div className="col-sm-4 unsetPadding" style={{ paddingRight: 'unset' }}>
                                            <CurrencyInputField
                                                className='form-control input-sm numeric'
                                                onBlur={(e) => { handleBlur, NewReloadPrices("PComR", e.target.value, values)/* , ReloadAll(values, null) */ }}
                                                min={0}
                                                maxLength={10}
                                                disabled={disabled}
                                                prefix=''
                                                decimalSeparator='.'
                                                groupSeparator=','
                                                decimalsLimit={4}
                                                decimalScale={4}
                                                onFocus={FocusInput}
                                                allowNegativeValue={false}
                                                value={values.PComR ? values.PComR : '0'}
                                                onValueChange={(value, name) => { setFieldValue(name, value) /* ChangeValueRecibo(values, 'PrimaNeta', value, null) */ }}
                                                id='PComR'
                                                name='PComR'
                                                autoComplete='off'
                                            />
                                        </div>
                                    </div>
                                </div>
                            )}
                            {Modulo == "E" && moduloOrigen == "P" && (
                                <div className='col-md-12'>
                                    <div className="form-groug">
                                        <div className='col-sm-3' style={{ paddingRight: 'unset' }}>
                                            <label className='col-form-label titulo'>Recargos</label>
                                        </div>
                                        <div className="col-sm-4" style={{ paddingRight: 'unset' }}>
                                            <CurrencyInputField
                                                className='form-control input-sm numeric'
                                                onBlur={(e) => { handleBlur, NewReloadPrices("ComR", e.target.value, values)/* , ReloadAll(values, '') */ }}
                                                min={0}
                                                maxLength={10}
                                                disabled={disabled}
                                                //prefix='$'
                                                decimalSeparator='.'
                                                groupSeparator=','
                                                decimalsLimit={4}
                                                decimalScale={4}
                                                onFocus={FocusInput}
                                                allowNegativeValue={false}
                                                value={values.ComR ? values.ComR : '0'}
                                                onValueChange={(value, name) => { setFieldValue(name, value) /* ChangeValueRecibo(values, 'PrimaNeta', value, null) */ }}
                                                id='ComR'
                                                name='ComR'
                                                autoComplete='off'
                                            />
                                        </div>
                                        <div className="col-sm-4 unsetPadding" style={{ paddingRight: 'unset' }}>
                                            <CurrencyInputField
                                                className='form-control input-sm numeric'
                                                onBlur={(e) => { handleBlur, NewReloadPrices("PComR", e.target.value, values)/* , ReloadAll(values, null) */ }}
                                                min={0}
                                                maxLength={10}
                                                disabled={disabled}
                                                prefix=''
                                                decimalSeparator='.'
                                                groupSeparator=','
                                                decimalsLimit={4}
                                                decimalScale={4}
                                                onFocus={FocusInput}
                                                allowNegativeValue={false}
                                                value={values.PComR ? values.PComR : '0'}
                                                onValueChange={(value, name) => { setFieldValue(name, value) /* ChangeValueRecibo(values, 'PrimaNeta', value, null) */ }}
                                                id='PComR'
                                                name='PComR'
                                                autoComplete='off'
                                            />
                                        </div>
                                    </div>
                                </div>
                            )}
                            {Modulo == "F" && (
                                <>
                                    <div className='col-md-12'>
                                        <div className="form-groug">
                                            <div className='col-sm-3' style={{ paddingRight: 'unset' }}>
                                                <label className='col-form-label titulo'>Gstos Maq</label>
                                            </div>
                                            <div className="col-sm-4" style={{ paddingRight: 'unset' }}>
                                                <CurrencyInputField
                                                    className='form-control input-sm numeric'
                                                    onBlur={(e) => { handleBlur, NewReloadPrices("CGastosMaq", e.target.value, values)/* , ReloadAll(values, '')  */ }}
                                                    min={0}
                                                    maxLength={10}
                                                    disabled={disabled}
                                                    //prefix='$'
                                                    decimalSeparator='.'
                                                    groupSeparator=','
                                                    decimalsLimit={4}
                                                    decimalScale={4}
                                                    onFocus={FocusInput}
                                                    allowNegativeValue={false}
                                                    value={values.CGastosMaq ? values.CGastosMaq : '0'}
                                                    onValueChange={(value, name) => { setFieldValue(name, value) /* ChangeValueRecibo(values, 'PrimaNeta', value, null) */ }}
                                                    id='CGastosMaq'
                                                    name='CGastosMaq'
                                                    autoComplete='off'
                                                />
                                            </div>
                                            <div className="col-sm-4 unsetPadding" style={{ paddingRight: 'unset' }}>
                                                <CurrencyInputField
                                                    className='form-control input-sm numeric'
                                                    onBlur={(e) => { handleBlur, NewReloadPrices("PCGastosMaq", e.target.value, values)/* , ReloadAll(values, null)  */ }}
                                                    min={0}
                                                    maxLength={10}
                                                    disabled={disabled}
                                                    prefix=''
                                                    decimalSeparator='.'
                                                    groupSeparator=','
                                                    decimalsLimit={4}
                                                    decimalScale={4}
                                                    onFocus={FocusInput}
                                                    allowNegativeValue={false}
                                                    value={values.PCGastosMaq ? values.PCGastosMaq : '0'}
                                                    onValueChange={(value, name) => { setFieldValue(name, value) /* ChangeValueRecibo(values, 'PrimaNeta', value, null) */ }}
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
                                                    onBlur={(e) => { handleBlur, NewReloadPrices("CGastosAdm", e.target.value, values)/* , ReloadAll(values, '')  */ }}
                                                    min={0}
                                                    maxLength={10}
                                                    disabled={disabled}
                                                    //prefix='$'
                                                    decimalSeparator='.'
                                                    groupSeparator=','
                                                    decimalsLimit={4}
                                                    decimalScale={4}
                                                    onFocus={FocusInput}
                                                    allowNegativeValue={false}
                                                    value={values.CGastosAdm ? values.CGastosAdm : '0'}
                                                    onValueChange={(value, name) => { setFieldValue(name, value) /* ChangeValueRecibo(values, 'PrimaNeta', value, null) */ }}
                                                    id='CGastosAdm'
                                                    name='CGastosAdm'
                                                    autoComplete='off'
                                                />
                                            </div>
                                            <div className="col-sm-4 unsetPadding" style={{ paddingRight: 'unset' }}>
                                                <CurrencyInputField
                                                    className='form-control input-sm numeric'
                                                    onBlur={(e) => { handleBlur, NewReloadPrices("PCGastosAdm", e.target.value, values)/* , ReloadAll(values, null) */ }}
                                                    min={0}
                                                    maxLength={10}
                                                    disabled={disabled}
                                                    prefix=''
                                                    decimalSeparator='.'
                                                    groupSeparator=','
                                                    decimalsLimit={4}
                                                    decimalScale={4}
                                                    onFocus={FocusInput}
                                                    allowNegativeValue={false}
                                                    value={values.PCGastosAdm ? values.PCGastosAdm : '0'}
                                                    onValueChange={(value, name) => { setFieldValue(name, value) /* ChangeValueRecibo(values, 'PrimaNeta', value, null) */ }}
                                                    id='PCGastosAdm'
                                                    name='PCGastosAdm'
                                                    autoComplete='off'
                                                />
                                            </div>
                                        </div>
                                    </div>
                                </>
                            )}
                            {Modulo == "E" && moduloOrigen == "F" && (
                                <>
                                    <div className='col-md-12'>
                                        <div className="form-groug">
                                            <div className='col-sm-3' style={{ paddingRight: 'unset' }}>
                                                <label className='col-form-label titulo'>Gstos Maq</label>
                                            </div>
                                            <div className="col-sm-4" style={{ paddingRight: 'unset' }}>
                                                <CurrencyInputField
                                                    className='form-control input-sm numeric'
                                                    onBlur={(e) => { handleBlur, NewReloadPrices("CGastosMaq", e.target.value, values)/* , ReloadAll(values, '')  */ }}
                                                    min={0}
                                                    maxLength={10}
                                                    disabled={disabled}
                                                    //prefix='$'
                                                    decimalSeparator='.'
                                                    groupSeparator=','
                                                    decimalsLimit={4}
                                                    decimalScale={4}
                                                    onFocus={FocusInput}
                                                    allowNegativeValue={false}
                                                    value={values.CGastosMaq ? values.CGastosMaq : '0'}
                                                    onValueChange={(value, name) => { setFieldValue(name, value) /* ChangeValueRecibo(values, 'PrimaNeta', value, null) */ }}
                                                    id='CGastosMaq'
                                                    name='CGastosMaq'
                                                    autoComplete='off'
                                                />
                                            </div>
                                            <div className="col-sm-4 unsetPadding" style={{ paddingRight: 'unset' }}>
                                                <CurrencyInputField
                                                    className='form-control input-sm numeric'
                                                    onBlur={(e) => { handleBlur, NewReloadPrices("PCGastosMaq", e.target.value, values)/* , ReloadAll(values, null)  */ }}
                                                    min={0}
                                                    maxLength={10}
                                                    disabled={disabled}
                                                    prefix=''
                                                    decimalSeparator='.'
                                                    groupSeparator=','
                                                    decimalsLimit={4}
                                                    decimalScale={4}
                                                    onFocus={FocusInput}
                                                    allowNegativeValue={false}
                                                    value={values.PCGastosMaq ? values.PCGastosMaq : '0'}
                                                    onValueChange={(value, name) => { setFieldValue(name, value) /* ChangeValueRecibo(values, 'PrimaNeta', value, null) */ }}
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
                                                    onBlur={(e) => { handleBlur, NewReloadPrices("CGastosAdm", e.target.value, values)/* , ReloadAll(values, '')  */ }}
                                                    min={0}
                                                    maxLength={10}
                                                    disabled={disabled}
                                                    //prefix='$'
                                                    decimalSeparator='.'
                                                    groupSeparator=','
                                                    decimalsLimit={4}
                                                    decimalScale={4}
                                                    onFocus={FocusInput}
                                                    allowNegativeValue={false}
                                                    value={values.CGastosAdm ? values.CGastosAdm : '0'}
                                                    onValueChange={(value, name) => { setFieldValue(name, value) /* ChangeValueRecibo(values, 'PrimaNeta', value, null) */ }}
                                                    id='CGastosAdm'
                                                    name='CGastosAdm'
                                                    autoComplete='off'
                                                />
                                            </div>
                                            <div className="col-sm-4 unsetPadding" style={{ paddingRight: 'unset' }}>
                                                <CurrencyInputField
                                                    className='form-control input-sm numeric'
                                                    onBlur={(e) => { handleBlur, NewReloadPrices("PCGastosAdm", e.target.value, values)/* , ReloadAll(values, null) */ }}
                                                    min={0}
                                                    maxLength={10}
                                                    disabled={disabled}
                                                    prefix=''
                                                    decimalSeparator='.'
                                                    groupSeparator=','
                                                    decimalsLimit={4}
                                                    decimalScale={4}
                                                    onFocus={FocusInput}
                                                    allowNegativeValue={false}
                                                    value={values.PCGastosAdm ? values.PCGastosAdm : '0'}
                                                    onValueChange={(value, name) => { setFieldValue(name, value) /* ChangeValueRecibo(values, 'PrimaNeta', value, null) */ }}
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
                                            onBlur={(e) => { handleBlur, NewReloadPrices("ComD", e.target.value, values)/* , ReloadAll(values, '') */ }}
                                            min={0}
                                            maxLength={10}
                                            disabled={disabled}
                                            //prefix='$'
                                            decimalSeparator='.'
                                            groupSeparator=','
                                            decimalsLimit={4}
                                            decimalScale={4}
                                            onFocus={FocusInput}
                                            allowNegativeValue={false}
                                            value={values.ComD ? values.ComD : '0'}
                                            onValueChange={(value, name) => { setFieldValue(name, value) /* NewReloadPrices(name, value, values) */ /* ChangeValueRecibo(values, 'PrimaNeta', value, null) */ }}
                                            id='ComD'
                                            name='ComD'
                                            autoComplete='off'
                                        />
                                    </div>
                                    <div className="col-sm-4 unsetPadding" style={{ paddingRight: 'unset' }}>
                                        <CurrencyInputField
                                            className='form-control input-sm numeric'
                                            onBlur={(e) => { handleBlur, NewReloadPrices("PComD", e.target.value, values)/* , ReloadAll(values, null)  */ }}
                                            min={0}
                                            maxLength={10}
                                            disabled={disabled}
                                            prefix=''
                                            decimalSeparator='.'
                                            groupSeparator=','
                                            decimalsLimit={4}
                                            decimalScale={4}
                                            onFocus={FocusInput}
                                            allowNegativeValue={false}
                                            value={values.PComD ? values.PComD : '0'}
                                            onValueChange={(value, name) => { setFieldValue(name, value) /* NewReloadPrices(name, value, values) */ /* ChangeValueRecibo(values, 'PrimaNeta', value, null) */ }}
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
                                            onBlur={(e) => { handleBlur, NewReloadPrices("ComD", e.target.value, values) /* ReloadPrices(values) */ }}
                                            min={0}
                                            maxLength={10}
                                            disabled={disabled}
                                            //prefix='$'
                                            decimalSeparator='.'
                                            groupSeparator=','
                                            decimalsLimit={4}
                                            decimalScale={4}
                                            onFocus={FocusInput}
                                            allowNegativeValue={false}
                                            value={values.ComD ? values.ComD : '0'}
                                            onValueChange={(value, name) => { setFieldValue(name, value) /* NewReloadPrices(name, value, values) */ /* ChangeValueRecibo(values, 'PrimaNeta', value, null) */ }}
                                            id='ComD'
                                            name='ComD'
                                            autoComplete='off'
                                        />
                                    </div>
                                    <div className="col-sm-4 unsetPadding" style={{ paddingRight: 'unset' }}>
                                        <CurrencyInputField
                                            className='form-control input-sm numeric'
                                            onBlur={(e) => { handleBlur, NewReloadPrices("PComD", e.target.value, values)/* ,  ReloadPrices(values)*/ }}
                                            min={0}
                                            maxLength={10}
                                            disabled={disabled}
                                            prefix=''
                                            decimalSeparator='.'
                                            groupSeparator=','
                                            decimalsLimit={4}
                                            decimalScale={4}
                                            onFocus={FocusInput}
                                            allowNegativeValue={false}
                                            value={values.PComD ? values.PComD : '0'}
                                            onValueChange={(value, name) => { setFieldValue(name, value) /* NewReloadPrices(name, value, values) */ /* ChangeValueRecibo(values, 'PrimaNeta', value, null) */ }}
                                            id='PComD'
                                            name='PComD'
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
                                            onBlur={(e) => { handleBlur, NewReloadPrices("Especial", e.target.value, values)/* , ReloadPrices(values)*/ }}
                                            min={0}
                                            maxLength={10}
                                            disabled={disabled}
                                            //prefix='$'
                                            decimalSeparator='.'
                                            groupSeparator=','
                                            decimalsLimit={4}
                                            decimalScale={4}
                                            onFocus={FocusInput}
                                            allowNegativeValue={false}
                                            value={values.Especial ? values.Especial : '0'}
                                            onValueChange={(value, name) => { setFieldValue(name, value) /* NewReloadPrices(name, value, values) */ /* ChangeValueRecibo(values, 'PrimaNeta', value, null) */ }}
                                            id='Especial'
                                            name='Especial'
                                            autoComplete='off'
                                        />
                                    </div>
                                    <div className="col-sm-4 unsetPadding" style={{ paddingRight: 'unset' }}>
                                        <CurrencyInputField
                                            className='form-control input-sm numeric'
                                            onBlur={(e) => { handleBlur, NewReloadPrices("PEspecial", e.target.value, values)/* ,  ReloadPrices(values)*/ }}
                                            min={0}
                                            maxLength={10}
                                            disabled={disabled}
                                            prefix=''
                                            decimalSeparator='.'
                                            groupSeparator=','
                                            decimalsLimit={4}
                                            decimalScale={4}
                                            onFocus={FocusInput}
                                            allowNegativeValue={false}
                                            value={values.PEspecial ? values.PEspecial : '0'}
                                            onValueChange={(value, name) => { setFieldValue(name, value) /* NewReloadPrices(name, value, values) */ /* ChangeValueRecibo(values, 'PrimaNeta', value, null) */ }}
                                            id='PEspecial'
                                            name='PEspecial'
                                            autoComplete='off'
                                        />
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div className='row'>
                            <div className='col-md-12'>
                                <div className="form-groug">
                                    <div className='col-sm-3' style={{ paddingRight: 'unset' }}>
                                        <label className='col-form-label titulo'>Total Comisiones</label>
                                    </div>
                                    <div className="col-sm-8" style={{ paddingRight: 'unset' }}>
                                        <CurrencyInputField
                                            className='form-control input-sm numeric'
                                            //onBlur={() => { handleBlur, ReloadAll(values, '') }}
                                            min={0}
                                            maxLength={10}
                                            disabled={true}
                                            //prefix='$'
                                            decimalSeparator='.'
                                            groupSeparator=','
                                            decimalsLimit={4}
                                            decimalScale={4}
                                            onFocus={FocusInput}
                                            allowNegativeValue={false}
                                            value={TComisines ? TComisines : '0'}
                                            //onValueChange={(value, name) => { ChangeValueRecibo(values, 'ComN', value, '') }}
                                            id='TComisines'
                                            name='TComisines'
                                            autoComplete='off'
                                        />
                                    </div>
                                </div>
                            </div>
                        </div>
                    </>
            }
        </>
    )
}
