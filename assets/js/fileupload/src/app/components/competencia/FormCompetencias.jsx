import React, { useState } from "react";
import PropTypes from "prop-types";
import Select from "react-select";
import * as Yup from "yup";
import { Formik } from "formik";
import {stylesSelect} from "../common/stylesSelect.js";

function FormCompetencias(props) {
    const [state,setState]=useState(props.form);


      const validationSchema = Yup.object({
        titulo: Yup.string().required("El titulo es requerido."),
        descripcion: Yup.string().required("La descripción es requerida")
      });
      const submitForm=(values)=>{
        //console.log(values)
        props.submit(values);
      }

    return (
        <Formik
        initialValues={props.form}
        validationSchema={validationSchema}
        enableReinitialize="true"
        onSubmit={(values,actions)=>{
            submitForm(values);
            //console.log(values);
        }}>
            {({
        values,
        errors,
        status,
        setFieldValue,
        handleBlur,
        handleChange,
        handleSubmit,
        isSubmitting
      }) => (
        <form onSubmit={handleSubmit} className="form" autoComplete="off">
            <div className="row">
                <div className="col-md-6">
                    <div className={errors.titulo ? "form-group has-error" : "form-group"}>
                        <label className="control-label">Nombre</label>
                        <input  type="text" className="form-control" id="titulo" name="titulo" value={values.titulo} onChange={handleChange}/>
                        <span className="help-block">{errors.titulo}</span>
                    </div>
                </div>
                <div className="col-md-6">
                    <div className="form-group">
                        <label className="control-label">Seleccione un puesto </label>
                        <Select
                          placeholder="Selecione una opción"
                          id="Puesto"
                          name="Puesto"
                          styles={stylesSelect(320,1,"Puesto")}
                          onChange={v=>{setFieldValue("Puesto", v)}}
                          onBlur={handleBlur}
                          value={values.Puesto}
                          options={props.puestos}
                        />
                    </div>
                </div>
            </div>
            <div className="row">
                <div className="col-md-12">
                    <div className={errors.descripcion ? "form-group has-error" : "form-group"}>
                        <label className="control-label">Descripción</label>
                        {/* <input type="text" className="form-control" value={values.descripcion} id="descripcion" name="descripcion" onChange={handleChange} /> */}
                        <textarea name="descripcion" id="descripcion" defaultValue={values.descripcion}  onChange={handleChange}  className="form-control" maxLength={252}></textarea>
                        <label className="control-label">Caracteres ingresados:{values.descripcion.length} de 252</label>
                        <span className="help-block">{errors.descripcion}</span>
                    </div>
                </div>
            </div>
                <button
                type="submit"
                    disabled={
                    !props.Competencia.length
                    }
                    className="btn btn-primary pull-right"
                >
                    <i className="fa fa-floppy-o" aria-hidden="true"></i> Guardar
                </button>
        </form>
      )}

        </Formik>
    );
  }
  FormCompetencias.propTypes = {
    //children: PropTypes.element.isRequired,
  };
  
  export default FormCompetencias;