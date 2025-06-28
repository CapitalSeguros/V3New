import React, { useState, useEffect, forwardRef } from "react";
import axios from "axios";
import HeadMonitoreo from "./HeadMonitoreo.jsx";
import DescpMonitoreo from "./DescripcionMonitoreo.jsx";
import ItemMonitoreo from "./ItemMonitoreo.jsx";
import ItemComentario from "./ItemComentario.jsx";

function MonitoreoPIP(props) {
  const path = window.jQuery("#base_url").attr("data-base-url");

  const [state, setState] = useState({
    IdPIP: "",
    Nombre: "",
    Departamento: "",
    Comentario: "",
    Elementos: [],
    Comentarios: [],
    Add: false,
    AddComent: "",
    Estatus:'',
    Itemseleccionado: {}
  });

  useEffect(() => {
    //var partPath = String(window.location.pathname).split("/");
    const partPath=window.jQuery("#idM").attr("data-id");
    const params = { idPI: partPath };
    axios
      .get(`${path}PIP/getDataMonitoreo`, { params })
      .then(function(response) {
        const datalog = mapItemsEdit(response.data.data.Taks);
        setState({
          ...state,
          Nombre: response.data.data.Info[0].name_complete,
          Departamento: response.data.data.Info[0].personaPuesto,
          Comentario: response.data.data.Info[0].comentario,
          Estatus:response.data.data.Info[0].estatus,
          Elementos: datalog,
          IdPIP: response.data.data.Info[0].id
        });
      });
  }, []);

  function mapItemsEdit(data) {
    var Items = [],
      Ct = [],
      CtInfo = [];
    const Pt = data.filter(item => item.parent === "0");
    Pt.forEach((item, index) => {
      Ct = data.filter(item2 => item2.parent === item.id);
      Items.push({
        titulo: item.titulo,
        Evidencia: item.observacion,
        Mejora: item.resultado_esperado,
        Lista: Ct,
        id: item.id,
        Fecha: item.fecha === "0000-00-00" ? null : item.fecha
      });
    });
    return Items;
  }

  function AddComentario() {
    axios.post(`${path}PIP/AddComentario`, state).then(function(response) {
      window.toastr.success("Éxito");
      setState({ ...state, AddComent: "" });
    });
  }
  function getComentarios(id, item) {
    const params = { idPI: id };
    axios
      .get(`${path}PIP/getComentarios`, { params })
      .then(function(response) {
        setState({
          ...state,
          Add: false,
          Itemseleccionado: item,
          Comentarios: response.data.data.Comentarios,
          AddComent: ""
        });
      })
      .then(function() {
        $("#exampleModalCenter").modal("show");
      });
  }

  function OpenModal(item) {
    setState({ ...state, Add: true, Itemseleccionado: item, AddComent: "" });
    $("#exampleModalCenter").modal("show");
  }

  function OpenComentarios(id, item) {
    getComentarios(id, item);
  }

  return (
    <div className="container-fluid">
      <div>
        <div className="row">
          <div className="col-md-4">
            <h4>Colaborador: {state.Nombre.toUpperCase()}</h4>
          </div>
          <div className="col-md-4">
            <h4>Departamento: {state.Departamento.toUpperCase()}</h4>
          </div>
        </div>
        <div className="row">
          {state.Elementos.map((item, index) => (
            <div className="col-md-12" key={index}>
              <div className="panel panel-default">
                <HeadMonitoreo
                  OpenComentarios={OpenComentarios}
                  estatus={state.Estatus}
                  Idp={item.id}
                  AddComentario={AddComentario}
                  item={item}
                  OpenModal={OpenModal}
                  index={index}
                  titulo={item.titulo}
                />
                <div>
                  <div className="panel-body">
                    <DescpMonitoreo
                      key={index}
                      Fecha={item.Fecha}
                      Evidencia={item.Evidencia}
                      Mejora={item.Mejora}
                    />
                    <div className="row">
                      <div className="col-md-12" id="lista-mejora">
                        <div>
                          <strong>
                            <span
                              className="fa fa-list"
                              aria-hidden="true"
                            ></span>
                            Lista de acciones para la mejora de desempeño:
                          </strong>
                        </div>
                        <ul className="list-group">
                          {item.Lista.map((item2, index2) => (
                            <ItemMonitoreo
                              estatus={state.Estatus}
                              OpenComentarios={OpenComentarios}
                              Idp={item2.id}
                              item={item2}
                              OpenModal={OpenModal}
                              key={index2}
                              Titulo={item2.titulo}
                            />
                          ))}
                        </ul>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          ))}
        </div>

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
                <button
                  type="button"
                  className="close"
                  data-dismiss="modal"
                  aria-label="Close"
                >
                  <span aria-hidden="true">&times;</span>
                </button>
                <h4 className="modal-title">{state.Itemseleccionado.titulo}</h4>
              </div>
              <div className="modal-body">
                {state.Add !== false ? (
                  <div className="row">
                    <div className="col-md-12">
                      <div className="form-group">
                        <p>
                          <em>
                            Escriba un comentario referente al desempeño del
                            usuario sobre la actividad seleccionada
                          </em>
                        </p>
                        <textarea
                          value={state.AddComent}
                          onChange={e =>
                            setState({ ...state, AddComent: e.target.value })
                          }
                          name="comentario"
                          id="comentario"
                          className="form-control"
                          style={{ resize: "none" }}
                        ></textarea>
                        <label className="control-label">
                          Caracteres ingresados:{state.AddComent.length} de 500
                        </label>
                      </div>
                    </div>
                  </div>
                ) : (
                  <div className="row">
                    <div className="col-md-12">
                      {state.Comentarios.length != 0 ? (
                        <ul className="media-list">
                          {state.Comentarios.map((itemx, index) => (
                            <ItemComentario key={index} item={itemx} />
                          ))}
                        </ul>
                      ) : (
                        <div style={{ textAlign: "center", height: 80 }}>
                          <p> No hay comentarios disponibles</p>
                        </div>
                      )}
                    </div>
                  </div>
                )}
              </div>
              {state.Add !== false ? (
                <div className="modal-footer">
                  <button
                    type="button"
                    disabled={!state.AddComent}
                    onClick={AddComentario}
                    id="close"
                    className="btn btn-primary"
                    data-dismiss="modal"
                  >
                    <span className="fa fa-floppy-o" aria-hidden="true"></span>{" "}
                    Guardar
                  </button>
                </div>
              ) : (
                ""
              )}
            </div>
          </div>
        </div>
      </div>
    </div>
  );
}

export default MonitoreoPIP;
