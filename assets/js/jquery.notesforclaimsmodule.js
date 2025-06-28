$(document).on("click", ".show-notes-modal", function(){

    const type = $(this).data("type");
    const id = $(this).data("id");
    const client = $(this).data("insured");
    const policy = $(this).data("policy");
    const typeSinister = $(this).data("type-sinister");
    const number = $(this).data("number");
    //console.log(client);

    $("#number-policy").val(number);
    $("#client-policy").val(client);
    $("#sinister-type").val(type.toUpperCase());
    $("#number-sinister").val(policy);
    $("#sinister-type-child").val(typeSinister);
    $("#id-row").val(id);

    $(".notes-modal").modal({
        show: true,
        keyboard: false,
        backdrop: false,
    })
});

//-------------------------
$(document).on("change", ".selected-all", function(){

    const group = $(this).data("group"); 
    const click = $(this).prop("checked");

    $(`.check-${group}`).each(function(){

        $(this).prop("checked", click);
    });
});

//-------------------------
$(".create-note").click(function(){

    const form = $("#sinister-note").serialize();
    const baseUrl = $("#base_url").data("base-url");
    const controller = getController($("#sinister-type").val().toLowerCase());

    //console.log(controller);
    // AJAX Request: POST
    const ajax = $.ajax({
        type: "POST",
        url: `${baseUrl+controller}/manageNote`,
        data: form,
        error: (error) => {
            console.log(error.responseText);
        },
        success: (data) => {
            const response = JSON.parse(data);
            //console.log(response);

            if(response.bool){
                alert("Nota creada");
                $(".notes-modal").modal("hide");
                $("#sinister-note")[0].reset();
            }
        }
    });
    //console.log(form);
});
//------------------------
$(".close-modal").click(function(){
    
    $("#sinister-note")[0].reset();
});
//------------------------

const getController = (data) => {

    var controller = ``;
    switch(data){
        case "autos": controller = "Autos";
        break;
        case "daños": controller = "Danos";
        break;
        case "gmm": controller = "GMM";
        break;
        case "autos corporativo": controller = "Siniestros";
        break;
    }

    return controller;
}

//---------------------------
$(document).on("click", ".show-list-notes-modal", function(){

    const id = $(this).data("id");
    const baseUrl = $("#base_url").data("base-url");
    const type = $(this).data("type");
    const controller = getController($(this).data("type").toLowerCase());

    const ajax = $.ajax({
        type: "GET",
        url: `${baseUrl+controller}/getNotes`,
        data: { 
            id: id
        },
        error: (error) => {
            console.log(error.responseText);
        },
        success: (data) => {
            const response = JSON.parse(data);
            console.log(response);
            $(".list-notes-body").html("");
            var trtd = ``;
            var divContent = ``;

            for(var a in response){
                //console.log(a);

                const assigned  = response[a].persons.reduce((acc, curr) => acc += `<tr class="text-muted"><td><div>${curr.name}</div><div>${curr.email}</div></td></tr>`, ``);

                trtd += `
                    <tr id="tr-${a}">
                        <!--<td>${response[a].note}</td>-->
                        <td>${response[a].dateCreate}</td>
                        <td>${response[a].creator}</td>
                        <td>
                            <div class="dropdown">
                                <button class="btn btn-link btn-sm dropdown-toggle" type="button" id="dpd-${id}-${a}" data-toggle="dropdown" aria-expanded="true">
                                Opciones
                                </button>
                                <ul class="dropdown-menu" role="menu" aria-labelledby="dpd-${id}-${a}" id="tab-options">
                                    <li role="presentation"><a role="menuitem" tabindex="-1" href="javascript: void(0)" data-id="${a}" data-controller="${response[a].typesinister}" class="update-note">Editar</a></li>
                                    <li role="presentation"><a role="menuitem" tabindex="-1" href="javascript: void(0)" data-id="${a}" data-sinister="${id}" data-controller="${type}" class="delete-note">Eliminar</a></li>
                                    <li role="presentation"><a role="menuitem" tabindex="-1" href="javascript: void(0)" data-id="${id}-${a}" data-controller="${type}" class="show-data-note">Ver detalle</a></li>
                                </ul>
                            </div>
                      </td>
                    </tr>`;
                
                divContent += `<div class="hidden panel panel-body detail-div border" id="${id}-${a}">
                    <p>Contenido de la nota</p>
                    <div class="col-md-12 mb-4">
                        <p>Detalle del siniestro</p>
                        <div class="row">
                            <div class="col-md-4"><p class="text-muted"><span class="font-weight-bold">Póliza:</span> ${response[a].policy}</p></div>
                            <div class="col-md-6"><p class="text-muted"><span class="font-weight-bold">Número de siniestro:</span> ${response[a].numberSinister}</p></div>
                            <div class="col-md-6"><p class="text-muted"><span class="font-weight-bold">Asegurado:</span> ${response[a].insure}</p></div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6">
                            <div class="col-md-12 border-right">
                                <p>Descripción de la nota</p>
                                <div style="height: 150px; overflow-y: auto">
                                    <p class="text-muted">${response[a].note}</p>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="col-md-12 table-responsive">
                                <p>¿Quién puede ver la nota?</p>
                                <div style="height: 150px; overflow-y: auto">
                                    <table class="table">
                                        <tbody>${assigned}</tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>`;
            }

            $(".list-notes-body").html(trtd); //details-note-content
            $(".details-note-content").html(divContent);
        }
    });

    $(".list-notes-modal").modal({
        show: true,
        keyboard: false,
        backdrop: false,
    })
});
//----------------------------
$(document).on("click", ".delete-note", function(){

    const idNote = $(this).data("id");
    const idSinister = $(this).data("sinister");
    const baseUrl = $("#base_url").data("base-url");
    const controller = getController($(this).data("controller").toLowerCase());

    //console.log(controller);

    const ajax = $.ajax({
        type: "POST",
        url: `${baseUrl+controller}/deleteNote`,
        data: { 
            id: idNote
        },
        error: (error) => {
            console.log(error.responseText);
        },
        success: (data) => {
            const response = JSON.parse(data);
            //console.log(response);

            alert(response.message);

            if(response.bool){

                $(`#tr-${idNote}`).remove();
                $(`#${idSinister}-${idNote}`).remove();
            }
        }
    });
});
//----------------------------
$(document).on("click", ".show-data-note", function(){

    const tab = $(this).data("id");
    console.log(tab);
    $(".detail-div").each(function(){

        $(this).addClass("hidden").removeClass("show");
    });

    $(`#${tab}`).addClass("show").removeClass("hidden")
});

//----------------------------
$(document).on("click", ".show-info", function(){

    const id = $(this).data("idnote");
    const baseUrl = $("#base_url").data("base-url");
    const controller = getController($(this).data("controller").toLowerCase());
    $("#title-policy").html("Descripción de la nota " + $(this).data("policy"));

    const ajax = $.ajax({
        type: "GET",
        url: `${baseUrl+controller}/getNote`,
        data: { 
            id: id
        },
        error: (error) => {
            console.log(error.responseText);
        },
        success: (data) => {
            const response = JSON.parse(data);
            console.log(response);

            $(".note-description").html(`<p class="text-muted">${response.note}</p>`);
        }
    });
});
//----------------------------
$(document).on("click", ".update-note", function(){

    const id = $(this).data("id");
    const controller = $(this).data("controller"); //getController($(this).data("controller").toLowerCase());
    const toController = $(this).data("controller") == "S" ? "Siniestros" : "Siniestro_catalogos";
    const baseUrl = $("#base_url").data("base-url");
    window.location.href=`${baseUrl + toController}/editNoteOfSinister/${controller}/${id}`;
    //console.log(id, controller);
    //$(".list-notes-modal").modal("toggle");
    //$(".list-notes-modal").on('hidden.bs.modal', function (e) {
        //e.preventDefault();
        //console.log("show");
        //$(".notes-modal").modal({
            //show: true,
            //keyboard: false,
            //backdrop: false,
        //});
        //return false;
    //});
    
});
//----------------------------

//$(".close-list").click(function(){
    //$(".list-notes-modal").modal("toggle");
    //$(".notes-modal").off("modal");
//});