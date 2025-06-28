import React from "react";
import ReactDOM from "react-dom";
import { FontAwesomeIcon } from '@fortawesome/react-fontawesome';
//import { faTrash } from '@fortawesome/free-solid-svg-icons'
import axios from "axios";

export default class Categoria extends React.Component{

    constructor(props){
        super(props);
        this.state ={
            categorias: []
        };

        this.obtenerCategorias = this.obtenerCategorias.bind(this);
    }

    componentDidMount = () => {
        this.obtenerCategorias();
    }

    obtenerCategorias = async () => {

        const base_url = window.jQuery("#base_url").data("url");
        const categorias = await axios.get(base_url+"capacita/gestionCapacitacion", {
            params: {
                a: "categorias"
            }
        },[]);

        const _categorias = {};
        const array_categorias = [];

        categorias.data.map((arr, i) => {

            _categorias[arr.id_capacitacion] = {
                nombre: arr.tipoCapacitacion,
                sub_capacitacion: [ ..._categorias[arr.id_capacitacion].sub_capacitacion[0] ,{
                    //...arr.id_capacitacion.sub_capacitacion,
                    id_sub_capacitacion: arr.id_certificado,
                    nombre_sub_capacitacion: arr.nombreCertificado
                }]
            }

            //console.log(_categorias[1].sub_capacitacion);
        });

        array_categorias.push(_categorias);

        console.log(_categorias);
    }

    render(){
        return(
            <h5>Hola mundo</h5>
        )
    }
}