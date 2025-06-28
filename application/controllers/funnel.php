<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class funnel extends CI_Controller
{

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
			$this->load->model('funnelM');
		   $this->load->model('personamodelo');
		   $this->load->model('crmproyecto_model', "crmproyecto");
	}
//--------------------------------------------------------------------------------------------------------------------
function devolverClientesPorMes(){

	  if(isset($_GET['idPersona'])){
	 $_GET['Usuario']=$this->personamodelo->obtenerDatosUsers($_GET['idPersona'])->email;
	}
		 
$respuesta['respuesta']='clienteXmes';
$respuesta['datos']=$this->funnelM->clientesXmes($_GET);
echo json_encode($respuesta); 	
}
//--------------------------------------------------------------------------------------------------------------------
function devolverAgentesPorCoordinador(){echo json_encode($this->personamodelo->devuelveAgentesPorCoordinadorActivos($_GET['idPersona']));}
//-------------------------------------------------------------------------------------------------
function index(){ //3110

	if (!$this->tank_auth->is_logged_in()) {redirect('/auth/login/');} 
	else
	 {    
	   $email="";
	   $user=null;
	   $idCoordinador=-1;
	   $datos['coordinadores']=$this->personamodelo->devuelveCoordinadoresVentas();
	   $idAgente="";
	   if(isset($_GET['idCoordinador']) && isset($_GET['idAgente']) )
	   {
		   $email=$this->personamodelo->obtenerDatosUsers($_GET['idAgente'])->email;
		   $user['user']=$email;
		   $idCoordinador=$_GET['idCoordinador'];	
		   $idAgente=$_GET['idAgente'];
	   }
	   else{
			 if(isset($_GET['idCoordinador']))
			 {	    
			   if($_GET['idCoordinador']>0)
			   { 
				$email=$this->personamodelo->obtenerDatosUsers($_GET['idCoordinador'])->email;
				$user['user']=$email;
				$idCoordinador=$_GET['idCoordinador'];	  	
			   }
			   else
			   {
				   $email=$this->tank_auth->get_usermail();
				   $user['user']=$this->tank_auth->get_usermail();
				 $idCoordinador=$this->tank_auth->get_idPersona();	     	    	
			   }
			 }
			else{
				   $email=$this->tank_auth->get_usermail();
				   $user['user']=$this->tank_auth->get_usermail();
				 $idCoordinador=$this->tank_auth->get_idPersona();
				  }
		   }
	
		 $datos['datosfunnel']=$this->funnelM->devuelvefunnels($email);
		 
		 //Modificacion Miguel Jaime [01/04/2021]
			 if($this->tank_auth->get_usermail()=="DIRECTORCOMERCIAL@AGENTECAPITAL.COM"){
				$user['user']="DIRECTORGENERAL@AGENTECAPITAL.COM";
			 }
		 //Fin de Modificacion
		 $datos['clientesPorMes']=$this->funnelM->fechasClientesPorMes($user);
	   
		 $datos['nombreMeses']=$this->libreriav3->devolverMeses();
				
	   $datos['agentes']=$this->personamodelo->devuelveAgentesPorCoordinadorActivos($idCoordinador);
	   $datos['idCoordinador']=$idCoordinador;
	   $datos['idAgente']=$idAgente;
  
	//Modificacion Miguel 10/02/2020
	   $datos['suspectos']=$this->funnelM->clientesSuspectos();
	   $datos['perfilados']=$this->funnelM->clientesPefilados();
	   $datos['contactados']=$this->funnelM->clientesContactados();
	   $datos['cotizados']=$this->funnelM->clientesCotizados();
	   $datos['emision']=$this->funnelM->clientesEmision();
	   $datos['pagados']=$this->funnelM->clientesPagados();	


		 //Modificacion Miguel 23/06/2021
	   $mes=date('m');
	   $coor = array("DIRECTORGENERAL@AGENTECAPITAL.COM", "DIRECTORCOMERCIAL@AGENTECAPITAL.COM","GERENTEOPERATIVO@AGENTECAPITAL.COM", "SISTEMAS@ASESORESCAPITAL.COM", "MARKETING@AGENTECAPITAL.COM");  //Dennis Castillo [2021/10/31] -> Dennis Castillo [2022-04-25] 
	   $coorFilter = !in_array($this->tank_auth->get_usermail(), $coor) ? $this->tank_auth->get_usermail(): "";  //Dennis Castillo [2021/10/31]
	   $prospectiveAgent = $this->funnelM->prospectosAgentes($mes, $coorFilter);   //Dennis Castillo [2021/10/31]

	   $datos['prospectosFianzas'] = $this->funnelM->prospectosFianzas($mes); 
	   $datos['prospectosAgentes'] = $prospectiveAgent; //$this->funnelM->prospectosAgentes($mes, $coorFilter); //Dennis Castillo [2021/10/31]
	   $datos["progressProspective"] = $this->getProgressProspectives($prospectiveAgent);   //Dennis Castillo [2021/10/31]
	   $datos['prospectosMarketing']=$this->funnelM->prospectosMarketing($mes);
	   $datos['prospectosMarketing_no_leads']=$this->funnelM->prospectosMarketing_no_leads($mes);
	   $datos['prospectosMarketing_leads']=$this->funnelM->prospectosMarketing_leads($mes);
	   $datos['mes']=$mes;


	    //Modificacion Miguel 30/10/2021
        //Visitantes
         $datos['visitasFianzas']=$this->funnelM->funnel_landing('Fianzas',$mes);
         $datos['visitasGmm']=$this->funnelM->funnel_landing('Gmm',$mes);
         //Alcanzados
         $datos['alcanzadosFianzas']=$this->funnelM->funnel_landing_alcanzados('Fianzas',$mes);
         $datos['alcanzadosGmm']=$this->funnelM->funnel_landing_alcanzados('Gmm',$mes);
         //Efectivos
          $datos['efectivosFianzas']=$this->funnelM->funnel_landing_efectivos('Fianzas',$mes);
         $datos['efectivosGmm']=$this->funnelM->funnel_landing_efectivos('Gmm',$mes);
         //*******


	   $datos["coor"] = in_array($this->tank_auth->get_usermail(), $coor) ? array_map(function($arr){ return $arr->asignado; }, $this->funnelM->getCoordinators(null,null)) : array($this->tank_auth->get_usermail()); //Dennis Castillo [2021/10/31]

	   //$fp = fopen('resultadoJason.txt', 'w');fwrite($fp, print_r($datos, TRUE));fclose($fp);
	
		  if($this->tank_auth->get_View()!= "App"){
			  $this->load->view('funnel/principal',$datos);
		  } else {
			  $this->load->view('funnel/principalApp',$datos);
		  }
	  }
  }
	/*function index(){

	  if (!$this->tank_auth->is_logged_in()) {redirect('/auth/login/');} 
	  else
	   {    
         $email="";
         $user=null;
         $idCoordinador=-1;
         $datos['coordinadores']=$this->personamodelo->devuelveCoordinadoresVentas();
         $idAgente="";
	     if(isset($_GET['idCoordinador']) && isset($_GET['idAgente']) )
	     {
	     	$email=$this->personamodelo->obtenerDatosUsers($_GET['idAgente'])->email;
	     	$user['user']=$email;
	     	$idCoordinador=$_GET['idCoordinador'];	
	     	$idAgente=$_GET['idAgente'];
	     }
	     else{
	     	  if(isset($_GET['idCoordinador']))
	     	  {	    
	     	    if($_GET['idCoordinador']>0)
	     	    { 
	     	     $email=$this->personamodelo->obtenerDatosUsers($_GET['idCoordinador'])->email;
	     	     $user['user']=$email;
	     	     $idCoordinador=$_GET['idCoordinador'];	  	
	     	    }
	     	    else
	     	    {
	          	   $email=$this->tank_auth->get_usermail();
	          	   $user['user']=$this->tank_auth->get_usermail();
                   $idCoordinador=$this->tank_auth->get_idPersona();	     	    	
	     	    }
	     	  }
	          else{
	          	   $email=$this->tank_auth->get_usermail();
	          	   $user['user']=$this->tank_auth->get_usermail();
                   $idCoordinador=$this->tank_auth->get_idPersona();
	          	  }
	         }
	  
           $datos['datosfunnel']=$this->funnelM->devuelvefunnels($email);
           
           //Modificacion Miguel Jaime [01/04/2021]
               if($this->tank_auth->get_usermail()=="DIRECTORCOMERCIAL@AGENTECAPITAL.COM"){
                  $user['user']="DIRECTORGENERAL@AGENTECAPITAL.COM";
               }
           //Fin de Modificacion
           $datos['clientesPorMes']=$this->funnelM->fechasClientesPorMes($user);
         
           $datos['nombreMeses']=$this->libreriav3->devolverMeses();
                  
         $datos['agentes']=$this->personamodelo->devuelveAgentesPorCoordinadorActivos($idCoordinador);
         $datos['idCoordinador']=$idCoordinador;
         $datos['idAgente']=$idAgente;
	
	  //Modificacion Miguel 10/02/2020
         $datos['suspectos']=$this->funnelM->clientesSuspectos();
         $datos['perfilados']=$this->funnelM->clientesPefilados();
         $datos['contactados']=$this->funnelM->clientesContactados();
         $datos['cotizados']=$this->funnelM->clientesCotizados();
         $datos['emision']=$this->funnelM->clientesEmision();
         $datos['pagados']=$this->funnelM->clientesPagados();	

		//Modificacion Miguel 30/10/2021
         $mes=date('m');
         $datos['prospectosFianzas']=$this->funnelM->prospectosFianzas($mes);
         $datos['prospectosAgentes']=$this->funnelM->prospectosAgentes($mes);
         $datos['mes']=$mes;
        //Visitantes
         $datos['visitasFianzas']=$this->funnelM->funnel_landing('Fianzas',$mes);
         $datos['visitasGmm']=$this->funnelM->funnel_landing('Gmm',$mes);
         //Alcanzados
         $datos['alcanzadosFianzas']=$this->funnelM->funnel_landing_alcanzados('Fianzas',$mes);
         $datos['alcanzadosGmm']=$this->funnelM->funnel_landing_alcanzados('Gmm',$mes);
         //Efectivos
          $datos['efectivosFianzas']=$this->funnelM->funnel_landing_efectivos('Fianzas',$mes);
         $datos['efectivosGmm']=$this->funnelM->funnel_landing_efectivos('Gmm',$mes);
         //*******
      
			if($this->tank_auth->get_View()!= "App"){
				$this->load->view('funnel/principal',$datos);
			} else {
				$this->load->view('funnel/principalApp',$datos);
			}
		}
	}*/
//------------------------
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
//------------------------
	function guardaNuevo(){
		 $arreglo= explode(",", $_REQUEST["datos"]);
		 $longitud=count($arreglo);
	
for($i=0;$i<$longitud;$i++){
		$nombre=$arreglo[0];	
	$arreglo1=explode(":",$arreglo[$i]);
	if($arreglo1[0]!='id' && $arreglo1[0]!='contactado' && $arreglo1[0]!='cotizado' & $arreglo1[0]!='pagado' & $arreglo1[0]!='perfilado' && $arreglo1[0]!='dimension'   ){
	$arreglo2[$arreglo1[0]]=$arreglo1[1];
   }
}
 
         //$arreglo1=explode(":",$arreglo);        
/*COMPRUEBA VALORES*/
$meses=["Enero","Febrero","Marzo","Abril","Mayo","Junio","Julio","Agosto","Septiembre","Octubre","Noviembre","Diciembre"];
if(in_array($arreglo2['mes'], $meses)){
	if($arreglo2['anio']=="2017" || $arreglo2['anio']=="2018" || $arreglo2['anio']=="2019" || $arreglo2['anio']=="2020" || $arreglo2['anio']=="2021" || $arreglo2['anio']=="2022" || $arreglo2['anio']=="2023" || $arreglo2['anio']=="2024" || $arreglo2['anio']=="2025"){
		if($arreglo2['comision']<=100 && $arreglo2['prospecto']<=100  && $arreglo2['impacto']<=100 && $arreglo2['seguimiento']<=100 && $arreglo2['suspecto']<=100   ){
         if($arreglo2['comision']>0 && $arreglo2['prospecto']>0  && $arreglo2['impacto']>0 && $arreglo2['seguimiento']>0 && $arreglo2['suspecto']>0   ){
         	if($arreglo2['ticketProm']>0 && $arreglo2['objetivoMensual']>0){
              if($arreglo2['contratoCerrar']>0)
              {
                $arreglo2['Usuario']=$this->tank_auth->get_usermail();                
                $idFunnel=$this->funnelM->insertafunnel($arreglo2);
                $var=$this->funnelM->devuelveFunnel($this->tank_auth->get_usermail(),$idFunnel);
                
                 echo json_encode($var);  		         		
              }
              else{$id=-1; echo json_encode($id);  	//"El contrato a cerrar debe ser mayor de cero";                 	         		
              }
         	}
         	else{$id=-2;  echo json_encode($id);  //"El ticket promedio y el objetivo mensual deben ser mayores de cero";       		         		
         	}
         }
         else{$id=-3;echo json_encode($id);//"Los porcentajes deben ser mayor 0";           		
         }
		}
		else
		{$id=-4;echo json_encode($id);//"Los porcentajes son menores o igual a 100";           				
		}

	}else{$id=-5;echo json_encode($id);//"Error en la fecha seleccionada";  		
	} 		
}else{
	$id=-6;echo json_encode($id); //"Error en el mes seleccionado";
 	
}
	
	}
//--------------------------------------------------------------------------------------------------------------------
function cancelaFunnel(){$this->funnelM->cancelaFunnel($_REQUEST["datos"]);}
//--------------------------------------------------------------------------------------------------------------------
//--------------------------------------------------------------------------------------------------------------------

//--------------------------------------------------------------------------------------------------------------------

//--------------------------------------------------------------------------------------------------------------------

//--------------------------------------------------------------------------------------------------------------------

//--------------------------------------------------------------------------------------------------------------------

//--------------------------------------------------------------------------------------------------------------------

//--------------------------------------------------------------------------------------------------------------------

//--------------------------------------------------------------------------------------------------------------------

//--------------------------------------------------------------------------------------------------------------------

//--------------------------------------------------------------------------------------------------------------------


}
