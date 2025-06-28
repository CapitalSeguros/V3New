import React, {useState, useEffect} from "react";
import { ReactDOM } from "react";
import axios from "axios";
import $ from "jquery";
import firebase from "../../firebase.js";
import Paper from '@mui/material/Paper';
import Table from '@mui/material/Table';
import TableBody from '@mui/material/TableBody';
import TableCell from '@mui/material/TableCell';
import TableContainer from '@mui/material/TableContainer';
import TableHead from '@mui/material/TableHead';
import TablePagination from '@mui/material/TablePagination';
import TableRow from '@mui/material/TableRow';

const UploadedDocList = (props) => {

    const baseUrl = $("#base_url").data("base-url");
    const [documents, setDocuments] = useState([]);
    const [checklist, setCheckList] = useState({});
    const [totalForDelete, setTotalForDelete] = useState(0);
    const [page, setPage] = useState(0);
    const [rowsPerPage, setRowsPerPage] = useState(10);

    //---------------------
    const changeCheckStatus = (event) => {

        const check = event.target.checked;
        const value = event.target.value;
        const newObject = {};

        for(const a in checklist){

            if(value == "all"){
                newObject[a] = check;
            } else{
                newObject[a] = a === value ? check : checklist[a];
            }
        }

        const total = Object.values(newObject).reduce((acc, curr) => {
            if(curr){
                acc++;
            }
            return acc;
        }, 0);

        setCheckList(newObject);
        setTotalForDelete(total);


    }
    //---------------------

    const columns = [
        {id: 'input', label: <input type="checkbox" onChange={changeCheckStatus.bind(this)} name="selectAll" id="select-all" value="all"/>, align: 'center', minWidth: 70},
        {id: 'etiqueta', label: 'Etiqueta', align: 'center', minWidth: 170},
        {id: 'documento', label: 'Documento', align: 'center', minWidth: 170},
        {id: 'fechaAlta', label: 'Fecha de carga', align: 'center', minWidth: 100},
        {id: 'quienSubio', label: '¿Quien subió el documento', align: 'center', minWidth: 170},
        {id: 'opciones', label: 'Opciones', align: 'center', minWidth: 170},
    ];

    useEffect(() => {
        $(".upload-modal-title").html(props.title);
        getAllDocs();
    }, []);

    const getAllDocs = async () => {

        const axios_ = await axios.get(`${baseUrl}capitalHumano/docsAndFormats`, {
            params: {
                id: props.employee
            }
        });

        const validateCheck = axios_.data.reduce((acc, curr) => {
            return {
                ...acc, [curr.id]: false
            }
        }, {});

        setDocuments(axios_.data);
        setCheckList(validateCheck);
    }

    const handleChangePage = (event, newPage) => {
        setPage(newPage);
    };

    const handleChangeRowsPerPage = (event) => {
        setRowsPerPage(+event.target.value);
        setPage(0);
    };

    const downloadFile = (data) => {
        //console.log(checklist);
        const storage = firebase.storage();
        const httpsReference = storage.refFromURL(data.downloadURL);

        httpsReference.getDownloadURL().then((url) => {

            var xmlhttp = new XMLHttpRequest();
            xmlhttp.responseType = "blob";
            xmlhttp.onload = (event) => {
                var blob = xmlhttp.response;
            }
            xmlhttp.open("GET", url);
            xmlhttp.send();

            var aTarget = $("<a><a>").attr("href", url).attr("download", data.document);
            $(document).append(aTarget);
            aTarget.click();
        });
    }

    const deleteDocuments = () => {

        const forDelete = [];
        const formData = new FormData();

        for(const a in checklist){
            if(checklist[a]){
                forDelete.push(a);
            }
        }
        
        formData.append("forDelete", JSON.stringify(forDelete));
        const delete_ = axios.post(`${baseUrl}capitalHumano/deleteDocs`, formData).then((response) => {
            //console.log(response);

            if(response.data){
                getAllDocs();
                setTotalForDelete(0);
            }
            
        }).catch((error) => {
            console.log(error)
        });
    }

    return(
        <React.Fragment>
            <h5>Descargue o elimine los archivos que necesite</h5>
            <Paper sx={{width: '100%', overflow: 'hidden'}}>
                {totalForDelete > 0 && <div className="float-right mb-4"><button className="btn btn-danger btn-sm text-white" onClick={deleteDocuments}>Eliminar { totalForDelete } seleccionados</button></div>}
                <TableContainer sx={{ maxHeight: 440 }}>
                    <Table stickyHeader aria-label="sticky table">
                        <TableHead>
                            <TableRow>
                                {
                                    columns.map(arr => <TableCell key={arr.id} align={arr.align} style={{minWidth: arr.minWidth}}>{arr.label}</TableCell>)
                                }
                            </TableRow>
                        </TableHead>
                        <TableBody>
                            {
                                documents.slice(page * rowsPerPage, page * rowsPerPage + rowsPerPage).map(arr => 
                                    <TableRow>
                                        <TableCell style={{textAlign: "center"}}><input type="checkbox" onChange={changeCheckStatus.bind(this)} checked={checklist[arr.id]} name="deleteOfList[]" className="delete-of-list" value={arr.id} /></TableCell>
                                        <TableCell style={{textAlign: "center"}}>{arr.tag}</TableCell>
                                        <TableCell>
                                            <div className="mb-2">{arr.document}</div>
                                            <div className="text-center">
                                                <a href="javascript: void(0)" onClick={downloadFile.bind(this, arr)} style={{padding: "4px 4px 4px 4px", border: "1px #D6EAF8 solid", borderRadius: "3px", backgroundColor: "rgba(46, 134, 193)", color: "white"}}>Descargar fichero</a>
                                            </div>
                                        </TableCell>
                                        <TableCell>{arr.dateInsert}</TableCell>
                                        <TableCell>{arr.whoUploadFile}</TableCell>
                                    </TableRow>
                                )
                            }
                        </TableBody>
                    </Table>
                </TableContainer>
                <TablePagination 
                    rowsPerPageOptions={[10, 25, 100]}  
                    component="div" 
                    count={documents.length}
                    rowsPerPage={rowsPerPage}
                    page={page}
                    onPageChange={handleChangePage}
                    onRowsPerPageChange={handleChangeRowsPerPage}
                ></TablePagination>
            </Paper>
        </React.Fragment>
    );
}

export default UploadedDocList