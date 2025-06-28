import React, { useState, useEffect, useRef } from 'react';
import Select from "react-select";
import { Form, Formik } from "formik";
import { CallApiGet, CallApiPost } from '../../Helpers/Calls.js';
import { mapitems, mapitemsHijos, displayitem, colourStyles } from '../../Helpers/FGeneral.js';
import Honorarios from './Honorarios.jsx';
import BitacoraVend from './BitacoraVend.jsx';

export default function Vendedor(props) {
    const { callback, UrlServicio, UrlPagina } = props;
    const path = window.jQuery("#base_url").attr("data-base-url");
    const Id = window.jQuery("#idRegistro").val();
    const formikRef = useRef(null);

    const [vendedor, SetVendedor] = useState({});
    const [bitacora,SetBitacora]=useState([]);
    const [state, SetState] = useState({
        InitialData: {
            "TipoEntidad": [],
            "Estatus": [],
            "Gerencia": [],
            "Despacho": [],
            "TipoVendedor": [],
            "Vendedores": [],
            "Honorario": [],
            "Monedas": []
        }
    });



    useEffect(() => {
        if ($('body div').hasClass('pace')) {
            $("body div").removeClass("pace");
        }
        InitialData();
        if (Id != undefined) {
            InitialDataRegistro();
        }
    }, []);

    async function InitialData() {
        const res = await CallApiGet(`${UrlServicio}catalogos/getInitialDataVendedor`, {}, null);
        if (res.status != 200) {
            toastr.error(`Error, intente mas tarde. ${res.error}`);
        } else {
            SetState({
                ...state,
                InitialData: res.success.Datos
            })
        }
    }

    async function InitialDataRegistro() {
        const res = await CallApiGet(`${UrlServicio}catalogos/getSigleVendedor/${Id}`, {}, null);
        if (res.status != 200) {
            toastr.error(`Error, intente mas tarde. ${res.error}`);
        } else {
            SetVendedor(res.success.Datos);
        }
    }


    async function SaveData(data) {
        var dta = {
            "data": data,
            "Id": Id
        };

        const res = await CallApiPost(`${UrlServicio}catalogos/vendedores`, dta, null);
        if (res.status != 200) {
            toastr.error(`Error, intente mas tarde. ${res.error}`);
        } else {
            toastr.success("Exíto");
            if (Id === undefined) {
                window.location = `${UrlPagina}servicioSistema/VendedorEdit/${res.success.Datos.IDVend}`;
            }
        }
    }

    async function Bitacora(data) {
        var dta = {
            "Id": Id
        };

        const res = await CallApiGet(`${UrlServicio}catalogos/getBitacoraHon`, dta, null);
        if (res.status != 200) {
            toastr.error(`Error, intente mas tarde. ${res.error}`);
        } else {
            toastr.success("Exíto");
            SetBitacora(res.success.Datos);
            $("#ModalBitacora").modal('show');
            //console.log(res.success.Datos)
        }
    }

    return (
        <Formik
            innerRef={formikRef}
            initialValues={vendedor}
            enableReinitialize="true"
            onSubmit={(values, actions) => {
                //console.log("valores", values);
                SaveData(values);
            }}
        >
            {({
                values,
                errors,
                status,
                setFieldValue,
                handleBlur,
                handleChange,
                handleSubmit,
                isSubmitting
            }) => (
                <form onSubmit={handleSubmit} className="form" autoComplete="off" style={{ minHeight: '350px' }}>
                    <div className='row'>
                        <div className='col-md-12 labelSpecial'>
                            <h4>Datos Generales Del Vendedor</h4>
                            <div className='btn_aling_form'>
                                <button className="btn btn-primary btn-s" type="submit" data-toggle="tooltip" data-placement="bottom" title="Guardar"><i className="fa fa-floppy-o" aria-hidden="true"></i></button>
                                {Id != undefined && (
                                    <a className="btn btn-primary btn-s" type="submit" data-toggle="tooltip" data-placement="bottom" title="Comisiones" onClick={() => $('#ModalHonorarios').modal('show')}><i className="fa fa-briefcase" aria-hidden="true"></i></a>
                                )}
                                <a className="btn btn-primary btn-s" onClick={() => Bitacora()} data-toggle="tooltip" data-placement="bottom" title="Bitacora" ><i className="fa fa-file-text-o" aria-hidden="true"></i></a>
                                <a className="btn btn-primary btn-s" onClick={() => { window.location = `${UrlPagina}servicioSistema/Vendedores` }} data-toggle="tooltip" data-placement="bottom" title="Regresar" ><i className="fa fa-reply" aria-hidden="true"></i></a>
                            </div>
                            <hr />
                        </div>
                    </div>
                    <div className='row'>
                        <div className='col-md-3'>
                            <div className='form-group'>
                                <label>Tipo Entidad</label>
                                <Select
                                    placeholder="Selecione"
                                    id="TipoEntidad"
                                    name="TipoEntidad"
                                    styles={colourStyles}
                                    onChange={v => { setFieldValue("Id_tipoentidad", v.value) }}
                                    onBlur={handleBlur}
                                    value={displayitem(values.Id_tipoentidad, state.InitialData.TipoEntidad)}
                                    options={mapitems(state.InitialData.TipoEntidad ? state.InitialData.TipoEntidad : [], '')}
                                    noOptionsMessage={() => "Sin opciones"}
                                    title={"Dirección"}
                                />
                            </div>
                        </div>
                        <div className='col-md-3'>
                            <div className='form-group'>
                                <label>Estatus</label>
                                <Select
                                    placeholder="Selecione"
                                    id="Estatus"
                                    name="Estatus"
                                    styles={colourStyles}
                                    onChange={v => { setFieldValue("Id_estatus", v.value) }}
                                    onBlur={handleBlur}
                                    value={displayitem(values.Id_estatus, state.InitialData.Estatus)}
                                    options={mapitems(state.InitialData.Estatus ? state.InitialData.Estatus : [], '')}
                                    noOptionsMessage={() => "Sin opciones"}
                                    title={"Dirección"}
                                />
                            </div>
                        </div>
                        <div className='col-md-3'>
                            <div className='form-group'>
                                <label>Clave</label>
                                <input type="text" name='Clave' id='Clave' className='form-control' value={values.Clave ? values.Clave : ''} onChange={handleChange} />
                            </div>
                        </div>
                        <div className='col-md-3'>
                            <div className='form-group'>
                                <label>Tipo vendedor</label>
                                <Select
                                    placeholder="Selecione"
                                    id="Id_tipovendedor"
                                    name="Id_tipovendedor"
                                    styles={colourStyles}
                                    onChange={v => { setFieldValue("Id_tipovendedor", v.value), setFieldValue("TipoVend_Txt", v.label) }}
                                    onBlur={handleBlur}
                                    value={displayitem(values.Id_tipovendedor, state.InitialData.TipoVendedor)}
                                    options={mapitems(state.InitialData.TipoVendedor ? state.InitialData.TipoVendedor : [], '')}
                                    noOptionsMessage={() => "Sin opciones"}
                                    title={"Dirección"}
                                />
                            </div>
                        </div>
                    </div>
                    <div className='row'>
                        <div className='col-md-3'>
                            <div className='form-group'>
                                <label>Nombre</label>
                                <input type="text" name='NombreCompleto' id='NombreCompleto' className='form-control' value={values.NombreCompleto ? values.NombreCompleto : ''} onChange={handleChange} />
                            </div>
                        </div>
                        <div className='col-md-3'>
                            <div className='form-group'>
                                <label>Superior</label>
                                <Select
                                    placeholder="Selecione"
                                    id="Id_superior"
                                    name="Id_superior"
                                    styles={colourStyles}
                                    onChange={v => { setFieldValue("Id_superior", v.value) }}
                                    onBlur={handleBlur}
                                    value={displayitem(values.Id_superior, state.InitialData.Vendedores)}
                                    options={mapitems(state.InitialData.Vendedores ? state.InitialData.Vendedores : [], '')}
                                    noOptionsMessage={() => "Sin opciones"}
                                    title={"Dirección"}
                                />
                            </div>
                        </div>
                        <div className='col-md-3'>
                            <div className='form-group'>
                                <label>Alias</label>
                                <input type="text" name='Alias' id='Alias' className='form-control' value={values.Alias ? values.Alias : ''} onChange={handleChange} />
                            </div>
                        </div>
                        <div className='col-md-3'>
                            <div className='form-group'>
                                <label>Pertenece a Despacho</label>
                                <Select
                                    placeholder="Selecione"
                                    id="Id_despacho"
                                    name="Id_despacho"
                                    styles={colourStyles}
                                    onChange={v => { setFieldValue("Id_despacho", v.value) }}
                                    onBlur={handleBlur}
                                    value={displayitem(values.Id_despacho, state.InitialData.Despacho)}
                                    options={mapitems(state.InitialData.Despacho ? state.InitialData.Despacho : [], '')}
                                    noOptionsMessage={() => "Sin opciones"}
                                    title={"Dirección"}
                                />
                            </div>
                        </div>
                    </div>
                    <div className='row'>
                        <div className='col-md-3'>
                            <div className='form-group'>
                                <label>Gerencia</label>
                                <Select
                                    placeholder="Selecione"
                                    id="Id_gerencia"
                                    name="Id_gerencia"
                                    styles={colourStyles}
                                    onChange={v => { setFieldValue("Id_gerencia", v.value) }}
                                    onBlur={handleBlur}
                                    value={displayitem(values.Id_gerencia, state.InitialData.Gerencia)}
                                    options={mapitems(state.InitialData.Gerencia ? state.InitialData.Gerencia : [], '')}
                                    noOptionsMessage={() => "Sin opciones"}
                                    title={"Dirección"}
                                />
                            </div>
                        </div>
                        <div className='col-md-3'>
                            <div className='form-group'>
                                <label>Centro Costo</label>
                                <input type="text" name='CentroCosto' id='CentroCosto' className='form-control' value={values.CentroCosto ? values.CentroCosto : ''} onChange={handleChange} />
                            </div>
                        </div>
                        <div className='col-md-3'>
                            <div className='form-group'>
                                <label>Genera Emision</label>
                                <input type="checkbox" />
                            </div>
                        </div>
                        <div className='col-md-3'>
                            <div className='form-group'>
                                <label>Crear honorarios</label>
                                <input type="checkbox" />
                            </div>
                        </div>
                    </div>
                    <div className='row'>
                        <div className='col-md-3'>
                            <div className='form-group'>
                                <label>Resta en cascada</label>
                                <input type="checkbox" />
                            </div>
                        </div>
                        <div className='col-md-3'>
                            <div className='form-group'>
                                <label>Configuración de honorarios</label>
                                <Select
                                    placeholder="Selecione"
                                    id="Id_honorario"
                                    name="Id_honorario"
                                    styles={colourStyles}
                                    onChange={v => { setFieldValue("Id_honorario", v.value) }}
                                    onBlur={handleBlur}
                                    value={displayitem(values.Id_honorario, state.InitialData.Honorario)}
                                    options={mapitems(state.InitialData.Honorario ? state.InitialData.Honorario : [], '')}
                                    noOptionsMessage={() => "Sin opciones"}
                                    title={"Dirección"}
                                />
                            </div>
                        </div>
                    </div>
                    <Honorarios Url={UrlServicio} Vendedor={Id} Monedas={state.InitialData.Monedas} />
                    <BitacoraVend data={bitacora} />
                </form>
            )}
        </Formik>
    )
}
