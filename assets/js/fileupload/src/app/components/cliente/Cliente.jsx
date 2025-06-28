import React, { useState, useEffect } from "react";
import ClienteM from "../cliente/Modal_cliente.jsx";
import Notificacion from "../cliente/Modal_notificacion.jsx";
import Indicadores from "../cliente/Modal_Indicadores.jsx";
import axios from "axios";
import { string } from "yup";

const Cliente = ({ AccionEditarE, AccionNuevoE,AccionEditarN, AccionNuevoN,AccionEditarI, AccionNuevoI, callBack }) => {
  const path = window.jQuery("#base_url").attr("data-base-url");
  const [state,setState]=useState({
    data:[],
    Accion:''
  });
/*   useEffect(() => {
    return () => {
      window.jQuery("#modalSiniestros").modal("show");
    }
  }, [bitacora]); */
  
  useEffect(() => {
    if(AccionNuevoE !=""){
      window.jQuery(document).on("click", AccionNuevoE, function(e) {
        e.preventDefault();
          setState({
            ...state,
            Accion:"1"
          });
          window.jQuery("#modalSiniestros").modal("show");
      });
    }
    if (AccionEditarE != "") {
        window.jQuery(document).on("click", AccionEditarE, function(e) {
          e.preventDefault();
          setState({
            ...state,
            data:{
                id:window.jQuery(e.currentTarget).attr("data-id"),
                usuario_id:window.jQuery(e.currentTarget).attr("data-usuario"),
                cliente_id:window.jQuery(e.currentTarget).attr("data-cliente"),
                tipo:window.jQuery(e.currentTarget).attr("data-tipo")
            },
            Accion:"2"
          });
          //console.log("dataReact",JSON.parse(decodeURIComponent(escape(window.atob(window.jQuery(e.currentTarget).attr("data-row"))))));
          window.jQuery("#modalSiniestros").modal("show");
        });
      }
    if (AccionNuevoN != "") {
        window.jQuery(document).on("click", AccionNuevoN, function(e) {
          e.preventDefault();
          //console.log("Data",JSON.parse(window.jQuery(e.currentTarget).attr("data-row")));
          setState({
            ...state,
            //data:JSON.parse(decodeURIComponent(escape(window.atob(window.jQuery(e.currentTarget).attr("data-row"))))),
            Accion:"3"
          });
          window.jQuery("#modalSiniestros").modal("show");
        });
      }
    if (AccionEditarN != "") {
        window.jQuery(document).on("click", AccionEditarN, function(e) {
          e.preventDefault();
          var datos=JSON.parse(window.jQuery(e.currentTarget).attr("data-row"));
          var esca1=JSON.parse(datos.escalamiento_1);
          var esca2=JSON.parse(datos.escalamiento_2);
          var dta={
            id:datos.id,
            cliente_id:!datos.cliente_id?'':(datos.cliente_id).toString(),
            tipo_id:(datos.tipo_id).toString(),
            sub_tipo_id:(datos.sub_tipo_id).toString(),
            causa_id:(datos.causa_id).toString(),
            dias:datos.dias,
            escalamiento_1:esca1.usuarios,
            escalamiento_2:esca2.usuarios,
            dias_posteriores_1:esca1.dias,
            dias_posteriores_2:esca2.dias,
            notificacion:JSON.parse(datos.tipo_notificacion)
          }
          console.log(dta);
          setState({
            ...state,
            data:dta,
            Accion:"4",

          });
          window.jQuery("#modalSiniestros").modal("show");
        });
      }
      if(AccionNuevoI !=""){
        window.jQuery(document).on("click", AccionNuevoI, function(e) {
          e.preventDefault();
            setState({
              ...state,
              Accion:"5"
            });
            window.jQuery("#modalSiniestros").modal("show");
        });
      }
      if(AccionEditarI !=""){
        window.jQuery(document).on("click", AccionEditarI, function(e) {
          e.preventDefault();
          var datos=JSON.parse(window.jQuery(e.currentTarget).attr("data-row"));
          var dta={
            id:datos.id,
            cliente_id:!datos.cliente_id?'':(datos.cliente_id).toString(),
            tipo_id:(datos.tipo_id).toString(),
            sub_tipo_id:(datos.sub_tipo_id).toString(),
            causa_id:(datos.causa_id).toString(),
            dias:(datos.dias).toString(),
          }
          console.log(dta);
            setState({
              ...state,
              data:dta,
              Accion:"6"
            });
            window.jQuery("#modalSiniestros").modal("show");
        });
      }
  }, []);

  const postEjecutivoAdd=(values,actions)=>{
    var url=state.Accion=="1"?"Serviciosws/servicio_postE/1":"Serviciosws/servicio_postE/2";
    var postUrl=path+url;
    var data = new FormData();
    data.append("id",values.id);
    data.append("cliente",values.cliente_id);
    data.append("usuario",values.usuario_id);
    data.append("tipo",values.tipo);
    //console.log(values);
    axios
    .post(postUrl, data)
    .then(function(response) {
      if(response.data.code!=200||response.data.code!="200"){
        toastr.error(response.data.message);
      }else{
        window.jQuery("#modalSiniestros").modal("hide"); 
        toastr.success("Éxito");
        actions.resetForm();
        callBack();
      }
    })
    .catch(error => {});
  }

  return (
    <>
    <div
      id="modalSiniestros"
      className="modal"
      tabIndex="-1"
      role="dialog"
      aria-labelledby="myLargeModalLabel"
      aria-hidden="true"
      data-backdrop="static" 
      data-keyboard="false"
    >
      <div className="modal-dialog modal-lg">
         {/*  <button className="btn" onClick={()=>console.log(state)}>state</button> */}
        <div className="modal-content">
            {state.Accion=="1" && 
                <ClienteM Titulo="Nuevo registro" post={postEjecutivoAdd} data={state.data}  Accion={state.Accion} />
            }
            {state.Accion=="2" && 
                <ClienteM Titulo="Editar registro" post={postEjecutivoAdd} data={state.data} Accion={state.Accion} />
            }
            {state.Accion=="3" && 
               <Notificacion Titulo="Nuevo registro" Accion={state.Accion} callBack={callBack} data={state.data} />
            }
            {state.Accion=="4" && 
                <Notificacion Titulo="Editar registro" Accion={state.Accion} callBack={callBack} data={state.data}/>
            }
            {state.Accion=="5" && 
               <Indicadores Titulo="Nuevo registro" Accion={state.Accion} callBack={callBack}/>
            }
            {state.Accion=="6" && 
                <Indicadores Titulo="Editar registro" Accion={state.Accion}callBack={callBack} data={state.data}/>
            }
        </div>
      </div>
      
    </div>
    <div id="upProgressModal" style={{display:'none'}} role="status" aria-hidden="true">
        <div id="nprogress" className="nprogress">
            <div className="spinner">
                <div className="spinner-icon"></div>
                <div className="spinner-icon-bg"></div>
            </div>
            <div className="overlay"></div>
        </div>
    </div>
    </>
  );

};

export default Cliente;
