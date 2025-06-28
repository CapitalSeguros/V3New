<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
//require('KLogger/vendor/autoload.php');

class Ws_sicas_old 
{
	var $uri_service = "https://www.sicasonline.info/SOnlineWS/WS_SICASOnline.asmx?WSDL";
	var $soapC;
	var $oDataWS;	
	var $key = "%SOnlineBOGO2001-2015WS#";
	var $ivPass = "GAP#aCap";
	var $CI;
	var $logger;
		var $auth = "vsDMquPhx68SZrY8wGcxEh2bk1XiPlR0EZkBVLmax3A4Mab7sDeeyodY3BjDuyB";	
	var $user = "GAP#aCap%2015";		
	var $pass = "CAP15gap20Ag";	
	var $Url = 'https://{host}/SOnlineWS/WS_SICASOnline.asmx?WSDL';
	var $host = 'www.sicasonline.info';
	var $numeroPagina=1;
	var $tableInfo=array();
	var 	$DeleteXml = array('<?xml version="1.0" encoding="utf-8"?>','<soap:Envelope xmlns:soap="http://schemas.xmlsoap.org/soap/envelope/" xmlns:xsi="http://www.w3.org/2001/XMLSchema-instance" xmlns:xsd="http://www.w3.org/2001/XMLSchema">','<DATAINFO> ','<soap:Envelope xmlns:soap="http://www.w3.org/2003/05/soap-envelope" xmlns:xsi="http://www.w3.org/2001/XMLSchema-instance" xmlns:xsd="http://www.w3.org/2001/XMLSchema"><soap:Body>','<ProcesarWSResponse xmlns="http://tempuri.org/">','<ProcesarWSResult>','</ProcesarWSResult>','</ProcesarWSResponse>','</soap:Envelope>','</DATAINFO> ','</soap:Body>','</DATAINFO> ',);
	var $ClearXml = array('','','','','','','','','','','','',);

	//------------------------------------------------------------------------------------------------------------------------
function __construct()
{
	
	$this->CI=& get_instance();
//	$this->logger = new Katzgrau\KLogger\Logger(__DIR__.'/logs');
	try
   {
    error_reporting(0);
		$this->CI =& get_instance();
		$this->soapC = new SoapClient($this->uri_service, array('trace' => 1));	
		set_time_limit(900);
		} catch (Exception $e) {
			
		}
		
}
  //------------------------------------------------------------------------------------------------------------------------
function init()
{
		$this->oDataWS = new \stdClass;
		$this->oDataWS->Credentials = new \stdClass;
		$this->oDataWS->Credentials->UserName = 'GAP#aCap%2015';
		$this->oDataWS->Credentials->Password = 'CAP15gap20Ag';
		//$this->oDataWS->Credentials->CodeAuth = 'vsDMquPhx68SZrY8wGcxEh2bk1XiPlR0EZkBVLmax3A4Mab7sDeeyodY3BjDuyB';
		$this->oDataWS->CredentialsUserSICAS = new \stdClass;
		if($this->CI->tank_auth->get_UserSICAS() == "" && $this->oDataWS->CredentialsUserSICAS->Password = $this->CI->tank_auth->get_PassSICAS() == ""){
			$this->oDataWS->CredentialsUserSICAS->UserName = "SISTEMAS@ASESORESCAPITAL.COM";
			$this->oDataWS->CredentialsUserSICAS->Password = "ACHAN2019";
		}else{
			$this->oDataWS->CredentialsUserSICAS->UserName = $this->CI->tank_auth->get_UserSICAS();
			$this->oDataWS->CredentialsUserSICAS->Password = $this->CI->tank_auth->get_PassSICAS();
		}				
}


//-------------------------------------------------------------------------------------------------
public function bitacora($array){
  /*VALORES QUE SE PUEDEN MODIFICAR IDBit,ClaveBit,Prioridad,Procedencia,Comentario*/
    if(isset($array['ClaveBit']))
  {
    $encriptado='<InfoData><DatBitacora>';
    foreach($array as $key => $value)
     {  $encriptado=$encriptado.'<'.$key.'>'.$value.'</'.$key.'>';   }
     $encriptado=$encriptado.'</DatBitacora></InfoData>';
       
     $encriptado=$this->encripta($encriptado);
    $respuesta=$this->grabarActualizasDatos('H04270',$encriptado);

       
    $respuesta=$this->decodificaXML($respuesta);  

  }

   /* $quitar = array(
            '<p>','</p>','<br />','<br>','&nbsp;','&acute;','&quot;','&uml;',
            '&Ntilde;','&ntilde;','&iquest;','&iexcl;','&uuml;','&Uuml;',
            '&aacute;','&eacute;','&iacute;','&oacute;','&uacute;',
            '&Aacute;','&Eacute;','&Iacute;','&Oacute;','&Uacute;',
            '&agrave;','&egrave;','&igrave;','&ograve;','&ugrave;',
            '&Agrave;','&Egrave;','&Igrave;','&Ograve;','&Ugrave;',
            '&lt;','&gt;',
            );
    $poner  = array(
            '','','\r\n','\r\n','','','','',
            'Ñ','ñ','¿','¡','u','U',
            'á','é','í','ó','ú',
            'Á','É','Í','Ó','Ú',
            'à','è','ì','ò','ù',
            'À','È','Ì','Ò','Ù',
            '<','>',
            );

    $wsKeycode = "H04270";
    $wsTipo = "Save_Data";
    $wsTextoPlano = "<InfoData>
              <DatBitacora>
                <IDBit>-1</IDBit>
                <ClaveBit>".$ClaveBit."</ClaveBit>
                <Prioridad>1</Prioridad>
                <Procedencia>".$Procedencia."</Procedencia>
                <Comentario>".str_replace($quitar,$poner,$Comentario)."</Comentario>
              </DatBitacora>
            </InfoData>";
    $wsNodoExtrae = "DATAINFO";*/



}
//-------------------------------------------
public function actualizarCliente($IDCli){

}


//-------------------------------------------

//-------------------------------------------
public function obtenerClientesParaActualizar($page)
{
/*======BUSCAR AL CLIENTE EN SICAS=======*/
/*
$IDClI=ES EL ID DEL CLIENTE EN SICAS EL CUAL DEBE SER UN ENTERO(1,2,3,5..)
 */
    $datos['TipoEntidad']='0';
    $datos['TypeDestinoCDigital']='CONTACT';
    $datos['IDValuePK']='0';
    $datos['ActionCDigital']='GETFiles';
    $datos['TypeFormat']='XML';
    $datos['TProct']='Read_Data';
    $datos['KeyProcess']='REPORT';
    //$datos['KeyCode']='HDS00002';
    $datos['KeyCode']='HWS_CLI';
    $datos['Page']=$page;
    $datos['ItemForPage']='1000';
    $datos['InfoSort']='CatClientes.IDCli';
    $datos['IDRelation']='0';  

   $respuesta = $this->getDatosSICAS($datos);

    return $respuesta;
}

//--------------------------------------------------------------
public function obtenerClientePorID($IDCli){
/*======BUSCAR AL CLIENTE EN SICAS=======*/
/*
$IDClI=ES EL ID DEL CLIENTE EN SICAS EL CUAL DEBE SER UN ENTERO(1,2,3,5..)
 */
    $datos['TipoEntidad']='0';
    $datos['TypeDestinoCDigital']='CONTACT';
    $datos['IDValuePK']='0';
    $datos['ActionCDigital']='GETFiles';
    $datos['TypeFormat']='XML';
    $datos['TProct']='Read_Data';
    $datos['KeyProcess']='REPORT';
    $datos['KeyCode']='HDS00002';
    $datos['Page']='1';
    $datos['ItemForPage']='2000';
    $datos['InfoSort']='CatClientes.IDCli';
    $datos['IDRelation']='0';
    if($IDCli==null){
     //$datos['ConditionsAdd']='IDCli;2;0;'.$IDCli.';'.$IDCli.';CatClientes.IDCli';
    }
    else{$datos['ConditionsAdd']='IDCli;2;0;'.$IDCli.';'.$IDCli.';CatClientes.IDCli';}
	       
   // $respuesta=$this->obtenerDatos($datos);
   $respuesta = $this->getDatosSICAS($datos);

    return $respuesta;
}
//----------------------------------------------------------------------------------------------------------------------------

public function  obtenerClienteInfo($IDCont){

/*======BUSCAR AL CLIENTE EN SICAS NOS PROPORCIONA OTROS DATOS QUE LA FUNCION HDS00002 COMO EL TELEFONO======*/
/*
$IDClI=ES EL ID DEL CLIENTE EN SICAS EL CUAL DEBE SER UN ENTERO(1,2,3,5..)
 */
    $datos['TipoEntidad']='0';
    $datos['TypeDestinoCDigital']='CONTACT';
    $datos['IDValuePK']='0';
    $datos['ActionCDigital']='GETFiles';
    $datos['TypeFormat']='XML';
    $datos['TProct']='Read_Data';
    $datos['KeyProcess']='REPORT';
    $datos['KeyCode']='HWS_CLI';
    $datos['Page']='1';
    $datos['ItemForPage']='2000';
    $datos['InfoSort']='CatClientes.IDCli';
    $datos['IDRelation']='0';
    $datos['ConditionsAdd']='IDCli;2;0;'.$IDCont.';'.$IDCont.';CatClientes.IDCli';
            
   // $respuesta=$this->obtenerDatos($datos);
   $respuesta = $this->getDatosSICAS($datos);

    return $respuesta;

}
//----------------------------------------------------------------------------------------------------------------------------
public function obtenerClientesPorVendedor($idVendedor,$nombre){
/*======SE BUSCA A CLIENTES DEL VENDEDOR QUE TENGAN UNA COINICIDENCIA CON  EL NOMBRE =====*/
/*
$idVendedor=ID DE VENDEDOR EN SICAS DEBE SER UN ENTERO(1,2,3)
$nombre=ES EL STRING QUE VAMOS A BUSCAR EN LOS NOMBRE DEL CLIENTE(PEDRO,PEREZ)
 */
    $datos['TipoEntidad']='0';
    $datos['TypeDestinoCDigital']='CONTACT';
    $datos['IDValuePK']='0';
    $datos['ActionCDigital']='GETFiles';
    $datos['TypeFormat']='XML';
    $datos['TProct']='Read_Data';
    $datos['KeyProcess']='REPORT';
    $datos['KeyCode']='HDS00002';
    $datos['Page']='1';
    $datos['ItemForPage']='2000';
    $datos['InfoSort']='CatClientes.NombreCompleto';
    $datos['IDRelation']='0';
    $datos['ConditionsAdd']='VendedorID;2;0;'.$idVendedor.';'.$idVendedor.';CatClientes.FieldInt1 ! Nombre Completo;0;0;*'.$nombre.'*;*'.$nombre.'*;0;-1;CatClientes.NombreCompleto ';
 
   // $respuesta=$this->obtenerDatos($datos);
   $respuesta = $this->getDatosSICAS($datos);

    return $respuesta;
   

}

//---------------------------------------------------------------------------------------------------------------------------


//---------------------------------------------------------------------------------------------------------------------------
public function obtenerDatosAgente($IDVend){
/*========OBTIENE DATOS DEL VENDEDOR===========*/
/*
$IDVend=ES EL ID DEL VENDEDOR EN SICAS DEBE SER UN ENTERO(1,2..)
 */


    $D_Cred=new stdClass();
    //$datoCredenciales['username']="nombre";
    //$datoCredenciales['Password']="passwor";
   // $datoCredenciales['CodeAuth']="codigo";
   
    $datos['TipoEntidad']='0';
    $datos['TypeDestinoCDigital']='CONTACT';
    $datos['IDValuePK']='0';
    $datos['ActionCDigital']='GETFiles';
    $datos['TypeFormat']='XML';
    $datos['TProct']='Read_Data';
    $datos['KeyProcess']='REPORT';
    $datos['KeyCode']='HWS_VEND';
    $datos['Page']='1';
    $datos['ItemForPage']='1000';
    $datos['InfoSort']='CatVendedores.IDVend';
    $datos['IDRelation']='0';
    $datos['ConditionsAdd']='devueltos;0;0;'.$IDVend.';'.$IDVend.';IDVend';
	       
    //$respuesta=$this->obtenerDatos($datos);
     $respuesta=$this->getDatosSICAS($datos);
  
    return $respuesta;

}

//----------------------------------------------------------------------------------------------------------------------------
public function crearContactoSicas()
{
/*=====CREA UN CONTACTO EN EL SICAS QUE SE DEBE RELACIONAR CON UN VENDEDOR EL CUAL ALMACENARA DATOS COMO TELEFONO,EMAIL ======*/
  $TextEncript='<InfoData><CatContactos><IDCont>-1</IDCont></CatContactos></InfoData>';

  $encriptado=$this->encripta($TextEncript);
  $respuesta=$this->grabarActualizasDatos('HCONTACT',$encriptado);
  $respuesta=$this->decodificaXML($respuesta);  
  return $respuesta;
}



//---------------------------------------------------------------------------------------------
public function crearVendedorSicas($idContacto){
   /*====CREA VENDEDOR EN EL SICAS EL VENDEDOR TIENE QUE TENER UNA RELACION CON CONTACTO PARA VISUALIZARLO EN EL SICAS */
/*
$idContacto= ES EL ID DE CONTACTA CON EL QUE SE VA A RELACIONAR EL VENDEDOR DEBE SER UN ENTERO(1,2,3)
 */
   $TextEncript='<InfoData><CatVendedores><IDVend>-1</IDVend><IDDespacho>1</IDDespacho><IDCont>'.$idContacto.'</IDCont><Status>0</Status><GenComision>1</GenComision></CatVendedores></InfoData>';
   $encriptado=$this->encripta($TextEncript);
  $respuesta=$this->grabarActualizasDatos('H01110',$encriptado);
  $respuesta=$this->decodificaXML($respuesta);
  return $respuesta;
}
//----------------------------------------------------------------------------------------------------------------------------
public function modificarCliente($array){
/*MODIFICA CLIENTE*/

  if(isset($array['IDCli'])){  
        $encriptado='<InfoData><CatClientes>';
            foreach($array as $key => $value){  $encriptado=$encriptado.'<'.$key.'>'.$value.'</'.$key.'>';   }
     $encriptado=$encriptado.'</CatClientes></InfoData>';
     $encriptado=$this->encripta($encriptado);
    $respuesta=$this->grabarActualizasDatos('H02000',$encriptado) ;      
    $respuesta=$this->decodificaXML($respuesta); 
   
   return $respuesta; 
    }

}
//---------------------------------------------------------------------------------------------------------------
public function actualizaOT($arrayOT){
/*ACTUALIZA UNA ORDEN DE TRABAJO(OT) */
$respuesta=array();
if(isset($arrayOT['IDDocto'])){

      $encriptado='<InfoData><DatDocumentos>';
    foreach($arrayOT as $key => $value){  $encriptado=$encriptado.'<'.$key.'>'.$value.'</'.$key.'>';   }
     $encriptado=$encriptado.'</DatDocumentos></InfoData>';

     $encriptado=$this->encripta($encriptado);
    $respuesta=$this->grabarActualizasDatos('HWCAPTURE',$encriptado);       
    $respuesta=$this->decodificaXML($respuesta); 
  
   return $respuesta;     
  }

}

//-----------------------------------------------------
public function actualizaTarea($arrayOT){
/*ACTUALIZA UNA ORDEN DE TRABAJO(OT) */
$respuesta=array();
unset($arrayOT['Concepto']);
unset($arrayOT['FEmision']);
if(isset($arrayOT['IDTarea'])){
      $encriptado='<InfoData><DatTareas>';
    foreach($arrayOT as $key => $value){  $encriptado=$encriptado.'<'.$key.'>'.$value.'</'.$key.'>';   }
     $encriptado=$encriptado.'</DatTareas></InfoData>';
     $encriptado=$this->encripta($encriptado);
    $respuesta=$this->grabarActualizasDatos('H04245',$encriptado);       
    $respuesta=$this->decodificaXML($respuesta); 

   return $respuesta;     
  }

}

//-----------------------------------------------------
public function actualizarVendedorSicas($arrayVendedor){
	/*===============ACTUALIZA AL VENDEDOR EN SICA===================*/
	/*$arrayVendedor=ES UN ARREGLO CON CAMPOS PARA ACTUALIZAR EN SICAS EN VENDEDORES Y TIENE QUE TENER POR OBLIGACION EL CAMPO IDVend 
	*/
   /*
   EJEMPLO DEL ARRAY
     $arreglo['IDVend']=$datosPersona->IDVend;
  $arreglo['CCosto']=$datosPersona->idpersonarankingagente;
  $arreglo['IDDespacho']=$this->PersonaModelo->buscarIdDespachoSicas($datosPersona->id_catalog_sucursales)->idDespachoSicas;
  $arreglo['IDCatCom']=$datosVendedor->honorariosCVH;
  $arreglo['IDVendNS']=$datosVendedor->IDVendNS;
  $arreglo['TipoVend']=$this->PersonaModelo->buscarTipoVendedorSicas($datosPersona->personaTipoAgente)->idTipoVendedorSicas;
 $arreglo['IDGerencia']=$this->PersonaModelo->buscarGerenciaSicasEnCatalogCanales($datosPersona->id_catalog_canales)->idGerenciaSicas;
    */
	
  if(isset($arrayVendedor['IDVend']))
  {
  	$encriptado='<InfoData><CatVendedores>';
    foreach($arrayVendedor as $key => $value)
     {  $encriptado=$encriptado.'<'.$key.'>'.$value.'</'.$key.'>';   }
     $encriptado=$encriptado.'</CatVendedores></InfoData>';
       
     $encriptado=$this->encripta($encriptado);
    $respuesta=$this->grabarActualizasDatos('H01110',$encriptado);

       
    $respuesta=$this->decodificaXML($respuesta);
    return $respuesta;  
  }

}
//----------------------------------------------------------------------------------------------------------------------------
public function actualizarContactoVendedorSicas($arrayContacto){
/*=========NOS SIRVE PARA ACTUALIZAR EL CONTACTO DEL VENDEDOR EN SICAS======================*/
	/*======$arrayVendedor=ES UN ARREGLO CON CAMPOS PARA ACTUALIZAR EN SICAS EL CONTACTO DEL VENDEDORES Y TIENE QUE TENER POR OBLIGACION EL CAMPO IDCont */

/*ARREGLO BASICO*/
/*======
  $arregloContacto['IDCont']=$datosPersona->idContactoSicas;
  $arregloContacto['Nombre']=$datosPersona->nombres;
  $arregloContacto['ApellidoP']=$datosPersona->apellidoPaterno;
  $arregloContacto['ApellidoM']=$datosPersona->apellidoMaterno;
  $arregloContacto['Email1']= $datosUser->email;
  $arregloContacto['FechaNac']= $this->convierteFecha($datosPersona->fechaNacimiento);
  $arregloContacto['CURP']= $datosPersona->curpPersona;
  $arregloContacto['RFC']= $datosPersona->rfc;
  $arregloContacto['EstadoNac']= $datosPersona->estadoNacimiento;
  $arregloContacto['LugarNac']= $datosPersona->paisNacimiento;
  $arregloContacto['Telefono1']= $datosPersona->celPersonal;
 */
  if(isset($arrayContacto['IDCont']))
  {
  	$encriptado='<InfoData><CatContactos>';
    foreach($arrayContacto as $key => $value)
     {  $encriptado=$encriptado.'<'.$key.'>'.$value.'</'.$key.'>';   }
     $encriptado=$encriptado.'</CatContactos></InfoData>';
       
     $encriptado=$this->encripta($encriptado);
    $respuesta=$this->grabarActualizasDatos('HCONTACT',$encriptado); 
      
    $respuesta=$this->decodificaXML($respuesta);  
    return $respuesta;
  }
}

//----------------------------------------------------------------------------------------------------------------------------

private function decodificaXML($xml){
	$xml = preg_replace('/(<\/?)(\w+):([^>]*>)/', '$1$2$3', $xml);
   $xml = simplexml_load_string($xml);
   $json = json_encode($xml);
   $responseArray = json_decode($json,true);
   $array=json_decode($responseArray['soapBody']['ProcesarWSResponse']['ProcesarWSResult'],true);
  return $array;
}
//----------------------------------------------------------------------------------------------------------------------------

public function actualizarContactoSicas($arrayOT)
{
$respuesta=array();

if(isset($arrayOT['IDCont'])){
      $encriptado='<InfoData><CatContactos>';
    foreach($arrayOT as $key => $value){  $encriptado=$encriptado.'<'.$key.'>'.$value.'</'.$key.'>';   }
     $encriptado=$encriptado.'</CatContactos></InfoData>';


         
     $encriptado=$this->encripta($encriptado);
    $respuesta=$this->grabarActualizasDatos('HDATACONTACT',$encriptado); 
    
          
    $respuesta=$this->decodificaXML($respuesta); 
    $fp = fopen('resultadoJason.txt', 'a');fwrite($fp, print_r( $respuesta, TRUE));fclose($fp); 
}
   return $respuesta;  
}
//-----------------------------------------------------------------

public  function  envioMensualAgentes($IDVend,$fechaInicial,$fechaFinal){
		/*====FORMATO DEL MANEJO DE LA FECHA 10/9/2018=========*/

    $datos['TipoEntidad']='0';
    $datos['TypeDestinoCDigital']='CONTACT';
    $datos['IDValuePK']='0';
    $datos['ActionCDigital']='GETFiles';
    $datos['TypeFormat']='XML';
    $datos['TProct']='Read_Data';
    $datos['KeyProcess']='REPORT';
    $datos['KeyCode']='H02930_003';
    $datos['Page']='1';
    $datos['ItemForPage']='1000';
    $datos['InfoSort']='DatHonRecibos.Status_TXT';
    $datos['IDRelation']='0';
    // $datos['ConditionsAdd']='Recibos;0;0;1;Pagados;1;-1;DatHonRecibos.Pagado ! Desde|Hasta|Fecha de Pago;3;0;'.$fechaInicial.'|'.$fechaFinal.';'.$fechaInicial.'|'.$fechaFinal.';0;-1;DatHonDocto.FPago ! VendedorID;2;0;'.$IDVend.';0;DatHonRecibos.IDVE' ;
    $datos['ConditionsAdd']='Recibos;0;0;1;Pagados;1;-1;DatHonRecibos.Pagado ! FPago;3;0;'.$fechaInicial.'|'.$fechaFinal.';0;-1;DatHonRecibos.FPago ! VendedorID;2;0;'.$IDVend.';0;DatHonRecibos.IDVE' ;

          //$datos['ConditionsAdd']='Desde|Hasta|Fecha de Pago;2;0;'.$fechaInicial.'|'.$fechaFinal.';'.$fechaInicial.'|'.$fechaFinal.';0;-1;DatHonDocto.FPago ! VendedorID;2;0;'.$IDVend.';0;DatHonRecibos.IDVE' ;
    //$respuestaSicas=$this->obtenerDatos($datos);
      $respuesta=$this->getDatosSICAS($datos);
    return $respuesta;

  }

//---------------------------------
public function obtenerCobranzaEfectuada($vendedor,$fechaI,$fechaF){
/*===== ESTE KEY CODE NOS SIRVE PARA OBTENER LA COBRANZA EFECTUADA TANTO PAGADA COMO LIQUIDA DEL VENDEDOR========*/
/*
$fechaI=A LA FECHA EN QUE SE VA A EMPEZAR A BUSCAR LA COBRANZA (10/9/2018)
$fechaf=A LA FECHA EN QUE SE VA A TERMINAR LA BUSQUEDA (10/9/2018)
$vendedor= ES EL ID DEL VENDEDOR EN SICAS EL CUAL DEBE SER UN ENTERO(1,2,45,67)

 */

 $datos['TipoEntidad']='0';
       $datos['TypeDestinoCDigital']='CONTACT';
       $datos['IDValuePK']='0';
       $datos['ActionCDigital']='GETFiles';
       $datos['TypeFormat']='XML';
       $datos['TProct']='Read_Data';
       $datos['KeyProcess']='REPORT';
       $datos['KeyCode']='H03430_003';
       $datos['Page']=$this->numeroPagina;
       $datos['ItemForPage']='1000';
       $datos['InfoSort']='VDatDocumentos.IDDocto';
       $datos['IDRelation']='0';

    if($vendedor>0)
    {
     $datos['ConditionsAdd']='       
       Desde|Hasta;3;0;'.$fechaI.'|'.$fechaF.';0;-1;VDatRecibos.FDesde ! Documento;0;0;1;1;DatDocumentos.TipoDocto ! Status;0;3;3;0;VDatRecibos.Status ! VendedorID;2;0;'.$vendedor.';'.$vendedor.';CatVendedores.IdVend';
    }
    else{$datos['ConditionsAdd']=' Desde|Hasta;3;0;'.$fechaI.'|'.$fechaF.';0;-1;VDatRecibos.FDesde  ! Status;3;0;3|4;0;-1;VDatRecibos.Status';
         // $datos['ConditionsAdd']=' Desde|Hasta;3;0;'.$fechaI.'|'.$fechaF.';0;-1;VDatRecibos.FDesde  ! Status;0;4;4;0;VDatRecibos.Status';
    }
  
    do{
    $datos['Page']=$this->numeroPagina;
     $respuesta=$this->obtenerDatos($datos);

     $this->numeroPagina=$this->numeroPagina+1;
     foreach($respuesta->TableInfo as $value){
       	    	array_push($this->tableInfo,$value);
       	    }
       
    }while((int)$respuesta->TableControl->Pages[0]>(int)$respuesta->TableControl->Page[0]);
    return $this->tableInfo;


}


//----------------------------------------------------------------------------------------------------------------------------
public function obtenerRecibosPorFecha($fechaInicial,$fechaFinal,$array)
{
/*OBTIENE LOS RECIBOS POR FECHADOCTO=VDatPagosRec.FDocto POR RANGO DE FECHA
  $fechaInicial=ES UN STRING CON FORMATO DIA-MES-AÑO
  $fechaFinal=ES UN STRING CON FORMATO DIA-MES-AÑO
  $array=ES UN ARRAY PARA CUALQUIER OTRA INFORMACION QUE SE DESEA PROCESAR
*/
  
  $D_Cred=new stdClass();	
    $datoCredenciales['username']="nombre";
    $datoCredenciales['Password']="passwor";
    $datoCredenciales['CodeAuth']="codigo";
    $datos['TipoEntidad']='0';
    $datos['TypeDestinoCDigital']='CONTACT';
    $datos['IDValuePK']='0';
    $datos['ActionCDigital']='GETFiles';
   // $datos['TypeFormat']='JSON';
    $datos['TypeFormat']='XML';
    $datos['TProct']='Read_Data';
    $datos['KeyProcess']='REPORT';
    $datos['KeyCode']='H03430_001';
    $datos['Page']='1';
    $datos['ItemForPage']='1000';
    $datos['InfoSort']='VDatDocumentos.IDDocto';
   $datos['IDRelation']='0';
  //Status;3;0;3|4;0;-1;VDatRecibos.Status
   //$datos['ConditionsAdd']='IDDocto;0;0;'.$recibo.';'.$recibo.';VDatRecibos.IDRecibo';
   
  // $datos['ConditionsAdd']='IDDocto;2;0;161518|2190|246|2510;0;-1;VDatRecibos.IDRecibo';

 $datos['ConditionsAdd']='Desde|Hasta;3;0;'.$fechaInicial.'|'.$fechaFinal.';0;-1;VDatPagosRec.FDocto';
 /*$datos['ConditionsAdd']='Desde|Hasta;2;0;'.$fechaInicial.';0;-1;VDatPagosRec.FDocto';

     
$respuesta=$this->getDatosSICAS($datos);
return $respuesta;*/

       do{      
    $datos['Page']=$this->numeroPagina;
     //$respuesta=$this->obtenerDatos($datos);
$respuesta=$this->getDatosSICAS($datos);

     $this->numeroPagina=$this->numeroPagina+1;
     foreach($respuesta->TableInfo as $value){
       	    	array_push($this->tableInfo,$value);
       	    }
       
    }while((int)$respuesta->TableControl->Pages[0]>(int)$respuesta->TableControl->Page[0]);


    return $this->tableInfo;
}

//----------------------------------------------------------------------------------------------------------------------------



public function obtenerRecibosPorFechaDia($fechaInicial,$fechaFinal,$array)
{
 /*OBTIENE LOS RECIBOS POR FECHADOCTO=VDatPagosRec.FDocto POR RANGO DE FECHA
  $fechaInicial=ES UN STRING CON FORMATO DIA-MES-AÑO
  $fechaFinal=ES UN STRING CON FORMATO DIA-MES-AÑO
  $array=ES UN ARRAY PARA CUALQUIER OTRA INFORMACION QUE SE DESEA PROCESAR
 */
    $D_Cred=new stdClass(); 
   $datoCredenciales['username']="nombre";
   $datoCredenciales['Password']="passwor";
   $datoCredenciales['CodeAuth']="codigo";
   $datos['TipoEntidad']='0';
   $datos['TypeDestinoCDigital']='CONTACT';
   $datos['IDValuePK']='0';
   $datos['ActionCDigital']='GETFiles';
   // $datos['TypeFormat']='JSON';
   $datos['TypeFormat']='XML';
   $datos['TProct']='Read_Data';
   $datos['KeyProcess']='REPORT';
   $datos['KeyCode']='H03430_001';
   $datos['Page']='1';
   $datos['ItemForPage']='1000';
   $datos['InfoSort']='VDatDocumentos.IDDocto';
   $datos['IDRelation']='0';

   $datos['ConditionsAdd']='Desde|Hasta;2;0;'.$fechaInicial.';0;-1;VDatPagosRec.FDocto';
    
  $respuesta=$this->getDatosSICAS($datos);
     
  return $respuesta;  
}

//------------------------------------------------------------------------------

public function obtenerRecibo($recibo){
	/*OBTIENE LOS RECIBOS PAGADOS DE LA POLZA ESTE LO ENLAZA CON COBRANZA PENDIENTE
    $recibo= ES UN STRING QUE CORRESPANDEAL IDRECIBO(IDRecibo) PUEDES SER UNA CADENA CONCATENADA CON | 
             EJEMPLOS(161518 O 161518|246|1875|2190|2305|2490|2499|2510|182374| PARA BUSCAR VARIOS RECIBOS)
	*/
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
    $datos['KeyCode']='H03430_001';
    $datos['Page']='1';
    $datos['ItemForPage']='1000';
    $datos['InfoSort']='VDatDocumentos.IDDocto';
   $datos['IDRelation']='0';
   $datos['ConditionsAdd']='IDDocto;2;0;'.$recibo.';0;-1;VDatRecibos.IDRecibo';

       do{
    $datos['Page']=$this->numeroPagina;
     $respuesta=$this->obtenerDatos($datos);

     $this->numeroPagina=$this->numeroPagina+1;
     foreach($respuesta->TableInfo as $value){
       	    	array_push($this->tableInfo,$value);
       	    }
       
    }while((int)$respuesta->TableControl->Pages[0]>(int)$respuesta->TableControl->Page[0]);

    return $this->tableInfo;
      
}
//----------------------------------------------------------------------------------------------------------------------------
public function obtenerReciboPorID($IDRecibo){
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
    $datos['KeyCode']='H03430_001';
    $datos['Page']='1';
    $datos['ItemForPage']='1000';
    $datos['InfoSort']='VDatDocumentos.IDDocto';
   $datos['IDRelation']='0';
   $datos['ConditionsAdd']='IDRecibo;2;0;'.$IDRecibo.';0;-1;VDatRecibos.IDRecibo';

       do{
    $datos['Page']=$this->numeroPagina;
    // $respuesta=$this->obtenerDatos($datos);
    $respuesta=$this->getDatosSICAS($datos);
    
     $this->numeroPagina=$this->numeroPagina+1;
     foreach($respuesta->TableInfo as $value){array_push($this->tableInfo,$value);}
       
    }while((int)$respuesta->TableControl->Pages[0]>(int)$respuesta->TableControl->Page[0]);

    return $this->tableInfo;
} 
//-------------------------------------------------------------------------------------------------------------------------
public function pruebaWS(){
	//$doc="1511151000134948";1043
	/*documento anual=111204*/
	/*documento mensual=109627*/
	$doc="106418";
	$D_Cred=new stdClass();
    $datoCredenciales['username']="nombre";
    $datoCredenciales['Password']="passwor";
    $datoCredenciales['CodeAuth']="codigo";
    $datos['TipoEntidad']='0';
    $datos['TypeDestinoCDigital']='CONTACT';
    $datos['IDValuePK']='0';
    $datos['ActionCDigital']='GETFiles';
    $datos['TypeFormat']='JSON';
    $datos['TProct']='Read_Data';
    $datos['KeyProcess']='REPORT';
    $datos['KeyCode']='H03430_001';
    $datos['Page']='1';
    $datos['ItemForPage']='1000';
   $datos['InfoSort']='VDatDocumentos.IDDocto';//H03430_001 FUNCIONA
   //$datos['InfoSort']='VDatPagosRec.FDocto';
     //$datos['InfoSort']='VDATRECIBOS.IDRECIBO';
//VDatPagosRec.FDocto $datos['ConditionsAdd']='Desde|Hasta;3;0;01-02-2019|13-02-2019;0;-1;DatDocumentos.FDesde';
   $datos['ConditionsAdd']='Desde|Hasta;3;0;01-01-2018|30-11-2018;0;-1;VDatPagosRec.FDocto';
 
    //$datos['InfoSort']='VDatDocumentos.IDDocto';//H03430_003
    //$datos['InfoSort']='VDatDocumentos.IDDocto';//H03400
    //$datos['InfoSort']='VDatDocumentos.IDDocto';//H02790
    //$datos['InfoSort']='VDatDocumentos.IDDocto';//HDS00007
    
    //$datos['InfoSort']='VDatDocumentos.IDDocto';//H02770
      // $datos['InfoSort']='VDATRECIBOS.IDRECIBO';//H03611_002
   $datos['IDRelation']='0';
  // $datos['ConditionsAdd']='DOCUMENTO;0;0;'.$doc.';'.$doc.';DatDocumentos.IDDocto';
   //$datos['ConditionsAdd']='IDVend;0;0;1;1;DatDocumentos.IDVend';
  //$datos['ConditionsAdd']='Desde|Hasta;3;0;01-02-2019|13-02-2019;0;-1;DatDocumentos.FechaPago';
//    $datos['ConditionsAdd']='Desde|Hasta;3;0;01-02-2019|13-02-2019;0;-1;DatDocumentos.FDesde';

  //$datos['ConditionsAdd']='IDDocto;0;0;4568;4568;VDatRecibos.IDRecibo';
    $respuesta=$this->obtenerDatos($datos);
    return $respuesta;

      
}
//----------------------------------------------------------------------------------------------------------------------------
public function buscarDocumentoAnterior($idDocto){
                $datos['TipoEntidad']='0';
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
        $datos['ConditionsAdd']='Documento;0;0;'.$idDocto.';'.$idDocto.';DatDocumentos.Documento';
        
        $respuesta=$this->getDatosSICAS($datos);

        return $respuesta;

}
//----------------------------------------------------------------------------------------------------------------------------
function buscarDocumentoPorIDSicas($IdSikas){
  /*========SE BUSCA DE ACUERDO AL idSicas QUE SE OBTIENEN AL CREAR ACTIVIDADES TAMBIEN ES UN VINCULO PARA VER LA OT EN SICAS========*/
  /*======== SI EN EL CAMPO Documento DEVUELTO POR LA CONSULTA YA NO TIENE OT SIGNIFICA QUE YA SE CONVIRTIO EN POLIZA=========*/
            $datos['TipoEntidad']='0';
          $datos['TypeDestinoCDigital']='CONTACT';
          $datos['IDValuePK']='0';
          $datos['ActionCDigital']='GETFiles';
          $datos['TypeFormat']='XML';
          $datos['TProct']='Read_Data';
          $datos['KeyProcess']='REPORT';
          //$datos['KeyCode']='H03430_003';
          $datos['KeyCode']='HWS_DOCTOS';
          $datos['Page']='1';
          $datos['ItemForPage']='10';
          $datos['InfoSort']='VDatDocumentos.IDDocto';
          $datos['IDRelation']='0';
          $datos['ConditionsAdd']='IDDocto;0;0;'.$IdSikas.';'.$IdSikas.';DatDocumentos.IDDocto';
                  $respuesta=$this->getDatosSICAS($datos);

        return $respuesta;
}

//------------------------------------------------------------
public function buscaDocumento($documento)
{
	/*EJEMPLO POLVA VERDE prueba30*/
	//$documento="prueba30";
	 $datos['TipoEntidad']='0';
       $datos['TypeDestinoCDigital']='CONTACT';
       $datos['IDValuePK']='0';
       $datos['ActionCDigital']='GETFiles';
       $datos['TypeFormat']='XML';
       $datos['TProct']='Read_Data';
       $datos['KeyProcess']='REPORT';
       $datos['KeyCode']='HWS_DOCTOS';
       $datos['Page']=$this->numeroPagina;
       $datos['ItemForPage']='1000';
       $datos['InfoSort']='VDatDocumentos.IDDocto';
       $datos['IDRelation']='0';
      $datos['ConditionsAdd']='IDDocto;0;0;'.$documento.';'.$documento.';DatDocumentos.Documento';
     // $datos['ConditionsAdd']='IDDocto;0;0;'.$documento.';'.$documento.';DatDocumentos.IDDocto';
     // $respuesta=$this->obtenerDatos($datos);
 $respuesta=$this->getDatosSICAS($datos);
 return $respuesta;

}



//----------------------------------------------------------------------------------------------------------
function buscaDocumentoPoliza($folio){

      //$D_Cred=new stdClass();
        /* $datoCredenciales['username']="nombre";
         $datoCredenciales['Password']="passwor";
         $datoCredenciales['CodeAuth']="codigo";*/
        $datos['TipoEntidad']='0';
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

           $datos['ConditionsAdd']='Documento;0;0;'.$folio.';'.$folio.';DatDocumentos.Documento  ';
    
 

$respuesta=$this->obtenerDatos2($datos);

 return $respuesta;

}
//----------------------------------------------
public function obtenerRecibosPorDocumento($Documento='',$idDocto='')
{
        $datos['TipoEntidad']='0';
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
         if($idDocto==''){$datos['ConditionsAdd']='Documento;2;0;'.$Documento.';'.$Documento.';DatDocumentos.Documento  ';}
         else{$datos['ConditionsAdd']='Documento;2;0;'.$idDocto.';'.$idDocto.';DatDocumentos.IDDocto';}
    


 $respuesta=$this->getDatosSICAS($datos);
 return $respuesta;


}
//----------------------------------------------------------------------

public function obtenerCobranzaEfectuadaPorFolio($folio,$vendedor,$nombreCLiente=null,$statusRecibo=null){
        $datos['TipoEntidad']='0';
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
        $datos2='<TipoEntidad>0</TipoEntidad><TypeDestinoCDigital>CONTACT</TypeDestinoCDigital><IDValuePK>0</IDValuePK><ActionCDigital>GETFiles</ActionCDigital><TypeFormat>XML</TypeFormat><TProct>Read_Data</TProct><KeyProcess>REPORT</KeyProcess><KeyCode>H03430_003</KeyCode><Page>1</Page><ItemForPage>100</ItemForPage><InfoSort>VDatDocumentos.IDDocto</InfoSort><IDRelation>0</IDRelation><ConditionsAdd>Documento;0;0;*4051900005833*;4051900005833;DatDocumentos.Documento</ConditionsAdd>';
       
       if($nombreCLiente!=null)
       {
         if($statusRecibo==null){$statusRecibo=0;}
    if($vendedor>0)
    {
         //$datos['ConditionsAdd']='Documento;0;0;*'.$nombreCLiente.'*;'.$nombreCLiente.';DatDocumentos.Documento ! VendedorID;0;0;'.$vendedor.';'.$vendedor.';CatVendedores.IdVend';
         $datos['ConditionsAdd']='Documento;2;0;1|2;1|2;DatDocumentos.TipoDocto !  Status;0;'.$statusRecibo.';'.$statusRecibo.';0;VDatRecibos.Status !  Nombre Completo;0;0;*'.$nombreCLiente.'*;*'.$nombreCLiente.'*;0;-1;CatClientes.NombreCompleto ! VendedorID;0;0;'.$vendedor.';'.$vendedor.';CatVendedores.IdVend';
    }
       else
       {
         $datos['ConditionsAdd']='Documento;2;0;1|2;1|2;DatDocumentos.TipoDocto !  Status;0;'.$statusRecibo.';'.$statusRecibo.';0;VDatRecibos.Status !  Nombre Completo;0;0;*'.$nombreCLiente.'*;*'.$nombreCLiente.'*;0;-1;CatClientes.NombreCompleto';
         // $datos['ConditionsAdd']='Documento;0;0;*'.$folio.'*;'.$folio.';DatDocumentos.Documento  ';
         //$datos['ConditionsAdd']='Desde|Hasta;3;0;'.$array['fechaInicial'].'|'.$array['fechaFinal'].';0;-1;VDatRecibos.'.$array['tipoFecha'].' ! Documento;0;1;1;1;DatDocumentos.TipoDocto ! Status;0;0;0;0;VDatRecibos.Status ! Despacho;0;3;3;1;DatDocumentos.IDDespacho';
        }

       }
       else
       {
         if($statusRecibo==null){$statusRecibo='';}
         else
         {
          $val=$statusRecibo;
          $statusRecibo=' ! Status;0;'.$val.';'.$val.';0;VDatRecibos.Status';
         }

         if($vendedor>0)
        {
         $datos['ConditionsAdd']='Documento;0;0;*'.$folio.'*;*'.$folio.'*;DatDocumentos.Documento ! VendedorID;0;0;'.$vendedor.';'.$vendedor.';CatVendedores.IdVend '.$statusRecibo;
        }
         else{$datos['ConditionsAdd']='Documento;0;0;*'.$folio.'*;*'.$folio.'*;DatDocumentos.Documento  '.$statusRecibo; }

    }
 
$respuesta=$this->obtenerDatos2($datos);
 return $respuesta;


}

//-------------------------------------------------------------------------------------------------
public function cobranza($vendedor,$fechaI,$fechaF,$pagina){

        $datos['TipoEntidad']='0';
        $datos['TypeDestinoCDigital']='CONTACT';
        $datos['IDValuePK']='0';
        $datos['ActionCDigital']='GETFiles';
        $datos['TypeFormat']='XML';
        $datos['TProct']='Read_Data';
        $datos['KeyProcess']='REPORT';
        $datos['KeyCode']='H03430_003';
        $datos['Page']=$pagina;
        $datos['ItemForPage']='1000000';
        $datos['InfoSort']='VDatDocumentos.IDDocto';
        $datos['IDRelation']='0';

       ////// $datos['ConditionsAdd']='Desde|Hasta;3;0;'.$fechaI.'|'.$fechaF.';0;-1;VDatRecibos.FLimPago ! Documento;0;0;1;1;DatDocumentos.TipoDocto ! Status;0;4;4;0;VDatRecibos.Status   ! VendedorID;2;0;'.$vendedor.';'.$vendedor.';CatVendedores.IdVend';
       ////// $datos['ConditionsAdd']='Desde|Hasta;3;0;'.$fechaI.'|'.$fechaF.';0;-1;VDatRecibos.FLimPago ! Documento;0;0;1;1;DatDocumentos.TipoDocto ! Status;4;5;5;0;VDatRecibos.Status   ! VendedorID;2;0;'.$vendedor.';'.$vendedor.';CatVendedores.IdVend ! gerencia;0,0;9;9;0;CATVENDEDORES.IDGERENCIA ! subRamo;0;0;14;14;0;VDatDocumentos.IDSRamo';
        // $datos['ConditionsAdd']='Desde|Hasta;3;0;'.$fechaI.'|'.$fechaF.';0;-1;VDatRecibos.FLimPago ! Documento;4;3;3;0;DatDocumentos.TipoDocto ! Status;4;6;6;0;VDatRecibos.Status   ! VendedorID;2;0;'.$vendedor.';'.$vendedor.';CatVendedores.IdVend';
        if($vendedor=='')
        {
          $datos['ConditionsAdd']='Desde|Hasta;3;0;'.$fechaI.'|'.$fechaF.';0;-1;VDatRecibos.FLimPago ! Documento;4;3;3;0;DatDocumentos.TipoDocto ! Status;4;6;6;0;VDatRecibos.Status';
        }
        else
        {
          $datos['ConditionsAdd']='Desde|Hasta;3;0;'.$fechaI.'|'.$fechaF.';0;-1;VDatRecibos.FLimPago ! Documento;4;3;3;0;DatDocumentos.TipoDocto ! Status;4;6;6;0;VDatRecibos.Status ! VendedorID;2;0;'.$vendedor.';'.$vendedor.';CatVendedores.IdVend';
        }


          $respuesta=$this->getDatosSICAS($datos);

         
       return $respuesta;
      

}
//-----------------------------------------------

public function obtenerReporteCobranza($vendedor,$fechaI,$fechaF,$tipoCobranza){
/*ESTOS SON REPORTES DE cobranza
$tipoCobranza= 	ES EL TIPO DE COBRANZA QUE SE QUIERE OBTENER 0(COBRANZA PENDIENTE),1(COBRANZA CANCELADA),3(COBRANZA EFECTUADA)
*/
        $datos['TipoEntidad']='0';
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
  switch ($tipoCobranza) {
  	case 0:
     if($vendedor>0)
    {
      if($fechaI!=null){
     $datos['ConditionsAdd']='Desde|Hasta;3;0;'.$fechaI.'|'.$fechaF.';0;-1;VDatRecibos.FLimPago ! Documento;0;0;1;1;DatDocumentos.TipoDocto ! Status;0;0;0;0;VDatRecibos.Status   ! VendedorID;2;0;'.$vendedor.';'.$vendedor.';CatVendedores.IdVend';
       }
       else{
     $datos['ConditionsAdd']=' Documento;0;0;1;1;DatDocumentos.TipoDocto ! Status;0;0;0;0;VDatRecibos.Status   ! VendedorID;2;0;'.$vendedor.';'.$vendedor.';CatVendedores.IdVend';
       }
    }
    else{
      if($fechaI!=null){
       $datos['ConditionsAdd']='Desde|Hasta;3;0;'.$fechaI.'|'.$fechaF.';0;-1;VDatRecibos.FLimPago ! Documento;0;0;1;1;DatDocumentos.TipoDocto ! Status;0;0;0;0;VDatRecibos.Status  ';
      } 
             else{
     $datos['ConditionsAdd']=' Documento;0;0;1;1;DatDocumentos.TipoDocto ! Status;0;0;0;0;VDatRecibos.Status ';
       }
    }

  	break;
  	
  	case 1:
    if($vendedor>0)
    {
     $datos['ConditionsAdd']='       
       Desde|Hasta;3;0;'.$fechaI.'|'.$fechaF.';0;-1;VDatRecibos.FDesde ! Documento;0;0;1;1;DatDocumentos.TipoDocto ! Status;0;1;1;0;VDatRecibos.Status ! VendedorID;2;0;'.$vendedor.';'.$vendedor.';CatVendedores.IdVend';
    }
    else{
       $datos['ConditionsAdd']='       
       Desde|Hasta;3;0;'.$fechaI.'|'.$fechaF.';0;-1;VDatRecibos.FDesde ! Documento;0;0;1;1;DatDocumentos.TipoDocto ! Status;0;1;1;0;VDatRecibos.Status  ';
    }
  		break;

  	case 3:
   if($vendedor>0)
    {
     $datos['ConditionsAdd']='       
       Desde|Hasta;3;0;'.$fechaI.'|'.$fechaF.';0;-1;VDatRecibos.FDesde ! Documento;0;0;1;1;DatDocumentos.TipoDocto ! Status;0;3;3;0;VDatRecibos.Status ! VendedorID;2;0;'.$vendedor.';'.$vendedor.';CatVendedores.IdVend';
    }
    else{
           $datos['ConditionsAdd']='       
       Desde|Hasta;3;0;'.$fechaI.'|'.$fechaF.';0;-1;VDatRecibos.FDesde ! Documento;0;0;1;1;DatDocumentos.TipoDocto ! Status;0;3;3;0;VDatRecibos.Status  ';
    }
  
  	break;
  }
  
      $respuesta=$this->getDatosSICAS($datos);
     
      
 return $respuesta;
}
//----------------------------------------------------------------------------------------------------------------------------
function aaa(){
      /*    $datos['TipoEntidad']='0';
        $datos['TypeDestinoCDigital']='CONTACT';
        $datos['IDValuePK']='0';
        $datos['ActionCDigital']='GETFiles';
        $datos['TypeFormat']='XML';
        $datos['TProct']='Read_Data';
        $datos['KeyProcess']='REPORT';
        $datos['KeyCode']='H03430_003';
        $datos['Page']='0';
        $datos['ItemForPage']='2000';
        $datos['InfoSort']='VDatDocumentos.IDDocto';
        $datos['IDRelation']='0';


          $datos['ConditionsAdd']='recibo;2;0;292467;292467;VDatRecibos.IDRecibo';

          $respuesta=$this->getDatosSICAS($datos);*/
        $array['IDRecibo']='292467';
        $array['IDDocto']='123081';
         $array['Status']='1';

       if(isset($array['IDRecibo'])){  
        $encriptado='<InfoData><VDatDocumentos>';
            foreach($array as $key => $value){  $encriptado=$encriptado.'<'.$key.'>'.$value.'</'.$key.'>';   }
     $encriptado=$encriptado.'</VDatDocumentos></InfoData>';

     $encriptado=$this->encripta($encriptado);
    $respuesta=$this->grabarActualizasDatos('H03430_003',$encriptado) ;      
    $respuesta=$this->decodificaXML($respuesta); 
   

    }



       return $respuesta;
}
//-------------------------------------------
function cobranzaReportePorRecibo($recibo)
{
 $respuesta=array();
        $datos['TipoEntidad']='0';
        $datos['TypeDestinoCDigital']='CONTACT';
        $datos['IDValuePK']='0';
        $datos['ActionCDigital']='GETFiles';
        $datos['TypeFormat']='XML';
        $datos['TProct']='Read_Data';
        $datos['KeyProcess']='REPORT';
        $datos['KeyCode']='H03430_003';
        $datos['Page']='1';
        $datos['ItemForPage']='3000';
        $datos['InfoSort']='VDatDocumentos.IDDocto';
        $datos['IDRelation']='0';
       $datos['ConditionsAdd']='IDDocto;2;0;'.$recibo.';0;-1;VDatRecibos.IDRecibo';
      
       $respuesta=$this->getDatosSICAS($datos);
       return $respuesta;
}
//-------------------------------------------
public function cobranzareporte($array,$paginacion=0,$pagina=0){
/*ESTOS SON REPORTES DE COBRANZA
$tipoCobranza=  ES EL TIPO DE COBRANZA QUE SE QUIERE OBTENER 0(COBRANZA PENDIENTE),1(COBRANZA CANCELADA),3(COBRANZA EFECTUADA)
$array['tipoFecha'] FDesde,FHasta,FLimPago,fDoctoPago*/
$respuesta=array();
$tableInfo=array();
        $datos['TipoEntidad']='0';
        $datos['TypeDestinoCDigital']='CONTACT';
        $datos['IDValuePK']='0';
        $datos['ActionCDigital']='GETFiles';
        $datos['TypeFormat']='XML';
        $datos['TProct']='Read_Data';
        $datos['KeyProcess']='REPORT';
        $datos['KeyCode']='H03430_003';
        $datos['Page']='1';
        $datos['ItemForPage']='5000';
        $datos['InfoSort']='VDatDocumentos.IDDocto';
        $datos['IDRelation']='0';
        
     

switch ($array['tipoReporte']) 
{
  case 'cancun':
$datos['ConditionsAdd']='Desde|Hasta;3;0;'.$array['fechaInicial'].'|'.$array['fechaFinal'].';0;-1;VDatRecibos.'.$array['tipoFecha'].' ! Documento;0;1;1;1;DatDocumentos.TipoDocto ! Status;0;0;0;0;VDatRecibos.Status ! Despacho;0;3;3;1;DatDocumentos.IDDespacho';
    break;
  case 'fianzas':
$datos['ConditionsAdd']='Desde|Hasta;3;0;'.$array['fechaInicial'].'|'.$array['fechaFinal'].';0;-1;VDatRecibos.'.$array['tipoFecha'].' ! Documento;0;2;2;1;DatDocumentos.TipoDocto ! Status;0;0;0;0;VDatRecibos.Status';
  break;
case 'institucional':
$datos['ConditionsAdd']='Desde|Hasta;3;0;'.$array['fechaInicial'].'|'.$array['fechaFinal'].';0;-1;VDatRecibos.'.$array['tipoFecha'].' ! Documento;0;1;1;1;DatDocumentos.TipoDocto ! Status;0;0;0;0;VDatRecibos.Status ! despacho;2;0;2|7;2|7;DatDocumentos.IDDespacho ! gerencia;0;9;9;1;DatDocumentos.IDGerencia ! grupo;1;0;12;0;1;DatDocumentos.IDGrupo ! subramo;1;0;20;0;0;DatDocumentos.IDSRamo';
  break;
  case 'merida':
$datos['ConditionsAdd']='Desde|Hasta;3;0;'.$array['fechaInicial'].'|'.$array['fechaFinal'].';0;-1;VDatRecibos.'.$array['tipoFecha'].' ! Documento;0;1;1;1;DatDocumentos.TipoDocto ! Status;0;0;0;0;VDatRecibos.Status ! despacho;2;0;2|7;2|7;DatDocumentos.IDDespacho ! gerencia;1;0;9;0;1;DatDocumentos.IDGerencia ';
  break;
case 'grupocer':
$datos['ConditionsAdd']='Desde|Hasta;3;0;'.$array['fechaInicial'].'|'.$array['fechaFinal'].';0;-1;VDatRecibos.'.$array['tipoFecha'].' ! Documento;0;1;1;1;DatDocumentos.TipoDocto ! Status;0;0;0;0;VDatRecibos.Status ! grupo;0;0;12;0;1;DatDocumentos.IDGrupo ! VendedorID;0;0;7;0;0;CatVendedores.IdVend';
  break;
case 'grupoflotillas':
$datos['ConditionsAdd']='Desde|Hasta;3;0;'.$array['fechaInicial'].'|'.$array['fechaFinal'].';0;-1;VDatRecibos.'.$array['tipoFecha'].' ! Documento;0;1;1;1;DatDocumentos.TipoDocto ! Status;0;0;0;0;VDatRecibos.Status ! grupo;1;0;12;0;1;DatDocumentos.IDGrupo ! VendedorID;0;0;7;0;0;CatVendedores.IdVend ! subramo;0;0;20;0;0;DatDocumentos.IDSRamo';
  break;
case 'todos':
$datos['ConditionsAdd']='Desde|Hasta;3;0;'.$array['fechaInicial'].'|'.$array['fechaFinal'].';0;-1;VDatRecibos.'.$array['tipoFecha'].' ! Documento;2;0;1|2;1|2;DatDocumentos.TipoDocto ! Status;0;0;0;0;VDatRecibos.Status';
  break;

  default:
  $vendedor=$this->CI->tank_auth->get_IDVend();
  $datos['ConditionsAdd']='Desde|Hasta;3;0;'.$array['fechaInicial'].'|'.$array['fechaFinal'].';0;-1;VDatRecibos.'.$array['tipoFecha'].' ! Documento;2;0;1|2;1|2;DatDocumentos.TipoDocto ! Status;0;0;0;0;VDatRecibos.Status ! VendedorID;2;0;'.$vendedor.';'.$vendedor.';CatVendedores.IdVend';
    break;

}
     if($paginacion)
     {
       $numeroPagina=1;
       $datos['ItemForPage']=100;
        do
        {
         
         $datos['Page']=$numeroPagina;
         $respuesta=$this->getDatosSICAS($datos);      
  
         foreach($respuesta->TableInfo as $value){array_push($tableInfo,$value);}   
         $numeroPagina=$numeroPagina+1;    
        }while((int)$respuesta->TableControl->Pages[0]>(int)$respuesta->TableControl->Page[0]);
                return $tableInfo;
 
     }
     else
     {
      $respuesta=$this->getDatosSICAS($datos);
      return $respuesta;
     }
 
}
//-------------------------------------------------------------------------------------------------
function aplicarPagoRecibo($array)
{ 
  /*=====APLICA EL PAGO DE RECIBO Y ENDOSO ======*/
/*

  $pago['IDPagoRec']=-1;
  $pago['IDRecibo']=id de recibo;
  $pago['FPago']= es la fecha de pago;
  $pago['FolioCh']= es el folio del cheque;
  $pago['TipoDocto']= por ejemplo si es un baucher;
  $pago['Banco']= el nombre del banco;
  $pago['FolioDocto']= es el folio del documento;
  $pago['FDocto']= es la fecha del documento;
  $pago['TPago']= el tipo de pago puede ser directo o tarjeta poner por default 0;
  $pago['ImporteP']=es el importe a pagar;
  $pago['IDMonPago']=es el tipo de moneda 1 pesos 2  en dollar;
  $pago['TCPago']=es el tipo de cambio si es IDMonPago=1 por defaul 1;
  $pago['Importe']=es el importe a pagar y suele ser igual ImporteP;
  $pago['TCDocto']=es el tipo de cambio del documento que suele ser igual a IDMonPago;
  $pago['IDTarjeta']=-1;
 */

    if(isset($array['IDRecibo']))
  { 
    $encriptado='<InfoData><DatPagosRec>';
    foreach($array as $key => $value){  $encriptado=$encriptado.'<'.$key.'>'.$value.'</'.$key.'>';   }

      $encriptado=$encriptado.'</DatPagosRec></InfoData>';       

      $encriptado=$this->encripta($encriptado);
   
     $respuesta=$this->grabarActualizasDatos('HWPAGOREC',$encriptado);       
     $res=$this->decodificaXML($respuesta);
   return $res;   
     }

}
//-------------------------------------------------
function renovacionPoliza($array)
{
    
 $xml='<soapenv:Envelope xmlns:soapenv="http://schemas.xmlsoap.org/soap/envelope/" xmlns:tem="http://tempuri.org/">
  <soapenv:Header/>  
  <soapenv:Body>      
  <tem:Procesar_Renovacion>         
  <tem:oConfigDataRenov>          
  <tem:IDDoctoSoure>'.$array['IDDocto'].'</tem:IDDoctoSoure>                  
  </tem:oConfigDataRenov>         
  <tem:oConfigAuth>            
  <tem:UserName>'.$this->user.'</tem:UserName>          
  <tem:Password>'.$this->pass.'</tem:Password>     
  <tem:CodeAuth>'.$this->auth.'</tem:CodeAuth>           
  </tem:oConfigAuth>      
  </tem:Procesar_Renovacion>   
  </soapenv:Body>
  </soapenv:Envelope>';

  $headers = array("POST/SOnlineWSQua/WS_SICASOnline.asmx HTTPS/1.1","Content-Type: text/xml; charset=utf-8","Accept: text/xml","Host: www.sicasonline.info","Pragma: no-cache","SOAPAction: http://tempuri.org/ProcesarWS", "Content-length: ".strlen($xml),);

       
       $soap_do = curl_init();
       $url="https://www.sicasonline.info/SOnlineWS/WS_SICASOnline.asmx?WSDL";
        curl_setopt($soap_do, CURLOPT_URL,$url );
        curl_setopt($soap_do, CURLOPT_POSTFIELDS,$xml);
        curl_setopt($soap_do, CURLOPT_HTTPHEADER,$headers);
        curl_setopt($soap_do, CURLOPT_SSL_VERIFYPEER, 0);
        curl_setopt($soap_do, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($soap_do, CURLOPT_HTTPAUTH, CURLAUTH_ANY);
        curl_setopt($soap_do, CURLOPT_TIMEOUT, 30);
        curl_setopt($soap_do, CURLOPT_POST, true);
        curl_setopt($soap_do, CURLOPT_HTTPHEADER, array('Accept: text/xml','Content-Type: text/xml'));
        $respuesta=curl_exec($soap_do);         
        curl_close($soap_do);
        
        $respuesta=htmlspecialchars_decode($respuesta); 

        $respuesta=str_replace('<?xml version="1.0" encoding="utf-8"?>', '', $respuesta);
        $respuesta=str_replace('<soap:Envelope xmlns:soap="http://schemas.xmlsoap.org/soap/envelope/" xmlns:xsi="http://www.w3.org/2001/XMLSchema-instance" xmlns:xsd="http://www.w3.org/2001/XMLSchema">', '', $respuesta);
        $respuesta=str_replace('<soap:Body>', '', $respuesta);
        $respuesta=str_replace('<Procesar_RenovacionResponse xmlns="http://tempuri.org/">', '', $respuesta);
        $respuesta=str_replace('<Procesar_RenovacionResult>', '', $respuesta);
        $respuesta=str_replace('</Procesar_RenovacionResult></Procesar_RenovacionResponse></soap:Body></soap:Envelope>', '', $respuesta);
$respuesta=(string)$respuesta;

$xmlRespuesta=<<<XML
   $respuesta
XML;
  error_reporting(0);
try {
    $xml = simplexml_load_string((string)$xmlRespuesta);    
     return $xml;
} catch (Exception $e) {
  $xml=array();
   return $xml;
  
}
          
 



}
//-------------------------------------------------

function cancelacionRenovacion($array)
{
    
 $xml='<soapenv:Envelope xmlns:soapenv="http://schemas.xmlsoap.org/soap/envelope/" xmlns:tem="http://tempuri.org/">
  <soapenv:Header/>  
  <soapenv:Body>      
  <tem:Procesar_Cancelacion>         
  <tem:oConfigDataCancel>          
  <tem:IDDocto>'.$array['IDDocto'].'</tem:IDDocto>
  <tem:TipoStatus>'.$array['TipoStatus'].'</tem:TipoStatus>
  <tem:FCancelacion>'.$array['FCancelacion'].'</tem:FCancelacion>
  <tem:Motivo>'.$array['Motivo'].'</tem:Motivo>                  
  <tem:SubMotivo>'.$array['SubMotivo'].'</tem:SubMotivo>   
  </tem:oConfigDataCancel>         
  <tem:oConfigAuth>            
  <tem:UserName>'.$this->user.'</tem:UserName>          
  <tem:Password>'.$this->pass.'</tem:Password>     
  <tem:CodeAuth>'.$this->auth.'</tem:CodeAuth>           
  </tem:oConfigAuth>      
  </tem:Procesar_Cancelacion>   
  </soapenv:Body>
  </soapenv:Envelope>';

  $headers = array("POST/SOnlineWSQua/WS_SICASOnline.asmx HTTPS/1.1","Content-Type: text/xml; charset=utf-8","Accept: text/xml","Host: www.sicasonline.info","Pragma: no-cache","SOAPAction: http://tempuri.org/ProcesarWS", "Content-length: ".strlen($xml),);

       
       $soap_do = curl_init();
       $url="https://www.sicasonline.info/SOnlineWS/WS_SICASOnline.asmx?WSDL";
        curl_setopt($soap_do, CURLOPT_URL,$url );
        curl_setopt($soap_do, CURLOPT_POSTFIELDS,$xml);
        curl_setopt($soap_do, CURLOPT_HTTPHEADER,$headers);
        curl_setopt($soap_do, CURLOPT_SSL_VERIFYPEER, 0);
        curl_setopt($soap_do, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($soap_do, CURLOPT_HTTPAUTH, CURLAUTH_ANY);
        curl_setopt($soap_do, CURLOPT_TIMEOUT, 30);
        curl_setopt($soap_do, CURLOPT_POST, true);
        curl_setopt($soap_do, CURLOPT_HTTPHEADER, array('Accept: text/xml','Content-Type: text/xml'));
        $respuesta=curl_exec($soap_do);         
        curl_close($soap_do);

        $respuesta=htmlspecialchars_decode($respuesta); 

/*        $respuesta=str_replace('<?xml version="1.0" encoding="utf-8"?>', '', $respuesta);
        $respuesta=str_replace('<soap:Envelope xmlns:soap="http://schemas.xmlsoap.org/soap/envelope/" xmlns:xsi="http://www.w3.org/2001/XMLSchema-instance" xmlns:xsd="http://www.w3.org/2001/XMLSchema">', '', $respuesta);
        $respuesta=str_replace('<soap:Body>', '', $respuesta);
        $respuesta=str_replace('<Procesar_RenovacionResponse xmlns="http://tempuri.org/">', '', $respuesta);
        $respuesta=str_replace('<Procesar_RenovacionResult>', '', $respuesta);
        $respuesta=str_replace('</Procesar_RenovacionResult></Procesar_RenovacionResponse></soap:Body></soap:Envelope>', '', $respuesta);
$respuesta=(string)$respuesta;
$xmlRespuesta=<<<XML
   $respuesta
XML;
  

$xml = simplexml_load_string((string)$xmlRespuesta);      
        
 return $xml;*/


}



//-------------------------------------------------
function cancelarReciboPagado($array)
{
    
 $xml='<soapenv:Envelope xmlns:soapenv="http://schemas.xmlsoap.org/soap/envelope/" xmlns:tem="http://tempuri.org/">
  <soapenv:Header/>  
  <soapenv:Body>      
  <tem:Procesar_AnularPago>         
  <tem:oConfigDataAnulaPago>          
  <tem:IDRecibo>'.$array['IDRecibo'].'</tem:IDRecibo>          
  <tem:MotivoAnulacion>'.$array['MotivoAnulacion'].'</tem:MotivoAnulacion>         
  </tem:oConfigDataAnulaPago>         
  <tem:oConfigAuth>            
  <tem:UserName>'.$this->user.'</tem:UserName>          
  <tem:Password>'.$this->pass.'</tem:Password>     
  <tem:CodeAuth>'.$this->auth.'</tem:CodeAuth>           
  </tem:oConfigAuth>      
  </tem:Procesar_AnularPago>   
  </soapenv:Body>
  </soapenv:Envelope>';

  $headers = array("POST/SOnlineWSQua/WS_SICASOnline.asmx HTTPS/1.1","Content-Type: text/xml; charset=utf-8","Accept: text/xml","Host: www.sicasonline.info","Pragma: no-cache","SOAPAction: http://tempuri.org/ProcesarWS", "Content-length: ".strlen($xml),);

       
       $soap_do = curl_init();
       $url="https://www.sicasonline.info/SOnlineWS/WS_SICASOnline.asmx?WSDL";
        curl_setopt($soap_do, CURLOPT_URL,$url );
        curl_setopt($soap_do, CURLOPT_POSTFIELDS,$xml);
        curl_setopt($soap_do, CURLOPT_HTTPHEADER,$headers);
        curl_setopt($soap_do, CURLOPT_SSL_VERIFYPEER, 0);
        curl_setopt($soap_do, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($soap_do, CURLOPT_HTTPAUTH, CURLAUTH_ANY);
        curl_setopt($soap_do, CURLOPT_TIMEOUT, 30);
        curl_setopt($soap_do, CURLOPT_POST, true);
        curl_setopt($soap_do, CURLOPT_HTTPHEADER, array('Accept: text/xml','Content-Type: text/xml'));
        $respuesta=curl_exec($soap_do);         
        curl_close($soap_do);
        
        $respuesta=htmlspecialchars_decode($respuesta);        
        $pos = strrpos($respuesta, "SUCESS");
        $return=1; 
        if ($pos === false){$return=0;}      
        
        return $return;


}
//-------------------------------------------------
public  function obtenerPolzasActividades($idCli,$sDate){
    $datos['Page'] ='1';
    $datos['ItemForPage'] = '1000';
    $datos['ConditionsAdd'] = 'Cliente Id;0;0;'. $idCli .';'. $idCli .';0;-1;DatDocumentos.IDCli ! Tipo Documento;0;0;1;1;DatDocumentos.TipoDocto ! Id Cliente;5;0;'.$sDate.';0;DatDocumentos.FHasta ! Cliente Id;0;0;0;0;0;-1;DatDocumentos.Status ';			
    $datos['InfoSort'] = 'CatClientes.IDCli';
    $datos['KeyCode'] = 'HWS_DOCTOS';
    $datos['KeyProcess'] ='REPORT';
    $respuesta=$this->getDatosSICAS($datos);
    return $respuesta;
}
//-------------------------------------------------------------------------------------------------
function obtenerDocumentoPorId($id){
  /*ESTE WEBSERVER SE EMPLEA PARA OBTENER LAS PRODUCCION(CARTERA)*/   
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
       $datos['InfoSort']='VDatDocumentos.IDDocto';
       $datos['IDRelation']='0';

   // $vendedor=$this->tank_auth->get_IDVend();

           $datos['ConditionsAdd']='Docto;0;0;'.$id.';0;-1;DatDocumentos.IDDocto';
    

    $respuesta=$this->getDatosSICAS($datos);
 return $respuesta;
}
//-------------------------------------------------------------------------------------------------
public function obtenerCarteraFecha($vendedor,$fechaI,$fechaF){    
/*ESTE WEBSERVER SE EMPLEA PARA OBTENER LAS PRODUCCION(CARTERA)*/ 	
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
       $datos['InfoSort']='VDatDocumentos.IDDocto';
       $datos['IDRelation']='0';

   // $vendedor=$this->tank_auth->get_IDVend();
    if($vendedor>0)
    {
      $datos['ConditionsAdd']='       
          Desde|Hasta;3;0;'.$fechaI.'|'.$fechaF.';0;-1;VDatDocumentos.FDesde ! Documento;0;0;0;1;DatDocumentos.Status ! VendedorID;2;0;'.$vendedor.';'.$vendedor.';CatVendedores.IdVend';
    }
    else{
           $datos['ConditionsAdd']='       
          Desde|Hasta;3;0;'.$fechaI.'|'.$fechaF.';0;-1;VDatDocumentos.FDesde ! Documento;0;0;0;1;DatDocumentos.Status ';
    }

    $respuesta=$this->getDatosSICAS($datos);
 return $respuesta;

}
//-------------------------------------------------------------------------------------------------
public function obtenerHonorariosFecha($vendedor,$fechaI,$fechaF,$tipo){
/*ES PARA OBTENER LOS HONORARIOS 
$tipo= ES ENTERO =1 ES PAGADO Y !=1 PARA NO PAGADOS 
*/
         $datos['TipoEntidad']='0';
         $datos['TypeDestinoCDigital']='CONTACT';
         $datos['IDValuePK']='0';
         $datos['ActionCDigital']='GETFiles';
         $datos['TypeFormat']='XML';
         $datos['TProct']='Read_Data';
         $datos['KeyProcess']='REPORT';
         $datos['KeyCode']='H02930_003';
         $datos['Page']='1';
         $datos['ItemForPage']='600';
         $datos['InfoSort']='DatHonRecibos.Status_TXT';
         $datos['IDRelation']='0';	



   if($tipo==1){   	
    $datos['ConditionsAdd']='Recibos;0;0;1;Pagados;1;-1;DatHonRecibos.Pagado !
    Desde|Hasta|Fecha de Pago;3;0;'.$fechaI.'|'.$fechaF.';'.$fechaI.'|'.$fechaF.';0;-1;DatHonDocto.FPago ! VendedorID;2;0;'.$vendedor.';'.$vendedor.';51;DatHonRecibos.IDVE' ;
   }else{
   	$datos['ConditionsAdd']='Honorarios;0;0;0;Pendientes;DatHonRecibos.Pagado !
Comisiones;7;1;Conciliado;Conciliado;VDPagoComRec.ComPagada ! 
recibos;0;0;4;-1;DatRecibos.Status ! VendedorID;0;0;'.$vendedor.';0;-1;DatHonRecibos.IDVE' ;
   }
  
       $respuesta=$this->getDatosSICAS($datos);
 return $respuesta;
}
//-----------------------------------------------------------------------

public function obtenerRenovacionesFecha($vendedor=null,$fechaI,$fechaF,$IDDocto=null,$status=null,$canal=''){    
/*ESTE WEBSERVER SE EMPLEA PARA OBTENER LAS RENOVACIONES*/ 	
  $respuesta=array();
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
       $datos['ConditionsAdd']='';
    //$vendedor=$this->tank_auth->get_IDVend();
   $condicionStatus="";
   if($IDDocto!=null)
   {
     $datos['ConditionsAdd']='IDDocto;0;0;'.$IDDocto.';'.$IDDocto.';DatDocumentos.IDDocto';
   }   
   else
   {
           $datos['ConditionsAdd']='Desde|Hasta;3;0;'.$fechaI.'|'.$fechaF.';0;-1;DatDocumentos.FHasta ';
    if($status!=null){$condicionStatus=' ! Status;0;0;0;0;DatDocumentos.Status';}
    
    if($vendedor>0)
    {
       $datos['ConditionsAdd'].=' ! Tipo Documento;0;0;1;1;DatDocumentos.TipoDocto! VendedorID;2;0;'.$vendedor.';'.$vendedor.';CatVendedores.IdVend';
    }
    else
    {
      if(empty($canal)){

        $datos['ConditionsAdd'].=' ! TipoDocumento;0;0;1;1;DatDocumentos.TipoDocto ';
      } else{

        $datos['ConditionsAdd'].=' ! '.$this->filtroParaCanales($canal);
      }
    }
    $datos['ConditionsAdd'].=$condicionStatus;
      
    }
         
    $respuesta=$this->getDatosSICAS($datos);

       

 return $respuesta;
}
//------------------------------------------------------------
	public function GetCDDigital($data,$recursivo=1){

   
		if(is_array($data)){
    if(isset($data['RECEIPT']))
    {
          $IDDocto  = $data["IDDocto"];     
      $data_body = array(
        "ConditionsAdd" => "",
        "InfoSort"=>"",
        "KeyCode"=>"",
        "KeyProcess"=> "CDIGITAL",
        "TypeDestinoCDigital"=> "DOCUMENT",
        "ActionCDigital"=> "GETFiles"
      );
       //$datos['TipoEntidad']='0';
       $datos['TypeDestinoCDigital']='RECEIPT';
       $datos['IDValuePK']=$IDDocto;
       $datos['ActionCDigital']='GETFiles';
       $datos['TypeFormat']='XML';
       $datos['KeyProcess']='CDIGITAL';      
       $datos['ReadRecursive']=$recursivo;
    }	
    else
    {		
			$IDDocto 	= $data["IDDocto"];			
			$data_body = array(
				"ConditionsAdd" => "",
				"InfoSort"=>"",
				"KeyCode"=>"",
				"KeyProcess"=> "CDIGITAL",
				"TypeDestinoCDigital"=> "DOCUMENT",
				"ActionCDigital"=> "GETFiles"
			);
       $datos['TipoEntidad']='0';
       $datos['TypeDestinoCDigital']='DOCUMENT';
       $datos['IDValuePK']=$IDDocto;
       $datos['ActionCDigital']='GETFiles';
       $datos['TypeFormat']='XML';
       $datos['TProct']='Read_Data';
       $datos['KeyProcess']='CDIGITAL';      
       $datos['Page']='1';
       $datos['ItemForPage']='10000000';
       $datos['ReadRecursive']=$recursivo;

     }
	    $result = $this->getDatosSICAS($datos);
	 
		if(isset($result[0]->Datos)){
		$result_c = array();
		if($result->Datos != "")
		{
		 $Level = 0;
		 foreach ($result->Datos as $value) {array_push($result_c,$value);}
		 $test = $this->CrearArbol($result_c,0);
		}
					return $test;
			}else{
				return array('text'=> 'No cuenta con documentos');
			}
 }
}
//----------------------------------
public function GetCDDigitalCliente($data,$recursivo=0){
   
    if(is_array($data)){      
      $id = $data["IDValuePK"];     
      $data_body = array(
        "ConditionsAdd" => "",
        "InfoSort"=>"",
        "KeyCode"=>"",
        "KeyProcess"=> "CDIGITAL",
        "TypeDestinoCDigital"=> "CLIENT",
        "ActionCDigital"=> "GETFiles"
      );
       $datos['TipoEntidad']='0';
       $datos['TypeDestinoCDigital']='CLIENT';
       $datos['IDValuePK']=$id;
       $datos['ActionCDigital']='GETFiles';
       $datos['TypeFormat']='XML';
       $datos['TProct']='Read_Data';
       $datos['KeyProcess']='CDIGITAL';
       $datos['Page']='1';
             
       $datos['ItemForPage']='10000000';
       $datos['ReadRecursive']=$recursivo;
       //$datos['RECEIPT']=1; 
      $result = $this->getDatosSICAS($datos);   
    if(isset($result[0]->Datos)){
    $result_c = array();
    if($result->Datos != "")
    {
     $Level = 0;
     foreach ($result->Datos as $value) {array_push($result_c,$value);}
     $test = $this->CrearArbol($result_c,0);
    }
          return $test;
     }
    else{return array('text'=> 'No cuenta con documentos');}
 }
}
//-------------------------------------------------------------------------------------------------
public function subirArchivoSicas($array){


  /*ENVIO DE ARCHIVOS A SICAS*/
    $xmlSend  ='<?xml version="1.0" encoding="utf-8"?>
      <soap:Envelope xmlns:xsi="http://www.w3.org/2001/XMLSchema-instance" xmlns:xsd="http://www.w3.org/2001/XMLSchema" xmlns:soap="http://schemas.xmlsoap.org/soap/envelope/">
      <soap:Body>
        <ProcesarWS xmlns="http://tempuri.org/">
          <oDataWS>
            <Credentials>
              <UserName>'.$this->user.'</UserName>
              <Password>'.$this->pass.'</Password>
              <CodeAuth>'.$this->auth.'</CodeAuth>
            </Credentials>
            <CredentialsUserSICAS>
              <UserName>SISTEMAS@ASESORESCAPITAL.COM</UserName>
              <Password>ACHAN2019</Password>
            </CredentialsUserSICAS>
            <TypeFormat>XML</TypeFormat>
            <KeyProcess>CDIGITAL</KeyProcess>
            <TypeDestinoCDigital>'.$array['TypeDestinoCDigital'].'</TypeDestinoCDigital>
            <IDValuePK>'.$array['IDValuePK'].'</IDValuePK>
            <ActionCDigital>'.$array['wsAction'].'</ActionCDigital>
            <ListFilesURL>'.$array['ListFilesURL'].'</ListFilesURL>
            <FolderDestino>'.$array['FolderDestino'].'</FolderDestino>
          </oDataWS>
        </ProcesarWS>
      </soap:Body>
    </soap:Envelope>';


    $resXmlConsumo = str_replace($this->DeleteXml, $this->ClearXml, $this->consumowssicas($xmlSend));
    $xmlTexto_resXmlConsumo = htmlspecialchars_decode($resXmlConsumo);
      

$xmlRespuesta=<<<XML
  $xmlTexto_resXmlConsumo
XML;
  
    if(simplexml_load_string($xmlRespuesta)){
      $wsNodoExtrae="";
      $nodoAs = (string)$wsNodoExtrae;
      $carga_xmlRespuesta = simplexml_load_string($xmlRespuesta);
      $return = array();
      foreach ($carga_xmlRespuesta->$nodoAs as $DatoRegistro){
        $return[] = $DatoRegistro;
      }
       
      return $return;     
    }
         
    return false;



}
//----------------------------------------------------
public  function  honorarios($IDVend,$fechaInicial,$fechaFinal,$item,$pagina){
    /*====FORMATO DEL MANEJO DE LA FECHA 10/9/2018=========*/
$numPagina=1;$itemPorPagina=10000;
   if($item!=0 && $pagina!=0){$numPagina=$pagina;$itemPorPagina=$pagina;
  }

    $datos['TipoEntidad']='0';
    $datos['TypeDestinoCDigital']='CONTACT';
    $datos['IDValuePK']='0';
    $datos['ActionCDigital']='GETFiles';
    $datos['TypeFormat']='XML';
    $datos['TProct']='Read_Data';
    $datos['KeyProcess']='REPORT';
    $datos['KeyCode']='H02930_003';
    $datos['Page']=$numPagina;
    $datos['ItemForPage']=$itemPorPagina;
    $datos['InfoSort']='DatHonRecibos.Status_TXT';
    $datos['IDRelation']='0';
    // $datos['ConditionsAdd']='Recibos;0;0;1;Pagados;1;-1;DatHonRecibos.Pagado ! Desde|Hasta|Fecha de Pago;3;0;'.$fechaInicial.'|'.$fechaFinal.';'.$fechaInicial.'|'.$fechaFinal.';0;-1;DatHonDocto.FPago ! VendedorID;2;0;'.$IDVend.';0;DatHonRecibos.IDVE' ;
  $datos['ConditionsAdd']='Recibos;0;0;1;1;-1;DatHonRecibos.Pagado ! Desde|Hasta|Fecha de Pago;3;0;'.$fechaInicial.'|'.$fechaFinal.';'.$fechaInicial.'|'.$fechaFinal.';0;-1;DatHonDocto.FPago ';


      $respuesta=$this->getDatosSICAS($datos);

    return $respuesta;

  }

//-------------------------------------------------------------
  private function consumowssicas($xmlData){
           $headers = array(
                        "POST /SOnlineWSQua/WS_SICASOnline.asmx HTTPS/1.1",
                        "Content-Type: text/xml; charset=utf-8",
                        "Accept: text/xml",                        
                        "Host: www.sicasonline.info",
                        "Pragma: no-cache",
                        "SOAPAction: http://tempuri.org/ProcesarWS", 
                        "Content-length: ".strlen($xmlData),
                    );

            $ch = curl_init();
            curl_setopt($ch, CURLOPT_URL, 'https://www.sicasonline.info/SOnlineWS/WS_SICASOnline.asmx?WSDL');
            curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
            curl_setopt($ch, CURLOPT_POSTFIELDS, $xmlData); // the SOAP request
            curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
            curl_setopt($ch, CURLOPT_HTTPAUTH, CURLAUTH_ANY);
            curl_setopt($ch, CURLOPT_TIMEOUT, 100);
            curl_setopt($ch, CURLOPT_POST, true);         
            $response = curl_exec($ch);            
            curl_close($ch);
            $response1 = str_replace("<soap:Body>","",$response);            
            $response1 = str_replace("</soap:Body>","",$response1);
            //$fp = fopen('resultadoJason.txt', 'a');fwrite($fp, print_r($response1, TRUE));fclose($fp);
            

      
            return $response1;
  }



//--------------------------------------------------------------------------------------------------
public function getDatosSICAS_JSON($wsdata){
   //
  $xml='<?xml version="1.0" encoding="utf-8"?><soap:Envelope xmlns:soap="http://www.w3.org/2003/05/soap-envelope" xmlns:tem="http://tempuri.org/"> <soap:Header/> <soap:Body> <ProcesarWS xmlns="http://tempuri.org/"> <oDataWS> <Credentials>';
$xml=$xml.'<UserName>'.$this->user.'</UserName>';
$xml=$xml.'<Password>'.$this->pass.'</Password>';
$xml=$xml.'<CodeAuth>'.$this->auth.'</CodeAuth></Credentials>';
$xml=$xml.'<CredentialsUserSICAS><UserName>SISTEMAS@ASESORESCAPITAL.COM</UserName>';
$xml=$xml.'<Password>ACHAN2019</Password></CredentialsUserSICAS>';
foreach ($wsdata as $key => $value) {$xml=$xml.'<'.$key.'>'.$value.'</'.$key.'>';}
$xml=$xml.'</oDataWS> </ProcesarWS> </soap:Body> </soap:Envelope>';
 

           $headers = array("POST /SOnlineWSQua/WS_SICASOnline.asmx HTTPS/1.1","Content-Type: text/xml; charset=utf-8","Accept: text/xml","Host: www.sicasonline.info",
                        "Pragma: no-cache","SOAPAction: http://tempuri.org/ProcesarWS", "Content-length: ".strlen($xml),);

            $ch = curl_init();
            curl_setopt($ch, CURLOPT_URL, 'https://www.sicasonline.info/SOnlineWS/WS_SICASOnline.asmx?WSDL');
            curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
            curl_setopt($ch, CURLOPT_POSTFIELDS, $xml); // the SOAP request
            curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
            curl_setopt($ch, CURLOPT_HTTPAUTH, CURLAUTH_ANY);
            curl_setopt($ch, CURLOPT_TIMEOUT, 100);
            curl_setopt($ch, CURLOPT_POST, true);
            // converting
            
            $response = curl_exec($ch); 
             
           

            $resXmlConsumo = str_replace($this->DeleteXml, $this->ClearXml, $response);
            $respuesta=json_decode($resXmlConsumo);
             return $respuesta;

           /*  return $response;
            $xmlTexto_resXmlConsumo = htmlspecialchars_decode($resXmlConsumo);
    
            $xmlRespuesta=<<<XML
  $xmlTexto_resXmlConsumo
XML;
  $return = array();

  $carga_xmlRespuesta = simplexml_load_string($xmlRespuesta);
     
            curl_close($ch);
//
        return $carga_xmlRespuesta;*/


}
//-------------------------------------------------------------------------------------------------
public function getDatosSICAS($wsdata){
   //
   
	$xml='<?xml version="1.0" encoding="utf-8"?><soap:Envelope xmlns:soap="http://www.w3.org/2003/05/soap-envelope" xmlns:tem="http://tempuri.org/"> <soap:Header/> <soap:Body> <ProcesarWS xmlns="http://tempuri.org/"> <oDataWS> <Credentials>';
$xml=$xml.'<UserName>'.$this->user.'</UserName>';
$xml=$xml.'<Password>'.$this->pass.'</Password>';
$xml=$xml.'<CodeAuth>'.$this->auth.'</CodeAuth></Credentials>';
$xml=$xml.'<CredentialsUserSICAS><UserName>SISTEMAS@ASESORESCAPITAL.COM</UserName>';
$xml=$xml.'<Password>ACHAN2019</Password></CredentialsUserSICAS>';

foreach ($wsdata as $key => $value) {$xml=$xml.'<'.$key.'>'.$value.'</'.$key.'>';}

$xml=$xml.'</oDataWS> </ProcesarWS> </soap:Body> </soap:Envelope>';
 
 

           $headers = array("POST /SOnlineWSQua/WS_SICASOnline.asmx HTTPS/1.1","Content-Type: text/xml; charset=utf-8","Accept: text/xml","Host: www.sicasonline.info",
                        "Pragma: no-cache","SOAPAction: http://tempuri.org/ProcesarWS", "Content-length: ".strlen($xml),);

            $ch = curl_init();
            curl_setopt($ch, CURLOPT_URL, 'https://www.sicasonline.info/SOnlineWS/WS_SICASOnline.asmx?WSDL');
            curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
            curl_setopt($ch, CURLOPT_POSTFIELDS, $xml); // the SOAP request
            curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
            curl_setopt($ch, CURLOPT_HTTPAUTH, CURLAUTH_ANY);
            curl_setopt($ch, CURLOPT_TIMEOUT, 100);
            curl_setopt($ch, CURLOPT_POST, true);
            // converting
            
            $response = curl_exec($ch); 

            $resXmlConsumo = str_replace($this->DeleteXml, $this->ClearXml, $response);
            $xmlTexto_resXmlConsumo = htmlspecialchars_decode($resXmlConsumo);
    
            $xmlRespuesta=<<<XML
	$xmlTexto_resXmlConsumo
XML;
	$return = array();
	$carga_xmlRespuesta = simplexml_load_string($xmlRespuesta);
     
            curl_close($ch);
//
	      return $carga_xmlRespuesta;


}
//-------------------------------------------------------------------------------------------------
private function obtenerDatos2($wsdata){
	require('KLogger/vendor/autoload.php');
	$DeleteXml = array('<?xml version="1.0" encoding="utf-8"?>','<soap:Envelope xmlns:soap="http://schemas.xmlsoap.org/soap/envelope/" xmlns:xsi="http://www.w3.org/2001/XMLSchema-instance" xmlns:xsd="http://www.w3.org/2001/XMLSchema">','<DATAINFO> ','<soap:Envelope xmlns:soap="http://www.w3.org/2003/05/soap-envelope" xmlns:xsi="http://www.w3.org/2001/XMLSchema-instance" xmlns:xsd="http://www.w3.org/2001/XMLSchema"><soap:Body>','<ProcesarWSResponse xmlns="http://tempuri.org/">','<ProcesarWSResult>','</ProcesarWSResult>','</ProcesarWSResponse>','</soap:Envelope>','</DATAINFO> ','</soap:Body>','</DATAINFO> ',);
	$ClearXml = array('','','','','','','','','','','','',);
	//$xml = '<soap:Envelope xmlns:xsi="http://www.w3.org/2001/XMLSchema-instance" xmlns:xsd="http://www.w3.org/2001/XMLSchema" xmlns:soap="http://schemas.xmlsoap.org/soap/envelope/"><soap:Body><ProcesarWS xmlns="http://tempuri.org/"><oDataWS><Credentials>';
	$xml='<?xml version="1.0" encoding="utf-8"?><soap:Envelope xmlns:soap="http://www.w3.org/2003/05/soap-envelope" xmlns:tem="http://tempuri.org/"> <soap:Header/> <soap:Body> <ProcesarWS xmlns="http://tempuri.org/"> <oDataWS> <Credentials>';
$xml=$xml.'<UserName>'.$this->user.'</UserName>';
$xml=$xml.'<Password>'.$this->pass.'</Password>';
$xml=$xml.'<CodeAuth>'.$this->auth.'</CodeAuth></Credentials>';
$xml=$xml.'<CredentialsUserSICAS><UserName>SISTEMAS@ASESORESCAPITAL.COM</UserName>';
$xml=$xml.'<Password>ACHAN2019</Password></CredentialsUserSICAS>';
//$xml=$xml.'<TypeFormat>JSON</TypeFormat>';
//$xml=$xml.'<KeyProcess>DATA</KeyProcess>';
foreach ($wsdata as $key => $value) {
	$xml=$xml.'<'.$key.'>'.$value.'</'.$key.'>';
}
$xml=$xml.'</oDataWS> </ProcesarWS> </soap:Body> </soap:Envelope>';

   

//$xml=$xml.$wsdata;

//$xml='<soapenv:Envelope xmlns:xsi="http://www.w3.org/2001/XMLSchema-instance" xmlns:xsd="http://www.w3.org/2001/XMLSchema" xmlns:soap="http://schemas.xmlsoap.org/soap/envelope/"><soapenv:Body><tem:ProcesarWS><tem:oDataWS> <tem:Credentials><tem:CodeAuth>vsDMquPhx68SZrY8wGcxEh2bk1XiPlR0EZkBVLmax3A4Mab7sDeeyodY3BjDuyB </tem:CodeAuth> <tem:UserName>SISTEMAS@ASESORESCAPITAL.COM</tem:UserName><tem:Password>ACHAN2019</tem:Password></tem:Credentials> <tem:CredentialsUserSICAS> <tem:UserName>SISTEMAS@ASESORESCAPITAL.COM</tem:UserName> <tem:Password>ACHAN2019</tem:Password> </tem:CredentialsUserSICAS> <tem:TypeFormat>XML</tem:TypeFormat> <tem:KeyProcess>REPORT</tem:KeyProcess> <tem:KeyCode>HDS00002</tem:KeyCode> <tem:Page>2</tem:Page> <tem:InfoSort>CatClientes.NombreCompleto</tem:InfoSort> </tem:oDataWS> </tem:ProcesarWS> </soapenv:Body> </soapenv:Envelope>';
//$xml=$xml.'<KeyCode>'.$keyCode.'</KeyCode>';
//$xml=$xml.'<TProc>Save_Data</TProc>';
//$xml =$xml.'<DataXML>'.$valores.'</DataXML>';
//$xml =$xml.'</oDataWS></ProcesarWS></soap:Body></soap:Envelope>';


/*$xml2='<?xml version="1.0" encoding="utf-8"?><soap:Envelope xmlns:soap="http://www.w3.org/2003/05/soap-envelope" xmlns:tem="http://tempuri.org/"> <soap:Header/> <soap:Body> <ProcesarWS xmlns="http://tempuri.org/"> <oDataWS> <Credentials> <CodeAuth>vsDMquPhx68SZrY8wGcxEh2bk1XiPlR0EZkBVLmax3A4Mab7sDeeyodY3BjDuyB </CodeAuth><UserName>GAP#aCap%2015</UserName><Password>CAP15gap20Ag</Password> </Credentials> <CredentialsUserSICAS> <UserName>SISTEMAS@ASESORESCAPITAL.COM</UserName> <Password>ACHAN2019</Password> </CredentialsUserSICAS>'.$wsdata.'</oDataWS> </ProcesarWS> </soap:Body> </soap:Envelope>';*/

$xml1='<?xml version="1.0" encoding="utf-8"?><soap:Envelope xmlns:soap="http://www.w3.org/2003/05/soap-envelope" xmlns:tem="http://tempuri.org/"> <soap:Header/> <soap:Body> <ProcesarWS xmlns="http://tempuri.org/"> <oDataWS> <Credentials> <CodeAuth>vsDMquPhx68SZrY8wGcxEh2bk1XiPlR0EZkBVLmax3A4Mab7sDeeyodY3BjDuyB </CodeAuth><UserName>GAP#aCap%2015</UserName><Password>CAP15gap20Ag</Password> </Credentials> <CredentialsUserSICAS> <UserName>SISTEMAS@ASESORESCAPITAL.COM</UserName> <Password>ACHAN2019</Password> </CredentialsUserSICAS> <TypeFormat>XML</TypeFormat> <KeyProcess>REPORT</KeyProcess> <KeyCode>HDS00002</KeyCode><TProc>Read_Data</TProc> <Page>2</Page> <InfoSort>CatClientes.NombreCompleto</InfoSort><ItemForPage>100</ItemForPage><ConditionsAdd>Tipo de Entidad;0;0;0;Fisicas;CatContactos.TipoEnt</ConditionsAdd></oDataWS> </ProcesarWS> </soap:Body> </soap:Envelope>';

$xmlData='<?xml version="1.0" encoding="utf-8"?>
			<soap:Envelope xmlns:xsi="http://www.w3.org/2001/XMLSchema-instance" xmlns:xsd="http://www.w3.org/2001/XMLSchema" xmlns:soap="http://schemas.xmlsoap.org/soap/envelope/">
			<soap:Body>
				<ProcesarWS xmlns="http://tempuri.org/">
					<oDataWS>
						<Credentials>
							<UserName>GAP#aCap%2015</UserName>
							<Password>CAP15gap20Ag</Password>
							<CodeAuth>vsDMquPhx68SZrY8wGcxEh2bk1XiPlR0EZkBVLmax3A4Mab7sDeeyodY3BjDuyB</CodeAuth>
						</Credentials>
						<CredentialsUserSICAS>
							<UserName>SISTEMAS@ASESORESCAPITAL.COM</UserName>
							<Password>ACHAN2019</Password>
						</CredentialsUserSICAS>
						<TypeFormat>XML</TypeFormat>
						<KeyProcess>DATA</KeyProcess>
						<KeyCode>H02000</KeyCode>
						<TProc>Read_Data</TProc>
						<DataXML>07fuoVnbTzBC5YjwCZRITtEGR6ur+g70C+cxyKmaDKQcnDdFgkgZAo4u8jFFpNS/r8eIHPQHyx6TveflGqwarOd3MNhW4lX4O4yM6XgAKtcuQ6zjSttDLd9XeFM6ufo73hn3SDf8fGQYTHIZEqn1Pj4HCFBcyqpHF1khh50lBgGBy9xd33kli3LrON0isZ7q</DataXML>
					</oDataWS>
				</ProcesarWS>
			</soap:Body>
		</soap:Envelope>';


           $headers = array("POST /SOnlineWSQua/WS_SICASOnline.asmx HTTPS/1.1","Content-Type: text/xml; charset=utf-8","Accept: text/xml","Host: www.sicasonline.info",
                        "Pragma: no-cache","SOAPAction: http://tempuri.org/ProcesarWS", "Content-length: ".strlen($xml),);
            $ch = curl_init();
            curl_setopt($ch, CURLOPT_URL, 'https://www.sicasonline.info/SOnlineWS/WS_SICASOnline.asmx?WSDL');
            curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
            curl_setopt($ch, CURLOPT_POSTFIELDS, $xml); // the SOAP request
            curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
            curl_setopt($ch, CURLOPT_HTTPAUTH, CURLAUTH_ANY);
            curl_setopt($ch, CURLOPT_TIMEOUT, 20);
            curl_setopt($ch, CURLOPT_POST, true);
            // converting
            //$fp = fopen('resultadoJason.txt', 'a');fwrite($fp, print_r($ch, TRUE));fclose($fp);
            $response = curl_exec($ch);          
            $resXmlConsumo = str_replace($DeleteXml, $ClearXml, $response);
            $xmlTexto_resXmlConsumo = htmlspecialchars_decode($resXmlConsumo);
  
            $xmlRespuesta=<<<XML
	$xmlTexto_resXmlConsumo
XML;
	$return = array();
	$carga_xmlRespuesta = simplexml_load_string($xmlRespuesta);
	  
		/*if(simplexml_load_string($xmlRespuesta)){
			$nodoAs = (string)$wsNodoExtrae;
			$carga_xmlRespuesta = simplexml_load_string($xmlRespuesta);
			
			foreach ($carga_xmlRespuesta->TableInfo as $DatoCliente){$return[] = $DatoCliente;}
			 
		}*/
           
            curl_close($ch);
	      return $carga_xmlRespuesta;

}
//-----------------------------------------------------------------------------------------------------------
 private function obtenerDatos($wsdata){

		if(is_array($wsdata)){
			try {
				$this->init();
				//Default Values
				$this->oDataWS->TipoEntidad = '0';
				$this->oDataWS->TypeDestinoCDigital = 'CONTACT'; 
				$this->oDataWS->IDValuePK = '0'; 
				$this->oDataWS->ActionCDigital = 'GETFiles';
				$this->oDataWS->TypeFormat = 'XML';
				$this->oDataWS->TProc = 'Read_Data'; 
				$this->oDataWS->KeyProcess = 'REPORT';
				$this->oDataWS->KeyCode = '';
				$this->oDataWS->Page ='1';
				$this->oDataWS->ItemForPage = '25';
				$this->oDataWS->InfoSort = '';
				$this->oDataWS->IDRelation = '0';
				$this->oDataWS->ConditionsAdd = '';
				if(isset($wsdata["XML"])){

					$xmlS = new SimpleXMLElement('<InfoData/>');
					$this->array_to_xml($wsdata['XML'], $xmlS);	
					$xmlData = $xmlS->asXML();
					
	
					// echo $xmlData;
					$TextEncript = $this->encripta($this->key, $this->ivPass, $xmlData);
					$this->oDataWS->DataXML = $TextEncript;
				}

				if(isset($wsdata['TipoEntidad']))
					$this->oDataWS->TipoEntidad = $wsdata['TipoEntidad']; 
				
				if(isset($wsdata['IDRelation']))
					$this->oDataWS->IDRelation = $wsdata['IDRelation']; 

				if(isset($wsdata['TypeDestinoCDigital']))
					$this->oDataWS->TypeDestinoCDigital = $wsdata['TypeDestinoCDigital']; 

				if(isset($wsdata['IDValuePK']))
					$this->oDataWS->IDValuePK = $wsdata['IDValuePK']; 

				if(isset($wsdata['ActionCDigital']))
					$this->oDataWS->ActionCDigital = $wsdata['ActionCDigital']; 

				if(isset($wsdata['Page']))
					$this->oDataWS->Page = $wsdata['Page']; 

				if(isset($wsdata['TProc']))
					$this->oDataWS->TProc = $wsdata['TProc']; 

				if(isset($wsdata['KeyProcess']))
					$this->oDataWS->KeyProcess = $wsdata['KeyProcess']; 

				if(isset($wsdata['KeyCode']))
					$this->oDataWS->KeyCode = $wsdata['KeyCode']; 

				if(isset($wsdata['ItemForPage']))
					$this->oDataWS->ItemForPage = $wsdata['ItemForPage']; 

				if(isset($wsdata['InfoSort']))
					$this->oDataWS->InfoSort = $wsdata['InfoSort']; 

				if(isset($wsdata['ConditionsAdd']))
					$this->oDataWS->ConditionsAdd = $wsdata['ConditionsAdd']; 

				//Consumir el Servicio Web
				$parameters = array('oDataWS' => $this->oDataWS, );
	 

				$resutl = $this->soapC->ProcesarWS($parameters);
				 // echo 'Request'. $this->soapC->__getLastRequest();
				if (strpos($resutl->ProcesarWSResult, 'DENIED') !== false) {
				    //return NULL;
				    return $resutl;
				}

				$xml = new SimpleXMLElement($resutl->ProcesarWSResult);
				return $xml;

			} catch (Exception $e) {
        
				return $resutl;
			
			}
		}
	}
//-----------------------------------------------------------------------------------------------------------------------------
private function CrearArbol($Arbol, $Nodo = 0){
				
		$isFolder 	= false;$text		= "";$level		= "";$href		= "";$hreftarget	= "";$level_int 		= 0;
    $tipo='';
		foreach ($Arbol as $key => $value) {						
			if((string)$value->Level == 0){				
				unset($Arbol[$key]);				
				if($value->Tipo == 0){					
					$isFolder = true;
					$text = (string)$value->NameShow;
					$level = (string)$value->Level;
          $tipo =(int)$value->Tipo;
												
				}else{
					
					$isFolder = false;
					$text = (string)$value->NameShow;
					$href = (string)$value->PathWWW;
					$hrefTarget = "_blank";
					$level = (string)$value->Level;
          $tipo =(int)$value->Tipo;
									
				}
			
					$recursive = $this->Hijos($Arbol);
						
					$return["isFolder"] = $isFolder;
					$return["text"] = $text;
					if(!empty($href))$return["href"] = $href;
					if(!empty($hrefTarget))$return["hrefTarget"] = $hrefTarget;
					if(!empty($level))$return["level"] = $level;
          if(!empty($tipo))$return["Tipo"] = $tipo;

					if($recursive != NULL)
						$return["children"] = $recursive;
					
			}
		}
						
		return empty($return) ? null : $return;   
	}
//------------------------------------------------------------------------------------------------------------------------------	
	private function Hijos($Arbol){
		$isFolder 	= false;$text		= "";$level		= "";$href		= "";$hreftarget	= "";$level = 0;	$hijos = array();		
		foreach ($Arbol as $key => $value) {
			unset($Arbol[$key]);
			if($value->Tipo == 0){
				$return  = 
				array("isFolder" => true,"text" => (string)$value->NameShow,"level" => (string)$value->Level,"Tipo"=>(int)$value->Tipo);											
			}else{				
				$return  = array("isFolder" => false,"text" => (string)$value->NameShow,"href" => (string)$value->PathWWW,"hrefTarget" => "_blank","level" => (string)$value->Level,"Tipo" => (int)$value->Tipo);}
			array_push($hijos,$return);
		}
		return empty($hijos) ? null : $hijos; 
	}
//--------------------------------------
function grabarBorrarDatos($keyCode,$valores)
{
$xml = '<?xml version="1.0" encoding="utf-8"?><soap:Envelope xmlns:xsi="http://www.w3.org/2001/XMLSchema-instance" xmlns:xsd="http://www.w3.org/2001/XMLSchema" xmlns:soap="http://schemas.xmlsoap.org/soap/envelope/"><soap:Body><ProcesarWS xmlns="http://tempuri.org/"><oDataWS><Credentials>';
$xml=$xml.'<UserName>'.$this->user.'</UserName>';
$xml=$xml.'<Password>'.$this->pass.'</Password>';
$xml=$xml.'<CodeAuth>'.$this->auth.'</CodeAuth></Credentials>';
$xml=$xml.'<CredentialsUserSICAS><UserName>SISTEMAS@ASESORESCAPITAL.COM</UserName>';
$xml=$xml.'<Password>ACHAN2019</Password></CredentialsUserSICAS>';
$xml=$xml.'<TypeFormat>JSON</TypeFormat>';
$xml=$xml.'<KeyProcess>DATA</KeyProcess>';
$xml=$xml.'<KeyCode>'.$keyCode.'</KeyCode>';
$xml=$xml.'<TProc>Del_Data</TProc>';
$xml =$xml.'<DataXML>'.$valores.'</DataXML>';
$xml =$xml.'</oDataWS></ProcesarWS></soap:Body></soap:Envelope>';
$headers = array("POST/SOnlineWSQua/WS_SICASOnline.asmx HTTPS/1.1","Content-Type: text/xml; charset=utf-8","Accept: text/xml","Host: www.sicasonline.info","Pragma: no-cache","SOAPAction: http://tempuri.org/ProcesarWS", "Content-length: ".strlen($xml),);


       $soap_do = curl_init();
       $url="https://www.sicasonline.info/SOnlineWS/WS_SICASOnline.asmx?WSDL";
        curl_setopt($soap_do, CURLOPT_URL,$url );
        curl_setopt($soap_do, CURLOPT_POSTFIELDS,$xml);
        curl_setopt($soap_do, CURLOPT_HTTPHEADER,$headers);
        curl_setopt($soap_do, CURLOPT_SSL_VERIFYPEER, 0);
        curl_setopt($soap_do, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($soap_do, CURLOPT_HTTPAUTH, CURLAUTH_ANY);
        curl_setopt($soap_do, CURLOPT_TIMEOUT, 30);
        curl_setopt($soap_do, CURLOPT_POST, true);
        $respuesta=curl_exec($soap_do);         
        curl_close($soap_do);
    
        return $respuesta;

}
//--------------------------------------
private function grabarActualizasDatos($keyCode,$valores){
$xml = '<?xml version="1.0" encoding="utf-8"?><soap:Envelope xmlns:xsi="http://www.w3.org/2001/XMLSchema-instance" xmlns:xsd="http://www.w3.org/2001/XMLSchema" xmlns:soap="http://schemas.xmlsoap.org/soap/envelope/"><soap:Body><ProcesarWS xmlns="http://tempuri.org/"><oDataWS><Credentials>';
$xml=$xml.'<UserName>'.$this->user.'</UserName>';
$xml=$xml.'<Password>'.$this->pass.'</Password>';
$xml=$xml.'<CodeAuth>'.$this->auth.'</CodeAuth></Credentials>';
$xml=$xml.'<CredentialsUserSICAS><UserName>SISTEMAS@ASESORESCAPITAL.COM</UserName>';
$xml=$xml.'<Password>ACHAN2019</Password></CredentialsUserSICAS>';
$xml=$xml.'<TypeFormat>JSON</TypeFormat>';
$xml=$xml.'<KeyProcess>DATA</KeyProcess>';
$xml=$xml.'<KeyCode>'.$keyCode.'</KeyCode>';
$xml=$xml.'<TProc>Save_Data</TProc>';
$xml =$xml.'<DataXML>'.$valores.'</DataXML>';
$xml =$xml.'</oDataWS></ProcesarWS></soap:Body></soap:Envelope>';
$headers = array("POST/SOnlineWSQua/WS_SICASOnline.asmx HTTPS/1.1","Content-Type: text/xml; charset=utf-8","Accept: text/xml","Host: www.sicasonline.info","Pragma: no-cache","SOAPAction: http://tempuri.org/ProcesarWS", "Content-length: ".strlen($xml),);


	     $soap_do = curl_init();
	     $url="https://www.sicasonline.info/SOnlineWS/WS_SICASOnline.asmx?WSDL";
	      curl_setopt($soap_do, CURLOPT_URL,$url );
	      curl_setopt($soap_do, CURLOPT_POSTFIELDS,$xml);
	      curl_setopt($soap_do, CURLOPT_HTTPHEADER,$headers);
	      curl_setopt($soap_do, CURLOPT_SSL_VERIFYPEER, 0);
        curl_setopt($soap_do, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($soap_do, CURLOPT_HTTPAUTH, CURLAUTH_ANY);
        curl_setopt($soap_do, CURLOPT_TIMEOUT, 30);
        curl_setopt($soap_do, CURLOPT_POST, true);
	      $respuesta=curl_exec($soap_do);	        
	      curl_close($soap_do);
	  
	      return $respuesta;
}
//-----------------------------------------------------------------------------------------------------------------------------
function encripta($TextPlain){
	
	$key='%SOnlineBOGO2001-2015WS#';$ivPass='GAP#aCap';
	if(strlen($key)!=24){
		throw new Exception('La longitud de la key ha de ser de 24 dígitos.<br>'); 
		return -1; 
	}
	if((strlen($ivPass) % 8 )!=0){
		throw new Exception('La longitud del vector iv Passsword ha de ser múltiple de 8 dígitos.<br>'); 
		return -2;
	}
	return @base64_encode(mcrypt_encrypt(MCRYPT_3DES, $key, $TextPlain, MCRYPT_MODE_CBC, $ivPass)); 
		   //**@base64_encode(mcrypt_encrypt(MCRYPT_3DES, $key, $TextPlain, MCRYPT_MODE_CBC, $ivPass));
}

//Modificaciones Miguel Jaime

//Cobranza Efectuada por sucursal
public function CobranzaEfectuadaSucursal($array){
$respuesta=array();
        $datos['TipoEntidad']='0';
        $datos['TypeDestinoCDigital']='CONTACT';
        $datos['IDValuePK']='0';
        $datos['ActionCDigital']='GETFiles';
        $datos['TypeFormat']='XML';
        $datos['TProct']='Read_Data';
        $datos['KeyProcess']='REPORT';
        $datos['KeyCode']='H03430_003';
        $datos['Page']='1';
        $datos['ItemForPage']='3000';
        $datos['InfoSort']='VDatDocumentos.IDDocto';
        $datos['IDRelation']='0';
        switch ($array['tipoReporte']) {
        case 'cancun':
          $datos['ConditionsAdd']='Desde|Hasta;3;0;'.$array['fechaInicial'].'|'.$array['fechaFinal'].';0;-1;VDatRecibos.'.$array['tipoFecha'].' ! Documento;0;1;1;1;DatDocumentos.TipoDocto !  Status;0;3;3;0;VDatRecibos.Status ! Despacho;0;3;3;1;DatDocumentos.IDDespacho';
        break;
        case 'institucional':
          $datos['ConditionsAdd']='Desde|Hasta;3;0;'.$array['fechaInicial'].'|'.$array['fechaFinal'].';0;-1;VDatRecibos.'.$array['tipoFecha'].' ! Documento;0;1;1;1;DatDocumentos.TipoDocto !  Status;0;3;3;0;VDatRecibos.Status ! despacho;2;0;2|7;2|7;DatDocumentos.IDDespacho ! gerencia;0;9;9;1;DatDocumentos.IDGerencia ! grupo;1;0;12;0;1;DatDocumentos.IDGrupo ! subramo;1;0;20;0;0;DatDocumentos.IDSRamo';
        break;
        case 'merida':
        $datos['ConditionsAdd']='Desde|Hasta;3;0;'.$array['fechaInicial'].'|'.$array['fechaFinal'].';0;-1;VDatRecibos.'.$array['tipoFecha'].' ! Documento;0;1;1;1;DatDocumentos.TipoDocto ! Status;0;3;3;0;VDatRecibos.Status ! despacho;2;0;2|7;2|7;DatDocumentos.IDDespacho ! gerencia;1;0;9;0;1;DatDocumentos.IDGerencia ';
        break;
        case 'todos':
          $datos['ConditionsAdd']='Desde|Hasta;3;0;'.$array['fechaInicial'].'|'.$array['fechaFinal'].';0;-1;VDatRecibos.'.$array['tipoFecha'].' ! Documento;2;0;1|2;1|2;DatDocumentos.TipoDocto !  Status;0;3;3;0;VDatRecibos.Status';
        break;
      }
       $respuesta=$this->getDatosSICAS($datos);
        return $respuesta;
    }

//----------------------------------------------------------------------------------------------------------------------------
//Dennis [2020-12-29]

function polizasPendientesFianzas($array){

  $fecha_f="";
  $fecha_inicial="";

  $fechaconsultaF=explode("-",$array["fechaFinal"]);
  //$fechaconsultaI=explode("-",$array["fechaInicio"]);

  $fecha_final=date("d-m-Y", mktime(0,0,0,$fechaconsultaF[1]+2,0,$fechaconsultaF[2]));

  if($fechaconsultaF[2]<date("Y") && $fechaconsultaF[1]==12){ //2020 //12

    $fecha_inicial=date("d-m-Y", mktime(0,0,0,$fechaconsultaF[1]-1,1,$fechaconsultaF[2]-1)); //01-11-2019

  } elseif($fechaconsultaF[2]==date("Y")){ //2021 -> mes++

    $fecha_inicial=date("d-m-Y", mktime(0,0,0,12,1,$fechaconsultaF[2]-2)); //01-12-2019

  }elseif($fechaconsultaF[2]<date("Y") && $fechaconsultaF[1]<12){ //2020 11 15

    $fecha_inicial=date("d-m-Y", mktime(0,0,0,10,1,$fechaconsultaF[2]-1)); //01-10-2019
  }

  $datos['TipoEntidad']='0';
  $datos['TypeDestinoCDigital']='CONTACT';
  $datos['IDValuePK']='0';
  $datos['ActionCDigital']='GETFiles';
  $datos['TypeFormat']='XML';
  $datos['TProct']='Read_Data';
  $datos['KeyProcess']='REPORT';
  $datos['KeyCode']='H03430_003';
  $datos['Page']='1';
  $datos['ItemForPage']='1000';
  $datos['InfoSort']='VDatDocumentos.IDDocto';
  $datos['IDRelation']='0';
  /*$datos["ConditionsAdd"]="Desde|Hasta;3;0;".$fecha_inicial."|".$fecha_final.";0;-1;VDatRecibos.FLIMPAGO ! 
    Ramo;0;0;5;Fianzas;VDATDOCUMENTOS.IDRAMO ! 
    Estado;0;0;0;Pendiente;VDatRecibos.STATUS";*/ //"Desde|Hasta;3;0;1-10-2019|".$array["fechaFinal"].";0;-1;VDATDOCUMENTOS.FLIMPAGO ! PolizasPendientes;0;0";

  $condicion_primaria="Desde|Hasta;3;0;".$fecha_inicial."|".$fecha_final.";0;-1;VDatRecibos.FLIMPAGO ! Estado;0;0;0;Pendiente;VDatRecibos.STATUS ! ";

  //Gerencia
  $filtroGerencia="";
  $condicionGerencia="";

  if(!empty($array['filtroGerencia'])){

    foreach($array['filtroGerencia'] as $d){

      if($d!=end($array['filtroGerencia'])){
        $filtroGerencia.=$d."|";
      } else{
        $filtroGerencia.=$d;
      }
    }

    $condicionGerencia.="FiltroGerencia;2;".$array['excepcionCanales'].";".$filtroGerencia.";".$filtroGerencia.";-1;DatDocumentos.IDGerencia ! ";

  }

  //Sucursal
  $filtroSucursal="";
  $condicionSucursal="";

  if(!empty($array['filtroDespacho'])){

    foreach($array['filtroDespacho'] as $d){

      if($d!=end($array['filtroDespacho'])){
        $filtroSucursal.=$d."|";
      } else{
        $filtroSucursal.=$d;
      }
    }

    $condicionSucursal.="FiltroDespacho;2;".$array['excepcionDespacho'].";".$filtroSucursal.";".$filtroSucursal.";-1;DatDocumentos.IDDespacho ! ";
  }
  //Grupos
  $filtroGrupo="";
  $condicionGrupo="";
  if(!empty($array['filtroGrupo'])){

    foreach($array['filtroGrupo'] as $d){

      if($d!=end($array['filtroGrupo'])){
        $filtroGrupo.=$d."|";
      } else{
        $filtroGrupo.=$d;
      }
    }

    $condicionGrupo.="FiltroGrupo;2;".$array['excepcionGrupo'].";".$filtroGrupo.";".$filtroGrupo.";-1;VDatDocumentos.IDGrupo ! ";
  }

  //Ramos Ramo;0;0;5;Fianzas;VDATDOCUMENTOS.IDRAMO ! 
  $filtroRamo="";
  $condicionRamo="";
  if(!empty($array['filtroRamo'])){

    foreach($array['filtroRamo'] as $d){

      if($d!=end($array['filtroRamo'])){
        $filtroRamo.=$d."|";
      } else{
        $filtroRamo.=$d;
      }
    }

    $condicionRamo.="FiltroRamo;2;".$array['excepcionRamos'].";".$filtroRamo.";".$filtroRamo.";-1;VDATDOCUMENTOS.IDRAMO ! ";
  }

  //Vendedores
  $filtroVendedor="";
  $condicionVendedor="";
  if(!empty($array['filtroVendedor'])){

    foreach($array['filtroVendedor'] as $d){

      if($d!=end($array['filtroVendedor'])){
        $filtroVendedor.=$d."|";
      } else{
        $filtroVendedor.=$d;
      }
    }

    $condicionVendedor.="FiltroVendedor;2;".$array['excepcionVendedor'].";".$filtroVendedor.";".$filtroVendedor.";-1;VDATDOCUMENTOS.IDVEND ! ";
  }


  $condicionTotal=$condicion_primaria.$condicionGerencia.$condicionSucursal.$condicionGrupo.$condicionRamo.$condicionVendedor;
  $datos["ConditionsAdd"]=trim($condicionTotal, " ! ");
    //Gerencia;0;0;7;Fianzas;VDATDOCUMENTOS.IDGERENCIA !
  $fp = fopen('resultadoJason.txt', 'a');fwrite($fp, print_r($datos["ConditionsAdd"],TRUE));fclose($fp); 
  $respuesta=$this->getDatosSICAS($datos);

  return $respuesta;

}

//----------------------------------------------------------------------------------------------------------------------------
//Dennis [2020-12-29]
function produccionFianzas($array){

  $datos['TypeFormat']='XML';
  $datos['TProc']='Read_Data';
  $datos['KeyProcess']='REPORT';
  $datos['KeyCode']="H03605_002|H03605_003";
  $datos['Page']='1';
  $datos['ItemForPage']='1000';
  $datos['InfoSort']='VDatDocumentos.IDDocto';
  //$datos['ConditionsAdd']="Desde|Hasta;3;0;".$array["fechaInicial"]."|".$array["fechaFinal"].";0;-1;-1;VDatDocumentos.FEmision ! Estatus;0;0;0;Vigente;-1;-1;VDatDocumentos.Status "; //Desde|Hasta;3;0;1-12-2020|22-12-2020;1-12-2020|22-12-2020;0;-1;VDATDOCUMENTOS.FEmision ! 
  //-------------------------------------------------------
  $condicionTotal="";
  $condicionFecha="Desde|Hasta;3;0;".$array["fechaInicial"]."|".$array["fechaFinal"].";0;-1;-1;VDatDocumentos.FEmision ! Estatus;0;0;0;Vigente;-1;-1;VDatDocumentos.Status ! ";
  //Grupos.
  $filtroGrupos="";
  $condicionGrupo="";
  if(!empty($array["filtroGrupo"])){
    foreach($array["filtroGrupo"] as $d){

      if($d!=end($array["filtroGrupo"])){
        
        $filtroGrupos.=$d."|";
      } else{
        $filtroGrupos.=$d;
      }
    }

    $condicionGrupo.="FiltroGrupo;2;".$array['excepcionGrupo'].";".$filtroGrupos.";".$filtroGrupos.";-1;VDatDocumentos.IDGrupo ! ";
  }
  //Sucursal
  $filtroDespacho="";
  $condicionDespacho="";
  if(!empty($array["filtroDespacho"])){
    foreach($array["filtroDespacho"] as $d){

      if($d!=end($array["filtroDespacho"])){
        
        $filtroDespacho.=$d."|";
      } else{
        $filtroDespacho.=$d;
      }
    }

    $condicionDespacho.="FiltroDespacho;2;".$array['excepcionDespacho'].";".$filtroDespacho.";".$filtroDespacho.";-1;DatDocumentos.IDDespacho ! ";
  }
  //Gerencia
  $filtroGerencia="";
  $condicionGerencia="";
  if(!empty($array["filtroGerencia"])){
    foreach($array["filtroGerencia"] as $d){

      if($d!=end($array["filtroGerencia"])){
        
        $filtroGerencia.=$d."|";
      } else{
        $filtroGerencia.=$d;
      }
    }

    $condicionGerencia.="FiltroGerencia;2;".$array['excepcionCanales'].";".$filtroGerencia.";".$filtroGerencia.";-1;DatDocumentos.IDGerencia ! ";
  }
  //Vendedores
  $filtroVendedor="";
  $condicionVendedor="";
  if(!empty($array["filtroVendedor"])){
    foreach($array["filtroVendedor"] as $d){

      if($d!=end($array["filtroVendedor"])){
        
        $filtroVendedor.=$d."|";
      } else{
        $filtroVendedor.=$d;
      }
    }

    $condicionVendedor.="FiltroVendedor;2;".$array['excepcionVendedor'].";".$filtroVendedor.";".$filtroVendedor.";-1;VDATDOCUMENTOS.IDVEND ! ";
  }
  $condicionTotal=$condicionFecha.$condicionGrupo.$condicionDespacho.$condicionGerencia.$condicionVendedor;
  //$prueba=trim($condicionTotal, "!");
  $datos['ConditionsAdd']=trim($condicionTotal," ! ");
  //-------------------------------------------------------
  // ! Estatus;0;0;0;Vigente;-1;-1;VDatDocumentos.Status
  //1-12-2020|22-12-2020
  $respuesta=$this->getDatosSICAS($datos);
  //$fp = fopen('resultadoJason.txt', 'a');fwrite($fp, print_r($datos['ConditionsAdd'],TRUE));fclose($fp); 

  $pol=array();

  /*foreach($respuesta->TableInfo as $polizas){

    array_push($pol,(String)$polizas->Documento);

  } */
  return $respuesta;
}

//----------------------------------------------------------------------------------------------------------------------------
//----------------------------------------------------------------------------------------------------------------------------
function recibosClientes($array){
  /*ESTOS SON REPORTES DE cobranza
  $tipoCobranza=  ES EL TIPO DE COBRANZA QUE SE QUIERE OBTENER 0(COBRANZA PENDIENTE),1(COBRANZA CANCELADA),3(COBRANZA EFECTUADA/PAGADO),4(LIQUIDADO)
  */

  $keyCode="H03430_003";
  $fechaTipoRecibo="VDatRecibos";
  if($array['tipoFecha']=='FDocto'){
    $keyCode='H03430_001';$fechaTipoRecibo='VDatPagosRec';

  } elseif($array['tipoFecha']=='FEmision'){ //FEmision
    $keyCode='H03400'; //: H03400|H03400_005
    $fechaTipoRecibo='DatDocumentos'; //

  }

          $datos['TipoEntidad']='0';
          $datos['TypeDestinoCDigital']='CONTACT';
          $datos['IDValuePK']='0';
          $datos['ActionCDigital']='GETFiles';
          $datos['TypeFormat']='XML';
          $datos['TProct']='Read_Data';
          $datos['KeyProcess']='REPORT';
          $datos['KeyCode']=$keyCode; //'H03430_003';
          $datos['Page']='1';
          $datos['ItemForPage']='1000000';
          $datos['InfoSort']='VDatDocumentos.IDDocto';
          $datos['IDRelation']='0';
    
  $filtroGrupoValores="";
  $filtroGrupo="";
  $filtroSubGrupoValores = "";
  $filtroSubGrupo = "";
  $filtroDespachoValores="";
  $filtroDespacho="";
  $filtroGerenciaValores="";
  $filtroGerencia="";
  $filtroRamoValores="";
  $filtroRamo="";
  $filtroVendedor="";
  $filtroTipoFechaValores="";
  $filtroTipoFecha="";
  $filtroStatus="";
  $filtroStatusValores="";
  $filtroVendedoresValores="";

  //Filtro de grupos
  if(isset($array['filtroGrupo']))
  {
    foreach ($array['filtroGrupo'] as  $value) 
    {
    if ($value === end($array['filtroGrupo'])) { $filtroGrupoValores.=$value;}
    else{$filtroGrupoValores.=$value.'|';}

    }

    $filtroExcepcionGrupo="grupo;2;0;";

    if($array["excepcionGrupo"]==1){$filtroExcepcionGrupo="grupo;2;1;";
    }

    if($filtroGrupoValores!=""){$filtroGrupo=$filtroExcepcionGrupo.$filtroGrupoValores.';'.$filtroGrupoValores.';DatDocumentos.IDGrupo ! ';}
  }

  //Filtro de SubGrupos
  if(isset($array['filtroSubGrupo'])) {
    foreach ($array['filtroSubGrupo'] as  $value) {
      if ($value === end($array['filtroSubGrupo'])) {
        $filtroSubGrupoValores.=$value;
      }
      else{
        $filtroSubGrupoValores.=$value.'|';
      }
    }
    $filtroExcepcionSubGrupo="subgrupo;2;0;";
    if($array["excepcionSubGrupo"]==1) {
      $filtroExcepcionSubGrupo="subgrupo;2;1;";
    }
    if($filtroSubGrupoValores!="") {
      $filtroSubGrupo=$filtroExcepcionSubGrupo.$filtroSubGrupoValores.';'.$filtroSubGrupoValores.';DatDocumentos.SubGrupo ! ';
    }
  }

  //Filtro de despacho
  if(isset($array['filtroDespacho']))
  {
    foreach ($array['filtroDespacho'] as  $value) 
    {
    if ($value === end($array['filtroDespacho'])) { $filtroDespachoValores.=$value;}
    else{$filtroDespachoValores.=$value.'|';}

    }

    $filtroExcepcionDespacho="Despacho;2;0;";

    if($array["excepcionDespacho"]==1){

      $filtroExcepcionDespacho="Despacho;2;1;";
    }

    if($filtroDespachoValores!=""){$filtroDespacho=$filtroExcepcionDespacho.$filtroDespachoValores.';'.$filtroDespachoValores.';DatDocumentos.IDDespacho ! ';}
  }

  //Filtro de gerencia
  if(isset($array['filtroGerencia']))
  {
    foreach ($array['filtroGerencia'] as  $value) 
    {
    if ($value === end($array['filtroGerencia'])) { $filtroGerenciaValores.=$value;}
    else{$filtroGerenciaValores.=$value.'|';}

    }

    $filtroExcepcionGerencia="gerencia;2;0;";

    if($array["excepcionCanales"]==1){

      $filtroExcepcionGerencia="gerencia;2;1;";
    }

    if($filtroGerenciaValores!=""){$filtroGerencia=$filtroExcepcionGerencia.$filtroGerenciaValores.';'.$filtroGerenciaValores.';DatDocumentos.IDGerencia ! ';}
  }

  //Filtro de ramo
  if(isset($array['filtroRamo']))
  {
    foreach ($array['filtroRamo'] as  $value) 
    {
    if ($value === end($array['filtroRamo'])) { $filtroRamoValores.=$value;}
    else{$filtroRamoValores.=$value.'|';}

    }
    $filtroExcepcionRamo="Ramo;2;0;";

    if($array["excepcionRamos"]==1){

      $filtroExcepcionRamo="Ramo;2;1;";
    }

    if($filtroRamoValores!=""){$filtroRamo=$filtroExcepcionRamo.$filtroRamoValores.';'.$filtroRamoValores.';DatDocumentos.IDRamo ! ';}
  }
  //Filtro de vendedor.
  if(isset($array['filtroVendedor']))
  {
    foreach ($array['filtroVendedor'] as  $value) 
    {
    if ($value === end($array['filtroVendedor'])) { $filtroVendedoresValores.=$value;}
    else{$filtroVendedoresValores.=$value.'|';}

    }

    $filtroExcepcionVendedor="VendedorID;2;0;";

    if($array["excepcionVendedor"]==1){

      $filtroExcepcionVendedor="VendedorID;2;1;";

    }

    if($filtroVendedoresValores!=""){
      $filtroVendedor=$filtroExcepcionVendedor.$filtroVendedoresValores.';'.$filtroVendedoresValores.';VDATDOCUMENTOS.IDVEND ! ';
    
    }
  }
  //Filtro de estatus.
  if(isset($array['filtroStatus']) && $array['tipoFecha'] != 'FEmision')
  {
    foreach ($array['filtroStatus'] as  $value) 
    {
      if($value!=-1){
        if ($value === end($array['filtroStatus'])) { $filtroStatusValores.=$value;}
      else{$filtroStatusValores.=$value.'|';}
        }
    }
    if($filtroStatusValores!=""){
      $filtroStatus='Ramo;2;0;'.$filtroStatusValores.';'.$filtroStatusValores.';VDatRecibos.Status ! '; //DatVendedor.IDVend !
    }
  }

  $filtrosGenerales='Desde|Hasta;3;0;'.$array['fechaInicial'].'|'.$array['fechaFinal'].';0;-1;'.$fechaTipoRecibo.'.'.$array['tipoFecha'].' ! '; //VDatRecibos
  $condicion=$filtrosGenerales.$filtroGrupo.$filtroSubGrupo.$filtroDespacho.$filtroGerencia.$filtroRamo.$filtroVendedor.$filtroStatus; //."GerenciaD;2;1;null;VCATGERENCIA.NOMBRE"
  $datos['ConditionsAdd']=trim($condicion,'! ');


  //$datos['ConditionsAdd']='Desde|Hasta;3;0;'.$array['fechaInicial'].'|'.$array['fechaFinal'].';0;-1;VDatRecibos.'.$array['tipoFecha'].' ! Ramo;2;0;5;5;DatDocumentos.IDRamo';

  //despacho;2;0;2|7;2|7;

  /*Desde|Hasta;3;0;1-11-2020|15-11-2020;0;-1;VDatRecibos.FLimPago ! 
  Despacho;2;1;3;3;DatDocumentos.IDDespacho ! 
  gerencia;2;1;9|7;9|7;DatDocumentos.IDGerencia ! 
  Ramo;2;1;5|6;5|6;DatDocumentos.IDRamo ! 
  VendedorID;2;1;7;7;CatVendedores.IdVend ! 
  CanceladosNull;2;1;301;DatDocumentos.Codigo    


  gerNull;2;1;'';VCATGERENCIA.NOMBRE


  */

  /* $datos['ConditionsAdd']='Desde|Hasta;3;0;'.$array['fechaInicial'].'|'.$array['fechaFinal'].';0;-1;VDatRecibos.'.$array['tipoFecha'].' ! Documento;0;1;1;1;DatDocumentos.TipoDocto  ! despacho;2;0;2|7;2|7;DatDocumentos.IDDespacho ! gerencia;0;9;9;1;DatDocumentos.IDGerencia ! grupo;1;0;12;0;1;DatDocumentos.IDGrupo';*/
    //$fp = fopen('resultadoJason.txt', 'a');fwrite($fp, print_r($datos['ConditionsAdd'],TRUE));fclose($fp);  


      $respuesta=$this->getDatosSICAS($datos);
      //$fp = fopen('resultadoJason.txt', 'a');fwrite($fp, print_r($respuesta,TRUE));fclose($fp); 
      return $respuesta;
      
  
}
//----------------------------------------------------------------------------------------------------

function recibosClientes_respaldo($array)
{
/*ESTOS SON REPORTES DE cobranza
$tipoCobranza=  ES EL TIPO DE COBRANZA QUE SE QUIERE OBTENER 0(COBRANZA PENDIENTE),1(COBRANZA CANCELADA),3(COBRANZA EFECTUADA/PAGADO),4(LIQUIDADO)
*/

$keyCode="H03430_003";
$fechaTipoRecibo="VDatRecibos";
if($array['tipoFecha']=='FDocto'){$keyCode='H03430_001';$fechaTipoRecibo='VDatPagosRec';}

        $datos['TipoEntidad']='0';
        $datos['TypeDestinoCDigital']='CONTACT';
        $datos['IDValuePK']='0';
        $datos['ActionCDigital']='GETFiles';
        $datos['TypeFormat']='XML';
        $datos['TProct']='Read_Data';
        $datos['KeyProcess']='REPORT';
        $datos['KeyCode']=$keyCode; //'H03430_003';
        $datos['Page']='1';
        $datos['ItemForPage']='10000';
        $datos['InfoSort']='VDatDocumentos.IDDocto';
        $datos['IDRelation']='0';
  
$filtroGrupoValores="";
$filtroGrupo="";
$filtroDespachoValores="";
$filtroDespacho="";
$filtroGerenciaValores="";
$filtroGerencia="";
$filtroRamoValores="";
$filtroRamo="";
$filtroVendedor="";
$filtroTipoFechaValores="";
$filtroTipoFecha="";
$filtroStatus="";
$filtroStatusValores="";
$filtroVendedoresValores="";

//Filtro de grupos
if(isset($array['filtroGrupo']))
{
  foreach ($array['filtroGrupo'] as  $value) 
  {
   if ($value === end($array['filtroGrupo'])) { $filtroGrupoValores.=$value;}
   else{$filtroGrupoValores.=$value.'|';}

  }

  $filtroExcepcionGrupo="grupo;2;0;";

  if($array["excepcionGrupo"]==1){

    $filtroExcepcionGrupo="grupo;2;1;";
  }

  if($filtroGrupoValores!=""){$filtroGrupo=$filtroExcepcionGrupo.$filtroGrupoValores.';'.$filtroGrupoValores.';DatDocumentos.IDGrupo ! ';}
}

//Filtro de despacho
if(isset($array['filtroDespacho']))
{
  foreach ($array['filtroDespacho'] as  $value) 
  {
   if ($value === end($array['filtroDespacho'])) { $filtroDespachoValores.=$value;}
  else{$filtroDespachoValores.=$value.'|';}

  }

  $filtroExcepcionDespacho="Despacho;2;0;";

  if($array["excepcionDespacho"]==1){

    $filtroExcepcionDespacho="Despacho;2;1;";
  }

  if($filtroDespachoValores!=""){$filtroDespacho=$filtroExcepcionDespacho.$filtroDespachoValores.';'.$filtroDespachoValores.';DatDocumentos.IDDespacho ! ';}
}

//Filtro de gerencia
if(isset($array['filtroGerencia']))
{
  foreach ($array['filtroGerencia'] as  $value) 
  {
   if ($value === end($array['filtroGerencia'])) { $filtroGerenciaValores.=$value;}
  else{$filtroGerenciaValores.=$value.'|';}

  }

  $filtroExcepcionGerencia="gerencia;2;0;";

  if($array["excepcionCanales"]==1){

    $filtroExcepcionGerencia="gerencia;2;1;";
  }

  if($filtroGerenciaValores!=""){$filtroGerencia=$filtroExcepcionGerencia.$filtroGerenciaValores.';'.$filtroGerenciaValores.';DatDocumentos.IDGerencia ! ';}
}

//Filtro de ramo
if(isset($array['filtroRamo']))
{
  foreach ($array['filtroRamo'] as  $value) 
  {
   if ($value === end($array['filtroRamo'])) { $filtroRamoValores.=$value;}
  else{$filtroRamoValores.=$value.'|';}

  }
  $filtroExcepcionRamo="Ramo;2;0;";

  if($array["excepcionRamos"]==1){

    $filtroExcepcionRamo="Ramo;2;1;";
  }

  if($filtroRamoValores!=""){$filtroRamo=$filtroExcepcionRamo.$filtroRamoValores.';'.$filtroRamoValores.';DatDocumentos.IDRamo ! ';}
}
//Filtro de vendedor.
if(isset($array['filtroVendedor']))
{
  foreach ($array['filtroVendedor'] as  $value) 
  {
   if ($value === end($array['filtroVendedor'])) { $filtroVendedoresValores.=$value;}
  else{$filtroVendedoresValores.=$value.'|';}

  }

  $filtroExcepcionVendedor="VendedorID;2;0;";

  if($array["excepcionVendedor"]==1){

    $filtroExcepcionVendedor="VendedorID;2;1;";

  }

  if($filtroVendedoresValores!=""){
    $filtroVendedor=$filtroExcepcionVendedor.$filtroVendedoresValores.';'.$filtroVendedoresValores.';VDATDOCUMENTOS.IDVEND ! ';
  
  }
}
//Filtro de estatus.
if(isset($array['filtroStatus']))
{
  foreach ($array['filtroStatus'] as  $value) 
  {
    if($value!=-1){
      if ($value === end($array['filtroStatus'])) { $filtroStatusValores.=$value;}
     else{$filtroStatusValores.=$value.'|';}
       }
  }
  if($filtroStatusValores!=""){
    $filtroStatus='Ramo;2;0;'.$filtroStatusValores.';'.$filtroStatusValores.';VDatRecibos.Status ! '; //DatVendedor.IDVend !
  } else{

  }
}

$filtrosGenerales='Desde|Hasta;3;0;'.$array['fechaInicial'].'|'.$array['fechaFinal'].';0;-1;'.$fechaTipoRecibo.'.'.$array['tipoFecha'].' ! '; //VDatRecibos
$condicion=$filtrosGenerales.$filtroGrupo.$filtroDespacho.$filtroGerencia.$filtroRamo.$filtroVendedor.$filtroStatus; //."GerenciaD;2;1;null;VCATGERENCIA.NOMBRE"
$datos['ConditionsAdd']=trim($condicion,'! ');


//$datos['ConditionsAdd']='Desde|Hasta;3;0;'.$array['fechaInicial'].'|'.$array['fechaFinal'].';0;-1;VDatRecibos.'.$array['tipoFecha'].' ! Ramo;2;0;5;5;DatDocumentos.IDRamo';

//despacho;2;0;2|7;2|7;

/*Desde|Hasta;3;0;1-11-2020|15-11-2020;0;-1;VDatRecibos.FLimPago ! 
Despacho;2;1;3;3;DatDocumentos.IDDespacho ! 
gerencia;2;1;9|7;9|7;DatDocumentos.IDGerencia ! 
Ramo;2;1;5|6;5|6;DatDocumentos.IDRamo ! 
VendedorID;2;1;7;7;CatVendedores.IdVend ! 
CanceladosNull;2;1;301;DatDocumentos.Codigo    


gerNull;2;1;'';VCATGERENCIA.NOMBRE


*/

/* $datos['ConditionsAdd']='Desde|Hasta;3;0;'.$array['fechaInicial'].'|'.$array['fechaFinal'].';0;-1;VDatRecibos.'.$array['tipoFecha'].' ! Documento;0;1;1;1;DatDocumentos.TipoDocto  ! despacho;2;0;2|7;2|7;DatDocumentos.IDDespacho ! gerencia;0;9;9;1;DatDocumentos.IDGerencia ! grupo;1;0;12;0;1;DatDocumentos.IDGrupo';*/
  //$fp = fopen('resultadoJason.txt', 'a');fwrite($fp, print_r($datos['ConditionsAdd'],TRUE));fclose($fp);  


     $respuesta=$this->getDatosSICAS($datos);
     //$fp = fopen('resultadoJason.txt', 'a');fwrite($fp, print_r($respuesta,TRUE));fclose($fp); 
     return $respuesta;
    
 
}
//----------------------------------------------------------------------------------------------------
function consultaAvanceSicas($coor,$idVend,$fecha_i,$fecha_f,$ramo_s){

  $datos['TipoEntidad']='0';
  $datos['TypeDestinoCDigital']='CONTACT';
  $datos['IDValuePK']='0';
  $datos['ActionCDigital']='GETFiles';
  $datos['TypeFormat']='XML';
  $datos['TProct']='Read_Data';
  $datos['KeyProcess']='REPORT';
  $datos['KeyCode']='H02930_003';
  $datos['Page']='1';
  $datos['ItemForPage']='1000';
  $datos['InfoSort']='DatHonRecibos.Status_TXT';
  $datos['IDRelation']='0';
    // $datos['ConditionsAdd']='Recibos;0;0;1;Pagados;1;-1;DatHonRecibos.Pagado ! Desde|Hasta|Fecha de Pago;3;0;'.$fechaInicial.'|'.$fechaFinal.';'.$fechaInicial.'|'.$fechaFinal.';0;-1;DatHonDocto.FPago ! VendedorID;2;0;'.$IDVend.';0;DatHonRecibos.IDVE' ;
  //$datos['ConditionsAdd']='Recibos;0;0;1;Pagados;1;-1;DatHonRecibos.Pagado ! FPago;3;0;'.$fecha_i.'|'.$fecha_f.';0;-1;DatHonRecibos.FPago ! Ramo;0;0;'.$ramo_s.';0;DatDocumentos.IDRamo ! VendedorID;2;0;'.$idVend.';0;DatHonRecibos.IDVE'; //! VendedorID;2;0;'.$idVend.';0;DatHonRecibos.IDVE //! Ramo;0;0;'.$ramo_s.';0;-1;DatHonRecibos.IDRamo
  //-------------
  $filtroCoor="";
  /*if($coor!=805){
    $filtroCoor="Ramo;2;1;5|6;5|6;-1;DatDocumentos.IDRamo ! Grupo";
  } else{
    $filtroCoor="Ramo;0;0;5;5;DatDocumentos.IDRamo !";
  }*/

  //------------
  $condicion_ramo="";

  if($ramo_s !=null){
    $condicion_ramo="Ramo;0;0;".$ramo_s.";0;DatDocumentos.IDRamo !";
  }

  $str_conditionAdd='Recibos;0;0;1;Pagados;1;-1;DatHonRecibos.Pagado ! FPago;3;0;'.$fecha_i.'|'.$fecha_f.';0;-1;DatHonRecibos.FPago ! '.$condicion_ramo.' VendedorID;2;0;'; //'.$idVend.';0;DatHonRecibos.IDVE';

  $busquedaAgentes="";

  for($i=0; $i<count($idVend); $i++){

    $busquedaAgentes.=$idVend[$i]."|";

  }

  $conditionAdd=$str_conditionAdd.trim($busquedaAgentes, "|").";".trim($busquedaAgentes, "|").";DatHonRecibos.IDVE";
  //$conditionAdd.='|';
          //$datos['ConditionsAdd']='Desde|Hasta|Fecha de Pago;2;0;'.$fechaInicial.'|'.$fechaFinal.';'.$fechaInicial.'|'.$fechaFinal.';0;-1;DatHonDocto.FPago ! VendedorID;2;0;'.$IDVend.';0;DatHonRecibos.IDVE' ;
    //$respuestaSicas=$this->obtenerDatos($datos);
  $datos['ConditionsAdd']=$conditionAdd;

  //$fp = fopen('resultadoJason.txt', 'a');fwrite($fp, print_r($conditionAdd,TRUE));fclose($fp);

  $respuesta=$this->getDatosSICAS($datos);

  return $respuesta;

}
//----------------------------------------------------------------------------------------------------
function polizas_emitidas_asesores($array){ //funcion que devuelve de Sicas las polizas emitidas (reportes/operaciones/polizas).

  /*$datos['TipoEntidad']='0';
  $datos['TypeDestinoCDigital']='CONTACT';
  $datos['IDValuePK']='0';
  $datos['ActionCDigital']='GETFiles';
  $datos['TypeFormat']='XML';
  $datos['TProct']='Read_Data';
  $datos['KeyProcess']='REPORT';
  $datos['KeyCode']='H03400|H03400_005'; //|H03400_005 //H03400|
  $datos['Page']='1';
  $datos['ItemForPage']='100';
  $datos['InfoSort']='VDatDocumentos.IDDocto';
  $datos['IDRelation']='0';*/
  $datos['TypeFormat']='XML';
  $datos['TProc']='Read_Data';
  $datos['KeyProcess']='REPORT';
  $datos['KeyCode']="H03400"; //|H03400_005
  $datos['Page']='1';
  $datos['ItemForPage']='100';
  $datos['InfoSort']='VDatDocumentos.IDDocto'; //VDatDocumentos
  $datos['ConditionsAdd']="Desde|Hasta;3;0;".$array["fechaInicial"]."|".$array["fechaFinal"].";".$array["fechaInicial"]."|".$array["fechaFinal"].";0;-1;-1;DatDocumentos.FEmision ! DocPoliza;2;0;1;Polizas;-1;-1;DatDocumentos.TipoDocto"; //! Despacho;2;0;3;3;DatDocumentos.IDDespacho ! gerencia;2;1;9;9;DatDocumentos.IDGerencia ! Ramo;2;1;6|5;6|5;DatDocumentos.IDRamo ! VendedorID;2;1;7;7;DatDocumentos.IDVEND";

  //Desde|Hasta;3;0;01-04-2021|14-04-2021;0;-1;VDatPagosRec.FDocto ! Despacho;2;0;3;3;DatDocumentos.IDDespacho ! gerencia;2;1;9;9;DatDocumentos.IDGerencia ! Ramo;2;1;6|5;6|5;DatDocumentos.IDRamo ! VendedorID;2;1;7;7;VDATDOCUMENTOS.IDVEND ! Ramo;2;0;3|4;3|4;VDatRecibos.Status

  $respuesta=$this->getDatosSICAS($datos);

  return $respuesta;

}
//----------------------------------------------------------------------------------------------------
public function devuelveCobranzaPorTipoReporte($array){
  $respuesta=array();
          $datos['TipoEntidad']='0';
          $datos['TypeDestinoCDigital']='CONTACT';
          $datos['IDValuePK']='0';
          $datos['ActionCDigital']='GETFiles';
          $datos['TypeFormat']='XML';
          $datos['TProct']='Read_Data';
          $datos['KeyProcess']='REPORT';
          $datos['KeyCode']='H03430_003';
          $datos['Page']='1';
          $datos['ItemForPage']='3000';
          $datos['InfoSort']='VDatDocumentos.IDDocto';
          $datos['IDRelation']='0';
          switch ($array['tipoReporte']) {
            case 'cancun':
              $datos['ConditionsAdd']='Desde|Hasta;3;0;'.$array['fechaInicial'].'|'.$array['fechaFinal'].';0;-1;VDatRecibos.'.$array['tipoFecha'].' ! Documento;0;1;1;1;DatDocumentos.TipoDocto !  Status;0;1;'.$array["estatus"].';0;VDatRecibos.Status ! Despacho;0;3;3;1;DatDocumentos.IDDespacho';
            break;
            case 'institucional':
              $datos['ConditionsAdd']='Desde|Hasta;3;0;'.$array['fechaInicial'].'|'.$array['fechaFinal'].';0;-1;VDatRecibos.'.$array['tipoFecha'].' ! Documento;0;1;1;1;DatDocumentos.TipoDocto !  Status;0;1;'.$array["estatus"].';0;VDatRecibos.Status ! despacho;2;0;2|7;2|7;DatDocumentos.IDDespacho ! gerencia;0;9;9;1;DatDocumentos.IDGerencia ! grupo;1;0;12;0;1;DatDocumentos.IDGrupo ! subramo;1;0;20;0;0;DatDocumentos.IDSRamo';
            break;
            case 'merida':
            $datos['ConditionsAdd']='Desde|Hasta;3;0;'.$array['fechaInicial'].'|'.$array['fechaFinal'].';0;-1;VDatRecibos.'.$array['tipoFecha'].' ! Documento;0;1;1;1;DatDocumentos.TipoDocto ! Status;0;3;'.$array["estatus"].';0;VDatRecibos.Status ! despacho;2;0;2|7;2|7;DatDocumentos.IDDespacho ! gerencia;1;0;9;0;1;DatDocumentos.IDGerencia ';
            break;
            case 'todos':
              $datos['ConditionsAdd']='Desde|Hasta;3;0;'.$array['fechaInicial'].'|'.$array['fechaFinal'].';0;-1;VDatRecibos.'.$array['tipoFecha'].' ! Documento;2;0;1|2;1|2;DatDocumentos.TipoDocto !  Status;0;3;3;0;VDatRecibos.Status';
            break;
          }
         $respuesta=$this->getDatosSICAS($datos);
          return $respuesta;
}

//-------------------------------------------------
function informacionDeBitacora($claveBit)
{
    $respuesta=array();
          $datos['TipoEntidad']='0';
          $datos['TypeDestinoCDigital']='CONTACT';
          $datos['IDValuePK']='0';
          $datos['ActionCDigital']='GETFiles';
          $datos['TypeFormat']='XML';
          $datos['TProct']='Read_Data';
          $datos['KeyProcess']='REPORT';
          $datos['KeyCode']='HWS_BITACORA';
          $datos['Page']='1';
          $datos['ItemForPage']='3000';
          $datos['InfoSort']='DatBitacora.FechaHora Desc';
          $datos['IDRelation']='0';
          $datos['ConditionsAdd']="Bitacora;0;0;".$claveBit.";Tarea;DatBitacora.ClaveBit";
   $respuesta=$this->getDatosSICAS($datos);
   return $respuesta;
}

//--------------------------------TIC CINSULTORES / MIGUEL AVILA / BUSQUEDA DE POLIZAS EN SICAS / 26-04-2021----------------------------------

public function  PruebaPolizas($data){//PruebaPolizas
      $datos['TypeFormat']='XML';
      $datos['KeyProcess']='REPORT';
      $datos['KeyCode']='HWS_DOCTOS';
      $datos['Page']='1';
      $datos['ItemForPage']='2000';
      $datos['InfoSort']='DatDocumentos.IDDocto';
      $fecha_actual = date("d-m-Y");
      $fechaFiltro= date("d/m/Y",strtotime($fecha_actual."- 2 year")); 
    $filtro=array();
    if($data["num_poliza_m"]!=''){
      $filtro[]='num_poliza;0;0;*'.$data["num_poliza_m"].'*;*'.$data["num_poliza_m"].'*;VDatDocumentos.Documento';
    }
    if($data["moral"]=="true"){
      $filtro[]='Nombre_completo;0;0;*'.$data["nombres"].'*;*'.$data["nombres"].'*;VCatClientes.NombreCompleto';
      $filtro[]='Entidad;0;0;1;1;VCatClientes.TipoEnt';
    }else{
        if($data["nombres"]!=''){
          $filtro[]='Nombre;0;0;*'.$data["nombres"].'*;0;VCatClientes.Nombre';
        }
        if($data["apellido_p"]!=''){
          $filtro[]='NoapellidoP;0;0;*'.$data["apellido_p"].'*;0;VCatClientes.ApellidoP';
        }
        if($data["apellido_m"]!=''){
          $filtro[]='apellidoM;0;0;*'.$data["apellido_m"].'*;0;VCatClientes.ApellidoM';
        }
    }
    $filtro[]='Fecha;5;1;'.$fechaFiltro.';'.$fechaFiltro.';VDatDocumentos.FHasta';
    //$filtro[]='Estatus;2;1;1|3;1|3;-1;-1;VDatDocumentos.Status';
    $datos['ConditionsAdd']=implode("!",$filtro);
    //$datos['ConditionsAdd']='Nombre C;0;1;polanco;0;VCatClientes.ApellidoP!Estatus;0;0;0;Vigente;-1;-1;VDatDocumentos.Status';

    $respuesta = $this->getDatosSICAS($datos);
    //$respuesta=$datos;
    return $respuesta;
  
  }

  public function Polizas_Documento($IDDocto){
  
    /*======BUSCAR AL CLIENTE EN SICAS NOS PROPORCIONA OTROS DATOS QUE LA FUNCION HDS00002 COMO EL TELEFONO======*/
    /*
    $IDClI=ES EL ID DEL CLIENTE EN SICAS EL CUAL DEBE SER UN ENTERO(1,2,3,5..)
     */
       /*  $datos['TipoEntidad']='0';
        $datos['TypeDestinoCDigital']='CONTACT';
        $datos['IDValuePK']='0';
        $datos['ActionCDigital']='GETFiles'; */
        $datos['TypeFormat']='XML';
        //$datos['TProct']='Read_Data';
        $datos['KeyProcess']='REPORT';
        $datos['KeyCode']='HWS_DOCTOS';
        $datos['Page']='1';
        $datos['ItemForPage']='2000';
        $datos['InfoSort']='DatDocumentos.IDDocto';
        $filtro[]='num_poliza;0;0;*'.$IDDocto.'*;*'.$IDDocto.'*;VDatDocumentos.IDDocto';
        //$filtro[]='Estatus;2;1;1|3;1|3;-1;-1;VDatDocumentos.Status';
        $datos['ConditionsAdd']=implode("!",$filtro);
        //$datos['ConditionsAdd']='Nombre C;0;1;polanco;0;VCatClientes.ApellidoP!Estatus;0;0;0;Vigente;-1;-1;VDatDocumentos.Status';
  
        $respuesta = $this->getDatosSICAS($datos);
        //$respuesta=$datos;
        return $respuesta;
    }
//--------------------------------FIN DE BUSQUEDA DE POLIZAS EN SICAS / 26-04-2021----
public function docDeActividades($IDValuePK,$typeD,$recursivo=1){
        $datos['TipoEntidad']='0';
        $datos['TypeDestinoCDigital']=$typeD;
        $datos['IDValuePK']=$IDValuePK;
        $datos['ActionCDigital']='GETFiles';
        $datos['TypeFormat']='XML';
        $datos['TProct']='Read_Data';
        $datos['KeyProcess']='CDIGITAL';
        $datos['KeyCode']='';
        $datos['Page']='1';
        $datos['ItemForPage']='10000000';
        $datos['InfoSort']='';
        $datos['IDRelation']='0';
        $datos['ReadRecursive']=$recursivo;

 

 $respuesta=$this->getDatosSICAS($datos);
 return $respuesta;


}

//-----------------------------------
function renovacionesYaRenovadas(){

  $fi = date("d-m-Y", mktime(0,0,0, date("n"), 1, date("Y")));
  $ff = date("d-m-Y", mktime(0,0,0, date("n") + 1, 0, date("Y")));

  $datos['TypeFormat']='XML';
  $datos['TProc']='Read_Data';
  $datos['KeyProcess']='REPORT';
  $datos['KeyCode']="H03400"; //|H03400_005
  $datos['Page']='1';
  $datos['ItemForPage']='10000';
  $datos['InfoSort']='VDatDocumentos.IDDocto'; //VDatDocumentos
  $datos['ConditionsAdd']="Desde|Hasta;3;0;".$fi."|".$ff.";".$fi."|".$ff.";0;-1;-1;DatDocumentos.FDesde ! Estado;2;0;0;0;DatDocumentos.Status ! DocPoliza;2;1;2;Polizas;-1;-1;DatDocumentos.TipoDocto";
  
  $fp = fopen('resultadoJason.txt', 'a');fwrite($fp, print_r($datos['ConditionsAdd'],TRUE));fclose($fp);
  $respuesta=$this->getDatosSICAS($datos);

  return $respuesta;
}
//-----------------------------------
function buscarReciboPorID($IDRecibo)
{
  $keyCode="H03430_003";
          $datos['TipoEntidad']='0';
          $datos['TypeDestinoCDigital']='CONTACT';
          $datos['IDValuePK']='0';
          $datos['ActionCDigital']='GETFiles';
          $datos['TypeFormat']='XML';
          $datos['TProct']='Read_Data';
          $datos['KeyProcess']='REPORT';
          $datos['KeyCode']=$keyCode; //'H03430_003';
          $datos['Page']='1';
          $datos['ItemForPage']='10000';
          $datos['InfoSort']='VDatDocumentos.IDDocto';
          $datos['IDRelation']='0';
        $datos['ConditionsAdd']='IDDocto;0;0;'.$IDRecibo.';'.$IDRecibo.';VDatRecibos.IDRecibo';
  $respuesta=$this->getDatosSICAS($datos);
 return $respuesta;

}


//-----------------------------------------------
function filtroParaCanales($tipoReporte)
{
  $condicion='';
  switch ($tipoReporte) 
{
  case 'cancun':
$condicion=' Documento;0;1;1;1;DatDocumentos.TipoDocto  ! Despacho;0;3;3;1;DatDocumentos.IDDespacho';
    break;
  case 'fianzas':
$condicion=' Documento;0;2;2;1;DatDocumentos.TipoDocto ';
  break;
case 'institucional':
$condicion=' Documento;0;1;1;1;DatDocumentos.TipoDocto  ! despacho;2;0;2|7;2|7;DatDocumentos.IDDespacho ! gerencia;0;9;9;1;DatDocumentos.IDGerencia ! grupo;1;0;12;0;1;DatDocumentos.IDGrupo ! subramo;1;0;20;0;0;DatDocumentos.IDSRamo';
  break;
  case 'merida':
$condicion=' Documento;0;1;1;1;DatDocumentos.TipoDocto  ! despacho;2;0;2|7;2|7;DatDocumentos.IDDespacho ! gerencia;1;0;9;0;1;DatDocumentos.IDGerencia ';
  break;
case 'grupocer':
$condicion='Documento;0;1;1;1;DatDocumentos.TipoDocto  ! grupo;0;0;12;0;1;DatDocumentos.IDGrupo ! VendedorID;0;0;7;0;0;CatVendedores.IdVend';
  break;
case 'grupoflotillas':
$condicion='Documento;0;1;1;1;DatDocumentos.TipoDocto  ! grupo;1;0;12;0;1;DatDocumentos.IDGrupo ! VendedorID;0;0;7;0;0;CatVendedores.IdVend ! subramo;0;0;20;0;0;DatDocumentos.IDSRamo';
  break;
  case 'gmmVida':
  #'IDDocto;0;0;'.$documento.';'.$documento.';DatDocumentos.Documento';
  #1==DAÑOS;2==Vehiculos;3==Accidentes y Enfermedades;4==Vida;5==Fianzas
$condicion=' Documento;2;0;3|4;3|4;DatDocumentos.IDRamo';
  break;
    case 'danios':
$condicion=' Documento;2;0;1;1;DatDocumentos.IDRamo';
  break;
    case 'vehiculos':
$condicion=' Documento;2;0;2;2;DatDocumentos.IDRamo';
  break;

case 'todos':
$condicion=' Documento;2;0;1|2;1|2;DatDocumentos.TipoDocto ';
  break;

  default:
  $vendedor=$this->CI->tank_auth->get_IDVend();
  $condicion=' Documento;2;0;1|2;1|2;DatDocumentos.TipoDocto  ! VendedorID;2;0;'.$vendedor.';'.$vendedor.';CatVendedores.IdVend';
    break;

}
return $condicion;
}

//----------------------------------
function newClients(){

  $datos['TipoEntidad']='0';
  $datos['TypeDestinoCDigital']='CONTACT';
  $datos['IDValuePK']='0';
  $datos['ActionCDigital']='GETFiles';
  $datos['TypeFormat']='XML';
  $datos['TProct']='Read_Data';
  $datos['KeyProcess']='REPORT';
  $datos['KeyCode']="H03665";
  $datos['Page']='1';
  $datos['ItemForPage']='10000';
  $datos['InfoSort']='VCatClientes.IDCli';
  $datos['IDRelation']='0';
  $datos['ConditionsAdd']='
    Desde;3;0;01/01/2022|15/01/2022;01/01/2022|15/01/2022;-1;DatDocumentos.FDesde ! 
    group;2;0;12;12;DatDocumentos.IDGrupo ! 
    local;2;0;3;3;CatDespachos.IDDespacho ! 
    category;2;0;5;5;VCATSRAMOS.IDRAMO
  ';

  //"Desde|Hasta;3;0;".$fi."|".$ff.";".$fi."|".$ff.";0;-1;-1;DatDocumentos.FDesde ! Estado;2;0;0;0;DatDocumentos.Status ! DocPoliza;2;1;2;Polizas;-1;-1;DatDocumentos.TipoDocto";

  $respuesta=$this->getDatosSICAS($datos);
 return $respuesta;
}
//----------------------------------
public function buscarDocumentoDetalle($condiciones='',$placa='',$serie='')
{
  //$idDocto='2T1BU42E49C086672';
  $condicion='';
  if($placa!='')
  {
    $condicion='Documento;0;0;'.$placa.';'.$placa.';VDatDoctoDetail.Placas ! Estatus;0;0;0;Vigente;-1;-1;VDatDocumentos.Status';
  }
  if($serie!='')
  {
    $condicion='Documento;0;0;'.$serie.';'.$serie.';VDatDoctoDetail.Serie ! Estatus;0;0;0;Vigente;-1;-1;VDatDocumentos.Status';

  }
  
        $datos['TipoEntidad']='0';
        $datos['TypeDestinoCDigital']='CONTACT';
        $datos['IDValuePK']='0';
        $datos['ActionCDigital']='GETFiles';
        $datos['TypeFormat']='XML';
        $datos['TProct']='Read_Data';
        $datos['KeyProcess']='REPORT';
        $datos['KeyCode']='HWS_DDETAIL';
        $datos['Page']='1';
        $datos['ItemForPage']='100';
        $datos['InfoSort']='VDatDocumentos.IDDocto';
        $datos['IDRelation']='0';
        $datos['ConditionsAdd']=$condicion;
        //$datos['InfoSort']='VDatDocumentos.IDDocto';//H03430_003
    //$datos['InfoSort']='VDatDocumentos.IDDocto';//H03400
    //$datos['InfoSort']='VDatDocumentos.IDDocto';//H02790
    //$datos['InfoSort']='VDatDocumentos.IDDocto';//HDS00007 
        $respuesta=$this->getDatosSICAS($datos);
  //$fp = fopen('resultadoJason.txt', 'a');fwrite($fp, print_r($respuesta,TRUE));fclose($fp);
        return $respuesta;

}
//---------------------------------- //Dennis Castillo [2022-05-19]
function obtenerClientesPorFecha($param){

  $datos['TipoEntidad']='0';
  $datos['TypeDestinoCDigital']='CONTACT';
  $datos['IDValuePK']='0';
  $datos['ActionCDigital']='GETFiles';
  $datos['TypeFormat']='XML';
  $datos['TProct']='Read_Data';
  $datos['KeyProcess']='REPORT';
  $datos['KeyCode']="HDS00002";
  $datos['Page']='1';
  $datos['ItemForPage']='10000';
  $datos['InfoSort']='VCatClientes.IDCli';
  $datos['IDRelation']='0';
  //$datos['ConditionsAdd'] = 'Desde|Hasta;3;0;01-05-2022|13-05-2022;01-05-2022|13-05-2022;0;-1;VCatClientes.FechaCap';
  $condition = array();

  foreach($param as $key => $dp){

    if(is_array($dp) && isset($param[$key]) && !empty($dp)){

      $end = end($dp);
      $newParams = $this->getExtrasFilters($key, $param);
      $value = count($dp) > 1 ? implode("|", $dp) : $dp[0];
     
      if(!empty($newParams)){
        $condition[] = $key.";2;".$newParams["exception"].";".$value.";".$value.";".$newParams["field"];
      }
    }
  }

  $datos['ConditionsAdd']="Desde|Hasta;3;0;".$param["fechaInicial"]."|".$param["fechaFinal"].";".$param["fechaInicial"]."|".$param["fechaFinal"].";0;-1;VCatClientes.FechaCap"; //.implode(" ! ", $condition);
  $fp = fopen('resultadoJason.txt', 'a');fwrite($fp, print_r($datos['ConditionsAdd']."\n", TRUE));fclose($fp);
  $respuesta=$this->getDatosSICAS($datos);
  $fp = fopen('resultadoJason.txt', 'a');fwrite($fp, print_r($respuesta, TRUE));fclose($fp);
  return $respuesta;
}
//---------------------------------- //Dennis Castillo [2022-05-19]
function polizasEmitidasDeClientes($param){ //funcion que devuelve de Sicas las polizas emitidas (reportes/operaciones/polizas).

  $datos['TypeFormat']='XML';
  $datos['TProc']='Read_Data';
  $datos['KeyProcess']='REPORT';
  $datos['KeyCode']="H03400"; //|H03400_005
  $datos['Page']='1';
  $datos['ItemForPage']='10000';
  $datos['InfoSort']='VDatDocumentos.IDDocto'; //VDatDocumentos
  $condition = array();

  foreach($param as $key => $dp){

    if(is_array($dp) && isset($param[$key]) && !empty($dp)){

      $end = end($dp);
      $newParams = $this->getExtrasFilters($key, $param);
      $value = count($dp) > 1 ? implode("|", $dp) : $dp[0];
     
      if(!empty($newParams)){
        $condition[] = $key.";2;".$newParams["exception"].";".$value.";".$value.";".$newParams["field"];
      }
    }
  }

  $fp = fopen('resultadoJason.txt', 'a');fwrite($fp, print_r($condition, TRUE));fclose($fp);
  $datos['ConditionsAdd']="Desde|Hasta;3;0;".$param["fechaInicial"]."|".$param["fechaFinal"].";".$param["fechaInicial"]."|".$param["fechaFinal"].";0;-1;-1;VCatClientes.FechaCap ! DocPoliza;2;0;1;Polizas;-1;-1;DatDocumentos.TipoDocto ! ".implode(" ! ", $condition);
  //$fp = fopen('resultadoJason.txt', 'a');fwrite($fp, print_r("\n".$datos['ConditionsAdd'], TRUE));fclose($fp);
  $respuesta = $this->getDatosSICAS($datos);

  return $respuesta;
}
//---------------------------------- //Dennis Castillo [2022-05-19]
function polizasEmitidasDeClientesFianzas($param){

  $datos['TypeFormat']='XML';
  $datos['TProc']='Read_Data';
  $datos['KeyProcess']='REPORT';
  $datos['KeyCode']="H03605_002|H03605_003";
  $datos['Page']='1';
  $datos['ItemForPage']='1000';
  $datos['InfoSort']='VDatDocumentos.IDDocto';
  //$datos['ConditionsAdd']="Desde|Hasta;3;0;".$array["fechaInicial"]."|".$array["fechaFinal"].";0;-1;-1;VDatDocumentos.FEmision ! Estatus;0;0;0;Vigente;-1;-1;VDatDocumentos.Status "; //Desde|Hasta;3;0;1-12-2020|22-12-2020;1-12-2020|22-12-2020;0;-1;VDATDOCUMENTOS.FEmision ! 
  //------------------
  $condition = array();

  foreach($param as $key => $dp){

    if(is_array($dp) && isset($param[$key]) && !empty($dp)){

      $end = end($dp);
      $newParams = $this->getExtrasFilters($key, $param);
      $value = count($dp) > 1 ? implode("|", $dp) : $dp[0];
     
      if(!empty($newParams)){
        $condition[] = $key.";2;".$newParams["exception"].";".$value.";".$value.";".$newParams["field"];
      }
    }
  }

  //$fp = fopen('resultadoJason.txt', 'a');fwrite($fp, print_r($condition, TRUE));fclose($fp);
  $datos['ConditionsAdd'] = "Desde|Hasta;3;0;".$param["fechaInicial"]."|".$param["fechaFinal"].";0;-1;-1;VCatClientes.FechaCap ! Estatus;0;0;0;Vigente;-1;-1;VDatDocumentos.Status ! ".implode(" ! ", $condition);
  //$datos['ConditionsAdd']="Desde|Hasta;3;0;".$param["fechaInicial"]."|".$param["fechaFinal"].";".$param["fechaInicial"]."|".$param["fechaFinal"].";0;-1;-1;VCatClientes.FechaCap ! DocPoliza;2;0;1;Polizas;-1;-1;DatDocumentos.TipoDocto ! ".implode(" ! ", $condition);
  $respuesta = $this->getDatosSICAS($datos);
  return $respuesta;
  //------------------
  //$condicionTotal="";
  //$condicionFecha="Desde|Hasta;3;0;".$array["fechaInicial"]."|".$array["fechaFinal"].";0;-1;-1;VDatDocumentos.FEmision ! Estatus;0;0;0;Vigente;-1;-1;VDatDocumentos.Status ! ";
}
//---------------------------------- //Dennis Castillo [2022-05-19]
function getExtrasFilters($case, $data){
  
  $value = array();
  switch($case){
    case "filtroDespacho":
      $value["exception"] = $data["excepcionDespacho"];
      $value["field"] = "DatDocumentos.IDDespacho";
      break;
    case "filtroRamo":
      $value["exception"] = $data["excepcionRamos"];
      $value["field"] = "DatDocumentos.IDRamo";
      break;
    case "filtroGrupo":
      $value["exception"] = $data["excepcionGrupo"];
      $value["field"] = "DatDocumentos.IDGrupo";
      break;
    case "filtroGerencia":
      $value["exception"] = $data["excepcionCanales"];
      $value["field"] = "DatDocumentos.IDGerencia";
      break;
    case "filtroVendedor":
      $value["exception"] = $data["excepcionVendedor"];
      $value["field"] = "DatDocumentos.IDVEND";
      break;
    case "filtroStatus":
      $value["exception"] = 0;
      $value["field"] = "VDatDocumentos.Status";
      break;
  } //filtroStatus

  return $value;
}
//------------------------------------
public function rfcClienteObtener($rfc)
{
  /*======BUSCAR AL CLIENTE EN SICAS=======*/
  /*$IDClI=ES EL ID DEL CLIENTE EN SICAS EL CUAL DEBE SER UN ENTERO(1,2,3,5..)*/

    $datos['TipoEntidad']='0';
    $datos['TypeDestinoCDigital']='CONTACT';
    $datos['IDValuePK']='0';
    $datos['ActionCDigital']='GETFiles';
    $datos['TypeFormat']='XML';
    $datos['TProct']='Read_Data';
    $datos['KeyProcess']='REPORT';
    $datos['KeyCode']='HDS00002';
    $datos['Page']='1';
    $datos['ItemForPage']='2000';
    $datos['InfoSort']='CatClientes.IDCli';
    $datos['IDRelation']='0';
    $datos['ConditionsAdd']='IDCli;2;0;'.$rfc.';'.$rfc.';CatClientes.rfc';
         
   // $respuesta=$this->obtenerDatos($datos);
   $respuesta = $this->getDatosSICAS($datos);
     
    return $respuesta;
}








}
