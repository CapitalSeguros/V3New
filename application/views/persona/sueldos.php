<? $idPersona = $this->tank_auth->get_idPersona(); ?>
<section class="container-fluid breadcrumb-formularios">
    <div class="row">
        <div class="col-md-5">
            <h3 class="titulo-secciones">Solicitudes de sueldos</h3>
        </div>
        <div class="col-md-6 col-sm-7 col-xs-7">
            <ol class="breadcrumb text-right">
                <li><a href="./">Inicio</a> </li><li class="active">Solicitudes Sueldos</li>
            </ol>
        </div>
    </div>
    <hr />
</section>
<section class="container" style="height: 620px;">
    <div style="float: left; width: 100%;">
        <!-- <div class="row">
            <div class="col-md-6 text-left">
            </div>
            <div class="col-md-6 text-right">
                <button class="btn-sueldo btn btn-primary pull-right">Solicitar</button>
            </div>
        </div> -->
        <br>
        <div class="panel panel-default">
            <div class="panel-body">
                <div class="col-md-12 column-flex-center-end pd-items-table">
                    <input type="text" class="form-control" id="FiltrarTS" placeholder="Filtrar" style="width: 50%">
                </div>
                <div class="col-md-12" style="height: 500px;overflow: auto;">
                    <table class="table table-striped" id="TablaSolicitudes">
                        <thead class="table-thead">
                            <tr class="table-tr">
                                <th>N°</th>
                                <th scope="col">Empleado</th>
                                <th scope="col">Área</th>
                                <th scope="col">Puesto</th>
                                <th scope="col">Email</th>
                                <th scope="col">Fecha Solicitud</th>
                                <th scope="col">Estatus</th>
                                <th></th>
                            </tr>
                        </thead>
                        <tbody class="body-table-solicitudes" id="BodyTablaSolicitudes"></tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</section>
<div class="modal fade" id="ModalDetails" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title" id="myModalLabel">Detalles de la solicitud</h4>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col-md-12" style="padding-bottom: 10px;">
                        <h5 class="modal-subtitle">
                            <i class="fas fa-info-circle"></i>Información de la petición seleccionada
                        </h5>
                    </div>
                </div>
                <div class="row" style="padding-bottom: 10px;">
                    <div class="col-md-12">
                        <span class="text-title"><i class="fas fa-user"></i>Empleado:</span>
                        <span class="text-subtitle" id="d-Empleado"></span>
                    </div>
                    <!-- <div class="col-md-12">
                        <span class="text-title"><i class="fas fa-suitcase"></i>Área:</span>
                        <span class="text-subtitle" id="d-Area"></span>
                    </div>
                    <div class="col-md-12">
                        <span class="text-title"><i class="fas fa-id-card-alt"></i>Puesto:</span>
                        <span class="text-subtitle" id="d-Puesto"></span>
                    </div>
                    <div class="col-md-12">
                        <span class="text-title"><i class="fas fa-envelope"></i>Email:</span>
                        <span class="text-subtitle" id="d-Email"></span>
                    </div> -->
                    <div class="col-md-12">
                        <span class="text-title"><i class="fas fa-user-tie"></i>Jefe:</span>
                        <span class="text-subtitle" id="d-Jefe"></span>
                    </div>
                    <div class="col-md-12">
                        <span class="text-title"><i class="fas fa-user-edit"></i>Creado por:</span>
                        <span class="text-subtitle" id="d-Creador"></span>
                    </div>
                    <div class="col-md-12">
                        <span class="text-title"><i class="fas fa-calendar-alt"></i>Solicitado el:</span>
                        <span class="text-subtitle" id="d-Fecha"></span>
                    </div>
                    <div class="col-md-12">
                        <span class="text-title"><i class="fas fa-clipboard-list"></i>Estatus:</span>
                        <span class="text-subtitle" id="d-Estatus"></span>
                    </div>
                    <div class="col-md-12">
                        <span class="text-title"><i class="fas fa-edit"></i>Motivo:</span>
                        <span class="text-subtitle" id="d-Motivo"></span>
                    </div>
                </div>
                <hr class="divider-hr">
                <div class="content-form-sueldos" id="containerRequest"></div>
                <div class="row">
                    <div class="col-md-12">
                        <h5 class="modal-subtitle">
                            <i class="fas fa-edit"></i>Estatus de la solicitud
                        </h5>
                    </div>
                </div>
                <div class="col-md-12" id="ModalBody"></div>
            </div>
            <div class="modal-footer">
                <button class="btn btn-primary" id="ModalRBtn" onclick="guardar_solicitud()">Guardar</button>
                <button type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button>
            </div>
        </div>
    </div>
</div>
<div class="modal fade" id="ModalHistorial" tabindex="-1" role="dialog" aria-labelledby="xd">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title">Proceso de solicitud</h4>
            </div>
            <div class="modal-body">
                <div class="content-table-record"></div>
                <div class="col-md-12" id="BodyModalHistorial">
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button>
            </div>
        </div>
    </div>
</div>

<style type="text/css">
    /*ID*/
        /*#TablaSolicitudes {
            height: 100%; margin: 0px;
        }*/
        #ModalDetails {background: #00000014;}
    /*Modals*/
        .modal-footer {position: relative;}
        .modal-subtitle {text-align: center;/* font-weight: 600; */font-size: 15px;}
        .modal-subtitle > i {margin-right: 5px;}
    /*Containers*/
        .content-form-sueldos {width: 94%;height: -webkit-fill-available;position: absolute;}
    /*Spinners*/
        .container-spinner-content-loading {
            margin: 0px;
            color: #266093;
            width: 100%;
            height: 100%;
            align-items: center;
            display: flex;
            flex-direction: column;
            justify-content: center;
            position: relative;
            background-color: rgb(255 255 255 / 85%);
            z-index: 3;
            transition: all 0.3s;
        }
        .container-spinner-btn-loading {
            margin: 0px;
            color: white;
            width: 100%;
            height: 100%;
            align-items: center;
            display: flex;
            flex-direction: column;
            justify-content: center;
            position: relative;
            /*z-index: 1;*/
            padding: 0px 13px;
            transition: all 0.3s;
        }
    /*Columns*/
        .column-flex-center-center {display: flex;justify-content: center;align-items: center;}
        .column-flex-center-start {display: flex;justify-content: flex-start;align-items: center;}
        .column-flex-center-end {display: flex;justify-content: flex-end;align-items: center;}
        .column-flex-content-center {display: flex;justify-content: center;}
        .column-flex-start {display: flex;justify-content: flex-start;}
        .column-flex-end {display: flex;justify-content: flex-end;}
        .column-flex-items-center {display: flex;align-items: center;}
        .column-flex-bottom {display: flex;align-items: flex-end;}
        .column-grid-start {display: flex;flex-direction: column;align-items: flex-start;}
        .column-grid-center {display: flex;flex-direction: column;align-items: center;justify-content: center;}
        .column-flex-space-evenly {display: flex;justify-content: space-evenly;}
        .width-ajust {width: 100%;max-width: max-content;}
    /*Botons*/
        .btn-primary.active, .btn-primary.focus, .btn-primary:active, .btn-primary:focus, .btn-primary:hover, 
        .open>.dropdown-toggle.btn-primary {color: #fff;background-color: #286090;border-color: #286090;}
        .btn-primary {color: #fff;background-color: #286090;border-color: #286090;font-size: 13px;}
        .btn-primary.btn-sm {font-size: 12px;}
        .btn-sueldo {outline: none;border-radius: 5px;}
        .btn-urlfile {color: #4c92b9;}
        .btn-urlfile:hover {color: #57c3ff;}
    /*Tables*/
        table {height: 100%;margin: 0px;font-size: 12px;}
        /*table > tbody {font-size: 12px;}*/
        tbody > tr > td > button, tbody > tr > td > a {font-size: 12px;}
        td > span.label { font-size: 12px;font-weight: 600; }
        .table > thead >.tr-style {background: #1e4c82;/*#5d418b*/z-index: 1;}
        .table > thead >.table-tr {background: #5d418b;z-index: 1;}
        .table-thead {position: sticky;top: 0;z-index: 1;}
        .table-tfoot {position: sticky;bottom: 0px; background-color:#e3e3e3;}
    /*Texts*/
        .title-status {text-align: center;margin-bottom: 20px;color: black;}
        .text-title {font-size: 13px;color: #2d2d2d;}
        .text-title > i {margin-right: 5px;}
        .text-subtitle {font-size: 13px;font-weight: 600;}
        .label-primary {padding: .4em .6em;line-height: unset;background-color: #3f5f8f;}
        .label-success {padding: .4em .6em;line-height: unset;background-color: #009d21;/*#3f8f66*/}
        .label-warning {padding: .4em .6em;line-height: unset;color: black;}
        .label-danger {padding: .4em .6em;line-height: unset;background-color: #d80600;}
        .label-wine {padding: .4em .6em;line-height: unset;background-color: #97154b;}
    /*Others*/
        .pd-left {padding-left: 0px;}
        .pd-right {padding-right: 0px;}
        .pd-top {padding-top: 15px;}
        .pd-bottom {padding-bottom: 15px;}
        .pd-items-table {padding-bottom: 5px;}
        .divider-hr {border-color: #d3d3d3;margin: 10px 0px;}
    /*Swal*/
        .swal-modal {width: 28%; /* 68% height: 40%*/}
        .swal-button--confirm{background-color:#337ab7!important;}
        .swal-text{/*color:#472380 !important;*/font-size: 17px;text-align: center;}
    /*Media Query*/
        @media (min-width: 768px) {
            #ModalDetails > .modal-dialog {
                margin: 1% auto;
            }
        }
</style>
<link rel="stylesheet" href="<?php echo base_url();?>assets/css/iconos.css">
<link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.10.21/css/jquery.dataTables.css">
<script src="https://cdn.jsdelivr.net/npm/bootstrap@3.4.1/dist/js/bootstrap.min.js" integrity="sha384-aJ21OjlMXNL5UyIl/XNwTMqvzeRMZH2w8c5cRVpzpU8Y5bApTppSuUkhZXN0VxHd" crossorigin="anonymous"></script>
<script type="text/javascript" charset="utf8" src="https://cdn.datatables.net/1.10.21/js/jquery.dataTables.js"></script>
<script>
    const base = "<?=base_url()?>fastFile";
    //Formato Monetario
    const money = { style: 'currency', currency: 'MXN' };
    const numberFormat = new Intl.NumberFormat('es-MX', money);

    $(document).ready(function() {
        tabla_solicitudes();

        $('#FiltrarTS').keyup(function() {
            filtrar_solicitudes();
        })
    });

    function tabla_solicitudes() {
        $.ajax({
            type: "GET",
            url: `${base}/getSalaries`,
            data: {
              id: "si"
            },
            beforeSend: (load) => {
                $('.body-table-solicitudes').html(`
                    <tr>
                        <td colspan="9">
                            <div class="container-spinner-content-loading">
                                <div class="spinner-border" role="status">
                                    <span class="visually-hidden"></span>
                                </div>
                                <p class="cr-cargando" style="font-size:18px;">Cargando...</p>
                            </div>
                        </td>
                    </tr>
                `);
            },
            success: (data) => {
                const r = JSON.parse(data);
                console.log(r);
                var trtd = ``;

                if (r != 0) {
                    for (const s in r) {
                        const id = r[s].id;
                        const estatus = r[s].estatus;
                        const fecha = getDateFormat(r[s].fecha,3);
                        var comentario = getTextValue(r[s].motivo);
                        var textStatus = "label-primary";
                        var disabled = "disabled";
                        var op = ``;
                        if (comentario == "") { comentario = "Sin definir"; }
                        if (r[s].estatus == "AUTORIZADO") { textStatus = "label-success"; }
                        else if (r[s].estatus == "RECHAZADO") { textStatus = "label-danger"; }
                        else if (r[s].estatus == "CANCELADO") { textStatus = "label-warning"; }
                        <? if ($permission == 1) { ?> 
                            op = `<li><button class="dropdown-item btnShowDetails"  data-id="${r[s].id}">Ver</button></li>`;
                        <? } ?>
                        trtd += `
                            <tr class="mostrar">
                                <td>${Number(s) + 1}</td>
                                <td>${getTextValue(r[s].name_complete)}</td>
                                <td>${r[s].colaboradorArea}</td>
                                <td>${r[s].personaPuesto}</td>
                                <td>${getTextValue(r[s].email)}</td>
                                <td>${fecha}</td>
                                <td><span class="label ${textStatus}" id="status${r[s].id}">${estatus}</span></td>
                                <td style="text-align: center;">
                                    <div class="dropdown">
                                        <button class="btn btn-link" type="button" id="dp${id}" data-toggle="dropdown" aria-haspopup="true" aria-expanded="true">
                                            <i class="fa fa-ellipsis-v" aria-hidden="true"></i>
                                        </button>
                                        <ul class="dropdown-menu" aria-labelledby="dp${id}">
                                            <li><button class="dropdown-item" onclick="historial_solicitud(${id})">Seguimiento</button></li>
                                            ${op}
                                        </ul>
                                    </div>
                                </td>
                            </tr>
                        `;
                    }
                }
                else {
                    trtd += `<tr><td colspan="9"><center><strong>Sin resultados</strong><center></td></tr>`;
                }
                $('.body-table-solicitudes').html(trtd);
                $('.btnShowDetails').click(function() {
                    const id = $(this).data('id');
                    var div = ``;
                    for (const e in r) {
                        if (r[e].id == id) {
                            $('#d-Empleado').text(r[e].name_complete);
                            /*$('#d-Area').text(getTextValue(r[e].colaboradorArea));
                            $('#d-Puesto').text(getTextValue(r[e].personaPuesto));
                            $('#d-Email').text(getTextValue(r[e].email));*/
                            $('#d-Jefe').text(getTextValue(r[e].jefe));
                            $('#d-Creador').text(getTextValue(r[e].creador));
                            $('#d-Fecha').text(getDateFormat(r[e].fecha,5));
                            $('#d-Estatus').text(getTextValue(r[e].estatus));
                            $('#d-Motivo').text(getTextValue(r[e].motivo));
                            if (r[e].estatus == "PENDIENTE") {
                                div = `
                                    <div class="row hidden">
                                        <div class="col-md-3">
                                            <div class="form-group">
                                                <label class="control-label">
                                                    <strong>ID:</strong>
                                                </label>
                                                <input class="form-control" id="request" value="${id}">
                                            </div>
                                        </div>
                                        <div class="col-md-3">
                                            <div class="form-group">
                                                <label class="control-label">
                                                    <strong>Empleado:</strong>
                                                </label>
                                                <input type="text" class="form-control" id="user" value="<?= $idPersona?>">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-5 width-ajust pd-right">
                                            <div class="form-group">
                                                <label class="control-label">
                                                    <strong>Estatus:</strong>
                                                </label>
                                                <select class="form-control" id="status">
                                                    <option></option>
                                                    <option>AUTORIZADO</option>
                                                    <option>RECHAZADO</option>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="col-md-3 pd-right">
                                            <div class="form-group">
                                                <label class="control-label">
                                                    <strong>Monto:</strong>
                                                </label>
                                                <div class="input-group">
                                                    <input type="text" class="form-control" id="money" value="${r[e].importe}">
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-4 width-ajust">
                                            <div class="form-group">
                                                <label class="control-label">
                                                    <strong>Fecha:</strong>
                                                </label>
                                                <div class="input-group width-ajust">
                                                    <input type="date" class="form-control" id="date" value="<?=date('Y-m-d')?>" readonly>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-12">
                                            <div class="form-group">
                                                <label class="control-label">
                                                    <strong>Comentario:</strong>
                                                </label>
                                                <textarea maxlength="400" class="form-control" name="comentario" id="ms-descp"></textarea>
                                                <label class="control-label" style="margin: 0px;">
                                                    Caracteres ingresados: <span id="caracteres">0</span> de 400
                                                </label>
                                            </div>
                                        </div>
                                    </div>
                                `;
                                $('#ModalRBtn').css('display',"");
                            }
                            else {
                                $('#ModalRBtn').css('display',"none");
                                var estatus = "";
                                switch (r[e].estatus) {
                                    case "AUTORIZADO": estatus = "AUTORIZADA"; break;
                                    case "RECHAZADO": estatus = "RECHAZADA"; break;
                                    case "CANCELADO": estatus = "CANCELADA"; break;
                                } 
                                div = `<h5 class="title-status">Solicitud <strong>${estatus}</strong>.</h5>`;
                            }
                        }
                    }
                    $('#ModalBody').html(div);
                    contador("#ms-descp","#caracteres");
                    $("#ModalDetails").modal({
                        show: true,
                        keyboard: false,
                        backdrop: false,
                    });
                })
            },
            error: (error) => {
                $('.body-table-solicitudes').html(`<tr><td colspan="9"><center><strong>Sin resultados</strong><center></td></tr>`);
               swal("¡Uups!", "Hay conflicto al buscar la información.", "error");
            }            
        })
    }

    function historial_solicitud(id) {
        $.ajax({
            type: "GET",
            url: `${base}/getRequestHistory`,
            data: {
              id: id
            },
            beforeSend: (load) => {
              $('.content-table-record').html(`
                <div class="container-spinner-content-sueldo">
                  <div class="bd-spinner spinner-border" role="status">
                    <span class="visually-hidden"></span>
                  </div>
                </div>
              `);
            },
            success: (data) => {
                const r = JSON.parse(data);
                console.log(r);
                var table = ``;
                $('.content-table-record').html("");
                if (r != 0) {
                    table = `
                        <table class="table" id="TablaHistorial">
                            <thead class="table-thead">
                                <tr class="table-tr">
                                    <th scope="col">Hecha Por</th>
                                    <th scope="col">Email</th>
                                    <th scope="col">Estatus</th>
                                    <th scope="col">Comentario</th>
                                    <th scope="col">Fecha</th>
                                </tr>
                            </thead>
                            <tbody class="body-table-solicitudes" id="BodyTablaHistorial">
                    `;
                    for (const h in r) {
                        const id = r[h].id;

                        table += `
                            <tr data-id="tableHistory${id}">
                                <td>${r[h].name_complete}</td>
                                <td>${r[h].email}</td>
                                <td><strong>${r[h].estatus}</strong></td>
                                <td>${getTextValue(r[h].motivo)}</td>
                                <td>${getDateFormat(r[h].fecha,1)}</td>
                            </tr>
                        `;
                    }
                    table += `</tbody></table>`;
                }
                else {
                    table = `<h5 class="text-center">Sin registros.</h5>`;
                }
                $('#BodyModalHistorial').html(table);
            },
            error: (error) => {
               swal("¡Uups!", "Hay conflicto al buscar la información.", "error");
            }            
        })
        $("#ModalHistorial").modal({
            show: true,
            keyboard: false,
            backdrop: false,
        });
    }

    function guardar_solicitud() {
        const id = document.getElementById('request').value;
        const user = document.getElementById('user').value;
        const status = document.getElementById('status').value;
        const money = document.getElementById('money').value;
        const comment = document.getElementById('ms-descp').value;
        console.log("ID: "+id+", User: "+user+", Status: "+status+", Money: "+money+", Comment: "+comment);
        if (status != 0) {
            $.ajax({
            type: "POST",
            url: `${base}/saveSalaryRequestStatus`,
            data: {
              id: id,
              us: user,
              st: status,
              mn: money,
              cm: comment
            },
            beforeSend: (load) => {
                $('#containerRequest').html(`
                    <div class="container-spinner-content-loading">
                        <div class="spinner-border" role="status">
                            <span class="visually-hidden"></span>
                        </div>
                        <p class="cr-cargando" style="font-size:18px;">Cargando...</p>
                    </div>
                `);
            },
            success: (data) => {
                const r = JSON.parse(data);
                console.log(r);
                $('#containerRequest').html("");
                if (r['update'] == true) {
                    swal("¡Guardado!", "Cambios realizados.", "success");
                    tabla_solicitudes();
                }
                else {
                    swal("¡Uups!", "Hay problemas  al intentar guardar la información.", "error");
                }
            },
            error: (error) => {
                console.log(error);
                $('#containerRequest').html("");
                swal("¡Vaya!", "Hay problemas  al intentar guardar la información.", "error");
            }            
        })
        }
        else {
            swal("¡Espera!", "Te falta seleccionar el estatus.", "warning");
        }
    }

    //------------------------------- OPERACIONES -----------------------------------
    let nameM = new Array ("Ene","Feb","Mar","Abr","May","Jun","Jul","Ago","Sep","Oct","Nov","Dic");
    let numbermonth = new Array ("01","02","03","04","05","06","07","08","09","10","11","12");
    let nameD = new Array("Dom", "Lun", "Mar", "Mié", "Jue", "Vie", "Sáb");
    let numberday = new Array("00","01","02","03","04","05","06","07","08","09","10","11","12","13","14","15","16","17","18","19","20","21","22","23","24","25","26","27","28","29","30","31");
    let monthname = new Array ("Enero","Febrero","Marzo","Abril","Mayo","Junio","Julio","Agosto","Septiembre","Octubre","Noviembre","Diciembre");
    let dayname = new Array("Domingo", "Lunes", "Martes", "Miércoles", "Jueves", "Viernes", "Sábado");

    function filtrar_solicitudes() {
        var input, filter, table, tr, td, i, j, visible;
        input = document.getElementById("FiltrarTS");
        filter = input.value.toUpperCase();
        table = document.getElementById("BodyTablaSolicitudes");
        tr = table.getElementsByTagName("tr");
        let Fila = document.getElementsByClassName('mostrar');

        for (i = 0; i < tr.length; i++) {
            visible = false;
            td = tr[i].getElementsByTagName("td");
            for (j = 0; j < td.length; j++) {
                if (td[j] && td[j].innerHTML.toUpperCase().indexOf(filter) > -1) {
                    visible = true;
                }
            }
            if (visible === true) {
                tr[i].style.display = "";
                $(tr[i]).addClass('mostrar');
            }
            else {
                tr[i].style.display = "none";
                $(tr[i]).removeClass('mostrar');
            }
        }
        result = Fila.length;
    }

    function contador(textarea, caracteres){
        function update_contador(textarea, caracteres){
            var contador = $(caracteres);
            var ta = $(textarea);   
            contador.html(ta.val().length);
        }
        $(textarea).keyup(function(){
            update_contador(textarea,caracteres);
        });
        $(textarea).change(function(){
            update_contador(textarea,caracteres);
        });
    }

    function newWindow(e,objeto){
        e.preventDefault();
        window.open(objeto.getAttribute('href'));
    }  

    function getTextValue(data) {
        if (data == "[object Object]" || data == undefined || data == null || data == "") {
            data = "";
        }
        return data;
    }

    function getDateFormat(data,format) {
        var dateF = "";

        if (data == undefined || data == null || data == "") {
            dateF = "";
        }
        else {
            date = new Date(data);
            if (format == 1) {
                dateF = date.getDate() + "/" + nameM[date.getMonth()] + "/" + date.getFullYear();
            }
            else if (format == 2) {
                dateF = date.getDate() + "/" + numbermonth[date.getMonth()] + "/" + date.getFullYear();
            }
            else if (format == 3) {
                dateF = date.getFullYear() + "/" + numbermonth[date.getMonth()] + "/" + numberday[date.getDate()];
            }
            else if (format == 4) {
                dateF = date.getFullYear() + "-" + numbermonth[date.getMonth()] + "-" + numberday[date.getDate()];
            }
            else if (format == 5) {
                dateF = dayname[date.getDay() + 1] + " " + numberday[date.getDate() + 1] + " de " + monthname[date.getMonth()] + " del " + date.getFullYear();
            }
        }
        return dateF;
    }
</script>