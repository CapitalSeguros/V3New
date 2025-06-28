import React from "react";
import ReactDOM, { render } from "react-dom";
import Select  from "../Capacitacion/Select.jsx";

//import { render } from "react-dom";

//Combo de personal asignado.
const Card = function(props){

//function tomar(){
    function subCapacitacionesClick(e){

        e.preventDefault();
        const valor_select = document.querySelector("#capacitaciones option:checked");
       //alert(valor_select);
        
       ReactDOM.render(
        <Card titulo={valor_select.textContent}></Card>,
        document.getElementById("contenedor_subcapacitacion")
       );
    }
//}

    return (
        //<div className="col-md-4">
            <div className="card">
                <div className="card-header text-center">{props.titulo}</div>
                <div className="card-body">
                    <div className="text-center">
                        <Select></Select>
                        <br />
                        <button className="btn btn-primary btn-sm" onClick={subCapacitacionesClick}>Tomar</button>
                    </div>
                </div>
            </div>
        //</div>
    );
}

export default Card;
