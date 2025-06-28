<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Clientes extends CI_Controller{
var	$datos;
	function __construct(){
		parent::__construct();
	   $this->load->model("clientemodelo");
	    $this->load->library('Ws_sicas'); 
      $this->load->library('libreriav3');
      $this->load->library("webservice_sicas_soap");
	}
	function index(){
      if (!$this->tank_auth->is_logged_in()) {redirect('/auth/login/');}
        $this->datos['clienteVerificar']=$this->clientemodelo->obtenerClientesActualizar();
        $this->datos['clientesConDetalle']=$this->clientemodelo->clientesConDetalle();

		$this->load->view('clientes/clientes',$this->datos);	

	}
//------------------------------------------------------------------------------------------
function cancelarActualizacion(){
  //
  $respuesta='';
	$update['statusComprobacion']=1;
  $this->clientemodelo->cancelarActualizacion($_POST['idClienteVerificar'],$update);
  if(isset($_POST['ajax'])){$respuesta['mensaje']='Cancelacion correcta';echo json_encode($respuesta);}
  else{$this->index();}	

}
//------------------------------------------------------------------------------------------
public function guardarActualizacion(){

  $cliente=$this->clientemodelo->obtenerCliente($_POST['IDCli']);
  $clienteVerifica=$this->clientemodelo->obtenerClienteDeActualizar($_POST['idClienteVerificar']);
  $datosMod=explode(";", $clienteVerifica[0]->campos);
  $datos="";
    foreach ($datosMod as  $valueDatosMod) {
      $cadena=explode(':',$valueDatosMod);
      if(count($cadena)>1){
      $datos[$cadena[0]]=$cadena[1];
      
       }

    //	$datos=$datos.$valueDatosMod;
     
    }

    
      //$datos['Telefono1']='';
      
      if(isset($datos['Telefono1'])){$datos['Telefono1']='Celular|'.$datos['Telefono1'];};
    $datos['IDCont']=$cliente[0]->idContacto;
    $respuesta=$this->ws_sicas->actualizarContactoVendedorSicas($datos);
    
    if(isset($respuesta['Sucess'])){
    	unset($datos['IDCont']);
    	$this->clientemodelo->actualizarCliente($_POST['IDCli'],$datos);
      if(isset($_POST['ajax']))
      {
       if($respuesta['Sucess']==1){
          $update['statusComprobacion']=1;
         $this->clientemodelo->cancelarActualizacion($_POST['idClienteVerificar'],$update);
        $this->datos['mensajeV3']="La actualizacion fue correcta";echo json_encode($this->datos);
      }
       else{$this->datos['mensajeV3']="Error en la actualizacion";echo json_encode($this->datos);}
      }
      else
      {
       if($respuesta['Sucess']==1){$this->datos['mensajeV3']="La actualizacion fue correcta";$this->cancelarActualizacion();}
       else{$this->datos['mensajeV3']="Error en la actualizacion";$this->index();}
      }
    }else{$this->datos['mensajeV3']="Error en la actualizacion";$this->index();}

  

}
//------------------------------------------------------------------------------------------
function datosClienteSICAS(){

  //$datos=$this->ws_sicas->obtenerClientePorID($_POST['IDCli']);
    $datos=$this->ws_sicas->obtenerClienteInfo($_POST['IDCli']);
  
   $cliente="";
   $cliente['NombreCompleto']=(string)$datos->TableInfo->NombreCompleto; 
   $cliente['tipoEntidad']=(string)$datos->TableInfo->TipoEnt_TXT;
   $cliente['EMail1']=(string)$datos->TableInfo->EMail1; 
   $cliente['Telefono1']=(string)$datos->TableInfo->Telefono1; 
  // $cliente['IDCli']=(string)$datos->TableInfo->IDCli;
  if($datos->TableInfo->TipoEnt==1){
    /*ES PERSONA MORAL*/
    $cliente['nombreCliente']=(string)$datos->TableInfo->RazonSocial;
  }
  else
  {
  /*ES PERSONA FISICA*/
  $cliente['nombreCliente']=(string)$datos->TableInfo->ApellidoP.' '.(string)$datos->TableInfo->ApellidoM.' '.(string)$datos->TableInfo->Nombre;
  }

  //if((string)$datos->TableInfo->EMail1==''){unset($datos->TableInfo->EMail1);$datos->TableInfo->addChild('EMail1',0); }
   $this->clientemodelo->actualizarCliente((string)$datos->TableInfo->IDCli,$cliente);
  //  $fp = fopen('resultadoJason.txt', 'a');fwrite($fp, print_r($cliente, TRUE));fclose($fp);
  if(isset($_POST['ajax'])){
    $informacion['datosCliente']=$cliente;
  echo json_encode($informacion); 
  }
}
//------------------------------------------------------------------------------------------
function actualizarCliente(){
  /*PROBLEMA DE QUE NO VEAN UN CLIENTE ES POR QUE EL CAMPO FieldInt1 TIENEN UN ID QUE NO RARO ESTO PASA LA BUSCAR AL CLIENTE EN LE MODULO DE DIRECTORIO*/
  $datos['IDCli'] ='18012';//$datos['Calidad']='PROSPECTO';
  $datos['FieldInt1']='220';/*ES DONDE SE ALMACENA EL ID DEL AGENTE*/
  $respuesta=$this->ws_sicas->modificarCliente($datos);
}

//------------------------------------------------------------------------------------------
function clientePorID(){
  $datos=$this->ws_sicas->obtenerClientePorID(27232);
  //$fp = fopen('resultadoJason.txt', 'a');fwrite($fp, print_r($datos, TRUE));fclose($fp);
}
//------------------------------------------------------------------------------------------
function datosClientesDesdeV3()
{
   $datos=array();
  if(isset($_POST['AJAX'])){echo json_encode($datos);}
  else{return  $datos;}
}
//----------------------------------------------
function actividadesDeClientes()
{
   $datos=array();
   $consulta='select a.*,(date_format(a.fechaCreacion,"%d-%m-%Y")) as fechaCreacion from actividades a where a.idCliente='.$_POST['idCliente'];
   $datos['actividades']=$this->db->query($consulta)->result();
  if(isset($_POST['AJAX'])){echo json_encode($datos);}
  else{return $datos;}
  
}

//--------------------------------------------------
function obtenerComentariosActividades()
{
  $respuesta['succes']='1';
      $respuesta['verBitacoraActividad'] =array();
     $comentarios   = $this->ws_sicas->informacionDeBitacora($_POST['ClaveBit']);
    
     if(isset($comentarios->TableInfo))
     {
      foreach ($comentarios->TableInfo as $value) 
      {
        $coment=array();
        $coment['Comentario']=(string)$value->Comentario;
        $coment['FechaHora']=(string)$value->FechaHora;
        array_push($respuesta['verBitacoraActividad'], $coment);
      }
     }
      //$fp = fopen('resultadoJason.txt', 'a');fwrite($fp, print_r($respuesta,TRUE));fclose($fp);
  echo json_encode($respuesta);
}
//-------------------------------------------------
function traerHistorialDeEnvios()
{
     $datos=array();
   $consulta='select c.*,(date_format(c.fechaCreacionCH,"%d-%m-%Y")) as fechaCreacion  from cobranzahistorial c where c.IDCli='.$_POST['idCliente'];
   $datos['cobranzaHistorial']=$this->db->query($consulta)->result();
  if(isset($_POST['AJAX'])){echo json_encode($datos);}
  else{return $datos;}
  
}
//-------------------------------------------------
function traerHistorialClientes()
{
   $datos=array();
   $datos['success']='1';
   $datos['actividades']=array();
   $datos['historialEnvio']=array();
   $actividades=$this->actividadesDeClientes();
    
   foreach ($actividades['actividades'] as  $value) 
   {
     $array=array();
     $array['idInterno']=$value->idInterno;
     $array['folioActividad']=$value->folioActividad;
     $array['idSicas']=$value->idSicas;
     $array['NumSolicitud']=$value->NumSolicitud;
     $array['tipoActividad']=$value->tipoActividad;
     $array['ramoActividad']=$value->ramoActividad;
     $array['subRamoActividad']=$value->subRamoActividad;
     $array['ClaveBit']=$value->ClaveBit;
     $array['fechaCreacion']=$value->fechaCreacion;
     array_push($datos['actividades'], $array);
   }
$historial=$this->traerHistorialDeEnvios();
   
      foreach ($historial['cobranzaHistorial'] as  $value) 
   {
     $array=array();
     $array['tipoEnvioCH']=$value->tipoEnvioCH;
     $array['hRefCH']=$value->hRefCH;
     $array['envioDestinoCH']=$value->envioDestinoCH;
     $array['email']=$value->email;        
     $array['documento']=$value->documento;
     $array['comentarioDelEnvio']=$value->comentarioDelEnvio;
     $array['fechaCreacion']=$value->fechaCreacion;
     array_push($datos['historialEnvio'], $array);
   }
   
  echo json_encode($datos);
  
}
//------------------------------------------------------------------------------------------
//Dennis Castillo [2021-12-28]
function manageClients(){

  if (!$this->tank_auth->is_logged_in()) {
    redirect('/auth/login/');
  }

  $unifycadedBlocks = $this->clientemodelo->getUnifications();
  $data["blocks"] = array_reduce($unifycadedBlocks, function($acc, $curr){
    
    $acc[$curr->id]["block"] = $curr->block." ".$curr->id;
    $acc[$curr->id]["clients"][$curr->IDCli]["name"] = $curr->NombreCompleto;
    $acc[$curr->id]["clients"][$curr->IDCli]["idCli"] = $curr->clientID;
    $acc[$curr->id]["ramifications"] = array_reduce($this->clientemodelo->getRamifications($curr->id), function($acc, $curr){

      $acc[] = array("name" => $curr->ramification, "policies" => $curr->countPolicies);
      return $acc;
    }, array());
   
    return $acc;
  }, array());

  //$fp = fopen('resultadoJason.txt', 'a');fwrite($fp, print_r($data, TRUE));fclose($fp);
  $this->load->view("clientes/manageClients", $data);
}

//------------------------------------------------------------------------------------------
//Dennis Castillo [2021-12-28]
function getClients(){

  $name = $_GET["client"];
  $clients = $this->clientemodelo->getClients($name);

  echo json_encode($clients);
}
//------------------------------------------------------------------------------------------
//Dennis Castillo [2021-12-28]
function getClientData(){

  $IDCli = $_GET["client"];
  $response = array();
	$ramosContact	= $this->getPoliciesFromSicas($IDCli);

  //$fp = fopen('resultadoJason.txt', 'a');fwrite($fp, print_r($ramosContact, TRUE));fclose($fp);

  if(array_key_exists("TableInfo", $ramosContact) || !$ramosContact){
    foreach($ramosContact->TableInfo as $data){

      $type = (String)$data->RamosNombre == "Accidentes y Enfermedades" ? "GMM" : (String)$data->RamosNombre;
      array_push($response, $type);
    }
  }
  //------------------

  echo json_encode(array_values(array_unique($response)));
}
//------------------------------------------------------------------------------------------
//Dennis Castillo [2021-12-28]
function getPoliciesFromSicas($IDCli){
  
  $sDate 						= date("d/m/Y");
	//$IDCli						= $_GET["q"];
	$wsdata['TypeFormat']		= 'XML';			
	$wsdata['KeyProcess']		= 'REPORT';
	$wsdata['KeyCode']			= 'HWS_DOCTOS';
	$wsdata['Page']				= '1';
	$wsdata['InfoSort']			= 'CatClientes.IDCli';
	$wsdata['ConditionsAdd']	= '
					Cliente Id;0;0;'. $IDCli .';'. $IDCli .';0;-1;DatDocumentos.IDCli 
					! 
					Tipo Documento;0;0;1;1;DatDocumentos.TipoDocto 
					! 
					Id Cliente;5;0;'.$sDate.';0;DatDocumentos.FHasta 
					! 
					Cliente Id;0;0;0;0;0;-1;DatDocumentos.Status';

	$ramosContact	= $this->webservice_sicas_soap->getDatosSicas($wsdata);

  return $ramosContact;
}
//------------------------------------------------------------------------------------------
//Dennis Castillo [2021-12-28]
function unifyClients(){

  $update = $_POST["update"];
  $postBlock = $_POST["block"];

  $response = $update == 0 ? $this->crateUnification($_POST) : $this->updateUnification($_POST); //

  echo json_encode($response);
}
//------------------------------------------------------------------------------------------
//Dennis Castillo [2021-12-28]
function updateUnification($data){

  $delete = $this->clientemodelo->deleteBlockSafely($data["block"]);
  $insert = $this->crateUnification($data);

  return $insert;
}
//-----------------------------------------
//Dennis Castillo [2021-12-28]
function crateUnification($data){

  $validate = array();
  //Starting point - create block
  $block = $this->clientemodelo->insertRecordSafely(array(
    "block" => "unificación",
    "dateCreate" => date("Y-m-d H:i:s")
  ), "client_unification_block");
  //-------------- 1 step
  $clients = array_reduce($data["clients"], function($acc, $curr) use($block){

    $acc[] = array(
      "clientID" => $curr,
      "blockNum" => $block["lastId"],
    );

    return $acc;
  }, array());
  //-------------- 2 step
  $ramifications = array_reduce($data["types"], function($acc, $curr) use($block){

    if(array_key_exists($curr,$acc)){
      $acc[$curr]["countPolicies"] ++;
    } else{

      $acc[$curr]["blockNum"] = $block["lastId"];
      $acc[$curr]["ramification"] = $curr;
      $acc[$curr]["countPolicies"] = 1;
    }

    return $acc;
  }, array());

  $clients_batch = $this->clientemodelo->insertMultipleRecordSafely($clients, "client_unifications");
  $ramifications_batch = $this->clientemodelo->insertMultipleRecordSafely(array_values($ramifications), "client_ramification");

  array_push($validate, $clients_batch["status"], $ramifications_batch["status"], $block["status"]);

  $response["status"] = in_array(false, $validate) ? false: true;
  $response["message"] = in_array(false, $validate) ? "Ocurrió un error en la ejecución. Favor de contactar a depto de sistemas": "Operación realizada con éxito";

  return $response;
}
//------------------------------------
//Dennis Castillo [2021-12-28]
function deleteUnify(){

  $idBlock = $_GET["block"];
  $delete = $this->clientemodelo->deleteBlockSafely($idBlock);
  //$delete = true;

  $response["status"] = $delete;
  $response["message"] = $delete ? "Registro eliminado con éxito" : "Ocurrió un error. Favor de contactar al depto de sistemas.";

  echo json_encode($response);
}

//------------------------------------------------------------------------------------------
//Dennis Castillo [2021-12-28]
function getOnlyClientData(){
  $IDCli = $_GET["client"];
  $response = array();
	$ramosContact	= $this->getPoliciesFromSicas($IDCli);

  foreach($ramosContact->TableInfo as $data){
    $response[(String)$data->RamosNombre][] = $data;
  }

  //$fp = fopen('resultadoJason.txt', 'a');fwrite($fp, print_r($response, TRUE));fclose($fp);
  echo json_encode($response);
}
//--------------------

function obtenerCentroDigital()
{
   //$respuesta['mensaje']='NO TIENE DOCUMENTOS PERSONALES';
   $respuesta['documentosCliente']=array();
  if($_POST['tipoBusqueda']=='cliente')
  {
    
    $data['IDValuePK']=$_POST['IDCli'];
    $documentos=$this->ws_sicas->GetCDDigitalCliente($data);
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
  }

  echo json_encode($respuesta);
}
//------------------------------------------------------------------------------------------
function subirDocumentos()
{
  //$fp = fopen('resultadoJason.txt', 'a');fwrite($fp, print_r($_FILES, TRUE));fclose($fp);
$this->load->model('manejodocumento_modelo');
$respuesta['mensaje']='Archivos añadidos con exito';
$tiempoEspera=0;
$traerArchivo=0;
foreach ($_FILES as $key => $value) 
{
   $tiempoEspera=$tiempoEspera+5;
   if($value['name']!='')
   {
     $archivo=array();
     $extension=explode(".",$value['name'] );
     $largo=count($extension);
     $ext=$extension[$largo-1];
     $idCliente    = $_POST['IDCli'];    
     $nombre=$this->db->query('select nombre from catalog_tipoImg c where c.idTipoImg='.$key)->result()[0]->nombre;
     $nameFileSicas  = str_replace(' ','_',$nombre);
     //$nameFileSicas  .= "-".strtoupper($this->input->post('descripcionArchivo', TRUE));
    $nameFileSicas  .= "-".date('YmdHi');
        //$nameFileSicas  .= ".".strrev(strstr(strrev($_FILES['DocumentoFiles']['name']), '.', true));
                //$destination  = '/var/www/html/capsys.com.mx/public_html/V3/assets/img/tmp/'.$nameFileSicas;
                //$destination  = 'C:\wamp64\www\Capsys\www\V3\assets\img\tmp\\'.$nameFileSicas;
      $destination  = '/var/www/html/V3/assets/img/tmp/'.$nameFileSicas.'.'.$ext; 
     move_uploaded_file($value['tmp_name'], $destination);
  
         if($key==5 || $key==7 || $key==11  || $key==12 || $key==21 || $key==22)
         {         
         $archivo['TypeDestinoCDigital'] = 'CLIENT';
         $archivo['IDValuePK']= $idCliente;                      
         $archivo['FolderDestino']= "";              
         }
         else{/*PARA CUANDO SE TENGA QUE GUARDAR DOCUMENTOS DE LA POLIZA REVISAR CONTROLADOR DE COBRANZA subirDocumentosDeCobranza*/}
      $archivo['wsAction'] = "PUTFiles";
      $archivo['ListFilesURL']= base_url().'assets/img/tmp/'.$nameFileSicas.'.'.$ext;   
      //$archivo['ListFilesURL']='https://capsys.com.mx/V3/assets/img/tmp/RECIBOS_DE_PAGO.pdf';
      
      $respuesta=$this->ws_sicas->subirArchivoSicas($archivo);
      sleep(5);
   
 }
}
$respuesta['documentosCliente']=array();
    $data['IDValuePK']=$_POST['IDCli'];
    $documentos=$this->ws_sicas->GetCDDigitalCliente($data);

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
  echo json_encode($respuesta);
}
//---------------------------------------------------------------
function agregarDocumentos()
{
  $respuesta['success']=true;

$tiempoEspera=3;
foreach ($_FILES as $key => $value) 
{
 // $fp = fopen('resultadoJason.txt', 'a');fwrite($fp, print_r($value, TRUE));fclose($fp);
      //$destination = 'C:\wamp64\www\Capsys\www\V3\assets\img\tmp\\'.$value['name'];
       //$destination = '/var/www/html/capsys.com.mx/public_html/V3/assets/img/tmp/'.$_FILES['imagenes']['name'][$i]; 
       //$destination = '/var/www/html/V3/assets/img/tmp/'.$value['name'];
       $destination=RUTA_ASSETS."assets/img/tmp/".$value['name'];       
       move_uploaded_file($value['tmp_name'], $destination);
       $archivo['ListFilesURL']= base_url().'assets/img/tmp/'.$value['name'];
       //$archivo['ListFilesURL']= 'https://capsys.com.mx/V3/assets/img/tmp/YSA566060200.pdf';
       $archivo['TypeDestinoCDigital']  = 'DOCUMENT';//$this->input->post('TypeDestinoCDigital', TRUE);
       $archivo['IDValuePK']= $_POST['IDDocto'];//'23247';//IDDocto     
       $archivo['FolderDestino']= '';
       $archivo['wsAction'] = "PUTFiles"; 
       $respuesta=$this->ws_sicas->subirArchivoSicas($archivo);  
  sleep($tiempoEspera);

}

echo json_encode($respuesta);
  
}
//------------------------------------------------------------------------------------------
function clientesModificar()
{
  $respuesta['tabs']=$this->db->query('SELECT (LEFT(c.NombreCompleto,1)) AS Nombre,(COUNT(LEFT(c.NombreCompleto,1))) as total
FROM clientelealtadpuntos c
GROUP BY 1')->result();

  $this->load->view('clientes/clientesModificar',$respuesta); 
}
//---------------------------------------------------------------------
function obtenerClientesPorLetraInicial()
{
   $respuesta['datos']='';
   $consulta='select * from clientelealtadpuntos where NombreCompleto like "'.$_POST['letraInicial'].'%"';
   
   $respuesta['datos']=$this->db->query($consulta)->result();
    echo json_encode($respuesta);
}
//----------------------------------------------------------------
function enviarCorreo()
{
  /*$mail = $this->phpmailer_lib->load();
  $mail->isSMTP();
  $mail->protocol='mail';
  $mail->Host     = 'agentecapital.com';
  $mail->SMTPAuth = true;
  $mail->Username = 'desarrollo@agentecapital.com';
  $mail->Password = 'Desarrollo2022#';
  $mail->SMTPSecure = 'ssl';
  $mail->Port     = 465;
  $mail->setFrom("avisos@sloanseguimiento.com");
  $mail->addAddress('luceme_23@yahoo.com');      
  $mail->isHTML(true);                                  //Set email format to HTML
  $mail->Subject ='prueba';
  $mail->Body='prueba'; 
  $mail->send();*/

       $this->load->library('email');
      $config['protocol'] = 'smtp';
      $config['smtp_host'] = 'agentecapital.com';///usr/sbin/sendmail';
      $config['smtp_user'] = 'desarrollo@agentecapital.com';
      $config['smtp_pass'] = 'Desarrollo2022#';
      $config["smtp_port"] = '587';
      $config['charset'] = 'utf-8';
      $config['wordwrap'] = TRUE;
      $config['validate'] = true;
      $this->email->initialize($config); 
      $this->email->clear(true);
      $this->email->from('avisosgap@asesorescapital.com');        
      $this->email->to('desarrollo@agentecapital.com');
      //$this->email->to($correoE);
      $this->email->message("Estado financiero");
            $this->email->send();
            show_error($this->  email->print_debugger());
         


}
//---------------------------------------------------------------
function guardarModificacionClientes()
{
    $respuesta['success']=true;
    //$respuesta['clienteDatos']=$_POST;
    #sleep(7);
     $datos=array();
     $oldValue=array();
     $newValue=array();
     $newValue['IDCont']=$_POST['IDCont'];
     $respuesta['errorInfo']=array();
     $respuesta['errorMensaje']=array();
     foreach ($_POST as $key => $value) 
     {
       switch ($key) 
       {
         case 'ApellidoP':
              $oldValue['ApellidoP']=$_POST['oldApellidoP'];
              $newValue['ApellidoP']=$_POST['ApellidoP'];     
           break;
         case 'ApellidoM': 
              $oldValue['ApellidoM']=$_POST['oldApellidoM'];
              $newValue['ApellidoM']=$_POST['ApellidoM']; 

           break;
           case 'Nombre': 
              $oldValue['Nombre']=$_POST['oldNombre'];
              $newValue['Nombre']=$_POST['Nombre'];         
           break;
           case 'Telefono1':  
           $telefono=$this->libreriav3->comprobarNumeroTelefonoSicas($_POST['Telefono1']);
           if($telefono!=0)
           {
              $oldValue['Telefono1']=$telefono;
              $newValue['Telefono1']=$telefono;

           }
           else
           {
              array_push($respuesta['errorMensaje'], 'El Telefono es invalido');
                array_push($respuesta['errorInfo'], 'Telefono1');
           }
                  

           break;
           case 'Email1': 

              if(!filter_var($this->input->post('EMail1', TRUE), FILTER_VALIDATE_EMAIL))
              {
                array_push($respuesta['errorMensaje'], 'El Email es invalido');
                array_push($respuesta['errorInfo'], 'Email1');
                    
              }   
              else
              {
                $oldValue['Email1']=$_POST['oldEmail1'];
                $newValue['Email1']=$_POST['Email1']; 
              }     
           break;
            case 'RFC':  
          $clienteExistente=$this->ws_sicas->rfcClienteObtener($_POST['RFC']);
          //
          if((int)$clienteExistente->TableControl->MaxRecords==0)
          {
               $resRFC=$this->libreriav3->comprobarRFC($_POST['RFC'],$_POST['tipoEntidad']);
                if($resRFC['esRFC']==0)
                  {
                    array_push($respuesta['errorMensaje'], 'No tiene la estructura del RFC ') ;
                    array_push($respuesta['errorInfo'], 'RFC');
                  }
                  else
                  {
                     $oldValue['RFC']=$_POST['oldRFC'];
                     $newValue['RFC']=$_POST['RFC'];        

                  }
          }
          else{array_push($respuesta['errorMensaje'], 'Ya existe un RFC asociado a otro cliente') ;array_push($respuesta['errorInfo'], 'RFC');}

           break;
            case 'fecha_nacimiento':  
              $oldValue['fecha_nacimiento']=$_POST['oldfecha_nacimiento'];
              $newValue['FechaNac']=$this->libreriav3->convierteFecha($_POST['fecha_nacimiento']); 
              $newValue['FechaConst']=$this->libreriav3->convierteFecha($_POST['fecha_nacimiento']);       
           break;
           case 'RazonSocial':
                   $oldValue['RazonSocial']=$_POST['oldRazonSocial'];
                   $newValue['RazonSocial']=$_POST['RazonSocial']; 
           break;
         default:
           # code...
           break;
       }
     }

     $respuestaWS=$this->ws_sicas->actualizarContactoSicas($newValue);

     if(isset($respuestaWS['Sucess']))
     {
      if($respuestaWS['Sucess'])
      {
          // $fp = fopen('resultadoJason.txt', 'a');fwrite($fp, print_r('grabar', TRUE));fclose($fp); 
        if(isset($_POST['fecha_nacimiento']))
        {
            $newValue['fecha_nacimiento']=$_POST['fecha_nacimiento'];
            unset( $newValue['FechaNac']);    
            unset($newValue['FechaConst']);
        }
        $this->clientemodelo->bitacoraclientesactualizacionInsertar($_POST['IDCli'],$_POST['IDCont'],$newValue,$oldValue);
        unset($newValue['IDCont']);
       $this->clientemodelo->actualizarCliente($_POST['IDCli'],$newValue);
      }
     }
     
 

    $respuesta['clienteDatos']=$this->db->query('SELECT IDCli,NombreCompleto,Telefono1,Email1,ApellidoP,ApellidoM,Nombre,RFC,cast(fecha_nacimiento AS DATE) AS Fecha_Nacimiento,RazonSocial
FROM clientelealtadpuntos
WHERE IDCli='.$_POST['IDCli'])->result()[0];

     //$fp = fopen('resultadoJason.txt', 'a');fwrite($fp, print_r($respuesta, TRUE));fclose($fp);
    echo json_encode($respuesta);
}
//-----------------------------------------------------------
function devolverPreferenciasDeContacto()
{
  $consulta='select  c.diaComunicacion,c.preferenciaComunicacion,c.horarioComunicacion from clientelealtadpuntos c where c.IDCli='.$_POST['IDCli'];

  $datos=$this->db->query($consulta)->result();
  if(count($datos>0))
  {
    echo json_encode($datos[0]);
  }
  else
  {
    $datos['diaComunicacion']=-1;
    $datos['horarioComunicacion']=-1;
    $datos['preferenciaComunicacion']=-1;
    echo json_encode($datos); 
  }
  
}
//-----------------------------------------------------------
function o()
{
  $datos=$this->ws_sicas->obtenerClientePorID(32);

  var_dump($datos);
}

}