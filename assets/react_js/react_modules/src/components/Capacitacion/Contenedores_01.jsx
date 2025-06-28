import React, { useState, useEffect } from "react";
import ReactDOM from "react-dom";
import ContenedorOpciones from "../Capacitacion/ContenedorOpciones.jsx";
import ContenedorObjeto from "../Capacitacion/ContenedorObjeto.jsx";
import { FontAwesomeIcon } from '@fortawesome/react-fontawesome'
import { faTrash } from '@fortawesome/free-solid-svg-icons'
import axios from "axios";
//import ListaChecbox from "../Capacitacion/ListaChecbox";

class Contenedor extends React.Component{

    constructor(props){
        super(props);
        this.transicionDiv = this.transicionDiv.bind(this);
        this.getCapacitaciones = this.getCapacitaciones.bind(this);
        this.getPersonas = this.getPersonas.bind(this);
        this.anexaALista = this.anexaALista.bind(this);
        this.handleChange =  this.handleChange.bind(this);
        this.getRamos = this.getRamos.bind(this);
        this.handleChangeCheckbox = this.handleChangeCheckbox.bind(this);
        this.handleChangePersons = this.handleChangePersons.bind(this);
        this.removePerson = this.removePerson.bind(this);
        this.collectHours = this.collectHours.bind(this);
        this.sendPostData = this.sendPostData.bind(this);
    }

    state = {
        personas: [],
        ramos: [],
        capacitaciones: [],
        sub_capacitaciones: [],
        tran: 1,
        _temporal:[],
        _temporal_ramo: [],
        _temporal_persona: [],
        //--contenedores--//
        _capacitacion: [],
        _sub_capacitacion: [],
        _ramos: [],
        _personas: [],
        _autos_hours: 0,
        _profesional_hours: 0,
        _vida_hours: 0,
        _danio_hours: 0,
        _gmm_hours: 0,
        _fianzas_hours: 0,
        //_horas_ramos: []

        //---------------//
    }
    //-----------------
    componentDidMount = () => {
        this.getCapacitaciones();
        this.getPersonas();
        this.getRamos();
    }
    //------------------
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
     }
    //------------------
    getPersonas = async () => {
        const base_url = window.jQuery("#base_url").data("url");
        await axios.get(base_url+"capacita/gestionCapacitacion",{
            params: {
                a: "personas"
            }
        }).then(res => {
            this.setState({
                personas: res.data
            })
        });
        //console.log(this.state.personas);
    }
    //------------------
    getRamos = async () => {
        const base_url = window.jQuery("#base_url").data("url");
        await axios.get(base_url+"capacita/gestionCapacitacion", {
            params: {
                a: "ramos"
            }
        }).then(res => {
            this.setState({
                ramos: res.data
            });
        });
        //console.log(this.state.ramos);
    }
    //-------------------
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
    //------------------
    anexaALista = async (e,a) => {

        if(this.state._temporal.capacitacion.valor == 0){
            alert("No se selecciono una opción válida");
            return;
        }

        if(e == "capacitacion"){
            //Llamada AJAX: GET
            const base_url = window.jQuery("#base_url").data("url");
            await axios.get(base_url+"capacita/gestionCapacitacion", {
                params: {
                    a: "sub_capacitacion",
                    b: this.state._temporal.capacitacion.valor
                }
            }).then(res => {
                this.setState({
                    sub_capacitaciones: res.data
                });
            });
        }
        //-----------------------
        switch(e){
            case "capacitacion": this.setState({_capacitacion: [this.state._temporal.capacitacion]});
            break;
            case "sub_capacitacion" : this.setState({_sub_capacitacion: [this.state._temporal.sub_capacitacion]});
            break;
            case "ramo": this.setState({_ramos: [this.state._temporal_ramo]});
            break;
            case "persona": this.setState({_personas: [...this.state._personas, this.state._temporal_persona]});
            break;
        }
    }
    //------------------
    /*obtenerOpciones = (e, a) => {

        //console.log(a);
        switch(e){
            case "capacitacion": this.setState({listado : {...this.state.listado, [e]:a }}); //setListado({...listado, [e]:a });
            break;
            case "persona": this.setState({agentes: [...this.state.agentes,{ [e]:a }]}); //setAgentes([...agentes,{ [e]:a }]);
            break;
        }
        
    }*/
    //------------------
    handleChange = (e) => {

        //var array_select = {};
        const selected_index = e.target.selectedIndex;
        const n_element = e.target.id;
        const valor = e.target.options[selected_index].value;
        const texto = e.target.options[selected_index].text;

        this.setState({
            _temporal: {
                ...this.state._temporal,
                [n_element]:{
                    valor: valor,
                    texto: texto
                }
            }
        });

        //console.log(this.state._temporal);
    }
    //-------------------
    handleChangeCheckbox = (e, a) => {

        //e es la cadena de tipo; a es el target
        const _check = a.target.checked;
        const valor = a.target.value;

        this.setState({
            _temporal_ramo: {
                ...this.state._temporal_ramo,
                [valor] : _check
            }
        });
    }
    //-------------------
    handleChangePersons = (e, a) => {

        //e es la cadena de tipo
        //console.log(e);
        const selectePersona = a.target.selectedIndex;
        const _idPersona = a.target.options[selectePersona].value; //a.target.selectedIndex;
        const _correo = a.target.options[selectePersona].getAttribute("data-correo"); //e.target.getAttribute("data-correo");
        const _nombrePersona = a.target.options[selectePersona].text.split("(");
        const _soloNombre = _nombrePersona[0].trim();
        
        this.setState({
            _temporal_persona: {
                idPersona: _idPersona,
                correo: _correo,
                nombre: _soloNombre
            }
        });
    }
    //-------------------
    removePerson = (e) => {
        
        console.log("res "+e);
        //this.state._personas state final de personas;
        const new_persons_array = [];

        this.state._personas.map((arr, i) => {

            if(arr.idPersona != e){
                new_persons_array.push(arr);
            }
        });

        this.setState({
            _personas: new_persons_array
        });

        //console.log(new_persons_array);
    }
    //-------------------
    collectHours = (e) => {

        console.log(e);
        switch(e.inputNumber.ramo){
            case "profesional": this.setState({_profesional_hours: e.inputNumber.valor});
            break;
            case "autos": this.setState({_autos_hours: e.inputNumber.valor});
            break;
            case "vida": this.setState({_vida_hours: e.inputNumber.valor});
            break;
            case "danios": this.setState({_danio_hours: e.inputNumber.valor});
            break;
            case "GMM": this.setState({_gmm_hours: e.inputNumber.valor});
            break;
            case "fianzas": this.setState({_fianzas_hours: e.inputNumber.valor});
            break;
        }
    }
    //-------------------
    sendPostData = (e) => {

        e.preventDefault();
        e.stopPropagation();
        const base_url = window.jQuery("#base_url").data("url");

        var sendData = new FormData(); //Necesario para poder trabajar con el objeto en el controlador.
        sendData.append("capacitacion", JSON.stringify(this.state._capacitacion)); //Convertir el objeto en cadena Json para covertirlo en Objeto en el controlador.
        sendData.append("sub_capacitacion", JSON.stringify(this.state._sub_capacitacion));
        sendData.append("ramos", JSON.stringify(this.state._ramos));
        sendData.append("personas", JSON.stringify(this.state._personas));
        sendData.append("horas_asignadas", JSON.stringify(
            {
                profesional: this.state._profesional_hours,
                autos: this.state._autos_hours,
                vida: this.state._vida_hours,
                danios: this.state._danio_hours,
                GMM: this.state._gmm_hours,
                fianzas: this.state._fianzas_hours
            }
        ));

        axios.post(base_url+"capacita/registraDatosDeCapacitacion", sendData).then(function(res){
            
            console.log(res.data);

            console.log(res.data.mensaje);

            alert(res.data.mensaje);
            if(res.data.bool){
                //window.location.reload(base_url+"capacita/reporteDeCapacitacionManual");
                window.location.replace(base_url+"capacita/reporteDeCapacitacionManual");
            }

        }). catch(function(error){
            
            alert(error);
            console.log(error);
        });
    }
    //-------------------
    render(){

        const personas = this.state.personas;
        var _options_persona = [];
        for(var aa in personas){

            const grupo = <optgroup label={aa.toUpperCase()}>
                {personas[aa].map((arr, i) =>
                    <option value={arr.idPersona} key={i} data-correo={arr.email}>{arr.nombres+" "+arr.apellidoPaterno+" "+arr.apellidoMaterno+" ("+arr.email+")"}</option>
                )}
            </optgroup>;

            _options_persona.push(grupo);

        }
        
        const _submit = <div className="text-center">
            <button className="btn btn-success btn-sm mt-2 text-center">Generar capacitación</button>
        </div>

        const state_persona = this.state._personas;
        const state_capacitacion = this.state._capacitacion;
        const state_sub_capacitacion = this.state._sub_capacitacion;
        const state_ramo = this.state._ramos;

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
                        <div className="card mt-3 mb-3">
                            <div className="card-header text-center">CAPACITACION</div>
                            <div className="card-body">
                                <label htmlFor="capacitacion">Seleccione una opción</label>
                                <select name="capacitacion" id="capacitacion" className="form-control" onChange={this.handleChange.bind(this)}>
                                    <option value="0">Seleccione...</option>
                                    {
                                        this.state.capacitaciones.map((arr, i) =>
                                            <option value={arr.id_capacitacion} key={i}>{arr.tipoCapacitacion}</option>
                                        )
                                    }
                                </select>
                                <div className="mt-2 text-center">
                                    <button className="btn btn-primary btn-sm" onClick={this.anexaALista.bind(this, "capacitacion")}>Tomar</button>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div id="sbcpct" className="tab-pane fade" role="tabpanel" aria-labelledby="t_sub-capacitacion">
                        <div className="card mt-3 mb-3">
                            <div className="card-header text-center">SUB-CAPACITACIÓN</div>
                            <div className="card-body">
                                <label htmlFor="sub-capacitacion">Seleccione una opción</label>
                                <select name="sub_capacitacion" id="sub_capacitacion" className="form-control" onChange={this.handleChange.bind(this)}>
                                    <option value="0">Seleccione</option>
                                    {
                                        this.state.sub_capacitaciones.length > 0 ? 
                                        this.state.sub_capacitaciones.map((arr, i) =>
                                            <option value={arr.id_certificado} key={i}>{arr.nombreCertificado}</option>
                                        ) : ""
                                    }
                                </select>
                                <div className="mt-2 text-center">
                                    <button className="btn btn-primary btn-sm" onClick={this.anexaALista.bind(this, "sub_capacitacion")}>Tomar</button>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div id="rm" className="tab-pane fade" role="tabpanel" aria-labelledby="t_ramo">
                        <div className="card mt-3 mb-3">
                            <div className="card-header text-center">RAMO</div>
                            <div className="card-body">
                                <label htmlFor="ramo">Seleccione una o varias opciones</label>
                                <div className="card-body border border-info">
                                {
                                    this.state.ramos.map((arr, i) =>
                                        <div className="form-check mb-1">
                                            <input className="form-check-input" onChange={this.handleChangeCheckbox.bind(this, "ramos")} type="checkbox" key={i} name={arr.nombre_ramo.replace("daños","danios")} id={arr.nombre_ramo.replace("daños","danios")} value={arr.nombre_ramo.replace("daños","danios")}/>
                                            <label htmlFor={arr.nombre_ramo.replace("daños","danios")}>{arr.nombre_ramo.toUpperCase()}</label>
                                        </div>
                                    )
                                }
                                </div>
                                <div className="mt-2 text-center">
                                    <button className="btn btn-primary btn-sm" onClick={this.anexaALista.bind(this, "ramo")}>Agregar a la lista</button>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div id="prsn" className="tab-pane fade" role="tabpanel" aria-labelledby="t_persona">
                        <div className="card mt-3 mb-3">
                            <div className="card-header text-center">PERSONA</div>
                            <div className="card-body">
                                <label htmlFor="capacitacion">Seleccione una opción</label>
                                <select name="persona" id="persona" className="form-control" onChange={this.handleChangePersons.bind(this, "persona")}>
                                    <option value="0">Seleccione</option>
                                    {
                                        _options_persona.map(_p =>
                                            _p
                                        )
                                    }
                                </select>
                                <div className="mt-2 text-center">
                                    <button className="btn btn-primary btn-sm" onClick={this.anexaALista.bind(this, "persona")}>Agregar a la lista</button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div className="col-md-8 mt-3 mb-3">
                    <div className="card">
                        <div className="card-header text-center">Avance seleccionado</div>
                        <div className="card-body">
                            <form onSubmit={this.sendPostData.bind(this)}>
                                <ListadoSeleccionado 
                                    _c={this.state._capacitacion}
                                    _s_c={this.state._sub_capacitacion}
                                    _r={this.state._ramos}
                                    _p={this.state._personas}
                                    removePerson={this.removePerson.bind(this)}
                                    collectHours={this.collectHours.bind(this)}
                                ></ListadoSeleccionado>
                                {
                                    state_capacitacion.length > 0 && state_sub_capacitacion.length > 0 && state_ramo.length > 0 && state_persona.length > 0 ?
                                    _submit
                                    :
                                    ""
                                }
                            </form>
                        </div>
                    </div>
                </div>
            </div>                
           
            <div className="float-right mt-2 mb-3">
                <button className="btn btn-info btn-sm ml-2" onClick={this.transicionDiv.bind(this,parseInt(this.state.tran - 1))} >Anterior</button>
                <button className="btn btn-info btn-sm ml-2" onClick={this.transicionDiv.bind(this,parseInt(this.state.tran + 1))}>Siguiente</button>
            </div>
        </div>

        )
    }
}

const ListadoSeleccionado = (props) => {

    const [inputProf, setInputProf] = useState("");
    const [inputAutos, setInputAutos] = useState("");
    const [inputVida, setInputVida] = useState("");
    const [inputDanio, setInputDanio] = useState("");
    const [inputGMM, setInputGMM] = useState("");
    const [inputFianzas, setInputFianzas] = useState("");

    const object_ramo = {
        "profesional" : inputProf,
        "autos": inputAutos,
        "vida": inputVida,
        "danios": inputDanio,
        "GMM": inputGMM,
        "fianzas": inputFianzas
    }

    const cont_c = props._c.map((arr, i) => 
           
        <div className="card-body" key={i}>
            <h6><span class="badge badge-secondary">Paso 1</span> Selección de capacitación </h6>
            <div className="form-check mt-1">
                <input type="checkbox" className="form-check-input" name="capacitacion[]" id="capacitacion" value={arr.valor} disabled checked/>
                <label className="form-check-label" htmlFor="capacitacion">{arr.texto}</label>
            </div>
        </div> 
    );
    //------------------------
    const cont_s_c = props._s_c.map((arr_, i) =>
        <div className="card-body" key={i}>
            <h6><span class="badge badge-secondary">Paso 2</span> Selección de sub-capacitación </h6>
            <div className="form-check mt-1">
                <input type="checkbox" className="form-check-input" name="sub_capacitacion[]" id="sub_capacitacion" value={arr_.valor} disabled checked/>
                <label className="form-check-label" htmlFor="sub_capacitacion">{arr_.texto}</label>
            </div>
        </div> 
    );
    //----------------------
    const handleChangeNumber = (e) => {

        props.collectHours({
            //[e.target.id]: e.target.value
            inputNumber: {
                ramo: e.target.id,
                valor: e.target.value
            }
        });

        switch(e.target.id){
            case "profesional": setInputProf(e.target.value);
            break;
            case "autos": setInputAutos(e.target.value);
            break;
            case "vida": setInputVida(e.target.value);
            break;
            case "danios": setInputDanio(e.target.value);
            break;
            case "GMM": setInputGMM(e.target.value);
            break;
            case "fianzas": setInputFianzas(e.target.value);
            break;
        }

        //setInputProf(e.target.value);
    }
    //----------------------
    /*const handleChangeNumber = (e) => {

        //e es el ramo;
        const tipo = e.target.id;
        const itr = props._r[0];

        switch(tipo){
            case "profesional": setInputProf(e.target.value);
            break;
            case "autos": setInputAutos(e.target.value);
            break;
            case "vida": setInputVida(e.target.value);
            break;
            case "danios": setInputDanio(e.target.value);
            break;
            case "GMM": setInputGMM(e.target.value);
            break;
            case "fianzas": setInputFianzas(e.target.value);
            break;
        }
                
        props.collectHours({[tipo]: object_ramo[tipo]});
        //props.collectHours(object_ramo);
        //console.log(object_ramo);
    }*/
    //------------------------

    var d_true = 0;
    var array_ramos_ = [];
    const iterador = props._r[0];

    for(var a in iterador){
        //console.log(iterador[a]);
        if(iterador[a]){
            d_true++;

            const rr = <div className="form-group row">
                <label htmlFor={a} class="col-md-4 col-form-label">{a.replace("danios", "daños").toUpperCase()}</label>
                <div className="col-md-4">
                    <input className="form-control" onChange={handleChangeNumber.bind(this)} type="number" name={a} id={a} value={
                        //inputProf
                        object_ramo[a]
                    } placeholder="Ejemplo: 1.5 horas" required/>
                </div>
            </div>

            array_ramos_.push(rr);
        }
    }
    //----------------------
    const cont_r = props._r.length > 0 && d_true > 0 ? 
        <div className="card-body">
             <h6><span class="badge badge-secondary">Paso 3</span> Selección y asignación de horas a ramos</h6>
             <small className="form-text text-muted">Las horas que se asignarán deben de ser enteros o con punto decimal</small>
             <small className="form-text text-muted mb-2">Ejemplo: una hora y media: 1.5, media hora: .5 ó 0.5</small>
             {
                array_ramos_ //Aqui se imprime los campos númericos para el formulario.
             }
        </div>
    : "";
    //----------------------
    const deletePerson = (e, a) => {
        //e es el idPersona
        a.preventDefault();
        props.removePerson(e);
    }
    //---------------------
    const cont_p = props._p.length > 0 ? <div className="card-body">
        <h6><span class="badge badge-secondary">Paso 4</span> Personal asignado</h6>
        <div className="table-responsive mt-3">
            <table className="table table-sm">
                <thead>
                    <tr>
                        <th>Asignado</th>
                        <th>Nombre</th>
                        <th>Correo</th>
                        <th></th>
                    </tr>
                </thead>
                <tbody>
                    {
                        props._p.map((arr, i) => 
                            <tr key={i}>
                                <td><input type="checkbox" name="persona_capacitacion[]" id={"p"+arr.idPersona} checked disabled value={arr.idPersona}/></td>
                                <td>{arr.nombre}</td>
                                <td>{arr.correo}</td>
                                <td className="text-center">
                                    <a href="javascript: void(0)" className="text-danger ml-4" onClick={deletePerson.bind(this, arr.idPersona)}>
                                        <FontAwesomeIcon icon={faTrash} />
                                    </a>
                                </td>
                            </tr>
                        )
                    }
                </tbody>
            </table>
        </div>
    </div> : "";
    //console.log(props._p);
    //---------------------
    return(
       <div>
           {cont_c}
           {cont_s_c}
           {cont_r}
           {cont_p}
       </div>
    )
}

export default Contenedor;