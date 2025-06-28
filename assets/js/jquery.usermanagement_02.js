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
//------------------------------------------------