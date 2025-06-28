import React, { useState, useEffect } from "react";
import axios from "axios";
import Select from "react-select";
import DatePicker, { registerLocale } from "react-datepicker";
import { isEmptyArray } from "formik";
import {stylesSelect} from "../common/stylesSelect.js";
import es from "date-fns/locale/es";
registerLocale("es", es);

function get_query(){
  var url = location.search;
  var qs = url.substring(url.indexOf('?') + 1).split('&');
  for(var i = 0, result = {}; i < qs.length; i++){
      qs[i] = qs[i].split('=');
      result[qs[i][0]] = decodeURIComponent(qs[i][1]);
  }
  return result;
}

function PIP(props) {
  const path = window.jQuery("#base_url").attr("data-base-url");
  var partPath =get_query();
  //console.log(partPath)
  var pathlength=Object.keys(partPath).length;
  useEffect(() => {
    const params =
    pathlength > 2
        ? { id: partPath["id"], idPeriodo: partPath["idp"] }
        : { id: partPath["id"] };
    //console.log("para",params);
    const InitialPath =
    pathlength > 2
        ? `${path}PIP/getdataPIPElement`
        : `${path}PIP/getdataPIP`;
    axios.get(InitialPath, { params }).then(function(response) {
      //console.log('respuesta',response.data.data.getLinemanagers);
      setPeriodo(response.data.data.Info.length==0?0:response.data.data.Info[0].evaluacion_periodo_id);
      setInfo(mapEmpleados(response.data.data.Info));
      setManager(mapPuestos(response.data.data.Puestos));
      const managers = mapPuestos(response.data.data.Puestos);
      //console.log('value',mapEmpleados(response.data.data.Info)[0].value)
      //setState({...state,Perido:partPath.length>6?partPath[7]:partPath[4],Empleadoset:mapEmpleados(response.data.data.Info)[0]});
      const empleado_seguimiento=response.data.data.Seguimiento==0?0:response.data.data.Seguimiento[0].empleado_seguimiento_id;
      if (pathlength > 2) {
        const lineManagerupdate = managers.find(
          item =>
            item.value ===empleado_seguimiento
        );
        setState({
          ...state,
          Perido: partPath["idpp"],
          Empleadoset: mapEmpleados(response.data.data.Info)[0],
          Linemanager: response.data.data.getLinemanagers
        });
        setEditEmp("1");
        getdataPIP(
          mapEmpleados(response.data.data.Info)[0].value,
          mapEmpleados(response.data.data.Info)[0],
          partPath["idp"],
          response.data.data.getLinemanagers
        );
      } else {
        setState({ ...state, Perido: algo["id"],Linemanager: response.data.data.getLinemanagers });
      }
    });
  }, []);

  const colourStyles = {
    control: styles => ({
      ...styles,
      backgroundColor: "white",
      borderRadius: "0px",
      minHeight: "34px",
      height: "45px"
    })
  };
  const estadoValues = [
    {
      value: 1,
      label: "BORRADOR"
    },
    {
      value: 2,
      label: "ACTIVO"
    }
  ];
  //estado completos de PIP
  const [state, setState] = useState({
    estadoPrincipal: "",
    creado: "",
    estatus: [],
    Perido: "",
    Empleadoset: [],
    Empleados: [],
    idTask: "",
    Evaluado: "",
    Linemanager: [],
    Comentario: "",
    Items: [],
  });
  const [editEm, setEditEmp] = useState("");
  const [periodo, setPeriodo] = useState("");
  const [idx, setIdx] = useState(0);
  const [onbState, setonbState] = useState("");
  const [def, setDef] = useState([]);
  const [Info, setInfo] = useState([]);
  const [manager, setManager] = useState([]);
  const [puestoColaborador,SetpuestoColaborador]=useState([]);
  const [caja, setCaja] = useState({
    Input1: "",
    Input2: "",
    Input3: "",
    Fecha: ""
  });
  const [defaultE,setdefaultE]=useState({
    Elemento: "",
    Evidencia: "",
    MejoraEsparada: "",
    AccionesACabo: [],
    FechaComp: ""
  })
  const defaultElement = {
    Elemento: caja.Input1,
    Evidencia: "",
    MejoraEsparada: "",
    AccionesACabo: [],
    FechaComp: ""
  };
  function handleInput(e) {
    const { value, name } = e.target;
    setCaja({ ...caja, [name]: value });
  }
  function getdataPIP(value, items, periodo, manager2) {
    const params = {
      idUsuario: value,
      idPerido: periodo === "" ? state.Perido : periodo
    };
    //const params = {idUsuario:value,idPerido:state.Perido};
    axios.get(`${path}PIP/editPIP`, { params }).then(function(response) {
      const linemanager =
        response.data.data.Info.length === 0
          ? ""
          : response.data.data.Info[0].empleado_seguimiento_id;
      const datalog = mapItemsEdit(response.data.data.Taks);
      const estatusget =
        response.data.data.Info.length === 0
          ? "BORRADOR"
          : response.data.data.Info[0].estatus;
      setState({
        ...state,
        estadoPrincipal: estatusget,
        creado: response.data.data.Info.length === 0 ? "0" : "1",
        estatus: estadoValues.find(item => item.label === estatusget),
        Empleadoset: items,
        Linemanager:manager2,
        Items: datalog,
        Comentario:
          response.data.data.Info.length === 0
            ? ""
            : response.data.data.Info[0].comentario,
        idTask:
          response.data.data.Info.length === 0
            ? ""
            : response.data.data.Info[0].id
      });
    });
  }

  function deleteItem(indexl, tipo) {
    const obj = state.Items;
    if (tipo === "Evidencia") {
      const newTodos = obj[idx].Evidencia.filter(
        (_, index) => index !== indexl
      );
      obj[idx].Evidencia = newTodos;
      setState({ ...state, Items: obj });
    } else if (tipo === "Acciones") {
      const newAcciones = obj[idx].AccionesACabo.filter(
        (_, index) => index !== indexl
      );
      obj[idx].AccionesACabo = newAcciones;
      setState({ ...state, Items: obj });
    }else if (tipo === "NuevoE") {
      const elemed=defaultE;
      //console.log('elemed',elemed);
      const newAcciones = elemed.AccionesACabo.filter(
        (_, index) => index !== indexl
      );
      //console.log(newAcciones);
      setdefaultE({...defaultE,AccionesACabo:newAcciones});
      //obj[idx].AccionesACabo = newAcciones;
      //setState({ ...state, Items: obj });
    }
  }

  function deleteInitialItem(indexE) {
      swal({
        title: `¿Está seguro de que quiere eliminar el elemento ${state.Items[indexE].Elemento}?`,
        text: "Una vez eliminado, ¡no podrá recuperar la información del elemento!",
        icon: "warning",
        buttons: ["Cancelar", "Aceptar"],
      }).then((value) => {
          if (value) {
            const newItems = state.Items.filter((_, index) => index !== indexE);
            setState({ ...state, Items: newItems });
            setIdx(0);
          }
      });
    //$("#exampleModalCenter").modal("hide");
  }

  function AddElm() {
    if (caja.Input1 !== "") {
      const Items = state.Items;
      Items.push(defaultElement);
      setState({ ...state, Items: Items });
      setDef(Items);
      //setonbState({...onbState,Items:Items});
      setCaja({ ...state, Input1: "" });
      $("#Input1").focus();
    } else {
      toastr.error("No se pueden agregar valores vacios");
    }
  }
  function AddElmArr(Tipo) {
    const Arry = state.Items;
    if (Tipo === "Evidencia") {
      //console.log("Evidencia", Arry[idx].Evidencia);
      Arry[idx].Evidencia.push(caja.Input2);
      setCaja({ ...caja, Input2: "" });
      $("#Input2").focus();
      setDef(Arry);
    } else if (Tipo === "Mejora") {
      if(idx==-1){
          var elemet=defaultE.AccionesACabo;
          elemet.push({ titulo: caja.Input3 });
          setdefaultE({...defaultE,AccionesACabo:elemet});
          setCaja({ ...caja, Input3: "" });
          $("#Input3").focus();
      }else{
        if (caja.Input3 === undefined || caja.Input3 === "") {
          toastr.error("No se pueden agregar valores vacios");
        } else {
          Arry[idx].AccionesACabo.push({ titulo: caja.Input3 });
          setDef(Arry);
          setCaja({ ...caja, Input3: "" });
          $("#Input3").focus();
        }
      }
    }
  }

  function OnblurDelete(e, indexl, tipo) {
    const obj = state.Items;
    if (e.target.value === "" && tipo === "Evidencia") {
      const newTodos = obj[idx].Evidencia.filter(
        (_, index) => index !== indexl
      );
      obj[idx].Evidencia = newTodos;
    } else if (e.target.value === "" && tipo === "Acciones") {
      const newTodos = obj[idx].AccionesACabo.filter(
        (_, index) => index !== indexl
      );
      obj[idx].AccionesACabo = newTodos;
    } else if (e.target.value === "" && tipo === "Titulo") {
      obj[idx].Elemento = onbState;
    }
    setState({ ...state, Items: obj });
  }

  function changeItem(e, index) {
    const Items = state.Items;
    if (typeof e.target === "undefined") {
      Items[idx].FechaComp = e;
    } else if (e.target.name === "Titulo") {
      Items[idx].Elemento = e.target.value;
      /* if(e.target.value===''){
                Items[idx].Elemento=onbState.Items[idx].Elemento;
            } */
    } else if (e.target.name === "Evidencia") {
      Items[idx].Evidencia = e.target.value;
    } else if (e.target.name === "Espera") {
      Items[idx].MejoraEsparada = e.target.value;
    } else if (e.target.name === "Acciones") {
      Items[idx].AccionesACabo[index].titulo = e.target.value;
    }
    setState({ ...state, Items: Items });
  }

  
  function changeItem2(e, index) {
    const Items = defaultE;
    if (typeof e.target === "undefined") {
      Items.FechaComp = e;
      setdefaultE({...defaultE,FechaComp: e});
      //setdefaultE(...defaultE,Element: e.target.value);
    } else if (e.target.name === "Titulo") {
      //Items.Elemento = e.target.value;
      setdefaultE({...defaultE,Elemento: e.target.value});
    } else if (e.target.name === "Evidencia") {
      //Items.Evidencia = e.target.value;
      setdefaultE({...defaultE,Evidencia: e.target.value});
    } else if (e.target.name === "Espera") {
      //Items.MejoraEsparada = e.target.value;
      setdefaultE({...defaultE,MejoraEsparada: e.target.value});
    } else if (e.target.name === "Acciones") {
      //Items.AccionesACabo[index].titulo = e.target.value;
      //setdefaultE({...defaultE,AccionesACabo[index]: e.target.value});
    }
    //console.log(e.target.value)
    //setdefaultE({...defaultE,Items});
    //setdefaultE({Items});
  }

  function click(index) {
    setIdx(index);
    setonbState(state.Items[index].Elemento);
    $("#exampleModalCenter").modal("show");
    $('a[href="#home"]').tab("show");
  }
  function addManager(v, tipo) {
    if (tipo === "estatus") {
      setState({ ...state, estatus: v });
    } else {
      setState({ ...state, Linemanager: v });
    }
  }
  function addEmpleado(v) {
    getdataPIP(v.value, v, "", "");
  }

  function postData() {
    //console.log("click guardar");
    const istrue = checkStateEmpty();
    let paths = "";
    if (state.creado === "0" && state.estatus.label === "BORRADOR") {
      paths = `${path}PIP/postPip`;
      axios.post(paths, state).then(response => {
        window.toastr.success("Éxito");
        window.location.href = path + "PIP/0";
        /* if (partPath>2) {
          window.location.replace(path + "PIP/" + periodo);
        } */
      });
    } else if (state.creado === "0" && state.estatus.label === "ACTIVO") {
      if (istrue.length === 0) {
        paths = `${path}PIP/postPip`;
        axios.post(paths, state).then(response => {
          window.toastr.success("Éxito");
         window.location.href = path + "PIP/0";
          /* if (partPath> 2) {
            window.location.replace(path + "PIP/" + periodo);
          } */
        });
      } else {
        let someerr = "";
        istrue.forEach((item, key) => {
          let splt = String(item.Elemento).split(",");
          someerr = someerr + splt[0] + " en campo: " + splt[1] + "<br/>";
        });
        window.toastr.error(`Por favor indique los valores: <br/> ${someerr}`);
      }
    } else if (state.creado === "1" && state.estatus.label === "BORRADOR") {
      paths = `${path}PIP/PostEditPIP`;
      axios.post(paths, state).then(response => {
        window.toastr.success("Éxito");
        window.location.href = path + "PIP/0";
        /* if (partPath > 2) {
          window.location.replace(path + "PIP/" + periodo);
        } */
      });
      if (partPath > 2) {
        window.location.replace(path + "PIP/" + periodo);
      }
    } else if (state.creado === "1" && state.estatus.label === "ACTIVO") {
      if (istrue.length === 0) {
        paths = `${path}PIP/PostEditPIP`;
        axios.post(paths, state).then(response => {
          window.toastr.success("Éxito");
          window.location.replace(path + "PIP/0");
          //console.log(path + "PIP/" + periodo);
         // window.location.href = path + "PIP/" + partPath["idpp"];
          /* if (partPath > 2) {
            window.location.replace(path + "PIP/" + periodo);
          } */
        });
      } else {
        let someerr = "";
        istrue.forEach((item, key) => {
          let splt = String(item.Elemento).split(",");
          someerr = someerr + splt[0] + " en campo: " + splt[1] + "<br/>";
        });
        window.toastr.error(`Por favor indique los valores: <br/> ${someerr}`);
      }
    }
  }

  function checkStateEmpty() {
    var errores = [];
    state.Items.forEach((element, index) => {
      if (isEmptyArray(element.AccionesACabo)) {
        errores.push({ Elemento: element.Elemento + "," + "Desempeño" });
      }
      if (element.FechaComp === "" || null) {
        errores.push({ Elemento: element.Elemento + "," + "Fecha" });
      }
    });
    return errores;
  }

  function handleInputChange(e, tipo) {
    if (e.charCode === 13) {
      if (tipo === "Elemento") {
        AddElm();
      } else {
        AddElmArr("Mejora");
      }
    }
  }

  function mapPuestos(respuesta) {
    const _ps = respuesta.map(i => {
      return { value: i.id, label: i.name_complete };
    });
    return _ps;
  }
  function mapEmpleados(respuesta) {
    const _ps = respuesta.map(i => {
      return {
        value: i.idPersona,
        label: i.name_complete,
        Puesto: i.personaPuesto
      };
    });
    return _ps;
  }
  function displayitem(id,array){
    const _array=array;
    const newData = _array.filter((item, index) => item.puesto === id);
    return newData;
  }


  function mapItemsEdit(data) {
    var Items = [],
      Ct = [],
      CtInfo = [];
    const Pt = data.filter(item => item.parent === "0");
    Pt.forEach((item, index) => {
      Ct = data.filter(item2 => item2.parent === item.id);
      Items.push({
        Elemento: item.titulo,
        Evidencia: item.observacion,
        MejoraEsparada: item.resultado_esperado,
        AccionesACabo: Ct,
        FechaComp: item.fecha === "0000-00-00" ? null : item.fecha
      });
    });
    return Items;
  }

  function addElementlist(){
      /* caja.Input1="Nuevo Elemento";
      var index=state.Items.length;
      console.log("index",index);
      AddElm();
      setIdx(index); */
      //setIdx();
    setIdx(-1);
    $("#exampleModalCenter").modal("show");
  }

  function AddnuevoItem(){
      if(defaultE.Elemento!='' && defaultE.MejoraEsparada!='' && defaultE.FechaComp!='' && defaultE.Evidencia && defaultE.AccionesACabo.length>0){
        const Items = state.Items;
        Items.push(defaultE);
        setState({ ...state, Items: Items });
        setIdx(0);
        setdefaultE({...defaultE,
          Elemento:'',
          MejoraEsparada:'',
          FechaComp:'',
          Evidencia:'',
          AccionesACabo:[]
        })
        $("#exampleModalCenter").modal("hide");
      }else{
        window.toastr.error("Complete todos los campos del formulario.");
      }
  }

  return (
    <div className="container-fluid">
   {/*    <button onClick={() => console.log("state", state)}>estate</button> */}
      <div className="row">
        <div className="col-md-12">
          <div className="panel panel-default">
            {state.idTask != 0 && (
              <div className="panel-body">
                <div className="row">
                  <div className="col-md-6">
                    <div className="form-group">
                      <label className="control-label">
                        <strong>Nombre del colaborador</strong>
                      </label>
                      <Select
                        placeholder="Selecione una opción"
                        id="Empleados"
                        name="Empleados"
                        styles={colourStyles}
                        onChange={(v) => {
                          addEmpleado(v);
                        }}
                        value={state.Empleadoset}
                        isDisabled={editEm != ""}
                        options={Info}
                      />
                    </div>
                  </div>
                  <div className="col-md-6">
                    <div className="form-group">
                      <label className="control-label">
                        <strong>Departamento</strong>
                      </label>
                      <p style={{ paddingTop: 10 }}>
                        {state.Empleadoset.length !== 0
                          ? state.Empleadoset.Puesto.toUpperCase()
                          : "No ha seleccionado un colaborador"}
                      </p>
                    </div>
                  </div>
                  <div className="col-md-12">
                    <div className="form-group">
                      <label className="control-label">
                        <strong>Line Manager </strong>
                      </label>
                      <Select
                        placeholder="Selecione una opción"
                        id="Puesto"
                        name="Puesto"
                        styles={stylesSelect("",'1','')}
                        isMulti
                        onChange={(v) => {
                          addManager(v);
                        }}
                        //isMulti={true}
                        isDisabled={
                          state.estadoPrincipal === "ACTIVO" ||
                          state.Empleadoset.length === 0
                            ? true
                            : false
                        }
                        value={state.Linemanager}
                        options={_puestos}
                      />
                    </div>
                  </div>
                </div>
                <div className="row">
                  <div className="col-md-8">
                    <div className="form-group">
                      <label>
                        <strong>Comentarios finales</strong>
                      </label>
                      <textarea
                        disabled={
                          state.estadoPrincipal === "ACTIVO" ||
                          state.Empleadoset.length === 0
                            ? true
                            : false
                        }
                        maxLength={252}
                        value={state.Comentario || ""}
                        className="form-control"
                        name="Comentario"
                        id="Comentario"
                        onChange={(e) =>
                          setState({ ...state, Comentario: e.target.value })
                        }
                      ></textarea>
                      <label className="control-label">
                        Caracteres ingresados:
                        {!state.Comentario
                          ? "0"
                          : state.Comentario.length || ""}{" "}
                        de 252
                      </label>
                    </div>
                  </div>
                  <div className="col-md-4">
                    <div className="form-group">
                      <label
                        className="control-label"
                        style={{ paddingBottom: 5 }}
                      >
                        <strong>Estatus </strong>
                      </label>
                      <Select
                        placeholder="Selecione una opción"
                        id="Estatus"
                        name="Estatus"
                        styles={colourStyles}
                        onChange={(v) => {
                          addManager(v, "estatus");
                        }}
                        value={state.estatus}
                        options={estadoValues}
                        isDisabled={
                          (state.estadoPrincipal === "ACTIVO" &&
                            state.creado === "1") ||
                          state.Empleadoset.length === 0
                            ? true
                            : false
                        }
                      />
                      {state.estadoPrincipal === "ACTIVO" ||
                      state.estatus.label === "ACTIVO" ? (
                        <p>
                          <em>
                            Nota: Si el PIP esta en estado "ACTIVO" no se puede
                            modificar
                          </em>
                        </p>
                      ) : (
                        ""
                      )}
                    </div>
                  </div>
                  {/* <div className="col-md-4" style={{paddingTop:30}}>
                                      <div className="form-group">
                                          {state.estadoPrincipal==='ACTIVO'?<p><em>Nota: Si el PIP esta en estado "ACTIVO" no se puede modificar</em></p>:''} 
                                      </div>
                                  </div> */}
                  {/* <div className="col-md-4" style={{paddingTop:25}}>
                                      <button disabled={state.Items.length===0||state.estadoPrincipal==='ACTIVO'} type="submit" className="btn btn-primary pull-right" onClick={()=>postData()}>
                                          <i className="fa fa-floppy-o" aria-hidden="true"></i> Guardar
                                      </button>
                                  </div> */}
                </div>
                {/* <div className="row">
                                  <div className="col-md-8">
                                      <div className="form-group">
                                          <label><strong>Comentarios finales</strong></label>
                                          <textarea  disabled={state.estadoPrincipal==='ACTIVO'||state.Empleadoset.length===0?true:false} maxLength={252} value={state.Comentario||''} className="form-control" name="Comentario" id="Comentario" onChange={e=>setState({...state,Comentario:e.target.value})}></textarea>
                                         <label className="control-label">Caracteres ingresados:{!state.Comentario?'0':state.Comentario.length||''} de 252</label>
                                      </div>
                                  </div>
                              </div> */}
                <div className="row">
                  <div className="col-md-8">
                    <h4>Lista de elementos a mejorar</h4>
                    <div className="form-group">
                     {/*  <input
                        autoComplete="off"
                        disabled={
                          state.estadoPrincipal === "ACTIVO" ||
                          state.Empleadoset.length === 0
                            ? true
                            : false
                        }
                        placeholder="Ingrese una opción"
                        type="text"
                        value={caja.Input1 || ""}
                        onKeyPress={(e) => handleInputChange(e, "Elemento")}
                        onChange={(e) => handleInput(e)}
                        className="form-control "
                        id="Input1"
                        name="Input1"
                      /> */}
                    </div>
                  </div>
                  <div className="col-md-4">
                  <button className="btn btn-primary  pull-right" onClick={()=>addElementlist()}>
                  <i className="fa fa-plus-circle" aria-hidden="true"></i>{" "}
                    Nuevo elemento</button>
                    {/* <button
                      disabled={
                        state.Items.length === 0 ||
                        state.estadoPrincipal === "ACTIVO"
                      }
                      type="submit"
                      className="btn btn-primary pull-right"
                      onClick={() => postData()}
                    >
                      <i className="fa fa-floppy-o" aria-hidden="true"></i>{" "}
                      Guardar
                    </button> */}
                  </div>
                </div>
                <div className="row">
                  <div className="col-md-12 disabled">
                    <ol
                      id={state.Items.length === 0 ? "" : "lista3"}
                      className={state.Items.length === 0 ? "inicio" : ""}
                      style={{maxHeight:"150px",overflow:'scroll',overflowX:'hidden'}}
                    >
                      {state.Items.length === 0 ? (
                        <li className="text-center">
                          No hay elementos agregados
                        </li>
                      ) : (
                        state.Items.map((item, index) => (
                          <li  key={index}>
                            <div className="row">
                              <div className="col-md-11" onClick={() => click(index)}>
                                <h5>{item.Elemento}</h5>
                              </div>
                              <div className="col-md-1 xCorr">
                                  <a
                                    className="remove"
                                    data-toggle="tooltip"
                                    title="Eliminar elemento"
                                    onClick={
                                      state.estadoPrincipal === "ACTIVO"
                                        ? null
                                        : () => deleteInitialItem(index)
                                    }
                                  >
                                    <i
                                      className="fa fa-times"
                                      aria-hidden="true"
                                    ></i>
                                  </a>
                                </div>
                            </div>
                          </li>
                        ))
                      )}
                    </ol>
                  </div>
                  <div className="col-md-12">
                    <button
                      disabled={
                        state.Items.length === 0 ||
                        state.estadoPrincipal === "ACTIVO"
                      }
                      type="submit"
                      className="btn btn-primary pull-right"
                      onClick={() => postData()}
                    >
                      <i className="fa fa-floppy-o" aria-hidden="true"></i>{" "}
                      Guardar
                    </button>
                  </div>
                </div>
              </div>
            )}
            {state.idTask == 0 && (
              <div className="panel-body">
                <div className="row">
                <div className="col-md-6">
                    <div className="form-group">
                      <label className="control-label">
                        <strong>Puesto del colaborador</strong>
                      </label>
                      <Select
                        placeholder="Selecione una opción"
                        id="Empleados"
                        name="Empleados"
                        styles={stylesSelect("",'1','')}
                        onChange={(v) => {
                          SetpuestoColaborador(v),setState({...state,Empleadoset:[],creado:'0'})
                        }}
                        value={puestoColaborador}
                        noOptionsMessage={()=>"Sin opciones"}
                        options={_puestos}
                      />
                    </div>
                  </div>
                  <div className="col-md-6">
                    <div className="form-group">
                      <label className="control-label">
                        <strong>Colaborador</strong>
                      </label>
                      <Select
                        placeholder="Selecione una opción"
                        id="Empleados"
                        name="Empleados"
                        styles={stylesSelect("",'1','')}
                        onChange={(v) => {
                          setState({...state,Empleadoset:v});
                        }}
                        noOptionsMessage={()=>"Sin opciones"}
                        value={state.Empleadoset}
                        options={displayitem(puestoColaborador.value,_empleados)}
                      />
                    </div>
                  </div>
                  <div className="col-md-12">
                    <div className="form-group">
                      <label className="control-label">
                        <strong>Line Manager </strong>
                      </label>
                      <Select
                        placeholder="Selecione una opción"
                        id="Puesto"
                        name="Puesto"
                        styles={stylesSelect("",'1','')}
                        isMulti
                        noOptionsMessage={()=>"Sin opciones"}
                        onChange={(v) => {
                          addManager(v);
                        }}
                        value={state.Linemanager}
                        options={_puestos}
                      />
                    </div>
                  </div>
                </div>
                <div className="row">
                  <div className="col-md-8">
                    <div className="form-group">
                      <label>
                        <strong>Comentarios finales</strong>
                      </label>
                      <textarea
                        maxLength={252}
                        value={state.Comentario || ""}
                        className="form-control"
                        name="Comentario"
                        id="Comentario"
                        onChange={(e) =>
                          setState({ ...state, Comentario: e.target.value })
                        }
                      ></textarea>
                      <label className="control-label">
                        Caracteres ingresados:
                        {!state.Comentario
                          ? "0"
                          : state.Comentario.length || ""}{" "}
                        de 252
                      </label>
                    </div>
                  </div>
                  <div className="col-md-4">
                    <div className="form-group">
                      <label
                        className="control-label"
                        style={{ paddingBottom: 5 }}
                      >
                        <strong>Estatus </strong>
                      </label>
                      <Select
                        placeholder="Selecione una opción"
                        id="Estatus"
                        name="Estatus"
                        styles={colourStyles}
                        onChange={(v) => {
                          addManager(v, "estatus");
                        }}
                        value={state.estatus}
                        options={estadoValues}
                      />
                      {state.estadoPrincipal === "ACTIVO" ||
                      state.estatus.label === "ACTIVO" ? (
                        <p>
                          <em>
                            Nota: Si el PIP esta en estado "ACTIVO" no se puede
                            modificar
                          </em>
                        </p>
                      ) : (
                        ""
                      )}
                    </div>
                  </div>
                </div>
                <div className="row">
                  <div className="col-md-8">
                    <h4>Lista de elementos a mejorar</h4>
                    <div className="form-group">
                     {/*  <input
                        autoComplete="off"
                        placeholder="Ingrese una opción"
                        type="text"
                        value={caja.Input1 || ""}
                        onKeyPress={(e) => handleInputChange(e, "Elemento")}
                        onChange={(e) => handleInput(e)}
                        className="form-control "
                        id="Input1"
                        name="Input1"
                      /> */}
                    </div>
                  </div>
                  <div className="col-md-4">
                    <button className="btn btn-primary  pull-right" onClick={()=>addElementlist()}>
                    <i className="fa fa-plus-circle" aria-hidden="true"></i>{" "}
                      Nuevo elemento</button>
                    {/* <button
                      disabled={
                        state.Items.length === 0 ||
                        state.estadoPrincipal === "ACTIVO"
                      }
                      type="submit"
                      className="btn btn-primary pull-right"
                      onClick={() => postData()}
                    >
                      <i className="fa fa-floppy-o" aria-hidden="true"></i>{" "}
                      Guardar
                    </button> */}
                  </div>
                  
                </div>
                <div className="row">
                  <div className="col-md-12 disabled">
                  <hr/>
                    <ol
                      id={state.Items.length === 0 ? "" : "lista3"}
                      className={state.Items.length === 0 ? "inicio" : ""}
                      style={{maxHeight:"150px",overflow:'scroll',overflowX:'hidden'}}
                    >
                      {state.Items.length === 0 ? (
                        <li className="text-center">
                          No hay elementos agregados
                        </li>
                      ) : (
                        state.Items.map((item, index) => (
                          <li  key={index}>
                            <div className="row">
                              <div className="col-md-11" onClick={() => click(index)}>
                                <h5>{item.Elemento}</h5>
                              </div>
                              <div className="col-md-1 xCorr">
                                  <a
                                    className="remove"
                                    data-toggle="tooltip"
                                    title="Eliminar elemento"
                                    onClick={
                                      state.estadoPrincipal === "ACTIVO"
                                        ? null
                                        : () => deleteInitialItem(index)
                                    }
                                  >
                                    <i
                                      className="fa fa-times"
                                      aria-hidden="true"
                                    ></i>
                                  </a>
                                </div>
                            </div>
                          </li>
                        ))
                      )}
                    </ol>
                  </div>
                </div>
                <div className="row">
                  <div className="col-md-12">
                    <hr/>
                    <button
                        disabled={
                          state.Items.length === 0 ||
                          state.estadoPrincipal === "ACTIVO"
                        }
                        type="submit"
                        className="btn btn-primary pull-right"
                        onClick={() => postData()}
                      >
                        <i className="fa fa-floppy-o" aria-hidden="true"></i>{" "}
                        Guardar
                      </button>
                  </div>
                </div>
              </div>
            )}
          </div>
        </div>
      </div>
      <div className="col-md-12"></div>
      {/*Inicio del modal*/}
      <div
        className="modal fade bd-example-modal-lg"
        id="exampleModalCenter"
        tabIndex="-1"
        role="dialog"
        aria-labelledby="exampleModalCenterTitle"
        aria-hidden="true"
      >
        <div className="modal-dialog modal-lg" role="document">
          <div className="modal-content">
            {/* <button onClick={()=>console.log('test',defaultE)}>test default</button> */}
            <div className="modal-body">
              <div className="row">
                <div className="col-md-9">
                  <div
                    className="form-group"
                    data-toggle="tooltip"
                    title="Título de la actividad"
                  >
                    <label htmlFor="">Título de la actividad</label>
                    <input
                      autoComplete="off"
                      onBlur={(e) => OnblurDelete(e, 0, "Titulo")}
                      onChange={(e) => idx==-1? changeItem2(e): changeItem(e)}
                      value={
                        !state.Items.length ? defaultE.Elemento : idx==-1?defaultE.Elemento:state.Items[idx].Elemento
                      }
                      className="form-control"
                      name="Titulo"
                    />
                  </div>
                </div>
                <div className="col-md-3">
                  <div
                    className="form-group"
                    data-toggle="tooltip"
                    title="Fecha de compromiso"
                  >
                    <label htmlFor="">Fecha de compromiso</label>
                    <DatePicker
                      locale="es"
                      peekNextMonth
                      showMonthDropdown
                      showYearDropdown
                      name="Fecha"
                      dropdownMode="select"
                      dateFormat="yyyy-MM-dd"
                      className="form-control input-sm"
                      placeholderText="Fecha de compromiso"
                      showPopperArrow={true}
                      disabled={state.estadoPrincipal === "ACTIVO"}
                      selected={state.Items.length === 0?(defaultE.FechaComp &&new Date(defaultE.FechaComp)) ||null : idx==-1?defaultE.FechaComp:(state.Items[idx].FechaComp &&new Date(state.Items[idx].FechaComp)) ||null
                      }
                      //onChange={(e) => changeItem(e)}
                      onChange={(e) =>idx==-1? changeItem2(e): changeItem(e)}
                    />
                  </div>
                </div>
              </div>
              <div className="row ModalHead">
                <hr />
              </div>
              <div className="row">
                <div className="col-md-12">
                  <ul className="nav nav-tabs">
                    <li className="active">
                      <a data-toggle="tab" href="#home">
                        Datos Generales
                      </a>
                    </li>
                    <li>
                      <a data-toggle="tab" href="#menu2">
                        Acciones de desempeño
                      </a>
                    </li>
                  </ul>

                  <div className="tab-content tab-size">
                    <div id="home" className="tab-pane fade in active">
                      <p>
                        <strong>Evidencia</strong>
                      </p>
                      <p>
                        <em>
                          Descripción de la evidencia de los elementos a mejorar
                        </em>
                      </p>
                      <div className="row">
                        <div className="col-md-12">
                          <div className="form-group">
                            <textarea
                              disabled={state.estadoPrincipal === "ACTIVO"}
                              value={state.Items.length === 0? defaultE.Evidencia: idx==-1?defaultE.Evidencia:state.Items[idx].Evidencia
                              }
                              onChange={(e) => idx==-1? changeItem2(e): changeItem(e)}
                              maxLength={252}
                              className="form-control"
                              name="Evidencia"
                              id="Evidencia"
                            ></textarea>
                          </div>
                        </div>
                      </div>
                      <p>
                        <strong>Mejora</strong>
                      </p>
                      <p>
                        <em>
                          ¿Qué se espera concretamente que mejore el
                          colaborador?
                        </em>
                      </p>
                      <div className="row">
                        <div className="col-md-12">
                          <div className="form-group">
                            <textarea
                              disabled={state.estadoPrincipal === "ACTIVO"}
                              value={
                                state.Items.length === 0? defaultE.MejoraEsparada: idx==-1?defaultE.MejoraEsparada:state.Items[idx].MejoraEsparada
                              }
                              onChange={(e) => idx==-1? changeItem2(e): changeItem(e)}
                              maxLength={252}
                              className="form-control"
                              name="Espera"
                              id="Espera"
                            ></textarea>
                          </div>
                        </div>
                      </div>
                    </div>
                    <div id="menu2" className="tab-pane fade ">
                      <p>
                        <strong>Desempeño</strong>
                      </p>
                      <p>
                        <em>
                          ¿Que acciones debe llevar a cabo el colaborador para
                          mejorar su desempeño?
                        </em>
                      </p>
                      <div className="row">
                        <div className="col-md-10">
                          <div className="form-group">
                            <input
                              disabled={state.estadoPrincipal === "ACTIVO"}
                              onKeyPress={(e) => handleInputChange(e, "Mejora")}
                              type="text"
                              value={caja.Input3 || ""}
                              onChange={(e) => handleInput(e)}
                              className="form-control"
                              id="Input3"
                              name="Input3"
                            />
                          </div>
                        </div>
                        <div className="col-md-2">
                          <div className="form-group">
                            <button
                              disabled={state.estadoPrincipal === "ACTIVO"}
                              className="btn btn-primary"
                              onClick={() => AddElmArr("Mejora")}
                            >
                              Agregar
                            </button>
                          </div>
                        </div>
                      </div>
                      <ol
                        id={"lista3"
                          /* state.Items.length === 0
                            ? "lista3"
                            : state.Items[idx].AccionesACabo.length === 0
                            ? ""
                            : "lista3" */
                        }
                      >
                        {state.Items.length === 0 ? (
                          defaultE.AccionesACabo.map((item, key) => (
                            <li className="list-unstyled" key={key}>
                              <div className="row">
                                <div className="col-md-11" style={{color:'#472380'}}>
                                  {defaultE.AccionesACabo[key].titulo}
                                </div>
                                <div className="col-md-1 xCorr">
                                  <a
                                    className="remove"
                                    data-toggle="tooltip"
                                    title="Eliminar elemento"
                                    onClick={
                                      state.estadoPrincipal === "ACTIVO"
                                        ? null
                                        : () => deleteItem(key, "NuevoE")
                                    }
                                  >
                                    <i
                                      className="fa fa-times"
                                      aria-hidden="true"
                                    ></i>
                                  </a>
                                </div>
                              </div>
                            </li>
                          ))
                        ) : idx==-1? defaultE.AccionesACabo.map((item, key) => (
                          <li className="list-unstyled" key={key}>
                            <div className="row">
                              <div className="col-md-11">
                                <input
                                  disabled={
                                    state.estadoPrincipal === "ACTIVO"
                                  }
                                  onBlur={(e) =>
                                    OnblurDelete(e, key, "Acciones")
                                  }
                                  onChange={(e) => changeItem(e, key)}
                                  value={
                                    defaultE.AccionesACabo[key].titulo
                                  }
                                  className="withoutBorder form-control"
                                  name="Acciones"
                                />
                              </div>
                              <div className="col-md-1 xCorr">
                                <a
                                  className="remove"
                                  data-toggle="tooltip"
                                  title="Eliminar elemento"
                                  onClick={
                                    state.estadoPrincipal === "ACTIVO"
                                      ? null
                                      : () => deleteItem(key, "NuevoE")
                                  }
                                >
                                  <i
                                    className="fa fa-times"
                                    aria-hidden="true"
                                  ></i>
                                </a>
                              </div>
                            </div>
                          </li>
                        ))
                        :state.Items[idx].AccionesACabo.length === 0 ? (
                          <li
                            className="list-unstyled"
                            style={{ paddingLeft: 150 }}
                          >
                            No hay valores agregados
                          </li>
                        ) : (
                          state.Items[idx].AccionesACabo.map((item, key) => (
                            <li className="list-unstyled" key={key}>
                              <div className="row">
                                <div className="col-md-11">
                                  <input
                                    disabled={
                                      state.estadoPrincipal === "ACTIVO"
                                    }
                                    onBlur={(e) =>
                                      OnblurDelete(e, key, "Acciones")
                                    }
                                    onChange={(e) => changeItem(e, key)}
                                    value={
                                      state.Items[idx].AccionesACabo[key].titulo
                                    }
                                    className="withoutBorder form-control"
                                    name="Acciones"
                                  />
                                </div>
                                <div className="col-md-1 xCorr">
                                  <a
                                    className="remove"
                                    data-toggle="tooltip"
                                    title="Eliminar elemento"
                                    onClick={
                                      state.estadoPrincipal === "ACTIVO"
                                        ? null
                                        : () => deleteItem(key, "Acciones")
                                    }
                                  >
                                    <i
                                      className="fa fa-times"
                                      aria-hidden="true"
                                    ></i>
                                  </a>
                                </div>
                              </div>
                            </li>
                          ))
                        )}
                      </ol>
                    </div>
                  </div>
                </div>
              </div>
            </div>
            <div className="modal-footer">
              {/* <button
                type="button"
                data-dismiss="modal"
                disabled={state.estadoPrincipal === "ACTIVO"}
                id="save"
                className="btn btn-primary btn-sm"
                onClick={() => deleteInitialItem()}
                data-toggle="tooltip"
                title={`Eliminar ${
                  !state.Items.length ? "" : state.Items[idx].Elemento
                }`}
              >
                Eliminar
              </button> */}
              <button 
                data-dismiss="modal"
                className="btn btn-default btn-sm">
                Cerrar
              </button>
              {idx==-1 &&(
                 <button 
                 //data-dismiss="modal"
                 disabled={state.estadoPrincipal === "ACTIVO"}
                 className="btn btn-primary btn-sm"
                 onClick={()=>AddnuevoItem()}>
                 Guardar elemento
               </button>
              )}
            </div>
          </div>
        </div>
      </div>
      {/* termino del modal */}
    </div>
  );
}

/* PIP.propTypes = {
    
}; */

export default PIP;
