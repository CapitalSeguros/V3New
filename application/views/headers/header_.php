<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html lang="es" xmlns="http://www.w3.org/1999/xhtml">

<head>
	<?= meta('charset', 'utf-8'); ?>
	<?= meta('viewport', 'width=device-width, initial-scale=1.0, user-scalable=no'); ?>
	<meta name="viewport" content="width=900px" /><!-- Moi -->
	<?= meta('X-UA-Compatible', 'IE=edge,chrome=1', 'equiv'); ?>
	<!-- <link rel="shortcut icon" href="images/favicon.ico"> -->
	<?= link_tag('assets/img/icon.png', 'apple-touch-icon-precomposed'); ?>
	<?= link_tag('assets/img/icon.png', 'shortcut icon'); ?>
	<title>Capsys &bull; Web - Bienvenido</title>
	<!-- Viculamos los Estilos CSS -->
	<link href="https://cdn.jsdelivr.net/npm/vuetify@3.5.3/dist/vuetify.min.css" rel="stylesheet">
	</link>
	<link href="https://cdn.jsdelivr.net/npm/@mdi/font@5.x/css/materialdesignicons.min.css" rel="stylesheet">
	<link href="<?= base_url() . "assets/vuejs-bundles/diary_process/diaryStyles.css" ?>" rel="stylesheet">
	<?= link_tag('assets/css/bootstrap.min.css'); ?>
	<?= link_tag('assets/css/font-awesome.min.css'); ?>
	<?= link_tag('assets/css/bootstrap-datepicker3.min.css'); ?>
	<?= link_tag('assets/css/cap.css'); ?>
	<?= link_tag('assets/css/subMenu.css'); ?>
	<?= link_tag('assets/css/menu.css'); ?>
	<?= link_tag('assets/css/win8/ui.easytree.css'); ?>
	<?= link_tag('assets/css/capMoi.css'); ?>
	<?= link_tag('assets/css/estiloscapsys.css'); ?>
	<?= meta("Expires", "0", "equiv"); ?>
	<?= meta("Last-Modified", "0", "equiv"); ?>
	<?= meta("Cache-Control", "no-cache, mustrevalidate", "equiv"); ?>
	<?= meta("Pragma", "no-cache", "equiv"); ?>
	<!--Estilos anteriores-->
	<!-- <script src="<?= site_url('assets/js/jquery-1.12.3.min.js'); ?>"></script>
   	<script src="<?= site_url('assets/js/bootstrap-datepicker.min.js'); ?>"></script>
	<script src="<?= site_url('assets/js/locales/bootstrap-datepicker.es.min.js'); ?>"></script>
   	<script src="<?= site_url('assets/js/jquery.easytree.min.js'); ?>"></script>
	<script src="<?= base_url('assets/gap/js/moment.min.js') ?>"></script>
	<script src="<?= base_url('assets/gap/js/lodash.min.js') ?>"></script> -->

	<!--Nueva configuracion para los módulos de tic Consultores-->
	<?php if (!isset($ticc)) { ?>

		<link href="<?= base_url('assets/gap/css/toastr.min.css') ?>" rel="stylesheet" />


		<script src="<?= site_url('assets/js/jquery-1.12.3.min.js'); ?>"></script>
		<script src="<?= site_url('assets/js/bootstrap-datepicker.min.js'); ?>"></script>
		<script src="<?= site_url('assets/js/locales/bootstrap-datepicker.es.min.js'); ?>"></script>
		<script src="<?= site_url('assets/js/jquery.easytree.min.js'); ?>"></script>
		<script src="<?= base_url('assets/gap/js/moment.min.js') ?>"></script>
		<script src="<?= base_url('assets/gap/js/lodash.min.js') ?>"></script>
		<script src="<?= base_url('assets/gap/js/sweetalert.min.js') ?>" type="text/javascript"></script>
		<script src="<?= base_url('assets/gap/js/toastr.min.js') ?>" type="text/javascript"></script>
	<?php  } ?>

	<?php if (isset($ticc)) { ?>
		<!-- Archivos de los modulos de siniestros y evaluaciones-->
		<link href="<?= base_url(DIR_ASSETS . 'css/bootstrap.min.css') ?>" rel="stylesheet" />
		<link href="<?= base_url(DIR_ASSETS . 'css/font-awesome.min.css') ?>" rel="stylesheet">
		<link href="<?= base_url(DIR_ASSETS . 'css/cap.css') ?>" rel="stylesheet" />
		<link href="<?= base_url(DIR_ASSETS . 'css/menu.css') ?>" rel="stylesheet" />
		<link href="<?= base_url(DIR_ASSETS . 'css/jquery-ui.min.css') ?>" rel="stylesheet">
		<link href="<?= base_url(DIR_ASSETS . 'css/toastr.min.css') ?>" rel="stylesheet" />

		<link href="<?= base_url(DIR_ASSETS . 'css/nprogress.css') ?>" rel="stylesheet" />
		<!-- JS -->
		<script src="<?= base_url(DIR_ASSETS . 'js/jquery-3.4.1.min.js') ?>" type="text/javascript"></script>
		<script src="<?= site_url(DIR_ASSETS . 'js/jquery-ui.min.js'); ?>"></script>
		<script src="<?= base_url(DIR_ASSETS . 'js/toastr.min.js') ?>" type="text/javascript"></script>
		<script src="<?= base_url(DIR_ASSETS . 'js/sweetalert.min.js') ?>" type="text/javascript"></script>
		<script src="<?= base_url(DIR_ASSETS . 'js/pace.min.js') ?>" type="text/javascript"></script>
	<?php  } ?>

	<?php if (isset($_scripts)) {
		foreach ($_scripts as $value) {
			echo $value;
		}
	}
	?>

	<script src="https://unpkg.com/vue@3/dist/vue.global.js"></script>
	<script src="https://unpkg.com/vuex@4.0.0/dist/vuex.global.js"></script>
	<script src="https://unpkg.com/rxjs@^7/dist/bundles/rxjs.umd.min.js"></script>
	<script crossorigin src="https://unpkg.com/universal-cookie@7/umd/universalCookie.min.js"></script>
	<script src="https://cdn.jsdelivr.net/npm/vue-demi"></script>
	<script src="https://cdn.jsdelivr.net/npm/@vuelidate/core"></script>
	<script src="https://cdn.jsdelivr.net/npm/@vuelidate/validators"></script>
	<script src="https://cdn.jsdelivr.net/npm/vuetify@3.5.3/dist/vuetify.min.js"></script>
	<!-- <link href="https://cdn.jsdelivr.net/npm/vuetify@3.5.3/dist/vuetify.min.css" rel="stylesheet">
	</link>
	<link href="https://cdn.jsdelivr.net/npm/@mdi/font@5.x/css/materialdesignicons.min.css" rel="stylesheet">
	<link href="<?= base_url() . "assets/vuejs-bundles/diary_process/diaryStyles.css" ?>" rel="stylesheet"> -->

	<!--[if lt IE 8]>
       <div style=' clear: both; text-align:center; position: relative;'>
         <a href="http://windows.microsoft.com/en-US/internet-explorer/products/ie/home?ocid=ie6_countdown_bannercode">
           <img src="http://storage.ie6countdown.com/assets/100/images/banners/warning_bar_0000_us.jpg" border="0" height="42" width="820" alt="You are using an outdated browser. For a faster, safer browsing experience, upgrade for free today." />
        </a>
      </div>
    <![endif]-->
	<!--[if lt IE 9]>
		<script src="js/html5shiv.min.js"></script>
		<script src="js/respond.min.js"></script>
    <![endif]-->
</head>
<style>
	.seguimientoSicas {
		/*border: 1px red solid;*/
		position: fixed;
		left: 70%;
		width: 25%;
		height: 85%;
		border-radius: 8px;
		background-color: #fff;
		bottom: 5%;
		z-index: 1;
	}

	.notificacion_seguimiento {
		text-align: center;
		height: 30px;
		background-color: #E2E2E2;
	}

	.polizaAtrasada {
		/*margin: 5px;*/
		border-radius: 4px;
		width: 100%;
		/*height: 20px;*/
		background-color: red;
		color: white;
	}

	.polizaAtrasada:hover {
		background-color: #CD6155;
	}

	.polizaPendiente {
		/*margin: 5px;*/
		border-radius: 4px;
		width: 100%;
		/*height: 20px;*/
		background-color: yellow;
	}

	.polizaPendiente:hover {
		background-color: #F4D03F;
	}

	.polizaEfectuada {
		/*margin: 5px;*/
		border-radius: 4px;
		width: 100%;
		/*height: 20px;*/
		background-color: #85C1E9;
		color: #fff;
	}

	.polizaEfectuada:hover {
		background-color: #58D68D;
		cursor: pointer;
	}

	.cerrar_xx {
		text-align: right;
	}

	#verde {
		background-color: #04B404;
	}

	#amarillo {
		background-color: #FFBF00;
	}

	#rojo {
		background-color: #FA5858;
	}
</style>

<body>
	<?php
	$CI = &get_instance();
	$CI->load->model("metacomercial_modelo");
	$CI->load->model("personamodelo");
	$CI->load->model("crmproyecto_model");
	$CI->load->library("ws_sicas");
	$novacio = false;
	$cnc = 0;
	$directiveUser = array("DIRECTORGENERAL@AGENTECAPITAL.COM", "SISTEMAS@ASESORESCAPITAL.COM");
	$permissions =  array_map(function ($arr) {
		return $arr->idLlavePermiso;
	}, $CI->personamodelo->getMyPermissions($this->tank_auth->get_idPersona()));
	//$personal_con_meta_asignada=$CI->personamodelo->devuelveCoorMetaComercial();

	$hoy = date("Y-m-d"); //"2021-02-27"; //
	$ultimo_dia_mes = date("Y-m-d", mktime(0, 0, 0, (date("m")) + 1, 0, date("Y")));

	$ids_con_meta = array();

	$modal_flotante = "";
	$flotante_nuevo = "";

	$meses = array();
	$meses[1] = "ENERO";
	$meses[2] = "FEBRERO";
	$meses[3] = "MARZO";
	$meses[4] = "ABRIL";
	$meses[5] = "MAYO";
	$meses[6] = "JUNIO";
	$meses[7] = "JULIO";
	$meses[8] = "AGOSTO";
	$meses[9] = "SEPTIEMBRE";
	$meses[10] = "OCTUBRE";
	$meses[11] = "NOVIEMBRE";
	$meses[12] = "DICIEMBRE";

	//----------------------------------
	function fechasFeriadas($mes)
	{

		$anio = date("Y");
		switch ($mes) {
			case 1:
				return [$anio . "-01-01"];
				break;
			case 2:
				return [$anio . "-02-01"];
				break;
			case 3:
				return [$anio . "-03-15"];
				break;
			case 5:
				return [$anio . "-05-01"];
				break;
			case 9:
				return [$anio . "-09-16"];
				break;
			case 11:
				return [$anio . "-11-15"];
				break;
			case 12:
				return [$anio . "-12-25"];
				break;
		}
	}

	function diasHabiles($fi, $ff, $fih)
	{

		if (empty($fih)) {
			$fih = array();
		}

		$int_i = strtotime($fi); //date("j", strtotime($fi));
		$int_f = strtotime($ff); //date("j", strtotime($ff));
		//$fp = fopen('resultadoJason.txt', 'a');fwrite($fp, print_r($int_f,TRUE));fclose($fp);

		$d_h = array();

		for ($it = $int_i; $it <= $int_f; $it += 86400) {
			if (!in_array(date("N", $it), array(6, 7)) && !in_array(date("Y-m-d", $it), $fih)) {

				array_push($d_h, date("N", $it));
			}
		}

		return $d_h;
	}

	//diasHabiles($hoy,$ultimo_dia_mes,fechasFeriadas(date("m")));
	//$cc=0;
	//$contador_dias_habiles=count(diasHabiles($hoy,$ultimo_dia_mes,fechasFeriadas(date("m"))));
	$contador_dias_habiles_a = diasHabiles($hoy, $ultimo_dia_mes, fechasFeriadas(date("m")));
	$cnc_ = 0;
	if (!empty($contador_dias_habiles_a)) {
		for ($ii = 0; $ii < count($contador_dias_habiles_a); $ii++) {
			$cnc++;
			$cnc_++;
		}
	} else {
		$cnc = 1;
	}
	//----------------------------------

	if ($this->tank_auth->get_idPersona()) {
		try {

			//$personal_con_meta_asignada=$CI->metacomercial_modelo->retornaMetaComercialAnual($this->tank_auth->get_usermail());
			//$agentes_cobranza=array("ATENCIONAGENTESMID@ASESORESCAPITAL.COM","ATENCIONCLIENTES@ASESORESCAPITAL.COM","COBRANZA@ASESORESCAPITAL.COM","SOPORTEOPERATIVO@ASESORESCAPITAL.COM");
			$agentes_cobranza = array("ASISTENTECUN2@AGENTECAPITAL.COM", "ATENCIONAGENTESMID@ASESORESCAPITAL.COM", "ATENCIONCLIENTES@ASESORESCAPITAL.COM", "COBRANZA@ASESORESCAPITAL.COM", "SOPORTEOPERATIVO@ASESORESCAPITAL.COM", "GERENTEOPERATIVO@AGENTECAPITAL.COM", "COORDINADOROPERATIVO@ASESORESCAPITAL.COM", "DATACENTER@AGENTECAPITAL.COM", "COORDINADORINSTITUCIONAL@AGENTECAPITAL.COM", "COORDINADOR@CAPCAPITAL.COM.MX", "COORDINADORCOMERCIAL@CAPCAPITAL.COM.MX", "COORDINADORCOMERCIAL@FIANZASCAPITAL.COM");
			$personal_con_meta_asignada = $CI->metacomercial_modelo->devuelveRelacionComisionPersona(array("idPersona" => $this->tank_auth->get_idPersona(), "correo" => $this->tank_auth->get_usermail()));
			//var_dump($personal_con_meta_asignada);
			//--------------------------------
			//Gestionar usuarios y metas
			$array_persona_meta = array();

			if (!empty($personal_con_meta_asignada)) {
				foreach ($personal_con_meta_asignada as $datos) {

					$validador_en_reportes = $CI->crmproyecto_model->devuelveRelacionKPIPorPersona($datos->idPersona);

					if (count($validador_en_reportes) > 0) {

						$array_persona_meta[$datos->idPersona][$datos->referencia]["id_referencia"] = $datos->id_referencia;
						$array_persona_meta[$datos->idPersona][$datos->referencia]["bandera"] = $datos->referencia == "venta_nueva" ? 1 : 2;
					}
				}
			}

			//var_dump($array_persona_meta);
			//--------------------------------
			if (!empty($array_persona_meta)) { //personal_con_meta_asignada

				$novacio = true;
				//var_dump($this->tank_auth->get_userprofile());

				$flotante_nuevo .= "<div class='card mb-2'>
						<div class='card-header text-center'>
							<a data-toggle='collapse' href='#muestro_avance_comercial' aria-expanded='false' aria-controls='muestro_avance_comercial'><i class='fa fa-cogs'></i>&nbsp;KPI Comercial<span class='caret'></span></a>
						</div>
						<div class='card-body collapse visible' id='muestro_avance_comercial'>
							<div style='margin-top: 10px; margin-left: 5px'><span class='label label-warning' style='font-size: 11px'>Fecha actual:</span>&nbsp<span class='label label-info' style='font-size: 11px'>" . date("d-m-Y") . "</span></div>
							<div style='margin-top: 10px; margin-left: 5px'><span class='label label-warning' style='font-size: 11px'>Días hábiles:</span>&nbsp<span class='label label-info' style='font-size: 11px'>" . $cnc_ . " días (Hasta " . date("d-m-Y", mktime(0, 0, 0, date("m") + 1, 0, date("Y"))) . ")</span></div>
					";

				//-----------------------------------
				foreach ($array_persona_meta as $persona => $metas) {

					$_email = $this->personamodelo->obtenerEmail($persona);
					$_avance_persona = array();
					$validador = array();

					foreach ($metas as $tipo => $parametros) {

						$meta_mensual = $this->metacomercial_modelo->devuelveMensualidadDeMeta(date("m"), $parametros["id_referencia"], $parametros["bandera"]);
						$recibos = $this->crmproyecto_model->avance_cobranza_agente_region($persona);
						$comision = $this->crmproyecto_model->devuelveDatosCobranzaPorComision($persona, 1);

						$_avance_persona[$tipo]["meta_comercial"] = !empty($meta_mensual) ? $meta_mensual->monto_al_mes : 0;
						$_avance_persona[$tipo]["comision"] = $tipo == "venta_nueva" ? $comision->comision_efectuada_venta_nueva : $comision->comision_efectuada;
						$_avance_persona[$tipo]["recibos"] = $tipo == "venta_nueva" ? $recibos->recibos_efectuados_venta_nueva : $recibos->recibos_efectuados;
						//var_dump($meta_mensual);
						array_push($validador, $tipo);
					}

					if (!in_array("ingreso_total", $validador)) {

						$_avance_persona["ingreso_total"]["meta_comercial"] = 0;
						$_avance_persona["ingreso_total"]["comision"] = 0;
						$_avance_persona["ingreso_total"]["recibos"] = 0;
					} elseif (!in_array("venta_nueva", $validador)) {

						$_avance_persona["venta_nueva"]["meta_comercial"] = 0;
						$_avance_persona["venta_nueva"]["comision"] = 0;
						$_avance_persona["venta_nueva"]["recibos"] = 0;
					}
					//var_dump($_avance_persona);

					$flotante_nuevo .= "<div class='row table-responsive' style='border: 1px #E2E2E2 solid; margin: 5px; border-radius: 4px; margin-top: 10px;' onclick='muestraContenido_(this)' id_m='1'><div class='polizaEfectuada'><label for='polizaEfectuada' style='margin-top:5px;'><small>" . $_email->email . "</small></label></div><div id='cont_polizaEfectuada' style='display:none'>
							<table class='table'>
								<tr>
									<td></td>
									<td><span class='badge badge-info'>Venta nueva</span></td>
									<td><span class='badge badge-info'>Ingreso total</span></td>
								</tr>
								<tr>
									<td><span class='label label-primary' style='font-size: 11px;'>Meta</span></td>
									<td class='text-center'><span style='font-size: 11px'>$" . number_format($_avance_persona["venta_nueva"]["meta_comercial"]) . "</span></td>
									<td class='text-center'><span style='font-size: 11px'>$" . number_format($_avance_persona["ingreso_total"]["meta_comercial"]) . "</span></td>
								</tr>
								<tr>
									<td><span class='label label-primary' style='font-size: 11px;'>Avance</span></td>
									<td class='text-center'><span style='font-size: 11px'>$" . number_format($_avance_persona["venta_nueva"]["comision"]) . "</span></td>
									<td class='text-center'><span style='font-size: 11px'>$" . number_format($_avance_persona["ingreso_total"]["comision"]) . "</span></td>
								</tr>
								<tr>
									<td><span class='label label-primary' style='font-size: 11px;'>Promedio de comision real</span></td>
									<td class='text-center'><span style='font-size: 11px'>$" . number_format($_avance_persona["venta_nueva"]["comision"] > 0 ? $_avance_persona["venta_nueva"]["comision"] / $_avance_persona["venta_nueva"]["recibos"] : 0) . "</span></td>
									<td class='text-center'><span style='font-size: 11px'>$" . number_format($_avance_persona["ingreso_total"]["comision"] > 0 ? $_avance_persona["ingreso_total"]["comision"] / $_avance_persona["ingreso_total"]["recibos"] : 0) . "</span></td>
								</tr>
								<tr>
									<td><span class='label label-primary' style='font-size: 11px;'>Promedio de comisión sugerida:</span></td>
									<td class='text-center'><span style='font-size: 11px'>$" . number_format($_avance_persona["venta_nueva"]["comision"] > 0 ? $_avance_persona["venta_nueva"]["comision"] / $cnc : 0) . "</span></td>
									<td class='text-center'><span style='font-size: 11px'>$" . number_format($_avance_persona["ingreso_total"]["comision"] > 0 ? $_avance_persona["ingreso_total"]["comision"] / $cnc : 0) . "</span></td>
								</tr>
							</table>
						";
					$flotante_nuevo .= "</div></div>"; //Fin del foreach
				}
				//----------------------------------
				$flotante_nuevo .= "</div></div>";
				//[Modificacion - Miguel Jaime 26-03-2021]
				$user = $this->tank_auth->get_usermail();
				if ($user == "DIRECTORGENERAL@AGENTECAPITAL.COM") {
					include('modal_flotante_kpi_operativo.php');
				}
				if ($user == "DIRECTORCOMERCIAL@AGENTECAPITAL.COM") {
					include('modal_flotante_kpi_prospeccion.php');
				}
			} elseif (empty($personal_con_meta_asignada) && $this->tank_auth->get_userprofile() == 1) {
				//var_dump($this->tank_auth->get_idPersona());

				$fechaI = date("d-m-Y", mktime(0, 0, 0, date("m"), 1, date("Y")));
				$fechaF = date("d-m-Y"); //"28-02-2021";//

				$metas = $CI->metacomercial_modelo->informacionGeneralMetaRamo($this->tank_auth->get_idPersona(), date("n"), "registro_meta_mensual_ramo_agente_generico");
				$metaSicas = $CI->ws_sicas->consultaAvanceSicas(667, array($this->tank_auth->get_IDVend()), $fechaI, $fechaF, null);

				//$fp = fopen('resultadoJason.txt', 'a');fwrite($fp, print_r($metaSicas,TRUE));fclose($fp);
				$ramos_n = array("autos", "danios", "vida", "gmm", "fianzas");
				$validador_r = array();
				$validador_m = array();

				//if(empty($metas)){
				//	$ramos_metas["mensaje"]="Datos no asignados";
				//} 
				if (!empty($metas)) { //else{
					//$ramos_metas["mensaje"]="";

					$novacio = true;

					$primaAutos = 0;
					$polizasAutos = 0;
					foreach ($metas as $v) {

						array_push($validador_m, $v->ramo);

						$ramos_asig[$v->ramo]["meta"]["cantidad_polizas"] = $v->cantidad_polizas;
						$ramos_asig[$v->ramo]["meta"]["cantidad_primas"] = $v->prima_polizas;

						if (array_key_exists("TableInfo", $metaSicas)) {
							foreach ($metaSicas->TableInfo as $s) {

								if ((string)$s->Ramo == "Accidentes y Enfermedades") {
									(string)$s->Ramo = "Gmm";
								} elseif ((string)$s->Ramo == "Vehiculos") {
									(string)$s->Ramo = "Autos";
									$primaAutos += (float)$s->PrimaNeta;
									$polizasAutos++;
								} elseif ((string)$s->Ramo == "Daños") {
									(string)$s->Ramo = "Danios";
								} elseif ((string)$s->Ramo == "Vida") {
									(string)$s->Ramo = "Vida";
								}

								if ($v->ramo == strtolower((string)$s->Ramo)) {

									if (!isset($ramos_asig[$v->ramo]["sicas"]["cantidad_primas"]) && !isset($ramos_asig[$v->ramo]["sicas"]["cantidad_polizas"])) {
										$ramos_asig[$v->ramo]["sicas"]["cantidad_primas"] = 0;
										$ramos_asig[$v->ramo]["sicas"]["cantidad_polizas"] = 0;
									}

									//$ramos_asig["meta"][$v->ramo]["cantidad_polizas"]=$v->cantidad_polizas;
									//$ramos_asig["meta"][$v->ramo]["cantidad_primas"]=$v->prima_polizas;
									$ramos_asig[$v->ramo]["sicas"]["cantidad_polizas"]++;
									$ramos_asig[$v->ramo]["sicas"]["cantidad_primas"] += (float)$s->PrimaNeta;
									array_push($validador_r, $v->ramo);
								}
							}

							for ($i = 0; $i < count($ramos_n); $i++) {

								if (!in_array($ramos_n[$i], $validador_r)) {
									//$ramos_asig["meta"][$ramos_n[$i]]["cantidad_polizas"]=0;
									//$ramos_asig["meta"][$ramos_n[$i]]["cantidad_primas"]=0;
									$ramos_asig[$ramos_n[$i]]["sicas"]["cantidad_polizas"] = 0;
									$ramos_asig[$ramos_n[$i]]["sicas"]["cantidad_primas"] = 0;
								}
							}
						}
						for ($i = 0; $i < count($ramos_n); $i++) {

							if (!in_array($ramos_n[$i], $validador_r)) {
								//$ramos_asig["meta"][$ramos_n[$i]]["cantidad_polizas"]=0;
								//$ramos_asig["meta"][$ramos_n[$i]]["cantidad_primas"]=0;
								$ramos_asig[$ramos_n[$i]]["sicas"]["cantidad_polizas"] = 0;
								$ramos_asig[$ramos_n[$i]]["sicas"]["cantidad_primas"] = 0;
							}
						}
					}

					for ($i = 0; $i < count($ramos_n); $i++) {

						if (!in_array($ramos_n[$i], $validador_m)) {
							$ramos_asig[$ramos_n[$i]]["meta"]["cantidad_polizas"] = 0;
							$ramos_asig[$ramos_n[$i]]["meta"]["cantidad_primas"] = 0;
							//$ramos_asig["sicas"][$ramos_n[$i]]["cantidad_polizas"]=0;
							//$ramos_asig["sicas"][$ramos_n[$i]]["cantidad_primas"]=0;
						}
					}

					$ramos_metas["asignado"] = $ramos_asig;
					//}

					//var_dump($metas);
					//$fp = fopen('resultadoJason.txt', 'a');fwrite($fp, print_r($ramos_metas,TRUE));fclose($fp);

					foreach ($ramos_metas["asignado"] as $k_a => $aa) {
						$flotante_nuevo .= "
								<div style='border: 1px #E2E2E2 solid; margin: 5px; border-radius: 4px; width: 95%;' onclick='muestraContenido_(this)' id_m='1'><div class='polizaEfectuada'><label for='polizaEfectuada' style='margin-top:5px;'>&nbsp;Ramo en " . $k_a . "</label></div><div id='cont_polizaEfectuada' style='display:none'>
									<table class='table'>
										<tbody>
											<tr>
												<td></td>
												<td style='font-size: 12px' class='text-center'><span class='badge badge-secondary'>Meta</span></td>
												<td style='font-size: 12px' class='text-center'><span class='badge badge-secondary'>Realizado</span></td>
											</tr>
											<tr>
												<td style='font-size: 12px'>Pólizas</td>
												<td style='text-align:center; font-size: 12px'>" . $aa["meta"]["cantidad_polizas"] . "</td>
												<td style='font-size: 12px' class='text-center'>" . $aa["sicas"]["cantidad_polizas"] . "</td>
											</tr>
											<tr>
												<td style='font-size: 12px'>Prima</td>
												<td style='text-align:center; font-size: 12px'>$ " . number_format($aa["meta"]["cantidad_primas"]) . "</td>
												<td style='font-size: 12px' class='text-center'>$ " . number_format($aa["sicas"]["cantidad_primas"]) . "</td>
											</tr>
										</tbody>
									</table>
								</div></div>
							";
					}

					$flotante_nuevo .= "</div>
						</div>";
				}
			}

			//if(!in_array($this->tank_auth->get_usermail(), $directiveUser)){
			//include("kpi_ramo_prima_cantidad.php"); //Metas por primas y polizas
			//}
			/*if(in_array($this->tank_auth->get_usermail(),$agentes_cobranza)){ //Flotante de cobranza
					
					$avance_cobranza_agente_region=$CI->crmproyecto_model->avance_cobranza_agente_region($this->tank_auth->get_idPersona());
					$cobranzaRegion= $this->tank_auth->get_idPersona() == 822 ? $CI->crmproyecto_model->devuelveTodosLosRegistrosPorRegion() : array();
					//$fp = fopen('resultadoJason.txt', 'a');fwrite($fp, print_r($avance_cobranza_agente_region,TRUE));fclose($fp);
					//$avance_cobranza_agente=$CI->crmproyecto_model->devuelveAvanceCobranzaKpi($this->tank_auth->get_idPersona());
					$novacio=true;
					//-----------------------------------
					$bxnActive = $this->tank_auth->get_usermail() == "COORDINADOR@CAPCAPITAL.COM.MX" ? true: false;
					$showBxN = "";
					$dxnData = $this->crmproyecto_model->getDxnData();
					$getCountBxN = array_reduce($dxnData, function($acc, $curr){

						if($curr->tipoRecibo == "efectuado"){
							$acc["effected"] += $curr->recibos; 
						} elseif($curr->tipoRecibo == "atrasado"){
							$acc["late"] += $curr->recibos; 
						}
						//$acc += $curr->recibos;
						return $acc;
					}, array("effected" => 0, "late" => 0));
					//----------------------------------
					//var_dump($this->tank_auth->get_idPersona());
					if(!empty($avance_cobranza_agente_region)){
						$total = $avance_cobranza_agente_region->recibos_efectuados + $avance_cobranza_agente_region->recibos_efectuados_grupo_cer;
						$total_late = $avance_cobranza_agente_region->recibos_atrasados + $avance_cobranza_agente_region->recibos_atrasados_grupo_cer;

						foreach($agentes_cobranza as $cuenta){
							if($cuenta==$this->tank_auth->get_usermail()){
                                
								$flotante_nuevo.='

									<div class="card" style="margin-top: 5px;">
										<div class="card-header text-center text-dark">
											<a data-toggle="collapse" href="#info_region" role="button" aria-expanded="false" aria-controls="info_region"><small> COBRANZA '.(!array_key_exists("reporte",$avance_cobranza_agente_region ) ? "AVANCE" : strtoupper($avance_cobranza_agente_region->reporte)).'</small><span class="caret"></span></a>
										</div>
										<div class="card-body collapse table-responsive show in" id="info_region">';

										if(empty($cobranzaRegion)){

											$flotante_nuevo .= '<span class="label label-warning">Fecha actual</span> <span class="label label-info">'.date("d-m-Y").'</span>&nbsp&nbsp&nbsp<span class="label label-warning">Dias hábiles</span> <span class="label label-info">'.$cnc.' dias</span>
												<span class="label label-warning">Promedio sugerido de cobro</span> <span class="label label-info">'.number_format(($avance_cobranza_agente_region->recibos_pendientes+$avance_cobranza_agente_region->recibos_atrasados)/$cnc).' recibos</span></h5>
												<br><br><hr>
												<div>
													<h5><span class="label label-primary">EFECTUADA</span>&nbsp&nbsp&nbsp<span class="label label-default">'.($avance_cobranza_agente_region->recibos_efectuados+$avance_cobranza_agente_region->recibos_efectuados_grupo_cer).' RECIBOS</span></h5>';
													
													if($bxnActive) {
														$flotante_nuevo .= '
															<div class="col-md-12" style="padding: 0px 0px 0px 0px">
																<div class="row">
																	<div class="col-md-2" style="padding: 0px 0px 0px 0px"></div>
																	<div class="col-md-6" style="padding: 0px 0px 0px 0px"><span class="label label-info">SIN DXN</span>&nbsp&nbsp<span class="label label-default">'.($total - $getCountBxN["effected"]).' RECIBOS</span></div>
																</div>
															</div>
															<div class="col-md-12" style="padding: 0px 0px 10px 0px">
																<div class="row">
																	<div class="col-md-2" style="padding: 0px 0px 0px 0px"></div>
																	<div class="col-md-4" style="padding: 0px 0px 0px 0px"><span class="label label-info">DXN</span>&nbsp&nbsp<span class="label label-default">'.$getCountBxN["effected"].' RECIBOS</span></div>
																</div>
															</div>';
													}

												$flotante_nuevo .= '</div>
												<h5><span class="label label-success">A TIEMPO</span>&nbsp&nbsp&nbsp<span class="label label-default">'.($avance_cobranza_agente_region->recibos_a_tiempo+$avance_cobranza_agente_region->recibos_a_tiempo_cer).' RECIBOS</span></h5>
												<h5><span class="label label-warning">PENDIENTE</span>&nbsp&nbsp&nbsp<span class="label label-default">'.$avance_cobranza_agente_region->recibos_pendientes.' RECIBOS</span></h5>
												<h5><span class="label label-danger">ATRASADA</span>&nbsp&nbsp&nbsp<span class="label label-default">'.$avance_cobranza_agente_region->recibos_atrasados.' RECIBOS</span></h5>';

												if($bxnActive) {
													$flotante_nuevo .= '
														<div class="col-md-12" style="padding: 0px 0px 0px 0px">
															<div class="row">
																<div class="col-md-2" style="padding: 0px 0px 0px 0px"></div>
																<div class="col-md-6" style="padding: 0px 0px 0px 0px"><span class="label label-info">SIN DXN</span>&nbsp&nbsp<span class="label label-default">'.($total_late - $getCountBxN["late"]).' RECIBOS</span></div>
															</div>
														</div>
														<div class="col-md-12" style="padding: 0px 0px 10px 0px">
															<div class="row">
																<div class="col-md-2" style="padding: 0px 0px 0px 0px"></div>
																<div class="col-md-4" style="padding: 0px 0px 0px 0px"><span class="label label-info">DXN</span>&nbsp&nbsp<span class="label label-default">'.$getCountBxN["late"].' RECIBOS</span></div>
															</div>
														</div>';
												}
										} else{
												$flotante_nuevo.='
													<table class="table-sm">
														<thead>
															<tr>
																<td></td>
																<td><span class="label label-info">EFECTUADA</span></td>
																<td><span class="label label-success">A TIEMPO</span></td>
																<td><span class="label label-warning">PENDIENTE</span></td>
																<td><span class="label label-danger">ATRASADA</span></td>
															</tr>
														</thead>
														<tbody>
													';

													$sum_efectuadas=0;
													$sum_pendientes=0;
													$sum_atrasadas=0;
													$sum_a_tiempo=0;

													$sum_efectuadas_seguros=0;
													$sum_pendientes_seguros=0;
													$sum_atrasadas_seguros=0;
													$sum_a_tiempo_seguros = 0;

													$sum_efectuadas_fianzas=0;
													$sum_pendientes_fianzas=0;
													$sum_atrasadas_fianzas=0;
													$sum_a_tiempo_fianzas = 0;

													foreach($cobranzaRegion as $bb){

														$sum_efectuadas += ($bb->recibos_efectuados + $bb->recibos_efectuados_grupo_cer);
														$sum_pendientes += ($bb->recibos_pendientes + $bb->recibos_pendientes_grupo_cer);
														$sum_atrasadas += ($bb->recibos_atrasados + $bb->recibos_atrasados_grupo_cer);
														$sum_a_tiempo += ($bb->recibos_a_tiempo + $bb->recibos_a_tiempo_cer);
														
														if($bb->reporte != "fianzas"){
															$sum_efectuadas_seguros += ($bb->recibos_efectuados + $bb->recibos_efectuados_grupo_cer);
															$sum_pendientes_seguros += ($bb->recibos_pendientes + $bb->recibos_pendientes_grupo_cer);
															$sum_atrasadas_seguros += ($bb->recibos_atrasados + $bb->recibos_atrasados_grupo_cer);
															$sum_a_tiempo_seguros += ($bb->recibos_a_tiempo + $bb->recibos_a_tiempo_cer);

															$flotante_nuevo.='
																<tr>
																	<td>'.ucwords($bb->reporte).'</td>
																	<td class="text-center">'.number_format($bb->recibos_efectuados + $bb->recibos_efectuados_grupo_cer).'</td>
																	<td class="text-center">'.number_format($bb->recibos_a_tiempo + $bb->recibos_a_tiempo_cer).'</td>
																	<td class="text-center">'.number_format($bb->recibos_pendientes + $bb->recibos_pendientes_grupo_cer).'</td>
																	<td class="text-center">'.number_format($bb->recibos_atrasados + $bb->recibos_atrasados_grupo_cer).'</td>
																</tr>
															';

														} else{
															$sum_efectuadas_fianzas += ($bb->recibos_efectuados + $bb->recibos_efectuados_grupo_cer);
															$sum_pendientes_fianzas += ($bb->recibos_pendientes + $bb->recibos_pendientes_grupo_cer);
															$sum_atrasadas_fianzas += ($bb->recibos_atrasados + $bb->recibos_atrasados_grupo_cer);
															$sum_a_tiempo_fianzas += ($bb->recibos_a_tiempo + $bb->recibos_a_tiempo_cer);
														}
													}

												$flotante_nuevo.='
														<tr><td colspan="5" style="border-top: solid"></td></tr>
														<tr><td>Seguros</td><td class="text-center">'.$sum_efectuadas_seguros.'</td><td class="text-center">'.$sum_a_tiempo_seguros.'</td><td class="text-center">'.$sum_pendientes_seguros.'</td><td class="text-center">'.$sum_atrasadas_seguros.'</td></tr>
														<tr><td>Fianzas</td><td class="text-center">'.$sum_efectuadas_fianzas.'</td><td class="text-center">'.$sum_a_tiempo_fianzas.'</td><td class="text-center">'.$sum_pendientes_fianzas.'</td><td class="text-center">'.$sum_atrasadas_fianzas.'</td></tr>
														<tr><td>Total</td><td class="text-center">'.$sum_efectuadas.'</td><td class="text-center">'.$sum_a_tiempo.'</td><td class="text-center">'.$sum_pendientes.'</td><td class="text-center">'.$sum_atrasadas.'</td></tr>
													</tbody>
												</table>
												';
											}
                                     
									$flotante_nuevo.='</div>
									</div>
								';
							}
						}
					}
				}*/ //Fin del obsoleto
			//*******Modificacion 21-04-2021 MJ*****

			$CI->load->model('cuadromando_model');
			$mes = date('m');
			$year = date('Y');
			$user = $this->tank_auth->get_usermail();
			$avance_cobranza_agente_region = $CI->crmproyecto_model->avance_cobranza_agente_region($this->tank_auth->get_idPersona());
			//Semaforo Renovaciones pendientes por renovar
			$renovacionPendientesDespacho = $this->cuadromando_model->getRenovacionesPendientesDespacho();

			//Totales de Polizas pendientes por renovar(Despacho)
			$totalMeridaPendientesDespacho = $renovacionPendientesDespacho[0] + $renovacionPendientesDespacho[1] + $renovacionPendientesDespacho[2];

			$totalCancunPendientesDespacho = $renovacionPendientesDespacho[3] + $renovacionPendientesDespacho[4] + $renovacionPendientesDespacho[5];

			$totalInstitucionalPendientesDespacho = $renovacionPendientesDespacho[6] + $renovacionPendientesDespacho[7] + $renovacionPendientesDespacho[8];

			$totalVerdePendientesDespacho = $renovacionPendientesDespacho[0] + $renovacionPendientesDespacho[6] + $renovacionPendientesDespacho[3];

			$totalAmarilloPendientesDespacho = $renovacionPendientesDespacho[1] + $renovacionPendientesDespacho[7] + $renovacionPendientesDespacho[4];

			$totalRojoPendientesDespacho = $renovacionPendientesDespacho[2] + $renovacionPendientesDespacho[8] + $renovacionPendientesDespacho[5];

			$totalPendientesDespacho = $totalVerdePendientesDespacho + $totalAmarilloPendientesDespacho + $totalRojoPendientesDespacho;
			if ($user == "GERENTEOPERATIVO@AGENTECAPITAL.COM" || $user == "COORDINADOROPERATIVO@ASESORESCAPITAL.COM") {
				include("modal_flotante_kpi_operativo.php");
			}
			if ($user != "COBRANZA@ASESORESCAPITAL.COM" /*&& !in_array($user, $directiveUser)*/) {
				if ($user != "GERENTEOPERATIVO@AGENTECAPITAL.COM" && $user != "COORDINADOROPERATIVO@ASESORESCAPITAL.COM" && $user != "COORDINADORINSTITUCIONAL@AGENTECAPITAL.COM" && $user != "COORDINADOR@CAPCAPITAL.COM.MX" && $user != "COORDINADORCOMERCIAL@CAPCAPITAL.COM.MX" && $user != "COORDINADORCOMERCIAL@FIANZASCAPITAL.COM") {
					$flotante_nuevo .= '
						<div class="card mb-2" style="margin-top: 5px;">
							<div class="card-header text-center text-dark">
								<a data-toggle="collapse" href="#renovaciones" role="button" aria-expanded="false" aria-controls="info_region"><small> <i class="fa fa-refresh"></i>&nbsp;RENOVACIONES ' . (!array_key_exists("reporte", $avance_cobranza_agente_region) ? "AVANCE" : strtoupper($avance_cobranza_agente_region->reporte)) . '</small><span class="caret"></span></a>
							</div>
							<div class="card-body collapse table-responsive muestra_avance_operativo" id="renovaciones">
								<table style="font-size: 11px;width: 100%;text-align: center;">
								<tr>
								<td rowspan="2" style="width: 45%;">
								<span style="font-size:10px;"><i class="fa fa-clock-o"></i> Polizas Pendientes por Renovar</span>
								</td>
								<td colspan="3"><div class="actividadesRenovacion" style="font-size: 10px;padding: 2px;">SEMAFORO</div></td>
								</tr>
								<tr style="text-align: center;background-color: #E2E2E2;">
								<td><span class="badge badge-default" id="verde">+20</span></td>
								<td><span class="badge badge-default" id="amarillo">+1</span></td>
								<td><span class="badge badge-default" id="rojo">-1</span></td>
								<td style="text-align: right;"><b>Totales</b>&nbsp;</td>
								</tr>';

					if ($user == "ATENCIONAGENTESMID@ASESORESCAPITAL.COM") {
						$flotante_nuevo .= '<tr>
									<td style="text-align: right;"><div style="background-color: #347ab7;color: #fff;opacity: 0.9;border-radius: 4px;padding: 2px;font-size: 10px;">MERIDA:&nbsp;&nbsp;</div></td>
									<td style="text-align: center;" class="pendiente-asesores-green-yr"><b>0</b></td>
									<td style="text-align: center;" class="pendiente-asesores-yellow-yr"><b>0</b></td>
									<td style="text-align: center;" class="pendiente-asesores-red-yr"><b>0</b></td>
									<td class="pendiente-asesores-total">0</td>
								</tr>';
					}

					if ($user == "ASISTENTECUN2@AGENTECAPITAL.COM") {
						$flotante_nuevo .= '<tr>
								<td style="text-align: right;"><div style="background-color: #347ab7;color: #fff;opacity: 0.8;border-radius: 4px;padding: 2px;font-size: 10px;">CANCUN:&nbsp;&nbsp;</div></td>
								<td style="text-align: center;" class="pendiente-cap-capital-green-yr"><b>0</b></td>
								<td style="text-align: center;" class="pendiente-cap-capital-yellow-yr"><b>0</b></td>
								<td style="text-align: center;" class="pendiente-cap-capital-red-yr"><b>0</b></td>
								<td class="pendiente-cap-capital-total">0</td>
							</tr>';
					}
					if ($user == "ATENCIONCLIENTES@ASESORESCAPITAL.COM") {
						$flotante_nuevo .= '
								<tr>
									<td style="text-align: right;"><div style="background-color: #347ab7;color: #fff;opacity: 0.7;border-radius: 4px;padding: 2px;font-size: 10px;">INSTITUCIONAL:&nbsp;&nbsp;</div></td>
									<td style="text-align: center;" class="pendiente-institucional-green-yr"><b>0</b></td>
									<td style="text-align: center;" class="pendiente-institucional-yellow-yr"><b>0</b></td>
									<td style="text-align: center;" class="pendiente-institucional-red-yr"><b>0</b></td>
									<td class="pendiente-institucional-total">0</td>
								</tr>';
					}
					$flotante_nuevo .= '
							</table>
						</div></div> <!-- fin flotante dennis -->';
				}
			}
			//Fin de Modificacion
			//$flotante_nuevo.='</div> <!-- fin flotante dennis 2 -->'; //$modal_flotante_cobranza

			/*$user=$this->tank_auth->get_usermail();
				if($user=="DIRECTORGENERAL@AGENTECAPITAL.COM" || $user=="DIRECTORCOMERCIAL@AGENTECAPITAL.COM" || $user=="SISTEMAS@ASESORESCAPITAL.COM" || $user=="GERENTEOPERATIVO@AGENTECAPITAL.COM" || $user == "COORDINADOROPERATIVO@ASESORESCAPITAL.COM" || $user == "DATACENTER@AGENTECAPITAL.COM"){
		
					include("avance_kpi_cobranza.php");
					$flotante_nuevo.="</div>"; //Cierre del card-body.
					$novacio=true;
				}*/

			//Modifcacion Miguel Modal Flotante Operativos 16/04/2021
			if (($this->tank_auth->get_usermail() == "AUTOS@ASESORESCAPITAL.COM") ||
				($this->tank_auth->get_usermail() == "BIENES@ASESORESCAPITAL.COM") ||
				($this->tank_auth->get_usermail() == "LINEASPERSONALES@ASESORESCAPITAL.COM") ||
				($this->tank_auth->get_usermail() == "AUTOSRENOVACIONES@ASESORESCAPITAL.COM") ||
				($this->tank_auth->get_usermail() == "EJECUTIVOCOTIZACIONES@AGENTECAPITAL.COM")
			) {
				$flotante_nuevo .= '<div class="container-fluid"><div class="row"><div style="border: 1px #808B96 solid; border-radius: 5px;">';
				include('modal_flotante_kpi_ejecutivo.php');
				$flotante_nuevo .= '</div></div></div>';
			}
		} catch (Exception $e) {
			//$fp = fopen('resultadoJason.txt', 'a');fwrite($fp, print_r($e->getMessage(),TRUE));fclose($fp);
			echo "Exepcion capturada", $e->getMessage(), "\n";
		}
	}
	?>

	<!---------------------------------->
	<?php
	if ($this->tank_auth->get_idPersona()) { //if($novacio)
		if (in_array("mostrarFlo", $permissions)) {
			$directiveUser = array("DIRECTORGENERAL@AGENTECAPITAL.COM", "SISTEMAS@ASESORESCAPITAL.COM");
			$dxn = $this->tank_auth->get_usermail() == "COORDINADOR@CAPCAPITAL.COM.MX" ? true : false;
	?>
			<input type="hidden" name="usuario" id="usuario" value="<?= $this->tank_auth->get_usermail() ?>">
			<div class="card border-dark mb-3" style="position: fixed; z-index: 10; width: 30%; top:15%" id="flotante_contenedor">
				<div class="card-header text-center">
					<a class="link_collapse" data-toggle="collapse" href="#av_comercial" role="button" aria-expanded="false" aria-controls="av_comercial" onclick="guardarenSesion(this);" ban="0">
						<label for="titulo_comercial" id="titulo_comercial">Avance de KPI<span class="caret"></span></label>
					</a>
				</div>
				<div class="card-body collapse visible" id="av_comercial">
					<?php echo $flotante_nuevo; ?>
					<?= in_array($this->tank_auth->get_usermail(), $agentes_cobranza) || in_array($this->tank_auth->get_usermail(), $directiveUser) ? $this->load->view("headers/kpi_cobranza", array("dias" => $cnc, "dxn" => $dxn)) : ""; ?>
				</div>
			</div>
			<div id="base_url" data-base-url="<?= base_url() ?>"></div>
	<?php }
	}
	?>
	<!---------------------------------->
	<!--<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">

	<script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous"></script>
	<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>
	<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>-->
	<!--<link rel="stylesheet" href="//code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
	<script src="https://code.jquery.com/jquery-1.12.4.js"></script>
	<script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>-->
	<script src="<?= base_url() . "assets/js/js_seguimientoCobranza.js" ?>"></script> <!--Dennis [2021-03-08] -->
	<script src="<?= base_url() . "assets/js/js_elementoArrastrable.js" ?>"></script> <!--Dennis [2021-03-20] -->
	<script src="<?= base_url() . "assets/js/jquery_kpiRenovaciones.js" ?>"></script> <!--Dennis [2021-11-16] -->
	<script src="<?= base_url() . "assets/js/jquery.kpiActividades.js" ?>"></script> <!--Dennis [2022-03-26] -->

	<script>
		$(function() {

			var div_flotante_principal = document.getElementById("flotante_contenedor");

			if (document.body.contains(div_flotante_principal)) {
				elementoArrastrable(div_flotante_principal);
			}
		});

		var ctx = 0;

		function cerrarAlerta_Ejecutivos() {
			if (ctx == 0) {
				document.getElementById('contenedor_info_ejecutivos').style.display = "none";
				document.getElementById('divEjecutivosOperativos').style.height = "4%";
				document.getElementsByClassName("fa-caret-down")[0].classList.replace("fa-caret-down", "fa-caret-up")
				ctx = 1;
			} else {
				document.getElementById('contenedor_info_ejecutivos').style.display = "block";
				document.getElementById('divEjecutivosOperativos').style.height = "85%";
				document.getElementsByClassName("fa-caret-up")[0].classList.replace("fa-caret-up", "fa-caret-down");
				ctx = 0;
			}
		}


		//-------------------
	</script>
	<!--:::::::::: INICIO HEADER ::::::::::-->
	<!--     
	<header class="header-cap">
    </header> 
	-->
	<!--:::::::::: FIN HEADER ::::::::::-->