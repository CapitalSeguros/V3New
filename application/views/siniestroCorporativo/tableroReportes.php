<script src="https://code.jquery.com/jquery-3.3.1.min.js"></script>
<link rel="preconnect" href="https://fonts.googleapis.com">
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
<link href="https://fonts.googleapis.com/css2?family=Montserrat:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&family=Ubuntu+Condensed&family=Ubuntu:wght@300;400&display=swap" rel="stylesheet">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.5.0/css/font-awesome.css" integrity="sha512-EaaldggZt4DPKMYBa143vxXQqLq5LE29DG/0OoVenoyxDrAScYrcYcHIuxYO9YNTIQMgD8c8gIUU8FQw7WpXSQ==" crossorigin="anonymous" referrerpolicy="no-referrer" />
<style>
    .form-inline .custom-select,
    .form-inline .input-group {
        width: auto
    }

    .btn-toolbar .input-group {
        width: auto
    }

    .input-group {
        position: relative;
        display: -ms-flexbox;
        display: flex;
        -ms-flex-wrap: wrap;
        flex-wrap: wrap;
        -ms-flex-align: stretch;
        align-items: stretch;
        width: 100%
    }

    .input-group>.custom-file,
    .input-group>.custom-select,
    .input-group>.form-control {
        position: relative;
        -ms-flex: 1 1 auto;
        flex: 1 1 auto;
        width: 1%;
        margin-bottom: 0
    }

    .input-group>.custom-file+.custom-file,
    .input-group>.custom-file+.custom-select,
    .input-group>.custom-file+.form-control,
    .input-group>.custom-select+.custom-file,
    .input-group>.custom-select+.custom-select,
    .input-group>.custom-select+.form-control,
    .input-group>.form-control+.custom-file,
    .input-group>.form-control+.custom-select,
    .input-group>.form-control+.form-control {
        margin-left: -1px
    }

    .input-group>.custom-file .custom-file-input:focus~.custom-file-label,
    .input-group>.custom-select:focus,
    .input-group>.form-control:focus {
        z-index: 3
    }

    .input-group>.custom-file .custom-file-input:focus {
        z-index: 4
    }

    .input-group>.custom-select:not(:last-child),
    .input-group>.form-control:not(:last-child) {
        border-top-right-radius: 0;
        border-bottom-right-radius: 0
    }

    .input-group>.custom-select:not(:first-child),
    .input-group>.form-control:not(:first-child) {
        border-top-left-radius: 0;
        border-bottom-left-radius: 0
    }

    .input-group>.custom-file {
        display: -ms-flexbox;
        display: flex;
        -ms-flex-align: center;
        align-items: center
    }

    .input-group>.custom-file:not(:last-child) .custom-file-label,
    .input-group>.custom-file:not(:last-child) .custom-file-label::after {
        border-top-right-radius: 0;
        border-bottom-right-radius: 0
    }

    .input-group>.custom-file:not(:first-child) .custom-file-label {
        border-top-left-radius: 0;
        border-bottom-left-radius: 0
    }

    .input-group-append,
    .input-group-prepend {
        display: -ms-flexbox;
        display: flex
    }

    .input-group-append .btn,
    .input-group-prepend .btn {
        position: relative;
        z-index: 2
    }

    .input-group-append .btn+.btn,
    .input-group-append .btn+.input-group-text,
    .input-group-append .input-group-text+.btn,
    .input-group-append .input-group-text+.input-group-text,
    .input-group-prepend .btn+.btn,
    .input-group-prepend .btn+.input-group-text,
    .input-group-prepend .input-group-text+.btn,
    .input-group-prepend .input-group-text+.input-group-text {
        margin-left: -1px
    }

    .input-group-prepend {
        margin-right: -1px
    }

    .input-group-append {
        margin-left: -1px
    }

    .input-group-text {
        display: -ms-flexbox;
        display: flex;
        -ms-flex-align: center;
        align-items: center;
        padding: .375rem .75rem;
        margin-bottom: 0;
        font-size: 1rem;
        font-weight: 400;
        line-height: 1.5;
        color: #495057;
        text-align: center;
        white-space: nowrap;
        background-color: #e9ecef;
        border: 1px solid #ced4da;
        border-radius: .25rem
    }

    .input-group-text input[type=checkbox],
    .input-group-text input[type=radio] {
        margin-top: 0
    }

    .input-group-lg>.form-control,
    .input-group-lg>.input-group-append>.btn,
    .input-group-lg>.input-group-append>.input-group-text,
    .input-group-lg>.input-group-prepend>.btn,
    .input-group-lg>.input-group-prepend>.input-group-text {
        height: calc(2.875rem + 2px);
        padding: .5rem 1rem;
        font-size: 1.25rem;
        line-height: 1.5;
        border-radius: .3rem
    }

    .input-group-sm>.form-control,
    .input-group-sm>.input-group-append>.btn,
    .input-group-sm>.input-group-append>.input-group-text,
    .input-group-sm>.input-group-prepend>.btn,
    .input-group-sm>.input-group-prepend>.input-group-text {
        height: calc(1.8125rem + 2px);
        padding: .25rem .5rem;
        font-size: .875rem;
        line-height: 1.5;
        border-radius: .2rem
    }

    .input-group>.input-group-append:last-child>.btn:not(:last-child):not(.dropdown-toggle),
    .input-group>.input-group-append:last-child>.input-group-text:not(:last-child),
    .input-group>.input-group-append:not(:last-child)>.btn,
    .input-group>.input-group-append:not(:last-child)>.input-group-text,
    .input-group>.input-group-prepend>.btn,
    .input-group>.input-group-prepend>.input-group-text {
        border-top-right-radius: 0;
        border-bottom-right-radius: 0
    }

    .input-group>.input-group-append>.btn,
    .input-group>.input-group-append>.input-group-text,
    .input-group>.input-group-prepend:first-child>.btn:not(:first-child),
    .input-group>.input-group-prepend:first-child>.input-group-text:not(:first-child),
    .input-group>.input-group-prepend:not(:first-child)>.btn,
    .input-group>.input-group-prepend:not(:first-child)>.input-group-text {
        border-top-left-radius: 0;
        border-bottom-left-radius: 0
    }

    .custom-control {
        position: relative;
        display: block;
        min-height: 1.5rem;
        padding-left: 1.5rem
    }

    .custom-control-inline {
        display: -ms-inline-flexbox;
        display: inline-flex;
        margin-right: 1rem
    }

    .custom-control-input {
        position: absolute;
        z-index: -1;
        opacity: 0
    }

    .custom-control-input:checked~.custom-control-label::before {
        color: #fff;
        background-color: #007bff
    }

    .custom-control-input:focus~.custom-control-label::before {
        box-shadow: 0 0 0 1px #fff, 0 0 0 .2rem rgba(0, 123, 255, .25)
    }

    .custom-control-input:active~.custom-control-label::before {
        color: #fff;
        background-color: #b3d7ff
    }

    .custom-control-input:disabled~.custom-control-label {
        color: #6c757d
    }

    .custom-control-input:disabled~.custom-control-label::before {
        background-color: #e9ecef
    }

    .custom-control-label {
        position: relative;
        margin-bottom: 0
    }

    .custom-control-label::before {
        position: absolute;
        top: .25rem;
        left: -1.5rem;
        display: block;
        width: 1rem;
        height: 1rem;
        pointer-events: none;
        content: "";
        -webkit-user-select: none;
        -moz-user-select: none;
        -ms-user-select: none;
        user-select: none;
        background-color: #dee2e6
    }

    .custom-control-label::after {
        position: absolute;
        top: .25rem;
        left: -1.5rem;
        display: block;
        width: 1rem;
        height: 1rem;
        content: "";
        background-repeat: no-repeat;
        background-position: center center;
        background-size: 50% 50%
    }

    .custom-checkbox .custom-control-label::before {
        border-radius: .25rem
    }

    .custom-checkbox .custom-control-input:checked~.custom-control-label::before {
        background-color: #007bff
    }

    .custom-checkbox .custom-control-input:checked~.custom-control-label::after {
        background-image: url("data:image/svg+xml;charset=utf8, %3Csvg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 8 8' %3E%3Cpath fill='%23fff' d='M6.564.75l-3.59 3.612-1.538-1.55L0 4.26 2.974 7.25 8 2.193z' /%3E%3C/svg%3E")
    }

    .custom-checkbox .custom-control-input:indeterminate~.custom-control-label::before {
        background-color: #007bff
    }

    .custom-checkbox .custom-control-input:indeterminate~.custom-control-label::after {
        background-image: url("data:image/svg+xml;charset=utf8, %3Csvg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 4 4' %3E%3Cpath stroke='%23fff' d='M0 2h4' /%3E%3C/svg%3E")
    }

    .custom-checkbox .custom-control-input:disabled:checked~.custom-control-label::before {
        background-color: rgba(0, 123, 255, .5)
    }

    .custom-checkbox .custom-control-input:disabled:indeterminate~.custom-control-label::before {
        background-color: rgba(0, 123, 255, .5)
    }

    .custom-radio .custom-control-label::before {
        border-radius: 50%
    }

    .custom-radio .custom-control-input:checked~.custom-control-label::before {
        background-color: #007bff
    }

    .custom-radio .custom-control-input:checked~.custom-control-label::after {
        background-image: url("data:image/svg+xml; charset=utf8, %3Csvg xmlns='http://www.w3.org/2000/svg' viewBox='-4 -4 8 8' %3E%3Ccircle r='3' fill='%23fff' /%3E%3C/svg%3E")
    }

    .custom-radio .custom-control-input:disabled:checked~.custom-control-label::before {
        background-color: rgba(0, 123, 255, .5)
    }

    .form-check {
        position: relative;
        display: block;
        padding-left: 1.25rem
    }

    .form-check-input {
        position: absolute;
        margin-top: .3rem;
        margin-left: -1.25rem
    }

    .form-check-input:disabled~.form-check-label {
        color: #6c757d
    }

    .form-check-label {
        margin-bottom: 0;
        margin-left: 15px;
    }

    .form-check-inline {
        display: -ms-inline-flexbox;
        display: inline-flex;
        -ms-flex-align: center;
        align-items: center;
        padding-left: 0;
        margin-right: .75rem
    }

    .form-check-inline .form-check-input {
        position: static;
        margin-top: 0;
        margin-right: .3125rem;
        margin-left: 0
    }

    legend {
        border-bottom: unset !important;
    }

    .nav-tabs {
        background-color: unset !important;
    }

    .nav-tabs>li>a:hover {
        background: unset !important;
    }

    .addtxt {
        padding-top: 10px;
        padding-bottom: 10px;
        text-align: center;
        font-size: 13px;
        width: 350px;
        background-color: #e5e8ed;
        font-weight: 500;
    }

    .second {
        width: 350px;
        background-color: white;
        border-radius: 4px;
        box-shadow: 10px 10px 5px #aaaaaa;
    }

    .text1 {
        font-size: 13px;
        font-weight: 500;
        color: #56575b;
    }

    .text2 {
        font-size: 13px;
        font-weight: 500;
        margin-left: 6px;
        color: #56575b;
    }

    .text3 {
        font-size: 13px;
        font-weight: 500;
        margin-right: 4px;
        color: #828386;
    }

    .text3o {
        color: #00a5f4;

    }

    .text4 {
        font-size: 13px;
        font-weight: 500;
        color: #828386;
    }

    .text4i {
        color: #00a5f4;
    }

    .text4o {
        color: white;
    }

    .thumbup {
        font-size: 13px;
        font-weight: 500;
        margin-right: 5px;
    }

    .thumbupo {
        color: #17a2b8;
    }

    .comment-boder {
        border: 1px solid black;
        margin-top: 5px;
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

    #load_tabla {
        overflow: auto;
        max-width: 100%;
        /*  height: 300px; */
        max-height: 400px;
    }
</style>
<script src="<?= base_url() ?>/assets/gap/js/Prueba.js"></script>
<section class="container-fluid breadcrumb-formularios">
    <a id="N" data-IdNotificacion='<?= $idNotificacion; ?>'></a>
    <div class="row">
        <div class="col-md-6 col-sm-5 col-xs-5">
            <h3 class="titulo-secciones">Tablero Reportes</h3>
        </div>
        <div class="col-md-6 col-sm-7 col-xs-7 d-flex">
            <ol class="breadcrumb text-right">
                <li><a href="<?= base_url() ?>">Inicio</a></li>
                <li><a href="<?= base_url() ?>TableroReportes">Tablero Reportes</a></li>
            </ol>
        </div>
    </div>
    <hr />
</section>
<section class="container">
    <?= $this->load->view('evaluaciones/_parts/sidemenu2', array("tipo" => $tipo)); ?>

    <div style="float: left; width: 90%;">
        <div class="panel panel-default">
            <div class="panel-body">
                <div class="row" id="change_template">
                    <?php $this->load->view("siniestroCorporativo/filtros_tablero"); ?>
                </div>
                <div class="row">
                    <div class="col-sm-12 text-right" style="padding-top: 10px;">
                        <a id="clean-control" class="btn btn-primary">Limpiar controles</a>
                        <a class="btn btn-primary" onclick="PostFiles()">Generar Documento</a>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-12" id="load_tabla">
                        <span>No se ha realizado ninguna busqueda</span>
                    </div>
                </div>
            </div><!-- panel-body -->
        </div><!-- panel-default -->
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


        const $path = $("#base_url").attr("data-base-url");

        $(document).on("input", ".numeric", function() {
            this.value = this.value.replace(/[^0-9.]/g, '').replace(/(\..*?)\..*/g, '$1');
        });

        $(document).on('click', '.test_m', function(e) {
            e.preventDefault();
            var optSelect = $('#estatus_d option:selected').toArray().map(item => item.value).join('|');
            alert(optSelect);
        });


        $('.multiselect-ui').multiselect({
            nonSelectedText: 'Seleccione',
            allSelectedText: 'Todo seleccionado',
            nSelectedText: "Seleccionado",
            numberDisplayed: 1,
        });

        //metodo para agregar otro input de tipo file
        $(document).on('click', '.btn-add', function(e) {
            e.preventDefault();
            //console.log("context",$(this).data('parent'))
            //alert("click")
            const currentDate = new Date();
            var controlForm = $(`#${$(this).data('parent')}:first`),
                currentEntry = $(this).parents('.entry:first'),
                newEntry = $(currentEntry.clone()).css('padding-top', '5px').appendTo(controlForm);

            newEntry.find('input').val('').attr('id', currentDate.getTime().toString());
            controlForm.find('.entry:not(:last) .btn-add')
                .removeClass('btn-add').addClass('btn-remove')
                .removeClass('btn-success').addClass('btn-danger')
                .html('<span class="fa fa-trash"></span>');
        }).on('click', '.btn-remove', function(e) {
            $(this).parents('.entry:first').remove();

            e.preventDefault();
            return false;
        });


        function getFomulario(tipo = 1) {
            var dta = new FormData();

            dta.append('tipo', tipo);
            var tipoR = $("#tipo_r").val();
            dta.append('tipo_r', tipoR);
            switch (tipoR) {
                case 'DEDUCIBLES':
                    var EstatusD = $('#estatus_d option:selected').toArray().map(item => item.value).join('|');
                    dta.append('estatus_d', EstatusD);
                    break;
                default:
                    break;
            }

            //Tipo
            if (tipoR == "ESTATUS_T") {
                var num_unidades = $("#num_unidades").val();
                dta.append('num_unidades', num_unidades);
            }

            //Fechas
            var f_inicio = $("#f_inicio").val();
            var f_fin = $("#f_fin").val();
            dta.append('f_inicio', f_inicio);
            dta.append('f_fin', f_fin);

            //clientes
            var st = document.getElementsByClassName("f_cliente");
            for (var i = 0; i < st.length; i++) {
                dta.append(`cliente[]`, st.item(i).value);
            }
            //polizas
            var st = document.getElementsByClassName("f_poliza");
            for (var i = 0; i < st.length; i++) {
                dta.append(`poliza[]`, st.item(i).value);
            }
            //compania
            var st = document.getElementsByClassName("f_compania");
            for (var i = 0; i < st.length; i++) {
                dta.append(`compania[]`, st.item(i).value);
            }

            return dta;
        }

        function getFomularioObject(tipo = 1) {
            var dta = {
                tipo: tipo,
                estatus_d: "",
                tipo_r: "",
                f_inicio: "",
                f_fin: "",
                cliente: [],
                poliza: [],
                compania: [],
                num_unidades:""
            };

            //dta.tipo = tipo;
            var tipoR = $("#tipo_r").val();
            dta['tipo_r'] = tipoR;
            switch (tipoR) {
                case 'DEDUCIBLES':
                    var EstatusD = $('#estatus_d option:selected').toArray().map(item => item.value).join('|');
                    dta['estatus_d'] = EstatusD;
                    break;
                default:
                    break;
            }

            //Fechas
             //Tipo
            if (tipoR == "ESTATUS_T") {
                var num_unidades = $("#num_unidades").val();
                dta['num_unidades']= num_unidades;
            }

            var f_inicio = $("#f_inicio").val();
            var f_fin = $("#f_fin").val();
            dta['f_inicio'] = f_inicio;
            dta['f_fin'] = f_fin;

            //clientes
            var st = document.getElementsByClassName("f_cliente");
            for (var i = 0; i < st.length; i++) {
                dta.cliente.push(st.item(i).value);
            }
            //polizas
            var st = document.getElementsByClassName("f_poliza");
            for (var i = 0; i < st.length; i++) {
                dta.poliza.push(st.item(i).value);
            }
            //compania
            var st = document.getElementsByClassName("f_compania");
            for (var i = 0; i < st.length; i++) {
                dta.compania.push(st.item(i).value);
            }

            return dta;
        }

        window.PostFiles = function() {
            var tipoR = $("#tipo_r").val();
            console.log("tipo", tipoR)
            if (tipoR != "") {

                if (tipoR == "ESTATUS_T") {
                    var unidades = $("#num_unidades").val();
                    if (unidades == "") {
                        toastr.error("Ingrese las unidades.");
                        return;
                    }
                }
                var dta = getFomulario(1);
                $.ajax({
                    type: 'POST',
                    url: `${$path}siniestroCorporativo/PostFiltros`,
                    data: dta,
                    processData: false,
                    contentType: false,
                    success: function(response) {
                        $("#load_tabla").html();
                        $("#load_tabla").html(response);
                        //console.log('response', response);
                    }
                });
            } else {
                toastr.error("Seleccione un tipo de reporte.");
            }
        }

        $(document).on('change', '#tipo_r', function(e) {
            e.preventDefault();
            var tipoR = $("#tipo_r").val();
            $.ajax({
                type: 'POST',
                url: `${$path}siniestroCorporativo/getFitro`,
                data: {
                    tipo_r: tipoR
                },
                success: function(response) {
                    $("#change_template").html();
                    $("#change_template").html(response);
                    $('.multiselect-ui').multiselect({
                        nonSelectedText: 'Seleccione',
                        allSelectedText: 'Todo seleccionado',
                        nSelectedText: "Seleccionado",
                        numberDisplayed: 1,
                    });
                    $("#load_tabla").html('');
                    //console.log('response', response);
                }
            });
        });

        $(document).on('click', '#clean-control', function(e) {
            e.preventDefault();
            var tipoR = $("#tipo_r").val();
            $.ajax({
                type: 'POST',
                url: `${$path}siniestroCorporativo/getFitro`,
                data: {
                    tipo_r: tipoR
                },
                success: function(response) {
                    $("#change_template").html();
                    $("#change_template").html(response);
                    $('.multiselect-ui').multiselect({
                        nonSelectedText: 'Seleccione',
                        allSelectedText: 'Todo seleccionado',
                        nSelectedText: "Seleccionado",
                        numberDisplayed: 1,
                    });
                    //console.log('response', response);
                }
            });
        });

        function getForm(url, target, values, method) {
            function grabValues(x) {
                var path = [];
                var depth = 0;
                var results = [];

                function iterate(x) {
                    switch (typeof x) {
                        case 'function':
                        case 'undefined':
                        case 'null':
                            break;
                        case 'object':
                            if (Array.isArray(x))
                                for (var i = 0; i < x.length; i++) {
                                    path[depth++] = i;
                                    iterate(x[i]);
                                }
                            else
                                for (var i in x) {
                                    path[depth++] = i;
                                    iterate(x[i]);
                                }
                            break;
                        default:
                            results.push({
                                path: path.slice(0),
                                value: x
                            })
                            break;
                    }
                    path.splice(--depth);
                }
                iterate(x);
                return results;
            }
            var form = document.createElement("form");
            form.method = method;
            form.action = url;
            form.target = target;

            var values = grabValues(values);

            for (var j = 0; j < values.length; j++) {
                var input = document.createElement("input");
                input.type = "hidden";
                input.value = values[j].value;
                input.name = values[j].path[0];
                for (var k = 1; k < values[j].path.length; k++) {
                    input.name += "[" + values[j].path[k] + "]";
                }
                form.appendChild(input);
            }
            return form;
        }

        //Imprimir documentos pdf
        $(document).on('click', '#print_pdf', function(e) {
            e.preventDefault();
            var dta = getFomularioObject(2);
            console.log(dta);
            var form = getForm(`${$path}siniestroCorporativo/PostFiltros`, "_blank", dta, "post");
            document.body.appendChild(form);
            form.submit();
            form.parentNode.removeChild(form);
        });

        //Imprimir documentos excel
        $(document).on('click', '#print_excel', function(e) {
            e.preventDefault();
            var dta = getFomularioObject(3);
            console.log(dta);
            var form = getForm(`${$path}siniestroCorporativo/PostFiltros`, "_blank", dta, "post");
            document.body.appendChild(form);
            form.submit();
            form.parentNode.removeChild(form);
        });

    });
</script>