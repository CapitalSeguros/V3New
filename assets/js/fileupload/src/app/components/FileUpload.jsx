import React from 'react'
import ReactDOM, { render } from 'react-dom';
import PropTypes from 'prop-types'
import axios from 'axios';
import { ToastContainer, toast } from 'react-toastify';
import 'react-toastify/dist/ReactToastify.css';
const TemplateModal = (props) => (
<div className="modal fade modalUpload">
    <div className="modal-dialog modal-lg">
        <div className="modal-content" style={{"minHeight":"400px"}}>
            <div className="modal-header">
                <button type="button" className="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">×</span></button>
                <h4 className="modal-title" id="tIndicador">Gestión documentos</h4>
            </div>
            <div className="modal-body">
                    <div className="row">
                        <div className="col-sm-12">
                            <div className="swMessage"></div>
                        </div>
                    </div>
                      <div id="tbActionCont">
                        <div className="tab-pane active" id="tbup1">
                            <div className="form-group col-sm-9">
                                <div className="input-group">
                                    <input type="hidden" className="form-control input-sm" name="txtFullNameFile" id="txtFullNameFile" placeholder="Nombre" />
                                    <input type="file" className="inFiles form-control" onChange={props.change} name="inFiles" id="inFiles" style={{'display':'none'}} accept="" multiple/>
                                    <input type="text" className="form-control input-sm" name="txtNameFile" id="txtNameFile" placeholder="Nombre" disabled={true} />
                                    <div className="input-group-btn">
                                        <button type="button" id="btnRemove" className="btn btn-default hidden btn-sm" onClick={props.remove} aria-label="Help">Remover</button>
                                        <button type="button" id="btnUpload" onClick={props.submit} className="btn btn-default btn-sm">Elegir...</button>
                                    </div>
                                </div>                                
                                ​<input type="text" className="form-control input-sm" name="txtDescription" id="txtDescription" placeholder="Descripción" />                                
                            </div>
                        </div>
                    </div>
                </div>
        </div>
    </div>
</div>
);

const TemplatePreview = (props) => {
    return(
        <div id="mdPrevies" className="modal moda-preview" tabIndex="-1" role="dialog">
    <div className="modal-dialog" role="document">
    <div className="modal-content">
        <div className="modal-header">{props.description}
        <a data-dismiss="modal" aria-label="Close" className="pull-right btn-sm"><i className="fa fa-2x fa-times" aria-hidden="true"></i></a>
        <a href={props.download} className="pull-right btn-sm"><i className="fa fa-2x fa-cloud-download" aria-hidden="true"></i></a>
        </div>
        <div className="modal-body">
        <iframe src={`https://docs.google.com/viewer?url=http://187.188.175.49:8081/${props.url}&embedded=true`} style={{'width':'100%', 'height':'90vh'}} frameBorder="0"></iframe>
        </div>
    </div>
    </div>
</div>
    )
};

const renderFile = (method,file,key) => (
<li key={key} data-key={key} onClick={method}>
    <a href="#"><i className={valueTipe(getTypeDocument(file.Tipo))}></i> {file.NombreCompleto}
    <ul className="list-unstyled sub" >
        <li>{file.Descripcion}</li>
        <li>{file.Fecha}</li>
    </ul>
    </a>
</li>
);

function getTypeDocument(type) {
    var sResult = "";
    switch (type) {
      case "application/pdf":
        sResult = "PDF";
        break;
      case "image/jpeg":
      case "image/png":
      case "image/gif":
        sResult = "IMAGEN";
        break;
      case "application/vnd.ms-excel":
      case "application/vnd.openxmlformats-officedocument.spreadsheetml.sheet":
        sResult = "EXCEL"
        break;
      case "application/msword":
      case "application/vnd.openxmlformats-officedocument.wordprocessingml.document":
        sResult = "WORD"
        break;
      default:
        sResult = "OTRO";
        break;
    }
    return sResult;
}

function valueTipe(type) {
    var icono;
    if (type == 'WORD') {
        icono = 'color-word fa fa-1x fa-file-word-o';
    }
    if (type == 'IMAGEN') {
        icono = 'color-image fa fa-1x fa-file-image-o';
    }
    if (type == 'PDF') {
        icono = 'color-pdf fa fa-1x fa-file-pdf-o ';
    }
    if (type == 'EXCEL') {
        icono = 'color-excel fa fa-1x fa-file-excel-o';
    }
    if (type == 'POWERPOINT') {
        icono = 'color-powerpoint fa fa-1x fa-file-powerpoint-o';
    }
    if (type == 'OTRO') {
        icono = 'color-code fa fa-1x fa-file-code-o';
    }
    return icono;
}


class FileUpload extends React.Component{
    constructor(props){
        super(props);
        this.state = {
            files:[],
            file:{},
            isLoading: true,
            show:false
        }
        this.openModalHandler = this.openModalHandler.bind(this);
        this.openPreviewFile = this.openPreviewFile.bind(this);
        this.submitInputHandler = this.submitInputHandler.bind(this);
        this.changeInputHandler = this.changeInputHandler.bind(this);

        
    }

    loadData(self){
        const {getFiles, reference, referenceId } = self.props;
        axios.get(`${getFiles}${reference}&id=${referenceId}`)
        .then(function (response) {
            self.setState({files: response.data.data})
        })
        .catch(function (error) {
            toast.error("Error al recuperar la información !", {
                position: toast.POSITION.TOP_RIGHT
            });
        });
    }

    componentDidMount(){
        this.loadData(this)
        var dv = document.querySelector('.dvModalUpload');
        if (dv == undefined) {
          dv = document.createElement('div');
          dv.classList.add('dvModalUpload')
          document.body.appendChild(dv);
        }
        ReactDOM.render(<TemplateModal submit={this.submitInputHandler} change={this.changeInputHandler} remove={this.removeInputHandler} />,dv);
        
    }
    changeInputHandler(e){
        e.preventDefault();
        e.stopPropagation();
        var files = e.target.files;
        this.setState({file : files});
        document.getElementById('btnRemove').classList.remove("hidden"); 
        for (let index = 0; index < files.length; index++) {
            const element = files[index];
            var names = element.name.split(".");
            var sName = '';
            if (names.length > 1) 
                sName = names[0];
            else
                sName = element.name;
            
            document.getElementById("txtNameFile").value = sName;
            document.getElementById("txtFullNameFile").value = element.name;
        }
        document.getElementById("btnUpload").innerHTML = "Subir";
    }
    submitInputHandler(e){
        var inFiles = document.getElementById('inFiles');
        if(inFiles.value != ""){
            const {postFiles, reference, referenceId } = this.props;
            var name = document.getElementById("txtNameFile").value;
            var fullname = document.getElementById("txtFullNameFile").value;
            var description = document.getElementById("txtDescription").value;

            var data = new FormData();
            data.append('referenciaId', referenceId);
            data.append('referencia', reference);
            data.append('name', name);
            data.append('fullname', fullname);
            data.append('description', description);
            
            for (const key in this.state.file) {
                data.append(key,this.state.file[key]);
            }
            var self = this;
            axios.post(postFiles,data)
            .then(function (response) {
                // self.setState({files: response.data.data})
                self.loadData(self);
                toast.success("Se cargo con exíto el archivo", {
                    position: toast.POSITION.TOP_RIGHT
                });
                document.getElementById("txtNameFile").value = "";
                document.getElementById("txtFullNameFile").value = "";
                document.getElementById("txtDescription").value = "";
                document.getElementById('btnRemove').classList.add("hidden"); 
                $('.modalUpload').modal('hide');
            })
            .catch(function (error) {
                console.log(error);
                toast.error("Ocurrio un error al subir el documento", {
                    position: toast.POSITION.TOP_RIGHT
                });
            });
        }else{
            inFiles.click();
        }
    }
    removeInputHandler(e){
        document.getElementById('btnRemove').classList.add("hidden"); 
        document.getElementById('inFiles').value = "";
        document.getElementById("txtNameFile").value = "";
        document.getElementById("txtFullNameFile").value = "";
        document.getElementById("btnUpload").innerHTML = "Elegir...";
        document.getElementById("txtDescription").value = "";
    }
    openPreviewFile(e){
        e.preventDefault();
        var file = this.state.files[e.currentTarget.dataset.key];
        var dv = document.querySelector('.dvFinal');
        if (dv == undefined) {
          dv = document.createElement('div');
          dv.classList.add('dvFinal')
          document.body.appendChild(dv);
        }
        ReactDOM.render( <TemplatePreview url={file.RutaCompleta} download={file.Download+""} title={file.Nombre} description={file.Descripcion} />,dv);
        $('#mdPrevies').modal({
          backdrop: 'static',
          keyboard: false
        });
    }
    openModalHandler(e){
        e.preventDefault();
        $('.modalUpload').modal({
            backdrop: 'static',
            keyboard: false
        });
    }
    
    render(){
        const {files} = this.state;
 
        return(
            <div className="wrapper wrapper-content project-manager">
                <button type="button" name="bnUpload" onClick={this.openModalHandler} className="btn btn-sm btn-default pull-right"> <span className="fa fa-paperclip"></span> Adjuntar documento</button>
                <ul className="list-unstyled project-files">
                    {
                        files.map((v,k) => renderFile(this.openPreviewFile,v,k))
                    }
                </ul>
                <ToastContainer />
            </div>
        );
    }
}
FileUpload.propTypes = {
    selector: PropTypes.string.isRequired,
    reference: PropTypes.string.isRequired,
    referenceId: PropTypes.number.isRequired,
    getFiles: PropTypes.string.isRequired,
    postFiles: PropTypes.string.isRequired,
    type: PropTypes.string.isRequired
  }
  export default FileUpload 