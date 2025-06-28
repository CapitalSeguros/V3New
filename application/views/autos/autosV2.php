<script src="<?= base_url() ?>/assets/gap/js/jquery.validate.js"></script>
<script src="<?= base_url() ?>/assets/gap/js/Prueba.js"></script>
<style>
    .box.first {
        float: left;
    }

    .card-round {
        border-radius: 5px;
        width: 100px;
        max-width: 100px;
    }

    .help-block {
        color: red;
    }

    .swal-button--confirm {
        background-color: #67439f !important;
    }

    .swal-text {
        color: #472380 !important;
    }

    .events li {
        display: flex;

    }

    .events time {
        position: relative;
        padding: 0 1.5em;
    }

    .events time::after {
        content: "";
        position: absolute;
        z-index: 2;
        right: 0;
        top: 0;
        transform: translateX(50%);
        border-radius: 50%;
        background: #fff;
        border: 1px #472380 solid;
        width: .8em;
        height: .8em;
    }


    .events span {
        padding: 0 1.5em 1.5em 1.5em;
        position: relative;
    }

    .events span::before {
        content: "";
        position: absolute;
        z-index: 1;
        left: 0;
        height: 100%;
        border-left: 1px #ccc solid;
    }

    .events strong {
        display: block;
        font-weight: bolder;
    }

    .events {
        margin: 1em;
        width: 50%;
    }

    .events,
    .events *::before,
    .events *::after {
        box-sizing: border-box;
        font-family: arial;
    }

    .progressBar {
        background-color: lightgrey;
        width: 200px;
        height: 20px;
    }

    .progressb {
        height: 100%;
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

    .tab-tramites {
        overflow: auto;
        max-height: 50vh;
    }

    .maple {
        -webkit-transform: unset !important;
        transform: unset !important;
    }

    .breadcrumb {
        margin-left: auto !important;
    }
</style>
<section class="container-fluid breadcrumb-formularios">
    <a id="N" data-IdNotificacion='<?= $idNotificacion; ?>'></a>
    <div class="row">
        <div class="col-md-6 col-sm-5 col-xs-5">
            <h3 class="titulo-secciones">Autos</h3>
        </div>
        <div class="col-md-6 col-sm-7 col-xs-7 d-flex">
            <?= $breadcrumbs; ?>
        </div>
    </div>
    <hr />
</section>
<section class="container-fluid">
    <?php
    $data["typeController"] = "AUTOSI";
    $this->load->view("popup/popupSiniestros", $data);
    ?>
    <?= $this->load->view('siniestro_catalogo/sidemenuV2', array("tipo" => $tipo)); ?>
    <div style="float: left; width: 90%;">
        <div class="row">
            <div class="form-group col-md-12 text-right">
            </div>
        </div>
        <div class="panel panel-default">
            <!-- <div class="panel-body">
                <table class="table" id="example">
                    <thead>
                        <tr>
                            <th scope="col">Id</th>
                            <th scope="col">Estatus</th>
                            <th scope="col">Tipo</th>
                            <th scope="col">Fecha</th>
                            <th scope="col">EstatusF</th>
                            <th scope="col">Progreso</th>
                            <th style="text-align: center;" scope="col">Acciones</th>
                            <th scope="col">Tipo</th>
                            <th scope="col">Aseguradora</th>
                        </tr>
                    </thead>
                    <tbody>
                    </tbody>
                </table>
            </div> -->
            <div class="panel-body">
                <div class="rectOT">

                </div>
            </div>
        </div>
    </div>

</section>

<div class="modal fade" id="modal_gmm" tabindex="-1" role="dialog" aria-labelledby="modalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <!--     <form id="form_cobertura" action="<?= base_url() ?>GMM/AccionesTiposCobertura" method="POST" autocomplete="off"> -->
        <div class="modal-content" style="width:80vw !important;margin-left: -20vw;">
            <div class="modal-header">
                <h4 class="modal-title" id="modalLabel">Información del registro</h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body" id="test">
                <div class="row">
                    <div class="col-md-12">
                        <ul class="nav nav-tabs">
                            <li id="tab_home" class="active"><a data-toggle="tab" href="#home">Información general</a></li>
                            <li id="tab_tramite"><a data-toggle="tab" href="#menu1">Tramites</a></li>
                            <li id="tab_Seguimiento"><a data-toggle="tab" href="#seguimiento_G">Seguimiento</a></li>
                        </ul>
                        <div class="tab-content">
                            <div id="home" class="tab-pane fade in active">
                                <!--   <dl class="row">
                                        <div class="col-md-12">
                                            <strong>
                                            <span class="fa fa-info-circle" aria-hidden="true"></span>
                                            INFORMACIÓN DEL REGISTRO SELECCIONADO
                                            </strong>
                                        </div>
                                    </dl>  -->
                                <dl class="row">
                                    <dt class="col-sm-12"> <span class="fa fa-info-circle" aria-hidden="true"></span> DATOS DE LA PÓLIZA: </dt>
                                    <dt class="col-sm-2 text-right">Titular</dt>
                                    <dd class="col-sm-10 text-left" id="NombreCompleto">N/A</dd>
                                    <dt class="col-sm-2 text-right">Num poliza</dt>
                                    <dd class="col-sm-10 text-left" id="Documento">N/A</dd>
                                    <dt class="col-sm-2 text-right">Desde:</dt>
                                    <dd class="col-sm-4 text-left" id="FDesde">N/A</dd>
                                    <dt class="col-sm-2 text-right">Hasta:</dt>
                                    <dd class="col-sm-4 text-left" id="FHasta">N/A</dd>
                                    <!--  <dt class="col-sm-2 text-right">Estatus:</dt>
                                        <dd class="col-sm-2 text-left" id="Status_TXT">N/A</dd> -->
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
                                    <dt class="col-sm-12"> <span class="fa fa-info-circle" aria-hidden="true"></span> DATOS DEL SINIESTRO: </dt>
                                    <dt class="col-sm-2 text-right">Num siniestro:</dt>
                                    <dd class="col-sm-4 text-left" id="siniestro_id">N/A</dd>
                                    <dt class="col-sm-2 text-right">Estado:</dt>
                                    <dd class="col-sm-4 text-left" id="estado">N/A</dd>
                                    <dt class="col-sm-2 text-right">Tipo:</dt>
                                    <dd class="col-sm-4 text-left" id="tipo_siniestro_nombre">N/A</dd>
                                    <dt class="col-sm-2 text-right">Causa:</dt>
                                    <dd class="col-sm-4 text-left" id="causa_nombre">N/A</dd>
                                    <dt class="col-sm-2 text-right">Telefono:</dt>
                                    <dd class="col-sm-4 text-left" id="Telefono1">N/A</dd>
                                    <dt class="col-sm-2 text-right">Correo:</dt>
                                    <dd class="col-sm-4 text-left" id="EMail1">N/A</dd>
                                    <dt class="col-sm-2 text-right">Vehiculo:</dt>
                                    <dd class="col-sm-4 text-left" id="vehiculo">N/A</dd>
                                    <dt class="col-sm-2 text-right">Serie:</dt>
                                    <dd class="col-sm-4 text-left" id="serie">N/A</dd>
                                    <dt class="col-sm-2 text-right">Lugar del Accidente:</dt>
                                    <dd class="col-sm-4 text-left" id="lugar">N/A</dd>
                                    <dt class="col-sm-2 text-right">Afectado/Responsable:</dt>
                                    <dd class="col-sm-4 text-left" id="afectado">N/A</dd>

                                    <dt class="col-sm-12"> <span class="fa fa-info-circle" aria-hidden="true"></span>DATOS DEL COORDINADOR: </dt>
                                    <!--  <dd class="col-sm-6 text-left" id="evento"></dd> -->
                                    <dt class="col-sm-2 text-right">Nombre</dt>
                                    <dd class="col-sm-10 text-left" id="nombre_coordinador">N/A</dd>
                                    <dt class="col-sm-2 text-right">Telefono</dt>
                                    <dd class="col-sm-2 text-left" id="telefono_coordinador">N/A</dd>
                                    <dt class="col-sm-1 text-right">Correo</dt>
                                    <dd class="col-sm-3 text-left" id="correo_coordinador">N/A</dd>
                                </dl>
                            </div>
                            <div id="menu1" class="tab-pane fade">
                                <div class="row">
                                    <div class="col-md-12 hide" id="contenido" style='overflow:auto; max-height: 50vh;'>
                                    </div>
                                    <div class="col-md-12 hide text-center" id="No_tramites">
                                        NO HAY TRÁMITES DISPONIBLES
                                    </div>
                                    <div class="col-md-12">
                                        <div style="float:right !important;">
                                            <nav aria-label="Page navigation">
                                                <ul class="pagination" id="paginacion">

                                                </ul>
                                            </nav>
                                        </div>
                                    </div>
                                </div>
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
<!-- modal seguimiento -->
<div class="modal fade" id="modal_seguimiento" tabindex="-1" role="dialog" aria-labelledby="modalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title" id="modalLabel">Seguimiento</h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="row" id="body_seguimiento">

                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
            </div>
        </div>
    </div>
</div>

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
                <form id="form_add_comentario" name="form_add_comentario" data-toggle="validator" method="POST" action="<?= base_url() ?>Autos/NuevoComentario">
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
                <form id="form_add_tramite" name="form_add_tramite" data-toggle="validator" method="POST" action="<?= base_url() ?>Autos/postTramite" autocomplete="off">
                    <div class="row">
                        <div class="col-md-12" id="inicio_tramite_select">
                            <label for="tipo_cobertura">Seleccione un tipo de trámite: </label>
                            <input type="hidden" name="id_siniestro" id="id_siniestro" class="field">
                            <input type="hidden" name="id_tramite" id="id_tramite" class="field">
                            <select class="form-control field" name="tipo_tramite_select" id="tipo_tramite_select">
                                <option value="">Seleccione uno</option>
                                <?php foreach ($tramites as $value): ?>
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
                <form id="form_add_update_doc" name="form_add_update_doc" data-toggle="validator" method="POST" action="<?= base_url() ?>Autos/updateDocumentos">
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

<div id="upProgressModal" style="display:none;" role="status" aria-hidden="true">
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

<!-------------------------------------------------------->

<script src="<?= base_url() ?>assets/gap/js/permisos.js"></script>
<script>
    $(document).ready(function() {

        //Iniciamos el componente 
        const path = $("#base_url").attr("data-base-url");
        const $pathServicio = $("#urlAPI").val();
        const CapturaC = new AutosComponente({
            classRender: '.rectOT',
            UrlServicio: $pathServicio,
            UrlPagina: path,
            Tipo: 1,
            callbackSuccess: (Tipo, Obj) => {
                DoActions(Tipo, Obj)
            },
        });
        CapturaC.init();

        window.DoActions = function(Tipo = null, Variables = null) {
            switch (Tipo) {
                case 1: //Accion para ver la información
                    //CapturaC.ReloadData(null);
                    Ver(Variables.Id);
                    break;
                case 2: //Accion para seguimiento
                    SeguimientoSiniestro(Variables.Id, Variables.id_tramite, Variables.tipo_tramite, Variables.tram_estatus);
                    break;
                case 3: //Editar tramite
                    editTramite(Variables.id_tramite, Variables.tipo_tramite);
                    break;
                case 4: //open tramite
                    openTramite(Variables.Id);
                    break;
                case 5: //Cambiar estatus
                    ChangeStatusTramite(Variables.tram_estatus, Variables.Id, Variables.id_tramite, Variables.tram_ini, Variables.tipo_tramite);
                    break;
                case 6: //Cambiar estatus del siniestro
                    //console.log("inicio_ajuste",Variables.inicio_ajuste)
                    ChangeStatus(Variables.status_id, Variables.orden, Variables.Id, Variables.inicio_ajuste);
                    break;
                case 7: //Reingreso
                    Reingreso(Variables.Id);
                    break;
                case 8:
                    OpenModalDocs(Variables.Id);
                    break;
                default:
                    alert('Acccion No definida')
                    break;
            }
        }

        if ($(".pop-up-modal")[0]) {
            var draggableElement = elementoArrastrable($(".pop-up-modal")[0]); //
        }
        //Dennis Castillo [2021-12-09]
        $('body').append('<div id="over" style="display:none;position: absolute;top:0;left:0;width: 100%;height:100%;z-index:2;opacity:0.4;filter: alpha(opacity = 50)"></div>');
        const $path = $("#base_url").attr("data-base-url");
        const titulos = ["Aviso", "Reporte de aseguradora", "Visita", "Documentacion", "Determinacion de perdidas", "Cuantificacion de peridas", "Conciliacion", "Ajuste", "Firma de convenio", "Recepcion de pago"]

        window.SelectEstatus = function() {
            var option = '<option value="">Todos</option><option value="N/A">N/A</option>';
            _estatus.forEach((element, key) => { //${element.id==1?"selected":''}
                option += `<option value="${element.nombre}" >${element.nombre}</option>`;
            });
            return option;
        }

        window.SelectAnos = function() {
            var option = '<option value="0">Todos</option>';
            var actualy = moment().format('YYYY');
            _years.forEach((element, key) => { //${element.id==1?"selected":''}
                option += `<option value="${element.opcion}" >${element.opcion}</option>`;
            });
            return option;
        }

        //---------------
        //Dennis Castillo [2022-01-17]
        const kpiYear = _years.reduce((acc, curr) => acc += `<li><a class="get-kpi-year" href="javascript: void(0)" data-claim="autos" data-year="${curr.opcion}">${curr.opcion}</a></li>`, ``);
        $(".kpi-dropdown").html(kpiYear);
        //console.log(kpiYear);
        //----------------

        /* window.SelectPath=function(){
            var id=$('cbEstado').val();
            //console.log('id',id);
            return id!=''?`${$path}Autos/getAutos?id:${id}`:`${$path}Autos/getAutos`;
        } */


        const $IdNotificacion = $("#N").attr("data-IdNotificacion");
        //console.log("testIDn",$IdNotificacion);
        if ($IdNotificacion !== '') {
            //datatable.search($IdNotificacion,true, false, true).draw();
            //datatable.columns(0).search($IdNotificacion).draw();

        } else {

        }

        $('.multiselect-ui').multiselect({
            nonSelectedText: 'Seleccione',
            numberDisplayed: 1,
        });

        //Metodos del modulo general
        window.Ver = function(id) { //MEtodo para mostrar el modal de visualizacion
            $("#tab_home").addClass("active"); //in active
            $("#home").addClass("in active");
            $("#tab_Seguimiento").removeClass("active");
            $("#tab_tramite").removeClass("active");
            $("#seguimiento_G").removeClass("in active");
            //$("#menu1").removeClass("in active");


            //metdo para obtner los tramites que estan activos
            $.ajax({
                type: 'POST',
                url: `${$path}Autos/getAllTramites`,
                data: {
                    "id": id,
                    //"Tipo":1
                },
                success: async function(data) {
                    //console.log("data",data.data);
                    var seguimiento = data.data.seguimiento;
                    //data normal
                    var dataG = data.data.siniestro[0];
                    Object.keys(dataG).forEach(key => {
                        if (dataG[key] != '') {
                            $(`#${key}`).html(dataG[key]);
                        } else {
                            $(`#${key}`).html("N/A");
                        }
                        //$(`#${key}`).html(dataG[key]);
                        //console.log(key);
                    });
                    //datos generales
                    var dataP = JSON.parse(data.data.siniestro[0].data_poliza);
                    Object.keys(dataP).forEach(key => {
                        if (key == 'FDesde' || key == 'FHasta') {
                            $(`#${key}`).html(moment(dataP[key]).format("DD/MM/YYYY"));
                        } else if (key == 'AgenteNombre') {
                            $(`#${key}`).html('[' + dataP['CAgente'] + '] ' + dataP[key]);
                        } else {
                            if (dataP[key] != '') {
                                $(`#${key}`).html(dataP[key]);
                            } else {
                                $(`#${key}`).html("N/A");
                            }
                            // $(`#${key}`).html(dataP[key]);
                        }

                    });
                    //data del asegurado
                    var dataC = JSON.parse(data.data.siniestro[0].complemento_json);
                    var dataCC = dataC['cordinador'];
                    Object.keys(dataCC).forEach(key => {

                        //$(`#${key}`).html(dataCC[key]);
                        if (dataCC[key] != '') {
                            $(`#${key}`).html(dataCC[key]);
                        } else {
                            $(`#${key}`).html("N/A");
                        }

                    });

                    //otroas datos
                    //var datagg=dataC['general'];
                    var datagg = typeof dataC['general'] !== 'undefined' ? dataC['general'] : {};
                    Object.keys(datagg).forEach(key => {

                        if (datagg[key] != '') {
                            $(`#${key}`).html(datagg[key]);
                        } else {
                            $(`#${key}`).html("N/A");
                        }

                    });
                    var Tramites = data.data.tramites;
                    await SeguimientoGeneral(seguimiento);
                    await FillTramites(Tramites);
                    await $('#modal_gmm').modal('show');
                    //CapturaC.ReloadData(null);();
                },
                error: function(data) {

                }
            });



            return;
        }

        window.SeguimientoGeneral = function(data) {
            var comentarios = '';
            data.forEach((element, key) => {
                var date = moment(element.fecha_add).format('DD-MM-YYYY HH:mm');
                //console.log('date'+date+' , normaldb '+element.fecha_add);
                comentarios += `
                            <div class="col-md-12">
                                    <ul class="media-list">
                                        <div class="media">
                                            <div class="media-body">
                                                <h5 class="media-heading"><small class="statuscomentario">
                                                <strong><i class="fa fa-user" aria-hidden="true"></i>&nbsp;
                                                ${element.name_complete}</strong></small> 
                                                <small class="text-muted pull-right">${date} <i class="fa fa-clock-o" aria-hidden="true"></i>&nbsp;</small>
                                                ${element.tram_nombre==null?'':`<div class="pull-right" style="padding-left:30px;">Trámite: ${element.tram_nombre}</div>`}
                                                </h5>
                                                <p class="pull-right"><span class="label" style="background-color:${element.color==null?'#ABAEB2':element.color}">${element.nombre==null?'comentario':element.nombre}</span></p><small><p>${element.comentario}</p></small>
                                            </div>
                                        </div>        
                                    </ul>
                                </div>
                        `;
            });
            if (comentarios == '') {
                comentarios = '<div class="col-md-12 text-center">NO HAY REGISTROS</div>';
            }
            $("#contenido_s").html('');
            $("#contenido_s").html(comentarios);
            //console.log('general',comentarios);
        }

        window.FillTramites = async function(data) {
            var acumTra = '';
            if (data.length > 0) {
                $("#contenido").removeClass('hide');
                $("#No_tramites").addClass('hide');
            } else {
                $("#No_tramites").removeClass("hide");
                $("#contenido").addClass('hide');
            }
            data.forEach((element, key) => {
                var valores = JSON.parse(element.info.valores);
                var val = '';
                var dcc = '';
                Object.keys(valores).forEach(key => {
                    val += `<div class="col-md-4"><h5><strong>${key=="Porcentaje_Danos"?"Porcentaje Daños":key.replace('_',' ').replace('_',' ').replace('_',' ')}</strong></h5>
                                    <div class="form-group">
                                        <div>${valores[key]!=''?valores[key]:'N/A'} ${key=="Porcentaje_Danos"?"%":''}</div>
                                    </div>
                                </div>`;
                });
                //mostramos los documentos
                element.documentos.forEach(elementdc => {
                    dcc += `<div class="col-md-2" id='doc_${elementdc.file_id}'>
                        <div class="form-group" style='text-align:center;'>
                            <i class="fa fa-trash" aria-hidden="true" style='cursor:pointer;font-size:18px;' onclick="delete_doc('${elementdc.file_id}','doc_${elementdc.file_id}')"></i><br/>
                            <a  data-nombre='${elementdc.nombre}' style='cursor:pointer;' data-id='${elementdc.file_id}' class='js-preview-item' >${elementdc.nombre}</a>
                         </div>
                    </div>`;
                });
                var colorS = Colorbarra(element.info.dias, element.info.progreso, element.info.fecha_inicio, element.info.fecha_fin, element.info.nombre);
                acumTra += `<div class="row">
                                    <div class="col-xs-1">
                                        <div class="card-round" style="background:${element.info.color};">
                                            <h6 class="text-uppercase fw-bold text-center" style="padding-top:9px;padding-bottom: 9px;font-size: 9px;color: white !important;">${element.info.nombre}</h6>
                                        </div>
                                    </div>
                                    <div class="col-xs-8" style="padding-left:50px">
                                        <div class="media" style="cursor:pointer;">
                                            <div class="media-body" >
                                                <div  data-toggle="collapse" data-target="#${element.info.id}_${element.info.tipo_tramite}">
                                                    <h4 class="media-heading"><strong>Trámite: ${element.info.tram_nom}</strong></h4>
                                                    <div class="Siniestro-body">
                                                        <div class="box first">Fecha inicio: ${moment(element.info.fecha_inicio).format("DD/MM/YYYY")}</div>
                                                        <div class="box first" style="padding-left: 15px;">Fecha fin: ${element.info.fecha_fin==null?'En curso':moment(element.info.fecha_fin).format("DD/MM/YYYY")}</div>
                                                        <div class="box first" style="padding-left: 15px;">Folio cia: ${element.info.folio_cia==null?'N/A':element.info.folio_cia}</div><br>
                                                        
                                                    </div><br>
                                                    
                                                </div>
                                            </div>
                                        </div>  
                                    </div>

                                    <div class="col-xs-3">
                                        <div style="float: right;font-size: 20px;" class="text-center">
                                            <div style="font-size: 12px;"> Duración</div>
                                            <div style="height: 30px;width: 30px;background-color: ${colorS.color};color:white;border-radius: 50%; display: inline-block;">${colorS.dias}</div>
                                            <div  style="font-size: 12px;"> Dias </div>
                                        </div>
                                    </div>

                                    <div class="col-xs-12">
                                        <div id="${element.info.id}_${element.info.tipo_tramite}" class="collapse Siniestro-body">
                                            <div class="row">
                                                <div class="col-md-12"> <h5><strong> <span class="fa fa-info-circle" aria-hidden="true"></span> Registro de valores</strong> </h5></div>
                                                ${val}
                                                <div class="col-md-12"> <h5><strong> <span class="fa fa-info-circle" aria-hidden="true"></span> Documentos</strong> </h5></div>
                                                ${dcc==''?' <div class="col-md-2">Sin documentos adjuntos</div>':dcc}
                                            </div>


                                        </div>
                                        
                                    </div>
                                    
                                </div>`;
                //console.log(contenido);
                $("#contenido").html('');
                $("#contenido").html(acumTra);
            });
        }

        window.color = function(data) {
            var color = "";
            switch (data) {
                case "ACTIVO":
                    color = "#149EF7";
                    break;
                case "PENDIENTE":
                    color = "#FFA301";
                    break;
                case "RECHAZADO":
                    color = "#f44343";
                    break;
                case "FINIQUITADO":
                    color = "#2cb922";
                    break;
                case "DESISTIMIENTO":
                    color = "#eccf0e";
                    break;
                case "DORMIDO":
                    color = "#8c8787";
                    break;
                default:
                    color = "#B0AEA9";
                    break;
            }
            return color;
        };

        window.Colorbarra = function(parametro, progreso, fechaI, fechaF, estado) {
            var FI = moment(fechaI, "YYYY-MM-DD");
            var FF = fechaF == null ? moment() : moment(fechaF, "YYYY-MM-DD");
            var days = FF.diff(FI, 'days');
            //console.log("days",days);
            var color = {};
            var total = parseFloat(parseInt(days) / parseInt(parametro));
            if (estado == "LIQUIDADO" || estado == "FINALIZADO" || estado == "FINIQUITADO") {
                color = {
                    color: Colores(total),
                    porcentaje: "100%",
                    mensaje: `Se ha liquidado el trámite en ${days} dias`,
                    dias: days
                };
            } else if (estado == 'RECHAZADO') {
                color = {
                    color: "#472380",
                    porcentaje: "100%",
                    mensaje: 'Se ha rechazado el trámite',
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

        window.SeguimientoSiniestro = function(id, id_tram, tipo_tram, est_tram) {
            $('#id_siniestro_c_t').val(id);
            $('#id_tramite_c_t').val(id_tram);
            $('#id_tipotram_c_t').val(tipo_tram);
            $('#id_esttram_c_t').val(est_tram);
            $('#modal_seguimiento_add').modal('show');
        }

        window.editTramite = function(id, tipo) {
            $.ajax({
                type: 'POST',
                url: `${$path}Autos/getpartialTramite`,
                data: {
                    tipotramite: tipo,
                    id_tramite: id
                },
                success: function(response) {
                    //console.log(response);
                    $("#inicio_tramite_select").addClass('hidden');
                    $("#id_tramite").val(id);
                    $("#contenido_tramite").html('');
                    $("#contenido_tramite").html(response);
                    $("#salto_tramite").addClass('hidden');

                    var valor = $("#Estatus_Unidad").val();
                    var valor2 = $("#Resultado_Valuacion").val();
                    //console.log("valores", `valor1--> ${valor}, valor2--> ${valor2}`);
                    Validacion1(valor);
                    Validacion2(valor2);
                    DocumentosTramite(tipo.toString());
                    $('#modal_new_tramite').modal('show');
                }
            });
        }

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
                });
            } else {
                $('.validacion_2').each(function(index, value) {
                    $(`#${value.name}`).removeAttr('disabled');
                });
            }
        }

        window.DocumentosTramite = function(id) {
            //console.log("id",id);
            const _array = _Documents;
            const newData = _array.filter((item, index) => item.tramite === id);
            //console.log("filter",newData);
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

            //console.log("filter",AcumDocumentos);
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

        window.openTramite = function(id) {
            $("#id_tramite").val('');
            $("#id_siniestro").val(id);
            $("#form_add_tramite").attr('action', $path + 'Autos/postTramite');
            $("#tipo_tramite_select").val('');
            $("#contenido_tramite").html('');
            $("#inicio_tramite_select").removeClass('hidden');
            $("#salto_tramite").removeClass('hidden');
            $("#contenido_tramite").html("<br> NO SE HA SELECCIONADO NINGÚN TRÁMITE");
            $('#modal_new_tramite').modal('show');
            //Validacion1('');
            //Validacion2('');
        }

        $(document).on('change', '#tipo_tramite_select', function(e) {
            //console.log("test",$('#Tipos option:selected').toArray().map(item => item.value).join('|'));
            var optSelect = $('#tipo_tramite_select').val();
            var id_siniestro = $('#id_siniestro').val();
            //document.getElementById("over").style.display = "block";
            //document.getElementById("upProgressGeneral").style.display = "block";
            if (optSelect != "") {
                $.ajax({
                    type: 'POST',
                    url: `${$path}Autos/getpartialTramite`,
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
                        $.ajax({
                            type: 'POST',
                            url: `${$path}Autos/ChangeEstatusTramite`,
                            data: {
                                "estatus": val,
                                "comentario": com,
                                "id_siniestro": idSiniestro,
                                "fecha_fin": fecha,
                                "id_tramite": idtramite,
                                "tipo_tram": tipo_tram
                            },
                            success: function(data) {
                                CapturaC.ReloadData(null);
                                toastr.success("Se cambio el estatus");

                            },
                            error: function(data) {

                            }
                        });

                    } else {
                        toastr.error("Seleccione un status");
                        ChangeStatusTramite();
                    }
                    //alert(value);
                }
            });

            $(".swal-text").html('');
            $(".swal-text").html(contenido);
            /*  $('#modal_status').modal('show'); */
            ///swal-text
        }

        window.ChangeStatus = function(id, orden, idSiniestro, inicio_ajuste) {
            /* const _tablaR = datatable.rows().data();
            const oIncid = _.find(_tablaR, function(it) {
                return it.id == idSiniestro;
            }); */
            var valores = '<select class="form-control" name="sweet_s" id="sweet_s"><option value="0">Seleccione una opción</option>';
            _estatus.forEach((element, key) => { //${id==element.id||orden>=element.orden?'disabled':''}
                valores += `<option value="${element.id}" >${element.nombre}</option>`;
            });
            valores += '</select>';
            var IsFechaFin = `<div class="col-lg-12 hidden" id="cont_val">
                                <div class="form-group">
                                    <label for="exampleInputEmail1">Fecha fin</label>
                                    <input type="date" class="form-control" id='fecha_fin' min=${moment(inicio_ajuste/* oIncid["inicio_ajuste"] */).format('YYYY-MM-DD')} max=${moment().format('YYYY-MM-DD')}>
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
                                <textarea name="comentario_est" id="comentario_est" class="form-control"></textarea>
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
                        document.getElementById("upProgressModal").style.display = "block";
                        $.ajax({
                            type: 'POST',
                            url: `${$path}Autos/ChangeEstatus`,
                            data: {
                                "estatus": val,
                                "comentario": com,
                                "id_siniestro": idSiniestro,
                                "fecha_fin": fecha
                            },
                            success: function(data) {
                                //CapturaC.ReloadData(null);();
                                CapturaC.ReloadData(null);
                                toastr.success("Se cambio el estatus");

                            },
                            error: function(data) {

                            }
                        });
                        document.getElementById("over").style.display = "none";
                        document.getElementById("upProgressModal").style.display = "none";
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
            $("#id_siniestro").val(id);
            $("#tipo_tramite_select").val('');
            $("#contenido_tramite").html('');
            $("#form_add_tramite").attr('action', $path + 'Autos/Reingreso');
            $("#inicio_tramite_select").removeClass('hidden');
            $("#salto_tramite").removeClass('hidden');
            $("#modalLabeltramite").text('Nuevo Trámite de Reingreso');
            $("#contenido_tramite").html("<br> NO SE HA SELECCIONADO NINGÚN TRÁMITE");
            $('#modal_new_tramite').modal('show');

        }

        var arraDocs = [];
        window.OpenModalDocs = function(id) {
            $.ajax({
                type: 'POST',
                url: `${$path}Autos/getAllTramites`,
                data: {
                    "id": id,
                },
                success: async function(data) {
                    //console.log(data.data.tramites);
                    var html = '<option value="0_0">Seleccione uno </option>';
                    arraDocs = data.data.tramites;
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
                //document.getElementById("over").style.display = "block"; 
                //document.getElementById("upProgressModal").style.display = "block";

                var formData = new FormData();
                //console.log('tramite',$("#tipo_tramite").val());
                //id_siniestro_t
                /*  formData.append('id_siniestro', $("#id_siniestro_t").val());
                 formData.append('tipo_tramite', $("#tipo_tramite").val());
                 formData.append('inicio_tramite', $("#inicio_tramite").val());
                 formData.append('descripcion', $("#descripcion").val()); */
                $('.field').each(function(index, value) {
                    formData.append(value.name, $(`#${value.name}`).val());
                    //$(`#${value.name}`).attr('disabled', 'disabled');
                });

                $('.fileD').each(function(index, value) {
                    const DocFiles = $(`#${value.name}_input`).prop('files');
                    for (var i = 0; i < DocFiles.length; i++) {
                        formData.append(DocFiles[i].name + '_' + `(${value.name})`, DocFiles[i]);
                    }
                });

                document.getElementById("over").style.display = "block";
                document.getElementById("upProgressModal").style.display = "block";
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
                            $('#modal_new_tramite').modal('hide');
                            document.getElementById('form_add_tramite').reset();
                            CapturaC.ReloadData(null);
                            //datatable.ajax.reload(null, false);
                            //datatable.ajax.reload();
                        } else {
                            toastr.error(response.message);
                        }
                        //termina la carga del tramite
                        document.getElementById("over").style.display = "none";
                        document.getElementById("upProgressModal").style.display = "none";
                    }
                });

            }
        });

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
                document.getElementById("upProgressModal").style.display = "block";

                var formData = new FormData();
                var fullval = $("#tram_doc").val().split('_');
                //console.log(fullval);
                //id_siniestro_t
                formData.append('id', fullval[0]);
                $('.fileD').each(function(index, value) {
                    //console.log('file',$(`#${value.name}`).prop('files')[0]);
                    //formData.append(value.name, $(`#${value.name}`).prop('files')[0]);
                    const DocFiles = $(`#${value.name}_input`).prop('files');
                    console.log("FIles",DocFiles);
                    for (var i = 0; i < DocFiles.length; i++) {
                        //console.log(`${value.name+'_'+i}`,DocFiles[i]);
                        //formData.append(value.name+'_'+(i+1),DocFiles[i]);
                        formData.append(DocFiles[i].name + '_' + `(${value.name})`, DocFiles[i]);
                    }
                });
                //document.getElementById("over").style.display = "block";
                //document.getElementById("upProgressModal").style.display = "block";
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
                            //datatable.ajax.reload(null, false);
                            //document.getElementById('form_tramite').reset();
                            //datatable.ajax.reload();
                        } else {
                            toastr.error(response.message);
                        }
                        //termina la carga del tramite
                        document.getElementById("over").style.display = "none";
                        document.getElementById("upProgressModal").style.display = "none";
                    }
                });

            }
        });

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
                        url: `${$path}Autos/delete_documento`,
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
        //console.log(year, claim);

        const ajax = $.ajax({
            type: "GET",
            url: `${baseUrl}Autos/getKpi`,
            data: {
                year: year
            },
            error: (error) => {
                console.log(error.responseText);
            },
            success: (data) => {
                const response = JSON.parse(data);
                //console.log(response);

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
<script src="<?= base_url() . "assets/js/js_elementoArrastrable.js" ?>"></script> <!--Dennis [2021-12-08] -->
<script src="<?= base_url() . "assets/js/jquery.notesforclaimsmodule.js" ?>"></script> <!--Dennis [2021-12-17] -->
<!--modal de las aciiones de las tablas-->