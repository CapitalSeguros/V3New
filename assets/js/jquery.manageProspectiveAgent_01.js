
$(document).on("click", ".agent-details", function(){

    const id_ = $(this).data("id");
    const content_ = $(this).data("content");
    const baseUrl = $(`#url`).data(`url`);
    //console.log(baseUrl);

    $.ajax({
        method: "GET",
        url: `${baseUrl}crmproyecto/getAgentData`,
        data: {
            id: id_
        },
        beforeSend: function(){
            console.log(`load`);
            $(`.data-panel`).html(`<h3>Cargando progreso...</h3>`);
        },
        error: function(error){
            console.log(error);
        },
        success: function(data){
            
            var resp = JSON.parse(data);
            console.log(resp);
            $(`.data-panel`).html(``);

            var divs = ``;
            var li_ = [];
            for(var a in resp){
                
                li_.push(resp[a].title);
                var generalDataContent = ``;
                if(a == 0){

                    var generalData_ = resp[0].data[0];
                    var generalData = ``;
                    for(var b in generalData_){ //Información general
                        
                        var getInputs = getLabel(b);
                        if(getInputs !== undefined){

                            var typeInput = ``;

                            if(getInputs.type_ !== "textarea" && getInputs.type_ !== "option"){
                                typeInput = `<input type="${getInputs.type_}" class="form-control" id="${b}" name="${b}" value="${generalData_[b]}">`;
                            } else if(getInputs.type_ == "textarea"){
                                typeInput = `<textarea class="form-control" name="${b}" rows="6" required>${generalData_[b]}</textarea>`;
                            } else if(getInputs.type_ == "option"){

                                var options = ["NO CONTACTADO", "CONTACTADO", "DESCARTADO", "EN PROCESO", "RECLUTADO"];
                                var optionsDisabled = ["EN PROCESO", "RECLUTADO"];

                                typeInput = `
                                <select class="form-control" name="${b}">
                                    ${options.map((arr, i) => {
                                        
                                        return `<option value="${arr}" ${generalData_[b] == arr ? "selected" : ""} ${optionsDisabled.includes(arr) ? "disabled" : ""}>${arr}</option>`;
                                    })}
                                </select>`;
                            }

                            generalData += `
                                <div class="form-group">
                                    <label for="labelNombre" class="col-md-4 control-label text-left">${getInputs.label_}</label>
                                    <div class="col-md-8">
                                        ${typeInput}
                                    </div>
                                </div>
                            `;
                        }
                    }

                    generalDataContent += `
                            <form id="${resp[0].data[0].id}" class="form-horizontal form-general">
                                <div style="height: 300px; overflow-y: auto">
                                    ${generalData}
                                </div>
                                <hr>
                                <div class="text-center"><button class="btn btn-primary btn-sm update-general-data">Registrar datos</button></div>
                            </form>`;
                } else if(a == 1){
                    //generalDataContent
                    var pass1 = resp[1].data;
                    for(var i in pass1){

                            var requeriment = pass1[i].requirements;
                        if(requeriment.length > 0){

                            var layouts = requeriment.reduce((acc, curr) => {

                                acc += `<tr>
                                    <td>
                                        <div class="row">
                                            <div class="col-md-12">${curr.docName}</div>
                                            <div class="col-md-12">${curr.description}</div>
                                        </div>
                                    </td>
                                    <td>${curr.attachment.length > 0 ? `<span class="label label-success">Anexado</span>` : `<span class="label label-warning">Pendiente</span>`}</td>
                                </tr>`;

                                return acc;
                            }, "");


                            var dissabledButton = requeriment.filter(arr => arr.attachment.length == 0);
                            //console.log(dissabledButton);

                            generalDataContent += `
                                <p>Avance en documentación requerida del agente temporal: <b>${resp[0].data[0].prospecto}</b></p>
                                <p>Una vez que el agente temporal concluya con la documentación requerida se dará de alta en el sistema para proceder con el seguimiento de inducción en el módulo de capacita.</p>
                                <p>Avance: </p>
                                <div style="height: 350px; overflow-y: auto;">
                                    <table class="table">
                                        <tbody>
                                            ${layouts}
                                        </tbody>
                                    </table>
                                </div>
                                ${dissabledButton.length == 0 ? `<hr><div class="text-center"><button class="btn btn-success btn-sm release-agent" data-person="${pass1[i].idPerson}">Liberar agente para inducción</button></div>` : ""}
                            `;

                        } else{
                            if(resp[1].data[0].progress == "induccion"){
                                //correo
                                generalDataContent += `
                                    <p>El prospecto con nombre: ${resp[0].data[0].prospecto}. Ya se encuentra dado de alta en el sistema del V3 como usuario temporal. Por lo que es necesario notificar al mismo para el curso de inducción</p>
                                    <p>Para notificar a su correo de contacto (<b>${resp[0].data[0].correo}</b>) favor de dar click a al botón</p>
                                    <hr>
                                    <p class="text-center"><button class="btn btn-info btn-sm sendNotification" data-prospective="${resp[1].data[0].idProspective}" data-person="${resp[1].data[0].idPerson}">Notificar al agente nuevo</button></p>

                                `;
                            } else if(resp[1].data[0].progress == "alta"){
                                generalDataContent += `<p>El prospecto de agente con nombre: <b>${resp[0].data[0].prospecto}</b> y correo: <b>${resp[0].data[0].correo}</b>; no esta dado de alta desde capital humano. Favor de registrarlo para proceder con su avance.</p>
                                    <p>Click al botón para registrar al agente en modo temporal</p>
                                    <p class="text-center">
                                        <!--<button class="btn btn-info btn-sm">Registrar en capital humano</button>-->
                                        <a class="btn btn-info btn-sm" role="button" href="${baseUrl}persona/agente?prospecto=${resp[0].data[0].id}">Registrar en capital humano</a>
                                    </p>
                                `;
                            }
                        }
                    }
                }

                divs += `
                    <div class="tab-pane text-left ${a == 0 ? `active` : ``}" role="tabpanel" id="${resp[a].title.replace(" ", "-").toLowerCase()}">
                        <h5>${resp[a].title.toUpperCase()}</h5>
                        ${generalDataContent}
                    </div>
                `;
            }
            //------------------------------------

            $(`.data-panel-${content_}`).html(`<ul class="nav nav-tabs" role="tablist">${li_.reduce((acc, cur, idx) => {

                acc += `<li role="presentation" ${idx == 0 ? `class="active"` : ``}><a href="#${cur.replace(" ","-").toLowerCase()}" aria-controls="${cur.replace(" ","-").toLowerCase()}" role="tab" data-toggle="tab">${cur.toUpperCase()}</a></li>`;
                return acc;
            }, "")}</ul><div class="tab-content">${divs}</div>`);
            //------------------------------------
        }
    });
});

function getLabel(key){

    switch(key){
        case "tiene_cedula": return  {label_: "Cédula", type_: "text"};
        break;
        case "prospecto": return {label_: "Nombre del prospecto", type_: "text"};
        break;
        case "apellido_paterno": return {label_: "Apellido paterno", type_: "text"};
        break;
        case "apellido_materno": return {label_: "Apellido materno", type_: "text"};
        break;
        case "correo": return {label_: "Correo electrónico", type_: "email"};
        break;
        case "numero_telefono": return {label_: "Teléfono", type_: "tel"};
        break;
        case "calle": return {label_: "Calle", type_: "text"};
        break;
        case "cruzamiento": return {label_: "Cruzamiento", type_: "text"};
        break;
        case "colonia": return {label_: "Colonia", type_: "text"};
        break;
        case "numero": return {label_: "Número", type_: "text"};
        break;
        case "municipio": return {label_: "Municipio", type_: "text"};
        break;
        case "estado": return {label_: "Estado", type_: "text"};
        break;
        case "pais": return {label_: "País", type_: "text"};
        break;
        case "codigo_postal": return {label_: "Códido Postal", type_: "text"};
        break;
        case "fecha": return {label_: "Fecha de alta", type_: "text"};
        break;
        case "comentarios": return {label_: "Comentario", type_: "textarea"};
        break;
        case "medio": return {label_: "Medio", type_: "text"};
        break;
        case "status": return {label_: "Estado", type_: "option"};
        break;
        //default: return key;
    }
}

$(document).on("submit", ".form-general", function(e){

    e.preventDefault();
    //console.log($(this).attr("id"));
    var idProspective = $(this).attr("id");
    const baseUrl = $(`#url`).data(`url`);
    var form = $(this).serializeArray();
    form.push({name: "id", value: idProspective});
    //console.log(form);
    $.ajax({
        type: "POST",
        url: `${baseUrl}crmproyecto/updateProspectiveData`,
        data: {data_: JSON.stringify(form)},
        success: function(response){
            console.log(response);
            var res = JSON.parse(response);
            if(res.response){
                alert("Registro del prospecto de agente actualizado");
                window.location.reload();
            }
        },
        error: function(error){
            console.log(error);
        }
    });
});

$(document).on("click",".btn-selected", function(){

    var class_ = $(this).data("class");
    var check = $(this).data("check");

    if($(`.check-${class_}`).is(":checked")){
        $(`.check-${class_}`).prop("checked", false);
        $(this).attr("data-check", 0);
    } else {
        $(`.check-${class_}`).prop("checked", true);
        $(this).attr("data-check", 1);
    }
    
});

$(document).on("click", ".earmarked-to", function(){
    
    var earmarked = $(this).data("mail");
    var class_ = $(this).data("class");
    $(`#earmarked-${class_}`).val(earmarked);
});

$(document).on("click", ".confirm", function(){

    var tab = $(this).data("tab");
    var input = $(`#earmarked-${tab}`).val();
    const baseUrl = $(`#url`).data(`url`);
    var changes = [];

    $(`.check-${tab}`).each(function(){
        if($(this).is(":checked")){
            changes.push($(this).val());
        }
       
    });

    if(changes.length == 0){
        alert("No hay prospectos seleccionados");
        return false;
    } else if(input == ""){
        alert("No se seleccionó a un asignado");
        return false;
    }

    $.ajax({
        type: "POST",
        url: `${baseUrl}crmproyecto/updateEarmarked`,
        data: {
            asignado: input,
            prospectos: changes.join()
        },
        success: function(response){
            console.log(response);
            alert("Se ha realizado la reasignación");
            window.location.reload();
        },
        error: function(error){
            console.log(error);
        }
    })
    console.log(changes);

});

$(document).on("click", ".release-agent", function(){

    var id_ = $(this).data("person");
    const baseUrl = $(`#url`).data(`url`);

    $.ajax({
        type: "POST",
        url: `${baseUrl}persona/registerTemporalUser`,
        data: {
            id: id_
        },
        success: function(response){

            var resp = JSON.parse(response);

            alert(resp.message);
            window.location.reload();
        },
        error: function(error){
            console.log(error);
        }
    })
});

$(document).on("click", ".sendNotification", function(){

    var prospective= $(this).data("prospective");
    var person= $(this).data("person");
    const baseUrl = $(`#url`).data(`url`);

    $.ajax({
        type: "POST",
        url: `${baseUrl}crmproyecto/sendNotification`,
        data: {
            person: person,
            prospective: prospective
        },
        success: function(response){

            var resp = JSON.parse(response);
            console.log(resp);
            alert(resp.message);
            //window.location.reload();
        },
        error: function(error){
            console.log(error);
        }
    })
});