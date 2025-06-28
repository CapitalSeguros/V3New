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