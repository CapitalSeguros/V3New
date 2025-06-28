import React,{ useState } from "react";
import ReactDOM from "react-dom";

class ContenedorObjeto extends React.Component{

    constructor(props){
        super(props);
        this.state = {
            acarreo: [],
            temporal: [],
            sub_capa:[
                {
                    1:[
                        {
                            id_certificado: 1,
                            nombreCertificado: "LEGAL"
                        },
                        {
                            id_certificado: 2,
                            nombreCertificado: "CONDICIONES GENERALES"
                        }
                    ],
                    2:[
                        {
                            id_certificado: 11,
                            nombreCertificado: "DESARROLLO PROFESIONAL"
                        }
                    ]
                }
            ],
        }
    }

    componentDidMount = () => {

        this.setState({
            acarreo: "Hola"
        });
    }

    handleCheck = (pp, aa) => {

        //console.log(aa);
    }

    agregaALista = (e) => { //Evento del boton

        e.preventDefault();
        
        this.props.obtenerOpciones(this.state.temporal);
      
    }

    render(){
        const paso = (this.props.titulo).replace("t_","");
        //console.log(this.props.acumulado);
        return(

            <div className="card mt-4">
                <div className="card-header text-center">{(this.props.titulo).replace("t_","").toUpperCase()}</div>
                <div className="card-body">
                    <div className="card-body border border-info">
                        {
                           
                        }
                    </div>
                    <div className="mt-2 text-center">
                      <button className="btn btn-primary btn-sm" onClick={this.agregaALista.bind(this)}>Tomar</button>
                    </div>
                </div>
            </div>
        )
    }
}
//---------------
/*class ListaCheckbox extends React.Component{

    render(){
        console.log(this.props._elements);
        return(

            <div className="card-body border border-info">
                {
                    this.props._elements.length > 0 ? 
                        console.log(this.props._elements[0].capacitacion.value)
                       //console.log(this.props._estado[0][this.props._elements[0].capacitacion.value]) //this.props._elements[0].capacitacion.value
                    : ""
                }
            </div>

        );
    }
}*/
export default ContenedorObjeto;