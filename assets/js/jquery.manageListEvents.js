//-------------------------
$(document).on("submit", ".guest-form", function(e){

    e.preventDefault();
    var objData = {};
    var serializeForm  = $(this).serializeArray();
    var base_url = $("#base_url").data("url");
    var card = $(this).parent();
    var class_ = card.attr("class").split(" ");

    console.log(class_);
    for(var a in serializeForm){
        objData[serializeForm[a].name] = serializeForm[a].value;
    }
    var hourEvent = $(`#hours-${objData.event}`).val();
    objData["hours"] = hourEvent;

    //AJAX Request: POST.
    $.ajax({
        method: "POST",
        url: base_url+"controlAsistenciaEvento/recordsTrainingData",
        data: {
            data_: JSON.stringify(objData)
        },
        error: function(error){
            alert(error);
        }, success: function(data){

            var res = JSON.parse(data);
            var idTrainig = parseInt(res.idTraining);
            var status = res.status;

            $(`#recordTraining-${res.idGuest}`).val(idTrainig);
            if(status){
                $(`#response-${res.idGuest}`).html(`
                    <h4><span class="badge badge-success">Registrado</span></h4>`
                );
                
            } else{
                $(`#response-${res.idGuest}`).html(`
                    <h4><span class="badge badge-danger">Removido</span></h4>`
                );
            }
        }
    });
});
//-----------------------