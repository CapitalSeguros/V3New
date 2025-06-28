import React, { useEffect, useState } from "react";
import IncidenciaForm from "./IncidenciaForm.jsx";
import axios from "axios";

const $path = $("#base_url").attr("data-base-url");
const ModalTemplate = props => (
  <div
    id="modalIncidecias"
    className="modal"
    tabIndex="-1"
    role="dialog"
    aria-labelledby="myLargeModalLabel"
    aria-hidden="true"
    data-backdrop="static" data-keyboard="false"
  >
    <div className="modal-dialog modal-lg">
      <div className="modal-content">
        <IncidenciaForm
          mode={props.mode}
          id={props.id}
          type={
            props.id == undefined ? "" : props.empleadoModel.tipo_incidencias_id
          }
          employee={
            props.id == undefined || props.id == 0
              ? props.mode == "vacaciones"
                ? {
                    value: props.empleadoModel.empleado_id,
                    label: props.empleadoModel.name_complete
                  }
                : ''
              : props.empleadoModel.name_complete==undefined?'':
              {
                value: props.empleadoModel.empleado_id,
                label: props.empleadoModel.name_complete
              }
          }
          days={props.id == undefined ? 0 : props.empleadoModel.dias}
          start={props.id == undefined ? "" : props.empleadoModel.fecha_inicio}
          comment={
            props.id == undefined
              ? ""
              : props.empleadoModel.comentario == null
              ? ""
              : props.empleadoModel.comentario
          }
          types={props.types}
          employees={props.employees}
          submit={props.submit}
          reset={props.reset}
        />
      </div>
    </div>
  </div>
);

const Incidencias = ({
  actionOpen,
  start,
  reference,
  callBack,
  fecha,
  empleadoId,
  incidencia
}) => {
  const [types, setTypes] = useState([]);
  const [state, setState] = useState({
    model: {
      empleado_id: 0,
      fecha_inicio: "",
      dias: 0,
      comentario: "",
      employee: ''
    },
    employees: []
  });
  const [loading, setLoading] = useState({
    id: -1,
    name: "",
    type: "",
    days: 0,
    mode: "normal"
  });

  useEffect(() => {
    axios
      .get(`${$path}incidencias/getIncidenciaCatalogo`)
      .then(function(response) {
        setTypes(response.data.data.types);
        setState({
          ...state,
          employees: _empleados
        });
      })
      .catch(function(error) {
        window.toastr.error("Error al recuperar la información !");
      });

    if (actionOpen != "") {
      window.jQuery(document).on("click", actionOpen, function(e) {
        var dv = document.querySelector(".dvModalIncidencia");
        if (dv == undefined) {
          dv = document.createElement("div");
          dv.classList.add("dvModalIncidencia");
          document.body.appendChild(dv);
        }
        const mode = window.jQuery(e.currentTarget).attr("data-in-mode");
        const name = window.jQuery(e.currentTarget).attr("data-in-name");
        const id = window.jQuery(e.currentTarget).attr("data-in-id");
        const empleado_id = window.jQuery(e.currentTarget).attr("data-in-eid");
        const type = window.jQuery(e.currentTarget).attr("data-in-ty");
        const days = window.jQuery(e.currentTarget).attr("data-in-days");

        if (id != undefined && id != loading.id) {
          setLoading({
            id: id,
            mode: mode == undefined ? "normal" : mode
          });

          setState({
            ...state,
            model: {
              empleado_id: empleado_id,
              tipo_incidencias_id: type,
              fecha_inicio: "",
              dias: days,
              comentario: "",
              name_complete: name,
              employee: {
                name_complete: name,
                empleado_id: empleado_id
              }
            }
          });
        }
        $("#noFile").text("");
        $("#file").val("");
        window.jQuery("#modalIncidecias").modal("show");
      });
    }
  }, []);

  useEffect(() => {
    if (incidencia != undefined && loading.id)
      setState({ ...state, model: incidencia });
  }, [loading.id]);

  const submitInputHandler = (values, actions) => {
    var data = new FormData();
    // data.append('referenciaId', referenceId);
    data.append("reference", reference);
    data.append("id", values.id);
    data.append("type", values.type);
    data.append("employee", values.employee.value);
    data.append(
      "start",
      typeof values.start == "string"
        ? values.start
        : values.start.toISOString()
    );
    data.append("comment", values.comment);
    data.append("days", values.days);
    for (const key in values.file) {
      data.append(key, values.file[key]);
    }
    axios
      .post(`${$path}incidencias/postAgregarIncidencia`, data)
      .then(response => {
        console.log("respuesta",response.data);
        if (response.data.code!=200||response.data.code!="200") {
          window.toastr.error(response.data.message);
        } else {
          window.toastr.success(response.data.message);
          window.jQuery("#modalIncidecias").modal("hide");
          actions.resetForm();
          callBack(response.data);
        }
        // setLoading(false);
        // actions.resetForm();
      })
     /*  .catch(error => {
        window.toastr.error("Error al recuperar la información !");
      }); */
  };


  const reset=()=>{
    setLoading({
      ...loading,
      id: undefined,
      name: "",
      type: "",
      days: 0,
      mode: "normal"
    });
    setState({
      ...state,
      model: {
        empleado_id: 0,
        fecha_inicio: "",
        dias: 0,
        comentario: "",
        employee: ''
      },
      employees: []
    });
  }

  return (
    <ModalTemplate
      mode={loading.mode}
      id={loading.id}
      name={loading.name}
      type={loading.type}
      days={loading.days}
      submit={submitInputHandler}
      types={types}
      empleadoModel={state.model}
      start={fecha}
      employees={state.employees}
      reset={reset}
    />
  );
};

export default Incidencias;
