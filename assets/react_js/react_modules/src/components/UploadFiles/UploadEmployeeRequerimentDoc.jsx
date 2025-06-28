import React, {useState, useEffect, useMemo} from "react";
import axios from "axios";
import {useDropzone} from 'react-dropzone';
import $ from "jquery";
import { FontAwesomeIcon } from '@fortawesome/react-fontawesome';
import { faBan, faPause, faPlay, faTrash } from '@fortawesome/free-solid-svg-icons';
//import { initializeApp } from "firebase/app";
//import { getStorage, ref } from "firebase/storage";
import firebase from "../../firebase.js";

const UploadContent = (props) => {

    //const {acceptedFiles, getRootProps, getInputProps} = useDropzone();
    const baseUrl = $("#base_url").data("base-url");
    const [filesReadyUpload, setFilesReadyUpload] = useState([]);
    const [repositories, setRepositories] = useState([]);
    const {
        //acceptedFiles,
        getRootProps,
        getInputProps,
        isFocused,
        isDragAccept,
        isDragReject
    } = useDropzone({onDrop: (acceptedFiles) => { //acceptedFiles is array of objects. drop does the storage in acceptedFiles.
        setFilesReadyUpload((prevFiles) => {
            return acceptedFiles.reduce((acc, curr) => {

                const temporalId = Math.floor(Math.random() * 100) + 1;
                return [...acc, {
                    tmpId: temporalId, 
                    tag: "",
                    employeId: parseInt(props.employee), 
                    name: curr.name, 
                    typeDoc: "",
                    subDirectory: "",
                    file: curr, 
                    status: "pending", 
                    optionStatus: "pending",
                    uploadStatus: ""
                }];
            }, prevFiles);
        });
    }, disabled: false,  accept: ".docx, .pdf"}); //{accept: 'image/*'}

    const baseStyle = {
        flex: 1,
        display: 'flex',
        flexDirection: 'column',
        alignItems: 'center',
        padding: '20px',
        borderWidth: 2,
        borderRadius: 2,
        borderColor: '#eeeeee',
        borderStyle: 'dashed',
        backgroundColor: '#fafafa',
        color: '#bdbdbd',
        outline: 'none',
        transition: 'border .24s ease-in-out'
      };
      
    const focusedStyle = {
        borderColor: '#2196f3'
    };
      
    const acceptStyle = {
        borderColor: '#00e676'
    };
      
    const rejectStyle = {
        borderColor: '#ff1744'
    };
    
    const style = useMemo(() => ({
        ...baseStyle,
        ...(isFocused ? focusedStyle : {}),
        ...(isDragAccept ? acceptStyle : {}),
        ...(isDragReject ? rejectStyle : {})
    }), [
        isFocused,
        isDragAccept,
        isDragReject
    ]);

    useEffect( async () => {
        $(".upload-modal-title").html(props.title);

        const getRepositories = await axios.get(`${baseUrl}capitalHumano/getRepositories`)
        setRepositories(getRepositories.data);

        const filter = ["permisos", "vacaciones", "incapacidad", "documentos"];
        const repositoriesFiltered = getRepositories.data.filter(arr => !filter.includes(arr.repositorio));

        //console.log(repositoriesFiltered); //getRepositories

    }, []);

    //----------------------------------------- //Dennis Castillo [2022-03-07]
    const changeUploadStatus = (status, id) => {

        const newArray = filesReadyUpload.map(arr => {
            if(arr.tmpId == id){
                arr.uploadStatus = status;
            }
            return arr;
        });

        setFilesReadyUpload(newArray);
        //console.log(status, id);
    }

    //----------------------------------------- //Dennis Castillo [2022-03-07]
    const passFiles = () => {
        //console.log("hook", filesReadyUpload);
        const validateTypeDoc = filesReadyUpload.filter(arr => arr.typeDoc == "");
        const whatsIsTheFiles = validateTypeDoc.reduce((acc, curr) => {
            acc += `${curr.name}\n`;
            return acc;
        }, ``);

        if(validateTypeDoc.length > 0){
            alert(`Los siguientes archivos no tiene un contenedor seleccionado\n${whatsIsTheFiles}`);
            return false;
        }

        const newArray = filesReadyUpload.map(arr => {

            if(arr.status == "pending"){
                arr.optionStatus = "uploading";
            }
            return arr;
        })
        
        setFilesReadyUpload(newArray);
        //useDropzone({});

        for(var a in filesReadyUpload){

            if(filesReadyUpload[a].optionStatus == "uploading"){
                uploadFilesToTheCloud(filesReadyUpload[a]);
            }            
        }
    }

    //----------------------------------------- //Dennis Castillo [2022-03-07]
    const uploadFilesToTheCloud = (data) => {
        //console.log("upload", data);
        const storage = firebase.storage();
        const ref = storage.ref();
        const subDir = data.subDirectory !== `` ? `${data.subDirectory}/` : ``;
        const rootFolder = ref.child(`documentos_de_puestos/${data.typeDoc}/${data.employeId}/${subDir}${data.name}`);
        var uploadTask = rootFolder.put(data.file);

        /*switch(data.uploadStatus){
            case "cancel": 
                uploadTask.cancel();
            break;
        }*/

        uploadTask.on("state_changed", 
            (snapshot) => {
                var progress = (snapshot.bytesTransferred / snapshot.totalBytes) * 100;
                //console.log('Upload is ' + progress + '% done');

                switch(snapshot.state){
                    case "running":
                        $(".upload-employee-files").prop("disabled", true);
                        $(`.progress-${data.tmpId}`).removeClass("hidden");
                        $(`.progress-bar-${data.tmpId}`).attr("aria-valuenow", parseInt(progress));
                        $(`.progress-bar-${data.tmpId}`).css("width", `${parseInt(progress)}%`);
                        $(`.progress-bar-${data.tmpId}`).html(`${parseInt(progress)}%`);
                    break;
                }

            },
            (error) => {
                console.log(error.code);
                $(`.progress-bar-${data.tmpId}`).addClass("progress-bar-danger");
            },
            () => {
                uploadTask.snapshot.ref.getDownloadURL().then((downloadURL) => {

                    console.log('File available at', downloadURL);
                    const insert = insertRegister(data, downloadURL);
                    $(".upload-employee-files").prop("disabled", false);
                });
            }
        )
    }

    //----------------------------------------- //Dennis Castillo [2022-03-07]
    const insertRegister = (data, link) => {
        //console.log("here in insert");
        //console.log(data);
        const baseUrl = $("#base_url").data("base-url");

        const formdata = new FormData();
        formdata.append("downloadLink", link);
        formdata.append("process", "insert");
        formdata.append("fileData", JSON.stringify(data));

        const post = axios.post(`${baseUrl}capitalHumano/manageEmployeeDoc`, formdata).then((response) => {
            //console.log(response.data);
            const newArray = filesReadyUpload.map(arr => {

                if(arr.tmpId == data.tmpId){

                    const status = response.data.bool ? "complete" : "failed";
                    arr.status = status;
                    arr.uploadStatus = status;
                    arr.optionStatus = status;
                }

                return arr;
            });

            setFilesReadyUpload(newArray);
        }). catch((error) => {
            console.log(error);
        });
    }

    //----------------------------------------- //Dennis Castillo [2022-03-07]
    const removeOfList = (a) => {
        setFilesReadyUpload(filesReadyUpload.filter(arr => arr.name !== a));
    }

    //----------------------------------------- //Dennis Castillo [2022-03-07]
    const selectDocType = (parameter, event) => {

        const selectIdx = event.target.selectedIndex;
        const typeDoc = event.target.options[selectIdx].value;
        const loop = filesReadyUpload;
        const newArray = [];

        for(var a in loop){
            if(a == parameter){
                loop[a].typeDoc = typeDoc;
            }

            newArray.push(loop[a]);
        }

        setFilesReadyUpload(newArray);
    }

    //----------------------------------------- //Dennis Castillo [2022-03-07]
    const changeOptions = (arr) => {
        //console.log(statusOption); //faPause - icon
        let options;
        let uploadChange = arr.uploadStatus == "" || arr.uploadStatus == "resume" ? 
            <a href="javascript: void(0)" className="text-dark" title="pausar" onClick={changeUploadStatus.bind(this, "pause", arr.tmpId)}><FontAwesomeIcon icon={faPause} /></a> : 
            <a href="javascript: void(0)" className="text-dark" title="reanudar" onClick={changeUploadStatus.bind(this, "resume", arr.tmpId)} ><FontAwesomeIcon icon={faPlay} /></a>

        switch(arr.optionStatus){
            case "pending": 
                options = <a href="javascript: void(0)" className="text-danger" onClick={removeOfList.bind(this, arr.name)}><FontAwesomeIcon icon={faTrash} /> Quitar</a>;
            break;
            case "uploading": 
                options = <div className="row mt-3"> 
                    <div className="col-md-6 text-center">{uploadChange}</div>
                    <div className="col-md-6"><a href="javascript: void(0)" className="text-danger" title="cancelar" onClick={changeUploadStatus.bind(this, "cancel", arr.tmpId)}><FontAwesomeIcon icon={faBan} /></a></div>
                </div>;
            break;
        }

        return options;
    }

    const changeStatus = (arr, idx) => {

        let response;
        //console.log(repositories);
        switch(arr.status){
            case "pending":
                response = arr.name.indexOf(" ") > -1 ? 
                    <span className="label label-danger">Rechazado</span> :
                    <React.Fragment>
                        <div className="mb-2">
                            <select name="docContainer" id="doc-container" className="form-control input-sm" onChange={selectDocType.bind(this, idx)}>
                                <option value="">Seleccione</option>
                                { repositories.map(arr => <option value={arr.repositorio} disabled={ (["solicitudes", "psicometrico"].includes(arr.repositorio) ? props.toDisabled : false ) } >{arr.etiqueta}</option> ) }
                            </select>
                        </div>
                        <div className="mb-2"><input type="text" onChange={generateTag.bind(this, arr.tmpId, "directory")} className="form-control input-sm" placeholder="carpeta2/carpeta3" name={`directory-${arr.tmpId}`} id={`directory-${arr.tmpId}`} value={arr.subDirectory} /></div>
                    </React.Fragment>
                break;
            case "complete": 
                response = <div className="mt-4"><h4><span className="label label-success">Completado</span></h4></div>
                break;
            case "failed": 
                response = <div className="mt-4"><h4><span className="label label-danger">Fallido</span></h4></div>
                break;
        }

        return response;
    }

    const clearCompleteAndFailedDocs = () => {

        //console.log("clear", filesReadyUpload);
        const newArray = filesReadyUpload.filter(arr => arr.status == "pending");
        setFilesReadyUpload(newArray);
    }

    const generateTag = (param, oneCase, event) => {
        //console.log(oneCase);
        const newArray = filesReadyUpload.map(arr => {

            if(arr.tmpId == param){

                if(oneCase == "title"){
                    arr.tag = event.target.value;

                }

                if(oneCase == "directory"){
                    arr.subDirectory = event.target.value;
                }
            }

            return arr;
        });
        setFilesReadyUpload(newArray);
        //console.log(event.target.value);
    }

    return(
        <section className="col-md-12">
            <div {...getRootProps({style})}>
                <input {...getInputProps()} />
                <p className="text-center text-muted">Arrastra algunos archivos aquí, o clic para seleccionar archivos
                    <br />
                    Solo archivos con formato .docx y .pdf
                </p>
            </div>
            <div className="col-md-12 table-responsive mt-4">
                {filesReadyUpload.length > 0 &&
                    <React.Fragment>
                        <table className="table">
                            <thead>
                                <tr><th colSpan={4}>Listado de archivos a subir</th></tr>
                                <tr><th>Etiqueta</th><th>Nombre del archivo</th><th>Estado de carga</th><th></th></tr>
                            </thead>
                            <tbody>
                            {filesReadyUpload.map((arr, idx) => {
                                
                                const options = changeOptions(arr);
                                const status = changeStatus(arr, idx);

                                return <tr>
                                    <td><input type="text" onChange={generateTag.bind(this, arr.tmpId, "title")} className="form-control input-sm" name={`tag-${arr.tmpId}`} id={`tag-${arr.tmpId}`} value={arr.tag} /></td>
                                    <td>
                                        <div>{arr.name}</div>
                                        <div className={`hidden progress-${arr.tmpId}`}>
                                            <div className="progress">
                                                <div className={`progress-bar progress-bar-${arr.tmpId}`} role="progressbar" aria-valuenow="0" aria-valuemin="0" aria-valuemax="100">
                                                    0%
                                                </div>
                                            </div>
                                        </div>
                                    </td>
                                    <td className="text-center">{status}</td><td>{options}</td>
                                </tr>
                            })}
                            </tbody>
                        </table>
                    </React.Fragment>
                }
            </div>
            <div className="col-md-12 mt-4">
                <div className="mr-2 float-right">
                    {
                        filesReadyUpload.length > 0 && <button className="btn btn-primary upload-employee-files" onClick={passFiles}>Subir documentos</button>
                    }
                </div>
                <div className="mr-2 float-right">
                    {
                        filesReadyUpload.filter(arr => arr.status == "complete" || arr.status == "failed").length > 0 &&
                        <button className="btn btn-primary" onClick={clearCompleteAndFailedDocs}>Limpiar completados y fallidos</button>
                    }
                </div>
            </div>
        </section>
    );
    
}

export default UploadContent;