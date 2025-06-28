import React, { useState, useEffect, forwardRef } from "react";
import PropTypes, { array } from "prop-types";
import { ReactSortable } from "react-sortablejs";
import FormCompetencia from "./FormCompetencias.jsx";
import axios from "axios";
import { Aside, CollectionItem, Main } from "../common/index.js";
import Formsearch from "./searchCompetencia.jsx";

// import '../competencia/estilos.css';
function Competencias(props) {
  const { getData, postData, getUpdate, id, returnUrl } = props;
  //listas de Preguntas
  const [listaTemporal, setTemporal] = useState([]);
  const [Competencia, setCompetencia] = useState([]);
  const [Preguntas, setPreguntas] = useState([]);
  const [updatepuesto, setupdatePuesto] = useState("");
  const [backup, setBackup] = useState([]);

  //estados del form
  const [state, setState] = useState({
    TipoPreguntas: [],
    Puestos: [],
    Tipo: "",
    TipoComp: "",
    NumRespuestas: "",
    Search: ""
  });

  const [form, setForm] = useState({
    titulo: "",
    descripcion: "",
    Puesto: []
  });
  //obtine la carga inicial del componente
  useEffect(() => {
    if (getUpdate === "") {
      getDataNormal();
    } else {
      $("#listCompetencia").html("");
      $("#listCompetencia").removeClass("textNew");
      getDataUpdate();
    }
  }, []);
  //hace la peticiÃ³n normal de carga
  function getDataNormal() {
    axios.get(getData).then(function(response) {
      setTemporal(response.data.data.preguntas);
      setPreguntas(response.data.data.preguntas);
      setBackup(response.data.data.preguntas);
      setState({
        ...state,
        /* Puestos: mapPuestos(response.data.data.puestos || ""), */
        Puestos: response.data.data.puestos || "",
        TipoPreguntas: response.data.data.TipoPreguntas
      });
    });
  }
  //hace la peticion del Update
  function getDataUpdate() {
    axios.get(getUpdate).then(function(response) {
      setState({
        ...state,
       /*  Puestos: mapPuestos(response.data.data.puestos || ""), */
        Puestos:response.data.data.puestos || "",
        TipoPreguntas: response.data.data.TipoPreguntas,
        TipoComp: response.data.data.listQuestion[0].nombre,
        NumRespuestas: response.data.data.listQuestion[0].cantidad
      });
      setForm({
        titulo: response.data.data.Informacion[0].titulo,
        descripcion: response.data.data.Informacion[0].descripcion,
        Puesto: response.data.data.Puesto
      });
      try {
        setupdatePuesto(response.data.data.Puesto[0].value);
      } catch (e) {}
      const ArrDiff = diff(
        response.data.data.listPregunta,
        response.data.data.listQuestion,
        "Idp"
      );
      setTemporal(ArrDiff);
      setPreguntas(ArrDiff);
      //checar esto para el orden de las preguntas
      setCompetencia(
        response.data.data.listQuestion.sort((a, b) => a.orden - b.orden)
      );
      //setCompetencia(response.data.data.listQuestion);
    });
  }
  //obtine el valor de los input del FormCompetencias
  function handleInput(e) {
    const { value, name } = e.target;
    setState({ ...state, [name]: value });
  }
  //hace el proceso de eliminar la pregunta si no cumple con las validaciones
  function PreguntaValidacion(indexP, item) {
    const newData = Competencia.filter((_, index) => index !== indexP);
    setCompetencia(newData);
    //console.log('New Data',newData);
    setTemporal([...listaTemporal, item]);
  }

  const postdataCompetencia = values => {
    if (getUpdate != "") {
      values["id"] = id;
      values["Accion"] = "Editar";
      values["ultimoPuesto"] = updatepuesto;
    } else {
      values["Accion"] = "Agregar";
    }
    values["Competencias"] = Competencia;
    axios
      .post(postData, values)
      .then(function(response) {
        toastr.success("Exíto");
        window.location.href = returnUrl;
      })
      .catch(error => {});
  };
  //el fliltro de los elementos del estado
  function onChange(e) {
    const changeUp = diff(backup, Competencia, "Idp");
    //console.log('changeUp',changeUp);
    setPreguntas(changeUp);
    //console.log('preguntas lista',Competencia);
    var text = e.target.value;
    if (e.target.name === "TipoPregunta") {
      text = e.target.value;
      setState({ ...state, Tipo: e.target.value });
    } else {
      if (e.target.value === "") {
        text = state.Tipo;
      } else {
        text = state.Tipo + " " + e.target.value;
        setState({ ...state, NumResp: e.target.value });
      }
    }
    const data = Preguntas;
    const newData = data.filter(function(item) {
      var itemDataTipo = item.nombre.toUpperCase();
      const NumRes = item.cantidad.toUpperCase();
      const Titulo = item.titulo.toUpperCase();
      const campo = Titulo + " " + itemDataTipo + " " + NumRes;
      const textData = text.toUpperCase();
      return campo.indexOf(textData) > -1;
    });
    //console.log('back',backup);
    setTemporal(newData);
  }

  function onAddMain(e) {
    try {
      const newIndex = e.newIndex;
      const FindItem = Competencia.find((_, index) => index === newIndex);
      if (Competencia.length === 1) {
        setState({
          ...state,
          TipoComp: Competencia[0].nombre,
          NumRespuestas: FindItem.cantidad
        });
      } else if (FindItem.nombre !== state.TipoComp) {
        toastr.error("No se puede agregar diferentes tipos de preguntas");
        PreguntaValidacion(newIndex, FindItem);
      } else if (FindItem.cantidad != state.NumRespuestas && FindItem.tipo_pregunta_id === "7") {
        toastr.error("No se puede agregar preguntas con diferentes numero de respuestas");
        PreguntaValidacion(newIndex, FindItem);
        //const Diff = diff(Preguntas, Competencia, "Idp");//check this
      }
      const changeUp = diff(backup, Competencia, "Idp");
      setPreguntas(changeUp);
    } catch (e) {}
  }
  function eliminarPregunta(indexl, item) {
    //console.log('index es', indexl);
    const newTodos = Competencia.filter((_, index) => index !== indexl);
    setCompetencia(newTodos);
    setPreguntas([...Preguntas, item]);
    setTemporal([...listaTemporal, item]);
    textoValidacion();
  }
  //funciÃ³n que permite obtener la diff entre dos array
  function diff(a1, a2, propiedad) {
    return a1.filter(
      o1 => a2.filter(o2 => o2[propiedad] === o1[propiedad]).length === 0
    );
  }

  function mapPuestos(respuesta) {
    const _ps = respuesta.map(i => {
      return { value: i.idPuesto, label: i.personaPuesto };
    });
    return _ps;
  }
  return (
    <>
      <div className="row">
        <div className="col-md-12"></div>
      </div>
      <div className="row">
        <Aside className="col-md-3">
          <Formsearch
            Tipopregunta={state.TipoPreguntas}
            Tipo={state.Tipo}
            onChange={onChange}
            state={state}
            handleInput={handleInput}
          />
          <div id="lol" style={{maxHeight:"80vh", overflow:"auto"}}>
            <ReactSortable
              list={listaTemporal}
              setList={setTemporal}
              onEnd={onAddMain}
              animation={150}
              group={{ name: "shared-group-name", put: false }}
              className={"cards"}
              tag={"ul"}
              sort={false}
            >
              {listaTemporal.map((item, key) => (
                <CollectionItem
                  key={item.Idp}
                  item={item}
                  index={key}
                  especial={false}
                  addToList={eliminarPregunta}
                />
              ))}
            </ReactSortable>
          </div>
        </Aside>
        <Aside className="col-md-9">
          <FormCompetencia
            puestos={state.Puestos}
            handleInput={handleInput}
            state={state}
            Competencia={Competencia}
            form={form}
            //Titulo={form.titulo}
            submit={postdataCompetencia}
          />
          <div>
            <h4>Lista de preguntas</h4>
          </div>
          <ReactSortable
            list={Competencia}
            setList={setCompetencia}
            animation={150}
            group="shared-group-name"
            className="cards card-container"
            id="listCompetencia"
            onAdd={() => {
              if (Competencia.length === 0) {
                $("#listCompetencia").html("");
                $("#listCompetencia").removeClass("textNew");
              }
            }}
          >
            {Competencia.map((item, key) => (
              <CollectionItem
                key={item.Idp}
                item={item}
                index={key}
                especial={true}
                addToList={eliminarPregunta}
              />
            ))}
          </ReactSortable>
          <span className="help-block">Arrastra las competencias aquí.</span>
        </Aside>
      </div>
    </>
  );
}

Competencias.propTypes = {
  selector: PropTypes.string,
  getData: PropTypes.string.isRequired,
  postData: PropTypes.string.isRequired,
  getUpdate: PropTypes.string,
  id: PropTypes.string,
  returnUrl: PropTypes.string,
  callbacksuccess: PropTypes.string
};

export default Competencias;
