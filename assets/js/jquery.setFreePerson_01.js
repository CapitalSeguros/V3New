$(function(){

    console.log("set me free");
    
    if($("#setfree").length > 0){

        var base_url = $("#base_url").data("base-url");
        var freePerson = $("#setfree").val();
        
        $(`#idPersonas option[value=${freePerson}]`).prop("selected", true);
        $(`#alert`).modal({
            keyboard: false,
            backdrop: "",
            show: true
        });
        axios.get(`${base_url}persona/getPersonalData`, {
            params: {
                id: freePerson
            }
        }).then(function(data){
            console.log(data);

            var data_ = data.data;
            var typePerson = data_.tipoPersona == 3 ? `AGENTE` : "COLABORADOR";
            var isEmploye = data_.tipoPersona == 1 ? `<p>De igual manera, seleccionar un puesto y área de trabajo para el nuevo colaborador</p>` : "";
            for(var a in data_){

                data_.idColaboradorArea = 1;

                if(a == "emailUsuario"){
                    
                    $("#divUsuarioPersona").html(`<input class="formEnviar" style="width: 300px" type="text" id="usuarioPersona" name="usuarioPersona" value="${data_.emailUsuario}" disabled="">`);
                } else if(a == "passwordUsuario"){
                    $("#divPasswordPersona").html(`<input class="formEnviar" style="width: 300px" type="text" id="usuarioPassword" name="usuarioPassword" value="${data_.passwordUsuario}" disabled="">`);
                } else if(a == "esAgenteNuevo"){
                    $(`#${a}`).html(`<option value="0">PERMANENTE</option>`);
                } else if(a == "IDVend"){
                    $(`#divIdVendedor`).html(`<input class="formEnviar" style="width: 300px" type="text" id="IDVend" name="IDVend" value="${data_.IDVend}">`)
                }
                $(`#${a}`).val(data_[a]);
            }
            var modalContent = `
                <h4 class="text-dark">Convertir persona temporal a fija</h4>
                <div class="col-md-12 text-dark mt-4">
                    <p><b>Datos del usuario</b>: pre-cargado</p>
                    <p><b>Nombre</b>: ${data_.nombres} ${data_.apellidoPaterno} ${data_.apellidoMaterno}</p>
                    <p><b>Tipo de persona</b>: ${typePerson}</p>
                    <div class="dropdown-divider"></div>
                    <div class="mt-4">
                        <p><b>Procedimiento:</b></p>
                        <p>Para convertir al usuario que ha cumplido de manera exitosa con su inducción, es necesario cambiar su usuario y contraseña de acceso al 
                            V3 de temporal a una fija para que el usuario pueda tener acceso a las herramientas de trabajo.    
                        </p>
                        ${isEmploye}
                        <p>Guardar cambios dando clic al boton de guardar.</p>
                    </div>
                </div>
            `;

            $(`.body-alert`).html(modalContent);

        }).catch(function(error){
            console.log(error);
        });
    }

    //--------------------------

    if($("#permit").length > 0){
        var base_url = $("#base_url").data("base-url");
        var permitPerson = $("#permit").val();

        $(`#alert`).modal({
            keyboard: false,
            backdrop: "",
            show: true
        });
        axios.get(`${base_url}persona/getTemporalPersonData`, {
            params: {
                id: permitPerson
            }
        }).then(function(data){
    
            //console.log(data.data);
            var onlyObject = data.data[0];
            delete onlyObject.idPersona;
            
            for(var a in onlyObject){

                if(a == "fecAltaSistemPersona"){

                    var date_ = onlyObject[a].split(" ");
                    var onlyDate = date_[0].split("-");
                    $(`#${a}`).val(`${onlyDate[2]}/${onlyDate[1]}/${onlyDate[0]}`);
                } else{
                    $(`#${a}`).val(onlyObject[a]);
                }
            }

            var typePerson = onlyObject.tipoPersona == 1 ? "COLABORADOR" : "AGENTE";
            var job = $(`#idPersonaPuesto option:selected`).text();
            var area = $(`#idColaboradorArea option:selected`).text();
            var message = `
                <h4 class="text-dark">Solicitud de alta de usuario</h4>
                <div class="col-md-12 text-dark mt-4">
                    <p><b>Datos del usuario</b>: pre-cargado</p>
                    <p><b>Nombre</b>: ${onlyObject.nombres} ${onlyObject.apellidoPaterno} ${onlyObject.apellidoMaterno}</p>
                    <p><b>Tipo de persona</b>: ${typePerson}</p>
                    ${(onlyObject.tipoPersona == 1 ? `<p><b>Puesto a cubrir</b>: ${job}</p>` : ``)}
                    <p><b>Área</b>: ${area.toUpperCase()}</p>
                    <div class="dropdown-divider"></div>
                    <div class="mt-4">
                        <p><b>Detalles:</b></p>
                        <p>
                            La cuenta de correo <b>${onlyObject.creator}</b> esta solicitando la alta de este usuario tipo ${typePerson}, ya que no cuenta con los permisos necesarios para darlo de alta en el sistema.
                        </p>
                        <p>Recuerde <b>Guardar</b> cambios dando clic al boton de guardar.</p>
                    </div>
                </div>
            `; 

            $(`.body-alert`).html(message);
        }).catch(function(error){
            console.log(error);
        })
    }

    //-------------------------
    var countDocs = $("#validateDocuments").data("totalcount");
    var countDocsUploaded = $("#validateDocuments").data("progressdocuments");
    var isProspective = $("#isProspective").data("prospective")
    var listMail = ["SISTEMAS@ASESORESCAPITAL.COM"];
    var mail = $("#usuario").val();

    if(isProspective == 0 && countDocsUploaded == countDocs){

        var typePerson = $("#tipoPersona option:selected").val() == 1 ? "COLABORADOR" : "AGENTE";
        var class_ = ``;//`crossToSystemUser`;
        var html_ = ``;//`Escalar ${typePerson.toLowerCase()} a sistemas`;
        var mostrar = false;

        if(listMail.includes(mail) && $("#tipoPersona option:selected").val() == 1){ //sistemas - colaborador
            var class_ = `crossToInducction`;
            var html_ = `Pasar ${typePerson.toLowerCase()} a inducción`;
            mostrar = true;
        } else if(!listMail.includes(mail) && $("#tipoPersona option:selected").val() == 3){
            var class_ = `crossToInducction`;
            var html_ = `Pasar ${typePerson.toLowerCase()} a inducción`;
            mostrar = true;

        } else if(!listMail.includes(mail) && $("#tipoPersona option:selected").val() == 1){
            var class_ = `crossToSystemUser`;
            var html_ = `Escalar ${typePerson.toLowerCase()} a sistemas`;
            mostrar = true;
        }

        if(mostrar){
            $(`#alert`).modal({
                keyboard: false,
                backdrop: "",
                show: true
            });
        }

        var name = $("#labelNombrePersona").text();
        crossToInducction = `
            <h4 class="text-dark">Pasar usuario a curso de inducción</h4>
            <div class="col-md-12 text-dark mt-4">
                <p>El usuario ${typePerson} ${name} ha cumplido con la documentación requerida para su proceso en inducción.</p>
                <p>Por favor dar click al botón para avisar al usuario de su curso de inducción.</p>
                <div class="text-center"><button class="btn btn-primary ${class_}">${html_}</button></div>
            </div>
        `;

        $(".body-alert").html(crossToInducction);
    }
    //-------------------------
});

$(document).on("click", ".crossToInducction", function(){

    console.log("inducción");
    var base_url = $("#base_url").data("base-url");
    var idPersona = $("#idPersonas option:selected").val()
    
    $.ajax({
        type: `POST`,
        url: `${base_url}persona/registerTemporalUserDirectly`,
        data: {
            idPerson: idPersona
        },
        success: function(response){
            console.log(response);
            var resp = JSON.parse(response);

            alert(resp.message);
            if(resp.success){
                window.location.reload();
            }
        },
        error: function(error){
            console.log(error);
        }
    });

});