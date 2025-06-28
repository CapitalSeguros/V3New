import React, { useState, useEffect } from "react";
import * as Yup from "yup";
import { Formik } from "formik";
import Select from "react-select";
import {stylesSelect} from "../common/stylesSelect.js";


const initial={
  usuario_id:'',
  cliente_id:'',
  tipo:'',
  id:'',
  PuestoF:''
}

const validationSchema = Yup.object({
  usuario_id:Yup.number("Ingrese un valor ")
  .required("Es requerido.")
  .typeError('El campo debe ser un número'),
  cliente_id:Yup.number("Ingrese un valor ")
  .required("Es requerido.")
  .typeError('El campo debe ser un número'),
  tipo:Yup.number("Ingrese un valor ")
  .required("Es requerido.")
  .typeError('El campo debe ser un número'),

});

/* const filterOption = ({ label, value }, string) => {
  // default search
  if (label.includes(string) || value.includes(string)) return true;

  // check if a group as the filter string as label
  const groupOptions = _puestos.filter(group =>
    group.label.toLocaleLowerCase().includes(string)
  );

  if (groupOptions) {
    for (const groupOption of groupOptions) {
      // Check if current option is in group
      const option = groupOption.options.find(opt => opt.value === value);
      if (option) {
        return true;
      }
    }
  }
  return false;
}; */


function mapitems(respuesta) {
  const _ps = respuesta.map(i => {
    return { value: i.id, label: i.nombre };
  });
  return _ps;
}
function displayitem(id,array){
  const _array=array;
  const newData = _array.filter((item, index) => item.id === id);
  const r=mapitems(newData);
  return r;
}
function displayitemPuesto(id,array){
  const _array=array;
  const newData = _array.filter((item, index) => item.puesto === id);
  return newData;
}

function displayitemU(id,array){
  const _array=array;
  const newData = _array.filter((item, index) => item.value === id);
  return newData;
}



const Modal_cliente = ({ Titulo,post ,data,Accion}) => {
  return (
    <>
      <div className="modal-header">
        <button type="button" /* style={{textTransform:'hidden'}} */ className="close" data-dismiss="modal"><span style={{color:"white"}}>&times;</span></button>
        <h5 className="modal-title">{Titulo}</h5>
      </div>
        <Formik
            initialValues={Accion=="2"?data:initial}
            validationSchema={validationSchema}
            enableReinitialize="true"
            onSubmit={(values, actions) => {
              post(values,actions);
              //console.log("values",values);
            }}
          >
            {({
              values,
              errors,
              status,
              setFieldValue,
              handleBlur,
              handleChange,
              handleSubmit,
              resetForm,
              touched
            }) => 
            <form onSubmit={handleSubmit} autoComplete="off">
                <div className="modal-body">
                    <div className="row">
                        <div className="col-md-4">
                          <div className={errors.cliente_id && touched.cliente_id? "form-group has-error" : "form-group"}>
                              <label className="control-label">
                                  Cliente
                              </label>
                              <Select
                                placeholder="Selecione una opción"
                                isDisabled={Accion=="2"}
                                id="cliente_id"
                                name="cliente_id"
                                styles={errors.cliente_id && touched.cliente_id? stylesSelect(250,2):stylesSelect(250,1)}
                                onChange={v=>{setFieldValue("cliente_id", v.value)}}
                                onBlur={handleBlur}
                                value={displayitem(values.cliente_id,_cliente)}
                                options={mapitems(_cliente)}
                                noOptionsMessage={()=>"Sin opciones"}
                              />
                          <span className="help-block">{errors.cliente_id&& touched.cliente_id?errors.cliente_id:''}</span>
                          </div>
                        </div>
                        {Accion!="2"&& 
                        <div className="col-md-4">
                          <div className={errors.Puesto && touched.Puesto? "form-group has-error" : "form-group"}>
                              <label className="control-label">
                                  Puesto
                              </label>
                              <Select
                                placeholder="Selecione una opción"
                                //filterOption={filterOption}
                                isDisabled={Accion=="2"}
                                id="usuario_id"
                                name="usuario_id"
                                styles={errors.Puesto && touched.Puesto? stylesSelect(250,2,'puesto'):stylesSelect(250,1,'puesto')}
                                onChange={v=>{setFieldValue("Puesto", v.value),setFieldValue("PuestoF", v),setFieldValue("usuario_id",'')}}
                                onBlur={handleBlur}
                                value={values.PuestoF||''}
                                options={_puestos}
                                noOptionsMessage={()=>"Sin opciones"}
                              />
                            <span className="help-block">{errors.Puesto&& touched.Puesto?errors.Puesto:''}</span>
                          </div>
                        </div>}
                        <div className="col-md-4">
                          <div className={errors.usuario_id && touched.usuario_id? "form-group has-error" : "form-group"}>
                              <label className="control-label">
                                  Ejecutivo/Usuario
                              </label>
                              <Select
                                placeholder="Selecione una opción"
                                isDisabled={Accion=="2"}
                                id="usuario_id"
                                name="usuario_id"
                                styles={errors.usuario_id && touched.usuario_id? stylesSelect(250,2):stylesSelect(250,1)}
                                onChange={v=>{setFieldValue("usuario_id", v.value)}}
                                onBlur={handleBlur}
                                value={displayitemU(values.usuario_id,_usuarios)}
                                options={displayitemPuesto(values.Puesto,_usuarios)}
                                noOptionsMessage={()=>"Sin opciones"}
                              />
                            <span className="help-block">{errors.usuario_id&& touched.usuario_id?errors.usuario_id:''}</span>
                          </div>
                        </div>
                        <div className="col-md-4">
                          <div className={errors.tipo && touched.tipo? "form-group has-error" : "form-group"}>
                              <label className="control-label">
                                  Tipo
                              </label>
                              <Select
                                placeholder="Selecione una opción"
                                id="tipo"
                                name="tipo"
                                styles={errors.tipo && touched.tipo? stylesSelect(250,2):stylesSelect(250,1)}
                                onChange={v=>{setFieldValue("tipo", v.value)}}
                                onBlur={handleBlur}
                                value={displayitem(values.tipo,_Tipos)}
                                options={mapitems(_Tipos)}
                                noOptionsMessage={()=>"Sin opciones"}
                              />
                            <span className="help-block">{errors.tipo&& touched.tipo?errors.tipo:''}</span>
                          </div>
                        </div>
                    </div>
                </div>
                <div className="modal-footer">
                    {/* <div className="btn" onClick={()=>console.log(values)}>check</div> */}
                    <div className="btn btn-secondary" style={{backgroundColor:"#e8e8e8"}} data-dismiss="modal">Cerrar</div>
                    <button type="submit" className="btn btn-primary">Guardar</button>
                </div> 
            </form>}
        </Formik>
    </>
  );
};

export default Modal_cliente;
