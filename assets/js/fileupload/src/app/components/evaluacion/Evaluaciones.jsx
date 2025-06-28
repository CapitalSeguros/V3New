import React, { useState, useEffect } from "react";
import { ReactSortable } from "react-sortablejs";
import update from "immutability-helper";
import {
  Aside,
  Main,
  CollectionCompetenciaItem as CollectionItem
} from "../common/index.js";
import Form from "./Form.jsx";
import CollectionEvItem from "./CollectionEvaluacionItem.jsx";
import axios from "axios";

const CustonEvaluaciones = ({ id }) => {
  const path = window.jQuery("#base_url").attr("data-base-url");
  const [state, setState] = useState({
    tipos: [],
    model: {
      titulo: "",
      tiempo_evaluacion: 0,
      tipo_evaluacion_id: "",
      tipo_evaluacion: "",
      descripcion: ""
    },
    minMount: 3
  });
  const [competencias, setCompetencia] = useState([]);
  const [evaluaciones, setEvaluacion] = useState([]);
  const [temp, setTemp] = useState([]);

  const handleInputChange = (e, data) => {
    const { value } = e.target;
    const newTemp = data.filter(item => {
      const text = item.nombre.toUpperCase();
      return text.indexOf(value.toUpperCase()) > -1;
    });
    setTemp(newTemp);
  };

  const removeItem = item => {
    const idx = evaluaciones.findIndex(i => i.id == item.id);
    setEvaluacion(update(evaluaciones, { $splice: [[idx, 1]] }));
    setTemp(update(temp, { $push: [item] }));
  };
  const handleSubmit = (model, actions) => {
    if (evaluaciones.length == 0 && model.tipos_evaluaciones.value != "2") {
      window.toastr.error(
        "Por favor indique las competencias para la evaluación."
      );
      return;
    }
    model["id"] = id;
    model["competencias"] = evaluaciones;
    axios
      .post(`${path}evaluaciones/post`, model)
      .then(response => {
        if (response.data.code == "200") {
          window.toastr.success(response.data.message);
          window.setTimeout(
            window.alert,
            2000,
            (window.location = `${path}evaluaciones`)
          );
        } else {
          window.toastr.error(response.data.message);
        }
      })
      .catch(error => console.log(error));
    console.log(model);
    // actions.resetForm();
  };

  useEffect(() => {
    if (competencias.length == 0) {
      axios
        .get(`${path}evaluaciones/get`)
        .then(response => {
          let _competencias = response.data.data.competencia;
          var _tipos = _.map(response.data.data.tipos, i => ({
            label: i.nombre,
            value: i.id
          }));
          id = parseInt(id);
          if (id > 0) {
            axios
              .get(`${path}evaluaciones/getBy`, {
                params: { id: id }
              })
              .then(response => {
                var mcompetencias = response.data.data.competencias;
                var rsult = _.filter(_competencias, it =>
                  mcompetencias.some(com => com.competencias_id == it.id)
                );
                _competencias = _.remove(
                  _competencias,
                  it => !mcompetencias.some(com => com.competencias_id == it.id)
                );

                setState({
                  ...state,
                  tipos: _tipos,
                  model: response.data.data
                });
                setEvaluacion(rsult);
                setCompetencia(_competencias);
                setTemp(_competencias);
              })
              .catch(error =>
                window.toaster.error(
                  "Ocurrio un error al recuperar las competencias"
                )
              );
          } else {
            setState({ ...state, tipos: _tipos });
            setCompetencia(response.data.data.competencia);
            setTemp(response.data.data.competencia);
          }
        })
        .catch(err =>
          window.toaster.error("Ocurrio un error al recuperar las competencias")
        )
        .finally(() => {});
    }
  }, []);

  return (
      <div className="row">
        <Aside className="col-md-3">
          <section className="">
            <input
              type="text"
              className="form-control"
              placeholder="Buscar..."
              onChange={e => handleInputChange(e, competencias)}
            />
          </section>

          <div id="lol" style={{maxHeight:"80vh", overflow:"auto"}}>
          <ReactSortable
            tag="ul"
            className="cards aside-size "
            list={temp}
            sort={false}
            setList={setTemp}
            animation={150}
            group={{ name: "shared-group-name", put: false }}
          >
            {temp.map((item, key) => (
              <CollectionItem key={key} item={item}></CollectionItem>
            ))}
          </ReactSortable>
          </div>
        </Aside>
        <Main className="main col-md-9">
          <ul className="nav nav-tabs">
            <li className="active">
              <a data-index="1" href="#home">
                General
              </a>
            </li>
            <li>
              <a data-index="2" href="#menu2">
                Competencias
              </a>
            </li>
          </ul>
          <div>
            <Form proState={state} submit={handleSubmit}>
            <ReactSortable
              tag="ul"
              className="cards card-container"
              style={{ maxHeight: "450px", overflow:"auto" }}
              list={evaluaciones}
              setList={(newList, sortable, store) => {
                setEvaluacion(newList);
              }}
              animation={150}
              group="shared-group-name"
            >
              {evaluaciones.map((item, key) => (
                <CollectionEvItem
                  key={key}
                  item={item}
                  removeItem={removeItem}
                ></CollectionEvItem>
              ))}
            </ReactSortable>
            <span className="help-block">Arrastra las competencias aquí.</span>
          </Form>
          </div>
        </Main>
    </div>
  );
};

export default CustonEvaluaciones;
