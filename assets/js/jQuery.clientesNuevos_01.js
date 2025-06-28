$(".submit-consulta").on("click", function(e){
    
    e.preventDefault();
    e.stopPropagation();
    var canal = $(this).data("canal");
    var form_serialize = $(`#form_consulta_${canal}`).serialize();
    var direccion = window.location.href;
    var mes_nombre = $(`#mes_consulta_${canal} option:selected`).text();
    //console.log(idx_s);

    //Petición AJAX: GET
    $.ajax({
        method: "GET",
        url: direccion+"/obtenerClientesAnteriores",
        data: form_serialize,
        beforeSend: function(){
            $(`.contenedor_${canal}`).html(
                `<!--<div class="row">-->
                    <!--<div class="col-md-2 text-right"><img src="${direccion.replace("directorio", "")+"assets/images/loading.gif"}" width="30" height="30"></div>-->
                    <div style="text-align: center"><img src="${direccion.replace("directorio", "")+"assets/images/loading.gif"}" width="30" height="30"></div>
                    <div style="text-align: center" class="mt-4"><h3>Cargando información del canal ${canal.toUpperCase()}</h3></div>
                <!--</div>-->`
            )
        }
    }).done(function(res){
        
        var response_ajax = JSON.parse(res);
        var card_client = "";

        alert(response_ajax.mensaje);
        $(`.titulo_consulta_${canal}`).html(`<h4>Resultado de la consulta para el mes: ${mes_nombre}</h4>`);
        if(response_ajax.bool){

            var cli_ = response_ajax.clientesAnteriores;
            for(var a in cli_){

                //console.log(cli_[a]);

                card_client += `
                    <div class="card">
                        <div class="jumbotron text-center"><h5>${cli_[a].NombreCompleto.toUpperCase()}</h5></div>
                        <div class="card-body">
                            <h6>Cliente Número ${a}</h6>
                            <p>Cliente asociado a la consulta del canal: ${canal.toUpperCase()}</p>
                            <hr>
                            <button type="button" class="btn btn-link client_contact" data-toggle="modal" data-target="#modal_contacto" data-client="${a}">Ver datos del contacto <span class="caret"></span></button>
                        </div>
                    </div>
                `;
            }

            $(`.contenedor_${canal}`).html(card_client);
        } else{
            $(`.contenedor_${canal}`).html(`<h4>No se encontraron resultados para la consulta: ${canal.toUpperCase()} en ${mes_nombre}</h4>`);
        }

        //console.log(response_ajax);
    });

    //console.log(form_serialize);
});