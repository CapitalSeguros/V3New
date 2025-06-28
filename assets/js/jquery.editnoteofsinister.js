$(".create-note").click(function(e){

    e.preventDefault();
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
            console.log(response);

            if(response.bool){
                alert("Nota actualizada");
                window.location.href = controller == "Siniestros" ? `${baseUrl+controller}/registros` : `${baseUrl+controller}`;
            }
        }
    });
    //console.log(form);
});

//-----------------------------
const getController = (data) => {

    var controller = ``;
    switch(data){
        case "autos": controller = "Autos";
        break;
        case "daños": controller = "Danos";
        break;
        case "gmm": controller = "GMM";
        break;
        case "siniestros autos corporativo": controller = "Siniestros";
        break;
    }

    return controller;
}