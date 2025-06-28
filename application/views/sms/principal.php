<?php 
	#var_dump($Catalogo_Perfiles);
	#echo json_encode($Catalogo_Perfiles);
	$this->load->view('headers/header');
?>
<!-- Navbar -->
<?php
	$this->load->view('headers/menu');
	$CI =& get_instance();
	$data_tab = $CI->is_role_show_tab($this->tank_auth->get_userprofile());
?>
<style>
div.bhoechie-tab-menu{
  padding-right: 0;
  padding-left: 0;
  padding-bottom: 0;
}
div.bhoechie-tab-menu div.list-group{
  margin-bottom: 0;
}
div.bhoechie-tab-menu div.list-group>a{
  margin-bottom: 0;
}
div.bhoechie-tab-menu div.list-group>a .glyphicon,
div.bhoechie-tab-menu div.list-group>a .fa {
  color: #5A55A3;
}
div.bhoechie-tab-menu div.list-group>a:first-child{
  border-top-right-radius: 0;
  -moz-border-top-right-radius: 0;
}
div.bhoechie-tab-menu div.list-group>a:last-child{
  border-bottom-right-radius: 0;
  -moz-border-bottom-right-radius: 0;
}
div.bhoechie-tab-menu div.list-group>a.active,
div.bhoechie-tab-menu div.list-group>a.active .glyphicon,
div.bhoechie-tab-menu div.list-group>a.active .fa{
  background-color: #5A55A3;
  background-image: #5A55A3;
  color: #ffffff;
}
div.bhoechie-tab-menu div.list-group>a.active:after{
  content: '';
  position: absolute;
  left: 100%;
  top: 50%;
  margin-top: -13px;
  border-left: 0;
  border-bottom: 13px solid transparent;
  border-top: 13px solid transparent;
  border-left: 10px solid #5A55A3;
}

div.bhoechie-tab-content{
  background-color: #ffffff;
  /* border: 1px solid #eeeeee; */
  padding-left: 20px;
  padding-top: 10px;
}

div.bhoechie-tab div.bhoechie-tab-content:not(.active){
  display: none;
}
/*Forms setup*/
.form-control {
    border-radius:0;
    box-shadow:none;
    height:auto;
}
.table>tbody>tr>td.pleft{
	padding-left: 20px;
}
.float-label{
    font-size:10px;
}
input[type="text"].form-control,
input[type="search"].form-control{
    border:none;
    border-bottom:1px dotted #CFCFCF;
}
textarea {
    border:1px dotted #CFCFCF!important;
    height:130px!important;
}
/*Content Container*/
.content-container {
    background-color:#fff;
    padding:35px 20px;
    margin-bottom:20px;
}
h1.content-title{
    font-size:32px;
    font-weight:300;
    text-align:center;
    margin-top:0;
    margin-bottom:20px;
    font-family: 'Open Sans', sans-serif!important;
}
/*Compose*/
.btn-send{
    text-align:center;
    margin-top:20px;
}
/*mail list*/
.mail-search{
    border-bottom-color:#7FBCC9!important; 
}

#dvReport {
	font-size: 12px !important;
}

.cargando {
    display:    none;
    position:   fixed;
    z-index:    1000;
    top:        0;
    left:       0;
    height:     100%;
    width:      100%;
    background: rgba( 255, 255, 255, .8 ) 
                url('http://i.stack.imgur.com/FhHRx.gif') 
                50% 50% 
                no-repeat;
}



/* When the body has the loading class, we turn
   the scrollbar off with overflow:hidden */
body.loading {
    overflow: hidden;   
}

/* Anytime the body has the loading class, our
   modal element will be visible */
body.loading .cargando {
    display: block;
    z-index: 999999999;
}
</style>
<section class="main-page main-page-close">

	<section class="container-fluid breadcrumb-formularios">
		<div class="row">
			<div class="col-md-6 col-sm-5 col-xs-5">
				<div class="col-md-6 col-sm-5 col-xs-5">
					<h3 class="titulo-secciones">SMS Masivo</h3>
				</div>
				<div class="col-md-6 col-sm-5 col-xs-5">
					<a href="#" class="submenu-secciones" style="border:1px solid #472380; margin-top:20px; margin-left:-80px;">
						<div class="submenu-secciones-front"><i class="fa fa-angle-right"></i></div>
						<div class="submenu-secciones-back"><i class="fa fa-angle-left"></i></div>
					</a>
				</div>			
			</div>
			<div class="col-md-6 col-sm-7 col-xs-7">
				<ol class="breadcrumb text-right">
					<li><a href="./">Inicio</a></li>
					<li class="active">SMS Masivo</li>
				</ol>
			</div>
		</div>
		<hr /> 
        <div align="right">
        Saldo Actual: <?= "$".number_format($saldo,2,".", ",");?>
        </div>
	</section>

<?

	if($this->input->get('paraTelefonosUrl', 'false') != ""){
		$paraTelefonos = $this->input->get('paraTelefonosUrl', 'false');
	}

	if($this->input->get('smsTextUrl','false') != ""){
		$smsText = $this->input->get('smsTextUrl', 'false');
	}

?>

	<section class="container-fluid">
		<div class="panel panel-default">
			<div class="panel-body">
				<div class="row">
					<div class="form-group col-md-12 col-sm-12">
						<div class="bhoechie-tab-menu menu-sidebar menu-sidebar-close" id="menuSms" style="height:550px">
							<a href="#" id="submenu-secciones" class="submenu-secciones" style="margin-top:80px; margin-left:80px;">
								<div class="submenu-secciones-front"><i class="fa fa-angle-right"></i></div>
								<div class="submenu-secciones-back"><i class="fa fa-angle-left"></i></div>
							</a>
							<div class="list-group">
								<a href="#" class="list-group-item  text-center">
									<h4 class="glyphicon glyphicon glyphicon-list-alt"></h4>
									<br/>Reporte
								</a>
								<a href="#" class="list-group-item active text-center">
									<h4 class="glyphicon glyphicon glyphicon-phone"></h4>
									<br/>Sms
								</a>
								<?php
								if(isset($Catalogo_Perfiles)):
									
									foreach($Catalogo_Perfiles as $item): 
										$idvendedor='';
										if($item["IDVend"]>0){$idvendedor='data-IdVen="'.$item["IDVend"].'"';}
								?>
									<a href="#" class="list-group-item text-center" <?=$idvendedor;?>>
										<h4 class="glyphicon glyphicon-user"></h4>
										<br/><?php echo $item["Name"]; ?>
									</a>
									<?php
									if (isset($item["Data"])) { 
										foreach ($item["Data"] as $value) {
											//if ($value['idTipoUser'] == 6 || $value['idTipoUser'] == 17) {
											if($value["CelularSMS"] != "" && $value["CelularSMS"] != "9999999999"){
											if ($userProfile ==1) {
									?>
												<a 
                                                	href="#" 
													class="list-group-item text-center" <?= ($item["Name"] == "Vendedores" || $item["Name"] == "Vendedores Oro" || $item["Name"] == "Vendedores Bronce" ? 'data-IdVen="'.$value["IDVend"].'"' : "");?>
												>
													<h4 class="glyphicon glyphicon-user"></h4>
													<br/>
													<? 
														echo ($item["Name"] == "Vendedores" ? "Clientes del vendedor " : "Vendedores de "); 
														echo ($value["username"] != "" ? $value["username"] : "Sin Usuario"); 
													?>
												</a>
									<?php 
											}
											}
										
										}
									} 
									
									endforeach;
									
									if($userProfile ==4 and $userProfile ==3) {
									?>
										<a href="#" class="list-group-item  text-center" data-IdVen="7">
	                                        <h4 class="glyphicon glyphicon glyphicon-phone"></h4>
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
							<link rel="stylesheet" type="text/css" href=" <?php echo site_url('assets/css/jquery.dataTables.css'); ?>">
							<script type="text/javascript" charset="utf8" src="<?php echo site_url('assets/js/jquery.dataTables.js'); ?>"></script>
							<table class="collaptable table table-striped" name="reporte" id="reporte" style="width: 100%;">
								<thead>
									<tr>
										<th>#</th>
										<th>Nombre</th>
										<th>Asunto</th>
										<th>Fecha Creación</th>
									</tr>
								</thead>
								<tbody>
								</tbody>
							</table>
							<script type="text/javascript">
								$(document).ready(function(){


									var table = $('#reporte').DataTable({
										processing: true,
										serverSide: true,
										searching:false,
										lengthChange: false,
										pageLength: 25,
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
											   "sDefaultContent": '<span class="glyphicon glyphicon-plus">'
											},
											// {"data":"IDCli"},
											{"data":"desde"},
											{"data":"asunto"},
											{"data":"fechaCreacion"},
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
										},
									});

									function format ( d ) {
										// `d` is the original data object for the row
										return '<table cellpadding="5" class="sub-dt" cellspacing="0" border="0" style="width:100%; padding-left:50px;">'+
										   '<thead><tr><th></th><th>Correo</th><th>Fecha Envio</th><th>Estatus</th></tr></thead>'+
											'<tbody></tbody>'+
										'</table>';
									}

									$('#reporte').on('click', 'tbody td span',function () {
										var tr = $(this).closest('tr');
										var row = table.row( tr );
								 
										if ( row.child.isShown() ) {
											// This row is already open - close it
											row.child.hide();
											tr.removeClass('shown');
										}
										else {
											// Open this row
											row.child( format(row.data()) ).show();
											tr.addClass('shown');
										  
											// Re-initialize DataTables for the child row(s)
											$('table.sub-dt').DataTable({
												processing: true,
												serverSide: true,
												retrieve: true,
												info:false,
												searching:false,
												lengthChange: false,
												filter: false,
												retrieve: true,
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
												},
												ajax:{
													url: "<?php echo base_url();?>mailMasivo/getReporteDetalle",
													type: 'POST',
													data: {asunto: row.data().asunto},
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
																sElement = '<span class="glyphicon glyphicon-time"  data-toggle="ttstatus" data-placement="right" title="Pendiente">';
															else
																sElement = '<span class="glyphicon glyphicon-ok-circle" data-toggle="ttstatus" data-placement="right" title="Enviado">';

															return sElement;
														},
														targets: 3
													}
												],
												columns:[
													{
													   "mDataProp": null,
													   "sClass": "control center",
													   "sDefaultContent": '<span class="glyphicon glyphicon-phone">'
													},
													{"data":"para"},
													{"data":"fechaEnvio"},
													{"data":"status"},
												]					              	
											});
										}
									});

									$('body').tooltip({
										selector: '[data-toggle="ttstatus"]'
									});
									// $('[data-toggle="ttstatus"]').tooltip(); 

								});
							</script>
					
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
										
                                        
								<!-- <label>Destinatarios</label> -->
                                <div class="row">
								</div>
										<div class="form-group">
											<?php 
											$data = array(
												'id'	=> 'paraTelefonos',						
												'name' 	=> 'paraTelefonos',
												'class' => 'form-control',
												'placeholder' => 'Destinatarios',
												'value' => $paraTelefonos
											);
											echo form_input($data); 
											?>
										</div>

										<!--
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
                                        -->
                                        
                                        <!--
										<div class="form-group">
										<label><input type="checkbox" class="client" data-alias="todos"> Todos los correos</label>
										</div>
										-->
                                        
                                        <div class="form-group" id="guest-list-gap" style="display:none;">
										</div>

                                <!-- <label>Mensaje</label> -->
								<div class="row">
									<textarea 
                                    	id="smsText" name="smsText" 
                                        class="form-control input-sm" placeholder="Mensaje"
                                    ><?= $smsText; ?></textarea>
									<p id="contSmsText">Caracteres usados: 0 de 150</p>
								</div>
								<?
									if($saldo >= '5.0000'){
								?>
										<div class="btn-send">
											<?php 
											$data = array(
												'type'  => 'submit',
												'name' 	=> 'send',
												'class' => 'btn btn-success btn-lg',						
											);
											$content = "<span class=\"glyphicon glyphicon-send\"></span> Enviar SMS";
											echo form_button($data,$content,"enviar"); 
											?>				
										</div>
								<?
									} else {
									}
								?>
									</div>
						</div>
	<!-- ** -->
	<?php
		if(isset($Catalogo_Perfiles)):
			foreach($Catalogo_Perfiles as $key=> $item):
			?>
				<div class="bhoechie-tab-content table-responsive">
					<div class="form-group">
						<label>

						</label>		
					<?php if( isset($item["Data"]) && $item["Data"] != NULL ){ ?>	
					<input type="checkbox" class="client" data-alias="tablaVen-<?php echo $key; ?>"> 
									Todos los <?php echo $item["Name"]; ?>	                       
						<table 
                        	class="table table-hover table-email-gap" 
                            id="tablaVenC-<?=$key; ?>" 
							<?= ($item["Name"] == "Vendedores" ? 'data-IdVen="'.$value["idTipoUser"].'"' : ""); ?>
						>
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
							foreach($item["Data"] as $items):
								if($items["CelularSMS"] != "" && $items["CelularSMS"] != "9999999999"){
						?>
								<tr>
									<td>
                                    	###
										<input 
                                        	type="checkbox" 
                                            class="tablaVen-<?= $value["IDVend"]; ?> emailGap client" 
                                            data-id="<?= $value["id"];?>" 
                                            data-sms ="<?= $items["CelularSMS"]; ?>"> 
										<a href="#"><i class="glyphicon glyphicon-phone"></i></a>
									</td>
									<td><strong><?= $items["username"]; ?></strong></td>
									<td><?php echo $items["CelularSMS"]; ?></td>
								<?php if($item['IdUser']==21){ ?>
									<td><a href="<?php echo(base_url().'mailMasivo/mandaBasura?id='.$items['id'] ) ?>">Eliminar</a></td>
								<?php } ?>
								</tr>
						<?php
								}
							endforeach; 
						?>

							</tbody>
						</table>
					<?php }else{?>
							   		<input type="checkbox" class="client" data-alias="tablaVen-<?php echo $key; ?>"> 
									Todos los <?php echo $item["Name"]; ?>
<table class="table table-hover table-email-gap" id="tablaVen-<?php echo $key; ?>" <?php echo ($item["Name"] == "Vendedores" ? 'data-IdVen="'.$value["idTipoUser"].'"' : "");?>>
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


					<?} ?>
					</div>
				</div>
					   
					  <?php if (isset($item["Data"])) {
							foreach ($item["Data"] as $value) { ?>
                                <?php /*if($value['idTipoUser'] == '6'):*/if($userProfile == '1'): ?>
								<div class="bhoechie-tab-content table-responsive">
									<div class="form-group">
										<label>
											<input type="checkbox" class="client" data-alias="tablaVen-<?php echo $value["IDVend"]; ?>">
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
																  <td>
                                                                  	<input 
                                                                    	type="checkbox" 
                                                                        class="tablaVen-<?= $value["IDVend"]; ?> emailGap client" 
                                                                        data-id="<?= $items["id"];?>"
																		data-sms ="<?= $items["CelularSMS"]; ?>"
																	> 
                                                                    <a href="#"><i class="glyphicon glyphicon-phone"></i></a></td>
																  <td><strong><?php echo $items["name_complete"]; ?></strong></td>
																  <td><?php echo $items["CelularSMS"]; ?></td>
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
                                <?php endif;?>
							<?php } 
						} ?>			
					<?php
					endforeach;
					?>
		
			<div class="bhoechie-tab-content table-responsive">
									<div class="form-group">aca estamos
										<table class="table table-hover table-email-gap" id="tablaVen-7">
											
												  <thead>
											<tr>
											  <th class="all"></th>
											  <th></th>
											  <th></th>
											</tr>
										  </thead>
										  <tbody>
										  </tbody>
										</table>
				</div>
			</div>
					<?php
				endif;
	?>
						</div>
					</div><!-- !bhoechie-tab-container -->
				</div><!-- !row -->
			</div><!-- !panel-body -->
		</div><!-- !panel-default -->
	</section><!-- !container-fluid -->

</section>

<div class="modal cargando"><!-- Place at bottom of page --></div>

	<script src="<?php echo site_url('assets/js/jquery.generic.cenis.js'); ?>"></script>
	<script type="text/javascript">
		$(document).ready(function() {
			var mainAltura = $('.main-page').height();
			$('.menu-sidebar').css('minHeight', mainAltura);
			var menuSidebar = $('.menu-sidebar');
			$(".submenu-secciones").click(function(e){
				e.preventDefault();
				e.stopPropagation();
				$(this).toggleClass('flipped');
				$('.main-page').toggleClass('main-page-close main-page-open');
				menuSidebar.toggleClass('menu-sidebar-close menu-sidebar-open');
			});
			//alert(window.location.href);
			$("div.bhoechie-tab-menu>div.list-group>a").click(function(e) {
				e.preventDefault();
				var idven = $(e.target).attr("data-idven");
				if (idven) 
				{
					//console.log(table);
					//console.log(table.find("tbody tr").length);
					var table = $("#tablaVen-" + idven);

					var Datos = { "IDVend" : idven };
					$.ajax({
						data: Datos,
						type: "POST",
						url: "mailMasivo/getClientes",
						error: function (jqXHR, textStatus, errorThrown) {
							alert("error: " + errorThrown); 
						},
						success: function (response) {
							//console.log(response);
							var Array_JSON = JSON.parse(response);
							
							//console.log(Array_JSON);
							//console.log("******************************************************************************************");
							table.find("tbody tr").remove();
							$.each(Array_JSON,function(k,v){
								
								
								
								var rowhead = '<tr class="sramo">'+
												'<td colspan="3"><input type="checkbox" class="client" data-alias="subramo" data-id="'+v.id+'">'+v.sramo+'</td>'+
											'</tr>';

								table.find("tbody").append(rowhead);

								
								$.each(v.data,function(i,item){

									console.log(item);

									var row = '<tr class="subsramo'+v.id+'" >' +
				                				'<td class="pleft"><input type="checkbox" data-id="'+ item.IDCli +'" data-id-sub="'+v.id+'" class="'+ table.attr("id") +' emailGap client sub'+v.id+'" data-sms="'+  item.Telefono1 +'"><a href="#"><i class="glyphicon glyphicon-phone"></i></a></td>' +
				                				'<td><strong>'+ item.NombreCompleto +'<strong></td>'+
				                				'<td>'+ item.Telefono1 + '</td>'+
				                			  '</tr>';
				                	//console.log(table);
				                	table.find("tbody").append(row);
				                	var agregado = $("#guest-list-gap input.guest_"+ item.IDCli).val();
				                	if (agregado)
				                	{
				                		$("." + table.attr("id")).prop("checked", true);
				                	}
								});
							});
						}
					});
				}

				$(this).siblings('a.active').removeClass("active");
				$(this).addClass("active");
				var index = $(this).index();
				$("div.bhoechie-tab>div.bhoechie-tab-content").removeClass("active");
				$("div.bhoechie-tab>div.bhoechie-tab-content").eq(index).addClass("active");
			});
		});
					
		$(document).on("click",".client",function (e) {
					 
			 data_value = $(this).attr("data-alias");
			 data_id = $(this).attr("data-id");
			 data_id_sub = $(this).attr("data-id-sub");
			 
			 if (data_value === undefined) {
				 
				//console.log("client");
				 
				 var guestView = "";
				 
				data_value = $(this).attr("data-sms");
				 
				 
				 
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
			 				guestView += "<input class='guest_" + dta_id +"_"+dta_id_sub+"' name='guests[]' value='" + $(item).attr("data-sms") + "'>";
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
					console.log(data_value);
					console.log(data_id);
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
								guestView += "<input class='guest_" + dta_id +"_"+dta_id_sub+"' name='guests[]' value='" + $(item).attr("data-sms") + "'>";
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
								guestView += "<input class='guest_" + dta_id +"_"+dta_id_sub+"' name='guests[]' value='" + $(item).attr("data-sms") + "'>";
							}
							$(item).prop( "checked", true );
						});

						var email = $("#"+data_value).find(".emailGap");		
						$.each(email,function(index,item){
							var dta_id = $(item).attr("data-id");
							var dta_id_sub = $(item).attr("data-id-sub");
							if($(".guest_" + dta_id+"_"+dta_id_sub).length == 0){
								guestView += "<input class='guest_" + dta_id +"_"+dta_id_sub+"' name='guests[]' value='" + $(item).attr("data-sms") + "'>";
							}
							$(item).prop( "checked", true );
						});						

						$("#guest-list-gap").append(guestView);	
						//$("#" + data_value + " input.emailGap").prop( "checked", true );
						//$("#" + data_value + " .client").prop( "checked", true );
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
								console.log(".guest_" + dta_id+"_"+dta_id_sub);
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
		
		/* Sms JjHe */

	init_contadorSmsText("smsText","contSmsText", 150);

	function init_contadorSmsText(idtextarea, idcontador,max){
		$("#"+idtextarea).keyup(function(){
			updateContadorTa(idtextarea, idcontador,max);
		});
    
		$("#"+idtextarea).change(function(){
			updateContadorTa(idtextarea, idcontador,max);
		});
	}

	function updateContadorTa(idtextarea, idcontador,max){
    	var contador = $("#"+idcontador);
    	var ta =     $("#"+idtextarea);
		contador.html("Caracteres usados: "+"0 de "+max);
		contador.html("Caracteres usados: "+ta.val().length+" de "+max);
		if(parseInt(ta.val().length)>max){
			ta.val(ta.val().substring(0,max-1));
			contador.html("Caracteres usados: "+max+" de "+max);
		}

	}

//menu-sidebar-close" id="menuSms"
<?php if(isset($abrirEmail)){?>
document.getElementById("menuSms").classList.add('menu-sidebar-open');
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

	</script>
<?php $this->load->view('footers/footer'); ?>