import React, { useState, useEffect } from "react";
import ModalVef from "../TabuladorBono/Modalverificar.jsx";
import FormM from "../TabuladorBono/ModalForm.jsx";
import axios from "axios";

function ModaLiberar({ tipo, selectorAction, selectorView,selectorEdit, callBack }) {
  const path = window.jQuery("#base_url").attr("data-base-url");

  const [state, setState] = useState({
    idUsuario: "",
    edit:'',
    Puesto: [],
    importe: 0,
    Puntos:0,
    Puestos: _puestos,
  });
  const [idInicio, setIdinicio] = useState();
  const [idEdit, setIdEdit] = useState();
  const [peticion, Setpeticion] = useState({
    estado: [],
    status: "",
    Puesto:"",
    Puesto2:"",
    Puntos:"",
    PuntosF:"",
    importe: null,
    importeF: "",
    motivo:"",
    Creado: "",
    Estados: [
      { value: "APROBADO", label: "APROBADO" },
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
  const [edit,setEdit]=useState('');
  const [seguimiento,setSeguimiento]=useState('');

  useEffect(()=>{
    return () => {
      window.jQuery("#modal-form-bono").modal("show");
    }
  },[edit]);
  useEffect(()=>{
    return () => {
      window.jQuery("#ModalVerificacion").modal("show");
    }
  },[seguimiento]);

  useEffect(() => {
    window.jQuery(document).on("click", selectorAction, function(e) {
      const idUsuario = window.jQuery(e.currentTarget).attr("data-in-eid");
      e.preventDefault();
      reset();
      $("#modal-form-bono").modal("show");
    });
    if (selectorView != "") {
      window.jQuery(document).on("click", selectorView, function(e) {
        const id = window.jQuery(e.currentTarget).attr("data-in-id");
        Inicio(id);
        setIdinicio(id);
        setSeguimiento(Math.random());
        /* if (peticion.estado !== "") {
          $("#ModalVerificacion").modal("show");
        } */
      });
    }
    if (selectorEdit != "") {
      window.jQuery(document).on("click", selectorEdit, function(e) {
        e.preventDefault();
        const id = window.jQuery(e.currentTarget).attr("data-in-id");
        Editar(id);
        setEdit(Math.random());
        /* if(state.Puntos!==''){
          $("#modal-form-bono").modal("show");
        } */
      });
    }
  }, []);

  const Editar=(id)=>{
    axios
        .get(`${path}TabuladorBonos/getRegistro/${id}`)
        .then(function(response) {
          //console.log("Response", response.data.data[0]);
          const _em = _.find(_puestos, it => it.value === response.data.data[0].puesto_id.toString());
          setState({...state,
            Puntos: response.data.data[0].calificacion,
            importe: response.data.data[0].sueldo,
            Puesto:_em,
            //Puesto2:_puestos2,
            edit:id
          });
          //$("#modal-form-bono").modal("show");
          //agregar(response);
        });
  }

  const Inicio=(id)=>{
    axios
        .get(`${path}TabuladorBonos/getRegistro/${id}`)
        .then(function(response) {
          Setpeticion({
            ...peticion,
            //estado:stats.find((item)=>item.label===response.data.data[0].estatus),
            status: response.data.data[0].estado,
            importe: parseInt(response.data.data[0].sueldo),
            importeF:parseInt(response.data.data[0].sueldo),
            Puntos:response.data.data[0].calificacion,
            PuntosF:response.data.data[0].calificacion,
            Puesto: response.data.data[0].personaPuesto,
            Creado: response.data.data[0].creado
          });
          //agregar(response);
        });
  }

  //Metodos para la parte de Usuario y Subordinados
  function mapPuestos(respuesta) {
    const _ps = respuesta.map(i => {
      return { value: i.id, label: i.name_complete };
    });
    return _ps;
  }
  const postData = (values, actions) => {
    let URL = state.edit?`${path}TabuladorBonos/editRegistro`:`${path}TabuladorBonos/postData`;
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
    axios.post(`${path}TabuladorBonos/insertSeguimiento`, data).then(function(response) {
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
    //Setpeticion({ ...peticion, estado: [] });
    setState({
      ...state,
      idUsuario: 0,
      Puesto:[],
      Puntos:null,
      importe:null,
      edit:''
    });
  }
  const Submit = values => {
    values["idSeguimiento"] = idInicio;
    InsertSeguimiento(values);
    setForm(values);
  };
 /*  $("#modal-form-bono").on("hidden.bs.modal", function() {
    reset();
  }); */

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
              Titulo="Nueva solicitud de Tabulador de bonos"
              state={state}
              postData={postData}
            />
          </div>
        </div>
      </div>

      <ModalVef
        Titulo="Respuesta a solicitud de Tabulador de bonos"
        state={peticion}
        Submit={Submit}
        validate={validate}
      />
    </>
  );
}

export default ModaLiberar;
