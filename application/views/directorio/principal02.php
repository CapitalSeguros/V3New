<?php 
$mostrar_Vista = false;
if($mostrar_Vista){
   $this->load->view('headers/header'); 
} ?>
<?php 
	$mostrar_Vista = true;
	if ($mostrar_Vista) {
		
		$this->load->view('headers/menu');
	}
	
?>
<?php 
	$mostrar_Vista = true;
	if ($mostrar_Vista) {
		$this->load->view('generales/historialClientes');
	}
?>
<?php 
$mostrar_Vista = true;
if ($mostrar_Vista) {
	$this->load->view('generales/altaTelefonosCorreos');//AQUI ESTA LA LLAVE QUE SOBRA
}
?>
<?php 
$mostrar_Vista = true;
if ($mostrar_Vista) {
	$this->load->view('generales/docPersonalesClienteAgregar');
} ?>

<?php 
	//var_dump($datos_clientes_nuevos);
?>
<script src="https://cdn.jsdelivr.net/npm/vue@2.6.14"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<script src="https://cdn.jsdelivr.net/npm/vue@2/dist/vue.js"></script>
<script src="https://cdn.jsdelivr.net/npm/axios/dist/axios.min.js"></script>
<link rel="stylesheet" href="//code.jquery.com/ui/1.13.1/themes/base/jquery-ui.css">
<script src="https://code.jquery.com/ui/1.13.1/jquery-ui.js"></script>
<!--<script src="https://code.jquery.com/jquery-3.6.0.js"></script>-->
<!--<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">-->

<!--
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.2/css/bootstrap.min.css">
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.2/css/bootstrap-theme.min.css">
-->
<style>
	/* Fondo oscuro al mostrar la modal */
	.modal-personalizada {
		position: fixed;
		top: 0;
		left: 0;
		width: 100vw; /* Ancho completo de la ventana */
		height: 100vh; /* Alto completo de la ventana */
		background-color: rgba(0, 0, 0, 0.5);
		display: flex;
		justify-content: center;
		align-items: center;
		z-index: 1000;
	}

	/* Contenedor de la modal (pantalla completa) */
	.modal-contenedor {
		background: white;
		width: 90vw; /* Ocupa todo el ancho de la pantalla */
		height: 90vh; /* Ocupa todo el alto de la pantalla */
		box-shadow: 0px 5px 15px rgba(0, 0, 0, 0.3);
		display: flex;
		flex-direction: column;
		animation: aparecerModal 0.3s ease-in-out;
	}

	/* Animación de la modal */
	@keyframes aparecerModal {
		from {
			opacity: 0;
			transform: scale(0.9);
		}
		to {
			opacity: 1;
			transform: scale(1);
		}
	}

	/* Encabezado */
	.modal-encabezado {
		display: flex;
		justify-content: space-between;
		align-items: center;
		padding: 15px;
		background: #f1f1f1;
		border-bottom: 1px solid #ccc;
	}

	/* Título */
	.modal-titulo {
		font-size: 20px;
		font-weight: bold;
	}

	/* Botón de cerrar */
	
	.cerrar-boton {
		background: none;
		border: none;
		font-size: 50px; /* Tamaño del icono */
		cursor: pointer;
		color: #555;
		
		/* Expande el área de clic */
		width: 100px; 
		height: 100px;
		padding: 10px;
		
		/* Hace que el botón sea redondo */
		border-radius: 50%;
		display: flex;
		align-items: center;
		justify-content: center;
		
		/* Efecto al pasar el mouse */
		transition: background 0.3s ease;
	}

.cerrar-boton:hover {
    background: rgba(0, 0, 0, 0.1);
}


	/* Cuerpo de la modal (se adapta al tamaño) */
	.modal-cuerpo {
		flex: 1; /* Hace que el contenido se expanda */
		padding: 20px;
		overflow-y: auto; /* Permite desplazamiento si el contenido es grande */
	}
	.modal-body {
    height: 100%;/**esablece la altura al momento */
    min-width: 100%;
    max-height: 75vh; /* Establece la altura máxima de la ventana modal al 70% de la altura de la ventana del navegador */
    max-width: 100vh; /* Establece el ancho máximo de la ventana modal al 80% de la altura de la ventana del navegador */
    overflow-y: auto; /* Activa el desplazamiento vertical cuando el contenido excede la altura máxima definida */
    padding: 26px;/* Elimina el relleno (padding) dentro del cuerpo de la ventana modal */
    display: flex;
    
    flex-direction: column;
	}

</style>

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



					<!--INICIA TABLA DE DATOS
					<div id="divClientes" class="divContenedor verObjeto">-->

                    <!-- <div class="col-lg-12 mb-4" >
							<form  id="myForm" method="POST" action="<?=base_url()?>directorio" >                	
								<div class="col-md-1">
									<label for="FechaInicio">Buscar Clientes</label>
								</div>
								<div class="col-md-2">
									<select class="form-control" name="tipoPersona">
										<option value='-1'></option>
										<option value='1'>MORAL</option>
										<option value='0'>FISICA</option>
									</select>
								</div>
								<div class="input-group col-md-4" style="z-index:1" >
									<input type="text" class="form-control" id="BusquedaCliente" name="busquedaDirectorio" value="<?php if(isset($busquedaDirectorio) ){ echo $busquedaDirectorio; } ?>" placeholder="Buscar">
									<span class="input-group-btn">
										<button class="btn btn-primary search-trigger" ><i class="fa fa-search"></i>&nbsp;</button>
									</span>                        
									<input type="hidden" value="<?php if(isset($busquedaDirectorio) ){ echo $busquedaDirectorio; } ?>" class="name_search"/>
									<input type="hidden"  name="page" class="name_page" value="<?php if(isset($page) ){ echo $page; } ?>"/>
								</div>
						
							</form>
							

						</div> -->
						<!--------------------------------------------------comienza instancia VUE RESOURCE-------------------------------------------------->
						<div id="clienteBusquedaVUE"><!--ING.Roberto Alvarez 04-marzo-2025-->
							<div class="col-lg-12 mb-4">
								<div id="myForm" method="POST" action="<?=base_url()?>directorio">
									<div class="col-md-1">
										<label for="FechaInicio">Buscar Clientes</label>
									</div>
									<div class="col-md-2"> 
										<select class="form-control" name="tipoPersona" v-model="tipoSeleccionado"><!--V-MODEL-SE INICIALLIZA-EN-DATA-->
											<option value="-1">Todos</option>
											<option value="1">MORAL</option>
											<option value="0">FÍSICA</option>
										</select>
									</div>

									<div class="input-group col-md-4" style="z-index:1">
										<input type="text" class="form-control" id="BusquedaCliente" v-model="buscarVUE" name="busquedaDirectorio" 
											placeholder="Buscar"
											@keydown.enter="realizarBusqueda($event)">  <!-- Detectar Enter @keyup.enter="realizarBusqueda" -->
										
										<span class="input-group-btn">
											<button class="btn btn-primary search-trigger" @click="realizarBusqueda($event)">
												<i class="fa fa-search"></i>&nbsp;
											</button>
										</span>                        
									</div>
								</div>
							</div>
							
							<div class="col-md-12" style="margin-top: 15px" v-if="componenteTabla1Directorio">
								<div class="panel panel-default">
									<div class="panel-heading text-center">
									<div class="col-md-4"> 
										<select class="form-control" name="tipoPersona" aria-placeholder="SELECCIONE UN NOMBRE" v-model="idClienteSeleccionadoVUE">
											<option value="" disabled>SELECCIONE UN NOMBRE</option>
											<option v-for="cliente in arraySelectVue" :value="cliente.IDCli">
												{{ cliente.NombreCompleto }}
											</option>
										</select>
									</div>

										<h5 v-if="titulo1Vue">Resultado de búsqueda</h5>
									</div>
									<div class="panel-body">
										<div class="row">
											<template v-if="clientesEncontrados.length">
												<div class="col-xs-12 col-sm-6 col-md-4" 
													v-for="cliente in clientesEncontrados" 
													:key="cliente.IDCli"
													v-if="cliente.IDCli">
													<div class="thumbnail">
														<label>CLIENTE: {{ cliente.IDCli }}</label>
														<div class="jumbotron">
															<h5 class="text-center"><strong>{{ cliente.NombreCompleto }}</strong></h5>
														</div>
														<label>Información básica del cliente</label>
														<div class="caption table-responsive">
															<table class="table table-condensed">
																<tbody>
																	<tr>
																		<td>Persona:</td>
																		<td>{{ cliente.TipoEnt_TXT }}</td>
																	</tr>
																	<tr>
																		<td>RFC:</td>
																		<td>{{ cliente.RFC || 'N/A' }}</td>
																	</tr>
																	<tr>
																		<td>Ranking:</td>
																		<td>{{ cliente.ranking || 'N/A' }}</td>
																	</tr>
																	<tr>
																		<td>Agente Sicas:</td>
																		<td>{{ cliente.FieldInt1 || 'N/A' }}</td>
																	</tr>
																	<tr>
																		<td>Siniestros Activos:</td>
																		<td>{{ cliente.SiniestrosActivos || 0 }}</td>
																	</tr>
																	<tr>
																			<td colspan="2">
																				<div class="dropdown" style="z-index: 2; position: absolute">
																					<!-- <a id="opcionesClient" href="javascript:void(0)" data-toggle="dropdown" aria-expanded="false" aria-haspopup="true">
																						Ver opciones <span class="caret"></span>
																					</a> -->
																					<!-- <a id="opcionesClient" href="javascript:void(0)" data-toggle="dropdown" aria-expanded="false" aria-haspopup="true" @click="toggleDropdown($event)">
																						Ver opciones <span class="caret"></span>
																					</a> -->
																					<!-- <a id="opcionesClient" href="javascript:void(0)" data-toggle="dropdown" aria-expanded="false" aria-haspopup="true" @click="toggleDropdown($event)">
																						Ver opciones <span class="caret"></span>
																					</a> -->

																					<a id="opcionesClient" href="javascript:void(0)" aria-expanded="false" aria-haspopup="true" @click="toggleDropdown($event)">
																						Ver opciones <span class="caret"></span>
																					</a>
																					<ul class="dropdown-menu" aria-labelledby="opcionesClient" role="menu">
																						<li role="presentation">
																							<a role="menuitem" tabindex="-1" href="javascript:void(0)" @click="abrirModal(cliente.IDCli, '<?=base_url()?>directorio/GetPolizaBeta?IDCli=', $event)">
																								<i class="fa fa-eye" aria-hidden="true"></i>&nbsp;Ver Polizas
																							</a>
																						</li>
																						<li role="presentation">
																							<a role="menuitem" tabindex="-1" href="javascript:void(0)" @click="abrirModal(cliente.IDCli, '<?=base_url()?>directorio/registroDetalleBeta?IDCli=', $event)">
																								<i class="fa fa-eye" aria-hidden="true"></i>&nbsp;Ver Datos
																							</a>
																						</li>
																						<li role="presentation">
																							<a role="menuitem" tabindex="-1" href="javascript:void(0)" @click="abrirModal(cliente.IDCli, '<?=base_url()?>directorio/GetFianzaBeta?IDCli=', $event)">
																								<i class="fa fa-eye" aria-hidden="true"></i>&nbsp;Ver Fianzas
																							</a>
																						</li>
																						<li role="presentation">
																							<a role="menuitem" tabindex="-1" class="client-data" href="javascript: void(0)" @click="preferenciaDeContactoVue(cliente.IDCli)" >
																								<i class="fa fa-users" aria-hidden="true" ></i>&nbsp;Preferencia de contacto  
																							</a>
																						</li>
																					
																						<!-- <li role="presentation">
																							<a role="menuitem" class="client-data" tabindex="-1" id-cliente="cliente.IDCli" href="javascript: void(0)" :id-cliente="cliente.IDCli"
																							@click="preferenciaDeContactoVue(cliente.IDCli)"><!--onclick="consultaContactoDelCliente(cliente.IDCli)""--
																								<i class="fa fa-users" aria-hidden="true"></i>&nbsp;Preferencia de contacto<!--NO FUNCIONA POR ALGUNA RAZON --
																							</a>
																						</li>  -->
																						<!-- <li role="presentation">
																							<a role="menuitem" class="client-data" tabindex="-1" href="javascript: void(0)" 
																								
																								@click="preferenciaDeContactoVue(cliente.IDCli)">!--:id_cliente="cliente.IDCli"--
																								<i class="fa fa-users" aria-hidden="true"></i>&nbsp;Preferencia de contacto
																							</a>
																						</li> -->

																						<!-- <li role="presentation">
																							<a role="menuitem" class="client-data" tabindex="-1" href="javascript: void(0)" :data-id-cliente="cliente.IDCli"
																							@click="consultaContactoDelCliente(cliente.IDCli)">
																								<i class="fa fa-users" aria-hidden="true"></i>&nbsp;Preferencia de contacto
																							</a>
																						</li> -->
																						

																						<li role="presentation">
																							<a role="menuitem" tabindex="-1" href="javascript:void(0)" @click="abrirNuevaPestaña(cliente.IDCli, '<?=base_url()?>directorio/llamarCotizacion?IDCli=')">
																								�� Cotizar
																							</a>
																						</li>
																						<li role="presentation">
																							<a role="menuitem" tabindex="-1" href="javascript:void(0)" @click="abrirNuevaPestaña(cliente.IDCli, '<?=base_url()?>directorio/llamarFianzas?IDCli=')">
																								�� Fianzas
																							</a>
																						</li>
																						<!-- <li role="presentation">
																							<a role="menuitem" class="client-notes" tabindex="-1" href="javascript:void(0)" :id_cliente="cliente.IDCli" :cliente_nombre="cliente.NombreCompleto">
																								<i class="fa fa-sticky-note-o" aria-hidden="true"></i>&nbsp;Notas asignadas<!--POR ALGUNA RAZON NO FUNCIONA--
																							</a>
																						</li> -->
																						<li role="presentation">
																							<a role="menuitem" class="client-notes" tabindex="-1" :id-click="1"href="javascript:void(0)" @click="notasAsignadasVue(cliente.IDCli, $event)"
																							 :id_cliente="cliente.IDCli" :cliente_nombre="cliente.NombreCompleto">
																								<i class="fa fa-sticky-note-o" aria-hidden="true"></i>&nbsp;Notas asignadas
																							</a>
																						</li>
																						<li role="presentation">
																							<a role="menuitem" tabindex="-1" href="javascript:void(0)" @click="traerHistorialClientesVue(cliente.IDCli)">
																								<i class="fa fa-eye" aria-hidden="true"></i>&nbsp;Bitácora
																							</a>
																						</li>
																						<li role="presentation">
																							<a role="menuitem" tabindex="-1" href="javascript:void(0)" @click="asignarValParaDatosClientesVue(cliente.IDCli); traerTelEmailAltaTCGenerales()">
																								<i class="fa fa-eye" aria-hidden="true"></i>&nbsp;Agregar Datos
																							</a>
																						</li>
																						<li role="presentation">
																						<button class="fa fa-eye buttonOpciones" @click="traerDigitalDPCAGeneralesVue(cliente.IDCli)">
																							&nbsp; Agregar Documentos
																						</button>
																						</li>
																						<li role="presentation">
																							<a role="menuitem" tabindex="-1" href="javascript:void(0)" @click="abrirModal(cliente.IDCli, '<?=base_url()?>crmproyecto/deteccionNecesidadesCliente?IDCli=', $event)">
																								Detección de Necesidades
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
											</template>
											<h3 v-else class="text-center">No hay datos por el momento</h3>
										</div>
									</div>
								</div>
							</div>

							
							<!-- Modal -->
							<div v-if="isModalVisible" class="modal-personalizada">
								<div class="modal-contenedor">
									<div class="modal-encabezado">
										<h5 class="modal-titulo">Opciones del Cliente</h5>
										<button class="cerrar-boton" @click="cerrarModal" aria-label="Close"   ><span aria-hidden="true">&times;</span></button>
										
									</div>
									<div class="modal-cuerpo">
										<!-- Contenido dentro de la modal -->
										 <iframe id="miIframe" :src="iframeSrc" width="100%" height="100%" frameborder="0"></iframe>
										 

										 <!-- <iframe id="iframeOpciones" src="<?=base_url()?>crmproyecto/deteccionNecesidadesCliente?IDCli=2197" width="100%" height="100%" frameborder="0"></iframe> -->
									</div>
								</div>
							</div>




							
						</div><!--termina instancia VUE RESOURCE--><!--ING.Roberto Alvarez 04-marzo-2025-->
						<!--------------------------------------------------termina instancia VUE RESOURCE-------------------------------------------------->
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
<div class="modal fade in" id="modal_info_contacto" tabindex="-1" role="dialog" aria-labelledby="modal_info_contactoLabel" aria-hidden="true">
	<div class="modal-dialog" role="document">
		<div class="modal-content">
			<div class="modal-header">
				<!--<h5 class="modal-title" id="modal_info_contactoLabel">Modal title</h5>-->
				<h4 class="modal-title cliente_m_h"></h4>
				<button type="button" class="close" data-dismiss="modal" onclick="cerrarModalInfoContacto()" aria-label="Close">
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
										<a class="list-group-item list-group-item-action" data-toggle="list" href="#g_<?=$id?>" role="tab" onclick="document.getElementById('g_<?=$id?>').classList.toggle('active')"><?=$d_g["nombre"]?></a>
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
				<button type="button" class="btn btn-default" data-dismiss="modal" onclick="cerrarModalInfoContacto()">Cerrar</button>
				<!-- <button type="button" class="btn btn-info" style="display: none" id="up_contactos">Actualizar</button> -->
				 <!-- <div id="clienteBusquedaVUE"><!--INICIA INSTANCIA DE VUE--
					<button type="button" class="btn btn-info" id="up_contactos"  style="dispdone"
					onclick="actualizarContacto(event)" @click="actualizarModalVue()">Actualizar</button>

				 </div>FINALIZA INSTANCIA VUE -->
				 <div id="clienteBusquedaVUE">
					<button type="button" class="btn btn-info" id="up_contactos" style="display: none"
					onclick="actualizarContacto(event)">Actualizar</button>
				</div>


				
			</div>
		</div>
	</div>
</div>
<!--</div>-->
<input type="hidden" value="<?=$this->tank_auth->get_userprofile()?>" id="tipoPersona">
<input type="hidden" data-url="<?=base_url()?>" class="base_url">
<script src="<?=base_url()."assets/js/js_directorioClientes.js"?>"></script> <!--Dennis [2021-03-08] -->
<script src="<?=base_url()."assets/js/jquery.clientesNuevos.js"?>"></script> <!--Dennis [2021-07-29] -->
<script src="<?=base_url()."assets/js/jquery.birthdays.js"?>"></script> <!--Dennis [2021-07-29] -->
<!-- Aquí va el div con la URL base -->
<div id="base_url" data-base-url="<?= base_url(); ?>"></div><!--SE TOMA LA UBICACIÓN DE RAIZ V3 SIRVE PARA LA INSTANCIA DE VUE-->
<!------>
<script>
   // Vue.js
// Vue.js
var baseUrlElement = document.getElementById("base_url");
if (baseUrlElement) {
    var ruta = baseUrlElement.getAttribute('data-base-url');
    var apiVacaciones = ruta + 'fastFile/obtenerPersonasEnVacaciones';
    var apiCliente = ruta + 'fastFile/obtenerCliente'; // URL de la API de clientente
} else {
    console.error('El div "base_url" no se encuentra en el DOM.');
}

new Vue({
    el: "#clienteBusquedaVUE",  // Asocia Vue al div con id="clienteBusquedaVUE"
    data: {
        tipoDePersona: '',  // Variable para el tipo de persona (MORAL/FISICA)
        terminoBusqueda: '',  // Variable para el término de búsqueda
        clientesEncontradosSinFiltrar: [],  // Array para almacenar los resultados de los clientes sinFiltrar
		clientesEncontrados: [], //Array para almacenar los resultados ya filtrados
        apiCliente: apiCliente,  // Asignamos la URL de apiCliente a una propiedad del componente
     	page: 1,//
		isModalVisible: false,  // Controla si el modal se muestra o no
		componenteTabla1Directorio: false,
		titulo1Vue: false,//
		buscarVUE:null,//
		tipoSeleccionado: "-1",    // Estado del select (valor por defecto)
		selectVue1:true,//
		idClienteSeleccionadoVUE: '',
		arraySelectVue:[],//
		iframeSrc:'<?=base_url()?>crmproyecto/deteccionNecesidadesCliente?IDCli=2197',//
		idGlobalVue: null,//
		
    },
    created: function() {
        // Realiza la búsqueda inicial al crear la instancia de Vue
        // this.realizarBusqueda();
		// this.$nextTick(() => {
        // let script = document.createElement("script");
        // script.src = "<!--<=//base_url().'assets/js/js_directorioClientes.js'?>-->"; 
        // script.async = true;
        // document.body.appendChild(script);
    	// });
    },
	mounted() {
		// this.realizarBusqueda();
		
	},
	watch: {
		
		tipoSeleccionado(nuevoValor) {//ve en tiempo real el v-model tipoSeleccionado
			// event.preventDefault(); // Evita que el Enter recargue la página o cierre la alerta
			Swal.fire({
			title: "Cargando datos...",
			text: "Por favor, espera unos segundos",
			allowOutsideClick: false,
			allowEscapeKey: false,
			didOpen: () => {
				Swal.showLoading();
			}
			});
			this.filtrarClientes(nuevoValor);
		},
		idClienteSeleccionadoVUE(nuevoValor){
			this.filtrarClientes(nuevoValor);
		},
	},
    methods: {

		toggleDropdown(event) {//abre el menu desplegable de los cards
			let dropdownMenu = event.target.nextElementSibling; // Obtiene el menú desplegable

			if (dropdownMenu.classList.contains("show")) {
				dropdownMenu.classList.remove("show"); // Oculta el menú quitando la clase "show"
				document.removeEventListener("click", this.closeDropdownOnClickOutside); // Remueve el listener
			} else {
				dropdownMenu.classList.add("show"); // Muestra el menú agregando la clase "show"
				// Espera un breve momento antes de agregar el listener para evitar que el primer clic lo cierre de inmediato
				setTimeout(() => {
					document.addEventListener("click", this.closeDropdownOnClickOutside);
				}, 100);
			}
		},

		closeDropdownOnClickOutside(event) {//cierra todos los menus desplegables que esten abiertos
			let dropdowns = document.querySelectorAll(".dropdown-menu.show"); // Selecciona todos los dropdowns abiertos que tengan show
			dropdowns.forEach(dropdown => {
				if (!dropdown.parentElement.contains(event.target)) {
					dropdown.classList.remove("show"); // Cierra el dropdown si el clic fue fuera de él
					document.removeEventListener("click", this.closeDropdownOnClickOutside); // Remueve el listener
				}
			});
		},


		abrirNuevaPestaña(IDCli, urlBase, ) {
			// Verifica que IDCli y urlBase sean válidos
			if (!IDCli || !urlBase) {
				console.error("IDCli o urlBase no son válidos");
				return;
			}

			// Construye la URL completa con el ID del cliente
			let urlCompleta = `${urlBase}${IDCli}`;

			// Abre la nueva pestaña con la URL generada
			window.open(urlCompleta, "_blank");
		},

		abrirModal(IDCli, urlBase, event) {
			this.alertaDatosSeCargan(event); // Muestra una alerta de carga con SweetAlert mientras se carga la información
			this.iframeSrc = urlBase + IDCli; // Construye la URL del iframe concatenando la base con el ID del cliente
			this.isModalVisible = true; // Hace visible el modal donde se mostrará el iframe
			// Usa $nextTick para asegurarse de que Vue ha actualizado el DOM antes de ejecutar el siguiente código
			this.$nextTick(() => {//this.$nextTick() es un método de Vue que ejecuta una función después de que se haya actualizado el DOM.
								  // // Es útil cuando necesitas hacer algo que depende de los cambios en la interfaz de usuario.
				let iframe = document.getElementById("miIframe"); // Obtiene el elemento <iframe> del DOM por su ID
				if (iframe) { // Verifica que el iframe realmente existe en el DOM antes de continuar
					iframe.onload = () => { // Define un evento que se ejecutará cuando el iframe termine de cargar
						Swal.close(); // Cierra la alerta de carga una vez que el iframe ha terminado de cargarse
					};
				}
			});
		},


		cerrarModal() {
			this.isModalVisible = false;
			this.iframeSrc = "";
		},
		
        // Método para realizar la búsqueda de clientes
        realizarBusqueda: function(event) {
			// console.log('VUE FUNCIONA CORRECTAMENTE'); 
			this.clientesEncontrados = [];
			// console.log(this.buscarVUE);

			// Mostrar alerta de carga
			
			
			// Realizar la solicitud con axios
			// console.log(this.apiCliente);
			
			
				this.alertaDatosSeCargan(event);
				
			axios.get(this.apiCliente + '/' + this.buscarVUE).then(response => {//petición al servidor 
					
					this.clientesEncontradosSinFiltrar = response.data.cliente;
					this.clientesEncontrados = this.clientesEncontradosSinFiltrar;//se almacena aqui para mostrarlos en vista
					// console.log(this.clientesEncontradosSinFiltrar);
					console.log("Los datos fueron extraídos con éxito");
					this.componenteTabla1Directorio = true;
					this.titulo1Vue = true;
					Swal.close();
					// Cerrar la alerta cuando la solicitud se complete con éxito
					// Swal.close();
					// Aplicar el filtro después de cargar los datos
					this.filtrarClientes(this.tipoSeleccionado);
				})
				.catch(error => {
					console.log(error);
					console.log("Error al extraer datos");
					this.clientesEncontrados = [];

					// Cerrar la alerta y mostrar mensaje de error
					Swal.fire({
						title: "Error",
						text: "No se pudieron obtener los datos",
						icon: "error"
					});
				});
		},
	filtrarClientes(tipo) {
    	// Mostrar alerta antes de iniciar el filtrado
		const tipoNumero = Number(tipo); // Convertir a número por si viene como string
		this.clientesEncontrados=[];
			
		switch (tipo) {
			case '-1': // Opción para mostrar todos los clientes sin aplicar filtros.
				
				this.clientesEncontrados = this.clientesEncontradosSinFiltrar;// Se asignan todos los clientes disponibles sin filtrar.
				this.arraySelectVue = this.clientesEncontradosSinFiltrar;// se llena los valores del select de todos los clientes sin filtrar
				setTimeout(() => {// Se cierra la alerta de carga después de 0.010 segundo.
					Swal.close();
				}, 1000);
				break;

			case '1': // Opción para filtrar solo los clientes de tipo MORAL (empresas).
				// Se filtran los clientes cuyo 'TipoEnt' es igual a '1' (empresas).
				this.clientesEncontrados = this.clientesEncontradosSinFiltrar.filter(cliente => cliente.TipoEnt === tipo);
				// Se asignan los mismos clientes filtrados al array 'arraySelectVue'.
				this.arraySelectVue = this.clientesEncontradosSinFiltrar.filter(cliente => cliente.TipoEnt === tipo);
				// Se imprime en consola la lista de clientes filtrados.
				// console.log(this.clientesEncontrados);
				console.log('se filtro correctamente las personas morales'); // Línea vacía en la consola para mejorar la legibilidad.
				// Se cierra la alerta de carga después de 1 segundo.
				setTimeout(() => {
					Swal.close();
				}, 1000);
				break;

			case '0': // Opción para filtrar solo los clientes de tipo FÍSICO (personas).
				// Se filtran los clientes cuyo 'TipoEnt' es igual a '0' (personas físicas).
				this.clientesEncontrados = this.clientesEncontradosSinFiltrar.filter(cliente => cliente.TipoEnt === tipo);

				// Se asignan los mismos clientes filtrados al array 'arraySelectVue'.
				this.arraySelectVue = this.clientesEncontradosSinFiltrar.filter(cliente => cliente.TipoEnt === tipo);

				// Se imprime en consola la lista de clientes filtrados.
				// console.log(this.clientesEncontrados);
				console.log('Se filtro correctamente las personas fisicas'); // Línea vacía en la consola para mejorar la legibilidad.

				// Se cierra la alerta de carga después de 0.010 segundo.
				setTimeout(() => {
					Swal.close();
				}, 1000);
				break;

			default: // Opción para filtrar clientes específicos por su ID.
				// Se filtra el cliente cuyo 'IDCli' coincida con el valor seleccionado.
				this.clientesEncontrados = this.clientesEncontradosSinFiltrar.filter(cliente => cliente.IDCli == tipo);
				break;
		}
	},

	//FUNC
    traerDigitalDPCAGeneralesVue(idCliente) {
    //   console.log(`Agregar documentos para cliente ${idCliente}`);
	  traerDigitalDPCAGenerales('',idCliente);
    },
	asignarValParaDatosClientesVue(IDCli){
	if (typeof idClienteTelEmailGeneralGloblal != 'undefined') { idClienteTelEmailGeneralGloblal = IDCli }
	// console.log('se accedio a esta funcion en vue');
	traerTelEmailAltaTCGenerales();
	},
	traerHistorialClientesVue(IDCli){
		traerHistorialClientes('',IDCli);

	},
	preferenciaDeContactoVue(IDCli){
		// console.log('consultaContactoDelClienteAlv');
		this.idGlobalVue = IDCli;//se inicializa idGlobal para que se pueda usar en otras funciones 
		consultaContactoDelClienteAlv(IDCli);
		document.getElementById("modal_info_contacto").classList.add("show");
	},
	// preferenciaDeContactoVue(id, event) {
	// 	this.idGlobalVue = id;//se inicializa idGlobal para que se pueda usar en otras funciones 
    // 	// const ElementHTML = event.target;

	
    // 	consultaContactoDelClienteAlv(id);//
	// 	document.getElementById("modal_info_contacto").classList.add("show");
  	// },
	  
	notasAsignadasVue(id, event){
		const ElementHTML = event.target; // Obtiene el elemento que disparó el evento

		//  console.log(ElementHTML);
		 consultarNotasDelClienteAlv(ElementHTML);
		 muestra_parte_notas(ElementHTML);
		 document.getElementById("modal_info_contacto").classList.add("show");
		// // consultaContactoDelCliente();modal-title cliente_m_h
		// $('#modal_info_contacto').modal('show');

	},
	actualizarModalVue(){
		console.log('Hola Mundo');
		actualizarContacto(event); 
	},
	alertaDatosSeCargan(event){
		event.preventDefault(); // Evita que el Enter recargue la página o cierre la alerta
		Swal.fire({
				title: "Cargando datos...",
				text: "Por favor, espera unos segundos",
				allowOutsideClick: false,
				allowEscapeKey: false,
				didOpen: () => {
					Swal.showLoading();
				}
			});
	},
	

	
    }
});





</script>


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
    $('#myForm').submit(function(e) {
        e.preventDefault();
    })
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
// $(document).ready(function() {
//     // Prevenir el envío del formulario de manera tradicional
//     $('#myForm').submit(function(e) {
//         e.preventDefault(); // Prevenir el envío tradicional del formulario
//     });

//     // Función para manejar el click en el botón de búsqueda (botón con clase 'search-trigger')
//     $(".search-trigger").click(function(e) {
//         e.preventDefault(); // Prevenir la acción predeterminada del click

//         var $data_page = $(".name_page").val(); // Obtener el valor de la página
//         var $data_search = $(".name_search").val(); // Obtener el valor de búsqueda
//         var $tipo_persona = $("select[name='tipoPersona']").val(); // Obtener el tipo de persona (FISICA o MORAL)

//         // Actualizar los campos ocultos antes de enviar los datos
//         $("input[name=page]").val($data_page);
//         $("input[name=busquedaDirectorio]").val($data_search);
//         $("input[name=tipoPersona]").val($tipo_persona); // Establecer el tipo de persona (FISICA o MORAL)


//     });

//     // Detectar el cambio en el select de 'tipoPersona' (FISICA o MORAL)
//     // $("select[name='tipoPersona']").change(function() {
//     //     var tipoPersona = $(this).val(); // Obtener el tipo de persona seleccionado (1 o 0)
//     //     console.log("Tipo de Persona seleccionado: " + tipoPersona);
//     // });
// });




	
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
console.log('se accedio a esta funcion desde un scriptgobal');
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