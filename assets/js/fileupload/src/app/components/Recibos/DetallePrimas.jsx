import React from 'react';
import CurrencyInputField from 'react-currency-input-field';
import { round } from '../../Helpers/FGeneral';

export default function DetallePrimas({ handleBlur, setFieldValue, disabled, NewReloadPrices,
    FocusInput, values, Modulo, moduloOrigen, isEditar }) {
    return (
        <>
            {
                !isEditar ?
                    <>
                        <div className='col-md-12'>
                            <div className="form-group">
                                <div className='col-sm-3' style={{ paddingRight: 'unset' }}>
                                    <label className='col-form-label titulo'>P Neta</label>
                                </div>
                                <div className="col-sm-8" style={{ paddingRight: 'unset' }}>
                                    <CurrencyInputField
                                        className='form-control input-sm numeric'
                                        onBlur={(e) => { handleBlur, NewReloadPrices("PrimaNeta", e.target.value, values) }}
                                        min={0}
                                        maxLength={10}
                                        disabled={true}
                                        //prefix='$'
                                        decimalSeparator='.'
                                        groupSeparator=','
                                        prefix=''
                                        decimalsLimit={2}
                                        decimalScale={2}
                                        onFocus={FocusInput}
                                        allowNegativeValue={false}
                                        value={round(values.PrimaNeta, 2) || 0}
                                        onValueChange={(value, name) => { setFieldValue(name, value) }}
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
                                        onBlur={(e) => { handleBlur, NewReloadPrices("Descuento", e.target.value, values) }}
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
                                        value={values.Descuento ? round(values.Descuento, 2) : '0'}
                                        onValueChange={(value, name) => { setFieldValue(name, value) }}
                                        id='Descuento'
                                        name='Descuento'
                                        autoComplete='off'
                                    />
                                </div>
                                <div className="col-sm-4 unsetPadding" style={{ paddingRight: 'unset' }}>
                                    <CurrencyInputField
                                        className='form-control input-sm numeric'
                                        onBlur={(e) => { handleBlur, NewReloadPrices("PDescuento", e.target.value, values) /* , ReloadAll(values, null) */ }}
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
                                        value={values.PDescuento ? round(values.PDescuento, 2) : '0'}
                                        onValueChange={(value, name) => { setFieldValue(name, value) /* ChangeValueRecibo(values, 'PrimaNeta', value, null) */ }}
                                        id='PDescuento'
                                        name='PDescuento'
                                        autoComplete='off'
                                    />
                                </div>
                            </div>
                        </div>
                        {Modulo == "P" && (
                            <div className='col-md-12'>
                                <div className="form-groug">
                                    <div className='col-sm-3' style={{ paddingRight: 'unset' }}>
                                        <label className='col-form-label titulo'>Recargos</label>
                                    </div>
                                    <div className="col-sm-4" style={{ paddingRight: 'unset' }}>
                                        <CurrencyInputField
                                            className='form-control input-sm numeric'
                                            onBlur={(e) => { handleBlur, NewReloadPrices("Recargos", e.target.value, values)/* , ReloadAll(values, '') */ }}
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
                                            value={values.Recargos ? round(values.Recargos, 2) : '0'}
                                            onValueChange={(value, name) => { setFieldValue(name, value) /* ChangeValueRecibo(values, 'PrimaNeta', value, null) */ }}
                                            id='Recargos'
                                            name='Recargos'
                                            autoComplete='off'
                                        />
                                    </div>
                                    <div className="col-sm-4 unsetPadding" style={{ paddingRight: 'unset' }}>
                                        <CurrencyInputField
                                            className='form-control input-sm numeric'
                                            onBlur={(e) => { handleBlur, NewReloadPrices("PorRecargos", e.target.value, values)/* , ReloadAll(values, null) */ }}
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
                                            value={values.PorRecargos ? round(values.PorRecargos, 2) : '0'}
                                            onValueChange={(value, name) => { setFieldValue(name, value) /* ChangeValueRecibo(values, 'PrimaNeta', value, null) */ }}
                                            id='PorRecargos'
                                            name='PorRecargos'
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
                                            onBlur={(e) => { handleBlur, NewReloadPrices("Recargos", e.target.value, values)/* , ReloadAll(values, '') */ }}
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
                                            value={values.Recargos ? round(values.Recargos, 2) : '0'}
                                            onValueChange={(value, name) => { setFieldValue(name, value) /* ChangeValueRecibo(values, 'PrimaNeta', value, null) */ }}
                                            id='Recargos'
                                            name='Recargos'
                                            autoComplete='off'
                                        />
                                    </div>
                                    <div className="col-sm-4 unsetPadding" style={{ paddingRight: 'unset' }}>
                                        <CurrencyInputField
                                            className='form-control input-sm numeric'
                                            onBlur={(e) => { handleBlur, NewReloadPrices("PorRecargos", e.target.value, values)/* , ReloadAll(values, null) */ }}
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
                                            value={values.PorRecargos ? round(values.PorRecargos, 2) : '0'}
                                            onValueChange={(value, name) => { setFieldValue(name, value) /* ChangeValueRecibo(values, 'PrimaNeta', value, null) */ }}
                                            id='PorRecargos'
                                            name='PorRecargos'
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
                                        <div className="col-sm-8" style={{ paddingRight: 'unset' }}>
                                            <CurrencyInputField
                                                className='form-control input-sm numeric'
                                                onBlur={(e) => { handleBlur, NewReloadPrices("GastosMaq", e.target.value, values)/* , ReloadAll(values, null) */ }}
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
                                                value={values.GastosMaq ? round(values.GastosMaq, 2) : '0'}
                                                onValueChange={(value, name) => { setFieldValue(name, value) /* ChangeValueRecibo(values, 'PrimaNeta', value, null) */ }}
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
                                                onBlur={(e) => { handleBlur, NewReloadPrices("GastosAdm", e.target.value, values) /* , ReloadAll(values, null) */ }}
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
                                                value={values.GastosAdm ? round(values.GastosAdm, 2) : '0'}
                                                onValueChange={(value, name) => { setFieldValue(name, value) /* ChangeValueRecibo(values, 'PrimaNeta', value, null) */ }}
                                                id='GastosAdm'
                                                name='GastosAdm'
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
                                        <div className="col-sm-8" style={{ paddingRight: 'unset' }}>
                                            <CurrencyInputField
                                                className='form-control input-sm numeric'
                                                onBlur={(e) => { handleBlur, NewReloadPrices("GastosMaq", e.target.value, values)/* , ReloadAll(values, null) */ }}
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
                                                value={values.GastosMaq ? round(values.GastosMaq, 2) : '0'}
                                                onValueChange={(value, name) => { setFieldValue(name, value) /* ChangeValueRecibo(values, 'PrimaNeta', value, null) */ }}
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
                                                onBlur={(e) => { handleBlur, NewReloadPrices("GastosAdm", e.target.value, values) /* , ReloadAll(values, null) */ }}
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
                                                value={values.GastosAdm ? round(values.GastosAdm, 2) : '0'}
                                                onValueChange={(value, name) => { setFieldValue(name, value) /* ChangeValueRecibo(values, 'PrimaNeta', value, null) */ }}
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
                                    <CurrencyInputField
                                        className='form-control input-sm numeric'
                                        onBlur={(e) => { handleBlur, NewReloadPrices("Derechos", e.target.value, values)/* , ReloadAll(values, null) */ }}
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
                                        value={values.Derechos ? round(values.Derechos, 2) : '0'}
                                        onValueChange={(value, name) => { setFieldValue(name, value) /* ChangeValueRecibo(values, 'PrimaNeta', value, null) */ }}
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
                                        className='form-control input-sm numeric'
                                        onBlur={(e) => { handleBlur, NewReloadPrices("Subtotal", e.target.value, values) /* 'ReloadPrices(values)' */ }}
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
                                        value={values.SubTotal ? round(values.SubTotal, 2) : '0'}
                                        onValueChange={(value, name) => { setFieldValue(name, value) /* ChangeValueRecibo(values, 'PrimaNeta', value, null) */ }}
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
                                        onBlur={(e) => { handleBlur, NewReloadPrices("IVA", e.target.value, values)/* , ReloadAll(values, 'IVA') */ }}
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
                                        value={values.IVA ? round(values.IVA, 2) : '0'}
                                        onValueChange={(value, name) => { setFieldValue(name, value) /* ChangeValueRecibo(values, 'PrimaNeta', value, null) */ }}
                                        id='IVA'
                                        name='IVA'
                                        autoComplete='off'
                                    />
                                </div>
                                <div className="col-sm-4 unsetPadding" style={{ paddingRight: 'unset' }}>
                                    <CurrencyInputField
                                        className='form-control input-sm numeric'
                                        onBlur={(e) => { handleBlur, NewReloadPrices("PorIVA", e.target.value, values)/* , ReloadAll(values, null) */ }}
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
                                        value={values.PorIVA ? round(values.PorIVA, 2) : '0'}
                                        onValueChange={(value, name) => { setFieldValue(name, value) /* ChangeValueRecibo(values, 'PrimaNeta', value, null) */ }}
                                        id='PorIVA'
                                        name='PorIVA'
                                        autoComplete='off'
                                    />
                                </div>
                            </div>
                        </div>
                        {
                            Modulo == 'P' && (
                                <div className='col-md-12'>
                                    <div className="form-group">
                                        <div className='col-sm-3' style={{ paddingRight: 'unset' }}>
                                            <label className='col-form-label titulo'>Ajuste</label>
                                        </div>
                                        <div className="col-sm-8" style={{ paddingRight: 'unset' }}>
                                            {/* <input type="text" className="form-control input-sm numeric" name="PrimaNeta" id="PrimaNeta" onFocus={e => e.target.select()} onChange={handleChange} value={values.PrimaNeta ? values.PrimaNeta : '0'} /> */}
                                            <CurrencyInputField
                                                className='form-control input-sm numeric'
                                                onBlur={(e) => { handleBlur, NewReloadPrices("Ajuste", e.target.value, values) /* 'ReloadPrices(values)' */ }}
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
                                                value={values.Ajuste ? round(values.Ajuste, 2) : '0'}
                                                onValueChange={(value, name) => { setFieldValue(name, value) /* ChangeValueRecibo(values, 'PrimaNeta', value, null) */ }}
                                                id='Ajuste'
                                                name='Ajuste'
                                                autoComplete='off'
                                            />
                                        </div>
                                    </div>
                                </div>
                            )
                        }
                        {
                            Modulo == 'E' && moduloOrigen == "P" && (
                                <div className='col-md-12'>
                                    <div className="form-group">
                                        <div className='col-sm-3' style={{ paddingRight: 'unset' }}>
                                            <label className='col-form-label titulo'>Ajuste</label>
                                        </div>
                                        <div className="col-sm-8" style={{ paddingRight: 'unset' }}>
                                            {/* <input type="text" className="form-control input-sm numeric" name="PrimaNeta" id="PrimaNeta" onFocus={e => e.target.select()} onChange={handleChange} value={values.PrimaNeta ? values.PrimaNeta : '0'} /> */}
                                            <CurrencyInputField
                                                className='form-control input-sm numeric'
                                                onBlur={(e) => { handleBlur, NewReloadPrices("Ajuste", e.target.value, values) /* 'ReloadPrices(values)' */ }}
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
                                                value={values.Ajuste ? round(values.Ajuste, 2) : '0'}
                                                onValueChange={(value, name) => { setFieldValue(name, value) /* ChangeValueRecibo(values, 'PrimaNeta', value, null) */ }}
                                                id='Ajuste'
                                                name='Ajuste'
                                                autoComplete='off'
                                            />
                                        </div>
                                    </div>
                                </div>
                            )
                        }
                        <div className='col-md-12'>
                            <div className="form-group">
                                <div className='col-sm-3' style={{ paddingRight: 'unset' }}>
                                    <label className='col-form-label titulo'>Prima Total</label>
                                </div>
                                <div className="col-sm-8" style={{ paddingRight: 'unset' }}>
                                    {/* <input type="text" className="form-control input-sm numeric" name="PrimaNeta" id="PrimaNeta" onFocus={e => e.target.select()} onChange={handleChange} value={values.PrimaNeta ? values.PrimaNeta : '0'} /> */}
                                    <CurrencyInputField
                                        className='form-control input-sm numeric'
                                        onBlur={(e) => { handleBlur, NewReloadPrices("PrimaTotal", e.target.value, values) /* 'ReloadPrices(values)' */ }}
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
                                        value={values.PrimaTotal ? round(values.PrimaTotal, 2) : '0'}
                                        onValueChange={(value, name) => { setFieldValue(name, value) /* ChangeValueRecibo(values, 'PrimaNeta', value, null) */ }}
                                        id='PrimaTotal'
                                        name='PrimaTotal'
                                        autoComplete='off'
                                    />
                                </div>
                            </div>
                        </div>
                    </>


                    :


                    <>
                        <div className='col-md-12'>
                            <div className="form-group">
                                <div className='col-sm-3' style={{ paddingRight: 'unset' }}>
                                    <label className='col-form-label titulo'>P Neta</label>
                                </div>
                                <div className="col-sm-8" style={{ paddingRight: 'unset' }}>
                                    <CurrencyInputField
                                        className='form-control input-sm numeric'
                                        onBlur={(e) => { handleBlur, NewReloadPrices("PrimaNeta", e.target.value, values) }}
                                        min={0}
                                        maxLength={10}
                                        disabled={disabled}
                                        //prefix='$'
                                        decimalSeparator='.'
                                        groupSeparator=','
                                        prefix=''
                                        decimalsLimit={4}
                                        decimalScale={4}
                                        onFocus={FocusInput}
                                        allowNegativeValue={false}
                                        value={values.PrimaNeta || 0}
                                        onValueChange={(value, name) => { setFieldValue(name, value) }}
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
                                        onBlur={(e) => { handleBlur, NewReloadPrices("Descuento", e.target.value, values) }}
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
                                        value={values.Descuento ? values.Descuento : '0'}
                                        onValueChange={(value, name) => { setFieldValue(name, value) }}
                                        id='Descuento'
                                        name='Descuento'
                                        autoComplete='off'
                                    />
                                </div>
                                <div className="col-sm-4 unsetPadding" style={{ paddingRight: 'unset' }}>
                                    <CurrencyInputField
                                        className='form-control input-sm numeric'
                                        onBlur={(e) => { handleBlur, NewReloadPrices("PDescuento", e.target.value, values) /* , ReloadAll(values, null) */ }}
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
                                        value={values.PDescuento ? values.PDescuento : '0'}
                                        onValueChange={(value, name) => { setFieldValue(name, value) /* ChangeValueRecibo(values, 'PrimaNeta', value, null) */ }}
                                        id='PDescuento'
                                        name='PDescuento'
                                        autoComplete='off'
                                    />
                                </div>
                            </div>
                        </div>
                        {Modulo == "P" && (
                            <div className='col-md-12'>
                                <div className="form-groug">
                                    <div className='col-sm-3' style={{ paddingRight: 'unset' }}>
                                        <label className='col-form-label titulo'>Recargos</label>
                                    </div>
                                    <div className="col-sm-4" style={{ paddingRight: 'unset' }}>
                                        <CurrencyInputField
                                            className='form-control input-sm numeric'
                                            onBlur={(e) => { handleBlur, NewReloadPrices("Recargos", e.target.value, values)/* , ReloadAll(values, '') */ }}
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
                                            value={values.Recargos ? values.Recargos : '0'}
                                            onValueChange={(value, name) => { setFieldValue(name, value) /* ChangeValueRecibo(values, 'PrimaNeta', value, null) */ }}
                                            id='Recargos'
                                            name='Recargos'
                                            autoComplete='off'
                                        />
                                    </div>
                                    <div className="col-sm-4 unsetPadding" style={{ paddingRight: 'unset' }}>
                                        <CurrencyInputField
                                            className='form-control input-sm numeric'
                                            onBlur={(e) => { handleBlur, NewReloadPrices("PorRecargos", e.target.value, values)/* , ReloadAll(values, null) */ }}
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
                                            value={values.PorRecargos ? values.PorRecargos : '0'}
                                            onValueChange={(value, name) => { setFieldValue(name, value) /* ChangeValueRecibo(values, 'PrimaNeta', value, null) */ }}
                                            id='PorRecargos'
                                            name='PorRecargos'
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
                                            onBlur={(e) => { handleBlur, NewReloadPrices("Recargos", e.target.value, values)/* , ReloadAll(values, '') */ }}
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
                                            value={values.Recargos ? values.Recargos : '0'}
                                            onValueChange={(value, name) => { setFieldValue(name, value) /* ChangeValueRecibo(values, 'PrimaNeta', value, null) */ }}
                                            id='Recargos'
                                            name='Recargos'
                                            autoComplete='off'
                                        />
                                    </div>
                                    <div className="col-sm-4 unsetPadding" style={{ paddingRight: 'unset' }}>
                                        <CurrencyInputField
                                            className='form-control input-sm numeric'
                                            onBlur={(e) => { handleBlur, NewReloadPrices("PorRecargos", e.target.value, values)/* , ReloadAll(values, null) */ }}
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
                                            value={values.PorRecargos ? values.PorRecargos : '0'}
                                            onValueChange={(value, name) => { setFieldValue(name, value) /* ChangeValueRecibo(values, 'PrimaNeta', value, null) */ }}
                                            id='PorRecargos'
                                            name='PorRecargos'
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
                                        <div className="col-sm-8" style={{ paddingRight: 'unset' }}>
                                            <CurrencyInputField
                                                className='form-control input-sm numeric'
                                                onBlur={(e) => { handleBlur, NewReloadPrices("GastosMaq", e.target.value, values)/* , ReloadAll(values, null) */ }}
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
                                                value={values.GastosMaq ? values.GastosMaq : '0'}
                                                onValueChange={(value, name) => { setFieldValue(name, value) /* ChangeValueRecibo(values, 'PrimaNeta', value, null) */ }}
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
                                                onBlur={(e) => { handleBlur, NewReloadPrices("GastosAdm", e.target.value, values) /* , ReloadAll(values, null) */ }}
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
                                                value={values.GastosAdm ? values.GastosAdm : '0'}
                                                onValueChange={(value, name) => { setFieldValue(name, value) /* ChangeValueRecibo(values, 'PrimaNeta', value, null) */ }}
                                                id='GastosAdm'
                                                name='GastosAdm'
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
                                        <div className="col-sm-8" style={{ paddingRight: 'unset' }}>
                                            <CurrencyInputField
                                                className='form-control input-sm numeric'
                                                onBlur={(e) => { handleBlur, NewReloadPrices("GastosMaq", e.target.value, values)/* , ReloadAll(values, null) */ }}
                                                min={0}
                                                maxLength={10}
                                                disabled={disabled}
                                                //prefix='$'
                                                decimalSeparator='.'
                                                groupSeparator=','
                                                decimalsLimit={2}
                                                decimalScale={2}
                                                onFocus={FocusInput}
                                                allowNegativeValue={false}
                                                value={values.GastosMaq ? values.GastosMaq : '0'}
                                                onValueChange={(value, name) => { setFieldValue(name, value) /* ChangeValueRecibo(values, 'PrimaNeta', value, null) */ }}
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
                                                onBlur={(e) => { handleBlur, NewReloadPrices("GastosAdm", e.target.value, values) /* , ReloadAll(values, null) */ }}
                                                min={0}
                                                maxLength={10}
                                                disabled={disabled}
                                                //prefix='$'
                                                decimalSeparator='.'
                                                groupSeparator=','
                                                decimalsLimit={2}
                                                decimalScale={2}
                                                onFocus={FocusInput}
                                                allowNegativeValue={false}
                                                value={values.GastosAdm ? values.GastosAdm : '0'}
                                                onValueChange={(value, name) => { setFieldValue(name, value) /* ChangeValueRecibo(values, 'PrimaNeta', value, null) */ }}
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
                                        onBlur={(e) => { handleBlur, NewReloadPrices("Derechos", e.target.value, values)/* , ReloadAll(values, null) */ }}
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
                                        value={values.Derechos ? values.Derechos : '0'}
                                        onValueChange={(value, name) => { setFieldValue(name, value) /* ChangeValueRecibo(values, 'PrimaNeta', value, null) */ }}
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
                                        disabled
                                        className='form-control input-sm numeric'
                                        onBlur={(e) => { handleBlur, NewReloadPrices("Subtotal", e.target.value, values) /* 'ReloadPrices(values)' */ }}
                                        min={0}
                                        maxLength={10}
                                        //prefix='$'
                                        decimalSeparator='.'
                                        groupSeparator=','
                                        decimalsLimit={4}
                                        decimalScale={4}
                                        onFocus={FocusInput}
                                        allowNegativeValue={false}
                                        value={values.SubTotal ? values.SubTotal : '0'}
                                        onValueChange={(value, name) => { setFieldValue(name, value) /* ChangeValueRecibo(values, 'PrimaNeta', value, null) */ }}
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
                                        onBlur={(e) => { handleBlur, NewReloadPrices("IVA", e.target.value, values)/* , ReloadAll(values, 'IVA') */ }}
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
                                        value={values.IVA ? values.IVA : '0'}
                                        onValueChange={(value, name) => { setFieldValue(name, value) /* ChangeValueRecibo(values, 'PrimaNeta', value, null) */ }}
                                        id='IVA'
                                        name='IVA'
                                        autoComplete='off'
                                    />
                                </div>
                                <div className="col-sm-4 unsetPadding" style={{ paddingRight: 'unset' }}>
                                    <CurrencyInputField
                                        className='form-control input-sm numeric'
                                        onBlur={(e) => { handleBlur, NewReloadPrices("PorIVA", e.target.value, values)/* , ReloadAll(values, null) */ }}
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
                                        value={values.PorIVA ? values.PorIVA : '0'}
                                        onValueChange={(value, name) => { setFieldValue(name, value) /* ChangeValueRecibo(values, 'PrimaNeta', value, null) */ }}
                                        id='PorIVA'
                                        name='PorIVA'
                                        autoComplete='off'
                                    />
                                </div>
                            </div>
                        </div>
                        {
                            Modulo == 'P' && (
                                <div className='col-md-12'>
                                    <div className="form-group">
                                        <div className='col-sm-3' style={{ paddingRight: 'unset' }}>
                                            <label className='col-form-label titulo'>Ajuste</label>
                                        </div>
                                        <div className="col-sm-8" style={{ paddingRight: 'unset' }}>
                                            {/* <input type="text" className="form-control input-sm numeric" name="PrimaNeta" id="PrimaNeta" onFocus={e => e.target.select()} onChange={handleChange} value={values.PrimaNeta ? values.PrimaNeta : '0'} /> */}
                                            <CurrencyInputField
                                                className='form-control input-sm numeric'
                                                onBlur={(e) => { handleBlur, NewReloadPrices("Ajuste", e.target.value, values) /* 'ReloadPrices(values)' */ }}
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
                                                value={values.Ajuste ? values.Ajuste : '0'}
                                                onValueChange={(value, name) => { setFieldValue(name, value) /* ChangeValueRecibo(values, 'PrimaNeta', value, null) */ }}
                                                id='Ajuste'
                                                name='Ajuste'
                                                autoComplete='off'
                                            />
                                        </div>
                                    </div>
                                </div>
                            )
                        }
                        {
                            Modulo == 'E' && moduloOrigen == "P" && (
                                <div className='col-md-12'>
                                    <div className="form-group">
                                        <div className='col-sm-3' style={{ paddingRight: 'unset' }}>
                                            <label className='col-form-label titulo'>Ajuste</label>
                                        </div>
                                        <div className="col-sm-8" style={{ paddingRight: 'unset' }}>
                                            {/* <input type="text" className="form-control input-sm numeric" name="PrimaNeta" id="PrimaNeta" onFocus={e => e.target.select()} onChange={handleChange} value={values.PrimaNeta ? values.PrimaNeta : '0'} /> */}
                                            <CurrencyInputField
                                                className='form-control input-sm numeric'
                                                onBlur={(e) => { handleBlur, NewReloadPrices("Ajuste", e.target.value, values) /* 'ReloadPrices(values)' */ }}
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
                                                value={values.Ajuste ? values.Ajuste : '0'}
                                                onValueChange={(value, name) => { setFieldValue(name, value) /* ChangeValueRecibo(values, 'PrimaNeta', value, null) */ }}
                                                id='Ajuste'
                                                name='Ajuste'
                                                autoComplete='off'
                                            />
                                        </div>
                                    </div>
                                </div>
                            )
                        }
                        <div className='col-md-12'>
                            <div className="form-group">
                                <div className='col-sm-3' style={{ paddingRight: 'unset' }}>
                                    <label className='col-form-label titulo'>Prima Total</label>
                                </div>
                                <div className="col-sm-8" style={{ paddingRight: 'unset' }}>
                                    {/* <input type="text" className="form-control input-sm numeric" name="PrimaNeta" id="PrimaNeta" onFocus={e => e.target.select()} onChange={handleChange} value={values.PrimaNeta ? values.PrimaNeta : '0'} /> */}
                                    <CurrencyInputField
                                        className='form-control input-sm numeric'
                                        onBlur={(e) => { handleBlur, NewReloadPrices("PrimaTotal", e.target.value, values) /* 'ReloadPrices(values)' */ }}
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
                                        value={values.PrimaTotal ? values.PrimaTotal : '0'}
                                        onValueChange={(value, name) => { setFieldValue(name, value) /* ChangeValueRecibo(values, 'PrimaNeta', value, null) */ }}
                                        id='PrimaTotal'
                                        name='PrimaTotal'
                                        autoComplete='off'
                                    />
                                </div>
                            </div>
                        </div>
                    </>
            }
        </>
    )
}
