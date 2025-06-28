import React, { useState } from "react";
import ReactDOM from "react-dom";

const ListaChecbox = (props) => {

    const [parametro, setParametro] = useState(props.parametro_array);
    const [sub_capacitacion,setSub_capacitacion] = useState(
        {
            1:[{
                    id: 1,
                    sub_capa: "legal"
                },
                {
                    id: 2,
                    sub_capa: "siniestros"
                },
            ],
            2: [{
                id: 1,
                sub_capa: "desarrollo profesional"
            }]
        }
    );

    console.log(props.parametro_array);

    return(
        <div className="border border-info">
            {/*
                props.parametro_array.map((arr, i) => 
                    
                    <div key={i}>
                        <div className="form-check mb-2 ml-2">
                            <input type="checkbox" className="form-check-input" id={"sub" + arr.id_capacitacion} value={arr.id_capacitacion} />
                            <label className="form-check-label" htmlFor={"sub" + arr.id_capacitacion}>{arr.nombre_capa.toUpperCase()}</label>
                        </div>
                    </div>
                )*/
            }
        </div>     
    );
}

export default ListaChecbox;