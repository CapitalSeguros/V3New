    <!-- <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.1.3/dist/css/bootstrap.min.css" integrity="sha384-MCw98/SFnGE8fJT3GXwEOngsV7Zt27NXFoaoApmYm81iuXoPkFOJwJ8ERdknLPMO" crossorigin="anonymous"> -->
    <!--  <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script> -->
    <!--  <script src="https://cdn.jsdelivr.net/npm/popper.js@1.14.3/dist/umd/popper.min.js" integrity="sha384-ZMP7rVo3mIykV+2+9J3UJ46jBk0WLaUAdn689aCwoqbBJiSnjAK/l8WvCWPIPm49" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.1.3/dist/js/bootstrap.min.js" integrity="sha384-ChfqqxuZUCnJSK3+MXmPNIyE6ZbWh2IMqE241rYiqJxyMiZ6OW/JmZQ5stwEULTy" crossorigin="anonymous"></script> -->
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

        .inputdcss {
            pointer-events: none;
            color: #AAA;
            background: #F5F5F5;
        }


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
            /*pointer-events: none;
        cursor: not-allowed;*/
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

        .blocker {
            position: absolute;
            top: 0px;
            left: 0px;
            height: 100%;
            width: 100%;
            /* hacemos que ocupe toda la pantalla a cualquier resolución*/
            z-index: 50;
        }
    </style>
    <div id="full-container">
        <?php $this->load->view("siniestroCorporativo/loadTemplate"); ?>
    </div>
    <div id="upProgressGeneral" style="display:none;" role="status" aria-hidden="true">
        <div id="nprogress" class="nprogress">
            <div class="spinner">
                <div class="spinner-icon"></div>
                <div class="spinner-icon-bg"></div>
            </div>
            <div class="overlay"></div>
        </div>
    </div>

    <!-- modal administracion de documentos -->
    <div class="modal fade" id="modal_docs_admin" tabindex="-1" role="dialog" aria-labelledby="modalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title" id="modalLabel">Administración de documentos</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>

                </div>
                <div class="modal-body">
                    <div id="modal-content-d">

                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- modal administracion de seguimiento -->
    <div class="modal fade" id="segimiento_modal" tabindex="-1" role="dialog" aria-labelledby="modalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title" id="modalLabel">Seguimiento</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>

                </div>
                <div class="modal-body">
                    <div class="row">
                        <div class="col-sm-10">
                            <textarea class="form-control" name="seguimiento" id="seguimiento"></textarea>
                        </div>
                        <div class="col-sm-2">
                            <a class="btn btn-primary" onclick="addSeguimiento()">Enviar</a>
                        </div>
                    </div>
                    <div class="row" style="overflow: auto; max-height: 250px;">
                        <div class="col-sm-12" id="comment-content" style="padding-top: 10px;">

                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- modal piezas de BO-->
    <div class="modal fade" id="refacciones_modal" tabindex="-1" role="dialog" aria-labelledby="modalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title" id="modalLabel">Refacciones en BO</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>

                </div>
                <div class="modal-body">
                    <div class="row">
                        <div class="col-sm-4">
                            <div class="form-group">
                                <label>Num de refacción</label>
                                <input type="text" class="form-control" id="num_refaccion_m" name="num_refaccion_m">
                            </div>

                        </div>
                        <div class="col-sm-4">
                            <div class="form-group">
                                <label>Pieza</label>
                                <input type="text" class="form-control" id="pieza_m" name="pieza_m">
                            </div>

                        </div>
                        <div class="col-sm-4">
                            <div class="form-group">
                                <label>Fecha recibida</label>
                                <input type="date" class="form-control" id="fecha_recibida_m" name="fecha_recibida_m">
                            </div>
                        </div>
                        <div class="col-sm-12" style="text-align: right;">
                            <a class="btn btn-primary" onclick="savePieza()">Guardar</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!--modal de las polizas-->
    <div class="modal fade" id="poliza_modal" tabindex="-1" role="dialog" aria-labelledby="modalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title" id="modalLabel">Buscar Poliza</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>

                </div>
                <div class="modal-body">
                    <div class="row">
                        <div class="col-sm-5">
                            <div class="form-group">
                                <label>Busqueda</label>
                                <input type="text" class="form-control" id="txSearch" name="txSearch">
                            </div>
                        </div>
                        <div class="col-sm-3">
                            <div class="form-group">
                                <label>Desde</label>
                                <input type="date" class="form-control" id="Finicio" name="Finicio">
                            </div>
                        </div>
                        <div class="col-sm-3">
                            <div class="form-group">
                                <label>Hasta</label>
                                <input type="date" class="form-control" id="Ffin" name="Ffin">
                            </div>
                        </div>
                        <div class="col-sm-1">
                            <button class="btn btn-primary" style="margin-top: 25px;" id="search_p">
                                <i class="fa fa-search"></i>
                            </button>
                        </div>

                    </div>
                    <div class="row">
                        <div class="col-md-12">
                            <table class="table table-condensed" id="polizas">
                                <thead>
                                    <tr>
                                        <th scope="col">id</th>
                                        <th scope="col" style="width: 100%;">Póliza</th>
                                    </tr>
                                </thead>
                                <tbody>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>
        $(document).ready(function() {
            $('body').append('<div id="over" style="display:none;position: absolute;top:0;left:0;width: 100%;height:100%;z-index:2;opacity:0.4;filter: alpha(opacity = 50)"></div>');
            var element = document.querySelector(".pace");
            element.classList.remove("pace-active");
            element.classList.add("pace-inactive");

            const $path = $("#base_url").attr("data-base-url");
            $('[data-toggle="tooltip"]').tooltip();

            //Opcion para mostrar las causas
            window.Causas = function(id, selected) {
                //console.log("id",id)
                var opt = '<option value="">Seleccione una Causa</option>';
                const newData = _Causa.filter((item, index) => item.tipo_siniestro_id === id);
                //console.log("newData",newData)
                newData.forEach((element, key) => {
                    opt += `<option value="${element.id}" ${selected == element.id ? 'selected' : ''}>${element.nombre}</option>`;
                });
                $("#causa_siniestro_id").html('');
                $("#causa_siniestro_id").html(opt);
            }

            //Select la causa
            <?php if ($siniestro_form["tipo_siniestro_id"] != 0) : ?>
                //alert('aaaa');
                Causas((<?= $siniestro_form["tipo_siniestro_id"] ?>).toString(), (<?= $siniestro_form["causa_siniestro_id"] ?>).toString());
            <?php endif; ?>

            $(document).on('change', '#tipo_siniestro_id', function(e) {
                var id = e.currentTarget.value;
                Causas(id, '');
            });

            window.FormDataSiniestro = function() {
                var dta = new FormData();

                //Siniestro poliza
                var sp = document.getElementsByClassName("siniestro-p");
                for (var i = 0; i < sp.length; i++) {
                    dta.append(`siniestro_poliza[${sp.item(i).name}]`, sp.item(i).value);


                }
                //dta.append("siniestro_poliza",JSON.stringify(spd));

                //Siniestro general
                var sf = document.getElementsByClassName("siniestro-f");
                for (var i = 0; i < sf.length; i++) {
                    dta.append(`siniestro_form[${sf.item(i).name}]`, sf.item(i).value);
                }

                //Siniestro deducible
                var sd = document.getElementsByClassName("siniestro-d");
                for (var i = 0; i < sd.length; i++) {
                    if (sd.item(i).classList.contains('moneyFormat')) {
                        var r = sd.item(i).value;
                        var value = Number(r.replace(/[^0-9.-]+/g, ""))
                        dta.append(`siniestro_deducible[${sd.item(i).name}]`, value);
                    } else {
                        dta.append(`siniestro_deducible[${sd.item(i).name}]`, sd.item(i).value);
                    }

                }

                //Siniestro reserva
                var sr = document.getElementsByClassName("siniestro-r");
                for (var i = 0; i < sr.length; i++) {
                    if (sr.item(i).classList.contains('moneyFormat')) {
                        var r = sr.item(i).value;
                        var value = Number(r.replace(/[^0-9.-]+/g, ""))
                        dta.append(`siniestro_reserva[${sr.item(i).name}]`, value);
                    } else {
                        dta.append(`siniestro_reserva[${sr.item(i).name}]`, sr.item(i).value);
                    }
                }

                var checkf = document.getElementsByClassName("check-r");
                for (var i = 0; i < checkf.length; i++) {
                    dta.append(`siniestro_reserva[${checkf.item(i).name}]`, checkf.item(i).checked ? 1 : "");
                }

                //Siniestro tramite
                var st = document.getElementsByClassName("siniestro-l");
                for (var i = 0; i < st.length; i++) {
                    //dta.append(`siniestro_tramite[${st.item(i).name}]`, st.item(i).value);
                    if (st.item(i).classList.contains('moneyFormat')) {
                        var r = st.item(i).value;
                        var value = Number(r.replace(/[^0-9.-]+/g, ""))
                        dta.append(`siniestro_tramite[${st.item(i).name}]`, value);
                    } else {
                        dta.append(`siniestro_tramite[${st.item(i).name}]`, st.item(i).value);
                    }
                }
                var checkt = document.getElementsByClassName("check-t");
                for (var i = 0; i < checkt.length; i++) {
                    dta.append(`siniestro_tramite[${checkt.item(i).name}]`, checkt.item(i).checked ? 1 : "");
                }



                //Add tipo de template a cargar
                var optSelect = $('#causa_siniestro_id').val();
                var Template = _Causa.find((elem, i) => elem.id == optSelect);
                dta.append('template', Template?.tipo_template);

                //Cargamos documentos
                $('.fileL').each(function(index, value) {
                    //console.log("DocName", value.name);
                    const DocFiles = $(`#${value.id}`).prop('files');
                    //console.log("DocFiles", DocFiles);
                    for (var i = 0; i < DocFiles.length; i++) {
                        dta.append(DocFiles[i].name + '_' + `${value.name}`, DocFiles[i]);
                    }
                });

                return dta;
            }

            $(document).on('change', '#causa_siniestro_id', function(e) {
                //alert('cambio')
                var optSelect = $('#causa_siniestro_id').val();
                var dta = FormDataSiniestro();

                if (optSelect != "") {
                    $.ajax({
                        type: 'POST',
                        url: `${$path}siniestroCorporativo/getTemplateView`,
                        data: dta,
                        processData: false,
                        contentType: false,
                        success: function(response) {
                            //console.log(response);
                            $("#full-container").html('');
                            $("#full-container").html(response);
                            var optSelectpost = $('#tipo_siniestro_id').val();
                            Causas(optSelectpost, optSelect);

                        }
                    });
                }
            });


            //Guardado de la vista
            $(document).on('click', '#save_button', function(e) {
                //alert('cambio')
                var optSelect = $('#causa_siniestro_id').val();
                var Poliza = $('#poliza').val();
                var idP = $('#id').val();
                var tipoSeg = $("#seguimiento_id").val();
                var dta = FormDataSiniestro();
                //Form data
                /* var form_data = $('#form-body').serializeArray();
                $.each(form_data, function(key, input) {
                    dta.append(input.name, input.value);
                }); */

                //File data
                /* var file_data = $('input[name="my_images"]')[0].files;
                for (var i = 0; i < file_data.length; i++) {
                    data.append("my_images[]", file_data[i]);
                } */

                //Custom data
                //data.append('key', 'value');
                document.getElementById("over").style.display = "block";
                document.getElementById("upProgressGeneral").style.display = "block";
                if (optSelect != "" && ((idP != "" || idP == 0) || Poliza != "") && tipoSeg != "") {
                    $.ajax({
                        type: 'POST',
                        url: `${$path}siniestroCorporativo/saveSiniestro`,
                        data: dta,
                        processData: false,
                        contentType: false,
                        success: function(response) {
                            if (response.code == 200) {
                                toastr.success("Se guardo con éxito.");
                                window.location.replace(`${$path}siniestroCorporativo`)
                            } else {
                                toastr.error(response.message);
                                document.getElementById("over").style.display = "none";
                                document.getElementById("upProgressGeneral").style.display = "none";
                            }

                            //console.log(response);
                            //$("#full-container").html('');
                            //$("#full-container").html(response);

                        }
                    });
                } else {
                    if (optSelect == "") {
                        toastr.error("Seleccione una causa de siniestro");
                        //alert("Seleccione una causa de siniestro")
                    }
                    if ((idP != "" || idP == 0) || Poliza == "") {
                        toastr.error("Ingrese una poliza");
                        //alert("Imgrese una poliza")
                    }
                    if (tipoSeg == "") {
                        toastr.error("Seleccione un tipo de seguimiento");
                    }
                    document.getElementById("over").style.display = "none";
                    document.getElementById("upProgressGeneral").style.display = "none";
                }
            });


            //metodo para agregar otro input de tipo file
            $(document).on('click', '.btn-add', function(e) {
                e.preventDefault();
                //console.log("context",$(this).data('parent'))
                //alert("click")
                const currentDate = new Date();
                var controlForm = $(`#${$(this).data('parent')}:first`),
                    currentEntry = $(this).parents('.entry:first'),
                    newEntry = $(currentEntry.clone()).appendTo(controlForm);

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


            window.OpenDocs = function(e) {
                var id = e.dataset.id;
                var tramite = e.dataset.tramite;
                $.ajax({
                    type: 'POST',
                    url: `${$path}siniestroCorporativo/GetDocuments`,
                    data: {
                        id: id,
                        tramite: tramite
                    },
                    //processData: false,
                    //contentType: false,
                    success: function(response) {
                        //console.log(response);
                        $("#modal-content-d").html('');
                        $("#modal-content-d").html(response);

                        $("#modal_docs_admin").modal("show");
                        console.log("altura modal", $("#modal_docs_admin").height());
                        console.log("altura de la pantalla", window.innerWidth)
                    }
                });
            }

            window.deleteFile = function(elm, id) {
                swal({
                    title: "¿Está seguro de que quiere eliminar el elemento seleccionado?",
                    text: "Una vez eliminado, ¡no podrá recuperar el elemento!",
                    icon: "warning",
                    buttons: ["Cancelar", "Aceptar"],
                }).then((value) => {
                    if (value) {
                        const element = document.getElementById(elm);
                        element.remove();
                        var rowCount = $('#list-files tr').length;
                        console.log("coutn", rowCount);
                        $.ajax({
                            type: 'POST',
                            url: `${$path}siniestroCorporativo/delete_documento`,
                            data: {
                                id: id,
                            },
                            //processData: false,
                            //contentType: false,
                            success: function(response) {
                                //console.log(response);
                                //$("#modal-content-d").html('');
                                //$("#modal-content-d").html(response);
                            }
                        });
                    }
                });
            }

            window.Seguimiento = function() {
                var tipo = $("#general> .active").data('modulo');
                var id_siniestro = $("#id").val();
                $.ajax({
                    type: 'POST',
                    url: `${$path}siniestroCorporativo/getSeguimiento`,
                    data: {
                        id: id_siniestro,
                        tramite: tipo,
                    },
                    //processData: false,
                    //contentType: false,
                    success: function(response) {
                        //console.log(response);
                        $("#comment-content").html('');
                        $("#comment-content").html(response);
                    }
                });
                //console.log("tipo", tipo);
                $("#segimiento_modal").modal("show");
            }

            window.addSeguimiento = function() {
                var id_siniestro = $("#id").val();
                var comment = $("#seguimiento").val();
                var tipo = $("#general> .active").data('modulo');
                var test = $("#general> li> .active> a ").data('modulo');
                $.ajax({
                    type: 'POST',
                    url: `${$path}siniestroCorporativo/NuevoComentario`,
                    data: {
                        id: id_siniestro,
                        tramite: tipo,
                        comentario: comment
                    },
                    //processData: false,
                    //contentType: false,
                    success: function(response) {
                        //console.log(response);
                        $("#seguimiento").val('');
                        $("#comment-content").html('');
                        $("#comment-content").html(response);
                    }
                });
            }

            window.NewPieza = function() {
                $("#refacciones_modal").modal("show");
            }

            window.savePieza = function() {
                var id_siniestro = $("#id").val();
                var pieza = $("#pieza_m").val();
                var num_refaccion = $("#num_refaccion_m").val();
                var fecha = $("#fecha_recibida_m").val();
                $.ajax({
                    type: 'POST',
                    url: `${$path}siniestroCorporativo/AccionesRefacciones`,
                    data: {
                        id: id_siniestro,
                        pieza: pieza,
                        num_refaccion: num_refaccion,
                        fecha: fecha,
                        tipo: 1
                    },
                    //processData: false,
                    //contentType: false,
                    success: function(response) {
                        //console.log(response);
                        $("#pieza_m").val('');
                        $("#num_refaccion_m").val('');
                        $("#fecha_recibida_m").val('');
                        $("#data-refacciones").html('');
                        $("#data-refacciones").html(response);
                        $("#refacciones_modal").modal("hide");
                    }
                });
            }

            $(document).on("input", ".numeric", function() {
                this.value = this.value.replace(/[^0-9.]/g, '').replace(/(\..*?)\..*/g, '$1');
            });

            //Aciones para calcular la penalizacion
            $(document).on("change", ".penalizacionChange", function() {
                //var fechai = $('#fecha_documentacion').val();
                var fechai = $('#fecha_pago_limite').val();
                console.log('Fi', fechai)
                var fechaf = $('#fecha_pago').val();
                console.log('FF', fechaf)
                //const date = '2016-10-19';
                const dateFormat = 'DD-MM-YYYY';
                const toDateFormatI = moment(new Date(fechai)).format(dateFormat);
                const toDateFormatF = moment(new Date(fechaf)).format(dateFormat);
                if (moment(toDateFormatI, dateFormat, true).isValid() && moment(toDateFormatF, dateFormat, true).isValid()) {
                    var fecha1 = moment(fechai);
                    var fecha2 = moment(fechaf);
                    //var dias = fecha2.diff(fecha1, 'days');
                    var dias = workingDays(fecha1, fecha2);
                    if (dias > 0) {
                        $("#dias_penalizacion").val(dias);
                        var monto_dia = parseInt($("#monto_dia").val());
                        $("#total_penalizacion").val(dias * monto_dia);
                    }
                    //alert('Son correctas');
                    //alert('Diferencia de dias'+fecha2.diff(fecha1, 'days').toString())
                } else {
                    $("#dias_penalizacion").val(0);
                    //alert('Not');
                }
                //console.log('fi',fechai);
                //console.log('ff',fechaf);
                /*  var fechai=moment($('#fecha_documentacion').val(), 'YYYY-MM-DD');
                 var fechaf=moment($('#fecha_pago').val(), 'YYYY-MM-DD'); */
                //alert(fechaf);
            });

            function workingDays(dateFrom, dateTo) {
                var from = moment(dateFrom, 'DD/MM/YYY'),
                    to = moment(dateTo, 'DD/MM/YYY'),
                    days = 0;

                while (!from.isAfter(to)) {
                    // Si no es sabado ni domingo
                    //console.log('day',from.isoWeekday())
                    if (from.isoWeekday() !== 6 && from.isoWeekday() !== 7) {
                        days++;
                    }
                    from.add(1, 'days');
                }
                if (days != 0) {
                    days = days - 1;
                }
                return days;
            }

            $(document).on("change", "#monto_dia", function() {
                var dias = parseInt($("#dias_penalizacion").val());
                var monto_dia = parseInt($("#monto_dia").val());
                $("#total_penalizacion").val(dias * monto_dia);
            });


            //Modal de poliza
            $(document).on("click", "#btn_cliente", function() {
                //alert('click');
                if (!$("#btn_cliente").hasClass('dbutton')) {
                    $("#poliza_modal").modal("show");
                }

            });



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
                            "tipo": 2
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
                                   <div onclick="test('${btoa(unescape(encodeURIComponent(JSON.stringify(row))))}')">
                                   <b>Póliza:</b> ${row.Poliza} | <b>Serie:</b> ${row.Serie}| <b>Economico:</b> ${row.Economico}| <b>Modelo:</b> ${row.Modelo} |  <br/> <b>Descripción:</b>  ${row.Descripcion}
                                   <b>Desde: </b> ${row.FDesde==null || row.FDesde=="0000-00-00 00:00:00"?'N/A':moment(row.FDesde).format("DD/MM/YYYY")}  <b>Hasta:</b>${row.FHasta==null || row.FHasta=="0000-00-00 00:00:00"?'N/A':moment(row.FHasta).format("DD/MM/YYYY")} 
                                   </div>
                            </div>`
                        }
                    },
                ],
                order: [
                    [0, 'desc']
                ],


            });

            //buscar poliza
            $(document).on("click", "#search_p", function() {
                datatable.draw();
                setTimeout(() => {
                    $("#poliza_modal").modal('handleUpdate');
                }, 1000)
            });


            window.test = function(row) {
                //alert('aa');
                //console.log('row', row)
                const dataelement = JSON.parse(decodeURIComponent(escape(window.atob(row))));
                //console.log(dataelement);
                $('#Poliza').val(dataelement.Poliza).addClass('inputdcss');
                $('#Descripcion').val(dataelement.Descripcion).addClass('inputdcss');
                $('#Modelo').val(dataelement.Modelo).addClass('inputdcss');
                $('#Endoso').val(dataelement.Endoso).addClass('inputdcss');
                $('#Serie').val(dataelement.Serie).addClass('inputdcss');
                $('#Economico').val(dataelement.Economico).addClass('inputdcss');
                //console.log('Fecha',moment(dataelement.f_inicio).format("YYYY-MM-DD"))
                $('#FDesde').val(moment(dataelement.FDesde).format("YYYY-MM-DD")).addClass('inputdcss');
                $('#FHasta').val(moment(dataelement.FHasta).format("YYYY-MM-DD")).addClass('inputdcss');

                $('.id-input-poliza').val(dataelement.Id).addClass('inputdcss');
                $('#siniestro_poliza_id').val(dataelement.Id).addClass('inputdcss');
                $("#poliza_modal").modal('hide');
            }

            window.CalculatePercent = function() {
                if ($('#monto_valuacion').length > 0) {
                    //console.log("calculatePercent");
                    var sumA = $("#suma_asegurada").val();
                    var mV = $("#monto_valuacion").val();
                    var CsumA = Number(sumA.replace(/[^0-9.-]+/g, ""));
                    var CsmV = Number(mV.replace(/[^0-9.-]+/g, ""));
                    var calculo = 0;
                    if (CsmV <= 0 || sumA <= 0) {
                        calculo = 0;
                    } else {
                        calculo = (CsmV * 100) / CsumA;
                    }

                    $("#porcentaje_dano").val(calculo == Infinity ? 0 : calculo.toFixed(2));
                }

            }

            if ($('#monto_valuacion').length > 0) {
                CalculatePercent();
                // Exists
            }
            //CalculatePercent();
            $(document).on("change", ".porcentajeD", function() {
                CalculatePercent();
                /*  var sumA=$("#suma_asegurada").val();
                 var mV=$("#monto_valuacion").val();
                 var CsumA=Number(sumA.replace(/[^0-9.-]+/g,""));
                 var CsmV=Number(mV.replace(/[^0-9.-]+/g,""));
                 var calculo=0;
                 if(CsmV<=0 || sumA<=0){
                     calculo=0;
                 }else{
                     calculo=(CsmV*100)/CsumA;
                 }
                 $("#porcentaje_dano").val(calculo==Infinity?0:calculo.toFixed(2)); */
            });



            //nueva poliza
            $(document).on("click", "#addP", function() {
                //siniestro-p
                var checkt = document.getElementsByClassName("siniestro-p");
                $("#btn_cliente").removeClass('dbutton');
                for (var i = 0; i < checkt.length; i++) {
                    $(`#${checkt.item(i).id}`).removeClass('inputdcss').val('');
                }
            });

            //editar
            $(document).on("click", "#editP", function() {
                //siniestro-p
                $("#btn_cliente").removeClass('dbutton');
                var checkt = document.getElementsByClassName("siniestro-p");
                for (var i = 0; i < checkt.length; i++) {
                    $(`#${checkt.item(i).id}`).removeClass('inputdcss');
                }
            });


            $(document).on("blur", ".moneyFormat", function() {
                //console.log('clic')
                var val = this.value;
                //console.log('value',Number(val).toLocaleString('es-MX', { style: 'currency', currency: 'MXN' }))
                this.value = Number(val).toLocaleString('es-MX', {
                    style: 'currency',
                    currency: 'MXN'
                });
                //$(`#${this.id}`).val(this.value.toLocaleString('es-MX', { style: 'currency', currency: 'MXN' }));
            });


            /*  $(document).on("click", "#testVal", function() {
                //alert('aaa')
                console.log("_Seguimiento",_Seguimiento)
                console.log("_Etapa",_Etapa)
                console.log("_EstatusTram",_EstatusTram)
                var Esid= $("#estatus_s_id").val();
                console.log(Esid)
            });
 */
            window.Etapas = function(id, selected) {
                var opt = '<option value="">Seleccione una opción</option>';
                const newData = _Etapa.filter((item, index) => item.id_seguimiento === id);
                //console.log("newData",newData)
                newData.forEach((element, key) => {
                    opt += `<option value="${element.id}" ${selected == element.id ? 'selected' : ''}>${element.nombre}</option>`;
                });
                $("#etapa_id").html('');
                $("#etapa_id").html(opt);
            }

            window.EstatusTram = function(id, selected) {
                var opt = '<option value="">Seleccione una opción</option>';
                //console.log("tramite",_EstatusTram)
                //console.log("icTT",selected)
                const newData = _EstatusTram.filter((item, index) => item.id_etapa === id);
                //console.log("newData",newData)
                newData.forEach((element, key) => {
                    opt += `<option value="${element.id}" ${selected == element.id ? 'selected' : ''}>${element.nombre}</option>`;
                });
                $("#estatus_s_id").html('');
                $("#estatus_s_id").html(opt);
            }


            $(document).on("change", "#seguimiento_id", function() {
                var id = $("#seguimiento_id").val();
                var Valid = $("#etapa_id").val();
                //Reset all selects
                Etapas(id, "");
                EstatusTram(id, "");
                Etapas(id, Valid);
                //$('#etapa_id').html('');
            });



            $(document).on("change", "#etapa_id", function() {
                var id = $("#etapa_id").val();
                var Valid = $("#estatus_s_id").val();
                EstatusTram(id, Valid);
            });

            window.ReloadSeguimieto = function() {
                var id = $("#seguimiento_id").val();
                var Eid = $("#etapa_id").val();
                var Esid = $("#copia_id_tramite").val();
                Etapas(id, Eid);
                EstatusTram(Eid, Esid);
                //console.log("reload",Esid)
            }
            ReloadSeguimieto();


        });
    </script>