<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class cobranza extends CI_Controller
{
 var $datos;
 private $quitarSicas = array('<p>', '</p>', '<br />', ',');
 private $ponerSicas = array('', '', '\n\r', '');	
 function __construct()
  {
	parent::__construct();		
    $this->load->library('Ws_sicas');
    $this->load->library("webservice_sicas_soap");
    $this->load->library("WhatsSMS");
	  $this->load->helper('ckeditor');
    $this->load->library("libreriav3");
	  $this->load->model('email_model');
	  $this->load->model('catalogos_model');
	  $this->load->model('PersonaModelo');
	  $this->load->model('reportes_model');
	  $this->load->model('personamodelo');
    $this->load->model('permisooperativo');
    $this->load->model('puntos_model');
    $this->load->model("preguntamodel");
    $this->load->model("actividades_model");
    $this->load->model('notificacionmodel');
    if (!$this->tank_auth->is_logged_in()) {redirect('/auth/login/');} 
    $idusuario =  $this->tank_auth->get_idPersona();
        //if(!isset($_POST['AJAX'])){if (!$this->tank_auth->is_logged_in()) {redirect('/auth/login/');} }
    
  }
//-----------------------------------------------------------------------------------------------------------------------
 function index()
 { 			
   if (!$this->tank_auth->isloggedin()) {redirect('/auth/login/');} 
 	 $vendedor=$this->tank_auth->get_IDVend();
 	 $tipoUsuario='';
 	 $opcionFecha='';
   $this->datos['selecDiaCobAtra']=0;
   $this->datos['permisosCanales']=$this->permisooperativo->devolverCanalesCobranza();
   $this->datos['permisoAplicacionPago']=$this->permisooperativo->devolverPermisoAplicacionPago();
   $this->datos['permisoPestania']=$this->permisooperativo->devolverPermisoPestania();
   $this->datos['metodosPagos']=$this->reportes_model->obtenerMetodosPagos();
   $this->datos['cargaAutomatica']=1;
   $envioEmail="";
  
            $fechaHoyDefault=getdate();
        $fechaActualDefault=$fechaHoyDefault['year'].'/'.$fechaHoyDefault['mon'].'/'.$fechaHoyDefault['mday'];       
        $actualDefault = strtotime($fechaActualDefault);
   /*SE DESHABILITO PARA QUE NO CARGUE NADA POR DEFECTO*/
   #if(!isset($_POST['fechaInicial'])){$_POST['fechaInicial'] = $fechaHoyDefault['mday'].'/'.$fechaHoyDefault['mon'].'/'.$fechaHoyDefault['year'];       }
   if(!isset($_POST['fechaFinal'] )){$_POST['fechaFinal'] = date("Y/m/d", strtotime("5 day", $actualDefault));}
   if(!isset($_POST['opcionFecha'])){ $_POST['opcionFecha']="FHasta";}
   if(!isset($_POST['opcion']))
   {
    if(count($this->datos['permisosCanales'])>0){$_POST['opcion']=$this->datos['permisosCanales'][0]->value;}
   }
   
 	 if(isset($_POST['opcion'])){$tipoUsuario=$_POST['opcion'];$envioEmail=$_POST['opcion'];}   
 	 else
 	 {
 	   switch ($this->tank_auth->get_usermail()) 
 	   {
 	 	  case 'SISTEMAS@ASESORESCAPITAL.COM': $tipoUsuario='merida';break;
 	 	  default:$tipoUsuario=(int)$this->tank_auth->get_IDVend();break;
 	   }
 	  }
 	  if(isset($_POST['opcionFecha'])){$opcionFecha=$_POST['opcionFecha'];}
 	  else{$opcionFecha="FHasta";}
    if(is_int($tipoUsuario)){$condicion=$tipoUsuario;}
     else
     {     
       $array['categoria']=$tipoUsuario;
       $agentes=$this->PersonaModelo->personasVendedoresPorCategoria($array);
       $condicion='';
       $cantidad=count($agentes);
       $cantidad--;
      // foreach ($agentes as $key=>$value) { ($cantidad==$key) ? $condicion.=$value->IDVend : $condicion.=$value->IDVend.'|';}        
     }

     $fechaHoy=getdate();
      $this->datos['cobranzaPendiente']=array();$this->datos['cobranzaAtrasada']=array();
      
      if(isset($_POST['fechaInicial'])) 
      {
        $fechaActual=$fechaHoy['year'].'/'.$fechaHoy['mon'].'/'.$fechaHoy['mday'];       
       
       $fi=$this->libreriav3->convierteFecha($_POST['fechaInicial']);
       $ff=$this->libreriav3->convierteFecha($_POST['fechaFinal']);
        $arrayCobranza['fechaInicial']=$fi;//$_POST['fechaInicial'];
        $arrayCobranza['fechaFinal']=$ff;//$_POST['fechaFinal'];
        $arrayCobranza['vendedor']=$condicion;
        $arrayCobranza['tipoReporte']=$this->input->post('opcion', TRUE);
        $arrayCobranza['tipoFecha']=$opcionFecha; 	      
        $this->datos['cobranzaPendiente']=array();

 	      $this->datos['cobranzaPendiente']=$this->ws_sicas->cobranzareporte($arrayCobranza);
          $solCobro=array();
        $solCobro=$this->reportes_model->obtenerSolicitudCobroActivos();
        $solCobroID=array();
        $solCobroIDString="";
        if(count($solCobro)>0)
        {
         foreach ($solCobro as $value) {$solCobroIDString.=$value->idRecibo.'|';}
         foreach ($this->datos['cobranzaPendiente']->TableInfo as $value) {$solCobroIDString.=$value->IDRecibo.'|';}
        $this->datos['cobranzaPendiente']=$this->ws_sicas->cobranzaReportePorRecibo($solCobroIDString.'|');
        }
            
       $cant=0;
       $cant=count($this->datos['cobranzaPendiente']->TableInfo);       
       for($i=0;$i<$cant;$i++)
       {
        $val=$this->reportes_model->obtenerSolicitudCobroPorIdDocto($this->datos['cobranzaPendiente']->TableInfo[$i]->IDDocto);  
        $comprueba=$this->reportes_model->comprobarSoicitudCobro($this->datos['cobranzaPendiente']->TableInfo[$i]->IDDocto);   
        
       $filtroConsulta=" and idRecibo=".$this->datos['cobranzaPendiente']->TableInfo[$i]->IDRecibo." and idSerie='".$this->datos['cobranzaPendiente']->TableInfo[$i]->Serie."' and email='".$this->tank_auth->get_usermail()."'";

       $historialEnvio=$this->db->query("select 'envio_correos' as tipoEnvio,(count(idCobranzaHistorial)) as total from cobranzahistorial where  tipoEnvioCH='envio_correos '".$filtroConsulta." union select 'envio_whats' as tipoEnvio,(count(idCobranzaHistorial) ) as total from cobranzahistorial where  tipoEnvioCH='envio_whats' ".$filtroConsulta." union select 'envio_sms' as tipoEnvio,(count(idCobranzaHistorial)) as total from cobranzahistorial where  tipoEnvioCH='envio_sms' ".$filtroConsulta)->result();
  
        $this->datos['cobranzaPendiente']->TableInfo[$i]->solicitudCobranza;
        $this->datos['cobranzaPendiente']->TableInfo[$i]->cobranzaConSolicitud=$comprueba[0]->bandera;
        $this->datos['cobranzaPendiente']->TableInfo[$i]->cobranzaSinSolicitud=$comprueba[1]->bandera;
        $this->datos['cobranzaPendiente']->TableInfo[$i]->cobranzaComenatarios=$comprueba[2]->bandera;
        $this->datos['cobranzaPendiente']->TableInfo[$i]->estatusConSolicitud=$comprueba[0]->estado;
        $this->datos['cobranzaPendiente']->TableInfo[$i]->tipoSolicitud=$comprueba[0]->tipoSolicitud;
        $this->datos['cobranzaPendiente']->TableInfo[$i]->historialCorreos=$historialEnvio[0]->total;
        $this->datos['cobranzaPendiente']->TableInfo[$i]->historialWhats=$historialEnvio[1]->total;     
        $this->datos['cobranzaPendiente']->TableInfo[$i]->historialSMS=$historialEnvio[2]->total;
        $contactoCli='select * from clientelealtadtipocontactodocumento c where c.documento="'.$this->datos['cobranzaPendiente']->TableInfo[$i]->Documento.'"';
        $contactoCliDatos=$this->db->query($contactoCli)->result();
  
        foreach ($contactoCliDatos as $key => $valueCD) 
        {
          if($valueCD->tipoContacto==3)
          {
             $this->datos['cobranzaPendiente']->TableInfo[$i]->EMail1=$valueCD->contacto;
          }
          else
          {
            $this->datos['cobranzaPendiente']->TableInfo[$i]->Telefono1=$valueCD->contacto;
          }
        }
       } 
       
       /* if(isset($_POST['selecDiaCobAtra']))
        {
          if($_POST['selecDiaCobAtra']>0)
         {
            $fechaActual=$fechaHoy['year'].'/'.$fechaHoy['mon'].'/'.$fechaHoy['mday'];       
         $actual = strtotime($fechaActual);
        $diasCA='-'.$_POST['selecDiaCobAtra'].' day';         
        $fecIniCA = date("d/m/Y", strtotime($diasCA, $actual));        
        $fecFinCA = date("d/m/Y", strtotime("-1 day", $actual));
        $fecIniCP = $fechaHoy['mday'].'/'.$fechaHoy['mon'].'/'.$fechaHoy['year'];       
        $fecFinCP = date("d/m/Y", strtotime("1 month", $actual)); 
 	         $arrayCobranza['fechaFinal']=$fecFinCA;
           $arrayCobranza['fechaInicial']=$fecIniCA;
           $arrayCobranza['vendedor']=$condicion;                
           $arrayCobranza['tipoFecha']=$opcionFecha;                
           $this->datos['cobranzaAtrasada']=$this->ws_sicas->cobranzareporte($arrayCobranza); 
           $this->datos['selecDiaCobAtra']=$_POST['selecDiaCobAtra'];       
         }
     
        }   */     
        $this->datos['fechaInicial']=$_POST['fechaInicial'];
        $this->datos['fechaFinal']=$_POST['fechaFinal'];
        $this->datos['cargaAutomatica']=0;      
      }
      else
      { 
        $fechaActual=$fechaHoy['year'].'/'.$fechaHoy['mon'].'/'.$fechaHoy['mday'];       
        $actual = strtotime($fechaActual);
        $fecIniCP = date("Y-m-d", strtotime("-1 day", $actual));//$fechaHoy['mday'].'/'.$fechaHoy['mon'].'/'.$fechaHoy['year'];       
        $fecFinCP = date("Y-m-d", strtotime("7 day", $actual));       
        $this->datos['fechaInicial']=$fecIniCP;
        $this->datos['fechaFinal']=$fecFinCP;
      }
 	  	 	 
 	 $array['categoria']='merida'; 
 	 $this->datos['opcion']=$tipoUsuario;      
 	 $this->datos['opcionFecha']=$opcionFecha;   
 	 $this->datos['bancos']=$this->catalogos_model->bancos(null);
   //$bancosAdicionales=new stdClass;
   $bancosAdicionales2=new stdClass;
   //$bancosAdicionales->descripcionBancos='OPCIONES DE PORTAL';
   //array_push($this->datos['bancos'], $bancosAdicionales);

    $bancosAdicionales2->descripcionBancos='COMERCIAL BANK';
   array_push($this->datos['bancos'],$bancosAdicionales2);


   $this->datos['tipoDocumentos']=$this->catalogos_model->catalog_tipoimg(null);   
   $this->datos['idVendedor']=$this->tank_auth->get_IDVend();   
   $this->datos['saldo']=$this->whatssms->obtenerSaldo();
   $this->datos['envioEmail']=$envioEmail; 
   $this->datos['vendedores'] =$this->personamodelo->obtenerVendActivos();            
   $actual = strtotime($fechaActual);                
   $fecFinRenovacion = date("d/m/Y", strtotime("30 day", $actual));  
   $this->datos['fechaActual']=$fechaHoy['year'].'-'.$fechaHoy['mon'].'-'.$fechaHoy['mday'];;     
   $this->datos['fechaFinalRenovacion']=$fecFinRenovacion;   
   $permiso=$this->PersonaModelo->permisosPersona('cancelarCobranza');
   $this->datos['permisoCancelarCobranza']=$permiso['valor'];
   $this->datos['meses']=$this->libreriav3->devolverMeses();
   $this->datos['anioActual']=date('Y');
   $this->datos['tipoContacto']=$this->db->query('select * from catalog_tipocontacto where idTipoContacto in (1,2,3) ')->result();

   //Modificacion MJ 30/11/20
   
     //$this->datos['semaforo_cobranza']=$this->getAllCobranzaPendiente();
     
	 $this->load->view('reportes/cobranza',$this->datos);	

 }

//----------------------------------------------------------------------
function renovacion()
{


   if (!$this->tank_auth->is_logged_in()) {redirect('/auth/login/');} 
   $vendedor=$this->tank_auth->get_IDVend();
   $tipoUsuario='';
   $opcionFecha='';
   $this->datos['selecDiaCobAtra']=0;
   $this->datos['permisosCanales']=$this->permisooperativo->devolverCanalesRenovacion();
   $this->datos['permisosParaRenovar']=$this->permisooperativo->devolverPermisoPorLlaveAndValue('ventanaRenovacion');
   if((int)$this->tank_auth->get_IDVend()==0){$this->datos['permisosParaRenovar']=1;}
   else{$this->datos['permisosParaRenovar']=0;}
   $this->datos['permisoAplicacionPago']=$this->permisooperativo->devolverPermisoAplicacionPago();
   $this->datos['cargaAutomatica']=1;
   $envioEmail="";
   if(!isset($_POST['opcion']))
   {
   if(count($this->datos['permisosCanales'])>0)
    {
      
      $_POST['opcion']=$this->datos['permisosCanales'][0]->value;
        $fechaHoyDefault=getdate();
        $fechaActualDefault=$fechaHoyDefault['year'].'/'.$fechaHoyDefault['mon'].'/'.$fechaHoyDefault['mday'];       
        $actualDefault = strtotime($fechaActualDefault);
        $_POST['fechaInicial'] = $fechaHoyDefault['mday'].'/'.$fechaHoyDefault['mon'].'/'.$fechaHoyDefault['year'];       
        $_POST['fechaFinal'] = date("d/m/Y", strtotime("15 day", $actualDefault));
        $_POST['opcionFecha']="FHasta";       
        
        
    }
   }

   if(isset($_POST['opcion'])){$tipoUsuario=$_POST['opcion'];$envioEmail=$_POST['opcion'];}   
   else
   {
     switch ($this->tank_auth->get_usermail()) 
     {
      case 'SISTEMAS@ASESORESCAPITAL.COM': $tipoUsuario='merida';break;
      default:$tipoUsuario=(int)$this->tank_auth->get_IDVend();break;
     }
    }
    if(isset($_POST['opcionFecha'])){$opcionFecha=$_POST['opcionFecha'];}
    else{$opcionFecha="FHasta";}
    if(is_int($tipoUsuario)){$condicion=$tipoUsuario;}
     else
     {     
       $array['categoria']=$tipoUsuario;
       $agentes=$this->PersonaModelo->personasVendedoresPorCategoria($array);
       $condicion='';
       $cantidad=count($agentes);
       $cantidad--;
      // foreach ($agentes as $key=>$value) { ($cantidad==$key) ? $condicion.=$value->IDVend : $condicion.=$value->IDVend.'|';}        
     }

     $fechaHoy=getdate();
      $this->datos['cobranzaPendiente']=array();$this->datos['cobranzaAtrasada']=array();
      if(isset($_POST['fechaInicial'])) 
      {$fechaActual=$fechaHoy['year'].'/'.$fechaHoy['mon'].'/'.$fechaHoy['mday'];       
       
        $arrayCobranza['fechaInicial']=$_POST['fechaInicial'];
        $arrayCobranza['fechaFinal']=$_POST['fechaFinal'];
        $arrayCobranza['vendedor']=$condicion;
        $arrayCobranza['tipoReporte']=$this->input->post('opcion', TRUE);
        $arrayCobranza['tipoFecha']=$opcionFecha;         
         
        $this->datos['fechaInicial']=$_POST['fechaInicial'];
        $this->datos['fechaFinal']=$_POST['fechaFinal'];
        $this->datos['cargaAutomatica']=0;      
      }
      else
      { 
        $fechaActual=$fechaHoy['year'].'/'.$fechaHoy['mon'].'/'.$fechaHoy['mday'];       
        $actual = strtotime($fechaActual);
        $fecIniCP = $fechaHoy['mday'].'/'.$fechaHoy['mon'].'/'.$fechaHoy['year'];       
        $fecFinCP = date("d/m/Y", strtotime("7 day", $actual));       
        $this->datos['fechaInicial']=$fecIniCP;
        $this->datos['fechaFinal']=$fecFinCP;
      }
         
   $array['categoria']='merida'; 
   $this->datos['opcion']=$tipoUsuario;      
   $this->datos['opcionFecha']=$opcionFecha;   
   $this->datos['bancos']=$this->catalogos_model->bancos(null);   
   $this->datos['tipoDocumentos']=$this->catalogos_model->catalog_tipoimg(null);   
   $this->datos['idVendedor']=$this->tank_auth->get_IDVend();   
   $this->datos['saldo']=$this->whatssms->obtenerSaldo();
   $this->datos['envioEmail']=$envioEmail; 
   $this->datos['vendedores'] =$this->personamodelo->obtenerVendActivos();            
   $actual = strtotime($fechaActual);                
   $fecFinRenovacion = date("d/m/Y", strtotime("30 day", $actual));  
   $this->datos['fechaActual']=$fechaHoy['year'].'-'.$fechaHoy['mon'].'-'.$fechaHoy['mday'];;     
   $this->datos['fechaFinalRenovacion']=$fecFinRenovacion;   
   $permiso=$this->PersonaModelo->permisosPersona('cancelarCobranza');
   $this->datos['permisoCancelarCobranza']=$permiso['valor'];
   $this->load->view('reportes/renovacionOperacion',$this->datos); 



}
//----------------------------------------------------------------------
	function aplicarPago()
	{
		//296721
		$respuesta = array();
		$recibo = $this->ws_sicas->buscarReciboPorID($_POST['IDRecibo']);

		if ($_POST['Fpago'] != '') {
		  $_POST['Fpago'] = $this->libreriav3->convierteFecha($_POST['Fpago']);
		}
		if ($_POST['FDocto'] != '') {
		  $_POST['FDocto'] = $this->libreriav3->convierteFecha($_POST['FDocto']);
		}

		if (isset($recibo->TableInfo)) {
		  if ((int)$recibo->TableInfo->Status == 0) {
			$pago['IDPagoRec'] = -1;
			$pago['IDRecibo'] = $_POST['IDRecibo'];
			$pago['FPago'] = $_POST['Fpago'];
			$pago['FolioCh'] = $_POST['FolioCh'];
			$pago['TipoDocto'] = $_POST['TipoDocto'];
			$pago['Banco'] = $_POST['Banco'];
			$pago['FolioDocto'] = $_POST['FolioDocto'];
			$pago['FDocto'] = $_POST['FDocto'];
			$pago['TPago'] = $_POST['TPago'];
			$pago['ImporteP'] = $_POST['ImporteP'];
			$pago['IDMonPago'] = $_POST['IDMonPago'];
			$pago['TCPago'] = $_POST['TCPago'];
			$pago['Importe'] = $_POST['Importe'];
			$pago['TCDocto'] = $_POST['TCDocto'];
			$pago['IDTarjeta'] = -1;
			$respuesta = $this->ws_sicas->aplicarPagoRecibo($pago); //TODO: no olvidar descomentar al finalizar el desarrollo
			//$respuesta['Sucess']=true;//TODO: no olvidar comentar al finalizar el desarrollo
			$insert['IDRecibo'] = $_POST['IDRecibo'];
			$insert['idcli'] = $_POST['idcli'];
			$insert['periodo'] = $_POST['periodo'];
			$insert['documento'] = $_POST['documento'];
			$insert['serie'] = $_POST['serie'];
			$insert['nombre'] = $_POST['nombre'];
			$insert['idPersonaAplica'] = $this->tank_auth->get_idPersona();
			$insert['metodoPago'] = $_POST['MetodoPago'];

			if (isset($respuesta['Sucess'])) {
			  $this->db->insert('cobranza_aplicada', $insert);
			  $respuesta['idRecibo'] = $_POST['IDRecibo'];
			  $respuesta['mensaje'] = 'El recibo se pago con exito';
			  $respuesta['bandera'] = '1';
			} else {
			  $respuesta['mensaje'] = 'Error al momento de pagar el recibo reportar a sistemas';
			  $respuesta['bandera'] = '0';
			}
		  } else {
			$respuesta['mensaje'] = 'El recibo ya esta aplicado';
			$respuesta['bandera'] = '1';
		  }
		}

		echo json_encode($respuesta);
	}
//----------------------------------------------------------------------------------------------------------------------
function mostrarHistorial()
{
    $historial['idRecibo']=$_POST['IDRecibo'];        
    $data_result['historialCobranza']=$this->reportes_model->cobranzaHistorial($historial);
    echo json_encode($data_result);
}

///----------------------------------------------------------
function traerDigitalVigente()
{
  $informacion=array();
  $datosDocumento=$this->ws_sicas->buscarDocumentoPorIDSicas($_POST["IDDocto"]);

 
  $data_result=array();
          $idDocto = $_POST["IDDocto"]; 
        $data = array("IDDocto" => $idDocto);
        $informacion['documentosPoliza']= $this->ws_sicas->GetCDDigital($data);
        $informacion['IDDocto']=$_POST["IDDocto"];
        $informacion['documento']=(string)$datosDocumento->TableInfo->Documento;
        $informacion['email']=(string)$datosDocumento->TableInfo->EMail1;
        $informacion['IDCli']=(string)$datosDocumento->TableInfo->IDCli;

      //$data_result = $this->ws_sicas->GetCDDigital($data);  
        //echo json_encode($data_result);
         
         
        echo json_encode($informacion);
}

//-----------------------------------------------------------
  function traeArchivos(){
 try{ 
      // 
		if (!$this->tank_auth->isloggedin()) {$data_result['cesionExpiro']=1;} 
    else{        
            
            /*$_POST['IDRecibo']=406891;
            $_POST['IDDocto']=162246;*/
          if(isset($_POST['buscarDocumento']))
          {
           $idDocto = $_POST['IDDocto']; 
           $data = array("IDDocto" => $idDocto,"ReadRecursive"=>0);
           $data_result = $this->ws_sicas->GetCDDigital($data);  
          }
          else
          {
        $idDocto = $_POST['IDRecibo'];  
        $data = array("IDDocto" => $idDocto,"ReadRecursive"=>0,'RECEIPT'=>0);
        $data_result = $this->ws_sicas->GetCDDigital($data);  
          }

                
        $data_result['rowIndex']=$_POST['rowIndex'];
        $data_result['inner']=$_POST['inner'];
        $data_result['innerText']=$_POST['inner'];
        $data_result['serie']=$_POST['serie'];
        $data_result['IDRecibo']=$_POST['IDRecibo'];
        $data_result['periodo']=$_POST['periodo'];
        $data_result['endoso']=$_POST['endoso'];
        $historial['idRecibo']=$_POST['IDRecibo'];
        $historial['count']=1;
        $data_result['historialCobranza']=$this->reportes_model->cobranzaHistorial($historial);
        $data_result['preferenciaComunicacion']=' ';
        $data_result['horarioComunicacion']=' ';
        $data_result['diaComunicacion']=' ';
        $cliente=$this->puntos_model->nombreCliente($_POST['idcli']);
        if((count($cliente))>0)
        {           
         $data_result['preferenciaComunicacion']=$cliente[0]->preferenciaComunicacion;
         $data_result['horarioComunicacion']=$cliente[0]->horarioComunicacion;
         $data_result['diaComunicacion']=$cliente[0]->diaComunicacion;
        }
        if (!isset($data_result['children'])) {
          /* $data_result['children'] = array(); */
          
        }
     }        
    echo json_encode($data_result);
    }
    catch(Exception $e){}

   }

//---------------------------------------------------------------------------------------------------------------------
function buscarDocumento()
{

  $idDocto = $_POST["IDDocto"];	  
  $documento=$this->ws_sicas->obtenerDocumentoPorId($idDocto);
  $documento=$documento->TableInfo;
  $cantPagos=explode('/',$_POST['serie']);
  $cantPagos=$cantPagos[1];
  $cantPagos=(int)$cantPagos;
  $respuesta['monedaDelDocto']=(string)$documento->Moneda;
  $respuesta['PrimaNeta']=(string)$documento->STotal;
  $respuesta['Pago']=(float)$documento->STotal/$cantPagos;
  $respuesta['TCPago']=(string)$documento->TCPago;
  $respuesta['FDesde']=(string)$documento->FDesde;
  $respuesta['FHasta']=(string)$documento->FHasta;
    $respuesta['FCaptura']=(string)$documento->FCaptura;
 $respuesta['FEmision']=(string)$documento->FEmision;
 
  echo json_encode($respuesta);
}
//------------------------------------------
function subirDocumentosDeCobranza()
{
 $this->load->model('manejodocumento_modelo');
 $respuesta['mensaje']='Archivos añadidos con exito';
 $tiempoEspera=0;
 $traerArchivo=0;
     $comentario['idCobranzaComentarios']=-1;
      $comentario['idRecibo']=(int)$_POST['inputRecibo'];
      $comentario['idDocto']=(int)$_POST['inputIdDocto'];
      $comentario['idSerie']=(string)$_POST['inputSerie'];
      $comentario['IDCli']=(int)$_POST['inputIdCliente'];
      $comentario['endoso']=(string)$_POST['inputEndoso'];       
foreach ($_FILES as $key => $value) 
{
  $tiempoEspera=$tiempoEspera+5;
   if($value['name']!=''){
  switch ($key) {
    case 3: $_FILES['DocumentoFiles']=$value;$this->subirComprobante();
    break;
    case 19:$_FILES['DocumentoFiles']=$value;$this->subirRecibo();
    break;
    default:
           $archivo=array();
           $extension=explode(".",$value['name'] );
           $largo=count($extension);
           $ext=$extension[$largo-1];
        $idCliente    = $_POST['inputIdCliente'];    
        $nombre=$this->db->query('select nombre from catalog_tipoImg c where c.idTipoImg='.$key)->result()[0]->nombre;
        $nameFileSicas  = str_replace(' ','_',$nombre);
        //$nameFileSicas  .= "-".strtoupper($this->input->post('descripcionArchivo', TRUE));
        $nameFileSicas  .= "-".date('YmdHi');
        //$nameFileSicas  .= ".".strrev(strstr(strrev($_FILES['DocumentoFiles']['name']), '.', true));
                //$destination  = '/var/www/html/capsys.com.mx/public_html/V3/assets/img/tmp/'.$nameFileSicas;
                //$destination  = 'C:\wamp64\www\Capsys\www\V3\assets\img\tmp\\'.$nameFileSicas;
	$destination	= RUTA_ASSETS.'img/tmp/'.$nameFileSicas.'.'.$ext; 
                move_uploaded_file($value['tmp_name'], $destination);

         if($key==5 || $key==7 || $key==11 || $key==12 || $key==21 || $key==22)
         {         
         $archivo['TypeDestinoCDigital'] = 'CLIENT';
         $archivo['IDValuePK']= $idCliente;                      
         $archivo['FolderDestino']= "";     
         
         }
         else
         {
          $archivo['TypeDestinoCDigital'] = 'DOCUMENT';
          $archivo['IDValuePK']= $_POST['inputIdDocto'];                      
          $archivo['FolderDestino']= "";     
          $traerArchivo=1;
         }
      $archivo['wsAction'] = "PUTFiles";
      $archivo['ListFilesURL']= base_url().'assets/img/tmp/'.$nameFileSicas.'.'.$ext;   
      //$archivo['ListFilesURL']='https://capsys.com.mx/V3/assets/img/tmp/PRUEBASISTEMAS.pdf';
      
      $respuesta=$this->ws_sicas->subirArchivoSicas($archivo);
 $comentario['cobranzaComentarios']='Se ha anexado el siguiente documento '.$nameFileSicas;
   $this->reportes_model->cobranzacomentarios($comentario);
      sleep(5);      
            
    break;
  }
 }
}
if($traerArchivo==1)
{
          
        $data = array("IDDocto" => $_POST['inputIdDocto']);
        $respuesta['children'] = $this->ws_sicas->GetCDDigital($data)['children']; 
}
$respuesta['endoso']=$_POST['inputEndoso'];
$respuesta['periodo']=$_POST['inputPeriodo'];
$respuesta['rowIndex']=$_POST['inputIndexCobranza'];
$respuesta['IDRecibo']=$_POST['inputRecibo'];
echo json_encode($respuesta);  
}
//-----------------------------------
function subirDocumentosVigente()
{
$this->load->model('manejodocumento_modelo');
$respuesta['mensaje']='Archivos añadidos con exito';
$cantidad=count($_FILES['imagenes']['name']) ;
$tiempoEspera=0;
for($i=0;$i<$cantidad;$i++)
{
    // 
      //$destination = 'C:\wamp64\www\Capsys\www\V3\assets\img\tmp\\'.$_FILES['imagenes']['name'][$i];
       //$destination = '/var/www/html/capsys.com.mx/public_html/V3/assets/img/tmp/'.$_FILES['imagenes']['name'][$i]; 
$tiempoEspera=(int)$tiempoEspera+6;      
       $destination = RUTA_ASSETS.'img/tmp/'.$_FILES['imagenes']['name'][$i];       

       move_uploaded_file($_FILES['imagenes']['tmp_name'][$i], $destination);
       $archivo['ListFilesURL']= base_url().'assets/img/tmp/'.$_FILES['imagenes']['name'][$i];
       //$archivo['ListFilesURL']= 'https://capsys.site/V3/assets/img/tmp/error.png';
       $archivo['TypeDestinoCDigital']  = 'DOCUMENT';//$this->input->post('TypeDestinoCDigital', TRUE);
       $archivo['IDValuePK']= $_POST['polizaVigente'];//'23247';/*IDDocto*/      
       $archivo['FolderDestino']= '';
       $archivo['wsAction'] = "PUTFiles";
       $respuesta=$this->ws_sicas->subirArchivoSicas($archivo);

}
sleep($tiempoEspera);
echo json_encode($respuesta);
}
//------------------------------------------
 function subirRecibo(){
 	
 		
 	if ($_FILES['DocumentoFiles']["error"] > 0){echo "Error: " . $_FILES['DocumentoFiles']['error'] . "<br>";} 
 	else {
             
           $this->load->model('manejodocumento_modelo');         
           $extension=explode(".",$_FILES['DocumentoFiles']['name'] );
           $largo=count($extension);
           $ext=$extension[$largo-1];
           $nameFileSicas=$_POST['inputDocumento'].'_'.$_POST['inputPeriodo'];
      if($_POST['inputEndoso']!='')
		   {
		   	if($_POST['inputIdEndoso']>0){  $nameFileSicas=$_POST['inputDocumento'].'_'.$_POST['inputEndoso'].'_'.$_POST['inputPeriodo'];}
		   }
		  // $destination	= 'C:\wamp64\www\Capsys\www\V3\assets\img\tmp\\'.$nameFileSicas.'.'.$ext;
		   $destination	= RUTA_ASSETS.'img/tmp/'.$nameFileSicas.'.'.$ext;
       
		   move_uploaded_file($_FILES['DocumentoFiles']['tmp_name'], $destination);
		   //$archivo['ListFilesURL']= base_url().'assets/img/tmp/'.$nameFileSicas;		  
		   $archivo['ListFilesURL']= base_url().'assets/img/tmp/'.$nameFileSicas.'.'.$ext;		
		   //$archivo['ListFilesURL']='https://capsys.com.mx/V3/assets/img/tmp/PRUEBASISTEMAS.pdf';
		   $archivo['TypeDestinoCDigital']	= 'DOCUMENT';//$this->input->post('TypeDestinoCDigital', TRUE);
		   $archivo['IDValuePK']= $_POST['inputIdDocto'];//'23247';/*IDDocto*/      //$_POST['inputIdDocto'];//$this->input->post('IDValuePK', TRUE);
		   $contRec=strlen($_POST['inputRecibo']);
		   $contRec=9-$contRec;
		   $rec='';
		   for($i=0;$i<$contRec;$i++){$rec.='0';}           
           //$archivo['FolderDestino']= 'REC000'.$_POST['inputRecibo'];//202521";/*IDRecibo*/   //$this->input->post('FolderDestino', TRUE);
           $archivo['FolderDestino']= 'REC'.$rec.$_POST['inputRecibo'];
		   if($_POST['inputEndoso']!='')
		   {
		   	if($_POST['inputIdEndoso']>0)
		   	{
		   	 $contRecEnd=strlen($_POST['inputIdEndoso']);
		     $contRecEnd=9-$contRecEnd;
		     $recEnd='';
		     for($i=0;$i<$contRecEnd;$i++){$recEnd.='0';}
             $archivo['FolderDestino']='END'.$recEnd.$_POST['inputIdEndoso'].'/'.'REC'.$rec.$_POST['inputRecibo'];
		   	}


		   }		   
		   $archivo['wsAction'] = "PUTFiles";
		   $archivo['wsNodoExtrae']= "Datos";
		 
		   $respuesta=$this->ws_sicas->subirArchivoSicas($archivo);

       $array['value']=$_POST['inputIdEnviarCorreo'];
       $array['idLlavePermiso']='subirrecibocobranza';
       $correos=$this->permisooperativo->PermisoModuloPersonaCorreos($array);
       foreach ($correos as  $value) 
      {
       $guardaMensaje['desde']="Avisos de GAP<avisosgap@aserorescpital.com>";
       $guardaMensaje['para']=$value->email;
       $guardaMensaje['mensaje']='<div>Se acaba de agregar un  recibo a la poliza:'.$_POST['inputDocumento'].' </div><div>Periodo:'.$_POST['inputPeriodo'].'</div></div>';       
       if($_POST['inputEndoso']!=''){$guardaMensaje['mensaje']='<div>Se acaba de agregar un  recibo a la poliza: '.$_POST['inputDocumento'].'</div><div>Endoso'.$_POST['inputEndoso'].'</div><div> Periodo '.$_POST['inputPeriodo'].'</div></div>'; }    
       $guardaMensaje['asunto']='Recibo';
      $guardaMensaje['identificaModulo']='subirRecibo|'.$_POST['inputDocumento'].'|'.$_POST['inputEndoso'].'|'.$_POST['inputPeriodo'];     
      #$this->email_model->enviarCorreo($guardaMensaje);   
     }
    	 $idDocto = $_POST["inputIdDocto"];	
		   $data = array("IDDocto" => $idDocto);
          $respuesta = $this->ws_sicas->GetCDDigital($data);
          $respuesta['serie']=$_POST['inputSerie'];
          $respuesta['IDRecibo']=$_POST['inputRecibo'];
          $respuesta['periodo']=$_POST['inputPeriodo'];
          $respuesta['bodyTable']=$_POST['inputBody'];
          $respuesta['documento']=$_POST['inputDocumento'];   
          $respuesta['inner']=$_POST['inputDocumento'];               	   
          $respuesta['endoso']=$_POST['inputEndoso']; 
		  //echo json_encode($respuesta);        		  
		}
 }
 //---------------------------------------------------------------------------------------------------------------------
 function subirComprobante(){
 	//
 	if ($_FILES['DocumentoFiles']["error"] > 0){echo "Error: " . $_FILES['DocumentoFiles']['error'] . "<br>";} 
	else { 		   
           $this->load->model('manejodocumento_modelo');         
           $extension=explode(".",$_FILES['DocumentoFiles']['name'] );
           $largo=count($extension);
           $ext=$extension[$largo-1];
           $nameFileSicas=$_POST['inputDocumento'].'_'.$_POST['inputPeriodo'];
           if($_POST['inputEndoso']!='')
		   {
		   	if($_POST['inputIdEndoso']>0)
		   	{  $nameFileSicas=$_POST['inputDocumento'].'_'.$_POST['inputEndoso'].'_'.$_POST['inputPeriodo'];
		   	}
		   }
		   //$destination	= 'C:\wamp64\www\Capsys\www\V3\assets\img\tmp\\'.$nameFileSicas.'Recibo.'.$ext;
		   $destination	= RUTA_ASSETS.'img/tmp/'.$nameFileSicas.'Comprobante.'.$ext;
		   move_uploaded_file($_FILES['DocumentoFiles']['tmp_name'], $destination);
		   //https://capsys.com.mx/V3/assets/img/tmp/4011500517591-4_6.pdf
		   //$archivo['ListFilesURL']= base_url().'assets/img/tmp/'.$nameFileSicas;
		$archivo['ListFilesURL']= base_url().'assets/img/tmp/'.$nameFileSicas.'Comprobante.'.$ext;	
		//$archivo['ListFilesURL']='https://capsys.com.mx/V3/assets/img/tmp/PRUEBASISTEMASComprobante.pdf';
		   $archivo['TypeDestinoCDigital']	= 'DOCUMENT';//$this->input->post('TypeDestinoCDigital', TRUE);
		   $archivo['IDValuePK']= $_POST['inputIdDocto'];//'23247';/*IDDocto*/      //$_POST['inputIdDocto'];//$this->input->post('IDValuePK', TRUE);
		   
		   $contRec=strlen($_POST['inputRecibo']);
		   $contRec=9-$contRec;
		   $rec='';
		   for($i=0;$i<$contRec;$i++){$rec.='0';}           
           //$archivo['FolderDestino']= 'REC000'.$_POST['inputRecibo'];//202521";/*IDRecibo*/   //$this->input->post('FolderDestino', TRUE);
           $archivo['FolderDestino']= 'REC'.$rec.$_POST['inputRecibo'];
		   if($_POST['inputEndoso']!='')
		   {
		   	if($_POST['inputIdEndoso']>0)
		   	{
		   	 $contRecEnd=strlen($_POST['inputIdEndoso']);
		     $contRecEnd=9-$contRecEnd;
		     $recEnd='';
		     for($i=0;$i<$contRecEnd;$i++){$recEnd.='0';}
             $archivo['FolderDestino']='END'.$recEnd.$_POST['inputIdEndoso'].'/'.'REC'.$rec.$_POST['inputRecibo'];
		   	}

		   }
		   $archivo['wsAction'] = "PUTFiles";
		   $archivo['wsNodoExtrae']= "Datos";
		   $this->ws_sicas->subirArchivoSicas($archivo);
    	   $idDocto = $_POST["inputIdDocto"];	
		   $data = array("IDDocto" => $idDocto);
        $respuesta = $this->ws_sicas->GetCDDigital($data);
          $respuesta['serie']=$_POST['inputSerie'];
          $respuesta['IDRecibo']=$_POST['inputRecibo'];
          $respuesta['periodo']=$_POST['inputPeriodo'];
          $respuesta['bodyTable']=$_POST['inputBody'];
          $respuesta['documento']=$_POST['inputDocumento'];  
                    $respuesta['inner']=$_POST['inputDocumento'];                    
          $respuesta['endoso']=$_POST['inputEndoso'];              	   
		  //echo json_encode($respuesta); 
		}
 }

//------------------------------------------------------------------------------------------
function enviarCorreos()
{
	 $correos=json_decode($_POST['valores']);
	 $respuesta='';
	 $idRecibo=array(); 
   $cantCorreos=array();  
   foreach ($correos as  $value) 
   { 
     $array=array();
     $filtroEmail=0;    
     $filtroEmail=filter_var($value->email, FILTER_VALIDATE_EMAIL);
     $insert['tipoEnvioCH']='envio_correos';
     $insert['hRefCH']=$value->href;
     $insert['idRecibo']=$value->idRecibo;
     $insert['idSerie']=$value->idSerie;
     $insert['idDocto']=$value->idDocto;
     $insert['IDCli']=$value->IDCli;
     $insert['envioDestinoCH']=$value->email;
     $insert['idCobranzaHistorial']=-1;
     $insert['documento']=$value->documento;
     $insert['endoso']=$value->endoso;
     $insert['email']=$this->tank_auth->get_usermail();    
     $array['idRecibo']=$value->idRecibo;
     $array['status']=0;
    if($filtroEmail)
    {
        //$value->href='https://www.sicasonline.info/SICASData/SICAS1325/Storage/CONT000013028/Cliente/DOC000100498/Comp_0880232608.pdf';      
      if($value->href!='')
      {
       $insert['hRefCH']=$value->href;
       $insert['fueEnviado']=1;
       $insert['comentarioDelEnvio']="CON EXITO";
       $idCobranzaHistorial=$this->reportes_model->cobranzaHistorial($insert);      
       $dias['fechaFinal']=$value->flimpago;
       $diasParaVencer=$this->libreriav3->diferenciaEntreDias($dias);
       $diasFinales='';       
       if($diasParaVencer->invert==1){$diasFinales=-$diasParaVencer->days;}
       else{$diasFinales=$diasParaVencer->days;}       
   	   $guardaMensaje['desde']="Avisos de GAP<avisosgap@aserorescpital.com>";
       $guardaMensaje['para']=$value->email;
       $guardaMensaje['mensaje']='<div>Estimado cliente su poliza '.$value->documento.' vence en '.$diasFinales.' dias, descargue su recibo <a href="'.$value->href.'">aqui</a> o para cargo a tarjeta visite <a href="www.capitalseguros.com.mx/paga-en-linea/">https://www.capitalseguros.com.mx/paga-en-linea/</a></div>';           
       if($insert['endoso']!=''){$guardaMensaje['mensaje']='<div>Estimado cliente su poliza '.$value->documento.'  vence en '.$diasFinales.' dias, descargue su recibo</div><a href="'.$value->href.'">aqui</a> o para cargo a tarjeta visite <a href="www.capitalseguros.com.mx/paga-en-linea/">https://www.capitalseguros.com.mx/paga-en-linea/</a></div>'; }    
        $guardaMensaje['asunto']='Recibo';
       $guardaMensaje['identificaModulo']='Cobranza-'.$idCobranzaHistorial;     
       $array['status']=1;        
       $this->email_model->enviarCorreo($guardaMensaje);
      }
     else
     {
      $insert['fueEnviado']=0;
      $insert['comentarioDelEnvio']='SIN DOCUMENTO';      
      $idCobranzaHistorial=$this->reportes_model->cobranzaHistorial($insert);
     }
    }
    else
    {
     $insert['fueEnviado']=0;
     $insert['comentarioDelEnvio']='EMAIL INVALIDO';
     $idCobranzaHistorial=$this->reportes_model->cobranzaHistorial($insert);
    }
    $consultaCantCorreos=array();
    $consultaCantCorreos=$this->db->query("select 'envio_correos' as tipoEnvio,(count(idCobranzaHistorial)) as total,idSerie,idRecibo from cobranzahistorial where tipoEnvioCH='envio_correos' and idRecibo=".$value->idRecibo." and idSerie='".$value->idSerie."'")->result()[0];
    array_push($cantCorreos, $consultaCantCorreos);
    array_push($idRecibo,$array);
   }
  $respuesta['idRecibo']=$idRecibo;
  $respuesta['bodyTabla']=$_POST['bodyTabla'];    
  $respuesta['cantCorreos']=$cantCorreos;
   echo json_encode($respuesta);		
}

//---------------------------------------------------------------------------------------------------------------------
function guardarTarjeta()
{ 
$bandGuardado=0;
$mensaje="";
  if($_POST['tipoTarjeta']=='Visa' || $_POST['tipoTarjeta']=='Master Card')
  { $codigoSeguridad=strlen($_POST['numeroTarjeta'] ) ;
  	
    if((strlen($_POST['codigoSeguridad']))==3 && (strlen($_POST['numeroTarjeta']))==16){$bandGuardado=1;}
    else{$mensaje="El numero debe tener 16 digitos y el codigo 3";}
  }
  else
  {
    if((strlen($_POST['codigoSeguridad']))==4 && (strlen($_POST['numeroTarjeta']))==15){$bandGuardado=1;}
    else{$mensaje="El numero debe tener 15 digitos y el codigo 4";}  
  }
if($bandGuardado){
  $info['dato']=$_POST['numeroTarjeta'];
  $info['llave']=$_POST['IDCli'];
  $encriptaNumeroTarjeta=$this->PersonaModelo->encriptarClave($info);
  $info['dato']=$_POST['codigoSeguridad'];
  $info['llave']=$_POST['IDCli'];
  $encriptaCodigoSeguridad=$this->PersonaModelo->encriptarClave($info);
  $guardarTarjeta['numeroTarjeta']=$encriptaNumeroTarjeta;
  $guardarTarjeta['vencimiento']=$_POST['vencimiento'];
  $guardarTarjeta['anio']=$_POST['anio'];
  $guardarTarjeta['codigoSeguridad']=$encriptaCodigoSeguridad;
  $guardarTarjeta['titularTarjeta']=$_POST['titularTarjeta'];
  $guardarTarjeta['banco']=$_POST['banco'];
  $guardarTarjeta['tipoPago']=$_POST['tipoPago'];
  $guardarTarjeta['IDCli']=$_POST['IDCli'];
  $guardarTarjeta['tipoTarjeta']=$_POST['tipoTarjeta'];
  $guardarTarjeta['idPersonaTarjeta']=-1;
  $tarjetaExistente=$this->PersonaModelo->tarjetaPersona($guardarTarjeta);  
  if($tarjetaExistente){$mensaje="La tarjeta se ha guardado";}
  else{$mensaje="La tarjeta ya existe";}
  //$datos=$this->db->query($consulta)->result();
 }
 $respuesta['mensaje']=$mensaje;
 echo json_encode($respuesta);

}


//---------------------------------------------------------------------------------------------------------------------
 function mostrarTarjeta()
{
  $respuesta="";
  $select['IDCli']=$_POST['IDCli'];
  
  $datos=$this->PersonaModelo->tarjetaPersona($select);
  if((count($datos))>0)
  {
  	$respuesta['mensaje']="";
  	$respuesta['datos']=$datos;
  }
  else{$respuesta['mensaje']='No se tiene registro de tarjeta';} 
   echo json_encode($respuesta);
}
//------------------------------------------------------------------------------------------------------------------
function cancelarTarjeta()
{
	
	 $info['dato']=$_POST['numeroTarjeta'];
  $info['llave']=$_POST['IDCli'];
  $encriptaNumeroTarjeta=$this->PersonaModelo->encriptarClave($info);
  $info['dato']=$_POST['codigoSeguridad'];
  $info['llave']=$_POST['IDCli'];
  $encriptaCodigoSeguridad=$this->PersonaModelo->encriptarClave($info);
  $_POST['codigoSeguridad']=$encriptaCodigoSeguridad;
  $_POST['numeroTarjeta']=$encriptaNumeroTarjeta;
  $_POST['tarjetaACtiva']=0;
  $_POST['update']='';
  $this->PersonaModelo->tarjetaPersona($_POST);
	$respuesta['mensaje']='Cancelacion Correcta';
  echo json_encode($respuesta);
}
//------------------------------------------------------------------------------------------------------------------
function reciboId(){
$datos=$this->ws_sicas->aaa();


 	 //$this->datos['cobranzaPendiente']=$this->ws_sicas->obtenerReporteCobranzaBorrar($vendedor,'01/01/2020','31/01/2020',0);
 	 //$this->datos['cobranzaAtrasada']=$this->ws_sicas->obtenerReporteCobranzaBorrar($vendedor,'01/11/2019','29/12/2019',0);
 	 //$this->datos['cobranzaPendiente']=$this->ws_sicas->obtenerReporteCobranzaBorrar($arrayCobranza);
	 
}

//--------------------------------------------------------------------------------------------------------------

function reporteCobranzaCliente()
{

          
     $fecha=getdate();
     $fechaHoy=$fecha['year'].'-'.$fecha['mon'].'-'.$fecha['mday'];
     $anioAnterior=$fecha['year']-1;
     $agentes=$this->personamodelo->devuelveAgentesPorCoordinadorActivos(224);
     $cantidad=count($agentes);
     $cantidad--;
     $condicion="";
     foreach ($agentes as $key=>$value) { ($cantidad==$key) ? $condicion.=$value->IDVend : $condicion.=$value->IDVend.'|';}
     $fechaInicial=$fecha['mday'].'/'.$fecha['mon'].'/'.$anioAnterior;
     $fecha1Final=$fecha['mday'].'/'.$fecha['mon'].'/'.$fecha['year'];
     $respuesta=$this->ws_sicas->cobranza($condicion,'1/1/2020','31/1/2020','1'); 
     $datos['reportecobranzaclientes']=array(); 
     //$datos['reportecobranzaclientes']= $respuesta->TableInfo;
     $datos['total']=count($datos['reportecobranzaclientes']);
     foreach ($respuesta as  $value) {
     	array_push($datos['reportecobranzaclientes'],$value);
     }  
     //
     echo json_encode($datos);
 
     // $respuesta=$this->ws_sicas->cobranza('76',$fechaInicial,$fecha1Final,$numeroPagina);   
     
}

//--------------------------------------------------------------------------------------------------------------
function comentariosRenovacion()
{
  $respuesta=array();  
  $respuesta['mensaje']='';
  $insert['Documento']=$_POST['Documento'];
  $insert['comentario']=$_POST['comentario'];
  $insert['IDDocto']=$_POST['IDDocto']; 
  $ultimoID=$this->reportes_model->renovacioncomentario($insert); 
  
  $insertVisto['idRenovacionComentario']=$ultimoID;
  $insertVisto['idPersona']=$this->tank_auth->get_idPersona();
  $insertVisto['estaVisto']=1;
  $this->db->insert('renovacioncomentariorelpersona',$insertVisto);

   $notificacion['tabla']='renovacioncomentario';          
    $notificacion['idTabla']=$ultimoID;
    $notificacion['tipo_id']='comentario';
    $notificacion['referencia']='COMENTARIO_ACTIVIDAD';
    $notificacion['referencia_id']='1001';
    $notificacion['check']=0;
    $notificacion['comentarioAdicional']='SE AGREGO UN COMENTARIO: '.$_POST['comentario'].' AL DOCUMENTO '.$_POST['Documento'].' DESDE EL MODULO DE RENOVACIONES';
    $notificacion['id']=-1;
    $notificacion['tipo']='OTRO';
    $notificacion['controlador']='cobranza/renovacion';        

   
  if($this->tank_auth->get_IDVend()==0)
  {

    $datosVend=$this->personamodelo->obtenerUsersPorIDVend($_POST['IDVend']);      
     
    $notificacion['persona_id']=$datosVend[0]->idPersona;
    $notificacion['email']=  $datosVend[0]->email;

  }
  else
  {
    //========== VERIFICA NOTIFICACION PARA RESPONSABLE DE ACTIVIDAD
   $respuesta=$this->actividades_model->devolverCorreoResponsableActividad($_POST['ramo'],false);

   if($respuesta->encontrado)
   {
    $notificacion['persona_id']=$respuesta->idPersona;
    $notificacion['email']=  $respuesta->email;
    

   }
  }

  $ultimoId=$this->notificacionmodel->notificacion($notificacion);
    $actualizar['id']=$ultimoId;
    $actualizar['controlador']='cobranza/renovacion';
    $this->notificacionmodel->actualizarNotificacion($actualizar);    

  echo json_encode($respuesta);
}
//-----------------------------------------------------
function comentarios(){
  

if(isset($_POST['buscar'])) 
{
  $respuesta['comentarios']=$this->reportes_model->cobranzacomentariosPorIDRecibo($_POST['IDRecibo']);  
}
else
{
  $respuesta['mensaje']='Comentario guardado';
   $consulta['idCobranzaComentarios']=-1;
   $consulta['cobranzaComentarios']=$_POST['comentario'];
   $consulta['idRecibo']=$_POST['IDRecibo'];
   $consulta['idDocto']=$_POST['idDocto'];
   $consulta['idSerie']=$_POST['serie'];
   $consulta['IDCli']=$_POST['IDCli'];
   $consulta['endoso']=$_POST['endoso'];
   $this->reportes_model->cobranzacomentarios($consulta);
   $this->reportes_model->enviarCorreoComentario($_POST['IDRecibo'],$_POST['comentario']);
}

  
  echo json_encode($respuesta);
}

//--------------------------------------------------------------------------------------------------------------
function comprobarNumero($telefono)
{
  $numero=explode(':',$telefono);
   
    if((count($numero))>1)
      {
        if(ctype_digit($numero[1])){return $numero[1];}
        else{return  0; }
      }
    else
      { 
        if(ctype_digit($numero[0])){return $numero[0];}
        else{return 0;}
      }
}
//-------------------------------------------------------------------------------------------
function mandarWhats()
{ 
  $correos=json_decode($_POST['valores']);
  $respuesta='';
  $linkCorto="";
  $idRecibo=array();         
   $cantCorreos=array(); 
 
     foreach ($correos as  $value) 
   {    
      $insert=array();
      $fueEnviado=array();
      $insert['tipoEnvioCH']='envio_whats';
       $insert['hRefCH']=$value->href;
       $insert['idRecibo']=$value->idRecibo;
       $insert['idSerie']=$value->idSerie;
       $insert['idDocto']=$value->idDocto;
       $insert['IDCli']=$value->IDCli;
       $insert['endoso']=$value->endoso;
       $insert['idCobranzaHistorial']=-1;
       $insert['documento']=$value->documento;
       $insert['email']=$this->tank_auth->get_usermail();
       $fueEnviado['idRecibo']=$value->idRecibo;
       $fueEnviado['status']=0;
       //$value->celular='celular:9996091909';
       //$value->href='https://www.sicasonline.info/SICASData/SICAS1325/Storage/CONT000013028/Cliente/DOC000100498/Comp_0880232608.pdf';

      $link=$value->href;
      if($value->href!='')
      {
       if($value->celular!=''){
       $telefono=$this->comprobarNumero($value->celular);                
       if($telefono!=0) 
       {
       $insert['envioDestinoCH']=$telefono;
         #$linkCorto=$this->whatssms->obtenerLink($link);               
        $linkCorto=$link;             
       if($linkCorto!='')
      { 
        $insert['linkCorto']=$linkCorto;
          $dias['fechaFinal']=$value->flimpago;
          $diasParaVencer=$this->libreriav3->diferenciaEntreDias($dias);
          $diasFinales='';       
          if($diasParaVencer->invert==1){$diasFinales=-$diasParaVencer->days;}
          else{$diasFinales=$diasParaVencer->days;}
              $whats['message']='Estimado cliente su póliza '.$value->documento.' vence en '.$diasFinales.' dias, descargue su recibo aqui '.$linkCorto.' o para cargo a tarjeta visite https://www.capitalseguros.com.mx/paga-en-linea/';
           $whats['numbers']=$telefono;    
          $res=$this->whatssms->enviarWhats($whats);

        if($res)
        {
         
         $diasParaVencer=$this->libreriav3->diferenciaEntreDias($dias);
         $diasFinales='';        
         if($diasParaVencer->invert==1){$diasFinales=-$diasParaVencer->days;}
         else{$diasFinales=$diasParaVencer->days;}
         $insert['fueEnviado']=1;
         $insert['comentarioDelEnvio']="CON EXITO";
         $insert['hRefCH']=$value->href;
         $fueEnviado['status']=1;
         //array_push($idRecibo,$value->idRecibo);  
       } 
       else{$insert['fueEnviado']=0;$insert['comentarioDelEnvio']="ERROR EN EL ENVIO";    }
      }    
      else{$insert['fueEnviado']=0;$insert['comentarioDelEnvio']="EL LINK NO SE GENERO";    }
     }
     else{$insert['fueEnviado']=0;$insert['comentarioDelEnvio']="NUMERO INVALIDO";    }
     }
     else{$insert['fueEnviado']=0;$insert['comentarioDelEnvio']="SIN NUMERO";    }
     }
     else{$insert['fueEnviado']=0;$insert['comentarioDelEnvio']="NO HAY DOCUMENTO";    }
     $idCobranzaHistorial=$this->reportes_model->cobranzaHistorial($insert);
     $consultaCantCorreos=$this->db->query("select 'envio_correos' as tipoEnvio,(count(idCobranzaHistorial)) as total,idSerie,idRecibo from cobranzahistorial where tipoEnvioCH='envio_whats' and idRecibo=".$value->idRecibo." and idSerie='".$value->idSerie."'")->result()[0];
    array_push($cantCorreos, $consultaCantCorreos); 
     array_push($idRecibo,$fueEnviado);  
   }//FIN DEL foreach
   $respuesta['idRecibo']=$idRecibo;
   $respuesta['bodyTabla']=$_POST['bodyTabla'];    
  $respuesta['cantCorreos']=$cantCorreos;
   echo json_encode($respuesta);   

}
//---------------------------------------------------------------------------------------------------------------------


function mandarWhatsOriginal()
{  $respuesta['mensaje']='bien';
   $whats="";
   $linkCorto=''; 
   $telefono='';
     // $link="https://www.sicasonline.info/SICASData/SICAS1325/Storage/CONT000020549/Cliente/DOC000123785/REC000294304/0880271290_1.pdf";
     $link=$_POST['linkLargo'];
     $linkCorto=$this->whatssms->obtenerLink($link);     
     //$_POST['telefono']='celular:9996091909';
      if($linkCorto!='')
      {
        $telefono=$this->comprobarNumero($_POST['telefono']);
      
        if($telefono!=0)
        {        
          //$whats['message']=$_POST['nombreCliente'].' este es link de descarga del recibo '.$_POST['serie'].' de la poliza '.$_POST['documento'].'   '.$linkCorto;          
          $dias['fechaFinal']=$_POST['flimpago'];
          $diasParaVencer=$this->libreriav3->diferenciaEntreDias($dias);
          $diasFinales='';  
          
          if($diasParaVencer->invert==1){$diasFinales='-'.$diasParaVencer->days;}
          else{$diasFinales=$diasParaVencer->days;}
          
              $whats['message']='Estimado cliente su póliza '.$_POST['documento'].' vence en '.$diasFinales.' dias, descargue su recibo aqui '.$linkCorto.' o para cargo a tarjeta visite https://www.capitalseguros.com.mx/paga-en-linea/';

//          $whats['message']='Estimado cliente su póliza '.$_POST['documento'].' vence en ***** dias, descargue su recibo aqui '.$linkCorto.' o para cargo a tarjeta visite https://www.capitalseguros.com.mx/paga-en-linea/';
           $whats['numbers']=$telefono;    
          $res=$this->whatssms->enviarWhats($whats);
          if($res)
          {
            $insert['tipoEnvioCH']='envio_whats';
            $insert['hRefCH']=$_POST['linkLargo'];
            $insert['idRecibo']=$_POST['IDRecibo'];
            $insert['idSerie']=$_POST['serie'];
            $insert['idDocto']=$_POST['idDocto'];
            $insert['IDCli']=$_POST['IDCli'];
            $insert['envioDestinoCH']=$telefono;
            $insert['endoso']=$_POST['endoso'];
            $insert['idCobranzaHistorial']=-1;
            $insert['linkCorto']=$linkCorto;
            $insert['email']=$this->tank_auth->get_usermail();
            $idCobranzaHistorial=$this->reportes_model->cobranzaHistorial($insert);
            $respuesta['mensaje']='Envio correcto'; 
          }
          else{$respuesta['mensaje']='Error de envio';}
         }
         else{$respuesta['mensaje']='No se puede procesar el numero';}

      } 
      else{$respuesta['mensaje']='Error al generar al generar link';}

      echo json_encode($respuesta);
}
//---------------------------------------------------------------------------------------------------------------------
function enviarSMS()
{

  $correos=json_decode($_POST['valores']);
  $respuesta='';
  $linkCorto="";
  $idRecibo=array();
   $cantCorreos=array();   
       
     foreach ($correos as  $value) 
   {    
      $insert=array();
      $fueEnviado=array();
      $insert['tipoEnvioCH']='envio_sms';
       $insert['hRefCH']=$value->href;
       $insert['idRecibo']=$value->idRecibo;
       $insert['idSerie']=$value->idSerie;
       $insert['idDocto']=$value->idDocto;
       $insert['documento']=$value->documento;
       $insert['IDCli']=$value->IDCli;
       $insert['endoso']=$value->endoso;
       $insert['idCobranzaHistorial']=-1;
       $insert['email']=$this->tank_auth->get_usermail();
       $fueEnviado['idRecibo']=$value->idRecibo;
       $fueEnviado['status']=0;
       //$value->celular='celular:9996091909';
       //$value->href='https://www.sicasonline.info/SICASData/SICAS1325/Storage/CONT000013028/Cliente/DOC000100498/Comp_0880232608.pdf';

      $link=$value->href;
      $telefono=$this->comprobarNumero($value->celular);                
      if ($telefono!=0){$insert['envioDestinoCH']=$telefono;}
      else{$insert['envioDestinoCH']=$value->celular;}
      if($value->href!='')
      {
       if($value->celular!=''){
       $telefono=$this->comprobarNumero($value->celular);                
       if($telefono!=0) 
       {
       $insert['envioDestinoCH']=$telefono;
       $linkCorto=$this->whatssms->obtenerLink($link);               
       if($linkCorto!='')
      { 
        $insert['linkCorto']=$linkCorto;
          $dias['fechaFinal']=$value->flimpago;
          $diasParaVencer=$this->libreriav3->diferenciaEntreDias($dias);
          $diasFinales='';       
          if($diasParaVencer->invert==1){$diasFinales=-$diasParaVencer->days;}
          else{$diasFinales=$diasParaVencer->days;}
         $sms['message']='Estimado cliente su poliza '.$value->documento.' vence en '.$diasFinales.' dias,baje su recibo aqui '.$linkCorto.' o visite https://www.capitalseguros.com.mx/paga-en-linea';
           $sms['numbers']=$telefono;
        $res=$this->whatssms->enviarSMS($sms);
        //$res=1;
        if($res)
        {
         
         $diasParaVencer=$this->libreriav3->diferenciaEntreDias($dias);
         $diasFinales='';        
         if($diasParaVencer->invert==1){$diasFinales=-$diasParaVencer->days;}
         else{$diasFinales=$diasParaVencer->days;}
         $insert['fueEnviado']=1;
         $insert['comentarioDelEnvio']="CON EXITO";
         $insert['hRefCH']=$value->href;
         $fueEnviado['status']=1;
         //array_push($idRecibo,$value->idRecibo);  
       } 
       else{$insert['fueEnviado']=0;$insert['comentarioDelEnvio']="ERROR EN EL ENVIO";    }
      }    
      else{$insert['fueEnviado']=0;$insert['comentarioDelEnvio']="EL LINK NO SE GENERO";    }
     }
     else{$insert['fueEnviado']=0;$insert['comentarioDelEnvio']="NUMERO INVALIDO";    }
     }
     else{$insert['fueEnviado']=0;$insert['comentarioDelEnvio']="SIN NUMERO";    }
     }
     else{$insert['fueEnviado']=0;$insert['comentarioDelEnvio']="NO HAY DOCUMENTO";    }
     $idCobranzaHistorial=$this->reportes_model->cobranzaHistorial($insert);
    $consultaCantCorreos=array();
    $consultaCantCorreos=$this->db->query("select 'envio_correos' as tipoEnvio,(count(idCobranzaHistorial)) as total,idSerie,idRecibo from cobranzahistorial where tipoEnvioCH='envio_sms' and idRecibo=".$value->idRecibo." and idSerie='".$value->idSerie."'")->result()[0];
    array_push($cantCorreos, $consultaCantCorreos);

     array_push($idRecibo,$fueEnviado);  
   }//FIN DEL foreach
   $respuesta['idRecibo']=$idRecibo;
   $respuesta['bodyTabla']=$_POST['bodyTabla'];    
   $respuesta['cantCorreos']=$cantCorreos;
   echo json_encode($respuesta);   
}


//-----------------------------------------
function buscarPoliza()
{
  $vendedor=$this->tank_auth->get_IDVend();
  if($vendedor>0)
  {
    $idPersona=$this->tank_auth->get_idPersona()*1000;
    if($vendedor==$idPersona){$vendedor=0;}
  }
 $xml='';
 $xml=$this->ws_sicas->obtenerCobranzaEfectuadaPorFolio($_POST['poliza'],$vendedor);
 $bandera="";
 foreach($xml->TableInfo as $table)
  {
    if($table){
      $bandera=$table->Status_TXT;
               $filtroConsulta=" and idRecibo=".$table->IDRecibo." and idSerie='".$table->Serie."' and email='".$this->tank_auth->get_usermail()."'";
       $historialEnvio=$this->db->query("select 'envio_correos' as tipoEnvio,(count(idCobranzaHistorial)) as total from cobranzahistorial where  tipoEnvioCH='envio_correos '".$filtroConsulta." union select 'envio_whats' as tipoEnvio,(count(idCobranzaHistorial) ) as total from cobranzahistorial where  tipoEnvioCH='envio_whats' ".$filtroConsulta." union select 'envio_sms' as tipoEnvio,(count(idCobranzaHistorial)) as total from cobranzahistorial where  tipoEnvioCH='envio_sms' ".$filtroConsulta)->result();
       $table->historialCorreos=$historialEnvio[0]->total;
       $table->historialWhats=$historialEnvio[1]->total;
       $table->historialSMS=$historialEnvio[2]->total;
       $contactoCli='select * from clientelealtadtipocontactodocumento c where c.documento="'.$table->Documento.'"';
        $contactoCliDatos=$this->db->query($contactoCli)->result();    
        foreach ($contactoCliDatos as $key => $valueCD) 
        {
          if($valueCD->tipoContacto==3){$table->EMail1=$valueCD->contacto;}
          else{$table->Telefono1=$valueCD->contacto;}
        }
    }
  } 
  
 $contador=0;
 $contador=$xml->TableControl->MaxRecords;
 if($contador==0){$xml->TableInfo=''; }   
 if($contador==1)
  {
    $datos['TableInfo'][0]=$xml->TableInfo; 
     $datos['TableControl']=$xml->TableControl; 
     echo json_encode($datos);
   }
  else{echo json_encode($xml);}
}

//------------------------------------------------------------------------------------
function hora(){
	date_default_timezone_set('America/Merida');
	echo(date('Y-m-d H:i:s'));
	date_default_timezone_set('America/Cancun');
	echo((string)date('Y-m-d H:i:s'));
}
//--------------------------------------------------------------------------------------------------------------
function bd(){
$consulta="SHOW FULL TABLES FROM capsysv3";
$consultaTabla="SHOW COLUMNS FROM ";
$respuesta=$this->db->query($consulta)->result();
foreach ($respuesta as $key=>$value) 
{
	if($value->Tables_in_capsysv3!='catalog_actividades-status'){
  	$tablas=$this->db->query($consultaTabla.$value->Tables_in_capsysv3)->result();
    unset($respuesta[$key]->Table_type);
    $respuesta[$key]->tabla=$value->Tables_in_capsysv3;
    $respuesta[$key]->campos=$tablas;
    unset($respuesta[$key]->Tables_in_capsysv3);
  	}
}

//$this->load->view('reportes/prueba',$respuesta);	
}
//------------------------------------------------------------------------------------
function buscarPolizaPorNombreCliente()
{
  
  $respuesta['mensaje']="llega";
  $vendedor=0;
  if($this->tank_auth->get_IDVend()>0){$vendedor=$this->tank_auth->get_IDVend();}
  $xml=$this->ws_sicas->obtenerCobranzaEfectuadaPorFolio('',$vendedor,$_POST['nombre']);

  $bandera="";

 foreach($xml->TableInfo as $key => $table)
  {
    $bandera=$table->Status_TXT;
           $filtroConsulta=" and idRecibo=".$table->IDRecibo." and idSerie='".$table->Serie."' and email='".$this->tank_auth->get_usermail()."'";
       $historialEnvio=$this->db->query("select 'envio_correos' as tipoEnvio,(count(idCobranzaHistorial)) as total from cobranzahistorial where  tipoEnvioCH='envio_correos '".$filtroConsulta." union select 'envio_whats' as tipoEnvio,(count(idCobranzaHistorial) ) as total from cobranzahistorial where  tipoEnvioCH='envio_whats' ".$filtroConsulta." union select 'envio_sms' as tipoEnvio,(count(idCobranzaHistorial)) as total from cobranzahistorial where  tipoEnvioCH='envio_sms' ".$filtroConsulta)->result();
       $table->historialCorreos=$historialEnvio[0]->total;
       $table->historialWhats=$historialEnvio[1]->total;
       $table->historialSMS=$historialEnvio[2]->total;
               $contactoCli='select * from clientelealtadtipocontactodocumento c where c.documento="'.$table->Documento.'"';
        $contactoCliDatos=$this->db->query($contactoCli)->result();
    
        foreach ($contactoCliDatos as $key => $valueCD) 
        {
          if($valueCD->tipoContacto==3)
          {
             $table->EMail1=$valueCD->contacto;
            
          }
          else
          {
            $table->Telefono1=$valueCD->contacto;
           
          }
        }
       } 
  
   
   
 $contador=0;
 $contador=$xml->TableControl->MaxRecords;
 if($contador==0){$xml->TableInfo=''; }   
 if($contador==1)
  {
    $datos['TableInfo'][0]=$xml->TableInfo; 
     echo json_encode($datos);
   }
else{                
    echo json_encode($xml);
  }
}
//---------------------------------------
function traerRecibosPagados()
{
  $vendedor=$this->tank_auth->get_IDVend();
  if($vendedor>0)
  {
    $idPersona=$this->tank_auth->get_idPersona()*1000;
    if($vendedor==$idPersona){$vendedor=0;}
  }
 $xml='';
 $xml=$this->ws_sicas->obtenerCobranzaEfectuadaPorFolio($_POST['poliza'],$vendedor,null,3);
 
 $bandera="";
 foreach($xml->TableInfo as $table){$bandera=$table->Status_TXT;}
 $contador=0;
 $contador=$xml->TableControl->MaxRecords;
 if($contador==0){$xml->TableInfo=''; }   
 if($contador==1)
  {
    $datos['TableInfo'][0]=$xml->TableInfo; 
     echo json_encode($datos);
   }
else{                
    echo json_encode($xml);
  }
}

//------------------------------------------------------------------------------------
function cancelarReciboPagado()
{
 
  $cancelacion['IDRecibo']=$_POST['recibo'];
  $cancelacion['MotivoAnulacion']=$_POST['comentario'];
  $respuesta['mensaje']="";
  $respuesta['bandera']="";
  if($_POST['recibo']!='')
  {
  $result=$this->ws_sicas->cancelarReciboPagado($cancelacion);
 
 

  if($result)
  {
      $respuesta['mensaje']='El recibo se cancelo con exito';
      $respuesta['bandera']='1';
      $respuesta['IDRecibo']=$_POST['recibo'];
  }
  else
  {
    $respuesta['mensaje']='Error al momento de pagar el recibo reportar a sistemas';
    $respuesta['bandera']='0';
   }
  }
  else{$respuesta['mensaje']='Escoger un recibo';$respuesta['bandera']='0';}
   
    echo json_encode($respuesta);
}



//-----------------------------
function buscarPolizaVigente()
{
  $respuesta['poliza']=array();
  $respuesta['poliza']=$this->ws_sicas->buscaDocumento($_POST['poliza']);
  if($respuesta['poliza']->TableControl->MaxRecords==0){$respuesta['mensaje']='La poliza no fue localizada';}
  else{
    $respuesta['poliza']=$respuesta['poliza']->TableInfo[0];
  
     $esAgenteColaborador=$this->personamodelo->obtenerVendedorPorIDVend($respuesta['poliza']->IDVend);   
          foreach ($esAgenteColaborador as $es) {
     $agenteCol=(string)$es['esAgenteColaborador']; 
     $respuesta['poliza']->esAgenteColaborador=$agenteCol;
       # code...
     }   
     
     //$respuesta['poliza']->esAgenteColaborador=(string)$esAgenteColaborador[0]['esAgenteColaborador'];

  }
  
   
  echo json_encode($respuesta);
}
//----------------------------------------

function traerRenovaciones()
{
 $informacion=array();
 $vendedor=$this->tank_auth->get_IDVend();


 $informacion['renovaciones']=$this->ws_sicas->obtenerRenovacionesFecha($vendedor,$_POST['fechaInicial'],$_POST['fechaFinal'],null,'0',$_POST['opcionBusqueda']);

 
 $filtroRamo=array();
 $datosRamo=$this->actividades_model->devolverRamosDelResponsable($this->tank_auth->get_usermail());
 foreach ($datosRamo as $value) {array_push($filtroRamo, $value->Nombre);}
 $informacion['renovacionvigente']=$this->reportes_model->renovacionvigente($filtroRamo);
 $informacion['renovacionpendiente']=$this->reportes_model->renovacionPendienteMesAnio();

foreach ($informacion['renovaciones']->TableInfo as  $value) 
{   $select['IDDocto']=(string)$value->IDDocto;
     $respuesta= $this->reportes_model->renovacionpre($select);
     $esAgenteColaborador=$this->personamodelo->obtenerVendedorPorIDVend($value->IDVend);
     $value->esAgenteColaborador="";
     foreach ($esAgenteColaborador as $es) {
     $agenteCol=(string)$es['esAgenteColaborador']; 
     $value->esAgenteColaborador=$agenteCol;
       # code...
     }
      $value->renovacionpre=0;
      if(count($respuesta)>0){$value->renovacionpre=1;}   
 
}
$informacion['IDVend']=$this->tank_auth->get_IDVend();
 echo json_encode($informacion);
}
//----------------------------------------------------
function buscarComentariosCobranza()
{
 $respuesta=array();
 
 $respuesta['success']=true;
 $_POST['function']=true;
 $_POST['obtenerCobranzaPendiente']=false;
 #$_POST['notInIdRecibos']=trim($_POST['idRecibosConSolicitud'],',');

 $respuesta['solicitudCobranza']=$this->devolverCobranzaPendiente();

 $respuesta['idRecibo']=$this->reportes_model->buscarComentariosCobranza($_POST);

 
  echo json_encode($respuesta);
}
//----------------------------------------------
function buscarComentariosRenovacion()
{
  $respuesta=array();
 $respuesta['datos']=$this->reportes_model->buscarComentariosRenovacion($_POST);
 
  echo json_encode($respuesta);
}
//--------------------------------------------------------------
function renovarPre()
{
  $datos['mensaje']='Cambios guardados';
  $respuesta='';
  $idDocto=explode(',', $_POST['IDDocto']);
  foreach ($idDocto as  $value) 
  {   
     $insert['insert']="";
     $insert['IDDocto']=$value;
         $this->reportes_model->renovacionpre($insert);     
  }  

  echo json_encode($datos);
}
//-----------------------------------------
function aplicarRenovacion()
{
  //$_POST['IDDocto']=130870;
  $datos=array();
   $datos['mensaje']="";
   $datos['success']=true;
   $datos['IDDocto']=$_POST['IDDocto'];
   $documentos=array();
   $documento=$this->ws_sicas->obtenerRenovacionesFecha(null,null,null,$_POST['IDDocto'],null);
    $Status=(int)$documento->TableInfo->Status;
   $ramo=(string)$documento->TableInfo->RamosNombre;
   $subRamo=(string)$documento->TableInfo->SRamoNombre;
   if($Status!=2)
   {
    /*============ RENOVACION==============*/
    $array=array();
     $array['IDDocto']=$_POST['IDDocto'];
     $IDDoctoVigente='';
     $DocumentoVigente='';
     $DAnteriorVigente='';
     $IDVendVigente='';
     $EjecutNombreVigente='';
     $renovacion=$this->ws_sicas->renovacionPoliza($array);
      if(isset($renovacion->PROCESSDATA->DATA))
      {
     $vigente=$this->ws_sicas->obtenerRenovacionesFecha(null,null,null,$renovacion->PROCESSDATA->DATA,null);
        $IDDoctoVigente=(int)$vigente->TableInfo->IDDocto;
        $DocumentoVigente=(string)$vigente->TableInfo->Documento;
        $DAnteriorVigente=(string)$vigente->TableInfo->DAnterior;
        $IDVendVigente=(int)$vigente->TableInfo->IDVend;
        $EjecutNombreVigente=(string)$vigente->TableInfo->EjecutNombre;      
      }
      else
      {
       $datosRenovada=$this->ws_sicas->buscaDocumento($_POST['documento']);
       $vigente=$this->ws_sicas->buscaDocumento((string)$datosRenovada->TableInfo->DPosterior);
       $IDDoctoVigente=(int)$vigente->TableInfo->IDDocto;
       $DocumentoVigente=(string)$vigente->TableInfo->Documento;
       $DAnteriorVigente=(string)$vigente->TableInfo->DAnterior;
       $IDVendVigente=(int)$vigente->TableInfo->IDVend;
       $EjecutNombreVigente=(string)$vigente->TableInfo->EjecutNombre;

      }
   

     $insertVigente=array();
     $insertVigente['IDDocto']=$IDDoctoVigente;//(int)$vigente->TableInfo->IDDocto;
     $insertVigente['Documento']=$DocumentoVigente;//(string)$vigente->TableInfo->Documento;
     $insertVigente['Solicitud']=$DocumentoVigente;//(string)$vigente->TableInfo->Documento;
     $insertVigente['DAnterior']=$DAnteriorVigente;//(string)$vigente->TableInfo->DAnterior;
     $insertVigente['IDDoctoAnterior']=$_POST['IDDocto'];
     $insertVigente['RamosNombre']=$ramo;
     $insertVigente['SRamoNombre']=$subRamo;
     $insertVigente['IDVend']=$IDVendVigente;//(int)$vigente->TableInfo->IDVend;
     $insertVigente['usuarioCreador']=$this->tank_auth->get_usermail();
     $this->db->insert('renovacionvigente',$insertVigente);
     /*============ RENOVACION==============*/

     /*============ POLIZA RENOVADA========*/
     $insert=array();
     $insert['IDDocto']=(string)$documento->TableInfo->IDDocto;
     $insert['Documento']=(string)$documento->TableInfo->Documento;
     /* $insert['FAntiguedad']=Strstr($documento->TableInfo->FAntiguedad,"T",true);
     $insert['FDesde']=Strstr($documento->TableInfo->FDesde,"T",true);
     $insert['FHasta']=Strstr($documento->TableInfo->FHasta,"T",true);
     $insert['FCaptura']=Strstr($documento->TableInfo->FCaptura,"T",true);
     $insert['FEmision']=Strstr($documento->TableInfo->FEmision,"T",true); */
     $insert['FAntiguedad']=date("Y-m-d", strtotime($documento->TableInfo->FAntiguedad));
     $insert['FDesde']=date("Y-m-d", strtotime($documento->TableInfo->FDesde));
     $insert['FHasta']=date("Y-m-d", strtotime($documento->TableInfo->FHasta));
     $insert['FCaptura']=date("Y-m-d", strtotime($documento->TableInfo->FCaptura));
     $insert['FEmision']=date("Y-m-d", strtotime($documento->TableInfo->FEmision));
     $insert['PrimaNeta']=(double)$documento->TableInfo->PrimaNeta;
     $insert['STotal']=(double)$documento->TableInfo->STotal;
     $insert['PrimaTotal']=(double)$documento->TableInfo->PrimaTotal;
     $insert['Moneda']=(string)$documento->TableInfo->Moneda;
     $insert['PrimaNetaNueva']=(double)$_POST['primaNueva'];
    $insert['otPosterior']=$DocumentoVigente;//(string)$vigente->TableInfo->Documento;
     $insert['IDDoctoPosterior']=$IDDoctoVigente;//(int)$vigente->TableInfo->IDDocto;
     $insert['IDVend']=$IDVendVigente;//(int)$vigente->TableInfo->IDVend;
     $insert['EjecutNombre']=$EjecutNombreVigente;//(string)$vigente->TableInfo->EjecutNombre; 
     $insert['EjecutNombre']=(string)$documento->TableInfo->EjecutNombre;
     $insert['emailUserAplica']=$this->tank_auth->get_usermail();
     $insert['idPersonaAplica']=$this->tank_auth->get_idPersona();
     $insert['GerenciaNombre']=(string)$documento->TableInfo->GerenciaNombre;
     $insert['Grupo']=(string)$documento->TableInfo->Grupo;
     $insert['SubGrupo']=(string)$documento->TableInfo->SubGrupo;
     $insert['VendNombre']=(string)$documento->TableInfo->VendNombre;
     $insert['RamosNombre']=(string)$documento->TableInfo->RamosNombre;
     $insert['SRamoNombre']=(string)$documento->TableInfo->SRamoNombre;
     $insert['AgenteNombre']=(string)$documento->TableInfo->AgenteNombre;
     $insert['CAgente']=(int)$documento->TableInfo->IDDocto;

     $this->db->insert('renovacion',$insert);
      $update=array();
      //$update['IDDocto']=(string)$documento->TableInfo->IDDocto;
      $update['IDDocto']=$IDDoctoVigente;//(int)$vigente->TableInfo->IDDocto;
      $update['Concepto']='RENOVADA';
      $respuesta=$this->ws_sicas->actualizaOT($update);
     /*============ POLIZA RENOVADA========*/
     $datos['renovacion']['IDDocto']=$IDDoctoVigente;//(int)$vigente->TableInfo->IDDocto;
     $datos['renovacion']['Documento']=$DocumentoVigente;//(string)$vigente->TableInfo->Documento;
     $datos['renovacion']['DAnterior']=$DAnteriorVigente;//(string)$vigente->TableInfo->DAnterior;
     $datos['mensaje']="La renovacion exitosa";

          $this->load->library('Kpi_automaticos');
     $dataKPI['GerenciaNombre']=$insert['GerenciaNombre'];
     $dataKPI['RamosNombre']=$insert['RamosNombre'];
     $dataKPI['SRamoNombre']=$insert['SRamoNombre'];
     $dataKPI['FHasta']=$insert['FHasta'];
     $dataKPI['IDDocto']=$insert['IDDocto'];
     $dataKPI['IDVend']=$insert['IDVend'];
     $dataKPI['Grupo']=$insert['Grupo'];
     $dataKPI['SubGrupo']=$insert['SubGrupo'];
     $this->kpi_automaticos->kpiAutomatico($dataKPI,'renovacion');
   }
   else{$datos['mensaje']="Esta poliza ya esta renovada";$datos['success']=false;}
   echo json_encode($datos);
}
//----------------------------------------
function mostrarComentariosRenovacion()
{
 $datos=array();
 $datos['datos']=$this->reportes_model->mostrarComentariosRenovacion($_POST['Documento']); 
 $datos['Documento']=$_POST['Documento']; 
 $this->reportes_model->actualizarComentariosRenovacion($_POST['Documento']);
 echo json_encode($datos); 
}
//------------------------------------------
function cancelarRenovacion()
{ 
 $respuesta=array();
 $array['IDDocto']=$_POST['IDDocto'];
 $array['TipoStatus']=-1;
 $array['FCancelacion']=$_POST['fecha'];
 $array['Motivo']='POLIZA NO RENOVADA';//$_POST['motivo'];
 $array['SubMotivo']=$_POST['submotivo'];
 $this->ws_sicas->cancelacionRenovacion($array);
 $this->db->where('IDDocto',$_POST['IDDocto']);
 $actualizar['statusTXT']='Cancelada';
 $this->db->update('renovacionvigente',$actualizar);
 $respuesta['IDDocto']=$_POST['IDDocto'];
 $respuesta['mensaje']='Cancelacion correcta';
 echo json_encode($respuesta);

}
//------------------------------------------------
function ponerlaComoLista()
{
  $respuesta=array();
  $respuesta['IDDocto']=$_POST['IDDocto'];
  $respuesta['mensaje']='Actualizacion correcta'; 
  $actualizar['estaLista']=1;
  $this->db->where('IDDocto',$_POST['IDDocto']);
  $this->db->update('renovacionvigente',$actualizar);
 echo json_encode($respuesta);
}
//--------------------------------------------
//*********Ultima actualizacion 28/09/2020 Miguel


  //*** Toda Cobranza Pendiente
  function getAllCobranzaPendiente(){
          $ct=0;
          $vendedor=$this->tank_auth->get_IDVend();
          $mes=date('m');
          $year=date('Y');
          $fechaInicial='01'.'-'.$mes.'-'.$year;
          $fechaFinal=date("d-m-Y");
          $arrayCobranza['fechaInicial']=$fechaInicial;
          $arrayCobranza['fechaFinal']= $fechaFinal;
          $arrayCobranza['vendedor']=$vendedor;
          $arrayCobranza['tipoReporte']='todos';
          $arrayCobranza['tipoFecha']='FLimPago';
          $rs=$this->ws_sicas->cobranzareporte($arrayCobranza);
          $ctRojo=0;
          $ctAmarillo=0;
          $ctVerde=0;
          
          foreach ($rs as $row){
              $FLimPago=date('d-m-Y',strtotime($row->FLimPago));
              $FCorte=date('d-m-Y',strtotime($fechaFinal));

              $dias=floor((strtotime($FLimPago)-strtotime($FCorte))/86400);
              //echo "Fecha Limite: ".$FLimPago."<br>";
              //echo "Fecha Corte: ".$FCorte."<br>";
              //echo "dias: ".$dias."<br>";
             
           // }
              if($dias<=-10){
                  $ctRojo++;
              }
              if(($dias<=5)&&($dias>=-10)){
                  $ctAmarillo++;
              }
              if($dias>5){
                  $ctVerde++;
              }
               
           }
           $cobranza[0]=$ctRojo;
           $cobranza[1]=$ctAmarillo;
           $cobranza[2]=$ctVerde;
           return $cobranza;
  }


function dia()
{
  date_default_timezone_set('America/Mexico_City');
  echo(date("Y-m-d H:i:s"));
}
//-----------------------------
function companias()
{
  $this->ws_sicas->obtenerCompanias();
}
//-----------------------------
function polizaNoRenovada()
{
    $documento=$this->ws_sicas->obtenerRenovacionesFecha(null,null,null,$_POST['IDDocto'],null);
    /*============ RENOVACION==============*/
    $array=array();
     $array['IDDocto']=$_POST['IDDocto'];
     //$renovacion=$this->ws_sicas->renovacionPoliza($array);
     $vigente=array();
    // $vigente=$this->ws_sicas->obtenerRenovacionesFecha(null,null,null,$renovacion->PROCESSDATA->DATA,null);
     $insertVigente=array();
     $insertVigente['IDDocto']=(int)$documento->TableInfo->IDDocto;
     $insertVigente['Documento']=(string)$documento->TableInfo->Documento;
     $insertVigente['Solicitud']=(string)$documento->TableInfo->Documento;
     $insertVigente['DAnterior']=(string)$documento->TableInfo->DAnterior;
     $insertVigente['IDDoctoAnterior']=$_POST['IDDocto'];
     $insertVigente['IDVend']=(int)$documento->TableInfo->IDVend;
     $insertVigente['statusTXT']='No Renovada';
     $this->db->insert('renovacionvigente',$insertVigente);
     /*============ RENOVACION==============*/

 
      $update=array();
      $update['IDDocto']=(string)$documento->TableInfo->IDDocto;
      $update['Status']=4;
      $update['Concepto']='NO RENOVADA';
      $respuesta=$this->ws_sicas->actualizaOT($update);
            
     $datos=array();
     $datos['mensaje']="";
     $datos['success']=true;
     $datos['IDDocto']=$_POST['IDDocto'];
     $datos['renovacion']['IDDocto']=(int)$documento->TableInfo->IDDocto;
     $datos['renovacion']['Documento']=(string)$documento->TableInfo->Documento;
     $datos['renovacion']['DAnterior']=(string)$documento->TableInfo->DAnterior;
     $datos['mensaje']="La renovacion exitosa";
 echo  json_encode($datos);
}

//----------------------------
function GuardarSolicitudDeCobro()
{
  
   $respuesta['mensaje']='Solicitud guardada';
   $guardar['estatusCSC']=5;
   if($_POST['requiereFactura']=='true'){$_POST['datos']=$_POST['datos'].'5-;';}
   if($_POST['pasarFacturaDirecto']==1){$guardar['estatusCSC']=6;$_POST['datos']='5-;';}

   $datos=explode(';', $_POST['datos']);
   foreach ($datos as $key => $value) 
   {
     if($value!='')
     {
      $separacion=explode('-', $value);
      $guardar['idDocto']=(int)$_POST['idDocto'];
      $guardar['idRecibo']=(int)$_POST['idRecibo'];
      $guardar['idSerie']=(string)$_POST['idSerie'];
      $guardar['endoso']=(string)$_POST['endoso'];
      $guardar['documento']=(string)$_POST['documento'];
      $guardar['IDCli']=(int)$_POST['IDCli'];
      $guardar['idTipoSolicitudCobro']=(int)$separacion[0];
      $guardar['IDVend']=$_POST['IDVend'];
      $guardar['comentario']=(string)$separacion[1];      
      $guardar['requiereFactura']=0;
      if((int)$separacion[0]==0 or (int)$separacion[0]==1 or (int)$separacion[0]=='2'){if($_POST['requiereFactura']){$guardar['requiereFactura']=1;}}

      $idCSC=$this->reportes_model->cobranzasolicitudcobro($guardar);
      $tipoCobranza=$this->catalogos_model->cobranzatiposolicitudcobro((int)$separacion[0]);
      $consulta['idCobranzaComentarios']=-1;
      $consulta['idRecibo']=(int)$_POST['idRecibo'];
      $consulta['idDocto']=(int)$_POST['idDocto'];
      $consulta['idSerie']=(string)$_POST['idSerie'];
      $consulta['IDCli']=(int)$_POST['IDCli'];
      $consulta['endoso']=(string)$_POST['endoso'];
      $consulta['idCobranzaSolicitudCobro']=$idCSC;      
    $consulta['cobranzaComentarios']='Se ha generado '.$tipoCobranza[0]->SolicitudCobro.'. '.(string)$separacion[1];
   $this->reportes_model->cobranzacomentarios($consulta);
     }
   }
   if($_POST['pasarFacturaDirecto']==1){
            if($_POST['idRecibo']>0)
        {
               $consulta='select userEmail from cobranza_responsable where tipoPermiso="factura" limit 1';
      $responsable=$this->db->query($consulta)->result()[0]->userEmail;
        
         $update['estatusCSC']=6;
         $update['usuarioResponsable']=$responsable;
         $update['estaResuelta']=0;
         $this->db->where('idRecibo',$_POST['idRecibo']);
         $this->db->update('cobranzasolicitudcobro',$update);
        }
   }
   $respuesta['idDocto']=$_POST['idDocto'];
   $respuesta['idRecibo']=$_POST['idRecibo'];
   $respuesta['documento']=$_POST['documento'];
   echo json_encode($respuesta);
}
//----------------------------
function traerComentarioSolicitudCobro()
{   
   $datos=array();   
   $datos['comentarios']=$this->reportes_model->obtenerSolicitudCobroPorIdDocto($_POST['idDocto'],$_POST['idRecibo']);
   $comentarios=array();
   foreach ($datos['comentarios'] as  $value) 
   {
     if($value->tabla=='cobranzacomentarios')
     {
      $array['estaVisto']=1;
      $array['idPersona']=$this->tank_auth->get_idPersona();
      $array['idCobranzaComentarios']=$value->id;
      $this->reportes_model->actualizarCobranzaComentariosRelPersona($array);
     }
     if($value->idCobranzaSolicitudCobro==0){array_push($comentarios, $value);}
   }     
   $datos["comentarios"]=$comentarios;
   $datos['idDocto']=$_POST['idDocto'];
   $datos['documento']=$_POST['documento'];
   $datos['contenedor']=$_POST['contenedor'];  
   echo json_encode($datos);
}


//----------------------------
function cambiarSolicitudCobro()
{
 $respuesta=array();
$respuesta['mensaje']='Cambio Guardado';
/*$actualizar['idCobranzaSolicitudCobro']=$_POST['idCobranzaSolicitudCobro'];
$actualizar['estaResuelta']=1;
$this->reportes_model->actualizarcobranzasolicitudcobro($actualizar);*/
$rehabilitar=false;
  if(isset($_POST['rehabilitar'])){$respuesta['rehabilitar']=$_POST['rehabilitar'];$rehabilitar=true;}

$this->reportes_model->cambiarResueltaCSC($_POST['idRecibo'],$_POST['status'],$rehabilitar,$_POST['comentario']);
 $datos=$this->reportes_model->comprobarSoicitudCobro($_POST['idDocto']); 
 $respuesta['existeCobranzaConSolicitud']=$datos[0]->bandera;
 $respuesta['idDocto']=$_POST['idDocto'];
  $respuesta['idRecibo']=$_POST['idRecibo'];
 //$respuesta['idCobranzaSolicitudCobro']=$_POST['idCobranzaSolicitudCobro'];
  $respuesta['status']=$_POST['status'];
  $respuesta['IDVend']=$this->tank_auth->get_IDVend();

 echo json_encode($respuesta);
}
//---------------------------
function cambiarStatusSolicitudDeCobro()
{
  
  $array['idRecibo']=$_POST['idRecibo'];
  $array['estatusCSC']=$_POST['status'];
  $array['comentario']=$_POST['comentario'];
  $info=$this->reportes_model->cambiarStatusSolicitudDeCobro($array);
  
  $respuesta['mensaje']=$info['mensaje'];
  $respuesta['success']=$info['succes'];
  $comentario='';
  if($_POST['status']==5 || $_POST['status']==6){$respuesta['classRemover']='classTieneAgente';$respuesta['classAgregar']='classTieneEjecutivo';$comentario='LA SOLICITUD DE COBRANZA PASO AL AJECUTIVO CORRESPONDIENTE';}
  else{$respuesta['classRemover']='classTieneEjecutivo';$respuesta['classAgregar']='classTieneAgente';$comentario='LA SOLICITUD DE COBRANZA PASO AL AGENTE';}


  /* $consulta['idCobranzaComentarios']=-1;
   $consulta['cobranzaComentarios']=$comentario;
   $consulta['idRecibo']=$_POST['IDRecibo'];
   $consulta['idDocto']=$_POST['idDocto'];
   $consulta['idSerie']=$_POST['serie'];
   $consulta['IDCli']=$_POST['IDCli'];
   $consulta['endoso']=$_POST['endoso'];
   $this->reportes_model->cobranzacomentarios($consulta);*/



 echo json_encode($respuesta);
}
//---------------------------
function obtenerSeguimientoActividades()
{
  $datos=array();
  $consulta="select c.*,a.Status_Txt from cobranzaactividad c left join actividades a on a.idInterno=c.idActividad where c.status=1";
  $datos['seguimientoActividades']=$this->db->query($consulta)->result();
  echo json_encode($datos);
}

//-------------------------
function traerDocumentosCliente()
{
  $respuesta['mensaje']='No tiene documentos personales';
  $data['IDValuePK']=$_POST['IDCli'];
  $documentos=$this->ws_sicas->GetCDDigitalCliente($data);
  $respuesta['documentosCliente']=array();
  if(isset($documentos['children'])){
  foreach ($documentos['children'] as $key => $value) 
  {
    if($value['isFolder']==1){break;}
    else
    {  
      $dat=array();
      $dat['href']=$value['href'];
      $dat['text']=$value['text'];
      array_push($respuesta['documentosCliente'], $dat); 
    }
  }
  }
  else
  {
        $dat=array();
      $dat['href']='';
      $dat['text']='NO CUENTA CON DOCUMENTOS';
      array_push($respuesta['documentosCliente'], $dat); 
  }
  $respuesta['telCliente']=array();
  $respuesta['emailCliente']=array();
  $contactoCliente=$this->ws_sicas->obtenerClienteInfo($_POST['IDCli']);  
  foreach ($contactoCliente as $value) 
  {
   if(isset($value->Telefono1)){array_push($respuesta['telCliente'],(string)$value->Telefono1);}
   if(isset($value->Telefono2)){array_push($respuesta['telCliente'],(string) $value->Telefono2);}
   if(isset($value->Telefono3)){array_push($respuesta['telCliente'],(string) $value->Telefono3);}
   if(isset($value->Telefono4)){array_push($respuesta['telCliente'],(string) $value->Telefono4);}
   if(isset($value->EMail1)){array_push($respuesta['emailCliente'],(string)$value->EMail1);}
    if(isset($value->EMail2)){array_push($respuesta['emailCliente'],(string)$value->EMail2);}
  }
   
  echo json_encode($respuesta);
}
//--------------------------
function historialEnviosPorUsuario()
{
  $respuesta=array();
  $respuesta['envios']=array();  
  $consulta="select c.*,(if(c.envioDestinoCH is null,'',c.envioDestinoCH)) as envioDestino,(DATE_FORMAT(cast(c.fechaCreacionCH as date),'%d-%m-%Y') )as fechaCreacion,(DATE_FORMAT(c.fechaCreacionCH,'%d-%m-%Y_%H:%i:%s') )as fechaCreacionHora,cl.NombreCompleto   from cobranzahistorial c left join clientelealtadpuntos cl on cl.IDCli=c.IDCli ";
  
  if($_POST['anio']=='' and $_POST['mes']=='')
  {
    $consulta.="where email='".$this->tank_auth->get_usermail()."' order by fechaCreacionHora desc";
    $respuesta['envios']=$this->db->query($consulta)->result();
     
  }
  else
  {
    if($_POST['mes']!='' and $_POST['anio']!='')
    {
            $consulta.="where year(c.fechaCreacionCH)=".$_POST['anio']." and month(c.fechaCreacionCH)=".$_POST['mes']." and email='".$this->tank_auth->get_usermail()."' order by fechaCreacionHora desc";
            
      $respuesta['envios']=$this->db->query($consulta)->result();
    }
    else
    {
      if($_POST['mes']!=''){$respuesta['mensajeAnio']='SELECCIONE AÑO';}
      else{$consulta.="where year(c.fechaCreacionCH)=".$_POST['anio']."  and email='".$this->tank_auth->get_usermail()."' order by fechaCreacionHora desc";
      $respuesta['envios']=$this->db->query($consulta)->result();
      }
     
    }
  }

  $respuesta['succes']='';
  echo json_encode($respuesta); 
}
//-------------------------
function eliminarActividadEndoso()
{
  $respuesta['mensaje']='Eliminacion correcta';
   $this->db->query('update cobranzaactividad set status=0 where folioActividad="'.$_POST['folioActividad'].'"');
  echo json_encode($respuesta);
}
//-------------------------
function guardarContactoCliente()
{ 
  $respuesta['success']=true;
  $respuesta['mensaje']='';
  if(isset($_POST['tipoContactoID']))
  {
    
   $respuesta=array();
   $respuesta['success']=true;
   $respuesta['mensaje']='LA INFORMACION SE GUARDO EXITOSAMENTE';
   if($_POST['tipoContactoID']==3)
   {    
    if(!filter_var($_POST['tipoContacto'], FILTER_VALIDATE_EMAIL)){$respuesta['mensaje']='EL CORREO NO ES VALIDO';$respuesta['success']=false;}
   }
   else
   {
    if(!$this->comprobarNumero($_POST['tipoContacto'])){$respuesta['mensaje']='EL TELEFONO O CELULAR NO ES VALIDO';$respuesta['success']=false;}                
    }
    if($respuesta['success'])
    {
      $insert['idTipoContacto']=$_POST['tipoContactoID'];
      $insert['IDCli']=$_POST['IDCli'];
      $insert['contacto']=$_POST['tipoContacto'];
      $insert['comentario']=$_POST['comentario'];
      $insert['userEmail']=$this->tank_auth->get_usermail();

     // if(isset($_POST['nombrePuestoOcupado'])){$insert['nombrePuestoOcupado']=$_POST['nombrePuestoOcupado'];}
      if(isset($_POST['nombreContacto'])){$insert['nombreContacto']=$_POST['nombreContacto'];}      
      $this->db->insert('clientelealtadtipocontacto',$insert);

    }
   }
   if(isset($_POST['idClienteLealtadTipoContacto']))
   {
    if(isset($_POST['delete']))
    {
      $delete='delete from clientelealtadtipocontacto where idClienteLealtadTipoContacto='.$_POST['idClienteLealtadTipoContacto'];
      $this->db->query($delete);
         $respuesta['mensaje']='EL REGISTRO SE HA BORRADO CORRECTAMENTE';
    }
   }
   $respuesta['informacion']=$this->db->query('select ctc.*,ct.tipoContacto from clientelealtadtipocontacto ctc left join catalog_tipocontacto ct on ct.idTipoContacto=ctc.idTipoContacto where ctc.IDCli='.$_POST['IDCli'])->result();
   
   $respuesta['datosAgrupados']=array();
   
   $i=0;
  foreach ($respuesta['informacion'] as $key => $value) 
   {
    if(!isset($respuesta['datosAgrupados'][$value->nombreContacto]))
      {
        $respuesta['datosAgrupados'][$value->nombreContacto]=new stdClass();    
        $respuesta['datosAgrupados'][$value->nombreContacto]->comentario=$value->comentario;
        $respuesta['datosAgrupados'][$value->nombreContacto]->nombreContacto=$value->nombreContacto;
        $respuesta['datosAgrupados'][$value->nombreContacto]->nombrePuestoContacto=$value->nombrePuestoContacto;
      }
      
     switch ($value->idTipoContacto) 
     {
       case 1:
       if(!isset($respuesta['datosAgrupados'][$value->nombreContacto]->Telefono[$i])){$respuesta['datosAgrupados'][$value->nombreContacto]->Telefono[$i]=new stdClass;}
          $respuesta['datosAgrupados'][$value->nombreContacto]->Telefono[$i]->Contacto=$value->contacto;
          $respuesta['datosAgrupados'][$value->nombreContacto]->Telefono[$i]->idClienteLealtadTipoContacto=$value->idClienteLealtadTipoContacto;
          $respuesta['datosAgrupados'][$value->nombreContacto]->Telefono[$i]->idTipoContacto=1;
       break;      
       case 2:
               if(!isset($respuesta['datosAgrupados'][$value->nombreContacto]->Celular[$i])){$respuesta['datosAgrupados'][$value->nombreContacto]->Celular[$i]=new stdClass;}
          $respuesta['datosAgrupados'][$value->nombreContacto]->Celular[$i]->Contacto=$value->contacto;
          $respuesta['datosAgrupados'][$value->nombreContacto]->Celular[$i]->idClienteLealtadTipoContacto=$value->idClienteLealtadTipoContacto;
          $respuesta['datosAgrupados'][$value->nombreContacto]->Celular[$i]->idTipoContacto=2;
       break;
       case 3:
               if(!isset($respuesta['datosAgrupados'][$value->nombreContacto]->Correo[$i])){$respuesta['datosAgrupados'][$value->nombreContacto]->Correo[$i]=new stdClass;}
          $respuesta['datosAgrupados'][$value->nombreContacto]->Correo[$i]->Contacto=$value->contacto;
          $respuesta['datosAgrupados'][$value->nombreContacto]->Correo[$i]->idClienteLealtadTipoContacto=$value->idClienteLealtadTipoContacto;
          $respuesta['datosAgrupados'][$value->nombreContacto]->Correo[$i]->idTipoContacto=3;
       break;
    }

    /*$respuesta['datosAgrupados'][$i]->idClienteLealtadTipoContacto='';//$value->idClienteLealtadTipoContacto;
    $respuesta['datosAgrupados'][$i]->nombrePuestoContacto='';//$value->nombrePuestoContacto;
    $respuesta['datosAgrupados'][$i]->IDCli=$_POST['IDCli'];    
    $respuesta['datosAgrupados'][$i]->Telefono=$this->db->query('select ctc.*,ct.tipoContacto from clientelealtadtipocontacto ctc left join catalog_tipocontacto ct on ct.idTipoContacto=ctc.idTipoContacto where ct.idTipoContacto=1 and ctc.IDCli='.$_POST['IDCli'])->result();
        $respuesta['datosAgrupados'][$i]->Celular=$this->db->query('select ctc.*,ct.tipoContacto from clientelealtadtipocontacto ctc left join catalog_tipocontacto ct on ct.idTipoContacto=ctc.idTipoContacto where ct.idTipoContacto=2 and ctc.IDCli='.$_POST['IDCli'])->result();
            $respuesta['datosAgrupados'][$i]->Correo=$this->db->query('select ctc.*,ct.tipoContacto from clientelealtadtipocontacto ctc left join catalog_tipocontacto ct on ct.idTipoContacto=ctc.idTipoContacto where ct.idTipoContacto=3 and ctc.IDCli='.$_POST['IDCli'])->result();*/
    
    $i++;
   }


  echo json_encode($respuesta);
}

//----------------------------------------
function traerRenovacionesReporte()
{
 $informacion=array();
 $informacion['success']=true;
 $informacion['renovaciones']=array();
 $vendedor=$this->tank_auth->get_IDVend();
 $fecIni=$this->libreriav3->convierteFecha($_POST['fechaInicial']);
 $fecFin=$this->libreriav3->convierteFecha($_POST['fechaFinal']);
 
 $renovaciones=$this->ws_sicas->obtenerRenovacionesFecha($vendedor,$fecIni,$fecFin,null,null,$_POST['canal']);
 if(isset($renovaciones->TableInfo))
 { 
   foreach ($renovaciones->TableInfo as  $value) {
     array_push($informacion['renovaciones'], $value);
   }
   
  //$informacion['renovaciones']=$renovaciones->TableInfo;
 }


 /*$informacion['renovacionvigente']=$this->reportes_model->renovacionvigente();
 $informacion['renovacionpendiente']=$this->reportes_model->renovacionPendienteMesAnio();

foreach ($informacion['renovaciones']->TableInfo as  $value) 
{   $select['IDDocto']=(string)$value->IDDocto;
     $respuesta= $this->reportes_model->renovacionpre($select);
     $esAgenteColaborador=$this->personamodelo->obtenerVendedorPorIDVend($value->IDVend);
     $value->esAgenteColaborador="";
     foreach ($esAgenteColaborador as $es) {
     $agenteCol=(string)$es['esAgenteColaborador']; 
     $value->esAgenteColaborador=$agenteCol;
       # code...
     }
      $value->renovacionpre=0;
      if(count($respuesta)>0){$value->renovacionpre=1;}   
 
}*/
 echo json_encode($informacion);
}
//-----------------------------------------------------------
 function traerArchivosReporte()
 {
  
  if($_POST['documentoTipo']=='docP')
  {
    $docPosterior=$this->ws_sicas->buscaDocumento($_POST['documento']);
    if(isset($docPosterior->TableInfo))
    {
    }  
    $_POST["IDDocto"]=(string)$docPosterior->TableInfo->IDDocto;
  }


   $respuesta['datos']=array(); 
        $idDocto = $_POST["IDDocto"]; 
        $data = array("IDDocto" => $idDocto);
        $data_result = $this->ws_sicas->GetCDDigital($data); 
        
  $respuesta['documento']=$_POST['documento'];
  $respuesta['IDDocto']=$_POST['IDDocto'];
  $respuesta['IDCli']=$_POST['IDCli'];
  $respuesta['email']=(string)$_POST['email'];
  $respuesta['archivos']=$data_result;
echo json_encode($respuesta);
}

//------------------------
function guardarTelefonoEnDocumentoCliente()
{
  $respuesta=array();
  $respuesta['mensaje']='LA INFORMACION SE GUARDO CORRECTAMENTE';
  $consulta='select * from clientelealtadtipocontacto c where c.idTipoContacto='.$_POST['tipoContacto'].' and c.IDCli='.$_POST['idcli'].' and c.contacto="'.$_POST['contacto'].'"';
  
  $validaExistencia=$this->db->query($consulta)->result();
  $delete='';
  if(count($validaExistencia)>0)
  {
    if($_POST['tipoContacto']==1 || $_POST['tipoContacto']==2)
    {
      $delete='delete from  clientelealtadtipocontactodocumento where idCli='.$_POST['idcli'].' and documento="'.$_POST['documento'].'" and tipoContacto in (1,2)';
    }
    else
    {
     $delete='delete from  clientelealtadtipocontactodocumento where idCli='.$_POST['idcli'].' and documento="'.$_POST['documento'].'" and tipoContacto=3'; 
    }
    $this->db->query($delete);
     $insert['idDocto']=$_POST['iddocto'];
     $insert['idRecibo']=$_POST['idrecibo'];
     $insert['idCli']=$_POST['idcli'];
     $insert['idContacto']=$_POST['idcontacto'];
     $insert['tipoContacto']=$_POST['tipoContacto'];
     $insert['contacto']=$_POST['contacto'];
     $insert['documento']=$_POST['documento'];
     $this->db->insert('clientelealtadtipocontactodocumento',$insert);
  }
  else{$respuesta['mensaje']='SE PRESENTO UN ERRO AL GRABAR LA INFORMACION EN EL CLIENTE NOTIFIQUE A SISTEMAS';}
  

  echo json_encode($respuesta);



}
//----------------------------
function enviarDocumentosDesdeRenovacion()
{
  $respuesta['success']=true;
  $respuesta['mensaje']='EL CORREO FUE ENVIADO DE MANERA CORRECTA';
     $filtroEmail=0;    
     $filtroEmail=filter_var($_POST['email'], FILTER_VALIDATE_EMAIL);
     

 
     //$array['idRecibo']='';
     //$array['status']=0;

    if($filtroEmail)
    {
           $insert['tipoEnvioCH']='envio_correos';
     $insert['hRefCH']='';
     $insert['idRecibo']='';
     $insert['idSerie']='';
     $insert['idDocto']=$_POST['IDDocto'];
     $insert['IDCli']=$_POST['IDCli'];
     $insert['envioDestinoCH']=$_POST['email'];
     $insert['idCobranzaHistorial']=-1;
     $insert['documento']=$_POST['documento'];
     $insert['endoso']='';
     $insert['email']=$this->tank_auth->get_usermail();   

        $primerHREF='';
        $mensaje='';
         $arrayHREF=explode(',', $_POST['dirDocumentos']);
         $cont=0;
         $mensajeEncabezado='<div><h3>ESTIMADO CLIENTE ESTOS DOCUMENTO SE HAN ENVIADO DESDE CAPITAL SEGUROS Y FIANZAS</h3></div><br><br>';
         foreach ($arrayHREF as  $value) 
         { 
           if($value!='')
           {
            $cont++;
            if($cont==1){$primerHREF=$value;}
            $arrayHREF=explode('/', $value);
            $cont=count($arrayHREF);
            $cont--;
            
            $mensaje.='<div><a href="'.$value.'">'.$arrayHREF[$cont].'</a></div><br>';
           }
         }

        
        if($mensaje!='')
        {
         $insert['hRefCH']=$primerHREF;
         $insert['fueEnviado']=0;
         $insert['comentarioDelEnvio']="EN PROCESO";
         $insert['conjuntoHRefch']=$_POST['dirDocumentos'];

         
         $idCobranzaHistorial=$this->reportes_model->cobranzaHistorial($insert);   
         $guardaMensaje['desde']="Avisos de GAP<avisosgap@aserorescpital.com>";
         $guardaMensaje['para']=$_POST['email'];
         $guardaMensaje['mensaje']=$mensajeEncabezado.$mensaje;
         $guardaMensaje['asunto']='Documentos';
         $guardaMensaje['identificaModulo']='cobranzahistorial-'.$idCobranzaHistorial;            
         $guardaMensaje['tabla']='cobranzahistorial';
         $guardaMensaje['idTabla']=$idCobranzaHistorial;
         $guardaMensaje['campoParaActualizar']='fueEnviado';
         $guardaMensaje['campoLlavePrimaria']='idCobranzaHistorial';         
         $array['status']=1;        
         $this->email_model->enviarCorreo($guardaMensaje);
        }
       
   }
   else{$respuesta['mensaje']='EL CORREO NO ES VALIDO';}
echo json_encode($respuesta);
}
//----------------------------
function anexarPuesEmpTelEmailGenerales()
{
  if(isset($_POST['nombrePuesto']))
  {
    $insert['contactoPuesto']=$_POST['nombrePuesto'];
    $datos['mensaje']='GUARDADO CON EXITO';
    $datos['contactoPuesto']=strtoupper($_POST['nombrePuesto']);
    $datos['nombrePuesto'] = $this->catalogos_model->catalog_contactopuesto($insert);
  }
  else
  {
   $datos['nombrePuesto'] = $this->catalogos_model->catalog_contactopuesto(); 
  }
 echo json_encode($datos);
}
//---------------------------
function agregarNombreDelContactoParaEmpresa()
{
  $respuesta=array();
   
  if(isset($_POST['nombreContacto']))
  {
   $respuesta['mensaje']='EL GUARDADO SE REALIZO CON EXITO';
   $nombre=mb_strtoupper($_POST['nombreContacto']);
   $consulta='select (count(c.nombreContacto)) as total from clientelealtadnombrecontacto c where c.nombreContacto="'.$nombre.'" and IDCli='.$_POST['IDCli'];
   $verifica=$this->db->query($consulta)->result()[0]->total;
   
   if($verifica==0)
    {
     $insert['nombreContacto']=$nombre;
     $insert['IDCli']=$_POST['IDCli'];
     $insert['nombrePuesto']=$_POST['nombrePuesto'];
     $insert['userEmail']=$this->tank_auth->get_usermail();
     $this->db->insert('clientelealtadnombrecontacto',$insert);
    }
    else{$respuesta['mensaje']='YA EXISTE UN CONTACTO CON ESTE NOMBRE';}
   $respuesta['seccess']=1;
  }
 $respuesta['informacion']=$this->db->query('select * from clientelealtadnombrecontacto where IDCli='.$_POST['IDCli'])->result();
 echo json_encode($respuesta);
}

//----------------------------
function actualizarRenovacionVigente()
{
  $consulta="select * from renovacionvigente where  RamosNombre is null and IDDocto>0  limit 100";
  $datos=$this->db->query($consulta)->result();
  foreach ($datos as  $value) 
  {
    $datos=$this->ws_sicas->buscarDocumentoPorIDSicas($value->IDDocto);
    
    if(isset($datos->TableInfo))
    {
        $update['RamosNombre']=(string)$datos->TableInfo[0]->RamosNombre;
        $update['SRamoNombre']=(string)$datos->TableInfo[0]->SRamoNombre;
        $this->db->where('IDDocto',$value->IDDocto);
        $this->db->update('renovacionvigente',$update);
      

    }
    
  }

}

//---------------------------
function verificaDocumentosConComentarios()
{
  $respuesta['success']=true;
  $respuesta['cobranzaComentario']=array();
  $respuesta['renovacionComentario']=array();
  $consulta='select distinct(c.idRecibo) from cobranzacomentarios c where c.idDocto='.$_POST['IDDocto'];
   $respuesta['cobranzaComentario']=$this->db->query($consulta)->result();
   $consulta='select (count(IDDocto)) total from renovacioncomentario c where c.IDDocto='.$_POST['IDDocto'];
  $respuesta['renovacionComentario']=$this->db->query($consulta)->result();
  echo json_encode($respuesta);
}
//---------------------------
function buscarComentariosCobranzaRenovacion()
{
  $respuesta['success']=true;
  $respuesta['bitacora']=array();
  $consulta='';
  if($_POST['tipo']=='recibo')
  {
    $consulta="select (c.cobranzaComentarios) as comentario,(c.fechaCreacionCC) as fecha,(c.emailUser) as emailUsers,
(DATE_FORMAT(c.fechaCreacionCC,'%d %M %Y')) as fec,
concat(hour(c.fechaCreacionCC),':',minute(c.fechaCreacionCC),':',second(c.fechaCreacionCC)) as hora 
from cobranzacomentarios c 
where c.idRecibo=".$_POST['idRecibo']." order by c.fechaCreacionCC desc";
 
 
  }
  else
  {
    $consulta="select c.comentario,c.fecha,p.emailUsers,(DATE_FORMAT(c.fecha,'%d %M %Y')) as fec,concat(hour(c.fecha),':',minute(c.fecha),':',second(c.fecha)) as hora from renovacioncomentario c left join persona p on p.idPersona=c.idPersona
where c.IDDocto=".$_POST['idDocto']." order by c.fecha desc";
   
  }
   $respuesta['bitacora']=$this->db->query($consulta)->result();
  echo json_encode($respuesta);
}
//---------------------------
function actividades()
{
  $i=0;
  $anio=2019;
  $email=$this->tank_auth->get_usermail();
  $idPersona=$this->tank_auth->get_idPersona();
  $consulta="select * from actividades a  where year(a.fechaCreacion)=".$anio." ORDER BY a.idInterno  LIMIT 1000 OFFSET ".$i;
  $actividades=$this->db->query($consulta)->result();
  while(count($actividades)>0)
  {
   
   $i=$i+1000;
      foreach ($actividades as  $value) 
      {
        //---------RESPALDA actividadescambiosestado
        $actividadesCambiosEstado=$this->db->query('select * from actividadescambiosestado where idInterno='.$value->idInterno)->result();
        if(count($actividadesCambiosEstado)>0)
        {
         
         foreach ($actividadesCambiosEstado as $valueCE) 
           {
              $json=json_encode($valueCE);
              $insert['tabla']='actividadescambiosestado';
              $insert['datos']=$json;
              $insert['email']=$email;
              $insert['idPersona']=$idPersona;
              $insert['fechaInsercionBD']=$valueCE->fechaInsercion;
              $insert['idTablaPadre']=$value->idInterno;
              $insert['tablaPadre']='actividades';
              $this->db->insert('papelera',$insert);

           } 
           $this->db->where('idInterno',$value->idInterno);
           #$this->db->delete('actividadescambiosestado');
        }
        //-------------------------------------------
        //---------RESPALDA actividadescerrados
        $actividadesCerrados=$this->db->query('select * from actividadescerrados where idInterno='.$value->idInterno)->result();
                if(count($actividadesCerrados)>0)
        {
         
        foreach ($actividadesCerrados as $valueC) 
        {
              
              $insert['tabla']='actividadescerrados';
              $insert['datos']=json_encode($valueC);
              $insert['email']=$email;
              $insert['idPersona']=$idPersona;
              $insert['fechaInsercionBD']=$valueC->fecha;
              $insert['idTablaPadre']=$value->idInterno;
              $insert['tablaPadre']='actividades';
              $this->db->insert('papelera',$insert);
        }
                    $this->db->where('idInterno',$value->idInterno);
           #$this->db->delete('actividadescerrados');
        }
        //-------------------------------------------

        //---------RESPALDA actividadescomentariooperativo
        $actividadesComentarioOperativo=$this->db->query('select * from actividadescomentariooperativo where idInterno='.$value->idInterno)->result();
                if(count($actividadesComentarioOperativo)>0)
        {
         
        foreach ($actividadesComentarioOperativo as $valueCO) 
        {
              
              $insert['tabla']='actividadescomentariooperativo';
              $insert['datos']=json_encode($valueCO);
              $insert['email']=$email;
              $insert['idPersona']=$idPersona;
              $insert['fechaInsercionBD']=$valueCO->fechaInsercion;
              $insert['idTablaPadre']=$value->idInterno;
              $insert['tablaPadre']='actividades';
              $insert['idTabla']=$valueCO->idACO;
              $this->db->insert('papelera',$insert);
        }
                    $this->db->where('idInterno',$value->idInterno);
           #$this->db->delete('actividadescomentariooperativo');
        }
        //-------------------------------------------

        //---------RESPALDA actividadescomentarios
        $actividadesComentarios=$this->db->query('select * from actividadescomentarios where folioActividad="'.$value->folioActividad.'"')->result();
                if(count($actividadesComentarios)>0)
        {
         
        foreach ($actividadesComentarios as $valueC) 
        {
              
              $insert['tabla']='actividadescomentarios';
              $insert['datos']=json_encode($valueC);
              $insert['email']=$email;
              $insert['idPersona']=$idPersona;
              $insert['fechaInsercionBD']=$valueC->fechaInsercion;
              $insert['idTablaPadre']=$value->folioActividad;
              $insert['tablaPadre']='actividades';
              $insert['idTabla']=$valueC->idComentario;
              $this->db->insert('papelera',$insert);
        }
                    $this->db->where('folioActividad',$value->folioActividad);
           #$this->db->delete('actividadescomentarios');
        }
        //-------------------------------------------


        //---------RESPALDA actividadesenrojo
        $actividadesRojo=$this->db->query('select * from actividadesenrojo where idInterno="'.$value->idInterno.'"')->result();
                if(count( $actividadesRojo)>0)
        {
         
        foreach ($actividadesRojo as $valueC) 
        {
              
              $insert['tabla']='actividadesenrojo';
              $insert['datos']=json_encode($valueC);
              $insert['email']=$email;
              $insert['idPersona']=$idPersona;
              $insert['fechaInsercionBD']=$valueC->fechaInsercion;
              $insert['idTablaPadre']=$value->idInterno;
              $insert['tablaPadre']='actividades';
              $insert['idTabla']=$valueC->idAcatividadesEnRojo;
              $this->db->insert('papelera',$insert);
        }
                    $this->db->where('idInterno',$value->idInterno);
           #$this->db->delete('actividadesenrojo');
        }
        //-------------------------------------------

        //---------RESPALDA actividadespartidas
        $actividadesPartidas=$this->db->query('select * from actividadespartidas where idInterno="'.$value->idInterno.'"')->result();
                if(count($actividadesPartidas)>0)
        {
         
        foreach ($actividadesPartidas as $valueC) 
        {
              
              $insert['tabla']='actividadespartidas';
              $insert['datos']=json_encode($valueC);
              $insert['email']=$email;
              $insert['idPersona']=$idPersona;
              $insert['fechaInsercionBD']=$valueC->fechaGrabado;
              $insert['idTablaPadre']=$value->idInterno;
              $insert['tablaPadre']='actividades';
              $insert['idTabla']=$valueC->idPartida;
              $this->db->insert('papelera',$insert);
        }
                    $this->db->where('idInterno',$value->idInterno);
           #$this->db->delete('actividadespartidas');
        }
        //-------------------------------------------
        //---------RESPALDA calificacionactividad
        $actividadesCalifica=$this->db->query('select * from calificacionactividad where idInternoActividad="'.$value->idInterno.'"')->result();
                if(count($actividadesCalifica)>0)
        {
         
        foreach ($actividadesCalifica as $valueC) 
        {
              
              $insert['tabla']='calificacionactividad';
              $insert['datos']=json_encode($valueC);
              $insert['email']=$email;
              $insert['idPersona']=$idPersona;
              $insert['fechaInsercionBD']=$valueC->fechaCalificacionActividad;
              $insert['idTablaPadre']=$value->idInterno;
              $insert['tablaPadre']='actividades';
              $insert['idTabla']=0;
              $this->db->insert('papelera',$insert);
        }
                    $this->db->where('idInternoActividad',$value->idInterno);
           #$this->db->delete('calificacionactividad');
        }
        //-------------------------------------------
        //---------RESPALDA actividadescomentarios
        $actividadesPromo=$this->db->query('select * from relactividadpromotoria where folioActividad="'.$value->folioActividad.'"')->result();
                if(count($actividadesPromo)>0)
        {
         
        foreach ($actividadesPromo as $valueC) 
        {
              
              $insert['tabla']='relactividadpromotoria';
              $insert['datos']=json_encode($valueC);
              $insert['email']=$email;
              $insert['idPersona']=$idPersona;
              $insert['fechaInsercionBD']=$valueC->fechaRAP;
              $insert['idTablaPadre']=$value->folioActividad;
              $insert['tablaPadre']='actividades';
              $insert['idTabla']=$valueC->idRelActividadPromotoria;
              $this->db->insert('papelera',$insert);
        }
                    $this->db->where('folioActividad',$value->folioActividad);
           #$this->db->delete('relactividadpromotoria');
        }
        //-------------------------------------------



              $insert['tabla']='actividades'; 
              $insert['datos']=json_encode($value);
              $insert['email']=$email;
              $insert['idPersona']=$idPersona;
              $insert['fechaInsercionBD']=$value->fechaCreacion;
              $insert['idTablaPadre']=0;
              $insert['tablaPadre']='';
              $insert['idTabla']=$valueC->idInterno;
              $this->db->insert('papelera',$insert);
    }//forEach $actividades
  $consulta="select * from actividades a  where year(a.fechaCreacion)=".$anio." ORDER BY a.idInterno  LIMIT 1000 OFFSET ".$i;
  $actividades=$this->db->query($consulta)->result();

  }
   
}
function obtR()
{
  $val=$this->ws_sicas->cobranzareportePrueba('CL22955600-0');

}
function bitl()
{

  $linkCorto=$this->whatssms->obtenerLink("https://www.google.com/search?q=traductor&client=opera&hs=7Cs&sxsrf=APwXEdfiKSyLbPBeu5YnRdlpHnbeMaZiYw%3A1683820676131&ei=hBBdZPnIB-7KkPIPk9OJ0AY&ved=0ahUKEwj5mpDq0O3-AhVuJUQIHZNpAmoQ4dUDCA4&uact=5&oq=traductor&gs_lcp=Cgxnd3Mtd2l6LXNlcnAQAzIHCCMQigUQJzINCAAQigUQsQMQgwEQQzIHCAAQigUQQzINCAAQigUQsQMQgwEQQzIKCAAQigUQsQMQQzIFCAAQgAQyCwgAEIAEELEDEIMBMgUIABCABDILCAAQgAQQsQMQgwEyBQgAEIAEOgoIABBHENYEELADOgQIIxAnOhEILhCABBCxAxCDARDHARDRAzoLCAAQigUQsQMQgwE6CAgAEIAEELEDSgQIQRgAUKIHWMIQYMAZaARwAXgAgAGZAYgBtgiSAQMwLjmYAQCgAQHIAQjAAQE&sclient=gws-wiz-serp");   
}
function comprimir()
{
  $cadena = 'https://www.sicasonline.info/SICASData/SICAS1325/Storage/CONT000026266/Cliente/DOC0001517393/CARATULA-FACTURA%20XML-202305111140.xml';


  // Comprimir la cadena
$comprimir = gzcompress($cadena);
echo "Tamaño original: ". strlen($cadena)."\n";
// Resultado: 1240
echo "Tamaño comprimido: ". strlen($comprimir)."\n";
// Resultado: 479
  echo $comprimir;
}
//-----------------------------------------------------------
function devolverCobranzaPendiente()
{

  $respuesta['success']=true;
  $respuesta['cobranzaPendienteActiva']=array();
    $respuesta['cobranzaPendiente']=array(); 
  $solCobroIDString="";
  $idReciboExiste=array();       
  (isset($_POST['notInIdRecibos']))? $solCobro=$this->reportes_model->obtenerSolicitudCobroActivos($_POST):$solCobro=$this->reportes_model->obtenerSolicitudCobroActivos();    

      if(count($solCobro)>0)
        {
          foreach ($solCobro as $value) {$solCobroIDString.=$value->idRecibo.'|';array_push($idReciboExiste, $value->idRecibo);}
          $cobranzaPendienteActiva=$this->ws_sicas->cobranzaReportePorRecibo($solCobroIDString.'|');
          
          if(isset($cobranzaPendienteActiva->TableInfo))
            {              
              //if((string)$cobranzaPendienteActiva->TableInfo != ''){
              if(!empty($cobranzaPendienteActiva->TableInfo)){
                foreach ($cobranzaPendienteActiva->TableInfo as  $value) {array_push($respuesta['cobranzaPendienteActiva'], $value);}   
              }          
            }
        }
  $email=$this->tank_auth->get_usermail();

  if($_POST['obtenerCobranzaPendiente'])  
  {
  $fi=$this->libreriav3->convierteFecha($_POST['fechaInicial']);
  $ff=$this->libreriav3->convierteFecha($_POST['fechaFinal']);
  $arrayCobranza['fechaInicial']=$fi;
  $arrayCobranza['fechaFinal']=$ff;
  $arrayCobranza['vendedor']=0;
  $arrayCobranza['tipoReporte']=$_POST['tipoReporte'];
  $arrayCobranza['tipoFecha']=$_POST['tipoFecha'];          
  $cobranzaPendienteTem=$this->ws_sicas->cobranzareporte($arrayCobranza,1);  
  foreach ($cobranzaPendienteTem as $value) 
   {

    if(!in_array($value->IDRecibo,$idReciboExiste))
    {
        if($value->IDRecibo!=null){
          $filtroConsulta=" and idRecibo=".$value->IDRecibo." and idSerie='".$value->Serie."' and email='".$email."'";
          $historialEnvio=$this->db->query("select 'envio_correos' as tipoEnvio,(count(idCobranzaHistorial)) as total from cobranzahistorial where  tipoEnvioCH='envio_correos '".$filtroConsulta." union select 'envio_whats' as tipoEnvio,(count(idCobranzaHistorial) ) as total from cobranzahistorial where  tipoEnvioCH='envio_whats' ".$filtroConsulta." union select 'envio_sms' as tipoEnvio,(count(idCobranzaHistorial)) as total from cobranzahistorial where  tipoEnvioCH='envio_sms' ".$filtroConsulta)->result();

          $value->historialCorreos=$historialEnvio[0]->total;
          $value->historialWhats=$historialEnvio[1]->total;     
          $value->historialSMS=$historialEnvio[2]->total;
          $comprueba=$this->reportes_model->comprobarSoicitudCobro($value->IDDocto);
          $value->cobranzaConSolicitud=$comprueba[0]->bandera;
          $value->cobranzaSinSolicitud=$comprueba[1]->bandera;
          $value->cobranzaComenatarios=$comprueba[2]->bandera;
          $value->estatusConSolicitud=$comprueba[0]->estado;
          $value->tipoSolicitud=$comprueba[0]->tipoSolicitud;
          $value->tieneSiniestro=$this->db->query('select count(poliza) as total from siniestro_poliza s where s.poliza="'.$value->Documento.'"')->result()[0]->total;
          $value->statusCSC=0;
          $value->tipoSolicitudTexto='';
          array_push($respuesta['cobranzaPendiente'], $value);
        }
    }
  }
 }
foreach ($respuesta['cobranzaPendienteActiva'] as $value) 
  {
      /*==============================PARA MOSTRAR CANTIDAD DE COMENTARIOS=====================================*/
    $filtroConsulta=" and idRecibo=".$value->IDRecibo." and idSerie='".$value->Serie."' and email='".$email."'";
    $historialEnvio=$this->db->query("select 'envio_correos' as tipoEnvio,(count(idCobranzaHistorial)) as total from cobranzahistorial where  tipoEnvioCH='envio_correos '".$filtroConsulta." union select 'envio_whats' as tipoEnvio,(count(idCobranzaHistorial) ) as total from cobranzahistorial where  tipoEnvioCH='envio_whats' ".$filtroConsulta." union select 'envio_sms' as tipoEnvio,(count(idCobranzaHistorial)) as total from cobranzahistorial where  tipoEnvioCH='envio_sms' ".$filtroConsulta)->result();
      $value->historialCorreos=$historialEnvio[0]->total;
      $value->historialWhats=$historialEnvio[1]->total;     
      $value->historialSMS=$historialEnvio[2]->total;
                          /*===============================FIN DE COMENTARIO===============================*/


    /*============================MOVIMEINTOS REALIZADOS PARA COBRANZA Y COMENTARIOS =======================================*/
        $comprueba=$this->reportes_model->comprobarSoicitudCobro($value->IDDocto);
        $value->cobranzaConSolicitud=$comprueba[0]->bandera;
        $value->cobranzaSinSolicitud=$comprueba[1]->bandera;
        $value->cobranzaComenatarios=$comprueba[2]->bandera;
        $value->estatusConSolicitud=$comprueba[0]->estado;
        $value->tipoSolicitud=$comprueba[0]->tipoSolicitud;
                         /*===============================FIN DE COMENTARIO===============================*/

    /*=============================VERIFICA SI TIENE SINIESTRO======================================*/
               $value->tieneSiniestro=$this->db->query('select count(poliza) as total from siniestro_poliza s where s.poliza="'.$value->Documento.'"')->result()[0]->total;
            
                                 /*===============================FIN DE COMENTARIO===============================*/
      /*===============================REGRESA EL STATUS DE LA COBRANZA SI ES AGENTE U  OPERATIVO====================================*/
             $recibo['idRecibo']=$value->IDRecibo;              
             $solicitudCobranza=$this->reportes_model->obtenerCobranzaSolicitudCobroId_CSC_Recibo_Docto($recibo);
             $scArray[0]='Aplicacion de Pago';
             $scArray[1]='Rehabilitacion de poliza';
             $scArray[2]='Cobro de recibo';
             $scArray[3]='Solicitud de referencia';
             $scArray[4]='Domiciliacion';
             $scArray[5]='Factura';             
            $tipo='';
             foreach ($solicitudCobranza['datos'] as $valueSC) {$tipo.=(string)$scArray[$valueSC->idTipoSolicitudCobro].';';}
             $value->tipoSolicitudTexto=$tipo;
              $value->statusCSC=$solicitudCobranza['statusGeneral'];                                  
                           /*===============================FIN DE COMENTARIO===============================*/
    /*=============================VERIFICA SI ES APLICADA======================================*/
         $consulta='select (count(IDRecibo)) as total from cobranza_aplicada c where c.IDRecibo='.$value->IDRecibo;
         $aplicada=$this->db->query($consulta)->result();
   
         $value->estaAplicada=$this->db->query($consulta)->result()[0]->total;

                         /*===============================FIN DE COMENTARIO===============================*/
  /*================================OTROS DATOS cobranzasolicitudcobro===================================*/
          $consulta='select estaResuelta from cobranzasolicitudcobro c where c.IDRecibo='.$value->IDRecibo.' limit 1';
         
          $cobranzaSolicitudCobro=$this->db->query($consulta)->result();
          $value->estaResuelta='';
          if(count($cobranzaSolicitudCobro)>0){$value->estaResuelta=$cobranzaSolicitudCobro[0]->estaResuelta;}
                     /*===============================FIN DE COMENTARIO===============================*/
        /*=============================SI TIENE FACTURA======================================*/
           $consulta='select (if(sum(c.requiereFactura) is null,0,sum(c.requiereFactura))) as requiereFactura from cobranzasolicitudcobro c where c.IDRecibo= '.$value->IDRecibo;
        
     $cobranzaSolicitudCobro=$this->db->query($consulta)->result();
          $value->requiereFactura=$cobranzaSolicitudCobro[0]->requiereFactura;
                             /*===============================FIN DE COMENTARIO===============================*/

          }
                 
  if(isset($_POST['function'])){return $respuesta;}
  else{echo json_encode($respuesta); }
}
//-----------------------------------------------------------
function devolverResponsablesCobranza()
{
  $datos['responsableCobranza']=$this->db->query('select * from cobranza_responsable where tipoPermiso="cobranza"')->result();
  $datos['responsableFactura']=$this->db->query('select * from cobranza_responsable where tipoPermiso="factura"')->result(); 
  echo json_encode($datos);
}
//-----------------------------------------------------------
function solicitudCobranzaLista()
{
  $respuesta['success']=1;
  echo json_encode($respuesta);

}
//-----------------------------------------------------------
function verRechazoDomiciliado(){
  $datos = array();

  $datos['motivosRechazo'] = $this->db->query('select * from motivos_rechazo_pago')->result();

  $datos['cliente'] = array(
    'nombre' => $this->input->post('nombre_cliente'),
    'email' => $this->input->post('email_cliente')
  );

  $datos['poliza'] = array(
    'folio_doc' => $this->input->post('folio_doc'),
    'periodo' => $this->input->post('periodo'),
    'vigencia' => $this->input->post('vigencia'),
    'endoso' => $this->input->post('endoso'),
    'compania' => $this->input->post('compania'),
    'prima_total' => $this->input->post('prima_total'),
    'id_recibo' => $this->input->post('IDRecibo'),
    'id_docto' => $this->input->post('idDocto'),
    'id_cli' => $this->input->post('IDCli')
  );

  $datos['username'] = $this->tank_auth->get_usernamecomplete();

  $nombre_vendedor = trim($this->input->post('nombre_vendedor'));
  $email_vendedor = $this->db->query("SELECT EMail1 FROM catalog_vendedores WHERE NombreCompleto LIKE ?", array("%" . $nombre_vendedor . "%"))->row();
  $datos['vendedor'] = array(
    'nombre' => $nombre_vendedor,
    'email' => $email_vendedor ? $email_vendedor->EMail1 : 'Sin email'
  );

  $idusuario = $this->tank_auth->get_idPersona();
  $datos['destinatariosAdicionales'] = $this->db->query("select emailAdicional from rechazo_persona_adicional where idPersona = $idusuario")->result();

  $this->load->view('reportes/rechazo_domiciliado', $datos);	
}

function enviarRechazoDomiciliado(){
  try{
    $guardarAdicional = ($this->input->post('guardar_adicional') == 'true');
    $destinatarios = $this->input->post('destinatarios');

    $mensaje = $this->input->post('mensaje');

    $nombre_remitente = $this->tank_auth->get_usernamecomplete();
    $correo_remitente = $this->tank_auth->get_usermail();

    date_default_timezone_set("America/Mexico_City");
    $fecha_envio = date("Y-m-d H:i:s");

    $email_data = array();
    $email_data['desde'] = "$nombre_remitente <$correo_remitente>";
    $email_data['asunto'] = "Rechazo de Pago";
    $email_data['mensaje'] = $mensaje;
    $email_data['fechaEnvio'] = $fecha_envio;
    $email_data['identificaModulo'] = 'cobranza/enviarRechazoDomiciliado';

    foreach($destinatarios as $dt){
      $email_data['para'] = $dt['correo'];
      $this->email_model->SendEmail($email_data);
    }

    if($guardarAdicional){
      $this->reportes_model->guardarDestinatarioAdicional($destinatarios);
    }

    echo "true";
  } catch (Exception $e){
    echo "false";
  }
}

function obtenerPagosAplicados(){
  $fechaInicial = $this->input->post('fechaInicial');
  $fechaFinal = $this->input->post('fechaFinal');

  $datos_v3 = $this->reportes_model->obtenerPagosAplicados($fechaInicial, $fechaFinal);

  echo json_encode($datos_v3);
}

function obtenerCSC_SC(){
  $idrecibos = $this->input->post('idrecibos');

  $datos_v3 = $this->reportes_model->obtenerCSC_SC($idrecibos);

  echo json_encode($datos_v3);
}

function obtenerDatosRecibosSicas(){
  $idrecibos = $this->input->post('idrecibos');

  $datos_sicas = $this->ws_sicas->obtenerReciboPorID($idrecibos);
  
  echo json_encode($datos_sicas);
}
//-----------------------------------------------------------
function obtenerRecibo()
{
   $recibo=$this->ws_sicas->buscarReciboPorID($_GET['id']);
  $fp = fopen('resultadoJason.txt', 'a');fwrite($fp, print_r($recibo,false));fclose($fp);
  echo $recibo; 
}

}//FIN DE CLASE