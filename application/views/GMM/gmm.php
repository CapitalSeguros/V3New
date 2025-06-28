<script src="<?=base_url()?>/assets/gap/js/jquery.validate.js"></script>
<script src="<?=base_url()?>/assets/gap/js/Prueba.js"></script>
<style>
 .error label{
    color:red;
}
#comentario_s-error{
    color:red;
}
    .box.first {
        float: left;
    }
    .card-round {
        border-radius: 5px;
        width: 100px;
        max-width: 100px;
    }
    .progressBar {
        background-color: lightgrey;
        width: 200px;
        height: 20px;
    }

    .progressb {
        height: 100%;
    }



.swal-button--confirm{
    background-color:#67439f!important;
}

.swal-text{
    color:#472380 !important;
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
        /*  -webkit-transition: 0.3s all;
        -moz-transition: 0.3s all;
        -ms-transition: 0.3s all;
        -o-transition: 0.3s all;
            transition: 0.3s all;*/
    }
    .blocker {
        position: absolute;
        top: 0px;
        left: 0px;
        height: 100%;
        width: 100%;
        /* hacemos que ocupe toda la pantalla a cualquier resolución*/
        z-index: 50;
        /* lo colocamos por encima del resto de componentes*/
        /* background: url(b.png) repeat */
        ;
        /*Color de fondo semitransparente*/
    }
    /**estilos del combo para la busqueda */
    span.multiselect-native-select {
            position: relative
    }
    span.multiselect-native-select select {
        border: 0!important;
        clip: rect(0 0 0 0)!important;
        height: 1px!important;
        margin: -1px -1px -1px -3px!important;
        overflow: hidden!important;
        padding: 0!important;
        position: absolute!important;
        width: 1px!important;
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
    .multiselect-container>li>a>label.radio, .multiselect-container>li>a>label.checkbox {
        margin: 0
    }
    .multiselect-container>li>a>label>input[type=checkbox] {
        margin-bottom: 5px
    }
    .btn-group>.btn-group:nth-child(2)>.multiselect.btn {
        border-top-left-radius: 4px;
        border-bottom-left-radius: 4px
    }
    .form-inline .multiselect-container label.checkbox, .form-inline .multiselect-container label.radio {
        padding: 3px 20px 3px 40px
    }
    .form-inline .multiselect-container li a label.checkbox input[type=checkbox], .form-inline .multiselect-container li a label.radio input[type=radio] {
        margin-left: -20px;
        margin-right: 0
    }

    .dropdown-menu>.active>a,
    .dropdown-menu>.active>a:focus,
    .dropdown-menu>.active>a:hover {
        background-color: #472380 !important;
    }

    .maple {
        -webkit-transform: unset !important;
        transform: unset !important;
    }

    .breadcrumb {
        margin-left: auto !important;
    }
    .maple{
        -webkit-transform:unset !important;
        transform:unset !important;
    }
    .breadcrumb{
        margin-left:auto !important;
    }
    /* Agregado [Suemy][2024-09-06]*/
        .btn-survey:hover {background: #238dd1;color: white;}
        .btn-survey[disabled] {pointer-events: none;cursor: not-allowed;background: #ededed;color: #727272;}
        .label-survey {font-size: 1.3rem;color: white;background: #307c30;padding: 4px 6px;border-radius: 5px;display: grid;justify-content: center;text-align: center;}
        .label-survey > i {font-size: 1.8rem;}
    /**/
</style>

<!-- <link rel="stylesheet" href="<?=base_url()?>assets/gap/css/jquery.filer.css">
<link rel="stylesheet" href="<?=base_url()?>assets/gap/css/jquery.filer-dragdropbox-theme.css"> -->
<section class="container-fluid breadcrumb-formularios">
    <a id="N" data-IdNotificacion='<?= $idNotificacion; ?>'></a>
    <div class="row">
        <div class="col-md-6 col-sm-5 col-xs-5">
            <h3 class="titulo-secciones">GMM (GASTOS MEDICOS MAYORES)</h3>
        </div>
        <div class="col-md-6 col-sm-7 col-xs-7 d-flex">
            <?= $breadcrumbs; ?>
        </div>
    </div>
    <hr />
</section>
<section class="container">

<?php 
    $idPersona = $this->tank_auth->get_idPersona(); //Agregado [Suemy][2024-09-17]
    $email = $this->tank_auth->get_usermail(); //Agregado [Suemy][2024-09-17]
    //Permission
    $permission = 0;
    if ($email == "MESADECONTROL@CAPITALSEGUROS.COM.MX" || $email == "SINIESTROSPERSONAS@AGENTECAPITAL.COM") {
        $permission = 1;
    }

    $data["typeController"] = "GMM";
    $this->load->view("popup/popupSiniestros", $data);
?>

<?= $this->load->view('siniestro_catalogo/sidemenu2', array("tipo" => $tipo)); ?>
    <div style="float: left; width: 90%;">
        <div class="row">
            <div class="form-group col-md-12 text-right">
           <!--  <a href="<?=base_url()?>GMM/RegistroGMM" class="bn-sol-bono btn-primary btn-sm btn pull-right">Nuevo</a> -->
               <!--  <button class="bn-sol-bono btn-primary btn-sm btn pull-right" >Nuevo</button> -->
            </div>
        </div>

        <div class="panel panel-default">
            <div class="panel-body">
                <table class="table" id="example" style='color:#472380 !important;'>
                    <thead>
                        <tr>
                            <th scope="col">Id</th>
                            <th scope="col">Estatus</th>
                            <th scope="col">Tipo</th>
                            <th scope="col">Fecha</th>
                            <th scope="col">EstatusF</th>
                            <th scope="col">Progreso</th>
                            <th style="text-align: center;" scope="col">Acciones</th>
                            <th scope="col">Aseguradora</th>
                            <? if ($permission == 1) { //Agregado [Suemy][2024-09-17] ?>
                                <th>Encuesta</th> <!-- Agregado [Suemy][2024-09-06] -->
                            <? } ?>
                        </tr>
                    </thead>
                    <tbody>
                    </tbody>
                </table>
            </div>
        </div>
    </div>

</section>


<!-- modal para ver la info del siniestro y del tramite -->
<div class="modal fade" id="modal_gmm" tabindex="-1" role="dialog" aria-labelledby="modalLabel" aria-hidden="true">
    <div class="modal-dialog">
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
                                    <dl class="row">
                                        <div class="col-md-12">
                                            <strong>
                                            <span class="fa fa-info-circle" aria-hidden="true"></span>
                                            INFORMACIÓN DE LA PÓLIZA
                                            </strong>
                                        </div>
                                    </dl> 
                                    <dl class="row">
                                        <dt class="col-sm-2 text-right">Num poliza</dt>
                                        <dd class="col-sm-10 text-left" id="Documento">N/A</dd>
                                        <!-- <dt class="col-sm-2 text-right">Inciso</dt>
                                        <dd class="col-sm-4 text-left" id="">N/A</dd> -->
                                        <dt class="col-sm-2 text-right">Desde:</dt>
                                        <dd class="col-sm-2 text-left" id="FDesde">N/A</dd>
                                        <dt class="col-sm-2 text-right">Hasta:</dt>
                                        <dd class="col-sm-2 text-left" id="FHasta">N/A</dd>
                                        <dt class="col-sm-2 text-right">Estatus:</dt>
                                        <dd class="col-sm-2 text-left" id="Status_TXT">N/A</dd>
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
                                        <dt class="col-sm-2 text-right">Num siniestro</dt>
                                        <dd class="col-sm-4 text-left" id="siniestro_id">N/A</dd>
                                        <dt class="col-sm-2 text-right">Inciso</dt>
                                        <dd class="col-sm-4 text-left" id="inciso">N/A</dd>
                                        <dt class="col-sm-2 text-right">Certificado</dt>
                                        <dd class="col-sm-4 text-left" id="certificado">N/A</dd>
                                        <dt class="col-sm-2 text-right">Estado</dt>
                                        <dd class="col-sm-4 text-left" id="estado">N/A</dd>
                                        <dt class="col-sm-2 text-right">Titular</dt>
                                        <dd class="col-sm-10 text-left" id="titular">N/A</dd>
                                        <dt class="col-sm-2 text-right">Afectado</dt>
                                        <dd class="col-sm-4 text-left" id="afectado">N/A</dd>
                                        <dt class="col-sm-2 text-right">Parentesco</dt>
                                        <dd class="col-sm-4 text-left" id="parentesco">N/A</dd>
                                        <dt class="col-sm-2 text-right">Subido por</dt>
                                        <dd class="col-sm-10 text-left" id="responsable">N/A</dd>
                                        <dt class="col-sm-2 text-right">Telefono</dt>
                                        <dd class="col-sm-4 text-left" id="Telefono1">N/A</dd>
                                        <dt class="col-sm-2 text-right">Correo</dt>
                                        <dd class="col-sm-4 text-left" id="EMail1">N/A</dd>
                                        <dt class="col-sm-12"> <span class="fa fa-info-circle" aria-hidden="true"></span> Datos del coordinador: </dt>
                                    <!--  <dd class="col-sm-6 text-left" id="evento"></dd> -->
                                        <dt class="col-sm-2 text-right">Nombre</dt>
                                        <dd class="col-sm-10 text-left" id="nombre_coordinador">N/A</dd>
                                        <dt class="col-sm-2 text-right">Telefono</dt>
                                        <dd class="col-sm-2 text-left" id="telefono_coordinador">N/A</dd>
                                        <dt class="col-sm-1 text-right">Correo</dt>
                                        <dd class="col-sm-3 text-left" id="correo_coordinador">N/A</dd>
                                    </dl>
                                    <div class="row" id="comentario">
                                    <dt class="col-sm-12"> <span class="fa fa-info-circle" aria-hidden="true"></span> Nuevo comentario de seguimiento: </dt>
                                        <form id="form_comentario" name="form_comentario" data-toggle="validator" method="POST" action="<?= base_url()?>GMM/NuevoComentario" >
                                            <div class="col-md-10">
                                                <div class="form-group">
                                                    <textarea onkeyup="javascript:this.value=this.value.toUpperCase();" class="form-control" name="comentario_s" id="comentario_s"></textarea>
                                                    <input type="hidden" name="id_siniestro_c" id="id_siniestro_c">
                                                    <span id="e_comentario_s" class="help-block"></span>
                                                </div>
                                            </div>
                                            <div class="col-md-2 text-center" style="padding-top:10px;">
                                                <button class="btn btn-primary">Guardar</button>
                                            </div>
                                        </form>
                                    </div>
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
                <!-- <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
                    <button type="submit" class="btn btn-primary">Guardar</button>
                </div> -->
            </div>
  <!--       </form> -->
    </div>
</div>
<!-- modal para nuevo tramite -->
<div class="modal fade" id="modal_tramite" tabindex="-1" role="dialog" aria-labelledby="modalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <form id="form_tramite" name="form_tramite" action="<?= base_url() ?>GMM/nuevoTramite" enctype="multipart/form-data" data-toggle="validator" method="POST" autocomplete="off">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title" id="modalLabel">Nuevo trámite</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body" id="test">
                    <div class="row">
                        <div class="col-lg-12">
                            <strong><p style="font-size:12px;">Datos del trámite</p><hr></strong>
                            <input type="hidden" id="id_siniestro_t" name="id_siniestro_t" />
                            <input type="hidden" id="id_tram_t" name="id_tram_t" />
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-4">
                            <div class="form-group">
                                <label for="exampleInputEmail1">Tipo de tramite</label>
                                <select class="form-control" name="tipo_tramite_t" id="tipo_tramite_t" required>
                                    <option value="">Seleccione uno</option>
                                    <?php foreach($reclamo as $value): ?>
                                        <option value="<?=$value['id'] ?>" ><?=$value['nombre'] ?></option>
                                    <?php endforeach; ?>
                                </select>
                               <!--  <span id="e_tipo_tramite" class="help-block"></span> -->
                                <span id="e_tipo_tramite_t" class="error"></span>
                            </div>
                        </div>
                        <div class="col-lg-4">
                            <div class="form-group">
                                <label for="exampleInputEmail1">Cobertura Afectada</label>
                                <select class="form-control" name="riesgo_id_t" id="riesgo_id_t">
                                    <option value="">Seleccione uno</option>
                                    <?php foreach($coberturas as $value): ?>
                                        <option value="<?=$value['id'] ?>" ><?=$value['nombre'] ?></option>
                                    <?php endforeach; ?>
                                    <!-- <option value="">Seleccione uno</option>
                                    <option value="1">Medicinas</option>
                                    <option value="2">GMM en el extrangero</option>
                                    <option value="3">GMM</option> -->
                                </select>
                                <span id="e_riesgo_id_t" class="error"></span>
                            </div>
                        </div>
                        <div class="col-lg-4">
                            <div class="form-group">
                                <label for="exampleInputEmail1">Padecimiento</label>
                                <select class="form-control" name="cobertura_id_t" id="cobertura_id_t">
                                    <option value="">Seleccione uno</option>
                                    <?php foreach($padecimientos as $value): ?>
                                       <!--  <?=$value['id']==isset($registro[0]['cobertura_id'])?'selected':''?> -->
                                        <option value="<?=$value['id'] ?>" ><?=$value['nombre'] ?></option>
                                    <?php endforeach; ?>
                                </select>
                                <span id="e_cobertura_id_t" class="error"></span>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-lg-4">
                            <div class="form-group">
                                <label for="exampleInputEmail1">Folio compañia</label>
                                <input onkeyup="javascript:this.value=this.value.toUpperCase();" type="text" class="form-control" id="folio_cia_t" name="folio_cia_t" placeholder="Folio cia."  />
                                <span id="e_folio_cia_t" class="error"></span>
                            </div>
                        </div>
                        <div class="col-lg-4">
                            <div class="form-group">
                                <?php 
                                    $fecha=date("Y-m-d");
                                ?>
                                <label for="exampleInputEmail1">Fecha inicio</label>
                                <input type="date" class="form-control" id="fecha_i_t" name="fecha_i_t" placeholder="Reclamado" max="<?=$fecha?>"  />
                                <span id="e_fecha_i_t" class="error"></span>
                            </div>
                        </div>
                        <div class="col-lg-12">
                            <div class="form-group">
                                <label for="exampleInputEmail1">Tratamiento</label>
                                <textarea onkeyup="javascript:this.value=this.value.toUpperCase();" name="tratamiento_t" id="tratamiento_t" class="form-control"></textarea>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-lg-12">
                            <strong><p style="font-size:12px;">Registro de valores</p><hr></strong>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-lg-4">
                            <div class="form-group">
                                <label for="exampleInputEmail1">Reclamado</label>
                                <input min="0"  type="number" class="form-control numeric" id="reclamado_t" name="reclamado_t" placeholder="Reclamado" />
                            </div>
                        </div>
                        <div class="col-lg-4">
                            <div class="form-group">
                                <label for="exampleInputEmail1">Deducible</label>
                                <input min="0"  type="number" class="form-control numeric" id="deducible_t" name="deducible_t" placeholder="Deducible"  />
                            </div>
                        </div>
                        <div class="col-lg-4">
                            <div class="form-group">
                                <label for="exampleInputEmail1">Coaseguro</label>
                                <input min="0"  type="number" class="form-control numeric" id="coaseguro_t" name="coaseguro_t" placeholder="Coaseguro"  />
                            </div>
                        </div>               
                    </div>
                    <div class="row">
                        <div class="col-lg-4">
                            <div class="form-group">
                                <label for="exampleInputEmail1">Gastos no Cubiertos</label>
                                <input min="0"  type="number" class="form-control numeric" id="no_cubierto_t" name="no_cubierto_t" placeholder="Gastos no Cubiertos"  />
                            </div>
                        </div>
                        <div class="col-lg-4">
                            <div class="form-group">
                                <label for="exampleInputEmail1">Convenio</label>
                                <input min="0"  type="number" class="form-control numeric" id="convenio_t" name="convenio_t" placeholder="Convenio"  />
                            </div>
                        </div>
                        <div class="col-lg-4">
                            <div class="form-group">
                                <label for="exampleInputEmail1">Retención</label>
                                <input min="0"  type="number" class="form-control numeric" id="retencion_t" name="retencion_t" placeholder="Retención"  />
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-lg-4">
                            <div class="form-group">
                                <label for="exampleInputEmail1">Pagado</label>
                                <input min="0"  type="number" class="form-control numeric" id="pagado_t" name="pagado_t" placeholder="Pagado"  />
                            </div>
                        </div>
                        <div class="col-lg-4">
                            <div class="form-group">
                                <label for="exampleInputEmail1">% Coaseguro</label>
                                <input min="0"  type="number" class="form-control numeric" id="p_coaseguro_t" name="p_coaseguro_t" placeholder="% Coaseguro"  />
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-lg-12">
                            <strong><p style="font-size:12px;">Documentos</p><hr></strong>
                        </div>
                    </div>
                    <div class="row" id='bodyDocumentos'>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
                    <button type="submit" class="btn btn-primary" id="btn_save">Guardar</button>
                    <!-- <button type="submit" class="btn btn-primary">Guardar</button> -->
                </div>
            </div>
        </form>
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
                <form id="form_add_update_doc" name="form_add_update_doc" data-toggle="validator" method="POST" action="<?= base_url()?>GMM/updateDocumentos" >
                    <div class="row">
                        <div class="col-md-12">
                            <div class="form-group">
                                <label>Seleccione un Trámite</label>
                                <select name="tram_doc" id="tram_doc" class="form-control"></select>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-12"> <h5><strong> <span class="fa fa-info-circle" aria-hidden="true"></span> Documentos cargados</strong> </h5></div>
                    </div>
                    <div class="row"  id="doc_cargados">
                       <div style="padding-left:20px"> No hay Documentos</div>
                    </div>
                    <div class="row">
                        <div class="col-md-12"> <h5><strong> <span class="fa fa-info-circle" aria-hidden="true"></span> Carga de documentos</strong> </h5></div>
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

<!-- <div class="js-preview"></div> -->
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

<!------------- Dennis Castillo [2022-01-18] -------------->
<?php 
    //var_dump($notes["agentsToAssing"]);
    $this->load->view("popup/sinisterNotesModal", $notes);
    $this->load->view("popup/sinisterListNotesModal");
?>
 
<!------------------------------------>

<!-- script de la funcion de los permisos -->
<script src="<?=base_url()?>assets/gap/js/permisos.js"></script>
<script>
    $(document).ready(function() {
       if($(".pop-up-modal")[0]){
       var draggableElement = elementoArrastrable($(".pop-up-modal")[0]); //
     }
//Dennis Castillo [2021-12-09]

        $('body').append('<div id="over" style="display:none;position: absolute;top:0;left:0;width: 100%;height:100%;z-index:2;opacity:0.4;filter: alpha(opacity = 50)"></div>');
        const titulos=["Pago directo","Pago vida","Programacion de Ingreso","Programacion de estudios","Programacion de medicamentos","Programacion de reembolsos"];
        const $path = $("#base_url").attr("data-base-url");
        const $IdNotificacion = $("#N").attr("data-IdNotificacion");
        var data_t=[];

       /*  const preview = new FilePreview({
            classRender: ".js-preview",
            site: $path
        });
        preview.init(); */
        
        window.jQuery(document).on('click', '.js-preview-item', function (e) {
            e.preventDefault();
            //$("#document_des").text();
            var id_doc=$(e.currentTarget).data("id");
            //console.log("id_Doc",$(e.currentTarget).data("id"));
            $('#frame_doc').attr('src', `https://docs.google.com/viewer?srcid=${id_doc}&pid=explorer&efh=false&a=v&chrome=false&embedded=true`);
            $('#frame_dow').attr('src', `https://drive.google.com/uc?id=${id_doc}&export=download`);
            $('#mdPrevies').modal('show');
            //preview.show(e.currentTarget.href, e.currentTarget.innerHTML);
        });

        window.SelectEstatus=function(){
            var option='<option value="">Todos</option><option value="N/A">N/A</option>';
            _estatus.forEach((element,key)=>{
                option+=`<option value="${element.nombre}">${element.nombre}</option>`;
            });
            return option;
        }
        window.SelectAnos=function(){
            var option='<option value="0">Todos</option>';
            var actualy=moment().format('YYYY');
            _years.forEach((element,key)=>{//${element.opcion==actualy?"selected":''}
                option+=`<option value="${element.opcion}" >${element.opcion}</option>`;
            });
            return option;
        }

        //---------------
        //Dennis Castillo [2022-01-17]
        const kpiYear = _years.reduce((acc, curr) => acc += `<li><a class="get-kpi-year" href="javascript: void(0)" data-claim="autos" data-year="${curr.opcion}">${curr.opcion}</a></li>`, ``);
        const yearNow = moment().format("YYYY");
        $(".kpi-dropdown").html(kpiYear + `<li><a class="get-kpi-year" href="javascript: void(0)" data-claim="gmm" data-year="${yearNow}">${yearNow}</a></li>`);
        //console.log(kpiYear);
        //----------------

        document.getElementById("over").style.display = "block";
        document.getElementById("upProgressModal").style.display = "block";
        var draw=0;
        const datatable = $('#example').DataTable({ //Modificado [Suemy][2024-09-27]
            language: {
                url: `${$path}assets/js/espanol.json`
            },
            ajax: {
                url: `${$path}GMM/getGMM`,
                type: 'POST',
                data :function (d) {
                    //d.id = $('#cbEstado').val(),
                    //d.year=$('#year').val()
                },
                /*success: (data) => {
                    console.log(data);
                },*/
                dataSrc: 'data'
            },
            drawCallback:function(){
               if(draw==0){
                    draw++;
               }else{
                    $("#over").css("display", "none");
                    $("#upProgressModal").css("display", "none");
                //console.log("callback");
               }
               Getpermisos();
            },
            dom: '<"toolbar">rtip ',
            initComplete: function() {
                   let btnNuevo='';
                if(IDVendVarGlobal==0){
                    btnNuevo=`<div class="col-md-12 text-right" style="margin-top: 10px;"><a class="btn btn-primary" href="<?=base_url()?>GMM/RegistroGMM" data-permiso="permiso" data-accion-permiso = "Nuevo">Nuevo</a></div>`;
                }
                var tmp = `
                <div>
                <div class="row">
                <div class="col-sm-2">
                    <label>Buscar </label>
                    <input type="text" placeholder="Buscar..." id="txSearch" class="form-control input-sm"  name="search"  />
                    </div>   
                <div class="col-sm-2">
                    <label>Estado </label>
                    <select class="form-control input-sm"  id="cbEstado" name="2">
                        ${SelectEstatus()}
                    </select>
                </div>
                <div class="col-sm-2">
                    <label>Fecha inicio </label>
                    <input type="date" class="form-control input-sm"  id="Finicio" />
                </div>
                <div class="col-sm-2">
                    <label>Fecha fin </label>
                    <input type="date" class="form-control input-sm"  id="Ffin" />
                </div>
                <div class="col-sm-2">
                    <label>Aseguradora </label><br>
                    <select id="Aseguradora" class="multiselect-ui form-control" multiple="multiple">
                        ${SelectAseguradoras()}
                    </select>
                </div>
                <div class="col-sm-2">
                    <label>Año</label>
                    <select class="form-control input-sm"  id="year" name="2">
                        ${SelectAnos()}
                    </select>
                </div>
                </div>
                <div class="row">
                    ${btnNuevo}
                </div>
                </div>`;
                $('div.toolbar').html(tmp);
                document.getElementById("over").style.display = "none";
                document.getElementById("upProgressModal").style.display = "none";

                //Asignamos las aseguradoras
                $('.multiselect-ui').multiselect({
                    nonSelectedText:'Seleccione',
                    numberDisplayed:1,
                });
            },/* ,
            fnInitComplete: function( oSettings ) {
                alert( 'DataTables has redrawn the table' );
            }, */
            columns: [
                {
                    data: 'id',
                    visible: false
                },
                {
                    data: 'null',
                    width: '100px',
                    orderable: false,
                    render: function(data, type, row) {
                        //console.log(row);
                        var colorS = color(row.estatus);
                        return `
                    <div class="col-md-1 center-aling-items">
                            <div class="card-round" style="background:${row.color==null?'#8c8787':row.color};">
                                <h6 class="text-uppercase fw-bold text-center" style="padding-top:9px;padding-bottom: 9px;font-size: 9px;color: white !important;">${row.estatus==null?'N/A':row.estatus}</h6>
                            </div>
                            </div>
                        `;
                    }
                },
                {
                    data: null,
                    render: function(data, type, row) {
                        var complemento=JSON.parse(row.complemento_json);
                        //var date=new Date(row.fecha_inicio);
                        //console.log(`date db ${row.fec_tram}, date moment ${moment(row.fecha_inicio).format("DD/MM/YYYY")}`)
                        return `
                    <div class="row">
                        <div class="col-md-12">
                            <div >
                                <div class="media-body">
                                    <h4 class="media-heading"><strong>Tramite: ${row.nombre_tramite==null?'N/A':row.nombre_tramite}</strong></h4>
                                    <div class="Siniestro-body">
                                    <div class="box first">Fecha inicio: ${row.fecha_inicio==null?moment(row.inicio_ajuste).format("DD/MM/YYYY"):moment(row.fecha_inicio).format("DD/MM/YYYY")}</div>
                                        <div class="box first" style="padding-left: 15px;"> Afectado: ${complemento.general['afectado']}</div>
                                        <div class="box first" style="padding-left: 15px;"> Número de siniestro: ${row.siniestro_id}</div>
                                        <div class="box first" style="padding-left: 15px;"> Poliza: ${row.poliza}</div>
                                        <div class="box first" style="padding-left: 15px;"> Folio CIA: ${row.folio_cia==null?'N/A':row.folio_cia}</div>
                                    </div>
                                </div>
                            </div>  
                        </div>
                            </div>
                        `;
                    }
                },
                {
                    data: 'fecha_filtro',
                    visible: false
                },
                {
                    data: 'siniestro_estatus',
                    visible: false
                },
                {
                    data: 'nombre',
                    orderable: false,
                    width: '200px',
                    render: function(data, type, row) {
                        //var colorS = Progresovalues(row.dias, row.estatus, row.progreso);
                        var colorS= Colorbarra(row.dias,row.progreso,row.fecha_inicio,row.fec_tram_F,row.estatus);
                       /*  if(row.id=="5929"){
                            console.log("undefined",`${row.dias+"  "+row.progreso+"  "+row.fecha_inicio+ " "+row.fec_tram_F+ " "+row.estatus}`);
                        } */
                        // window.Colorbarra=function(parametro,progreso,fechaI,fechaF,estado){
                        //ColorDias(row.fec_tram,row.fec_tram_F,row.dias,row.estatus);
                        // <span>${row.dias+"  "+row.estatus+"  "+row.progreso}</span>
                        //<span>${row.dias+"  "+row.progreso+"  "+row.fecha_inicio+ " "+row.fec_tram_F+ " "+row.estatus}</span>
                        return `
                    <div class="row">
                        <div class="col-md-12">
                            <div class="progressBar">
                                <div class="progressb" style="width: ${colorS.porcentaje}; background-color: ${colorS.color};" data-row="40%">
                                </div>
                                <span>${colorS.mensaje}</span>
                            </div> 
                        </div>
                            </div>
                        `;
                    }
                },
                {
                    data: null,
                    "sClass": "control",
                    "sDefaultContent": '',
                    width: '100px',
                    "orderable": false,
                    render: function(data, type, row) {
                        var colorS= Colorbarra(row.dias,row.progreso,row.fecha_inicio,row.fec_tram_F,row.estatus);
                        const permisos=["FINIQUITADO","RECHAZADO"];
                        //console.log("row",row);
                        //<li><a class="bn-bono-view"  style="cursor: pointer;" onclick="SeguimientoSiniestro(${row.id},'')" >Seguimiento</a></li>
                        //<li><a class="bn-bono-view"  style="cursor: pointer;" onclick='ChangeStatus(${row.id_est_tra})' >Cambiar estatus</a></li>
                        /* ${row.siniestro_estatus!="FINIQUITADO"?`
                        <li><a class="bn-bono-view"  style="cursor: pointer;" href="${$path}GMM/RegistroGMM/${row.id}" >Editar siniestro</a></li>
                        ${row.estatus=="FINIQUITADO"|| row.nombre_tramite==null?``:`<li><a class="bn-bono-view"  style="cursor: pointer;" onclick='EditTramite(${row.id})' >Editar trámite</a></li>`}
                        ${row.estatus=="FINIQUITADO"|| row.estatus==null?`<li><a class="bn-bono-view"  style="cursor: pointer;" onclick="Tramite(${row.id})">Nuevo tramite </a></li>`:``}
                        ${row.estatus=="FINIQUITADO"|| row.nombre_tramite==null?``:`<li><a class="bn-bono-view"  style="cursor: pointer;" onclick='ChangeStatus(${row.id_tramite},${row.id_est_tra},${row.orden_tram},${row.id})' >Cambiar estatus</a></li>`}
                        ${row.siniestro_estatus=="ACTIVO"?`<li><a class="bn-bono-view"  style="cursor: pointer;" onclick="CerarSiniestro(${row.id})" >Cerrar Siniestro</a></li>`:''}`
                        :''} */
                        let regresar=`
                        <div style="float: left;font-size: 20px;" class="text-center"><div style="font-size: 12px;"> Duración</div><div style="height: 30px;width: 30px;background-color: ${colorS.color};color:white;border-radius: 50%; display: inline-block;">${colorS.dias}</div><div  style="font-size: 12px;"> Dias </div></div>
                        </div>`;
                        if(IDVendVarGlobal==0){
                            regresar+=`<div style="text-align: center;">
                                <div class="dropdown">
                                    <button class="btn btn-link dropdown-toggle" type="button" id="dp${row.id}" data-toggle="dropdown" aria-haspopup="true" aria-expanded="true">
                                        <i class="fa fa-ellipsis-v" aria-hidden="true"></i>
                                    </button>
                                    <ul class="dropdown-menu" aria-labelledby="dp${row.id}">
                                        <li><a class="bn-bono-view"  style="cursor: pointer;" onclick="Ver(${row.id})" data-permiso="permiso" data-accion-permiso="Ver">Ver</a></li>
                                        
                                        ${row.siniestro_estatus!="FINIQUITADO"?`
                                        <li><a class="bn-bono-view"  style="cursor: pointer;" href="${$path}GMM/RegistroGMM/${row.id}" data-permiso="permiso" data-accion-permiso="Editar">Editar siniestro</a></li>
                                        ${permisos.includes(row.estatus)|| row.nombre_tramite==null?``:`<li><a class="bn-bono-view"  style="cursor: pointer;" onclick='EditTramite(${row.id})' data-permiso="permiso" data-accion-permiso="Editar-tramite" >Editar trámite</a></li>`}
                                        ${permisos.includes(row.estatus)|| row.estatus==null?`<li><a class="bn-bono-view"  style="cursor: pointer;" onclick="Tramite(${row.id})" data-permiso="permiso" data-accion-permiso="Nuevo-tramite">Nuevo tramite </a></li>`:``}
                                        ${/* row.estatus=="FINIQUITADO" */permisos.includes(row.estatus)|| row.nombre_tramite==null?``:`<li><a class="bn-bono-view"  style="cursor: pointer;" onclick='ChangeStatus(${row.id_tramite},${row.id_est_tra},${row.orden_tram},${row.id})' data-permiso="permiso" data-accion-permiso="Cambiar-estatus">Cambiar estatus</a></li>`}
                                        ${row.siniestro_estatus=="ACTIVO"?`<li><a class="bn-bono-view"  style="cursor: pointer;" onclick="CerarSiniestro(${row.id})" data-permiso="permiso" data-accion-permiso="Cerrar-Siniestro">Cerrar Siniestro</a></li>`:''}`
                                        :''}
                                        <li><a class="bn-bono-view Editar"  style="cursor: pointer;"  data-permiso="permiso" data-accion-permiso="Administrar-documentos" onclick="OpenModalDocs(${row.id})" data-permiso="permiso" data-accion-permiso="Administrar-documentos" >Administrar Documentos</a></li>
                                        <li role="presentation" class="dropdown-header">Notas</li>
                                        <li><a class="bn-bono-view show-notes-modal" data-type="gmm" data-id="${row.id}" data-number="${row.siniestro_id}" data-insured="${row.asegurado_nombre}" data-policy="${row.poliza}" data-type-sinister="${row.nombre_tramite==null?'N/A':row.nombre_tramite}" style="cursor: pointer;" >Generar nota</a></li>
                                        <li><a class="bn-bono-view show-list-notes-modal" data-type="gmm" data-id="${row.id}" style="cursor: pointer;" >Mostrar notas creadas</a></li>
                                        ${row.id_tramite!=null ?`<li><a style="cursor: pointer;" onclick="window.open('${$path}documentos/check/${btoa(JSON.stringify({id:row.id,estatus:"prueba"}))}', '_blank')">Validar documentacion </a></li>`:''}
                                    </ul>
                                </div>
                            `;
                            }
                        return regresar;
                    }
                },
                {
                    data: 'aseguradora_id',
                    visible: false
                },
                <? if ($permission == 1) { //Agregado [Suemy][2024-09-17] ?>
                {
                    data: null,
                    orderable: false,
                    render: function(data, type, row) {
                        console.log(data, type, data.siniestro_id);
                        var disabled = "disabled";
                        if (data.encuesta.evidencia != 0) { disabled = ""; }
                        var btn = data.nombre_tramite == "Reembolso" ? `` : `
                            <div style="text-align: center;">
                                <div class="dropdown">
                                    <button class="btn btn-link dropdown-toggle" type="button" id="survey${data.id}" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                        <i class="fa fa-ellipsis-v" aria-hidden="true"></i>
                                    </button>
                                    <ul class="dropdown-menu" aria-labelledby="survey${data.id}">
                                        <li><a class="btn-survey" href='<?=base_url()?>siniestros/archivos_encuesta?pr=<?=$idPersona?>&pz=${data.poliza}&st=${data.siniestro_id}&rm=GMM' target="_blank"><i class="fa fa-cloud-upload"></i> Documento</a></li>
                                        <li><a class="btn-survey" href='<?=base_url()?>siniestros/encuesta_siniestro?pr=<?=$idPersona?>&pz=${data.poliza}&st=${data.siniestro_id}' target="_blank" ${disabled}><i class="fa fa-pencil-square-o"></i> Registrar</a></li>
                                    </ul>
                                </div>
                            </div>`;
                        if (data.encuesta.estatus != 0 && data.encuesta.evidencia != 0) {
                            btn = `<label class="label-survey"><i class="fa fa-check-circle"></i> <span>Hecho</span></label>`;
                        }
                        return btn;
                    }
                },
                <? } ?>
            ],
            "order": [
                [0, 'desc']
            ],
        });
             

        if ($IdNotificacion !== '') {
            //datatable.search($IdNotificacion,true, false, true).draw();
            datatable.columns(0).search($IdNotificacion).draw();

        } else {
               
        }

        $(document).on('change', '#Aseguradora', function(e) {
            //console.log("test",$('#Aseguradora option:selected').toArray().map(item => item.value).join('|'));
            var optSelect=$('#Aseguradora option:selected').toArray().map(item => item.value).join('|');
            datatable.columns(7).search('').draw();
            datatable.columns(7).search(optSelect,true, false).draw();
        });

        $(document).on("input", ".numeric", function() {
            this.value = this.value.replace(/[^0-9.]/g, '').replace(/(\..*?)\..*/g, '$1');
        });

        window.EditTramite=function(id){
            const _data = datatable.rows().data();
            const oInci = _.find(_data, function (it) {
                return it.id == id;
            });
            GetDocuments((oInci.tipo_tramite).toString());//id_siniestro_t
            var valores=JSON.parse(oInci.valores);
            $('#fecha_i_t').prop('disabled', true).val(oInci.fec_tram);
            $('#tratamiento_t').prop('disabled', true).val(oInci.tram_des);
            $('#riesgo_id_t').prop('disabled', true).val(oInci.cobertura_afectada);
            $('#cobertura_id_t').prop('disabled', true).val(oInci.cobertura_id);//tipo_tramite
            $('#tipo_tramite_t').prop('disabled', true).val(oInci.tipo_tramite);
            $('#folio_cia_t').prop('disabled', true).val(oInci.folio_cia);
            $('#id_siniestro_t').val(oInci.id);
            $('#id_tram_t').val(oInci.id_tramite);
            Object.keys(valores).forEach(key =>{
                $(`#${key}_t`).val(valores[key]);
            });
            $("#form_tramite").data('validator').resetForm();
            $('#modal_tramite').modal('show');
            //datos del registro 
            //console.log("Data",oInci);
        }


       

        //funcion para abrir el modal
        window.OpenModal = function() {
            $("#bodyDocumentos").html('');
            $('#modal_tipos').modal('show'); 
            $('input[name=Nombre]').val('');
            $('textarea[name=Descripcion]').val('');
            $('input[name=id]').val('');
        }

        //funcion para editar un registro
        window.Ver = function (id) {
            $("#tab_home").addClass("active");//in active
            $("#home").addClass("in active");
            $("#tab_tramite").removeClass("active");
            $("#tab_Seguimiento").removeClass("active");
            $("#menu1").removeClass("in active");
            $("#seguimiento_G").removeClass("in active");
            $("#seguimiento_G").removeClass("show");
            //console.log("id",id);
            const _data = datatable.rows().data();
            const oInci = _.find(_data, function (it) {
                return it.id == id;
            });
            //console.log("Data",JSON.stringify(oInci));
            //$("#test2").html(JSON.stringify(oInci));
            /* Object.keys(oInci).forEach(key =>{
                if(moment(oInci[key], "YYYY-MM-DD HH:mm:ss", true).isValid()){
                    var date=new Date(oInci[key]);
                    $(`#${key}`).html(moment(date).format("DD/MM/YYYY"));
                }else{
                    $(`#${key}`).html(oInci[key]);
                }
               
            }); */
            //metdo para obtner los tramites que estan activos
             $.ajax({
                type: 'POST',
                url: `${$path}GMM/getAllTramites`,
                async: true,
                data: {
                    "id": id,
                    //"Tipo":1
                },
                success: async function (data) {
                    //console.log("data",data.data);
                    //console.log("poliza",JSON.parse(data.data.siniestro[0].data_poliza));

                    //datos generales del modal ver
                    //var cm=data.data.siniestro[0].siniestro_estatus=='FINIQUITADO'?$("#comentario").hide(): $("#comentario").show();
                    //$('#id_siniestro_c').val(data.data.siniestro[0].id);
                    var seguimiento=data.data.SeguimientoGeneral;
                    //console.log("seguimiento",seguimiento);
                    $("#comentario").hide();
                    $('#estado').html(data.data.siniestro[0].estado);

                    var dataP=JSON.parse(data.data.siniestro[0].data_poliza);
                    Object.keys(dataP).forEach(key =>{
                        if(key=='FDesde'||key=='FHasta'){
                            $(`#${key}`).html(moment(dataP[key]).format("DD/MM/YYYY"));
                        }
                        else{
                            $(`#${key}`).html(dataP[key]);
                        }
                    
                    });
                    //datos corrdinador del modal ver
                    var dataC=JSON.parse(data.data.siniestro[0].complemento_json);
                    //console.log(dataC);
                    var dataGG=dataC['general'];
                    Object.keys(dataGG).forEach(key =>{
                        $(`#${key}`).html(dataGG[key]);
                    });

                    var dataCC=dataC['cordinador'];
                    //console.log(dataCC);
                    Object.keys(dataCC).forEach(key =>{
                        $(`#${key}`).html(dataCC[key]);
                    });
                    
                    var data=data.data.tramites;
                    //console.log("dsds",data);
                    $("#paginacion").html('');
                    if(data.length>0){
                        $("#contenido").removeClass('hide');
                        $("#No_tramites").addClass('hide');
                    }else{
                        $("#No_tramites").removeClass("hide");
                        $("#contenido").addClass('hide');
                    }
                    var acumTra='';
                    data.forEach((element,key) => {
                        const keysVal={"reclamado":"Reclamado","deducible":"Deducible","coaseguro":"Coaseguro","no_cubierto":"Gastos no cubiertos", "convenio":"Convenio","retencion":"Retención","pagado":"Pagado","p_coaseguro":"% Coaseguro"};
                        const kyesCAfectada=["Médicinas","GMM en el extranjero","GMM"];
                        //console.log("valoreshjs", element.info);
                        var valores=JSON.parse(element.info.valores);
                        var val='';var dcc='';
                        /* Object.keys(valores).forEach(key =>{
                            val+=`<div class="box first" style="padding-left: 15px;">${keysVal[key]}: ${valores[key]!=''? `$${valores[key]}`:'N/A'}</div>`;
                        });
                        element.documentos.forEach(elementdc => {
                            dcc+=`<div class="box first" style="padding-left: 15px;cursor:pointer;"><a data-nombre='${elementdc.nombre}' data-id='${elementdc.file_id}' class='js-preview-item' >${elementdc.nombre}</a></div>`;
                        }); */
                        Object.keys(valores).forEach(key =>{
                            val+=`<div class="col-md-2"><h5><strong>${keysVal[key]}</strong></h5>
                                    <div class="form-group">
                                        <div>${valores[key]!=''?`$`+valores[key]:'$0.00'}</div>
                                    </div>
                                </div>`;
                        });
                        element.documentos.forEach(elementdc => {
                            // <i class="fa fa-trash" aria-hidden="true" style='cursor:pointer;font-size:18px;' onclick="delete_doc('${elementdc.file_id}','doc_${elementdc.file_id}')"></i><br/>
                            /* dcc+=`<div class="col-md-2" id='doc_${elementdc.file_id}'>
                                    <div class="form-group" style='text-align:center;'>
                                   
                                    <a  data-nombre='${elementdc.nombre}' style='cursor:pointer;' data-id='${elementdc.file_id}' class='js-preview-item' >${elementdc.nombre}</a>
                                    </div>
                                </div>`; */
                                dcc+=`<div class="col-md-2" id='doc_${elementdc.file_id}'>
                                            <div class="form-group" style='text-align:center;white-space: nowrap;text-overflow: ellipsis;overflow: hidden;'>
                                                <a  data-nombre='${elementdc.nombre}' style='cursor:pointer;' data-id='${elementdc.file_id}' class='js-preview-item' >${elementdc.nombre}</a>
                                            </div>
                                    </div>`;
                        });
                        //var colorS = Progresovalues(element.info.dias, element.info.nombre, element.info.progreso);
                        var colorS=Colorbarra(element.info.dias,element.info.progreso,element.info.fecha_inicio,element.info.fecha_fin,element.info.nombre);
                        //var date=new Date(element.info.fecha_inicio);
                        //var colorB = color("ACTIVO");
                        acumTra+=`<div class="row">
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
                                    <div class="col-xs-2" style="margin-left: -175px;">
                                        <div class="progressBar">
                                            <div class="progressb" style="width: ${colorS.porcentaje}; background-color: ${colorS.color};" data-row="40%">
                                            </div>
                                            <span>${colorS.mensaje}</span>
                                        </div> 
                                    </div>
                                    <div class="col-xs-1" style="margin-left: 80px;">
                                    <div style="float: right;font-size: 20px;" class="text-center"><div style="font-size: 12px;"> Duración</div><div style="height: 30px;width: 30px;background-color: ${colorS.color};color:white;border-radius: 50%; display: inline-block;">${colorS.dias}</div><div  style="font-size: 12px;"> Dias </div></div>
                                    <div class="btnComentario display" style="margin-left: 90px;padding-top: 20px;cursor:pointer;"><div onclick="SeguimientoSiniestro(${element.info.id},'algo')" class="btnItem" data-toggle="tooltip" title="ver comentarios" style="display:inline-block;float: left;"><span class="fa fa-comments fa-lg" aria-hidden="true"></span></div></div>
                                    </div>

                                    <div class="col-xs-12">
                                        <div id="${element.info.id}_${element.info.tipo_tramite}" class="collapse Siniestro-body">
                                            <div class="row">
                                                <div class="col-md-12"> <h5><strong> <span class="fa fa-info-circle" aria-hidden="true"></span> Datos del trámite</strong> </h5></div>
                                                <div class="col-md-2">
                                                    <div class="form-group">
                                                        <h5><strong>Tipo de tramite:</strong></h5>
                                                        <div>${element.info.tram_nom}</div>
                                                    </div>
                                                </div>
                                                <div class="col-md-2">
                                                    <div class="form-group">
                                                        <h5><strong>Cobertura Afectada:</strong></h5>
                                                        <div>${kyesCAfectada[element.info.cobertura_afectada-1]}</div>
                                                    </div>
                                                </div>
                                                <div class="col-md-2">
                                                    <div class="form-group">
                                                        <h5><strong>Padecimiento:</strong></h5>
                                                        <div>${element.info.cobertura_nombre}</div>
                                                    </div>
                                                </div>
                                                <div class="col-md-6">
                                                    <div class="form-group">
                                                        <h5><strong>Tratamiento:</strong></h5>
                                                        <div>${element.info.descripcion}</div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="col-md-12"> <h5><strong> <span class="fa fa-info-circle" aria-hidden="true"></span> Registro de valores</strong> </h5></div>
                                                ${val}
                                            </div>
                                            <div class="row">
                                                <div class="col-md-12"> <h5><strong> <span class="fa fa-info-circle" aria-hidden="true"></span> Documentos</strong> </h5></div>
                                                ${dcc==''?' <div class="col-md-2">Sin documentos adjuntos</div>':dcc}
                                            </div>
                                            ${element.info.nombre!='FINIQUITADO'?`
                                            <div class="row">
                                                <dt class="col-md-12"> <span class="fa fa-info-circle" aria-hidden="true"></span> Nuevo comentario de seguimiento: </dt>
                                                <div class="col-md-12">
                                                    <form id="form_comentario_tramite" name="form_comentario_tramite" data-toggle="validator" method="POST" action="<?= base_url()?>GMM/NuevoComentarioT" >
                                                        <div class="col-md-10">
                                                            <div class="form-group">
                                                                <textarea onkeyup="javascript:this.value=this.value.toUpperCase();" class="form-control" name="comentario_s_t" id="comentario_s_t"></textarea>
                                                                <input type="hidden" name="id_siniestro_c_t" id="id_siniestro_c_t" value="${element.info.id}">
                                                                <span id="e_comentario_s_t" class="help-block" style="color:red;"></span>
                                                            </div>
                                                        </div>
                                                        <div class="col-md-2 text-center" style="padding-top:10px;">
                                                            <button class="btn btn-primary">Guardar</button>
                                                        </div>
                                                    </form>
                                                </div>
                                            </div>`:''}

                                        </div>
                                        
                                    </div>
                                    
                                </div>`;
                    });
                    await $("#contenido").html('');
                    await $("#contenido").html(acumTra);
                    await SeguimientoGeneral(seguimiento);
                    await SeguimientoT();
                    
                     await $('#modal_gmm').modal('show');
                    //console.log('dataVer',data);
                   /*  data_t=data;
                    Clicktramite(0);
                    //console.log(data);
                    var acum='';
                    data.forEach((element,key) => {
                        //console.log("fin",element);
                        
                        acum+=`<li>
                                <a style="cursor:pointer;" onclick="Clicktramite(${key})">${key+1}</a>
                               </li>`;
                    });
                    $("#paginacion").html('');
                    $("#paginacion").html(acum); */
                    //datatable.ajax.reload();
                },
                error: function (data) {

                }
            });

             
        }

        ///select de las aseguradoras
        window.SelectAseguradoras=function(){
            var opt='';
            _Aseguradoras.forEach(element => {
                opt+=`<option value="${element.id}">${element.nombre}</option>`;
            });
            return opt;
        }

        window.SeguimientoGeneral=function(data){
            var comentarios='';
            data.forEach((element,key)=>{
                comentarios+=`
                            <div class="col-md-12">
                                    <ul class="media-list">
                                        <div class="media">
                                            <div class="media-body">
                                                <h5 class="media-heading"><small class="statuscomentario">
                                                <strong><i class="fa fa-user" aria-hidden="true"></i>&nbsp;
                                                ${element.name_complete}</strong></small> 
                                                <small class="text-muted pull-right">${moment(element.fecha_alta).format("DD-MM-YYYY HH:mm")} <i class="fa fa-clock-o" aria-hidden="true"></i>&nbsp;</small>
                                                ${element.nombre==null?'':`<div class="pull-right" style="padding-right: 30px;">Trámite: ${element.nombre}</div>`}
                                                </h5>
                                                <p class="pull-right"><span class="label" style="background-color:${element.color==null?'#ABAEB2':element.color}">${element.estatus_n==null?'comentario':element.estatus_n}</span></p><small><p>${element.comentario}</p></small>
                                            </div>
                                        </div>        
                                    </ul>
                                </div>
                        `;
            });
            if(comentarios==''){
                comentarios='<div class="col-md-12 text-center">NO HAY REGISTROS</div>';
            }
            $("#contenido_s").html('');
            $("#contenido_s").html(comentarios);
            //console.log('general',comentarios);
        }



        window.ChangeStatus=function(id_tramite,id,orden,idSiniestro){
            const _tablaR = datatable.rows().data();
            const oIncid = _.find(_tablaR, function (it) {
                return it.id == idSiniestro;
            });
            
            var valores='<select class="form-control" name="sweet_s" id="sweet_s"><option value="0">Seleccione una opción</option>';
            _estatus.forEach((element,key) => {
                //console.log("fin",element);
                //valores+=`<option value="${element.id}" ${id==element.id||orden>=element.orden?'disabled':''}>${element.nombre}</option>`;
                valores+=`<option value="${element.id}">${element.nombre}</option>`;
            });
            valores+='</select>';
            var IsFechaFin=`<div class="col-lg-12 hidden" id="cont_fecha">
                                <div class="form-group">
                                    <label for="exampleInputEmail1">Fecha fin</label>
                                    <input type="date" class="form-control" id='fecha_fin'  min=${moment(oIncid["fec_tram"]).format('YYYY-MM-DD')} max=${moment().format('YYYY-MM-DD')}>
                                </div>
                            </div>`;
            var contenido=`<div class="row">
                        <div class="col-lg-12">
                            <div class="form-group">
                                <label for="exampleInputEmail1">Estatus</label>
                               ${valores}
                            </div>
                        </div>
                        ${IsFechaFin}
                        <div class="col-lg-12">
                            <div class="form-group">
                                <label for="exampleInputEmail1">Comentario</label>
                                <textarea onkeyup="javascript:this.value=this.value.toUpperCase();" name="comentario_est" id="comentario_est" class="form-control"></textarea>
                            </div>
                        </div>
                        <div class="col-lg-12 hidden" id="cont_val">
                            <form id="from_estatus">
                                <div class="col-lg-12">
                                    Valores del trámite <hr>
                                </div>
                                <div class="col-lg-4">
                                        <div class="form-group">
                                        <label for="exampleInputEmail1">Reclamado</label>
                                        <input min="0"  type="number" class="form-control numeric" id="reclamado_s" name="reclamado" placeholder="Reclamado" />
                                    </div>
                                </div>
                                <div class="col-lg-4">
                                    <div class="form-group">
                                        <label for="exampleInputEmail1">Deducible</label>
                                        <input min="0"  type="number" class="form-control numeric" id="deducible_s" name="deducible" placeholder="Deducible"  />
                                    </div>
                                </div>
                                <div class="col-lg-4">
                                    <div class="form-group">
                                        <label for="exampleInputEmail1">Coaseguro</label>
                                        <input min="0"  type="number" class="form-control numeric" id="coaseguro_s" name="coaseguro" placeholder="Coaseguro"  />
                                    </div>
                                </div>
                                <div class="col-lg-4">
                                    <div class="form-group">
                                        <label for="exampleInputEmail1">Gastos no Cubiertos</label>
                                        <input min="0"  type="number" class="form-control numeric" id="no_cubierto_s" name="no_cubierto" placeholder="Gastos no Cubiertos"  />
                                    </div>
                                </div>
                                <div class="col-lg-4">
                                    <div class="form-group">
                                        <label for="exampleInputEmail1">Convenio</label>
                                        <input min="0"  type="number" class="form-control numeric" id="convenio_s" name="convenio" placeholder="Convenio"  />
                                    </div>
                                </div>
                                <div class="col-lg-4">
                                    <div class="form-group">
                                        <label for="exampleInputEmail1">Retención</label>
                                        <input min="0"  type="number" class="form-control numeric" id="retencion_s" name="retencion" placeholder="Retención"  />
                                    </div>
                                </div>
                                <div class="col-lg-4">
                                    <div class="form-group">
                                        <label for="exampleInputEmail1">Pagado</label>
                                        <input min="0"  type="number" class="form-control numeric" id="pagado_s" name="pagado" placeholder="Pagado"  />
                                    </div>
                                </div>
                                <div class="col-lg-4">
                                    <div class="form-group">
                                        <label for="exampleInputEmail1">% Coaseguro</label>
                                        <input min="0"  type="number" class="form-control numeric" id="p_coaseguro_s" name="p_coaseguro" placeholder="% Coaseguro"  />
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>`;

            swal({
                title: "¿Está seguro de cambiar el estatus del trámite?",
                text: "Una vez eliminado, ¡no podrá recuperar el elemento!",
                icon: "warning",
                //content:"<select><option>TEST</option></select>",
                buttons: ["Cancelar", "Aceptar"],
            }).then((value) => {
                var dta={};
                var val=$("#sweet_s").val();
                var com=$("#comentario_est").val();
                var fecha=$("#fecha_fin").val();
                var values= $('#from_estatus').serializeArray();
                $.each(values,function(key,input){
                    dta[`${input.name}`]=input.value;
                });
                //console.log("dta",dta);
                if (value) {
                    if(val!=0 && com!=''){
                        document.getElementById("over").style.display = "block";
                        document.getElementById("upProgressModal").style.display = "block";
                        $.ajax({
                            type: 'POST',
                            url: `${$path}GMM/ChangeEstatus`,
                            data: {
                                "id": id_tramite,
                                "estatus":val,
                                "comentario":com,
                                "id_siniestro":idSiniestro,
                                "fecha_fin":fecha,
                                "valores":dta
                            },
                            success: function (data) {
                                //datatable.ajax.reload();
                                datatable.ajax.reload(null, false);
                                toastr.success("Se cambio el estatus");
                               
                            },
                            error: function (data) {

                            }
                        });
                        
                    }else{
                        toastr.error("Completa los campos");
                        ChangeStatus(id_tramite,id,orden,idSiniestro);
                    }
                   //alert(value);
                }
            });

            $(".swal-text").html('');
            $(".swal-text").html(contenido);
            
            const _data = datatable.rows().data();
            const oInci = _.find(_data, function (it) {
                return it.id == idSiniestro;
            });
            const jsonVal=JSON.parse(oInci.valores);
            //console.log(jsonVal);
            Object.keys(jsonVal).forEach(key =>{
                //console.log(key+'_s');
                $(`#${key}_s`).val(jsonVal[key]);
            });

            
           /*  $('#modal_status').modal('show'); */
           ///swal-text
        }

        /* $(document).on('input', '#sweet_s', function(e) {
            //console.log('changeStatus',e.currentTarget.value);
            var id=e.currentTarget.value;
            ActualizaValores(id);
        });

        window.ActualizaValores=function(id,data){
            var contenido='';
            const isVal = _.find(_estatus, function (it) {
                return it.id == id;
            });
            if(isVal.valores=='1'){
                $('#cont_val').removeClass("hidden");
            }else{
                $('#cont_val').addClass("hidden");
            }
        } */
        $(document).on('input', '#sweet_s', function(e) {
            console.log('changeStatus',e.currentTarget.value);
            var id=e.currentTarget.value;
            ActualizaValores(id);
        });

        window.ActualizaValores=function(id,data){
            var contenido='';
            const isVal = _.find(_estatus, function (it) {
                return it.id == id;
            });
            if(isVal.valores=='1'){
                $('#cont_val').removeClass("hidden");
                if(_FechaFin){
                    $('#cont_fecha').removeClass("hidden");
                }
            }else{
                $('#cont_val').addClass("hidden");
                $('#cont_fecha').addClass("hidden");
            }
        }



        ///metodos para la edicion e eliminación de los tipos de incidencias
        window.eliminar = function (id) {
            swal({
                title: "¿Está seguro de que quiere eliminar el elemento seleccionado?",
                text: "Una vez eliminado, ¡no podrá recuperar el elemento!",
                icon: "warning",
                buttons: ["Cancelar", "Aceptar"],
            }).then((value) => {
                if (value) {
                    $.ajax({
                        type: 'POST',
                        url: `${$path}GMM/AccionesTiposCobertura`,
                        data: {
                            "id": id,
                            "Tipo":1
                        },
                        success: function (data) {
                            //datatable.ajax.reload();
                        },
                        error: function (data) {

                        }
                    });
                }
            });
        }

        //Muetsra la info de los tramites
        window.Clicktramite=function(data){
            var dta=data_t[data];
            //console.log('data_tClick',data_t);
            $("#tipo_tramite_r").html(titulos[dta.tipo_tramite]);
            $("#fecha_inicio_rt").html(dta.fecha_inicio);
            $("#fecha_fin_rt").html(dta.fecha_fin==null?'En curso':dta.fecha_fin);
            $("#estatus_rt").html(dta.estatus);
            $("#descripcion_rt").html(dta.descripcion);
            var valores=JSON.parse(dta.valores);
            Object.keys(valores).forEach(key =>{
                //console.log('valores',valores[key])
                $(`#${key}_rt`).html(valores[key]!=''?valores[key]:'N/A');
            });
            //$("#fecha_inicio_rt").html(titulos[dta.fecha_fin]);
            /* $("#tipo_tramite_r").html(titulos[data.tipo_tramite]);
            $("#tipo_tramite_r").html(titulos[data.tipo_tramite]); */
        }

        //colores
        window.color = function(data) {
            var color = "";
            switch (data) {
                case "ACTIVO":
                    color = "#149EF7";
                    break;
                case "PENDIENTE":
                    color = "#FFA301";
                    break;
                case "FINALIZADO":
                    color = "#6dca6d";
                    break;
                default:
                    color = "#B0AEA9";
                    break;
            }
            return color;
        };

        //Eventos de los filtros de la vista
        // varioables para el filtro de fechas
        minDateFilter = "";
        maxDateFilter = "";

        //metodo de filtrado por fechas
        $.fn.dataTableExt.afnFiltering.push(
            function(oSettings, aData, iDataIndex) {
                //console.log("adata",aData);
                if (typeof aData._date == 'undefined') {
                    aData._date = new Date(aData[3]).getTime();
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
        //evento del inputdate Fecha inicio
        $(document).on('input', '#Finicio', function(e) {
            minDateFilter = new Date(e.currentTarget.value).getTime();
            datatable.draw();
        });

        //evento del inputdate Fecha fin
        $(document).on('input', '#Ffin', function(e) {
            //maxDateFilter = new Date(e.currentTarget.value).getTime();
            var inputDate=new Date(e.currentTarget.value);
            inputDate.setDate(inputDate.getDate()+1);
            maxDateFilter=inputDate;
            if (minDateFilter > maxDateFilter) {
                swal("Error", "La fecha seleccionada debe de ser mayor", "error");
                $(e.currentTarget).val('');
            } else {
                datatable.draw();
            }
        });

        //evento del combo de estados
        $(document).on('change', '#cbEstado', function(e) {
            datatable
                .columns(1)
                .search(e.currentTarget.value)
                .draw();
        });

        
        $(document).on('change', '#year', function(e) {
            //document.getElementById("over").style.display = "block";
           // document.getElementById("upProgressModal").style.display = "block";
            //datatable.ajax.reload();
            //console.log("valor",e.currentTarget.value);

        });

        
        //evento del input buscar
        $(document).on('input', '#txSearch', function(e) {
            datatable
                .search(e.currentTarget.value)
                .draw();
        });


        window.Tramite=function(data)  {
            $("#id_tram_t").val('');
            GetDocuments(0);
            $("#id_siniestro_t").val(data);
            $('#fecha_i_t').prop('disabled', false);
            $('#tratamiento_t').prop('disabled', false);
            $('#riesgo_id_t').prop('disabled', false);
            $('#cobertura_id_t').prop('disabled', false);//tipo_tramite
            $('#tipo_tramite_t').prop('disabled', false);
            $('#folio_cia_t').prop('disabled', false);
            document.getElementById('form_tramite').reset();
            $('#modal_tramite').modal('show');
        }


        ///agregar nuevo tramite
        $("#form_tramite").validate({
            rules:{
                tipo_tramite_t:{
                    required:true,
                },
                riesgo_id_t:{
                    required:true,
                },
                cobertura_id_t:{
                    required:true,
                },
                fecha_i_t:{
                    required:true,
                },
                folio_cia_t:{
                    required:true,
                }
            },
            messages: {
                tipo_tramite_t:{
                    required:"Seleccione un tipo de tramite.",
                },
                riesgo_id_t:{
                    required:"Seleccione una cobertura.",
                },
                cobertura_id_t:{
                    required:"Seleccione un padecimiento",
                },
                fecha_i_t:{
                    required:"Seleccione una fecha",
                },
                folio_cia_t:{
                    required:"Ingrese un folio",
                }
            },
            errorPlacement: function(error, element) {
                if (error) {
                    //console.log("elemt",element[0].id);
                $(`#e_${element[0].id}`).append(error);
                } else {
                    error.insertAfter(element);
                }
            },
            submitHandler: function(form) {
                //inicio del tramite
                document.getElementById("over").style.display = "block"; 
                document.getElementById("upProgressModal").style.display = "block";

                var formData = new FormData();
                //id_siniestro_t
                formData.append('id_siniestro', $("#id_siniestro_t").val());
                formData.append('tipo_tramite', $("#tipo_tramite_t").val());
                formData.append('inicio_tramite', $("#fecha_i_t").val());
                formData.append('descripcion', $("#tratamiento_t").val());
                //formData.append('inicio_tramite', $("#inicio_tramite_t").val());
                formData.append('riesgo_id', $("#riesgo_id_t").val());
                formData.append('cobertura_id', $("#cobertura_id_t").val());
                formData.append('reclamado', $("#reclamado_t").val());
                formData.append('deducible', $("#deducible_t").val());
                formData.append('coaseguro', $("#coaseguro_t").val());
                formData.append('no_cubierto', $("#no_cubierto_t").val());
                formData.append('convenio', $("#convenio_t").val());
                formData.append('retencion', $("#retencion_t").val());
                formData.append('pagado', $("#pagado_t").val());
                formData.append('p_coaseguro', $("#p_coaseguro_t").val());
                formData.append('folio_cia', $("#folio_cia_t").val());
                formData.append('id_tram', $("#id_tram_t").val());

                //$('#id_siniestro_t').val(oInci.id);
                //$('#id_tram_t').val(oInci.id_tramite);
                /* $('.fileD').each(function(index,value){
                    formData.append(value.name, $(`#${value.name}`).prop('files')[0]);
                }); */
                $('.fileD').each(function(index,value){
                    const DocFiles=$(`#${value.name}`).prop('files');
                    for (var i = 0; i < DocFiles.length; i++) {
                        formData.append(DocFiles[i].name+'_'+`(${value.name})`,DocFiles[i]);
                        //console.log(`${value.name+'_'+i}`,DocFiles[i]);
                        //formData.append(value.name+'_'+(i+1),DocFiles[i]);
                    }
                });

                /* var myfiles = document.getElementById("documentos");
                var files = myfiles.files;
                for (i = 0; i < files.length; i++) {
                    formData.append('file' + i, files[i]);
                } */
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
                        if(response.code==200){
                            toastr.success("Se guardo con éxito.");
                            //datatable.ajax.reload();
                            $('#modal_tramite').modal('hide');
                            datatable.ajax.reload(null, false);
                            document.getElementById('form_tramite').reset();
                        }else{
                            toastr.error(response.message);
                        }
                        document.getElementById("over").style.display = "none"; 
                        document.getElementById("upProgressModal").style.display = "none";   
                    }            
                });
            }
        });

        window.Colorbarra=function(parametro,progreso,fechaI,fechaF,estado){
            var FI=moment(fechaI, "YYYY-MM-DD");
            var FF=fechaF==null?moment():moment(fechaF, "YYYY-MM-DD");
            var days=FF.diff(FI, 'days');
            var color = {};
            var total = parseFloat(parseInt(days) / parseInt(parametro));
            if (estado == "LIQUIDADO" || estado == "FINALIZADO"||estado=="FINIQUITADO") {
                color = {
                    color: Colores(total),
                    porcentaje: "100%",
                    mensaje: `Se ha liquidado el trámite en ${days} dias de ${parametro}.`,
                    dias:days
                };
            }
            else if (estado=='RECHAZADO') {
                color = {
                    color: "#472380",
                    porcentaje: "100%",
                    mensaje: 'Se ha rechazado el trámite',
                    dias:days
                };
            } 
            else if (parametro == null || parametro== undefined) {
                color = {
                    color: "#472380",
                    porcentaje: "0%",
                    mensaje: 'No se tiene ningún indicador relacionado.',
                    dias:isNaN(days)?0:days
                };
            } else {
                if (total >= 0 && total <= 0.40) {
                    color = {
                        color: Colores(total),
                        porcentaje: "30%",
                        mensaje: `Han transcurrido ${days} dias de los ${parametro} del indicador`,
                        dias:days
                    };
                }
                if (total > 0.40 && total <= 0.60) {
                    color = {
                        color: Colores(total),
                        porcentaje: "60%",
                        mensaje: `han transcurrido ${days} dias de los${parametro} del indicador`,
                        dias:days
                    };
                }
                if (total > 0.60 && total < 1) {
                    color = {
                        color: Colores(total),
                        porcentaje: "85%",
                        mensaje: `Han transcurrido ${days} dias de los ${parametro} del indicador`,
                        dias:days
                    };
                }
                if (total >= 1) {
                    color = {
                        color: Colores(total),
                        porcentaje: "100%",
                        mensaje: `Han transcurrido ${days} dias de los ${parametro} del indicador`,
                        dias:days
                    };
                }
            }
            return color;
            
        }
        window.Colores=function(total){
            var color='';
            if (total >= 0 && total <= 0.40) {
                    color="#6dca6d";
                }
                if (total > 0.40 && total <= 0.60) {
                    color="#e8f051";
                }
                if (total > 0.60 && total < 1) {
                    color="#e68d10";
                }
                if (total >= 1) {
                    color="#db311a";
                }
                return color;
        }

        window.Progresovalues = function(parametro, estado, progreso) {
            var total = parseFloat(parseInt(progreso) / parseInt(parametro));
            var color = {};
            if (estado == "LIQUIDADO" || estado == "FINALIZADO"||estado=="FINIQUITADO") {
                color = {
                    color: '#472380',
                    porcentaje: "100%",
                    mensaje: 'Se ha liquidado el trámite'
                };
            }
            else if (estado=='RECHAZADO') {
                color = {
                    color: "#472380",
                    porcentaje: "100%",
                    mensaje: 'Se ha rechazado el trámite'
                };
            } 
            else if (parametro == null) {
                color = {
                    color: "#472380",
                    porcentaje: "0%",
                    mensaje: 'No se tiene ningún indicador relacionado.'
                };
            } else {
                if (total >= 0 && total <= 0.40) {
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

        window.ColorDias=function(inicio,fin,indicador,estatus){
            var FI=moment(inicio, "YYYY-MM-DD");
            var FF=fin==null?moment():moment(fin, "YYYY-MM-DD");
            var trans=FF.diff(FI, 'days');
            var porcentaje=parseFloat(parseInt(trans) / parseInt(indicador));
            //console.log(` dias: ${trans} , porcentaje: ${porcentaje} estatus: ${estatus}`)
            //console.log("DIAS trancurridos",FF.diff(FI, 'days'));
            //var dias=last-inicio;
        }


        //tipos de documentos por cada tramite
        $(document).on('change', '#tipo_tramite_t', function(e) {
            //console.log("valor",e.currentTarget.value);
            var id=e.currentTarget.value;
            GetDocuments(id);
            $('#modal_gmm').modal('handleUpdate'); 
        });

        window.GetDocuments=function(id){
            //console.log(id);
            const _array=_Documents;
            const newData = _array.filter((item, index) => item.tramite === id);
            //console.log("filter",newData);
            var AcumDocumentos='';
            newData.forEach((element,key) => {
            var name=element.documento_nom;
            //console.log("fin",element);
            AcumDocumentos+=`<div class="col-lg-4">
                            <div class="form-group">
                                <label for="exampleInputEmail1">${element.documento_nom}</label>
                                <input type="file" class="form-control fileD" id="${string_to_slug(name)}" name="${string_to_slug(name)}" placeholder="${element.documento_nom}"  multiple='multiple' onchange="listadoc('${string_to_slug(name)}')" />
                                <div id="${string_to_slug(name)}_lista"></div>
                                </div>
                        </div>`;
            });
            if(AcumDocumentos==''){
                AcumDocumentos=`<div class="col-lg-12">
                            <div class="text-center">
                                No se puenden subir Archivos
                            </div>
                        </div>`;
            }
            $("#bodyDocumentos").html('');
            $("#bodyDocumentos").html(AcumDocumentos);
            //$('#modal_gmm').modal('handleUpdate'); 
        }

     /*    window.listadoc=function(id){
            const DocFiles=$(`#${id}`).prop('files');
            console.log(DocFiles.length);
            var content='<ul style="padding-left:20px;">';
            for (var i = 0; i < DocFiles.length; i++) {
                console.log(`doc`,DocFiles[i]);
                content+=`<li>
                            ${DocFiles[i].name}
                        </li>`;
            }
            content+='</ul>';
            $(`#${id}_lista`).html('');
            $(`#${id}_lista`).html(content);
        } */

        window.CerarSiniestro=function(id){
            //console.log("estatus",id_siniestro);
            var valores='<select class="form-control" name="sweet_s" id="sweet_s"><option value="0">Seleccione una opción</option>';
            _Causa .forEach((element,key) => {
                //console.log("fin",element);
                valores+=`<option value="${element.id}">${element.nombre}</option>`;
            });
            valores+='</select>';
            var contenido=` <div class="row">
                        <div class="col-lg-12">
                            <div class="form-group">
                                <label for="exampleInputEmail1">Causa</label>
                               ${valores}
                            </div>
                        </div>
                        <div class="col-lg-12">
                            <div class="form-group">
                                <label for="exampleInputEmail1">Comentario</label>
                                <textarea onkeyup="javascript:this.value=this.value.toUpperCase();" name="comentario_est" id="comentario_est" class="form-control"></textarea>
                            </div>
                        </div>
                    </div>`;

            swal({
                title: "¿Está seguro de cerrar el siniestro?",
                text: "Una vez cerrado, ¡no podrá registrar más trámites!",
                icon: "warning",
                //content:"<select><option>TEST</option></select>",
                buttons: ["Cancelar", "Aceptar"],
            }).then((value) => {
                var val=$("#sweet_s").val();
                var com=$("#comentario_est").val();
                if (value) {
                    if(val!=0 && com!=''){
                        document.getElementById("over").style.display = "block";
                        document.getElementById("upProgressModal").style.display = "block";
                        $.ajax({
                            type: 'POST',
                            url: `${$path}GMM/CerrarSiniestro`,
                            data: {
                                "id_siniestro": id,
                                "id_causa":val,
                                "comentario":com,
                            },
                            success: function (data) {
                                //datatable.ajax.reload();
                                datatable.ajax.reload(null, false);
                                toastr.success("Se cambio el estatus");
                               
                            },
                            error: function (data) {

                            }
                        });
                        
                    }else{
                        toastr.error("Completa los campos");
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

        window.SeguimientoSiniestro=function(id_tramite,tipo){
            //console.log('idSe',id_tramite);
                var url=tipo!=''?`${$path}GMM/getSeguimientoT`:`${$path}GMM/getSeguimiento`;
                $.ajax({
                    type: 'POST',
                    url:url,
                    //url: `${$path}GMM/getSeguimiento`,
                    data: {
                        "id": id_tramite,
                    },
                    success: async function (data) {
                        var html='';
                        var data=data.data;
                        data.forEach(  (element,key) => {
                            html+=`<div class="col-md-12">
                                    <ul class="media-list">
                                        <div class="media">
                                            <div class="media-body">
                                                <h5 class="media-heading"><small class="statuscomentario">
                                                <strong><i class="fa fa-user" aria-hidden="true"></i>&nbsp;
                                                ${element.name_complete}</strong></small> 
                                                <small class="text-muted pull-right">${moment(element.fecha_alta).format("DD-MM-YYYY HH:mm")} <i class="fa fa-clock-o" aria-hidden="true"></i>&nbsp;</small>
                                                ${element.tram_n==null?'':`<div class="pull-right" style="padding-right: 30px;">Trámite: ${element.tram_n}</div>`}
                                                </h5>
                                                <p class="pull-right"><span class="label" style="background-color:${element.color==null?'#ABAEB2':element.color}">${element.nombre==null?'comentario':element.nombre}</span></p><small><p>${element.comentario}</p></small>
                                            </div>
                                        </div>        
                                    </ul>
                                </div>
                            `;
                        });
                        if(html==''){
                            html+=`<div class="text-center">NO HAY REGISTRO DE SEGUIMIENTO</div>`;
                        }

                        await $("#body_seguimiento").html('');
                        await $("#body_seguimiento").html(html);
                        await $('#modal_seguimiento').modal('show');
                    },
                    error: function (data) {}
                });
            
        }

        ///validaciones para el form de Nuevo Comentario
        $("#form_comentario").validate({
            rules:{
                comentario_s:{
                    required:true,
                }
            },
            messages: {
                comentario_s:{
                    required:"Ingrese un comentario.",
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
                document.getElementById("over").style.display = "block";
                document.getElementById("upProgressModal").style.display = "block";
                $.ajax({
                    url: form.action,
                    type: form.method,
                    data: $(form).serialize(),
                    success: function(response) {
                        if(response.code==200){
                            toastr.success("Se guardo con éxito.");
                            document.getElementById('form_comentario').reset();
                            datatable.ajax.reload(null, false);
                            //datatable.ajax.reload();
                        }else{
                            toastr.error(response.message);
                        }
                    }            
                });
            }
        });

        window.SeguimientoT=function(){
            $("#form_comentario_tramite").validate({
                rules:{
                    comentario_s_t:{
                        required:true,
                    }
                },
                messages: {
                    comentario_s_t:{
                        required:"Ingrese un comentario.",
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
                            if(response.code==200){
                                toastr.success("Se guardo con éxito.");
                                document.getElementById('form_comentario_tramite').reset();
                                var seguimiento=response.data;
                                SeguimientoGeneral(seguimiento);
                                //datatable.ajax.reload();
                            }else{
                                toastr.error(response.message);
                            }
                        }            
                    });
                }
            });
        }

        window.string_to_slug=function(str){
            str = str.replace(/^\s+|\s+$/g, ''); // trim
            str = str.toLowerCase();
        
            // remove accents, swap ñ for n, etc
            var from = "àáäâèéëêìíïîòóöôùúüûñç·/_,:;";
            var to   = "aaaaeeeeiiiioooouuuunc------";
            for (var i=0, l=from.length ; i<l ; i++) {
                str = str.replace(new RegExp(from.charAt(i), 'g'), to.charAt(i));
            }

            str = str.replace(/[^a-z0-9 -]/g, '') // remove invalid chars
                .replace(/\s+/g, '_') // collapse whitespace and replace by -
                .replace(/-+/g, '_'); // collapse dashes

            return str;
        }

        //visualizar documentos
        //<a href='" + value.ruta_completa + "' class='js-preview-item' >" + value.nombre_completo + "</a></br>
        
        window.delete_doc=function(id,id_elemento){
            swal({
                title: "¿Está seguro de que quiere eliminar el documento seleccionado?",
                text: "Una vez eliminado, ¡no podrá recuperar el elemento!",
                icon: "warning",
                buttons: ["Cancelar", "Aceptar"],
            }).then((value) => {
                if (value) {
                    $.ajax({
                        type: 'POST',
                        url: `${$path}GMM/delete_documento`,
                        data: {
                            "id_doc": id,
                        },
                        success: function (data) {
                            //elemino el elemento
                            $(`#${id_elemento}`).remove();
                            toastr.success("Accion realizada con éxito.");
                            //datatable.ajax.reload();
                        },
                        error: function (data) {

                        }
                    });
                }
            });
        }

         //metodos para actualizar los documentos
         var arraDocs=[];
        window.OpenModalDocs= function(id){
            $.ajax({
                    type: 'POST',
                    url: `${$path}GMM/getAllTramites`,
                    data: {
                        "id": id,
                    },
                    success: async function (data) {
                        console.log(data.data.tramites);
                        var html='<option value="0_0">Seleccione uno </option>';
                        arraDocs=data.data.tramites;
                        arraDocs.forEach((element,key) => {
                            html+=`
                                <option value="${element.info.id}_${element.info.tipo_tramite}">${element.info.tram_nom}  |${moment(element.info.fecha_inicio).format("DD/MM/YYYY")}-${element.info.fecha_fin==null?'Activo':moment(element.info.fecha_inicio).format("DD/MM/YYYY")}</option>
                            `;
                        });
                        if(html==''){
                            html+=``;
                        }

                        $("#doc_anexos").html('');
                        $("#doc_anexos").html('<div style="padding-left:20px"> NO HAY ARCHIVOS</div>');
                        $("#doc_cargados").html('');
                        $("#doc_cargados").html('<div style="padding-left:20px"> NO HAY ARCHIVOS</div>');
                        await $("#tram_doc").html('');
                        await $("#tram_doc").html(html);
                        await $('#modal_docs_admin').modal('show');
                    },
                    error: function (data) {}
                });
        }

        window.documentos_tram=function(data,opt){
            var elm='';
            data.forEach(elementdc => {
                //
                elm+=`
                    <div class="col-md-3" id='doc_${elementdc.file_id}'>
                        <div class="form-group" style='text-align:center;white-space: nowrap;text-overflow: ellipsis;overflow: hidden;'>
                            ${opt==null?'':`<img height='15' width='15' src='https://dl.dropboxusercontent.com/s/678nxrrg13fl745/trash.svg?dl=0' style='cursor:pointer;' onclick="delete_doc('${elementdc.file_id}','doc_${elementdc.file_id}')" /><br/>`}
                            <a  data-nombre='${elementdc.nombre}' style='cursor:pointer;' data-id='${elementdc.file_id}' class='js-preview-item' >${elementdc.nombre}</a>
                        </div>
                </div>
                `;
            });
            if(elm==''){
                elm+=`<div style="padding-left:20px"> NO HAY ARCHIVOS</div>`;
            }
            return elm;
        }


       /*  $(document).on('change', '#tram_doc', function(e) {
            var fullval=$("#tram_doc").val().split('_');
            console.log(fullval);
            var docsup=DocumentosTramiteAdmin(fullval[1]);
            console.log("almDat",arraDocs);
            FindDocsTramite(parseInt(fullval[0]));
            $("#doc_anexos").html('');
            $("#doc_anexos").html(docsup);
        }); */

        $(document).on('change', '#tram_doc', function(e) {
            var fullval=$("#tram_doc").val().split('_');
            if(fullval[0]!='0'){
                var docsup=DocumentosTramiteAdmin(fullval[1]);
                //console.log("almDat",arraDocs);
                FindDocsTramite(parseInt(fullval[0]));
                $("#doc_anexos").html('');
                $("#doc_anexos").html(docsup);
            }else{
                $("#doc_anexos").html('');
                $("#doc_anexos").html('<div style="padding-left:20px"> NO HAY ARCHIVOS</div>');
                $("#doc_cargados").html('');
                $("#doc_cargados").html('<div style="padding-left:20px"> NO HAY ARCHIVOS</div>');
                $("#btn_save_doc").addClass('hide');
            }
        });


        window.DocumentosTramiteAdmin=function(id){
            //console.log("id",id);
            const _array=_Documents;
            const newData = _array.filter((item, index) => item.tramite === id);
            console.log("filter",newData);
            var AcumDocumentos='';
            newData.forEach((element,key) => {
            var name=element.documento_nom;
            //console.log("fin",element);
            AcumDocumentos+=`<div class="col-lg-4">
                            <div class="form-group">
                                <label for="exampleInputEmail1">${element.documento_nom}</label>
                                <input type="file" class="form-control fileD" id="${string_to_slug(name)}" name="${string_to_slug(name)}" placeholder="${element.documento_nom}" onchange="listadoc('${string_to_slug(name)}','ADM')" multiple />
                                <div id="${string_to_slug(name)}_lista_doc"></div>
                                </div>
                        </div>`;
            });
            if(AcumDocumentos==''){
                AcumDocumentos=`
                            <div style="padding-left:20px">
                                No se puenden subir Archivos
                            </div>`;
                $("#btn_save_doc").addClass('hide');
            }else{
                $("#btn_save_doc").removeClass('hide');
            }
            return AcumDocumentos;
        }

        window.FindDocsTramite=function(id){
            var found = arraDocs.find(element => element.info.id === id);
            var docs=documentos_tram(found.documentos,'test');
            $("#doc_cargados").html('');
            $("#doc_cargados").html(docs);
            //console.log("found",found);
        }

        
        //form_add_update_doc
        ///agregar nuevo tramite
        $("#form_add_update_doc").validate({
            rules:{
                comentario_s:{
                    required:true,
                }
            },
            messages: {
                comentario_s:{
                    required:"Ingrese un comentario.",
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
                var fullval=$("#tram_doc").val().split('_');
                //console.log(fullval);
                //id_siniestro_t
                formData.append('id', fullval[0]);
                $('.fileD').each(function(index,value){
                    //console.log('file',$(`#${value.name}`).prop('files')[0]);
                    formData.append(value.name, $(`#${value.name}`).prop('files')[0]);
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
                        if(response.code==200){
                            toastr.success("Se guardo con éxito.");
                            $('#modal_docs_admin').modal('hide');
                            //document.getElementById('form_tramite').reset();
                            //datatable.ajax.reload();
                        }else{
                            toastr.error(response.message);
                        }
                        //termina la carga del tramite
                        document.getElementById("over").style.display = "none"; 
                        document.getElementById("upProgressModal").style.display = "none";   
                    }            
                });

            }
        });



        //delimitador de craga de documentos
        var error=[];
        const MAXIMO_TAMANIO_BYTES = 8000000;
        window.listadoc=function(id,tipo=null){
            error=[];
            const DocFiles=$(`#${id}`).prop('files');
            //console.log(DocFiles.length);
            var content='<ul style="padding-left:20px;">';
            for (var i = 0; i < DocFiles.length; i++) {
                //console.log(`doc`,DocFiles[i]);
                if (DocFiles[i].size > MAXIMO_TAMANIO_BYTES) {
                    error.push(DocFiles[i].name);
                    content+=`<li style="color:red;">${DocFiles[i].name}</li>`;
                } else{
                    content+=`<li>${DocFiles[i].name}</li>`;
                }
                
            }
            content+='</ul>';
            var boton=tipo==null?`#btn_save`:`#btn_save_doc`;
            var lista=tipo==null?`#${id}_lista`:`#${id}_lista_doc`;
            if(error.length>0){
                swal({
                    title: "Algunos archivos exceden el limite de 8 MB",
                    text: "Suba archivos de menor tamaño.",
                    icon: "warning",
                    button: {
                        text: "Aceptar",
                    },
                });
                $(boton).attr("disabled", true);
            }else{
                $(boton).removeAttr("disabled");
                    //alert("hoy juegas");
            }
            $(lista).html('');
            $(lista).html(content);
            $('#modal_tramite').modal('handleUpdate'); 
        }



    });
</script>
<script>
    //Dennis Castillo [2022-01-18]
    $(document).on("click", ".get-kpi-year", function(){

        const year = $(this).data("year");
        const claim = $(this).data("claim");
        const baseUrl = $("#base_url").data("base-url");
        
        $("#dpd-kpi-year").html(year);
        $("#dpd-kpi-year").attr("title", year);
        console.log(year, claim);

        const ajax = $.ajax({
            type: "GET",
            url: `${baseUrl}GMM/getKpi`,
            data: { 
               year: year
            },
            error: (error) => {
                console.log(error.responseText);
            },
            success: (data) => {
                const response = JSON.parse(data);
                console.log(response);

                if(Object.keys(response).length > 0){

                    for(const a in response){

                        const tr = Object.values(response[a]);
                        const td0 = getLabels(a);
                        const allTr = tr.unshift(td0);
                        const stringTr = tr.reduce((acc, curr, idx) =>{

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

        switch(key){
            case "Finalizado": return "Pendientes";
            case "No_Finalizado": return "Terminados";
            default: return key;
        }
    }
    //------------------------------
</script>
<script src="<?=base_url()."assets/js/js_elementoArrastrable.js"?>"></script> <!--Dennis [2021-12-08] -->
<script src="<?=base_url()."assets/js/jquery.notesforclaimsmodule.js"?>"></script> <!--Dennis [2022-01-18] -->
<!--modal de las aciiones de las tablas-->    