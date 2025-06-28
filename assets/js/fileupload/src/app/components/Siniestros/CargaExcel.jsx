import React, { useState, useEffect } from "react";
import { Formik } from "formik";
import Select from "react-select";
import {colourStyles2,colourStyles,validationExcel,displayitem,mapitems,displayitemC} from "../Siniestros/helper.js";

const path = window.jQuery("#base_url").attr("data-base-url");

const CargaExcel = ({ Titulo,uploadFile }) => {
  return (
    <>
      <div className="modal-header">
        <button type="button" className="close" data-dismiss="modal"><span style={{color:"white"}}>&times;</span></button>
        <h5 className="modal-title">{Titulo}</h5>
      </div>
      <Formik
          initialValues={{
            file:'',
            aseguradora_id:'',
            cliente_id:''
          }}
          validationSchema={validationExcel}
          enableReinitialize="true"
          onSubmit={(values, actions) => {
            uploadFile(values,actions);
              //console.log("values",values);
              //postdatesfilter(values, actions);
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
          <form onSubmit={handleSubmit} className="form" autoComplete="off">
          <div className="modal-body">
            <div className="row">
                <div className="col-sm-6 col-md-6">
                    <div className={errors.aseguradora_id &&touched.aseguradora_id? "form-group has-error" : "form-group"}>
                        <label className="control-label">
                           Aseguradora
                        </label>
                      <Select
                          placeholder="Selecione una opción"
                          id="aseguradora_id"
                          name="aseguradora_id"
                          styles={errors.aseguradora_id &&touched.aseguradora_id? colourStyles2:colourStyles}
                          onChange={v=>{setFieldValue("aseguradora_id", v.value),setFieldValue("cliente_id",'')}}
                          onBlur={handleBlur}
                          value={displayitem(values.aseguradora_id,_Aseg)}
                          options={mapitems(_Aseg)}
                          noOptionsMessage={()=>"Sin opciones"}
                        />
                    </div>
                </div>
                <div className="col-sm-6 col-md-6">
                    <div className={errors.cliente_id &&touched.cliente_id? "form-group has-error" : "form-group"}>
                      <label className="control-label">
                            Cliente
                        </label>
                      <Select
                          placeholder="Selecione una opción"
                          id="cliente_id"
                          name="cliente_id"
                          styles={errors.cliente_id &&touched.cliente_id? colourStyles2:colourStyles}
                          onChange={v=>{setFieldValue("cliente_id", v.value)}}
                          onBlur={handleBlur}
                          value={displayitem(values.cliente_id,_clienteT)}
                          options={displayitemC(values.aseguradora_id,_clienteT)}
                          noOptionsMessage={()=>"Sin opciones"}
                        />
                    </div>
                </div>
                <div className="col-sm-12 col-md-12">
                    <label className="control-label">
                            Archivo
                    </label>
                    <div className={errors.file &&touched.file? "file-upload error" : "file-upload"}>
                        <div className="file-select">
                            <div className="file-select-button" id="fileName">Seleccionar archivo</div>
                            <div className="file-select-name" id="noFile">{values.file!==""?values.file.name:'Archivo no seleccionado...'}</div>
                            <input name="file" type="file" onChange={(event) => {setFieldValue("file", event.currentTarget.files[0]);}} name="chooseFile" id="chooseFile"/>
                        </div>
                    </div>
                </div>
            </div>
          </div>
          <div className="modal-footer">
            <div className="btn btn-secondary" style={{backgroundColor:"#e8e8e8"}} data-dismiss="modal">Cerrar</div>
           {/*  <button onClick={()=>console.log("Valores",values)}>values</button> */}
            <button className="btn btn-primary" type="submit">Guardar</button>
          </div>
          </form>}
        </Formik>
    </>
  );
};

export default CargaExcel;
