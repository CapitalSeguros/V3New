//console.log("Hi");

var _holydays = [];

$( function() {
    console.log("VACATIONS_SCRIPT: ACTIVATED 1");

    const ajax_ = $.ajax({
        type: "GET",
        url: `${$("#base_url").data("base-url")}miInfo/getHolydays`,
        error: (error) => {
            console.log(error);
        },
        success: (data) => {
            const response = JSON.parse(data);
            _holydays = response.holydays;

            $( "#datepicker-vacations" ).datepicker({
                dateFormat: 'dd/mm/yy',
                showOtherMonths: false,
                minDate: 0,
                autoclose: true,
                beforeShowDay: function(d){

                    const montAndDay = `${d.getMonth() + 1}-${d.getDate()}`;
                    const fullDate = `${d.getFullYear()}-${d.getMonth() + 1}-${d.getDate()}`;
                    //console.log(fullDate);
                    const lock = !response.holydays.includes(montAndDay) && ![0, 6].includes(d.getDay()) && !response.interval.includes(fullDate) && !response.vacations.includes(fullDate); //&& !response.afterRequest.includes(montAndDay)
                    //const ccs = response.interval.includes(montAndDay) ? "disabled-interval" : "";
                    var css = "";
                    if(response.vacations.includes(fullDate)){ //jerarquia nivel máximo.
                        css = "vacation-date";
                    } else if(response.periodChange.includes(montAndDay)){
                        css = "period-change-date";
                    } /*else if(response.afterRequest.includes(montAndDay)){
                        css = "after-request-date";
                    }*/ else if(response.interval.includes(fullDate)){ //jerarquia nivel mínimo.
                        css = "disabled-interval";
                    }

                    return [lock, css, response.periodChange.includes(montAndDay) ? "Fecha de cambio de periodo" : "Vigente"];
                },
                onSelect: function(dateText, obj){
                    //console.log(dateText, obj);
                    $("#return-to-work-hidden").val(dateText);
                    $("#cantidad_dias option:selected").trigger("change");
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
    //console.log(this);
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
                    <div role="tabpanel">
                        <ul class="nav nav-tabs" role="tablist" id="vacations-tab">
                            <li role="presentation" class="active"><a href="#data-table-tab" aria-controls="data-table-tab" role="tab" data-toggle="tab">Solicitudes</a></li>
                            <li role="presentation"><a href="#preview-file-tab" aria-controls="preview-file-tab" role="tab" data-toggle="tab">Visualización de solicitud</a></li>
                        </ul>
                        <div class="tab-content">
                            <div role="tabpanel" class="tab-pane active" id="data-table-tab">
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
                            </div>
                            <div role="tabpanel" class="tab-pane" id="preview-file-tab">
                                <div class="preview-file-content mt-4"></div>
                            </div>
                        </div>
                    </div>
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

    $('#vacations-tab a[href="#preview-file-tab"]').tab('show');

    $(".preview-file-content").html(`
        <iframe width="100%" height="500px" src="https://docs.google.com/gview?url=${$(this).attr("href")}&embedded=true"></iframe>
    `);
});
//----------------------------
$(document).on("change", "#vacations-periods", function(e){

    const year = $(this).val();
    const countPending_ = $("#vacations-periods option:selected").data("pending");
    console.log(countPending_);

    const ajax = $.ajax({
        url: `${$("#base_url").data("base-url")}fastFile/getAvailableDaysOfPeriod`,
        type: "GET",
        data: { year: year, countPending: countPending_ },
        error: function(error){
            console.log(error);
        },
        success: function(data){
            const response = JSON.parse(data);
            console.log(response);
            var options = ``;

            for(var a = 1; a <= response.availableDays; a++){
                options += `<option value="${a}">${a}</option>`;
            }

            $("#antiguedad").val(year);
            $("#cantidad_dias").html(options);
            $("#apply-past-periods").val(!countPending_);
        }
    });

});
//----------------------------
$("#cantidad_dias").on("change", function(e){

    var validDate = 0;
    var returnDate = "";
    var firstDate = $("#return-to-work-hidden").val().split("/");
    var countDays = $(this).val();

    var newHolydays = _holydays.map(function(arr){

        const dateSplit = arr.split("-");
        const dateNow = new Date();
        return new Date(dateNow.getFullYear(), dateSplit[0] - 1, dateSplit[1]);

    }).filter(arr => ![0, 6].includes(arr.getDay())).map(arr => arr.getTime());

    var firstDate_ = new Date(firstDate[2], firstDate[1] - 1, firstDate[0]);
    var firstReturn = new Date(firstDate[2], firstDate[1] - 1, firstDate[0]);
    firstReturn.setDate(firstReturn.getDate() + parseInt(countDays) + 62); //62 es lo equivalente a dos meses por si el usuario requiere solicitar 1 mes de vacaciones.

    for(var a = firstDate_; a <= firstReturn; a = new Date(a.getTime() + (1000 * 60 * 60 * 24))){ //Recolectar todos los días que sean fines de semana.
        
        if([0,6].includes(a.getDay())) continue; //Descartar fines de semana.
        if(newHolydays.includes(a.getTime())) continue; //Descartar festivos.
        
        if(validDate < countDays){

            validDate ++;
        } else if(validDate == countDays){

            returnDate = a;
            break;
        }
    }

    var dateReturn_ = [
        (returnDate.getDate() < 10 ? "0" : "") + returnDate.getDate(), 
        ((returnDate.getMonth() + 1) < 10 ? "0" : "") + (returnDate.getMonth() + 1), 
        returnDate.getFullYear()
    ].join("/");

    $("#return-to-work").val(dateReturn_);
});
//---------------------------- // .for-export
$(".export-xls").on("click", function(e){

    var downloadLink;
    var filename = "Vacaciones";
    var dataType = 'application/vnd.ms-excel';
    var tableSelect = document.getElementById("for-export");
    var tableHTML = tableSelect.outerHTML.replace(/ /g, '%20');
    
    // Specify file name
    filename = filename ? filename + '.xls' : 'excel_data.xls';
    
    // Create download link element
    downloadLink = document.createElement("a");
    
    document.body.appendChild(downloadLink);
    
    if(navigator.msSaveOrOpenBlob){
        var blob = new Blob(['ufeff', tableHTML], {
            type: dataType
        });
        navigator.msSaveOrOpenBlob( blob, filename);
    }else{
        // Create a link to the file
        downloadLink.href = 'data:' + dataType + ', ' + tableHTML;
    
        // Setting the file name
        downloadLink.download = filename;
        
        //triggering the function
        downloadLink.click();
    }
});
//----------------------------