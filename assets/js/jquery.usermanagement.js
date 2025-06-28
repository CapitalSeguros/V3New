$(document).on("change", "#idColaboradorArea", function(){

    var value = $(this).val();
    const idPersona = $("#idPersona").val();
    console.log(idPersona);
    const baseUrl = $("#base_url").data("base-url");

    var ajax = $.ajax({
        type: "GET",
        url: `${baseUrl}persona/getPositions`,
        data: {
            area: value,
            idPersona: parseInt(idPersona)
        },
        error: (error) => {
            console.log(error);
        },
        success: (data) => {
            const response = JSON.parse(data);
            console.log(response);

            //$("#idPersonaPuesto").html(``);
            const options = response.reduce((acc, curr) => {
                acc += `<option value="${curr.idPuesto}">${curr.personaPuesto}</option>`;
                return acc;
            }, "");

            $("#idPersonaPuesto").html(`<option value="">Seleccione</option>`+options);
        }
    });
})
//-------------------------------------------------
$(".delete-persons-exists").click(function(){

    const idPersona = $("#idPersona").val();
    const typeRequest = $(this).data("op");
    const baseUrl = $("#base_url").data("base-url");

    if($("#banned-value").val() == 0 && typeRequest == "delete"){
        alert("Para eliminar de manera permante se requiere que el usuario este en estatus baneado.\nSi no tiene permiso de bannear favor de contactar a sistemas.");
        return false;
    }

    if(typeRequest == "delete" && !confirm("¿Esta seguro de que quiere eliminar a esta persona y dejar vacante el puesto?")){
        return false;
    }

    const ajax = $.ajax({
        type: "POST",
        url: `${baseUrl}persona/passRequestForDismissal`,
        data: {
            id: idPersona,
            typeRequest: typeRequest
        }, 
        error: (error) => {
            console.log(error.responseText);
        },
        success: (data) => {
            const response = JSON.parse(data);
            console.log(response);

            alert(response.message);
            if(response.bool){

                if(response.type == "request"){
                    window.location.reload();
                } else{
                    window.location.href = `${baseUrl}persona/agente`;
                }
            }
        }
    });


    console.log("DELETE-PERSON");
});
//------------------------------------------------
$(".cancel-request").click(function(){

    const baseUrl = $("#base_url").data("base-url");
    const id = $(this).data("id");

    const ajax = $.ajax({
        type: "POST",
        url: `${baseUrl}persona/deleteRequest`,
        data: {
            id: id,
        }, 
        error: (error) => {
            console.log(error.responseText);
        },
        success: (data) => {
            const response = JSON.parse(data);
            console.log(response);

            alert(response.message);
            if(response.bool){
                window.location.reload();
            }
        }
    });
    console.log("CANCEL-REQUEST");
});
//------------------------- //Dennis Castillo [2022-03-02]
$(".get-descriptive").click(function(){

    const valueEmployee = $("#idPersonaPuesto").val();
    console.log(valueEmployee);

    if(valueEmployee == ""){
        alert("Seleccionó una opción incorrecta para descargar el descriptivo");
        return false;
    }

});
//-------------------------
$("#idPersonaPuesto").change(function(){

    const baseUrl = $("#base").val();
    //const idJob = $("#idPersonaPuesto option:selected").val();
  
    const ajax = $.ajax({
          type: "GET",
          url: `${baseUrl}capitalHumano/getJobAccounts`,
          data: {job: $(this).val()},
          error: (error) => {
              console.log(error);
          },
          success: (data) => {
              
              const response = JSON.parse(data);
              //const ulChild = $(".job-accounts-1").children();
              const liOptions = response.reduce((acc, curr) => acc += `<li role="presentation"><a class="get-account" role="menuitem" tabindex="-1" href="javascript: void(0)">${curr.email}</a></li>`, ``);
              $(".avalibe-accounts-list").html(liOptions);
              $(".count-accounts").html(response.length);
              //console.log(response);
              //console.log(ulChild[1]);
          }
      });
});
//---------------------
$(document).on("click", ".get-account", function(){
    const lastUserName = $("#usuarioPersona").val();
    const name = $(this).text();
    //$(".last-user-account").html(`<small>Cuenta anterior: ${lastUserName}</small>`);
    $("#usuarioPersona").val(name);
    //console.log(name);
});
//----------------------