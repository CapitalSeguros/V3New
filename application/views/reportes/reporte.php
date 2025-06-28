<?php 
	$this->load->view('headers/header'); 
?>
<!-- Navbar -->
<?php
	$this->load->view('headers/menu');
/*
	function formatDate($date){
		$tmpDate = new DateTime($date);
		echo $tmpDate->format('Y/m/d');
	}
	function formatMoney($num){
		echo '$ '.number_format((Double)$num, 2, '.', ',');
	}
*/
?>

<style>
		th,tr{
			font-size:12px;			
		}
		table.dataTable tbody th, table.dataTable tbody td {
			padding: 4px 0px !important;
		}
		td a.link_report{
			padding: 8px 5px !important;
		}
		.modal-preload { 
		position: fixed;
		top: 50% !important; 
		left: 50% !important; 
		margin-top: -50px;  
		margin-left: -45px; 
		/*    overflow: visible !important;*/
		}
		.modal-preload,
		.modal-preload .modal-dialog,
		.modal-preload .modal-content {
			width: 100px; 
			height: 90px; 
		}

		.modal-preload .modal-content {
			background: rgba(255,255,255,.90);
			border: 0px;
		}
		.modal-preload .modal-dialog,
		.modal-preload .modal-content {
			padding: 0 !important; 
			margin: 0 !important;
		}
		.modal-preload .modal-content .icon {
		}
		.modal-preload .modal-content small{
			font-size: 10px;
		}
		.showPoliza{
			cursor: pointer; cursor: hand;
		}
		.not-btn{
			display: none;
		}
</style>
<!--:::::::::: INICIO CONTENIDO ::::::::::-->
<section class="container-fluid breadcrumb-formularios">
	<div class="row">
		<div class="col-md-6 col-sm-5 col-xs-5">
			<div id="dvDescarga" class="text-right <?php echo ($activeReporte)? '':'not-btn'; ?>">
				<a id="btDescarga" href="#" class="btn btn-default input-sm">Ver Descarga</a>		
			</div>
		</div>
    </div>
	<div class="row">
		<div class="col-md-6 col-sm-5 col-xs-5">
			<h3 class="titulo-secciones">Reportes</h3>
		</div>
		<div class="col-md-6 col-sm-7 col-xs-7">
			<ol class="breadcrumb text-right">
            	<? $consultarView = ($consultar=="Produccin")?'Producci&oacute;n':$consultar ?>
          		<li><a href="<?=base_url()?>">Inicio</a></li>
				<li><a href="<?=base_url()."reportes"?>">Reportes</a></li>
				<li class="active"><?=$consultarView?></li>
			</ol>
		</div>
	</div>
	<hr /> 
</section>

<!-- End navbar -->
<section class="container-fluid">    
	<div class="row">
		<div class="col-md-12">
			<!--Inicio del reporte-->
			<?
			if(isset($meses)){
			?>
			<div class="row">
				<div class="col-md-3">
					<select id="stMeses" name="meses" class="form-control">
						<option value="">Todos</option>
						<? foreach($meses as $key => $value){ ?>
							<option value="<?=$key; ?>">
								<?=$value; ?>
                            </option>
						<? }?>
						</select>
				</div>
			</div>
			<?
			}
			?>
			<div class="row">
				<div class="col-md-12">
					<form
                    	id="frmReporte"
						method="POST"
                    	action="<?=base_url()?>reportes/verReporte" 
                    >
					<input type="hidden" name="cliente"		value="<?=$cliente?>"/>
					<input type="hidden" name="ramo"		value="<?=$ramo?>"/>
					<input type="hidden" name="subramo"		value="<?=$subramo?>"/>
					<input type="hidden" name="fechaini"	value="<?=$fechaini?>"/>
					<input type="hidden" name="fechafin"	value="<?=$fechafin?>"/>
					<input type="hidden" name="poliza"		value="<?=$poliza?>"/>
					<input type="hidden" name="estatus"		value="<?=$estatus?>"/>
					<input type="hidden" name="vendedor"	value="<?=$vendedor?>"/>
					<input type="hidden" name="grupo"		value="<?=$grupo?>"/>
					<input type="hidden" name="subgrupo"	value="<?=$subgrupo?>"/>
					<input type="hidden" name="habilitarf"	value="<?=$habilitarf?>"/>
				<? if(isset($mes)){ ?>
					<input type="hidden" name="mes"			value="<?=$mes?>"/>
				<? } ?>
					<input type="hidden" name="consultar"	value="<?=$consultar?>"/>
					<input type="hidden" name="page"		value="<?=$page?>"/>
					<table  name="reporte" id="reporte" cellspacing="0" width="100%">
						<thead>
						<!--EMPIEZA EL NOMBRE DE LAS COLUMNAS-->
							<tr class="act-tr-level-undefined">
								<th>#</th>
								<th>Tipo</th>
								<th>Documento</th>
							<?
								if($consultar=="Cobranza Pendiente" || $consultar=="Cobranza Efectuada" || $consultar=="Cobranza Cancelada"){
							?>
								<th>Serie</th>
							<?
								}
							?>
								<th>Anterior</th>
								<th>Posterior</th>
								<th>Desde</th>
                                 <th>Fecha limite</th>
								<th>Hasta</th>
								
								<th>Estatus</th>
								<th class="cliente">Cliente</th>
								<th>Grupo</th>
								<th>Sub Grupo</th>
								<th class="compania">Concepto</th>
								<th class="compania">Referencia 1</th>
								<th class="compania">Referencia 2</th>                                            
								<th>No Folio</th>   
								<th>Moneda</th>
								<th>Forma de pago</th>
								<th>Clave de agente</th>
								<th class="compania">Compa&ntilde;ia</th>
								<th>Sub Ramo</th>
								<th>Prima neta</th>
								<th>Prima total</th>
								<th class="compania">Ejecutivo</th>
								<th class="compania">Vendedor</th>
						<!--TERMINA EL NOMBRE DE LAS COLUMNAS-->
							</tr>
						<thead>
						<tfoot>
							<tr>
								<th></th>
								<th>Tipo</th>
								<th>Documento</th>
							<?
								if($consultar=="Cobranza Pendiente" || $consultar=="Cobranza Efectuada" || $consultar=="Cobranza Cancelada"){
							?>
								<th>Serie</th>
							<?
								}
							?>
								<th>Anterior</th>
								<th>Posterior</th>
								<th>Desde</th>

								<th>Hasta</th>

								<th>Estatus</th>
								<th class="cliente">Cliente</th>
								<th>Grupo</th>
								<th>Sub Grupo</th>
								<th class="compania">Concepto</th>
								<th class="compania">Referencia 1</th>
								<th class="compania">Referencia 2</th>                                            
								<th>No Folio</th>   
								<th>Moneda</th>
								<th>Forma de pago</th>
								<th>Clave de agente</th>
								<th class="compania">Compa&ntilde;ia</th>
								<th>Sub Ramo</th>
								<th>Prima neta</th>
								<th>Prima total</th>
								<th class="compania">Ejecutivo</th>
								<th class="compania">Vendedor</th>
							</tr>
						</tfoot>
					</table>
					</form>
				</div>
			</div>
			<!--Fin del reporte-->

			<!-- container del los colores de los reportes -->
			<div class="container">
				<?php if ($consultar == "Renovacin"): ?>
					<div class="row" style="background: #472380;margin-top:10px;padding-top:10px;padding-bottom:10px;">				
						<div class="col-md-offset-1 col-md-2 col-sm-2" >
							<span class="glyphicon glyphicon-bookmark" style="color: white;"> Pendientes</span>
						</div>
						<div class=" col-md-2 col-sm-2 " >
							<span class="glyphicon glyphicon-bookmark" style="color: #0000FF;"> Renovadas</span>
						</div>
						<div class="col-md-2 col-sm-2 " >
							<span class="glyphicon glyphicon-bookmark" style="color: #FFFF00;"> No Renovada</span>
						</div>
						<div class="col-md-2 col-sm-2 " >
							<span class="glyphicon glyphicon-bookmark" style="color: #FF0000;"> Canceladas</span>
						</div>
						<div class="col-md-2 col-sm-2 " >
							<span class="glyphicon glyphicon-bookmark" style="color: #FF9900;"> Anuladas</span>
						</div> 				           
					</div>
				<?php endif ?>	
			</div>
			<!-- Fin container del los colores de los reportes -->
		</div>		       	
	</div>
</section>
<!--..::::::::::::::::::::================ INICIO MODAL PRELOAD AJAX 
CARGA EL GIF MIENTRAS TRAE LA INFORMACION A CONSULTAR ================::::::::::::::::::::..-->
<div id="modalPreload" class="modal fade">
	<div class="modal-preload">
		<div class="modal-dialog">
			<div class="modal-content">
				<div class="modal-body">
					<div class="text-center">
						<img src="<?php echo base_url() ?>assets/img/loading.gif" class="icon" />
						<small>PROCESANDO...</small>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>
<!--..::::::::::::::::::::================ FIN MODAL PRELOAD AJAX ================::::::::::::::::::::..-->

<!--..:::::::::::::::============MODAL DETALLE===============::::::::::::::::..-->
<div id="detallePoliza" class="modal fade bs-example-modal-lg" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" >
  <div class="modal-dialog modal-lg">
    <div class="modal-content">
		<div class="modal-header">
			<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
			<h4 class="modal-title" id="titleModal"></h4>
		</div>
		<div class="modal-body">
			      <form action="#" method="POST" id="frmBuscador">
    		<div class="row">
    	           <div class="col-md-12">
                        <div class="row">
                            <div class="col-md-4">
                                <label for="tipodoc">Tipo Documento</label>
                                <p id="tpDoc"></p>
                            </div>
                            <div class="col-md-4">
                                <label for="solicitud">Solicitud</label>
                                <p id="solicitud"></p>
                            </div>
                            <div class="col-md-4">
                                <label for="anterior">Anterior</label>
                                <p id="anterior"></p>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-4">
                                <label for="polizamaestra">P&oacute;liza Maestra</label>                       
                                <p id="pMaestra"></p>
                            </div>
                            <div class="col-md-4">
                                <label for="documento">Documento</label>
                                <p id="documento"></p>
                            </div>
                            <div class="col-md-4">
                                <label for="posterior">Posterior</label>
                                <p id="posterior"></p>
                            </div>
                        </div>
                   </div>
    		</div>
            <div class="row row-individual">
                <div class="col-md-12">
                    <div id="wizard">
                        <h3>General</h3>
                        <section>
                            <div class="row row-tabs">
                                <div class="col-md-9">
                                    <div class="row row-tabs">
                                        <div class="form-gropup col-md-6">
                                            <div class="row row-tabs">
                                                <div class="col-md-12">
                                                    <label for="cliente">Cliente</label>
                                                    <p id="cliente"></p>
                                                </div>
                                            </div>
                                            <div class="row row-tabs">
                                                <div class="col-md-12">
                                                    <label for="direccion">Direcci&oacute;n</label>
                                                    <p id="direccion"></p>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="form-gropup col-md-6">
                                            <div class="row row-tabs">
                                                <div class="col-md-12">
                                                    <label for="agente">Agente</label>
                                                    <p id="agente"></p>
                                                    <p id="agenteN"></p>
                                                    <p id="agenteci"></p>
                                                </div>
                                            </div>
                                            <div class="row row-tabs">
                                                <div class="col-md-12">
                                                    <label for="ejecutivo">Ejecutivo de Compa&ntilde;ia</label>
                                                    <p id="ejecutivo"></p>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row row-tabs">
                                        <div class="form-gropup col-md-6">
                                            <div class="row row-tabs">
                                                <div class="form-group col-md-6">
                                                    <label for="fechaini">Desde</label>
                                                    <div class="input-group">
                                                        <p id="desde"></p>
                                                    </div>
                                                </div>
                                                <div class="form-group col-md-6">
                                                    <label for="fechafin">Hasta</label>
                                                    <div class="input-group">
                                                        <p id="hasta"></p>
                                                    </div>
                                                </div>
                                            </div>
                                             <div class="row row-tabs">
                                                <!-- <div class="form-group col-md-6">
                                                    <label for="fechaantiguedad">Fecha de antiguedad</label>
                                                    <div class="input-group">
                                                        <p id="fechaantiguedad"></p>
                                                    </div>
                                                </div> -->
                                                <div class="form-group col-md-6">
                                                    <label for="renovacion">Renovaci&oacute;n</label>
                                                    <p id="renovacion"></p>
                                                </div>
                                            </div>
                                            <!-- <div class="row row-tabs">
                                                <div class="col-md-12">
                                                    <label for="pagos">Celendario de Pagos</label>
                                                    <p id="pagos"></p>
                                                </div>
                                            </div> -->
                                        </div>
                                        <div class="form-gropup col-md-6">
                                            <div class="row row-tabs">
                                                <div class="col-md-8">
                                                    <label for="moneda">Moneda</label>
                                                    <p id="moneda"></p>
                                                </div>
                                                <!-- <div class="col-md-4">
                                                    <label for="tipocambio">Tipo de Cambio</label>
                                                    <p id="tipocambio"></p>
                                                </div> -->
                                            </div>
                                            <div class="row row-tabs">
                                                <div class="col-md-12">
                                                    <label for="formapago">Forma de pago</label>
                                                    <p id="formapago"></p>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="rew row-tabs">
                                        <div class="col-md-12">
                                            <label for="cvendedor">Vendedor</label>
                                            <p id="cvendedor"></p>
                                        </div>
                                    </div>
                                    <div class="rew row-tabs">
                                        <div class="col-md-12">
                                            <label for="cejecutivo">Ejecutivo</label>
                                            <p id="cejecutivo"></p>
                                        </div>
                                    </div>
                                    <div class="rew row-tabs">
                                        <div class="col-md-12">
                                            <label for="grupo">Grupo</label>
                                            <p id="grupo"></p>
                                        </div>
                                    </div>
                                    <div class="rew row-tabs">
                                        <div class="col-md-12">
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="row row-tabs">
                                <div class="col-md-12">
                                    <label for="concepto">Concepto</label>
                                    <p id="concepto"></p>
                                </div>
                            </div>
                            <div class="row row-tabs">
                            	<div id="tree_menu" class="col-md-12">
            				       
                            	</div>		
                            </div>
                        </section>
                    </div>
                </div>
            </div>
        </form>
		</div>
		<div class="modal-footer">
			<button type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button>			
		</div>
    </div>
  </div>
</div>
<!--..::::::::::::::::::::================ FIN MODAL ================::::::::::::::::::::..-->
<!--..::::::::::::::::::::================ INICIO MODAL 
DESPLIEGA UN MENSAJE PARA LA DESCARGA DE EXCEL================::::::::::::::::::::..-->
<div id="confirm" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLl" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
		<div class="modal-header">
			<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
			<h4 class="modal-title" id="titleModal">Generar Excel</h4>
		</div>
		<div class="modal-body">
			<div class="alert alert-info" role="alert">
			  <span class="glyphicon glyphicon-exclamation-sign" aria-hidden="true"></span>
			  <span class="sr-only">Informacii&oacute;n:</span>
			  Desea generar el reporte de la pagina actual o generar el reporte completo; En caso de generar reporte completo, espere hasta que se genere
			</div>
		</div>
		<div class="modal-footer">
			<button type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button>
			<button type="button" class="btn btn-default" id="pagvisible"><i></i> P&aacute;gina visible</button>
			<button type="button" class="btn btn-primary" id="pagcomplete"><i></i> P&aacute;gina completa</button>			

		</div>
    </div>
  </div>
</div>
<!--..::::::::::::::::::::================ FIN MODAL ================::::::::::::::::::::..--><!--..::::::::::::::::::::================ INICIO MODAL ================::::::::::::::::::::..-->
<div id="confirm_bitacora" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myLarge" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
		<div class="modal-header">
			<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
			<h4 class="modal-title" id="titleModal">Generar Excel: Bitacora</h4>
		</div>
		<div class="modal-body">
			<div class="alert alert-info" role="alert">
			  <span class="glyphicon glyphicon-exclamation-sign" aria-hidden="true"></span>
			  <span class="sr-only">Informacii&oacute;n:</span>
			  Desea generar el reporte de la pagina actual o generar el reporte completo; En caso de generar reporte completo, espere hasta que se genere
			</div>
		</div>
		<div class="modal-footer">
			<button type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button>
			<button type="button" class="btn btn-default" id="pagvisible"><i></i> P&aacute;gina visible</button>
			<button type="button" class="btn btn-primary" id="pagcomplete"><i></i> P&aacute;gina completa</button>			
		</div>
    </div>
  </div>
</div>
<!--..::::::::::::::::::::================ FIN MODAL ================::::::::::::::::::::..-->
<!--..::::::::::::::::::::================ FIN MODAL ================::::::::::::::::::::..--><!--..::::::::::::::::::::================ INICIO MODAL ================::::::::::::::::::::..-->
<div id="confirm_vacio" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
		<div class="modal-header">
			<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
			<h4 class="modal-title title-text" id="titleModal" >Generar Excel: Vacio</h4>
		</div>
		<div class="modal-body">
			<div class="alert alert-warning info-text" role="alert">
			  <span class="glyphicon glyphicon-exclamation-sign" aria-hidden="true"></span>
			  <span class="sr-only">Informacii&oacute;n:</span>
			  No se puede generar un reporte en excel vac&iacute;o.
			</div>
			<div id="dvNote"><p>Nota: <b>Descargar</b> utilizá la información con la fecha indicada, <b>Generar</b> se descargara de nuevo toda la información.</p></div>
		</div>
		<div class="modal-footer">
			<button id="bnCerrar" type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button>
			<button  type="button" class="btn btn-primary bnDescargarActual" ><i></i> Descargar</button>
			<button id="bnNuevo" type="button" class="btn btn-primary" ><i></i> Generar</button>
		</div>
    </div>
  </div>
</div>
<div id="confirm_error" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
		<div class="modal-header">
			<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
			<h4 class="modal-title" id="titleModal">Generar Excel: <span class="title-error"></span></h4>
		</div>
		<div class="modal-body">
			<div class="alert alert-danger" role="alert">
			  <span class="glyphicon glyphicon-exclamation-sign" aria-hidden="true"></span>
			  <span class="sr-only">Informacii&oacute;n:</span>
			  <div class="info-error">
			  </div>
			</div>			
		</div>
		<div class="modal-footer">
			<button type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button>
		</div>
    </div>
  </div>
</div>

<div id="confirm_status" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
		<div class="modal-header">
			<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
			<h4 class="modal-title" id="titleModal">Estado del reporte: <span class="title-error"></span></h4>
		</div>
		<div class="modal-body">

			
			<div class="alert alert-warning" role="alert">
			  <div class="info-error">
			  </div>
			</div>			
			<div class="progress">
			  <div class="progress-bar progress-bar-striped active" role="progressbar" aria-valuenow="0" aria-valuemin="0" aria-valuemax="100" style="width: 0%">
			    <span class="sr-only">0% Complete</span>
			  </div>
			</div>
		</div>
		<div class="modal-footer">
			<button type="button" class="btn btn-primary bnDescargarActual not-btn" ><i></i> Descargar</button>
			<button type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button>
		</div>
    </div>
  </div>
</div>


<!--..::::::::::::::::::::================ FIN MODAL ================::::::::::::::::::::..-->

<link rel="stylesheet" type="text/css" href=" <?php echo site_url('assets/css/jquery.dataTables.css'); ?>">

<script type="text/javascript" charset="utf8" src="<?php echo site_url('assets/js/jquery.dataTables.js'); ?>"></script>
<script src="<?php echo site_url('assets/js/aCollapTable.js'); ?>"></script>
<script>

function getURLParameter(name) {
  return decodeURIComponent((new RegExp('[?|&]' + name + '=' + '([^&;]+?)(&|#|;|$)').exec(location.search)||[,""])[1].replace(/\+/g, '%20'))||null;
}

$(document).ready(function(){

	var fecha = $('body').on('focus','.fecha',function(){
        $(this).datepicker({
            format: "dd/mm/yyyy",
            startDate: "01/01/1900",
            language: "es",
            autoclose: true,
			orientation: "top auto"

        });
    });
	
	$('#reporte tfoot th').each( function () {
        var title = $(this).text();
		
		var dType = $(this).attr('data-type');
        var sClass = "";
        if (typeof dType !== typeof undefined && dType !== false) {
            sClass = " fecha ";
        }
		
		if(title == ""){
			$(this).html( '<span class="btn btn-default exportexcel"><i class="fa fa-file-excel-o"></i> Excel</span>' );
		}else{
			$(this).html( '<input type="text" name="'+title.replace(/ /g,"_").toLowerCase() +'" class="' + sClass + '" placeholder="Buscar por '+title+'" />' );
		}         
    });
	
	var table =	$('#reporte').on('preXhr.dt', function( e, settings, data ){
		
        	data.cliente 	= getURLParameter('cliente'); //$("input[name=cliente]").val();
        	data.ramo		= getURLParameter('ramo'); //$("input[name=ramo]").val();
        	data.subramo 	= getURLParameter('subramo'); //$("input[name=subramo]").val();
        	data.fechaini 	= getURLParameter('fechaini');  //$("input[name=fechaini]").val();
        	data.fechafin 	= getURLParameter('fechafin'); //$("input[name=fechafin]").val();
        	data.poliza 	= getURLParameter('poliza'); //$("input[name=poliza]").val();
        	data.estatus 	= getURLParameter('estatus'); //$("input[name=estatus]").val();
        	data.vendedor 	= getURLParameter('vendedor'); // $("input[name=vendedor]").val();
        	data.grupo 		= getURLParameter('grupo');  //$("input[name=grupo]").val();
        	data.subgrupo 	= getURLParameter('subgrupo');  //$("input[name=subgrupo]").val();
        	data.promotor 	= getURLParameter('promotor'); //$("input[name=promotor]").val();
        	data.consultar 	= getURLParameter('consultar');  //$("input[name=consultar]").val();
        	data.page 		= 1;
        	data.habilitarf = $("input[name=habilitarf]").val();

        	<?php if (isset($mes)): ?>
			data.mes 		= $("input[name=mes]").val();
			<?php endif ?>
				data.search_d   = function(){
                var input = $('#reporte > tfoot').find("input");
                data_value = [];
                var _array = "[";

                var count = input.size();

                $.each(input,function(index, value){

                    var name = $(value).attr("name");
                    var val = $(value).attr("data-value");


                    if(typeof val === "undefined"){
                        val = "";
                    }

                    if(name != "" && val != ""){
                        var indice = index;
                        var sType = "";
                        if($(value).hasClass('fecha')){
                            sType = "date";
                        }else{
                            sType = "text";
                        }
                        _array += '{"id":"'+ indice + '", "val":"' + val + '", "type":"'+sType+'"},';    
                    }
                }); 
                
                _array = _array.substring(0, _array.length - 1);
                _array += "]";

                return _array;  
            };

	    	}).on( 'processing.dt', function ( e, settings, processing ) {

				console.log("prosesando...");
	    		if(processing){
					$('#modalPreload').modal({
			            show: true,
			            backdrop: "static"
			        });	    			
	    		}else{
	    			$('#modalPreload').modal('hide');
	    		}

				// $('#processingIndicator').css( 'display', processing ? 'block' : 'none' );
		} )
	    .DataTable( {
	        processing: true,
			serverSide: true,
			searching:false,
			scrollX: true,
			lengthChange: false,
			pageLength: 25,
			ajax:{
				url: "<?php echo base_url();?>reportes/verReporteAjax",
				type: 'POST',
				error:function(er,settings){
					console.log(er);
					
					$('#modalPreload').modal('hide');
				}
			},
			language:{
			    "sProcessing":     "",
			    "sLengthMenu":     "Mostrar _MENU_ registros",
			    "sZeroRecords":    "No se encontraron resultados",
			    "sEmptyTable":     "Ning&uacute;n dato disponible en esta tabla",
			    "sInfo":           "Mostrando registros del _START_ al _END_ de un total de _TOTAL_ registros",
			    "sInfoEmpty":      "Mostrando registros del 0 al 0 de un total de 0 registros",
			    "sInfoFiltered":   "(filtrado de un total de _MAX_ registros)",
			    "sInfoPostFix":    "",
			    "sSearch":         "Buscar:",
			    "sUrl":            "",
			    "sInfoThousands":  ",",
			    "sLoadingRecords": "Cargando...",
			    "oPaginate": {
			        "sFirst":    "Primero",
			        "sLast":     "&Uacute;ltimo",
			        "sNext":     "Siguiente",
			        "sPrevious": "Anterior"
			    },
			    "oAria": {
			        "sSortAscending":  ": Activar para ordenar la columna de manera ascendente",
			        "sSortDescending": ": Activar para ordenar la columna de manera descendente"
			    }
			},
			aoColumns:[
			 	{
                   "mDataProp": null,
                   "sClass": "control center",
                   "sDefaultContent": '<span class="glyphicon glyphicon-check">',
                   "orderable": false
                },
				// {"data":"IDCli"},
				   //IMPRIME COLUMNAS DE REPORTES
                   
                    {"data":"TipoDocto"<?php if ($consultar == "Cobranza Pendiente" || $consultar == "Cobranza Efectuada" || $consultar == "Cobranza Cancelada"){echo ' , "orderable": false'; }?>},
                
				{"data":"Documento"},
				<?php if ($consultar == "Cobranza Pendiente" || $consultar == "Cobranza Efectuada" || $consultar == "Cobranza Cancelada"){ ?>
					{"data":"Serie"},
				<?php } ?>
                {"data":"DAnterior"},
                  
                    {"data":"DPosterior"<?php if ($consultar == "Cobranza Pendiente" || $consultar == "Cobranza Efectuada" || $consultar == "Cobranza Cancelada"){echo ' , "orderable": false'; }?>},    
           
				{"data":"FDesde"},
				//LOCM
				{"data":"FLim"},
				{"data":"FHasta"},
				{"data":"Status"},
				{"data":"NombreCompleto"},
				{"data":"Grupo"},
				{"data":"SubGrupo"},
				{"data":"Concepto"},
				{"data":"Referencia1"},
				{"data":"Referencia2"},
                    {"data":"FolioNo"<?php if ($consultar == "Cobranza Pendiente" || $consultar == "Cobranza Efectuada" || $consultar == "Cobranza Cancelada"){echo ' , "orderable": false'; }?>},
				
				{"data":"Moneda"},
				{"data":"FPago"},
				{"data":"CAgente"},
				{"data":"AgenteNombre"},
				{"data":"SRamoAbreviacion"},
				{"data":"PrimaNeta"},
				{"data":"PrimaTotal"},
				{"data":"EjecutNombre"},
				{"data":"VendNombre"},
			],
			"fnRowCallback": function( nRow, aData, iDisplayIndex, iDisplayIndexFull ) {

				$(nRow).find('td:eq(2)').addClass('showPoliza');
                <?php if ($consultar == "Cobranza Pendiente" || $consultar == "Cobranza Efectuada" || $consultar == "Cobranza Cancelada"){ ?>
                    $(nRow).find('td:eq(4)').addClass('showPoliza');
                    $(nRow).find('td:eq(5)').addClass('showPoliza');

                <?php }else{?>
                    $(nRow).find('td:eq(3)').addClass('showPoliza');
                    $(nRow).find('td:eq(4)').addClass('showPoliza');

                <?php }?>
				<?php if ($consultar == "Renovacin"): ?>
					switch(aData.Status){
						case 'Vigente':

						break;
						case 'Renovada':
							$(nRow).css('background','#0000FF');
							$(nRow).css('color','#FFFFFF');
						break;
						case 'No Renovada':
							$(nRow).css('background','#FFFF00');
						break;
						case 'Cancelada':
							$(nRow).css('background','#FF0000');
							$(nRow).css('color','#FFFFFF');
						break;
						case 'Anulada':
							$(nRow).css('background','#FF9900');
						break;
					}
				<?php endif ?>


		    }
	    });	
		
		function clearTable(){
			if(table != null){
				table.clear.draw();	
			}			
		}
		
		table.columns().every( function () {
			var that = this;
			$( 'input', this.footer() ).on( 'keyup change', function (event) {				
				if(this.value.length > 3){
					$("input[name=" + this.name + "]").attr("data-value",this.value);
					
					if ( that.search() !== this.value ) {						
						that.search(this.value).draw();
					}
				}else{
					if(event.keyCode == 8){						
						$("input[name=" + this.name + "]").attr("data-value",this.value);					
						if ( that.search() !== this.value ) {						
							that.search(this.value).draw();
						}else if(this.value.length == 0){
							that.search(this.value).draw();
						}
					}
				}
			});
		});

		/*********************************************/
		$('.exportexcel').on('click',function(){


			var data = table;
			var json_table = data.ajax.json();
			if(json_table.recordsTotal == 0){					
					$("#confirm_vacio").modal('show');	
			}else{
				$('#confirm').modal({ 
									backdrop: 'static', 
									keyboard: false 
				}).one('click', '#pagvisible', function() {
						
						addclassbutton('#pagvisible');
						JSONToCSVConvertor(json_table.data, "Capsys", true);
						closemodal('#confirm');
						$(".bnDescargarActual").hide();
						$("#bnNuevo").hide();
						$("#dvNote").hide();
						$(".title-text").text("Descarga Completa");
						$(".info-text").text("Se ha completado la descarga del excel de la pagina visible.");
						$("#confirm_vacio").modal("show");
						
						removeclassbutton('#pagvisible');
				}).one('click', '#pagcomplete', function() {
					
					var oData = data.ajax.params();
					oData.isNew = false;
					addclassbutton('#pagcomplete');
					$.ajax({
					  type: "POST",
					  dataType: "json",
					  url: "<?php echo base_url();?>reportes/getExcelAjax",
					  data: oData
					}).done(function( msg ) {
						if(msg.data.status){
							$(".title-text").text("Éxito");
							$(".bnDescargarActual").hide();
							$("#bnNuevo").hide();
							$("#dvNote").hide();
							$("#bnCerrar").show();
							$("#dvDescarga").show();

						}else{
							if(msg.data.disabled_controls){
								$(".title-text").text("Advertencia");
								$("#bnCerrar").show();
								$("#bnNuevo").hide();
								$("#dvNote").hide();
								$(".bnDescargarActual").hide();
							}else{
								$(".title-text").text("Advertencia");
								$("#bnCerrar").hide();
								$("#bnNuevo").show();
								$("#dvNote").show();
								$(".bnDescargarActual").show();	
							}

							
						}

						$(".info-text").text(msg.data.message);
						//JSONToCSVConvertor(msg.data, "Capsys", true);
					}).fail(function() {							
						$("#title-error").text("Error al generar documento");
						$("#info-error").text("Ocurrio un error al generar el excel completo de los documentos, revise que su conexion");
					
						removeclassbutton('#pagcomplete');
					}).always(function() {
						closemodal('#confirm');
						
						$("#confirm_vacio").modal({
							backdrop: 'static',
							keyboard: false 
						}).one('click','#bnNuevo',function(){

							addclassbutton('#bnNuevo');
							var oData = data.ajax.params();
							oData.isNew = true;

							$.ajax({
							  type: "POST",
							  dataType: "json",
							  url: "<?php echo base_url();?>reportes/getExcelAjax",
							  data: oData
							}).done(function( msg ) {

								if(msg.data.status){
									$(".title-text").text("Éxito");
									$(".bnDescargarActual").hide();
									$("#bnNuevo").hide();
									$("#dvNote").hide();
									$("#bnCerrar").show();
									$("#dvDescarga").show();

								}else{
									$(".title-text").text("Advertencia");
									$("#bnCerrar").show();
								}
								$(".info-text").text(msg.data.message);
								//JSONToCSVConvertor(msg.data, "Capsys", true);
							}).always(function(){
								removeclassbutton('#bnNuevo');
							});

							

						}).one('click','.bnDescargarActual',function(){

							addclassbutton('.bnDescargarActual');

							var link = document.createElement("a");    
						    link.href = "<?php echo base_url();?>reportes/descarReporte/"+getURLParameter('consultar');
						    
						    //set the visibility hidden so it will not effect on your web-layout
						    link.style = "visibility:hidden";
						    link.target = "_blank";
						    link.click();
						    removeclassbutton('.bnDescargarActual');
						    $('#confirm_vacio').modal('hide');


							// $.ajax({
							//   type: "POST",
							//   dataType: "json",
							//   url: "<?php echo base_url();?>reportes/descarReporte",
							//   data: {consultar: getURLParameter('consultar')}
							// }).done(function( msg ) {
								
							// 	JSONToCSVConvertor(msg.data, "Capsys", true);
							// 	$('#confirm_vacio').modal('hide');
							// }).always(function(){
							// 	removeclassbutton('.bnDescargarActual');	
							// });
							

						});

						removeclassbutton('#pagcomplete');
					});
					
					
				});	
			}		
			 				
		});
		

		/*********************************************/


	function format ( d ) {

		//** d.IDDoctoPosterior = "N136011582";
	    return '<table class="sub-dt" cellspacing="0" border="0">'+
					'<thead>' + 
						'<tr>' + 
							'<th style="100px">Fecha</th>' + 
							'<th style="100px">Comentario</th>' + 
						'</tr>' + 
					'</thead>'+
					'<tfoot>' + 
						'<tr>' + 
							'<th colspan="2" style="100px">' + 
								'<a href="#" class="btn btn-default exportexcelpoliza">' + 
									'<i class="fa fa-file-excel-o"></i>' + 
									'Excel Poliza' 
									+ '</a>' + 
							'</th>' + 							
						'</tr>' + 
					'</tfoot>'+
				'<tbody></tbody>'+
			'</table>'+
	    '<table><tr>'+
	    	<?
				if($consultar == "Cobranza Pendiente" || $consultar == "Cobranza Efectuada" || $consultar == "Cobranza Cancelada"){
			?>
	    	'<td>'+
				'<a href="<?=base_url()."actividades/agregar/CambioFormaPago"?>" class="link_report" data-idDocto="'+d.IDDocto+'" data-ramo="'+d.RamosNombre.toUpperCase()+'">Cambio Forma de Pago</a>'+
	    	'</td>'+
			
	    	'<td><a href="<?php echo base_url() . "actividades/agregar/PagoCobranza"?>" class="link_report" data-idDocto="'+d.IDDocto+'" data-ramo="'+d.RamosNombre.toUpperCase()+'" >Pago Cobranza</a></td>'+	
	    	<?
				} else {
			?>
	    	'<td><a href="<?php echo base_url() . "actividades/agregar/Cotizacion"?>" class="link_report" data-idDocto="'+d.IDDocto+'" data-ramo="'+d.RamosNombre.toUpperCase()+'" >Cotizacion</a></td>'+
	    	'<td><a href="<?php echo base_url() . "actividades/agregar/Emision"?>" class="link_report" data-idDocto="'+d.IDDocto+'" data-ramo="'+d.RamosNombre.toUpperCase()+'">Emision</a></td>'+	
	    	<?
				}
			?>
	    	'<td>'+
				'<a class="link_report" href="<?=base_url()."actividades/agregar/Endoso"?>" data-idDocto="'+d.IDDocto+'" data-ramo="'+d.RamosNombre.toUpperCase()+'" data-idDoctoPosterior="'+d.IDDoctoPosterior+'">Endoso</a>'+
			'</td>'+
			
	    	'<td>'+
				'<a href="<?=base_url()."actividades/agregar/Cancelacion"?>" class="link_report" data-idDocto="'+d.IDDocto+'" data-ramo="'+d.RamosNombre.toUpperCase()+'">Cancelacion</a>'+
			'</td>'+
			
	    	'<td>'+
				'<a href="<?=base_url()."actividades/agregar/Diligencia"?>" class="link_report" data-idDocto="'+d.IDDocto+'" data-ramo="'+d.RamosNombre.toUpperCase()+'">Diligencia</a>'+
			'</td>'+

	    	'<td>'+
				'<a href="<?=base_url()."actividades/agregar/CapturaRenovacion"?>" class="link_report" data-idDocto="'+d.IDDocto+'" data-ramo="'+d.RamosNombre.toUpperCase()+'">Captura Renovacion</a>'+
			'</td>'+
	    	
			<!-- '<td><a href="<?php echo base_url() . "actividades/agregar/Enviar"?>" class="link_report" data-idDocto="'+d.IDDocto+'" data-ramo="'+d.RamosNombre.toUpperCase()+'">Enviar</a></td>'+

	    '</tr></table>';
	}

	Date.prototype.yyyymmdd = function() {
       var yyyy = this.getFullYear().toString();
       var mm = (this.getMonth()+1).toString(); // getMonth() is zero-based
       var dd  = this.getDate().toString();
	   
       return  (dd[1]?dd:"0"+dd[0])+"/"+ (mm[1]?mm:"0"+mm[0])+"/"+ yyyy; // padding
    };
	


	function getValue(data){
		var resl = '';
		if(data != null){
			if(typeof data == 'object'){
				resl = '';
			}else{
				resl = data;
			}
		}else{
			resl = '';
		}

		return resl;
	}

	$('#reporte').on('click','.showPoliza',function(){
		
		var parent = $(this).closest('tr');
		var data = table.row(parent).data();

		var doc = $(this).html();
		var consul = getURLParameter('consultar');

		if(doc == '' || consul == ''){
			return;
		}
		var data_json = {"Documento":doc,"Consultar": consul };
/*		
		$('#modalPreload').modal({
            show: true,
            backdrop: "static"
        });
*/
		$('#modalPreload').modal('show');
		
		$.ajax({
				url: '<?php echo base_url()."reportes/GetPolizaAnt"; ?>',
				// url: '<?php echo base_url()."reportes/GetPolizaAnt"; ?>/'+doc+'/'+consul,
				type: 'POST',
				data: data_json,
				success: function (data) {
					
					data = jQuery.parseJSON(data);
					console.log(data);

					$('#titleModal').html(getValue('Poliza: '+data.Documento));

					$('#tpDoc').html(getValue(data.TipoDocto));
					$('#solicitud').html(getValue(data.Solicitud));
					$('#anterior').html(getValue(data.DAnterior));
					$('#posterior').html(getValue(data.DPosterior));
					$('#documento').html(getValue(data.Documento));
					//General
					$('#cliente').html(getValue(data.NombreCompleto));	
					//$('#direccion').html(getValue(data.Calle) +' '+ getValue(data.NOExt) +' '+getValue(data.NOInt)+ ' ' +getValue(v.Colonia)+ ' '+getValue(v.CPostal)+ ' '+getValue(v.Poblacion) + ' '+ getValue(v.Ciudad) + ' ' + getValue(v.Pais));
					$('#agente').html(getValue(data.CAgente));
					$('#agenteN').html(getValue(data.AgenteNombre));
					$('#agenteci').html(getValue(data.CiaNombre));
					$('#cvendedor').html(getValue(data.VendNombre));	
					$('#cejecutivo').html(getValue(data.EjecutNombre));
					$('#grupo').html(getValue(data.Grupo));
					$('#subgrupo').html(getValue(data.SubGrupo));

					var dHasta = new Date(getValue(data.FHasta));
					var dDesde = new Date(getValue(data.FDesde));
					var dFechaAntiguedad = new Date(getValue(data.FAntiguedad));
					$('#hasta').html(dHasta.yyyymmdd());
					$('#desde').html(dDesde.yyyymmdd());
					// $('#fechaantiguedad').html(dFechaAntiguedad.yyyymmdd());
					$('#moneda').html(getValue(data.Moneda));
					$('#formapago').html(getValue(data.FPago));
					$('#renovacion').html(getValue(data.Renovacion));
					$('#concepto').html(getValue(data.Concepto));
					
//**-->					$('#modalPreload').modal('hide');

                    $.ajax({
                        method: "POST",
                        data: { "IDDocto": data.IDDocto },
                        url : "<?php echo base_url()?>directorio/LoadCentroDigital",
                        dataType: "html",
                        success : function(data){
                                $('#tree_menu').easytree({                  
                                    // data: arbol,
                                    data: [JSON.parse(data)],
                                });
                        }
                    
                    });

					$('#detallePoliza').modal('show');
				},
				always:function(){
//**-->					$('#modalPreload').modal('hide');
				}
			});
		$('#modalPreload').modal('hide');
	});

	/***/
	//Global
	var dataBitacora = {};
	/***/

	$('#reporte').on('click', 'tbody td span',function () {
							
		var tr = $(this).closest('tr');
		
        var row = table.row( tr );
		var clavebit = row.data().ClaveBit;
		//console.log(row.data().ClaveBit);
		console.log(clavebit);
		
        if ( row.child.isShown() ) {
            // This row is already open - close it
            row.child.hide();
            tr.removeClass('shown');
        }
        else {
            // Open this row
            // row.child( format(row.data()) ).show();
			$("tbody tr.new_table").hide();
			$("tbody tr").removeClass('shown');
			
            row.child($(
                '<tr class="new_table">'+
                    '<td colspan="4">' + format(row.data()) + '</td>'+
                    '<td colspan="20"></td>'+
                '</tr>'
            )).show();
			$("tbody tr").removeClass('shown');
            tr.addClass('shown');
			
            // Re-initialize DataTables for the child row(s)
            dataBitacora = $('table.sub-dt').DataTable({
        		processing: true,
				serverSide: true,
				retrieve: true,
				info:true,
				searching:false,
              	lengthChange: false,
              	filter: false,
				pageLength: 10,
              	ajax:{
              		url: "<?php echo base_url();?>reportes/GetInfoBit",
					type: 'POST',
					data: {claveBit: row.data().ClaveBit},
					error:function(er){
						console.log(er);
					}
              	},language:{
			    "sProcessing":     "",
				"sLengthMenu":     "Mostrar _MENU_ registros",
			    "sZeroRecords":    "No se encontraron resultados",
			    "sEmptyTable":     "Ning&uacute;n dato disponible en esta tabla",
			    "sInfo":           "Mostrando registros del _START_ al _END_ de un total de _TOTAL_ registros",
			    "sInfoEmpty":      "Mostrando registros del 0 al 0 de un total de 0 registros",
			    "sInfoFiltered":   "(filtrado de un total de _MAX_ registros)",
			    "sInfoPostFix":    "",
			    "sSearch":         "Buscar:",
			    "sUrl":            "",
			    "sInfoThousands":  ",",
			    "sLoadingRecords": "Cargando...",
			    "oPaginate": {
			        "sFirst":    "Primero",
			        "sLast":     "&Uacute;ltimo",
			        "sNext":     "Siguiente",
			        "sPrevious": "Anterior"
			    },
			    "oAria": {
			        "sSortAscending":  ": Activar para ordenar la columna de manera ascendente",
			        "sSortDescending": ": Activar para ordenar la columna de manera descendente"
			    }
			},
              	columns:[
					{"data":"Fecha"},
					{"data":"Comentario"},
				],
			 	"columnDefs": [
				    { "width": "80 px", "targets": 0 }
			  	]
              	
            });				
			
        }
		
			$('a.btn.btn-default.exportexcelpoliza').on('click',function(event){
				event.preventDefault();				
				var data = dataBitacora;				
				var json_table = data.ajax.json();
			
				if(clavebit == ""){					
					$("#confirm_vacio").modal('show');
					
				}else{
					var complete = false;
					
					$('#confirm_bitacora').modal("show").one('click', '#pagvisible', function() {
							
							addclassbutton('#pagvisible');
							JSONToCSVConvertor(json_table.data, "Capsys", true);
							closemodal('#confirm_bitacora');
							$(".title-text").text("Descarga Completa");
							$(".info-text").text("Se ha completado la descarga del excel de la pagina visible.");
							$("#confirm_vacio").modal("show");
							removeclassbutton('#pagvisible');							
							
					}).one('click', '#pagcomplete', function() {						
						addclassbutton('#pagcomplete');
						$.ajax({
						  type: "POST",
						  dataType: "json",
						  url: "<?php echo base_url();?>reportes/GetInfoBitExcel",						  
						  data: {claveBit: row.data().ClaveBit}
						}).done(function( msg ) {
							JSONToCSVConvertor(msg.data, "Capsys", true);														
						}).fail(function() {							
							$("#title-error").text("Error al generar bitacora");
							$("#info-error").text("Ocurrio un error al generar el excel completo de la bitacora, revise que su conexion");
							//$('#pagcomplete').removeClass("fa-spin");
							removeclassbutton('#pagcomplete');
						}).always(function() {
							closemodal('#confirm_bitacora');
							$(".title-text").text("Descarga Completa");
							$(".info-text").text("Se ha completado la descarga del excel completo.");
							$("#confirm_vacio").modal("show");
							//$('#pagcomplete').removeClass("fa-spin");
							removeclassbutton('#pagcomplete');
						});
					});
				}			
			});
	});
	
	$('#btDescarga').click(function(e){
		e.preventDefault();
		


		$.ajax({
			url: '<?php echo base_url();?>reportes/reportStatus',
			type: 'post',
			dataType: 'json',
			data: {consultar: getURLParameter('consultar')},
			success: function (msg) {
				$('#modalPreload').modal('hide');
				if(msg.data.code == 'OK'){
					$('#confirm_status .bnDescargarActual').show();
				}else{
					$('#confirm_status .bnDescargarActual').hide();
				}
				$('.progress-bar').css('width', msg.data.percentage+'%').attr('aria-valuenow', msg.data.percentage);	
				$("#confirm_status .info-error").html(msg.data.message+" porcentaje del reporte: "+ msg.data.percentage+"%.");

				$("#confirm_status").modal({
					backdrop: 'static',
					keyboard: false
				}).one('click','.bnDescargarActual',function(e){
					e.preventDefault();
					addclassbutton('.bnDescargarActual');

					var link = document.createElement("a");    
				    link.href = "<?php echo base_url();?>reportes/descarReporte/"+getURLParameter('consultar');
				    
				    //set the visibility hidden so it will not effect on your web-layout
				    link.style = "visibility:hidden";
				    link.target = "_blank";
				    link.click();
				    removeclassbutton('.bnDescargarActual');
				    $('#confirm_vacio').modal('hide');
				});

			}
		});
	});
	

	function closemodal(idModal){
		
		console.log("añadir clase");
		$(idModal).modal("hide");
	}
	
	function addclassbutton(idClassbutton){
		console.log("añadir clase");
		$(idClassbutton + " i").addClass("fa fa-spinner fa-spin");
	}
	function removeclassbutton(idClassbutton){
		console.log("remove clase");
		$(idClassbutton + " i").removeClass("fa fa-spinner fa-spin");
	}
	
<?php if (isset($meses)): ?>
	$('#stMeses').change(function(ev){
		$valor = $(this).val();
		$("input[name=mes]").val($valor);
	    table.ajax.reload();
	});

<?php endif ?>


	$(".pag_cenis").click(function(e){
		  e.preventDefault();
		
		$data_page = $(this).attr("data-pag");
	
		$("input[name=page]").val($data_page );		
		$('#frmReporte').trigger('submit');	
	});
	
	$("#reporte").on('click','.link_report',function(e){
			e.preventDefault();
			$url = $(this).attr("href");
			$idDocto = $(this).attr("data-idDocto")
			$idDoctoPosterior = $(this).attr("data-idDoctoPosterior")
	//-->
			$Ramo = $(this).attr("data-ramo");
			$UrlRedirect = "";
			$UrlRedirect += $url + "/" + HtmlEncode(normalize($Ramo)).replace(/ /g,"_");;
			
			$.ajax({
			  method: "POST",
			  url: "<?php echo base_url(); ?>" + "reportes/GetDoctoForID",		  
			  //dataType: 'json',
			  data: { idDocto : $idDocto},
			success: function(json){
					
					// console.log(json);
					// return false;
					try{		
						var obj = jQuery.parseJSON(json);
						
						if(obj.IDDocto != ""){
							
							$UrlRedirect += "/" + obj.IDSRamo + "/Existente?idCliente=" + obj.IDCli + "-" + obj.IDDocto + "&idPoliza=" + obj.IDDocto+"&"+window.location.search.substring(1);
							alert($UrlRedirect);
							sendUrl($UrlRedirect);
							
						}else{
							alert("No se pudo recuperar la informacion, intente de nuevo.");
						}
						
					}catch(e) {		
						alert('Exception while request..');
					}		
					},
				error: function(jqXHR,textStatus,errorThrown ){
					console.log(jqXHR);
					console.log(textStatus);
					console.log(errorThrown );
					alert('Error while request..');
				}			  
			})
			
			return false;
		});
		
		function sendUrl(url){
			window.open(url,'_self');
		}
		function HtmlEncode(s)
		{
		  var el = document.createElement("div");
		  el.innerText = el.textContent = s;
		  s = el.innerHTML;
		  return s;
		}
		
		var normalize = (function() {
		  var from = "ÃÀÁÄÂÈÉËÊÌÍÏÎÒÓÖÔÙÚÜÛãàáäâèéëêìíïîòóöôùúüûÑñÇç", 
			  to   = "AAAAAEEEEIIIIOOOOUUUUaaaaaeeeeiiiioooouuuuNncc",
			  mapping = {};
		 
		  for(var i = 0, j = from.length; i < j; i++ )
			  mapping[ from.charAt( i ) ] = to.charAt( i );
		 
		  return function( str ) {
			  var ret = [];
			  for( var i = 0, j = str.length; i < j; i++ ) {
				  var c = str.charAt( i );
				  if( mapping.hasOwnProperty( str.charAt( i ) ) )
					  ret.push( mapping[ c ] );
				  else
					  ret.push( c );
			  }      
			  return ret.join( '' );
		  }
		 
		})();
});
$('.collaptable').aCollapTable({ 
	    startCollapsed: true,
	    addColumn: false, 
	    plusButton: '<span class="i">+</span>', 
	    minusButton: '<span class="i">-</span>' 
});

Date.prototype.yyyymmdd_henc = function() {
   var yyyy = this.getFullYear().toString();
   var mm = (this.getMonth()+1).toString(); // getMonth() is zero-based
   var dd  = this.getDate().toString();
   var hh  = this.getHours().toString();
   var min = this.getMinutes().toString();
   var sec = this.getSeconds().toString();
   return  (dd[1]?dd:"0"+dd[0])+"_"+ (mm[1]?mm:"0"+mm[0])+"_"+ yyyy + "_" + hh + "_" + min + "_" + sec; // padding
};




/**************************************************/
function JSONToCSVConvertor(JSONData, ReportTitle, ShowLabel) {
    //If JSONData is not an object then JSON.parse will parse the JSON string in an Object
    var arrData = typeof JSONData != 'object' ? JSON.parse(JSONData) : JSONData;
    
    var CSV = '';    
    //Set Report title in first row or line
    
    CSV += ReportTitle + '\r\n\n';

    //This condition will generate the Label/Header
    if (ShowLabel) {
        var row = "";
        
        //This loop will extract the label from 1st index of on array
        for (var index in arrData[0]) {
            
            //Now convert each value to string and comma-seprated
            row += index + ',';
        }

        row = row.slice(0, -1);
        
        //append Label row with line break
        CSV += row + '\r\n';
    }
    
    //1st loop is to extract each row
    for (var i = 0; i < arrData.length; i++) {
        var row = "";
        
        //2nd loop will extract each column and convert it in string comma-seprated
        for (var index in arrData[i]) {
            row += '"' + arrData[i][index] + '",';
        }

        row.slice(0, row.length - 1);
        
        //add a line break after each row
        CSV += row + '\r\n';
    }

    if (CSV == '') {        
        alert("Invalid data");
        return;
    }   
    
    //Generate a file name
    var fileName = "Reporte_";
    //this will remove the blank-spaces from the title and replace it with an underscore
    fileName += ReportTitle.replace(/ /g,"_");   
    var time = new Date();
	fileName += "_" + time.yyyymmdd_henc();
    //Initialize file format you want csv or xls
    var uri = 'data:text/csv;charset=utf-8,' + escape(CSV);
    
    // Now the little tricky part.
    // you can use either>> window.open(uri);
    // but this will not work in some browsers
    // or you will not get the correct file extension    
    
    //this trick will generate a temp <a /> tag
    var link = document.createElement("a");    
    link.href = uri;
    
    //set the visibility hidden so it will not effect on your web-layout
    link.style = "visibility:hidden";
    link.download = fileName + ".csv";
    
    //this part will append the anchor tag and remove it after automatic click
    document.body.appendChild(link);
    link.click();
    document.body.removeChild(link);
}
/**************************************************/
</script>
<?php $this->load->view('footers/footer'); ?>
