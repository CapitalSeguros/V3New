<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

require_once APPPATH.'third_party/fpdf/fpdf.php';

class crmproyecto extends CI_Controller{
	var $citaRegistrada	= 0;
	var $idCliente		= 0;
	var $data			= array(); //"";

	function __construct(){
		
		parent::__construct();
		
		if (!$this->tank_auth->is_logged_in()) {
			redirect("");
		}
			$params['id_sicas']		= $this->tank_auth->get_IDUserSICAS(); "get_IDUserSICAS";
			$params['user_sicas'] 	= $this->tank_auth->get_UserSICAS(); "get_UserSICAS";
			$params['pass_sicas'] 	= $this->tank_auth->get_PassSICAS(); "get_PassSICAS";
			$this->load->library('Ws_sicasdre',$params);
			$this->load->library('webservice_sicas_soap');
			$this->load->library('localfileuploader');
			$this->load->library('Ws_sicas');
			$this->load->helper('ckeditor');
			$this->load->model('capsysdre_actividades');
			$this->load->model('fullcalendar_model');
			$this->load->model('PersonaModelo');
			$this->load->model('crmProyecto_Model');
			$this->load->model('email_model');
			$this->load->model('saldo_model');
			$this->load->model("preguntamodel");
			$this->load->library('libreriaV3');
			$this->load->library('excel');
			
			$this->load->library(array("webservice_sicas_soap","role"));
	//		$this->load->helper('url');
			$this->load->model("catalogos_model");
	//		$this->load->model("capsysdre_directorio");
	//		$this->load->model("clientemodelo");
        	$this->load->model('capitalhumano_model'); //Agregado [Suemy][2024-06-26]
        	$this->load->model('superestrella_model'); //Agregado [Suemy][2024-06-26]
	}

//-------------------------------------------------------------------------------------------------------------------------------






 function guardaArchivo(){
 	$this->load->model('manejodocumento_modelo');
 	$id=$this->manejodocumento_modelo->reemplazarNombreArchivo(key($_FILES),"Archivo","");
    $extension=$this->manejodocumento_modelo->devolverExtension($_FILES[key($_FILES)]['name']);
    $compruebaExtension=$this->manejodocumento_modelo->verificaExtensionArchivo($extension);
    if($compruebaExtension){
     $nombre=$this->manejodocumento_modelo->eliminaCaracteres($_FILES[key($_FILES)]['name']);
     $nombre=$this->manejodocumento_modelo->obtenerNombreArchivo($nombre);
     $directorio=$this->manejodocumento_modelo->obtenerDirectorio("S");
    
     $this->manejodocumento_modelo->guardarArchivo($directorio.'archivosCRM/'.$id."/",$_FILES,$nombre,$extension);
 	//$this->index();
 	$this->data['pestania']='seguimientoProspecto';
 	$this->proyecto100();
    }
    else
    {
     
 	//$this->index();	
 	$this->data['pestania']='seguimientoProspecto';
 	$this->proyecto100();
    }
 	
 	
 }

 //---------------------------------------------------------------------------------------------------------------------------------------------------------
function proyecto100(){
	$this->data['citas']=$this->fullcalendar_model->devuelveCitasActivasPorUsuarios();	
	$this->data['idCliente']=$this->idCliente;
	$this->data['clientesEnPausa']=$this->crmProyecto_Model->devuelveEnPausa(null);

	if($this->tank_auth->get_View()!= "App"){
		$this->load->view('crmproyecto/proyecto100',$this->data);
	} else {

		$SubSessionApp	= $this->uri->segment(3);

		switch($SubSessionApp){
			case "Alta":
				$this->load->view('crmproyecto/proyecto100App_Alta',$this->data);
			break;
			
			case "Seguimiento":
				$this->load->view('crmproyecto/proyecto100App_Segumiento',$this->data);
			break;
				
			case "Administracion":
				$this->load->view('crmproyecto/proyecto100App_Administracion',$this->data);
			break;
				
			case "Reporte":
				$this->load->view('crmproyecto/proyecto100App_Reporte',$this->data);
			break;
				
			case "Puntos":
				$this->load->view('crmproyecto/proyecto100App_Puntos',$this->data);
			break;
				
			case "Funnel":
				$this->load->view('crmproyecto/proyecto100App_Funnel',$this->data);
			break;
		}
		
	}
	
}
//-------------------------------------------------------------------------------------------------------------------------------
function miCalendario(){
$this->load->view('crmproyecto/micalendario');
}
//-------------------------------------------------------------------------------------------------------------------------------
	function Estadistica(){
       	if (!$this->tank_auth->is_logged_in()) {redirect('/auth/login/');} 
		else 
		{

	        $fechaini						= $this->input->post('fechaini', true);
	        $fechafin						= $this->input->post('fechafin', true);
			$coordinadorVendedor			= $this->input->post('coordinadorVendedor',true);
			
	        $data['fechaini']				= $fechaini;
            $data['fechafin']				= $fechafin;
            $data['meses']=$this->libreriav3->devolverMeses();
            $data['anios']=$this->libreriav3->devolverAnios();
  
             if(!isset($_POST['anioConcentrado']))
             {
                 $data['mesConcentrado']=date("n");
                 $data['anioConcentrado']=date("Y");            
                              $mesYanio['mes']=date("n");
             $mesYanio['anio']=date("Y");

			}
             else
             {
            $data['mesConcentrado']=$this->input->post('mesConcentrado',true);
            $data['anioConcentrado']=$this->input->post('anioConcentrado',true);
             $mesYanio['mes']=$this->input->post('mesConcentrado',true);
             $mesYanio['anio']=$this->input->post('anioConcentrado',true);

             }
			$anioInicial['anio']=2022;
            $canales=$this->catalogos_model->canalesCatalogos($anioInicial);            
			$data['CoordinadoresVentas']	= $CoordinadoresVentas	= $canales;//$this->PersonaModelo->devuelveCoordinadoresVentas();
            
			foreach($CoordinadoresVentas as $coordinadorVen){$filtroCoordinadorVer[] = $coordinadorVen->email;}

			if(in_array($this->tank_auth->get_usermail(),$filtroCoordinadorVer)){$data['filtroVer']	= "COORDINA"; 				
			} else if($this->tank_auth->get_usermail() == "DIRECTORGENERAL@AGENTECAPITAL.COM" || $this->tank_auth->get_usermail() == "SISTEMAS@ASESORESCAPITAL.COM"){
				$data['filtroVer']				= "DIRECT";
			} else {
				$data['filtroVer']				= "";
			}
			$data['coordinadorVendedor']	= $coordinadorVendedor;

			$data['ListaVendedores']		= $this->capsysdre->ListaVendedoresP100xFecha($fechaini,$fechafin,$coordinadorVendedor,$mesYanio);
			$data['permisoCanjear']=false;
			if($this->tank_auth->get_usermail()=='SISTEMAS@ASESORESCAPITAL.COM' || $this->tank_auth->get_usermail()=='$this->tank_auth->get_usermail()'){$data['permisoCanjear']=true;}
			
			//$fp = fopen('resultadoJason.txt', 'a');fwrite($fp, print_r($data['ListaVendedores']->result(),TRUE));fclose($fp);	
			
				$this->load->view('crmproyecto/concentrado',$data);
			

         } 
    }

//-------------------------------------------------------------------------------------------------------------------------------
	function editPros(){

		if (!$this->tank_auth->is_logged_in()) {
			redirect('/auth/login/');
		} else {
			if($this->input->get('IDCli',TRUE))
			{
				$idInterno = $this->input->get('IDCli',TRUE);
				$data['detalleUsuario']	= $this->capsysdre->detalleProspecto($idInterno);
				$data['respuesta']="Editar";
				$data['IDCli']=$idInterno;
			    echo json_encode($data);
				//$this->load->view('crmproyecto/editProspecto', $data['detalleUsuario']);
			}
		}
	} /*! editPros */

//-------------------------------------------------------------------------------------------------------------------------------
	function consultaxfechas(){
		if (!$this->tank_auth->is_logged_in()) {redirect('/auth/login/');} 
		else {
			$fechaini				= $this->input->post('fechaini',true);
			$fechafin				= $this->input->post('fechafin', true);
			$coordinadorVendedor	= $this->input->post('coordinadorVendedor');
			//$correoUsuario = "COORDINADOR@CAPCAPITAL.COM.MX";
		  
			$data['CoordinadoresVentas']	= $this->PersonaModelo->devuelveCoordinadoresVentas();
			$data['ListaVendedores']		= $this->capsysdre->ListaVendedoresP100xFecha($fechaini,$fechafin,$coordinadorVendedor);
			$data['coordinadorVendedor']	= $coordinadorVendedor;
			$data['fechaini']				= $fechaini;
			$data['fechafin']				= $fechafin;
			if($this->tank_auth->get_View()!= "App"){$this->load->view('crmproyecto/Estadistica',$data);}
			else {$this->load->view('crmproyecto/EstadisticaApp',$data);}
         } 
    }
//-------------------------------------------------------------------------------------------------------------------------------
	function actualizaProspecto(){

		if (!$this->tank_auth->is_logged_in()) {redirect('/auth/login/');} 
		else {  
			strtoupper ($this->input->post('cliselecsikas'));

				$IDpros			= $this->input->post('IDCl');
				$ApellidoP			= strtoupper ($this->input->post('ApellidoP'));
	 			$ApellidoM			= strtoupper ($this->input->post('ApellidoM'));
	 			$Nombre				= strtoupper ($this->input->post('Nombre'));
	 			$RazonSocial		= strtoupper ($this->input->post('RazonSocial'));
	 			$RFC				= strtoupper ($this->input->post('RFC'));
	 			$email				= strtoupper ($this->input->post('EMail1'));
				$cel				= $this->input->post('Telefono1');

				$sqlUpdateUser = "
				Update
					`clientes_actualiza`
				Set
				`ApellidoP` = '".$ApellidoP."',
				`ApellidoM` = '".$ApellidoM."',
				`Nombre` = '".$Nombre."',
				`RazonSocial`='".$RazonSocial."',
	            `RFC` = '".$RFC."',
	            `EMail1` = '".$email."',
	            `Telefono1` = '".$cel."'
				Where
				`IDCli` = '".$IDpros."'
						 ";

				$this->db->query($sqlUpdateUser);
  

				$data['detalleUsuario'] = $this->capsysdre->detalleProspecto($IDpros);
				$data['alert']		= "success";
				$this->Reportes();
				//redirect('crmproyecto/Reportes', $data);

		}
	} /*! actualizaProspecto */
//-------------------------------------------------------------------------------------------------------------------------------
//-------------------------------------------------------------------------------------------------------------------------------
function agregarProspecto(){
	$clasificacion=$this->PersonaModelo->clasificacionUsuariosParaEnvios(null);
	$personaTipoEnvio=array();
	foreach ($clasificacion as $key => $value) 
	{
		if($value['Name']!='Marketing proyecto 100'){
		foreach ($value['Data'] as  $valueData) 
		{   $valueData['Name']=$value['Name'];
			array_push($personaTipoEnvio, (object)$valueData);
		}
	}
	}


	$devolverPersona['tipoPersona']='Agente';
	$datos['personaTipoPersonaCatalogo']=$this->libreriav3->agrupaPersonasParaSelect($personaTipoEnvio,$devolverPersona);    

				
				//$data['personaTipoPersonaCatalogo']=$this->libreriav3->agrupaPersonasParaSelect($this->PersonaModelo->obtenerPersonas('',3),$devolverPersona);


	($this->tank_auth->get_IDVend()>0)? $datos['imprimirSelecVendedor']=false:$datos['imprimirSelecVendedor']=true;
	$datos['imprimirSelecVendedor']=true;
	if((int)$this->tank_auth->get_IDVend()>0){$datos['imprimirSelecVendedor']=false;}

	//-------------
	//Dennis Castillo [2021-11-02]
	$datos["accountsToAssignLeads"] = array_map(function($arr){ return $arr->account; }, $this->crmProyecto_Model->getAssigned());
	//-------------
	

if($this->tank_auth->get_View()!= "App"){$this->load->view('crmproyecto/agregarProspecto',$datos);} 
else {$this->load->view('crmproyecto/agregarProspectoApp',$datos);}


}
//-------------------------------------------------------------------------------------------------------

//MiguelJaime 15-02-2023*************************
function getDato($campo, $valor){
    $user=$this->tank_auth->get_usermail();
    $ct=0;
    $valor="'".$valor."'"." AND Usuario="."'".$user."'";
    $sql="SELECT COUNT(*) as total FROM clientes_actualiza WHERE ".$campo."=".$valor;
    $rs=$this->db->query($sql)->result();
    $ct=$rs[0]->total;
    return $ct;
    echo $sql;
 }

//----------------------------------------------------------------------------
function seguimientoProspecto(){
		if($this->tank_auth->get_usermail()=="GERENTE@FIANZASCAPITAL.COM"){$this->conexionCS();}
			//$this->conexionCS();
			$correoProcedente		= $this->tank_auth->get_usermail();
			
			$data['emailVendedor']='';
			if(isset($_GET['emailVendedor'])){$correoProcedente=$_GET['emailVendedor'];$data['emailVendedor']=$_GET['emailVendedor'];}
			//$correoProcedente='JMORALES@CAPCAPITAL.COM.MX';
			$data_search['id']		= $this->capsysdre->IDxEmail($correoProcedente);
			$data_search['role']	= "OPERATIVO";  //pasamos este dato para qeu la consulta traiga los del vendedor

			/*BUSCAMOS CLIENTE SIKAS  
			$data_result = $this->webservice_sicas_soap->GetClientp100($data_search);	
			$data['data_result']=$data_result;*/
			
			$nombrep=$this->input->post('nomsik');
		    if($nombrep!=""){
				$data_result = $this->capsysdre_actividades->ListaClienteProspecto($nombrep);	
				$data['data_result']=$data_result;
            }



			$dat=$this->capsysdre->ListaClientes($this->input->post('busquedaUsuario', TRUE),$correoProcedente)->result();

            $diasSemana=$this->libreriav3->devolverDiasSemana();
            $fechaHoy=getdate();

			//$data['ListaClientes']= $this->capsysdre->ListaClientes($this->input->post('busquedaUsuario', TRUE),$correoProcedente);
            $j=0;
            $pestania=array(); //"";
            for($i=$fechaHoy['wday'];$i>=0;$i--){
             if($j==0){$pestania[$j]='HOY';}				   		
             else{$pestania[$j]=$diasSemana[$i];}
             $j++;
            }
            $fec=$fechaHoy['year'].'-'.$fechaHoy['mon'].'-'.$fechaHoy['mday'];
            $hoyEs=new DateTime($fec);
            $countDiaSemana=count($pestania);
 
            foreach ($dat as  $value) {
            	$dia=new DateTime(date("Y-m-d", strtotime($value->fechaCreacionCA )));
            	$diaCreacion=date("Y-m-d", strtotime($value->fechaCreacionCA ));
            	$diaCreacion=explode('-', $diaCreacion);

              $dif=$hoyEs->diff($dia);
              if($fechaHoy['year']!=$diaCreacion[0]){$value->pestania='ANTIGUOS';}
              else{$difMeses=$fechaHoy['mon']-$diaCreacion[1];
              	   if($difMeses>1){$value->pestania='ANTIGUOS';}
                   else{
                   	     if($difMeses==1){$value->pestania="MES_PASADO";}
                   	     else{
                   	           $difDia=$fechaHoy['mday']-$diaCreacion[2];

                   	           if($difDia<$countDiaSemana)
                   	           {
                   	           	$value->pestania=$pestania[$difDia];
                   	           }
                   	           else
                   	           {
                   	           	$value->pestania="ESTE_MES";
                   	           }

                   	         }
                   	   }
                  }
   	             
            }

            array_push($pestania,'ESTE MES');
            array_push($pestania,'MES PASADO');
            array_push($pestania,'ANTIGUOS');
            array_push($pestania,'TODOS');
      
			/* $data['queryConsultaDimension'] = $queryConsultaDimension;
			 $data['queryPuntosGlobales']= $queryPuntosGlobales;
			 $data['queryConsultacontactados']= $queryConsultacontactados;
			 $data['queryConsultaRegistrados']= $queryConsultaRegistrados;
			 $data['queryConsultaCotizados']= $queryConsultaCotizados; 
             $data['queryConsultaPagados']= $queryConsultaPagados; 


			 $data['queryConsultaperfilados']= $queryConsultaperfilados;
			 $data['queryPuntosperfilados']= $queryPuntosperfilados;
			 $data['queryPuntoscontactados']= $queryPuntoscontactados;
			 $data['queryPuntosRegistrados']= $queryPuntosRegistrados;
             $data['queryPuntosCotizados']= $queryPuntosCotizados;
             $data['queryPuntosPagados']= $queryPuntosPagados;*/
            $data['fechaActual']=$this->libreriav3->convierteFecha($this->libreriav3->devolverFechaActual('/'));
            $data['primerDiaMes']=$this->libreriav3->convierteFecha($this->libreriav3->devolverPrimerDiaMesActual('/',''));
            $data['ListaClientes']=$dat;
			$data['muestraCalendario']=$this->citaRegistrada;
			$data['citas']=$this->fullcalendar_model->devuelveCitasActivasPorUsuarios();
			$data['idCliente']=$this->idCliente;
			$data['pestania']=$pestania;
$clasificacion=$this->PersonaModelo->clasificacionUsuariosParaEnvios(null);
$personaTipoEnvio=array();
foreach ($clasificacion as $key => $value) 
{
	if($value['Name']!='Marketing proyecto 100'){
	foreach ($value['Data'] as  $valueData) 
	{   $valueData['Name']=$value['Name'];
		array_push($personaTipoEnvio, (object)$valueData);
	}
  }
}

	//------------------------------------
	//Dennis Castillo [2021-08-03]
	$guiones = $this->preguntamodel->obtenerGuionTelefonico("prospecto");
	$array_guion = array();

	if(!empty($guiones)){
		foreach($guiones as $d_g){

			$array_guion[$d_g->idNombre]["nombre"] = $d_g->nombre;
			$array_guion[$d_g->idNombre]["mensaje"][] = array("etiqueta" => $d_g->etiqueta, "texto" => $d_g->mensaje);
		}
	}
	$data["guionTelefonico"] = $array_guion;
	//------------------------------------
	//Dennis Castillo [2021-11-02]
	$data["accountsWithPermission"] = array_map(function($arr){ return $arr->account; }, $this->crmProyecto_Model->getAssigned());
	array_push($data["accountsWithPermission"], "DIRECTORGENERAL@AGENTECAPITAL.COM", "DIRECTORCOMERCIAL@AGENTECAPITAL.COM", "MARKETING@AGENTECAPITAL.COM");
	//------------------------------------


$devolverPersona['tipoPersona']='Agente';
$data['personaTipoPersonaCatalogo']=$this->libreriav3->agrupaPersonasParaSelect($personaTipoEnvio,$devolverPersona);
            ($this->tank_auth->get_IDVend()>0) ? $data['imprimirSelecVendedor']=false:$data['imprimirSelecVendedor']=true;
            //$datos['imprimirSelecVendedor']=true;
         
$mesActual=date('n');
$anioActual=date('Y');
$consulta='select if(sum(PuntosGenerados) is null,0, sum(PuntosGenerados)) as puntos  from puntaje where Usuario="'.$correoProcedente.'" and year(FechaRegistro)='.$anioActual.' and month(FechaRegistro)='.$mesActual;

$meses=$this->libreriav3->devolverMeses();
$anioAntes=$anioActual-1;
$anioEnCurso=array();
$anioAnterior=array();

$data['puntosMesActual']=$this->db->query($consulta)->result()[0]->puntos;

foreach ($meses as $keyMeses => $valueMeses) 
{
	$anioEnCurso[$keyMeses]['mes']=$valueMeses;
	$anioEnCurso[$keyMeses]['anio']=$anioActual;
	$consulta='select if(sum(PuntosGenerados) is null,0, sum(PuntosGenerados)) as puntos  from puntaje where Usuario="'.$correoProcedente.'" and year(FechaRegistro)='.$anioActual.' and month(FechaRegistro)='.$keyMeses;
	$anioEnCurso[$keyMeses]['puntos']=$this->db->query($consulta)->result()[0]->puntos;
			$queryPagados = "select (count(Usuario)) as pagado from clientes_actualizapuntospagados where cancelado=0 and Usuario='".$correoProcedente."'  and anio=".$anioActual." and mes=".$keyMeses;
     $anioEnCurso[$keyMeses]['estaPagado']=$this->db->query($queryPagados)->result()[0]->pagado;



	$anioAnterior[$keyMeses]['mes']=$valueMeses;
	$anioAnterior[$keyMeses]['anio']=$anioAntes;
	$consulta='select if(sum(PuntosGenerados) is null,0, sum(PuntosGenerados)) as puntos  from puntaje where Usuario="'.$correoProcedente.'" and year(FechaRegistro)='.$anioAntes.' and month(FechaRegistro)='.$keyMeses;
	$anioAnterior[$keyMeses]['puntos']=$this->db->query($consulta)->result()[0]->puntos;
			$queryPagados = "select (count(Usuario)) as pagado from clientes_actualizapuntospagados where cancelado=0 and Usuario='".$correoProcedente."'  and anio=".$anioAntes." and mes=".$keyMeses;
     $anioAnterior[$keyMeses]['estaPagado']=$this->db->query($queryPagados)->result()[0]->pagado;

}
$data['anioEnCurso']=$anioEnCurso;
$data['anioAnterior']=$anioAnterior;

if((int)$this->tank_auth->get_IDVend()>0){$datos['imprimirSelecVendedor']=true;}


	//MiguelJaime 15-02-2023***************

	$data['casado']=$this->getDato('EdoCivil','CASADO');
	$data['casado_hijos']=$this->getDato('EdoCivil','CASADOCONHIJOS');
	$data['divorciado']=$this->getDato('EdoCivil','DIVORCIADOS');
	$data['divorciado_hijos']=$this->getDato('EdoCivil','DIVORCIADOSCONHIJOS');
	$data['soltero']=$this->getDato('EdoCivil','SOLTERO');
	$data['soltero_hijos']=$this->getDato('EdoCivil','SOLTEROCONHIJOS');
	$data['unionlibre']=$this->getDato('EdoCivil','UNIONLIBRE');
	$data['unionlibre_hijos']=$this->getDato('EdoCivil','UNIONLIBRECONHIJOS');
	$data['viudo']=$this->getDato('EdoCivil','VIUDO');
	$data['viudo_hijos']=$this->getDato('EdoCivil','VIUDOCONHIJOS');

	$data['MENOSDE18']=$this->getDato('RangodeEdad','MENOSDE18');
    $data['DE19A35']=$this->getDato('RangodeEdad','DE19A35');
    $data['DE36A50']=$this->getDato('RangodeEdad','DE36A50');
    $data['DE51A65']=$this->getDato('RangodeEdad','DE51A65');

    $data['amadecasa']=$this->getDato('Ocupacion','AMADECASA');
    $data['ejecutivo']=$this->getDato('Ocupacion','EJECUTIVO');
    $data['empleado']=$this->getDato('Ocupacion','EMPLEADO');
    $data['empresario']=$this->getDato('Ocupacion','EMPRESARIO');
    $data['gerente']=$this->getDato('Ocupacion','GERENTE');
    $data['negociopropio']=$this->getDato('Ocupacion','NEGOCIOPROPIO');
    $data['profesionistaindependiente']=$this->getDato('Ocupacion','PROFESIONISTAINDEPENDIENTE');
    $data['retirado']=$this->getDato('Ocupacion','RETIRADO');
    $data['otrospempleos']=$this->getDato('Ocupacion','OTROSEMPLEOS');
    $data['estudiante']=$this->getDato('Ocupacion','ESTUDIANTE');


    $data['AMIGODEESCUELA']=$this->getDato('FuenteProspecto','AMIGODEESCUELA');
    $data['VECINOS']=$this->getDato('FuenteProspecto','VECINOS');
    $data['AMIGODEFAMILIA']=$this->getDato('FuenteProspecto','AMIGODEFAMILIA');
    $data['CONOCIDOPASATIEMPOS']=$this->getDato('FuenteProspecto','CONOCIDOPASATIEMPOS');
    $data['FAMPROPIAOCONYUGUE']=$this->getDato('FuenteProspecto','FAMPROPIAOCONYUGUE');
    $data['CONOCIDOGRUPOSOCIAL']=$this->getDato('FuenteProspecto','CONOCIDOGRUPOSOCIAL');
    $data['CONOCIDOACTIVICOMUNIDAD']=$this->getDato('FuenteProspecto','CONOCIDOACTIVICOMUNIDAD');
    $data['CONOCIDOANTIGUOEMPLEO']=$this->getDato('FuenteProspecto','CONOCIDOANTIGUOEMPLEO');
    $data['PERSONASHACENEGOCIO']=$this->getDato('FuenteProspecto','PERSONASHACENEGOCIO');
    $data['CENTRODEINFLUENCIA']=$this->getDato('FuenteProspecto','CENTRODEINFLUENCIA');

    $data['HABILIDADEXCELENTE']=$this->getDato('HabilidadRef','EXCELENTE');
    $data['HABILIDADBUENA']=$this->getDato('HabilidadRef','BUENA');
    $data['HABILIDADREGULAR']=$this->getDato('HabilidadRef','REGULAR');

    $data['MENOSDE25000']=$this->getDato('IngresoMensual','MENOSDE$25000');
    $data['DE25000A60000']=$this->getDato('IngresoMensual','DE$25000A$60000');
    $data['DE6000A100000']=$this->getDato('IngresoMensual','DE$6000A$100000');
    $data['MASDE100000']=$this->getDato('IngresoMensual','MASDE$100000');

    $data['FACILMENTE']=$this->getDato('PosibiAcercamiento','FACILMENTE');
    $data['NOMUYDIFICIL']=$this->getDato('PosibiAcercamiento','NOMUYDIFICIL');
    $data['CONDIFICULTAD']=$this->getDato('PosibiAcercamiento','CONDIFICULTAD');

    $data['bant_auth1']=$this->getDato('bant_aut','1');
    $data['bant_auth2']=$this->getDato('bant_aut','2');
    $data['bant_auth3']=$this->getDato('bant_aut','3');

    $data['bant_need1']=$this->getDato('bant_need','1');
    $data['bant_need2']=$this->getDato('bant_need','2');
    $data['bant_need3']=$this->getDato('bant_need','3');

    $data['bant_timing_inmediato']=$this->getDato('bant_timing','Inmediato');
    $data['bant_timing_sin_urgencia']=$this->getDato('bant_timing','Sin urgencia');
    $data['bant_timing_largo_plazo']=$this->getDato('bant_timing','Largo Plazo');

	$this->load->view('crmproyecto/seguimientoProspecto',$data);
			
}
//----------------------------------------------------------------------------
   /*=============================SE CONECTA A BD DE FIANZAS===================================*/
  function  conexionCS(){

$idMaxSVS=$this->db->query("select (max(id_SVS)) as maximo from clientes_actualiza where id_bd_referencia=1");
$bdCapital = $this->load->database('capitalSegurosFianzas', true);//INSTACEAMOS BD 
if($idMaxSVS->result()[0]->maximo=='')
{$row=$bdCapital->query('select id, details from wp_svs_submits where id>11');
}
else
{	 
 $row=$bdCapital->query("select id, details from wp_svs_submits where id>".$idMaxSVS->result()[0]->maximo);
     }


     foreach ($row->result() as  $value) {

  	$bandInsertar=0;
     	//$arreglo=explode("Q: ",$value->details);
     	$valor=str_replace('Q: "Nombre, Email, Teléfono"','',$value->details);
        $valor2=explode('*',$valor);
        $telefono=$valor2[0];
        $nombre=str_replace('Entered name: ','',$valor2[1]);
        $email=str_replace('Entered e-mail: ','',$valor2[2]);
        $insert='insert into clientes_actualiza  (actualiza, IDCont, TipoEnt, Nombre, ApellidoM, ApellidoP,EMail1,Telefono1,Usuario,RazonSocial,RFC,callcenter,EstadoActual,id_SVS,tipoSeguroSVS,id_bd_referencia) ';

        $insert=$insert.'values ("clienteWeb",0, 0,"","","';
        $insert=$insert.$nombre.'","'.$email.'","';
        $insert=$insert.$telefono.'","GERENTE@FIANZASCAPITAL.COM","","",null,"DIMENSION",'.$value->id.',"",1)';
        $this->db->query($insert);

    		     
	}




  }
   /*==========================================================================================*/


	function index(){
		
		if (!$this->tank_auth->is_logged_in()) {
			redirect('/auth/login/');
		} else {
			if($this->tank_auth->get_usermail()=="GERENTE@FIANZASCAPITAL.COM"){$this->conexionCS();}
			//$this->conexionCS();

			$correoProcedente		= $this->tank_auth->get_usermail();
			$data_search['id']		= $this->capsysdre->IDxEmail($correoProcedente);
			$data_search['role']	= "OPERATIVO";  //pasamos este dato para qeu la consulta traiga los del vendedor

			/*BUSCAMOS CLIENTE SIKAS  
			$data_result = $this->webservice_sicas_soap->GetClientp100($data_search);	
			$data['data_result']=$data_result;*/

			$nombrep=$this->input->post('nomsik');
		    if($nombrep!=""){
				$data_result = $this->capsysdre_actividades->ListaClienteProspecto($nombrep);	
				$data['data_result']=$data_result;
            }

			/////////////////////////////////////////////////////////////////////////////////////////////PARA DIMENSIONADOS

			 $sqlConsultadimension = "Select * From `clientes_actualiza` Where `Usuario`='".$correoProcedente."' And `EstadoActual` = 'DIMENSION' And `callcenter` IS NULL Order By `ApellidoP` Asc ";
			$queryConsultaDimension	= $this->db->query($sqlConsultadimension);

			$sqlConsultaPuntosGlobales = "select sum(pj.PuntosGenerados) as globalito from puntaje pj left join clientes_actualiza ca on ca.IDCli=pj.IDCliente where ca.callcenter is null and pj.Usuario='".$correoProcedente."' group by pj.Usuario
									 ";
			$queryPuntosGlobales	= $this->db->query($sqlConsultaPuntosGlobales);

			/////////////////////////////////////////////////////////////////////////////////////////PARA PERFILADOS

			$sqlConsultaperfilados = "Select * From `clientes_actualiza` Where `Usuario`='".$correoProcedente."' And `EstadoActual` = 'PERFILADO' And
					`callcenter` IS NULL
				Order By
					 `ApellidoP` Asc
									 ";
			$queryConsultaperfilados	= $this->db->query($sqlConsultaperfilados);

			$sqlconsultaPuntosPerfilados = "
				select sum(pj.PuntosGenerados) as perfiladito from puntaje pj
				 left join clientes_actualiza ca on ca.IDCli=pj.IDCliente
 where ca.callcenter is null
				and pj.Usuario='".$correoProcedente."'  and pj.EdoActual='PERFILADO'
				group by pj.Usuario
									 ";
			$queryPuntosperfilados	= $this->db->query($sqlconsultaPuntosPerfilados);



			///////////////////////////////////////////////////////////////////////////////////// PARA CONTACTADOS


			$sqlConsultacontactados = "
				Select
					*
				From
					`clientes_actualiza`
				Where
					`Usuario`='".$correoProcedente."'
					And
					`EstadoActual` = 'CONTACTADO'
					And
					`callcenter` IS NULL
				Order By
					 `ApellidoP` Asc
									 ";
			$queryConsultacontactados	= $this->db->query($sqlConsultacontactados);


			$sqlconsultaPuntosContactados = "
				select sum(pj.PuntosGenerados) as contactaditos from puntaje pj
				 left join clientes_actualiza ca on ca.IDCli=pj.IDCliente
 where ca.callcenter is null
				and pj.Usuario='".$correoProcedente."'  and pj.EdoActual='CONTACTADO'
				group by pj.Usuario
									 ";
			$queryPuntoscontactados	= $this->db->query($sqlconsultaPuntosContactados);



			///////////////////////////////////////////////////////////////////////////////////// PARA REGISTRADAS CITAS

			$sqlConsultaRegistrados = "
				Select
					*
				From
					`clientes_actualiza`
				Where
					`Usuario`='".$correoProcedente."'
					And
					`EstadoActual` = 'REGISTRADO'
					And
					`callcenter` IS NULL
				Order By
					 `ApellidoP` Asc
									 ";
			$queryConsultaRegistrados	= $this->db->query($sqlConsultaRegistrados);


			$sqlconsultaPuntosRegistrados = "
				select sum(pj.PuntosGenerados) as registraditos from puntaje pj
				 left join clientes_actualiza ca on ca.IDCli=pj.IDCliente
 where ca.callcenter is null
				and pj.Usuario='".$correoProcedente."'  and pj.EdoActual='REGISTRADO'
				group by pj.Usuario
									 ";
			$queryPuntosRegistrados	= $this->db->query($sqlconsultaPuntosRegistrados);



			
			///////////////////////////////////////////////////////////////////////////////////// COTIZADOS 

			$sqlConsultaCotizados = "
select cat.IDCli,cat.ApellidoP,cat.ApellidoM,cat.Nombre,cat.Telefono1,cat.EMail1,cat.EstadoActual,pj.FolioActividad,pj.idSicas
From
clientes_actualiza cat
inner join
puntaje pj on cat.IDCli=pj.IDCliente
Where
`cat`.`Usuario`='".$correoProcedente."'
And
(`cat`.`EstadoActual` = 'COTIZADO' And
					`callcenter` IS NULL)
And
(`pj`.`EdoActual`='COTIZADO' and `pj`.`PuntosGenerados`>0)
Order By
`ApellidoP` Asc
									 ";// en la consulta los puntos mayores de cero es para elimnar la de vehiculos porque vehiculos no genera puntos
			$queryConsultaCotizados	= $this->db->query($sqlConsultaCotizados);


			$sqlconsultaPuntosCotizados = "
				select sum(pj.PuntosGenerados) as cotizaditos from puntaje pj
				 left join clientes_actualiza ca on ca.IDCli=pj.IDCliente
 where ca.callcenter is null
				and pj.Usuario='".$correoProcedente."'  and pj.EdoActual='COTIZADO'
				group by pj.Usuario
									 ";
			$queryPuntosCotizados	= $this->db->query($sqlconsultaPuntosCotizados);

			///////////////////////////////////////////////////////////////////////////////////// PAGADOS 


			$sqlConsultaPagados = "
			Select cat.IDCli,cat.ApellidoP,cat.ApellidoM,cat.Nombre,cat.Telefono1,cat.EMail1,cat.EstadoActual,pj.FolioActividad,pj.idSicas
From
clientes_actualiza cat
inner join
puntaje pj on cat.IDCli=pj.IDCliente
Where
`cat`.`Usuario`='".$correoProcedente."'
And
(`cat`.`EstadoActual` = 'PAGADO' And
					`callcenter` IS NULL)
And
(`pj`.`EdoActual`='COTIZADO') 
Order By
`ApellidoP` Asc
									 "; 
			$queryConsultaPagados	= $this->db->query($sqlConsultaPagados);


			$sqlconsultaPuntosPagados = "
				select sum(pj.PuntosGenerados) as pagaditos from puntaje pj
				 left join clientes_actualiza ca on ca.IDCli=pj.IDCliente
 where ca.callcenter is null
				and pj.Usuario='".$correoProcedente."'  and pj.EdoActual='PAGADO'
				group by pj.Usuario
									 ";
			$queryPuntosPagados	= $this->db->query($sqlconsultaPuntosPagados);


			///////////////////////////////////////////////////////////////////////////////////// 

			$data['ListaClientes']		= $this->capsysdre->ListaClientes($this->input->get('busquedaUsuario', TRUE),$correoProcedente);

			 $data['queryConsultaDimension'] = $queryConsultaDimension;
			 $data['queryPuntosGlobales']= $queryPuntosGlobales;
			 $data['queryConsultacontactados']= $queryConsultacontactados;
			 $data['queryConsultaRegistrados']= $queryConsultaRegistrados;
			 $data['queryConsultaCotizados']= $queryConsultaCotizados; 
             $data['queryConsultaPagados']= $queryConsultaPagados; 


			 $data['queryConsultaperfilados']= $queryConsultaperfilados;
			 $data['queryPuntosperfilados']= $queryPuntosperfilados;
			 $data['queryPuntoscontactados']= $queryPuntoscontactados;
			 $data['queryPuntosRegistrados']= $queryPuntosRegistrados;
             $data['queryPuntosCotizados']= $queryPuntosCotizados;
             $data['queryPuntosPagados']= $queryPuntosPagados;

			$data['muestraCalendario']=$this->citaRegistrada;
			$data['citas']=$this->fullcalendar_model->devuelveCitasActivasPorUsuarios();
			$data['idCliente']=$this->idCliente;

			if($this->tank_auth->get_View()!= "App"){
				$this->load->view('crmproyecto/principal',$data);
				//$this->load->view('crmproyecto/agregarProspecto',$data);
			} 
			else {$this->load->view('crmproyecto/principalApp',$data);}
			
			
		}
	}
//----------------------------------------------------------------------------------------------------------------------------------------------------
	function Eliminar(){

		if (!$this->tank_auth->is_logged_in()) {
			redirect('/auth/login/');
		} else {

           	$IDCli2=$this->input->get('IDCL', TRUE);
           	$fecharegistro=(string)date('Y-m-d H:i:s');
			$correoProcedente=$this->tank_auth->get_usermail();
			$EdoAnt=$this->input->get('EDOANT', TRUE);
          	$sqlInsert_Referencia = "Update `clientes_actualiza` set `EstadoActual` = 'ELIMINADO' where `IDCli`='".$IDCli2."'";
			$this->db->query($sqlInsert_Referencia);
			$referencia = $this->db->insert_id();
			$sqlInsert_grabapuntos = "Insert Ignore Into `puntaje` (`Usuario`, `IDCliente`,`FechaRegistro`,`EdoAnterior`,`EdoActual`,`PuntosGenerados`) Values('".$correoProcedente."','".$IDCli2."','".$fecharegistro."', '".$EdoAnt."','ELIMINADO','0');";
			$this->db->query($sqlInsert_grabapuntos);
			$referencia = $this->db->insert_id();
			$respuesta['mensaje']="El prospecto se ha eliminado";
			$respuesta['row']=$this->input->get('row', TRUE);
			$respuesta['respuesta']='Eliminar';
			echo json_encode($respuesta);
            //redirect('crmproyecto/Reportes');
            //$this->Reportes();
       	}
    }
//-------------------------------------------------------------------------------------------------------------------------------
    function Reportes(){

		if (!$this->tank_auth->is_logged_in()) {
			redirect('/auth/login/');
		} else {
            //DETERMINAMOS CORREO PROSCEDENTE
           // $correoForm = $this->input->get('vendedorp', TRUE);
            $correoForm = $this->input->post('vendedorp', TRUE);          	
            if ($correoForm != ""){$this->CalculaInfo($correoForm);}
            else{	
		 		$correoProcedente=$this->tank_auth->get_usermail();
		 		$this->CalculaInfo($correoProcedente);
		    }
       	}//fin del Else basico de la funcion
    }

//-------------------------------------------------------------------------------------------------------------------------------
    function ReportesTablero(){

		if (!$this->tank_auth->is_logged_in()) {
			redirect('/auth/login/');
		} else {
            //DETERMINAMOS CORREO PROSCEDENTE
           // $correoForm = $this->input->get('vendedorp', TRUE);
            $correoForm = $this->input->post('vendedorp', TRUE);          	
            if ($correoForm != "")
            {
               $this->CalculaInfoClientes($correoForm);
            }
            else
            {	
		 		$correoProcedente=$this->tank_auth->get_usermail();
		 		$this->CalculaInfoClientes($correoProcedente);
		    }
       	}//fin del Else basico de la funcion
    }
	
	function TableroClientes()
	{
		if (!$this->tank_auth->is_logged_in()) {
			redirect('/auth/login/');
		} else {
            //DETERMINAMOS CORREO PROSCEDENTE
			
			$correoForm = $this->input->get_post('vendedorp', TRUE);

            if ($correoForm != ""){
				// echo "Correo Form Con Info";
				$this->CalculaInfoClientes($correoForm);
            } else {
				// echo "Correo Form SIN Info";
				$correoProcedente	= $this->tank_auth->get_usermail();
		 		$this->CalculaInfoClientes($correoProcedente);
		    }

       	}//fin del Else basico de la funcion
    }
//-------------------------------------------------------------------------------------------------------------------------------
     function CalculaInfo($EmailUserp100)
	 {
		if (!$this->tank_auth->is_logged_in()) {
			redirect('/auth/login/');
		} else {

			$correoProcedente=$EmailUserp100;

			/////////Sumas PERFIL DE PROSPECTO PARA GRAFICAAS////////////////////////// 

			$sqlConsultaPuntosGlobales = "
				select sum(pj.PuntosGenerados) as globalito from puntaje pj
				where pj.Usuario='".$correoProcedente."'
				group by pj.Usuario
									 ";
			$queryPuntosGlobales	= $this->db->query($sqlConsultaPuntosGlobales);


			$sqlconsultaPuntosPerfilados = "
				select sum(pj.PuntosGenerados) as perfiladito from puntaje pj
				 left join clientes_actualiza ca on ca.IDCli=pj.IDCliente
 where ca.callcenter is null
				and pj.Usuario='".$correoProcedente."'  and pj.EdoActual='PERFILADO'
				group by pj.Usuario
									 ";
			$queryPuntosperfilados	= $this->db->query($sqlconsultaPuntosPerfilados);

				$sqlconsultaPuntosContactados = "
				select sum(pj.PuntosGenerados) as contactaditos from puntaje pj
				 left join clientes_actualiza ca on ca.IDCli=pj.IDCliente
 where ca.callcenter is null
				and pj.Usuario='".$correoProcedente."'  and pj.EdoActual='CONTACTADO'
				group by pj.Usuario
									 ";
			$queryPuntoscontactados	= $this->db->query($sqlconsultaPuntosContactados);

				$sqlconsultaPuntosRegistrados = "
				select sum(pj.PuntosGenerados) as registraditos from puntaje pj
				 left join clientes_actualiza ca on ca.IDCli=pj.IDCliente
 where ca.callcenter is null
				and pj.Usuario='".$correoProcedente."'  and pj.EdoActual='REGISTRADO'
				group by pj.Usuario
									 ";
			$queryPuntosRegistrados	= $this->db->query($sqlconsultaPuntosRegistrados);

				$sqlconsultaPuntosCotizados = "
				select sum(pj.PuntosGenerados) as cotizaditos from puntaje pj
				 left join clientes_actualiza ca on ca.IDCli=pj.IDCliente
 where ca.callcenter is null
				and pj.Usuario='".$correoProcedente."'  and pj.EdoActual='COTIZADO'
				group by pj.Usuario
									 ";
			$queryPuntosCotizados	= $this->db->query($sqlconsultaPuntosCotizados);



		    $sqlconsultaPuntosPagados = "
				select sum(pj.PuntosGenerados) as pagaditos from puntaje pj
				where pj.Usuario='".$correoProcedente."'  and pj.EdoActual='PAGADO'
				group by pj.Usuario
									 ";
			$queryPuntosPagados	= $this->db->query($sqlconsultaPuntosPagados);


			/////////FUENTE PROSPECTO////////////////////////// 

			 $sqlconsultaAmigosescuela = "
				select      count(ca.IDCli) as Amigosescuela from clientes_actualiza ca 
				where ca.Usuario='".$correoProcedente."'
				and ca.FuenteProspecto='AMIGODEESCUELA' and ca.EstadoActual<>'ELIMINADO'
				group by ca.Usuario
									 ";
			$queryAmigosescuela	= $this->db->query($sqlconsultaAmigosescuela);

			 $sqlconsultaAmigosfamilia = "
				select      count(ca.IDCli) as Amigosfamilia from clientes_actualiza ca 
				where ca.Usuario='".$correoProcedente."'
				and ca.FuenteProspecto='AMIGODEFAMILIA' and ca.EstadoActual<>'ELIMINADO'
				group by ca.Usuario
									 ";
			$queryAmigosfamilia	= $this->db->query($sqlconsultaAmigosfamilia);

			
			$sqlconsultaVecinos = "
				select      count(ca.IDCli) as Vecinos from clientes_actualiza ca 
				where ca.Usuario='".$correoProcedente."'
				and ca.FuenteProspecto='VECINOS' and ca.EstadoActual<>'ELIMINADO'
				group by ca.Usuario
									 ";
			$queryVecinos	= $this->db->query($sqlconsultaVecinos);


			$sqlconsultaConocidospasatiempos = "
				select      count(ca.IDCli) as Conocidospasatiempos from clientes_actualiza ca 
				where ca.Usuario='".$correoProcedente."'
				and ca.FuenteProspecto='CONOCIDOPASATIEMPOS' and ca.EstadoActual<>'ELIMINADO'
				group by ca.Usuario
									 ";
			$queryConocidospasatiempos	= $this->db->query($sqlconsultaConocidospasatiempos);


			$sqlconsultaFampropia = "
				select      count(ca.IDCli) as Fampropia from clientes_actualiza ca 
				where ca.Usuario='".$correoProcedente."'
				and ca.FuenteProspecto='FAMPROPIAOCONYUGUE' and ca.EstadoActual<>'ELIMINADO'
				group by ca.Usuario
									 ";
			$queryFampropia	= $this->db->query($sqlconsultaFampropia);


			$sqlconsultaGposocial = "
				select      count(ca.IDCli) as Gposocial from clientes_actualiza ca 
				where ca.Usuario='".$correoProcedente."'
				and ca.FuenteProspecto='CONOCIDOGRUPOSOCIAL' and ca.EstadoActual<>'ELIMINADO'
				group by ca.Usuario
									 ";
			$queryGposocial	= $this->db->query($sqlconsultaGposocial);


			$sqlconsultaComunidad = "
				select      count(ca.IDCli) as Comunidad from clientes_actualiza ca 
				where ca.Usuario='".$correoProcedente."'
				and ca.FuenteProspecto='CONOCIDOACTIVICOMUNIDAD' and ca.EstadoActual<>'ELIMINADO'
				group by ca.Usuario
									 ";
			$queryComunidad	= $this->db->query($sqlconsultaComunidad);


			$sqlconsultaAntempleo = "
				select      count(ca.IDCli) as Antempleo from clientes_actualiza ca 
				where ca.Usuario='".$correoProcedente."'
				and ca.FuenteProspecto='CONOCIDOANTIGUOEMPLEO' and ca.EstadoActual<>'ELIMINADO'
				group by ca.Usuario
									 ";
			$queryAntempleo	= $this->db->query($sqlconsultaAntempleo);


			$sqlconsultaNegocio = "
				select      count(ca.IDCli) as Negocio from clientes_actualiza ca 
				where ca.Usuario='".$correoProcedente."'
				and ca.FuenteProspecto='PERSONASHACENEGOCIO' and ca.EstadoActual<>'ELIMINADO'
				group by ca.Usuario
									 ";
			$queryNegocio	= $this->db->query($sqlconsultaNegocio);


			$sqlconsultaInfluencia = "
				select      count(ca.IDCli) as Influencia from clientes_actualiza ca 
				where ca.Usuario='".$correoProcedente."'
				and ca.FuenteProspecto='CENTRODEINFLUENCIA' and ca.EstadoActual<>'ELIMINADO'
				group by ca.Usuario
									 ";
			$queryInfluencia	= $this->db->query($sqlconsultaInfluencia);

		
			$data['queryAmigosescuela']= $queryAmigosescuela;
			$data['queryAmigosfamilia']= $queryAmigosfamilia;
			$data['queryVecinos']= $queryVecinos;
       		$data['queryConocidospasatiempos']= $queryConocidospasatiempos;
            $data['queryFampropia']= $queryFampropia;

            $data['queryGposocial']= $queryGposocial;
			$data['queryComunidad']= $queryComunidad;
			$data['queryAntempleo']= $queryAntempleo;
       		$data['queryNegocio']= $queryNegocio;
            $data['queryInfluencia']= $queryInfluencia;
         
           /////////INFRESO MENSUAL//////////////////////////

             $sqlconsultamenos25  = "
				select      count(ca.IDCli) as menos25 from clientes_actualiza ca 
				where ca.Usuario='".$correoProcedente."'
				and ca.IngresoMensual='MENOSDE$25000' and ca.EstadoActual<>'ELIMINADO'
				group by ca.Usuario
									 ";
			$querymenos25	= $this->db->query($sqlconsultamenos25);

			  $sqlconsultaentre25y60  = "
				select      count(ca.IDCli) as entre25y60 from clientes_actualiza ca 
				where ca.Usuario='".$correoProcedente."'
				and ca.IngresoMensual='DE$25000A$60000' and ca.EstadoActual<>'ELIMINADO'
				group by ca.Usuario
									 ";
			$queryentre25y60	= $this->db->query($sqlconsultaentre25y60);


  			$sqlconsultaentre60y100  = "
				select      count(ca.IDCli) as entre60y100 from clientes_actualiza ca 
				where ca.Usuario='".$correoProcedente."'
				and ca.IngresoMensual='DE$6000A$100000' and ca.EstadoActual<>'ELIMINADO'
				group by ca.Usuario
									 ";
			$queryentre60y100	= $this->db->query($sqlconsultaentre60y100);


 			 $sqlconsultamas100  = "
				select      count(ca.IDCli) as mas100 from clientes_actualiza ca 
				where ca.Usuario='".$correoProcedente."'
				and ca.IngresoMensual='MASDE$100000' and ca.EstadoActual<>'ELIMINADO'
				group by ca.Usuario
									 ";
			$querymas100	= $this->db->query($sqlconsultamas100);

			 $data['querymenos25']= $querymenos25;
			$data['queryentre25y60']= $queryentre25y60;
			$data['queryentre60y100']= $queryentre60y100;
       		$data['querymas100']= $querymas100;

       		 /////////RANGO EDAD//////////////////////////


             $sqlconsultamenos18  = "
				select      count(ca.IDCli) as menos18 from clientes_actualiza ca 
				where ca.Usuario='".$correoProcedente."'
				and ca.RangodeEdad='MENOSDE18' and ca.EstadoActual<>'ELIMINADO'
				group by ca.Usuario
									 ";
			$querymenos18	= $this->db->query($sqlconsultamenos18);

			 $sqlconsultade19a35  = "
				select      count(ca.IDCli) as de19a35 from clientes_actualiza ca 
				where ca.Usuario='".$correoProcedente."'
				and ca.RangodeEdad='DE19A35' and ca.EstadoActual<>'ELIMINADO'
				group by ca.Usuario
									 ";
			$queryde19a35	= $this->db->query($sqlconsultade19a35);

			 $sqlconsultade36a50  = "
				select      count(ca.IDCli) as de36a50 from clientes_actualiza ca 
				where ca.Usuario='".$correoProcedente."'
				and ca.RangodeEdad='DE36A50' and ca.EstadoActual<>'ELIMINADO'
				group by ca.Usuario
									 ";
			$queryde36a50	= $this->db->query($sqlconsultade36a50);

			 $sqlconsultade51a65  = "
				select      count(ca.IDCli) as de51a65 from clientes_actualiza ca 
				where ca.Usuario='".$correoProcedente."'
				and ca.RangodeEdad='DE51A65' and ca.EstadoActual<>'ELIMINADO'
				group by ca.Usuario
									 ";
			$queryde51a65	= $this->db->query($sqlconsultade51a65);

			$data['querymenos18']= $querymenos18;
			$data['queryde19a35']= $queryde19a35;
			$data['queryde36a50']= $queryde36a50;
       		$data['queryde51a65']= $queryde51a65;


       		/////////OCUPACION//////////////////////////


             $sqlconsultaamacasa  = "
				select      count(ca.IDCli) as amacasa from clientes_actualiza ca 
				where ca.Usuario='".$correoProcedente."'
				and ca.Ocupacion='AMADECASA' and ca.EstadoActual<>'ELIMINADO'
				group by ca.Usuario
									 ";
			$queryamacasa	= $this->db->query($sqlconsultaamacasa);

			 $sqlconsultaejecutivo  = "
				select      count(ca.IDCli) as ejecutivo from clientes_actualiza ca 
				where ca.Usuario='".$correoProcedente."'
				and ca.Ocupacion='EJECUTIVO' and ca.EstadoActual<>'ELIMINADO'
				group by ca.Usuario
									 ";
			$queryejecutivo	= $this->db->query($sqlconsultaejecutivo);

			 $sqlconsultaempleado  = "
				select      count(ca.IDCli) as empleado from clientes_actualiza ca 
				where ca.Usuario='".$correoProcedente."'
				and ca.Ocupacion='EMPLEADO' and ca.EstadoActual<>'ELIMINADO'
				group by ca.Usuario
									 ";
			$queryempleado	= $this->db->query($sqlconsultaempleado);

			 $sqlconsultaestudiante  = "
				select      count(ca.IDCli) as estudiante from clientes_actualiza ca 
				where ca.Usuario='".$correoProcedente."'
				and ca.Ocupacion='ESTUDIANTE' and ca.EstadoActual<>'ELIMINADO'
				group by ca.Usuario
									 ";
			$queryestudiante	= $this->db->query($sqlconsultaestudiante);

			 $sqlconsultaempresario  = "
				select      count(ca.IDCli) as empresario from clientes_actualiza ca 
				where ca.Usuario='".$correoProcedente."'
				and ca.Ocupacion='EMPRESARIO' and ca.EstadoActual<>'ELIMINADO'
				group by ca.Usuario
									 ";
			$queryempresario	= $this->db->query($sqlconsultaempresario);

			 $sqlconsultagerente  = "
				select      count(ca.IDCli) as gerente from clientes_actualiza ca 
				where ca.Usuario='".$correoProcedente."'
				and ca.Ocupacion='GERENTE' and ca.EstadoActual<>'ELIMINADO'
				group by ca.Usuario
									 ";
			$querygerente	= $this->db->query($sqlconsultagerente);

			 $sqlconsultanegociop  = "
				select      count(ca.IDCli) as negociop from clientes_actualiza ca 
				where ca.Usuario='".$correoProcedente."'
				and ca.Ocupacion='NEGOCIOPROPIO' and ca.EstadoActual<>'ELIMINADO'
				group by ca.Usuario
									 ";
			$querynegociop	= $this->db->query($sqlconsultanegociop);

			 $sqlconsultaprofesionista  = "
				select      count(ca.IDCli) as profesionista from clientes_actualiza ca 
				where ca.Usuario='".$correoProcedente."'
				and ca.Ocupacion='PROFESIONISTAINDEPENDIENTE' and ca.EstadoActual<>'ELIMINADO'
				group by ca.Usuario
									 ";
			$queryprofesionista	= $this->db->query($sqlconsultaprofesionista);

			 $sqlconsultaretirado  = "
				select      count(ca.IDCli) as retirado from clientes_actualiza ca 
				where ca.Usuario='".$correoProcedente."'
				and ca.Ocupacion='RETIRADO' and ca.EstadoActual<>'ELIMINADO'
				group by ca.Usuario
									 ";
			$queryretirado	= $this->db->query($sqlconsultaretirado);

			 $sqlconsultaotros  = "
				select      count(ca.IDCli) as otros from clientes_actualiza ca 
				where ca.Usuario='".$correoProcedente."'
				and ca.Ocupacion='OTROSEMPLEOS' and ca.EstadoActual<>'ELIMINADO'
				group by ca.Usuario
									 ";
			$queryotros	= $this->db->query($sqlconsultaotros);

			$data['queryamacasa']= $queryamacasa;
			$data['queryejecutivo']= $queryejecutivo;
			$data['queryempleado']= $queryempleado;
       		$data['queryestudiante']= $queryestudiante;
       		$data['queryempresario']= $queryempresario;
			$data['querygerente']= $querygerente;
			$data['querynegociop']= $querynegociop;
       		$data['queryprofesionista']= $queryprofesionista;
       		$data['queryretirado']= $queryretirado;
			$data['queryotros']= $queryotros;


			/////////Estado Civil//////////////////////////

			 $sqlconsultacasado  = "
				select      count(ca.IDCli) as casado from clientes_actualiza ca 
				where ca.Usuario='".$correoProcedente."'
				and ca.EdoCivil='CASADO' and ca.EstadoActual<>'ELIMINADO'
				group by ca.Usuario
									 ";
			$querycasado	= $this->db->query($sqlconsultacasado);

			$sqlconsultacasadoch  = "
				select      count(ca.IDCli) as casadoch from clientes_actualiza ca 
				where ca.Usuario='".$correoProcedente."'
				and ca.EdoCivil='CASADOCONHIJOS' and ca.EstadoActual<>'ELIMINADO'
				group by ca.Usuario
									 ";
			$querycasadoch	= $this->db->query($sqlconsultacasadoch);

			$sqlconsultadivorciado = "
				select      count(ca.IDCli) as divorciado from clientes_actualiza ca 
				where ca.Usuario='".$correoProcedente."'
				and ca.EdoCivil='DIVORCIADOS' and ca.EstadoActual<>'ELIMINADO'
				group by ca.Usuario
									 ";
			$querydivorciado	= $this->db->query($sqlconsultadivorciado);

			$sqlconsultadivorciadoch  = "
				select      count(ca.IDCli) as divorciadoch from clientes_actualiza ca 
				where ca.Usuario='".$correoProcedente."'
				and ca.EdoCivil='DIVORCIADOSCONHIJOS' and ca.EstadoActual<>'ELIMINADO'
				group by ca.Usuario
									 ";
			$querydivorciadoch	= $this->db->query($sqlconsultadivorciadoch);

			$sqlconsultasoltero  = "
				select      count(ca.IDCli) as soltero from clientes_actualiza ca 
				where ca.Usuario='".$correoProcedente."'
				and ca.EdoCivil='SOLTERO' and ca.EstadoActual<>'ELIMINADO'
				group by ca.Usuario
									 ";
			$querysoltero	= $this->db->query($sqlconsultasoltero);

			$sqlconsultasolteroch  = "
				select      count(ca.IDCli) as solteroch from clientes_actualiza ca 
				where ca.Usuario='".$correoProcedente."'
				and ca.EdoCivil='SOLTEROCONHIJOS' and ca.EstadoActual<>'ELIMINADO'
				group by ca.Usuario
									 ";
			$querysolteroch	= $this->db->query($sqlconsultasolteroch);

			$sqlconsultaunionl = "
				select      count(ca.IDCli) as unionl from clientes_actualiza ca 
				where ca.Usuario='".$correoProcedente."'
				and ca.EdoCivil='UNIONLIBRE' and ca.EstadoActual<>'ELIMINADO'
				group by ca.Usuario
									 ";
			$queryunionl	= $this->db->query($sqlconsultaunionl);

			$sqlconsultaunionlch = "
				select      count(ca.IDCli) as unionlch from clientes_actualiza ca 
				where ca.Usuario='".$correoProcedente."'
				and ca.EdoCivil='UNIONLIBRECONHIJOS' and ca.EstadoActual<>'ELIMINADO'
				group by ca.Usuario
									 ";
			$queryunionlch	= $this->db->query($sqlconsultaunionlch);

			$sqlconsultaviudo  = "
				select      count(ca.IDCli) as viudo from clientes_actualiza ca 
				where ca.Usuario='".$correoProcedente."'
				and ca.EdoCivil='VIUDO' and ca.EstadoActual<>'ELIMINADO'
				group by ca.Usuario
									 ";
			$queryviudo	= $this->db->query($sqlconsultaviudo);

			$sqlconsultaviudoch  = "
				select      count(ca.IDCli) as viudoch from clientes_actualiza ca 
				where ca.Usuario='".$correoProcedente."'
				and ca.EdoCivil='VIUDOCONHIJOS' and ca.EstadoActual<>'ELIMINADO'
				group by ca.Usuario
									 ";
			$queryviudoch	= $this->db->query($sqlconsultaviudoch);

			$data['querycasado']= $querycasado;
			$data['querycasadoch']= $querycasadoch;
			$data['querydivorciado']= $querydivorciado;
       		$data['querydivorciadoch']= $querydivorciadoch;
       		$data['querysoltero']= $querysoltero;
			$data['querysolteroch']= $querysolteroch;
			$data['queryunionl']= $queryunionl;
       		$data['queryunionlch']= $queryunionlch;
       		$data['queryviudo']= $queryviudo;
			$data['queryviudoch']= $queryviudoch;

			/////////Tiempo de COnocer Prospectos//////////////////////////

			$sqlconsultamasde5 = "
				select      count(ca.IDCli) as masde5 from clientes_actualiza ca 
				where ca.Usuario='".$correoProcedente."'
				and ca.TiempodeConocerProspec='MASDE5ANIOS' and ca.EstadoActual<>'ELIMINADO'
				group by ca.Usuario
									 ";
			$querymasde5	= $this->db->query($sqlconsultamasde5);

			$sqlconsultadedosa5  = "
				select      count(ca.IDCli) as dedosa5 from clientes_actualiza ca 
				where ca.Usuario='".$correoProcedente."'
				and ca.TiempodeConocerProspec='DE2A5ANIOS' and ca.EstadoActual<>'ELIMINADO'
				group by ca.Usuario
									 ";
			$querydedosa5	= $this->db->query($sqlconsultadedosa5);

			$sqlconsultamenos2 = "
				select      count(ca.IDCli) as menos2 from clientes_actualiza ca 
				where ca.Usuario='".$correoProcedente."'
				and ca.TiempodeConocerProspec='MENOSDE2ANIOS' and ca.EstadoActual<>'ELIMINADO'
				group by ca.Usuario
									 ";
			$querymenos2	= $this->db->query($sqlconsultamenos2);

			$data['querymasde5']= $querymasde5;
       		$data['querydedosa5']= $querydedosa5;
			$data['querymenos2']= $querymenos2;

				/////////Frecuencia Vio//////////////////////////

			$sqlconsultamasde5v = "
				select      count(ca.IDCli) as masde5v from clientes_actualiza ca 
				where ca.Usuario='".$correoProcedente."'
				and ca.FrecuenciaVio='MASDE5VECES' and ca.EstadoActual<>'ELIMINADO'
				group by ca.Usuario
									 ";
			$querymasde5v	= $this->db->query($sqlconsultamasde5v);

			$sqlconsultade3a5v = "
				select      count(ca.IDCli) as de3a5v from clientes_actualiza ca 
				where ca.Usuario='".$correoProcedente."'
				and ca.FrecuenciaVio='DE3A5VECES' and ca.EstadoActual<>'ELIMINADO'
				group by ca.Usuario
									 ";
			$queryde3a5v	= $this->db->query($sqlconsultade3a5v);

			$sqlconsultade1a2v = "
				select      count(ca.IDCli) as de1a2v from clientes_actualiza ca 
				where ca.Usuario='".$correoProcedente."'
				and ca.FrecuenciaVio='DE1A2VECES' and ca.EstadoActual<>'ELIMINADO'
				group by ca.Usuario
									 ";
			$queryde1a2v	= $this->db->query($sqlconsultade1a2v);

			$sqlconsultanovio = "
				select      count(ca.IDCli) as novio from clientes_actualiza ca 
				where ca.Usuario='".$correoProcedente."'
				and ca.FrecuenciaVio='NOLOVIO' and ca.EstadoActual<>'ELIMINADO'
				group by ca.Usuario
									 ";
			$querynovio	= $this->db->query($sqlconsultanovio);

			$data['querymasde5v']= $querymasde5v;
       		$data['queryde2a5']= $queryde3a5v;
			$data['queryde1a2v']= $queryde1a2v;
			$data['querynovio']= $querynovio;

        /////////posibilidad de Acercamiento//////////////////////////

			$sqlconsultafacil = "
				select      count(ca.IDCli) as facil from clientes_actualiza ca 
				where ca.Usuario='".$correoProcedente."'
				and ca.PosibiAcercamiento='FACILMENTE' and ca.EstadoActual<>'ELIMINADO'
				group by ca.Usuario
									 ";
			$queryfacil	= $this->db->query($sqlconsultafacil);

			$sqlconsultanomuyf = "
				select      count(ca.IDCli) as nomuyf from clientes_actualiza ca 
				where ca.Usuario='".$correoProcedente."'
				and ca.PosibiAcercamiento='NOMUYFACIL' and ca.EstadoActual<>'ELIMINADO'
				group by ca.Usuario
									 ";
			$querynomuyf	= $this->db->query($sqlconsultanomuyf);

			$sqlconsultadifi = "
				select      count(ca.IDCli) as difi from clientes_actualiza ca 
				where ca.Usuario='".$correoProcedente."'
				and ca.PosibiAcercamiento='CONDIFICULTAD' and ca.EstadoActual<>'ELIMINADO'
				group by ca.Usuario
									 ";
			$querydifi	= $this->db->query($sqlconsultadifi);

			$data['queryfacil']= $queryfacil;
       		$data['querynomuyf']= $querynomuyf;
			$data['querydifi']= $querydifi;

		/////////Potencial para dar Referencias//////////////////////////
		
			$sqlconsultaexel = "
				select      count(ca.IDCli) as exel from clientes_actualiza ca 
				where ca.Usuario='".$correoProcedente."'
				and ca.HabilidadRef='EXCELENTE' and ca.EstadoActual<>'ELIMINADO'
				group by ca.Usuario
									 ";
			$queryexel	= $this->db->query($sqlconsultaexel);

			$sqlconsultabuena = "
				select      count(ca.IDCli) as buena from clientes_actualiza ca 
				where ca.Usuario='".$correoProcedente."'
				and ca.HabilidadRef='BUENA' and ca.EstadoActual<>'ELIMINADO'
				group by ca.Usuario
									 ";
			$querybuena	= $this->db->query($sqlconsultabuena);

			$sqlconsultaregular = "
				select      count(ca.IDCli) as regular from clientes_actualiza ca 
				where ca.Usuario='".$correoProcedente."'
				and ca.HabilidadRef='REGULAR' and ca.EstadoActual<>'ELIMINADO'
				group by ca.Usuario
									 ";
			$queryregular	= $this->db->query($sqlconsultaregular);

			$data['queryexel']= $queryexel;
       		$data['querybuena']= $querybuena;
			$data['queryregular']= $queryregular;
	



			//$data['ListaClientes']		= $this->capsysdre->ListaClientes($this->input->get('busquedaUsuario', TRUE),$correoProcedente);
			$data['ListaClientes']		= $this->capsysdre->ListaClientes($this->input->post('busquedaUsuario', TRUE),$correoProcedente);

	    	$data['queryPuntosperfilados']= $queryPuntosperfilados;
			$data['queryPuntoscontactados']= $queryPuntoscontactados;
			$data['queryPuntosRegistrados']= $queryPuntosRegistrados;
        	$data['queryPuntosCotizados']= $queryPuntosCotizados;
       	 	$data['queryPuntosPagados']= $queryPuntosPagados;


            $correoPermisoLista=$this->tank_auth->get_usermail();
       	 	$profileuser=$this->capsysdre->ProfilexEmail($correoPermisoLista);
		 	//$correoescogido=$this->input->get('vendedorp', TRUE);

			if($profileuser=='4' || $profileuser=='3')  //SOLO ES master Y OPERATIVOS
        	{ $data['ListaVendedores']= $this->capsysdre->ListaVendedoresP100();

        	
      		}
      		else
      		{	

               $data['ListaVendedores']=$this->capsysdre->ObtieneUsuarioxEmail($correoProcedente);
               
        	} //fin del else de master

			if($this->tank_auth->get_View()!= "App"){ 
				$this->load->view('crmproyecto/ReporteClientes',$data);
			} else {
				$this->load->view('crmproyecto/ReporteClientesApp',$data);
			}

        }
    }
	
//-------------------------------------------------------------------------------------------------------------------------------
	function CalculaInfoClientes($EmailUserp100)
	{
		if (!$this->tank_auth->is_logged_in()) {
			redirect('/auth/login/');
		} else {
			
			$sqlCalcula_IDVend = "
				Select
					`IDVend`
				From
					`users`
				Where
					`email` = '".$EmailUserp100."'
				;
								 ";
			
			$IdVend					= $this->db->query($sqlCalcula_IDVend)->row()->IDVend;
			
			$correoProcedente		= $EmailUserp100;
            $correoPermisoLista		= $this->tank_auth->get_usermail();
       	 	$profileuser			= $this->capsysdre->ProfilexEmail($correoPermisoLista);
				
		//	$data['ListaClientes']	= $this->capsysdre->ListaClientes($this->input->post('busquedaUsuario', TRUE),$correoProcedente);
			$data['saldo']			= $this->saldo_model->saldo($this->tank_auth->get_user_id());
			$data['ListClientesWs']	= $this->ListaClientesXIdVend($IdVend);	//$this->ListaClientesWsIdVend($IdVend);

			
			
			if($profileuser=='4' || $profileuser=='3'){	//SOLO ES master Y OPERATIVOS
				$data['ListaVendedores']	= $this->capsysdre->ListaVendedoresP100();
      		} else {
				$data['ListaVendedores']	= $this->capsysdre->ObtieneUsuarioxEmail($correoProcedente);
        	} //fin del else de master
			
			if($this->tank_auth->get_View()!= "App"){
				$this->load->view('crmproyecto/TableroClientes',$data);
			} else {
				$this->load->view('crmproyecto/TableroClientesApp',$data);
			}
        }
    }/*! CalculaInfoClientes */
	
	function ListaClientesWsIdVend($IdVend){
				$clientesWs				= $this->webservice_sicas_soap->GetClient_forIdVend(array( "IdVend" => $IdVend, "page" => 1));	// 			$data['clientes']

			$resultClientesWs	= array();
			if($clientesWs["clientes"] != NULL){
				foreach ($clientesWs["clientes"] as $data){
					$dataNew	= array();
						/*
						$dataNew['IDCli']		= $data->IDCli;
						$dataNew['ApellidoP']	= $data->ApellidoP;
						$dataNew['ApellidoM']	= $data->ApellidoM;
						$dataNew['Nombre']		= $data->Nombre;
						$dataNew['RazonSocial']	= $data->RazonSocial;
						$dataNew['RFC']			= $data->RFC;
						$dataNew['EMail1']		= $data->EMail1;
						$dataNew['Telefono1']	= $data->Telefono1;
						*/
						array_push($dataNew,array("IDCli"=>$data->IDCli));
						
//					print_r($dataNew);
					
##					if (isset($data->EMail1) && strlen($data->EMail1) > 5){
						//array_push($data->LineasPersonales,'x');
						if(!empty($data->URL)){

							$IDSRamos = explode('|', $data->URL);

							foreach ($IDSRamos as $value) {
								if(!array_key_exists($value, $resultClientesWs)){
									$SRamo						= $this->catalogos_model->get_NameSubRamo($value);

									$resultClientesWs[$value]	= array(
																	'id'	=> $value,
																	'sramo'	=> $SRamo[0]['nombre'],
																	'data'	=> array($data)
																  );
								}else{
									array_push($resultClientesWs[$value]['data'], $data);
								}
							}

					  	}else{
					  		if(!array_key_exists('54', $resultClientesWs)){
					  			$resultClientesWs['54'] = array('id'=>'54', 'sramo'=>'SIN RAMO','data' =>array($data));		
					  		}else{
					  			array_push($resultClientesWs['54']['data'] , $data);
					  		}
					  		
					  	}
##					}
				}
			}
			
		return
		json_encode($resultClientesWs);
		
				
	}
	
	function ListaClientesXIdVend($IdVend){
		$clientesWs			= $this->webservice_sicas_soap->GetClient_forIdVend(array( "IdVend" => $IdVend, "page" => 1));
		
		$resultClientesWs	= array();
		if($clientesWs["clientes"] != NULL){
			foreach ($clientesWs['clientes'] as $data){
			//	Lp -> Lineas Personales
			//	Vi -> Vida
			//	Da -> Daños
			//	Fi -> Fianzas
			//	Ve -> Vehiculos


			$IDCli						= (string)$data->IDCli;
			$wsdata['TypeFormat']		= 'XML';			
			$wsdata['KeyProcess']		= 'REPORT';
			$wsdata['KeyCode']			= 'HWS_DOCTOS';
			$wsdata['Page']				= '1';
			$wsdata['InfoSort']			= 'CatClientes.IDCli';
			$wsdata['ConditionsAdd']	= '
							Cliente Id;2;0;'.$IDCli.';'.$IDCli.';0;-1;DatDocumentos.IDCli
							! 
							Tipo Documento;0;0;1;1;DatDocumentos.TipoDocto
										  ';
//							! 
//							Tipo Documento;0;0;2;2;DatDocumentos.TipoDocto
			
			$value	= $this->webservice_sicas_soap->getDatosSicas($wsdata);
			//print("<pre>");
			//print_r($value);
			
			$contLp	= 0;
			$contVi	= 0;
			$contDa	= 0;
			$contFi	= 0;
			$contVe	= 0;
			
			if($value->TableControl->MaxRecords != 0){
				foreach($value->TableInfo as $poliza){
					switch($poliza->RamosAbreviacion){
						case "Lineas Personales":
							$contLp++;
						break;
						
						case "Vida":
							$contVi++;
						break;
						
						case "Daños":
							$contDa++;
						break;
						
						case "Fianzas":
							$contFi++;
						break;
						
						case "Vehiculos":
							$contVe++;
						break;
					}				
				}
				$Lp	= $contLp;
				$Vi	= $contVi;
				$Da	= $contDa;
				$Fi	= $contFi;
				$Ve	= $contVe;
			} else {
				$Lp	= '0';
				$Vi	= '0';
				$Da	= '0';
				$Fi	= '0';
				$Ve	= '0';
			}
			
			$resultClientesWs['clientes'][]	= array(
												'IDCli'			=> (string)$data->IDCli,
												'ApellidoP'		=> (string)$data->ApellidoP,
												'ApellidoM'		=> (string)$data->ApellidoM,
												'Nombre'		=> (string)$data->Nombre,
												'RazonSocial'	=> (string)$data->RazonSocial,
												'RFC'			=> (string)$data->RFC,
												'EMail1'		=> (string)$data->EMail1,
												'Telefono1'		=> (string)$data->Telefono1,
												
												'Lp' => $Lp,
												'Vi' => $Vi,
												'Da' => $Da,
												'Fi' => $Fi,
												'Ve' => $Ve,
											  );
			}
		}

		/*

		
		if($clientesWs["clientes"] != NULL){
			foreach ($clientesWs["clientes"] as $data){

				if(!empty($data->URL)){

					$IDSRamos = explode('|', $data->URL);

					foreach ($IDSRamos as $value){
						if(!array_key_exists($value, $resultClientesWs)){
							$SRamo						= $this->catalogos_model->get_NameSubRamo($value);
							$resultClientesWs[$value]	= array(
																	'id'	=> $value,
																	'sramo'	=> $SRamo[0]['nombre'],
																	'data'	=> array($data)
																  );
								}else{
									array_push($resultClientesWs[$value]['data'], $data);
								}
							}
							
					  	} else {
					  		if(!array_key_exists('54', $resultClientesWs)){
					  			$resultClientesWs['54'] = array('id'=>'54', 'sramo'=>'SIN RAMO','data' =>array($data));		
					  		} else {
					  			array_push($resultClientesWs['54']['data'] , $data);
					  		}
						}
			}
		}
		*/	

		return
			//json_encode($resultClientesWs);
			//$clientesWs;
			$resultClientesWs;
		
				
	}
//-------------------------------------------------------------------------------------------------------------------------------
function Emision(){		
		if (!$this->tank_auth->is_logged_in()) {redirect('/auth/login/');} 
		else {			
			   $Cliente=$this->input->post('cliselecEmi', TRUE);
				 if($Cliente>0)
                 {                    
			   		$sqlConsultaDatos = "Select * From `clientes_actualiza` Where `IDCli`='".$Cliente."'";
			   		$queryConsultaDatos	= $this->db->query($sqlConsultaDatos); 
			   		if(!empty($queryConsultaDatos))
                        { 
                             foreach ($queryConsultaDatos->result() as $Registro) { 

                              $apaterno= str_replace(" ", "", $Registro->ApellidoP);
                              $amaterno=str_replace(" ", "", $Registro->ApellidoM);
                              $nombres=str_replace(" ", "_", $Registro->Nombre);
                              $Telefono1=str_replace(" ", "", $Registro->Telefono1);
                              $email=str_replace(" ", "", $Registro->EMail1);

                              $RazonSocial=str_replace(" ", "", $Registro->RazonSocial);

                              $IDCliSikasn=$Registro->IDCliSikas;
                              $IDContacton=$Registro->IDContacto;

                            }
                             $resultado1 = str_replace("@", "-", $email);


						}

                 }

           

                 if($IDCliSikasn>0)//es cliente sikas por la tanto llamo nuevo
                 {
                        $cadenafina="/actividades/agregar/Emision/VEHICULOS/17/Existente?idCliente=".$IDCliSikasn."-".$IDContacton."&clientep=".$Cliente."";
                 } 
                 else
                 {   
                      if($RazonSocial!="")
                      {	

                      	 $cadenafina="/actividades/agregar/Emision/VEHICULOS/17/Nuevo/Moral/".$Cliente."/SAP/SAM/SN/".$Telefono1."/".$resultado1."/".$RazonSocial."/";
                      } 
                      else
                      { 

                         $cadenafina="/actividades/agregar/Emision/VEHICULOS/17/Nuevo/Fisica/".$Cliente."/".$apaterno."/".$amaterno."/".$nombres."/".$Telefono1."/".$resultado1."/SR/";
                      }	  
                 }	

			redirect($cadenafina);


		}
	}

//-------------------------------------------------------------------------------------------------------------------------------
	 function LlamaCapturaEmision(){
		
		if (!$this->tank_auth->is_logged_in()) {
			redirect('/auth/login/');
		} else {
			
			   $Cliente=$this->input->post('cliselecCotiEmi', TRUE);


				 if($Cliente>0)
                 {
                    
			   		$sqlConsultaDatos = "
							Select
							*
							From
							`clientes_actualiza`
								Where
								`IDCli`='".$Cliente."'
									 ";

			   		$queryConsultaDatos	= $this->db->query($sqlConsultaDatos); 

			   		 	if(!empty($queryConsultaDatos))
                        { 
                             foreach ($queryConsultaDatos->result() as $Registro) { 

                              $apaterno= str_replace(" ", "", $Registro->ApellidoP);
                              $amaterno=str_replace(" ", "", $Registro->ApellidoM);
                              $nombres=str_replace(" ", "_", $Registro->Nombre);
                              $Telefono1=str_replace(" ", "", $Registro->Telefono1);
                              $email=str_replace(" ", "", $Registro->EMail1);

                              $RazonSocial=str_replace(" ", "", $Registro->RazonSocial);

                              $IDCliSikasn=$Registro->IDCliSikas;
                              $IDContacton=$Registro->IDContacto;

                            }
                             $resultado1 = str_replace("@", "-", $email);


						}

                 }

           

                 if($IDCliSikasn>0)//es cliente sikas por la tanto llamo nuevo
                 {
                        $cadenafina="/actividades/agregar/CapturaEmision/VEHICULOS/17/Existente?idCliente=".$IDCliSikasn."-".$IDContacton."&clientep=".$Cliente."";
                 } 
                 else
                 {   
                      if($RazonSocial!="")
                      {	

                      	 $cadenafina="/actividades/agregar/CapturaEmision/VEHICULOS/17/Nuevo/Moral/".$Cliente."/SAP/SAM/SN/".$Telefono1."/".$resultado1."/".$RazonSocial."/";
                      } 
                      else
                      { 

                         $cadenafina="/actividades/agregar/CapturaEmision/VEHICULOS/17/Nuevo/Fisica/".$Cliente."/".$apaterno."/".$amaterno."/".$nombres."/".$Telefono1."/".$resultado1."/SR/";
                      }	  
                 }	

			redirect($cadenafina);


		}
	}
//-------------------------------------------------------------------------------------------------------------------------------
	function Limpia($cadena)
	{
       $lista= str_replace("Ñ", "N", $cadena);
       $lista1= str_replace("ñ", "n", $lista);
       $lista2= str_replace("á", "a", $lista1);
       $lista3= str_replace("é", "e", $lista2);
       $lista4= str_replace("í", "i", $lista3);
       $lista5= str_replace("ó", "o", $lista4);
       $lista6= str_replace("ú", "u", $lista5);
       $lista7= str_replace("Á", "A", $lista6);
       $lista8= str_replace("É", "E", $lista7);
       $lista9= str_replace("Í", "I", $lista8);
       $lista0= str_replace("Ó", "O", $lista9);
       $listafin= str_replace("Ú", "U", $lista0);
       $listafin2= strtoupper($listafin);

       return $listafin2;
    }


	

	function InsertaDimension(){ //Modificado [Suemy][2024-06-26]
		
		if (!$this->tank_auth->is_logged_in()) {
			redirect('/auth/login/');
		} else {
			
			$fecharegistro=(string)date('Y-m-d H:i:s');
			if($this->input->post('selectVendedor')!=''){$correoProcedente=$this->input->post('selectVendedor');}
		    else{$correoProcedente=$this->tank_auth->get_usermail();}

			$ApellidoP = $this->Limpia($this->input->post('apellidop'));
            $ApellidoM = $this->Limpia ($this->input->post('apellidom'));
            $Nombre = $this->Limpia ($this->input->post('nombre'));

            $Razon = $this->Limpia ($this->input->post('razon'));
            $rfc = strtoupper ($this->input->post('rfc'));
             //$FuenteProspecto = $this->input->post('fuente');
             $FuenteProspecto			= "DIRECTO";
             $IngresoMensual =  $this->input->post('IngMen');
             $RangodeEdad =  $this->input->post('RangoEdad');
             $Ocupacion =  $this->input->post('ocupacion');
             $EdoCivil =  $this->input->post('estadocivil');
             $TiempodeConocerProspec =  $this->input->post('tiempoconocer');
             $FrecuenciaVio =  $this->input->post('frecuenciavio');
             $PosibiAcercamiento =  $this->input->post('posacercamiento');
             $HabilidadRef =  $this->input->post('habilidadref');
             $EMail2 = strtoupper ($this->input->post('email'));
             $Telefono1 = $this->input->post('celular');
             $tipoEntidad=$this->input->post('tipo');
             $observacion=$this->input->post('observacion');
             $tipo_prospecto=$this->input->post('tipo_prospecto');
             $fNac=$this->input->post('fNac');
             $cp=$this->input->post('codigoPostal');
             $referido = ($this->input->post('referido') != false) ? "Si" : "No";

             $estado="";
             if($tipo_prospecto==0){$estado="DIMENSION";}
             else{$estado="NUEVO";}

				$sqlInsert_Referencia = "Insert Ignore Into `clientes_actualiza` 
									(`actualiza`, `IDCont`,`TipoEnt`,`ApellidoP`,`ApellidoM`,`Nombre`,`RazonSocial`,`RFC`,`EMail1`,`Telefono1`,`fechaActualizacion`,`Usuario`,`EstadoActual`,`FuenteProspecto`,`IngresoMensual`,`RangodeEdad`,`Ocupacion`,`EdoCivil`,`TiempodeConocerProspec`,`FrecuenciaVio`,`PosibiAcercamiento`,`HabilidadRef`,`tipoEntidad`,`observacion`,`tipo_prospecto`,`fecha_nacimiento`,`CP`,`referido`) 
									Values('clienteWeb','0','0','".$ApellidoP."', '".$ApellidoM."','".$Nombre."','".$Razon."','".$rfc."','".$EMail2."','".$Telefono1."','".$fecharegistro."','".$correoProcedente."','".$estado."','".$FuenteProspecto."','".$IngresoMensual."','".$RangodeEdad."','".$Ocupacion."','".$EdoCivil."','".$TiempodeConocerProspec."','".$FrecuenciaVio."','".$PosibiAcercamiento."','".$HabilidadRef."','".$tipoEntidad."','".$observacion."','".$tipo_prospecto."','".$fNac."','".$cp."','".$referido."');";                         
				$this->db->query($sqlInsert_Referencia);
				$referencia = $this->db->insert_id();

				if($this->tank_auth->get_View()!= "App"){
					$this->proyecto100();
				} else {
					redirect('/crmproyecto/proyecto100');
				}
		}
	}


	function InsertaDimension_generico(){ //Modificado [Suemy][2024-06-26]
		
		if (!$this->tank_auth->is_logged_in()) {
			redirect('/auth/login/');
		} else {
			
			if($this->input->post('selectVendedor')!=''){
				$correoProcedente=$this->input->post('selectVendedor');
			} else {
				$correoProcedente=$this->tank_auth->get_usermail();
			}
			$fecharegistro				= (string)date('Y-m-d H:i:s');
			$ApellidoP 					= $this->Limpia($this->input->post('apellidop_generico'));
            $ApellidoM 					= $this->Limpia ($this->input->post('apellidom_generico'));
            $Nombre 					= $this->Limpia ($this->input->post('nombre_generico'));
            $Razon 						= $this->Limpia ($this->input->post('razon_generico'));
            $rfc 						= strtoupper ($this->input->post('rfc_generico'));
            //$FuenteProspecto = $this->input->post('fuente');
            $FuenteProspecto			= "DIRECTO";
            $IngresoMensual				= $this->input->post('IngMen_generico');
            $RangodeEdad 				= $this->input->post('RangoEdad_generico');
            $Ocupacion 					= $this->input->post('ocupacion_generico');
            $EdoCivil 					= $this->input->post('estadocivil_generico');
            $TiempodeConocerProspec		= $this->input->post('tiempoconocer_generico');
            $FrecuenciaVio				= $this->input->post('frecuenciavio_generico');
            $PosibiAcercamiento			= $this->input->post('posacercamiento_generico');
            $HabilidadRef				= $this->input->post('habilidadref_generico');
            $EMail2						= strtoupper($this->input->post('email_generico'));
            $Telefono1					= $this->input->post('celular_generico');
            $tipoEntidad				= $this->input->post('tipo_generico');
            $observacion				= $this->input->post('observacion_generico');
            $leads						= "http://www.fianzascapital.com.mx";
            $referido 					= ($this->input->post('referido') != false) ? "Si" : "No";
            //Modificacion MJ
			//$tipo_prospecto				= "";
			$tipo_prospecto				= "1";
			//Fin de modificacion
			
			$sqlInsert_Referencia		= "

				Insert Ignore Into 
					`clientes_actualiza` 
					
					(`actualiza`, `IDCont`,`TipoEnt`,`ApellidoP`,`ApellidoM`,`Nombre`,`RazonSocial`,`RFC`,`EMail1`,`Telefono1`,`fechaActualizacion`,`Usuario`,`EstadoActual`,`FuenteProspecto`,`IngresoMensual`,`RangodeEdad`,`Ocupacion`,`EdoCivil`,`TiempodeConocerProspec`,`FrecuenciaVio`,`PosibiAcercamiento`,`HabilidadRef`,`tipoEntidad`,`observacion`,`tipo_prospecto`,`leads`,`referido`)
					Values
					('clienteWeb','0','0','".$ApellidoP."', '".$ApellidoM."','".$Nombre."','".$Razon."','".$rfc."','".$EMail2."','".$Telefono1."','".$fecharegistro."','".$correoProcedente."','DIMENSION','".$FuenteProspecto."','".$IngresoMensual."','".$RangodeEdad."','".$Ocupacion."','".$EdoCivil."','".$TiempodeConocerProspec."','".$FrecuenciaVio."','".$PosibiAcercamiento."','".$HabilidadRef."','".$tipoEntidad."','".$observacion."','".$tipo_prospecto."','".$leads."','".$referido."');
										  ";
										  									  
			$this->db->query($sqlInsert_Referencia);
			$referencia = $this->db->insert_id();
				
			if($this->tank_auth->get_View()!= "App"){
				$this->proyecto100();
			} else {
				redirect('/crmproyecto/proyecto100');
			}

		}
	}

function determinarMes($m){
    $mes='';
    switch ($m){
        case 1:$mes='ENE';break;
        case 2:$mes='FEB';break;
        case 3:$mes='MAR';break;
        case 4:$mes='ABR';break;
        case 5:$mes='MAY';break;
        case 6:$mes='JUN';break;
        case 7:$mes='JUL';break;
        case 8:$mes='AGO';break;
        case 9:$mes='SEP';break;
        case 10:$mes='OCT';break;
        case 11:$mes='NOV';break;
        case 12:$mes='DIC';break;
    }
    return $mes;
}

//----------------
// Dennis Castillo [2021-10-31]
function InsertaDimension_agente(){ //Modificado [Suemy][2024-06-26]
        
	if (!$this->tank_auth->is_logged_in()) {
		redirect('/auth/login/');
	} else {
		
		 $ApellidoP = $this->Limpia($this->input->post('apellidop_agente'));+
		 $ApellidoM = $this->Limpia($this->input->post('apellidom_agente'));
		 $Nombre = $this->Limpia ($this->input->post('nombre_agente'));
		 //$prospecto=$Nombre.' '.$ApellidoP.' '.$apellidoM;
		 $cedula=$this->input->post('cedula_agente');

		 $emailPersonal = strtoupper ($this->input->post('email_agente'));
		 $celPersonal = $this->input->post('celular_agente');
		 $telCasaProspecto = $this->input->post("telefono-casa-agente");

		 $status =$this->input->post('status');
		 $asignado = $this->input->post('asignado');
		 //$ubicacion_agente = $this->input->post('ubicacion_agente');
         $referido = ($this->input->post('referido') != false) ? "Si" : "No";

		 //----------
			//Ubicación
			$calle = $this->input->post("calle");
			$cruce = $this->input->post("cruzamiento");
			$numero = $this->input->post("numero");
			$colonia = $this->input->post("colonia");
			$municipio = $this->input->post("municipio");
			$estado = $this->input->post("estado");
			$pais = $this->input->post("pais");
			$postal = $this->input->post("postal");

			$ubicacion_agente = $calle." ".$cruce." ".$numero." ".$colonia." ".$municipio." ".$estado." ".$pais." ".$postal;
		 //----------
		 $coordinacion="";
		 if($asignado=="COORDINADORCOMERCIAL@CAPCAPITAL.COM.MX"){
			  $coordinacion="CBE";
		 }else{
			 $coordinacion="MID";
		 }

		 $observacion=$this->input->post('observacion_agente');
		 $dia=date('d');
		 $mes=date('m');
		 $mes=$this->determinarMes($mes);
		 $anio=date('Y');
		
		 //$sqlInsert_Referencia="INSERT INTO prospectos_agentes(medio,tiene_cedula,prospecto, apellido_paterno, apellido_materno,correo,numero_telefono,ubicacion,dia,mes,anio,coordinacion,asignado,comentarios,status)values('SISTEMA','$cedula','$Nombre','$ApellidoP','$ApellidoM','$emailPersonal','$celPersonal','$ubicacion_agente','$dia','$mes','$anio','$coordinacion','$asignado','$observacion','$status')";
		 $sqlInsert_Referencia="INSERT INTO prospectos_agentes(medio,tiene_cedula,prospecto, apellido_paterno, apellido_materno,correo,numero_telefono,ubicacion,dia,mes,anio,coordinacion,asignado,comentarios,status, estadoRegistro, referido)values('SISTEMA','$cedula','$Nombre','$ApellidoP','$ApellidoM','$emailPersonal','$celPersonal','$ubicacion_agente','$dia','$mes','$anio','$coordinacion','$asignado','$observacion','NO CONTACTADO','activo','$referido')";
				  
			$this->db->query($sqlInsert_Referencia);
			$referencia = $this->db->insert_id();
			
			$insertAddress = $this->crmProyecto_Model->insertaRegistros(array(
				"calle" => $calle, 
				"cruzamiento" => $cruce, 
				"colonia" => $colonia, 
				"numero" => $numero, 
				"municipio" => $municipio, 
				"estado" => $estado, 
				"pais" => $pais, 
				"codigo_postal" => $postal, 
				"idProspecto" => $referencia
			 ), "direccion_prospecto_agente");

			 $insertProgress = $this->crmProyecto_Model->insertaRegistros(array(
				"idProspecto" => $referencia,
			 ), "prospective_to_user");

			 /*$insertInSecondTable = $this->crmProyecto_Model->insertaRegistros(array(
				"nombre" => strtolower($Nombre), 
				"apellidoPaterno" => strtolower($this->input->post("apellidop_agente")),
				"apellidoMaterno" => strtolower($this->input->post("apellidom_agente")), 
				"telefono" => $celPersonal, 
				"correo" => $emailPersonal, 
				"fechaAlta" => date("Y-m-d H:i:s"), 
				"referenciaProspecto" => $referencia,

			 ), "prospecto_agente_a_capital_humano");*/


			if($this->tank_auth->get_View()!= "App"){
				$this->proyecto100();
			} else {
				redirect('/crmproyecto/proyecto100');
			}

	}
	
}
//----------------

/*function InsertaDimension_agente(){
        
        if (!$this->tank_auth->is_logged_in()) {
            redirect('/auth/login/');
        } else {
            
             $Apellido = $this->Limpia($this->input->post('apellido_agente'));
             $Nombre = $this->Limpia ($this->input->post('nombre_agente'));
             $prospecto=$Nombre.' '.$Apellido;
             $cedula=$this->input->post('cedula_agente');

             $emailPersonal = strtoupper ($this->input->post('email_agente'));
             $celPersonal = $this->input->post('celular_agente');

             $status =$this->input->post('status');
             $asignado = $this->input->post('asignado');
             $ubicacion_agente = $this->input->post('ubicacion_agente');

             $coordinacion="";
             if($asignado=="COORDINADORCOMERCIAL@CAPCAPITAL.COM.MX"){
                  $coordinacion="CBE";
             }else{
                 $coordinacion="MID";
             }

             $observacion=$this->input->post('observacion_agente');
             $dia=date('d');
             $mes=date('m');
             $mes=$this->determinarMes($mes);
             $anio=date('Y');
            
             $sqlInsert_Referencia="INSERT INTO prospectos_agentes(medio,tiene_cedula,prospecto,correo,numero_telefono,ubicacion,dia,mes,anio,coordinacion,asignado,comentarios,status)values('SISTEMA','$cedula','$prospecto','$emailPersonal','$celPersonal','$ubicacion_agente','$dia','$mes','$anio','$coordinacion','$asignado','$observacion','$status')";

                      
                $this->db->query($sqlInsert_Referencia);
                $referencia = $this->db->insert_id();
                
                if($this->tank_auth->get_View()!= "App"){
                    $this->proyecto100();
                } else {
                    redirect('/crmproyecto/proyecto100');
                }

        }
        
}*/


//-------------------------------------------------------------------------------------------------------------------------------
	function InsertaDimensiondeSikas(){
		
		if (!$this->tank_auth->is_logged_in()) {
			redirect('/auth/login/');
		} else {
			
			$fecharegistro=(string)date('Y-m-d H:i:s');
			$correoProcedente=$this->tank_auth->get_usermail();
            //traigo los valores de sikas  
			$idclienteSikas=strtoupper ($this->input->post('cliselecsikas'));
			$DatosCli=$this->webservice_sicas_soap->GetClient_forID($idclienteSikas); 
			foreach ($DatosCli['cliente'] as $key) {
				 $ApellidoP = $key->ApellidoP;
                 $ApellidoM = $key->ApellidoM;
                 $Nombre = $key->Nombre;
                 $IdContacto = $key->IDCont;
			}
           // $ApellidoP = strtoupper ($this->input->post('apellidop'));
           // $ApellidoM = strtoupper ($this->input->post('apellidom'));
           // $Nombre = strtoupper ($this->input->post('nombre'));
             $FuenteProspecto = $this->input->post('fuente');
             $IngresoMensual =  $this->input->post('IngMen');
             $RangodeEdad =  $this->input->post('RangoEdad');
             $Ocupacion =  $this->input->post('ocupacion');
             $EdoCivil =  $this->input->post('estadocivil');
             $TiempodeConocerProspec =  $this->input->post('tiempoconocer');
             $FrecuenciaVio =  $this->input->post('frecuenciavio');
             $PosibiAcercamiento =  $this->input->post('posacercamiento');
             $HabilidadRef =  $this->input->post('habilidadref');            
			 $sqlInsert_Referencia = "
						Insert Ignore Into `clientes_actualiza` (`actualiza`, `IDCont`, `TipoEnt`,`ApellidoP`,`ApellidoM`,`Nombre`,`RazonSocial`,`RFC`,`EMail1`,`fechaActualizacion`,`Usuario`,`EstadoActual`,`FuenteProspecto`,
										`IngresoMensual`,
										`RangodeEdad`,
										`Ocupacion`,
										`EdoCivil`,
										`TiempodeConocerProspec`,
										`FrecuenciaVio`,
										`PosibiAcercamiento`,
										`HabilidadRef`,
										`IDCliSikas`,
										`IDContacto`
									) 
									Values
									(
									    'clienteSikas',
									    '0',
									    '0',
										'".$ApellidoP."', 
										'".$ApellidoM."',
										'".$Nombre."',
										'',
										'',
										'',
                                        '".$fecharegistro."',
										'".$correoProcedente."',
										'DIMENSION',

										'".$FuenteProspecto."',
										'".$IngresoMensual."',
										'".$RangodeEdad."',
										'".$Ocupacion."',
										'".$EdoCivil."',
										'".$TiempodeConocerProspec."',
										'".$FrecuenciaVio."',
										'".$PosibiAcercamiento."',
										'".$HabilidadRef."',
										'".$idclienteSikas."',
										'".$IdContacto."'

									);
											";

											
                         
				$this->db->query($sqlInsert_Referencia);
				$referencia = $this->db->insert_id();
                        
			//redirect('/crmproyecto/proyecto100');
			//$this->proyecto100();
				redirect('/crmproyecto');
		}
	}

//-------------------------------------------------------------------------------------------------------------------------------
function suspenderCliente(){
	$respuesta="";
	$fecha=explode('/',$_GET['fechaPospuesto']);	
    $actualizar['fechaMensajePausa']=$fecha[2].'-'.$fecha[1].'-'.$fecha[0];
    $actualizar['IDCli']=$_GET['IDCli'];
    $actualizar['update']='';
    $actualizar['EstadoActual']='PAUSA';
    $this->crmProyecto_Model->clientes_actualiza($actualizar);
    $respuesta['mensaje']="Los cambios se realizaron con exito";
	echo json_encode($respuesta);
}
//-------------------------------------------------------------------------------------------------
function activarEnPausa(){
	$respuesta="";
	$update['IDCli']=$_GET['IDCli'];
	$datos=$this->crmProyecto_Model->clientes_actualiza($update);
    $mensaje="";
    if((count($datos))>0){

    	if($datos[0]->Usuario==$this->tank_auth->get_usermail())
    	{
    		$ultimoEstado=$this->crmProyecto_Model->ultimoEdoActualPuntaje($_GET['IDCli']);
    		$actualiza['EstadoActual']=$ultimoEstado[0]->EdoActual;
    		$actualiza['IDCli']=$_GET['IDCli'];
    		$actualiza['update']='';
    		$this->crmProyecto_Model->clientes_actualiza($actualiza);
  
    		$mensaje="Los cambios se llevaron a cabo correctamente";
    	}
    	else
    	{
    		$mensaje="Esta accion no es posible";
    	}
    }
	
	/*$fecha=explode('/',$_GET['fechaPospuesto']);
	
    $actualizar['fechaMensajePausa']=$fecha[2].'-'.$fecha[1].'-'.$fecha[0];
    $actualizar['IDCli']=$_GET['IDCli'];
    $actualizar['update']='';
    $actualizar['EstadoActual']='PAUSA';

    $this->crmProyecto_Model->clientes_actualiza($actualizar);*/
   $respuesta['mensaje']=$mensaje;
	      echo json_encode($respuesta);
}
//-------------------------------------------------------------------------------------------------
function InsertaPerfilado(){		
		if (!$this->tank_auth->is_logged_in()) {redirect('/auth/login/');} 
		else {           
		//Cambios Edwin Marin         
			$puntos=$this->PersonaModelo->obtenerPuntosProspeccionIndividual("PERFILAR");
			$mensaje="";			
			$fecharegistro=(string)date('Y-m-d H:i:s');
			$correoProcedente=$this->tank_auth->get_usermail();
            $IDCli2 = $this->input->get('IDCL', TRUE);
            $actualiza['IDCli']=$_GET['IDCL'];
            $actualiza['FuenteProspecto']=$_GET['fuente'];
            $actualiza['IngresoMensual']=$_GET['IngMen'];
            $actualiza['RangodeEdad']=$_GET['RangoEdad'];
            $actualiza['Ocupacion']=$_GET['ocupacion'];
            $actualiza['EdoCivil']=$_GET['estadocivil'];
            $actualiza['TiempodeConocerProspec']=$_GET['tiempoconocer'];
            $actualiza['FrecuenciaVio']=$_GET['frecuenciavio'];
            $actualiza['PosibiAcercamiento']=$_GET['posacercamiento'];
            $actualiza['HabilidadRef']=$_GET['habilidadref'];

            //Modificacion MJ 07-02-2023
            $actualiza['bant_aut']=$_GET['bant_aut'];
            $actualiza['bant_need']=$_GET['bant_need'];
            $actualiza['bant_timing']=$_GET['bant_timing'];
            
            $actualiza['update']='';
            $this->crmProyecto_Model->clientes_actualiza($actualiza);
            if($IDCli2>0)
            {	
            	try{
					$sqlInsert_Referencia = "Update `clientes_actualiza` set `EstadoActual` = 'PERFILADO' where `IDCli`='".$IDCli2."'";
                 $this->db->query($sqlInsert_Referencia);
				$referencia = $this->db->insert_id();
					$sqlInsert_grabapuntos = "Insert Ignore Into `puntaje` (`Usuario`, `IDCliente`,`FechaRegistro`,`EdoAnterior`,`EdoActual`,`PuntosGenerados`) Values('".$correoProcedente."','".$IDCli2."','".$fecharegistro."', 'DIMENSION','PERFILADO','".$puntos."');";											                         
					$this->db->query($sqlInsert_grabapuntos);
					$referencia = $this->db->insert_id();
				 }
                 catch (Exception $e){    
             	         echo $e->getMessage();
             	         $this->data['pestania']='seguimientoProspecto';
             	         $this->proyecto100();
             	        // redirect('/crmproyecto');
        	     }	
            //$this->data['pestania']='seguimientoProspecto';
            //$this->proyecto100();
			//redirect('/crmproyecto');
		  $respuesta['respuesta']="Cambios con exitos";
		  //$respuesta['otra']="Cambios con exitos";
          echo json_encode($respuesta);

			}

		}
	}

//-------------------------------------------------------------------------------------------------------------------------------
function deteccion_necesidades()
{
    $IDCli=$this->input->get('IDCL', TRUE);
 
    $data['cliente']= $IDCli;
    $sql="SELECT * FROM clientes_actualiza where IDCLi='$IDCli'";
    $data['datos']=$this->db->query($sql)->result();
    $data['datosDN']=$this->db->query('select * from deteccion_necesidades where id='.$IDCli)->result();
    $this->load->view("crmproyecto/deteccion_necesidades",$data);
}

//-------------------------------------------------------------------------------------------------------------------------------
   function LlamaCotizacion(){		
		if (!$this->tank_auth->is_logged_in()) {
			redirect('/auth/login/');
		} 
		else {
			
			   $Cliente= $this->input->get('IDCL', TRUE);
				 if($Cliente>0)
                 {
			   		$sqlConsultaDatos = "Select * From `clientes_actualiza` Where `IDCli`='".$Cliente."'";
			   		$queryConsultaDatos	= $this->db->query($sqlConsultaDatos); 
			   		 	if(!empty($queryConsultaDatos))
                        { 
                             foreach ($queryConsultaDatos->result() as $Registro) { 
                              $apaterno= str_replace(" ", "", $Registro->ApellidoP);
                              $amaterno=str_replace(" ", "", $Registro->ApellidoM);
                              $nombres=str_replace(" ", "_", $Registro->Nombre);
                              $Telefono1=str_replace(" ", "", $Registro->Telefono1);
                              $email=str_replace(" ", "", $Registro->EMail1);
                              $RazonSocial=str_replace(" ", "", $Registro->RazonSocial);
                              $IDCliSikasn=$Registro->IDCliSikas;
                              $IDContacton=$Registro->IDContacto;
                            }
                             $resultado1 = str_replace("@", "-", $email);
						}
                 }
      if($IDCliSikasn>0){$cadenafina="/actividades/agregar/Cotizacion/VEHICULOS/17/Existente?idCliente=".$IDCliSikasn."-".$IDContacton."&clientep=".$Cliente."";} 
      else{   
           if($RazonSocial!=""){
            	if($Telefono1==""){$Telefono1="NA";}
            	if($resultado1==""){$resultado1="N-A.COM";}
            	if($RazonSocial==""){$RazonSocial="NA";}
            	$cadenafina="/actividades/agregar/Cotizacion/VEHICULOS/17/Nuevo/Moral/".$Cliente."/SAP/SAM/SN/".$Telefono1."/".$resultado1."/".$RazonSocial."/";
            	
            } else{ 
                if($apaterno==""){$apaterno="NA";}
              	if($amaterno==""){$amaterno="NA";}          	
             	if($Telefono1==""){$Telefono1="NA";}
            	if($resultado1==""){$resultado1="N-A.COM";}
            	if($RazonSocial==""){$RazonSocial="NA";}
            	if($nombres==""){$nombres="NA";}
             	$cadenafina="/actividades/agregar/Cotizacion/VEHICULOS/17/Nuevo/Fisica/".$Cliente."/".$apaterno."/".$amaterno."/".$nombres."/".$Telefono1."/".$resultado1."/SR/";}	  
          }	

		redirect($cadenafina);
		 }
	}
//-------------------------------------------------------------------------------------------------------------------------------
	function devuelveFecha($fecha){
       	 $fec= explode("/",$fecha);
         list($anio,$mes,$dia)=$fec;     
         $fechaCon1=$anio."-".$mes."-".$dia;
	     $fechaNac= date("y-m-d", strtotime($fechaCon1));

     return($fechaNac);
    }

//-------------------------------------------------------------------------------------------------------------------------------
	function InsertaContactado($IDCLi){
		//Cambios Edwin Marin
		$puntos=$this->PersonaModelo->obtenerPuntosProspeccionIndividual("CONTACTO");
		if (!$this->tank_auth->is_logged_in()) {
			redirect('/auth/login/');
		} else {
			
			$fecharegistro=(string)date('Y-m-d H:i:s');
			$correoProcedente=$this->tank_auth->get_usermail();
			$FechaContacto=$this->input->post('fechaStart');

            $IDCli2 = $this->input->get('IDCL', TRUE);

            if($IDCli2>0)
            {	

            	try{

						$sqlInsert_Referencia = "Update `clientes_actualiza` set `EstadoActual` = 'CONTACTADO' where `IDCli`='".$IDCli2."'";

                         
						$this->db->query($sqlInsert_Referencia);
						$referencia = $this->db->insert_id();

						$sqlInsert_grabapuntos = "Insert Ignore Into `puntaje` (`Usuario`, `IDCliente`,`FechaRegistro`,`EdoAnterior`,`EdoActual`,`PuntosGenerados`,`FechaContacto` ) 
									Values('".$correoProcedente."','".$IDCli2."','".$fecharegistro."', 'PERFILADO','CONTACTADO','".$puntos."','".$FechaContacto."');";
											                         
						$this->db->query($sqlInsert_grabapuntos);
						$referencia = $this->db->insert_id();
            
			    }
                catch (Exception $e){    
             	         echo $e->getMessage();
             	         redirect('/crmproyecto');
        	     }	
            
				redirect('/crmproyecto');

			}

		}
	}
//-------------------------------------------------------------------------------------------------------------------------------
	function InsertaCitaRegistrada(){
		//Cambios Edwin Marin
		$puntos=$this->PersonaModelo->obtenerPuntosProspeccionIndividual("REGISTRAR");
		if (!$this->tank_auth->is_logged_in()) {
			redirect('/auth/login/');
		} else {
			
			$fecharegistro=(string)date('Y-m-d H:i:s');
			$correoProcedente=$this->tank_auth->get_usermail();
			$FechaCita= $this->input->post('fechaStartCita');

            $IDCli3 = $this->input->get('IDCL', TRUE);

            if($IDCli3>0)
            {	

            	try{

						$sqlInsert_Referencia = "Update `clientes_actualiza` set `EstadoActual` = 'REGISTRADO' where `IDCli`='".$IDCli3."'";
						$this->db->query($sqlInsert_Referencia);
						$referencia = $this->db->insert_id();
						$sqlInsert_grabapuntos = "
						Insert Ignore Into`puntaje` (`Usuario`, `IDCliente`,`FechaRegistro`,`EdoAnterior`,`EdoActual`,`PuntosGenerados`,`FechaCita`) Values
									('".$correoProcedente."','".$IDCli3."','".$fecharegistro."', 'CONTACTADO','REGISTRADO','".$puntos."','".$FechaCita."');";

											
                         
					$this->db->query($sqlInsert_grabapuntos);
					$referencia = $this->db->insert_id();
                    $this->idCliente=$IDCli3;
					$this->citaRegistrada=1;
            
			     }
                catch (Exception $e){    
             	         echo $e->getMessage();
             	         redirect('/crmproyecto');
        	     }	
                $this->index();
				//redirect('/crmproyecto');

			}

		}
	}
//--------------------------------------------------------------------------------------------------
function eliminaCita(){
$resp=$this->fullcalendar_model->eliminaCita($_POST['id']);
echo($resp);

}
//--------------------------------------------------------------------------------------------------
	function actualizaCita(){
		$resp=$this->fullcalendar_model->actualizaCita($_POST['id'],$_POST['fi'],$_POST['ff']);
		echo $resp;
	}
//--------------------------------------------------------------------------------------------------
	function guardaCita()
	{

		/*$cadena=explode('&',$_POST['datosCita']);
		$fecha=explode('/',str_replace('fecha=','',$cadena[2]));
		$fechaIni=$fecha[2]."-".$fecha[1]."-".$fecha[0]; $fechaIni=$fechaIni."
		".(str_replace('horaI=',"",$cadena[0]));
		$fechaFin=$fecha[2]."-".$fecha[1]."-".$fecha[0]; $fechaFin=$fechaFin."
		".(str_replace('horaF=',"",$cadena[1])); $insert="insert into
		citascalendar(emailUsuario,titulo,fechaInicial,fechaFinal) values";
		$insert=$insert.'("prueba","prueba","'.$fechaIni.'","'.$fechaFin.'")';*/
		//$this->db->query($insert);

		//Version 1
		$fecha=explode('/',$_POST['fecCita']); 
		$fechaFormato=$fecha[2].'-'.$fecha[1].'-'.$fecha[0];
		$insert['titulo']=$_POST['tituloCita'];
		$insert['fechaInicial']=$fechaFormato.' '.$_POST['fecIniCita'].':00';
		$insert['fechaFinal']=$fechaFormato.' '.$_POST['fecFinCita'].':00';
		$insert['tabla']='citascalendar';
		$insert['idTabla']=null;
		//$this->fullcalendar_model->guardaCitaModulo($_POST['tituloCita'],$fechaFormato,$_POST['fecIniCita'],$_POST['fecFinCita'],"clientes_actualiza",$_POST['idClienteCita']);
		$this->fullcalendar_model->guardaCitaModulo($insert);
		$this->citaRegistrada=1;
		//$this->index();
		$this->proyecto100();
		echo json_encode($data);
	}
//--------------------------------------------------------------------------------------------------
function verificarPago(){
	$idSicas ='119292';//'119292';
	$ot='ot';
	$mensaje="";
	$consultaProspecto['IDCli']=$_GET['IDCli'];
	$datosProspecto=$this->crmProyecto_Model->clientes_actualiza($consultaProspecto);
   $pagado=0;
if($datosProspecto[0]->Usuario==$this->tank_auth->get_usermail()){
$datos=$this->capsysdre_actividades->buscarActividadPorFolio($_GET['folioActividad']);
	$idSicas=$datos[0]->idSicas;
//$idSicas=$datos[0]->idSicas;			
 $respuesta=$this->ws_sicas->buscarDocumentoPorIDSicas($idSicas);
 $documento=(String)$respuesta->TableInfo->Documento;
 //$ot = strstr($documento, 'OT');
  $documentoRespuesta="";
if (strlen(stristr($documento,'OT'))==''){
	$documentoRespuesta=$documento;
	$update['IDCli']=$_GET['IDCli'];
	$update['update']="";
	$update['Documento']=$documento;
	$recibos=$this->ws_sicas->obtenerRecibosPorDocumento($documento);
 
  if((integer)$recibos->TableControl->MaxRecords>0){
      $status=(String)$recibos->TableInfo->Status;
     if($status==3 || $status==4)
     	//Cambios Edwin Marin
     {  $puntos=$this->PersonaModelo->obtenerPuntosProspeccionIndividual("PAGAR");
     	$update['pagado']=1;
        $update['EstadoActual']='PAGADO';
        $pagado=1;
     	$mensaje="Ya se realizo el primer pago de la Poliza, puntos generados con exito";
     	$insertPuntaje['Usuario']=$this->tank_auth->get_usermail();;
     	$insertPuntaje['IDCliente']=$_GET['IDCli'];
     	$insertPuntaje['FechaRegistro']=(string)date('Y-m-d H:i:s');;
     	$insertPuntaje['EdoAnterior']='COTIZADO';
     	$insertPuntaje['EdoActual']='PAGADO';
     	$insertPuntaje['PuntosGenerados']=$puntos;
     	$insertPuntaje['IDPuntaje']=-1;
     	$this->crmProyecto_Model->puntaje($insertPuntaje);
     }
     else
     {
     	$mensaje="Poliza ya esta generada pero no se han detectado pagos en ella";
     }
  }
  else{
  	$mensaje="La poliza ya fue generada pero no se han detectado recibos";
  }
  $this->crmProyecto_Model->clientes_actualiza($update);
}
else{
	$mensaje="No se ha generado poliza de esta actividad";
}
}
else{
	$mensaje="No se puede llevar a cabo esta accion";
}
$respuestaPeticion['mensaje']=$mensaje;
$respuestaPeticion['folioActividad']=$_GET['folioActividad'];
$respuestaPeticion['IDCli']=$_GET['IDCli'];
$respuestaPeticion['Documento']=$documentoRespuesta;
$respuestaPeticion['pagado']=$pagado;

  echo json_encode($respuestaPeticion);

}
//--------------------------------------------------------------------------------------------------
function muestraRecibos(){
$vendedor=$this->tank_auth->get_IDVend();
$xml=$this->ws_sicas->obtenerRecibosPorDocumento($_GET['Documento']);

                  $bandera="";
                 foreach($xml->TableInfo as $table)
                 {
                  $bandera=$table->Status_TXT;
                 }
                 $contador=0;
                 $contador=$xml->TableControl->MaxRecords;
                 if($contador>1){                             
                        $this->load->view('reportes/produccion',$xml);                 
                 }
                 else
                 { 
                     $x['TableInfo']= $xml->TableInfo; 
                   $x['TableControl'] =$xml->TableControl;
                   $this->load->view('reportes/produccion',$x);
                 } 

}
//--------------------------------------------------------------------------------------------------

	function VerificarPago2(){
		//Cambios Edwin Marin
				$puntos=$this->PersonaModelo->obtenerPuntosProspeccionIndividual("PAGAR");
		if (!$this->tank_auth->is_logged_in()) {
			redirect('/auth/login/');
		} else {

			$IdSikas = $this->input->get('IDSIK', TRUE);
			$IDCli3 = $this->input->get('IDCL', TRUE);
			$fecharegistro=(string)date('Y-m-d H:i:s');
			$correoProcedente=$this->tank_auth->get_usermail();
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
        	$datos['KeyCode']='H03430_003';
        	$datos['Page']='1';
        	$datos['ItemForPage']='10';
        	$datos['InfoSort']='VDatDocumentos.IDDocto';
        	$datos['IDRelation']='0';
        	$datos['ConditionsAdd']='IDDocto;0;0;'.$IdSikas.';'.$IdSikas.';DatDocumentos.IDDocto';
             $xml=$this->webservice_sicas_soap->datos($datos); 
            
             $tapoliza="";
             foreach($xml->TableInfo as $table)
	             {$tapoliza=$table->Status_TXT;}
             if($tapoliza=='Liquidado'){

             	//genera los puntos y cmabia el status

             	$sqlInsert_Referencia = "Update `clientes_actualiza` set `EstadoActual` = 'PAGADO' where `IDCli`='".$IDCli3."'";

                         
			$this->db->query($sqlInsert_Referencia);
			$referencia = $this->db->insert_id();

			$sqlInsert_grabapuntos = "Insert Ignore Into `puntaje` (`Usuario`, `IDCliente`,`FechaRegistro`,`EdoAnterior`,`EdoActual`,`PuntosGenerados`) Values('".$correoProcedente."','".$IDCli3."','".$fecharegistro."', 'COTIZADO','PAGADO','".$puntos."');";
				$this->db->query($sqlInsert_grabapuntos);
				$referencia = $this->db->insert_id();
             }
             
           // redirect('/crmproyecto/');
            	$this->data['pestania']='seguimientoProspecto';
 	$this->proyecto100();

		}
	}

//--------------------------------------------------------------------------------------------------
	function ExportaClientes(){	

	//$mysqli = new mysqli('localhost','root','','capsysv3');

	$mysqli = new mysqli('www.capsys.com.mx','root','VikinGo@52x','capsysV3');
    $correoProcedente=$this->tank_auth->get_usermail();
	$fecha = date("d-m-Y");

   	$consulta= "select * from clientes_actualiza ca where usuario='".$correoProcedente."' order by ca.ApellidoP

   	";

   	$resultado= $mysqli->query($consulta);

  

	//Inicio de la instancia para la exportación en Excel
	header('Content-type: application/vnd.ms-excel');
	header("Content-Disposition: attachment; filename=Listado_$fecha.xls");
	header("Pragma: no-cache");
	header("Expires: 0");

	echo "<table border=1> ";
	echo "<tr> ";
	echo    "<th>Id_Cliente</th> ";
	echo 	"<th>TipoCliente</th> ";
	echo    "<th>ApellidoP</th> ";
	echo    "<th>ApellidoM</th> ";
	echo 	"<th>Nombres</th> ";
	echo 	"<th>Razon_Social</th> ";
	echo 	"<th>RFC</th> ";
	echo 	"<th>Email</th> ";
	echo 	"<th>Telefono</th> ";
	echo 	"<th>EstadoActual</th> ";

	echo 	"<th>FuenteProspecto</th> ";
	echo 	"<th>IngresoMensual</th> ";
	echo 	"<th>RangodeEdad</th> ";
	echo 	"<th>Ocupacion</th> ";
	echo 	"<th>EdoCivil</th> ";
	echo 	"<th>TiempodeConocerProspecto</th> ";

	echo 	"<th>FrecuenciaVio</th> ";
	echo 	"<th>HabilidadparaReferenciar</th> ";
	echo 	"<th>TiempodeConocerProspecto</th> ";


	echo "</tr> ";

	while($row = mysqli_fetch_array($resultado)){	

	$IDCli = $row['IDCli'];
	$actualiza = $row['actualiza'];
	$ApellidoP = $row['ApellidoP'];
	$ApellidoM = $row['ApellidoM'];
	$Nombre = $row['Nombre'];
	$RazonSocial = $row['RazonSocial'];
    $RFC = $row['RFC'];
	$EMail1 = $row['EMail1'];
	$Telefono1 = $row['Telefono1'];
	$EstadoActual = $row['EstadoActual'];

    $FuenteProspecto = $row['FuenteProspecto'];
	$IngresoMensual = $row['IngresoMensual'];
	$RangodeEdad = $row['RangodeEdad'];
    $Ocupacion = $row['Ocupacion'];
	$EdoCivil = $row['EdoCivil'];
	$TiempodeConocerProspec = $row['TiempodeConocerProspec'];
	$FrecuenciaVio = $row['FrecuenciaVio'];
	$PosibiAcercamiento = $row['PosibiAcercamiento'];
	$HabilidadRef = $row['HabilidadRef'];

	
	
	

	echo    "<tr> ";
	echo 	"<td HEIGHT=20>".$IDCli."</td> "; 
	echo 	"<td HEIGHT=20>".$actualiza."</td> ";
	echo 	"<td HEIGHT=20>".$ApellidoP."</td> "; 
	echo 	"<td HEIGHT=20>".$ApellidoM."</td> "; 
	echo 	"<td HEIGHT=20>".$Nombre."</td> "; 
	echo 	"<td HEIGHT=20>".$RazonSocial."</td> "; 
	echo 	"<td HEIGHT=20>".$RFC."</td> "; 
	echo 	"<td HEIGHT=20>".$EMail1."</td> "; 
	echo 	"<td HEIGHT=20>".$Telefono1."</td> "; 
	echo 	"<td HEIGHT=20>".$EstadoActual."</td> "; 

	echo 	"<td HEIGHT=20>".$FuenteProspecto."</td> "; 
	echo 	"<td HEIGHT=20>".$IngresoMensual."</td> "; 
	echo 	"<td HEIGHT=20>".$RangodeEdad."</td> "; 
	echo 	"<td HEIGHT=20>".$Ocupacion."</td> "; 
	echo 	"<td HEIGHT=20>".$EdoCivil."</td> "; 
	echo 	"<td HEIGHT=20>".$TiempodeConocerProspec."</td> "; 
	echo 	"<td HEIGHT=20>".$FrecuenciaVio."</td> "; 
	echo 	"<td HEIGHT=20>".$PosibiAcercamiento."</td> "; 
	echo 	"<td HEIGHT=20>".$HabilidadRef."</td> "; 

	

	echo    "</tr> ";

	}
	echo "</table> ";

 	}
 //---------------------------------------------------------------------------------------------------------------------------------------------------------

 
function devuelveDocumentos(){	 
	 $this->load->model('manejodocumento_modelo');
 	echo json_encode($this->manejodocumento_modelo->devolverDocumentos('archivosCRM/'.$_GET['idProspecto'].'/',0));

}
 //------------------------------------------------------------------------------------------------------------------------------------------------------------
 function comentarios(){
 	

 	if(isset($_GET['nuevoComentario'])){$this->capsysdre_actividades->insertaComentario();}
 	if(isset($_GET['eliminaComentario'])){$array=explode("-",$_GET['idProspecto']);$_GET['idProspecto']=$array[0];$_GET['idComentario']=$array[1];$this->capsysdre_actividades->eliminaComentario();}
 	if(isset($_GET['modificaComentario'])){$array=explode("-",$_GET['idProspecto']);$_GET['idProspecto']=$array[0];$_GET['idComentario']=$array[1];$this->capsysdre_actividades->modificaComentario();}
 	if($_GET['tipoCCC']==0){$respuesta=$this->capsysdre_actividades->buscaComentarios();}else{$respuesta=$this->capsysdre_actividades->devuelveVentana();}
 	echo json_encode($respuesta);
 }

 function documentos(){
 	$respuesta=$this->capsysdre_actividades->mostrarDocumentos();
 	echo json_encode($respuesta);
 }

 //-------------------------------------------------------------------------------------------------------------------------------------------------------------
 function ventanaCitaContacto()
 {

  $respuesta=$this->capsysdre_actividades->devuelveVentana();
  echo json_encode($respuesta);
 }
 //-------------------------------------------------------------------------------------------------------------------------------------------------------------
 function guardarContactoCita()
 {

if($_GET['citaContacto']!=""){
//$this->fullcalendar_model->guardaCitaModulo($_POST['tituloCita'],$fechaFormato,$_POST['fecIniCita'],$_POST['fecFinCita'],"clientes_actualiza",$_POST['idClienteCita']);

 $respuesta=$this->capsysdre_actividades->guardarContactoCita();
   	$fecha=explode('/',$_GET['citaContacto']); 
    $fechaFormato=$fecha[2].'-'.$fecha[1].'-'.$fecha[0];
    $insert['titulo']="";
	 $insert['fechaInicial']=$fechaFormato.' '.$_GET['selectFechaDeCC'].':00';
	 $insert['fechaFinal']=$fechaFormato.' '.$_GET['selectFechaACC'].':00';
	 $insert['tabla']='comentarioscitacontacto';
	 $insert['idTabla']=$respuesta;  

    $this->fullcalendar_model->guardaCitaModulo($insert);
  }
   $respuesta=$this->capsysdre_actividades->devuelveVentana();
   echo json_encode($respuesta);

 }
 //-------------------------------------------------------------------------------------------------------------------------------------------------------------
	function reporteComercial()
	{
		$this->data['year'] = "";
		$this->data['month'] = "";
		$usermail	= $this->tank_auth->get_usermail();
	//$this->data['coordinadores']=$this->PersonaModelo->devuelveCoordinadoresVentas();
    			$anioInicial['anio']=2022;
    			$this->data['esCoordinador']=0;
            $this->data['coordinadores']=$this->catalogos_model->canalesCatalogos($anioInicial); 
             $this->data['catalogTipoPersona']=array();
        $arrayContenedorCoordinador=array();
        foreach ($this->data['coordinadores'] as $key => $value) 
        {
        	if($value->email==$usermail)
        	{
              $this->data['esCoordinador']=1;
              array_push($arrayContenedorCoordinador, $value);
        	}
        }
        if( $this->data['esCoordinador']==1){$this->data['coordinadores']=$arrayContenedorCoordinador;}
      //$fp = fopen('resultadoJason.txt', 'a');fwrite($fp, print_r($this->data,TRUE));fclose($fp);	


		if($this->tank_auth->get_View()!= "App"){$this->load->view('crmproyecto/reporteComercial',$this->data);} 
		else {$this->load->view('crmproyecto/reporteComercialApp',$this->data);}
	}
 //-------------------------------------------------------------------------------------------------------------------------------------------------------------
	function verReporteComercial(){
		if(!$this->tank_auth->is_logged_in()){redirect('/auth/login/');} 
		else {	 
			$this->data['emailCoordinador']	= $this->input->post('emailCoordinador');
			$this->data['year']				= $this->input->post('year');
			$this->data['month']				= $this->input->post('month');
			$this->data['filtroFechas']		= $this->input->post('filtroFechasChec');
			$this->data['fechaStart']			= $this->input->post('fechaStart');
			$this->data['fechaEnd']			= $this->input->post('fechaEnd');
			//$this->data['coordinadores']=$this->PersonaModelo->devuelveCoordinadoresVentas();
    			$anioInicial['anio']=2022;
            $this->data['coordinadores']=$this->catalogos_model->canalesCatalogos($anioInicial); 
            $this->data['catalogTipoPersona']=$this->db->query('SELECT * FROM personatipoagente')->result_array();
            $arr['idPersonaTipoAgente']=0;
            $arr['personaTipoAgente']='SIN CLASIFICAR';
            array_push($this->data['catalogTipoPersona'], $arr);
 			
            $this->data['esCoordinador']=0;
        $arrayContenedorCoordinador=array();
        $usermail	= $this->tank_auth->get_usermail();
        foreach ($this->data['coordinadores'] as $key => $value) 
        {
        	if($value->email==$usermail)
        	{
              $this->data['esCoordinador']=1;
              array_push($arrayContenedorCoordinador, $value);
        	}
        }
        if( $this->data['esCoordinador']==1){$this->data['coordinadores']=$arrayContenedorCoordinador;}

				$this->load->view('crmproyecto/reporteComercial',$this->data);
		
		}
	}
 //-------------------------------------------------------------------------------------------------------------------------------------------------------------
 function devolverAgentes(){
$datos=$this->PersonaModelo->obtenerVendActivos();
$respuesta="";
foreach ($datos as $key => $value) {
$respuesta[$key]['idPersona']=$value->idPersona;
$respuesta[$key]['nombre']=$value->nombre;	
}
 echo json_encode($respuesta);
 }
//-------------------------------------------------------------------------------------------------------------------------------------------------------------
 function devolverOperativos(){

 $datos=$this->PersonaModelo->obtenerEmpleadosActivos();

$respuesta="";
foreach ($datos as $key => $value) {
$respuesta[$key]['idPersona']=$value->idPersona;
$respuesta[$key]['nombre']=$value->apellidoPaterno.' '.$value->apellidoMaterno.' '.$value->nombres;	
}

 echo json_encode($respuesta);	
 }
//-------------------------------------------------------------------------------------------------------------------------------------------------------------
 function transfiereProspectos()
 {
    $respuesta='La transferencia fue un exito';
 	$idClientes=explode('-',$_GET['idCliente']);
 	$fecha=(string)date('Y-m-d'); 		
      $correoAsignar=$this->PersonaModelo->obtenerDatosUsers($_GET['idPersona'])->email;   	
      $cadena="<h1>Transferencia de los siguientes propectos:</h1>";	
 	  foreach ($idClientes as  $value) 
 	  { 
 	   if($value!='')
 	   {   

         $select['IDCli']=$value;         
        $cliente_actualiza=$this->crmProyecto_Model->clientes_actualiza($select);

 		 $correo=$cliente_actualiza[0]->Usuario;
 		 $update['Usuario']=$correoAsignar;
 		 $update['UsuarioAnterior']=$correo;
 		 $update['IDCli']=$value;
 		 $update['update']='';
 		 $update['fechaTraspaso']=$fecha;
 		 $cadena.='<div>Nombre:'.$cliente_actualiza[0]->ApellidoP.' '.$cliente_actualiza[0]->ApellidoM.' '.$cliente_actualiza[0]->Nombre.'(Razon Social:'.$cliente_actualiza[0]->RazonSocial.')';
           $comentarioProspeccion='El siguiente prospecto se te acaba de reasignar:'.$cliente_actualiza[0]->ApellidoP.' '.$cliente_actualiza[0]->ApellidoM.' '.$cliente_actualiza[0]->Nombre.'(Razon Social:'.$cliente_actualiza[0]->RazonSocial.')';
	    
	    $notificacion['tabla']='clientes_actualiza';          
        $notificacion['idTabla']=$value;
        $notificacion['persona_id']=$_GET['idPersona'];
        $notificacion['email']=  $correoAsignar;
        $notificacion['tipo_id']='email';
        $notificacion['referencia']='COMENTARIO_PROSPECCION';
        $notificacion['referencia_id']='1001';
        $notificacion['check']=0;
        $notificacion['comentarioAdicional']=$comentarioProspeccion;
        $notificacion['id']=-1;
        $notificacion['tipo']='OTRO';
        //$notificacion['controlador']='actividades/eliminaComentarioAcitividad?folioActividad='.$folioActividad;        
        $ultimoId=$this->notificacionmodel->notificacion($notificacion);
        //$actualizar['id']=$ultimoId;
        //$actualizar['controlador']='actividades/eliminaComentarioAcitividad?folioActividad='.$folioActividad.'&id='.$ultimoId;
        //$this->notificacionmodel->actualizarNotificacion($actualizar);
        


 		 $this->crmProyecto_Model->clientes_actualiza($update); 		
 	   }	
 	  }

 	  	$guardaMensaje['desde']="Avisos de GAP<avisosgap@aserorescpital.com>";
        $guardaMensaje['para']=$correoAsignar;
        $guardaMensaje['asunto']='Transpaso de Prospectos';
        $guardaMensaje['mensaje']=$cadena;
        $guardaMensaje['status']=0;
        $guardaMensaje['identificaModulo']='Prospeccion transferencia de prospectos';
        $this->email_model->enviarCorreo($guardaMensaje); 	          
   echo json_encode($respuesta);	
	
 }
//-------------------------------------------------------------------------------------------------------------------------------------------------------------
 function verReasignados(){ 		
			$correoProcedente		= $this->tank_auth->get_usermail();
			$dat=$this->capsysdre->ListaReasignados($this->input->post('busquedaUsuario', TRUE),$correoProcedente)->result();
            $diasSemana=$this->libreriav3->devolverDiasSemana();
            $fechaHoy=getdate();
            $j=0;
            $pestania="";
            for($i=$fechaHoy['wday'];$i>=0;$i--){
             if($j==0){$pestania[$j]='HOY';}				   		
             else{$pestania[$j]=$diasSemana[$i];}
             $j++;
            }
            $fec=$fechaHoy['year'].'-'.$fechaHoy['mon'].'-'.$fechaHoy['mday'];
            $hoyEs=new DateTime($fec);
            $countDiaSemana=count($pestania);
 
            foreach ($dat as  $value) {
            	$dia=new DateTime(date("Y-m-d", strtotime($value->fechaCreacionCA )));
            	$diaCreacion=date("Y-m-d", strtotime($value->fechaCreacionCA ));
            	$diaCreacion=explode('-', $diaCreacion);
              $dif=$hoyEs->diff($dia);
              if($fechaHoy['year']!=$diaCreacion[0]){$value->pestania='ANTIGUOS';}
              else{$difMeses=$fechaHoy['mon']-$diaCreacion[1];
              	   if($difMeses>1){$value->pestania='ANTIGUOS';}
                   else{
                   	     if($difMeses==1){$value->pestania="MES_PASADO";}
                   	     else{
                   	           $difDia=$fechaHoy['mday']-$diaCreacion[2];
                   	           if($difDia<=$countDiaSemana){$value->pestania=$pestania[$difDia];}
                   	           else{$value->pestania="ESTE_MES";}
                   	         }
                   	   }
                  }
   	             
            }

            array_push($pestania,'ESTE MES');
            array_push($pestania,'MES PASADO');
            array_push($pestania,'ANTIGUOS');
            array_push($pestania,'TODOS');
            $data['ListaClientes']=$dat;
			$data['muestraCalendario']=$this->citaRegistrada;
			$data['citas']=$this->fullcalendar_model->devuelveCitasActivasPorUsuarios();
			$data['idCliente']=$this->idCliente;
			$data['pestania']=$pestania;
			if($this->tank_auth->get_View()!= "App"){$this->load->view('crmproyecto/reasignados',$data);} 
		
 }
//-------------------------------------------------------------------------------------------------------------------------------------------------------------
 function antiguo(){
 	$this->load->view('crmproyecto_01/_principal',$data);	
 }
//-------------------------------------------------------------------------------------------------------------------------------------------------------------

function subirdocumento(){
	$this->load->view('crmproyecto/subirdocumento');	
}


function guardar_documento(){
	 $this->load->model('manejodocumento_modelo');
	 $mi_archivo = 'documento';
	 $directorio=$this->manejodocumento_modelo->obtenerDirectorio("U");
     
$config['upload_path'] = $directorio."assets/documentos/";
     $config['file_name'] = $_FILES['documento']['name'];;
     $config['allowed_types'] = "*";
     $config['max_size'] = "50000";
     $config['max_width'] = "2000";
     $config['max_height'] = "2000";

     $this->load->library('upload', $config);
    
     if (!$this->upload->do_upload($mi_archivo)) {
        $data['uploadError'] = $this->upload->display_errors();
        echo $this->upload->display_errors();
        return;
     }
     //subir archivo
     $data['uploadSuccess'] = $this->upload->data();
     //Guardar URL
     $id=$this->input->post('id',TRUE);
     $nombre_archivo = $_FILES['documento']['name'];
	 $this->manejodocumento_modelo->modificar_url_documento($id,$nombre_archivo);
	 echo"
	 <script>
	 	alert('El Archivo de envio exitosamente');
		window.history.back(-1);
	</script>";
}

function importar_prospectos(){
	$datos=array();
	if((int)$this->tank_auth->get_IDVend()>0){$datos['imprimirSelecVendedor']=true;}

	$this->load->view('crmproyecto/importar_prospectos',$datos);
}

function guardar_prospectos(){ //Obsoleto Dennis Castillo [2022-05-12]
		 $this->load->model('manejodocumento_modelo');
		 $mi_archivo = 'lista';
		 $directorio=$this->manejodocumento_modelo->obtenerDirectorio("U")."assets/documentos/prospectos/";
	     
	   //crear carpeta temporal
	     mkdir($directorio.$this->tank_auth->get_usermail(), 0777);
	     $directorio=$directorio.$this->tank_auth->get_usermail()."/";

	     $config['upload_path'] = $directorio;
	     $config['file_name'] = 'prospectos';
	     $config['allowed_types'] = "*";
	     $config['max_size'] = "50000";
	     $config['max_width'] = "2000";
	     $config['max_height'] = "2000";

	     $this->load->library('upload', $config);
	    
	     if (!$this->upload->do_upload($mi_archivo)) {
	        $data['uploadError'] = $this->upload->display_errors();
	        echo $this->upload->display_errors();
	        return;
	     }
	     //Subir archivo
	    $data['uploadSuccess'] = $this->upload->data();
	    //Traspasar Info de archivo a BD
		$this->traspasar();
		//Eliminar archivo
		unlink($directorio."prospectos.xlsx");
		rmdir($directorio);

		echo"<script>alert('El Archivo de envio exitosamente');window.history.back(-1);</script>";
	}


	function traspasar(){ //Obsoleto Dennis Castillo [2022-05-12]
		$this->load->library('PHPExcel-1.8/Classes/PHPExcel.php');
		$this->load->model('manejodocumento_modelo');
		
		//Miguel 16/09/2020**********
		$directorio=$this->manejodocumento_modelo->obtenerDirectorio("U");
		$directorio=$directorio."assets/documentos/prospectos/".$this->tank_auth->get_usermail()."/";

		$archivo = $directorio."prospectos.xlsx";
		$inputFileType = PHPExcel_IOFactory::identify($archivo);
		$objReader = PHPExcel_IOFactory::createReader($inputFileType);
		$objPHPExcel = $objReader->load($archivo);
		$sheet = $objPHPExcel->getSheet(0); 
		$highestRow = $sheet->getHighestRow(); 
		$highestColumn = $sheet->getHighestColumn();


		for ($row = 2; $row <= $highestRow; $row++){
			$sql="insert into clientes_actualiza(actualiza,TipoEnt,IDCont,ApellidoP,ApellidoM,Nombre,RazonSocial,RFC,Email1,Telefono1,Usuario,EstadoActual,tipoEntidad,tipo_prospecto)values('clienteWeb','".'0'."','".'0'."','".strtoupper($sheet->getCell("A".$row)->getValue())."','".strtoupper($sheet->getCell("B".$row)->getValue())."','".strtoupper($sheet->getCell("C".$row)->getValue())."','".strtoupper($sheet->getCell("D".$row)->getValue())."','".$sheet->getCell("E".$row)->getValue()."','".strtoupper($sheet->getCell("F".$row)->getValue())."','".$sheet->getCell("G".$row)->getValue()."','".$this->tank_auth->get_usermail()."','DIMENSION','fisica','0'".");";
			 $this->db->query($sql);
       }
	}

	//--------------------
	function importProspectivesList(){

		try{
			$forInsert = array();
			$response = array();
			$file = $_FILES["lista"]["tmp_name"];
			$objExcel = PHPExcel_IOFactory::load($file);
			$sheet = $objExcel->getSheet(0);

			for($i = 2; $i <= $sheet->getHighestRow(); $i++){
				array_push($forInsert, array(
					"ApellidoP" => $sheet->getCell("A".$i)->getValue(),
					"ApellidoM" => $sheet->getCell("B".$i)->getValue(),
					"Nombre" => $sheet->getCell("C".$i)->getValue(),
					"RazonSocial" => $sheet->getCell("D".$i)->getValue(),
					"RFC" => $sheet->getCell("E".$i)->getValue(),
					"Email1" => $sheet->getCell("F".$i)->getValue(),
					"Telefono1" => $sheet->getCell("G".$i)->getValue(),
					"actualiza" => "clienteWeb",
					"TipoEnt" => 0,
					"IDCont" => 0,
					"Usuario" => $this->tank_auth->get_usermail(),
					"EstadoActual" => "DIMENSION",
					"tipoEntidad" => "fisica",
					"tipo_prospecto" => 0,
				));
			}
			
			$this->db->trans_begin();
			$this->db->insert_batch("clientes_actualiza", $forInsert);

			if($this->db->trans_status() === FALSE){
				$this->db->trans_rollback();
				$response = array("code" => 501, "status" => "failed", "message" => "Ocurrió un error en la carga de registros. Favor de contactar al depto de sistemas");
			} else{
				$this->db->trans_commit();
				$response = array("code" => 200, "status" => "success", "message" => "Importación de registros realizado con éxito", "data" => array("count" => count($forInsert)));
			}

			echo json_encode($response);
		} catch(Exception $e){
			echo "Excepción capturada: ".$e->getMessage();
		}
	}
	//--------------------
	
function notificaciones_primer_cita(){
	$hoy=date('d-m-Y');
	$dias=0;
	$dia_primer_cita=7;
	$data=$this->crmProyecto_Model->cliente_primera_cita();
		foreach ($data as $row) { 
				$fechaActualizacion=substr($row->fechaActualizacion, 0, -9);
				$dias=(strtotime($fechaActualizacion)-strtotime($hoy))/86400;
		   	 	$dias=abs($dias); 
		   	 	$dias = floor($dias);
		   	 	if($dias>=$dia_primer_cita){
		   	 		$sw=$this->crmProyecto_Model->existeNotificacion($row->IDCli);
					if(count($sw)>0){
						}else{
		   	 			$ins="INSERT into clientes_actualiza_notificacion(IDCli,EstadoActual,fechaActualizacion) values('$row->IDCli','$row->EstadoActual','$fechaActualizacion') ";
		   	 			$this->db->query($ins);
   	 				}
   	 			}
		}
}


function notificaciones_cierre(){
	$hoy=date('d-m-Y');
	$dias=0;
	$dia_cierre=7;
	$data=$this->crmProyecto_Model->cliente_cierre();
		foreach ($data as $row) { 
			$fechaActualizacion=substr($row->fechaActualizacion, 0, -9);
			$dias=(strtotime($fechaActualizacion)-strtotime($hoy))/86400;
	   	 	$dias=abs($dias); 
	   	 	$dias = floor($dias);
	   	 	if($dias>=$dia_cierre){
	   	 	$sw=$this->crmProyecto_Model->existeNotificacion($row->IDCli);
				if(count($sw)>0){
					$ins="UPDATE clientes_actualiza_notificacion SET EstadoActual='$row->EstadoActual' WHERE IDCli='$row->IDCli'";
	   	 			$this->db->query($ins);
				}else{
					$ins="INSERT into clientes_actualiza_notificacion(IDCli,EstadoActual,fechaActualizacion) values('$row->IDCli','$row->EstadoActual','$fechaActualizacion') ";
	   	 			$this->db->query($ins);
   	 			}
	 		}
		}
}



//Ultima Modificacion 26/10/2020
function enviarCorreoEscalado($idPersona,$IDCli){
	
	$sqlX="SELECT Nombre,ApellidoP,Email1,Telefono1,fechaActualizacion FROM clientes_actualiza WHERE IDCli='$IDCli'";
	$resultX=$this->db->query($sqlX)->result();

    foreach($resultX as $rowX) {
       $nombre=$rowX->Nombre;
       $apellidop=$rowX->ApellidoP;
       $email1=$rowX->Email1;
       $telefono1=$rowX->Telefono1;
       $fechaActualizacion=$rowX->fechaActualizacion;
    }

	$sql="SELECT idPuesto,email,padrePuesto FROM personapuesto WHERE idPersona='$idPersona'";
	$result=$this->db->query($sql)->result();
    foreach($result as $row) {
       $idPuesto=$row->idPuesto;
       $emailagente=$row->email;
       $idPadre=$row->padrePuesto;
    }

    $sqlY="SELECT email FROM personapuesto WHERE idPersona='$idPadre'";
	$resultY=$this->db->query($sqlY)->result();
    foreach($resultY as $rowY) {
       $email=$rowY->email;
    }



    $mensaje="<DOCTYPE html>
<html>
<head>
    <title></title>
    <style type='text/css'>
        body{
            font-family: arial;
            background-color: #E6E6E6;
            font-size: 12px;
        }
    </style>
</head>
<body>
<table width='75%' align='center' style='border-width: 1px;padding: 5%; border-color: #b2b2b2;border-radius: 10px;border-style: solid;background-color: #fff;'>
    <tr>
        <td align='left' colspan='2'>
            <img src='https://www.capsys.com.mx/V3/assets/img/logo/logocapital.png' width='30%' style='margin-top: -8%;'>
        </td>
    </tr>
    <tr align='center'><td colspan='2'><h4 style='color: blue;'>NOTIFICACIÓN DE PROSPECTO ASIGNADO -V3 Plus Capsys</h4></td></tr>
 
    <tr>
        <td><b>Nombre y Apellido:</b></td>
        <td>".strtoupper($nombre)."</td>
    </tr>
    <tr>
        <td width='50%'><b>Telefono:</b></td>
        <td>".strtoupper($apellidop)."</td>
    </tr>
    <tr>
        <td width='50%'><b>E-mail:</b></td>
        <td>".strtoupper($email1)."</td>
    </tr>
     <tr>
        <td width='50%'><b>Telefono:</b></td>
        <td>".strtoupper($telefono1)."</td>
    </tr>
    <tr>
        <td><b>Fecha de Registro:</b></td>
        <td>".$fechaActualizacion."</td>
    </tr>
    <tr><td colspan='2'>&nbsp;</td></tr>
    <tr>
    	<td colspan='2'>
    		<b>Nota:</b>&nbsp; Favor comunicarse con el prospecto el cual fue escalado desde &nbsp;".$emailagente."  a usted.
    	</td>
    </tr>
</table>
</body>
</html>";
echo $mensaje;

/*************Config 1 ***********/

$para=trim($email);
$titulo    = "Notificacion de Prospecto - Asesores Capital Seguros y Fianzas";
$cabeceras = 'MIME-Version: 1.0' . "\r\n";
$cabeceras .= 'Content-type: text/html; charset=utf-8' . "\r\n";
$cabeceras .= 'From: info@agentecapital.com' . "\r\n" .'Reply-To:info@agentecapital.com' . "\r\n" .'X-Mailer: PHP/';
mail($para, $titulo, $mensaje, $cabeceras);
}

function enviarCorreo($idPersona,$IDCli){
	
	$sqlX="SELECT Nombre,ApellidoP,Email1,Telefono1,fechaActualizacion FROM clientes_actualiza WHERE IDCli='$IDCli'";
	$resultX=$this->db->query($sqlX)->result();

    foreach($resultX as $rowX) {
       $nombre=$rowX->Nombre;
       $apellidop=$rowX->ApellidoP;
       $email1=$rowX->Email1;
       $telefono1=$rowX->Telefono1;
       $fechaActualizacion=$rowX->fechaActualizacion;
    }

	$sql="SELECT idPuesto,email FROM personapuesto WHERE idPersona='$idPersona'";
	$result=$this->db->query($sql)->result();
    foreach($result as $row) {
       $idPuesto=$row->idPuesto;
       $email=$row->email;
    }
    $mensaje="<DOCTYPE html>
<html>
<head>
    <title></title>
    <style type='text/css'>
        body{
            font-family: arial;
            background-color: #E6E6E6;
            font-size: 12px;
        }
    </style>
</head>
<body>
<table width='75%' align='center' style='border-width: 1px;padding: 5%; border-color: #b2b2b2;border-radius: 10px;border-style: solid;background-color: #fff;'>
    <tr>
        <td align='left' colspan='2'>
            <img src='https://www.capsys.com.mx/V3/assets/img/logo/logocapital.png' width='30%' style='margin-top: -8%;'>
        </td>
    </tr>
    <tr align='center'><td colspan='2'><h4 style='color: blue;'>NOTIFICACIÓN DE PROSPECTO ASIGNADO -V3 Plus Capsys</h4></td></tr>
 
    <tr>
        <td><b>Nombre y Apellido:</b></td>
        <td>".strtoupper($nombre)."</td>
    </tr>
    <tr>
        <td width='50%'><b>Telefono:</b></td>
        <td>".strtoupper($apellidop)."</td>
    </tr>
    <tr>
        <td width='50%'><b>E-mail:</b></td>
        <td>".strtoupper($email1)."</td>
    </tr>
     <tr>
        <td width='50%'><b>Telefono:</b></td>
        <td>".strtoupper($telefono1)."</td>
    </tr>
    <tr>
        <td><b>Fecha de Registro:</b></td>
        <td>".$fechaActualizacion."</td>
    </tr>
    <tr><td colspan='2'>&nbsp;</td></tr>
    <tr>
    	<td colspan='2'>
    		<b>Nota:</b>&nbsp; Favor comunicarse con el prospecto lo mas pronto posible, de lo contrario el mismo sera escalado.
    	</td>
    </tr>
</table>
</body>
</html>";
echo $mensaje;

/*************Config 1 ***********/

$para=trim($email);
$titulo    = "Notificacion de Prospecto - Asesores Capital Seguros y Fianzas";
$cabeceras = 'MIME-Version: 1.0' . "\r\n";
$cabeceras .= 'Content-type: text/html; charset=utf-8' . "\r\n";
$cabeceras .= 'From: info@agentecapital.com' . "\r\n" .'Reply-To:info@agentecapital.com' . "\r\n" .'X-Mailer: PHP/';
mail($para, $titulo, $mensaje, $cabeceras);
}

function notificaciones_leads(){
	$hoy=date('d-m-Y H:m:s');
	$hora_hoy1=explode(' ',$hoy);
	$hora_hoy2=explode(':',$hora_hoy1[1]);
	$hora_hoy=$hora_hoy2[0];
	$data=$this->crmProyecto_Model->cliente_leads();
		foreach ($data as $row) { 
			$hora1=explode(' ',$row->fechaActualizacion);
			$hora2=explode(':',$hora1[1]);
			$hora=$hora2[0];
			$t_hora=$hora-$hora_hoy;
			if($t_hora<>0){
				$sw=$this->crmProyecto_Model->existeNotificacion($row->IDCli);
				if(count($sw)>0){
					$ins="UPDATE clientes_actualiza_notificacion SET EstadoActual='$row->EstadoActual', escala='1' WHERE IDCli='$row->IDCli'";
	   	 			$this->db->query($ins);
				}else{
					$ins="INSERT into clientes_actualiza_notificacion(IDCli,EstadoActual,fechaActualizacion,tipo_prospecto) values('$row->IDCli','$row->EstadoActual','$hoy',3)";
	   	 			$this->db->query($ins);
	   	 			$this->enviarCorreo($this->tank_auth->get_idPersona(),$row->IDCli);
   	 			}

	 			$swX=$this->crmProyecto_Model->existeNotificacionEscala($row->IDCli);
				if(count($swX)>0){
					$ins="UPDATE clientes_actualiza_notificacion SET escala=2 WHERE IDCli='$row->IDCli'";
   	 				$this->db->query($ins);
   	 				$this->enviarCorreoEscalado($this->tank_auth->get_idPersona(),$row->IDCli);
				}
			}
		}
}

// Fin de Modificacion 


function actualiza_prospecto(){
	$id=$this->input->post('id',TRUE);
	$tipo=$this->input->post('tipo_prospecto',TRUE);
	$sql="UPDATE clientes_actualiza set tipo_prospecto='$tipo' WHERE IDCli='$id'";
	$this->db->query($sql);
}


function ModificarPerfilado(){
	$id=$this->input->post('IDCL',TRUE);
	$fuente=$this->input->post('fuente',TRUE);
	$IngMen=$this->input->post('IngMen',TRUE);
	$sql="UPDATE clientes_actualiza set FuenteProspecto='$fuente',IngresoMensual='$IngMen' WHERE IDCli='$id'";
	$this->db->query($sql);
}

function prospecto_genericos_estado(){
	$estado=$this->input->get('estado',TRUE);
	$data['ListaClientes']=$this->crmProyecto_Model->ClientesGenericosFiltroEstadoActual($estado);
	$this->load->view('crmproyecto/prospecto_genericos_estado',$data);
}

function agenda_citas_asesores(){
	$this->load->view('crmproyecto/agenda_citas_asesores');
}

function agregar_agenda(){
	$id_userInfo=$_REQUEST['id_userInfo'];
	$hinicio=$_REQUEST['hinicio'];
	$hfinal=$_REQUEST['hfinal'];
	$mesActual=$_REQUEST['mesActual'];
	$yearActual=$_REQUEST['yearActual'];

	$sql="INSERT INTO calendario_conf_personal(idPersona,hinicio,hfinal,mes,year) values ('$id_userInfo','$hinicio','$hfinal','$mesActual','$yearActual')";
		$this->db->query($sql);
	$this->load->view('crmproyecto/agenda_citas_asesores');
}



function get_id_userInfo($id){
	$sql="SELECT idPersona from users where id='$id' and idTipoUser_txt='Vendedor'";
	$this->db->query($sql);
	$result=$this->db->query($sql);
    foreach($result as $row) {
       $id_userInfo=$row->idPersona;
    }
    return $id_userInfo;

}

function eliminarAgenda(){
	$id=$this->input->get('id',TRUE);
	$sql="DELETE FROM calendario_citas_asesores where id='$id'";
	$this->db->query($sql);
	$this->load->view('crmproyecto/agenda_citas_asesores');
}

function eliminar_configuracion_agenda(){
	$id=$_REQUEST['id'];
    $query="DELETE from calendario_conf_personal WHERE id='$id'";
    $this->db->query($query);
    $this->load->view('crmproyecto/agenda_citas_asesores');
}


//***MJ **** 04/07/2022
function agregar_agenda_capital(){

	try{
		$id_userInfo=$_REQUEST['id_userInfo'];
		$hinicio=$_REQUEST['hinicio'];
		$hfinal=$_REQUEST['hfinal'];
		$mesActual=$_REQUEST['mesActual'];
		$yearActual=$_REQUEST['yearActual'];
		$duracion=$_REQUEST['duracion'];
		$query="SELECT * from calendario_conf_capital WHERE idPersona='$id_userInfo'";
		$result=$this->db->query($query)->result();
		$sw=0;
		foreach($result as $row){
			$sw=1;
		}
		if($sw==1){
			$sql="UPDATE calendario_conf_capital SET hinicio='$hinicio' , hfinal='$hfinal' ,mes='$mesActual' ,year='$yearActual' , duracion='$duracion' WHERE idPersona='$id_userInfo'";
		}else{
			$sql="INSERT INTO calendario_conf_capital(idPersona,hinicio,hfinal,mes,year,duracion) values ('$id_userInfo','$hinicio','$hfinal','$mesActual','$yearActual','$duracion')";
		}
		$this->db->query($sql);
		//$this->data["configuracion"]=$this->db->query($query)->result();
		//$this->data['id_userInfo']=$id_userInfo;
		//$this->load->view("calendario/configuracion_citas_online",$this->data);

		if($this->db->trans_status() === FALSE){

			$this->db->trans_rollback();
			throw new Exception("Ocurrió un error durante el proceso de registro", 500);
			
		} else {

			$this->db->trans_commit();
		}
		
		http_response_code(200);
		echo json_encode(array("success" => $this->db->trans_commit()));

	} catch(Exception $e){

		http_response_code($e->getCode());
		echo json_encode(array("success" => false, "message" => $e->getMessage()));
	}

}


function eliminar_configuracion_agenda_capital(){
	
	try{
		$id=$_REQUEST['id'];
		$query="DELETE from calendario_conf_capital WHERE id='$id'";
		$this->db->query($query);
		//$id_userInfo=$this->tank_auth->get_idPersona();
		//$this->data['id_userInfo']=$id_userInfo;
		//$query="SELECT * from calendario_conf_capital WHERE idPersona='$id_userInfo'";
		//$this->data["configuracion"]=$this->db->query($query)->result();
		//$this->load->view("calendario/configuracion_citas_online",$this->data);

		if($this->db->trans_status() === FALSE){

			$this->db->trans_rollback();
			throw new Exception("Ocurrió un error durante el proceso", 500);
			
		} else {

			$this->db->trans_commit();
		}
		
		http_response_code(200);
		echo json_encode(array("success" => $this->db->trans_commit()));

	} catch(Exception $e){

		http_response_code($e->getCode());
		echo json_encode(array("success" => false, "message" => $e->getMessage()));
	}
}
//Fin

//Modificacion Miguel Jaime 11/11/2020

function listar_notificaciones()
{
	$this->load->model('crmProyecto_Model');
	
	$data['primeracita']	= $this->crmProyecto_Model->cliente_primera_cita_notificacion($this->tank_auth->get_usermail());
	$data['cierre']			= $this->crmProyecto_Model->cliente_cierre_notificacion($this->tank_auth->get_usermail());
	$data['leads']			= $this->crmProyecto_Model->cliente_leads_notificacion($this->tank_auth->get_usermail());
	$data['tareas']			= $this->crmProyecto_Model->cliente_tareas_notificacion($this->tank_auth->get_idPersona());
	$this->load->view('crmproyecto/listar_notificaciones',$data);
}

function guardar_agente_temporal(){
	$nombres=$this->input->get('nombres',TRUE);
	$apellidoP=$this->input->get('apellidoP',TRUE);
	$apellidoM=$this->input->get('apellidoM',TRUE);
	$email=strtoupper($this->input->get('email',TRUE));
	$telefono=$this->input->get('telefono',TRUE);
	$userEmailCreacion=$this->tank_auth->get_usermail();
	$fechaCreacion=date('Y-m-d H:m:s');
	$sql="INSERT INTO persona(nombres,apellidoPaterno,apellidoMaterno,emailPersonal,celPersonal,tipoPersona,clave_externa,motivo_id,userEmailCreacion) values ('$nombres','$apellidoP','$apellidoM','$email','$telefono',4,'',0,'$userEmailCreacion')";
	$this->db->query($sql);
	
	$sqlX="SELECT idPersona from persona order by idPersona DESC";
	$rs=$this->db->query($sqlX)->result();
	$idPersona=$rs[0]->idPersona;

	$sqlY="INSERT INTO users(activated,banned,idPersona,usernameOld,password,emailOld,created,passwordVisible,IdSucursal,IdCanal,IdTipoUserSMSmail,emailAlternativo,IdSucursal2,FechaIngresoAgente,UsuarioCarCapital,CodeAuthPersonaSicas) values (1,0,'$idPersona','','','$email','$fechaCreacion','','','',0,'','',CURDATE(),0,'')";
	$this->db->query($sqlY);
	$this->load->view('crmproyecto/proyecto100');
}
//Modificacion 15/01/2020 
//Funcion encargada de consultar los prospectos de negocios en los direferentes estados y vias de insersion a la bd
function detalle_reporte_prospectos(){
	 
  $mes=date('m');
  $year=date('Y');
  //************************************
  //*** Prospectos Personas-Importacion

  //Suspectos
  $sql="SELECT * from clientes_actualiza where EstadoActual='DIMENSION' AND MONTH(fechaActualizacion)='$mes' AND YEAR(fechaActualizacion)='$year' AND tipo_prospecto=0";
  $datos['suspectos_personas_importacion']=$this->db->query($sql)->result();

   //Perfilados
  $sql="SELECT * from clientes_actualiza where EstadoActual='PERFILADO' AND MONTH(fechaActualizacion)='$mes' AND YEAR(fechaActualizacion)='$year' AND tipo_prospecto=0";
  $datos['perfilados_personas_importacion']=$this->db->query($sql)->result();

   //Contactados
  $sql="SELECT * from clientes_actualiza where EstadoActual='contactado' AND MONTH(fechaActualizacion)='$mes' AND YEAR(fechaActualizacion)='$year' AND tipo_prospecto=0";
  $datos['contactado_personas_importacion']=$this->db->query($sql)->result();

  //Cotizados
  $sql="SELECT * from clientes_actualiza where EstadoActual='COTIZADO' AND MONTH(fechaActualizacion)='$mes' AND YEAR(fechaActualizacion)='$year' AND tipo_prospecto=0";
  $datos['cotizado_personas_importacion']=$this->db->query($sql)->result();

   //Cerrados
  $sql="SELECT * from clientes_actualiza where EstadoActual='CERRADO' AND MONTH(fechaActualizacion)='$mes' AND YEAR(fechaActualizacion)='$year' AND tipo_prospecto=0";
  $datos['cerrado_personas_importacion']=$this->db->query($sql)->result();

  //************************
  //*** Prospectos Personas-Leads
  
  //Suspectos
  $sql="SELECT * from clientes_actualiza where EstadoActual='DIMENSION' AND MONTH(fechaActualizacion)='$mes' AND YEAR(fechaActualizacion)='$year' AND tipo_prospecto=3";
  $datos['suspectos_personas_leads']=$this->db->query($sql)->result();

   //Perfilados
  $sql="SELECT * from clientes_actualiza where EstadoActual='PERFILADO' AND MONTH(fechaActualizacion)='$mes' AND YEAR(fechaActualizacion)='$year' AND tipo_prospecto=3";
  $datos['perfilados_personas_leads']=$this->db->query($sql)->result();

//Contactados
  $sql="SELECT * from clientes_actualiza where EstadoActual='CONTACTADO' AND MONTH(fechaActualizacion)='$mes' AND YEAR(fechaActualizacion)='$year' AND tipo_prospecto=3";
  $datos['contactado_personas_leads']=$this->db->query($sql)->result();

  //Cotizados
 $sql="SELECT * from clientes_actualiza where EstadoActual='COTIZADO' AND MONTH(fechaActualizacion)='$mes' AND YEAR(fechaActualizacion)='$year' AND tipo_prospecto=3";
  $datos['cotizado_personas_leads']=$this->db->query($sql)->result();

  //Cerrados
$sql="SELECT * from clientes_actualiza where EstadoActual='CERRADO' AND MONTH(fechaActualizacion)='$mes' AND YEAR(fechaActualizacion)='$year' AND tipo_prospecto=3";
  $datos['cerrado_personas_leads']=$this->db->query($sql)->result();



   //************************
  //*** Prospectos Personas-Via Directo
  
  //Suspectos
  $sql="SELECT * from clientes_actualiza where EstadoActual='DIMENSION' AND MONTH(fechaActualizacion)='$mes' AND YEAR(fechaActualizacion)='$year' AND tipo_prospecto=1 AND FuenteProspecto='DIRECTO'";
  $datos['suspectos_personas_directo']=$this->db->query($sql)->result();

   //Perfilados
  $sql="SELECT * from clientes_actualiza where EstadoActual='PERFILADO' AND MONTH(fechaActualizacion)='$mes' AND YEAR(fechaActualizacion)='$year' AND tipo_prospecto=1 AND FuenteProspecto='DIRECTO'";
  $datos['perfilados_personas_directo']=$this->db->query($sql)->result();

//Contactados
  $sql="SELECT * from clientes_actualiza where EstadoActual='CONTACTADO' AND MONTH(fechaActualizacion)='$mes' AND YEAR(fechaActualizacion)='$year' AND tipo_prospecto=1 AND FuenteProspecto='DIRECTO'";
  $datos['contactado_personas_directo']=$this->db->query($sql)->result();

  //Cotizados
 $sql="SELECT * from clientes_actualiza where EstadoActual='COTIZADO' AND MONTH(fechaActualizacion)='$mes' AND YEAR(fechaActualizacion)='$year' AND tipo_prospecto=1 AND FuenteProspecto='DIRECTO'";
  $datos['cotizado_personas_directo']=$this->db->query($sql)->result();

  //Cerrados
$sql="SELECT * from clientes_actualiza where EstadoActual='CERRADO' AND MONTH(fechaActualizacion)='$mes' AND YEAR(fechaActualizacion)='$year' AND tipo_prospecto=1 AND FuenteProspecto='DIRECTO'";
  $datos['cerrado_personas_directo']=$this->db->query($sql)->result();


  //************************
  //*** Prospectos Genericos-Importacion

  //Suspectos
  $sql="SELECT idCli from clientes_actualiza where EstadoActual='DIMENSION' AND MONTH(fechaActualizacion)='$mes' AND YEAR(fechaActualizacion)='$year' AND tipo_prospecto=1";
  $datos['suspectos_genericos_importacion']=$this->db->query($sql)->result();

   //SIN VENTA
  $sql="SELECT idCli from clientes_actualiza where EstadoActual='SIN VENTA' AND MONTH(fechaActualizacion)='$mes' AND YEAR(fechaActualizacion)='$year' AND tipo_prospecto=1";
  $datos['sinventa_genericos_importacion']=$this->db->query($sql)->result();

  //EN PROGRESO
    $sql="SELECT idCli from clientes_actualiza where EstadoActual='EN PROGRESO' AND MONTH(fechaActualizacion)='$mes' AND YEAR(fechaActualizacion)='$year' AND tipo_prospecto=1";
  $datos['progreso_genericos_importacion']=$this->db->query($sql)->result();

  //************************
  //*** Prospectos Genericos-Leads

  //Suspectos
  $sql="SELECT idCli from clientes_actualiza where EstadoActual='DIMENSION' AND MONTH(fechaActualizacion)='$mes' AND YEAR(fechaActualizacion)='$year' AND tipo_prospecto=3";
  $datos['suspectos_genericos_leads']=$this->db->query($sql)->result();

  //Sin Ventas
   $sql="SELECT idCli from clientes_actualiza where EstadoActual='SIN VENTA' AND MONTH(fechaActualizacion)='$mes' AND YEAR(fechaActualizacion)='$year' AND tipo_prospecto=3";
  $datos['sinventa_genericos_leads']=$this->db->query($sql)->result();

   //En Progreso
   $sql="SELECT idCli from clientes_actualiza where EstadoActual='EN PROGRESO' AND MONTH(fechaActualizacion)='$mes' AND YEAR(fechaActualizacion)='$year' AND tipo_prospecto=3";
  $datos['progreso_genericos_leads']=$this->db->query($sql)->result();


    //*** Prospectos Genericos-Directo

  //Suspectos
  $sql="SELECT idCli from clientes_actualiza where EstadoActual='DIMENSION' AND MONTH(fechaActualizacion)='$mes' AND YEAR(fechaActualizacion)='$year' AND tipo_prospecto=1 AND FuenteProspecto='DIRECTO'"; 
  $datos['suspectos_genericos_directo']=$this->db->query($sql)->result();

  //Sin Ventas
   $sql="SELECT idCli from clientes_actualiza where EstadoActual='SIN VENTA' AND MONTH(fechaActualizacion)='$mes' AND YEAR(fechaActualizacion)='$year' AND tipo_prospecto=1 AND FuenteProspecto='DIRECTO'"; 
  $datos['sinventa_genericos_directo']=$this->db->query($sql)->result();

   //En Progreso
   $sql="SELECT idCli from clientes_actualiza where EstadoActual='EN PROGRESO' AND MONTH(fechaActualizacion)='$mes' AND YEAR(fechaActualizacion)='$year' AND tipo_prospecto=1 AND FuenteProspecto='DIRECTO'"; 
  $datos['progreso_genericos_directo']=$this->db->query($sql)->result();



  $this->load->view('reportes/detalle_reporte_prospectos',$datos);
}

function setProspecto(){
	$tipo=$_GET['tipo'];
	$data = json_decode($_GET['ids']);
	$hasta=sizeof($data);
	for($i=0;$i<$hasta;$i++){
		$sql="UPDATE clientes_actualiza set tipo_prospecto='$tipo' WHERE IDCli='$data[$i]'";
		$this->db->query($sql);
	}
	$this->proyecto100();
	
}
function actualiza_estado(){
	$id=$this->input->get('id',TRUE);
	$estado=$this->input->get('estado',TRUE);
	$sql="UPDATE clientes_actualiza set EstadoActual='$estado' WHERE IDCli='$id'";
	$this->db->query($sql);
	$this->proyecto100();
}

//Modificacion MJ 14 sep
//-----------------------------------------------------
function setDeteccionNecesidades(){
	$IDCL=$this->input->post('IDCL',TRUE);

    $compruebaProspecto=$this->db->query('select (count(d.id)) as id from deteccion_necesidades d where d.id='.$this->input->post('IDCL',TRUE))->result()[0]->id;
    
if($compruebaProspecto==0)
{
	$datos=array();
	for($i=0;$i<117;$i++)
	{
		$j=$i+1;
		$cad='text'.$j;
		$datos[$i]=$this->input->post($cad,TRUE);
	}
	$cad=$IDCL.",";
	for($i=0;$i<116;$i++)
	{
		if($i!=115){$cad.="'".$datos[$i]."'".',';}
		else{$cad.="'".$datos[$i]."'";}
	}
	$sql="INSERT INTO deteccion_necesidades values(".$cad.")";
	$this->db->query($sql);
}
else
{
      
     
     foreach ($_POST as $key => $value) 
     {
     	$vText=explode('text', $key);
     	 $update=array();
     	if(count($vText)==2)
     	{
     	 
     	 if($key=='text'.$vText[1])
     	 {
     	 	$dato['text'.$vText[1]]=$value;
     	 	array_push($update, $dato);
           //array_push($update, var)
     	 }	
     	}
     	
     }
     $this->db->where('id',$this->input->post('IDCL',TRUE));
     $this->db->update('deteccion_necesidades',$update[0]);
     
}
  $_GET['IDCL']=$IDCL;
  $this->deteccion_necesidades();
	
	
	$pdf = new FPDF();
	/*$pdf->AddPage();
	$pdf->Image('assets/img/logo/logocapital.png',10,0,40,40);
	$pdf->SetFont('Arial','B',16);
	$pdf->ln(20);
	$pdf->Cell(40,10,'Deteccion de Necesidades');
	$pdf->SetFont('Arial','',11);
	$pdf->ln(6);
	$pdf->Cell(40,10,'"Antes de iniciar, me gustaría hacer un compromiso con usted; durante este tiempo vamos a hablar de algunos');
	$pdf->ln(4);
	$pdf->Cell(40,10,'conceptos y voy a hacerle algunas preguntas con el objeto de analizar si nuestros servicios pueden serle de');
	$pdf->ln(4);
	$pdf->Cell(40,10,'utilidad" Eventualmente voy a preguntarle si los temas de los que estamos hablando le interesan o no; si me');
	$pdf->ln(4);
	$pdf->Cell(40,10,'contesta que no le interesa, en ese momento le agradezco y me retiro: ahora, si le interesa continuaremos');
	$pdf->ln(4);
	$pdf->Cell(40,10,'le parece bien?');
	$pdf->ln(8);
	$pdf->Cell(20,10,'Nombre:');
	$pdf->SetFont('Arial','B',11);
	$pdf->Cell(45,10, $datos[0]);
	$pdf->ln(4);
	$pdf->SetFont('Arial','',11);
	$pdf->Cell(20,10,'Correo:');
	$pdf->SetFont('Arial','B',11);
	$pdf->Cell(45,10, $datos[1]);
    
    $pdf->ln(4);
	$pdf->SetFont('Arial','',11);
	$pdf->Cell(20,10,'Fecha:');
	$pdf->SetFont('Arial','B',11);
	$pdf->Cell(45,10, $datos[2]);

	$pdf->ln(4);
	$pdf->SetFont('Arial','',11);
	$pdf->Cell(30,10,'Estado Civil:');
	$pdf->SetFont('Arial','B',11);
	$pdf->Cell(45,10, $datos[3]);

	$pdf->ln(4);
	$pdf->SetFont('Arial','',11);
	$pdf->Cell(20,10,'Telefono:');
	$pdf->SetFont('Arial','B',11);
	$pdf->Cell(45,10, $datos[4]);

	$pdf->ln(4);
	$pdf->SetFont('Arial','',11);
	$pdf->Cell(50,10,'Edad/Fecha de Nacimiento:');
	$pdf->SetFont('Arial','B',11);
	$pdf->Cell(45,10, $datos[5]);

	$pdf->ln(4);
	$pdf->SetFont('Arial','',11);
	$pdf->Cell(20,10,'Profesion: ');
	$pdf->SetFont('Arial','B',11);
	$pdf->Cell(45,10, $datos[6]);

	$pdf->ln(4);
	$pdf->SetFont('Arial','',11);
	$pdf->Cell(20,10,'Fumas?: ');
	$pdf->SetFont('Arial','B',11);
	$pdf->Cell(45,10, $datos[7]);

	$pdf->ln(4);
	$pdf->SetFont('Arial','B',11);
	$pdf->Cell(40,10,'Cuentas con seguro?:  ');
	$pdf->SetFont('Arial','',11);
	$pdf->ln(4);
	$pdf->Cell(40,10,strtoupper($datos[8]).', Compania:  '.strtoupper($datos[11]));
	$pdf->ln(4);
	$pdf->Cell(40,10,strtoupper($datos[9]).', Compania:  '.strtoupper($datos[12]));
	$pdf->ln(4);
	$pdf->Cell(40,10,strtoupper($datos[10]).', Compania:  '.strtoupper($datos[13]));

	$pdf->ln(8);
	$pdf->SetFont('Arial','B',11);
	$pdf->Cell(100,10,'DEPENDIENTES                     EDAD         PARENTESCO');
	$pdf->SetFont('Arial','',11);
	$pdf->ln(4);
	$pdf->Cell(55,10,$datos[14]);
	$pdf->Cell(20,10,$datos[15]); 
	$pdf->Cell(70,10,$datos[16]); 
	$pdf->ln(4);
	$pdf->Cell(55,10,$datos[17]);
	$pdf->Cell(20,10,$datos[18]); 
	$pdf->Cell(70,10,$datos[19]); 
	$pdf->ln(4);
	$pdf->Cell(55,10,$datos[20]);
	$pdf->Cell(20,10,$datos[21]); 
	$pdf->Cell(70,10,$datos[22]); 
	$pdf->ln(4);
	$pdf->Cell(55,10,$datos[23]);
	$pdf->Cell(20,10,$datos[24]); 
	$pdf->Cell(70,10,$datos[25]); 
	$pdf->ln(4);
	$pdf->Cell(55,10,$datos[26]);
	$pdf->Cell(20,10,$datos[27]); 
	$pdf->Cell(70,10,$datos[28]); 
	$pdf->ln(4);
	$pdf->Cell(55,10,$datos[29]);
	$pdf->Cell(20,10,$datos[30]); 
	$pdf->Cell(70,10,$datos[31]); 
	$pdf->ln(4);
	$pdf->Cell(55,10,$datos[32]);
	$pdf->Cell(20,10,$datos[33]); 
	$pdf->Cell(70,10,$datos[34]); 
	$pdf->ln(4);
	$pdf->Cell(55,10,$datos[35]);
	$pdf->Cell(20,10,$datos[36]); 
	$pdf->Cell(70,10,$datos[37]); 
	$pdf->ln(4);
	$pdf->Cell(55,10,$datos[38]);
	$pdf->Cell(20,10,$datos[39]); 
	$pdf->Cell(70,10,$datos[40]); 
	$pdf->ln(4);
	$pdf->Cell(55,10,$datos[41]);
	$pdf->Cell(20,10,$datos[42]); 
	$pdf->Cell(70,10,$datos[43]); 
	$pdf->ln(4);
	$pdf->Cell(55,10,$datos[44]);
	$pdf->Cell(20,10,$datos[45]); 
	$pdf->Cell(70,10,$datos[46]); 
	
	$pdf->ln(6);
	$pdf->SetFont('Arial','B',11);
	$pdf->Cell(20,10,'PREVISION FINANCIERA: ');
	$pdf->ln(4);
	$pdf->SetFont('Arial','B',11);
	$pdf->Cell(20,10,'Que tan dificil te resulta ahora?');
	$pdf->ln(4);
	$pdf->SetFont('Arial','B',11);
	$pdf->Cell(20,10,'R='.$datos[47]);

	$pdf->ln(6);
	$pdf->SetFont('Arial','',11);
	$pdf->Cell(20,10,'Ingreso Promedio mensual: '.$datos[48].'   x12: '.$datos[49]);

	$pdf->ln(4);
	$pdf->Cell(20,10,'Ingreso Promedio Anual: '.$datos[50].'   x12: '.$datos[51]);

	$pdf->ln(4);
	$pdf->Cell(20,10,'Anios Trabajados: '.$datos[52]);

	$pdf->ln(4);
	$pdf->Cell(20,10,'$: '.$datos[53].'   X10:'.$datos[54]);

	$pdf->ln(4);
	$pdf->Cell(20,10,'Cuanto tiene ahorrando? '.$datos[55].'   (sobra o falta)='.$datos[56]);

	$pdf->ln(6);
	$pdf->SetFont('Arial','B',11);
	$pdf->Cell(20,10,'NECESIDAD DE PROTECCION');
	
	$pdf->ln(4);
	$pdf->SetFont('Arial','',11);
	$pdf->Cell(20,10,'Gasto mensual:  '.$datos[57].'X12');

	$pdf->ln(4);
	$pdf->SetFont('Arial','',11);
	$pdf->Cell(20,10,'Gasto mensual:  '.$datos[58].'  X  ');

	$pdf->ln(4);
	$pdf->SetFont('Arial','',11);
	$pdf->Cell(20,10,' = '.$datos[59]);

	$pdf->ln(4);
	$pdf->SetFont('Arial','',11);
	$pdf->Cell(20,10,'(Sobra o falta):'.$datos[60]);

	$pdf->ln(4);
	$pdf->SetFont('Arial','',11);
	$pdf->Cell(20,10,'COmo te sientes de ver esto?: '.$datos[61]);

	$pdf->ln(6);
	$pdf->SetFont('Arial','B',11);
	$pdf->Cell(20,10,'SENSIBILIZAR CON OBSTACULOS');

	$pdf->ln(4);
	$pdf->SetFont('Arial','',11);
	$pdf->Cell(20,10,'Hacer consciente al cliente de los riesgos que pueden suceder si hubiese ocurrido'); 
	$pdf->ln(4);
	$pdf->Cell(20,10,'alguno de los obstaculos.Ejemplo: que pasaria si hubiese tenido una invalidez'); 
	$pdf->ln(4);
	$pdf->Cell(20,10,'hace 3 meses, como seriia tu situacion financiera actual, como estaria tu familia, etc'); 
	$pdf->ln(6);
	$pdf->SetFont('Arial','B',11);
	$pdf->Cell(20,10,'OBSTACULOS');

	$pdf->ln(6);
	$pdf->SetFont('Arial','',11);
	$pdf->Cell(20,10,'1.-Invalidez');
	$pdf->ln(4);
	$pdf->Cell(20,10,'Cual seria tu ingreso si sufrieras una incapacidad total y permanente? Te preocuparia?');
	$pdf->ln(4);
	$pdf->SetFont('Arial','B',11);
	$pdf->Cell(20,10,'R= '.$datos[62]);

	$pdf->ln(12);
	$pdf->SetFont('Arial','',11);
	$pdf->Cell(20,10,'2.-Fallecimiento');
	$pdf->ln(4);
	$pdf->Cell(20,10,'Si fallecieras, Quien se haria cargo de tus dependientes economicos? Te preocuparia?');
	$pdf->ln(4);
	$pdf->SetFont('Arial','B',11);
	$pdf->Cell(20,10,'R= '.$datos[63]);


	$pdf->ln(6);
	$pdf->SetFont('Arial','',11);
	$pdf->Cell(20,10,'3.-Vivir demasiado');
	$pdf->ln(4);
	$pdf->Cell(20,10,'Que tan longeva es tu familia?, Sabes de alguien que ya tenga una edad avanzada y no pueda hacerle frente');
	$pdf->ln(4);
	$pdf->Cell(20,10,'a sus gastos minimos indispensables?');
	$pdf->ln(4);
	$pdf->SetFont('Arial','B',11);
	$pdf->Cell(20,10,'R= '.$datos[64]);


	$pdf->ln(6);
	$pdf->SetFont('Arial','',11);
	$pdf->Cell(20,10,'4.-Gastos Extraordinarios');
	$pdf->ln(4);
	$pdf->Cell(20,10,'Alguna vez has tenido que pagar una cantidad de dinero que no tenias planeado? Como lo solucionaste?');
	$pdf->ln(4);
	$pdf->SetFont('Arial','B',11);
	$pdf->Cell(20,10,'R= '.strtoupper($datos[65]));

	$pdf->ln(6);
	$pdf->SetFont('Arial','',11);
	$pdf->Cell(20,10,'Gastas mas de lo que ingresas?');
	$pdf->ln(4);
	$pdf->SetFont('Arial','B',11);
	$pdf->Cell(20,10,'R= '.strtoupper($datos[66]));

	$pdf->ln(6);
	$pdf->SetFont('Arial','',11);
	$pdf->Cell(20,10,'Cuanto puedes aportar mensual o anual a tu proyecto sin alterar tu nivel de vida?');
	$pdf->ln(4);
	$pdf->Cell(20,10,'Fecha y hora de la proxima reunion:'.$datos[67]);

	$pdf->ln(6);
	$pdf->SetFont('Arial','',11);
	$pdf->Cell(20,10,'Hay alguien que deba estar presente para tomar decisiones en nuestra proxima cita?');
	$pdf->ln(4);
	$pdf->SetFont('Arial','B',11);
	$pdf->Cell(20,10,'R= '.strtoupper($datos[68]));
	$pdf->ln(4);
	$pdf->SetFont('Arial','',11);
	$pdf->Cell(20,10,'Quien?');
	$pdf->ln(4);
	$pdf->SetFont('Arial','B',11);
	$pdf->Cell(20,10,'R= '.strtoupper($datos[69]));

	$pdf->ln(12);
	$pdf->SetFont('Arial','B',11);
	$pdf->Cell(20,10,'RESUMEN ESTRATEGICO');
	$pdf->ln(6);
	$pdf->SetFont('Arial','',11);
	$pdf->Cell(20,10,'Cuanto puedes aportar mensual o anual o tu proyecto sin alterar tu nivel de vida');
	$pdf->ln(4);
	$pdf->Cell(20,10,'Fecha y hora de la proxima reunion: '.$datos[70]);
	$pdf->ln(4);
	$pdf->Cell(20,10,'Hay alguien que deba estar presente para tomar decisiones en nuestra proxima cita?');
	$pdf->ln(4);
	$pdf->SetFont('Arial','B',11);
	$pdf->Cell(20,10,'R= '.strtoupper($datos[71]));
	$pdf->ln(4);
	$pdf->SetFont('Arial','',11);
	$pdf->Cell(20,10,'Quien?');
	$pdf->ln(4);
	$pdf->SetFont('Arial','B',11);
	$pdf->Cell(20,10,'R= '.strtoupper($datos[72]));
	
	$pdf->ln(12);
	$pdf->SetFont('Arial','B',11);
	$pdf->Cell(20,10,'ACUERDOS');

	$pdf->ln(6);
	$pdf->SetFont('Arial','',11);
	$pdf->Cell(20,10,'Al formalizar el dia de la segunda cita, la probabilidad de que esta se de aumenta. Aprovecha la sensibilizacion'); 
	$pdf->ln(4);
	$pdf->Cell(20,10,'del prospecto');

	$pdf->ln(6);
	$pdf->SetFont('Arial','',11);
	$pdf->Cell(20,10,'"Me toma de dos a tres dias estudiar tus preguntas y elaborar tu estrategia... asi podre presentartela el dia');
	$pdf->ln(4);
	$pdf->SetFont('Arial','B',11);
	$pdf->Cell(20,10,'R= '.strtoupper($datos[73]));

	$pdf->ln(12);
	$pdf->SetFont('Arial','B',11);
	$pdf->Cell(20,10,'SOLICITAR REFERIDOS');
	$pdf->ln(6);
	$pdf->SetFont('Arial','B',11);
	$pdf->Cell(100,10,'NOMBRE                                 EDAD ');
	$pdf->SetFont('Arial','',11);
	$pdf->ln(4);
	$pdf->Cell(55,10,$datos[74]);
	$pdf->Cell(20,10,$datos[75]);
	$pdf->ln(4);
	$pdf->Cell(55,10,$datos[76]);
	$pdf->Cell(20,10,$datos[77]);
	$pdf->ln(4);
	$pdf->Cell(55,10,$datos[78]);
	$pdf->Cell(20,10,$datos[79]);
	$pdf->ln(4);
	$pdf->Cell(55,10,$datos[80]);
	$pdf->Cell(20,10,$datos[81]);
	$pdf->ln(4);
	$pdf->Cell(55,10,$datos[82]);
	$pdf->Cell(20,10,$datos[83]);
	$pdf->ln(4);
	$pdf->Cell(55,10,$datos[84]);
	$pdf->Cell(20,10,$datos[85]);
	$pdf->ln(4);
	$pdf->Cell(55,10,$datos[86]);
	$pdf->Cell(20,10,$datos[87]);
	$pdf->ln(4);
	$pdf->Cell(55,10,$datos[88]);
	$pdf->Cell(20,10,$datos[89]);
	$pdf->ln(4);
	$pdf->Cell(55,10,$datos[90]);
	$pdf->Cell(20,10,$datos[91]);
	$pdf->ln(4);
	$pdf->Cell(55,10,$datos[92]);
	$pdf->Cell(20,10,$datos[93]);
	
	$this->load->model('manejodocumento_modelo');
    $directorio=$this->manejodocumento_modelo->obtenerDirectorio("U");
    $ruta=$directorio."assets/documentos/deteccion_necesidades/";
	$IDCL=$ruta.$IDCL.'.pdf';
	$pdf->Output('F',$IDCL);
	$this->proyecto100();*/
}
//-----------------------------------------------------
    //Modificacion Miguel 26/03/2021

    function guardar_prospectos_agentes(){
             $this->load->model('manejodocumento_modelo');
             $mi_archivo = 'lista';
             $directorio=$this->manejodocumento_modelo->obtenerDirectorio("U")."assets/documentos/prospectos_agentes/";
             
           //crear carpeta temporal
             mkdir($directorio.$this->tank_auth->get_usermail(), 0777);
             $directorio=$directorio.$this->tank_auth->get_usermail()."/";

             $config['upload_path'] = $directorio;
             $config['file_name'] = 'prospectos_agentes';
             $config['allowed_types'] = "*";
             $config['max_size'] = "50000";
             $config['max_width'] = "2000";
             $config['max_height'] = "2000";

             $this->load->library('upload', $config);
            
             if (!$this->upload->do_upload($mi_archivo)) {
                $data['uploadError'] = $this->upload->display_errors();
                echo $this->upload->display_errors();
                return;
             }
            
            $data['uploadSuccess'] = $this->upload->data();
           $this->traspasar_propectos_agentes();
            unlink($directorio."prospectos_agentes.xlsx");
            rmdir($directorio);
            echo"<script>alert('El Archivo de envio exitosamente');window.history.back(-1);</script>";
        }


        function traspasar_propectos_agentes(){
            $this->load->library('PHPExcel-1.8/Classes/PHPExcel.php');
            $this->load->model('manejodocumento_modelo');
            
            $directorio=$this->manejodocumento_modelo->obtenerDirectorio("U");
            $directorio=$directorio."assets/documentos/prospectos_agentes/".$this->tank_auth->get_usermail()."/";

            $archivo = $directorio."prospectos_agentes.xlsx";
            $inputFileType = PHPExcel_IOFactory::identify($archivo);
            $objReader = PHPExcel_IOFactory::createReader($inputFileType);
            $objPHPExcel = $objReader->load($archivo);
            $sheet = $objPHPExcel->getSheet(0);
            $highestRow = $sheet->getHighestRow();
            $highestColumn = $sheet->getHighestColumn();


           for ($row = 2; $row <= $highestRow; $row++){
               $sql="insert into prospectos_agentes(medio,tiene_cedula,prospecto,correo,numero_telefono,ubicacion,dia,mes,anio,coordinacion,asignado,comentarios,status)values(
               '".strtoupper($sheet->getCell("A".$row)->getValue())."',
               '".strtoupper($sheet->getCell("B".$row)->getValue())."',
               '".preg_replace('([^A-Za-z0-9])','', strtoupper($sheet->getCell("C".$row)->getValue()))."',
               '".strtoupper($sheet->getCell("D".$row)->getValue())."',
               '".$sheet->getCell("E".$row)->getValue()."',
               '".strtoupper($sheet->getCell("F".$row)->getValue())."',
               '".$sheet->getCell("G".$row)->getValue()."',
               '".$sheet->getCell("H".$row)->getValue()."',
               '".date('Y')."',
               '".$sheet->getCell("I".$row)->getValue()."',
               '".$sheet->getCell("J".strtoupper($row)->getValue())."',
               '".$sheet->getCell("L".$row)->getValue()."',
               '".$sheet->getCell("K".$row)->getValue()."'".");";
                $this->db->query($sql);
           }
        }

   //modificacion 16/04
       
       
  function modificar_agentes_seleccionados(){
       $data['prospectos']=$_GET['prospectos'];
       $data['status']=$_GET['status'];
       $this->crmProyecto_Model->modificar_agentes_seleccionados($data);
       echo "<script>alert('Los Prospectos se han modificado exitosamente');</script>";
       $this->load->view('crmproyecto/prospectos_agentes_filtrado');
   }

   function modificar_agentes_seleccionados_asignacion(){
       $data['prospectos']=$_GET['prospectos'];
       $data['asignado']=strtoupper($_GET['asignado']);
       $this->crmProyecto_Model->modificar_agentes_seleccionados_asignacion($data);
       echo "<script>alert('Los Prospectos se han asignado exitosamente');</script>";
       $this->load->view('crmproyecto/prospectos_agentes_filtrado');
   }

   function prospectos_agentes_filtradoKey(){
       $param=$_GET['param'];
       $valor=$_GET['valor'];
       $valor=$valor."%";
       $user=$this->tank_auth->get_usermail();
       $users=[
       "DIRECTORGENERAL@AGENTECAPITAL.COM",
       "MARKETING@AGENTECAPITAL.COM"
       ];
       $sw=0;
       for($i=0;$i<count($users);$i++){
           if($user==$users[$i]){
               $sql="SELECT * FROM prospectos_agentes WHERE ".$param." LIKE '$valor'";
               $sw=1;
           }
       }
       if($sw==0){
           $sql="SELECT * FROM prospectos_agentes WHERE asignado='$user' AND ".$param." LIKE '$valor'";
       }
       $data['agentes']=$this->db->query($sql)->result();
       $this->load->view('crmproyecto/prospectos_agentes_filtrado',$data);
   }

   function prospectos_agentes_filtrado(){
       $param=$_GET['param'];
       $valor=$_GET['valor'];
       $user=$this->tank_auth->get_usermail();
       $users=[
       "DIRECTORGENERAL@AGENTECAPITAL.COM",
       "MARKETING@AGENTECAPITAL.COM"
       ];
       $sw=0;
       for($i=0;$i<count($users);$i++){
           if($user==$users[$i]){
               $sql="SELECT * FROM prospectos_agentes WHERE ".$param."='$valor'";
               $sw=1;
           }
       }
       if($sw==0){
           $sql="SELECT * FROM prospectos_agentes WHERE asignado='$user' AND ".$param."='$valor'";
       }
       $data['agentes']=$this->db->query($sql)->result();
       $this->load->view('crmproyecto/prospectos_agentes_filtrado',$data);
   }

     function actualizar_prospectos_agentes(){
      $data['prospectos']=$_GET['p'];
      $this->load->view('crmproyecto/prospectos_agentes_seleccionados',$data);
    }

    function actualizar_prospectos_agentes_asignacion(){
      $data['prospectos']=$_GET['p'];
      $this->load->view('crmproyecto/prospectos_agentes_seleccionados_asignacion',$data);
    }

    function actualiza_comentario(){
       $comentario=$_GET['comentario'];
       $id=$_GET['id'];
       $sql="UPDATE prospectos_agentes SET comentarios='$comentario' WHERE id='$id'";
       $this->db->query($sql);
       $this->load->view('crmproyecto/prospectos_agentes_filtrado');
   }

   function prospectos_agentes(){
       $this->load->view('crmproyecto/prospectos_agentes');
   }
   function seguimiento_prospecto(){
       $this->load->view('crmproyecto/proyecto100');
   }
   function EliminarProspectoAgente(){
       $id=$this->input->get('id',TRUE);
       $sql="DELETE FROM prospectos_agentes where id='$id'";
       $this->db->query($sql);
       $this->load->view('crmproyecto/prospectos_agentes_filtrado');
   }
    
    //Modificacion 07/2021-->
    function prospectos_leads(){
        $this->load->view('crmproyecto/prospectos_leads');
    }


    function prospectos_leads_filtradoKey(){
        $param=$_GET['param'];
        $valor=$_GET['valor'];
        $valor=$valor."%";
        $user=$this->tank_auth->get_usermail();
        $users=[
        "DIRECTORGENERAL@AGENTECAPITAL.COM",
        "MARKETING@AGENTECAPITAL.COM"
        ];
        $sw=0;
        for($i=0;$i<count($users);$i++){
            if($user==$users[$i]){
                $sql="SELECT * FROM clientes_actualiza WHERE leads<>'' AND tipo_prospecto=0 AND ".$param." LIKE '$valor'";
                $sw=1;
            }
        }
        if($sw==0){
            $sql="SELECT * FROM clientes_actualiza WHERE asignado='$user' AND leads<>'' AND tipo_prospecto=0 AND ".$param." LIKE '$valor'";
        }
        $data['leads']=$this->db->query($sql)->result();
        $this->load->view('crmproyecto/prospectos_leads_filtrado',$data);
    }
   //Fin de modificacion
    //*********************_________________FINAL Miguel
//-------------------------------------------------------------
function buscarProspectosEmitidos()
{
	$datos['mensaje']="";
	$email=$this->tank_auth->get_usermail();
	if(isset($_GET['email'])){$email=$_GET['email'];}
	$consulta='select * from clientes_actualiza c where c.pagado=1 and c.Usuario="'.$email.'"';
	$datos['informacion']=$this->db->query($consulta)->result();
    
	echo json_encode($datos);
}
//-------------------------------------------------------
function traerDocumentos()
{
$respuesta['mensaje']='mensaje';
$respuesta['documentoSicas']=array();
$respuesta['children']=array();
   if($_GET['IDCliSikas']!='')
   {
  $buscar['IDValuePK'] = $_GET["IDCliSikas"];	  
  $respuesta['children']=$this->ws_sicas->GetCDDigitalCliente($buscar)['children'];
 
   }
  	$ruta=FCPATH;	
	$ruta=str_replace("\\", '/', $ruta);	
	$nameFileSicas=1;
	$ruta.='assets/documentos/deteccion_necesidades/'.$_GET['IDCli'].'.pdf';
	
	if(file_exists($ruta))
	{
      $necesidades['isFolder']='';
      $necesidades['text']='DETECCION NECESIDADES';
      $necesidades['href']=base_url().'assets/documentos/deteccion_necesidades/'.$_GET['IDCli'].'.pdf';
      $necesidades['hrefTarget']='_blank';
      $necesidades['level']=1;

	  array_push($respuesta['children'], $necesidades);
    }
  
  echo json_encode($respuesta);
}
//-------------------------------------------------------

//Modificacion 07/2021-->

function getDatosProspectoCotizador($IDCL){
	$sql="SELECT * FROM clientes_actualiza WHERE IDCli='$IDCL'";
	$rs=$this->db->query($sql)->result();
	return $rs[0];
}

function getDatosCorizador(){
	$sql="SELECT * FROM cotizador_fianzas";
	$rs=$this->db->query($sql)->result();
	return $rs[0];
}


function CotizacionFianzas(){
	$this->data['IDCL']=$_REQUEST['id'];
	$this->data['datos']=$this->getDatosCorizador();
	$this->data['cliente']=$this->getDatosProspectoCotizador($_REQUEST['id']);
	$this->load->view('crmproyecto/cotizador_fianzas',$this->data);
}

/*function funnelEstadoAgentes(){
	$estado=$_REQUEST['estado'];
	$mes=$_REQUEST['mes'];
	$year=date('Y');
	$sql="SELECT * FROM prospectos_agentes WHERE status='$estado' AND MONTH(fecha)='$mes' AND YEAR(fecha)='$year'";
	$rs=$this->db->query($sql)->result();
	$tblAgentes="<table class='table table-responsive table-striped table-hover' style='width:100%;font-size:11px;'>";
	$tblAgentes.="<tr><td colspan='8'><h4>Listado de Prospectos Agentes</h4></td></tr>";
	$tblAgentes.="<tr><td colspan='8'><b>Estado: </b>".$estado."</td></tr>";
	$tblAgentes.="<tr style='background-color:#1e4c82;color:#fff;'><th>Prospecto</th><th>Medio</th><th>Status</th><th>CedulaS/N</th><th>Correo</th><th>Coordinación</th><th>Asignado</th><th>Comentarios</th></tr>";
	foreach($rs as $row){
		$tblAgentes.='<tr><td>'.$row->prospecto.'</td><td>'.$row->medio.'</td><td>'.$row->status.'</td><td>'.$row->tiene_cedula.'</td><td>'.$row->correo.'</td><td>'.$row->coordinacion.'</td><td>'.$row->asignado.'</td><td>'.$row->comentarios.'</td></tr>';
	}
	$tblAgentes.="</table>";
	echo $tblAgentes;
}*/

function funnelEstadoFianzas(){
	$estado=$_REQUEST['estado'];
	$mes=$_REQUEST['mes'];
	$year=date('Y');
	$sql="SELECT * from clientes_actualiza where YEAR(fechaActualizacion)='$year' AND MONTH(fechaActualizacion)='$mes' AND leads='http://www.fianzascapital.com.mx' AND EstadoActual='$estado'";
	$rs=$this->db->query($sql)->result();
	$tblFianzas="<table class='table table-responsive table-striped table-hover' style='width:100%;font-size:11px;'>";
	$tblFianzas.="<tr><td colspan='5'><h4>Listado de Prospectos de Fianzas</h4</td></tr>";
	$tblFianzas.="<tr><td colspan='5'><b>Estado: </b>".$estado."</td></tr>";
	$tblFianzas.="<tr style='background-color:#1e4c82;color:#fff;'><th>Prospecto</th><th>Email</th><th>Telefono</th><th>Estado Actual</th><th>Via Landing Page</th></tr>";
	foreach($rs as $row){
		$tblFianzas.='<tr><td>'.$row->Nombre.' '.$row->ApellidoP.'</td><td>'.$row->EMail1.'</td><td>'.$row->Telefono1.'</td><td>'.$row->EstadoActual.'</td><td>'.$row->leads.'</td></tr>';
	}
	$tblFianzas.="</table>";
	echo $tblFianzas;
}


function funnelEstadoMarketing(){
	$estado=$_REQUEST['estado'];
	$mes=$_REQUEST['mes'];
	$year=date('Y');
	$sql="SELECT * from clientes_actualiza where YEAR(fechaActualizacion)='$year' AND MONTH(fechaActualizacion)='$mes' AND leads!='' AND EstadoActual='$estado'  AND Usuario!='TELEMARKETING@AGENTECAPITAL.COM'";
	$rs=$this->db->query($sql)->result();
	$tblMarketing="<table class='table table-responsive table-striped table-hover' style='width:100%;font-size:11px;'>";
	$tblMarketing.="<tr><td colspan='6'><h4>Listado de Prospectos de Marketing(Leads)</h4</td></tr>";
	$tblMarketing.="<tr><td colspan='6'><b>Estado: </b>".$estado."</td></tr>";
	$tblMarketing.="<tr style='background-color:#1e4c82;color:#fff;'><th>Prospecto</th><th>Email</th><th>Telefono</th><th>Estado Actual</th><th>Asignado</th><th>Via Landing Page</th></tr>";
	foreach($rs as $row){
		$tblMarketing.='<tr><td>'.$row->Nombre.' '.$row->ApellidoP.'</td><td>'.$row->EMail1.'</td><td>'.$row->Telefono1.'</td><td>'.$row->EstadoActual.'</td><td>'.$row->Usuario.'</td><td>'.$row->leads.'</td></tr>';
	}
	$tblMarketing.="</table>";
	echo $tblMarketing;
}


function filtroProspeccionFianzas(){
	$this->load->model('funnelM');
	$mes=$_REQUEST['mes'];
	$this->data['prospectosFianzas']=$this->funnelM->prospectosFianzas($mes);
	$this->load->view('funnel/fianzas',$this->data);
}

function filtroProspeccionAgentes(){
	$this->load->model('funnelM');
	$mes=$_REQUEST['mes'];
	$this->data['prospectosAgentes']=$this->funnelM->prospectosAgentes($mes);
	$this->load->view('funnel/agentes',$this->data);
}

function filtroEstadisticaMarketing(){
	$this->load->model('funnelM');
	$mes=$_REQUEST['mes'];
	//Visitantes
	$this->data['visitasFianzas']=$this->funnelM->funnel_landing('Fianzas',$mes);
	$this->data['visitasGmm']=$this->funnelM->funnel_landing('Gmm',$mes);
	//Alcanzados
	$this->data['alcanzadosFianzas']=$this->funnelM->funnel_landing_alcanzados('Fianzas',$mes);
	$this->data['alcanzadosGmm']=$this->funnelM->funnel_landing_alcanzados('Gmm',$mes);
	//Efectivos
	$this->data['efectivosFianzas']=$this->funnelM->funnel_landing_efectivos('Fianzas',$mes);
	$this->data['efectivosGmm']=$this->funnelM->funnel_landing_efectivos('Gmm',$mes);
	$this->data['mes']=$mes;
	$this->load->view('funnel/estadistica_marketing',$this->data);
}

function setCotizadoFianzas($IDCL){
	$sql="UPDATE clientes_actualiza SET EstadoActual='COTIZADO' WHERE IDCli='$IDCL'";
	$this->db->query($sql);
}

function RptCotizadorFianzas(){
	$chkAnticipo='';
	$chkCumplimiento='';
	$chkVicios='';
	$sw='';
	if(isset($_REQUEST['chkAnticipo'])){
		$sw=$sw.'a';
	}
	if(isset($_REQUEST['chkCumplimiento'])){
		$chkCumplimiento=$_REQUEST['chkCumplimiento'];
		$sw=$sw.'c';
	}
	if(isset($_REQUEST['chkVicios'])){
		$chkVicios=$_REQUEST['chkVicios'];
		$sw=$sw.'v';
	}
	

	$nombre=$_REQUEST['nombre'];
	$anticipo_contrato=$_REQUEST['contrato1'];
	$anticipo_monto=$_REQUEST['montoAfianzado1'];
	$anticipo_total=$_REQUEST['totalPagar1'];

	$cumplimiento_contrato=$_REQUEST['contrato2'];
	$cumplimiento_monto=$_REQUEST['montoAfianzado2'];
	$cumplimiento_total=$_REQUEST['totalPagar2'];

	$por1=$_REQUEST['txtporrpt1'];
	$por2=$_REQUEST['txtporrpt2'];
	$por3=$_REQUEST['txtporrpt3'];

	$vicios_contrato=$_REQUEST['contrato3'];
	$vicios_monto=$_REQUEST['montoAfianzado2'];
	$vicios_total=$_REQUEST['totalPagar3'];

	$IDCL=$_REQUEST['IDCL'];
	$tipo=$_REQUEST['tipo'];
	
	$pdf = new FPDF();
	header("Content-Type: text/html; charset=iso-8859-1 ");
	$pdf->AddPage();
	$pdf->Image('assets/img/logo_fianzas.png',10,0,35,35);
	
	$pdf->ln(20);
	$pdf->SetFont('Arial','',11);
	$pdf->Cell(40,10,$nombre);
	$pdf->ln(5);
	$pdf->Cell(40,10,'PRESENTE');

	$pdf->SetFont('Arial','B',12);
	$pdf->ln(10);
	$pdf->Cell(40,10,'De acuerdo a lo que platicamos considerando el contrato con IVA');
	$pdf->ln(10);
	$pdf->Cell(30,5,"FIANZAS",1);
	$pdf->Cell(30,5,"CONTRATO",1);
	$pdf->Cell(10,5,"%",1);
	$pdf->Cell(45,5,"MONTO AFIANZADO",1);
	$pdf->Cell(40,5,"TOTAL A PAGAR",1);
	$pdf->SetFont('Arial','',12);
	$pdf->ln(5);

	if($sw=='a'){
		$pdf->Cell(30,5,"Anticipo",1);
		$pdf->Cell(30,5,utf8_decode($anticipo_contrato),1,0,'R');
		$pdf->Cell(10,5,$por1,1);
		$pdf->Cell(45,5,utf8_decode($anticipo_monto),1,0,'R');
		$pdf->Cell(40,5,utf8_decode($anticipo_total),1,0,'R');
	}
	if($sw=='c'){
		$pdf->Cell(30,5,"Cumplimiento",1);
		$pdf->Cell(30,5,utf8_decode($cumplimiento_contrato),1,0,'R');
		$pdf->Cell(10,5,$por2,1);
		$pdf->Cell(45,5,utf8_decode($cumplimiento_monto),1,0,'R');
		$pdf->Cell(40,5,utf8_decode($cumplimiento_total),1,0,'R');
	}
	if($sw=='v'){
		$pdf->Cell(30,5,"Vicios Ocultos",1);
		$pdf->Cell(30,5,utf8_decode($vicios_contrato),1,0,'R');
		$pdf->Cell(10,5,$por3,1);
		$pdf->Cell(45,5,utf8_decode($vicios_monto),1,0,'R');
		$pdf->Cell(40,5,utf8_decode($vicios_total),1,0,'R');
	}

	if($sw=='ac'){
		$pdf->Cell(30,5,"Anticipo",1);
		$pdf->Cell(30,5,utf8_decode($anticipo_contrato),1,0,'R');
		$pdf->Cell(10,5,$por1,1);
		$pdf->Cell(45,5,utf8_decode($anticipo_monto),1,0,'R');
		$pdf->Cell(40,5,utf8_decode($anticipo_total),1,0,'R');
		$pdf->ln(5);
		$pdf->Cell(30,5,"Cumplimiento",1);
		$pdf->Cell(30,5,utf8_decode($cumplimiento_contrato),1,0,'R');
		$pdf->Cell(10,5,$por2,1);
		$pdf->Cell(45,5,utf8_decode($cumplimiento_monto),1,0,'R');
		$pdf->Cell(40,5,utf8_decode($cumplimiento_total),1,0,'R');
	}

	if($sw=='av'){
		$pdf->Cell(30,5,"Anticipo",1);
		$pdf->Cell(30,5,utf8_decode($anticipo_contrato),1,0,'R');
		$pdf->Cell(10,5,$por1,1);
		$pdf->Cell(45,5,utf8_decode($anticipo_monto),1,0,'R');
		$pdf->Cell(40,5,utf8_decode($anticipo_total),1,0,'R');
		$pdf->ln(5);
		$pdf->Cell(30,5,"Vicios Ocultos",1);
		$pdf->Cell(30,5,utf8_decode($vicios_contrato),1,0,'R');
		$pdf->Cell(10,5,$por3,1);
		$pdf->Cell(45,5,utf8_decode($vicios_monto),1,0,'R');
		$pdf->Cell(40,5,utf8_decode($vicios_total),1,0,'R');
	}

	if($sw=='cv'){
		$pdf->Cell(30,5,"Cumplimiento",1);
		$pdf->Cell(30,5,utf8_decode($cumplimiento_contrato),1,0,'R');
		$pdf->Cell(10,5,$por2,1);
		$pdf->Cell(45,5,utf8_decode($cumplimiento_monto),1,0,'R');
		$pdf->Cell(40,5,utf8_decode($cumplimiento_total),1,0,'R');
		$pdf->ln(5);
		$pdf->Cell(30,5,"Vicios Ocultos",1);
		$pdf->Cell(30,5,utf8_decode($vicios_contrato),1,0,'R');
		$pdf->Cell(10,5,$por3,1);
		$pdf->Cell(45,5,utf8_decode($vicios_monto),1,0,'R');
		$pdf->Cell(40,5,utf8_decode($vicios_total),1,0,'R');
	}
	if($sw=='acv'){
		$pdf->Cell(30,5,"Anticipo",1);
		$pdf->Cell(30,5,utf8_decode($anticipo_contrato),1,0,'R');
		$pdf->Cell(10,5,$por1,1);
		$pdf->Cell(45,5,utf8_decode($anticipo_monto),1,0,'R');
		$pdf->Cell(40,5,utf8_decode($anticipo_total),1,0,'R');
		$pdf->ln(5);
		$pdf->Cell(30,5,"Cumplimiento",1);
		$pdf->Cell(30,5,utf8_decode($cumplimiento_contrato),1,0,'R');
		$pdf->Cell(10,5,$por2,1);
		$pdf->Cell(45,5,utf8_decode($cumplimiento_monto),1,0,'R');
		$pdf->Cell(40,5,utf8_decode($cumplimiento_total),1,0,'R');
		$pdf->ln(5);
		$pdf->Cell(30,5,"Vicios Ocultos",1);
		$pdf->Cell(30,5,utf8_decode($vicios_contrato),1,0,'R');
		$pdf->Cell(10,5,$por3,1);
		$pdf->Cell(45,5,utf8_decode($vicios_monto),1,0,'R');
		$pdf->Cell(40,5,utf8_decode($vicios_total),1,0,'R');
	}


	if($tipo=='fisica'){

			$pdf->ln(10);
			$pdf->SetFont('Arial','B',12);
			$pdf->Cell(40,10,'REQUISITOS PARA APERTURA DE EXPEDIENTE PERSONA FISICA:');
			$pdf->SetFont('Arial','',11);
			$pdf->ln(10);
			$pdf->Cell(40,10,utf8_decode('- INE o pasaporte vigente - digitalizado en PDF'));
			$pdf->ln(6);
			$pdf->Cell(40,10,'- CURP - digitalizado en PDF');
			$pdf->ln(6);
			$pdf->Cell(40,10,'- Comprobante de domicilio, no mayor a 3 meses (puede ser un edo. de cuenta bancario que coincida');
			$pdf->ln(6);
			$pdf->Cell(40,10,' con el RFC) - digitalizado en PDF Si lo tuviera, es importante lo entregue.');
			$pdf->ln(6);
			$pdf->Cell(40,10,utf8_decode('- Ultima declaración anual y acuse de recibo del SAT'));
			$pdf->ln(6);
			$pdf->Cell(40,10,utf8_decode('- Estados Financieros al cierre de del año inmediato anterior, firmados por el Representante Legal y el contador'));
			$pdf->ln(6);
			$pdf->Cell(40,10,utf8_decode('   (incluyendo Leyenda )*T'));
			$pdf->ln(6);
			$pdf->Cell(40,10,'- Cedula del Contador - digitalizado en PDF');
			$pdf->ln(6);
			$pdf->Cell(40,10, utf8_decode('- Constancia de situacioón Fiscal actualizada (CIF)'));
			$pdf->ln(6);
			$pdf->Cell(40,10, utf8_decode('- Currículum profesional con los trabajos más representativas y su monto, firmado, digitalizado en PDF'));
			$pdf->SetFont('Arial','B',12);
			$pdf->ln(10);
			$pdf->Cell(40,10, utf8_decode('Garantías (3 opciones) (debe presentar al menos 2):'));
			$pdf->SetFont('Arial','',11);
			$pdf->ln(6);
			$pdf->Cell(40,10,'1. Bien inmueble libre de gravamen');
			$pdf->ln(6);
			$pdf->Cell(40,10,'        - Escrituras - Copia');
			$pdf->ln(6);
			$pdf->Cell(40,10,'        - Libertad de Gravamen (en caso de tenerlo)');
			$pdf->ln(6);
			$pdf->Cell(40,10,'        - LINE o pasaporte vigente del Propietario - Copia');
			$pdf->ln(6);
			$pdf->Cell(40,10,'        - Comprobante de domicilio actual - Copia');
			$pdf->ln(6);
			$pdf->Cell(40,10, utf8_decode('        - Acta de matrimonio (si está bajo bienes mancomunados, debería firmar el conyugue) o en su caso'));
			$pdf->ln(6);
			$pdf->Cell(40,10, utf8_decode('        acta de divorcio.'));
			$pdf->ln(6);
			$pdf->Cell(40,10, utf8_decode('2. Deposíto en garantía (importe a confirmar por afianzadora) Opcional'));
			$pdf->ln(8);
			$pdf->Cell(40,10,'3. Estados financieros 2020 (no mayor a 3 meses, firmados por el Representante Legal y el contador');
			$pdf->ln(6);
			$pdf->Cell(40,10, utf8_decode('         (incluyendo Leyenda )*'));
			$pdf->ln(10);
			$pdf->Cell(40,10, utf8_decode('4. Obligado Solidario que cubra el punto 1 o 2 de las garantías.'));
			$pdf->SetFont('Arial','B',12);
			$pdf->ln(10);
			$pdf->Cell(40,10,'*Leyenda que deben contener los estados financieros:');
			$pdf->SetFont('Arial','',11);
			$pdf->ln(8);
			$pdf->Cell(40,10,'BAJO PROTESTA DE DECIR VERDAD MANIFIESTO QUE LAS CIFRAS CONTENIDAS EN ESTE ESTADO');
			$pdf->ln(6);
			$pdf->Cell(40,10,'FINANCIERO SON VERACES Y CONTIENEN TODA LA INFORMACION REFERENTE A LA');
			$pdf->ln(6);
			$pdf->Cell(40,10,'INFORMACION FINANCIERA Y/O LOS RESULTADOS DE LA EMPRESA Y AFIRMO QUE SOY');
			$pdf->ln(6);
			$pdf->Cell(40,10,'LEGALMENTE RESPONSABLE DE LA AUTENTICIDAD Y VERACIDAD DE LA MISMA ASUMIENDO');
			$pdf->ln(6);
			$pdf->Cell(40,10,'ASIMISMO, TODO TIPO DE RESPONSABILIDAD DERIVADA DE CUALQUIER DECLARACION EN');
			$pdf->ln(6);
			$pdf->Cell(40,10,'FALSO SOBRE LAS MISMAS.');
			$pdf->ln(18);
			$pdf->Cell(100,10,"																					FIRMA CONTADOR");
			$pdf->Cell(50,10,"FIRMA REP. LEGAL");
	}

	if($tipo=='moral'){

		$pdf->ln(10);
			$pdf->SetFont('Arial','B',12);
			$pdf->Cell(40,10,'REQUISITOS PARA APERTURA DE EXPEDIENTE PERSONA MORAL:');
			$pdf->SetFont('Arial','',11);
			$pdf->ln(10);
			$pdf->Cell(40,10,utf8_decode('- Acta Constitutiva completa con sus protocolizaciones (folio electrónico) - Digitalizado en PDF'));
			$pdf->ln(6);
			$pdf->Cell(40,10,'- Poder Representante legal - Digitalizado en PDF');
			$pdf->ln(6);
			$pdf->Cell(40,10,'- INE o pasaporte vigente del Representante Legal - Digitalizado en PDF');
			$pdf->ln(6);
			$pdf->Cell(40,10,'- CURP del Representante Legal - Digitalizado en PDF');
			$pdf->ln(6);
			$pdf->Cell(40,10,utf8_decode('- Comprobante de domicilio, no mayor a 3 meses (en caso de no estar a nombre de la empresa,'));
			$pdf->ln(6);
			$pdf->Cell(40,10,utf8_decode('puede ser un edo.de cuenta bancario que coincida con el RFC) - Digitalizado en PDF'));
			$pdf->ln(6);
			$pdf->Cell(40,10,utf8_decode('- Ultima declaracón anual y acuse de recibo del SAT'));
			$pdf->ln(6);
			$pdf->Cell(40,10,utf8_decode('- Estados Financieros al cierre de año anterior, firmados por el Representante Legal y el contador'));
			$pdf->ln(6);
			$pdf->Cell(40,10,'(incluyendo Leyenda )*');
			$pdf->ln(6);
			$pdf->Cell(40,10, utf8_decode('- Cedula del Contador - Digitalizado en PDF'));
			$pdf->ln(6);
			$pdf->Cell(40,10, utf8_decode('- Constancia de situacón Fiscal actualizada (CIF)'));
			$pdf->ln(6);
			$pdf->Cell(40,10, utf8_decode('- Currículum de la empresa con las obras más representativas y su monto, firmado por el Representante Legal. '));
			$pdf->ln(6);
			$pdf->Cell(40,10, utf8_decode('      Digitalizado en PDF'));
			$pdf->ln(6);
			$pdf->Cell(40,10, utf8_decode('- Datos de la empresa y/o contacto Teléfono, número de celular, correo electrónico y pagina web'));

			$pdf->SetFont('Arial','B',12);
			$pdf->ln(10);
			$pdf->Cell(40,10, utf8_decode('Garantías (debe presentar al menos 2):'));
			$pdf->SetFont('Arial','',11);
			$pdf->ln(6);
			$pdf->Cell(40,10,utf8_decode('1. Estados financieros parciales año vigente (no mayor a 3 meses, firmados por el Representante Legal'));
			$pdf->ln(6);
			$pdf->Cell(40,10,' y el contador (incluyendo Leyenda )*');
			$pdf->ln(6);
			$pdf->Cell(40,10, utf8_decode('2.  Bien inmueble libre de gravamen (actualizada) Digitalizado en PDF'));
			$pdf->ln(6);
			$pdf->Cell(40,10,'        - Escrituras completas - Digitalizado en PDF');
			$pdf->ln(6);
			$pdf->Cell(40,10,'        - Libertad de Gravamen actualizada');
			$pdf->ln(6);
			$pdf->Cell(40,10,'        - INE o pasaporte vigente del Propietario - Digitalizado en PDF');
			$pdf->ln(6);
			$pdf->Cell(40,10,'        - Comprobante de domicilio actual - Digitalizado en PDF');
			$pdf->ln(6);
			$pdf->Cell(40,10,'        - CURP Digitalizado en PDF');
			$pdf->ln(6);
			$pdf->Cell(40,10,'        - RFC en caso de tenerlo (puede solo mencionarlo)');
			$pdf->ln(6);
			$pdf->Cell(40,10,utf8_decode('       - Acta de matrimonio (si está bajo bienes mancomunados, deberá firmar el conyugue) o en su caso'));
			$pdf->ln(6);
			$pdf->Cell(40,10,utf8_decode('       acta de divorcio.'));

			$pdf->ln(6);
			$pdf->Cell(40,10,utf8_decode('        - Datos del Obligado Solidario
Teléfono, número de celular, correo electrónico.'));

			$pdf->ln(6);
			$pdf->Cell(40,10,utf8_decode('3. Obligado Solidario que cubra el punto 1 o 2 de las garantías.'));

			$pdf->SetFont('Arial','B',12);
			$pdf->ln(10);
			$pdf->Cell(40,10,'*Leyenda que deben contener los estados financieros:');
			$pdf->SetFont('Arial','',11);
			$pdf->ln(8);
			$pdf->Cell(40,10,'BAJO PROTESTA DE DECIR VERDAD MANIFIESTO QUE LAS CIFRAS CONTENIDAS EN ESTE ESTADO');
			$pdf->ln(6);
			$pdf->Cell(40,10,'FINANCIERO SON VERACES Y CONTIENEN TODA LA INFORMACION REFERENTE A LA');
			$pdf->ln(6);
			$pdf->Cell(40,10,'INFORMACION FINANCIERA Y/O LOS RESULTADOS DE LA EMPRESA Y AFIRMO QUE SOY');
			$pdf->ln(6);
			$pdf->Cell(40,10,'LEGALMENTE RESPONSABLE DE LA AUTENTICIDAD Y VERACIDAD DE LA MISMA ASUMIENDO');
			$pdf->ln(6);
			$pdf->Cell(40,10,'ASIMISMO, TODO TIPO DE RESPONSABILIDAD DERIVADA DE CUALQUIER DECLARACION EN');
			$pdf->ln(6);
			$pdf->Cell(40,10,'FALSO SOBRE LAS MISMAS.');
			$pdf->ln(18);
			$pdf->Cell(100,10,"																					FIRMA CONTADOR");
			$pdf->Cell(50,10,"FIRMA REP. LEGAL");

	}

	//modificar cliente a cotizado
	$this->setCotizadoFianzas($IDCL);
//	$IDCL=$IDCL.'.pdf';
//	$pdf->Output('D',$IDCL);
//	$this->proyecto100();
	
	$IDCL	= "/var/www/html/V3/assets/documentos/fianzas/cotExpres/".$IDCL.'.pdf';
	$pdf->Output('F',$IDCL);

	redirect('/actividades/ver/');
}

function guardar_afianzadora(){
	$txtsofimex=$_REQUEST['txtsofimex'];
	$txtliberty=$_REQUEST['txtliberty'];
	$txttokyo=$_REQUEST['txttokyo'];
	$txtberkley=$_REQUEST['txtberkley'];
	$sql="UPDATE cotizador_fianzas SET sofimex='$txtsofimex',liberty='$txtliberty',tokyo='$txttokyo', berkley='$txtberkley'";
	$rs=$this->db->query($sql);
	$this->proyecto100();
}
function guardar_buro(){
	$txtMoral=$_REQUEST['txtMoral'];
	$txtFisica=$_REQUEST['txtFisica'];
	$sql="UPDATE cotizador_fianzas SET buro_moral='$txtMoral',buro_fisica='$txtFisica'";
	$rs=$this->db->query($sql);	
	$this->proyecto100();
}

function guardar_prima_minima(){
	$txtprimaMinima=$_REQUEST['txtprimaMinima'];
	$sql="UPDATE cotizador_fianzas SET prima_minima='$txtprimaMinima'";
	$rs=$this->db->query($sql);	
	$this->proyecto100();
}

//----------------
//Dennis Castillo [2021-10-31]
function manageFirstProspectiveAgent(){ 
		
	$getProspectivePersons = $this->crmProyecto_Model->getProspectiveAgents($this->tank_auth->get_usermail());	
	$prospectiveAgents = array();

	foreach($getProspectivePersons as $d_pa){

		$asignado = $d_pa->asignado == "" ? "sin asignacion" : $d_pa->asignado;
		$prospectiveAgents[$asignado][] = $d_pa;
	}

	

	$data["prospectives"] = $prospectiveAgents;
	$data["accounts"] = array_map(function($arr){ return $arr->account; }, $this->crmProyecto_Model->getAssigned()); //$prospectiveAgents;
	$this->load->view("crmproyecto/manageProspectiveAgent", $data);
   }
//----------------
//Dennis Castillo [2021-10-31]
function getAgentData(){
		
	//$dataAgent = $this->crmProyecto_Model->get_prospecto_agente($_GET["id"]); //getGeneralDataAgent
	$dataAgent = $this->crmProyecto_Model->getGeneralDataAgent($_GET["id"]); //getGeneralDataAgent
	$agentProgress = $this->crmProyecto_Model->getProspectiveAgentProgress($_GET["id"]);
	$response = array();

	//if(empty($agentProgress) || $agentProgress->avance != "induccion"){

		$response[0]["title"] = "Datos generales";
		$response[0]["data"] = $dataAgent;
	//}
	
	if(!empty($agentProgress)){
		$response[1]["title"] = $agentProgress->avance == "induccion" ? "fase 2" : "fase 1";
		$response[1]["data"][] = array(
			"progress" => $agentProgress->avance,
			"idPerson" => $agentProgress->idPersona,
			"idProspective" => $agentProgress->idProspecto,
			"requirements" => $agentProgress->avance == "documento" ? $this->getAgentDocument($agentProgress->idPersona) : array(),
		);
	}
	
	echo json_encode($response);
}
//---------------
//Dennis Castillo [2021-10-31]
function getAgentDocument($id){

	$getLayout = $this->PersonaModelo->obtenerLayout($id);
	$return = array();

	foreach($getLayout as $docs){

		$return[] = array(
			"docName" => $docs->descripcionPD,
			"description" => $docs->textoPD,
			"required" => $docs->obligatorioPD,
			"attachment" => $this->PersonaModelo->getUniqueDocRequired($id, $docs->idPersonaDocumento, $docs->layoutPD),
		);
	}
	
	$userPhoto = "select fotoUser from user_miInfo where idPersona = ".$id." and fotoUser != 'noPhoto.jpg'";
	$queryP = $this->db->query($userPhoto);
	$photo = $queryP->num_rows() > 0 ? $queryP->result() : array();

	array_push($return, array(
		"docName" => "FOTO DE PERFIL",
		"description" => "Foto de perfil para la sesión del usuario",
		"required" => "SI",
		"attachment" => $photo,
	));

	return $return;
}
//---------------
//Dennis Castillo [2021-10-31]
function updateProspectiveData(){

	$data = json_decode($_POST["data_"]);
	$udpateArray = array();
	$id = "";
	
	foreach($data as $values){
		if($values->value != "null"){
			$udpateArray[$values->name] = $values->value;
		}
	}
	
	$updateProspective = $this->crmProyecto_Model->updateProspectiveData($udpateArray);

	$verificateProspectiveToUser = $this->crmProyecto_Model->getProspectiveAgentProgress($udpateArray["id"]);
	if(empty($verificateProspectiveToUser)){
		$this->crmProyecto_Model->insertaRegistros(array(
			"idProspecto" => $udpateArray["id"],
			"avance" => "alta"
		), "prospective_to_user");
	}

	
	echo json_encode(array("response" => 1));
}
//---------------
//Dennis Castillo [2021-10-31]
function sendNotification(){
	$person = $_POST["person"];
	$prospective = $_POST["prospective"];

	$getProspectiveData = $this->crmProyecto_Model->getGeneralDataAgent($prospective);
	$name = $this->PersonaModelo->obtenerNombrePersona($person);
	$data["name"] = $name;
	$data["person"] = $person;
	$mensaje = $this->load->view("crmproyecto/correo_notificacion", $data, true);

	//idCorreo, fechaCreacion, desde, para, copia, copiaOculta, asunto, mensaje, fileAdjunto, nameAdjunto, status, fechaEnvio, identificaModulo
	$sendMail = $this->crmProyecto_Model->insertaRegistros(array(
		"desde" => "Avisos de GAP<avisosgap@aserorescapital.com>", 
		"para" => $getProspectiveData[0]->correo, 
		"asunto" => "Inducción del agente",
		"mensaje" => $mensaje,
	), "envio_correos");

	echo json_encode(array("message" => "Se ha notificado al nuevo agente"));
}
//---------------
//Dennis Castillo [2021-10-31]
function preliminarView(){

	$this->load->view("crmproyecto/correo_notificacion");
}
//---------------
//Dennis Castillo [2021-10-31]
/*function getTemporalAccount($idPersona){

	$data["name"] = $this->PersonaModelo->obtenerNombrePersona($idPersona); //obtenerDatosUsers
	$data["account"] = $this->PersonaModelo->obtenerDatosUsers($idPersona);
	$this->load->view("crmproyecto/temporalAccount", $data);
}*/
//---------------
//Dennis Castillo [2021-10-31]
function funnelEstadoAgentes(){
	$estado=$_REQUEST['estado'];
	$mes=$_REQUEST['mes'];
	$coor=$_REQUEST['coor'];
	$year=date('Y');
	//$sql="SELECT * FROM prospectos_agentes WHERE status='$estado' AND MONTH(fecha)='$mes' AND YEAR(fecha)='$year'";
	//$rs=$this->db->query($sql)->result();
	$this->db->where("status", $estado);
	$this->db->where("MONTH(fecha)", $mes);
	$this->db->where("YEAR(fecha)", $year);

	if(!empty($coor)){
		$this->db->where("asignado", $coor);

	}
	
	$rs = $this->db->get("prospectos_agentes")->result();

	$tblAgentes="<table class='table table-responsive table-striped table-hover' style='width:100%;font-size:11px;'>";
	$tblAgentes.="<tr><td colspan='8'><h4>Listado de Prospectos Agentes</h4></td></tr>";
	$tblAgentes.="<tr><td colspan='8'><b>Estado: </b>".$estado."</td></tr>";
	$tblAgentes.="<tr style='background-color:#1e4c82;color:#fff;'><th>Prospecto</th><th>Medio</th><th>Status</th><th>CedulaS/N</th><th>Correo</th><th>Coordinación</th><th>Asignado</th><th>Comentarios</th></tr>";
	foreach($rs as $row){
		$tblAgentes.='<tr><td>'.$row->prospecto.'</td><td>'.$row->medio.'</td><td>'.$row->status.'</td><td>'.$row->tiene_cedula.'</td><td>'.$row->correo.'</td><td>'.$row->coordinacion.'</td><td>'.$row->asignado.'</td><td>'.$row->comentarios.'</td></tr>';
	}
	$tblAgentes.="</table>";
	echo $tblAgentes;
}
//---------------
//Dennis Castillo [2021-10-31]
function agentsForFunnel(){
	$this->load->model("funnelM", "funnel");
	$data["funnel"] = $this->funnel->prospectosAgentes($_GET["month"], $_GET["coor"]);
	$data["table"] = $this->getProgressProspectivesTable($data["funnel"]);
	
	echo json_encode($data);
}
//---------------
//Dennis Castillo [2021-10-31]
function getProgressProspectivesTable($array){

	$result = array();
	$result_ = array();
	foreach($array["EN_PROCESO"] as $type => $d_a){
		//foreach($d_a as $dd_a){

			$getProspectiveUser = $this->crmProyecto_Model->getProspectiveAgentProgress($d_a->id);
			array_push($result, array("id" => $d_a->id, "data" => $getProspectiveUser));

			if(!empty($getProspectiveUser)){

				if($getProspectiveUser->avance == "induccion" || $getProspectiveUser->avance == "documento"){

					$getPesonalData = $this->PersonaModelo->buscaPersonaPorCampo($getProspectiveUser->idPersona, "nombres,apellidoPaterno,apellidoMaterno,fecAltaSistemPersona");
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
	
	return $result_;
}
//--------------
//Dennis Castillo [2021-10-31]
function updateEarmarked(){
	//modificar_agentes_seleccionados_asignacion
	$data['prospectos']=$_POST['prospectos'];
	$data['asignado']=strtoupper($_POST['asignado']);
	$this->crmProyecto_Model->modificar_agentes_seleccionados_asignacion($data);

	echo json_encode(array("response" => 1));
}
//--------------
//Dennis Castillo [2021-11-01]
function getAssigned(){

	$assigned = $this->crmProyecto_Model->getAssigned();
	;

	return $assigned;
}
//--------------
function assignAccount(){

	$account = $_REQUEST["account"]; //$this->input->post("account");
	$message = "";
    $mensaje='ACTUALIZACION CON EXITO';
    $success=true;
	$validateExists = array_map(function($arr){
		return $arr->account;
	}, $this->getAssigned()) ; //$this->crmProyecto_Model->getAssigned();
	
         $insertar['idPersona']=$_POST['idPersona'];
		 $insertar['idPersonaPermiso']=$_POST['idPersonaPermiso'];
    		 

	if(!in_array(strtoupper($account), $validateExists))
	{
		$insertAccount = $this->crmProyecto_Model->insertaRegistros(array("account" => strtoupper($account)), "account_to_assign");
					$this->db->where('account',$_POST['account']);
		
			 $this->PersonaModelo->personapermisorelacion($insertar);
	} else{
		if(isset($_POST['delete']))
		{
			$this->db->where('account',$_POST['account']);
			$this->db->delete('account_to_assign');
            $insertar['delete']=1;
			 $this->PersonaModelo->personapermisorelacion($insertar);
		}
		else
		{
		$message = 'La cuenta ya se encuentra agregado al combo de "asignado a"';
		$mensaje = 'La cuenta ya se encuentra agregado al combo de "asignado a"';
		$success=false;
		}
    
	}

	$forCombo =  array_map(function($arr){
		return $arr->account;
	}, $this->getAssigned());

	echo json_encode(array("message" => $message, "accounts" => $forCombo,'mensaje' => $mensaje,'success' => $success));
}
//--------------
function deteccionNecesidadesCliente()
{
	$consulta='select * from clientes_actualiza where IDCliSikas='.$_GET['IDCli'];	
	$cliente=$this->db->query($consulta)->result();
	
	if(count($cliente)==0)
	{
		$clienteSicas=$this->ws_sicas->obtenerClientePorID($_GET['IDCli'])->TableInfo;
		$insertar['actualiza']='clienteWeb';
		$inseritar['IDCont']=0;
		$insertar['IDCliSikas']=$_GET['IDCli'];
		$insertar['fecha_nacimiento']='2022-01-01';
		$insertar['ApellidoP']=(string)$clienteSicas->ApellidoP;
		$insertar['ApellidoM']=(string)$clienteSicas->ApellidoM;
		$insertar['Nombre']=(string)$clienteSicas->Nombre;
		$insertar['Email1']=(string)$clienteSicas->Email1;
		$insertar['Telefono1']=(string)$clienteSicas->Telefono1;
		$insertar['Usuario']='DESCARGA@AGENTECAPITAL.COM';	
		$insertar['EstadoActual']='PAGADO';
		$insertar['IDContacto']=$clienteSicas->IDCont;
		$insertar['pagado']=1;
		$this->db->insert('clientes_actualiza',$insertar);
		$last=$this->db->insert_id();
				
	}
	else{$last=$cliente[0]->IDCli;}


$_GET['IDCL']=$last;
$this->deteccion_necesidades();
}
//Fin de modificacion
//-------------------------------------------------------
function notificacionParaActivarProspectosEnPausa()
{

   //ESTA FUNCION ES SOLO PARA EL ROBOT
    $consulta='select c.IDCli,c.Usuario,c.ApellidoP,c.ApellidoM,c.Nombre,u.idPersona 
from clientes_actualiza c left join users u on u.email=c.Usuario where c.fechaMensajePausa=cast(now() as date) and u.banned=0 and u.activated=1';
    $notificaciones=$this->db->query($consulta)->result();


    foreach ($notificaciones as $key => $value) 
    { 
        	
        $notificacion['tabla']='clientes_actualiza';          
        $notificacion['idTabla']=$value->IDCli;
        $notificacion['persona_id']=$value->idPersona;
        $notificacion['email']=  $value->Usuario;
        $notificacion['tipo_id']='email';
        $notificacion['referencia']='NOT_PROSPECTOPAUSA';
        $notificacion['referencia_id']='1001';
        $notificacion['check']=0;
        $notificacion['comentarioAdicional']='REVISAR LA ACTIVACION DEL PROSPECTO '.$value->ApellidoP.' '.$value->ApellidoM.' '.$value->Nombre;
        $notificacion['id']=-1;
        $notificacion['tipo']='OTRO';
        //$notificacion['controlador']='crmproyecto/eliminaComentarioAcitividad?folioActividad='.$folioActividad;        
        $ultimoId=$this->notificacionmodel->notificacion($notificacion);
        $actualizar['id']=$ultimoId;
        $actualizar['controlador']='crmproyecto/eliminarNotificacion?id='.$ultimoId;
        $this->notificacionmodel->actualizarNotificacion($actualizar);
		
    }	
}

//-------------------------------------------------------
function eliminarNotificacion()
{
	       
        $actualizar['id']=$_GET['id'];
        $actualizar['check']=2;
        $this->notificacionmodel->actualizarNotificacion($actualizar);
        $this->proyecto100();
}
//-------------------------------------------------------
function guardarCancelarPuntos()
{
 
 $respuesta['mensaje']='';
 $respuesta['usuario']=$_GET['usuario'];
 $respuesta['tipo'] =$_GET['tipo'];
 $respuesta['anio'] =$_GET['anio'];
 $respuesta['mes'] =$_GET['mes'];
 if($_GET['tipo']==1)
 {
   $this->db->where('Usuario',$_GET['usuario']);
   $this->db->where('anio',$_GET['anio']);
   $this->db->where('mes',$_GET['mes']);
   $this->db->where('cancelado','0');
   $update['cancelado']=1;
   $update['userCancela']=$this->tank_auth->get_usermail();
   $update['fechaCancelacion']=date('Y-m-d h:i:s ', time()); 
   $this->db->update('clientes_actualizapuntospagados',$update);
   $respuesta['mensaje']='LA CANCELACION SE REALIZO CORRECTAMENTE';
 }
 else
 {
 	$consulta='select (count(c.mes)) existeActivo from clientes_actualizapuntospagados c where c.cancelado=0 and c.anio='.$_GET['anio'].' and  c.mes='.$_GET['mes'].' and c.Usuario="'.$_GET['usuario'].'" ';
 	
   $existeActivo=$this->db->query($consulta)->result()[0]->existeActivo;
   
   if($existeActivo==0)
   {
    $insert['Usuario']=$_GET['usuario'];
    $insert['anio']=$_GET['anio'];
    $insert['mes']=$_GET['mes'];
    $insert['cancelado']=0;
    $insert['userInserta']=$this->tank_auth->get_usermail();
    $this->db->insert('clientes_actualizapuntospagados',$insert);
    $respuesta['mensaje']='PUNTOS OTORGADOS CON EXITO';
   }
   else{$respuesta['mensaje']='LOS PUNTOS YA FUERON OTORGADOS';}
 }
 echo json_encode($respuesta);
}


//---------------------------------------
function windows()
{
	$this->load->view("crmproyecto/windows");
}

//Miguel Jaime 13-02-2023

function filtroByBant(){
	$option=$_REQUEST['option'];
	$bant=$_REQUEST['bant'];
	$Usuario=$this->tank_auth->get_usermail();
	$dat=$this->capsysdre->ListaClientesBant($option,$bant,$Usuario)->result();
	$data['ListaClientes']=$dat;

	$diasSemana=$this->libreriav3->devolverDiasSemana();
            $fechaHoy=getdate();

            $j=0;
            $pestania=array(); //"";
            for($i=$fechaHoy['wday'];$i>=0;$i--){
            if($j==0){
             	$pestania[$j]='HOY';

         	}else{
         		$pestania[$j]=$diasSemana[$i];
         	}
             $j++;
            }
            $fec=$fechaHoy['year'].'-'.$fechaHoy['mon'].'-'.$fechaHoy['mday'];
            $hoyEs=new DateTime($fec);
            $countDiaSemana=count($pestania);
            $ct=0;
            foreach ($dat as  $value) {
            	$ct++;
            	$dia=new DateTime(date("Y-m-d", strtotime($value->fechaCreacionCA )));
            	$diaCreacion=date("Y-m-d", strtotime($value->fechaCreacionCA ));
            	$diaCreacion=explode('-', $diaCreacion);
            	$dif=$hoyEs->diff($dia);
              if($fechaHoy['year']!=$diaCreacion[0]){$value->pestania='ANTIGUOS';}
              else{$difMeses=$fechaHoy['mon']-$diaCreacion[1];
              	   if($difMeses>1){$value->pestania='ANTIGUOS';}
                   else{
                   	     if($difMeses==1){$value->pestania="MES_PASADO";}
                   	     else{
                   	           $difDia=$fechaHoy['mday']-$diaCreacion[2];

                   	           if($difDia<$countDiaSemana)
                   	           {
                   	           	$value->pestania=$pestania[$difDia];
                   	           }
                   	           else
                   	           {
                   	           	$value->pestania="ESTE_MES";
                   	           }

                   	         }
                   	   }
                  }
   	             
            }

            array_push($pestania,'ESTE MES');
            array_push($pestania,'MES PASADO');
            array_push($pestania,'ANTIGUOS');
            array_push($pestania,'TODOS');
      
	$data['pestania']='seguimientoProspecto';
	$data['totalResultados']=$ct;
	$data['fechaActual']=$this->libreriav3->convierteFecha($this->libreriav3->devolverFechaActual('/'));
    $data['primerDiaMes']=$this->libreriav3->convierteFecha($this->libreriav3->devolverPrimerDiaMesActual('/',''));
    //$data['muestraCalendario']=$this->citaRegistrada;
	$data['citas']=$this->fullcalendar_model->devuelveCitasActivasPorUsuarios();
	$data['casado']=$this->getDato('EdoCivil','CASADO');
	$data['casado_hijos']=$this->getDato('EdoCivil','CASADOCONHIJOS');
	$data['divorciado']=$this->getDato('EdoCivil','DIVORCIADOS');
	$data['divorciado_hijos']=$this->getDato('EdoCivil','DIVORCIADOSCONHIJOS');
	$data['soltero']=$this->getDato('EdoCivil','SOLTERO');
	$data['soltero_hijos']=$this->getDato('EdoCivil','SOLTEROCONHIJOS');
	$data['unionlibre']=$this->getDato('EdoCivil','UNIONLIBRE');
	$data['unionlibre_hijos']=$this->getDato('EdoCivil','UNIONLIBRECONHIJOS');
	$data['viudo']=$this->getDato('EdoCivil','VIUDO');
	$data['viudo_hijos']=$this->getDato('EdoCivil','VIUDOCONHIJOS');

	$data['MENOSDE18']=$this->getDato('RangodeEdad','MENOSDE18');
    $data['DE19A35']=$this->getDato('RangodeEdad','DE19A35');
    $data['DE36A50']=$this->getDato('RangodeEdad','DE36A50');
    $data['DE51A65']=$this->getDato('RangodeEdad','DE51A65');

    $data['amadecasa']=$this->getDato('Ocupacion','AMADECASA');
    $data['ejecutivo']=$this->getDato('Ocupacion','EJECUTIVO');
    $data['empleado']=$this->getDato('Ocupacion','EMPLEADO');
    $data['empresario']=$this->getDato('Ocupacion','EMPRESARIO');
    $data['gerente']=$this->getDato('Ocupacion','GERENTE');
    $data['negociopropio']=$this->getDato('Ocupacion','NEGOCIOPROPIO');
    $data['profesionistaindependiente']=$this->getDato('Ocupacion','PROFESIONISTAINDEPENDIENTE');
    $data['retirado']=$this->getDato('Ocupacion','RETIRADO');
    $data['otrospempleos']=$this->getDato('Ocupacion','OTROSEMPLEOS');
    $data['estudiante']=$this->getDato('Ocupacion','ESTUDIANTE');


    $data['AMIGODEESCUELA']=$this->getDato('FuenteProspecto','AMIGODEESCUELA');
    $data['VECINOS']=$this->getDato('FuenteProspecto','VECINOS');
    $data['AMIGODEFAMILIA']=$this->getDato('FuenteProspecto','AMIGODEFAMILIA');
    $data['CONOCIDOPASATIEMPOS']=$this->getDato('FuenteProspecto','CONOCIDOPASATIEMPOS');
    $data['FAMPROPIAOCONYUGUE']=$this->getDato('FuenteProspecto','FAMPROPIAOCONYUGUE');
    $data['CONOCIDOGRUPOSOCIAL']=$this->getDato('FuenteProspecto','CONOCIDOGRUPOSOCIAL');
    $data['CONOCIDOACTIVICOMUNIDAD']=$this->getDato('FuenteProspecto','CONOCIDOACTIVICOMUNIDAD');
    $data['CONOCIDOANTIGUOEMPLEO']=$this->getDato('FuenteProspecto','CONOCIDOANTIGUOEMPLEO');
    $data['PERSONASHACENEGOCIO']=$this->getDato('FuenteProspecto','PERSONASHACENEGOCIO');
    $data['CENTRODEINFLUENCIA']=$this->getDato('FuenteProspecto','CENTRODEINFLUENCIA');

    $data['HABILIDADEXCELENTE']=$this->getDato('HabilidadRef','EXCELENTE');
    $data['HABILIDADBUENA']=$this->getDato('HabilidadRef','BUENA');
    $data['HABILIDADREGULAR']=$this->getDato('HabilidadRef','REGULAR');

    $data['MENOSDE25000']=$this->getDato('IngresoMensual','MENOSDE$25000');
    $data['DE25000A60000']=$this->getDato('IngresoMensual','DE$25000A$60000');
    $data['DE6000A100000']=$this->getDato('IngresoMensual','DE$6000A$100000');
    $data['MASDE100000']=$this->getDato('IngresoMensual','MASDE$100000');

    $data['FACILMENTE']=$this->getDato('PosibiAcercamiento','FACILMENTE');
    $data['NOMUYDIFICIL']=$this->getDato('PosibiAcercamiento','NOMUYDIFICIL');
    $data['CONDIFICULTAD']=$this->getDato('PosibiAcercamiento','CONDIFICULTAD');

    $data['bant_auth1']=$this->getDato('bant_aut','1');
    $data['bant_auth2']=$this->getDato('bant_aut','2');
    $data['bant_auth3']=$this->getDato('bant_aut','3');

    $data['bant_need1']=$this->getDato('bant_need','1');
    $data['bant_need2']=$this->getDato('bant_need','2');
    $data['bant_need3']=$this->getDato('bant_need','3');

    $data['bant_timing_inmediato']=$this->getDato('bant_timing','Inmediato');
    $data['bant_timing_sin_urgencia']=$this->getDato('bant_timing','Sin urgencia');
    $data['bant_timing_largo_plazo']=$this->getDato('bant_timing','Largo Plazo');

	$this->load->view('crmproyecto/filtroBant',$data);
}
//-----------------------------------------------------------------------------------------------------------
	function reportes_ventas() { //Creado [Suemy][2024-06-26]
		if (!$this->tank_auth->is_logged_in()) {
            redirect('/auth/login/');
        } else {
            //Usuario
            $data['email'] = $this->tank_auth->get_usermail();
            $data['idPersona'] = $this->tank_auth->get_idPersona();
            //Nombres y Correos Empleados
            $data['puestos'] = $this->capitalhumano_model->devolverPuestos(1);
            $data['empleados'] = $this->PersonaModelo->devolverColaboradoresActivos(array("grupos" => 1));
            $clasificacion=$this->PersonaModelo->clasificacionUsuariosParaEnvios(null);
            $personaTipoEnvio=array();
			foreach ($clasificacion as $key => $value) {
				if($value['Name']!='Marketing proyecto 100'){
					foreach ($value['Data'] as  $valueData) {
						$valueData['Name']=$value['Name'];
						array_push($personaTipoEnvio, (object)$valueData);
					}
  				}
			}
            $data['agentes'] = $this->libreriav3->agrupaPersonasParaSelect($personaTipoEnvio,array("tipoPersona" => "Agente"));
    		//Encontrar Meses
    		$months = '';
    		$m = $this->libreriav3->devolverMeses();
    		foreach ($m as $key => $val) {
    		    $selected = "";
    		    if ($key == date('m')) { $selected = "selected"; }
    		    $months .= "<option value=".$key." ".$selected.">".$val."</option>";
    		}
    		$data['months'] = $months;
    		//Encontrar Años
    		$years = '';
    		$count = date('Y') - 2022;
    		$yearI = date('Y');
    		for ($i=0;$i<=$count;$i++) {
    		    $selected = "";
    		    if ($yearI == date('Y')) { $selected = "selected"; }
    		    $years .= '<option value="'.$yearI.'" '.$selected.'>'.$yearI.'</option>';
    		    $yearI--;
    		}
    		$data['years'] = $years;
			//Permisos
    		$data['permission_v'] = 0;
    		if ($data['email'] == "CCO@AGENTECAPITAL.COM" || $data['email'] == "DIRECTORGENERAL@AGENTECAPITAL.COM" || $data['email'] == "SISTEMAS@ASESORESCAPITAL.COM" || $data['email'] == "ASISTENTEDIRECCION@AGENTECAPITAL.COM"){ $data['permission_v'] = 1;
    		}
    		else if ($data['email'] == "COORDINADORINSTITUCIONAL@AGENTECAPITAL.COM" || $data['email'] == "COORDINADORCOMERCIAL@FIANZASCAPITAL.COM" || $data['email'] == "COORDINADOR@CAPCAPITAL.COM.MX" || $data['email'] == "COORDINADORCOMERCIAL@CAPCAPITAL.COM.MX") { $data['permission_v'] = 2; }
        	$this->load->view('crmproyecto/reportes',$data);
        }
	}

	function getReportSales() { //Creado [Suemy][2024-06-26]
		$email = $this->tank_auth->get_usermail();
		$month = $this->input->get('mn');
		$year = $this->input->get('yr');
		$user = $this->input->get('em');
		$report = $this->input->get('rp');
		$type = $this->input->get('tp');
		//Datos del mes
		$y_m = $year.'-'.$month;
		$date_I = date('Y-m-d',strtotime($y_m.'-01')); //Primer día del mes
		$weekToday = date("W") - date("W",strtotime($date_I)) + 1; //Semana actual
		$range = $this->superestrella_model->rangeMonth($date_I); //Rango de fechas del mes actual
        //Primera semana
        $week1 = array("dateI" => $date_I, "dateF" => date('Y-m-d',strtotime($y_m.'-07')));
        //Segunda semana
        $week2 = array("dateI" => date('Y-m-d',strtotime($y_m.'-08')), "dateF" => date('Y-m-d',strtotime($y_m.'-14'))
        );
        //Tercera semana
        $week3 = array("dateI" => date('Y-m-d',strtotime($y_m.'-15')), "dateF" => date('Y-m-d',strtotime($y_m.'-21'))
        );
        //Cuarta semana
        $week4 = array("dateI" => date('Y-m-d',strtotime($y_m.'-22')), "dateF" => $range['dateF']);
        //Operaciones
        $indicators = array("0" => "Número de Prospectos", "1" => "Cruces de Cartera", "2" => "Número de Referidos", "3" => "Número de Citas", "4" => "Número de Cotizaciones", "5" => "Número de Cierres", "6" => "Ratio de Conversión Cotizaciones/Cierres", "7" => "Ratio de Conversión Prospectos/Cierres", "8" => "Ingresos de Comisiones");
		$weeks = array("week1" => $week1, "week2" => $week2, "week3" => $week3, "week4" => $week4);
		$info = array("indicators" => $indicators, "email" => $user, "user" => $email, "report" => $report, "type" => $type);
        $data['result'] = $this->crmProyecto_Model->getInformationSoldMonthly($info,$weeks);
		//Tipo de datos
		if ($type == 1) {
			$data['data'] = array("month" => $month, "year" => $year, "user" => $user, "report" => $report, "type" => $type);
			$data['date'] = array(
				"month_range" => $range,
				"week" => $weekToday,
				"week1" => date('d/m/Y',strtotime($week1['dateI'])).' - '.date('d/m/Y',strtotime($week1['dateF'])),
				"week2" => date('d/m/Y',strtotime($week2['dateI'])).' - '.date('d/m/Y',strtotime($week2['dateF'])),
				"week3" => date('d/m/Y',strtotime($week3['dateI'])).' - '.date('d/m/Y',strtotime($week3['dateF'])),
				"week4" => date('d/m/Y',strtotime($week4['dateI'])).' - '.date('d/m/Y',strtotime($week4['dateF']))
			);
			echo json_encode($data);
		}
		else if ($type == 2) {
			//echo json_encode($data);
			return $data['result'];
		}
	}

	function exportReportSales() { //Creado [Suemy][2024-06-26]
    	$this->load->library('excel');
    	$m = $this->libreriav3->devolverMeses();
    	$cells = array("A","B","C","D","E","F","G","H","I","J","K","L","M","N","O","P","Q","R","S","T","U","V","W","X","Y","Z");
    	$row = 3;
    	$cellI = 1;
    	//Data
    	$data = $this->getReportSales();
    	//Styles
    	$styleHead = [
    	  	'font' => [
    	  	    'bold'  =>  true,
    	  	    'size'  =>  10,
    	  	    'name'  =>  'Franklin Gothic Book',
    	  	    'color' => array('rgb' => 'FFFFFF'),
    	  	],
    	  	'alignment' => [
    	  	    'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,
    	  	    'vertical' => PHPExcel_Style_Alignment::VERTICAL_CENTER
    	  	],
    	  	'fill' =>[
    	  	  'type'=>PHPExcel_Style_Fill::FILL_SOLID,
    	  	  'color' => ['rgb' => '0b5394']
    	  	]
    	];
    	$styleTitle1 = [
    	  	'font' => [
    	  	    'bold'  =>  true,
    	  	    'size'  =>  10,
    	  	    'name'  =>  'Franklin Gothic Book',
    	  	    'color' => array('rgb' => '3D3D3D'),
    	  	],
    	  	'alignment' => [
    	  	    'vertical' => PHPExcel_Style_Alignment::VERTICAL_CENTER
    	  	],
    	  	'fill' =>[
    	  	  'type'=>PHPExcel_Style_Fill::FILL_SOLID,
    	  	  'color' => ['rgb' => 'e5f1ff']
    	  	],
      		'borders' => [
      		    'top' => [
      		        'style' => PHPExcel_Style_Border::BORDER_THIN,
      		        'color' => ['rgb' => '7C7C7C']
      		    ],
      		    'right' => [
      		        'style' => PHPExcel_Style_Border::BORDER_THIN,
      		        'color' => ['rgb' => '7C7C7C']
      		    ]
      		],
    	];
    	$styleTitle2 = [
    	  	'font' => [
    	  	    'bold'  =>  true,
    	  	    'size'  =>  10,
    	  	    'name'  =>  'Franklin Gothic Book',
    	  	    'color' => array('rgb' => '3D3D3D'),
    	  	],
    	  	'alignment' => [
    	  	    'vertical' => PHPExcel_Style_Alignment::VERTICAL_CENTER
    	  	],
      		'borders' => [
      		    'top' => [
      		        'style' => PHPExcel_Style_Border::BORDER_THIN,
      		        'color' => ['rgb' => '7C7C7C']
      		    ],
      		    'right' => [
      		        'style' => PHPExcel_Style_Border::BORDER_THIN,
      		        'color' => ['rgb' => '7C7C7C']
      		    ]
      		],
    	  	'fill' =>[
    	  	  'type'=>PHPExcel_Style_Fill::FILL_SOLID,
    	  	  'color' => ['rgb' => 'ffe5e5']
    	  	]
    	];
    	$stylePair = [
      		'font' => [
      		    'bold'  =>  true,
      		    'size'  =>  10,
      		    'name'  =>  'Franklin Gothic Book',
      		    'color' => array('rgb' => '3D3D3D'),
      		],
      		'alignment' => [
      		    'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,
      		    'vertical' => PHPExcel_Style_Alignment::VERTICAL_CENTER
      		],
      		'borders' => [
      		    'inside' => [
      		        'style' => PHPExcel_Style_Border::BORDER_THIN,
      		        'color' => ['rgb' => 'd9d9d9']
      		    ],
      		    'left' => [
      		        'style' => PHPExcel_Style_Border::BORDER_THIN,
      		        'color' => ['rgb' => 'd9d9d9']
      		    ],
      		    'right' => [
      		        'style' => PHPExcel_Style_Border::BORDER_THIN,
      		        'color' => ['rgb' => 'd9d9d9']
      		    ]
      		],
      		'fill' =>[
      		  'type'=>PHPExcel_Style_Fill::FILL_SOLID,
      		  'color' => ['rgb' => 'fafafa']
      		]   
    	];
    	$styleOdd = [
      		'font' => [
      		    'bold'  =>  true,
      		    'size'  =>  10,
      		    'name'  =>  'Franklin Gothic Book',
      		    'color' => array('rgb' => '3D3D3D'),
      		],
      		'alignment' => [
      		    'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,
      		    'vertical' => PHPExcel_Style_Alignment::VERTICAL_CENTER
      		],
      		'borders' => [
      		    'inside' => [
      		        'style' => PHPExcel_Style_Border::BORDER_THIN,
      		        'color' => ['rgb' => 'd9d9d9']
      		    ],
      		    'left' => [
      		        'style' => PHPExcel_Style_Border::BORDER_THIN,
      		        'color' => ['rgb' => 'd9d9d9']
      		    ],
      		    'right' => [
      		        'style' => PHPExcel_Style_Border::BORDER_THIN,
      		        'color' => ['rgb' => 'd9d9d9']
      		    ]
      		],
      		'fill' =>[
      		  'type'=>PHPExcel_Style_Fill::FILL_SOLID,
      		  'color' => ['rgb' => 'f2f2f2']
      		]   
    	];
    	//Draw
    	$this->excel->setActiveSheetIndex(0);
    	$this->excel->getActiveSheet()->setTitle("Reporte Ventas");
    	$this->excel->getActiveSheet()->getColumnDimension('B')->setWidth(50);
    	$this->excel->getActiveSheet()->getColumnDimension('C')->setWidth(15);
    	$this->excel->getActiveSheet()->getColumnDimension('D')->setWidth(15);
    	$this->excel->getActiveSheet()->getColumnDimension('E')->setWidth(15);
    	$this->excel->getActiveSheet()->getColumnDimension('F')->setWidth(15);
    	$this->excel->getActiveSheet()->getStyle('C1:F1')->applyFromArray($styleHead);
    	$this->excel->getActiveSheet()->getStyle('A2:F2')->applyFromArray($styleHead);
    	$this->excel->getActiveSheet()->getStyle('A3:A11')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
    	$this->excel->getActiveSheet()->getStyle('B3:B11')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_LEFT);
    	$this->excel->getActiveSheet()->mergeCells('C1:F1')->setCellValue('C1','Objetivos Cuantitativos');
    	$this->excel->getActiveSheet()->setCellValue("A2","N°");
    	$this->excel->getActiveSheet()->setCellValue("B2","Indicadores y Ratios");
    	$this->excel->getActiveSheet()->setCellValue("C2","Semana 1");
    	$this->excel->getActiveSheet()->setCellValue("D2","Semana 2");
    	$this->excel->getActiveSheet()->setCellValue("E2","Semana 3");
    	$this->excel->getActiveSheet()->setCellValue("F2","Semana 4");
    	//Trigger
    	foreach ($data as $key => $val) {
    		$num = strval($key + 1);
    		$ind = strval($val['title']);
    		$week1 = strval($val['week1']);
    		$week2 = strval($val['week2']);
    		$week3 = strval($val['week3']);
    		$week4 = strval($val['week4']);
    		$num_row = strval('A'.$row);
    		$ind_row = strval('B'.$row);
    		$week1_row = strval('C'.$row);
    		$week2_row = strval('D'.$row);
    		$week3_row = strval('E'.$row);
    		$week4_row = strval('F'.$row);
    		$style_row = ($val['class'] == "indicator") ? $styleTitle1 : $styleTitle2;
    		$style_cell = (($num % 2) == 0) ? $stylePair : $styleOdd;
    		$this->excel->getActiveSheet()->setCellValue($num_row,$num)->getStyle($num_row)->applyFromArray($style_row);
    		$this->excel->getActiveSheet()->setCellValue($ind_row,$ind)->getStyle($ind_row)->applyFromArray($style_row);
    		$this->excel->getActiveSheet()->setCellValue($week1_row,$week1)->getStyle($week1_row)->applyFromArray($style_cell);
    		$this->excel->getActiveSheet()->setCellValue($week2_row,$week2)->getStyle($week2_row)->applyFromArray($style_cell);
    		$this->excel->getActiveSheet()->setCellValue($week3_row,$week3)->getStyle($week3_row)->applyFromArray($style_cell);
    		$this->excel->getActiveSheet()->setCellValue($week4_row,$week4)->getStyle($week4_row)->applyFromArray($style_cell);
    		$row++;
    	}

    	header("Content-Type: aplication/vnd.ms-excel ");
    	$name = "Reporte_Ventas ".date("Y-m-d H:i:s");
    	header("Content-Disposition: attachment; filename=\"$name.xls\"");
    	header("Cache-Control: max-age=0");

    	$writer = PHPExcel_IOFactory::CreateWriter($this->excel,"Excel5");
    	file_put_contents('depuracion.txt', ob_get_contents());
    	ob_end_clean();
    	$writer->save("php://output");
  	}
//-----------------------------------------------------------------------------------------------------------
}
