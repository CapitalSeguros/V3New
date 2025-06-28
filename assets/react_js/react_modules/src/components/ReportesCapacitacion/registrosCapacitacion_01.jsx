import React from "react";
import ReacDOM from "react-dom";
import axios from "axios";
import TableRegister from "../ReportesCapacitacion/TablaRegistros.jsx";
import CapacitacionPersona from "../ReportesCapacitacion/CapacitacionPersona.jsx";
class PanelCapacitacion extends React.Component{

    constructor(props){
        super(props);

        this.state = {
            capacitaciones: [],
            objeto_modal: [],
            titulo_modal: "",
            persona_modal: ""
        }

        this.obtenerRegistrosCapacitacion = this.obtenerRegistrosCapacitacion.bind(this);
        this.handleClickDetalle = this.handleClickDetalle.bind(this);
        this.removeRow = this.removeRow.bind(this);
    }

    //----- //Al cargar la página (renderizado).
    componentDidMount = () => {
        this.obtenerRegistrosCapacitacion();
    }
    //------------
    obtenerRegistrosCapacitacion = () => {

        const tiempo = new Date();

        const base_url = document.getElementById("base_url").getAttribute("data-url");
        axios.get(base_url+"capacita/obtenerSeguimientoCapacitacion", {
            params: {
                mes: tiempo.getMonth()+1
            }
        }).
        then(res => {
            this.setState({capacitaciones: res.data});
        })
        //console.log(base_url);
    }
    //------------
    handleClickDetalle = (e) => {

        //console.log("padre "+e);
        this.setState({persona_modal: e});

        const _capacitaciones = this.state.capacitaciones;

        for(var a in _capacitaciones){
            for(var b in _capacitaciones[a]){
                if(b == e){
                    this.setState({objeto_modal: _capacitaciones[a][b].datosCapacitacion});
                    this.setState({titulo_modal: _capacitaciones[a][b].datosPersona.nombres+" "+_capacitaciones[a][b].datosPersona.apellidoPaterno+" "+_capacitaciones[a][b].datosPersona.apellidoMaterno})
                }
            }
        }

    }
    //------------
    removeRow = (e) => {

        console.log(e);
        const base_url = document.getElementById("base_url").getAttribute("data-url");
        axios.get(base_url+"capacita/eliminarRegistro", {
            params: {
                id: e
            }
        }).then(res => {
            alert(res.data.mensaje);

            if(res.data.bool){
                this.obtenerRegistrosCapacitacion();
                //this.setState({objeto_modal: []});
                $("#exampleModal").modal("hide");
            }

            console.log(res.data);
        })
    }
    //------------
    render(){
        //console.log(this.state.objeto_modal);

        const registros = this.state.capacitaciones;
        const cards = [];

        for(var a in registros){

            const card = <div className="card mt-3">
                <div className="card-header">{a}</div>
                <div className="card-body">
                    <TableRegister 
                        datos={registros[a]}
                        handleClickDetalle={this.handleClickDetalle.bind(this)}
                    ></TableRegister>
                </div>
            </div>

            cards.push(card);
        }

        return(

            <div className="card-body">
                <h6>{this.props.titulo}</h6>
                {
                    cards
                }
                <div className="modal fade bd-detalle-modal-lg" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                <div className="modal-dialog modal-lg" role="document">
                    <div className="modal-content">
                    <div className="modal-header">
                        <h6 className="modal-title" id="exampleModalLabel">{this.state.titulo_modal}</h6>
                        <button type="button" className="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div className="modal-body">
                       <CapacitacionPersona 
                            data={this.state.objeto_modal}
                            idPersona={this.state.persona_modal}
                            removeRow={this.removeRow.bind(this)}
                       ></CapacitacionPersona>
                    </div>
                    <div className="modal-footer">
                        <button type="button" className="btn btn-secondary" data-dismiss="modal">Close</button>
                    </div>
                    </div>
                </div>
                </div>
            </div>
            
        )
    }
}

export default PanelCapacitacion;
