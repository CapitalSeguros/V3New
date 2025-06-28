import React, { useState, useEffect, useRef, forwardRef, useImperativeHandle } from 'react';
import { FComisiones, Comisiones, GetName, RecalcualateTotal, FormatItem, round, ShowLoading, FComisionesP, colourStyles, mapitems, displayitem, CComisiones, FocusInput, ComisionesRecibos } from '../../Helpers/FGeneral';
import { CallApiGet, CallApiPost, } from '../../Helpers/Calls';
import CurrencyInputField from 'react-currency-input-field';
import Select from "react-select";

const ModalComRevision = forwardRef((props, ref) => {
    useImperativeHandle(ref, () => {
        return {
            Reload: Reload
        }
    })

    useEffect(() => {
        //SetIdxItem(-1);
        //SetIdxItemH(-1); 
    }, [props]);

    const { ListaElementos, Monedas, ListaHonorarios, setState, state, Url, Tipo, ReloadHon, Modulo, Agentes, Vendedores, Documento, UrlServicio, InitialData } = props;
    function Reload() {
        //SetIdxItem(-1);
        //SetIdxItemH(-1);
    }

    function GetNameFormV2(value) {
        var rturn = '';
        var find = FComisiones.find(x => x.Id == value);
        if (find != null) {
            rturn = find.Nombre;
        }
        return rturn;
    }

    ///Edcion de comisiones
    //objeto paa modificar las comisiones
    var InitialModCom = {
        //IdRecibo: 0,
        Modulo: Modulo,
        IdDocto: 0,
        Id: 0,
        IDAgente: 0,
        TipoComision: 0,
        Formula: 0,
        Participacion: 0,
        Generada: null,
        Pendiente: null,
        TipoValor: '%',
        Creacion: moment().format("YYYY-MM-DD"),
        Registros: [],
        Total: 0,
        IsEdit: true
    }
    const [ObjCom, setObjCom] = useState(InitialModCom);
    //objeto paa modificar los honorarios
    const [ObjHon, setObjHon] = useState(InitialModCom);

    async function clicObjeto(item, tipo) {
        if (tipo == 1) {
            var obj = { ...InitialModCom };
            obj.Id = item.Id;
            obj.IsEdit = false;
            obj.IDAgente = item.Agente;
            obj.TipoComision = item.Formula;
            obj.Generada = item.Importe;
            obj.Participacion = item.Participacion;
            obj.Registros = [];
            setObjCom(obj);
            //CalculateObjCom();
        } else {
            var obj = { ...InitialModCom };
            obj.Id = item.Id;
            obj.IsEdit = false;
            obj.IDAgente = item.Id_vendedor;
            if (obj.TipoComision > 5) {
                obj.TipoComision = 1;
            } else {
                obj.TipoComision = item.Id_tipo_hon;
            }
            /* if(Modulo=="F"){
                obj.TipoComision = item.Id_tipo;
            }else{
                obj.TipoComision = item.Id_tipo_hon;
            } */
            obj.Formula = item.Id_formula;
            obj.Generada = item.ImporteCal;
            obj.Participacion = item.Porcentaje;
            obj.Registros = [];
            //setObjCom(obj);
            setObjHon(obj);
            //await getPagoHonIndividual(item.Id);
        }
    }


    function handleChangeCom(e, Campo = '') {
        if (Campo != '')
            setObjCom({ ...ObjCom, [Campo]: e });
        else
            setObjCom({ ...ObjCom, [e.target.name]: e.target.value });

    }

    function handleChangeHon(e, Campo = '') {
        if (Campo != '')
            setObjHon({ ...ObjHon, [Campo]: e });
        else
            setObjHon({ ...ObjHon, [e.target.name]: e.target.value });

    }

    function returnCantidadCom(Tipo, Porcentaje) {
        var rReturn = 0;
        var values = Documento;

        switch (parseInt(Tipo)) {
            case 1:
                rReturn = ((values.PrimaNeta ? values.PrimaNeta : 0) / 100) * (Porcentaje ? Porcentaje : 0);
                break;
            case 3:
                rReturn = ((values.Derechos ? values.Derechos : 0) / 100) * (Porcentaje ? Porcentaje : 0);
                break;
            case 4:
                rReturn = ((values.Recargos ? values.Recargos : 0) / 100) * (Porcentaje ? Porcentaje : 0);
                break;
            case 5:
                rReturn = ((values.GastosMaq ? values.GastosMaq : 0) / 100) * (Porcentaje ? Porcentaje : 0);
                break;

            default:
                break;
        }
        return round(rReturn, 2);
    }

    function returnCantidadHon(Tipo, Porcentaje) {
        var rReturn = 0;
        var values = Documento;
        var TipHon = ObjHon.TipoComision;
        //console.log("Tipo", Tipo)
        switch (parseInt(Tipo)) {
            case 1:
                rReturn = ((values.ComNeta ? values.ComNeta : 0) / 100) * (Porcentaje ? Porcentaje : 0);
                break;
            case 2:
                //console.log('entro');
                var Val1 = values.ComNeta ? values.ComNeta : 0;
                var Val2 = values.ComRec ? values.ComRec : 0;
                //console.log(`${Val1} | ${Val2}`);
                rReturn = ((Val1 + Val2) / 100) * (Porcentaje ? Porcentaje : 0);
                break;
            case 3:
                if (Modulo == "F") {
                    rReturn = ((values.CGastosMaquila ? values.CGastosMaquila : 0) / 100) * (Porcentaje ? Porcentaje : 0);
                } else {
                    var Val1 = values.ComDer ? values.ComDer : 0;
                    var Val2 = values.ComRec ? values.ComRec : 0;
                    rReturn = ((Val1 + Val2) / 100) * (Porcentaje ? Porcentaje : 0);
                }
                break;
            case 4:
                rReturn = ((values.ComRec ? values.ComRec : 0) / 100) * (Porcentaje ? Porcentaje : 0);
                break;
            case 5:
                rReturn = ((values.CGastosMaquila ? values.CGastosMaquila : 0) / 100) * (Porcentaje ? Porcentaje : 0);
                break;

            default:
                break;
        }
        if (parseInt(TipHon) > 99) {
            rReturn = (rReturn) * (-1);
        }
        return round(rReturn, 2);
    }

    function returnTotal(Tipo) {
        var rReturn = 0;
        var values = Documento;
        switch (parseInt(Tipo)) {
            case 1:
                rReturn = ((values.PrimaNeta ? values.PrimaNeta : 0));
                break;
            case 3:
                rReturn = ((values.Recargos ? values.Recargos : 0));
                break;
            case 4:
                rReturn = ((values.Derechos ? values.Derechos : 0));
                break;
            case 5:
                rReturn = ((values.GastosMaq ? values.GastosMaq : 0));
                break;


            default:
                break;
        }
        return round(rReturn, 2);
    }

    function CalculateObjCom() {
        var obj = { ...ObjCom };
        obj.Generada = returnCantidadCom(obj.TipoComision, parseFloat(obj.Participacion));
        setObjCom(obj);
    }

    function CalculateObtHon() {
        var obj = { ...ObjHon };
        obj.Generada = returnCantidadHon(obj.Formula, parseFloat(obj.Participacion));
        setObjHon(obj);
    }

    async function SaveHonObj(Tipo) {
        var obj = Tipo == 1 ? { ...ObjCom } : { ...ObjHon };
        var Lista = Tipo == 1 ? { ...ListaElementos } : { ...ListaHonorarios };
        var URL = Tipo == 1 ? `${UrlServicio}capture/saveorupdateobjcom` : `${UrlServicio}capture/saveorupdateobjhon`;
        ShowLoading();
        console.log(Documento);
        //obj.IdRecibo = Id;
        obj.IdDocto = Modulo != "E" ? Documento.IDDocto : Documento.IDEnd;
        if (Tipo == 1) {
            obj.Total = returnTotal(obj.TipoComision);
        } else {
            obj.Total = returnTotal(obj.TipoComision);
        }
        var dta = obj;
        //Validamos los tipos de Honorarios
        var Check = Validatebandas(Tipo, Lista, obj);
        if (Check) {
            ShowLoading(false);
            return toastr.error(`El porcentaje no puede ser mayor a 100%.`);

        }

        //console.log(Check);
        const res = await CallApiPost(URL, dta, null);
        if (res.status != 200) {
            toastr.error(`Error ${res.error.Mensaje}`);
        } else {
            toastr.success("Exíto");
            //setObjCom(InitialModCom)
            //await InitialData();
            if (Tipo == 1) {
                setObjCom(InitialModCom)
            } else {
                setObjHon(InitialModCom)
            }
            //await ReloadHon();
            await InitialData();
        }
        ShowLoading(false);
    }

    function Validatebandas(Tipo, Lista, Objeto) {
        //console.log("Tipo", Tipo)
        //console.log("Lista", Lista)
        //console.log("Objeto", Objeto)
        var Copy = [];
        const LElementos = Object.values(Lista);

        LElementos.forEach((elemento) => {
            Copy.push(elemento);
        });
        //console.log(Copy);
        var sumasPorTipo = 0;
        if (Objeto.Id == 0) {
            if (Tipo == 1) {
                Copy.push({
                    Tipo: Objeto.TipoComision,
                    Participacion: parseFloat(Objeto.Participacion)
                });
            } else {
                Copy.push({
                    Id_formula: Objeto.TipoComision,
                    participacion: parseFloat(Objeto.Participacion),
                    Id_tipo_hon: Objeto.TipoComision,
                });
            }
        }
        //console.log("Copy", Copy);
        if (Tipo == 1) {
            sumasPorTipo = Copy.reduce((acc, item) => ({
                ...acc,
                [item.Tipo]: (acc[item.Tipo] || 0) + item.Participacion,
            }), {});
        } else {
            sumasPorTipo = Copy.reduce((acc, item) => ({
                ...acc,
                [item.Id_formula]: (acc[item.Id_formula] || 0) + (item.participacion * (item.Id_tipo_hon == 100 ? -1 : 1)),
            }), {});
        }
        //console.log("Copy", Copy)
        //console.log(sumasPorTipo);
        return Object.values(sumasPorTipo).some(suma => suma > 100);
    }


    async function EliminarHonObj(Tipo) {
        var obj = { Id: Tipo == 1 ? ObjCom.Id : ObjHon.Id };
        var URL = Tipo == 1 ? `${UrlServicio}capture/deleteobjcom` : `${UrlServicio}capture/deleteobjhon`;
        swal({
            title: "¿Está seguro de que quiere eliminar el elemento seleccionado?",
            text: "Una vez eliminado, ¡no podrá recuperar el elemento!",
            icon: "warning",
            buttons: ["Cancelar", "Aceptar"],
        }).then(async (value) => {
            if (value) {
                ShowLoading();
                var dta = obj;
                const res = await CallApiPost(URL, dta, null);
                if (res.status != 200) {
                    toastr.error(`Error ${res.error.Mensaje}`);
                } else {
                    toastr.success("Exíto");
                    if (Tipo == 1) {
                        setObjCom(InitialModCom)
                    } else {
                        setObjHon(InitialModCom)
                    }
                    await InitialData();
                    //await ReloadHon();
                }
                ShowLoading(false);
            }
        });

    }

    async function RecalculoGeneral() {
        var obj = { Modulo: Modulo, IdDocto: Documento.IDDocto };
        var URL = `${UrlServicio}capture/recargaGeneral`;
        swal({
            title: "¿Está seguro de que quiere realizar el recalculo general?",
            text: "Una vez aplicado, ¡no podrá recuperar los anteriores datos!",
            icon: "warning",
            buttons: ["Cancelar", "Aceptar"],
        }).then(async (value) => {
            if (value) {
                ShowLoading();
                var dta = obj;
                const res = await CallApiPost(URL, dta, null);
                if (res.status != 200) {
                    toastr.error(`Error ${res.error.Mensaje}`);
                } else {
                    toastr.success("Exíto");
                    setObjCom(InitialModCom);
                    setObjHon(InitialModCom);
                    await InitialData();
                    //await ReloadHon();
                }
                ShowLoading(false);
            }
        });

    }


    return (
        <div id="ModalComH" className="modal fade" role="dialog">
            <div className="modalLarge modal-dialog modal-lg">
                <div className="modal-content">
                    <div className="modal-body">
                        <div className='row'>
                            <div className='col-md-12'>
                                <button type="button" className="close" data-dismiss="modal">&times;</button>
                            </div>
                        </div>
                        <div className='col-md-12'>
                            <div className='row'>
                                <div className='col-md-12'>
                                    <ul className="nav nav-tabs nav-justified" id="generalRecibos" role="tablist">
                                        <li className="nav-item navr">
                                            <a className="nav-link active" id="home-tab" data-toggle="tab" href="#com-generales" role="tab" aria-controls="com-generales" aria-selected="true">Comisiones de agentes</a>
                                        </li>
                                        <li className="nav-item navr">
                                            <a className="nav-link" id="com-recibo-tab" data-toggle="tab" href="#com-recibo" role="tab" aria-controls="com-recibo" aria-selected="false">Honorarios de vendedor</a>
                                        </li>
                                    </ul>
                                </div>
                                <div className='col-md-12'>
                                    <div className="tab-content" id="generalTabCom">
                                        <div className="tab-pane fade active show in" id="com-generales" role="tabpanel" aria-labelledby="com-generales-tab">
                                            <div className='row'>
                                                <div className='col-md-12'>
                                                    <table className="table StylesTables" id="comisionesagente">
                                                        <thead style={{ fontSize: '12px' }}>
                                                            <tr>
                                                                <th scope="col" style={{ width: '50%' }}>Agente</th>
                                                                <th scope="col">Tipo Agente</th>
                                                                <th scope="col">Tipo Comisión</th>
                                                                <th scope="col">Participación</th>
                                                                <th scope="col">Importe</th>
                                                                {/*   <th scope="col" style={{ width: '20%', textAlign: 'center' }}>Acciones</th> */}
                                                            </tr>
                                                        </thead>
                                                        <tbody>
                                                            {ListaElementos.length == 0 && (
                                                                <tr>
                                                                    <td className='text-center' colSpan={5}>NO EXISTEN CONFIGURACIONES</td>
                                                                </tr>
                                                            )}
                                                            {ListaElementos && ListaElementos.map((item, key) => (
                                                                <tr key={key} onClick={() => clicObjeto(item, 1)} style={item.Id == ObjCom.Id ? { cursor: 'pointer', backgroundColor: '#6f42c1', color: 'white' } : { cursor: 'pointer' }}>
                                                                    <td>{item.AgenteNombre}</td>
                                                                    <td>{item.TipoAgente}</td>
                                                                    <td>{item.TipoC}</td>
                                                                    <td>{item.Participacion}</td>
                                                                    <td>{FormatItem(item.Importe)}</td>
                                                                    {/*  <td style={{ textAlign: 'center' }}>
                                                                        <a className='btn btn-primary btn-sm' onClick={() => selectedItem(key, item)} data-toggle="tooltip" data-placement="bottom" title="Editar"><i className="fa fa-pencil" aria-hidden="true"></i></a>
                                                                    </td> */}
                                                                </tr>
                                                            ))}
                                                        </tbody>
                                                    </table>
                                                </div>
                                                <div className='col-md-12'>
                                                    <div className='row'>
                                                        <div className='col-md-6'>
                                                            <div className='row'>
                                                                <div className='col-md-12'>
                                                                    <h6>EDICIÓN DE COMISIONES</h6>
                                                                    <hr />
                                                                </div>
                                                                <div className='col-md-12 text-right'>
                                                                    <a className="btn btn-primary btn-s" type="submit" data-toggle="tooltip" data-placement="bottom" title="Nuevo" onClick={() => { setObjCom({ ...InitialModCom, IsEdit: false }) }}><i className="fa fa-plus" aria-hidden="true"></i></a>
                                                                    {ObjCom.Id > 0 && (
                                                                        <a className="btn btn-primary btn-s" type="submit" data-toggle="tooltip" data-placement="bottom" title="Eliminar" onClick={() => EliminarHonObj(1)}><i className="fa fa-trash" aria-hidden="true"></i></a>
                                                                    )}
                                                                    {!ObjCom.IsEdit && (
                                                                        <a className="btn btn-primary btn-s" type="submit" data-toggle="tooltip" data-placement="bottom" title="Cancelar" onClick={() => setObjCom({ ...InitialModCom, IsEdit: true })}><i className="fa fa-times-circle-o" aria-hidden="true"></i></a>
                                                                    )}
                                                                    <a className="btn btn-primary btn-s" disabled={ObjCom.Participacion > 0 ? false : true} type="submit" data-toggle="tooltip" data-placement="bottom" title="Guardar" onClick={() => SaveHonObj(1)}><i className="fa fa-floppy-o" aria-hidden="true"></i></a>
                                                                </div>
                                                            </div>
                                                            <div className='row'>
                                                                <div className='col-md-12'>
                                                                    <div className='form-group'>
                                                                        <label>Agente</label>
                                                                        <Select
                                                                            isDisabled={ObjCom.IsEdit}
                                                                            placeholder="Selecione"
                                                                            id="IDAgente"
                                                                            name="IDAgente"
                                                                            styles={colourStyles}
                                                                            onChange={v => {
                                                                                handleChangeCom(v.value, 'IDAgente')
                                                                            }}
                                                                            onBlur={() => { onblur }}
                                                                            value={displayitem(ObjCom.IDAgente, Agentes, 'Agente')}
                                                                            options={mapitems(Agentes ? Agentes : [], '')}
                                                                            noOptionsMessage={() => "Sin opciones"}
                                                                        />
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <div className='row'>
                                                                <div className='col-md-8'>
                                                                    <div className='form-group'>
                                                                        <label>Tipo Comisión</label>
                                                                        <Select
                                                                            isDisabled={ObjCom.IsEdit}
                                                                            placeholder="Selecione"
                                                                            id="TipoComision"
                                                                            name="TipoComision"
                                                                            styles={colourStyles}
                                                                            onChange={v => {
                                                                                handleChangeCom(v.value, 'TipoComision')
                                                                            }}
                                                                            onBlur={() => { CalculateObjCom() }}
                                                                            value={displayitem(ObjCom.TipoComision, CComisiones, 'Agente')}
                                                                            options={mapitems(CComisiones ? CComisiones : [], '')}
                                                                            noOptionsMessage={() => "Sin opciones"}

                                                                        />
                                                                    </div>
                                                                </div>
                                                                <div className='col-md-4'>
                                                                    <div className='form-group'>
                                                                        <label>Paticipación</label>
                                                                        {/* <input type="number" disabled={ObjCom.IsEdit} className='form-control input-sm numeric' value={ObjCom.Participacion} onChange={(v) => handleChangeCom(v.target.value, 'Participacion')} onBlur={() => CalculateObjCom()} name="Participacion" id="Participacion" /> */}
                                                                        <CurrencyInputField
                                                                            disabled={ObjCom.IsEdit}
                                                                            className='form-control input-sm numeric'
                                                                            onBlur={(e) => { CalculateObjCom() }}
                                                                            min={0}
                                                                            maxLength={10}
                                                                            //prefix='$'
                                                                            decimalsLimit={4}
                                                                            decimalScale={4}
                                                                            decimalSeparator='.'
                                                                            groupSeparator=','
                                                                            onFocus={FocusInput}
                                                                            allowNegativeValue={false}
                                                                            value={ObjCom.Participacion ? ObjCom.Participacion : '0'}
                                                                            onValueChange={(value, name) => { handleChangeCom(value, name) }}
                                                                            id='Participacion'
                                                                            name='Participacion'
                                                                            autoComplete='off'
                                                                        />
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <div className='row'>
                                                                <div className='col-md-6'>
                                                                    <div className='form-group'>
                                                                        <label>Generada</label>
                                                                        <CurrencyInputField
                                                                            className='form-control input-sm numeric'
                                                                            //onBlur={() => { handleBlur, ReloadAll(values, null) }}
                                                                            min={0}
                                                                            maxLength={10}
                                                                            disabled={true}
                                                                            //prefix='$'
                                                                            decimalSeparator='.'
                                                                            groupSeparator=','
                                                                            prefix=''
                                                                            decimalsLimit={2}
                                                                            decimalScale={2}
                                                                            onFocus={FocusInput}
                                                                            allowNegativeValue={false}
                                                                            value={ObjCom.Generada}
                                                                            //onValueChange={(value, name) => { ChangeValueRecibo(values, 'PrimaNeta', value, null) }}
                                                                            id='Generada'
                                                                            name='Generada'
                                                                            autoComplete='off'

                                                                        />
                                                                        {/*  <input type="text" className='form-control input-sm' value={ObjCom.Generada} name="Generada" id="Generada" disabled /> */}
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div className='col-md-6 text-right'>
                                                            <a className="btn btn-primary btn-s" style={{ marginTop: '25px' }} type="submit" data-toggle="tooltip" data-placement="bottom" title="Recalculo General" onClick={() => { RecalculoGeneral() }}><i className="fa fa-refresh" aria-hidden="true"></i> Recalculo General</a>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div className="tab-pane fade" id="com-recibo" role="tabpanel" aria-labelledby="com-recibo-tab-tab">
                                            <div className='row'>
                                                <div className='col-md-12'>
                                                    <table className="table" id="comisionesagente">
                                                        <thead style={{ fontSize: '12px' }}>
                                                            <tr>
                                                                <th scope="col">Vendedor</th>
                                                                <th scope="col" className='text-center'>Tipo valor</th>
                                                                <th scope="col" className='text-center'>Base calculo</th>
                                                                <th scope="col" className='text-center'>Participación</th>
                                                                <th scope="col" className='text-center'>Fórmula</th>
                                                                <th scope="col">Importe</th>
                                                                {/*   <th scope="col" style={{ textAlign: 'center' }}>Acciones</th> */}
                                                            </tr>
                                                        </thead>
                                                        <tbody>
                                                            {ListaHonorarios.length == 0 && (
                                                                <tr>
                                                                    <td className='text-center' colSpan={7}>NO EXISTEN CONFIGURACIONES</td>
                                                                </tr>
                                                            )}
                                                            {ListaHonorarios && ListaHonorarios.map((item, key) => (
                                                                <tr key={key} style={item.Id == ObjHon.Id ? { cursor: 'pointer', backgroundColor: '#6f42c1', color: 'white' } : { cursor: 'pointer' }} onClick={() => clicObjeto(item, 2)}>
                                                                    <td>{item.NombreCompleto}</td>
                                                                    <td className='text-center'>{item.TipoValor}</td>
                                                                    <td className='text-center'>{FormatItem(item.Base)}</td>
                                                                    <td className='text-center'>{item.Porcentaje}</td>
                                                                    <td className='text-center'>{GetNameFormV2(item.Id_formula)}</td>
                                                                    <td>{FormatItem(item.importe)}</td>
                                                                    {/* <td style={{ textAlign: 'center' }}>
                                                                        <a className='btn btn-primary btn-sm' onClick={() => selectedItemH(key, item)} data-toggle="tooltip" data-placement="bottom" title="Editar"><i className="fa fa-pencil" aria-hidden="true"></i></a>
                                                                    </td> */}
                                                                </tr>
                                                            ))}
                                                        </tbody>
                                                    </table>
                                                </div>
                                                <div className='col-md-12'>

                                                    <div className='row'>
                                                        <div className='col-md-6'>
                                                            <div className='row'>
                                                                <div className='col-md-12'>
                                                                    <h6>EDICIÓN DE HONORARIOS</h6>
                                                                    {/* <a onClick={() => $('#ModalAplicarHon').modal('show')} className='btn btn-primary'>test</a> */}
                                                                    <hr />
                                                                </div>
                                                                <div className='col-md-12 text-right'>
                                                                    <a className="btn btn-primary btn-s" type="submit" data-toggle="tooltip" data-placement="bottom" title="Nuevo" onClick={() => { setObjHon({ ...InitialModCom, IsEdit: false }) }}><i className="fa fa-plus" aria-hidden="true"></i></a>
                                                                    {ObjHon.Id > 0 && (
                                                                        <a className="btn btn-primary btn-s" type="submit" data-toggle="tooltip" data-placement="bottom" title="Eliminar" onClick={() => EliminarHonObj(2)}><i className="fa fa-trash" aria-hidden="true"></i></a>
                                                                    )}
                                                                    {!ObjHon.IsEdit && (
                                                                        <a className="btn btn-primary btn-s" type="submit" data-toggle="tooltip" data-placement="bottom" title="Cancelar" onClick={() => setObjHon({ ...InitialModCom, IsEdit: true })}><i className="fa fa-times-circle-o" aria-hidden="true"></i></a>
                                                                    )}
                                                                    <a className="btn btn-primary btn-s" disabled={ObjHon.Participacion > 0 ? false : true} type="submit" data-toggle="tooltip" data-placement="bottom" title="Guardar" onClick={() => SaveHonObj(2)}><i className="fa fa-floppy-o" aria-hidden="true"></i></a>

                                                                </div>
                                                            </div>
                                                            <div className='row'>
                                                                <div className='col-md-12'>
                                                                    <div className='form-group'>
                                                                        <label>Vendedor</label>
                                                                        <Select
                                                                            isDisabled={ObjHon.IsEdit}
                                                                            placeholder="Selecione"
                                                                            id="IDAgente"
                                                                            name="IDAgente"
                                                                            styles={colourStyles}
                                                                            onChange={v => {
                                                                                handleChangeHon(v.value, 'IDAgente')
                                                                            }}
                                                                            onBlur={() => { onblur }}
                                                                            value={displayitem(ObjHon.IDAgente, Vendedores, 'Agente')}
                                                                            options={mapitems(Vendedores ? Vendedores : [], '')}
                                                                            noOptionsMessage={() => "Sin opciones"}
                                                                        />
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <div className='row'>
                                                                <div className='col-md-8'>
                                                                    <div className='form-group'>
                                                                        <label>Tipo Honorario</label>
                                                                        <Select
                                                                            isDisabled={ObjHon.IsEdit}
                                                                            placeholder="Selecione"
                                                                            id="TipoComision"
                                                                            name="TipoComision"
                                                                            styles={colourStyles}
                                                                            onChange={v => {
                                                                                handleChangeHon(v.value, 'TipoComision')
                                                                            }}
                                                                            onBlur={() => { CalculateObtHon() }}
                                                                            value={displayitem(ObjHon.TipoComision, ComisionesRecibos, 'Agente')}
                                                                            options={mapitems(ComisionesRecibos ? ComisionesRecibos : [], '')}
                                                                            noOptionsMessage={() => "Sin opciones"}

                                                                        />
                                                                    </div>
                                                                </div>
                                                                <div className='col-md-4'>
                                                                    <div className='form-group'>
                                                                        <label>Tipo</label>
                                                                        <input type="text" disabled={true} className='form-control input-sm' value={ObjHon.TipoValor} />
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <div className='row'>
                                                                <div className='col-md-8'>
                                                                    <div className='form-group'>
                                                                        <label>Fórmula</label>
                                                                        <Select
                                                                            isDisabled={ObjHon.IsEdit}
                                                                            placeholder="Selecione"
                                                                            id="Formula"
                                                                            name="Formula"
                                                                            styles={colourStyles}
                                                                            onChange={v => {
                                                                                handleChangeHon(v.value, 'Formula')
                                                                            }}
                                                                            onBlur={() => { CalculateObtHon() }}
                                                                            value={displayitem(ObjHon.Formula, FComisiones, 'Agente')}
                                                                            options={mapitems(FComisiones ? FComisiones : [], '')}
                                                                            noOptionsMessage={() => "Sin opciones"}

                                                                        />
                                                                    </div>
                                                                </div>
                                                                <div className='col-md-4'>
                                                                    <div className='form-group'>
                                                                        <label>Paticipación</label>
                                                                        {/* <input type="number" disabled={ObjHon.IsEdit} className='form-control input-sm numeric' value={ObjHon.Participacion} onChange={(v) => handleChangeHon(v.target.value, 'Participacion')} onBlur={() => CalculateObtHon()} name="Participacion" id="Participacion" /> */}
                                                                        <CurrencyInputField
                                                                            disabled={ObjHon.IsEdit}
                                                                            className='form-control input-sm numeric'
                                                                            onBlur={(e) => { CalculateObtHon() }}
                                                                            min={0}
                                                                            maxLength={10}
                                                                            //prefix='$'
                                                                            decimalsLimit={4}
                                                                            decimalScale={4}
                                                                            decimalSeparator='.'
                                                                            groupSeparator=','
                                                                            onFocus={FocusInput}
                                                                            allowNegativeValue={false}
                                                                            value={ObjHon.Participacion ? ObjHon.Participacion : '0'}
                                                                            onValueChange={(value, name) => { handleChangeHon(value, name) }}
                                                                            id='Participacion'
                                                                            name='Participacion'
                                                                            autoComplete='off'
                                                                        />
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <div className='row'>
                                                                <div className='col-md-6'>
                                                                    <div className='form-group'>
                                                                        <label>Generada</label>
                                                                        <CurrencyInputField
                                                                            className='form-control input-sm numeric'
                                                                            //onBlur={() => { handleBlur, ReloadAll(values, null) }}
                                                                            min={0}
                                                                            maxLength={10}
                                                                            disabled={true}
                                                                            //prefix='$'
                                                                            decimalSeparator='.'
                                                                            groupSeparator=','
                                                                            prefix=''
                                                                            decimalsLimit={2}
                                                                            decimalScale={2}
                                                                            onFocus={FocusInput}
                                                                            allowNegativeValue={false}
                                                                            value={ObjHon.Generada}
                                                                            //onValueChange={(value, name) => { ChangeValueRecibo(values, 'PrimaNeta', value, null) }}
                                                                            id='Generada'
                                                                            name='Generada'
                                                                            autoComplete='off'

                                                                        />
                                                                        {/*  <input type="text" className='form-control input-sm' value={ObjCom.Generada} name="Generada" id="Generada" disabled /> */}
                                                                    </div>
                                                                </div>
                                                                {/* <div className='col-md-6'>
                                                                            <div className='form-group'>
                                                                                <label>Pendiente</label>
                                                                                <input type="text" className='form-control input-sm' value={ObjHon.Pendiente} name="Pendiente" id="Pendiente" disabled />
                                                                            </div>
                                                                        </div> */}
                                                            </div>
                                                        </div>
                                                        <div className='col-md-6 text-right'>
                                                            <a className="btn btn-primary btn-s" style={{ marginTop: '25px' }} type="submit" data-toggle="tooltip" data-placement="bottom" title="Recalculo General" onClick={() => { RecalculoGeneral() }}><i className="fa fa-refresh" aria-hidden="true"></i> Recalculo General</a>
                                                        </div>

                                                    </div>
                                                </div>
                                            </div>
                                        </div>
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
)
export default ModalComRevision;