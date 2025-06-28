import { setNestedObjectValues } from "formik";
import React,{ useState } from "react";
import ReactDOM from "react-dom";
import Option from "./Option.jsx"
//import ListaChecbox from "./ListaChecbox.jsx";
import Select from "./Select.jsx";

const ContenedorOpciones = (props) => {

    const nombre = (props.aria_lby).replace("t_","").replace("capacitacion", "capacitación");
    const atributo_array = props.parametro_array; 
    const paso = (props.aria_lby).replace("t_","");
    const [acarreo, setAcarreo] = useState({});
    const [pinta, setPinta] = useState(false);

    /*const tomarSeleccion = (e) => {
        setAcarreo({
            id: e.target.value,
            nombre: e.target.options[e.target.selectedIndex].text
        });
    }*/

    //const pp = [];

    const agregaALista = (e, a) => {

        const _option = window.jQuery("#"+e).prop("selectedIndex");
        //console.log(_option);

        if(_option == 0){
            alert("No se selecciono "+ nombre);
            return;
        }

        setAcarreo({
            id: _option,
        });

    }

    console.log(acarreo);

    return(

        <div id={props.id_tab} className={props.clase} role="tabpanel" aria-labelledby={props.aria_lby}>
            <div className="row">
                <div className="col-md-4 mt-4">
                    <div className="card">
                        <div className="card-header text-center">{nombre.toUpperCase()}</div>
                        <div className="card-body">
                            <label htmlFor={(props.aria_lby).replace("t_","")}>Seleccione una opción de la lista</label>
                                {
                                    paso == "capacitacion" || paso == "persona" ? <Select a={paso} arreglo={atributo_array}></Select>
                                    : <ListaCheckbox></ListaCheckbox>
                                }
                                <div className="mt-2 text-center">
                                    <button className="btn btn-primary btn-sm" onClick={agregaALista.bind(this, paso)}>Tomar</button>
                                </div>
                        </div>
                    </div>
                </div>
                <div className="col-md-8 mt-4">
                    <div className="card">
                        <div className="card-header text-center">Avance seleccionado</div> 
                        <div className="card-body">
                            {
                             
                            }
                        </div>
                    </div>                
                </div>
            </div>
        </div>
    );
}

const ListaCheckbox = () => {

    console.log();

    return(

        <div className="card-body border border-info">
            {

            }
        </div>

    );

}

export default ContenedorOpciones;