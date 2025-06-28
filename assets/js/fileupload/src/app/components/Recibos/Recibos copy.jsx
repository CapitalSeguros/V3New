import React, { useState, useEffect, useRef } from 'react';
import { Formik, validateYupSchema } from "formik";
import CurrencyInputField from 'react-currency-input-field';
import { CallApiGet, CallApiPost } from '../../Helpers/Calls.js';
import { validationSchemaPoliza } from '../../Helpers/Validations.js';
import { ShowLoading, FocusInput, LockEnter, colourStyles, colourStylesCustomRecibos, FComisiones, CComisiones, FComisionesP, mapitems, displayitem, UpperCaseField, round, Comisiones, ComisionesRecibos } from '../../Helpers/FGeneral.js';
import Select from "react-select";
import ModalLiquidar from './ModalLiquidar.jsx';
import DetallePrimas from './DetallePrimas.jsx';
import DetalleComisiones from './DetalleComisiones.jsx';

export default function Recibos(props) {
    const path = window.jQuery("#base_url").attr("data-base-url");
    const Id = window.jQuery("#idRegistro").val();
    const Documento = window.jQuery("#documento").val();
    const Modulo = window.jQuery("#modulo").val();
    const LoggedUser = window.jQuery("#Usuario").val();
    const { callback, UrlServicio, UrlPagina } = props;
    const formikRef = useRef(null);
    const formikModalRef = useRef(null);
    const formikModalRefPHon = useRef(null);
    const [IsChange, SetIsChange] = useState(false);
    const [TComisines, SetTComisones] = useState(0);
    const ModalLiquidarRef = useRef(null);

    const [recibo, setRecibo] = useState({
        IDTemp: '',
        IDDocto: '',
        IDRecibo: '',
        IDEnd: '',
        Documento: '',
        IncisoDoc: '',
        Endoso: '',
        Periodo: '',
        Serie: '',
        FDesde: '',
        FHasta: '',
        FRecepcion: '',
        FEnvio: '',
        FEmision: '',
        FolioRec: '',
        FLimPago: '',
        Status: '',
        PrimaNeta: '',
        Descuento: '',
        ExtraPrima: '',
        Recargos: '',
        PorRecargos: '',
        Derechos: '',
        GastosAdm: '',
        IVA: '',
        PorIVA: '',
        PrimaTotal: '',
        ComN: '',
        PComN: '',
        ComR: '',
        PComR: '',
        ComD: '',
        PComD: '',
        Comision1: '',
        Comision2: '',
        Comision3: '',
        Comision4: '',
        Comision5: '',
        Comision6: '',
        Comision7: '',
        Comision8: '',
        TCPago: '',
        FGeneracion: '',
        SubTotal: '',
        Ajuste: '',
        FCreacion: '',
        PDescuento: '',
        Especial: '',
        PEspecial: '',
        Status_TXT: '',
        FEstatus: '',
        GastosMaq: '',
        CGastosMaq: '',
        PCGastosMaq: '',
        CGastosAdm: '',
        PCGastosAdm: '',
        PorDescuento: '',
        STotal: '',
        Modulo: '',
        FDocto: '',
        IdVend: ''
    });
    const [ItemInfoRecibo, SetItemInfoRecibo] = useState({
        Documento: '',
        IDTemp: '',
        IDMon: '',
        IDVend: '',
        IDSSRamo: '',
        IDSubGrupo: '',
        IDCli: '',
        ComRec: '',
        ComDer: '',
        NPagos: '',
        Cliente: '',
        Ejecutivo: '',
        Vendedor: '',
        EjecutivoCobranza: '',
        Ramo: '',
        Agente: '',
        Moneda: '',
        FormaPago: ''
    });
    const [pagos, setPagos] = useState([]);
    const [comisiones, setComisiones] = useState([]);
    const [honorarios, setHonorarios] = useState([]);
    const [Endosos, setEndosos] = useState([]);
    var objPago = {
        Id: '',
        IdRecibo: Id,
        Documento: Documento,
        FechaPago: moment().format("YYYY-MM-DD"),
        FolioCheque: '',
        IdTipoDocumento: '',
        DTipoDocumento: '',
        IdBanco: '',
        DBanco: '',
        NoDocumento: '',
        FechaDocumento: moment().format("YYYY-MM-DD"),
        IdTipoPago: '',
        DTipoPago: '',
        ImportePago: '0',
        ImporteReal: '0',
        IdMonedaPago: '',
        DMonedaPago: '',
        IdMonedaDcto: '',
        DMonedaDcto: '',
        Fecha1: moment().format("YYYY-MM-DD"),
        Fecha2: moment().format("YYYY-MM-DD"),
        Fecha3: moment().format("YYYY-MM-DD"),
        TipoCambio1: '',
        TipoCambio2: '',
        PrimaPendiente: '0',
        NoLiq: '',
        FolioLiqCia: '',
        FLiq: '',
        ConfirmacionLiq: false,
        FConfirmacion: '',
        IdEstatus: 3,
        Estatus: 'Pendiente',
        UsuarioAplica: '',
        FechaAplica: '',
        UsuarioLiq: '',
        FechaLiquidacion: ''
    }

    var objSelectedPago = {
        Id: '',
        IdRecibo: '',
        Documento: '',
        FechaPago: '',
        FolioCheque: '',
        IdTipoDocumento: '',
        DTipoDocumento: '',
        IdBanco: '',
        DBanco: '',
        NoDocumento: '',
        FechaDocumento: '',
        IdTipoPago: '',
        DTipoPago: '',
        ImportePago: '',
        ImporteReal: '',
        IdMonedaPago: '',
        DMonedaPago: '',
        IdMonedaDcto: '',
        DMonedaDcto: '',
        Fecha1: '',
        Fecha2: '',
        TipoCambio1: '',
        TipoCambio2: '',
        PrimaPendiente: '',
        NoLiq: '',
        FolioLiqCia: '',
        FLiq: '',
        ConfirmacionLiq: '',
        FConfirmacion: '',
        IdEstatus: '',
        Estatus: '',
        UsuarioAplica: '',
        FechaAplica: '',
        UsuarioLiq: '',
        FechaLiquidacion: ''
    }
    const [PHon, SetPHon] = useState(objPago);
    const [pago, setPago] = useState(objPago);
    const [selectedPago, setSelectedPago] = useState(objSelectedPago);
    const [InitialDataInfo, setInitialDataInfo] = useState({
        TipoDocumento: [],
        Monedas: [],
        TipoPago: [],
        TipoDocto: [],
        Bancos: [],
        Vendedores: [],
        Agentes: [],
    });
    const [disabled, setDisabled] = useState(true);
    const [pagoO, setPagoO] = useState(objPago);

    //objeto paa modificar las comisiones
    var InitialModCom = {
        IdRecibo: 0,
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

    const [AjusteAnteriorGuardado, SetAjusteAnteriorGuardado] = useState(0);
    const [tipoEndosoGuardado, SetTipoEndosoGuardado] = useState(1);
    const [moduloOrigen, SetModuloOrigen] = useState("");

    const [isEditar, setIsEditar] = useState(false);

    async function InitialData() {
        var complemento = {};
        var URL = ``;

        URL = `${UrlServicio}conciliacion/getrecibobyid`;
        complemento = {
            Id: Id,
            Documento: Documento,
            Modulo: Modulo,
        }

        const res = await CallApiGet(URL, complemento, null);

        if (res.status != 200) {
            toastr.error(`Error ${res.error.Mensaje}`);
        } else {

            SetAjusteAnteriorGuardado(res.success.Datos.Recibo.Ajuste || 0);

            SetTipoEndosoGuardado(res.success.Datos.Endosos ? res.success.Datos.Endosos.TipoE : 1);

            let _moduloOrigen = res.success.Datos.Padre && res.success.Datos.Padre.IDSRamo < 5 ? "P" : res.success.Datos.Padre && res.success.Datos.Padre.IDSRamo > 4 && "F";
            SetModuloOrigen(_moduloOrigen);

            setTimeout(() => {
                setRecibo(prevState => ({
                    ...prevState,
                    ...res.success.Datos.Recibo
                }));
                TotalComisiones(res.success.Datos.Recibo);

                SetItemInfoRecibo(prevState => ({
                    ...prevState,
                    ...res.success.Datos.ItemInfoRecibo
                }));

                ConvertImporte(res.success.Datos.Recibo, res.success.Datos.Comisiones, "C");
                ConvertImporte(res.success.Datos.Recibo, res.success.Datos.Honorarios, "H")
                //setHonorarios();
                //setComisiones(res.success.Datos.Comisiones);

                setEndosos(res.success.Datos.Endosos);
            }, 50);

        }
    }

    async function GetInitialDataPago() {
        var complemento = {};
        var URL = ``;

        URL = `${UrlServicio}conciliacion/initialdatapago?modulo=${Modulo}`;
        // complemento = {
        //     Id: Id,
        //     Modulo: Modulo,
        // }

        const res = await CallApiGet(URL, complemento, null);

        if (res.status != 200) {
            toastr.error(`Error ${res.error.Mensaje}`);
        } else {
            setTimeout(() => {
                setInitialDataInfo(res.success.Datos);
            }, 50);

        }
    }

    async function GetPago() {
        var complemento = {};
        var URL = ``;

        URL = `${UrlServicio}conciliacion/getpagobyreciboid`;
        complemento = {
            IdRecibo: Id,
        }

        const res = await CallApiGet(URL, complemento, null);

        if (res.status != 200) {
            setPagos([]);
            setPago(objPago);
            setPagoO(objPago);
            setSelectedPago(objSelectedPago);

        } else {
            setTimeout(() => {
                setPagos([res.success.Datos]);

                let _pago = { ...res.success.Datos };
                _pago.FechaPago = moment(_pago.FechaPago).format('YYYY-MM-DD');
                _pago.FechaDocumento = moment(_pago.FechaDocumento).format('YYYY-MM-DD');
                _pago.Fecha1 = moment(_pago.Fecha1).format('YYYY-MM-DD');
                _pago.Fecha2 = moment(_pago.Fecha2).format('YYYY-MM-DD');
                setPago(prevState => ({
                    ...prevState,
                    ...Object.fromEntries(
                        Object.entries(_pago).map(([key, value]) => [
                            key,
                            value === null ? '' : value
                        ])
                    )
                }));

                setPagoO(prevState => ({
                    ...prevState,
                    ...Object.fromEntries(
                        Object.entries(_pago).map(([key, value]) => [
                            key,
                            value === null ? '' : value
                        ])
                    )
                }));

                let _selectedPago = { ...res.success.Datos };
                _selectedPago.PrimaEnviada = res.success.Datos.ImportePago;
                _selectedPago.PrimaTotal = res.success.Datos.ImporteReal;
                _selectedPago.PrimaPagada = res.success.Datos.ImportePago;
                _selectedPago.PrimaPendiente = res.success.Datos.ImporteReal - res.success.Datos.ImportePago;

                _selectedPago.FechaPago = moment(_selectedPago.FechaPago).format('YYYY-MM-DD');
                _selectedPago.FechaDocumento = moment(_selectedPago.FechaDocumento).format('YYYY-MM-DD');

                setSelectedPago(prevState => ({
                    ...prevState,
                    ...Object.fromEntries(
                        Object.entries(_selectedPago).map(([key, value]) => [
                            key,
                            value === null ? '' : value
                        ])
                    )
                }));

            }, 50);

        }
    }

    async function SaveData(values) {
        ShowLoading();
        values.DTipoDocumento = displayitem(values.IdTipoDocumento, InitialDataInfo.TipoDocto).length > 0 ? displayitem(values.IdTipoDocumento, InitialDataInfo.TipoDocto)[0].label : '';
        values.DTipoPago = displayitem(values.IdTipoPago, InitialDataInfo.TipoPago).length > 0 ? displayitem(values.IdTipoPago, InitialDataInfo.TipoPago)[0].label : '';
        values.DMonedaPago = displayitem(values.IdMonedaPago, InitialDataInfo.Monedas).length > 0 ? displayitem(values.IdMonedaPago, InitialDataInfo.Monedas)[0].label : '';
        values.DMonedaDcto = displayitem(values.IdMonedaDcto, InitialDataInfo.Monedas).length > 0 ? displayitem(values.IdMonedaDcto, InitialDataInfo.Monedas)[0].label : '';
        values.DBanco = displayitem(values.IdBanco, InitialDataInfo.Bancos).length > 0 ? displayitem(values.IdBanco, InitialDataInfo.Bancos)[0].label : '';

        values.ConfirmacionLiq = null;
        values.FLiq = null;
        values.FConfirmacion = null;
        values.FechaLiquidacion = null;

        if (values.Id > 0) {

        }
        else {
            values.UsuarioAplica = LoggedUser;
            values.FechaAplica = moment().format('YYYY-MM-DD h:mm');
        }

        var dta = {
            objeto: values
        };

        const res = await CallApiPost(`${UrlServicio}conciliacion/saveorupdatepago`, dta, null);
        if (res.status != 200) {
            swal({
                title: "Advertencia",
                //html:res.error.Mensaje,
                text: "No se guardó el pago.",
                icon: "warning",
                confirmButtonText: "Aceptar",
                confirmButtonColor: "#472380"
            });
            //toastr.error(`Error ${res.error.Mensaje}`);
        } else {
            toastr.success("Éxito");
            $("#ModalRPago").modal('hide');
            await ReloadPageInfo();
            //window.location = UrlPagina + `servicioSistema/recibo/` + Id + "/" + Documento + "/" + Modulo;
        }
        ShowLoading(false);
    }

    async function AnularPago() {
        if (recibo.Status_TXT == 'Aplicado') {
            ShowLoading();
            var complemento = {};
            var URL = ``;

            URL = `${UrlServicio}conciliacion/anularpago`;
            complemento = {
                objeto: {
                    IdRecibo: Id,
                    Documento: Documento
                }
            }

            const res = await CallApiPost(URL, complemento, null);
            if (res.status != 200) {
                toastr.error(`Error ${res.error.Mensaje}`);
            } else {
                toastr.success("Éxito");
                await ReloadPageInfo();
                //window.location = UrlPagina + `servicioSistema/recibo/` + Id + "/" + Documento + "/" + Modulo;
            }
            ShowLoading(false);
        }
    }

    async function Liquidar() {
        //$('#ModalLiquidar').modal('show');
        ModalLiquidarRef.current.Open();
    }

    async function AplicarLiquidar(Fecha) {
        if (recibo.Status_TXT == 'Aplicado') {
            ShowLoading();
            var lsHonorarios = [];
            var lsComisiones = [];

            honorarios.map(x => {
                var honorario = {
                    Id: 0,
                    IdRecibo: Id,
                    Pagado: 1,
                    Documento: recibo.Documento,
                    Endoso: recibo.Endoso,
                    FDesde: recibo.FDesde,
                    Serie: recibo.Serie,
                    TipoComision: x.Formula,
                    //TipoComision: '%',
                    TipoValor: x.TipoValor,
                    Participacion: x.Porcentaje,
                    PrimaNeta: recibo.PrimaNeta,
                    //Importe: ImporteHonorarios(x, "honorario"),
                    Importe: x.ImporteCal,
                    MonedaDoc: pago.DMonedaDcto,
                    IDMon: pago.IdMonedaDcto,
                    TCDocumento: pago.TipoCambio2,
                    TCPago: pago.TipoCambio1,
                    ImportePago: pago.ImporteReal ? pago.ImporteReal : 0,
                    Cliente: ItemInfoRecibo.Cliente,
                    IDCli: ItemInfoRecibo.IDCli,
                    IDCia: ItemInfoRecibo.IDCia,
                    Compañia: ItemInfoRecibo.CiaNombre,
                    FormaPago: ItemInfoRecibo.FormaPago,
                    FEstatus: moment().format('YYYY-MM-DD'),
                    //FAplicado: moment().format('YYYY-MM-DD'),
                    FAplicado: moment(Fecha).format('YYYY-MM-DD'),
                    IDMonPago: pago.IdMonedaPago,
                    MonedaPago: pago.DMonedaPago,
                    IDVend: x.Id_vendedor,
                    VendNom: x.NombreCompleto,
                    Tipo: x.Id_formula,
                    //ImporteConvertido: ConvertirImporte(ImporteHonorarios(x, "honorario"))
                    ImporteConvertido: (ConvertirImporte(x.ImporteCal)),
                    IdRef: x.Id
                }

                lsHonorarios.push(honorario);
            })

            comisiones.map(x => {
                var comision = {
                    Id: 0,
                    IdRecibo: Id,
                    Pagado: 1,
                    Documento: recibo.Documento,
                    Endoso: recibo.Endoso,
                    FDesde: recibo.FDesde,
                    Serie: recibo.Serie,
                    TipoComision: x.TipoC,
                    //TipoComision: x.TipoComision,
                    TipoValor: '%',
                    Participacion: x.Participacion,
                    PrimaNeta: recibo.PrimaNeta,
                    Aplicado: pago.ImporteReal,
                    //Importe: ImporteHonorarios(x, "comision"),
                    Importe: x.ImporteCal,
                    MonedaDoc: pago.DMonedaDcto,
                    Monedapago: pago.DMonedaPago,
                    IDMonDoc: pago.IdMonedaDcto,
                    IDMonPago: pago.IdMonedaPago,
                    TipoAgente: x.TipoAgente,
                    TCDocumento: pago.TipoCambio2,
                    TCPago: pago.TipoCambio1,
                    ImportePago: pago.ImporteReal ? pago.ImporteReal : 0,
                    Cliente: ItemInfoRecibo.Cliente,
                    IDCli: ItemInfoRecibo.IDCli,
                    IDCia: ItemInfoRecibo.IDCia,
                    Compañia: ItemInfoRecibo.CiaNombre,
                    FormaPago: ItemInfoRecibo.FormaPago,
                    FEstatus: moment().format('YYYY-MM-DD'),
                    //FAplicado: moment().format('YYYY-MM-DD'),
                    FAplicado: moment(Fecha).format('YYYY-MM-DD'),
                    IDVend: 0,
                    VendNom: x.AgenteNombre,
                    Tipo: x.Formula,
                    //ImporteConvertido: ConvertirImporte(ImporteHonorarios(x, "comision"))
                    ImporteConvertido: ConvertirImporte(x.ImporteCal),
                    IdRef: x.Id
                }

                lsComisiones.push(comision);
            })

            let fecha = moment(Fecha).format('YYYY-MM-DD');

            let _pago = { ...pago };
            _pago.NoLiq = moment().format('YYYYMMDDHHmmssSSS');
            _pago.FLiq = fecha;
            _pago.ConfirmacionLiq = 1;
            _pago.FConfirmacion = fecha;
            _pago.IdEstatus = 6;
            _pago.Estatus = 'Liquidado';
            _pago.UsuarioLiq = LoggedUser;
            _pago.FechaLiquidacion = moment().format('YYYY-MM-DD');
            //_pago.FechaLiquidacion = moment().format('YYYY-MM-DD h:mm');

            var dta = {
                pago: _pago,
                honorarios: lsHonorarios,
                comisiones: lsComisiones
            };

            const res = await CallApiPost(`${UrlServicio}conciliacion/liquidarpago`, dta, null);
            if (res.status != 200) {
                swal({
                    title: "Advertencia",
                    //html:res.error.Mensaje,
                    text: "No se pudo liquidar el pago.",
                    icon: "warning",
                    confirmButtonText: "Aceptar",
                    confirmButtonColor: "#472380"
                });
            } else {
                $("#ModalLiquidar").modal('hide');
                toastr.success("Éxito");
                await ReloadPageInfo();
                //window.location = UrlPagina + `servicioSistema/recibo/` + Id + "/" + Documento + "/" + Modulo;
            }
            ShowLoading(false);
        }
    }

    async function DesliquidarPago() {
        if (recibo.Status_TXT == 'Liquidado') {
            ShowLoading();
            var complemento = {};
            var URL = ``;

            URL = `${UrlServicio}conciliacion/desliquidarpago`;
            complemento = {
                objeto: {
                    IdRecibo: Id,
                    Documento: Documento,
                    Id: pago.Id
                }
            }

            const res = await CallApiPost(URL, complemento, null);
            if (res.status != 200) {
                toastr.error(`Error ${res.error.Mensaje}`);
            } else {
                toastr.success("Éxito");
                await ReloadPageInfo();
                //window.location = UrlPagina + `servicioSistema/recibo/` + Id + "/" + Documento + "/" + Modulo;
            }
            ShowLoading(false);
        }
    }

    function HaveChange(e) {
        SetIsChange(true);
    }

    function FormatItem(value) {
        var _return = parseFloat(value ? value : 0);
        return (_return).toLocaleString('es-MX', { style: 'currency', currency: 'MXN' })
    }

    function GetNameFormV2(value) {
        var rturn = '';
        var find = Modulo == 'P' ? FComisionesP.find(x => x.Id == value) : FComisiones.find(x => x.Id == value);;
        if (find != null) {
            rturn = find.Nombre;
        }
        return rturn;
    }

    function ConvertirImporte(value) {
        /* if (ItemInfoRecibo.IDMon > 1) {
            var TC = getFieldById(ItemInfoRecibo.IDMon, 'TipoCambio', 'MONEDAS');
            if (TC && TC > 0) {
                return parseFloat(value * TC);
            }
            else {
                return parseFloat(value);
            }
        }

        return parseFloat(value); */
        return round(parseFloat(value), 2) * round(parseFloat(pagoO.TipoCambio2), 2);
    }

    async function AplicarPago(origen) {
        if (recibo.Status_TXT == 'Pendiente' && origen === 'Aplicar' || recibo.Status_TXT == 'Aplicado' && origen === 'Editar') {
            ShowLoading();
            formikModalRef.current.resetForm();

            let _recibo = { ...recibo };
            let _pago = { ...pagoO };

            if (_pago.Id > 0) {

            }
            else {
                _pago.ImportePago = _recibo.PrimaTotal;
                _pago.ImporteReal = _recibo.PrimaTotal;
                _pago.IdMonedaDcto = ItemInfoRecibo.IDMon;
                _pago.IdMonedaPago = ItemInfoRecibo.IDMon;

                _pago.TipoCambio1 = getFieldById(ItemInfoRecibo.IDMon, 'TipoCambio', 'MONEDAS');
                _pago.TipoCambio2 = getFieldById(ItemInfoRecibo.IDMon, 'TipoCambio', 'MONEDAS')

            }
            setPago(prevState => ({
                ...prevState,
                ..._pago
            }));
            ShowLoading(false);
            $("#ModalRPago").modal('show');
        }
    }

    const getFieldById = (id, field, tipo) => {
        if (tipo === "MONEDAS") {
            const item = InitialDataInfo.Monedas.find(item => item.Id === id);
            return item ? item[field] : null;
        }

        return null;
    };

    function setTipoCambio(name, setFieldValue, id, field, tipo) {
        if (tipo === "MONEDAS") {
            const item = InitialDataInfo.Monedas.find(item => item.Id === id);
            setFieldValue(name, item ? item[field] : null);
        }
    }

    async function ReloadPageInfo() {
        ShowLoading();
        await InitialData();
        await GetInitialDataPago();
        await GetPago();

        ShowLoading(false);
    }

    function ReloadAll(values, tipo) {
        //let elm = { ...recibo };
        // var PTotal = values.PrimaNeta ? values.PrimaNeta : 0;
        // var RTotal = values.Recargos ? values.Recargos : 0;
        // var RDerecho = values.Derechos ? values.Derechos : 0;
        // var TMaq = values.GastosMaquila ? values.GastosMaquila : 0;
        // var Adm = values.GastosAdmin ? values.GastosAdmin : 0;
        // var PAcmu = 0; var RAcmu = 0; var DAcmu = 0; var MaqAcmu = 0; var AdmAcmu = 0;

        // elm.PrimaNeta = round((PTotal - PAcmu), 2);
        // elm.Recargos = round((RTotal - RAcmu), 2);
        // elm.Derechos = round((RDerecho - DAcmu), 2);
        // elm.GastosMaq = round((TMaq - MaqAcmu), 2);
        // elm.GastosAdm = round((Adm - AdmAcmu), 2);

        let elm = ReloadIndividual(values, tipo);

        setRecibo(elm);
    }

    function ReloadIndividual(elm, Accion = null) {
        const values = elm;
        if (Modulo === "F") {
            var PNeta = round(parseFloat(values.PrimaNeta ? values.PrimaNeta : 0), 2);
            var GastosMaquila = round(parseFloat(values.GastosMaq ? values.GastosMaq : 0), 2);
            var GastosAdmin = round(parseFloat(values.GastosAdm ? values.GastosAdm : 0), 2);
            var Derechos = round(parseFloat(values.Derechos ? values.Derechos : 0), 2);//IDSRamo
            var PIVA = parseFloat(values.PorIVA ? values.PorIVA : 0);
            //var PIVA = parseFloat(0);

            if (Accion == null) {
                //var PRecargos = parseFloat(values.PorRecargos ? values.PorRecargos : 0);
                //var Derechos = parseFloat(values.Derechos ? values.Derechos : 0);
                var PDescuento = parseFloat(values.PDescuento ? values.PDescuento : 0);
                var PDerechos = parseFloat(values.PDerecho ? values.PDerecho : 0);

                //Varibales calculables
                var Descuento = round(PNeta * (PDescuento / 100), 2);
                //var Derechos = (PNeta * (PDerechos / 100)).toFixed(2);

                const SubTotal = parseFloat(PNeta) + parseFloat(Derechos) + parseFloat(GastosMaquila) + parseFloat(GastosAdmin) - parseFloat(Descuento);

                var IVA = round((PIVA / 100) * SubTotal, 2);
                var PTotal = round(SubTotal + parseFloat(IVA), 2);
                //Actualizmaos Prima
                elm.Descuento = Descuento;
                elm.Derechos = Derechos;
                elm.SubTotal = round(SubTotal, 2);
                elm.IVA = parseFloat(IVA);
                elm.PrimaTotal = parseFloat(PTotal);

                //Actualizamos Comisiones
                var PorComincion = parseFloat(values.PComN ? values.PComN : 0);
                var Comision = round(PNeta * (PorComincion / 100), 2);
                var PorDerechos = parseFloat(values.PComD ? values.PComD : 0);
                var PDerechos = round(parseFloat(Derechos * (PorDerechos / 100)), 2);
                var PGastosMaquila = parseFloat(values.PCGastosMaq ? values.PCGastosMaq : 0);
                var GastosMaquilaC = round(GastosMaquila * (PGastosMaquila / 100), 2);//PorRecargos
                var PGastosAdmin = parseFloat(values.PCGastosAdmin ? values.PCGastosAdmin : 0);
                var GastosAdminC = round(GastosAdmin * (PGastosAdmin / 100), 2);//PorRecargos
                var PorEspecial = parseFloat(values.PEspecial ? values.PEspecial : 0);
                var Especial = round(parseFloat(PNeta * (PorEspecial / 100)), 2);

                elm.ComN = parseFloat(Comision);
                elm.CGastosMaq = parseFloat(GastosMaquilaC);
                elm.CGastosAdm = parseFloat(GastosAdminC);
                elm.ComD = parseFloat(PDerechos);
                elm.Especial = parseFloat(Especial);
            } else {

                var Descuento = parseFloat(values.Descuento ? values.Descuento : 0);
                var Derechos = parseFloat(values.Derechos ? values.Derechos : 0);
                //Varibales calculables
                var PDescuento = round((Descuento * 100) / PNeta, 2);
                var PDerechos = round((Derechos * 100) / PNeta, 2);
                const SubTotal = parseFloat(PNeta) + parseFloat(Derechos) - parseFloat(Descuento) + parseFloat(GastosMaquila) + parseFloat(GastosAdmin);
                //var IVA = round((PIVA / 100) * SubTotal, 2);
                var IVA = parseFloat(values.IVA ? values.IVA : 0);
                var PTotal = round(SubTotal + parseFloat(IVA), 2);

                //Asignar los primeros valores
                elm.PDescuento = PDescuento;
                elm.PDerecho = PDerechos;
                elm.SubTotal = SubTotal;
                //Array.IVA = parseFloat(IVA);
                var PorIVA = round((IVA / SubTotal) * 100, 2);
                elm.PrimaTotal = parseFloat(PTotal);

                //Actualizamos Comisiones
                var ComNeta = parseFloat(values.ComN ? values.ComN : 0);
                var PComNeta = round((ComNeta * 100) / PNeta, 2);
                var ComDer = parseFloat(values.ComDer ? values.ComDer : 0);
                var PComDer = round((ComDer * 100) / PNeta, 2);
                var CGastosMaquila = parseFloat(values.CGastosMaq ? values.CGastosMaq : 0); 800
                var PCGastosMaquila = round((CGastosMaquila * 100) / GastosMaquila, 2);
                var CGastosAdmin = parseFloat(values.CGastosAdm ? values.CGastosAdm : 0);
                var PCGastosAdmin = round((CGastosAdmin * 100) / GastosAdmin, 2);
                var Especial = parseFloat(values.Especial ? values.Especial : 0);
                var PEspecial = round((Especial * 100) / PNeta, 2);

                elm.PorIVA = parseFloat(PorIVA);
                elm.PComN = parseFloat(PComNeta);
                elm.PComDer = parseFloat(PComDer);
                elm.PCGastosMaq = parseFloat(PCGastosMaquila);
                elm.CGastosAdm = parseFloat(PCGastosAdmin);
                elm.PEspecial = parseFloat(PEspecial);
            }
            return values;
        }
        else if (Modulo === "P") {
            var Ramo = parseFloat(elm.IDSRamo ? elm.IDSRamo : 0);
            var PNeta = parseFloat(values.PrimaNeta ? values.PrimaNeta : 0);
            var Derechos = parseFloat(values.Derechos ? values.Derechos : 0);
            if (Accion == null) {
                var PIVA = parseFloat(values.PorIVA ? values.PorIVA : 0);
                var PRecargos = parseFloat(values.PorRecargos ? values.PorRecargos : 0);
                var PDescuento = parseFloat(values.PDescuento ? values.PDescuento : 0);

                //Varibales calculables
                var Descuento = round(PNeta * (PDescuento / 100), 2);
                var Recargos = round(PNeta * (PRecargos / 100), 2);

                const SubTotal = parseFloat(Recargos) + parseFloat(PNeta) + parseFloat(Derechos) - parseFloat(Descuento);
                var IVA = round((PIVA / 100) * (SubTotal), 2);
                var PTotal = round(SubTotal + parseFloat(IVA), 2);
                //Actualizmaos Prima
                elm.Descuento = Descuento;
                elm.Recargos = Recargos;
                elm.SubTotal = SubTotal;
                elm.IVA = parseFloat(IVA);
                elm.PrimaTotal = parseFloat(PTotal);
                //Actualizamos Comisiones
                var PorComincion = parseFloat(values.PComN ? values.PComN : 0);
                var Comision = round(PNeta * (PorComincion / 100), 2);
                var PRecargos = parseFloat(values.PComR ? values.PComR : 0);
                var RecargosC = round(Recargos * (PRecargos / 100), 2);//PorRecargos
                var PorDerechos = parseFloat(values.PComD ? values.PComD : 0);
                var Derechos = round(parseFloat(PNeta * (PorDerechos / 100)), 2);
                var PorEspecial = parseFloat(values.PEspecial ? values.PEspecial : 0);
                var Especial = round(parseFloat(PNeta * (PorEspecial / 100)), 2);

                elm.ComN = parseFloat(Comision);
                elm.ComR = parseFloat(RecargosC);
                elm.ComD = parseFloat(Derechos);
                elm.Especial = parseFloat(Especial);
            } else {
                //alert('test')//PComN//PComR//PComD
                //var IVA = parseFloat(PNeta * 0.16);
                var Descuento = parseFloat(values.Descuento ? values.Descuento : 0);
                var Recargos = parseFloat(values.Recargos ? values.Recargos : 0);

                var PIVA = parseFloat(values.PorIVA ? values.PorIVA : 0);
                var PDescuento = round((Descuento * 100) / PNeta, 2);
                var PRecargos = round((Recargos * 100) / PNeta, 2);
                const SubTotal = parseFloat(Recargos) + parseFloat(PNeta) + parseFloat(Derechos) - parseFloat(Descuento);
                //Nuevo procedimiento

                var IVA = parseFloat(values.IVA ? values.IVA : 0);
                var PorIVA = round((IVA / SubTotal) * 100, 2);
                var PTotal = (SubTotal + round(parseFloat(IVA), 2));

                elm.PDescuento = PDescuento;
                elm.PorRecargos = PRecargos;
                elm.STotal = SubTotal;
                elm.PrimaTotal = parseFloat(PTotal);

                var ComNeta = parseFloat(values.ComN ? values.ComN : 0);
                var PComNeta = round((ComNeta * 100) / PNeta, 2);

                //var ComRec = parseFloat(values.ComRec ? values.ComRec : 0);
                var ComRec = parseFloat(values.ComR ? values.ComR : 0);
                var PComRec = round((ComRec * 100) / Recargos, 2);

                var ComDer = parseFloat(values.ComD ? values.ComD : 0);
                var PComDer = round((ComDer * 100) / Derechos, 2);

                var Especial = parseFloat(values.Especial ? values.Especial : 0);
                var PEspecial = round((Especial * 100) / PNeta, 2);

                elm.IVA = parseFloat(IVA);
                elm.PorIVA = parseFloat(PorIVA);
                elm.PComN = parseFloat(PComNeta);
                elm.PComR = parseFloat(PComRec);
                elm.PComD = parseFloat(PComDer);
                elm.PEspecial = parseFloat(PEspecial);

            }
            TotalComisiones(values);
            return values;
        }
    }

    function ChangeValueRecibo(values, field, value, tipo = null) {
        let elm = { ...recibo };
        elm[field] = value;
        elm = ReloadIndividual(elm, tipo);
        setRecibo(elm);
    }

    async function SaveRecibos() {
        if (recibo.Status_TXT === 'Pendiente') {
            ShowLoading();
            var dta = {
                //"data": recibo,
                "data": formikRef.current.values
            };

            const res = await CallApiPost(`${UrlServicio}conciliacion/updaterecibo`, dta, null);
            if (res.status != 200) {
                toastr.error(`Error ${res.error.Mensaje}`);
            } else {
                toastr.success("Exíto");
                await ReloadPageInfo();
            }
            ShowLoading(false);
        }
    }

    function ImporteHonorarios(item, tipo) {
        if (recibo.IDEnd > 0) {
            if (tipo === "honorario") {
                if (Endosos.length > 0) {
                    return item.importe / Endosos.length ? item.importe / Endosos.length : 0;
                }
                else {
                    return item.importe;
                }
            }
            else if (tipo === "comision") {
                if (Endosos.length > 0) {
                    return item.Importe / Endosos.length ? item.Importe / Endosos.length : 0;
                }
                else {
                    return item.Importe;
                }
            }
        }
        else {
            if (tipo === "honorario") {
                return item.importe / ItemInfoRecibo.NPagos ? item.importe / ItemInfoRecibo.NPagos : 0;
            }
            else if (tipo === "comision") {
                return item.Importe / ItemInfoRecibo.NPagos ? item.Importe / ItemInfoRecibo.NPagos : 0;
            }
        }
        return 0;
    }

    function ResetModal(setFieldValue) {
        setPago(prevState => ({
            ...prevState,
            ...pagoO
        }));
    }

    function ConvertImporte(recibo, lista, tipo) {
        let _lista = [];

        if (tipo === "H") {
            lista.forEach(x => {
                if (Modulo == 'P') {
                    //var find = FComisionesP.find(r => r.Id == x.Id_formula);
                    var find = FComisiones.find(r => r.Id == x.Id_formula);
                    if (find) {
                        x.Formula = find.Nombre;

                        if (find.Id === 1 || find.Id === 2) {
                            x.Base = recibo.ComN;
                            x.ImporteCal = (x.Base * x.Porcentaje) / 100 ? (x.Base * x.Porcentaje) / 100 : 0;
                        }

                        else if (find.Id === 3) {
                            x.Base = recibo.ComR + recibo.ComD;
                            x.ImporteCal = (x.Base * x.Porcentaje) / 100 ? (x.Base * x.Porcentaje) / 100 : 0;
                        }
                        else if (find.Id === 4) {
                            x.Base = recibo.ComD;
                            x.ImporteCal = (x.Base * x.Porcentaje) / 100 ? (x.Base * x.Porcentaje) / 100 : 0;
                        }

                        if (x.Id_tipo_hon == 100) {
                            if (x.ImporteCal > 0) {
                                x.ImporteCal = (x.ImporteCal) * (-1);
                            }
                        }
                        _lista.push(x);
                    }
                }
                else if (Modulo == 'F') {
                    var find = FComisiones.find(r => r.Id == x.Id_formula);
                    if (find) {
                        x.Formula = find.Nombre;

                        if (find.Id === 1) {
                            x.Base = recibo.ComN;
                            x.ImporteCal = (x.Base * x.Porcentaje) / 100 ? (x.Base * x.Porcentaje) / 100 : 0;
                        }
                        else if (find.Id === 2) {
                            x.Base = recibo.ComN + recibo.CGastosMaq;
                            x.ImporteCal = (x.Base * x.Porcentaje) / 100 ? (x.Base * x.Porcentaje) / 100 : 0;
                        }
                        else if (find.Id === 3) {
                            x.Base = recibo.ComD + recibo.CGastosMaq;
                            x.ImporteCal = (x.Base * x.Porcentaje) / 100 ? (x.Base * x.Porcentaje) / 100 : 0;
                        }
                        else if (find.Id === 4 || find.Id === 5) {
                            x.Base = recibo.CGastosMaq;
                            x.ImporteCal = (x.Base * x.Porcentaje) / 100 ? (x.Base * x.Porcentaje) / 100 : 0;
                        }
                        if (x.Id_tipo_hon == 100) {
                            if (x.ImporteCal > 0) {
                                x.ImporteCal = (x.ImporteCal) * (-1);
                            }
                        }
                        _lista.push(x);
                    }
                }

            })
            setHonorarios(_lista);
        }
        else if (tipo === "C") {
            lista.forEach(x => {
                if (Modulo == 'P') {
                    if (x.Formula === 1) {
                        //x.ImporteCal = recibo.ComN;
                        x.ImporteCal = ((recibo.PrimaNeta) / 100) * (x.Participacion);
                        //x.ImporteCal = recibo.ComN;
                    }
                    else if (x.Formula === 3) {
                        x.ImporteCal = ((recibo.Recargos) / 100) * (x.Participacion);
                        //x.ImporteCal = recibo.ComR;
                    }
                    else if (x.Formula === 4) {
                        x.ImporteCal = ((recibo.Descuento) / 100) * (x.Participacion);
                        //x.ImporteCal = recibo.ComD;
                    }
                    _lista.push(x);
                }
                else if (Modulo == 'F') {
                    if (x.Formula === 1) {
                        x.ImporteCal = ((recibo.PrimaNeta) / 100) * (x.Participacion);
                        //x.ImporteCal = recibo.ComN;
                    }
                    else if (x.Formula === 2) {
                        x.ImporteCal = ((recibo.Recargos + recibo.GtosMaq) / 100) * (x.Participacion);
                        //x.ImporteCal = recibo.ComN + recibo.CGastosMaq;
                    }
                    else if (x.Formula === 3) {
                        x.ImporteCal = ((recibo.Recargos + recibo.GtosMaq) / 100) * (x.Participacion);//GtosMaq
                        //x.ImporteCal = x.Recargo + x.GtosMaq;GastosMaq
                    }
                    else if (x.Formula === 4 || x.Formula === 5) {
                        x.ImporteCal = ((recibo.GastosMaq) / 100) * (x.Participacion);
                        //x.ImporteCal = ((recibo.CGastosMaq) / 100) * (x.Participacion); //x.CGastosMaq;//CGtosMaquila
                        //x.ImporteCal = x.CGastosMaq;//CGtosMaquila
                    }
                    _lista.push(x);
                }
            })

            setComisiones(_lista);
        }

        return _lista;
    }

    useEffect(async () => {
        if ($('body div').hasClass('pace')) {
            $("body div").removeClass("pace");
        }
        ShowLoading();
        await InitialData();
        await GetInitialDataPago();
        await GetPago();

        ShowLoading(false);
    }, []);

    useEffect(() => {
        if (recibo && recibo.Status_TXT && recibo.Status_TXT == 'Pendiente') {
            setDisabled(false);
        }
        else {
            setDisabled(true);
        }
    }, [recibo])

    function TotalComisiones(values) {
        var Val1 = (values.ComR ? values.ComR : 0);
        var Val2 = (values.CGastosMaq ? values.CGastosMaq : 0);
        var Val3 = (values.CGastosAdm ? values.CGastosAdm : 0);
        var Val4 = (values.ComD ? values.ComD : 0);
        var Val5 = (values.ComDer ? values.ComDer : 0);
        var Val6 = (values.Especial ? values.Especial : 0);
        var Val7 = (values.ComN ? values.ComN : 0);

        let Total = parseFloat(Val1) + parseFloat(Val2) + parseFloat(Val3) + parseFloat(Val4) + parseFloat(Val5) + parseFloat(Val6) + parseFloat(Val7);

        SetTComisones(Total);
    }

    function toFixedNumber(number) {
        const spitedValues = String(number.toLocaleString()).split('.');
        let decimalValue = spitedValues.length > 1 ? spitedValues[1] : '';
        decimalValue = decimalValue.concat('00').substr(0, 2);
        return parseFloat(spitedValues[0].replace(/,/g, '') + '.' + decimalValue);
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
        var values = formikRef.current.values;

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
        var values = formikRef.current.values;
        var TipHon = ObjHon.TipoComision;
        switch (parseInt(Tipo)) {
            case 1:
            case 2:
                rReturn = ((values.ComN ? values.ComN : 0) / 100) * (Porcentaje ? Porcentaje : 0);
                break;
            case 3:
                if (Modulo == "F") {
                    rReturn = ((values.CGastosMaq ? values.CGastosMaq : 0) / 100) * (Porcentaje ? Porcentaje : 0);
                } else {
                    rReturn = ((values.ComD ? values.ComD : 0) / 100) * (Porcentaje ? Porcentaje : 0);
                }
                break;
            case 4:
                rReturn = ((values.ComR ? values.ComR : 0) / 100) * (Porcentaje ? Porcentaje : 0);
                break;
            case 5:
                rReturn = ((values.CGastosMaq ? values.CGastosMaq : 0) / 100) * (Porcentaje ? Porcentaje : 0);
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
        var values = formikRef.current.values;
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
        var URL = Tipo == 1 ? `${UrlServicio}conciliacion/saveorupdateobjcom` : `${UrlServicio}conciliacion/saveorupdateobjhon`;
        ShowLoading();
        obj.IdRecibo = Id;
        obj.IdDocto = recibo.IDDocto;
        if (Tipo == 1) {
            obj.Total = returnTotal(obj.TipoComision);
        } else {
            obj.Total = returnTotal(obj.TipoComision);
        }
        var dta = obj;
        const res = await CallApiPost(URL, dta, null);
        if (res.status != 200) {
            toastr.error(`Error ${res.error.Mensaje}`);
        } else {
            toastr.success("Exíto");
            //setObjCom(InitialModCom)
            //await ReloadPageInfo();
            if (Tipo == 1) {
                setObjCom(InitialModCom)
            } else {
                setObjHon(InitialModCom)
            }
            await ReloadPageInfo();
        }
        ShowLoading(false);
    }

    async function EliminarHonObj(Tipo) {
        var obj = { Id: Tipo == 1 ? ObjCom.Id : ObjHon.Id };
        var URL = Tipo == 1 ? `${UrlServicio}conciliacion/deleteobjcom` : `${UrlServicio}conciliacion/deleteobjhon`;
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
                    await ReloadPageInfo();
                }
                ShowLoading(false);
            }
        });

    }

    async function clicObjeto(item, tipo) {
        if (tipo == 1) {
            var obj = { ...InitialModCom };
            obj.Id = item.Id;
            obj.IsEdit = false;
            obj.IDAgente = item.Agente;
            obj.TipoComision = item.Formula;
            obj.Generada = item.Importe;
            obj.Participacion = item.Participacion;
            obj.Registros = await getPagoComIndividual(item.Id);
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
            obj.Registros = await getPagoHonIndividual(item.Id);
            //setObjCom(obj);
            setObjHon(obj);
            //await getPagoHonIndividual(item.Id);
        }
    }

    async function getPagoHonIndividual(Id) {
        var URL = `${UrlServicio}conciliacion/getpagohonindividual`;
        var RetunDta = [];
        var dta = { Id: Id };
        const res = await CallApiGet(URL, dta, null);
        if (res.status != 200) {
            toastr.error(`Error ${res.error.Mensaje}`);
        } else {
            RetunDta = res.success.Datos
            /* setObjHon({
                ...ObjHon,
                Registros: res.success.Data
            }); */
        }
        return RetunDta;
    }

    async function getPagoComIndividual(Id) {
        var URL = `${UrlServicio}conciliacion/getpagocomindividual`;
        var RetunDta = [];
        var dta = { Id: Id };
        const res = await CallApiGet(URL, dta, null);
        if (res.status != 200) {
            toastr.error(`Error ${res.error.Mensaje}`);
        } else {
            RetunDta = res.success.Datos
            /* setObjHon({
                ...ObjHon,
                Registros: res.success.Data
            }); */
        }
        return RetunDta;
    }

    function CargarPagoHonorario() {
        var copy = { ...PHon };
        var copyFullH = { ...honorarios.find(x => x.Id == ObjHon.Id) };
        copy.IdMonedaDcto = copyFullH.Id_moneda_docto;
        copy.IdMonedaPago = copyFullH.Id_moneda_pago;
        copy.ImportePago = copyFullH.importe;
        copy.ImporteReal = copyFullH.importe;
        copy.TipoCambio1 = copyFullH.Id_moneda_pago,
            copy.TipoCambio2 = copyFullH.Id_moneda_docto,
            SetPHon(copy);
        $('#ModalAplicarHon').modal('show');
    }

    async function SavePagoHonorario() {
        var copyFullH = { ...honorarios.find(x => x.Id == ObjHon.Id) };
        var AplicarHon = formikModalRefPHon.current.values;
        var honorario = {
            Id: 0,
            IdRecibo: Id,
            Pagado: 1,
            Documento: recibo.Documento,
            Endoso: recibo.Endoso,
            FDesde: recibo.FDesde,
            Serie: recibo.Serie,
            TipoComision: '%',
            TipoValor: copyFullH.TipoValor,
            Participacion: copyFullH.Porcentaje,
            PrimaNeta: recibo.PrimaNeta,
            //Importe: ImporteHonorarios(x, "honorario"),
            Importe: copyFullH.ImporteCal,
            MonedaDoc: InitialDataInfo.Monedas.find(x => parseInt(x.Id) === parseInt(AplicarHon.IdMonedaDcto)).Nombre,
            IDMon: AplicarHon.IdMonedaDcto,
            TCDocumento: AplicarHon.TipoCambio2,
            TCPago: AplicarHon.TipoCambio1,
            ImportePago: AplicarHon.ImporteReal ? AplicarHon.ImporteReal : 0,
            Cliente: ItemInfoRecibo.Cliente,
            IDCli: ItemInfoRecibo.IDCli,
            IDCia: ItemInfoRecibo.IDCia,
            Compañia: ItemInfoRecibo.CiaNombre,
            FormaPago: ItemInfoRecibo.FormaPago,
            FEstatus: moment().format('YYYY-MM-DD'),
            //FAplicado: moment().format('YYYY-MM-DD'),
            FAplicado: moment(AplicarHon.Fecha).format('YYYY-MM-DD'),
            IDMonPago: AplicarHon.IdMonedaPago,
            MonedaPago: InitialDataInfo.Monedas.find(x => parseInt(x.Id) === parseInt(AplicarHon.IdMonedaPago)).Nombre,
            IDVend: copyFullH.Id_vendedor,
            VendNom: copyFullH.NombreCompleto,
            Tipo: copyFullH.Id_formula,
            //ImporteConvertido: ConvertirImporte(ImporteHonorarios(x, "honorario"))
            ImporteConvertido: (ConvertirImporte(AplicarHon.ImportePago)),
            IdRef: copyFullH.Id,
            CDocumento: AplicarHon.NoDocumento,
            CFolio: AplicarHon.FolioCheque,
            FDocumento: moment(AplicarHon.Fecha3).format('YYYY-MM-DD')
        }
        var URL = `${UrlServicio}conciliacion/savepagohonindividual`;
        var RetunDta = [];
        var dta = { Honorario: honorario };

        swal({
            title: "¿Está seguro de que quiere aplicar el honorario?",
            text: "Se realizara la captura de los datos ingresados",
            icon: "warning",
            buttons: ["Cancelar", "Aceptar"],
        }).then(async (value) => {
            if (value) {
                const res = await CallApiPost(URL, dta, null);
                if (res.status != 200) {
                    toastr.error(`Error ${res.error.Mensaje}`);
                } else {
                    await ReloadPageInfo();
                    setObjHon(InitialModCom);
                    SetPHon(objPago);
                    $('#ModalAplicarHon').modal('hide');
                }
            }
        });

    }

    async function ElminarPagoHon() {
        var URL = `${UrlServicio}conciliacion/eliminarpagohonindividual`;
        var RetunDta = [];
        var dta = { Id: ObjHon.Id };
        swal({
            title: "¿Está seguro de que quiere anular el pago?",
            text: "Se realizara la anulación del pago",
            icon: "warning",
            buttons: ["Cancelar", "Aceptar"],
        }).then(async (value) => {
            if (value) {
                const res = await CallApiPost(URL, dta, null);
                if (res.status != 200) {
                    toastr.error(`Error ${res.error.Mensaje}`);
                } else {
                    RetunDta = res.success.Datos
                    await ReloadPageInfo();
                    setObjHon(InitialModCom);
                    SetPHon(objPago);
                }
                return RetunDta;
            }
        });

    }




    function NewReloadPrices(field, value, values) {

        console.log("NewReloadPrices", field, value);

        if (value && value.includes(',')) {
            value = value.replace(/,/g, '');
        }

        let _OT = formikRef.current.values;

        var TipoEndoso = tipoEndosoGuardado || 1; //parseFloat(_OT.TipoE ? _OT.TipoE : 1);

        formikRef.current.setFieldValue(field, (field != "Descuento" && field != "PDescuento"
            && field != "PorRecargos" && field != "PorDerechos" && field != "PorIVA"
            && field != "PComN" && field != "PComR" && field != "PComD" && field != "PEspecial"
            && field != "PCGastosMaquila" && field != "PCGastosAdmin"
            && TipoEndoso == -1 ? "-" + Math.abs(value) : Math.abs(value)));

        if (field == "PrimaNeta") {
            let descuento = round(parseFloat(Math.abs(value) * (Math.abs(_OT.PDescuento || 0)) / 100), 4);
            let recargos = round(parseFloat(Math.abs(value) * (Math.abs(_OT.PorRecargos || 0)) / 100), 4);
            let derechos = parseFloat(Math.abs(_OT.Derechos)); /* round(parseFloat(Math.abs(value) * (Math.abs(_OT.PorDerechos) || 0) / 100), 4); */
            let subtotal =
                (parseFloat(Math.abs(value))
                    + parseFloat(Math.abs(derechos || 0))
                    + parseFloat(Math.abs(recargos || 0))
                    + parseFloat(Math.abs(_OT.GastosMaq || 0))
                    + parseFloat(Math.abs(_OT.GastosAdm || 0))) - parseFloat(Math.abs(descuento || 0));
            let iva = round(parseFloat(Math.abs(subtotal) * (Math.abs(_OT.PorIVA || 0)) / 100), 4);
            let total = round(parseFloat(Math.abs(subtotal) + Math.abs(iva) + parseFloat(Math.abs(_OT.Ajuste || 0))), 4);

            let comN = round(parseFloat(Math.abs(value) * Math.abs(_OT.PComN || 0) / 100), 4);
            let comR = round(parseFloat(Math.abs(recargos) * Math.abs(_OT.PComR || 0) / 100), 4);
            let comD = round(parseFloat(Math.abs(derechos) * Math.abs(_OT.PComD || 0) / 100), 4);
            let especial = round(parseFloat(Math.abs(value) * Math.abs(_OT.PEspecial || 0) / 100), 4);

            //console.log(`PrimaNeta ${value} | Derechos ${derechos} | Recargos ${recargos} | GastosMaq ${_OT.GastosMaq} | GastosAdm ${_OT.GastosAdm} | Descuento ${descuento} | SubTotal ${subtotal} | IVA ${iva} | Total ${total}`);

            formikRef.current.setFieldValue("Descuento", Math.abs(descuento || 0));
            formikRef.current.setFieldValue("Recargos", Math.abs(recargos || 0) * TipoEndoso);
            formikRef.current.setFieldValue("Derechos", Math.abs(derechos || 0) * TipoEndoso);
            formikRef.current.setFieldValue("IVA", Math.abs(iva || 0) * TipoEndoso);
            formikRef.current.setFieldValue("SubTotal", Math.abs(subtotal || 0) * TipoEndoso);
            formikRef.current.setFieldValue("PrimaTotal", Math.abs(total || 0) * TipoEndoso);

            formikRef.current.setFieldValue("ComN", Math.abs(comN || 0) * TipoEndoso);
            formikRef.current.setFieldValue("ComR", Math.abs(comR || 0) * TipoEndoso);
            formikRef.current.setFieldValue("ComD", Math.abs(comD || 0) * TipoEndoso);
            formikRef.current.setFieldValue("Especial", Math.abs(especial || 0) * TipoEndoso);
        }
        else if (field == "Descuento") {
            let pDescuento = round(parseFloat(Math.abs(value) / (Math.abs(_OT.PrimaNeta || 0)) * 100), 4);
            let subtotal = (parseFloat(Math.abs(_OT.PrimaNeta || 0))
                + parseFloat(Math.abs(_OT.Derechos || 0))
                + parseFloat(Math.abs(_OT.Recargos || 0))
                + parseFloat(Math.abs(_OT.GastosMaq || 0)) + parseFloat(Math.abs(_OT.GastosAdm || 0))) - parseFloat(Math.abs(value));
            let total = round((parseFloat(Math.abs(subtotal)) + parseFloat(Math.abs(_OT.IVA || 0)) + parseFloat(Math.abs(_OT.Ajuste || 0))), 4);

            formikRef.current.setFieldValue("PDescuento", Math.abs(pDescuento || 0));
            formikRef.current.setFieldValue("SubTotal", Math.abs(subtotal || 0) * TipoEndoso);
            formikRef.current.setFieldValue("PrimaTotal", Math.abs(total || 0) * TipoEndoso);
        }
        else if (field == "PDescuento") {
            let descuento = round(parseFloat(Math.abs(_OT.PrimaNeta || 0) * Math.abs(value) / 100), 4);
            let subtotal = round((parseFloat(Math.abs(_OT.PrimaNeta || 0))
                + parseFloat(Math.abs(_OT.Derechos || 0))
                + parseFloat(Math.abs(_OT.PrimaNeta || 0) * Math.abs(_OT.PorRecargos || 0) / 100)
                + parseFloat(Math.abs(_OT.GastosMaq || 0)) + parseFloat(Math.abs(_OT.GastosAdm || 0))) - parseFloat(Math.abs(_OT.PrimaNeta || 0) * value / 100), 4);
            let total = round(parseFloat(Math.abs(subtotal) + Math.abs(_OT.IVA || 0) + parseFloat(Math.abs(_OT.Ajuste || 0))), 4);

            formikRef.current.setFieldValue("Descuento", Math.abs(descuento || 0));
            formikRef.current.setFieldValue("SubTotal", Math.abs(subtotal || 0) * TipoEndoso);
            formikRef.current.setFieldValue("PrimaTotal", Math.abs(total || 0) * TipoEndoso);
        }
        else if (field == "Recargos") {

            let pRecargos = round(parseFloat(Math.abs(value) / Math.abs(_OT.PrimaNeta || 0) * 100), 4);
            let subtotal = (parseFloat(Math.abs(_OT.PrimaNeta || 0))
                + parseFloat(Math.abs(_OT.Derechos || 0))
                + parseFloat(Math.abs(_OT.PrimaNeta || 0) * (Math.abs(value) / Math.abs(_OT.PrimaNeta || 0) * 100) / 100)
                + parseFloat(Math.abs(_OT.GastosMaq || 0)) + parseFloat(Math.abs(_OT.GastosAdm || 0))) - parseFloat(Math.abs(_OT.Descuento || 0));
            let total = round(parseFloat(Math.abs(subtotal)) + parseFloat(Math.abs(_OT.IVA || 0)) + parseFloat(Math.abs(_OT.Ajuste || 0)), 4);

            let comR = round(parseFloat(Math.abs(value) * Math.abs(_OT.PComR || 0) / 100), 4);

            formikRef.current.setFieldValue("PorRecargos", Math.abs(pRecargos || 0));
            formikRef.current.setFieldValue("SubTotal", Math.abs(subtotal || 0) * TipoEndoso);
            formikRef.current.setFieldValue("PrimaTotal", Math.abs(total || 0) * TipoEndoso);

            formikRef.current.setFieldValue("ComR", Math.abs(comR || 0) * TipoEndoso);
        }
        else if (field == "PorRecargos") {
            let recargos = round(parseFloat(Math.abs(_OT.PrimaNeta || 0) * Math.abs(value) / 100), 4);
            let subtotal = (parseFloat(Math.abs(_OT.PrimaNeta || 0))
                + parseFloat(Math.abs(_OT.Derechos || 0))
                + parseFloat(Math.abs(_OT.PrimaNeta || 0) * Math.abs(value) / 100)
                + parseFloat(Math.abs(_OT.GastosMaq || 0)) + parseFloat(Math.abs(_OT.GastosAdm || 0))) - parseFloat(Math.abs(_OT.Descuento || 0));
            let total = round(parseFloat(Math.abs(subtotal) + parseFloat(Math.abs(_OT.IVA || 0)) + parseFloat(Math.abs(_OT.Ajuste || 0))), 4);

            let comR = round(parseFloat(recargos * Math.abs(_OT.PComR || 0) / 100), 4);

            formikRef.current.setFieldValue("Recargos", Math.abs(recargos || 0) * TipoEndoso);
            formikRef.current.setFieldValue("SubTotal", Math.abs(subtotal || 0) * TipoEndoso);
            formikRef.current.setFieldValue("PrimaTotal", Math.abs(total || 0) * TipoEndoso);

            formikRef.current.setFieldValue("ComR", Math.abs(comR || 0) * TipoEndoso);
        }
        else if (field == "Derechos") {
            let pDerecho = round(parseFloat(Math.abs(value) / Math.abs(_OT.PrimaNeta || 0) * 100), 4);
            let subtotal = (parseFloat(Math.abs(_OT.PrimaNeta || 0))
                + parseFloat(Math.abs(_OT.Derechos)) + parseFloat(Math.abs(_OT.Recargos || 0))
                + parseFloat(Math.abs(_OT.GastosMaq || 0)) + parseFloat(Math.abs(_OT.GastosAdm || 0))
            ) - parseFloat(Math.abs((_OT.Descuento || 0)));
            let iva = round(parseFloat(Math.abs(subtotal) * Math.abs(_OT.PorIVA || 0) / 100), 4)
            let total = round(parseFloat(Math.abs(subtotal) + Math.abs(subtotal) * Math.abs(_OT.PorIVA || 0) / 100) + parseFloat(Math.abs(_OT.Ajuste) || 0), 4);

            let comD = round(parseFloat(Math.abs(value) * Math.abs(_OT.PComD || 0) / 100), 4);

            //console.log(`PrimaNeta ${_OT.PrimaNeta} | Derechos ${value} | Recargos ${_OT.Recargos} | GastosMaq ${_OT.GastosMaq} | GastosAdm ${_OT.GastosAdm} | Descuento ${_OT.Descuento} | Subtotal ${subtotal} | IVA ${iva} | Total ${total}`);

            formikRef.current.setFieldValue("PorDerechos", pDerecho || 0);
            formikRef.current.setFieldValue("SubTotal", Math.abs(subtotal || 0) * TipoEndoso);
            formikRef.current.setFieldValue("IVA", Math.abs(iva || 0) * TipoEndoso);
            formikRef.current.setFieldValue("PrimaTotal", Math.abs(total || 0) * TipoEndoso);

            formikRef.current.setFieldValue("ComD", Math.abs(comD || 0) * TipoEndoso);
        }
        else if (field == "PorDerechos") {
            let derechos = round(parseFloat(Math.abs(_OT.PrimaNeta || 0) * Math.abs(value) / 100), 4);
            let subtotal = (parseFloat(Math.abs(_OT.PrimaNeta || 0))
                + parseFloat(Math.abs(derechos || 0)) + parseFloat(Math.abs(_OT.Recargos || 0))
                + parseFloat(Math.abs(_OT.GastosMaq || 0)) + parseFloat(Math.abs(_OT.GastosAdm || 0))) - parseFloat(Math.abs(_OT.Descuento || 0));
            let total = round(parseFloat(Math.abs(subtotal) + parseFloat(Math.abs(_OT.IVA || 0)) + parseFloat(Math.abs(_OT.Ajuste || 0))), 4);

            let comD = round(parseFloat(derechos * Math.abs(_OT.PComD || 0) / 100), 4);

            formikRef.current.setFieldValue("Derechos", Math.abs(derechos || 0) * TipoEndoso);
            formikRef.current.setFieldValue("SubTotal", Math.abs(subtotal || 0) * TipoEndoso);
            formikRef.current.setFieldValue("PrimaTotal", Math.abs(total || 0) * TipoEndoso);

            formikRef.current.setFieldValue("ComD", Math.abs(comD || 0) * TipoEndoso);
        }
        else if (field == "GastosMaq") {
            let subtotal = (parseFloat(Math.abs(_OT.PrimaNeta || 0))
                + parseFloat(Math.abs(_OT.Derechos || 0))
                + parseFloat(Math.abs(_OT.Recargos || 0))
                + parseFloat(Math.abs(value))
                + parseFloat(Math.abs(_OT.GastosAdm || 0))) - parseFloat(Math.abs(_OT.Descuento || 0));
            let iva = round(parseFloat(Math.abs(subtotal) * (Math.abs(_OT.PorIVA || 0)) / 100), 4)
            let total = round(parseFloat(Math.abs(subtotal) + (Math.abs(iva)) + parseFloat(Math.abs(_OT.Ajuste || 0))), 4);

            let cGastosMaq = round(parseFloat(value * Math.abs(_OT.PCGastosMaq || 0) / 100), 4);

            formikRef.current.setFieldValue("IVA", iva || 0);
            formikRef.current.setFieldValue("SubTotal", subtotal || 0);
            formikRef.current.setFieldValue("PrimaTotal", total || 0);

            formikRef.current.setFieldValue("CGastosMaq", cGastosMaq || 0);
        }
        else if (field == "GastosAdm") {
            let subtotal = (parseFloat(Math.abs(_OT.PrimaNeta || 0))
                + parseFloat(Math.abs(_OT.Derechos || 0))
                + parseFloat(Math.abs(_OT.Recargos || 0))
                + parseFloat(Math.abs(_OT.GastosMaq || 0))
                + parseFloat(Math.abs(value))) - parseFloat(Math.abs(_OT.Descuento || 0));
            let iva = round(parseFloat(Math.abs(subtotal) * Math.abs(_OT.PorIVA || 0) / 100), 4)
            let total = round(parseFloat(Math.abs(subtotal) + Math.abs(iva) + parseFloat(Math.abs(_OT.Ajuste || 0))), 4);

            let cGastosAdm = round(parseFloat(Math.abs(value) * Math.abs(_OT.PCGastosAdm || 0) / 100), 4);

            formikRef.current.setFieldValue("IVA", Math.abs(iva || 0) * TipoEndoso);
            formikRef.current.setFieldValue("SubTotal", Math.abs(subtotal || 0) * TipoEndoso);
            formikRef.current.setFieldValue("PrimaTotal", Math.abs(total || 0) * TipoEndoso);

            formikRef.current.setFieldValue("CGastosAdm", Math.abs(cGastosAdm || 0) * TipoEndoso);
        }
        else if (field == "IVA") {

            let piva = round(parseFloat(Math.abs(value) / Math.abs(_OT.SubTotal || 0) * 100), 4);
            let total = round(parseFloat(Math.abs(_OT.SubTotal || 0)) + parseFloat(Math.abs(value)) + parseFloat(Math.abs(_OT.Ajuste || 0)), 4);

            formikRef.current.setFieldValue("PorIVA", Math.abs(piva || 0));
            formikRef.current.setFieldValue("PrimaTotal", Math.abs(total || 0) * TipoEndoso);
        }
        else if (field == "PorIVA") {

            let iva = round(parseFloat(Math.abs(value) / 100 * Math.abs(_OT.SubTotal || 0)), 4);
            let total = round(parseFloat(Math.abs(_OT.SubTotal) + Math.abs(_OT.SubTotal || 0) * Math.abs(value) / 100) + parseFloat(Math.abs(_OT.Ajuste || 0)), 4);

            formikRef.current.setFieldValue("IVA", Math.abs(iva || 0) * TipoEndoso);
            formikRef.current.setFieldValue("PrimaTotal", Math.abs(total || 0) * TipoEndoso);
        }
        else if (field == "Ajuste") {

            let ajusteAnterior = _OT.AjusteAnterior == undefined ? parseFloat(Math.abs(AjusteAnteriorGuardado || 0)) : parseFloat(Math.abs(_OT.AjusteAnterior || 0));

            /* if (_OT.AjusteAnterior == undefined) {
                if (Id == undefined) {
                    ajusteAnterior = 0;
                }
                else {
                    ajusteAnterior = parseFloat(Math.abs(AjusteAnteriorGuardado || 0));
                }
            }
            else {
                ajusteAnterior = parseFloat(Math.abs(_OT.AjusteAnterior || 0));
            } */

            let total = round(parseFloat(Math.abs(_OT.PrimaTotal || 0)) - parseFloat(Math.abs(ajusteAnterior)) + parseFloat(Math.abs(value)), 4);
            let subtotal = (parseFloat(Math.abs(total)) - parseFloat(Math.abs(value))) / (1 + (Math.abs(_OT.PorIVA || 0) / 100));
            let iva = round(parseFloat(Math.abs(subtotal) * Math.abs(_OT.PorIVA || 0) / 100), 4);
            let primaneta = round(parseFloat((Math.abs(subtotal) - Math.abs(_OT.Derechos || 0) - Math.abs(_OT.GastosMaq || 0) - Math.abs(_OT.GastosAdm || 0)) / ((1 + (Math.abs(_OT.PorRecargos || 0) / 100)) - (Math.abs(_OT.PDescuento || 0) / 100))), 4);
            let descuento = round(parseFloat(Math.abs(primaneta) * Math.abs(_OT.PDescuento || 0) / 100), 4);
            let recargos = round(parseFloat(Math.abs(primaneta) * Math.abs(_OT.PorRecargos || 0) / 100), 4);
            let derechos = round(parseFloat(Math.abs(_OT.Derechos)), 2); //round(parseFloat(Math.abs(primaneta) * Math.abs(_OT.PorDerechos || 0) / 100), 4);

            let comN = round(parseFloat(Math.abs(primaneta) * Math.abs(_OT.PComN || 0) / 100), 4);
            let comR = round(parseFloat(Math.abs(recargos) * Math.abs(_OT.PComR || 0) / 100), 4);
            let comD = round(parseFloat(Math.abs(derechos) * Math.abs(_OT.PComD || 0) / 100), 4);
            let especial = round(parseFloat(Math.abs(primaneta) * Math.abs(_OT.PEspecial || 0) / 100), 4);

            formikRef.current.setFieldValue("PrimaTotal", Math.abs(total || 0) * TipoEndoso);
            formikRef.current.setFieldValue("SubTotal", Math.abs(subtotal || 0) * TipoEndoso);
            formikRef.current.setFieldValue("IVA", Math.abs(iva || 0) * TipoEndoso);
            formikRef.current.setFieldValue("PrimaNeta", Math.abs(primaneta || 0) * TipoEndoso);
            formikRef.current.setFieldValue("Descuento", descuento || 0);
            formikRef.current.setFieldValue("Recargos", Math.abs(recargos || 0) * TipoEndoso);
            formikRef.current.setFieldValue("Derechos", Math.abs(derechos || 0) * TipoEndoso);

            formikRef.current.setFieldValue("ComN", Math.abs(comN || 0) * TipoEndoso);
            formikRef.current.setFieldValue("ComR", Math.abs(comR || 0) * TipoEndoso);
            formikRef.current.setFieldValue("ComD", Math.abs(comD || 0) * TipoEndoso);
            formikRef.current.setFieldValue("Especial", Math.abs(especial || 0) * TipoEndoso);

            formikRef.current.setFieldValue("AjusteAnterior", parseFloat(Math.abs(value || 0)));
        }
        else if (field == "PrimaTotal") {
            let subtotal = (parseFloat(Math.abs(value)) - parseFloat(Math.abs(_OT.Ajuste || 0))) / (1 + (Math.abs(_OT.PorIVA || 0) / 100));
            let iva = round(parseFloat(Math.abs(subtotal) * Math.abs(_OT.PorIVA || 0) / 100), 4);
            let primaneta = round(parseFloat((Math.abs(subtotal) - Math.abs(_OT.Derechos || 0) - Math.abs(_OT.GastosMaq || 0) - Math.abs(_OT.GastosAdm || 0)) / ((1 + (Math.abs(_OT.PorRecargos || 0) / 100)) - (Math.abs(_OT.PDescuento || 0) / 100))), 4);
            let descuento = round(parseFloat(Math.abs(primaneta) * Math.abs(_OT.PDescuento || 0) / 100), 4);
            let recargos = round(parseFloat(Math.abs(primaneta) * Math.abs(_OT.PorRecargos || 0) / 100), 4);
            let derechos = round(parseFloat(Math.abs(_OT.Derechos)), 4); //parseFloat(Math.abs(primaneta) * Math.abs(_OT.PorDerechos || 0) / 100);

            let comN = round(parseFloat(Math.abs(primaneta) * Math.abs(_OT.PComN || 0) / 100), 4);
            let comR = round(parseFloat(Math.abs(recargos) * Math.abs(_OT.PComR || 0) / 100), 4);
            let comD = parseFloat(Math.abs(derechos) * Math.abs(_OT.PComD || 0) / 100);
            let especial = round(parseFloat(Math.abs(primaneta) * Math.abs(_OT.PEspecial || 0) / 100), 4);

            formikRef.current.setFieldValue("SubTotal", Math.abs(subtotal || 0) * TipoEndoso);
            formikRef.current.setFieldValue("IVA", Math.abs(iva || 0) * TipoEndoso);
            formikRef.current.setFieldValue("PrimaNeta", Math.abs(primaneta || 0) * TipoEndoso);
            formikRef.current.setFieldValue("Descuento", descuento || 0);
            formikRef.current.setFieldValue("Recargos", Math.abs(recargos || 0) * TipoEndoso);
            formikRef.current.setFieldValue("Derechos", Math.abs(derechos || 0) * TipoEndoso);

            formikRef.current.setFieldValue("ComN", Math.abs(comN || 0) * TipoEndoso);
            formikRef.current.setFieldValue("ComR", Math.abs(comR || 0) * TipoEndoso);
            formikRef.current.setFieldValue("ComD", Math.abs(comD || 0) * TipoEndoso);
            formikRef.current.setFieldValue("Especial", Math.abs(especial || 0) * TipoEndoso);
        }

        else if (field == "ComN") {
            let pComN = round(parseFloat(Math.abs(value) / Math.abs(_OT.PrimaNeta || 0) * 100), 4);
            formikRef.current.setFieldValue("PComN", pComN || 0);
        }
        else if (field == "PComN") {
            let comN = round(parseFloat(Math.abs(_OT.PrimaNeta || 0) * Math.abs(value) / 100), 4);
            formikRef.current.setFieldValue("ComN", Math.abs(comN || 0) * TipoEndoso);
        }
        else if (field == "ComR") {
            let pComR = round(parseFloat(Math.abs(value) / Math.abs(_OT.Recargos || 0) * 100), 4);
            formikRef.current.setFieldValue("PComR", pComR || 0);
        }
        else if (field == "PComR") {
            let comR = round(parseFloat(Math.abs(_OT.Recargos || 0) * Math.abs(value) / 100), 4);
            formikRef.current.setFieldValue("ComR", Math.abs(comR || 0) * TipoEndoso);
        }
        else if (field == "ComD") {
            let pComD = round(parseFloat(Math.abs(value) / Math.abs(_OT.Derechos || 0) * 100), 4);
            formikRef.current.setFieldValue("PComD", pComD || 0);
        }
        else if (field == "PComD") {
            let comD = round(parseFloat(Math.abs(_OT.Derechos || 0) * Math.abs(value) / 100), 4);
            formikRef.current.setFieldValue("ComD", Math.abs(comD || 0) * TipoEndoso);
        }
        else if (field == "CGastosMaq") {
            let pCGastosMaquila = round(parseFloat(Math.abs(value) / Math.abs(_OT.GastosMaq || 0) * 100), 4);
            formikRef.current.setFieldValue("PCGastosMaq", pCGastosMaquila || 0);
        }
        else if (field == "PCGastosMaq") {
            let cGastosMaquila = round(parseFloat(Math.abs(_OT.GastosMaq || 0) * Math.abs(value) / 100), 4);
            formikRef.current.setFieldValue("CGastosMaq", Math.abs(cGastosMaquila || 0) * TipoEndoso);
        }
        else if (field == "CGastosAdm") {
            let pCGastosAdmin = round(parseFloat(Math.abs(value) / Math.abs(_OT.GastosAdm || 0) * 100), 4);
            formikRef.current.setFieldValue("PCGastosAdm", pCGastosAdmin || 0);
        }
        else if (field == "PCGastosAdm") {
            let cGastosAdmin = round(parseFloat(Math.abs(_OT.GastosAdm || 0) * Math.abs(value) / 100), 4);
            formikRef.current.setFieldValue("CGastosAdm", Math.abs(cGastosAdmin || 0) * TipoEndoso);
        }
        else if (field == "Especial") {
            let pEspecial = round(parseFloat(Math.abs(value) / Math.abs(_OT.PrimaNeta || 0) * 100), 4);
            formikRef.current.setFieldValue("PEspecial", pEspecial || 0);
        }
        else if (field == "PEspecial") {
            let especial = round(parseFloat(Math.abs(_OT.PrimaNeta) * Math.abs(value) / 100), 4);
            formikRef.current.setFieldValue("Especial", Math.abs(especial || 0) * TipoEndoso);
        }

        TotalComisiones(values);
    }

    async function RehabiltarRecibo() {
        var URL = `${UrlServicio}conciliacion/rehabilitarRecibo`;
        var RetunDta = [];
        var dta = {
            IDRecibo: Id,
            Documento: recibo.Documento,
            IDDocto: recibo.IDDocto,
            Modulo: Modulo
        };
        swal({
            title: "¿Está seguro de que quiere rehabilitar el recibo?",
            text: "Se realizara la rehabilitación del recibo",
            icon: "warning",
            buttons: ["Cancelar", "Aceptar"],
        }).then(async (value) => {
            if (value) {
                const res = await CallApiPost(URL, dta, null);
                if (res.status != 200) {
                    toastr.error(`Error ${res.error.Mensaje}`);
                } else {
                    RetunDta = res.success.Datos
                    await ReloadPageInfo();
                    //setObjHon(InitialModCom);
                    //SetPHon(objPago);
                }
                return RetunDta;
            }
        });
    }

    async function RecalcularRecibo() {
        var URL = `${UrlServicio}conciliacion/recalcularRecibo`;
        var RetunDta = [];
        var dta = {
            IDRecibo: Id,
            Documento: recibo.Documento,
            IDDocto: recibo.IDDocto,
            Modulo: Modulo
        };
        swal({
            title: "¿Está seguro de que quiere recalcular el recibo?",
            text: "Se realizara el recalculo del recibo",
            icon: "warning",
            buttons: ["Cancelar", "Aceptar"],
        }).then(async (value) => {
            if (value) {
                const res = await CallApiPost(URL, dta, null);
                if (res.status != 200) {
                    toastr.error(`Error ${res.error.Mensaje}`);
                } else {
                    RetunDta = res.success.Datos
                    await ReloadPageInfo();
                    //setObjHon(InitialModCom);
                    //SetPHon(objPago);
                }
                return RetunDta;
            }
        });
    }


    return (
        <>
            <Formik
                innerRef={formikRef}
                initialValues={recibo}
                enableReinitialize="true"
                validationSchema={validationSchemaPoliza}
                validateOnChange={(e) => console.log('validateChange')}
                onSubmit={(values, actions) => {
                    //SaveData(values);
                }} >
                {({
                    values,
                    errors,
                    status,
                    setFieldValue,
                    handleBlur,
                    handleChange,
                    handleSubmit,
                    isSubmitting,
                }) => (
                    <>
                        <form onKeyDown={LockEnter} onChange={(e) => HaveChange(e)} onSubmit={handleSubmit} className="form" autoComplete="off" >
                            <div className='row'>
                                <div className='col-md-12'>
                                    <div className='row mt-3'>
                                        <div className='col-md-12'>
                                            {/*  tabs */}
                                            <ul className="nav nav-tabs nav-justified" id="general" role="tablist">
                                                <li className="nav-item navr">
                                                    <a className="nav-link active" id="datos-generales-tab" data-toggle="tab" href="#datos-generales" role="tab" aria-controls="datos-generales" aria-selected="true">General</a>
                                                </li>
                                                <li className="nav-item navr">
                                                    <a className="nav-link" id="registro-pago-tab" data-toggle="tab" href="#registro-pago" role="tab" aria-controls="registro-pago" aria-selected="false">Registro de pago</a>
                                                </li>
                                                <li className="nav-item navr">
                                                    <a className="nav-link" id="comision-agente-tab" data-toggle="tab" href="#comision-agente" role="tab" aria-controls="comision-agente" aria-selected="false">Comisiones de agente</a>
                                                </li>
                                                <li className="nav-item navr">
                                                    <a className="nav-link" id="honorarios-vendedor-tab" data-toggle="tab" href="#honorarios-vendedor" role="tab" aria-controls="honorarios-vendedor" aria-selected="false">Honorarios de vendedor</a>
                                                </li>
                                            </ul>
                                        </div>
                                        <div className='col-md-12'>
                                            <div className="tab-content" id="generalTabContent">
                                                {/*  tab 1 */}
                                                <div className="tab-pane fade active show in" id="datos-generales" role="tabpanel" aria-labelledby="datos-generales-tab">
                                                    <div className='row mb-3'>
                                                        <div className='col-md-12 text-right'>
                                                            <a className='btn btn-primary btn-s' disabled={recibo.Status_TXT != 'Pendiente' ? true : false} data-toggle="tooltip" data-placement="bottom" title="Aplicar pago" onClick={() => SaveRecibos()}><i className="fa fa-credit-card" aria-hidden="true"></i>&nbsp;Guardar recibo</a>
                                                            <a className='btn btn-primary btn-s' disabled={recibo.Status_TXT == 'Cancelado' || recibo.Status_TXT == 'Cancelada' ? false : true} data-toggle="tooltip" data-placement="bottom" title="Aplicar pago" onClick={() => RehabiltarRecibo()}><i className="fa fa-check-circle" aria-hidden="true"></i>&nbsp;Rehabilitar recibo</a>
                                                            <a className='btn btn-primary btn-s' disabled={recibo.Status_TXT != 'Pendiente' ? true : false} data-toggle="tooltip" data-placement="bottom" title="Aplicar pago" onClick={() => RecalcularRecibo()}><i className="fa fa-refresh" aria-hidden="true"></i>&nbsp;Recalcular recibo</a>
                                                            <a className="btn btn-primary btn-s" onClick={() => { window.location = UrlPagina + `servicioSistema/${'recibos/' + (ItemInfoRecibo.IDTemp ? ItemInfoRecibo.IDTemp : 0) + '/' + Modulo}`; }} data-toggle="tooltip" data-placement="bottom" title="Regresar" ><i className="fa fa-reply" aria-hidden="true"></i>&nbsp;Regresar</a>
                                                        </div>
                                                    </div>

                                                    <div className='row mb-3'>
                                                        <div className='col-md-6'>
                                                            <div className='row mb-3'>
                                                                <div className='col-md-9'>
                                                                    <div className='form-group'>
                                                                        <label>Documento</label>
                                                                        <input type="text" className='form-control input-sm' name="Doc" id="Doc" disabled={true} value={ItemInfoRecibo.Documento ? ItemInfoRecibo.Documento : ''} onChange={() => ''} />
                                                                    </div>
                                                                </div>
                                                                <div className='col-md-3'>
                                                                    <div className='form-group'>
                                                                        <label>Inciso</label>
                                                                        <input type="text" className='form-control input-sm' name="Inc" id="Inc" disabled={true} value={ItemInfoRecibo.IncisoDoc ? ItemInfoRecibo.IncisoDoc : ''} onChange={() => ''} />
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <div className='row'>
                                                                <div className='col-md-12'>
                                                                    <div className='form-group'>
                                                                        <label>Cliente</label>
                                                                        <input type="text" className='form-control input-sm' name="clte" id="clte" disabled={true} value={ItemInfoRecibo.Cliente ? ItemInfoRecibo.Cliente : ''} onChange={() => ''} />
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <div className='row'>
                                                                <div className='col-md-6'>
                                                                    <div className='form-group'>
                                                                        <label>Ejecutivo</label>
                                                                        <input type="text" className='form-control input-sm' name="Ejc" id="Ejc" disabled={true} value={ItemInfoRecibo.Ejecutivo ? ItemInfoRecibo.Ejecutivo : ''} onChange={() => ''} />
                                                                    </div>
                                                                </div>
                                                                <div className='col-md-6'>
                                                                    <div className='form-group'>
                                                                        <label>Vendedor</label>
                                                                        <input type="text" className='form-control input-sm' name="Vend" id="Vend" disabled={true} value={ItemInfoRecibo.Vendedor ? ItemInfoRecibo.Vendedor : ''} onChange={() => ''} />
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <div className='row'>
                                                                <div className='col-md-10'>
                                                                    <div className='form-group'>
                                                                        <label>Referencia de pago</label>
                                                                        <input type="text" className='form-control input-sm' name="RefPago" id="RefPago" disabled={true} value={ItemInfoRecibo.ReferenciaPago ? ItemInfoRecibo.ReferenciaPago : ''} onChange={() => ''} />
                                                                    </div>
                                                                </div>
                                                                <div className='col-md-2'>
                                                                    <div className='form-group'>
                                                                        <label>Int pago</label>
                                                                        <input type="text" className='form-control input-sm' name="IntPago" id="IntPago" disabled={true} value={ItemInfoRecibo.IntPago ? ItemInfoRecibo.IntPago : '0'} onChange={() => ''} />
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <div className='row'>
                                                                <div className='col-md-6'>
                                                                    <div className='form-group'>
                                                                        <label>Ejecutivo de cobranza</label>
                                                                        <input type="text" className='form-control input-sm' name="EjecC" id="EjecC" disabled={true} value={ItemInfoRecibo.EjecutivoCobranza ? ItemInfoRecibo.EjecutivoCobranza : ''} onChange={() => ''} />
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div className='col-md-6'>
                                                            <div className='row'>
                                                                <div className='col-md-4'>
                                                                    <div className='form-group'>
                                                                        <label>Endoso</label>
                                                                        <input type="text" className='form-control input-sm' name="End" id="End" disabled={true} value={values.Endoso ? values.Endoso : ''} onChange={() => ''} />
                                                                    </div>
                                                                </div>
                                                                <div className='col-md-4'>
                                                                    <div className='form-group'>
                                                                        <label>Tipo Endoso</label>
                                                                        <input type="text" className='form-control input-sm' name="TEnd" id="TEnd" disabled={true} value={ItemInfoRecibo.TipoEndoso ? ItemInfoRecibo.TipoEndoso : ''} onChange={() => ''} />
                                                                    </div>
                                                                </div>
                                                                <div className='col-md-2'>
                                                                    <div className='form-group'>
                                                                        <label>Serie</label>
                                                                        <input type="text" className='form-control input-sm' name="Serie" id="Serie" disabled={true} value={values.Serie ? values.Serie : ''} onChange={() => ''} />
                                                                    </div>
                                                                </div>
                                                                <div className='col-md-2'>
                                                                    <div className='form-group'>
                                                                        <label>Periodo</label>
                                                                        <input type="text" className='form-control input-sm' name="Periodo" id="Periodo" disabled={true} value={values.Periodo ? values.Periodo : ''} onChange={() => ''} />
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <div className='row'>
                                                                <div className='col-md-12'>
                                                                    <div className='form-group'>
                                                                        <label>Ramo</label>
                                                                        <input type="text" className='form-control input-sm' name="Ramo" id="Ramo" disabled={true} value={ItemInfoRecibo.Ramo ? ItemInfoRecibo.Ramo : ''} onChange={() => ''} />
                                                                    </div>
                                                                </div>
                                                                <div className='col-md-12'>
                                                                    <div className='form-group'>
                                                                        <label>Compañia</label>
                                                                        <input type="text" className='form-control input-sm' name="Comp" id="Comp" disabled={true} value={ItemInfoRecibo.Compania ? ItemInfoRecibo.Compania : ''} onChange={() => ''} />
                                                                    </div>
                                                                </div>
                                                                <div className='col-md-12'>
                                                                    <div className='form-group'>
                                                                        <label>Agente</label>
                                                                        <input type="text" className='form-control input-sm' name="Agente" id="Agente" disabled={true} value={ItemInfoRecibo.Agente ? ItemInfoRecibo.Agente : ''} onChange={() => ''} />
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <div className='row'>
                                                                <div className='col-md-6'>
                                                                    <div className='form-group'>
                                                                        <label>Moneda</label>
                                                                        <input type="text" className='form-control input-sm' name="Moneda" id="Moneda" disabled={true} value={ItemInfoRecibo.Moneda ? ItemInfoRecibo.Moneda : ''} onChange={() => ''} />
                                                                    </div>
                                                                </div>
                                                                <div className='col-md-6'>
                                                                    <div className='form-group'>
                                                                        <label>Forma Pago</label>
                                                                        <input type="text" className='form-control input-sm' name="Fpago" id="Fpago" disabled={true} value={ItemInfoRecibo.FormaPago ? ItemInfoRecibo.FormaPago : ''} onChange={() => ''} />
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>

                                                    <br />
                                                    <div className='row mb-3'>
                                                        <div className='col-md-12 text-right'>
                                                            <a className="btn btn-primary btn-s" onClick={() => setIsEditar(!isEditar)} data-toggle="tooltip" data-placement="bottom"
                                                                title={isEditar ? "Cancelar" : "Editar"} >
                                                                {
                                                                    isEditar ?
                                                                        <i className="fa fa-close" aria-hidden="true">&nbsp;Cancelar</i>
                                                                        :
                                                                        <i className="fa fa-edit" aria-hidden="true">&nbsp;Editar</i>
                                                                }
                                                            </a>
                                                        </div>
                                                        <div className='col-md-4'>
                                                            <div className='row'>
                                                                <div className='col-md-12'>
                                                                    <h6>DETALLE DE PRIMAS</h6>
                                                                    <hr />
                                                                </div>

                                                                <DetallePrimas handleBlur={handleBlur} setFieldValue={setFieldValue} disabled={disabled}
                                                                    NewReloadPrices={NewReloadPrices} FocusInput={FocusInput} values={values} Modulo={Modulo}
                                                                    moduloOrigen={moduloOrigen} isEditar={isEditar} />

                                                            </div>
                                                        </div>
                                                        <div className='col-md-4'>
                                                            <div className='col-md-12'>
                                                                <h6>DETALLE DE COMISIONES</h6>
                                                                <hr />
                                                            </div>

                                                            <DetalleComisiones handleBlur={handleBlur} setFieldValue={setFieldValue} disabled={disabled}
                                                                NewReloadPrices={NewReloadPrices} FocusInput={FocusInput} values={values} Modulo={Modulo}
                                                                moduloOrigen={moduloOrigen} isEditar={isEditar} TComisines={TComisines} />

                                                        </div>
                                                        <div className='col-md-4'>
                                                            <div className='row'>
                                                                <div className='col-md-12'>
                                                                    <div className='form-group'>
                                                                        <label>Estatus</label>
                                                                        <input type="text" value={values.Status_TXT ? values.Status_TXT : "Sin Estatus"} className='form-control input-sm' name="Estatus" id="Estatus" disabled={true} />
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <div className='row'>
                                                                <div className='col-md-6'>
                                                                    <div className='form-group'>
                                                                        <label>Desde</label>
                                                                        <input
                                                                            type="date"
                                                                            className='form-control input-sm'
                                                                            name="Desde"
                                                                            id="Desde"
                                                                            disabled
                                                                            value={values.FDesde ? moment(values.FDesde).format("YYYY-MM-DD") : ''}
                                                                        //onChange={(e) => ChangeValueRecibo(values, 'Desde', e.target.value)} 
                                                                        />
                                                                    </div>
                                                                </div>
                                                                <div className='col-md-6'>
                                                                    <div className='form-group'>
                                                                        <label>Hasta</label>
                                                                        <input
                                                                            type="date"
                                                                            className='form-control input-sm'
                                                                            name="Hasta"
                                                                            id="Hasta"
                                                                            disabled
                                                                            value={values.FHasta ? moment(values.FHasta).format("YYYY-MM-DD") : ''}
                                                                        //onChange={(e) => ChangeValueRecibo(values, 'FHasta', e.target.value)} 
                                                                        />
                                                                    </div>
                                                                </div>
                                                                <div className='col-md-6'>
                                                                    <div className='form-group'>
                                                                        <label>Generación</label>
                                                                        <input
                                                                            type="date"
                                                                            className='form-control input-sm'
                                                                            name="Generacion"
                                                                            id="Generacion"
                                                                            disabled
                                                                            value={values.FGeneracion ? moment(values.FGeneracion).format("YYYY-MM-DD") : ''}
                                                                        //onChange={(e) => ChangeValueRecibo(values, 'FGeneracion', e.target.value)}
                                                                        />
                                                                    </div>
                                                                </div>
                                                                <div className='col-md-6'>
                                                                    <div className='form-group'>
                                                                        <label>Limite Pago</label>
                                                                        <input
                                                                            type="date"
                                                                            className='form-control input-sm'
                                                                            name="Lpago"
                                                                            id="Lpago"
                                                                            disabled
                                                                            value={values.FLimPago ? moment(values.FLimPago).format("YYYY-MM-DD") : ''}
                                                                        //onChange={(e) => ChangeValueRecibo(values, 'FLimPago', e.target.value)}
                                                                        />
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>

                                                {/* tab 2 */}
                                                <div className='tab-pane fade' id="registro-pago" role="tabpanel" aria-labelledby="registro-pago-tab">
                                                    <div className='row mb-3'>
                                                        <div className='col-md-12 text-right'>
                                                            <a className='btn btn-primary btn-s' disabled={recibo.Status_TXT == 'Pendiente' ? false : true} data-toggle="tooltip" data-placement="bottom" title="Aplicar pago" onClick={() => AplicarPago("Aplicar")}><i className="fa fa-credit-card" aria-hidden="true"></i>&nbsp;Aplicar pago</a>
                                                            <a className='btn btn-primary btn-s' disabled={recibo.Status_TXT == 'Aplicado' ? false : true} data-toggle="tooltip" data-placement="bottom" title="Editar" onClick={() => AplicarPago("Editar")}><i className="fa fa-edit" aria-hidden="true"></i>&nbsp;Editar</a>
                                                            <a className='btn btn-primary btn-s' disabled={recibo.Status_TXT == 'Aplicado' ? false : true} data-toggle="tooltip" data-placement="bottom" title="Anular pago" onClick={() => AnularPago()}><i className="fa fa-times-circle" aria-hidden="true"></i>&nbsp;Anular pago</a>
                                                            <a className='btn btn-primary btn-s' disabled={recibo.Status_TXT == 'Aplicado' ? false : true} data-toggle="tooltip" data-placement="bottom" title="Liquidar" onClick={() => Liquidar()}><i className="fa fa-check-circle" aria-hidden="true"></i>&nbsp;Liquidar</a>
                                                            <a className='btn btn-primary btn-s' disabled={recibo.Status_TXT == 'Liquidado' ? false : true} data-toggle="tooltip" data-placement="bottom" title="Desliquidar" onClick={() => DesliquidarPago()}><i className="fa fa-undo" aria-hidden="true"></i>&nbsp;Desliquidar</a>
                                                            <a className="btn btn-primary btn-s" onClick={() => { window.location = UrlPagina + `servicioSistema/${'recibos/' + (ItemInfoRecibo.IDTemp ? ItemInfoRecibo.IDTemp : 0) + '/' + Modulo}`; }} data-toggle="tooltip" data-placement="bottom" title="Regresar" ><i className="fa fa-reply" aria-hidden="true"></i>&nbsp;Regresar</a>

                                                        </div>
                                                    </div>

                                                    <div className='row mb-3'>
                                                        <div className='col-md-12'>
                                                            <table className="table table-condensed" id="recibos">
                                                                <thead>
                                                                    <tr>
                                                                        <th scope="col" style={{ width: '200px' }}>Fecha de pago</th>
                                                                        <th scope="col" style={{ width: '200px' }}>Moneda pago</th>
                                                                        <th scope="col" style={{ width: '200px' }}>Importe del pago</th>
                                                                        <th scope="col" style={{ width: '200px' }}>Importe real</th>
                                                                        <th scope="col" style={{ width: '200px' }}>Tipo de documento</th>
                                                                        <th scope="col" style={{ width: '200px' }}>Confirmación liq.</th>
                                                                        <th scope="col" style={{ width: '200px' }}>Tipo de pago</th>
                                                                    </tr>
                                                                </thead>
                                                                <tbody style={{ maxHeight: '200px', height: '100px', overflow: 'auto' }}>
                                                                    {pagos.length == 0 && (
                                                                        <tr className='text-center'><td colSpan={11}>No hay registros de pagos.</td></tr>
                                                                    )}
                                                                    {pagos && pagos.map((item, key) => (
                                                                        <tr key={key} className='cursor-pointer'>
                                                                            <td>{moment(item.FechaPago).format("DD/MM/YYYY")}</td>
                                                                            <td>{item.DMonedaPago ? item.DMonedaPago : 'N/A'}</td>
                                                                            <td>{FormatItem(item.ImportePago)}</td>
                                                                            <td>{FormatItem(item.ImporteReal)}</td>
                                                                            <td>{item.DTipoDocumento ? item.DTipoDocumento : 'N/A'}</td>
                                                                            <td>{item.ConfirmacionLiq ? 'Si' : 'No'}</td>
                                                                            <td>{item.DTipoPago ? item.DTipoPago : 'N/A'}</td>
                                                                        </tr>
                                                                    ))}
                                                                </tbody>
                                                            </table>
                                                        </div>
                                                    </div>

                                                    <div className='row mb-2'>
                                                        <div className='col-md-12'>
                                                            <div className='col-md-3'>
                                                                <div className="form-group row">
                                                                    <div className='col-sm-4' style={{ paddingRight: 'unset' }}>
                                                                        <label className='col-form-label titulo'>Prima enviada</label>
                                                                    </div>
                                                                    <div className="col-sm-8" style={{ paddingRight: 'unset' }}>
                                                                        <CurrencyInputField
                                                                            disabled
                                                                            className='form-control input-sm numeric'
                                                                            onBlur={() => handleBlur}
                                                                            min={0}
                                                                            maxLength={10}
                                                                            //prefix='$'
                                                                            decimalSeparator='.'
                                                                            groupSeparator=','
                                                                            decimalsLimit={2}
                                                                            decimalScale={2}
                                                                            onFocus={FocusInput}
                                                                            allowNegativeValue={false}
                                                                            value={selectedPago.PrimaEnviada}
                                                                            onValueChange={(value, name) => { setFieldValue(name, value)/* ,ReloadPrices(values) */ }}
                                                                            id='PrimaEnviada'
                                                                            name='PrimaEnviada'
                                                                            autoComplete='off'
                                                                        />
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <div className='col-md-3'>
                                                                <div className="form-group row">
                                                                    <div className='col-sm-4' style={{ paddingRight: 'unset' }}>
                                                                        <label className='col-form-label titulo'>Prima total</label>
                                                                    </div>
                                                                    <div className="col-sm-8" style={{ paddingRight: 'unset' }}>
                                                                        <CurrencyInputField
                                                                            disabled
                                                                            className='form-control input-sm numeric'
                                                                            onBlur={() => handleBlur}
                                                                            min={0}
                                                                            maxLength={10}
                                                                            //prefix='$'
                                                                            decimalSeparator='.'
                                                                            groupSeparator=','
                                                                            decimalsLimit={2}
                                                                            decimalScale={2}
                                                                            onFocus={FocusInput}
                                                                            allowNegativeValue={false}
                                                                            value={selectedPago.PrimaTotal}
                                                                            onValueChange={(value, name) => { setFieldValue(name, value)/* ,ReloadPrices(values) */ }}
                                                                            id='PrimaTotal'
                                                                            name='PrimaTotal'
                                                                            autoComplete='off'
                                                                        />
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <div className='col-md-3'>
                                                                <div className="form-group row">
                                                                    <div className='col-sm-4' style={{ paddingRight: 'unset' }}>
                                                                        <label className='col-form-label titulo'>Prima pagada</label>
                                                                    </div>
                                                                    <div className="col-sm-8" style={{ paddingRight: 'unset' }}>
                                                                        <CurrencyInputField
                                                                            disabled
                                                                            className='form-control input-sm numeric'
                                                                            onBlur={() => handleBlur}
                                                                            min={0}
                                                                            maxLength={10}
                                                                            //prefix='$'
                                                                            decimalSeparator='.'
                                                                            groupSeparator=','
                                                                            decimalsLimit={2}
                                                                            decimalScale={2}
                                                                            onFocus={FocusInput}
                                                                            allowNegativeValue={false}
                                                                            value={selectedPago.PrimaPagada}
                                                                            onValueChange={(value, name) => { setFieldValue(name, value)/* ,ReloadPrices(values) */ }}
                                                                            id='PrimaPagada'
                                                                            name='PrimaPagada'
                                                                            autoComplete='off'
                                                                        />
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <div className='col-md-3'>
                                                                <div className="form-group row">
                                                                    <div className='col-sm-4' style={{ paddingRight: 'unset' }}>
                                                                        <label className='col-form-label titulo'>Prima pendiente</label>
                                                                    </div>
                                                                    <div className="col-sm-8" style={{ paddingRight: 'unset' }}>
                                                                        <CurrencyInputField
                                                                            disabled
                                                                            className='form-control input-sm numeric'
                                                                            onBlur={() => handleBlur}
                                                                            min={0}
                                                                            maxLength={10}
                                                                            //prefix='$'
                                                                            decimalSeparator='.'
                                                                            groupSeparator=','
                                                                            decimalsLimit={2}
                                                                            decimalScale={2}
                                                                            onFocus={FocusInput}
                                                                            allowNegativeValue={false}
                                                                            value={selectedPago.PrimaPendiente}
                                                                            onValueChange={(value, name) => { setFieldValue(name, value)/* ,ReloadPrices(values) */ }}
                                                                            id='PrimaPendiente'
                                                                            name='PrimaPendiente'
                                                                            autoComplete='off'
                                                                        />
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>

                                                    <div className='row mb-2'>
                                                        <div className='col-md-12'>
                                                            <div className='card'>
                                                                <div className='card-body p-0'>
                                                                    <div className='row'>
                                                                        <div className='col-md-2 mb-2'>
                                                                            <div className="form-group">
                                                                                <label htmlFor="txMotivo">Fecha de pago</label>
                                                                                <input
                                                                                    className="form-control input-sm"
                                                                                    type="date"
                                                                                    name="FechaPago"
                                                                                    id="FechaPago"
                                                                                    disabled
                                                                                    onBlur={() => { handleBlur }}
                                                                                    onChange={handleChange}
                                                                                    value={selectedPago.FechaPago}
                                                                                    data-toggle="tooltip" data-placement="bottom" title="Fecha de pago"
                                                                                />
                                                                            </div>
                                                                        </div>
                                                                        <div className='col-md-2 mb-2'>
                                                                            <div className="form-group">
                                                                                <label htmlFor="txMotivo">Tipo de documento</label>
                                                                                <input
                                                                                    type="text"
                                                                                    name="DTipoDocumento"
                                                                                    id="DTipoDocumento"
                                                                                    disabled
                                                                                    onChange={(e) => { handleChange }}
                                                                                    onFocus={FocusInput}
                                                                                    //onClick={() => { $("#ModalRPago").modal('handleUpdate') }}
                                                                                    value={selectedPago.DTipoDocumento}
                                                                                    className="form-control input-sm"
                                                                                    autoComplete="off"
                                                                                />
                                                                            </div>
                                                                        </div>
                                                                        <div className='col-md-3 mb-2'>
                                                                            <div className="form-group">
                                                                                <label htmlFor="txMotivo">Banco</label>
                                                                                <input
                                                                                    type="text"
                                                                                    name="DBanco"
                                                                                    id="DBanco"
                                                                                    disabled
                                                                                    onChange={(e) => { handleChange }}
                                                                                    onFocus={FocusInput}
                                                                                    value={selectedPago.DBanco}
                                                                                    className="form-control input-sm"
                                                                                    autoComplete="off"
                                                                                />
                                                                            </div>
                                                                        </div>
                                                                        <div className='col-md-3 mb-2'>
                                                                            <div className="form-group">
                                                                                <label htmlFor="txMotivo">No. documento</label>
                                                                                <input
                                                                                    type="text"
                                                                                    name="NoDocumento"
                                                                                    id="NoDocumento"
                                                                                    onFocus={FocusInput}
                                                                                    disabled
                                                                                    onChange={(e) => handleChange}
                                                                                    value={selectedPago.NoDocumento}
                                                                                    className="form-control input-sm"
                                                                                    autoComplete="off"
                                                                                />
                                                                            </div>
                                                                        </div>
                                                                        <div className='col-md-2 mb-2'>
                                                                            <div className='form-group'>
                                                                                <label htmlFor="txMotivo">
                                                                                    Fecha documento
                                                                                </label>
                                                                                <input
                                                                                    className="form-control input-sm"
                                                                                    type="date"
                                                                                    name="FechaDocumento"
                                                                                    id="FechaDocumento"
                                                                                    disabled
                                                                                    onBlur={() => handleBlur}
                                                                                    onChange={handleChange}
                                                                                    value={selectedPago.FechaDocumento}
                                                                                    data-toggle="tooltip" data-placement="bottom" title="Fecha documento"
                                                                                />
                                                                            </div>
                                                                        </div>
                                                                        <div className='col-md-3 mb-2'>
                                                                            <div className="form-group">
                                                                                <label htmlFor="txMotivo">Folio de cheque</label>
                                                                                <input
                                                                                    type="text"
                                                                                    name="FolioCheque"
                                                                                    id="FolioCheque"
                                                                                    disabled
                                                                                    onFocus={FocusInput}
                                                                                    onChange={(e) => handleChange}
                                                                                    value={selectedPago.FolioCheque}
                                                                                    className="form-control input-sm"
                                                                                    autoComplete="off"
                                                                                />
                                                                            </div>
                                                                        </div>
                                                                        <div className='col-md-2 mb-2'>
                                                                            <div className="form-group">
                                                                                <label htmlFor="txMotivo">Tipo de pago</label>
                                                                                <input
                                                                                    type="text"
                                                                                    name="DTipoPago"
                                                                                    id="DTipoPago"
                                                                                    disabled
                                                                                    onFocus={FocusInput}
                                                                                    onChange={(e) => handleChange}
                                                                                    value={selectedPago.DTipoPago}
                                                                                    className="form-control input-sm"
                                                                                    autoComplete="off"
                                                                                />
                                                                            </div>
                                                                        </div>
                                                                        <div className='col-md-5 mb-2'>
                                                                            <label htmlFor="txMotivo"><p></p></label>
                                                                            <div className='form-group'>
                                                                                <h6>{selectedPago.UsuarioAplica}</h6>
                                                                                <hr />
                                                                            </div>
                                                                        </div>
                                                                        <div className='col-md-2 mb-2'>
                                                                            <label htmlFor="txMotivo"><p></p></label>
                                                                            <div className='form-group'>
                                                                                <h6>{selectedPago.FechaAplica ? moment(selectedPago.FechaAplica).format('DD/MM/YYYY h:mm A') : ''}</h6>
                                                                                <hr />
                                                                            </div>
                                                                        </div>
                                                                        <div className='col-md-5 p-0'>
                                                                            <div className='col-sm-4'>
                                                                                <div className="form-group">
                                                                                    <label htmlFor="txMotivo">Moneda pago</label>
                                                                                    <input
                                                                                        type="text"
                                                                                        name="DMonedaPago"
                                                                                        id="DMonedaPago"
                                                                                        disabled
                                                                                        onFocus={FocusInput}
                                                                                        onChange={(e) => handleChange}
                                                                                        value={selectedPago.DMonedaPago}
                                                                                        className="form-control input-sm"
                                                                                        autoComplete="off"
                                                                                    />
                                                                                </div>
                                                                            </div>
                                                                            <div className='col-sm-4'>
                                                                                <div className="form-group">
                                                                                    <label htmlFor="txMotivo">
                                                                                        Tipo de cambio
                                                                                    </label>
                                                                                    <CurrencyInputField
                                                                                        className='form-control input-sm numeric mb-3'
                                                                                        disabled
                                                                                        onBlur={() => { handleBlur }}
                                                                                        min={0}
                                                                                        maxLength={10}
                                                                                        decimalsLimit={4}
                                                                                        decimalScale={4}
                                                                                        //prefix='$'
                                                                                        decimalSeparator='.'
                                                                                        groupSeparator=','
                                                                                        onFocus={FocusInput}
                                                                                        allowNegativeValue={false}
                                                                                        value={selectedPago.TipoCambio1}
                                                                                        onValueChange={(value, name) => { setFieldValue(name, value) }}
                                                                                        id='TipoCambio1'
                                                                                        name='TipoCambio1'
                                                                                        autoComplete='off'
                                                                                    />
                                                                                </div>
                                                                            </div>
                                                                            <div className='col-sm-4'>
                                                                                <div className="form-group">
                                                                                    <label htmlFor="txMotivo">
                                                                                        Importe del pago
                                                                                    </label>
                                                                                    <CurrencyInputField
                                                                                        className='form-control input-sm numeric'
                                                                                        disabled
                                                                                        onBlur={() => { handleBlur }}
                                                                                        min={0}
                                                                                        maxLength={10}
                                                                                        decimalsLimit={2}
                                                                                        decimalScale={2}
                                                                                        //prefix='$'
                                                                                        decimalSeparator='.'
                                                                                        groupSeparator=','
                                                                                        onFocus={FocusInput}
                                                                                        allowNegativeValue={false}
                                                                                        value={selectedPago.ImportePago}
                                                                                        onValueChange={(value, name) => { setFieldValue(name, value) }}
                                                                                        id='ImportePago'
                                                                                        name='ImportePago'
                                                                                        autoComplete='off'
                                                                                    />
                                                                                </div>
                                                                            </div>
                                                                        </div>
                                                                        <div className='col-md-3 mb-2'>
                                                                            <div className="form-group">
                                                                                <label htmlFor="txMotivo">Moneda del docto.</label>
                                                                                <input
                                                                                    type="text"
                                                                                    name="DMonedaDcto"
                                                                                    id="DMonedaDcto"
                                                                                    disabled
                                                                                    onFocus={FocusInput}
                                                                                    onChange={(e) => handleChange}
                                                                                    value={selectedPago.DMonedaDcto}
                                                                                    className="form-control input-sm"
                                                                                    autoComplete="off"
                                                                                />
                                                                            </div>
                                                                        </div>
                                                                        <div className='col-md-2 mb-2'>
                                                                            <div className="form-group">
                                                                                <label htmlFor="txMotivo">
                                                                                    Tipo de cambio
                                                                                </label>
                                                                                <CurrencyInputField
                                                                                    className='form-control input-sm numeric mb-3'
                                                                                    disabled
                                                                                    onBlur={() => { handleBlur }}
                                                                                    min={0}
                                                                                    maxLength={10}
                                                                                    decimalsLimit={4}
                                                                                    decimalScale={4}
                                                                                    //prefix='$'
                                                                                    decimalSeparator='.'
                                                                                    groupSeparator=','
                                                                                    onFocus={FocusInput}
                                                                                    allowNegativeValue={false}
                                                                                    value={selectedPago.TipoCambio2}
                                                                                    onValueChange={(value, name) => { setFieldValue(name, value) }}
                                                                                    id='TipoCambio2'
                                                                                    name='TipoCambio2'
                                                                                    autoComplete='off'
                                                                                />
                                                                            </div>
                                                                        </div>
                                                                        <div className='col-md-2 mb-2'>
                                                                            <div className="form-group">
                                                                                <label htmlFor="txMotivo">Importe real</label>
                                                                                <CurrencyInputField
                                                                                    className='form-control input-sm numeric'
                                                                                    disabled
                                                                                    onBlur={() => { handleBlur }}
                                                                                    min={0}
                                                                                    maxLength={10}
                                                                                    decimalsLimit={2}
                                                                                    decimalScale={2}
                                                                                    //prefix='$'
                                                                                    decimalSeparator='.'
                                                                                    groupSeparator=','
                                                                                    onFocus={FocusInput}
                                                                                    allowNegativeValue={false}
                                                                                    value={selectedPago.ImporteReal}
                                                                                    onValueChange={(value, name) => { setFieldValue(name, value) }}
                                                                                    id='ImporteReal'
                                                                                    name='ImporteReal'
                                                                                    autoComplete='off'
                                                                                />
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>

                                                    <div className='row mb-2'>
                                                        <div className='col-md-12'>
                                                            <div className='card'>
                                                                <div className='card-body p-0'>
                                                                    <div className='row'>
                                                                        <div className='col-md-3 mb-2'>
                                                                            <div className="form-group">
                                                                                <label htmlFor="txMotivo">Número liquidación</label>
                                                                                <input
                                                                                    type="text"
                                                                                    name="NoLiq"
                                                                                    id="NoLiq"
                                                                                    disabled
                                                                                    onChange={(e) => { handleChange }}
                                                                                    onFocus={FocusInput}
                                                                                    value={selectedPago.NoLiq}
                                                                                    className="form-control input-sm"
                                                                                    autoComplete="off"
                                                                                />
                                                                            </div>
                                                                        </div>
                                                                        <div className='col-md-3 mb-2'>
                                                                            <div className="form-group">
                                                                                <label htmlFor="txMotivo">Folio liquidación cía.</label>
                                                                                <input
                                                                                    type="text"
                                                                                    name="FolioLiqCia"
                                                                                    id="FolioLiqCia"
                                                                                    disabled
                                                                                    onChange={(e) => { handleChange }}
                                                                                    onFocus={FocusInput}
                                                                                    value={selectedPago.FolioLiqCia}
                                                                                    className="form-control input-sm"
                                                                                    autoComplete="off"
                                                                                />
                                                                            </div>
                                                                        </div>
                                                                        <div className='col-md-2 mb-2'>
                                                                            <div className="form-group">
                                                                                <label htmlFor="txMotivo">Fecha liquidación</label>
                                                                                <input
                                                                                    type="date"
                                                                                    name="FLiq"
                                                                                    id="FLiq"
                                                                                    disabled
                                                                                    onChange={(e) => { handleChange }}
                                                                                    onFocus={FocusInput}
                                                                                    value={moment(selectedPago.FLiq).format('YYYY-MM-DD')}
                                                                                    className="form-control input-sm"
                                                                                    autoComplete="off"
                                                                                />
                                                                            </div>
                                                                        </div>
                                                                        <div className='col-md-2 mb-2'>
                                                                            <div className="form-group">
                                                                                <label htmlFor="txMotivo">Confirmación liq.</label>
                                                                                <input
                                                                                    type="text"
                                                                                    name="ConfirmacionLiq"
                                                                                    id="ConfirmacionLiq"
                                                                                    disabled
                                                                                    onChange={(e) => { handleChange }}
                                                                                    onFocus={FocusInput}
                                                                                    value={recibo.Status_TXT == 'Pendiente' ? '' : selectedPago.ConfirmacionLiq ? 'SI' : 'NO'}
                                                                                    className="form-control input-sm"
                                                                                    autoComplete="off"
                                                                                />
                                                                            </div>
                                                                        </div>
                                                                        <div className='col-md-2 mb-2'>
                                                                            <div className="form-group">
                                                                                <label htmlFor="txMotivo">Fecha de confirmación</label>
                                                                                <input
                                                                                    className="form-control input-sm"
                                                                                    type="date"
                                                                                    name="FConfirmacion"
                                                                                    id="FConfirmacion"
                                                                                    disabled
                                                                                    onBlur={() => { handleBlur }}
                                                                                    onChange={handleChange}
                                                                                    value={moment(selectedPago.FConfirmacion).format('YYYY-MM-DD')}
                                                                                    data-toggle="tooltip" data-placement="bottom" title="Fecha de pago"
                                                                                />
                                                                            </div>
                                                                        </div>
                                                                        <div className='col-md-5 mb-0'></div>
                                                                        <div className='col-md-5 mb-0'>
                                                                            <label htmlFor="txMotivo"><p></p></label>
                                                                            <div className='form-group'>
                                                                                <h6>{selectedPago.UsuarioLiq}</h6>
                                                                                <hr />
                                                                            </div>
                                                                        </div>
                                                                        <div className='col-md-2 mb-0'>
                                                                            <label htmlFor="txMotivo"><p></p></label>
                                                                            <div className='form-group'>
                                                                                <h6>{selectedPago.FechaLiquidacionUsuario ? moment(selectedPago.FechaLiquidacionUsuario).format('DD/MM/YYYY h:mm A') : ''}</h6>
                                                                                {/*  <h6>{selectedPago.FechaLiquidacion ? moment(selectedPago.FechaLiquidacion).format('DD/MM/YYYY h:mm') : ''}</h6> */}
                                                                                <hr />
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>

                                                    <div className='row'>
                                                        <div className='col-md-12'>
                                                            <div className='col-md-6' style={{ paddingLeft: 'unset' }}>
                                                                <div className="form-group">
                                                                    <label htmlFor="txMotivo">Observaciones</label>
                                                                    <textarea
                                                                        type="text"
                                                                        name="DTipoDocumento"
                                                                        id="DTipoDocumento"
                                                                        rows={3}
                                                                        disabled
                                                                        onChange={(e) => { handleChange }}
                                                                        onFocus={FocusInput}
                                                                        value={values.DTipoDocumento ? values.DTipoDocumento : ''}
                                                                        className="form-control input-sm"
                                                                        autoComplete="off"></textarea>
                                                                </div>
                                                            </div>
                                                            <div className='col-md-6' style={{ paddingRight: 'unset' }}>
                                                                <div className="form-group">
                                                                    <label htmlFor="txMotivo">Concentrado de cheques</label>
                                                                    <textarea
                                                                        type="text"
                                                                        name="DTipoDocumento"
                                                                        id="DTipoDocumento"
                                                                        rows={3}
                                                                        disabled
                                                                        onChange={(e) => { handleChange }}
                                                                        onFocus={FocusInput}
                                                                        value={values.DTipoDocumento ? values.DTipoDocumento : ''}
                                                                        className="form-control input-sm"
                                                                        autoComplete="off"></textarea>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>

                                                {/* tab 3 */}
                                                <div className='tab-pane fade' id="comision-agente" role="tabpanel" aria-labelledby="comision-agente-tab">
                                                    <div className='row mb-3'>
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
                                                                    {comisiones.length == 0 && (
                                                                        <tr>
                                                                            <td className='text-center' colSpan={5}>NO EXISTEN CONFIGURACIONES</td>
                                                                        </tr>
                                                                    )}
                                                                    {comisiones && comisiones.map((item, key) => (
                                                                        <tr key={key} style={item.Id == ObjCom.Id ? { cursor: 'pointer', backgroundColor: '#6f42c1', color: 'white' } : { cursor: 'pointer' }} onClick={() => clicObjeto(item, 1)}>
                                                                            <td>{item.AgenteNombre}</td>
                                                                            <td>{item.TipoAgente}</td>
                                                                            <td>{item.TipoC}</td>
                                                                            <td>{item.Participacion}</td>
                                                                            <td>{FormatItem(item.ImporteCal)}</td>
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
                                                                            <a className="btn btn-primary btn-s" type="submit" data-toggle="tooltip" data-placement="bottom" title="Guardar" onClick={() => SaveHonObj(1)}><i className="fa fa-floppy-o" aria-hidden="true"></i></a>
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
                                                                                    value={displayitem(ObjCom.IDAgente, InitialDataInfo.Agentes, 'Agente')}
                                                                                    options={mapitems(InitialDataInfo.Agentes ? InitialDataInfo.Agentes : [], '')}
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
                                                                        {/* <div className='col-md-6'>
                                                                            <div className='form-group'>
                                                                                <label>Pendiente</label>
                                                                                <input type="text" className='form-control input-sm' value={ObjCom.Pendiente} name="Pendiente" id="Pendiente" disabled />
                                                                            </div>
                                                                        </div> */}
                                                                    </div>
                                                                    <div className='row'>
                                                                        <div className='col-md-12'>
                                                                            <div className='form-group'>
                                                                                <label>Creación</label>
                                                                                <input type="text" className='form-control input-sm' value={ObjCom.Creacion} name="Creacion" id="Creacion" disabled />
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                                <div className='col-md-6'>
                                                                    <div className='col-md-12'>
                                                                        <div className='col-md-12'>
                                                                            <h6>DETALLE DE PAGO COMISIONES</h6>
                                                                            <hr />
                                                                        </div>
                                                                        <div className='row'>
                                                                            <table style={{ width: '95% !important' }} className="table table-condensed" id="TCRecibos">
                                                                                <thead>
                                                                                    <tr>
                                                                                        <th scope="col" style={{ width: '100px' }}>Fecha Aplicación</th>
                                                                                        <th scope="col" style={{ width: '100px' }}>Documento Cobro</th>
                                                                                        <th scope="col" style={{ width: '100px' }}>Folio Liquidación</th>
                                                                                        <th scope="col" style={{ width: '100px' }}>Moneda Docto</th>

                                                                                    </tr>
                                                                                </thead>
                                                                                <tbody style={{ maxHeight: '400px', overflow: 'auto' }}>
                                                                                    {ObjCom.Registros.length == 0 && (
                                                                                        <tr className='text-center'><td colSpan={4}>No hay registros de captura.</td></tr>
                                                                                    )}
                                                                                    {ObjCom.Registros && ObjCom.Registros.map((item, key) => (
                                                                                        <tr key={key} >
                                                                                            <td>{item.FAplicado ? moment(item.FAplicado).format("DD/MM/YYYY") : 'N/A'}</td>
                                                                                            <td>{item.CDocumento ? item.CDocumento : 'N/A'}</td>
                                                                                            <td>{item.CFolio ? item.CFolio : 'N/A'}</td>
                                                                                            <td>{item.MonedaPago ? item.MonedaPago : 'N/A'}</td>
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
                                                </div>

                                                {/* tab 4 */}
                                                <div className='tab-pane fade' id="honorarios-vendedor" role="tabpanel" aria-labelledby="honorarios-vendedor-tab">
                                                    <div className='row mb-3'>
                                                        <div className='col-md-12'>
                                                            <table className="table" id="comisionesagente">
                                                                <thead style={{ fontSize: '12px' }}>
                                                                    <tr>
                                                                        <th scope="col">Vendedor</th>
                                                                        <th scope="col" className='text-center'>Tipo valor</th>
                                                                        <th scope="col" className='text-center'>Base calculo</th>
                                                                        <th scope="col" className='text-center'>Participación</th>
                                                                        <th scope="col" className='text-center'>Fórmula</th>
                                                                        <th scope="col">Importe1</th>
                                                                        {/*   <th scope="col" style={{ textAlign: 'center' }}>Acciones</th> */}
                                                                    </tr>
                                                                </thead>
                                                                <tbody>
                                                                    {honorarios.length == 0 && (
                                                                        <tr>
                                                                            <td className='text-center' colSpan={7}>NO EXISTEN CONFIGURACIONES</td>
                                                                        </tr>
                                                                    )}
                                                                    {honorarios && honorarios.map((item, key) => (
                                                                        <tr key={key} style={item.Id == ObjHon.Id ? { cursor: 'pointer', backgroundColor: '#6f42c1', color: 'white' } : { cursor: 'pointer' }} onClick={() => clicObjeto(item, 2)}>
                                                                            <td>{item.NombreCompleto}</td>
                                                                            <td className='text-center'>{item.TipoValor}</td>
                                                                            <td className='text-center'>{FormatItem(item.Base)}</td>
                                                                            <td className='text-center'>{item.Porcentaje}</td>
                                                                            <td className='text-center'>{item.Formula}</td>
                                                                            <td>{FormatItem(item.ImporteCal)}</td>
                                                                            {/* <td>{FormatItem(ImporteHonorarios(item, "honorario"))}</td> */}
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
                                                                            <a className="btn btn-primary btn-s" type="submit" data-toggle="tooltip" data-placement="bottom" title="Guardar" onClick={() => SaveHonObj(2)}><i className="fa fa-floppy-o" aria-hidden="true"></i></a>
                                                                            {ObjHon.Id > 0 && ObjHon.Registros.length == 0 && (
                                                                                <a className="btn btn-primary btn-s" type="submit" data-toggle="tooltip" data-placement="bottom" title="Aplicar pago" onClick={() => CargarPagoHonorario()}><i className="fa fa-check" aria-hidden="true"></i></a>
                                                                            )}
                                                                            {ObjHon.Id > 0 && ObjHon.Registros.length > 0 && (
                                                                                <a className="btn btn-primary btn-s" type="submit" data-toggle="tooltip" data-placement="bottom" title="Anular pago" onClick={() => ElminarPagoHon()}><i className="fa fa-times" aria-hidden="true"></i></a>
                                                                            )}
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
                                                                                    value={displayitem(ObjHon.IDAgente, InitialDataInfo.Vendedores, 'Agente')}
                                                                                    options={mapitems(InitialDataInfo.Vendedores ? InitialDataInfo.Vendedores : [], '')}
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
                                                                    <div className='row'>
                                                                        <div className='col-md-12'>
                                                                            <div className='form-group'>
                                                                                <label>Creación</label>
                                                                                <input type="text" className='form-control input-sm' value={ObjHon.Creacion} name="Creacion" id="Creacion" disabled />
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                                <div className='col-md-6'>
                                                                    <div className='col-md-12'>
                                                                        <div className='col-md-12'>
                                                                            <h6>DETALLE DE PAGO HONORARIOS</h6>
                                                                            <hr />
                                                                        </div>
                                                                        <div className='row'>
                                                                            <div className='col-md-12'>
                                                                                <div className='form-group'>
                                                                                    <label htmlFor="">Documento</label>
                                                                                    <input disabled={true} type="text" className='form-control input-sm' value={ObjHon.Registros.length > 0 ? ObjHon.Registros[0].CDocumento : ''} />
                                                                                </div>
                                                                            </div>
                                                                        </div>
                                                                        <div className='row'>
                                                                            <div className='col-md-6'>
                                                                                <div className='form-group'>
                                                                                    <label htmlFor="">Fecha Pago</label>
                                                                                    <input disabled={true} type="date" className='form-control input-sm' value={ObjHon.Registros.length > 0 ? moment(ObjHon.Registros[0].FDocumento).format("YYYY-MM-DD") : ''} />
                                                                                </div>
                                                                            </div>
                                                                            <div className='col-md-6'>
                                                                                <div className='form-group'>
                                                                                    <label htmlFor="">Folio</label>
                                                                                    <input disabled={true} type="text" className='form-control input-sm' value={ObjHon.Registros.length > 0 ? ObjHon.Registros[0].CFolio : ''} />
                                                                                </div>
                                                                            </div>
                                                                        </div>
                                                                        <div className='row'>
                                                                            <div className='col-md-6'>
                                                                                <div className='form-group'>
                                                                                    <label htmlFor="">Moneda de Pago</label>
                                                                                    <input disabled={true} type="text" className='form-control input-sm' value={ObjHon.Registros.length > 0 ? ObjHon.Registros[0].MonedaPago : ''} />
                                                                                </div>
                                                                            </div>
                                                                            <div className='col-md-6'>
                                                                                <div className='form-group'>
                                                                                    <label htmlFor="">Moneda de Docto</label>
                                                                                    <input disabled={true} type="text" className='form-control input-sm' value={ObjHon.Registros.length > 0 ? ObjHon.Registros[0].MonedaDoc : ''} />
                                                                                </div>
                                                                            </div>
                                                                        </div>
                                                                        <div className='row'>
                                                                            <div className='col-md-6'>
                                                                                <div className='form-group'>
                                                                                    <label htmlFor="">Tipo de cambio de Pago</label>
                                                                                    <input disabled={true} type="text" className='form-control input-sm' value={ObjHon.Registros.length > 0 ? ObjHon.Registros[0].TCPago : ''} />
                                                                                </div>
                                                                            </div>
                                                                            <div className='col-md-6'>
                                                                                <div className='form-group'>
                                                                                    <label htmlFor="">Tipo de cambio de Docto</label>
                                                                                    <input disabled={true} type="text" className='form-control input-sm' value={ObjHon.Registros.length > 0 ? ObjHon.Registros[0].TCDocumento : ''} />
                                                                                </div>
                                                                            </div>
                                                                        </div>
                                                                        <div className='row'>
                                                                            <div className='col-md-6'>

                                                                            </div>
                                                                            <div className='col-md-6'>
                                                                                <div className='form-group'>
                                                                                    <label htmlFor="">Importe de pago</label>
                                                                                    <CurrencyInputField
                                                                                        className='form-control input-sm numeric'
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
                                                                                        value={ObjHon.Registros[0] ? ObjHon.Registros[0].ImporteConvertido : ''}
                                                                                        id='Generada'
                                                                                        name='Generada'
                                                                                        autoComplete='off'

                                                                                    />
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
                            </div>
                        </form>

                    </>
                )}
            </Formik>

            <Formik
                innerRef={formikModalRef}
                initialValues={pago}
                enableReinitialize="true"
                //validationSchema={validationSchemaPoliza}
                //validateOnChange={(e) => console.log('validateChange')}
                onSubmit={(values, actions) => {
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
                    isSubmitting,
                }) => (
                    <form onKeyDown={LockEnter} onSubmit={handleSubmit} className="form" autoComplete="off" >
                        <div id="ModalRPago" className="modal fade" role="dialog">
                            <div className="modal-dialog modal-lg modal-dialog-centered">
                                <div className="modal-content">
                                    <div className="modal-body">
                                        <div className="row">
                                            <div className='col-md-10 labelSpecial'>
                                                <h4>Registro de pago</h4>
                                            </div>
                                            <div className='col-md-2'>
                                                <button type="button" className="close" onClick={() => ResetModal()} data-dismiss="modal">&times;</button>
                                            </div>
                                        </div>
                                        <div className="row">
                                            <div className="col-md-12 text-right">
                                                <a type="button" onClick={() => SaveData(values)} className="btn btn-primary btn-s" title='Guardar' ><i className="fa fa-floppy-o"></i>&nbsp;Guardar</a>
                                            </div>
                                        </div>
                                        <br />
                                        <div className="row">
                                            <div className="col-md-7">
                                                <div className="card">
                                                    <div className="card-body p-0">
                                                        <div className="row">
                                                            <div className="col-md-6 mb-0">
                                                                <div className="form-group">
                                                                    <label htmlFor="txMotivo">Fecha de pago</label>
                                                                    <input
                                                                        className="form-control input-sm"
                                                                        type="date"
                                                                        name="FechaPago"
                                                                        id="FechaPago"
                                                                        onBlur={() => { handleBlur }}
                                                                        onChange={handleChange}
                                                                        value={values.FechaPago}
                                                                        data-toggle="tooltip" data-placement="bottom" title="Fecha de pago"
                                                                    />
                                                                </div>
                                                            </div>
                                                            <div className='col-md-6 mb-0'>
                                                                <div className="form-group">
                                                                    <label htmlFor="txMotivo">Folio de cheque</label>
                                                                    <input
                                                                        type="text"
                                                                        name="FolioCheque"
                                                                        id="FolioCheque"
                                                                        onFocus={FocusInput}
                                                                        onChange={(e) => { setFieldValue('FolioCheque', UpperCaseField(e.target.value)) }}
                                                                        value={values.FolioCheque}
                                                                        className="form-control input-sm"
                                                                        autoComplete="off"
                                                                    />
                                                                </div>
                                                            </div>
                                                            <div className='col-md-6 mb-0'>
                                                                <div className="form-group">
                                                                    <label htmlFor="txMotivo">Tipo de documento</label>
                                                                    <Select
                                                                        placeholder="Selecione"
                                                                        id="IdTipoDocumento"
                                                                        name="IdTipoDocumento"
                                                                        styles={colourStylesCustomRecibos}
                                                                        onChange={v => { setFieldValue("IdTipoDocumento", v.value) }}
                                                                        onClick={() => { $("#ModalRPago").modal('handleUpdate') }}
                                                                        onBlur={handleBlur}
                                                                        value={displayitem(values.IdTipoDocumento, InitialDataInfo.TipoDocto)}
                                                                        options={mapitems(InitialDataInfo.TipoDocto ? InitialDataInfo.TipoDocto : [], '')}
                                                                        noOptionsMessage={() => "Sin opciones"}
                                                                    />
                                                                </div>
                                                            </div>
                                                            <div className="col-md-6 mb-0"></div>
                                                            <div className='col-md-6 mb-0'>
                                                                <div className="form-group">
                                                                    <label htmlFor="txMotivo">Banco</label>
                                                                    <Select
                                                                        placeholder="Selecione"
                                                                        id="IdBanco"
                                                                        name="IdBanco"
                                                                        styles={colourStylesCustomRecibos}
                                                                        onChange={v => { setFieldValue("IdBanco", v.value) }}
                                                                        onBlur={handleBlur}
                                                                        onClick={() => { $("#ModalRPago").modal('handleUpdate') }}
                                                                        value={displayitem(values.IdBanco, InitialDataInfo.Bancos)}
                                                                        options={mapitems(InitialDataInfo.Bancos ? InitialDataInfo.Bancos : [], '')}
                                                                        noOptionsMessage={() => "Sin opciones"}
                                                                    />
                                                                </div>
                                                            </div>
                                                            <div className="col-md-6 mb-0"></div>
                                                            <div className='col-md-6 mb-0'>
                                                                <div className="form-group">
                                                                    <label htmlFor="txMotivo">No. documento</label>
                                                                    <input
                                                                        type="text"
                                                                        name="NoDocumento"
                                                                        id="NoDocumento"
                                                                        onFocus={FocusInput}
                                                                        onChange={(e) => { setFieldValue('NoDocumento', UpperCaseField(e.target.value)) }}
                                                                        value={values.NoDocumento}
                                                                        className="form-control input-sm"
                                                                        autoComplete="off"
                                                                    />
                                                                </div>
                                                            </div>
                                                            <div className="col-md-6 mb-0">
                                                                <div className='form-group'>
                                                                    <label htmlFor="txMotivo">
                                                                        Fecha documento
                                                                    </label>
                                                                    <input
                                                                        className="form-control input-sm"
                                                                        type="date"
                                                                        name="FechaDocumento"
                                                                        id="FechaDocumento"
                                                                        onBlur={() => { handleBlur }}
                                                                        onChange={handleChange}
                                                                        value={values.FechaDocumento}
                                                                        data-toggle="tooltip" data-placement="bottom" title="Fecha documento"
                                                                    />
                                                                </div>
                                                            </div>
                                                            <div className='col-md-6 mb-0'>
                                                                <div className="form-group">
                                                                    <label htmlFor="txMotivo">Tipo de pago</label>
                                                                    <Select
                                                                        placeholder="Selecione"
                                                                        id="IdTipoPago"
                                                                        name="IdTipoPago"
                                                                        styles={colourStylesCustomRecibos}
                                                                        onChange={v => { setFieldValue("IdTipoPago", v.value) }}
                                                                        onBlur={handleBlur}
                                                                        value={displayitem(values.IdTipoPago, InitialDataInfo.TipoPago)}
                                                                        options={mapitems(InitialDataInfo.TipoPago ? InitialDataInfo.TipoPago : [], '')}
                                                                        noOptionsMessage={() => "Sin opciones"}
                                                                    />
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div className="col-md-5">
                                                <div className="card">
                                                    <div className="card-body p-0">
                                                        <div className="row">
                                                            <div className='col-md-6 mb-0'>
                                                                <div className="form-group">
                                                                    <label htmlFor="txMotivo">
                                                                        Importe del pago
                                                                    </label>
                                                                    <CurrencyInputField
                                                                        className='form-control input-sm numeric'
                                                                        //disabled={IsDisabledP}
                                                                        onBlur={() => { handleBlur }}
                                                                        min={0}
                                                                        maxLength={10}
                                                                        decimalsLimit={2}
                                                                        decimalScale={2}
                                                                        //prefix='$'
                                                                        decimalSeparator='.'
                                                                        groupSeparator=','
                                                                        onFocus={FocusInput}
                                                                        allowNegativeValue={false}
                                                                        value={values.ImportePago}
                                                                        onValueChange={(value, name) => { setFieldValue(name, value) }}
                                                                        id='ImportePago'
                                                                        name='ImportePago'
                                                                        autoComplete='off'
                                                                    />
                                                                </div>
                                                            </div>
                                                            <div className='col-md-6 mb-0'>
                                                                <div className="form-group">
                                                                    <label htmlFor="txMotivo">Importe real</label>
                                                                    <CurrencyInputField
                                                                        className='form-control input-sm numeric'
                                                                        disabled
                                                                        onBlur={() => { handleBlur }}
                                                                        min={0}
                                                                        maxLength={10}
                                                                        decimalsLimit={2}
                                                                        decimalScale={2}
                                                                        //prefix='$'
                                                                        decimalSeparator='.'
                                                                        groupSeparator=','
                                                                        onFocus={FocusInput}
                                                                        allowNegativeValue={false}
                                                                        value={values.ImporteReal}
                                                                        onValueChange={(value, name) => { setFieldValue(name, value) }}
                                                                        id='ImporteReal'
                                                                        name='ImporteReal'
                                                                        autoComplete='off'
                                                                    />
                                                                </div>
                                                            </div>
                                                            <div className='col-md-6 mb-0'>
                                                                <div className="form-group">
                                                                    <label htmlFor="txMotivo">Moneda pago</label>
                                                                    <Select
                                                                        placeholder="Selecione"
                                                                        id="IdMonedaPago"
                                                                        name="IdMonedaPago"
                                                                        styles={colourStylesCustomRecibos}
                                                                        onChange={v => { setFieldValue("IdMonedaPago", v.value), setTipoCambio("TipoCambio1", setFieldValue, v.value, "TipoCambio", "MONEDAS") }}
                                                                        onBlur={handleBlur}
                                                                        value={displayitem(values.IdMonedaPago, InitialDataInfo.Monedas)}
                                                                        options={mapitems(InitialDataInfo.Monedas ? InitialDataInfo.Monedas : [], '')}
                                                                        noOptionsMessage={() => "Sin opciones"}
                                                                    />
                                                                </div>
                                                            </div>
                                                            <div className='col-md-6 mb-0'>
                                                                <div className="form-group">
                                                                    <label htmlFor="txMotivo">Moneda del docto.</label>
                                                                    <Select
                                                                        placeholder="Selecione"
                                                                        id="IdMonedaDcto"
                                                                        name="IdMonedaDcto"
                                                                        isDisabled={true}
                                                                        styles={colourStylesCustomRecibos}
                                                                        onChange={v => { setFieldValue("IdMonedaDcto", v.value) }}
                                                                        onBlur={handleBlur}
                                                                        value={displayitem(values.IdMonedaDcto, InitialDataInfo.Monedas)}
                                                                        options={mapitems(InitialDataInfo.Monedas ? InitialDataInfo.Monedas : [], '')}
                                                                        noOptionsMessage={() => "Sin opciones"}
                                                                    />
                                                                </div>
                                                            </div>
                                                            <div className="col-md-6 mb-0">
                                                                <div className='form-group'>
                                                                    <label htmlFor="txMotivo">
                                                                        Fecha
                                                                    </label>
                                                                    <input
                                                                        className="form-control input-sm"
                                                                        type="date"
                                                                        name="Fecha1"
                                                                        id="Fecha1"
                                                                        onBlur={() => { handleBlur }}
                                                                        onChange={handleChange}
                                                                        value={values.Fecha1}
                                                                        data-toggle="tooltip" data-placement="bottom" title="Fecha"
                                                                    />
                                                                </div>
                                                            </div>
                                                            <div className="col-md-6 mb-0">
                                                                <div className='form-group'>
                                                                    <label htmlFor="txMotivo">
                                                                        Fecha
                                                                    </label>
                                                                    <input
                                                                        className="form-control input-sm"
                                                                        type="date"
                                                                        name="Fecha2"
                                                                        id="Fecha2"
                                                                        onBlur={() => { handleBlur }}
                                                                        onChange={handleChange}
                                                                        value={values.Fecha2}
                                                                        data-toggle="tooltip" data-placement="bottom" title="Fecha"
                                                                    />
                                                                </div>
                                                            </div>
                                                            <div className='col-md-6 mb-0'>
                                                                <div className='form-group'>
                                                                    <label htmlFor="txMotivo">
                                                                        Tipo de cambio
                                                                    </label>
                                                                    <CurrencyInputField
                                                                        className='form-control input-sm numeric'
                                                                        //disabled
                                                                        onBlur={() => { handleBlur }}
                                                                        min={0}
                                                                        maxLength={10}
                                                                        decimalsLimit={4}
                                                                        decimalScale={4}
                                                                        //prefix='$'
                                                                        decimalSeparator='.'
                                                                        groupSeparator=','
                                                                        onFocus={FocusInput}
                                                                        allowNegativeValue={false}
                                                                        value={values.TipoCambio1}
                                                                        onValueChange={(value, name) => { setFieldValue(name, value) }}
                                                                        id='TipoCambio1'
                                                                        name='TipoCambio1'
                                                                        autoComplete='off'
                                                                    />
                                                                </div>
                                                            </div>
                                                            <div className='col-md-6 mb-0'>
                                                                <div className='form-group'>
                                                                    <label htmlFor="txMotivo">
                                                                        Tipo de cambio
                                                                    </label>
                                                                    <CurrencyInputField
                                                                        className='form-control input-sm numeric'
                                                                        //disabled
                                                                        onBlur={() => { handleBlur }}
                                                                        min={0}
                                                                        maxLength={10}
                                                                        decimalsLimit={4}
                                                                        decimalScale={4}
                                                                        //prefix='$'
                                                                        decimalSeparator='.'
                                                                        groupSeparator=','
                                                                        onFocus={FocusInput}
                                                                        allowNegativeValue={false}
                                                                        value={values.TipoCambio2}
                                                                        onValueChange={(value, name) => { setFieldValue(name, value) }}
                                                                        id='TipoCambio2'
                                                                        name='TipoCambio2'
                                                                        autoComplete='off'
                                                                    />
                                                                </div>
                                                            </div>
                                                            <div className='col-md-12 mb-0'>
                                                                <div className='form-group'>
                                                                    <label htmlFor="txMotivo">
                                                                        Prima pendiente
                                                                    </label>
                                                                    <CurrencyInputField
                                                                        className='form-control input-sm numeric'
                                                                        disabled
                                                                        onBlur={() => { handleBlur }}
                                                                        min={0}
                                                                        maxLength={10}
                                                                        decimalsLimit={2}
                                                                        decimalScale={2}
                                                                        //prefix='$'
                                                                        decimalSeparator='.'
                                                                        groupSeparator=','
                                                                        onFocus={FocusInput}
                                                                        allowNegativeValue={false}
                                                                        value={values.ImporteReal - values.ImportePago}
                                                                        onValueChange={(value, name) => { setFieldValue(name, value) }}
                                                                        id='PrimaPendiente'
                                                                        name='PrimaPendiente'
                                                                        autoComplete='off'
                                                                    />
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
                    </form>
                )}
            </Formik>

            {/* modal para aplicar el pago */}
            <Formik
                innerRef={formikModalRefPHon}
                initialValues={PHon}
                enableReinitialize="true"
                //validationSchema={validationSchemaPoliza}
                //validateOnChange={(e) => console.log('validateChange')}
                onSubmit={(values, actions) => {
                    //SaveData(values);
                    SavePagoHonorario()
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
                    isSubmitting,
                }) => (
                    <form onKeyDown={LockEnter} onSubmit={handleSubmit} className="form" autoComplete="off" >
                        <div id="ModalAplicarHon" className="modal fade" role="dialog">
                            <div className="modal-dialog modal-lg modal-dialog-centered">
                                <div className="modal-content">
                                    <div className="modal-body">
                                        <div className="row">
                                            <div className='col-md-10 labelSpecial'>
                                                <h4>Aplicar Honorario</h4>
                                            </div>
                                            <div className='col-md-2'>
                                                <button type="button" className="close" onClick={() => ResetModal()} data-dismiss="modal">&times;</button>
                                            </div>
                                        </div>
                                        <div className="row">
                                            <div className="col-md-12 text-right">
                                                <a type="button" onClick={() => SavePagoHonorario(values)} className="btn btn-primary btn-s" title='Guardar' ><i className="fa fa-floppy-o"></i>&nbsp;Guardar</a>
                                            </div>
                                        </div>
                                        <br />
                                        <div className="row">
                                            <div className="col-md-7">
                                                <div className="card">
                                                    <div className="card-body p-0">
                                                        <div className="row">
                                                            <div className="col-md-12 mb-0">
                                                                <div className="form-group">
                                                                    <label htmlFor="txMotivo">A nombre de </label>
                                                                    <input
                                                                        className="form-control input-sm"
                                                                        type="text"
                                                                        disabled
                                                                        //onChange={handleChange}
                                                                        value={ObjHon.IDAgente ? InitialDataInfo.Vendedores.find(x => parseInt(x.Id) === parseInt(ObjHon.IDAgente)).Nombre : ''}
                                                                        data-toggle="tooltip" data-placement="bottom" title="Fecha de pago"
                                                                    />
                                                                </div>
                                                            </div>
                                                            <div className='col-md-6 mb-0'>
                                                                <div className="form-group">
                                                                    <label htmlFor="txMotivo">Documento</label>
                                                                    <input
                                                                        type="text"
                                                                        name="NoDocumento"
                                                                        id="NoDocumento"
                                                                        onFocus={FocusInput}
                                                                        onChange={(e) => { setFieldValue('NoDocumento', UpperCaseField(e.target.value)) }}
                                                                        value={values.NoDocumento}
                                                                        className="form-control input-sm"
                                                                        autoComplete="off"
                                                                    />
                                                                </div>
                                                            </div>
                                                            <div className='col-md-6 mb-0'>
                                                                <div className="form-group">
                                                                    <label htmlFor="txMotivo">Folio</label>
                                                                    <input
                                                                        type="text"
                                                                        name="FolioCheque"
                                                                        id="FolioCheque"
                                                                        onFocus={FocusInput}
                                                                        onChange={(e) => { setFieldValue('FolioCheque', UpperCaseField(e.target.value)) }}
                                                                        value={values.FolioCheque}
                                                                        className="form-control input-sm"
                                                                        autoComplete="off"
                                                                    />
                                                                </div>
                                                            </div>
                                                            <div className='col-md-6 mb-0'>
                                                                <div className="form-group">
                                                                    <label htmlFor="txMotivo">Fecha Pago</label>
                                                                    <input
                                                                        type="date"
                                                                        name="Fecha3"
                                                                        id="Fecha3"
                                                                        onFocus={FocusInput}
                                                                        onChange={handleChange}
                                                                        value={values.Fecha3}
                                                                        className="form-control input-sm"
                                                                        autoComplete="off"
                                                                    />
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div className="col-md-5">
                                                <div className="card">
                                                    <div className="card-body p-0">
                                                        <div className="row">
                                                            <div className='col-md-6 mb-0'>
                                                                <div className="form-group">
                                                                    <label htmlFor="txMotivo">
                                                                        Importe del pago
                                                                    </label>
                                                                    <CurrencyInputField
                                                                        className='form-control input-sm numeric'
                                                                        //disabled={IsDisabledP}
                                                                        onBlur={() => { handleBlur }}
                                                                        min={0}
                                                                        maxLength={10}
                                                                        decimalsLimit={2}
                                                                        decimalScale={2}
                                                                        //prefix='$'
                                                                        decimalSeparator='.'
                                                                        groupSeparator=','
                                                                        onFocus={FocusInput}
                                                                        allowNegativeValue={false}
                                                                        value={values.ImportePago}
                                                                        onValueChange={(value, name) => { setFieldValue(name, value) }}
                                                                        id='ImportePago'
                                                                        name='ImportePago'
                                                                        autoComplete='off'
                                                                    />
                                                                </div>
                                                            </div>
                                                            <div className='col-md-6 mb-0'>
                                                                <div className="form-group">
                                                                    <label htmlFor="txMotivo">Importe real</label>
                                                                    <CurrencyInputField
                                                                        className='form-control input-sm numeric'
                                                                        disabled
                                                                        onBlur={() => { handleBlur }}
                                                                        min={0}
                                                                        maxLength={10}
                                                                        decimalsLimit={2}
                                                                        decimalScale={2}
                                                                        //prefix='$'
                                                                        decimalSeparator='.'
                                                                        groupSeparator=','
                                                                        onFocus={FocusInput}
                                                                        allowNegativeValue={false}
                                                                        value={values.ImporteReal}
                                                                        onValueChange={(value, name) => { setFieldValue(name, value) }}
                                                                        id='ImporteReal'
                                                                        name='ImporteReal'
                                                                        autoComplete='off'
                                                                    />
                                                                </div>
                                                            </div>
                                                            <div className='col-md-6 mb-0'>
                                                                <div className="form-group">
                                                                    <label htmlFor="txMotivo">Moneda pago</label>
                                                                    <Select
                                                                        placeholder="Selecione"
                                                                        id="IdMonedaPago"
                                                                        name="IdMonedaPago"
                                                                        styles={colourStylesCustomRecibos}
                                                                        onChange={v => { setFieldValue("IdMonedaPago", v.value), setTipoCambio("TipoCambio1", setFieldValue, v.value, "TipoCambio", "MONEDAS") }}
                                                                        onBlur={handleBlur}
                                                                        value={displayitem(values.IdMonedaPago, InitialDataInfo.Monedas)}
                                                                        options={mapitems(InitialDataInfo.Monedas ? InitialDataInfo.Monedas : [], '')}
                                                                        noOptionsMessage={() => "Sin opciones"}
                                                                    />
                                                                </div>
                                                            </div>
                                                            <div className='col-md-6 mb-0'>
                                                                <div className="form-group">
                                                                    <label htmlFor="txMotivo">Moneda del docto.</label>
                                                                    <Select
                                                                        placeholder="Selecione"
                                                                        id="IdMonedaDcto"
                                                                        name="IdMonedaDcto"
                                                                        isDisabled={true}
                                                                        styles={colourStylesCustomRecibos}
                                                                        onChange={v => { setFieldValue("IdMonedaDcto", v.value) }}
                                                                        onBlur={handleBlur}
                                                                        value={displayitem(values.IdMonedaDcto, InitialDataInfo.Monedas)}
                                                                        options={mapitems(InitialDataInfo.Monedas ? InitialDataInfo.Monedas : [], '')}
                                                                        noOptionsMessage={() => "Sin opciones"}
                                                                    />
                                                                </div>
                                                            </div>
                                                            <div className="col-md-6 mb-0">
                                                                <div className='form-group'>
                                                                    <label htmlFor="txMotivo">
                                                                        Fecha
                                                                    </label>
                                                                    <input
                                                                        className="form-control input-sm"
                                                                        type="date"
                                                                        name="Fecha1"
                                                                        id="Fecha1"
                                                                        onBlur={() => { handleBlur }}
                                                                        onChange={handleChange}
                                                                        value={values.Fecha1}
                                                                        data-toggle="tooltip" data-placement="bottom" title="Fecha"
                                                                    />
                                                                </div>
                                                            </div>
                                                            <div className="col-md-6 mb-0">
                                                                <div className='form-group'>
                                                                    <label htmlFor="txMotivo">
                                                                        Fecha
                                                                    </label>
                                                                    <input
                                                                        className="form-control input-sm"
                                                                        type="date"
                                                                        name="Fecha2"
                                                                        id="Fecha2"
                                                                        onBlur={() => { handleBlur }}
                                                                        onChange={handleChange}
                                                                        value={values.Fecha2}
                                                                        data-toggle="tooltip" data-placement="bottom" title="Fecha"
                                                                    />
                                                                </div>
                                                            </div>
                                                            <div className='col-md-6 mb-0'>
                                                                <div className='form-group'>
                                                                    <label htmlFor="txMotivo">
                                                                        Tipo de cambio
                                                                    </label>
                                                                    <input
                                                                        className="form-control input-sm numeric"
                                                                        type="text"
                                                                        name="TCPago"
                                                                        id="TCPago"
                                                                        onBlur={() => { handleBlur }}
                                                                        onChange={handleChange}
                                                                        value={values.Fecha2}
                                                                        data-toggle="tooltip" data-placement="bottom" title="Fecha"
                                                                    />
                                                                </div>
                                                            </div>
                                                            <div className='col-md-6 mb-0'>
                                                                <div className='form-group'>
                                                                    <label htmlFor="txMotivo">
                                                                        Tipo de cambio
                                                                    </label>
                                                                    <input
                                                                        className="form-control input-sm numeric"
                                                                        type="date"
                                                                        name="TCDocto"
                                                                        id="TCDocto"
                                                                        onBlur={() => { handleBlur }}
                                                                        onChange={handleChange}
                                                                        value={values.Fecha2}
                                                                        data-toggle="tooltip" data-placement="bottom" title="Fecha"
                                                                    />
                                                                </div>
                                                            </div>
                                                            <div className='col-md-12 mb-0'>
                                                                <div className='form-group'>
                                                                    <label htmlFor="txMotivo">
                                                                        Importe Honorario
                                                                    </label>
                                                                    <CurrencyInputField
                                                                        className='form-control input-sm numeric'
                                                                        disabled
                                                                        onBlur={() => { handleBlur }}
                                                                        min={0}
                                                                        maxLength={10}
                                                                        decimalsLimit={2}
                                                                        decimalScale={2}
                                                                        //prefix='$'
                                                                        decimalSeparator='.'
                                                                        groupSeparator=','
                                                                        onFocus={FocusInput}
                                                                        allowNegativeValue={false}
                                                                        value={values.ImporteReal - values.ImportePago}
                                                                        onValueChange={(value, name) => { setFieldValue(name, value) }}
                                                                        id='PrimaPendiente'
                                                                        name='PrimaPendiente'
                                                                        autoComplete='off'
                                                                    />
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
                    </form>
                )}
            </Formik>
            <ModalLiquidar ref={ModalLiquidarRef} AplicarLiquidar={AplicarLiquidar} />
        </>
    )
}
