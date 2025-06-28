import React from 'react';
import Select from "react-select";
import { Sexo, colourStyles, UpperCaseField, CalculateEdad } from '../../Helpers/FGeneral';

export default function DetalleGMD(props) {
    const { values, errors, state, handleChange, handleKeyDown, handleBlur, setFieldValue, displayitem, mapitems } = props
    return (
        <div className="tab-pane fade" id="detalleGMD" role="tabpanel" aria-labelledby="detalleGMD-tab">
            <div className='row'>
                <div className='col-md-12 unsetPadding'>
                    <h6>Asegurado Principal</h6>
                    <hr />
                </div>
                <div className='col-md-2 unsetPadding'>
                    <div className="form-group">
                        <label htmlFor="txMotivo">Apellido Paterno</label>
                        <input
                            className="form-control input-sm"
                            type="text"
                            name="AApaterno"
                            id="AApaterno"
                            //onKeyDown={handleKeyDown}
                            //onChange={handleChange}
                            onChange={e => setFieldValue("AApaterno", UpperCaseField(e.target.value))}
                            value={values.AApaterno ? values.AApaterno : ''}
                        />
                    </div>
                </div>
                <div className='col-md-2 unsetPadding'>
                    <div className="form-group">
                        <label htmlFor="txMotivo">Apellido Materno</label>
                        <input
                            className="form-control input-sm"
                            type="text"
                            name="AAmaterno"
                            id="AAmaterno"
                            //onKeyDown={handleKeyDown}
                            //onChange={handleChange}
                            onChange={e => setFieldValue("AAmaterno", UpperCaseField(e.target.value))}
                            value={values.AAmaterno ? values.AAmaterno : ''}
                        />
                    </div>
                </div>
                <div className='col-md-2 unsetPadding'>
                    <div className="form-group">
                        <label htmlFor="txMotivo">Nombres</label>
                        <input
                            className="form-control input-sm"
                            type="text"
                            name="ANombre"
                            id="ANombre"
                            //onKeyDown={handleKeyDown}
                            //onChange={handleChange}
                            onChange={e => setFieldValue("ANombre", UpperCaseField(e.target.value))}
                            value={values.ANombre ? values.ANombre : ''}
                        />
                    </div>
                </div>
                <div className='col-md-2 unsetPadding'>
                    <div className="form-group">
                        <label htmlFor="txMotivo">F. Nacimiento</label>
                        <input
                            className="form-control input-sm"
                            type="date"
                            name="AFnacimiento"
                            id="AFnacimiento"
                            //onKeyDown={handleKeyDown}
                            //onChange={handleChange}
                            onChange={e => { setFieldValue("AFnacimiento", UpperCaseField(e.target.value)), setFieldValue('AEdad', CalculateEdad(e.target.value)) }}
                            value={values.AFnacimiento ? values.AFnacimiento : ''}
                        />
                    </div>
                </div>
                <div className='col-md-2 unsetPadding'>
                    <div className="form-group">
                        <label htmlFor="txMotivo">Edad</label>
                        <input
                            className="form-control input-sm"
                            type="text"
                            name="AEdad"
                            id="AEdad"
                            onChange={e => setFieldValue("AEdad", UpperCaseField(e.target.value))}
                            //onKeyDown={handleKeyDown}
                            //onChange={handleChange}
                            value={values.AEdad ? values.AEdad : ''}
                        />
                    </div>
                </div>
                <div className='col-md-2 unsetPadding'>
                    <div className="form-group">
                        <label htmlFor="txMotivo">Sexo</label>
                        <Select
                            placeholder="Selecione"
                            id="ASexo"
                            name="ASexo"
                            styles={colourStyles}
                            onChange={v => { setFieldValue("ASexo", v.value) }}
                            onBlur={handleBlur}
                            value={displayitem(values.ASexo ? values.ASexo : '', Sexo)}
                            options={mapitems(Sexo ? Sexo : [], '')}
                            noOptionsMessage={() => "Sin opciones"}
                        />
                    </div>
                </div>
            </div>
            <div className='row'>
                <div className='col-md-12 unsetPadding'>
                    <h6>Asegurado Secundario</h6>
                    <hr />
                </div>
                <div className='col-md-2 unsetPadding'>
                    <div className="form-group">
                        <label htmlFor="txMotivo">Apellido Paterno</label>
                        <input
                            className="form-control input-sm"
                            type="text"
                            name="ApaternoS"
                            id="ApaternoS"
                            //onKeyDown={handleKeyDown}
                            //onChange={handleChange}
                            onChange={e => setFieldValue("ApaternoS", UpperCaseField(e.target.value))}
                            value={values.ApaternoS ? values.ApaternoS : ''}
                        />
                    </div>
                </div>
                <div className='col-md-2 unsetPadding'>
                    <div className="form-group">
                        <label htmlFor="txMotivo">Apellido Materno</label>
                        <input
                            className="form-control input-sm"
                            type="text"
                            name="AmaternoS"
                            id="AmaternoS"
                            //onKeyDown={handleKeyDown}
                            //onChange={handleChange}
                            onChange={e => setFieldValue("AmaternoS", UpperCaseField(e.target.value))}
                            value={values.AmaternoS ? values.AmaternoS : ''}
                        />
                    </div>
                </div>
                <div className='col-md-2 unsetPadding'>
                    <div className="form-group">
                        <label htmlFor="txMotivo">Nombres</label>
                        <input
                            className="form-control input-sm"
                            type="text"
                            name="ANombreS"
                            id="ANombreS"
                            //onKeyDown={handleKeyDown}
                            //onChange={handleChange}
                            onChange={e => setFieldValue("ANombreS", UpperCaseField(e.target.value))}
                            value={values.ANombreS ? values.ANombreS : ''}
                        />
                    </div>
                </div>
                <div className='col-md-2 unsetPadding'>
                    <div className="form-group">
                        <label htmlFor="txMotivo">F. Nacimiento</label>
                        <input
                            className="form-control input-sm"
                            type="date"
                            name="AFnacimientoS"
                            id="AFnacimientoS"
                            //onKeyDown={handleKeyDown}
                            //onChange={handleChange}
                            onChange={e => { setFieldValue("AFnacimientoS", UpperCaseField(e.target.value)), setFieldValue('AEdadS', CalculateEdad(e.target.value)) }}
                            value={values.AFnacimientoS ? values.AFnacimientoS : ''}
                        />
                    </div>
                </div>
                <div className='col-md-2 unsetPadding'>
                    <div className="form-group">
                        <label htmlFor="txMotivo">Edad</label>
                        <input
                            className="form-control input-sm"
                            type="text"
                            name="AEdadS"
                            id="AEdadS"
                            //onKeyDown={handleKeyDown}
                            //onChange={handleChange}
                            onChange={e => setFieldValue("AEdadS", UpperCaseField(e.target.value))}
                            value={values.AEdadS ? values.AEdadS : ''}
                        />
                    </div>
                </div>
                <div className='col-md-2 unsetPadding'>
                    <div className="form-group">
                        <label htmlFor="txMotivo">Sexo</label>
                        <Select
                            placeholder="Selecione"
                            id="ASexoS"
                            name="ASexoS"
                            styles={colourStyles}
                            onChange={v => { setFieldValue("ASexoS", v.value) }}
                            onBlur={handleBlur}
                            value={displayitem(values.ASexoS ? values.ASexoS : '', Sexo)}
                            options={mapitems(Sexo ? Sexo : [], '')}
                            noOptionsMessage={() => "Sin opciones"}
                        />
                    </div>
                </div>
            </div>
        </div>
    )
}
