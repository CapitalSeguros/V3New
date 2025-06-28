import React, { useState, forwardRef, useImperativeHandle, useRef } from 'react';
import { ShowLoading, FormatItem } from '../../Helpers/FGeneral.js';
import { CallApiGet, CallApiPost } from '../../Helpers/Calls.js';

const ModalCorteHon = forwardRef((props, ref) => {
    const { UrlServicio } = props;
    let Inicial = {
        FInicio: moment().startOf('month').format("YYYY-MM-DD"),
        FFin: moment().endOf('month').format("YYYY-MM-DD"),
        Busqueda: '',
        Opcion: 'EXPORTAR',
        Tipo: 'FULL',
        TipoExport: 'EXCEL',
        ListaCopia: [],
        Item: null,
        IndexItem: null,
        Usuarios: false,
        Asunto: '',
        Mensaje: ''
    }

    const [state, SetState] = useState(Inicial);
    const [usuarioCopia, SetUsuarioCopia] = useState('');
    const [indUser, SetindUser] = useState(0);
    const [tabla, SetTabla] = useState([]);
    const [usuariosC, SetUsuariosC] = useState([]);
    function handleChange(e, Campo = '') {
        //console.log(`${e} | ${Campo}`)
        if (Campo != '')
            SetState({ ...state, [Campo]: e });
        else
            SetState({ ...state, [e.target.name]: e.target.value });

        setTimeout(() => {
            $("#ModalCorteHon").modal('handleUpdate');
        }, 100)
    }

    useImperativeHandle(ref, () => {
        return {
            /*  Initial: (ID) => {
                 getInitial(ID)
             } */
            Initial: Initial
        }
    });

    function Initial() {
        SetState(Inicial);
        SetTabla([]);
        $("#ModalCorteHon").modal('show');
    }

    async function GetCortes() {
        ShowLoading();
        const res = await CallApiGet(`${UrlServicio}honorarios/honorariosCorte`, state, null);
        if (res.status != 200) {
            toastr.error(`Error ${res.error.Mensaje}`);
        } else {
            SetTabla(res.success.Datos);
            SetState({ ...state, IndexItem: null, Item: null });
        }
        ShowLoading(false);
    }

    function AddElement() {
        if (usuarioCopia == '') {
            return swal({
                title: "Agregar copia",
                text: "No se ha ingresado ningun elemento",
                icon: "warning",
                confirmButtonText: "Aceptar",
                confirmButtonColor: "#472380"
            });
        }
        state.ListaCopia.push(usuarioCopia);
        SetUsuarioCopia('');
        $("#ModalCorteHon").modal('handleUpdate');
    }

    function DeleteUser(Idx) {
        var cppy = [...state.ListaCopia];
        var New = cppy.filter((x, idx) => idx != Idx);
        SetState({ ...state, ListaCopia: New });
    }

    async function GetDocumento() {
        //var Qparams = new URLSearchParams(state);
        //console.log("Parametros", `${UrlServicio}?${Qparams}`);
        var Conversion = btoa(JSON.stringify(state));
        var accion = "";
        if (state.Opcion == "EXPORTAR") {
            if (state.TipoExport == "EXCEL") {
                accion = "honorarios/postDownloadHon";
            } else {
                accion = "honorarios/postDownloadHonPDF";
            }
            window.open(`${UrlServicio}${accion}?parametro=${Conversion}`, '_blank');
        } else {

            if (state.Asunto == "") {
                return swal({
                    title: "Asunto",
                    text: "El campo no puede ir vacio.",
                    icon: "warning",
                    confirmButtonText: "Aceptar",
                    confirmButtonColor: "#472380"
                });
            }
            if (state.Mensaje == "") {
                return swal({
                    title: "Mensaje",
                    text: "El campo no puede ir vacio.",
                    icon: "warning",
                    confirmButtonText: "Aceptar",
                    confirmButtonColor: "#472380"
                });
            }
            accion = "honorarios/postSendMail";
            const res = await CallApiPost(`${UrlServicio}${accion}`, { parametro: Conversion }, null);
            if (res.status != 200) {
                console.log(res.error);
                toastr.error(`${res.error.Mensaje}`);
            } else {
                SetState({
                    ...state,
                    Asunto: '',
                    Mensaje: '',
                    ListaCopia: []
                });
                toastr.success("Exíto");
            }
        }

    }

    async function GetUsersCorte(Item) {
        ShowLoading();
        var dta = {
            Documento: Item.Documento,
            Folio: Item.Folio,
            FDocumento: Item.FDocumento
        }
        const res = await CallApiGet(`${UrlServicio}honorarios/getUsersByCorte`, dta, null);
        if (res.status != 200) {
            toastr.error(`Error ${res.error.Mensaje}`);
        } else {
            SetUsuariosC(res.success.Datos);
            //SetTabla(res.success.Datos);
            //SetState({ ...state, IndexItem: null, Item: null });
        }
        ShowLoading(false);
    }



    function DownloadFile() {
        if (indUser > 0) {
            let data = { IDVend: indUser, Tipo: "FULL", Item: state.Item }
            var Conversion = btoa(JSON.stringify(data));
            window.open(`${UrlServicio}honorarios/postDownloadHonPDF?parametro=${Conversion}`, '_blank');
        } else {
            return swal({
                title: "Error",
                text: "Seleccione un vendedor.",
                icon: "warning",
                confirmButtonText: "Aceptar",
                confirmButtonColor: "#472380"
            });
        }
    }



    return (
        <div id="ModalCorteHon" className="modal fade" role="dialog">
            <div className="modalLarge modal-dialog modal-lg ">
                <div className="modal-content">
                    <div className='modal-body'>
                        <div className='row'>
                            <div className='col-md-12'>
                                <h6>Cortes de Honorarios</h6>
                            </div>
                        </div>
                        <div className='row pt-3'>
                            <div className="col-md-3">
                                <div className="form-group">
                                    <label>Desde</label>
                                    <input type="date" id="FInicio" name="FInicio" value={state.FInicio} onChange={handleChange} className="form-control input-sm" />
                                </div>
                            </div>
                            <div className="col-md-3">
                                <div className="form-group">
                                    <label>Hasta</label>
                                    <input type="date" id="FFin" name="FFin" value={state.FFin} onChange={handleChange} className="form-control input-sm" />
                                </div>
                            </div>
                            <div className="col-md-3">
                                <div className="form-group">
                                    <label>Busqueda</label>
                                    <input type="text" id="Busqueda" name="Busqueda" value={state.Busqueda} onChange={handleChange} className="form-control input-sm" />
                                </div>
                            </div>
                            <div className="col-md-3">
                                <a className="btn btn-primary" onClick={() => GetCortes()} style={{ marginTop: '20px', width: '100%' }}><i className="fa fa-file-text-o"></i> Generar Información</a>
                            </div>
                        </div>
                        <div className='row'>
                            <div className="col-md-12" style={{ maxHeight: '200px' }}>
                                <div className="table-wrapperH2" id="HonorariosCorte">
                                    <table className="table">
                                        <thead>
                                            <tr>
                                                <th scope="col" style={{ width: '20px' }}>Documento</th>
                                                <th scope="col" style={{ width: '20px' }}>Folio</th>
                                                <th scope="col" style={{ width: '20px' }}>Fecha Documento</th>
                                                <th scope="col" style={{ width: '20px' }}>Total Registros</th>
                                                <th scope="col" style={{ width: '20px' }}>Total Aplicado</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            {tabla.length == 0 && (
                                                <tr>
                                                    <td className='text-center' colSpan={5}>NO SE HA FILTRADO INFORMACIÓN</td>
                                                </tr>
                                            )}
                                            {tabla && tabla.map((item, key) => (

                                                <tr key={key} style={state.IndexItem == key ? { backgroundColor: '#8605df', color: '#ffffff', cursor: 'pointer' } : { cursor: 'pointer' }} onClick={() => { SetState({ ...state, Item: item, IndexItem: key }), GetUsersCorte(item) }}>
                                                    <td>{item.Documento}</td>
                                                    <td>{item.Folio}</td>
                                                    <td>{moment(item.FDocumento).format("DD/MM/YYYY")}</td>
                                                    <td>{item.TRegistros}</td>
                                                    <td>{FormatItem(item.TAplicado)}</td>
                                                </tr>
                                            ))}
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                        {state.Item != null && (
                            <div className='row'>
                                <div className='col-md-3'>
                                    <div className='row'>
                                        <div className='col-md-12'>
                                            <h6>Seleccione una acción:</h6>
                                        </div>
                                        <div className="col-md-12">
                                            <div className="radio ">
                                                <label htmlFor="EXPORTAR"><input type="radio" name="Opcion" id="EXPORTAR" value={state.Opcion ? state.Opcion : ''} onChange={(e) => handleChange("EXPORTAR", 'Opcion')} checked={state.Opcion == "EXPORTAR" ? true : false} />Exportar</label>
                                            </div>
                                            <div className="radio">
                                                <label htmlFor="ENVIO"><input type="radio" name="Opcion" id="ENVIO" value={state.Opcion ? state.Opcion : ''} onChange={(e) => { handleChange("ENVIO", 'Opcion'), $("#ModalCorteHon").modal('handleUpdate') }} checked={state.Opcion == "ENVIO" ? true : false} />Envio Correo</label>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div className='col-md-3'>
                                    <div className='row'>
                                        <div className='col-md-12'>
                                            <h6>Tipo de Información</h6>
                                        </div>
                                        <div className="col-md-12">
                                            <div className="radio">
                                                <label htmlFor="FULL"><input type="radio" name="Tipo" id="FULL" value={state.Tipo ? state.Tipo : ''} onChange={(e) => handleChange("FULL", 'Tipo')} checked={state.Tipo == "FULL" ? true : false} />Desglozado</label>
                                            </div>
                                            <div className="radio">
                                                <label htmlFor="NOTFULL"><input type="radio" name="Tipo" id="NOTFULL" value={state.Tipo ? state.Tipo : ''} onChange={(e) => handleChange("NOTFULL", 'Tipo')} checked={state.Tipo == "NOTFULL" ? true : false} />Individual</label>
                                            </div>
                                        </div>
                                    </div>
                                    {state.Opcion == "ENVIO" && (
                                        <div className='row'>
                                            <div className="col-md-12">
                                                <div className="radio">
                                                    <label htmlFor="FULLU"><input style={{ marginLeft: '-20px' }} type="checkbox" name="Usuarios" id="FULLU" value={state.Usuarios ? state.Usuarios : ''} onChange={(e) => handleChange(e.target.checked, 'Usuarios')} checked={state.Usuarios ? 'cheked' : ''} /> Usuarios Individual</label>
                                                </div>
                                            </div>
                                            {state.Usuarios && (
                                                <>
                                                    <div className='col-md-12'>
                                                        <div className='form-group'>
                                                            <label htmlFor="">Seleccione el usuario</label>
                                                            <select name="UsuarioC" id="UsuarioC" className='form-control' onChange={(e) => SetindUser(parseInt(e.target.value))}>
                                                                <option value="0">Seleccione uno</option>
                                                                {usuariosC.map((item, key) => (
                                                                    <option key={key} value={item.IDVend}>{item.VendNom}</option>
                                                                ))}
                                                            </select>
                                                        </div>
                                                    </div>
                                                    <div className='col-md-12'>
                                                        <button className='btn btn-sm btn-primary' style={{ width: '100%' }} onClick={() => DownloadFile()}> <i className='fa fa-file-text-o'></i> Descargar Individual</button>
                                                    </div>
                                                    <div className='col-md-12'>
                                                        <p style={{fontSize:'10px'}}><i className='fa fa-info-circle'></i> <em>Esta acción solo descarga un documento, no envia correo.</em></p>
                                                    </div>
                                                </>
                                            )}
                                        </div>
                                    )}
                                </div>
                                <div className='col-md-4'>
                                    {state.Opcion == "ENVIO" && (
                                        <div className='row'>
                                            <div className='col-md-12'>
                                                <div className='form-group'>
                                                    <label>Asunto</label>
                                                    <input type="text" id='Asunto' name='Asunto' className='form-control input-sm' value={state.Asunto ? state.Asunto : ''} onChange={handleChange} />
                                                </div>
                                            </div>
                                            <div className='col-md-12'>
                                                <div className='form-group'>
                                                    <label>Mensaje</label>
                                                    <textarea id='Mensaje' name='Mensaje' className='form-control input-sm' value={state.Mensaje ? state.Mensaje : ''} onChange={handleChange} >
                                                        {state.Mensaje ? state.Mensaje : ''}
                                                    </textarea>
                                                </div>
                                            </div>
                                            <div className='col-md-12 pb-3'>
                                                <h6>Agregar copia a :</h6>
                                            </div>
                                            <div className='col-md-12'>
                                                <div className='row'>
                                                    <div className='col-md-10'>
                                                        <input type="text" id='addElement' name='addElement' className='form-control' value={usuarioCopia} onChange={(e) => SetUsuarioCopia(e.target.value)} />
                                                    </div>
                                                    <div className='col-md-1'>
                                                        <a className="btn btn-primary" onClick={() => { AddElement() }} style={{ marginTop: '5px', marginLeft: '-10px' }}><i className="fa fa-plus"></i></a>
                                                    </div>
                                                </div>
                                            </div>
                                            <div className='col-md-12'>
                                                <div className='row'>
                                                    {state.ListaCopia.length == 0 && (
                                                        <div className='col-md-12'>No hay registros</div>
                                                    )}
                                                    {state.ListaCopia && state.ListaCopia.map((item, key) => (
                                                        <div key={key} className='col-md-12'>
                                                            <div style={{ display: 'inline' }}><i className="fa fa-envelope" aria-hidden="true"></i> {item}</div> <div onClick={() => DeleteUser(key)} style={{ textAlign: 'right', display: 'inline' }}><a className='btn btn-sm'><i className="fa fa-trash"></i></a></div>
                                                        </div>
                                                    ))}
                                                </div>
                                            </div>
                                        </div>
                                    )}
                                    {state.Opcion == "EXPORTAR" && (
                                        <div className='row'>
                                            <div className='col-md-12'>
                                                <h6>Exportar documento como</h6>
                                            </div>
                                            <div className="col-md-12">
                                                <div className="radio ">
                                                    <label htmlFor="EXCEL"><input type="radio" name="TipoExport" id="EXCEL" value={state.TipoExport ? state.TipoExport : ''} onChange={(e) => handleChange("EXCEL", 'TipoExport')} checked={state.TipoExport == "EXCEL" ? true : false} />EXCEL</label>
                                                </div>
                                                <div className="radio">
                                                    <label htmlFor="PDF"><input type="radio" name="TipoExport" id="PDF" value={state.TipoExport ? state.TipoExport : ''} onChange={(e) => handleChange("PDF", 'TipoExport')} checked={state.TipoExport == "PDF" ? true : false} />PDF</label>
                                                </div>
                                            </div>
                                        </div>
                                    )}

                                </div>
                                <div className='col-md-2'>
                                    <a className="btn btn-primary" data-toggle="tooltip" data-placement="bottom" title={state.Opcion == "EXPORTAR" ? 'DESCARGAR DOCUMENTO' : 'ENVIAR'} onClick={() => { GetDocumento() }} style={{ marginTop: '25px', width: '100%' }}><i className={state.Opcion == "EXPORTAR" ? 'fa fa-download' : 'fa fa-paper-plane'}></i></a>
                                </div>
                            </div>
                        )}
                    </div>
                    <div className='modal-footer'>
                        <a className="btn btn-secondary" style={{ backgroundColor: "#e8e8e8" }} data-dismiss="modal">Cerrar</a>
                    </div>
                </div>
            </div>
        </div>
    )
})

export default ModalCorteHon;
