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