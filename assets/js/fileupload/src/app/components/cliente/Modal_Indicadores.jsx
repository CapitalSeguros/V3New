import React, { useState, useEffect } from "react";
import { Formik } from "formik";
import Select from "react-select";
import {colourStyles,colourStyles2,initialI,validationSchemaI,mapitems,displayitem,_postIndicadores, initial}from "../cliente/functions.js";

const Modal_Indicadores = ({Titulo,Accion,callBack, data}) => {
  /*   const Tipos=[
        {id:"1",nombre:"EMISIÓN"},
        {id:"2",nombre:"SINIESTRO"}
    ];
    const Sub_Tipos=[
        {id:"1",nombre:"DAÑOS"},
        {id:"2",nombre:"AUTOS"},
        {id:"3",nombre:"GASTOS MÉDICOS"}
    ]; */
  return (
    <>
      <div className="modal-header">
        <button type="button" className="close" data-dismiss="modal"><span style={{color:"white"}}>&times;</span></button>
        <h5 className="modal-title">{Titulo}</h5>
      </div>
        <Formik
            initialValues={Accion=="5"?initialI:data}
            validationSchema={validationSchemaI}
            enableReinitialize="true"
            onSubmit={(values, actions) => {
                _postIndicadores(values,actions,Accion,callBack);

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
              touched,
              resetForm
            }) => 
            <form onSubmit={handleSubmit} autoComplete="off">
                <div className="modal-body">
                  <div className="row">
                      <div className="col-md-4">
                          <div className={errors.cliente_id && touched.cliente_id ? "form-group has-error" : "form-group"}>
                              <label className="control-label">
                                  Cliente
                              </label>
                              <Select
                                placeholder="Selecione una opción"
                                id="cliente_id"
                                name="cliente_id"
                                isDisabled={Accion=="6"}
                                styles={errors.cliente_id && touched.cliente_id ? colourStyles2:colourStyles}
                                onChange={v=>{setFieldValue("cliente_id", v!==null?v.value:'')}}
                                onBlur={handleBlur}
                                isClearable={true}
                                value={displayitem(values.cliente_id,_cliente)}
                                options={mapitems(_cliente)}
                                noOptionsMessage={()=>"Sin opciones"}
                              />
                          <span className="help-block">{errors._cliente&& touched._cliente?errors._cliente:''}</span>
                          </div>
                      </div>
                      <div className="col-md-4">
                          <div className={errors.tipo_id && touched.tipo_id ? "form-group has-error" : "form-group"}>
                              <label className="control-label">
                                 Tipo
                              </label>
                              <Select
                                placeholder="Selecione una opción"
                                id="tipo_id"
                                name="tipo_id"
                                isDisabled={Accion=="6"}
                                styles={errors.tipo_id && touched.tipo_id ? colourStyles2:colourStyles}
                                onChange={v=>{setFieldValue("tipo_id", v.value),setFieldValue("sub_tipo_id",''),setFieldValue("causa_id",'')}}
                                onBlur={handleBlur}
                                value={displayitem(values.tipo_id,_Tipos)}
                                options={mapitems(_Tipos)}
                                noOptionsMessage={()=>"Sin opciones"}
                              />
                          <span className="help-block">{errors.tipo_id&& touched.tipo_id?errors.tipo_id:''}</span>
                          </div>
                      </div>
                      <div className="col-md-4">
                          <div className={errors.sub_tipo_id && touched.sub_tipo_id ? "form-group has-error" : "form-group"}>
                              <label className="control-label">
                                  Sub-Tipo
                              </label>
                              <Select
                                placeholder="Selecione una opción"
                                id="causa"
                                name="causa"
                                isDisabled={Accion=="6"}
                                styles={errors.sub_tipo_id && touched.sub_tipo_id ? colourStyles2:colourStyles}
                                onChange={v=>{setFieldValue("sub_tipo_id", v.value),setFieldValue("causa_id",'')}}
                                noOptionsMessage={()=>"Sin opciones"}
                                onBlur={handleBlur}
                                value={displayitem(values.sub_tipo_id,_SubtIpos)}
                                options={mapitems(values.tipo_id=='2'?_SubtIpos:[])}
                              />
                          <span className="help-block">{errors.sub_tipo_id&& touched.sub_tipo_id?errors.sub_tipo_id:''}</span>
                          </div>
                        </div>
                  </div>
                    <div className="row">
                      <div className="col-md-4">
                        <div className={errors.causa_id && touched.causa_id  ? "form-group has-error" : "form-group"}>
                              <label className="control-label">
                                  Causa
                              </label>
                              <Select
                                placeholder="Selecione una opción"
                                id="causa_id"
                                name="causa_id"
                                isDisabled={Accion=="6"}
                                styles={errors.causa_id && touched.causa_id ? colourStyles2:colourStyles}
                                onChange={v=>{setFieldValue("causa_id", v.value)}}
                                onBlur={handleBlur}
                                value={displayitem(values.causa_id,_causas)}
                                options={mapitems(values.sub_tipo_id=="2"?_causas:[])}
                                noOptionsMessage={()=>"Sin opciones"}
                              />
                          <span className="help-block">{errors.causa_id&& touched.causa_id?errors.causa_id:''}</span>
                          </div>
                      </div>
                      <div className="col-md-4">
                          <div className={errors.dias && touched.dias ? "form-group has-error" : "form-group"}>
                              <label className="control-label">
                                  Dias
                              </label>
                              <input type="text" className="form-control" name="dias" id="dias" onChange={handleChange} value={values.dias||''}/>
                            <span className="help-block">{errors.dias && touched.dias?errors.dias:''}</span>
                          </div>
                      </div>
                    </div>
                </div>
                <div className="modal-footer">
                    <div className="btn btn-secondary" style={{backgroundColor:"#e8e8e8"}} data-dismiss="modal">Cerrar</div>
                    <button type="submit" className="btn btn-primary">Guardar</button>
                </div> 
            </form>}
        </Formik>
    </>
  );
};

export default Modal_Indicadores;
