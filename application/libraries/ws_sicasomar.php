<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
//** require('KLogger/vendor/autoload.php');

class ws_sicasomar
{
	var $uri_service = URL_TICC_SICAS.'sicas/addData';
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
	var $host = 'www.sicasonline.info:448';
	var $numeroPagina=1;
	var $tableInfo=array();
	var 	$DeleteXml = array('<?xml version="1.0" encoding="utf-8"?>','<soap:Envelope xmlns:soap="http://schemas.xmlsoap.org/soap/envelope/" xmlns:xsi="http://www.w3.org/2001/XMLSchema-instance" xmlns:xsd="http://www.w3.org/2001/XMLSchema">','<DATAINFO> ','<soap:Envelope xmlns:soap="http://www.w3.org/2003/05/soap-envelope" xmlns:xsi="http://www.w3.org/2001/XMLSchema-instance" xmlns:xsd="http://www.w3.org/2001/XMLSchema"><soap:Body>','<ProcesarWSResponse xmlns="http://tempuri.org/">','<ProcesarWSResult>','</ProcesarWSResult>','</ProcesarWSResponse>','</soap:Envelope>','</DATAINFO> ','</soap:Body>','</DATAINFO> ',);
	var $ClearXml = array('','','','','','','','','','','','',);

	//------------------------------------------------------------------------------------------------------------------------
function __construct()
{
/*	
	$this->CI=& get_instance();
	$this->logger = new Katzgrau\KLogger\Logger(__DIR__.'/logs');
	try {
		$this->CI =& get_instance();
		$this->soapC = new SoapClient($this->uri_service, array('trace' => 1));	
		set_time_limit(900);
		} catch (Exception $e) {
			
		}
*/		
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
//-------------------------------------------------------------------------------------------------
public function actualizarCliente($IDCli){

}


//--------------------------------------------------------------------------------------------------
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
$respuesta="";
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

public function actualizarContactoSicas(){

}
//----------------------------------------------------------------------------------------------------------------------------

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
 $datos['ConditionsAdd']='Recibos;0;0;1;Pagados;1;-1;DatHonRecibos.Pagado ! FPago;3;0;'.$fechaInicial.'|'.$fechaFinal.';0;-1;DatHonDocto.FPago ! VendedorID;2;0;'.$IDVend.';0;DatHonRecibos.IDVE' ;



          //$datos['ConditionsAdd']='Desde|Hasta|Fecha de Pago;2;0;'.$fechaInicial.'|'.$fechaFinal.';'.$fechaInicial.'|'.$fechaFinal.';0;-1;DatHonDocto.FPago ! VendedorID;2;0;'.$IDVend.';0;DatHonRecibos.IDVE' ;


    //$respuestaSicas=$this->obtenerDatos($datos);

      $respuesta=$this->getDatosSICAS($datos);

    return $respuesta;

  }

//-------------------------------------------------------------------------------------------------

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

   // $respuesta=$this->obtenerDatos($datos);
     
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
       $datos['KeyCode']='H03430_001';
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
public function obtenerRecibosPorDocumento($Documento){
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

           $datos['ConditionsAdd']='Documento;2;0;'.$Documento.';'.$Documento.';DatDocumentos.Documento  ';
    


 $respuesta=$this->getDatosSICAS($datos);
 return $respuesta;


}
//-------------------------------------------------------------------------------------------------

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
         $datos['ConditionsAdd']='Documento;2;0;1|2;1|2;DatDocumentos.TipoDocto !  Status;0;'.$statusRecibo.';'.$statusRecibo.';0;VDatRecibos.Status !  Nombre Completo;0;0;*'.$nombreCLiente.'*;*'.$nombreCLiente.'*;0;-1;CatClientes.NombreCompleto';
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
//----------------------------------------------------------------------------------------------------------------------------
public function obtenerReporteCobranza($vendedor,$fechaI,$fechaF,$tipoCobranza){
/*ESTOS SON REPORTES DE COBRANZA
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
//----------------------------------------------------------------------------------------------------------------------------
public function cobranzareporte($array){
/*ESTOS SON REPORTES DE COBRANZA
$tipoCobranza=  ES EL TIPO DE COBRANZA QUE SE QUIERE OBTENER 0(COBRANZA PENDIENTE),1(COBRANZA CANCELADA),3(COBRANZA EFECTUADA)
$array['tipoFecha'] FDesde,FHasta,FLimPago*/
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
// 

 
   /*if(isset($array['tipoReporte'])){
      $tipoReporte=strtoupper($array['tipoReporte']);
    
      switch ($tipoReporte) 
      {
        case 'COBRANZAPENDIENTE':
                if($array['fechaInicial']!=null)
                {
                 //$datos['ConditionsAdd']='Desde|Hasta;3;0;'.$array['fechaInicial'].'|'.$array['fechaFinal'].';0;-1;VDatRecibos.FLimPago ! Documento;0;0;1;1;DatDocumentos.TipoDocto ! Status;0;0;0;0;VDatRecibos.Status   ! VendedorID;2;0;'.$array['vendedor'].';'.$array['vendedor'].';CatVendedores.IdVend';
               $datos['ConditionsAdd']='Desde|Hasta;3;0;'.$array['fechaInicial'].'|'.$array['fechaFinal'].';0;-1;VDatRecibos.'.$array['tipoFecha'].' ! Documento;0;1;1;1;DatDocumentos.TipoDocto ! Status;0;0;0;0;VDatRecibos.Status   ! VendedorID;2;0;'.$array['vendedor'].';'.$array['vendedor'].';CatVendedores.IdVend';
       }
       else{
       $datos['ConditionsAdd']=' Documento;0;0;1;1;DatDocumentos.TipoDocto ! Status;0;0;0;0;VDatRecibos.Status   ! VendedorID;2;0;'.$vendedor.';'.$vendedor.';CatVendedores.IdVend';
       }
          break;
        
        default:
          # code...
          break;
      }
  }*/

 /* switch ($tipoCobranza) {
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
       $datos['ConditionsAdd']='Desde|Hasta;3;0;'.$fechaI.'|'.$fechaF.';0;-1;VDatRecibos.FLimPago ! Documento;0;0;1;1;DatDocumentos.TipoDocto ! Status;0;0;0;0;VDatRecibos.Status  ! VendedorID;2;0;1|2|3|4|5|6|7;1|2|3|4|5|6|7|;CatVendedores.IdVend';
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
  }*/
        
     
      $respuesta=$this->getDatosSICAS($datos);
      
 return $respuesta;
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
    $respuesta=$this->decodificaXML($respuesta);  
   return $respuesta;   
     }

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
       $url=URL_TICC_SICAS.'sicas/addData';
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
function renovacionPoliza($array){

  $respuesta="";
/*if(isset($array['IDDoctoSoure'])){

      $encriptado='<InfoData><DatTareas>';
    foreach($array as $key => $value){  $encriptado=$encriptado.'<'.$key.'>'.$value.'</'.$key.'>';   }
     $encriptado=$encriptado.'</DatTareas></InfoData>';

     $encriptado=$this->encripta($encriptado);
    $respuesta=$this->grabarActualizasDatos('wsRenovaciond',$encriptado);       
    $respuesta=$this->decodificaXML($respuesta); 
  
   return $respuesta;     
  }*/        
 // $servicio='http://localhost/V3API/sicas/addData';
  //$servicion=new $servicio;//$this->uri_service;
  /*$datos['TipoEntidad']='0';
  $datos['TypeDestinoCDigital']='CONTACT';
  $datos['IDValuePK']='0';
  $datos['ActionCDigital']='GETFiles';
  $datos['TypeFormat']='XML';
  $datos['TProct']='Read_Data';
  $datos['KeyProcess']='REPORT';
  $datos['KeyCode']='wsRenovacionnn';
  $datos['Page']='1';
  $datos['ItemForPage']='10000000';
  $datos['InfoSort']='VDatDocumentos.IDDocto';
  $datos['IDRelation']='0';
//  $datos['ConditionsAdd']='Documento;2;0;'.$id.';'.$id.';DatDocumentos.Documento  '; */
//  $WSSICAS = new $this->soapC;

 //$respuesta=$this->getDatosSICAS($datos);

}
//-------------------------------------------------------------------------------------------------
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
//------------------------------------------------------------------------------------------------
public function obtenerRenovacionesFecha($vendedor,$fechaI,$fechaF){    
/*ESTE WEBSERVER SE EMPLEA PARA OBTENER LAS RENOVACIONES*/ 	
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

   // $vendedor=$this->tank_auth->get_IDVend();
    if($vendedor>0)
    {
       $datos['ConditionsAdd']='
       Desde|Hasta;3;0;'.$fechaI.'|'.$fechaF.';0;-1;DatDocumentos.FHasta ! Tipo Documento;0;0;1;1;DatDocumentos.TipoDocto! VendedorID;2;0;'.$vendedor.';'.$vendedor.';CatVendedores.IdVend';
    }
    else{
       $datos['ConditionsAdd']='
       Desde|Hasta;3;0;'.$fechaI.'|'.$fechaF.';0;-1;DatDocumentos.FHasta ! Tipo Documento;0;0;1;1;DatDocumentos.TipoDocto';       
    }
    $respuesta=$this->getDatosSICAS($datos);
         
 return $respuesta;

}
//-------------------------------------------------------------------------------------------------
	public function GetCDDigital($data){

   
		if(is_array($data)){			
			$IDDocto 	= $data["IDDocto"];			
			$data_body = array(
				//"Page" => 1,
				//"ItemForPage" => "",
				"ConditionsAdd" => "",
				"InfoSort"=>"",
				"KeyCode"=>"",
				"KeyProcess"=> "CDIGITAL",
				"TypeDestinoCDigital"=> "DOCUMENT",
				//"IDValuePK"=> $IDDocto,
				"ActionCDigital"=> "GETFiles"
			);
       $datos['TipoEntidad']='0';
       $datos['TypeDestinoCDigital']='DOCUMENT';
       $datos['IDValuePK']=$IDDocto;
       $datos['ActionCDigital']='GETFiles';
       $datos['TypeFormat']='XML';
       $datos['TProct']='Read_Data';
       $datos['KeyProcess']='CDIGITAL';
      // $datos['KeyCode']='HWS_DOCTOS';
       $datos['Page']='1';
       $datos['ItemForPage']='10000000';
       //$datos['InfoSort']='VDatDocumentos.FHasta';
       //$datos['IDRelation']='0';

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
//-------------------------------------------------------------------------------------------------
public function GetCDDigitalCliente($data){
   
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
            curl_setopt($ch, CURLOPT_URL, 'http://localhost/V3API/sicas/addData');
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
            curl_setopt($ch, CURLOPT_URL, 'http://localhost/V3API/sicas/addData');
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
  function getDatosSICAS($body, $header = null, $url = "", $format = "XML")
  {

    $xml = '<ProcesarWS><oDataWS>';
    foreach ($body as $key => $value) {
      $xml = $xml . '<' . $key . '>' . $value . '</' . $key . '>';
    }
    $xml = $xml . '</oDataWS></ProcesarWS>';



    $urlSite = 'http://localhost/V3API/sicas/addData';
    //$urlSite = 'http://tic.sicasapi.capsys.site/sicas/addData';
    $Fiedls = array("data" => $xml);
    $httpHeader = array();
    $headers = array("Content-Type: application/json; charset=utf-8");
    $curl = curl_init();
    curl_setopt_array($curl, array(
      CURLOPT_URL => $urlSite,
      CURLOPT_RETURNTRANSFER => true,
      CURLOPT_ENCODING => "",
      CURLOPT_MAXREDIRS => 10,
      CURLOPT_TIMEOUT => 120,
      CURLOPT_CONNECTTIMEOUT => 120,
      CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
      CURLOPT_CUSTOMREQUEST => "POST",
      CURLOPT_POSTFIELDS => json_encode($Fiedls),
      CURLOPT_HTTPHEADER => $headers
    ));

    $response = curl_exec($curl);
    $err = curl_error($curl);
    curl_close($curl);
    if ($err) {
      $obj["code"] = 400;
      $obj["error"] = $err;
      return json_encode($obj);
    } else {
      //echo $response;
      $decoded_response = json_decode($response);
      if ($format === "JSON") {
        return $decoded_response;
      }
      $decoded_response2 = json_decode($response, true);
      $returnedResponse = $this->convertResponse($decoded_response2);
      return $returnedResponse;
    }
  }
//-------------------------------------------------------------------------------------------------
private function obtenerDatos2($wsdata){
  $format="XML";
  $xml = '<ProcesarWS><oDataWS>';
  foreach ($wsdata as $key => $value) {
    $xml = $xml . '<' . $key . '>' . $value . '</' . $key . '>';
  }
  $xml = $xml . '</oDataWS></ProcesarWS>';



  $urlSite = 'http://localhost/V3API/sicas/addData';
  //$urlSite = 'http://tic.sicasapi.capsys.site/sicas/addData';
  $Fiedls = array("data" => $xml);
  $httpHeader = array();
  $headers = array("Content-Type: application/json; charset=utf-8");
  $curl = curl_init();
  curl_setopt_array($curl, array(
    CURLOPT_URL => $urlSite,
    CURLOPT_RETURNTRANSFER => true,
    CURLOPT_ENCODING => "",
    CURLOPT_MAXREDIRS => 10,
    CURLOPT_TIMEOUT => 120,
    CURLOPT_CONNECTTIMEOUT => 120,
    CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
    CURLOPT_CUSTOMREQUEST => "POST",
    CURLOPT_POSTFIELDS => json_encode($Fiedls),
    CURLOPT_HTTPHEADER => $headers
  ));

  $response = curl_exec($curl);
  $err = curl_error($curl);
  curl_close($curl);
  if ($err) {
    $obj["code"] = 400;
    $obj["error"] = $err;
    return json_encode($obj);
  } else {
    //echo $response;
    $decoded_response = json_decode($response);
    if ($format === "JSON") {
      return $decoded_response;
    }
    $decoded_response2 = json_decode($response, true);
    $returnedResponse = $this->convertResponse($decoded_response2);
    return $returnedResponse;
  }

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
	 

				$asArray=(array)$parameters;
				$this->CI->load->library('Ws_sicas'); 
				$resutl=$this->CI->ws_sicas->getDatosSICAS($asArray["oDataWS"]);
        return $resutl;
			} catch (Exception $e) {
        
				//return $resutl;
			
			}
		}
	}


  public function ConvertArrayToXML($array)
	{
		$xml = '';
		$arraykeys = array_keys($array);

		foreach ($arraykeys as $k => $val) {
			if (is_array($array[$val])) {
				$xml.="<{$val}>";
				$xml.= $this->ConvertArrayToXML($array[$val]);
				$xml.="</{$val}>";
			} else {
				$xml .= "<{$val}>" . $array[$val] . "</{$val}>";
			}
		}
		return $xml;
	}
//-----------------------------------------------------------------------------------------------------------------------------
private function CrearArbol($Arbol, $Nodo = 0){
				
		$isFolder 	= false;$text		= "";$level		= "";$href		= "";$hreftarget	= "";$level_int 		= 0;		
		foreach ($Arbol as $key => $value) {						
			if((string)$value->Level == 0){				
				unset($Arbol[$key]);				
				if($value->Tipo == 0){					
					$isFolder = true;
					$text = (string)$value->NameShow;
					$level = (string)$value->Level;
												
				}else{
					
					$isFolder = false;
					$text = (string)$value->NameShow;
					$href = (string)$value->PathWWW;
					$hrefTarget = "_blank";
					$level = (string)$value->Level;
									
				}
			
					$recursive = $this->Hijos($Arbol);
						
					$return["isFolder"] = $isFolder;
					$return["text"] = $text;
					if(!empty($href))
						$return["href"] = $href;
					if(!empty($hrefTarget))
						$return["hrefTarget"] = $hrefTarget;
					if(!empty($level))
						$return["level"] = $level;

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
				array("isFolder" => true,"text" => (string)$value->NameShow,"level" => (string)$value->Level);											
			}else{				
				$return  = array("isFolder" => false,"text" => (string)$value->NameShow,"href" => (string)$value->PathWWW,"hrefTarget" => "_blank","level" => (string)$value->Level);}
			array_push($hijos,$return);
		}
		return empty($hijos) ? null : $hijos; 
	}
  //--------------------------------------
  function grabarBorrarDatos($keyCode, $valores)
  {
    $format="XML";
    $xml = '<ProcesarWS><oDataWS><Credentials>';
    $xml = $xml . '<TypeFormat>JSON</TypeFormat>';
    $xml = $xml . '<KeyProcess>DATA</KeyProcess>';
    $xml = $xml . '<KeyCode>' . $keyCode . '</KeyCode>';
    $xml = $xml . '<TProc>Del_Data</TProc>';
    $xml = $xml . '<DataXML>' . $valores . '</DataXML>';
    $xml = $xml . '</oDataWS></ProcesarWS></soap:Body></soap:Envelope>';

    $urlSite = 'http://localhost/V3API/sicas/addData';
    //$urlSite = 'http://tic.sicasapi.capsys.site/sicas/addData';
    $Fiedls = array("data" => $xml);
    $httpHeader = array();
    $headers = array("Content-Type: application/json; charset=utf-8");
    $curl = curl_init();
    curl_setopt_array($curl, array(
      CURLOPT_URL => $urlSite,
      CURLOPT_RETURNTRANSFER => true,
      CURLOPT_ENCODING => "",
      CURLOPT_MAXREDIRS => 10,
      CURLOPT_TIMEOUT => 120,
      CURLOPT_CONNECTTIMEOUT => 120,
      CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
      CURLOPT_CUSTOMREQUEST => "POST",
      CURLOPT_POSTFIELDS => json_encode($Fiedls),
      CURLOPT_HTTPHEADER => $headers
    ));

    $response = curl_exec($curl);
    $err = curl_error($curl);
    curl_close($curl);
    if ($err) {
      $obj["code"] = 400;
      $obj["error"] = $err;
      return json_encode($obj);
    } else {
      //echo $response;
      $decoded_response = json_decode($response);
      if ($format === "JSON") {
        return $decoded_response;
      }
      $decoded_response2 = json_decode($response, true);
      $returnedResponse = $this->convertResponse($decoded_response2);
      return $returnedResponse;
    }

}
//--------------------------------------
private function grabarActualizasDatos($keyCode,$valores){
    $format="XML";
    $xml = '<ProcesarWS><oDataWS>';
    $xml = $xml . '<TypeFormat>JSON</TypeFormat>';
    $xml = $xml . '<KeyProcess>DATA</KeyProcess>';
    $xml = $xml . '<KeyCode>' . $keyCode . '</KeyCode>';
    $xml = $xml . '<TProc>Save_Data</TProc>';
    $xml = $xml . '<DataXML>' . $valores . '</DataXML>';
    $xml = $xml . '</oDataWS></ProcesarWS></soap:Body></soap:Envelope>';
    $headers = array("Content-Type: application/json; charset=utf-8");
    $Fiedls = array("data" => $xml);

    $urlSite = 'http://localhost/V3API/sicas/addData';
    $curl = curl_init();
    curl_setopt_array($curl, array(
      CURLOPT_URL => $urlSite,
      CURLOPT_RETURNTRANSFER => true,
      CURLOPT_ENCODING => "",
      CURLOPT_MAXREDIRS => 10,
      CURLOPT_TIMEOUT => 120,
      CURLOPT_CONNECTTIMEOUT => 120,
      CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
      CURLOPT_CUSTOMREQUEST => "POST",
      CURLOPT_POSTFIELDS => json_encode($Fiedls),
      CURLOPT_HTTPHEADER => $headers
    ));

    $response = curl_exec($curl);
    $err = curl_error($curl);
    curl_close($curl);
    if ($err) {
      $obj["code"] = 400;
      $obj["error"] = $err;
      return json_encode($obj);
    } else {
      //echo $response;
      $decoded_response = json_decode($response);
      if ($format === "JSON") {
        return $decoded_response;
      }
      $decoded_response2 = json_decode($response, true);
      $returnedResponse = $this->convertResponse($decoded_response2);
      return $returnedResponse;
    }
}


function convertResponse($respuesta)
{
    $xml = "<DATAINFO>";
    $Type = gettype($respuesta["TableInfo"]);
    if (is_array($respuesta["TableInfo"])) {
        foreach ($respuesta["TableInfo"] as $key => $value) {
            $arraykeys = array_keys($value);
            $test=count($arraykeys);
            if($arraykeys==0 || isset($respuesta["TableInfo"]["DATAINFO"])){
                $arraykeys = array_keys($value[0]);
                $value=$value[0];
            }
            $xml .= "<TableInfo>";
            foreach ($arraykeys as $k => $val) {
                $xml .= "<{$val}>" . $value[$val] . "</{$val}>";
            }
            $xml .= "</TableInfo>";
        }
        if (count($respuesta["TableInfo"]) == 0) {
            $xml .= "<TableInfo>";
            $xml .= "</TableInfo>";
        }
    } else {
        $arraykeys = array_keys($respuesta["TableInfo"]);
        $xml .= "<TableInfo>";
        foreach ($arraykeys as $k => $val) {
            $xml .= "<{$val}>" . $respuesta["TableInfo"][$val] . "</{$val}>";
        }
        $xml .= "</TableInfo>";
    }

    //Ponemos los datos del table control
    $arraykeys = array_keys($respuesta["TableControl"]);
    $xml .= "<TableControl>";
    foreach ($arraykeys as $k => $val) {
        $xml .= "<{$val}>" . $respuesta["TableControl"][$val] . "</{$val}>";
    }
    $xml .= "</TableControl>";
    //$xml .= "<Sucess>True</Sucess>";
    $xml .= "</DATAINFO>";
    $text = preg_replace('/&(?!#?[a-z0-9]+;)/', '', $xml);
    //$text=preg_replace('/&(?!#?[a-z0-9]+;)/', '', $text);
    //$text= preg_replace("/(^[\r\n]*|[\r\n]+)[\s\t]*[\r\n]+/", "\n", $text);
    $text=str_replace(' & ', '', html_entity_decode((htmlspecialchars_decode($text))));
    //echo $text;
    //$resXmlConsumo = str_replace($this->DeleteXml, $this->ClearXml, $xml);
    $resXmlConsumo = str_replace($this->DeleteXml, $this->ClearXml, $text);
    $convert = htmlspecialchars_decode($resXmlConsumo);
    $Responde = simplexml_load_string($convert);

    return $Responde;
}


//-----------------------------------------------------------------------------------------------------------------------------

function recibosClientes($array)
{
/*ESTOS SON REPORTES DE cobranza
$tipoCobranza=  ES EL TIPO DE COBRANZA QUE SE QUIERE OBTENER 0(COBRANZA PENDIENTE),1(COBRANZA CANCELADA),3(COBRANZA EFECTUADA)
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
$filtroTipoFechaValores="";
$filtroTipoFecha="";
if(isset($array['filtroGrupo']))
{
  foreach ($array['filtroGrupo'] as  $value) 
  {
   if ($value === end($array['filtroGrupo'])) { $filtroGrupoValores.=$value;}
   else{$filtroGrupoValores.=$value.'|';}

  }
  if($filtroGrupoValores!=""){$filtroGrupo='grupo;2;0;'.$filtroGrupoValores.';'.$filtroGrupoValores.';DatDocumentos.IDGrupo ! ';}
}


if(isset($array['filtroDespacho']))
{
  foreach ($array['filtroDespacho'] as  $value) 
  {
   if ($value === end($array['filtroDespacho'])) { $filtroDespachoValores.=$value;}
  else{$filtroDespachoValores.=$value.'|';}

  }
  if($filtroDespachoValores!=""){$filtroDespacho='Despacho;2;0;'.$filtroDespachoValores.';'.$filtroDespachoValores.';DatDocumentos.IDDespacho ! ';}
}


if(isset($array['filtroGerencia']))
{
  foreach ($array['filtroGerencia'] as  $value) 
  {
   if ($value === end($array['filtroGerencia'])) { $filtroGerenciaValores.=$value;}
  else{$filtroGerenciaValores.=$value.'|';}

  }
  if($filtroGerenciaValores!=""){$filtroGerencia='gerencia;2;0;'.$filtroGerenciaValores.';'.$filtroGerenciaValores.';DatDocumentos.IDGerencia ! ';}
}


if(isset($array['filtroRamo']))
{
  foreach ($array['filtroRamo'] as  $value) 
  {
   if ($value === end($array['filtroRamo'])) { $filtroRamoValores.=$value;}
  else{$filtroRamoValores.=$value.'|';}

  }
  if($filtroRamoValores!=""){$filtroRamo='Ramo;2;0;'.$filtroRamoValores.';'.$filtroRamoValores.';DatDocumentos.IDRamo ! ';}
}


/*if(isset($array['tipoFecha']))
{
  foreach ($array['tipoFecha'] as  $value) 
  {
   if ($value === end($array['tipoFecha'])) { $filtroTipoFechaValores.=$value;}
  else{$filtroTipoFechaValores.=$value.'|';}

  }
  if($filtroTipoFechaValores!=""){$filtroTipoFecha='Ramo;2;0;'.$filtroTipoFechaValores.';'.$filtroTipoFechaValores.';DatDocumentos.IDRamo ! ';}
}*/



$filtrosGenerales='Desde|Hasta;3;0;'.$array['fechaInicial'].'|'.$array['fechaFinal'].';0;-1;VDatRecibos.'.$array['tipoFecha'].' ! ';
$condicion=$filtrosGenerales.$filtroGrupo.$filtroDespacho.$filtroGerencia.$filtroRamo;
$datos['ConditionsAdd']=trim($condicion,'! ');


//$datos['ConditionsAdd']='Desde|Hasta;3;0;'.$array['fechaInicial'].'|'.$array['fechaFinal'].';0;-1;VDatRecibos.'.$array['tipoFecha'].' ! Ramo;2;0;5;5;DatDocumentos.IDRamo';

//despacho;2;0;2|7;2|7;

/* $datos['ConditionsAdd']='Desde|Hasta;3;0;'.$array['fechaInicial'].'|'.$array['fechaFinal'].';0;-1;VDatRecibos.'.$array['tipoFecha'].' ! Documento;0;1;1;1;DatDocumentos.TipoDocto  ! despacho;2;0;2|7;2|7;DatDocumentos.IDDespacho ! gerencia;0;9;9;1;DatDocumentos.IDGerencia ! grupo;1;0;12;0;1;DatDocumentos.IDGrupo';*/
//$fp = fopen('resultadoJason.txt', 'a');fwrite($fp, print_r($condicion,TRUE));fclose($fp);  


     $respuesta=$this->getDatosSICAS($datos);
     $fp = fopen('resultadoJason.txt', 'a');fwrite($fp, print_r($respuesta,TRUE));fclose($fp); 
     return $respuesta;
    
 
}
//-----------------------------------------------




}