import React, { useState, useEffect } from "react";
import ModalVef from "../bonos/ModalVerificar.jsx";
import FormM from "../bonos/ModalForm.jsx";
import axios from "axios";

function ModaLiberar({ tipo, selectorAction, selectorView, callBack }) {
  const path = window.jQuery("#base_url").attr("data-base-url");

  const [state, setState] = useState({
    idUsuario: "",
    empleado: [],
    perfil: false,
    importe: null,
    fecha: "",
    motivo: "",
    Empleados: _empleados,
    subordinados: [],
    setSubordinados: "",
    datU: [],
    idPeticion: "",
    puesto:''
  });
  const [idInicio, setIdinicio] = useState();
  const [peticion, Setpeticion] = useState({
    estado: [],
    status: "",
    importe: null,
    importeF: "",
    fechaF: "",
    fecha: "",
    motivo: "",
    motivoP: "",
    empleado:"",
    usuario: "",
    dateP: "",
    Creado: "",
    puestoF:"",
    Estados: [
      { value: "AUTORIZADO", label: "AUTORIZADO" },
      { value: "RECHAZADO", label: "RECHAZADO" }
    ]
  });
  const [validate, SetValidate] = useState({
    data: [],
    error: ""
  });
  const [form, setForm] = useState([]);
  const [idHis, setidHis] = useState();
  const [dataH, setDataH] = useState();
  const [HisAcc, setHisAcc] = useState(0);

  useEffect(() => {
    window.jQuery(document).on("click", selectorAction, function(e) {
      e.preventDefault();
      const idUsuario = window.jQuery(e.currentTarget).attr("data-in-eid");
      //console.log("idU",idUsuario);
      const perfil = window.jQuery(e.currentTarget).attr("data-in-perfil");
      const reply = window.jQuery(e.currentTarget).attr("data-in-reply");
      const _em = _.find(_empleados, it => it.value === idUsuario);
      if (reply != undefined) {
        setHisAcc(1);
        axios
          .get(`${path}Bonos/getDataPeticion/${reply}`)
          .then(function(response) {
            //console.log("respuesta",response.data.data);
            var date = new Date(response.data.data[0].fecha);
            var imp = parseInt(response.data.data[0].importe);
            setState({
              ...state,
              empleado: _em,
              fecha: new Date(date.setDate(date.getDate() + 1)),
              importe: imp,
              idPeticion: reply,
              setSubordinados: ""
            });
            $("#modal-form-bono").modal("show");
          });
      } else {
        setState({
          ...state,
          idUsuario: idUsuario,
          perfil: perfil != undefined ? true : false,
          empleado: _em,
          Empleados: _empleados,
          subordinados: []
        });
        $("#modal-form-bono").modal("show");
      }
    });
    if (selectorView != "") {
      window.jQuery(document).on("click", selectorView, function(e) {
        const id = window.jQuery(e.currentTarget).attr("data-in-id");
        setIdinicio(id);
        if (peticion.estado !== "") {
          $("#ModalVerificacion").modal("show");
        }
      });
    }
  }, []);

  useEffect(() => {
    if (idHis != undefined) {
      axios
        .get(`${path}Bonos/getSeguimiento/${idHis}`)
        .then(function(response) {
          //console.log("respuesta",response.data.data);
          setDataH(response.data.data);
        });
    }
  }, [idHis]);

  useEffect(() => {
    if (idInicio != undefined) {
      axios
        .get(`${path}Bonos/getDataPeticion/${idInicio}`)
        .then(function(response) {
          var date = new Date(response.data.data[0].fecha);
          //console.log("respuesta",response.data.data);
          Setpeticion({
            ...peticion,
            //estado:stats.find((item)=>item.label===response.data.data[0].estatus),
            status: response.data.data[0].estatus,
            importe: parseInt(response.data.data[0].importe),
            dateP: response.data.data[0].fecha,
            fecha: new Date(date.setDate(date.getDate() + 1)),
            motivoP: response.data.data[0].motivo,
            usuario: response.data.data[0].name_complete,
            Creado: response.data.data[0].Creador,
            importeF: response.data.data[0].importe_final,
            fechaF: response.data.data[0].fecha_aplicacion
          });
          //agregar(response);
        });
    }
  }, [idInicio]);
  //Metodos para la parte de Usuario y Subordinados
  function mapPuestos(respuesta) {
    const _ps = respuesta.map(i => {
      return { value: i.id, label: i.name_complete,puesto: i.puesto };
    });
    return _ps;
  }

  // function Subordinados() {
  //   setHisAcc(0);
  //   setState({
  //     ...state,
  //     setSubordinados: "something",
  //     empleado: [],
  //     importe: null,
  //     fecha: ""
  //   });
  //   $("#ModalFormBono").modal("show");
  // }
  const postData = (values, actions) => {
    let URL =
      HisAcc === 0 ? `${path}Bonos/postData` : `${path}Bonos/ReplicaBono`;
    axios.post(URL, values).then(function(response) {
      if (response.data.code == "200") {
        window.jQuery("#modal-form-bono").modal("hide");
        actions.resetForm();
        window.toastr.success(response.data.message);
        callBack();
        setHisAcc(0);
      } else {
        window.toastr.error(response.data.message);
      }
    });
  };
  //Metodos para la parte de las solicitudes

  function InsertSeguimiento(data) {
    axios.post(`${path}Bonos/insertSeguimiento`, data).then(function(response) {
      if (response.data.code == "200") {
        window.jQuery("#ModalVerificacion").modal("hide");
        callBack();
        // actions.resetForm();
        window.toastr.success(response.data.message);
      } else {
        window.toastr.error(response.data.message);
      }
    });
  }

  function reset() {
    Setpeticion({ ...peticion, estado: [] });
    setState({
      ...state,
      idUsuario: 0,
      empleado: '',
      subordinados: []
    });
  }
  const Submit = values => {
    values["idSeguimiento"] = idInicio;
    InsertSeguimiento(values);
    setForm(values);
  };
  $("#modal-form-bono").on("hidden.bs.modal", function() {
    reset();
  });

  return (
    <>
      <div
        className="modal fade bd-example-modal-lg"
        id="modal-form-bono"
        tabIndex="-1"
        role="dialog"
        aria-labelledby="exampleModalCenterTitle"
        aria-hidden="true"
      >
        <div className="modal-dialog modal-lg" role="document">
          <div className="modal-content">
            <FormM
              Titulo="Solicitud de bonos"
              state={state}
              postData={postData}
            />
          </div>
        </div>
      </div>

      <ModalVef
        Titulo="Respuesta a solicitud de bonos"
        state={peticion}
        Submit={Submit}
        validate={validate}
      />
    </>
  );
}

export default ModaLiberar;
