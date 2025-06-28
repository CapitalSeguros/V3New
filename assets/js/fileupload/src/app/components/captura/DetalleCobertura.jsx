import React, { useState } from 'react';
import Select from "react-select";
import { FocusInput, Sexo, colourStyles } from '../../Helpers/FGeneral';
import CurrencyInputField from 'react-currency-input-field';
import { CallApiPost } from '../../Helpers/Calls';

export default function DetalleCobertura(props) {
    const { values, errors, state, handleKeyDown, UrlServicio, handleBlur, setFieldValue, displayitem, mapitems, Listcoberturas, SetordenTrabajo, OT, Planes } = props;
    const [Item, SetItem] = useState({
        Documento: values.Documento,
        IDDocto: values.IDDocto,
        Nombre: ''
    });
    function OpenCobertura() {
        var SelectedItem = displayitem(values.IDCobertura, state.InitialData.Coberturas);
        SetItem({
            Documento: values.Documento,
            IDDocto: values.IDDocto,
            Nombre: SelectedItem[0].label ? SelectedItem[0].label : ''
        });
        $('#ModalCobrtura').modal('show');
    }
    async function Add() {
        var dta = {
            Id: values.IDDocto,
            Documento: values.Documento,
            data: Item
        }
        const res = await CallApiPost(`${UrlServicio}capture/addCobertura`, dta, null);
        if (res.status != 200) {
            return toastr.error(`Error ${res.error.Mensaje}`);
        } else {
            SetordenTrabajo({ ...OT, Coberturas: res.success.Datos });
            $('#ModalCobrtura').modal('hide');
            SetItem({
                Documento: values.Documento,
                IDDocto: values.IDDocto,
                Nombre: ''
            });
            toastr.success("Exíto");
        }
    }

    function handleChange(e, Campo = '', isArray = false) {
        if (Campo != '') {
            SetItem({ ...Item, [`${Campo}`]: e });
        }
        else
            SetItem({ ...Item, [e.target.name]: e.target.value });
    }


    function FormatItem(value) {
        var _return = parseFloat(value);
        return (_return).toLocaleString('es-MX', { style: 'currency', currency: 'MXN' })
    }

    function EditElement(item) {
        SetItem(item);
        $('#ModalCobrtura').modal('show');
    }

    async function Delete(Id) {
        var dta = {
            Id: Id,
            IDDocto: values.IDDocto,
            Documento: values.Documento
        }
        const res = await CallApiPost(`${UrlServicio}capture/deleteCobertura`, dta, null);
        if (res.status != 200) {
            return toastr.error(`Error ${res.error.Mensaje}`);
        } else {
            SetordenTrabajo({ ...OT, Coberturas: res.success.Datos });
            toastr.success("Exíto");
        }
    }


    return (
        <>
            <div className="tab-pane fade" id="detalle-cobertura" role="tabpanel" aria-labelledby="detalle-cobertura-tab">
                <div className='row'>
                    <div className='col-md-6'>
                        <div className='form-group'>
                            <label htmlFor="txMotivo">Plan</label>
                            <Select
                                placeholder="Selecione"
                                id="IDPlan"
                                name="IDPlan"
                                styles={colourStyles}
                                onChange={v => { setFieldValue("IDPlan", v.value) }}
                                onBlur={handleBlur}
                                value={displayitem(values.IDPlan, Planes)}
                                options={mapitems(Planes ? Planes : [], '')}
                                noOptionsMessage={() => "Sin opciones"}
                            />
                        </div>
                    </div>
                    <div className='col-md-5'>
                        <div className='form-group'>
                            <label htmlFor="txMotivo">Cobertura</label>
                            <Select
                                placeholder="Selecione"
                                id="IDCobertura"
                                name="IDCobertura"
                                styles={colourStyles}
                                onChange={v => { setFieldValue("IDCobertura", v.value) }}
                                onBlur={handleBlur}
                                value={displayitem(values.IDCobertura, state.InitialData.Coberturas)}
                                options={mapitems(state.InitialData.Coberturas ? state.InitialData.Coberturas : [], '')}
                                noOptionsMessage={() => "Sin opciones"}
                            />
                        </div>
                    </div>
                    <div className='col-md-1'>
                        <a className='btn btn-sm btn-primary mt-4' onClick={() => OpenCobertura()}> <i className="fa fa-plus" aria-hidden="true"></i></a>
                    </div>
                </div>
                <div className='row'>
                    <div className='col-md-12 pt-5'>
                        <div className='table-responsive'>
                            <table className="table table-condensed" id="cobeerturas">
                                <thead style={{ fontSize: '12px' }}>
                                    <tr>
                                        <th scope="col" style={{ width: '100px' }}>Cobertura</th>
                                        <th scope="col" style={{ width: '100px' }}>Suma Asegurada</th>
                                        <th scope="col" style={{ width: '100px' }}>Deducible Local</th>
                                        <th scope="col" style={{ width: '100px' }}>Deducible Extrajero</th>
                                        <th scope="col" style={{ width: '100px' }}>Coaseguro Local</th>
                                        <th scope="col" style={{ width: '100px' }}></th>
                                    </tr>
                                </thead>
                                <tbody>
                                    {Listcoberturas && Listcoberturas.length == 0 && (
                                        <tr>
                                            <td className='text-center' colSpan={6}>NO SE HAN REGISTRADO</td>
                                        </tr>
                                    )}
                                    {Listcoberturas && Listcoberturas.map((item, key) => (
                                        <tr key={key}>
                                            <td>{item.Nombre}</td>
                                            <td>{FormatItem(item.SumaAseg ? item.SumaAseg : 0)}</td>
                                            <td>{FormatItem(item.DeducibleL ? item.DeducibleL : 0)}</td>
                                            <td>{FormatItem(item.DeducibleE ? item.DeducibleE : 0)}</td>
                                            <td>{FormatItem(item.CoaseguroL ? item.CoaseguroL : 0)}</td>
                                            <td>
                                                <a className='btn btn-primary btn-sm' onClick={() => EditElement(item)} data-toggle="tooltip" data-placement="bottom" title="Editar" ><i className="fa fa-pencil" aria-hidden="true"></i></a>
                                                <a className='btn btn-primary btn-sm' onClick={() => Delete(item.IDTemp)} data-toggle="tooltip" data-placement="bottom" title="Eliminar" ><i className="fa fa-trash" aria-hidden="true"></i></a>
                                            </td>
                                        </tr>
                                    ))}
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
            <div id="ModalCobrtura" className="modal fade" role="dialog">
                <div className="modal-dialog modal-lg">
                    <div className="modal-content">
                        <div className='modal-body'>
                            <div className='row'>
                                <div className='col-md-10 labelSpecial'>
                                    <h4>Cobertura</h4>
                                </div>
                                <div className='col-md-2'>
                                    <button type="button" className="close" data-dismiss="modal">&times;</button>
                                </div>

                            </div>
                            <div className='row'>
                                <div className='col-md-12'>
                                    <div className='form-group'>
                                        <label>Cobertura</label>
                                        <input disabled={true} type="text" className='form-control' id='Nombre' name='Nombre' onChange={(e) => handleChange(e, '')} value={Item.Nombre ? Item.Nombre : ''} />
                                    </div>
                                </div>
                                <div className='col-md-12'>
                                    <div className='form-group'>
                                        <label>Suma Aseegurada</label>
                                        <CurrencyInputField
                                            className='form-control input-sm numeric'
                                            //onBlur={() => { ReloadPrices(null) /* handleBlur *//* , ReloadPrices(values) */ }}
                                            min={0}
                                            maxLength={10}
                                            //prefix='$'
                                            decimalSeparator='.'
                                            groupSeparator=','
                                            onFocus={FocusInput}
                                            allowNegativeValue={false}
                                            value={Item.SumaAseg ? Item.SumaAseg : '0'}
                                            onValueChange={(value, name) => { handleChange(value, 'SumaAseg') }}
                                            id='SumaAseg'
                                            name='SumaAseg'
                                            autoComplete='off'
                                        />
                                    </div>
                                </div>
                                <div className='col-md-12'>
                                    <div className='form-group'>
                                        <label>Deducible Local</label>
                                        <CurrencyInputField
                                            className='form-control input-sm numeric'
                                            //onBlur={() => { ReloadPrices(null) /* handleBlur *//* , ReloadPrices(Item) */ }}
                                            min={0}
                                            maxLength={10}
                                            //prefix='$'
                                            decimalSeparator='.'
                                            groupSeparator=','
                                            onFocus={FocusInput}
                                            allowNegativeValue={false}
                                            value={Item.DeducibleL ? Item.DeducibleL : '0'}
                                            onValueChange={(value, name) => { handleChange(value, 'DeducibleL') }}
                                            id='DeducibleL'
                                            name='DeducibleL'
                                            autoComplete='off'
                                        />
                                    </div>
                                </div>
                                <div className='col-md-12'>
                                    <div className='form-group'>
                                        <label>Deducible Extranjero</label>
                                        <CurrencyInputField
                                            className='form-control input-sm numeric'
                                            //onBlur={() => { ReloadPrices(null) /* handleBlur *//* , ReloadPrices(Item) */ }}
                                            min={0}
                                            maxLength={10}
                                            //prefix='$'
                                            decimalSeparator='.'
                                            groupSeparator=','
                                            onFocus={FocusInput}
                                            allowNegativeValue={false}
                                            value={Item.DeducibleE ? Item.DeducibleE : '0'}
                                            onValueChange={(value, name) => { handleChange(value, 'DeducibleE') }}
                                            id='DeducibleE'
                                            name='DeducibleE'
                                            autoComplete='off'
                                        />
                                    </div>
                                </div>
                                <div className='col-md-12'>
                                    <div className='form-group'>
                                        <label>Coaseguro Local</label>
                                        <CurrencyInputField
                                            className='form-control input-sm numeric'
                                            //onBlur={() => { ReloadPrices(null) /* handleBlur *//* , ReloadPrices(Item) */ }}
                                            min={0}
                                            maxLength={10}
                                            //prefix='$'
                                            decimalSeparator='.'
                                            groupSeparator=','
                                            onFocus={FocusInput}
                                            allowNegativeValue={false}
                                            value={Item.CoaseguroL ? Item.CoaseguroL : '0'}
                                            onValueChange={(value, name) => { handleChange(value, 'CoaseguroL') }}
                                            id='CoaseguroL'
                                            name='CoaseguroL'
                                            autoComplete='off'
                                        />
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div className='modal-footer'>
                            <button type="button" className="btn btn-secondary" data-dismiss="modal">Cerrar</button>
                            <button type="button" className="btn btn-primary" onClick={() => Add()}>Guardar</button>
                        </div>
                    </div>
                </div>
            </div>
        </>
    )
}
