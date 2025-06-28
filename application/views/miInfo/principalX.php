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

$inicioEmplreado			= strtotime($miInfo_Datos->fechaAltaPersona);
$hoy 						= strtotime(date("Y-m-d"));
$tipoRestanteProvisional	= intval(($hoy - $inicioEmplreado) / (24 * 60 * 60)); // /(365.25 * 24 * 60 * 60 * 1000);

//[Dennis]
$tiempoAnioActivo=intval($tipoRestanteProvisional/(365.25)); //cantidad de años

$fecha_iniEmpleado=explode("-",$miInfo_Datos->FechaIniEmpl); //prueba_xd
$punto_partinda_despues_anio=date("Y-m-d", mktime(0,0,0,$fecha_iniEmpleado[1],$fecha_iniEmpleado[2],$fecha_iniEmpleado[0]+$tiempoAnioActivo));
$dia_ii=strtotime($punto_partinda_despues_anio);
$dia_ac=date("Y-m-d"); //strtotime(date("Y-m-d"));
$_almacena_meses=array();

$__ff1= new DateTime($miInfo_Datos->FechaIniEmpl);
$__ff2= new DateTime($dia_ac);

$df=$__ff1->diff($__ff2);

$contador_meses_dias=0;
$contador_semanas_dias=0;
$contador_resto_dias=0;
$contador_diferencia_dias=0;

$contador_meses_dias=intval($df->m);
$contador_semanas_dias=intval($df->d / 7);
$contador_resto_dias=($df->d >= 7) ? intval($df->d % ($contador_semanas_dias*7)): $df->d;

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
<style>
.modal{
    position: fixed;
    top: 0;
    left: 0;
    width: 100%;
    height: 100%;
    z-index: 1050;
}
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
														<td><?=$meses[$mes]?></td>
														<td>$<?=number_format($reg["monto_mes"])?></td>
														<td>$<?=number_format($reg["comision_venta_nueva"])?></td>
														<td><?=number_format($porcentaje_unitario)?>%</td>
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
				<!--Modificaciones MJ-->
				<!--Liberacion sujeta a autorizacion-->
		                <!--<li role="presentation"><a href="#prestamos" aria-controls="prestamos" role="tab" data-toggle="tab">Prestamos</a></li>
		                <li role="presentation"><a href="#vacaciones" aria-controls="vacaciones" role="tab" data-toggle="tab">Vacaciones</a></li>-->
<?php   if ($es_empleado == 1) 
        { ?>
				<!--<li role="presentation" class="active"><a href="#profile" aria-controls="profile" role="tab" data-toggle="tab">Perfil</a></li>-->
				<li role="presentation"><a href="#incidencias" aria-controls="incidencias" role="tab" data-toggle="tab">Incidencias</a></li>
				<li role="presentation"><a href="#evaluaciones" aria-controls="evaluaciones" role="tab" data-toggle="tab">Evaluaciones</a></li>
				<!--<li role="presentation"><a href="#capacitacion" aria-controls="otros" role="tab" data-toggle="tab">Capacitación</a></li>-->
				
                
                <li role="presentation"><a href="#otros" aria-controls="otros" role="tab" data-toggle="tab">Otros</a></li>
                
				<!--<li role="presentation"><a href="#metaasig" aria-controls="metaasig" role="tab" data-toggle="tab">Metas asignadas</a></li>-->
				<!-- <li role="presentation" class="pull-right dropdown">
					<a class="dropdown-toggle" data-toggle="dropdown" href="#" role="button" aria-haspopup="true" aria-expanded="false">
						Periodo <?= $periodoName ?><span class="caret"></span>
					</a>
					<ul class="dropdown-menu">
						<?php foreach ($periodos as $key => $value) : ?>
							<li><a href="<?= base_url() . "miInfo/?periodo=$value[id]" ?>"><?= $value["titulo"] ?></a></li>
						<?php endforeach; ?>
					</ul>
				</li> -->
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
										<p><b>Años: <?=$tiempoAnioActivo?> Meses: <?php echo $contador_meses_dias;//$mesActivo;?> Semanas: <?php echo $contador_semanas_dias;//$semana?>
										   Dias: <?php echo $contador_resto_dias;
										    //$diaContable=0;
											//$meses30=array(4,6,9,11);
											//$meses31=array(1,3,5,7,8,10,12);
											//$meses28=array(2);
										   //if(in_array($mesHoy, $meses31)){echo $diaContable=intval(($dias-(30*($mesActivo))-(7*$semana))-$mes31);}
										   //elseif(in_array($mesHoy, $meses30)){echo $diaContable=intval(($dias-(30*($mesActivo))-(7*$semana))-$mes30);}
										   //elseif(in_array($mesHoy, $meses28)){echo $diaContable=intval(($dias-(28*($mesActivo))-(7*$semana))-$mes28);}
										   ?><br> Hrs: <?php echo $df->h;//$hora=($diaContable*24)-date('H')." hrs";?></b></p>
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
									<p><b>Estado civil:</b> <? 
									
									$ed_civil="N/A";
									if(!empty($miInfo_Datos->estadoCivil)){
										$ec=$this->personamodelo->obtenerUnEstadoCivil($miInfo_Datos->estadoCivil);
										$ed_civil=$ec[0]->estadoCivil;
									}

									//$ec=$this->personamodelo->obtenerUnEstadoCivil($miInfo_Datos->estadoCivil);
									echo $ed_civil; //$ec[0]->estadoCivil; ?></p>
								</div>
								<div class="col-md-6 col-sm-6">
									<p><b>Nombre:</b> <? echo $miInfo_Datos->nombres; ?></p>
									<p><b>Apellido:</b> <? echo $miInfo_Datos->apellidoPaterno . ' ' . $miInfo_Datos->apellidoMaterno; ?></p>
									<p><b>Fecha nac.:</b> <? echo $miInfo_Datos->fechaNacimiento; ?></p>
									<p><b>Lugar nac.:</b> <? echo $miInfo_Datos->estadoNacimiento." ".$miInfo_Datos->municipioNacimiento." ".$miInfo_Datos->paisNacimiento; ?></p>
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
				<div class="col-md-12">
					<p class="h4"><i class="fa fa-clock-o" aria-hidden="true"></i> Capacitación</p><hr />
					<div class="panel panel-info">
						<div class="panel-heading"><h5>Registro de horas de capacitación</h5></div>
						<div class="panel-body">
						<input type="hidden" name="idPersona" id="idPersona" value="<?=$this->tank_auth->get_idPersona()?>">
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
									<tbody id="cuerpoContenido"> <!--aqui-->
										<!--<?php ?>-->
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
											<!--<th class="text-center">SUMATORIA DE HORAS</th>-->
										</tr>
									</thead>
									<tbody id="cuerpoContenidoMensual"></tbody>
								</table>
							</div>
						</div>
					</div>
					<!--<table id="tablaCapacitacion" class="table">
						<thead>
							<tr>
								<th>Categoria</th>
								<th>Sub-categoria</th>
							</tr>
						</thead>
							<?php var_dump($capacitacion);?>
						<thead>
							<tr style="text-align: center; color:white" >
								<td>Meses</td><td>Profesional</td><td>Autos</td><td>Daños</td><td>Fianzas</td><td>GMM</td><td>Vida</td><td>Total</td>
							</tr>
						</thead>
								<tbody>
									<?php
									//[Dennis 2020-05-03]
									$sumaTotal=0;
									for($i=1;$i<13;$i++){
										$flag=false;
										for($j=0;$j<count($capacitacion);$j++){
											if($i==$capacitacion[$j]->mes && $capacitacion[$j]->anio==date("Y")) {
												$sumaTotal=$capacitacion[$j]->certificacion+$capacitacion[$j]->certificacionAutos+$capacitacion[$j]->certificacionGmm+$capacitacion[$j]->certificacionFianzas+$capacitacion[$j]->certificacionDanos+$capacitacion[$j]->certificacionVida;
												$flag=true; 
									?>
										<tr>
											<td style="text-align:center"><?=$meses[$i]?></td>
											<td style="text-align:center"><?=$capacitacion[$j]->certificacion?></td>
											<td style="text-align:center"><?=$capacitacion[$j]->certificacionAutos?></td>
											<td style="text-align:center"><?=$capacitacion[$j]->certificacionGmm?></td>
											<td style="text-align:center"><?=$capacitacion[$j]->certificacionFianzas ?></td>
											<td style="text-align:center"><?=$capacitacion[$j]->certificacionDanos ?></td>
											<td style="text-align:center"><?=$capacitacion[$j]->certificacionVida ?></td>
											<td style="text-align:center"><b><?=$sumaTotal ?></b></td>
										</tr>
									<?php } ?>
									<?php }
									if($flag==false){ ?>
										<tr>
											<td style="text-align:center"><?=$meses[$i]?></td>
											<td style="text-align:center">0</td>
											<td style="text-align:center">0</td>
											<td style="text-align:center">0</td>
											<td style="text-align:center">0</td>
											<td style="text-align:center">0</td>
											<td style="text-align:center">0</td>
											<td style="text-align:center"><b>0</b></td>
										</tr>
									<?php } }?>
									</tbody>
								</table>-->
							</div>
			<!--------------------------------------------------------------------------------------------------->
						<div class="col-md-12">
							<p class="h4"><i class="fa fa-file-text"></i> Prospeccion de Negocios</p>
							<hr />
						</div>
						<div class="col-md-6">
							<div class="row">
								<?= imprimirProspectos2($prospectos); ?>
							</div>
						</div>
					</div>
				</div>
<?php   if ($es_empleado == 1) 
        { ?>
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
				<div role="tabpanel" class="tab-pane" id="evaluaciones">
					<div class="row">
						<div class="col-md-12">
							<!-- cambios TIC_Consultores 17/03/2021 -->
							<div style="float:right; with">
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
							<p class="h4"><i class="fa fa-file-text"></i> Mi evaluación</p>
							<hr />
						</div>
						<div class="col-md-12">
							<?= $this->load->view("evaluaciones/personas/mi_evaluacion") ?>
						</div>
						<div class="col-md-12">
							<p class="h4"><i class="fa fa-file-text"></i> Pendientes por responder</p>
							<hr />
						</div>
						<div class="col-md-12">
							<?= $this->load->view("evaluaciones/personas/evaluaciones_pendientes") ?>
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
					<div class="row">
						<div class="col-md-12">
							<p class="h4"><i class="fa fa-file-text"></i> Seguimiento performance improvement plan</p>
							<hr />
						</div>
						<div class="col-md-12">
							<?= $this->load->view("evaluaciones/personas/mis_pip") ?>
						</div>
					</div>
				</div>
        

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



<!--Modificaciones MJ-->
<div role="tabpanel" class="tab-pane" id="prestamos">
    <div class="row">
        <div class="col-md-10">
            <p class="h4"><i class="fa fa-file-text"></i> Solicitud de prestamos</p>
        </div>
        <div class="col-md-2">
            <a href="#" data-toggle="modal" data-target="#modalPrestamos"><button class="btn btn-primary btn-sm btn pull-right">Solicitar</button></a>
        </div>
    </div>
     <hr />
    <div class="row">
        <div class="col-md-12">
            <?php $this->load->view("miInfo/prestamos");?>
            <div class="alert alert-info"><i class="fa fa-info-circle"></i>&nbsp;Este Modulo se encuentra en desarrollo</div>
        </div>
    </div>
</div>

<?php
  $diasSolicitados=$diasSolicitados[0]->dias;
  $restan=$diasVacaciones-$diasSolicitados;
?>
<div role="tabpanel" class="tab-pane" id="vacaciones">
    <div class="row">
        <div class="col-md-10">
            <p class="h4"><i class="fa fa-file-text"></i> Solicitud de vacaciones</p>
        </div>
        <div class="col-md-2">
        <?php if($restan>0){?>
            <a href="#" data-toggle="modal" data-target="#modalVacaciones">
                <button class="btn-primary btn-sm btn pull-right">Solicitar</button>
            </a>
        <?php }?>
        </div>
    </div>
     <hr />
    <div class="row">
        <div class="col-md-12">
            <?php $this->load->view("miInfo/vacaciones");?>
            <div class="alert alert-info" style="padding-left: 50px;"><i class="fa fa-info-circle"></i> <b>Nota:</b> Actualmente Ud. posee <b><?=$antiguedad?></b> años de antiguedad en la empresa, le corresponde del año en curso (<?php echo date('Y');?>) lo siguente:<br>
                <ul>
                <li>Dias de Vacaciones: <b><?php echo $diasVacaciones;?></b></li>
                <li>Dias aprobados ó pendientes por aprobar: <b><?php echo $diasSolicitados;?></b></li>
                <li>Le Resta: <b><?php echo ($restan);?></b> dia(s) para vacacionar</li>
                </ul>
            </div>
        </div>
    </div>
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
    $(".metas_comerciales").each(function(e){

		var nombre_tabla = $(this).data("table");
		var filas = $("#"+nombre_tabla+" tbody tr");
		var fecha = new Date();
		//console.log(nombre_tabla);
		filas.each(function(){

			var mes = $(this).find("td").eq(0).html();
			var meta = $(this).find("td").eq(2).html().replace("$","").replace(",","");
			var avance = $(this).find("td").eq(3).html().replace("$","").replace(",","");

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
  <form name="frmprestamo" id="frmprestamo" method="post" action="<?php echo base_url()?>fastFile/guardar_solicitud_prestamo">
  <input type="hidden" name="idPersona" id="idPersona" value="<?php echo $this->tank_auth->get_idPersona();?>">
  <div class="modal-dialog">
    <!-- Modal content-->
   <div class="modal-content" style="width:120%;margin-left:-10%;">
      <div class="modal-header">
        <h4 class="modal-title"  id="myModalLabel"><i class="fa fa-money"></i>&nbsp;Solicitud de prestamo</h4>
      </div>
      <div class="modal-body">
        <table border="0" style="width:100%;">
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
            <td><i class="fa fa-calendar"></i>&nbsp;Fecha de solicitud:</td>
            <td><?php echo date('d-m-Y');?></td>
        </tr>
        <tr>
            <td><i class="fa fa-money"></i>&nbsp;Cantidad a solicitar:</td>
            <td><input type="text" id="monto" name="monto" class="form-control" style="width:200px;text-align:right;" placeholder="0,00 MXN"></td>
        </tr>
            <tr><td colspan="4">&nbsp;</td></tr>
            <tr><td colspan="4"><hr></td></tr>
            <tr><td colspan="4">&nbsp;</td></tr>
            <tr>
                <td colspan="4" style="text-align: right;">
                 <button type="button" class="btn btn-primary" data-dismiss="modal"><i class="fa fa-times"></i>Cerrar</button>
                  <button type="button" class="btn btn-primary" onclick="guardar_solicitud_prestamo()"><i class="fa fa-check"></i>&nbsp;Enviar Solicitud</button>
                </td>
            </tr>
        </table>
          </div>
      </div>
    </div>
  </form>
</div>



<div id="modalVacaciones" class="modal" role="dialog">
  <form name="frmvacaciones" id="frmvacaciones" method="post" action="<?php echo base_url()?>fastFile/guardar_solicitud_vacaciones">
  <input type="hidden" name="idPersona" id="idPersona" value="<?php echo $this->tank_auth->get_idPersona();?>">
  <input type="hidden" name="antiguedad" id="antiguedad" value="<?php echo $antiguedad?>;?>">
  <div class="modal-dialog">
    <!-- Modal content-->
   <div class="modal-content" style="width:120%;margin-left:-10%;">
      <div class="modal-header">
        <h4 class="modal-title"  id="myModalLabel"><i class="fa fa-plane"></i>&nbsp;Solicitud de vacaciones</h4>
      </div>
      <div class="modal-body">
        <table border="0" style="width:100%;">
        <tr>
            <td style="width: 30%;"><i class="fa fa-user"></i>&nbsp;Nombre empleado:</td>
            <td><b><? echo $miInfo_Datos->nombres.' '.$miInfo_Datos->apellidoPaterno . ' ' . $miInfo_Datos->apellidoMaterno; ?></b></td>
        </tr>
        <tr>
            <td><i class="fa fa-user"></i>&nbsp;Cargo:</td>
            <?php $cargo=$this->personamodelo->puestoDePersona($this->tank_auth->get_idPersona());?>
            <td><b><?php echo $cargo[0]->personaPuesto;?></b></td>
        </tr>
         <tr>
            <td><i class="fa fa-calendar"></i>&nbsp;Fecha de salida:</td>
            <td><input type="date" class="form-control" name="fecha_salida" id="fecha_salida" style="width:200px;"></td>
        </tr>
        <tr>
            <td><i class="fa fa-calendar-plus-o" aria-hidden="true"></i>&nbsp;Cantidad de diás:</td>
            <td>
            <select name="cantidad_dias" id="cantidad_dias" class="form-control" style="width:200px;">
            <?php for($i=1;$i<$restan+1;$i++){?>
                <option value="<?php echo $i;?>"><?php echo $i;?></option>
            <?php }?>
            </td>
        </tr>
        <tr><td colspan="4">&nbsp;</td></tr>
            <tr><td colspan="4"><hr></td></tr>
            <tr><td colspan="4">&nbsp;</td></tr>
        
            <tr>
                <td colspan="4" style="text-align: right;">
                 <button type="button" class="btn btn-primary" data-dismiss="modal"><i class="fa fa-times"></i>Cerrar</button>
                  <button type="button" class="btn btn-primary" onclick="guardar_solicitud_vacaciones()"><i class="fa fa-check"></i>&nbsp;Enviar Solicitud</button>
                </td>
            </tr>
        </table>
          </div>
      </div>
    </div>
  </form>
</div>



<div class="js-incidencias"></div>
<div class="md-detalle"></div>
<div id="bonos-container"></div>
<div class="modal-seguimiento-container"></div>
<div id="base_url" class="container-fluid" data-base-url="<?= base_url() ?>"></div>
<script>
	const _empleados = <?= json_encode($_empleados) ?>;
	const _puestos = <?= json_encode($_puestos) ?>;
	var url = document.location.toString();
	if (url.match('#')) {
		$('.nav-tabs a[href="#' + url.split('#')[1] + '"]').tab('show');
	}
</script>
<!----------------------------------------------------[Dennis 2020-08-28]-------------------------------------------------------------------->
<script>
	//console.log(window.location.href);
	//aqui
	var direccion=window.location.href;
	var select=document.getElementById("mesesActivos");
	var hidden=document.getElementById("idPersona");
	var meses={};

	meses[1]="ENERO";
	meses[2]="FEBRERO";
	meses[3]="MARZO";
	meses[4]="ABRIL";
	meses[5]="MAYO";
	meses[6]="JUNIO";
	meses[7]="JULIO";
	meses[8]="AGOSTO";
	meses[9]="SEPTIEMBRE";
	meses[10]="OCTUBRE";
	meses[11]="NOVIEMBRE";
	meses[12]="DICIEMBRE";

	function despliegaInfoDeHistorial(){
		//console.log(select.value);

		var xmlhttp= new XMLHttpRequest();

		if(select.value!=0){
			xmlhttp.onreadystatechange=function(){
				if(this.readyState==4 && this.status==200){
					//console.log(JSON.parse(this.responseText));
					var respuesta=JSON.parse(this.responseText);

					var cuerpoTabla=document.getElementById("cuerpoContenido");
					cuerpoTabla.innerHTML="";

					var cuerpoTablaM=document.getElementById("cuerpoContenidoMensual");
					cuerpoTablaM.innerHTML="";

					if(Object.entries(respuesta).length>0){
						for(var indice in respuesta){

							if(select.value!="total"){

								document.getElementById("historial_unitario").style.display="block";
								document.getElementById("historial_mensual").style.display="none";

									cuerpoTabla.innerHTML+=`
									<tr>
										<td>`+indice+`</td>
										<td id="columna_`+indice+`"></td>
									</tr>
								`;

								var columnaInfo=document.getElementById("columna_"+indice);
								var info="";
								var sub_info="";
							
								for(var subCat in respuesta[indice]){
									for(var $ramo in  respuesta[indice][subCat]){

										if(respuesta[indice][subCat][$ramo]>0){
											sub_info+=`
												<ul>
													<li>`+$ramo.replace("danios","daños").toUpperCase()+`: `+respuesta[indice][subCat][$ramo]+` hrs</li>
												</ul>
											`;
										}
									}

									info+=`
										<ul>
											<li>Sub-categoria: <b>`+subCat+`</b><br> En el ramo: `+sub_info+`</li>
										</ul><hr>
									`;
								}
								columnaInfo.innerHTML+=info;

							} else if(select.value=="total"){
								
								document.getElementById("historial_unitario").style.display="none";
								document.getElementById("historial_mensual").style.display="block";

								var fila="";
							
								fila+=`
									<tr>
										<td>`+meses[indice]+`</td>
										<td id="cat_`+indice+`"></td>
										<td id="sub_cat_`+indice+`"></td>
										<!--<td id="sum_sub_cat_`+indice+`"></td>-->
									</tr>
								`;

								cuerpoTablaM.innerHTML+=fila;

								var columnaMes=document.getElementById("cat_"+indice);
								columnaMes.innerHTML="";

								var columnaSubCat=document.getElementById("sub_cat_"+indice);
								columnaSubCat.innerHTML="";
								//console.log(columnaMes);
								var filacat="";
								var filaSubCat="";
								var sumSubCat="";
								
								if(Object.entries(respuesta[indice]).length>0){
									for(var cat in respuesta[indice]){
									filacat+=cat+`<br>`;

										if(Object.entries(respuesta[indice][cat]).length>0) {
											for(var subCat in respuesta[indice][cat]){

												filaSubCat+=subCat+`: <b>`+respuesta[indice][cat][subCat]+` hrs</b><br>`;
											}
										}
									}
								} else{
									filacat+=`0`;
									filaSubCat+=`0`
									columnaMes.classList.add("text-center");
									columnaSubCat.classList.add("text-center");
								}
								columnaMes.innerHTML+=filacat;
								columnaSubCat.innerHTML+=filaSubCat;
							}
						}
					} else{
						cuerpoTabla.innerHTML+=`<h4>No hay datos por el momento...<h4>`;
					}
				}
			}

			xmlhttp.open("GET",direccion+"/obtenerInfoSeleccionado?q="+select.value+"&r="+hidden.value,true);
			xmlhttp.send();
		} else{
			alert("Se seleccionó la primera opción");
		}
	}

	select.addEventListener("change",despliegaInfoDeHistorial);
</script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@8.18.0/dist/sweetalert2.all.min.js"></script>
<script>
    function guardar_solicitud_prestamo(){
        var monto=document.getElementById('monto').value;
        if(monto!=''){
            var op=confirm("¿Esta seguro(a) de la cantidad a solicitar, dicho prestamo estara sujeto a aprobacion por parte de la administración?");
            if(op==1){
                document.getElementById('frmprestamo').submit();
            }
        }else{
                var text = "Validación solicitud prestamo";
                Swal.fire({
                title: '',
                type: 'warning',
                html:
                'Debe ingresar al menos una <b>cantidad</b> a solicitar'
                })
        }
    }

    function guardar_solicitud_vacaciones(){
        var fecha_salida=document.getElementById('fecha_salida').value;
        if(fecha_salida!=''){
            var op=confirm("¿Esta seguro(a) de los datos de solicitud?");
            if(op==1){
                document.getElementById('frmvacaciones').submit();
            }
        }else{
                var text = "Validación solicitud de vacaciones";
                Swal.fire({
                title: '',
                type: 'warning',
                html:
                'Debe seleccionar una fecha de salida y una de retorno'
                })
        }
    }

</script>
<!--------------------------------------------------------------------------------------------------------------------------------->
<script type="text/javascript" src="<?= base_url() ?>assets/gap/js/datatables.min.js"></script>
<script type="text/javascript" src="<?= base_url() ?>assets/js/fileupload/public/bundle-modal-seguimiento.js"></script>
<script type="text/javascript" src="<?= base_url() ?>assets/js/fileupload/public/bundle-incidencias.js"></script>
<script type="text/javascript" src="<?= base_url() ?>assets/js/fileupload/public/bundle-bonos.js"></script>
<script type="text/javascript" src="<?= base_url() ?>assets/gap/js/personas.profile.js"></script>
<!--EVALUACIONES FIN-->
