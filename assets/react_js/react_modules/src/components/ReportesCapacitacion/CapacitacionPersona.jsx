import axios from "axios";
import React from "react";
import ReactDOM from "react-dom";
import firebase from "./../../firebase.js";
import { FontAwesomeIcon } from '@fortawesome/react-fontawesome'
import { faEllipsis } from '@fortawesome/free-solid-svg-icons'

class CapacitacionPersona extends React.Component{

    constructor(props){
        super(props);

        this.state = {
            capacitacion_especifica: []
        }

        this.obtenerInformacionCapacitacion = this.obtenerInformacionCapacitacion.bind(this); //Función obsoleta
        this.deleteRegister = this.deleteRegister.bind(this);
        this.consultaArchivo = this.consultaArchivo.bind(this);
        this.updateRegistro = this.updateRegistro.bind(this);
    }

    obtenerInformacionCapacitacion = (a, e, i, o) => { //Funcion obsoleta

        const tiempo = new Date();
        const base_url = document.getElementById("base_url").getAttribute("data-url");

        /*axios.get(base_url+"capacita/devuelveInformacionCapacitacionPersona", {
            params:{
                idPersona: a,
                capacitacion: e,
                sub_capacitacion: i,
                mes: tiempo.getMonth() + 1
            }
        }).then(res => {
            this.setState({capacitacion_especifica: res.data});
        })*/
    }
    //---------------------------
    consultaArchivo = (e) => {

        const rutaCapacitacion = e.target.getAttribute("data-capacitacion");
        const rutaSubCapacitacion = e.target.getAttribute("data-subCapacitacion");
        const rutaIdPersona = e.target.getAttribute("data-idPersona");
        const rutaRamo = e.target.getAttribute("data-ramo");
        const archivo = e.target.getAttribute("data-archivo");

        var storage = firebase.storage();
        var rutaReferencia = storage.ref();
        var rutaPadre = rutaReferencia.child("registroCapacitacionesExternas");
        var subRutas = rutaPadre.child(`/${rutaCapacitacion}/${rutaSubCapacitacion}/${rutaIdPersona}/${rutaRamo.replace("daños", "danios")}/`);
        var rutaArchivo = subRutas.child(archivo);

        rutaArchivo.getDownloadURL().then((url) => {

            console.log(url);
            //var linkDownload = window.URL.createObjectURL(new Blob([url]));
            var link = document.createElement("a");
            link.href = url; //linkDownload;
            link.setAttribute("download", archivo);
            link.setAttribute("target", "_blank");
            document.body.appendChild(link);
            link.click();
            document.body.removeChild(link);

        }).catch((error) => {
            console.log(error.code);
            alert(error.code);
        })

    }
    //---------------------------
    deleteRegister = (idRegistro, rutaArchivo, tipoRegistro, e) => {

        this.props.removeRow(
            {
                idRegistro: idRegistro,
                rutaArchivo: rutaArchivo,
                tipoRegistro: tipoRegistro,
            });
    }
    //---------------------------
    updateRegistro = (idRegistro, e) => {

        //console.log(idRegistro);
        this.props.updateRegister(idRegistro);
    }
    //---------------------------
    render(){

        //console.log(this.state.capacitacion_especifica);
        const _capa = this.props.data;
        const _idPersona = this.props.idPersona;
        //const a_href = [];
        //const div_tabs = [];
        const collapse_panels = [];
        var cont = -1;

        //console.log(_capa);

        for(var a in _capa){

            const idCapacitacion = _capa[a][0].id_capacitacion;
            const anexo = _capa[a][0].anexoResponsables || {};
            const archivo = _capa[a][0].anexoArchivo || {};
            const registro = _capa[a][0].tipoRegistro || "";
            const aTarget = [];

            //console.log(anexo,archivo,registro);

            if(registro == "interno"){
                
                var aTarget_ = <div className="dropdown-menu" aria-labelledby={"dropd-"+_capa[a][0].idRegistro+"-reg"}>
                    <h6 class="dropdown-header">Fecha de capacitación</h6>
                    <a className="dropdown-item" href="javascript: void(0)">{anexo.fechaCompromiso}</a>
                    <h6 class="dropdown-header">Responsables</h6>
                    {
                        anexo.responsables.map((arr1, i) => <a className="dropdown-item" href="javascript: void(0)">{arr1.nombre}</a>)
                    }
                </div>

                aTarget.push(aTarget_);
            } 
            
            //const dropDownContenedor = <div className="dropdown-menu" aria-labelledby={"dropd-"+arr.idRegistro}></div>

            const cardPanel = 
                <div className="card mt-3">
                    <div className="card-header">
                        <a data-toggle="collapse" role="button" aria-expanded="false" aria-controls={"collapse_"+idCapacitacion} href={"#collapse_"+idCapacitacion}>{a.toUpperCase()}</a>
                    </div>
                    <div className="card-body table-responsive collapse" id={"collapse_"+idCapacitacion}>
                        <table className="table">
                            <thead>
                                <tr>
                                    <th>Sub-capacitacion</th>
                                    <th>Ramo</th>
                                    <th>Tiempo asignado (hrs)</th>
                                    <th>Fecha de alta</th>
                                    <th>Registrado por:</th>
                                    <th>Tipo de registro</th>
                                    <th>Registro</th>
                                    <th>Opciones</th>
                                </tr>
                            </thead>
                            <tbody>
                                {
                                    _capa[a].map((arr, i) => 
                                        <tr key={i}>
                                            <td>{arr.nombreCertificado}</td>
                                            <td>{arr.nombre_ramo.toUpperCase()}</td>
                                            <td className="text-center">{arr.horas}</td>
                                            <td>{arr.fecha}</td>
                                            <td>{arr.creadorAlta}</td>
                                            <td>{arr.tipoRegistro.toUpperCase()}</td>
                                            <td className="text-center">
                                                <div className="dropdown">
                                                    <a href="javascript: void(0)" className="dropdown-toggle" id={"dropd-"+arr.idRegistro+"-reg"} data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">Ver</a>
                                                    {
                                                        arr.tipoRegistro == "interno" ?
                                                        <div className="dropdown-menu" aria-labelledby={"dropd-"+arr.idRegistro+"-reg"}>
                                                            <h6 class="dropdown-header">Fecha de capacitación</h6>
                                                            <a className="dropdown-item" href="javascript: void(0)">{arr.anexoResponsables["fechaCompromiso"]}</a>
                                                            <h6 class="dropdown-header">Responsables</h6>
                                                            {
                                                                arr.anexoResponsables["responsables"].map((arr_, i) => 
                                                                    <a className="dropdown-item" href="javascript: void(0)">{arr_["nombre"]}</a>
                                                                )
                                                            }
                                                        </div>
                                                        :
                                                        <div className="dropdown-menu" aria-labelledby={"dropd-"+arr.idRegistro+"-reg"}>
                                                            <a className="dropdown-item" href="javascript: void(0)" data-capacitacion={a} data-subCapacitacion={arr.nombreCertificado} data-idPersona={arr.idPersona} data-ramo={arr.nombre_ramo} data-archivo={arr.anexoArchivo} onClick={this.consultaArchivo.bind(this)}>{"Descargar archivo "+ arr.anexoArchivo}</a>
                                                        </div>
                                                    }
                                                </div>
                                            </td>
                                            <td>
                                                <div className="dropdown">
                                                    <a href="javascript: void(0)" className="dropdown-toggle" id={"dropd-"+arr.idRegistro} data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">Opciones</a>

                                                    <div className="dropdown-menu" aria-labelledby={"dropd-"+arr.idRegistro}>
                                                        <a className="dropdown-item" href="javascript: void(0)" onClick={this.updateRegistro.bind(this, arr.idRegistro)}>Editar</a>
                                                        <a className="dropdown-item" href="javascript: void(0)" onClick={this.deleteRegister.bind(this, arr.idRegistro, `/${a}/${arr.nombreCertificado}/${arr.idPersona}/${arr.nombre_ramo}/${arr.anexoArchivo}`, arr.tipoRegistro)}>Eliminar</a>
                                                        {
                                                            //arr.anexoArchivo && <a className="dropdown-item" href="javascript: void(0)" data-capacitacion={a} data-subCapacitacion={arr.nombreCertificado} data-idPersona={arr.idPersona} data-ramo={arr.nombre_ramo} data-archivo={arr.anexoArchivo} onClick={this.consultaArchivo.bind(this)}>{"Descargar archivo "+ arr.anexoArchivo}</a>
                                                        }
                                                    </div>
                                                </div>
                                            </td>
                                        </tr>
                                    )
                                }
                            </tbody>
                        </table>
                    </div>
                </div>
            ;
            
            collapse_panels.push(cardPanel);
        }

        /*for(var a in _capa){    

            const s_c = _capa[a].sub_capacitacion;
            const div_s_c = [];   

            for(var b in s_c){

                const d_s_c =<div className="mt-3"><a href="javascript: void(0)">{s_c[b].nombre_certificado}</a></div> //onClick={this.obtenerInformacionCapacitacion.bind(this, _idPersona, a, b)}
                div_s_c.push(d_s_c);
            }

            cont++;

            const _a = <a className={"list-group-item list-group-item-action "+(cont == 0 ? "active" : "")} id={"list-"+_idPersona+"_"+a+"-list"} data-toggle="list" href={"#list-"+_idPersona+"_"+a} role="tab" aria-controls={_idPersona+"_"+a}>{_capa[a].tipoCapacitacion}</a>

            const _div = <div class={"tab-pane fade "+(cont == 0 ? "show active" : "")} id={"list-"+_idPersona+"_"+a} role="tabpanel" aria-labelledby={"list-"+_idPersona+"_"+a+"-list"}>
                <p>Sub-capacitaciones del asignado</p>
                <small>Click a una de las opciones desplegadas para refrescar la infomación</small>
                {div_s_c}
            </div>

            a_href.push(_a);
            div_tabs.push(_div);
        }*/

        return(
            <div classaName="card card-body">
                <h6>Registros de capacitaciones</h6>
                {
                    collapse_panels
                }
            </div>
            /*<div className="row">
                <div className="col-md-4">
                    <div className="list-group" id="list-tab" role="tab-list">
                        {
                            a_href
                        }
                    </div>
                </div>
                <div className="col-md-6">
                    <div className="tab-content" id="nav-tabContent">
                        {div_tabs}
                    </div>
                </div>
                {
                     this.state.capacitacion_especifica.length > 0 && 
                   <div className="col-md-12">
                        <div className="card-body table-responsive">
                           <table className="table">
                               <thead>
                                   <tr>
                                       <th>Sub-capacitación</th>
                                       <th>Fecha</th>
                                       <th>Profesional</th>
                                       <th>Vida</th>
                                       <th>Autos</th>
                                       <th>Daños</th>
                                       <th>GMM</th>
                                       <th>Fianzas</th>
                                       <th>Opciones</th>
                                   </tr>
                               </thead>
                               <tbody>
                                   {    
                                        this.state.capacitacion_especifica.length > 0 &&
                                       this.state.capacitacion_especifica.map((arr, i) =>
                                        <tr key={i}>
                                            <td>{arr.nombreCertificado}</td>
                                            <td>{arr.fechaAsignada}</td>
                                            <td className="text-center">{arr.certificacion}</td>
                                            <td className="text-center">{arr.certificacionVida}</td>
                                            <td className="text-center">{arr.certificacionAutos}</td>
                                            <td className="text-center">{arr.certificacionDanos}</td>
                                            <td className="text-center">{arr.certificacionGmm}</td>
                                            <td className="text-center">{arr.certificacionFianzas}</td>
                                            <td>
                                                <div className="dropdown">
                                                    <button className="btn btn-link dropdown-toggle btn-sm" type="button" id="dpd" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                                        Opciones
                                                    </button>
                                                    <div className="dropdown-menu" aria-labelledby="dpd">
                                                        <a className="dropdown-item text-danger" href="javascript: void(0)" onClick={this.deleteRegister.bind(this, arr.idCertificacion)}>Eliminar</a>
                                                        <a className="dropdown-item text-info" href="javascript: void(0)">Editar</a>
                                                    </div>
                                                </div>
                                            </td>
                                        </tr>
                                       )
                                   }
                               </tbody>
                           </table>
                        </div>
                    </div>
                }
            </div>
        */ ) 
    }
}

export default CapacitacionPersona;