//JS a base de JQuery
$(function(){ //Al momento de cargar la página.
    
    $(".metacomercial").each(function(){

        var tipo = $(this).attr("aria-controls");
        var tabla = $(this).attr("id-tabla");

        if(tipo == "venta_nueva"){

            //Activar las tablas de venta nueva
            $(this).addClass("active");
            $("#"+tabla).addClass("active show");
            
        }
        //Mostrar avance de metas y comisiones.
        var filas = $("#"+tabla+" table tbody tr");

        filas.each(function(){ //Recorrido de cada tabla y filas de la vista.

            var num_mes = $(this).find("td").eq(0).html();
            var meta = parseInt($(this).find("td").eq(2).html().replace("$","").replace(",",""));
            var comision = parseInt($(this).find("td").eq(3).html().replace("$","").replace(",",""));
            var fecha = new Date();

            if(num_mes < fecha.getMonth()+1){

                var semaforo = comision >= meta ? "success" : "danger";
                $(this).addClass("table-"+semaforo);

                //console.log(semaforo);
            } else{
                $(this).find("td").eq(4).empty();
            }
        });
    });  
});
//---------------------------------------------
$(".consulta_sicas").on("click", function(e){ //Click al botón para consultar a Sicas.

    e.stopPropagation();
    var datos = $(this).data("info").split("-");
    var reporte = $(this).data("reporte");
    var direccion = window.location.href;

    var tr = $("#"+datos[2]+"_"+datos[1]+" table tbody tr").eq(datos[0] - 1);
    var td_3 = tr.find("td").eq(3);

    var etiqueta = reporte == 1 ? "Fecha documento" : "Fecha limite de pago";

    //Consulta AJAX: GET
    $.ajax({
        url: direccion+"/consultaAvanceDeSicas",
        data: {
            "mes" : datos[0],
            "id" : datos[1],
            "tipo" : datos[2],
            "reporte" : reporte
        },
        type: "GET",
        datatype: "json",
        beforeSend: function(){
            
            td_3.html("Cargando consulta...");
        }
    })
    .fail(function(jqHXR, textStatus, errorThrown){
        alert("Error capturado: "+errorThrown);
    })
    .done(function(data){

        var resp = JSON.parse(data);
        console.log(resp);

        var comision = "";

        for(var a in resp){

            if(a == datos[2]){

                comision = (Math.round(resp[a].comision)).toLocaleString();
            } else if(datos[1] == 805){

                comision = (Math.round(resp["ingreso_total"].comision)).toLocaleString();
            }
        }

        td_3.html(`$`+comision+` <br><h5><span class="badge badge-primary">`+etiqueta+`</span></h5>`);
    });
});
//---------------------------------------------