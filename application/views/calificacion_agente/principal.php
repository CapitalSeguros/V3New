<??>
<!-- <meta name="viewport" content="width=900px"/> -->
<link rel='stylesheet prefetch' href='https://cdnjs.cloudflare.com/ajax/libs/bootstrap-select/1.11.2/css/bootstrap-select.min.css'>
<link rel="stylesheet" href="<?php echo base_url();?>assets/css/iconos.css">
<link rel="stylesheet" href="<?php echo base_url();?>assets/css/hover-min.css">
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.7.2/font/bootstrap-icons.css">
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-table@1.22.4/dist/bootstrap-table.min.css">
<link rel="stylesheet" href="<?php echo base_url();?>assets/css/super-star-min.css">
<link rel="stylesheet" href="<?php echo base_url();?>assets/css/bootstrap-table-style.css">
<link rel="stylesheet" href="<?php echo base_url();?>assets/css/evaluacion-agentes.min.css">

<div class="contenido" id="VisualContent" data-name="ValoracionAg">
    <div class="panel_botones" id="BtnMenuValoracionAg">
        <table class="tablaMenu table" id="PanelBotonesValoracionAg" style="position: sticky;top:0;">
            <tr>
                <td style="border-top: none;">
                    <div class="boton hvr-icon-grow active-seg" onclick="showContent(this,'Resultados')" data-div="divResultados">
                        <i class="fas fa-list-alt hvr-icon"></i>
                        <span >Resultados</span>
                    </div>
                </td>
            </tr>
            <tr>
                <td>
                    <div class="boton hvr-icon-grow" onclick="showContent(this,'Crear Evaluación')" data-div="divCreacion">
                        <i class="fas fa-edit hvr-icon" style="margin-right: -5px;"></i>
                        <span >Crear</span>
                    </div>
                </td>
            </tr>
            <tr>
                <td>
                    <div class="boton hvr-icon-grow" onclick="showContent(this,'Generar Evaluación')" data-div="divGenerar">
                        <i class="fas fa-link hvr-icon" style="margin-right: -5px;"></i>
                        <span >Generar</span>
                    </div>
                </td>
            </tr>
        </table>
    </div>
    <div class="contenidoPrincipal">
        <section class="container-fluid breadcrumb-formularios">
            <div class="row">
                <div class="col-md-6 column-flex-center-start">
                    <h3 class="title-section-module">
                        <button class="btn-burguer" id="BtnMenuBurguer" title="Menú">
                            <i class="fa fa-bars" aria-hidden="true"></i></button>
                        <span id="TitleSectionMenu">Puntuaciones del Agente</span>
                    </h3>
                </div>
            </div>
            <hr/>
        </section>
        <div class="divContenidoValoracionAg" id="divResultados">
            <? $this->load->view('calificacion_agente/resultados'); ?>
        </div>
        <div class="divContenidoValoracionAg ocultarObjeto" id="divCreacion">
            <? $this->load->view('calificacion_agente/crear'); ?>
        </div>
        <div class="divContenidoValoracionAg ocultarObjeto" id="divGenerar">
            <? $this->load->view('calificacion_agente/generar'); ?>
        </div>
    </div>
</div>

<div id="base_url" data-base-url="<?=base_url()?>"></div>

<? $this->load->view('calificacion_agente/modals'); ?>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@3.4.1/dist/js/bootstrap.min.js" integrity="sha384-aJ21OjlMXNL5UyIl/XNwTMqvzeRMZH2w8c5cRVpzpU8Y5bApTppSuUkhZXN0VxHd" crossorigin="anonymous"></script>
<script src="//cdnjs.cloudflare.com/ajax/libs/bootstrap-select/1.6.3/js/bootstrap-select.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/apexcharts"></script>
<script src="<?=base_url()?>/assets/gap/js/datatables.js"></script>
<script src="<?=base_url()?>/assets/js/basic-operations.js"></script>
<script src="<?=base_url()?>/assets/js/evaluacion-agentes.min.js"></script>