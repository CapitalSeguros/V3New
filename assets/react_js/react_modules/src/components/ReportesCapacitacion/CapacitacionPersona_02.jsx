import axios from "axios";
import React from "react";
import ReactDOM from "react-dom";
import { FontAwesomeIcon } from '@fortawesome/react-fontawesome'
import { faEllipsis } from '@fortawesome/free-solid-svg-icons'

class CapacitacionPersona extends React.Component{

    constructor(props){
        super(props);

        this.state = {
            capacitacion_especifica: []
        }

        this.obtenerInformacionCapacitacion = this.obtenerInformacionCapacitacion.bind(this);
        this.deleteRegister = this.deleteRegister.bind(this);
    }

    obtenerInformacionCapacitacion = (a, e, i, o) => {

        const tiempo = new Date();
        const base_url = document.getElementById("base_url").getAttribute("data-url");

        axios.get(base_url+"capacita/devuelveInformacionCapacitacionPersona", {
            params:{
                idPersona: a,
                capacitacion: e,
                sub_capacitacion: i,
                mes: tiempo.getMonth() + 1
            }
        }).then(res => {
            this.setState({capacitacion_especifica: res.data});
        })
    }
    //---------------------------
    deleteRegister = (a,e) => {

        this.props.removeRow(a);
    }
    //---------------------------
    render(){

        //console.log(this.state.capacitacion_especifica);
        const _capa = this.props.data;
        const _idPersona = this.props.idPersona;
        const a_href = [];
        const div_tabs = [];
        var cont = -1;

        for(var a in _capa){    

            const s_c = _capa[a].sub_capacitacion;
            const div_s_c = [];   

            for(var b in s_c){

                const d_s_c =<div><a href="javascript: void(0)" onClick={this.obtenerInformacionCapacitacion.bind(this, _idPersona, a, b)} >{s_c[b].nombre_certificado}</a></div>
                div_s_c.push(d_s_c);
            }

            cont++;

            const _a = <a className={"list-group-item list-group-item-action "+(cont == 0 ? "active" : "")} id={"list-"+_idPersona+"_"+a+"-list"} data-toggle="list" href={"#list-"+_idPersona+"_"+a} role="tab" aria-controls={_idPersona+"_"+a}>{_capa[a].tipoCapacitacion}</a>

            const _div = <div class={"tab-pane fade "+(cont == 0 ? "show active" : "")} id={"list-"+_idPersona+"_"+a} role="tabpanel" aria-labelledby={"list-"+_idPersona+"_"+a+"-list"}>
                <p>Sub-capacitaciones del asignado</p>
                <small>Click a una de las opciones desplegadas</small>
                {div_s_c}
            </div>

            a_href.push(_a);
            div_tabs.push(_div);
        }

        return(
            <div className="row">
                <div className="col-md-4">
                    <div className="list-group" id="list-tab" role="tab-list">
                        {a_href}
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
        )
    }
}

export default CapacitacionPersona;