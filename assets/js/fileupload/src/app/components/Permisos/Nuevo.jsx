import React, { useState, useEffect } from "react";
import * as Yup from "yup";
import { Formik } from "formik";
import Select from "react-select";
import axios from "axios";
import {stylesSelect} from "../common/stylesSelect.js";

const path = window.jQuery("#base_url").attr("data-base-url");
const validationSchema = Yup.object({
    url:Yup.number("Ingrese un valor ")
    .required("Es requerido.")
    .typeError('El campo debe ser un número'),
    puesto:Yup.number("Ingrese un valor ")
    .required("Es requerido.")
    .typeError('El campo debe ser un número'),
});

function submitForm(values, actions) {
    console.log("valoresForm", values);
}
function displayitem(id,array){
    const _array=array;
    const newData = _array.filter((item, index) =>item.value === id);
    return newData;
  }

const Nuevo = ({ data, Titulo,callbackSuccess }) => {
  return (
    <>
      <div className="modal-header">
        <button type="button" className="close" data-dismiss="modal"><span style={{color:"white"}}>&times;</span></button>
        <h5 className="modal-title">{Titulo}</h5>
      </div>
      <Formik
          initialValues={{
            url: null,
            puesto: null,
          }}
          validationSchema={validationSchema}
          enableReinitialize="true"
          onSubmit={(values, actions) => {
            var postUrl=path+"Permisos/Acciones/1";
            var data = new FormData();
            data.append("Data",JSON.stringify(values)); 
            axios
            .post(postUrl, data)
            .then(function(response) {
                if(response.data.code!=200||response.data.code!="200"){
                    toastr.error(response.data.message);
                  }else{
                    toastr.success("Exíto");
                    window.jQuery("#modalPermisos").modal("hide");
                    actions.resetForm();
                    callbackSuccess();
                  }
            })
            .catch(error => {console.log(error)});
            //callBack();
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
                <div className="col-sm-3 col-md-6">
                    <div className={errors.url &&touched.url? "form-group has-error" : "form-group"}>
                        <label className="control-label">
                           URL
                        </label>
                      <Select
                          placeholder="Selecione una opción"
                          id="aseguradora_id"
                          name="aseguradora_id"
                          styles={errors.url &&touched.url? stylesSelect(650,2):stylesSelect(650,1)}
                          onChange={v=>{setFieldValue("url", v.value)}}
                          onBlur={handleBlur}
                          value={displayitem(values.url,_url)}
                          options={_url}
                          noOptionsMessage={()=>"Sin opciones"}
                        />
                    </div>
                </div>
                <div className="col-sm-3 col-md-6">
                    <div className={errors.puesto &&touched.puesto? "form-group has-error" : "form-group"}>
                        <label className="control-label">
                           Puesto
                        </label>
                      <Select
                          placeholder="Selecione una opción"
                          id="puesto"
                          name="puesto"
                          styles={errors.puesto &&touched.puesto? stylesSelect(380,2,"puesto"):stylesSelect(380,1,"puesto")}
                          //onChange={v=>{console.log(v)}}
                          onChange={v=>{setFieldValue("puesto", v.value),setFieldValue("item", v)}}
                          onBlur={handleBlur}
                          value={values.item||''}
                          options={_puestos}
                          noOptionsMessage={()=>"Sin opciones"}
                        />
                    </div>
                </div>

            </div>
          </div>
          <div className="modal-footer">
            <div className="btn btn-secondary" style={{backgroundColor:"#e8e8e8"}} data-dismiss="modal">Cerrar</div>
            <button className="btn btn-primary" type="submit">Guardar</button>
          </div>
          </form>}
        </Formik>
    </>
  );
};

export default Nuevo;
