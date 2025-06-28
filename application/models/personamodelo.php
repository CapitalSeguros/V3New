<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class PersonaModelo extends CI_Model {
	var $funcionLlamar;
	var $datos=array();
	var $emailUser;
	var $idPersona;
	var $idVend;
	var $idUser;
//-----------------------------------------------------------------
	function __construct(){
		parent::__construct();
     $this->emailUser=$this->tank_auth->get_usermail();
     $this->idPersona=$this->tank_auth->get_idPersona();
     $this->IDVend=$this->tank_auth->get_IDVend();
     $this->idUser=$this->tank_auth->get_IDUserSICAS();
     $this->load->model('notificacionmodel');

	}
//-----------------------------------------------------------------
public function index($funcion,$consulta,$id){
 switch ($funcion) {
	case "0":$this->getterDatos($consulta);break;
	case "1":$last=$this->setterDatos($consulta);return $last;  break;
	case "2":$this->updateDatos($consulta,$id);break;
	case "3":$this->nuevoPersonaDP($consulta);break;
	case "4":$this->updatePersonaDP($consulta,$id);break;
	case "5":$this->nuevoPermisoVend($consulta);break;
	case "6":$this->actualizaPermisoVend($consulta);break;
	case "7":$this->nuevoUserConfig($consulta);break;
    case "8":$this->actualizaUserConfig($consulta,$id);break;

  }

}
//-----------------------------------------------------------------
public function solicitarPermisoCapsys($idPersona,$tipoPersona){
	//$tipoPersona 4->EN PROCESO DE CAPSYS, 3->EN AGENTE
  $actualiza="update persona set tipoPersona=".$tipoPersona." where idPersona=".$idPersona;
  if($tipoPersona==4){
  	$this->enviarCorreo("AUDITORINTERNO@AGENTECAPITAL.COM","ALTA V3","Alta de :".$this->obtenerNombrePersona($idPersona));
  }
  else{
  	if($tipoPersona==3){
  		$email=$this->obtenerUsuarioCreacion($idPersona);
  		
  		$this->enviarCorreo($email,"ALTA V3","Revisar el alta de agente de: ".$this->obtenerNombrePersona($idPersona));
  		$this->enviarCorreo("SISTEMAS@ASESORESCAPITAL.COM","EMAIL","Revisar el correo del usuario: ".$this->obtenerNombrePersona($idPersona));
  	}
  }
  $this->db->query($actualiza);
}
//-----------------------------------------------------------------
public function enviarCorreo($para,$asunto,$mensaje){

 $usuarioCreacion="";
 $agente="";
	$insertCorreo="insert into envio_correos(fechacreacion,desde,para,copia,copiaoculta,asunto,mensaje,status,fechaenvio)";
	$insertCorreo=$insertCorreo.'values(now(), "Buzon de quejas<avisosgap@aserorescpital.com>","'.$para.'" ,0,0,"'.$asunto.'","'.$mensaje.'",0,now());';
 $this->db->query($insertCorreo);

}
//-----------------------------------------------------------------
public function compruebaExistenciaEmail($email,$idPersona)
{

	$email=strtoupper($email);
	$consulta='select (count(users.id)) as cantidad,idPersona from users where users.email="'.$email.'" limit 1';
	$datos=$this->db->query($consulta)->result()[0]->cantidad;
    
    
	 if($this->db->query($consulta)->result()[0]->idPersona==$idPersona){$datos=0;}
	 return $datos;	  	
}
//------------------- //Dennis Castillo [2022-06-02]
function getDataForInsert($params, $person){

	$responseForInsert = array();
	switch($params["type"]){
		case 1:
			$creator = $this->tank_auth->get_usermail();
			
			if(!empty($params["permit"])){ //Toma al creador de la solicitud de alta de colaborador y lo pasa como verdadero creador.

				$this->db->from("persona_temporal a");
				$this->db->join("persona_temporal_creator b", "a.idPersona = b.idTemporalPerson", "left");
				$this->db->where("a.idPersona", $params["permit"]);
				$query = $this->db->get()->row();

				if(!empty($query)){
					$creator = $query->creator;
				}
			}

			$responseForInsert[] = array("table" => "true_creator", "data" => array("idChild" => $person, "creator" => $creator));
			$responseForInsert[] = array("table" => "employe_to_user", "data" => array("idPersona" => $person));
			//$responseForInsert["typeQuery"] = "insert";
			break;
		//case 3:
			//break;
	}

	return $responseForInsert;
}
//------------------- //Dennis Castillo [2022-06-02]
function getArrayTable($table, $array){

	$fields = $this->db->list_fields($table);
	$response = array();

	foreach($fields as $df){

		$response[$df] = isset($array[$df]) ? $array[$df] : null;
	}

	return $response;
}
//-----------------------------------------------------------------
public function insertaPersona($datos){

	//------------------------
	$newArrayTable = array();
	$arrayTable = array("persona_contrato", "requerimientos_y_perfil_del_puesto");

	foreach($arrayTable as $nameTable){
		$newArrayTable[$nameTable] = $this->getArrayTable($nameTable, $datos);
		unset($newArrayTable[$nameTable]["id"]); //Elimina el id para pasarlo como nulo (Evita el conflicto id 0).

		foreach($newArrayTable[$nameTable] as $key => $value){ //Eliminar del array principal.
			unset($datos[$key]);
		}
	}
	//------------------------
	$params = array(
		"permit" => (isset($datos["permit"]) ? $datos["permit"] : 0), 
		"prospective" => (isset($datos["prospectiveAgent"]) ? $datos["prospectiveAgent"] : null),
		"type" => $datos["tipoPersona"]
	);
	//------------------------
	unset($datos['certificacion']);
	unset($datos['certificacionAutos']);
	unset($datos['certificacionGmm']);
	unset($datos['certificacionVida']);
	unset($datos['certificacionDanos']);
	unset($datos['certificacionFianzas']);
	unset($datos['honorariosCVH']);
	unset($datos['IDVendNS']);
	unset($datos['CodeAuthPersonaSicas']);
	unset($datos['CodeAuthUserPersonaSicas']);
	unset($datos['promotoriasActivadas']);
	unset($datos['banned']);
	unset($datos['UsuarioCarCapital']);
	unset($datos['aliadoCarCapital']); //Dennis [2022-06-07]
	unset($datos['usuarioPersona']);
	unset($datos['usuarioPassword']);
	//----------
	//Dennis Castillo [2021-10-31]
	unset($datos["prospectiveAgent"]);
	unset($datos['permit']);
	unset($datos['sendNotification']); //Dennis [2022-01-05]
	//-----------
	$datos['nombres']=strtoupper($datos['nombres']);
	$datos['apellidoPaterno']=strtoupper($datos['apellidoPaterno']);
	$datos['apellidoMaterno']=strtoupper($datos['apellidoMaterno']);
	$datos['cedulaPersona']=strtoupper($datos['cedulaPersona']);
	$datos['PRCAgentePersona'];
	$datos['fecIniCedulaPersona'];
	$datos['fecFinCedulaPersona'];
	$datos['fecIniPRCAgentePersona'];
	$datos['fecFinPRCAgentePersona'];
	$datos['idModalidad'];
	//Miguel Jaime 19-11-2021
	$datos['nombrePapa']=strtoupper($datos['nombrePapa']);
	$datos['edadPapa']=$datos['edadPapa'];
	$datos['nombreMama']=strtoupper($datos['nombreMama']);
	$datos['edadMama']=$datos['edadMama'];
	$datos['nombreEsposo']=strtoupper($datos['nombreEsposo']);
	$datos['edadEsposo']=$datos['edadEsposo'];
	//$datos['sexo']=$datos['sexo'];
	//$datos['ingles']=$datos['ingles'];
	//$datos['postgrado']=$datos['postgrado'];
	//$datos['viajar']=$datos['viajar'];
	//$datos['herramientas_office']=$datos['herramientas_office'];
	$datos['experiencia'] = isset($datos['experiencia']) ? $datos['experiencia'] : null; //Dennis Castillo [2022-03-01]
	$datos['habilidades'] = isset($datos['habilidades']) ? $datos['habilidades'] : null; //Dennis Castillo [2022-03-01]
	$datos['competencias'] = isset($datos['competencias']) ? $datos['competencias'] : null; //Dennis Castillo [2022-03-01]
	$datos['idColaboradorArea'] = $datos['tipoPersona'] == 1 ? $datos['idColaboradorArea'] : 1;
	//---------------------------

	$this->db->trans_begin();

	//insert Person
	$this->db->insert('persona', $datos);
 	$last = $this->db->insert_id();
	
	//Insert in other tables
	$otherTables = $this->getDataForInsert($params, $last);

	if($datos["tipoPersona"] == 1){

		foreach($newArrayTable as $table => $dataTable){

			$dataTable["idPersona"] = $last;
			$this->db->insert($table, $dataTable);
		}

		foreach($otherTables as $di){ //insert en employee to user, true creator tables
			$this->db->insert($di["table"], $di["data"]);
		}
	} else{

		$this->db->insert("temporal_persons", array("idPersona" => $last)); //Insert temporal id (unknwon table)
	}

	if($this->db->trans_status() === FALSE){
			
		$this->db->trans_rollback();
		//return $this->db->error();
		//throw new Exception("Ocurrió un error en la transacción.\nError: ".$this->db->error());

	} else{
		$this->db->trans_commit();
		//return  $last;
	}

	return $last;
	//if($datos['idModalidad']==''){$datos['idModalidad']=null;}
	//if($datos['idPersonaPuesto']==''){$datos['idPersonaPuesto']=0;}
	//if($datos['personaTipoAgente']==''){$datos['personaTipoAgente']=1;}
	//if($datos['gastoMenPersona']==''){$datos['gastoMenPersona']=0;}
	//if($datos['metaPersona']==''){$datos['metaPersona']=0;}
}
//-----------------------------------------------------------------
public function actualizaPersona($consulta,$id){
	$idPersonaPuesto='';

	$newArrayTable = array();
	$arrayTable = array("persona_contrato", "requerimientos_y_perfil_del_puesto");

	foreach($arrayTable as $nameTable){
		$newArrayTable[$nameTable] = $this->getArrayTable($nameTable, $consulta);
		unset($newArrayTable[$nameTable]["id"]);

		foreach($newArrayTable[$nameTable] as $key => $value){ //Eliminar del array principal.
			unset($consulta[$key]);
		}
	}
	//------------------------
	unset($consulta['certificacion']);
	unset($consulta['certificacionAutos']);
	unset($consulta['certificacionGmm']);
	unset($consulta['certificacionVida']);
	unset($consulta['certificacionDanos']);
	unset($consulta['certificacionFianzas']);
	unset($consulta['honorariosCVH']);
	unset($consulta['IDVendNS']);
	unset($consulta['CodeAuthPersonaSicas']);
	unset($consulta['CodeAuthUserPersonaSicas']);
	unset($consulta['promotoriasActivadas']);
	//-----------------
	//Dennis Castillo [2021-10-31]
	unset($consulta['setfree']);
	unset($consulta['permit']);
	unset($consulta['sendNotification']); //Dennis [2022-01-05]
	//-----------------
	$consulta['PRCAgentePersona'];
	$consulta['nombres']=strtoupper($consulta['nombres']);
	$consulta['apellidoPaterno']=strtoupper($consulta['apellidoPaterno']);
	$consulta['apellidoMaterno']=strtoupper($consulta['apellidoMaterno']);
	$consulta['cedulaPersona']=strtoupper($consulta['cedulaPersona']);
	$consulta['fecIniCedulaPersona'];
	$consulta['fecFinCedulaPersona'];
	$consulta['fecIniPRCAgentePersona'];
	$consulta['fecFinPRCAgentePersona'];
	$consulta['tipoCedulaAgentePersona'];
	

	$this->db->trans_begin();

		if($consulta['tipoPersona']!=1)
		{
			$con='select esAgenteColaborador from persona where idPersona='.$id;
			$verificarDatos=$this->db->query($con)->result()[0];
			if($verificarDatos->esAgenteColaborador!=1){$consulta['idColaboradorArea']=0;$consulta['idPersonaPuesto']=0;}         
		}

		if($consulta['idPersonaPuesto']==''){unset($consulta['idPersonaPuesto']);}
    	else{$idPersonaPuesto=$consulta['idPersonaPuesto'];}

		$this->db->where('idPersona',$id);
 		$this->db->update('persona',$consulta);

		if($consulta["tipoPersona"] == 1){

			foreach($newArrayTable as $table => $dataTable){

				$dataTable["idPersona"] = $id;
				if($this->db->where("idPersona", $id)->get($table)->num_rows() > 0){

					$this->db->where("idPersona", $id);
					$this->db->update($table, $dataTable);
				} else {
					$this->db->insert($table, $dataTable);
				}
			}
		}

		if($idPersonaPuesto=='98')
		{
			$update='update personapuesto set idPersona=0 where idPuesto=98';
			$this->db->query($update);
		}

	if($this->db->trans_status() === FALSE){
		$this->db->trans_rollback();
	} else {
		$this->db->trans_commit();
	}
}
//-----------------------------------------------------------------
public function actualizaHorario($id,$datos){
	$update='update persona set persona.entradaLunes="'.$datos["entLunes"].'", persona.salidaLunes="'.$datos["salLunes"].'", persona.entradaMartes="'.$datos["entMartes"].'", persona.salidaMartes="'.$datos["salMartes"].'", persona.entradaMiercoles="'.$datos["entMiercoles"].'", persona.salidaMiercoles="'.$datos["salMiercoles"].'",persona.entradaJueves="'.$datos["entJueves"].'", persona.salidaJueves="'.$datos["salJueves"].'",persona.entradaViernes="'.$datos["entViernes"].'", persona.salidaViernes="'.$datos["salViernes"].'", persona.entradaSabado="'.$datos["entSabado"].'", persona.salidaSabado="'.$datos["salSabado"].'", persona.entradaDomingo="'.$datos["entDomingo"].'", persona.salidaDomingo="'.$datos["salDomingo"].'", persona.tipoTrabajo="'.$datos["tipoTrabajo"].'" WHERE idPersona='.$id;
	$this->db->query($update);
}
//-----------------------------------------------------------------
public function insertaPersona_obsoleto($datos){ //Funcion obsoleta - Dennis Castillo [2022-06-02]

	//------------------------
	$newArrayTable = array();
	$arrayTable = array("persona_contrato", "requerimientos_y_perfil_del_puesto");

	foreach($arrayTable as $nameTable){
		$newArrayTable[$nameTable] = $this->getArrayTable($nameTable, $datos);
		unset($newArrayTable[$nameTable]["id"]); //Elimina el id para pasarlo como nulo (Evita el conflicto id 0).

		foreach($newArrayTable[$nameTable] as $key => $value){ //Eliminar del array principal.
			unset($datos[$key]);
		}
	}
	//------------------------
	$params = array(
		"permit" => (isset($datos["permit"]) ? $datos["permit"] : 0), 
		"prospective" => (isset($datos["prospectiveAgent"]) ? $datos["prospectiveAgent"] : null),
		"type" => $datos["tipoPersona"]
	);
	//------------------------
	unset($datos['certificacion']);
	unset($datos['certificacionAutos']);
	unset($datos['certificacionGmm']);
	unset($datos['certificacionVida']);
	unset($datos['certificacionDanos']);
	unset($datos['certificacionFianzas']);
	unset($datos['honorariosCVH']);
	unset($datos['IDVendNS']);
	unset($datos['CodeAuthPersonaSicas']);
	unset($datos['CodeAuthUserPersonaSicas']);
	unset($datos['promotoriasActivadas']);
	unset($datos['banned']);
	unset($datos['UsuarioCarCapital']);
	unset($datos['usuarioPersona']);
	unset($datos['usuarioPassword']);
	//----------
	//Dennis Castillo [2021-10-31]
	unset($datos["prospectiveAgent"]);
	unset($datos['permit']);
	unset($datos['sendNotification']); //Dennis [2022-01-05]
	//-----------
	$datos['nombres']=strtoupper($datos['nombres']);
	$datos['apellidoPaterno']=strtoupper($datos['apellidoPaterno']);
	$datos['apellidoMaterno']=strtoupper($datos['apellidoMaterno']);
	$datos['cedulaPersona']=strtoupper($datos['cedulaPersona']);
	$datos['PRCAgentePersona'];
	$datos['fecIniCedulaPersona'];
	$datos['fecFinCedulaPersona'];
	$datos['fecIniPRCAgentePersona'];
	$datos['fecFinPRCAgentePersona'];
	$datos['idModalidad'];
	//Miguel Jaime 19-11-2021
	$datos['nombrePapa']=strtoupper($datos['nombrePapa']);
	$datos['edadPapa']=$datos['edadPapa'];
	$datos['nombreMama']=strtoupper($datos['nombreMama']);
	$datos['edadMama']=$datos['edadMama'];
	$datos['nombreEsposo']=strtoupper($datos['nombreEsposo']);
	$datos['edadEsposo']=$datos['edadEsposo'];
	$datos['sexo']=$datos['sexo'];
	$datos['ingles']=$datos['ingles'];
	$datos['postgrado']=$datos['postgrado'];
	$datos['viajar']=$datos['viajar'];
	$datos['herramientas_office']=$datos['herramientas_office'];
	$datos['experiencia'] = isset($datos['experiencia']) ? $datos['experiencia'] : null; //Dennis Castillo [2022-03-01]
	$datos['habilidades'] = isset($datos['habilidades']) ? $datos['habilidades'] : null; //Dennis Castillo [2022-03-01]
	$datos['competencias'] = isset($datos['competencias']) ? $datos['competencias'] : null; //Dennis Castillo [2022-03-01]
	//$datos['experiencia']=$datos['experiencia']; 
	//$datos['habilidades']=$datos['habilidades'];
	//$datos['competencias']=$datos['competencias'];
	//---------------------------



        $nombre=$datos['nombres'].' '.$datos['apellidoPaterno'].' '.$datos['apellidoMaterno'];
	if($datos['tipoPersona']==1)
	{
		$datos['userEmailCreacion']='CAPITALHUMANO@AGENTECAPITAL.COM';
		  $nombre=$datos['nombres'].' '.$datos['apellidoPaterno'].' '.$datos['apellidoMaterno'];

    $mensaje="El colaborador ".$nombre." a sido dado de alta revisar su alta en SICAS";
    $para='SISTEMAS@ASESORESCAPITAL.COM';
   $this->operPersona->enviarCorreo($para,"Alta de colaborador",$mensaje);

	}
	else{$datos['idColaboradorArea']=0;}
	if($datos['idModalidad']==''){$datos['idModalidad']=null;}
	if($datos['idPersonaPuesto']==''){$datos['idPersonaPuesto']=0;}
	if($datos['personaTipoAgente']==''){$datos['personaTipoAgente']=1;}
	if($datos['gastoMenPersona']==''){$datos['gastoMenPersona']=0;}
	if($datos['metaPersona']==''){$datos['metaPersona']=0;}

 	$this->db->insert('persona',$datos);
 	$last=$this->db->insert_id();
        $notificacion['tabla']='personas';
        $notificacion['idTabla']=$last;
        $notificacion['persona_id']=$this->tank_auth->get_idPersona();
        $notificacion['email']=  $this->tank_auth->get_usermail();
        $notificacion['tipo_id']='email';
        $notificacion['referencia']='CAPACITACION_NUEVO_INGRESO';
        $notificacion['referencia_id']='1000';
        $notificacion['check']=0;
        $notificacion['comentarioAdicional']='Capacitacion para '.$nombre;
        $notificacion['id']=-1;
        $notificacion['tipo']='OTRO';
        $notificacion['controlador']='persona/agentesEnProceso';
        $this->notificacionmodel->notificacion($notificacion);
     return  $last;
}
//-----------------------------------------------------------------
public function actualizaPersona_obsoleto($consulta,$id){ //Funcion obsoleta - Dennis Castillo [2022-06-02]
	$idPersonaPuesto='';
	
	unset($consulta['certificacion']);
	unset($consulta['certificacionAutos']);
	unset($consulta['certificacionGmm']);
	unset($consulta['certificacionVida']);
	unset($consulta['certificacionDanos']);
	unset($consulta['certificacionFianzas']);
	unset($consulta['honorariosCVH']);
	unset($consulta['IDVendNS']);
	unset($consulta['CodeAuthPersonaSicas']);
	unset($consulta['CodeAuthUserPersonaSicas']);
	unset($consulta['promotoriasActivadas']);
	//-----------------
	//Dennis Castillo [2021-10-31]
	unset($consulta['setfree']);
	unset($consulta['permit']);
	unset($consulta['sendNotification']); //Dennis [2022-01-05]
	//-----------------
	$consulta['PRCAgentePersona'];
	$consulta['nombres']=strtoupper($consulta['nombres']);
	$consulta['apellidoPaterno']=strtoupper($consulta['apellidoPaterno']);
	$consulta['apellidoMaterno']=strtoupper($consulta['apellidoMaterno']);
	$consulta['cedulaPersona']=strtoupper($consulta['cedulaPersona']);
	$consulta['fecIniCedulaPersona'];
	$consulta['fecFinCedulaPersona'];
	$consulta['fecIniPRCAgentePersona'];
	$consulta['fecFinPRCAgentePersona'];
	$consulta['tipoCedulaAgentePersona'];
	
    if($consulta['tipoPersona']!=1)
    {
    	$con='select esAgenteColaborador from persona where idPersona='.$id;
     $verificarDatos=$this->db->query($con)->result()[0];
     if($verificarDatos->esAgenteColaborador!=1){$consulta['idColaboradorArea']=0;$consulta['idPersonaPuesto']=0;}         
    }

    if($consulta['idPersonaPuesto']==''){unset($consulta['idPersonaPuesto']);}         
    else{$idPersonaPuesto=$consulta['idPersonaPuesto'];}
  	$this->db->where('idPersona',$id);
 	$this->db->update('persona',$consulta);
    if($idPersonaPuesto=='98')
    {
    	$update='update personapuesto set idPersona=0 where idPuesto=98';
    	$this->db->query($update);
    }

}
//--------------------------------------------------------
public function actualizarPersonaGeneral($consulta,$id){
  
   	$this->db->where('idPersona',$id);
 	$this->db->update('persona',$consulta);
 }
//-----------------------------------------------------------------
public function buscaPersona($idPersona,$email,$sinEmail){
	/*CUANDO EL IDVend DE PERSONA=0 SIGNIFICA QUE NO ESTA DADO DE ALTA EN SICAS*/
  if($this->tank_auth->get_usermail()=='AUDITORINTERNO@AGENTECAPITAL.COM' ||
  $this->tank_auth->get_usermail()=='DIRECTORGENERAL@AGENTECAPITAL.COM' || $this->tank_auth->get_usermail()=='SISTEMAS@ASESORESCAPITAL.COM' || $this->emailUser=="SUBGERENTE@CAPCAPITAL.COM.MX" || $this->emailUser=="MARKETING@AGENTECAPITAL.COM" || $this->emailUser=="GERENTEOPERATIVO@AGENTECAPITAL.COM" || $this->emailUser=="DIRECTORCOMERCIAL@AGENTECAPITAL.COM")
  {
  $consulta="select * from persona where  idPersona=".$idPersona;
  }else
  {
    if($sinEmail==0)
    {
   	if($email=="COORDINADOR@FIANZASCAPITAL.COM"){$email="GERENTE@FIANZASCAPITAL.COM";}
      $consulta="select * from persona where userEmailCreacion='".$email."' and idPersona=".$idPersona;
    }
    else
  	 {
  	   $consulta="select * from persona where  idPersona=".$idPersona;
     }
 }
 
  return $this->db->query($consulta)->result()[0];	  	

 }
//-----------------------------------------------------------------
public function buscaPersonaPorCampo($idPersona,$campos){
   /*LOS CAMPOS SON CADENA SEPARADOS CON COMAS*/
   $consulta='select '.$campos. ' from persona where  idPersona='.$idPersona; 


    return $this->db->query($consulta)->result()[0];	
 }
//-----------------------------------------------------------------
public function buscarIdDespachoSicas($idSucursal){
   /*DEVUELVE EL IDSUCRSAL QUE SE GRABA EN SICAS*/
   $consulta='select  idDespachoSicas from catalog_sucursales where  idSucursal='.$idSucursal; 
    return $this->db->query($consulta)->result()[0];
}
//------------------------------------------------------------------
public function obtenerIdCatalogTipoUser($ranking){
	$consulta='select * from catalog_tipouser  where idPersonaRankingAgenteP="'.$ranking.'"';
	 return $this->db->query($consulta)->result()[0];
}
//------------------------------------------------------------------
public function buscarTipoVendedorSicas($idTipoVendedor){
/*====== SE BUSCA LA EQUIVALENCIA  DE TIPO VENDEDOR EN SICAS CON CAPSYS=========*/

 $consulta='select idTipoVendedorSicas from personatipoagente where idPersonaTipoAgente='.$idTipoVendedor;
   return $this->db->query($consulta)->result()[0];
}
//------------------------------------------------------------------------
public function buscarGerenciaSicasEnCatalogCanales($idCatalogCanal){
/*========NOS DEVUELVE LA EQUIVALENCIA DE CANAL EN SICAS EL CUAL ES IDGerencia EN SICAS========*/
$consulta='select idGerenciaSicas from catalog_canales where idCanal='.$idCatalogCanal;
   return $this->db->query($consulta)->result()[0];

}
//------------------------------------------------------------------------
public function buscaPersonaBaneo($idPersona){
  $consulta="select * from persona where  idPersona=".$idPersona;	
  return $this->db->query($consulta)->result()[0];
 }
//-----------------------------------------------------------------

public function obtenerPermisoVendedores($ramo,$idPersona){
	$consulta="select permiso from vend_permisos where ramo='".$ramo."' and idpersona=".$idPersona;
	//$datos=array();
	$datos=$this->db->query($consulta)->result()[0]->permiso;

	if($datos=="")//if(count($datos)==0) 
        {

		$email=$this->db->query("select email from users where idPersona=".$idPersona)->result()[0];

		$insert['modulo']='actividades';
		$insert['subModulo']='agregar';
		$insert['tipo']='Cotizacion';
		$insert['ramo']=$ramo;
		$insert['accion']="VER";
		$insert['permiso']="NO";
		$insert['idPersona']=$idPersona;
		$insert['emailUser']=$email->email;
		$this->db->insert('vend_permisos',$insert);
		$datos=$this->db->query($consulta)->result()[0]->permiso;
	}
	
	 return $datos;
 }
//-----------------------------------------------------------------
public function obtenerEscolaridad(){
	$consulta='select * from personaescolaridad';
		$datos=$this->db->query($consulta)->result();

	 return $datos;
}
//-----------------------------------------------------------------
public function obtenerUnaEscolaridad($idEscolaridad){
	$consulta="select escolaridad from personaescolaridad where idEscolaridad=".$idEscolaridad;
		$datos=$this->db->query($consulta)->result();
	 return $datos;
}
//-----------------------------------------------------------------
public function obtenerEstadoCivil(){
	$consulta='select * from personaestadocivil';
		$datos=$this->db->query($consulta)->result();
	 return $datos;	
}
//-----------------------------------------------------------------
public function obtenerUnEstadoCivil($idEstadoCivil){
	$consulta="select estadoCivil from personaestadocivil where idEstadoCivil=".$idEstadoCivil;
		$datos=$this->db->query($consulta)->result();

	 return $datos;
}
//-----------------------------------------------------------------

public function obtenerTipoAgente(){
if($this->emailUser=='AUDITORINTERNO@AGENTECAPITAL.COM' || $this->emailUser=='SISTEMAS@ASESORESCAPITAL.COM' || $this->emailUser=='DIRECTORGENERAL@AGENTECAPITAL.COM' || $this->emailUser=='MARKETING@AGENTECAPITAL.COM')
	{$consulta='select * from personatipoagente';
		$datos=$this->db->query($consulta)->result();
		}
	else{
    $consulta='select * from personatipoagentepermisos ptap left join personatipoagente pta on pta.idPersonaTipoAgente=ptap.idPersonaTipoAgente where ptap.idPersona='.$this->idPersona;
		$datos=$this->db->query($consulta)->result();
	}
	 return $datos;	
	
}
//------------------------------------------------------------------
public function guardarPermisoTipoAgente($idPersona,$permisos){
/*
GUARDA LOS TIPOS DE AGENTE QUE PUEDE CREAR UNA PERSONA
idPersona=AL ID DE LA PERSONA ES UN ENTERO
$permisos=SON LOS ID DE personaTipoAgente DE LOS CUALES PUEDE TENER UNA PERSONA ES UN STRING DE ENTEROS SEPARADOS CON PUNTO Y COMA(;)
 */
if($idPersona!='' and $idPersona!=null){
$delete="delete from personatipoagentepermisos where idPersona=".$idPersona;
$this->db->query($delete);
$permisos=explode(';',$permisos); 
foreach ($permisos as  $value) {
	if($value!="" && $value!=NULL ){
	$insert['idPersona']=$idPersona;
	$insert['idPersonaTipoAgente']=$value;
	$this->db->insert('personatipoagentepermisos',$insert);
   }
}
}
}

//-----------------------------------------------------------------
public function devuelvePermisoTipoAgente($idPersona){
	$consulta="select ptap.idPersona,ptap.idPersonaTipoAgente 
from personatipoagentepermisos ptap where ptap.idPersona=".$idPersona;
  $permisos=$this->db->query($consulta)->result();
  $consulta="select *,'0' as permiso from personatipoagente";
  $tipoAgente=$this->db->query($consulta)->result();
 // $permisoAgente=array();
 $respuesta=array();
  foreach($permisos as $value){
     foreach($tipoAgente as $valueTA){
     	if($value->idPersonaTipoAgente==$valueTA->idPersonaTipoAgente){
     		$valueTA->permiso=1;
     		//array_push($permisoAgente,$valueTA);

     	}
     }

  }
  if($this->emailUser=='AUDITORINTERNO@AGENTECAPITAL.COM' || $this->emailUser=='SISTEMAS@ASESORESCAPITAL.COM' || $this->emailUser=='DIRECTORGENERAL@AGENTECAPITAL.COM')
  {$respuesta['permisoPTAMaster']=$tipoAgente;
  }
 // $respuesta['permisoPTACoordinador']=$permisoAgente;
  
 
return $respuesta;

}
//-----------------------------------------------------------------
public function obtenerCatalogSucursales(){
	$consulta='select * from  catalog_sucursales';
		$datos=$this->db->query($consulta)->result();
	 return $datos;		
}
//-----------------------------------------------------------------
public function obtenerCatalogCanales(){
	$consulta='select IdCanal,nombreTitulo from  catalog_canales where activo=1';
		$datos=$this->db->query($consulta)->result();
	 return $datos;		
}
//-----------------------------------------------------------------
public function obtenerCatalogPromotorias()
{
		$consulta='select * from  catalog_promotorias where activoPromotoria=1';
		$datos=$this->db->query($consulta)->result();
	 return $datos;
}
//-----------------------------------------------------------------
public function obtenerDatoCatalogoPromotoria($idPromotoria)
{
	$consulta='select * from  catalog_promotorias where idPromotoria='.$idPromotoria;
		$datos=$this->db->query($consulta)->result();
	 return $datos;
}
//-----------------------------------------------------------------
public function obtenerGiroAgente(){
		$consulta='select personaGiroAgente from  personagiroragente';
		$datos=$this->db->query($consulta)->result();
	 return $datos;	
}
//-----------------------------------------------------------------
public function obtenerRankingAgente(){
	/*persona,permisosOperativos*/
		$consulta='select personaRankingAgente,companiasPermitidasPRA from  personarankingagente where activoPRA=1';
		$datos=$this->db->query($consulta)->result();
	 return $datos;	
}
//-----------------------------------------------------------------
//Cambios Edwin Marin
public function obtenerPuntosProspeccion(){
	/*persona,permisosOperativos*/
		$consulta='select prospeccion,puntosOtorgados from  puntosprospeccion where activoPP=1';
		$datos=$this->db->query($consulta)->result();
	 return $datos;	
}
//-----------------------------------------------------------------
//Cambios Edwin Marin
public function obtenerPuntosProspeccionIndividual($prospeccion){
	/*persona,permisosOperativos*/
		$consulta='select puntosOtorgados from  puntosprospeccion where prospeccion="'.$prospeccion.'"';
		$datos=$this->db->query($consulta);
		$puntos=$datos->result()[0]->puntosOtorgados;
	 return $puntos;	
}
//-----------------------------------------------------------------
public function nuevoUserConfig($consulta){

  $consulta['apellidop']=strtoupper($consulta['apellidop']);
  $consulta['apellidom']=strtoupper($consulta['apellidom']);
  $consulta['nombre']=strtoupper($consulta['nombre']);
  $consulta['emailUser']=(string)($consulta['emailUser']);

  $this->db->insert('user_miInfo',$consulta)	;
  }
//-----------------------------------------------------------------
public function actualizaUserConfig($consulta,$id){
	
    unset($consulta['idPersona']);
     $consulta['apellidop']=strtoupper($consulta['apellidop']);
   $consulta['apellidom']=strtoupper($consulta['apellidom']);
   $consulta['nombre']=strtoupper($consulta['nombre']);

 	$this->db->where('idPersona',$id); 
 	$this->db->update('user_miInfo',$consulta);
 }
//-----------------------------------------------------------------
 

public function obtenerAgenteFacultades($idPersona){
		$consulta="select agenteFacultades from  user_miInfo where idPersona=".$idPersona;

		$datos=$this->db->query($consulta)->result();
	 return $datos;		
  }
//-----------------------------------------------------------------

public function insertarEnUser($datos){
   $datos['name_complete']=strtoupper($datos['name_complete']);
   $datos['email']=strtoupper($datos['email']);
   if(isset($datos['UsuarioCarCapital']))
   {
   	if($datos['UsuarioCarCapital']=='SI'){$datos['UsuarioCarCapital']=1;}
   	if($datos['UsuarioCarCapital']=='NO'){$datos['UsuarioCarCapital']=0;}
   }
   $this->db->insert('users',$datos);

 }

//---------------------------------------------------------------

 public function insertarEnCatalogVendedores($datos){
    $datos['NombreCompleto']=strtoupper($datos['NombreCompleto']);
    $datos['ApellidoP']=strtoupper($datos['ApellidoP']);
    $datos['ApellidoM']=strtoupper($datos['ApellidoM']);
    $datos['Nombre']=strtoupper($datos['Nombre']);
   $this->db->insert('catalog_vendedores',$datos)	;

 }

//---------------------------------------------------------------
public function actualizaUser($consulta,$id){

	$this->db->trans_begin();

	if(isset($consulta['banned']) && isset($consulta['tipoPersona']) && $consulta['tipoPersona'] == 1){  
		if($consulta['banned']==1)
             {
                
              $consulta['activated']=0; 
              $emailDisponible=$this->db->query('select email from users where idPersona='.$id)->result()[0]->email;
              $consulta['email']=$id.'_'.$emailDisponible;
              $consulta['emailOld']=$emailDisponible;
              $consulta['username']=$id.'_'.$emailDisponible;
              //$update='update persona set idPersonaPuesto=0 where idPersona='.$id.' limit 1'; //Comentado por Dennis Castillo [2022-06-13]
              //$this->db->query($update); Comentado por Dennis Castillo [2022-06-13]
             }	
			else{$consulta['activated']=1; 	}
			//unset($consulta['tipoPersona']);
        }
	unset($consulta['tipoPersona']);
    $consulta['name_complete']=strtoupper($consulta['name_complete']);
    if(isset($consulta['email'])){$consulta['email']=strtoupper($consulta['email']);}
    	$this->db->where('idPersona',$id); 
    	$this->db->update('users',$consulta);
    
	if($this->db->trans_status() === FALSE){
		$this->db->trans_rollback();
	} else{
		$this->db->trans_commit();
	}
  }
//-----------------------------------------------------------------
public function actualizarCatalogVendedores($consulta,$id){
    $consulta['NombreCompleto']=strtoupper($consulta['NombreCompleto']);
    $consulta['ApellidoP']=strtoupper($consulta['ApellidoP']);
    $consulta['ApellidoM']=strtoupper($consulta['ApellidoM']);
    $consulta['Nombre']=strtoupper($consulta['Nombre']);

    	$this->db->where('idPersona',$id); 
    	$this->db->update('catalog_vendedores',$consulta);
  }
//------------------------------------------------------------------

public function obtenerTarget($idPersona,$tipoTarget){
	//$tipoTarget=$this->obtenerTipoAgenteParaLaoyut($idPersona);
	$consulta="select * from target where tipoTarget=".$tipoTarget;
	$datos['target']=$this->db->query($consulta)->result();
		$consulta='select * from personatarget where personatarget.idPersona='.$idPersona.' and personatarget.tipoTarget='.$tipoTarget;
		$datos['targetPersona']=$this->db->query($consulta)->result();
	$consulta="select (concat(nombres,' ',apellidoPaterno,' ',apellidoMaterno)) as nombre from persona where idPersona=".$idPersona;
	$datos['nombre']=$this->db->query($consulta)->result();
	$consulta='select (cast(fecEvaluacion as date)) as fecha from personatarget  where idPersona='.$idPersona.' and tipoTarget='.$tipoTarget.' limit 1';
	$datos['fecha']=$this->db->query($consulta)->result();
	
  
	return $datos;
  }

//-----------------------------------------------------------------
public function obtenerTargetPersona($idPersona,$tipoTarget){
	$consulta='select * from personatarget where personatarget.idPersona='.$idPersona.' and personatarget.tipoTarget='.$tipoTarget;
	$datos=$this->db->query($consulta)->result();
	return $datos;

 }
//-----------------------------------------------------------------
public function guardarTargetPersona($datos){
  $this->db->insert('personatarget',$datos);
 }

//-----------------------------------------------------------------
public function obtenerTipoTarget($idTarget){
	$consulta='select tipoTarget from target where idTarget='.$idTarget;
	$datos=$this->db->query($consulta)->result();
	return $datos;	
  }
//-----------------------------------------------------------------
private function getterDatos($consulta){
   $this->datos=$this->db->query($consulta)->result();	   	
   return $this->datos; 
  }
 //-----------------------------------------------------------------
 private function setterDatos($consulta){
 	$this->db->insert('persona',$consulta);
 	$last=$this->db->insert_id();

     return  $last;

 }
 //-----------------------------------------------------------------
  private function updateDatos($consulta,$id){
  	$this->db->where('idPersona',$id);
 	$this->db->update('persona',$consulta);

 }
 //-----------------------------------------------------------------
  private function nuevoPersonaDP($consulta){
 	$this->db->insert('personadepartamentopuesto',$consulta);
 	$last=$this->db->insert_id();
     return  $last;

 }
 //-----------------------------------------------------------------
   private function updatePersonaDP($consulta,$id){
 	
  	$this->db->where('idPersona',$id);
 	$this->db->update('personadepartamentopuesto',$consulta);

 }
 //-----------------------------------------------------------------
 public function nuevoPermisoVend($consulta){$this->db->insert('vend_permisos',$consulta);}
//-----------------------------------------------------------------
public function actualizaPermisoVend($consulta){
    $ramo=$consulta['ramo'];
    $idpersona=$consulta['idpersona'];
    unset($consulta['ramo']);
    unset($consulta['idpersona']);
 	$this->db->where('ramo',$ramo);
 	$this->db->where('idpersona',$idpersona);
 	$this->db->update('vend_permisos',$consulta);
 } 	
//-----------------------------------------------------------------
public function obtenerLayout($idPersona){
  $layout=$this->obtenerTipoAgenteParaLaoyut($idPersona);
  $consulta="select * from personadocumento where layoutPD=".$layout;
  $datos=$this->db->query($consulta)->result();
  return $datos;
  }
 //-----------------------------------------------------------------
 
public function verificarCantidadObligatorios($idPersona){
  $layout=$this->obtenerTipoAgenteParaLaoyut($idPersona);
  $consulta='select (count(idPersonaDocumento)) as cantidad from personadocumento where personadocumento.obligatorioPD="SI" and personadocumento.layoutPD='.$layout;
  $cantObligatorios=$this->db->query($consulta)->result();
  $consulta='select (count(personadocumento.idPersonaDocumento)) as cantidad from personadocumento inner join personadocumentoguardado on personadocumentoguardado.idPersonaDocumento=personadocumento.idPersonaDocumento where personadocumento.obligatorioPD="SI" and personadocumento.layoutPD='.$layout.' and personadocumentoguardado.idPersona='.$idPersona;

  $cantObligatoriosSubidos=$this->db->query($consulta)->result();
  if($cantObligatorios[0]->cantidad==$cantObligatoriosSubidos[0]->cantidad){return 1;}else{return 0;}
 }

//-----------------------------------------------------------------
public function obtenerDocumentosSubidosLaoyut($idPersona){
   $layout=$this->obtenerTipoAgenteParaLaoyut($idPersona);
   $consulta="select personadocumentoguardado.idPersonaDocumento,personadocumentoguardado.extensionPDG,personadocumento.descripcionPD from personadocumentoguardado left join personadocumento on personadocumento.idPersonaDocumento=personadocumentoguardado.idPersonaDocumento where personadocumentoguardado.idPersona=".$idPersona." and personadocumentoguardado.idLayout=".$layout;
   $datos=$this->db->query($consulta)->result();
   return $datos;
 }

//-----------------------------------------------------------------
private function obtenerTipoAgenteParaLaoyut($idPersona){
	$consulta="select personaTipoAgente from persona where idPersona=".$idPersona;
 	$tipoAgente=$this->db->query($consulta)->result()['0']->personaTipoAgente;
 	//  $datos="";
    //switch ($tipoAgente) 
    //{    
    // 	case 1:$layout=1;break;  /*PARA AGENTE EN FORMACION*/  	
    //	case 2:$layout=2;break;  /*PARA AGENTE CONSOLIDADO*/
    //	case 3:$layout=3;break;  /*PARA AGENTE INDEPENDIENTE*/
    //	case 4:$layout=4;break;  /*PARA AGENTE INDEPENDIENTE*/
    //}
    return $tipoAgente;

 }


//-----------------------------------------------------------------
public function obtenerBancos(){
   $consulta="select * from bancos where verBancos='SI'";
   $datos=$this->db->query($consulta)->result();
   return $datos;
 }
//-----------------------------------------------------------------
public function obtenerNombreBanco($idBanco){
  $consulta="select descripcionBancos from bancos where verBancos='SI' and idBanco=".$idBanco;
  $datos=$this->db->query($consulta)->result()[0]->descripcionBancos;
  return $datos;
 }
//-----------------------------------------------------------------
public function agentesEnEstadoCapsys($email){
  /*$consulta='select (concat(nombres," ",apellidoPaterno," ",apellidoMaterno)) as nombres from persona where tipoPersona=4 and userEmailCreacion="'.$email.'"';*/
 if($this->tank_auth->get_usermail()=='AUDITORINTERNO@AGENTECAPITAL.COM' ||
$this->tank_auth->get_usermail()=='DIRECTORGENERAL@AGENTECAPITAL.COM' || $this->tank_auth->get_usermail()=='SISTEMAS@ASESORESCAPITAL.COM'){
  $consulta='select persona.idPersona,persona.nombres,persona.apellidoPaterno,persona.apellidoMaterno,
 (   CASE
        WHEN persona.tipoPersona = 3 THEN "(Agente temporal)"
        WHEN persona.tipoPersona = 4 THEN "(En proceso V3...)"
          WHEN persona.tipoPersona = 1 THEN "(persona)"
    END) as EstadoV3,persona.userEmailCreacion

from persona
inner join users on users.IDVend=(persona.idPersona*1000)
union
select persona.idPersona,persona.nombres,persona.apellidoPaterno,persona.apellidoMaterno,
 (   CASE
        WHEN persona.tipoPersona = 4 THEN "(En proceso V3...)"
    END) as EstadoV3,persona.userEmailCreacion

from persona
inner join users on users.idPersona=(persona.idPersona)
where persona.tipoPersona=4 and users.activated=1 and users.banned=0
order by userEmailCreacion,EstadoV3 desc';}
else{
	$consulta='select persona.idPersona,persona.nombres,persona.apellidoPaterno,persona.apellidoMaterno,
 (   CASE
        WHEN persona.tipoPersona = 3 THEN "(Agente temporal)"
        WHEN persona.tipoPersona = 4 THEN "(En proceso V3...)"
        WHEN persona.tipoPersona = 1 THEN "(persona)"
    END) as EstadoV3,persona.userEmailCreacion

from persona
inner join users on users.IDVend=(persona.idPersona*1000)
where persona.userEmailCreacion="'.$email.'" union
select persona.idPersona,persona.nombres,persona.apellidoPaterno,persona.apellidoMaterno,
 (   CASE
        WHEN persona.tipoPersona = 4 THEN "(En proceso V3...)"
    END) as EstadoV3,persona.userEmailCreacion

from persona
inner join users on users.idPersona=(persona.idPersona) where persona.tipoPersona=4 and users.activated=1 and users.banned=0 and persona.userEmailCreacion="'.$email.'" order by userEmailCreacion,EstadoV3 desc';
}
  $datos=$this->db->query($consulta)->result();
  return $datos;	

 }
//-----------------------------------------------------------------
public function obtenerNombrePersona($idPersona){
   $consulta='select (concat(nombres," ",apellidoPaterno," ",apellidoMaterno)) as nombres from persona where idPersona='.$idPersona;
  
   $datos=$this->db->query($consulta)->result()[0]->nombres;
   return $datos;		
 }
//-----------------------------------------------------------------
public function obtenerUsuarioCreacion($idPersona){
   $consulta='select userEmailCreacion from persona where idPersona='.$idPersona;
   $datos=$this->db->query($consulta)->result()[0]->userEmailCreacion;
   return $datos;		
 }

//-----------------------------------------------------------------
public function obtenerIdUser($idPersona){
  $consulta='select users.id from users where users.idPersona='.$idPersona;

  $datos=$this->db->query($consulta)->result()[0]->id;
  return $datos;
 }

//-----------------------------------------------------------------
public function actualizarDatosEmpresa($idUser,$datos,$idPersona){

   $datos['passWordVisible']=strtoupper($datos['passWordVisible']);
   $datos['email']=strtoupper($datos['email']);

   $datos['username']=$datos['email'];
 if($this->verficaExistenciaIDVend($datos['IDVend'])<1)
 {

 	   $datos['IDVend']=$datos['IDVend'];
 	   $datosMiinfo['IDVend']=$datos['IDVend'];
 	   $catalog_vendedores['IDVend']=$datos['IDVend'];	
 	   $persona['IDVend']=$datos['IDVend'];	
 	    /*===========ACTUALIZA CAMPOS DE catalog_vendedores============*/
  $this->db->where('idPersona',$idPersona);
   $this->db->update('catalog_vendedores',$persona);
   /*================ACTUALIZA CAMPOS persona========================*/
     $this->db->where('idPersona',$idPersona);
   $this->db->update('persona',$catalog_vendedores);

 }else{unset($datos['IDVend']);}

  /*==========ACTUALIZA CAMPOS DE USER===========*/   
   $this->db->where('idPersona',$idPersona);
   $this->db->update('users',$datos);
  /*==========ACTUALIZA CAMPOS DE user_miinfo===========*/ 
      $datosMiinfo['emailUser']=$datos['email'];
   $this->db->where('idPersona',$idPersona);
   $this->db->update('user_miInfo',$datosMiinfo);
   /*==========ACTUALIZA CAMPOS DE vend_permisos===========*/ 
        $datosVendPermisos['emailUser']=$datos['email'];
     $this->db->where('idPersona',$idPersona);
   $this->db->update('vend_permisos', $datosVendPermisos);
 $this->manejarBanner($idPersona,$datos['banned']);
  }

//-----------------------------------------------------------------
public function obtenerDatosUsers($idPersona){
  $consulta="select email,passwordVisible,banned,UsuarioCarCapital,CodeAuthUserPersonaSicas,name_complete from users where idPersona=".$idPersona;
  $datos=$this->db->query($consulta);
  return $datos->result()[0];

 }
//--------------------------------------------------------------------


public function obtenerDatosMiInfo($idPersona){
  $consulta="select certificacion,certificacionAutos,certificacionGmm,certificacionVida,certificacionDanos,certificacionFianzas,IDValida from user_miInfo where idPersona=".$idPersona;
  $datos=$this->db->query($consulta);
  return $datos->result()[0];

 }
//--------------------------------------------------------------------
public function obtenerVendedoresActivos(){
 $consulta='select IDVend,NombreCompleto from catalog_vendedores where Status=0 and idPersona is not null order by NombreCompleto';
  $datos=$this->db->query($consulta);
  return $datos->result();	
}



//--------------------------------------------------------------------
public function obtenerDatosCatalogoVendedores($idPersona,$campos){
/*=====================NOS PROPORCIONA DATOS DE LA TABLA catalog_vendedores=========================*/
/*$campos ES UN STRING CON EL NOMBRE DELOS CAMPOS SEPARADOS POR COMA*/
  
  $comprobar='select * from catalog_vendedores where idPersona='.$idPersona;
  $rows = $this->db->query($comprobar)->result();
  if(count($rows)==0)
  {
  	
  	$persona=$this->db->query('select * from persona p left join users u on u.idPersona=p.idPersona where p.idPersona='.$idPersona)->result()[0];
  	//
  	$stastus=0;
  	$idVend=0;
  	$txtStatus='ACTIVO';
  	if($persona->IDVend==0){$idVend=$idPersona*1000;}
  	else{$idVend=$persona->IDVend;}
  	if($persona->banned==1){$stastus=1;$txtStatus="INACTIVO";}
  	$insert['NombreCompleto']=$persona->apellidoPaterno.' '.$persona->apellidoMaterno.' '.$persona->nombres;
  	$insert['Nombre']=$persona->nombres;
  	$insert['Status']=$stastus;
  	$insert['Status_TXT']=$txtStatus;
  	$insert['IDDespacho']=$persona->id_catalog_sucursales;
  	$insert['apellidoP']=$persona->apellidoPaterno;
  	$insert['apellidoM']=$persona->apellidoMaterno;
  	$insert['IDVend']=$idVend;
  	$insert['IDGerencia']=3;
  	$insert['DespNombre']='MERIDA';
  	$insert['idCont']=$persona->idContactoSicas;
  	$insert['idPersona']=$idPersona;

    $this->db->insert('catalog_vendedores',$insert);	
  	
  
  }  
  $consulta='select '.$campos.' from catalog_vendedores where idPersona='.$idPersona;  
  $datos=$this->db->query($consulta);    
  return $datos->result()[0];	
}
//--------------------------------------------------------------------
public function obtenerDatosUsuarios($idPersona,$campos){
/*=====================NOS PROPORCIONA DATOS DE LA TABLA users=========================*/
  $consulta='select '.$campos.' from users where idPersona='.$idPersona;
  $datos=$this->db->query($consulta);
  return $datos->result()[0];	
}
//--------------------------------------------------------------------

//---------------------------------------------------------------------
public function manejarBanner($idPersona,$valor){
if($idPersona>0){
if($valor==1){
$actualizar['banned']=1;
$actualizar['idTipoUser']=12;
$actualizar['activated']=0;
$actVendor['Status']=1;
$actVendor['Status_TXT']="INACTIVO";

}else{
$actualizar['banned']=0;
$actualizar['idTipoUser']=6;
$actualizar['activated']=1;
$actVendor['Status']=0;
$actVendor['Status_TXT']="ACTIVO";	
}
$this->db->where('idPersona',$idPersona);
$this->db->update('users',$actualizar);	
$this->db->where('idPersona',$idPersona);
$this->db->update('catalog_vendedores',$actVendor);
}
}

//--------------------------------------------------------------------
function verficaExistenciaIDVend($valor){
	$consulta="select (count(IDVend)) as cantidad from catalog_vendedores where IDVend=".$valor;
	return($this->db->query($consulta)->result()[0]->cantidad);

}
//--------------------------------------------------------------------
function obtenerCatalogoHonorarios(){
	$consulta='select * from catalog_vendhonorarios';
		$datos=$this->db->query($consulta)->result();
	 return $datos;	
}
//--------------------------------------------------------------------
function obtenerPuestos(){
	$consulta='select idPuesto,personaPuesto from personapuesto where idPuesto>1 and statusPuesto=1 and idPersona=0';
	return $this->db->query($consulta)->result();
}
//--------------------------------------------------------------------
public function obtenerTipoPersona($idPersona){
	$consulta="select tipoPersona from persona where idPersona=".$idPersona;

	return $this->db->query($consulta)->result()[0]->tipoPersona;
}
//--------------------------------------------------------------------
public function obtenerCatalogoTipoPersona(){

return $this->db->query('select * from personatipopersona where id=1 or id=3 or id=5  order by id desc')->result();
}
//--------------------------------------------------------------------
public function obtenerVendActivos($array=null){
	/* ES SIMILAR A obtenerVendedoresActivos*/
	if(isset($array['grupos']))
	{$respuesta=array();
         $consultaAgentes='select distinct(p.idpersonarankingagente) from persona p where p.tipoPersona=3 and p.idpersonarankingagente!="" order by p.idpersonarankingagente';
   $agentes=$this->db->query($consultaAgentes)->result();  
   foreach ($agentes as $key => $value) 
   {
  	if($value->idpersonarankingagente!='' and $value->idpersonarankingagente!=null)
  	{	
  	     $consulta='select p.idpersonarankingagente,p.nombres,p.idPersona,p.personaTipoAgente,p.apellidoPaterno,p.apellidoMaterno,p.celPersonal,(p.celPersonal) as CelularSMS,
u.IDVend,u.email,(u.email) as EMail1,u.id,u.banned,u.idTipoUser,u.idTipoUserSMSmail,(concat(p.apellidoPaterno," ",p.apellidoMaterno," ",p.nombres)) as username,"AGENTES" as TIPO from persona p  left join users u on u.idPersona=p.idPersona where p.tipoPersona=3 and u.banned=0 and u.activated=1 and p.esAgenteColaborador=0 and p.idpersonarankingagente="'.$value->idpersonarankingagente.'"';
        $agentesRanking=$this->db->query($consulta)->result_array();
	
      $datos['Name']=$value->idpersonarankingagente;
      $datos['tipoPersona']='Vendedor';
      $datos['Data']= $agentesRanking;
      $datos['IDVend']=0;  
      $datos['IdUser']=5;
      $datos['idTipoUser']=0;
      array_push($respuesta, $datos);     
    }

  }
return $respuesta;  
	}
	else
	{
	$consulta="select persona.idPersona,persona.nombres,(if((concat(persona.nombres,' ',persona.apellidoPaterno,' ',persona.apellidoMaterno))is null,
persona.nombres,(concat(persona.nombres,' ',persona.apellidoPaterno,' ',persona.apellidoMaterno)))) as nombre, 
personatipoagente.personaTipoAgente,persona.idpersonarankingagente, 'activo' as lealtad,persona.id_catalog_canales,cc.nombreTitulo,users.IDVend,(if((concat(persona.nombres,' ',persona.apellidoPaterno,' ',persona.apellidoMaterno))is null,
persona.nombres,concat(persona.nombres,' ',persona.apellidoPaterno,' ',persona.apellidoMaterno))) as name_complete
from persona
left join users on users.idPersona=persona.idPersona
left join personatipoagente on personatipoagente.idPersonaTipoAgente=persona.personaTipoAgente
left join catalog_canales cc on cc.IdCanal=persona.id_catalog_canales
where persona.tipoPersona=3 and users.banned=0 and users.activated=1 order by nombre";
$datos=$this->db->query($consulta)->result();
return $datos;
   }

}
//--------------------------------------------------------------------
public function obtenerIdVendedor($idPersona){
	$consulta="select IDVend from persona where idPersona=".$idPersona;
	$datos=$this->db->query($consulta)->result();
	return $datos;
}
//--------------------------------------------------------------------
public function devuelveCoordinadoresVentas(){
	$datos="";
  $usuario=$this->tank_auth->get_usermail();
   if($usuario=='AUDITORINTERNO@AGENTECAPITAL.COM' ||
  $usuario=='DIRECTORGENERAL@AGENTECAPITAL.COM' || $usuario=='SISTEMAS@ASESORESCAPITAL.COM' || $usuario=="SUBGERENTE@CAPCAPITAL.COM.MX" || $usuario=="GERENTE@CAPCAPITAL.COM.MX" || $usuario=='MARKETING@AGENTECAPITAL.COM' || $usuario=="GERENTEOPERATIVO@AGENTECAPITAL.COM")
   {
     $consulta='select p.idPersona,p.nombres,p.apellidoPaterno,p.apellidoMaterno,u.email, u.id from persona p left join users u on  u.idPersona=p.idPersona where u.email="COORDINADOR@ASESORESCAPITAL.COM" || u.email="COORDINADOR@CAPCAPITAL.COM.MX" || u.email="COORDINADORINSTITUCIONAL@AGENTECAPITAL.COM" || u.email="COORDINADORCOMERCIAL@CAPCAPITAL.COM.MX" || u.email="GERENTE@FIANZASCAPITAL.COM "';

  }
  else{
  	    $consulta='select p.idPersona,p.nombres,p.apellidoPaterno,p.apellidoMaterno,u.email from persona p left join users u on  u.idPersona=p.idPersona where u.email="'.$usuario.'"';
      }

$consultaCoordinador='select * from coordinadoreshijos where idPersonaCoordinador='.$this->tank_auth->get_idPersona();
$coordinadorPadre=$this->db->query($consultaCoordinador)->result();
$seleccionCoordinador='';
foreach ($coordinadorPadre as  $value) {$seleccionCoordinador.=" || u.email='".$value->emailHijo."'";
}

  	    $consulta='select p.idPersona,p.nombres,p.apellidoPaterno,p.apellidoMaterno,u.email from persona p left join users u on  u.idPersona=p.idPersona where u.email="'.$usuario.'" '.$seleccionCoordinador;


  $datos=$this->db->query($consulta)->result();
  return $datos;  
}
//--------------------------------------------------------------------
public function obtVendAct(){
	$coordinador=$this->devuelveCoordinadoresVentas();


	$condicionAdicional="";
	if(count($coordinador)==1){$condicionAdicional=" and userEmailCreacion='".$coordinador[0]->email."'";}
 
$consulta="select persona.idPersona,(if(persona.nombres is null,'',persona.nombres)) as nombre,(if(persona.apellidoPaterno is null,'',persona.apellidoPaterno)) as apellidoPaterno,
(if(persona.apellidoMaterno is null,'',persona.apellidoMaterno)) as apellidoMaterno, personatipoagente.personaTipoAgente, 
(if(persona.idpersonarankingagente is null,'',persona.idpersonarankingagente)) as ranking,(if(catalog_sucursales.NombreSucursal is null,'',catalog_sucursales.NombreSucursal)) as sucursal,
catalog_canales.nombreTitulo,(cast(persona.fecAltaSistemPersona as date)) as fecAltaSistemPersona,catalog_vendedores.promotoriasActivadasCP,users.id,users.IdSucursal,users.name_complete,users.idVend,users.celularSMS,persona.fecFinCedulaPersona,persona.userEmailCreacion,um.IDValida,users.passwordVisible,users.email,persona.telCasa,persona.celPersonal,(if(users.activated=1,'activo','no activo')) as status,cvh.comisionCVH
from persona 
left join users on users.idPersona=persona.idPersona
left join personatipoagente on personatipoagente.idPersonaTipoAgente=persona.personaTipoAgente
left join catalog_sucursales on catalog_sucursales.IdSucursal=persona.id_catalog_sucursales
left join catalog_canales on catalog_canales.IdCanal=persona.id_catalog_canales
left join catalog_vendedores on catalog_vendedores.idPersona=persona.idPersona
left join catalog_vendhonorarios cvh on cvh.idCVH=catalog_vendedores.honorariosCVH
left join user_miInfo um on um.idPersona=persona.idPersona
where persona.tipoPersona=3 and users.banned=0 and users.activated=1 ".$condicionAdicional;

$datos=$this->db->query($consulta)->result();
$cantAgentes=count($datos);
 $catalogo=$this->obtenerCatalogPromotorias();


  for($i=0;$i<$cantAgentes;$i++)
  {
      foreach ($catalogo as $value)
       {   
        $promotoria=(string)$value->Promotoria;
     	$datos[$i]->$promotoria="";
       }
     if($datos[$i]->promotoriasActivadasCP!=""){
     	$idPromotoria=explode(";",$datos[$i]->promotoriasActivadasCP);
     	foreach ($idPromotoria as $id) {
        if($id!=""){
     		$info=$this->obtenerDatoCatalogoPromotoria($id);
     		$nombre=(string)$info[0]->Promotoria;
     		$datos[$i]->$nombre="SI";	
        }     	
     		
     	}
      	
      }

   }	

return $datos;	
}
//--------------------------------------------------------------------
function obtenerVendedoresPorTipoAgente($arrayTipoAgente){
/*OBTENER LOS VENDEDORES DE ACUERDO AL TIPO DE AGENTE QUE SON AGENTE EN FORMACION, AGENTE CONSOLIDADO,PROMOVENDEDOR*/
/*RECIBE UN ARREGLO DE ACUERDO A AL ID DE SU TIPO DE AGENTE*/
/*EJEMPLO DEL ARREGLO A PASAR $arreglo=[2,3];*/
$cant=count($arrayTipoAgente);
$condicion="";
$condicion="personaTipoAgente=".$arrayTipoAgente[0];
for($i=1;$i<$cant;$i++){

 $condicion= $condicion." or personaTipoAgente=".$arrayTipoAgente[$i];
}
$consulta="select p.idPersona,p.nombres,p.apellidoPaterno,p.apellidoMaterno,u.email from persona p
left join users u on u.idPersona=p.idPersona where ".$condicion;

return $this->db->query($consulta)->result();


}
//--------------------------------------------------------
//Dennis [2021-06-10]
function obtenerIdPersonaPorEmail($email){

	$array = array();

	$this->db->select("idPersona");
	$this->db->where("email", $email);
	$query = $this->db->get("users");

	if($query->num_rows()>0){
		$array = $query->row();
	}

	return $array;
}
//--------------------------------------------------------------------
public function obtenerPersonas($email,$tipoPersona){
/*=================PARA LLENAR EL COMBO DE PERSONAS QUE PUEDE VER CADA CREADOR================================*/
   $filtro="";
   $idP = $this->obtenerIdPersonaPorEmail($email); //Nueva implementación obtener el idPersona por medio del correo.

 if(!isset($_POST['quitarFiltroActivo'])){$filtro=" where users.activated=1 and users.banned=0 and persona.bajaPersona=0";}
 else{$filtro=" where  persona.bajaPersona=0 ";}
if($this->tank_auth->get_usermail()=='DIRECTORGENERAL@AGENTECAPITAL.COM' || $this->tank_auth->get_usermail()=='SISTEMAS@ASESORESCAPITAL.COM' || $this->tank_auth->get_usermail()=='AUDITORINTERNO@AGENTECAPITAL.COM' || $this->emailUser=="SUBGERENTE@CAPCAPITAL.COM.MX" || $this->emailUser=="GERENTE@CAPCAPITAL.COM.MX" || $this->emailUser=="MARKETING@AGENTECAPITAL.COM" || $this->emailUser=="GERENTEOPERATIVO@AGENTECAPITAL.COM" ||  $this->tank_auth->get_usermail()=="ASISTENTEDIRECCION@AGENTECAPITAL.COM")  {
	/*$consulta="select persona.idPersona,persona.apellidoPaterno,persona.nombres,(trim(persona.userEmailCreacion)) as email,persona.apellidoMaterno 
from persona 
left join users on users.idPersona=persona.idPersona
 order by persona.nombres";*/


 $consulta="select persona.idPersona, persona.nombres,(if(persona.apellidoPaterno is null,'',persona.apellidoPaterno)) as apellidoPaterno,
(if(persona.apellidoMaterno is null,'',persona.apellidoMaterno)) as apellidoMaterno, personatipoagente.personaTipoAgente, 
(if(persona.idpersonarankingagente is null,'',persona.idpersonarankingagente)) as ranking,(if(catalog_sucursales.NombreSucursal is null,'',catalog_sucursales.NombreSucursal)) as sucursal,
catalog_canales.nombreTitulo,(cast(persona.fecAltaSistemPersona as date)) as fecAltaSistemPersona,catalog_vendedores.promotoriasActivadasCP,users.id,users.IdSucursal,users.name_complete,users.email,users.idVend,users.celularSMS,persona.userEmailCreacion,users.activated,users.UsuarioCarCapital, persona.esAgenteNuevo,persona.tipoPersona,persona.esAgenteColaborador,colaboradorarea.colaboradorArea from colaboradorarea, persona 
left join users on users.idPersona=persona.idPersona
left join personatipoagente on personatipoagente.idPersonaTipoAgente=persona.personaTipoAgente
left join catalog_sucursales on catalog_sucursales.IdSucursal=persona.id_catalog_sucursales
left join catalog_canales on catalog_canales.IdCanal=persona.id_catalog_canales
left join catalog_vendedores on catalog_vendedores.idPersona=persona.idPersona where colaboradorarea.idColaboradorArea=persona.idColaboradorArea";
$consulta=$consulta.$filtro;

}
else{	
/*if($this->tank_auth->get_usermail()=='AUDITORINTERNO@AGENTECAPITAL.COM'){
$consulta="select idPersona,apellidoPaterno,nombres,concat(apellidoMaterno,'-Creado por:',userEmailCreacion) as apellidoMaterno from persona where tipoPersona=4 order by nombres";}*/
    
	/*$consulta="select idPersona,apellidoPaterno,nombres,apellidoMaterno from persona where  userEmailCreacion='".$email."' order by nombres";*/
if($email=="COORDINADOR@FIANZASCAPITAL.COM"){$email="GERENTE@FIANZASCAPITAL.COM";}
	$consulta="select persona.idPersona,persona.nombres,(if(persona.apellidoPaterno is null,'',persona.apellidoPaterno)) as apellidoPaterno,
(if(persona.apellidoMaterno is null,'',persona.apellidoMaterno)) as apellidoMaterno, personatipoagente.personaTipoAgente, 
(if(persona.idpersonarankingagente is null,'',persona.idpersonarankingagente)) as ranking,(if(catalog_sucursales.NombreSucursal is null,'',catalog_sucursales.NombreSucursal)) as sucursal,
catalog_canales.nombreTitulo,(cast(persona.fecAltaSistemPersona as date)) as fecAltaSistemPersona,catalog_vendedores.promotoriasActivadasCP,users.id,users.IdSucursal,users.name_complete,users.email,users.idVend,users.celularSMS,persona.userEmailCreacion,users.activated,persona.tipoPersona,persona.esAgenteColaborador,
colaboradorarea.colaboradorArea from colaboradorarea,  persona 
left join users on users.idPersona=persona.idPersona
left join personatipoagente on personatipoagente.idPersonaTipoAgente=persona.personaTipoAgente
left join catalog_sucursales on catalog_sucursales.IdSucursal=persona.id_catalog_sucursales
left join catalog_canales on catalog_canales.IdCanal=persona.id_catalog_canales
left join catalog_vendedores on catalog_vendedores.idPersona=persona.idPersona
where colaboradorarea.idColaboradorArea=persona.idColaboradorArea";
$consulta=$consulta.$filtro;
if($filtro==""){$consulta=$consulta." where  userEmailCreacion='".$email."' and persona.bajaPersona=0";}
else{$consulta=$consulta." and  userEmailCreacion='".$email."'  ";}
    
   }  

   $consulta=$consulta." order by nombres";
   $consultaCoordinador='select * from coordinadoreshijos where idPersonaCoordinador='.$idP->idPersona; //Nueva implementación.
//$consultaCoordinador='select * from coordinadoreshijos where idPersonaCoordinador='.$this->tank_auth->get_idPersona();
$coordinadorPadre=$this->db->query($consultaCoordinador)->result();
$seleccionCoordinador='';
foreach ($coordinadorPadre as  $value) {$seleccionCoordinador.=" || userEmailCreacion='".$value->emailHijo."'";
}

if(!isset($_POST['quitarFiltroActivo'])){$filtrox=" and (users.activated=1 and users.banned=0 and persona.bajaPersona=0)";}
 //else{$filtrox=" and (persona.bajaPersona=0)";}
 else{$filtrox=" and (persona.bajaPersona=0) and persona.idPersona not in (select zz.idPersona from capsysV3.list_of_users_to_delete zz where reallyDeleted = 0)";} //Dennis Castillo [2022-06-14]
$consultax="select pp.personaPuesto,ca.colaboradorArea,persona.idPersona,persona.nombres,(if(persona.apellidoPaterno is null,'',persona.apellidoPaterno)) as apellidoPaterno,
(if(persona.apellidoMaterno is null,'',persona.apellidoMaterno)) as apellidoMaterno, personatipoagente.personaTipoAgente, 
(if(persona.idpersonarankingagente is null,'',persona.idpersonarankingagente)) as ranking,(if(catalog_sucursales.NombreSucursal is null,'',catalog_sucursales.NombreSucursal)) as sucursal,
catalog_canales.nombreTitulo,(cast(persona.fecAltaSistemPersona as date)) as fecAltaSistemPersona,catalog_vendedores.promotoriasActivadasCP,users.id,users.IdSucursal,users.name_complete,users.email,users.idVend,users.celularSMS,persona.userEmailCreacion,users.activated,users.UsuarioCarCapital,persona.esAgenteNuevo,persona.tipoPersona,persona.esAgenteColaborador
,colaboradorarea.colaboradorArea from colaboradorarea, persona 
left join users on users.idPersona=persona.idPersona
left join personatipoagente on personatipoagente.idPersonaTipoAgente=persona.personaTipoAgente
left join catalog_sucursales on catalog_sucursales.IdSucursal=persona.id_catalog_sucursales
left join catalog_canales on catalog_canales.IdCanal=persona.id_catalog_canales
left join catalog_vendedores on catalog_vendedores.idPersona=persona.idPersona
left join personapuesto pp on pp.idPersona=persona.idPersona 
left join colaboradorarea  ca on ca.idColaboradorArea=pp.idColaboradorArea
where colaboradorarea.idColaboradorArea=persona.idColaboradorArea AND (userEmailCreacion='".$email."'".$seleccionCoordinador.")".$filtrox;
//and idPersona not in (select idPersona from list_of_users_to_delete where reallyDeleted = 0)

	$datos=$this->db->query($consultax)->result();

 foreach ($datos as $key => $value) 
 {
 	if($value->tipoPersona==1)
 	{
       $value->Name=$value->colaboradorArea;
 	}
 	else
 	{
 	 if($value->ranking==''){$value->Name='Sin Clasificacion';}
     else{$value->Name=$value->ranking;} 
      
 	}
 }
 
	return $datos;	

}
//-----------------------------------------------------------------

//-----------------------------------------------------------------
function devuelveAgentesPorCoordinadorActivos($idPersona){

   $respuesta=$this->personamodelo->obtenerDatosUsers($idPersona);

  /* $consulta='select persona.idPersona,persona.IDVend,persona.nombres,persona.apellidoPaterno,
persona.apellidoMaterno,users.email,persona.idpersonarankingagente,
cs.NombreSucursal,cc.nombreTitulo,pta.personaTipoAgente
from persona  
left join users on users.idPersona=persona.idPersona 
left join catalog_sucursales cs on cs.IdSucursal=persona.id_catalog_sucursales
left join catalog_canales cc on cc.IdCanal=persona.id_catalog_canales
left join personatipoagente pta on pta.idPersonaTipoAgente=persona.personaTipoAgente
where persona.tipoPersona=3  and users.banned=0 and users.activated=1 and (persona.idpersonarankingagente="BRONCE" || persona.idpersonarankingagente="ORO" ) 
and persona.userEmailCreacion="'.$respuesta->email.'"';*/
$email=$respuesta->email;
	if($respuesta->email=="COORDINADOR@FIANZASCAPITAL.COM" || $respuesta->email=="COORDINADORCOMERCIAL@FIANZASCAPITAL.COM"){$email='GERENTE@FIANZASCAPITAL.COM" || persona.userEmailCreacion="'.$respuesta->email.' ';}

/*
 $consulta='select persona.idPersona,persona.IDVend,persona.nombres,persona.apellidoPaterno,
persona.apellidoMaterno,users.email,persona.idpersonarankingagente,
cs.NombreSucursal,(cs.NombreSucursal) as sucursal,cc.nombreTitulo,pta.personaTipoAgente,(if(persona.nombres is null,"",persona.nombres)) as nombre 
from persona  
left join users on users.idPersona=persona.idPersona 
left join catalog_sucursales cs on cs.IdSucursal=persona.id_catalog_sucursales
left join catalog_canales cc on cc.IdCanal=persona.id_catalog_canales
left join personatipoagente pta on pta.idPersonaTipoAgente=persona.personaTipoAgente
where (persona.tipoPersona=3)  and (users.banned=0) and (users.activated=1)  
and (persona.userEmailCreacion="'.$email.'") order by persona.nombres ASC';*/

    //Modificacion MJ 12-05-2021
    if($this->tank_auth->get_usermail()=="COORDINADORINSTITUCIONAL@AGENTECAPITAL.COM"){
        $consulta='select persona.idPersona,persona.IDVend,persona.nombres,persona.apellidoPaterno,
        persona.apellidoMaterno,users.email,persona.idpersonarankingagente,
        cs.NombreSucursal,(cs.NombreSucursal) as sucursal,cc.nombreTitulo,pta.personaTipoAgente,(if(persona.nombres is null,"",persona.nombres)) as nombre
        from persona
        left join users on users.idPersona=persona.idPersona
        left join catalog_sucursales cs on cs.IdSucursal=persona.id_catalog_sucursales
        left join catalog_canales cc on cc.IdCanal=persona.id_catalog_canales
        left join personatipoagente pta on pta.idPersonaTipoAgente=persona.personaTipoAgente
        where (persona.tipoPersona=3)  and (users.banned=0) and (users.activated=1) and (persona.userEmailCreacion="COORDINADORINSTITUCIONAL@AGENTECAPITAL.COM")
        or (persona.userEmailCreacion="COORDINADORCOMERCIAL@FIANZASCAPITAL.COM") order by persona.nombres ASC';
    }else{
         $consulta='select persona.idPersona,persona.IDVend,persona.nombres,persona.apellidoPaterno,
        persona.apellidoMaterno,users.email,persona.idpersonarankingagente,
        cs.NombreSucursal,(cs.NombreSucursal) as sucursal,cc.nombreTitulo,pta.personaTipoAgente,(if(persona.nombres is null,"",persona.nombres)) as nombre
        from persona
        left join users on users.idPersona=persona.idPersona
        left join catalog_sucursales cs on cs.IdSucursal=persona.id_catalog_sucursales
        left join catalog_canales cc on cc.IdCanal=persona.id_catalog_canales
        left join personatipoagente pta on pta.idPersonaTipoAgente=persona.personaTipoAgente
        where (persona.tipoPersona=3)  and (users.banned=0) and (users.activated=1)
        and (persona.userEmailCreacion="'.$email.'") order by persona.nombres ASC';
      }
    //Fin Modificacion
    
    
    
   $datos=$this->db->query($consulta)->result();

   return $datos;
}

//----------------------------------------------------------------------
function verificaExistenciaCorreos($email){
	$band=0;
	$consulta='select email from users where email="'.$email.'"';
	if(count($this->db->query($consulta)->result())>0){$band=1;}
   return $band;

}
//----------------------------------------------------------------------
public function buscaFotoPersonal($idPersona){
	/*BUSCA SI EXISTE LA FOTO QUE VA EN LsA CABECERA DEVUELVE LOS CAMPOS*/
     return ($this->db->query('select idPersonaImagen,extensionPersonaImagen,idPersona from personaimagen where tipoPersonaImagen=0 and idPersona='.$idPersona)->result());

	}
//---------------------------------------------------------------
public function obtenerIdPersona($IDVend){
 $consulta="select idPersona from users where IDVend=".$IDVend;
 $datos=$this->db->query($consulta)->result();

 return $datos;
}
//-----------------------------------------------------------------------
public function devolverModulosPermisosPersona($idPersona)
{
	$consulta="select pp.idPersonaPermiso,pp.nombrePersonaPermiso,pp.descripcionPermiso,tipoPermiso,modulo,controlador,funcion,vista from personapermiso pp ";
	 $modulos=$this->db->query($consulta)->result();
	 $consulta="select * from personapermisorelacion where idPersona=".$idPersona;


	$permisos=$this->db->query($consulta)->result();
	$respuesta;
	foreach ($modulos as  $value) {
	$value->permite=0;
	  foreach ($permisos as  $valuePermisos) {
	  		if($value->idPersonaPermiso ==$valuePermisos->idPersonaPermiso){
	  			$value->permite=1;
	  		}
	  	}	
	}
return $modulos;
}
//-----------------------------------------------------------------------

public function permisosPersona($vista)
{
	$consulta='select pp.idPersonaPermiso,pp.nombrePersonaPermiso,pp.value from personapermisorelacion ppr left join personapermiso pp on pp.idPersonaPermiso=ppr.idPersonaPermiso where ppr.idPersona='.$this->idPersona.' and pp.vista="'.$vista.'"';

	$respuesta=$this->db->query($consulta)->result();
	$permisos['default']="";
	$permisos['valor']=-1;
	foreach ($respuesta as  $value) {
		$permisos[$value->nombrePersonaPermiso]=$value->idPersonaPermiso;
		$permisos['value']=$value->value;
		$permisos['valor']=$value->value;
	}

	return $permisos;

}
//-----------------------------------------------------------------------
function personapermisorelacion($array){
	if(isset($array['idPersona']))
	{
		if($array['idPersonaPermiso']==-1)
		{
			/*BORRARA TODOS LOS PERMISOS DEL EMPLEADO*/
			$delete="delete from personapermisorelacion where idPersona=".$array['idPersona'];
			$this->db->query($delete);
		}
		else
		{
			if(isset($array['delete']))
			{
                $this->db->where('idPersona',$array['idPersona']);
                $this->db->where('idPersonaPermiso',$array['idPersonaPermiso']);
                $this->db->delete('personapermisorelacion');

			}
			else{$this->db->insert('personapermisorelacion',$array);}
		}
	}

}
//-----------------------------------------------------------------------
function obtenerEmpleados(){
	$consulta="select p.idPersona,u.email,p.nombres,p.apellidoPaterno,p.apellidoMaterno,p.esCoordinador from persona p left join users u on u.idPersona=p.idPersona where p.tipoPersona=1
	order by email";
	
	return $this->db->query($consulta)->result();

}
//-----------------------------------------------------------------------
function obtenerEmpleadosActivos(){
	$consulta="select p.idPersona,u.email,p.nombres,p.apellidoPaterno,p.apellidoMaterno from persona p left join users u on u.idPersona=p.idPersona where p.tipoPersona=1 and u.banned=0 and u.activated=1 order by p.apellidoPaterno desc";
	return $this->db->query($consulta)->result();

}
//-----------------------------------------------------------------------
function permisosCuentasContablesFacturas(){
/*PERMISOS DE LAS CUENTAS CONTABLES POR GERENTE PARE REALIZAR FACTURAS */

}
//-----------------------------------------------------------------------
function permiteemision($array){

	$datos	= array();//"";
     	if(isset($array['insert']))
     	{
     	  unset($array['insert']);
     	  if($array['idPersona']!=''){
          // $this->db->where('idPersona',$array['idPersona']);
            $this->db->insert('permiteEmision',$array);      
           }
           	
     	}
     	else
     	{
     	  if(isset($array['delete'])){
            $this->db->where('idPersona',$array['idPersona']);
            $this->db->delete('permiteEmision');
     	  }
     	  else{
          $this->db->where('idPersona',$array['idPersona']);
          $datos=$this->db->get('permiteEmision')->result();
          return $datos;
          }
     	}

}

//------------------------------------------------------------------------
public function persona($array){

$salida=0;$seguridad=0;$datos="";
  	do{
    if(isset($array['idPersona']) )
    {
     if($array['idPersona']==-1)
     {
     	unset($array['idPersona']);
     	unset($array['update']);
     	$this->db->insert('persona',$array);
     	$array['idPersona']=$this->db->insert_id();
     } 
     else
     {
     	if(isset($array['update']))
     	{
     	  unset($array['update']);
     	  if($array['idPersona']!=''){

          $this->db->where('idPersona',$array['idPersona']);
         $this->db->update('persona',$array);
      
           }else{$salida=1;}
           	
     	}
     	else
     	{
          $this->db->where('idPersona',$array['idPersona']);
          $datos=$this->db->get('persona')->result();
          $salida=1;
     	}
     }
    }
    else
    { 
    	//$where->db->where('Usuario',$this->tank_auth->get_usermail());
         $datos=$this->db->get('persona')->result();        
         $salida=1;
    }
    $seguridad++;
    if($seguridad>4){$salida=1;}

  }while($salida==0);
  return $datos;
}
//------------------------------------------------------------------------
function encriptarClave($array)
{ 
  $respuesta='';
  if(isset($array['dato']) && isset($array['llave']))
  {
   $consulta="select AES_ENCRYPT('".$array['dato']."','".$array['llave']."CAPITALSEGUROS') as encriptado";
   $respuesta=$this->db->query($consulta)->result()[0]->encriptado;
  }
  else{$respuesta="Se necesita un array con los valores dato y llave";}
  return $respuesta;
}
//--------------------------------------------------------------------------
function descriptaClave($array){
	$consulta='select (AES_DECRYPT(tarjetaNumeroEncriptado,"'.$folioActividad.'AC")) as numero,(AES_DECRYPT(tarjetaCodigoSeguridad,"'.$folioActividad.'AC"))  as codigo from personaTarjeta a where a.folioActividad="'.$folioActividad.'"';
	return $this->db->query($consulta)->result();
}

//--------------------------------------------------------------------------
function tarjetaPersona($array){


	$datos="";

     		if(isset($array['IDCli']))
     		{
     			if(isset($array['idPersonaTarjeta']))
     			{
     			 if($array['idPersonaTarjeta']==-1)
     			 { 
     			  $this->db->where('numeroTarjeta',$array['numeroTarjeta']);
     			  $this->db->where('codigoSeguridad',$array['codigoSeguridad']);
     			  $this->db->where('IDCli',$array['IDCli']);
     			  $this->db->where('tarjetaActiva',1);
     			 $tarjetaExistente= $this->db->get('personatarjeta')->result();
     			
     			  if((count($tarjetaExistente))==0)
     			   {
     	            unset($array['idPersonaTarjeta']);       
     	            if(isset($array['titularTarjeta'])){$array['titularTarjeta']=strtoupper($array['titularTarjeta']);} 
     	            if(isset($array['banco'])){$array['banco']=strtoupper($array['banco']);}   
                    $this->db->insert('personatarjeta',$array); 
                    return 1;
                   }
                   else
                   {
                   	return 0;
                   }
                  }                
     			
     	       else
     			 {
     			  if(isset($array['update']))
     			  {
                    unset($array['update']);
                    $this->db->where('codigoSeguridad',$array['codigoSeguridad']);
                    $this->db->where('numeroTarjeta',$array['numeroTarjeta']);
                    $this->db->where('idPersonaTarjeta',$array['idPersonaTarjeta']);
                    $this->db->update('personatarjeta',$array);
     			  }
     		  	}
               }     		   
     			 else
     			 {
     			  $consulta='select (AES_DECRYPT(pt.numeroTarjeta,"'.$array['IDCli'].'CAPITALSEGUROS")) as numeroTarjeta,(AES_DECRYPT(pt.codigoSeguridad,"'.$array['IDCli'].'CAPITALSEGUROS")) as codigoSeguridad,pt.vencimiento,pt.anio,pt.titularTarjeta,pt.tipoTarjeta,pt.banco,pt.tipoPago,idPersonaTarjeta,IDCli  from personatarjeta pt where tarjetaActiva=1 and IDCli='.$array['IDCli'];     			    
     			  $datos=$this->db->query($consulta)->result();
     			  return $datos;
     			}
     		  
              
     	    }

     	  /*if(isset($array['delete'])){
            $this->db->where('idPersona',$array['idPersona']);
            $this->db->delete('permiteEmision');
     	  }
     	  else{
          $this->db->where('idPersona',$array['idPersona']);
          $datos=$this->db->get('permiteEmision')->result();
          return $datos;
          }*/
     	

}
//------------------------------------------------------------------------
//Función realizado por Dennis Castillo
function insertaMetaComercial($idPersona,$meta,$tipo){
	$fecha=date("Y-m-d H:i:s");
	$fechaDeCreacion=explode(" ",$fecha);
		if($tipo=='metaCA'){
		$select="SELECT id,email FROM users WHERE idPersona=".$idPersona."";
		$resultado=$this->db->query($select)->result();
		foreach($resultado as $valor){
			$insertInto="INSERT INTO metacomercial(idPersona,idUser,email,montoDeMetaComercial,fechaCreacion,tipoDeMeta,mes,anio)
					 	  VALUE(".$idPersona.",".$valor->id.",'".$valor->email."',".$meta.",".$fechaDeCreacion[0].",'anual','0',YEAR(NOW()))";
			$this->db->query($insertInto);}}}
//------------------------------------------------------------------------
//[Dennis]
function obtenerMetaComercialAnual($idPersona) {

	if($idPersona==906 || $idPersona==6 || $idPersona==808){
		$this->db->select_sum("montoDeMetaComercial");
		$this->db->select("anio,mes,idPersona,idMetaComercial");
	} else{
		$this->db->where('idPersona',$idPersona);
	}

	#$this->db->select('anio','montoDeMetaComercial');
	//$this->db->where('idPersona',$idPersona);

	$this->db->where("anio", date("Y"));
	$this->db->order_by('idMetaComercial','DESC');
	$query=$this->db->get('metacomercial');

	if($query->num_rows()>0){
		$resultado=$query->row();}
	else{$resultado=array();}
	return $resultado;
}
//------------------------------------------------------------------------
#[Dennis Castillo]
function obtenerIngresosTotalAgente($emailUsuario){
	#Esta consulta devuelve la sumatoria total de ingresos de los todos los agentes de un coordinador por mes.
	$select="SELECT SUM(bitacora.ingresoTotalesEAB) AS ingresoTotal, bitacora.mesEAB, bitacora.metaComercialEAB
			 FROM envioagentesbitacora bitacora
			 INNER JOIN users usuario ON bitacora.IDVendEAB=usuario.IDVend
			 INNER JOIN persona persona ON usuario.IDVend=persona.IDVend
			 WHERE bitacora.anioEAB=YEAR(NOW()) AND usuario.activated=1 AND usuario.banned=0 AND persona.tipoPersona=3
			 AND userEmailCreacion='".$emailUsuario."' GROUP BY bitacora.mesEAB";
	$query=$this->db->query($select)->result();
	if(isset($query)){$resultado=$query;}
	else{$resultado=array();}
	return $resultado;
}
//------------------------------------------------------------------------
function obtenerModalidades(){
	if($this->emailUser==="COORDINADORCOMERCIAL@CAPCAPITAL.COM.MX"){
		$select="SELECT * FROM tipomodalidad";
		$query=$this->db->query($select)->result();}
	elseif($this->emailUser==="COORDINADOR@CAPCAPITAL.COM.MX"){
		$select="SELECT * FROM tipomodalidad WHERE idModalidad IN (3,4)";
		$query=$this->db->query($select)->result();}
	elseif($this->emailUser==="COORDINADORINSTITUCIONAL@AGENTECAPITAL.COM" || $this->emailUser==="COORDINADORCARIBE@AGENTECAPITAL.COM"){
		$select="SELECT * FROM tipomodalidad WHERE idModalidad=4";
		$query=$this->db->query($select)->result();}
	elseif($this->emailUser==="COORDINADOR@ASESORESCAPITAL.COM"){
		$select="SELECT *  FROM tipomodalidad WHERE idModalidad <> 4";
		$query=$this->db->query($select)->result();}
	elseif($this->emailUser==="COORDINADORCOMERCIAL@FIANZASCAPITAL.COM"){ //COORDINADORCOMERCIAL@FIANZAS.COM
		$select="SELECT *  FROM tipomodalidad WHERE idModalidad <> 3";
		$query=$this->db->query($select)->result();}
	elseif($this->emailUser==="SISTEMAS@ASESORESCAPITAL.COM" || $this->emailUser==="CAPITALHUMANO@AGENTECAPITAL.COM" || $this->emailUser==="AUDITORINTERNO@AGENTECAPITAL.COM" || $this->emailUser==="DIRECTORGENERAL@AGENTECAPITAL.COM"){
		$select="SELECT *  FROM tipomodalidad";
		$query=$this->db->query($select)->result();}
	else{
		$query=array();
	}
	return $query;
}

//------------------------------------------------------------------------
//[Dennis 2020-04-01]
function obtenerArchivosObligatorios($idPersona){
	$layoutTipoagente=$this->obtenerTipoAgenteParaLaoyut($idPersona);
	$select="SELECT * FROM personadocumentoguardado WHERE idPersona=".$idPersona." AND idPersonaDocumento IN (SELECT idPersonaDocumento
                           							FROM personadocumento
                           							WHERE obligatorioPD='SI' AND layoutPD=".$layoutTipoagente.")";
	$query=$this->db->query($select)->result();

	if(isset($query)){$resultado=$query;}
	else{$resultado=array();}
	return $resultado;
}
function docObligatorios($idPersona){
	$layoutTipoagente=$this->obtenerTipoAgenteParaLaoyut($idPersona);
	$select="SELECT idPersonaDocumento FROM personadocumento WHERE obligatorioPD='SI' AND layoutPD=".$layoutTipoagente.";";
	$query=$this->db->query($select)->result();

	/*if(isset($query)){$resultado=$query;}
	else{$resultado=0;} */
	return $query;
}
//-------------------------------------------------------------------------
function personasVendedoresPorCategoria($array)
{   

$respuesta=array();
if(isset($array['categoria'])){
	$consulta="";
  switch ($array['categoria']) {
  	case 'cancun':
  		   $consulta='select distinct(p.IDVend) from persona p where p.IDVend>0 and p.id_catalog_sucursales=2 and p.tipoPersona=3';
  		break;
  	case 'merida':
  		   $consulta='select distinct(p.IDVend) from persona p where p.IDVend>0 and (p.id_catalog_sucursales=1 || p.id_catalog_sucursales=7) and p.IDVend!=7 and p.tipoPersona=3';
  		break;
  	case 'institucional':
  		   $consulta='select distinct(p.IDVend) from persona p where p.IDVend>0 and p.IDVend=7 and p.tipoPersona=3';
  		break;
  	case 'todos':
  		   $consulta='select distinct(p.IDVend) from persona p where p.IDVend>0 and p.tipoPersona=3';
  		break;
  	
  	default:
  		$respuesta['opciones']='valores para consulta: cancun,merida,institucional,totos';
  		break;
  }

  if($consulta!=''){$respuesta=$this->db->query($consulta)->result();}
}
else{
$respuesta['opciones']='mandar un array["categoria"] los valores para consulta: cancun,merida,institucional,totos';
}
return $respuesta;
}
//------------------------------------------------------------------------
//[Dennis 2020-04-07]
function obtenerEmail($idPersona){
	$this->db->select('email');
	$this->db->where('idPersona',$idPersona);
	$query=$this->db->get('users');

	if($query->num_rows()>0){$resultado=$query->row();}
	else{$resultado=array();}
	return $resultado;
}
//------------------------------------------------------------------------
function devolverUsersPorEmail($email){
	$consulta='select * from users where users.email="'.$email.'"';
	$datos=$this->db->query($consulta)->result()[0];
	return $datos;

}
//------------------------------------------------------------------------
//[Dennis 2020-04-08]
function devuelveSucursalCoor($idPersona){

	$persona=$this->obtenerEmail($idPersona);
	if($persona->email==="COORDINADORCOMERCIAL@CAPCAPITAL.COM.MX" || $persona->email==="COORDINADORCARIBE@AGENTECAPITAL.COM"){
		$select="SELECT * FROM catalog_sucursales WHERE idSucursal=2";
		$query=$this->db->query($select)->result();}
	elseif($persona->email==="COORDINADORINSTITUCIONAL@AGENTECAPITAL.COM"){
		$select="SELECT * FROM catalog_sucursales WHERE idSucursal IN (1,7)";
		$query=$this->db->query($select)->result();}
	elseif($persona->email==="COORDINADORCOMERCIAL@FIANZASCAPITAL.COM"){
		$select="SELECT * FROM catalog_sucursales WHERE idSucursal IN (2,1)";
		$query=$this->db->query($select)->result();}
	elseif($persona->email==="COORDINADOR@CAPCAPITAL.COM.MX" || $persona->email==="COORDINADOR@ASESORESCAPITAL.COM"){
		$select="SELECT * FROM catalog_sucursales WHERE idSucursal=1";
		$query=$this->db->query($select)->result();}
	elseif($persona->email==="SISTEMAS@ASESORESCAPITAL.COM" || $persona->email==="CAPITALHUMANO@AGENTECAPITAL.COM" || $persona->email==="AUDITORINTERNO@AGENTECAPITAL.COM" || $persona->email="DIRECTOR@AGENTECAPITAL.COM"){
		$query=$this->obtenerCatalogSucursales();
	}
	
	if(isset($query)){$resultado=$query;}
	else{$resultado=array();}
	
	return $resultado;
}

//------------------------------------------------------------------------

//[Dennis 2020-04-14]
public function obtenerTipoAgentePorModalidad($idModalidad){
	
	$select="SELECT * FROM personatipoagente WHERE idModalidad=".$idModalidad."";
	$datos=$this->db->query($select)->result();
	return $datos;	
}
//------------------------------------------------------------------------
//[Dennis 2020-04-14]
public function obtenerCanalPorTipoAgente($canal){
	if($canal==5 || $canal==7){
		$select="SELECT * FROM catalog_canales WHERE activo=1 AND idCanal=2";
		$query=$this->db->query($select)->result();}
	elseif($canal==1 || $canal==4){
		$select="SELECT * FROM catalog_canales WHERE activo=1 AND idCanal=11";
		$query=$this->db->query($select)->result();}
	elseif($canal==3 || $canal==2){
		$select="SELECT * FROM catalog_canales WHERE activo=1 AND idCanal IN (3,10)";
		$query=$this->db->query($select)->result();}

	if(isset($query)){$resultado=$query;}
	else{$resultado=array();}

	return $resultado;
}
//------------------------------------------------------------------------
public function devuelveTipoAgenteActual($idPersona){
	$select="SELECT personaTipoAgente 
			FROM personatipoagente 
			WHERE idPersonaTipoAgente IN (SELECT personaTipoAgente FROM persona WHERE IdPersona=".$idPersona.")";
	$respuesta=$this->db->query($select)->result();
	if((count($respuesta))>0){$query=$respuesta[0];}
	#$query=$this->db->query($select)->result()[0];

	if(isset($query)){$resultado=$query;}
	else{$resultado=new stdClass();  $resultado->personaTipoAgente='';}

	return $resultado;
}

//------------------------------------------------------------------------

public function devuelveCanalActual($idPersona){
	//$resultado=array();
	$select="SELECT nombreTitulo 
				FROM catalog_canales 
				WHERE activo =1 AND IdCanal IN (SELECT id_catalog_canales FROM persona WHERE IdPersona=".$idPersona.")";

	$query=$this->db->query($select)->result();
//if(isset($query)){$resultado=$query;}
  
	if((count($query))>0){$resultado=$query[0];}	
	else{$resultado=new stdClass();$resultado->nombreTitulo="No hay datos";}

	return $resultado;
}
//------------------------------------------------------------------------
//[Dennis 2020-04-24]
function insertaCertificaciones($certificaciones){
	
	for($i=0;$i<count($certificaciones);$i++){
		$this->db->insert("registro_certificacion",$certificaciones[$i]);
	}
}

//[Dennis 2020-04-27]
function buscarVendedor($busqueda,$email){
	
	$selectLeft="SELECT persona.idPersona, persona.nombres, persona.apellidoPaterno, persona.apellidoMaterno,
				agente.personaTipoAgente, canal.nombreTitulo, sucursal.NombreSucursal, persona.idVend, usuario.name_complete
				FROM persona persona
				LEFT JOIN catalog_canales canal ON canal.idCanal=persona.id_catalog_canales
				LEFT JOIN personatipoagente agente ON agente.idPersonaTipoAgente=persona.personaTipoAgente
				LEFT JOIN catalog_sucursales sucursal ON sucursal.IdSucursal=persona.id_catalog_sucursales
				LEFT JOIN users  usuario ON usuario.idPersona=persona.idPersona
				WHERE (persona.bajaPersona=0 AND usuario.banned=0 AND usuario.activated=1)
				AND (persona.nombres LIKE '%".$busqueda."%' OR persona.apellidoPaterno LIKE '%".$busqueda."%' OR persona.apellidoMaterno LIKE '%".$busqueda."%' OR usuario.name_complete LIKE '%".$busqueda."%'
				OR agente.personaTipoAgente LIKE '%".$busqueda."%' OR canal.nombreTitulo LIKE '%".$busqueda."%' OR sucursal.NombreSucursal LIKE '%".$busqueda."%')
				AND  persona.userEmailCreacion= '".$email."'
				ORDER BY nombres ASC";
				
	if($this->tank_auth->get_usermail()=='DIRECTORGENERAL@AGENTECAPITAL.COM' 
		|| $this->tank_auth->get_usermail()=='SISTEMAS@ASESORESCAPITAL.COM' 
		|| $this->tank_auth->get_usermail()=='AUDITORINTERNO@AGENTECAPITAL.COM' 
		|| $this->emailUser=="SUBGERENTE@CAPCAPITAL.COM.MX" 
		|| $this->emailUser=="GERENTE@CAPCAPITAL.COM.MX" 
		|| $this->emailUser=="MARKETING@AGENTECAPITAL.COM" 
		|| $this->emailUser=="GERENTEOPERATIVO@AGENTECAPITAL.COM"){
		$consulta=str_replace("AND  persona.userEmailCreacion= '".$email."'", "",$selectLeft);
		$query=$this->db->query($consulta)->result();}
		
	else{$query=$this->db->query($selectLeft)->result();}

	return $query;
}

function prueba2($emailCreador){
	$selectLeft="SELECT persona.idPersona, persona.nombres, persona.apellidoPaterno, persona.apellidoMaterno,agente.personaTipoAgente, canal.nombreTitulo, sucursal.NombreSucursal, persona.idVend, usuario.name_complete
				FROM persona persona
				LEFT JOIN catalog_canales canal ON canal.idCanal=persona.id_catalog_canales
				LEFT JOIN personatipoagente agente ON agente.idPersonaTipoAgente=persona.personaTipoAgente
				LEFT JOIN catalog_sucursales sucursal ON sucursal.IdSucursal=persona.id_catalog_sucursales
				LEFT JOIN users  usuario ON usuario.idPersona=persona.idPersona
				WHERE persona.bajaPersona=0 AND usuario.banned=0 AND usuario.activated=1
				AND  persona.userEmailCreacion= '".$emailCreador."'
				ORDER BY nombres ASC";
	//$query=$this->db->query($selectLeft)->result();
	if($emailCreador=="todos"){
		$consulta=str_replace("AND  persona.userEmailCreacion= '".$emailCreador."'", "",$selectLeft);
		$query=$this->db->query($consulta)->result();
	}
	else{$query=$this->db->query($selectLeft)->result();}

	return $query;
}

function obtenerHrsCapaIndividual($idPersona){
	//$idPersona=822;
	$this->db->select('idPersona,emailCreador,mes,fechaAsignada,anio');
	$this->db->select_sum('certificacion');
	$this->db->select_sum('certificacionAutos');
	$this->db->select_sum('certificacionGmm');
	$this->db->select_sum('certificacionVida');
	$this->db->select_sum('certificacionDanos');
	$this->db->select_sum('certificacionFianzas');
	$this->db->where("idPersona", $idPersona);
	$this->db->group_by("mes");
	$select=$this->db->get("registro_certificacion")->result();

	
	return $select;
}
//[Dennis 2020-05-03]
function obtenerHrsCapaCoor($emailCoor=null,$tipoCert){
	$this->db->select("persona.idPersona,nombres,apellidoPaterno,apellidoMaterno,mes,anio,tipoCapacitacion,nombreCertificado");
	$this->db->select_sum('certificacion');
	$this->db->select_sum('certificacionAutos');
	$this->db->select_sum('certificacionGmm');
	$this->db->select_sum('certificacionVida');
	$this->db->select_sum('certificacionDanos');
	$this->db->select_sum('certificacionFianzas');
	$this->db->from("persona");
	$this->db->join("registro_certificacion","registro_certificacion.idPersona=persona.idPersona","left");
	$this->db->join("catalog_certificacion","catalog_certificacion.id_certificado=registro_certificacion.id_certificado","left");
	$this->db->join("catalog_capacitacion","catalog_capacitacion.id_capacitacion=catalog_certificacion.id_capacitacion","left");

	if(!empty($emailCoor)){
		$this->db->where("registro_certificacion.emailCreador",$emailCoor);
	}
	
	$this->db->where("registro_certificacion.id_certificado",$tipoCert);
	$this->db->group_by(array("registro_certificacion.idPersona","mes","tipoCapacitacion","nombreCertificado"));
	$this->db->order_by("mes","asc");
	$select=$this->db->get()->result();

	return $select;
}
//[Dennis 2020-05-27]
function devuelveCertificadoActivoCoor($emailCreador){
	$select="SELECT DISTINCT(tipoCapacitacion), capa.id_capacitacion
			FROM registro_certificacion registro
			LEFT JOIN catalog_certificacion certi ON certi.id_certificado=registro.id_certificado
			LEFT JOIN catalog_capacitacion capa ON capa.id_capacitacion=certi.id_capacitacion ";

			if(!empty($emailCreador)){
				$select.="WHERE registro.emailCreador='".$emailCreador."';";
			}
	
	$query=$this->db->query($select)->result();
	
	return $query;
}
//[Dennis 2020-05-27]
function devuelveCapaXCerti($capacitacion, $usuario=null){
	$select="SELECT DISTINCT(nombreCertificado), certi.id_certificado
			FROM registro_certificacion registro
			LEFT JOIN catalog_certificacion certi ON certi.id_certificado=registro.id_certificado
			LEFT JOIN catalog_capacitacion capa ON capa.id_capacitacion=certi.id_capacitacion 
			WHERE capa.id_capacitacion=".$capacitacion."";

			if(!empty($usuario)){
				$select.=" AND registro.emailCreador='".$usuario."'";
			}
			//$select.="WHERE capa.id_capacitacion=".$capacitacion." AND registro.emailCreador='".$usuario."'";
	$query=$this->db->query($select)->result();
	
	return $query;		
}

function resumenGeneral(){
	/*$select="SELECT persona.idPersona, persona.nombres, persona.apellidoPaterno, persona.apellidoMaterno, persona.tipoPersona, persona.personaTipoAgente, persona.id_catalog_sucursales, persona.id_catalog_canales,
			capa.emailCreador, capa.certificacion, capa.certificacionAutos,capa.certificacionGmm,capa.certificacionVida,capa.certificacionDanos,capa.certificacionFianzas,capa.mes,capa.anio
			FROM persona persona
			LEFT JOIN registro_certificacion capa ON  capa.idPersona=persona.idPersona
			WHERE persona.bajaPersona=0 AND persona.tipoPersona=3 
			GROUP BY capa.mes, capa.idPersona
			ORDER BY persona.idPersona ASC;"; */
		$this->db->select("persona.idPersona,nombres,apellidoPaterno,apellidoMaterno,tipoPersona,personaTipoAgente,id_catalog_sucursales,id_catalog_canales,mes,anio,tipoCapacitacion,nombreCertificado,catalog_capacitacion.id_capacitacion,catalog_certificacion.id_certificado");
		$this->db->select_sum('certificacion');
		$this->db->select_sum('certificacionAutos');
		$this->db->select_sum('certificacionGmm');
		$this->db->select_sum('certificacionVida');
		$this->db->select_sum('certificacionDanos');
		$this->db->select_sum('certificacionFianzas');
		$this->db->from("persona");
		$this->db->join("registro_certificacion","registro_certificacion.idPersona=persona.idPersona","left");
		$this->db->join("catalog_certificacion","catalog_certificacion.id_certificado=registro_certificacion.id_certificado","left");
		$this->db->join("catalog_capacitacion","catalog_capacitacion.id_capacitacion=catalog_certificacion.id_capacitacion","left");
		$this->db->group_by(array("registro_certificacion.idPersona","mes")); //,"catalog_certificacion.nombreCertificado","catalog_capacitacion.tipoCapacitacion"
		$this->db->order_by("mes","asc");
		$select=$this->db->get()->result();
		
	//$query=$this->db->query($select)->result();
	
	return $select;
}

//[Dennis 2020-05-26]
function devuelveTipoCapacitacion(){
	$select="SELECT * FROM catalog_capacitacion WHERE activo=1";
	$resultado=$this->db->query($select)->result();

	
	return $resultado;
}

//[Dennis 2020-05-26]
function devuelveTipoCertificado($tipoCapa){
	$this->db->where("id_capacitacion",$tipoCapa);
	$resultado=$this->db->get("catalog_certificacion")->result();

	return $resultado;
}

function devuelveInfoXSubCapa($subCapa){
	/*$this->db->distinct();
	$this->db->select("mes");
	$this->db->where("id_certificado",$subCapa);
	$this->db->order_by("mes","ASC");
	$respuesta=$this->db->get("registro_certificacion")->result(); */

	$this->db->select("persona.idPersona,nombres,apellidoPaterno,apellidoMaterno,mes,anio,tipoCapacitacion,nombreCertificado,id_catalog_sucursales,persona.id_catalog_canales, persona.tipoPersona");
	$this->db->select_sum('certificacion');
	$this->db->select_sum('certificacionAutos');
	$this->db->select_sum('certificacionGmm');
	$this->db->select_sum('certificacionVida');
	$this->db->select_sum('certificacionDanos');
	$this->db->select_sum('certificacionFianzas');
	$this->db->from("persona");
	$this->db->join("registro_certificacion","registro_certificacion.idPersona=persona.idPersona","left");
	$this->db->join("catalog_certificacion","catalog_certificacion.id_certificado=registro_certificacion.id_certificado","left");
	$this->db->join("catalog_capacitacion","catalog_capacitacion.id_capacitacion=catalog_certificacion.id_capacitacion","left");
	$this->db->where("registro_certificacion.id_certificado",$subCapa);
	$this->db->group_by(array("registro_certificacion.idPersona","mes","tipoCapacitacion","nombreCertificado"));
	$this->db->order_by("mes","asc");
	$respuesta=$this->db->get()->result();

	return $respuesta;
}

function resumenGeneralGraficas($valorCapa,$valorSubCapa,$valorMes){

	$this->db->select("persona.idPersona,nombres,apellidoPaterno,apellidoMaterno,mes,anio,tipoCapacitacion,nombreCertificado,id_catalog_sucursales,persona.id_catalog_canales, persona.tipoPersona");
	$this->db->select_sum('certificacion');
	$this->db->select_sum('certificacionAutos');
	$this->db->select_sum('certificacionGmm');
	$this->db->select_sum('certificacionVida');
	$this->db->select_sum('certificacionDanos');
	$this->db->select_sum('certificacionFianzas');
	$this->db->from("persona");
	$this->db->join("registro_certificacion","registro_certificacion.idPersona=persona.idPersona","left");
	$this->db->join("catalog_certificacion","catalog_certificacion.id_certificado=registro_certificacion.id_certificado","left");
	$this->db->join("catalog_capacitacion","catalog_capacitacion.id_capacitacion=catalog_certificacion.id_capacitacion","left");
	$this->db->where("catalog_capacitacion.id_capacitacion",$valorCapa);
	$this->db->where("registro_certificacion.id_certificado",$valorSubCapa);
	$this->db->where("registro_certificacion.mes",$valorMes);
	$this->db->group_by(array("registro_certificacion.idPersona","mes","tipoCapacitacion","nombreCertificado"));
	$this->db->order_by("mes","asc");
	$select=$this->db->get()->result();

	return $select;
}


	public function obtener($id, $full = null)
	{
		$query = $this->db->where("u.idPersona", $id)
			->where("u.activated",1)
			->where("u.banned",0)
			->where("p.tipoPersona",1)
			->select("p.*,u.name_complete")
			->join("users u", "u.idPersona = p.idPersona", "inner")
			->get("persona p");

		$rslt = $query->row();

		if (gettype($full) == "string") {
			$epp = $this->db
				->where("pp.idPuesto", $rslt->idPersonaPuesto)
				->get("personapuesto pp");

			$rslt->puesto = $epp->row();
		}

		return $query->row();
	}

	public function obtenerJefe($id)
	{
		$query = $this->db->where("u.idPersona", $id)
			->where("p.tipoPersona",1)
			->select("p.*,u.name_complete")
			->join("users u", "u.idPersona = p.idPersona", "inner")
			->get("persona p");

		$tmp = $query->row();
		
		$epp = $this->db
			->where("pp.idPuesto", $tmp->idPersonaPuesto)
			->get("personapuesto pp");
		$puesto = $epp->row();
		
		$query = $this->db
			->where("u.activated",1)
			->where("u.banned",0)
			->where("p.tipoPersona",1)
			->where("p.idPersonaPuesto",$puesto->padrePuesto)
			->join("users u", "u.idPersona = p.idPersona", "inner")
			->select("p.*,u.name_complete, u.email")
			->get("persona p");

		return $query->row();
	}

	public function obtenerPuestoBy($id)
	{
		$query = $this->db->where("idPuesto", $id)
			->get("personapuesto");
		return $query->row();
	}
	public function obtenerPuestosBy($id)
	{
		$query = $this->db->where_in("idPuesto", $id)
			->get("personapuesto");
		return $query->result();
	}

	function getEmpleados()
	{
		$this->db->where("activated", 1);
		$this->db->where("banned", 0);
		$this->db->select("u.idPersona as value,u.name_complete as label,p.idPersonaPuesto puesto");
		$this->db->join("persona p","p.idPersona = u.idPersona AND p.tipoPersona = 1","inner");
		$tipos = $this->db->get('users u');
		return $tipos->result_array();
	}

	function getVacaciones($id)
	{
		$query = $this->db->select("get_vacaciones($id)")
			->get();
		$rs = $query->result_array();
		return $query->num_rows > 0 ? $rs[0][key($rs[0])] : 0;
	}
	
	function get_Puestos()
	{
		$tipos = $this->db->select("idPuesto id, personaPuesto name, padrePuesto parent,idPersonaPuestoGrupo")
			->where("statusPuesto", 1)
			->get('personapuesto');
		return $tipos->result_array();
	}

	function getPuestos()
	{
		$tipos = $this->db->select("idPuesto value, personaPuesto label, padrePuesto parent")
			->where("statusPuesto", 1)
			->get('personapuesto');
		return $tipos->result_array();
	}

	public function baja_persona($id, $motivo)
	{
		$ok = false;
		$this->db->trans_begin();
		$this->db->where("idPersona", $id);
		$this->db->update(
			"persona",
			array(
				"motivo_id" => $motivo,
				"bajaPersona" => true,
				"fecha_baja" => date('Y-m-d H:i:s'),
			)
		);

		$this->db->where("idPersona", $id);
		$this->db->update(
			"users",
			array(
				"activated" => false,
				"modified" => date('Y-m-d H:i:s')
			)
		);
		if ($this->db->trans_status() === FALSE) {
			$this->db->trans_rollback();
		} else {
			$this->db->trans_commit();
			$ok = true;
		}
		return $ok;
	}


	public function addOnTheMinutePersona($idPersona, $idOnTheMine)
	{
		$ok = false;
		try {
			$this->db->trans_begin();

			$this->db
				->where("idPersona", $idPersona)
				->delete("personaontheminute");

			$this->db
				->insert("personaontheminute", array(
					"idPersona" => $idPersona,
					"idOnTheMinute" => $idOnTheMine
				));
			if ($this->db->trans_status() === FALSE) {
				$this->db->trans_rollback();
			} else {
				$this->db->trans_commit();
				$ok = true;
			}
		} catch (\Throwable $th) {
			log_message('error', $th->getMessage());
		}
		return $ok;
	}
//-------------------------------------------------------------
function coordinadoreshijos($array)
{
  $respuesta=array();
  
  if(isset($array['idPersonaCoordinador']))
  {
   if(isset($array['delete']))
   {
    $this->db->query('delete from coordinadoreshijos where idPersonaCoordinador='.$array['idPersonaCoordinador']);    
    
   }
   else
   {
   	if(isset($array['idPersonaHijo']))
   	 {  
   	 	
        $array['idPersonaHijo']=(int)$array['idPersonaHijo'];
        $array['idPersonaCoordinador']=(int)$array['idPersonaCoordinador'];     
   	 	$this->db->insert('coordinadoreshijos',$array);	
   	 	   	    	   	  
   	 }
   	 else
   	 {
   	 	$consulta='select * from coordinadoreshijos where idPersonaCoordinador='.$array['idPersonaCoordinador'];
       $respuesta=$this->db->query($consulta)->result();	 	

   	 }
   }
  }
  else
  {
    $consulta='select * from coordinadoreshijos';
    $respuesta=$this->db->query($consulta)->result();
  }
  	
  return $respuesta;
}
//-------------------------------------------------------------
function comentarioagenteanuevo($array)
{

$respuesta=array();
     if(isset($array['idComentarioAgenteNuevo']))
     {
          if(isset($array['update']))
          {
           unset($array['update']);
           $this->db->where('idComentarioAgenteNuevo',$array['idComentarioAgenteNuevo']);
           $this->db->update('comentarioagenteanuevo',$array);
          }
          else
          {
          
          }
     }
   else
   {
     if(isset($array['idPersona']) && isset($array['tipoComentario']))
     {
          if(isset($array['insert']))
          {
          unset($array['insert']);
          $this->db->insert('comentarioagenteanuevo',$array);
          }
          else
          {         
      $consulta="select * from comentarioagenteanuevo where idPersona=".$array['idPersona'].'  and activo=1 and tipoComentario="'.$array['tipoComentario'].'" order by fechaCreacion desc';      
      $respuesta=$this->db->query($consulta)->result();
      }

     }
   }
   return $respuesta;

}

//-------------------------------------------------------------
function caracteristicasagentenuevopersonarelacion($array)
{   $caracteristica=array();

	$table_ = $array["tipoPersona"] == "colaborador" ? "caracteristicascolaboradornuevo" : "caracteristicaagentenuevo";

	$consulta='select * from '.$table_.' can where can.caracteristicaAgenteNuevo="'.$array['caracteristicaAgenteNuevo'].'"';
	//$consulta='select * from caracteristicaagentenuevo can where can.caracteristicaAgenteNuevo="'.$array['caracteristicaAgenteNuevo'].'"';
	$caracteristica=$this->db->query($consulta)->result();
	if((count($caracteristica))>0)
	{
	  if($array['insertar']==1)
	  {
	  	unset($array['insertar']);
		unset($array['tipoPersona']);
        $this->db->insert('caracteristicasagentenuevopersonarelacion',$array);
	  }
	  else
	  {
        $this->db->where('idPersona',$array['idPersona']);
        $this->db->where('caracteristicaAgenteNuevo',$array['caracteristicaAgenteNuevo']);
        $this->db->delete('caracteristicasagentenuevopersonarelacion');
	  }
	}
}

//-------------------------------------------------------------
function caracteristicasAgenteNuevo($array)
{  

 $respuesta=array();
	$idPersona=explode(',', $array['idPersona']);
	$where='';
	$band=0;

	foreach ($idPersona as  $value) {
		if($band==0){$where='idPersona='.$value;$band=1;}
		else{if($value!=''){$where.=' || idPersona='.$value;}}
	}
  $consulta="select * from caracteristicasagentenuevopersonarelacion  where ".$where;
  
  $respuesta=$this->db->query($consulta)->result();
  return $respuesta;
 
}
//-----------------------------------------------------------
//[Dennis 2020-07-27]

function devuelveRamo(){

	$resultado=array();

	$this->db->where("activo",1);
	$query=$this->db->get("ramos");

	if($query->num_rows()>0){
		$resultado=$query->result();
	}

	return $resultado;

}

//--------------------------------------------------------------
function colaboradorarea($area)
{
 //$consulta="select * from colaboradorarea";
 $consulta="select * from colaboradorarea where idcolaboradorarea != 0";
 $respuesta=$this->db->query($consulta)->result();
 return $respuesta;
}

//-----------------------------------------------------------------------------------
//[Dennis 2020-07-30]: consulta que devuelve las sub-categoria de capacitación en registro.
function devuelveSubCapacitacionDelRegistro(){

	$resultado=array();

	$this->db->distinct();
	$this->db->select("id_certificado");
	$this->db->from("registro_certificacion");
	$query=$this->db->get();

	if($query->num_rows()>0){
		//$resultado=$query->result_array();
		foreach($query->result() as $valor){
			array_push($resultado, $valor->id_certificado);
		}
	} else {
		$resultado=0; 
	}

	

	return $resultado;
}

//--------------------------------------------------------------------------------
//[Dennis 2020-07-30]: consulta que devuelve las categorias de capacitaciones y sub-categorias

function devuelveCategoriaCapa(){

	$sub_categorias=$this->devuelveSubCapacitacionDelRegistro();

	$resultado=array();

	$this->db->distinct();
	$this->db->select("tipoCapacitacion,catalog_capacitacion.id_capacitacion");
	$this->db->from("catalog_capacitacion");
	$this->db->join("catalog_certificacion","catalog_capacitacion.id_capacitacion=catalog_certificacion.id_capacitacion","inner");
	$this->db->where_in("catalog_certificacion.id_certificado",$sub_categorias);
	
	$query=$this->db->get();

	if($query->num_rows()>0){
		$resultado=$query->result();
	}


	return $resultado;
}

//------------------------------------------------------------
//[Dennis 2020-07-30]. consulta que devuelve las subcategoria de una categoria en registro.
function devuelveSubCategoriaxCategoriaEnRegistro($categoria){

	$resultado=array();

	$this->db->distinct()
			->select("registro_certificacion.id_certificado,catalog_certificacion.nombreCertificado")
			->from("registro_certificacion")
			->join("catalog_certificacion","registro_certificacion.id_certificado=catalog_certificacion.id_certificado","inner")
			->join("catalog_capacitacion","catalog_certificacion.id_capacitacion=catalog_capacitacion.id_capacitacion","inner")
			->where("catalog_capacitacion.id_capacitacion",$categoria);
	$query=$this->db->get();

	if($query->num_rows()>0){
		$resultado=$query->result();
	}

	return $resultado;

}
//-------------------------------------------------------------
function mesesXRamoActivo($cat, $subCat, $ramo){

	

	$resultado=array();

	$select="SELECT SUM(".$ramo.") AS sumRamo, mes, tipoCapacitacion, nombreCertificado
			FROM registro_certificacion re
			INNER JOIN catalog_certificacion ce ON re.id_certificado=ce.id_certificado
			INNER JOIN catalog_capacitacion ca ON ce.id_capacitacion=ca.id_capacitacion
			WHERE ca.id_capacitacion=".$cat." AND ce.id_certificado=".$subCat."
			GROUP BY mes
			ORDER BY mes ASC";
	$query=$this->db->query($select);

	if($query->num_rows()>0){
		$resultado=$query->result();
	}

	

	return $resultado;
}
//-------------------------------------------------------------------
function devuelveDatosSubCategoria($subCat){

	$resultado=array();

	$this->db->where("nombreCertificado",$subCat);
	$query=$this->db->get("catalog_certificacion");

	if($query->num_rows()>0){
		$resultado=$query->row();
	}

	return $resultado;
}

//-----------------------------------------------------------------------------------------------------------
function obtenerAgenteXEmail($correo){

	$resultado=array();

	$this->db->where("email",$correo);
	$query=$this->db->get("users");

	if($query->num_rows()>0){
		$resultado=$query->result();
	}

	return $resultado;
}
//----------------------------------------------------------------------------------------------------------
function devuelveCorreosSuperiores(){

	$resultado=array();

	$this->db->distinct()
			->select("emailHijo");
	$query=$this->db->get("coordinadoreshijos");

	if($query->num_rows()>0){
		$resultado=$query->result();
	}

	return $resultado;
}

//-----------------------------------------------------------------------------------------------------------
//Comentado se uso para una prueba.[Dennis 2020-08-05].
/*function insertaCapaCal($certificaciones){
	
	for($i=0;$i<count($certificaciones);$i++){
		$this->db->insert("registro_certificacion_calendario",$certificaciones[$i]);
	}
} */
//--------------------------------------------------------------------------
function devolverColaboradoresActivos($array=null)
{
 /*==
  esAgenteColaborador= ES UN VENDEDOR QUE ES CATALOGADO COMO EMPLEADO	
 ==*/
	if(isset($array['grupos']))
 	{$respuesta=array();
      $area=$this->db->query("select * from colaboradorarea")->result();
      foreach ($area as $key => $value) 
       { 
       	 $areaColaborador='select p.idpersonarankingagente,p.nombres,p.idPersona,p.personaTipoAgente,p.apellidoPaterno,p.apellidoMaterno,p.celPersonal,(p.celPersonal) as CelularSMS,u.IDVend ,u.email,(u.email) as EMail1,u.id,u.banned,u.idTipoUser,u.idTipoUserSMSmail,(concat(p.apellidoPaterno," ",p.apellidoMaterno," ",p.nombres)) as username,"COLABORADOR" as TIPO,p.esCoordinador,p.telOficina,p.telOficinaExtension,p.celOficina from persona p  left join users u on u.idPersona=p.idPersona where (p.tipoPersona=1 or p.esAgenteColaborador=1) and u.banned=0 and u.activated=1 and p.idColaboradorArea='.$value->idColaboradorArea;
         $colaborador=$this->db->query($areaColaborador)->result_array();
        if(count($colaborador)>0)
        {
    	 $datos['Name']=$value->colaboradorArea;
    	 $datos['tipoPersona']='Colaborador';
    	 $datos['Data']=$colaborador;
    	 $datos['IDVend']=0;
    	 $datos['IdUser']=$this->idUser;
    	 array_push($respuesta, $datos);
        }
  	
      }
      return $respuesta;
	}
	else
	{	
	$consulta="select p.* from persona p left join users u on u.idPersona=p.idPersona where p.tipoPersona=1 and u.banned=0 and u.activated=1 ";
	return $this->db->query($consulta)->result();
    }
	
}
//-------------------------------------------------------------
function clasificacionUsuariosParaEnvios($array=null)
{
  /*==========
  SON USUARIOS QUE SE CLASIFICAN PARA HACER ENVIOS POR EJEMPLO EN EMAIL, SMS, PARA CONVOCAR JUNTAS

  ========*/
  $respuesta=array();
  if($this->IDVend>0 and $array==null)
  {
  	$datos=array();
  $datos['Name']='Clientes';
  $datos['tipoPersona']='Clientes Agente';
  $datos['IDVend']=$this->IDVend;
  $datos['Data']=array();
  $datos['IdUser']=$this->idUser;
  array_push($respuesta,$datos);
  }
  else
  {
   if($this->IDVend==0){
   $consultaAgentes='select distinct(p.idpersonarankingagente) from persona p where p.tipoPersona=3 and p.idpersonarankingagente!="" order by p.idpersonarankingagente';
   $agentes=$this->db->query($consultaAgentes)->result();  
   foreach ($agentes as $key => $value) 
   {
  	if($value->idpersonarankingagente!='' and $value->idpersonarankingagente!=null)
  	{	
  	     $consulta='select u.aliadoCarCapital, p.idpersonarankingagente,p.nombres,p.idPersona,p.personaTipoAgente,p.apellidoPaterno,p.apellidoMaterno,p.celPersonal,(p.celPersonal) as CelularSMS,
u.IDVend,u.email,(u.email) as EMail1,u.id,u.banned,u.idTipoUser,u.idTipoUserSMSmail,(concat(p.apellidoPaterno," ",p.apellidoMaterno," ",p.nombres)) as username,"COLABORADOR" as TIPO,p.esCoordinador,p.telOficina,p.telOficinaExtension,p.celOficina,p.tipoPersona from persona p  left join users u on u.idPersona=p.idPersona where p.tipoPersona=3 and u.banned=0 and u.activated=1 and p.esAgenteColaborador=0 and p.idpersonarankingagente="'.$value->idpersonarankingagente.'"';
        $agentesRanking=$this->db->query($consulta)->result_array();
	
      $datos['Name']=$value->idpersonarankingagente;
      $datos['tipoPersona']='Vendedor';
      $datos['Data']= $agentesRanking;
      $datos['IDVend']=0;  
      $datos['IdUser']=5;
      $datos['idTipoUser']=0;
      array_push($respuesta, $datos);     
    }
  }
  }
  $area=$this->db->query("select * from colaboradorarea")->result();
  foreach ($area as $key => $value) 
  { $areaColaborador='select u.aliadoCarCapital,p.idpersonarankingagente,p.nombres,p.idPersona,p.personaTipoAgente,p.apellidoPaterno,p.apellidoMaterno,p.celPersonal,(p.celPersonal) as CelularSMS,u.IDVend ,u.email,(u.email) as EMail1,u.id,u.banned,u.idTipoUser,u.idTipoUserSMSmail,(concat(p.apellidoPaterno," ",p.apellidoMaterno," ",p.nombres)) as username,"COLABORADOR" as TIPO,p.esCoordinador,p.telOficina,p.telOficinaExtension,p.celOficina,p.tipoPersona from persona p  left join users u on u.idPersona=p.idPersona where (p.tipoPersona=1 or p.esAgenteColaborador=1) and u.banned=0 and u.activated=1 and p.idColaboradorArea='.$value->idColaboradorArea;
    $colaborador=$this->db->query($areaColaborador)->result_array();
    if(count($colaborador)>0)
    {
    	$datos['Name']=$value->colaboradorArea;
    	$datos['tipoPersona']='Colaborador';
    	$datos['Data']=$colaborador;
    	$datos['IDVend']=0;
    	$datos['IdUser']=$this->idUser;
    	array_push($respuesta, $datos);
    }
  	
  }
  if($array==null){
  $marketing=$this->db->query('select (IDCli) as  IDVend,(IDCli) as  id,(concat(Nombre," ",ApellidoP," ",ApellidoM )) as name_complete, (concat(Nombre," ",ApellidoP," ",ApellidoM )) as username,(EMail1) as email,(Telefono1) as CelularSMS, 0 as banned, 9 as IdCanal, 4 as idTipoUserSMSmail, 4 as idTipoUser, 0 as tipoPersona from clientes_actualiza where EstadoActual="ELIMINADO" and basuraSMSEmail=0')->result_array();
  $datos['Name']='Marketing proyecto 100';
  $datos['tipoPersona']='Clientes proyecto 100';
  $datos['IDVend']=0;
  $datos['Data']=$marketing;
  $datos['IdUser']=$this->idUser;
  array_push($respuesta,$datos);
  $datos['Name']='Clientes GAP';
  $datos['tipoPersona']='Clientes GAP';
  $datos['IDVend']=7;
  $datos['Data']=array();
  $datos['IdUser']=$this->idUser;
  array_push($respuesta,$datos);

  }
  }
  return $respuesta;
}
//-------------------------------------------------------------
function personapuestogrupo($array=null)
{ 
	if(isset($array['idPersonaPuestoGrupo']))
	{
	  if($array['idPersonaPuestoGrupo']==-1)
       {
        unset($array['idPersonaPuestoGrupo']);
        $array['cantidadPermitida']=1;
        $array['cantidadOcupada']=0;
        $this->db->insert('personapuestogrupo',$array);
       }
     else
     {
     if(isset($array['update']))
     {
     	unset($array['update']);
     	$this->db->where('idPersonaPuestoGrupo',$array['idPersonaPuestoGrupo']);
     	$this->db->update('personapuestogrupo',$array);
     }
	}
	}
	else
	{
    $consulta="select * from personapuestogrupo order by personaPuestoGrupo";
     return $this->db->query($consulta)->result();
   }
}
//-------------------------------------------
function aumentaDecrementapersonapuestogrupo($idPersonaPuestoGrupo,$operacion)
{
  if($operacion==0)
  {
  	$update='update personapuestogrupo set cantidadPermitida=cantidadPermitida-1 where idPersonaPuestoGrupo='.$idPersonaPuestoGrupo;
  }
  else
  {
  	$update=$update='update personapuestogrupo set cantidadPermitida=cantidadPermitida+1 where idPersonaPuestoGrupo='.$idPersonaPuestoGrupo;
  }
  $this->db->query($update);
}
//-------------------------------------------
function devolverColaboradorConPuesto()
{
	$info=array();
	$consulta='select p.nombres,p.apellidoPaterno,p.apellidoMaterno,ppg.idPersonaPuestoGrupo,pp.personaPuesto from persona p left join users u on u.idPersona=p.idPersona left join personapuesto pp on pp.idPersona=p.idPersona left join personapuestogrupo ppg on ppg.idPersonaPuestoGrupo=pp.idPersonaPuestoGrupo where u.banned=0 and u.activated=1 and p.tipoPersona=1 and pp.idPersona>0 order by ppg.idPersonaPuestoGrupo';
	$consulta='select ppg.*,pp.personaPuesto,pp.idPersonaPuestoGrupo,pp.idPersona,(if(pp.idPersona>0,(concat(p.apellidoPaterno," ",p.apellidoMaterno," ",p.nombres)),"Vacante")) as nombrePersona,p.idPersonaPuesto from personapuestogrupo ppg
left join personapuesto pp on pp.idPersonaPuestoGrupo=ppg.idPersonaPuestoGrupo
left join  persona p on p.idPersona=pp.idPersona
where pp.statusPuesto=1';

    $informacion=$this->db->query($consulta)->result();

$infoPerDocCatalogo=$this->db->query('select pd.idPersonaDocumento,pd.textoPD,"0" as tieneDocumento from personadocumento pd where pd.layoutPD=8')->result();
    $totalDocCatalogo=count($infoPerDocCatalogo);
    
    foreach ($informacion as $key => $value) 
    { 
    	$value->documentosPersonales=array();
    	$value->bandInformacionProcesos=0;
    	$value->requerimientosPuestoDoc=array();
    	$value->documentosDelPuesto=array();
    	$value->informacionProcesos=array();  
    	$value->bandDocPersonales=0;  	
      if($value->idPersonaPuesto!='')
      {
        $infoDocPersonales=array(); 
    	$infoDocPersonales=$this->db->query('select * from  personadocumentoguardado pdg where pdg.idPersona='.$value->idPersona)->result();

    	$value->documentosPersonales=$this->db->query('select pd.idPersonaDocumento,pd.textoPD,"0" as tieneDocumento from personadocumento pd where pd.layoutPD=8')->result();
        $banDocPersonal=0;
          foreach ($infoDocPersonales as $valInfoDP) 
          {    	

          	foreach ($value->documentosPersonales as  $valDP) 
          	{

          		if($valDP->idPersonaDocumento==$valInfoDP->idPersonaDocumento)
          		{   $banDocPersonal++;
          			$valDP->tieneDocumento=1;
          		}
          	}
          }
 	

         if($banDocPersonal==$totalDocCatalogo){$value->bandDocPersonales=2;}
         else
    {
         	if($banDocPersonal>0){$value->bandDocPersonales=1;}
         }
    	$consulPuesto='select mp.idDivMUP,mp.descripcionMUP,(if(m.contenido="",0,1)) as bandContenido from manualusuario m  left join  manualusuariopartes mp on mp.idDivMUP=m.idDivContenedor where mp.tipoMUP="M" and m.idPuesto='.$value->idPersonaPuesto.' order by mp.ordenMUP';
    	//$valPuesto=$this->db->query($consulPuesto)->result();
    	$value->requerimientosPuestoDoc=$this->db->query($consulPuesto)->result();
    	
    	
    	$consulta1='select funcionpuesto.idFuncionProcesoFP,funcionproceso.descripcionFP from funcionpuesto  left join funcionproceso on funcionproceso.idFuncionProceso=funcionpuesto.idFuncionProcesoFP where funcionproceso.statusFP=1 and funcionproceso.clasificacionFP=0 and funcionpuesto.idPuestoFP='.$value->idPersonaPuesto;    	
    	$datos1=$this->db->query($consulta1)->result();

    	$value->documentosDelPuesto=$this->db->query('select nombre,url from documentos_capitalhumano where idPuesto='.$value->idPersonaPuesto)->result();

    	foreach ($datos1 as $keyD1 => $datos1Val) 
    	{   $consulta1='';
    		$consulta1='select idFuncionProceso,descripcionFP from funcionproceso where statusFP=1 and padreFP='.$datos1Val->idFuncionProcesoFP;
    		$datos2=$this->db->query($consulta1)->result();
            
    		foreach ($datos2 as $keyD2 => $datos2Val) 
    		{$value->bandInformacionProcesos=1;
    			$consulta1='';
    			$consulta1='select  (if(contenido="",0,1)) as bandera from manualusuario where manualusuario.idFuncionProceso='.$datos2Val->idFuncionProceso.' group by bandera';
    			$bandConsulta=$this->db->query($consulta1)->result();
    			if(count($bandConsulta)==0)
    			{
    				$agregar=array();
    				$agregar['funcion']=$datos1Val->descripcionFP;
    				$agregar['proceso']=$datos2Val->descripcionFP;
    				$agregar['informacion']='SIN DATOS';
    				array_push($value->informacionProcesos, $agregar);
    			}
    			if(count($bandConsulta)==2)
    			{
    				$agregar=array();
    				$agregar['funcion']=$datos1Val->descripcionFP;
    				$agregar['proceso']=$datos2Val->descripcionFP;
    				$agregar['informacion']='FALTA INFORMACION';
                    array_push($value->informacionProcesos, $agregar);
    			}
    		}
    	}
    }

      $id=$value->idPersonaPuestoGrupo;
      if(!isset($info[$id])){$info[$id]=array();}
     array_push($info[$id],$value);	
    }
	
	return $info;
}
//-------------------------------------------
function puestoDePersona($idPersona)
{   $datos=array();
	$consulta='select * from personapuesto where idPersona='.$idPersona;
    $datos=$this->db->query($consulta)->result();
    return $datos;
}
//-------------------------------------------
function devuelveInvitadoRep($evento){

	$respuesta=array();

	$this->db->where("id_evento",$evento);
	$query=$this->db->get("registro_certificacion");

	if($query->num_rows()>0){
		$resultado=$query->result();
	}

	return $resultado;
}
//-----------------------------------------------------------------------------------------------------------
function actualizaEnReporte($evento,$personaId){

	$resultado=false;

	$segundo=$this->load->database("db2", true);

	$segundo->query("CALL actualizaRegistroReporte(".$personaId.",'".$evento."')");

	if($this->db->trans_status()===FALSE){
		$this->db->trans_rollback();
	} else{
		$this->db->trans_commit();
		$resultado=true;
	}

	return $resultado;

}
//-----------------------------------------------------------------------------------------------------------
function devuelveInfoUser($idPersona){

	$resultado=array();

	$this->db->where("idPersona",$idPersona);
	$query=$this->db->get("users");

	if($query->num_rows()>0){
		$resultado=$query->result();
	}

	return $resultado;
}
//------------------------------------------------ Dennis 2021-05-07
function insertaMeta($datos,$bandera){

	$resultado=false;

	if($bandera == 1){
		$this->db->insert("metacomercial",$datos);
	} elseif($bandera == 2){
		$this->db->insert("metacomercial_ingreso_total",$datos);
	}

	$resultado=$this->db->insert_id();

	if($this->db->trans_status()===FALSE){
		$this->db->trans_rollback();
	} else{
		$this->db->trans_commit();
	}

	return $resultado;
}
//------------------------------------------------ Dennis 2021-05-07
function insertaMontoMensual($datos,$band){

	$resultado=false;

	if($band == 1){
		$this->db->insert("metapormes",$datos);
	} elseif($band == 2){
		$this->db->insert("metapormes_por_ingreso_total",$datos);
	}

	//$this->db->insert("metapormes",$datos);

	if($this->db->trans_status()===FALSE){
		$this->db->trans_rollback();
	} else {
		$this->db->trans_commit();
		$resultado=true;
	}

	return $resultado;
}
//------------------------------------------------

function devuelveMontosMensuales($idMeta){

	$resultado=array();

	$this->db->where("idMetaComercial",$idMeta);
	$query=$this->db->get("metapormes");

	if($query->num_rows()>0){
		$resultado=$query->result();
	}

	return $resultado;
}

//----------------------------------------------  Dennis 2021-05-07
function regresaMontodelMes($mes,$meta,$band){

	$resultado=array();

	$this->db->where("mes_num",$mes)
			->where("idMetaComercial",$meta);
	
	if($band == 1){
		$query=$this->db->get("metapormes");
	} elseif($band == 2){
		$query=$this->db->get("metapormes_por_ingreso_total");
	}
	//		$query=$this->db->get("metapormes");

	if($query->num_rows()>0){
		$resultado=$query->result();
	}

	return $resultado;

}
//---------------------------------------------  Dennis 2021-05-07
function regresaMontodelMes_respaldo($mes,$meta){

	$resultado=array();

	$this->db->where("mes_num",$mes)
			->where("idMetaComercial",$meta);
	$query=$this->db->get("metapormes");

	if($query->num_rows()>0){
		$resultado=$query->result();
	}

	return $resultado;

}
//-----------------------------------------------------------------------------------------------------------
function devuelveCoorMetaComercial(){

	$resultado=array();

	$this->db->where("anio",date("Y"));
	$query=$this->db->get("metacomercial");

	if($query->num_rows()>0){
		$resultado=$query->result();
	}

	return $resultado;

}
//----------------------------------------------  Dennis 2021-05-07
function devuelveCoorMetaComercialIngresoTotal(){

	$resultado=array();

	$this->db->where("anio",date("Y"));
	$query=$this->db->get("metacomercial_ingreso_total");

	if($query->num_rows()>0){
		$resultado=$query->result();
	}

	return $resultado;

}
//-------------------------------------  Dennis 2021-05-07
function actualizaMeta($array,$idMeta,$band){

	$exito=false;
	$tabla="";
	$this->db->where("idMetaComercial",$idMeta)
			->where("anio",date("Y"));
			//->update("metacomercial",$array);
	
	if($band == 1){
		//$tabla="metacomercial";
		$this->db->update("metacomercial",$array);
	} elseif($band == 2){
		$this->db->update("metacomercial_ingreso_total",$array);
		//$tabla="metacomercial_ingreso_total";
	}

	//$this->db->update($tabla,$array);

	if($this->db->trans_status()===FALSE){
		$this->db->trans_rollback();
	} else{
		$this->db->trans_commit();
		$exito=true;
	}

	return $exito;

}
//---------------------------------------------  Dennis 2021-05-07
function actualizaMontosMensuales($array,$idMeta,$mes,$band){

	$resultado=false;

	$this->db->where("idMetaComercial",$idMeta)
			->where("mes_num",$mes)
			->where("anio",date("Y"));
			//->update("metapormes",$array);

	if($band == 1){
		$this->db->update("metapormes",$array);
	} else{
		$this->db->update("metapormes_por_ingreso_total",$array);
	}

	if($this->db->trans_status()===FALSE){
		$this->db->trans_rollback();
	} else{
		$this->db->trans_commit();
		$resultado=true;
	}

	return $resultado;

}
//-------------------------------------------
function devuelveInfoGeneralCapa($idPersona,$mes,$tipo){

	$resultado=array();
	
	$this->db->select("idCertificacion,idPersona,id_invitado,emailCreador,mes,anio,fechaAsignada,catalog_certificacion.id_certificado,nombreCertificado,catalog_capacitacion.id_capacitacion,tipoCapacitacion")
			->select_sum("certificacion")
			->select_sum("certificacionAutos")
			->select_sum("certificacionGmm")
			->select_sum("certificacionVida")
			->select_sum("certificacionDanos")
			->select_sum("certificacionFianzas")
			->from("registro_certificacion")
			->join("catalog_certificacion","registro_certificacion.id_certificado=catalog_certificacion.id_certificado","inner")
			->join("catalog_capacitacion","catalog_certificacion.id_capacitacion=catalog_capacitacion.id_capacitacion","inner")
			->where("registro_certificacion.idPersona",$idPersona);

		if($tipo==1){
			if($mes!=null){
				$this->db->where("mes",$mes)
						->where("anio",date("Y"));
						//->group_by("mes");
			} //else{
				$this->db->group_by("nombreCertificado");
			//}
		} else{
			$this->db->group_by("nombreCertificado");
		}
		
		$this->db->order_by("catalog_capacitacion.id_capacitacion","asc");
			
	$query=$this->db->get();

	if($query->num_rows()>0){
		$resultado=$query->result();
	}

	return $resultado;

}
//------------------------------------------------------------------------------------------------------------
function devuelveMesesActivos($idPersona){

	$resultado=array();

	$this->db->distinct()
			->select("mes")
			->where("idPersona",$idPersona)
			->where("anio",date("Y"))
			->order_by("mes","asc");
	$query=$this->db->get("registro_certificacion");

	if($query->num_rows()>0){
		$resultado=$query->result();
	}

	return $resultado;

}

//---------------------------------------------
//-------Miguel Pesona Modelo 10/11/2021--------------------

function devuelveHijosCoordinador($usuario){
$consulta="SELECT u.name_complete, u.email,(SELECT idColaboradorArea FROM persona WHERE persona.idPersona=u.idPersona) as area from users as u, coordinadoreshijos where coordinadoreshijos.emailCoordinador='$usuario' AND u.idPersona=coordinadoreshijos.idPersonaHijo" ;
    $datos=$this->db->query($consulta)->result();
    return $datos;	
}

function devuelveHijos($usuario){
$consulta="SELECT u.name_complete, u.email,(SELECT idColaboradorArea FROM persona WHERE persona.idPersona=u.idPersona) as area from users as u, coordinadoreshijos where coordinadoreshijos.emailCoordinador='$usuario' AND u.idPersona=coordinadoreshijos.idPersonaHijo" ;
    $datos=$this->db->query($consulta)->result();
    return $datos;	
}

function devuelveInfoUserAll(){
  $consulta="SELECT user_miInfo.* from user_miInfo,persona where persona.idPersona=user_miInfo.idPersona AND persona.bajaPersona=0 ORDER BY user_miInfo.idPersona ASC"; 
   $datos=$this->db->query($consulta)->result();
    return $datos;	
}

function devuelveInfoUserActivo($id){
	$sql="SELECT activo from activar_userInfo WHERE id_user='$id'";
    $datos=$this->db->query($sql)->result();
    foreach ($datos as $row){
    	return $row->activo;
    }
}

function devuelveInfoUserAcerdaDe($id){
	$sql="SELECT acerca_de, formacion, experiencia,autos,gmm,vidas,danos,fianzas,espanol,ingles,frances from activar_userInfo WHERE id_user='$id'";
    $datos=$this->db->query($sql)->result();
    return $datos;
}

//Modificacion Miguel Jaime 11/11/2020
function getProspectosAgentes(){
	$sql="SELECT * from prospectos_agentes";
    $datos=$this->db->query($sql)->result();
    return $datos;
}
//--------------------------Final---------------------------

//---------------------------------------------
//[Dennis 2020-10-11]
function obtenerInfoIndividual($idPersona){

	$resultado=array();

	$this->db->where("idPersona",$idPersona);
	$query=$this->db->get("persona");

	if($query->num_rows()>0){
		$resultado=$query->result();
	}

	return $resultado;
}
//---------------------------------------------------
//[Dennis 2020-10-11]
function obtenerCaracteristicaIndividual($idPersona){

	$resultado=array();

	$this->db->where("idPersona",$idPersona);
	$query=$this->db->get("caracteristicasagentenuevopersonarelacion");

	if($query->num_rows()>0){
		$resultado=$query->result();
	}

	return $resultado;

}
//---------------------------------------------------
//[Dennis 2020-10-11]
function obtenerCaracteristicasDefault(){

	$resultado=array();

	$this->db->order_by("posicion","asc");
	$query=$this->db->get("caracteristicaagentenuevo");

	if($query->num_rows()>0){
		$resultado=$query->result();
	}

	return $resultado;
}
//---------------------------------------------------
//[Dennis 2020-10-11]
function actualizaEvaluacion($q,$r){

	$_r=str_replace(" ","",strtolower($r));

	$updateField=array("envioSolicitudEvaluacion"=>1);

	$this->db->where("idPersona",$q)
			->where("caracteristicaAgenteNuevo", $_r)
			->update("caracteristicasagentenuevopersonarelacion",$updateField);

	if($this->db->trans_status()===FALSE){
		$this->db->trans_rollback();
	} else{
		$this->db->trans_commit();
	}

}
//---------------------------------------------------
//[Dennis 26-10-33]

function obtenerCatalogCanalSicas(){

	$resultado=array();

	$this->db->where("IDGerenciaSICAS !=",0);
	$query=$this->db->get("catalog_canales");

	if($query->num_rows()>0){
		$resultado=$query->result();
	}

	return $resultado;
}

//---------------------------------------------------
function compruebaTipoPersona($idVend){

	$resultado=array();

	$this->db->where("IDVend",$idVend);
	$query=$this->db->get("persona");

	if($query->num_rows()>0){
		$resultado=$query->row();
	}

	return $resultado;
}
//---------------------------------------------------
function obtenerVendedorPorIDVend($IDVend)
{
	$IDVend = isset($IDVend) ? 0 : $IDVend;
	$respuesta=array();
	$consulta='select p.esAgenteColaborador from users u  left join persona p on p.idPersona=u.idPersona where u.activated=1 and u.banned=0 and u.IDVend='.$IDVend;

   $respuesta= $this->db->query($consulta)->result_array();
   return $respuesta;
}
//---------------------------------------------------
function proveedores($array)
{
    $data=array();
    if(isset($array['id']))
    {
        if($array['id']==-1)
        {
            
        }
    }
    else
    {
      $consulta='select * from proveedores';
      $data=$this->db->query($consulta);
      
    }
    return $data;
}
//----------------------------------

/*function datos_personales($correo){

	$resultado=array();

	$this->db->where("emailUsers", $correo);
	$query=$this->db->get("persona");

	if($query->num_rows()>0){
		$resultado=$query->row();
	}

	return $resultado;
}*/
function datos_personales($correo){

	$resultado=array();
	//$this->db->select("persona.nombres");
	$this->db->from("persona");
	$this->db->join("user_miInfo","user_miInfo.idPersona=persona.idPersona","left");
	//$this->db->where("user_miInfo.emailUser", $correo);
	$this->db->where("persona.idPersona", $correo);
	$query=$this->db->get();//("persona");

	if($query->num_rows()>0){
		$resultado=$query->row();
	}

	return $resultado;
}

//---------------------------------------------------

function obtenerTodasLasPersonas(){

	$resultado=array();

	$this->db->from("persona");
	$this->db->join("users","users.idPersona=persona.idPersona","left");
	$this->db->where("persona.bajaPersona",0);
	$this->db->where("users.activated",1);
	$this->db->where("users.banned",0);
	$query=$this->db->get();

	if($query->num_rows()>0){
		
		$resultado=$query->result();

	}

	return $resultado;
}
//---------------------------------------------------
function generaNotificacionCumpleanio($array){

	$this->db->insert("notificacion_cumpleanio",$array);

	return $this->db->insert_id();
}
//---------------------------------------------------
function devuelveFelicitaciones($id){

	$resultado=array();

	$this->db->from("notificacion_cumpleanio");
	$this->db->join("relacion_persona_fecha_cumpleanio_notificacion","relacion_persona_fecha_cumpleanio_notificacion.id_notificacion_cumpleanio=notificacion_cumpleanio.id_notificacion_cumpleanio","inner");
	$this->db->join("persona","persona.idPersona=relacion_persona_fecha_cumpleanio_notificacion.idPersona_cumpleanio","inner");
	$this->db->join("users","users.idPersona=persona.idPersona","left");
	$this->db->join("catalog_canales","catalog_canales.IdCanal=persona.id_catalog_canales","left");
	$this->db->join("personapuesto","personapuesto.idPersona=persona.idPersona","left");
	$this->db->join("colaboradorarea","colaboradorarea.idColaboradorArea=persona.idColaboradorArea","left");
	$this->db->where("notificacion_cumpleanio.id_notificacion_cumpleanio",$id);
	$query=$this->db->get();

	if($query->num_rows()>0){
		$resultado=$query->result();
	}

	return $resultado;
}
//---------------------------------------------------
function crearRelacionFelicitacionPersona($array){

	$respuesta=false;

	$this->db->insert("relacion_persona_fecha_cumpleanio_notificacion", $array);

	if($this->db->trans_status()===FALSE){
		$this->db->trans_rollback();
	} else{
		$this->db->trans_commit();
		$respuesta=true;
	}

	return $respuesta;
}
//---------------------------------------------------
function registraCapacitacion($array_insert){

	$res = false;

	$this->db->insert("registro_certificacion", $array_insert);

	if($this->db->trans_status() === FALSE){
		$this->db->trans_rollback();
	} else{
		$this->db->trans_commit();
		$res = true;
	}

	return $res;
}

//---------------------------------------------------
//[TIC CONSULTORES MIGUEL AVILA 27-05-2021]

function getTreedb(){
	$tipos = $this->db->get("modulo_grupo");
	$allt=$tipos->result_array();
	$tree=[];
	foreach ($allt as $key => $value) {
		$tree[]=array(
			"nombre"=>$value["nombre"],
			"items"=>$this->getItemsGroups($value["id"])
		);
	}
	return $tree;

}
//---------------------------------------------------
//[TIC CONSULTORES MIGUEL AVILA 27-05-2021]
function getTableNombre($tabla){
	$tipos = $this->db->get($tabla);
	return $tipos->result_array();
}
//---------------------------------------------------
//[TIC CONSULTORES MIGUEL AVILA 27-05-2021]
function getItemsGroups($id){
	$this->db->select('mu.nombre ,mu.url,mg.nombre modulo, mu.id')
	->join("modulo_url mu", "mgr.id_url=mu.id", "left")
	->join("modulo_grupo mg", "mgr.id_grupo=mg.id", "left")
	->where("mgr.id_grupo",$id)
	->order_by('mu.id','ASC');
	$obj=$this->db->get('modulo_grupo_relacion mgr');
	return $obj->result_array();
}

//---------------------------------------------------
function obtenerPersonaPorNombre($n, $p1, $p2){

	$this->db->from("persona");
	$this->db->join("users", "users.idPersona=persona.idPersona", "left");
	$this->db->where("apellidoPaterno", $p1);
	$this->db->where("apellidoMaterno", $p2);
	$this->db->where("nombres", $n);
	$this->db->where("bajaPersona",0);
	$this->db->where("activated",1);
	$this->db->where("banned",0);
	$query = $this->db->get();

	return $query->num_rows() > 0 ? $query->row() : array();
}
//----------------------------------
//Dennis Castillo [2021-10-31]
function getUniqueDocRequired($idPersona, $idDoc, $idLayout){ //3110

	$this->db->where("idPersona", $idPersona);
	$this->db->where("idPersonaDocumento", $idDoc);
	$this->db->where("idLayout", $idLayout);
	$query = $this->db->get("personadocumentoguardado");

	return $query->num_rows() > 0 ? $query->result_array() : array();
}
//---------------------------------
//Dennis Castillo [2021-10-31]
function insertaRegistro($reg, $table){ //3110

	$this->db->insert($table, $reg);
}
//----------------------------
//Dennis Castillo [2021-10-31]
function updateToTemporalCount($array){ //3110

	$this->db->where("idPersona", $array["idPersona"]);
	unset($array["idPersona"]);
	$this->db->update("users", $array);
}
//----------------------------
//Dennis Castillo [2021-10-31]
function getPositions($email){ //3110

	$highRanking = array("DIRECTORGENERAL@AGENTECAPITAL.COM", "CAPITALHUMANO@AGENTECAPITAL.COM", "SISTEMAS@ASESORESCAPITAL.COM");

	$this->db->where("statusPuesto = 1 
		AND idPersona = 0 
		".(!in_array($email, $highRanking) ? "AND padrePuesto IN (SELECT idPuesto FROM personapuesto WHERE email = '".$email."')" : "")."");
	$query = $this->db->get("personapuesto");
	
	return $query->num_rows() > 0 ? $query->result() : array();
}
//---------------------------- Dennis Castillo [2021-12-22]
function getPositions_($email, $area){
	
	$select = 'SELECT * 
		FROM personapuesto 
		WHERE statusPuesto = 1 
		AND idPersona = 0 AND idColaboradorArea = '.$area[0]->idColaboradorArea.' AND padrePuesto IN (
			SELECT idPuesto FROM personapuesto WHERE email = "'.$email.'"
		)';
	$query = $this->db->query($select);

	return $query->num_rows() > 0 ? $query->result() : array();
}
//----------------------------
//Dennis Castillo [2021-10-31]
function insertRegister($table, $array){ //3110

	$this->db->insert($table, $array);
	return $this->db->insert_id();
}
//----------------------------
//Dennis Castillo [2021-10-31]
function getInducctionFreePerson($id){ //3110

	$this->db->where("inducctionPerson", $id);
	$query = $this->db->get("set_free_of_inducction");

	return $query->num_rows() > 0 ? $query->row() : array();
}
//---------------------------
//Dennis Castillo [2021-10-31]
function getTemporalPersons(){ //3110

	$this->db->from("persona_temporal a");
	$this->db->join("persona_temporal_creator b", "a.idPersona = b.idTemporalPerson", "left");
	$this->db->order_by("a.idPersona" ,"asc");
	$query = $this->db->get();

	return $query->num_rows() > 0 ? $query->result() : array();
}
//---------------------------
//Dennis Castillo [2021-10-31]
function deleteTemporalPerson($id){ //3110

	$this->db->where("idPersona", $id);
	$this->db->delete("persona_temporal");

	$this->db->where("idTemporalPerson", $id);
	$this->db->delete("persona_temporal_creator");
}
//---------------------------
//Dennis Castillo [2021-10-31]
function getPassCodeNewUser($id){ //3110

	$this->db->where("idPersona", $id);
	$query = $this->db->get("new_person_passcode");

	return $query->num_rows() > 0 ? $query->row() : array();
}
//---------------------------
//Dennis Castillo [2021-10-31]
function validatePassCode($code){ //3110

	$this->db->where("passCode", $code);
	$query = $this->db->get("new_person_passcode");

	return $query->num_rows() > 0 ? $query->row() : array();
}
//---------------------------
//Dennis Castillo [2021-10-31]
function updatePassCode($idPersona, $array){ //3110

	$this->db->where("idPersona", $idPersona);
	$this->db->update("new_person_passcode", $array);
}
//---------------------------
//Dennis Castillo [2021-10-31]
function getPersonalEmail($id){ //3110

	$this->db->select("emailPersonal");
	$this->db->where("idPersona", $id);
	$query = $this->db->get("persona");

	return $query->num_rows() > 0 ? $query->row() : array();
}
//---------------------------
//Dennis Castillo [2021-10-31]
function geteEmployeLayout(){ //3110

	$this->db->where("layoutPD", 8);
	$query = $this->db->get("personadocumento");

	return $query->result();
}
//---------------------------
//Dennis Castillo [2021-10-31] -> [2022-06-02]
function getEmployeFileUpload($id, $idDoc = null, $idlayout){ //3110
	//$consulta="select personadocumentoguardado.idLayout, personadocumentoguardado.idPersonaDocumento,personadocumentoguardado.extensionPDG,personadocumento.descripcionPD from personadocumentoguardado left join personadocumento on personadocumento.idPersonaDocumento=personadocumentoguardado.idPersonaDocumento where personadocumentoguardado.idPersona=".$idPersona." and personadocumentoguardado.idLayout=".$layout;
	$this->db->from("personadocumentoguardado a");
	$this->db->join("personadocumento b", "a.idPersonaDocumento = b.idPersonaDocumento", "inner");
	$this->db->where("a.idLayout", $idlayout);
	$this->db->where("a.idPersona", $id);

	if(!empty($idDoc)){
		$this->db->where("a.idPersonaDocumento", $idDoc);
	}

	$query = $this->db->get();

	return $query->num_rows() > 0 ? $query->result() : array();
}
//---------------------------
//Dennis Castillo [2021-10-31]
function getPersonalPicture($id){  //3110

	$this->db->select("fotoUser");
	$this->db->where("idPersona", $id);
	$this->db->where("fotoUser !=", "noPhoto.jpg");
	$query = $this->db->get("user_miInfo");

	return $query->num_rows() > 0 ? $query->row() : array();
}
//---------------------------
//Dennis Castillo [2021-11-04]
function getEmployeeUsers(){

	$query = $this->db->get("employe_to_user");
	return $query->num_rows() > 0 ? $query->result() : array();
}
//---------------------------
//Dennis Castillo [2021-11-04]
function getCreatorEmployee($condition = null){

	if(!empty($condition)){
		$this->db->where($condition);
	}

	$query = $this->db->get("true_creator");
	return $query->num_rows() > 0 ? $query->result() : array();
}
//---------------------------
//Dennis Castillo [2021-11-04]
function updateStatusEmployeeToUser($array, $id, $changeRelaseStatus){ //Dennis Castillo [2022-06-02]

	$response = true;
	$this->db->trans_begin();
	$this->db->where("idPersona", $id);
	$this->db->update("employe_to_user", $array);

	if(!empty($changeRelaseStatus) && is_array($changeRelaseStatus)){
		$this->db->where("inducctionPerson", $changeRelaseStatus["person"]);
		$this->db->update("set_free_of_inducction", array("status" => $changeRelaseStatus["status"])); //fired (baja de personal)
	}

	if(isset($array["avance"]) && $array["avance"] == "liberado"){
		//Proceso de intercambio de cuenta (otorgar cuenta al nuevo al ser liberado y dar de baja al anterior).
		$job = $this->db->where("idPersona", $id)->get("personapuesto")->row();

		$this->db->where(array("idJob" =>$job->idPuesto, "email" => $job->email));
		$this->db->update("list_of_users_to_delete", array("reallyDeleted" => 1));

		$getPersonInList = $this->db->where(array("idJob" =>$job->idPuesto, "email" => $job->email, "reallyDeleted" => 1))->get("list_of_users_to_delete")->row();

		if(!empty($getPersonInList)){
			$this->db->where("idPersona", $getPersonInList->idPersona)->update("persona", array("bajaPersona" => 1));
		}
	}

	if($this->db->trans_status() === FALSE){
		$this->db->trans_rollback();
		$response = false;
	} else{
		$this->db->trans_commit();
	}

	return $response;
}
//--------------------------- Dennis Castillo [2022-06-02]
function updateStatusEmployeeToUser_($person){ //Funcion obsoleta - Dennis Castillo [2022-06-02]

	$this->db->trans_begin();
	$this->db->where("idPersona", $id);
	$this->db->update("employe_to_user", $array);
}
//---------------------------
//Dennis Castillo [2021-11-04]
function getReviewer($id, $viewer){

	$this->db->where("idPerson", $id);
	$this->db->where("reviewer", $viewer);
	$query = $this->db->get("induction_user_reviewer");

	return $query->num_rows() > 0 ? $query->row() : array();
}
//--------------------------
//Dennis Castillo [2021-11-04]
function executeQuery($query){

	$this->db->trans_start();
	$this->db->query($query);
	$this->db->trans_complete();
	$response = true;

	if($this->db->trans_status() === FALSE){
		$this->db->trans_rollback();
		$response = false;
	}

	return $response;
}	
//--------------------------
function getMyEmployees($email){

	$this->db->where("creator", $email);
	$query = $this->db->get("true_creator");
	return $query->num_rows() > 0 ? $query->result() : array();
}
//--------------------------
function getMyEmployeesByEmail($email = null){

	$this->db->from("employe_to_user a"); //true_creator a
	$this->db->join("true_creator b", "a.idPersona = b.idChild", "left"); //idChild
	if(!empty($email)){
		$this->db->where("b.creator", $email);
	}
	
	$query = $this->db->get();

	return $query->num_rows() > 0 ? $query->result() : array();
}
//--------------------------
function getEmployeeById($id){

	$this->db->select("*, CASE WHEN avance = 'liberado' THEN 'fired' ELSE 'cancelled' END AS deleteStatus, CASE WHEN avance = 'liberado' THEN 'despedido' ELSE 'cancelado' END AS estadoBaja", false);
	$this->db->where("idPersona", $id);
	$query = $this->db->get("employe_to_user");

	return $query->num_rows() > 0 ? $query->row() : array();
}
//-------------------------- //Dennis Castillo [2022-06-16]
function getAgentById($id){

	$this->db->select("*, CASE WHEN avance = 'liberado' THEN 'fired' ELSE 'cancelled' END AS deleteStatus, CASE WHEN avance = 'liberado' THEN 'despedido' ELSE 'cancelado' END AS estadoBaja", false);
	$this->db->where("idPersona", $id);
	$query = $this->db->get("prospective_to_user");

	return $query->num_rows() > 0 ? $query->row() : array();
}
//--------------------------
function getParentsEmail($filterEmails){

	$this->db->distinct();
	$this->db->select("emailCoordinador");
	$this->db->where($filterEmails);
	$this->db->where("emailCoordinador is not null");
	$query = $this->db->get("coordinadoreshijos");

	return $query->num_rows() > 0 ? $query->result() : array();
}
//--------------------------
function updateProgressNewPerson($id, $array){

	$this->db->trans_start();
	$this->db->where("inducctionPerson", $id);
	$this->db->update("set_free_of_inducction", $array);
	$this->db->trans_complete();

}
//-------------------------
//Dennis Castillo [2021-11-16]
function getBirthdayOfMonth($month){

	$this->db->from("persona a");
	$this->db->join("users b", "a.idPersona = b.idPersona", "left");
	$this->db->join("user_miInfo c", "a.idPersona = c.idPersona", "left");
	$this->db->where("MONTH(fechaNacimiento)", $month);
	$this->db->where("a.bajaPersona", 0);
	$this->db->where("b.banned", 0);
	$this->db->where("b.activated", 1);
	$query = $this->db->get();

	return $query->num_rows() > 0 ? $query->result() : array();
}
//-------------------------
//Dennis Castillo [2021-11-23]
function changePersonPosition($id, $position){

	$response = false;
	$this->db->trans_begin();
	$select = $this->db->where("idPersona", $id)
					->where("idPuesto", $position)
					->get("personapuesto")->result();

	if(!empty($select)){
		$this->db->where("idPuesto", $select[0]->idPuesto)
		->update("personapuesto", array("idPersona" => 0));
	} 

	$update = $this->db->where("idPuesto", $position)
			->update("personapuesto", array("idPersona" => $id));
	
	//$this->db->trans_complete();

	if($this->db->trans_status() === FALSE){

		$this->db->trans_rollback();
	} else{
		$this->db->trans_commit();
		$response = true;
	}

	return $response;
}
//-------------------------
function getAllPositions(){

	$query = $this->db->get("personapuesto");
	return $query->num_rows() > 0 ? $query->result() : array();
}
//--------------------------
function getMyAreas(){
	$position = $this->puestoDePersona($this->tank_auth->get_idPersona());

	$this->db->select("DISTINCT(b.idColaboradorArea) idarea, b.*", false);
	$this->db->from("personapuesto a");
	$this->db->join("colaboradorarea b","a.idColaboradorArea = b.idColaboradorArea", "left");
	$this->db->where("a.padrePuesto", $position[0]->idPuesto);
	$this->db->where("a.idColaboradorArea !=", 0);
	$query = $this->db->get();

	return $query->num_rows() > 0 ? $query->result() : array();
}
//---------------------------
function obtenerColaboradorArea($area){
	$this->db->where("idColaboradorArea", $area);
	$query = $this->db->get("colaboradorarea");

	return $query->num_rows() > 0 ? $query->result() : array();
}
//---------------------------
function getAvaliblePositions($area){

	$this->db->where("statusPuesto", 1);
	$this->db->where("idPersona", 0);
	$this->db->where("idColaboradorArea", $area[0]->idColaboradorArea);
	$query = $this->db->get("personapuesto");

	return $query->num_rows() > 0 ? $query->result() : array();
}
//------------------------- //Dennis Castillo [2022-02-22]
function getDeleteRequest($id){

	$this->db->where("idPersona", $id);
	$query = $this->db->get("casualty_list");

	return $query->num_rows() > 0 ? $query->row() : array();
}
//------------------------- //Dennis Castillo [2022-02-22]
function removeRequest($id){

	$this->db->where("id", $id);
	$delete = $this->db->delete("casualty_list");

	return $delete;
}
//------------------------- //Dennis Castillo [2022-02-22]
function getAllDeleteRequest(){
	
	$query = $this->db->get("casualty_list");
	return $query->num_rows() > 0 ? $query->result() : array();
}
//------------------------- //Dennis Castillo [2022-02-22]
function updatePersonsUserAndPendingData($set, $condition){

	$response = false;
	$this->db->trans_begin();

	//GET info
	$query = $this->db->join("users b", "b.idPersona = a.idPersona", "left")->where($condition)->get("persona a")->row();

	if($query->tipoPersona == 1 || $query->esAgenteColaborador = 1){

		$this->db->insert("list_of_users_to_delete", array("idPersona" => $query->idPersona, "email" => $query->emailOld, "idJob" => $query->idPersonaPuesto, "deleteDate" => date("Y-m-d H:i:s")));
	}
	
	$this->db->update("personapuesto a", $set, $condition); ////persona a LEFT JOIN personapuesto b ON a.idPersona = b.idPersona LEFT JOIN set_free_of_inducction c ON a.idPersona = c.inducctionPerson

	if($this->db->trans_status() === FALSE){

		$this->db->trans_rollback();
	} else{
		$this->db->trans_commit();
		$response = true;
	}

	return $response;
}
//------------------------- //Dennis Castillo [2022-02-22]
function getPersonalDataForDelete($id){

	$query = $this->db->from("casualty_list a")
			->join("persona b", "a.idPersona = b.idPersona", "left")
			->where("a.id", $id)
			->get();
	
	return $query->num_rows() > 0 ? $query->row() : array();
}
//------------------------- //Dennis Castillo [2022-02-28]
function searchPerson($id){

	$query = $this->db->where("idPersona", $id)->get("persona");
	return $query->row();
}
//------------------------- //Dennis Castillo [2022-02-28]
function getPositionInPersonalData($id){

	$this->db->select("a.*, b.*, c.*");
	$this->db->join("personapuesto b", "a.idPersonaPuesto = b.idPuesto", "inner");
	$this->db->join("true_creator c", "a.idPersona = c.idChild", "left");
	$this->db->where("a.idPersona", $id);
	$query = $this->db->get("persona a");

	return $query->num_rows() > 0 ? $query->row() : array();
}
//-------------------------
function getMyPositionsByAreaAndEmail($email, $area){

	$subQuery = $this->db->select("idPuesto")->from("personapuesto")->where("email", $email)->get()->row();

	$this->db->where("idColaboradorArea", $area);
	$this->db->where("padrePuesto", !empty($subQuery) ? $subQuery->idPuesto : 0);
	$this->db->where("statusPuesto", 1);
	$this->db->where("idPersona", 0);
	$query = $this->db->get("personapuesto");

	return $query->num_rows() > 0 ? $query->result() : array();
}
//------------------------- //Dennis Castillo [2022-03-22]
function getAllPersonByJob($condition){

	$this->db->where($condition);
	$this->db->order_by("fecAltaSistemPersona", "asc");
	$query = $this->db->get("persona");

	return $query->num_rows() > 0 ? $query->result() : array();
}
//------------------------- //Dennis Castillo [2022-04-14]
function insertAsistence($array){

	$response = false;
	$this->db->trans_begin();
	$this->db->insert_batch("fastfile", $array);

	if($this->db->trans_status() === FALSE){
		$this->db->trans_rollback();
	} else{
		$this->db->trans_commit();
		$response = true;
	}

	return $response;
}
//-------------------------  //Dennis Castillo [2022-03-29]
function getMyPermissions($person){

	$this->db->join("personapermisorelacion b", "b.idPersonaPermiso = a.idPersonaPermiso", "inner");
	$this->db->where("b.idPersona", $person);
	$query = $this->db->get("personapermiso a");
	return $query->num_rows() > 0 ? $query->result() : array();
}
//------------------------- //Dennis Castillo [2022-06-02]
function requerimientosExtras($idPersona){

	$this->db->select("*,
		CASE 
			WHEN contrato = 1 THEN 'PERMANENTE' 
		ELSE 'TEMPORAL' END AS label1,
		CASE 
			WHEN fondoAhorro = 1 THEN 'SI APLICA' 
		ELSE 'NO APLICA' END AS label2", false);
	$this->db->where("idPersona", $idPersona);
	$query = $this->db->get("persona_contrato");

	return $query->num_rows() > 0 ? $query->row() : array();
}
//------------------------- //Dennis Castillo [2022-06-02]
function requerimientosPerfil($idPersona){

	$this->db->where("idPersona", $idPersona);
	$query = $this->db->get("requerimientos_y_perfil_del_puesto");

	return $query->num_rows() > 0 ? $query->row() : array();
}
//-------------------------
//****Fin registerAsistencia - Control de asistencia y puntualidad
//*******************Miguel Jaime 22/11/2021
function registerAsistencia($login){
	$sql="SELECT idPersona from users where username='$login' OR email='$login'";
	$rs=$this->db->query($sql)->result();
	if($rs){
		$idPersona=$rs[0]->idPersona;
		$day=date('d');
		$month=date('m');
		$year=date('Y');
		$sql_encontrado="SELECT * from fastfile WHERE idPersona='$idPersona' AND DAY(fecha)='$day' AND MONTH(fecha)='$month' AND YEAR(fecha)='$year' AND descripcion='puntualidad'";
		$encontrado=$this->db->query($sql_encontrado)->result();
		if(!$encontrado){
			$fecha=date('Y-m-d h:i:s');
			//determinar minutos de retraso;
			if( ( (date('h')==08) && (date('i')<=59) ) || ((date('h')==8) && (date('i')<=59)) ){
					$sql="INSERT INTO fastfile(idPersona,descripcion,fecha,valor)VALUES('$idPersona','puntualidad','$fecha','1')";
					$this->db->query($sql);
			}
		}
		//registrar asistencia
		$sql_encontradoAsist="SELECT * from fastfile WHERE idPersona='$idPersona' AND DAY(fecha)='$day' AND MONTH(fecha)='$month' AND YEAR(fecha)='$year' AND descripcion='asistencia'";
		$encontradoAsist=$this->db->query($sql_encontradoAsist)->result();
		if(!$encontradoAsist){
			$sqlX="INSERT INTO fastfile(idPersona,descripcion,fecha,valor)VALUES('$idPersona','asistencia','$fecha','1')";
			$this->db->query($sqlX);
		}
	}
}


function experienciasPuesto(){
	$sql="SELECT * from requerimientos_puesto where tipo='Experiencia'";
	$rs=$this->db->query($sql)->result();
	return $rs;
}

function getFechaLastLogin($id,$dia,$mes,$year){
    $fecha=$dia."-".$mes."-".$year;
    $sql="SELECT * FROM users WHERE idPersona='$id' AND DAY(last_login)='$dia' AND MONTH(last_login)='$mes' AND YEAR(last_login)='$year'";
    $rs=$this->db->query($sql)->result();
	  foreach($rs as $row){
        if($row->idPersona==$id){ $fecha=$row->last_login; }
    }
    return $fecha;
}

function asistenciaAnual($id,$year){
    $ct=0;
    $sql="SELECT * FROM fastfile WHERE idPersona='$id' AND YEAR(fecha)='$year' AND descripcion='asistencia'";
    $rs=$this->db->query($sql)->result();
	  foreach($rs as $row){
        if($row->idPersona==$id){ $ct++; }
    }
    return $ct;
}


function asistenciaMensual($id,$mes,$year){
    $ct=0;
    $sql="SELECT * FROM fastfile WHERE idPersona='$id' AND MONTH(fecha)='$mes' AND YEAR(fecha)='$year' AND descripcion='asistencia'";
    $rs=$this->db->query($sql)->result();
	  foreach($rs as $row){
        if($row->idPersona==$id){ $ct++; }
    }
    return $ct;
}

function asistencia($id,$dia,$mes,$year){
    $op=false;
    $sql="SELECT * FROM fastfile WHERE idPersona='$id' AND DAY(fecha)='$dia' AND MONTH(fecha)='$mes' AND YEAR(fecha)='$year'";
    $rs=$this->db->query($sql)->result();
	  foreach($rs as $row){
        if($row->idPersona==$id){ $op=true; }
    }
    return $op;
}

function puntualidadAnual($id,$year){
    $ct=0;
    $sql="SELECT * FROM fastfile WHERE idPersona='$id' AND YEAR(fecha)='$year' AND descripcion='puntualidad' AND valor_ant=1";
    $rs=$this->db->query($sql)->result();
	  foreach($rs as $row){
        if($row->idPersona==$id){ $ct++; }
    }
    return $ct;
}

function puntualidadMensual($id,$mes,$year){
    $ct=0;
    $sql="SELECT * FROM fastfile WHERE idPersona='$id' AND MONTH(fecha)='$mes' AND YEAR(fecha)='$year' AND descripcion='puntualidad' AND valor_ant=1";
    $rs=$this->db->query($sql)->result();
	  foreach($rs as $row){
        if($row->idPersona==$id){ $ct++; }
    }
    return $ct;
}

function puntualidad($id,$dia,$mes,$year){
    $op=false;
    $sqlX="SELECT * from fastfile WHERE DAY(fecha)='$dia' AND MONTH(fecha)='$mes' AND YEAR(fecha)='$year' AND descripcion='puntualidad' AND valor_ant=1 AND idPersona='$id'";
    $puntualidad=$this->db->query($sqlX)->result();
    foreach($puntualidad as $puntual){
        if($puntual->idPersona==$id){ $op=true; }
    }
    return $op;
}

function getFechaIngreso($idPersona){
	$sql="SELECT fecAltaSistemPersona FROM persona WHERE idPersona='$idPersona'";
	$rs=$this->db->query($sql)->result();
	return $rs[0]->fecAltaSistemPersona;
}

//****Fin registerAsistencia

//------------------------- //Dennis Castillo [2022-06-02]
function getTrueCreator($idPerson){

	$this->db->where("idChild", $idPerson);
	$query = $this->db->get("true_creator");

	return $query->num_rows() > 0 ? $query->row()->creator : $this->obtenerUsuarioCreacion($idPerson);
}
//------------------------- //Dennis Castillo [2022-04-11]
function createSupportLink($array){

	$response = false;
	$this->db->trans_begin();
	$this->db->insert("suport_link_list", $array);

	if($this->db->trans_status() === FALSE){
		$this->db->trans_rollback();
	} else{
		$this->db->trans_commit();
		$response = true;
	}

	return $response;
}
//------------------------- //Dennis Castillo [2022-04-11]
function updateSupportLink($condition, $array){

	$response = false;
	$this->db->trans_begin();
	$this->db->where($condition);
	$this->db->update("suport_link_list", $array);

	if($this->db->trans_status() === FALSE){
		$this->db->trans_rollback();
	} else{
		$this->db->trans_commit();
		$response = true;
	}

	return $response;
}
//------------------------- //Dennis Castillo [2022-04-11]
function getLikList(){

	$query = $this->db->get("suport_link_list");

	return $query->num_rows() > 0 ? $query->result() : array();
}
//------------------------- //Dennis Castillo [2022-04-11]
function getOnlyLink($id){

	$this->db->where("id", $id);
	$query = $this->db->get("suport_link_list");

	return $query->num_rows() > 0 ? $query->row() : array();
}
//------------------------- //Dennis Castillo [2022-04-11]
function deleteLinkOfList($condition){

	$response = false;
	$this->db->trans_begin();
	$this->db->where($condition);
	$this->db->delete("suport_link_list");

	if($this->db->trans_status() === FALSE){

		$this->db->trans_rollback();
	} else{
		$this->db->trans_commit();
		$response = true;
	}

	return $response;
}
//-------------------------- //Dennis Castillo [2022-06-16]
function getUsersForDelete($job){

	return $this->db->where(array("idJob" => $job, "reallyDeleted" => 0))->get("list_of_users_to_delete")->result();
}
//-------------------------- //Dennis Castillo [2022-06-28]
function getWorkStartPeriod($idPersona){

	$getYears = $this->db->query("SELECT TIMESTAMPDIFF(YEAR, (SELECT DATE(fecAltaSistemPersona) FROM persona WHERE idPersona = ".$idPersona."), DATE(NOW())) AS years")
				->row();

	$this->db->select("*");
	$this->db->where_in("anio", $getYears->years);

	return $this->db->get("tabla_vacaciones")->row();
}
//--------------------------
//--------------------------
function obtenerUsersPorIDVend($IDVend)
{
	$respuesta=array();
	if($IDVend>0)
	{
        $consulta='select * from users u where u.banned=0 and u.activated=1 and IDVend='.$IDVend;
            
        $respuesta=$this->db->query($consulta)->result();


	}
   return $respuesta;
}
//--------------------------
function obtenerPermisosPersona($idPersona='',$idPermiso='')
{
	$filtroPermiso='';
 if($idPersona==''){$this->tank_auth->get_idPersona();}
 if($idPermiso!=''){$filtroPermiso=' and idPersonaPermiso='.$idPermiso;}
 $consult='SELECT * FROM personapermisorelacion p WHERE p.idPersona='.$idPersona.$filtroPermiso;
 $datos=$this->db->query($consult)->result();

 $array=array();
 foreach ($datos as $key => $value) {
 	$array[$value->idPersonaPermiso]=$value;
 }
 return $array; 
}
//--------------------------
    //Asistencias
    function getAsistencia($email,$date) {
        $this->db->select('f.id, f.idPersona, f.fecha, f.descripcion, f.valor, p.idPersona, p.nombres, p.apellidoPaterno, p.apellidoMaterno, p.emailUsers');
        $this->db->join('persona p','f.idPersona=p.idPersona','inner');
        $this->db->where(array('p.emailUsers' => $email, 'DATE(f.fecha)' => $date, 'f.descripcion' => 'asistencia'));
        $this->db->order_by('f.fecha', 'desc');
        //$this->db->group_by('f.fecha');
        $query = $this->db->get('fastfile f');
        return $query->num_rows() > 0 ? $query->result() : array();
    }

    function getPuntualidad($email,$date) {
        $this->db->select('f.id, f.idPersona, f.fecha, f.descripcion, f.valor, p.idPersona, p.nombres, p.apellidoPaterno, p.apellidoMaterno, p.emailUsers');
        $this->db->join('persona p','f.idPersona=p.idPersona','inner');
        $this->db->where(array('p.emailUsers' => $email, 'DATE(f.fecha)' => $date, 'f.descripcion' => 'puntualidad'));
        $this->db->order_by('f.fecha', 'desc');
        //$this->db->group_by('f.fecha');
        $query = $this->db->get('fastfile f');
        return $query->num_rows() > 0 ? $query->result() : array();
    }

    function getAsistenciaPorMes($email,$month,$year) {
        $this->db->select('f.id, f.idPersona, f.fecha, f.descripcion, f.valor, p.idPersona, p.nombres, p.apellidoPaterno, p.apellidoMaterno, p.emailUsers');
        $this->db->join('persona p','f.idPersona=p.idPersona','inner');
        $this->db->where(array('p.emailUsers' => $email, 'MONTH(f.fecha)' => $month, 'YEAR(f.fecha)' => $year, 'f.descripcion' => 'asistencia'));
        $this->db->order_by('f.fecha', 'desc');
        //$this->db->group_by('f.fecha');
        $query = $this->db->get('fastfile f');
        return $query->num_rows() > 0 ? $query->result() : array();
    }

    function getPuntualidadPorMes($email,$month,$year) {
        $this->db->select('f.id, f.idPersona, f.fecha, f.descripcion, f.valor, p.idPersona, p.nombres, p.apellidoPaterno, p.apellidoMaterno, p.emailUsers');
        $this->db->join('persona p','f.idPersona=p.idPersona','inner');
        $this->db->where(
            array(
              'p.emailUsers' => $email, 
              'MONTH(f.fecha)' => $month, 
              'YEAR(f.fecha)' => $year, 
              'f.descripcion' => 'puntualidad'
            )
        );
        $this->db->order_by('f.fecha', 'desc');
        //$this->db->group_by('f.fecha');
        $query = $this->db->get('fastfile f');
        return $query->num_rows() > 0 ? $query->result() : array();
    }

    function getAsistenciaAnual($email,$year) {
        $this->db->select('f.id, f.idPersona, f.fecha, f.descripcion, f.valor, p.idPersona, p.nombres, p.apellidoPaterno, p.apellidoMaterno, p.emailUsers');
        $this->db->join('persona p','f.idPersona=p.idPersona','inner');
        $this->db->where(array('p.emailUsers' => $email, 'YEAR(f.fecha)' => $year, 'f.descripcion' => 'asistencia'));
        $this->db->order_by('f.fecha', 'desc');
        //$this->db->group_by('f.fecha');
        $query = $this->db->get('fastfile f');
        return $query->num_rows() > 0 ? $query->result() : array();
    }

    function getPuntualidadAnual($email,$year) {
        $this->db->select('f.id, f.idPersona, f.fecha, f.descripcion, f.valor, p.idPersona, p.nombres, p.apellidoPaterno, p.apellidoMaterno, p.emailUsers');
        $this->db->join('persona p','f.idPersona=p.idPersona','inner');
        $this->db->where(array('p.emailUsers' => $email, 'YEAR(f.fecha)' => $year, 'f.descripcion' => 'puntualidad'));
        $this->db->order_by('f.fecha', 'desc');
        //$this->db->group_by('f.fecha');
        $query = $this->db->get('fastfile f');
        return $query->num_rows() > 0 ? $query->result() : array();
    }
  
    function ConsultInfoUser($email) {
        $this->db->select('p.idPersona, p.nombres, p.apellidoPaterno, p.apellidoMaterno, p.emailUsers');
        $this->db->where('p.emailUsers', $email);
        $query = $this->db->get('persona p');
        return $query->num_rows() > 0 ? $query->result() : array(); 
    }
  
    function ConsultAsistencia($email) {
        $this->db->select('f.id, f.idPersona, f.fecha, f.descripcion, f.valor, p.idPersona, p.nombres, p.apellidoPaterno, p.apellidoMaterno, p.emailUsers');
        $this->db->join('persona p','f.idPersona=p.idPersona','inner');
        $this->db->where(array('p.emailUsers' => $email, 'f.descripcion' => 'asistencia'));
        $this->db->order_by('f.fecha', 'desc');
        //$this->db->group_by('f.fecha');
        $query = $this->db->get('fastfile f');
        return $query->num_rows() > 0 ? $query->result() : array(); 
    }
  
    function ConsultPuntualidad($email) {
        $this->db->select('f.id, f.idPersona, f.fecha, f.descripcion, f.valor, p.idPersona, p.nombres, p.apellidoPaterno, p.apellidoMaterno, p.emailUsers');
        $this->db->join('persona p','f.idPersona=p.idPersona','inner');
        $this->db->where(array('p.emailUsers' => $email, 'f.descripcion' => 'puntualidad'));
        $this->db->order_by('f.fecha', 'desc');
        //$this->db->group_by('f.fecha');
        $query = $this->db->get('fastfile f');
        return $query->num_rows() > 0 ? $query->result() : array(); 
    }

    //reporteAsistencias
     function getAsistenciaReporte($date,$descripcion) {
        $this->db->select('f.idPersona, p.nombres, p.apellidoPaterno, p.apellidoMaterno, pu.idPuesto, pu.personaPuesto, ca.idColaboradorArea, ca.colaboradorArea, f.fecha, f.descripcion');
        $this->db->join('persona p','f.idPersona=p.idPersona','inner');
        $this->db->join('personapuesto pu','p.idPersonaPuesto=pu.idPuesto','inner');
        $this->db->join('colaboradorarea ca','p.idColaboradorArea=ca.idColaboradorArea','inner');
        $this->db->where(array('DATE(f.fecha)' => $date, 'f.descripcion' => $descripcion));
        $this->db->order_by('f.fecha', 'asc');
        $this->db->group_by('f.idPersona');
        $query = $this->db->get('fastfile f');
        return $query->num_rows() > 0 ? $query->result() : array();
    }
    //reporte de asistencias quincenal
    function getAsistenciaQuincenalReporte($dateIncial, $dateFinal,$descripcion){
    	$respuesta=array();
    	$sql="select f.idPersona, p.nombres, p.apellidoPaterno, p.apellidoMaterno,pu.idPuesto, pu.personaPuesto,ca.idColaboradorArea, ca.colaboradorArea, f.fecha, f.descripcion, f.comentario from fastfile f left join persona p on f.idPersona=p.idPersona left join personapuesto pu on p.idPersonaPuesto=pu.idPuesto  left join colaboradorarea ca on p.idColaboradorArea=ca.idColaboradorArea  where DATE(f.fecha) >= '".$dateIncial."'  and DATE(f.fecha) <= '".$dateFinal."' and f.descripcion='".$descripcion."' order by f.idPersona asc, f.fecha asc;";
    $respuesta=$this->db->query($sql)->result();
    return $respuesta;
    }

    function getVacaionesReporte($dateIncial, $dateFinal,$descripcion){
    	$respuesta=array();
    	$sql="select f.idPersona, p.nombres, p.apellidoPaterno, p.apellidoMaterno,pu.idPuesto, pu.personaPuesto,ca.idColaboradorArea, ca.colaboradorArea, f.fecha, f.descripcion, f.valor, f.comentario from fastfile f left join persona p on f.idPersona=p.idPersona left join personapuesto pu on p.idPersonaPuesto=pu.idPuesto  left join colaboradorarea ca on p.idColaboradorArea=ca.idColaboradorArea where DATE(f.fecha) >= '".$dateIncial."'  and DATE(f.fecha) <= '".$dateFinal."' and f.descripcion='".$descripcion."' order by f.idPersona asc, f.fecha asc;";
    $respuesta=$this->db->query($sql)->result();
    return $respuesta;
    }

    function getNombresColaboradores($permiso){
	
    	if($permiso==null){
    		$sql='select p.idPersona as id, concat(p.nombres," " ,p.apellidoPaterno," " ,p.apellidoMaterno) as nombre, pp.idPuesto, pp.personaPuesto,c.idColaboradorArea, c.colaboradorArea, p.entradaLunes, p.salidaLunes, p.entradaMartes, p.salidaMartes, p.entradaMiercoles, p.salidaMiercoles, p.entradaJueves, p.salidaJueves, p.entradaViernes, p.salidaViernes, p.entradaSabado, p.salidaSabado from personapuesto pp left join colaboradorarea c on c.idColaboradorArea=pp.idColaboradorArea left join persona p on p.idPersona=pp.idPersona where pp.statusPuesto=1 and pp.idPuesto!=1 and pp.idPuesto!=98 and p.idPersona='.$this->tank_auth->get_idPersona().' ORDER BY `p`.`idPersona`';
    		  $datos=$this->db->query($sql)->result();
    		  $respuesta=array();
			  $idPadre='';  
			  array_push($respuesta, $datos[0]);
			  if((count($datos))>0){
			    $consulta='select p.idPersona as id, concat(p.nombres," " ,p.apellidoPaterno," " ,p.apellidoMaterno) as nombre, pp.idPuesto, pp.personaPuesto,c.idColaboradorArea, c.colaboradorArea, p.entradaLunes, p.salidaLunes, p.entradaMartes, p.salidaMartes, p.entradaMiercoles, p.salidaMiercoles, p.entradaJueves, p.salidaJueves, p.entradaViernes, p.salidaViernes, p.entradaSabado, p.salidaSabado from personapuesto pp left join colaboradorarea c on c.idColaboradorArea=pp.idColaboradorArea left join persona p on p.idPersona=pp.idPersona where pp.statusPuesto=1 and pp.idPuesto!=1 and pp.idPuesto!=98 and p.idPersona is not null  and pp.padrePuesto='.$datos[0]->idPuesto.' ORDER BY `p`.`idPersona`';			       
			    $datos=$this->db->query($consulta)->result();    
			    foreach($datos as $key => $value) {
					array_push($respuesta, $value);
					$consulta2='select p.idPersona as id, concat(p.nombres," " ,p.apellidoPaterno," " ,p.apellidoMaterno) as nombre, pp.idPuesto, pp.personaPuesto,c.idColaboradorArea, c.colaboradorArea, p.entradaLunes, p.salidaLunes, p.entradaMartes, p.salidaMartes, p.entradaMiercoles, p.salidaMiercoles, p.entradaJueves, p.salidaJueves, p.entradaViernes, p.salidaViernes, p.entradaSabado, p.salidaSabado from personapuesto pp left join colaboradorarea c on c.idColaboradorArea=pp.idColaboradorArea left join persona p on p.idPersona=pp.idPersona where pp.statusPuesto=1 and pp.idPuesto!=1 and pp.idPuesto!=98 and p.idPersona is not null  and pp.padrePuesto='.$value->idPuesto.' ORDER BY `p`.`idPersona`';			       
					$datos2=$this->db->query($consulta2)->result();
					if(count($datos2)>0){    
					foreach($datos2 as $key2 => $value2) {
						array_push($respuesta, $value2);
						$consulta3='select p.idPersona as id, concat(p.nombres," " ,p.apellidoPaterno," " ,p.apellidoMaterno) as nombre, pp.idPuesto, pp.personaPuesto,c.idColaboradorArea, c.colaboradorArea, p.entradaLunes, p.salidaLunes, p.entradaMartes, p.salidaMartes, p.entradaMiercoles, p.salidaMiercoles, p.entradaJueves, p.salidaJueves, p.entradaViernes, p.salidaViernes, p.entradaSabado, p.salidaSabado from personapuesto pp left join colaboradorarea c on c.idColaboradorArea=pp.idColaboradorArea left join persona p on p.idPersona=pp.idPersona where pp.statusPuesto=1 and pp.idPuesto!=1 and pp.idPuesto!=98 and p.idPersona is not null  and pp.padrePuesto='.$value2->idPuesto.' ORDER BY `p`.`idPersona`';			       
						$datos3=$this->db->query($consulta3)->result();
						if(count($datos3)>0){    
						foreach($datos3 as $key3 => $value3) {
							array_push($respuesta, $value3);
						}
						}
					}
					}
				}
			    
			  }

			  return $respuesta;

    }else{
    	$sql="select p.idPersona as id, concat(p.nombres,' ' ,p.apellidoPaterno,' ' ,p.apellidoMaterno) as nombre, pp.idPuesto, pp.personaPuesto,c.idColaboradorArea, c.colaboradorArea, p.entradaLunes, p.salidaLunes, p.entradaMartes, p.salidaMartes, p.entradaMiercoles, p.salidaMiercoles, p.entradaJueves, p.salidaJueves, p.entradaViernes, p.salidaViernes, p.entradaSabado, p.salidaSabado from personapuesto pp left join colaboradorarea c on c.idColaboradorArea=pp.idColaboradorArea left join persona p on p.idPersona=pp.idPersona where pp.statusPuesto=1 and pp.idPuesto!=1 and pp.idPuesto!=98 and p.idPersona is not null  ORDER BY `p`.`idPersona`";
    	$respuesta=$this->db->query($sql)->result();
    	return $respuesta;
	}
    }
	function getColaboradoresEvaluacion($permiso){
    	if($permiso==null){
    		$sql='select p.idPersona as id, concat(p.nombres," " ,p.apellidoPaterno," " ,p.apellidoMaterno) as nombre, pp.idPuesto, pp.personaPuesto,c.idColaboradorArea, c.colaboradorArea, p.entradaLunes, p.salidaLunes, p.entradaMartes, p.salidaMartes, p.entradaMiercoles, p.salidaMiercoles, p.entradaJueves, p.salidaJueves, p.entradaViernes, p.salidaViernes, p.entradaSabado, p.salidaSabado from personapuesto pp left join colaboradorarea c on c.idColaboradorArea=pp.idColaboradorArea left join persona p on p.idPersona=pp.idPersona where pp.statusPuesto=1 and pp.idPuesto!=1 and pp.idPuesto!=98 and p.idPersona='.$this->tank_auth->get_idPersona().' ORDER BY `p`.`idPersona`';
    		  $datos=$this->db->query($sql)->result();
    		  $respuesta=array();
			  $idPadre='';  
			  array_push($respuesta, $datos[0]);
			  if((count($datos))>0){
			    $consulta='select p.idPersona as id, concat(p.nombres," " ,p.apellidoPaterno," " ,p.apellidoMaterno) as nombre, pp.idPuesto, pp.personaPuesto,c.idColaboradorArea, c.colaboradorArea, p.entradaLunes, p.salidaLunes, p.entradaMartes, p.salidaMartes, p.entradaMiercoles, p.salidaMiercoles, p.entradaJueves, p.salidaJueves, p.entradaViernes, p.salidaViernes, p.entradaSabado, p.salidaSabado from personapuesto pp left join colaboradorarea c on c.idColaboradorArea=pp.idColaboradorArea left join persona p on p.idPersona=pp.idPersona where pp.statusPuesto=1 and pp.idPuesto!=1 and pp.idPuesto!=98 and p.idPersona is not null  and pp.padrePuesto='.$datos[0]->idPuesto.' ORDER BY `p`.`idPersona`';			       
			    $datos=$this->db->query($consulta)->result();    
			    foreach($datos as $key => $value) {
					array_push($respuesta, $value);
				}			    
			  }
			  return $respuesta;
    }else{
    	$sql="select p.idPersona as id, concat(p.nombres,' ' ,p.apellidoPaterno,' ' ,p.apellidoMaterno) as nombre, pp.idPuesto, pp.personaPuesto,c.idColaboradorArea, c.colaboradorArea, p.entradaLunes, p.salidaLunes, p.entradaMartes, p.salidaMartes, p.entradaMiercoles, p.salidaMiercoles, p.entradaJueves, p.salidaJueves, p.entradaViernes, p.salidaViernes, p.entradaSabado, p.salidaSabado from personapuesto pp left join colaboradorarea c on c.idColaboradorArea=pp.idColaboradorArea left join persona p on p.idPersona=pp.idPersona where pp.statusPuesto=1 and pp.idPuesto!=1 and pp.idPuesto!=98 and p.idPersona is not null  ORDER BY `p`.`idPersona`";
    	$respuesta=$this->db->query($sql)->result();
    	return $respuesta;
	}
    }

    function getColaboradoresCordi(){
    	//$sql="select * FROM `personapuesto` WHERE (`email` IS NOT NULL) AND (`nivelPuesto`=3 or `nivelPuesto`=4)";
    	$sql="select * FROM `personapuesto` WHERE (`email` IS NOT NULL) AND `statusPuesto`=1";
    	$respuesta=$this->db->query($sql)->result();
    	return $respuesta;
    }

function getColaboradoresSubordinados($idPuesto){
	    	$consulta='select p.idPersona as id, concat(p.nombres," " ,p.apellidoPaterno," " ,p.apellidoMaterno) as nombre, pp.idPuesto, pp.personaPuesto,c.idColaboradorArea, c.colaboradorArea, p.entradaLunes, p.salidaLunes, p.entradaMartes, p.salidaMartes, p.entradaMiercoles, p.salidaMiercoles, p.entradaJueves, p.salidaJueves, p.entradaViernes, p.salidaViernes, p.entradaSabado, p.salidaSabado from personapuesto pp left join colaboradorarea c on c.idColaboradorArea=pp.idColaboradorArea left join persona p on p.idPersona=pp.idPersona where pp.statusPuesto=1 and pp.idPuesto!=1 and pp.idPuesto!=98 and p.idPersona is not null  and pp.padrePuesto='.$idPuesto.' ORDER BY `p`.`idPersona`';
			       
			    $datos=$this->db->query($consulta)->result();    
			    return $datos;
}

function getReporteAniversario($username){
	$subordinados="";
		if($username=="CAPITALHUMANO@AGENTECAPITAL.COM"){
			$sql="select p.idPersona, pp.idPuesto from personapuesto pp left join persona p on p.idPersona=pp.idPersona where pp.statusPuesto=1 and pp.idPuesto!=1 and pp.idPuesto!=98 and p.idPersona is not null  ORDER BY `p`.`idPersona`";
			$subordinados=$this->db->query($sql)->result();
		}else{
			$sql='select p.idPersona, pp.idPuesto from personapuesto pp left join persona p on p.idPersona=pp.idPersona where pp.statusPuesto=1 and pp.idPuesto!=1 and pp.idPuesto!=98 and p.idPersona='.$this->tank_auth->get_idPersona().' ORDER BY `p`.`idPersona`';
			$datosColaborador=$this->db->query($sql)->result();
			$subordinados=array();
			array_push($subordinados, $datosColaborador[0]);
			if((count($datosColaborador))>0){
			  $consultaSub='select p.idPersona, pp.idPuesto from personapuesto pp left join persona p on p.idPersona=pp.idPersona where pp.statusPuesto=1 and pp.idPuesto!=1 and pp.idPuesto!=98 and p.idPersona is not null  and pp.padrePuesto='.$datosColaborador[0]->idPuesto.' ORDER BY `p`.`idPersona`';      
			  $datosSubordinados=$this->db->query($consultaSub)->result();   
			  if(count($datosSubordinados)>0){
				foreach($datosSubordinados as $key => $value) {
					array_push($subordinados, $value);
					$consultaSub2='select p.idPersona, pp.idPuesto from personapuesto pp left join persona p on p.idPersona=pp.idPersona where pp.statusPuesto=1 and pp.idPuesto!=1 and pp.idPuesto!=98 and p.idPersona is not null  and pp.padrePuesto='.$value->idPuesto.' ORDER BY `p`.`idPersona`';      
			  		$datosSubordinados2=$this->db->query($consultaSub2)->result();
					  if(count($datosSubordinados2)>0){
					  foreach($datosSubordinados2 as $key2 => $value2) {
						array_push($subordinados, $value2);
						$consultaSub3='select p.idPersona, pp.idPuesto from personapuesto pp left join persona p on p.idPersona=pp.idPersona where pp.statusPuesto=1 and pp.idPuesto!=1 and pp.idPuesto!=98 and p.idPersona is not null  and pp.padrePuesto='.$value2->idPuesto.' ORDER BY `p`.`idPersona`';      
			  		 	$datosSubordinados3=$this->db->query($consultaSub3)->result();
						   if(count($datosSubordinados3)>0){
							foreach($datosSubordinados3 as $key3 => $value3) {
							  array_push($subordinados, $value3);
						  }
						  }
					}
					}
				}
			  } 
			  
			}
		}
		if((count($subordinados))>0){
			$datos=array();
			foreach ($subordinados as $c => $k) {
				$consulta='SELECT 
								p.idPersona, 
								p.apellidoPaterno, 
								p.apellidoMaterno, 
								p.nombres, 
								DATE(p.fecAltaSistemPersona) AS fecha_alta, 
								TIMESTAMPDIFF(YEAR, p.fecAltaSistemPersona, CURDATE()) AS antiguedad,
								TIMESTAMPDIFF(MONTH, p.fecAltaSistemPersona, CURDATE()) % 12 AS mes_antiguedad,
								tv.dias,
								SUM(CASE WHEN v.aprobado = 0 THEN v.cantidad_dias ELSE 0 END) AS diasAprobados,
								(tv.dias - SUM(CASE WHEN v.aprobado = 0 THEN v.cantidad_dias ELSE 0 END)) AS diasFaltantes
							FROM persona p
							LEFT JOIN tabla_vacaciones_nueva tv 
								ON tv.anio = TIMESTAMPDIFF(YEAR, p.fecAltaSistemPersona, CURDATE())
							LEFT JOIN vacaciones v 
								ON v.idPersona = p.idPersona 
								AND v.antiguedad = TIMESTAMPDIFF(YEAR, p.fecAltaSistemPersona, CURDATE())
							WHERE p.idPersona = '.$k->idPersona.'
							GROUP BY 
								p.idPersona, 
								p.apellidoPaterno, 
								p.apellidoMaterno, 
								p.nombres, 
								p.fecAltaSistemPersona, 
								tv.dias;';
				$vacacionColaborador=$this->db->query($consulta)->result();
				if(count($vacacionColaborador)>0){
				array_push($datos, $vacacionColaborador[0]);
				}
			}
		}else{
			$datos="";
		}
		

		return $datos;
}

		function getReporteSolicitados($username){
			$subordinados="";
			if($username=="CAPITALHUMANO@AGENTECAPITAL.COM"){
				$sql="select p.idPersona, pp.idPuesto from personapuesto pp left join persona p on p.idPersona=pp.idPersona where pp.statusPuesto=1 and pp.idPuesto!=1 and pp.idPuesto!=98 and p.idPersona is not null  ORDER BY `p`.`idPersona`";
				$subordinados=$this->db->query($sql)->result();
			}else{
				$sql='select p.idPersona, pp.idPuesto from personapuesto pp left join persona p on p.idPersona=pp.idPersona where pp.statusPuesto=1 and pp.idPuesto!=1 and pp.idPuesto!=98 and p.idPersona='.$this->tank_auth->get_idPersona().' ORDER BY `p`.`idPersona`';
			$datosColaborador=$this->db->query($sql)->result();
			$subordinados=array();
			array_push($subordinados, $datosColaborador[0]);
			if((count($datosColaborador))>0){
			  $consultaSub='select p.idPersona, pp.idPuesto from personapuesto pp left join persona p on p.idPersona=pp.idPersona where pp.statusPuesto=1 and pp.idPuesto!=1 and pp.idPuesto!=98 and p.idPersona is not null  and pp.padrePuesto='.$datosColaborador[0]->idPuesto.' ORDER BY `p`.`idPersona`';      
			  $datosSubordinados=$this->db->query($consultaSub)->result();   
			  if(count($datosSubordinados)>0){
				foreach($datosSubordinados as $key => $value) {
					array_push($subordinados, $value);
					$consultaSub2='select p.idPersona, pp.idPuesto from personapuesto pp left join persona p on p.idPersona=pp.idPersona where pp.statusPuesto=1 and pp.idPuesto!=1 and pp.idPuesto!=98 and p.idPersona is not null  and pp.padrePuesto='.$value->idPuesto.' ORDER BY `p`.`idPersona`';      
			  		$datosSubordinados2=$this->db->query($consultaSub2)->result();
					  if(count($datosSubordinados2)>0){
					  foreach($datosSubordinados2 as $key2 => $value2) {
						array_push($subordinados, $value2);
						$consultaSub3='select p.idPersona, pp.idPuesto from personapuesto pp left join persona p on p.idPersona=pp.idPersona where pp.statusPuesto=1 and pp.idPuesto!=1 and pp.idPuesto!=98 and p.idPersona is not null  and pp.padrePuesto='.$value2->idPuesto.' ORDER BY `p`.`idPersona`';      
			  		 	$datosSubordinados3=$this->db->query($consultaSub3)->result();
						   if(count($datosSubordinados3)>0){
							foreach($datosSubordinados3 as $key3 => $value3) {
							  array_push($subordinados, $value3);
						  }
						  }
					}
					}
				}
			  } 
			  
			}
			}
			if((count($subordinados))>0){
				$datos=array();
				foreach ($subordinados as $c => $k) {
					$consulta='SELECT idPersona, nombre, antiguedad, cantidad_dias, DATE(fecha) AS fecha, fecha_salida, fecha_retorno, estado, correoJefeDirecto FROM `vacaciones` where idPersona='.$k->idPersona.' ORDER BY idPersona, fecha';
					$solicitudColaborador=$this->db->query($consulta)->result();
					if(count($solicitudColaborador)>0){
					$datos = array_merge($datos, $solicitudColaborador);
					}
				}
			}else{
				$datos="";
			}
			return $datos;			
}
//-------------------- //Edwin Marin [2025-04-23]
function searchReporteAniversario($tipo, $username, $dato1=null, $dato2=null){
	if($tipo==2){
		$datos=$this->getReporteAniversario($username);
		}else{
			$consulta='SELECT p.idPersona,p.apellidoPaterno,p.apellidoMaterno,p.nombres, DATE(p.fecAltaSistemPersona) AS fecha_alta, 
					TIMESTAMPDIFF(YEAR, p.fecAltaSistemPersona, CURDATE()) AS antiguedad, TIMESTAMPDIFF(MONTH, p.fecAltaSistemPersona, CURDATE()) % 12 AS mes_antiguedad,
					tv.dias, SUM(CASE WHEN v.aprobado = 0 THEN v.cantidad_dias ELSE 0 END) AS diasAprobados, (tv.dias - SUM(CASE WHEN v.aprobado = 0 THEN v.cantidad_dias ELSE 0 END)) AS diasFaltantes
				FROM persona p LEFT JOIN tabla_vacaciones_nueva tv  ON tv.anio = TIMESTAMPDIFF(YEAR, p.fecAltaSistemPersona, CURDATE())
				LEFT JOIN vacaciones v ON v.idPersona = p.idPersona AND v.antiguedad = TIMESTAMPDIFF(YEAR, p.fecAltaSistemPersona, CURDATE())
				WHERE p.idPersona = '.$dato1.' GROUP BY p.idPersona, p.apellidoPaterno,p.apellidoMaterno, p.nombres, p.fecAltaSistemPersona,	tv.dias;';
				$datos=$this->db->query($consulta)->result();
		}
		return $datos;
}
function searchReporteSolicitados($tipo, $dato1=null, $dato2=null){
	switch ($tipo){
        case 1:
			$consulta='SELECT idPersona, nombre, antiguedad, cantidad_dias, DATE(fecha) AS fecha, fecha_salida, fecha_retorno, estado, correoJefeDirecto FROM `vacaciones` where idPersona='.$dato1.' ORDER BY idPersona, fecha';
			$datos=$this->db->query($consulta)->result();
			break;
		case 2:
			$colaboradores=$this->devolverColaboradoresActivos();
			$datos=array();
			foreach ($colaboradores as $c => $k) {
				$consulta='SELECT idPersona, nombre, antiguedad, cantidad_dias, DATE(fecha) AS fecha, fecha_salida, fecha_retorno, estado, correoJefeDirecto FROM `vacaciones` where idPersona='.$k->idPersona.' AND DATE(fecha)="'.$dato1.'" ORDER BY idPersona, fecha';
				$solicitudColaborador=$this->db->query($consulta)->result();
				if(count($solicitudColaborador)>0){
				$datos = array_merge($datos, $solicitudColaborador);
				}
			}
			break;
		case 3:
			$consulta='SELECT idPersona, nombre, antiguedad, cantidad_dias, DATE(fecha) AS fecha, fecha_salida, fecha_retorno, estado, correoJefeDirecto FROM `vacaciones` where idPersona='.$dato1.' AND DATE(fecha)="'.$dato2.'" ORDER BY idPersona, fecha';
			$datos=$this->db->query($consulta)->result();
			break;
		}
		return $datos;
}
//----------
    function getPuestosColaboradores(){
    	$respuesta=array();
    	$sql="select idPuesto as id, personaPuesto as nombre FROM `personapuesto` WHERE statusPuesto=1 and idPuesto!=1 and idPuesto!=98";
    	$respuesta=$this->db->query($sql)->result();
    	return $respuesta;

    }

    function getAreaColaboradores(){
    	$respuesta=array();
    	$sql="select idColaboradorArea as id, colaboradorArea as nombre FROM `colaboradorarea` WHERE activo=1";
    	$respuesta=$this->db->query($sql)->result();
    	return $respuesta;
    }
//---------------------------------------------
    //Configuraciones: Tipo de Bajas
    function selectTB(){
        $this->db->select('*');
        $query = $this->db->get('tipos_bajas');
        return $query->num_rows() > 0 ? $query->result() : array();
    }

    function addTB($name){
    	$data = array (
    	  'nombre'=>$name,
    	  'created'=>date("Y-m-d H:i:s"),
    	  'creado_por'=>$this->tank_auth->get_idPersona()
    	);
    	return $this->db->insert('tipos_bajas',$data);
    }
    function updateTB($id,$name) {
    	$this->db->where('id',$id);
		$this->db->set('nombre',$name);
		$this->db->set('modified',date("Y-m-d H:i:s"));
		$this->db->set('modificado_por',$this->tank_auth->get_idPersona());
		return $this->db->update('tipos_bajas');
    }

    function deleteTB($id){
        $this->db->delete('tipos_bajas',array('id' => $id));
    }

    //------------------------------
function devolvercelOficina($idPersona){
  $consulta= "select `celOficina` FROM `persona` WHERE idpersona=".$idPersona;
  $response= $this->db->query($consulta)->result();
  return $response; 
}

//--------------------------------------------------------------------------------------------------------------
	//Módulo Sueldos (Se quitó del fastfile de Puestos)
	function consultSalaryRequest($id) {
		$sql = 'select pp.idPuesto, pp.personaPuesto, c.colaboradorArea, us.name_complete, us.email, pj.idPersona as idJefe, j.name_complete as jefe, cd.name_complete as creador, ss.* from personapuesto pp left join colaboradorarea c on c.idColaboradorArea=pp.idColaboradorArea left join persona p on p.idPersona=pp.idPersona left join users us on us.idPersona = pp.idPersona left join personapuesto pj on pj.idPuesto = pp.padrePuesto left join users j on j.idPersona = pj.idPersona left join solicitud_sueldo ss on ss.empleado_id = pp.idPersona left join users cd on cd.idPersona = ss.creado_por where pp.statusPuesto=1 and ss.empleado_id '.$id.' order by ss.id desc';
		$query = $this->db->query($sql)->result();
		return $query;
	}

	function consultRequestHistory($id) {
		$query = $this->db->query('SELECT ss.*, us.name_complete, us.email FROM solicitud_sueldo_seguimiento ss INNER JOIN users us ON us.idPersona = ss.empleado_id WHERE solicitud_sueldo_id = '.$id);
		return $query->result();
	}

	function updateStatusRequest($id,$data) {
		$this->db->where('id',$id);
		$query = $this->db->update('solicitud_sueldo',$data);
		return $query;
	}

	function insertTracingRequest($data) {
		$query = $this->db->insert('solicitud_sueldo_seguimiento',$data);
		return $this->db->insert_id();
	}

//--------------------------------------------------------------------------------------------------------------
	//Programa SuperEstrella (Información para el fastfile de Puestos) - [Suemy][2024-02-23]
	function getMonthAudit($idPersona,$month,$year) {
		$query = $this->db->query('select id, idPersona, trimestre, calificacion, registro as fecha from calificacion_auditoria where idPersona = '.$idPersona.' and month(registro) = '.$month.' and year(registro) = '.$year);
		return $query->result();
	}

	function getMonthTraining($idPersona,$month,$year) {
		$data = array();
		$monthS = $month;
		$accumulated = 0;
		$points = 0;
		$show = "no";
		$quarterly = "";
		$query = "";
		switch ($month) {
			case "3":
				$monthS = 03;
				$quarterly = "Primer";
				$query = $this->db->query('SELECT * FROM cal_events_json WHERE YEAR(fecha_inicio) = '.$year.' AND MONTH(fecha_inicio) BETWEEN 01 AND 03')->result();
				break;
			case "6":
				$monthS = 06;
				$quarterly = "Segundo";
				$query = $this->db->query('SELECT * FROM cal_events_json WHERE YEAR(fecha_inicio) = '.$year.' AND MONTH(fecha_inicio) BETWEEN 04 AND 06')->result();
				break;
			case "9":
				$monthS = 09;
				$quarterly = "Tercero";
				$query = $this->db->query('SELECT * FROM cal_events_json WHERE YEAR(fecha_inicio) = '.$year.' AND MONTH(fecha_inicio) BETWEEN 07 AND 09')->result();
				break;
			case "12":
				$monthS = 12;
				$quarterly = "Cuarto";
				$query = $this->db->query('SELECT * FROM cal_events_json WHERE YEAR(fecha_inicio) = '.$year.' AND MONTH(fecha_inicio) BETWEEN 10 AND 12')->result();
				break;
		}
		//---------- Fechas ----------
	    $dataDate = array();
    	$date = $this->rangeMonth();
	    //$date = array("dateI" => $day_first, "dateF" => $day_end);
	    $dayI = date('Y-m-d',strtotime($date['dateI']."- 1 days"));
	    $days = (strtotime($dayI)-strtotime($date['dateF']))/86400;
		$days = abs($days); 
		$days = floor($days);
		for ($i=0;$i<$days;$i++) {
  	  		$dayI = date('Y-m-d',strtotime($dayI."+ 1 days"));
  	  		$dMonth = date('m',strtotime(date($dayI)));
  	  		$dNameDay = date('N',strtotime(date($dayI)));
  	  		if ($dNameDay >= 1 && $dNameDay <= 5) {
  	  			array_push($dataDate, $dayI);
  	  		}
  	  	}
		if (strtotime(date('Y-m-d')) >= strtotime(end($dataDate))) { $show = "yes"; }

  	  	//if (date('Y-m-d') == "2024-03-01") {
			if (!empty($query)) {
				$email = $this->db->query('SELECT email FROM users WHERE idPersona = '.$idPersona)->row()->email;
				foreach ($query as $val) {
					$guest = $this->db->query('SELECT * FROM invitados_eventos WHERE tipo_invitado = "interno" AND id_evento = "'.$val->id_cal.'" AND correo_lectronico = "'.$email.'"')->result();
					foreach ($guest as $row) {
						$register = "";
						if ($row->estado == "aceptado") {
							$register = $this->db->query('SELECT cg.estado FROM capacita_registros cg INNER JOIN capacita_relacion_invitado_registro cr ON cr.idRegistro = cg.idRegistro INNER JOIN invitados_eventos ev ON ev.id_invitado = cr.id_invitado WHERE ev.id_invitado = '.$row->id_invitado)->row();
						}
						$register = !empty($register) ? $register->estado : "";
					}
					$hours = (strtotime($val->hora_final) - strtotime($val->hora_inicio)) / 3600;
					if ($register == "activo") {
						$accumulated = $accumulated + $hours;
					}
				}
				//Cálculo de puntos por trimestre
				if ($accumulated >= 6) {
					$points = 18;
				}
				else if ($accumulated == 5) {
					$points = 3;
				}
			}
			$add['acumulado'] = $accumulated;
			//$add['fechas'] = $dataDate;
			$add['fecha'] = end($dataDate);
			$add['mostrar'] = $show;
			$add['puntos'] = $points;
			$add['trimestre'] = $quarterly;
			array_push($data, $add);
		//}
		$data = json_decode(json_encode($data));
		return $data;
	}

	function getAsistEvent($idPersona,$month,$year,$sql = null) { //Modificado [Suemy][2024-04-26]
		//$data = array("idPersona" => $idPersona, "mes" => $month, "año" => $year);
		$data = array();
		$email = $this->db->query('SELECT email FROM users WHERE idPersona = '.$idPersona)->row()->email;
		$query = $this->db->query('SELECT ej.id_cal, ej.titulo, ej.fecha_inicio AS fecha, ie.id_invitado, cr.estado FROM cal_events_json ej INNER JOIN invitados_eventos ie ON ie.id_evento = ej.id_cal INNER JOIN capacita_relacion_invitado_registro ci ON ci.id_invitado = ie.id_invitado INNER JOIN capacita_registros cr ON ci.idRegistro = cr.idRegistro WHERE  ie.correo_lectronico = "'.$email.'" AND MONTH(ej.fecha_inicio) = '.$month.' AND YEAR(ej.fecha_inicio) = '.$year.' '.$sql)->result();
		$external = $this->db->query('SELECT * FROM capacita_externo WHERE idPersona = '.$idPersona.' AND MONTH(date) = '.$month.' AND YEAR(date) = '.$year)->result();
		foreach ($query as $val) {
			$add['titulo'] = $val->titulo;
			$add['fecha'] = $val->fecha;
			$add['estado'] = $val->estado;
			$add['tipo'] = "Interna";
			array_push($data, $add);
		}
		foreach ($external as $row) {
			$add['titulo'] = $row->title;
			$add['fecha'] = $row->date;
			$add['estado'] = "activo";
			$add['tipo'] = "Externa";
			array_push($data, $add);
		}
		//$query = stdClass Object
		//$data = array
		$data = json_decode(json_encode($data)); //Ordenar array por fechas
		return $data;
	}

  	function rangeMonth(){
    	$date = new DateTime('');
    	$Date = $date->format('Y-m-d');
    	$first = $date->modify('first day of this month');
    	$day_first = $first->format('Y-m-d');
    	$end = $date->modify("last day of this month");
    	$day_end = $end->format('Y-m-d');
	    return Array("dateI" => $day_first, "dateF" => $day_end);
	}

//-----------------------------------------------------------		
function vendedoresActivosPorCoordinador($emailCoordinador)
{
	$consulta='select p.apellidoPaterno,p.apellidoMaterno,p.nombres,u.email,u.idPersona,u.IDVend from persona p left join users u on u.idPersona=p.idPersona where u.banned=0 and u.activated=1 and p.userEmailCreacion="'.$emailCoordinador.'" order by p.apellidoPaterno';

	return $this->db->query($consulta)->result();
}
public function __destruct()
{


}

}
