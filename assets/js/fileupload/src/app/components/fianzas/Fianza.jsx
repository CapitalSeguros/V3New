import React, { useState, useEffect, useRef } from 'react';
import Select from "react-select";
import { Form, Formik } from "formik";
import { CallApiGet, CallApiPost } from '../../Helpers/Calls.js';
import axios from "axios";
import { isEmptyObject, ShowLoading, mapitems, mapitemsHijos, displayitem, colourStyles, displayOther, calculatePagos, LockEnter, round, UpperCaseField, FocusInput } from '../../Helpers/FGeneral.js';
import ModalOpc from '../captura/ModalOpc.jsx';
import CurrencyInputField from 'react-currency-input-field';
import Detalle from './Detalle.jsx';
import { validationSchemaFianza } from '../../Helpers/Validations.js';
import TablaRecibos from '../captura/TablaRecibos.jsx';
import ModalComRevision from '../captura/ModalComRevision.jsx';
import ModalRecibos from '../captura/ModalRecibos.jsx';
import ModalCancelar from '../Acciones/ModalCancelar.jsx';
import ModalDocumentos from '../Acciones/ModalDocumentos.jsx';
import AllowElement from '../Acciones/AllowElements.jsx';
import ModalRehabilitar from '../Acciones/ModalRehabilitar.jsx';
import ModalFileManager from '../Acciones/ModalFileManager.jsx';
import ModalEndososV2 from '../Acciones/ModalEndososV2.jsx';
import { isMobile } from 'react-device-detect';
//import ModalEndosos from '../Acciones/ModalEndosos.jsx';



export default function Fianza(props) {
  const path = window.jQuery("#base_url").attr("data-base-url");
  const Id = window.jQuery("#idRegistro").val();
  const LoggedUser = window.jQuery("#Usuario").val();
  const { callback, UrlServicio, UrlPagina } = props;
  const formikRef = useRef(null);
  const ChildrenkRef = useRef(null);
  const [ItemRecibo, SetItemRecibo] = useState({});
  const [ItemInfoRecibo, SetItemInfoRecibo] = useState({});
  const [IndexRecibo, SetIndexRecibo] = useState();
  const ModalFileUploadRef = useRef(null);
  const ModalEndosos = useRef(null);
  const [IsChange, SetIsChange] = useState(false);


  const [state, setState] = useState({
    InitialData: {
      Monedas: [],
      TipoDocumento: [],
      Grupo: [],
      SubGrupo: [],
      FormaPago: [],
      Ejecutivos: [],
      Vendedores: [],
      Companias: [],
      Agentes: [],
      Estatus: [],
      EstatusCobro: [],
      EstatusDoc: [],
      ConductoCobro: [],
      LineaNegocio: [],
      TipoPago: [],
      TipoVenta: [],
      Gerencias: [],
      SubRamo: [],
      Clientes: [],
      Despachos: [],
      TipoConCobro: [],
      Ramos: [],
      Marca: [],
      SubMarca: [],
      Transmision: [],
      Cochera: [],
      Color: [],
      Servicio: [],
      UsoServicio: [],
      CiaLocalizacion: [],
      Inspeccion: [],
      Estados: [],
      TipoFianza: [],
      FianzaProducto: [],
      EstatusCancelacion: [],
      MotivosCancelacion: [],
      EstatusUsurario: [],
      Compania: []
    },
    selected: { value: "", label: "" },
  });
  const [configuraciones, SetConfiguraciones] = useState({
    listaComisiones: [],
    ListaHonorarios: [],
  })
  const [evaluadores, setEvaluad] = useState([]);
  const [recibos, setRecibos] = useState([]);
  const [IsDisabledP, SetIsDisabledP] = useState(false);
  const [ordenTrabajo, SetordenTrabajo] = useState({
    OT: {
      IDTemp: '',
      Status_TXT: null,
      FDesde: moment(),
      FHasta: moment().add(1, 'years').subtract(1, 'days'),
      DObligacion: 0,
      PrimaNeta: '0'
    },
    Usuario: {
      Info: {
        Nombre: '',
        Id: ''
      },
      Direcciones: [],
    },
    Flotillas: [],
    Endosos: []
  });


  useEffect(async () => {
    if ($('body div').hasClass('pace')) {
      $("body div").removeClass("pace");
    }
    ShowLoading();
    InitialData();
    if (Id != undefined) {
      await InitialDataRegistro();
    } else {
      if (formikRef.current) {
        formikRef.current.setFieldValue('PorIVA', 16);
        formikRef.current.setFieldValue('FDesde', moment());
        formikRef.current.setFieldValue('FHasta', moment().add(1, 'years').subtract(1, 'days'));
        //test
        formikRef.current.setFieldValue('IObligacion', moment());
        formikRef.current.setFieldValue('FObligacion', moment().add(1, 'years').subtract(1, 'days'));
        var a = moment();
        var b = moment(moment().add(1, 'years').subtract(1, 'days'));
        formikRef.current.setFieldValue('DObligacion', b.diff(a, 'days'));
        formikRef.current.validateForm();
      }

    }
    await IsDisabledPrimas();
    ShowLoading(false);

  }, []);

  //Obtner initial data
  async function InitialData() {
    var complemento = {};
    var URL = `${UrlServicio}capture/getInitialData?Tipo=F`;
    //if (formikRef.current.values.IDAgente != undefined) {
    if (Id != undefined) {
      URL = `${UrlServicio}capture/getInitialData`;
      complemento = {
        Tipo: "F",
        Agente: Id,
        IDAgente: formikRef.current.values.IDAgente,
        //Agente: Id
      }
    } else {
      URL = `${UrlServicio}capture/getInitialData`;
      complemento = {
        Tipo: "F",
        IDAgente: formikRef.current.values.IDAgente
      }
    }

    const res = await CallApiGet(URL, complemento, null);
    if (res.status != 200) {
      toastr.error(`Error ${res.error.Mensaje}`);
    } else {
      setTimeout(() => {
        setState({
          ...state,
          InitialData: res.success.Datos
        });
      }, 50);
    }
  }

  async function InitialDataRegistro() {
    const res = await CallApiGet(`${UrlServicio}capture/singleFianza?Id=${Id}`, { id: Id }, null);
    if (res.status != 200) {
      toastr.error(`Error ${res.error.Mensaje}`);
    } else {

      if (res.success.Datos.OT.NPagos == null || res.success.Datos.OT.NPagos == undefined) {
        var complemento = {};
        var URL = `${UrlServicio}capture/getInitialData?Tipo=F`;
        URL = `${UrlServicio}capture/getInitialData`;
        complemento = {
          Tipo: "F",
          Agente: Id,
          IDAgente: formikRef.current.values.IDAgente,
        }

        const responseData = await CallApiGet(URL, complemento, null);
        if (responseData.status != 200) {
          toastr.error(`Error ${responseData.error.Mensaje}`);
        } else {
          let _formaPago = responseData.success.Datos.FormaPago;
          let _formaPagoAsignado = _formaPago.find((item) => item.Nombre == res.success.Datos.OT.FPago);
          if (_formaPagoAsignado) {
            res.success.Datos.OT.NPagos = _formaPagoAsignado.NPagos;
          }
        }
      }

      SetordenTrabajo({
        ...ordenTrabajo,
        OT: res.success.Datos.OT,
        Flotillas: res.success.Datos.Flotillas,
        Usuario: res.success.Datos.Usuario,
        Endosos: res.success.Datos.Endosos
      });
      setRecibos(res.success.Datos.Recibos);
      SetConfiguraciones({ ...configuraciones, ListaHonorarios: res.success.Datos.Honorarios, listaComisiones: res.success.Datos.Comisiones });
      let GrupoHon = res.success.Datos.TotalHonorariosGrupo;
      if (res.success.Datos.TotalHonorario > 0) {
        Object.keys(GrupoHon).forEach(function (key) {
          var val = GrupoHon[key];
          if ((val > 100 || val < 100) && res.success.Datos.OT.TipoDocto == 1 && res.success.Datos.OT.Status_TXT === 'Vigente') {
            swal({
              title: "Honorarios",
              text: "La participación de los honorarios debe de estar al 100%.",
              icon: "warning",
              confirmButtonText: "Aceptar",
              confirmButtonColor: "#472380"
            });
          }
        });
      } else {
        if (res.success.Datos.OT.TipoDocto == 1) {
          swal({
            title: "Honorarios",
            text: "La participación de los honorarios debe de estar al 100%.",
            icon: "warning",
            confirmButtonText: "Aceptar",
            confirmButtonColor: "#472380"
          });
        }
      }
      /* if ((res.success.Datos.TotalHonorario < 100 || res.success.Datos.TotalHonorario > 100) && res.success.Datos.OT.TipoDocto == 1) {
        swal({
          title: "Honorarios",
          text: "La participación de los honorarios debe de estar al 100%.",
          icon: "warning",
          confirmButtonText: "Aceptar",
          confirmButtonColor: "#472380"
        });
      } */
      if (formikRef.current) {
        formikRef.current.validateForm();
      }
    }
  }

  function getDirecciones(Data) {
    axios
      .get(`${UrlServicio}capture/usuarioDirecciones?IDCli=${Data.Id}`, null)
      .then(function (response) {
        SetordenTrabajo({
          ...ordenTrabajo,
          Usuario: {
            Direcciones: response.data.Datos,
            Info: Data
          }
        })
      });
  }

  async function SaveData(data) {
    ShowLoading();
    var dta = {
      "data": data,
      "Id": Id,
      "User": LoggedUser
    };

    const res = await CallApiPost(`${UrlServicio}capture/saveFianza`, dta, null);
    if (res.status != 200) {
      toastr.error(`Error ${res.error.Mensaje}`);
    } else {
      var RId = res.success.Datos.IDDocto;
      toastr.success("Exíto");
      if (Id == undefined) {
        window.location = path + 'servicioSistema/FianzaEdit/' + RId;
      }
      else {
        SetIsChange(false);
        InitialDataRegistro();
      }
    }
    ShowLoading(false);
  }

  const handleKeyDown = (event) => {
    event.preventDefault();
    event.stopPropagation();
    if (event.key === 'Enter') {

    }
  }

  async function GetAllConfig() {
    ShowLoading();
    const values = formikRef.current.values;
    var data = {
      Compania: values.IDAgente,
      Agente: values.IDVend,
      Moneda: values.IDMon,
      SubRamo: values.IDSSRamo,
      FormaPago: values.IDFPago,
      Vendedor: values.IDVend
    };
    const res = await CallApiGet(`${UrlServicio}capture/getConfigValues`, data, null);
    if (res.status != 200) {
      toastr.error(`Error, intente mas tarde. ${res.error}`);
    } else {
      var CpyState = { ...state };
      CpyState.InitialData.Compania = res.success.Datos.Compania;

      var Rvalues = res.success.Datos.ConfigComisiones;
      setState({ ...state, listaComisiones: res.success.Datos.ListaComisiones, InitialData: CpyState.InitialData });
      formikRef.current.setFieldValue('PDerecho', Rvalues.PrimaRecargos);
      formikRef.current.setFieldValue('GastosMaquila', Rvalues.PrimaDerechos);
      formikRef.current.setFieldValue('PComNeta', Rvalues.ComisionesBase);
      formikRef.current.setFieldValue('PCGastosMaquila', Rvalues.ComisionesDerechos);

      NewReloadPrices('PrimaNeta',values.PrimaNeta);
      //ReloadPrices(null);
      //ReloadPrices('');

    }

    ShowLoading(false);
    //var PNeta = parseFloat(values.PrimaNeta ? values.PrimaNeta : 0);
  }

  function ReloadPrices(Values = null) {
    const values = formikRef.current.values;
    var PNeta = parseFloat(values.PrimaNeta ? values.PrimaNeta : 0);
    var GastosMaquila = parseFloat(values.GastosMaquila ? values.GastosMaquila : 0);
    var GastosAdmin = parseFloat(values.GastosAdmin ? values.GastosAdmin : 0);
    var Derechos = parseFloat(values.Derechos ? values.Derechos : 0);
    //var PIVA = parseFloat(16);
    var Ramo = parseFloat(values.IDSRamo ? values.IDSRamo : 0);
    var PIVA = 0;
    var IVA = 0;
    var IPIVA = values.PorIVA;
    if (Values == null) {
      PIVA = parseFloat(values.PorIVA ? values.PorIVA : 0);
      var PDescuento = parseFloat(values.PDescuento ? values.PDescuento : 0);
      var PDerechos = parseFloat(values.PDerecho ? values.PDerecho : 0);

      //Varibales calculables
      var Descuento = round((PNeta * (PDescuento / 100)), 2);
      Derechos = round(PNeta * (PDerechos / 100), 2);

      const SubTotal = (parseFloat(PNeta) + parseFloat(Derechos) + parseFloat(GastosMaquila) + parseFloat(GastosAdmin)) - parseFloat(Descuento);

      var IVA = round(((PIVA / 100) * SubTotal), 2);
      var PTotal = round(SubTotal + parseFloat(IVA), 2);
      //Actualizmaos Prima
      formikRef.current.setFieldValue('Descuento', Descuento);
      formikRef.current.setFieldValue('Derechos', Derechos);
      formikRef.current.setFieldValue('STotal', round(SubTotal, 2));
      formikRef.current.setFieldValue('IVA', parseFloat(IVA));
      formikRef.current.setFieldValue('PrimaTotal', parseFloat(PTotal));

      //Actualizamos Comisiones
      var PorComincion = parseFloat(values.PComNeta ? values.PComNeta : 0);
      var Comision = round(PNeta * (PorComincion / 100), 2);
      var PorDerechos = parseFloat(values.PComDer ? values.PComDer : 0);
      var PDerechos = round(parseFloat(Derechos * (PorDerechos / 100)), 2);
      var PGastosMaquila = parseFloat(values.PCGastosMaquila ? values.PCGastosMaquila : 0);
      var GastosMaquilaC = round((GastosMaquila * (PGastosMaquila / 100)), 2);//PorRecargos
      var PGastosAdmin = parseFloat(values.PCGastosAdmin ? values.PCGastosAdmin : 0);
      var GastosAdminC = round(GastosAdmin * (PGastosAdmin / 100), 2);//PorRecargos
      var PorEspecial = parseFloat(values.PEspecial ? values.PEspecial : 0);
      var Especial = round(parseFloat(PNeta * (PorEspecial / 100)), 2);

      formikRef.current.setFieldValue('ComNeta', parseFloat(Comision));
      formikRef.current.setFieldValue('CGastosMaquila', parseFloat(GastosMaquilaC));
      formikRef.current.setFieldValue('CGastosAdmin', parseFloat(GastosAdminC));
      formikRef.current.setFieldValue('ComDer', parseFloat(PDerechos));
      formikRef.current.setFieldValue('Especial', parseFloat(Especial));
    } else {
      var Descuento = parseFloat(values.Descuento ? values.Descuento : 0);
      var Derechos = parseFloat(values.Derechos ? values.Derechos : 0);
      //var GastosMaquila = parseFloat(values.Derechos ? values.Derechos : 0);
      //Varibales calculables
      var PDescuento = round((Descuento * 100) / PNeta, 4);
      var PDerechos = round((Derechos * 100) / PNeta, 4);
      const SubTotal = (parseFloat(PNeta) + parseFloat(Derechos) + parseFloat(GastosMaquila) + parseFloat(GastosAdmin)) - parseFloat(Descuento);
      if (Values == "IVA") {
        IVA = parseFloat(values.IVA ? values.IVA : 0)
        PIVA = ((IVA * 100) / (SubTotal == 0 ? 1 : SubTotal));
      } else {
        PIVA = values.PorIVA;
        IVA = round((PIVA / 100) * SubTotal, 2);
      }
      /* if (Ramo == 4) {
        IVA = parseFloat(0 * 0.16);
        //formikRef.current.setFieldValue('PorIVA', parseFloat(0));
      } else {
        IVA = parseFloat(SubTotal * 0.16);

      } */
      //var IVA = ((PIVA / 100) * SubTotal).toFixed(2);
      var PTotal = round(SubTotal + parseFloat(IVA), 2);
      formikRef.current.setFieldValue('IVA', IVA);
      formikRef.current.setFieldValue('PorIVA', round(PIVA == 0 ? IPIVA : PIVA, 4));
      formikRef.current.setFieldValue('PDescuento', PDescuento);
      formikRef.current.setFieldValue('PDerecho', PDerechos);
      formikRef.current.setFieldValue('STotal', round(SubTotal, 2));
      formikRef.current.setFieldValue('PrimaTotal', parseFloat(PTotal));


      //Actualizamos Comisiones //Derechos
      var ComNeta = parseFloat(values.ComNeta ? values.ComNeta : 0);
      var PComNeta = round(((ComNeta * 100) / PNeta), 4);
      var ComDer = parseFloat(values.ComDer ? values.ComDer : 0);
      var PComDer = round(((ComDer * 100) / Derechos), 4);
      var CGastosMaquila = parseFloat(values.CGastosMaquila ? values.CGastosMaquila : 0);
      var PCGastosMaquila = round((CGastosMaquila * 100) / GastosMaquila, 4);
      var CGastosAdmin = parseFloat(values.CGastosAdmin ? values.CGastosAdmin : 0);
      var PCGastosAdmin = round((CGastosAdmin * 100) / GastosAdmin, 4);
      var Especial = parseFloat(values.Especial ? values.Especial : 0);
      var PEspecial = round((Especial * 100) / PNeta, 4);

      //Initial values
      var IPComNeta = values.PComNeta;
      var IPComRec = values.PComRec;
      var IPEspecial = values.PEspecial;
      var IPComDer = values.PComDer;
      var IPCGastosMaquila = values.PCGastosMaquila;
      var IPCGastosAdmin = values.PCGastosAdmin;

      /* formikRef.current.setFieldValue('PComNeta', parseFloat(PComNeta) == 0 ? parseFloat(PComNeta) : IPComNeta)
      formikRef.current.setFieldValue('PComDer', parseFloat(PComDer) ? parseFloat(PComDer) : IPComDer);
      formikRef.current.setFieldValue('PCGastosMaquila', parseFloat(PCGastosMaquila) == 0 ? parseFloat(IPCGastosMaquila) : PCGastosMaquila);
      formikRef.current.setFieldValue('PCGastosAdmin', parseFloat(PCGastosAdmin) == 0 ? parseFloat(IPCGastosAdmin) : PCGastosAdmin);
      formikRef.current.setFieldValue('PEspecial', parseFloat(PEspecial) == 0 ? parseFloat(PEspecial) : IPEspecial); */
      formikRef.current.setFieldValue('PComNeta', parseFloat(values.PrimaNeta) > 0 ? parseFloat(PComNeta) : IPComNeta)
      formikRef.current.setFieldValue('PComDer', parseFloat(values.Derechos) > 0 ? parseFloat(PComDer) : IPComDer);
      formikRef.current.setFieldValue('PCGastosMaquila', parseFloat(values.GastosMaquila) > 0 ? parseFloat(IPCGastosMaquila) : PCGastosMaquila);
      formikRef.current.setFieldValue('PCGastosAdmin', parseFloat(values.GastosAdmin) > 0 ? parseFloat(IPCGastosAdmin) : PCGastosAdmin);
      formikRef.current.setFieldValue('PEspecial', parseFloat(values.PrimaNeta) > 0 ? parseFloat(PEspecial) : IPEspecial);

    }



  }

  /* function GeneraRecibos() {

    var recibos = [];
    const values = formikRef.current.values;
    
    if (IsChange) {
      return swal({
        title: "Advertencia",
        text: "No se ha guardado la poliza.",
        icon: "warning",
        confirmButtonText: "Aceptar",
        confirmButtonColor: "#472380"
      });
    }
    if (values.FDesde === '' || values.FDesde === null) {
      return swal({
        title: "Llenar información",
        text: "No se ha ingresado el campo : Desde ",
        icon: "warning",
        confirmButtonText: "Aceptar",
        confirmButtonColor: "#472380"
      });
    }
    if (values.FHasta === '' || values.FHasta === null) {
      return swal({
        title: "Llenar información",
        text: "No se ha ingresado el campo : Hasta ",
        icon: "warning",
        confirmButtonText: "Aceptar",
        confirmButtonColor: "#472380"
      });
    }
    if (parseFloat(values.PrimaNeta) <= 0 || values.PrimaNeta === null) {
      return swal({
        title: "Llenar información",
        text: "No se ha ingresado el campo : P Neta ",
        icon: "warning",
        confirmButtonText: "Aceptar",
        confirmButtonColor: "#472380"
      });
    }

    var Npagos = parseFloat(values.NPagos ? values.NPagos : 0);
    var Calculo = calculatePagos(values.FDesde, values.FHasta, Npagos);
    var FDesde = values.FDesde;
    var FHasta = values.FHasta;
    var PNeta = parseFloat(values.PrimaNeta ? values.PrimaNeta : 0);
    var PIVA = parseFloat(values.PorIVA ? values.PorIVA : 0);
    //var PIVA = parseFloat(16);
    var PNetaRecibo = round((PNeta / Npagos), 2);
    var Rec = parseFloat(values.Recargos ? values.Recargos : 0);
    //var Recargos = (Rec / Npagos).toFixed(2);
    //var PRecargos = parseFloat(values.PorRecargos ? values.PorRecargos : 0);
    //var Recargos = round(parseFloat(PNetaRecibo) * (PRecargos / 100), 2);
    var Derechos = parseFloat(values.Derechos ? values.Derechos : 0);

    var SubTotal = 0;
    var IVA = 0;
    var PrimaTotal = 0;
    var FGastosMaquila = parseFloat(values.GastosMaquila ? values.GastosMaquila : 0);
    var GastosMaquila = parseFloat(values.GastosMaquila ? values.GastosMaquila : 0) / Npagos;
    var GastosAdmin = parseFloat(values.GastosAdmin ? values.GastosAdmin : 0) / Npagos;
    var FGastosAdmin = parseFloat(values.GastosAdmin ? values.GastosAdmin : 0);
    var Descuento = parseFloat(values.Descuento ? values.Descuento : 0);
    var PorDescuento = parseFloat(values.PDescuento ? values.PDescuento : 0);

    let SumTotal = 0;
    let SumPTotal = 0;    

    for (let index = 0; index < Npagos; index++) {

      var Findex = index + 1;
      if (index == 0) {
        SubTotal = (parseFloat(PNetaRecibo) + parseFloat(Derechos) + parseFloat(round(GastosMaquila, 2)) + parseFloat(round(GastosAdmin, 2))) - parseFloat(Descuento);
      } else {
        SubTotal = parseFloat(PNetaRecibo) + parseFloat(round(GastosMaquila, 2)) + parseFloat(round(GastosAdmin, 2));
      }
      IVA = round(SubTotal * (PIVA / 100), 2);
      PrimaTotal = SubTotal + parseFloat(IVA);
      var Com = parseFloat(PNetaRecibo);
      //var ComR = + parseFloat(Recargos);
      var TotalCom = round(parseFloat(Com * (values.PComNeta / 100)), 2);
      //var TotalComR = round(parseFloat(ComR * (values.PComRec / 100)), 2);

      var PCGastosMaq = parseFloat(values.PCGastosMaquila ? values.PCGastosMaquila : 0) / 100;
      var CGastosMaq = round(parseFloat((GastosMaquila) * (PCGastosMaq)), 2);
      var PCGastosAdm = parseFloat(values.PCGastosAdmin ? values.PCGastosAdmin : 0) / 100;
      var CGastosAdm = round(parseFloat(GastosAdmin * (PCGastosAdm)), 2);

      var Hasta = moment(FDesde).add(((Calculo.Add) * (index + 1)), Calculo.Action);
      var DesdeF = moment(FDesde).add(((Calculo.Add) * index), Calculo.Action).format('YYYYMMDD');
      let RFHasta = Findex < Npagos ? moment(FDesde).add(((Calculo.Add) * (index + 1)), Calculo.Action).format('YYYYMMDD') : moment(FHasta).format('YYYYMMDD');
      let DiasPrimerRecibo = state.InitialData.Compania.DPPRN ? state.InitialData.Compania.DPPRN : null;
      let DiasSegundoRecibo = state.InitialData.Compania.DPRSN ? state.InitialData.Compania.DPRSN : null;

      recibos.push({
        IDDocto: ordenTrabajo.OT.IDDocto,
        Documento: ordenTrabajo.OT.Documento,
        //FCreacion: moment(FDesde).format('YYYYMMDD'),
        //FDesde: moment(FDesde).add(index, 'M').format('YYYYMMDD'),
        //FHasta: moment(FDesde).add(index + 1, 'M').format('YYYYMMDD'),
        //FGeneracion: moment().format('YYYYMMDD'),
        //FLimPago: moment(FDesde).add(index + 2, 'M').format('YYYYMMDD'),
        FCreacion: moment(FDesde).format('YYYYMMDD'),
        FDesde: DesdeF,
        //FDesde: moment(FDesde).add(((Calculo.Add) * index), Calculo.Action).format('YYYYMMDD'),
        //FHasta: Findex < Npagos ? moment(FDesde).add(((Calculo.Add) * (index + 1)), Calculo.Action).format('YYYYMMDD') : moment(FHasta).format('YYYYMMDD'),
        FHasta: RFHasta,
        FGeneracion: moment().format('YYYYMMDD'),
        FLimPago: index == 0 ? moment(DesdeF).add(DiasPrimerRecibo != null ? DiasPrimerRecibo : 0, 'Days').format('YYYYMMDD') : moment(DesdeF).add(DiasSegundoRecibo != null ? DiasSegundoRecibo : (DiasPrimerRecibo == null ? 0 : DiasPrimerRecibo), 'Days').format('YYYYMMDD'),
        //FLimPago: moment(DesdeF).add(state.InitialData.Compania.DPPRN ? state.InitialData.Compania.DPPRN : 0, 'Days').format('YYYYMMDD'),
        //FLimPago: Hasta.add(Calculo.Add, Calculo.Action).format('YYYYMMDD'),
        Periodo: Findex,
        Serie: `0${Findex}/0${Npagos}`,
        PrimaNeta: round(PNetaRecibo, 2),
        Descuento: index == 0 ? Descuento : 0,
        PDescuento: index == 0 ? PorDescuento : 0,
        Recargos: 0,
        PorRecargos: 0,
        //Recargos: Recargos,
        //PorRecargos: PRecargos,
        Derechos: index == 0 ? Derechos : 0,
        SubTotal: round(SubTotal, 2),
        IVA: IVA,
        PorIVA: PIVA,
        Ajuste: 0,
        PrimaTotal: round(PrimaTotal, 2),
        IsEdit: false,
        //nuevos campos
        ComN: parseFloat(TotalCom),
        //ComR: parseFloat(TotalComR),
        ComR: 0,
        PComN: values.PComNeta,
        PComR: 0,
        //PComR: values.PComRec,
        //ComD:
        ///Agregamos los cmapos que faltan
        //GastosMaq: index == 0 ? FGastosMaquila.toFixed(2) : 0,
        //GastosAdm: index == 0 ? FGastosAdmin.toFixed(2) : 0,
        GastosMaq: round(GastosMaquila, 2),
        GastosAdm: round(GastosAdmin, 2),
        CGastosMaq: CGastosMaq,
        PCGastosMaq: (PCGastosMaq * 100),
        CGastosAdm: CGastosAdm,
        PCGastosAdm: (PCGastosAdm * 100),
        Modulo: 'F'
      });
      SumTotal += round(PrimaTotal, 2);
      SumPTotal += round(PNetaRecibo, 2);

    }

    let result = (values.PrimaTotal) - (SumTotal);
    let result2 = (values.PrimaNeta) - (SumPTotal);
    if (recibos.length > 0) {
      // if (result > 0) {
      //   recibos[0].PrimaTotal = recibos[0].PrimaTotal + Math.abs(result);
      //   recibos[0].PrimaNeta = recibos[0].PrimaNeta + Math.abs(result2);
      // } else {
      //   recibos[0].PrimaTotal = recibos[0].PrimaTotal - Math.abs(result);
      //   recibos[0].PrimaNeta = recibos[0].PrimaNeta - Math.abs(result2);
      // }
    } 

    setRecibos(recibos);
  } */

  function ChangeValueRecibo(index, field, value, tipo = null) {
    const elm = [...recibos];
    elm[index][field] = value;
    let Algo = ReloadIndividual(elm[index], tipo);
    setRecibos(elm);
    SetIsChange(false);
  }

  function NewOrden() {
    window.location = `${UrlPagina}servicioSistema/FianzaAdd`;
  }

  function AddRenovacion() {
    let Fvalues = formikRef.current.values;
    let TipoDoc = Fvalues.TipoDocto;
    let NumRenovacion = Fvalues.NumRenovacion;

    if (TipoDoc == "0") {
      return swal({
        title: "Advertencia",
        text: "No se puede renovar una solicitud.",
        icon: "warning",
        confirmButtonText: "Aceptar",
        confirmButtonColor: "#472380"
      });
    }
    if (parseInt(NumRenovacion) > 0) {
      return swal({
        title: "Advertencia",
        text: "Ya se renovo el documento.",
        icon: "warning",
        confirmButtonText: "Aceptar",
        confirmButtonColor: "#472380"
      });
    }
    swal({
      title: "¿Está seguro de que quiere renovar el documento seleccionado?",
      text: "Se realizará una renovación completa de los datos.",
      icon: "warning",
      buttons: ["Cancelar", "Aceptar"],
    }).then(async (value) => {
      if (value) {
        ShowLoading();
        var dta = {
          Id: Id,
        };
        const res = await CallApiPost(`${UrlServicio}capture/renovarFianza`, dta, null);
        if (res.status != 200) {
          return toastr.error(`Error ${res.error.Mensaje}`);
        } else {
          var IDnew = res.success.Datos.IDDocto;
          window.location = path + 'servicioSistema/FianzaEdit/' + IDnew;

          toastr.success("Exíto");
        }
        ShowLoading(false);
      }
    });

  }

  async function DeleteDocument() {
    var dta = {
      "Id": Id
    };

    swal({
      title: "¿Está seguro de que quiere eliminar el elemento seleccionado?",
      text: "Una vez eliminado, ¡no podrá recuperar el elemento!",
      icon: "warning",
      buttons: ["Cancelar", "Aceptar"],
    }).then(async (value) => {
      if (value) {
        ShowLoading();
        const res = await CallApiPost(`${UrlServicio}capture/deleteFianza`, dta, null);
        if (res.status != 200) {
          toastr.error(`Error ${res.error.Mensaje}`);
        } else {
          toastr.success("Exíto");
          window.location = path + 'servicioSistema/Fianza';
        }
        ShowLoading(false);
      }
    });

  }

  function OpenAction(Accion) {
    window.open(`${UrlPagina}servicioSistema/AccionPestana/${Id}/${Accion}/F`, 'newwindow', 'toolbar=no,menubar=no,scrollbars=yes,dialog=yes,resizable=no,width=400,height=450'); return false;
  }

  function ReloadIndividual(Array, Accion = null) {
    const values = Array;
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
      Array.Descuento = Descuento;
      Array.Derechos = Derechos;
      Array.SubTotal = round(SubTotal, 2);
      Array.IVA = parseFloat(IVA);
      Array.PrimaTotal = parseFloat(PTotal);

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

      Array.ComN = parseFloat(Comision);
      Array.CGastosMaq = parseFloat(GastosMaquilaC);
      Array.CGastosAdm = parseFloat(GastosAdminC);
      Array.ComD = parseFloat(PDerechos);
      Array.Especial = parseFloat(Especial);
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
      Array.PDescuento = PDescuento;
      Array.PDerecho = PDerechos;
      Array.SubTotal = SubTotal;
      //Array.IVA = parseFloat(IVA);
      var PorIVA = round((IVA / SubTotal) * 100, 2);
      Array.PrimaTotal = parseFloat(PTotal);

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

      Array.PorIVA = parseFloat(PorIVA);
      Array.PComN = parseFloat(PComNeta);
      Array.PComDer = parseFloat(PComDer);
      Array.PCGastosMaq = parseFloat(PCGastosMaquila);
      Array.CGastosAdm = parseFloat(PCGastosAdmin);
      Array.PEspecial = parseFloat(PEspecial);
    }
    return values;
  }

  function ReloadAll(index, tipo) {
    const elm = [...recibos];
    var PTotal = formikRef.current.values.PrimaNeta ? formikRef.current.values.PrimaNeta : 0;
    var RTotal = formikRef.current.values.Recargos ? formikRef.current.values.Recargos : 0;
    var RDerecho = formikRef.current.values.Derechos ? formikRef.current.values.Derechos : 0;
    var TMaq = formikRef.current.values.GastosMaquila ? formikRef.current.values.GastosMaquila : 0;
    var Adm = formikRef.current.values.GastosAdmin ? formikRef.current.values.GastosAdmin : 0;
    var PAcmu = 0; var RAcmu = 0; var DAcmu = 0; var MaqAcmu = 0; var AdmAcmu = 0;
    var TotalRecibos = 0;
    for (let idx = 0; idx < elm.length; idx++) {
      if (idx > index) {
        if (TotalRecibos == 0) {
          TotalRecibos = (elm.length - (index == 0 ? 1 : idx));
        }
        if (index == 0) {
          TotalRecibos = (elm.length - 1);
        }
        //elm[idx]['PrimaNeta'] = ((PTotal - PAcmu) / TotalRecibos);
        elm[idx]['PrimaNeta'] = round((PTotal - PAcmu) / (TotalRecibos), 2);
        elm[idx]['Recargos'] = round((RTotal - RAcmu) / (TotalRecibos), 2);
        elm[idx]['Derechos'] = round((RDerecho - DAcmu) / (TotalRecibos), 2);
        elm[idx]['GastosMaq'] = round((TMaq - MaqAcmu) / (TotalRecibos), 2);
        elm[idx]['GastosAdm'] = round((Adm - AdmAcmu) / (TotalRecibos), 2);
        elm[idx] = ReloadIndividual(elm[idx], tipo);
      } else {
        PAcmu = PAcmu + parseFloat(elm[idx]['PrimaNeta']);
        RAcmu = RAcmu + parseFloat(elm[idx]['Recargos']);
        DAcmu = DAcmu + parseFloat(elm[idx]['Derechos']);
        MaqAcmu = MaqAcmu + parseFloat(elm[idx]['GastosMaq']);
        AdmAcmu = AdmAcmu + parseFloat(elm[idx]['GastosAdm']);
      }

    }
    setRecibos(elm);
  }

  async function CopyDocumento() {
    let Fvalues = formikRef.current.values;
    let TipoDoc = Fvalues.TipoDocto;
    let NumRenovacion = Fvalues.NumRenovacion;

    if (parseInt(TipoDoc) == 0) {
      return swal({
        title: "Advertencia",
        text: "No se puede copiar una solicitud.",
        icon: "warning",
        confirmButtonText: "Aceptar",
        confirmButtonColor: "#472380"
      });
    }
    swal({
      title: "¿Está seguro de que quiere copiar el documento seleccionado?",
      text: "Se realizará una copia completa de los datos.",
      icon: "warning",
      buttons: ["Cancelar", "Aceptar"],
    }).then(async (value) => {
      if (value) {
        ShowLoading();
        var dta = {
          IDDocto: Id,
          Documento: Fvalues.Documento,
          Modulo: 'F'
        };
        const res = await CallApiPost(`${UrlServicio}capture/copyDocumento`, dta, null);
        if (res.status != 200) {
          return toastr.error(`Error ${res.error.Mensaje}`);
        } else {
          var IDnew = res.success.Datos.IDDocto;
          window.location = path + 'servicioSistema/FianzaEdit/' + IDnew;

          toastr.success("Exíto");
        }
        ShowLoading(false);
      }
    });


  }

  async function GeConfigEspecial() {
    ShowLoading();
    const values = formikRef.current.values;
    var data = {
      Producto: values.Producto,
      TipoFianza: values.TipoFianza,
      SubRamo: values.IDSSRamo,
      Agente: values.IDAgente,
    };
    const res = await CallApiGet(`${UrlServicio}capture/configEspecial`, data, null);
    if (res.status != 200) {
      return toastr.error(`Error ${res.error.Mensaje}`);
    } else {
      //alert('prro');
      if (res.success.Datos.Tarifa != null) {
        formikRef.current.setFieldValue('Tarifa', res.success.Datos.Tarifa);
      }
      if (res.success.Datos.Comisiones != null) {
        var Cneta = res.success.Datos.Comisiones.CNeta;
        var Cderechos = res.success.Datos.Comisiones.CDerechos != 0 ? res.success.Datos.Comisiones.CDerechos : 0;
        var Creargos = res.success.Datos.Comisiones.CRecargos != 0 ? res.success.Datos.Comisiones.CDerechos : 0;
        formikRef.current.setFieldValue('PComDer', Cderechos);
        formikRef.current.setFieldValue('PComNeta', Cneta);//PComNeta
        //formikRef.current.setFieldValue('PComNeta',Cderechos);
      }
      ShowLoading(false);
      //toastr.success("Exíto");
    }
  }

  async function RealoadHonorarios() {
    swal({
      title: "¿Está seguro de que quiere recalcular los honorarios?",
      text: "Una vez realizado, podria haber direferencias",
      icon: "warning",
      buttons: ["Cancelar", "Aceptar"],
    }).then(async (value) => {
      if (value) {
        ShowLoading();
        var data = {
          Id: Id,
          Modulo: "F"
        };
        const res = await CallApiPost(`${UrlServicio}capture/reloadHonorarios`, data, null);
        if (res.status != 200) {
          toastr.error(`Error, intente mas tarde. ${res.error}`);
        } else {
          InitialDataRegistro();
        }
        //var PNeta = parseFloat(values.PrimaNeta ? values.PrimaNeta : 0);
        ShowLoading(false);
      }
    });


  }


  async function Rehabilitar() {
    const values = formikRef.current.values;
    let find = state.InitialData.EstatusCancelacion.find(x => x.Nombre === values.Status_TXT);
    if (find != undefined) {
      $('#ModalRehabilitar').modal('show')
    }
    else {
      swal({
        title: "Documento Vigente",
        text: "El actual documento se encuentra vigente.",
        icon: "warning",
        confirmButtonText: "Aceptar",
        confirmButtonColor: "#472380"
      });
    }
  }

  async function IsDisabledPrimas() {
    const values = formikRef.current.values;
    //let Check = values.TipoDocto ? values.TipoDocto : '';
    if (parseInt(values.TipoDocto) === 0 || values.TipoDocto == null) {
      SetIsDisabledP(true);
    } else {
      SetIsDisabledP(false);
    }

  }

  function CheckErrores() {
    const values = formikRef.current.errors;
    if (values != null) {
      return swal({
        title: "Llenar información",
        text: "Hay campos sin llenar.",
        icon: "warning",
        confirmButtonText: "Aceptar",
        confirmButtonColor: "#472380"
      });
    }
  }

  function HaveChange(e) {
    SetIsChange(true);
  }

  function CreateFolderRef() {
    let Documentos = [];
    recibos.forEach(element => {
      Documentos.push("Recibo_" + element.Serie);
    });
    var data = new FormData();
    data.append("ref", "Fianzas");
    data.append("refId", formikRef.current.values.Solicitud);
    data.append("Carpetas", Documentos.join(","));
    axios
      .post(`${path}filemanager/refDocumentos`, data)
      .then((response) => {
        getFilesByParent();
      })
      .catch((error) => {
        //console.error(error);
      });
  }


  async function DeleteRecibo(index) {
    var Itms = [...recibos];
    var dta = {
      "Id": Itms[index]['IDTemp']
    };
    if (Itms[index]['IDTemp'] == undefined) {
      //alert('No existe');
      toastr.success("Exíto");

    } else {
      //alert('existe');
      const res = await CallApiPost(`${UrlServicio}capture/deleteRecibo`, dta, null);
      if (res.status != 200) {
        return toastr.error(`Error ${res.error.Mensaje}`);
      } else {
        toastr.success("Exíto");
      }
    }
    Itms.splice(index, 1);
    setRecibos(Itms);
  }

  async function CheckDocument() {
    ShowLoading();
    const values = formikRef.current.values;
    if (values.Documento != "" && values.Documento != null) {
      var dta = {
        Id: values.IDDocto ? values.IDDocto : null,
        Documento: values.Documento ? values.Documento : null,
        Modulo: "F"
      };
      //alert('existe');
      const res = await CallApiGet(`${UrlServicio}capture/isSaved`, dta, null);
      if (res.status != 200) {
        //swal("Oops...", "Something went wrong!", "error");
        swal({
          title: "Advertencia",
          text: res.error.Mensaje,
          icon: "warning",
          showConfirmButton: false,
          buttons: ["Aceptar"],
        });
      } else {
        //toastr.success("Exíto");
      }
    }
    ShowLoading(false);
  }



  //Métodos modificados
  async function SaveRecibos() {
    if (recibos.length == 0) {
      return swal({
        title: "Advertencia",
        text: "Genere primero los recibos para poder guardarlos.",
        icon: "warning",
        confirmButtonText: "Aceptar",
        confirmButtonColor: "#472380"
      });
    }
    if (IsChange) {
      return swal({
        title: "Advertencia",
        text: "No se ha guardado la fianza.",
        icon: "warning",
        confirmButtonText: "Aceptar",
        confirmButtonColor: "#472380"
      });
    }
    ShowLoading();
    var dta = {
      "data": recibos,
      "Id": Id
    };

    const res = await CallApiPost(`${UrlServicio}capture/saveRecibos`, dta, null);
    if (res.status != 200) {
      toastr.error(`Error ${res.error.Mensaje}`);
      setRecibos([]);
    } else {
      setRecibos(res.success.Datos);
      CreateFolderRef();
      toastr.success("Exíto");
    }
    ShowLoading(false);
  }

  function ChangeEdit(index) {
    SetIndexRecibo(index);
    const elm = [...recibos];
    elm[index].IsEdit = !elm[index].IsEdit;
    const values = formikRef.current.values;
    setRecibos(elm);
    SetItemRecibo(elm[index]);
    let itemCopia = { ...elm[index] };
    setItemSelected(itemCopia);
    var FindIdxAgente = state.InitialData.Agentes.findIndex(x => parseInt(x.Id) === parseInt(values.IDAgente));
    var FIDXEjectivo = state.InitialData.Ejecutivos.findIndex(x => parseInt(x.Id) === parseInt(values.IDEjecutCompania));
    var FIDXVendedor = state.InitialData.Vendedores.findIndex(x => parseInt(x.Id) === parseInt(values.IDVend));
    var FIDXVEjeCo = state.InitialData.Ejecutivos.findIndex(x => parseInt(x.Id) === parseInt(values.IDEjecutCobranza));
    var FIDXRamo = state.InitialData.Ramos.findIndex(x => parseInt(x.Id) === parseInt(values.IDSRamo));
    var FIDXAgente = state.InitialData.Agentes.findIndex(x => parseInt(x.Id) === parseInt(values.IDAgente));
    var FIDXMoneda = state.InitialData.Monedas.findIndex(x => parseInt(x.Id) === parseInt(values.IDMon));
    var FIDXFago = state.InitialData.FormaPago.findIndex(x => parseInt(x.Id) === parseInt(values.IDFPago));
    //var FindIdxAgente = state.InitialData.Agentes.findIndex(x => parseInt(x.Id) === parseInt(values.IDAgente));
    SetItemInfoRecibo({
      Documento: values.Documento ? values.Documento : '',
      Inciso: '',
      Cliente: ordenTrabajo.Usuario.Info.Nombre ? ordenTrabajo.Usuario.Info.Nombre : '',
      Ejecutivo: FIDXEjectivo != -1 ? state.InitialData.Ejecutivos[FIDXEjectivo].Nombre : "",
      Vendedor: FIDXVendedor != -1 ? state.InitialData.Vendedores[FIDXVendedor].Nombre : "",
      ReferenciaPago: '',
      IntPago: '0',
      EjecutivoCobranza: FIDXVEjeCo != -1 ? state.InitialData.Ejecutivos[FIDXVEjeCo].Nombre : "",
      Endoso: '',
      TipoEndoso: '',
      Ramo: FIDXRamo != -1 ? state.InitialData.Ramos[FIDXRamo].Nombre : "",
      Compania: FindIdxAgente != -1 ? state.InitialData.Agentes[FindIdxAgente].Nombre : "",
      Agente: FIDXAgente != -1 ? state.InitialData.Agentes[FIDXAgente].Nombre : "",
      Moneda: FIDXMoneda != -1 ? state.InitialData.Monedas[FIDXMoneda].Nombre : "",
      FormaPago: FIDXFago != -1 ? state.InitialData.FormaPago[FIDXFago].Nombre : "",
    })
    //$('#ModalRecibos').modal('show');
    $('#ModalRecibos').modal({
      backdrop: 'static',
      keyboard: true,
      show: true
    });
  }

  async function GeneraRecibos() {
    var recibos = [];
    const values = formikRef.current.values;

    let dataPost = {
      CiaNombre: values.CiaNombre,
    }

    //Verificar si los descuentos, recargos y derechos son proporcionales
    const res = await CallApiPost(`${UrlServicio}catalogos/getCompaniaByNombre`, dataPost, null);

    let companiaSeleccionada = res.success.Datos || null;

    var aplicacionDerechos = companiaSeleccionada && companiaSeleccionada.AplicacionDerechos ? companiaSeleccionada.AplicacionDerechos : "1";
    var aplicacionDescuentos = companiaSeleccionada && companiaSeleccionada.AplicacionDescuentos ? companiaSeleccionada.AplicacionDescuentos : "2";
    var aplicacionRecargos = companiaSeleccionada && companiaSeleccionada.AplicacionRecargos ? companiaSeleccionada.AplicacionRecargos : "2";

    if (IsChange) {
      return swal({
        title: "Advertencia",
        text: "No se ha guardado la poliza.",
        icon: "warning",
        confirmButtonText: "Aceptar",
        confirmButtonColor: "#472380"
      });
    }
    if (values.FDesde === '' || values.FDesde === null) {
      return swal({
        title: "Llenar información",
        text: "No se ha ingresado el campo : Desde ",
        icon: "warning",
        confirmButtonText: "Aceptar",
        confirmButtonColor: "#472380"
      });
    }
    if (values.FHasta === '' || values.FHasta === null) {
      return swal({
        title: "Llenar información",
        text: "No se ha ingresado el campo : Hasta ",
        icon: "warning",
        confirmButtonText: "Aceptar",
        confirmButtonColor: "#472380"
      });
    }
    if (parseFloat(values.PrimaNeta) <= 0 || values.PrimaNeta === null) {
      return swal({
        title: "Llenar información",
        text: "No se ha ingresado el campo : P Neta ",
        icon: "warning",
        confirmButtonText: "Aceptar",
        confirmButtonColor: "#472380"
      });
    }

    ShowLoading();

    //Obtener los valores a utilizar
    var Npagos = parseFloat(values.NPagos ? values.NPagos : 0);
    var Calculo = calculatePagos(values.FDesde, values.FHasta, Npagos);
    var FDesde = values.FDesde;
    var FHasta = values.FHasta;
    var PNeta = parseFloat(values.PrimaNeta ? values.PrimaNeta : 0);
    var PIVA = parseFloat(values.PorIVA ? values.PorIVA : 0);
    var PNetaRecibo = round((PNeta / Npagos), 4);
    var TotalRecargo = parseFloat(values.Recargos ? values.Recargos : 0);
    var Derechos = parseFloat(values.Derechos ? values.Derechos : 0);
    var Descuento = parseFloat(values.Descuento ? values.Descuento : 0);
    var GastosMaquila = parseFloat(values.GastosMaquila ? values.GastosMaquila : 0);
    var GastosAdmin = parseFloat(values.GastosAdmin ? values.GastosAdmin : 0);
    var PorDescuento = parseFloat(values.PDescuento ? values.PDescuento : 0);

    var SubTotal = 0;
    var IVA = 0;
    var PrimaTotal = 0;

    var DerechoProporcional = Derechos / Npagos;
    var DescuentoProporcional = Descuento / Npagos;
    var RecargosProporcional = TotalRecargo / Npagos;
    var GastosMaquilaProporcional = GastosMaquila / Npagos;
    var GastosAdminProporcional = GastosAdmin / Npagos;

    let SumTotal = 0;
    let SumPTotal = 0;

    for (let index = 0; index < Npagos; index++) {

      var Findex = index + 1;
      if (index == 0) {
        SubTotal = (parseFloat(PNetaRecibo) + parseFloat(aplicacionDerechos == "1" ? Derechos : DerechoProporcional) + GastosMaquilaProporcional + GastosAdminProporcional) - parseFloat(aplicacionDescuentos == "1" ? Descuento : DescuentoProporcional);
      } else {
        SubTotal = (parseFloat(PNetaRecibo) + parseFloat(aplicacionDerechos == "1" ? 0 : DerechoProporcional) + GastosMaquilaProporcional + GastosAdminProporcional) - parseFloat(aplicacionDescuentos == "1" ? 0 : DescuentoProporcional);
      }
      IVA = round(SubTotal * (PIVA / 100), 4);
      PrimaTotal = SubTotal + parseFloat(IVA);

      //var Com = parseFloat(PNetaRecibo);
      //var TotalCom = round(parseFloat(Com * (values.PComNeta / 100)), 2);
      //var PCGastosMaq = parseFloat(values.PCGastosMaquila ? values.PCGastosMaquila : 0) / 100;
      //var CGastosMaq = round(parseFloat((GastosMaquila) * (PCGastosMaq)), 2);
      //var PCGastosAdm = parseFloat(values.PCGastosAdmin ? values.PCGastosAdmin : 0) / 100;
      //var CGastosAdm = round(parseFloat(GastosAdmin * (PCGastosAdm)), 2);

      var ComisionNeta = round(parseFloat(PNetaRecibo * (values.PComNeta / 100)), 4);
      var ComisionRecargos = round(parseFloat(TotalRecargo * (values.PComRec / 100)), 4);
      var ComisionRecargosProporcional = round(parseFloat(values.ComRec / Npagos), 4);

      var ComisionGastosMaqProporcional = round(parseFloat(values.CGastosMaquila / Npagos), 4);
      var ComisionGastosAdmProporcional = round(parseFloat(values.CGastosAdmin / Npagos), 4);

      var ComisionDerechos = round(parseFloat(Derechos * (values.PComDer / 100)), 4);
      var ComisionDerechosProporcional = round(parseFloat(values.ComDer / Npagos), 4)
      var ComisionEspecial = round(parseFloat(PNetaRecibo * (values.PEspecial / 100)), 4);

      var Hasta = moment(FDesde).add(((Calculo.Add) * (index + 1)), Calculo.Action);
      var DesdeF = moment(FDesde).add(((Calculo.Add) * index), Calculo.Action).format('YYYYMMDD');
      let RFHasta = Findex < Npagos ? moment(FDesde).add(((Calculo.Add) * (index + 1)), Calculo.Action).format('YYYYMMDD') : moment(FHasta).format('YYYYMMDD');
      let DiasPrimerRecibo = state.InitialData.Compania.DPPRN ? state.InitialData.Compania.DPPRN : null;
      let DiasSegundoRecibo = state.InitialData.Compania.DPRSN ? state.InitialData.Compania.DPRSN : null;

      recibos.push({
        IDTemp: 0,
        IDDocto: ordenTrabajo.OT.IDDocto,
        Documento: ordenTrabajo.OT.Documento,
        FCreacion: moment(FDesde).format('YYYYMMDD'),
        FDesde: DesdeF,
        FHasta: RFHasta,
        FGeneracion: moment().format('YYYYMMDD'),
        FLimPago: index == 0 ?
          moment(DesdeF).add(DiasPrimerRecibo != null ? DiasPrimerRecibo : 0, 'Days').format('YYYYMMDD')
          :
          moment(recibos[recibos.length - 1].FLimPago ? recibos[recibos.length - 1].FLimPago : undefined).add(DiasSegundoRecibo != null ? DiasSegundoRecibo : (DiasPrimerRecibo == null ? 0 : DiasPrimerRecibo), 'Days').format('YYYYMMDD'),
        //moment(DesdeF).add(DiasSegundoRecibo != null ? DiasSegundoRecibo : (DiasPrimerRecibo == null ? 0 : DiasPrimerRecibo), 'Days').format('YYYYMMDD'),
        Periodo: Findex,
        Serie: `0${Findex}/0${Npagos}`,
        PrimaNeta: PNetaRecibo,
        Descuento: aplicacionDescuentos == "1" ? index == 0 ? Descuento : 0 : aplicacionDescuentos == "2" && DescuentoProporcional, //Dividir
        PDescuento: aplicacionDescuentos == "1" ? index == 0 ? PorDescuento : 0 : aplicacionDescuentos == "2" && PorDescuento,
        GastosMaq: round(GastosMaquilaProporcional, 4),
        GastosAdm: round(GastosAdminProporcional, 4),
        Recargos: 0,
        PorRecargos: 0,
        Derechos: aplicacionDerechos == "1" ? index == 0 ? Derechos : 0 : aplicacionDerechos == "2" && DerechoProporcional, //index == 0 ? Derechos : 0, //Dividir
        SubTotal: round(SubTotal, 4),
        IVA: IVA,
        PorIVA: PIVA,
        Ajuste: 0,
        PrimaTotal: round(PrimaTotal, 4),
        IsEdit: false,

        ComN: parseFloat(ComisionNeta),
        PComN: values.PComNeta,

        ComR: 0,
        PComR: 0,
        CGastosMaq: ComisionGastosMaqProporcional, //CGastosMaq,
        PCGastosMaq: values.PCGastosMaquila, //(PCGastosMaq * 100),
        CGastosAdm: ComisionGastosAdmProporcional, //CGastosAdm,
        PCGastosAdm: values.PCGastosAdmin, //(PCGastosAdm * 100),
        ComD: aplicacionDerechos == "1" ? index == 0 ? parseFloat(ComisionDerechos) : 0 : aplicacionDerechos == "2" && ComisionDerechosProporcional,
        PComD: aplicacionDerechos == "1" ? index == 0 ? values.PComDer : 0 : aplicacionDerechos == "2" && values.PComDer,
        Especial: parseFloat(ComisionEspecial),
        PEspecial: values.PEspecial,
        Status_TXT: "Pendiente",
        Modulo: 'F'
      });
      SumTotal += round(PrimaTotal, 4);
      SumPTotal += round(PNetaRecibo, 4);

    }

    let result = (values.PrimaTotal) - (SumTotal);
    let result2 = (values.PrimaNeta) - (SumPTotal);
    if (recibos.length > 0) {
      // if (result > 0) {
      //   recibos[0].PrimaTotal = recibos[0].PrimaTotal + Math.abs(result);
      //   recibos[0].PrimaNeta = recibos[0].PrimaNeta + Math.abs(result2);
      // } else {
      //   recibos[0].PrimaTotal = recibos[0].PrimaTotal - Math.abs(result);
      //   recibos[0].PrimaNeta = recibos[0].PrimaNeta - Math.abs(result2);
      // }
    }

    setRecibos(recibos);
    ShowLoading(false);
  }

  /* function NuevoRecibo() {
    var recibosC = [...recibos];
    const values = formikRef.current.values;

    //Validar el límite de los recibos
    const NumRecibos = values.NPagos;
    if (IsChange) {
      return swal({
        title: "Advertencia",
        text: "No se ha guardado la poliza.",
        icon: "warning",
        confirmButtonText: "Aceptar",
        confirmButtonColor: "#472380"
      });
    }
    if (values.FDesde === '' || values.FDesde === null) {
      return swal({
        title: "Llenar información",
        text: "No se ha ingresado el campo : Desde ",
        icon: "warning",
        confirmButtonText: "Aceptar",
        confirmButtonColor: "#472380"
      });
    }
    if (values.FHasta === '' || values.FHasta === null) {
      return swal({
        title: "Llenar información",
        text: "No se ha ingresado el campo : Hasta ",
        icon: "warning",
        confirmButtonText: "Aceptar",
        confirmButtonColor: "#472380"
      });
    }
    if (parseFloat(values.PrimaNeta) <= 0 || values.PrimaNeta === null) {
      return swal({
        title: "Llenar información",
        text: "No se ha ingresado el campo : P Neta ",
        icon: "warning",
        confirmButtonText: "Aceptar",
        confirmButtonColor: "#472380"
      });
    }
    if (NumRecibos == recibosC.length) {
      return swal({
        title: "Límite de recibos alcanzado.",
        text: "Ya no se pueden agregar mas recibos.",
        icon: "warning",
        confirmButtonText: "Aceptar",
        confirmButtonColor: "#472380"
      });
    }

    var Npagos = parseFloat(values.NPagos ? values.NPagos : 0);
    var FDesde = values.FDesde;
    var PNeta = 0;
    var PNeta = parseFloat(values.PrimaNeta ? values.PrimaNeta : 0);
    var NetSum = 0;
    recibosC.forEach(num => {
      NetSum += num.PrimaNeta;
    })
    var PIVA = parseFloat(values.PorIVA ? values.PorIVA : 0);
    //var PIVA = parseFloat(16);
    //var PNetaRecibo = (PNeta / recibosC.length + 1).toFixed(2);
    //var PNetaRecibo = (PNeta - NetSum);
    var PNetaRecibo = 0;
    var Rec = parseFloat(values.Recargos ? values.Recargos : 0);
    var Recargos = round((Rec / Npagos), 2);
    var PRecargos = parseFloat(values.PorRecargos ? values.PorRecargos : 0);
    var Derechos = parseFloat(values.Derechos ? values.Derechos : 0);

    var SubTotal = 0;
    var IVA = 0;
    var PrimaTotal = 0;
    var GastosMaquila = parseFloat(values.GastosMaquila ? values.GastosMaquila : 0) / Npagos;
    var GastosAdmin = parseFloat(values.GastosAdmin ? values.GastosAdmin : 0) / Npagos;

    for (let index = 0; index < Npagos; index++) {
      var Findex = index + 1;
      if (index == 0) {
        SubTotal = parseFloat(PNetaRecibo) + parseFloat(Recargos) + parseFloat(Derechos) + parseFloat(round(GastosMaquila, 2)) + parseFloat(round(GastosAdmin, 2));
      } else {
        SubTotal = parseFloat(PNetaRecibo) + parseFloat(round(GastosMaquila, 2)) + parseFloat(round(GastosAdmin, 2));
      }
      IVA = round(SubTotal * (PIVA / 100), 2);
      PrimaTotal = SubTotal + parseFloat(IVA);
      var Com = parseFloat(PNetaRecibo);
      var ComR = + parseFloat(Recargos);
      var TotalCom = round(parseFloat(Com * (values.PComNeta / 100)), 2);
      var TotalComR = round(parseFloat(ComR * (values.PComRec / 100)), 2);

      var PCGastosMaq = parseFloat(values.CGastosMaquila ? values.CGastosMaquila : 0) / 100;
      var CGastosMaq = round(parseFloat(GastosMaquila * (PCGastosMaq)), 2);
      var PCGastosAdm = parseFloat(values.PCGastosAdmin ? values.PCGastosAdmin : 0) / 100;
      var CGastosAdm = round(parseFloat(GastosAdmin * (PCGastosAdm)), 2);
      let DiasPrimerRecibo = state.InitialData.Compania.DPPRN ? state.InitialData.Compania.DPPRN : null;
      let DiasSegundoRecibo = state.InitialData.Compania.DPRSN ? state.InitialData.Compania.DPRSN : null;

      let RFHasta = moment(FDesde).add(index + 1, 'M').format('YYYYMMDD');
      recibosC.push({
        IDTemp: 0,
        IDDocto: ordenTrabajo.OT.IDDocto,
        Documento: ordenTrabajo.OT.Documento,
        FCreacion: moment(FDesde).format('YYYYMMDD'),
        FDesde: moment(FDesde).add(index, 'M').format('YYYYMMDD'),
        FHasta: RFHasta,
        FGeneracion: moment().format('YYYYMMDD'),
        FLimPago: index == 0 ? moment(DesdeF).add(DiasPrimerRecibo != null ? DiasPrimerRecibo : 0, 'Days').format('YYYYMMDD') : moment(DesdeF).add(DiasSegundoRecibo != null ? DiasSegundoRecibo : (DiasPrimerRecibo == null ? 0 : DiasPrimerRecibo), 'Days').format('YYYYMMDD'),
        Periodo: Findex,
        Serie: `0${Findex}/0${Npagos}`,
        PrimaNeta: PNetaRecibo,
        Descuento: 0,
        PorDescuento: 0,
        Recargos: Recargos,
        PorRecargos: PRecargos,
        Derechos: index == 0 ? Derechos : 0,
        SubTotal: SubTotal,
        IVA: IVA,
        PorIVA: PIVA,
        Ajuste: 0,
        PrimaTotal: round(PrimaTotal, 2),
        IsEdit: false,

        ComN: parseFloat(TotalCom),
        ComR: parseFloat(TotalComR),
        PComN: values.PComNeta,
        PComR: values.PComRec,
        GastosMaq: round(GastosMaquila, 2),
        GastosAdm: round(GastosAdmin, 2),
        CGastosMaq: CGastosMaq,
        PCGastosMaq: (PCGastosMaq) * 100,
        CGastosAdm: CGastosAdm,
        PCGastosMaq: (PCGastosAdm) * 100,
        Modulo: 'F'
      });
    }
    setRecibos(recibosC);
  } */

  function NuevoRecibo() {
    var recibosC = [...recibos];
    const values = formikRef.current.values;

    //Validar el límite de los recibos
    const NumRecibos = values.NPagos;
    if (IsChange) {
      return swal({
        title: "Advertencia",
        text: "No se ha guardado la poliza.",
        icon: "warning",
        confirmButtonText: "Aceptar",
        confirmButtonColor: "#472380"
      });
    }
    if (values.FDesde === '' || values.FDesde === null) {
      return swal({
        title: "Llenar información",
        text: "No se ha ingresado el campo : Desde ",
        icon: "warning",
        confirmButtonText: "Aceptar",
        confirmButtonColor: "#472380"
      });
    }
    if (values.FHasta === '' || values.FHasta === null) {
      return swal({
        title: "Llenar información",
        text: "No se ha ingresado el campo : Hasta ",
        icon: "warning",
        confirmButtonText: "Aceptar",
        confirmButtonColor: "#472380"
      });
    }
    if (parseFloat(values.PrimaNeta) <= 0 || values.PrimaNeta === null) {
      return swal({
        title: "Llenar información",
        text: "No se ha ingresado el campo : P Neta ",
        icon: "warning",
        confirmButtonText: "Aceptar",
        confirmButtonColor: "#472380"
      });
    }
    if (NumRecibos == recibosC.length) {
      return swal({
        title: "Límite de recibos alcanzado.",
        text: "Ya no se pueden agregar mas recibos.",
        icon: "warning",
        confirmButtonText: "Aceptar",
        confirmButtonColor: "#472380"
      });
    }

    var Npagos = parseFloat(values.NPagos ? values.NPagos : 0);
    var FDesde = values.FDesde;
    var PNeta = 0;
    var PNeta = parseFloat(values.PrimaNeta ? values.PrimaNeta : 0);
    var NetSum = 0;
    recibosC.forEach(num => {
      NetSum += num.PrimaNeta;
    })
    var PIVA = parseFloat(values.PorIVA ? values.PorIVA : 0);
    //var PIVA = parseFloat(16);
    //var PNetaRecibo = (PNeta / recibosC.length + 1).toFixed(2);
    //var PNetaRecibo = (PNeta - NetSum);
    var PNetaRecibo = 0;
    var Rec = parseFloat(values.Recargos ? values.Recargos : 0);
    var Recargos = round(Rec / Npagos, 2);
    var PRecargos = parseFloat(values.PorRecargos ? values.PorRecargos : 0);
    var PorDescuento = parseFloat(values.PDescuento ? values.PDescuento : 0);

    //var SubTotal = PNeta + Recargos + Derechos;
    //var IVA = SubTotal * (PIVA / 100);
    //var PrimaTotal = SubTotal + IVA;
    var SubTotal = 0;
    var IVA = 0;
    var PrimaTotal = 0;

    /* if (recibosC.length == 0) {
        SubTotal = parseFloat(PNetaRecibo) + parseFloat(Recargos) + parseFloat(Derechos);
    } else {
        SubTotal = parseFloat(PNetaRecibo);
    } */

    //IVA = round(SubTotal * (PIVA / 100), 2);
    //PrimaTotal = SubTotal + parseFloat(IVA);
    var Com = parseFloat(PNetaRecibo);
    var ComR = + parseFloat(Recargos);
    var TotalCom = round(parseFloat(Com * (values.PComNeta / 100)), 2);
    var TotalComR = round(parseFloat(ComR * (values.PComRec / 100)), 2);
    //var RFHasta = moment(FDesde).add(recibosC.length + 2, 'M').format('YYYYMMDD');
    let DiasPrimerRecibo = state.InitialData.Compania.DPPRN ? state.InitialData.Compania.DPPRN : null;
    let DiasSegundoRecibo = state.InitialData.Compania.DPRSN ? state.InitialData.Compania.DPRSN : null;
    var Calculo = calculatePagos(values.FDesde, values.FHasta, Npagos);
    var UltimoRecibo = recibosC[recibosC.length - 1];
    var HastaUltRecibo = moment(UltimoRecibo && UltimoRecibo.FHasta ? UltimoRecibo.FHasta : values.FHasta).add(3, "month").format('YYYYMMDD');
    var DesdeF = moment(FDesde).add(((Calculo.Add) * (recibosC.length)), Calculo.Action).format('YYYYMMDD');

    recibosC.push({
      IDTemp: 0,
      IDDocto: ordenTrabajo.OT.IDDocto,
      Documento: ordenTrabajo.OT.Documento,
      FCreacion: moment(FDesde).format('YYYYMMDD'),
      FDesde: (recibosC.length) == 0 ? moment(DesdeF).format('YYYYMMDD') : UltimoRecibo && UltimoRecibo.FHasta ? UltimoRecibo.FHasta : values.Fesde,
      FHasta: (recibosC.length) == 0 ? moment(DesdeF).format('YYYYMMDD') : HastaUltRecibo,
      FGeneracion: moment().format('YYYYMMDD'),
      FLimPago: (recibosC.length - 1) == 0 ?
        moment(DesdeF).add(DiasPrimerRecibo != null ? DiasPrimerRecibo : 0, 'Days').format('YYYYMMDD')
        :
        moment(recibos.length > 0 ? recibos[recibos.length - 1].FLimPago : undefined).add(DiasSegundoRecibo != null ? DiasSegundoRecibo : (DiasPrimerRecibo == null ? 0 : DiasPrimerRecibo), 'Days').format('YYYYMMDD'),
      //moment(DesdeF).add(DiasSegundoRecibo != null ? DiasSegundoRecibo : (DiasPrimerRecibo == null ? 0 : DiasPrimerRecibo), 'Days').format('YYYYMMDD'),
      Periodo: recibosC.length + 1,
      Serie: `0${recibosC.length + 1}/0${recibosC.length + 1}`,
      PrimaNeta: 0,
      Descuento: 0,
      PDescuento: PorDescuento,
      GastosMaq: 0,
      GastosAdm: 0,
      Recargos: 0,
      PorRecargos: 0,
      Derechos: 0,
      SubTotal: SubTotal,
      IVA: IVA,
      PorIVA: PIVA,
      Ajuste: 0,
      PrimaTotal: PrimaTotal,
      IsEdit: false,

      ComN: 0,
      PComN: values.PComNeta,

      ComR: 0,
      PComR: 0,
      CGastosMaq: 0,
      PCGastosMaq: values.PCGastosMaquila,
      CGastosAdm: 0,
      PCGastosAdm: values.PCGastosAdmin,
      ComD: 0,
      PComD: values.PComDer,
      Especial: 0,
      PEspecial: values.PEspecial,
      Status_TXT: "Pendiente",
      Modulo: 'P'
    });

    setRecibos(recibosC);
  }

  async function DeleteAllRecibos() {
    var _recibos = [...recibos];
    if (_recibos && _recibos.length > 0) {

      let recibosPendientes = _recibos.filter(r => r.Status_TXT === "Pendiente");

      if (recibosPendientes.length > 0) {
        recibosPendientes.forEach(async (element, idx) => {
          if (element.Status_TXT == "Pendiente") {
            var dta = {
              "Id": element.IDTemp
            };

            if (dta.Id > 0) {
              const res = await CallApiPost(`${UrlServicio}capture/deleteRecibo`, dta, null);
              if (res.status != 200) {
                return toastr.error(`Error ${res.error.Mensaje}`);
              } else {

              }
            }
          }
        });
      }

      let _recibosFinales = _recibos.filter(r => r.Status_TXT !== "Pendiente");
      toastr.success("Exíto");
      setRecibos(_recibosFinales || []);
    }
    else {
      toastr.success("Exíto");
      setRecibos([]);
    }

    /* var Itms = [...recibos];
    Itms.forEach(async (element, idx) => {
        var dta = {
            "Id": Itms[idx]['IDTemp']
        };
        if (Itms[idx]['IDTemp'] == undefined) {
            //toastr.success("Exíto");
 
        } else {
            const res = await CallApiPost(`${UrlServicio}capture/deleteRecibo`, dta, null);
            if (res.status != 200) {
                return toastr.error(`Error ${res.error.Mensaje}`);
            } else {
                //toastr.success("Exíto");
            }
        }
    });
    toastr.success("Exíto");
    setRecibos([]); */
  }


  //Nuevos Métodos
  const [itemSelected, setItemSelected] = useState(null);
  function NewChangeValueRecibo(index, field, value) {

    // No se utiliza el Ajuste y los Recargos
    let _recibos = [...recibos];
    _recibos[index][field] = value;

    if (field == "PrimaNeta") {
      let descuento = parseFloat(value * _recibos[index].PDescuento / 100);
      let subtotal = (parseFloat(value) + parseFloat(_recibos[index].Derechos) + parseFloat(_recibos[index].GastosMaq) + parseFloat(_recibos[index].GastosAdm)) - parseFloat(descuento);
      let iva = round(parseFloat(subtotal * _recibos[index].PorIVA / 100), 4);
      let total = round(parseFloat(subtotal + iva + parseFloat(_recibos[index].Ajuste)), 4);
      let comN = round(parseFloat(value * _recibos[index].PComN / 100), 4);
      let especial = round(parseFloat(value * _recibos[index].PEspecial / 100), 4);

      _recibos[index].Descuento = descuento;
      _recibos[index].IVA = iva;
      _recibos[index].SubTotal = subtotal;
      _recibos[index].PrimaTotal = total;

      _recibos[index].ComN = comN;
      _recibos[index].Especial = especial;
    }
    else if (field == "Descuento") {

      let pDescuento = round(parseFloat(value / _recibos[index].PrimaNeta * 100), 4);
      let subtotal = round((parseFloat(_recibos[index].PrimaNeta) + parseFloat(_recibos[index].Derechos) + parseFloat(_recibos[index].GastosMaq) + parseFloat(_recibos[index].GastosAdm)) - parseFloat(value), 4);
      let total = round(parseFloat(subtotal) + parseFloat(_recibos[index].IVA), 4);

      _recibos[index].PDescuento = pDescuento;
      _recibos[index].SubTotal = subtotal;
      _recibos[index].PrimaTotal = total;
    }
    else if (field == "PDescuento") {

      let descuento = round(parseFloat(_recibos[index].PrimaNeta * value / 100), 4);
      let subtotal = round((parseFloat(_recibos[index].PrimaNeta) + parseFloat(_recibos[index].Derechos) + parseFloat(_recibos[index].GastosMaq) + parseFloat(_recibos[index].GastosAdm)) - parseFloat(descuento), 4);
      let total = round(parseFloat(subtotal + _recibos[index].IVA), 4);

      _recibos[index].Descuento = descuento;
      _recibos[index].SubTotal = subtotal;
      _recibos[index].PrimaTotal = total;
    }
    else if (field == "GastosMaq") {

      let subtotal = (parseFloat(_recibos[index].PrimaNeta) + parseFloat(value) + parseFloat(_recibos[index].GastosAdm) + parseFloat(_recibos[index].Derechos)) - parseFloat(_recibos[index].PrimaNeta * _recibos[index].PDescuento / 100);
      let iva = round(parseFloat(subtotal * _recibos[index].PorIVA / 100), 4)
      let total = round(parseFloat(subtotal + (subtotal * _recibos[index].PorIVA / 100)), 4);

      let cGastosMaq = round(parseFloat(value * _recibos[index].PCGastosMaq / 100), 4);

      _recibos[index].SubTotal = subtotal;
      _recibos[index].IVA = iva;
      _recibos[index].PrimaTotal = total;

      _recibos[index].CGastosMaq = cGastosMaq;
    }
    else if (field == "GastosAdm") {

      let subtotal = (parseFloat(_recibos[index].PrimaNeta) + parseFloat(_recibos[index].GastosMaq) + parseFloat(value) + parseFloat(_recibos[index].Derechos)) - parseFloat(_recibos[index].PrimaNeta * _recibos[index].PDescuento / 100);
      let iva = round(parseFloat(subtotal * _recibos[index].PorIVA / 100), 4)
      let total = round(parseFloat(subtotal + (subtotal * _recibos[index].PorIVA / 100)), 4);

      let cGastosAdm = round(parseFloat(value * _recibos[index].PCGastosAdm / 100), 4);

      _recibos[index].SubTotal = subtotal;
      _recibos[index].IVA = iva;
      _recibos[index].PrimaTotal = total;

      _recibos[index].CGastosAdm = cGastosAdm;
    }
    else if (field == "Derechos") {

      let subtotal = (parseFloat(_recibos[index].PrimaNeta) + parseFloat(_recibos[index].GastosMaq) + parseFloat(_recibos[index].GastosAdm) + parseFloat(value)) - parseFloat(_recibos[index].PrimaNeta * _recibos[index].PDescuento / 100);
      let iva = round(parseFloat(subtotal * _recibos[index].PorIVA / 100), 4)
      let total = round(parseFloat(subtotal + (subtotal * _recibos[index].PorIVA / 100)) + parseFloat(_recibos[index].Ajuste), 4);

      let comD = round(parseFloat(value * _recibos[index].PComD / 100), 4);

      _recibos[index].SubTotal = subtotal;
      _recibos[index].IVA = iva;
      _recibos[index].PrimaTotal = total;

      _recibos[index].ComD = comD;
    }
    else if (field == "IVA") {

      let piva = round(parseFloat(value / _recibos[index].SubTotal * 100), 4);
      let total = round(parseFloat(_recibos[index].SubTotal) + parseFloat(value), 4);

      _recibos[index].PorIVA = piva;
      _recibos[index].PrimaTotal = total;
    }
    else if (field == "PorIVA") {

      let iva = round(parseFloat(value / 100 * _recibos[index].SubTotal), 4);
      let total = round(parseFloat(_recibos[index].SubTotal + _recibos[index].SubTotal * value / 100), 4);

      _recibos[index].IVA = iva;
      _recibos[index].PrimaTotal = total;
    }
    else if (field == "PrimaTotal") {

      let subtotal = round(parseFloat(value) / (1 + (_recibos[index].PorIVA / 100)), 4);
      let iva = round(parseFloat(subtotal * _recibos[index].PorIVA / 100), 4);
      let primaneta = round(parseFloat((subtotal - _recibos[index].Derechos - parseFloat(_recibos[index].GastosMaq) - parseFloat(_recibos[index].GastosAdm)) / (1 - (_recibos[index].PDescuento / 100))), 4);
      let descuento = round(parseFloat(primaneta * _recibos[index].PDescuento / 100), 4);

      let comN = round(parseFloat(primaneta * _recibos[index].PComN / 100), 4);
      let especial = round(parseFloat(primaneta * _recibos[index].PEspecial / 100), 4);

      _recibos[index].SubTotal = subtotal;
      _recibos[index].IVA = iva;
      _recibos[index].PrimaNeta = primaneta;
      _recibos[index].Descuento = descuento;

      _recibos[index].ComN = comN;
      _recibos[index].Especial = especial;
    }

    else if (field == "ComN") {
      let pComN = round(parseFloat(value / _recibos[index].PrimaNeta * 100), 4);
      _recibos[index].PComN = pComN;
    }
    else if (field == "PComN") {
      let comN = round(parseFloat(_recibos[index].PrimaNeta * value / 100), 4);
      _recibos[index].ComN = comN;
    }
    else if (field == "ComR") {
      let pComR = round(parseFloat(value / _recibos[index].Recargos * 100), 4);
      _recibos[index].PComR = pComR;
    }
    else if (field == "PComR") {
      let comR = round(parseFloat(_recibos[index].Recargos * value / 100), 4);
      _recibos[index].ComR = comR;
    }
    else if (field == "ComD") {
      let pComD = round(parseFloat(value / _recibos[index].Derechos * 100), 4);
      _recibos[index].PComD = pComD;
    }
    else if (field == "PComD") {
      let comD = round(parseFloat(_recibos[index].Derechos * value / 100), 4);
      _recibos[index].ComD = comD;
    }
    else if (field == "Especial") {
      let pEspecial = round(parseFloat(value / _recibos[index].PrimaNeta * 100), 4);
      _recibos[index].PEspecial = pEspecial;
    }
    else if (field == "PEspecial") {
      let especial = round(parseFloat(_recibos[index].PrimaNeta * value / 100), 4);
      _recibos[index].Especial = especial;
    }
    else if (field == "CGastosMaq") {
      let pcGastosMaq = round(parseFloat(value / _recibos[index].GastosMaq * 100), 4);
      _recibos[index].PCGastosMaq = pcGastosMaq;
    }
    else if (field == "PCGastosMaq") {
      let cGastosMaq = round(parseFloat(value * _recibos[index].PCGastosMaq / 100), 4);
      _recibos[index].CGastosMaq = cGastosMaq;
    }
    else if (field == "CGastosAdm") {
      let pcGastosAdm = round(parseFloat(value / _recibos[index].GastosAdm * 100), 4);
      _recibos[index].PCGastosAdm = pcGastosAdm;
    }
    else if (field == "PCGastosAdm") {
      let cGastosAdm = round(parseFloat(value * _recibos[index].PCGastosAdm / 100), 4);
      _recibos[index].CGastosAdm = cGastosAdm;
    }

    setRecibos(_recibos);
    SetIsChange(false);
  }

  function ReloadRecibosSubsecuentes(index, item) {
    const values = formikRef.current.values;

    //No tenemos Ajuste y Recargos

    let PrimaTotal = values.PrimaNeta || 0;
    let DescuentoTotal = values.Descuento || 0;
    let RecargosTotales = 0;
    let DerechosTotales = values.Derechos || 0;
    let GastosMaqTotales = values.GastosMaquila || 0;
    let GastosAdmTotales = values.GastosAdmin || 0;
    let IVATotal = values.IVA || 0;
    let AjusteTotal = 0;

    let ComisionPrimaNeta = values.ComNeta || 0;
    let ComisionRecargos = 0;
    let ComisionDerechos = values.ComDer || 0;
    let ComisionGastosMaq = values.CGastosMaquila || 0;
    let ComisionGastosAdm = values.CGastosAdmin || 0;
    let ComisionEspecial = values.Especial || 0;

    if (item.PrimaNeta >= PrimaTotal) {
      return swal({
        title: "Límite prima neta.",
        text: "La prima neta no puede ser igual o mayor a la prima neta total.",
        icon: "warning",
        confirmButtonText: "Aceptar",
        confirmButtonColor: "#472380"
      });
    }
    if (item.GastosMaq > GastosMaqTotales) {
      return swal({
        title: "Límite Gastos Maquila.",
        text: "El gasto de maquila no puede ser mayor al gasto de maquila total.",
        icon: "warning",
        confirmButtonText: "Aceptar",
        confirmButtonColor: "#472380"
      });
    }
    if (item.GastosAdm > GastosAdmTotales) {
      return swal({
        title: "Límite Gastos Administración.",
        text: "El gasto de administración no puede ser mayor al gasto de administración total.",
        icon: "warning",
        confirmButtonText: "Aceptar",
        confirmButtonColor: "#472380"
      });
    }
    if (item.Descuento > DescuentoTotal) {
      return swal({
        title: "Límite descuento.",
        text: "El descuento no puede ser mayor al descuento total.",
        icon: "warning",
        confirmButtonText: "Aceptar",
        confirmButtonColor: "#472380"
      });
    }
    /* if (item.Recargos > RecargosTotales) {
      return swal({
        title: "Límite recargos.",
        text: "El recargo no puede ser mayor al recargo total.",
        icon: "warning",
        confirmButtonText: "Aceptar",
        confirmButtonColor: "#472380"
      });
    } */
    if (item.Derechos > DerechosTotales) {
      return swal({
        title: "Límite derechos.",
        text: "El derecho no puede ser mayor al derecho total.",
        icon: "warning",
        confirmButtonText: "Aceptar",
        confirmButtonColor: "#472380"
      });
    }
    if (item.IVA > IVATotal) {
      return swal({
        title: "Límite IVA.",
        text: "El IVA no puede ser mayor al IVA total.",
        icon: "warning",
        confirmButtonText: "Aceptar",
        confirmButtonColor: "#472380"
      });
    }
    /* if (item.Ajuste > AjusteTotal) {
      return swal({
        title: "Límite ajuste.",
        text: "El ajuste no puede ser mayor al ajuste total.",
        icon: "warning",
        confirmButtonText: "Aceptar",
        confirmButtonColor: "#472380"
      });
    } */

    //Datos principales
    let PAcmu = 0, DesAcmu = 0, /* RAcmu = 0, */ DAcmu = 0, IVAcmu = 0, /* AjusteAcmu = 0, */ GastosMaqAcmu = 0, GastosAdmAcmu = 0;

    //Datos de las comisiones
    let ComPNetaAcmu = 0, /* ComRAcmu = 0, */ ComDAcmu = 0, ComEspAcmu = 0, ComGastosMaqAcmu = 0, ComGastosAdmAcmu = 0;

    let totalRecibosRestantes = recibos.length - (index + 1);

    let _recibos = recibos.map((recibo, idx) => {
      let newRecibo = { ...recibo };

      if (idx > index) {
        let remainingRecibos = totalRecibosRestantes || 1;

        //Valores principales
        newRecibo.PrimaNeta = round((PrimaTotal - PAcmu) / remainingRecibos, 4);
        newRecibo.Descuento = round((DescuentoTotal - DesAcmu) / remainingRecibos, 4);
        /* newRecibo.Recargos = round((RecargosTotales - RAcmu) / remainingRecibos, 4); */
        newRecibo.Derechos = round((DerechosTotales - DAcmu) / remainingRecibos, 4);
        newRecibo.IVA = round((IVATotal - IVAcmu) / remainingRecibos, 4);
        /* newRecibo.Ajuste = round((AjusteTotal - AjusteAcmu) / remainingRecibos, 4); */
        newRecibo.GastosMaq = round((GastosMaqTotales - GastosMaqAcmu) / remainingRecibos, 4);
        newRecibo.GastosAdm = round((GastosAdmTotales - GastosAdmAcmu) / remainingRecibos, 4);

        //Valores de las comisiones
        newRecibo.ComN = round((ComisionPrimaNeta - ComPNetaAcmu) / remainingRecibos, 4);
        /* newRecibo.ComR = round((ComisionRecargos - ComRAcmu) / remainingRecibos, 4); */
        newRecibo.CGastosMaq = round((ComisionGastosMaq - ComGastosMaqAcmu) / remainingRecibos, 4);
        newRecibo.CGastosAdm = round((ComisionGastosAdm - ComGastosAdmAcmu) / remainingRecibos, 4);
        newRecibo.ComD = round((ComisionDerechos - ComDAcmu) / remainingRecibos, 4);
        newRecibo.Especial = round((ComisionEspecial - ComEspAcmu) / remainingRecibos, 4);

      } else {
        //Valores principales
        PAcmu += parseFloat(recibo.PrimaNeta || 0);
        DesAcmu += parseFloat(recibo.Descuento || 0);
        /* RAcmu += parseFloat(recibo.Recargos || 0); */
        DAcmu += parseFloat(recibo.Derechos || 0);
        IVAcmu += parseFloat(recibo.IVA || 0);
        /* AjusteAcmu += parseFloat(recibo.Ajuste || 0); */
        GastosMaqAcmu += parseFloat(recibo.GastosMaq || 0);
        GastosAdmAcmu += parseFloat(recibo.GastosAdm || 0);

        //Valores de las comisiones
        ComPNetaAcmu += parseFloat(recibo.ComN || 0);
        /* ComRAcmu += parseFloat(recibo.ComR || 0); */
        ComDAcmu += parseFloat(recibo.ComD || 0);
        ComEspAcmu += parseFloat(recibo.Especial || 0);
        ComGastosMaqAcmu += parseFloat(recibo.CGastosMaq || 0);
        ComGastosAdmAcmu += parseFloat(recibo.CGastosAdm || 0);
      }

      return newRecibo;
    });

    _recibos.forEach((item, indexRecibo) => {
      if (indexRecibo > index) {

        let subtotal = round((parseFloat(item.PrimaNeta + item.GastosMaq + item.GastosAdm + item.Derechos)) - parseFloat(item.Descuento), 4);

        item.PDescuento = round((item.Descuento / item.PrimaNeta) * 100, 4);
        /* item.PorRecargos = round((item.Recargos / item.PrimaNeta) * 100, 4); */
        item.SubTotal = round((parseFloat(item.PrimaNeta + item.GastosMaq + item.GastosAdm + item.Derechos)) - parseFloat(item.Descuento), 4);
        item.PorIVA = round((item.IVA / subtotal) * 100, 4);
        item.PrimaTotal = round((parseFloat(item.PrimaNeta + item.GastosMaq + item.GastosAdm + item.Derechos)) - parseFloat(item.Descuento) + parseFloat(item.IVA), 4);

        item.PComN = round((item.ComN / item.PrimaNeta) * 100, 4);
        /* item.PComR = round((item.ComR / item.Recargos) * 100, 4); */
        item.PComD = round((item.ComD / item.Derechos) * 100, 4);
        item.PEspecial = round((item.Especial / item.PrimaNeta) * 100, 4);
        item.PCGastosMaq = round((item.CGastosMaq / item.GastosMaq) * 100, 4);
        item.PCGastosAdm = round((item.CGastosAdm / item.GastosAdm) * 100, 4);
      }
    });

    setRecibos(_recibos);
    closeModal();
  }

  function cancelAction(index, itemSelected) {
    let _recibos = [...recibos];
    _recibos[index] = itemSelected;
    setRecibos(_recibos);
  }

  function closeModal() {
    $('#ModalRecibos').modal('hide');
  }

  function recalculateAllRecibos(index, item) {
    var recibosC = [...recibos];
    const values = formikRef.current.values;

    //Validar el límite de los recibos
    const NumRecibos = values.NPagos;
    if (IsChange) {
      return swal({
        title: "Advertencia",
        text: "No se ha guardado la poliza.",
        icon: "warning",
        confirmButtonText: "Aceptar",
        confirmButtonColor: "#472380"
      });
    }
    if (values.FDesde === '' || values.FDesde === null) {
      return swal({
        title: "Llenar información",
        text: "No se ha ingresado el campo : Desde ",
        icon: "warning",
        confirmButtonText: "Aceptar",
        confirmButtonColor: "#472380"
      });
    }
    if (values.FHasta === '' || values.FHasta === null) {
      return swal({
        title: "Llenar información",
        text: "No se ha ingresado el campo : Hasta ",
        icon: "warning",
        confirmButtonText: "Aceptar",
        confirmButtonColor: "#472380"
      });
    }
    if (parseFloat(values.PrimaNeta) <= 0 || values.PrimaNeta === null) {
      return swal({
        title: "Llenar información",
        text: "No se ha ingresado el campo : P Neta ",
        icon: "warning",
        confirmButtonText: "Aceptar",
        confirmButtonColor: "#472380"
      });
    }
    if (NumRecibos == recibosC.length) {
      return swal({
        title: "Límite de recibos alcanzado.",
        text: "Ya no se pueden agregar mas recibos.",
        icon: "warning",
        confirmButtonText: "Aceptar",
        confirmButtonColor: "#472380"
      });
    }

    var Npagos = parseFloat(values.NPagos ? values.NPagos : 0);
    let totalRegistros = Npagos - recibos.length;

    for (let index = 0; index < totalRegistros; index++) {
      var FDesde = values.FDesde;
      var PNeta = 0;
      var PNeta = parseFloat(values.PrimaNeta ? values.PrimaNeta : 0);
      var NetSum = 0;
      recibosC.forEach(num => {
        NetSum += num.PrimaNeta;
      })
      var PIVA = parseFloat(values.PorIVA ? values.PorIVA : 0);
      //var PIVA = parseFloat(16);
      //var PNetaRecibo = (PNeta / recibosC.length + 1).toFixed(2);
      //var PNetaRecibo = (PNeta - NetSum);
      var PNetaRecibo = 0;
      var Rec = parseFloat(values.Recargos ? values.Recargos : 0);
      var Recargos = round(Rec / Npagos, 2);
      var PRecargos = parseFloat(values.PorRecargos ? values.PorRecargos : 0);
      var PorDescuento = parseFloat(values.PDescuento ? values.PDescuento : 0);

      //var SubTotal = PNeta + Recargos + Derechos;
      //var IVA = SubTotal * (PIVA / 100);
      //var PrimaTotal = SubTotal + IVA;
      var SubTotal = 0;
      var IVA = 0;
      var PrimaTotal = 0;

      /* if (recibosC.length == 0) {
          SubTotal = parseFloat(PNetaRecibo) + parseFloat(Recargos) + parseFloat(Derechos);
      } else {
          SubTotal = parseFloat(PNetaRecibo);
      } */

      //IVA = round(SubTotal * (PIVA / 100), 2);
      //PrimaTotal = SubTotal + parseFloat(IVA);
      var Com = parseFloat(PNetaRecibo);
      var ComR = + parseFloat(Recargos);
      var TotalCom = round(parseFloat(Com * (values.PComNeta / 100)), 2);
      var TotalComR = round(parseFloat(ComR * (values.PComRec / 100)), 2);
      //var RFHasta = moment(FDesde).add(recibosC.length + 2, 'M').format('YYYYMMDD');
      let DiasPrimerRecibo = state.InitialData.Compania.DPPRN ? state.InitialData.Compania.DPPRN : null;
      let DiasSegundoRecibo = state.InitialData.Compania.DPRSN ? state.InitialData.Compania.DPRSN : null;
      var Calculo = calculatePagos(values.FDesde, values.FHasta, Npagos);
      var UltimoRecibo = recibosC[recibosC.length - 1];
      var HastaUltRecibo = moment(UltimoRecibo && UltimoRecibo.FHasta ? UltimoRecibo.FHasta : values.FHasta).add(3, "month").format('YYYYMMDD');
      var DesdeF = moment(FDesde).add(((Calculo.Add) * (recibosC.length)), Calculo.Action).format('YYYYMMDD');

      recibosC.push({
        IDTemp: 0,
        IDDocto: ordenTrabajo.OT.IDDocto,
        Documento: ordenTrabajo.OT.Documento,
        FCreacion: moment(FDesde).format('YYYYMMDD'),
        FDesde: UltimoRecibo && UltimoRecibo.FHasta ? UltimoRecibo.FHasta : values.Fesde,
        FHasta: HastaUltRecibo,
        FGeneracion: moment().format('YYYYMMDD'),
        FLimPago: (recibosC.length - 1) == 0 ?
          moment(DesdeF).add(DiasPrimerRecibo != null ? DiasPrimerRecibo : 0, 'Days').format('YYYYMMDD')
          :
          moment(recibos[recibos.length - 1].FLimPago ? recibos[recibos.length - 1].FLimPago : undefined).add(DiasSegundoRecibo != null ? DiasSegundoRecibo : (DiasPrimerRecibo == null ? 0 : DiasPrimerRecibo), 'Days').format('YYYYMMDD'),
        //moment(DesdeF).add(DiasSegundoRecibo != null ? DiasSegundoRecibo : (DiasPrimerRecibo == null ? 0 : DiasPrimerRecibo), 'Days').format('YYYYMMDD'),
        Periodo: recibosC.length + 1,
        Serie: `0${recibosC.length + 1}/0${recibosC.length + 1}`,
        PrimaNeta: 0,
        Descuento: 0,
        PDescuento: PorDescuento,
        GastosMaq: 0,
        GastosAdm: 0,
        Recargos: 0,
        PorRecargos: 0,
        Derechos: 0,
        SubTotal: SubTotal,
        IVA: IVA,
        PorIVA: PIVA,
        Ajuste: 0,
        PrimaTotal: PrimaTotal,
        IsEdit: false,

        ComN: 0,
        PComN: values.PComNeta,

        ComR: 0,
        PComR: 0,
        CGastosMaq: 0,
        PCGastosMaq: values.PCGastosMaquila,
        CGastosAdm: 0,
        PCGastosAdm: values.PCGastosAdmin,
        ComD: 0,
        PComD: values.PComDer,
        Especial: 0,
        PEspecial: values.PEspecial,
        Status_TXT: "Pendiente",
        Modulo: 'P'
      });
    }

    let PrimaTotal2 = values.PrimaNeta || 0;
    let DescuentoTotal = values.Descuento || 0;
    let RecargosTotales = 0;
    let DerechosTotales = values.Derechos || 0;
    let GastosMaqTotales = values.GastosMaquila || 0;
    let GastosAdmTotales = values.GastosAdmin || 0;
    let IVATotal = values.IVA || 0;
    let AjusteTotal = 0;

    let ComisionPrimaNeta = values.ComNeta || 0;
    let ComisionRecargos = 0;
    let ComisionDerechos = values.ComDer || 0;
    let ComisionGastosMaq = values.CGastosMaquila || 0;
    let ComisionGastosAdm = values.CGastosAdmin || 0;
    let ComisionEspecial = values.Especial || 0;

    /* if (item.PrimaNeta >= PrimaTotal) {
      return swal({
        title: "Límite prima neta.",
        text: "La prima neta no puede ser igual o mayor a la prima neta total.",
        icon: "warning",
        confirmButtonText: "Aceptar",
        confirmButtonColor: "#472380"
      });
    }
    if (item.GastosMaq > GastosMaqTotales) {
      return swal({
        title: "Límite Gastos Maquila.",
        text: "El gasto de maquila no puede ser mayor al gasto de maquila total.",
        icon: "warning",
        confirmButtonText: "Aceptar",
        confirmButtonColor: "#472380"
      });
    }
    if (item.GastosAdm > GastosAdmTotales) {
      return swal({
        title: "Límite Gastos Administración.",
        text: "El gasto de administración no puede ser mayor al gasto de administración total.",
        icon: "warning",
        confirmButtonText: "Aceptar",
        confirmButtonColor: "#472380"
      });
    }
    if (item.Descuento > DescuentoTotal) {
      return swal({
        title: "Límite descuento.",
        text: "El descuento no puede ser mayor al descuento total.",
        icon: "warning",
        confirmButtonText: "Aceptar",
        confirmButtonColor: "#472380"
      });
    }
    if (item.Derechos > DerechosTotales) {
      return swal({
        title: "Límite derechos.",
        text: "El derecho no puede ser mayor al derecho total.",
        icon: "warning",
        confirmButtonText: "Aceptar",
        confirmButtonColor: "#472380"
      });
    }
    if (item.IVA > IVATotal) {
      return swal({
        title: "Límite IVA.",
        text: "El IVA no puede ser mayor al IVA total.",
        icon: "warning",
        confirmButtonText: "Aceptar",
        confirmButtonColor: "#472380"
      });
    } */

    //Datos principales
    let PAcmu = 0, DesAcmu = 0, /* RAcmu = 0, */ DAcmu = 0, IVAcmu = 0, /* AjusteAcmu = 0, */ GastosMaqAcmu = 0, GastosAdmAcmu = 0;

    //Datos de las comisiones
    let ComPNetaAcmu = 0, /* ComRAcmu = 0, */ ComDAcmu = 0, ComEspAcmu = 0, ComGastosMaqAcmu = 0, ComGastosAdmAcmu = 0;

    let totalRecibosRestantes = recibosC.length - (index + 1);

    let _recibos = recibosC.map((recibo, idx) => {
      let newRecibo = { ...recibo };

      if (idx > index) {
        let remainingRecibos = totalRecibosRestantes || 1;

        //Valores principales
        newRecibo.PrimaNeta = round((PrimaTotal2 - PAcmu) / remainingRecibos, 4);
        newRecibo.Descuento = round((DescuentoTotal - DesAcmu) / remainingRecibos, 4);
        /* newRecibo.Recargos = round((RecargosTotales - RAcmu) / remainingRecibos, 4); */
        newRecibo.Derechos = round((DerechosTotales - DAcmu) / remainingRecibos, 4);
        newRecibo.IVA = round((IVATotal - IVAcmu) / remainingRecibos, 4);
        /* newRecibo.Ajuste = round((AjusteTotal - AjusteAcmu) / remainingRecibos, 4); */
        newRecibo.GastosMaq = round((GastosMaqTotales - GastosMaqAcmu) / remainingRecibos, 4);
        newRecibo.GastosAdm = round((GastosAdmTotales - GastosAdmAcmu) / remainingRecibos, 4);

        //Valores de las comisiones
        newRecibo.ComN = round((ComisionPrimaNeta - ComPNetaAcmu) / remainingRecibos, 4);
        /* newRecibo.ComR = round((ComisionRecargos - ComRAcmu) / remainingRecibos, 4); */
        newRecibo.CGastosMaq = round((ComisionGastosMaq - ComGastosMaqAcmu) / remainingRecibos, 4);
        newRecibo.CGastosAdm = round((ComisionGastosAdm - ComGastosAdmAcmu) / remainingRecibos, 4);
        newRecibo.ComD = round((ComisionDerechos - ComDAcmu) / remainingRecibos, 4);
        newRecibo.Especial = round((ComisionEspecial - ComEspAcmu) / remainingRecibos, 4);

      } else {
        //Valores principales
        PAcmu += parseFloat(recibo.PrimaNeta || 0);
        DesAcmu += parseFloat(recibo.Descuento || 0);
        /* RAcmu += parseFloat(recibo.Recargos || 0); */
        DAcmu += parseFloat(recibo.Derechos || 0);
        IVAcmu += parseFloat(recibo.IVA || 0);
        /* AjusteAcmu += parseFloat(recibo.Ajuste || 0); */
        GastosMaqAcmu += parseFloat(recibo.GastosMaq || 0);
        GastosAdmAcmu += parseFloat(recibo.GastosAdm || 0);

        //Valores de las comisiones
        ComPNetaAcmu += parseFloat(recibo.ComN || 0);
        /* ComRAcmu += parseFloat(recibo.ComR || 0); */
        ComDAcmu += parseFloat(recibo.ComD || 0);
        ComEspAcmu += parseFloat(recibo.Especial || 0);
        ComGastosMaqAcmu += parseFloat(recibo.CGastosMaq || 0);
        ComGastosAdmAcmu += parseFloat(recibo.CGastosAdm || 0);
      }

      return newRecibo;
    });

    _recibos.forEach((item, indexRecibo) => {
      if (indexRecibo > index) {

        let subtotal = round((parseFloat(item.PrimaNeta + item.GastosMaq + item.GastosAdm + item.Derechos)) - parseFloat(item.Descuento), 4);

        item.PDescuento = round((item.Descuento / item.PrimaNeta) * 100, 4);
        /* item.PorRecargos = round((item.Recargos / item.PrimaNeta) * 100, 4); */
        item.SubTotal = round((parseFloat(item.PrimaNeta + item.GastosMaq + item.GastosAdm + item.Derechos)) - parseFloat(item.Descuento), 4);
        item.PorIVA = round((item.IVA / subtotal) * 100, 4);
        item.PrimaTotal = round((parseFloat(item.PrimaNeta + item.GastosMaq + item.GastosAdm + item.Derechos)) - parseFloat(item.Descuento) + parseFloat(item.IVA), 4);

        item.PComN = round((item.ComN / item.PrimaNeta) * 100, 4);
        /* item.PComR = round((item.ComR / item.Recargos) * 100, 4); */
        item.PComD = round((item.ComD / item.Derechos) * 100, 4);
        item.PEspecial = round((item.Especial / item.PrimaNeta) * 100, 4);
        item.PCGastosMaq = round((item.CGastosMaq / item.GastosMaq) * 100, 4);
        item.PCGastosAdm = round((item.CGastosAdm / item.GastosAdm) * 100, 4);
      }
    });

    setRecibos(_recibos);
  }

  function NewReloadPrices(field, value) {

    if (typeof value == "string") {
      if (value.includes(',')) {
        value = value.replace(/,/g, '');
      }
    }
    
    // values.PrimaNeta
    // values.Descuento
    // values.PDescuento
    // values.Derechos
    // values.PDerecho
    // values.GastosMaquila
    // values.GastosAdmin
    // values.STotal
    // values.IVA
    // values.PorIVA
    // values.PrimaTotal

    // values.ComNeta
    // values.PComNeta
    // values.ComDer
    // values.PComDer
    // values.CGastosMaquila
    // values.PCGastosMaquila
    // values.PCGastosAdmin
    // values.CGastosAdmin
    // values.Especial
    // values.PEspecial

    // No se utiliza el Ajuste y los Recargos

    /* let _OT = { ...ordenTrabajo.OT };
    _OT[field] = value; */

    let _OT = formikRef.current.values;
    formikRef.current.setFieldValue(field, value);

    if (field == "PrimaNeta") {
      let descuento = parseFloat(value * (_OT.PDescuento || 0) / 100);
      let derechos = parseFloat(value * (_OT.PDerecho || 0) / 100);
      let subtotal = (parseFloat(value) + parseFloat(derechos) + parseFloat(_OT.GastosMaquila || 0) + parseFloat(_OT.GastosAdmin || 0)) - parseFloat(descuento);
      let iva = parseFloat(subtotal * (_OT.PorIVA || 0) / 100);
      let total = parseFloat(subtotal + iva);

      let comN = parseFloat(value * (_OT.PComNeta || 0) / 100);
      let especial = parseFloat(value * (_OT.PEspecial || 0) / 100);

      formikRef.current.setFieldValue("Descuento", descuento || 0);
      formikRef.current.setFieldValue("Derechos", derechos || 0);
      formikRef.current.setFieldValue("IVA", iva || 0);
      formikRef.current.setFieldValue("STotal", subtotal || 0);
      formikRef.current.setFieldValue("PrimaTotal", total || 0);

      formikRef.current.setFieldValue("ComNeta", comN || 0);
      formikRef.current.setFieldValue("Especial", especial || 0);

      /* _OT.Descuento = round(descuento, 4);
      _OT.Derechos = round(derechos, 4);
      _OT.IVA = round(iva, 4);
      _OT.STotal = round(subtotal, 4);
      _OT.PrimaTotal = round(total, 4);

      _OT.ComNeta = comN;
      _OT.Especial = especial; */
    }
    else if (field == "Descuento") {

      let pDescuento = parseFloat(value / (_OT.PrimaNeta || 0) * 100);
      let subtotal = (parseFloat(_OT.PrimaNeta || 0) + parseFloat(_OT.Derechos || 0) + parseFloat(_OT.GastosMaquila || 0) + parseFloat(_OT.GastosAdmin || 0)) - parseFloat(value);
      let total = (parseFloat(subtotal) + parseFloat(_OT.IVA || 0));

      formikRef.current.setFieldValue("PDescuento", pDescuento || 0);
      formikRef.current.setFieldValue("STotal", subtotal || 0);
      formikRef.current.setFieldValue("PrimaTotal", total || 0);

      /* _OT.PDescuento = pDescuento;
      _OT.STotal = subtotal;
      _OT.PrimaTotal = total; */
    }
    else if (field == "PDescuento") {

      let descuento = round(parseFloat((_OT.PrimaNeta || 0) * value / 100), 4);
      let subtotal = round((parseFloat(_OT.PrimaNeta || 0) + parseFloat(_OT.Derechos || 0) + parseFloat(_OT.GastosMaquila || 0) + parseFloat(_OT.GastosAdmin || 0)) - parseFloat((_OT.PrimaNeta || 0) * value / 100), 4);
      let total = round(parseFloat(subtotal + (_OT.IVA || 0)), 4);

      formikRef.current.setFieldValue("Descuento", descuento || 0);
      formikRef.current.setFieldValue("STotal", subtotal || 0);
      formikRef.current.setFieldValue("PrimaTotal", total || 0);

      /* _OT.Descuento = descuento;
      _OT.STotal = subtotal;
      _OT.PrimaTotal = total; */
    }
    else if (field == "GastosMaquila") {

      let subtotal = (parseFloat(_OT.PrimaNeta || 0) + parseFloat(_OT.Derechos || 0) + parseFloat(value) + parseFloat(_OT.GastosAdmin || 0)) - parseFloat(_OT.Descuento || 0);
      let iva = round(parseFloat(subtotal * (_OT.PorIVA || 0) / 100), 4)
      let total = round(parseFloat(subtotal + (subtotal * (_OT.PorIVA || 0) / 100)), 4);

      let cGastosMaq = round(parseFloat(value * (_OT.PCGastosMaquila || 0) / 100), 4);

      formikRef.current.setFieldValue("IVA", iva || 0);
      formikRef.current.setFieldValue("STotal", subtotal || 0);
      formikRef.current.setFieldValue("PrimaTotal", total || 0);

      formikRef.current.setFieldValue("CGastosMaquila", cGastosMaq || 0);

      /* _OT.STotal = subtotal;
      _OT.IVA = iva;
      _OT.PrimaTotal = total;

      _OT.CGastosMaquila = cGastosMaq; */
    }
    else if (field == "GastosAdmin") {

      let subtotal = (parseFloat(_OT.PrimaNeta || 0) + parseFloat(_OT.GastosMaquila || 0) + parseFloat(value) + parseFloat(_OT.Derechos || 0)) - parseFloat(_OT.Descuento || 0);
      let iva = round(parseFloat(subtotal * (_OT.PorIVA || 0) / 100), 4)
      let total = round(parseFloat(subtotal + iva), 4);

      let cGastosAdm = round(parseFloat(value * (_OT.PCGastosAdmin || 0) / 100), 4);

      formikRef.current.setFieldValue("IVA", iva || 0);
      formikRef.current.setFieldValue("STotal", subtotal || 0);
      formikRef.current.setFieldValue("PrimaTotal", total || 0);

      formikRef.current.setFieldValue("CGastosAdmin", cGastosAdm || 0);

      /* _OT.STotal = subtotal;
      _OT.IVA = iva;
      _OT.PrimaTotal = total;

      _OT.CGastosAdmin = cGastosAdm; */
    }
    else if (field == "IVA") {

      let piva = round(parseFloat(value / (_OT.STotal || 0) * 100), 4);
      let total = round(parseFloat(_OT.STotal || 0) + parseFloat(value), 4);

      formikRef.current.setFieldValue("PorIVA", piva || 0);
      formikRef.current.setFieldValue("PrimaTotal", total || 0);

      /* _OT.PorIVA = piva;
      _OT.PrimaTotal = total; */
    }
    else if (field == "PorIVA") {

      let iva = round(parseFloat(value / 100 * (_OT.STotal || 0)), 4);
      let total = round(parseFloat((_OT.STotal || 0) + (_OT.STotal || 0) * value / 100), 4);

      formikRef.current.setFieldValue("IVA", iva || 0);
      formikRef.current.setFieldValue("PrimaTotal", total || 0);

      /* _OT.IVA = iva;
      _OT.PrimaTotal = total; */
    }
    else if (field == "Derechos") {

      let pDerecho = round(parseFloat(value / (_OT.PrimaNeta || 0) * 100), 4);
      let subtotal = (parseFloat(_OT.PrimaNeta || 0) + parseFloat(value) + parseFloat(_OT.GastosMaquila || 0) + parseFloat(_OT.GastosAdmin || 0)) - parseFloat(_OT.Descuento || 0);
      let iva = round(parseFloat(subtotal * (_OT.PorIVA || 0) / 100), 4)
      let total = round(parseFloat(subtotal + iva), 4);

      let comD = round(parseFloat(value * (_OT.PComDer || 0) / 100), 4);

      formikRef.current.setFieldValue("PDerecho", pDerecho || 0);
      formikRef.current.setFieldValue("STotal", subtotal || 0);
      formikRef.current.setFieldValue("IVA", iva || 0);
      formikRef.current.setFieldValue("PrimaTotal", total || 0);

      formikRef.current.setFieldValue("ComDer", comD || 0);

      /* _OT.STotal = subtotal;
      _OT.IVA = iva;
      _OT.PrimaTotal = total;

      _OT.ComDer = comD; */
    }
    else if (field == "PDerecho") {

      let derechos = round(parseFloat((_OT.PrimaNeta || 0) * value / 100), 4);
      let subtotal = round((parseFloat(_OT.PrimaNeta || 0) + parseFloat(derechos) + parseFloat(_OT.GastosMaquila || 0) + parseFloat(_OT.GastosAdmin || 0)) - parseFloat(_OT.Descuento || 0), 4);
      let iva = round(parseFloat(subtotal * (_OT.PorIVA || 0) / 100), 4);
      let total = round(parseFloat(subtotal + iva), 4);

      let comD = round(parseFloat(derechos * (_OT.PComDer || 0) / 100), 4);

      formikRef.current.setFieldValue("Derechos", derechos || 0);
      formikRef.current.setFieldValue("STotal", subtotal || 0);
      formikRef.current.setFieldValue("IVA", iva || 0);
      formikRef.current.setFieldValue("PrimaTotal", total || 0);

      formikRef.current.setFieldValue("ComDer", comD || 0);

      /* _OT.Derechos = derechos;
      _OT.STotal = subtotal;
      _OT.IVA = iva;
      _OT.PrimaTotal = total;

      _OT.ComDer = comD; */
    }
    else if (field == "PrimaTotal") {

      let subtotal = round((parseFloat(value)) / (1 + ((_OT.PorIVA || 0) / 100)), 4);
      let iva = round(parseFloat(subtotal * (_OT.PorIVA || 0) / 100), 4);
      let primaneta = round(parseFloat((subtotal - (_OT.Derechos || 0) - parseFloat(_OT.GastosMaquila || 0) - parseFloat(_OT.GastosAdmin || 0)) / (1 - ((_OT.PDescuento || 0) / 100))), 4);
      let descuento = round(parseFloat(primaneta * (_OT.PDescuento || 0) / 100), 4);
      let derechos = round(parseFloat(primaneta * (_OT.PDerecho || 0) / 100), 4);

      let comN = round(parseFloat(primaneta * (_OT.PComNeta || 0) / 100), 4);
      let comD = round(parseFloat(derechos * (_OT.PComDer || 0) / 100), 4);
      let especial = round(parseFloat(primaneta * (_OT.PEspecial || 0) / 100), 4);

      formikRef.current.setFieldValue("STotal", subtotal || 0);
      formikRef.current.setFieldValue("IVA", iva || 0);
      formikRef.current.setFieldValue("PrimaNeta", primaneta || 0);
      formikRef.current.setFieldValue("Descuento", descuento || 0);
      formikRef.current.setFieldValue("Derechos", derechos || 0);

      formikRef.current.setFieldValue("ComNeta", comN || 0);
      formikRef.current.setFieldValue("ComDer", comD || 0);
      formikRef.current.setFieldValue("Especial", especial || 0);

      /* _OT.STotal = subtotal;
      _OT.IVA = iva;
      _OT.PrimaNeta = primaneta;
      _OT.Descuento = descuento;
      _OT.Derechos = derechos;

      _OT.ComNeta = comN;
      _OT.ComDer = comD;
      _OT.Especial = especial; */
    }

    else if (field == "ComNeta") {
      let pComN = round(parseFloat(value / (_OT.PrimaNeta || 0) * 100), 4);
      formikRef.current.setFieldValue("PComNeta", pComN || 0);

      /* _OT.PComNeta = pComN; */
    }
    else if (field == "PComNeta") {
      let comN = round(parseFloat((_OT.PrimaNeta || 0) * value / 100), 4);
      formikRef.current.setFieldValue("ComNeta", comN || 0);

      /* _OT.ComNeta = comN; */
    }
    else if (field == "ComDer") {
      let pComD = round(parseFloat(value / (_OT.Derechos || 0) * 100), 4);
      formikRef.current.setFieldValue("PComDer", pComD || 0);

      /* _OT.PComDer = pComD; */
    }
    else if (field == "PComDer") {
      let comD = round(parseFloat((_OT.Derechos || 0) * value / 100), 4);
      formikRef.current.setFieldValue("ComDer", comD || 0);

      /* _OT.ComDer = comD; */
    }
    else if (field == "CGastosMaquila") {
      let pCGastosMaquila = round(parseFloat(value / (_OT.GastosMaquila || 0) * 100), 4);
      formikRef.current.setFieldValue("PCGastosMaquila", pCGastosMaquila || 0);

      /* _OT.PCGastosMaquila = pCGastosMaquila; */
    }
    else if (field == "PCGastosMaquila") {
      let cGastosMaquila = round(parseFloat((_OT.GastosMaquila || 0) * value / 100), 4);
      formikRef.current.setFieldValue("CGastosMaquila", cGastosMaquila || 0);

      /* _OT.CGastosMaquila = cGastosMaquila; */
    }
    else if (field == "CGastosAdmin") {
      let pCGastosAdmin = round(parseFloat(value / (_OT.GastosAdmin || 0) * 100), 4);
      formikRef.current.setFieldValue("PCGastosAdmin", pCGastosAdmin || 0);

      /* _OT.PCGastosAdmin = pCGastosAdmin; */
    }
    else if (field == "PCGastosAdmin") {
      let cGastosAdmin = round(parseFloat((_OT.GastosAdmin || 0) * value / 100), 4);
      formikRef.current.setFieldValue("CGastosAdmin", cGastosAdmin || 0);

      /* _OT.CGastosAdmin = cGastosAdmin; */
    }
    else if (field == "Especial") {
      let pEspecial = round(parseFloat(value / (_OT.PrimaNeta || 0) * 100), 4);
      formikRef.current.setFieldValue("PEspecial", pEspecial || 0);

      /* _OT.PEspecial = pEspecial; */
    }
    else if (field == "PEspecial") {
      let especial = round(parseFloat(_OT.PrimaNeta * value / 100), 4);
      formikRef.current.setFieldValue("Especial", especial || 0);

      /* _OT.Especial = especial; */
    }

    /* SetordenTrabajo({
      ...ordenTrabajo,
      OT: _OT
    }); */
  }

  return (
    <Formik
      innerRef={formikRef}
      initialValues={ordenTrabajo.OT}
      enableReinitialize="true"
      validationSchema={validationSchemaFianza}
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
        isSubmitting
      }) => (
        <form onKeyDown={LockEnter} onSubmit={handleSubmit} onChange={(e) => HaveChange(e)} className="form" autoComplete="off">
          <div className='row'>
            <div className='col-md-2'>
              <div className="form-group">
                <label htmlFor="txMotivo">Buscar</label>
                <ModalDocumentos UrlServicio={UrlServicio} Modulo={'F'} UrlPagina={UrlPagina} OnSelect={(e) => { }} Data={ordenTrabajo.OT.Documento ? ordenTrabajo.OT.Documento : ''} />
              </div>
            </div>
            <div className='col-md-10 text-right'>
              <AllowElement PermisoAccion="Nuevo"><a className='btn btn-primary btn-s' data-toggle="tooltip" data-placement="bottom" title="Nuevo" onClick={() => NewOrden()}><i className="fa fa-plus" aria-hidden="true"></i></a></AllowElement>
              {isEmptyObject(errors) != true && (
                <AllowElement PermisoAccion="Editar"><button className="btn btn-primary btn-s" type="submit" data-toggle="tooltip" data-placement="bottom" title="Guardar"><i className="fa fa-floppy-o" aria-hidden="true"></i></button></AllowElement>
              )}
              {isEmptyObject(errors) != false && (
                <AllowElement PermisoAccion="Editar"><a className="btn btn-primary btn-s" type="submit" data-toggle="tooltip" data-placement="bottom" title="Guardar" onClick={() => CheckErrores()}><i className="fa fa-floppy-o" aria-hidden="true"></i></a></AllowElement>
              )}
              <AllowElement PermisoAccion="Honorarios"><a className='btn btn-primary btn-s' disabled={values.IsSavedFianza == null ? true : false} onClick={() => { ChildrenkRef.current.Reload(), $('#ModalComH').modal('show') }} data-toggle="tooltip" data-placement="bottom" title="Honorarios"><i className="fa fa-money" aria-hidden="true"></i></a></AllowElement>
              <AllowElement PermisoAccion="Recalcular"><a className='btn btn-primary btn-s' disabled={values.IsSavedFianza == null ? true : false} onClick={() => { RealoadHonorarios() }} data-toggle="tooltip" data-placement="bottom" title="Recalcular Honorarios"><i className='fa fa-refresh' aria-hidden="true"></i></a></AllowElement>
              <AllowElement PermisoAccion="Renovar"> <a className='btn btn-primary btn-s' disabled={values.IsSavedFianza == null ? true : false} onClick={() => AddRenovacion()} data-toggle="tooltip" data-placement="bottom" title="Renovar"><i className="fa fa-retweet" aria-hidden="true"></i></a></AllowElement>
              <AllowElement PermisoAccion="Bitacora"> <a className="btn btn-primary btn-s" disabled={Id == undefined ? true : false} onClick={() => OpenAction("BITACORA")} data-toggle="tooltip" data-placement="bottom" title="Bitacora"><i className="fa fa-file-text-o" aria-hidden="true"></i></a></AllowElement>
              <AllowElement PermisoAccion="Carga-documentos"><a className="btn btn-primary btn-s" disabled={Id == undefined ? true : false} onClick={() => { ModalFileUploadRef.current.Open() }} data-toggle="tooltip" data-placement="bottom" title="Documentos" ><i className="fa fa-folder-open" aria-hidden="true"></i></a></AllowElement>
              {/* <AllowElement PermisoAccion="Carga-documentos"> <a className="btn btn-primary btn-s" disabled={Id == undefined ? true : false} onClick={() => OpenAction("DOCUMENT")} data-toggle="tooltip" data-placement="bottom" title="Documentos" ><i className="fa fa-folder-open" aria-hidden="true"></i></a></AllowElement> */}
              {/* <AllowElement PermisoAccion="Endosos"> <a className="btn btn-primary btn-s" disabled={values.IsSavedFianza == null ? true : false} onClick={() => { $('#ModalEndoso').modal('show') }} data-toggle="tooltip" data-placement="bottom" title="Endosos" ><i className="fa fa-archive" aria-hidden="true"></i></a></AllowElement> */}
              <AllowElement PermisoAccion="Endosos"><a className="btn btn-primary btn-s" disabled={values.IsSavedFianza == null ? true : false} onClick={() => { ModalEndosos.current.InitialLoad(true) }} data-toggle="tooltip" data-placement="bottom" title="Endosos" ><i className="fa fa-archive" aria-hidden="true"></i></a></AllowElement>
              <AllowElement PermisoAccion="Copiar"> <a className="btn btn-primary btn-s" disabled={Id == undefined ? true : false} onClick={() => { CopyDocumento() }} data-toggle="tooltip" data-placement="bottom" title="Copiar Documento" ><i className="fa fa-clone" aria-hidden="true"></i></a></AllowElement>
              <AllowElement PermisoAccion="Cancelar"><a className="btn btn-primary btn-s" disabled={values.IsSavedFianza == null ? true : false} onClick={() => { $('#ModalCancelar').modal('show') }} data-toggle="tooltip" data-placement="bottom" title="Cancelar Documento" ><i className="fa fa-times-circle-o" aria-hidden="true"></i></a></AllowElement>
              <AllowElement PermisoAccion="Cancelar"><a className="btn btn-primary btn-s" disabled={values.IsSavedFianza == null ? true : false} onClick={() => { Rehabilitar() }} data-toggle="tooltip" data-placement="bottom" title="Rehabilitar Documento" ><i className="fa fa-check-circle" aria-hidden="true"></i></a></AllowElement>
              <AllowElement PermisoAccion="Eliminar"> <a className='btn btn-primary btn-s' disabled={Id == undefined ? true : false} onClick={() => DeleteDocument()} data-toggle="tooltip" data-placement="bottom" title="Eliminar"><i className="fa fa-trash" aria-hidden="true"></i></a></AllowElement>
              <a className="btn btn-primary btn-s" onClick={() => { window.location = `${UrlPagina}servicioSistema/Fianza` }} data-toggle="tooltip" data-placement="bottom" title="Regresar" ><i className="fa fa-reply" aria-hidden="true"></i></a>
            </div>
          </div>
          <div className='row'>
            <div className='col-md-12'>
              <div className='row'>
                <div className='col-md-2'>
                  <div className="form-group">
                    <label htmlFor="txMotivo">Tipo Doc</label>
                    <Select
                      isDisabled={values.IsSavedFianza == 1 && values.TipoDocto == 1 ? true : false}
                      placeholder="Selecione"
                      id="TipoDocto"
                      name="TipoDocto"
                      styles={colourStyles}
                      onChange={v => { setFieldValue("TipoDocto", v.value) }}
                      onBlur={() => { handleBlur, IsDisabledPrimas() }}
                      value={displayitem(values.TipoDocto, state.InitialData.TipoDocumento)}
                      options={mapitems(state.InitialData.TipoDocumento ? state.InitialData.TipoDocumento : [], '')}
                      noOptionsMessage={() => "Sin opciones"}
                    />
                    <span className="help-block">{errors.TipoDocto}</span>
                  </div>
                </div>
                <div className='col-md-2'>
                  <div className="form-group">
                    <label htmlFor="txMotivo">Solicitud</label>
                    <input
                      className="form-control input-sm"
                      type="text"
                      name="Solicitud"
                      id="Solicitud"
                      onChange={handleChange}
                      disabled={true}
                      value={values.Solicitud ? values.Solicitud : ''}
                    />
                  </div>
                </div>
                <div className='col-md-2'>
                  <div className="form-group">
                    <label htmlFor="txMotivo">No. Fianza</label>
                    <input
                      className="form-control input-sm"
                      type="text"
                      name="Documento"
                      id="Documento"
                      onBlur={() => CheckDocument()}
                      onChange={(e) => { setFieldValue('Documento', UpperCaseField(e.target.value)) }}
                      onFocus={FocusInput}
                      //onChange={handleChange}
                      value={values.Documento ? values.Documento : ''}
                    />
                    <span className="help-block">{errors.Documento}</span>
                  </div>
                </div>
                <div className='col-md-2'>
                  <div className="form-group">
                    <label htmlFor="txMotivo">Anterior</label>
                    <input
                      className="form-control input-sm"
                      type="text"
                      name="DAnterior"
                      id="DAnterior"
                      //onChange={handleChange}
                      onChange={(e) => { setFieldValue('DAnterior', UpperCaseField(e.target.value)) }}
                      onFocus={FocusInput}
                      value={values.DAnterior ? values.DAnterior : ''}
                    />
                  </div>
                </div>
                <div className='col-md-2'>
                  <div className="form-group">
                    <label htmlFor="txMotivo">Posterior</label>
                    <input
                      className="form-control input-sm"
                      type="text"
                      name="DPosterior"
                      id="DPosterior"
                      //onChange={handleChange}
                      onChange={(e) => { setFieldValue('DPosterior', UpperCaseField(e.target.value)) }}
                      onFocus={FocusInput}
                      value={values.DPosterior ? values.DPosterior : ''}
                    />
                  </div>
                </div>
              </div>
            </div>
          </div>
          <div className='row'>
            <div className='col-md-9'>
              <div className='row mt-3'>
                <div className='col-md-12'>
                  {/*  tabs */}
                  <ul className="nav nav-tabs nav-justified" id="general" role="tablist">
                    <li className="nav-item navr">
                      <a className="nav-link active" id="home-tab" data-toggle="tab" href="#datos-generales" role="tab" aria-controls="datos-generales" aria-selected="true">Datos Generales</a>
                    </li>
                    <>
                      <li className="nav-item navr">
                        <a className="nav-link" id="detalle-fianza-tab" data-toggle="tab" href="#detalle-fianza" role="tab" aria-controls="detalle-fianza" aria-selected="false">Detalle</a>
                      </li>
                    </>

                  </ul>
                </div>
                <div className='col-md-12'>
                  <div className="tab-content" id="generalTabContent">
                    {/*  tab 1 */}
                    <div className="tab-pane fade active show in" id="datos-generales" role="tabpanel" aria-labelledby="datos-generales-tab">
                      <div className='row'>
                        <div className='col-md-8'>
                          <div className='row'>
                            <div className='col-md-6'>
                              <div className='row'>
                                <div className='col-md-12'>
                                  <h6>FIADO</h6>
                                  <hr />
                                </div>
                                <div className='col-md-12'>
                                  <div className="form-group">
                                    <label htmlFor="txMotivo">Fiado</label>
                                    <ModalOpc UrlServicio={UrlServicio} Tipo={1} OnSelect={(e) => {
                                      setFieldValue("IDCli", e.Id);
                                      getDirecciones(e);
                                    }} Data={ordenTrabajo.Usuario.Info.Nombre ? ordenTrabajo.Usuario.Info.Nombre : ''} />
                                    <span className="help-block">{errors.IDCli}</span>
                                  </div>
                                </div>
                                <div className='col-md-12'>
                                  <div className="form-group">
                                    <label htmlFor="txMotivo">Direccion</label>
                                    <Select
                                      placeholder="Selecione"
                                      id="IDDir"
                                      name="IDDir"
                                      styles={colourStyles}
                                      onChange={v => { setFieldValue("IDDir", v.value) }}
                                      onBlur={handleBlur}
                                      value={displayitem(values.IDDir, ordenTrabajo.Usuario.Direcciones)}
                                      options={mapitems(ordenTrabajo.Usuario.Direcciones ? ordenTrabajo.Usuario.Direcciones : [], '')}
                                      noOptionsMessage={() => "Sin opciones"}
                                      title={"Dirección"}

                                    />
                                  </div>
                                </div>
                                <div className='col-md-12'>
                                  <h6>VIGENCIA</h6>
                                  <hr />
                                </div>
                                <div className='col-md-6'>
                                  <div className="form-group">
                                    <label htmlFor="txMotivo">Desde</label>
                                    <input
                                      className="form-control input-sm"
                                      type="date"
                                      name="FDesde"
                                      id="FDesde"
                                      onBlur={() => {
                                        setFieldValue('FHasta', moment(values.FDesde).add(1, 'years').subtract(1, 'days'));
                                        setFieldValue('IObligacion', values.FDesde);
                                        setFieldValue('FObligacion', moment(values.FDesde).add(1, 'years').subtract(1, 'days'));
                                        var a = moment(values.FDesde);
                                        var b = moment(moment(values.FDesde).add(1, 'years').subtract(1, 'days'));
                                        setFieldValue('DObligacion', b.diff(a, 'days'));
                                      }}
                                      onChange={handleChange}
                                      value={values.FDesde ? moment(values.FDesde).format("YYYY-MM-DD") : ''}
                                      data-toggle="tooltip" data-placement="bottom" title="Desde"
                                    />
                                    <span className="help-block">{errors.FDesde}</span>
                                  </div>
                                </div>
                                <div className='col-md-6'>
                                  <div className="form-group">
                                    <label htmlFor="txMotivo">Hasta</label>
                                    <input
                                      className="form-control input-sm"
                                      type="date"
                                      name="FHasta"
                                      id="FHasta"
                                      onChange={handleChange}
                                      value={values.FHasta ? moment(values.FHasta).format("YYYY-MM-DD") : ''}
                                    />
                                    <span className="help-block">{errors.FHasta}</span>
                                  </div>
                                </div>
                                <div className='col-md-6'>
                                  <div className="form-group">
                                    <label htmlFor="txMotivo">{isMobile ? 'FAntiguedad' : 'Fecha Antiguedad'}</label>
                                    <input
                                      className="form-control input-sm"
                                      type="date"
                                      name="FAntiguedad"
                                      id="FAntiguedad"
                                      onChange={handleChange}
                                      value={values.FAntiguedad ? moment(values.FAntiguedad).format("YYYY-MM-DD") : ''}
                                    />
                                  </div>
                                </div>
                                <div className='col-md-6'>
                                  <div className="form-group">
                                    <label htmlFor="txMotivo">Renovación</label>
                                    <input
                                      //disabled={true}
                                      className="form-control input-sm"
                                      type="number"
                                      name="NumRenovacion"
                                      id="NumRenovacion"
                                      onChange={handleChange}
                                      value={values.NumRenovacion ? values.NumRenovacion : '0'}
                                    />
                                  </div>
                                </div>
                              </div>
                            </div>
                            <div className='col-md-6'>
                              <div className='row'>
                                <div className='col-md-12'>
                                  <h6>COMPAÑIA</h6>
                                  <hr />
                                </div>
                                <div className='col-md-12'>
                                  <div className="form-group">
                                    <label htmlFor="txMotivo">Agente</label>
                                    <Select
                                      placeholder="Selecione"
                                      id="IDAgente"
                                      name="IDAgente"
                                      //styles={errors.aseguradora_id ? colourStyles2 : colourStyles}
                                      styles={colourStyles}
                                      onChange={v => {
                                        setFieldValue("IDAgente", v.value),
                                          setFieldValue("IDMon", ''),
                                          setFieldValue("TipoCambio", ''),
                                          setFieldValue("IDFPago", ''),
                                          setFieldValue("FPago", ''),
                                          setFieldValue("NPagos", '')
                                      }}
                                      onBlur={() => { handleBlur, InitialData(), GetAllConfig() }}
                                      value={displayitem(values.IDAgente, state.InitialData.Agentes)}
                                      options={mapitems(state.InitialData.Agentes ? state.InitialData.Agentes : [], '')}
                                      noOptionsMessage={() => "Sin opciones"}
                                    />
                                    <span className="help-block">{errors.IDAgente}</span>
                                  </div>
                                </div>
                                <div className='col-md-12'>
                                  <div className="form-group">
                                    <label htmlFor="txMotivo">Ejecutivo Compañia</label>
                                    <Select
                                      placeholder="Selecione"
                                      id="IDEjecutCompania"
                                      name="IDEjecutCompania"
                                      styles={colourStyles}
                                      onChange={v => { setFieldValue("IDEjecutCompania", v.value) }}
                                      onBlur={handleBlur}
                                      value={displayitem(values.IDEjecutCompania, state.InitialData.Ejecutivos)}
                                      options={mapitems(state.InitialData.Ejecutivos ? state.InitialData.Ejecutivos : [], '')}
                                      noOptionsMessage={() => "Sin opciones"}
                                    />
                                    <span className="help-block">{errors.IDEjecutCompania}</span>
                                  </div>
                                </div>
                                <div className='col-md-12'>
                                  <h6>MONEDA Y FORMA DE PAGO</h6>
                                  <hr />
                                </div>
                                <div className='col-md-6'>
                                  <div className="form-group">
                                    <label htmlFor="txMotivo">Moneda</label>
                                    <Select
                                      placeholder="Selecione"
                                      id="Moneda"
                                      name="Moneda"
                                      styles={colourStyles}
                                      onChange={v => {
                                        setFieldValue("IDMon", v.value),
                                          setFieldValue('TipoCambio', displayOther(v.value, state.InitialData.Monedas).TipoCambio ? displayOther(v.value, state.InitialData.Monedas).TipoCambio : '')
                                      }}
                                      onBlur={() => GetAllConfig()}
                                      value={displayitem(values.IDMon, state.InitialData.Monedas)}
                                      options={mapitems(state.InitialData.Monedas ? state.InitialData.Monedas : [], '')}
                                      noOptionsMessage={() => "Sin opciones"}
                                    />
                                    <span className="help-block">{errors.IDMon}</span>
                                  </div>
                                </div>
                                <div className='col-md-6'>
                                  <div className="form-group">
                                    <label htmlFor="txMotivo">T Cambio</label>
                                    <input
                                      className="form-control input-sm numeric"
                                      type="text"
                                      name="TipoCambio"
                                      id="TipoCambio"
                                      onChange={handleChange}
                                      value={values.TipoCambio ? values.TipoCambio : '0'}
                                    />
                                  </div>
                                </div>
                                <div className='col-md-6'>
                                  <div className="form-group">
                                    <label htmlFor="txMotivo">{isMobile ? 'F pago' : 'Forma pago'}</label>
                                    <Select
                                      placeholder="Selecione"
                                      id="IDFPago"
                                      name="IDFPago"
                                      styles={colourStyles}
                                      onChange={v => {
                                        var Find = state.InitialData.FormaPago.find(x => x.Id === v.value)
                                        setFieldValue("IDFPago", v.value),
                                          setFieldValue("FPago", v.label),
                                          setFieldValue('NPagos', Find.NPagos)
                                        //setFieldValue('PorRecargos', Find.PRecargos)
                                      }}
                                      onBlur={() => GetAllConfig()}
                                      value={displayitem(values.IDFPago, state.InitialData.FormaPago)}
                                      options={mapitems(state.InitialData.FormaPago ? state.InitialData.FormaPago : [], '')}
                                      noOptionsMessage={() => "Sin opciones"}
                                    />
                                  </div>
                                  <span className="help-block">{errors.IDFPago}</span>
                                </div>
                                <div className='col-md-6'>
                                  <div className="form-group">
                                    <label htmlFor="txMotivo">N Pagos</label><br />
                                    <p>{values.NPagos ? values.NPagos : ''}</p>
                                  </div>
                                </div>
                              </div>
                            </div>
                            <div className='col-md-12'>
                              <div className='row'>
                                <div className='col-md-12'>
                                  <h6>REFERENCIAS</h6>
                                  <hr />
                                </div>
                                <div className='col-md-12'>
                                  <div className="form-group">
                                    <label htmlFor="txMotivo">Concepto</label>
                                    <input
                                      type="text"
                                      name="Concepto"
                                      id="Concepto"
                                      //onChange={handleChange}
                                      onChange={(e) => { setFieldValue('Concepto', UpperCaseField(e.target.value)) }}
                                      onFocus={FocusInput}
                                      value={values.Concepto ? values.Concepto : ''}
                                      className="form-control input-sm"
                                      autoComplete="off"
                                    />
                                  </div>
                                </div>
                                <div className='col-md-6'>
                                  <div className="form-group">
                                    <label htmlFor="txMotivo">Referencia 1</label>
                                    <input
                                      type="text"
                                      name="Referencia1"
                                      id="Referencia1"
                                      //onChange={handleChange}
                                      onChange={(e) => { setFieldValue('Referencia1', UpperCaseField(e.target.value)) }}
                                      onFocus={FocusInput}
                                      value={values.Referencia1 ? values.Referencia1 : ''}
                                      className="form-control input-sm"
                                      autoComplete="off"
                                    />
                                  </div>
                                </div>
                                <div className='col-md-6'>
                                  <div className="form-group">
                                    <label htmlFor="txMotivo">Referencia 2</label>
                                    <input
                                      type="text"
                                      name="Referencia2"
                                      id="Referencia2"
                                      onChange={(e) => { setFieldValue('Referencia2', UpperCaseField(e.target.value)) }}
                                      onFocus={FocusInput}
                                      //onChange={handleChange}
                                      value={values.Referencia2 ? values.Referencia2 : ''}
                                      className="form-control input-sm"
                                      autoComplete="off"
                                    />
                                  </div>

                                </div>
                                <div className='col-md-6'>
                                  <div className="form-group">
                                    <label htmlFor="txMotivo">Referencia 3</label>
                                    <input
                                      type="text"
                                      name="Referencia3"
                                      id="Referencia3"
                                      //onChange={handleChange}
                                      onChange={(e) => { setFieldValue('Referencia3', UpperCaseField(e.target.value)) }}
                                      onFocus={FocusInput}
                                      value={values.Referencia3 ? values.Referencia3 : ''}
                                      className="form-control input-sm"
                                      autoComplete="off"
                                    />
                                  </div>

                                </div>
                                <div className='col-md-6'>
                                  <div className="form-group">
                                    <label htmlFor="txMotivo">Referencia 4</label>
                                    <input
                                      className="form-control input-sm"
                                      type="text"
                                      name="Referencia4"
                                      id="Referencia4"
                                      onChange={(e) => { setFieldValue('Referencia4', UpperCaseField(e.target.value)) }}
                                      onFocus={FocusInput}
                                      //onChange={handleChange}
                                      value={values.Referencia4 ? values.Referencia4 : ''}
                                    />
                                  </div>

                                </div>
                                <div className='col-md-8'>
                                  <div className="form-group">
                                    <label htmlFor="txMotivo">Beneficiario preferente</label>
                                    <input
                                      onFocus={FocusInput}
                                      className="form-control input-sm"
                                      type="text"
                                      name="BeneficiarioPreferente"
                                      id="BeneficiarioPreferente"
                                      value={values.BeneficiarioPreferente ? values.BeneficiarioPreferente : ''}
                                      onChange={(e) => setFieldValue('BeneficiarioPreferente', UpperCaseField(e.target.value))}
                                    />

                                  </div>

                                </div>
                              </div>
                            </div>
                          </div>
                        </div>
                        <div className='col-md-4'>
                          <div className='row'>
                            <div className='col-md-12'>
                              <h6>CONTROL</h6>
                              <hr />
                            </div>
                            <div className='col-md-12'>
                              <div className="form-group">
                                <label htmlFor="txMotivo">Ramo</label>
                                <Select
                                  placeholder="Selecione"
                                  id="IDSRamo"
                                  name="IDSRamo"
                                  styles={colourStyles}
                                  onChange={v => {
                                    setFieldValue("IDSRamo", v.value),
                                      setFieldValue("IDSSRamo", '')
                                  }}
                                  onBlur={handleBlur}
                                  value={displayitem(values.IDSRamo, state.InitialData.Ramos)}
                                  options={mapitems(state.InitialData.Ramos ? state.InitialData.Ramos : [], '')}
                                  noOptionsMessage={() => "Sin opciones"}
                                />
                                <span className="help-block">{errors.IDSRamo}</span>
                              </div>
                            </div>
                            <div className='col-md-12'>
                              <div className="form-group">
                                <label htmlFor="txMotivo">SubRamo</label>
                                <Select
                                  placeholder="Selecione"
                                  id="IDSSRamo"
                                  name="IDSSRamo"
                                  styles={colourStyles}
                                  onChange={v => { setFieldValue("IDSSRamo", v.value) }}
                                  onBlur={() => GetAllConfig()}
                                  value={displayitem(values.IDSSRamo, state.InitialData.SubRamo)}
                                  options={mapitemsHijos(state.InitialData.SubRamo ? state.InitialData.SubRamo : [], values.IDSRamo)}
                                  noOptionsMessage={() => "Sin opciones"}
                                />
                                <span className="help-block">{errors.IDSSRamo}</span>
                              </div>
                            </div>
                          </div>
                          <div className='row'>
                            <div className='col-md-12'>
                              <div className="form-group">
                                <label htmlFor="txMotivo">Vendedor</label>
                                <Select
                                  placeholder="Selecione"
                                  id="IDVend"
                                  name="IDVend"
                                  styles={colourStyles}
                                  onChange={v => { //setFieldValue("IDVend", v.value) 
                                    var FinVen = state.InitialData.Vendedores.find(x => x.Id === v.value)
                                    var FindDespacho = state.InitialData.Despachos.find(x => x.Id === FinVen.Id_despacho)
                                    var FindGerencia = state.InitialData.Gerencias.find(x => x.Id === FinVen.Id_gerencia)
                                    setFieldValue("IDVend", v.value)
                                    setFieldValue("IDGerencia", FindGerencia != null ? FindGerencia.Id : null);
                                    setFieldValue("IDDespacho", FindDespacho != null ? FindDespacho.Id : null);
                                  }}
                                  onBlur={handleBlur}
                                  value={displayitem(values.IDVend, state.InitialData.Vendedores)}
                                  options={mapitems(state.InitialData.Vendedores ? state.InitialData.Vendedores : [], '')}
                                  noOptionsMessage={() => "Sin opciones"}
                                />
                                <span className="help-block">{errors.IDVend}</span>
                              </div>
                            </div>
                          </div>
                          <div className='row'>
                            <div className='col-md-12'>
                              <div className="form-group">
                                <label htmlFor="txMotivo">Ejecutivo</label>
                                <Select
                                  placeholder="Selecione"
                                  id="IDEjecut"
                                  name="IDEjecut"
                                  styles={colourStyles}
                                  onChange={v => { setFieldValue("IDEjecut", v.value) }}
                                  onBlur={handleBlur}
                                  value={displayitem(values.IDEjecut, state.InitialData.Ejecutivos)}
                                  options={mapitems(state.InitialData.Ejecutivos ? state.InitialData.Ejecutivos : [], '')}
                                  noOptionsMessage={() => "Sin opciones"}
                                />
                              </div>
                            </div>
                          </div>
                          <div className='row'>
                            <div className='col-md-12'>
                              <div className="form-group">
                                <label htmlFor="txMotivo">Grupo</label>
                                <Select
                                  placeholder="Selecione"
                                  id="IDGrupo"
                                  name="IDGrupo"
                                  styles={colourStyles}
                                  onChange={v => { setFieldValue("IDGrupo", v.value), setFieldValue("IDSubGrupo", '') }}
                                  onBlur={handleBlur}
                                  value={displayitem(values.IDGrupo, state.InitialData.Grupo)}
                                  options={mapitems(state.InitialData.Grupo ? state.InitialData.Grupo : [], '')}
                                  noOptionsMessage={() => "Sin opciones"}
                                />
                                <span className="help-block">{errors.IDGrupo}</span>
                              </div>
                            </div>
                          </div>
                          <div className='row'>
                            <div className='col-md-12'>
                              <div className="form-group">
                                <label htmlFor="txMotivo">SubGrupo</label>
                                <Select
                                  placeholder="Selecione"
                                  id="IDSubGrupo"
                                  name="IDSubGrupo"
                                  styles={colourStyles}
                                  onChange={v => { setFieldValue("IDSubGrupo", v.value) }}
                                  onBlur={handleBlur}
                                  value={displayitem(values.IDSubGrupo, state.InitialData.SubGrupo)}
                                  options={mapitemsHijos(state.InitialData.SubGrupo ? state.InitialData.SubGrupo : [], values.IDGrupo)}
                                  noOptionsMessage={() => "Sin opciones"}
                                />
                                <span className="help-block">{errors.IDSubGrupo}</span>
                              </div>
                            </div>
                          </div>
                          <div className='row'>
                            <div className='col-md-12'>
                              <div className="form-group">
                                <label htmlFor="txMotivo">Sub SubGrupo</label>
                                <input
                                  className="form-control input-sm"
                                  type="text"
                                  name="IDSubSubGrupo"
                                  id="IDSubSubGrupo"
                                  onChange={(e) => { setFieldValue('IDSubSubGrupo', UpperCaseField(e.target.value)) }}
                                  onFocus={FocusInput}
                                  //onChange={handleChange}
                                  value={values.IDSubSubGrupo ? values.IDSubSubGrupo : ''}
                                />
                              </div>
                            </div>
                          </div>
                          <div className='row'>
                            <div className='col-md-12'>
                              <div className="form-group">
                                <label htmlFor="txMotivo">Ejecutivo cobranza</label>
                                <Select
                                  placeholder="Selecione"
                                  id="IDEjecutCobranza"
                                  name="IDEjecutCobranza"
                                  styles={colourStyles}
                                  onChange={v => { setFieldValue("IDEjecutCobranza", v.value) }}
                                  onBlur={handleBlur}
                                  value={displayitem(values.IDEjecutCobranza, state.InitialData.Ejecutivos)}
                                  options={mapitems(state.InitialData.Ejecutivos ? state.InitialData.Ejecutivos : [], '')}
                                  noOptionsMessage={() => "Sin opciones"}
                                />

                              </div>
                            </div>
                          </div>
                          <div className='row'>
                            <div className='col-md-12'>
                              <div className="form-group">
                                <label htmlFor="txMotivo">Ejecutivo reclamo</label>
                                <Select
                                  placeholder="Selecione"
                                  id="IDEjecutReclamo"
                                  name="IDEjecutReclamo"
                                  styles={colourStyles}
                                  onChange={v => { setFieldValue("IDEjecutReclamo", v.value) }}
                                  onBlur={handleBlur}
                                  value={displayitem(values.IDEjecutReclamo, state.InitialData.Ejecutivos)}
                                  options={mapitems(state.InitialData.Ejecutivos ? state.InitialData.Ejecutivos : [], '')}
                                  noOptionsMessage={() => "Sin opciones"}
                                />
                              </div>
                            </div>
                          </div>
                        </div>
                        <div className='col-sm-12 col-md-12'>
                          <div className='row'>
                            <div className={isMobile ? 'col-sm-4' : 'col-md-2'}>
                              <div className="form-group">
                                <label htmlFor="txMotivo">Estatus cobro</label>
                                <Select
                                  placeholder="Selecione"
                                  id="IDEstatusCobro"
                                  name="IDEstatusCobro"
                                  styles={colourStyles}
                                  onChange={v => { setFieldValue("IDEstatusCobro", v.value) }}
                                  onBlur={handleBlur}
                                  value={displayitem(values.IDEstatusCobro, state.InitialData.EstatusCobro)}
                                  options={mapitems(state.InitialData.EstatusCobro ? state.InitialData.EstatusCobro : [], '')}
                                  noOptionsMessage={() => "Sin opciones"}
                                />
                              </div>
                            </div>
                            <div className={isMobile ? 'col-sm-4' : 'col-md-2'}>
                              <div className="form-group">
                                <label htmlFor="txMotivo">Conducto Cobro</label>
                                <Select
                                  placeholder="Selecione"
                                  id="IDCoductoCobro"
                                  name="IDCoductoCobro"
                                  styles={colourStyles}
                                  onChange={v => { setFieldValue("IDCoductoCobro", v.value) }}
                                  onBlur={handleBlur}
                                  value={displayitem(values.IDCoductoCobro, state.InitialData.ConductoCobro)}
                                  options={mapitems(state.InitialData.ConductoCobro ? state.InitialData.ConductoCobro : [], '')}
                                  noOptionsMessage={() => "Sin opciones"}
                                />
                              </div>
                            </div>
                            <div className={isMobile ? 'col-sm-4' : 'col-md-2'}>
                              <div className="form-group">
                                <label htmlFor="txMotivo">Tipo pago</label>
                                <Select
                                  placeholder="Selecione"
                                  id="IDTipoPago"
                                  name="IDTipoPago"
                                  styles={colourStyles}
                                  onChange={v => { setFieldValue("IDTipoPago", v.value) }}
                                  onBlur={handleBlur}
                                  value={displayitem(values.IDTipoPago, state.InitialData.TipoPago)}
                                  options={mapitems(state.InitialData.TipoPago ? state.InitialData.TipoPago : [], '')}
                                  noOptionsMessage={() => "Sin opciones"}
                                />
                              </div>
                            </div>
                            <div className={isMobile ? 'col-sm-4' : 'col-md-3'}>
                              <div className="form-group">
                                <label htmlFor="txMotivo">Clasificacion documento</label>
                                <Select
                                  placeholder="Selecione"
                                  id="IDClasificiacionDocumento"
                                  name="IDClasificiacionDocumento"
                                  styles={colourStyles}
                                  onChange={v => { setFieldValue("IDClasificiacionDocumento", v.value) }}
                                  onBlur={handleBlur}
                                  value={displayitem(values.IDClasificiacionDocumento, state.InitialData.EstatusDoc)}
                                  options={mapitems(state.InitialData.EstatusDoc ? state.InitialData.EstatusDoc : [], '')}
                                  noOptionsMessage={() => "Sin opciones"}
                                />
                              </div>
                            </div>
                            <div className={isMobile ? 'col-sm-4' : 'col-md-3'}>
                              <div className="form-group">
                                <label htmlFor="txMotivo">Despacho</label>
                                <Select
                                  placeholder="Selecione"
                                  id="IDDespacho"
                                  name="IDDespacho"
                                  styles={colourStyles}
                                  onChange={v => { setFieldValue("IDDespacho", v.value) }}
                                  onBlur={handleBlur}
                                  value={displayitem(values.IDDespacho, state.InitialData.Despachos)}
                                  options={mapitems(state.InitialData.Despachos ? state.InitialData.Despachos : [], '')}
                                  noOptionsMessage={() => "Sin opciones"}
                                />
                              </div>
                            </div>
                            <div className={isMobile ? 'col-sm-4' : 'col-md-2'}>
                              <div className="form-group">
                                <label htmlFor="txMotivo">Estatus usuario</label>
                                <Select
                                  placeholder="Selecione"
                                  id="IDEstatusUsuario"
                                  name="IDEstatusUsuario"
                                  styles={colourStyles}
                                  onChange={v => { setFieldValue("IDEstatusUsuario", v.value) }}
                                  onBlur={handleBlur}
                                  value={displayitem(values.IDEstatusUsuario, state.InitialData.EstatusUsurario)}
                                  options={mapitems(state.InitialData.EstatusUsurario ? state.InitialData.EstatusUsurario : [], '')}
                                  noOptionsMessage={() => "Sin opciones"}
                                />
                              </div>
                            </div>
                            <div className={isMobile ? 'col-sm-4' : 'col-md-2'}>
                              <div className="form-group">
                                <label htmlFor="txMotivo">Tipo cond cobro</label>
                                <Select
                                  placeholder="Selecione"
                                  id="IDTipoCondCobro"
                                  name="IDTipoCondCobro"
                                  styles={colourStyles}
                                  onChange={v => { setFieldValue("IDTipoCondCobro", v.value) }}
                                  onBlur={handleBlur}
                                  value={displayitem(values.IDTipoCondCobro, state.InitialData.TipoConCobro)}
                                  options={mapitems(state.InitialData.TipoConCobro ? state.InitialData.TipoConCobro : [], '')}
                                  noOptionsMessage={() => "Sin opciones"}
                                />
                              </div>
                            </div>
                            <div className={isMobile ? 'col-sm-4' : 'col-md-2'}>
                              <div className="form-group">
                                <label htmlFor="txMotivo">Tipo venta</label>
                                <Select
                                  placeholder="Selecione"
                                  id="IDTipoVenta"
                                  name="IDTipoVenta"
                                  styles={colourStyles}
                                  onChange={v => { setFieldValue("IDTipoVenta", v.value) }}
                                  onBlur={handleBlur}
                                  value={displayitem(values.IDTipoVenta, state.InitialData.TipoVenta)}
                                  options={mapitems(state.InitialData.TipoVenta ? state.InitialData.TipoVenta : [], '')}
                                  noOptionsMessage={() => "Sin opciones"}
                                />
                              </div>
                            </div>
                            <div className={isMobile ? 'col-sm-4' : 'col-md-3'}>
                              <div className="form-group">
                                <label htmlFor="txMotivo">Linea negocio</label>
                                <Select
                                  placeholder="Selecione"
                                  id="IDLineaNegocio"
                                  name="IDLineaNegocio"
                                  styles={colourStyles}
                                  onChange={v => { setFieldValue("IDLineaNegocio", v.value) }}
                                  onBlur={handleBlur}
                                  value={displayitem(values.IDLineaNegocio, state.InitialData.LineaNegocio)}
                                  options={mapitems(state.InitialData.LineaNegocio ? state.InitialData.LineaNegocio : [], '')}
                                  noOptionsMessage={() => "Sin opciones"}
                                />
                              </div>
                            </div>
                            <div className={isMobile ? 'col-sm-4' : 'col-md-3'}>
                              <div className="form-group">
                                <label htmlFor="txMotivo">Gerencia</label>
                                <Select
                                  placeholder="Selecione"
                                  id="IDGerencia"
                                  name="IDGerencia"
                                  styles={colourStyles}
                                  onChange={v => { setFieldValue("IDGerencia", v.value) }}
                                  onBlur={handleBlur}
                                  value={displayitem(values.IDGerencia, state.InitialData.Gerencias)}
                                  options={mapitems(state.InitialData.Gerencias ? state.InitialData.Gerencias : [], '')}
                                  noOptionsMessage={() => "Sin opciones"}
                                />
                              </div>
                            </div>
                          </div>
                        </div>
                      </div>
                    </div>
                    <Detalle values={values} state={state} handleChange={handleChange} handleKeyDown={handleKeyDown} handleBlur={handleBlur} setFieldValue={setFieldValue} displayitem={displayitem} mapitems={mapitems} GeConfigEspecial={GeConfigEspecial} ReloadPrices={ReloadPrices} />
                  </div>
                </div>
              </div>
            </div>
            <div className='col-md-3 mt-3'>
              <div className='row'>
                <h6>DETALLE DE PRIMAS</h6>
                <hr />
              </div>
              <div className='row mt-2'>
                <div className='col-md-12'>
                  <div className="form-group row">
                    <div className='col-sm-3' style={{ paddingRight: 'unset' }}>
                      <label className='col-form-label titulo'>P Neta</label>
                    </div>
                    <div className="col-sm-8" style={{ paddingRight: 'unset' }}>
                      <CurrencyInputField
                        disabled={IsDisabledP}
                        className='form-control input-sm numeric'
                        onBlur={(e) => { NewReloadPrices("PrimaNeta", e.target.value) /* ReloadPrices(null) */ }}
                        min={0}
                        maxLength={10}
                        //prefix='$'
                        decimalSeparator='.'
                        groupSeparator=','
                        decimalsLimit={2}
                        decimalScale={2}
                        onFocus={FocusInput}
                        allowNegativeValue={false}
                        value={values.PrimaNeta ? values.PrimaNeta : '0'}
                        onValueChange={(value, name) => { setFieldValue(name, value)/* ,ReloadPrices(values) */ }}
                        id='PrimaNeta'
                        name='PrimaNeta'
                        autoComplete='off'
                      />
                      <span className="help-block">{errors.PrimaNeta}</span>
                    </div>
                  </div>
                </div>
              </div>
              <div className='row mt-2'>
                <div className='col-md-12'>
                  <div className="form-group row">
                    <div className='col-sm-3' style={{ paddingRight: 'unset' }}>
                      <label className='col-form-label titulo'>Descuento</label>
                    </div>
                    <div className="col-sm-4" style={{ paddingRight: 'unset' }}>
                      <CurrencyInputField
                        disabled={IsDisabledP}
                        className='form-control input-sm numeric'
                        onBlur={(e) => { NewReloadPrices("Descuento", e.target.value) /* ReloadPrices('') */ }}
                        min={0}
                        maxLength={10}
                        //prefix='$'
                        decimalSeparator='.'
                        groupSeparator=','
                        decimalsLimit={2}
                        decimalScale={2}
                        onFocus={FocusInput}
                        allowNegativeValue={false}
                        value={values.Descuento ? values.Descuento : '0'}
                        onValueChange={(value, name) => { setFieldValue(name, value) }}
                        id='Descuento'
                        name='Descuento'
                        autoComplete='off'
                      />
                    </div>
                    <div className="col-sm-4 unsetPadding" style={{ paddingRight: 'unset' }}>
                      <CurrencyInputField
                        disabled={IsDisabledP}
                        className='form-control input-sm numeric'
                        onBlur={(e) => { NewReloadPrices("PDescuento", e.target.value) /* ReloadPrices(null) */ }}
                        min={0}
                        maxLength={10}
                        prefix=''
                        decimalSeparator='.'
                        groupSeparator=','
                        decimalsLimit={4}
                        decimalScale={4}
                        onFocus={FocusInput}
                        allowNegativeValue={false}
                        value={values.PDescuento ? values.PDescuento : '0'}
                        onValueChange={(value, name) => { setFieldValue(name, value) }}
                        id='PDescuento'
                        name='PDescuento'
                        autoComplete='off'
                      />
                    </div>
                  </div>
                </div>
              </div>
              <div className='row mt-2'>
                <div className='col-md-12'>
                  <div className="form-group row">
                    <div className='col-sm-3' style={{ paddingRight: 'unset' }}>
                      <label className='col-form-label titulo'>Derechos</label>
                    </div>
                    <div className="col-sm-4" style={{ paddingRight: 'unset' }}>
                      <CurrencyInputField
                        disabled={IsDisabledP}
                        className='form-control input-sm numeric'
                        onBlur={(e) => { NewReloadPrices("Derechos", e.target.value) /*  handleBlur,  *//* ReloadPrices('') */ }}
                        min={0}
                        maxLength={10}
                        //prefix='$'
                        decimalSeparator='.'
                        groupSeparator=','
                        decimalsLimit={2}
                        decimalScale={2}
                        onFocus={FocusInput}
                        allowNegativeValue={false}
                        value={values.Derechos ? values.Derechos : '0'}
                        onValueChange={(value, name) => { setFieldValue(name, value) }}
                        id='Derechos'
                        name='Derechos'
                        autoComplete='off'
                      />
                    </div>
                    <div className="col-sm-4 unsetPadding" style={{ paddingRight: 'unset' }}>
                      <CurrencyInputField
                        disabled={IsDisabledP}
                        className='form-control input-sm numeric'
                        onBlur={(e) => { NewReloadPrices("PDerecho", e.target.value) /* handleBlur, */ /* ReloadPrices(null) */ }}
                        min={0}
                        maxLength={10}
                        prefix=''
                        decimalSeparator='.'
                        groupSeparator=','
                        decimalsLimit={4}
                        decimalScale={4}
                        onFocus={FocusInput}
                        allowNegativeValue={false}
                        value={values.PDerecho ? values.PDerecho : '0'}
                        onValueChange={(value, name) => { setFieldValue(name, value) }}
                        id='PDerecho'
                        name='PDerecho'
                        autoComplete='off'
                      />
                    </div>
                  </div>
                </div>
              </div>
              <div className='row mt-2'>
                <div className='col-md-12'>
                  <div className="form-group row">
                    <div className='col-sm-3' style={{ paddingRight: 'unset' }}>
                      <label className='col-form-label titulo'>Gstos Maq</label>
                    </div>
                    <div className="col-sm-8" style={{ paddingRight: 'unset' }}>
                      <CurrencyInputField
                        disabled={IsDisabledP}
                        className='form-control input-sm numeric'
                        onBlur={(e) => { NewReloadPrices("GastosMaquila", e.target.value) /* ReloadPrices(null) */ /* handleBlur *//* , ReloadPrices(values) */ }}
                        min={0}
                        maxLength={10}
                        //prefix='$'
                        decimalSeparator='.'
                        groupSeparator=','
                        decimalsLimit={2}
                        decimalScale={2}
                        onFocus={FocusInput}
                        allowNegativeValue={false}
                        value={values.GastosMaquila ? values.GastosMaquila : '0'}
                        onValueChange={(value, name) => { setFieldValue(name, value)/* ,ReloadPrices(values) */ }}
                        id='GastosMaquila'
                        name='GastosMaquila'
                        autoComplete='off'
                      />
                    </div>
                  </div>
                </div>
              </div>
              <div className='row mt-2'>
                <div className='col-md-12'>
                  <div className="form-group row">
                    <div className='col-sm-3' style={{ paddingRight: 'unset' }}>
                      <label className='col-form-label titulo'>Gstos Adm</label>
                    </div>
                    <div className="col-sm-8" style={{ paddingRight: 'unset' }}>
                      <CurrencyInputField
                        disabled={IsDisabledP}
                        className='form-control input-sm numeric'
                        onBlur={(e) => { NewReloadPrices("GastosAdmin", e.target.value) /* ReloadPrices(null) */ /* handleBlur *//* , ReloadPrices(values) */ }}
                        min={0}
                        maxLength={10}
                        //prefix='$'
                        decimalSeparator='.'
                        groupSeparator=','
                        decimalsLimit={4}
                        decimalScale={4}
                        onFocus={FocusInput}
                        allowNegativeValue={false}
                        value={values.GastosAdmin ? values.GastosAdmin : '0'}
                        onValueChange={(value, name) => { setFieldValue(name, value)/* ,ReloadPrices(values) */ }}
                        id='GastosAdmin'
                        name='GastosAdmin'
                        autoComplete='off'
                      />
                    </div>
                  </div>
                </div>
              </div>
              <div className='row mt-2'>
                <div className='col-md-12'>
                  <div className="form-group row">
                    <div className='col-sm-3' style={{ paddingRight: 'unset' }}>
                      <label className='col-form-label titulo'>SubTotal</label>
                    </div>
                    <div className="col-sm-8" style={{ paddingRight: 'unset' }}>
                      <CurrencyInputField
                        disabled={true}
                        className='form-control input-sm numeric'
                        onBlur={(e) => { NewReloadPrices("STotal", e.target.value) /* handleBlur, */ /* ReloadPrices(null) */ }}
                        min={0}
                        maxLength={10}
                        //prefix='$'
                        decimalSeparator='.'
                        groupSeparator=','
                        decimalsLimit={2}
                        decimalScale={2}
                        onFocus={FocusInput}
                        allowNegativeValue={false}
                        value={values.STotal ? values.STotal : '0'}
                        onValueChange={(value, name) => { setFieldValue(name, value) }}
                        id='STotal'
                        name='STotal'
                        autoComplete='off'
                      />
                    </div>
                  </div>
                </div>
              </div>
              <div className='row mt-2'>
                <div className='col-md-12'>
                  <div className="form-group row">
                    <div className='col-sm-3' style={{ paddingRight: 'unset' }}>
                      <label className='col-form-label titulo'>IVA</label>
                    </div>
                    <div className="col-sm-4" style={{ paddingRight: 'unset' }}>
                      <CurrencyInputField
                        disabled={IsDisabledP}
                        className='form-control input-sm numeric'
                        onBlur={(e) => { NewReloadPrices("IVA", e.target.value) /* handleBlur, *//*  ReloadPrices('IVA') */ }}
                        min={0}
                        maxLength={10}
                        //prefix='$'
                        decimalSeparator='.'
                        groupSeparator=','
                        decimalsLimit={2}
                        decimalScale={2}
                        onFocus={FocusInput}
                        allowNegativeValue={false}
                        value={values.IVA ? values.IVA : '0'}
                        onValueChange={(value, name) => { setFieldValue(name, value) }}
                        id='IVA'
                        name='IVA'
                        autoComplete='off'
                      />
                    </div>
                    <div className="col-sm-4 unsetPadding" style={{ paddingRight: 'unset' }}>
                      <CurrencyInputField
                        disabled={IsDisabledP}
                        className='form-control input-sm numeric'
                        onBlur={(e) => { NewReloadPrices("PorIVA", e.target.value) /* handleBlur, *//*  ReloadPrices(null) */ }}
                        min={0}
                        maxLength={10}
                        prefix=''
                        decimalSeparator='.'
                        groupSeparator=','
                        decimalsLimit={4}
                        decimalScale={4}
                        onFocus={FocusInput}
                        allowNegativeValue={false}
                        value={values.PorIVA ? values.PorIVA : '0'}
                        onValueChange={(value, name) => { setFieldValue(name, value) }}
                        id='PorIVA'
                        name='PorIVA'
                        autoComplete='off'
                      />
                    </div>
                  </div>
                </div>
              </div>
              <div className='row mt-2'>
                <div className='col-md-12'>
                  <div className="form-group row">
                    <div className='col-sm-3' style={{ paddingRight: 'unset' }}>
                      <label className='col-form-label titulo'>P Total</label>
                    </div>
                    <div className="col-sm-8" style={{ paddingRight: 'unset' }}>
                      <CurrencyInputField
                        disabled={true}
                        className='form-control input-sm numeric'
                        onBlur={(e) => { NewReloadPrices("PrimaTotal", e.target.value) /*  handleBlur, */ /* ReloadPrices(null) */ }}
                        min={0}
                        maxLength={10}
                        //prefix='$'
                        decimalSeparator='.'
                        groupSeparator=','
                        decimalsLimit={2}
                        decimalScale={2}
                        onFocus={FocusInput}
                        allowNegativeValue={false}
                        value={values.PrimaTotal ? values.PrimaTotal : '0'}
                        onValueChange={(value, name) => { setFieldValue(name, value) }}
                        id='PrimaTotal'
                        name='PrimaTotal'
                        autoComplete='off'
                      />
                    </div>
                  </div>
                </div>
              </div>
              <div className='row'>
                <h6>DETALLE DE COMISIONES</h6>
                <hr />
              </div>
              <div className='row mt-2'>
                <div className='col-md-12'>
                  <div className="form-group row">
                    <div className='col-sm-3' style={{ paddingRight: 'unset' }}>
                      <label className='col-form-label titulo'>Neta</label>
                    </div>
                    <div className="col-sm-4" style={{ paddingRight: 'unset' }}>
                      <CurrencyInputField
                        disabled={IsDisabledP}
                        className='form-control input-sm numeric'
                        onBlur={(e) => { NewReloadPrices("ComNeta", e.target.value) /* ReloadPrices('') */ }}
                        min={0}
                        maxLength={10}
                        //prefix='$'
                        decimalSeparator='.'
                        groupSeparator=','
                        decimalsLimit={2}
                        decimalScale={2}
                        onFocus={FocusInput}
                        allowNegativeValue={false}
                        value={values.ComNeta ? values.ComNeta : '0'}
                        onValueChange={(value, name) => { setFieldValue(name, value) }}
                        id='ComNeta'
                        name='ComNeta'
                        autoComplete='off'
                      />
                    </div>
                    <div className="col-sm-4 unsetPadding" style={{ paddingRight: 'unset' }}>
                      <CurrencyInputField
                        disabled={IsDisabledP}
                        className='form-control input-sm numeric'
                        onBlur={(e) => { NewReloadPrices("PComNeta", e.target.value) /* ReloadPrices(null) */ }}
                        min={0}
                        maxLength={10}
                        prefix=''
                        decimalSeparator='.'
                        groupSeparator=','
                        decimalsLimit={4}
                        decimalScale={4}
                        onFocus={FocusInput}
                        allowNegativeValue={false}
                        value={values.PComNeta ? values.PComNeta : '0'}
                        onValueChange={(value, name) => { setFieldValue(name, value) }}
                        id='PComNeta'
                        name='PComNeta'
                        autoComplete='off'
                      />
                    </div>
                  </div>
                </div>
              </div>

              <div className='row mt-2'>
                <div className='col-md-12'>
                  <div className="form-group row">
                    <div className='col-sm-3' style={{ paddingRight: 'unset' }}>
                      <label className='col-form-label titulo'>Derechos</label>
                    </div>
                    <div className="col-sm-4" style={{ paddingRight: 'unset' }}>
                      <CurrencyInputField
                        disabled={IsDisabledP}
                        className='form-control input-sm numeric'
                        onBlur={(e) => { NewReloadPrices("ComDer", e.target.value) /* handleBlur, */ /* ReloadPrices('') */ }}
                        min={0}
                        maxLength={10}
                        //prefix='$'
                        decimalSeparator='.'
                        groupSeparator=','
                        decimalsLimit={2}
                        decimalScale={2}
                        onFocus={FocusInput}
                        allowNegativeValue={false}
                        value={values.ComDer ? values.ComDer : '0'}
                        onValueChange={(value, name) => { setFieldValue(name, value) }}
                        id='ComDer'
                        name='ComDer'
                        autoComplete='off'
                      />
                    </div>
                    <div className="col-sm-4 unsetPadding" style={{ paddingRight: 'unset' }}>
                      <CurrencyInputField
                        disabled={IsDisabledP}
                        className='form-control input-sm numeric'
                        onBlur={(e) => { NewReloadPrices("PComDer", e.target.value) /* handleBlur, *//*  ReloadPrices(null) */ }}
                        min={0}
                        maxLength={10}
                        prefix=''
                        decimalSeparator='.'
                        groupSeparator=','
                        decimalsLimit={4}
                        decimalScale={4}
                        onFocus={FocusInput}
                        allowNegativeValue={false}
                        value={values.PComDer ? values.PComDer : '0'}
                        onValueChange={(value, name) => { setFieldValue(name, value) }}
                        id='PComDer'
                        name='PComDer'
                        autoComplete='off'
                      />
                    </div>
                  </div>
                </div>
              </div>
              <div className='row mt-2'>
                <div className='col-md-12'>
                  <div className="form-group row">
                    <div className='col-sm-3' style={{ paddingRight: 'unset' }}>
                      <label className='col-form-label titulo'>Gtos Maquila</label>
                    </div>
                    <div className="col-sm-4" style={{ paddingRight: 'unset' }}>
                      <CurrencyInputField
                        disabled={IsDisabledP}
                        className='form-control input-sm numeric'
                        onBlur={(e) => { NewReloadPrices("CGastosMaquila", e.target.value) /* handleBlur, */ /* ReloadPrices('') */ }}
                        min={0}
                        maxLength={10}
                        //prefix='$'
                        decimalSeparator='.'
                        groupSeparator=','
                        decimalsLimit={2}
                        decimalScale={2}
                        onFocus={FocusInput}
                        allowNegativeValue={false}
                        value={values.CGastosMaquila ? values.CGastosMaquila : '0'}
                        onValueChange={(value, name) => { setFieldValue(name, value) }}
                        id='CGastosMaquila'
                        name='CGastosMaquila'
                        autoComplete='off'
                      />
                    </div>
                    <div className="col-sm-4 unsetPadding" style={{ paddingRight: 'unset' }}>
                      <CurrencyInputField
                        disabled={IsDisabledP}
                        className='form-control input-sm numeric'
                        onBlur={(e) => { NewReloadPrices("PCGastosMaquila", e.target.value) /* handleBlur, */ /* ReloadPrices(null) */ }}
                        min={0}
                        maxLength={10}
                        prefix=''
                        decimalSeparator='.'
                        groupSeparator=','
                        decimalsLimit={4}
                        decimalScale={4}
                        onFocus={FocusInput}
                        allowNegativeValue={false}
                        value={values.PCGastosMaquila ? values.PCGastosMaquila : '0'}
                        onValueChange={(value, name) => { setFieldValue(name, value) }}
                        id='PCGastosMaquila'
                        name='PCGastosMaquila'
                        autoComplete='off'
                      />
                    </div>
                  </div>
                </div>
              </div>
              <div className='row mt-2'>
                <div className='col-md-12'>
                  <div className="form-group row">
                    <div className='col-sm-3' style={{ paddingRight: 'unset' }}>
                      <label className='col-form-label titulo'>Gtos Admin</label>
                    </div>
                    <div className="col-sm-4" style={{ paddingRight: 'unset' }}>
                      <CurrencyInputField
                        disabled={IsDisabledP}
                        className='form-control input-sm numeric'
                        onBlur={(e) => { NewReloadPrices("CGastosAdmin", e.target.value) /* handleBlur, */ /* ReloadPrices('') */ }}
                        min={0}
                        maxLength={10}
                        //prefix='$'
                        decimalSeparator='.'
                        groupSeparator=','
                        decimalsLimit={2}
                        decimalScale={2}
                        onFocus={FocusInput}
                        allowNegativeValue={false}
                        value={values.CGastosAdmin ? values.CGastosAdmin : '0'}
                        onValueChange={(value, name) => { setFieldValue(name, value) }}
                        id='CGastosAdmin'
                        name='CGastosAdmin'
                        autoComplete='off'
                      />
                    </div>
                    <div className="col-sm-4 unsetPadding" style={{ paddingRight: 'unset' }}>
                      <CurrencyInputField
                        disabled={IsDisabledP}
                        className='form-control input-sm numeric'
                        onBlur={(e) => { NewReloadPrices("PCGastosAdmin", e.target.value) /* handleBlur, */ /* ReloadPrices(null) */ }}
                        min={0}
                        maxLength={10}
                        prefix=''
                        decimalSeparator='.'
                        groupSeparator=','
                        decimalsLimit={4}
                        decimalScale={4}
                        onFocus={FocusInput}
                        allowNegativeValue={false}
                        value={values.PCGastosAdmin ? values.PCGastosAdmin : '0'}
                        onValueChange={(value, name) => { setFieldValue(name, value) }}
                        id='PCGastosAdmin'
                        name='PCGastosAdmin'
                        autoComplete='off'
                      />
                    </div>
                  </div>
                </div>
              </div>
              <div className='row mt-2'>
                <div className='col-md-12'>
                  <div className="form-group row">
                    <div className='col-sm-3' style={{ paddingRight: 'unset' }}>
                      <label className='col-form-label titulo'>Especial</label>
                    </div>
                    <div className="col-sm-4" style={{ paddingRight: 'unset' }}>
                      <CurrencyInputField
                        disabled={IsDisabledP}
                        className='form-control input-sm numeric'
                        onBlur={(e) => { NewReloadPrices("Especial", e.target.value) /* handleBlur, */ /* ReloadPrices('') */ }}
                        min={0}
                        maxLength={10}
                        //prefix='$'
                        decimalSeparator='.'
                        groupSeparator=','
                        decimalsLimit={2}
                        decimalScale={2}
                        onFocus={FocusInput}
                        allowNegativeValue={false}
                        value={values.Especial ? values.Especial : '0'}
                        onValueChange={(value, name) => { setFieldValue(name, value) }}
                        id='Especial'
                        name='Especial'
                        autoComplete='off'
                      />
                    </div>
                    <div className="col-sm-4 unsetPadding" style={{ paddingRight: 'unset' }}>
                      <CurrencyInputField
                        disabled={IsDisabledP}
                        className='form-control input-sm numeric'
                        onBlur={(e) => { NewReloadPrices("PEspecial", e.target.value) /* handleBlur, */ /* ReloadPrices(null) */ }}
                        min={0}
                        maxLength={10}
                        prefix=''
                        decimalSeparator='.'
                        groupSeparator=','
                        decimalsLimit={4}
                        decimalScale={4}
                        onFocus={FocusInput}
                        allowNegativeValue={false}
                        value={values.PEspecial ? values.PEspecial : '0'}
                        onValueChange={(value, name) => { setFieldValue(name, value) }}
                        id='PEspecial'
                        name='PEspecial'
                        autoComplete='off'
                      />
                    </div>
                  </div>
                </div>
              </div>
              <div className='row'>
                <h6>REGISTRO DE FECHAS</h6>
                <hr />
              </div>
              <div className='row mt-2'>
                <div className='col-md-6'>
                  <div className="form-group">
                    <label htmlFor="txMotivo">Solicitud</label>
                    <input
                      className="form-control input-sm"
                      type="date"
                      name="FSolicitud"
                      id="FSolicitud"
                      onChange={handleChange}
                      value={values.FSolicitud ? moment(values.FSolicitud).format("YYYY-MM-DD") : ''}
                    />
                  </div>
                </div>
                <div className='col-md-6'>
                  <div className='form-group'>
                    <label htmlFor="txMotivo">No. Folio</label>
                    <input
                      className="form-control input-sm"
                      type="text"
                      name="FolioNo"
                      id="FolioNo"
                      onChange={handleChange}
                      value={values.FolioNo ? values.FolioNo : ''}
                    />
                  </div>
                </div>
                <div className='col-md-6'>
                  <div className="form-group">
                    <label htmlFor="txMotivo">Recepcion</label>
                    <input
                      className="form-control input-sm"
                      type="date"
                      name="FRecepcion"
                      id="FRecepcion"
                      onChange={handleChange}
                      value={values.FRecepcion ? moment(values.FRecepcion).format("YYYY-MM-DD") : ''}
                    />
                  </div>
                </div>
                <div className='col-md-6'>
                  <div className="form-group">
                    <label htmlFor="txMotivo">Emision</label>
                    <input
                      className="form-control input-sm"
                      type="date"
                      name="FEmision"
                      id="FEmision"
                      onChange={handleChange}
                      value={values.FEmision ? moment(values.FEmision).format("YYYY-MM-DD") : ''}
                    />
                  </div>
                </div>
                <div className='col-md-6'>
                  <div className="form-group">
                    <label htmlFor="txMotivo">Conversion</label>
                    <input
                      disabled={true}
                      className="form-control input-sm"
                      type="date"
                      name="FConversion"
                      id="FConversion"
                      onChange={handleChange}
                      value={values.FConversion ? moment(values.FConversion).format("YYYY-MM-DD") : ''}
                    />
                  </div>
                </div>
                <div className='col-md-6'>
                  <div className="form-group">
                    <label htmlFor="txMotivo">Entrega</label>
                    <input
                      className="form-control input-sm"
                      type="date"
                      name="FEntrega"
                      id="FEntrega"
                      onChange={handleChange}
                      value={values.FEntrega ? moment(values.FEntrega).format("YYYY-MM-DD") : ''}
                    />
                  </div>
                </div>
              </div>
              <div className='row'>
                <div className='col-md-12 text-center'>
                  <h5>ESTATUS DEL DOCUMENTO</h5>
                </div>
              </div>
              <div className='row'>
                <div className='col-md-12 text-center'>
                  <h6>{values.Status_TXT == null ? 'N/A' : values.Status_TXT}</h6>
                </div>
              </div>
            </div>
          </div>
          {values.TipoDocto != 0 && values.IsSavedFianza == 1 && (
            <div className='row'>
              <div className='col-md-12'>
                <div className='row' style={{ paddingTop: '35px' }}>
                  <div className='col-md-6'>
                    <h6>LISTADO DE RECIBOS</h6>
                  </div>
                  <div className='col-md-6 text-right'>
                    <AllowElement PermisoAccion="Recibos">
                      <>
                        {recibos.length == 0 && (
                          <>
                            <a className='btn btn-primary btn-sm btn-recibos' style={{ marginRight: '5px' }} disabled={Id === undefined ? true : false} onClick={() => GeneraRecibos()}>
                              Generar
                            </a>
                          </>
                        )}
                        {recibos.length > 0 && recibos.length < values.NPagos && (
                          <>
                            <a className='btn btn-primary btn-sm btn-recibos'
                              style={{ marginRight: '5px' }}
                              disabled={Id === undefined ? true : false}
                              onClick={() => recalculateAllRecibos(recibos.length - 1, recibos[recibos.length - 1])}>
                              Recalcular Recibos
                            </a>
                          </>
                        )}
                        {recibos.length > 0 && (
                          <>
                            <a className='btn btn-primary btn-sm btn-recibos' style={{ marginRight: '5px' }} disabled={Id === undefined ? true : false} onClick={() => DeleteAllRecibos()}>Eliminar Recibos</a>
                          </>
                        )}
                        <a className='btn btn-primary btn-sm btn-recibos' style={{ marginRight: '5px' }} disabled={Id === undefined ? true : false} onClick={() => NuevoRecibo()}>Nuevo Recibo</a>
                        <a className='btn btn-primary btn-sm btn-recibos' style={{ marginRight: '5px' }} disabled={Id === undefined ? true : false} onClick={() => SaveRecibos()}>Guardar Recibos</a>
                        <a className='btn btn-primary btn-sm btn-recibos' style={{ marginRight: '5px' }} disabled={Id === undefined ? true : false} onClick={() => window.location = `${UrlPagina}servicioSistema/recibos/${Id}/F`}>Cobranza</a>
                      </>
                    </AllowElement >
                  </div>
                  <div className='col-md-12'>
                    <hr />
                  </div>
                </div>
                <TablaRecibos
                  Recibos={recibos}
                  values={values}
                  ChangeValueRecibo={ChangeValueRecibo}
                  handleBlur={handleBlur}
                  FocusInput={FocusInput}
                  ChangeEdit={ChangeEdit}
                  DeleteRecibo={DeleteRecibo}
                  Tipo={'F'}
                />
              </div>
            </div>
          )}

          <ModalRecibos IndexRecibo={IndexRecibo}
            Item={ItemRecibo}
            ItemInfoRecibo={ItemInfoRecibo}
            ChangeValueRecibo={ChangeValueRecibo}
            handleBlur={handleBlur}
            FocusInput={FocusInput}
            Tipo={'F'}
            ReloadAll={ReloadAll}
            NewChangeValueRecibo={NewChangeValueRecibo}
            ReloadRecibosSubsecuentes={ReloadRecibosSubsecuentes}
            itemSelected={itemSelected}
            setItemSelected={setItemSelected}
            cancelAction={cancelAction}
            closeModal={closeModal} />

          {/* <ModalComRevision ref={ChildrenkRef} Monedas={state.InitialData.Monedas} Url={UrlServicio} ListaElementos={configuraciones.listaComisiones} ListaHonorarios={configuraciones.ListaHonorarios} setState={SetConfiguraciones} state={configuraciones} Tipo={'F'} /> */}
          <ModalComRevision ref={ChildrenkRef} ReloadHon={RealoadHonorarios} Modulo={"F"} InitialData={InitialDataRegistro} UrlServicio={UrlServicio} Documento={formikRef.current ? formikRef.current.values : {}} Vendedores={state.InitialData.Vendedores} Agentes={state.InitialData.Agentes} Monedas={state.InitialData.Monedas} Url={UrlServicio} ListaElementos={configuraciones.listaComisiones} ListaHonorarios={configuraciones.ListaHonorarios} setState={SetConfiguraciones} state={configuraciones} Tipo={'F'} />
          <ModalCancelar
            Id={Id}
            Documento={values.Documento ? values.Documento : ''}
            Modulo={'F'}
            Estatus={state.InitialData.EstatusCancelacion}
            Motivos={state.InitialData.MotivosCancelacion}
            UrlServicio={UrlServicio}
            Callback={() => { InitialData(), InitialDataRegistro() }}
          />
          <ModalRehabilitar
            Id={Id}
            Documento={values.Documento ? values.Documento : ''}
            Modulo={'F'}
            Estatus={state.InitialData.EstatusCancelacion}
            Motivos={state.InitialData.MotivosCancelacion}
            UrlServicio={UrlServicio}
            Callback={() => { InitialData(), InitialDataRegistro() }}
          />
          <ModalEndososV2 ref={ModalEndosos} IDDocto={values.IDDocto} Documento={values.Documento} UrlServicio={UrlServicio} UrlPagina={UrlPagina} Modulo={'F'} />
          {/* <ModalEndosos IDDocto={values.IDDocto} UrlPagina={UrlPagina} ListaEndosos={ordenTrabajo.Endosos} Modulo={'F'} /> */}
          <ModalFileManager ref={ModalFileUploadRef} Documento={values.Documento} referencia={'DOCUMENT'} referenciaId={values.Solicitud} IDCli={values.IDCli} />
        </form>

      )}
    </Formik>
  )
}
