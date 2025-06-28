import React, { useState, useEffect } from "react";
import New from "../Aseguradora/Nuevo.jsx";
import axios from "axios";

const Aseguradora = ({ AccionVer,AccionEditar, AccionNuevo, callBack,Datatable }) => {
  const path = window.jQuery("#base_url").attr("data-base-url");
  const [state,setState]=useState({
    conexiontext:[],
    json:[],
    objeto:"",
    AccionS:"0",
    Aseguradora:"0",
    url:"",
    Accionws:"",
    cliente:""
  });
  
 /*  useEffect(() => {
    return () => {
      window.jQuery("#modalSiniestros").modal("show");
    }
  }, [state]); */
  
  useEffect(() => {
      if (AccionEditar != "") {
        window.jQuery(document).on("click", AccionEditar, function(e) {
          const data=JSON.parse(window.jQuery(e.currentTarget).attr("data-row"));
          setState({...state,
            conexiontext:data.objetojson,
            json:data.json_dinamico,
            objeto:data.objetocampo,
            AccionS:window.jQuery(e.currentTarget).attr("data-servicio"),
            Aseguradora:window.jQuery(e.currentTarget).attr("data-aseguradora"),
            url:data.url,
            cliente:window.jQuery(e.currentTarget).attr("data-cliente"),
            Accionws:window.jQuery(e.currentTarget).attr("data-metodo"),
            Accion:"2",
            id:window.jQuery(e.currentTarget).attr("data-id")
          });
          window.jQuery("#modalAseguradora").modal("show");
        });
      }
    if (AccionNuevo != "") {
        window.jQuery(document).on("click", AccionNuevo, function(e) {
          e.preventDefault();
          setState({
            ...state,
            Accion:"3"
          });
          window.jQuery("#modalAseguradora").modal("show");
        });
      }

      $('#modalAseguradora').on('hidden.bs.modal', function (e) {
        reloadform();
        //console.log("se cerro");
      })
  }, []);

  const handleInput=(e)=> {
    const { value, name } = e.currentTarget;
    if(name=="conexion"){
        try{
            let valor=JSON.parse(value);
            const procss=ObjectKey(valor);
            const arrayJSON=get_logs();
            console.log("array",arrayJSON);
            setState({ ...state, json: arrayJSON,objeto:value,conexiontext:valor });
        }catch(e){
            $("#logs").empty();
            toastr.error("Revise la estructura ingresada");
        }
    }
    else{
      setState({ ...state, [name]: value });
    }
  }

  const onchangeDinamic=(index,e)=>{
    const { value, name } = e.currentTarget;
    const data=state.json;
    data[index].value=value;
    setState({ ...state, json: data});
  }

  const ObjectKey = o => {
    $("#logs").empty();
      Object.keys(o).forEach(k => {
        if(typeof o[k] === 'object'){
          ObjectKey(o[k]);
        } else {
            $("#logs").append(`<label style="display: none;">${k}</label>`);
        }
      });
    }

    const ObjectKeyPost = ()=> {
      const dato=state.json;
      let returnObj=state.conexiontext;
      let string;
      dato.forEach(el=>{
        string=JSON.stringify(returnObj);
         const obj = JSON.parse(string, (k, v) => k == el.elemento && el.dinamico==false? el.value : v);
        returnObj=obj;
      });
      return returnObj;
    }
    const get_logs=()=>{
        let array=[];
        $('#logs label').each(function(i,elemento) {
            let text=$(this).html();
            array.push({elemento:text,dinamico:false,value:""});
        });
        return array;
    };

    const dinamico=(index)=>{
      const data=state.json;
      data[index].dinamico=!data[index].dinamico;
      setState({ ...state, json: data});
      //console.log("dinamico",data[index]);
    }
    const reloadform=()=>{
      setState({ ...state,
        conexiontext:[],
        url:"",
        json:[],
        objeto:"",
        conexiontext:"",
        Accionws:"",
        cliente:""
      });
    }

    const post_accion=()=>{
      const url=state.Accion==2?path+"Serviciosws/servicio_post/2":path+"Serviciosws/servicio_post/1";
      const data=state;
      if(state.AccionS==="MANUAL"||state.AccionS==="EXCEL"){
        data.conexiontext=null;
        data.url=null;
        data.json=null;
        data.objeto=null;
        data.conexiontext=null;
        data.Accionws=null;
      }else{
        data.conexiontext=ObjectKeyPost();
      }
      //const algo=ObjectKeyPost();
      //console.log("algo",algo);
      //console.log(data);
      axios
      .post(url, {data})
      .then(function(response) {
        console.log(response.data.code);
        if(response.data.code==200){
          toastr.success("Exíto");
          window.jQuery("#modalAseguradora").modal("hide");
          reloadform();
          callBack("algo"); 
        }else{
          toastr.error(response.data.message);
        }
      })
      .catch(error => {console.log("Eror")});
    }
  return (
    <>
    <div
      id="modalAseguradora"
      className="modal"
      tabIndex="-1"
      role="dialog"
      aria-labelledby="myLargeModalLabel"
      aria-hidden="true"
    >
      <div className="modal-dialog modal-lg">
      {/* <button className="btn" onClick={()=>console.log("datatable",state)}>push</button> */}
        <div className="modal-content">
            {state.Accion=="3" && 
               <New Titulo="Nuevo servicio" handleInput={handleInput} state={state} dinamico={dinamico} post_accion={post_accion} onchangeDinamic={onchangeDinamic} ObjectKeyPost={ObjectKeyPost}  />
            }
            {state.Accion=="2" && 
               <New Titulo="Editar servicio" handleInput={handleInput} state={state} dinamico={dinamico} post_accion={post_accion} onchangeDinamic={onchangeDinamic} ObjectKeyPost={ObjectKeyPost} />
            }
        </div>
      </div>
      
    </div>
    </>
  );

};

export default Aseguradora;
