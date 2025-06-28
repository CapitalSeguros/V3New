import React, { useState, useEffect } from "react";
import { Formik } from "formik";
import Select from "react-select";
import {colourStyles,colourStyles2,displayItemsA,initial,validationSchema,mapitems,displayitem,_postAlerta,getDias,displayitemU}from "../cliente/functions.js";

const Modal_notificacion = ({Titulo,Accion,callBack, data}) => {
  return (
    <>
      <div className="modal-header">
        <button type="button" className="close" data-dismiss="modal"><span style={{color:"white"}}>&times;</span></button>
        <h5 className="modal-title">{Titulo}</h5>
      </div>
        <Formik
            initialValues={Accion=="4"?data:initial}
            validationSchema={validationSchema}
            enableReinitialize="true"
            onSubmit={(values, actions) => {
              _postAlerta(values,actions,Accion,callBack);
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
              touched,
              resetForm
            }) => 
            <form onSubmit={handleSubmit} autoComplete="off">
                <div className="modal-body">
                  <div className="row">
                      <div className="col-md-4">
                          <div className={errors.cliente_id &&touched.cliente_id ? "form-group has-error" : "form-group"}>
                              <label className="control-label">
                                  Cliente
                              </label>
                              <Select
                                placeholder="Selecione una opción"
                                isDisabled={Accion=="4"}
                                id="cliente_id"
                                name="cliente_id"
                                styles={errors.cliente_id &&touched.cliente_id? colourStyles2:colourStyles}
                                onChange={v=>{setFieldValue("cliente_id", v!==null?v.value:''),setFieldValue("causa_id",''),setFieldValue("escalamiento_1",[]),setFieldValue("escalamiento_2",[])}}
                                isClearable={true}
                                onBlur={handleBlur}
                                value={displayitem(values.cliente_id,_cliente)}
                                options={mapitems(_cliente)}
                              />
                          <span className="help-block">{errors.cliente_id &&touched.cliente_id ?errors.cliente_id:''}</span>
                          </div>
                      </div>
                      <div className="col-md-4">
                          <div className={errors.tipo_id &&touched.tipo_id? "form-group has-error" : "form-group"}>
                              <label className="control-label">
                                  Tipo
                              </label>
                              <Select
                                placeholder="Selecione una opción"
                                isDisabled={Accion=="4"}
                                id="tipo_id"
                                name="tipo_id"
                                styles={errors.tipo_id&&touched.tipo_id ? colourStyles2:colourStyles}
                                onChange={v=>{setFieldValue("tipo_id", v.value),setFieldValue("sub_tipo_id",''),setFieldValue("causa_id",'')}}
                                onBlur={handleBlur}
                                value={displayitem(values.tipo_id,_Tipos)}
                                options={mapitems(_Tipos)}
                                noOptionsMessage={()=>"Sin opciones"}
                              />
                          <span className="help-block">{errors.tipo_id&&touched.tipo_id?errors.tipo_id:''}</span>
                          </div>
                      </div>
                      <div className="col-md-4">
                          <div className={errors.sub_tipo_id &&touched.sub_tipo_id? "form-group has-error" : "form-group"}>
                              <label className="control-label">
                                  Sub-tipo
                              </label>
                              <Select
                                placeholder="Selecione una opción"
                                isDisabled={Accion=="4"}
                                id="sub_tipo"
                                name="sub_tipo"
                                styles={errors.sub_tipo_id&&touched.sub_tipo_id ? colourStyles2:colourStyles}
                                onChange={v=>{setFieldValue("sub_tipo_id", v.value),setFieldValue("causa_id",'')}}
                                onBlur={handleBlur}
                                value={displayitem(values.sub_tipo_id,_SubtIpos)}
                                options={mapitems(_SubtIpos)}
                                noOptionsMessage={()=>"Sin opciones"}
                              />
                          <span className="help-block">{errors.sub_tipo_id&&touched.sub_tipo_id?errors.sub_tipo_id:''}</span>
                          </div>
                        </div>
                  </div>
                  <div className="row">
                    <div className="col-md-4">
                          <div className={errors.causa_id &&touched.causa_id? "form-group has-error" : "form-group"}>
                              <label className="control-label">
                                  Indicador
                              </label>
                              <Select
                                placeholder="Selecione una opción"
                                isDisabled={Accion=="4"}
                                id="causa_id"
                                name="causa_id"
                                styles={errors.causa_id &&touched.causa_id? colourStyles2:colourStyles}
                                onChange={v=>{setFieldValue("causa_id", v.value)}}
                                onBlur={handleBlur}
                                value={displayitem(values.causa_id,_Causa)}
                                options={displayItemsA(values.cliente_id,values.tipo_id,values.sub_tipo_id,_Causa)}
                                noOptionsMessage={()=>"Sin opciones"}
                              />
                          <span className="help-block">{errors.causa_id&&touched.causa_id?errors.causa_id:''}</span>
                          </div>
                        </div>
                        <div className="col-md-4">
                          <div className="form-group">
                              <label className="control-label">
                                  Dias de atención
                              </label>
                              <p style={{paddingTop:"10px"}}>{getDias(values.causa_id,_Causa)}</p>
                          </div>
                        </div>
                        <div className="col-md-4">
                          <div className={errors.dias &&touched.dias? "form-group has-error" : "form-group"}>
                              <label className="control-label">
                                  Dias previos
                              </label>
                              <input type="text" className="form-control" name="dias" id="dias" onChange={handleChange} value={values.dias||''}/>
                            <span className="help-block">{errors.dias&&touched.dias?errors.dias:''}</span>
                          </div>
                      </div>
                  </div>
                    <div className="row">
                      <div className="col-md-8">
                          <div className={errors.escalamiento_1 &&touched.escalamiento_1? "form-group has-error" : "form-group"}>
                              <label className="control-label">
                                  Escalamiento 1 :
                              </label>
                              <Select
                                isDisabled={values.cliente_id===''}
                                placeholder="Selecione los usuarios"
                                id="escalamiento_1"
                                name="escalamiento_1"
                                isMulti={true}
                                styles={errors.escalamiento_1&&touched.escalamiento_1 ? colourStyles2:colourStyles}
                                onChange={v=>{setFieldValue("escalamiento_1", v)}}
                                onBlur={handleBlur}
                                value={values.escalamiento_1}
                                options={displayitemU(values.cliente_id,_usuarios)}
                                noOptionsMessage={()=>"Sin opciones"}
                              />
                          <span className="help-block">{errors.escalamiento_1&&touched.escalamiento_1?errors.escalamiento_1:''}</span>
                          </div>
                      </div>
                      <div className="col-md-4">
                          <div className={errors.dias_posteriores_1 &&touched.dias_posteriores_1? "form-group has-error" : "form-group"}>
                              <label className="control-label">
                                  Dias posteriores
                              </label>
                              <input type="text" disabled={values.escalamiento_1.length===0} className="form-control" name="dias_posteriores_1" id="dias_posteriores_1" onChange={handleChange} value={values.dias_posteriores_1||''}/>
                            <span className="help-block">{errors.dias_posteriores_1&&touched.dias_posteriores_1?errors.dias_posteriores_1:''}</span>
                          </div>
                      </div>
                      <div className="col-md-8">
                          <div className={errors.escalamiento_2 &&touched.escalamiento_2? "form-group has-error" : "form-group"}>
                              <label className="control-label">
                                  Escalamiento 2 :
                              </label>
                              <Select
                                isDisabled={values.cliente_id===''}
                                placeholder="Selecione los usuarios"
                                id="escalamiento_2"
                                name="escalamiento_2"
                                isMulti={true}
                                styles={errors.escalamiento_2 &&touched.escalamiento_2? colourStyles2:colourStyles}
                                onChange={v=>{setFieldValue("escalamiento_2", v)}}
                                onBlur={handleBlur}
                                value={values.escalamiento_2}
                                options={displayitemU(values.cliente_id,_usuarios)}
                                noOptionsMessage={()=>"Sin opciones"}
                              />
                          <span className="help-block">{errors.escalamiento_2&&touched.escalamiento_2?errors.escalamiento_2:''}</span>
                          </div>
                      </div>
                      <div className="col-md-4">
                          <div className={errors.dias_posteriores_2 &&touched.dias_posteriores_2? "form-group has-error" : "form-group"}>
                              <label className="control-label">
                                  Dias posteriores
                              </label>
                              <input type="text" disabled={values.escalamiento_2.length===0} className="form-control" name="dias_posteriores_2" id="dias_posteriores_2" onChange={handleChange} value={values.dias_posteriores_2||''}/>
                            <span className="help-block">{errors.dias_posteriores_2&&touched.dias_posteriores_2?errors.dias_posteriores_2:''}</span>
                          </div>
                      </div>
                    </div>
                    <div className="row">
                      <div className="col-md-4">
                            <div className={errors.notificacion &&touched.notificacion? "form-group has-error" : "form-group"}>
                            <label className="control-label">
                                Tipo de notificación
                            </label>
                            <div className="checkbox">
                              <label className="control-label"><input checked={values.notificacion.includes('email')} name="notificacion" type="checkbox" onChange={handleChange} value="email"/>Correo</label>
                            </div>
                            <div className="checkbox">
                              <label className="control-label"><input checked={values.notificacion.includes('web')} name="notificacion" type="checkbox" onChange={handleChange} value="web"/>Plataforma</label>
                            </div>
                            <span className="help-block">{errors.notificacion&&touched.notificacion?errors.notificacion:''}</span>
                            </div>
                        </div>
                    </div>
                </div>
                <div className="modal-footer">
                    <div className="btn btn-secondary" style={{backgroundColor:"#e8e8e8"}} data-dismiss="modal">Cerrar</div>
                    {/* <div className="btn" onClick={()=>console.log(values)}>values</div> */}
                    <button type="submit" className="btn btn-primary">Guardar</button>
                </div> 
            </form>}
        </Formik>
    </>
  );
};

export default Modal_notificacion;
