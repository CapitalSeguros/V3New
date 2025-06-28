$(document).ready(function(){ //function (){

    console.log("get inducction");
    var url_ = new URLSearchParams(window.location.search);
    var parameters = url_.entries();
    var params = {};

    for(var a of parameters){
        params[a[0]] = a[1];
    }
 
    if(Object.entries(params).length > 0){
        $(`#type-person a[href="#${params.r}"]`).tab(`show`);
        $(`#${params.r} table tbody tr`).each(function(){

            var dataTr = $(this).data("id");
            if(dataTr == params.q){
                
                $(this).addClass("info");
            }
        })
    }
    //console.log(params, "ok");
});

$(document).on("click", ".removeRegister", function(e){

    var reg = $(this).parent().parent().data("id");
    var confirm_ = confirm("¿Estas seguro de quitar de la lista a este usuario?");
    var baseUrl = $(`#base_url`).data(`url`);

    //console.log(e.target);
    //alert(confirm_);
    if(confirm_){
        console.log(reg);

        // AJAX Request: POST
        $.ajax({
            type: `POST`,
            url: `${baseUrl}persona/updateCheck`,
            data: {
                id: reg,
                typePerson: $(this).data(`typeperson`)
            },
            error: function(error){
                console.log(error);
            },
            success: function(response){
                console.log(response);

                var resp = JSON.parse(response);
                alert(resp.message);

                if(resp.bool){
                    e.target.closest(`tr`).remove();
                    //console.log($(this));
                }
            }
        });
    }
});

$(document).on("change", ".reviewer", function(e){

    var viewer = $(this).val();
    var person = $(this).data("person");
    var check = $(this).is(":checked") ? "agree" : "delete";
    var baseUrl = $(`#base_url`).data(`url`);

    // AJAX Request: POST
    $.ajax({
        type: `POST`,
        url: `${baseUrl}persona/manageReviewer`,
        data: {
            id: person,
            viewer: viewer,
            action: check
        },
        error: function(error){
            console.log(error);
        },
        success: function(response){
            var resp = JSON.parse(response)
            console.log(resp);

        }
    });
})