import React, { useState } from 'react';
import Select from "react-select";
import axios from "axios";
import CurrencyInputField from 'react-currency-input-field';

export default function ModalFlotilla(props) {
    const { state, handleBlur, displayitem, mapitems, UrlServicio, values, Flotillas } = props;
    const [opc, SetOpc] = useState(0);
    const [listaInc, SetListaInc] = useState([...Flotillas]);
    const [inciso, SetInciso] = useState({
        NumInc: '',
        NumEco: '',
        Certificado: '',
        Conductor: '',
        Direccion: '',
        Marca: '',
        SubMarca: '',
        Tipo: '',
        Transmision: '',
        Puertas: '',
        Modelo: '',
        Clave: '',
        Placas: '',
        Serie: '',
        Motor: '',
        Repuve: '',
        Cochera: '',
        EstadoCircula: '',
        Color: '',
        Ocupantes: '',
        Servicio: '',
        UsoVehiculo: '',
        Inspeccion: '',
        TipoCarga: '',
        Tonelaje: '',
        CiaLocalizacion: '',
        SerieLocalizador: '',
        EqEsp: '',
        EqEspSAseg: '',
        Adap: '',
        AdapSAseg: '',
        RDescripcion: '',
        RMarca: '',
        RTipo: '',
        RModelo: '',
        RClave: '',
        RPlacas: '',
        RSerie: '',
        RSumaAsegurada: '',
        PrimaNeta: '',
        Descuento: '',
        PorDesc: '',
        Recargos: '',
        PorRecargos: '',
        Derechos: '',
        SubTotal: '',
        IVA: '',
        PorIVA: '',
        Ajuste: '',
        PrimaTotal: '',
        DoctoAlta: '',
        FAlta: '',
        DoctoBaja: '',
        FBaja: '',
        Referencia: '',
        Status: '',
        IDTemp: '',

    });
    const colourStyles = {
        control: styles => ({
            ...styles,
            backgroundColor: "white",
            borderRadius: "0px",
            minHeight: "30px",
            maxHeight: 30,
            color: '#472380 !important'
        })
    };

    function changeOpc(opc) {
        SetOpc(opc);
        setTimeout(function () {
            $('#ModalFlotilla').modal('handleUpdate');
        }, 80);
    }

    function handleChange(e, Campo = '') {
        console.log(`${e} | ${Campo}`)
        if (Campo != '')
            SetInciso({ ...inciso, [Nombre]: e });
        else
            SetInciso({ ...inciso, [e.target.name]: e.target.value });

    }

    function CleanObject() {
        var Inciso = { ...inciso };
        Object.keys(Inciso).forEach(function (index) {
            Inciso[index] = "";
        });
        SetInciso(Inciso);
    }



    function Add() {
        var Inciso = { ...inciso };
        Inciso['Documento'] = values.Documento;
        Inciso['IDDocto'] = values.IDDocto;
        var dta = {
            "data": Inciso,
        };
        axios
            .post(`${UrlServicio}capture/saveFlotillas`, dta)
            .then(function (response) {
                CleanObject();
                SetListaInc(response.data.Datos);
                SetOpc(0);
            });
    }
    return (
        <div id="ModalFlotilla" className="modal fade" role="dialog">
            <div className="modal-dialog modal-lg">
                <div className="modal-content">
                    <div className="modal-body">
                        <div className='row'>
                            <div className='col-md-12'>
                                <button type="button" className="close" data-dismiss="modal">&times;</button>
                            </div>
                            <div className='col-md-12  text-right'>
                                <a className='btn btn-primary btn-s' data-toggle="tooltip" data-placement="bottom" title="Lista" onClick={() => changeOpc(0)}><i className="fa fa-list" aria-hidden="true"></i></a>
                                <a className='btn btn-primary btn-s' data-toggle="tooltip" data-placement="bottom" title="Nuevo" onClick={() => changeOpc(1)}><i className="fa fa-plus" aria-hidden="true"></i></a>
                                <a className='btn btn-primary btn-s' data-toggle="tooltip" data-placement="bottom" title="Importar" onClick={() => console.log(listaInc)}><i className="fa fa-file" aria-hidden="true"></i></a>
                                <a className='btn btn-primary btn-s' data-toggle="tooltip" data-placement="bottom" title="Guardar" onClick={() => Add()}><i className="fa fa-floppy-o" aria-hidden="true"></i></a>
                            </div>
                        </div>
                        <div className={opc == 0 ? 'row' : 'row hidden'}>
                            <div className={'col-md-12 mt-2'}>
                                <div className='table-responsive'>
                                    <table className="table table-condensed" id="incisos">
                                        <thead style={{ fontSize: '12px' }}>
                                            <tr>
                                                <th>Inciso</th>
                                                <th>Nombre o Razon social</th>
                                                <th>Docto de Alta</th>
                                                <th>Fecha Alta</th>
                                                <th>Docto baja</th>
                                                <th>Fecha baja</th>
                                                <th>Referencia</th>
                                                <th></th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            {Flotillas.length == 0 && (
                                                <tr>
                                                    <td className='text-center' colSpan={8}>NO SE HAN GENERADO LOS RECIBOS</td>
                                                </tr>
                                            )}
                                            {Flotillas && Flotillas.map((item, key) => (
                                                <tr key={key}>
                                                    <td>{item.NumInc}</td>
                                                    <td>{item.Serie}</td>
                                                    <td>{item.Serie}</td>
                                                    <td>{item.FAlta}</td>
                                                    <td>{item.FAlta}</td>
                                                    <td>{item.FBaja}</td>
                                                    <td>{item.Referencia}</td>
                                                    <td>
                                                    <a className='btn btn-primary btn-sm' onClick={() => ''} data-toggle="tooltip" data-placement="bottom" title="Eliminar recibo"><i className="fa fa-pencil" aria-hidden="true"></i></a>
                                                    </td>
                                                </tr>
                                            ))}
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                        <div className={opc == 1 ? 'row' : 'row hidden'}>
                            <div className='col-md-12 mt-2'>
                                <ul className="nav nav-tabs nav-justified" id="FlotillaGeneral" role="tablist">
                                    <li className="nav-item navr">
                                        <a className="nav-link active" id="home-tab" data-toggle="tab" href="#detalle-general-flotilla" role="tab" aria-controls="detalle-general-flotilla" aria-selected="true">Detalle unidad</a>
                                    </li>
                                    <li className="nav-item navr">
                                        <a className="nav-link" id="home-tab" data-toggle="tab" href="#cobertura-flotilla" role="tab" aria-controls="cobertura-flotilla" aria-selected="true">Coberturas</a>
                                    </li>
                                </ul>
                            </div>
                            <div className='col-md-12'>
                                <div className="tab-content" id="FlotillaGeneralTabContent">
                                    <div className="tab-pane fade active show in" id="detalle-general-flotilla" role="tabpanel" aria-labelledby="detalle-general-flotilla-tab">
                                        <div className='row'>
                                            <div className='col-md-4 unsetPadding'>
                                                <div className="form-group">
                                                    <label htmlFor="txMotivo">Inciso</label>
                                                    <input
                                                        className="form-control input-sm"
                                                        type="text"
                                                        name="NumInc"
                                                        id="NumInc"
                                                        onChange={handleChange}
                                                        value={inciso.NumInc ? inciso.NumInc : ''}
                                                    />
                                                </div>
                                            </div>
                                            <div className='col-md-4 unsetPadding'>
                                                <div className="form-group">
                                                    <label htmlFor="txMotivo">Numero Economico</label>
                                                    <input
                                                        className="form-control input-sm"
                                                        type="text"
                                                        name="NumEco"
                                                        id="NumEco"
                                                        onChange={handleChange}
                                                        value={inciso.NumEco ? inciso.NumEco : ''}
                                                    />
                                                </div>
                                            </div>
                                            <div className='col-md-4 unsetPadding'>
                                                <div className="form-group">
                                                    <label htmlFor="txMotivo">Certificado</label>
                                                    <input
                                                        className="form-control input-sm"
                                                        type="text"
                                                        name="Certificado"
                                                        id="Certificado"
                                                        onChange={handleChange}
                                                        value={inciso.Certificado ? inciso.Certificado : ''}
                                                    />
                                                </div>
                                            </div>
                                        </div>
                                        <div className='row'>
                                            <div className='col-md-12 unsetPadding'>
                                                <h6>Conductor habitual</h6>
                                                <hr />
                                            </div>
                                            <div className='col-md-6 unsetPadding'>
                                                <div className="form-group">
                                                    <label htmlFor="txMotivo">Conductor habitual</label>
                                                    <Select
                                                        placeholder="Selecione"
                                                        id="Conductor"
                                                        name="Conductor"
                                                        styles={colourStyles}
                                                        onChange={v => { handleChange(v) }}
                                                        //onBlur={handleBlur}
                                                        value={displayitem(inciso.Conductor, state.InitialData.TipoDocumento)}
                                                        options={mapitems(state.InitialData.TipoDocumento ? state.InitialData.TipoDocumento : [], '')}
                                                        noOptionsMessage={() => "Sin opciones"}
                                                    />
                                                </div>
                                            </div>
                                            <div className='col-md-6 unsetPadding'>
                                                <div className="form-group">
                                                    <label htmlFor="txMotivo">Dirección</label>
                                                    <textarea className='form-control'
                                                        onChange={handleChange}
                                                        value={inciso.Direccion ? inciso.Direccion : ''} name="Direccion" id="Direccion"
                                                        //onChange={handleChange} //value={values.DireccionConductor ? values.DireccionConductor : ''}
                                                        style={{ height: '30px' }}>{inciso.Direccion ? inciso.Direccion : ''}</textarea>
                                                </div>
                                            </div>
                                        </div>
                                        <div className='row'>
                                            <div className='col-md-12 unsetPadding'>
                                                <h6>Datos del vehículo</h6>
                                                <hr />
                                            </div>
                                            <div className='col-md-2 unsetPadding'>
                                                <div className="form-group">
                                                    <label htmlFor="txMotivo">Marca</label>
                                                    <Select
                                                        placeholder="Selecione"
                                                        id="Marca"
                                                        name="Marca"
                                                        styles={colourStyles}
                                                        onChange={v => { handleChange(v, 'Marca') }}
                                                        onBlur={handleBlur}
                                                        value={displayitem(inciso.Marca, state.InitialData.TipoDocumento)}
                                                        options={mapitems(state.InitialData.TipoDocumento ? state.InitialData.TipoDocumento : [], '')}
                                                        noOptionsMessage={() => "Sin opciones"}
                                                    />
                                                </div>
                                            </div>
                                            <div className='col-md-2 unsetPadding'>
                                                <div className="form-group">
                                                    <label htmlFor="txMotivo">Sub Marca</label>
                                                    <Select
                                                        placeholder="Selecione"
                                                        id="SubMarca"
                                                        name="SubMarca"
                                                        styles={colourStyles}
                                                        onChange={v => { handleChange(v, 'SubMarca') }}
                                                        onBlur={handleBlur}
                                                        value={displayitem(inciso.SubMarca, state.InitialData.TipoDocumento)}
                                                        options={mapitems(state.InitialData.TipoDocumento ? state.InitialData.TipoDocumento : [], '')}
                                                        noOptionsMessage={() => "Sin opciones"}
                                                    />
                                                </div>
                                            </div>
                                            <div className='col-md-5'>
                                                <div className='row'>
                                                    <div className='col-md-8 unsetPadding'>
                                                        <div className="form-group">
                                                            <label htmlFor="txMotivo">Tipo</label>
                                                            <input
                                                                className="form-control input-sm"
                                                                type="text"
                                                                name="Tipo"
                                                                id="Tipo"
                                                                onChange={handleChange}
                                                                value={inciso.Tipo ? inciso.Tipo : ''}
                                                            />
                                                        </div>
                                                    </div>
                                                    <div className='col-md-4 unsetPadding'>
                                                        <div className="form-group">
                                                            <label htmlFor="txMotivo">Transmisión</label>
                                                            <Select
                                                                placeholder="Selecione"
                                                                id="Trasmision"
                                                                name="Trasmision"
                                                                styles={colourStyles}
                                                                onChange={v => { handleChange(v, 'Transmision') }}
                                                                onBlur={handleBlur}
                                                                value={displayitem(inciso.Transmision, state.InitialData.TipoDocumento)}
                                                                options={mapitems(state.InitialData.TipoDocumento ? state.InitialData.TipoDocumento : [], '')}
                                                                noOptionsMessage={() => "Sin opciones"}
                                                            />
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div className='col-md-3'>
                                                <div className='row'>
                                                    <div className='col-md-4 unsetPadding'>
                                                        <div className="form-group">
                                                            <label htmlFor="txMotivo">Puertas</label>
                                                            <input
                                                                className="form-control input-sm"
                                                                type="text"
                                                                name="Puertas"
                                                                id="Puertas"
                                                                onChange={handleChange}
                                                                value={inciso.Puertas ? inciso.Puertas : ''}
                                                            />
                                                        </div>
                                                    </div>
                                                    <div className='col-md-4 unsetPadding'>
                                                        <div className="form-group">
                                                            <label htmlFor="txMotivo">Modelo</label>
                                                            <input
                                                                className="form-control input-sm"
                                                                type="text"
                                                                name="Modelo"
                                                                id="Modelo"
                                                                onChange={handleChange}
                                                                value={inciso.Modelo ? inciso.Modelo : ''}
                                                            />
                                                        </div>
                                                    </div>
                                                    <div className='col-md-4 unsetPadding'>
                                                        <div className="form-group">
                                                            <label htmlFor="txMotivo">Clave</label>
                                                            <input
                                                                className="form-control input-sm"
                                                                type="text"
                                                                name="Clave"
                                                                id="Clave"
                                                                onChange={handleChange}
                                                                value={inciso.Clave ? inciso.Clave : ''}
                                                            />
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div className='row'>
                                            <div className='col-md-2 unsetPadding'>
                                                <div className="form-group">
                                                    <label htmlFor="txMotivo">Placas</label>
                                                    <input
                                                        className="form-control input-sm"
                                                        type="text"
                                                        name="Placas"
                                                        id="Placas"
                                                        onChange={handleChange}
                                                        value={inciso.Placas ? inciso.Placas : ''}
                                                    />
                                                </div>
                                            </div>
                                            <div className='col-md-3 unsetPadding'>
                                                <div className="form-group">
                                                    <label htmlFor="txMotivo">Serie</label>
                                                    <input
                                                        className="form-control input-sm"
                                                        type="text"
                                                        name="Serie"
                                                        id="Serie"
                                                        onChange={handleChange}
                                                        value={inciso.Serie ? inciso.Serie : ''}
                                                    />
                                                </div>
                                            </div>
                                            <div className='col-md-2 unsetPadding'>
                                                <div className="form-group">
                                                    <label htmlFor="txMotivo">Motor</label>
                                                    <input
                                                        className="form-control input-sm"
                                                        type="text"
                                                        name="Motor"
                                                        id="Motor"
                                                        onChange={handleChange}
                                                        value={inciso.Motor ? inciso.Motor : ''}
                                                    />
                                                </div>
                                            </div>
                                            <div className='col-md-3 unsetPadding'>
                                                <div className="form-group">
                                                    <label htmlFor="txMotivo">Repuve</label>
                                                    <input
                                                        className="form-control input-sm"
                                                        type="text"
                                                        name="Repuve"
                                                        id="Repuve"
                                                        onChange={handleChange}
                                                        value={inciso.Repuve ? inciso.Repuve : ''}
                                                    />
                                                </div>
                                            </div>
                                            <div className='col-md-2 unsetPadding'>
                                                <div className="form-group">
                                                    <label htmlFor="txMotivo">Cochera</label>
                                                    <Select
                                                        placeholder="Selecione"
                                                        id="Cochera"
                                                        name="Cochera"
                                                        styles={colourStyles}
                                                        onChange={v => { handleChange(v, 'Cochera') }}
                                                        onBlur={handleBlur}
                                                        value={displayitem(inciso.Cochera, state.InitialData.TipoDocumento)}
                                                        options={mapitems(state.InitialData.TipoDocumento ? state.InitialData.TipoDocumento : [], '')}
                                                        noOptionsMessage={() => "Sin opciones"}
                                                    />
                                                </div>
                                            </div>
                                        </div>
                                        <div className='row'>
                                            <div className='col-md-2 unsetPadding'>
                                                <div className="form-group">
                                                    <label htmlFor="txMotivo">Estado Circula</label>
                                                    <Select
                                                        placeholder="Selecione"
                                                        id="EstadoCircula"
                                                        name="EstadoCircula"
                                                        styles={colourStyles}
                                                        onChange={v => { handleChange(v, 'EstadoCircula') }}
                                                        onBlur={handleBlur}
                                                        value={displayitem(inciso.EstadoCircula, state.InitialData.TipoDocumento)}
                                                        options={mapitems(state.InitialData.TipoDocumento ? state.InitialData.TipoDocumento : [], '')}
                                                        noOptionsMessage={() => "Sin opciones"}
                                                    />
                                                </div>
                                            </div>
                                            <div className='col-md-2 unsetPadding'>
                                                <div className="form-group">
                                                    <label htmlFor="txMotivo">Color</label>
                                                    <Select
                                                        placeholder="Selecione"
                                                        id="Color"
                                                        name="Color"
                                                        styles={colourStyles}
                                                        onChange={v => { handleChange(v, 'Color') }}
                                                        onBlur={handleBlur}
                                                        value={displayitem(inciso.Color, state.InitialData.TipoDocumento)}
                                                        options={mapitems(state.InitialData.TipoDocumento ? state.InitialData.TipoDocumento : [], '')}
                                                        noOptionsMessage={() => "Sin opciones"}
                                                    />
                                                </div>
                                            </div>
                                            <div className='col-md-2 unsetPadding'>
                                                <div className="form-group">
                                                    <label htmlFor="txMotivo">Ocupantes</label>
                                                    <input
                                                        className="form-control input-sm numeric"
                                                        type="text"
                                                        name="Ocupantes"
                                                        id="Ocupantes"
                                                        onChange={handleChange}
                                                        value={inciso.Ocupantes ? inciso.Ocupantes : ''}
                                                    />
                                                </div>
                                            </div>
                                            <div className='col-md-2 unsetPadding'>
                                                <div className="form-group">
                                                    <label htmlFor="txMotivo">Servicio</label>
                                                    <Select
                                                        placeholder="Selecione"
                                                        id="Servicio"
                                                        name="Servicio"
                                                        styles={colourStyles}
                                                        onChange={v => { handleChange(v, 'Servicio') }}
                                                        onBlur={handleBlur}
                                                        value={displayitem(inciso.Servicio, state.InitialData.TipoDocumento)}
                                                        options={mapitems(state.InitialData.TipoDocumento ? state.InitialData.TipoDocumento : [], '')}
                                                        noOptionsMessage={() => "Sin opciones"}
                                                    />
                                                </div>
                                            </div>
                                            <div className='col-md-2 unsetPadding'>
                                                <div className="form-group">
                                                    <label htmlFor="txMotivo">Uso Servicio</label>
                                                    <Select
                                                        placeholder="Selecione"
                                                        id="UsoVehiculo"
                                                        name="UsoVehiculo"
                                                        styles={colourStyles}
                                                        onChange={v => { handleChange(v, 'UsoVehiculo') }}
                                                        onBlur={handleBlur}
                                                        value={displayitem(inciso.UsoVehiculo, state.InitialData.TipoDocumento)}
                                                        options={mapitems(state.InitialData.TipoDocumento ? state.InitialData.TipoDocumento : [], '')}
                                                        noOptionsMessage={() => "Sin opciones"}
                                                    />
                                                </div>
                                            </div>
                                            <div className='col-md-2 unsetPadding'>
                                                <div className="form-group">
                                                    <label htmlFor="txMotivo">Inspección</label>
                                                    <Select
                                                        placeholder="Selecione"
                                                        id="Inspeccion"
                                                        name="Inspeccion"
                                                        styles={colourStyles}
                                                        onChange={v => { handleChange(v, 'Inspeccion') }}
                                                        onBlur={handleBlur}
                                                        value={displayitem(inciso.Inspeccion, state.InitialData.TipoDocumento)}
                                                        options={mapitems(state.InitialData.TipoDocumento ? state.InitialData.TipoDocumento : [], '')}
                                                        noOptionsMessage={() => "Sin opciones"}
                                                    />
                                                </div>
                                            </div>
                                        </div>
                                        <div className='row'>
                                            <div className='col-md-3 unsetPadding'>
                                                <div className="form-group">
                                                    <label htmlFor="txMotivo">Tipo de carga</label>
                                                    <input
                                                        className="form-control input-sm"
                                                        type="text"
                                                        name="TipoCarga"
                                                        id="TipoCarga"
                                                        onChange={handleChange}
                                                        value={inciso.TipoCarga ? inciso.TipoCarga : ''}
                                                    />
                                                </div>
                                            </div>
                                            <div className='col-md-3 unsetPadding'>
                                                <div className="form-group">
                                                    <label htmlFor="txMotivo">Tonelaje</label>
                                                    <input
                                                        className="form-control input-sm"
                                                        type="text"
                                                        name="Tonelaje"
                                                        id="Tonelaje"
                                                        onChange={handleChange}
                                                        value={inciso.Tonelaje ? inciso.Tonelaje : ''}
                                                    />
                                                </div>
                                            </div>
                                            <div className='col-md-3 unsetPadding'>
                                                <div className="form-group">
                                                    <label htmlFor="txMotivo">Cia Localizacion</label>
                                                    <Select
                                                        placeholder="Selecione"
                                                        id="CiaLocalizacion"
                                                        name="CiaLocalizacion"
                                                        styles={colourStyles}
                                                        onChange={v => { handleChange(v, 'CiaLocalizacion') }}
                                                        onBlur={handleBlur}
                                                        value={displayitem(inciso.CiaLocalizacion, state.InitialData.TipoDocumento)}
                                                        options={mapitems(state.InitialData.TipoDocumento ? state.InitialData.TipoDocumento : [], '')}
                                                        noOptionsMessage={() => "Sin opciones"}
                                                    />
                                                </div>
                                            </div>
                                            <div className='col-md-3 unsetPadding'>
                                                <div className="form-group">
                                                    <label htmlFor="txMotivo">Serie localizador</label>
                                                    <input
                                                        className="form-control input-sm"
                                                        type="text"
                                                        name="SerieLocalizador"
                                                        id="SerieLocalizador"
                                                        onChange={handleChange}
                                                        value={inciso.SerieLocalizador ? inciso.SerieLocalizador : ''}
                                                    />
                                                </div>
                                            </div>
                                        </div>
                                        <div className='row'>
                                            <div className='col-md-8 unsetPadding'>
                                                <div className="form-group">
                                                    <label htmlFor="txMotivo">Equipo especial</label>
                                                    <input
                                                        className="form-control input-sm"
                                                        type="text"
                                                        name="EqEsp"
                                                        id="EqEsp"
                                                        onChange={handleChange}
                                                        value={inciso.EqEsp ? inciso.EqEsp : ''}
                                                    />
                                                </div>
                                            </div>
                                            <div className='col-md-4 unsetPadding'>
                                                <div className="form-group">
                                                    <label htmlFor="txMotivo">Suma Asegurada</label>
                                                    <input
                                                        className="form-control input-sm numeric"
                                                        type="text"
                                                        name="EqEspSAseg"
                                                        id="EqEspSAseg"
                                                        onChange={handleChange}
                                                        value={inciso.EqEspSAseg ? inciso.EqEspSAseg : ''}
                                                    />
                                                </div>
                                            </div>
                                        </div>
                                        <div className='row'>
                                            <div className='col-md-8 unsetPadding'>
                                                <div className="form-group">
                                                    <label htmlFor="txMotivo">Adaptaciones</label>
                                                    <input
                                                        className="form-control input-sm"
                                                        type="text"
                                                        name="Adaptaciones"
                                                        id="Adaptaciones"
                                                        onChange={handleChange}
                                                        value={inciso.Adap ? inciso.Adap : ''}
                                                    />
                                                </div>
                                            </div>
                                            <div className='col-md-4 unsetPadding'>
                                                <div className="form-group">
                                                    <label htmlFor="txMotivo">Suma Asegurada</label>
                                                    <input
                                                        className="form-control input-sm numeric"
                                                        type="text"
                                                        name="AdapSAseg"
                                                        id="AdapSAseg"
                                                        onChange={handleChange}
                                                        value={inciso.AdapSAseg ? inciso.AdapSAseg : ''}
                                                    />
                                                </div>
                                            </div>
                                        </div>
                                        <div className='row'>
                                            <div className='col-md-12 unsetPadding'>
                                                <h6>Datos del remolque o semiremolque</h6>
                                                <hr />
                                            </div>
                                            <div className='col-md-6 unsetPadding'>
                                                <div className="form-group">
                                                    <label htmlFor="txMotivo">Descripcion remolque</label>
                                                    <input
                                                        className="form-control input-sm"
                                                        type="text"
                                                        name="RDescripcion"
                                                        id="RDescripcion"
                                                        onChange={handleChange}
                                                        value={inciso.RDescripcion ? inciso.RDescripcion : ''}
                                                    />
                                                </div>
                                            </div>
                                            <div className='col-md-3 unsetPadding'>
                                                <div className="form-group">
                                                    <label htmlFor="txMotivo">Marca</label>
                                                    <input
                                                        className="form-control input-sm"
                                                        type="text"
                                                        name="RMarca"
                                                        id="RMarca"
                                                        onChange={handleChange}
                                                        value={inciso.RMarca ? inciso.RMarca : ''}
                                                    />
                                                </div>
                                            </div>
                                            <div className='col-md-3 unsetPadding'>
                                                <div className="form-group">
                                                    <label htmlFor="txMotivo">Tipo</label>
                                                    <input
                                                        className="form-control input-sm"
                                                        type="text"
                                                        name="RTipo"
                                                        id="RTipo"
                                                        onChange={handleChange}
                                                        value={inciso.RTipo ? inciso.RTipo : ''}
                                                    />
                                                </div>
                                            </div>
                                        </div>
                                        <div className='row'>
                                            <div className='col-md-2 unsetPadding'>
                                                <div className="form-group">
                                                    <label htmlFor="txMotivo">Modelo</label>
                                                    <input
                                                        className="form-control input-sm"
                                                        type="text"
                                                        name="RModel"
                                                        id="RModel"
                                                        onChange={handleChange}
                                                        value={inciso.RModelo ? inciso.RModelo : ''}
                                                    />
                                                </div>
                                            </div>
                                            <div className='col-md-2 unsetPadding'>
                                                <div className="form-group">
                                                    <label htmlFor="txMotivo">Clave</label>
                                                    <input
                                                        className="form-control input-sm"
                                                        type="text"
                                                        name="RClave"
                                                        id="RClave"
                                                        onChange={handleChange}
                                                        value={inciso.RClave ? inciso.RClave : ''}
                                                    />
                                                </div>
                                            </div>
                                            <div className='col-md-2 unsetPadding'>
                                                <div className="form-group">
                                                    <label htmlFor="txMotivo">Placas</label>
                                                    <input
                                                        className="form-control input-sm"
                                                        type="text"
                                                        name="RPlacas"
                                                        id="RPlacas"
                                                        onChange={handleChange}
                                                        value={inciso.RPlacas ? inciso.RPlacas : ''}
                                                    />
                                                </div>
                                            </div>
                                            <div className='col-md-4 unsetPadding'>
                                                <div className="form-group">
                                                    <label htmlFor="txMotivo">Serie</label>
                                                    <input
                                                        className="form-control input-sm"
                                                        type="text"
                                                        name="RemolqueSerie"
                                                        id="RemolqueSerie"
                                                        onChange={handleChange}
                                                        value={inciso.RSerie ? inciso.RSerie : ''}
                                                    />
                                                </div>
                                            </div>
                                            <div className='col-md-2 unsetPadding'>
                                                <div className="form-group">
                                                    <label htmlFor="txMotivo">Suma asegurada</label>
                                                    <input
                                                        className="form-control input-sm numeric"
                                                        type="text"
                                                        name="RSumaAsegurada"
                                                        id="RSumaAsegurada"
                                                        onChange={handleChange}
                                                        value={inciso.RSumaAsegurada ? inciso.RSumaAsegurada : ''}
                                                    />
                                                </div>
                                            </div>
                                        </div>
                                        <div className='row'>
                                            <div className='col-md-12 unsetPadding'>
                                                <h6>Detalle de primas</h6>
                                                <hr />
                                            </div>
                                            <div className='col-md-12'>
                                                <div className='row'>
                                                    <div className='col-md-2 unsetPadding'>
                                                        <div className='form-group'>
                                                            <label className='col-form-label titulo'>Prima Neta</label>
                                                            <CurrencyInputField
                                                                className='form-control input-sm numeric'
                                                                //onBlur={() => { handleBlur, ReloadPrices(values) }}
                                                                min={0}
                                                                maxLength={10}
                                                                //prefix='$'
                                                                decimalSeparator='.'
                                                                groupSeparator=','
                                                                //onFocus={FocusInput}
                                                                allowNegativeValue={false}
                                                                value={inciso.PrimaNeta ? inciso.PrimaNeta : '0'}
                                                                onValueChange={(value, name) => { handleChange(value, name) }}
                                                                id='PrimaNeta'
                                                                name='PrimaNeta'
                                                                autoComplete='off'
                                                            />
                                                        </div>
                                                    </div>
                                                    <div className='col-md-2 unsetPadding'>
                                                        <div className='form-group'>
                                                            <label className='col-form-label titulo'>Descuento</label>
                                                            <CurrencyInputField
                                                                className='form-control input-sm numeric'
                                                                //onBlur={() => { handleBlur, ReloadPrices(values) }}
                                                                min={0}
                                                                maxLength={10}
                                                                //prefix='$'
                                                                decimalSeparator='.'
                                                                groupSeparator=','
                                                                //onFocus={FocusInput}
                                                                allowNegativeValue={false}
                                                                value={inciso.Descuento ? inciso.Descuento : '0'}
                                                                onValueChange={(value, name) => { handleChange(value, name) }}
                                                                id='Descuento'
                                                                name='Descuento'
                                                                autoComplete='off'
                                                            />
                                                        </div>
                                                    </div>
                                                    <div className='col-md-2 unsetPadding'>
                                                        <div className='form-group'>
                                                            <label className='col-form-label titulo'>%</label>
                                                            <CurrencyInputField
                                                                className='form-control input-sm numeric'
                                                                //onBlur={() => { handleBlur, ReloadPrices(values) }}
                                                                min={0}
                                                                maxLength={10}
                                                                //prefix='$'
                                                                decimalSeparator='.'
                                                                groupSeparator=','
                                                                //onFocus={FocusInput}
                                                                allowNegativeValue={false}
                                                                value={inciso.PDescuento ? inciso.PDescuento : '0'}
                                                                onValueChange={(value, name) => { handleChange(value, name) }}
                                                                id='PDescuento'
                                                                name='PDescuento'
                                                                autoComplete='off'
                                                            />
                                                        </div>
                                                    </div>
                                                    <div className='col-md-2 unsetPadding'>
                                                        <div className='form-group'>
                                                            <label className='col-form-label titulo'>Recargos</label>
                                                            <CurrencyInputField
                                                                className='form-control input-sm numeric'
                                                                ///onBlur={() => { handleBlur, ReloadPrices(values) }}
                                                                min={0}
                                                                maxLength={10}
                                                                //prefix='$'
                                                                decimalSeparator='.'
                                                                groupSeparator=','
                                                                //onFocus={FocusInput}
                                                                allowNegativeValue={false}
                                                                value={inciso.Recargos ? inciso.Recargos : '0'}
                                                                onValueChange={(value, name) => { handleChange(value, name) }}
                                                                id='Recargos'
                                                                name='Recargos'
                                                                autoComplete='off'
                                                            />
                                                        </div>

                                                    </div>
                                                    <div className='col-md-2 unsetPadding'>
                                                        <div className='form-group'>
                                                            <label className='col-form-label titulo'>%</label>
                                                            <CurrencyInputField
                                                                className='form-control input-sm numeric'
                                                                //onBlur={() => { handleBlur, ReloadPrices(values) }}
                                                                min={0}
                                                                maxLength={10}
                                                                //prefix='$'
                                                                decimalSeparator='.'
                                                                groupSeparator=','
                                                                //onFocus={FocusInput}
                                                                allowNegativeValue={false}
                                                                value={inciso.PDescuento ? inciso.PDescuento : '0'}
                                                                onValueChange={(value, name) => { handleChange(value, name) }}
                                                                id='PDescuento'
                                                                name='PDescuento'
                                                                autoComplete='off'
                                                            />
                                                        </div>
                                                    </div>
                                                    <div className='col-md-2 unsetPadding'>
                                                        <div className='form-group'>
                                                            <label className='col-form-label titulo'>Derechos</label>
                                                            <CurrencyInputField
                                                                className='form-control input-sm numeric'
                                                                //onBlur={() => { handleBlur, ReloadPrices(values) }}
                                                                min={0}
                                                                maxLength={10}
                                                                //prefix='$'
                                                                decimalSeparator='.'
                                                                groupSeparator=','
                                                                //onFocus={FocusInput}
                                                                allowNegativeValue={false}
                                                                value={inciso.Derechos ? inciso.Derechos : '0'}
                                                                onValueChange={(value, name) => { handleChange(value, name) }}
                                                                id='Derechos'
                                                                name='Derechos'
                                                                autoComplete='off'
                                                            />
                                                        </div>
                                                    </div>
                                                    <div className='col-md-2 unsetPadding'>
                                                        <div className='form-group'>
                                                            <label className='col-form-label titulo'>SubTotal</label>
                                                            <CurrencyInputField
                                                                className='form-control input-sm numeric'
                                                                //onBlur={() => { handleBlur, ReloadPrices(values) }}
                                                                min={0}
                                                                maxLength={10}
                                                                //prefix='$'
                                                                decimalSeparator='.'
                                                                groupSeparator=','
                                                                //onFocus={FocusInput}
                                                                allowNegativeValue={false}
                                                                value={inciso.SubTotal ? inciso.SubTotal : '0'}
                                                                onValueChange={(value, name) => { handleChange(value, name) }}
                                                                id='SubTotal'
                                                                name='SubTotal'
                                                                autoComplete='off'
                                                            />
                                                        </div>
                                                    </div>
                                                    <div className='col-md-2 unsetPadding'>
                                                        <div className='form-group'>
                                                            <label className='col-form-label titulo'>IVA</label>
                                                            <CurrencyInputField
                                                                className='form-control input-sm numeric'
                                                                //onBlur={() => { handleBlur, ReloadPrices(values) }}
                                                                min={0}
                                                                maxLength={10}
                                                                //prefix='$'
                                                                decimalSeparator='.'
                                                                groupSeparator=','
                                                                //onFocus={FocusInput}
                                                                allowNegativeValue={false}
                                                                value={inciso.IVA ? inciso.IVA : '0'}
                                                                onValueChange={(value, name) => { handleChange(value, name) }}
                                                                id='IVA'
                                                                name='IVA'
                                                                autoComplete='off'
                                                            />
                                                        </div>
                                                    </div>
                                                    <div className='col-md-2 unsetPadding'>
                                                        <div className='form-group'>
                                                            <label className='col-form-label titulo'>%</label>
                                                            <CurrencyInputField
                                                                className='form-control input-sm numeric'
                                                                //onBlur={() => { handleBlur, ReloadPrices(values) }}
                                                                min={0}
                                                                maxLength={10}
                                                                //prefix='$'
                                                                decimalSeparator='.'
                                                                groupSeparator=','
                                                                //onFocus={FocusInput}
                                                                allowNegativeValue={false}
                                                                value={inciso.PIVA ? inciso.PIVA : '0'}
                                                                onValueChange={(value, name) => { handleChange(value, name) }}
                                                                id='PIVA'
                                                                name='PIVA'
                                                                autoComplete='off'
                                                            />
                                                        </div>
                                                    </div>
                                                    <div className='col-md-3 unsetPadding'>
                                                        <div className='form-group'>
                                                            <label className='col-form-label titulo'>Ajuste</label>
                                                            <CurrencyInputField
                                                                className='form-control input-sm numeric'
                                                                //onBlur={() => { handleBlur, ReloadPrices(values) }}
                                                                min={0}
                                                                maxLength={10}
                                                                //prefix='$'
                                                                decimalSeparator='.'
                                                                groupSeparator=','
                                                                //onFocus={FocusInput}
                                                                allowNegativeValue={false}
                                                                value={inciso.Ajuste ? inciso.Ajuste : '0'}
                                                                onValueChange={(value, name) => { handleChange(value, name) }}
                                                                id='Ajuste'
                                                                name='Ajuste'
                                                                autoComplete='off'
                                                            />
                                                        </div>
                                                    </div>
                                                    <div className='col-md-3 unsetPadding'>
                                                        <div className='form-group'>
                                                            <label className='col-form-label titulo'>Prima Total</label>
                                                            <CurrencyInputField
                                                                className='form-control input-sm numeric'
                                                                //onBlur={() => { handleBlur, ReloadPrices(values) }}
                                                                min={0}
                                                                maxLength={10}
                                                                //prefix='$'
                                                                decimalSeparator='.'
                                                                groupSeparator=','
                                                                //onFocus={FocusInput}
                                                                allowNegativeValue={false}
                                                                value={inciso.PrimaTotal ? inciso.PrimaTotal : '0'}
                                                                onValueChange={(value, name) => { handleChange(value, name) }}
                                                                id='PrimaTotal'
                                                                name='PrimaTotal'
                                                                autoComplete='off'
                                                            />
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div className='col-md-12 unsetPadding'>
                                                <h6>Complemento</h6>
                                                <hr />
                                            </div>
                                            <div className='col-md-12'>
                                                <div className='row'>
                                                    <div className='col-md-4 unsetPadding'>
                                                        <div className='form-group'>
                                                            <label className='col-form-label titulo'>Docto Alta</label>
                                                            <input
                                                                className="form-control input-sm"
                                                                type="text"
                                                                name="DoctoAlta"
                                                                id="DoctoAlta"
                                                                onChange={handleChange}
                                                                value={inciso.DoctoAlta ? inciso.DoctoAlta : ''}
                                                            />
                                                        </div>
                                                    </div>
                                                    <div className='col-md-4 unsetPadding'>
                                                        <div className='form-group'>
                                                            <label className='col-form-label titulo'>Fecha Alta</label>
                                                            <input
                                                                className="form-control input-sm"
                                                                type="date"
                                                                name="FAlta"
                                                                id="FAlta"
                                                                onChange={handleChange}
                                                                value={inciso.FAlta ? moment(inciso.FAlta).format("YYYY-MM-DD") : ''}
                                                            />
                                                        </div>
                                                    </div>
                                                    <div class="w-100 d-none d-md-block"></div>
                                                    <div className='col-md-4 unsetPadding'>
                                                        <div className='form-group'>
                                                            <label className='col-form-label titulo'>Docto Baja</label>
                                                            <input
                                                                className="form-control input-sm"
                                                                type="text"
                                                                name="DoctoBaja"
                                                                id="DoctoBaja"
                                                                onChange={handleChange}
                                                                value={inciso.DoctoBaja ? inciso.DoctoBaja : ''}
                                                            />
                                                        </div>
                                                    </div>
                                                    <div className='col-md-4 unsetPadding'>
                                                        <div className='form-group'>
                                                            <label className='col-form-label titulo'>Fecha Baja</label>
                                                            <input
                                                                className="form-control input-sm"
                                                                type="date"
                                                                name="FBaja"
                                                                id="FBaja"
                                                                onChange={handleChange}
                                                                value={inciso.FBaja ? moment(inciso.FBaja).format("YYYY-MM-DD") : ''}
                                                            />
                                                        </div>
                                                    </div>
                                                    <div className='col-md-4 unsetPadding'>
                                                        <div className='form-group'>
                                                            <label className='col-form-label titulo'>Estatus</label>
                                                            <input
                                                                className="form-control input-sm"
                                                                type="text"
                                                                name="Estatus"
                                                                id="Estatus"
                                                                onChange={handleChange}
                                                                value={inciso.Estatus ? inciso.Estatus : ''}
                                                            />
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div className='col-md-12 unsetPadding'>
                                                <div className='form-group'>
                                                    <label className='col-form-label titulo'>Referencia</label>
                                                    <input
                                                        className="form-control input-sm"
                                                        type="text"
                                                        name="Referencia"
                                                        id="Referencia"
                                                        onChange={handleChange}
                                                        value={inciso.Referencia ? inciso.Referencia : ''}
                                                    />
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div className="tab-pane fade" id="cobertura-flotilla" role="tabpanel" aria-labelledby="cobertura-flotilla-tab">
                                        test1
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    )
}
