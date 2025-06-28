//console.log("Hi");

$( function() {
    console.log("VACATIONS_SCRIPT: ACTIVATED");

    const ajax_ = $.ajax({
        type: "GET",
        url: `${$("#base_url").data("base-url")}miInfo/getHolydays`,
        error: (error) => {
            console.log(error);
        },
        success: (data) => {
            const response = JSON.parse(data);
            console.log(response);
            $( "#datepicker-vacations" ).datepicker({
                dateFormat: 'dd/mm/yy',
                showOtherMonths: false,
                minDate: 0,
                autoclose: true,
                beforeShowDay: function(d){

                    const montAndDay = `${d.getMonth() + 1}-${d.getDate()}`;
                    const lock = !response.holydays.includes(montAndDay) && ![0, 6].includes(d.getDay()) && !response.interval.includes(montAndDay) && !response.afterRequest.includes(montAndDay) && !response.vacations.includes(montAndDay);
                    //const ccs = response.interval.includes(montAndDay) ? "disabled-interval" : "";
                    var css = "";
                    if(response.periodChange.includes(montAndDay)){
                        css = "period-change-date";
                    }
                    if(response.interval.includes(montAndDay)){
                        css = "disabled-interval";
                    }
                    if(response.afterRequest.includes(montAndDay)){
                        css = "after-request-date";
                    }
                    if(response.vacations.includes(montAndDay)){
                        css = "vacation-date";
                    }
                    return [lock, css, response.periodChange.includes(montAndDay) ? "Fecha de cambio de periodo" : "Vigente"];
                }
            });
        }
    });

    //Apply in vacations manager view
    if($(".data-table-1").length > 0){

        $('.data-table-1').DataTable({
            columnDefs:[{
                targets: '_all',
                sortable: false,
                
            }]
        });
    }

} );

//---------------------------
$("#frmvacaciones").on("submit", function(e){

    e.preventDefault();
    console.log(this);
    const ajax = $.ajax({
        type: "POST",
        contentType: false, //"multipart/form-data",
        processData: false,
        url: `${$("#base_url").data("base-url")}vacation/post`,
        data: new FormData(this),
        error: (error) => {
            console.log(error.responseText);
        },
        success: (data) => {
            const response = JSON.parse(data);
            console.log(response);
            alert(response.message.join("\n"));

            if(response.success){
                window.location.reload();
            }
        }
    });
});

//-----------------------
$(document).on("click", ".delete-vacation-request", function(){

    console.log("DELETE_REQUEST");
    const deleteRecord = confirm("¿Desea dejar el registro de su cancelación en la lista actual?");
    const update = {
        condition: {
            estado: "cancelado", showInList: deleteRecord, aprobado: "-2"
        },
        options: {
            mail: false, 
            notification: false
        }
    };
    //console.log(JSON.stringify(update));

    const ajax = $.ajax({
        type: "PATCH",
        dataType: "json",
        processData: false,
        contentType: "application/json; charset=utf-8;",
        url: `${$("#base_url").data("base-url")}vacation/patch/${$(this).data("id")}`,
        data: JSON.stringify(update),
        error: (error) => {
            console.log(error.responseText);
        },
        success: (data_) => {
            console.log(data_);

            const msg = data_.message.join("\n");
            alert(msg);

            if(data_.success){
                window.location.reload();
            }
        }
    })
});

//----------------------------
$(document).on("click", ".get-vacation-request", function(){

    console.log("SHOW-LIST");
    const base_url = $("#base_url").data("base-url");

    $(".requester").text($(this).data("person"));
    $(".vacation-list").modal({
        show: true,
        backdrop: false,
        keyboard: false,
    });

    var ajax = $.ajax({
        type: "GET",
        url: `${base_url}vacation/get/${$(this).data("id")}/${$(this).data("show-all")}`,
        beforeSend: (load) => {
            $(".request-list").html(`
                <h3 class="text-center"><i class="fa fa-spinner fa-pulse fa-fw"></i> Solicitando información</h3>
            `);
        },
        error: (object) => {
            console.log(object.responseText);
        },
        success: (data) => {
            const response = JSON.parse(data);
            console.log(response);

            $(".preview-file-content").html(``);
            if( response.length > 0 ){

                const trtd = response.reduce((acc, curr) => {

                    const resp = curr.aprobado == 1 ? `
                        <div class="dropdown">
                            <button class="btn btn-${curr.cssClass} btn-xs dropdown-toggle" type="button" id="dropdownMenu1" data-toggle="dropdown" aria-expanded="true">${curr.estado.toUpperCase()}</button>
                            <ul class="dropdown-menu" role="menu" aria-labelledby="dropdownMenu1">
                                <li role="presentation"><a class="text-success status-change" data-id="${curr.id}" data-change="0" role="menuitem" tabindex="-1" href="javascript: void(0)">Aprobar</a></li>
                                <li role="presentation"><a class="text-danger status-change" data-id="${curr.id}" data-change="-1" role="menuitem" tabindex="-1" href="javascript: void(0)">Rechazar</a></li>
                            </ul>
                        </div>
                    ` : `<button class="btn btn-${curr.cssClass} btn-xs text-white">${curr.estado.toUpperCase()}</button>`;

                    acc += `<tr class="text-center">
                        <td>${curr.antiguedad}</td>
                        <td>${curr.fecha}</td>
                        <td>${curr.fecha_salida}</td>
                        <td>${curr.fecha_retorno}</td>
                        <td>${curr.cantidad_dias}</td>
                        <td>${curr.name == null ? "No anexado" : `<a href="${base_url}uploads/VACACIONES/REF_${curr.id}/${curr.name}" class="preview-file"> Ver solicitud</a>`}</td>
                        <td>${resp}</td>
                    </tr>`;

                    return acc;
                }, ``);

                $(".request-list").html(`
                   <table class="table table-sm table-condensed table-hover data-table-2">
                    <thead>
                        <tr>
                            <th>Periodo</th>
                            <th>Fecha de solicitud</th>
                            <th>Primer fecha de descanso</th>
                            <th>Fecha de retorno</th>
                            <th>Dias solicitados</th>
                            <th>Solicitud</th>
                            <th>Respuesta</th>
                        </tr>
                    </thead>
                    <tbody>${trtd}</tbody>
                   </table>
                `);

                $('.data-table-2').DataTable({
                    columnDefs:[{
                        targets: '_all',
                        sortable: false,
                    }],
                    order: [[1, 'desc']],
                });

            } else{
                $(".request-list").html(`
                    <h3 class="text-center text-danger">No se encontraron solicitudes</h3>
                `);
            }
        }
    });

});
//----------------------------
$(document).on("click", ".status-change", function(){

    //const notification = confirm("¿Desea enviar notificación con dos dias de anticipación a todos los colaboradores?");
    const mail = confirm("¿Desea enviar mail de aviso con dos dias de anticipación a todos los colaboradores?");

    update = {
        condition: {
            aprobado: $(this).data("change"),
            estado: $(this).data("change") == 0 ? "aprobado" : "rechazado",
        },
        options:{
            mail: mail,
            notification: false,
        }
    }

    const ajax = $.ajax({
        type: "PATCH",
        dataType: "json",
        processData: false,
        contentType: "application/json; charset=utf-8;",
        url: `${$("#base_url").data("base-url")}vacation/patch/${$(this).data("id")}`,
        data: JSON.stringify(update),
        error: (error) => {
            console.log(error.responseText);
        },
        success: (data_) => {
            console.log(data_);

            const msg = data_.message.join("\n");
            alert(msg);

            if(data_.success){
                $(".vacation-list").modal("hide");
                window.location.reload();
            }
        }
    });
    
});
//----------------------------
$(document).on("click", ".preview-file", function(e){

    e.preventDefault();
    console.log("SHOW-FILE");

    $(".preview-file-content").html(`
        <iframe width="100%" src="https://docs.google.com/gview?url=${$(this).attr("href")}&embedded=true"></iframe>
    `);
});
//----------------------------