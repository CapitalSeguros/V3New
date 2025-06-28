import React from "react";
import ReactDOM from "react-dom";
import axios from "axios";

const Select = (props) => {

    //console.log(props.arreglo);

    return(

        <select name={props.a} id={props.a} className="form-control">
            <option value="0">Seleccione</option>
            {
                props.arreglo.map((arr, i) => {
                   
                    if(props.a == "persona"){

                        return <option value={arr.idPersona} key={i}>{arr.nombres}</option>;
                    } else if(props.a == "capacitacion"){

                        return <option value={arr.id_capacitacion} key={i}>{arr.nombre_capa.toUpperCase()}</option>;
                    }
                })
            }
        </select>
    );

}

export default Select;

/*export default class Select extends React.Component{
    
    state = {
        capacitaciones:[],
    }

    async componentDidMount(){
        const url = document.getElementById("base_url").getAttribute("data-url");
        const res = await axios.get(url+"capacita/obtenerCapacitaciones",{
            params:{
                a: 0
            }
        });

        this.setState({capacitaciones: res.data});
        console.log(this.state.capacitaciones);
    }

   render(){
    return(

        <select name="capacitaciones" id="capacitaciones" className="form-control">
            <option value="0">Seleccione</option>
            {
                this.state.capacitaciones.map(c =>
                    <option value={c.id_capacitacion}>{c.tipoCapacitacion.toUpperCase()}</option>
                )
            }
        </select>
        
    )
   }
}*/
