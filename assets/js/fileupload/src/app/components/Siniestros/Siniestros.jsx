import React, { useState, useEffect } from "react";
import Info from "../Siniestros/ShowInfo.jsx";
import Edit from "../Siniestros/EditSiniestro.jsx";
import New from "../Siniestros/Filterdates.jsx";
import Cargar from "../Siniestros/CargaExcel.jsx";
import axios from "axios";

const Siniestros = ({ AccionVer,AccionEditar, AccionNuevo,AccionActualizar,AccionCargar, callBack }) => {
  const path = window.jQuery("#base_url").attr("data-base-url");
  const [load,setLoad]=useState(false);
  const [state,setState]=useState({
    data:[],
    Accion:''
  });
  const [bitacora,setbitacora]=useState({
    especial:[],
    data:[],
    index:null
  });

  useEffect(() => {
    return () => {
      //console.log("bitacora",bitacora);
      window.jQuery("#modalSiniestros").modal("show");
    }
  }, [bitacora]);
  
  useEffect(() => {
    if(AccionActualizar !=""){
      window.jQuery(document).on("click", AccionActualizar, function(e) {
        e.preventDefault();
          setState({
            ...state,
            Accion:"4"
          });
          window.jQuery("#modalSiniestros").modal("show");
      });
    }
    if (AccionVer != "") {
        window.jQuery(document).on("click", AccionVer, function(e) {
          e.preventDefault();
          const dataelement=JSON.parse(decodeURIComponent(escape(window.atob(window.jQuery(e.currentTarget).attr("data-row")))));
          setState({
            ...state,
            data:dataelement,
            Accion:"1"
          });
          getBitacora(window.jQuery(e.currentTarget).attr("data-cabina"),dataelement);
          //console.log("dataReact",JSON.parse(decodeURIComponent(escape(window.atob(window.jQuery(e.currentTarget).attr("data-row"))))));
          //window.jQuery("#modalSiniestros").modal("show");
        });
      }
    if (AccionEditar != "") {
        window.jQuery(document).on("click", AccionEditar, function(e) {
          e.preventDefault();
          //console.log("Data",JSON.parse(window.jQuery(e.currentTarget).attr("data-row")));
          setState({
            ...state,
            data:JSON.parse(decodeURIComponent(escape(window.atob(window.jQuery(e.currentTarget).attr("data-row"))))),
            Accion:"2"
          });
          window.jQuery("#modalSiniestros").modal("show");
        });
      }
    if (AccionNuevo != "") {
        window.jQuery(document).on("click", AccionNuevo, function(e) {
          e.preventDefault();
          setState({
            ...state,
            Accion:"3"
          });
          window.jQuery("#modalSiniestros").modal("show");
        });
      }
      if (AccionCargar != "") {
        window.jQuery(document).on("click", AccionCargar, function(e) {
          e.preventDefault();
          setState({
            ...state,
            Accion:"5"
          });
          window.jQuery("#modalSiniestros").modal("show");
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

  const getBitacora=(id,dataesp)=>{
    //console.log("Entro a la bitacora");
    var postUrl=path+"Siniestros/Siniestros_bitacora";
    var data = new FormData();
    data.append("id",id);
    axios
    .post(postUrl, data)
    .then(function(response) {
      //console.log("reponse bitacora",response.data);
        setbitacora({
          ...bitacora,
          especial:dataesp,
          data:response.data.data
        });
        
    })
    .catch(error => {});
    

  }

  const postEdit=(values,actions)=>{
    //console.log("values edit",values);
    var postUrl=path+"Siniestros/postData";
    //console.log("values",values);
    var data = new FormData();
    data.append("Accion",state.Accion==2?"Editar":"Nuevo");
    data.append("Data",JSON.stringify(values)); 
    axios
    .post(postUrl, data)
    .then(function(response) {
      toastr.success("Exíto");
      window.jQuery("#modalSiniestros").modal("hide"); 
      actions.resetForm();
      window.jQuery("#reloadT").click();
    })
    .catch(error => {console.log("Eror")});
    callBack();
  }

  const actualizar =()=>{
    var postUrl=path+"Siniestros/updateSiniestroWS";
    //console.log(state.data);
    var data = new FormData();
    data.append("id",state.data.cabina_id);
    data.append("aseguradora_id",state.data.aseguradora_id);
    data.append("cliente_id",state.data.cliente_id);
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
        const newData=response.data.data[0];
        const id=state.data.cabina_id;
        //console.log("respuesta",response.data.data[0]);
        getBitacora(id,newData);
        setState({
          ...state,
          data:newData
        });
      }
      window.jQuery("#reloadT").click();
      document.getElementById("over").style.display = "none"; 
      document.getElementById("upProgressModal").style.display = "none";
      //getBitacora(state.data.cabina_id,newData);
      //const newData=JSON.parse(decodeURIComponent(escape(window.atob(document.getElementById(state.data.cabina_id).getAttribute("data-row")))));
      //console.log("DATANEW",newData);
    })
    .catch(error => {});
  }

  const uploadFile=(values,actions)=>{
    var postUrl=path+"Siniestros/registros";
    var formData = new FormData();
    formData.append("isRequest", true);
    formData.append("aseguradora_id",values.aseguradora_id);
    formData.append("cliente_id",values.cliente_id);
    formData.append('document', values.file, values.file.name);

    document.getElementById("over").style.display = "block"; 
    document.getElementById("upProgressModal").style.display = "block";
    setLoad(!load);
    axios({
      method : 'POST',
      url :postUrl,
      data:formData,
      headers: {
          'Content-Type' : false,
          'processData': false,
      },
  }).then((response) => {
      document.getElementById("over").style.display = "none"; 
      document.getElementById("upProgressModal").style.display = "none";
      if(response.data.code!=200||response.data.code!="200"){
        toastr.error(response.data.message);
      }else{
        window.jQuery("#reloadT").click();
        toastr.success("Exíto");
        window.jQuery("#modalSiniestros").modal("hide"); 
      }

  }).catch(function (error) {
      console.log(error);
  });
    //console.log("Nombre",values.file.name);
  }

  const clic_bitacora=(index)=>{
      if(index!=="Actual"){
        const data=bitacora.data[index].informacion;
        /* const formatdata=JSON.parse(data);
        console.log("DTACLICK",formatdata[0]); */
        setbitacora({
          ...bitacora,
          index:index
        });
        setState({
          ...state,
          data:JSON.parse(data)[0]
        });
      }else{
        setbitacora({
          ...bitacora,
          index:null
        });
        setState({
          ...state,
          data:bitacora.especial
        });
      }
  }


  function formatDate(date) {
    return moment(date).format("YYYY-MM-DD");
    /* var current_datetime=new Date(date);
    var d = current_datetime.getDate();
    var m = current_datetime.getMonth() + 1;
    var y = current_datetime.getFullYear();
    return y + '-' + (m<=9 ? '0' + m : m) + '-' + (d <= 9 ? '0' + d : d); */
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
        <div className="modal-content">
            {state.Accion=="1" && 
                <Info Titulo="Información del siniestro" actualizar={actualizar} data={state.data} bitacora={bitacora} click_botacora={clic_bitacora}/>
            }
            {state.Accion=="2" && 
                <Edit Titulo="Editar del siniestro" postEdit={postEdit} data={state.data} Accion={state.Accion}/>
            }
            {state.Accion=="4" && 
               <New Titulo="Actualizar por rango de fechas" postdatesfilter={postdatesfilter}  />
            }
            {state.Accion=="3" && 
                <Edit Titulo="Nuevo del siniestro" postEdit={postEdit} data={state.data} Accion={state.Accion}/>
            }
            {state.Accion=="5" && 
                <Cargar Titulo="Subir documento" uploadFile={uploadFile} />
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

export default Siniestros;
