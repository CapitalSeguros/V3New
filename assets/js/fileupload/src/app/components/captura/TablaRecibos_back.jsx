import React from 'react';
import CurrencyInputField from 'react-currency-input-field';

export default function TablaRecibos(props) {
    const { Recibos, ChangeValueRecibo, handleBlur, FocusInput, ChangeEdit, values } = props;


    function FormatItem(value) {
        var _return = parseFloat(value);
        return (_return).toLocaleString('es-MX', { style: 'currency', currency: 'MXN' })
    }

    function ParseItem(value) {
        if(value==undefined){
            value='0000-00-00';
        }

        var check = moment(value, 'YYYY-MM-DD', true).isValid();
        var _return = 'N/A';
        if (check) {
            _return = moment(value).format('DD/MM/YYYY');
        }
        return _return;
    }

    return (
        <div className='row'>
            <div className='col-md-12'>
                <div className='table-responsive'>
                    <table className="table table-condensed" id="polizas">
                        <thead style={{ fontSize: '12px' }}>
                            <tr>
                                <th scope="col" style={{ width: '100px' }}>Creacion</th>
                                <th scope="col" style={{ width: '100px' }}>Desde</th>
                                <th scope="col" style={{ width: '100px' }}>Hasta</th>
                                <th scope="col" style={{ width: '100px' }}>Generacion</th>
                                <th scope="col" style={{ width: '100px' }}>Limite Pago</th>
                                <th scope="col" style={{ width: '100px' }}>Periodo</th>
                                <th scope="col" style={{ width: '100px' }}>Serie</th>
                                <th scope="col" style={{ width: '100px' }}>Prima Neta</th>
                                <th scope="col" style={{ width: '100px' }}>Descuento</th>
                                <th scope="col" style={{ width: '100px' }}>% Descuento</th>
                                <th scope="col" style={{ width: '100px' }}>Recargos</th>
                                <th scope="col" style={{ width: '100px' }}>% Recargos</th>
                                <th scope="col" style={{ width: '100px' }}>Derechos</th>
                                <th scope="col" style={{ width: '100px' }}>SubTotal</th>
                                <th scope="col" style={{ width: '100px' }}>IVA</th>
                                <th scope="col" style={{ width: '100px' }}>% IVA</th>
                                <th scope="col" style={{ width: '100px' }}>Ajuste</th>
                                <th scope="col" style={{ width: '100px' }}>Prima Total</th>
                                <th scope="col" style={{ width: '100px' }}></th>
                            </tr>
                        </thead>
                        <tbody>
                            {Recibos.length == 0 && (
                                <tr>
                                    <td className='text-center' colSpan={19}>NO SE HAN GENERADO LOS RECIBOS</td>
                                </tr>
                            )}
                            {Recibos && Recibos.map((item, key) => (
                                (item.IsEdit === true ?
                                    <tr key={key}>
                                        <td>
                                            <input
                                                className="form-control input-sm"
                                                type="date"
                                                name="Creacion"
                                                id="Creacion"
                                                onChange={(e) => ChangeValueRecibo(key, 'Creacion', e.target.value)}
                                                value={item.Creacion ? moment(item.Creacion).format("YYYY-MM-DD") : ''}
                                            />
                                        </td>
                                        <td>
                                            <input
                                                className="form-control input-sm"
                                                type="date"
                                                name="FDesde"
                                                id="FDesde"
                                                onChange={(e) => ChangeValueRecibo(key, 'FDesde', e.target.value)}
                                                value={item.FDesde ? moment(item.FDesde).format("YYYY-MM-DD") : ''}
                                            />
                                        </td>
                                        <td>
                                            <input
                                                className="form-control input-sm"
                                                type="date"
                                                name="FHasta"
                                                id="FHasta"
                                                onChange={(e) => ChangeValueRecibo(key, 'FHasta', moment(e.target.value).format("YYYY-MM-DD"))}
                                                value={item.FHasta ? moment(item.FHasta).format("YYYY-MM-DD") : ''}
                                            />
                                        </td>
                                        <td>
                                            <input
                                                className="form-control input-sm"
                                                type="date"
                                                name="FGeneracion"
                                                id="FGeneracion"
                                                onChange={(e) => ChangeValueRecibo(key, 'FGeneracion', moment(e.target.value).format("YYYY-MM-DD"))}
                                                value={item.FGeneracion ? moment(item.FGeneracion).format("YYYY-MM-DD") : ''}
                                            />
                                        </td>
                                        <td>
                                            <input
                                                className="form-control input-sm"
                                                type="date"
                                                name="FLimPago"
                                                id="FLimPago"
                                                onChange={(e) => ChangeValueRecibo(key, 'FLimPago', moment(e.target.value).format("YYYY-MM-DD"))}
                                                value={item.FLimPago ? moment(item.FLimPago).format("YYYY-MM-DD") : ''}
                                            />
                                        </td>
                                        <td>{item.Periodo}</td>
                                        <td>{item.Serie}</td>
                                        <td>
                                            {/*  <input type="text" onFocus={FocusInput} onChange={(e) => ChangeValueRecibo(key, 'PrimaNeta', e.target.value)} style={{ width: '80px' }} value={item.PrimaNeta} /> */}
                                            <CurrencyInputField
                                                className='form-control input-sm numeric'
                                                style={{ width: '80px' }}
                                                onBlur={handleBlur}
                                                min={0}
                                                maxLength={10}
                                                prefix=''
                                                decimalSeparator='.'
                                                groupSeparator=','
                                                onFocus={FocusInput}
                                                allowNegativeValue={false}
                                                value={item.PrimaNeta}
                                                onValueChange={(value, name) => ChangeValueRecibo(key, 'PrimaNeta', value)}
                                                id='PrimaNeta'
                                                name='PrimaNeta'
                                                autoComplete='off'
                                            />
                                        </td>
                                        <td>
                                            {/* <input type="text" onFocus={FocusInput} onChange={(e) => ChangeValueRecibo(key, 'Descuento', e.target.value)} style={{ width: '80px' }} value={item.Descuento} /> */}
                                            <CurrencyInputField
                                                className='form-control input-sm numeric'
                                                style={{ width: '80px' }}
                                                onBlur={handleBlur}
                                                min={0}
                                                maxLength={10}
                                                prefix=''
                                                decimalSeparator='.'
                                                groupSeparator=','
                                                onFocus={FocusInput}
                                                allowNegativeValue={false}
                                                value={item.Descuento}
                                                onValueChange={(value, name) => ChangeValueRecibo(key, 'Descuento', value)}
                                                id='Descuento'
                                                name='Descuento'
                                                autoComplete='off'
                                            />
                                        </td>
                                        <td>
                                            <CurrencyInputField
                                                className='form-control input-sm numeric'
                                                style={{ width: '80px' }}
                                                onBlur={handleBlur}
                                                min={0}
                                                maxLength={10}
                                                prefix=''
                                                decimalSeparator='.'
                                                groupSeparator=','
                                                onFocus={FocusInput}
                                                allowNegativeValue={false}
                                                value={item.PorDescuento}
                                                onValueChange={(value, name) => ChangeValueRecibo(key, 'PorDescuento', value)}
                                                id='PorDescuento'
                                                name='PorDescuento'
                                                autoComplete='off'
                                            />
                                        </td>
                                        <td>
                                            {/* <input type="text" onFocus={FocusInput} onChange={(e) => ChangeValueRecibo(key, 'Recargos', e.target.value)} style={{ width: '80px' }} value={item.Recargos} /> */}
                                            <CurrencyInputField
                                                className='form-control input-sm numeric'
                                                style={{ width: '80px' }}
                                                onBlur={handleBlur}
                                                min={0}
                                                maxLength={10}
                                                prefix=''
                                                decimalSeparator='.'
                                                groupSeparator=','
                                                onFocus={FocusInput}
                                                allowNegativeValue={false}
                                                value={item.Recargos}
                                                onValueChange={(value, name) => ChangeValueRecibo(key, 'Recargos', value)}
                                                id='RPEspecial'
                                                name='RPEspecial'
                                                autoComplete='off'
                                            />
                                        </td>
                                        <td>
                                            <CurrencyInputField
                                                className='form-control input-sm numeric'
                                                style={{ width: '80px' }}
                                                onBlur={handleBlur}
                                                min={0}
                                                maxLength={10}
                                                prefix=''
                                                decimalSeparator='.'
                                                groupSeparator=','
                                                onFocus={FocusInput}
                                                allowNegativeValue={false}
                                                value={item.Recargos}
                                                onValueChange={(value, name) => ChangeValueRecibo(key, 'Recargos', value)}
                                                id='Recargos'
                                                name='Recargos'
                                                autoComplete='off'
                                            />
                                        </td>
                                        <td>
                                            <CurrencyInputField
                                                className='form-control input-sm numeric'
                                                style={{ width: '80px' }}
                                                onBlur={handleBlur}
                                                min={0}
                                                maxLength={10}
                                                prefix=''
                                                decimalSeparator='.'
                                                groupSeparator=','
                                                onFocus={FocusInput}
                                                allowNegativeValue={false}
                                                value={item.PorRecargos}
                                                onValueChange={(value, name) => ChangeValueRecibo(key, 'PorRecargos', value)}
                                                id='PorRecargos'
                                                name='PorRecargos'
                                                autoComplete='off'
                                            />
                                        </td>
                                        <td>
                                            <CurrencyInputField
                                                className='form-control input-sm numeric'
                                                style={{ width: '80px' }}
                                                onBlur={handleBlur}
                                                min={0}
                                                maxLength={10}
                                                prefix=''
                                                decimalSeparator='.'
                                                groupSeparator=','
                                                onFocus={FocusInput}
                                                allowNegativeValue={false}
                                                value={item.Derechos}
                                                onValueChange={(value, name) => ChangeValueRecibo(key, 'Derechos', value)}
                                                id='Derechos'
                                                name='Derechos'
                                                autoComplete='off'
                                            />
                                        </td>
                                        <td>
                                            <CurrencyInputField
                                                className='form-control input-sm numeric'
                                                style={{ width: '80px' }}
                                                onBlur={handleBlur}
                                                min={0}
                                                maxLength={10}
                                                prefix=''
                                                decimalSeparator='.'
                                                groupSeparator=','
                                                onFocus={FocusInput}
                                                allowNegativeValue={false}
                                                value={item.SubTotal}
                                                onValueChange={(value, name) => ChangeValueRecibo(key, 'SubTotal', value)}
                                                id='SubTotal'
                                                name='SubTotal'
                                                autoComplete='off'
                                            />
                                        </td>
                                        <td>
                                            <CurrencyInputField
                                                className='form-control input-sm numeric'
                                                style={{ width: '80px' }}
                                                onBlur={handleBlur}
                                                min={0}
                                                maxLength={10}
                                                prefix=''
                                                decimalSeparator='.'
                                                groupSeparator=','
                                                onFocus={FocusInput}
                                                allowNegativeValue={false}
                                                value={item.PorIVA}
                                                onValueChange={(value, name) => ChangeValueRecibo(key, 'PorIVA', value)}
                                                id='PorIVA'
                                                name='PorIVA'
                                                autoComplete='off'
                                            />
                                        </td>
                                        <td>
                                            <CurrencyInputField
                                                className='form-control input-sm numeric'
                                                style={{ width: '80px' }}
                                                onBlur={handleBlur}
                                                min={0}
                                                maxLength={10}
                                                prefix=''
                                                decimalSeparator='.'
                                                groupSeparator=','
                                                onFocus={FocusInput}
                                                allowNegativeValue={false}
                                                value={item.Ajuste}
                                                onValueChange={(value, name) => ChangeValueRecibo(key, 'Ajuste', value)}
                                                id='Ajuste'
                                                name='Ajuste'
                                                autoComplete='off'
                                            />
                                        </td>
                                        <td>
                                            <CurrencyInputField
                                                className='form-control input-sm numeric'
                                                style={{ width: '80px' }}
                                                onBlur={handleBlur}
                                                min={0}
                                                maxLength={10}
                                                prefix=''
                                                decimalSeparator='.'
                                                groupSeparator=','
                                                onFocus={FocusInput}
                                                allowNegativeValue={false}
                                                value={item.PrimaTotal}
                                                onValueChange={(value, name) => ChangeValueRecibo(key, 'PrimaTotal', value)}
                                                id='PrimaTotal'
                                                name='PrimaTotal'
                                                autoComplete='off'
                                            />
                                        </td>
                                        <td style={{ display: 'inline-flex' }}>
                                            <a className='btn btn-primary btn-sm' onClick={() => ChangeEdit(key)} data-toggle="tooltip" data-placement="bottom" title="Eliminar recibo"><i className="fa fa-times" aria-hidden="true"></i></a>
                                        </td>
                                    </tr> :
                                    <tr key={key}>
                                        <td>{ParseItem(item.Creacion)}</td>
                                        <td>{ParseItem(item.FDesde)}</td>
                                        <td>{ParseItem(item.FHasta)}</td>
                                        <td>{ParseItem(item.FGeneracion)}</td>
                                        <td>{ParseItem(item.FLimPago)}</td>
                                        <td>{item.Periodo}</td>
                                        <td>{item.Serie}</td>
                                        <td>{FormatItem(item.PrimaNeta)}</td>
                                        <td>{FormatItem(item.Descuento)}</td>
                                        <td>{item.PorDescuento ? item.PorDescuento : '0'}</td>
                                        <td>{FormatItem(item.Recargos)}</td>
                                        <td>{item.PorRecargos ? item.PorRecargos : '0'}</td>
                                        <td>{FormatItem(item.Derechos)}</td>
                                        <td>{FormatItem(item.SubTotal)}</td>
                                        <td>{FormatItem(item.IVA)}</td>
                                        <td>{item.PorIVA ? item.PorIVA : '0'}</td>
                                        <td>{FormatItem(item.Ajuste)}</td>
                                        <td>{FormatItem(item.PrimaTotal)}</td>
                                        <td style={{ display: 'inline-flex' }}>
                                            <a className='btn btn-primary btn-sm' onClick={() => ChangeEdit(key)} data-toggle="tooltip" data-placement="bottom" title="Eliminar recibo"><i className="fa fa-pencil" aria-hidden="true"></i></a>
                                            {/* {values.IDTemp === '' && (
                                                <>
                                                    <a className='btn btn-primary btn-sm' onClick={() => ChangeEdit(key)} data-toggle="tooltip" data-placement="bottom" title="Eliminar recibo"><i className="fa fa-pencil" aria-hidden="true"></i></a>
                                                    <a className='btn btn-primary btn-sm' onClick={() => ''} data-toggle="tooltip" data-placement="bottom" title="Eliminar recibo"><i className="fa fa-trash" aria-hidden="true"></i></a>
                                                </>
                                            )}
 */}
                                        </td>
                                    </tr>)
                            ))}
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    )
}

