import React, { useState, useEffect } from "react";
import { Formik } from "formik";
import { DatePickerField as DatePicker } from "../common";
import Select from "react-select";
import {colourStyles2,colourStyles,validationSchema,displayitem,mapitems,displayitemC} from "../Siniestros/helper.js";

const path = window.jQuery("#base_url").attr("data-base-url");

function submitForm(values, actions) {
    //postdatesfilter(values, actions);
    //console.log("valoresForm", values);
}

const Filterdates = ({ data, Titulo, postdatesfilter }) => {
  return (
    <>
      <div className="modal-header">
        <button type="button" className="close" data-dismiss="modal"><span style={{color:"white"}}>&times;</span></button>
        <h5 className="modal-title">{Titulo}</h5>
      </div>
        <Formik
          initialValues={{
            Fechainicio: moment(Date.now()).format("YYYY-MM-DD"),
            FechaFin: moment(Date.now()).format("YYYY-MM-DD"),
            aseguradora_id:'',
            cliente_id:''
          }}
          validationSchema={validationSchema}
          enableReinitialize="true"
          onSubmit={(values, actions) => {
              postdatesfilter(values, actions);
            /* console.log('actions',actions); */
            //submitForm(values, actions);
            //resetForm();
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
                <div className="col-sm-3 col-md-3">
                    <div className={errors.aseguradora_id && touched.aseguradora_id? "form-group has-error" : "form-group"}>
                        <label className="control-label">
                           Aseguradora
                        </label>
                      <Select
                          placeholder="Selecione una opción"
                          id="aseguradora_id"
                          name="aseguradora_id"
                          styles={errors.aseguradora_id && touched.aseguradora_id? colourStyles2:colourStyles}
                          onChange={v=>{setFieldValue("aseguradora_id", v.value),setFieldValue("cliente_id",'')}}
                          onBlur={handleBlur}
                          value={displayitem(values.aseguradora_id,_Aseg)}
                          options={mapitems(_Aseg)}
                          noOptionsMessage={()=>"Sin opciones"}
                        />
                         <span className="help-block">{errors.aseguradora_id&& touched.aseguradora_id?errors.aseguradora_id:''}</span>
                    </div>
                </div>
                <div className="col-sm-3 col-md-3">
                    <div className={errors.cliente_id && touched.cliente_id? "form-group has-error" : "form-group"}>
                      <label className="control-label">
                            Cliente
                        </label>
                      <Select
                          placeholder="Selecione una opción"
                          id="cliente_id"
                          name="cliente_id"
                          styles={errors.cliente_id && touched.cliente_id? colourStyles2:colourStyles}
                          onChange={v=>{setFieldValue("cliente_id", v.value)}}
                          onBlur={handleBlur}
                          value={displayitem(values.cliente_id,_clienteT)}
                          options={displayitemC(values.aseguradora_id,_clienteT)}
                          noOptionsMessage={()=>"Sin opciones"}
                        />
                         <span className="help-block">{errors.cliente_id&& touched.cliente_id?errors.cliente_id:''}</span>
                    </div>
                </div>
                <div className="col-sm-3 col-md-3">
                    <div className={errors.Fechainicio && touched.Fechainicio? "form-group has-error" : "form-group"}>
                        <label className="control-label">
                            Fecha inicio
                        </label>
                        <DatePicker
                        dateFormat="yyyy-MM-dd"
                        className="form-control filter-input"
                        showPopperArrow={true}
                        name="Fechainicio"
                        id="txFechaInicio"
                        selected={values.Fechainicio}
                        placeholder="Fechainicio"
                        //   disabled={values.fechaInicio != ""}
                        title="Fechainicio"
                        autoComplete="off"
                      />
                        <span className="help-block">{errors.Fechainicio}</span>
                    </div>
                </div>
                <div className="col-sm-3 col-md-3">
                    <div className={errors.FechaFin && touched.Fechainicio? "form-group has-error" : "form-group"}>
                        <label className="control-label">
                            Fecha fin
                        </label>
                        <DatePicker
                        dateFormat="yyyy-MM-dd"
                        className="form-control filter-input"
                        showPopperArrow={true}
                        name="FechaFin"
                        id="txFechaFin"
                        selected={values.FechaFin}
                        placeholder="FechaFin"
                        //   disabled={values.fechaInicio != ""}
                        title="FechaFin"
                        autoComplete="off"
                      />
                        <span className="help-block">{errors.FechaFin}</span>
                    </div>
                </div>
               {/*  <div style={{float:'right',paddingRight:15}}>
                 <button  className="btn btn-primary btn-filter" type="submit">Consultar</button>
                </div> */}
            </div>
          </div>
          <div className="modal-footer">
            <div className="btn btn-secondary" style={{backgroundColor:"#e8e8e8"}} data-dismiss="modal">Cerrar</div>
            <button className="btn btn-primary" type="submit">Consultar</button>
          </div>
          </form>}
        </Formik>
     
    </>
  );
};

export default Filterdates;
