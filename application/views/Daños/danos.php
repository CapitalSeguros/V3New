<script src="<?=base_url()?>/assets/gap/js/jquery.validate.js"></script>
<script src="<?=base_url()?>/assets/gap/js/Prueba.js"></script>
<style>

    .box.first {
        float: left;
    }
    .card-round {
        border-radius: 5px;
        width: 100px;
        max-width: 100px;
    }
    .help-block{
        color:red;
    }
    .swal-button--confirm{
    background-color:#67439f!important;
}

.swal-text{
    color:#472380 !important;
}

    /* estilos de la linea */
    .events li { 
  display: flex; 
  /* color: #999; */
}

.events time { 
  position: relative;
  padding: 0 1.5em;  }

.events time::after { 
   content: "";
   position: absolute;
   z-index: 2;
   right: 0;
  /*  top: 0; */
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
  /*  height: 130%; */
   height:10vw;
   border-left: 1px #ccc solid;
}

.events strong {
  /*  display: block; */
   font-weight: bolder;
}

.events { margin: 1em; width: 50%; }
.events, 
.events *::before, 
.events *::after { box-sizing: border-box; font-family: arial; }

.progressBar {
        background-color: lightgrey;
        width: 200px;
        height: 20px;
    }

    .progressb {
        height: 100%;
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
    
    /* Popup box BEGIN */
    .hover_bkgr_fricc{
        background:rgba(0,0,0,.4);
        cursor:pointer;
        display:none;
        height:100%;
        position:fixed;
        text-align:center;
        top:0;
        width:100%;
        z-index:10000;
    }
    .hover_bkgr_fricc .helper{
        display:inline-block;
        height:100%;
        vertical-align:middle;
    }
    .hover_bkgr_fricc > div {
        background-color: #fff;
        box-shadow: 10px 10px 60px #555;
        display: inline-block;
        height: auto;
        max-width: 551px;
        min-height: 100px;
        vertical-align: middle;
        width: 60%;
        position: relative;
        border-radius: 8px;
        padding: 15px 5%;
    }
    .popupCloseButton {
        background-color: #fff;
        border: 3px solid #999;
        border-radius: 50px;
        cursor: pointer;
        display: inline-block;
        font-family: arial;
        font-weight: bold;
        position: absolute;
        top: -20px;
        right: -20px;
        font-size: 25px;
        line-height: 30px;
        width: 30px;
        height: 30px;
        text-align: center;
    }
    .popupCloseButton:hover {
        background-color: #ccc;
    }
    .trigger_popup_fricc {
        cursor: pointer;
        font-size: 20px;
        margin: 20px;
        display: inline-block;
        font-weight: bold;
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
    .dropdown-menu>.active>a, .dropdown-menu>.active>a:focus, .dropdown-menu>.active>a:hover {
        background-color:#472380 !important;
    }
    .maple{
        -webkit-transform:unset !important;
        transform:unset !important;
    }
    .breadcrumb{
        margin-left:auto !important;
    }
</style>
<section class="container-fluid breadcrumb-formularios">
    <a id="N" data-IdNotificacion='<?= $idNotificacion; ?>'></a>
    <div class="row">
        <div class="col-md-6 col-sm-5 col-xs-5">
            <h3 class="titulo-secciones">Daños</h3>
        </div>
        <div class="col-md-6 col-sm-7 col-xs-7 d-flex">
            <?= $breadcrumbs; ?>
        </div>
    </div>
    <hr />
</section>
<section class="container">

<?php 
    $data["typeController"] = "DANOS";
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
                            <th scope="col">Aseguradora</th>
                        </tr>
                    </thead>
                    <tbody>
                    </tbody>
                </table>
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
                                   <dl class="row">
                                        <div class="col-md-12">
                                            <strong>
                                            <span class="fa fa-info-circle" aria-hidden="true"></span>
                                            INFORMACIÓN DEL REGISTRO SELECCIONADO
                                            </strong>
                                        </div>
                                    </dl> 
                                    <dl class="row">
                                        <dt class="col-sm-12"> <span class="fa fa-info-circle" aria-hidden="true"></span> Datos de la Póliza: </dt>
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
                                        <dt class="col-sm-2 text-right">Agente</dt>
                                        <dd class="col-sm-10 text-left" id="AgenteNombre">N/A</dd>
                                        <dt class="col-sm-2 text-right">Titular</dt>
                                        <dd class="col-sm-10 text-left" id="NombreCompleto">N/A</dd>
                                        <dt class="col-sm-12"> <span class="fa fa-info-circle" aria-hidden="true"></span> DATOS DEL SINIESTRO: </dt>
                                        <dt class="col-sm-2 text-right">Num siniestro:</dt>
                                        <dd class="col-sm-4 text-left" id="siniestro_id">N/A</dd>
                                        <dt class="col-sm-2 text-right">Num reporte:</dt>
                                        <dd class="col-sm-4 text-left" id="num_reporte">N/A</dd>
                                        <dt class="col-sm-2 text-right">Fecha ocurrencia:</dt>
                                        <dd class="col-sm-4 text-left" id="fecha_ocurrencia">N/A</dd>
                                        <dt class="col-sm-2 text-right">Fecha Inicio:</dt>
                                        <dd class="col-sm-4 text-left" id="inicio_ajuste">N/A</dd>
                                        <dt class="col-sm-2 text-right">Inciso:</dt>
                                        <dd class="col-sm-4 text-left" id="inciso">N/A</dd>
                                        <dt class="col-sm-2 text-right">Estado:</dt>
                                        <dd class="col-sm-4 text-left" id="estado">N/A</dd>
                                        <dt class="col-sm-2 text-right">Reporta:</dt>
                                        <dd class="col-sm-4 text-left" id="persona_reporta">N/A</dd>
                                        <dt class="col-sm-2 text-right">Num reporta</dt>
                                        <dd class="col-sm-4 text-left" id="numero_reporta">N/A</dd>
                                        <dt class="col-sm-2 text-right">Tipo:</dt>
                                        <dd class="col-sm-4 text-left" id="tipo_c">N/A</dd>
                                        <dt class="col-sm-2 text-right">Riesgo:</dt>
                                        <dd class="col-sm-4 text-left" id="tipoC">N/A</dd>
                                        <dt class="col-sm-2 text-right">Afectado:</dt>
                                        <dd class="col-sm-10 text-left" id="descripcion_afectado">N/A</dd>
                                        <dt class="col-sm-2 text-right">Concepto:</dt>
                                        <dd class="col-sm-10 text-left" id="concepto">N/A</dd>
                                        <dt class="col-sm-2 text-right">Dirección</dt>
                                        <dd class="col-sm-10 text-left" id="direccion">N/A</dd>
                                        <dt class="col-sm-2 text-right">Agregado por:</dt>
                                        <dd class="col-sm-10 text-left" id="name_complete">N/A</dd>
                                        <dt class="col-sm-2 text-right">Telefono</dt>
                                        <dd class="col-sm-4 text-left" id="Telefono1">N/A</dd>
                                        <dt class="col-sm-2 text-right">Correo</dt>
                                        <dd class="col-sm-4 text-left" id="EMail1">N/A</dd>
                                        
                                        <dt class="col-sm-12"> <span class="fa fa-info-circle" aria-hidden="true"></span> DATOS DEL COORDINADOR: </dt>
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
                                        <form id="form_comentario" name="form_comentario" data-toggle="validator" method="POST" action="<?= base_url()?>Danos/NuevoComentario" >
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
                                        <div class="col-md-12">
                                        <ul class="events" id="lista_tramites" style="overflow: auto;max-height: 50vh;width: 75vw;">
                                        
                                            <!-- <li>
                                            <div><img src="https://www.flaticon.es/svg/vstatic/svg/3313/3313804.svg?token=exp=1613278577~hmac=d3341f849225f1353fa2510c8bb247a5" width="50px" height="50px"></div>
                                                <time datetime="10:03"></time> 
                                                <span>
                                                    <strong>AVISO</strong>
                                                    Example<br> 
                                                    2020/04/12 a 2020/04/15
                                                </span>
                                            </li> -->
                                            </ul>
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
            </div>
  <!--       </form> -->
    </div>
</div>


<!-- modal de tramites -->
<div class="modal fade" id="modal_tramite" tabindex="-1" role="dialog" aria-labelledby="modalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <form id="form_tramite" action="<?= base_url() ?>Danos/nuevoTramite" enctype="multipart/form-data" method="POST" autocomplete="off">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title" id="titulo_tramite"></h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                    </button>
                    
                </div>
                <div class="modal-body" id="test">
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="exampleInputEmail1">Tipo de evento</label>
                                <p id="label_tramite"></p>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <?php 
                                    $fecha=date("Y-m-d");
                                ?>
                                <label>Fecha de inicio</label>
                                <input type="hidden" name="id_siniestro_t" id="id_siniestro_t">
                                <input type="hidden" name="tipo_tramite" id="tipo_tramite">
                                <input type="hidden" name="id_tramite" id="id_tramite" value='0'>
                                <input class="form-control" type="date" name="inicio_tramite" id="inicio_tramite" max="<?=$fecha?>" value="<?=$fecha?>" <?=$FechaFin?'': 'disabled'?> />
                                <span id="e_inicio_tramite" class="help-block"></span>
                            </div>
                        </div>
                        <div class="col-md-12">
                            <div class="form-group">
                                <label>Descripcion</label>
                                <textarea onkeyup="javascript:this.value=this.value.toUpperCase();" class="form-control" name="descripcion" id="descripcion"></textarea>
                                <span id="e_descripcion" class="help-block"></span>
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
            <form id="form_add_comentario" name="form_add_comentario" data-toggle="validator" method="POST" action="<?= base_url()?>Danos/NuevoComentario" >
               <div class="row">
                    <dt class="col-sm-12"> <span class="fa fa-info-circle" aria-hidden="true"></span> Nuevo comentario de seguimiento: </dt>
                            <div class="col-md-10">
                                <div class="form-group">
                                    <textarea onkeyup="javascript:this.value=this.value.toUpperCase();" class="form-control" name="comentario_s_t" id="comentario_s_t"></textarea>
                                    <input type="hidden" name="id_siniestro_c_t" id="id_siniestro_c_t" >
                                    <input type="hidden" name="id_tramite_c_t" id="id_tramite_c_t" >
                                    <input type="hidden" name="id_tipotram_c_t" id="id_tipotram_c_t" >
                                    <input type="hidden" name="id_esttram_c_t" id="id_esttram_c_t" >
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
                <form id="form_add_update_doc" name="form_add_update_doc" data-toggle="validator" method="POST" action="<?= base_url()?>Danos/updateDocumentos" >
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


<!-- modal para ver documentos -->
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

<!------------------------------------>
<?php 
    //var_dump($notes["agentsToAssing"]);
    $this->load->view("popup/sinisterNotesModal", $notes);
    $this->load->view("popup/sinisterListNotesModal");
?>
 
<!------------------------------------>


<script src="<?=base_url()?>assets/gap/js/permisos.js"></script>
<script>
    $(document).ready(function() {

           if($(".pop-up-modal")[0]){
       var draggableElement = elementoArrastrable($(".pop-up-modal")[0]); //
     }
//Dennis Castillo [2021-12-09]

        $('body').append('<div id="over" style="display:none;position: absolute;top:0;left:0;width: 100%;height:100%;z-index:2;opacity:0.4;filter: alpha(opacity = 50)"></div>');
        const $path = $("#base_url").attr("data-base-url");
        const $IdNotificacion = $("#N").attr("data-IdNotificacion");
        const titulos=["Aviso","Reporte de aseguradora", "Visita","Documentacion", "Determinacion de perdidas","Cuantificacion de peridas", "Conciliacion", "Ajuste", "Firma de convenio", "Recepcion de pago"]

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
            _years.forEach((element,key)=>{//${element.id==1?"selected":''}
                option+=`<option value="${element.opcion}" ${element.opcion==actualy?"selected":''}>${element.opcion}</option>`;
            });
            return option;
        }

        //---------------
        //Dennis Castillo [2022-01-17]
        const kpiYear = _years.reduce((acc, curr) => acc += `<li><a class="get-kpi-year" href="javascript: void(0)" data-claim="autos" data-year="${curr.opcion}">${curr.opcion}</a></li>`, ``);
        const yearNow = moment().format("YYYY");
        $(".kpi-dropdown").html(kpiYear + `<li><a class="get-kpi-year" href="javascript: void(0)" data-claim="danos" data-year="${yearNow}">${yearNow}</a></li>`);
        //console.log(kpiYear);
        //----------------

        document.getElementById("over").style.display = "block";
        document.getElementById("upProgressModal").style.display = "block";
        var draw=0;
        const datatable = $('#example').DataTable({
            language: {
                url: `${$path}assets/js/espanol.json`
            },
            ajax: {
                url: `${$path}Danos/getDanos`,
                type: 'POST',
                data :function (d) {
                    //d.id = $('#cbEstado').val(),
                    //d.year=$('#year').val()
                },
                dataSrc: 'data'
            },
            drawCallback:function(){
               if(draw==0){
                    draw++;
               }else{
                    $("#over").css("display", "none");
                    $("#upProgressModal").css("display", "none");
               }
               Getpermisos();
            },
            dom: '<"toolbar">rtip ',
            initComplete: function() {
                 let btnNuevo='';
                  if(IDVendVarGlobal==0){btnNuevo=`<div class="col-md-10 text-right" style="margin-top: 10px;">
                            <a class="btn btn-primary Nuevo" href="<?=base_url()?>Danos/RegistroDanos">Nuevo</a>
                    </div>`}
                var tmp = `
                <div>
                <div class="row">
                <div class="col-sm-2">
                    <label>Buscar </label>
                    <input type="text" placeholder="Buscar..." id="txSearch" class="form-control input-sm"  name="search"  />
                </div>
                <div class="col-sm-2">
                    <label>Estatus tramite </label>
                    <select class="form-control input-sm"  id="cbEstado" name="1">
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
                    <label>Año</label>
                    <select class="form-control input-sm"  id="year" name="2">
                        ${SelectAnos()}
                    </select>
                </div>
                <div class="col-sm-2">
                    <label>Aseguradora </label><br>
                    <select id="Aseguradora" class="multiselect-ui form-control" multiple="multiple">
                        ${SelectAseguradoras()}
                    </select>
                </div>
                </div>
                <div class="row">
                    <div class="col-md-2">
                        <label>Estatus siniestro </label>
                        <select class="form-control input-sm"  id="cbEstado_2" name="8">
                            ${SelectEstatus()}
                        </select>
                    </div>
                  ${btnNuevo}
                </div>
                </div>`
                $('div.toolbar').html(tmp);
                document.getElementById("over").style.display = "none";
                document.getElementById("upProgressModal").style.display = "none";

                //Asignamos las aseguradoras
                $('.multiselect-ui').multiselect({
                    nonSelectedText:'Seleccione',
                    numberDisplayed:1,
                });
                //GetTotal();
            },
            columns: [
                {
                    data: 'id',
                    visible: false
                },
                {
                    data: 'estatus',
                    width: '150px',
                    orderable: false,
                    render: function(data, type, row) {
                        //console.log(row);
                        //var colorS = color(row.estatus);
                        return `
                    <div class="col-md-1 center-aling-items">
                            <div class="card-round" style="background:${row.color==null?'#8c8787':row.color};">
                                <h6 class="text-uppercase fw-bold text-center" style="padding-top:9px;padding-bottom: 9px;font-size: 9px;color: white !important;">${row.estatus==null?'N/A':row.estatus}</h6>
                            </div>
                    </div>`
                    }
                },
                {
                    data: null,
                    orderable: false,
                    render: function(data, type, row) {
                        //var date=new Date(row.inicio_ajuste);
                        // <div style='float:right;'>Prueba</div>
                        var index = _Tram.findIndex(elemt => elemt.order === row.order_tipo_t);
                        //console.log("index find",index)
                        //<div class="box first" style="padding-left: 15px;"> order: ${row.order_tipo_t}</div>
                        //<div class="box first" style="padding-left: 15px;"> order: ${_Tram.length}</div>
                        //<div  class="box first" style="padding-left: 15px;">F_lastram ${row.f_lasttram}</div>
                        return `
                    <div class="row">
                        <div class="col-md-12">
                            <div >
                                <div class="media-body">
                                    <h4 class="media-heading"><strong>Evento: ${row.nombre_tramite==null?'N/A':row.nombre_tramite}</strong> (${row.order_tipo_t?row.order_tipo_t:0} de ${_Tram.length})</h4>
                                    <div class="Siniestro-body">
                                        <div class="box first ">Fecha Inicio: ${row.inicio_ajuste==null?'N/A':moment(row.inicio_ajuste).format("DD/MM/YYYY")}</div>
                                        <div class="box first" style="padding-left: 15px;"> Fecha Fin:  ${row.fecha_fin==null?'N/A':moment(row.fecha_fin).format("DD/MM/YYYY")}</div>
                                        <div class="box first" style="padding-left: 15px;"> Asegurado: ${row.asegurado_nombre}</div>
                                        <div class="box first" style="padding-left: 15px;"> Número de siniestro: ${row.siniestro_id}</div>
                                        <div class="box first" style="padding-left: 15px;"> Poliza: ${row.poliza}</div>
                                        
                                    </div>
                                </div>
                            </div>  
                        </div>
                    </div>`
                    }
                },
                {
                    data: 'inicio_ajuste',
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
                        //var colorS = Progresovalues(row.dias, row.estatus_t, row.progreso);
                        // <span>${row.dias+"  "+row.estatus+"  "+row.progreso}</span>
                        // var colorS= Colorbarra(row.dias,row.progreso,row.fecha_inicio,row.fec_tram_F,row.estatus);
                        var colorS= Colorbarra(row.dias,row.progreso,row.inicio_ajuste,row.fecha_fin,row.siniestro_estatus);
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
                    "sClass": "control",
                    "sDefaultContent": '',
                    width: '120px',
                    "orderable": false,
                    render: function(data, type, row) {
                        //console.log(`id del tramite -> ${row.id_tramite}, tipo_tram ${row.tipo_tramite==null?'1':(row.tipo_tramite+1).toString()}`);
                        var tramiteold=Findtramite(row.tipo_tramite==null?'1':(row.tipo_tramite==10?row.tipo_tramite:row.tipo_tramite+1).toString());
                        var tramite=FindtramiteOrder(row.order_tipo_t==null?'1':(row.tipo_tramite==10?row.tipo_tramite:row.tipo_tramite+1).toString());
                        var colorS= Colorbarra(row.dias,row.progreso,row.inicio_ajuste,row.fecha_fin,row.siniestro_estatus);

                        const permisos=["FINIQUITADO","RECHAZADO"];
                        let regresar=`  <div style="float: left;font-size: 20px;" class="text-center"><div style="font-size: 12px;"> Duración</div><div style="height: 30px;width: 30px;background-color: ${colorS.color};color:white;border-radius: 50%; display: inline-block;">${colorS.dias}</div><div  style="font-size: 12px;"> Dias </div></div>`;
                        if(IDVendVarGlobal==0){ regresar+=`
                      
                        <div style="text-align: center;">
                                <div class="dropdown">
                                    <button class="btn btn-link dropdown-toggle" type="button" id="dp${row.id}" data-toggle="dropdown" aria-haspopup="true" aria-expanded="true">
                                        <i class="fa fa-ellipsis-v" aria-hidden="true"></i>
                                    </button>
                                    <ul class="dropdown-menu" aria-labelledby="dp${row.id}">
                                        <li><a class="bn-bono-view"  style="cursor: pointer;" onclick="Ver(${row.id})"  >Ver</a></li>
                                        
                                        ${row.siniestro_estatus!="FINIQUITADO"?`
                                            <li><a class="bn-bono-view Editar"  style="cursor: pointer;" href="${$path}Danos/RegistroDanos/${row.id}" data-permiso="permiso" data-accion-permiso="Editar">Editar siniestro</a></li>
                                            <li><a class="bn-bono-view"  style="cursor: pointer;" onclick="AddSeguimiento(${row.id},${row.id_tramite},${row.tipo_tramite},${row.tram_estatus})" data-permiso="permiso" data-accion-permiso="Seguimiento" >Seguimiento</a></li>
                                            ${row.tipo_tramite<_Tram.length || row.estatus==null?`<li><a class="bn-bono-view"  style="cursor: pointer;" onclick="Tramite(${row.id},'${tramiteold.id}',${row.id_tramite},'${row.id_tramite==null?row.fecha_ocurrencia:row.f_lasttram==null?row.fecha_ocurrencia:row.f_lasttram}')" data-permiso="permiso" data-accion-permiso="Nuevo-tramite">${ tramiteold.nombre} </a></li>`:``}
                                            
                                            ${row.order_tipo_t>0 && _FechaFin && row.order_tipo_t==_Tram.length && !permisos.includes(row.estatus) ?`<li><a class="bn-bono-view"  style="cursor: pointer;" onclick="ChangeStatus(${row.id_tramite},0,0,${row.id},${row.order_tipo_t})" data-permiso="permiso" data-accion-permiso="Cambiar-estatus">Cerrar evento: <br> ${_Tram[9].nombre}</a></li>`:''}
                                            <li><a class="bn-bono-view Editar"  style="cursor: pointer;"   data-permiso="permiso" data-accion-permiso="Administrar-documentos" onclick="OpenModalDocs(${row.id})">Administrar Documentos</a></li>

                                            <li role="presentation" class="dropdown-header">Notas</li>
                                            <li><a class="bn-bono-view show-notes-modal" data-type="daños" data-id="${row.id}" data-number="${row.siniestro_id}" data-insured="${row.asegurado_nombre}" data-policy="${row.poliza}" data-type-sinister="${row.tipo_siniestro_nombre}" style="cursor: pointer;" >Generar nota</a></li>
                                            <li><a class="bn-bono-view show-list-notes-modal" data-type="daños" data-id="${row.id}" style="cursor: pointer;" >Mostrar notas creadas</a></li>
                                            `
                                        :''}
                                        
                                    </ul>
                                </div>
                        </div>
                        `;}
                        return regresar;
                    }
                },
                {
                    data: 'aseguradora_id',
                    visible: false
                },
                {
                    data: 'siniestro_estatus',
                    visible: false
                },
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

        ///select de las aseguradoras
        window.SelectAseguradoras=function(){
            var opt='';
            _Aseguradoras.forEach(element => {
                opt+=`<option value="${element.id}">${element.nombre}</option>`;
            });
            return opt;
        }


        window.Findtramite=function(id){
            const tramite = _.find(_Tram, function (it) {
                return it.id === id;
            });
            //console.log(tramite);
            return tramite;
        }

        window.FindtramiteOrder=function(order){
            const tramite = _.find(_Tram, function (it) {
                return it.order == order;
            });
            return tramite;
        }


        //funcion para editar un registro
        window.Ver = function (id) {
            $("#tab_home").addClass("active");//in active
            $("#home").addClass("in active");
            $("#tab_tramite").removeClass("active");
            $("#tab_Seguimiento").removeClass("active");
            $("#menu1").removeClass("in active");
            $("#seguimiento_G").removeClass("in active");
            //$('#myTabs').tabs('select', '#home');

            //obtner la info desde la tabla para mostar los datos generales
            /* const _data = datatable.rows().data();
            const oInci = _.find(_data, function (it) {
                return it.id == id;
            });
            Object.keys(oInci).forEach(key =>{
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
                url: `${$path}Danos/getAllTramites`,
                data: {
                    "id": id,
                    //"Tipo":1
                },
                success: async function (data) {
                    //console.log("data",data.data);
                    //console.log('estado',data.data.siniestro[0].siniestro_estatus)
                    //var cm=data.data.siniestro[0].siniestro_estatus=='FINIQUITADO'?$("#comentario").hide(): $("#comentario").show();
                    $("#comentario").hide()
                    $('#id_siniestro_c').val(data.data.siniestro[0].id_sin);
                    var seguimiento=data.data.SeguimientoGeneral;

                    Object.keys(data.data.siniestro[0]).forEach(key =>{
                        if($(`#${key}`).length>0){
                            if(key=='inicio_ajuste'||key=='fecha_ocurrencia'){
                                $(`#${key}`).html(moment(data.data.siniestro[0][key]).format("DD/MM/YYYY"));
                            }else{
                                $(`#${key}`).html(data.data.siniestro[0][key]);
                            }
                           
                        }
                    });
                    //datos generales
                    var dataP=JSON.parse(data.data.siniestro[0].data_poliza);
                    /* if(dataP!=null){
                       
                    } */
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
                    var dataG=dataC['general'];
                    Object.keys(dataG).forEach(key =>{
                        if($(`#${key}`).length){
                           if(dataG[key]!=''){
                            $(`#${key}`).html(dataG[key]);
                           }else{
                            $(`#${key}`).html("N/A");
                           }
                        }
                    });
                    var dataCC=dataC['cordinador'];
                    //console.log(dataCC);
                    Object.keys(dataCC).forEach(key =>{
                        
                        //$(`#${key}`).html(dataCC[key]);
                        if(dataCC[key]!=''){
                            $(`#${key}`).html(dataCC[key]);
                           }else{
                            $(`#${key}`).html("N/A");
                           }
                    });

                    var data=data.data.tramites;
                    var acum='';
                    data.forEach(element => {
                        var t=Findtramite();
                        /* var date1=new Date(element.fecha_inicio);
                        var date2=new Date(element.fecha_fin); */
                        var colorS= Colorbarra(element.info.dias,element.info.progreso,element.info.fecha_inicio,element.info.fecha_fin,element.info.nombre);
                        acum+=`
                        <li>
                            <div class="col-md-4">
                                <img src="${element.info.url}" width="50px" height="50px">
                                <time datetime="10:03"></time> 
                                <span>
                                <strong>${element.info.tram_nom}</strong>
                                <br> 
                                <div style='padding-left: 8vw;'>${moment(element.info.fecha_inicio).format("DD/MM/YYYY")} a ${element.info.fecha_fin==null?' En curso':moment(element.info.fecha_fin).format("DD/MM/YYYY")}</div>
                                </span>
                            </div>
                            <div class="col-md-1">
                                <div style="float: left;font-size: 20px;" class="text-center"><div style="font-size: 12px;"> Duración</div><div style="height: 30px;width: 30px;background-color:#472380;color:white;border-radius: 50%; display: inline-block;">${colorS.dias}</div><div  style="font-size: 12px;"> Dias </div></div>
                            </div>
                            <div class="col-md-7">
                                <div class="col-sm-12">
                                <strong> Descripción del trámite ${element.info.tram_nom}: </strong> <br/>
                               <p>${element.info.descripcion==""?'N/A':element.info.descripcion}</p>
                                </div>
                                <div class="col-sm-12"><strong> Documentos del trámite ${element.info.tram_nom}: </strong> <br/>
                                    ${documentos_tram(element.documentos,null)}
                                </div>
                            </div>
                        </li>`;
                    });
                    if(acum==''){
                        acum="<li class='center'>NO SE HAN REGISTRADO TRÁMITES</li>";
                    }
                    //console.log("acum",acum);
                    await $("#lista_tramites").html('');
                    await $("#lista_tramites").html(acum);
                    await SeguimientoGeneral(seguimiento);
                    await $('#modal_gmm').modal('show');
                    //datatable.ajax.reload();
                },
                error: function (data) {

                }
            });


           
            return;
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
                elm+=`NO HAY DOCUMENTOS`;
            }
            return elm;
        }

        window.SeguimientoGeneral=function(data){
            var comentarios='';
            data.forEach((element,key)=>{
                var date=moment(element.fecha_alta).format('DD-MM-YYYY HH:mm');
                console.log('date'+date+' , normaldb '+element.fecha_alta);
                comentarios+=`
                            <div class="col-md-12">
                                    <ul class="media-list">
                                        <div >
                                            <div class="media-body">
                                                <h5 class="media-heading"><small class="statuscomentario">
                                                <strong><i class="fa fa-user" aria-hidden="true"></i>&nbsp;
                                                ${element.name_complete}</strong></small> 
                                                <small class="text-muted pull-right">${date} <i class="fa fa-clock-o" aria-hidden="true"></i>&nbsp;</small>
                                                ${element.tram_nom==null?'':`<div class="pull-right" style="padding-right: 30px;">Trámite: ${element.tram_nom}</div>`}
                                                </h5>
                                                <p class="pull-right"><span class="label" style="background-color:${element.color==null?'#ABAEB2':element.color}">${element.nombre==null?'comentario':element.nombre}</span></p><small><p>${element.comentario}</p></small>
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
                            datatable.ajax.reload(null, false);
                            //datatable.ajax.reload();
                        },
                        error: function (data) {

                        }
                    });
                }
            });
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

         //evento del combo de estatus tramites
         $(document).on('change', '#cbEstado', function(e) {
            //datatable.ajax.reload();
            datatable
                .columns(1)
                .search(e.currentTarget.value)
                .draw();
        });

         //evento del combo de estatus siniestros
         $(document).on('change', '#cbEstado_2', function(e) {
            //datatable.ajax.reload();
            datatable
                .columns(8)
                .search(e.currentTarget.value)
                .draw();
        });

        //evento del input buscar
        $(document).on('input', '#txSearch', function(e) {
            datatable
                .search(e.currentTarget.value)
                .draw();
        });

        $(document).on('change', '#year', function(e) {
            //datatable.ajax.reload();
        });

         //agregar nuevo tramite
         window.Tramite=function(data,tramite,id_tramite,fecha_limit)  {
            //console.log("id_tram",id_tramite);
            //var traD=tramite+1;
            var t=Findtramite(tramite);
            let today = new Date().toLocaleDateString();
            //console.log(today);
            //console.log("tramite",t);
            $("#id_siniestro_t").val(data);
            $("#inicio_tramite").attr("min",fecha_limit=='N/A'?moment().format("YYYY-MM-DD"):moment(fecha_limit).format("YYYY-MM-DD"));
            //$("#tipo_tramite").val(tramite);
            $("#tipo_tramite").val(t.order);
            $("#id_tramite").val(id_tramite==null?0:id_tramite);
            $("#documentacion").val();
            $("#titulo_tramite").text("Registro de "+t.nombre);
            $("#label_tramite").text(t.nombre);
            DocumentosTramite((t.id).toString());
            $('#modal_tramite').modal('show');
           
        }

        //agregar nuevo tramite
        window.Tramite2=function(data,tramite,id_tramite)  {
            var t=Findtramite(tramite);
            document.getElementById("over").style.display = "block";
            document.getElementById("upProgressModal").style.display = "block";
            $.ajax({
                    url: `${$path}Danos/nuevoTramite`,
                    type: "POST",
                    data: {
                        "id_siniestro":data,
                        "tipo_tramite":tramite==11?11:t.id,
                        "id_tramite":id_tramite,
                        "opcion":2
                    },
                    success: function(response) {
                        if(response.code==200){
                            toastr.success("Se guardo con éxito.");
                            datatable.ajax.reload(null, false);
                            //datatable.ajax.reload();
                        }else{
                            toastr.error(response.message);
                        }
                    }            
            });
        }


        window.AddSeguimiento=function(id,id_tram,tipo_tram,est_tram){
            $('#id_siniestro_c_t').val(id);
            $('#id_tramite_c_t').val(id_tram);
            $('#id_tipotram_c_t').val(tipo_tram);
            $('#id_esttram_c_t').val(est_tram);
            //$('#id_tramite_c_t').val(tramite);
            $('#modal_seguimiento_add').modal('show');
        }

        ///cambiar estatus
        window.ChangeStatus=function(id_tramite,id,orden,idSiniestro,numEvento){
            const _tablaR = datatable.rows().data();
            const oIncid = _.find(_tablaR, function (it) {
                return it.id == idSiniestro;
            });
             var valores='<select class="form-control" name="sweet_s" id="sweet_s"><option value="0">Seleccione una opción</option>';
            _estatus.forEach((element,key) => {
                if(element.valores=='1'){
                    valores+=`<option value="${element.id}" ${id==element.id||orden>=element.orden?'disabled':''}>${element.nombre}</option>`;
                }
               
            });
            var IsFechaFin=`<div class="col-lg-12 hidden" id="cont_fecha">
                                <div class="form-group">
                                    <label for="exampleInputEmail1">Fecha fin</label>
                                    <input type="date" class="form-control" id='fecha_fin' min=${moment(oIncid["fecha_inicio"]).format('YYYY-MM-DD')} max=${moment().format('YYYY-MM-DD')}>
                                </div>
                            </div>`;
            valores+='</select>';
            var contenido=` <div class="row">
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
                                <textarea name="comentario_est" id="comentario_est" class="form-control"></textarea>
                            </div>
                        </div>
                    </div>`;
            swal({
                title: "¿Está seguro de cambiar el estatus del trámite?",
                text: "Una vez cambiado, ¡no podrá recuperar el elemento!",
                icon: "warning",
                //content:"<select><option>TEST</option></select>",
                buttons: ["Cancelar", "Aceptar"],
            }).then((value) => {
                var val=$("#sweet_s").val();
                var com=$("#comentario_est").val();
                var fecha=$("#fecha_fin").val();
                if (value) {
                    if(val!=0  && com!=''){
                        document.getElementById("over").style.display = "block";
                        document.getElementById("upProgressModal").style.display = "block";
                        $.ajax({
                            type: 'POST',
                            url: `${$path}Danos/ChangeEstatus`,
                            data: {
                                "id": id_tramite,
                                "estatus":val,
                                "comentario":com,
                                "id_siniestro":idSiniestro,
                                "numEvento":numEvento,
                                "fecha_fin":fecha
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
                if(_FechaFin){
                    $('#cont_fecha').removeClass("hidden");
                }
            }else{
                $('#cont_fecha').addClass("hidden");
            }
        }

        ///agregar nuevo tramite
        $("#form_tramite").validate({
            rules:{
                inicio_tramite:{
                    required:true,
                },
                descripcion:{
                    required:true,
                }
            },
            messages: {
                inicio_tramite:{
                    required:"Seleccione una fecha.",
                },
                descripcion:{
                    required:"ingrese una descripción.",
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
                console.log('tramite',$("#tipo_tramite").val());
                //id_siniestro_t
                formData.append('id_siniestro', $("#id_siniestro_t").val());
                formData.append('tipo_tramite', $("#tipo_tramite").val());
                formData.append('id_tramite', $("#id_tramite").val());
                formData.append('inicio_tramite', $("#inicio_tramite").val());
                formData.append('descripcion', $("#descripcion").val());
                $('.fileD').each(function(index,value){
                    const DocFiles=$(`#${value.name}`).prop('files');
                    for (var i = 0; i < DocFiles.length; i++) {
                        //console.log(`${value.name+'_'+i}`,DocFiles[i]);
                        //formData.append(value.name+'_'+(i+1),DocFiles[i]);
                        formData.append(DocFiles[i].name+'_'+`(${value.name})`,DocFiles[i]);
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
                        if(response.code==200){
                            toastr.success("Se guardo con éxito.");
                            $('#modal_tramite').modal('hide');
                            document.getElementById('form_tramite').reset();
                            datatable.ajax.reload(null, false);
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

        window.Progresovalues = function(parametro, estado, progreso) {
            var total = parseFloat(parseInt(progreso) / parseInt(parametro));
            var color = {};
            if (estado == "LIQUIDADO" || estado == "FINALIZADO"||estado=="FINIQUITADO") {
                color = {
                    color: "#472380",
                    porcentaje: "100%",
                    mensaje: 'Se ha liquidado el siniestro'
                };
            } 
            else if (estado=='RECHAZADO') {
                color = {
                    color: "#472380",
                    porcentaje: "100%",
                    mensaje: 'Se ha rechazado el siniestro'
                };
            } 
            else if (parametro == null) {
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
                    mensaje: `Se ha liquidado el siniestro en ${days} dias`,
                    dias:days
                };
            }
            else if (estado=='RECHAZADO') {
                color = {
                    color: "#472380",
                    porcentaje: "100%",
                    mensaje: 'Se ha rechazado el siniestro',
                    dias:days
                };
            } 
            else if (parametro == null) {
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
            var color='#8c8787';
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


        window.DocumentosTramite=function(id){
            console.log("id",id);
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
                                <input type="file" class="form-control fileD" id="${string_to_slug(name)}" name="${string_to_slug(name)}" placeholder="${element.documento_nom}" onchange="listadoc('${string_to_slug(name)}')" multiple />
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
        }

        window.SeguimientoSiniestro=function(id_tramite){
            //console.log('idSe',id_tramite);
                $.ajax({
                    type: 'POST',
                    url: `${$path}Danos/getSeguimiento`,
                    data: {
                        "id": id_tramite,
                    },
                    success: async function (data) {
                        var html='';
                        var data=data.data;
                        data.forEach((element,key) => {
                            html+=`<div class="col-md-12">
                                    <ul class="media-list">
                                        <div class="media">
                                            <div class="media-body">
                                                <h5 class="media-heading"><small class="statuscomentario">
                                                <strong><i class="fa fa-user" aria-hidden="true"></i>&nbsp;
                                                ${element.name_complete}</strong></small>
                                               
                                                <small class="text-muted pull-right">${moment(element.fecha_alta).format("DD-MM-YYYY HH:mm")} <i class="fa fa-clock-o" aria-hidden="true"></i>&nbsp;</small>
                                                ${element.tram_nom==null?'':`<div class="pull-right" style="padding-right: 30px;">Trámite: ${element.tram_nom}</div>`}
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



        $("#form_add_comentario").validate({
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
                            document.getElementById('form_add_comentario').reset();
                            //var seguimiento=data.data.SeguimientoGeneral;
                            //SeguimientoGeneral(seguimiento);

                            $('#modal_seguimiento_add').modal('hide');
                            //datatable.ajax.reload();
                        }else{
                            toastr.error(response.message);
                        }
                    }            
                });
            }
        });

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

        ///ver archivos subidos
        window.jQuery(document).on('click', '.js-preview-item', function (e) {
            e.preventDefault();
            //$("#document_des").text();
            var id_doc=$(e.currentTarget).data("id");
            //console.log("id_Doc",$(e.currentTarget).data("id"));
            $('#frame_doc').attr('src', `https://docs.google.com/viewer?srcid=${id_doc}&pid=explorer&efh=false&a=v&chrome=false&embedded=true`);
            $('#frame_dow').attr('href', `https://drive.google.com/uc?id=${id_doc}&export=download`);
            $('#mdPrevies').modal('show');
            //preview.show(e.currentTarget.href, e.currentTarget.innerHTML);
        });

        $(document).on('click', '.multiselect', function(e) {
            console.log('click select')
           //alert('clic boton');
           $("ul.multiselect-container.dropdown-menu.show").css('transform', 'none');
           //$("ul.multiselect-container.dropdown-menu.show").remove('transform');
        });

        //metodos para actualizar los documentos
        var arraDocs=[];
        window.OpenModalDocs= function(id){
            $.ajax({
                    type: 'POST',
                    url: `${$path}Danos/getAllTramites`,
                    data: {
                        "id": id,
                    },
                    success: async function (data) {
                        console.log(data.data.tramites);
                        var html='<option value="0_0">Seleccione uno </option>';
                        arraDocs=data.data.tramites;
                        arraDocs.forEach((element,key) => {
                            html+=`
                                <option value="${element.info.id}_${element.info.tipo_tramite}">${element.info.tram_nom}</option>
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

       /*  $(document).on('change', '#tram_doc', function(e) {
            var fullval=$("#tram_doc").val().split('_');
            console.log(fullval);
            var docsup=DocumentosTramiteAdmin(fullval[1]);
            console.log("almDat",arraDocs);
            FindDocsTramite(parseInt(fullval[0]));
            $("#doc_anexos").html('');
            $("#doc_anexos").html(docsup);
        }); */

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
                        url: `${$path}Danos/delete_documento`,
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
                    
                    //formData.append(value.name, $(`#${value.name}`).prop('files')[0]);
                    const DocFiles=$(`#${value.name}`).prop('files');
                    for (var i = 0; i < DocFiles.length; i++) {
                        //console.log(`${value.name+'_'+i}`,DocFiles[i]);
                        //formData.append(value.name+'_'+(i+1),DocFiles[i]);
                        formData.append(DocFiles[i].name+'_'+`(${value.name})`,DocFiles[i]);
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
            url: `${baseUrl}Danos/getKpi`,
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
<!--<script src="<?=base_url()?>assets/js/jquery.sinisternotes.js"></script>-->
<script src="<?=base_url()."assets/js/jquery.notesforclaimsmodule.js"?>"></script> <!--Dennis [2022-01-14] -->
<!--modal de las aciiones de las tablas-->