import React, {useState} from "react";
import '../components/estilos.css';
    
export default function Respuesta (data) {
    const [Data]=useState(data.data);
    const [Tipo]=useState(data.tipo);
    //const [Ponderacion,setPonderacion]=useState(data.ponderacion);

    function renderdata(tipo){
        console.log('Respuesta component',Tipo);
        switch (tipo) {
        case 'TEXT':
          return <input placeholder="Respuesta corta" className="form-control" type="text" disabled/>;
        case 'TEXTAREA':
          return <textarea placeholder="Respuesta larga" className="form-control" disabled></textarea>;
        case 'SELECT':
            return (<><ol>
                {Data&&Data.split(/\r?\n/).map((item,i)=>{
                    return(
                        <>
                            <li className="lista-izquierda" key={i}>{item}</li>
                        </>
                    )
                })}
                </ol>
              </>);
        case 'MULTIPLETEXT':
            return (
                <>
                    lol
                </>
            );
        default:
          return  (
            <>
            {Data&&Data.split(/\r?\n/).map((item,i)=>{
                return(
                    <>
                    <input disabled key={i} type={tipo}/>{item}
                    </>
                )
            })}
          </>
          )
        }
    }

    return(
        <>
             {renderdata(Tipo)}
        </>
    )
};

