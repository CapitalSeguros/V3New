<?php $this->load->view('headers/header'); ?>
<?php $this->load->view('headers/menu');?>
<?php $this->load->view('generales/historialClientes');?>
<?php $this->load->view('generales/altaTelefonosCorreos');?>
<?php $this->load->view('generales/docPersonalesClienteAgregar');?>

<?php 
	//var_dump($datos_clientes_nuevos);
?>
<link rel="stylesheet" href="//code.jquery.com/ui/1.13.1/themes/base/jquery-ui.css">
<!--<script src="https://code.jquery.com/jquery-3.6.0.js"></script>-->
<script src="https://code.jquery.com/ui/1.13.1/jquery-ui.js"></script>
<!--<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">-->

<!--
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.2/css/bootstrap.min.css">
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.2/css/bootstrap-theme.min.css">
-->

<style type="text/css">
	
	/*#modal_info_contacto{

	background-color: rgba(0, 0, 0, 0.7);
    position: fixed;
    top: 0;
    left: 0;
    width: 100%;
    height: 100%;
    z-index: 1050;
	}*/

</style>
	<input type="hidden" id="base-url" data-url="<?=base_url()?>">
	<section class="container-fluid breadcrumb-formularios">
		<div class="row">
			<div class="col-md-6 col-sm-5 col-xs-5"><h3 class="titulo-secciones">Directorio</h3></div>
			<div class="col-md-6 col-sm-7 col-xs-7">
				<ol class="breadcrumb text-right">
					<li><a href="./">Inicio</a></li>
					<li class="active">Directorio</li>
				</ol>
			</div>
		</div>
			<hr /> 
	</section>

	<div>
		<div class="row">
			<div class="col-md-1">
				<button onclick="verPestania('divClientes')" class="buttonLatera"><img src="<?=base_url()."assets/img/directorio/clientes.png"?>" alt="Clientes" style="width: 80px; height: 80px"></button> <!--<h4>&#128104</h4> Clientes-->
				<?php if(isset($permisos["clienteN"])){?>
					<button onclick="verPestania('divClientesNuevos')" class="buttonLatera">Clientes Nuevos</button> <!--Dennis [2021-07-28]-->
				<?php }?>
				<?php if(isset($permisos["directory"])){ ?>
					<button onclick="verPestania('divAgentes')" class="buttonLatera"><img src="<?=base_url()."assets/img/directorio/agentes.png"?>" alt="Clientes" style="width: 80px; height: 80px"></button>
					<button onclick="verPestania('divEmpleados')" class="buttonLatera"><img src="<?=base_url()."assets/img/directorio/empleados.png"?>" alt="Clientes" style="width: 80px; height: 80px"></button>
					<button onclick="verPestania('divProveedores')" class="buttonLatera"><img src="<?=base_url()."assets/img/directorio/proveedores.png"?>" alt="Clientes" style="width: 80px; height: 80px"></button>
				<?php }?>
				<button onclick="verPestania('notas_contenedor_get')" class="buttonLatera"><img src="<?=base_url()."assets/img/directorio/notas.png"?>" alt="Clientes" style="width: 80px; height: 80px"></button>
				<button onclick="verPestania('divCumpleanios')" class="buttonLatera">Cumpleaños</button>
			</div>
			<div class="col-md-10">
				<!-------------------Vista de cumpleaños---------------------->
					<div class="divContenedor ocultarObjeto" id="divCumpleanios" style="width: 1200px">
						<h5>Agentes y colaboradores que cumplen años hoy</h5>
						<hr>
						<div class="col-md-12">
							<div class="col-md-4">
								<div class="row">
									<div class="col-md-4">Seleccione un mes:</div>
									<div class="col-md-6">
										<select name="birthMonth" id="birthMonth" class="form-control input-sm">
											<option value="">SELECCIONE</option>
											<?=array_reduce(array(1,2,3,4,5,6,7,8,9,10,11,12), function($acc, $curr) use($meses_){
												$selected = $curr == date("n") ? "selected" : "";
												$acc .= '<option value="'.$curr.'" '.$selected.'>'.$meses_[$curr].'</option>';
												return $acc;
											}, ""); ?>
										</select>
									</div>
								</div>
							</div>
							<div class="col-md-2">
								<button class="btn btn-primary btn-sm filterDates">REALIZAR FILTRO</button>
							</div>
							<div class="col-md-2 show-modal-congratulation"></div>
						</div>
						<div class="col-md-12 mt-4">
							<h4>Felicitemos a nuestros compañeros del mes de <?=$meses_[date("n")]?></h4>
							<br>
							<div class="col-md-12">
								<div class="col-md-6">
									<div class="row">
										<div class="col-md-2">Filtrar por días</div>
										<div class="col-md-4">
											<select name="birthday" id="birthday_" class="form-control input-sm">
												<option value="00">SELECCIONE</option>
												<?php sort($birthDays); 
													$options = array_reduce($birthDays, function($acc, $curr){
														$selected = $curr == date("d") ? "selected" : "";
														$acc .= '<option value="'.$curr.'" >'.$curr.'</option>';
														return $acc;
													}, "");
													echo $options;
												?>
											</select>
										</div>
									</div>
								</div>
							</div>
							<br>
							<div class="birthdays-container mt-4">
							<?php ksort($birthdays); foreach($birthdays as $typeWeek => $hbs){?>
								<div class="card mt-4">
									<div class="card-header">
										<h4><a class="btn btn-link birth-day-collapse" data-toggle="collapse" href="#<?=$hbs["typeOfWeek"]?>" role="button" aria-expanded="false" aria-controls="<?=$hbs["typeOfWeek"]?>">Cumpleaños de la semana <?=$hbs["typeOfWeek"]?> <span class="caret"></span> </a></h4>
									</div>
									<div class="card-body collapse show in" id="<?=$hbs["typeOfWeek"]?>">
										<div class="card-group">
											<?php foreach($hbs["persons"] as $d_p){?>
												<div class="col-md-3 card-hbd" id="bd-<?=date("d", strtotime($d_p->fechaNacimiento))?>">
													<div class="card">
														<img class="card-img-top" src="<?=base_url()."assets/img/miInfo/userPhotos/".$d_p->fotoUser?>" alt="Card image cap" >
														<div class="card-body">
															<h5 class="card-title"><?=$d_p->name_complete?></h5>
															<div class="row">
																<div class="col-md-5"><p><?php $bd = explode("-", $d_p->fechaNacimiento); echo $bd[2]."/".$meses_[date("n", strtotime($d_p->fechaNacimiento))]; ?></p></div>
																<div class="col-md-7"><p><?=$d_p->area?> / <?=$d_p->employment?></p></div>
																<div class="col-md-12"><button class="btn btn-info btn-xs" type="button" data-toggle="collapse" data-target="#<?=$d_p->idPersona?>" aria-expanded="false" aria-controls="<?=$d_p->idPersona?>">Ver datos de contacto</button></div>
															</div>
															<div class="collapse table-responsive" id="<?=$d_p->idPersona?>">
																<br>
																<table class="table">
																	<tbody>
																		<tr><td>Celular</td><td><?=$d_p->celPersonal?></td></tr>
																		<tr><td>E-mail</td><td><?=$d_p->email?></td></tr>
																		<tr><td>E-mail personal</td><td><?=$d_p->emailPersonal?></td></tr>
																	</tbody>
																</table>
															</div>
														</div>
													</div>
												</div>
											<?php }?>
										</div>
									</div>
								</div>
							<?php }?>
							</div>
						</div>
						<!-------------------->
						<div class="modal fade congratulations" tabindex="-1" role="dialog" aria-labelledby="congratulations" aria-hidden="true">
						<div class="modal-dialog modal-lg">
							<div class="modal-content">
								<div class="modal-body hbd-content"></div>
								<div class="modal-footer"><button type="button" class="btn btn-default" data-dismiss="modal">Close</button></div>
							</div>
						</div>
						</div>
						<!-------------------->
					</div>
					<!------------------Vista de notas asignadas------------------->
					<div class="container-fluid divContenedor ocultarObjeto" id="notas_contenedor_get">
						<div class="card">
							<div class="card-header">
								<h5>Notas asignadas al agente: <?=$this->tank_auth->get_usermail();?></h5>
							</div>
							<div class="card-body">
								<?php if(!empty($datos_nota)){ ?>

									<?php if(!empty($resalta_nota)) {?> 
										<div class="card border-info mb-3">
											<div class="card-header"><h5>Nota reciente creada o actualizada</h5></div>
											<div class="card-body">
												<table class="table">
													<thead>
														<tr>
															<th class="text-center">Número de cliente</th>
															<th class="text-center">Nombre del cliente</th>
															<th class="text-center">Comentario de nota</th>
														</tr>
													</thead>
													<tbody>
													<?php foreach($resalta_nota as $d_n){?>
														<tr>
															<td><?=$d_n->id_cliente?></td>
															<td><?=$d_n->nombre_del_cliente?></td>
															<td>
																<h6>
																	<span class="text-muted">
																	<?php if(!empty($d_n->fecha_creacion)) {?><i class="fa fa-calendar" aria-hidden="true"></i>&nbsp<?=$d_n->fecha_creacion?><?php }?>
																	<?php if(!empty($d_n->fecha_actualizacion)) {?> - Actualizacion: <?=$d_n->fecha_actualizacion?> <?php }?>
																	</span>
																</h6>
																<?=$d_n->comentario?>
															</td>
														</tr>
													<?php }?>
													</tbody>
												</table>	
											</div>
										</div><br>
									<?php }?>

									<div class="card">
										<div class="card-header">
											<h5>Mis notas asignadas</h5>
										</div>
										<div class="card-body">
											<table class="table">
												<thead>
													<tr>
														<th class="text-center">Número de cliente</th>
														<th class="text-center">Nombre del cliente</th>
														<th class="text-center">Comentario de nota</th>
													</tr>
												</thead>
												<tbody>
											
											<?php foreach($datos_nota as $cliente => $datos_notas){
													$c=1;
												?>
												<tr>
													<td rowspan="<?= count($datos_notas["comentarios"])?>"><?=$cliente?></td>
													<td rowspan="<?= count($datos_notas["comentarios"])?>"><?=$datos_notas["nombre_cliente"]?></td>
													<td>
														<h6>
															<span class="text-muted">
															<?php if(!empty($datos_notas["comentarios"][0]["fecha_creacion"])) {?><i class="fa fa-calendar" aria-hidden="true"></i>&nbsp<?=$datos_notas["comentarios"][0]["fecha_creacion"]?><?php }?>
															<?php if(!empty($datos_notas["comentarios"][0]["fecha_actualizacion"])) {?> - Actualizacion: <?=$datos_notas["comentarios"][0]["fecha_actualizacion"]?> <?php }?>
															</span>
														</h6>
														<?=$datos_notas["comentarios"][0]["contenido"]?>
													</td>
												</tr>
												<?php for($a=1; $a<count($datos_notas["comentarios"]); $a++){ ?> 
													<tr>
														<td>
															<h6>
																<span class="text-muted">
																<?php if(!empty($datos_notas["comentarios"][$a]["fecha_creacion"])) {?><i class="fa fa-calendar" aria-hidden="true"></i>&nbsp<?=$datos_notas["comentarios"][$a]["fecha_creacion"]?><?php }?>
																<?php if(!empty($datos_notas["comentarios"][$a]["fecha_actualizacion"])) {?> - Actualizacion: <?=$datos_notas["comentarios"][$a]["fecha_actualizacion"]?> <?php }?>
																</span>
															</h6>
															<?=$datos_notas["comentarios"][$a]["contenido"]?>
														</td>
													</tr>
												<?php }?>
											<?php }?>
												</tbody>
											</table>
										</div>
									</div>
								<?php } else{?> <h3 class="text-center">No hay notas asignados para este perfil</h3> <?php }?>
							</div>
						</div>
					</div>
					<!-------------------------------------------------------------->
					<!-- Dennis [2021-07-28] -->
					<div id="divClientesNuevos" class="divContenedor ocultarObjeto">
						<div class="panel panel-default">
							<div class="panel-heading bg-default"><h5>Listado de clientes nuevos</h5></div>
							<div class="panel-body">
								<?php 
									$tabs = array_keys($datos_clientes_nuevos); 
									$active = $tabs[0]; 
								?>
								<ul class="nav nav-pills" id="tabsCanales" role="tablist">
									<?php array_map(function($arr) use($active){ ?>
										<li class="nav-item <?= $arr == $active ? "active" : "" ?>">
											<a class="nav-link" id="<?=$arr?>_" href="#<?=$arr?>" data-toggle="tab" role="tab" aria-controls="<?=$arr?>" aria-selected="<?=($arr == "institucional" ? "true" : "false")?>"><?=strtoupper($arr)?></a>
										</li>
									<?php }, $tabs);?>
								</ul>
								<div class="tab-content" id="tabContent">
									<?php foreach($datos_clientes_nuevos as $k => $data){?>
										<div class="tab-pane fade <?= $k == $active ? "in active" : "" ?>" id="<?=$k?>" role="tabpanel" aria-labelledby="<?=$k?>_">
											<div class="col-md-12" style="display: inline-block; vertical-align: top">
												<h4 class="mb-4">Clientes nuevos del canal: <?=strtoupper($k)?></h4>
												<h4 class="mb-4 titulo_consulta_<?=$k?>">Clientes nuevos agregados en el mes de: <?=strtoupper($meses_[date("n")])?></h4>
											</div>
											<div class="col-md-12 mb-4">
												<button class="btn btn-primary" data-toggle="collapse" data-target="#filter-new-client-<?=$k?>" aria-expanded="false" aria-controls="filter-new-client-<?=$k?>">Mostrar filtros</button>
												<div class="panel panel-body collapse border visible mt-4" id="filter-new-client-<?=$k?>">
													<h4 class="mb-4">Filtrar clientes nuevos por meses anteriores</h4>
													<form action="#" id="form_consulta_<?=$k?>" class="query-form mb-4" data-channel="<?=$k?>">
														<div class="row ml-2">
															<div class="mt-2 text-center"><label for="canal_<?=$k?>">Canal</label></div>
															<div class="col-md-2"><input type="text" name="canal_" id="c_<?=$k?>" class="form-control input-sm"  value="<?=strtoupper($k)?>" readonly></div>
															<div class="mt-2 text-center"><label for="canal_<?=$k?>_">Inicia</label></div>
															<div class="col-md-2"><input type="text" name="fechaInicial" class="form-control input-sm datepicker" size="30"></div>
															<div class="mt-2 text-center"><label for="canal_<?=$k?>_">Finaliza</label></div>
															<div class="col-md-2"><input type="text" name="fechaFinal" class="form-control input-sm datepicker" size="30"></div>
															<div class="col-md-2"><button class="btn btn-info btn-sm" data-canal="<?=$k?>">Consultar</button></div>
														</div>
													</form>
													<div class="message-container-<?=$k?>"></div>
												</div>
											</div>
											<hr>
											<div class="row contenedor_<?=$k?>">
											<?php if(!empty($data)){?>
												<?php array_map(function($arr_){ ?>
													<div class="col-md-4">
														<div class="thumbnail">
															<div class="jumbotron text-center">
																<h5><strong><?=strtoupper($arr_->nombreCliente)?></strong></h5>
															</div>
															<div class="caption">
																<table class="table">
																	<tbody>
																		<tr><td>Cliente número:</td><td><?=$arr_->IDCli?></td></tr>
																		<tr><td>Fecha de captura:</td><td><?=date("d-m-Y", strtotime($arr_->fechaCaptura))?></td></tr>
																		<tr><td>Polizas capturadas</td><td><?=$arr_->polizasRecientes?></td></tr>   
																		<tr>
																			<td colspan="2">
																				<div class="dropdown">
																					<button class="btn btn-link btn-sm" type="button" id="dropdownMenu1" data-toggle="dropdown" aria-expanded="true">
																						Ver opciones
																						<span class="caret"></span>
																					</button>
																					<ul class="dropdown-menu" role="menu" aria-labelledby="dropdownMenu1">
																						<li role="presentation"><a role="menuitem" tabindex="-1" href="<?=base_url()?>directorio/GetPoliza?IDCli=<?=$arr_->IDCli?>&page=0" target="_blank"><i class="fa fa-eye" aria-hidden="true"></i> Ver pólizas</a></li>
																						<li role="presentation"><a role="menuitem" class="client-data" id_cliente="<?=$arr_->IDCli?>" tabindex="-1" href="javascript: void(0)"><i class="fa fa-users" aria-hidden="true"></i> Preferencias de contacto</a></li>
																						<li role="presentation"><a role="menuitem" class="client-notes" id_cliente="<?=$arr_->IDCli?>" cliente_nombre="<?=$arr_->nombreCliente?>" tabindex="-1" href="javascript: void(0)"><i class="fa fa-sticky-note-o" aria-hidden="true"></i> Notas</a></li>
																						<li role="presentation" ><a role="menuitem" tabindex="-1" href="<?php echo base_url(); ?>directorio/llamarCotizacion?IDCli=<?= $arr_->IDCli; ?>" target="_blank" >&#128077 Cotizar</a></li>
																						<li role="presentation"><a role="menuitem" tabindex="-1" href="<?php echo base_url(); ?>directorio/llamarFianzas?IDCli=<?= $arr_->IDCli; ?>" target="_blank" >&#128200 Fianzas</a></li>
																						<li role="presentation"><a role="menuitem" tabindex="-1" href="javascript: void(0)" onclick="traerHistorialClientes('',<?= $arr_->IDCli; ?>)"><i class="fa fa-eye" aria-hidden="true"></i>&nbsp Bitacora</a></li>
                                                        								<li role="presentation"><a role="menuitem" tabindex="-1" href="javascript: void(0)" onclick="asignarValParaDatosClientes(<?= $arr_->IDCli; ?>);traerTelEmailAltaTCGenerales()"><i class="fa fa-eye" aria-hidden="true"></i>&nbsp Agregar Datos</a></li>
																					</ul>
																				</div>
																			</td>
																		</tr>
																	</tbody>
																</table>
															</div>
														</div>
													</div>
												<?php }, $data)?>
											<?php } else{?><div class="col-md-12 text-center"><h3>No existen clientes nuevos de este mes</h3></div><?php }?>
											</div>
										</div>
									<?php }?>
								</div>
							</div>
						</div>

						<div class="modal fade" id="modal_contacto" tabindex="-1" role="dialog" aria-labelledby="modal_contacto_label" aria-hidden="true">
							<div class="modal-dialog" role="document">
								<div class="modal-content">
									<div class="modal-header">
										<h5 class="modal-title" id="modal_contacto_label">Datos del contacto</h5>
										<button type="button" class="close" data-dismiss="modal" aria-label="Close">
										<span aria-hidden="true">&times;</span>
										</button>
									</div>
									<div class="modal-body cliente_nuevo_contenedor">
										...
									</div>
									<div class="modal-footer">
										<button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
										<button type="button" class="btn btn-primary actualizaCliente">Actualizar</button>
									</div>
								</div>
							</div>
						</div>
						<!---->
					</div>
					<!-------------------------------------------------------------->
					<div id="divAgentes" class="divContenedor ocultarObjeto">
						<table class="table">
							<thead>
								<tr>
									<th colspan="6"><h4>Agentes</h4>
									</th>
								</tr>
								<tr>
									<th>Nombre</th>
									<th>Apellido Paterno</th>
									<th>Apellido Materno</th>
									<th>Celular</th>
									<th>Email</th>
									<th>Ranking</th>
								</tr>
								<tr>
									<th colspan="6"><input type="text" class="form-control" placeholder="filtro por nombres y apellidos" onchange="buscarEnTabla(this.value,'bodyVendedores')"></th>
								</tr>
								</thead>
							<tbody id="bodyVendedores">
							<?=imprimirVendedores($personas);?>
							</tbody>
						</table>
					</div><!--divAgentes-->
					<div id="divEmpleados" class="divContenedor ocultarObjeto">
						<table class="table">
							<thead>
								<th colspan="6"><h4>Empleados</h4>
								<tr>
									<th>Nombre</th>
									<th>Apellido Paterno</th>
									<th>Apellido Materno</th>                     
									<th>Celular</th>
									<th>Email</th>
									<th>Area</th>
								</tr>
								<tr>
									<th colspan="6"><input type="text" class="form-control" placeholder="filtro por nombres y apellidos" onchange="buscarEnTabla(this.value,'bodyEmpleados')"></th>
								</tr>                 
							</thead>
							<tbody id="bodyEmpleados">
								<?=imprimirEmpleados($personas);?>
							</tbody>
						</table>
					</div><!--divEmpleados-->
					<div id="divProveedores" class="divContenedor ocultarObjeto">
						<table class="table">
							<thead>
								<tr>
									<th>Nombre</th>
									<th>Apellido Contacto</th>
									<th>Cel. Personal</th>
									<th>Email</th>
								</tr>
								<tr>
									<th colspan="6"><input type="text" class="form-control" placeholder="filtro por nombres y apellidos" onchange="buscarEnTabla(this.value,'bodyProveedores')"></th>
								</tr>                 
							</thead>
							<tbody id="bodyProveedores">
								<?=imprimirProveedores($proveedores)?>
							</tbody>
						</table>

					</div><!--divProveedores-->
					<div id="divClientes" class="divContenedor verObjeto">
					<!--<section class="row">-->
						<div class="col-lg-12 mb-4">
							<form  id="myForm" method="POST" action="<?=base_url()?>directorio" >                	
								<div class="col-md-1">
									<label for="FechaInicio">Buscar Clientes</label>
								</div>
								<div class="col-md-2">
									<select class="form-control" name="tipoPersona"><option value='-1'></option><option value='1'>MORAL</option><option value='0'>FISICA</option></select>
								</div>
								<div class="input-group col-md-4" style="z-index:1">
									<input type="text" class="form-control" id="BusquedaCliente" name="busquedaDirectorio" value="<?php if(isset($busquedaDirectorio) ){ echo $busquedaDirectorio; } ?>" placeholder="Buscar">
									<span class="input-group-btn"><button class="btn btn-primary search-trigger"><i class="fa fa-search"></i>&nbsp;</button></span>                        
									<input type="hidden" value="<?php if(isset($busquedaDirectorio) ){ echo $busquedaDirectorio; } ?>" class="name_search"/>
									<input type="hidden"  name="page" class="name_page" value="<?php if(isset($page) ){ echo $page; } ?>"/>
								</div>
						
							</form>
						</div>
						<!---------------------- Dennis [2021-03-18] ---------------------------------->
						<div class="col-md-12" style="margin: top 15px">

							<div class="panel panel-default">
								<div class="panel-heading text-center"><h5>Resultado de búsqueda</h5></div>
								<div class="panel-body">

									<div class="row">
										<input type="hidden" value="<?=$this->tank_auth->get_userprofile()?>" id="tipoPersona">
										<?php if(!empty($data_result)){?>
											<?php foreach($data_result["cliente"] as $Cliente) {?>
												<?php //if($Cliente->FieldInt2=="0") {?>
											
												<div class="col-xs-4">
													<div class="thumbnail" style="z-index: 1; position: static">
														<label for="cliente">CLIENTE: <?=$Cliente->IDCli?></label>
														<div class="jumbotron">
															<h5 class="text-center"><strong><?=$Cliente->NombreCompleto?></strong></h5>
														</div>
														<label for="informacion">Información básica del cliente</label>
														<div class="caption table-responsive">
															<table class="table table-condensed">
																<tbody>
																	<tr>
																		<td>Persona:</td>
																		<td><?= $Cliente->TipoEnt_TXT?></td>
																	</tr>
																	<tr>
																		<td>RFC:</td>
																		<td><?= $Cliente->RFC?></td>
																	</tr>
																	<tr>
																		<td>Ranking:</td>
																		<td><?= $Cliente->ranking?></td>
																	</tr>
																	<tr>
																		<td>Agente Sicas:</td>
																		<td><?= $Cliente->FieldInt1?></td>
																	</tr>
																	<!-- //------------------- Cambios Miguel Avila| Tic Consultores| 30_09_2021 -->
																	<tr>
																		<td>Siniestros Activos:</td>
																		<td><?= $Cliente->SiniestrosActivos?></td>
																	</tr>
																	<!-- //------------------- Cambios Miguel Avila| Tic Consultores| 30_09_2021 -->
																	<tr>
																		<td colspan="2">
																			<div class="dropdown" style="z-index: 2; position: absolute">
																				<a id="opcionesClient" data-target="#" href="javascript: void(0)" data-toggle="dropdown" aria-expanded="false" aria-haspopup="true">Ver opciones<span class="caret"></span></a>
																				<ul class="dropdown-menu" aria-labelledby="opcionesClient" role="menu">
																					<li role="presentation"><a role="menuitem" tabindex="-1" href="<?php echo base_url(); ?>directorio/GetPoliza?IDCli=<?php echo $Cliente->IDCli; ?>&page=<?php echo $page; ?>"><i class="fa fa-eye" aria-hidden="true"></i>&nbspVer Polizas</a></li>
																					<li role="presentation"><a role="menuitem" tabindex="-1" href="<?php echo base_url(); ?>directorio/registroDetalle?IDCli=<?php echo $Cliente->IDCli; ?>&page=<?php echo $page; ?>"><i class="fa fa-eye" aria-hidden="true"></i>&nbspVer Datos</a></li>
																					<li role="presentation"><a role="menuitem" tabindex="-1" href="<?php echo base_url(); ?>directorio/GetFianza?IDCli=<?php echo $Cliente->IDCli; ?>&page=<?php echo $page; ?>"><i class="fa fa-eye" aria-hidden="true"></i>&nbspVer Fianzas</a></li>

																					<!-- //------------------- Cambios Miguel Avila| Tic Consultores| 30_09_2021 -->
																					<?php if($Cliente->SiniestrosActivos!=0) : ?>
																						<li role="presentation" id="opcion_siniestro" onclick="getSiniestrosActivos(<?= $Cliente->IDCli; ?>)" data-id="<?= $Cliente->IDCli; ?>" style="cursor:pointer;"><a role="menuitem" tabindex="-1"><i class="fa fa-eye" aria-hidden="true"></i>&nbspVer Siniestros</a></li>
																					<?php endif; ?>
																					<!-- //-------------------  Cambios Miguel Avila| Tic Consultores| 30_09_2021 -->
																					<li role="presentation"><a role="menuitem" class="client-data" tabindex="-1" href="javascript: void(0)" id_cliente="<?=$Cliente->IDCli?>"><i class="fa fa-users" aria-hidden="true"></i>&nbspPreferencia de contacto</a></li>
																					<li role="presentation" ><a role="menuitem" tabindex="-1" href="<?php echo base_url(); ?>directorio/llamarCotizacion?IDCli=<?= $Cliente->IDCli; ?>" target="_blank" >&#128077 Cotizar</a></li>
																					<li role="presentation"><a role="menuitem" tabindex="-1" href="<?php echo base_url(); ?>directorio/llamarFianzas?IDCli=<?= $Cliente->IDCli; ?>" target="_blank" >&#128200 Fianzas</a></li>
																					<li role="presentation"><a role="menuitem" class="client-notes" tabindex="-1" href="javascript: void(0)" id_cliente="<?=$Cliente->IDCli?>" cliente_nombre="<?=$Cliente->NombreCompleto?>"><i class="fa fa-sticky-note-o" aria-hidden="true"></i>&nbspNotas asignadas</a></li>
																					<li role="presentation"><a role="menuitem" tabindex="-1" href="javascript: void(0)" onclick="traerHistorialClientes('',<?= $Cliente->IDCli; ?>)"><i class="fa fa-eye" aria-hidden="true"></i>&nbsp Bitacora</a></li>
																					<li role="presentation" ><a role="menuitem" tabindex="-1" href="javascript: void(0)" onclick="asignarValParaDatosClientes(<?= $Cliente->IDCli; ?>);traerTelEmailAltaTCGenerales()"><i class="fa fa-eye" aria-hidden="true"></i>&nbsp Agregar Datos</a></li>
											   <li role="presentation" >
		<button class="fa fa-eye buttonOpciones" onclick="traerDigitalDPCAGenerales('',<?= $Cliente->IDCli; ?>)">&nbsp Agregar Documentos
																</button>
																
															</li>																														

	   <li role="presentation" >
	   																	<a role="menuitem" tabindex="-1" href="<?php echo base_url(); ?>crmproyecto/deteccionNecesidadesCliente?IDCli=<?= $Cliente->IDCli; ?>" target="_blank" >Deteccion de Necesidades
																</a>

																
															</li>																														
														</ul>
																			</div>
																		</td>
																	</tr>
																</tbody>
															</table>
														</div>
													</div>
												</div>
													<?php //}?>
											<?php }?>
										<?php } else{?>
											<h3 class="text-center">No hay datos por el momento</h3>
										<?php }?>
									</div>
								</div>
								</div>
							</div>
						</div>
					<!--</section> -->
					</div>
			</div>
		</div>
	</div>
<!--
<script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous"></script>-->
<!--<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>-->


<!--:::::::::: INICIO TIC CONSULTORES CONTENIDO |Miguel Avila | 30/09/2021  ::::::::::-->
<div class="modal" id="modal_info_siniestros" tabindex="-1" role="dialog" aria-labelledby="modal_info_siniestros" aria-hidden="true">
	<div class="modal-dialog" role="document">
		<div class="modal-content" style="width:60vw !important;margin-left: -10vw;">
			<div class="modal-header">
				<h4 class="modal-title text-center" id="cliente_m_h">Registro de Siniestros Activos</h4>
				<button type="button" class="close" data-dismiss="modal" aria-label="Close">
					<span aria-hidden="true">&times;</span>
				</button>
			</div>
			<div class="modal-body">
				<div class="row" id="Contenido_siniestro">
					<div class="col-md-12">
						<table class="table table-hover"> 
							<thead>
								<tr>
									<th># Siniestro</th>
									<th>Poliza</th>
									<th>Fecha Inicio</th>
									<th>Tipo</th>
									<th>Acción</th>
								</tr>
    						</thead>
							<tbody id="siniestro_tabla">

							</tbody>
						</table>
					</div>
				</div>
			</div>
			<div class="modal-footer">
				<!-- <button type="button" class="btn btn-info" style="display: none" id="up_contacto">Actualizar</button> -->
				<button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
			</div>
		</div>
	</div>
</div>
<script src="<?=base_url()?>assets/gap/js/directorio_siniestros.js"></script> 

<!--:::::::::: FIN TIC CONSULTORES CONTENIDO |Miguel Avila | 30/09/2021 ::::::::::-->

<div class="modal fade" id="modal_info_contacto" tabindex="-1" role="dialog" aria-labelledby="modal_info_contactoLabel" aria-hidden="true">
	<div class="modal-dialog" role="document">
		<div class="modal-content">
			<div class="modal-header">
				<!--<h5 class="modal-title" id="modal_info_contactoLabel">Modal title</h5>-->
				<h4 class="modal-title cliente_m_h"></h4>
				<button type="button" class="close" data-dismiss="modal" aria-label="Close">
					<span aria-hidden="true">&times;</span>
				</button>
			</div>
			<div class="modal-body">
				<div class="form-row" id="cliente_m_b"></div>
				<div class="row">
					<div class="col-md-6"><button class="btn btn-primary" data-toggle="collapse" href="#guion_tel" role="button" aria-expanded="false" aria-controls="guion_tel">Guión telefónico</button></div>
				</div>
				<div class="collapse" id="guion_tel">
					<div class="panel panel-body">
						<h4 class="visible">Guión telefónico</h4>
						<div class="">
							<div class="list-group visible" id="myList" role="tablist">
								<?php if(!empty($guionTelefonico)){ 
									foreach($guionTelefonico as $id => $d_g){?>
										<a class="list-group-item list-group-item-action" data-toggle="list" href="#g_<?=$id?>" role="tab"><?=$d_g["nombre"]?></a>
								<?php }
								}?>
							</div>
							<div class="">
								<div class="tab-content">
									<div class="tab-pane bg-white active" id="inicio" role="tabpanel">
										<h3 class="text-center">Visualice cualquier de los ejemplos arriba</h3>
									</div>
									<?php if(!empty($guionTelefonico)){
										foreach($guionTelefonico as $id => $d_g){?>
											<div class="tab-pane bg-white" id="g_<?=$id?>" role="tabpanel">
												<h4>Ejemplo de guía telefónica (Guión para referidos)</h4>
												<br>
												<div class="ml-4">
													<?php foreach($d_g["mensaje"] as $conversacion){?>
														<h4><span class="badge badge-primary mb-2"><?=$conversacion["etiqueta"]?></span></h4><br>
														<p class="text-dark font-italic"><?=$conversacion["texto"]?></p><br>
													<?php }?>
												</div>
											</div>
										<?php }
									}?>
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>
			<div class="modal-footer">
				<button type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button>
				<button type="button" class="btn btn-info" style="display: none" id="up_contacto">Actualizar</button>
			</div>
		</div>
	</div>
</div>
<!--</div>-->

<input type="hidden" data-url="<?=base_url()?>" class="base_url">
<script src="<?=base_url()."assets/js/js_directorioClientes.js"?>"></script> <!--Dennis [2021-03-08] -->
<script src="<?=base_url()."assets/js/jquery.clientesNuevos.js"?>"></script> <!--Dennis [2021-07-29] -->
<script src="<?=base_url()."assets/js/jquery.birthdays.js"?>"></script> <!--Dennis [2021-07-29] -->
<!------>

<!--:::::::::: FIN CONTENIDO ::::::::::-->
<script>
//para paginacion
$(document).ready(function(){
	$(".pag_cenis").click(function(e){
		  e.preventDefault();
		
		$data_page = $(this).attr("data-pag");
		$data_search = $(".name_search").val();
		
		$("input[name=page]").val($data_page );
		$("input[name=busquedaDirectorio]").val($data_search);		
		$('#myForm').trigger('submit');	
	});
//	$("select option").select(){ }
	$("#Cliente").change(function(){
		$IDCli = $(this).val();
		/*
		$NameSelect = $(this).attr("name");

		if($NameSelect != "Proveedores"){ //--> JjHe
			DetalleRegistro($IDCli);
		} else {
			DetalleRegistroProveedor($IDCli);
		}
		*/
		DetalleRegistro($IDCli);
	});
	
	$("#Prospecto").change(function(){
		$IDCli = $(this).val();
		/*
		$NameSelect = $(this).attr("name");

		if($NameSelect != "Proveedores"){ //--> JjHe
			DetalleRegistro($IDCli);
		} else {
			DetalleRegistroProveedor($IDCli);
		}
		*/
		DetalleRegistro($IDCli);
	});
	
	$("#Proveedor").change(function(){
		$IDCli = $(this).val();
		/*
		$NameSelect = $(this).attr("name");

		if($NameSelect != "Proveedores"){ //--> JjHe
			DetalleRegistro($IDCli);
		} else {
			DetalleRegistroProveedor($IDCli);
		}
		*/
		DetalleRegistroProveedor($IDCli);
	});
	

	function DetalleRegistro(IDCli){
		window.open('<?php echo base_url(); ?>directorio/registroDetalle?IDCli='+IDCli,'_self');
	}
	/* JjHe */
	function DetalleRegistroProveedor(IdOrganizacion){
		window.open('<?php echo base_url(); ?>directorio/registroDetalleProveedor?IdOrganizacion='+IdOrganizacion,'_self');
	}
});
</script>

<script language="javascript" type="text/javascript">
    function MakeStaticHeader(gridId, height, width, headerHeight, isFooter) {
        var tbl = document.getElementById(gridId);
        if (tbl) {
        var DivHR = document.getElementById('DivHeaderRow');
        var DivMC = document.getElementById('DivMainContent');
        var DivFR = document.getElementById('DivFooterRow');

        //*** Set divheaderRow Properties ****
        DivHR.style.height = headerHeight + 'px';
        DivHR.style.width = (parseInt(width) - 16) + 'px';
        DivHR.style.position = 'relative';
        DivHR.style.top = '0px';
        DivHR.style.zIndex = '10';
        DivHR.style.verticalAlign = 'top';

        //*** Set divMainContent Properties ****
        DivMC.style.width = width + 'px';
        DivMC.style.height = height + 'px';
        DivMC.style.position = 'relative';
        DivMC.style.top = -headerHeight + 'px';
        DivMC.style.zIndex = '1';

        //*** Set divFooterRow Properties ****
        DivFR.style.width = (parseInt(width) - 16) + 'px';
        DivFR.style.position = 'relative';
        DivFR.style.top = -headerHeight + 'px';
        DivFR.style.verticalAlign = 'top';
        DivFR.style.paddingtop = '2px';

        if (isFooter) {
         var tblfr = tbl.cloneNode(true);
      tblfr.removeChild(tblfr.getElementsByTagName('tbody')[0]);
         var tblBody = document.createElement('tbody');
         tblfr.style.width = '100%';
         tblfr.cellSpacing = "0";
         //*****In the case of Footer Row *******
         tblBody.appendChild(tbl.rows[tbl.rows.length - 1]);
         tblfr.appendChild(tblBody);
         DivFR.appendChild(tblfr);
         }
        //****Copy Header in divHeaderRow****
        DivHR.appendChild(tbl.cloneNode(true));
     }
    }


    function OnScrollDiv(Scrollablediv) {
    document.getElementById('DivHeaderRow').scrollLeft = Scrollablediv.scrollLeft;
    document.getElementById('DivFooterRow').scrollLeft = Scrollablediv.scrollLeft;
    }

     window.onload = function() {
   MakeStaticHeader('tabla', 250, 1350, 40, false)
     }
  function buscarEnTabla(cadenaBusqueda,tBody)
  {
      let texto=cadenaBusqueda.toUpperCase();
      let tabla=document.getElementById(tBody);
      let totalRows=tabla.rows.length;
      if(texto==''){for(var i=0;i<totalRows;i++){tabla.rows[i].classList.remove('ocultarObjeto');}}
  else{ 
      for(var i=0;i<totalRows;i++)
      {       
        if ( tabla.rows[i].dataset.nombre.indexOf(texto) !== -1 ){tabla.rows[i].classList.remove('ocultarObjeto'); }
        else{ tabla.rows[i].classList.add('ocultarObjeto'); }
      }
     }
  }
</script>
<script>
function verPestania(pestania)
{
    /*let div=document.getElementsByClassName('divContenedor');
    div.forEach(capa=>
    {   capa.classList.remove('verObjeto')
        capa.classList.add('ocultarObjeto')
    })*/
    var i = Array.from(document.getElementsByClassName('divContenedor'));
    i.forEach(capa=>{capa.classList.remove('verObjeto')
        capa.classList.add('ocultarObjeto')})
    document.getElementById(pestania).classList.add('verObjeto');
    document.getElementById(pestania).classList.remove('ocultarObjeto');
}
function asignarValParaDatosClientes(IDCli)
{
if (typeof idClienteTelEmailGeneralGloblal != 'undefined') { idClienteTelEmailGeneralGloblal = IDCli }
}

</script>
<style>
    .buttonLatera{min-width: 90px;min-height: 90px;width: 90px;height: 90px;background-color: white}
    .buttonLatera:hover{background-color: #d2cbdc}
    .buttonOpciones{border: none; background-color: white}
</style>
<?php $this->load->view('footers/footer'); ?>
<style>
    .verObjeto{display:block}
    .ocultarObjeto{display:none}
 </style>
 <?php
  function imprimirProveedores($array)
 {
     $tr="";
     foreach ($array as $value)
     {
              $tr.='<tr data-nombre="'.$value->NombreProveedor.'">';
              $tr.='<td>'.$value->NombreProveedor.'</td>';
              $tr.='<td>'.$value->Nombre_contacto.'</td>';
              $tr.='<td>'.$value->telefono_movil.'</td>';                            
              $tr.='<td>'.$value->email.'</td>';
              
              $tr.='</tr>';         
          
         
     }
     return $tr;
 }
 function imprimirEmpleados($array)
 {
     $tr="";
     
     foreach ($array as $value)
     {
         if($value['tipoPersona']=='Colaborador')
         {
         
         
          foreach($value['Data'] as $valueData)
          {
              $tr.='<tr data-nombre="'.$valueData['nombres'].' '.$valueData['apellidoPaterno'].' '.$valueData['apellidoMaterno'].'">';
              $tr.='<td>'.$valueData['nombres'].'</td>';
              $tr.='<td>'.$valueData['apellidoPaterno'].'</td>';
              $tr.='<td>'.$valueData['apellidoMaterno'].'</td>';              
              $tr.='<td>'.$valueData['celPersonal'].'</td>';
              $tr.='<td>'.$valueData['email'].'</td>';
              $tr.='<td>'.$value['Name'].'</td>';
              $tr.='</tr>';         
          }
         
         }
     }
     return $tr;
 }
 //-------------------------------------
 function imprimirVendedores($array)
 {
     $tr="";
     
     foreach ($array as $value)
     {
         if($value['tipoPersona']=='Vendedor')
         {
         
         
          foreach($value['Data'] as $valueData)
          {
              $tr.='<tr data-nombre="'.$valueData['nombres'].' '.$valueData['apellidoPaterno'].' '.$valueData['apellidoMaterno'].'">';
              $tr.='<td>'.$valueData['nombres'].'</td>';
              $tr.='<td>'.$valueData['apellidoPaterno'].'</td>';
              $tr.='<td>'.$valueData['apellidoMaterno'].'</td>';              
              $tr.='<td>'.$valueData['celPersonal'].'</td>';
              $tr.='<td>'.$valueData['email'].'</td>';
              $tr.='<td>'.$value['Name'].'</td>';
              $tr.='</tr>';         
          }
         
         }
     }
     return $tr;
 }
 ?>