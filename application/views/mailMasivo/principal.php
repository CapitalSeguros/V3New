<?php  $this->load->view('headers/header'); ?>
<!-- Navbar -->
<?php
	$this->load->view('headers/menu');
	$CI =& get_instance();
	$data_tab = $CI->is_role_show_tab($this->tank_auth->get_userprofile());
?>
<link rel="stylesheet" href="<?php echo base_url();?>assets/css/iconos.css">
<link rel="stylesheet" type="text/css" href=" <?php echo site_url('assets/css/jquery.dataTables.css'); ?>">
<link rel="stylesheet" href="<?php echo base_url();?>assets/css/super-star-min.css">
<style>

div.bhoechie-tab-menu{padding-right: 0;padding-left: 0;padding-bottom: 0;}
div.bhoechie-tab-menu div.list-group{margin-bottom: 0;}
div.bhoechie-tab-menu div.list-group>a{margin-bottom: 0;}
div.bhoechie-tab-menu div.list-group>a .glyphicon,div.bhoechie-tab-menu div.list-group>a .fa {color: #5A55A3;}
div.bhoechie-tab-menu div.list-group>a:first-child{border-top-right-radius: 0;-moz-border-top-right-radius: 0;}
div.bhoechie-tab-menu div.list-group>a:last-child{border-bottom-right-radius: 0;-moz-border-bottom-right-radius: 0;}
div.bhoechie-tab-menu div.list-group>a.active,div.bhoechie-tab-menu div.list-group>a.active .glyphicon,div.bhoechie-tab-menu div.list-group>a.active .fa{background-color: #5A55A3;background-image: #5A55A3;color: #ffffff;}
div.bhoechie-tab-menu div.list-group>a.active:after{content: '';position: absolute;left: 100%;top: 50%;margin-top: -13px;border-left: 0;border-bottom: 13px solid transparent;border-top: 13px solid transparent;border-left: 10px solid #5A55A3;}
div.bhoechie-tab-content{background-color: #ffffff;  padding-left: 20px;padding-top: 10px;}
div.bhoechie-tab div.bhoechie-tab-content:not(.active){display: none;}
/*Forms setup*/
.form-control {border-radius:0;box-shadow:none;height:auto;}
.table>tbody>tr>td.pleft{padding-left: 20px;}
.float-label{font-size:10px;}
input[type="text"].form-control,input[type="search"].form-control{border:none;border-bottom:1px dotted #CFCFCF;}
textarea {border:1px dotted #CFCFCF!important;height:130px!important;}
/*Content Container*/
.content-container {background-color:#fff;padding:35px 20px;margin-bottom:20px;}
h1.content-title{font-size:32px;font-weight:300;text-align:center;margin-top:0;margin-bottom:20px;font-family: 'Open Sans', sans-serif!important;}
.list-group {border: 1px solid #ddd;border-radius: 0px 5px 5px 0px;border-left: none;background: white;}
.submenu-secciones-back, .submenu-secciones-front {background: #233f80;}
.submenu-secciones-back {border: 1px solid white;}
.open-container-table-reports {cursor: pointer;padding: 6px 8px;background: #d2e0f1;border-radius: 4px;}
/*Compose*/
.btn-send{text-align:center;margin-top:20px;}
/*mail list*/
.mail-search{border-bottom-color:#7FBCC9!important; }
#dvReport {font-size: 12px !important;}
.cargando {display:none;position:fixed;z-index:1000;top:0;left:0;height:100%;width:100%;background: rgba( 255, 255, 255, .8 ) url('http://i.stack.imgur.com/FhHRx.gif') 50% 50% no-repeat;}
/* When the body has the loading class, we turn
   the scrollbar off with overflow:hidden */
body.loading {overflow: hidden; }
/* Anytime the body has the loading class, our
   modal element will be visible */
body.loading .cargando {display: block;z-index: 999999999;}
	/*Spinners*/
		.container-spinner-btn-loading {color: #5a55a3;}
	/*Botons*/
		#btnClients.list-group-item.text-center[disabled] {pointer-events: none;cursor: not-allowed;background: #ededed;}
		#btnClients.list-group-item.text-center[disabled] > .container-spinner-btn-loading {color: #a1a1a1;}
		.menu-sidebar .list-group .list-group-item {border: 1px solid #cfd5e7;background: #f3f5fb;}
		.menu-sidebar .list-group .list-group-item.active {color: white;border-color: #5567a3;background-color: #5567a3;}
		.menu-sidebar .list-group .list-group-item.active > i {color: white;}
		.menu-sidebar .list-group .list-group-item:hover {background: white;color: #3d3d3d;border-color: #cfd5e7;}
		.menu-sidebar .list-group .list-group-item:hover > i {color: #3a609b;}
		button:active, button:focus {outline: 0 !important;}
	/*Tables*/
		.table-primary, .table-primary>td, .table-primary>th {background-color: #ace5b9;}
		.table > tbody > tr.table-primary > td {border-top: 1px solid #fffefe;}
		.brd-subtable > td {border: 1px solid #ddd;}
	/*Inputs*/
		input[type="search"] {outline: 0;border: 1px solid #adadad;border-style: ridge;border-radius: 3px;}
		input[type="search"]:focus {border-color: #472380;outline: 0;box-shadow: inset 2px 3px 3px 0px rgba(0, 0, 0, 0.1), 0 0 8px rgba(71, 35, 128, .8);}
	/*Texts*/
		td > .label.label-primary {font-size: 1.4rem;}
	/*Icons*/
		.icon-time {font-size: 1.8rem;color: #1057b3;}
		.icon-check {font-size: 1.8rem;color: green;}
		.list-group-item > i {font-size: 2.4rem;color: #5562a3;margin-bottom: 5px;}
		.submenu-secciones i.fa-angle-left {margin-left: 0px;margin-top: -12px;left: 20%;}
		.submenu-secciones i.fa-angle-right {margin-left: 0px;margin-top: -12px;left: 31%;}
	/*DataTables*/
		.dataTables_wrapper .dataTables_length {justify-content: flex-start;}
		.dataTables_wrapper .dataTables_info, .dataTables_wrapper .dataTables_paginate {bottom: auto;}
		.dataTables_wrapper .dataTables_length, .dataTables_wrapper .dataTables_filter, 
		.dataTables_wrapper .dataTables_info, .dataTables_wrapper .dataTables_processing, 
		.dataTables_wrapper .dataTables_paginate {width: auto;}
</style>
<section class="main-page main-page-close">
<section class="container-fluid breadcrumb-formularios">
	<div class="row">
		<div class="col-md-6 col-sm-5 col-xs-5">
			<!--<a href="#" id="submenu-secciones" class="submenu-secciones">
				<div class="submenu-secciones-front"><i class="fa fa-angle-right"></i></div>
				<div class="submenu-secciones-back"><i class="fa fa-angle-left"></i></div>
			</a>-->
			<div class="col-md-6 col-sm-5 col-xs-5">
				<h3 class="titulo-secciones">Mail Masivo</h3>
			</div>
			<div class="col-md-6 col-sm-5 col-xs-5">
				<a href="#" class="submenu-secciones" title="Ver MenÃº" style="margin-top:20px; margin-left:-80px;">
					<div class="submenu-secciones-front"><i class="fa fa-angle-right"></i></div>
					<div class="submenu-secciones-back"><i class="fa fa-angle-left"></i></div>
				</a>
			</div>			
		</div>
		<div class="col-md-6 col-sm-7 col-xs-7">
			<ol class="breadcrumb text-right">
				<li><a href="./">Inicio</a></li>
				<li class="active">Mail Masivo</li>
			</ol>
		</div>
	</div>
	<hr /> 
</section>
<section class="container-fluid">   
	<div class="panel panel-default" style="margin-bottom: 90px;">
		<div class="panel-body">
			<div class="row">
				<div class="form-group col-md-12 col-sm-12">
					<!-- Se hicieron modificaciones de los estilos para que el sidebar pueda verse en el screen completo y puedan visualizarse todas las opciones en cualquier tamaÃ±o de pantalla -->
					<div class="bhoechie-tab-menu menu-sidebar menu-sidebar-close" id="menuCorreos" style="height: 100%; padding-top: 0; padding-bottom: 3%;">
						<a href="#" id="submenu-secciones" class="submenu-secciones" style="margin-top:2%; margin-left:80px;">
							<div class="submenu-secciones-back"><i class="fa fa-angle-left"></i></div>
							<div class="submenu-secciones-front"><i class="fa fa-angle-right"></i></div>
						</a>
						<div class="list-group">
							<a href="#" class="list-group-item  text-center">
								<i class="fas fa-clipboard-list"></i>
								<br/><span>Reporte</span>
							</a>
							<a href="#" class="list-group-item active text-center">
								<i class="fas fa-envelope"></i>
								<br/><span>Correo</span>
							</a>
							<?php
								if(isset($Catalogo_Perfiles)):
									foreach($Catalogo_Perfiles as $key=> $item): 
										$idvendedor='';
										$idBtn = "";
										if($item["IDVend"]>0){
											$idvendedor='data-IdVen="'.$item["IDVend"].'"';
											$idBtn = 'id="btnClients"';
										}
									?>
									<a href="#" class="list-group-item text-center" <?=$idBtn?> <?=$idvendedor;?>>
										<i class="fas fa-user"></i>
										<br/><span><?php echo $item["Name"]; ?></span>
									</a>
									<?php if (isset($item["Data"])) { 
											foreach ($item["Data"] as $value) {
												//if ($value['idTipoUser'] == 6 || $value['idTipoUser'] == 17) {
											/*if ($userProfile ==1) {
									?>
										<a href="#" class="list-group-item text-center" <?php echo ($item["Name"] == "Vendedores" || $item["Name"] == "Vendedores Oro" || $item["Name"] == "Vendedores Bronce" ? 'data-IdVen="'.$value["IDVend"].'"' : "");?>>
											<h4 class="glyphicon glyphicon-user"></h4><br/><?php echo ($item["Name"] == "Vendedores" ? "Clientes del vendedor " : "Vendedores de "); echo ($value["username"] != "" ? $value["username"] : "Sin Usuario"); ?>
										</a>
									<?php 
													}*/
												} 
											}
									endforeach;
									
											if ($userProfile ==4 and $userProfile ==3) {
									?>
												<a href="#" class="list-group-item  text-center" id="btnClients" data-IdVen="7">
								<h4 class="glyphicon glyphicon glyphicon-envelope"></h4>
								<br/>Clientes GAP
							</a>
									<?php 
													} 									
								endif;
							?>

						</div>
					</div>
				</div>
				<div class="col-lg-12 col-md-12 col-sm-12 col-xs-9 bhoechie-tab-container">
					<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 bhoechie-tab">
						<div id="dvReport" class="bhoechie-tab-content ">
							<table class="collaptable table table-striped" name="reporte" id="reporte" style="width: 100%;">
								<thead>
									<tr>
										<th>#</th>
										<th>Nombre</th>
										<th>Asunto</th>
										<th>Fecha CreaciÃ³n</th>
									</tr>
								</thead>
								<tbody>
								</tbody>
							</table>
					
						</div>
						<div class="bhoechie-tab-content active">
							<div class="col-sm-12 col-md-12">
								<?php echo validation_errors('<div class="alert alert-danger alert-dismissible" role="alert"><button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button><strong>Advertencia!</strong> ', '</div>'); ?>
								<?php if(isset($message)): ?>
									<div class="alert <?php echo $alert_class;?> alert-dismissible" role="alert">
										<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
										<strong><?php echo $alert; ?></strong> <?php echo $message; ?>
									</div>
								<?php endif;?>
							</div>
							<div class="col-sm-12 col-md-12" align="right">
									<?php echo form_open($this->uri->uri_string()); ?>
										
										<div class="form-group">					
											<?php 
											$data = array('name' 	=> 'para','class' => 'form-control','placeholder' => 'Para');
											echo form_input($data); 
											?>
											
										</div>
										<!--                                
										<div class="form-group">
											<?php 
											$data = array('name' 	=> 'cc','class' => 'form-control','placeholder' => 'Cc');
											echo form_input($data); 
											?>					
										</div>
										<div class="form-group">					
											<?php 
											$data = array(						
												'name' 	=> 'bcc',
												'class' => 'form-control',
												'placeholder' => 'Bcc'
											);
											echo form_input($data); 
											?>
										</div>
		-->
										<div class="form-group">					
											<?php 
											$data = array(	
												'required'=> '',					
												'name' 	=> 'asunto',
												'class' => 'form-control',
												'placeholder' => 'Asunto'
											);
											echo form_input($data); 
											?>
										</div>
										<div class="form-group column-flex-end">
											<div class="pd-side">
												<input type="checkbox" class="form-check-input client" data-alias="todos">
												<label class="textForm" title="Colaboradores y Clientes">Todos los correos</label>
											</div>
										</div>
										<div class="form-group" id="guest-list-gap" style="display:none;">
											
										</div>
										<?php 
											$data = array(
												'name' 	=> 'mensaje',
												'class' => 'form-control',
												'placeholder' => 'Mensaje',
												'id' => 'content'
											);
											echo form_textarea($data);					
											// echo display_ckeditor($ckeditor);
										?>
										<div class="btn-send">
											<?php 
											$data = array(
												'type'  => 'submit',
												'name' 	=> 'send',
												'class' => 'btn btn-success btn-lg',						
											);
											$content = "<span class=\"glyphicon glyphicon-send\"></span> Enviar";
											echo form_button($data,$content,"enviar"); 
											?>				
										</div>
										<?php
										// echo form_close();
										// ?>
									</div>
						</div>
						<?php

							if(isset($Catalogo_Perfiles)):
								foreach($Catalogo_Perfiles as $key=>$item):
							?>
						<div class="bhoechie-tab-content table-responsive">
							<div class="form-group">
								<label>
								
								</label>
								<?php if( isset($item["Data"]) && $item["Data"] != NULL ){?> 
	                           <input type="checkbox" class="form-check-input client" data-alias="tablaVen-<?php echo $key; ?>" style="margin-bottom: 3px;"> 
									Todos los <?php echo $item["Name"]; ?>								                       
								<table class="table table-hover table-email-gap" id="tablaVenC-<?php echo (Int)$item["IDVend"] > 0 ? $item["IDVend"] : $key; ?>" <?php echo ($item["Name"] == "Vendedores" ? 'data-IdVen="'.$value["idTipoUser"].'"' : "");?>>
								  <thead>
									<tr>
									  <th class="all"></th>
									  <th></th>
									  <th></th>
									  <?php if($item['IdUser']==21){ ?>
									  <th></th>
									  <?php } ?>
									</tr>
								  </thead>
								  <tbody>
									<?php 
									foreach($item["Data"] as $items): ?>
									<?php if(!is_null($items["aliadoCarCapital"]) && $items["aliadoCarCapital"] == 0):?>
									<tr>
									  <td><input type="checkbox" class="form-check-input tablaVen-<?php echo $item["IDVend"]; ?> emailGap client" data-id="<?php echo $items["id"];?>" data-email ="<?php echo $items["email"]; ?>"> <a href="#"><i class="glyphicon glyphicon-envelope"></i></a></td>
									  <td><strong><?php echo $items["username"]; ?></strong></td>
									  <td><?php echo $items["email"]; ?></td>
									  <?php if($item['IdUser']==21){ ?>
									  <td><a href="<?php echo(base_url().'mailMasivo/mandaBasura?id='.$items['id'] ) ?>">Eliminar</a></td>
									  <?php } ?>
									</tr>
									<?php endif;?>
									<?php endforeach; ?>

								 </tbody>
							   </table>
							   <?php }
							   else
							   {?>
							   		<input type="checkbox" class="form-check-input client" onclick="escogerTodosLosClientes(this)" data-alias="tablaVen-<?php echo $key; ?>" style="margin-bottom: 3px;"> 
									Todos los <?php echo $item["Name"]; ?>
<table class="table table-hover table-email-gap" id="tablaVen-<?php echo (Int)$item["IDVend"] > 0 ? $item["IDVend"] : $key; ?>" <?php echo ($item["Name"] == "Vendedores" ? 'data-IdVen="'.$value["idTipoUser"].'"' : "");?>>
								  <thead>
									<tr>
									  <th class="all"></th>
									  <th></th>
									  <th></th>
									  <?php if($item['IdUser']==21){ ?>
									  <th></th>
									  <?php } ?>
									</tr>
								  </thead>
								  <tbody>
</tbody></table>
							  <? }; ?>
							</div>
					   </div>
					   
					  <?php /*if (isset($item["Data"])) {
							foreach ($item["Data"] as $value) { ?>
                                <?php //if($userProfile == '1'): ?>
								<div class="bhoechie-tab-content table-responsive">
									<div class="form-group">
										<label>
											<input type="checkbox" class="client xddd2" data-alias="tablaVen-<?php echo $value["IDVend"]; ?>">
											<?php echo ($item["Name"] == "Vendedores" ? "Clientes del vendedor " : "Vendedores de "); echo ($value["username"] != "" ? $value["username"] : "Sin Usuario"); ?>
										</label>
										<?php if( isset($item["Data"]) && $item["Data"] != NULL ): ?>
										<table class="table table-hover table-email-gap " id="tablaVen-<?php echo $value["IDVend"]; ?>">
										  <thead>
											<tr>
											  <th class="all"></th>
											  <th></th>
											  <th></th>
											</tr>
										  </thead>
										  <tbody>
												<?php
												if ($item["Name"] != "Vendedores") 
												{
													if (isset($value["vendedores"])) {
														foreach($value["vendedores"] as $items): 
															if (strlen($items["email"]) > 0): ?>								
																<tr>
																  <td><input type="checkbox" class="tablaVen-<?php echo $value["IDVend"]; ?> emailGap client" data-id="<?php echo $items["id"];?>" data-email ="<?php echo $items["email"]; ?>"> <a href="#"><i class="glyphicon glyphicon-envelope"></i></a></td>
																  <td><strong><?php echo $items["name_complete"]; ?></strong></td>
																  <td><?php echo $items["email"]; ?></td>
																</tr>
															<?php endif;
														endforeach; 
													}
												}
												?>
										  </tbody>
										</table>
										<?php endif; ?>
									</div>
								</div>
                                <?php //endif;?>
							<?php }
						} */?>			
					<?php
					endforeach;
					?>

					<?php
				endif;
				?>               
            </div>
        </div>
			</div>
		</div>
	</div>
</section>
</section>
<!--
<div class="container-fluid">
	<div class="row"></div>
</div>-->
<div class="modal cargando"><!-- Place at bottom of page --></div>

<script type="text/javascript" src="<?php echo base_url(); ?>/assets/js/bootstrap-toolkit.min.js"></script>
<script type="text/javascript" src="<?php echo base_url(); ?>/assets/js/ckeditor/ckeditor.js"></script>
<script type="text/javascript">CKEDITOR_BASEPATH = '<?php echo base_url(); ?>/assets/js/ckeditor/';</script>
<script type="text/javascript" charset="utf8" src="<?php echo site_url('assets/js/jquery.dataTables.js'); ?>"></script>
<script src="<?php echo site_url('assets/js/jquery.generic.cenis.js'); ?>"></script>
<script type="text/javascript">
	//------------------------------------------- CKEDITOR -------------------------------------------
	(function($, document, window, viewport){
		var highlightBox = function( className ) {
			$(className).addClass('active');
		}
		var highlightBoxes = function() {
			if( viewport.is("<=sm") ) {
				var editor = CKEDITOR.instances["content"];
				if (editor) { editor.destroy(true); }
				CKEDITOR.replace( 'content', {
					toolbarGroups:[],
					removeButtons: 'Underline,Strike,Subscript,Superscript,Anchor,Styles,Specialchar'
				});
			}
			if( viewport.is("md") ) {
				var editor = CKEDITOR.instances["content"];
				if (editor) { editor.destroy(true); }
				CKEDITOR.replace('content',{
					filebrowserUploadUrl: '/V3/mailMasivo/upload'
				});
				//console.log("md");
			}
			if( viewport.is(">md") ) {
				var editor = CKEDITOR.instances["content"];
				if (editor) { editor.destroy(true); }
				CKEDITOR.replace('content',{
					filebrowserUploadUrl: '/V3/mailMasivo/upload'
					//customConfig : '<?php echo site_url('assets/js/custom.ckeditor.js'); ?>'
				});
				//console.log(">md");
			}
		}
		$(document).ready(function() {
			highlightBoxes();
		});
		$(window).resize(
			viewport.changed(function(){
				highlightBoxes();
			})
		);
	})(jQuery, document, window, ResponsiveBootstrapToolkit);
	//------------------------------------------- Fin CKEDITOR -------------------------------------------

	$(document).ready(function() {
			getNamesClientsByRamo(); //Agregado [Suemy][2024-08-16]
			var mainAltura = $('.main-page').height();
			//$('.menu-sidebar').css('minHeight', mainAltura);  //Este cÃ³digo afecta al sidebar en pantallas de resoluciÃ³n pequeÃ±a impidiÃ©ndoles ver las ultimas opciones del menÃº de este
			var menuSidebar = $('.menu-sidebar');
			$(".submenu-secciones").click(function(e){
				e.preventDefault();
				e.stopPropagation();
				$(".submenu-secciones").toggleClass('flipped'); //Se cambiÃ³ para que los iconos que abren y cierran el sidebar estÃ©n coordinados
				$('.main-page').toggleClass('main-page-close main-page-open');
				menuSidebar.toggleClass('menu-sidebar-close menu-sidebar-open');
			});
			//alert(window.location.href);
			$("div.bhoechie-tab-menu>div.list-group>a").click(function(e) {	//Modificado [Suemy][2024-08-16]
				e.preventDefault();
				$(this).siblings('a.active').removeClass("active");
				$(this).addClass("active");
				var index = $(this).index();
				$("div.bhoechie-tab>div.bhoechie-tab-content").removeClass("active");
				$("div.bhoechie-tab>div.bhoechie-tab-content").eq(index).addClass("active");
			});

			//------------------------ Tabla Reportes | Modificado [Suemy][2024-08-16] ------------------------
			var table = $('#reporte').DataTable({
				/*processing: true,
				serverSide: true,*/
				searching: false,
				lengthChange: true,
				pageLength: 10,
				lengthMenu: [5, 10, 25, 50, 75, 100],
				ajax:{
					url: "<?php echo base_url();?>mailMasivo/getReporte",
					type: 'POST',
					error:function(er,settings){
						console.log(er);
						//$('#modalPreload').modal('hide');
					}
				},
				aoColumns:[
					{
					   "mDataProp": null,
					   "sClass": "control center",
					   "sDefaultContent": '<span class="open-container-table-reports"><i class="fas fa-plus"></i></span>'
					},
					// {"data":"IDCli"},
					{"data":"desde"},
					{"data":"asunto"},
					{"data":"fechaCreacion"},
				],
				language:{
					url: `<?=base_url()?>assets/js/espanol.json`
				},
			});

			function format ( d ) {
				// `d` is the original data object for the row
				return '<table cellpadding="5" class="sub-dt" cellspacing="0" border="0" style="width:100%;">'+'<thead><tr><th></th><th>Correo</th><th>Fecha CreaciÃ³n</th><th>Fecha Envio</th><th>Estatus</th></tr></thead>'+'<tbody></tbody>'+'</table>';
			}

			$('#reporte').on('click', 'tbody td span',function () {
				var tr = $(this).closest('tr');
				var row = table.row( tr );
				//console.log(row.data());
								 
				if ( row.child.isShown() ) {
					// This row is already open - close it
					row.child.hide();
					tr.removeClass('shown');
					$(this).html(`<i class="fas fa-plus"></i>`);
				}
				else {
					$(this).html(`<i class="fas fa-minus"></i>`);
					// Open this row
					row.child( format(row.data()) ).show();
					tr.addClass('shown');
					// Re-initialize DataTables for the child row(s)
					$('table.sub-dt').DataTable({
						/*processing: true,
						serverSide: true,*/ //No deja que haya paginaciÃ³n
						retrieve: true,
						info: true, //Muestra registros
						searching: true, //Muestra el input de bÃºsqueda
						lengthChange: true, //Muestra la longitud de registros
						filter: false,
						pageLength: 10,
						language:{
							url: `<?=base_url()?>assets/js/espanol.json`
						},
						ajax:{
							url: "<?php echo base_url();?>mailMasivo/getReporteDetalle",
							type: 'POST',
							data: {
								asunto: row.data().asunto,
								desde: row.data().desde
							},
							error:function(er){
								console.log(er);
							}
						},
						 columnDefs: [
							{
								render: function ( data, type, row ) {
									//console.log(type, data, row); 
									var sElement = '';
									if(data == 0)
										sElement = '<span class="icon-time"  data-toggle="ttstatus" data-placement="right" title="Pendiente"><i class="fas fa-clock"></i></span>';
									else
										sElement = '<span class="icon-check" data-toggle="ttstatus" data-placement="right" title="Enviado"><i class="fas fa-check-circle"></i></span>';
									return sElement;
								},
								targets: 4
							}
						],
						columns:[
							{
							   "mDataProp": null,
							   "sClass": "control center",
							   "sDefaultContent": '<span class="glyphicon glyphicon-envelope">'
							},
							{"data":"para"},
							{	data: "fechaCreacion"	},
							{
								data: "fechaEnvio",
								render: function (data,type,row) {
									//console.log(type, data, row); 
									var dateSend = "Sin enviar";
									if (data != "1900-01-01 00:00:00") {
										dateSend = row.fechaEnvio;
									}
									return dateSend;
								},
							},
							{"data":"status"},
						]					              	
					});
					$(row.child()).addClass('brd-subtable');
				}
			});

			$('body').tooltip({
				selector: '[data-toggle="ttstatus"]'
			});
			// $('[data-toggle="ttstatus"]').tooltip(); 
			//------------------------ Fin Tabla Reportes ------------------------
	});
		
	$(document).on("click",".client",function (e) {
					 
			 data_value = $(this).attr("data-alias");
			 data_id = $(this).attr("data-id");
			 data_id_sub = $(this).attr("data-id-sub");
			 
			 if (data_value === undefined) {
				 
				//console.log("client");
				 
				 var guestView = "";
				 
				data_value = $(this).attr("data-email");
				 
				 
				 
				if($(this).is(':checked')){							 
					guestView += "<input class='guest_" + data_id +"_"+data_id_sub+"' name='guests[]' value='" + data_value + "'>";
					$("#guest-list-gap").append(guestView);	
				}
				else{
					
					if($("input[data-alias=todos]").is(':checked')){
						$("input[data-alias=todos]").prop( "checked", false )
					}
					
					alias = $(this).closest('table').attr('id');
					
					console.log(alias);
					
					if($("input[data-alias=" + alias + "]").is(':checked')){
						$("input[data-alias=" + alias + "]").prop( "checked", false )
					}
					
					$(".guest_" + data_id).remove(); 
				 }
				 
			 }else if(data_value == 'subramo'){
				guestView = "";
			 	var ID = $(this).attr('data-id');
		 		var emails = $('.sub'+ID);
			 	if(this.checked){
			 		

			 		$.each(emails,function(index,item){
			 			var dta_id = $(item).attr("data-id");
			 			var dta_id_sub = $(item).attr("data-id-sub");

			 			if($(".guest_" + dta_id+"_"+dta_id_sub).length == 0){
			 				guestView += "<input class='guest_" + dta_id +"_"+dta_id_sub+"' name='guests[]' value='" + $(item).attr("data-email") + "'>";
			 			}
						$(item).prop( "checked", true );						
			 		});

			 		$("#guest-list-gap").append(guestView);	

			 	}else{

			 		$.each(emails,function(index,item){
						var dta_id = $(item).attr("data-id");
						var dta_id_sub = $(item).attr("data-id-sub");
						$(".guest_" + dta_id+"_"+dta_id_sub).remove();
						$(item).prop( "checked", false );
					});
			 	}
			 }
			 else{
				if($(this).is(':checked')){
				console.log(this)
					//$( "#x" ).prop( "checked", true );
 
					// Uncheck #x
					//$( "#x" ).prop( "checked", false );
					if(data_value == "todos")
					{					
						$("#guest-list-gap").html("");
						var email = $(".table-email-gap").find(".emailGap");
						var guestView = "";

						$.each(email,function(index,item){
							var dta_id = $(item).attr("data-id");
							var dta_id_sub = $(item).attr("data-id-sub");

							if($(".guest_" + dta_id+"_"+dta_id_sub).length == 0){
								guestView += "<input class='guest_" + dta_id +"_"+dta_id_sub+"' name='guests[]' value='" + $(item).attr("data-email") + "'>";
							}
							$(item).prop( "checked", true );
						});
						
						$("#guest-list-gap").append(guestView);	
						$("input.client").prop( "checked", true );
					}else{													
												
						var vals = data_value.split('-');	
						var email = $("#tablaVenC-"+vals[1]).find(".emailGap");								
						var guestView = "";
						$.each(email,function(index,item){
							var dta_id = $(item).attr("data-id");
							var dta_id_sub = $(item).attr("data-id-sub");
							if($(".guest_" + dta_id+"_"+dta_id_sub).length == 0){
								guestView += "<input class='guest_" + dta_id +"_"+dta_id_sub+"' name='guests[]' value='" + $(item).attr("data-email") + "'>";
							}
							$(item).prop( "checked", true );
						});

						var email = $("#"+data_value).find(".emailGap");		
						$.each(email,function(index,item){
							var dta_id = $(item).attr("data-id");
							var dta_id_sub = $(item).attr("data-id-sub");
							if($(".guest_" + dta_id+"_"+dta_id_sub).length == 0){
								guestView += "<input class='guest_" + dta_id +"_"+dta_id_sub+"' name='guests[]' value='" + $(item).attr("data-email") + "'>";
							}
							$(item).prop( "checked", true );
						});						

						$("#guest-list-gap").append(guestView);	

					}

				}else{
					
					if(data_value == "todos"){
						//$(".guest_" + data_value).remove();
						console.log("ready-todos");
						
						var email = $("#" + data_value).find(".emailGap");
						
						if(email.length > 0){
						
							$.each(email,function(index,item)
							{
								var dta_id = $(item).attr("data-id");
								var dta_id_sub = $(item).attr("data-id-sub");
								$(".guest_" + dta_id+"_"+dta_id_sub).remove();
								$(item).prop( "checked", false );
							});
						}else{
							
							var email_list = $("#guest-list-gap").find("input");							
							$.each(email_list,function(index,item){	$(item).remove(); });
						}
						

						
						$("input.emailGap").prop( "checked", false );
						$("input.client").prop( "checked", false );
					}else{
						//console.log("dkadskas");
						//$(".guest_" + data_value).remove();
						//$("input." + data_value).prop( "checked", false );
						var vals = data_value.split('-');
						
						var email = $("#tablaVenC-"+vals[1]).find(".emailGap");								
						$.each(email,function(index,item)
						{
							var dta_id = $(item).attr("data-id");
							var dta_id_sub = $(item).attr("data-id-sub");
							$(".guest_" + dta_id+"_"+dta_id_sub).remove();
							$(item).prop( "checked", false );
						});
						var email = $("#"+data_value).find(".emailGap");		
				
						$.each(email,function(index,item)
						{
							var dta_id = $(item).attr("data-id");
							var dta_id_sub = $(item).attr("data-id-sub");
							$(".guest_" + dta_id+"_"+dta_id_sub).remove();
							$(item).prop( "checked", false );
						});
					}
				} 
			 }		
		});
		
	$("#MostarListaCorreo").GeneralCenis('MostarCorreos',{
		EventButtonId : '#add-email',
		Data : <?php echo $EmailScriptJS; ?>
	});

	$body = $("body");
	$(document).on({
	    ajaxStart: function() { $body.addClass("loading");    },
	    ajaxStop: function()  { $body.removeClass("loading"); },
	    ajaxError: function() { $body.removeClass("loading"); }    
	});

//menu-sidebar-close" id="menuCorreos"
<?php if(isset($abrirEmail)){?>
document.getElementById("menuCorreos").classList.add('menu-sidebar-open');
var longitud=document.getElementsByClassName('list-group')[0].childNodes.length;
var activaUltimo=0;
for(var i=0;i<longitud;i++)
{if(document.getElementsByClassName('list-group')[0].childNodes[i].nodeName=="A")
 {document.getElementsByClassName('list-group')[0].childNodes[i].classList.remove("active");activaUltimo=i;}
}
document.getElementsByClassName('list-group')[0].childNodes[activaUltimo].classList.add("active");

longitud=document.getElementsByClassName('bhoechie-tab')[0].childNodes.length;
activaUltimo=0;
for(var i=0;i<longitud;i++)
{
if(document.getElementsByClassName('bhoechie-tab')[0].childNodes[i].nodeName=="DIV"){
  document.getElementsByClassName('bhoechie-tab')[0].childNodes[i].classList.remove("active");
   activaUltimo=i;
 }


}
 document.getElementsByClassName('bhoechie-tab')[0].childNodes[activaUltimo].classList.add("active");
document.getElementsByClassName('main-page')[0].classList.remove('main-page-close')
document.getElementsByClassName('main-page')[0].classList.add('main-page-open')
<?php } ?>

function escogerTodosLosClientes(objeto)
{
	let c=document.getElementsByClassName('clienteEmail');
	if(objeto.checked){for(let i of c){i.checked=true;}}
	else{for(let i of c){i.checked=false;}}

}
function ocultarHijosClientes(objeto,id)
{
	let hijos=document.getElementsByClassName('subsramo'+id);
   if(objeto.innerHTML=='<i class="fas fa-plus"></i>')
   {
     for(let i of hijos)
     {
      i.classList.remove('ocultarObjeto')
     }
     objeto.innerHTML='<i class="fas fa-minus"></i>';
   }
   else
   {
   	     for(let i of hijos)
     {
      i.classList.add('ocultarObjeto')
     }
     objeto.innerHTML='<i class="fas fa-plus"></i>';
   }
	
}

//--------------------------------------------------------------------------------------------
	function getNamesClientsByRamo() { //Creado [Suemy][2024-08-16]
		var idven = $('#btnClients').attr("data-idven");
		var table = $("#tablaVen-" + idven);
		var Datos = { "IDVend" : idven };
		//console.log(idven, table, Datos);
		$('#btnClients').attr('disabled',true);
		$.ajax({
			data: Datos,
			type: "POST",
			url: "mailMasivo/getClientes",
			beforeSend: (load) => {
				$('body').removeClass("loading");
				$('#btnClients').html(`
					<div class="container-spinner-btn-loading">
                        <div class="spinner-border" role="status" style="margin: 5px 0px;">
                            <span class="visually-hidden"></span>
                        </div>
                        <p style="margin: 0px;">Clientes GAP</p>
                    </div>
				`);
			},
			error: function (jqXHR, textStatus, errorThrown) {
				alert("error: " + errorThrown); 
			},
			success: function (response) {
				//console.log(response);
				var Array_JSON = JSON.parse(response);
				console.log(Array_JSON);
				table.find("tbody tr").remove();
				$.each(Array_JSON,function(k,v){				
					//var rowhead = '<tr class="sramo table-primary">'+'<td colspan="2"><input type="checkbox" class="client clienteEmail" data-alias="subramo" data-id="'+v.id+'">'+v.sramo+'</td><td align="right"><button class="btn btn-primary" onclick="ocultarHijosClientes(this,'+v.id+'")" >+</button></td>'+'</tr>';
					var rowhead = `<tr class="sramo table-primary"><td colspan="2"><input type="checkbox" class="form-check-input client clienteEmail" data-alias="subramo" data-id="${v.id}"> ${v.sramo}</td><td align="right"><label class="label label-primary">${v.data.length}</label> <button class="btn btn-primary" onclick="ocultarHijosClientes(this,'${v.id}')" style="    padding: 6px 8px;background: #233680;"><i class="fas fa-plus"></i></button></td></tr>`;
					table.find("tbody").append(rowhead);
					$.each(v.data,function(i,item){
						var name = getTextValue(item.NombreCompleto);
						name = (name != 0) ? name : "Sin nombre";		
						var row = '<tr class="subsramo'+v.id+' ocultarObjeto" >' + '<td class="pleft"><input type="checkbox" data-id="'+ item.IDCli +'" data-id-sub="'+v.id+'" class="form-check-input clienteEmail '+ table.attr("id") +' emailGap client sub'+v.id+'" data-email="'+  item.EMail1 +'"> <a href="#"><i class="glyphicon glyphicon-envelope"></i></a></td>' + '<td><strong>'+ name +'<strong></td>'+ '<td>'+ item.EMail1 + '</td>'+ '</tr>';
				        //console.log(table);
				        table.find("tbody").append(row);
				        var agregado = $("#guest-list-gap input.guest_"+ item.IDCli).val();
				        if (agregado)
				        {
				        	$("." + table.attr("id")).prop("checked", true);
				        }
					});
				});
				$('#btnClients').attr('disabled',false);
				$('#btnClients').html(`<i class="fas fa-user"></i><br/><span>Clientes GAP</span>`);
			}
		});
	}

    function getTextValue(data) {
        if (data == "[object Object]" || data == undefined || data == null || data == "") {
            data = "";
        }
        return data;
    }

//--------------------------------------------------------------------------------------------
	</script>
	<style type="text/css">
		.ocultarObjeto{display: none}
	</style>
<?php $this->load->view('footers/footer'); ?>