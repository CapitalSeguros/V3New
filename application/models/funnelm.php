<?php
class funnelM extends CI_Model{
	
	public function __Construct(){
		parent::__Construct();
		//$this->CI =& get_instance();
	}
 //-----------------------------------------------
function devuelvefunnels($user){
  //$datos=$this->db->query('select * from funnel where eliminada="F"');  

$datos=$this->db->query('select *,
(select count(EdoActual) from puntaje where cast(FechaRegistro as date)>concat(funnel.anio,"-",funnel.intMes,"-","01") 
and cast(FechaRegistro as date)<concat(funnel.anio,"-",funnel.intMes,"-","31")
and puntaje.Usuario=funnel.Usuario and EdoActual="PERFILADO") as perfilado,
(select count(EdoActual) from puntaje where cast(FechaRegistro as date)>concat(funnel.anio,"-",funnel.intMes,"-","01") 
and cast(FechaRegistro as date)<concat(funnel.anio,"-",funnel.intMes,"-","31")
and puntaje.Usuario=funnel.Usuario and (EdoActual="CONTACTADO" || EdoActual="REGISTRADO")) as contactado,
(select count(EdoActual) from puntaje where cast(FechaRegistro as date)>concat(funnel.anio,"-",funnel.intMes,"-","01") 
and cast(FechaRegistro as date)<concat(funnel.anio,"-",funnel.intMes,"-","31")
and puntaje.Usuario=funnel.Usuario and EdoActual="COTIZADO") as cotizado,
(select count(EdoActual) from puntaje where cast(FechaRegistro as date)>concat(funnel.anio,"-",funnel.intMes,"-","01") 
and cast(FechaRegistro as date)<concat(funnel.anio,"-",funnel.intMes,"-","31")
and puntaje.Usuario=funnel.Usuario and EdoActual="PAGADO") as pagado,
(select count(EdoActual) from puntaje where cast(FechaRegistro as date)>concat(funnel.anio,"-",funnel.intMes,"-","01") 
and cast(FechaRegistro as date)<concat(funnel.anio,"-",funnel.intMes,"-","31")
and puntaje.Usuario=funnel.Usuario and (EdoActual="PAGADO" || EdoActual="REGISTRADO" || EdoActual="COTIZADO" || EdoActual="CONTACTADO" || EdoActual="PERFILADO" || EdoActual="DIMENSION")) as dimension
 from funnel where eliminada="F" and funnel.usuario="'.$user.'"');
   return $datos->result();
}
//-----------------------------------------------
function devuelveFunnel($user,$id){
$datos=$this->db->query('select *,
(select count(EdoActual) from puntaje where cast(FechaRegistro as date)>concat(funnel.anio,"-",funnel.intMes,"-","01") 
and cast(FechaRegistro as date)<concat(funnel.anio,"-",funnel.intMes,"-","31")
and puntaje.Usuario=funnel.Usuario and EdoActual="PERFILADO") as perfilado,
(select count(EdoActual) from puntaje where cast(FechaRegistro as date)>concat(funnel.anio,"-",funnel.intMes,"-","01") 
and cast(FechaRegistro as date)<concat(funnel.anio,"-",funnel.intMes,"-","31")
and puntaje.Usuario=funnel.Usuario and (EdoActual="CONTACTADO" || EdoActual="REGISTRADO")) as contactado,
(select count(EdoActual) from puntaje where cast(FechaRegistro as date)>concat(funnel.anio,"-",funnel.intMes,"-","01") 
and cast(FechaRegistro as date)<concat(funnel.anio,"-",funnel.intMes,"-","31")
and puntaje.Usuario=funnel.Usuario and EdoActual="COTIZADO") as cotizado,
(select count(EdoActual) from puntaje where cast(FechaRegistro as date)>concat(funnel.anio,"-",funnel.intMes,"-","01") 
and cast(FechaRegistro as date)<concat(funnel.anio,"-",funnel.intMes,"-","31")
and puntaje.Usuario=funnel.Usuario and EdoActual="PAGADO") as pagado,
(select count(EdoActual) from puntaje where cast(FechaRegistro as date)>concat(funnel.anio,"-",funnel.intMes,"-","01") 
and cast(FechaRegistro as date)<concat(funnel.anio,"-",funnel.intMes,"-","31")
and puntaje.Usuario=funnel.Usuario and (EdoActual="PAGADO" || EdoActual="REGISTRADO" || EdoActual="COTIZADO" || EdoActual="CONTACTADO" || EdoActual="PERFILADO" || EdoActual="DIMENSION")) as dimension
 from funnel where eliminada="F" and funnel.usuario="'.$user.'" && funnel.id='.$id);
   return $datos->result();

}
//------------------------------------------------
function devuelveColumnas(){
 $datos=$this->db->query("SHOW COLUMNS FROM funnel;");  
   return $datos->result();	
}
//------------------------------------------------
function insertafunnel($valores){
	
	 $this->db->insert('funnel',$valores);
$last=$this->db->insert_id();
return  $last;

 }
 //------------------------------------------------
 function cancelaFunnel($valor){
 	$data['eliminada']="T";
 	$this->db->where('id',$valor);
 	$this->db->update('funnel',$data);

 }
 //-----------------------------------------------
 function fechasClientesPorMes($array)
 {

 	if(isset($array['user'])){
     $consulta='select distinct(concat(YEAR(cc.fechaActualizacion),"-",MONTH(cc.fechaActualizacion))),(MONTH(cc.fechaActualizacion)) as mes,(YEAR(cc.fechaActualizacion)) as anio,(YEAR(NOW())) as anioActual,
(MONTH(NOW())) as mesActual from clientes_actualiza cc where (cc.EstadoActual!="ELIMINADO" and cc.EstadoActual!="SIN VENTA") and cc.Usuario="'.$array['user'].'" order by anio desc,mes desc';
 	}
 	else{
     $consulta='select distinct(concat(YEAR(cc.fechaActualizacion),"-",MONTH(cc.fechaActualizacion))),(MONTH(cc.fechaActualizacion)) as mes,(YEAR(cc.fechaActualizacion)) as anio,(YEAR(NOW())) as anioActual,
(MONTH(NOW())) as mesActual from clientes_actualiza cc where (cc.EstadoActual!="ELIMINADO" and cc.EstadoActual!="SIN VENTA") and cc.Usuario="'.$this->tank_auth->get_usermail().'" order by anio desc,mes desc ';
 	}
 	
 	return $this->db->query($consulta)->result();
   

 }
 //-----------------------------------------------
 function clientesXmes($array){
	$anio=date("Y");
  	$mes=date("m");
  	$user="";

  $filtro='';
  $consulta='';

 	if(isset($array['Usuario']))
    {
      $user=$array['Usuario'];
       $idVend=$this->personamodelo->devolverUsersPorEmail($array['Usuario'])->IDVend;
    }
 	else
    {
      $user=$this->tank_auth->get_usermail();
      $idVend=$this->tank_auth->get_IDVend();
    }

   if($array['mes']>12)
   {
     $consulta='select * from clientes_actualiza cc  ';
     $filtro.=' where Usuario="'.$user.'"';
 }
  else
   {
   	 $consulta='select * from clientes_actualiza cc where YEAR(cc.fechaActualizacion)='.$array['anio'].' && MONTH(cc.fechaActualsizacion)='.$array['mes'];
    	$filtro.='where YEAR(cc.fechaActualizacion)='.$array['anio'].' && MONTH(cc.fechaActualizacion)='.$array['mes'].' && Usuario="'.$user.'"';
   }
 	
  
  /*DIMENSION*/
   $consulta='select cc.* from clientes_actualiza cc '; 
 	 $datos['DIMENSION']=$this->db->query($consulta.$filtro.' && EstadoActual="DIMENSION"')->result();

/*PERFILADOS*/
   $consulta='select cc.*,"1" estaDimension from clientes_actualiza cc ';
 	 $datos['PERFILADO']=$this->db->query($consulta.$filtro.' && EstadoActual="PERFILADO"')->result();

/*REGISTRADOS*/
  $consulta='select cc.*,"1" estaDimension,((select count(IDCliente) from puntaje p where p.IDCliente=IDCli and p.EdoActual="PERFILADO" )) as estaPerfilado from clientes_actualiza cc ';
 	$datos['REGISTRADO']=$this->db->query($consulta.$filtro.' && EstadoActual="REGISTRADO"')->result();


/*COTIZADOS*/
  $consulta='select cc.*,"1" estaDimension,((select count(IDCliente) from puntaje p where p.IDCliente=IDCli and p.EdoActual="PERFILADO" )) as estaPerfilado,((select count(IDCliente) from puntaje p where p.IDCliente=IDCli and p.EdoActual="CONTACTADO" )) as estaContactado from clientes_actualiza cc ';
  
 	$datos['COTIZADO']=$this->db->query($consulta.$filtro.' && EstadoActual="COTIZADO" && estaEmitido=0')->result();


/*EMITIDOS*/
$consulta='select cc.*,"1" estaDimension,((select count(IDCliente) from puntaje p where p.IDCliente=IDCli and p.EdoActual="PERFILADO" )) as estaPerfilado,((select count(IDCliente) from puntaje p where p.IDCliente=IDCli and p.EdoActual="CONTACTADO" )) as estaContactado,((select count(IDCliente) from puntaje p where p.IDCliente=IDCli and p.EdoActual="COTIZADO" )) as estaCoTIZADO from clientes_actualiza cc ';   
 
 if($idVend>0)
 {
  $idSicasDocumentoArray=array();
  $idClienteActualizaArray=array();
   $con='select a.idSicas,a.IDCliClienteActualiza from actividades a where a.IDCliClienteActualiza!=0 and year(a.fechaCreacion)='.$array['anio'].' and month(a.fechaCreacion)='.$array['mes'].'  and a.tipoActividad in ("CapturaEmision","Emision") and a.IDVend='.$idVend;
  
   $actividadesEmitidas=$this->db->query($con)->result();
    
   foreach ($actividadesEmitidas as  $valEmitida) 
   {
     array_push($idSicasDocumentoArray,$valEmitida->idSicas);
     array_push($idClienteActualizaArray,$valEmitida->IDCliClienteActualiza);
   }
   $idSicasDocumentoString=implode($idSicasDocumentoArray,',');
   $idClienteActualizaString=implode($idClienteActualizaArray,',');

    $con='select * from clientes_actualiza where IDCli in ('.$idClienteActualizaString.')';

  $datos['EMITIDO']=$this->db->query($con)->result();//$this->db->query($consulta.' && EstadoActual="COTIZADO" && estaEmitido="1"')->result();


  $con='select distinct(e.documento),e.* from estadofinanciero e where e.IDDocto in ('.$idSicasDocumentoString.')';

  $idClienteActualizaPagadosArray=array();
  $idEstadoFinanciero=$this->db->query($con)->result();
  
   foreach ($idEstadoFinanciero as $valEF) 
   {
     foreach ($actividadesEmitidas as $valEmitida) 
     {
       if($valEF->IDDocto==$valEmitida->idSicas){array_push($idClienteActualizaPagadosArray,$valEmitida->IDCliClienteActualiza);}
     }
   }
     $idClienteActualizaPagadosString=implode($idClienteActualizaPagadosArray,',');
      if($idClienteActualizaPagadosString!=''){
      $con='select * from clientes_actualiza where IDCli in ('.$idClienteActualizaPagadosString.')';   
      $datos['PAGADO']=$this->db->query($con)->result();
     }
     else
     {
      $datos['PAGADO']=array();
     }

   
 }
 else
{ 
  $datos['EMITIDO']=$this->db->query($consulta.$filtro.'  && estaEmitido=1')->result();   
 	$datos['PAGADO']=$this->db->query($consulta.$filtro.' && EstadoActual="PAGADO"')->result();
 }
 	return $datos;
 }
 //-----------------------------------------------

                        
//Modificacion Miguel Jaime 25/marzo/2021
function clientesXmesX($array){
 $user="";
 if(isset($array['Usuario'])){
   $user=$array['Usuario'];
 }else{
   $user=$this->tank_auth->get_usermail();
 }
 $consulta="";
 
 if(($user=="DIRECTORGENERAL@AGENTECAPITAL.COM")||($user=="DIRECTORCOMERCIAL@AGENTECAPITAL.COM")){
    $consulta='select * from clientes_actualiza cc where YEAR(cc.fechaActualizacion)='.$array['anio'].' && MONTH(cc.fechaActualizacion)='.$array['mes'].'';
 }else{
   $consulta='select * from clientes_actualiza cc where YEAR(cc.fechaActualizacion)='.$array['anio'].' && MONTH(cc.fechaActualizacion)='.$array['mes'];
   $consulta.=' && Usuario="'.$user.'"';
 }

 $datos['DIMENSION']=$this->db->query($consulta.' && EstadoActual="DIMENSION"')->result();
 $datos['PERFILADO']=$this->db->query($consulta.' && EstadoActual="PERFILADO"')->result();
 $datos['REGISTRADO']=$this->db->query($consulta.' && EstadoActual="REGISTRADO"')->result();
 $datos['COTIZADO']=$this->db->query($consulta.' && EstadoActual="COTIZADO"')->result();
 $datos['COTIZADO_EMITIDO']=$this->db->query($consulta.' && EstadoActual="COTIZADO" && estaEmitido="1"')->result();
 $datos['PAGADO']=$this->db->query($consulta.' && EstadoActual="PAGADO"')->result();
 return $datos;
}
                        
                        
//Modificacion Miguel 10/02/2020
 function clientesSuspectos(){
   $mes=date('m');
   $year=date('Y');
   //Prospectos Dimension
   $sql="SELECT idCli from clientes_actualiza where EstadoActual='DIMENSION' AND MONTH(fechaActualizacion)='$mes' AND YEAR(fechaActualizacion)='$year'";
    return $this->db->query($sql)->result();
 }

 function clientesPefilados(){
     $mes=date('m');
     $year=date('Y');
     //Prospectos Perfilados
     $sql="SELECT idCli from clientes_actualiza where EstadoActual='PERFILADO' AND MONTH(fechaActualizacion)='$mes' AND YEAR(fechaActualizacion)='$year'";
    return $this->db->query($sql)->result();
 }

 function clientesContactados(){
     $mes=date('m');
     $year=date('Y');
     //Prospectos Contactado
     $sql="SELECT idCli from clientes_actualiza where EstadoActual='CONTACTADO' AND MONTH(fechaActualizacion)='$mes' AND YEAR(fechaActualizacion)='$year'";
    return $this->db->query($sql)->result();
 }


 function clientesCotizados(){
     $mes=date('m');
     $year=date('Y');
     //Prospectos Cotizado
     $sql="SELECT idCli from clientes_actualiza where EstadoActual='COTIZADO' AND estaEmitido=0 AND MONTH(fechaActualizacion)='$mes' AND YEAR(fechaActualizacion)='$year'";
     return $this->db->query($sql)->result();
 }
 function clientesEmision(){
     $mes=date('m');
     $year=date('Y');
     //Prospectos Cotizado
     $sql="SELECT idCli from clientes_actualiza where EstadoActual='COTIZADO' AND estaEmitido=1 AND MONTH(fechaActualizacion)='$mes' AND YEAR(fechaActualizacion)='$year'";
     return $this->db->query($sql)->result();
 }


 function clientesPagados(){
     $mes=date('m');
     $year=date('Y');
     //Prospectos Pagado
     $sql="SELECT idCli from clientes_actualiza where EstadoActual='PAGADO' AND MONTH(fechaActualizacion)='$mes' AND YEAR(fechaActualizacion)='$year'";
     return $this->db->query($sql)->result();
 }
 function prospectosMarketing($mes){
     $year=date('Y');
     $dimension="select * from clientes_actualiza where YEAR(fechaActualizacion)='$year' AND MONTH(fechaActualizacion)='$mes' AND leads!='' AND EstadoActual='SIN VENTA' AND Usuario!='TELEMARKETING@AGENTECAPITAL.COM'";
     $perfilado="select * from clientes_actualiza where YEAR(fechaActualizacion)='$year' AND MONTH(fechaActualizacion)='$mes' AND leads!='' AND EstadoActual='PERFILADO' AND Usuario!='TELEMARKETING@AGENTECAPITAL.COM'";
     $contactado="select * from clientes_actualiza where YEAR(fechaActualizacion)='$year' AND MONTH(fechaActualizacion)='$mes' AND leads!='' AND EstadoActual='CONTACTADO' AND Usuario!='TELEMARKETING@AGENTECAPITAL.COM'";
      $cotizado="select * from clientes_actualiza where YEAR(fechaActualizacion)='$year' AND MONTH(fechaActualizacion)='$mes' AND leads!='' AND EstadoActual='COTIZADO' AND Usuario!='TELEMARKETING@AGENTECAPITAL.COM'";
      $cotizado_emitido="select * from clientes_actualiza where YEAR(fechaActualizacion)='$year' AND MONTH(fechaActualizacion)='$mes' AND leads!='' AND EstadoActual='COTIZADO'  AND Usuario!='TELEMARKETING@AGENTECAPITAL.COM'AND estaEmitido=1";
      $pagado="select * from clientes_actualiza where YEAR(fechaActualizacion)='$year' AND MONTH(fechaActualizacion)='$mes' AND leads!='' AND EstadoActual='PAGADO' AND Usuario!='TELEMARKETING@AGENTECAPITAL.COM'";

     $datos['SIN_VENTA']=$this->db->query($dimension)->result();
     $datos['PERFILADO']=$this->db->query($perfilado)->result();
     $datos['CONTACTADO']=$this->db->query($contactado)->result();
     $datos['COTIZADO']=$this->db->query($cotizado)->result();
     $datos['COTIZADO_EMITIDO']=$this->db->query($cotizado_emitido)->result();
     $datos['PAGADO']=$this->db->query($pagado)->result();
     return $datos;
}

//**** Modificacion MJ 29/10



function funnel_landing($landing,$mes){
  $ct=0;
  $year=date('Y');
  if($landing=='Fianzas'){
    $sql="SELECT COUNT(*) as total FROM estadisticas_landing WHERE landing='Fianzas'  AND YEAR(fecha)='$year' AND MONTH(fecha)='$mes' GROUP BY fecha";
  }else{
    $sql="SELECT * FROM estadisticas_landing WHERE landing='Gmm' AND YEAR(fecha)='$year' AND MONTH(fecha)='$mes'"; 
  }
  $rs=$this->db->query($sql)->result();
  foreach ($rs as $row) {$ct++;}
  return $ct;
}

function funnel_landing_alcanzados($landing,$mes){
  $ct=0;
  $year=date('Y');
  if($landing=='Fianzas'){
   $sql="SELECT * FROM clientes_actualiza WHERE leads='http://www.fianzascapital.com.mx'  AND YEAR(fechaActualizacion)='$year' AND MONTH(fechaActualizacion)='$mes'";
  }else{
     $sql="SELECT * FROM clientes_actualiza WHERE leads='http://www.capitalsegurosgmm.com'  AND YEAR(fechaActualizacion)='$year' AND MONTH(fechaActualizacion)='$mes'";
  }
  $rs=$this->db->query($sql)->result();
  foreach ($rs as $row) {$ct++;}
  return $ct;
}

function funnel_landing_efectivos($landing,$mes){
  $ct=0;
  $year=date('Y');
  if($landing=='Fianzas'){
   $sql="SELECT * FROM clientes_actualiza WHERE leads='http://www.fianzascapital.com.mx'  AND YEAR(fechaActualizacion)='$year' AND MONTH(fechaActualizacion)='$mes' AND Usuario!='marketing@agentecapital.com'";
  }else{
     $sql="SELECT * FROM clientes_actualiza WHERE leads='http://www.capitalsegurosgmm.com'  AND YEAR(fechaActualizacion)='$year' AND MONTH(fechaActualizacion)='$mes' AND Usuario!='marketing@agentecapital.com'";
  }
  $rs=$this->db->query($sql)->result();
  foreach ($rs as $row) {$ct++;}
  return $ct;
}



//*************



  function prospectosFianzas($mes){
     $year=date('Y');
     $dimension="select * from clientes_actualiza where YEAR(fechaActualizacion)='$year' AND MONTH(fechaActualizacion)='$mes' AND leads='http://www.fianzascapital.com.mx' AND EstadoActual='SIN VENTA'";
     $perfilado="select * from clientes_actualiza where YEAR(fechaActualizacion)='$year' AND MONTH(fechaActualizacion)='$mes' AND leads='http://www.fianzascapital.com.mx' AND EstadoActual='PERFILADO'";
     $contactado="select * from clientes_actualiza where YEAR(fechaActualizacion)='$year' AND MONTH(fechaActualizacion)='$mes' AND leads='http://www.fianzascapital.com.mx' AND EstadoActual='CONTACTADO'";
      $cotizado="select * from clientes_actualiza where YEAR(fechaActualizacion)='$year' AND MONTH(fechaActualizacion)='$mes' AND leads='http://www.fianzascapital.com.mx' AND EstadoActual='COTIZADO'";
      $cotizado_emitido="select * from clientes_actualiza where YEAR(fechaActualizacion)='$year' AND MONTH(fechaActualizacion)='$mes' AND leads='http://www.fianzascapital.com.mx' AND EstadoActual='COTIZADO' AND estaEmitido=1";
      $pagado="select * from clientes_actualiza where YEAR(fechaActualizacion)='$year' AND MONTH(fechaActualizacion)='$mes' AND leads='http://www.fianzascapital.com.mx' AND EstadoActual='PAGADO'";

     $datos['SIN_VENTA']=$this->db->query($dimension)->result();
     $datos['PERFILADO']=$this->db->query($perfilado)->result();
     $datos['CONTACTADO']=$this->db->query($contactado)->result();
     $datos['COTIZADO']=$this->db->query($cotizado)->result();
     $datos['COTIZADO_EMITIDO']=$this->db->query($cotizado_emitido)->result();
     $datos['PAGADO']=$this->db->query($pagado)->result();
     return $datos;
}
//-----------------------
function prospectosAgentes($mes, $coor = null){ 
  $year=date('Y');
  //$no_contactado="select * from prospectos_agentes where YEAR(fecha)='$year' AND MONTH(fecha)='$mes' AND status='NO CONTACTADO'";
  //$contactado="select * from prospectos_agentes where YEAR(fecha)='$year' AND MONTH(fecha)='$mes' AND status='CONTACTADO'";
  //$proceso="select * from prospectos_agentes where YEAR(fecha)='$year' AND MONTH(fecha)='$mes' AND status='EN PROCESO'";
  //$descartado="select * from prospectos_agentes where YEAR(fecha)='$year' AND MONTH(fecha)='$mes' AND status='DESCARTADO'";
  
  $this->db->where("YEAR(fecha)", $year);
  $this->db->where("MONTH(fecha)", $mes);

  if(!empty($coor)){
    $this->db->where("asignado", $coor);
  }
  
  $query = $this->db->get("prospectos_agentes");
  $result = $query->num_rows() > 0 ? $query->result() : array();

  $datos['NO_CONTACTADO'] = array_values(array_filter($result, function($arr){ return $arr->status == "NO CONTACTADO"; }));
  $datos['CONTACTADO'] = array_values(array_filter($result, function($arr){ return $arr->status == "CONTACTADO"; }));
  $datos['EN_PROCESO'] = array_values(array_filter($result, function($arr){ return $arr->status == "EN PROCESO"; }));
  $datos['DESCARTADO'] = array_values(array_filter($result, function($arr){ return $arr->status == "DESCARTADO"; }));
  $datos['RECLUTADO'] = array_values(array_filter($result, function($arr){ return $arr->status == "RECLUTADO"; }));
  
  //$prospectives = 

  //$reclutado="select * from prospectos_agentes where YEAR(fecha)='$year' AND MONTH(fecha)='$mes' AND status='RECLUTADO'";
  //$datos['NO_CONTACTADO']=$this->db->query($no_contactado)->result();
  //$datos['CONTACTADO']=$this->db->query($contactado)->result();
  //$datos['EN_PROCESO']=$this->db->query($proceso)->result();
  //$datos['DESCARTADO']=$this->db->query($descartado)->result();
  //$datos['RECLUTADO']=$this->db->query($reclutado)->result();
  return $datos;
}
//-----------------------
//Dennis Castillo [2021-10-31]
function getProgressProspectives($array){ //3110

	$result = array();
	$result_ = array();
	foreach($array["EN_PROCESO"] as $type => $d_a){
		//foreach($d_a as $dd_a){

			$getProspectiveUser = $this->crmproyecto->getProspectiveAgentProgress($d_a->id);
			array_push($result, array("id" => $d_a->id, "data" => $getProspectiveUser));

			if(!empty($getProspectiveUser)){

				if($getProspectiveUser->avance == "induccion" || $getProspectiveUser->avance == "documento"){

					$getPesonalData = $this->personamodelo->buscaPersonaPorCampo($getProspectiveUser->idPersona, "nombres,apellidoPaterno,apellidoMaterno,fecAltaSistemPersona");
					$result_[strtoupper($getProspectiveUser->avance)][] = array(
						"name" => $getPesonalData->nombres." ".$getPesonalData->apellidoPaterno." ".$getPesonalData->apellidoMaterno,
						"date" => date("d-m-Y", strtotime($getPesonalData->fecAltaSistemPersona)),
					);
				}
			} else{
				$result_["ACTUALIZAR"][] = array(
					"name" => $d_a->prospecto." ".$d_a->apellido_paterno." ".$d_a->apellido_materno,
					"message" => "Actualizar información del prospecto en el formulario (seguimiento de prospeccion/prospectos agentes)"
				);
			}
	}
	//$fp = fopen('resultadoJason.txt', 'w');fwrite($fp, print_r($result_, TRUE));fclose($fp);
	return $result_;
}
//-----------------------
//Dennis Castillo [2021-10-31] -> Dennis Castillo [2021-12-09]
function getCoordinators($month = null, $year = null){ //3110

  $this->db->distinct();
  $this->db->select("asignado");

  if(!empty($month)){
    $this->db->where("MONTH(fecha)", $month);
  }

  if(!empty($year)){
    $this->db->where("YEAR(fecha)", $year);
  }

  $query = $this->db->get("prospectos_agentes");

  return $query->num_rows() > 0 ? $query->result() : array();
}
//----------------------
function prospectosMarketing_no_leads($mes){
  $year=date('Y');
  $fianzas="select * from clientes_actualiza where YEAR(fechaActualizacion)='$year' AND MONTH(fechaActualizacion)='$mes' AND leads='http://www.fianzascapital.com.mx' AND Usuario='TELEMARKETING@AGENTECAPITAL.COM'";
  
  $gmm="select * from clientes_actualiza where YEAR(fechaActualizacion)='$year' AND MONTH(fechaActualizacion)='$mes' AND leads='http://www.capitalsegurosgmm.com' AND Usuario='TELEMARKETING@AGENTECAPITAL.COM'";

  $datos['FIANZAS']=$this->db->query($fianzas)->result();
  $datos['GASTOS_MEDICOS']=$this->db->query($gmm)->result();
  return $datos;
}
//----------------------
function prospectosMarketing_leads($mes){
  $year=date('Y');
  $fianzas="select * from clientes_actualiza where YEAR(fechaActualizacion)='$year' AND MONTH(fechaActualizacion)='$mes' AND leads='http://www.fianzascapital.com.mx' AND Usuario!='TELEMARKETING@AGENTECAPITAL.COM'";
  
  $gmm="select * from clientes_actualiza where YEAR(fechaActualizacion)='$year' AND MONTH(fechaActualizacion)='$mes' AND leads='http://www.capitalsegurosgmm.com' AND Usuario!='TELEMARKETING@AGENTECAPITAL.COM'";

  $datos['FIANZAS']=$this->db->query($fianzas)->result();
  $datos['GASTOS_MEDICOS']=$this->db->query($gmm)->result();
  return $datos;
}
//----------------------
/*function prospectosAgentes($mes){
     $year=date('Y');
    $no_contactado="select * from prospectos_agentes where YEAR(fecha)='$year' AND MONTH(fecha)='$mes' AND status='NO CONTACTADO'";
     $contactado="select * from prospectos_agentes where YEAR(fecha)='$year' AND MONTH(fecha)='$mes' AND status='CONTACTADO'";
     $proceso="select * from prospectos_agentes where YEAR(fecha)='$year' AND MONTH(fecha)='$mes' AND status='EN PROCESO'";
     $descartado="select * from prospectos_agentes where YEAR(fecha)='$year' AND MONTH(fecha)='$mes' AND status='DESCARTADO'";
     
     $reclutado="select * from prospectos_agentes where YEAR(fecha)='$year' AND MONTH(fecha)='$mes' AND status='RECLUTADO'";
     $datos['NO_CONTACTADO']=$this->db->query($no_contactado)->result();
     $datos['CONTACTADO']=$this->db->query($contactado)->result();
     $datos['EN_PROCESO']=$this->db->query($proceso)->result();
     $datos['DESCARTADO']=$this->db->query($descartado)->result();
     $datos['RECLUTADO']=$this->db->query($reclutado)->result();
     return $datos;
}*/


}
