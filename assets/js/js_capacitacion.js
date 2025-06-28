//----------Uso de JQuery--------------

$(".listar_cap").on("click", function(e){

    //e.stopPropagation();
    var capacitacion = $(this).data("capacitacion");
    var sub_capacitacion = $(this).data("sub_capacitacion");
    var ramo = $(this).data("ramo");

    var base_url = window.location.href.replace("reporteDeCapacitacionManual", "");
    var tiempo = new Date();

    //Petición AJAX: GET.
    $.ajax({
        method: "GET",
        url: base_url+"obtenerListadoCapacitacion",
        data: {
            _c: capacitacion,
            _s_c: sub_capacitacion,
            _r: ramo,
            _m: tiempo.getMonth()+1
        },
        dataType: "json"
    }).done(function(res){
        console.log(res);

        var resp = `<h6>Información de `+capacitacion+`</h6>`;
        resp += `<table class="table">
            <thead>
                <tr>
                    <th>Sub-capacitación</th>
                    <th>Asignado por</th>
                    <th>Fecha asignada</th>
                    <th>`+ramo.toUpperCase()+`</th>
                </tr>
            </thead>
            <tbody>`;

        for(var a in res){
            if(res[a].tiempo > 0){
                resp += `<tr>
                    <td>`+res[a].nombreCertificado+`</td>
                    <td>`+res[a].emailCreador+`</td>
                    <td>`+res[a].fechaAsignada+`</td>
                    <td>`+res[a].tiempo+` hrs</td>
                </tr>`;
            }
        }

        resp += `<tbody>
        </table>`

        $("#m_b").html(resp);

    });
});