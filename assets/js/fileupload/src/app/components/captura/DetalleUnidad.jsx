import React from 'react';
import Select from "react-select";
import CurrencyInputField from 'react-currency-input-field';
import { mapitemsHijos,UpperCaseField } from '../../Helpers/FGeneral';


export default function DetalleUnidad(props) {
    const { values, errors, state, handleChange, handleKeyDown, handleBlur, setFieldValue, displayitem, mapitems, CheckNumSerie } = props;

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
    return (
        <div className="tab-pane fade" id="detalle-unidad" role="tabpanel" aria-labelledby="detalle-unidad-tab">
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
                            id="IDConductor"
                            name="IDConductor"
                            styles={colourStyles}
                            onChange={v => { setFieldValue("IDConductor", v.value) }}
                            onBlur={handleBlur}
                            value={displayitem(values.TipoDocto, state.InitialData.TipoDocumento)}
                            options={mapitems([] ? [] : [], '')}
                            noOptionsMessage={() => "Sin opciones"}
                        />
                    </div>
                </div>
                <div className='col-md-6 unsetPadding'>
                    <div className="form-group">
                        <label htmlFor="txMotivo">Dirección</label>
                        <textarea className='form-control' name="DireccionConductor" id="DireccionConductor"
                            //onChange={handleChange} 
                            onChange={e=> setFieldValue("DireccionConductor", UpperCaseField(e.target.value))}
                            value={values.DireccionConductor ? values.DireccionConductor : ''}
                            style={{ height: '30px' }}>{values.DireccionConductor ? values.DireccionConductor : ''}</textarea>
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
                            id="IDMarca"
                            name="IDMarca"
                            styles={colourStyles}
                            onChange={v => { setFieldValue("IDMarca", v.value) }}
                            onBlur={handleBlur}
                            value={displayitem(values.IDMarca, state.InitialData.Marca)}
                            options={mapitems(state.InitialData.Marca ? state.InitialData.Marca : [], '')}
                            noOptionsMessage={() => "Sin opciones"}
                        />
                    </div>
                </div>
                <div className='col-md-2 unsetPadding'>
                    <div className="form-group">
                        <label htmlFor="txMotivo">Sub Marca</label>
                        <Select
                            placeholder="Selecione"
                            id="IDSubMarca"
                            name="IDSubMarca"
                            styles={colourStyles}
                            onChange={v => { setFieldValue("IDSubMarca", v.value) }}
                            onBlur={handleBlur}
                            value={displayitem(values.IDSubMarca, state.InitialData.SubMarca)}
                            //options={mapitems(state.InitialData.SubMarca ? state.InitialData.SubMarca : [], '')}
                            options={mapitemsHijos(state.InitialData.SubMarca ? state.InitialData.SubMarca : [], values.IDMarca)}
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
                                    name="TipoCarro"
                                    id="TipoCarro"
                                    //onKeyDown={handleKeyDown}
                                    //onChange={handleChange}
                                    onChange={e=> setFieldValue("TipoCarro", UpperCaseField(e.target.value))}
                                    value={values.TipoCarro ? values.TipoCarro : ''}
                                />
                            </div>
                        </div>
                        <div className='col-md-4 unsetPadding'>
                            <div className="form-group">
                                <label htmlFor="txMotivo">Trasmisión</label>
                                <Select
                                    placeholder="Selecione"
                                    id="IDTrasmision"
                                    name="IDTrasmision"
                                    styles={colourStyles}
                                    onChange={v => { setFieldValue("IDTrasmision", v.value) }}
                                    onBlur={handleBlur}
                                    value={displayitem(values.IDTrasmision, state.InitialData.Transmision)}
                                    options={mapitems(state.InitialData.Transmision ? state.InitialData.Transmision : [], '')}
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
                                {/* <a onClick={()=>{console.log(values),console.log(handleChange)}}>test</a> */}
                                <input
                                    className="form-control input-sm numeric"
                                    type="text"
                                    name="Puertas"
                                    id="Puertas"
                                    ////onKeyDown={handleKeyDown}
                                    onChange={handleChange}
                                    value={values.Puertas ? values.Puertas : ''}
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
                                    //onKeyDown={handleKeyDown}
                                    //onChange={handleChange}
                                    onChange={e=> setFieldValue("Modelo", UpperCaseField(e.target.value))}
                                    value={values.Modelo ? values.Modelo : ''}
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
                                    //onKeyDown={handleKeyDown}
                                    //onChange={handleChange}
                                    onChange={e=> setFieldValue("Clave", UpperCaseField(e.target.value))}
                                    value={values.Clave ? values.Clave : ''}
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
                            //onKeyDown={handleKeyDown}
                            //onChange={handleChange}
                            onChange={e=> setFieldValue("Placas", UpperCaseField(e.target.value))}
                            value={values.Placas ? values.Placas : ''}
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
                            onBlur={()=>CheckNumSerie()}
                            onChange={e=> setFieldValue("Serie", UpperCaseField(e.target.value))}
                            //onKeyDown={handleKeyDown}
                            //onChange={handleChange}
                            value={values.Serie ? values.Serie : ''}
                        />
                        <span className="help-block">{errors.Serie ? errors.Serie : ''}</span>
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
                            //onKeyDown={handleKeyDown}
                            //onChange={handleChange}
                            onChange={e=> setFieldValue("Motor", UpperCaseField(e.target.value))}
                            value={values.Motor ? values.Motor : ''}
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
                            onChange={e=> setFieldValue("Repuve", UpperCaseField(e.target.value))}
                            //onKeyDown={handleKeyDown}
                            //onChange={handleChange}
                            value={values.Repuve ? values.Repuve : ''}
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
                            onChange={v => { setFieldValue("Cochera", v.value) }}
                            onBlur={handleBlur}
                            value={displayitem(values.Cochera, state.InitialData.Cochera)}
                            options={mapitems(state.InitialData.Cochera ? state.InitialData.Cochera : [], '')}
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
                            id="IDEstadoCircula"
                            name="IDEstadoCircula"
                            styles={colourStyles}
                            onChange={v => { setFieldValue("IDEstadoCircula", v.value) }}
                            onBlur={handleBlur}
                            value={displayitem(values.IDEstadoCircula, state.InitialData.Estados)}
                            options={mapitems(state.InitialData.Estados ? state.InitialData.Estados : [], '')}
                            noOptionsMessage={() => "Sin opciones"}
                        />
                    </div>
                </div>
                <div className='col-md-2 unsetPadding'>
                    <div className="form-group">
                        <label htmlFor="txMotivo">Color</label>
                        <Select
                            placeholder="Selecione"
                            id="IDColor"
                            name="IDColor"
                            styles={colourStyles}
                            onChange={v => { setFieldValue("IDColor", v.value) }}
                            onBlur={handleBlur}
                            value={displayitem(values.IDColor, state.InitialData.Color)}
                            options={mapitems(state.InitialData.Color ? state.InitialData.Color : [], '')}
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
                            onChange={e=> setFieldValue("Ocupantes", UpperCaseField(e.target.value))}
                            //onKeyDown={handleKeyDown}
                            //onChange={handleChange}
                            value={values.Ocupantes ? values.Ocupantes : ''}
                        />
                    </div>
                </div>
                <div className='col-md-2 unsetPadding'>
                    <div className="form-group">
                        <label htmlFor="txMotivo">Servicio</label>
                        <Select
                            placeholder="Selecione"
                            id="IDServicio"
                            name="IDServicio"
                            styles={colourStyles}
                            onChange={v => { setFieldValue("IDServicio", v.value) }}
                            onBlur={handleBlur}
                            value={displayitem(values.IDServicio, state.InitialData.Servicio)}
                            options={mapitems(state.InitialData.Servicio ? state.InitialData.Servicio : [], '')}
                            noOptionsMessage={() => "Sin opciones"}
                        />
                    </div>
                </div>
                <div className='col-md-2 unsetPadding'>
                    <div className="form-group">
                        <label htmlFor="txMotivo">Uso Servicio</label>
                        <Select
                            placeholder="Selecione"
                            id="IDUsoServicio"
                            name="IDUsoServicio"
                            styles={colourStyles}
                            onChange={v => { setFieldValue("IDUsoServicio", v.value) }}
                            onBlur={handleBlur}
                            value={displayitem(values.IDUsoServicio, state.InitialData.UsoServicio)}
                            options={mapitems(state.InitialData.UsoServicio ? state.InitialData.UsoServicio : [], '')}
                            noOptionsMessage={() => "Sin opciones"}
                        />
                    </div>
                </div>
                <div className='col-md-2 unsetPadding'>
                    <div className="form-group">
                        <label htmlFor="txMotivo">Inspección</label>
                        <Select
                            placeholder="Selecione"
                            id="IDInspeccion"
                            name="IDInspeccion"
                            styles={colourStyles}
                            onChange={v => { setFieldValue("IDInspeccion", v.value) }}
                            onBlur={handleBlur}
                            value={displayitem(values.IDInspeccion, state.InitialData.Inspeccion)}
                            options={mapitems(state.InitialData.Inspeccion ? state.InitialData.Inspeccion : [], '')}
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
                            //onKeyDown={handleKeyDown}
                            //onChange={handleChange}
                            onChange={e=> setFieldValue("TipoCarga", UpperCaseField(e.target.value))}
                            value={values.TipoCarga ? values.TipoCarga : ''}
                        />
                    </div>
                </div>
                <div className='col-md-3 unsetPadding'>
                    <div className="form-group">
                        <label htmlFor="txMotivo">Tonelaje</label>
                        <input
                            className="form-control input-sm numeric"
                            type="text"
                            name="Tonelaje"
                            id="Tonelaje"
                            onChange={e=> setFieldValue("Tonelaje", UpperCaseField(e.target.value))}
                            //onKeyDown={handleKeyDown}
                            //onChange={handleChange}
                            value={values.Tonelaje ? values.Tonelaje : ''}
                        />
                    </div>
                </div>
                <div className='col-md-3 unsetPadding'>
                    <div className="form-group">
                        <label htmlFor="txMotivo">Cia Localizacion</label>
                        <Select
                            placeholder="Selecione"
                            id="IDCiaLoc"
                            name="IDCiaLoc"
                            styles={colourStyles}
                            onChange={v => { setFieldValue("IDCiaLoc", v.value) }}
                            onBlur={handleBlur}
                            value={displayitem(values.IDCiaLoc, state.InitialData.CiaLocalizacion)}
                            options={mapitems(state.InitialData.CiaLocalizacion ? state.InitialData.CiaLocalizacion : [], '')}
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
                            name="SerieLoc"
                            id="SerieLoc"
                            //onKeyDown={handleKeyDown}
                            //onChange={handleChange}
                            onChange={e=> setFieldValue("SerieLoc", UpperCaseField(e.target.value))}
                            value={values.SerieLoc ? values.SerieLoc : ''}
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
                            name="EqEspecial"
                            id="EqEspecial"
                            //onKeyDown={handleKeyDown}
                            //onChange={handleChange}
                            onChange={e=> setFieldValue("EqEspecial", UpperCaseField(e.target.value))}
                            value={values.EqEspecial ? values.EqEspecial : ''}
                        />
                    </div>
                </div>
                <div className='col-md-4 unsetPadding'>
                    <div className="form-group">
                        <label htmlFor="txMotivo">Suma Asegurada</label>
                        <input
                            className="form-control input-sm numeric"
                            type="text"
                            name="EquSumaA"
                            id="EquSumaA"
                            //onKeyDown={handleKeyDown}
                            //onChange={handleChange}
                            onChange={e=> setFieldValue("EquSumaA", UpperCaseField(e.target.value))}
                            value={values.EquSumaA ? values.EquSumaA : '0'}
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
                            name="Adaptacion"
                            id="Adaptacion"
                            //onKeyDown={handleKeyDown}
                            //onChange={handleChange}
                            onChange={e=> setFieldValue("Adaptacion", UpperCaseField(e.target.value))}
                            value={values.Adaptacion ? values.Adaptacion : ''}
                        />
                    </div>
                </div>
                <div className='col-md-4 unsetPadding'>
                    <div className="form-group">
                        <label htmlFor="txMotivo">Suma Asegurada</label>
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
                            value={values.AdSumaA ? values.AdSumaA : '0'}
                            onChange={handleChange}
                            id='AdSumaA'
                            name='AdSumaA'
                            autoComplete='off'
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
                            name="RemolqueDes"
                            id="RemolqueDes"
                            //onKeyDown={handleKeyDown}
                            //onChange={handleChange}
                            onChange={e=> setFieldValue("RemolqueDes", UpperCaseField(e.target.value))}
                            value={values.RemolqueDes ? values.RemolqueDes : ''}
                        />
                    </div>
                </div>
                <div className='col-md-3 unsetPadding'>
                    <div className="form-group">
                        <label htmlFor="txMotivo">Marca</label>
                        <input
                            className="form-control input-sm"
                            type="text"
                            name="RemolqueMarca"
                            id="RemolqueMarca"
                            //onKeyDown={handleKeyDown}
                            //onChange={handleChange}
                            onChange={e=> setFieldValue("RemolqueMarca", UpperCaseField(e.target.value))}
                            value={values.RemolqueMarca ? values.RemolqueMarca : ''}
                        />
                    </div>
                </div>
                <div className='col-md-3 unsetPadding'>
                    <div className="form-group">
                        <label htmlFor="txMotivo">Tipo</label>
                        <input
                            className="form-control input-sm"
                            type="text"
                            name="RemolqueTipo"
                            id="RemolqueTipo"
                            //onKeyDown={handleKeyDown}
                            //onChange={handleChange}
                            onChange={e=> setFieldValue("RemolqueTipo", UpperCaseField(e.target.value))}
                            value={values.RemolqueTipo ? values.RemolqueTipo : ''}
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
                            name="RemolqueModelo"
                            id="RemolqueModelo"
                            //onKeyDown={handleKeyDown}
                            //onChange={handleChange}
                            onChange={e=> setFieldValue("RemolqueModelo", UpperCaseField(e.target.value))}
                            value={values.RemolqueModelo ? values.RemolqueModelo : ''}
                        />
                    </div>
                </div>
                <div className='col-md-2 unsetPadding'>
                    <div className="form-group">
                        <label htmlFor="txMotivo">Clave</label>
                        <input
                            className="form-control input-sm"
                            type="text"
                            name="RemolqueClave"
                            id="RemolqueClave"
                            //onKeyDown={handleKeyDown}
                            //onChange={handleChange}
                            onChange={e=> setFieldValue("RemolqueClave", UpperCaseField(e.target.value))}
                            value={values.RemolqueClave ? values.RemolqueClave : ''}
                        />
                    </div>
                </div>
                <div className='col-md-2 unsetPadding'>
                    <div className="form-group">
                        <label htmlFor="txMotivo">Placas</label>
                        <input
                            className="form-control input-sm"
                            type="text"
                            name="RemolquePlacas"
                            id="RemolquePlacas"
                            //onKeyDown={handleKeyDown}
                            //onChange={handleChange}
                            onChange={e=> setFieldValue("RemolquePlacas", UpperCaseField(e.target.value))}
                            value={values.RemolquePlacas ? values.RemolquePlacas : ''}
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
                            onChange={e=> setFieldValue("RemolqueSerie", UpperCaseField(e.target.value))}
                            //onKeyDown={handleKeyDown}
                            //onChange={handleChange}
                            value={values.RemolqueSerie ? values.RemolqueSerie : ''}
                        />
                    </div>
                </div>
                <div className='col-md-2 unsetPadding'>
                    <div className="form-group">
                        <label htmlFor="txMotivo">Suma asegurada</label>
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
                            value={values.RemolqueSumaA ? values.RemolqueSumaA : '0'}
                            onValueChange={(value, name) => { handleChange(value, name) }}
                            id='RemolqueSumaA'
                            name='RemolqueSumaA'
                            autoComplete='off'
                        />
                    </div>
                </div>
            </div>
        </div>
    )
}
