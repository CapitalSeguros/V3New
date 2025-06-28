$(function() {
    $( ".datepicker" ).datepicker({dateFormat: "yy-mm-dd"});
});
//-----------------------------------
$(document).on("click", ".client-data", function(e){
    consultaContactoDelCliente(e.target);
    $('#modal_info_contacto').modal({
        show: true,
        backdrop: false,
        keyboard: false,
    });
});
//-----------------------------------
$(document).on("click", ".client-notes", function(e){
    consultarNotasDelCliente(e.target);
    $('#modal_info_contacto').modal({
        show: true,
        backdrop: false,
        keyboard: false,
    });
});
//-----------------------------------
$(document).on("submit", ".query-form", function(e){

    e.preventDefault();
    const form = $(this).serialize();
    const baseUrl = $(".base_url").data("url");
    console.log("Getting new clients...");

    $.ajax({
        method: "GET",
        url: `${baseUrl}directorio/getNewClients`,
        data: form,
        beforeSend: () => {
            $(`.message-container-${$(this).data("channel")}`).html(`<div class="alert alert-info" role="alert"><button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button><i class="fa fa-spinner fa-spin fa-fw"></i> Solicitando datos...</div>`);
            //<div class="alert alert-info" role="alert">s</div>
        },
    }).fail((jqXHR, textStatus, errorThrown) => {
        console.log(errorThrown);
    }).done((data) => {
        const response = JSON.parse(data);
        console.log(response);

        if(response.data.length > 0){

            const clients = response.data;
            const clientsList = clients.reduce((acc, curr) => {
                acc += `
                    <div class="col-md-4">
                        <div class="thumbnail">
                            <div class="jumbotron text-center"><h5><strong>${curr.nombreCliente}</strong></h5></div>
                            <div class="caption">
                                <table class="table">
                                    <tbody>
                                        <tr><td>Cliente número:</td><td>${curr.IDCli}</td></tr>
                                        <tr><td>Fecha de captura:</td><td>${curr.fechaCaptura}</td></tr>
                                        <tr><td>Polizas capturadas</td><td>${curr.papers.length}</td></tr>    
                                        <tr>
											<td colspan="2">
												<div class="dropdown">
													<button class="btn btn-link btn-sm" type="button" id="dropdownMenu1" data-toggle="dropdown" aria-expanded="true">
														Ver opciones <span class="caret"></span>
													</button>
													<ul class="dropdown-menu" role="menu" aria-labelledby="dropdownMenu1">
														<li role="presentation"><a role="menuitem" tabindex="-1" href="${baseUrl}directorio/GetPoliza?IDCli=${curr.IDCli}&page=0" target="_blank"><i class="fa fa-eye" aria-hidden="true"></i> Ver pólizas</a></li>
														<li role="presentation"><a role="menuitem" class="client-data" id_cliente="${curr.IDCli}" tabindex="-1" href="javascript: void(0)"><i class="fa fa-users" aria-hidden="true"></i> Preferencias de contacto</a></li>
														<li role="presentation"><a role="menuitem" class="client-notes" id_cliente="${curr.IDCli}" cliente_nombre="${curr.nombreCliente}" tabindex="-1" href="javascript: void(0)"><i class="fa fa-sticky-note-o" aria-hidden="true"></i> Notas</a></li>
                                                        <li role="presentation" ><a role="menuitem" tabindex="-1" href="${baseUrl}directorio/llamarCotizacion?IDCli=${curr.IDCli}" target="_blank" >&#128077 Cotizar</a></li>
														<li role="presentation"><a role="menuitem" tabindex="-1" href="${baseUrl}directorio/llamarFianzas?IDCli=${curr.IDCli}" target="_blank" >&#128200 Fianzas</a></li>
                                                        <li role="presentation"><a role="menuitem" tabindex="-1" href="javascript: void(0)" onclick="traerHistorialClientes('',${curr.IDCli})"><i class="fa fa-eye" aria-hidden="true"></i>&nbsp Bitacora</a></li>
                                                        <li role="presentation"><a role="menuitem" tabindex="-1" href="javascript: void(0)" onclick="asignarValParaDatosClientes(${curr.IDCli});traerTelEmailAltaTCGenerales()"><i class="fa fa-eye" aria-hidden="true"></i>&nbsp Agregar Datos</a></li>
													</ul>
												</div>
											</td>
										</tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                `;
                return acc;
            }, ``);

            $(`.message-container-${clients[0].canal}`).html(`<div class="alert alert-success" role="alert"><button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button><i class="fa fa-check" aria-hidden="true"></i> Clientes obtenidos: <strong>${clients.length}</strong></div>`);
            $(`.contenedor_${clients[0].canal}`).html(clientsList);
        } else{
            $(".message-container").html(`<div class="alert alert-danger" role="alert"><button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button><i class="fa fa-times" aria-hidden="true"></i> No se encontraron resultados con el rango de fechas indicado</div>`);
        }
    });

});
//-----------------------------------
$(".submit-consulta").on("click", function(e){ //Obsoleto
    
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
        console.log(response_ajax);

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