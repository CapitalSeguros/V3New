import React, { useState, useEffect } from "react";
import PropTypes from "prop-types";
import Formpregunta from "./Formpregunta.jsx";
import ModeloPregunta from "./Modelo.jsx";
import Item from "./Items.jsx";
import { ReactSortable } from "react-sortablejs";

import axios from "axios";
import slug from "slug";

function Prueba(props) {
  const path = window.jQuery("#base_url").attr("data-base-url");
  const { postFiles, getFiles } = props;
  const letras = ["A", "B", "C", "D"];
  const [state, setState] = useState({
    ListaTipo: [],
    Tipo: "",
    Value: "",
    checked: false,
    Ponderacion: 0.0,
    Required: false
  });
  const [Filas, setFilas] = useState([]);
  const [editpet, setEditPet] = useState("");
  const [idstate, setIdstate] = useState();
  const [asignado, setAsignado] = useState(0.0);
  const [idR, setIdR] = useState(0);
  const [auto, setAuto] = useState(100.0);
  const [def, setDef] = useState([]);
  const [idDef, setIdDef] = useState(0);

  const [OpCorrecta,setOpCorrecta]=useState("");
  //Peticiones
  useEffect(() => {
    axios
      .get(`${path}Preguntas/getTipoPregunta`)
      .then(response => {
        setState({ ...state, ListaTipo: response.data.data });
      })
      .catch(err => console.log(err));
  }, []);

  useEffect(() => {
    if (state.checked === true) {
      const Asig = [];
      let pond = 0;
      Filas.forEach((item, index) => {
        item.valor = parseFloat(100 / Filas.length).toFixed(2);
        $(`#Itemvalue${index}`).val(parseFloat(100 / Filas.length).toFixed(2));
        pond = pond + parseFloat(item.valor);
        Asig.push(item);
      });
      setAsignado(pond);
    }
  }, [state.checked]);

  useEffect(() => {
    setAuto(parseFloat(100 / Filas.length).toFixed(2));
  }, [Filas.length]);

  useEffect(() => {
    if (idstate != undefined) {
      reset();
      axios
        .get(idstate)
        .then(function(response) {
          if (Filas.length === 0) {
            $("#listPreguntas").removeClass("textNew");
            $("#listPreguntas").html("");
          }
          let cheked = JSON.parse(response.data[0].json_content);
          setState({
            ...state,
            Titulo: response.data[0].titulo,
            Tipo: response.data[0].tipo_pregunta_id,
            Idpreg: response.data[0].Idp,
            checked: cheked.checked
          });
          setOpCorrecta(response.data[0].respuesta);
          setEditPet("Editar");
          setAsignado(100.0);
          let json;
          switch (response.data[0].tipo_pregunta_id) {
            case "7":
              json = JSON.parse(response.data[0].json_content);
              let datap = json;
              var result = [],
                id = 0;
              for (var i in datap) {
                result.push({ id: id, titulo: datap[i], valor: "" });
                id++;
              }
              setFilas(result);
              break;
            case "6":
              json = JSON.parse(response.data[0].json_content);
              let cont = json.items;
              var result = [],
                id = 0;
              cont.forEach(item => {
                let NaItem = item.name.replace(
                  `[Valor:${item.validators[0].maxValue}]`,
                  ""
                );
                result.push({
                  id: id,
                  titulo: NaItem,
                  valor: item.validators[0].maxValue
                });
                id++;
              });
              setFilas(result);
              break;
            case "3":
            case "4":
            case "8":
              dataformatPreguntas(response.data[0].json_content,response.data[0].respuesta);
              break;
            default:
              break;
          }
          $("#exampleModalCenter").modal("show");
          //setIdstate('');
        })
        .catch(error => {});
    }
  }, [idstate]);
  //METODOS
  function handleInput(e) {
    const { value, name } = e.target;
    if (e.target.name === "Ponderacion") {
      setState({ ...state, [name]: parseFloat(value || 0) });
    } else if (e.target.name === "Required") {
      setState({ ...state, [name]: !state.Required });
    } else {
      setState({ ...state, [name]: value });
    }
  }
  function RespuestaCorrecta(index){
    const FilasCopia=Filas;
    FilasCopia.forEach(element=>{
      element.correcta=false;
    });
    FilasCopia[index].correcta=true;
    setFilas(FilasCopia);
    $("#opcionC"+OpCorrecta).removeClass("correct").addClass("normal");
    $("#opcionC"+index).removeClass("normal").addClass("correct");
    setOpCorrecta(index);
  }
  function toggleChange() {
    setState({ ...state, checked: !state.checked });
  }
  function eliminar(eliminar) {
    getAsigando(eliminar);
    const newTodos = Filas.filter((_, index) => index !== eliminar);
    setFilas(newTodos);
  }
  //metodo que agrega valores a la matriz
  function addValue() {
    if (state.Value !== "") {
      if (Filas.length === 0) {
        $("#listPreguntas").removeClass("textNew");
        $("#listPreguntas").html("");
      }
      var PdC = String(state.Ponderacion);
      setFilas([
        ...Filas,
        {
          id: idDef,
          titulo: state.Value,
          valor: parseFloat(PdC.replace("-", "")) || "",
          correcta:false
        }
      ]);
      setAsignado(asignado + parseFloat(PdC.replace("-", "")) || 0);
      setState({ ...state, Value: "", Ponderacion: 0 });
      setDef([
        ...def,
        {
          id: idDef,
          titulo: state.Value,
          valor: parseFloat(PdC.replace("-", "")) || "",
          correcta:false
        }
      ]);
      setIdDef(idDef + 1);
      $("#Value").focus();
    } else {
      toastr.error("No se puede agregar un valor vacio");
    }
  }
  function handleInputChange(e) {
    if (e.charCode === 13) {
      addValue();
    }
  }
  function handleInputChangeMt(e) {
    if (e.charCode === 13) {
      if (state.checked !== false) {
        if (state.Value !== "" && state.Ponderacion !== 0) {
          addValue();
        } else {
          toastr.error("Ingrese los valores indicados");
        }
      } else {
        addValue();
      }
    }
  }
  function dataformatPreguntas(data,respuesta) {
    var contenido = JSON.parse(data);
    let arr = contenido.choices;
    let contet = [];
    arr.forEach(item => {
      //console.log(respuesta);
      contet.push({
        id: Math.floor(Math.random() * 100 * 2) + 1,
        titulo: item,
        correcta:item==respuesta?true:false
      });
    });
    setFilas(contet);
  }

  function accionPost() {
    if (state.Tipo === "7") {
      if (Filas.length === 0) {
        toastr.error("Ingrese una respuesta");
      } else if (Filas.length > 4) {
        toastr.error(
          "Este tipo de pregunta solo permite un máximo 4 reactivos"
        );
      } else {
        AxiosPost();
      }
    } else if (state.Tipo === "6") {
      if (state.checked !== false) {
        /*  let sum=0;
                Filas.forEach((item)=>{sum=sum+parseFloat(item.valor)}); */
        if (asignado > 100) {
          toastr.error(
            "Esta pregunta supera el ponderado de 100,revise sus respuestas"
          );
        } else if (asignado < 100) {
          toastr.error(
            "Esta pregunta no suma el ponderado de 100, revise sus respuestas"
          );
        } else {
          AxiosPost();
        }
      } else {
        AxiosPost();
      }
    } else if (state.Tipo === "1") {
      AxiosPost();
    } else if (state.Tipo === "2") {
      AxiosPost();
    } else {
      if (Filas.length === 0) {
        toastr.error("Ingrese una respuesta");
      }else if(typeof OpCorrecta=='string'){
        toastr.error("Selecccione una respuesta como correcta");
      } else {
        AxiosPost();
      }
    }
  }

  function editPregunta() {
    const idview = window.jQuery("#idRow").val();
    axios
      .get(idview)
      .then(function(response) {
        setState({
          ...state,
          Titulo: response.data[0].titulo,
          Tipo: response.data[0].tipo_pregunta_id,
          Idpreg: response.data[0].Idp
        });
        setEditPet("Editar");
        let json;
        switch (response.data[0].tipo_pregunta_id) {
          case "7":
            json = JSON.parse(response.data[0].json_content);
            let datap = json;
            var result = [],
              id = 0;
            for (var i in datap) {
              result.push({ id: id, titulo: datap[i], valor: "" });
              id++;
            }
            setFilas(result);
            break;
          case "6":
            json = JSON.parse(response.data[0].json_content);
            let cont = json.items;
            var result = [],
              id = 0;
            cont.forEach(item => {
              let NaItem = item.name.replace(
                `[Valor:${item.validators[0].maxValue}]`,
                ""
              );
              result.push({
                id: id,
                titulo: NaItem,
                valor: item.validators[0].maxValue,
                checked: item.checked
              });
              id++;
            });
            setFilas(result);
            break;
          case "3":
          case "4":
          case "8":
            dataformatPreguntas(response.data[0].json_content);
            break;
          default:
            break;
        }
        //$("#exampleModalCenter").modal("show");
      })
      .catch(error => {});
  }

  function crearDataPost() {
    let acumulador = "";
    let data, shape;
    let required;
    const found = state.ListaTipo.find(element => element.id == state.Tipo);
    switch (state.Tipo) {
      case "7":
        let arr = Filas;
        let content = {};
        for (let index = 0; index < arr.length; index++) {
          const element = arr[index];
          if (index + 1 === arr.length) {
            acumulador += `"${letras[index]}": "${element.titulo}"`;
          } else {
            acumulador += `"${letras[index]}": "${element.titulo}",`;
          }
        }
        data = `{${acumulador}}`;
        break;
      case "1":
        data = JSON.stringify({
          type: "text",
          name: state.Titulo,
          isRequired: state.Required
        });
        break;
      case "2":
        data = JSON.stringify({
          type: "comment",
          name: state.Titulo,
          isRequired: state.Required
        });
        break;
      case "6":
        let items = [],
          Vmax = "";
        if (state.checked !== true) {
          Vmax = parseFloat(100 / Filas.length).toFixed(2);
        }
        Filas.forEach((item, index) => {
          items.push({
            name:
              item.titulo +
              " " +
              `[Valor:${parseFloat(
                state.checked !== true ? Vmax : item.valor
              ).toFixed(2)}]`,
            placeHolder: {
              es: String(state.checked !== true ? Vmax : item.valor)
            },
            inputType: "number",
            validators: [
              {
                type: "numeric",
                minValue: 0,
                maxValue: parseFloat(
                  state.checked !== true ? Vmax : item.valor
                ).toFixed(2)
              }
            ]
          });
        });
        shape = {
          type: found.clave,
          name: state.Titulo,
          checked: state.checked,
          isRequired: state.Required,
          items: items
        };
        data = JSON.stringify(shape);
        break;
      default:
        let choices = [];
        Filas.forEach((item, index) => {
          choices.push(item.titulo);
        });
        shape = {
          type: found.clave,
          name: state.Titulo,
          isRequired: state.Required,
          choices: choices
        };
        data = JSON.stringify(shape);
        break;
    }
    return data;
  }

  function AxiosPost() {
    var data = new FormData();
    var template = crearDataPost();
    data.append("Pregunta", state.Titulo);
    data.append("Template", template);
    data.append("slug", slug(state.Titulo, "_"));
    data.append("tipoPregunta", state.Tipo);
    const respuesta=Filas.find((_,index)=>index===OpCorrecta);
    data.append("correcta",respuesta?respuesta.titulo:null);
    if (editpet === "Editar") {
      data.append("Accion", "Editar");
      data.append("id", state.Idpreg || "");
    } else {
      data.append("Accion", "Agregar");
    }
    axios
      .post(postFiles, data)
      .then(function(response) {
        toastr.success("Exíto");
        reset();
        editPregunta();
        $("#exampleModalCenter").modal("hide");
        $("button[id=eliminar]").click();
      })
      .catch(error => {});
  }

  $("button[id=editar]").click(() => {
    const idview = window.jQuery("#idRow").val();
    setIdstate(idview);
    if (state.Titulo) {
      $("#exampleModalCenter").modal("show");
    }
  });

  function getAsigando(newIndex) {
    const FindItem = Filas.find((_, index) => index === newIndex);
    setAsignado(asignado - FindItem.valor);
  }
  function reset() {
    setState({
      ...state,
      Tipo: "",
      Value: "",
      Titulo: "",
      checked: false,
      Ponderacion: 0
    });
    setFilas([]);
    setEditPet("");
    setAsignado(0.0);
    setOpCorrecta('');
    if (Filas.length === 0) {
      $("#listPreguntas").addClass("textNew");
      $("#listPreguntas").html("No se ha agregado ninguna opción");
    }
  }
  function changeItem(e, index, id) {
    let arr = Filas;
    if (id === "ItemTitle") {
      arr[index].titulo = e.currentTarget.textContent;
    } else if (e.target.name === "Itemvalue") {
      if (e.target.value === "") {
        console.log("default", arr[index].valor);
        e.target.value = parseFloat(arr[index].valor);
      }
      var text = e.target.value.replace("-", "");
      var num = parseFloat(e.target.value);
      var cleanNum = num.toFixed(2);
      arr[index].valor = cleanNum;
      e.target.value = parseFloat(text);
    }
    setFilas(arr);
    getAllvaluesFilas();
  }

  function getAllvaluesFilas() {
    let arr = Filas,
      objeto = 0;
    arr.forEach(item => {
      objeto = objeto + parseFloat(String(item.valor).replace("-", ""));
    });
    setAsignado(objeto);
  }

  $("#exampleModalCenter").on("hidden.bs.modal", function() {
    setIdstate(undefined);
  });

  return (
    <>
      <button
        type="button"
        className="btn btn-primary pull-right"
        data-toggle="modal"
        onClick={reset}
        data-target="#exampleModalCenter"
      >
        Nuevo
      </button>
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
              <h5
                className="modal-title"
                style={{ fontSize: "1.75rem" }}
                id="exampleModalLongTitle"
              >
                Nueva pregunta
              </h5>
            </div>
            <div className="modal-body">
              <Formpregunta
                ListaTipo={state.ListaTipo}
                handleInput={handleInput}
                state={state}
              />
              <div className="row">
                <div className="col-md-12">
                  <div className="form-group">
                    <ModeloPregunta
                      Tipo={state.Tipo}
                      handleInput={handleInput}
                      handleInputChange={handleInputChange}
                      handleInputChangeMt={handleInputChangeMt}
                      addValue={addValue}
                      state={state}
                      toggleChange={toggleChange}
                      Filas={Filas}
                      onkeydown={onkeydown}
                    />
                  </div>
                </div>
              </div>
              <div className="row">
                <div
                  className={
                    state.Tipo != 0 && state.Tipo != "1" && state.Tipo != "2"
                      ? "col-md-12"
                      : "hidden"
                  }
                >
                  <div className={state.Tipo === "6" ? "text-left" : "hidden"}>
                    {!state.checked ? (
                      <h5>
                        Valor de cada respuesta:{" "}
                        {Filas.length > 0
                          ? (100 / Filas.length).toFixed(2)
                          : "100.00"}
                      </h5>
                    ) : (
                      <h5>
                        Valor asigando:{" "}
                        {parseFloat(String(asignado).replace("-", "")) || 0} de
                        100.00, restante:{" "}
                        {parseFloat(100 - parseFloat(asignado)).toFixed(2) || 0}
                      </h5>
                    )}
                  </div>
                  <ReactSortable
                    list={Filas}
                    setList={setFilas}
                    animation={150}
                    group={{ name: "shared-group-name", put: false }}
                    className={"cards"}
                    tag={"ul"}
                    sort={true}
                    id="listPreguntas"
                  >
                    {Filas.map((item, key) => (
                      <Item
                        RespuestaCorrecta={RespuestaCorrecta}
                        key={item.id}
                        Eliminar={eliminar}
                        item={item}
                        index={key}
                        checked={state.checked}
                        Tipo={state.Tipo}
                        changeItem={changeItem}
                        auto={auto}
                      />
                    ))}
                  </ReactSortable>
                </div>
              </div>
            </div>
            <div className="modal-footer">
              <button
                type="button"
                id="close"
                className="btn btn-secondary"
                data-dismiss="modal"
              >
                Cerrar
              </button>
              <button
                id="save"
                className="btn btn-primary"
                disabled={!state.Tipo || !state.Titulo || asignado > 100}
                id="save"
                onClick={accionPost}
              >
                <i className="fa fa-floppy-o" aria-hidden="true"></i> Guardar
              </button>
            </div>
          </div>
        </div>
      </div>
    </>
  );
}

Prueba.propTypes = {
  selector: PropTypes.string.isRequired,
  reference: PropTypes.string.isRequired,
  referenceId: PropTypes.number.isRequired,
  getFiles: PropTypes.string,
  postFiles: PropTypes.string.isRequired
};

export default Prueba;
