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
            <h3 class="titulo-secciones">Autos Corporativo</h3>
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
                    <div class="col-sm-2">
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
                    </div>
                    <div class="col-sm-2">
                        <label>Seguimiento </label>
                        <select class="form-control input-sm" id="cbSeguimiento" name="7">
                            <option value="">Todos</option>
                            <option value="N/A">N/A</option>
                        </select>
                    </div>
                    <div class="col-sm-2">
                        <label>Etapa </label>
                        <select class="form-control input-sm" id="cbEtapa" name="7">
                            <option value="">Todos</option>
                        </select>
                    </div>
                    <div class="col-sm-2">
                        <label>Seguimiento Estatus </label>
                        <select class="form-control input-sm" id="cbEseguimiento" name="7">
                            <option value="">Todos</option>
                        </select>
                    </div>
                    <div class="col-md-8 text-right" style="margin-top: 10px;">
                        <a href="<?= base_url() ?>siniestroCorporativo/add" class="btn btn-primary Nuevo">Nuevo siniestro</a>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-12">
                        <table class="table table-condensed" id="Tabla_siniestros">
                            <thead>
                                <tr>
                                    <th scope="col">id</th>
                                    <th scope="col" style="width: 200px;">Estado</th>
                                    <th scope="col">Siniestro</th>
                                    <th scope="col">Progreso</th>
                                    <th style="text-align: center;" scope="col">Acciones</th>
                                    <th scope="col">Fecha</th>
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

        window.itemsArray = function() {
            //var acum = `<option value="">Todos</option><option value='N/A'>N/A</option>`;
            var acum = `<option value="">Todos</option>`;
            _estatus.forEach(element => {
                if (element.nombre == "EN TRAMITE") {
                    // acum += `<option value='${element.nombre}' selected>${element.nombre}</option>`;
                    acum += `<option value='${element.nombre}' >${element.nombre}</option>`;
                } else {
                    acum += `<option value='${element.nombre}'>${element.nombre}</option>`;
                }

            });
            //return acum;
            $("#cbEstado").html();
            $("#cbEstado").html(acum);
            //$("#cbEstado_2").html();
            //$("#cbEstado_2").html(acum);
            //$("#cbEstado").html();
            //$("#cbEstado2").html(acum);
        };
        itemsArray();

        window.itemsCiente = function() {
            var acum = "";
            _clienteT.forEach(element => {
                acum += `<option value='${element.id}'>${element.nombre}</option>`;
            });
            return acum;
        };

        window.SelectAnos = function() {
            var option = '<option value="">Todos</option>';
            var actualy = moment().format('YYYY');
            _years.forEach((element, key) => { //${element.id==1?"selected":''}
                option += `<option value="${element.opcion}" ${element.opcion==actualy?"selected":''} >${element.opcion}</option>`;
            });
            $("#year").html();
            $("#year").html(option);
            //return option;
        }
        //SelectAnos();



        //document.getElementById("over").style.display = "block";
        //document.getElementById("upProgressGeneral").style.display = "block";
        var draw = 0;
        const datatable = $('#Tabla_siniestros').DataTable({
            processing: true,
            serverSide: true,
            searching: false,
            lengthChange: false,
            preDrawCallback: function() {
                document.getElementById("over").style.display = "block";
                document.getElementById("upProgressGeneral").style.display = "block";
            },
            initComplete: function() {
                $('.multiselect-ui').multiselect({
                    nonSelectedText: 'Seleccione',
                    numberDisplayed: 1,
                });
            },
            language: {
                url: `${$path}assets/js/espanol.json`
            },
            ajax: {
                url: `${$path}siniestroCorporativo/SiniestroTabla`,
                type: 'GET',
                "data": function(d) {
                    return $.extend({}, d, {
                        "search": $("#txSearch").val(),
                        "finicio": $("#Finicio").val(),
                        "ffin": $("#Ffin").val(),
                        "evento": $("#Tipos").val(),
                        "tipo_tramite": $("#Tramites_Autos").val(),
                        "estatus_siniestro": $("#cbEstado").val(),
                        "estatus_tramite": $("#cbEstado_2").val(),
                        "seguimiento": $("#cbSeguimiento").val(),
                        "etapa": $("#cbEtapa").val(),
                        "Eseguimiento": $("#cbEseguimiento").val(),
                        "year": $("#year").val()
                    });
                }
            },
            drawCallback: function() {
                document.getElementById("over").style.display = "none";
                document.getElementById("upProgressGeneral").style.display = "none";
                //alert('Se actualizo');
                //Getpermisos();
            },
            ordering: false,
            columns: [{
                    data: 'id',
                    visible: false
                },
                {
                    data: 'status_id',
                    width: '150px',
                    orderable: false,
                    render: function(data, type, row) {
                        //console.log(row);
                        //var colorS = color(row.estatusSiniesto);

                        return `
                    <div class="col-md-1 center-aling-items">
                            <div class="card-round" style="background:${row.fecha_terminacion==null?(row.siniestro_color==null?'#8c8787':row.siniestro_color):row.siniestro_color};">
                                <h6 class="text-uppercase fw-bold text-center" style="padding-top:9px;padding-bottom: 9px;font-size: 9px;color: white !important;">${ row.siniestro_estatus }</h6>
                            </div>
                            <div style="text-align: center!important; font-size:10px">
                                <div style="margin-left: 2.5vh;"> Segumiento:</div>
                                <div style="margin-left: 5vh;">${row.SeguimientoOpc==null?'N/A':row.SeguimientoOpc}</div>
                            </div>
                    </div>`
                    }
                },
                {
                    data: 'nombre',
                    orderable: false,
                    render: function(data, type, row) {
                        //, Causa: ${row.TipoCausa==null?'N/A':row.TipoCausa}
                        //<div class="box first" style="padding-left: 15px;"> Reporte cabina: ${row.num_reporte}&nbsp;</div>
                        //console.log('obj',row);
                        return `
                    <div class="row">
                        <div class="col-md-12">
                            <div>
                                <div class="media-body">
                                    <h4 class="media-heading"><strong>Tipo: ${row.TipoNombre}</strong></h4>
                                    <div class="Siniestro-body">
                                        <div class="box first">Póliza: ${row.poliza==null ||row.poliza==''?"N/A":row.poliza}&nbsp; </div>
                                        <div class="box first" style="padding-left: 15px;">Fecha Accidente: ${row.fecha_reporte==null || row.fecha_reporte=="0000-00-00 00:00:00"?'N/A':moment(row.fecha_reporte).format("DD/MM/YYYY")}</div>
                                        <div class="box first" style="padding-left: 15px;">Fecha Fin: ${row.fecha_terminacion==null || row.fecha_terminacion=="0000-00-00 00:00:00"?'N/A':moment(row.fecha_terminacion).format("DD/MM/YYYY")}</div>
                                        <div class="box first" style="padding-left: 15px;"> Núm siniestro: ${row.num_siniestro}&nbsp;</div>
                                        
                                    </div>
                                </div>
                            </div>  
                        </div>
                    </div>`
                    }
                },
                {
                    data: 'nombre',
                    orderable: false,
                    width: '200px',
                    render: function(data, type, row) {
                        //var colorS = Progresovalues(row.parametro, row.estatusSiniesto, row.progreso);
                        var colorS = Colorbarra(row.parametro, row.progreso, row.fecha_reporte, row.fecha_terminacion, row.siniestro_estatus);
                        //<span>${row.parametro+"  "+row.estatusSiniesto+"  "+row.progreso}</span>
                        return `
                    <div class="row">
                        <div class="col-md-12">
                            <div class="progressBar">
                                <div class="progressb" style="width: ${colorS.porcentaje}; background-color: ${colorS.color};" data-row="40%">
                                </div>
                                <span style="font-size:10px">${colorS.mensaje==undefined?'N/A':colorS.mensaje}</span><br/>
                            </div> 
                        </div>
                        <div class="col-md-12" style="font-size:10px; margin-top:35px;">
                                <span><b>Etapa:</b> ${row.etapa==undefined?'N/A':row.etapa}</span><br/>
                                <span><b>Seguimiento Estatus:</b> ${row.estatusSeguimiento==undefined?'N/A':row.estatusSeguimiento}</span>
                        </div>
                    </div>`
                    }
                },
                {
                    data: null,
                    "sClass": "control text-right",
                    "sDefaultContent": '',
                    width: '120px',
                    orderable: false,
                    render: function(data, type, row) {
                        var colorS = Colorbarra(row.parametro, row.progreso, row.fecha_reporte, row.fecha_terminacion, row.siniestro_estatus);
                        return `
                        <div style="float: left;font-size: 20px;" class="text-center"><div style="font-size: 12px;"> Duración</div><div style="height: 30px;width: 30px;background-color: ${colorS.color==undefined?'#e2e2e2':colorS.color};color:white;border-radius: 50%; display: inline-block;">${colorS.dias==undefined?0:colorS.dias}</div><div  style="font-size: 12px;"> Dias </div></div>
                        <div style="text-align: center;">
                            <div class="dropdown">
                                <button class="btn btn-link dropdown-toggle" type="button" id="dp${row.id}" data-toggle="dropdown" aria-haspopup="true" aria-expanded="true" >
                                    <i class="fa fa-ellipsis-v" aria-hidden="true"></i>
                                </button>
                                <ul class="dropdown-menu dropdown-menu-right"  aria-labelledby="dp${row.id}">
                                    <li><a class="bn-bono-view"  style="cursor: pointer;" href="${$path}siniestroCorporativo/editSiniestro/${row.id}"  data-permiso="permiso" data-accion-permiso="Editar">Editar</a></li>
                                </ul>
                            </div>
                        </div>
                    `;
                    }
                },
                {
                    data: 'fecha_reporte',
                    "sClass": "control text-right",
                    visible: false
                },
                {
                    data: 'siniestro_estatus',
                    "sClass": "control text-right",
                    visible: false
                },
                {
                    data: 'tipo_siniestro_id',
                    visible: false
                },
            ],
            order: [
                [0, 'desc']
            ],


        });

        $(document).on('change', '#Tipos', function(e) {
            datatable.draw();
            /* console.log("test", $('#Tipos option:selected').toArray().map(item => item.value).join('|'));
            var optSelect = $('#Tipos option:selected').toArray().map(item => item.value).join('|');
            datatable.columns(9).search('').draw();
            datatable.columns(9).search(optSelect, true, false).draw(); */
        });

        $(document).on('click', '#Excel', function(e) {
            ExportExcel();
        });

        window.ItemsTipo = function() {
            var opt = '';
            _siniestroT.forEach(element => {
                opt += `<option value="${element.id}">${element.nombre}</option>`;
            });
            $("#Tipos").html();
            $("#Tipos").html(opt);
            //return opt;
        }
        ItemsTipo();
        ///inicio select tramites
        window.ItemsTramitesAutos = function() {
            var opt = '<option value="">Todos</option>';
            _TramAutos.forEach(element => {
                opt += `<option value="${element.id}">${element.nombre}</option>`;
            });
            $("#Tramites_Autos").html();
            $("#Tramites_Autos").html(opt);
            //return opt;
        }
        //ItemsTramitesAutos();

        $(document).on('change', '#Tramites_Autos', function(e) {
            datatable.draw();
        });

        window.ItemsEstatusReparacion = function() {
            var opt = '';
            _Estatus_Reparacion.forEach(element => {
                opt += `<option value="${element.nombre}">${element.nombre}</option>`;
            });
            return opt;
        }

        $(document).on('input', '#Tipos_reparacion', function(e) {
            datatable
                .search("")
                .draw();
            datatable
                .columns(e.currentTarget.name)
                .search(e.currentTarget.value)
                .draw();
        });
        /// fin select tramites



        $(document).on('input', '#txSearch', function(e) {
            datatable.draw();
        });

        //evento del combo de estatus tramites
        $(document).on('change', '#cbEstado', function(e) {
            datatable.draw();
            /* datatable
                .columns(1)
                .search(e.currentTarget.value)
                .draw(); */
            /* datatable
                .columns(1)
                .search(e.currentTarget.value)
                .draw(); */
        });

        //evento del ccombo de estatus siniestros
        $(document).on('change', '#cbEstado_2', function(e) {
            datatable.draw();
            /* datatable
                .columns(1)
                .search(e.currentTarget.value)
                .draw();
            datatable
                .columns(7)
                .search(e.currentTarget.value)
                .draw(); */
        });

        $(document).on('change', '#year', function(e) {
            document.getElementById("over").style.display = "block";
            document.getElementById("upProgressGeneral").style.display = "block";
            datatable.draw();
            /* //datatable.ajax.reload();
            datatable
                .columns(12)
                .search(e.currentTarget.value)
                .draw(); */
        });

        $(document).on('input', '#cbEstado2', function(e) {
            datatable.draw();
            /* datatable
                .search("")
                .draw();
            datatable
                .columns(e.currentTarget.name)
                .search(e.currentTarget.value)
                .draw(); */
        });

        //evento del inputdate Fecha inicio
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

        window.color = function(data) {
            var color = "";
            switch (data) {
                case "CONDICIONADO":
                    color = "#FFA301";
                    break;
                case "EN TRAMITE":
                    color = "#149EF7";
                    break;
                case "AVISADO":
                    color = "#e6d81c";
                    break;
                case "LIQUIDADO":
                    color = "#6dca6d";
                    break;
                case "Sin estatus":
                    color = "#B0AEA9";
                    break;
                default:
                    color = "#6dca6d";
                    break;
            }
            return color;
        };

        window.Progresovalues = function(parametro, estado, progreso) {
            var total = parseFloat(parseInt(progreso) / parseInt(parametro));
            var color = {};
            if (estado == "LIQUIDADO" || estado == "FINALIZADO") {
                color = {
                    color: "#472380",
                    porcentaje: "100%",
                    mensaje: 'Se ha liquidado el siniestro'
                };
            } else if (parametro == null) {
                color = {
                    color: "#472380",
                    porcentaje: "0%",
                    mensaje: 'No se tiene ningún indicador relacionado.'
                };
            } else {
                if (total > 0 && total <= 0.40) {
                    color = {
                        color: "#6dca6d",
                        porcentaje: "30%",
                        mensaje: `Han transcurrido ${progreso} dias de los ${parametro} del indicador`
                    };
                }
                if (total > 0.40 && total <= 0.60) {
                    color = {
                        color: "#e8f051",
                        porcentaje: "60%",
                        mensaje: `han transcurrido ${progreso} dias de los${parametro} del indicador`
                    };
                }
                if (total > 0.60 && total < 1) {
                    color = {
                        color: "#e68d10",
                        porcentaje: "85%",
                        mensaje: `Han transcurrido ${progreso} dias de los ${parametro} del indicador`
                    };
                }
                if (total >= 1) {
                    color = {
                        color: "#db311a",
                        porcentaje: "100%",
                        mensaje: `Han transcurrido ${progreso} dias de los ${parametro} del indicador`
                    };
                }
            }

            return color;
        };

        // varioables para el filtro de fechas
        minDateFilter = "";
        maxDateFilter = "";
        label = "";

        //metodo de filtrado por fechas
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


        window.OpenModal = function(data) {
            var datos = JSON.parse($(data).attr("data-row"));
            //var datos= $(data).attr("data-row");
            //console.log("variable", datos);
        };

        window.updateTable = function() {
            document.getElementById("over").style.display = "block";
            document.getElementById("upProgressGeneral").style.display = "block";
            $.ajax({
                type: 'POST',
                url: `${$path}Siniestros/getJSON`,
                dataType: 'json',
                data: {},
                success: function(response) {
                    //document.getElementById("over").style.display = "none";
                    //document.getElementById("upProgressGeneral").style.display = "none";
                    datatable.ajax.reload(null, false);
                    //console.log(response);
                },
                error: function(xhr) {
                    console.log('error', xhr);
                }
            });

        };

        window.reloadTable = function() {
            datatable.ajax.reload(null, false);
        };


        window.getDataHistorial = function(id) {
            $.ajax({
                url: `${$path}Siniestros/seguimiento/2`,
                data: {
                    id: id
                },
                method: 'POST',
                dateType: 'json',
                success: function(response) {
                    window.modalModalSeguimiento.show("Seguimiento de Siniestro", response.data)
                }
            });

        }

        window.ExportExcel = function() {
            //obtnego los registros filtrados
            var arry = [];
            const dta = datatable.rows({
                filter: 'applied'
            }).data();
            const oInci = _.filter(dta, function(it) {
                return it;
            });
            const datasend = oInci.map(item => `'${item.id}'`).join(',');
            $.ajax({
                url: `${$path}Siniestros/postExcel`,
                data: {
                    filtro: datasend
                },
                method: 'POST',
                dateType: 'json',
                success: function(response) {
                    window.open(`${$path}Siniestros/getExcel`, '_blank');
                    //window.modalModalSeguimiento.show("Seguimiento de Siniestro", response.data)
                }
            });
        }

        window.Colorbarra = function(parametro, progreso, fechaI, fechaF, estado) {
            //console.log(`fecha i ${fechaI} | Fecha Fin ${fechaF}`);
            var FI = moment(fechaI, "YYYY-MM-DD");
            var FF = (fechaF == null || fechaF == "0000-00-00 00:00:00") ? moment() : moment(fechaF, "YYYY-MM-DD");
            var days = FF.diff(FI, 'days');
            //console.log("dias", days);
            var color = {};
            var total = parseFloat(parseInt(days) / parseInt(parametro));
            //console.log("Total", total)
            //console.log("parametro", parametro)
            if (estado == "LIQUIDADO" || estado == "FINALIZADO" || estado == "FINIQUITADO") {
                color = {
                    color: Colores(total),
                    porcentaje: "100%",
                    mensaje: `Se ha liquidado el siniestro en ${days} dias`,
                    dias: days
                };
            } else if (estado == 'RECHAZADO') {
                color = {
                    color: "#472380",
                    porcentaje: "100%",
                    mensaje: 'Se ha rechazado el siniestro',
                    dias: days
                };
            } else if (parametro == null) {
                color = {
                    color: "#472380",
                    porcentaje: "0%",
                    mensaje: 'No se tiene ningún indicador relacionado.',
                    dias: isNaN(days) ? 0 : days

                };
            } else {
                if (total >= 0 && total <= 0.40) {
                    color = {
                        color: Colores(total),
                        porcentaje: "30%",
                        mensaje: `Han transcurrido ${days} dias de los ${parametro} del indicador`,
                        dias: days
                    };
                }
                if (total > 0.40 && total <= 0.60) {
                    color = {
                        color: Colores(total),
                        porcentaje: "60%",
                        mensaje: `han transcurrido ${days} dias de los${parametro} del indicador`,
                        dias: days
                    };
                }
                if (total > 0.60 && total < 1) {
                    color = {
                        color: Colores(total),
                        porcentaje: "85%",
                        mensaje: `Han transcurrido ${days} dias de los ${parametro} del indicador`,
                        dias: days
                    };
                }
                if (total >= 1) {
                    color = {
                        color: Colores(total),
                        porcentaje: "100%",
                        mensaje: `Han transcurrido ${days} dias de los ${parametro} del indicador`,
                        dias: days
                    };
                }
            }
            //console.log("all", color)
            return color;

        }
        window.Colores = function(total) {
            var color = '';
            if (total >= 0 && total <= 0.40) {
                color = "#6dca6d";
            }
            if (total > 0.40 && total <= 0.60) {
                color = "#e8f051";
            }
            if (total > 0.60 && total < 1) {
                color = "#e68d10";
            }
            if (total >= 1) {
                color = "#db311a";
            }
            return color;
        }


        ///nuevos metodos de la actualizacion
        window.SeguimientoSiniestro = function(id, id_tram, tipo_tram, est_tram) {
            $('#id_siniestro_c_t').val(id);
            $('#id_tramite_c_t').val(id_tram);
            $('#id_tipotram_c_t').val(tipo_tram);
            $('#id_esttram_c_t').val(est_tram);
            $('#modal_seguimiento_add').modal('show');
        }

        ///cambiar estatus
        window.ChangeStatus = function(id, orden, idSiniestro) {
            const _tablaR = datatable.rows().data();
            const oIncid = _.find(_tablaR, function(it) {
                return it.id == idSiniestro;
            });
            //console.log("oinc", oIncid);
            var valores = '<select class="form-control" name="sweet_s" id="sweet_s"><option value="0">Seleccione una opción</option>';
            _estatus.forEach((element, key) => { //${id==element.id||orden>=element.orden?'disabled':''}
                //console.log(oIncid["estatusSiniesto"]+"  "+element.nombre);
                var estatus_t = oIncid["siniestro_estatus"] != null ? oIncid["siniestro_estatus"] : 'ACTIVO';
                valores += `<option value="${element.id}" ${estatus_t.toUpperCase()==element.nombre?'disabled':''} >${element.nombre}</option>`;

            });
            valores += '</select>';
            var IsFechaFin = `<div class="col-lg-12 hidden" id="cont_val">
                                <div class="form-group">
                                    <label for="exampleInputEmail1">Fecha fin</label>
                                    <input type="date" class="form-control" id='fecha_fin' min=${moment(oIncid["inicio_ajuste"]).format('YYYY-MM-DD')} max=${moment().format('YYYY-MM-DD')}>
                                </div>
                            </div>`;
            var contenido = ` <div class="row">
                        <div class="col-lg-12">
                            <div class="form-group">
                                <label for="exampleInputEmail1">Estatus</label>
                               ${valores}
                            </div>
                        </div>
                        ${_FechaFin?IsFechaFin:''}
                        <div class="col-lg-12">
                            <div class="form-group">
                                <label for="exampleInputEmail1">Comentario</label>
                                <textarea onkeyup="javascript:this.value=this.value.toUpperCase();" name="comentario_est" id="comentario_est" class="form-control"></textarea>
                            </div>
                        </div>
                    </div>`;
            swal({
                title: "¿Está seguro de cambiar el estatus del siniestro?",
                text: "Una vez eliminado, ¡no podrá recuperar el elemento!",
                icon: "warning",
                //content:"<select><option>TEST</option></select>",
                buttons: ["Cancelar", "Aceptar"],
            }).then((value) => {
                var val = $("#sweet_s").val();
                var com = $("#comentario_est").val();
                var fecha = $("#fecha_fin").val();
                if (value) {
                    if (val != 0 && com != '') {
                        document.getElementById("over").style.display = "block";
                        document.getElementById("upProgressGeneral").style.display = "block";
                        $.ajax({
                            type: 'POST',
                            url: `${$path}Siniestros/ChangeEstatus`,
                            data: {
                                "estatus": val,
                                "comentario": com,
                                "id_siniestro": idSiniestro,
                                "fecha_fin": fecha
                            },
                            success: function(data) {
                                datatable.ajax.reload(null, false);
                                toastr.success("Se cambio el estatus");

                            },
                            error: function(data) {

                            }
                        });

                    } else {
                        toastr.error("Seleccione un status");
                        ChangeStatus();
                    }
                    //alert(value);
                }
            });

            $(".swal-text").html('');
            $(".swal-text").html(contenido);
            /*  $('#modal_status').modal('show'); */
            ///swal-text
        }

        ///metodos para mostar la fecha fin
        $(document).on('input', '#sweet_s', function(e) {
            //console.log('changeStatus', e.currentTarget.value);
            var id = e.currentTarget.value;
            ActualizaValores(id);
        });

        window.ActualizaValores = function(id, data) {
            var contenido = '';
            const isVal = _.find(_estatus, function(it) {
                return it.id == id;
            });
            if (isVal.valores == '1' && _FechaFin) {
                $('#cont_val').removeClass("hidden");
            } else {
                $('#cont_val').addClass("hidden");
            }
        }

        //funcion para editar un registro
        window.Ver = function(id) {
            $("#tab_home").addClass("active"); //in active
            $("#home").addClass("in active");
            $("#tab_Seguimiento").removeClass("active");
            $("#tab_tramite").removeClass("active");
            $("#seguimiento_G").removeClass("in active");
            const _tablaR = datatable.rows().data();
            const oIncid = _.find(_tablaR, function(it) {
                return it.id == id;
            });
            //console.log("test", oIncid);
            //$("#menu1").removeClass("in active");


            //metdo para obtner los tramites que estan activos
            /* $.ajax({
                type: 'POST',
                url: `${$path}Autos/getAllTramites`,
                data: {
                    "id": id,
                    //"Tipo":1
                },
                success: async function (data) {
                    //console.log("data",data.data);
                    var seguimiento=data.data.seguimiento;
                    //data normal
                    var dataG=data.data.siniestro[0];
                    Object.keys(dataG).forEach(key =>{
                        $(`#${key}`).html(dataG[key]);
                        //console.log(key);
                    });
                    //datos generales
                    var dataP=JSON.parse(data.data.siniestro[0].data_poliza);
                    Object.keys(dataP).forEach(key =>{
                            if(key=='FDesde'||key=='FHasta'){
                                $(`#${key}`).html(moment(dataP[key]).format("DD/MM/YYYY"));
                            }else if(key=='AgenteNombre'){
                                $(`#${key}`).html('['+dataP['CAgente']+'] '+dataP[key]);
                            }
                            else{
                                $(`#${key}`).html(dataP[key]);
                            }
                    
                        });
                    //data del asegurado
                    var dataC=JSON.parse(data.data.siniestro[0].complemento_json);
                    var dataCC=dataC['cordinador'];
                    Object.keys(dataCC).forEach(key =>{
                        
                        $(`#${key}`).html(dataCC[key]);
                       
                    });
                    await SeguimientoGeneral(seguimiento);
                    await $('#modal_gmm').modal('show');
                    //datatable.ajax.reload();
                },
                error: function (data) {

                }
            }); */
            $('#modal_gmm').modal('show');


            return;
        }

        //funcion para nuevo comentario
        $("#form_add_comentario").validate({
            rules: {
                comentario_s_t: {
                    required: true,
                }
            },
            messages: {
                comentario_s_t: {
                    required: "Ingrese un comentario.",
                }
            },
            errorPlacement: function(error, element) {
                if (error) {
                    $(`#e_${element[0].id}`).append(error);
                } else {
                    error.insertAfter(element);
                }
            },
            submitHandler: function(form) {
                //document.getElementById("over").style.display = "block";
                //document.getElementById("upProgressGeneral").style.display = "block";
                $.ajax({
                    url: form.action,
                    type: form.method,
                    data: $(form).serialize(),
                    success: function(response) {
                        if (response.code == 200) {
                            toastr.success("Se guardo con éxito.");
                            document.getElementById('form_add_comentario').reset();
                            $('#modal_seguimiento_add').modal('hide');
                            //datatable.ajax.reload();
                        } else {
                            toastr.error(response.message);
                        }
                    }
                });
            }
        });


        //nuevo tramite
        window.openTramite = function(id) {
            $("#id_siniestro").val(id);
            $("#id_tramite").val('');
            $("#form_add_tramite").attr('action', $path + 'Siniestros/postTramite');
            $("#tipo_tramite_select").val('');
            $("#contenido_tramite").html('');
            $("#inicio_tramite").removeClass('hidden');
            $("#salto_tramite").removeClass('hidden');
            $("#contenido_tramite").html("<br> NO SE HA SELECCIONADO NINGÚN TRÁMITE");
            $('#isEdit').val('1');
            $('#modal_new_tramite').modal('show');
            //isEdit = false;
        }
        //obtner la partialview
        $(document).on('change', '#tipo_tramite_select', function(e) {
            //console.log("test",$('#Tipos option:selected').toArray().map(item => item.value).join('|'));
            var optSelect = $('#tipo_tramite_select').val();
            var id_siniestro = $('#id_siniestro').val();
            //document.getElementById("over").style.display = "block";
            //document.getElementById("upProgressGeneral").style.display = "block";
            if (optSelect != "") {
                $.ajax({
                    type: 'POST',
                    url: `${$path}Siniestros/getpartialTramite`,
                    data: {
                        tipotramite: optSelect,
                        id_siniestro: id_siniestro
                    },
                    success: function(response) {
                        //console.log(response);
                        $("#contenido_tramite").html('');
                        $("#contenido_tramite").html(response);
                        //los tipod de dcoumentos que se pueden subir al tipo de tramite sleccioando
                        DocumentosTramite(optSelect);
                        //validaciones de los nuevos tramites
                        Validacion1('');
                        Validacion2('');
                        //$('#modal_new_tramite').modal('handleUpdate');
                        $("#ccomentario").removeClass("hidden");
                        $('#modal_new_tramite').modal('handleUpdate');
                        //document.getElementById("over").style.display = "none";
                        //document.getElementById("upProgressGeneral").style.display = "none";

                    }
                });
            } else {
                $("#contenido_tramite").html('');
                $("#contenido_tramite").html("<br> NO SE HA SELECCIONADO NINGÚN TRÁMITE");
                //document.getElementById("over").style.display = "none";
                //document.getElementById("upProgressGeneral").style.display = "none";
            }
        });

        //editar tramite
        window.editTramite = function(id, tipo, siniestro) {
            $('#isEdit').val('1');
            $.ajax({
                type: 'POST',
                url: `${$path}Siniestros/getpartialTramite`,
                data: {
                    tipotramite: tipo,
                    id_tramite: id
                },
                success: function(response) {
                    //console.log(response);
                    $("#id_siniestro").val(siniestro);
                    $("#id_tramite").val(id);
                    $("#contenido_tramite").html('');
                    $("#contenido_tramite").html(response);
                    $("#salto_tramite").addClass('hidden');
                    $("#inicio_tramite").addClass('hidden');
                    $("#ccomentario").removeClass("hidden");
                    //validaciones de los nuevos tramites
                    var valor = $("#Estatus_Unidad").val();
                    var valor2 = $("#Resultado_Valuacion").val();
                    //console.log("valores", `valor1--> ${valor}, valor2--> ${valor2}`);
                    Validacion1(valor);
                    Validacion2(valor2);
                    DocumentosTramite(tipo.toString());
                    $('#modal_new_tramite').modal('show');
                    $('#modal_new_tramite').modal('handleUpdate');
                }
            });
        }

        //funcion para guardar los trámites
        $("#form_add_tramite").validate({
            rules: {
                fecha_inicio: {
                    required: true,
                }
            },
            messages: {
                fecha_inicio: {
                    required: "Seleccione una fecha.",
                },
            },
            errorPlacement: function(error, element) {
                if (error) {
                    $(`#e_${element[0].id}`).append(error);
                } else {
                    error.insertAfter(element);
                }
            },
            submitHandler: function(form) {
                var formData = new FormData();
                $('.field').each(function(index, value) {
                    //console.log('campo',value.name);
                    formData.append(value.name, $(`#${value.name}`).val());
                    //$(`#${value.name}`).attr('disabled', 'disabled');
                });
                $('.fileD').each(function(index, value) {
                    //console.log('file',$(`#${value.name}`).prop('files')[0]);
                    /* if($(`#${value.name}`)[0].files.length!=0){
                        formData.append(value.name, $(`#${value.name}`).prop('files')[0]);
                    } */
                    const DocFiles = $(`#${value.name}`).prop('files');
                    for (var i = 0; i < DocFiles.length; i++) {
                        formData.append(DocFiles[i].name + '_' + `(${value.name})`, DocFiles[i]);
                        //console.log(`${value.name+'_'+i}`,DocFiles[i]);
                        //formData.append(value.name+'_'+(i+1),DocFiles[i]);
                    }

                });
                document.getElementById("over").style.display = "block";
                document.getElementById("upProgressGeneral").style.display = "block";
                $('#isEdit').val('');
                $.ajax({
                    url: form.action,
                    type: form.method,
                    processData: false,
                    contentType: false,
                    data: formData,
                    //data: $(form).serialize(),
                    success: async function(response) {
                        if (response.code == 200) {
                            await $('#modal_new_tramite').modal('hide');
                            await toastr.success("Se guardo con éxito.");
                            //document.getElementById('form_add_comentario').reset();

                            await datatable.ajax.reload(null, false);

                            //console.log("draw",draw);
                            //document.getElementById("over").style.display = "none";
                            //document.getElementById("upProgressGeneral").style.display = "none";
                            //datatable.ajax.reload();
                        } else {
                            toastr.error(response.message);
                        }
                    }
                });
            }
        });

        ///cambiar estatus
        window.ChangeStatusTramite = function(id, idSiniestro, idtramite, fecha_inicio, tipo_tram) {
            //console.log("fechatramite" + fecha_inicio, moment(fecha_inicio).format('YYYY-MM-DD'));
            var valores = '<select class="form-control" name="sweet_s" id="sweet_s"><option value="0">Seleccione una opción</option>';
            _estatus.forEach((element, key) => { //${id==element.id||orden>=element.orden?'disabled':''}
                //console.log(oIncid["estatusSiniesto"]+"  "+element.nombre);
                valores += `<option value="${element.id}" ${id==element.id?'disabled':''} >${element.nombre}</option>`;

            });
            valores += '</select>';
            var IsFechaFin = `<div class="col-lg-12 hidden" id="cont_val">
                                <div class="form-group">
                                    <label for="exampleInputEmail1">Fecha fin</label>
                                    <input type="date" class="form-control" id='fecha_fin' min=${moment(fecha_inicio).format('YYYY-MM-DD')} max=${moment().format('YYYY-MM-DD')}>
                                </div>
                            </div>`;
            var contenido = ` <div class="row">
                        <div class="col-lg-12">
                            <div class="form-group">
                                <label for="exampleInputEmail1">Estatus</label>
                               ${valores}
                            </div>
                        </div>
                        ${_FechaFin?IsFechaFin:''}
                        <div class="col-lg-12">
                            <div class="form-group">
                                <label for="exampleInputEmail1">Comentario</label>
                                <textarea onkeyup="javascript:this.value=this.value.toUpperCase();" name="comentario_est" id="comentario_est" class="form-control"></textarea>
                            </div>
                        </div>
                    </div>`;
            swal({
                title: "¿Está seguro de cambiar el estatus del trámite?",
                text: "Una vez eliminado, ¡no podrá recuperar el elemento!",
                icon: "warning",
                //content:"<select><option>TEST</option></select>",
                buttons: ["Cancelar", "Aceptar"],
            }).then((value) => {
                var val = $("#sweet_s").val();
                var com = $("#comentario_est").val();
                var fecha = $("#fecha_fin").val();
                if (value) {
                    if (val != 0 && com != '') {
                        document.getElementById("over").style.display = "block";
                        document.getElementById("upProgressGeneral").style.display = "block";
                        $.ajax({
                            type: 'POST',
                            url: `${$path}Siniestros/ChangeEstatusTramite`,
                            data: {
                                "estatus": val,
                                "comentario": com,
                                "id_siniestro": idSiniestro,
                                "fecha_fin": fecha,
                                "id_tramite": idtramite,
                                "tipo_tram": tipo_tram
                            },
                            success: function(data) {
                                datatable.ajax.reload(null, false);
                                toastr.success("Se cambio el estatus");

                            },
                            error: function(data) {

                            }
                        });

                    } else {
                        toastr.error("Seleccione un status");
                        ChangeStatus();
                    }
                    //alert(value);
                }
            });

            $(".swal-text").html('');
            $(".swal-text").html(contenido);
            /*  $('#modal_status').modal('show'); */
            ///swal-text
        }

        window.Reingreso = function(id) {
            //alert('el id es '+ id);
            $("#id_siniestro").val(id);
            $("#id_tramite").val('');
            $("#tipo_tramite_select").val('');
            $("#contenido_tramite").html('');
            $("#form_add_tramite").attr('action', $path + 'Siniestros/Reingreso');
            $("#inicio_tramite").removeClass('hidden');
            $("#salto_tramite").removeClass('hidden');
            $("#modalLabeltramite").text('Nuevo Trámite de Reingreso');
            $("#contenido_tramite").html("<br> NO SE HA SELECCIONADO NINGÚN TRÁMITE");
            $('#modal_new_tramite').modal('show');

        }


        $(document).on("input", ".numeric", function() {
            this.value = this.value.replace(/[^0-9.]/g, '').replace(/(\..*?)\..*/g, '$1');
        });

        //accion que permite generar los input de carga de documentos
        window.DocumentosTramite = function(id) {
            //console.log("id", id);
            const _array = _Documents;
            const newData = _array.filter((item, index) => item.tramite === id);
            //console.log("filter", newData);
            var AcumDocumentos = '';
            newData.forEach((element, key) => {
                var name = element.documento_nom;
                //console.log("fin",element);
                AcumDocumentos += `<div class="col-lg-4">
                            <div class="form-group">
                                <label for="exampleInputEmail1">${element.documento_nom}</label>
                                <input type="file" class="form-control fileD" id="${string_to_slug(name)}" name="${string_to_slug(name)}" placeholder="${element.documento_nom}" onchange="listadoc('${string_to_slug(name)}')" multiple />
                                <div id="${string_to_slug(name)}_lista"></div>
                                </div>
                        </div>`;
            });
            if (AcumDocumentos == '') {
                AcumDocumentos = `<div class="col-lg-12">
                            <div class="text-center">
                                No se puenden subir Archivos
                            </div>
                        </div>`;
            }
            $("#bodyDocumentos").html('');
            $("#bodyDocumentos").html(AcumDocumentos);
        }

        window.string_to_slug = function(str) {
            str = str.replace(/^\s+|\s+$/g, ''); // trim
            str = str.toLowerCase();

            // remove accents, swap ñ for n, etc
            var from = "àáäâèéëêìíïîòóöôùúüûñç·/_,:;";
            var to = "aaaaeeeeiiiioooouuuunc------";
            for (var i = 0, l = from.length; i < l; i++) {
                str = str.replace(new RegExp(from.charAt(i), 'g'), to.charAt(i));
            }

            str = str.replace(/[^a-z0-9 -]/g, '') // remove invalid chars
                .replace(/\s+/g, '_') // collapse whitespace and replace by -
                .replace(/-+/g, '_'); // collapse dashes

            return str;
        }

        //cmapo que servira como las nuevas cosas
        $(document).on("change", "#Estatus_Unidad", function(e) {
            var valor = $("#Estatus_Unidad").val();
            Validacion1(valor);
            Validacion2('');
        });

        //segunda validacion
        $(document).on("change", "#Resultado_Valuacion", function(e) {
            var valor = $("#Resultado_Valuacion").val();
            Validacion2(valor);

        });

        window.Validacion1 = function(valor) {
            if (valor == 'NO APLICA' || valor == '') {
                $('.validacion_1').each(function(index, value) {
                    $(`#${value.name}`).attr('disabled', 'disabled');
                });
            } else {
                $('.validacion_1').each(function(index, value) {
                    $(`#${value.name}`).removeAttr('disabled');
                });
            }
        }


        window.Validacion2 = function(valor) {
            if (valor != 'REPARACION AUTORIZADA' || valor == '') {
                $('.validacion_2').each(function(index, value) {
                    $(`#${value.name}`).attr('disabled', 'disabled');
                    //$(`#${value.name}`).val('');
                    $('#Fecha_Autorizacion_Reparacion').val("");
                });
            } else {
                $('.validacion_2').each(function(index, value) {
                    $(`#${value.name}`).removeAttr('disabled');
                });
            }
        }

        window.jQuery(document).on('click', '.js-preview-item', function(e) {
            e.preventDefault();
            //$("#document_des").text();
            var id_doc = $(e.currentTarget).data("id");
            //console.log("id_Doc",$(e.currentTarget).data("id"));
            //alert(id_doc);
            $('#frame_doc').attr('src', `https://docs.google.com/viewer?srcid=${id_doc}&pid=explorer&efh=false&a=v&chrome=false&embedded=true`);
            $('#frame_dow').attr('href', `https://drive.google.com/uc?id=${id_doc}&export=download`);
            $('#mdPrevies').modal('show');
            //preview.show(e.currentTarget.href, e.currentTarget.innerHTML);
        });

        //Siniestros
        //metodos para actualizar los documentos
        var arraDocs = [];
        window.OpenModalDocs = function(id) {
            $.ajax({
                type: 'POST',
                url: `${$path}Siniestros/seguimiento/2`,
                data: {
                    "id": id,
                },
                success: async function(data) {
                    //console.log(data.data.tramites);
                    var html = '<option value="0_0">Seleccione uno </option>';
                    arraDocs = data.data.Tramites;
                    arraDocs.forEach((element, key) => {
                        html += `
                                <option value="${element.info.id}_${element.info.tipo_tramite}">${element.info.tram_nom}  |${moment(element.info.fecha_inicio).format("DD/MM/YYYY")}-${element.info.fecha_fin==null?'Activo':moment(element.info.fecha_inicio).format("DD/MM/YYYY")}</option>
                            `;
                    });
                    if (html == '') {
                        html += ``;
                    }
                    $("#doc_anexos").html('');
                    $("#doc_anexos").html('<div style="padding-left:20px"> NO HAY ARCHIVOS</div>');
                    $("#doc_cargados").html('');
                    $("#doc_cargados").html('<div style="padding-left:20px"> NO HAY ARCHIVOS</div>');
                    await $("#tram_doc").html('');
                    await $("#tram_doc").html(html);
                    await $('#modal_docs_admin').modal('show');
                },
                error: function(data) {}
            });
        }

        window.documentos_tram = function(data, opt) {
            var elm = '';
            data.forEach(elementdc => {
                //
                elm += `
                    <div class="col-md-3" id='doc_${elementdc.file_id}'>
                        <div class="form-group" style='text-align:center;white-space: nowrap;text-overflow: ellipsis;overflow: hidden;'>
                            ${opt==null?'':`<img height='15' width='15' src='https://dl.dropboxusercontent.com/s/678nxrrg13fl745/trash.svg?dl=0' style='cursor:pointer;' onclick="delete_doc('${elementdc.file_id}','doc_${elementdc.file_id}')" /><br/>`}
                            <a  data-nombre='${elementdc.nombre}' style='cursor:pointer;' data-id='${elementdc.file_id}' class='js-preview-item' >${elementdc.nombre}</a>
                        </div>
                </div>
                `;
            });
            if (elm == '') {
                elm += `<div style="padding-left:20px"> NO HAY ARCHIVOS</div>`;
            }
            return elm;
        }


        $(document).on('change', '#tram_doc', function(e) {
            var fullval = $("#tram_doc").val().split('_');
            if (fullval[0] != '0') {
                var docsup = DocumentosTramiteAdmin(fullval[1]);
                //console.log("almDat",arraDocs);
                FindDocsTramite(parseInt(fullval[0]));
                $("#doc_anexos").html('');
                $("#doc_anexos").html(docsup);
            } else {
                $("#doc_anexos").html('');
                $("#doc_anexos").html('<div style="padding-left:20px"> NO HAY ARCHIVOS</div>');
                $("#doc_cargados").html('');
                $("#doc_cargados").html('<div style="padding-left:20px"> NO HAY ARCHIVOS</div>');
                $("#btn_save_doc").addClass('hide');
            }
        });

        window.DocumentosTramiteAdmin = function(id) {
            //console.log("id",id);
            const _array = _Documents;
            const newData = _array.filter((item, index) => item.tramite === id);
            //console.log("filter", newData);
            var AcumDocumentos = '';
            newData.forEach((element, key) => {
                var name = element.documento_nom;
                //console.log("fin",element);
                AcumDocumentos += `<div class="col-lg-4">
                            <div class="form-group">
                                <label for="exampleInputEmail1">${element.documento_nom}</label>
                                <input type="file" class="form-control fileD" id="${string_to_slug(name)}" name="${string_to_slug(name)}" placeholder="${element.documento_nom}" onchange="listadoc('${string_to_slug(name)}','ADM')" multiple />
                                <div id="${string_to_slug(name)}_lista_doc"></div>
                                </div>
                        </div>`;
            });
            if (AcumDocumentos == '') {
                AcumDocumentos = `
                            <div style="padding-left:20px">
                                No se puenden subir Archivos
                            </div>`;
                $("#btn_save_doc").addClass('hide');
            } else {
                $("#btn_save_doc").removeClass('hide');
            }
            return AcumDocumentos;
        }

        window.FindDocsTramite = function(id) {
            var found = arraDocs.find(element => element.info.id === id);
            var docs = documentos_tram(found.documentos, 'test');
            $("#doc_cargados").html('');
            $("#doc_cargados").html(docs);
            //console.log("found",found);
        }

        window.delete_doc = function(id, id_elemento) {
            swal({
                title: "¿Está seguro de que quiere eliminar el documento seleccionado?",
                text: "Una vez eliminado, ¡no podrá recuperar el elemento!",
                icon: "warning",
                buttons: ["Cancelar", "Aceptar"],
            }).then((value) => {
                if (value) {
                    $.ajax({
                        type: 'POST',
                        url: `${$path}Siniestros/delete_documento`,
                        data: {
                            "id_doc": id,
                        },
                        success: function(data) {
                            //elemino el elemento
                            $(`#${id_elemento}`).remove();
                            toastr.success("Accion realizada con éxito.");
                            //datatable.ajax.reload();
                        },
                        error: function(data) {

                        }
                    });
                }
            });
        }

        //form_add_update_doc
        ///agregar nuevo tramite
        $("#form_add_update_doc").validate({
            rules: {
                comentario_s: {
                    required: true,
                }
            },
            messages: {
                comentario_s: {
                    required: "Ingrese un comentario.",
                }
            },
            errorPlacement: function(error, element) {
                if (error) {
                    $(`#e_${element[0].id}`).append(error);
                } else {
                    error.insertAfter(element);
                }
            },
            submitHandler: function(form) {
                //inica el proceso del tramite 
                document.getElementById("over").style.display = "block";
                document.getElementById("upProgressGeneral").style.display = "block";

                var formData = new FormData();
                var fullval = $("#tram_doc").val().split('_');
                //console.log(fullval);
                //id_siniestro_t
                formData.append('id', fullval[0]);
                $('.fileD').each(function(index, value) {
                    const DocFiles = $(`#${value.name}`).prop('files');
                    for (var i = 0; i < DocFiles.length; i++) {
                        //console.log(`${value.name+'_'+i}`,DocFiles[i]);
                        //formData.append(value.name+'_'+(i+1),DocFiles[i]);
                        formData.append(DocFiles[i].name + '_' + `(${value.name})`, DocFiles[i]);
                    }
                });
                $.ajax({
                    url: form.action,
                    type: form.method,
                    processData: false,
                    contentType: false,
                    //dataType: 'json',
                    //contentType: 'multipart/form-data',
                    data: formData,
                    success: function(response) {
                        if (response.code == 200) {
                            toastr.success("Se guardo con éxito.");
                            $('#modal_docs_admin').modal('hide');
                            //document.getElementById('form_tramite').reset();
                            //datatable.ajax.reload();
                        } else {
                            toastr.error(response.message);
                        }
                        //termina la carga del tramite
                        document.getElementById("over").style.display = "none";
                        document.getElementById("upProgressGeneral").style.display = "none";
                    }
                });

            }
        });

        ///el cmabio en el input del tramite de reparacion
        $(document).on('blur', '#Monto_Iva', function(e) {
            Calculate();
        });

        window.Calculate = function() {
            var iniunidad = parseFloat($("#valor_unidad").data('valor-unidad').replace(/,/g, ''));
            var fullval = parseFloat(($("#Monto_Iva").val()).replace(/,/g, ''));
            var valor_unidad = parseFloat(($("#valor_unidad").data('valor-unidad')).replace(/,/g, ''));
            if (fullval > 0 && valor_unidad > 0) {
                var porcentaje = (fullval * 100) / valor_unidad;
                if ($("#validateFormula").is(":checked")) {
                    //alert("se aplica la formula")
                    $("#Porcentaje_Danos").val(porcentaje.toFixed(2));
                } else {
                    //alert("No se aplica la formula")
                }
            }
        }

        //sacar el iva del traspaso
        $(document).on('change', '#Transmision_Propiedad', function(e) {
            var val = parseFloat($("#Transmision_Propiedad").val());
            //console.log("testIva", val * 0.16);
            $("#IVA_Tras_Propiedad").val(val * 0.16);

        });


        //onchange para el precio Neto
        $(document).on('blur', '.Neto', function(e) {
            var iva_tras = parseFloat($("#IVA_Tras_Propiedad").val());
            var valor_unidad = parseFloat($("#Valor_Unidad").val());
            var deducible = parseFloat($("#Deducible").val());
            var prima_des = parseFloat($("#Prima_Descontada").val());
            var Neto = (valor_unidad - deducible - prima_des) + iva_tras;
            $("#Total_Neto").val(Neto);

        });

        //delimitador de craga de documentos
        var error = [];
        const MAXIMO_TAMANIO_BYTES = 14000000;
        window.listadoc = function(id, tipo = null) {
            error = [];
            const DocFiles = $(`#${id}`).prop('files');
            //console.log(DocFiles.length);
            var content = '<ul style="padding-left:20px;">';
            for (var i = 0; i < DocFiles.length; i++) {
                //console.log(`doc`,DocFiles[i]);
                if (DocFiles[i].size > MAXIMO_TAMANIO_BYTES) {
                    error.push(DocFiles[i].name);
                    content += `<li style="color:red;">${DocFiles[i].name}</li>`;
                } else {
                    content += `<li>${DocFiles[i].name}</li>`;
                }

            }
            content += '</ul>';
            var boton = tipo == null ? `#btn_save` : `#btn_save_doc`;
            var lista = tipo == null ? `#${id}_lista` : `#${id}_lista_doc`;
            if (error.length > 0) {
                swal({
                    title: "Algunos archivos exceden el limite de 14 MB",
                    text: "Suba archivos de menor tamaño.",
                    icon: "warning",
                    button: {
                        text: "Aceptar",
                    },
                });
                $(boton).attr("disabled", true);
            } else {
                $(boton).removeAttr("disabled");
                //alert("hoy juegas");
            }
            $(lista).html('');
            $(lista).html(content);
            $('#modal_tramite').modal('handleUpdate');
        }

        //Nuevo metodo
        $(document).on('change', '#Fecha_Valuacion', function(e) {
            var val_r = $("#Fecha_Valuacion").val();
            $("#Fecha_Autorizacion_Reparacion").val(val_r);

        });

        //Saber si el modal se esta cerrando
        //let closeM = false;

        $('#modal_new_tramite').on('hide.bs.modal', function(e) {
            if ($('#isEdit').val() != '') {
                e.preventDefault();
                e.stopImmediatePropagation();
                swal({
                    title: "¿Está seguro de cerrar la pestaña?",
                    text: "Una vez cerrado, ¡no podrá recuperar la informacion llenada!",
                    icon: "warning",
                    buttons: ["Cancelar", "Aceptar"],
                }).then((value) => {
                    if (value) {
                        //isEdit = false;
                        $('#isEdit').val('');
                        $('#modal_new_tramite').modal('hide');
                    }
                });
                return false;
            }
        });


        window.SeguiminetoOpc = function() {
            var opt = '';
            var opt = '<option value="">Todos</option><option value="N/A">N/A</option>';
            _seguimientoE.forEach(element => {
                opt += `<option value="${element.id}">${element.opcion}</option>`;
            });
            $("#cbSeguimiento").html();
            $("#cbSeguimiento").html(opt);
            //return opt;
        }
        SeguiminetoOpc();

        $(document).on('change', '#cbSeguimiento', function(e) {
            var id = $("#cbSeguimiento").val();
            var Valid = $("#cbEtapa").val();
            //Reset all selects
            Etapas(id, "");
            EstatusTram(id, "");
            Etapas(id, Valid);
            datatable.draw();
        });


        //Filtros nuevos
        window.Etapas = function(id, selected) {
            var opt = '<option value="">Todos</option>';
            const newData = _Etapa.filter((item, index) => item.id_seguimiento === id);
            //console.log("newData",newData)
            newData.forEach((element, key) => {
                opt += `<option value="${element.id}" ${selected == element.id ? 'selected' : ''}>${element.nombre}</option>`;
            });
            $("#cbEtapa").html('');
            $("#cbEtapa").html(opt);
        }

        window.EstatusTram = function(id, selected) {
            var opt = '<option value="">Todos</option>';
            //console.log("tramite", _EstatusTram)
            //console.log("icTT", selected)
            const newData = _EstatusTram.filter((item, index) => item.id_etapa === id);
            //console.log("newData", newData)
            newData.forEach((element, key) => {
                opt += `<option value="${element.id}" ${selected == element.id ? 'selected' : ''}>${element.nombre}</option>`;
            });
            $("#cbEseguimiento").html('');
            $("#cbEseguimiento").html(opt);
        }


        /* $(document).on("change", "#cbSeguimiento", function() {
            var id = $("#cbSeguimiento").val();
            var Valid = $("#cbEtapa").val();
            //Reset all selects
            Etapas(id, "");
            EstatusTram(id, "");
            Etapas(id, Valid);
            //$('#etapa_id').html('');
        }); */



        $(document).on("change", "#cbEtapa", function() {
            var id = $("#cbEtapa").val();
            var Valid = $("#cbEseguimiento").val();
            EstatusTram(id, Valid);
            datatable.draw();
        });

        $(document).on("change", "#cbEseguimiento", function() {
            datatable.draw();
        });



    });
</script>