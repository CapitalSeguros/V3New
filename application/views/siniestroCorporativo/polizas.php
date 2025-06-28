<script src="<?= base_url() ?>/assets/gap/js/jquery.validate.js"></script>
<style>
    .title-infoS {
        margin-top: 10px;
        margin-bottom: 10px;
    }

    .btnACt {
        float: right;
        margin-right: 15px;
        margin-top: 20px;
    }

    .card-round {
        border-radius: 5px;
        width: 100px;
        max-width: 100px;
    }

    .Siniestro-body {
        display: inline-block;
    }

    .box.first {
        float: left;
    }

    .edit {
        margin-bottom: unset !important;
    }

    dd button {
        margin-top: 10px;
    }

    .edit dt {
        margin-top: 10px;
        margin-bottom: 3px;
    }

    .col-M2 {
        width: 119px !important;
    }

    span {
        margin-right: 5px !important;
    }

    .edit dd {
        margin-top: 3px;
        margin-bottom: 3px;
    }

    .btn-filter {
        float: left;
        vertical-align: middle;
        margin-top: 20px;
        margin-left: 100px;
    }

    .datetimeI {
        width: 269px !important;
    }

    .erorrT {
        color: #a94442;
    }

    .erorrI input {
        color: #a94442;
        border-color: #a94442;
    }

    /* spiner */
    #nprogress {
        pointer-events: none;
        height: 100%;
        left: 0;
        position: fixed;
        top: 0;
        width: 100%;
        z-index: 1040;
    }

    #nprogress .spinner {
        display: block;
        position: fixed;
        right: 50%;
        top: 50%;
        margin-left: -10px;
        margin-top: -10px;
        z-index: 1031;
    }

    #nprogress .spinner-icon {
        border: solid 2px transparent;
        border-left-color: #8AD703;
        border-radius: 50%;
        border-top-color: #8AD703;
        box-sizing: border-box;
        height: 20px;
        width: 20px;
        position: absolute;
        -webkit-animation: nprogress-spinner 400ms linear infinite;
        animation: nprogress-spinner 400ms linear infinite;
    }

    #nprogress .spinner-icon-bg {
        border: solid 2px rgba(0, 0, 0, 0.2);
        border-radius: 50%;
        box-sizing: border-box;
        height: 20px;
        width: 20px;
    }

    #nprogress .overlay {
        background-color: #000;
        background-color: rgba(0, 0, 0, 0.4);
        color: #fff;
        display: block;
        height: 100%;
        position: fixed;
        text-align: center;
        top: 0;
        width: 100%;
        z-index: 1030;
    }

    .pagination {
        margin: unset !important;
    }

    .label-P {
        margin-top: 10px;
        font-weight: 700;
    }

    .btn-P {
        margin-top: 30px;
    }

    .dis-li {
        pointer-events: none;
        opacity: 0.6;
    }

    .li-info {
        cursor: pointer;
    }

    .blocker {
        position: absolute;
        top: 0px;
        left: 0px;
        height: 100%;
        width: 100%;
        z-index: 50;
    }

    input.ls {
        position: relative;
        color: white;
    }

    input.ls:before {
        position: absolute;
        /* top: 3px; */
        left: 10px;
        content: attr(data-date);
        display: inline-block;
        color: #472380 !important;
    }

    input.ls::-webkit-datetime-edit,
    input::-webkit-inner-spin-button,
    input::-webkit-clear-button {
        display: none;
    }

    input.ls::-webkit-calendar-picker-indicator {
        position: absolute;
        /* top: 3px; */
        right: 10px;
        color: #472380 !important;
        opacity: 1;
    }

    .Select-option:nth-child(n+6) {
        display: none;
    }

    .Select-option:last-child,
    .Select-option:nth-child(5) {
        border-bottom-right-radius: 4px;
        border-bottom-left-radius: 4px;
    }

    .css-dvua67-singleValue {
        color: #472380 !important;
    }

    .filter-input {
        height: 40px !important;
    }

    .progressBar {
        background-color: lightgrey;
        width: 200px;
        height: 20px;
    }

    .progressb {
        height: 100%;
    }

    span.multiselect-native-select {
        position: relative
    }

    span.multiselect-native-select select {
        border: 0 !important;
        clip: rect(0 0 0 0) !important;
        height: 1px !important;
        margin: -1px -1px -1px -3px !important;
        overflow: hidden !important;
        padding: 0 !important;
        position: absolute !important;
        width: 1px !important;
        left: 50%;
        top: 30px
    }

    .multiselect-container {
        position: absolute;
        list-style-type: none;
        margin: 0;
        padding: 0
    }

    .multiselect-container .input-group {
        margin: 5px
    }

    .multiselect-container>li {
        padding: 0
    }

    .multiselect-container>li>a.multiselect-all label {
        font-weight: 700
    }

    .multiselect-container>li.multiselect-group label {
        margin: 0;
        padding: 3px 20px 3px 20px;
        height: 100%;
        font-weight: 700
    }

    .multiselect-container>li.multiselect-group-clickable label {
        cursor: pointer
    }

    .multiselect-container>li>a {
        padding: 0
    }

    .multiselect-container>li>a>label {
        margin: 0;
        height: 100%;
        cursor: pointer;
        font-weight: 400;
        padding: 3px 0 3px 30px
    }

    .multiselect-container>li>a>label.radio,
    .multiselect-container>li>a>label.checkbox {
        margin: 0
    }

    .multiselect-container>li>a>label>input[type=checkbox] {
        margin-bottom: 5px
    }

    .btn-group>.btn-group:nth-child(2)>.multiselect.btn {
        border-top-left-radius: 4px;
        border-bottom-left-radius: 4px
    }

    .form-inline .multiselect-container label.checkbox,
    .form-inline .multiselect-container label.radio {
        padding: 3px 20px 3px 40px
    }

    .form-inline .multiselect-container li a label.checkbox input[type=checkbox],
    .form-inline .multiselect-container li a label.radio input[type=radio] {
        margin-left: -20px;
        margin-right: 0
    }

    .dropdown-menu>.active>a,
    .dropdown-menu>.active>a:focus,
    .dropdown-menu>.active>a:hover {
        background-color: #472380 !important;
    }

    .contorno {
        padding-top: 9px;
        padding-bottom: 9px;
        font-size: 9px;
        color: white !important;
    }

    .modal-fullsize {
        width: 80vw !important;
        margin-left: -20vw;
    }

    .tab-tramites {
        overflow: auto;
        max-height: 50vh;
        overflow-x: hidden;
    }

    .documentos_see {
        text-align: center;
        white-space: nowrap;
        text-overflow: ellipsis;
        overflow: hidden;
    }

    .maple {
        -webkit-transform: unset !important;
        transform: unset !important;
    }
</style>
<script src="<?= base_url() ?>/assets/gap/js/Prueba.js"></script>
<section class="container-fluid breadcrumb-formularios">
    <a id="N" data-IdNotificacion='<?= $idNotificacion; ?>'></a>
    <div class="row">
        <div class="col-md-6 col-sm-5 col-xs-5">
            <h3 class="titulo-secciones">Pólizas</h3>
        </div>
        <div class="col-md-6 col-sm-7 col-xs-7 d-flex">
            <ol class="breadcrumb text-right">
                <li><a href="<?= base_url() ?>">Inicio</a></li>
                <li><a href="<?= base_url() ?>Siniestros">Tablero</a></li>
                <li class="active">Autos Coorporativo</li>
            </ol>
        </div>
    </div>
    <hr />
</section>
<section class="container-fluid">
    <?= $this->load->view('evaluaciones/_parts/sidemenu2', array("tipo" => $tipo)); ?>

    <div style="float: left; width: 90%;">
        <div class="panel panel-default">
            <div class="panel-body">
                <div class="row">
                    <div class="col-sm-2">
                        <label>Buscar </label>
                        <input type="text" placeholder="Buscar..." id="txSearch" class="form-control input-sm" name="search" />
                        <input type="hidden" id="year" name="2">
                        <input type="hidden" id="Tramites_Autos" name="10">
                        <input type="hidden" id="cbEstado_2" name="7">
                    </div>
                    <div class="col-sm-2">
                        <label>Fecha inicio </label>
                        <input type="date" class="form-control input-sm" id="Finicio" />
                    </div>
                    <div class="col-sm-2">
                        <label>Fecha fin </label>
                        <input type="date" class="form-control input-sm" id="Ffin" />
                    </div>
                    <div class="col-md-6 text-right" style="margin-top: 10px;">
                        <a href="<?= base_url() ?>siniestroCorporativo/AddPoliza" class="btn btn-primary Nuevo">Nuevo</a>
                    </div>
                    <!-- <div class="col-sm-2">
                        <label>Evento </label><br>
                        <select id="Tipos" class="multiselect-ui form-control" multiple="multiple">
                        </select>
                    </div>
                    <div class="col-sm-2">
                        <label>Estatus siniestro </label>
                        <select class="form-control input-sm" id="cbEstado" name="7">
                            <option value="">Todos</option>
                            <option value="N/A">N/A</option>

                        </select>
                    </div> -->
                </div>
                <div class="row">
                    <div class="col-md-12">
                        <table class="table table-condensed" id="polizas">
                            <thead>
                                <tr>
                                    <th scope="col">id</th>
                                    <th scope="col" style="width: 200px;">Poliza</th>
                                </tr>
                            </thead>
                            <tbody>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div><!-- panel-body -->
        </div><!-- panel-default -->
        <div class="modal-seguimiento-container"></div>
        <!--  <div id="block" class="blocker" style="display: none"></div> -->
        <div id="siniestro-container">
        </div>
        <!--   <div id="selectm">
        </div> -->
        <button id="reloadT" style="display: none" onclick="reloadTable()">Algo</button>
    </div>


</section>


<div id="upProgressGeneral" style="display:none;" role="status" aria-hidden="true">
    <div id="nprogress" class="nprogress">
        <div class="spinner">
            <div class="spinner-icon"></div>
            <div class="spinner-icon-bg"></div>
        </div>
        <div class="overlay"></div>
    </div>
</div>
<script src="<?= base_url() ?>assets/gap/js/permisos.js"></script>
<script>
    $(document).ready(function() {
        var element = document.querySelector(".pace");
        element.classList.remove("pace-active");
        element.classList.add("pace-inactive");

        var label = '';
        const $IdNotificacion = $("#N").attr("data-idnotificacion");

        var element = document.querySelector(".pace");
        element.classList.remove("pace-active");
        element.classList.add("pace-inactive");
        //var isEdit = true;//Saber si se puede modificar el modal de tramites

        //console.log("Notificacion",$idNotificacion);
        $('body').append('<div id="over" style="display:none;position: absolute;top:0;left:0;width: 100%;height:100%;z-index:2;opacity:0.4;filter: alpha(opacity = 50)"></div>');
        const $path = $("#base_url").attr("data-base-url");


        const datatable = $('#polizas').DataTable({
            processing: true,
            serverSide: true,
            searching: false,
            lengthChange: false,
            preDrawCallback: function() {
                //document.getElementById("over").style.display = "block";
                //document.getElementById("upProgressGeneral").style.display = "block";
            },
            initComplete: function() {
                /* $('.multiselect-ui').multiselect({
                    nonSelectedText: 'Seleccione',
                    numberDisplayed: 1,
                }); */
            },
            language: {
                url: `${$path}assets/js/espanol.json`
            },
            ajax: {
                url: `${$path}siniestroCorporativo/getPolizas`,
                type: 'GET',
                "data": function(d) {
                    return $.extend({}, d, {
                        "search": $("#txSearch").val(),
                        "finicio": $("#Finicio").val(),
                        "ffin": $("#Ffin").val(),
                        "tipo": 1
                    });
                }
            },
            drawCallback: function() {
                //document.getElementById("over").style.display = "none";
                //document.getElementById("upProgressGeneral").style.display = "none";
            },
            ordering: false,
            columns: [{
                    data: 'Id',
                    visible: false
                },
                {
                    data: 'status_id',
                    width: '100%',
                    orderable: false,
                    render: function(data, type, row) {
                        //console.log(row);
                        //var colorS = color(row.estatusSiniesto);
                        //console.log('row',JSON.stringify(row).replace());
                        return `
                            <div class="col-md-12">
                                   <div>
                                        <b>Póliza:</b> ${row.Poliza} | <b>Serie:</b> ${row.Serie}| <b>Economico:</b> ${row.Economico}| <b>Modelo:</b> ${row.Modelo} |  <b>Desde: </b> ${row.FDesde==null || row.FDesde=="0000-00-00 00:00:00"?'N/A':moment(row.FDesde).format("DD/MM/YYYY")} |<b>Hasta:</b>${row.FHasta==null || row.FHasta=="0000-00-00 00:00:00"?'N/A':moment(row.FHasta).format("DD/MM/YYYY")}
                                        <br/> <b>Descripción:</b>  ${row.Descripcion}
                                        <div style="text-align: right; margin-top: -30px;">
                                                    <div class="dropdown">
                                                        <button class="btn btn-link dropdown-toggle" type="button" id="dp${row.Id}" data-toggle="dropdown" aria-haspopup="true" aria-expanded="true" >
                                                            <i class="fa fa-ellipsis-v" aria-hidden="true"></i>
                                                        </button>
                                                        <ul class="dropdown-menu dropdown-menu-right"  aria-labelledby="dp${row.Id}">
                                                            <li><a class="bn-bono-view"  style="cursor: pointer;" href="${$path}siniestroCorporativo/AddPoliza/${row.Id}"  data-permiso="permiso" data-accion-permiso="Editar">Editar</a></li>
                                                            <li onclick="deleteItem('${row.Id}')" data-id="${row.Id}"><a class="bn-bono-view"  style="cursor: pointer;"   data-permiso="permiso" data-accion-permiso="Editar">Eliminar</a></li>
                                                        </ul>
                                                    </div>
                                        </div>
                                   </div> 
                            </div>`
                    }
                },
            ],
            order: [
                [0, 'desc']
            ],


        });
        minDateFilter = "";
        maxDateFilter = "";
        $.fn.dataTableExt.afnFiltering.push(
            function(oSettings, aData, iDataIndex) {
                //console.log("adata",aData);
                if (typeof aData._date == 'undefined') {
                    aData._date = new Date(aData[5]).getTime();
                }

                if (minDateFilter && !isNaN(minDateFilter)) {
                    if (aData._date < minDateFilter) {
                        return false;
                    }
                }

                if (maxDateFilter && !isNaN(maxDateFilter)) {
                    if (aData._date > maxDateFilter) {
                        return false;
                    }
                }

                return true;
            }
        );

        window.deleteItem = function(id) {
            //console.log("id", id);

            swal({
                title: "¿Está seguro de que quiere eliminar el documento seleccionado?",
                text: "Una vez eliminado, ¡no podrá recuperar el elemento!",
                icon: "warning",
                buttons: ["Cancelar", "Aceptar"],
            }).then((value) => {
                if (value) {
                    var dta = new FormData();
                    dta.append(`siniestro_poliza[id]`, id);
                    dta.append(`siniestro_poliza[accion]`, 2);
                    $.ajax({
                        type: 'POST',
                        url: `${$path}siniestroCorporativo/AccionesPoliza`,
                        data: dta,
                        processData: false,
                        contentType: false,
                        success: function(response) {
                            if (response.code == 200) {
                                toastr.success("Se guardo con éxito.");
                                datatable.draw();
                                //window.location.replace(`${$path}siniestroCorporativo/Polizas`)
                            } else {
                                toastr.error(response.message);
                            }

                        }
                    });
                }
            });
        }

        $(document).on('input', '#txSearch', function(e) {
            datatable.draw();
        });

        $(document).on('input', '#Finicio', function(e) {
            // minDateFilter = new Date(e.currentTarget.value).getTime();
            datatable.draw();
        });

        //evento del inputdate Fecha fin
        $(document).on('input', '#Ffin', function(e) {
            maxDateFilter = new Date(e.currentTarget.value).getTime();
            var inputDate = new Date(e.currentTarget.value);
            inputDate.setDate(inputDate.getDate() + 1);
            maxDateFilter = inputDate;
            if (minDateFilter > maxDateFilter) {
                swal("Error", "La fecha seleccionada debe de ser mayor", "error");
                $(e.currentTarget).val('');
            } else {
                datatable.draw();
            }
        });




    });
</script>