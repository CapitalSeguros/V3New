$(function(){

    verifyStaffTermination();
    setInterval(function(){
        verifyStaffTermination();
    }, (1000 * 60 * 10)); //one second * seconds in one minute * minutes
});

const verifyStaffTermination = () => {

    const baseUrl = $("#base_url").data("base-url");

    if($("#idPersona").val() == 0){
        return false;
    }

    const ajax = $.ajax({
        type: "GET",
        url: `${baseUrl}persona/verifyExistsStaff`,
        data: {
            id: $("#idPersona").val()
        },
        error: (err) => {
            console.log(error.responseText);
        },
        success: (data) => {
            const response = JSON.parse(data);
            console.log(response);

            if(response.bajaPersona > 0){
                $("#labelEstadoPersona").html("- ESTE USUARIO ESTÁ DADO DE BAJA");
                $(".sendForm").prop("disabled", true);
                $(".cancel-request").prop("disabled", true);
                $(".delete-persons-exists").prop("disabled", true);
            }
        }
    });
}
//-----------------------
$(document).on("show.bs.modal", ".w-template-modal", function(e){

    const baseUrl = $("#base_url").data("base-url");
    const person = $("#idPersona").val();
    const template = $("#select-bussiness-channel option:selected").val();
    //console.log(person, template);

    if(template == ""){
        alert("Seleccione una plantilla correcta");
        return false;
    }

    const ajax = $.ajax({
        type: "GET",
        url: `${baseUrl}persona/getWelcomeTemplate`,
        data:{
            person: person,
            template: template,
        },
        beforeSend: () => {
            console.log("GETTING_WELCOME_TEMPLATE");
            $(".send-welcome-message").prop("disabled", true);
            $(".w-template-body").html(`<h4 class="text-center"><i class="fa fa-spinner fa-spin fa-fw"></i> Generando plantilla...</h4>`);
        }, 
        error: (error) =>{
            console.log(error.responseText);
            $(".send-welcome-message").prop("disabled", true);
        },
        success: (data) =>{
            const response = JSON.parse(data);
            console.log(response);
            
            $(".send-welcome-message").prop("disabled", false);
            $(".w-template-body").html(`<img class="img-responsive" src="${baseUrl + response.data}" alt="Plantilla de bienvenida">`);
        }
    });
});
//-----------------------
$(document).on("click", ".send-welcome-message", function(e){

    const baseUrl = $("#base_url").data("base-url");
    const person = $("#idPersona").val();
    const template = $("#select-bussiness-channel option:selected").val();

    const ajax = $.ajax({
        type: "GET",
        url: `${baseUrl}persona/sendWelcomeMessage`,
        data:{
            person: person,
            template: template,
        },
        beforeSend: () => {
            
        }, 
        error: (error) =>{
            console.log(error);
        },
        success: (data_) =>{
            const response = JSON.parse(data_);
            console.log(response);
            $(".w-template-modal").modal("hide");
            var content = ``;
            
            for(var a in response.data){

                var message = response.data[a].status ? `El envio de correo se realizó correctamente` : `Ocurrió un detalle al envio de correo. Favor de contactar al área de sistemas`;
                content += `<div clas="col-md-12"><p>${response.data[a].label}: ${"sendMessage" in response.data ? `Se ha enviado el mensaje de bienvenida con anterioridad` : message}</p></div>`;
            }

            $(".show-welcome-template").html(content);
        }
    });
});
//-----------------------