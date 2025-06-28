import React, { useState, useEffect, useRef } from 'react';
import Select from "react-select";
import { Form, Formik } from "formik";
import { CallApiGet, CallApiPost } from '../../Helpers/Calls.js';
import axios from "axios";
import { ShowLoading, mapitems, mapitemsHijos, displayitem, colourStyles, calculatePagos, LockEnter, round, UpperCaseField } from '../../Helpers/FGeneral.js';
import CurrencyInputField from 'react-currency-input-field';
import { validationSchemaEndoso } from '../../Helpers/Validations.js';
import TablaRecibos from '../captura/TablaRecibos.jsx';
import ModalComRevision from '../captura/ModalComRevision.jsx';
import ModalRecibos from '../captura/ModalRecibos.jsx';
import ModalCancelar from '../Acciones/ModalCancelar.jsx';
import ModalDocumentos from '../Acciones/ModalDocumentos.jsx';
import AllowElement from '../Acciones/AllowElements.jsx';
import ModalFileManager from '../Acciones/ModalFileManager.jsx';

export default function Endoso(props) {
  const { callback, UrlServicio, UrlPagina } = props;
  const path = window.jQuery("#base_url").attr("data-base-url");
  const Id = window.jQuery("#idRegistro").val();
  const IdDoc = window.jQuery("#idDoc").val();
  const Modulo = window.jQuery("#Modulo").val();
  const LoggedUser = window.jQuery("#Usuario").val();
  const formikRef = useRef(null);
  const ChildrenkRef = useRef(null);
  const [ItemRecibo, SetItemRecibo] = useState({});
  const [ItemInfoRecibo, SetItemInfoRecibo] = useState({});
  const [IndexRecibo, SetIndexRecibo] = useState();
  const [IsDisabled, setIsDisabled] = useState(false);
  const [sendRecibos, SetsendRecibos] = useState(false);
  const ModalFileUploadRef = useRef(null);
  const [IsChange, SetIsChange] = useState(false);


  const [state, setState] = useState({
    InitialData: {
      TipoDocumento: [],
      TipoEndoso: [],
      Referencia: [],
      EstatusUsuario: [],
      TotalRecibos: [],
      Compania: [],
      Agentes:[],
      Vendedores:[],
      Monedas:[]

    },
    selected: { value: "", label: "" },
  });
  const [configuraciones, SetConfiguraciones] = useState({
    listaComisiones: [],
    ListaHonorarios: [],
  })
  const [evaluadores, setEvaluad] = useState([]);
  const [recibos, setRecibos] = useState([]);
  const [endoso, setEndoso] = useState({});

  const [ordenTrabajo, SetordenTrabajo] = useState({
    OT: {
      IDTemp: '',
      IsSaved: null,
      FHasta: null,
      ComN: 0,
      PComN: 0,
      ComR: 0,
      PComR: 0,
      ComD: 0,
      PComD: 0,
      Especial: 0,
      PEspecial: 0
    },
    InfoRecibos: []
  });

  const [AjusteAnteriorGuardado, SetAjusteAnteriorGuardado] = useState(0);

  useEffect(() => {
    if ($('body div').hasClass('pace')) {
      $("body div").removeClass("pace");
    }
    InitialData();
    if (Id != undefined) {
      InitialDataRegistro();
    }

  }, []);


  //Obtner initial data
  function InitialData() {
    var complemento = {};
    var URL = `${UrlServicio}capture/getInitialendoso?IdDoc=${IdDoc}&Tipo=${Modulo}`;
    //if (formikRef.current.values.IDAgente != undefined) {
    if (Id != undefined) {
      URL = `${UrlServicio}capture/getInitialendoso?IdDoc=${IdDoc}&IdRegistro=${Id}&Tipo=${Modulo}&Agente=${Id}`;
      complemento = {
        Agente: Id
      }
    } else {
      URL = `${UrlServicio}capture/getInitialendoso?IdDoc=${IdDoc}&Tipo=${Modulo}&IDAgente=${formikRef.current.values.IDAgente}`;
      complemento = {
        IDAgente: formikRef.current.values.IDAgente
      }
    }

    axios
      .get(URL, complemento)
      .then(function (response) {
        setState({
          ...state,
          InitialData: response.data.Datos
        });

        SetAjusteAnteriorGuardado(response.data.Datos.Referencia.Ajuste || 0);

        if (Id == undefined) {

          let referencia = response.data.Datos.Referencia;

          SetordenTrabajo(prevState => ({
            ...prevState,
            OT: {
              ...prevState.OT,
              FHasta: response.data.Datos.Referencia.FHasta,
              PComN: response.data.Datos.Comisiones.PComN,
              PComD: response.data.Datos.Comisiones.PComD,
              PorDerechos: response.data.Datos.Comisiones.PDerecho,
              PorIVA: response.data.Datos.Comisiones.PorIVA,
              PEspecial: response.data.Datos.Comisiones.PComEsp,

              PDescuento: referencia.PDescuento,

              ...(Modulo === "P"
                ? {
                  PComR: response.data.Datos.Comisiones.PComR,
                  PorRecargos: response.data.Datos.Comisiones.PorRecargos
                }
                : {
                  PCGastosMaquila: response.data.Datos.Comisiones.PCGastosMaquila,
                  PCGastosAdmin: response.data.Datos.Comisiones.PCGastosAdmin,
                  GastosMaquila: response.data.Datos.Comisiones.GastosMaquila
                })
            }
          }));
        }
      });
  }

  function InitialDataRegistro() {
    axios
      .get(`${UrlServicio}capture/singleEndoso?Id=${Id}&IdDoc=${IdDoc}&Modulo=${Modulo}`, { id: Id })
      .then(function (response) {
        var Dta = response.data.Datos.OT;

        if (Dta != null) {
          var Cstate = { ...ordenTrabajo };
          Cstate.OT = response.data.Datos.OT;
          Cstate.InfoRecibos = response.data.Datos.InfoRecibos;
          SetordenTrabajo(Cstate);
          if (Cstate.OT.Tipo == 4) {
            setIsDisabled(true);
          }
          /*  SetordenTrabajo({
             ...ordenTrabajo,
             OT: response.data.Datos.OT,
             InfoRecibos: response.data.Datos.InfoRecibos,
             //Usuario: response.data.Datos.Usuario
           }); */
        }
        setRecibos(response.data.Datos.Recibos);
        SetConfiguraciones({ ...configuraciones, ListaHonorarios: response.data.Datos.Honorarios, listaComisiones: response.data.Datos.Comisiones })
        let GrupoHon = response.data.Datos.TotalHonorariosGrupo;
        if (response.data.Datos.TotalHonorario > 0) {
          Object.keys(GrupoHon).forEach(function (key) {
            var val = GrupoHon[key];
            if ((val > 100 || val < 100) && response.data.Datos.OT.TipoDocto == 1) {
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
          swal({
            title: "Honorarios",
            text: "La participación de los honorarios debe de estar al 100%.",
            icon: "warning",
            confirmButtonText: "Aceptar",
            confirmButtonColor: "#472380"
          });
        }
        /* if ((response.data.Datos.TotalHonorario < 100 || response.data.Datos.TotalHonorario > 100) && response.data.Datos.OT.TipoDocto == 1) {
          swal({
            title: "Honorarios",
            text: "La participación de los honorarios debe de estar al 100%.",
            icon: "warning",
            confirmButtonText: "Aceptar",
            confirmButtonColor: "#472380"
          });
        } */
      });
  }

  function SaveData(data) {
    ShowLoading();
    var dta = {
      "data": data,
      "IDDocto": IdDoc,
      "Modulo": Modulo,
      "Id": Id,
      "User": LoggedUser
    };
    axios
      .post(`${UrlServicio}capture/save_endoso`, dta)
      .then(function (response) {
        var RId = response.data.Datos.IDEnd;
        toastr.success("Exíto");
        if (Id == undefined) {
          window.location = path + `servicioSistema/EndosoEdit/${IdDoc}/${RId}/${Modulo}`;
        } else {
          SetIsChange(false);
          InitialDataRegistro();
        }
      })
      .catch(error => {
        toastr.error(`Error, intente mas tarde. ${error}`);
      });
    ShowLoading(false);
  }

  const handleKeyDown = (event) => {
    event.preventDefault();
    event.stopPropagation();
    if (event.key === 'Enter') {

    }
  }

  const FocusInput = (e) => {
    e.target.select();
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
      var Rvalues = res.success.Datos.ConfigComisiones;
      setState({ ...state, listaComisiones: res.success.Datos.ListaComisiones });
      //ListaHonorarios:res.success.Datos.ListaHonorarios
      //asignamos los valores al formik
      //formikRef.current.setFieldValue('PorRecargos', Rvalues.PrimaRecargos);
      formikRef.current.setFieldValue('PDerecho', Rvalues.PrimaRecargos);
      formikRef.current.setFieldValue('GastosMaquila', Rvalues.PrimaDerechos);
      formikRef.current.setFieldValue('PComNeta', Rvalues.ComisionesBase);
      formikRef.current.setFieldValue('PCGastosMaquila', Rvalues.ComisionesDerechos);
    }
    ShowLoading(false);
    //var PNeta = parseFloat(values.PrimaNeta ? values.PrimaNeta : 0);
  }

  function ReloadPrices(valores = null) {
    const values = formikRef.current.values;

    var Ajuste = Math.abs(parseFloat(values.Ajuste ? Math.abs(values.Ajuste) : 0));
    var TipoEndoso = parseFloat(values.TipoE ? values.TipoE : 1);
    var PNeta = Math.abs(parseFloat(values.PrimaNeta ? Math.abs(values.PrimaNeta) : 0));
    var Derechos = Math.abs(parseFloat(values.Derechos ? Math.abs(values.Derechos) : 0));//IDSRamo
    var Ramo = Math.abs(parseFloat(state.InitialData.Referencia.IDSRamo ? state.InitialData.Referencia.IDSRamo : 0));
    var GastosMaquila = Math.abs(parseFloat(values.GastosMaquila ? Math.abs(values.GastosMaquila) : 0));
    var GastosAdmin = Math.abs(parseFloat(values.GastosAdmin ? Math.abs(values.GastosAdmin) : 0));
    var PRecargos = Math.abs(parseFloat(values.PorRecargos ? values.PorRecargos : 0));
    var PDescuento = Math.abs(parseFloat(values.PDescuento ? values.PDescuento : 0));
    var PIVA = 0;
    var IVA = 0;
    var SubTotal = 0;
    var IPIVA = values.PorIVA;
    if (valores == null) {
      PIVA = Math.abs(parseFloat(values.PorIVA ? values.PorIVA : 0));

      //Varibales calculables
      var Descuento = Math.abs(round((PNeta * (PDescuento / 100)), 4));
      var Recargos = Math.abs(round((PNeta * (PRecargos / 100)), 4));

      if (Modulo == "P") {
        SubTotal = parseFloat(Recargos) + parseFloat(PNeta) + parseFloat(Derechos) - parseFloat(Descuento);
      } else {
        var PorDerechos = Math.abs(parseFloat(values.PorDerechos ? values.PorDerechos : 0));
        var Derechos = round((PNeta * (PorDerechos / 100)), 4);
        formikRef.current.setFieldValue('Derechos', Derechos);
        SubTotal = parseFloat(PNeta) + parseFloat(Derechos) - parseFloat(Descuento) + parseFloat(GastosMaquila) + parseFloat(GastosAdmin);
      }


      var IVA = round((PIVA / 100) * SubTotal, 4);
      var PTotal = round((Math.abs(SubTotal) + Math.abs(parseFloat(IVA)) + Math.abs(parseFloat(Ajuste))), 4);
      //var PTotal = round((SubTotal + parseFloat(IVA)), 2);
      //Actualizmaos Prima

      formikRef.current.setFieldValue('GastosMaquila', GastosMaquila * (TipoEndoso));
      formikRef.current.setFieldValue('GastosAdmin', GastosAdmin * (TipoEndoso));
      formikRef.current.setFieldValue('PrimaNeta', PNeta * (TipoEndoso));
      //formikRef.current.setFieldValue('Descuento', Descuento * (TipoEndoso));
      formikRef.current.setFieldValue('Descuento', Descuento);
      formikRef.current.setFieldValue('Derechos', Derechos * (TipoEndoso));
      formikRef.current.setFieldValue('Recargos', Math.abs(Recargos) * (TipoEndoso));
      formikRef.current.setFieldValue('STotal', round(SubTotal, 4) * (TipoEndoso));
      formikRef.current.setFieldValue('IVA', round(parseFloat(IVA), 4) * (TipoEndoso));
      formikRef.current.setFieldValue('Ajuste', parseFloat(Ajuste) * (TipoEndoso));
      formikRef.current.setFieldValue('PrimaTotal', parseFloat(PTotal) * (TipoEndoso));
      //Actualizamos Comisiones
      var PorComincion = Math.abs(parseFloat(values.PComN ? values.PComN : 0));
      var Comision = round((PNeta * (PorComincion / 100)), 4);
      var PRecargos = Math.abs(parseFloat(values.PComR ? values.PComR : 0));
      var RecargosC = round((Recargos * (PRecargos / 100)), 4);//PorRecargos
      var PorDerechos = Math.abs(parseFloat(values.PComD ? values.PComD : 0));
      var Derechos = round(parseFloat(Derechos * (PorDerechos / 100)), 4);
      var PorEspecial = Math.abs(parseFloat(values.PEspecial ? values.PEspecial : 0));
      var Especial = round(parseFloat(PNeta * (PorEspecial / 100)), 4);
      var PorMaquila = Math.abs(parseFloat(values.PCGastosMaquila ? values.PCGastosMaquila : 0));
      var Maquila = round(parseFloat(GastosMaquila * (PorMaquila / 100)), 4);
      var PorAdm = Math.abs(parseFloat(values.PCGastosAdmin ? values.PCGastosAdmin : 0));
      var Adm = round(parseFloat(GastosAdmin * (PorAdm / 100)), 4);

      //configuraciones de la parte de fianza
      //formikRef.current.setFieldValue('PCGastosAdmin', parseFloat(PorAdm));
      formikRef.current.setFieldValue('CGastosMaquila', parseFloat(Maquila) * (TipoEndoso));
      formikRef.current.setFieldValue('CGastosAdmin', parseFloat(Adm) * (TipoEndoso));

      formikRef.current.setFieldValue('ComN', parseFloat(Comision) * (TipoEndoso));
      formikRef.current.setFieldValue('ComR', parseFloat(RecargosC) * (TipoEndoso));
      formikRef.current.setFieldValue('ComD', parseFloat(Derechos) * (TipoEndoso));
      formikRef.current.setFieldValue('Especial', parseFloat(Especial) * (TipoEndoso));
    } else {
      //var IVA = parseFloat(PNeta * 0.16);
      IVA = parseFloat(values.IVA ? values.IVA : 0);
      var Descuento = Math.abs(parseFloat(values.Descuento ? values.Descuento : 0));
      var Recargos = Math.abs(parseFloat(values.Recargos ? values.Recargos : 0));


      var PDescuento = ((Descuento * 100) / PNeta);
      var PRecargos = ((Recargos * 100) / PNeta);

      var PDerechos = round(((Derechos * 100) / PNeta), 4);


      //const SubTotal = parseFloat(Recargos) + parseFloat(PNeta) + parseFloat(Derechos) - parseFloat(Descuento);

      if (Modulo == "P") {
        SubTotal = parseFloat(Recargos) + parseFloat(PNeta) + parseFloat(Derechos) - parseFloat(Descuento);
      } else {
        SubTotal = parseFloat(PNeta) + parseFloat(Derechos) - parseFloat(Descuento) + parseFloat(GastosMaquila) + parseFloat(GastosAdmin);
      }

      if (Ramo == 4) {
        //IVA = parseFloat(0 * 0.16);
        //formikRef.current.setFieldValue('PorIVA', parseFloat(0));
      } else {
        //IVA = parseFloat(SubTotal * 0.16);

      }
      //Nuevo proceso
      if (valores == "IVA") {
        var PIVA = ((IVA * 100) / (SubTotal == 0 ? 1 : SubTotal));
      } else {
        var PIVA = values.PorIVA;
        IVA = round((PIVA / 100) * SubTotal, 4);
      }

      //var PIVA = ((IVA * 100) / (SubTotal == 0 ? 1 : SubTotal));
      var PTotal = round((Math.abs(SubTotal) + Math.abs(parseFloat(IVA)) + Math.abs(parseFloat(Ajuste))), 4);
      //formikRef.current.setFieldValue('Descuento', (Descuento) * (TipoEndoso));
      formikRef.current.setFieldValue('Recargos', Math.abs(Recargos) * (TipoEndoso));
      formikRef.current.setFieldValue('Descuento', (Descuento));
      formikRef.current.setFieldValue('IVA', parseFloat(Math.abs(IVA)) * (TipoEndoso));
      formikRef.current.setFieldValue('PorIVA', parseFloat(Math.abs(PIVA)));


      formikRef.current.setFieldValue('PDescuento', PDescuento); //* (TipoEndoso)
      formikRef.current.setFieldValue('PorDerechos', PDerechos); //* (TipoEndoso)
      formikRef.current.setFieldValue('PorRecargos', PRecargos); //* (TipoEndoso)
      formikRef.current.setFieldValue('STotal', round(SubTotal, 4) * (TipoEndoso));
      formikRef.current.setFieldValue('Ajuste', parseFloat(Ajuste) * (TipoEndoso));
      formikRef.current.setFieldValue('PrimaTotal', parseFloat(PTotal) * (TipoEndoso));
      //formikRef.current.setFieldValue('PorIVA', PIVA);
      //formikRef.current.setFieldValue('IVA', round(parseFloat(IVA), 2) * (TipoEndoso));

      var ComNeta = Math.abs(parseFloat(values.ComN ? values.ComN : 0));
      var PComNeta = round(((ComNeta * 100) / PNeta), 4);

      var ComRec = Math.abs(parseFloat(values.ComR ? values.ComR : 0));
      var PComRec = round(((ComRec * 100) / Recargos), 4);

      var ComDer = Math.abs(parseFloat(values.ComD ? values.ComD : 0));
      var PComDer = round(((ComDer * 100) / Derechos), 4);

      var Especial = Math.abs(parseFloat(values.Especial ? values.Especial : 0));
      var PEspecial = round(((Especial * 100) / PNeta), 4);

      var Maquila = Math.abs(parseFloat(values.CGastosMaquila ? values.CGastosMaquila : 0));
      var PMaquila = round(((Maquila * 100) / GastosMaquila), 4);

      var Adm = Math.abs(parseFloat(values.CGastosAdmin ? values.CGastosAdmin : 0));
      var PAdm = round(((Adm * 100) / GastosAdmin), 4);

      //Initial values
      var IPComNeta = values.PComN;
      var IPComRec = values.PComR;
      var IPComDer = values.PComD;
      var IPEspecial = values.PEspecial;
      var IPCGastosMaquila = values.PCGastosMaquila;
      var IPCGastosAdmin = values.PCGastosAdmin;

      formikRef.current.setFieldValue('CGastosMaquila', parseFloat(Maquila) * (TipoEndoso));
      formikRef.current.setFieldValue('CGastosAdmin', parseFloat(Adm) * (TipoEndoso));

      formikRef.current.setFieldValue('ComN', parseFloat(ComNeta) * (TipoEndoso));
      formikRef.current.setFieldValue('ComR', parseFloat(ComRec) * (TipoEndoso));
      formikRef.current.setFieldValue('ComD', parseFloat(ComDer) * (TipoEndoso));
      formikRef.current.setFieldValue('Especial', parseFloat(Especial) * (TipoEndoso));

      /* formikRef.current.setFieldValue('PComN', parseFloat(PComNeta) == 0 || isNaN(parseFloat(PComNeta)) ? parseFloat(IPComNeta) : PComNeta);
      formikRef.current.setFieldValue('PComR', parseFloat(PComRec) == 0 || isNaN(parseFloat(PComRec)) ? parseFloat(IPComRec) : PComRec);
      formikRef.current.setFieldValue('PComD', parseFloat(PComDer) == 0 || isNaN(parseFloat(PComDer)) ? parseFloat(IPComDer) : PComDer);
      formikRef.current.setFieldValue('PCGastosMaquila', parseFloat(PMaquila) == 0 || isNaN(parseFloat(PMaquila)) ? parseFloat(IPCGastosMaquila) : PMaquila);
      formikRef.current.setFieldValue('PCGastosAdmin', parseFloat(PAdm) == 0 || isNaN(parseFloat(PAdm)) ? parseFloat(IPCGastosAdmin) : PAdm); */
      formikRef.current.setFieldValue('PComN', parseFloat(PNeta) == 0 || isNaN(parseFloat(PNeta)) ? parseFloat(IPComNeta) : PComNeta);
      formikRef.current.setFieldValue('PComR', parseFloat(Recargos) == 0 || isNaN(parseFloat(Recargos)) ? parseFloat(IPComRec) : PComRec);
      formikRef.current.setFieldValue('PComD', parseFloat(Derechos) == 0 || isNaN(parseFloat(Derechos)) ? parseFloat(IPComDer) : PComDer);
      formikRef.current.setFieldValue('PEspecial', parseFloat(PNeta) == 0 || isNaN(parseFloat(PNeta)) ? parseFloat(IPEspecial) : PEspecial);
      formikRef.current.setFieldValue('PCGastosMaquila', parseFloat(GastosMaquila) == 0 || isNaN(parseFloat(GastosMaquila)) ? parseFloat(IPCGastosMaquila) : PMaquila);
      formikRef.current.setFieldValue('PCGastosAdmin', parseFloat(GastosAdmin) == 0 || isNaN(parseFloat(GastosAdmin)) ? parseFloat(IPCGastosAdmin) : PAdm);

    }
    //ReloadInd();

  }

  function ReloadInd() {
    const values = formikRef.current.values;

    //var RAjuste = (values.RAjuste ? Math.abs(parseFloat(values.RAjuste)) : 0) * TipoEndoso;
    var TipoEndoso = parseFloat(values.TipoE ? values.TipoE : 1);
    var PNeta = parseFloat(values.RPrimaNeta ? Math.abs(values.RPrimaNeta) : 0) * TipoEndoso;
    var Derechos = parseFloat(values.RDerechos ? Math.abs(values.RDerechos) : 0) * TipoEndoso;
    var Recargos = parseFloat(values.RRecargos ? Math.abs(values.RRecargos) : 0) * TipoEndoso;
    var Descuento = parseFloat(values.RDescuento ? Math.abs(values.RDescuento) : 0);
    var Maq = parseFloat(values.RGastosMaquila ? Math.abs(values.RGastosMaquila) : 0) * TipoEndoso;
    var Adm = parseFloat(values.RGatsosAdm ? Math.abs(values.RGatsosAdm) : 0) * TipoEndoso;
    var PIVA = parseFloat(values.PorIVA ? values.PorIVA : 0);

    const SubTotal = (parseFloat(Math.abs(PNeta)) + parseFloat(Math.abs(Recargos)) + parseFloat(Math.abs(Derechos)) + parseFloat(Math.abs(Maq)) + parseFloat(Math.abs(Adm))) - parseFloat(Math.abs(Descuento));

    var IVA = round((PIVA / 100) * Math.abs(SubTotal), 4);
    var PTotal = round(Math.abs(SubTotal) + parseFloat(Math.abs(IVA)) + parseFloat(Math.abs(values.RAjuste || 0)), 4);
    //Actualizmaos Prima
    formikRef.current.setFieldValue('RGastosMaquila', Maq);
    formikRef.current.setFieldValue('RGatsosAdm', Adm);
    formikRef.current.setFieldValue('RDerechos', Derechos);
    formikRef.current.setFieldValue('RPrimaNeta', PNeta);
    formikRef.current.setFieldValue('RDescuento', Descuento);
    formikRef.current.setFieldValue('RRecargos', Recargos);
    formikRef.current.setFieldValue('RSubTotal', SubTotal);
    formikRef.current.setFieldValue('RIVA', parseFloat(IVA));
    formikRef.current.setFieldValue('RAjuste', Math.abs(parseFloat(values.RAjuste || 0)) * TipoEndoso);
    formikRef.current.setFieldValue('RPrimaTotal', parseFloat(PTotal));
    //Actualizamos Comisiones
  }

  function ChangeValueRecibo(index, field, value, tipo = null) {
    const elm = [...recibos];
    elm[index][field] = value;
    let Algo = ReloadIndividual(elm[index], tipo);
    setRecibos(elm);
    //ReloadPrices();
  }

  function NewOrden() {
    window.location = `${UrlPagina}servicioSistema/EndosoAdd/${IdDoc}/${Modulo}`;
  }

  function AddRenovacion() {
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
          window.location = path + `servicioSistema/EndosoEdit/${IdDoc}/${IDnew}/${Modulo}`;

          toastr.success("Exíto");
        }
        ShowLoading(false);
      }
    });
  }

  function DeleteDocument() {
    var dta = {
      "Id": Id
    };

    swal({
      title: "¿Está seguro de que quiere eliminar el elemento seleccionado?",
      text: "Una vez eliminado, ¡no podrá recuperar el elemento!",
      icon: "warning",
      buttons: ["Cancelar", "Aceptar"],
    }).then((value) => {
      if (value) {
        ShowLoading();
        axios
          .post(`${UrlServicio}capture/deleteEndoso`, dta)
          .then(function (response) {
            toastr.success("Exíto");
            var locatonR = '';
            if (Modulo == 'F') {
              locatonR = path + 'servicioSistema/FianzaEdit/' + IdDoc;
            } else {
              locatonR = path + 'servicioSistema/OrdenTrabajoEdit/' + IdDoc;
            }
            window.location = locatonR;
            //window.location = path + 'servicioSistema/Fianza';
          })
          .catch(error => {
            toastr.error(`Error, intente mas tarde. ${error}`);
          });
        ShowLoading(false);
      }
    });

  }

  async function CopyDocumento() {
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
          Documento: formikRef.current.values.Documento,
          Modulo: 'E'
        };
        const res = await CallApiPost(`${UrlServicio}capture/copyDocumento`, dta, null);
        if (res.status != 200) {
          return toastr.error(`Error ${res.error.Mensaje}`);
        } else {
          var IDnew = res.success.Datos.IDDocto;
          window.location = path + `servicioSistema/EndosoEdit/${IdDoc}/${IDnew}/${Modulo}`;

          toastr.success("Exíto");
        }

        ShowLoading(false);
      }
    });


  }

  function OpenAction(Accion) {
    window.open(`${UrlPagina}servicioSistema/AccionPestana/${Id}/${Accion}/E`, 'newwindow', 'toolbar=no,menubar=no,scrollbars=yes,dialog=yes,resizable=no,width=400,height=450'); return false;
  }

  function ReloadIndividual(Array, Accion = null) {
    const valuesFormik = formikRef.current.values;

    var Ramo = parseFloat(state.InitialData.Referencia.IDSRamo ? state.InitialData.Referencia.IDSRamo : 0);
    const values = Array;
    var TipoEndoso = parseFloat(valuesFormik.TipoE ? valuesFormik.TipoE : 1);
    var PNeta = round(values.PrimaNeta ? Math.abs(values.PrimaNeta) : 0, 2) * (TipoEndoso);
    var Derechos = round(values.Derechos ? Math.abs(values.Derechos) : 0, 2) * (TipoEndoso);
    var GastosMaquila = round(values.GastosMaq ? Math.abs(values.GastosMaq) : 0, 2) * (TipoEndoso);
    var GastosAdmin = round(values.GastosAdm ? Math.abs(values.GastosAdm) : 0, 2) * (TipoEndoso);
    if (Accion == null) {
      //var PIVA = parseFloat(16);
      var PIVA = parseFloat(values.PorIVA ? values.PorIVA : 0);

      var PRecargos = parseFloat(values.PorRecargos ? values.PorRecargos : 0);
      var PDescuento = parseFloat(values.PDescuento ? values.PDescuento : 0);
      //Varibales calculables
      var Descuento = round((PNeta * (PDescuento / 100)), 2);
      var Recargos = round((PNeta * (PRecargos / 100)), 2);

      //const SubTotal = parseFloat(Recargos) + parseFloat(PNeta) + parseFloat(Derechos) - parseFloat(Descuento);
      const SubTotal = parseFloat(PNeta) + parseFloat(Derechos) + parseFloat(Recargos) - parseFloat(Descuento) + parseFloat(GastosMaquila) + parseFloat(GastosAdmin);
      var IVA = round(((PIVA / 100) * SubTotal), 2);
      var PTotal = round((SubTotal + parseFloat(IVA)), 2);
      //Actualizmaos Prima
      Array.PrimaNeta = round(PNeta, 2);
      Array.Descuento = round(Math.abs(Descuento), 2) * TipoEndoso;
      Array.Recargos = round(Recargos, 2);
      Array.SubTotal = round(SubTotal, 2);
      Array.IVA = parseFloat(IVA);
      Array.PrimaTotal = parseFloat(PTotal);
      Array.GastosMaq = round(GastosMaquila, 2);
      Array.GastosAdm = round(GastosAdmin, 2);
      //Actualizamos Comisiones
      var PorComincion = parseFloat(values.PComN ? values.PComN : 0);
      var Comision = round((PNeta * (PorComincion / 100)), 2) * (TipoEndoso);
      var PRecargos = parseFloat(values.PComR ? values.PComR : 0);
      var RecargosC = round((Recargos * (PRecargos / 100)), 2) * (TipoEndoso);//PorRecargos
      var PorDerechos = parseFloat(values.PComD ? values.PComD : 0);
      var DerechosT = round(parseFloat(Derechos * (PorDerechos / 100)), 2) * (TipoEndoso);
      var PorEspecial = parseFloat(values.PEspecial ? values.PEspecial : 0);
      var Especial = round(parseFloat(PNeta * (PorEspecial / 100)), 2) * (TipoEndoso);

      var PCGastosMaq = parseFloat(values.PCGastosMaq ? values.PCGastosMaq : 0);
      var CGastosMaq = round(parseFloat(GastosMaquila * (PCGastosMaq / 100)), 2) * (TipoEndoso);
      var PCGastosAdm = parseFloat(values.PCGastosAdm ? values.PCGastosAdm : 0);
      var CGastosAdm = round(parseFloat(GastosAdmin * (PCGastosAdm / 100)), 2) * (TipoEndoso);


      Array.ComN = parseFloat(Comision) * (TipoEndoso);
      Array.ComR = parseFloat(RecargosC) * (TipoEndoso);
      Array.ComD = parseFloat(DerechosT) * (TipoEndoso);
      Array.Especial = parseFloat(Especial) * (TipoEndoso);
      Array.CGastosMaq = parseFloat(CGastosMaq) * (TipoEndoso);
      Array.CGastosAdm = parseFloat(CGastosAdm) * (TipoEndoso);


    } else {

      var IVA = parseFloat(values.IVA ? values.IVA : 0);
      var Descuento = parseFloat(values.Descuento ? values.Descuento : 0);
      var Recargos = parseFloat(values.Recargos ? values.Recargos : 0);

      var PIVA = ((IVA * 100) / PNeta);
      var PDescuento = round(((Descuento * 100) / PNeta), 2);
      var PRecargos = round(((Recargos * 100) / PNeta), 2);

      const SubTotal = parseFloat(Recargos) + parseFloat(PNeta) + parseFloat(Derechos) - parseFloat(Descuento) + parseFloat(GastosMaquila) + parseFloat(GastosAdmin);
      var PTotal = (SubTotal + parseFloat(IVA)).toFixed(2);

      Array.PDescuento = PDescuento;
      Array.PorRecargos = PRecargos;
      Array.STotal = round(SubTotal, 2);
      Array.PrimaTotal = parseFloat(PTotal);
      Array.IVA = parseFloat(IVA).toFixed(2);

      var ComNeta = parseFloat(values.ComN ? values.ComN : 0);
      var PComNeta = round(((ComNeta * 100) / PNeta), 2);

      var ComRec = parseFloat(values.ComR ? values.ComR : 0);
      var PComRec = round(((ComRec * 100) / Recargos), 2);//CGastosMaq

      var ComDer = parseFloat(values.ComD ? values.ComD : 0);
      var PComDer = round(((ComDer * 100) / Derechos), 2);

      var Especial = parseFloat(values.Especial ? values.Especial : 0);
      var PEspecial = round(((Especial * 100) / PNeta), 2);

      var CGastosMaq = parseFloat(values.CGastosMaq ? values.CGastosMaq : 0);
      var PCGastosMaq = round(((CGastosMaq * 100) / GastosMaquila), 2);

      var CGastosAdm = parseFloat(values.CGastosAdm ? values.CGastosAdm : 0);
      var PCGastosAdm = round(((CGastosAdm * 100) / GastosAdmin), 2);

      Array.PComN = parseFloat(PComNeta);
      Array.PComR = parseFloat(PComRec);
      Array.PComD = parseFloat(PComDer);
      Array.PEspecial = parseFloat(PEspecial);
      Array.PCGastosMaq = parseFloat(Math.abs(PCGastosMaq));
      Array.PCGastosAdm = parseFloat(Math.abs(PCGastosAdm));

      //Array.CGastosMaq = parseFloat(CGastosMaq) * (TipoEndoso);
      //Array.CGastosAdm = parseFloat(CGastosAdm) * (TipoEndoso);

    }
    return values;

  }

  function ReloadAll(index, tipo) {
    const elm = [...recibos];
    var TipoEndoso = parseFloat(formikRef.current.values.TipoE ? formikRef.current.values.TipoE : 1);
    var PTotal = Math.abs(formikRef.current.values.PrimaNeta ? formikRef.current.values.PrimaNeta : 0);
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
        elm[idx]['PrimaNeta'] = round((Math.abs(PTotal) - Math.abs(PAcmu)) / (TotalRecibos), 2);
        elm[idx]['Recargos'] = round((Math.abs(RTotal) - Math.abs(RAcmu)) / (TotalRecibos), 2);
        elm[idx]['Derechos'] = round((Math.abs(RDerecho) - Math.abs(DAcmu)) / (TotalRecibos), 2) * TipoEndoso;
        elm[idx]['GastosMaq'] = round((Math.abs(TMaq) - Math.abs(MaqAcmu)) / (TotalRecibos), 2);
        elm[idx]['GastosAdm'] = round((Math.abs(Adm) - Math.abs(AdmAcmu)) / (TotalRecibos), 2);
        elm[idx] = ReloadIndividual(elm[idx], tipo);
      } else {
        PAcmu = PAcmu + round(parseFloat(elm[idx]['PrimaNeta']), 2);
        RAcmu = RAcmu + round(parseFloat(elm[idx]['Recargos']), 2);
        DAcmu = DAcmu + round(parseFloat(elm[idx]['Derechos']), 2);
        MaqAcmu = MaqAcmu + Math.abs(elm[idx]['GastosMaq'], 2) * (TipoEndoso);
        AdmAcmu = AdmAcmu + round(parseFloat(elm[idx]['GastosAdm']), 2);
      }

    }
    setRecibos(elm);
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
          Modulo: "E",
          SubModulo: Modulo,
          SubId: IdDoc
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
      toastr.success("Exíto");
    } else {
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


  //Métodos modificados
  function SaveRecibos() {
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
        text: "No se ha guardado la poliza.",
        icon: "warning",
        confirmButtonText: "Aceptar",
        confirmButtonColor: "#472380"
      });
    }
    ShowLoading();
    SetsendRecibos(true);

    var dta = {
      "data": recibos,
      "Id": Id
    };
    axios
      .post(`${UrlServicio}capture/saveRecibos`, dta)
      .then(function (response) {

        setRecibos(response.data.Datos);
        CreateFolderRef();
        toastr.success("Exíto");
      })
      .catch(error => {
        toastr.error("Error, intente mas tarde.");
      });
    SetIsChange(false);
    SetsendRecibos(false);
    setTimeout(() => {
      ShowLoading(false);
    }, 1000);
  }

  function ChangeEdit(index) {
    SetIndexRecibo(index);
    const elm = [...recibos];
    elm[index].IsEdit = !elm[index].IsEdit;
    const values = formikRef.current.values;
    setRecibos(elm);
    SetItemRecibo(elm[index]);
    SetItemInfoRecibo(ordenTrabajo.InfoRecibos);
    let itemCopia = { ...elm[index] };
    setItemSelected(itemCopia);

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
    if (parseFloat(values.PrimaNeta) == 0 || values.PrimaNeta === null) {
      return swal({
        title: "Llenar información",
        text: "No se ha ingresado el campo : P Neta ",
        icon: "warning",
        confirmButtonText: "Aceptar",
        confirmButtonColor: "#472380"
      });
    }
    if (parseFloat(values.RPrimaNeta) == 0 || values.RPrimaNeta === null) {
      return swal({
        title: "Llenar información",
        text: "No se ha ingresado el campo : P Neta del primer recibo.",
        icon: "warning",
        confirmButtonText: "Aceptar",
        confirmButtonColor: "#472380"
      });
    }

    ShowLoading();

    let dataPost = {
      CiaNombre: state.InitialData.Referencia.CiaNombre || "",
    }

    //Verificar si los descuentos, recargos y derechos son proporcionales
    const res = await CallApiPost(`${UrlServicio}catalogos/getCompaniaByNombre`, dataPost, null);
    let companiaSeleccionada = res.success.Datos || null;

    var aplicacionDerechos = companiaSeleccionada && companiaSeleccionada.AplicacionDerechos ? companiaSeleccionada.AplicacionDerechos : "1";
    var aplicacionDescuentos = companiaSeleccionada && companiaSeleccionada.AplicacionDescuentos ? companiaSeleccionada.AplicacionDescuentos : "2";
    var aplicacionRecargos = companiaSeleccionada && companiaSeleccionada.AplicacionRecargos ? companiaSeleccionada.AplicacionRecargos : "2";

    //Filtramos los recibos que esten en el rango de fechas
    var AllR = [...state.InitialData.TotalRecibos];
    var countF = [];
    const FindIdx = AllR.findIndex(x => moment(x.FDesde).startOf('month').format('YYYYMMDD') === moment(values.FDesde).startOf('month').format('YYYYMMDD'));
    AllR.forEach((element, idx) => {
      if (idx >= FindIdx) {
        countF.push(element);
      }
      /* if (values.FHasta >= element.FHasta) {
        countF.push(element);
      } */
      /* if (moment(element.FDesde).isBetween(values.FDesde, values.FHasta)) {
        countF.push(element);
      } */
    });

    var Npagos = countF.length;
    var FDesde = values.FDesde;
    var TipoEndoso = parseFloat(values.TipoE ? values.TipoE : 1);
    var PNeta = Math.abs(parseFloat(values.PrimaNeta ? values.PrimaNeta : 0)) * TipoEndoso;
    var Calculo = calculatePagos(values.FDesde, values.FHasta, Npagos);
    //var PIVA = parseFloat(values.PorIVA ? values.PorIVA : 0);
    var PIVA = Math.abs(parseFloat(values.PorIVA ? values.PorIVA : 16));
    var PNetaRecibo = round((PNeta / Npagos), 4);
    var Rec = parseFloat(values.Recargos ? Math.abs(values.Recargos) : 0) - Math.abs(values.RRecargos);
    var Recargos = round((Rec / (Npagos - 1)), 4);
    var PRecargos = parseFloat(values.PorRecargos ? Math.abs(values.PorRecargos) : 0);
    var Derechos = parseFloat(values.Derechos ? Math.abs(values.Derechos) - Math.abs(values.RDerechos) : 0) * TipoEndoso;
    var DerechosI = parseFloat(values.Derechos ? Math.abs(values.Derechos) : 0) - Math.abs(values.RDerechos);
    var DerechosAll = round((DerechosI / (Npagos - 1)), 4);
    var AjusteTotal = parseFloat(values.Ajuste ? Math.abs(values.Ajuste) - Math.abs(values.RAjuste) : 0);
    var Descuento = parseFloat(values.Descuento ? Math.abs(values.Descuento) - Math.abs(values.RDescuento) : 0);
    var PorDescuento = parseFloat(values.PDescuento ? values.PDescuento : 0);
    var TotalRecargo = parseFloat(values.Recargos ? Math.abs(values.Recargos) - Math.abs(values.RRecargos) : 0);
    var IVATotal = parseFloat(values.IVA ? Math.abs(values.IVA) - Math.abs(values.RIVA) : 0);

    //var PRecIA = round((Recargos * 100) / (values.Recargos ? values.Recargos : 0), 2);
    //
    var SubTotal = 0;
    var IVA = 0;
    var PrimaTotal = 0;
    var GastosMaquila = (Math.abs(parseFloat(values.GastosMaquila ? Math.abs(values.GastosMaquila) - Math.abs(values.RGastosMaquila) : 0)));
    var GastosAdmin = (Math.abs(parseFloat(values.GastosAdmin ? Math.abs(values.GastosAdmin) - Math.abs(values.RGatsosAdm) : 0)));

    var GastosMaqInd = (Math.abs(parseFloat(values.RGastosMaquila ? values.RGastosMaquila : 0)));
    var GastosMaqFull = Math.abs(values.GastosMaquila ? values.GastosMaquila : 0);
    var GastosMaqAll = round((GastosMaqFull - GastosMaqInd) / (Npagos - 1), 4);

    var PRRec = Math.abs(values.PrimaNeta) - Math.abs(values.RPrimaNeta);
    var FinalPN = ((PRRec) / (Npagos - 1));

    var DerechoProporcional = Math.abs(Derechos) / (Npagos - 1);
    var DescuentoProporcional = Math.abs(Descuento) / (Npagos - 1);
    var RecargosProporcional = Math.abs(TotalRecargo) / (Npagos - 1);
    var AjusteProporcional = Math.abs(AjusteTotal) / (Npagos - 1);
    var IVAProporcional = Math.abs(IVATotal) / (Npagos - 1);
    var GastosMaquilaProporcional = Math.abs(GastosMaquila) / (Npagos - 1);
    var GastosAdmProporcional = Math.abs(GastosAdmin) / (Npagos - 1);

    console.log("NPAgos", Npagos);
    

    let SumTotal = 0;
    let SumPTotal = 0;
    for (let index = 0; index < Npagos; index++) {

      var PRecIA = round(((index == 0 ? values.RRecargos : Recargos) * 100) / (values.Recargos ? values.Recargos : 0), 4);
      var PRecI = round((values.RRecargos * 100) / (index == 0 ? values.RPrimaNeta : round(FinalPN, 4)), 4);
      var Findex = index + 1;
      if (index == 0) {
        SubTotal = Math.abs(parseFloat(Math.abs(values.RPrimaNeta)))
          + parseFloat(aplicacionRecargos == "1" ? Math.abs(TotalRecargo + values.RRecargos) : Math.abs(values.RRecargos))
          + parseFloat(aplicacionDerechos == "1" ? Math.abs(Derechos + values.RDerechos) : Math.abs(values.RDerechos))
          + parseFloat(Math.abs(values.RGastosMaquila)) + parseFloat(Math.abs(values.RGatsosAdm))
          - parseFloat(aplicacionDescuentos == "1" ? Math.abs(Descuento + values.RDescuento) : Math.abs(values.RDescuento));//+ parseFloat(GastosMaquila.toFixed(2)) + parseFloat(GastosAdmin.toFixed(2))
      } else {
        SubTotal = parseFloat(Math.abs(FinalPN))
          + parseFloat(aplicacionRecargos == "1" ? 0 : Math.abs(RecargosProporcional)) /* parseFloat(Recargos) */
          + parseFloat(aplicacionDerechos == "1" ? 0 : Math.abs(DerechosAll)) /* (Math.abs(DerechosAll) * TipoEndoso) */
          + parseFloat(Math.abs(GastosMaquilaProporcional)) + parseFloat(Math.abs(GastosAdmProporcional))
          - parseFloat(aplicacionDescuentos == "1" ? 0 : Math.abs(DescuentoProporcional));//+ parseFloat(GastosMaquila.toFixed(2)) + parseFloat(GastosAdmin.toFixed(2))
      }

      IVA = round(Math.abs(SubTotal) * (Math.abs(PIVA) / 100), 4);
      PrimaTotal = Math.abs(SubTotal) + (index == 0 ? parseFloat(Math.abs(values.RIVA)) : parseFloat(Math.abs(IVAProporcional)))
        + (index == 0 && Math.abs(values.RAjuste || 0) > 0 ? Math.abs(parseFloat(values.RAjuste || 0)) : Math.abs(parseFloat(AjusteProporcional || 0)));

      var Com = Math.abs(index == 0 ? values.RPrimaNeta : round(FinalPN, 4));
      var ComR = + parseFloat(Recargos);
      var TotalCom = round(Com * (values.PComN / 100), 4);
      var TotalComR = round(ComR * (values.PComR / 100), 4);

      var ComisionNeta = round(parseFloat(Math.abs(PNetaRecibo) * (Math.abs(values.PComN) / 100)), 4);
      var ComisionRecargos = round(parseFloat(Math.abs(TotalRecargo) * (Math.abs(values.PComR) / 100)), 4);
      var ComisionRecargosProporcional = round(parseFloat(Math.abs(values.ComR) / Npagos), 4)
      var ComisionDerechos = round(parseFloat((aplicacionDerechos == "1" ? index == 0 ? Math.abs(Derechos) + Math.abs(values.RDerechos) : 0 : aplicacionDerechos == "2" ? Math.abs(values.RDerechos) : Math.abs(DerechoProporcional)) * (Math.abs(values.PComD) / 100)), 4);
      var ComisionDerechosProporcional = round(parseFloat(Math.abs(values.ComD) / Npagos), 4)
      var ComisionEspecial = round(parseFloat(Math.abs(PNetaRecibo) * (Math.abs(values.PEspecial) / 100)), 4);

      //var PCGastosMaq = parseFloat(values.PCGastosMaquila ? values.PCGastosMaquila : 0) / 100;
      var PCGastosMaq = parseFloat(values.PCGastosMaquila ? values.PCGastosMaquila : 0);
      var CGastosMaq = round((index == 0 ? GastosMaqInd : GastosMaqAll) * (PCGastosMaq), 4);
      //var PCGastosAdm = parseFloat(values.PCGastosAdmin ? values.PCGastosAdmin : 0) / 100;
      var PCGastosAdm = parseFloat(values.PCGastosAdmin ? values.PCGastosAdmin : 0);
      var CGastosAdm = parseFloat(GastosAdmin * (PCGastosAdm)).toFixed(2);

      var PCDer = parseFloat(values.PComD ? values.PComD : 0);
      var TotalCDer = round((index == 0 ? values.RDerechos : DerechosAll) * (PCDer / 100), 4);

      var Hasta = moment(FDesde).add(((Calculo.Add) * (index + 1)), Calculo.Action);
      let RFHasta = countF[index].FHasta;
      let DesdeF = index == 0 ? moment(FDesde).add(((Calculo.Add) * index), Calculo.Action).format('YYYYMMDD') : countF[index].FDesde;
      let DiasPrimerRecibo = state.InitialData.Compania.DPPRN ? state.InitialData.Compania.DPPRN : null;
      let DiasSegundoRecibo = state.InitialData.Compania.DPRSN ? state.InitialData.Compania.DPRSN : null;

      recibos.push({
        IDTemp: 0,
        IDDocto: IdDoc,
        IDEnd: Id,
        Documento: ordenTrabajo.OT.Documento,
        FCreacion: moment(FDesde).format('YYYYMMDD'),
        FDesde: index == 0 ? moment(FDesde).add(((Calculo.Add) * index), Calculo.Action).format('YYYYMMDD') : countF[index].FDesde,
        FHasta: RFHasta,
        FGeneracion: moment().format('YYYYMMDD'),
        FLimPago: index == 0 ?
          moment(DesdeF).add(DiasPrimerRecibo != null ? DiasPrimerRecibo : 0, 'Days').format('YYYYMMDD')
          :
          moment(recibos[recibos.length - 1].FLimPago ? recibos[recibos.length - 1].FLimPago : undefined).add(DiasSegundoRecibo != null ? DiasSegundoRecibo : (DiasPrimerRecibo == null ? 0 : DiasPrimerRecibo), 'Days').format('YYYYMMDD'),
        //moment(DesdeF).add(DiasSegundoRecibo != null ? DiasSegundoRecibo : (DiasPrimerRecibo == null ? 0 : DiasPrimerRecibo), 'Days').format('YYYYMMDD'),
        Periodo: countF[index].Periodo,
        Serie: countF[index].Serie,
        PrimaNeta: index == 0 ? Math.abs(values.RPrimaNeta) * TipoEndoso : round(Math.abs(FinalPN) * TipoEndoso, 4),
        Descuento: aplicacionDescuentos == "1" ? index == 0 ? (Math.abs(Descuento) + Math.abs(values.RDescuento)) : 0 : aplicacionDescuentos == "2" && index == 0 ? Math.abs(values.RDescuento) : Math.abs(DescuentoProporcional), //Dividir
        PDescuento: round(aplicacionDescuentos == "1" ? index == 0 ? Math.abs(PorDescuento) : 0 : aplicacionDescuentos == "2" && index == 0 ? (parseFloat(Math.abs(values.RDescuento)) / parseFloat(Math.abs(values.RPrimaNeta))) * 100 : (parseFloat(Math.abs(DescuentoProporcional)) / parseFloat(Math.abs(FinalPN))) * 100, 4),
        //PDescuento: aplicacionDescuentos == "1" ? index == 0 ? PorDescuento : 0 : aplicacionDescuentos == "2" && PorDescuento,
        Recargos: aplicacionRecargos == "1" ? index == 0 ? (Math.abs(TotalRecargo) + Math.abs(values.RRecargos)) * TipoEndoso : 0 : aplicacionRecargos == "2" && index == 0 ? Math.abs(values.RRecargos) * TipoEndoso : Math.abs(RecargosProporcional) * TipoEndoso, //Dividir
        PorRecargos: round(aplicacionRecargos == "1" ? index == 0 ? Math.abs(PRecargos) : 0 : aplicacionRecargos == "2" && index == 0 ? (parseFloat(Math.abs(values.RRecargos)) / parseFloat(Math.abs(values.RPrimaNeta))) * 100 : (parseFloat(Math.abs(RecargosProporcional)) / parseFloat(Math.abs(FinalPN))) * 100, 4),
        Derechos: aplicacionDerechos == "1" ? index == 0 ? Math.abs(Derechos) + Math.abs(values.RDerechos) * TipoEndoso : 0 : aplicacionDerechos == "2" && index == 0 ? Math.abs(values.RDerechos) * TipoEndoso : Math.abs(DerechoProporcional) * TipoEndoso, //index == 0 ? Derechos : 0, //Dividir
        SubTotal: round(Math.abs(SubTotal) * TipoEndoso, 4),
        IVA: round(index == 0 ? Math.abs(values.RIVA) * TipoEndoso : parseFloat(Math.abs(IVAProporcional) * TipoEndoso), 4),
        PorIVA: round(index == 0 ? ((parseFloat(Math.abs(values.RIVA)) / parseFloat(Math.abs(SubTotal))) * 100) : ((parseFloat(Math.abs(IVAProporcional)) / parseFloat(Math.abs(SubTotal))) * 100), 4),
        //PorIVA: PIVA,
        Ajuste: index == 0 && Math.abs(values.RAjuste || 0) > 0 ? parseFloat(Math.abs(values.RAjuste || 0)) * TipoEndoso : parseFloat(Math.abs(AjusteProporcional || 0)) * TipoEndoso,
        AjusteAnterior: index == 0 && Math.abs(values.RAjuste) > 0 ? parseFloat(Math.abs(values.RAjuste || 0)) * TipoEndoso : parseFloat(Math.abs(AjusteProporcional || 0)) * TipoEndoso,
        PrimaTotal: round(Math.abs(PrimaTotal) * TipoEndoso, 4),
        IsEdit: false,

        ComN: index == 0 ? (parseFloat(Math.abs(values.RPrimaNeta)) * Math.abs(values.PComN) / 100) * TipoEndoso : (parseFloat(Math.abs(FinalPN)) * Math.abs(values.PComN) / 100) * TipoEndoso,
        PComN: values.PComN,

        ComR: aplicacionRecargos == "1" ? index == 0 ? ((Math.abs(TotalRecargo) + Math.abs(values.RRecargos)) * Math.abs(values.PComR) / 100) * TipoEndoso /* parseFloat(ComisionRecargos) * TipoEndoso */ : 0 : aplicacionRecargos == "2" && index == 0 ? (Math.abs(values.RRecargos) * Math.abs(values.PComR) / 100) * TipoEndoso : (Math.abs(RecargosProporcional) * Math.abs(values.PComR) / 100) * TipoEndoso,
        PComR: aplicacionRecargos == "1" ? index == 0 ? Math.abs(values.PComR) : 0 : aplicacionRecargos == "2" && Math.abs(values.PComR),
        ComD: aplicacionDerechos == "1" ? index == 0 ? /* parseFloat(Math.abs(ComisionDerechos)) */ (Math.abs(Derechos) + Math.abs(values.RDerechos) * Math.abs(values.PComD) / 100) * TipoEndoso : 0 : aplicacionDerechos == "2" && index == 0 ? (Math.abs(values.RDerechos) * Math.abs(values.PComD) / 100) * TipoEndoso : (Math.abs(DerechoProporcional) * Math.abs(values.PComD) / 100) * TipoEndoso,
        PComD: aplicacionDerechos == "1" ? index == 0 ? Math.abs(values.PComD) : 0 : aplicacionDerechos == "2" && Math.abs(values.PComD),
        Especial: index == 0 ? (parseFloat(Math.abs(values.RPrimaNeta)) * Math.abs(values.PEspecial) / 100) * TipoEndoso : (parseFloat(Math.abs(FinalPN)) * Math.abs(values.PEspecial) / 100) * TipoEndoso,
        PEspecial: Math.abs(values.PEspecial),
        Status_TXT: "Pendiente",
        Modulo: 'E',

        GastosMaq: index == 0 ? parseFloat(Math.abs(values.RGastosMaquila) * TipoEndoso) : parseFloat(Math.abs(GastosMaquilaProporcional) * TipoEndoso), //index == 0 ? round(GastosMaqInd * TipoEndoso, 4) : round(GastosMaqAll * TipoEndoso, 4),
        GastosAdm: index == 0 ? parseFloat(Math.abs(values.RGatsosAdm) * TipoEndoso) : parseFloat(Math.abs(GastosAdmProporcional) * TipoEndoso), //round(GastosAdmin, 4),

        CGastosMaq: index == 0 ? parseFloat(Math.abs(values.RGastosMaquila) * Math.abs(PCGastosMaq) / 100) * TipoEndoso : parseFloat((Math.abs(GastosMaquilaProporcional) * Math.abs(PCGastosMaq) / 100) * TipoEndoso), //CGastosMaq * TipoEndoso,
        PCGastosMaq: PCGastosMaq, //(PCGastosMaq) * 100,
        CGastosAdm: index == 0 ? parseFloat(Math.abs(values.RGatsosAdm) * Math.abs(PCGastosAdm) / 100) * TipoEndoso : parseFloat((Math.abs(GastosAdmProporcional) * Math.abs(PCGastosAdm) / 100) * TipoEndoso), //CGastosAdm * TipoEndoso,
        PCGastosAdm: PCGastosAdm, //(PCGastosAdm) * 100,

      });

      SumTotal += round(Math.abs(PrimaTotal), 4);
      SumPTotal += round(index == 0 ? Math.abs(values.RPrimaNeta) : round(Math.abs(FinalPN), 4), 4);
    }

    let result = (values.PrimaTotal) - (SumTotal);
    let result2 = (values.PrimaNeta) - (SumPTotal);
    if (recibos.length > 0) {
      /* if (result > 0) {
        recibos[0].PrimaTotal = recibos[0].PrimaTotal + Math.abs(result);
        recibos[0].PrimaNeta = recibos[0].PrimaNeta + Math.abs(result2);
      } else {
        recibos[0].PrimaTotal = recibos[0].PrimaTotal - Math.abs(result);
        recibos[0].PrimaNeta = recibos[0].PrimaNeta - Math.abs(result2);
      } */
    }

    setRecibos(recibos);
    ShowLoading(false);
  }

  function NuevoRecibo() {
    var recibosC = [...recibos];
    const values = formikRef.current.values;
    //const NumRecibos = values.NPagos;

    var AllR = [...state.InitialData.TotalRecibos];
    var countF = [];
    const FindIdx = AllR.findIndex(x => moment(x.FDesde).startOf('month').format('YYYYMMDD') === moment(values.FDesde).startOf('month').format('YYYYMMDD'));
    AllR.forEach((element, idx) => {
      if (idx >= FindIdx) {
        countF.push(element);
      }
    });

    var NumRecibos = countF.length;

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
    if (parseFloat(Math.abs(values.PrimaNeta)) <= 0 || Math.abs(values.PrimaNeta) === null) {
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
        title: "El limite de recibos alcanzado.",
        text: "Ya no se pueden agregar mas rrecibos.",
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
    var Recargos = (Rec / Npagos).toFixed(2);
    var PRecargos = parseFloat(values.PorRecargos ? values.PorRecargos : 0);
    var Derechos = parseFloat(values.Derechos ? values.Derechos : 0);
    var PorDescuento = parseFloat(values.PDescuento ? values.PDescuento : 0);

    //var SubTotal = PNeta + Recargos + Derechos;
    //var IVA = SubTotal * (PIVA / 100);
    //var PrimaTotal = SubTotal + IVA;
    var SubTotal = 0;
    var IVA = 0;
    var PrimaTotal = 0;
    var GastosMaquila = parseFloat(values.GastosMaquila ? values.GastosMaquila : 0) / Npagos;
    var GastosAdmin = parseFloat(values.GastosAdmin ? values.GastosAdmin : 0) / Npagos;

    /* if (recibosC.length == 0) {
      SubTotal = parseFloat(PNetaRecibo) + parseFloat(Recargos) + parseFloat(Derechos);
    } else {
      SubTotal = parseFloat(PNetaRecibo);
    } */

    /* IVA = (SubTotal * (PIVA / 100)).toFixed(2);
    PrimaTotal = SubTotal + parseFloat(IVA); */
    var Com = parseFloat(PNetaRecibo);
    var ComR = + parseFloat(Recargos);
    var TotalCom = parseFloat(Com * (values.PComNeta / 100)).toFixed(2);
    var TotalComR = parseFloat(ComR * (values.PComRec / 100)).toFixed(2);

    var PCGastosMaq = parseFloat(values.CGastosMaquila ? values.CGastosMaquila : 0) / 100;
    var CGastosMaq = parseFloat(GastosMaquila * (PCGastosMaq)).toFixed(2);
    var PCGastosAdm = parseFloat(values.PCGastosAdmin ? values.PCGastosAdmin : 0) / 100;
    var CGastosAdm = parseFloat(GastosAdmin * (PCGastosAdm)).toFixed(2);
    let DiasPrimerRecibo = state.InitialData.Compania.DPPRN ? state.InitialData.Compania.DPPRN : null;
    let DiasSegundoRecibo = state.InitialData.Compania.DPRSN ? state.InitialData.Compania.DPRSN : null;
        
    var Calculo = calculatePagos(values.FDesde, values.FHasta, Npagos);
    var UltimoRecibo = recibosC.length > 0 ? recibosC[recibosC.length - 1] : null;
    var HastaUltRecibo = UltimoRecibo != null ? moment(UltimoRecibo && UltimoRecibo.FHasta ? UltimoRecibo.FHasta : values.FHasta).add(3, "month").format('YYYYMMDD') : moment().format('YYYYMMDD');
    var DesdeF = moment(FDesde).add(((Calculo.Add) * (recibosC.length > 0 ? recibosC.length : 0)), Calculo.Action).format('YYYYMMDD');    

    recibosC.push({
      IDTemp: 0,
      IDDocto: IdDoc,
      IDEnd: Id,
      Documento: ordenTrabajo.OT.Documento,
      FCreacion: moment(FDesde).format('YYYYMMDD'),
      FDesde: (recibosC.length) == 0 ? moment(DesdeF).format('YYYYMMDD') : UltimoRecibo && UltimoRecibo.FHasta ? UltimoRecibo.FHasta : values.Fesde,
      FHasta: (recibosC.length) == 0 ? moment(DesdeF).format('YYYYMMDD') : HastaUltRecibo,
      //FDesde: moment(FDesde).add(recibosC.length + 1, 'M').format('YYYYMMDD'),
      //FHasta: moment(FDesde).add(recibosC.length + 2, 'M').format('YYYYMMDD'),
      FGeneracion: moment().format('YYYYMMDD'),
      FLimPago: (recibosC.length - 1) == 0 ?
        moment(DesdeF).add(DiasPrimerRecibo != null ? DiasPrimerRecibo : 0, 'Days').format('YYYYMMDD')
        :
        moment(recibos.length > 0 ? recibos[recibos.length - 1].FLimPago : undefined).add(DiasSegundoRecibo != null ? DiasSegundoRecibo : (DiasPrimerRecibo == null ? 0 : DiasPrimerRecibo), 'Days').format('YYYYMMDD'),
      //moment(FDesde).add(recibosC.length + 2, 'M').format('YYYYMMDD'),
      Periodo: recibosC.length + 1,
      Serie: `0${recibosC.length + 1}/0${recibosC.length + 1}`,
      PrimaNeta: 0,
      Descuento: 0,
      PDescuento: PorDescuento,
      GastosMaq: 0,
      GastosAdm: 0,
      Recargos: 0,
      PorRecargos: PRecargos,
      Derechos: 0,
      SubTotal: SubTotal,
      IVA: IVA,
      PorIVA: PIVA,
      Ajuste: 0,
      PrimaTotal: PrimaTotal,
      IsEdit: false,

      ComN: 0,
      PComN: values.PComN,

      ComR: 0,
      PComR: values.PComR,
      ComD: 0,
      PComD: values.PComD,
      Especial: 0,
      PEspecial: values.PEspecial,
      Status_TXT: "Pendiente",
      Modulo: 'E',

      CGastosMaq: 0,
      PCGastosMaq: (PCGastosMaq) * 100,
      CGastosAdm: 0,
      PCGastosMaq: (PCGastosAdm) * 100,
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
    const values = formikRef.current.values;
    var TipoEndoso = parseFloat(values.TipoE ? values.TipoE : 1);

    let _recibos = [...recibos];

    if (field == "FDesde") {
      _recibos[index][field] = value;
    }
    else if (field == "FHasta") {
      _recibos[index][field] = value;
    }
    else if (field == "FGeneracion") {
      _recibos[index][field] = value;
    }
    else if (field == "FLimPago") {
      _recibos[index][field] = value;
    }
    else {
      _recibos[index][field] = field != "Descuento" && field != "PDescuento" && field != "PorRecargos" && field != "PorIVA" && field != "PComN" && field != "PComR" && field != "PComD" && field != "PEspecial" && TipoEndoso == -1 ? "-" + value : value;
    }

    if (field == "PrimaNeta") {

      let descuento = parseFloat(Math.abs(value) * Math.abs(_recibos[index].PDescuento) / 100);
      let recargos = parseFloat(Math.abs(value) * Math.abs(_recibos[index].PorRecargos) / 100);
      let subtotal = (parseFloat(Math.abs(value)) + Math.abs(_recibos[index].GastosMaq) + Math.abs(_recibos[index].GastosAdm) + parseFloat(Math.abs(_recibos[index].Derechos)) + parseFloat(Math.abs(value) * Math.abs(_recibos[index].PorRecargos) / 100)) - parseFloat(Math.abs(value) * Math.abs(_recibos[index].PDescuento) / 100);
      let iva = round(parseFloat(Math.abs(subtotal) * Math.abs(_recibos[index].PorIVA) / 100), 4);
      let total = round(parseFloat(Math.abs(subtotal) + Math.abs(iva) + parseFloat(Math.abs(_recibos[index].Ajuste))), 4);
      let comN = round(parseFloat(Math.abs(value) * Math.abs(_recibos[index].PComN) / 100), 4);
      let especial = round(parseFloat(Math.abs(value) * Math.abs(_recibos[index].PEspecial) / 100), 4);
      let comR = round(parseFloat(Math.abs(recargos) * Math.abs(_recibos[index].PComR) / 100), 4);

      _recibos[index].Descuento = descuento;
      _recibos[index].Recargos = recargos * TipoEndoso;
      _recibos[index].IVA = iva * TipoEndoso;
      _recibos[index].SubTotal = subtotal * TipoEndoso;
      _recibos[index].PrimaTotal = total * TipoEndoso;

      _recibos[index].ComN = comN * TipoEndoso;
      _recibos[index].ComR = comR * TipoEndoso;
      _recibos[index].Especial = especial * TipoEndoso;
    }
    else if (field == "Descuento") {

      let pDescuento = round(parseFloat(Math.abs(value) / Math.abs(_recibos[index].PrimaNeta) * 100), 4);
      let subtotal = round((parseFloat(Math.abs(_recibos[index].PrimaNeta)) + Math.abs(_recibos[index].GastosMaq) + Math.abs(_recibos[index].GastosAdm) + parseFloat(Math.abs(_recibos[index].Derechos)) + parseFloat(Math.abs(_recibos[index].PrimaNeta) * Math.abs(_recibos[index].PorRecargos) / 100)) - parseFloat(Math.abs(value)), 4);
      let total = round(parseFloat(Math.abs(subtotal)) + parseFloat(Math.abs(_recibos[index].IVA) + Math.abs(parseFloat(_recibos[index].Ajuste))), 4);

      _recibos[index].PDescuento = pDescuento;
      _recibos[index].SubTotal = subtotal * TipoEndoso;
      _recibos[index].PrimaTotal = total * TipoEndoso;
    }
    else if (field == "PDescuento") {

      let descuento = round(parseFloat(Math.abs(_recibos[index].PrimaNeta) * Math.abs(value) / 100), 4);
      let subtotal = round((parseFloat(Math.abs(_recibos[index].PrimaNeta)) + Math.abs(_recibos[index].GastosMaq) + Math.abs(_recibos[index].GastosAdm) + parseFloat(Math.abs(_recibos[index].Derechos)) + parseFloat(Math.abs(_recibos[index].PrimaNeta) * Math.abs(_recibos[index].PorRecargos) / 100)) - parseFloat(Math.abs(_recibos[index].PrimaNeta) * Math.abs(value) / 100), 4);
      //let total = round((parseFloat(_recibos[index].PrimaNeta) + parseFloat(_recibos[index].Derechos) + parseFloat(_recibos[index].PrimaNeta * _recibos[index].PorRecargos / 100)) - parseFloat(_recibos[index].PrimaNeta * value / 100) + parseFloat(_recibos[index].PrimaNeta * _recibos[index].PorIVA / 100), 4);
      let total = round(parseFloat(Math.abs(subtotal) + Math.abs(_recibos[index].IVA) + parseFloat(Math.abs(_recibos[index].Ajuste))), 4);

      _recibos[index].Descuento = descuento;
      _recibos[index].SubTotal = subtotal * TipoEndoso;
      _recibos[index].PrimaTotal = total * TipoEndoso;
    }
    else if (field == "GastosMaq") {

      let subtotal = (parseFloat(Math.abs(_recibos[index].PrimaNeta)) + parseFloat(Math.abs(value)) + parseFloat(Math.abs(_recibos[index].GastosAdm)) + parseFloat(Math.abs(_recibos[index].Derechos))) - parseFloat(Math.abs(_recibos[index].PrimaNeta) * Math.abs(_recibos[index].PDescuento) / 100);
      let iva = round(parseFloat(Math.abs(subtotal) * Math.abs(_recibos[index].PorIVA) / 100), 4)
      let total = round(parseFloat(Math.abs(subtotal) + (Math.abs(subtotal) * Math.abs(_recibos[index].PorIVA) / 100)), 4);

      let cGastosMaq = round(parseFloat(Math.abs(value) * Math.abs(_recibos[index].PCGastosMaq) / 100), 4);

      _recibos[index].SubTotal = subtotal * TipoEndoso;
      _recibos[index].IVA = iva * TipoEndoso;
      _recibos[index].PrimaTotal = total * TipoEndoso;

      _recibos[index].CGastosMaq = cGastosMaq * TipoEndoso;
    }
    else if (field == "GastosAdm") {

      let subtotal = (parseFloat(Math.abs(_recibos[index].PrimaNeta)) + parseFloat(Math.abs(_recibos[index].GastosMaq)) + parseFloat(Math.abs(value)) + parseFloat(Math.abs(_recibos[index].Derechos))) - parseFloat(Math.abs(_recibos[index].PrimaNeta) * Math.abs(_recibos[index].PDescuento) / 100);
      let iva = round(parseFloat(Math.abs(subtotal) * Math.abs(_recibos[index].PorIVA) / 100), 4)
      let total = round(parseFloat(Math.abs(subtotal) + (Math.abs(subtotal) * Math.abs(_recibos[index].PorIVA) / 100)), 4);

      let cGastosAdm = round(parseFloat(Math.abs(value) * Math.abs(_recibos[index].PCGastosAdm) / 100), 4);

      _recibos[index].SubTotal = subtotal * TipoEndoso;
      _recibos[index].IVA = iva * TipoEndoso;
      _recibos[index].PrimaTotal = total * TipoEndoso;

      _recibos[index].CGastosAdm = cGastosAdm * TipoEndoso;
    }
    else if (field == "Recargos") {

      let pRecargos = round(parseFloat(Math.abs(value) / Math.abs(_recibos[index].PrimaNeta) * 100), 4);
      let subtotal = round((parseFloat(Math.abs(_recibos[index].PrimaNeta)) + Math.abs(_recibos[index].GastosMaq) + Math.abs(_recibos[index].GastosAdm) + parseFloat(Math.abs(_recibos[index].Derechos)) + parseFloat(Math.abs(_recibos[index].PrimaNeta) * (Math.abs(value) / Math.abs(_recibos[index].PrimaNeta) * 100) / 100)) - parseFloat(Math.abs(_recibos[index].Descuento)), 4);
      //let total = round((parseFloat(_recibos[index].PrimaNeta) + parseFloat(_recibos[index].Derechos) + parseFloat(_recibos[index].PrimaNeta * (value / _recibos[index].PrimaNeta * 100) / 100)) - parseFloat(_recibos[index].Descuento) + parseFloat(_recibos[index].PrimaNeta * _recibos[index].PorIVA / 100), 4);
      let total = round(parseFloat(Math.abs(subtotal)) + parseFloat(Math.abs(_recibos[index].IVA)) + parseFloat(Math.abs(_recibos[index].Ajuste)), 4);
      let comR = round(parseFloat(Math.abs(value) * Math.abs(_recibos[index].PComR) / 100), 4);

      _recibos[index].PorRecargos = pRecargos;
      _recibos[index].SubTotal = subtotal * TipoEndoso;
      _recibos[index].PrimaTotal = total * TipoEndoso;

      _recibos[index].ComR = comR * TipoEndoso;
    }
    else if (field == "PorRecargos") {

      let recargos = round(parseFloat(Math.abs(_recibos[index].PrimaNeta) * Math.abs(value) / 100), 4);
      let subtotal = round((parseFloat(Math.abs(_recibos[index].PrimaNeta)) + Math.abs(_recibos[index].GastosMaq) + Math.abs(_recibos[index].GastosAdm) + parseFloat(Math.abs(_recibos[index].Derechos)) + parseFloat(Math.abs(_recibos[index].PrimaNeta) * Math.abs(value) / 100)) - parseFloat(Math.abs(_recibos[index].Descuento)), 4);
      //let total = round((parseFloat(_recibos[index].PrimaNeta) + parseFloat(_recibos[index].Derechos) + parseFloat(_recibos[index].PrimaNeta * value / 100)) - parseFloat(_recibos[index].Descuento) + parseFloat(_recibos[index].PrimaNeta * _recibos[index].PorIVA / 100), 4);
      let total = round(parseFloat(Math.abs(subtotal) + parseFloat(Math.abs(_recibos[index].IVA)) + parseFloat(Math.abs(_recibos[index].Ajuste))), 4);
      let comR = round(parseFloat(Math.abs(recargos) * Math.abs(_recibos[index].PComR) / 100), 4);

      _recibos[index].Recargos = recargos * TipoEndoso;
      _recibos[index].SubTotal = subtotal * TipoEndoso;
      _recibos[index].PrimaTotal = total * TipoEndoso;

      _recibos[index].ComR = comR * TipoEndoso;
    }
    else if (field == "IVA") {

      let piva = round(parseFloat(Math.abs(value) / Math.abs(_recibos[index].SubTotal) * 100), 4);
      //let total = round((parseFloat(_recibos[index].PrimaNeta) + parseFloat(_recibos[index].Derechos) + parseFloat(_recibos[index].PrimaNeta * _recibos[index].PorRecargos / 100)) - parseFloat(_recibos[index].Descuento) + parseFloat(value), 4);
      let total = round(parseFloat(Math.abs(_recibos[index].SubTotal)) + parseFloat(Math.abs(value)) + parseFloat(Math.abs(_recibos[index].Ajuste)), 4);

      _recibos[index].PorIVA = piva;
      _recibos[index].PrimaTotal = total * TipoEndoso;
    }
    else if (field == "PorIVA") {

      let iva = round(parseFloat(Math.abs(value) / 100 * Math.abs(_recibos[index].SubTotal)), 4);
      //let total = round((parseFloat(_recibos[index].PrimaNeta) + parseFloat(_recibos[index].Derechos) + parseFloat(_recibos[index].PrimaNeta * _recibos[index].PorRecargos / 100)) - parseFloat(_recibos[index].Descuento) + parseFloat(value / 100 * _recibos[index].PrimaNeta), 4);
      let total = round(parseFloat(Math.abs(_recibos[index].SubTotal) + Math.abs(_recibos[index].SubTotal) * Math.abs(value) / 100) + parseFloat(Math.abs(_recibos[index].Ajuste)), 4);

      _recibos[index].IVA = iva * TipoEndoso;
      _recibos[index].PrimaTotal = total * TipoEndoso;
    }
    else if (field == "Derechos") {

      let subtotal = (parseFloat(Math.abs(_recibos[index].PrimaNeta)) + Math.abs(_recibos[index].GastosMaq) + Math.abs(_recibos[index].GastosAdm) + parseFloat(Math.abs(value)) + parseFloat(Math.abs(_recibos[index].PrimaNeta) * Math.abs(_recibos[index].PorRecargos) / 100)) - parseFloat(Math.abs(_recibos[index].PrimaNeta) * Math.abs(_recibos[index].PDescuento) / 100);
      let iva = round(parseFloat(Math.abs(subtotal) * Math.abs(_recibos[index].PorIVA) / 100), 4)
      let total = round(parseFloat(Math.abs(subtotal) + Math.abs(subtotal) * Math.abs(_recibos[index].PorIVA) / 100) + parseFloat(Math.abs(_recibos[index].Ajuste)), 4);

      let comD = round(parseFloat(Math.abs(value) * Math.abs(_recibos[index].PComD) / 100), 4);

      _recibos[index].SubTotal = subtotal * TipoEndoso;
      _recibos[index].IVA = iva * TipoEndoso;
      _recibos[index].PrimaTotal = total * TipoEndoso;

      _recibos[index].ComD = comD * TipoEndoso;
    }
    else if (field == "Ajuste") {
      if (parseFloat(value) > 0) {
        let total = round(parseFloat(Math.abs(_recibos[index].PrimaTotal)) - parseFloat(Math.abs(_recibos[index].AjusteAnterior) || 0) + parseFloat(Math.abs(value)), 4);
        let subtotal = round((parseFloat(Math.abs(total)) - parseFloat(Math.abs(value))) / (1 + (Math.abs(_recibos[index].PorIVA) / 100)), 4);
        let iva = round(parseFloat(Math.abs(subtotal) * Math.abs(_recibos[index].PorIVA) / 100), 4);
        let primaneta = round(parseFloat((Math.abs(subtotal) - Math.abs(_recibos[index].Derechos)) / ((1 + (Math.abs(_recibos[index].PorRecargos) / 100)) - (Math.abs(_recibos[index].PDescuento) / 100))), 4);
        let descuento = round(parseFloat(Math.abs(primaneta) * Math.abs(_recibos[index].PDescuento) / 100), 4);
        let recargos = round(parseFloat(Math.abs(primaneta) * Math.abs(_recibos[index].PorRecargos) / 100), 4);

        let comN = round(parseFloat(Math.abs(primaneta) * Math.abs(_recibos[index].PComN) / 100), 4);
        let especial = round(parseFloat(Math.abs(primaneta) * Math.abs(_recibos[index].PEspecial) / 100), 4);
        let comR = round(parseFloat(Math.abs(recargos) * Math.abs(_recibos[index].PComR) / 100), 4);

        _recibos[index].PrimaTotal = total * TipoEndoso;
        _recibos[index].SubTotal = subtotal * TipoEndoso;
        _recibos[index].IVA = iva * TipoEndoso;
        _recibos[index].PrimaNeta = primaneta * TipoEndoso;
        _recibos[index].Descuento = descuento * TipoEndoso;
        _recibos[index].Recargos = recargos * TipoEndoso;

        _recibos[index].ComN = comN * TipoEndoso;
        _recibos[index].ComR = comR * TipoEndoso;
        _recibos[index].Especial = especial * TipoEndoso;

        _recibos[index].AjusteAnterior = parseFloat(Math.abs(value));
      }

    }
    else if (field == "PrimaTotal") {

      let subtotal = round((parseFloat(Math.abs(value)) - parseFloat(Math.abs(_recibos[index].Ajuste))) / (1 + (Math.abs(_recibos[index].PorIVA) / 100)), 4);
      let iva = round(parseFloat(Math.abs(subtotal) * Math.abs(_recibos[index].PorIVA) / 100), 4);
      let primaneta = round(parseFloat((Math.abs(subtotal) - Math.abs(_recibos[index].GastosMaq) - Math.abs(_recibos[index].GastosAdm) - Math.abs(_recibos[index].Derechos)) / ((1 + (Math.abs(_recibos[index].PorRecargos) / 100)) - (Math.abs(_recibos[index].PDescuento) / 100))), 4);
      let descuento = round(parseFloat(Math.abs(primaneta) * Math.abs(_recibos[index].PDescuento) / 100), 4);
      let recargos = round(parseFloat(Math.abs(primaneta) * Math.abs(_recibos[index].PorRecargos) / 100), 4);

      let comN = round(parseFloat(Math.abs(primaneta) * Math.abs(_recibos[index].PComN) / 100), 4);
      let especial = round(parseFloat(Math.abs(primaneta) * Math.abs(_recibos[index].PEspecial) / 100), 4);
      let comR = round(parseFloat(Math.abs(recargos) * Math.abs(_recibos[index].PComR) / 100), 4);

      _recibos[index].SubTotal = subtotal * TipoEndoso;
      _recibos[index].IVA = iva * TipoEndoso;
      _recibos[index].PrimaNeta = primaneta * TipoEndoso;
      _recibos[index].Descuento = descuento * TipoEndoso;
      _recibos[index].Recargos = recargos * TipoEndoso;

      _recibos[index].ComN = comN * TipoEndoso;
      _recibos[index].ComR = comR * TipoEndoso;
      _recibos[index].Especial = especial * TipoEndoso;
    }

    else if (field == "ComN") {
      let pComN = round(parseFloat(Math.abs(value) / Math.abs(_recibos[index].PrimaNeta) * 100), 4);
      _recibos[index].PComN = pComN;
    }
    else if (field == "PComN") {
      let comN = round(parseFloat(Math.abs(_recibos[index].PrimaNeta) * Math.abs(value) / 100), 4);
      _recibos[index].ComN = comN * TipoEndoso;
    }
    else if (field == "ComR") {
      let pComR = round(parseFloat(Math.abs(value) / Math.abs(_recibos[index].Recargos) * 100), 4);
      _recibos[index].PComR = pComR;
    }
    else if (field == "PComR") {
      let comR = round(parseFloat(Math.abs(_recibos[index].Recargos) * Math.abs(value) / 100), 4);
      _recibos[index].ComR = comR * TipoEndoso;
    }
    else if (field == "ComD") {
      let pComD = round(parseFloat(Math.abs(value) / Math.abs(_recibos[index].Derechos) * 100), 4);
      _recibos[index].PComD = pComD;
    }
    else if (field == "PComD") {
      let comD = round(parseFloat(Math.abs(_recibos[index].Derechos) * Math.abs(value) / 100), 4);
      _recibos[index].ComD = comD * TipoEndoso;
    }
    else if (field == "Especial") {
      let pEspecial = round(parseFloat(Math.abs(value) / Math.abs(_recibos[index].PrimaNeta) * 100), 4);
      _recibos[index].PEspecial = pEspecial;
    }
    else if (field == "PEspecial") {
      let especial = round(parseFloat(Math.abs(_recibos[index].PrimaNeta) * Math.abs(value) / 100), 4);
      _recibos[index].Especial = especial * TipoEndoso;
    }
    else if (field == "CGastosMaq") {
      let pcGastosMaq = round(parseFloat(Math.abs(value) / Math.abs(_recibos[index].GastosMaq) * 100), 4);
      _recibos[index].PCGastosMaq = pcGastosMaq;
    }
    else if (field == "PCGastosMaq") {
      let cGastosMaq = round(parseFloat(Math.abs(value) * Math.abs(_recibos[index].PCGastosMaq) / 100), 4);
      _recibos[index].CGastosMaq = cGastosMaq * TipoEndoso;
    }
    else if (field == "CGastosAdm") {
      let pcGastosAdm = round(parseFloat(Math.abs(value) / Math.abs(_recibos[index].GastosAdm) * 100), 4);
      _recibos[index].PCGastosAdm = pcGastosAdm;
    }
    else if (field == "PCGastosAdm") {
      let cGastosAdm = round(parseFloat(Math.abs(value) * Math.abs(_recibos[index].PCGastosAdm) / 100), 4);
      _recibos[index].CGastosAdm = cGastosAdm * TipoEndoso;
    }

    setRecibos(_recibos);
    SetIsChange(false);
  }

  function ReloadRecibosSubsecuentes(index, item) {
    const values = formikRef.current.values;

    var TipoEndoso = parseFloat(values.TipoE ? values.TipoE : 1);

    let PrimaTotal = Math.abs(values.PrimaNeta) || 0;
    let DescuentoTotal = Math.abs(values.Descuento) || 0;
    let RecargosTotales = Math.abs(values.Recargos) || 0;
    let GastosMaqTotales = Math.abs(values.GastosMaquila) || 0;
    let GastosAdmTotales = Math.abs(values.GastosAdmin) || 0;
    let DerechosTotales = Math.abs(values.Derechos) || 0;
    let IVATotal = Math.abs(values.IVA) || 0;
    let AjusteTotal = Math.abs(values.Ajuste) || 0;

    let ComisionPrimaNeta = Math.abs(values.ComN) || 0;
    let ComisionRecargos = Math.abs(values.ComR) || 0;
    let ComisionDerechos = Math.abs(values.ComD) || 0;
    let ComisionEspecial = Math.abs(values.Especial) || 0;
    let ComisionGastosMaq = Math.abs(values.CGastosMaquila) || 0;
    let ComisionGastosAdm = Math.abs(values.CGastosAdmin) || 0;

    if (Math.abs(item.PrimaNeta) >= Math.abs(PrimaTotal)) {
      return swal({
        title: "Límite prima neta.",
        text: "La prima neta no puede ser igual o mayor a la prima neta total.",
        icon: "warning",
        confirmButtonText: "Aceptar",
        confirmButtonColor: "#472380"
      });
    }
    if (Math.abs(item.Descuento) > Math.abs(DescuentoTotal)) {
      return swal({
        title: "Límite descuento.",
        text: "El descuento no puede ser mayor al descuento total.",
        icon: "warning",
        confirmButtonText: "Aceptar",
        confirmButtonColor: "#472380"
      });
    }
    if (Math.abs(item.Recargos) > Math.abs(RecargosTotales)) {
      return swal({
        title: "Límite recargos.",
        text: "El recargo no puede ser mayor al recargo total.",
        icon: "warning",
        confirmButtonText: "Aceptar",
        confirmButtonColor: "#472380"
      });
    }
    if (Math.abs(item.Derechos) > Math.abs(DerechosTotales)) {
      return swal({
        title: "Límite derechos.",
        text: "El derecho no puede ser mayor al derecho total.",
        icon: "warning",
        confirmButtonText: "Aceptar",
        confirmButtonColor: "#472380"
      });
    }
    if (Math.abs(item.IVA) > Math.abs(IVATotal)) {
      return swal({
        title: "Límite IVA.",
        text: "El IVA no puede ser mayor al IVA total.",
        icon: "warning",
        confirmButtonText: "Aceptar",
        confirmButtonColor: "#472380"
      });
    }
    if (Math.abs(item.Ajuste) > Math.abs(AjusteTotal)) {
      return swal({
        title: "Límite ajuste.",
        text: "El ajuste no puede ser mayor al ajuste total.",
        icon: "warning",
        confirmButtonText: "Aceptar",
        confirmButtonColor: "#472380"
      });
    }

    //Datos principales
    let PAcmu = 0, DesAcmu = 0, RAcmu = 0, DAcmu = 0, IVAcmu = 0, AjusteAcmu = 0, GastosMaqAcmu = 0, GastosAdmAcmu = 0;

    //Datos de las comisiones
    let ComPNetaAcmu = 0, ComRAcmu = 0, ComDAcmu = 0, ComEspAcmu = 0, ComGastosMaqAcmu = 0, ComGastosAdmAcmu = 0;

    let totalRecibosRestantes = recibos.length - (index + 1);

    let _recibos = recibos.map((recibo, idx) => {
      let newRecibo = { ...recibo };

      if (idx > index) {
        let remainingRecibos = totalRecibosRestantes || 1;

        newRecibo.AjusteAnterior = round((Math.abs(AjusteTotal) - AjusteAcmu) / remainingRecibos, 4);

        //Valores principales
        newRecibo.PrimaNeta = round((Math.abs(PrimaTotal) - PAcmu) / remainingRecibos, 4) * TipoEndoso;
        newRecibo.Descuento = round((Math.abs(DescuentoTotal) - DesAcmu) / remainingRecibos, 4);
        newRecibo.Recargos = round((Math.abs(RecargosTotales) - RAcmu) / remainingRecibos, 4) * TipoEndoso;
        newRecibo.Derechos = round((Math.abs(DerechosTotales) - DAcmu) / remainingRecibos, 4) * TipoEndoso;
        newRecibo.IVA = round((Math.abs(IVATotal) - IVAcmu) / remainingRecibos, 4) * TipoEndoso;
        newRecibo.Ajuste = round((Math.abs(AjusteTotal) - AjusteAcmu) / remainingRecibos, 4) * TipoEndoso;

        newRecibo.GastosMaq = round((Math.abs(GastosMaqTotales) - GastosMaqAcmu) / remainingRecibos, 4) * TipoEndoso;
        newRecibo.GastosAdm = round((Math.abs(GastosAdmTotales) - GastosAdmAcmu) / remainingRecibos, 4) * TipoEndoso;

        //Valores de las comisiones
        newRecibo.ComN = round((Math.abs(ComisionPrimaNeta) - ComPNetaAcmu) / remainingRecibos, 4) * TipoEndoso;
        newRecibo.ComR = round((Math.abs(ComisionRecargos) - ComRAcmu) / remainingRecibos, 4) * TipoEndoso;
        newRecibo.ComD = round((Math.abs(ComisionDerechos) - ComDAcmu) / remainingRecibos, 4) * TipoEndoso;
        newRecibo.Especial = round((Math.abs(ComisionEspecial) - ComEspAcmu) / remainingRecibos, 4) * TipoEndoso;

        newRecibo.CGastosMaq = round((Math.abs(ComisionGastosMaq) - ComGastosMaqAcmu) / remainingRecibos, 4) * TipoEndoso;
        newRecibo.CGastosAdm = round((Math.abs(ComisionGastosAdm) - ComGastosAdmAcmu) / remainingRecibos, 4) * TipoEndoso;

      } else {
        //Valores principales
        PAcmu += parseFloat(Math.abs(recibo.PrimaNeta) || 0);
        DesAcmu += parseFloat(Math.abs(recibo.Descuento) || 0);
        RAcmu += parseFloat(Math.abs(recibo.Recargos) || 0);
        DAcmu += parseFloat(Math.abs(recibo.Derechos) || 0);
        IVAcmu += parseFloat(Math.abs(recibo.IVA) || 0);
        AjusteAcmu += parseFloat(Math.abs(recibo.Ajuste) || 0);

        GastosMaqAcmu += parseFloat(Math.abs(recibo.GastosMaq) || 0);
        GastosAdmAcmu += parseFloat(Math.abs(recibo.GastosAdm) || 0);

        //Valores de las comisiones
        ComPNetaAcmu += parseFloat(Math.abs(recibo.ComN) || 0);
        ComRAcmu += parseFloat(Math.abs(recibo.ComR) || 0);
        ComDAcmu += parseFloat(Math.abs(recibo.ComD) || 0);
        ComEspAcmu += parseFloat(Math.abs(recibo.Especial) || 0);

        ComGastosMaqAcmu += parseFloat(Math.abs(recibo.CGastosMaq) || 0);
        ComGastosAdmAcmu += parseFloat(Math.abs(recibo.CGastosAdm) || 0);
      }

      return newRecibo;
    });

    _recibos.forEach((item, indexRecibo) => {
      if (indexRecibo > index) {

        let subtotal = round((parseFloat(Math.abs(item.PrimaNeta) + Math.abs(item.GastosMaq) + Math.abs(item.GastosAdm) + Math.abs(item.Recargos) + Math.abs(item.Derechos))) - parseFloat(Math.abs(item.Descuento)), 4);

        item.PDescuento = round((Math.abs(item.Descuento) / Math.abs(item.PrimaNeta)) * 100, 4);
        item.PorRecargos = round((Math.abs(item.Recargos) / Math.abs(item.PrimaNeta)) * 100, 4);
        item.SubTotal = round((parseFloat(Math.abs(item.PrimaNeta) + Math.abs(item.Recargos) + Math.abs(item.Derechos))) - parseFloat(Math.abs(item.Descuento)), 4) * TipoEndoso;
        item.PorIVA = round((Math.abs(item.IVA) / Math.abs(subtotal)) * 100, 4);
        item.PrimaTotal = round((parseFloat(Math.abs(item.PrimaNeta) + Math.abs(item.GastosMaq) + Math.abs(item.GastosAdm) + Math.abs(item.Recargos) + Math.abs(item.Derechos))) - parseFloat(Math.abs(item.Descuento)) + parseFloat(Math.abs(item.IVA)) + parseFloat(Math.abs(item.Ajuste)), 4) * TipoEndoso;

        item.PComN = round((Math.abs(item.ComN) / Math.abs(item.PrimaNeta)) * 100, 4);
        item.PComR = round((Math.abs(item.ComR) / Math.abs(item.Recargos)) * 100, 4);
        item.PComD = round((Math.abs(item.ComD) / Math.abs(item.Derechos)) * 100, 4);
        item.PEspecial = round((Math.abs(item.Especial) / Math.abs(item.PrimaNeta)) * 100, 4);

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

  function NewReloadPrices(field, value) {

    if (value.includes(',')) {
      value = value.replace(/,/g, '');
    }

    let _OT = formikRef.current.values;
    var TipoEndoso = parseFloat(_OT.TipoE ? _OT.TipoE : 1);

    formikRef.current.setFieldValue(field, (field != "Descuento" && field != "PDescuento"
      && field != "PorRecargos" && field != "PorDerechos" && field != "PorIVA"
      && field != "PComN" && field != "PComR" && field != "PComD" && field != "PEspecial"
      && field != "PCGastosMaquila" && field != "PCGastosAdmin"
      && TipoEndoso == -1 ? "-" + Math.abs(value) : Math.abs(value)));

    if (field == "PrimaNeta") {
      let descuento = round(parseFloat(Math.abs(value) * (Math.abs(_OT.PDescuento || 0)) / 100), 4);
      let recargos = round(parseFloat(Math.abs(value) * (Math.abs(_OT.PorRecargos || 0)) / 100), 4);
      let derechos = round(parseFloat(Math.abs(value) * (Math.abs(_OT.PorDerechos) || 0) / 100), 4);
      let subtotal = round((parseFloat(Math.abs(value)) + parseFloat(Math.abs(derechos || 0))
        + parseFloat(Math.abs(recargos || 0)) + parseFloat(Math.abs(_OT.GastosMaquila || 0)) + parseFloat(Math.abs(_OT.GastosAdmin || 0))) - parseFloat(Math.abs(descuento || 0)), 4);
      let iva = round(parseFloat(Math.abs(subtotal) * (Math.abs(_OT.PorIVA || 0)) / 100),);
      let total = round(parseFloat(Math.abs(subtotal) + Math.abs(iva) + parseFloat(Math.abs(_OT.Ajuste || 0))), 4);

      let comN = round(parseFloat(Math.abs(value) * Math.abs(_OT.PComN || 0) / 100), 4);
      let comR = round(parseFloat(Math.abs(recargos) * Math.abs(_OT.PComR || 0) / 100), 4);
      let comD = round(parseFloat(Math.abs(derechos) * Math.abs(_OT.PComD || 0) / 100), 4);
      let especial = round(parseFloat(Math.abs(value) * Math.abs(_OT.PEspecial || 0) / 100), 4);

      formikRef.current.setFieldValue("Descuento", Math.abs(descuento || 0));
      formikRef.current.setFieldValue("Recargos", Math.abs(recargos || 0) * TipoEndoso);
      formikRef.current.setFieldValue("Derechos", Math.abs(derechos || 0) * TipoEndoso);
      formikRef.current.setFieldValue("IVA", Math.abs(iva || 0) * TipoEndoso);
      formikRef.current.setFieldValue("STotal", Math.abs(subtotal || 0) * TipoEndoso);
      formikRef.current.setFieldValue("PrimaTotal", Math.abs(total || 0) * TipoEndoso);

      formikRef.current.setFieldValue("ComN", Math.abs(comN || 0) * TipoEndoso);
      formikRef.current.setFieldValue("ComR", Math.abs(comR || 0) * TipoEndoso);
      formikRef.current.setFieldValue("ComD", Math.abs(comD || 0) * TipoEndoso);
      formikRef.current.setFieldValue("Especial", Math.abs(especial || 0) * TipoEndoso);
    }
    else if (field == "Descuento") {
      let pDescuento = round(parseFloat(Math.abs(value) / (Math.abs(_OT.PrimaNeta || 0)) * 100), 4);
      let subtotal = round((parseFloat(Math.abs(_OT.PrimaNeta || 0))
        + parseFloat(Math.abs(_OT.Derechos || 0)) + parseFloat(Math.abs(_OT.Recargos || 0))
        + parseFloat(Math.abs(_OT.GastosMaquila || 0)) + parseFloat(Math.abs(_OT.GastosAdmin || 0))) - parseFloat(Math.abs(value)), 4);
      let total = round((parseFloat(Math.abs(subtotal)) + parseFloat(Math.abs(_OT.IVA || 0)) + parseFloat(Math.abs(_OT.Ajuste || 0))), 4);

      formikRef.current.setFieldValue("PDescuento", Math.abs(pDescuento || 0));
      formikRef.current.setFieldValue("STotal", Math.abs(subtotal || 0) * TipoEndoso);
      formikRef.current.setFieldValue("PrimaTotal", Math.abs(total || 0) * TipoEndoso);
    }
    else if (field == "PDescuento") {
      let descuento = round(parseFloat(Math.abs(_OT.PrimaNeta || 0) * Math.abs(value) / 100), 4);
      let subtotal = round((parseFloat(Math.abs(_OT.PrimaNeta || 0))
        + parseFloat(Math.abs(_OT.Derechos || 0))
        + parseFloat(Math.abs(_OT.PrimaNeta || 0) * Math.abs(_OT.PorRecargos || 0) / 100)
        + parseFloat(Math.abs(_OT.GastosMaquila || 0)) + parseFloat(Math.abs(_OT.GastosAdmin || 0))) - parseFloat(Math.abs(_OT.PrimaNeta || 0) * value / 100), 4);
      let total = round(parseFloat(Math.abs(subtotal) + Math.abs(_OT.IVA || 0) + parseFloat(Math.abs(_OT.Ajuste || 0))), 4);

      formikRef.current.setFieldValue("Descuento", Math.abs(descuento || 0));
      formikRef.current.setFieldValue("STotal", Math.abs(subtotal || 0) * TipoEndoso);
      formikRef.current.setFieldValue("PrimaTotal", Math.abs(total || 0) * TipoEndoso);
    }
    else if (field == "Recargos") {

      let pRecargos = round(parseFloat(Math.abs(value) / Math.abs(_OT.PrimaNeta || 0) * 100), 4);
      let subtotal = round((parseFloat(Math.abs(_OT.PrimaNeta || 0))
        + parseFloat(Math.abs(_OT.Derechos || 0))
        + parseFloat(Math.abs(_OT.PrimaNeta || 0) * (Math.abs(value) / Math.abs(_OT.PrimaNeta || 0) * 100) / 100)
        + parseFloat(Math.abs(_OT.GastosMaquila || 0)) + parseFloat(Math.abs(_OT.GastosAdmin || 0))) - parseFloat(Math.abs(_OT.Descuento || 0)), 4);
      let total = round(parseFloat(Math.abs(subtotal)) + parseFloat(Math.abs(_OT.IVA || 0)) + parseFloat(Math.abs(_OT.Ajuste || 0)), 4);

      let comR = round(parseFloat(Math.abs(value) * Math.abs(_OT.PComR || 0) / 100), 4);

      formikRef.current.setFieldValue("PorRecargos", Math.abs(pRecargos || 0));
      formikRef.current.setFieldValue("STotal", Math.abs(subtotal || 0) * TipoEndoso);
      formikRef.current.setFieldValue("PrimaTotal", Math.abs(total || 0) * TipoEndoso);

      formikRef.current.setFieldValue("ComR", Math.abs(comR || 0) * TipoEndoso);
    }
    else if (field == "PorRecargos") {
      let recargos = round(parseFloat(Math.abs(_OT.PrimaNeta || 0) * Math.abs(value) / 100), 4);
      let subtotal = round((parseFloat(Math.abs(_OT.PrimaNeta || 0))
        + parseFloat(Math.abs(_OT.Derechos || 0))
        + parseFloat(Math.abs(_OT.PrimaNeta || 0) * Math.abs(value) / 100)
        + parseFloat(Math.abs(_OT.GastosMaquila || 0)) + parseFloat(Math.abs(_OT.GastosAdmin || 0))) - parseFloat(Math.abs(_OT.Descuento || 0)), 4);
      let total = round(parseFloat(Math.abs(subtotal) + parseFloat(Math.abs(_OT.IVA || 0)) + parseFloat(Math.abs(_OT.Ajuste || 0))), 4);

      let comR = round(parseFloat(recargos * Math.abs(_OT.PComR || 0) / 100), 4);

      formikRef.current.setFieldValue("Recargos", Math.abs(recargos || 0) * TipoEndoso);
      formikRef.current.setFieldValue("STotal", Math.abs(subtotal || 0) * TipoEndoso);
      formikRef.current.setFieldValue("PrimaTotal", Math.abs(total || 0) * TipoEndoso);

      formikRef.current.setFieldValue("ComR", Math.abs(comR || 0) * TipoEndoso);
    }
    else if (field == "Derechos") {
      let pDerecho = round(parseFloat(Math.abs(value) / Math.abs(_OT.PrimaNeta || 0) * 100), 4);
      let subtotal = (parseFloat(Math.abs(_OT.PrimaNeta || 0))
        + parseFloat(Math.abs(value)) + parseFloat(Math.abs(_OT.Recargos || 0))
        + parseFloat(Math.abs(_OT.GastosMaquila || 0)) + parseFloat(Math.abs(_OT.GastosAdmin || 0))) - parseFloat(Math.abs((_OT.Descuento || 0)));
      let iva = round(parseFloat(Math.abs(subtotal) * Math.abs(_OT.PorIVA || 0) / 100), 4)
      let total = round(parseFloat(Math.abs(subtotal) + Math.abs(subtotal) * Math.abs(_OT.PorIVA || 0) / 100) + parseFloat(Math.abs(_OT.Ajuste) || 0), 4);

      let comD = round(parseFloat(Math.abs(value) * Math.abs(_OT.PComD || 0) / 100), 4);

      formikRef.current.setFieldValue("PorDerechos", pDerecho || 0);
      formikRef.current.setFieldValue("STotal", Math.abs(subtotal || 0) * TipoEndoso);
      formikRef.current.setFieldValue("IVA", Math.abs(iva || 0) * TipoEndoso);
      formikRef.current.setFieldValue("PrimaTotal", Math.abs(total || 0) * TipoEndoso);

      formikRef.current.setFieldValue("ComD", Math.abs(comD || 0) * TipoEndoso);
    }
    else if (field == "PorDerechos") {
      let derechos = round(parseFloat(Math.abs(_OT.PrimaNeta || 0) * Math.abs(value) / 100), 4);
      let subtotal = round((parseFloat(Math.abs(_OT.PrimaNeta || 0))
        + parseFloat(Math.abs(derechos || 0))
        + parseFloat(Math.abs(_OT.Recargos || 0))
        + parseFloat(Math.abs(_OT.GastosMaquila || 0)) + parseFloat(Math.abs(_OT.GastosAdmin || 0))) - parseFloat(Math.abs(_OT.Descuento || 0)), 4);
      let total = round(parseFloat(Math.abs(subtotal) + parseFloat(Math.abs(_OT.IVA || 0)) + parseFloat(Math.abs(_OT.Ajuste || 0))), 4);

      let comD = round(parseFloat(derechos * Math.abs(_OT.PComD || 0) / 100), 4);

      formikRef.current.setFieldValue("Derechos", Math.abs(derechos || 0) * TipoEndoso);
      formikRef.current.setFieldValue("STotal", Math.abs(subtotal || 0) * TipoEndoso);
      formikRef.current.setFieldValue("PrimaTotal", Math.abs(total || 0) * TipoEndoso);

      formikRef.current.setFieldValue("ComD", Math.abs(comD || 0) * TipoEndoso);
    }
    else if (field == "GastosMaquila") {
      let subtotal = (parseFloat(Math.abs(_OT.PrimaNeta || 0))
        + parseFloat(Math.abs(_OT.Derechos || 0))
        + parseFloat(Math.abs(_OT.Recargos || 0))
        + parseFloat(Math.abs(value)) + parseFloat(Math.abs(_OT.GastosAdmin || 0))) - parseFloat(Math.abs(_OT.Descuento || 0));
      let iva = round(parseFloat(Math.abs(subtotal) * (Math.abs(_OT.PorIVA || 0)) / 100), 4)
      let total = round(parseFloat(Math.abs(subtotal) + (Math.abs(iva)) + parseFloat(Math.abs(_OT.Ajuste || 0))), 4);

      let cGastosMaq = round(parseFloat(value * Math.abs(_OT.PCGastosMaquila || 0) / 100), 4);

      formikRef.current.setFieldValue("IVA", iva || 0);
      formikRef.current.setFieldValue("STotal", subtotal || 0);
      formikRef.current.setFieldValue("PrimaTotal", total || 0);

      formikRef.current.setFieldValue("CGastosMaquila", cGastosMaq || 0);
    }
    else if (field == "GastosAdmin") {
      let subtotal = (parseFloat(Math.abs(_OT.PrimaNeta || 0))
        + parseFloat(Math.abs(_OT.Derechos || 0))
        + parseFloat(Math.abs(_OT.Recargos || 0))
        + parseFloat(Math.abs(_OT.GastosMaquila || 0)) + parseFloat(Math.abs(value))) - parseFloat(Math.abs(_OT.Descuento || 0));
      let iva = round(parseFloat(Math.abs(subtotal) * Math.abs(_OT.PorIVA || 0) / 100), 4)
      let total = round(parseFloat(Math.abs(subtotal) + Math.abs(iva) + parseFloat(Math.abs(_OT.Ajuste || 0))), 4);

      let cGastosAdm = round(parseFloat(Math.abs(value) * Math.abs(_OT.PCGastosAdmin || 0) / 100), 4);

      formikRef.current.setFieldValue("IVA", Math.abs(iva || 0) * TipoEndoso);
      formikRef.current.setFieldValue("STotal", Math.abs(subtotal || 0) * TipoEndoso);
      formikRef.current.setFieldValue("PrimaTotal", Math.abs(total || 0) * TipoEndoso);

      formikRef.current.setFieldValue("CGastosAdmin", Math.abs(cGastosAdm || 0) * TipoEndoso);
    }
    else if (field == "IVA") {

      let piva = round(parseFloat(Math.abs(value) / Math.abs(_OT.STotal || 0) * 100), 4);
      let total = round(parseFloat(Math.abs(_OT.STotal || 0)) + parseFloat(Math.abs(value)) + parseFloat(Math.abs(_OT.Ajuste || 0)), 4);

      formikRef.current.setFieldValue("PorIVA", Math.abs(piva || 0));
      formikRef.current.setFieldValue("PrimaTotal", Math.abs(total || 0) * TipoEndoso);
    }
    else if (field == "PorIVA") {

      let iva = round(parseFloat(Math.abs(value) / 100 * Math.abs(_OT.STotal || 0)), 4);
      let total = round(parseFloat(Math.abs(_OT.STotal) + Math.abs(_OT.STotal || 0) * Math.abs(value) / 100) + parseFloat(Math.abs(_OT.Ajuste || 0)), 4);

      formikRef.current.setFieldValue("IVA", Math.abs(iva || 0) * TipoEndoso);
      formikRef.current.setFieldValue("PrimaTotal", Math.abs(total || 0) * TipoEndoso);
    }
    else if (field == "Ajuste") {

      let ajusteAnterior = 0;

      if (_OT.AjusteAnterior == undefined) {
        if (Id == undefined) {
          ajusteAnterior = 0;
        }
        else {
          ajusteAnterior = parseFloat(Math.abs(AjusteAnteriorGuardado || 0));
        }
      }
      else {
        ajusteAnterior = parseFloat(Math.abs(_OT.AjusteAnterior || 0));
      }

      let total = round(parseFloat(Math.abs(_OT.PrimaTotal || 0)) - parseFloat(Math.abs(ajusteAnterior)) + parseFloat(Math.abs(value)), 4);
      let subtotal = round((parseFloat(Math.abs(total)) - parseFloat(Math.abs(value))) / (1 + (Math.abs(_OT.PorIVA || 0) / 100)), 4);
      let iva = round(parseFloat(Math.abs(subtotal) * Math.abs(_OT.PorIVA || 0) / 100), 4);
      let primaneta = round(parseFloat((Math.abs(subtotal) - Math.abs(_OT.Derechos || 0) - Math.abs(_OT.GastosMaquila || 0) - Math.abs(_OT.GastosAdmin || 0)) / ((1 + (Math.abs(_OT.PorRecargos || 0) / 100)) - (Math.abs(_OT.PDescuento || 0) / 100))), 4);
      let descuento = round(parseFloat(Math.abs(primaneta) * Math.abs(_OT.PDescuento || 0) / 100), 4);
      let recargos = round(parseFloat(Math.abs(primaneta) * Math.abs(_OT.PorRecargos || 0) / 100), 4);
      let derechos = round(parseFloat(Math.abs(primaneta) * Math.abs(_OT.PorDerechos || 0) / 100), 4);

      let comN = round(parseFloat(Math.abs(primaneta) * Math.abs(_OT.PComN || 0) / 100), 4);
      let comR = round(parseFloat(Math.abs(recargos) * Math.abs(_OT.PComR || 0) / 100), 4);
      let comD = round(parseFloat(Math.abs(derechos) * Math.abs(_OT.PComD || 0) / 100), 4);
      let especial = round(parseFloat(Math.abs(primaneta) * Math.abs(_OT.PEspecial || 0) / 100), 4);

      formikRef.current.setFieldValue("PrimaTotal", Math.abs(total || 0) * TipoEndoso);
      formikRef.current.setFieldValue("STotal", Math.abs(subtotal || 0) * TipoEndoso);
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
      let subtotal = round((parseFloat(Math.abs(value)) - parseFloat(Math.abs(_OT.Ajuste || 0))) / (1 + (Math.abs(_OT.PorIVA || 0) / 100)), 4);
      let iva = round(parseFloat(Math.abs(subtotal) * Math.abs(_OT.PorIVA || 0) / 100), 4);
      let primaneta = round(parseFloat((Math.abs(subtotal) - Math.abs(_OT.Derechos || 0) - Math.abs(_OT.GastosMaquila || 0) - Math.abs(_OT.GastosAdmin || 0)) / ((1 + (Math.abs(_OT.PorRecargos || 0) / 100)) - (Math.abs(_OT.PDescuento || 0) / 100))), 4);
      let descuento = round(parseFloat(Math.abs(primaneta) * Math.abs(_OT.PDescuento || 0) / 100), 4);
      let recargos = round(parseFloat(Math.abs(primaneta) * Math.abs(_OT.PorRecargos || 0) / 100), 4);
      let derechos = parseFloat(Math.abs(primaneta) * Math.abs(_OT.PorDerechos || 0) / 100);

      let comN = round(parseFloat(Math.abs(primaneta) * Math.abs(_OT.PComN || 0) / 100), 4);
      let comR = round(parseFloat(Math.abs(recargos) * Math.abs(_OT.PComR || 0) / 100), 4);
      let comD = parseFloat(Math.abs(derechos) * Math.abs(_OT.PComD || 0) / 100);
      let especial = round(parseFloat(Math.abs(primaneta) * Math.abs(_OT.PEspecial || 0) / 100), 4);

      formikRef.current.setFieldValue("STotal", Math.abs(subtotal || 0) * TipoEndoso);
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
    else if (field == "CGastosMaquila") {
      let pCGastosMaquila = round(parseFloat(Math.abs(value) / Math.abs(_OT.GastosMaquila || 0) * 100), 4);
      formikRef.current.setFieldValue("PCGastosMaquila", pCGastosMaquila || 0);
    }
    else if (field == "PCGastosMaquila") {
      let cGastosMaquila = round(parseFloat(Math.abs(_OT.GastosMaquila || 0) * Math.abs(value) / 100), 4);
      formikRef.current.setFieldValue("CGastosMaquila", Math.abs(cGastosMaquila || 0) * TipoEndoso);
    }
    else if (field == "CGastosAdmin") {
      let pCGastosAdmin = round(parseFloat(Math.abs(value) / Math.abs(_OT.GastosAdmin || 0) * 100), 4);
      formikRef.current.setFieldValue("PCGastosAdmin", pCGastosAdmin || 0);
    }
    else if (field == "PCGastosAdmin") {
      let cGastosAdmin = round(parseFloat(Math.abs(_OT.GastosAdmin || 0) * Math.abs(value) / 100), 4);
      formikRef.current.setFieldValue("CGastosAdmin", Math.abs(cGastosAdmin || 0) * TipoEndoso);
    }
    else if (field == "Especial") {
      let pEspecial = round(parseFloat(Math.abs(value) / Math.abs(_OT.PrimaNeta || 0) * 100), 4);
      formikRef.current.setFieldValue("PEspecial", pEspecial || 0);
    }
    else if (field == "PEspecial") {
      let especial = round(parseFloat(Math.abs(_OT.PrimaNeta) * Math.abs(value) / 100), 4);
      formikRef.current.setFieldValue("Especial", Math.abs(especial || 0) * TipoEndoso);
    }
  }

  function NewReloadReciboPrices(field, value) {

    if (value.includes(',')) {
      value = value.replace(/,/g, '');
    }

    let _OT = formikRef.current.values;
    formikRef.current.setFieldValue(field, (field != "RDescuento" && TipoEndoso == -1 ? "-" + value : value));

    if (field == "RPrimaNeta") {
      let descuento = parseFloat(value * (_OT.PDescuento || 0) / 100);
      let recargos = parseFloat(value * (_OT.PorRecargos || 0) / 100);
      let subtotal = (parseFloat(value) + parseFloat(_OT.Derechos || 0) + parseFloat(recargos || 0)) - parseFloat(descuento || 0);
      let iva = parseFloat(subtotal * (_OT.PorIVA || 0) / 100);
      let total = parseFloat(subtotal + iva + parseFloat(_OT.Ajuste || 0));

      let comN = parseFloat(value * (_OT.PComNeta || 0) / 100);
      let especial = parseFloat(value * (_OT.PEspecial || 0) / 100);
      let comR = parseFloat(recargos * (_OT.PComRec || 0) / 100);

      formikRef.current.setFieldValue("Descuento", descuento || 0);
      formikRef.current.setFieldValue("Recargos", recargos || 0);
      formikRef.current.setFieldValue("IVA", iva || 0);
      formikRef.current.setFieldValue("STotal", subtotal || 0);
      formikRef.current.setFieldValue("PrimaTotal", total || 0);

      formikRef.current.setFieldValue("ComNeta", comN || 0);
      formikRef.current.setFieldValue("ComRec", comR || 0);
      formikRef.current.setFieldValue("Especial", especial || 0);
    }
    else if (field == "Descuento") {

      let pDescuento = parseFloat(value / (_OT.PrimaNeta || 0) * 100);
      let subtotal = (parseFloat(_OT.PrimaNeta || 0) + parseFloat(_OT.Derechos || 0) + parseFloat((_OT.PrimaNeta || 0) * (_OT.PorRecargos || 0) / 100)) - parseFloat(value);
      let total = (parseFloat(subtotal) + parseFloat((_OT.IVA || 0) + parseFloat(_OT.Ajuste || 0)));

      formikRef.current.setFieldValue("PDescuento", pDescuento || 0);
      formikRef.current.setFieldValue("STotal", subtotal || 0);
      formikRef.current.setFieldValue("PrimaTotal", total || 0);

      /* _OT.PDescuento = pDescuento;
      _OT.STotal = subtotal;
      _OT.PrimaTotal = total; */
    }
    else if (field == "PDescuento") {

      let descuento = round(parseFloat((_OT.PrimaNeta || 0) * value / 100), 4);
      let subtotal = round((parseFloat(_OT.PrimaNeta || 0) + parseFloat(_OT.Derechos || 0) + parseFloat((_OT.PrimaNeta || 0) * (_OT.PorRecargos || 0) / 100)) - parseFloat((_OT.PrimaNeta || 0) * value / 100), 4);
      let total = round(parseFloat(subtotal + (_OT.IVA || 0) + parseFloat(_OT.Ajuste || 0)), 4);

      formikRef.current.setFieldValue("Descuento", descuento || 0);
      formikRef.current.setFieldValue("STotal", subtotal || 0);
      formikRef.current.setFieldValue("PrimaTotal", total || 0);

      /* _OT.Descuento = descuento;
      _OT.STotal = subtotal;
      _OT.PrimaTotal = total; */
    }
    else if (field == "Recargos") {

      let pRecargos = round(parseFloat(value / (_OT.PrimaNeta || 0) * 100), 4);
      let subtotal = round((parseFloat(_OT.PrimaNeta || 0) + parseFloat(_OT.Derechos || 0) + parseFloat((_OT.PrimaNeta || 0) * (value / (_OT.PrimaNeta || 0) * 100) / 100)) - parseFloat(_OT.Descuento || 0), 4);
      let total = round(parseFloat(subtotal) + parseFloat(_OT.IVA || 0) + parseFloat(_OT.Ajuste || 0), 4);

      let comR = round(parseFloat(value * (_OT.PComRec || 0) / 100), 4);

      formikRef.current.setFieldValue("PorRecargos", pRecargos || 0);
      formikRef.current.setFieldValue("STotal", subtotal || 0);
      formikRef.current.setFieldValue("PrimaTotal", total || 0);

      formikRef.current.setFieldValue("ComRec", comR || 0);

      /* _OT.PorRecargos = pRecargos;
      _OT.STotal = subtotal;
      _OT.PrimaTotal = total;
 
      _OT.ComRec = comR; */
    }
    else if (field == "PorRecargos") {

      let recargos = round(parseFloat((_OT.PrimaNeta || 0) * value / 100), 4);
      let subtotal = round((parseFloat(_OT.PrimaNeta || 0) + parseFloat(_OT.Derechos || 0) + parseFloat((_OT.PrimaNeta || 0) * value / 100)) - parseFloat(_OT.Descuento || 0), 4);
      let total = round(parseFloat(subtotal + parseFloat(_OT.IVA || 0) + parseFloat(_OT.Ajuste || 0)), 4);

      let comR = round(parseFloat(recargos * (_OT.PComRec || 0) / 100), 4);

      formikRef.current.setFieldValue("Recargos", recargos || 0);
      formikRef.current.setFieldValue("STotal", subtotal || 0);
      formikRef.current.setFieldValue("PrimaTotal", total || 0);

      formikRef.current.setFieldValue("ComRec", comR || 0);

      /* _OT.Recargos = recargos;
      _OT.STotal = subtotal;
      _OT.PrimaTotal = total;
 
      _OT.ComRec = comR; */
    }
    else if (field == "IVA") {

      let piva = round(parseFloat(value / (_OT.STotal || 0) * 100), 4);
      let total = round(parseFloat(_OT.STotal || 0) + parseFloat(value) + parseFloat(_OT.Ajuste || 0), 4);

      formikRef.current.setFieldValue("PorIVA", piva || 0);
      formikRef.current.setFieldValue("PrimaTotal", total || 0);

      /* _OT.PorIVA = piva;
      _OT.PrimaTotal = total; */
    }
    else if (field == "PorIVA") {

      let iva = round(parseFloat(value / 100 * (_OT.STotal || 0)), 4);
      let total = round(parseFloat(_OT.STotal + (_OT.STotal || 0) * value / 100) + parseFloat(_OT.Ajuste || 0), 4);

      formikRef.current.setFieldValue("IVA", iva || 0);
      formikRef.current.setFieldValue("PrimaTotal", total || 0);

      /* _OT.IVA = iva;
      _OT.PrimaTotal = total; */
    }
    else if (field == "Derechos") {

      let subtotal = (parseFloat(_OT.PrimaNeta || 0) + parseFloat(value) + parseFloat((_OT.PrimaNeta || 0) * (_OT.PorRecargos || 0) / 100)) - parseFloat((_OT.PrimaNeta || 0) * (_OT.PDescuento || 0) / 100);
      let iva = round(parseFloat(subtotal * (_OT.PorIVA || 0) / 100), 4)
      let total = round(parseFloat(subtotal + subtotal * (_OT.PorIVA || 0) / 100) + parseFloat(_OT.Ajuste || 0), 4);

      let comD = round(parseFloat(value * (_OT.PComDer || 0) / 100), 4);

      formikRef.current.setFieldValue("STotal", subtotal || 0);
      formikRef.current.setFieldValue("IVA", iva || 0);
      formikRef.current.setFieldValue("PrimaTotal", total || 0);

      formikRef.current.setFieldValue("ComDer", comD || 0);

      /* _OT.STotal = subtotal;
      _OT.IVA = iva;
      _OT.PrimaTotal = total;
 
      _OT.ComDer = comD; */
    }
    else if (field == "Ajuste") {
      //if (parseFloat(value) > 0) {
      let total = parseFloat(_OT.PrimaTotal || 0) - parseFloat(_OT.AjusteAnterior || 0) + parseFloat(value);

      let subtotal = (parseFloat(total) - parseFloat(value)) / (1 + ((_OT.PorIVA || 0) / 100));
      let iva = parseFloat(subtotal * (_OT.PorIVA || 0) / 100);
      let primaneta = parseFloat((subtotal - (_OT.Derechos || 0)) / ((1 + ((_OT.PorRecargos || 0) / 100)) - ((_OT.PDescuento || 0) / 100)));
      let descuento = parseFloat(primaneta * (_OT.PDescuento || 0) / 100);
      let recargos = parseFloat(primaneta * (_OT.PorRecargos || 0) / 100);

      let comN = parseFloat(primaneta * (_OT.PComNeta || 0) / 100);
      let comR = parseFloat(recargos * (_OT.PComRec || 0) / 100);
      let especial = parseFloat(primaneta * (_OT.PEspecial || 0) / 100);

      formikRef.current.setFieldValue("PrimaTotal", total || 0);
      formikRef.current.setFieldValue("STotal", subtotal || 0);
      formikRef.current.setFieldValue("IVA", iva || 0);
      formikRef.current.setFieldValue("PrimaNeta", primaneta || 0);
      formikRef.current.setFieldValue("Descuento", descuento || 0);
      formikRef.current.setFieldValue("Recargos", recargos || 0);

      formikRef.current.setFieldValue("ComNeta", comN || 0);
      formikRef.current.setFieldValue("ComRec", comR || 0);
      formikRef.current.setFieldValue("Especial", especial || 0);

      formikRef.current.setFieldValue("AjusteAnterior", parseFloat(value || 0));

      /* _OT.PrimaTotal = total;
      _OT.STotal = subtotal
      _OT.IVA = iva;
      _OT.PrimaNeta = primaneta;
      _OT.Descuento = descuento;
      _OT.Recargos = recargos;
 
      _OT.ComNeta = comN;
      _OT.ComRec = comR;
      _OT.Especial = especial;
 
      _OT.AjusteAnterior = parseFloat(value); */
      //}
    }
    else if (field == "PrimaTotal") {

      let subtotal = round((parseFloat(value) - parseFloat(_OT.Ajuste || 0)) / (1 + ((_OT.PorIVA || 0) / 100)), 4);
      let iva = round(parseFloat(subtotal * (_OT.PorIVA || 0) / 100), 4);
      let primaneta = round(parseFloat((subtotal - (_OT.Derechos || 0)) / ((1 + ((_OT.PorRecargos || 0) / 100)) - ((_OT.PDescuento || 0) / 100))), 4);
      let descuento = round(parseFloat(primaneta * (_OT.PDescuento || 0) / 100), 4);
      let recargos = round(parseFloat(primaneta * (_OT.PorRecargos || 0) / 100), 4);

      let comN = round(parseFloat(primaneta * (_OT.PComNeta || 0) / 100), 4);
      let comR = round(parseFloat(recargos * (_OT.PComRec || 0) / 100), 4);
      let especial = round(parseFloat(primaneta * (_OT.PEspecial || 0) / 100), 4);

      formikRef.current.setFieldValue("STotal", subtotal || 0);
      formikRef.current.setFieldValue("IVA", iva || 0);
      formikRef.current.setFieldValue("PrimaNeta", primaneta || 0);
      formikRef.current.setFieldValue("Descuento", descuento || 0);
      formikRef.current.setFieldValue("Recargos", recargos || 0);

      formikRef.current.setFieldValue("ComNeta", comN || 0);
      formikRef.current.setFieldValue("ComRec", comR || 0);
      formikRef.current.setFieldValue("Especial", especial || 0);

      /* _OT.STotal = subtotal;
      _OT.IVA = iva;
      _OT.PrimaNeta = primaneta;
      _OT.Descuento = descuento;
      _OT.Recargos = recargos;
 
      _OT.ComNeta = comN;
      _OT.ComRec = comR;
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
    else if (field == "ComRec") {
      let pComR = round(parseFloat(value / (_OT.Recargos || 0) * 100), 4);
      formikRef.current.setFieldValue("PComRec", pComR || 0);

      /* _OT.PComRec = pComR; */
    }
    else if (field == "PComRec") {
      let comR = round(parseFloat((_OT.Recargos || 0) * value / 100), 4);
      formikRef.current.setFieldValue("ComRec", comR || 0);

      /* _OT.ComRec = comR; */
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
  }

  return (
    <Formik
      innerRef={formikRef}
      initialValues={ordenTrabajo.OT}
      enableReinitialize="true"
      validationSchema={validationSchemaEndoso}
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
                {/*  <a onClick={() => ReloadPrices('')}>Reload</a> */}
                <ModalDocumentos UrlServicio={UrlServicio} Modulo={'E'} ModuloPadre={Modulo} UrlPagina={UrlPagina} OnSelect={(e) => { }} Data={ordenTrabajo.OT.Documento ? ordenTrabajo.OT.Documento : ''} />
              </div>
            </div>
            <div className='col-md-10 text-right'>
              <AllowElement PermisoAccion="Nuevo"><a className='btn btn-primary btn-s' data-toggle="tooltip" data-placement="bottom" title="Nuevo" onClick={() => NewOrden()}><i className="fa fa-plus" aria-hidden="true"></i></a></AllowElement>
              <AllowElement PermisoAccion="Editar"><button className="btn btn-primary btn-s" type="submit" data-toggle="tooltip" data-placement="bottom" title="Guardar"><i className="fa fa-floppy-o" aria-hidden="true"></i></button></AllowElement>
              <AllowElement PermisoAccion="Honorarios"><a className='btn btn-primary btn-s' disabled={values.IsSaved == null ? true : false} onClick={() => { ChildrenkRef.current.Reload(), $('#ModalComH').modal('show') }} data-toggle="tooltip" data-placement="bottom" title="Honorarios"><i className="fa fa-money" aria-hidden="true"></i></a></AllowElement>
              <AllowElement PermisoAccion="Recalcular"><a className='btn btn-primary btn-s' disabled={values.IsSaved == null ? true : false} onClick={() => { RealoadHonorarios() }} data-toggle="tooltip" data-placement="bottom" title="Recalcular Honorarios"><i className='fa fa-refresh' aria-hidden="true"></i></a></AllowElement>
              {/* <AllowElement PermisoAccion="Renovar"><a className='btn btn-primary btn-s' disabled={true} onClick={() => AddRenovacion()} data-toggle="tooltip" data-placement="bottom" title="Renovar"><i className="fa fa-retweet" aria-hidden="true"></i></a></AllowElement> */}
              <AllowElement PermisoAccion="Bitacora"> <a className="btn btn-primary btn-s" disabled={Id == undefined ? true : false} onClick={() => OpenAction("BITACORA")} data-toggle="tooltip" data-placement="bottom" title="Bitacora"><i className="fa fa-file-text-o" aria-hidden="true"></i></a></AllowElement>
              <AllowElement PermisoAccion="Carga-documentos"><a className="btn btn-primary btn-s" disabled={Id == undefined ? true : false} onClick={() => { ModalFileUploadRef.current.Open() }} data-toggle="tooltip" data-placement="bottom" title="Documentos" ><i className="fa fa-folder-open" aria-hidden="true"></i></a></AllowElement>
              {/* <AllowElement PermisoAccion="Carga-documentos"> <a className="btn btn-primary btn-s" disabled={Id == undefined ? true : false} onClick={() => OpenAction("DOCUMENT")} data-toggle="tooltip" data-placement="bottom" title="Documentos" ><i className="fa fa-folder-open" aria-hidden="true"></i></a></AllowElement> */}
              {/* <AllowElement PermisoAccion="Copiar"> <a className="btn btn-primary btn-s" disabled={true} onClick={() => { CopyDocumento() }} data-toggle="tooltip" data-placement="bottom" title="Copiar Documento" ><i className="fa fa-clone" aria-hidden="true"></i></a></AllowElement> */}
              <AllowElement PermisoAccion="Cancelar"> <a className="btn btn-primary btn-s" disabled={values.IsSaved == null ? true : false} onClick={() => { $('#ModalCancelar').modal('show') }} data-toggle="tooltip" data-placement="bottom" title="Cancelar Documento" ><i className="fa fa-times-circle-o" aria-hidden="true"></i></a></AllowElement>
              <AllowElement PermisoAccion="Eliminar"><a className='btn btn-primary btn-s' disabled={Id == undefined ? true : false} onClick={() => DeleteDocument()} data-toggle="tooltip" data-placement="bottom" title="Eliminar"><i className="fa fa-trash" aria-hidden="true"></i></a></AllowElement>
              <a className="btn btn-primary btn-s" onClick={() => { window.location = Modulo == "P" ? `${UrlPagina}servicioSistema/OrdenTrabajoEdit/${IdDoc}` : `${UrlPagina}servicioSistema/FianzaEdit/${IdDoc}` }} data-toggle="tooltip" data-placement="bottom" title="Regresar" ><i className="fa fa-reply" aria-hidden="true"></i></a>
            </div>
          </div>
          <div className='row'>
            <div className='col-md-9'>
              <div className='row mt-3'>
                <div className='col-md-12'>
                  <div className='row'>
                    <div className='col-md-12'>
                      <h5>Datos del documento</h5>
                      <hr />
                    </div>
                  </div>
                  <div className='row'>
                    <div className='col-md-3'>
                      <div className='form-group'>
                        <label>Cliente</label>
                        <input className='form-control input-sm' disabled={true} value={state.InitialData.Referencia.Cliente ? state.InitialData.Referencia.Cliente : ''} />
                      </div>
                    </div>
                    <div className='col-md-3'>
                      <div className='form-group'>
                        <label>RFC</label>
                        <input className='form-control input-sm' disabled={true} value={state.InitialData.Referencia.RFC ? state.InitialData.Referencia.RFC : ''} />
                      </div>
                    </div>
                    <div className='col-md-3'>
                      <div className='form-group'>
                        <label>Ramo</label>
                        <input className='form-control input-sm' disabled={true} value={state.InitialData.Referencia.Ramo ? state.InitialData.Referencia.Ramo : ''} />
                      </div>
                    </div>
                    <div className='col-md-3'>
                      <div className='form-group'>
                        <label>Forma Pago</label>
                        <input className='form-control input-sm' disabled={true} value={state.InitialData.Referencia.FPago ? state.InitialData.Referencia.FPago : ''} />
                      </div>
                    </div>
                  </div>
                  <div className='row'>
                    <div className='col-md-3'>
                      <div className='form-group'>
                        <label>Grupo</label>
                        <input className='form-control input-sm' disabled={true} value={state.InitialData.Referencia.Grupo ? state.InitialData.Referencia.Grupo : ''} />
                      </div>
                    </div>
                    <div className='col-md-3'>
                      <div className='form-group'>
                        <label>SubGrupo</label>
                        <input className='form-control input-sm' disabled={true} value={state.InitialData.Referencia.SubGrupo ? state.InitialData.Referencia.SubGrupo : ''} />
                      </div>
                    </div>
                    <div className='col-md-3'>
                      <div className='form-group'>
                        <label>Compania</label>
                        <input className='form-control input-sm' disabled={true} value={state.InitialData.Referencia.CiaNombre ? state.InitialData.Referencia.CiaNombre : ''} />
                      </div>
                    </div>
                    <div className='col-md-3'>
                      <div className='form-group'>
                        <label>Moneda</label>
                        <input className='form-control input-sm' disabled={true} value={state.InitialData.Referencia.Moneda ? state.InitialData.Referencia.Moneda : ''} />
                      </div>
                    </div>
                  </div>
                  <div className='row'>
                    <div className='col-md-3'>
                      <div className='form-group'>
                        <label>Documento</label>
                        <input className='form-control input-sm' disabled={true} value={state.InitialData.Referencia.Documento ? state.InitialData.Referencia.Documento : ''} />
                      </div>
                    </div>
                    <div className='col-md-3'>
                      <div className='form-group'>
                        <label>Inciso</label>
                        <input className='form-control input-sm' disabled={true} value={state.InitialData.Referencia.Inciso ? state.InitialData.Referencia.Inciso : ''} />
                      </div>
                    </div>
                    <div className='col-md-3'>
                      <div className='form-group'>
                        <label>Agente</label>
                        <input className='form-control input-sm' disabled={true} value={state.InitialData.Referencia.AgenteNombre ? state.InitialData.Referencia.AgenteNombre : ''} />
                      </div>
                    </div>
                    <div className='col-md-3'>
                      <div className='form-group'>
                        <label>T Cambio</label>
                        <input className='form-control input-sm' disabled={true} value={state.InitialData.Referencia.TCambio ? state.InitialData.Referencia.TCambio : ''} />
                      </div>
                    </div>
                  </div>
                  <div className='row'>
                    <div className='col-md-12'>
                      <h5>DATOS DEL ENDOSO</h5>
                      <hr />
                    </div>
                  </div>
                  <div className='row'>
                    <div className='col-md-3'>
                      <div className="form-group">
                        <label htmlFor="txMotivo">Tipo Doc</label>
                        <Select
                          placeholder="Selecione"
                          id="TipoDocto"
                          name="TipoDocto"
                          styles={colourStyles}
                          onChange={v => { setFieldValue("TipoDocto", v.value) }}
                          onBlur={handleBlur}
                          value={displayitem(values.TipoDocto, state.InitialData.TipoDocumento)}
                          options={mapitems(state.InitialData.TipoDocumento ? state.InitialData.TipoDocumento : [], '')}
                          noOptionsMessage={() => "Sin opciones"}
                        />
                        <span className="help-block">{errors.TipoDocto}</span>
                      </div>
                    </div>
                    <div className='col-md-3'>
                      <div className="form-group">
                        <label htmlFor="txMotivo">No. Solicitud</label>
                        <input
                          className="form-control input-sm"
                          type="text"
                          name="Solicitud"
                          id="Solicitud"
                          onChange={(e) => { setFieldValue('Solicitud', UpperCaseField(e.target.value)) }}
                          onFocus={FocusInput}
                          //onChange={handleChange}
                          value={values.Solicitud ? values.Solicitud : ''}
                        />
                        <span className="help-block">{errors.Solicitud}</span>
                      </div>
                    </div>
                    <div className='col-md-3'>
                      <div className="form-group">
                        <label htmlFor="txMotivo">Desde</label>
                        <input
                          disabled={true}
                          className="form-control input-sm"
                          value={moment(state.InitialData.Referencia.FDesde ? state.InitialData.Referencia.FDesde : '').format("DD/MM/YYYY")}
                        />
                      </div>
                    </div>
                    <div className='col-md-3'>
                      <div className="form-group">
                        <label htmlFor="txMotivo">Hasta</label>
                        <input
                          disabled={true}
                          className="form-control input-sm"
                          value={moment(state.InitialData.Referencia.FHasta ? state.InitialData.Referencia.FHasta : '').format("DD/MM/YYYY")}
                        />
                      </div>
                    </div>
                  </div>
                  <div className='row'>
                    <div className='col-md-3'>
                      <div className="form-group">
                        <label htmlFor="txMotivo">Endoso</label>
                        <input
                          className="form-control input-sm"
                          type="text"
                          name="Endoso"
                          id="Endoso"
                          onChange={(e) => { setFieldValue('Endoso', UpperCaseField(e.target.value)) }}
                          onFocus={FocusInput}
                          //onChange={handleChange}
                          value={values.Endoso ? values.Endoso : ''}
                        />
                        <span className="help-block">{errors.Endoso}</span>
                      </div>
                    </div>
                    <div className='col-md-3'>
                      <div className="form-group">
                        <label htmlFor="txMotivo">Tipo Endoso</label>
                        <Select
                          placeholder="Selecione"
                          id="Tipo"
                          name="Tipo"
                          styles={colourStyles}
                          onChange={v => {
                            var Find = state.InitialData.TipoEndoso.find(x => x.Id === v.value);
                            setFieldValue("Tipo", v.value), setFieldValue("TipoE", Find.Tipo);
                            setIsDisabled(Find.Nombre == "Modificacion" ? true : false);
                          }}
                          onBlur={() => { handleBlur, ReloadPrices(null), ReloadInd() }}
                          value={displayitem(values.Tipo, state.InitialData.TipoEndoso)}
                          options={mapitems(state.InitialData.TipoEndoso ? state.InitialData.TipoEndoso : [], '')}
                          noOptionsMessage={() => "Sin opciones"}
                          title={"Tipo Endoso"}
                        />
                        <span className="help-block">{errors.Tipo}</span>
                      </div>
                    </div>
                    <div className='col-md-3'>
                      <div className="form-group">
                        <label htmlFor="txMotivo">Desde</label>
                        <input
                          className="form-control input-sm"
                          type="date"
                          name="FDesde"
                          id="FDesde"
                          onBlur={() => {
                            handleBlur
                            //setFieldValue('FHasta', moment(values.FDesde).add(1, 'years'))
                          }}
                          onChange={handleChange}
                          value={values.FDesde ? moment(values.FDesde).format("YYYY-MM-DD") : ''}
                          data-toggle="tooltip" data-placement="bottom" title="Desde"
                        />
                        <span className="help-block">{errors.FDesde}</span>
                      </div>
                    </div>
                    <div className='col-md-3'>
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

                  </div>
                  <div className='row'>
                    <div className='col-md-6'>
                      <div className="form-group">
                        <label htmlFor="txMotivo">Referencia 1</label>
                        <input
                          className="form-control input-sm"
                          type="text"
                          name="Referencia1"
                          id="Referencia1"
                          onChange={(e) => { setFieldValue('Referencia1', UpperCaseField(e.target.value)) }}
                          onFocus={FocusInput}
                          //onChange={handleChange}
                          value={values.Referencia1 ? values.Referencia1 : ''}
                        />
                        <span className="help-block">{errors.Referencia1}</span>
                      </div>
                    </div>
                    <div className='col-md-6'>
                      <div className="form-group">
                        <label htmlFor="txMotivo">Referencia 2</label>
                        <input
                          className="form-control input-sm"
                          type="text"
                          name="Referencia2"
                          id="Referencia2"
                          onChange={(e) => { setFieldValue('Referencia2', UpperCaseField(e.target.value)) }}
                          onFocus={FocusInput}
                          //onChange={handleChange}
                          value={values.Referencia2 ? values.Referencia2 : ''}
                        />
                        <span className="help-block">{errors.Referencia2}</span>
                      </div>
                    </div>
                  </div>
                  <div className='row'>
                    <div className='col-md-9'>
                      <div className="form-group">
                        <label htmlFor="txMotivo">Concepto </label>
                        <input
                          className="form-control input-sm"
                          type="text"
                          name="Concepto"
                          id="Concepto"
                          onChange={(e) => { setFieldValue('Concepto', UpperCaseField(e.target.value)) }}
                          onFocus={FocusInput}
                          //onChange={handleChange}
                          value={values.Concepto ? values.Concepto : ''}
                        />
                        <span className="help-block">{errors.Concepto}</span>
                      </div>
                    </div>
                    <div className='col-md-3'>
                      <div className="form-group">
                        <label htmlFor="txMotivo">Estatus usuario</label>
                        <Select
                          placeholder="Selecione"
                          id="EstatusUsuario"
                          name="EstatusUsuario"
                          styles={colourStyles}
                          onChange={v => { setFieldValue("EstatusUsuario", v.value) }}
                          onBlur={handleBlur}
                          value={displayitem(values.EstatusUsuario, state.InitialData.EstatusUsuario)}
                          options={mapitems(state.InitialData.EstatusUsuario ? state.InitialData.EstatusUsuario : [], '')}
                          noOptionsMessage={() => "Sin opciones"}
                          title={"Dirección"}

                        />
                      </div>
                    </div>
                  </div>
                  <div className='row'>
                    <div className='col-md-12'>
                      <h5>REGISTRO DE FECHAS</h5>
                      <hr />
                    </div>
                  </div>
                  <div className='row'>
                    <div className='col-md-3'>
                      <div className="form-group">
                        <label htmlFor="txMotivo">Fecha solicitud</label>
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
                    <div className='col-md-3'>
                      <div className="form-group">
                        <label htmlFor="txMotivo">Captura</label>
                        <input
                          className="form-control input-sm"
                          type="date"
                          name="FCaptura"
                          id="FCaptura"
                          onChange={handleChange}
                          value={values.FCaptura ? moment(values.FCaptura).format("YYYY-MM-DD") : ''}
                        />
                      </div>
                    </div>
                    <div className='col-md-3'>
                      <div className="form-group">
                        <label htmlFor="txMotivo">Envio</label>
                        <input
                          className="form-control input-sm"
                          type="date"
                          name="FEnvio"
                          id="FEnvio"
                          onChange={handleChange}
                          value={values.FEnvio ? moment(values.FEnvio).format("YYYY-MM-DD") : ''}
                        />
                      </div>
                    </div>
                    <div className='col-md-3'>
                      <div className="form-group">
                        <label htmlFor="txMotivo">Folio no.</label>
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
                  </div>
                  <div className='row'>
                    <div className='col-md-3'>
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
                    <div className='col-md-3'>
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
                    <div className='col-md-3'>
                      <div className="form-group">
                        <label htmlFor="txMotivo">Conversion</label>
                        <input
                          className="form-control input-sm"
                          type="date"
                          name="FConversion"
                          id="FConversion"
                          onChange={handleChange}
                          value={values.FConversion ? moment(values.FConversion).format("YYYY-MM-DD") : ''}
                        />
                      </div>
                    </div>
                    <div className='col-md-3'>
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
                        className='form-control input-sm numeric'
                        onBlur={(e) => { NewReloadPrices("PrimaNeta", e.target.value) /* ReloadPrices(null) */ }}
                        min={0}
                        maxLength={10}
                        disabled={IsDisabled}
                        prefix={values.Tipo == -1 ? "-" : ""}
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
                        className='form-control input-sm numeric'
                        onBlur={(e) => { NewReloadPrices("Descuento", e.target.value) /*  handleBlur,  *//* ReloadPrices('') */ }}
                        disabled={IsDisabled}
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
                        className='form-control input-sm numeric'
                        disabled={IsDisabled}
                        onBlur={(e) => { NewReloadPrices("PDescuento", e.target.value) /* handleBlur, */ /* ReloadPrices(null) */ }}
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
              {/* Opciones de poliza */}
              {Modulo == "P" && (
                <>
                  <div className='row mt-2'>
                    <div className='col-md-12'>
                      <div className="form-group row">
                        <div className='col-sm-3' style={{ paddingRight: 'unset' }}>
                          <label className='col-form-label titulo'>Recargos</label>
                        </div>
                        <div className="col-sm-4" style={{ paddingRight: 'unset' }}>
                          <CurrencyInputField
                            className='form-control input-sm numeric'
                            disabled={IsDisabled}
                            onBlur={(e) => {
                              NewReloadPrices("Recargos", e.target.value) /* handleBlur, */ /* ReloadPrices('') *//* , setTimeout(() => {
                              ReloadPrices(null)
                              //alert('Prueba');
                            }, 100) */
                            }}
                            min={0}
                            maxLength={10}
                            //prefix='$'
                            decimalSeparator='.'
                            groupSeparator=','
                            decimalsLimit={2}
                            decimalScale={2}
                            onFocus={FocusInput}
                            allowNegativeValue={false}
                            value={values.Recargos ? values.Recargos : '0'}
                            onValueChange={(value, name) => { setFieldValue(name, value) }}
                            id='Recargos'
                            name='Recargos'
                            autoComplete='off'
                          />
                        </div>
                        <div className="col-sm-4 unsetPadding" style={{ paddingRight: 'unset' }}>
                          <CurrencyInputField
                            disabled={IsDisabled}
                            className='form-control input-sm numeric'
                            onBlur={(e) => { NewReloadPrices("PorRecargos", e.target.value) /*  handleBlur, */ /* ReloadPrices(null) */ }}
                            min={0}
                            maxLength={10}
                            prefix=''
                            decimalSeparator='.'
                            groupSeparator=','
                            decimalsLimit={4}
                            decimalScale={4}
                            onFocus={FocusInput}
                            allowNegativeValue={false}
                            value={values.PorRecargos ? values.PorRecargos : '0'}
                            onValueChange={(value, name) => { setFieldValue(name, value) }}
                            id='PorRecargos'
                            name='PorRecargos'
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
                        <div className="col-sm-8" style={{ paddingRight: 'unset' }}>
                          <CurrencyInputField
                            className='form-control input-sm numeric'
                            onBlur={(e) => { NewReloadPrices("Derechos", e.target.value) /*  handleBlur, */ /* ReloadPrices(null) */ }}
                            min={0}
                            disabled={IsDisabled}
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
                            className='form-control input-sm numeric'
                            onBlur={(e) => { NewReloadPrices("IVA", e.target.value) /* handleBlur, */ /* ReloadPrices('IVA') */ }}
                            min={0}
                            maxLength={10}
                            disabled={IsDisabled}
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
                            className='form-control input-sm numeric'
                            onBlur={(e) => { NewReloadPrices("PorIVA", e.target.value) /* handleBlur, */ /* ReloadPrices(null) */ }}
                            min={0}
                            maxLength={10}
                            prefix=''
                            decimalSeparator='.'
                            groupSeparator=','
                            decimalsLimit={4}
                            decimalScale={4}
                            disabled={IsDisabled}
                            onFocus={FocusInput}
                            allowNegativeValue={false}
                            value={values.PorIVA ? values.PorIVA : '16'}
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
                          <label className='col-form-label titulo'>Ajuste</label>
                        </div>
                        <div className="col-sm-8" style={{ paddingRight: 'unset' }}>
                          <CurrencyInputField
                            className='form-control input-sm numeric'
                            onBlur={(e) => { NewReloadPrices("Ajuste", e.target.value) /* handleBlur, */ /* ReloadPrices(null) */ }}
                            min={0}
                            maxLength={10}
                            disabled={IsDisabled}
                            //prefix='$'
                            decimalSeparator='.'
                            groupSeparator=','
                            decimalsLimit={2}
                            decimalScale={2}
                            onFocus={FocusInput}
                            allowNegativeValue={false}
                            value={values.Ajuste ? values.Ajuste : '0'}
                            onValueChange={(value, name) => { setFieldValue(name, value) }}
                            id='Ajuste'
                            name='Ajuste'
                            autoComplete='off'
                          />
                        </div>
                      </div>
                    </div>
                  </div>
                </>
              )}
              {Modulo == "F" && (
                <>
                  <div className='row mt-2'>
                    <div className='col-md-12'>
                      <div className="form-group row">
                        <div className='col-sm-3' style={{ paddingRight: 'unset' }}>
                          <label className='col-form-label titulo'>Derechos</label>
                        </div>
                        <div className="col-sm-4" style={{ paddingRight: 'unset' }}>
                          <CurrencyInputField
                            className='form-control input-sm numeric'
                            onBlur={(e) => { NewReloadPrices("Derechos", e.target.value) /* handleBlur, */ /* ReloadPrices('') */ }}
                            min={0}
                            disabled={IsDisabled}
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
                            className='form-control input-sm numeric'
                            onBlur={(e) => { NewReloadPrices("PorDerechos", e.target.value) /*  handleBlur, */ /* ReloadPrices(null) */ }}
                            disabled={IsDisabled}
                            min={0}
                            maxLength={10}
                            prefix=''
                            decimalSeparator='.'
                            groupSeparator=','
                            decimalsLimit={4}
                            decimalScale={4}
                            onFocus={FocusInput}
                            allowNegativeValue={false}
                            value={values.PorDerechos ? values.PorDerechos : '0'}
                            onValueChange={(value, name) => { setFieldValue(name, value) }}
                            id='PorDerechos'
                            name='PorDerechos'
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
                          <label className='col-form-label titulo'>Gtos Maq</label>
                        </div>
                        <div className="col-sm-8" style={{ paddingRight: 'unset' }}>

                          <CurrencyInputField
                            disabled={IsDisabled}
                            className='form-control input-sm numeric'
                            onBlur={(e) => { NewReloadPrices("GastosMaquila", e.target.value) /* handleBlur, */ /* ReloadPrices(null) */ }}
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
                            onValueChange={(value, name) => { setFieldValue(name, value) }}
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
                          <label className='col-form-label titulo'>Gtos Adm</label>
                        </div>
                        <div className="col-sm-8" style={{ paddingRight: 'unset' }}>

                          <CurrencyInputField
                            className='form-control input-sm numeric'
                            onBlur={(e) => { NewReloadPrices("GastosAdmin", e.target.value) /* handleBlur, */ /* ReloadPrices(null) */ }}
                            min={0}
                            disabled={IsDisabled}
                            maxLength={10}
                            //prefix='$'
                            decimalSeparator='.'
                            groupSeparator=','
                            decimalsLimit={2}
                            decimalScale={2}
                            onFocus={FocusInput}
                            allowNegativeValue={false}
                            value={values.GastosAdmin ? values.GastosAdmin : '0'}
                            onValueChange={(value, name) => { setFieldValue(name, value) }}
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
                            className='form-control input-sm numeric'
                            onBlur={(e) => { NewReloadPrices("IVA", e.target.value) /* handleBlur, *//*  ReloadPrices('') */ }}
                            disabled={IsDisabled}
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
                            className='form-control input-sm numeric'
                            disabled={IsDisabled}
                            onBlur={(e) => { NewReloadPrices("PorIVA", e.target.value) /* handleBlur, */ /* ReloadPrices(null) */ }}
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
                </>
              )}
              <div className='row mt-2'>
                <div className='col-md-12'>
                  <div className="form-group row">
                    <div className='col-sm-3' style={{ paddingRight: 'unset' }}>
                      <label className='col-form-label titulo'>P Total</label>
                    </div>
                    <div className="col-sm-8" style={{ paddingRight: 'unset' }}>
                      <CurrencyInputField
                        className='form-control input-sm numeric'
                        disabled={IsDisabled}
                        onBlur={(e) => { NewReloadPrices("PrimaTotal", e.target.value) /*  handleBlur, *//*  ReloadPrices(values)  */ }}
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
                <h6>PRIMER RECIBO</h6>
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
                        className='form-control input-sm numeric'
                        disabled={IsDisabled}
                        onBlur={() => { ReloadInd() /* handleBlur *//* , ReloadPrices(values) */ }}
                        min={0}
                        maxLength={10}
                        //prefix='$'
                        decimalSeparator='.'
                        groupSeparator=','
                        decimalsLimit={2}
                        decimalScale={2}
                        onFocus={FocusInput}
                        allowNegativeValue={false}
                        value={values.RPrimaNeta ? values.RPrimaNeta : '0'}
                        onValueChange={(value, name) => { setFieldValue(name, value)/* ,ReloadPrices(values) */ }}
                        id='RPrimaNeta'
                        name='RPrimaNeta'
                        autoComplete='off'
                      />
                      <span className="help-block">{errors.RPrimaNeta}</span>
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
                    <div className="col-sm-8" style={{ paddingRight: 'unset' }}>
                      <CurrencyInputField
                        className='form-control input-sm numeric'
                        onBlur={() => {/*  handleBlur,  */ReloadInd() }}
                        min={0}
                        disabled={IsDisabled}
                        maxLength={10}
                        //prefix='$'
                        decimalSeparator='.'
                        groupSeparator=','
                        decimalsLimit={2}
                        decimalScale={2}
                        onFocus={FocusInput}
                        allowNegativeValue={false}
                        value={values.RDescuento ? values.RDescuento : '0'}
                        onValueChange={(value, name) => { setFieldValue(name, value) }}
                        id='RDescuento'
                        name='RDescuento'
                        autoComplete='off'
                      />
                    </div>
                  </div>
                </div>
              </div>
              {Modulo == "P" && (
                <>
                  <div className='row mt-2'>
                    <div className='col-md-12'>
                      <div className="form-group row">
                        <div className='col-sm-3' style={{ paddingRight: 'unset' }}>
                          <label className='col-form-label titulo'>Recargos</label>
                        </div>
                        <div className="col-sm-8" style={{ paddingRight: 'unset' }}>
                          <CurrencyInputField
                            className='form-control input-sm numeric'
                            disabled={IsDisabled}
                            onBlur={() => { /* handleBlur, */ ReloadInd() }}
                            min={0}
                            maxLength={10}
                            //prefix='$'
                            decimalSeparator='.'
                            groupSeparator=','
                            decimalsLimit={2}
                            decimalScale={2}
                            onFocus={FocusInput}
                            allowNegativeValue={false}
                            value={values.RRecargos ? values.RRecargos : '0'}
                            onValueChange={(value, name) => { setFieldValue(name, value) }}
                            id='RRecargos'
                            name='RRecargos'
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
                        <div className="col-sm-8" style={{ paddingRight: 'unset' }}>
                          <CurrencyInputField
                            className='form-control input-sm numeric'
                            disabled={IsDisabled}
                            onBlur={() => {/*  handleBlur, */ ReloadInd() }}
                            min={0}
                            maxLength={10}
                            //prefix='$'
                            decimalSeparator='.'
                            groupSeparator=','
                            decimalsLimit={4}
                            decimalScale={4}
                            onFocus={FocusInput}
                            allowNegativeValue={false}
                            value={values.RDerechos ? values.RDerechos : '0'}
                            onValueChange={(value, name) => { setFieldValue(name, value) }}
                            id='RDerechos'
                            name='RDerechos'
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
                            onBlur={() => { /* handleBlur, */ ReloadInd() }}
                            min={0}
                            maxLength={10}
                            //prefix='$'
                            decimalSeparator='.'
                            groupSeparator=','
                            decimalsLimit={2}
                            decimalScale={2}
                            onFocus={FocusInput}
                            allowNegativeValue={false}
                            value={values.RSubTotal ? values.RSubTotal : '0'}
                            onValueChange={(value, name) => { setFieldValue(name, value) }}
                            id='RSubTotal'
                            name='RSubTotal'
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
                        <div className="col-sm-8" style={{ paddingRight: 'unset' }}>

                          <CurrencyInputField
                            className='form-control input-sm numeric'
                            onBlur={() => { /* handleBlur, */ ReloadPrices(values) }}
                            min={0}
                            disabled={IsDisabled}
                            maxLength={10}
                            //prefix='$'
                            decimalSeparator='.'
                            groupSeparator=','
                            decimalsLimit={2}
                            decimalScale={2}
                            onFocus={FocusInput}
                            allowNegativeValue={false}
                            value={values.RIVA ? values.RIVA : '0'}
                            onValueChange={(value, name) => { setFieldValue(name, value) }}
                            id='RIVA'
                            name='RIVA'
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
                          <label className='col-form-label titulo'>Ajuste</label>
                        </div>
                        <div className="col-sm-8" style={{ paddingRight: 'unset' }}>
                          <CurrencyInputField
                            className='form-control input-sm numeric'
                            onBlur={() => { /* handleBlur, */ ReloadInd() }}
                            min={0}
                            disabled={IsDisabled}
                            maxLength={10}
                            //prefix='$'
                            decimalSeparator='.'
                            groupSeparator=','
                            decimalsLimit={2}
                            decimalScale={2}
                            onFocus={FocusInput}
                            allowNegativeValue={false}
                            value={values.RAjuste ? values.RAjuste : '0'}
                            onValueChange={(value, name) => { setFieldValue(name, value) }}
                            id='RAjuste'
                            name='RAjuste'
                            autoComplete='off'
                          />
                        </div>
                      </div>
                    </div>
                  </div>
                </>
              )}
              {Modulo == "F" && (
                <>
                  <div className='row mt-2'>
                    <div className='col-md-12'>
                      <div className="form-group row">
                        <div className='col-sm-3' style={{ paddingRight: 'unset' }}>
                          <label className='col-form-label titulo'>Derechos</label>
                        </div>
                        <div className="col-sm-8" style={{ paddingRight: 'unset' }}>
                          <CurrencyInputField
                            className='form-control input-sm numeric'
                            onBlur={() => {/*  handleBlur, */ ReloadInd() }}
                            min={0}
                            maxLength={10}
                            //prefix='$'
                            decimalSeparator='.'
                            disabled={IsDisabled}
                            groupSeparator=','
                            decimalsLimit={2}
                            decimalScale={2}
                            onFocus={FocusInput}
                            allowNegativeValue={false}
                            value={values.RDerechos ? values.RDerechos : '0'}
                            onValueChange={(value, name) => { setFieldValue(name, value) }}
                            id='RDerechos'
                            name='RDerechos'
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
                          <label className='col-form-label titulo'>Gtos Maq</label>
                        </div>
                        <div className="col-sm-8" style={{ paddingRight: 'unset' }}>
                          <CurrencyInputField
                            className='form-control input-sm numeric'
                            onBlur={() => { /* handleBlur, */ ReloadInd() }}
                            disabled={IsDisabled}
                            min={0}
                            maxLength={10}
                            //prefix='$'
                            decimalSeparator='.'
                            groupSeparator=','
                            decimalsLimit={2}
                            decimalScale={2}
                            onFocus={FocusInput}
                            allowNegativeValue={false}
                            value={values.RGastosMaquila ? values.RGastosMaquila : '0'}
                            onValueChange={(value, name) => { setFieldValue(name, value) }}
                            id='RGastosMaquila'
                            name='RGastosMaquila'
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
                          <label className='col-form-label titulo'>Gtos Adm</label>
                        </div>
                        <div className="col-sm-8" style={{ paddingRight: 'unset' }}>
                          <CurrencyInputField
                            className='form-control input-sm numeric'
                            onBlur={() => { /* handleBlur, */ ReloadInd() }}
                            min={0}
                            maxLength={10}
                            disabled={IsDisabled}
                            //prefix='$'
                            decimalSeparator='.'
                            groupSeparator=','
                            decimalsLimit={2}
                            decimalScale={2}
                            onFocus={FocusInput}
                            allowNegativeValue={false}
                            value={values.RGatsosAdm ? values.RGatsosAdm : '0'}
                            onValueChange={(value, name) => { setFieldValue(name, value) }}
                            id='RGatsosAdm'
                            name='RGatsosAdm'
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
                            onBlur={() => { /* handleBlur, */ ReloadInd() }}
                            min={0}
                            maxLength={10}
                            //prefix='$'
                            decimalSeparator='.'
                            groupSeparator=','
                            decimalsLimit={2}
                            decimalScale={2}
                            onFocus={FocusInput}
                            allowNegativeValue={false}
                            value={values.RSubTotal ? values.RSubTotal : '0'}
                            onValueChange={(value, name) => { setFieldValue(name, value) }}
                            id='RSubTotal'
                            name='RSubTotal'
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
                        <div className="col-sm-8" style={{ paddingRight: 'unset' }}>

                          <CurrencyInputField
                            className='form-control input-sm numeric'
                            onBlur={() => { /* handleBlur, */ ReloadPrices(values) }}
                            min={0}
                            maxLength={10}
                            disabled={IsDisabled}
                            //prefix='$'
                            decimalSeparator='.'
                            groupSeparator=','
                            decimalsLimit={2}
                            decimalScale={2}
                            onFocus={FocusInput}
                            allowNegativeValue={false}
                            value={values.RIVA ? values.RIVA : '0'}
                            onValueChange={(value, name) => { setFieldValue(name, value) }}
                            id='RIVA'
                            name='RIVA'
                            autoComplete='off'
                          />
                        </div>
                      </div>
                    </div>
                  </div>
                </>
              )}
              <div className='row mt-2'>
                <div className='col-md-12'>
                  <div className="form-group row">
                    <div className='col-sm-3' style={{ paddingRight: 'unset' }}>
                      <label className='col-form-label titulo'>P Total</label>
                    </div>
                    <div className="col-sm-8" style={{ paddingRight: 'unset' }}>
                      <CurrencyInputField
                        className='form-control input-sm numeric'
                        onBlur={() => {/*  handleBlur, */ ReloadInd() }}
                        min={0}
                        maxLength={10}
                        disabled={IsDisabled}
                        //prefix='$'
                        decimalSeparator='.'
                        groupSeparator=','
                        decimalsLimit={2}
                        decimalScale={2}
                        onFocus={FocusInput}
                        allowNegativeValue={false}
                        value={values.RPrimaTotal ? values.RPrimaTotal : '0'}
                        onValueChange={(value, name) => { setFieldValue(name, value) }}
                        id='RPrimaTotal'
                        name='RPrimaTotal'
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
              {Modulo == "P" && (
                <>
                  <div className='row mt-2'>
                    <div className='col-md-12'>
                      <div className="form-group row">
                        <div className='col-sm-3' style={{ paddingRight: 'unset' }}>
                          <label className='col-form-label titulo'>Neta</label>
                        </div>
                        <div className="col-sm-4" style={{ paddingRight: 'unset' }}>
                          <CurrencyInputField
                            className='form-control input-sm numeric'
                            onBlur={(e) => { NewReloadPrices("ComN", e.target.value) /* handleBlur, */ /* ReloadPrices('') */ }}
                            min={0}
                            disabled={IsDisabled}
                            maxLength={10}
                            //prefix='$'
                            decimalSeparator='.'
                            groupSeparator=','
                            decimalsLimit={2}
                            decimalScale={2}
                            onFocus={FocusInput}
                            allowNegativeValue={false}
                            value={values.ComN ? values.ComN : '0'}
                            onValueChange={(value, name) => { setFieldValue(name, value) }}
                            id='ComN'
                            name='ComN'
                            autoComplete='off'
                          />
                        </div>
                        <div className="col-sm-4 unsetPadding" style={{ paddingRight: 'unset' }}>
                          <CurrencyInputField
                            className='form-control input-sm numeric'
                            onBlur={(e) => { NewReloadPrices("PComN", e.target.value) /* handleBlur, */ /* ReloadPrices(null) */ }}
                            min={0}
                            maxLength={10}
                            prefix=''
                            disabled={IsDisabled}
                            decimalSeparator='.'
                            groupSeparator=','
                            decimalsLimit={4}
                            decimalScale={4}
                            onFocus={FocusInput}
                            allowNegativeValue={false}
                            value={values.PComN ? values.PComN : '0'}
                            onValueChange={(value, name) => { setFieldValue(name, value) }}
                            id='PComN'
                            name='PComN'
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
                          <label className='col-form-label titulo'>Recargos</label>
                        </div>
                        <div className="col-sm-4" style={{ paddingRight: 'unset' }}>
                          <CurrencyInputField
                            className='form-control input-sm numeric'
                            onBlur={(e) => { NewReloadPrices("ComR", e.target.value) /* handleBlur, */ /* ReloadPrices('') */ }}
                            min={0}
                            disabled={IsDisabled}
                            maxLength={10}
                            //prefix='$'
                            decimalSeparator='.'
                            groupSeparator=','
                            decimalsLimit={2}
                            decimalScale={2}
                            onFocus={FocusInput}
                            allowNegativeValue={false}
                            value={values.ComR ? values.ComR : '0'}
                            onValueChange={(value, name) => { setFieldValue(name, value) }}
                            id='ComR'
                            name='ComR'
                            autoComplete='off'
                          />
                        </div>
                        <div className="col-sm-4 unsetPadding" style={{ paddingRight: 'unset' }}>
                          <CurrencyInputField
                            className='form-control input-sm numeric'
                            onBlur={(e) => { NewReloadPrices("PComR", e.target.value) /* handleBlur, */ /* ReloadPrices(null) */ }}
                            min={0}
                            disabled={IsDisabled}
                            maxLength={10}
                            prefix=''
                            decimalSeparator='.'
                            groupSeparator=','
                            decimalsLimit={4}
                            decimalScale={4}
                            onFocus={FocusInput}
                            allowNegativeValue={false}
                            value={values.PComR ? values.PComR : '0'}
                            onValueChange={(value, name) => { setFieldValue(name, value) }}
                            id='PComR'
                            name='PComR'
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
                            className='form-control input-sm numeric'
                            onBlur={(e) => { NewReloadPrices("ComD", e.target.value) /* handleBlur, */ /* ReloadPrices('') */ }}
                            min={0}
                            disabled={IsDisabled}
                            maxLength={10}
                            //prefix='$'
                            decimalSeparator='.'
                            groupSeparator=','
                            decimalsLimit={2}
                            decimalScale={2}
                            onFocus={FocusInput}
                            allowNegativeValue={false}
                            value={values.ComD ? values.ComD : '0'}
                            onValueChange={(value, name) => { setFieldValue(name, value) }}
                            id='ComD'
                            name='ComD'
                            autoComplete='off'
                          />
                        </div>
                        <div className="col-sm-4 unsetPadding" style={{ paddingRight: 'unset' }}>
                          <CurrencyInputField
                            className='form-control input-sm numeric'
                            onBlur={(e) => { NewReloadPrices("PComD", e.target.value) /* handleBlur, */ /* ReloadPrices(null) */ }}
                            min={0}
                            disabled={IsDisabled}
                            maxLength={10}
                            prefix=''
                            decimalSeparator='.'
                            groupSeparator=','
                            decimalsLimit={4}
                            decimalScale={4}
                            onFocus={FocusInput}
                            allowNegativeValue={false}
                            value={values.PComD ? values.PComD : '0'}
                            onValueChange={(value, name) => { setFieldValue(name, value) }}
                            id='PComD'
                            name='PComD'
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
                            className='form-control input-sm numeric'
                            onBlur={(e) => { NewReloadPrices("Especial", e.target.value) /* handleBlur, */ /* ReloadPrices('') */ }}
                            min={0}
                            disabled={IsDisabled}
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
                            className='form-control input-sm numeric'
                            onBlur={(e) => { NewReloadPrices("PEspecial", e.target.value) /* handleBlur, *//*  ReloadPrices(null) */ }}
                            min={0}
                            disabled={IsDisabled}
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
                </>
              )}
              {Modulo == "F" && (
                <>
                  <div className='row mt-2'>
                    <div className='col-md-12'>
                      <div className="form-group row">
                        <div className='col-sm-3' style={{ paddingRight: 'unset' }}>
                          <label className='col-form-label titulo'>Neta</label>
                        </div>
                        <div className="col-sm-4" style={{ paddingRight: 'unset' }}>
                          <CurrencyInputField
                            disabled={IsDisabled}
                            className='form-control input-sm numeric'
                            onBlur={(e) => { NewReloadPrices("ComN", e.target.value) /* ReloadPrices('') */ }}
                            min={0}
                            maxLength={10}
                            //prefix='$'
                            decimalSeparator='.'
                            groupSeparator=','
                            decimalsLimit={2}
                            decimalScale={2}
                            onFocus={FocusInput}
                            allowNegativeValue={false}
                            value={values.ComN ? values.ComN : '0'}
                            onValueChange={(value, name) => { setFieldValue(name, value) }}
                            id='ComN'
                            name='ComN'
                            autoComplete='off'
                          />
                        </div>
                        <div className="col-sm-4 unsetPadding" style={{ paddingRight: 'unset' }}>
                          <CurrencyInputField
                            className='form-control input-sm numeric'
                            onBlur={(e) => { NewReloadPrices("PComN", e.target.value) /* ReloadPrices(null) */ }}
                            min={0}
                            maxLength={10}
                            disabled={IsDisabled}
                            prefix=''
                            decimalSeparator='.'
                            groupSeparator=','
                            decimalsLimit={4}
                            decimalScale={4}
                            onFocus={FocusInput}
                            allowNegativeValue={false}
                            value={values.PComN ? values.PComN : '0'}
                            onValueChange={(value, name) => { setFieldValue(name, value) }}
                            id='PComN'
                            name='PComN'
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
                            disabled={IsDisabled}
                            className='form-control input-sm numeric'
                            onBlur={(e) => { NewReloadPrices("ComD", e.target.value) /* handleBlur, */ /* ReloadPrices('') */ }}
                            min={0}
                            maxLength={10}
                            //prefix='$'
                            decimalSeparator='.'
                            groupSeparator=','
                            decimalsLimit={2}
                            decimalScale={2}
                            onFocus={FocusInput}
                            allowNegativeValue={false}
                            value={values.ComD ? values.ComD : '0'}
                            onValueChange={(value, name) => { setFieldValue(name, value) }}
                            id='ComD'
                            name='ComD'
                            autoComplete='off'
                          />
                        </div>
                        <div className="col-sm-4 unsetPadding" style={{ paddingRight: 'unset' }}>
                          <CurrencyInputField
                            className='form-control input-sm numeric'
                            onBlur={(e) => { NewReloadPrices("PComD", e.target.value) /* handleBlur, */ /* ReloadPrices(null) */ }}
                            min={0}
                            disabled={IsDisabled}
                            maxLength={10}
                            prefix=''
                            decimalSeparator='.'
                            groupSeparator=','
                            decimalsLimit={4}
                            decimalScale={4}
                            onFocus={FocusInput}
                            allowNegativeValue={false}
                            value={values.PComD ? values.PComD : '0'}
                            onValueChange={(value, name) => { setFieldValue(name, value) }}
                            id='PComD'
                            name='PComD'
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
                          <label className='col-form-label titulo'>Gtos Maq</label>
                        </div>
                        <div className="col-sm-4" style={{ paddingRight: 'unset' }}>
                          <CurrencyInputField
                            className='form-control input-sm numeric'
                            onBlur={(e) => { NewReloadPrices("CGastosMaquila", e.target.value) /* handleBlur, */ /* ReloadPrices('') */ }}
                            min={0}
                            disabled={IsDisabled}
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
                            className='form-control input-sm numeric'
                            onBlur={(e) => { NewReloadPrices("PCGastosMaquila", e.target.value) /* handleBlur, */ /* ReloadPrices(null) */ }}
                            min={0}
                            maxLength={10}
                            prefix=''
                            disabled={IsDisabled}
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
                          <label className='col-form-label titulo'>Gtos Adm</label>
                        </div>
                        <div className="col-sm-4" style={{ paddingRight: 'unset' }}>
                          <CurrencyInputField
                            className='form-control input-sm numeric'
                            onBlur={(e) => { NewReloadPrices("CGastosAdmin", e.target.value) /* handleBlur, */ /* ReloadPrices('')  */ }}
                            min={0}
                            disabled={IsDisabled}
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
                            className='form-control input-sm numeric'
                            onBlur={(e) => { NewReloadPrices("PCGastosAdmin", e.target.value) /* handleBlur, */ /* ReloadPrices(null) */ }}
                            min={0}
                            disabled={IsDisabled}
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
                            className='form-control input-sm numeric'
                            onBlur={(e) => { NewReloadPrices("Especial", e.target.value) /* handleBlur, */ /* ReloadPrices('') */ }}
                            min={0}
                            maxLength={10}
                            disabled={IsDisabled}
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
                            className='form-control input-sm numeric'
                            onBlur={(e) => { NewReloadPrices("PEspecial", e.target.value) /* handleBlur, */ /* ReloadPrices(null) */ }}
                            min={0}
                            maxLength={10}
                            prefix=''
                            disabled={IsDisabled}
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
                </>
              )}
            </div>
          </div>
          {values.TipoDocto != 0 && (
            <div className='row'>
              <div className='col-md-12 pt-5'>
                <div className='row'>
                  <div className='col-md-6'>
                    <h6>LISTADO DE RECIBOS</h6>
                  </div>
                  <div className='col-md-6 text-right'>
                    <AllowElement PermisoAccion="Recibos">
                      {recibos.length == 0 && (
                        <a className='btn btn-primary btn-sm btn-recibos' style={{ marginRight: '5px' }} disabled={Id === undefined ? true : false} onClick={() => GeneraRecibos()}>Generar</a>
                      )}
                      <a className='btn btn-primary btn-sm btn-recibos' style={{ marginRight: '5px' }} disabled={Id === undefined ? true : false} onClick={() => DeleteAllRecibos()}>Eliminar Recibos</a>
                      <a className='btn btn-primary btn-sm btn-recibos' style={{ marginRight: '5px' }} disabled={Id === undefined ? true : false} onClick={() => NuevoRecibo()}>Nuevo Recibo</a>
                      <a className='btn btn-primary btn-sm btn-recibos' style={{ marginRight: '5px' }} disabled={Id === undefined && sendRecibos == false ? true : false} onClick={() => SaveRecibos()}>Guardar Recibos</a>
                      <a className='btn btn-primary btn-sm btn-recibos' style={{ marginRight: '5px' }} disabled={Id === undefined ? true : false} onClick={() => window.location = `${UrlPagina}servicioSistema/recibos/${IdDoc}/E`}>Cobranza</a>
                    </AllowElement>
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
                  Tipo={Modulo}
                />
              </div>
            </div>
          )}
          <ModalCancelar
            Id={values.IDDocto ? values.IDDocto : ''}
            Documento={values.Documento ? values.Documento : ''}
            Modulo={'E'}
            Estatus={state.InitialData.EstatusCancelacion}
            Motivos={state.InitialData.MotivosCancelacion}
            UrlServicio={UrlServicio}
            Callback={() => { InitialData(), InitialDataRegistro() }}
          />

          <ModalRecibos IndexRecibo={IndexRecibo}
            Item={ItemRecibo}
            ItemInfoRecibo={ItemInfoRecibo}
            ChangeValueRecibo={ChangeValueRecibo}
            NewChangeValueRecibo={NewChangeValueRecibo}
            handleBlur={handleBlur}
            FocusInput={FocusInput}
            Tipo={Modulo}
            ReloadAll={ReloadAll}
            UrlServicio={UrlServicio}
            ReloadRecibosSubsecuentes={ReloadRecibosSubsecuentes}
            itemSelected={itemSelected}
            setItemSelected={setItemSelected}
            cancelAction={cancelAction}
            closeModal={closeModal} />

         {/*  <ModalComRevision ref={ChildrenkRef} Monedas={state.InitialData.Monedas} Url={UrlServicio} ListaElementos={configuraciones.listaComisiones} ListaHonorarios={configuraciones.ListaHonorarios} setState={SetConfiguraciones} state={configuraciones} Tipo={'F'} /> */}
         <ModalComRevision ref={ChildrenkRef} ReloadHon={RealoadHonorarios} Modulo={"E"} InitialData={InitialDataRegistro} UrlServicio={UrlServicio} Documento={formikRef.current ? formikRef.current.values : {}} Vendedores={state.InitialData.Vendedores} Agentes={state.InitialData.Agentes} Monedas={state.InitialData.Monedas} Url={UrlServicio} ListaElementos={configuraciones.listaComisiones} ListaHonorarios={configuraciones.ListaHonorarios} setState={SetConfiguraciones} state={configuraciones} Tipo={'E'} />
          <ModalFileManager ref={ModalFileUploadRef} Documento={values.Endoso == "" || values.Endoso == null || values.Endoso == undefined ? values.Solicitud : values.Endoso}
            referencia={'DOCUMENT'} referenciaId={values.Solicitud} />
          {/*   <a className='btn' onClick={()=>console.log('test',state.InitialData)}>test</a> */}
        </form>

      )
      }
    </Formik >
  )
}
