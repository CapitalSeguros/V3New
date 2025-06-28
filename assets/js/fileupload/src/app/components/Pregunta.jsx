import React,{useState,useEffect}from 'react';
import PropTypes, { array } from 'prop-types';
import axios from 'axios';
import slug from 'slug';

function Pregunta (props) {
    const path = window.jQuery("#base_url").attr("data-base-url");
    const {postFiles,getFiles} = props;
    const [pregunta,setPregunta]=useState();
    const [value,setValue]=useState(null);
    const [Respuesta, setResp] = useState('');
    const [Tipo, setTipo] = useState();
    const [tipoPregunta,setTipoPreguntas] = useState([]);
    const [Filas,setFilas]= useState([]);
    const [required,SetRequiered]=useState(false);
    const [validate,setvalidate]=useState();
    const [shareState,setShareState]=useState();
    
    const [editing, setEditing] = useState(false);
    const [editpet,setEditPet]=useState('');
    const [idstate,setIdstate]=useState();
    const [idPre,setIdpreg]=useState('');
    const[Axiosp,setAxiosP]=useState();
    const letras=['A','B','C','D'];
    //let id='45';
    //
    useEffect(() => {
        
        if(tipoPregunta.length == 0){
            axios.get(`${path}Preguntas/getTipoPregunta`)
            .then(response => {
                setTipoPreguntas(response.data.data)
            })
            .catch(err => console.log(err));
        }


        if(idstate!=undefined){
            axios.get(idstate)
            .then(function (response) {
                //console.log(response.data[0]);
                let nombre=response.data[0].titulo;
                let letra='A';
                setPregunta(response.data[0].titulo);
                setTipo(response.data[0].clave);
                setEditPet('Editar');
                //console.log(response.data[0].clave);
                setIdpreg(response.data[0].Idp);
                switch (response.data[0].clave) {
                    case "matrix":
                        //console.log('Matriz');
                        let json= JSON.parse(response.data[0].json_content);
                        //console.log('datos de las respuestas',response.data[0].json_content);
                        let datap=json;
                        //console.log(json[0])
                        var result = [];
                        for(var i in datap)
                        //console.log(datap [i])
                            result.push(datap [i])
                        setFilas(result);
                        break;
                    case "checkbox":
                        dataformatPreguntas(response.data[0].json_content);
                        break;
                    case "radiogroup":
                        dataformatPreguntas(response.data[0].json_content);
                        break;
                    case "dropdown":
                        dataformatPreguntas(response.data[0].json_content);
                        break;
                    default:
                        break;
                }
                $("#exampleModalCenter").modal("show");
            }).catch(error => {
                //console.log(error)
            });
        }
    },[idstate]);

    $('button[id=editar]').click(()=> {
        let id= $('input[id=idRow]').val();
        
        setIdstate(id);
        // $('#save').removeClass('hidden');
        if(pregunta){
            $("#exampleModalCenter").modal("show");
        }
    });

    //metodo para poder crear la pregunta
    function toggleEditing() {
        //console.log(window);
        $('#exampleModalCenter').modal('show');
        setEditing(!editing);
    }
    //metodo para hacer focus a los componentes de texto
    function handleFocus(e){
        e.target.select();
    }
    function handleInputChange(e){
        if(e.charCode == 13){
            addValue();
        }
    }

    //metodo que agrega valores a la matriz
    function addValue(){
        if(Filas.length<=3){
            setFilas([...Filas, value]);
            setValue('');
            setShareState(1);
            $("#Value").focus();
        }
    }
    
    function refresh(){
        window.location.reload();
    }
    //metodo para el checked
    function toggleChange (){
        SetRequiered(!required)
      }
    //metodo para eliminar items del array de matriz
    function eliminar(eliminar){
        const newTodos = Filas.filter((_, index) => index !== eliminar);
        setFilas(newTodos);
    }
    //metodo para mover los items del array de matriz
    function arraymove(fromIndex, toIndex) {
        let arr=Filas;
        var element = arr[fromIndex];
        arr.splice(fromIndex, 1);
        arr.splice(toIndex, 0, element);
        setFilas(null);
        arr.forEach((element,i) => {
            setFilas([...Filas,element]);
        });
        let lastindex=Filas.length;
        eliminar(lastindex);
    }
    //crea el template json de las preguntas
    function crearDataPost(){
        let acumulador="";
        let data;
        let required;
        switch (Tipo) {
            case 'matrix':
                let arr=Filas;
                for (let index = 0; index < arr.length; index++) {
                    const element = arr[index];
                    if(index+1===arr.length){
                        acumulador+=`"${letras[index]}": "${element}"`;
                    }else{
                        acumulador+=`"${letras[index]}": "${element}",`;
                    }
                }
                data=`{${acumulador}}`;
                break;
            case 'text':
                if(required){
                    data=`{"type":"${Tipo}", "name": "${pregunta}"`;
                }else{
                    data=`{"type":"${Tipo}", "name": "${pregunta}","isRequired": true}`;
                }
                
                break;
            case 'comment':
                data=`{"type":"${Tipo}", "name": "${pregunta}"}`;
                break;
            default:
                let resp=Respuesta.split('\n');
                for (let index = 0; index < resp.length; index++) {
                    const element = resp[index];
                    if(index+1===resp.length){
                        //console.log('no entro');
                        acumulador+=`"${element}"`;
                    }else{
                        acumulador+=`"${element}",`;
                    }
                }
                data=`{"type":"${Tipo}", "name": "${pregunta}","choices": [${acumulador}]}`;
                break;
        }
        //console.log("post",postFiles);
        //console.log("data",data);
        return data;
    }
    //Envio de los datos a la url especificada
    function accionPost(){
        var data = new FormData();
        var template=crearDataPost();
        data.append('Pregunta', pregunta);
        data.append('Template', template);
        data.append('slug',slug(pregunta,'_'));
        data.append('tipoPregunta',Tipo);
        if(editpet==="Editar"){
            data.append('Accion',"Editar");
            data.append('id',idPre||'');
        }else{
            data.append('Accion',"Agregar");
        }

        axios.post(postFiles,data)
        .then(function (response) {
            toastr.success('Exíto');
            $("#exampleModalCenter").modal("hide");
            $('button[id=eliminar]').click();
        }).catch(error => {
            //console.log(error)
        });
        //window.location.reload();
    }

    //reset todos los estados de la aplicación
    function reset(){
        setFilas([]);
        setPregunta('');
        setResp('');
        setTipo('');
        setValue('');
        //idPre('');
    }

    function dataformatPreguntas(data){
        var contenido= JSON.parse(data);
                    let arr=contenido.choices;
                    let values=arr.length;
                    //console.log(arr);
                    let acum='';
                    for (let index = 0; index < arr.length; index++) {
                        if(index+1===values){
                            acum+=arr[index];
                        }else{
                            acum+=arr[index]+"\n";
                        }
                    }
                    setResp(acum);
    }
   
    //funciones del todo de ponderacion
    function renderRespuestas(param){
        switch(param) {
            case 'text':
              return <input placeholder="Respuesta corta" className="form-control" type="text" disabled/>;
              case 'comment':
              return <textarea placeholder="Respuesta larga" className="form-control" disabled></textarea>;
              case 'matrix':
              return <>
                <div className="row">
                    <div className="col-md-8">
                        <input className="form-control" 
                            placeholder="Ingrese una opción" 
                            id="option" 
                            onKeyPress={handleInputChange} 
                            value={value||''} 
                            onChange={e=>setValue(e.target.value)}/>
                    </div>
                    <div className="col-md-4"><button className="btn btn-primary btn-sm" onClick={addValue}>Agregar</button></div>
                </div> 
                <br/>
                <ul className="list-group">
                    {
                        Filas&&Filas.map((item,i)=>(
                            <div key={i}>
                                <li className="list-group-item" >{letras[i]}: {item}
                                    <a href="#">
                                    <span className="show-menu">
                                        <a className="btn-xs" onClick={()=>arraymove(i,i-1)}><i className="fa fa-chevron-up" aria-hidden="true"></i></a>
                                        <a className="btn-xs" onClick={()=>arraymove(i,i+1)}><i className="fa fa-chevron-down" aria-hidden="true"></i></a>
                                        <a className="btn-xs" onClick={()=>eliminar(i)}><i className="fa fa-times" aria-hidden="true"></i></a>
                                    </span>
                                    </a>
                                </li>
                            </div>
                        ))
                    }
                </ul>
              
            </>;
            default:
              return  <><label>Ingrese una opción </label><textarea disabled={!Tipo} value={''||Respuesta} className="form-control" name="respuestas" rows="4" style={{overflow:'hidden',resize:'none'}} onChange={e=>setResp(e.target.value)} placeholder="Opción 1&#10;Opción 2&#10;Opción 3&#10;Opción 4"></textarea></>;
          }
    }

        return (
            <>
                <button type="button" className="btn btn-primary" data-toggle="modal" onClick={reset} data-target="#exampleModalCenter">
                <i className="fa fa-plus-circle" aria-hidden="true"></i> Agregar pregunta
                </button>
                <div className="modal fade bd-example-modal-lg" id="exampleModalCenter" tabIndex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
                    <div className="modal-dialog modal-lg" role="document">
                        <div className="modal-content">
                            <div className="modal-header">
                                <h5 className="modal-title" style={{fontSize:"1.75rem"}} id="exampleModalLongTitle">{editpet ? (
                                        'Editar pregunta'
                                        ) : (
                                           'Agregar nueva pregunta'
                                        )}</h5>
                            </div>
                            <div className="modal-body">
                                <div className="row">
                                    <div className="col-md-12">
                                        <div className="row">
                                            <div className="col-md-7">
                                                <label>Título</label>
                                                <input onFocus={handleFocus} className="form-control" name="pregunta" placeholder="Título" value={pregunta||''} onChange={e=>setPregunta(e.target.value)}></input>
                                            </div>
                                            <div className="col-md-3">
                                            <label>Tipo</label>
                                                <select className="form-control" value={Tipo||''} onChange={e=>setTipo(e.target.value)}  id="exampleFormControlSelect1">
                                                    <option value="0" defaultValue>Seleccione una opción</option>
                                                    {tipoPregunta.map((it,k) => <option key={k} value={it.clave}>{it.nombre}</option>)}
                                                </select>
                                            </div>
                                            <div className="col-md-2" style={{textAlign:"center",paddingTop:"20px"}}>
                                            <input type="checkbox" name="Required" defaultValue={required} onChange={toggleChange}/> Requerido
                                            </div>
                                        </div>
                                        <div className="row">
                                            <div className="col-md-12 div-contenido">
                                                <br/>
                                               {renderRespuestas(Tipo)}
                                                <br/>
                                                
                                                <br/>
                                            </div>
                                        </div>
                                        <div className="row">
                                            <div className="col-sm-4 col-md-12">
                                                <div className="form-group">
                                                    <br/>
                                                    <div className="alert alert-success alert-dismissible hidden" id="myAlert">
                                                        {"Se completo correctamente la acción"}
                                                    </div>
                                                    <div className="alert alert-danger alert-dismissible hidden" id="myAlert2">
                                                        {"Ocurrio un error, intentelo mas tarde"}
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div className="modal-footer">
                                <button type="button" id="close" className="btn btn-secondary" data-dismiss="modal">Cerrar</button>
                                <button className="btn btn-primary" id="save" onClick={accionPost} disabled={!Tipo||Tipo==="0"||!pregunta}><i className="fa fa-floppy-o" aria-hidden="true"></i> Guardar</button>
                            </div>
                        </div>
                    </div>
                </div>
            </>
        );
}

Pregunta.propTypes = {
    selector: PropTypes.string.isRequired,
    reference: PropTypes.string.isRequired,
    referenceId: PropTypes.number.isRequired,
    getFiles: PropTypes.string,
    postFiles: PropTypes.string.isRequired,
    //type: PropTypes.string.isRequired
};

export default Pregunta;