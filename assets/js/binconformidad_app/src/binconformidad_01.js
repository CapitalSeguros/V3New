import dbx from "./API/dropbox/dropboxconnection.js";
import Uppy from "@uppy/core";
import DragDrop from "@uppy/drag-drop";
import Spanish from "@uppy/locales/lib/es_ES";
import { initializeApp } from "firebase/app";
import { getStorage, ref, uploadBytesResumable, getDownloadURL, listAll, deleteObject } from "firebase/storage";
import axios from "axios";
//import axios from "axios";

var countUpload = [];
var countReg = [];
var validFinally = [];
var allSelect = false;
var date = new Date();
var months = {
    1: "Enero",
    2: "Febrero",
    3: "Marzon",
    4: "Abril",
    5: "Mayo",
    6: "Junio",
    7: "Julio",
    8: "Agosto",
    9: "Septiembre",
    10: "Octubre",
    11: "Noviembre",
    12: "Diciembre"
}

const firebaseConfig = {
    apiKey: "AIzaSyAt0LKhc2LcZ7EIbRTIPSxTq1R8RrWnz2U",
    authDomain: "v3-plus-2.firebaseapp.com",
    projectId: "v3-plus-2",
    storageBucket: "v3-plus-2.appspot.com",
    messagingSenderId: "90046407574",
    appId: "1:90046407574:web:efa800e312ac7020baf3b7",
    measurementId: "G-7SLVDSJMBN"
};

const firebaseApp = initializeApp(firebaseConfig);
const storage = getStorage(firebaseApp);

//-----------------------------------
jQuery(window).on("load", function(){
    
    console.log("Hola mundo - 10");

    /*const printTable = printDataTable({ //Prueba
        "getOnlyMyList": true,
        "year": date.getFullYear(),
    });*/

    /*getList({
        getOnlyMyList: true,
        year: date.getFullYear(),
        //applyDataTable: true
    });*/

    jQuery(".nc-list-table").DataTable({
        language: {
            url: 'https://cdn.datatables.net/plug-ins/1.11.5/i18n/es-MX.json',
        },
        ordering: false
        /*fixedColumns: {
            left: 1
        }*/
    });

    jQuery(".datepicker-filter").datepicker({
        dateFormat: "dd/mm/yy"
    });
});

//----------------------------------
const uppy = new Uppy({
    locale: Spanish,
    restrictions:{
        allowedFileTypes:['image/*', '.jpg', '.jpeg', '.png', '.gif', ".xlsx", ".docx", ".pptx", ".doc", ".xls", ".pdf"]
    },
    onBeforeFileAdded: (file) => {

        const addAFile = addToFileContainer({
            file: file,
            querySelector: `.uploaded-files .pre-upload-list .row`,
            checkboxClass: `check-file-selected`,
        });
    }
}).use(DragDrop, {
    target: '.example-two .for-DragDrop',
    //width: '30%',
    height: '10%',
});

const uppy2 = new Uppy({
    locale: Spanish,
    restrictions:{
        allowedFileTypes:['image/*', '.jpg', '.jpeg', '.png', '.gif', ".xlsx", ".docx", ".pptx", ".doc", ".xls", ".pdf"]
    },
    onBeforeFileAdded: (file) => {
        //console.log(file);
        const addAFile = addToFileContainer({
            file: file,
            querySelector: `.uploaded-files .modal-pre-upload .row`,
            checkboxClass: `check-file-selected-in_modal`,
        })
    },
});

//----------------------------------
function addToFileContainer(data){

    var child = jQuery("<div></div>").addClass("col-md-2 border mr-2 text-center").append(
        jQuery("<div></div>").addClass("text-center mt-2 mb-2").html(`<i class="fa fa-file fa-2x" aria-hidden="true"></i>`),
        jQuery("<div></div>").append(
            jQuery("<input>").
                attr("type", "text").
                val(data.file.name).
                css("width", "100%").
                attr("readonly", true).
                css("border", "0px").css("background-color", "transparent")
        ),
        jQuery("<div></div>").addClass("mb-2").append(
            jQuery("<input>").addClass(data.checkboxClass).attr("type", "checkbox").val(data.file.id)
        )
    );
    jQuery(data.querySelector).append(child); //.uploaded-files .pre-upload-list .row
}
//----------------------------------
function uploadToFirebaseCloud(root = null, id, regId = null){
    
    //var docs = uppy.getFiles();
    var docs = uppy.getFile(id)
    const subDirectory = root !== null ? `${root}/` : ``;

    //for(var a in docs){
        const storageRef = ref(storage, `inconformidades/${subDirectory}/inconforme/${docs.name}`);
        const uploadTask = uploadBytesResumable(storageRef, docs.data);
        const idd = docs.id.split("-").pop()
        
        uploadTask.on('state_changed',
        (snapshot) => {
            const progress = (snapshot.bytesTransferred / snapshot.totalBytes) * 100;
                        
            jQuery(`.progress-upload-file-${idd}`).text(progress.toPrecision(3) + "%")
            .attr("aria-valuenow", progress)
            .css("width", `${progress}%`);
        },
        (error) => {
            
            countUpload.push(false);
            alert(error);
            jQuery(`.progress-container-${idd}`).remove();
            jQuery(`.icon-upload-file-${idd}`).html(`<i class="fa fa-times" aria-hidden="true"></i>`);
        },
        () => {
            getDownloadURL(uploadTask.snapshot.ref).then((download) => {
                
                countUpload.push(true);
                jQuery(`.progress-container-${idd}`).remove();
                jQuery(`.icon-upload-file-${idd}`).html(`<i class="fa fa-check" aria-hidden="true"></i>`);

                if(regId !== null){
                    const stop = finishProgress(regId);
                }
            })
        });
    //}
}
//----------------------------------
jQuery("#delete-selected").on("click", function(e){ //document.getElementById("delete-selected").addEventListener

    e.preventDefault();
   jQuery(".check-file-selected").each(function(){
        
        if(jQuery(this).is(":checked")){
        
            uppy.removeFile(jQuery(this).val());
            jQuery(this).parent().parent().remove();
        }

   });

   if(uppy.getFiles().length == 0){
    jQuery("#select-all-files").prop("checked", false);
    jQuery("#select-all-files").trigger("change");
   }

   //console.log(uppy.getFiles());
});
//----------------------------------
jQuery("#select-all-files").on("change", function(e){

    const change = jQuery(this).is(":checked");
    var selectedLabel = change ? ` Quitar selección` : `Seleccionar todos`;

    if(jQuery(".check-file-selected").length > 0){
        jQuery(".change-selected-label").html(selectedLabel);
    }

    jQuery(".check-file-selected").each(function(){
        jQuery(this).prop("checked", change);
    });
});
//----------------------------------
jQuery("#inconformidadFormulario").on("submit", function(e){

    e.preventDefault();
    const url = jQuery(this).attr("action");
    const formdata = new FormData(this);
    const confirm = new Promise(showPreSendModal);

    confirm.then(() => {

        const ax = axios.post( url, formdata, {
            headers: {
                "Content-Type": "multipart/form-data"
            }
        }).then((jsonData) => {
            
            const showmodal = showProgressModal(jsonData.data);
    
        }).catch((error) => {
            alert(error.message);
            //console.log(error);
        });
    });
});

//----------------------------------
function showProgressModal(data){

    const files = uppy.getFiles();

    jQuery(".progress-first-create").html(`
        <div class="upload-progress text-center mb-4">
            <div class="icon-container"><i class="fa fa-circle-o-notch fa-spin fa-3x fa-fw"></i></div>
            <div class="ticket-container"></div>
            <div class="comment-container"></div>
        </div>
        <div class="progress-list"></div>`
    );

    for(var a in data){

        //if(type == "data"){
            countReg.push(data[a].success);
            const icon = data[a].success ? `<i class="fa fa-check" aria-hidden="true"></i>` : `<i class="fa fa-times" aria-hidden="true"></i>`
            jQuery(".progress-list").append(
                jQuery("<div></div>").addClass("col-md-12 mb-4").append(
                    jQuery("<div></div>").addClass("row").append(
                        jQuery("<div></div>").addClass("col-md-1").html(icon)).append(
                            jQuery("<div></div>").addClass("col-md-10").text(data[a].message)
                        ))
            );
        //}
    }

    for(var b in files){
        
        const idd = files[b].id.split("-").pop();

        jQuery(".progress-list").append(
            jQuery("<div></div>").addClass("col-md-12").append(
                jQuery("<div></div>").addClass("row").append(
                    jQuery("<div></div>").addClass(`col-md-1 icon-upload-file-${idd}`)
                ).append(
                    jQuery("<div></div>").addClass(`col-md-10`).append(
                        jQuery("<div></div>").append(
                            jQuery("<label></label>").text(files[b].name)
                        )
                    ).append(
                        jQuery("<div></div>").addClass("mt-2").append(
                            jQuery("<div></div>").addClass(`progress progress-container-${idd}`).append(
                                jQuery("<div></div>").addClass(`progress-bar progress-upload-file-${idd}`).
                                attr("role", "progressbar").
                                attr("aria-valuenow", 0).
                                attr("aria-valuemin", 0).
                                attr("aria-valuemax", 100).
                                text("0%")
                            )
                        )
                    )
                )
            )
        )
        const upload = uploadToFirebaseCloud(data[0].data, files[b].id, data[0].data);
    }

    if(files.length == 0){
        const stop = finishProgress(data[0].data);
    }

    jQuery("#progress-modal").modal({
        show: true,
        keyboard: false,
        backdrop: false,
    });
}
//----------------------------------
function finishProgress(id){
    
    const countFiles = uppy.getFiles().length;
    const countUp = countUpload.length

    if(countFiles > 0){
        if(countFiles == countUp){
            
            const all = [...countUpload, ...countReg];
            const icon = all.includes(false) ? `times` : `check`;
            const comment = all.includes(false) ? `No todos los puntos se completaron` : `Carga exitosa`;
           
            jQuery(".icon-container").html(`<i class="fa fa-${icon}  fa-3x fa-fw"></i>`);
            jQuery(".ticket-container").html(`<h4>Su ticket es: <b>IN${id}</b></h4>`);
            jQuery(".comment-container").html(`<h4><small>${comment}<small></h4>`);
            jQuery(".close-and-continue").prop("disabled", false);
            clearForm("#inconformidadFormulario", true);
            getList({
                getOnlyMyList: true,
                year: date.getFullYear(),
                //applyDataTable: false
            });
        }
    } else{
        const icon = countReg.includes(false) ? `times` : `check`;
        const comment = countReg.includes(false) ? `No todos los puntos se completaron` : `Carga exitosa`;
        
        jQuery(".icon-container").html(`<i class="fa fa-${icon}  fa-3x fa-fw"></i>`);
        jQuery(".ticket-container").html(`<h4>Su ticket es: <b>IN${id}</b></h4>`);
        jQuery(".comment-container").html(`<h4><small>${comment}<small></h4>`);
        jQuery(".close-and-continue").prop("disabled", false);
        clearForm("#inconformidadFormulario");
        getList({
            getOnlyMyList: true,
            year: date.getFullYear(),
            //applyDataTable: false
        });
    }
}
//----------------------------------
function showPreSendModal(resolve, reject){

    const newGetLadeld = [];

    jQuery("#pre-send-form").modal({
        show: true,
        keyboard: false,
        backdrop: false,
    });
    
    jQuery("#inconformidadFormulario").find(":selected, textarea").each(function(){

        const obj = {};
        const prt = jQuery(this).is("textarea") ? jQuery(this).attr("name") : jQuery(this).parent().attr("name");
        obj["label"] = jQuery(`#label-${prt}`).text().replace(" *:", ":")
        obj["textvalue"] = jQuery(this).is("textarea") ? jQuery(this).val() : jQuery(this).text();
        newGetLadeld.push(obj);
    });

    jQuery(".pre-send-info").html(`
        <div class="col-md-12 text-center">
            <i class="fa fa-exclamation-circle fa-3x" aria-hidden="true"></i>
            <div><h4>Espere un momento</h4></div>
            <div><h4><small>Antes de enviar, confirme si la información que capturó es correcta</small></h4></div>
        </div>
        <div class="col-md-12 mt-4 table-responsive">
            <h4 class="text-left">Información capturada:</h4>
            <div>
                ${
                    newGetLadeld.reduce((acc, curr) => acc += `
                        <div class="row">
                            <div class="col-md-4"><h5>${curr.label}<h5></div>
                            <div class="col-md-8 text-justify"><h4><small>${curr.textvalue}</small></h4></div>
                        </div>
                    `,``)
                }
            </div>
        </div>
    `);

    jQuery(".confirm-send-form").click(function(e){ jQuery("#pre-send-form").modal("hide"), resolve(); });
}
//-----------------------------------
function clearForm(form, deleteFiles = false){

    jQuery(form).trigger("reset");

    if(deleteFiles){

        uppy.reset();
        jQuery("#select-all-files").prop("checked", true).trigger("change");
        jQuery("#delete-selected").trigger("click");
    }
}
//-----------------------------------
function getList(params_){

    const required = ["getOnlyMyList"];
    const valid = Object.keys(params_).map(arr => required.includes(arr));
    
    if(!valid.includes(true)){
        alert("Se requiere que el objeto tenga estos keys: " + required.reduce((acc, curr) => acc += `${curr},`, ``));
        return false;
    }

    const list = axios.get("https://capsys.com.mx/V3/binconformidad/getNCList", {
        params: params_
    }).
    then((response) => {
            
        //console.log(response.data);
        const printList = printNCList({reg: response.data, querySelector: ".nc-content"}); //, applyDataTable: params_.applyDataTable
    }).
    catch((error) => {
        console.log(error);
    });
}
//-----------------------------------
function printNCList(data){

    //jQuery(".nc-list-table").DataTable({destroy: true});

    const trtd = data.reg.reduce((acc, curr, idx) => {
        
        var labelStatus = ``;
        const root = [1].includes(parseInt(curr.aFavor)) ? "resuelto" : "inconforme";
        switch(parseInt(curr.aFavor)){
            case 0:
            case 1: 
                labelStatus = `<button class="btn btn-${curr.label} btn-xs text-white">${curr.status}</button></span>`;
                break;
            case 3:
                labelStatus = `
                    <div class="dropdown">
                        <button class="btn btn-${curr.label} btn-xs text-white dropdown-toggle" type="button" id="dropdownMenu1" data-toggle="dropdown" aria-expanded="true">${curr.status}</button>
                        <ul class="dropdown-menu" role="menu" aria-labelledby="dropdownMenu1">
                            <li role="presentation"><a role="menuitem" class="upload-more-files" data-root="resuelto" finally-nc="true" tabindex="-1" href="#" data-id="${curr.id}">Confirmar de completado</a></li>
                        </ul>
                    </div>
                `;
                break;
        }
        
        acc += `
            <tr>
                <!--<td><input type="checkbox" value="${curr.id}"></td>-->
                <td>IN${curr.id}</td>
                <td>${curr.idCBIArea}</td>
                <td>${curr.idCBIOpcion}</td>
                <td>${curr.idCBIArea}</td>
                <td>${curr.fechaRegistro}</td>
                <td class="show-all-comment" data-id="${curr.id}" style="cursor: pointer">${curr.descripcion}...</td>
                <td>${labelStatus}</td>
                <td>${curr.correoResponsable}</td>
                <td>
                    <div class="dropdown">
                        <button class="btn btn-link btn-sm dropdown-toggle" type="button" id="dropdownMenu${idx}" data-toggle="dropdown" aria-expanded="true"><i class="fa fa-ellipsis-v" aria-hidden="true"></i></button>
                        <ul class="dropdown-menu" role="menu" aria-labelledby="dropdownMenu${idx}">
                            <li role="presentation"><a role="menuitem" tabindex="-1" href="#" class="show-binnacle" data-id="${curr.id}">Ver bitácora</a></li>
                            <li role="presentation" class="divider"></li>
                            <li role="presentation"><a role="menuitem" tabindex="-1" href="#" data-root="${curr.id}" class="show-nc-files">Ver archivos anexos</a></li>
                            <li role="presentation"><a role="menuitem" tabindex="-1" href="#" class="upload-more-files" data-root="${root}" finally-nc="false" data-id="${curr.id}">Agregar archivos</a></li>
                        </ul>
                    </div>  
                </td>
            </tr>`

        return acc;
    }, ``);

    jQuery(data.querySelector).html(trtd);

    /*if(data.applyDataTable){
        jQuery(".nc-list-table").DataTable({
            language: {
                url: 'https://cdn.datatables.net/plug-ins/1.11.5/i18n/es-MX.json',
            },
            ordering: false
        });
    }*/
}
//-----------------------------------
jQuery(document).on("click", ".show-nc-files", function(e){
    
    e.preventDefault();
    const id = jQuery(this).data("root");
    const root = ref(storage, `inconformidades/${id}`);

    listAll(root).then(function(data){
        
        const bodyModal = data.prefixes.length > 0 ? `
            <div class="col-md-12 text-center">
                <div><i class="fa fa-file fa-3x" aria-hidden="true"></i></div>
                <div><h4>Archivos activos</h4></div>
            </div>
            <div class="col-md-12 files-content-table"></div>
        ` : `<h4 class="text-center">No existen archivos anexados</h4>`;

        showInModal({
            header: `Archivos asociados a la inconformidad: IN${id}`,
            body: bodyModal
        });

        //console.log(data);
        
        if(data.prefixes.length > 0){

            for(var a in data.prefixes){
           
                const table_ = jQuery("<table></table>").addClass("table table-hover border").append(
                    jQuery("<tbody></tbody>").addClass(`tbody-${data.prefixes[a].fullPath.split("/").pop()}-content`).append(
                        jQuery("<tr></tr>").append(
                            jQuery("<td></td>").attr("colspan", 3).text(data.prefixes[a].fullPath.split("/").pop().toUpperCase() + ":")
                        )
                    )
                );
    
                jQuery(".files-content-table").append(table_); //Primero crear las tablas y concatenarla en el dom
    
                listAll(ref(storage, data.prefixes[a].fullPath)).
                then((_data) => {
    
                    const files = _data.items;
    
                    for(var b in files){
    
                        const routers = files[b].fullPath.split("/");
                        const deleteLast = routers.pop();
                        const folder = routers.pop();
    
                        const trtd = jQuery("<tr></tr>").append(
                            jQuery("<td></td>").text((parseInt(b) + 1)),
                            jQuery("<td></td>").html(`<a href="javascript: void(0)" class="file-${id}-${folder}-${(parseInt(b) + 1)} text-black">${files[b].name}</a>`),
                            jQuery("<td></td>").html(`<a href="#" class="text-danger delete-file-selected" data-id="${id}" data-root="${folder}" data-name-file="${files[b].name}"><i class="fa fa-times-circle fa-lg" aria-hidden="true"></i></a>`)
                        );
    
                        jQuery(`.tbody-${folder}-content`).append(trtd);
    
                        getDownloadURL(ref(storage, `inconformidades/${id}/${folder}/${files[b].name}`))
                        .then((dwnlurl) => {
            
                            jQuery(`.file-${id}-${folder}-${(parseInt(b) + 1)}`).attr("href", dwnlurl).attr("target", "_blank");
                        })
                        .catch((error) => {
                            console.log(error);
                        });
                    }
                }).
                catch((error) => {
                    console.log(error);
                });
            }
        }
    }).catch(function(error){
        console.log(error);
    });
})
//---------------------------------
jQuery(document).on("click", ".show-binnacle", function(e){

    e.preventDefault();

    const id = jQuery(this).data("id");
    const axios_ = axios.get(`https://capsys.com.mx/V3/binconformidad/getBinnacle/${id}`).
    then((data) => {

        const body = data.data.reduce((acc, curr) => {

            acc += `
                <tr>
                    <td>
                        <h5><span class="label label-primary">${curr.fechaMovimiento}</span></h5>
                        <div class="col-md-12">${curr.movimiento}</div>
                    </td>
                </tr>
            `;

            return acc;
        }, ``);


        const showModal = showInModal({
            header: `Bitácora de la inconformidad: IN${id}`,
            body: `<table class="table"><tbody>${body}</tbody></table>`,
        });
    }).catch((error) => {
        console.log(error);
    });
});
//---------------------------------
jQuery(document).on("click", ".delete-file-selected", function(e){

    e.preventDefault();
    const id = jQuery(this).data("id");
    const folder = jQuery(this).data("root");
    const filename = jQuery(this).data("name-file");
    const ref_ = ref(storage, `inconformidades/${id}/${folder}/${filename}`);
    
    deleteObject(ref_).
    then(() => {

        jQuery(".show-nc-files").each(function(){
            var root = jQuery(this).data("root");
            if(id == root){
                jQuery(this).trigger("click");
            }
        })
    }).
    catch((error) => {
        console.log(error);
    })
});
//---------------------------------
jQuery(document).on("click", ".upload-more-files", function(e){
    
    e.preventDefault();
    var title = jQuery(this).data("root") == "resuelto" ? `Subir archivos de evidencía de inconformidad completado: IN${jQuery(this).data("id")}` : "Subir archivos" ;
    var buttonTitle = jQuery(this).data("root") == "resuelto" ? "Subir y confirmar de compleado" : "Subir";

    jQuery(".dragdrop-body").html("");
    jQuery(".pre-upload-list.row").html("");
    jQuery(".modal-files-title").html(title);
    jQuery(".upload-more-to-cloud").attr("finally-nc", jQuery(this).attr("finally-nc"));
    jQuery("#root-folder").val(jQuery(this).data("root"));
    jQuery("#folio").val(jQuery(this).data("id"));

    jQuery("#modal-upload-nc-file").modal({
        show: true,
        backdrop: false,
        keyboard: false
    });
})
//---------------------------------
function showInModal(data){

    jQuery(".modal-title-others").html(data.header);
    jQuery(".modal-body-others").html(data.body);

    jQuery("#modal-other-content").modal({
        show: true,
        backdrop: false,
        keyboard: false
    });
}
//----------------------------------
jQuery("#select-new-files").on("change", function(e){

    const change = jQuery(this).is(":checked");
    //console.log(change);
    var selectedLabel = change ? `<i class="fa fa-check-circle" aria-hidden="true"></i> Quitar selección` : `<i class="fa fa-check-circle" aria-hidden="true"></i> Seleccionar todos`;

    if(jQuery(".check-file-selected-in_modal").length > 0){
        jQuery(".change-selected-label-in-modal").html(selectedLabel);
    }

    jQuery(".check-file-selected-in_modal").each(function(){
        jQuery(this).prop("checked", change);
    });
});
//---------------------------------
jQuery("#modal-upload-nc-file").on("hide.bs.modal", function(e){

    uppy2.close();

    jQuery("#select-new-files").prop("checked", true).trigger("change");
    jQuery("#delete-selected-in-modal").trigger("click");
    jQuery(".bar-progress-in-modal").html("");
});
//--------------------------------
jQuery("#delete-selected-in-modal").on("click", function(e){

    e.preventDefault();
    //console.log("apply in modal");
    jQuery(".check-file-selected-in_modal").each(function(){
            
        if(jQuery(this).is(":checked")){
            
            uppy2.removeFile(jQuery(this).val());
            jQuery(this).parent().parent().remove();
        }
    });

    if(uppy2.getFiles().length == 0){
        jQuery("#select-new-files").prop("checked", false);
        jQuery("#select-new-files").trigger("change");
    }
});
//--------------------------------
jQuery("#modal-upload-nc-file").on("show.bs.modal", function(e){
    
    uppy2.use(
        DragDrop, {
            target: '.dragdrop-container .dragdrop-body',
        }
    );
});
//--------------------------------
jQuery(".upload-more-to-cloud").on("click", function(e){

    const files = uppy2.getFiles();
    const subDirectory = jQuery("#folio").val();
    const otherSubDirectory = jQuery("#root-folder").val();
    const _finally = jQuery(this).attr("finally-nc");

    if(files.length == 0){
        alert("No se encontraron archivos cargados");
        return false;
    }

    jQuery(".bar-progress-in-modal").html(`
        <div class="text-center"><h5>Subiendo archivos...</h5></div>
        <div class="progress">
            <div class="progress-bar progress-bar-in-modal" role="progressbar" aria-valuenow="0" aria-valuemin="0" aria-valuemax="100" style="width: 0%;">0%</div>
        </div>
    `);

    //Upload to cloud
    for(var a in files){
        const storageRef = ref(storage, `inconformidades/${subDirectory}/${otherSubDirectory}/${files[a].name}`);
        const uploadTask = uploadBytesResumable(storageRef, files[a].data);

        uploadTask.on("state_changed", 
            (snapshot) => {
                const progress = (snapshot.bytesTransferred / snapshot.totalBytes) * 100;
                jQuery(".progress-bar-in-modal").attr("aria-valuenow", progress).css("width", `${progress}%`).text(`${progress}%`)
            },
            (error) => {
                alert(error);
                jQuery(".progress-bar-in-modal").addClass("progress-bar-danger");
                return false;
            },
            () => {
                getDownloadURL(uploadTask.snapshot.ref).then((url) => {

                    jQuery(".progress-bar-in-modal").addClass("progress-bar-success");

                    if(_finally === "true"){ //Desplegar modal de aviso de inconformidad terminada.
                        
                        validFinally.push(true);
                        const updateData = updateNC(subDirectory);
                        //jQuery("#modal-upload-nc-file").modal("hide");
                    }

                }).catch((error) => {
                    alert(error);
                    jQuery(".progress-bar-in-modal").addClass("progress-bar-danger");
                    validFinally.push(false);
                    return false;
                })
            }
        )
    }
});
//-------------------------------
jQuery("#filter-form").on("submit", function(e){

    e.preventDefault();
    const getparams = jQuery(this).serializeArray().reduce((acc, curr) => {
        return { ...acc, [curr.name]: curr.value }
    }, {});
    
    const axios_ = axios.get( jQuery(this).attr("action"), {
        params: getparams
    }).then((response) => {

        const valid = response.data.length == 0;
        //console.log(response);

        jQuery(".show-alert").append(
            jQuery(`<div></div>`).
                addClass(`alert alert-${!valid ? `success` : `danger`}`).
                attr("role", "alert").
                text(!valid ? `Se encontraron ${response.data.length} registro(s).` : `No se encontraron resultados.`).
                append(
                    jQuery("<button></button>").
                    attr("type", "button").
                    attr("data-dismiss", "alert").
                    attr("aria-label", "Close").
                    addClass("close").
                    html(`<span aria-hidden="true">&times;</span>`)
            )
        );
        
        const printList = printNCList({reg: response.data, querySelector: ".nc-content", applyDataTable: false});

    }).catch((error) => {
        console.log(error);
    })
});
//-------------------------------
jQuery(document).on("click", ".show-all-comment", function(e){

    const id = jQuery(this).data("id");

    const axios_ = axios.get("https://capsys.com.mx/V3/binconformidad/getComment", { params: { id: id } }).
    then((response) => {
        //console.log(response.data);
        const bodyModal = `
            <div class="panel panel-default">
                <div class="panel-body border">
                    <h5><span class="label label-primary">Comentario</span></h5><h5><span class="label label-primary">${response.data[0].fechaRegistro}</span></h5>
                    <p class="text-justify">${response.data[0].descripcion}</p>
                </div>
            </div>
        `;

        showInModal({
            header: `Comentario de la inconformidad: IN${id}`,
            body: bodyModal
        })
    }).
    catch((error) => {
        console.log(error);
    });
});
//-------------------------------
function updateNC(id){

    //console.log(validFinally);

    if(uppy2.getFiles().length == validFinally.length && validFinally.includes(true)){

        const axios_ = axios.post(`https://capsys.com.mx/V3/binconformidad/updateNC/${id}`).
        then((data) => {
            //console.log(data);
            if(data.data.success){

                jQuery("#modal-upload-nc-file").modal("hide");

                getList({
                    getOnlyMyList: true,
                    year: date.getFullYear(),
                    //applyDataTable: false
                });

                const showModal = showInModal({
                    header: `Estado de inconformidad`,
                    body: `
                        <div class="text-center">
                            <div><i class="fa fa-check fa-3x" aria-hidden="true"></i></div>
                            <div><h4>Inconformidad IN${id} finalizada</h4></div>
                            <div><h4><small>Todo salió de manera correcta</small></h4></div>
                        </div>
                    `,
                });
            }
        }).
        catch((error) => {
            console.log(error);
            const showModal = showInModal({
                header: `Estado de inconformidad`,
                body: `
                    <div class="text-center">
                        <div><i class="fa fa-times fa-3x" aria-hidden="true"></i></div>
                        <div><h4>Ups...</h4></div>
                        <div><h4><small>La inconformidad IN${id} no realizó el cambio de manera correcta</small></h4></div>
                    </div>
                `,
            });
        });
    }
}
//-------------------------------