import React from "react";
import ReactDom from "react-dom";


class TableRegister extends React.Component{
    constructor(props){
        super(props);
        this.state = {

        }

        this.handleClickPerson = this.handleClickPerson.bind(this);
    }
    //-------------------------
    handleClickPerson = (a, e) => {

        //console.log(a);
        this.props.handleClickDetalle(a);

    }
    //-------------------------
    render(){
        //console.log(this.props.datos);
        const data = this.props.datos;
        const _tr = [];

        for(var a in data){

            const d_persona = data[a].datosPersona;
            //console.log(d_persona.nombres);

            const tr_td = <tr>
                <td>{d_persona.nombres+" "+d_persona.apellidoPaterno+" "+d_persona.apellidoMaterno}</td>
                <td>{d_persona.username}</td>
                <td className="text-center"><button type="button" class="btn btn-link btn-sm" data-toggle="modal" data-target=".bd-detalle-modal-lg" onClick={this.handleClickPerson.bind(this, a)}>Ver detalle</button></td>
            </tr>;

            _tr.push(tr_td);
        }
        return(

            <table className="table table-sm">
                <thead>
                    <tr>
                        <th class="text-center">Nombre</th>
                        <th class="text-center">Correo</th>
                        <th class="text-center">Opciones</th>
                    </tr>
                </thead>
                <tbody>
                    { _tr}
                </tbody>
            </table>

        )
    }

}

export default TableRegister;