import React, { useState, useEffect } from "react";
import {colourStyles,displayitem,mapitems} from "../Siniestros/helper.js";
import Select from "react-select";
import axios from "axios";
import Seguimiento from "../common/Modal.jsx";
const path = window.jQuery("#base_url").attr("data-base-url");

function formatDate(date) {
  var current_datetime=new Date(date);
  var d = current_datetime.getDate();
  if(date!=null && !isNaN(d)){
    return moment(date).format("DD-MM-YYYY HH:mm");
  }else{
    return "Sin asignación";
  }
}
function validate(info){
  return info==null||info==""?"Sin asignación":info;
}
const Siniestros = ({ data, Titulo,bitacora, click_botacora,actualizar }) => {
const [state,setState]=useState({
  data:[],
  comentario:'',
  Acccion:''
});
const handleChange = (evt) => {
  const { name, value } = evt.target;
  setState({
    ...state,
    [name]:value
  });
}

const postEvent=()=>{
  var postUrl=path+"Siniestros/seguimiento/1";
  var datas = new FormData();
  datas.append("id",data.id);
  datas.append("comentario",state.comentario);
  axios
  .post(postUrl, datas)
  .then(function(response) {
    if(response.data.code!=200||response.data.code!="200"){
      toastr.error(response.data.message);
      
      document.getElementById("comentario").value='';
    }else{
      setState({
        ...state,
        comentario:''
      });
      toastr.success("Exíto");
    }
  })
  .catch(error => {alert('ERROR')});

}

const seguimientio=()=>{
  $.ajax({
    url: `${path}Siniestros/seguimiento/2`,
    data: {id:data.id},
    method: 'POST',
    dateType: 'json',
    success: function(response) {
      setState({
        ...state,
        Acccion:1,
        data:response.data
      });
        //window.modalModalSeguimiento.show("Seguimiento de Siniestro", response.data)
    }
  });
}

  return (
    <>
      <div className="modal-header">
        <button type="button" className="close" data-dismiss="modal"><span style={{color:"white"}}>&times;</span></button>
        <h5 className="modal-title">{Titulo}</h5>
      </div>
      <div className="modal-body">
        <dl className="row">
          <div className="col-md-8">
            <strong>
              <span className="fa fa-info-circle" aria-hidden="true"></span>
              INFORMACIÓN DEL REGISTRO SELECCIONADO
            </strong>
          </div>
          <div className="col-md-4 text-right">
            {bitacora.index !== null && (
              <strong>
                Fecha: {formatDate(bitacora.data[bitacora.index].modificado)}
              </strong>
            )}
          </div>
        </dl>
        <dl className="row" style={{ fontSize: 12 }}>
          <dt className="col-sm-2 text-right">N.º reporte:</dt>
          <dd className="col-sm-2">{validate(data.cabina_id)}</dd>
          <br />
          <dt className="col-sm-2 text-right">Siniestro:</dt>
          <dd className="col-sm-2">{validate(data.siniestro_id)}</dd>
          <dt className="col-sm-2 text-right">Declaración:</dt>
          <dd className="col-sm-2">
            {data.declara_conductor === "1" ? (
              <i className="fa fa-check" aria-hidden="true"></i>
            ) : (
              <i className="fa fa-times" aria-hidden="true"></i>
            )}
          </dd>
          <dt className="col-sm-2 text-right">Certificado:</dt>
          <dd className="col-sm-2">{validate(data.certificado)}</dd>
          <br />
          <dt className="col-sm-2 text-right">Evento:</dt>
          <dd className="col-sm-2">{validate(data.evento)}</dd>
          <dt className="col-sm-2 text-right">Sub evento:</dt>
          <dd className="col-sm-6">{validate(data.sub_evento)}</dd>

          <dt className="col-sm-2 text-right">Ajustador clave:</dt>
          <dd className="col-sm-2">{validate(data.ajustador_id)}</dd>
          <dt className="col-sm-2 text-right">Estado:</dt>
          <dd className="col-sm-2">{validate(data.Estado)}</dd>
          {/* <dd className="col-sm-2">{validate(data.estado_id)}</dd> */}
          <dt className="col-sm-2 text-right">Municipio:</dt>
          <dd className="col-sm-2">{validate(data.municipio_id)}</dd>
          <dt className="col-sm-2 text-right">Nombre ajustador:</dt>
          <dd className="col-sm-10">{validate(data.ajustador_nombre)}</dd>
          <dt className="col-sm-2 text-right">Asegurado:</dt>
          <dd className="col-sm-10">{validate(data.asegurado_nombre)}</dd>
          <br />
          <dt className="col-sm-2 text-right">Estatus siniestro:</dt>
          {/* <dd className="col-sm-2">{data.status_id}</dd><br/> */}
          <dd className="col-sm-4">{validate(data.estatusSiniesto)}</dd>
          <dt className="col-sm-2 text-right">Estatus reporte:</dt>
          {/* <dd className="col-sm-2">{data.status_id}</dd><br/> */}
          <dd className="col-sm-4">{validate(data.estatus)}</dd>
          <br />
          <dt className="col-sm-12 text-left title-infoS">
            INFORME DEL AJUSTADOR
          </dt>
          <dt className="col-sm-2 text-right">Siniestro ID:</dt>
          <dd className="col-sm-4">{data.tipo_siniestro_id}</dd>
          <dt className="col-sm-2 text-right">Causa ID:</dt>
          <dd className="col-sm-4">{data.causa_siniestro_id}</dd>
          <dt className="col-sm-2 text-right">Tipo siniestro:</dt>
          {/* <dd className="col-sm-2">{data.tipo_siniestro_id}</dd> */}
          <dd className="col-sm-4">{validate(data.tipo_nombre)}</dd>
          <dt className="col-sm-2 text-right">Causa siniestro:</dt>
          {/* <dd className="col-sm-2">{data.causa_siniestro_id}</dd> */}
          <dd className="col-sm-4">{validate(data.causa_nombre)}</dd>
          <dt className="col-sm-2 text-right">Autoridad presente:</dt>
          {/* <dd className="col-sm-2">{data.autoridad_id}</dd><br/> */}
          <dd className="col-sm-4">{validate(data.autoridad_nombre)}</dd>
          <br />
          <dt className="col-sm-2 text-right">Atencion en lugar:</dt>
          <dd className="col-sm-4">
            {data.atencion_lugar === "1" ? (
              <i className="fa fa-check" aria-hidden="true"></i>
            ) : (
              <i className="fa fa-times" aria-hidden="true"></i>
            )}
          </dd>
          <br />
          <dt className="col-sm-2 text-right">Autoridad:</dt>
          {/* <dd className="col-sm-2">{data.responsable_autoridad}</dd> */}
          <dd className="col-sm-4">{validate(data.segunAutoridad)}</dd>
          <dt className="col-sm-2 text-right">Ajustador:</dt>
          {/* <dd className="col-sm-2">{data.responsable_ajustador}</dd> */}
          <dd className="col-sm-4">{validate(data.segunAjustador)}</dd>

          <dt className="col-sm-12 text-left title-infoS">FECHA REPORTE</dt>
          <dt className="col-sm-2 text-right">Reporte:</dt>
          <dd className="col-sm-4">{formatDate(data.fecha_repote)}</dd>
          <dt className="col-sm-2 text-right">Ocurrencia:</dt>
          <dd className="col-sm-4">{formatDate(data.fecha_ocurrencia)}</dd>
          <dt className="col-sm-2 text-right">Inicio ajuste:</dt>
          <dd className="col-sm-4">{formatDate(data.inicio_ajuste)}</dd>
          <dt className="col-sm-2 text-right">Fin ajuste:</dt>
          <dd className="col-sm-4">{formatDate(data.fin_ajuste)}</dd>
          <dt className="col-sm-2 text-right">Cita:</dt>
          <dd className="col-sm-4">{formatDate(data.cita)}</dd>
          <dt className="col-sm-12 text-left title-infoS">
            INFORMACIÓN DE LA PÓLIZA
          </dt>
          <br />
          <dt className="col-sm-2 text-right">Póliza:</dt>
          <dd className="col-sm-10">{validate(data.poliza)}</dd>
          <dt className="col-sm-2 text-right">Paquete:</dt>
          <dd className="col-sm-10">{validate(data.paquete_descripcion)}</dd>
          <dt className="col-sm-12 text-left title-infoS">
            INSERTAR SEGUIMIENTO
          </dt>
          <dt className="col-sm-2 text-right">Comentario:</dt>
            <dd className="col-sm-10"><textarea id="comentario" name="comentario" value={state.comentario} onChange={handleChange} className="form-control">{state.comentario}</textarea></dd>
          <dd className="col-sm-8">
            <label className="label-P">REGISTRO DE ACTUALIZACIONES</label>
            <nav aria-label="Page navigation">
              <ul className="pagination pagination-sm">
                {bitacora.data.length === 0 && <div>No hay registros</div>}
                {bitacora.data.length !== 0 && (
                  <li
                    className={
                      bitacora.index === null ? "li-info dis-li" : "li-info"
                    }
                    onClick={() => {
                      click_botacora("Actual");
                    }}
                  >
                    <a>Actual</a>
                  </li>
                )}
                {/* <li>
                  <a aria-label="Previous">
                    <span aria-hidden="true">&laquo;</span>
                  </a>
                </li> */}
                {bitacora.data &&
                  bitacora.data.map((item, i) => (
                    <li
                      key={i}
                      className={
                        bitacora.index === i ? "li-info dis-li" : "li-info"
                      }
                      onClick={() => {
                        click_botacora(i);
                      }}
                    >
                      <a>{i + 1}</a>
                    </li>
                  ))}
                {/*  <li>
                  <a aria-label="Next">
                    <span aria-hidden="true">&raquo;</span>
                  </a>
                </li> */}
              </ul>
            </nav>
          </dd>
          <dd className="col-sm-4 text-right">
           {/*  <button style={{marginTop:'25px',marginRight:'5px'}} onClick={seguimientio} className="btn btn-primary">Seguimiento</button> */}
            <button style={{marginTop:'25px'}} disabled={state.comentario==''} onClick={postEvent} className="btn btn-primary">Guardar</button>
            </dd>
          {/* {data.tipo_actualizacion!="MANUAL"&&(
            <dd className="col-sm-2 text-right">
              <button className="btn btn-primary btn-P" onClick={()=>{actualizar()}}>Actualizar</button>
            </dd>
          )} */}
        </dl>
      {/*   {state.Acccion!=''&& (
          <Seguimiento titulo={"Seguimiento de siniestros"} id={23} show={1} state={state.data}/>
        )} */}
      </div>
      <div className="modal-footer">
        <button type="button" className="btn btn-secondary" data-dismiss="modal">Cerrar</button>
        {data.tipo_actualizacion!="MANUAL"&&(
          <button className="btn btn-primary" onClick={()=>{actualizar()}}>Actualizar</button>
        )}
      </div>
    </>
  );
};

export default Siniestros;
