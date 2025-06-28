<? $this->load->view('headers/header'); ?>
<!-- Navbar -->
<? $this->load->view('headers/menu'); ?>
<style>

	tr, th, td{
		font-size:12px;
		text-align:justify;
	}
	.modal-preload { 
		position: fixed;
		top: 50% !important; 
		left: 50% !important; 
		margin-top: -50px;  
		margin-left: -45px;
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
			<div id="dvDescarga" class="text-right <? echo ($activeReporte)? '':'not-btn'; ?>">
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
			<div class="row">
				<div class="col-md-12">
					<form
						method="POST"
                    	name="frmReporte" id="frmReporte"
						action="<?=base_url()?>reportes/verReporte" 
                    >
					<table  name="reporte" id="reporte" class="display" cellspacing="0" width="100%">
						<thead style="background-color:#FFF;">
							<tr>
								<th>Semaforo</th>
								<th>Urgente</th>
								<th>Folio</th>
								<th>Estatus</th>
								<th>Poliza</th>
								<th>Nombre Cliente</th>
								<th>Tipo Actividad</th>
								<th>Ramo Actividad</th>
								<th>SubRamo Actividad</th>
								<th>Satisfaccion</th>
								<th>Usuario Creacion</th>
								<th>Nombre Vendedor</th>
								<th>Ranking Vendedor</th>
								<th>Usuario Responsable</th>
								<th>Usuario Cotizador</th>
								<th>Fecha Creacion</th>
								<th>Fecha Promesa</th>
								<th>Fecha Cotizacion</th>
								<th>Fecha Emision</th>
								<th>Fecha Termino</th>
							</tr>
						<thead>
						<tfoot>
							<tr>
								<th>Semaforo</th>
								<th>Urgente</th>
								<th>Folio</th>
								<th>Estatus</th>
								<th>Poliza</th>
								<th>Nombre Cliente</th>
								<th>Tipo Actividad</th>
								<th>Ramo Actividad</th>
								<th>SubRamo Actividad</th>
								<th>Satisfaccion</th>
								<th>Usuario Creacion</th>
								<th>Nombre Vendedor</th>
								<th>Ranking Vendedor</th>
								<th>Usuario Responsable</th>
								<th>Usuario Cotizador</th>
								<th>Fecha Creacion</th>
								<th>Fecha Promesa</th>
								<th>Fecha Cotizacion</th>
								<th>Fecha Emision</th>
								<th>Fecha Termino</th>
							</tr>
                            <tr>
                            	<th colspan="9"></th><!-- Boton Exportado Excel-->
                            </tr>
						</tfoot>
					</table>
					</form>
				</div>
			</div>
			<!--Fin del reporte-->
		</div>		       	
	</div>
</section>
<!--..::::::::::::::::::::================ INICIO MODAL PRELOAD AJAX ================::::::::::::::::::::..-->
<div id="modalPreload" class="modal fade">
	<div class="modal-preload">
		<div class="modal-dialog">
			<div class="modal-content">
				<div class="modal-body">
					<div class="text-center">
						<img src="<? echo base_url() ?>assets/img/loading.gif" class="icon" />
						<small>PROCESANDO...</small>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>
<!--..::::::::::::::::::::================ FIN MODAL PRELOAD AJAX ================::::::::::::::::::::..-->

<!--..::::::::::::::::::::================ INICIO MODAL DETALLE ================::::::::::::::::::::..-->
<div id="detallePoliza" class="modal fade bs-example-modal-lg" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel">
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
<!--..::::::::::::::::::::================ FIN MODAL DETALLE ================::::::::::::::::::::..-->

<!--..::::::::::::::::::::================ INICIO MODAL [confirm] ================::::::::::::::::::::..-->
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
					Exportar filas del reporte
				</div>
                <div>
                	<p>
                    	<center>
						<button type="button" class="btn btn-primary" id="pagfiltrado"> Filtrado</button>
						<button type="button" class="btn btn-primary" id="pagvisible"> P&aacute;gina actual</button>
						<button type="button" class="btn btn-primary" id="pagcomplete"> Reporte completo</button>
                        </center>
                    </p>
                </div>
				<div id="dvNote">
            		<p>
                    	Nota:
                        	<br />
							<span style="padding-left:5px;">
                            	<b>Filtrado:</b> utiliz&aacute; la informaci&oacute;n filtrada del reporte.
                            </span>
                            <br />
							<span style="padding-left:5px;">
                            	<b>P&aacute;gina actual:</b> utiliz&aacute; la informaci&oacute;n de la pagina actualmente en vista, del reporte.
                            </span>
                            <br />
							<span style="padding-left:5px;">
                            	<b>Reporte completo:</b> utiliz&aacute; toda la informaci&oacute;n del reporte.
                            </span>
                    </p>
				</div>
			</div>
			<div class="modal-footer">
				<button type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button>
			</div>
		</div>
	</div>
</div>
<!--..::::::::::::::::::::================ FIN MODAL [confirm] ================::::::::::::::::::::..-->

<!--..::::::::::::::::::::================ INICIO MODAL [confirm_bitacora] ================::::::::::::::::::::..-->
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
<!--..::::::::::::::::::::================ FIN MODAL [confirm_bitacora] ================::::::::::::::::::::..-->

<!--..::::::::::::::::::::================ INICIO MODAL [confirm_vacio] ================::::::::::::::::::::..-->
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
						No se puede generar un reporte en excel vac&iacute;o.
				</div>
			</div>
			<div class="modal-footer">
				<button id="bnCerrar" type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button>
				<!-- <button  type="button" class="btn btn-primary bnDescargarActual" ><i></i> Descargar</button> -->
				<!-- <button id="bnNuevo" type="button" class="btn btn-primary" ><i></i> Generar</button> -->
			</div>
		</div>
	</div>
</div>
<!--..::::::::::::::::::::================ FIN MODAL [confirm_vacio] ================::::::::::::::::::::..-->

<!--..::::::::::::::::::::================ INICIO MODAL [confirm_error] ================::::::::::::::::::::..-->
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
<!--..::::::::::::::::::::================ FIN MODAL [confirm_error] ================::::::::::::::::::::..-->

<!--..::::::::::::::::::::================ INICIO MODAL [confirm_status] ================::::::::::::::::::::..-->
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
			    <span class="sr-only">0% Complete</span><!-- Ojo -->
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
<!--..::::::::::::::::::::================ FIN MODAL [confirm_status] ================::::::::::::::::::::..-->

<link rel="stylesheet" type="text/css" href="<?=site_url('assets/css/jquery.dataTables.css')?>">
<script type="text/javascript" charset="utf8" src="<?=site_url('assets/js/jquery.dataTables.js')?>"></script>
<!-- <script src="<?=site_url('assets/js/aCollapTable.js'); ?>"></script> -->
<script>
	function getURLParameter(name){
		return decodeURIComponent((new RegExp('[?|&]' + name + '=' + '([^&;]+?)(&|#|;|$)').exec(location.search)||[,""])[1].replace(/\+/g, '%20'))||null;
	}

$(document).ready(function(){
	/***/
	//Global
	var dataBitacora = {};
	/***/
	var fecha = $('body').on('focus','.fecha',function(){
		$(this).datepicker({
			format:			"dd/mm/yyyy",
            startDate:		"01/01/1900",
            language:		"es",
            autoclose:		true,
			orientation:	"top auto"
        });
    });

	Date.prototype.yyyymmdd = function(){
		var yyyy = this.getFullYear().toString();
		var mm = (this.getMonth()+1).toString(); // getMonth() is zero-based
		var dd  = this.getDate().toString();
		
		return  
			(dd[1]?dd:"0"+dd[0])+"/"+ (mm[1]?mm:"0"+mm[0])+"/"+ yyyy; // padding
	};
	


	function clearTable(){
		if(table != null){
			table.clear.draw();	
		}
	}
	
	function closemodal(idModal){
		//console.log("añadir clase");
		$(idModal).modal("hide");
	}

	function addclassbutton(idClassbutton){
		//console.log("añadir clase");
		$(idClassbutton + " i").addClass("fa fa-spinner fa-spin");
	}

	function removeclassbutton(idClassbutton){
		//console.log("remove clase");
		$(idClassbutton + " i").removeClass("fa fa-spinner fa-spin");
	}

	function sendUrl(url){
		window.open(url,'_self');
	}

	function HtmlEncode(s){
		var el = document.createElement("div");
		el.innerText	= el.textContent = s;
		s				= el.innerHTML;
		return	s;
	}
		
	function getValue(data){
		var resl = '';
		if(data != null){
			if(typeof data == 'object'){
				resl = '';
			} else {
				resl = data;
			}
		} else {
			resl = '';
		}
		return resl;
	}
			
	function format(d){

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
	    	<? if ($consultar == "Cobranza Pendiente" || $consultar == "Cobranza Efectuada" || $consultar == "Cobranza Cancelada"): ?>
	    	'<td><a href="<? echo base_url() . "actividades/agregar/CambioFormaPago"?>" class="link_report" data-idDocto="'+d.IDDocto+'" data-ramo="'+d.RamosNombre.toUpperCase()+'" >Cambio Forma de Pago</a></td>'+
	    	'<td><a href="<? echo base_url() . "actividades/agregar/PagoCobranza"?>" class="link_report" data-idDocto="'+d.IDDocto+'" data-ramo="'+d.RamosNombre.toUpperCase()+'" >Pago Cobranza</a></td>'+	
	    	<? else: ?>
	    	'<td><a href="<? echo base_url() . "actividades/agregar/Cotizacion"?>" class="link_report" data-idDocto="'+d.IDDocto+'" data-ramo="'+d.RamosNombre.toUpperCase()+'" >Cotizacion</a></td>'+
	    	'<td><a href="<? echo base_url() . "actividades/agregar/Emision"?>" class="link_report" data-idDocto="'+d.IDDocto+'" data-ramo="'+d.RamosNombre.toUpperCase()+'">Emision</a></td>'+	
	    	<? endif ?>
	    	
	    	'<td><a href="<? echo base_url() . "actividades/agregar/Endoso"?>" class="link_report" data-idDocto="'+d.IDDocto+'" data-ramo="'+d.RamosNombre.toUpperCase()+'">Endoso</a></td>'+
	    	'<td><a href="<? echo base_url() . "actividades/agregar/Cancelacion"?>" class="link_report" data-idDocto="'+d.IDDocto+'" data-ramo="'+d.RamosNombre.toUpperCase()+'">Cancelacion</a></td>'+
	    	'<td><a href="<? echo base_url() . "actividades/agregar/Diligencia"?>" class="link_report" data-idDocto="'+d.IDDocto+'" data-ramo="'+d.RamosNombre.toUpperCase()+'">Diligencia</a></td>'+
	    	<!-- '<td><a href="<? echo base_url() . "actividades/agregar/Enviar"?>" class="link_report" data-idDocto="'+d.IDDocto+'" data-ramo="'+d.RamosNombre.toUpperCase()+'">Enviar</a></td>'+
	    	'<td><a href="<? echo base_url() . "actividades/agregar/CapturaRenovacion"?>" class="link_report" data-idDocto="'+d.IDDocto+'" data-ramo="'+d.RamosNombre.toUpperCase()+'">Captura Renovacion</a></td>'+
	    '</tr></table>';
	
	Date.prototype.yyyymmdd = function() {
       var yyyy = this.getFullYear().toString();
       var mm = (this.getMonth()+1).toString(); // getMonth() is zero-based
       var dd  = this.getDate().toString();
	   
       return  (dd[1]?dd:"0"+dd[0])+"/"+ (mm[1]?mm:"0"+mm[0])+"/"+ yyyy; // padding
    };
	}

	$('#reporte tfoot th').each(function(){
		var title	= $(this).text();
        var sClass	= "";

		if(title == ""){
			$(this).html('<span class="btn btn-default exportexcel" title="Exportar Reporte en Excel"><i class="fa fa-file-excel-o"></i> Excel</span>' );
		}else{
			$(this).html('<input type="text" name="'+title.replace(/ /g,"_").toLowerCase()+'" class="'+sClass+'" placeholder="Buscar por '+title+'" title="Filtrado a partir de 3 caracteres"/>');
		}
	});

	var table =	
	$('#reporte').on('preXhr.dt',function(e, settings, data){
		data.search_d   = function(){
			data_value	= [];
			var input	= $('#reporte > tfoot').find("input");
			var _array	= "[";
			var count	= input.size();
			
			$.each(input,function(index, value){
				var name	= $(value).attr("name");
				var val		= $(value).attr("data-value");
				if(typeof val === "undefined"){
					val		= "";
				}
				if(name != "" && val != ""){
					var indice	= index;
					var sType	= "";
					if($(value).hasClass('fecha')){
						sType	= "date";
					} else {
						sType	= "text";
					}
					_array += '{"id":"'+ indice + '", "val":"' + val + '", "type":"'+sType+'"},';    
				}
			});
                _array = _array.substring(0, _array.length - 1);
                _array += "]";
				//console.log(_array);
			return _array;  
		};
		
	}).on('processing.dt', function (e, settings, processing){
		//console.log("(1)prosesando...");
		if(processing){
			$('#modalPreload').modal({
				show:		true,
				backdrop:	"static"
			});
		} else {
			$('#modalPreload').modal('hide');
		}
		// $('#processingIndicator').css( 'display', processing ? 'block' : 'none' );
	}).DataTable({
		processing:		true,
		serverSide:		true,
		searching:		false,
		scrollX:		true,
		lengthChange:	false,
		autoWidth:		false,
		pageLength:		25,
		ajax:			{
			url:	"<?=base_url();?>reportes/reporteVendedoresAjax",
			type:	'POST',
			error:	function(er,settings){
				//console.log(er);
				$('#modalPreload').modal('hide');
			},
		},
		language:		{
			"sProcessing":		"",
			"sLengthMenu":		"Mostrar _MENU_ registros",
			"sZeroRecords":		"No se encontraron resultados",
			"sEmptyTable":		"Ning&uacute;n dato disponible en esta tabla",
			"sInfo":			"Mostrando registros del _START_ al _END_ de un total de _TOTAL_ registros",
			"sInfoEmpty":		"Mostrando registros del 0 al 0 de un total de 0 registros",
			"sInfoFiltered":	"(filtrado de un total de _MAX_ registros)",
			"sInfoPostFix":		"",
			"sSearch":			"Buscar:",
			"sUrl":				"",
			"sInfoThousands":	",",
			"sLoadingRecords":	"Cargando...",
			"oPaginate":		{
				"sFirst":		"Primero",
				"sLast":		"&Uacute;ltimo",
				"sNext":		"Siguiente",
				"sPrevious":	"Anterior"
			},
			"oAria":			{
				"sSortAscending":  ": Activar para ordenar la columna de manera ascendente",
				"sSortDescending": ": Activar para ordenar la columna de manera descendente"
			}
		},
		aoColumns:[
			{"data":"Status_TXT"},
			{"data":"NombreCompleto"},
			{"data":"DespNombre"},
			{"data":"Giro"},
			{"data":"Expediente"},
			{"data":"Clasifica_TXT"},
			{"data":"EMail1"},
			{"data":"FechaNac"},
			{"data":"FechaCap"}
		],
	});	

	table.columns().every(function(){
		var that = this;
		$('input', this.footer()).on('keyup change', function(event){
			if(this.value.length > 3){
				$("input[name=" + this.name + "]").attr("data-value",this.value);
				if(that.search() !== this.value){
					that.search(this.value).draw();
				}
			} else {
				if(event.keyCode == 8){
					$("input[name=" + this.name + "]").attr("data-value",this.value);
						if (that.search() !== this.value){
							that.search(this.value).draw();
						}else if(this.value.length == 0){
							that.search(this.value).draw();
						}
				}
			}
		});
	});
	
// ******************************************** //
	$('.exportexcel').on('click',function(){
		var data		= table;
		var json_table	= data.ajax.json();
		if(json_table.recordsTotal == 0){
			$("#confirm_vacio").modal('show');
		} else {
			$('#confirm').modal({
				backdrop:	'static', 
				keyboard:	false
			})
			.one('click', '#pagfiltrado', function(){
				addclassbutton('#pagfiltrado');
				JSONToCSVConvertor(json_table.data, "CapsysVendedores", true);
				closemodal('#confirm');
				$(".title-text").text("Descarga Completa");
				$(".info-text").text("Se ha completado la descarga del excel filtrado en el reporte.");
				$("#confirm_vacio").modal("show");
				removeclassbutton('#pagfiltrado');
			})
			.one('click', '#pagvisible', function(){
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
			})
			.one('click', '#pagcomplete', function(){
				var oData = data.ajax.params();
				oData.isNew = false;
				addclassbutton('#pagcomplete');
				$.ajax({
					type:		"POST",
					dataType:	"json",
					url:		"<? echo base_url();?>reportes/getExcelAjax",
					data:		oData
				}).done(function(msg){
					if(msg.data.status){
						$(".title-text").text("Éxito");
						$(".bnDescargarActual").hide();
						$("#bnNuevo").hide();
						$("#dvNote").hide();
						$("#bnCerrar").show();
						$("#dvDescarga").show();
					} else {
						if(msg.data.disabled_controls){
							$(".title-text").text("Advertencia 1");
							$("#bnCerrar").show();
							$("#bnNuevo").hide();
							$("#dvNote").hide();
							$(".bnDescargarActual").hide();
						} else {
							$(".title-text").text("Advertencia 2");
							$("#bnCerrar").hide();
							$("#bnNuevo").show();
							$("#dvNote").show();
							$(".bnDescargarActual").show();	
						}		
					}
					$(".info-text").text(msg.data.message);
					//JSONToCSVConvertor(msg.data, "Capsys", true);
				}).fail(function(){
					$("#title-error").text("Error al generar documento");
					$("#info-error").text("Ocurrio un error al generar el excel completo de los documentos, revise que su conexion");
					removeclassbutton('#pagcomplete');
				}).always(function(){
					closemodal('#confirm');
					$("#confirm_vacio").modal({
						backdrop: 'static',
						keyboard: false 
					}).one('click','#bnNuevo',function(){
						addclassbutton('#bnNuevo');
						var oData = data.ajax.params();
						oData.isNew = true;
						$.ajax({
							type:		"POST",
							dataType:	"json",
							url:		"<? echo base_url();?>reportes/getExcelAjax",
							data:		oData
						}).done(function(msg){
							if(msg.data.status){
								$(".title-text").text("Éxito");
								$(".bnDescargarActual").hide();
								$("#bnNuevo").hide();
								$("#dvNote").hide();
								$("#bnCerrar").show();
								$("#dvDescarga").show();
							} else {
								$(".title-text").text("Advertencia 3");
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
						link.href = "<? echo base_url();?>reportes/descarReporte/"+getURLParameter('consultar');						    
						    //set the visibility hidden so it will not effect on your web-layout
						    link.style = "visibility:hidden";
						    link.target = "_blank";
						    link.click();
						    removeclassbutton('.bnDescargarActual');
						    $('#confirm_vacio').modal('hide');
					});
					removeclassbutton('#pagcomplete');
				});
			});
		}
	});
// ********************************************* //
	
	$('#btDescarga').click(function(e){
		e.preventDefault();
		


		$.ajax({
			url: '<? echo base_url();?>reportes/reportStatus',
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
				    link.href = "<? echo base_url();?>reportes/descarReporte/"+getURLParameter('consultar');
				    
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
});/*! --> */
/*
$('.collaptable').aCollapTable({ 
	    startCollapsed: true,
	    addColumn: false, 
	    plusButton: '<span class="i">+</span>', 
	    minusButton: '<span class="i">-</span>' 
});
*/
	Date.prototype.yyyymmdd_henc = function(){
		var yyyy	= this.getFullYear().toString();
		var mm		= (this.getMonth()+1).toString(); // getMonth() is zero-based
		var dd		= this.getDate().toString();
		var hh		= this.getHours().toString();
		var min		= this.getMinutes().toString();
		var sec		= this.getSeconds().toString();
		
		return  
			(dd[1]?dd:"0"+dd[0])+"_"+ (mm[1]?mm:"0"+mm[0])+"_"+ yyyy + "_" + hh + "_" + min + "_" + sec; // padding
	};
    var timeJjHe = new Date();
	timeJjHe = timeJjHe.yyyymmdd_henc();
	console.log(timeJjHe);
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
<? $this->load->view('footers/footer'); ?>