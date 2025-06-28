import React, { useState } from 'react';
import Select from "react-select";
import axios from "axios";
import CurrencyInputField from 'react-currency-input-field';
import { UpperCaseField, round, FocusInput } from '../../Helpers/FGeneral';
import { CallApiPost } from '../../Helpers/Calls';

export default function DetalleFlotilla(props) {
    const { state, errors, handleBlur, displayitem, mapitems, mapitemsHijos, UrlServicio, values, ordenTrabajo, SetordenTrabajo } = props;
    const [opc, SetOpc] = useState(0);
    const [file, SetFile] = useState({
        selectedFile: null
    });
    const [errores, SetErrores] = useState([]);
    const validate = ['Serie'];
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
        //CleanObject();
        SetOpc(opc);
        //Asignar valores al formulario
        inciso['PDescuento'] = values.PDescuento ? values.PDescuento : 0;
        inciso['PorRecargos'] = values.PorRecargos ? values.PorRecargos : 0;
        inciso['PorIVA'] = values.PorIVA ? values.PorIVA : 0;
        inciso['Derechos'] = values.Derechos ? values.Derechos : 0;
        inciso['Ajuste'] = values.Ajuste ? values.Ajuste : 0;
        /* setTimeout(function () {
            $('#ModalFlotilla').modal('handleUpdate');
        }, 80); */
    }

    function handleChange(e, Campo = '', isArray = false) {
        if (Campo != '') {
            SetInciso({ ...inciso, [`${Campo}`]: e });
        }
        else
            SetInciso({ ...inciso, [e.target.name]: UpperCaseField(e.target.value) });

    }

    function CleanObject() {
        var Inciso = { ...inciso };
        Object.keys(Inciso).forEach(function (index) {
            Inciso[index] = "";
        });
        SetInciso(Inciso);
    }

    function ReloadPrices(values = null) {
        var Inciso = { ...inciso };
        console.log("INICISO", Inciso);
        var PNeta = parseFloat(Inciso.PrimaNeta ? Inciso.PrimaNeta : 0);
        var Derechos = parseFloat(Inciso.Derechos ? Inciso.Derechos : 0);
        if (values == null) {
            var PIVA = parseFloat(Inciso.PorIVA ? Inciso.PorIVA : 0);
            var PRecargos = parseFloat(Inciso.PorRecargos ? Inciso.PorRecargos : 0);
            var PDescuento = parseFloat(Inciso.PDescuento ? Inciso.PDescuento : 0);
            var Descuento = round(PNeta * (PDescuento / 100), 2);
            var Recargos = round(PNeta * (PRecargos / 100), 2);
            const SubTotal = (parseFloat(Recargos) + parseFloat(PNeta) + parseFloat(Derechos)) - parseFloat(Descuento);
            var IVA = round((PIVA / 100) * (SubTotal), 2);
            var PTotal = round(SubTotal + parseFloat(IVA), 2);
            Inciso.Descuento = Descuento;
            Inciso.Recargos = Recargos;
            Inciso.SubTotal = SubTotal;
            Inciso.IVA = parseFloat(IVA);
            Inciso.PrimaTotal = parseFloat(PTotal);
        } else {
            var Descuento = parseFloat(Inciso.Descuento ? Inciso.Descuento : 0);
            var Recargos = parseFloat(Inciso.Recargos ? Inciso.Recargos : 0);

            var PIVA = parseFloat(Inciso.PorIVA ? Inciso.PorIVA : 0);
            var PDescuento = round((Descuento * 100) / PNeta, 2);
            var PRecargos = round((Recargos * 100) / PNeta, 2);
            //console.log(`Subtotal||${Recargos}|${PNeta}|${Derechos}|${Descuento}|${IVA}`);
            const SubTotal = (parseFloat(Recargos) + parseFloat(PNeta) + parseFloat(Derechos)) - parseFloat(Descuento);
            //Nuevo procedimiento

            var IVA = parseFloat(Inciso.IVA ? Inciso.IVA : 0);
            var PorIVA = round((IVA / SubTotal) * 100, 2);
            // console.log(IVA);
            var PTotal = (SubTotal + round(parseFloat(IVA), 2));
            //console.log(`PTotal||${PTotal}||SubTotal ${SubTotal} || IVA ${IVA}`);

            Inciso.PDescuento = PDescuento;
            Inciso.PorRecargos = PRecargos;
            Inciso.SubTotal = SubTotal;
            Inciso.PrimaTotal = parseFloat(PTotal);
        }
        //console.log("INICISO",Inciso);
        SetInciso(Inciso);
    }



    async function Add() {
        var ErroresArray = await test();
        var Inciso = { ...inciso };
        Inciso['Documento'] = values.Documento;
        Inciso['IDDocto'] = values.IDDocto;
        var dta = {
            "data": Inciso,
        };
        if (ErroresArray.length == 0) {
            axios
                .post(`${UrlServicio}capture/saveFlotillas`, dta)
                .then(function (response) {
                    CleanObject();
                    var estado = { ...ordenTrabajo };
                    estado.Flotillas = response.data.Datos;
                    SetordenTrabajo(estado);
                    //SetListaInc(response.data.Datos);
                    SetOpc(0);
                });
        } else {
            return swal({
                title: "Llenar información",
                text: "No se ha ingresado todos los campos. ",
                icon: "warning",
                confirmButtonText: "Aceptar",
                confirmButtonColor: "#472380"
            });
        }
    }

    async function Delete(Id) {
        swal({
            title: "¿Está seguro de que quiere eliminar el registro seleccionado?",
            text: "Se realizará una eliminación completa de los datos.",
            icon: "warning",
            buttons: ["Cancelar", "Aceptar"],
        }).then(async (value) => {
            if (value) {
                var dta = {
                    Id: Id,
                    IDDocto: values.IDDocto
                };
                const res = await CallApiPost(`${UrlServicio}capture/deleteFlotillas`, dta, null);
                //console.log(res);
                if (res.status != 200) {
                    return toastr.error(`Error ${res.error.Mensaje}`);
                } else {
                    var estado = { ...ordenTrabajo };
                    estado.Flotillas = res.success.Datos;
                    SetordenTrabajo(estado);

                    toastr.success("Exíto");
                }
            }
        });
    }

    function EditElement(element) {
        SetInciso(element);
        SetOpc(1);
    }

    function ParseItem(value) {
        if (value == undefined) {
            value = '0000-00-00';
        }
        var check = moment(value, 'YYYY-MM-DD').isValid();//2024-04-14 00:00:00
        var _return = 'N/A';
        if (check) {
            _return = moment(value).format('DD/MM/YYYY');
        }
        return _return;
    }

    const onFileChange = (event) => {
        // Update the state
        SetFile({
            selectedFile: event.target.files[0],
        });
    };

    function sendFlotillasFiles() {
        const formData = new FormData();

        // Update the formData object
        formData.append(
            "myFile",
            file.selectedFile,
            file.selectedFile.name
        );
        formData.append("IDDocto", values.IDDocto);
        formData.append("Documento", values.Documento);

        axios
            .post(`${UrlServicio}capture/saveFlotillasFile`, formData)
            .then(function (response) {
                var estado = { ...ordenTrabajo };
                estado.Flotillas = response.data.Datos;
                SetordenTrabajo(estado);
                //SetListaInc(response.data.Datos);
                SetOpc(0);
            });

    }

    async function test() {
        var VForm = $("#FlotillaForm").serializeArray();
        var Errores = [];
        validate.forEach(element => {
            var FindElement = VForm.find(x => x.name == element);
            if (FindElement != null) {
                if (FindElement.value == "") {
                    //console.log('Requerido');
                    Errores.push(element);
                }
            }
        });
        SetErrores(Errores);
        return Errores;
    }

    return (
        <div className="tab-pane fade" id="detalle-flotilla" role="tabpanel" aria-labelledby="detalle-flotilla-tab">
            <div className='row'>
                <div className='col-md-12  text-right'>
                    <a className='btn btn-primary btn-s' disabled={values.IsSavedPoliza == null ? true : false} data-toggle="tooltip" data-placement="bottom" title="Lista" onClick={() => changeOpc(0)}><i className="fa fa-list" aria-hidden="true"></i></a>
                    <a className='btn btn-primary btn-s' disabled={values.IsSavedPoliza == null ? true : false} data-toggle="tooltip" data-placement="bottom" title="Nuevo" onClick={() => changeOpc(1)}><i className="fa fa-plus" aria-hidden="true"></i></a>
                    <a className='btn btn-primary btn-s' disabled={values.IsSavedPoliza == null ? true : false} data-toggle="tooltip" data-placement="bottom" title="Importar" onClick={() => console.log("errore", inciso)}><i className="fa fa-file" aria-hidden="true"></i></a>
                    <a className='btn btn-primary btn-s' disabled={values.IsSavedPoliza == null ? true : false} data-toggle="tooltip" data-placement="bottom" title="Guardar" onClick={() => Add()}><i className="fa fa-floppy-o" aria-hidden="true"></i></a>
                </div>
            </div>
            <div className={opc == 0 ? 'row' : 'row hidden'}>
                <div className={'col-md-12 mt-2'}>
                    <div className='table-responsive'>
                        <table className="table table-condensed" id="incisos">
                            <thead style={{ fontSize: '12px' }}>
                                <tr>
                                    <th>Inciso</th>
                                    <th>Tipo</th>
                                    <th>Serie</th>
                                    <th>Fecha Alta</th>
                                    <th>Docto baja</th>
                                    <th>Fecha baja</th>
                                    <th>Referencia</th>
                                    <th></th>
                                </tr>
                            </thead>
                            <tbody>
                                {ordenTrabajo.Flotillas.length == 0 && (
                                    <tr>
                                        <td className='text-center' colSpan={8}>NO SE HAN AGREGADO LOS INCISOS</td>
                                    </tr>
                                )}
                                {ordenTrabajo.Flotillas && ordenTrabajo.Flotillas.map((item, key) => (
                                    <tr key={key}>
                                        <td>{item.NumInc ? item.NumInc : 'N/A'}</td>
                                        <td>{item.Tipo ? item.Tipo : 'N/A'}</td>
                                        <td>{item.Serie ? item.Serie : 'N/A'}</td>
                                        <td>{ParseItem(item.FAlta)}</td>
                                        <td>{item.DoctoBaja ? item.DoctoBaja : 'N/A'}</td>
                                        <td>{ParseItem(item.FBaja)}</td>
                                        <td>{item.Referencia ? item.Referencia : 'N/A'}</td>
                                        <td>
                                            <a className='btn btn-primary btn-sm' onClick={() => EditElement(item)} data-toggle="tooltip" data-placement="bottom" title="Editar Flotilla" ><i className="fa fa-pencil" aria-hidden="true"></i></a>
                                            <a className='btn btn-primary btn-sm' onClick={() => Delete(item.IDTemp)} data-toggle="tooltip" data-placement="bottom" title="Eliminar Flotilla" ><i className="fa fa-trash" aria-hidden="true"></i></a>
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
                            <a className="nav-link" id="home-tab" data-toggle="tab" href="#cobertura-flotilla" role="tab" aria-controls="cobertura-flotilla" aria-selected="true">Carga Masiva</a>
                        </li>
                    </ul>
                </div>
                <div className='col-md-12'>
                    <div className="tab-content" id="FlotillaGeneralTabContent">
                        <div className="tab-pane fade active show in" id="detalle-general-flotilla" role="tabpanel" aria-labelledby="detalle-general-flotilla-tab">
                            <form id='FlotillaForm'>
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
                                                onFocus={FocusInput}
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
                                                onFocus={FocusInput}
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
                                                onFocus={FocusInput}
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
                                                value={displayitem(inciso.Conductor, [])}
                                                options={mapitems(state.InitialData.TipoDocumento ? [] : [], '')}
                                                noOptionsMessage={() => "Sin opciones"}
                                            />
                                        </div>
                                    </div>
                                    <div className='col-md-6 unsetPadding'>
                                        <div className="form-group">
                                            <label htmlFor="txMotivo">Dirección</label>
                                            <textarea className='form-control'
                                                onChange={handleChange}
                                                onFocus={FocusInput}
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
                                                onChange={v => {
                                                    handleChange(v.value, 'Marca') /* setTimeout(() => {
                                                    handleChange(1, 'SubMarca')
                                                }, 5000) */
                                                }}
                                                onBlur={handleBlur}
                                                value={displayitem(inciso.Marca, state.InitialData.Marca)}
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
                                                id="SubMarca"
                                                name="SubMarca"
                                                styles={colourStyles}
                                                onChange={v => { handleChange(v.value, 'SubMarca') }}
                                                onBlur={handleBlur}
                                                value={displayitem(inciso.SubMarca, state.InitialData.SubMarca)}
                                                options={mapitemsHijos(state.InitialData.SubMarca ? state.InitialData.SubMarca : [], inciso.Marca)}
                                                //options={mapitems(state.InitialData.SubMarca ? state.InitialData.SubMarca : [], '')}
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
                                                        onFocus={FocusInput}
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
                                                        onChange={v => { handleChange(v.value, 'Transmision') }}
                                                        onBlur={handleBlur}
                                                        value={displayitem(inciso.Transmision, state.InitialData.Transmision)}
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
                                                    <input
                                                        className="form-control input-sm"
                                                        type="text"
                                                        name="Puertas"
                                                        id="Puertas"
                                                        onFocus={FocusInput}
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
                                                        onFocus={FocusInput}
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
                                                        onFocus={FocusInput}
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
                                                onFocus={FocusInput}
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
                                                onFocus={FocusInput}
                                                onChange={(e) => { handleChange(e), test() }}
                                                value={inciso.Serie ? inciso.Serie : ''}
                                            />
                                            <span className="help-block">{errores.includes('Serie') ? 'Requerido' : ''}</span>
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
                                                onFocus={FocusInput}
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
                                                onFocus={FocusInput}
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
                                                onChange={v => { handleChange(v.value, 'Cochera') }}
                                                onBlur={handleBlur}
                                                value={displayitem(inciso.Cochera, state.InitialData.Cochera)}
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
                                                id="EstadoCircula"
                                                name="EstadoCircula"
                                                styles={colourStyles}
                                                onChange={v => { handleChange(v.value, 'EstadoCircula') }}
                                                onBlur={handleBlur}
                                                value={displayitem(inciso.EstadoCircula, state.InitialData.Estados)}
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
                                                id="Color"
                                                name="Color"
                                                styles={colourStyles}
                                                onChange={v => { handleChange(v.value, 'Color') }}
                                                onBlur={handleBlur}
                                                value={displayitem(inciso.Color, state.InitialData.Color)}
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
                                                onFocus={FocusInput}
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
                                                onChange={v => { handleChange(v.value, 'Servicio') }}
                                                onBlur={handleBlur}
                                                value={displayitem(inciso.Servicio, state.InitialData.Servicio)}
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
                                                id="UsoVehiculo"
                                                name="UsoVehiculo"
                                                styles={colourStyles}
                                                onChange={v => { handleChange(v.value, 'UsoVehiculo') }}
                                                onBlur={handleBlur}
                                                value={displayitem(inciso.UsoVehiculo, state.InitialData.UsoServicio)}
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
                                                id="Inspeccion"
                                                name="Inspeccion"
                                                styles={colourStyles}
                                                onChange={v => { handleChange(v, 'Inspeccion') }}
                                                onBlur={handleBlur}
                                                value={displayitem(inciso.Inspeccion, state.InitialData.Inspeccion)}
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
                                                onChange={handleChange}
                                                onFocus={FocusInput}
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
                                                onFocus={FocusInput}
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
                                                value={displayitem(inciso.CiaLocalizacion, state.InitialData.CiaLocalizacion)}
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
                                                name="SerieLocalizador"
                                                id="SerieLocalizador"
                                                onChange={handleChange}
                                                onFocus={FocusInput}
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
                                                onFocus={FocusInput}
                                                value={inciso.EqEsp ? inciso.EqEsp : ''}
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
                                                value={inciso.EqEspSAseg ? inciso.EqEspSAseg : '0'}
                                                onValueChange={(value, name) => { handleChange(value, name) }}
                                                id='EqEspSAseg'
                                                name='EqEspSAseg'
                                                autoComplete='off'
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
                                                name="Adap"
                                                id="Adap"
                                                onChange={handleChange}
                                                onFocus={FocusInput}
                                                value={inciso.Adap ? inciso.Adap : ''}
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
                                                onFocus={FocusInput}
                                                allowNegativeValue={false}
                                                value={inciso.AdapSAseg ? inciso.AdapSAseg : '0'}
                                                onValueChange={(value, name) => { handleChange(value, name) }}
                                                id='AdapSAseg'
                                                name='AdapSAseg'
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
                                                name="RDescripcion"
                                                id="RDescripcion"
                                                onChange={handleChange}
                                                onFocus={FocusInput}
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
                                                onFocus={FocusInput}
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
                                                onFocus={FocusInput}
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
                                                name="RModelo"
                                                id="RModelo"
                                                onChange={handleChange}
                                                onFocus={FocusInput}
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
                                                onFocus={FocusInput}
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
                                                onFocus={FocusInput}
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
                                                name="RSerie"
                                                id="RSerie"
                                                onChange={handleChange}
                                                onFocus={FocusInput}
                                                value={inciso.RSerie ? inciso.RSerie : ''}
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
                                                onFocus={FocusInput}
                                                allowNegativeValue={false}
                                                value={inciso.RSumaAsegurada ? inciso.RSumaAsegurada : '0'}
                                                onValueChange={(value, name) => { handleChange(value, name) }}
                                                id='RSumaAsegurada'
                                                name='RSumaAsegurada'
                                                autoComplete='off'
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
                                                        onBlur={() => { handleBlur, ReloadPrices(null) }}
                                                        min={0}
                                                        maxLength={10}
                                                        //prefix='$'
                                                        decimalSeparator='.'
                                                        groupSeparator=','
                                                        onFocus={FocusInput}
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
                                                        onBlur={() => { handleBlur, ReloadPrices('') }}
                                                        min={0}
                                                        maxLength={10}
                                                        //prefix='$'
                                                        decimalSeparator='.'
                                                        groupSeparator=','
                                                        onFocus={FocusInput}
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
                                                        onBlur={() => { handleBlur, ReloadPrices(null) }}
                                                        min={0}
                                                        maxLength={10}
                                                        //prefix='$'
                                                        decimalSeparator='.'
                                                        groupSeparator=','
                                                        onFocus={FocusInput}
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
                                                        onBlur={() => { handleBlur, ReloadPrices('') }}
                                                        min={0}
                                                        maxLength={10}
                                                        //prefix='$'
                                                        decimalSeparator='.'
                                                        groupSeparator=','
                                                        onFocus={FocusInput}
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
                                                        onBlur={() => { handleBlur, ReloadPrices(null) }}
                                                        min={0}
                                                        maxLength={10}
                                                        //prefix='$'
                                                        decimalSeparator='.'
                                                        groupSeparator=','
                                                        onFocus={FocusInput}
                                                        allowNegativeValue={false}
                                                        value={inciso.PorRecargos ? inciso.PorRecargos : '0'}
                                                        onValueChange={(value, name) => { handleChange(value, name) }}
                                                        id='PorRecargos'
                                                        name='PorRecargos'
                                                        autoComplete='off'
                                                    />
                                                </div>
                                            </div>
                                            <div className='col-md-2 unsetPadding'>
                                                <div className='form-group'>
                                                    <label className='col-form-label titulo'>Derechos</label>
                                                    <CurrencyInputField
                                                        className='form-control input-sm numeric'
                                                        onBlur={() => { handleBlur, ReloadPrices(null) }}
                                                        min={0}
                                                        maxLength={10}
                                                        //prefix='$'
                                                        decimalSeparator='.'
                                                        groupSeparator=','
                                                        onFocus={FocusInput}
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
                                                        disabled={true}
                                                        //onBlur={() => { handleBlur, ReloadPrices(values) }}
                                                        min={0}
                                                        maxLength={10}
                                                        //prefix='$'
                                                        decimalSeparator='.'
                                                        groupSeparator=','
                                                        onFocus={FocusInput}
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
                                                        onBlur={() => { handleBlur, ReloadPrices('IVA') }}
                                                        min={0}
                                                        maxLength={10}
                                                        //prefix='$'
                                                        decimalSeparator='.'
                                                        groupSeparator=','
                                                        onFocus={FocusInput}
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
                                                        onBlur={() => { handleBlur, ReloadPrices(null) }}
                                                        min={0}
                                                        maxLength={10}
                                                        //prefix='$'
                                                        decimalSeparator='.'
                                                        groupSeparator=','
                                                        onFocus={FocusInput}
                                                        allowNegativeValue={false}
                                                        value={inciso.PorIVA ? inciso.PorIVA : '0'}
                                                        onValueChange={(value, name) => { handleChange(value, name) }}
                                                        id='PorIVA'
                                                        name='PorIVA'
                                                        autoComplete='off'
                                                    />
                                                </div>
                                            </div>
                                            <div className='col-md-3 unsetPadding'>
                                                <div className='form-group'>
                                                    <label className='col-form-label titulo'>Ajuste</label>
                                                    <CurrencyInputField
                                                        className='form-control input-sm numeric'
                                                        onBlur={() => { handleBlur, ReloadPrices(null) }}
                                                        min={0}
                                                        maxLength={10}
                                                        //prefix='$'
                                                        decimalSeparator='.'
                                                        groupSeparator=','
                                                        onFocus={FocusInput}
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
                                                        disabled={true}
                                                        min={0}
                                                        maxLength={10}
                                                        //prefix='$'
                                                        decimalSeparator='.'
                                                        groupSeparator=','
                                                        onFocus={FocusInput}
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
                                                        onFocus={FocusInput}
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
                                                        onFocus={FocusInput}
                                                        onChange={handleChange}
                                                        value={inciso.FAlta ? moment(inciso.FAlta).format("YYYY-MM-DD") : ''}
                                                    />
                                                </div>
                                            </div>
                                            <div className="w-100 d-none d-md-block"></div>
                                            <div className='col-md-4 unsetPadding'>
                                                <div className='form-group'>
                                                    <label className='col-form-label titulo'>Docto Baja</label>
                                                    <input
                                                        className="form-control input-sm"
                                                        type="text"
                                                        name="DoctoBaja"
                                                        id="DoctoBaja"
                                                        onFocus={FocusInput}
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
                                                        onFocus={FocusInput}
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
                                                        onFocus={FocusInput}
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
                                                onFocus={FocusInput}
                                                value={inciso.Referencia ? inciso.Referencia : ''}
                                            />
                                        </div>
                                    </div>
                                </div>
                            </form>
                        </div>
                        <div className="tab-pane fade" id="cobertura-flotilla" role="tabpanel" aria-labelledby="cobertura-flotilla-tab">
                            <div className='row'>
                                <div className='col-md-10'>
                                    <div className='form-group'>
                                        <input className='form-control' onChange={onFileChange} type="file" name="flotilla_doc" id="flotilla_doc" />
                                    </div>
                                </div>
                                <div className='col-md-2'>
                                    <a className='btn btn-sm btn-primary' onClick={() => sendFlotillasFiles()}> Cargar documento</a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    )
}
