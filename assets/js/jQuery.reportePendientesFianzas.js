//Envío de formulario
$(".envia_form").on("click", function(){

    var fecha1 = $("#fechaI").val();
    var fecha2 = $("#fechaF").val();
    var _reporte = $("#repote_select option:selected").val();
    var _fechaDocto = $("#fecha_docto option:selected").val();
    var direccion = window.location.href.replace("reportePendienteFianzas", ""); //reportePendienteFianzas
    var _canal = [];
    var _despacho = [];
    var _ramo = [];
    var _grupo = [];

    if(fecha1 == "" || fecha2 == ""){ //Validador de campos importantes

        alert("No se seleccionó una fecha en el rango de fechas");
        return false;

    } else if(_reporte == "Inicio" || _fechaDocto == "Inicio"){

        alert("No se selecciono un tipo de reporte o fecha de documento");
        return false;
    }

    $("[name='ck_canal[]']:checked").each(function(idx){

        _canal.push($(this).val());
    });

    $("[name='despachoSicas[]']:checked").each(function(idx){

        _despacho.push($(this).val());
    });
    
    $("[name='ramosSicas[]']:checked").each(function(idx){

        _ramo.push($(this).val());
    });

    $("[name='grupoSicas[]']:checked").each(function(idx){

        _grupo.push($(this).val());
    });

    console.log($("input[name='valid_ramo']:checked").val());

    //Petición AJAX: GET
    $.ajax({
        method: "GET",
        url: direccion+"consultaRecibosFianzas",
        data:{
            "fecha1": fecha1,
            "fecha2": fecha2,
            "reporte": _reporte,
            "fechaDocto": _fechaDocto,
            "check_canal": $("input[name='valid_canal']:checked").val(),
            "canal": _canal,
            "check_despacho": $("input[name='valid_despacho']:checked").val(),
            "despacho": _despacho,
            "check_ramo": $("input[name='valid_ramo']:checked").val(),
            "ramo": _ramo,
            "check_grupo": $("input[name='valid_grupo']:checked").val(),
            "grupo": _grupo
        }
    }).done(function(data){

        var json_obj = JSON.parse(data);

        $("#contenedor_agentes").html();

        var obj = json_obj.reduce((acc, va) => {

            if(va.IDVendedor in acc){
                return {
                    ...acc,
                    [va.IDVendedor]: {
                        Nombre: va.VendNombre,
                        Documentos: [
                            ...acc[va.IDVendedor].Documentos,
                            va
                        ]
                    }
                }
            } else {
                return {
                    ...acc,
                    [va.IDVendedor]:{
                        Nombre: va.VendNombre,
                        Documentos:  [va]
                    }
                }
            }

        }, {});

        console.log(obj);

        var cadena_resultado = ``;

        for(var a in obj){

            cadena_resultado += `
                <div class="card mt-3 mb-2">
                    <div class="card-header">
                        <div class="row">
                            <div class="col-md-10"><a data-toggle="collapse" href="#collapse${a}" aria-expanded="false" aria-controls="collapse${a}">${obj[a].Nombre} <span class="caret"></span></a></div>
                            <div class="col-md-2 text-right">
                                <div class="dropdown">
                                    <a id="dd-${a}" type="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">Opciones</a>
                                    <span class="caret"></span>
                                    <ul class="dropdown-menu" role="menu" aria-labelledby="dd-${a}">
                                        <li role="presentation"><a class="export" role="menuitem" tabindex="-1" href="javascript: void(0);" data-id="${a}" data-nombre="${obj[a].Nombre}" onclick="generaAccion(this);">Exportar a archivo de Excel</a></li>
                                        <li role="presentation" class="divider"></li>
                                        <li role="presentation"><a class="email" role="menuitem" tabindex="-1" href="javascript: void(0);" data-id="${a}" onclick="generaAccion(this);">Enviar notificación por correo</a></li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="card-body table-responsive collapse" id="collapse${a}">
                        <table class="table tabla-${a}">
                            <thead>
                                <tr>
                                    <th>Documento</th>
                                    <th>FDesde</th>
                                    <th>FHasta</th>
                                    <th>FLimPago</th>
                                    <th>PrimaNeta</th>
                                    <th>PrimaTotal</th>
                                    <th>Estado</th>
                                    <th>Cliente</th>
                                    <th>Afianzadora</th>
                                    <th>Comision0</th>
                                    <th>Comision3</th>
                                </tr>
                            </thead>
                            <tbody>`;

                            obj[a].Documentos.map((arr_) => {
                                cadena_resultado +=`
                                    <tr>
                                        <td>${arr_.Documento}</td>
                                        <td>${arr_.FDesde}</td>
                                        <td>${arr_.FHasta}</td>
                                        <td>${arr_.FLimPago}</td>
                                        <td>${arr_.PrimaNeta}</td>
                                        <td>${arr_.PrimaTotal}</td>
                                        <td>${arr_.Estado}</td>
                                        <td>${arr_.Cliente}</td>
                                        <td>${arr_.Afianzadora}</td>
                                        <td>${arr_.Comision0}</td>
                                        <td>${arr_.Comision3}</td>
                                    </tr>
                                `;
                            });

                        cadena_resultado += `
                            </tbody>
                        </table>
                    </div>
                </div>
            `;

        }

        $("#contenedor_agentes").html(cadena_resultado);

    }).fail(function( jqXHR, textStatus, errorThrown ){
        console.log(textStatus,errorThrown);
    });
});
//-------------------------------------------
$(".export").on("click", function(){

    console.log("Hola");
    //e.stopProgation();
//    var idd = $(this).data("id");
    
});
//-------------------------------------------
function generaAccion(html){

    var idd= html.getAttribute("data-id");
    var accion = html.getAttribute("class");
    var direccion = window.location.href.replace("reportePendienteFianzas", "");
    var _nombre = html.getAttribute("data-nombre");
    var array_table = [];
    
    $(`.tabla-${idd} tbody tr`).each(function(){
        
        var obj_table = {};
        obj_table = {
            documento: $(this).find("td").eq(0).html(),
            fdesde: $(this).find("td").eq(1).html(),
            fhasta: $(this).find("td").eq(2).html(),
            flimpago: $(this).find("td").eq(3).html(),
            primaNeta: $(this).find("td").eq(4).html(),
            primaTotal: $(this).find("td").eq(5).html(),
            estado: $(this).find("td").eq(6).html(),
            cliente: $(this).find("td").eq(7).html(),
            afianzadora: $(this).find("td").eq(8).html(),
            comision0: $(this).find("td").eq(9).html(),
            comision3: $(this).find("td").eq(10).html(),
        }

        array_table.push(obj_table);
    });

    //Petición AJAX: POST
    $.ajax({
        method: "POST",
        url: direccion+"gestionaAccion",
        data:{
            tipo: accion,
            idVend: idd,
            nombre: _nombre,
            arr_obj: array_table
        }
    }).done(function(data){
        var respuesta = JSON.parse(data);
        var index = Object.keys(respuesta);
        console.log(index);

        if(index[0] == "export"){
            var aa = $(`<a>`);
            aa.attr("href", respuesta.export.file64);
            aa.attr("download", respuesta.export.archivo);
            $("body").append(aa);
            aa[0].click()
            aa.remove();
        } else{
            var msg = respuesta.email.envio ? "Envio de correo exitoso" : "Hubo un problema al enviar. Contacte al departamento de sistemas";

            alert(msg);
        }   
    });
}
//-------------------------------------------