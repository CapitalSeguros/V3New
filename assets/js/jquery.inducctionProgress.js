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

    $(document).ready(function() {
        $('table.table-content-new-users').DataTable({
            //"order": [[ 3, "desc" ]]
            "language": {
                "url": "//cdn.datatables.net/plug-ins/9dcbecd42ad/i18n/Spanish.json"
            },
            //"order": false,
            //rowGroup: {
                //dataSrc: [ 2, 1 ]
            //}                
        });
    } );
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
});

//----------------
$(document).on("click", ".show-more-info", function(){

    var baseUrl = $(`#base_url`).data(`url`);
    const id = $(this).data("id");
    const type = $(this).data("type");
    const name = $(this).data("name");
    const email = $(this).data("email");

    $.ajax({
        type: `GET`,
        url: `${baseUrl}persona/getInfoNewPerson`,
        data: {
            idPerson: id,
            typePerson: type,
        },
        error: function(error){
            console.log(error);
        },
        success: function(data){
            
            const response = JSON.parse(data);
            console.log(response);

            $("#show-more-data-modal").modal({
                show: true,
                keyboard: false,
                backdrop: false,
            });
            
            const contract = Object.keys(response.data.xtraData).length > 0 ? response.data.xtraData.label1 : `Sin registro`;
            const saving = Object.keys(response.data.xtraData).length > 0 ? response.data.xtraData.label2 : `Sin registro`;
            const salary = Object.keys(response.data.xtraData).length > 0 ? parseFloat(response.data.xtraData.sueldoPercibido).toLocaleString() : `0`;

            const part1 = `
                <div><p><strong>Tipo de contrato:</strong> ${contract}</p></div>
                <div><p><strong>Fondo de ahorro:</strong> ${saving}</p></div>
                <div><p><strong>Sueldo percibido:</strong> $${salary}</p></div>
            `;

            const part2 = response.data.documents.reduce((acc, curr, idx) => {

                const target = curr.exists ? `target="_blank"` : ``;
                const href = curr.exists ? curr.docUploaded : `javascript: void(0)`;

                acc += `
                    <a href="${baseUrl}${href}" ${target} class="list-group-item">
                        <div>${curr.layout} ${curr.require ? `<span class="label label-danger">Obligatorio</span>` : ``}</div>
                        <div><small>${curr.exists ? `<i class="fa fa-check-circle-o text-success" aria-hidden="true"></i> Contiene un archivo anexado` : `<i class="fa fa-times-circle-o text-danger" aria-hidden="true"></i> Sin archivo por el momento`}</small></div>
                    </a>
                `;
                return acc;
            }, ``);

            $("#myModalLabel").html(`<div>${name}</div><div><small class="text-white">${email}</small></div>`);   

            $(".insert-data").html(`
                <div><p><strong>Información requerida para el usuario</strong></p></div>
                <div class=""><p><strong>Usuario creado por:</strong> ${response.data.creator}</p></div>
                ${type == 1 ? `<div class="mb-2">${part1}</div>` : ``}
                <div class="list-group" style="height: 300px; overflow-y: auto">${part2}</div>
            `);
        }
    });
});