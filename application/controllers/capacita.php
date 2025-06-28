<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class capacita extends CI_Controller{

	function __construct(){
		parent::__construct();
		$this->load->model('capacita_modelo');
		$this->load->model('PersonaModelo');
		$this->load->model('manejodocumento_modelo');
		$this->load->model('documentos_capitalhumano_model', 'capitalhumanodocs');
        $this->load->model('superestrella_model'); //Creado [Suemy][2024-04-26]
		$this->load->library("libreriav3");
		$this->operPersona=new $this->PersonaModelo;
	}

	function index(){		
		if (!$this->tank_auth->is_logged_in()) {
			redirect('/auth/login/');
		} else {
			$data['videos']=$this->capacita_modelo->get_videos();
			 //[Dennis]
			$data['contVistas']=$this->capacita_modelo->get_contVistas();
			$this->idPersona=$this->tank_auth->get_idPersona();
			$this->emailUser=$this->tank_auth->get_usermail();
			
    		$data['tipoModalidad']=$this->operPersona->obtenerModalidades($this->idPersona);
    		$data['capacitacion']=$this->operPersona->devuelveTipoCapacitacion();
  			$data['IDVendNS']=$this->operPersona->obtenerVendedoresActivos();
			$data['agentesTemporales']=$this->operPersona->obtenerPersonas($this->emailUser,3);
			$data['coordinadores']=$this->operPersona->devuelveHijosCoordinador("SISTEMAS@ASESORESCAPITAL.COM");//$this->operPersona->devuelveCoordinadoresVentas(); //($this->tank_auth->get_usermail()=="SISTEMAS@ASESORESCAPITAL.COM" || $this->tank_auth->get_usermail()=="DIRECTORGENERAL@AGENTECAPITAL.COM") ? $this->operPersona->devuelveCoordinadoresVentas() : $this->operPersona->obtVendAct();
			
			$this->load->view('capacita/principal', $data);
		}
	}
	function votarvideo(){
		$video = $this->input->post('id',TRUE);
		$action = $this->input->post('lk');
		$data = array(
			'idPersona' => $this->input->post('us'),
			'video_id' => $video,
			'id_capacitacion' => $this->input->post('ct'),
			'accion' => "calificar",
			'ultimo_acceso' => date("Y-m-d H:i:s")
		);
		if ($action != "0") {
			$this->capacita_modelo->quitar_voto($data);
			$this->capacita_modelo->eliminar_accion($action);
		}
		else {
		$this->capacita_modelo->votar_video($data);
			$this->capacita_modelo->registrar_accion($data);
    		//$this->videos();
		}
		$info = $this->capacita_modelo->get_videos_id($video);
    	echo json_encode($info);
	}

	function votarvistas(){
		$video = $this->input->post('id',TRUE);
		$view = $this->input->post('vw');
		$data = array(
			'idPersona' => $this->input->post('us'),
			'video_id' => $video,
			'id_capacitacion' => $this->input->post('ct'),
			'accion' => "ver",
			'ultimo_acceso' => date("Y-m-d H:i:s")
		);
		$this->capacita_modelo->votar_vistas($data);
    	//$this->videos();
		if ($view != "0") {
			$data['id'] = $view;
			$this->capacita_modelo->actualizar_accion($data);
		}
		else {
			$this->capacita_modelo->registrar_accion($data);
		}
		$result = $this->capacita_modelo->get_videos_id($video);
    	echo json_encode($result);
	}

	function votarvistasnombres(){
		$id=$this->input->post('id',TRUE);
		$data = array(
			'video_id' => $id
			);

		$result = $this->capacita_modelo->votar_vistas_nombres($data);
		echo json_encode($result);
	}



	function videos(){
		if (!$this->tank_auth->is_logged_in()) {
			redirect('/auth/login/');
		} else {
		$data['videos']=$this->capacita_modelo->get_videos();
		$data['categorias']=$this->capacita_modelo->categoria_videos();
		$this->load->view('capacita/videos',$data);
	}
	}

	function cargarvideos_categoria($categoria){
		$data['videos']=$this->capacita_modelo->get_videos_categoria($categoria);
		$data['contVistas']=$this->capacita_modelo->get_contVistas();
		$this->load->view('capacita/videos_id',$data);
	}

	function cargarvideo_visto() {
		$user = $this->input->post('id');
		$category = $this->input->post('ct');
		$data = $this->capacita_modelo->get_videos_vistos($user,$category);
		echo json_encode($data);
	}
	function cargarvideos(){
		if (!$this->tank_auth->is_logged_in()) {
			redirect('/auth/login/');
		} 
		else {
		$data['categorias']=$this->capacita_modelo->categoria_videos();
		$data['ramos']=$this->capacita_modelo->ramo_videos();
		$data['videos']=$this->capacita_modelo->get_videos();
	 	$this->load->view('capacita/cargar_video', $data);
	}
	}

	//2.) Controlador con recepcion de parametro e instancia de modelo y recepcion de consulta
	function cargarsubcategoria($categoria){
		$data['subcategorias']=$this->capacita_modelo->sub_categoria_videos($categoria);
		$this->load->view('capacita/subcategoria',$data);
	}

	function editar_video($id){
		$data['categorias']=$this->capacita_modelo->categoria_videos();
		$data['ramos']=$this->capacita_modelo->ramo_videos();
		$data['videos']=$this->capacita_modelo->get_videos_id($id);
		$this->load->view('capacita/editar_video',$data);
	}

	function guardarvideo(){
		$data = array(
		'nombre' => strtoupper($this->input->post('nombre',TRUE)),
		'categoria' => $this->input->post('categoria',TRUE),
		'subcategoria' => $this->input->post('subcategoria',TRUE),
		'ramo' => $this->input->post('ramo',TRUE),
    	'descripcion' => $this->input->post('descripcion',TRUE),
    	'lecciones' => $this->input->post('lecciones',TRUE),
    	'examen' => $this->input->post('examen',TRUE),
    	'duracion' => $this->input->post('duracion',TRUE),
    	'estudiantes' => $this->input->post('estudiantes',TRUE),
		'certificado' => $this->input->post('certificado',TRUE),
		'id_ramo' => $this->input->post('ramo',TRUE)
    	);
    	$this->capacita_modelo->guardar_video($data);
    	$this->cargarvideos();
	}

	function borrarvideo($id){
		$this->capacita_modelo->borrar_video($id);
		$this->capacita_modelo->eliminar_video($id);
		redirect('capacita/cargarvideos');
	}

	function modificarurlvideo(){
		$data = array(
			'id' => $this->input->post('id',TRUE),
			'video' => $this->input->post('video',TRUE)
		);
		$this->capacita_modelo->modificar_url_video($data);
    	$this->cargarvideos();
	}
	function modificarurlimagen(){
		$data = array(
			'id' => $this->input->post('id',TRUE),
			'imagen' => $this->input->post('imagen',TRUE)
		);
		$this->capacita_modelo->modificar_url_imagen($data);
    	$this->cargarvideos();
	}

	function modificarurldocumento(){
		$data = array(
			'id' => $this->input->post('id',TRUE),
			'documento' => $this->input->post('documento',TRUE)
		);
		$this->capacita_modelo->modificar_url_documento($data);
    	$this->cargarvideos();
	}

	function modificarvideo(){
		$data = array(
			'id' => $this->input->post('id',TRUE),
			'nombre' => $this->input->post('nombre',TRUE),
			'descripcion' => $this->input->post('descripcion',TRUE),
			'categoria' => $this->input->post('categoria',TRUE),
			'subcategoria' => $this->input->post('subcategoria',TRUE),
			'ramo' => $this->input->post('ramo',TRUE),
	    	'lecciones' => $this->input->post('lecciones',TRUE),
	    	'examen' => $this->input->post('examen',TRUE),
	    	'duracion' => $this->input->post('duracion',TRUE),
	    	'estudiantes' => $this->input->post('estudiantes',TRUE),
			'certificado' => $this->input->post('certificado',TRUE),
			'id_ramo' => $this->input->post('ramo',TRUE)
		);
		$this->capacita_modelo->modificar_video($data);
    	$this->cargarvideos();
	}

function solicitar_evaluacion(){
		$titulo_solicitud=$this->input->post('titulo_solicitud',TRUE);
		$categoria_solicitud=$this->input->post('categoria_solicitud',TRUE);
		$certificacion_solicitud=$this->input->post('certificacion_solicitud',TRUE);
		$nombre_solicitud=$this->input->post('nombre_solicitud',TRUE);
		$email_solicitud=$this->input->post('email_solicitud',TRUE);

$fecha=date('d-m-Y');


$mensaje="<DOCTYPE html>
<html>
<head>
	<title></title>
</head>
<body>
<table width='75%' align='center' border='1' style='border-collapse:collapse; border-color: #b2b2b2;'>
	<tr>
		<td align='center' colspan='2'>
			<img src='https://www.capsys.com.mx/V3/assets/images/logo_capacita.png' width='25%'>
		</td>
	</tr>
	<tr>
		<td colspan='2' align='left'><b>Fecha solicitud:&nbsp;&nbsp;</b>". $fecha."</td>
	</tr>
	<tr align='center'><td colspan='2'><h2 style='color: blue;'>SOLICITUD DE EVALUACIÓN</h2></td></tr>
	<tr>
		<td><b>Titulo del Curso:</b></td>
		<td>".$titulo_solicitud."</td>
	</tr>
	<tr>
		<td width='30%'><b>Categoria:</b></td>
		<td>".$categoria_solicitud."</td>
	</tr>
	<tr>
		<td><b>Certificacion:</b></td>
		<td>".$certificacion_solicitud."</td>
	</tr>
	
	<tr>
		<td colspan='2' align='center'>
			<b>********* DATOS DEL SOLICITANTE *********</b>
		</td>
	</tr>
	<tr>
		<td><b>Nombre solicitante:</b></td>
		<td>".$nombre_solicitud."</td>
	</tr>
	<tr>
		<td><b>Email del solicitante:</b></td>
		<td>".$email_solicitud."</td>
	</tr>
</table>
</body>
</html>";




/*************Envio de Correo ***********/
$para="SERVICIOSESPECIALES@AGENTECAPITAL.COM";
$titulo    = "Solicitud de Evaluacion - Capacita - Capital Seguros y Fianzas";
$cabeceras = 'MIME-Version: 1.0' . "\r\n";
$cabeceras .= 'Content-type: text/html; charset=utf-8' . "\r\n";
$cabeceras .= 'From: info@agentecapital.com' . "\r\n" .'Reply-To:info@agentecapital.com' . "\r\n" .'X-Mailer: PHP/';
mail($para, $titulo, $mensaje, $cabeceras);

		$data = array(
			'fecha' => $this->input->post('fecha',TRUE),
			'nombre_curso' => $this->input->post('titulo_solicitud',TRUE),
			'categoria' => $this->input->post('categoria_solicitud',TRUE),
			'certificacion' => $this->input->post('certificacion_solicitud',TRUE),
			'nombre_solicitante' => $this->input->post('nombre_solicitud',TRUE),
	    	'email_solicitante' => $this->input->post('email_solicitud',TRUE)
		);

		$this->capacita_modelo->guardar_solicitud_evaluacion($data);
    	redirect('capacita/videos');
	}

//-----------------------------------------------
function asignaImgCurso(){
	$agentes=$_POST["agente"];
	//$fp = fopen('resultadoJason.txt', 'w');fwrite($fp, print_r($_FILES["archivo"]["name"], TRUE));fclose($fp);
	if($_FILES["archivo"]["name"]!="" && $_POST["agente"]!=""){
	  $this->manejodocumento_modelo->insertaImgsCurso($agentes,$_FILES);
	  //$fp = fopen('resultadoJason.txt', 'w');fwrite($fp, print_r("si hay archivo", TRUE));fclose($fp);
	}
	else{
	  echo "Se recibieron datos incompletos, intenta de nuevo";
	}
  }
//----------------------------------------------- //Obsoleto
function ingresaCapacitacion(){
	$asignaCapa=array();
	$fp = fopen('resultadoJason.txt', 'w');fwrite($fp, print_r($_POST['idPersona'], TRUE));fclose($fp);
	$agente=$_POST['idPersona'];
  
	for($i=0;$i<count($agente);$i++){
	  $asignaCapa[$i]=array(
		"idPersona"=>$agente[$i],
		"emailCreador"=>$this->tank_auth->get_usermail(),
		"certificacion"=>!empty($_POST['certificacion']) ? $_POST['certificacion'] : 0,
		"certificacionAutos"=> !empty($_POST['certificacionAutos']) ? $_POST['certificacionAutos'] : 0,//$_POST['certificacionAutos'],
		"certificacionGmm"=>!empty($_POST['certificacionGmm']) ? $_POST['certificacionGmm'] : 0,//$_POST['certificacionGmm'],
		"certificacionVida"=>!empty($_POST['certificacionVida']) ? $_POST['certificacionVida'] : 0,//$_POST['certificacionVida'],
		"certificacionDanos"=>!empty($_POST['certificacionDanos']) ? $_POST['certificacionDanos'] : 0,//$_POST['certificacionDanos'],
		"certificacionFianzas"=>!empty($_POST['certificacionFianzas']) ? $_POST['certificacionFianzas'] : 0,//$_POST['certificacionFianzas'],
		"descripcion"=>!empty($_POST['descripcion']) ? $_POST['descripcion'] : "Sin comentario",//$_POST['descripcion'],
		"mes"=>date("n"),
		"anio"=>date("Y"),
		"fechaAsignada"=>date("Y-m-d"),
		"id_certificado"=> $_POST["nameSelectCerti"]);
	}
	
	$this->operPersona->insertaCertificaciones($asignaCapa);
}
  //-----------------------------------------------
function gestionaCapacitacion(){

	$email = $this->tank_auth->get_usermail();

	//$data['agentesTemporales']=$this->operPersona->obtenerPersonas("SISTEMAS@ASESORESCAPITAL.COM",3);

	//$data["puestos_y_personas"] = $this->libreriav3->agrupaPersonasParaSelect($data['agentesTemporales']);
	$data['capacitacion']=$this->operPersona->devuelveTipoCapacitacion();

	//$fp = fopen('resultadoJason.txt', 'w');fwrite($fp, print_r($data['agentesTemporales'], TRUE));fclose($fp);

	$this->load->view("capacita/gestionHorasCapacitacion"); //$data
}
//-----------------------------------------------
function obtenerCapacitaciones(){

	$solicitud  = $this->operPersona->devuelveTipoCapacitacion();

	echo json_encode($solicitud);
}
//-----------------------------------------------
function gestionCapacitacion(){

	$retorno_json = array();

	switch($_GET["a"]){
		case "capacitacion" : $retorno_json = $this->operPersona->devuelveTipoCapacitacion();
		break;
		case "personas" : $retorno_json = $this->libreriav3->agrupaPersonasParaSelect($this->operPersona->obtenerPersonas("SISTEMAS@ASESORESCAPITAL.COM",3));
		break;
		case "sub_capacitacion" : $retorno_json = $this->operPersona->devuelveTipoCertificado($_GET["b"]);
		break;
		case "ramos": $retorno_json = $this->operPersona->devuelveRamo();
		break;
		case "categorias": $retorno_json = $this->capacita_modelo->obtenerCategorias();
		break;
	}

	//$fp = fopen('resultadoJason.txt', 'w');fwrite($fp, print_r($this->libreriav3->agrupaPersonasParaSelect($this->operPersona->obtenerPersonas("SISTEMAS@ASESORESCAPITAL.COM",3)), TRUE));fclose($fp);

	echo json_encode($retorno_json);
}
//------------------------------------------
function registraDatosDeCapacitacion(){ //Dennis [2021-08-18]

	$_c = json_decode($this->input->post("capacitacion"));
	$_s_c = json_decode($this->input->post("sub_capacitacion"));
	$_r = json_decode($this->input->post("ramos"), true);
	$_p = json_decode($this->input->post("personas"));
	$_h_r = json_decode($this->input->post("horas_asignadas"), true);
	//$_f_p = json_decode($this->input->post("filesPersons"), true);
	$band = json_decode($this->input->post("tipo_registro"));
	$anexo = $band == 2 ? json_decode($this->input->post("filesPersons"), true) : json_decode($this->input->post("personasResposables"), true);

	/*idCertificacion, idPersona, id_invitado, emailCreador, certificacion, certificacionAutos, certificacionGmm, certificacionVida, certificacionDanos, certificacionFianzas, mes, fechaAsignada, anio, descripcion, id_certificado, id_evento*/
	//$fp = fopen('resultadoJason.txt', 'w');fwrite($fp, print_r($_POST, TRUE));fclose($fp);

	$val = array();
	$_val = array();

	$filtro = array_filter($_r[0], function($v){
		return $v != true;
	});

	foreach($_h_r as $key => $d_r_h){

		$val[$key] = !array_key_exists($key, $_r[0]) || array_key_exists($key, $filtro) ? 0 : $d_r_h;
	}

	//$fp = fopen('resultadoJason.txt', 'w');fwrite($fp, print_r(array($val, $_p, $_s_c, $band, $anexo), TRUE));fclose($fp);
	$response = $this->registraCapacitacionNuevo($val, $_p, $_s_c, $band, $anexo, $this->tank_auth->get_usermail());
	$fp = fopen('resultadoJason.txt', 'w');fwrite($fp, print_r($response, TRUE));fclose($fp);

	echo json_encode($response);
}
//------------------------------------------ Script para sincronizar con al tabla anterior
function getAllOldDataCapacita(){ //Dennis [2021-08-18]

	$allCapacitacion = $this->capacita_modelo->devuelveHorasCapacitacion();
	//$fp = fopen('resultadoJason.txt', 'w');fwrite($fp, print_r($allCapacitacion, TRUE));fclose($fp);

	foreach($allCapacitacion as $d_c){

		$persona[0] = (object) array("idPersona" => $d_c->idPersona);
		$subCapa[0] = (object) array("valor" => $d_c->id_certificado);
		$bandera = 1;
		$idResponsable = $this->operPersona->obtenerIdPersonaPorEmail($d_c->emailCreador);
		$anexo_["fechaParaCapacitacion"] = $d_c->fechaAsignada;
		$anexo_["responsables"][0] = array("idPersona" => $idResponsable->idPersona);

		$horaRamos = array(
			"profesional" => $d_c->certificacion,
			"vida" => $d_c->certificacionVida,
			"danios" => $d_c->certificacionDanos,
			"autos" => $d_c->certificacionAutos,
			"fianzas" => $d_c->certificacionFianzas,
			"gmm" => $d_c->certificacionGmm,
		);

		$this->registraCapacitacionNuevo($horaRamos, $persona, $subCapa, $bandera, $anexo_, $d_c->emailCreador);

		var_dump($persona);
		var_dump($subCapa);
		var_dump($anexo_);
		var_dump($horaRamos);
	}
}
//------------------------------------------
function registraCapacitacionNuevo($horasYramo, $persona, $subCapa, $bandera, $anexo, $creador){ //Dennis [2021-08-18]

	$response["hours"] = array();
	//$response["register"] = array();
	$response["hourCategoryRelationship"] = array();
	$response["creator"] = array();
	$response["persons"] = array();
	
	foreach($horasYramo as $ramo => $hora){

		if($hora > 0){

			$datosRamo = $this->capacita_modelo->devuelveRamo(str_replace("danios", "daños", $ramo));

			$insertaHora = $this->capacita_modelo->insertaRegistro(array(
				"fecha" => date("Y-m-d"),
				"horas" => $hora,
				"idSubCapacitacion" => $subCapa[0]->valor,
			), "capacita_registros_horas");

			array_push($response["hours"], array("bool" => $insertaHora["bool"], "category" => str_replace("danios", "daños", $ramo)));
			
			if($insertaHora["bool"]){

				$insertaRelacionHoraRamo = $this->capacita_modelo->insertaRegistro(array(
					"idRegistroHora" => $insertaHora["lastId"],
					"idR" => $datosRamo->idR
				), "capacita_relacion_hora_ramo"); //Independt
	
				$insertaCreador = $this->capacita_modelo->insertaRegistro(array(
					"idRegistroHora" => $insertaHora["lastId"],
					"creadorAlta" => $creador,
				),"capacita_usuario_creador"); //Independt

				array_push($response["hourCategoryRelationship"], array("bool" => $insertaRelacionHoraRamo["bool"], "category" => str_replace("danios", "daños", $ramo))); // $insertaRelacionHoraRamo
				array_push($response["creator"], array("bool" => $insertaCreador["bool"], "who" => $creador)); //$insertaCreador

				foreach($persona as $_persona){

					$insertaReferenciaArchivo = array();
					$insertaReferenciaResponsable = array();

					$insertaRegistros = $this->capacita_modelo->insertaRegistro(array(
						"idPersona" => $_persona->idPersona,
						"idRegistroHora" => $insertaHora["lastId"],
						"tipoRegistro" => $bandera == 2 ? "externo" : "interno",
						"estado" => "activo",
					), "capacita_registros");
	
					if($bandera == 2){
						$insertaReferenciaArchivo = $this->capacita_modelo->insertaRegistro(array(
							"archivo" => $anexo[$_persona->idPersona][$ramo]["nombre"],
							"idRegistro" => $insertaRegistros["lastId"],
						), "capacita_documentacion"); //Independt
	
					} elseif($bandera == 1){
	
						foreach($anexo["responsables"] as $d_a){
	
							$insertaReferenciaResponsable = $this->capacita_modelo->insertaRegistro(array(
								"responsable" => $d_a["idPersona"],
								"fechaCompromiso" => date("Y-m-d", strtotime($anexo["fechaParaCapacitacion"])), //date("Y-m-d"), //$anexo["fechaParaCapacitacion"],
								"idRegistro" => $insertaRegistros["lastId"]
							), "capacita_responsable"); //Independt
						}
					}

					array_push($response["persons"], array(
						"idPersona" => $_persona->idPersona, 
						"band" => $bandera, 
						"extra" => ($bandera == 1 ? $insertaReferenciaResponsable["bool"] : $insertaReferenciaArchivo["bool"]),
						"category" => str_replace("danios", "daños", $ramo),
						"register" => $insertaRegistros["bool"])
					);
				}
			}
		}
	}

	return $response;
}
//------------------------------------------
function registraCapacitacionNuevo_respaldo($horasYramo, $persona, $subCapa, $bandera, $anexo, $creador){ //Dennis [2021-08-18]

	$response["hours"] = array();
	$response["register"] = array();
	$response["hourCategoryRelationship"] = array();
	$response["creator"] = array();
	$response["documents"] = array();
	$response["responsable"] = array();
	
	//try{
		foreach($horasYramo as $ramo => $hora){

			if($hora > 0){
	
				$datosRamo = $this->capacita_modelo->devuelveRamo(str_replace("danios", "daños", $ramo));
	
				$insertaHora = $this->capacita_modelo->insertaRegistro(array(
					"fecha" => date("Y-m-d"),
					"horas" => $hora,
					"idSubCapacitacion" => $subCapa[0]->valor,
				), "capacita_registros_horas");
				
				$insertaRelacionHoraRamo = $this->capacita_modelo->insertaRegistro(array(
					"idRegistroHora" => $insertaHora["lastId"],
					"idR" => $datosRamo->idR
				), "capacita_relacion_hora_ramo"); //Independt
	
				$insertaCreador = $this->capacita_modelo->insertaRegistro(array(
					"idRegistroHora" => $insertaHora["lastId"],
					"creadorAlta" => $creador,
				),"capacita_usuario_creador"); //Independt
				
				array_push($response["hours"], $insertaHora);
				array_push($response["hourCategoryRelationship"], $insertaRelacionHoraRamo);
				array_push($response["creator"], $insertaCreador);

				foreach($persona as $_persona){
	
					$insertaRegistros = $this->capacita_modelo->insertaRegistro(array(
						"idPersona" => $_persona->idPersona,
						"idRegistroHora" => $insertaHora,
						"tipoRegistro" => $bandera == 2 ? "externo" : "interno",
						"estado" => "activo",
					), "capacita_registros");
	
					if($bandera == 2){
						$insertaReferenciaArchivo = $this->capacita_modelo->insertaRegistro(array(
							"archivo" => $anexo[$_persona->idPersona][$ramo]["nombre"],
							"idRegistro" => $insertaRegistros,
						), "capacita_documentacion"); //Independt
	
					} elseif($bandera == 1){
	
						foreach($anexo["responsables"] as $d_a){
	
							$insertaReferenciaResponsable = $this->capacita_modelo->insertaRegistro(array(
								"responsable" => $d_a["idPersona"],
								"fechaCompromiso" => date("Y-m-d", strtotime($anexo["fechaParaCapacitacion"])), //date("Y-m-d"), //$anexo["fechaParaCapacitacion"],
								"idRegistro" => $insertaRegistros
							), "capacita_responsable"); //Independt
						}
					}
				}
			}
		}
	//} catch(Exception $e){
		//echo "error capturado".$e->getMessage();
	//}
}
//-----------------------------------------
function reporteDeCapacitacionManual(){ //Dennis [2021-08-18]

	$Mi_seguimiento_actual = array();
	$Mi_historial_capacitacion = array();

	$correos_validos=array(
		"SISTEMAS@ASESORESCAPITAL.COM",
		"ASISTENTEDIRECCION@AGENTECAPITAL.COM",
		"DIRECTORGENERAL@AGENTECAPITAL.COM",
		"DIRECTORCOMERCIAL@AGENTECAPITAL.COM",
		"GERENTECORPORATIVO@CAPITALSEGUROS.COM.MX",
		"MARKETING@AGENTECAPITAL.COM",
		"GERENTEOPERATIVO@AGENTECAPITAL.COM",
		"COORDINADORINSTITUCIONAL@AGENTECAPITAL.COM",
		"COORDINADOR@CAPCAPITAL.COM.MX",
		"COORDINADORCOMERCIAL@CAPCAPITAL.COM.MX",
		"COORDINADORCOMERCIAL@FIANZASCAPITAL.COM",
		"CAPITALHUMANO@AGENTECAPITAL.COM",
		"ASISTENTEDIRECTOR@AGENTECAPITAL.COM",
		"SERVICIOSESPECIALES@AGENTECAPITAL.COM",
	);

	$capacitaciones = $this->capacita_modelo->devuelveMiCapacitacion($this->tank_auth->get_idPersona());
	$ramos = $this->operPersona->devuelveRamo();
	$horas_ = $this->capacita_modelo->devuelveHorasCapacitacionNuevo();
	$nuevoContenedor = array();
	$restructuredArray = array();

	if(!empty($ramos)){
		foreach($horas_ as $d_hrs){

			if(!empty($horas_)){
				$validador = array();
				foreach($ramos as $d_r){
					
					if(!empty($d_hrs->idPersona)){
						$nombre = $this->operPersona->obtenerNombrePersona($d_hrs->idPersona);
						$restructuredArray[$d_hrs->idPersona]["nombre"] = $nombre; //$d_hrs->idPersona;

						if(strtolower($d_r->nombre_ramo) == strtolower($d_hrs->nombre_ramo)){

							$restructuredArray[$d_hrs->idPersona]["registros"][$d_hrs->nombre_ramo] = $d_hrs->horas;
							//array_push($validador, strtolower($d_hrs->nombre_ramo));
						}
					}
				}
			}
		}

		foreach($restructuredArray as $id => $data){
			$validador = array();
			foreach($ramos as $d_ramo){
				foreach($data["registros"] as $ramo_ => $hour){
					if($ramo_ == $d_ramo->nombre_ramo){
						$Mi_historial_capacitacion[$id]["nombre"] = $data["nombre"];
						$Mi_historial_capacitacion[$id]["registros"][$ramo_] = $hour;
						array_push($validador, $ramo_);
					}
				}
				if(!in_array($d_ramo->nombre_ramo, $validador)){
					$Mi_historial_capacitacion[$id]["registros"][$d_ramo->nombre_ramo] = 0;
				}
			}
		}
	}


	if(!empty($capacitaciones)){
		foreach($capacitaciones as $d_c){

			$Mi_seguimiento_actual[$d_c->tipoCapacitacion][$d_c->nombreCertificado][$d_c->nombre_ramo] = $d_c->horas;
		}
	}

	$data["Cap_actual"] = $Mi_seguimiento_actual;
	$data["Cap_historial"] = $Mi_historial_capacitacion;
	$data["valida"] = in_array($this->tank_auth->get_usermail(),$correos_validos) ? 1 : 0;
	//$data["ramos"] = $ramos;
	$fp = fopen('resultadoJason.txt', 'w');fwrite($fp, print_r($Mi_historial_capacitacion, TRUE));fclose($fp);
	$this->load->view("capacita/reporteCapacitacionManual",$data);
}
//------------------------------------------
function obtenerListadoCapacitacion(){ //Dennis [2021-08-18]

	$mi_seguimiento = $this->capacita_modelo->devuelveCapacitacionEspecifica(array(
		"c" => isset($_GET["_c"]) ? $_GET["_c"] : "",
		"sc" => isset($_GET["_s_c"]) ? $_GET["_s_c"] : "",
		"r" => isset($_GET["_r"]) ? $_GET["_r"] : "",
		"t" => isset($_GET["_m"]) ? $_GET["_m"] : "",
		"u" => $this->tank_auth->get_idPersona()
	));

	echo json_encode($mi_seguimiento);
}
//-----------------------------------------
function obtenerSeguimientoCapacitacion(){ //Dennis [2021-08-18]

	$data_response = array();
	//$get_data = $this->capacita_modelo->devuelveAltasCapacitaciones($this->tank_auth->get_usermail(), $_GET["mes"]);
	$get_data = $this->capacita_modelo->delvuelveAltaDeCapacitacion($this->tank_auth->get_usermail());

	if(!empty($get_data)){
		foreach($get_data as $data){

			$data_response[$data->creadorAlta][$data->idPersona]["datosPersona"] = array( //$data->emailCreador
				"nombres" => $data->nombres,
				"apellidoPaterno" => $data->apellidoPaterno,
				"apellidoMaterno" => $data->apellidoMaterno,
				"username" =>  $data->email, //$data->username,
			);

			//$data_response[$data->emailCreador][$data->idPersona]["datosCapacitacion"][$data->id_capacitacion]["tipoCapacitacion"] = $data->tipoCapacitacion;
			//$data_response[$data->emailCreador][$data->idPersona]["datosCapacitacion"][$data->id_capacitacion]["sub_capacitacion"][$data->id_certificado] = array("nombre_certificado" => $data->nombreCertificado);
		}
	}

	//$fp = fopen('resultadoJason.txt', 'w');fwrite($fp, print_r($data_response, TRUE));fclose($fp);

	echo json_encode($data_response);
}
//-----------------------------------------
function devuelveInformacionCapacitacionPersona(){ //Dennis [2021-08-18]

	$persona_registro = $this->capacita_modelo->devuelveInformacionDeCapacitacion($_GET["idPersona"]);
	$response = array();
	//$fp = fopen('resultadoJason.txt', 'w');fwrite($fp, print_r($persona_registro, TRUE));fclose($fp);
	if(!empty($persona_registro)){

		foreach($persona_registro as $data){

			$response[$data->tipoCapacitacion][] = array(
				"id_capacitacion" => $data->id_capacitacion,
				"idRegistro" => $data->idRegistro,
                "horas" => $data->horas,
                "idPersona" => $data->idPersona,
                "tipoRegistro" => $data->tipoRegistro,
                "fecha" => $data->fecha,
            	"nombre_ramo" => $data->nombre_ramo,
                "nombreCertificado" => $data->nombreCertificado,
                "tipoCapacitacion" => $data->tipoCapacitacion,
                "creadorAlta" => $data->creadorAlta,
				"anexoResponsables" => $this->devuelveResponsables($data->idRegistro),
				"anexoArchivo" => $data->archivo,
			);
		}
	}
	//$fp = fopen('resultadoJason.txt', 'w');fwrite($fp, print_r($response, TRUE));fclose($fp);
	echo json_encode($response);
}
//-----------------------------------------------
function devuelveResponsables($registro){ //Dennis [2021-08-18]

	$arrayResponse = array();
	$consulta = $this->capacita_modelo->devuelveResponsables($registro);

	if(!empty($consulta)){
		foreach($consulta as $d_rep){
			
			$nombrePersona = $this->operPersona->obtenerNombrePersona($d_rep->responsable);

			$arrayResponse["fechaCompromiso"] = $d_rep->fechaCompromiso;
			$arrayResponse["responsables"][] = array(
				"nombre" => $nombrePersona
			);
		}
	}
	//$fp = fopen('resultadoJason.txt', 'w');fwrite($fp, print_r($arrayResponse, TRUE));fclose($fp);
	return $arrayResponse;
}
//-----------------------------------------
function eliminarRegistro(){ //Dennis [2021-08-18]

	$resultado = array();
	$delete = $this->capacita_modelo->destruyeRegistroDeCapacitacion($_GET["idRegistro"]);

	$resultado["bool"] = $delete;
	$resultado["mensaje"] = $delete ? "Registro eliminado con éxito" : "Registro no eliminado. Contactar a sistemas";

	echo json_encode($resultado);
}
//-----------------------------------------------
function editarRegistroDeCapacitacion(){ //Dennis [2021-08-18]

	$idRegistro = $_GET["q"];
	$anexos = array();
	$obtenerRegistro = $this->capacita_modelo->devuelveCapacitacionPorIdRegistro($idRegistro);

	if($obtenerRegistro->tipoRegistro == "interno"){
		$internalData = $this->capacita_modelo->devuelveResponsables($obtenerRegistro->idRegistro);
		//$arrayResponsable = array();
		foreach($internalData as $d_i){
			$dataUser = $this->operPersona->obtenerDatosUsuarios($d_i->responsable, "*");
			$data["anexos"][] = array(
				"DNI" => $d_i->idResponsable,
				"idPersona" => $dataUser->idPersona,
				"nombre" => $dataUser->name_complete,
				"email" => $dataUser->email
			);
			$data["puestos_y_personas"] = $this->libreriav3->agrupaPersonasParaSelect($this->operPersona->obtenerPersonas("SISTEMAS@ASESORESCAPITAL.COM",3));
		}
	} elseif($obtenerRegistro->tipoRegistro == "externo"){
		$data["anexos"] = $this->capacita_modelo->obtenerArchivosDeCapacitacion($obtenerRegistro->idRegistro);
	}

	$data["datosCapacitacion"] = $obtenerRegistro;
	$data["capacitacion"] = $this->operPersona->devuelveTipoCapacitacion();
	$data["ramo"] = $this->operPersona->devuelveRamo();

	$fp = fopen('resultadoJason.txt', 'w');fwrite($fp, print_r($data, TRUE));fclose($fp);
	$this->load->view("capacita/editarRegistroCapacitacion", $data);
}
//-----------------------------------------------
function actualizaRegistro(){ //Dennis [2021-08-18]

	//$prueba = $_FILES["archivo"];
	$nombreArchivo = $this->input->post("archivo");
	$capacitacion = $this->input->post("capacitacion");
	$subCapacitacion = $this->input->post("sub-capacitacion");
	$ramo = $this->input->post("ramo");
	$horas = $this->input->post("horas");
	$creador = $this->input->post("creador");
	$registro = $this->input->post("idRegistro");

	$actualiza = $this->capacita_modelo->actualizaRegistro(array(
		"capacitacion" => $capacitacion,
		"subCapacitacion" => $subCapacitacion,
		"ramo" => $ramo,
		"horas" => $horas,
		"idRegistro" => $registro,
		"archivo" => $nombreArchivo
	));

	if($actualiza){
		$act_reg = $this->capacita_modelo->insertaRegistro(array(
			"fecha" => date("Y-m-d H:i:s"),
			"realizo" => $this->tank_auth->get_usermail(),
			"idRegistro" => $registro
		),"capacita_actualizacion_registro");
	}

	echo json_encode(array("update" => $actualiza));

	//$fp = fopen('resultadoJason.txt', 'w');fwrite($fp, print_r($datosParaActualizar, TRUE));fclose($fp);
}
//-----------------------------------------------
function actualizaRegistroInterno(){

	$dataUpdate = json_decode($_POST["dataSend"], true);
	//$fp = fopen('resultadoJason.txt', 'w');fwrite($fp, print_r($dataUpdate, TRUE));fclose($fp);
	$actualiza = $this->capacita_modelo->actualizaRegistroInterno_(array(
		"capacitacion" => $dataUpdate["capacitacion"],
		"subCapacitacion" => $dataUpdate["sub-capacitacion"],
		"ramo" => $dataUpdate["ramo"],
		"horas" => $dataUpdate["horas"],
		"idRegistro" => $dataUpdate["idRegistro"],
		//"archivo" => $nombreArchivo
	));

	if($actualiza){

		foreach($dataUpdate["responsables"] as $d_res){
			$responsable = $this->capacita_modelo->insertaRegistro(array(
				"responsable" => $d_res,
				"fechaCompromiso" => date("Y-m-d"),
				"idRegistro" => $dataUpdate["idRegistro"],
			), "capacita_responsable");
		}

		$act_reg = $this->capacita_modelo->insertaRegistro(array(
			"fecha" => date("Y-m-d H:i:s"),
			"realizo" => $this->tank_auth->get_usermail(),
			"idRegistro" => $dataUpdate["idRegistro"]
		),"capacita_actualizacion_registro");
	}
	
	echo json_encode(array("update" => $actualiza));
}
//----------------------------
function deleteResponsableRecord(){
	$register = $_POST["q"];

	$condition = "idResponsable = ".$register."";

	$delete = $this->capacita_modelo->deleleteRegister(array(
		"condition" => $condition,
		"table" => array("capacita_responsable")
		)
	);

	echo json_encode(array("delete" => $delete));
}
//----------------------------
function resumenCapacitacion(){
	//$resumenCoor=$this->operPersona->obtenerHrsCapaCoor($this->emailUser);
	//$conteoMes=$this->operPersona->obtenerMesesCapa($this->emailUser);
	//$personal_superior=array("DIRECTORGENERAL@AGENTECAPITAL.COM","DIRECTORCOMERCIAL@AGENTECAPITAL.COM");
	$correos_validos=array("SISTEMAS@ASESORESCAPITAL.COM","ASISTENTEDIRECCION@AGENTECAPITAL.COM","DIRECTORGENERAL@AGENTECAPITAL.COM","DIRECTORCOMERCIAL@AGENTECAPITAL.COM","GERENTECORPORATIVO@CAPITALSEGUROS.COM.MX","MARKETING@AGENTECAPITAL.COM","GERENTEOPERATIVO@AGENTECAPITAL.COM");
	$controlCapa=$this->operPersona->devuelveCertificadoActivoCoor(!in_array($this->tank_auth->get_usermail(), $correos_validos) ? $this->tank_auth->get_usermail() : ""); //$this->emailUser
	//$datos['resumenCoor']=$resumenCoor;
	//$datos['conteoMes']=$conteoMes;
	$datos['controlCapa']=$controlCapa;
  
	//$fp = fopen('resultadoJason.txt', 'w');fwrite($fp, print_r($controlCapa, TRUE));fclose($fp);
	//$datos['meses']=$this->libreriav3->devolverMeses();
	$this->load->view("persona/resumenCapacitacion", $datos);
  }
//----------------------------
function updateOldTrainingTypeInternal(){

	$select = 'SELECT a.idRegistro, d.fecha, d.idRegistroHora FROM capacita_registros a 
	LEFT JOIN capacita_responsable b ON a.idRegistro = b.idRegistro 
	INNER JOIN capacita_registros_horas d ON a.idRegistroHora = d.idRegistroHora 
	WHERE a.tipoRegistro = "interno" AND b.responsable IS NULL;';

	$forUpdate = $this->db->query($select)->result();

	foreach($forUpdate as $d_u){

		$creator = 'SELECT * FROM capacita_usuario_creador WHERE idRegistroHora = '.$d_u->idRegistroHora.';';
		$getCreator = $this->db->query($creator)->row();
		$getIdCreator = $this->operPersona->obtenerIdPersonaPorEmail($getCreator->creadorAlta);

		$insertResponsable = 'INSERT INTO capacita_responsable(responsable, fechaCompromiso, idRegistro) VALUES('.$getIdCreator->idPersona.', "'.$d_u->fecha.'", '.$d_u->idRegistro.');';
		$executeInsert = $this->db->query($insertResponsable);

		var_dump($getCreator);
	}

	//var_dump($query);

}
//----------------------------
function viewInducctionDocs(){

	$docs = $this->capitalhumanodocs->get_documentos();
	$getInducctionDocs = array_filter($docs, function($arr){ return $arr->carpeta == "materialDidactico"; });
	$data["docAndExtension"] = array_reduce($getInducctionDocs, function($acc, $curr){

		$doc = explode(".", $curr->url);
		$acc[] = array("name" => $doc[0], "extension" => $doc[1]);

		return $acc;
	}, array());

	//var_dump($docForExtension);
	$this->load->view("capacita/viewInducctionDocs", $data);
}
//----------------------------
/*function reporteGeneral_respaldo(){

	$months = $this->libreriav3->devolverMeses();
	//$getInternalDates = array_map(function($arr){ return date("n", strtotime($arr->fechaCompromiso)); }, $this->capacita_modelo->getInternalTrainingDates());
	//$getExternalDates = array_map(function($arr){ return date("n", strtotime($arr->fecha)); }, $this->capacita_modelo->getExternalTrainingDates());
	//$datesAvalible = array_values(array_unique(array_merge($getInternalDates, $getExternalDates)));
	$structuredArray = array();
	$headerDates = array();
	//sort($datesAvalible);

	$allTrainingData = $this->capacita_modelo->getGeneralTrainingData();

	foreach($allTrainingData as $a_d){

		$typePerson_ = $a_d->tipoPersona == 1 ? "colaborador" : "agente";

		//if($a_d->tipoPersona == 1){
			$structuredArray["persons"][$typePerson_][$a_d->nombre_completo][date("d-m-Y", strtotime($a_d->fechaCapacitacion))][] = array(
				"category" => $a_d->nombre_ramo,
				"hours" => $a_d->sumatoriaHoras
			);
		//}

		array_push($headerDates, $a_d->fechaCapacitacion);
	}
	sort($headerDates);
	$structuredArray["headerDates"] = array_reduce(array_unique($headerDates), function($acc, $curr){

		$acc[date("n", strtotime($curr))][] = array(
			"date" => date("d-m-Y", strtotime($curr))
		);

		return $acc;
	}, array());

	ksort($structuredArray["headerDates"]);
	
	//$fp = fopen('resultadoJason.txt', 'w');fwrite($fp, print_r($structuredArray, TRUE));fclose($fp);

	//$data["montsInRegister"] = $datesAvalible;
	$data["months"] = $months;
	$data["trainings"] = $structuredArray;
	$data["dashboard"] = 0;//$this->getAllTrainingData();
	$this->load->view("capacita/reporteGeneral", $data);
}*/
//---------------------------
function reporteGeneral(){

	$months = $this->libreriav3->devolverMeses();
	
	$trainingsWithDates = $this->capacita_modelo->getPeopleWithTraining();
	$training = $this->capacita_modelo->getTraining();
	$years = $this->capacita_modelo->getYears();
	$numMonths = array_keys($months);
	$persons = array();

	foreach($trainingsWithDates as $dp){

		$idPersona = $dp->idPersona;
		$persons[$idPersona]["name"] = $dp->nombre;
		$persons[$idPersona]["data"] = array_reduce($numMonths, function($acc, $curr) use($trainingsWithDates, $idPersona){

			$acc[] = array_reduce($trainingsWithDates, function($acc_, $curr_) use($idPersona, $curr){

				if($curr_->idPersona == $idPersona && date("n", strtotime($curr_->fechaRow)) == $curr){
					$acc_ += $curr_->sumatoria_horas;
				}
				return $acc_;
			}, 0);
			return $acc;
		}, array());
		//$persons[$idPersona]["data"][] = $dp; //array_reduce($numMonths, function($acc, $curr) use(){}, array());
	}

	$data["peopleWithTraining"] = $persons;
	$data["months"] = $months;
	$data["years1"] = $years;
	$data["training"] = $training; 
	//$fp = fopen('resultadoJason.txt', 'w');fwrite($fp, print_r($data, TRUE));fclose($fp);
	$this->load->view("capacita/reporteGeneral", $data);
}
//----------------------------
function getAllTrainingData(){ //Use for React JS

	$allTrainingData = $this->capacita_modelo->getGeneralTrainingData();
	//$fp = fopen('resultadoJason.txt', 'w');fwrite($fp, print_r($allTrainingData, TRUE));fclose($fp);

	echo json_encode($allTrainingData);
	//return true;
}
//----------------------------
function getTrainingReport(){
	$allTrainingData = $this->capacita_modelo->getGeneralTrainingData_($_GET["month"], $_GET["year"]);
	$trainingProgress = $this->capacita_modelo->getTrainingProgress($_GET["month"], $_GET["year"]);
	$assitences = array();

	$generalData = array_reduce($allTrainingData, function($acc, $curr){

		if(array_key_exists($curr->idPersona, $acc)){
			$acc[$curr->idPersona]["hoursContent"] += $curr->sumatoriaHoras;
		} else{
			$acc[$curr->idPersona]["name"] = $curr->nombre_completo;
			$acc[$curr->idPersona]["id"] = $curr->idPersona;
			$acc[$curr->idPersona]["office"] = $curr->NombreSucursal;
			$acc[$curr->idPersona]["typePerson"] = $curr->tipoPersona == 1 ? "Colaborador": "Agente";
			$acc[$curr->idPersona]["hoursContent"] = $curr->sumatoriaHoras;
		}

		return $acc;
	}, array());

	$trainingData = array_reduce($trainingProgress, function($acc, $curr){

		if(array_key_exists($curr->id_capacitacion, $acc)){
			$acc[$curr->id_capacitacion]["total"] += $curr->total;
			$acc[$curr->id_capacitacion]["subT"][$curr->id_certificado]["name"] = $curr->nombreCertificado;
			$acc[$curr->id_capacitacion]["subT"][$curr->id_certificado]["types"][$curr->nombre_ramo] = $curr->total;
		} else{
			$acc[$curr->id_capacitacion]["name"] = $curr->tipoCapacitacion;
			$acc[$curr->id_capacitacion]["total"] = $curr->total;
			$acc[$curr->id_capacitacion]["subT"][$curr->id_certificado]["name"] = $curr->nombreCertificado;
			$acc[$curr->id_capacitacion]["subT"][$curr->id_certificado]["types"][$curr->nombre_ramo] = $curr->total;
		}
		
		//$acc[$curr->id_capacitacion]["subT"][$curr->id_certificado]["types"][$curr->idR]["totalHours"] = $curr->total;

		return $acc;
	}, array());

	foreach($allTrainingData as $t_d){
		$assitences[$t_d->id_capacitacion]["name"] = $t_d->capacitacion;
		$assitences[$t_d->id_capacitacion]["subTraining"][$t_d->id_certificado]["name"] = $t_d->subCapacitacion;
		$assitences[$t_d->id_capacitacion]["subTraining"][$t_d->id_certificado]["data"][] = $t_d;
	}

	//$fp = fopen('resultadoJason.txt', 'w');fwrite($fp, print_r($assitences, TRUE));fclose($fp);
	$response["firstData"] = $generalData;
	$response["trainings"] = $trainingData;
	$response["assistences"] = $assitences;

	echo json_encode($response);
}
//----------------------------
function getTrainings(){

	$year = $_GET["year"];
	$getTrainings = $this->capacita_modelo->getTrainings();
	$trainingsWithDates = $this->capacita_modelo->getTrainingsWithDates();
	$peopleInTraining = $this->capacita_modelo->agentsInTraining();
	$months = $this->libreriav3->devolverMeses();
	$years = $this->capacita_modelo->getYears();
	$datesFiltered1 = $this->getDatesFiltered($trainingsWithDates, $year, "hours");
	$datesFiltered2 = $this->getDatesFiltered($peopleInTraining, $year, "people");

	$trainings = array_reduce($datesFiltered1, function($acc, $curr){ //getTrainings
	
		if(array_key_exists($curr->id_capacitacion, $acc)){
			$acc[$curr->id_capacitacion]["counts"] += $curr->horas;
			//$acc[$curr->id_capacitacion]["name"] = $curr->tipoCapacitacion;
		} else{
			$acc[$curr->id_capacitacion]["counts"] = floatval($curr->horas);
			$acc[$curr->id_capacitacion]["name"] = !empty($curr->tipoCapacitacion) ? $curr->tipoCapacitacion : "NINGUNO";
		}
		return $acc;
	}, array());

	$response["montlyRecords"] = $this->getMontlyTrainings($datesFiltered1); //datesFiltered //trainingsWithDates
	$response["montlyPeopleRecords"] = $this->getMontlyPeopleTrainings($datesFiltered2);
	$response["trainingsHours"] = array_values($trainings);
	$response["peopleInTraining"] = $this->getTotalTraining($response["montlyPeopleRecords"]);  //$people;
	$response["trainingTree"] = $getTrainings;
	$response["peopleTrainingTree"] = $datesFiltered2; //$peopleInTraining
	$response["months"] = $months;
	$response["years"] = $years;
	//$fp = fopen('resultadoJason.txt', 'w');fwrite($fp, print_r($response, TRUE));fclose($fp);
	echo json_encode($response);
}
//----------------------------
function getDatesFiltered($array, $filter, $typeData){

	$response = array();

	switch($typeData){
		case "people": 
			$response = array_filter($array, function($arr) use($filter){

				if(!empty($filter)){
					return date("Y", strtotime($arr->fechaOficial)) == $filter; 
				} else{
					return $arr;
				}
			});
		break;
		case "hours": 
			$response = array_filter($array, function($arr) use($filter){

				if(!empty($filter)){
					return date("Y", strtotime($arr->fechaRegistro)) == $filter; 
				} else{
					return $arr;
				}
			});
		break;
	}

	return array_values($response);
}
//-----------------------------
function getMontlyPeopleTrainings($data){
	$trainings = $this->capacita_modelo->getTraining();
	$meses = $this->libreriav3->devolverMeses();
	$onlyNumberMonth = array_keys($meses);
	$montlyData = array();

	foreach($trainings as $d_t){
		$name_ = $d_t->tipoCapacitacion;
		$montlyData[$d_t->id_capacitacion]["name"] = $d_t->tipoCapacitacion;
		$montlyData[$d_t->id_capacitacion]["data"] = array_map(function($arr) use($data, $name_){

			$filter = array_filter($data, function($arr_) use($arr, $name_){
				return date("n", strtotime($arr_->fechaOficial)) == $arr && $arr_->tipoCapacitacion == $name_;
			});

			$sumPeople = array_reduce($filter, function($acc, $curr){

				if(array_key_exists($curr->idPersona, $acc)){
					$acc[$curr->idPersona] ++;	
				} else{
					$acc[$curr->idPersona] = 1;	
				}

				return $acc;
			}, array());

			return count($sumPeople);
		}, $onlyNumberMonth);
	}

	$response["months"] = array_values($meses);
	$response["montlyData"] = $montlyData;

	return $response;
}
//-----------------------------
function getMontlyPeopleTrainings_respaldo($data){
	$trainings = $this->capacita_modelo->getTraining();
	$meses = $this->libreriav3->devolverMeses();
	$onlyNumberMonth = array_keys($meses);
	$montlyData = array();

	foreach($trainings as $d_t){
		$name_ = $d_t->tipoCapacitacion;
		$montlyData[$d_t->id_capacitacion]["name"] = $d_t->tipoCapacitacion;
		$montlyData[$d_t->id_capacitacion]["data"] = array_map(function($arr) use($data, $name_){

			$filter = array_filter($data, function($arr_) use($arr, $name_){
				return date("n", strtotime($arr_->fechaOficial)) == $arr && $arr_->tipoCapacitacion == $name_;
			});

			//$validate = array();
			$sumPeople = array_reduce($filter, function($acc, $curr){

				$validate = array();
				if(!in_array($curr->idPersona, $validate)){
					$acc ++;
					//array_push($validate, $curr->idPersona);
					$validate[] = $curr->idPersona;
				} else{
					$acc = 1;
					//array_push($validate, $curr->idPersona);
					$validate[] = $curr->idPersona;
				}
				return $acc;
			}, 0);

			return $sumPeople;
		}, $onlyNumberMonth);
	}

	$response["months"] = array_values($meses);
	$response["montlyData"] = $montlyData;

	return $response;
}
//----------------------------
function getMontlyTrainings($data){

	$trainings = $this->capacita_modelo->getTraining();
	$meses = $this->libreriav3->devolverMeses();
	$onlyNumberMonth = array_keys($meses);
	$montlyData = array();

	foreach($trainings as $d_t){
		$name_ = $d_t->tipoCapacitacion;
		$montlyData[$d_t->id_capacitacion]["name"] = $d_t->tipoCapacitacion;
		$montlyData[$d_t->id_capacitacion]["data"] = array_map(function($arr) use($data, $name_){

			$filter = array_filter($data, function($arr_) use($arr, $name_){
				return date("n", strtotime($arr_->fechaRegistro)) == $arr && $arr_->tipoCapacitacion == $name_;
			});

			$sumHours = array_reduce($filter, function($acc, $curr){
				$acc += $curr->horas;
				return $acc;
			}, 0);

			return $sumHours;
		}, $onlyNumberMonth);
	}

	$response["months"] = array_values($meses);
	$response["montlyData"] = $montlyData;
	return $response;
}
//----------------------------
function getTrainingSelected(){

	$training = $_GET["id"];
	$type = $_GET["type"];
	$filter = $_GET["filter"];
	$monthGet = $_GET["month"];
	$getTrainings = $this->capacita_modelo->getTrainings();
	$peopleInTraining = $this->capacita_modelo->agentsInTraining();
	$months = $this->libreriav3->devolverMeses();
	$numberMonth = array_keys($months);
	$index = ($monthGet - 1);
	$filterValue = $filter == "trimestral" ? 3 : 1;
	$interval = array_slice($numberMonth, $index, $filterValue);

	$onlyTraining = array_filter($getTrainings, function($arr) use($training){

		return $arr->id_capacitacion == $training;
	});

	$agentsFiltered = array_filter($peopleInTraining, function($arr) use($training, $interval, $filter, $monthGet){

		if($filter !== "vacio"){
			return $arr->id_capacitacion == $training && in_array( date("n", strtotime($arr->fechaOficial)), $interval );
		} else{
			return $arr->id_capacitacion == $training;
		}
	});

	$response = $type == "hours" ? array_values($onlyTraining) : array_values($agentsFiltered);
	echo json_encode($response);
}
//----------------------------
function getTrainingFiltered(){

	//$getTrainings = $this->capacita_modelo->getTrainings();
	$month = $_GET["month"];
	$year = $_GET["year"];
	$typeFilter = $_GET["typeFilter"];
	$trainingsWithDates = $this->capacita_modelo->getTrainingsWithDates();
	$peopleInTraining = $this->capacita_modelo->agentsInTraining();
	$months = $this->libreriav3->devolverMeses();
	$numberMonth = array_keys($months);
	$index = ($month - 1);
	$filterValue = $typeFilter == "trimestral" ? 3 : 1;
	$interval = array_slice($numberMonth, $index, $filterValue);
	$datesFiltered1 = $this->getDatesFiltered($trainingsWithDates, $year, "hours");
	$datesFiltered2 = $this->getDatesFiltered($peopleInTraining, $year, "people");

	//-------------------------------
	//Filteres
	$filterRecords = array_filter($datesFiltered1, function($arr) use($interval){ //trainingsWithDates

		return in_array( date("n", strtotime($arr->fechaRegistro)), $interval);
	});

	$peopleFiltered = array_filter($datesFiltered2, function($arr) use($interval){ //peopleInTraining
		return in_array( date("n", strtotime($arr->fechaOficial)), $interval);
	});
	//-------------------------------
	$trainings = array_reduce($filterRecords, function($acc, $curr){
	
		if(array_key_exists($curr->id_capacitacion, $acc)){
			$acc[$curr->id_capacitacion]["counts"] += $curr->horas;
			
		} else{
			$acc[$curr->id_capacitacion]["counts"] = floatval($curr->horas);
			$acc[$curr->id_capacitacion]["name"] = !empty($curr->tipoCapacitacion) ? $curr->tipoCapacitacion : "Ninguno"; //$curr->tipoCapacitacion;
		}
		return $acc;
	}, array());

	$response["montlyRecords"] = $this->getMontlyTrainings(array_values($filterRecords)); //datesFiltered //trainingsWithDates
	$response["montlyPeopleRecords"] = $this->getMontlyPeopleTrainings(array_values($peopleFiltered));
	$response["trainingsHours"] = array_values($trainings);
	$response["peopleInTraining"] = $this->getTotalTraining($response["montlyPeopleRecords"]);  //$people;
	//$response["trainingTree"] = $getTrainings;
	$response["peopleTrainingTree"] = $peopleFiltered; //$peopleInTraining
	$response["months"] = $months;
	//$response["years"] = $years;

	/*$response["trainingsHours"] = $trainings;
	$response["montlyRecords"] = $this->getMontlyTrainings(array_values($filterRecords));//peopleFiltered
	$response["montlyPeopleRecords"] = $this->getMontlyPeopleTrainings(array_values($peopleFiltered));
	$response["peopleInTraining"] = $people;
	$response["peopleTrainingTree"] = array_values($peopleFiltered);
	$response["months"] = $months;*/
	/*
		//$response["montlyRecords"] = $this->getMontlyTrainings($trainingsWithDates);
		//$response["montlyPeopleRecords"] = $this->getMontlyPeopleTrainings($peopleInTraining);
		//$response["trainingsHours"] = $trainings;
		//$response["peopleInTraining"] = $people;
		$response["trainingTree"] = $getTrainings;
		//$response["peopleTrainingTree"] = $peopleInTraining;
		//$response["months"] = $months;
	*/
	$fp = fopen('resultadoJason.txt', 'w');fwrite($fp, print_r($filterRecords, TRUE));fclose($fp);
	echo json_encode($response);
}
//----------------------------
function getSubtrainings(){
	
	$id = $_GET["id"];
	$getST = $this->capacita_modelo->getSubTrainings($id);

	echo json_encode($getST);
}
//---------------------------
function getReportFiltered(){

	$years = array_map(function($arr){ return $arr->dateTraining; }, $this->capacita_modelo->getYears());
	$months = array_keys($this->libreriav3->devolverMeses());
	$training = $_GET["training"];
	$subTraining = $_GET["subTraining"];
	$month = empty($_GET["month"]) ? $months : array($_GET["month"]);
	$year = $_GET["year"] == "total" ? $years : array($_GET["year"]);
	if(isset($_GET["tipoPersona"])){$tipoPersona=$_GET["tipoPersona"];}else{$tipoPersona=null;}
	$peopleTrainingData = $this->capacita_modelo->getPeopleWithTypes($training, $subTraining, $tipoPersona);
	$dataExternos = $this->capacita_modelo->getCapaciExternas();
	//$types = array("profesional", "autos", "daños", "GMM", "vida", "fianzas");

	/*$filters = array_filter($peopleTrainingData, function($arr) use($month){
		
		return date("n", strtotime($arr->fechaOficial)) == $month;
	});*/

	$filters = array_filter($peopleTrainingData, function($arr) use($month, $year){
		$montRow = date("n", strtotime($arr->fechaOficial));
		$yearRow = date("Y", strtotime($arr->fechaOficial));
		return in_array($montRow, $month) && in_array($yearRow, $year);
	});
	$filters2 = array_filter($dataExternos, function($arr) use($month, $year){
		$montRow = date("n", strtotime($arr->date));
		$yearRow = date("Y", strtotime($arr->date));
		return in_array($montRow, $month) && in_array($yearRow, $year);
	});

	$response = array_reduce($filters, function($acc, $curr) use($filters,$filters2){

		$id = $curr->idPersona;
		$acc[$curr->idPersona]["name"] = $curr->nombre;
		$acc[$curr->idPersona]["id_capacitacion"] = $curr->id_capacitacion;
		$acc[$curr->idPersona]["tipoCapacitacion"] = $curr->tipoCapacitacion;
		$acc[$curr->idPersona]["fecha"] = $curr->fechaOficial;
		$acc[$curr->idPersona]["tipoPersona"] = $curr->tipoPersona;
		$acc[$curr->idPersona]["data"] = array_reduce($filters, function($acc2, $curr2) use($id){

			if($curr2->idPersona == $id){

				if($curr2->nombre_ramo == "profesional"){
					$acc2["profesional"] += $curr2->horas;
				}
				if($curr2->nombre_ramo == "vida"){
					$acc2["vida"] += $curr2->horas;
				}
				if($curr2->nombre_ramo == "autos"){
					$acc2["autos"] += $curr2->horas;
				}
				if($curr2->nombre_ramo == "daños"){
					$acc2["daños"] += $curr2->horas;
				}
				if($curr2->nombre_ramo == "GMM"){
					$acc2["gmm"] += $curr2->horas;
				}
				if($curr2->nombre_ramo == "fianzas"){
					$acc2["fianzas"] += $curr2->horas;
				}
				
			}

			return $acc2;
		}, array("profesional" => 0, "vida" => 0, "daños" => 0, "autos" => 0, "gmm" => 0, "fianzas" => 0));

		$acc[$curr->idPersona]["data"] += array_reduce($filters2, function($acc3,$curr3) use($id){
				if($curr3->idPersona == $id){
					$acc3["externos"]+=$curr3->duration;
				}
				return $acc3;
			}, array("externos"=>0));

		return $acc;
	}, array());

	//$fp = fopen('resultadoJason.txt', 'w');fwrite($fp, print_r($filters2, TRUE));fclose($fp);
	echo json_encode(array_values($response));
}
//---------------------------
function getResult(){

	$peopleInTraining = $this->capacita_modelo->agentsInTraining();
	$montlyData = $this->getMontlyPeopleTrainings($peopleInTraining);
	$total = $this->getTotalTraining($montlyData);
	$fp = fopen('resultadoJason.txt', 'w');fwrite($fp, print_r($month, TRUE));fclose($fp);
	var_dump($total);

}
//---------------------------
function getTotalTraining($data){

	$response = array();
	foreach($data["montlyData"] as $id => $data){

		$response[$id]["name"] = $data["name"];
		$response[$id]["counts"] = array_sum($data["data"]);
	}

	return array_values($response);
}
//--------------------------------------------------------------------------
	//Registro de Revistas
	function subir_revista() {
		if (!$this->tank_auth->is_logged_in()) {
			redirect('/auth/login/');
		} 
		else {
			$data['revistas'] = $this->capacita_modelo->ver_revistas();
			$data['ramos']=$this->capacita_modelo->ramo_videos();
			$array['grupos'] = 1;
			$data['empleados'] = $this->PersonaModelo->devolverColaboradoresActivos($array);
			$data['agentes'] = $this->PersonaModelo->obtenerVendActivos();
			$this->load->view('capacita/menu_capacita');
			$this->load->view('capacita/cargar_revista',$data);
		}
	}

	function get_revistas() {
		$data['revistas'] = $this->capacita_modelo->ver_revistas();
		echo json_encode($data);
	}

	function guardar_revista() {
		$id = $this->input->post('id');
		$type = $this->input->post('tp');
		$data = array(
			'IDRamo' => $this->input->post('rm'),
			'tituloGeneral' => $this->input->post('t0'),
			'descripcion' => $this->input->post('ds'),
			'edicion' => $this->input->post('ed'),
			'edicionAnio' => $this->input->post('yr')
		);
		if ($type != "1") {
			$this->capacita_modelo->actualizar_revista($id,$data);
			$result = "Actualizado";
		}
		else {
			$this->capacita_modelo->registrar_revista($data);
			$result = "Registrado";
		}
		echo json_encode($result);
	}

	function buscar_revista() {
		$id = $this->input->get('id');
		$data = $this->capacita_modelo->consultar_revista($id);
		echo json_encode($data);
	}

	function borrar_revista() {
		$id = $this->input->post('id');
		$result = $this->capacita_modelo->eliminar_revista($id);
		echo json_encode($result);
	}

	function agregar_archivo() {
		$id = $this->input->post('id');
		$file = $this->input->post('fl');
		$result = $this->capacita_modelo->guardar_archivo($id,$file);
		echo json_encode($result);
	}

	//Visualización de Revistas
	function revistas() {
		if (!$this->tank_auth->is_logged_in()) {
			redirect('/auth/login/');
		} 
		else {
			$data['revistas'] = $this->capacita_modelo->ver_revistas();
			$this->load->view('capacita/menu_capacita');
			$this->load->view('capacita/revistas',$data);
		}
	}

//--------------------------------------------------------------------------
	//Registro de Videos Tutoriales
	function get_tutoriales() {
		$data = $this->capacita_modelo->ver_tutoriales();
		echo json_encode($data);
	}

	function buscar_tutorial() {
		$id = $this->input->get('id');
		$data = $this->capacita_modelo->consultar_tutorial($id);
		echo json_encode($data);
	}

	function guardar_tutorial() {
		$id = $this->input->post('id');
		$type = $this->input->post('tp');
		$data = array(
			'name' => $this->input->post('tl'),
			'description' => $this->input->post('ds'),
			'dateCreation' => date('Y-m-d H:i:s')
		);
		if ($type != "1") {
			$result = $this->capacita_modelo->actualizar_tutorial($id,$data);
		}
		else {
			$result = $this->capacita_modelo->registrar_tutorial($data);
		}
		echo json_encode($result);
	}

	function borrar_tutorial(){
		$id = $this->input->post('id');
		$result = $this->capacita_modelo->eliminar_tutorial($id);
		echo json_encode($result);
	}

	function modificarurltutorial(){
		$id = $this->input->post('id');
		$data = array(
			'nameDoc' => $this->input->post('fl'),
			'format' => $this->input->post('fr'),
			'dateUpdate' => date('Y-m-d H:i:s')
		);
		$result = $this->capacita_modelo->modificar_url_tutorial($id,$data);
    	echo json_encode($result);
	}
//--------------------------------------------------------------------------
	//Capacitación Externa
	function CapacitacionExterna() { //Creado [Suemy][2024-04-26]
		if (!$this->tank_auth->is_logged_in()) {
			redirect('/auth/login/');
		} else {
			$idPersona = $this->tank_auth->get_idPersona();
			$typeUser = "Colaborador";
			$con = $this->db->query('SELECT * FROM persona WHERE idPersona = '.$idPersona)->result()[0];
			if ($con->tipoPersona == 3) { $typeUser = "Agente"; }
			$data['typeUser'] = $typeUser;
			$data['nameUser'] = $con->apellidoPaterno." ".$con->apellidoMaterno." ".$con->nombres;
			$data['emailAgentes'] = $this->capacita_modelo->emailAgentes();
			$this->load->view('capacita/capacitacion_externa',$data);
		}
	}

	function guardarCapacitacionExterna() { //Creado [Suemy][2024-04-26]
		$info = $this->input->post('info');
		$hourS = "";
		$hourF = "";
		$duration = 0;
		if (!isset($info[10])) {
			$duration = $info[9];
		}
		else {
			$hourS = $info[9];
			$hourF = $info[10];
			$duration = $this->superestrella_model->getDurationEvent($hourS,$hourF);
		}
		$data['insert'] = array(
			"title" => $info[1],
			"company" => $info[6],
			"theme" => $info[2],
			"date" => $info[7],
			"start_hour" => $hourS,
			"final_hour" => $hourF,
			"duration" => $duration,
			"description" => $info[3],
			"idPersona" => $info[8],
			"email" => $info[5],
			"typeUser" => $info[4],
			//"registration_date" => date("Y-m-d H:i:s")
		);
		$data['result'] = $this->capacita_modelo->registerUserEvent($data['insert']);
		echo json_encode($data);
	}

	function tablaCapacitacionExterna() { //Creado [Suemy][2024-04-26]
		$idPersona = $this->tank_auth->get_idPersona();
		$data = $this->capacita_modelo->getInfoExternalEvent($idPersona);
		echo json_encode($data);
	}

	function tablaCapacitacionesExternas() { //Creado [Suemy][2024-04-26]
		$data = $this->capacita_modelo->getExternalEvents();
		echo json_encode($data);
	}

	function eliminarCapacitacionExterna() { //Creado [Suemy][2024-04-26]
		$id = $this->input->post('id');
		$data['status'] = $this->capacita_modelo->deleteExternalEvent($id);
		echo json_encode($data);
	}
}
