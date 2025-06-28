import React, { useState, useEffect } from "react";
import Nuevo from "../Permisos/Nuevo.jsx";
import axios from "axios";

const Permisos = ({ AccionNuevo, callbackSuccess }) => {
  const path = window.jQuery("#base_url").attr("data-base-url");
  const [state,setState]=useState({
    data:[],
    Accion:''
  });

  useEffect(() => {
    if(AccionNuevo !=""){
      window.jQuery(document).on("click", AccionNuevo, function(e) {
        e.preventDefault();
          setState({
            ...state,
            Accion:"1"
          });
          window.jQuery("#modalPermisos").modal("show");
      });
    }
  }, []);



  const postdatesfilter=(values,actions)=>{
    var postUrl=path+"Siniestros/filterdates";
    var data = new FormData();
    data.append("aseguradora_id",values.aseguradora_id);
    data.append("cliente_id",values.cliente_id);
    data.append("FechaI",formatDate(values.Fechainicio));
    data.append("FechaF",formatDate(values.FechaFin));
    //data.append("FechaI", );

    document.getElementById("over").style.display = "block"; 
    document.getElementById("upProgressModal").style.display = "block";
    setLoad(!load);
    
    axios
    .post(postUrl, data)
    .then(function(response) {
      if(response.data.code!=200||response.data.code!="200"){
        toastr.error(response.data.message);
      }else{
        toastr.success("Exíto");
      }
      document.getElementById("over").style.display = "none"; 
      document.getElementById("upProgressModal").style.display = "none";
      window.jQuery("#modalSiniestros").modal("hide"); 
      actions.resetForm();
      window.jQuery("#reloadT").click();
    })
    .catch(error => {alert('ERROR')});

  }

  
  return (
    <>
    <div
      id="modalPermisos"
      className="modal"
      tabIndex="-1"
      role="dialog"
      aria-labelledby="myLargeModalLabel"
      aria-hidden="true"
      data-backdrop="static" 
      data-keyboard="false"
    >
      <div className="modal-dialog modal-lg">
        <div className="modal-content">
            {state.Accion=="1" && 
                <Nuevo Titulo="Permisos" data={state.data} callbackSuccess={callbackSuccess} />
            }
        </div>
      </div>
      
    </div>
    </>
  );

};

export default Permisos;
