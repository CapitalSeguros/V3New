<?php 
/**
 * 
 */
 class validarInformacion extends CI_Controller
 {
 	
 	function __construct()
 	{    
 		parent::__construct();
 		header('Access-Control-Allow-Origin: *');
 		
 		$this->load->model('catalogos_model');
 		$this->load->model('menu_model');
 		$this->load->model('manejodocumento_modelo');
		 $this->load->model("personamodelo", "persona"); //Dennis Castillo [2021-10-31]
		$this->load->model("capacita_modelo");
 		$this->load->library('Tank_auth');
 		$this->load->library("WS_Sicas");
 		$this->load->library(array("webservice_sicas_soap"));
 				$this->load->model('procesamientoncmodel');
 	}
//----------------------------------------------------------------------------------------------
 	function index(){
 		$this->load->view('validarinformacion/principal');
 	}

//----------------------------------------------------------------------------------------------
 	function _validarPoliza($poliza){

 		//$res = $this->webservice_sicas_soap->GetPolicy_forDocto($poliza);
 		$res = $this->ws_sicas->obtenerRecibosPorDocumento($poliza);

 		if(isset($res)){
 			if(!empty($res)){
 				$res=$res->TableInfo;
//$fp = fopen('resultadoJason.txt', 'w');fwrite($fp, print_r($res, TRUE));fclose($fp);     
 				$this->_GuardarBusqueda($poliza,1,1);
				$oPoliza = new \stdClass;
				$oPoliza->Status_TXT = $res->Status_TXT;//$this->getValue();
				$oPoliza->Documento = $this->getValue($res->Documento);
				$oPoliza->FDesde = $this->formatDate($this->getValue($res->FDesde));
				$oPoliza->FHasta = $this->formatDate($this->getValue($res->FHasta));
				$oPoliza->VendNombre = $this->getValue($res->VendNombre);
				$oPoliza->SubGrupo = $this->getValue($res->SubGrupo);
				$oPoliza->CiaNombre = $this->getValue($res->CiaNombre);
				$oPoliza->FPago = $this->getValue($res->FPago);
				$oPoliza->SRamoNombre = $this->getValue($res->SRamoNombre);
				$oPoliza->Grupo = $this->getValue($res->Grupo);
				$oPoliza->PrimaNeta = $this->formatMoney($this->getValue($res->PrimaNeta));
				$oPoliza->PrimaTotal = $this->formatMoney($this->getValue($res->PrimaTotal));

	 			$data['poliza'] = $oPoliza;
				
				//echo "<pre>";
				//print_r($oPoliza);
				//echo "</pre>";
	 			
				$this->load->view('validarinformacion/validapoliza',$data);	
	 		}else{
	 			$this->_GuardarBusqueda($poliza,1,0);
	 			$data['error'] = 'De la poliza: '.$poliza;
	 			$this->load->view('validarinformacion/noencontrado',$data);	
	 		}
 		}else{
 			$this->_GuardarBusqueda($poliza,1,0);
 			$data['error'] = 'De la poliza: '.$poliza;
 			$this->load->view('validarinformacion/noencontrado',$data);	
 		}
 	}

//-----------------------------------------------------------
 function validardatos()
 {
		
 		$datos = $this->input->post('dato');
 		$opcion = $this->input->post('opcion');
	
 		switch ($opcion) 
 		{
 			case '1':$this->_validarPoliza($datos);break;
			case '2':$this->_validarAgente($datos);break;
			case '3':$this->_validarCLUBCAP($datos);break;
            case '4': $this->_validarClave($datos);break;
			case '5': $this->_validarNuevoAcceso($datos);break;
 			default:$this->load->view('validarinformacion/principal');break;
 		}
 	}
//-----------------------------------------------------------
 	 	function validardatosPorSicas(){
	
 		$datos = $_GET['idValidacion']; 	
        $this->_validarClave($datos);

 	}
//-----------------------------------------------------------
 	function _validarCLUBCAP($num){
 		$res = $this->webservice_sicas_soap->GetClient_forCLUBCAP($num);

 		if(isset($res)){
			if(!empty($res)){
				$this->_GuardarBusqueda($num,3,1);
				$oCliente = new \stdClass;
				$oCliente->NombreCompleto = $res->NombreCompleto;
				$oCliente->Monedero = $res->Obs;
				$oCliente->Categoria = $res->Calidad;

	 			$data['cliente'] = $oCliente;
	 			$this->load->view('validarinformacion/clubcap',$data);	
			}else{
				$this->_GuardarBusqueda($num,3,0);
				$data['error'] = 'Del número de afiliación: '.$num;
	 			$this->load->view('validarinformacion/noencontrado',$data);	
			}
 		}else{
 			$this->_GuardarBusqueda($num,3,0);
 			$data['error'] = 'Del número de afiliación: '.$num;
 			$this->load->view('validarinformacion/noencontrado',$data);	
 		}
		
 	}
//-----------------------------------------------------------
 	function _GuardarBusqueda($datos,$opcion,$exito){
 		$data = array(
 			'tipo' => $opcion, 
 			'exito' => $exito,
 			'valor'=> $datos);
 		$result = $this->catalogos_model->GuardarBusqueda($data);
 	}

 	function _validarAgente($name){
 		$result = $this->catalogos_model->validAgente($name);

 		if(count($result) > 0){
 			$this->_GuardarBusqueda($name,2,1);
 			$data['agentes'] = $result;
 			$this->load->view('validarinformacion/agentes',$data);	
 		}else{
 			$this->_GuardarBusqueda($name,2,0);
 			$data['error'] = 'con la clave: '.$name;
 			$this->load->view('validarinformacion/noencontrado',$data);	
 		}
 	}
//-----------------------------------------------------------
 	function _validarClave($name){
 		$result = $this->catalogos_model->validClave($name);

 		if(count($result) > 0){
 			$this->_GuardarBusqueda($name,2,1);
 			$data['agentes'] = $result;
 			$idPersona=$result[0]['idPersona'];
 			
            $consulta=$this->db->query("select id,descripcion from user_miinfofacultades");
            $facultades=$this->db->query('select agenteFacultades,cantidadEstrellas,cantidadPersonasEstrellas,idPersona from user_miInfo where emailUser="'.$result[0]['emailUser'].'"');
	$nombre=$this->db->query('select name_complete from users where email="'.$result[0]['emailUser'].'"');					
			//[Dennis]
			$baneado=$this->db->query("select banned from users where email='".$result[0]['emailUser']."';");
			//---------------------------
			//Dennis [2021-06-14]
			$capacitaciones = $this->capacita_modelo->devuelveMiCapacitacion($result[0]['idPersona']);
			$categories = array("profesional" , "autos", "gmm", "fianzas", "daños", "vida");
			$arrayCap = array();

			foreach($capacitaciones as $val){

				$arrayCap[$val->tipoCapacitacion][$val->nombreCertificado]["data"][strtolower($val->nombre_ramo)] = $val->horas;

				foreach($categories as $vc){

					if(!in_array($vc, array_keys($arrayCap[$val->tipoCapacitacion][$val->nombreCertificado]["data"]))){

						$arrayCap[$val->tipoCapacitacion][$val->nombreCertificado]["data"][$vc] = 0;
					}
				}
			}
			//-------------------
$data['facultades'] = $consulta->result();
$data['facultadesAgenteDato'] = $facultades->result();
$data['nombreUsuario']=$nombre->result()[0]->name_complete;
$data["baneado"]=$baneado->result()[0]->banned; //[Dennis]
$data["estrellasCliente"]=$this->db->query('select * from estrellasvalidador where estaActivo=1 and tipoEstrella=1')->result();
$data['estrellasClienteNuevo']=$this->db->query('select * from estrellasvalidador where estaActivo=1 and tipoEstrella=0')->result();
#$data['totalEstrellas']=$this->obtenerEstrellasValidador($facultades->result()[0]->idPersona);
$data['totalEstrellas']=$this->obtenerEstrellasValidador($idPersona);
$data["capacitacion"] = $arrayCap; //Dennis [2021-06-14] -> [2022-08-01]
#$data['imagenPersonal']= $this->menu_model->buscaFotoPersonal($this->tank_auth->get_idPersona());  
$data['imagenPersonal']= $this->menu_model->buscaFotoPersonal($idPersona);  
$data['imagenesMisCursos']=$this->manejodocumento_modelo->imagenes('archivosPersona/'.$facultades->result()[0]->idPersona.'/misCursos/',0);
  $this->load->model('valoracion_model');
  #$data['totalCuantos']=$this->valoracion_model->getCuantos($this->tank_auth->get_idPersona());
  $data['totalCuantos']=$this->valoracion_model->getCuantos($idPersona);
  #$data['comentarios']=$this->valoracion_model->getComentarios($this->tank_auth->get_idPersona());
  $data['comentarios']=$this->valoracion_model->getComentarios($idPersona);
  #$data['idPersona']=$this->tank_auth->get_idPersona();
  $data['idPersona']=$idPersona;
  $data['puntos']=$this->valoracion_model->getPuntos();
  $data['totalEstrellasPorTipo']=$this->valoracion_model->getTotalEstrellas($idPersona);
  $data['idValidador']=$name;

 			if(isset($_POST['peticionAJAX']))
 			{
 			  echo json_encode($data);
 		    }
 		    else
 		    {
 			$this->load->view('validarinformacion/agentes',$data);	
 		    }
 		}else{
 			$this->_GuardarBusqueda($name,2,0);
 			$data['error'] = 'con la clave: '.$name;
 			$this->load->view('validarinformacion/noencontrado',$data);	
 		}
 	}
//-----------------------------------------------------------
 	function getValue($data){
		return isset($data) ? strval($data) : '';
	}
//-----------------------------------------------------------
 	function formatDate($date){
		$tmpDate = new DateTime($date);
		return $tmpDate->format('Y/m/d');

	}
//-----------------------------------------------------------	
	function formatMoney($num){
		return '$ '.number_format((Double)$num, 2, '.', ',');
	}
//-----------------------------------------------------------

	 function solicitarclubcap(){

	 	$name = $this->input->post('nombre').' '.$this->input->post('apellidop').' '.$this->input->post('apellidom');
	 	$telefono = $this->input->post('telefono');
	 	$correo = $this->input->post('correo');


     	$config['protocol'] = 'sendmail';
		$config['mailpath'] = '/usr/sbin/sendmail';
		$config['charset'] = 'iso-8859-1';
		$config['wordwrap'] = TRUE;
		$config['mailtype'] = 'html';
		
        $this->load->library('email',$config);
        $this->load->library('sendemail');
        $this->sendemail->enviarSolicitudClubCAP($name,$telefono,$correo);

        $this->load->view('validarinformacion/exito');	
    }

//----------------------------------------------------------------------------------------------------------------------------------------------------------------
function guardaEstrellas(){
	if($_POST['inputEstrellas']>0 and $_POST['inputEstrellas']<6){
	$update='update user_miInfo set cantidadEstrellas=cantidadEstrellas+'.$_POST['inputEstrellas'].',cantidadPersonasEstrellas=cantidadPersonasEstrellas+1 where emailUser="'.$_POST['inputEmailEstrella'].'"';
	$this->db->query($update);}
	//$fp = fopen('resultadoJason.txt', 'w');fwrite($fp, print_r($_POST['inputIdGafeteEstrella'],TRUE));fclose($fp);
	$this->_validarClave($_POST['inputIdGafeteEstrella']);
}
//----------------------------------------------------------------------------------------------------------------------------------------------------------------
function guardaInconformidad()
{
	


     $datosAlternos='"nom":'.$_POST['nomInconformidad'].',"tel":'.$_POST['telInconformidad'].',"email":'.$_POST['emailInconformidad'];	
	
	$consulta='select emailUser,(concat(apellidop," ",apellidom," ",nombre)) as nombre,idPersona from user_miInfo where IDValida=' .$_POST['gafeteInconformidad'];
    $consultaDatos=$this->db->query($consulta);
    $insert='insert into inconformidades (descripcion,correoProcedente,nombreProcedente,tipoInconformidad,dirigidoa,fechaRegistro,datosAlternos,idPersona) values("[';
    $insert=$insert.$consultaDatos->result()[0]->emailUser.']'.$_POST['textTareaInconformidad'].'","'.$consultaDatos->result()[0]->emailUser;
    $insert=$insert.'","'.$consultaDatos->result()[0]->nombre.'",1,"directorgeneral@agentecapital.com",now(),\''.$datosAlternos.'\','.$consultaDatos->result()[0]->idPersona.')';

	$this->db->query($insert);
$referencia = $this->db->insert_id();

	         $insertNoConformidad['nombreTabla']='inconformidades';            
	         $insertNoConformidad['idPersonaResponsable']=$_POST['idPersona'];
                         
            $insertNoConformidad['idRowTabla']=$referencia;
            $this->procesamientoncmodel->insertarNC($insertNoConformidad);
	$this->_validarClave($_POST['gafeteInconformidad']);
}
//----------------------------------------------------------------------------------------------------------------------------------------------------------------
function guardarCalificacionEstrella()
{  $datos['mensaje']='guardado';
	
	$consulta['tipoEstrellas']=$_POST['tipo'];
	$consulta['idPersona']=$_POST['idPersona'];	
    $this->db->insert('estrellasvalidadorcabecera',$consulta);
	$last=$this->db->insert_id();
	$valores=explode(';',$_POST['valores']);
	foreach ($valores as $key => $value) 
	{ 
		$insert=explode(',',$value);
		$insertar['idEstrellasValidadorCabecera']=$last;
		$insertar['idEstrellaValidador']=$insert[0];
		$insertar['calificacionValidador']=0;		
		if($insert[1]=="true"){$insertar['calificacionValidador']=1;}
		$this->db->insert('estrellasvalidadorcabecerapartidas',$insertar);
	}   
	$datos['estrellasCliente']= $this->obtenerEstrellasValidador($_POST['idPersona']);
	echo json_encode($datos);
}
//----------------------------------------------------------------------------------------------------------------------------------------------------------------
function obtenerEstrellasValidador($idPersona)
{
  $consulta='select (count(idPersona)) as cuantosCalificaron from estrellasvalidadorcabecera where tipoEstrellas=1 and idPersona='.$idPersona;  
  $datos['estrellasCliente']=$this->db->query($consulta)->result();
  $datos['estrellasClienteNuevas']=$this->db->query('select (count(idPersona)) as cuantosCalificaron from estrellasvalidadorcabecera where tipoEstrellas=0 and idPersona='.$idPersona)->result();
  $datos['estrellasClienteTotal']=$this->db->query('select (count(idPersona)) as cuantosCalificaron from estrellasvalidadorcabecera where idPersona='.$idPersona)->result();
  $consultaTotales='select (sum(if(evc.tipoEstrellas= 0 and evcp.calificacionValidador=1,1,0))) sumClienteNuevo,
  (sum(if(evc.tipoEstrellas=1 and evcp.calificacionValidador=1,1,0))) sumCliente,
  (sum(if(evcp.calificacionValidador=1,1,0))) sumTotal,
  (sum(if(evc.tipoEstrellas= 0 ,1,0))) totalClienteNuevo,(sum(if(evc.tipoEstrellas= 1 ,1,0))) totalCliente,
  (sum(if(evc.tipoEstrellas= 1 || evc.tipoEstrellas= 0,1,0))) total,(cast(min(evc.fechaCreacion)as date)) as primerFechaCalificacion
  from estrellasvalidadorcabecera evc
  left join estrellasvalidadorcabecerapartidas evcp on evcp.idEstrellasValidadorCabecera=evc.idestrellasvalidadorcabecera
  where idPersona='.$idPersona;
  
  $datos['estrellasTotales']=$this->db->query($consultaTotales)->result();
  
  return $datos;
}
//-------------------------------------------------------------------------------------------------
function  calificaElCliente()
{
	
 		$_POST['dato'] = $this->input->get('dato');
 		$_POST['opcion'] =4;
 		$this->validardatos();
 }
//----------------------------------------------------------------------------------------------------------------------------------------------------------------
//Dennis Castillo [2021-10-31]
function _validarNuevoAcceso($data){

	$validateAccess = $this->persona->validatePassCode($data);
	//$fp = fopen('resultadoJason.txt', 'w');fwrite($fp, print_r($validateAccess, TRUE));fclose($fp);
	if(!empty($validateAccess)){

		$personData = $this->persona->buscaPersona($validateAccess->idPersona, "SISTEMAS@ASESORESCAPITAL.COM", 3);
		$userData = $this->persona->obtenerDatosUsuarios($validateAccess->idPersona,'username,passwordVisible');
		//$fp = fopen('resultadoJason.txt', 'w');fwrite($fp, print_r($userData, TRUE));fclose($fp);
		$data_["dateCreation"] = $validateAccess->dateCreation;
		$data_["nameComplete"] = $personData->nombres." ".$personData->apellidoPaterno." ".$personData->apellidoMaterno;
		$data_["user"] =  $userData->username;
		$data_["password"] =  $userData->passwordVisible;
		//$fp = fopen('resultadoJason.txt', 'w');fwrite($fp, print_r($data_, TRUE));fclose($fp);
		$this->load->view("validarinformacion/validatePassCode", $data_);
	} else{
		//$this->load->view("");
	}
	
}
//----------------------------------------------------------------------------------------------------------------------------------------------------------------
function getTemporalAccount($idPersona){

	$data["name"] = $this->persona->obtenerNombrePersona($idPersona); //obtenerDatosUsers
	$data["account"] = $this->persona->obtenerDatosUsers($idPersona);
	$this->load->view("crmproyecto/temporalAccount", $data);
}
//-----------------------------------------------------------
function devuelvePuntosCalificacion()
{
	$respuesta['success']=1;
	  $this->load->model('valoracion_model');
	 	$result = $this->catalogos_model->validClave($_POST['idValidador']);
	 		$idPersona=$result[0]['idPersona'];
	  $puntos=$this->valoracion_model->getPuntos();
  foreach ($puntos as $key => $value) 
  {
  	$estrellas=$this->valoracion_model->total_estrellas($value->id,$idPersona);
  	$value->estrellas=$estrellas;
  }

	   $respuesta['estrellas']=$puntos;
	   $respuesta['idPersona']=$idPersona;
	     $respuesta['totalCuantos']=$this->valoracion_model->getCuantos($idPersona);
	  echo json_encode($respuesta);
}
//-----------------------------------------------------------
function  obtenerComentarios($idPersona='')
{
	 $this->load->model('valoracion_model');
	 $data['success']=1;
	if(isset($_POST['idValidador']))
	{
 		$result = $this->catalogos_model->validClave($_POST['idValidador']);

 			$idPersona=$result[0]['idPersona'];
 					
	}
	$data['comentarios']=$this->valoracion_model->getComentarios($idPersona);

	if(isset($_POST['peticionAJAX'])){echo json_encode($data);}
	else{return $data;}
}
//-----------------------------------------------------------

 } ?>
