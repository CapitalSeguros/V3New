import React, { useState, useEffect } from "react";

const path = window.jQuery("#base_url").attr("data-base-url");

function submitForm(values, actions) {
    console.log("valoresForm", values);
  }

const NewAseguradora = ({Titulo,handleInput,state,dinamico,post_accion,onchangeDinamic,ObjectKeyPost}) => {
  return (
    <>
      <div className="modal-header">
        <button type="button" className="close" data-dismiss="modal"><span style={{color:"white"}}>&times;</span></button>
        <h5 className="modal-title">{Titulo}</h5>
      </div>
      <div className="modal-body">
        <div className="row">
            <div className="col-md-4">
                <div className="form-group">
                    <label className="control-label">
                        Aseguradora
                    </label>
                    <select className="form-control" name="Aseguradora" id="Aseguradora" onChange={e => handleInput(e)} value={0||state.Aseguradora}>
                        <option value="0" defaultValue>Seleccione uno</option>
                        {_aseguradoras&&_aseguradoras.map((item,key)=>(
                            <option key={key} value={item.id}>{item.Promotoria}</option>
                        ))}
                    </select>
                </div>
            </div>
            <div className="col-md-4">
                <div className="form-group">
                    <label className="control-label">
                       Cliente
                    </label>
                    <select className="form-control" name="cliente" id="cliente" onChange={e => handleInput(e)} value={0||state.cliente}>
                    <option value="0" defaultValue>Seleccione uno</option>
                    {_cliente&&_cliente.map((item,key)=>(
                            <option key={key} value={item.id}>{item.nombre}</option>
                        ))}
                    </select>
                </div>
            </div>
            <div className="col-md-4">
                <div className="form-group">
                    <label className="control-label">
                        Acciòn del servicio
                    </label>
                    <select className="form-control" name="AccionS" id="AccionS" onChange={e => handleInput(e)} value={0||state.AccionS}>
                        <option value="0" defaultValue>Seleccione uno</option>
                        <option value="SERVICIO">Servicio web</option>
                        <option value="EXCEL">Carga Excel</option>
                        <option value="MANUAL">Manual</option>
                    </select>
                </div>
            </div>
        </div>
        {state.AccionS=="SERVICIO"&&(
        <div className="row">
            <div className="col-md-4">
                <div className="form-group">
                    <label className="control-label">
                       Tipo de metodo
                    </label>
                    <select className="form-control" name="Accionws" id="Accionws" onChange={e => handleInput(e)} value={0||state.Accionws||0}>
                        <option value="0" defaultValue>Seleccione uno</option>
                        <option value="RANGO">Consulta por rango</option>
                        <option value="INDIVIDUAL">Consulta individual</option>
                    </select>
                </div>
            </div>
            <div className="col-md-8">
                <div className="form-group">
                    <label className="control-label">
                       URL del método
                    </label>
                    <input type="text" name="url" className="form-control" onChange={e => handleInput(e)} value={state.url||''}/>
                </div>
            </div>
        </div>
        )}
        {state.AccionS=="SERVICIO"&&(
        <div className="row">
            <div className="col-md-6">
                    <div className="form-group">
                        <label className="control-label">
                            Objeto de conexiòn
                        </label>
                        <textarea name="conexion" id="conexion" cols="30" rows="10" className="form-control" value={''||state.objeto} onChange={e => handleInput(e)}></textarea>
                    </div>
            </div>
            <div className="col-md-6">
                <div className="row">
                    <div className="col-xs-6"><label>Campos de conexion</label></div>
                    <div className="col-xs-6"><label>Dinámico</label></div>
                </div>
                   <div className="scroll-elements">
                   {state.json && state.json.map((element,key)=>(
                        <div key={key} className="row">
                            <div className="col-xs-6">
                                <label className="control-label">{element.elemento}</label>
                                <input disabled={element.dinamico} type="text" className="form-control" onChange={(e)=>onchangeDinamic(key,e)} value={element.value||''}/>
                            </div>
                            <div className="col-xs-6">
                                <div style={{paddingTop:25}}><input type="checkbox" checked={element.dinamico} onChange={()=>dinamico(key)}/></div>
                            </div>
                        </div>
                    ))}
                   </div>
            </div>
        </div>
        )}
        <div id="logs"></div>
      </div>
      <div className="modal-footer">
        <div className="btn btn-secondary" style={{backgroundColor:"#e8e8e8"}} data-dismiss="modal">Cerrar</div>
        <button disabled={
                    state.AccionS!=="SERVICIO"?state.Aseguradora==="0"||state.AccionS==="0"||state.cliente==="0":state.url===""||state.Accionws===""||state.objeto===""||state.cliente===""}
                     style={{float:"right"}} className="btn btn-primary" onClick={()=>post_accion()}>Guardar</button>
      </div>
    </>
  );
};

export default NewAseguradora;
