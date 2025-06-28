<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class renovaciones extends CI_Controller
{
 private $quitarSicas = array('<p>', '</p>', '<br />', ',');
 private $ponerSicas = array('', '', '\n\r', '');	
 function __construct()
  {
	parent::__construct();		
	$params['id_sicas'] = $this->tank_auth->get_IDUserSICAS(); "get_IDUserSICAS";
	$params['user_sicas'] = $this->tank_auth->get_UserSICAS(); "get_UserSICAS";
	$params['pass_sicas'] = $this->tank_auth->get_PassSICAS(); "get_PassSICAS";
	$this->load->library('Ws_sicasdre',$params);

	$this->load->helper('ckeditor');
	$this->load->model('capsysdre_actividades');
  $this->load->model('cuadromando_model', 'cuadrodemando');
	$this->load->library(array("webservice_sicas_soap","role"));	
  $this->load->library('Ws_sicas');
  }
 function index()
 {	

	if (!$this->tank_auth->is_logged_in()) 
	{
		redirect('/auth/login/');
	} 
	else 
	{
     $this->load->view('reportes/renovaciones');	
	}
 }


 function traeDatos(){
 		if (!$this->tank_auth->is_logged_in()) 
	{
		redirect('/auth/login/');
	} 
	else 		
	{ 
		if($this->input->post('fIni')=='' or $this->input->post('fFin')=='' )	
       {
 	    $datos["mensaje"]="requiere fecha para la consulta";//$this->input->post('f_Ini');
 	    $this->load->view('reportes/renovaciones',$datos);	
	   }
       else{       		
   
        $fecha=$this->input->post('fIni');  		
       	$fec= explode("/",$fecha);
        list($dia,$mes,$anio)=$fec;     
        $fechaCon1=$dia."-".$mes."-".$anio;
	      $fechaI= $dia."/".$mes."/".$anio;//ate("m/d/y", strtotime($fechaCon1));     
	  
    
        $fecha=$this->input->post('fFin');     
        $fec= explode("/",$fecha);
        list($dia,$mes,$anio)=$fec;     
        $fechaCon2=$dia."-".$mes."-".$anio;
        $fechaF=$dia."/".$mes."/".$anio;//date("m/d/y",strtotime($fechaCon2));
	  



        $D_Cred=new stdClass();
       	$datoCredenciales['username']="nombre";
       	$datoCredenciales['Password']="passwor";
       	$datoCredenciales['CodeAuth']="codigo";       	
       $datos['TipoEntidad']='0';
       $datos['TypeDestinoCDigital']='CONTACT';
       $datos['IDValuePK']='0';
       $datos['ActionCDigital']='GETFiles';
       $datos['TypeFormat']='XML';
       $datos['TProct']='Read_Data';
       $datos['KeyProcess']='REPORT';
       $datos['KeyCode']='HWS_DOCTOS';
       $datos['Page']='1';
       $datos['ItemForPage']='10000000';
       $datos['InfoSort']='VDatDocumentos.FHasta';
       $datos['IDRelation']='0';


    $vendedor=$this->tank_auth->get_IDVend();
    if($vendedor>0)
    {
       $datos['ConditionsAdd']='
       Desde|Hasta;3;0;'.$fechaI.'|'.$fechaF.';0;-1;DatDocumentos.FHasta ! Tipo Documento;0;0;1;1;DatDocumentos.TipoDocto! VendedorID;2;0;'.$vendedor.';'.$vendedor.';CatVendedores.IdVend';
    }
    else{
       $datos['ConditionsAdd']='
       Desde|Hasta;3;0;'.$fechaI.'|'.$fechaF.';0;-1;DatDocumentos.FHasta ! Tipo Documento;0;0;1;1;DatDocumentos.TipoDocto';
    }
        //$xml=$this->webservice_sicas_soap->datos($datos);
      $xml=$this->ws_sicas->obtenerRenovacionesFecha($vendedor,$fechaI,$fechaF);
            
        /*$fp =fopen('resultadoJason.txt', 'w');
                  fwrite($fp, print_r($xml, TRUE));
                   fclose($fp);*/
                            

$contador=0;
                 $contador=$xml->TableControl->MaxRecords;
                 if($contador>1){
                             $xml->addChild('fecFin', $this->input->post('fFin'));
                       $xml->addChild('fecIni', $this->input->post('fIni'));
                   $this->load->view('reportes/renovaciones',$xml);
                 }
                 else
                 { 
                    $x['fecFin']= $this->input->post('fFin');
                      $x['fecIni']= $this->input->post('fIni');
                     $x['TableInfo']= $xml->TableInfo; 
                     $x['TableControl'] =$xml->TableControl;   


            
                     
                   $this->load->view('reportes/renovaciones',$x);
                 }
       	 
       }  			
	}
 }

 function detalle(){
 	if($_POST['gato']=="felino"){
 	$result="es un gato";	
 	}
 	else
 	{
 		$result="es un perro";
 	}
 	
 				echo json_encode($result);	
 	}

 function traeArchivos(){
 			try{		
			$idDocto = $_REQUEST["IDDocto"];
	
			$data = array("IDDocto" => $idDocto);
			$this->load->library("webservice_sicas_soap");
      $this->load->library("Ws_sicas");
       
			//$data_result = $this->webservice_sicas_soap->GetCDDigital($data);
      $data_result = $this->ws_sicas->GetCDDigital($data);

  			echo json_encode($data_result);
		}catch(Exception $e){
		
		}

 }

function traeArchivosAnteriores(){

 			try{		
			$idDocto = $_REQUEST["IDDocto"];
	
			$data = array(
				"IDDocto" => $idDocto
			);
			$this->load->library("webservice_sicas_soap");

             /*   $datos['TipoEntidad']='0';
        $datos['TypeDestinoCDigital']='CONTACT';
        $datos['IDValuePK']='0';
        $datos['ActionCDigital']='GETFiles';
        $datos['TypeFormat']='XML';
        $datos['TProct']='Read_Data';
        $datos['KeyProcess']='REPORT';
        $datos['KeyCode']='H03430_003';
        $datos['Page']='1';
        $datos['ItemForPage']='10000000';
        $datos['InfoSort']='VDatDocumentos.IDDocto';
        $datos['IDRelation']='0';
        $datos['ConditionsAdd']='Documento;0;0;'.$idDocto.';'.$idDocto.';DatDocumentos.Documento';*/

 //$xml=$this->webservice_sicas_soap->datos($datos); 
 $this->load->library("Ws_sicas");               
$xml=$this->ws_sicas->buscarDocumentoAnterior($idDocto);

 $d=array();
 $d['IDDocto']=(string)$xml->TableInfo->IDDocto;

  $data_result = $this->webservice_sicas_soap->GetCDDigital($d);
  
 foreach ($xml->TableInfo as $info) {    
     $data_result['VendNombre']=$info->VendNombre;
     $data_result['PrimaTotal']=$info->PrimaTotal;
     $data_result['PrimaNeta']=$info->PrimaNeta;
     $data_result['SRamoAbreviacion']=$info->SRamoAbreviacion;
     $data_result['CiaNombre']=$info->CiaNombre;
     $data_result['CAgente']=$info->CAgente;
     $data_result['Moneda']=$info->Moneda;
     $data_result['Concepto']=$info->Concepto;
     $data_result['NombreCompleto']=$info->NombreCompleto;
     $data_result['Status_TXT']=$info->Status_TXT;
      $data_result['FHasta']=$info->FHasta;
     $data_result['FDesde']=$info->FDesde;
     $data_result['DAnterior']=$info->DAnterior;
     $data_result['Documento']=$info->Documento;
      $data_result['TipoDocto_TXT']=$info->TipoDocto_TXT;
  }

			echo json_encode($data_result);
		}catch(Exception $e){
		
		}

}


 function traeArchivosBit(){
		$claveBit = "";
		if($_REQUEST["claveBit"] != null){
			$claveBit = $_REQUEST["claveBit"];
			//$sPage = $_REQUEST["start"];
			$sPage=0;
			if($sPage > 0){
				$sPage = ($sPage / 10) + 1;	
			}else{
				$sPage = 1;
			}
			$data_body = array('claveBit' => $claveBit, 'page'=>$sPage );

			$data= $this->webservice_sicas_soap->GetInfoBit($data_body);
						/*$fp = fopen('resultadoJason.txt', 'w');
                 fwrite($fp, print_r($data_infoBit, TRUE));
                          fclose($fp);*/
                          if($data != null){
                    $json = json_encode($data);
                  $array = json_decode($json, TRUE);
                  echo json_encode($array);
  					/*$fp = fopen('resultadoJason.txt', 'w');
                 fwrite($fp, print_r($array, TRUE));
                          fclose($fp);*/

                          }
                          else
                          {
                          	echo json_encode(array(
					        'data'=>$tb_infoBit,
				            'recordsTotal'=>'0',
				            'recordsFiltered'=> 0));
                          }


               /*       $arr = array();
  foreach ($data_infoBit as $element) {
    $tag = $element->getName();
    $e = get_object_vars($element);
    if (!empty($e)) {
      $arr[$tag] = $element instanceof SimpleXMLElement ? xml2array($element) : $e;
    }
    else {
      $arr[$tag] = trim($element);
    }
  }*/
  					/*$fp = fopen('resultadoJason.txt', 'w');
                 fwrite($fp, print_r($arr, TRUE));
                          fclose($fp);*/

//echo json_encode($data_infoBit);
			//$tb_infoBit = array();
			//if($data_infoBit != null){

			/*	foreach ($data_infoBit->TableInfo as  $value) {
					$item = new \stdClass;					
					$item->Fecha = $this->capsysdre_actividades->fechaHoraEspActividades($this->getValue($value->FechaHora),'lineal');
					$item->Comentario = $this->getValue($value->Comentario);					
					array_push($tb_infoBit, $item);
				}*/
				/*$item = new \stdClass;
				 $valor->nuevo=0;
				 $valor->viejo=1;
					foreach ($data_infoBit->TableInfo as  $value) {				
					//$item->Fecha = $this->capsysdre_actividades->fechaHoraEspActividades($this->getValue($value->FechaHora),'lineal');
					$item->Comentario = $this->getValue($value->Comentario);					
					array_push($tb_infoBit, $item);
				}

								$item->Comentario ="fssfd";					
					array_push($tb_infoBit, $item);
													$item->Comentario ="fssfd";					
					array_push($tb_infoBit, $item);*/
			/*$fp = fopen('resultadoJason.txt', 'w');
                 fwrite($fp, print_r($data_infoBit, TRUE));
                          fclose($fp);*/

			/*	echo json_encode(array(
	 		'recordsTotal'=> strval($this->getValue($data_infoBit->TableControl->MaxRecords)) != NULL ? strval($this->getValue($data_infoBit->TableControl->MaxRecords)):'0',
	 		'recordsFiltered'=>strval($this->getValue($data_infoBit->TableControl->MaxRecords)) != NULL ? strval($this->getValue($data_infoBit->TableControl->MaxRecords)):'0',
	 		'data'=>$tb_infoBit
 			));	*/

			/*}else{
				echo json_encode(array(
					'data'=>$tb_infoBit,
				'recordsTotal'=>'0',
				'recordsFiltered'=> 0));
			}	*/		
		}

 }
 //-----------------------------------
 //Dennis Castillo [2021-11-19] -> [2022-03-24]
 function getRenewedRenewals(){

  $sessionAccount = $this->tank_auth->get_usermail();
  $response = array();
  $getRenovations = $this->cuadrodemando->getRenewedRenewals();

  if(!empty($getRenovations)){

    $categories = array_values(
      array_unique(
        array_map(function($arr){ return $arr->RamosNombre == "Vida" ||  $arr->RamosNombre == "Accidentes y Enfermedades" ? "Lineas Personales" : $arr->RamosNombre; }, $getRenovations)
        )
    );

    foreach($categories as $d_c){

      $inArray = $d_c == "Lineas Personales" ? array("Vida", "Accidentes y Enfermedades") : array($d_c);

      $response[strtolower($d_c)] = array_reduce($getRenovations, function($acc, $curr) use($inArray){

        if(in_array($curr->RamosNombre, $inArray) && $curr->Renovacion > 0 && !empty($curr->FEmision)){

          $now = new DateTime(date("Y-m-d", strtotime($curr->FEmision)));
          $dateReg = new DateTime(date("Y-m-d", strtotime($curr->FDesde)));
          $interval = $now->diff($dateReg);
          $intDay = (Int)$interval->format("%R%a");

          if($intDay >= 20){
            $acc["green"]++;
          }

          if($intDay >= 1 && $intDay <= 19){
            $acc["yellow"]++;
          }

          if($intDay <= 0){
            $acc["red"]++;
          }

        }

        return $acc;
      }, array("green" => 0, "yellow" => 0, "red" => 0));

    }

    //$fp =fopen('resultadoJason.txt', 'a');fwrite($fp, print_r($response, TRUE));fclose($fp);
  }
  return $this->showRenovations($sessionAccount, $response);
  //echo json_encode($this->showRenovations($sessionAccount, $response));
  //echo json_encode($response);
 }
 //----------------------------------- //Dennis Castillo [2022-03-24] -> [2022-03-30]
 function getPendingRenovations(){

  $sessionAccount = $this->tank_auth->get_usermail();
  $response = array();
  $responseChannels = array();
  $getRenovations = $this->cuadrodemando->getPendingRenovationsDays();

  $categories = array_map(function($arr){ return in_array($arr->RamosNombre, array("Vida", "Accidentes y Enfermedades")) ? "Lineas Personales" : $arr->RamosNombre; }, $getRenovations);
  $channels = array_map(function($arr){ return $arr->GerenciaNombre; }, $getRenovations);
  $uniqueCategory = array_values(array_unique($categories));
  $uniqueChannels = array_values(array_unique($channels));

  foreach($uniqueChannels as $dch){

    $responseChannels[strtolower($dch)] = array_reduce($getRenovations, function($acc, $curr) use($dch){

      if($curr->GerenciaNombre == $dch){

        if($curr->Days >= 20){
          $acc["green"] ++;
        }

        if($curr->Days > 0 && $curr->Days <= 19){
          $acc["yellow"] ++;
        }

        if($curr->Days <= 0){
          $acc["red"] ++;
        }
      }

      return $acc;
    }, array("green" => 0, "yellow" => 0, "red" => 0));
  }

  foreach($uniqueCategory as $dc){

    $inArray = $dc == "Lineas Personales" ? array("Vida", "Accidentes y Enfermedades") : array($dc);
    $response[strtolower($dc)] = array_reduce($getRenovations, function($acc, $curr) use($inArray){

      if(in_array($curr->RamosNombre, $inArray)){

        if($curr->Days >= 20){
          $acc["green"] ++;
        }

        if($curr->Days > 0 && $curr->Days <= 19){
          $acc["yellow"] ++;
        }

        if($curr->Days <= 0){
          $acc["red"] ++;
        }
      }

      return $acc;
    }, array("green" => 0, "yellow" => 0, "red" => 0));
  }

  $allResponse = array_merge($response, $responseChannels);

  //$fp =fopen('resultadoJason.txt', 'a');fwrite($fp, print_r($allResponse, TRUE));fclose($fp);

  return $this->showRenovations($sessionAccount, $allResponse); //$response
  //echo json_encode($this->showRenovations($sessionAccount, $response));
  //var_dump($response);
 }
 //-----------------------------------  //Dennis Castillo [2022-03-24]
 function getRenovationsKpi(){

  $response = array(
    "Renovadas" => array("class" => "renovada", "content" => $this->getRenewedRenewals()),
    "pendientes" => array("class" => "pendiente", "content" => $this->getPendingRenovations()),
  );

  //$fp =fopen('resultadoJason.txt', 'a');fwrite($fp, print_r($response, TRUE));fclose($fp);
  //var_dump($response);

  echo json_encode($response);
 }
 //-----------------------------------
 //Dennis Castillo [2021-11-19] -> [2022-03-30]
 function showRenovations($account, $data){

  switch($account){
    case strtoupper("autos@asesorescapital.com"): 
      unset($data["lineas personales"]); 
      unset($data["daños"]); 
      unset($data["institucional"]); 
      unset($data["cap capital"]); 
      unset($data["asesores"]); 
      return $data;
    break;
    case strtoupper("autosrenovaciones@asesorescapital.com"): 
      unset($data["lineas personales"]); 
      unset($data["daños"]);
      unset($data["institucional"]); 
      unset($data["cap capital"]); 
      unset($data["asesores"]); 
      return $data;
    break;
    case strtoupper("ejecutivocotizaciones@agentecapital.com"): 
      unset($data["lineas personales"]); 
      unset($data["daños"]); 
      unset($data["institucional"]); 
      unset($data["cap capital"]); 
      unset($data["asesores"]); 
      return $data;
    break;
    case strtoupper("lineaspersonales@asesorescapital.com"): 
      unset($data["vehiculos"]); 
      unset($data["daños"]);
      unset($data["institucional"]); 
      unset($data["cap capital"]); 
      unset($data["asesores"]); 
      return $data;
    break;
    case strtoupper("bienes@asesorescapital.com"): 
      unset($data["vehiculos"]); 
      unset($data["lineas personales"]);
      unset($data["institucional"]); 
      unset($data["cap capital"]); 
      unset($data["asesores"]); 
      return $data;
    break;
    case strtoupper("asistentecun2@agentecapital.com"): //ASISTENTECUN2@AGENTECAPITAL.COM
      unset($data["vehiculos"]); 
      unset($data["lineas personales"]);
      unset($data["daños"]); 
      unset($data["institucional"]);
      unset($data["asesores"]); 
      return $data;
    break;
    case strtoupper("atencionagentesmid@asesorescapital.com"): //ATENCIONAGENTESMID@ASESORESCAPITAL.COM
      unset($data["vehiculos"]); 
      unset($data["lineas personales"]);
      unset($data["daños"]); 
      unset($data["institucional"]); 
      unset($data["cap capital"]); 
      return $data;
    break;
    case strtoupper("atencionclientes@asesorescapital.com"): //ATENCIONCLIENTES@ASESORESCAPITAL.COM
      unset($data["vehiculos"]); 
      unset($data["lineas personales"]);
      unset($data["daños"]); 
      unset($data["cap capital"]); 
      unset($data["asesores"]);
      return $data;
    break;
    default: return $data;
  }

 }
 //-----------------------------------
 function obtenerSemafonoActividades(){

  $array = array(
    //"mes" => 7,
    //"anio" => 2021,
    "semaforo" => "rojo",
    "responsable" => "AUTOS@ASESORESCAPITAL.COM"
  );

  $activities = $this->cuadrodemando->getSemaforoActividades($array);

  var_dump($array);
  var_dump($activities);
 }
 //-----------------------------------
}