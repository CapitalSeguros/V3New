//Load firebase storage.

const firebaseConfig = {
    apiKey: "AIzaSyBa6S-7_FtZE_cMxNz33e1Tvil3PGnON_4",
    authDomain: "v3plus-279402.firebaseapp.com",
    databaseURL: "https://v3plus-279402.firebaseio.com",
    projectId: "v3plus-279402",
    storageBucket: "v3plus-279402.appspot.com",
    messagingSenderId: "4568272251",
    appId: "1:4568272251:web:483a7b036920897138c1de",
    measurementId: "G-8EJP31SQZ7"
};

firebase.initializeApp(firebaseConfig);
const storage = firebase.storage();

$("#generatetutorial").click(function(e){

    var file = $("#tutorialfile").prop("files")[0];
    var name = $("#tutorialname").val();
    var module = $("#tutorialmodule option:selected").val();
    var moduleName = $("#tutorialmodule option:selected").text();
    var idTutorial = $("#tutorial-id").val();

    if(name == ""){
        alert("No se asigno un nombre a bloque de tutoria");
        return false;
    } else if(module == "0"){
        alert("No se seleccionó un módulo de destino");
        return false;
    } else if(file == undefined){
        alert("No se cargó el archivo");
        return false;
    }

    if(idTutorial > 0){

        var tutorialExists = $(`.tutorial-no-${idTutorial}`).find("div").eq(2).text().split(" ");
        console.log(tutorialExists[1]);
        var deleteFile = deleteFileFromCloud(moduleName, tutorialExists[1]);
    }
    //firebase storage processing
    var uploadfile = uploadFileToFirebase(file, moduleName);
});

//--------------------------
var progress = false;
$(document).on("click", ".progress-action", function(e){

    console.log($(this).data("action"));
    var action = $(this).data("action");

    switch(action){
        case "pause": progress = uploadFile.pause();
        break;
        case "resume": progress = uploadFile.resume(); 
        break;
        case "canceled": progress = uploadFile.cancel();
        break;
    }

    if(action == "canceled"){
        $(".pause").addClass("hidden").removeClass("show");
        $(".resume").addClass("hidden").removeClass("show");
        $(".progress-bar").addClass("progress-bar-danger").removeClass("progress-bar-warning");
    }
});
//--------------------------
var uploadFile;

function uploadFileToFirebase(file, module){
    var storageref = storage.ref(`modulos_de_tutoria/${module}/${file.name}`);
    uploadFile = storageref.put(file);
    uploadFile.on("state_changed", 
        (snapshot) => {
        var progress = (snapshot.bytesTransferred/snapshot.totalBytes) * 100;
        //console.log(progress);
        //console.log(snapshot.state);
        switch (snapshot.state) {
            case "paused": // or 'paused'
                console.log('Upload is paused');
                $(".progress-bar").addClass("progress-bar-warning");
                $(".pause").addClass("hidden").removeClass("show");
                $(".resume").addClass("show").removeClass("hidden");
              break;
            case "running": // or 'running'
              console.log('Upload is running');
                $(".upload-progress").html(`
                    <h4>Carga en progreso</h4>
                    <div class="progress">
                        <div class="progress-bar" role="progressbar" aria-valuenow="${parseInt(progress)}" aria-valuemin="0" aria-valuemax="100" style="width: ${parseInt(progress)}%;">
                        ${parseInt(progress)}%
                        </div>
                    </div>
                    <div class="col-md-7">
                        <div class="row">
                            <div class="col-md-4 progress-action hidden resume" data-action="resume"><div role="button"><i class="fa fa-play" aria-hidden="true"></i> Reanudar</div></div>
                            <div class="col-md-4 progress-action pause" data-action="pause"><div role="button"><i class="fa fa-pause" aria-hidden="true"></i> Pausar</div></div>
                            <div class="col-md-4 progress-action cancel" data-action="canceled"><div role="button"><i class="fa fa-ban" aria-hidden="true"></i> Cancelar</div></div>
                        </div>
                    </div>
                `);

                $(".progress-bar").removeClass("progress-bar-warning");
                $(".pause").addClass("show").removeClass("hidden");
                $(".resume").addClass("hidden").removeClass("show");
              break;
          }
    }, (error) => {
        console.log(error);
    }, () => {
        $(".pause").addClass("hidden").removeClass("show");
        $(".resume").addClass("hidden").removeClass("show");
        $(".cancel").addClass("hidden").removeClass("show");
        var saveData = registerData(file);
    });
}

//--------------------
function registerData(file){

    var name = $("#tutorialname").val();
    var module = $("#tutorialmodule option:selected").val();
    var baseUrl = $("#base_url").data("base-url");
    var moduleName = $("#tutorialmodule option:selected").text();
    var description = $("#tutorialdescription").val();
    $(".upload-complete").removeClass("hidden"); //html(`<h4>Tutorial subido al sistema</h4><div class="tutorial-uploaded"></div>`);
    //Processing data in AJAX
    $.ajax({
        type: `POST`,
        url: `${baseUrl}permisosOperativos/registerTutorial`,
        data: {
            name: name,
            moduleId: module,
            file: file.name,
            description: description,
            idTutorial: $("#tutorial-id").val()
        },
        error: function(error){
            console.log(error);
        },
        success: function(response){

            var resp = JSON.parse(response);
            console.log(resp);

            $("#tutorial-id").val(resp.lastId);

            if(resp.type == "creat"){

                var paintResult = paintUpload(resp.lastId, file.name, name, moduleName, resp.dateUpload, resp.status);
            } else{
                $(`.tutorial-no-${resp.lastId}`).find("div").eq(2).html(`<p>Archivo: ${file.name}</p>`);
                $(`.tutorial-no-${resp.lastId}`).find("div").eq(3).html(`<p>Nombre de la tutoria: ${name}</p>`);
                $(`.tutorial-no-${resp.lastId}`).find("div").eq(5).html(`<p>${resp.dateUpload}</p>`);
                $(`.tutorial-no-${resp.lastId}`).find("div").eq(6).html(`<h5><span class="label label-info">Actualizado</span></h5>`);
            }
            
            $(".to-tutorial-content").html("<button class='btn btn-primary to-tutorials text-white'>Ir a listado de tutoriales</button>");
            $(".clear-form").html("<button class='btn btn-primary clear-inputs text-white'>Nueva carga</button>");
            //}

            if(!confirm("¿Desea seguir trabajando en el módulo actual de carga de tutoriales?")){
                window.location.reload();
            }
        }
    });
}
//---------------------------
function paintUpload(resp, fileName, name, moduleName, dateCreation_, status){
    
    var dateCreation = "";
    var label = "";

    if(status){
        dateCreation = dateCreation_;
        label = `<h5><span class="label label-success">Cargado</span></h5>`;
    } else{
        dateCreation = "Sin fecha";
        label = `<h5><span class="label label-danger">Error</span></h5>`;
    }

    var result = $(".tutorial-uploaded").append(
        $("<div></div>").addClass(`row tutorial-no-${resp}`).append(
            $("<div></div>").addClass("col-md-2").append(
                $("<p></p>").text(`Módulo: ${moduleName}`)
            ),
            $("<div></div>").addClass("col-md-7").append(
                //$("<div></div>").append(
                    $("<div></div>").addClass("col-md-12 no-gutters").append($("<p></p>").text(`Archivo: ${fileName}`)),
                    $("<div></div>").addClass("col-md-12 no-gutters").append($("<p></p>").text(`Nombre de la tutoria: ${name}`))
                //)
            ),
            $("<div></div>").addClass("col-md-3").append( 
                //$("<div></div>").append(
                    $("<div></div>").addClass("col-md-12 no-gutters text-right").append($("<p></p>").text(dateCreation)),
                    $("<div></div>").addClass("col-md-12 no-gutters text-right").html(label) //.append($("<p></p>")
                //)
            )
        ),
        $("<hr>")
    );

    return result;
}
//---------------------------
$(document).on("click", ".to-tutorials", function(){
    console.log("hola");
    $('#myTab a[href="#tutorial_lista"]').tab('show');
    $("#tutorial-lista").addClass("active");
});
//---------------------------
$(document).on("click", ".clear-inputs", function(){

    $("#tutorial-id").val(0);
    $("#tutorialname").val("");
    $("#tutorialfile").val("");
    $("#tutorialmodule").val(0);
    $(".upload-progress").html("");
});

//-------------------------
function deleteFileFromCloud(folder, file){

    var desertRef = storage.ref(`modulos_de_tutoria/${folder}/${file}`);
    desertRef.delete().then(function(){
        console.log("deleted successfully");
    }).catch(function(error){
        alert("Ocurrió un error al actualizar ela archivo. Contacte al departamento de sistemas");
    });
}
//-----------------------
$(document).on("click", ".deleteRegister", function(){

    //console.log($(this).data("id"));
    var idRegister = $(this).data("id");
    var module = $(this).data("module");
    var doc = $(this).data("doc");
    var baseUrl = $("#base_url").data("base-url");

    var deleteFile = deleteFileFromCloud(module.toUpperCase(), doc);

    $.ajax({
        type: "POST",
        url: `${baseUrl}permisosOperativos/deleteTutorialRegister`,
        data: {
            register: idRegister
        },
        error: function(error){
            alert(`Error detectado: ${error}`);
        },
        success: function(resp){
            var response = JSON.parse(resp);
            console.log(response);

            if(response.result){
                $(`#${module}-${idRegister}`).remove();
            }
        }
    });
});

//-----------------------
$(document).on("click", ".updateRegister", function(){

    $('#myTab a[href="#create-tutorial"]').tab('show');
    var baseUrl = $("#base_url").data("base-url");
    var tutorial = $(this).data("id");
    $.ajax({
        type: "GET",
        url: `${baseUrl}permisosOperativos/getTutorialForUpdate`,
        error: function(error){
            alert(`Error detectado: ${error}`);
        },
        success: function(resp){
            var response = JSON.parse(resp);
            var tutorial_ = response.filter(arr => arr.idTutorial == tutorial).reduce((acc, curr) => acc = curr, {});
            console.log(tutorial_);

            $("#tutorial-id").val(tutorial_.idTutorial);
            $("#tutorialname").val(tutorial_.name);
            $("#tutorialmodule").val(tutorial_.idModule);
            $(".help-block").html(`Video cargado: ${tutorial_.nameDoc}`)
            $("#tutorialdescription").val(tutorial_.description);

            var paintResult = paintUpload(tutorial_.idTutorial, tutorial_.nameDoc, tutorial_.name, tutorial_.modulo, tutorial_.dateCreation, true);
            $(".upload-complete").removeClass("hidden");
            //$(".upload-progress").html("");
            
        }
    });
});
//-----------------------
$(document).on("click", ".show-file", function(){

    storage.ref(`modulos_de_tutoria/`).child(`${$(this).data("module").toUpperCase()}/${$(this).data("file")}`). //
    getDownloadURL().then(function(url){
        console.log(url);
        //$(this).prop("href", url).click();
        var xmlhttp = new XMLHttpRequest();
        xmlhttp.responseType = "blob";
        xmlhttp.onload = function(event){
            var blob = xmlhttp.response;
        };
        xmlhttp.open("GET", url);
        xmlhttp.send();

        //$(this).attr("href", url);
        //$(this).click();

    }). catch(function(error){

        switch (error.code) {
            case 'storage/object-not-found': alert("No se encuentra el archivo solicitado. Favor de contactar al departamento de sistemas.");
              // File doesn't exist
              break;
        
            case 'storage/unauthorized':alert("No tienes autorizado ver este archivo. Favor de contactar al departamento de sistemas.");
              // User doesn't have permission to access the object
              break;
        
            case 'storage/canceled': alert("Se ha cancelado la carga del archivo. Favor de contactar al departamento de sistemas.");
              // User canceled the upload
              break;
        }
    });

});

//----------------------
/*$(document).on("click", ".refresh-content", function(){

    console.log($(".tab-tutorial-modules.active"));
});*/
///---------------------