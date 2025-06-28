import React, { useState, useEffect, useRef, forwardRef, useImperativeHandle } from 'react';
import { CallApiGet, CallApiPost } from '../../../Helpers/Calls';
import CurrencyInputField from 'react-currency-input-field';
import { ShowLoading } from '../../../Helpers/FGeneral';
const Productos = forwardRef((props, ref) => {
    const { Url, SubRamo, Empresa, Monedas } = props;
    useImperativeHandle(ref, () => {
        return {
            Reload: Reload
        }
    });


    async function InitialLoad() {
        var params = {
            Compania: Empresa,
            SubRamo: SubRamo,
        }
        const res = await CallApiGet(`${Url}catalogos/getInitialFianzasProductos`, params, null);
        if (res.status != 200) {
            toastr.error(`Error, intente mas tarde. ${res.error}`);
        } else {
            Setstate({ ...state, Fianzas: res.success.Datos.TipoFianzas });
        }
    }

    function Reload() {

    }

    const [state, Setstate] = useState({
        Fianzas: [],
        Productos: [],
        Comisiones: []
    });
    const [config, SetConfig] = useState({
        TipoFianza: '',
        Id_fianza_config: '',
        ComPro: '',
        IdConf:''
    })


    useEffect(() => {
        InitialLoad();
    }, []);

    const FocusInput = (e) => {
        e.target.select();
    }

    function ChangeCheck(array, index, option, id = null) {
        array[index].Selected = !array[index].Selected;

        if (option == "Productos") {
            Setstate({ ...state, Productos: array });
        }
        if (option == "Fianzas") {
            //SetConfig({ ...config, TipoFianza: array[index].TipoFianza });
            Setstate({ ...state, Fianzas: array });
        }
        if (option == "Comisiones") {
            Setstate({ ...state, Comisiones: array });
        }
    }

    function ChangeValueRecibo(index, field, value, tipo) {
        if (tipo == 'Producto') {
            const elm = [...state.Productos];
            elm[index][field] = value;
            Setstate({
                ...state,
                Productos: elm,
            });
        } else {
            const elm = [...state.Comisiones];
            elm[index][field] = value;
            Setstate({
                ...state,
                Comisiones: elm,
            });
        }
    }

    async function SaveAll() {
        ShowLoading();
        var params = {
            Compania: Empresa,
            SubRamo: SubRamo,
            Fianzas: state.Fianzas,
            Productos: state.Productos,
            Comisiones: state.Comisiones,
            TFianza: config.TipoFianza,
            Id_fianza_config: config.Id_fianza_config,
            IdProducto: config.ComPro,
            IdConfig:config.IdConf
        }
        const res = await CallApiPost(`${Url}catalogos/saveFianzasProductos`, params, null);
        if (res.status != 200) {
            toastr.error(`Error, intente mas tarde. ${res.error}`);
        } else {
            Setstate({
                ...state,
                Fianzas: res.success.Datos.TipoFianzas,
                Productos: res.success.Datos.Productos,
                Comisiones: res.success.Datos.Comisiones
            });
        }
        ShowLoading(false);
    }

    async function GetProductos(TipoFianza) {
        ShowLoading();
        SetConfig({ ...config, TipoFianza: TipoFianza });
        var params = {
            TipoFianza: TipoFianza,
            Compania: Empresa
        }
        const res = await CallApiGet(`${Url}catalogos/getInitialProductos`, params, null);
        if (res.status != 200) {
            toastr.error(`Error, intente mas tarde. ${res.error}`);
        } else {
            Setstate({ ...state, Productos: res.success.Datos.Productos, Comisiones: [] });
        }
        ShowLoading(false);
    }

    async function GetProdCom(Conf, Id) {
        ShowLoading();
        SetConfig({ ...config, ComPro: Conf, IdConf: Id });
        var params = {
            Id_config_producto: Conf,
            Id: Id,
            Compania: Empresa
        }
        const res = await CallApiGet(`${Url}catalogos/getInitialProdComisiones`, params, null);
        if (res.status != 200) {
            toastr.error(`Error, intente mas tarde. ${res.error}`);
        } else {
            Setstate({ ...state, Comisiones: res.success.Datos.Comisiones });
        }
        ShowLoading(false);
    }




    return (
        <div id="ModalProductos" className="modal fade" role="dialog">
            <div className="modalLarge modal-dialog modal-lg ">
                <div className="modal-content">
                    <div className='modal-body'>
                        <div className='row'>
                            <div className='col-md-12'>
                                <button type="button" className="close" data-dismiss="modal">&times;</button>
                            </div>
                            <div className='col-md-12 labelSpecial'>
                                <h4 >Configuración de productos</h4>
                            </div>
                        </div>
                        <div className='row'>
                            <div className='col-md-4 labelSpecial'>
                                <div className='row'>
                                    <div className='col-md-12 labelSpecial'>
                                        <p>Tipo de Fianzas</p>
                                    </div>
                                </div>
                                <div className='row'>
                                    <div className='col-md-12 table-wrapper'>
                                        <table className="table" id="polizas">
                                            <thead style={{ fontSize: '12px' }}>
                                                <tr>
                                                    <th scope="col" style={{ width: '100px' }}>Tipo</th>
                                                    <th scope="col" style={{ width: '100px', textAlign: 'center' }}>Acciones</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                {state.Fianzas.length == 0 && (
                                                    <tr>
                                                        <td className='text-center' colSpan={19}>SIN REGISTROS</td>
                                                    </tr>
                                                )}
                                                {state.Fianzas && state.Fianzas.map((item, key) => (
                                                    <tr key={key} /* style={IdFM === item.Id_formapago ? { backgroundColor: '#5A55A3', color: 'white' } : { backgroundColor: 'unset' }} */>
                                                        <td> {item.Nombre}</td>
                                                        <td className='text-center'>
                                                            <div className='row'>
                                                                <div className='col-md-6'>
                                                                    <input onClick={() => ChangeCheck(state.Fianzas, key, 'Fianzas')} type="checkbox" checked={item.Selected ? true : false} name={item.FormaPago} id={item.FormaPago} value={item.Selected ? item.Selected : ''} onChange={() => ''} />
                                                                </div>
                                                                <div className='col-md-6'>
                                                                    {item.Saved && (
                                                                        <a className='btn btn-xs btn-primary' onClick={() => GetProductos(item.IDF)}>
                                                                            <i className="fa fa-cog" aria-hidden="true"></i>
                                                                        </a>
                                                                    )}
                                                                </div>
                                                            </div>
                                                        </td>
                                                    </tr>
                                                ))}
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                            <div className='col-md-8 labelSpecial'>
                                <div className='row'>
                                    <div className='col-md-6 labelSpecial'>
                                        <p>Productos</p>
                                        {/* <a className='btn btn-primary' onClick={() => console.log('data', state)}></a>
                                        <a className='btn btn-primary' onClick={() => console.log('data2', config)}></a> */}
                                    </div>
                                    <div className='col-md-6 text-right'>
                                        {/*<a className='btn btn-xs btn-primary mr-2' onClick={() => 'NuevoElemento()'}><i className="fa fa-plus" aria-hidden="true"></i> Nuevo</a> */}
                                        <a className='btn btn-xs btn-primary' onClick={() => SaveAll()}><i className="fa fa-floppy-o" aria-hidden="true"></i> Guardar</a>
                                    </div>
                                </div>
                                <div className='row'>
                                    <div className='col-md-12 table-wrapper'>
                                        <table className="table" id="polizas">
                                            <thead style={{ fontSize: '12px' }}>
                                                <tr>
                                                    <th scope="col" style={{ width: '100px' }}>Tipo</th>
                                                    <th scope="col" style={{ width: '100px' }}>Tarifa</th>
                                                    <th scope="col" style={{ width: '100px', textAlign: 'center' }}>Acciones</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                {state.Productos.length == 0 && (
                                                    <tr>
                                                        <td className='text-center' colSpan={19}>SIN REGISTROS</td>
                                                    </tr>
                                                )}
                                                {state.Productos && state.Productos.map((item, key) => (
                                                    <tr key={key} /* style={IdFM === item.Id_formapago ? { backgroundColor: '#5A55A3', color: 'white' } : { backgroundColor: 'unset' }} */>
                                                        <td> {item.Nombre}</td>
                                                        <td>
                                                            <CurrencyInputField
                                                                className='form-control input-sm numeric'
                                                                style={{ width: '80px' }}
                                                                //onBlur={handleBlur}
                                                                disabled={!item.Selected}
                                                                min={0}
                                                                maxLength={10}
                                                                prefix=''
                                                                decimalSeparator='.'
                                                                groupSeparator=','
                                                                onFocus={FocusInput}
                                                                allowNegativeValue={false}
                                                                value={item.tarifa}
                                                                onValueChange={(value, name) => ChangeValueRecibo(key, 'tarifa', value, 'Producto')}
                                                                id='tarifa'
                                                                name='tarifa'
                                                                autoComplete='off'
                                                            />
                                                        </td>
                                                        <td className='text-center'>
                                                            <div className='row'>
                                                                <div className='col-md-6'>
                                                                    <input onClick={() => ChangeCheck(state.Productos, key, 'Productos')} type="checkbox" checked={item.Selected ? true : false} name={item.FormaPago} id={item.FormaPago} value={item.Selected ? item.Selected : ''} onChange={() => ''} />
                                                                </div>
                                                                <div className='col-md-6'>
                                                                    {item.Saved && (
                                                                        <a className='btn btn-xs btn-primary' onClick={() => GetProdCom(item.IdProducto, item.Id)}>
                                                                            <i className="fa fa-cog" aria-hidden="true"></i>
                                                                        </a>
                                                                    )}
                                                                </div>
                                                            </div>
                                                        </td>
                                                    </tr>
                                                ))}
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div className='row'>
                            <div className='col-md-12 labelSpecial' style={{ marginTop: '15px' }}>
                                <p>Configuracion de comisiones por productos</p>
                            </div>
                            <div className='col-md-12 table-wrapper'>
                                <table className="table table-condensed" id="polizas">
                                    <thead style={{ fontSize: '12px' }}>
                                        <tr>
                                            <th scope="col" style={{ width: '100px' }}>TIpo de comision</th>
                                            <th scope="col" style={{ width: '100px' }}>Porcentaje</th>
                                            <th scope="col" style={{ width: '100px' }}>Acciones</th>
                                            {/* <th scope="col" style={{ width: '100px' }}>Establecido</th> */}
                                        </tr>
                                    </thead>
                                    <tbody>
                                        {state.Comisiones.length == 0 && (
                                            <tr>
                                                <td className='text-center' colSpan={19}>SIN REGISTROS</td>
                                            </tr>
                                        )}
                                        {state.Comisiones && state.Comisiones.map((item, key) => (
                                            <tr key={key}>
                                                <td>{item.Nombre}</td>
                                                <td>
                                                    <div>
                                                        <CurrencyInputField
                                                            className='form-control input-sm numeric'
                                                            style={{ width: '80px' }}
                                                            //onBlur={handleBlur}
                                                            disabled={!item.Selected}
                                                            min={0}
                                                            maxLength={10}
                                                            prefix=''
                                                            decimalSeparator='.'
                                                            groupSeparator=','
                                                            onFocus={FocusInput}
                                                            allowNegativeValue={false}
                                                            value={item.Porcentaje}
                                                            onValueChange={(value, name) => ChangeValueRecibo(key, 'Porcentaje', value, 'Comision')}
                                                            id='Porcentaje'
                                                            name='Porcentaje'
                                                            autoComplete='off'
                                                        />
                                                    </div>
                                                </td>
                                                <td className='text-center'>
                                                    <input onClick={() => ChangeCheck(state.Comisiones, key, 'Comisiones')} type="checkbox" checked={item.Selected ? true : false} value={item.Selected ? item.Selected : ''} onChange={() => ''} />
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
export default Productos;