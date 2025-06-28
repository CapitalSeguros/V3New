<?php
############# Semaforo Actividades #############
$colorRef[0] = "5";
$colorRef[1] = "8";
$colorRef[2] = "11";
$colorRef[3] = "14";
$colorRef[4] = "17";
$colorRef[5] = "20";
$colorRef[6] = "23";
$colorRef[7] = "26";
$colorRef[8] = "29";
$colorRef[9] = "32";
$colorRef[10] = "";
$colorRef[11] = "";
$colorRef[12] = "";
$colorRef[13] = "";
$colorRef[14] = "";

$graficaRef		= base_url() . 'assets/plugins/GraPHPico_0-0-3/graphref.php?ref=';
$graficaBarras	= base_url() . 'assets/plugins/GraPHPico_0-0-3/graphbarras.php?dat=';
$graficaPastel	= base_url() . 'assets/plugins/GraPHPico_0-0-3/graphpastel.php?dat=';
$graficaPorcen	= base_url() . 'assets/plugins/GraPHPico_0-0-3/graphporcentaje.php?fil=';
############# Semaforo Actividades #############

//$inicioEmplreado			= strtotime($miInfo_Datos->fecAltaSistemPersona); //fechaAltaPersona
//$hoy 						= strtotime(date("Y-m-d"));
//$tipoRestanteProvisional	= intval(($hoy - $inicioEmplreado) / (24 * 60 * 60)); // /(365.25 * 24 * 60 * 60 * 1000);

//[Dennis]
//$tiempoAnioActivo=intval($tipoRestanteProvisional/(365.25)); //cantidad de años
$dia_ac=date("Y-m-d"); //strtotime(date("Y-m-d"));
//$_almacena_meses=array();

$__ff1= new DateTime($miInfo_Datos->fecAltaSistemPersona); //FechaIniEmpl
$__ff2= new DateTime($dia_ac);

$df=$__ff1->diff($__ff2);

$contador_meses_dias=0;
$contador_semanas_dias=0;
$contador_resto_dias=0;
$contador_diferencia_dias=0;

$contador_meses_dias=intval($df->m);
//$contador_semanas_dias=intval($df->d / 7);
//$contador_resto_dias=($df->d >= 7) ? intval($df->d % ($contador_semanas_dias*7)): $df->d;

$moduloConfiguraciones = "";
foreach ($configModulos as $modulos) {
	if ($modulos['modulo'] == "configuraciones") {
		$moduloConfiguraciones .= TRUE;
	} else {
		$moduloConfiguraciones .= FALSE;
	}
}

function formatMoney($num)
{
	echo '$ ' . $num;
}

$this->load->view('headers/header');
echo link_tag('assets/gap/css/cap.css');
//$path_foto = "assets/img/miInfo/userPhotos/";
$foto = "";
$foto = $fotoPersonal;
//Miguel *********** 20/10/2020
    /*$this->load->model("menu_model");
    $imagenPersona  = $this->menu_model->buscaFotoPersonal($this->tank_auth->get_idPersona());
	//var_dump($imagenPersona);
	if(!empty($imagenPersona)){
		if($imagenPersona=="noPhoto.png"){
			$foto = $path_foto . "noPhoto.png";
		}else{
			$foto = $path_foto . $imagenPersona;
		}
	} else{
		$foto=$path_foto."noPhoto.png";
	}*/
    /*if(count($imagenPersona)>0){$foto="archivosPersona/".$imagenPersona[0]->idPersona."/miFoto/".$imagenPersona[0]->idPersonaImagen.$imagenPersona[0]->extensionPersonaImagen;
       }else{  $foto = $path_foto . "noPhoto.png";}*/
//************************
?>
<!-- Navbar -->
<?php
$this->load->view('headers/menu');
?>

<link rel="preconnect" href="https://fonts.googleapis.com">
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
<link href="https://fonts.googleapis.com/css2?family=Cabin&display=swap" rel="stylesheet">
<link href="https://fonts.googleapis.com/css2?family=Be+Vietnam+Pro:wght@200&display=swap" rel="stylesheet">
<link href="https://fonts.googleapis.com/css2?family=Bebas+Neue&display=swap" rel="stylesheet">
<link rel="stylesheet" href="//code.jquery.com/ui/1.13.1/themes/base/jquery-ui.css">
<link rel="stylesheet" href="/resources/demos/style.css">
<script src="https://code.jquery.com/ui/1.13.1/jquery-ui.js"></script>
<style>

#modalPrestamos,#modalVacaciones,#mdDetail,#modalIncidecias,#modal-form-bono,#modal-seguimiento{
    position: fixed;
    top: 0;
    left: 0;
    width: 100%;
    height: 100%;
    z-index: 1050;	
}



.sub-category{
	font-family: 'Cabin', sans-serif;
}
.inf-training{
	font-family: 'Be Vietnam Pro', sans-serif;
}
.ramos-labels{
	font-family: 'Bebas Neue', cursive;
	font-size: 15px;
	border-radius: 2px; 
	padding: 3px 3px 3px 3px; 
	margin-right: 3px; 
	margin-bottom: 3px; color: white; 
}
/*--- Dennis Castillo [2022-06-28] ---*/
.disabled-interval span {
	background-color: #C0392B !important;
	color: white !important;
}
.period-change-date a {
	background-color: #28B463 !important;
	color: white !important;
}
.after-request-date span {
	background-color: #DC7633 !important;
	color: white !important;
}
.vacation-date span {
	background-color: #2E86C1 !important;
	color: white !important;
}
/*----------------*/
</style>
<!--:::::::::: INICIO CONTENIDO ::::::::::-->
<section class="container-fluid breadcrumb-formularios">
	<div class="row">
		<div class="col-md-6 col-sm-5 col-xs-5">
			<h3 class="titulo-secciones">Mi Info</h3>
		</div>
		<div class="col-md-6 col-sm-7 col-xs-7">
			<ol class="breadcrumb text-right">
				<li><a href="./">Inicio</a></li>
				<li class="active">Mi Info</li>
			</ol>
		</div>
	</div>
	<hr />
</section>
<section class="container-fluid">
	<div class="row">
		<div class="col-md-3">
			<div class="panel panel-default">
				<div class="panel-heading">
					<i class="fa fa-bank fa-lg"></i> Banco
				</div>
				<div class="panel-body">
					<p><b>Nombre:</b> <? 
						$b=$this->personamodelo->obtenerNombreBanco($miInfo_Datos->idBanco);
						if(empty($b)){
							$b="N/A";
						}
						echo $b; //$miInfo_Datos->banco?></p>
					<p><b>Clabe:</b> <? echo $miInfo_Datos->claveBancoPersona;?></p>
					<p><b>Cuenta:</b> <? echo $miInfo_Datos->cuentaBancoPersona; ?></p>
					<p><b>Tipo cuenta:</b> <? echo $miInfo_Datos->tipoCuentaBancoPersona; ?></p>
				</div>
			</div>
			<div class="panel panel-default">
				<div class="panel-heading">
					<i class="fa fa-heartbeat fa-lg"></i> En caso de accidente
				</div>
				<div class="panel-body">
					<p><b>Avisar a:</b> <? echo $miInfo_Datos->accidtePersonaAvisa; ?></p>
					<p><b>Recomendado por:</b> <? echo $miInfo_Datos->recomendarPersona; ?></p>
					<p><b>Teléfono accidente:</b> <? echo $miInfo_Datos->telPersonaAvisa; ?></p>
					<p><b>IMSS:</b> <? echo $miInfo_Datos->imssPersona; ?></p>
					<p><b>Referencias:</b> <? echo $miInfo_Datos->referenciaPersona; ?></p>
					<p><b>Tiene hijos:</b> <? echo $miInfo_Datos->hijosPersona; ?></p>
				</div>
			</div>
			<?php if(!empty($metas_comerciales)) {?>
			<div class="panel panel-default">
				<div class="panel-heading">
					<i class="fa fa-flag" aria-hidden="true"></i> Metas comerciales
				</div>
				<div class="panel panel-body">
				<!--------------------------------------------------------------------------------------------------------->
					<div class="table-responsive">
						<!--<table class="table" id="tableMetaAnual"></table>-->
						
						<div role="tabpanel">
							<ul class="nav nav-tabs" role="tablist">
								<?php foreach($metas_comerciales as $tipo => $datos){?>

									<li role="presentation" class="<?=$tipo == "venta_nueva" ? "active" : ""?>"><a href="#<?=$tipo?>" class="metas_comerciales" data-table="<?=$tipo?>" role="tab" data-toggle="tab"><?=strtoupper(str_replace("_"," ",$tipo))?></a></li>
								<?php }?>		
							</ul>
							
							<div class="tab-content">
								<?php foreach($metas_comerciales as $tipo => $datos){
									
									$total_meta = 0;
									$total_comision = 0;
									
									$sub_total_comision = 0;
									$sub_total_meta = 0;

									$porcentaje_sub = 0;
									$porcentaje_total = 0;
									?>

									<div role="tabpanel" class="tab-pane table-responsive <?=$tipo == "venta_nueva" ? "active" : ""?>" id="<?=$tipo?>">
										<p><b>Meta Mensual</b> <? echo formatMoney(number_format($datos[date("n")]["monto_mes"]));?></p>
										<table class="table" id="<?=$tipo?>">
											<thead>
												<tr>
													<th>MES</th>
													<th>META</th>
													<th>INGRESO</th>
													<th>PORCENTAJE</th>
												</tr>
											</thead>
											<tbody>
												<?php foreach($datos as $mes => $reg){
													
													$total_meta += $reg["monto_mes"];
													$total_comision += $reg["comision_venta_nueva"];
													//$porcentaje_total = $total_meta > 0 && $total_comision > 0 ? (100*$reg["comision_venta_nueva"])/$reg["monto_mes"] : 0;

													$porcentaje_unitario = 0;
													$porcentaje_unitario = $reg["monto_mes"] > 0 && $reg["comision_venta_nueva"] > 0 ? (100*$reg["comision_venta_nueva"])/$reg["monto_mes"] : 0;

													if($mes < date("n")){
														$sub_total_meta += $reg["monto_mes"];
														$sub_total_comision += $reg["comision_venta_nueva"];
														//$porcentaje_sub = $sub_total_meta > 0 && $sub_total_comision > 0 ? (100*$reg["comision_venta_nueva"])/$reg["monto_mes"] : 0;
														//$sub_total_it += 0;
													}
													
													?>
													<tr>
														<td class="hidden"><?=$mes?></td>
														<td><div><?=$meses[$mes]?></div><div class="mt-2"><?=(isset($reg["badge"]) && $reg["badge"] ? '<span class="label label-danger">Consulta '.$reg["year"].'</span>' : "" )?></div></td>
														<td class="text-center"><div>$<?=number_format($reg["monto_mes"])?></div><div class="mt-2"><?=(isset($reg["badge"]) && $reg["badge"] ? '<span class="label label-danger">Meta '.$reg["year"].'</span>' : "" )?></div></td>
														<td class="text-center"><div>$<?=number_format($reg["comision_venta_nueva"])?></div><div class="mt-2"><?=(isset($reg["badge"]) && $reg["badge"] ? '<span class="label label-danger">Comisión '.$reg["year"].'</span>' : "" )?></div></td>
														<td class="text-center"><div><?=number_format($porcentaje_unitario)?>%</div><div class="mt-2"><?=( isset($reg["badge"]) &&$reg["badge"] ? '<span class="label label-danger">Porcentaje '.$reg["year"].'</span>' : "" )?></div></td>
													</tr>
												<?php }

													$porcentaje_total = $total_meta > 0 && $total_comision > 0 ? (100*$total_comision)/$total_meta : 0;
													$porcentaje_sub = $sub_total_meta > 0 && $sub_total_comision > 0 ? (100*$sub_total_comision)/$sub_total_meta : 0;
												
												?>
											</tbody>
											<tfoot>
												<tr style="border-top: solid">
													<td>SUBTOTAL</td>
													<td>$<?=number_format($sub_total_meta)?></td>
													<td>$<?=number_format($sub_total_comision)?></td>
													<td><?=number_format($porcentaje_sub)?>%</td>
												</tr>
												<tr>
													<td>TOTAL</td>
													<td>$<?=number_format($total_meta)?></td>
													<td>$<?=number_format($total_comision)?></td>
													<td><?=number_format($porcentaje_total)?>%</td>
												</tr>
												<tr>
													<td>DIFERENCIA</td>
													<td>$<?=number_format($total_meta - $sub_total_meta)?></td>
													<td>$<?=number_format($total_comision - $sub_total_comision)?></td>
												</tr>
											</tfoot>
										</table>
									</div>
								<?php }?>		
							</div>
						</div>
					</div>
				</div>
			</div>
			<?php }?>
			<div class="panel panel-default">
				<div class="panel-heading"><i class="fa fa-angellist fa-lg"></i> Otros</div>
				<div class="panel-body">
					<p><b>Comida favorita:</b> <? echo $miInfo_Datos->comidaFavPersona; ?></p>
					<p><b>Color favorito:</b> <? echo $miInfo_Datos->colorFavPersona; ?></p>
					<p><b>Pasatiempo favorito:</b> <? echo $miInfo_Datos->pasatiempoFavPersona; ?></p>
					<p><b>Club social:</b> <? echo $miInfo_Datos->clubSocialPersona; ?></p>
				</div>
			</div>
            


		</div>
		<div class="col-md-9">
			<ul class="nav nav-tabs" role="tablist">
				<li role="presentation" class="active"><a href="#profile" aria-controls="profile" role="tab" data-toggle="tab">Perfil</a></li>
				<li role="presentation"><a href="#metaasig" aria-controls="metaasig" role="tab" data-toggle="tab">Metas asignadas</a></li>
				<li role="presentation"><a href="#valoracion" aria-controls="valoracion" role="tab" data-toggle="tab">Valoraciónes y Comentarios</a></li>
				<!--<li role="presentation" class="active"><a href="#profile" aria-controls="profile" role="tab" data-toggle="tab">Perfil</a></li>-->
				<?php   if ($es_empleado == 1) { ?>
					<li role="presentation"><a href="#incidencias" aria-controls="incidencias" role="tab" data-toggle="tab">Incidencias</a></li>
				<?php } ?>
					<li role="presentation"><a href="#evaluaciones" aria-controls="evaluaciones" role="tab" data-toggle="tab">Evaluaciones</a></li>
				<!--<li role="presentation"><a href="#capacitacion" aria-controls="otros" role="tab" data-toggle="tab">Capacitación</a></li>-->
				<!--Modificaciones MJ-->
				<?php   if ($es_empleado == 1) { ?>
                	<li role="presentation"><a href="#prestamos" aria-controls="prestamos" role="tab" data-toggle="tab">Prestamos / Ahorros</a></li>
				<?php } ?>
				<?php   if ($es_empleado == 1) { ?>
					<?php if($vacations["canRequestVacation"]){?>
						<li role="presentation"><a href="#vacaciones" aria-controls="vacaciones" role="tab" data-toggle="tab">Vacaciones</a></li>
					<?php }?>
				<?php } ?>
				<?php   if ($es_empleado == 1) { ?>
					<li role="presentation"><a href="#PIP" aria-controls="PIP" role="tab" data-toggle="tab">PIP</a></li>
                	<li role="presentation"><a href="#otros" aria-controls="otros" role="tab" data-toggle="tab">Otros</a></li>
				<?php } ?>
			</ul>
			<div class="tab-content">
				<div role="tabpanel" class="tab-pane active" id="profile">
<?php   /* }
        else { ?>
			<div class="panel panel-default">
				<div class="panel-heading">
					<i class="fa fa-profile fa-lg"></i> Perfil
				</div>
                                <div class="panel-body">
<?php
        } */ ?>
					<div class="row">
						<!--<ul class="menu-panel text-right">
							<li><a href="<?= base_url() ?>miInfo/editar" title="Editar"><i class="fa fa-edit fa-2x"></i></a></li>
							
								<li><a href="<?= base_url() ?>configuraciones" title="Configuración"><i class="fa fa-cogs fa-2x"></i></a></li> 
								
						</ul>-->
						<div class="col-md-2 col-sm-2 col-xs-3">
							<?php //var_dump($foto); 
							?>
							<img src="<?php echo base_url() . $foto; ?>" width="150" class="img-responsive" style="border-radius:50%;"/>
						</div>

						<div class="col-md-10 col-sm-10 col-xs-9">
							<?
							if (true) {
							?>
								<div class="row">
									<div class="col-md-6 col-sm-6">
										<!--<p><b>Tiempo Transcurrido Alta: <?= $tipoRestanteProvisional ?> Dias</b></p>-->
										<!------------------------------------------------------------------------------------------>
										<p><b>Años: <?=$df->y?>; Meses: <?php echo $df->m;//$mesActivo;?>; Dias: <?php echo $df->d;?></b></p>
										<!------------------------------------------------------------------------------------------>

										<p>
											<?php if (isset($miInfo_Datos->diasParaBaneo)) {
												echo ('<b>Tiempo de calculo para cubrir la cuota minima:  ' . $miInfo_Datos->diasParaBaneo . ' dias  </b>');
											} ?>

											<!--<?
											if (90 - $tipoRestanteProvisional > 0) {
											?>
												<p style="color:#F00; font-style:italic;">
													** Tiempo limite de permanencia es de 90 dias
													<br />
													(<?= 90 - $tipoRestanteProvisional; ?> Dias Restantes)
												</p>
											<?
											} else if (90 - $tipoRestanteProvisional < 0) {
											?>
												<p style="color:#F00; font-style:italic;">
													** Expiro
												</p>
											<?
											}
											?> -->
									</div>
								</div>
							<?
							}
							?>
							<div class="row">
								<div class="col-md-6 col-sm-6">
									<p><b>Fecha de ingreso:</b> <?= date("d-m-Y", strtotime($miInfo_Datos->fecAltaSistemPersona)) ?></p>
									<p><b>Sucursal:</b> <? echo $miInfo_Datos->id_catalog_sucursales; ?></p>
									<p><b>Usuario:</b> <? echo $miInfo_Datos->emailUser; ?></p>
									<p><b>RFC:</b> <? echo $miInfo_Datos->rfc; ?></p>
									<p><b>Escolaridad:</b> <? 
										$escolaridad="N/A";

										if(!empty($miInfo_Datos->escolaridad)){
											//$escc=$this->personamodelo->obtenerUnaEscolaridad($miInfo_Datos->escolaridad);
											$escolaridad=$miInfo_Datos->escolaridad;//$escc[0]->escolaridad;
										}
										//$escc=$this->personamodelo->obtenerUnaEscolaridad($miInfo_Datos->escolaridad);
										echo $escolaridad;//$escc[0]->escolaridad; ?></p>
								</div>
								<div class="col-md-6 col-sm-6">
									<p><b>Nombre:</b> <? echo $miInfo_Datos->nombres; ?></p>
									<p><b>Apellido:</b> <? echo $miInfo_Datos->apellidoPaterno . ' ' . $miInfo_Datos->apellidoMaterno; ?></p>
									<p><b>Fecha nac.:</b> <? echo $miInfo_Datos->fechaNacimiento; ?></p>
									<p><b>Lugar nac.:</b> <? echo $miInfo_Datos->estadoNacimiento." ".$miInfo_Datos->municipioNacimiento." ".$miInfo_Datos->paisNacimiento; ?></p>
									<p><b>Estado civil:</b> <? 
									
									$ed_civil="N/A";
									if(!empty($miInfo_Datos->estadoCivil)){
										$ec=$this->personamodelo->obtenerUnEstadoCivil($miInfo_Datos->estadoCivil);
										$ed_civil=$ec[0]->estadoCivil;
									}

									echo $ed_civil;?></p>
								</div>
							</div>
						</div>
					</div>
					<div class="row">
						<div class="col-md-12">
							<p class="h4"><i class="glyphicon glyphicon-map-marker"></i> Dirección</p>
							<hr />
						</div>
						<div class="col-md-12">
							<div class="row">
								<div class="col-md-6 col-sm-6 col-xs-6">
									<p><b>Calle:</b> <? echo $miInfo_Datos->calle; ?></p>
									<p><b>Referencia:</b> <? echo $miInfo_Datos->cruzamiento; ?></p>
									<p><b>Colonia:</b> <? echo $miInfo_Datos->colonia; ?></p>
								</div>
								<div class="col-md-6 col-sm-6 col-xs-6">
									<p><b>No. ext:</b> <? echo $miInfo_Datos->numero; ?></p>
									<p><b>C.P:</b> <? echo $miInfo_Datos->codigoPostal; ?></p>
									<p><b>Ciudad:</b> <? echo $miInfo_Datos->municipioDomicilio; ?></p>
								</div>
							</div>
						</div>
						<div class="col-md-12">
							<p class="h4"><i class="fa fa-phone"></i> Teléfono</p>
							<hr />
						</div>
						<div class="col-md-12">
							<div class="row">
								<div class="col-md-6 col-sm-6 col-xs-6">
									<p><b>Tel casa:</b> <? echo $miInfo_Datos->telCasa; ?></p>
									<p><b>Celular:</b> <? echo $miInfo_Datos->celPersonal; ?></p>
								</div>
								<div class="col-md-6 col-sm-6 col-xs-6">
									<p><b>Tel. trabajo:</b> <? echo $miInfo_Datos->telOficina; ?></p>
									<p><b>Comp. cel:</b> <? echo $miInfo_Datos->celOficina; ?></p>
								</div>
							</div>
						</div>
						<div class="col-md-12">
							<p class="h4"><i class="fa fa-car"></i> Vehículo</p>
							<hr />
						</div>
						<div class="col-md-12">
							<div class="row">
								<div class="col-md-6 col-sm-6 col-xs-6">
									<p><b>Vehículo propio:</b> <? echo $miInfo_Datos->vehiculoPersona; ?></p>
								</div>
								<div class="col-md-6 col-sm-6 col-xs-6">
									<p><b>Modelo vehículo:</b> <? echo $miInfo_Datos->modeloVehiculoPersona; ?></p>
								</div>
							</div>
						</div>
						<div class="col-md-12">
							<p class="h4"><i class="fa fa-file-text"></i> Documentos</p>
							<hr />
						</div>
						<div class="col-md-12">
							<div class="row">
								<div class="col-md-6 col-sm-6 col-xs-6">
									<p><b>Cedula CNSF:</b> <? echo $miInfo_Datos->cedulaPersona; ?></p>
									<!--<p><b>Licencia de Conducir:</b> <? //echo $miInfo_Datos->licencia_conducir; ?></p>-->
									<!--<p><b>Pasaporte:</b> <? //echo $miInfo_Datos->pasaporte; ?></p>-->
								</div>
								<div class="col-md-6 col-sm-6 col-xs-6">
									<p><b>Vigencia cedula:</b> <? echo $miInfo_Datos->fecFinCedulaPersona; ?></p>
									<!--<p><b>Vigencia licencia:</b> <? //echo $miInfo_Datos->vigencia_licencia; ?></p>-->
									<!--<p><b>Vigencia pasaporte:</b> <? //echo $miInfo_Datos->vigencia_pasaporte; ?></p>-->
								</div>
							</div>
						</div>
			<!--------------------------------------------------------------------------------------------------->
				<!--<div class="col-md-12">
					<p class="h4"><i class="fa fa-clock-o" aria-hidden="true"></i> Capacitación</p><hr />
					<div class="panel panel-info">
						<div class="panel-heading"><h5>Registro de horas de capacitación</h5></div>
						<div class="panel-body">
							<input type="hidden" name="idPersona" id="idPersona" value="<?=$idPersona?>">
							<?php 
								$conteoMes[1]="ENERO";
								$conteoMes[2]="FEBRERO";
								$conteoMes[3]="MARZO";
								$conteoMes[4]="ABRIL";
								$conteoMes[5]="MAYO";
								$conteoMes[6]="JUNIO";
								$conteoMes[7]="JULIO";
								$conteoMes[8]="AGOSTO";
								$conteoMes[9]="SEPTIEMBRE";
								$conteoMes[10]="OCTUBRE";
								$conteoMes[11]="NOVIEMBRE";
								$conteoMes[12]="DICIEMBRE";
							?> 
								<select name="mesesActivos" id="mesesActivos" class="form-control" style="width:30%">
									<option value="0">Historial de capacitación</option>
									<?php 
									if(isset($mesCapaA)){
									foreach($mesCapaA as $valor){?> 
										<option value="<?=$valor->mes?>"><?=$conteoMes[$valor->mes]?></option>
									<?php } }?>
									<option value="total">ACUMULADOS</option>
								</select>
						</div>
						<div class="panel-body">
							<div id="historial_unitario">
							
								<table class="table">
									<thead>
										<tr>
											<th>CATEGORIA</th>
											<th>SUB-CATEGORIA -> RAMO</th>
										</tr>
									</thead>
									<tbody id="cuerpoContenido"> 
									
										<?php if(isset($capacitacion)){
											$info="";
											foreach($capacitacion as $categoria=>$datos){?>
												<tr>
													<td><?=$categoria?></td>
													<td><?php foreach($datos as $subcate=>$ramos){
														//var_dump($datos);
														$info="<ul><li>Sub-categoria: <b>".$subcate."</b><br>En el ramo:";
														$info.="<ul>";
														foreach($ramos as $nombre=>$hora){
															if($hora>0){
																$info.="<li>".strtoupper(str_replace("danios","daños",$nombre)).": ".$hora." hrs</li>";
															}
														}
														$info.="</ul></li></ul><hr>";
														//echo $ramoname."<br>";
														echo $info;
													} ?></td>
												</tr>
												<?php } } if(empty($capacitacion)){?>
													<tr><td><h4>No hay datos asignado por el momento</h4></td></tr>
												<?php }?>
									</tbody>
								</table>
							</div>
							<div id="historial_mensual" style="display:none">
								<table class="table" >
									<thead>
										<tr>
											<th class="text-center">MES</th>
											<th class="text-center">CATEGORIAS</th>
											<th class="text-center">SUB-CATEGORIAS - TOTAL DE HORAS</th>
										</tr>
									</thead>
									<tbody id="cuerpoContenidoMensual"></tbody>
								</table>
							</div>
						</div>
					</div>
				</div>-->
			<!--------------------------------------------------------------------------------------------------->
			<!--------------------------------------------------------------------------------------------------->
			<div class="col-md-12">
					<p class="h4"><i class="fa fa-clock-o" aria-hidden="true"></i> Capacitación</p><hr />
					<div class="panel panel-info">
						<div class="panel-heading"><h5>Registro de horas de capacitación</h5></div>
						<div class="panel-body">
							<div>
								<em>Seleccione del combo la opción que requiere consultar.</em>
							</div>
							<div class="row mt-3">
								<div class="col-md-6">
									<div class="row">
										<label for="trainingCategory" class="mt-3 col-md-2">Categorias</label>
										<div class="col-md-6">
											<select name="trainingCategory" id="trainingCategory" class="form-control">
												<option value="0">Seleccione</option>
												<?php array_map(function($arr) { ?>
													<option value="<?=strtolower(str_replace(" ", "-", $arr))?>"><?=$arr?></option>
												<?php }, $trainingNames) ?>
												<option value="accumulated">ACUMULADO</option>
											</select>
										</div>
									</div>
								</div>
							</div>
							<div class="col-md-12">
								<?php foreach($training as $training_ => $dataTraining){?>
									<div class="col-md-12 training-container hidden" id="<?=strtolower(str_replace(" ", "-", $training_))?>">
										<div class="panel panel-body">
											<?php foreach($dataTraining as $subTraining => $data) {?>
												<div class="row">
													<div class="col-md-4 center-block">
														
														<h4 class="sub-category text-center" style="padding-top: 15px"><?=$subTraining?></h4>
													</div>
													<div class="col-md-8">
														<!--<h4>Registros de horas</h4>-->
														<div class="row">
															<?php foreach($data as $data){ ?> 
															
																<div class="col-md-3 text-white mr-2 mt-2" style="background-color: <?=$data["style"]["background"]?>">
																	<div class="row">
																		<div class="col-md-4" style="padding: 0;">
																			<h4 class="text-center text-white"><i class="fa <?=$data["style"]["icon"]?>" aria-hidden="true"></i></h4>
																		</div>
																		<div class="col-md-7" style="padding: 0">
																			<h5 class="text-right"><?=$data["horas"]?> horas</h5>
																			<a 
																				role="button" 
																				class="text-white dates-popover" 
																				tabindex="0" 
																				data-toggle="popover" 
																				data-id="<?=$idPersona?>" 
																				data-training = "<?=$training_?>"
																				data-subtraining="<?=$subTraining?>"
																				data-category="<?=$data["ramo"]?>" 
																				data-url="<?=base_url()?>"
																			>
																				<p class="text-right" style="font-size: 10px;"><?=strtoupper($data["ramo"])?></p>
																			</a>
																		</div>
																	</div>
																</div>

															<?php }?>
														</div>
													</div>
												</div>
												<br>
												<hr>
											<?php }?>
										</div>
									</div>
								<?php }?>
								<div class="col-md-12 training-container hidden" id="accumulated">
									<div class="panel panel-body">
										<table class="table text-center">
											<thead>
												<tr>
													<th class="text-center">Capacitación</th>
													<th class="text-center">Contenido</th>
												</tr>
											</thead>
											<tbody>
												<? foreach($training as $name => $subTraining){?>
													<tr>
														<td><?=$name?></td>
														<td>
															<table class="table table-sm">
																<tbody>
																	<tr>
																		<td>Sub-categoría</td>
																		<td>Ramos - Horas</td>
																	</tr>
																	<? foreach($subTraining as $sName => $data){?>
																		<tr>
																			<td class="text-left"><?=$sName?></td>
																			<td>
																				<div class="row text-left">
																					<?php foreach($data as $d_){?>
																						<div class="ramos-labels" style="background-color: <?=$d_["style"]["background"]?>"><?=strtoupper($d_["ramo"]).": ".$d_["horas"]?> hrs</div>
																					<?php }?>
																				</div>
																			</td>
																		</tr>	
																	<?php }?>
																</tbody>
															</table>
														</td>
													</tr>	
												<?php }?>
											</tbody>
										</table>
									</div>
								</div>
							</div>
						</div>
						<!--<div class="panel-body">
							<input type="hidden" name="idPersona" id="idPersona" value="<?=$idPersona?>">
							<?php 
								$conteoMes[1]="ENERO";
								$conteoMes[2]="FEBRERO";
								$conteoMes[3]="MARZO";
								$conteoMes[4]="ABRIL";
								$conteoMes[5]="MAYO";
								$conteoMes[6]="JUNIO";
								$conteoMes[7]="JULIO";
								$conteoMes[8]="AGOSTO";
								$conteoMes[9]="SEPTIEMBRE";
								$conteoMes[10]="OCTUBRE";
								$conteoMes[11]="NOVIEMBRE";
								$conteoMes[12]="DICIEMBRE";
							?> 
								<select name="mesesActivos" id="mesesActivos" class="form-control" style="width:30%">
									<option value="0">Historial de capacitación</option>
									<?php 
									if(isset($mesCapaA)){
									foreach($mesCapaA as $valor){?> 
										<option value="<?=$valor->mes?>"><?=$conteoMes[$valor->mes]?></option>
									<?php } }?>
									<option value="total">ACUMULADOS</option>
								</select>
						</div>
						<div class="panel-body">
							<div id="historial_unitario">
							
								<table class="table">
									<thead>
										<tr>
											<th>CATEGORIA</th>
											<th>SUB-CATEGORIA -> RAMO</th>
										</tr>
									</thead>
									<tbody id="cuerpoContenido">
										
										<?php if(isset($capacitacion)){
											$info="";
											foreach($capacitacion as $categoria=>$datos){?>
												<tr>
													<td><?=$categoria?></td>
													<td><?php foreach($datos as $subcate=>$ramos){
														//var_dump($datos);
														$info="<ul><li>Sub-categoria: <b>".$subcate."</b><br>En el ramo:";
														$info.="<ul>";
														foreach($ramos as $nombre=>$hora){
															if($hora>0){
																$info.="<li>".strtoupper(str_replace("danios","daños",$nombre)).": ".$hora." hrs</li>";
															}
														}
														$info.="</ul></li></ul><hr>";
														//echo $ramoname."<br>";
														echo $info;
													} ?></td>
												</tr>
												<?php } } if(empty($capacitacion)){?>
													<tr><td><h4>No hay datos asignado por el momento</h4></td></tr>
												<?php }?>
									</tbody>
								</table>
							</div>
							<div id="historial_mensual" style="display:none">
								<table class="table" >
									<thead>
										<tr>
											<th class="text-center">MES</th>
											<th class="text-center">CATEGORIAS</th>
											<th class="text-center">SUB-CATEGORIAS - TOTAL DE HORAS</th>
										</tr>
									</thead>
									<tbody id="cuerpoContenidoMensual"></tbody>
								</table>
							</div>
						</div>-->
					</div>
				</div>
			<!--------------------------------------------------------------------------------------------------->
						<div class="col-md-12">
							<p class="h4"><i class="fa fa-file-text"></i> Funnel general del mes en curso</p>
							<hr />
						</div>
						<div class="col-md-6">
							<div class="row">
								<?= imprimirProspectos2($prospectos); ?>
							</div>
						</div>
					</div>
				</div>

				<div role="tabpanel" class="tab-pane" id="valoracion">
				    <div class="row">
				        <div class="col-md-12">
				            <p class="h4"><i class="fa fa-file-text"></i>Valoraciónes y Comentarios de sus Clientes</p>
				        </div>
				       
				    </div>
				     <hr />
				    <div class="row">
				    	 <div class="col-md-6">
				    	 	<?php $this->load->view("miInfo/comentarios");?>
				    	 </div>
				        <div class="col-md-6">
				        	<?php $this->load->view("miInfo/estrellas");?>
				        </div>
				    </div>
				</div>
				<div role="tabpanel" class="tab-pane" id="evaluaciones">
					<div class="row">
						<div class="col-md-12">
							<p class="h4"><i class="fa fa-file-text"></i> Pendientes por responder</p>
							<hr />
						</div>
						<div class="col-md-12">
							<?= $this->load->view("evaluaciones/personas/evaluaciones_pendientesAll") ?>
						</div>
						<div class="col-md-12">
							<!-- cambios TIC_Consultores 17/03/2021 -->
							<div style="float:right;">
								<ul style="list-style:none;">
									<li role="presentation" class="pull-right dropdown">
										<a style="line-height: 25px;" class="dropdown-toggle" data-toggle="dropdown" href="#" role="button" aria-haspopup="true" aria-expanded="false">
											Periodo:  <?= $periodoName ?><span class="caret"></span>
										</a>
										<ul class="dropdown-menu">
										<?php foreach ($periodos as $key => $value) : ?>
												<li><a href="<?= base_url() . "miInfo/?periodo=$value[id]" ?>"><?= $value["titulo"] ?></a></li>
											<?php endforeach; ?>
										</ul>
									</li>
								</ul>
							</div>
							<p class="h4"><i class="fa fa-file-text"></i> Evaluaciones por periodos</p>
							<hr />
						</div>
						<div class="col-md-12">
							<?= $this->load->view("evaluaciones/personas/evaluaciones_pendientes") ?>
						</div>
						<div class="col-md-12">
							<p class="h4"><i class="fa fa-file-text"></i> Mi evaluación</p>
							<hr />
						</div>
						<div class="col-md-12">
							<?= $this->load->view("evaluaciones/personas/mi_evaluacion") ?>
						</div>
					</div>
				</div>
			<?php   if ($es_empleado == 1) { ?>
				<div role="tabpanel" class="tab-pane" id="incidencias">
					<div class="row">
						<div class="col-md-12">
							<?php if ($puedo_solicitar) : ?>
								<div id="vOptions" data-min-date="<?= $minDayVacation ?>" data-start-block="<?= $startBlock ?>" data-days-block="<?= $daysBlock ?>"></div>
							
                            <button class="openModal btn-primary btn-sm btn pull-right" data-in-id="0" data-in-eid="<?= $id; ?>" data-in-name="<?= $name_complete; ?>" data-in-mode="vacaciones" data-in-ty="1" data-in-days="<?= $dias_vacaciones ?>">Solicitar</button>
                            
                            

							<?php endif; ?>
							<!--<p class="h4"><i class="fa fa-file-text"></i> Vacaciones</p>
							<hr />-->
						</div>
						<div class="col-md-12">
							<?= $this->load->view("evaluaciones/personas/mis_vacaciones") ?>
						</div>
						<div class="col-md-12">
							<p class="h4"><i class="fa fa-file-text"></i> Mis incidencias</p>
							<hr />
						</div>
						<div class="col-md-12">
							<?= $this->load->view("evaluaciones/personas/mis_incidencias") ?>
						</div>
					</div>
				</div>
				
				<div role="tabpanel" class="tab-pane" id="PIP">
					<div class="row">
						<div class="col-md-12">
							<a class="btn-primary btn-sm btn pull-right" href="<?=base_url()."PIP/AgregarPIP/?id=0&idp=0&idpp=0"?>">Administrar PIP</a>
							<p class="h4"><i class="fa fa-file-text"></i> Seguimiento performance improvement plan</p>
							<hr />
						</div>
						<div class="col-md-12">
							<?= $this->load->view("evaluaciones/personas/mis_pip") ?>
						</div>
					</div>
				</div>
				<div role="tabpanel" class="tab-pane" id="otros">
					<div class="row">
						<div class="col-md-12">
							<?php if ($puedo_solicitar) : ?>
								<button class="bn-sol-bono btn-primary btn-sm btn pull-right" data-in-id="0" data-in-eid="<?= $id; ?>" data-in-name="<?= $name_complete; ?>">Solicitar</button>
							<?php endif; ?>
							<p class="h4"><i class="fa fa-file-text"></i> Solicitud de sueldos</p>
							<hr />
						</div>
						
						<div class="col-md-12">
							<?= $this->load->view("evaluaciones/personas/mis_bonos") ?>
						</div>
					</div>
					<!-- <div class="row">
						<div class="col-md-12">
							<p class="h4"><i class="fa fa-file-text"></i> Seguimiento performance improvement plan</p>
							<hr />
						</div>
						<div class="col-md-12">
							<?= $this->load->view("evaluaciones/personas/mis_pip") ?>
						</div>
					</div> -->
				</div>
				
        
<!--Modificaciones MJ-->
<div role="tabpanel" class="tab-pane" id="prestamos">
    <div class="row">
        <div class="col-md-10">
            <p class="h4"><i class="fa fa-file-text"></i> Solicitud de Prestamos / Ahorros</p>
        </div>
        <div class="col-md-2">
            <a href="#" data-toggle="modal" data-target="#modalPrestamos"><button class="btn btn-primary btn-sm btn pull-right">Solicitar</button></a>
        </div>
    </div>
     <hr />
    <div class="row">
        <div class="col-md-12">
            <?php $this->load->view("miInfo/prestamos");?>
            <hr>
            <?php $this->load->view("miInfo/ahorros");?>
            <div class="alert alert-info"><i class="fa fa-info-circle"></i>&nbsp;Solicite prestamos y ahorros de su nomina a traves de este modulo</div>
        </div> 
    </div>
</div>

<?php if($vacations["canRequestVacation"]){
	$diasSolicitados=$diasSolicitados[0]->dias;
	$restan=$diasVacaciones-$diasSolicitados;
?>
<div role="tabpanel" class="tab-pane" id="vacaciones">
    <div class="row">
        <div class="col-md-10">
            <p class="h4"><i class="fa fa-file-text"></i> Solicitud de vacaciones</p>
        </div>
        <div class="col-md-2">
        <?php if($vacations["canRequestVacation"]){ //canRequestVacation //$restan>0 ?>
            <a href="#" data-toggle="modal" data-target="#modalVacaciones">
                <button class="btn-primary btn-sm btn pull-right">Solicitar</button>
            </a>
        <?php }?>
        </div>
    </div>
     <hr />
     <?	?>
    <div class="row">
        <div class="col-md-12">
            <?php $this->load->view("miInfo/vacaciones", array("vacaciones" => $vacaciones, "dayRequest" => $diasSolicitados));?>
			<?php if($vacations["countDays"] <= 15){?>
			<div class="alert alert-danger" role="alert">
				Importante: <br>
				<?php if($vacations["countDays"] > 0){?>
					Quedan <b><?=$vacations["countDays"]?></b> dias disponibles para solicitar vacaciones antes de que empiece el siguiente periodo. <br>
					Los dias faltantes no son acumulables.
					<br>Ya no podrá solicitar vacaciones hasta el cambio de periodo.
				<?php } else{?> 
					Usted no puede solicitar vacaciones hasta llegar a la fecha: <b><?=$vacations["changeDate"]?></b>
				<?php }?>
			</div>
			<?php }?>
            <div class="alert alert-info" style="padding-left: 50px;">
				<i class="fa fa-info-circle"></i> <b>Nota:</b> Actualmente Ud. posee <b><?= $vacations["period"]; //$antiguedad?></b> años de antiguedad en la empresa, le corresponde en este periodo(<?php echo date('Y',strtotime($vacations['periodoActual']));?>) lo siguente:<br>
				<ul>
					<li>Dias de Vacaciones: <b><?php echo $vacations["cantidadDiasPeriodo"]; //echo $diasVacaciones;?></b></li>
					<li>Dias aprobados ó pendientes por aprobar: <b><?php echo $diasSolicitados;?></b></li>
					<li>Le Resta: <b><?php echo ($restan);?></b> dia(s) para vacacionar</li>
				</ul>
            </div>
        </div>
    </div>
</div>
<?php }?>

<?php
        } ?>

				<div role="tabpanel" class="tab-pane" id="metaasig">
					<h4>Metas asignadas</h4>
					<hr>
					<h5>Metas por ramo</h5>
						<table class="table">
							<thead>
								<tr>
									<th>MES</th>
									<th>AUTOS</th>
									<th>VIDA</th>
									<th>DAÑO</th>
									<th>GMM</th>
									<th>FIANZAS</th>
								</tr>
							</thead>
							<tbody>
							<?php foreach($metaPorRamoMensual as $mes=>$dataInfo){ ?>
								<tr>
									<td><?=$meses[$mes]?></td>
									<td>
										<ul>
											<li>Polizas: <span class="badge badge-primary"><?=$dataInfo["autos"]["Polizas"]?></span></li>
											<li>Prima: <span class="badge badge-info">$ <?=$dataInfo["autos"]["Prima"]?></span></li>
										</ul>
									</td>
									<td>
										<ul>
											<li>Polizas: <span class="badge badge-primary"><?=$dataInfo["vida"]["Polizas"]?></span></li>
											<li>Prima: <span class="badge badge-info">$ <?=$dataInfo["vida"]["Prima"]?></span></li>
										</ul>
									</td>
									<td>
										<ul>
											<li>Polizas: <span class="badge badge-primary"><?=$dataInfo["danios"]["Polizas"]?></span></li>
											<li>Prima: <span class="badge badge-info">$ <?=$dataInfo["danios"]["Prima"]?></span></li>
										</ul>
									</td>
									<td>
										<ul>
											<li>Polizas: <span class="badge badge-primary"><?=$dataInfo["gmm"]["Polizas"]?></span></li>
											<li>Prima: <span class="badge badge-info">$ <?=$dataInfo["gmm"]["Prima"]?></span></li>
										</ul>
									</td>
									<td>
										<ul>
											<li>Polizas: <span class="badge badge-primary"><?=$dataInfo["fianzas"]["Polizas"]?></span></li>
											<li>Prima: <span class="badge badge-info">$ <?=$dataInfo["fianzas"]["Prima"]?></span></li>
										</ul>
									</td>
								</tr>
							<?php }?>
							</tbody>
						</table>
					</div>
							</div>
			</div>
	</div>
	<!-- Semaforo de Actividades -->
	<div class="row">
		<div class="col-md-12">
			<div class="panel panel-default">
				<div class="col-md-12">
					<h3 class="titulo-secciones">Semáforo de Actividades</h3>
				</div>

				<!-- -->

				<section class="container-fluid">
					<div class="row">
						<div class="col-md-12">
						</div>
					</div>
					<?
					if ($ConsultaTipoAct->num_rows() > 0) {
					?>
						<div class="row">
							<div class="col-md-12">
								<div class="panel panel-default">
									<div class="panel-heading">
										<i class="glyphicon glyphicon-filter"></i> Resultados Filtrados
									</div>
									<!--* panel-heading -->
									<div class="panel-body">
										<div class="row">
											<div class="col-md-12">
												<span style="font-size:14px;">
													<?
													if ($filtroFechas == "si") {
													?>
														<!--                            <div class="row"> -->
														<div class="col-md-6">
															<b>Filtrado Tipo:</b> <i>Rango de Fechas</i>
															<p style="padding-left:9px;">
																<b>Fecha de Inicio:</b> <i><?= $fechaStart ?></i>
																&nbsp;
																<b>Fecha de Inicio:</b> <i><?= $fechaEnd ?></i>
															</p>
														</div>
														<!--							</div> -->
													<?
													} else {
													?>
														<!--                            <div class="row"> -->
														<div class="col-md-6">
															<b>Filtrado Tipo:</b> <i>Selecci&oacute;n de Mes</i>
															<p style="padding-left:9px;">
																<b>Mes Seleccionado:</b> <i><?php if (isset($meses[$mesActivo])) {
																								echo ($meses[$mesActivo]);
																							} ?></i>
															</p>
														</div>
														<!--							</div> -->
													<?
													}
													?>
													<?
													if (!isset($usuarioVendedor) || $usuarioVendedor != "") {
													?>
														<div class="col-md-6">
															<b>Filtrado Agente:</b> <i>Si</i>
															<p style="padding-left:9px;">
																<?
																/*
											// print_r($usuVend_Array);
											if(in_array($usuarioVendedor,$usuVend_Array)){
												//echo "Si";
											} else {
												//echo "No";
											}
										*/
																?>
																<b>Agente:</b> <i><?= $usuarioVendedor ?></i>
															</p>
														</div>
													<?
													}
													?>
												</span>
											</div>
										</div>
									</div>
								</div>
							</div>
						</div>
					<?
					} else if ($this->input->post('fechaStart', TRUE) != "") {
					?>
						<div class="row">
							<div class="col-md-12">
								<div class="panel panel-default">
									<div class="panel-heading">
										<i class="glyphicon glyphicon-warning-sign"></i> No Hay Resultados
										<!-- glyphicon glyphicon-warning-sign -->
									</div>
									<!--* panel-heading -->
									<div class="panel-body">
										<div class="row">
											<div class="col-md-12">
												<span style="color:#F00; font-weight:bold; font-size:14px;">
													Lo siento no existen resultados con el filtro solicitado !!!
												</span>
											</div>
										</div>
									</div>
								</div>
							</div>
						</div>
					<?
					}
					?>
					<!--
	<div class="row">
		<div class="col-md-12">
			<div class="row">
				<div class="col-sm-12 col-md-12">
					<div class="panel panel-default">
						<div class="panel-heading">
							<i class="glyphicon glyphicon-list-alt"></i> Actividades
						</div>
						<div class="panel-body">
							@@@
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
-->
					<div class="row">
						<div class="col-md-12">
							<div class="row">
								<div class="col-sm-3 col-md-4">
									<div class="panel panel-default">
										<div class="panel-heading">
											<i class="glyphicon glyphicon-list-alt"></i> Semaforo Actividades
										</div>
										<!--* panel-heading -->
										<div class="panel-body">
											<form name="formMesActividades" id="formMesActividades" method="post" action="<?= base_url(); ?>miInfo">
												<input type="hidden" name="monitorear" value="SemaforoActividades">

												<!-- -->
												<div class="row">
													<div class="col-sm-12 col-md-12" align="right">
														<select class="form-control input-sm" name="usuarioVendedor" id="usuarioVendedor" title="Seleccione un Agente a Monitorear">
															<option value="" title="Muestra Todos los Agentes">-- Seleccione un Agente --</option>
															<?
															foreach ($usuVend_Array as $usuVend) { // $key => $mes
															?>
																<option value="<?= $usuVend['EMail1'] ?>" <?= ($usuVend['EMail1'] == $usuarioVendedor) ? 'selected="selected"' : '' ?> title="<?= "[" . $usuVend['Status_TXT'] . "] (" . $usuVend['Giro'] . ") {" . $usuVend['Clasifica_TXT'] . "}" ?>">
																	<?= $usuVend['NombreCompleto'] ?>
																</option>
															<?
															}
															?>
														</select>
													</div>
													<div class="col-sm-4 col-md-4">
														<input type="hidden" name="userMail" id="userMail" class="form-control input-sm fecha fechaStart" value="<?= $usuarioVendedor; ?>" />
													</div>
													<div class="col-sm-4 col-md-4">
														<input type="hidden" name="idPersona" id="idPersona" value="<?= $idPersona; ?>" />
													</div>
												</div>
												<div class="row">
													<div class="col-sm-12 col-md-12" align="right">
														<p>
															<hr />
														</p>
													</div>
												</div>
												<div class="row">
													<div class="col-sm-4 col-md-4">
														<input type="hidden" name="filtroFechas" id="filtroFechas" value="<?= $this->input->post('filtroFechas', TRUE) ?>">
														<label style="alignment-baseline:central;">
															Filtro Fechas:
															<input type="checkbox" name="filtroFechasChec" id="filtroFechasChec" value="si" <?= ($this->input->post('filtroFechas', TRUE) == "si") ? 'checked="checked"' : '' ?> title="Click para activar el filtro por rango de fechas" />
														</label>
													</div>

													<div class="col-sm-4 col-md-4">
														<input type="text" name="fechaStart" id="fechaStart" class="form-control input-sm fecha fechaStart" placeholder="1900-01-01" value="<?= ($this->input->post('fechaStart', TRUE) != "") ? $this->input->post('fechaStart', TRUE) : date('Y-m-d') ?>" title="Fecha de Inicio" />
													</div>
													<div class="col-sm-4 col-md-4">
														<input type="text" name="fechaEnd" id="fechaEnd" class="form-control input-sm fecha fechaEnd" placeholder="1900-01-01" value="<?= ($this->input->post('fechaEnd', TRUE) != "") ? $this->input->post('fechaEnd', TRUE) : date('Y-m-d') ?>" title="Fecha de Fin" />
													</div>
												</div>
												<div class="row">
													<div class="col-sm-12 col-md-12" align="right">
														<p>
															<hr />
														</p>
													</div>
												</div>
												<div class="row">
													<div class="col-sm-8 col-md-8">
														<!-- -->
														<select class="form-control input-sm" style="display: none;" name="mesActividades" id="mesActividades" title="Seleccione el Mes a Monitorear">
															<option value="">-- Seleccione Mes a Monitorear --</option>
															<?
															foreach ($meses as $key => $mes) {
															?>
																<option value="<?= $key ?>" <?= ($mesActivo == $key) ? 'selected="selected"' : '' ?>><?= $mes ?></option>
															<?
															}
															?>
														</select>
													</div>
													<div class="col-sm-4 col-md-4">
														<button class="btn btn-primary btn-sm" name="GenerarMonitor" id="GenerarMonitor">
															Mostrar Monitor
														</button>
													</div>
												</div>
												<div class="row">
													<div class="col-sm-12 col-md-12">
														<?
														if ($ConsultaActivi->num_rows() > 0) {
															$dat_Actividades	= "";
															$ref				= array();
															$puntero			= 0;
															$tipoActividadMes	= array();
															$totalActividades	= 0;

															foreach ($ConsultaActivi->result_array() as $tiposActividad) {
																//print_r($tiposActividad);
																$totalActividades	= $totalActividades + $tiposActividad['noTipoActividad'];
																$tipoActividadMes[]	= $tiposActividad['tipoActividad'];
																$dat_Actividades   .= $tiposActividad['noTipoActividad'] . ",";
																$ref[] = ''
																	. '<tr>'
																	. '<td>'
																	. '<img src="' . $graficaRef . $colorRef[$puntero] . '&typ=2&dim=5&bkg=FFFFFF">'
																	. '</td>'
																	. '<td>'
																	. '(' . str_pad($tiposActividad['noTipoActividad'], 2, '0', 0) . ')'
																	. '</td>'
																	. '<td>'
																	. '' . $tiposActividad['tipoActividad']
																	. '</td>'
																	. '</tr>';
																$puntero++;
															}
															$dat_Actividades = $dat_Actividades . $cantUrgentes;
															$sumCalificaciones = $cantMalas + $cantRegulares + $cantSinCalificar + $cantBuenas;
														?>


															<img src="<?= $graficaBarras . trim($dat_Actividades, ',') . "&bkg=FFFFFF&wdt=300&hgt=200" ?>">
															<br />
															<div class="table-responsive">
																<table class="table">
																	<tr style="text-decoration:underline;">
																		<td></td>
																		<td>Total</td>
																		<td>Tipo Actividad</td>
																	</tr>
																	<?
																	foreach ($ref as $referencia) {
																		print($referencia);
																	}
																	/*$imprimeUrgentes='<tr><td><img src="'.base_url();
										$imprimeUrgentes=$imprimeUrgentes.'assets/plugins/GraPHPico_0-0-3/graphref.php?ref=23&typ=2&dim=5&bkg=FFFFFF"></td><td>(';
										$imprimeUrgentes=$imprimeUrgentes.$cantUrgentes.')</td><td>Urgentes</td></tr>';*/

																	//echo($imprimeUrgentes);

																	?>
																	<tr>
																		<td></td>
																		<td colspan="2"><b><?= $totalActividades ?> Total</b></td>

																	</tr>
																	<tr>
																		<td colspan="5">Numero de urgentes: <?php echo ($cantUrgentes)    ?> </td>
																	</tr>

																	<tr>
																		<td colspan="5">Calificacion de las Actividades </td>
																	</tr>
																	<tr>
																		<td colspan="5"><label style=" color: green"><?php echo ($cantBuenas); ?> Actividades Buenas (<?php echo (round(($cantBuenas * 100) / $sumCalificaciones, 1, PHP_ROUND_HALF_UP)) ?>%)</label></td>
																	</tr>
																	<tr>
																		<td colspan="5"> <label style=" color: red"><?php echo ($cantMalas);  ?> <label style=" color: red">Actividades Malas (<?php echo (round(($cantMalas * 100) / $sumCalificaciones, 1, PHP_ROUND_HALF_UP)) ?>%)</label></td>
																	</tr>
																	<tr>
																		<td colspan="5"><label style=" color: #d28802"><?php echo ($cantRegulares);  ?> Actividades Regulares (<?php echo (round(($cantRegulares * 100) / $sumCalificaciones, 1, PHP_ROUND_HALF_UP)) ?>%)</label></td>
																	</tr>
																	<tr>
																		<td colspan="5"><label style=" color: #605e5e"><?php echo ($cantSinCalificar);  ?> Actividades sin Calificar (<?php echo (round(($cantSinCalificar * 100) / $sumCalificaciones, 1, PHP_ROUND_HALF_UP)) ?>%)</label></td>
																	</tr>

																</table>

															</div>
														<?
														} /*! if Num_Rows() */
														?>
													</div>
												</div>
												<!-- <input type="hidden" name="tipoActividad" value=""> -->
											</form>
										</div>
										<!--* panel-body -->
									</div>
									<!--* panel panel-default -->
								</div>
								<!--* col-sm-3 col-md-4 -->

								<? if ($ConsultaActivi->num_rows() > 0) { ?>
									<div class="col-sm-3 col-md-4">
										<div class="panel panel-default">
											<div class="panel-heading">
												<i class="glyphicon glyphicon-list-alt"></i> Desglose Tipos Actividades
											</div>
											<!--* panel-heading -->
											<div class="panel-body">
												<form name="formTipoActividades" id="formTipoActividades" method="post" action="<?= base_url(); ?>miInfo">
													<!-- action="<?= base_url(); ?>monitores/verMonitor" -->
													<input type="hidden" name="monitorear" value="SemaforoActividades">
													<input type="hidden" name="mesActividades" value="<?= $this->input->post('mesActividades', TRUE) ?>">
													<input type="hidden" name="filtroFechas" value="<?= $this->input->post('filtroFechas', TRUE) ?>">
													<input type="hidden" name="fechaStart" value="<?= $this->input->post('fechaStart', TRUE) ?>">
													<input type="hidden" name="fechaEnd" value="<?= $this->input->post('fechaEnd', TRUE) ?>">
													<input type="hidden" name="usuarioVendedor" value="<?= $this->input->post('usuarioVendedor', TRUE) ?>">
													<input type="hidden" name="userMail" value="<?= $usuarioVendedor ?>">
													<input type="hidden" name="idPersona" value="<?= $idPersona ?>">

													<select class="form-control input-sm" name="tipoActividad" id="tipoActividad" title="Seleccione el Tipo de actividad a Monitorear">
														<?
														foreach ($tipoActividadMes as $tiposActividades) {
														?>
															<option value="<?= $tiposActividades ?>" <?= ($tipoActividad == $tiposActividades) ? 'selected="selected"' : '' ?>><?= $tiposActividades ?></option>
														<?
														}
														?>
													</select>
													<?
													if ($ConsultaTipoAct->num_rows() > 0) {
														$dat_TiposActividades	= "";
														$refTiposActividades	= array();
														$puntero				= 0;
														$totalTiposActividades	= 0;
														$tiposProspectos		= array();
														$subRamosActivida		= array();

														foreach ($ConsultaTipoAct->result_array() as $tipoActividades) {
															//$totalSubRamo			= $tipoActividades['noActividadTipo'];
															$subRamosActivida[]		= $tipoActividades['subRamoActividad'];
															$totalTiposActividades	= $totalTiposActividades + $tipoActividades['noActividadTipo'];
															$dat_TiposActividades   .= $tipoActividades['noActividadTipo'] . ",";
															$refTiposActividades[]	= ''
																. '<tr>'
																. '<td>'
																. '<img src="' . $graficaRef . $colorRef[$puntero] . '&typ=2&dim=5&bkg=FFFFFF">'
																. '</td>'
																. '<td>'
																. '(' . str_pad($tipoActividades['noActividadTipo'], 2, '0', 0) . ')'
																. '</td>'
																. '<td>'
																. '' . $tipoActividades['tipoActividad']
																. '<font style="font-size:10px;">'
																. '<br /><b>&bull;' . $tipoActividades['ramoActividad'] . '</b>'
																. '<br /><b>-' . $tipoActividades['subRamoActividad'] . '</b>'
																. '</font>'
																. '</td>'
																. '</tr>';
															$puntero++;
														}

													?>

														<img src="<?= $graficaPastel . trim($dat_TiposActividades, ',') . "&bkg=FFFFFF&wdt=300&hgt=200" ?>">
														<? echo '<img   src=' . base_url() . 'GraPHPico_0-0-3/graphpastel.php?dat=2,5,1,6,3,4&bkg=FFFFFF&wdt=100&hgt=200"' . '">' ?>
														<br /><br />
														<div class="table-responsive">
															<table class="table">
																<tr style="text-decoration:underline;">
																	<td></td>
																	<td>Total</td>
																	<td>Tipos Actividad</td>
																</tr>
																<?
																$sumaCalifPorTipo = $cantBuenasPorTipoResult + $cantMalasPorTipoResult + $cantRegularResult + $cantSinCalificarResult;
																foreach ($refTiposActividades as $refTipoActivida) {
																	print($refTipoActivida);
																}
																?>
																<tr>
																	<td></td>
																	<td colspan="2"><b><?= $totalTiposActividades ?> Total</b></td>
																</tr>

																<tr>
																	<td colspan="5">Calificacion de las Actividades </td>
																</tr>
																<tr>
																	<td colspan="5"><label style=" color: green"><?php echo ($cantBuenasPorTipoResult); ?> Actividades Buenas (<?php echo (round(($cantBuenasPorTipoResult * 100) / $sumaCalifPorTipo, 1, PHP_ROUND_HALF_UP)) ?>%)</label></td>
																</tr>
																<tr>
																	<td colspan="5"> <label style=" color: red"><?php echo ($cantMalasPorTipoResult);  ?> <label style=" color: red">Actividades Malas (<?php echo (round(($cantMalasPorTipoResult * 100) / $sumaCalifPorTipo, 1, PHP_ROUND_HALF_UP)) ?>%)</label></td>
																</tr>
																<tr>
																	<td colspan="5"><label style=" color: #d28802"><?php echo ($cantRegularResult);  ?> Actividades Regulares (<?php echo (round(($cantRegularResult * 100) / $sumaCalifPorTipo, 1, PHP_ROUND_HALF_UP)) ?>%)</label></td>
																</tr>
																<tr>
																	<td colspan="5"><label style=" color: #605e5e"><?php echo ($cantSinCalificarResult);  ?> Actividades sin Calificar (<?php echo (round(($cantSinCalificarResult * 100) / $sumaCalifPorTipo, 1, PHP_ROUND_HALF_UP)) ?>%)</label></td>
																</tr>
															</table>
														</div>
													<?
													} /*! if Num_Rows() */
													?>
												</form>
											</div>
											<!--* panel-body -->
										</div>
										<!--* panel panel-default -->
									</div>
									<!--* col-sm-3 col-md-4 -->
								<? } ?>
								<? if ($ConsultaActivi->num_rows() > 0) { ?>
									<div class="col-sm-3 col-md-4">
										<div class="panel panel-default">
											<div class="panel-heading">
												<i class="glyphicon glyphicon-list-alt"></i> Detalle Actividades Tipo
											</div>
											<!--* panel-heading -->
											<div class="panel-body">
												<form name="formDetalleActividades" id="formDetalleActividades" method="post" action="<?= base_url(); ?>miInfo">
													<!-- action="<?= base_url(); ?>monitores/verMonitor" -->
													<input type="hidden" name="monitorear" value="SemaforoActividades">
													<input type="hidden" name="mesActividades" value="<?= $this->input->post('mesActividades', TRUE) ?>">
													<input type="hidden" name="tipoActividad" value="<?= $this->input->post('tipoActividad', TRUE) ?>">
													<input type="hidden" name="filtroFechas" value="<?= $this->input->post('filtroFechas', TRUE) ?>">
													<input type="hidden" name="fechaStart" value="<?= $this->input->post('fechaStart', TRUE) ?>">
													<input type="hidden" name="fechaEnd" value="<?= $this->input->post('fechaEnd', TRUE) ?>">
													<input type="hidden" name="usuarioVendedor" value="<?= $this->input->post('usuarioVendedor', TRUE) ?>">
													<!-- tipoActividad -->
													<select class="form-control input-sm" name="subRamoActividad" id="subRamoActividad" title="Seleccione el SubRamo de actividades a Monitorear">
														<?
														foreach ($subRamosActivida as $ramosActividad) {
														?>
															<option value="<?= $ramosActividad ?>" <?= ($ramosActividad == $subRamoActividad) ? 'selected="selected"' : '' ?>><?= $ramosActividad ?></option>
														<?
														}
														?>
													</select>
													<?
													if ($ConsultaTipoAct->num_rows() > 0) {
														$totalSubRamo	= count($ConsultaSubRamosAct->result_array());
														$porcentaje		= round(($totalSubRamo / $totalTiposActividades) * 100, 2, 1);
														$refDetalleActivida	= "";
														foreach ($ConsultaSubRamosAct->result_array() as $subRamosActividades) {
															$refDetalleActivida[]	= ''
																. '<tr>'
																. '<td title="' . $subRamosActividades['datosExpres'] . '">'
																. '<font style="font-size:12px;">'
																. $subRamosActividades['folioActividad']
																. '</font>'
																. '</td>'

																. '<td>'
																. '<font style="font-size:10px;">'
																. "<b>FecAlta: </b>" . $subRamosActividades['fechaCreacion']
																. '<br />'
																. "<b>FacActu: </b>" . $subRamosActividades['fechaActualizacion']
																. '</font>'
																. '</td>'

																. '<td>'
																. '<font style="font-size:12px;">'
																. $subRamosActividades['Status_Txt']
																. '</font>'
																. '</td>'
																. '</tr>'
																. '<tr>'
																. '<td>'
																. '</td>'

																. '<td colspan="2">'
																. '<font style="font-size:10px;">'
																. "<b>Creado: </b>" . $subRamosActividades['nombreUsuarioCreacion']
																. '<br />'
																. "<b>Agente: </b>" . $subRamosActividades['nombreUsuarioVendedor']
																. '</font>'
																. '</td>'
																. '</tr>'
																. '<tr style="border-top:solid 2px #FFF;" align="left">'
																. '<td colspan="3">'
																. '<font style="font-size:14px; font-style:italic;">'
																. '<b>&bull;</b> '
																. '<font style="text-decoration:underline;">' . $subRamosActividades['tipoActividad'] . '</font><br />'
																. '</font>'
																. '<font style="font-size:11px;">'
																. " <b>&bull;</b> " . $subRamosActividades['ramoActividad']
																. " <b>&bull;</b> " . $subRamosActividades['subRamoActividad']
																. '</font>'
																. '</td>'
																. '</tr>';
														}
													?>
														<br />
														<div class="row">
															<div class="col-sm-6 col-md-6" align="right">
																<span style="text-align:right">
																	<img src="<?= $graficaPorcen . $porcentaje . "&wdt=30" ?>" title="">
																</span>
															</div>
															<div class="col-sm-6 col-md-6" align="left">
																<table cellpadding="2" cellspacing="0" style="font-size:10px;">
																	<tr align="left">
																		<td><b>Total Actividades:</b></td>
																	</tr>
																	<tr align="right" style="font-size:12px; text-decoration:underline; font-style:italic;">
																		<td><?= $totalActividades ?></td>
																	</tr>
																	<tr align="left">
																		<td><b>Total Tipo <?= $tipoActividades['tipoActividad'] ?>:</b></td>
																	</tr>
																	<tr align="right" style="font-size:12px; text-decoration:underline; font-style:italic;">
																		<td><?= $totalTiposActividades ?></td>
																	</tr>
																	<tr align="left">
																		<td><b>Total <?= ucwords(strtolower($subRamoActividad)) ?>:</b></td>
																	</tr>
																	<tr align="right" style="font-size:12px; text-decoration:underline; font-style:italic;">
																		<td><?= $totalSubRamo ?></td>
																	</tr>
																	<tr align="left">
																		<td><b>% <?= ucwords(strtolower($subRamoActividad)) ?>:</b></td>
																	</tr>
																	<tr align="right" style="font-size:12px; text-decoration:underline; font-style:italic;">
																		<td><?= $porcentaje ?></td>
																	</tr>
																</table>
															</div>
														</div>
														<br /><br />
														<div class="table-responsive">
															<table class="table">
																<tr style="text-decoration:underline;">
																	<td>Folio</td>
																	<td>Fecha</td>
																	<td>Estado</td>
																</tr>
																<?
																foreach ($refDetalleActivida as $refDetalle) {
																	print($refDetalle);
																}
																?>
																<tr>
																	<td></td>
																	<td></td>
																	<td></td>
																</tr>
															</table>
														</div>
													<?
													} /*! if Num_Rows() */
													?>
												</form>
											</div>
											<!--* panel-body -->
										</div>
										<!--* panel panel-default -->
									</div>
									<!--* col-sm-3 col-md-4 -->
								<? } ?>
							</div>
						</div>
					</div>
				</section>

				<!-- -->
			</div>
		</div>
	</div>
</section>



<!--:::::::::: FIN CONTENIDO ::::::::::-->
<?php $this->load->view('footers/footer'); ?>
<script>
	//JQuery
	$("[data-toggle='popover']").popover(
          {
            container: 'body',
			trigger: "focus",
			html: true,
			title: function(){
				var category = $(this).data("category");
				return `Registro de altas en ${category}`;
			},
            template: `
			<div class="popover top-modal" role="tooltip" style="max-width: 100%;">
				<div class="arrow"></div>
				<h3 class="popover-title text-dark"></h3>
				<div class="popover-content">
				</div>
			</div>`,
			content: function(){
				var category = $(this).data("category");
				var training = $(this).data("training");
				var subtraining = $(this).data("subtraining");
				var idPersona = $(this).data("id");
				$(`.body-content`).html(``);
				//console.log(parameter);
				$.ajax({
					method: "GET",
					url: `${$(this).data("url")}miInfo/getDatesAndHours`,
					data:{
						i: idPersona
					},
					error: function(error){
						console.log(error);
					},
					success: function(data){

						var resp = JSON.parse(data);
						//console.log(resp);
						var content_ = ``;
						//console.log(resp[training][subtraining][category]);
						var selectedKey = resp[training][subtraining][category];
						var rows = selectedKey.reduce((acc, cur) => {

							var date_ = cur.registerDate.split("-");
							var attachment = ``;
							if(cur.type == "interno"){
								//curr.content
								var dateT = cur["content"][0].fechaCompromiso.split("-");
								attachment = `<div style="padding-left: 3px">Capacitación: ${dateT[2]+"-"+dateT[1]+"-"+dateT[0]}</div>`;
							} else if(cur.type == "externo"){
								attachment = `<div style="padding-left: 3px">Archivo: ${cur.content.archivo}</div>`;
							}
							acc += `
								<div class="border border-dark mb-3" style="padding-left: 5px;">
									<div>Alta: <span class="inf-training">${date_[2]+"-"+date_[1]+"-"+date_[0]}</span></div>
									<div>Horas: <span class="inf-training">${cur.hours}</span></div>
									<div>Tipo: <span class="inf-training">${cur.type.toUpperCase()}</span></div>
									<div>Anexo: <span class="inf-training"><br>${attachment}</span></div>
								</div>
							`;
							return acc;
						}, "");

						//console.log(rows);
						$(`.body-content`).html(rows);
					}
				});

				return `<div class="body-content table-responsive" style="height: 150px; overflow-y: scroll"></div>`;
			},
       });
	
    $(".metas_comerciales").each(function(e){

		var nombre_tabla = $(this).data("table");
		var filas = $("#"+nombre_tabla+" tbody tr");
		var fecha = new Date();
		//console.log(nombre_tabla);
		filas.each(function(){
			var mes = $(this).find("td").eq(0).first().text(); //.html();
			var meta = $(this).find("td").eq(2).find("div").first().text().replace("$","").replace(",",""); //.html().replace("$","").replace(",","");
			var avance = $(this).find("td").eq(3).find("div").first().text().replace("$","").replace(",",""); //.html().replace("$","").replace(",","");

			if(mes < fecha.getMonth() + 1){
				
				var insert_class = parseInt(meta) < parseInt(avance) ? "success" : "danger";

				$(this).find("td").eq(1).addClass("text-"+insert_class);
				$(this).find("td").eq(2).addClass("text-"+insert_class);
				$(this).find("td").eq(3).addClass("text-"+insert_class);
				$(this).find("td").eq(4).addClass("text-"+insert_class);

			}
		});
	});
	
</script>
<script>

	//document.getElementById("tableMetaAnual").innerHTML="<?php //echo $row; ?>";

	var fechaStart =
		$('.fechaStart').datepicker({
			format: "yyyy-mm-dd",
			startDate: "",
			language: "es",
			autoclose: true
		});

	var fechaEnd =
		$('.fechaEnd').datepicker({
			format: "yyyy-mm-dd",
			startDate: "",
			language: "es",
			autoclose: true
		});

	$('#GenerarMonitor').click(function(e) {
		if ($('#filtroFechasChec').prop('checked') == true) {
			$('#filtroFechas').val('si');
			$('#mesActividades').val('13');
		} else if (filtroFecha == false) {
			$('#filtroFechas').val('');
		}
	});

	$('#mesActividades').change(function(e) {
		$('#filtroFechas').val('');
		$('#filtroFechasChec').prop('checked', '');
	});

	$('#tipoActividad').change(function(e) {
		document.formTipoActividades.submit();
	});

	$('#formDetalleActividades').change(function(e) {
		document.formDetalleActividades.submit();
	});
</script>


<?
function imprimirProspectos2($prospectos){
    $i=0;
    foreach ($prospectos as $key => $value) {
        $nombre[$i]=$key;
        $valor[$i]=count($value);
        $i++;
    }
    $div='<style type="text/css">.funnel{width: 100%;background-color: #fff;height: auto;padding: 2%;font-family: arial;color: #fff;font-weight: bold;font-size: 14px;text-align: center;}.suspecto, .perfilado, .contactado, .contactado, .cotizado, .emitido, .pagado{margin-bottom:4px;height: 40px;border-radius: 0px 0px 7px 7px;padding-top: 5px;}.suspecto{width: 90%;background-color: #2e5082;}.perfilado{width: 80%;background-color: #3c5e90;margin-left: 5%;}.contactado{width: 70%;background-color: #48699a;margin-left: 10%;}.cotizado{width: 60%;background-color: #5777a6;margin-left: 15%;}.emitido{width: 50%;background-color: #6280ad;margin-left: 20%;}.pagado{width: 40%;background-color: #718ebb;margin-left: 25%;}.badge{background-color: #fff;color:#000;font-size:14px;}</style><div class="funnel"><div class="suspecto"><div class="badge badge-success">'.$valor[0].'</div>   '.$nombre[0].'</div><div class="perfilado"><div class="badge badge-success">'.$valor[1].'</div>   '.$nombre[1].'</div><div class="contactado"><div class="badge badge-success">'.$valor[2].'</div>   '.$nombre[2].'</div><div class="cotizado"><div class="badge badge-success">'.$valor[3].'</div>   '.$nombre[3].'</div><div class="emitido"><div class="badge badge-success">'.$valor[4].'</div>   '.$nombre[4].'</div><div class="pagado"><div class="badge badge-success">'.$valor[5].'</div>   '.$nombre[5].'</div></div>';
    return $div;
}

function imprimirProspectos($prospectos)
{
	$div = '<ul class="nav nav-pills nav-stacked" style="max-width: 260px;">';
	foreach ($prospectos as $key => $value) {
		$div .= '<li  class="active"><a><span class="badge pull-right""> ' . count($value) . '</span>' . $key . '</a><br>';
	}
	return $div;
}
?>


<!--EVALUACIONES-->
<div id="mdDetail" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="mdDetailLabel">
	<div class="modal-dialog modal-lg" role="document">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
				<h4 class="modal-title" id="myModalLabel">Modal title</h4>
			</div>
			<div class="modal-body">
				...
			</div>
			<div class="modal-footer">
				<button type="button" class="btn btn-default" data-dismiss="modal">Cancelar</button>
			</div>
		</div>
	</div>
</div>

<!--Modales prestamos y vacaciones-->

<div id="modalPrestamos" class="modal" role="dialog">
  <div class="modal-dialog" role="document">
    <!-- Modal content-->
   <div class="modal-content" style="width:120%;margin-left:-10%;">
      <div class="modal-header">
        <h4 class="modal-title"  id="myModalLabel"><i class="fa fa-money"></i>&nbsp;Solicitud de prestamo u ahorro</h4>
      </div>
      <div class="modal-body">
        <table border="0" style="width:100%;margin-bottom: 5%;">
        <tr>
            <td><i class="fa fa-user"></i>&nbsp;Nombre Empleado</td>
            <td><b><? echo $miInfo_Datos->nombres.' '.$miInfo_Datos->apellidoPaterno . ' ' . $miInfo_Datos->apellidoMaterno; ?></b></td>
        </tr>
        <tr>
            <td><i class="fa fa-user"></i>&nbsp;Cargo:</td>
            <?php $cargo=$this->personamodelo->puestoDePersona($this->tank_auth->get_idPersona());?>
            <td><b><?php echo $cargo[0]->personaPuesto;?></b></td>
        </tr>
         <tr>
            <td><i class="fa fa-calendar"></i>&nbsp;Fecha de Solicitud:</td>
            <td><?php echo date('d-m-Y');?></td>
        </tr>
        <tr>
            <td><i class="fa fa-tag"></i>&nbsp;Tipo de Solicitud::</td>
            <td>
            	<select name="tipo" id="tipo" class="form-control" onchange="openOption()">
            		<option value="0"></option>
            		<option value="1">PRESTAMO</option>
            		<option value="2">AHORRO</option>
            	</select>
            </td>
        </tr>
        </table>
        	<!--div para prestamos-->
        	<form name="frmprestamo" id="frmprestamo" method="post" action="<?php echo base_url()?>fastFile/guardar_solicitud_prestamo">
  		<input type="hidden" name="idPersona" id="idPersona" value="<?php echo $this->tank_auth->get_idPersona();?>">
	        <div class="well" style="background-color: #fff;display: none;width: 100%;height: auto;" id="dataPrestamo">
		        <table border="0" style="width:100%;">
		        <tr>
		            <td><i class="fa fa-money"></i>&nbsp;Cantidad a solicitar:</td>
		            <td><input type="text" id="monto" name="monto" class="form-control" style="width:200px;text-align:right;" placeholder="0,00 MXN"></td>
		        </tr>
		            <tr><td colspan="4">&nbsp;</td></tr>
		            <tr>
		                <td colspan="4" style="text-align: right;">
		                  <button type="button" class="btn btn-primary" onclick="guardar_solicitud_prestamo()"><i class="fa fa-check"></i>&nbsp;Enviar Solicitud</button>
		                </td>
		            </tr>
		        </table>
		        <div style="margin-bottom: -3%;"><i class='fa fa-tag'></i> Tipo de Solicitud: <b>Prestamo</b></div>
		</div>
		</form>
		<!--fin div prestamos-->

		<!--div para Ahorros-->
		<form name="frmahorro" id="frmahorro" method="post" action="<?php echo base_url()?>fastFile/guardar_solicitud_ahorro">
 		 <input type="hidden" name="idPersona" id="idPersona" value="<?php echo $this->tank_auth->get_idPersona();?>">
	        <div class="well" style="background-color: #fff;display: none;width: 100%;height: auto;" id="dataAhorro">
		        <table border="0" style="width:100%;">
		        <tr>
		            <td><i class="fa fa-money"></i>&nbsp;Monto mensual a descontar de su Nomina:</td>
		            <td><input type="text" id="montoAhorro" name="montoAhorro" class="form-control" style="width:200px;text-align:right;" placeholder="0,00 MXN"></td>
		        </tr>
		            <tr><td colspan="4">&nbsp;</td></tr>
		            <tr>
		                <td colspan="4" style="text-align: right;">
		                  <button type="button" class="btn btn-primary" onclick="guardar_solicitud_ahorro()"><i class="fa fa-check"></i>&nbsp;Enviar Solicitud</button>
		                </td>
		            </tr>

		            <tr>
		            	<td colspan="4">&nbsp;</td>
		            </tr>
		            <tr>
		            	<td colspan="4">
		            		<div class="alert alert-info">
		            			<p>
		            				<b>NOTA: </b>
		            				EL MONTO MINIMO APROBADO ES EL <b>3%</b> Y MAXIMO EL <b>5%</b> SOBRE EL SUELDO MENSUAL.
		            			</p>

		            		</div>
		            	</td>
		            </tr>
		        </table>
		        <div style="margin-bottom: -3%;"><i class='fa fa-tag'></i>Tipo de Solicitud: <b>Ahorro</b></div>
		</div>
		</form>
		<!--fin div Ahorros-->
          </div>
          <div class="modal-footer">
          	 <button type="button" class="btn btn-warning" data-dismiss="modal" style="color: #fff;"><i class="fa fa-times-circle"></i> Cerrar</button>
          </div>
      </div>
    </div>
  </form>
</div>

<?php if($vacations["canRequestVacation"]){?>
<div id="modalVacaciones" class="modal" role="dialog">
  <form name="frmvacaciones" id="frmvacaciones" method="post" action="<?php echo base_url()?>fastFile/guardar_solicitud_vacaciones" enctype="multipart/form-data">
  <!--<input type="hidden" name="idPersona" id="idPersona" value="<?php echo $this->tank_auth->get_idPersona();?>">-->
  <input type="hidden" name="antiguedad" id="antiguedad" value="<?= $vacations["period"] ?>">
  <input type="hidden" name="applyPastPeriods" id="apply-past-periods" value="false">
  <div class="modal-dialog">
    <!-- Modal content-->
   <div class="modal-content" style="width:120%;margin-left:-10%;">
      <div class="modal-header">
        <h4 class="modal-title"  id="myModalLabel"><i class="fa fa-plane"></i>&nbsp;Solicitud de vacaciones</h4>
      </div>
      <div class="modal-body">
        <table border="0" style="width:100%;">
        <tr>
            <td style="width: 30%;"><i class="fa fa-user"></i>&nbsp;Nombre del Colaborador:</td>
            <td><b><? echo $miInfo_Datos->nombres.' '.$miInfo_Datos->apellidoPaterno . ' ' . $miInfo_Datos->apellidoMaterno; ?></b></td>
        </tr>
        <tr>
            <td><i class="fa fa-user"></i>&nbsp;Puesto:</td>
            <?php $cargo=$this->personamodelo->puestoDePersona($this->tank_auth->get_idPersona());?>
            <td><b><?php echo $cargo[0]->personaPuesto;?></b></td>
        </tr>
		<tr>
			<td><i class="fa fa-exclamation-circle" aria-hidden="true"></i> Importante identificar: </td>
			<td>
				<div>
					<div class="mt-2">Color <i class="fa fa-calendar-o" aria-hidden="true" style="color: #4CAB4A"></i> - Fecha de cambio de periodo.</div>
					<div class="mt-2">Color <i class="fa fa-calendar-o" aria-hidden="true" style="color: #2E86C1"></i> - Dias aprobados o pendientes.</div>
				</div>
			</td>
		</tr>
		<tr>
			<td><i class="fa fa-clock-o" aria-hidden="true"></i> Próxima fecha de cambio de periodo</td>
			<td><input type="text" name="periodchangeDate" class="form-control" value="<?=$vacations["changeDate"]?>" readonly style="background-color: transparent; border: 0px; width:200px;"></td>
		</tr>
        <tr>
            <td><i class="fa fa-calendar"></i>&nbsp;Primer dia de Ausencia:</td>
            <td>
				<!--<input type="date" class="form-control" name="fecha_salida" id="fecha_salida" style="width:200px;">-->
				<input type="text" placeholder="Seleccione una fecha"  id="datepicker-vacations" name="firstVacationDay" class="form-control" style="width:200px; background-color: transparent; border: 0px; cursor: pointer;" readonly required>
			</td>
        </tr>
		<tr>
            <td><i class="fa fa-calendar"></i>&nbsp;Fecha de retorno:</td>
            <td>
				<!--<input type="date" class="form-control" name="fecha_salida" id="fecha_salida" style="width:200px;">-->
				<input type="hidden" id="return-to-work-hidden" class="form-control" style="background-color: transparent; border: 0px; width:200px;" readonly>
				<input type="text" id="return-to-work" class="form-control" style="background-color: transparent; border: 0px; width:200px;" readonly>
			</td>
        </tr>
		<?php if($vacations["requestPastPeriods"]){

			$dateArr = explode("-", $vacations["initialDate"]);
			$fy = new DateTime("2022-".$dateArr[1]."-".$dateArr[2]);
			$fiy = new DateTime(str_replace("/", "-", $vacations["changeDate"]));
			$diff = $fiy->diff($fy);
		?>
		<tr>
			<td><i class="fa fa-calendar-plus-o" aria-hidden="true"></i>&nbsp;Periodo acumulado</td>
			<td>
				<select id="vacations-periods" class="form-control" style="width: 200px">
				<?php 
					for($i = $vacations["period"]; $i >= ($vacations["period"] - $diff->y); $i--){ ?>
						<option value="<?php echo $i;?>" data-pending="<?= $i == $vacations["period"] ? "true" : "false"?>"><?php echo $i;?></option>
				<?php }?>
				</select>
			</td>
		</tr>
		<?php }?>
        <tr>
            <td><i class="fa fa-calendar-plus-o" aria-hidden="true"></i>&nbsp;Cantidad de diás:</td>
            <td>
				<select name="countDays" id="cantidad_dias" class="form-control mt-2" style="width: 200px;" required>
					<?php for($i=1;$i<$restan+1;$i++){?>
						<option value="<?php echo $i;?>"><?php echo $i;?></option>
					<?php }?>
				</select>
            </td>
        </tr>
		<tr>
			<td>
				<i class="fa fa-upload" aria-hidden="true"></i>&nbsp; Carga de formato de solicitud
			</td>
			<td><input type="file" name="uploadFormatVacation" id="upload-format-vacations" required></td>
		</tr>
        <tr><td colspan="4">&nbsp;</td></tr>
            <tr><td colspan="4"><hr></td></tr>
            <tr><td colspan="4">&nbsp;</td></tr>
        
            <tr>
                <td colspan="4" style="text-align: right;">
                <button type="button" class="btn btn-primary" data-dismiss="modal"><i class="fa fa-times"></i>Cerrar</button>
                <button type="submit" class="btn btn-primary" ><i class="fa fa-check"></i>&nbsp;Enviar Solicitud</button> <!-- onclick="guardar_solicitud_vacaciones()" -->
                </td>
            </tr>
        </table>
          </div>
      </div>
    </div>
  </form>
</div>
<?php }?>

<div class="js-incidencias"></div>
<div class="md-detalle"></div>
<div id="bonos-container"></div>
<div class="modal-seguimiento-container"></div>
<div id="base_url" class="container-fluid" data-base-url="<?= base_url() ?>"></div>


<!--Modal de para ver evaluaciones posteriores || Miguel Avila -->
<div id="mEvalAnterior" class="modal" tabindex="-1" role="dialog" data-backdrop="false">
	<div class="modal-dialog modal-lg" style="max-width: 80vw!important;" role="document">
		<div class="modal-content">
			<div class="modal-header">
				<h5 class="modal-title">Evaluaciones Anteriores</h5>
				<button type="button" class="close" data-dismiss="modal" aria-label="Close">
					<span aria-hidden="true">&times;</span>
				</button>
			</div>
			<div class="modal-body">
				<div class="row">
					<div class="col-lg-12">
						<p><i>Nota: solo se muestran las últimas 5 evaluaciones posteriores con referencia al usuario</i></p>
					</div>
					<div class="col-lg-12" id="renderContent">

					</div>
				</div>
			</div>
			<div class="modal-footer">
				<button type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button>
			</div>
		</div>
	</div>
</div>

<script>
	const _empleados = <?= json_encode($_empleados) ?>;
	const _puestos = <?= json_encode($_puestos) ?>;
	var url = document.location.toString();
	if (url.match('#')) {
		$('.nav-tabs a[href="#' + url.split('#')[1] + '"]').tab('show');
	}
</script>
<script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>
<script>
    function guardar_solicitud_prestamo(){
        var monto=document.getElementById('monto').value;
        if(monto!=''){
            var op=confirm("¿Esta seguro(a) de la cantidad a solicitar, dicho prestamo estara sujeto a aprobacion por parte de la administración?");
            if(op==1){
                document.getElementById('frmprestamo').submit();
            }
        }else{
                swal("Validación solicitud prestamo", "Debe ingresar al menos una cantidad a solicitar");
        }
    }

     function guardar_solicitud_ahorro(){
        var monto=document.getElementById('montoAhorro').value;
        if(monto!=''){
            var op=confirm("¿Esta seguro(a) de la cantidad a ahorrar, dicho monto estara sujeto a aprobación por parte de la administración?");
            if(op==1){
                document.getElementById('frmahorro').submit();
            }
        }else{
        	 swal("Validación solicitud ahorro", "Debe ingresar al menos una a solicitar");
        }
    }

    function guardar_solicitud_vacaciones(){ //Función obsoleta por Dennis Castillo [2022-06-28]
        var fecha_salida=document.getElementById('fecha_salida').value;
		var fileVacation = document.getElementById("upload-format-vacations").value;
		//------------------------------
		//Dennis [2021-09-10]
		var date = fecha_salida.split("-");
		var date_ = new Date(date[0], date[1] - 1, date[2]);
		var day = date_.getDay();
		var invalidateDays = [6,0];
		//var holydays = [`${date[0]}-01-01`, `${date[0]}-02-01`, `${date[0]}-03-15`, `${date[0]}-05-01`, `${date[0]}-09-16`, `${date[0]}-11-15`, `${date[0]}-12-25`];
		var holydays = [`${date[0]}-01-01`, `${date[0]}-02-07`, `${date[0]}-03-21`, `${date[0]}-05-01`, `${date[0]}-09-16`, `${date[0]}-11-21`, `${date[0]}-12-25`];

		if(invalidateDays.includes(day)){
			 swal("Validación solicitud de vacaciones", "No se puede escoger una fecha dentro del fin de semana. Intenta con dias de Lunes a Viernes");
			return false;
		}  else if(holydays.includes(fecha_salida)){
			swal("Validación solicitud de vacaciones", "La fecha que seleccionó es considerada como festivo (día no laborado)");
			return false;
		}
		//-----------------------------

        if(fecha_salida!='' && fileVacation.length > 0){
            var op=confirm("¿Esta seguro(a) de los datos de solicitud?");
            if(op==1){
                //document.getElementById('frmvacaciones').submit();
            }
        }else{
        	swal("Validación solicitud de vacaciones", "Debe seleccionar una fecha de salida y una de retorno. De igual manera, adjuntar el formato de solicitud");
        }
    }

</script>
<script>
	//Dennis Castillo 2021-09-24
	document.getElementById("trainingCategory").addEventListener("change", function(){
		
		var selectedIndex = this.value;
		var containers = document.getElementsByClassName("training-container");

		for(var a = 0; a < containers.length; a++){
			//console.log(containers[a]);
			if(containers[a].id == selectedIndex){
				containers[a].classList.replace("hidden", "show");
			} else{
				containers[a].classList.replace("show", "hidden");
			}
		}

		//console.log(containers);
	})
</script>
<!--------------------------------------------------------------------------------------------------------------------------------->
<script type="text/javascript" src="<?= base_url() ?>assets/gap/js/datatables.min.js"></script>
<script type="text/javascript" src="<?= base_url() ?>assets/js/fileupload/public/bundle-modal-seguimiento.js"></script>
<script type="text/javascript" src="<?= base_url() ?>assets/js/fileupload/public/bundle-bonos.js"></script>
<script type="text/javascript" src="<?= base_url() ?>assets/js/fileupload/public/bundle-incidencias.js"></script>
<script type="text/javascript" src="<?= base_url() ?>assets/gap/js/personas.profile.js"></script>
<script type="text/javascript" src="<?= base_url() ?>assets/js/jquery.vacations.js"></script> <!-- Dennis Castillo [2022-06-16] -->
<!--EVALUACIONES FIN-->
<!--Modificacion 09-12-2021 MJ-->
<script type="text/javascript">
	function openOption() {
		var op=document.getElementById('tipo').value;
		if(op==1){
			document.getElementById('dataPrestamo').style.display='block';	
			document.getElementById('dataAhorro').style.display='none';
		}
		if(op==2){
			document.getElementById('dataPrestamo').style.display='none';	
			document.getElementById('dataAhorro').style.display='block';
		}
		
	}
</script>
<!--Fin Modificacion-->

<!--Cambios Miguel Avila -->
<script type="text/javascript" src="<?= base_url() ?>assets/gap/js/modal_anteriores.js"></script>
<script>
	function clickDeletePIP(id){
		swal({
                title: "¿Está seguro de que quiere eliminar el registro seleccionado?",
                text: "Una vez eliminado, ¡no podrá recuperar el elemento!",
                icon: "warning",
                buttons: ["Cancelar", "Aceptar"],
            }).then((value) => {
                if (value) {
                    $.ajax({
                        type: 'POST',
                        url: `<?= base_url() ?>PIP/Delete`,
                        data: {
                            id: id,
                        },
                        success: function (data) {
							//alert('correct')
                            //elemino el elemento
                            $(`#PIP_${id}`).remove();
                            toastr.success("Accion realizada con éxito.");
                            //datatable.ajax.reload();
                        },
                        error: function (data) {

                        }
                    });
                }
            });
	}
</script>
