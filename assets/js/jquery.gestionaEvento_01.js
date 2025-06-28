
var base_url = $("#base_url").data("url");

$("#formRegistro").submit(function(e){

    e.preventDefault();
    var formulario = $(this).serialize();
    //console.log(formulario);

    $.ajax({
        method: "POST",
        url: base_url+"accesoAEvento/registraInvitado",
        data: formulario,
        beforeSend: function(){
            $(".modal-body").html("<div class='mt-6'><h4>Enviando información...</h4></div>");
        },
        success: function(data){

            var res = JSON.parse(data);

            if(res.resultado > 0){
                $(".modal-body").html("<div class='mt-6'><h4>Información enviada...</h4></div>");
                $(".bd-registro-modal-lg").modal("hide");
                
            }
        },
        error: function(error){
            alert(error);
        }
    })
});

$("#confirma").click(function(e){

    var valueIndex = $("#aceptacion option:selected").val();
    var guest = $("#aceptacion").data("invitado");

    if(valueIndex == 0){
        alert("Seleccionó una opción incorrecta");
        return false;
    }
    //console.log(valueIndex);
    
    $.ajax({
        method: "GET",
        url: base_url+"crearLiga/actualizaEstado",
        data: {
            q: guest,
            r: valueIndex,
            p: 0
        },
        beforeSend: function(){
        },
        success: function(data){

            var res = JSON.parse(data);
            //console.log(res);
            if(res.bool){
                window.location.reload();
            }
        },
        error: function(error){
            alert(error);
        }
    })
})