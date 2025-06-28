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
<section class="container">

    <?php
    $data["typeController"] = "AUTOSC";
    $this->load->view("popup/popupSiniestros", $data);
    ?>
    <?= $this->load->view('_parts/sidemenu2', array("tipo" => $tipo)); ?>

    <div style="float: left; width: 90%;">
        <div class="panel panel-default">
            <div class="panel-body">
                <div class="row">
                    <div class="col-sm-2">
                        <label>Buscar </label>
                        <input type="text" placeholder="Buscar..." id="txSearch" class="form-control input-sm" name="search" />
                    </div>
                    <div class="col-sm-2">
                        <label>Año</label>
                        <select class="form-control input-sm" id="year" name="2">

                        </select>
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
                        <label>Tipo tramite </label><br>
                        <select id="Tramites_Autos" class="form-control" name="10">
                            <option value="">Todos</option>
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
                        <label>Estatus tramite </label>
                        <select class="form-control input-sm" id="cbEstado_2" name="7">
                            <option value="">Todos</option>
                            <option value="N/A">N/A</option>
                        </select>
                    </div>
                </div>
                <div class="row">
                    <div class="col-sm-4" style="margin-top: 30px;">
                        <!--  <label id="last_update"> Última actualización: ${label} </label> -->
                    </div>
                    <div class="col-md-8 text-right" style="margin-top: 10px;">
                        <button class="js-Cargar btn btn-primary hidden">Cargar documento</button>
                        <button id="Excel" class="btn btn-primary">Generar Excel</button>
                        <button class="js-Actualizar btn btn-primary">Actualizar tabla</button>
                        <a href="<?= base_url() ?>Siniestros/RegistroAutosC" class="btn btn-primary Nuevo">Nuevo siniestro</a>
                        <button class="js-NewSiniestro btn btn-primary hidden">Nuevo siniestro</button>
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

<!-- modal add seguimiento -->
<div class="modal fade" id="modal_seguimiento_add" tabindex="-1" role="dialog" aria-labelledby="modalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title" id="modalLabel">Nuevo seguimiento</h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>

            </div>
            <div class="modal-body">
                <form id="form_add_comentario" name="form_add_comentario" data-toggle="validator" method="POST" action="<?= base_url() ?>Siniestros/NuevoComentario">
                    <div class="row">
                        <dt class="col-sm-12"> <span class="fa fa-info-circle" aria-hidden="true"></span> Nuevo comentario de seguimiento: </dt>
                        <div class="col-md-10">
                            <div class="form-group">
                                <textarea onkeyup="javascript:this.value=this.value.toUpperCase();" class="form-control" name="comentario_s_t" id="comentario_s_t"></textarea>
                                <input type="hidden" name="id_siniestro_c_t" id="id_siniestro_c_t">
                                <input type="hidden" name="id_tramite_c_t" id="id_tramite_c_t">
                                <input type="hidden" name="id_tipotram_c_t" id="id_tipotram_c_t">
                                <input type="hidden" name="id_esttram_c_t" id="id_esttram_c_t">
                                <span id="e_comentario_s_t" class="help-block" style="color:red;"></span>
                            </div>
                        </div>
                        <div class="col-md-2 text-center" style="padding-top:10px;">
                            <button class="btn btn-primary">Guardar</button>
                        </div>
                    </div>
            </div>
            </form>
        </div>
        <!--  <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
                    <button type="submit" class="btn btn-primary">Guardar</button>
            </div> -->
    </div>
</div>
</div>

<!-- modal para ver la info -->
<div class="modal fade" id="modal_gmm" tabindex="-1" role="dialog" aria-labelledby="modalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <!--     <form id="form_cobertura" action="<?= base_url() ?>GMM/AccionesTiposCobertura" method="POST" autocomplete="off"> -->
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
                <h4 class="modal-title" id="modalLabel">Información del registro</h4>
            </div>
            <div class="modal-body" id="test">
                <div class="row">
                    <div class="col-md-12">
                        <ul class="nav nav-tabs">
                            <li id="tab_home" class="active"><a data-toggle="tab" href="#home">Información general</a></li>
                            <li id="tab_Seguimiento"><a data-toggle="tab" href="#seguimiento_G">Seguimiento</a></li>
                        </ul>
                        <div class="tab-content">
                            <div id="home" class="tab-pane fade in active">
                                <dl class="row">
                                    <div class="col-md-12">
                                        <strong>
                                            <span class="fa fa-info-circle" aria-hidden="true"></span>
                                            INFORMACIÓN DEL REGISTRO SELECCIONADO
                                        </strong>
                                    </div>
                                </dl>
                                <dl class="row">
                                    <dt class="col-sm-2 text-right">Num poliza</dt>
                                    <dd class="col-sm-10 text-left" id="poliza">N/A</dd>
                                    <dt class="col-sm-2 text-right">Estatus:</dt>
                                    <dd class="col-sm-10 text-left" id="estatusSiniesto">N/A</dd>
                                    <dt class="col-sm-2 text-right">Aseguradora</dt>
                                    <dd class="col-sm-10 text-left" id="CiaNombre">N/A</dd>
                                    <dt class="col-sm-2 text-right">Ejecutivo</dt>
                                    <dd class="col-sm-4 text-left" id="EjecutNombre">N/A</dd>
                                    <dt class="col-sm-2 text-right">Grupo</dt>
                                    <dd class="col-sm-4 text-left" id="Grupo">N/A</dd>
                                    <dt class="col-sm-2 text-right">Sub Grupo</dt>
                                    <dd class="col-sm-4 text-left" id="SubGrupo">N/A</dd>
                                    <dt class="col-sm-2 text-right">Sub Ramo</dt>
                                    <dd class="col-sm-4 text-left" id="SRamoNombre">N/A</dd>
                                    <dt class="col-sm-2 text-right">Agente</dt>
                                    <dd class="col-sm-10 text-left" id="AgenteNombre">N/A</dd>
                                    <dt class="col-sm-2 text-right">Titular</dt>
                                    <dd class="col-sm-10 text-left" id="NombreCompleto">N/A</dd>
                                    <dt class="col-sm-2 text-right">Num siniestro:</dt>
                                    <dd class="col-sm-4 text-left" id="siniestro_id">N/A</dd>
                                    <dt class="col-sm-2 text-right">Estado:</dt>
                                    <dd class="col-sm-4 text-left" id="estado">N/A</dd>
                                    <dt class="col-sm-2 text-right">Tipo:</dt>
                                    <dd class="col-sm-4 text-left" id="evento">N/A</dd>
                                    <dt class="col-sm-2 text-right">Causa:</dt>
                                    <dd class="col-sm-4 text-left" id="tipo_nombre">N/A</dd>
                                    <dt class="col-sm-2 text-right">Telefono</dt>
                                    <dd class="col-sm-4 text-left" id="Telefono1">N/A</dd>
                                    <dt class="col-sm-2 text-right">Correo</dt>
                                    <dd class="col-sm-4 text-left" id="EMail1">N/A</dd>


                                </dl>
                            </div>
                            <div id="seguimiento_G" class="tab-pane fade">
                                <div class="row" id="contenido_s" style="overflow: auto;max-height: 50vh;">

                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!--  <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
                    <button type="submit" class="btn btn-primary">Guardar</button>
                </div> -->
        </div>
        <!--       </form> -->
    </div>
</div>

<!-- modal para los nuevos tipos de trámite -->
<div class="modal fade" id="modal_new_tramite" tabindex="-1" role="dialog" aria-labelledby="modalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title" id="modalLabeltramite">Nuevo Trámite</h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>

            </div>
            <div class="modal-body">
                <form id="form_add_tramite" name="form_add_tramite" data-toggle="validator" method="POST" action="<?= base_url() ?>Siniestros/postTramite" autocomplete="off">
                    <div class="row">
                        <div class="col-md-12" id="inicio_tramite">
                            <label for="tipo_cobertura">Seleccione un tipo de trámite: </label>
                            <input type="hidden" name="id_siniestro" id="id_siniestro" class="field">
                            <input type="hidden" name="id_tramite" id="id_tramite" class="field">
                            <input type="hidden" name="isEdit" id="isEdit" value="1">
                            <select class="form-control field" name="tipo_tramite_select" id="tipo_tramite_select">
                                <option value="">Seleccione uno</option>
                                <?php foreach ($tramites as $value) : ?>
                                    <option value="<?= $value['id'] ?>"><?= $value['nombre'] ?></option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                        <div class="col-md-12" id="contenido_tramite">
                            <br>
                            NO SE HA SELECCIONADO NINGÚN TRÁMITE
                        </div>
                    </div>
                </form>
            </div>
        </div>
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
                <form id="form_add_update_doc" name="form_add_update_doc" data-toggle="validator" method="POST" action="<?= base_url() ?>Siniestros/updateDocumentos">
                    <div class="row">
                        <div class="col-md-12">
                            <div class="form-group">
                                <label>Seleccione un Trámite</label>
                                <select name="tram_doc" id="tram_doc" class="form-control"></select>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-12">
                            <h5><strong> <span class="fa fa-info-circle" aria-hidden="true"></span> Documentos cargados</strong> </h5>
                        </div>
                    </div>
                    <div class="row" id="doc_cargados">
                        <div style="padding-left:20px"> No hay Documentos</div>
                    </div>
                    <div class="row">
                        <div class="col-md-12">
                            <h5><strong> <span class="fa fa-info-circle" aria-hidden="true"></span> Carga de documentos</strong> </h5>
                        </div>
                    </div>
                    <div class="row" id="doc_anexos">
                        <div style="padding-left:20px"> No se pueden subir Archivos</div>
                    </div>
                    <div class="row text-right" id="doc_anexos">
                        <div class="col-md-12">
                            <button class="btn btn-primary hide" id="btn_save_doc">Guardar</button>
                        </div>
                    </div>
                </form>
            </div>
            <!--  <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
                    <button type="submit" class="btn btn-primary">Guardar</button>
            </div> -->
        </div>
    </div>
</div>


<!-- modal para los documentos-->
<div id="mdPrevies" class="modal moda-preview" tabIndex="-1" role="dialog">
    <div class="modal-dialog" role="document">
        <div class="modal-content" style="width:80vw !important;margin-left: -20vw;">
            <div class="modal-header" id="document_des">
                <a href='' class="pull-right btn-sm" id='frame_dow'><i class="fa fa-2x fa-cloud-download" aria-hidden="true"></i></a>
                <a data-dismiss="modal" aria-label="Close" class="pull-right btn-sm"><i class="fa fa-2x fa-times" aria-hidden="true"></i></a>
            </div>
            <div class="modal-body">
                <iframe src='' style="width:100%;height:90vh;" frameBorder="0" id="frame_doc"></iframe>
            </div>
        </div>
    </div>
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

<!------------- Dennis Castillo [2022-01-17] -------------->
<?php
//var_dump($notes["agentsToAssing"]);
$this->load->view("popup/sinisterNotesModal", $notes);
$this->load->view("popup/sinisterListNotesModal");
?>

<!------------------------------------>

<script src="<?= base_url() ?>assets/gap/js/permisos.js"></script> -->
<script>
    $(document).ready(function() {
        var label = '';
        const $IdNotificacion = $("#N").attr("data-idnotificacion");
        var element = document.querySelector(".pace");
        element.classList.remove("pace-active");
        element.classList.add("pace-inactive");
        //console.log("Notificacion",$idNotificacion);
        var draggableElement = elementoArrastrable($(".pop-up-modal")[0]); //Dennis Castillo [2021-12-09]

        $('body').append('<div id="over" style="display:none;position: absolute;top:0;left:0;width: 100%;height:100%;z-index:2;opacity:0.4;filter: alpha(opacity = 50)"></div>');
        const ModuloSiniestro = new Siniestros({
            classRender: '#siniestro-container',
            AccionNuevo: '.js-NewSiniestro',
            AccionActualizar: '.js-Actualizar',
            AccionEditar: '.js-EditSiniestro',
            AccionVer: '.js-ShowSiniestro',
            AccionCargar: '.js-Cargar',
            callBack: function() {
                console.log("callback");
                //datatable.ajax.reload();
            },
        });
        ModuloSiniestro.init();
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
            console.log("acumulado tipo", acum);
            $("#cbEstado").html();
            $("#cbEstado").html(acum);
            $("#cbEstado_2").html();
            $("#cbEstado_2").html(acum);
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
        SelectAnos();


        //---------------
        //Dennis Castillo [2022-01-18]
        const kpiYear = _years.reduce((acc, curr) => acc += `<li><a class="get-kpi-year" href="javascript: void(0)" data-claim="autos" data-year="${curr.opcion}">${curr.opcion}</a></li>`, ``);
        const yearNow = moment().format("YYYY");
        $(".kpi-dropdown").html(kpiYear + `<li><a class="get-kpi-year" href="javascript: void(0)" data-claim="autos" data-year="${yearNow}">${yearNow}</a></li>`);
        //console.log(kpiYear);
        //----------------

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
            language: {
                url: `${$path}assets/js/espanol.json`
            },
            ajax: {
                url: `${$path}Siniestros/fulldata`,
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
                        "year": $("#year").val()
                    });
                }
            },
            drawCallback: function() {
                document.getElementById("over").style.display = "none";
                document.getElementById("upProgressGeneral").style.display = "none";
                Getpermisos();
            },
            ordering: false,
            regex: true,
            dom: '<"toolbar">rtip ',
            initComplete: function() {
                $('.multiselect-ui').multiselect({
                    nonSelectedText: 'Seleccione',
                    numberDisplayed: 1,
                });
            },
            columns: [{
                    data: 'id',
                    visible: false
                }, {
                    data: 'status_id',
                    width: '150px',
                    orderable: false,
                    render: function(data, type, row) {
                        //console.log(row);
                        //var colorS = color(row.estatusSiniesto);

                        return `
                    <div class="col-md-1 center-aling-items">
                            <div class="card-round" style="background:${row.fecha_fin==null?(row.tram_est_col==null?'#8c8787':row.tram_est_col):row.siniestro_color};">
                                <h6 class="text-uppercase fw-bold text-center" style="padding-top:9px;padding-bottom: 9px;font-size: 9px;color: white !important;">${ row.fecha_fin==null?(row.tram_est_nom==null?'N/A':row.tram_est_nom):row.siniestro_estatus }</h6>
                            </div>
                    </div>`
                    }
                },
                {
                    data: 'nombre',
                    orderable: false,
                    render: function(data, type, row) {
                        return `
                    <div class="row">
                        <div class="col-md-12">
                            <div>
                                <div class="media-body">
                                    <h4 class="media-heading"><strong>Tipo: ${row.sub_evento}, Trámite: ${row.nombre_tramite==null?'N/A':row.nombre_tramite}</strong></h4>
                                    <div class="Siniestro-body">
                                        <div class="box first">Fecha Accidente: ${row.fecha_ocurrencia==null?'N/A':moment(row.fecha_ocurrencia).format("DD/MM/YYYY")}</div>
                                        <div class="box first" style="padding-left: 15px;">Fecha Fin: ${row.fecha_fin==null?'N/A':moment(row.fecha_fin).format("DD/MM/YYYY")}</div>
                                        <div class="box first" style="padding-left: 15px;"> Reporte cabina: ${row.cabina_id}&nbsp;</div>
                                        <div class="box first" style="padding-left: 15px;"> Núm siniestro: ${row.siniestro_id}</div>
                                        ${row.nombre_tramite=='REPARACIÓN'?`<div class="box first" style="padding-left: 15px;"> Estatus Reparación: ${row.Estatus_Reparacion!=""?row.Estatus_Reparacion:"N/A"}</div>`:''}
                                        ${row.nombre_tramite=='PERDIDA TOTAL'?`<div class="box first" style="padding-left: 15px;"> Estatus: ${row.Estatus_P!="undefined"?row.Estatus_P:'N/A'}</div>`:''}
                                        ${row.nombre_tramite=='DETENIDO'?`<div class="box first" style="padding-left: 15px;"> Estatus: ${row.Estatus_D!=""?row.Estatus_D:"N/A"}</div>`:''}
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
                        var colorS = Colorbarra(row.parametro, row.progreso, row.fecha_repote, row.fecha_fin, row.estatusSiniesto);
                        //<span>${row.parametro+"  "+row.estatusSiniesto+"  "+row.progreso}</span>
                        return `
                    <div class="row">
                        <div class="col-md-12">
                            <div class="progressBar">
                                <div class="progressb" style="width: ${colorS.porcentaje}; background-color: ${colorS.color};" data-row="40%">
                                </div>
                                <span>${colorS.mensaje}</span>
                                
                            </div> 
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
                        /* <li><a id='${row.cabina_id}' style="cursor: pointer;" class="js-ShowSiniestro" data-cabina='${row.cabina_id}' data-row='${btoa(unescape(encodeURIComponent(JSON.stringify(row))))}' >Ver</a></li>
                                    ${(row.tipo_actualizacion == "MANUAL" ? `<li><a style="cursor: pointer;" class="js-EditSiniestro" data-row='${btoa(unescape(encodeURIComponent(JSON.stringify(row))))}' >Editar</a></li>` : "")}
                                    <li><a onclick="getDataHistorial(${row.id})" style="cursor: pointer;" data-in-id="${row.id}">Seguimiento</a></li> */
                        var colorS = Colorbarra(row.parametro, row.progreso, row.fecha_repote, row.fecha_fin, row.estatusSiniesto);
                        return `
                        <div style="float: left;font-size: 20px;" class="text-center"><div style="font-size: 12px;"> Duración</div><div style="height: 30px;width: 30px;background-color: ${colorS.color};color:white;border-radius: 50%; display: inline-block;">${colorS.dias}</div><div  style="font-size: 12px;"> Dias </div></div>
                        <div style="text-align: center;">
                            <div class="dropdown">
                                <button class="btn btn-link dropdown-toggle" type="button" id="dp${row.id}" data-toggle="dropdown" aria-haspopup="true" aria-expanded="true" >
                                    <i class="fa fa-ellipsis-v" aria-hidden="true"></i>
                                </button>
                                <ul class="dropdown-menu dropdown-menu-right"  aria-labelledby="dp${row.id}">
                                        <li><a id='${row.cabina_id}' style="cursor: pointer;" class="js-ShowSiniestro" data-idrow='${row.id}' data-cabina='${row.cabina_id}' data-row='${btoa(unescape(encodeURIComponent(JSON.stringify(row))))}' >Ver</a></li>
                                        <li><a class="bn-bono-view"  style="cursor: pointer;" onclick="SeguimientoSiniestro(${row.id},${row.id_tramite},${row.tipo_tramite},${row.tram_estatus})" data-permiso="permiso" data-accion-permiso="Seguimiento" >Seguimiento</a></li>
                                        ${row.fecha_fin==null?`
                                            <li><a class="bn-bono-view"  style="cursor: pointer;" href="${$path}Siniestros/RegistroAutosC/${row.id}"  data-permiso="permiso" data-accion-permiso="Editar">Editar siniestro</a></li>
                                            ${row.tram_close==null && row.id_tramite!=null?`<li><a class="bn-bono-view"  style="cursor: pointer;" onclick="editTramite(${row.id_tramite},${row.tipo_tramite},${row.id})" data-permiso="permiso" data-accion-permiso="Editar-tramite">Editar Trámite</a></li>`:``}
                                            ${row.tram_close=='1'|| row.id_tramite==null ?`<li><a class="bn-bono-view"  style="cursor: pointer;" onclick="openTramite(${row.id})" data-permiso="permiso" data-accion-permiso="Nuevo-tramite" >Nuevo Trámite</a></li>`:``}
                                            ${row.tram_close==null && row.id_tramite!=null ?`<li><a class="bn-bono-view"  style="cursor: pointer;" onclick='ChangeStatusTramite(${row.tram_estatus},${row.id},${row.id_tramite},"${row.tram_ini}","${row.tipo_tramite}" )' data-permiso="permiso" data-accion-permiso="Cambiar-estatus">Cambiar estatus Trámite</a></li>`:``}
                                            ${(row.tram_close!=null||row.id_tramite==null)?`<li><a class="bn-bono-view"  style="cursor: pointer;" onclick='ChangeStatus(${row.status_id},${row.orden},${row.id})' data-permiso="permiso" data-accion-permiso="Cambiar-estatus" >Cambiar estatus Siniestro</a></li>`:``}
                                            
                                       `:`
                                            ${row.fecha_fin!=null ?`<li><a class="bn-bono-view"  style="cursor: pointer;" onclick='Reingreso(${row.id})' data-permiso="permiso" data-accion-permiso="Reingreso" >Reingreso</a></li>`:``}
                                            ${row.tram_close==null && row.id_tramite!=null?`<li><a class="bn-bono-view"  style="cursor: pointer;" onclick="editTramite(${row.id_tramite},${row.tipo_tramite},${row.id})" data-permiso="permiso" data-accion-permiso="Editar-tramite">Editar Trámite</a></li>`:``}
                                            ${row.tram_close==null && row.id_tramite!=null?`<li><a class="bn-bono-view"  style="cursor: pointer;" onclick='ChangeStatusTramite(${row.tram_estatus},${row.id},${row.id_tramite},"${row.tram_ini}","${row.tipo_tramite}" )' data-permiso="permiso" data-accion-permiso="Cambiar-estatus" >Cambiar estatus Trámite r</a></li>`:``}
                                            ${(row.tram_close!=null ||row.id_tramite==null) && row.fecha_fin==null?`<li><a class="bn-bono-view"  style="cursor: pointer;" onclick='ChangeStatus(${row.status_id},${row.orden},${row.id})' data-permiso="permiso" data-accion-permiso="Cambiar-estatus" >Cambiar estatus Siniestro</a></li>`:``}
                                       `}
                                       <li><a class="bn-bono-view Editar"  style="cursor: pointer;"  data-permiso="permiso" data-accion-permiso="Administrar-documentos" onclick="OpenModalDocs(${row.id})">Administrar Documentos</a></li>
                                       <li role="presentation" class="dropdown-header">Notas</li>
                                       <li><a class="bn-bono-view show-notes-modal" data-type="autos corporativo" data-id="${row.id}" data-number="${row.siniestro_id}" data-insured="${row.asegurado_nombre}" data-policy="${row.poliza}" data-type-sinister="${row.sub_evento!=null?row.sub_evento.toUpperCase():'SIN ASIGNAR'}" style="cursor: pointer;" >Generar nota</a></li>
                                       <li><a class="bn-bono-view show-list-notes-modal" data-type="autos corporativo" data-id="${row.id}" style="cursor: pointer;" >Mostrar notas creadas</a></li>
                                </ul>
                            </div>
                        </div>
                    `;
                    }
                },
                {
                    data: 'fecha_ocurrencia',
                    "sClass": "control text-right",
                    visible: false
                },
                {
                    data: 'status_id',
                    "sClass": "control text-right",
                    visible: false
                },
                {
                    data: 'siniestro_estatus',
                    "sDefaultContent": 'N/A',
                    "sClass": "control text-right",
                    visible: false
                },
                {
                    data: 'cliente_id',
                    "sClass": "control text-right",
                    visible: false //tipo_siniestro_id
                },
                {
                    data: 'tipo_siniestro_id',
                    visible: false
                },
                {
                    data: 'tipo_tramite',
                    visible: false
                },
                {
                    data: 'Estatus_Reparacion',
                    visible: false
                },
                {
                    data: 'ano_filtro',
                    visible: false
                },
            ],
            order: [
                [0, 'desc']
            ],


        });

        ///prueba del select React
        /* window.LoadSelect=function(){
            const selectm = new SelectM({
            classRender: '#selectm',
                callBack: function(data) {
                    console.log("info",data);
                    //datatable.ajax.reload();
                },
            });
            selectm.init();
        } */
        $(document).on('change', '#Tipos', function(e) {
            datatable.draw();
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
        ItemsTramitesAutos();

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

        if ($IdNotificacion !== '') {
            datatable.search($IdNotificacion, true, false, true).draw();
            /* setTimeout(function() {
                datatable.search('4903|4903').draw();
            }, 1000); */

        } else {
            // datatable.search($idNotificacion,true, false, true).draw();
            /*  datatable
                 .search("EN TRAMITE")
                 .draw(); */

        }

        //prueba del select 
        
        $(document).on('input', '#txSearch', function(e) {
            datatable.draw();
        });

        //evento del combo de estatus tramites
        $(document).on('change', '#cbEstado', function(e) {
            datatable.draw();
        });

        //evento del ccombo de estatus siniestros
        $(document).on('change', '#cbEstado_2', function(e) {
            datatable.draw();
        });

        $(document).on('change', '#year', function(e) {
            document.getElementById("over").style.display = "block";
            document.getElementById("upProgressGeneral").style.display = "block";
            datatable.draw();
        });

        $(document).on('input', '#cbEstado2', function(e) {
            datatable.draw();
        });

        //evento del inputdate Fecha inicio
        $(document).on('input', '#Finicio', function(e) {
            datatable.draw();
        });

        //evento del inputdate Fecha fin
        $(document).on('input', '#Ffin', function(e) {
            datatable.draw();
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
            console.log("variable", datos);
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
            var FI = moment(fechaI, "YYYY-MM-DD");
            var FF = fechaF == null ? moment() : moment(fechaF, "YYYY-MM-DD");
            var days = FF.diff(FI, 'days');
            var color = {};
            var total = parseFloat(parseInt(days) / parseInt(parametro));
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
            console.log("oinc", oIncid);
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
            console.log('changeStatus', e.currentTarget.value);
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
            console.log("test", oIncid);
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
                    const DocFiles = $(`#${value.name}_input`).prop('files');
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
            console.log("fechatramite" + fecha_inicio, moment(fecha_inicio).format('YYYY-MM-DD'));
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
            console.log("id", id);
            const _array = _Documents;
            const newData = _array.filter((item, index) => item.tramite === id);
            console.log("filter", newData);
            var AcumDocumentos = '';
            newData.forEach((element, key) => {
                var name = element.documento_nom;
                //console.log("fin",element);
                AcumDocumentos += `<div class="col-lg-4">
                            <div class="form-group">
                                <label for="exampleInputEmail1">${element.documento_nom}</label>
                                <input type="file" class="form-control fileD" id="${string_to_slug(name)}_input" name="${string_to_slug(name)}" placeholder="${element.documento_nom}" onchange="listadoc('${string_to_slug(name)}')" multiple />
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
            console.log("filter", newData);
            var AcumDocumentos = '';
            newData.forEach((element, key) => {
                var name = element.documento_nom;
                //console.log("fin",element);
                AcumDocumentos += `<div class="col-lg-4">
                            <div class="form-group">
                                <label for="exampleInputEmail1">${element.documento_nom}</label>
                                <input type="file" class="form-control fileD" id="${string_to_slug(name)}_input" name="${string_to_slug(name)}" placeholder="${element.documento_nom}" onchange="listadoc('${string_to_slug(name)}','ADM')" multiple />
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
                    const DocFiles = $(`#${value.name}_input`).prop('files');
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
            console.log("testIva", val * 0.16);
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
        const MAXIMO_TAMANIO_BYTES = 8000000;
        window.listadoc = function(id, tipo = null) {
            error = [];
            const DocFiles = $(`#${id}_input`).prop('files');
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
                    title: "Algunos archivos exceden el limite de 8 MB",
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



    });
</script>
<script>
    //Dennis Castillo [2022-01-18]
    $(document).on("click", ".get-kpi-year", function() {

        const year = $(this).data("year");
        const claim = $(this).data("claim");
        const baseUrl = $("#base_url").data("base-url");

        $("#dpd-kpi-year").html(year);
        $("#dpd-kpi-year").attr("title", year);
        console.log(year, claim);

        const ajax = $.ajax({
            type: "GET",
            url: `${baseUrl}Siniestros/getKpi`,
            data: {
                year: year
            },
            error: (error) => {
                console.log(error.responseText);
            },
            success: (data) => {
                const response = JSON.parse(data);
                console.log(response);

                if (Object.keys(response).length > 0) {

                    for (const a in response) {

                        const tr = Object.values(response[a]);
                        const td0 = getLabels(a);
                        const allTr = tr.unshift(td0);
                        const stringTr = tr.reduce((acc, curr, idx) => {

                            const class_ = idx > 0 ? `class="text-center"` : ``;
                            acc += `<td ${class_}>${curr}</td>`;
                            return acc;
                        }, ``);
                        $(`.kpi-${td0}`).html(stringTr);
                    }
                }
            }
        });
    });
    //------------------------------
    //Dennis Castillo [2022-01-18]
    const getLabels = (key) => {

        switch (key) {
            case "Finalizado":
                return "Pendientes";
            case "No_Finalizado":
                return "Terminados";
            default:
                return key;
        }
    }
    //------------------------------
</script>
<script src="<?= base_url() . "assets/js/js_elementoArrastrable.js" ?>"></script>
<!--Dennis [2021-12-08] -->
<script src="<?= base_url() . "assets/js/jquery.notesforclaimsmodule.js" ?>"></script>
<!--Dennis [2022-01-18] -->