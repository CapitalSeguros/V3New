import React, { useState, useEffect, useRef } from 'react';
import { CallApiGet, CallApiPost } from '../../../Helpers/Calls.js';
import { mapitems, mapitemsHijos, displayitem, colourStyles } from '../../../Helpers/FGeneral.js';
import CurrencyInputField from 'react-currency-input-field';


export default function PrimaMin(props) {
    const { Url, SubRamo, Empresa, Monedas } = props;
    const [state, Setstate] = useState([]);
    const [ItemM, SetItemM] = useState([]);
    const [item, SetItem] = useState({
        Id: 0,
        Importe: 0,
        Tipo: 0,
        Id_moneda: 0,
        Registros: []
    });

    function ChangeValueRecibo(index, field, value) {
        const elm = [...item.Registros];
        elm[index][field] = value;
        SetItem({
            ...item,
            Registros: elm
        });
    }

    async function GetPrimas(value) {
        //SetItemM(item);
        var params = {
            Id: Empresa,
            Id_SR: SubRamo,
            Id_M: item.Id_moneda,
            Tipo: "PRIMA",
            TipoId: value
            //TipoId: item.Tipo
        };
        const res = await CallApiGet(`${Url}catalogos/getConfiguracionesSR`, params, null);
        if (res.status != 200) {
            toastr.error(`Error, intente mas tarde. ${res.error}`);
        } else {
            //console.log("Tipo", item.Tipo)
            if (item.Tipo = 1) {
                var ccp = { ...res.success.Datos };
                ccp.Id_moneda = parseInt(item.Id_moneda);
                ccp.Tipo = value;
                SetItem(ccp);
            } else {
                SetItem({
                    ...item,
                    Id_moneda: item.Id_moneda,
                    Tipo: item.Tipo,
                    Registros: res.success.Datos
                });
            }
        }
    }

    async function ChengeAll(nombre, valor) {
        //await SetItem({ ...item, Tipo: valor });
        GetPrimas(valor);
    }

    function ChangeEdit(index, valor) {
        var itms = [...item.Registros];
        itms[index].IsEdit = valor;
        SetItem({ ...item, Registros: itms });
    }

    const FocusInput = (e) => {
        e.target.select();
    }

    async function SaveDerechos() {
        if (item.Id_moneda == undefined) {
            return toastr.error(`Seleccione una moneda.`);
        }

        var params = {
            Id: Empresa,
            Id_SR: SubRamo,
            Id_M: item.Id_moneda,
            Tipo: "PRIMA",
            Importe: item.Importe,
            IdRow: item.Id,
            Registros: item.Registros,
            TipoId: item.Tipo
        };
        //console.log("Parametros",params)
        const res = await CallApiPost(`${Url}catalogos/saveConfiguracionesSR`, params, null);
        if (res.status != 200) {
            toastr.error(`Error, intente mas tarde. ${res.error}`);
        } else {
            toastr.success("Exíto");
            //SetItem(res.success.Datos);
        }
    }

    function DeleteItem(index) {
        var ccp = { ...item };
         var filtered = ccp.Registros.splice(index, 1);
        SetItem(ccp);
    }


    return (
        <div className='row'>
            <div className='col-md-12'>
                <h4>Configuracion de prima minima</h4>
                {/* <a className='btn' onClick={() => console.log('item', item)}>test</a> */}
            </div>
            <div className='col-md-12'>
                <div className='row'>
                    <div className='col-md-4'>
                        <p>Monedas utilizadas</p>

                        <div className='row'>
                            {Monedas && Monedas.map((itm, key) => (
                                <div key={key} className='col-md-12 pt-3 pb-3' style={item.Id_moneda === itm.Id_moneda ? { backgroundColor: '#5A55A3', color: 'white', cursor: 'pointer' } : { backgroundColor: 'unset', cursor: 'pointer' }} onClick={() => SetItem({ ...item, Id_moneda: itm.Id_moneda, Tipo: '' })}>
                                    {itm.Moneda}
                                </div>
                            ))}
                        </div>
                    </div>
                    <div className='col-md-8'>
                        <p>Configuración de la prima minima</p>
                        <div className='row'>
                            {item.Id_moneda != '' && (
                                <div className='col-md-12'>
                                    <div className='form-group'>
                                        <label>Tipo</label>
                                        <select name="Tipo" id="Tipo" className='form-control' onChange={(e) => ChengeAll(e.target.name, e.target.value)}>
                                            <option value="">Seleccione una opcion</option>
                                            <option value="1">Importe Fijo</option>
                                            <option value="2">Rango</option>
                                        </select>
                                    </div>
                                </div>
                            )}
                        </div>

                    </div>

                </div>
                <div className='row'>
                    {item.Tipo == '' && (
                        <div className='col-md-12'>
                            Seleccione una opcion
                        </div>
                    )}
                    {item.Tipo == '1' && (
                        <>
                            <div className='col-md-12'>
                                <div className='form-group'>
                                    <label>Importe fijo</label>
                                    <input className='form-control' name='Importe' id='Importe' value={item.Importe ? item.Importe : '0'} onChange={(e) => SetItem({ ...item, [e.target.name]: e.target.value })} />
                                </div>
                            </div>
                            <div className='col-md-12'>
                                <a className='btn btn-xs btn-primary' onClick={() => SaveDerechos()}>Guardar</a>
                            </div>
                        </>
                    )}
                    {item.Tipo == '2' && (
                        <div className='col-md-12'>
                            <div className='col-md-12 text-right'>
                                <a className='btn btn-xs btn-primary' onClick={() => {
                                    var items = [...item.Registros];
                                    items.push({ Desde: 0, Hasta: 0, Importe: 0 });
                                    SetItem({ ...item, Registros: items });
                                }}> Nuevo</a>
                                <a className='btn btn-xs btn-primary' onClick={() => SaveDerechos()}>Guardar</a>
                            </div>
                            <div className='form-group'>
                                <table className="table table-condensed" id="polizas">
                                    <thead style={{ fontSize: '12px' }}>
                                        <tr>
                                            <th scope="col" style={{ width: '100px' }}>Desde</th>
                                            <th scope="col" style={{ width: '100px' }}>Hasta</th>
                                            <th scope="col" style={{ width: '100px' }}>Cantidad</th>
                                            <th scope="col" style={{ width: '100px' }}></th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        {item.Registros.length == 0 && (
                                            <tr>
                                                <td className='text-center' colSpan={19}>NO SE HAN REGISTRADO</td>
                                            </tr>
                                        )}
                                        {item.Registros && item.Registros.map((item, key) => (
                                            (item.IsEdit === true ?
                                                <tr key={key}>
                                                    <td>
                                                        <CurrencyInputField
                                                            className='form-control input-sm numeric'
                                                            style={{ width: '80px' }}
                                                            //onBlur={handleBlur}
                                                            min={0}
                                                            maxLength={10}
                                                            prefix=''
                                                            decimalSeparator='.'
                                                            groupSeparator=','
                                                            onFocus={FocusInput}
                                                            allowNegativeValue={false}
                                                            value={item.Desde}
                                                            onValueChange={(value, name) => ChangeValueRecibo(key, 'Desde', value)}
                                                            id='Desde'
                                                            name='Desde'
                                                            autoComplete='off'
                                                        />
                                                    </td>
                                                    <td>
                                                        <CurrencyInputField
                                                            className='form-control input-sm numeric'
                                                            style={{ width: '80px' }}
                                                            //onBlur={handleBlur}
                                                            min={0}
                                                            maxLength={10}
                                                            prefix=''
                                                            decimalSeparator='.'
                                                            groupSeparator=','
                                                            onFocus={FocusInput}
                                                            allowNegativeValue={false}
                                                            value={item.Hasta}
                                                            onValueChange={(value, name) => ChangeValueRecibo(key, 'Hasta', value)}
                                                            id='Hasta'
                                                            name='Hasta'
                                                            autoComplete='off'
                                                        />
                                                    </td>
                                                    <td>
                                                        <CurrencyInputField
                                                            className='form-control input-sm numeric'
                                                            style={{ width: '80px' }}
                                                            //onBlur={handleBlur}
                                                            min={0}
                                                            maxLength={10}
                                                            prefix=''
                                                            decimalSeparator='.'
                                                            groupSeparator=','
                                                            onFocus={FocusInput}
                                                            allowNegativeValue={false}
                                                            value={item.Importe}
                                                            onValueChange={(value, name) => ChangeValueRecibo(key, 'Importe', value)}
                                                            id='Cantidad'
                                                            name='Cantidad'
                                                            autoComplete='off'
                                                        />
                                                    </td>
                                                    <td style={{ display: 'inline-flex' }}>
                                                        <a className='btn btn-primary btn-sm' onClick={() => ChangeEdit(key, false)} data-toggle="tooltip" data-placement="bottom" title="Cancelar editar"><i className="fa fa-times" aria-hidden="true"></i></a>
                                                    </td>
                                                </tr> :
                                                <tr key={key}>
                                                    <td>{item.Desde}</td>
                                                    <td>{item.Hasta}</td>
                                                    <td>{item.Importe}</td>
                                                    <td style={{ display: 'inline-flex' }}>
                                                        <a className='btn btn-primary btn-sm' onClick={() => ChangeEdit(key, true)} data-toggle="tooltip" data-placement="bottom" title="Editar"><i className="fa fa-pencil" aria-hidden="true"></i></a>
                                                        <a className='btn btn-primary btn-sm' onClick={() => DeleteItem(key)} data-toggle="tooltip" data-placement="bottom" title="Eliminar"><i className="fa fa-trash" aria-hidden="true"></i></a>
                                                    </td>
                                                </tr>)
                                        ))}
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    )}
                </div>
            </div>
        </div>
    )
}
