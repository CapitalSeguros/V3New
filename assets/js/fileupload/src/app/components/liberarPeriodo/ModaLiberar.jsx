import React, { useState, useEffect } from "react";
import axios from "axios";
import Select from "react-select";
import {stylesSelect} from "../common/stylesSelect.js";

function ModaLiberar(props) {
  const path = window.jQuery("#base_url").attr("data-base-url");
  const { callback,AccionOpen } = props;


/*   useEffect(() => {
    setState({ ...state, inicio: "Inicio" });
  }, [state]); */
  const [state, setState] = useState({
    inicio: "",
    Puesto:"",
    infoPeriodo: [],
    users: [],
    eval360: [],
    evaluaciones: [],
    selected: { value: "", label: "" },
    selectedEmplEva: [],
    fielPost: {}
  });
  const [evaluadores, setEvaluad] = useState([]);
  const [idinicio, setIdinicio] = useState();
  const [E360, setE360] = useState("");
  const [validation, setValidation] = useState([]);
  const [selectesEval, setSeletedEval] = useState("");
  const [openM, setopenM] = useState("");
/*   useEffect(() => {
    if (idinicio != undefined) {
      axios
        .get(`${path}periodo/beforeLiberar/${idinicio}`)
        .then(function(response) {
          //console.log("response", response);
          agregar(response);
        });
        
    }
  }, [idinicio]); */

   useEffect(() => {
     return()=>{
       window.jQuery("#exampleModalCenter").modal("show");
     }
  }, [openM]);

  useEffect(() => {
     if(AccionOpen !=""){
      window.jQuery(document).on("click", AccionOpen, function(e) {
          e.preventDefault();
          //e.currentTarget).attr("data-in-id")
          const id = window.jQuery(e.currentTarget).attr("data-in-id");
          setIdinicio(id);
           axios
            .get(`${path}periodo/beforeLiberar/${id}`)
            .then(function(response) {
              //console.log("response", response);
              agregar(response);
            });
          //window.jQuery("#exampleModalCenter").modal("show");
      });
    }
  }, []);

  function agregar(respuesta) {
    console.log("emopleaod",respuesta.data.data.empleados)
    setState({
      ...state,
      users: mapPuestos(respuesta.data.data.empleados),
      eval360: respuesta.data.data.eval360,
      evaluaciones: respuesta.data.data.evaluaciones,
      infoPeriodo: respuesta.data.data.infoPeriodo
    });
    let obj360 = respuesta.data.data.eval360;
    setE360(obj360.length > 0 ? "1" : "0");
    setopenM(Math.random());
    //troubles(respuesta.data.data.eval360);
  }

  function changeSelect(v) {
    setState({ ...state, selected: v });
  }
  function changeSelectP(v) {
    setState({ ...state, Puesto: v });
  }

  function openModalAdd(idP, idE, IdPe, item) {
    //console.log(item);
    setSeletedEval(item);
    getEvaluadores360(idP, idE, IdPe);
    $("#ModalEval").modal("show");
    //setEmp(item);
  }
  function getEvaluadores360(idP, IdE, IdPe) {
    const params = { idPersona: idP, idEvaluacion: IdE, idPeriodo: IdPe };
    let usuarios = state.users.filter(item => item.value !== idP);
    axios
      .get(`${path}periodo/getEvaluadores360`, { params })
      .then(function(response) {
        let evalp = mapPuestos2(response.data.data);
        setEvaluad(evalp);
        const todos = diff(usuarios, evalp, "label");
        setState({
          ...state,
          users: todos,
          fielPost: { idP: idP, IdE: IdE, IdPe: IdPe }
        });
      });
  }
  function mapPuestos(respuesta) {
    const _ps = respuesta.map(i => {
      return { value: i.id, label: i.name_complete,puesto:i.puesto};
    });
    return _ps;
  }
  function mapPuestos2(respuesta) {
    const _ps = respuesta.map(i => {
      return { value: i.idPersona, label: i.name_complete, id: i.id };
    });
    return _ps;
  }

  function diff(a1, a2, propiedad) {
    return a1.filter(
      o1 => a2.filter(o2 => o2[propiedad] === o1[propiedad]).length === 0
    );
  }
  function postdata(accion, id) {
    let data = {};
    let fullpath = "";
    if (accion === "add") {
      data = {
        periodo_id: state.fielPost.IdPe,
        evaluacion_id: state.fielPost.IdE,
        empleado_id: state.fielPost.idP,
        aplica_id: state.selected.value
      };
      fullpath = `${path}periodo/addEval360`;
    } else {
      data = { id: id };
      fullpath = `${path}periodo/deleteEval360`;
    }
    axios.post(fullpath, data).then(function(response) {
      //window.toastr.success('Éxito');
    });
  }

  function add() {
    if (state.selected.value !== "") {
      let evalu = evaluadores;
      let usr = state.users.filter(
        item2 => item2.value !== state.selected.value
      );
      evalu.push(state.selected);
      setEvaluad(evalu);
      postdata("add", "");
      setState({ ...state, users: usr, selected: { value: "", label: "" } });
    } else {
      toastr.error("No se pueden agregar valores vacios");
    }
  }

  function deleteEval(item, id) {
    //console.log(item);
    let allusr = state.users;
    let newEva = evaluadores.filter(Element => Element.value !== item.value);
    allusr.push(item);
    setState({ ...state, users: allusr });
    setEvaluad(newEva);
    postdata("delete", id);
  }

  function troubles(respuesta) {
    respuesta.map((item, index) => {
      item.empleados.map((iten, indes) => {
        let validacion = validation;
        let arreglo = {
          id: iten.Emp.name_complete,
          evaluados: iten.aplicados
        };
        validacion.push(arreglo);
        setValidation(validacion);
      });
    });
  }

  function Validationliberar() {
    let errores = [];
    let msg = "";
    let allvalidatio = [];
    axios
      .get(`${path}periodo/beforeLiberar/${idinicio}`)
      .then(function(response) {
        troubles(response.data.data.eval360);
        if (E360 === "1") {
          let lol = validation.length - 1;
          allvalidatio.push(validation);
          allvalidatio[0].forEach((Element, idx) => {
            if (Element.evaluados.length === 0) {
              errores.push({ usr: Element.id });
            }
          });
          if (errores.length > 0) {
            errores.forEach(elt => {
              msg = msg + elt.usr + "<br/>";
            });
            window.toastr.error(`No se han agregado evaluadores: <br/> ${msg}`);
          } else {
            liberar();
            $("#exampleModalCenter").modal("hide");
          }
        } else {
          //alert("No tiene 360, puede pasar");
          liberar();
        }
        setValidation([]);
      });
  }

  function liberar() {
    axios.post(`${path}periodo/liberar/${idinicio}`).then(function(response) {
      window.toastr.success("Éxito");
      callback();
      $("#exampleModalCenter").modal("hide");
    });
  }
  const handleNext = (e, action) => {
    e.preventDefault();
    e.stopPropagation();
    const tab = window.jQuery(".nav-tabs li.active a");
    const items = window.jQuery(".nav-tabs a").length;
    let index = window.jQuery(tab).attr("data-index");
    var next = 0;
    if (action) next = parseInt(index) + 1;
    else next = parseInt(index) - 1;

    window.jQuery(`.nav-tabs a[data-index="${next}"]`).tab("show");
    if (next == items) {
      window.jQuery(this).hide();
      window.jQuery("#bnNext").hide();
      window.jQuery("#bnSubmit").show();
    } else {
      window.jQuery("#bnSubmit").hide();
      window.jQuery("#bnNext").show();
    }
  };

  function displayitemPuesto(id,array){
    const _array=array;
    const newData = _array.filter((item, index) => item.puesto === id);
    console.log("data",newData);
    return newData;
  }

  return (
    <>
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
            <div className="modal-header">
              LIBERAR PERIODO{" "}
              {state.infoPeriodo.length > 0 ? state.infoPeriodo[0].titulo : ""}
            </div>
            <div className="modal-body">
              <div className="row">
                <div className="col-md-12">
                  <ul className="nav nav-tabs">
                    {E360 === "0" ? (
                      ""
                    ) : (
                      <li className={E360 === "1" ? "active" : "null"}>
                        {/* disabled */}
                        <a
                          data-index="1"
                          href={E360 === "0" ? "#null" : "#home"}
                        >
                          {/* disabled */} Evaluación 360{" "}
                        </a>
                      </li>
                    )}
                    <li className={E360 === "0" ? "active" : null}>
                      <a data-index="2" href="#menu2">
                        Finalizar
                      </a>
                    </li>
                  </ul>
                  <div className="tab-content tab-size">
                    <div
                      id="home"
                      className={
                        E360 === "1"
                          ? "tab-pane fade in active"
                          : "tab-pane fade"
                      }
                    >
                      <div className="row">
                        <div className="col-md-12">
                          {state.eval360.map((item, indx) => (
                            <div key={indx + "w"}>
                              <div key={indx}>
                                Nombre de la evaluacion: {item.Nombre} -{" "}
                                {item.Puesto[0].personaPuesto}
                              </div>
                              <ol id="lista3" key={indx + "q"}>
                                {item.empleados.map((itm, ind) => (
                                  <li key={ind + "r"}>
                                    <div className="row">
                                      <div className="col-md-11">
                                        <h6>{itm.Emp.name_complete}</h6>
                                      </div>
                                      <div className="col-md-1 xCorr">
                                        <a
                                          className="remove"
                                          data-toggle="tooltip"
                                          title="Agregar evaluadores"
                                          onClick={() =>
                                            openModalAdd(
                                              itm.Emp.idPersona,
                                              item.id_evaluacion,
                                              item.Perido,
                                              itm
                                            )
                                          }
                                        >
                                          <span
                                            className="fa fa-plus-circle fa-lg"
                                            aria-hidden="true"
                                          ></span>
                                        </a>
                                      </div>
                                    </div>
                                  </li>
                                ))}
                              </ol>
                            </div>
                          ))}
                        </div>
                      </div>
                    </div>
                    <div
                      id="menu2"
                      className={
                        E360 === "0"
                          ? "tab-pane fade in active"
                          : "tab-pane fade"
                      }
                    >
                      <p>
                        <em>
                          Nota: esta apunto de liberar un perido de evaluación,
                          lo que indica que se podran en activo las evaluaciones
                          creadas, ¿está seguro de continuar?
                        </em>
                      </p>
                    </div>
                  </div>
                </div>
              </div>
            </div>
            <div className="modal-footer">
              <div className="row">
                <div className="col-md-3 col-md-offset-9">
                  <button
                    id="bnSubmit"
                    className="btn btn-default pull-right"
                    type="submit"
                    style={E360 === "1" ? { display: "none" } : {}}
                    onClick={Validationliberar}
                  >
                    Guardar
                  </button>
                  <button
                    id="bnNext"
                    style={E360 === "0" ? { display: "none" } : {}}
                    className="next btn btn-default pull-right"
                    onClick={e => handleNext(e, true)}
                    type="button"
                  >
                    Siguiente
                  </button>
                  <button
                    disabled={E360 === "0" ? true : false}
                    id="bnPrev"
                    className="next btn btn-default pull-right"
                    onClick={e => handleNext(e, false)}
                    type="button"
                  >
                    Anterior
                  </button>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>

      <div
        className="modal fade bd-example-modal-lg"
        id="ModalEval"
        tabIndex="-1"
        role="dialog"
        aria-labelledby="exampleModalCenterTitle"
        aria-hidden="true"
      >
        <div className="modal-dialog modal-lg" role="document">
          <div className="modal-content">
            <div className="modal-header">
              Agregar evaluadores para{" "}
              {selectesEval !== "" ? selectesEval.Emp.name_complete : ""}
            </div>
            <div className="modal-body">
              <div className="row">
                <div className="col-md-12">
                  <div className="row">
                  <div className="col-md-5">
                      <div className="form-group">
                      <label
                        className="col-form-label titulos"
                      >
                        Puesto
                      </label>
                        <Select
                          placeholder="Selecione una opción"
                          id="Puesto"
                          name="Puesto"
                          styles={stylesSelect(300,1,"puesto")}
                          onChange={v => {
                            changeSelectP(v);
                          }}
                          value={state.Puesto || ""}
                          options={_puestos}
                        />
                      </div>
                    </div>
                    <div className="col-md-5">
                      <div className="form-group">
                      <label
                          className="col-form-label titulos"
                        >
                          Empleado
                        </label>
                        <Select
                          placeholder="Selecione una opción"
                          id="Evaluadores"
                          name="Evaluadores"
                          styles={stylesSelect(300,1)}
                          onChange={v => {
                            changeSelect(v);
                          }}
                          value={state.selected || ""}
                          options={displayitemPuesto(state.Puesto.value,state.users)}
                          noOptionsMessage={()=>"Sin opciones"}
                        />
                      </div>
                    </div>
                    <div className="col-md-2">
                      <div className="form-group" style={{paddingTop:"20px"}}>
                        <button
                          onClick={() => add()}
                          className="btn btn-primary"
                          style={{ height: 45 }}
                        >
                          Agregar
                        </button>
                      </div>
                    </div>
                  </div>
                  <div className="row">
                    <div className="col-md-12">
                      Lista de evaluadores asiganados:
                      {evaluadores.length === 0 ? (
                        <div className="text-center">
                          No hay ningún empleado asignado
                        </div>
                      ) : (
                        <ol id="lista3">
                          {evaluadores.map((item, ind) => (
                            <li key={ind + "d"}>
                              <div className="row">
                                <div className="col-md-11">
                                  <h6>{item.label}</h6>
                                </div>
                                <div className="col-md-1 xCorr">
                                  <a
                                    className="remove"
                                    data-toggle="tooltip"
                                    title="Eliminar evaluador"
                                    onClick={() => deleteEval(item, item.id)}
                                  >
                                    <span
                                      className="fa fa-times fa-sm"
                                      aria-hidden="true"
                                    ></span>
                                  </a>
                                </div>
                              </div>
                            </li>
                          ))}
                        </ol>
                      )}
                    </div>
                  </div>
                </div>
              </div>
            </div>
            <div className="modal-footer">
              <button
                type="button"
                className="btn btn-default"
                data-dismiss="modal"
              >
                Cerrar
              </button>
            </div>
          </div>
        </div>
      </div>
    </>
  );
}

export default ModaLiberar;
