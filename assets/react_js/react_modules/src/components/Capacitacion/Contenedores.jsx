import React, { useState, useEffect, useRef } from "react";
import ReactDOM from "react-dom";
import ContenedorOpciones from "./ContenedorOpciones.jsx";
import ModalRegistro from "./ModalRegistro.jsx";
import { FontAwesomeIcon } from '@fortawesome/react-fontawesome';
import { faTrash } from '@fortawesome/free-solid-svg-icons';
import axios from "axios";
import DatePicker from "react-datepicker";
import "react-datepicker/dist/react-datepicker.css";
import firebase from "../../firebase.js";
import { isEmptyArray } from "formik";

class Contenedor extends React.Component{

    constructor(props){
        super(props);
        
        this.state = {
            personas: [],
            //----Nuevo implementacion 2022-02-09
            showFinish: false,
            showList: true,
            showFinishButton: false, 
            disabled: false,
            finishPersons: [],
            finishCategory: [],
            finishHours: [],
            finishCreator: [],
            //----Nuevo implementacion 2021-06-11
            ranking_area: [],
            ranking_seleccionado: "",
            personas_seleccionado: [],
            personas_checked: [],
            responsables: [],
            personas_table: [],
            responsables_table: [],
            //---------------------------------
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
            //---------------//
            tipo_registro: 0,
            //---------------//
            files: [],
            validasubida: [],
            //---------------//
            personasResponsables: [],
            fechaCapacitacion: ""
            //---------------//
        }

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
        this.handleClickAreaRanking = this.handleClickAreaRanking.bind(this);
        this.handleChangeCheckboxIdPersona = this.handleChangeCheckboxIdPersona.bind(this);
        this.handleClickConfirmaPersonas = this.handleClickConfirmaPersonas.bind(this);
        this.handleChangeTypeRegister = this.handleChangeTypeRegister.bind(this);
        this.seleccionarArchivoDeRamo = this.seleccionarArchivoDeRamo.bind(this);
        this.insertIntoCloud = this.insertIntoCloud.bind(this);
        this.manageDataPersons = this.manageDataPersons.bind(this);
        this.handleClickResponsable = this.handleClickResponsable.bind(this);
        this.getInputDate = this.getInputDate.bind(this);
        this.generatePostResult = this.generatePostResult.bind(this);
        this.showForm = this.showForm.bind(this);
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
            });
            this.setState({ranking_area: Object.keys(res.data)});
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
        const validador = [1,2,3,4,5];

        if(validador.includes(ii)){
        
            //setTran(ii);
            this.setState({
                tran: ii
            });
        }

        const _link = document.getElementsByClassName("nav-link");
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
        
        const bandera = e.tipo == "asignados" ? "personas_table" : "responsables_table";
        const new_persons_array = [];

        this.state[bandera].map((arr, i) => { //this.state._personas

            if(arr.idPersona != e.idPersona){
                new_persons_array.push(arr);
            }
        });

        this.setState({
            [bandera]: new_persons_array
        });
    }
    //-------------------
    collectHours = (e) => {

        //console.log(e);
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
        const self = this;

        //if(this.state.tipo_registro == 2){
            
            const archivosUsuarios = this.state.files.reduce((acc, i) => {

                if(i.idPersona in acc){
                    return {
                        ...acc,
                        [i.idPersona]: {
                            ...acc[i.idPersona],
                            [i.ramo]: {
                                nombre: i.nombreArchivo,
                                datos: i.datoArchivo
                            }
                        }
                    }
                } else{
                    return {
                        ...acc,
                        [i.idPersona]: {
                            [i.ramo]: {
                            nombre: i.nombreArchivo,
                            datos: i.datoArchivo
                            }
                        }
                    }
                }
            }, {});

            const uploadFile = this.insertIntoCloud(archivosUsuarios);
        //} //
        //-------------------
        //console.log(archivosUsuarios);
        //-------------------

        var sendData = new FormData(); //Necesario para poder trabajar con el objeto en el controlador.
        sendData.append("capacitacion", JSON.stringify(this.state._capacitacion)); //Convertir el objeto en cadena Json para covertirlo en Objeto en el controlador.
        sendData.append("sub_capacitacion", JSON.stringify(this.state._sub_capacitacion));
        sendData.append("ramos", JSON.stringify(this.state._ramos));
        sendData.append("personas", JSON.stringify(this.state.personas_table));
        sendData.append("tipo_registro", JSON.stringify(this.state.tipo_registro));
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

        if(this.state.tipo_registro == 2){
            sendData.append("filesPersons", JSON.stringify(archivosUsuarios));
        } else if(this.state.tipo_registro == 1){
            sendData.append("personasResposables", JSON.stringify({
                responsables: this.state.responsables_table,
                fechaParaCapacitacion: this.state.fechaCapacitacion
                }
                )
            );
        }

        axios.post(base_url+"capacita/registraDatosDeCapacitacion", sendData).then(function(res){
            
            //alert(res.data.mensaje);
            /*if(res.data.bool){
                //window.location.reload(base_url+"capacita/reporteDeCapacitacionManual");
                window.location.replace(base_url+"capacita/reporteDeCapacitacionManual");
            }*/           
            const response = res.data;
            self.generatePostResult(response);

        }). catch(function(error){
            
            alert(error);
            console.log(error);
        });
    }
    //-------------------
    generatePostResult = (data) => {

        //console.log(data);
        const hours = data.hours.map(arr => {
            return {
                category: arr.category,
                statusProgress: arr.bool ? "completado" : "fallido",
                colorProgress: arr.bool ? "success" : "danger"
            };
        });

        const relationship = data.hourCategoryRelationship.map(arr => {
            return {
                category: arr.category,
                statusProgress: arr.bool ? `completado` : `fallido`,
                colorProgress: arr.bool ? "success" : "danger"
            };
        });

        const creator = data.creator.map(arr => {
            return {
                statusProgress: arr.bool ? `completado` : `fallido`,
                colorProgress: arr.bool ? "success" : "danger",
                creator: arr.who
            }
        });

        const personN = data.persons.reduce((acc, curr) => {
            const getData = this.state.personas_table.filter(arr_ => arr_.idPersona == curr.idPersona);

            if(curr.idPersona in acc){

                return {
                    ...acc,
                    [curr.idPersona] : {
                        type: curr.band == 1 ? `interno` : `externo`,
                        person: getData[0].nombre,
                        statusProgressAttachment: [
                            ...acc[curr.idPersona].statusProgressAttachment,
                            {
                                bool: curr.extra ? true : false,
                                category: curr.category,
                                badge: curr.extra ? `success` : `danger`,
                            }
                        ],
                        statusProgress: [
                            ...acc[curr.idPersona].statusProgress,
                            {
                                bool: curr.register ? true : false,
                                category: curr.category,
                                badge: curr.register ? `success` : `danger`,
                            }
                        ]
                    }
                }
            } else{
                return {
                    ...acc,
                    [curr.idPersona] : {
                        type: curr.band == 1 ? `interno` : `externo`,
                        person: getData[0].nombre,
                        statusProgressAttachment: [
                            {
                                bool: curr.extra ? true : false,
                                category: curr.category,
                                badge: curr.extra ? `success` : `danger`,
                            }
                        ],
                        statusProgress: [
                            {
                                bool: curr.register ? true : false,
                                category: curr.category,
                                badge: curr.register ? `success` : `danger`,
                            }
                        ]
                    }
                }
            }
        }, {});

        this.setState({finishHours: hours});
        this.setState({finishCategory: relationship});
        this.setState({finishCreator: creator});
        this.setState({finishPersons: Object.values(personN)});
        this.setState({disabled: true});
        this.setState({showFinish: true});
        this.setState({showList: false});
        console.log(personN);
    }
    //-------------------
    insertIntoCloud = (imagesObjects) => {

        var storage = firebase.storage();
        var storageRef = storage.ref(); //"registroCapacitacionesExternas/"
        var contenedor = storageRef.child("registroCapacitacionesExternas");
        var rutaCapacitacion = this.state._capacitacion[0];
        var rutaSubCapacitacion = this.state._sub_capacitacion[0];
        
        var booleanUpload = [];//{};
        //console.log(this.state._capacitacion);

        for(var a in imagesObjects){
            
            var dataFiles = imagesObjects[a];

            for(var b in dataFiles){

                var uploadTask = contenedor.child(rutaCapacitacion.texto+"/"+rutaSubCapacitacion.texto+"/"+a+"/"+b+"/"+dataFiles[b].nombre).put(dataFiles[b].datos);

                uploadTask.on("state_changed",
                    function(snapshot){
                        
                        var progress = (snapshot.bytesTransferred / snapshot.totalBytes) * 100;
                        console.log(progress);

                    }, 
                    
                    function(error){
                        console.log(error.code);
                        //booleanUpload.push(false);
                        alert(error.code)
                        return;

                    }, 
                    
                    function(){
                        uploadTask.snapshot.ref.getDownloadURL().then(function(downloadURL){
                        })
                    }
                )
            }
        }

        return; //booleanUpload.includes(false) ? false : true;
    }
    //-------------------
    handleClickAreaRanking = () => {

        const select = document.getElementById("area");
        const selected_index = select.selectedIndex;
        const texto = select.options[selected_index].text;
        //const area_selected = 
        if(selected_index == 0){
            alert("Seleccione una opción valida");
            $("#modalPersona").modal("hide");
            return;
        }

        this.manageDataPersons(texto);
    }
    //-------------------
    handleClickResponsable = (e) => {

        this.manageDataPersons(e);
    }
    //-------------------
    manageDataPersons = (apuntador) => {

        this.setState({ranking_seleccionado: apuntador.toUpperCase()});
        const personas = this.state.personas;
        var _options_persona = [];

        for(var aa in personas){

            if(aa.toLowerCase() == apuntador.toLowerCase()){
                
                personas[aa].map((arr, i) => {
                        
                        const obj_persona = {};
                        obj_persona["idPersona"] = arr.idPersona;
                        obj_persona["nombre"] = arr.nombres+" "+arr.apellidoPaterno+" "+arr.apellidoMaterno;
                        obj_persona["correo"] = arr.email;
                        obj_persona["area_ranking"] = apuntador;

                        _options_persona.push(obj_persona);
                    }
                )
            } //
        }

        this.setState({personas_seleccionado: _options_persona});
    }
    //-------------------
    handleChangeCheckboxIdPersona = (a,e) => {

        ///console.log(e);
        const idPersona = e.target.value;
        const check = e.target.checked;
        //console.log(a);
        
        const bucketPersons = a == "asignados" ? "personas_checked" : "responsables";
        //personas_checked
        this.setState({[bucketPersons]: {
            ...this.state[bucketPersons],
            [idPersona]: check
        }});
    }
    //-------------------
    handleClickConfirmaPersonas = (a, e) => {

        const _personas_c = this.state.personas_seleccionado;
        const grupoPersonas = a == "asignados" ? "personas_checked" : "responsables";
        const _personas_checked = this.state[grupoPersonas]; //.personas_checked;
        const indicador = a == "asignados" ? "personas_table" : "responsables_table";
        const tabla_registros = this.state[indicador];
        const modal = "asignados" ? "modalPersona" : "modalResponsables";
        //console.log(tabla_registros);

        //Validar existencia de la persona en la tabla
        if(tabla_registros.length > 0){ //this.state.personas_table

            tabla_registros.map((arr, i) => { //this.state.personas_table
                
                for(var a_ in _personas_checked){

                    if(a_ == arr.idPersona){
                        alert("El usuario ya se encuentra seleccionado en la tabla");
                        delete _personas_checked[a_];
                    }
                }
            });
        }

        //Anexar a la persona en la tabla para capacitación.
        _personas_c.map((arr, i) => {

            for(var a_ in _personas_checked){

                if(_personas_checked[a_] && arr.idPersona.toLowerCase() == a_.toLowerCase()){
                    //console.log(_personas_checked[a]);
                    this.setState(
                        estadoPrevio => ({
                            [indicador]: [...estadoPrevio[indicador], arr] //personas_table //anterior en el spread operator personas_table
                        })
                    );
                }
            }
        });
        
        this.setState({[grupoPersonas]: []}); //personas_checked

        //console.log(this.state.personas_table);

        $(`#${modal} input[type='checkbox']`).prop('checked', false).change();
        $(`#${modal}`).trigger("reset");
        $(`#${modal}`).modal("hide");
    }
    //-------------------
    handleChangeTypeRegister = (e) => {

        const selectedIndex = e.target.selectedIndex;
        const valor = e.target.options[selectedIndex].value;
        //console.log(valor);

        if(selectedIndex == 0){
            alert("Selecciono una opción invalida. Seleccione entre interno y externo");
            return;
        }

        this.setState({
            tipo_registro: parseInt(valor)
        });
    }
    //-------------------
    seleccionarArchivoDeRamo = (e) => {

        //console.log(e);

        if(this.state.files.length > 0){

            var filterFiles = this.state.files.filter((arr) => arr.idPersona != e.fileInput.idPersona && arr.ramo != e.fileInput.ramo);
            console.log("filtrando...", filterFiles);
            /*this.setState({
                files: filterFiles
            });*/
            
        }
        this.setState({
            files: [
                ...this.state.files,
                e.fileInput
            ]
        });
    }
    //-------------------
    getInputDate = (e) => {

        //console.log(e.toLocaleDateString("en-US"));
        this.setState({
            fechaCapacitacion: String(e.toLocaleDateString("en-Us"))
        });
        //fechaCapacitacion
    }
    //-------------------
    showForm = (e) => {
        console.log("target", e);
        this.setState({showFinish: !e.bool});
        this.setState({showList: e.bool});
        this.setState({showFinishButton: e.bool});
    }
    //-------------------
    render(){
        //console.log(this.tipo_registro);
        //console.log(this.state.finishHours);
        const _submit = <div className="text-center">
            <button className="btn btn-success btn-sm mt-2 text-center" disabled={this.state.disabled}>Generar capacitación</button>
        </div>

        const state_persona = this.state.personas_table; //this.state._personas;
        const state_capacitacion = this.state._capacitacion;
        const state_sub_capacitacion = this.state._sub_capacitacion;
        const state_ramo = this.state._ramos;
        const disabled = this.state.disabled;

        return(
            <div>
            <ul className="nav nav-tabs" id="tab_c" role="tablist">
                <li className="nav-item">
                    <a className="nav-link active tab-select" id="t_capacitacion" href="#cpct" data-trs="1" data-toggle="tab" role="tab" aria-controls="cpct" aria-selected="true">Capacitación</a>
                </li>
                <li className="nav-item">
                    <a className="nav-link tab-select" id="t_sub-capacitacion" href="#sbcpct" data-trs="2" data-toggle="tab" role="tab" aria-controls="sbcpct" aria-selected="false">Sub-capacitacion</a>
                </li>
                <li className="nav-item">
                    <a className="nav-link tab-select" id="t_ramo" href="#rm" data-toggle="tab" data-trs="3" role="tab" aria-controls="rm" aria-selected="false">Ramos</a>
                </li>
                <li className="nav-item">
                    <a className="nav-link tab-select" id="t_persona" href="#prsn" data-toggle="tab" data-trs="4" role="tab" aria-controls="prsn" aria-selected="false  ">Personas</a>
                </li>
                <li className="nav-item">
                    <a className="nav-link tab-select" id="t_requisito" href="#req" data-toggle="tab" data-trs="5" role="tab" aria-controls="req" aria-selected="false">Requisitos</a>
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
                                    <button className="btn btn-primary btn-sm" onClick={this.anexaALista.bind(this, "capacitacion")} disabled={this.state.disabled}>Tomar</button>
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
                                    <button className="btn btn-primary btn-sm" onClick={this.anexaALista.bind(this, "sub_capacitacion")} disabled={this.state.disabled}>Tomar</button>
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
                                    <button className="btn btn-primary btn-sm" onClick={this.anexaALista.bind(this, "ramo")} disabled={this.state.disabled}>Agregar a la lista</button>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div id="prsn" className="tab-pane fade" role="tabpanel" aria-labelledby="t_persona">
                        <div className="card mt-3 mb-3">
                            <div className="card-header text-center">PERSONA</div>
                            <div className="card-body">
                                <label htmlFor="capacitacion">Seleccione una opción de ranking o área</label>
                                <select 
                                    name="area"
                                    id="area"
                                    className="form-control" 
                                >
                                    <option value="0">Seleccione</option>
                                    {   
                                        this.state.ranking_area.map((arr, i) =>

                                            <option value={i++} key={i}>{arr.toUpperCase()}</option>
                                        )
                                    }
                                </select>
                                <div className="mt-2 text-center">
                                    <button 
                                        className="btn btn-primary btn-sm"
                                        data-toggle="modal" 
                                        data-target=".bd-persona-modal-lg"
                                        onClick={this.handleClickAreaRanking.bind()}
                                        disabled={this.state.disabled}
                                    >
                                        Buscar personas
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div id="req" className="tab-pane fade" role="tabpanel" aria-labelledby="t_requisito">
                        <div class="card mt-3 mb-3">
                            <div class="card-header text-center">Requisito de registro</div>
                            <div class="card-body">
                                <label htmlFor="requisito">Seleccione un tipo de registro de capacitación</label>
                                <select disabled={this.state.disabled} name="tipo_registro" id="tipo_registro" className="form-control" onChange={this.handleChangeTypeRegister.bind(this)}>
                                    <option value="0">Seleccione</option>
                                    <option value="1">INTERNO</option>
                                    <option value="2">EXTERNO</option>
                                </select>
                                <div className="mt-4">
                                    {   
                                        this.state.tipo_registro == 1 && 
                                        <RegistroInterno 
                                            area_rank = {this.state.ranking_area}
                                            personas = {this.state.personas}
                                            seleccionaResponsable = {this.handleChangeCheckboxIdPersona.bind(this,"responsables")}
                                            confirmaResponsable = {this.handleClickConfirmaPersonas.bind(this, "responsables")}
                                            selectAreaRanking = {this.handleClickResponsable.bind(this)}
                                            getInputDate = {this.getInputDate.bind(this)}
                                        ></RegistroInterno>
                                    }
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div className="col-md-8 mt-3 mb-3">
                    <div className="card">
                        <div className="card-header text-center">Avance seleccionado</div>
                        {
                            this.state.showList && <div className="card-body form-progress">
                                                        <form onSubmit={this.sendPostData.bind(this)}>
                                                            <ListadoSeleccionado 
                                                                _c={this.state._capacitacion}
                                                                _s_c={this.state._sub_capacitacion}
                                                                _r={this.state._ramos}
                                                                _p={this.state.personas_table}//{this.state._personas}
                                                                _rp={this.state.responsables_table}
                                                                _t={this.state.tipo_registro}
                                                                _f={this.state.fechaCapacitacion}
                                                                removePerson={this.removePerson.bind(this)}
                                                                collectHours={this.collectHours.bind(this)}
                                                                selectedFile={this.seleccionarArchivoDeRamo.bind(this)}
                                                            ></ListadoSeleccionado>
                                                            {
                                                                state_capacitacion.length > 0 && state_sub_capacitacion.length > 0 && state_ramo.length > 0 && state_persona.length > 0 && (this.state.files.length > 0 || this.state.responsables_table.length > 0) ?
                                                                _submit
                                                                :
                                                                ""
                                                            }
                                                        </form>
                                                        { this.state.showFinishButton && <div className="text-center mt-4"><button className="btn btn-primary btn-sm" onClick={this.showForm.bind(this, {bool: false})}>Mostrar resultados</button></div> }
                                                    </div>
                        }
                        {
                            this.state.showFinish && <div className="card-body finish-progress">
                                                        <FinishedProgress
                                                            hours = {this.state.finishHours}
                                                            category = {this.state.finishCategory}
                                                            creator = {this.state.finishCreator}
                                                            persons = {this.state.finishPersons}
                                                            showForm = {this.showForm.bind(this)}
                                                        ></FinishedProgress>
                                                    </div>
                        }
                    </div>
                </div>
            </div>                
            <div class="modal fade bd-persona-modal-lg" id="modalPersona" tabindex="-1" role="dialog" aria-labelledby="LabelPersona" aria-hidden="true">
                <div class="modal-dialog modal-lg" role="document">
                    <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="LabelPersona">Listado de personas pertenecientes a área o ranking {this.state.ranking_seleccionado}</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body table responsive">
                        <form action="" id="form_personas">
                            <h6>Seleccione uno o varias personas para anexar al proceso de capacitación.</h6>
                            <br />
                            <table className="table table-sm">
                                <thead>
                                    <tr>
                                        <th className="text-center">Seleccionar</th>
                                        <th className="text-center">Nombre completo</th>
                                        <th className="text-center">Correo asignado</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    {
                                        this.state.personas_seleccionado.map((arr, i) =>

                                                <tr>
                                                    <td className="text-center"><input key={i} type="checkbox" name={"personaSeleccionada_"+this.state.ranking_seleccionado.replace(" ","_").toLowerCase()+"[]"} id={"check_"+arr.idPersona} value={arr.idPersona} onChange={this.handleChangeCheckboxIdPersona.bind(this,"asignados")}/></td>
                                                    <td>{arr.nombre}</td>
                                                    <td>{arr.correo}</td>
                                                </tr>
                                        )
                                    }
                                </tbody>
                            </table>
                        </form>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary btn-sm" data-dismiss="modal">Close</button>
                        <button type="button" class="btn btn-primary btn-sm" onClick={this.handleClickConfirmaPersonas.bind(this, "asignados")}>Seleccionar personas</button>
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
    //------------------------
    const handleChangeFile = (e) => {

        const id = e.target.id;
        const ramoFile = id.split("-");

            props.selectedFile({
                fileInput:{
                    ramo: ramoFile[1],
                    idPersona: ramoFile[2],
                    nombreArchivo: e.target.files.length > 0 ? e.target.files[0].name : null,
                    datoArchivo: e.target.files.length > 0 ? e.target.files[0] : null,
                    activo: true
                }
            });
    }
    //------------------------

    var d_true = 0;
    var array_ramos_ = [];
    var filesRamos = [];
    const iterador = props._r[0];

    for(var a in iterador){
        //console.log(iterador[a]);
        if(iterador[a]){
            d_true++;

            filesRamos.push(a);

            const rr = <div className="form-group row">
                <label htmlFor={a} class="col-md-3 col-form-label">{a.replace("danios", "daños").toUpperCase()}</label>
                <div className="col-md-3">
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
    const deletePerson = (e, i, a) => {
        //e es el idPersona
        a.preventDefault();
        props.removePerson({
            idPersona: e,
            tipo: i
        });
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
                        <th>Area o ranking</th>
                        <th>Opciones</th>
                    </tr>
                </thead>
                <tbody>
                    {
                        props._p.map((arr, i) => 
                            <tr key={i}>
                                <td className="text-center"><input type="checkbox" name="persona_capacitacion[]" id={"p"+arr.idPersona} checked disabled value={arr.idPersona}/></td>
                                <td>{arr.nombre}</td>
                                <td>{arr.correo}</td>
                                <td>{arr.area_ranking}</td>
                                <td className="text-center">
                                    <a href="javascript: void(0)" className="text-danger ml-4" onClick={deletePerson.bind(this, arr.idPersona, "asignados")}>
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
    //-----------------------------------------
    const cont_rp = props._rp.length > 0 ? <div className="card-body">
        <h6><span class="badge badge-secondary">Paso 5</span> Responsable asignado</h6>
        <p>Fecha de alta de capacitación {props._f}</p>
        <div className="table-responsive mt-3">
            <table className="table table-sm">
                <thead>
                    <tr>
                        <th>Responsable</th>
                        <th>Nombre</th>
                        <th>Correo</th>
                        <th>Area o ranking</th>
                        <th>Opciones</th>
                    </tr>
                </thead>
                <tbody>
                    {
                        props._rp.map((arr, i) => 
                            <tr key={i}>
                                <td className="text-center"><input type="checkbox" name="persona_capacitacion[]" id={"p"+arr.idPersona} checked disabled value={arr.idPersona}/></td>
                                <td>{arr.nombre}</td>
                                <td>{arr.correo}</td>
                                <td>{arr.area_ranking}</td>
                                <td className="text-center">
                                    <a href="javascript: void(0)" 
                                        className="text-danger ml-4" 
                                        onClick={deletePerson.bind(this, arr.idPersona,"responsables")}>
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
    //-----------------------------------------

    const fileUploadForPerson = props._p.length > 0 ? <div className="card-body">
            <h6><span class="badge badge-secondary">Paso 5</span> Requerimiento de documentación</h6>
            <div>
                {
                    props._p.map((arr, i) =>
                    <div>
                        <div className="row mt-3">
                            <div className="col-md-6">{arr.nombre}</div>
                            <div className="col-md-3"><button className="btn btn-info btn-sm" data-toggle="collapse" data-target={"#collapse-"+arr.idPersona} aria-expanded="false" aria-controls={"collapse-"+arr.idPersona} onClick={(e) => {e.preventDefault()}}>Subir archivos</button></div>
                        </div>
                        <div className="collapse mt-3" id={"collapse-"+arr.idPersona}>
                            <p>Realiza la carga de archivos que corrobore la capacitación del colaborador.</p>
                            <div className="card-body">
                                {
                                    filesRamos.map((arr_, i) => 

                                        <div>
                                            <div className="row mt-3">
                                                <div className="col-md-4">{arr_.replace("danios","daños").toUpperCase()}</div>
                                                <div className="col-md-8">
                                                    <div class="custom-file">
                                                        <input type="file" className="custom-file-input" id={"file-"+arr_+"-"+arr.idPersona} lang="es" name={"file-"+arr_+"-"+arr.idPersona} required 
                                                            onChange={handleChangeFile.bind(this)}
                                                        />
                                                        <label htmlFor={"file-"+arr_+"-"+arr.idPersona} className="custom-file-label">Seleccione un archivo</label>
                                                    </div>
                                                </div>
                                            </div>
                                            <hr />
                                        </div>)
                                }
                            </div>
                        </div>
                        <hr />
                    </div> )
                }
            </div>
        </div> : "";
    //---------------------
    return(
       <div>
           {cont_c}
           {cont_s_c}
           {cont_r}
           {cont_p}
           {
               props._t == 2 ? fileUploadForPerson : cont_rp
           }
       </div>
    )
}
//--------------------------------------
const RegistroInterno = (props) => {

    const [startDate, setStartDate] = useState(new Date());
    var divs_personas = [];
    const personas = props.personas;

    //------------------------
    const seleccionaResponsable_ = (e) => {

        props.seleccionaResponsable(e);
    }
    //------------------------
    const confirmarResponsables = (e) => {
        props.confirmaResponsable(e);
        $(`#modalResponsables input[type='checkbox']`).prop('checked', false).change();
        $(`#formResponsable`).trigger("reset");
        $(`#modalResponsables`).modal("hide");
    }
    //------------------------
    const selectAreaRanking_ = (e) => {

        props.selectAreaRanking(e.target.getAttribute("data-area"));
    }
    //------------------------
    const getInputDate_ = () => {

        props.getInputDate(startDate);
    }
    //------------------------
    for(var a in personas){

        const divHijo = <div className={"h-25 tab-pane fade" + (a == "BRONCE" ? "show active" : "") + ""}  id={"list-"+a.replace(" ", "_").toLowerCase()} role="tabpanel" aria-labelledby={"list-"+a.replace(" ","_").toLowerCase()+"-list"}>
            <div className=" h-25 table-responsive">
                <table className="table table-sm">
                    <thead>
                        <tr>
                            <th>Responsabilizar</th>
                            <th>Nombre</th>
                            <th>Correo</th>
                        </tr>
                    </thead>
                    <tbody>
                        {
                            personas[a].map((arr_, a) => 
                            <tr>
                                <td className="text-center">
                                    <input type="checkbox" name="responsable[]" id={"responsable_"+arr_.idPersona} value={arr_.idPersona} onChange={seleccionaResponsable_.bind(this)}/>
                                </td>
                                <td>{arr_.nombres+" "+arr_.apellidoPaterno+" "+arr_.apellidoMaterno}</td>
                                <td>{arr_.email}</td>
                            </tr> )
                        }
                    </tbody>
                </table>
            </div>
        </div>

        divs_personas.push(divHijo);
    }

    return(
        <div className="card card-body">
            <p>Ingrese los datos requeridos para el registro de capacitación</p>
            <p>Fecha de alta de capacitación</p>
            <div className="row">
                <div className="col-md-3"><label htmlFor="datepicker">Fecha: </label></div>
                <div className="col-md-8"><DatePicker placeholderText="Ingrese una fecha" dateFormat="yyyy/MM/dd" selected={startDate} onChange={(date) => setStartDate(date)} /></div>
            </div>
            <div className="mt-3 text-center"><button className="btn btn-info btn-sm" onClick={getInputDate_.bind()}>Tomar fecha</button></div>
            <hr />
            <p>Click al siguiente boton para seleccionar a un responsable de la capacitación <button className="btn btn-primary btn-sm" data-toggle="modal" data-target=".bd-responsable-modal-lg">Buscar</button> </p>
            <div className="modal fade bd-responsable-modal-lg" id="modalResponsables" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabelxd" aria-hidden="true">
                <div className="modal-dialog modal-lg">
                    <div className="modal-content">
                        <div className="modal-header"><h5>Seleccione a un responsable de la capacitación</h5>
                            <button type="button" className="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <div className="modal-body">
                            <form id="formResponsable">
                                <div className="row">
                                    <div className="col-md-4 h-50">
                                        <div class="list-group" id="list-tab" role="tablist">
                                            {
                                                props.area_rank.map((arr, i) => 
                                                    <a 
                                                        class={"list-group-item list-group-item-action " + (arr == "BRONCE" ? "active" : "") +"" } 
                                                        id={"list-"+arr.replace(" ","_").toLowerCase()+"-list"}  
                                                        data-toggle="list" href={"#list-"+arr.replace(" ", "_").toLowerCase()} 
                                                        role="tab" aria-controls={arr.replace(" ", "_").toLowerCase()}
                                                        data-area = {arr.toLowerCase()}
                                                        onClick = {selectAreaRanking_.bind(this)}
                                                    >{arr.toUpperCase()}
                                                    </a>
                                                )
                                            }
                                        </div>
                                    </div>
                                    <div className="col-md-8 h-50">
                                        <div className="tab-content" id="nav-tabContent">
                                            {
                                                divs_personas
                                            }
                                        </div>
                                        <div className="modal-footer">
                                            <button type="button" class="btn btn-primary" onClick={confirmarResponsables.bind(this)}>Seleccionar responsables</button>
                                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
                                        </div>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    )
}
//-------------------------------------
const FinishedProgress = (props) => { 

    const activateButton = (e) => {

        props.showForm({bool: true});
    }

    return(
        <div>
            <div className="block-hour mb-4 border-bottom">
                {
                    props.hours.length > 0 ? props.hours.map(arr => <div className="row">
                        <div className="col-md-12">
                            <p>{arr.category.toUpperCase() + " - "} Registro de hora: <span className={"text-" + arr.colorProgress}>{arr.statusProgress}</span></p>
                        </div>
                        </div> ) :
                        <div className="col-md-12">
                            <p className="text-danger">Registro de hora: interrumpido</p>
                        </div>
                }
            </div>
            <div className="block-category mb-4 border-bottom">
                {
                    props.category.length > 0 ?  props.category.map(arr => <div className="row">
                        <div className="col-md-12">
                            <p>{arr.category.toUpperCase() + " - "} Creación de relación de la hora con el ramo: <span className={"text-" + arr.colorProgress}>{arr.statusProgress}</span></p>
                        </div>
                        </div> ) :
                    <div className="col-md-12">
                        <p className="text-danger">Proceso interrumpido en creación de relación de la hora con el ramo</p>
                    </div>
                }
            </div>
            <div className="block-creator mb-4">
                {
                    props.creator.length > 0 ? <div className="row">
                                                    <div className="col-md-12">
                                                            <p>Asignación del registro al creador ({props.creator[0].creator}): <span className={"text-" + props.creator[0].colorProgress}>{props.creator[0].statusProgress}</span></p>
                                                    </div>
                                                </div> :
                                                <div className="col-md-12">
                                                    <p className="text-danger">Asignación del registro al creador: interrumpido</p>
                                                </div>
                }
              
            </div>
            <div className="block-persons table-responsive">
                {
                    props.persons.length > 0 ? 
                    <table class="table table-sm">
                        <thead>
                            <tr className="text-center">
                                <th>Nombre</th>
                                <th>Anexos</th>
                                <th>Registro</th>
                            </tr>
                        </thead>
                        <tbody>
                            {
                                props.persons.map(arr => <tr>
                                    <td >{arr.person}</td>
                                    <td>
                                        {
                                            arr.statusProgressAttachment.map(arr_ => <div><p>{arr_.category.toUpperCase() + ":"} <span className={"text-" + arr_.badge}>{(arr_.bool ? "completado" : "fallido")}</span></p></div> )
                                        }
                                    </td>
                                    <td>
                                        {
                                            arr.statusProgress.map(arr_ => <div><p>{arr_.category.toUpperCase() + ":"} <span className={"text-" + arr_.badge}>{(arr_.bool ? "completado" : "fallido")}</span></p></div> )
                                        }
                                    </td>
                                </tr> )
                            }
                        </tbody>
                    </table> :
                    <div className="col-md-12">
                        <p className="text-danger">Proceso de asignación a las personas solicitadas ha sido interrumpido</p>
                    </div>
                }
            </div>
            <div className=" row text-center">
                <div className="col-md-6"><button className="btn btn-primary btn-sm" onClick={activateButton.bind(this)}>Regresar al formulario</button></div>
                <div className="col-md-6"><a href="javascript: void(0)" onClick={() => {
                    const base_url = window.jQuery("#base_url").data("url");
                    window.location.href = base_url+"capacita/reporteDeCapacitacionManual";
                }} class="btn btn-primary btn-sm">Finalizar</a></div>
            </div>
        </div>
    )
}
//-------------------------------------
export default Contenedor;