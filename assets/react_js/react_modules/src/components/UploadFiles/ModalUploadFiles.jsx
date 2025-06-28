import React, {useState, useEffect} from "react";
import axios from "axios";
import $ from "jquery";
import UploadContent from "../UploadFiles/UploadEmployeeRequerimentDoc.jsx";
import UploadedDocList from "../UploadFiles/UploadedDocsList.jsx"
import CreatePDF from "../UploadFiles/CreatePDF.jsx";
//Use function component
const ButtonUpload = (props) => {
    const baseUrl = $("#base_url").data("base-url");
    const [employee, setEmployee] = useState(parseInt(props.employee)); //$("#idPuesto").val()
    const [dataEmploye, setDataEmployee] = useState( {} );
    const [itsFree, setItsFree] = useState(0);
    const [showContent, setShowContent] = useState(0);
    const [modalTitle, setModalTitle] = useState("");
    const [blockButton, setBlockButton] = useState( false );
    const [disabledOption, setDisabledOption] = useState( false );
    //console.log("props", props);

    useEffect(() => {
        axios.get(`${baseUrl}capitalHumano/getEmployeeData`, {
            params:{
                id: props.employee
            }
        })
        .then((response) => {
            //console.log(response);
            setItsFree(parseInt(response.data.idPersona));
            setDataEmployee(response.data);
            setDisabledOption( parseInt(response.data.idPersona) > 0 ? true : false );
        })
        .catch((error) => {
            console.log(error);
        });
    }, []);

    const showModalContent = (a, e) => {
        setShowContent(a); //upload-modal-title
        switch(a){
            case 1: setModalTitle("Carga de documentos para el puesto");
            break;
            case 3: setModalTitle("Lista de formatos de requerimientos del puesto");
            break;
            case 4: setModalTitle("Descargar perfil del puesto");
            break;
        }
    }

    //console.log(disabledOption);
    return(
        <React.Fragment>
            <div className="dropdown">
                <a id="dLabel" class="btn btn-link" data-target="#" href="javascript: void(0)" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false" disabled={blockButton}>Carga de formato para el puesto</a>
                <ul class="dropdown-menu" aria-labelledby="dLabel">
                    { props.permit.upload && <li><a href="javascript: void(0)" data-action="upload-file" className="show-upload-modal" onClick={showModalContent.bind(this, 1)}>Subir documentos para el puesto</a></li> }
                    { props.permit.formats && <li><a href="javascript: void(0)" className="show-upload-modal" onClick={showModalContent.bind(this, 3)}>Descargar formato de requerimiento del puesto actual</a></li> }
                    { props.permit.jobProfile && <li><a href="javascript: void(0)" className="show-upload-modal" onClick={showModalContent.bind(this, 4)}>Descargar perfil del puesto</a></li>}
                </ul>
            </div>

            <div class="modal fade" tabindex="-1" role="dialog" id="modal-upload-container">
                <div class="modal-dialog" role="document">
                    <div class="modal-content modal-lg">
                    <div class="modal-header">
                        <h4 class="modal-title upload-modal-title"></h4>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                    </div>
                    <div class="modal-body">
                       {showContent == 1 && <UploadContent title={modalTitle} employee={ employee } toDisabled = { disabledOption } ></UploadContent> }
                       {showContent == 3 && <UploadedDocList title={modalTitle} employee={ employee } formats={ props.permit.formats } requeriments={ itsFree == 0 ? true : false }></UploadedDocList> }
                       {showContent == 4 && <CreatePDF employee={employee} title={modalTitle}></CreatePDF> }
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button>
                    </div>
                    </div>
                </div>
            </div>
        </React.Fragment>  
    )
}

export default ButtonUpload;