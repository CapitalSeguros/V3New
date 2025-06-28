import * as Yup from "yup";
import axios from "axios";

const path = window.jQuery("#base_url").attr("data-base-url");
export const colourStyles = {
    control: styles => ({
      ...styles,
      backgroundColor: "white",
      borderRadius: "0px",
      minHeight: "34px",
      color:'#472380 !important'
    })
  };
  
  export const Tipos=[
    { id:"SINIESTRO",nombre:"SINIESTRO"}
  ]
  
  export const colourStyles2 = {
    control: styles => ({
      ...styles,
      backgroundColor: "white",
      borderRadius: "0px",
      minHeight: "34px",
      borderColor:'#a94442 !important'
    })
  };
  
  export const initial={
    cliente_id:0,
    tipo_id:'',
    sub_tipo_id:'',
    causa_id:'',
    dias:'',
    escalamiento_1:[],
    escalamiento_2:[],
    dias_posteriores_1:'',
    dias_posteriores_2:'',
    notificacion:[]
  }

  export const initialI={
    cliente_id:0,
    tipo_id:'',
    sub_tipo_id:'',
    causa_id:'',
    dias:'',
  }

  export const validationSchemaI = Yup.object({
    cliente_id:Yup.number().
      nullable("Debe de seleccionar un elemento.").
      typeError("Debe de seleccionar un elemento."),
    tipo_id: Yup.number("Ingrese una valor")
      .typeError('Seleccione un tipo')
      .required("Es requerido."),
    sub_tipo_id: Yup.number("Ingrese una valor")
      .typeError('Seleccione un sub-tipo')
      .required("Es requerido."),
    causa_id: Yup.number("Ingrese una valor ")
      .required("Es requerido.")
      .nullable("Seleccione una causa.")
      .typeError('El campo debe ser un número'),
    dias: Yup.number("Ingrese los días.")
      .required("Es requerido.")
      .moreThan(0,"El campo debe ser mayor 0.")
      .typeError('El campo debe ser un número.'),
  });
  
  export const validationSchema = Yup.object({
    cliente_id:Yup.number().
      nullable("Debe de seleccionar un elemento.").
      typeError("Debe de seleccionar un elemento."),
    tipo_id: Yup.number("Ingrese una valor")
      .typeError('Seleccione un tipo')
      .required("Es requerido."),
    sub_tipo_id: Yup.number("Ingrese una valor")
      .typeError('Seleccione un tipo')
      .required("Es requerido."),
    causa_id: Yup.number("Ingrese una valor ")
      .required("Es requerido.")
      .nullable("Seleccione una causa.")
      .typeError('El campo debe ser un número'),
    dias: Yup.number("Ingrese los días.")
      .required("Es requerido.").moreThan(-1,"EL numero debe ser 0 o mayor.")
      .typeError('El campo debe ser un número.'),
    escalamiento_1: Yup.array()
    .of(
      Yup.object().shape({
        value:Yup.string().required()
      })
    )
    .nullable("Seleccione una usuario."),
    escalamiento_2: Yup.array()
    .of(
      Yup.object().shape({
        value:Yup.string().required()
      })
    )
    .nullable("Seleccione una usuario."),
    dias_posteriores_1:Yup.number("Ingrese una valor")
    .typeError('Ingrese los días.').when('escalamiento_1',{
      is:(escalamiento_1)=>escalamiento_1.length>0,
      then:Yup.number().moreThan(-1,"EL numero debe ser 0 o mayor.").required('Ingrese un valor.').typeError('Ingrese un valor.')
    }),
    dias_posteriores_2:Yup.number("Ingrese una valor")
    .typeError('Ingrese los días.').when('escalamiento_2',{
      is:(escalamiento_2)=>escalamiento_2.length>0,
      then:Yup.number().moreThan(-1,"EL numero debe ser 0 o mayor.").required('Ingrese un valor.').typeError('Ingrese un valor.')
    }),
    notificacion: Yup.array().required("Seleccione al menos una casilla"),
  });
  
  export function mapitems(respuesta) {
    const _ps = respuesta.map(i => {
      return { value: i.id, label: i.nombre };
    });
    return _ps;
  }
  export function mapitemsu(respuesta) {
    const _ps = respuesta.map(i => {
      return { value: i.value, label: i.label };
    });
    return _ps;
  }
  
  export function displayitem(id,array){
    const _array=array;
    const newData = _array.filter((item, index) => item.id === id);
    const r=mapitems(newData);
    return r;
  }

  export function _postAlerta(values,actions,Accion,callBack){
    var url=Accion=="3"?"Serviciosws/servicio_postA/1":"Serviciosws/servicio_postA/2";
    var postUrl=path+url;
    var data = new FormData();
    data.append("Accion",Accion==3?"Nuevo":"Editar");
    data.append("Data",JSON.stringify(values)); 
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

  export function _postIndicadores(values,actions,Accion,callBack){
    var url=Accion=="5"?"Serviciosws/servicio_postI/1":"Serviciosws/servicio_postI/2";
    var postUrl=path+url;
    var data = new FormData();
    data.append("Accion",Accion=="5"?"Nuevo":"Editar");
    data.append("Data",JSON.stringify(values)); 
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

export function displayItemsA(cliente,tipo,sub_tipo,_array) {
    const newData = _array.filter((item, index) => item.cliente_id === cliente&&item.tipo_id===tipo &&item.sub_tipo_id===sub_tipo);
    const _ps = newData.map(i => {
      return { value: i.id, label: i.nombre };
    });
    return _ps;
}

export function getDias(id,array){
  const newData = array.filter((item, index) => item.id === id);
  if(newData.length>0){
    return newData[0].dias;
  }else{
    return "No se ha seleccionado una causa.";
  }
}

export function displayitemU(id,array){
  const _array=array;
  const newData = _array.filter((item, index) => item.cliente === id);
  const r=mapitemsu(newData);
  return r;
}

  