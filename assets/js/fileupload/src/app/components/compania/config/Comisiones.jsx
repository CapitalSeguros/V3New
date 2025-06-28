import React, { useState, useEffect, useRef, forwardRef, useImperativeHandle } from 'react';
import Select from "react-select";
import { CallApiGet, CallApiPost } from '../../../Helpers/Calls.js';
import { mapitems, displayitem, mapitemsHijos, colourStyles } from '../../../Helpers/FGeneral.js';
import CurrencyInputField from 'react-currency-input-field';
import { GetName, ShowLoading } from '../../../Helpers/FGeneral.js';

const Comisiones = forwardRef((props, ref) => {
    useImperativeHandle(ref, () => {
        return {
            Reload: Reload
        }
    });

    function Reload() {
        Setstate({
            Moneda: '',
            Comsion: '',
            OpcionComision: ''
        });
        SetItem({
            Id: 0,
            Importe: 0,
            Tipo: 0,
            Id_moneda: 0,
            Registros: [],
            Agentes: []
        });
    }

    const { Url, SubRamo, Empresa, Monedas } = props;
    const Comisiones = [
        {
            Nombre: 'Comisión Base o de Neta',
            Id: 1
        },
        {
            Nombre: 'Comisión de Recargos',
            Id: 3
        },
        {
            Nombre: 'Comisión de Derechos',
            Id: 4
        }
    ];

    const FComisiones = [
        {
            Nombre: '% Comisión Base o Prima Neta.',
            Id: 3
        },
        {
            Nombre: '% Comision Recargos',//%Comisión Base o Prima Neta.
            Id: 2
        },
        {
            Nombre: '% Comision Derechos.',//%Comisión Base o Prima Neta.
            Id: 4
        },
    ];
    const [state, Setstate] = useState({
        Moneda: '',
        Comsion: '',
        OpcionComision: ''
    });

    const [item, SetItem] = useState({
        Id: 0,
        Importe: 0,
        Tipo: 0,
        Id_moneda: 0,
        Registros: [],
        Agentes: []
    });

    useEffect(() => {
        getConfigComisiones();
    }, [state.Moneda, state.Comsion]);

    function ChangeEdit(index, valor) {
        var itms = [...item.Registros];
        itms[index].IsEdit = valor;
        SetItem({ ...item, Registros: itms });
    }
    const FocusInput = (e) => {
        e.target.select();
    }



    function ChangeValueRecibo(index, field, value) {
        const elm = [...item.Registros];
        elm[index][field] = value;
        SetItem({
            ...item,
            Registros: elm
        });
    }

    function NuevoElemento() {
        if (state.Moneda == '') {
            toastr.error(`Seleccione una Moneda.`);
            return;
        }

        if (state.Comsion == '') {
            toastr.error(`Seleccione una Comisión.`);
            return;
        }


        var Items = [...item.Registros];
        Items.push({
            Desde: 0,
            Hasta: 0,
            Porcentaje: 0,
            Formula_Porcentaje: '',
            Formula_Importe: ''
        });
        SetItem({
            ...item,
            Registros: Items,
            Agentes: []
        });
    }

    async function deleteItem(Id, key) {
        console.log("ID",Id)
        var Itms = [...item.Registros];
        Itms.splice(key, 1);
        SetItem({
            ...item,
            Registros: Itms,
            Agentes: []
        });
        if (Id != undefined) {
            var params = {
                Id: Id,
            };
            const res = await CallApiPost(`${Url}catalogos/deleteConfig`, params, null);
            if (res.status != 200) {
                toastr.error(`Error, intente mas tarde. ${res.error}`);
            } else {
                getConfigComisiones();
            }
        }

    }

    async function getConfigComisiones() {
        if (state.Moneda != '' && state.Comsion != '') {
            ShowLoading();
            var params = {
                Id: Empresa,
                Id_SR: SubRamo,
                Id_M: state.Moneda,
                IdF: state.Comsion,
            };
            const res = await CallApiGet(`${Url}catalogos/getConfigComisiones`, params, null);
            if (res.status != 200) {
                toastr.error(`Error, intente mas tarde. ${res.error}`);
            } else {
                SetItem({
                    ...item,
                    Registros: res.success.Datos,
                    Agentes: []
                });
            }
            ShowLoading(false);
        }
    }

    async function Guardar() {
        ShowLoading();
        var params = {
            Id: Empresa,
            Id_SR: SubRamo,
            Id_M: state.Moneda,
            IdF: state.Comsion,
            Items: item.Registros,
            Agentes: item.Agentes,
            IdC: state.OpcionComision
        };
        const res = await CallApiPost(`${Url}catalogos/saveConfigComisiones`, params, null);
        if (res.status != 200) {
            toastr.error(`Error, intente mas tarde. ${res.error}`);
        } else {
            SetItem({
                ...item,
                Registros: res.success.Datos
            });
            toastr.success("Exíto");
            //SetItem(res.success.Datos);
        }
        ShowLoading(false);
    }

    async function getAgentes(IdConfig) {
        if (IdConfig == undefined) {
            return toastr.error(`Error, Guarde primero el elemento`);
        }
        ShowLoading();
        Setstate({
            ...state,
            OpcionComision: IdConfig
        });
        var params = {
            Id: Empresa,
            Id_SR: SubRamo,
            Id_M: state.Moneda,
            IdF: state.Comsion,
            IdC: IdConfig
        };
        const res = await CallApiGet(`${Url}catalogos/getAgentesComisiones`, params, null);
        if (res.status != 200) {
            toastr.error(`Error, intente mas tarde. ${res.error}`);
        } else {
            SetItem({
                ...item,
                Agentes: res.success.Datos
            });
            //toastr.success("Exíto");
        }
        ShowLoading(false);
    }

    function ChangeEditCheck(index, valor) {
        var itms = [...item.Agentes];
        if (itms[index].Id_config != null) {
            itms[index].Id_config = null;
        } else {
            itms[index].Id_config = valor;
        }
        //itms[index].Id_config = valor;
        SetItem({ ...item, Agentes: itms });
    }


    return (
        <div id="ModalComisiones" className="modal fade" role="dialog" style={{paddingTop:'40px'}}>
            <div className="modalLarge modal-dialog modal-lg ">
                <div className="modal-content">
                    <div className='modal-body'>
                        <div className='row'>
                            <div className='col-md-12'>
                                <button type="button" className="close" data-dismiss="modal">&times;</button>
                            </div>
                            <div className='col-md-12 labelSpecial'>
                                <h4 >Configuración de comisiones</h4>

                            </div>
                        </div>
                        <div className='row'>
                            <div className='col-md-2 labelSpecial'>
                                <p>Monedas</p>
                                <div className='row styleMonedas'>
                                    {Monedas && Monedas.map((item, key) => (
                                        <div key={key} className={state.Moneda == item.Id_moneda ? 'col-md-12 pt-3 pb-3 selectItemGAP' : 'col-md-12 pt-3 pb-3'} style={{ 'cursor': 'pointer' }} onClick={() => Setstate({ ...state, Moneda: item.Id_moneda })}>
                                            {item.Moneda}
                                        </div>
                                    ))}
                                </div>
                            </div>
                            <div className='col-md-2 labelSpecial'>
                                <p>Comisiones</p>
                                <div className='row'>
                                    {Comisiones && Comisiones.map((item, key) => (
                                        <div key={key} className={state.Comsion == item.Id ? 'col-md-12 pt-3 pb-3 selectItemGAP' : 'col-md-12 pt-3 pb-3'} style={{ 'cursor': 'pointer' }} onClick={() => Setstate({ ...state, Comsion: item.Id })}>
                                            {item.Nombre}
                                        </div>
                                    ))}
                                </div>
                            </div>
                            <div className='col-md-8'>
                                <div className='row'>
                                    <div className='col-md-6 labelSpecial'>
                                        <p>Configuración de comisiones</p>
                                    </div>
                                    <div className='col-md-6 text-right'>
                                        {/* <a onClick={() => console.log(item)}>test</a> */}
                                        <a className='btn btn-xs btn-primary mr-2' onClick={() => NuevoElemento()}><i className="fa fa-plus" aria-hidden="true"></i> Nuevo</a>
                                        <a className='btn btn-xs btn-primary' onClick={() => Guardar()}><i className="fa fa-floppy-o" aria-hidden="true"></i> Guardar</a>
                                    </div>
                                </div>
                                <div className='row'>
                                    <div className='col-md-12'>
                                        <table className="table table-condensed StylesTables " id="polizas">
                                            <thead style={{ fontSize: '12px' }}>
                                                <tr>
                                                    <th scope="col" style={{ width: '100px' }}>Desde</th>
                                                    <th scope="col" style={{ width: '100px' }}>Hasta</th>
                                                    <th scope="col" style={{ width: '100px' }}>Porcentaje</th>
                                                    <th scope="col" style={{ width: '100px' }}>Formula $</th>
                                                    <th scope="col" style={{ width: '100px' }}>Formula %</th>
                                                    <th scope="col" style={{ width: '100px' }}>Acciones</th>
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
                                                        <tr key={key} className={state.OpcionComision === item.Id ? 'selectItemGAP' : ''}>
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
                                                                    value={item.Porcentaje}
                                                                    onValueChange={(value, name) => ChangeValueRecibo(key, 'Porcentaje', value)}
                                                                    id='Cantidad'
                                                                    name='Cantidad'
                                                                    autoComplete='off'
                                                                />
                                                            </td>
                                                            <td>
                                                                <select name="Formula_Importe" id="Formula_Importe" className='form-control' value={item.Formula_Importe ? item.Formula_Importe : ''} onChange={(e) => ChangeValueRecibo(key, e.target.name, e.target.value)}>
                                                                    <option value="">Seleccione una Opción</option>
                                                                    {Comisiones && Comisiones.map((item, key) => (
                                                                        <option key={key} value={item.Id}>{item.Nombre}</option>
                                                                    ))}
                                                                </select>
                                                            </td>
                                                            <td>
                                                                <select name="Formula_Porcentaje" id="Formula_Porcentaje" className='form-control' value={item.Formula_Porcentaje ? item.Formula_Porcentaje : ''} onChange={(e) => ChangeValueRecibo(key, e.target.name, e.target.value)}>
                                                                    <option value="">Seleccione una Opción</option>
                                                                    {FComisiones && FComisiones.map((item, key) => (
                                                                        <option key={key} value={item.Id}>{item.Nombre}</option>
                                                                    ))}
                                                                </select>
                                                            </td>
                                                            <td style={{ display: 'inline-flex' }}>
                                                                <a className='btn btn-primary btn-sm' onClick={() => ChangeEdit(key, false)} data-toggle="tooltip" data-placement="bottom" title="Cancelar edicion"><i className="fa fa-times" aria-hidden="true"></i></a>
                                                            </td>
                                                        </tr> :
                                                        <tr key={key} className={state.OpcionComision === item.Id ? 'selectItemGAP' : ''}>
                                                            <td>{item.Desde}</td>
                                                            <td>{item.Hasta}</td>
                                                            <td>{item.Porcentaje}</td>
                                                            <td>{item.Formula_Importe == '' ? 'N/A' : GetName(item.Formula_Importe, Comisiones)}</td>
                                                            <td>{item.Formula_Porcentaje == '' ? 'N/A' : GetName(item.Formula_Porcentaje, FComisiones)}</td>
                                                            <td style={{ display: 'inline-flex' }}>
                                                                <a className='btn btn-primary btn-sm' onClick={() => ChangeEdit(key, true)} data-toggle="tooltip" data-placement="bottom" title="Editar"><i className="fa fa-pencil" aria-hidden="true"></i></a>
                                                                <a className='btn btn-primary btn-sm' onClick={() => deleteItem(item.Id) /* deleteItem(key) */} data-toggle="tooltip" data-placement="bottom" title="Eliminar"><i className="fa fa-trash-o" aria-hidden="true"></i></a>
                                                                <a className='btn btn-primary btn-sm' onClick={() => getAgentes(item.Id)} data-toggle="tooltip" data-placement="bottom" title="Asignar Agentes"><i className="fa fa-user" aria-hidden="true"></i></a>
                                                            </td>
                                                        </tr>)
                                                ))}
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div className='row'>
                            <div className='col-md-12 labelSpecial' style={{ marginTop: '15px' }}>
                                <p>Agentes</p>
                            </div>
                            <div className='col-md-12 table-wrapper'>
                                <table className="table table-condensed" id="polizas">
                                    <thead style={{ fontSize: '12px' }}>
                                        <tr>
                                            <th scope="col" style={{ width: '100px' }}>Agente</th>
                                            <th scope="col" style={{ width: '100px' }}>Clave Agente</th>
                                            {/* <th scope="col" style={{ width: '100px' }}>Tipo</th> */}
                                            <th scope="col" style={{ width: '100px' }}>Establecido</th>
                                            <th scope="col" style={{ width: '100px' }}></th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        {item.Agentes.length == 0 && (
                                            <tr>
                                                <td className='text-center' colSpan={19}>SIN REGISTROS</td>
                                            </tr>
                                        )}
                                        {item.Agentes && item.Agentes.map((item, key) => (
                                            <tr key={key}>
                                                <td>{item.Nombre}</td>
                                                <td>{item.Clave}</td>
                                                {/* <td>{item.TipoAgente}</td> */}
                                                <td>{item.Establecido}</td>
                                                <td className='text-center'>
                                                    <input type="checkbox" value={item.Id_config != null ? item.Id_config : ''} checked={item.Id_config != null ? true : false} onChange={() => ChangeEditCheck(key, state.OpcionComision)} />
                                                </td>
                                            </tr>
                                        ))}
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    )
})
export default Comisiones;