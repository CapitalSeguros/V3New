import React, { useState, useEffect, useRef } from 'react';
import Select from "react-select";
import { CallApiGet, CallApiPost } from '../../Helpers/Calls.js';
import { mapitems, displayitem, displayitemText, mapitemsHijos, colourStyles } from '../../Helpers/FGeneral.js';


export default function Agentes(props) {
    const { Agentes, Catalogos, UrlServicio, UpdateAgentes, SetEmpresa, empresa } = props;
    const path = window.jQuery("#base_url").attr("data-base-url");
    const Id = window.jQuery("#idRegistro").val();

    const [agente, SetAgente] = useState({});
    const [isEditA, SetEditA] = useState(false);

    function ChangeValue(field, value) {
        SetAgente({
            ...agente,
            [field]: value
        })
        /* const elm = {...agente};
        elm[field] = value;
        SetAgente(elm); */
    }

    function EditElement(value) {
        SetAgente(value);
        SetEditA(true);
    }

    function CancelEdit() {
        SetEditA(false);
        SetAgente({});
    }

    async function SaveElement() {
        var dta = {
            "data": agente,
            "Id": Id
        };

        const res = await CallApiPost(`${UrlServicio}catalogos/guardarAgente`, dta, null);
        if (res.status != 200) {
            if(res.error && res.error.Mensaje != "")
                toastr.error(`Error. ${res.error.Mensaje}`);
            else
                toastr.error(`Error. Ocurrió un error al guardar el registro.`);
            //toastr.error(`Error, intente mas tarde. ${res.error}`);
        } else {
            toastr.success("Exíto");
            SetEditA(false);
            SetAgente({});
            //UpdateAgentes(res.success.Datos.Agentes);

            let _empresa = {...empresa};
            _empresa.Agentes = res.success.Datos.Agentes;
            SetEmpresa(_empresa);

            /* SetEmpresa({
                ...empresa,
                Agentes: res.success.Datos.Agentes
            }); */
        }
    }

    function NewAgente() {
        SetEditA(true);
        SetAgente({});
    }

    function mapitemsA(respuesta) {
        const _ps = respuesta.map(i => {
            var obj = {};
            obj = { Id: parseInt(i.IDAgente), Nombre: i.AgenteNombre };
            return obj;
        });
        return _ps;
    }

    return (
        <div className="bhoechie-tab-content">
            <div className='row'>
                <div className='col-md-12 labelSpecial'>
                    <h4>Lista de agentes relacionados</h4>
                    <div className='btn_aling_form'>
                        <a className='btn btn-primary btn-s' data-toggle="tooltip" data-placement="bottom" title="Nuevo Agente" onClick={() => NewAgente()}><i className="fa fa-plus" aria-hidden="true"></i></a>
                        {isEditA && (
                            <a className="btn btn-primary btn-s" type="submit" data-toggle="tooltip" data-placement="bottom" title="Cancelar" onClick={() => CancelEdit()}><i className="fa fa-times" aria-hidden="true"></i></a>
                        )}
                        <a className="btn btn-primary btn-s" type="submit" data-toggle="tooltip" data-placement="bottom" title="Guardar Agente" onClick={() => SaveElement()}><i className="fa fa-floppy-o" aria-hidden="true"></i></a>
                    </div>
                    <hr />
                </div>
            </div>
            <div className='row' style={!isEditA ? { display: 'none' } : {}}>
                <div className='col-md-12'>
                    <div className='row'>
                        <div className='col-md-6'>
                            <div className='form-group'>
                                <label>Razon social </label>
                                <input type="text" name='AgenteNombre' id='AgenteNombre' className='form-control' value={agente.AgenteNombre ? agente.AgenteNombre : ''} onChange={(e) => ChangeValue(e.target.name, e.target.value)} />
                            </div>
                        </div>
                        <div className='col-md-3'>
                            <div className='form-group'>
                                <label>Tipo de entidad </label>
                                <Select
                                    placeholder="Selecione"
                                    id="IdTipoEntidad"
                                    name="IdTipoEntidad"
                                    styles={colourStyles}
                                    onChange={v => { ChangeValue("IdTipoEntidad", v.value) }}
                                    //onBlur={handleBlur}
                                    value={displayitemText(agente.IdTipoEntidad, Catalogos.TipoEntidad)}
                                    options={mapitems(Catalogos.TipoEntidad ? Catalogos.TipoEntidad : [], '')}
                                    noOptionsMessage={() => "Sin opciones"}
                                    title={"Dirección"}
                                />
                            </div>
                        </div>
                        <div className='col-md-3'>
                            <div className='form-group'>
                                <label>Clave Agente </label>
                                <input type="text" name='CAgente' id='CAgente' className='form-control' value={agente.CAgente ? agente.CAgente : ''} onChange={(e) => ChangeValue(e.target.name, e.target.value)} />
                            </div>
                        </div>
                    </div>
                    <div className='row'>
                        <div className='col-md-3'>
                            <div className='form-group'>
                                <label>Alias </label>
                                <input type="text" name='Abreviacion' id='Abreviacion' className='form-control' value={agente.Abreviacion ? agente.Abreviacion : ''} onChange={(e) => ChangeValue(e.target.name, e.target.value)} />
                            </div>
                        </div>
                        <div className='col-md-3'>
                            <div className='form-group'>
                                <label>Cédula </label>
                                <input type="text" name='Cedula' id='Cedula' className='form-control' value={agente.Cedula ? agente.Cedula : ''} onChange={(e) => ChangeValue(e.target.name, e.target.value)} />
                            </div>
                        </div>
                        <div className='col-md-3'>
                            <div className='form-group'>
                                <label>Tipo cédula </label>
                                <Select
                                    placeholder="Selecione"
                                    id="IdTipoCedula"
                                    name="IdTipoCedula"
                                    styles={colourStyles}
                                    onChange={v => { ChangeValue("IdTipoCedula", v.value) }}
                                    //onBlur={handleBlur}
                                    value={displayitem(agente.IdTipoCedula, Catalogos.TipoCompania)}
                                    options={mapitems(Catalogos.TipoCompania ? Catalogos.TipoCompania : [], '')}
                                    noOptionsMessage={() => "Sin opciones"}
                                    title={"Dirección"}
                                />
                            </div>
                        </div>
                        <div className='col-md-3'>
                            <div className='form-group'>
                                <label>Venc. Cédula agente </label>
                                <input type="date" name='VenCedula' id='VenCedula' className='form-control' value={agente.VenCedula ? agente.VenCedula : ''} onChange={(e) => ChangeValue(e.target.name, e.target.value)} />
                            </div>
                        </div>
                    </div>
                    <div className='row'>
                        <div className='col-md-4'>
                            <div className='form-group'>
                                <label>Tipo de Agente</label>
                                <Select
                                    placeholder="Selecione"
                                    id="IdTipoAgente"
                                    name="IdTipoAgente"
                                    styles={colourStyles}
                                    onChange={v => { ChangeValue("IdTipoAgente", v.value) }}
                                    //onBlur={handleBlur}
                                    value={displayitem(agente.IdTipoAgente, Catalogos.TipoAgente)}
                                    options={mapitems(Catalogos.TipoAgente ? Catalogos.TipoAgente : [], '')}
                                    noOptionsMessage={() => "Sin opciones"}
                                    title={"Dirección"}
                                />
                            </div>
                        </div>
                        <div className='col-md-4'>
                            <div className='form-group'>
                                <label>Poliza R.C.</label>
                                <input type="text" name='PolizaRC' id='PolizaRC' className='form-control' value={agente.PolizaRC ? agente.PolizaRC : ''} onChange={(e) => ChangeValue(e.target.name, e.target.value)} />
                            </div>
                        </div>
                        <div className='col-md-4'>
                            <div className='form-group'>
                                <label>Vencimiento R.C.</label>
                                <input type="date" name='VenCedula' id='VenCedula' className='form-control' value={agente.VenCedula ? agente.VenCedula : ''} onChange={(e) => ChangeValue(e.target.name, e.target.value)} />
                            </div>
                        </div>
                    </div>
                    <div className='row'>
                        <div className='col-md-8'>
                            <div className='form-group'>
                                <label>Depende</label>
                                <Select
                                    placeholder="Selecione"
                                    id="Depende"
                                    name="Depende"
                                    styles={colourStyles}
                                    onChange={v => { ChangeValue("Depende", v.value) }}
                                    //onBlur={handleBlur}
                                    value={displayitem(agente.Depende, mapitemsA(Agentes))}
                                    options={mapitems(Agentes ? mapitemsA(Agentes) : [], '')}
                                    noOptionsMessage={() => "Sin opciones"}
                                    title={"Dirección"}
                                />
                            </div>
                        </div>
                        <div className='col-md-4'>
                            <div className='form-group'>
                                <label>Estatus</label>
                                <Select
                                    placeholder="Selecione"
                                    id="IdEstatus"
                                    name="IdEstatus"
                                    styles={colourStyles}
                                    onChange={v => { ChangeValue("IdEstatus", v.value) }}
                                    //onBlur={handleBlur}
                                    value={displayitem(agente.IdEstatus, Catalogos.Estatus)}
                                    options={mapitems(Catalogos.Estatus ? Catalogos.Estatus : [], '')}
                                    noOptionsMessage={() => "Sin opciones"}
                                    title={"Dirección"}
                                />
                            </div>
                        </div>
                    </div>
                    <div className='row'>
                        <div className='col-md-4'>
                            <div className='form-group'>
                                <label>Centro de costo</label>
                                <input type="text" name='CentroCostos' id='CentroCostos' className='form-control' value={agente.CentroCostos ? agente.CentroCostos : ''} onChange={(e) => ChangeValue(e.target.name, e.target.value)} />
                            </div>
                        </div>
                        <div className='col-md-4'>
                            <div className='form-group'>
                                <label>Cartera</label>
                                <Select
                                    placeholder="Selecione"
                                    id="IdCartera"
                                    name="IdCartera"
                                    styles={colourStyles}
                                    onChange={v => { ChangeValue("TCompania", v.value) }}
                                    //onBlur={handleBlur}
                                    value={displayitem(agente.IdCartera, Catalogos.Cartera)}
                                    options={mapitems(Catalogos.Cartera ? Catalogos.Cartera : [], '')}
                                    noOptionsMessage={() => "Sin opciones"}
                                    title={"Dirección"}
                                />
                            </div>
                        </div>
                        <div className='col-md-4'>
                            <div className='form-group'>
                                <label>Sub Cartera</label>
                                <Select
                                    placeholder="Selecione"
                                    id="IdSubCartera"
                                    name="IdSubCartera"
                                    styles={colourStyles}
                                    onChange={v => { ChangeValue("IdSubCartera", v.value) }}
                                    //onBlur={handleBlur}
                                    value={displayitem(agente.IdSubCartera, Catalogos.SubCartera)}
                                    options={mapitems(Catalogos.SubCartera ? Catalogos.SubCartera : [], '')}
                                    noOptionsMessage={() => "Sin opciones"}
                                    title={"Dirección"}
                                />
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div className='row' style={isEditA ? { display: 'none' } : {}}>
                <div className='col-md-12  table-wrapper' style={{ height: '400px', marginBottom: '10px' }}>
                    <table className="table table-condensed" id="incisos">
                        <thead style={{ fontSize: '12px' }}>
                            <tr>
                                <th>Clave Agente</th>
                                <th>Nombre o razón social</th>
                                <th>Depende</th>
                                <th></th>
                            </tr>
                        </thead>
                        <tbody>
                            {empresa.Agentes.length == 0 && (
                                <tr>
                                    <td className='text-center' colSpan={8}>NO SE HAN AGREGADO AGENTES</td>
                                </tr>
                            )}
                            {empresa.Agentes && empresa.Agentes.map((item, key) => (
                                <tr key={key}>
                                    <td>{item.CAgente}</td>
                                    <td>{item.AgenteNombre}</td>
                                    <td>{item.Depende == null ? 'N/A' : `[${item.DependeClave}] ${item.DependeNombre}`}</td>
                                    <td>
                                        <a className='btn btn-primary btn-sm' onClick={() => EditElement(item)} data-toggle="tooltip" data-placement="bottom" title="Editar Flotilla" ><i className="fa fa-pencil" aria-hidden="true"></i></a>
                                    </td>
                                </tr>
                            ))}
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

    )
}
