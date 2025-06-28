import React, { useState, useEffect } from "react";
import ReactDOM from "react-dom";
import ContenedorOpciones from "./ContenedorOpciones.jsx";
import ContenedorObjeto from "./ContenedorObjeto.jsx";
import axios from "axios";
//import ListaChecbox from "../Capacitacion/ListaChecbox";

class Contenedor extends React.Component{

    constructor(props){
        super(props);
        this.transicionDiv = this.transicionDiv.bind(this);
        this.obtenerOpciones = this.obtenerOpciones.bind(this);
        this.getCapacitaciones = this.getCapacitaciones.bind(this);
    }

    state = {
        personas: [
            /*{
                idPersona: 1,
                nombres: "Dennis Alberto",
                apellidoPaterno: "Castillo"
            },
            {
                idPersona: 2,
                nombres: "Edgar Alejandro",
                apellidoPaterno: "Chan"
            },
            {
                idPersona: 3,
                nombres: "Omar",
                apellidoPaterno: "Ceja"
            }*/
        ],
        ramos: [
            /*{
                idR: 1,
                nombre_ramo: "profesional"
            },
            {
                idR: 2,
                nombre_ramo: "daños"
            },
            {
                idR: 3,
                nombre_ramo: "vida"
            },
            {
                idR: 4,
                nombre_ramo: "autos"
            },*/
        ],
        capacitaciones: [],
        listado: [],
        tran: 1,
        agentes: []
    }

    componentDidMount =  () => {
        this.getCapacitaciones();        
    }

    getCapacitaciones =  async () => {
        const base_url = window.jQuery("#base_url").data("url");
        await axios.get(base_url+"capacita/gestionCapacitacion",{
             params: {
                 a: "capacitacion"
             }
         }).then(res => {
             this.setState({
                capacitaciones: res.data});
                //console.log(res);
         });
         //setCapacitaciones(get_result.data);
         //this.setState({capacitaciones: aa.data});
         //console.log(this.state.capacitaciones);
 
     }

    transicionDiv = (ii, tt) =>{
        
        tt.preventDefault();
        const validador = [1,2,3,4];

        if(validador.includes(ii)){
        
            //setTran(ii);
            this.setState({
                tran: ii
            });
        }

        const _link = document.getElementsByClassName("nav-link");
        //console.log(ii);
        window.jQuery(`.nav-tabs a[data-trs="${ii}"]`).tab("show");
    }

    obtenerOpciones = (e, a) => {

        //console.log(a);
        switch(e){
            case "capacitacion": this.setState({listado : {...this.state.listado, [e]:a }}); //setListado({...listado, [e]:a });
            break;
            case "persona": this.setState({agentes: [...this.state.agentes,{ [e]:a }]}); //setAgentes([...agentes,{ [e]:a }]);
            break;
        }
        
    }

    render(){

        //console.log(this.state.capacitaciones);
        const capacitaciones__ = this.state.capacitaciones;
        //console.log(capacitaciones__)
        return(

            <div>
            <ul className="nav nav-tabs" id="tab_c" role="tablist">
                <li className="nav-item">
                    <a className="nav-link active" id="t_capacitacion" href="#cpct" data-trs="1" data-toggle="tab" role="tab" aria-controls="cpct" aria-selected="true">Capacitación</a>
                </li>
                <li className="nav-item">
                    <a className="nav-link" id="t_sub-capacitacion" href="#sbcpct" data-trs="2" data-toggle="tab" role="tab" aria-controls="sbcpct" aria-selected="false">Sub-capacitacion</a>
                </li>
                <li className="nav-item">
                    <a className="nav-link" id="t_ramo" href="#rm" data-toggle="tab" data-trs="3" role="tab" aria-controls="rm" aria-selected="false">Ramos</a>
                </li>
                <li className="nav-item">
                    <a className="nav-link" id="t_persona" href="#prsn" data-toggle="tab" data-trs="4" role="tab" aria-controls="prsn" aria-selected="false  ">Personas</a>
                </li>
            </ul>
            <div className="row border border-dark">
                <div className="col-md-4 tab-content" id="tab_contenido">
                    <div id="cpct" className="tab-pane fade show active " role="tabpanel" aria-labelledby="t_capacitacion">
                        <ContenedorOpciones aria_lby="t_capacitacion" parametro_array={capacitaciones__} obtenerOpciones={this.obtenerOpciones.bind(this, "capacitacion")}></ContenedorOpciones>
                    </div>
                    <div id="sbcpct" className="tab-pane fade" role="tabpanel" aria-labelledby="t_sub-capacitacion">
                        <ContenedorObjeto titulo="t_sub-capacitacion" acumulado={this.state.listado} obtenerOpciones={this.obtenerOpciones.bind(this, "sub-capacitacion")}></ContenedorObjeto>
                    </div>
                    <div id="rm" className="tab-pane fade" role="tabpanel" aria-labelledby="t_ramo">
                        <ContenedorOpciones aria_lby="t_ramo" parametro_array={this.state.ramos} obtenerOpciones={this.obtenerOpciones.bind(this, "ramo")}></ContenedorOpciones>
                    </div>
                    <div id="prsn" className="tab-pane fade" role="tabpanel" aria-labelledby="t_persona">
                        <ContenedorOpciones aria_lby="t_persona" parametro_array={this.state.personas} obtenerOpciones={this.obtenerOpciones.bind(this, "persona")}></ContenedorOpciones>
                    </div>
                </div>
                <div className="col-md-8 mt-4 mb-3">
                    <div className="card">
                        <div className="card-header text-center">Avance seleccionado</div>
                        <div className="card-body">
                            <ListadoSeleccionado array_muestra={this.state.listado}></ListadoSeleccionado>
                        </div>
                    </div>
                </div>
            </div>                
           
            <div className="float-right mt-2">
                <button className="btn btn-info btn-sm ml-2" onClick={this.transicionDiv.bind(this,parseInt(this.state.tran - 1))} >Anterior</button>
                <button className="btn btn-info btn-sm ml-2" onClick={this.transicionDiv.bind(this,parseInt(this.state.tran + 1))}>Siguiente</button>
            </div>
        </div>

        )
    }

}

/*const Contenedor = () => {

    const [capacitaciones, setCapacitaciones] = useState(null)

    const [tran, setTran] = useState(1); //1;
    const [listado, setListado] = useState([]);
    //const [sub_listado, setSub_listado] = useState([]);
    const [agentes, setAgentes] = useState([]);
    const [personas, setPersonas] = useState([
        {
            idPersona: 1,
            nombres: "Dennis Alberto",
            apellidoPaterno: "Castillo"
        },
        {
            idPersona: 2,
            nombres: "Edgar Alejandro",
            apellidoPaterno: "Chan"
        },
        {
            idPersona: 3,
            nombres: "Omar",
            apellidoPaterno: "Ceja"
        }
    ]);
    const [capacitaciones_, setCapacitaciones_] = useState([
        {
            id_capacitacion: 1,
            nombre_capa: "capacitación tecnica"
        },
        {
            id_capacitacion: 2,
            nombre_capa: "desarrollo profesional"
        }
    ]);

    const [ramos, seRamos] =useState([
        {
            idR: 1,
            nombre_ramo: "profesional"
        },
        {
            idR: 2,
            nombre_ramo: "daños"
        },
        {
            idR: 3,
            nombre_ramo: "vida"
        },
        {
            idR: 4,
            nombre_ramo: "autos"
        },
    ])
    const base_url = window.jQuery("#base_url").data("url");
    //console.log(base_url);

    //console.log(personas);
    const transicionDiv = (ii, tt) =>{
        
        tt.preventDefault();
        const validador = [1,2,3,4];

        if(validador.includes(ii)){
        
            setTran(ii);
        }

        const _link = document.getElementsByClassName("nav-link");
        //console.log(ii);
        window.jQuery(`.nav-tabs a[data-trs="${ii}"]`).tab("show");
    }

    const obtenerOpciones = (e, a) => {

        //console.log(a);
        switch(e){
            case "capacitacion": setListado({...listado, [e]:a });
            break;
            case "persona": setAgentes([...agentes,{ [e]:a }]);
            break;
        }
        
    }

    const getPersonas = () => {

    }

    useEffect(() => {
        getCapacitaciones();
    }, []);

    const getCapacitaciones = () => {
       axios.get(base_url+"capacita/gestionCapacitacion",{
            params: {
                a: "capacitacion"
            }
        }).then(res => {
            setCapacitaciones(res.data);
        });
        //setCapacitaciones(get_result.data);
        //console.log(get);

    }

    //console.log(capacitaciones_);
    console.log(capacitaciones);
    return(
        <div>
            <ul className="nav nav-tabs" id="tab_c" role="tablist">
                <li className="nav-item">
                    <a className="nav-link active" id="t_capacitacion" href="#cpct" data-trs="1" data-toggle="tab" role="tab" aria-controls="cpct" aria-selected="true">Capacitación</a>
                </li>
                <li className="nav-item">
                    <a className="nav-link" id="t_sub-capacitacion" href="#sbcpct" data-trs="2" data-toggle="tab" role="tab" aria-controls="sbcpct" aria-selected="false">Sub-capacitacion</a>
                </li>
                <li className="nav-item">
                    <a className="nav-link" id="t_ramo" href="#rm" data-toggle="tab" data-trs="3" role="tab" aria-controls="rm" aria-selected="false">Ramos</a>
                </li>
                <li className="nav-item">
                    <a className="nav-link" id="t_persona" href="#prsn" data-toggle="tab" data-trs="4" role="tab" aria-controls="prsn" aria-selected="false  ">Personas</a>
                </li>
            </ul>
            <div className="row border border-dark">
                <div className="col-md-4 tab-content" id="tab_contenido">
                    <div id="cpct" className="tab-pane fade show active " role="tabpanel" aria-labelledby="t_capacitacion">
                        <ContenedorOpciones aria_lby="t_capacitacion" parametro_array={capacitaciones} obtenerOpciones={obtenerOpciones.bind(this, "capacitacion")}></ContenedorOpciones>
                    </div>
                    <div id="sbcpct" className="tab-pane fade" role="tabpanel" aria-labelledby="t_sub-capacitacion">
                        <ContenedorObjeto titulo="t_sub-capacitacion" acumulado={listado} obtenerOpciones={obtenerOpciones.bind(this, "sub-capacitacion")}></ContenedorObjeto>
                    </div>
                    <div id="rm" className="tab-pane fade" role="tabpanel" aria-labelledby="t_ramo">
                        <ContenedorOpciones aria_lby="t_ramo" parametro_array={ramos} obtenerOpciones={obtenerOpciones.bind(this, "ramo")}></ContenedorOpciones>
                    </div>
                    <div id="prsn" className="tab-pane fade" role="tabpanel" aria-labelledby="t_persona">
                        <ContenedorOpciones aria_lby="t_persona" parametro_array={personas} obtenerOpciones={obtenerOpciones.bind(this, "persona")}></ContenedorOpciones>
                    </div>
                </div>
                <div className="col-md-8 mt-4 mb-3">
                    <div className="card">
                        <div className="card-header text-center">Avance seleccionado</div>
                        <div className="card-body">
                            <ListadoSeleccionado array_muestra={listado}></ListadoSeleccionado>
                        </div>
                    </div>
                </div>
            </div>                
           
            <div className="float-right mt-2">
                <button className="btn btn-info btn-sm ml-2" onClick={transicionDiv.bind(this,parseInt(tran - 1))} >Anterior</button>
                <button className="btn btn-info btn-sm ml-2" onClick={transicionDiv.bind(this,parseInt(tran + 1))}>Siguiente</button>
            </div>
        </div>
    );
}*/

const ListadoSeleccionado = (props) => {

    var cc = "";
    const itt = props.array_muestra;
    for(var a in itt){
        cc = <div className="card">
            <div className="card-header">{itt[a].text}</div>
            <div className="card-body"></div>
        </div>
    }

    return(
       cc
    )
}

/*const ListadoSeleccionado = (props) => {

    //console.log(props.array_muestra);
    return(
       props.array_muestra.map((arr, i) => {

            return(
                <div className="card mb-3" key={i}>
                    <div className="card-header text-center">{arr.capacitacion.text}</div>
                    <div className="card-body table-responsive">
                        <table className="table">
                            <tbody>

                            </tbody>
                        </table>
                    </div>
                </div>
            )
       })
    );
}*/

export default Contenedor;