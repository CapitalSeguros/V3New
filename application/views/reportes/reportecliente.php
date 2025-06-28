<?php 
	$this->load->view('headers/header'); 
?>
<!-- Navbar -->
<?php
	$this->load->view('headers/menu');
?>
<!-- End navbar -->
<section class="page-section">
	        
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
        tr.tbheader
        {
            cursor:pointer;
        }
        span 
        {
            cursor:pointer;
        }
		//agregar el siguiente css

		div.dataTables_wrapper {
	        width: 1200px;
	    }
	    .dataTables_wrapper .dataTables_paginate {
		    float: right;
		    margin-right: 50px;
		    text-align: right;
		    padding-top: 0.25em;
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
    </style>
	<!--:::::::::: INICIO CONTENIDO ::::::::::-->
<section class="container-fluid breadcrumb-formularios">
	<div id="dvDescarga" class="text-right <?php echo ($activeReporte)? '':'not-btn'; ?>">
		<a id="btDescarga" href="#" class="btn btn-default input-sm">Ver Descarga</a>		
	</div>
	<div class="row">
		<div class="col-md-6 col-sm-5 col-xs-5"><h3 class="titulo-secciones">Reportes</h3></div>
		<div class="col-md-6 col-sm-7 col-xs-7">
			<ol class="breadcrumb text-right">
				<li><a href="./">Inicio</a></li>
				<li><a href="<?php base_url()."reportes" ?>">Reportes</a></li>
				<li class="active"><?php echo $consultar; ?></li>
			</ol>
		</div>
	</div>
		<hr /> 
</section>
<section class="container-fluid">    
	<div class="row">
		<div class="col-md-12" style="padding:0 10px 0 10px">
			<div class="row">
				<div class="col-md-12" style="padding:0 10px 0 10px">
					<!--Inicio del reporte-->
					 <form action="<?php base_url();?>reportes/verReporte; ?>" method="POST" id="frmReporte">
						<input type="hidden" name="cliente" value="<?php echo $cliente; ?>"/>
						<input type="hidden" name="ramo" value="<?php echo $ramo; ?>"/>
						<input type="hidden" name="subramo" value="<?php echo $subramo; ?>"/>
						<input type="hidden" name="fechaini" value="<?php echo $fechaini; ?>"/>
						<input type="hidden" name="fechafin" value="<?php echo $fechafin; ?>"/>
						<input type="hidden" name="poliza" value="<?php echo $poliza; ?>"/>
						<input type="hidden" name="estatus" value="<?php echo $estatus; ?>"/>
						<input type="hidden" name="vendedor" value="<?php echo $vendedor; ?>"/>
						<input type="hidden" name="grupo" value="<?php echo $grupo; ?>"/>
						<input type="hidden" name="subgrupo" value="<?php echo $subgrupo; ?>"/>
						<input type="hidden" name="consultar" value="<?php echo $consultar; ?>"/>
						<!--<input type="hidden" name="promotor" value="<?php //echo $promotor; ?>"/>-->
						<input type="hidden" name="page" value="<?php echo $page; ?>"/>
						<table width="100%" name="reporte" id="reporte">
							<thead>
								<tr class="act-tr-level-undefined">
									<th>#</th>
									<th>Nombre</th>
									<th>RFC</th>
									<th>Telefono</th>
									<th>Correo</th>								
									<th>Direccion</th>
								</tr>
							</thead>							
							<tfoot>
								<tr class="act-tr-level-undefined">
									<th></th>
									<th>Nombre</th>
									<th>RFC</th>
									<th>Telefono</th>
									<th>Correo</th>								
									<th>Direccion</th>
								</tr>
							</tfoot>
							<tbody>  
							</tbody>
						</table>					
					</form>
			<!--Inicio del reporte-->
				</div>
			</div>			
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
						<img src="<?php echo base_url() ?>assets/img/loading.gif" class="icon" />
						<small>PROCESANDO...</small>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>
<!--..::::::::::::::::::::================ FIN MODAL PRELOAD AJAX ================::::::::::::::::::::..-->
<!--..::::::::::::::::::::================ INICIO MODAL ================::::::::::::::::::::..-->
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
			<button  type="button" class="btn btn-primary bnDescargarActual"><i></i> Descargar</button>
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
<!--..::::::::::::::::::::================ FIN MODAL ================::::::::::::::::::::..-->

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

    $('#btDescarga').click(function(e){
		e.preventDefault();
		$('#modalPreload').modal({
	            show: true,
            backdrop: "static"
        });	

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

						// addclassbutton('.bnDescargarActual');
						// $.ajax({
						//   type: "POST",
						//   dataType: "json",
						//   url: "<?php echo base_url();?>reportes/descarReporte",
						//   data: {consultar: getURLParameter('consultar')}
						// }).done(function( msg ) {
							
						// 	JSONToCSVConvertor(msg.data, "Capsys", true);
						// 	$('#confirm_status').modal('hide');

						// }).always(function(){
						// 	removeclassbutton('.bnDescargarActual');
						// });
					});

			}
		});
	});
	
	/****/
	/*Crear el footer con inputs para el buscador*/
	/****/
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

	/*
	* Primera instancia del datatable
	*/
	var table =	$("#reporte").on('preXhr.dt', function( e, settings, data ){

	
		
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
                
                if(settings.sInstance != "reporte"){
                	var input = $('tfoot.ttfoot').find("input");
				}else{
					var input = $('#reporte > tfoot').find("input");                	
				}
				
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

	    		if(processing){
					$('#modalPreload').modal({
			            show: true,
			            backdrop: "static"
			        });	    			
	    		}else{
	    			$('#modalPreload').modal('hide');
	    		}

				// $('#processingIndicator').css( 'display', processing ? 'block' : 'none' );
		}).DataTable({
			processing: true,
			serverSide: true,
			searching:false,
			pageLength: 25,
			scrollX: true,
			lengthChange: false,
			ajax:{
				url: "<?php echo base_url();?>reportes/verReporteAjax",
				type: 'POST',
				
				error:function(er){
					console.log(er);
				}

			},
			aoColumns:[
			 	{
                   "mDataProp": null,
                   "sClass": "control center",
                   "sDefaultContent": '<span class="glyphicon glyphicon-check open_poliza">'
                },
				// {"data":"IDCli"},
				{"data":"Nombre"},
				{"data":"RFC"},
				{"data":"Telefono1"},
				{"data":"Correo"},
				{"data":"Direccion"},
			],
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
			}
		});

		/***************************************************/
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
		/***************************************************/
		$('.exportexcel').on('click',function(){

			var data = table;
			var json_table = data.ajax.json();
			
			if(json_table.recordsTotal == 0){					
				$("#confirm_vacio").modal('show');	
			}else{
				/**************************************/
				/**** EXPORT **************************/
				$('#confirm').modal({ 
									backdrop: 'static', 
									keyboard: false 
				}).one('click', '#pagvisible', function() {
						
						addclassbutton('#pagvisible');
						JSONToCSVConvertor(json_table.data, "Capsys_Clientes", true);
						closemodal('#confirm');
						$(".bnDescargarActual").hide();
						$("#bnNuevo").hide();
						$("#dvNote").hide();
						$(".title-text").text("Descarga Completa");
						$(".info-text").text("Se ha completado la descarga del excel de la pagina visible.");
						$("#confirm_vacio").modal("show");
						
				}).one('click', '#pagcomplete', function() {
					
					addclassbutton('#pagcomplete');

					var oData = data.ajax.params();
					oData.isNew = false;
					
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
						// JSONToCSVConvertor(msg.data, "Capsys_Clientes", true);
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
								
							});

						}).one('click','.bnDescargarActual',function(){
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

						removeclassbutton('#pagcomplete');
					});
				});	
				/**************************************/
			
			}		 				
		});




	
	/*
	* Template para la tabla
	*/
	function format () {
			// `d` is the original data object for the row
		return '<table class="sub-dt-poliza">'+
				'<thead>' + 
					'<tr>' + 
						'<th></th>' + 
						'<th>Estatus</th>' + 
						'<th>Documento</th>' + 
						'<th>Desde</th>' + 
						'<th>Hasta</th>' + 
						'<th>Agente</th>' + 
						'<th>Sub Ramo</th>' + 
						'<th>Aseguradora</th>' + 
						'<th>Forma Pago</th>' + 
						'<th>Sub Grupo</th>' + 
						'<th>Prima Neta</th>' + 
						'<th>Prima Total</th>' + 
						'</tr>' + 
					'</thead>'+
					'<tbody></tbody>' + 
					'<tfoot class="ttfoot">' + 
						'<tr>' + 
							'<td ></td>' +
							'<td width="30px">Estatus</td>' +
							'<td width="60px">Documento</td>' + 
							'<td width="50px" data-type="date">Desde</td>' + 
							'<td width="50px" data-type="date">Hasta</td>' + 
							'<td width="50px">Agente</td>'+
							'<td width="50px">Sub Ramo</td>' + 
							'<td width="50px">Aseguradora</td>' + 
							'<td width="50px">Forma Pago</td>'+
							'<td width="50px">Sub Grupo</td>'+
							'<td width="50px">Prima Neta</td>' + 
							'<td width="50px">Prima Total</td>' + 
						'</tr>' + 
					'</tfoot>'+
				'</table>';
	}

	var tablePolicy  = {};
	var idcli = {};
	$('#reporte').on('click', 'tbody td span.open_poliza',function () {
			
			var tr = $(this).closest('tr');
		
			var row = table.row( tr );
			var idcli = row.data().IDCli;
			
			console.log(idcli);
			
			if ( row.child.isShown() ) {				
				row.child.hide();
				tr.removeClass('shown');
			}
			else {

				$("tbody tr.new_table").hide();
				$("tbody tr").removeClass('shown');
	           row.child($(
					'<tr class="new_table">'+
						'<td colspan="6">' + format() + '</td>'+
						'<td colspan="20"></td>'+
					'</tr>'
				)).show();
				$("tbody tr").removeClass('shown');
				tr.addClass('shown');
				
				/***************************************************/
				$('#reporte tbody tr.new_table tfoot td').each( function () {            	
						var title = $(this).text();
						
						var dType = $(this).attr('data-type');
						var sClass = "";
						if (typeof dType !== typeof undefined && dType !== false) {
							sClass = " fecha ";
						}
						
						if(title == ""){
							$(this).html( '<a class="btn btn-default exportexcelpoliza"><i class="fa fa-file-excel-o"></i> Excel</a>' );
						}else{
							$(this).html( '<input type="text" name="'+title.replace(/ /g,"_").toLowerCase() +'" class="' + sClass + '" placeholder="Buscar por '+title+'" />' );
						}         
				});
				/***************************************************/
				var sSearch  = function sSearch(){
	                var input = $('tfoot.ttfoot').find("input");

	                console.log(input);
	                data_value = [];
	                var _array = "[";

	                var count = input.size();
					console.log(count);

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
				/***************************************************/
				var intest = sSearch();
				tablePolicy = $('table.sub-dt-poliza').DataTable({
            		processing: true,
					serverSide: true,
					searching:false,
					retrieve: true,
					pageLength: 10,
					lengthChange: false,
	              	ajax:{
	              		url: "<?php echo base_url();?>reportes/getPolicyforIDCli",
						type: 'POST',
						data: {IDCli: row.data().IDCli ,search_d: intest },
						error:function(er){
							console.log(er);
						}
	              	},
	              	columns:[
	              		{
		                   "mDataProp": null,
		                   "sClass": "control center",
		                   "sDefaultContent": ''
		                },
						{"data":"Status"},
						{"data":"Documento"},
						{"data":"FDesde"},
						{"data":"FHasta"},
						{"data":"VendNombre"},
						{"data":"IDSRamo"},
						{"data":"IDAseg"},
						{"data":"IDFPago"},
						{"data":"IDSSGrupo"},
						{"data":"PrimaNeta"},
						{"data":"PrimaTotal"},
					],
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
					}
	            });	

				/******************************************************/
				tablePolicy.columns().every( function () {
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
				/******************************************************/
				$('a.btn.btn-default.exportexcelpoliza').on('click',function(event){
					event.preventDefault();
			
				
					var data = tablePolicy;
					
					var json_table = data.ajax.json();
				
					if(idcli == ""){					
						$("#confirm_vacio").modal('show');
						
					}else{
						
						$('#confirm_bitacora').modal("show").one('click', '#pagvisible', function() {
								addclassbutton('#pagvisible');	
								JSONToCSVConvertor(json_table.data, "Capsys_poliza", true);
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
							  url: "<?php echo base_url();?>reportes/getPolicyforIDCliExcel",							  
							  data: {IDCli: row.data().IDCli}
							}).done(function( msg ) {
								JSONToCSVConvertor(msg.data, "Capsys_poliza", true);								
							}).fail(function() {							
								$("#title-error").text("Error al generar bitacora");
								$("#info-error").text("Ocurrio un error al generar el excel completo de la bitacora, revise que su conexion");
								removeclassbutton('#pagcomplete');
							}).always(function() {
								closemodal('#confirm_bitacora');
								$(".title-text").text("Descarga Completa");
								$(".info-text").text("Se ha completado la descarga del excel completo.");
								$("#confirm_vacio").modal("show");
								removeclassbutton('#pagcomplete');
							});
						});		
					}			
				});
				/******************************************************/
				
				
			}
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
		
		$(".pag_cenis").click(function(e){
			  e.preventDefault();
			
			$data_page = $(this).attr("data-pag");
		
			$("input[name=page]").val($data_page );		
			$('#frmReporte').trigger('submit');	
		});
		
		$(".link_report").click(function(e){
			e.preventDefault();
			$url = $(this).attr("href");
			$idDocto = $(this).attr("data-idDocto")
			$Ramo = $(this).attr("data-ramo");
			$UrlRedirect = "";
			$UrlRedirect += $url + "/" + HtmlEncode($Ramo);
			
			$.ajax({
			  method: "POST",
			  url: "<?php echo base_url(); ?>" + "reportes/GetDoctoForID",		  
			  //dataType: 'json',
			  data: { idDocto : $idDocto },
			success: function(json){
					
					try{		
						var obj = jQuery.parseJSON(json);
						
						if(obj.IDDocto > 0){
							
							$UrlRedirect += "/" + obj.IDSRamo + "/Existente?idCliente=" + obj.IDCli + "-" + obj.IDCli + "&idPoliza=" + obj.IDDocto;
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