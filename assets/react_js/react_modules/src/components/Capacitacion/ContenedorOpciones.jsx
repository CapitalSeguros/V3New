import { setNestedObjectValues } from "formik";
import React,{ useState } from "react";
import ReactDOM from "react-dom";
//import ListaChecbox from "./ListaChecbox.jsx";

export default class ContenedorOpciones extends React.Component{

    constructor(props){
        super(props);
        this.agregaALista = this.agregaALista.bind(this);
        this.handleOnChange = this.handleOnChange.bind(this);
        this.handleCheck = this.handleCheck.bind(this);
    }

    state = {
        parametros: [],
        enListar: [],
        submit: [],
        temporal: []

    }

    //Pasar parametro de objeto al estado de la clase.
    componentDidMount = () => {

        const paso = (this.props.aria_lby).replace("t_","");
        var pushear = [];

        console.log(this.props.parametro_array);

        this.props.parametro_array.map(pr => {

            var _id = "";
            var _nombre = "";

            switch(paso){
                case "persona": _id = pr.idPersona; _nombre = pr.nombres;
                break;
                case "capacitacion": _id = pr.id_capacitacion; _nombre = pr.nombre_capa;
                break;
                case "sub-capacitacion": _id = pr.id_capacitacion; _nombre = pr.nombre_capa;
                break;
                case "ramo": _id = pr.idR; _nombre = pr.nombre_ramo;
                break;
            }

            pushear.push(
                {
                    id : _id,
                    nombre_opcion: _nombre
                }
            )
        });

        this.setState({
            parametros: pushear
        })
    }

    handleOnChange = (pp, aa) => {

        this.setState({
            temporal: aa /*{
                [pp]: aa
            }*/
        });
        //console.log(aa);
    }

    handleCheck = (pp, aa) => {

        //console.log(aa);
    }

    agregaALista = (e) => { //Evento del boton

        e.preventDefault();
        this.props.obtenerOpciones(this.state.temporal);      
    }

    render(){
        const paso = (this.props.aria_lby).replace("t_","");
        //console.log(this.state.parametros);
        return(
            <div className="card mt-4 mb-3">
                <div className="card-header text-center">{(this.props.aria_lby).replace("t_","").toUpperCase()}</div>
                <div className="card-body">
                    <label htmlFor={(this.props.aria_lby).replace("t_","")}>Seleccione una opción de la lista</label>
                    {   
                        paso == "capacitacion" || paso == "persona" ?
                            <Select id={(this.props.aria_lby).replace("t_","")} _elements={this.state.parametros} handleOnChange={this.handleOnChange.bind(this, paso)}></Select>
                        :
                            <ListaCheckbox _id={paso} _elements={this.state.parametros} handleCheck={this.handleCheck.bind(this, paso)}></ListaCheckbox>
                    }
                    <div className="mt-2 text-center">
                      <button className="btn btn-primary btn-sm" onClick={this.agregaALista.bind(this)}>Tomar</button>
                    </div>
                </div>
            </div>
        )
    }
}

//----------------
class Select extends React.Component{

    handleChange = (e) => {

        const option_selected = {
            value: e.target.selectedIndex,
            text: e.target.options[e.target.selectedIndex].text
        }
        //console.log(option_selected);
        this.props.handleOnChange(option_selected);
    }

    render(){

        //console.log(this.props._elements);
        const opp = this.props._elements;

        return(
            
            <select name={this.props.id} id={this.props.id} className="form-control" onChange={this.handleChange.bind(this)}>
                <option value="0">Seleccione</option>
                {   
                    
                    opp.map((pp, i) => 
                        <option value={pp.id} key={i}>{pp.nombre_opcion.toUpperCase()}</option>
                    )
                }
            </select>
            
        );
    }

}
//---------------
class ListaCheckbox extends React.Component{

    render(){
        //console.log(this.props._id);
        return(

            <div className="card-body border border-info">
                {
                    this.props._elements.map((_e, i) =>

                        <div className="form-check" key={i}>
                            <input className="form-check-input" type="checkbox" name={this.props._id+"[]"} id={this.props._id} value={_e.id}/>
                            <label className="form-check-label" htmlFor={_e.nombre_opcion}>{_e.nombre_opcion.toUpperCase()}</label>
                        </div>
                    )
                }
            </div>

        );
    }

}
//---------------
/*class ListaSeleccion extends React.Component{

    render(){
        //console.log(this.props.seleccion);
        return(
           this.props.seleccion.map((arr, i) =>

               <div className="card" key={i}>
                   <div className="card-header">{arr.capacitacion.text}</div>
               </div>
           )
        )
    }

}*/

