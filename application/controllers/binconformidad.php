<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class binconformidad extends CI_Controller{

	function __construct(){
		parent::__construct();
	
			$params['id_sicas'] = $this->tank_auth->get_IDUserSICAS(); "get_IDUserSICAS";
			$params['user_sicas'] = $this->tank_auth->get_UserSICAS(); "get_UserSICAS";
			$params['pass_sicas'] = $this->tank_auth->get_PassSICAS(); "get_PassSICAS";
			$this->load->library('Ws_sicasdre',$params);
			$this->load->library('webservice_sicas_soap');
			$this->load->library('localfileuploader');
			$this->load->library('libreriav3');

			$this->load->helper('ckeditor');
			$this->load->model('capsysdre_miinfo');
			$this->load->model('procesamientoncmodel');
			$this->load->model('catalogos_model');
			$this->load->model('binconformidad_model', "inconformidad");

			if (!$this->tank_auth->is_logged_in()) {
				redirect('/auth/login/');
			}
	}

   function index(){
		
		if (!$this->tank_auth->is_logged_in()) {
			redirect('/auth/login/');
		} else {
			
			 $data['alert']		= "";
			 $anioBusqueda="";
			 $data['anios']=$this->libreriav3->devolverAnioActualConAnteriores();
			 $data['anioEscogido']=$data['anios'][0];
             if(isset($_POST['fecha'])){$data['anioEscogido']=$_POST['fecha'];}
             $buscar['fecha']=$data['anioEscogido'];
             $data['inconformidades']=$this->procesamientoncmodel->devolverInconformidadesPorAnioPorPersona($buscar);
			 $data['tipoInconformidad']=$this->catalogos_model->inconformidadCataloBuzonInconformidadPadre();
             //$data['inconformidades']=$this->procesamientoncmodel->reporteBuzonInconformidad($buscar);
			 //$data["NCList"] = $this->inconformidad->getList(array("correoProcedente" => $this->tank_auth->get_usermail(), "YEAR(fechaRegistro)" => date("Y")));
			 
                             
			$this->load->view('binconformidad/principal',$data);
		}
	}
//--------------------------------------------------
function buscarReporte()
{
$respuesta=array();

$respuesta=$data['inconformidades']=$this->procesamientoncmodel->reporteBuzonInconformidad($_POST);
echo json_encode($respuesta);
}
//--------------------------------------------------
	function Guardar(){ //Obsoleto
        $descripcion=$this->input->post('smsText');
		$dirigidoa=$this->input->post('quejante');
		$fecharegistro=(string)date('Y-m-d H:i:s');

		if (!$this->tank_auth->is_logged_in()) {
			redirect('/auth/login/');
		} else {
            //$correoProcedente=$this->corre
            $correoProcedente=$this->tank_auth->get_usermail();
            $nombreProcedente=$this->capsysdre->NombreUsuarioEmail($correoProcedente);
			$sqlInsert_Referencia = "Insert Ignore Into `inconformidades` (`descripcion`, `correoProcedente`,`nombreProcedente`,`fechaRegistro`) Values('".$descripcion."', '".$correoProcedente."','".$nombreProcedente."','".$fecharegistro."');";
			$this->db->query($sqlInsert_Referencia);
			$referencia = $this->db->insert_id();
			$insertar['nombreTabla']='inconformidades';
			$insertar['idRowTabla']=$referencia;
			$insertar['idPersonaInconforme']=$this->tank_auth->get_idPersona();
            $this->procesamientoncmodel->insertarNC($insertar);
            $data['referencia'] = $referencia;
            $data['alert']		= "success";	
            			 $data['anios']=$this->libreriav3->devolverAnioActualConAnteriores();
			 $data['anioEscogido']=$data['anios'][0];
			                           $buscar['fecha']=$data['anioEscogido'];
             $data['inconformidades']=$this->procesamientoncmodel->devolverInconformidadesPorAnioPorPersona($buscar);
			$this->load->view('binconformidad/principal', $data);
		}
	}
//--------------------------------------------------------
function devolverHijoCatalogoInconformidades()
{
	$respuesta=array();
	$respuesta['success']=1;
	$respuesta['catalogo']=array();
	$respuesta['informacion']=$this->catalogos_model->devolverHijoCatalogoInconformidades($_POST['idCBI'],$_POST['tipoBusqueda']);
    $respuesta['idCBI']=$_POST['idCBI'];
    if($_POST['idCBI']==2){$respuesta['catalogo']=$this->catalogos_model->devolverHijoCatalogoInconformidades(5,'subCatalogo');}
    if($_POST['idCBI']==1){$respuesta['catalogo']=$this->catalogos_model->devolverHijoCatalogoInconformidades(28,'subCatalogo');}

	//
	echo json_encode($respuesta);
}
function guardarInconformidad() //obsoleto
{
  if (!$this->tank_auth->is_logged_in()) {redirect('/auth/login/');} 
  else 
  {
  	   $descripcion=$this->input->post('smsText');
		$dirigidoa=$this->input->post('quejante');
		$fecharegistro=(string)date('Y-m-d H:i:s');
           
           $respuesta=array();
           $respuesta['success']=true;
            $correoProcedente=$this->tank_auth->get_usermail();
            $nombreProcedente=$this->capsysdre->NombreUsuarioEmail($correoProcedente);
            $insertInconformidad['descripcion']=$descripcion;
            $insertInconformidad['correoProcedente']=$correoProcedente;
            $insertInconformidad['nombreProcedente']=$nombreProcedente;
            $insertInconformidad['fechaRegistro']=$fecharegistro;
            $insertInconformidad['idCBITipo']=$this->input->post('tipoInconformidadSelect', TRUE);
            $insertInconformidad['idCBIOpcion']=$this->input->post('opcionInconformidad', TRUE);
           $insertInconformidad['idCBIArea']=$this->input->post('areaInconformidad', TRUE);
           
            $this->db->insert('inconformidades',$insertInconformidad);			
			
			$referencia = $this->db->insert_id();
			$this->db->where('id',$referencia);	
			$update['folioInconformidad']='IN'.$referencia;		
			$this->db->update('inconformidades',$update);			
			$insertar['nombreTabla']='inconformidades';
			$insertar['idRowTabla']=$referencia;
			$insertar['idPersonaInconforme']=$this->tank_auth->get_idPersona();
            $this->procesamientoncmodel->insertarNC($insertar);
            $data['referencia'] = $referencia;
            $data['alert']		= "success";	
            			 $data['anios']=$this->libreriav3->devolverAnioActualConAnteriores();
			 #$data['anioEscogido']=$data['anios'][0];
             #$buscar['fecha']=$data['anioEscogido'];
             #$data['inconformidades']=$this->procesamientoncmodel->devolverInconformidadesPorAnioPorPersona($buscar);
       //$fp = fopen('resultadoJason.txt', 'a');fwrite($fp,print_r($_FILES,TRUE));fclose($fp); 
       $respuesta['folio']='IN'.$referencia;
	echo json_encode($respuesta);


  }

}
//------------------------- //Dennis Castillo [2022-07-29]
function crearInconformidad(){

	$response = array();
	$toInsert = array();

	foreach($_POST as $key => $value){

		$toInsert[$key] = $value;
	}

	$toInsert["correoProcedente"] = $this->tank_auth->get_usermail();
	$toInsert["nombreProcedente"] = $this->capsysdre->NombreUsuarioEmail($this->tank_auth->get_usermail());
	$toInsert["fechaRegistro"] = date("Y-m-d H:i:s");
	
	$insert = $this->inconformidad->insertaInconformidad($toInsert, array("sendEmail" => true));

	array_push($response, array(
		"success" => $insert["success"], 
		"data" => $insert["id"], 
		"message" => $insert["success"] ? "Registro creado con éxito" : "Ocurrió un error. Intente de nuevo"
	), array(
		"success" => $insert["success"], 
		"message" => $insert["success"] ? "Ticket enviado a mi correo" : "No se logró enviar el correo"
	));

	echo json_encode($response);
}
//------------------------- //Dennis Castillo [2022-07-29]
function getNCList(){

	$condition = array();
	$json = array();
	//$fp = fopen('resultadoJason.txt', 'a');fwrite($fp,print_r($_GET,TRUE));fclose($fp);

	if($_GET["getOnlyMyList"]){
		$condition["correoProcedente"] = $this->tank_auth->get_usermail();
	}
	
	if(isset($_GET["year"])){
		$condition["YEAR(fechaRegistro)"] = $_GET["year"];
	}

	//unset($_GET["getOnlyMyList"]);

	/*foreach($_GET as $k => $v){

		$condition[$k] = $v;
	}*/
	//$getNCList = $this->inconformidad->getList($condition);
	$otherList = $this->procesamientoncmodel->tablaNC(array("idPersona" => $this->tank_auth->get_idPersona()));
	$newArray = array();

	foreach($otherList as $k => $arr){

		foreach($arr as $data){
			array_push($newArray, $data);
			$ar["id"] = $data->idRowTabla;
			$ar["folio"] = $k == "calificaUsuario" ? "IN".$data->idRowTabla : $data->idRowTabla;
			$ar["aFavor"] = $data->aFavor;
			$ar["idRowTabla"] = $data->idRowTabla;
			$ar["idPersonaResponsable"] = $data->idPersonaResponsable;
			$ar["fechaRegistro"] = $data->fechaHoraRegistro;
			$ar["idCBITipo"] = $data->tipoInconformidad;
			$ar["idCBIOpcion"] = $data->opcionInconformidad;
			$ar["idCBIArea"] = $data->areaInconformidad;
			$ar["label"] = $data->label;
			$ar["nombreTabla"] = $data->nombreTabla;
			$ar["status"] = $data->status;
			$ar["idTablaNoConformidad"] = $data->idTablaNoConformidad;
			$ar["responsables"] = array_map(function($arr){ return array("email" => $arr->email, "nombre" => $arr->nombres." ".$arr->apellidoPaterno." ".$arr->apellidoMaterno); }, $data->personaResponsables);
			$ar["bitacora"] = end(array_map(function($arr_){ return $arr_->movimiento; }, $data->comentariosBitacora));
			array_push($json, $ar);
		}
	}

	

	echo json_encode($json);
}
//------------------------- //Dennis Castillo [2022-07-29]
function getBinnacle($id){

	$binnacle = $this->procesamientoncmodel->inconformidadesBitacora($id, true);
	
	echo json_encode(array_reverse($binnacle));
}
//------------------------- //Dennis Castillo [2022-07-29]
function getFilteredNonconformity(){
	
	$form = $_GET;

	$from = new DateTime(str_replace("/", "-",$_GET["dateOne"]));
	$to = new DateTime(str_replace("/", "-",$_GET["dateTwo"]));

	/*$getList = $this->inconformidad->getList(array(
		"correoProcedente" => $this->tank_auth->get_usermail(),
		"DATE(fechaRegistro) >=" => $from->format("Y-m-d"),
		"DATE(fechaRegistro) <=" => $to->format("Y-m-d")
	));*/


	$otherList = $this->procesamientoncmodel->tablaNC(array("idPersona" => $this->tank_auth->get_idPersona()));
	$json = array();

	foreach($otherList as $k => $arr){

		foreach($arr as $data){

			if((strtotime($data->fCreacion) >= strtotime($from->format("Y-m-d"))) && (strtotime($data->fCreacion) <= strtotime($to->format("Y-m-d")))){
				//array_push($newArray, $data);
				$ar["id"] = $data->idRowTabla;
				$ar["folio"] = $k == "calificaUsuario" ? "IN".$data->idRowTabla : $data->idRowTabla;
				$ar["aFavor"] = $data->aFavor;
				$ar["idRowTabla"] = $data->idRowTabla;
				$ar["idPersonaResponsable"] = $data->idPersonaResponsable;
				$ar["fechaRegistro"] = $data->fechaHoraRegistro;
				$ar["idCBITipo"] = $data->tipoInconformidad;
				$ar["idCBIOpcion"] = $data->opcionInconformidad;
				$ar["idCBIArea"] = $data->areaInconformidad;
				$ar["label"] = $data->label;
				$ar["nombreTabla"] = $data->nombreTabla;
				$ar["status"] = $data->status;
				$ar["idTablaNoConformidad"] = $data->idTablaNoConformidad;
				$ar["responsables"] = array_map(function($arr){ return array("email" => $arr->email, "nombre" => $arr->nombres." ".$arr->apellidoPaterno." ".$arr->apellidoMaterno); }, $data->personaResponsables);
				$ar["bitacora"] = end(array_map(function($arr_){ return $arr_->movimiento; }, $data->comentariosBitacora));
				array_push($json, $ar);
			}
		}
	}


	echo json_encode($json);
}
//------------------------- //Dennis Castillo [2022-07-29]
function getComment(){

	$id = $_GET["id"];
	$getList = $this->procesamientoncmodel->inconformidadesBitacora($id, true);
	
	/*$this->inconformidad->getNCListFiltered(array(
		"correoProcedente" => $this->tank_auth->get_usermail(),
		"id" => $id
	));*/

	echo json_encode(end($getList));
}
//------------------------- //Dennis Castillo [2022-07-29]
function viewTemplate(){

	$this->load->view("binconformidad/correosNotificacion/ncNotification");
}
//------------------------- //Dennis Castillo [2022-07-29]
function updateNC($id){

	$update = $this->inconformidad->updateNCReg(array("idRowTabla" => $id));

	echo json_encode($update);
}
//-------------------------

  /**
   * Maneja la solicitud para obtener la lista de evaluadores de tareas a partir de los IDs enviados
   */
  public function obtenerListaEvaluadoresNC()
  {
    $data_ids = $_POST[ 'data_ids' ];
    $resultados = $this->inconformidad->obtenerListaEvaluadoresNC($data_ids);
    echo json_encode($resultados);
  }

}