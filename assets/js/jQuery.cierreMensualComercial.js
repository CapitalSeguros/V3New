var m_a = {
    1: "ENERO",
    2: "FEBRERO",
    3: "MARZO",
    4: "ABRIL",
    5: "MAYO",
    6: "JUNIO",
    7: "JULIO",
    8: "AGOSTO",
    9: "SEPTIEMBRE",
    10: "OCTUBRE",
    11: "NOVIEMBRE",
    12: "DICIEMBRE",
}

$(`.pauta_cierre`).on("click", function(){

    var fecha = new Date();
    var aceptacion = $(`#aceptacion`).val();
    var mesCierre = parseInt($(this).data("mes")) == 12 ?  1 : parseInt($(this).data("mes")) + 1;
    var anioCierre = parseInt($(this).data("mes")) == 12 ?  parseInt($(this).data("anio")) + 1 : parseInt($(this).data("anio"));
    console.log(mesCierre, anioCierre, fecha.getFullYear);

    if(aceptacion.toLowerCase() != "aceptar"){
        $(`#mssg`).html(`No se introdujo la palabra correcta. Intente de nuevo`);
        $(`#mssg`).addClass(`text-danger`);
        $(`#mssg`).addClass(`mt-3`);
        return false;

    } else if(anioCierre > fecha.getFullYear){
        $(`#mssg`).html(`No se puede realizar el cierre del mes actual. Esta solicitando activar el año siguiente (${anioCierre}) y aún estamos en ${fecha.getFullYear}`);
        $(`#mssg`).addClass(`text-danger`);
        $(`#mssg`).addClass(`mt-3`);
        return false;
    }
    
    /*else if(mesCierre > fecha.getMonth() + 1){
        $(`#mssg`).html(`No se puede realizar el cierre del mes actual. Esta solicitando activar el mes siguiente (${m_a[mesCierre]}) y aún estamos en ${m_a[fecha.getMonth() + 1]}`);
        $(`#mssg`).addClass(`text-danger`);
        $(`#mssg`).addClass(`mt-3`);
        return false;
    }*/

    $.ajax({
        method:"POST",
        url: window.location.href+`/almacenaACtivacionComercial`,
        data:{
            "q": mesCierre,
            "p": 1,
            "r": anioCierre,
        }
    }).done(function(data){
        alert(`Cierre del mes ejecutado`);
        window.location.reload();
    });
});

$(`.activa_consulta`).on("click", function(){

    var valor = $(`#mes_activa option:selected`).val();
    var yearValue = $(`#anio-activo option:selected`).val();
    var obj_date = new Date();

    if(valor >= obj_date.getMonth() + 1 && yearValue == obj_date.getFullYear()){ //|| valor == 0
        $(`#msgg`).html(`Se seleccionó un mes superior (${$(`#mes_activa option:selected`).text()}) o la primera opción.`);
        $(`#msgg`).addClass("text-danger");
        $(`#msgg`).addClass("mt-3");
        return false;
    } 
    if(valor == 0 || yearValue == 0){
        $(`#msgg`).html(`Se seleccionó la primera opción.`);
        $(`#msgg`).addClass("text-danger");
        $(`#msgg`).addClass("mt-3");
        return false
    }

    $.ajax({
        method:"POST",
        url: window.location.href+`/almacenaACtivacionComercial`,
        data:{
            "q": valor,
            "p": 0,
            "r": yearValue,
        }
    }).done(function(data){
        alert("Periodo comercial activado");
        window.location.reload();
    });
});