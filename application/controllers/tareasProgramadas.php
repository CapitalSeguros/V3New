<?php if (!defined('BASEPATH')) exit('No direct script access allowed');
//require_once __DIR__.'dompdf/autoload.inc.php';
//use Dompdf\Dompdf;
//require_once(dirname(__FILE__) . '\dompdf\autoload.inc');

class tareasProgramadas extends CI_Controller{
//------------------------------------------------------------------------------------------------------------------------------------------
		function __construct(){
		parent::__construct();     
		$this->CI =& get_instance();
		
		$config['protocol'] = 'sendmail';
        $config['mailpath'] = '/usr/sbin/sendmail';
        $config['charset'] = 'iso-8859-1';
        $config['wordwrap'] = TRUE;
        $config['mailtype'] = 'html';
		$this->load->library('email',$config);
   // $this->load->library('Phpmailer_lib');
    
    //$this->load->library("WS_Sicas");  
		
		//$this->load->model('capsysdre_envioCorreos');
	}
//------------------------------------------------------------------------------------------------------------------------------------------
public function index(){

}
//------------------------------------------------------------------------------------------------------------------------------------------
public function envioCorreosEmbebido(){
  //$v3=$this->load->database('V3',true);
$this->load->library('PHPMailer_lib');
$mail = $this->phpmailer_lib->load();
       $mail->isSMTP();
       $mail->protocol='mail';
        $mail->Host     = 'mail.asesorescapital.com';
        $mail->SMTPAuth = true;
        $mail->Username = 'avisocapital@asesorescapital.com';
        $mail->Password = ';uthbsm?m0^$';
        $mail->SMTPSecure = 'tsl';
        $mail->Port     = 587;
        $mail->SMTPDebug = 2;

      //  $mail->From='avisocapital@asesorescapital.com';
  $mail->setFrom('avisocapital@asesorescapital.com','');
        //$mail->addReplyTo('info@example.com', 'Programacion.net');
       //$mail->addAddress('luceme_23@yahoo.com');
$mail->addAddress('desarrollo@agentecapital.com');
        
        // Add cc or bcc 
        //$mail->addCC('cc@example.com');
        //$mail->addBCC('bcc@example.com');
        
        // Email subject
        $mail->Subject = 'Send Email via SMTP using PHPMailer in CodeIgniter';
        
        // Set email format to HTML
        $mail->isHTML(true);
        
        // Email body content
        $mailContent = "<h1>Send HTML Email using SMTP in CodeIgniter</h1>
            <p>This is a test email sending using SMTP mail server with PHPMailer.</p>";
        $mail->Body = $mailContent;
       // Send email
        if(!$mail->send()){
            echo 'Message could not be sent.';
            echo 'Mailer Error: ' . $mail->ErrorInfo;
        }else{
            echo 'Message has been sent';
        }

    /*  if($correosPendientesEnviar != FALSE){
        $this->load->library('email');
        $config['protocol'] = 'smtp';
        $config['smtp_host'] = 'agentecapital.com';///usr/sbin/sendmail';
        //$config['smtp_host'] = 'asesorescapital.com';///usr/sbin/sendmail';
        //+$config['smtp_user'] = 'avisosgap@asesorescapital.com';
        //+$config['smtp_pass'] = 'avisosgap2018';
        $config['smtp_user'] = 'avisocapital@asesorescapital.com';
        $config['smtp_pass'] = ';uthbsm?m0^$';
        
        $config["smtp_port"] = '587';
         $config['charset'] = 'utf-8';
         $config['wordwrap'] = TRUE;
         $config['validate'] = true;
       $prueba= $this->email->initialize($config);     
//$fp = fopen('erroresEmail.txt', 'a');fwrite($fp, print_r($prueba,TRUE));fclose($fp);  
        for($i=0;$i<$cantidad;$i++){       
         $fromNombre = strstr($correosPendientesEnviar[$i]->desde, '<', true);
         $fromEmail = trim(substr(strstr($correosPendientesEnviar[$i]->desde, "<"), 1),'>');
               $this->email->from('avisosgap@asesorescapital.com',$fromNombre);
        $this->email->subject('Here is your info '. $fromNombre);
             $this->email->to($correosPendientesEnviar[$i]->para);
                 $this->email->subject($correosPendientesEnviar[$i]->asunto);
            $this->email->message($correosPendientesEnviar[$i]->mensaje);        
               if($this->email->send()){
 
               $actualizar="update envio_correos set status=1 where idCorreo=".$correosPendientesEnviar[$i]->idCorreo;
         $v3->query($actualizar);
  
         
        }
}
        }
      }
             $v3=$this->load->database('V3',false);*/

}

//-----------------------------------------------------------------------------------------------------------------------------------------
/*==== NOS DEVUELVE EL RANKING DE CADA AGENTE PARA ENVIO DE ESTADO FINANCIERO Y META COMERCIAL=============================================*/
private function traeAgentesParaEnvionMensual($filtro){
  /*A LOS PLATINUM NO SE LES ENVIA ESTADO FINANCIERO NI META COMERCIAL INSTITUCIONA QUE ES GAP*/
  $bandEF=0;
  $gastosOperacion=0;
  $consulta='select persona.idPersona,persona.IDVend,persona.nombres,persona.apellidoPaterno,persona.apellidoMaterno,users.email,catalog_canales.nombreTitulo from persona left join catalog_canales on catalog_canales.IdCanal=persona.id_catalog_canales left join users on users.idPersona=persona.idPersona ';
  $mes=date('m');
  $mes=$mes-1;  $anio=date('Y');
  if($mes==1){$mes=12;$anio=$anio-1;}
  $mes=1;$anio=2020;
  $consultaMC='select montoEAM,paraEAM from envioagentesmeta where anioEAM='.$anio.' and mesEAM='.$mes.' and paraEAM="';
  switch ($filtro) {
    /*BRONCE MERIDA*/
    case 0:$consulta=$consulta.'where persona.tipoPersona=3 and persona.id_catalog_sucursales=1 and persona.idpersonarankingagente="BRONCE" and persona.id_catalog_canales!=3 and (users.idTipoUser=15 || users.idTipoUser=17 || users.idTipoUser=18)';$bandEF=1;$consultaMC=$consultaMC.'M"';$gastosOperacion=2500;$leyenda="Como parte de nuestro compromiso en la administración de la cartera de nuestros agentes buscamos la rentabilidad de su negocio.";break;   
    /*BRONCE CANCUN*/
    case 1:$consulta=$consulta.'where persona.tipoPersona=3 and persona.id_catalog_sucursales=2 and persona.idpersonarankingagente="BRONCE" and persona.id_catalog_canales!=3 and  (users.idTipoUser=15 || users.idTipoUser=17 || users.idTipoUser=18)';$bandEF=1;$consultaMC=$consultaMC.'C"';$gastosOperacion=2500;$leyenda="Como parte de nuestro compromiso en la administración de la cartera de nuestros agentes buscamos la rentabilidad de su negocio.";break;
    /*BRONCE FIANZAS*/
    case 2:$consulta=$consulta.'where persona.tipoPersona=3 and persona.idpersonarankingagente="BRONCE" and persona.id_catalog_canales=3 and (users.idTipoUser=15 || users.idTipoUser=17 || users.idTipoUser=18)';$bandEF=1;$consultaMC=$consultaMC.'F"';$gastosOperacion=3000;$leyenda="Como parte de nuestro compromiso en la administración de la cartera de nuestros agentes buscamos la rentabilidad de su negocio."; ;break;
    /*ORO MERIDA*/
    case 3:$consulta=$consulta.'where persona.tipoPersona=3 and persona.id_catalog_sucursales=1 and (persona.idpersonarankingagente="ORO" || persona.idpersonarankingagente="PLATINO VIP") and persona.id_catalog_canales!=3 and (users.idTipoUser=15 || users.idTipoUser=17 || users.idTipoUser=18)';$consultaMC=$consultaMC.'M"';$gastosOperacion=2500;$leyenda="Como parte de nuestro compromiso en la administración de la cartera de nuestros agentes le ayudamos a lograr su meta comercial que le permita lograr un incremento de sus ingresos.";break;
    /*ORO CANCUN*/
    case 4:$consulta=$consulta.'where persona.tipoPersona=3 and persona.id_catalog_sucursales=2 and (persona.idpersonarankingagente="ORO" || persona.idpersonarankingagente="PLATINO VIP") and persona.id_catalog_canales!=3  and (users.idTipoUser=15 || users.idTipoUser=17 || users.idTipoUser=18)';$consultaMC=$consultaMC.'C"';$gastosOperacion=2500;$leyenda="Como parte de nuestro compromiso en la administración de la cartera de nuestros agentes le ayudamos a lograr su meta comercial que le permita lograr un incremento de sus ingresos.";break;
    /*ORO FIANZAS*/
    case 5:$consulta=$consulta.'where persona.tipoPersona=3 and (persona.idpersonarankingagente="ORO" || persona.idpersonarankingagente="PLATINO VIP") and persona.id_catalog_canales=3 and (users.idTipoUser=15 || users.idTipoUser=17 || users.idTipoUser=18)';$consultaMC=$consultaMC.'F"';$gastosOperacion=3000;$leyenda="Como parte de nuestro compromiso en la administración de la cartera de nuestros agentes le ayudamos a lograr su meta comercial que le permita lograr un incremento de sus ingresos.";break;
  }
      
    //$v3=$this->load->database('V3',true);
 
    $agentesEnvio['agentes']=$this->db->query($consulta)->result();
    $agentesEnvio['cabecera']=$this->db->query('select * from envioagentestabla where idEAT=1 order by orderEAT')->result();
    $agentesEnvio['metaComercial']=$this->db->query('select * from envioagentestabla where idEAT=3 order by orderEAT')->result();
    if($bandEF){$agentesEnvio['estadoFinanciero']=$this->db->query('select * from envioagentestabla where idEAT=2 order by orderEAT')->result();}
    $agentesEnvio['montoMeta']=$this->db->query($consultaMC)->result();
    $agentesEnvio['gastoOperacion']=$gastosOperacion;
    $agentesEnvio['leyenda']=$leyenda;
    //$v3=$this->load->database('V3',false);
           
    return $agentesEnvio;
}

//---------------------------

public function enviarAgentesBronceMensual(){
/*===FUNCION QUE SE DEBE EJECUTAR PRIMER DIA DEL MES A LAS 5 HORAS ENVIA META COMERCIAL Y ESTADO FINANCIERO A AGENTES  BRONCE ESTA FUNCION YA NO ESTA FUNCIONANDO======*/
    $agentesEnvio=$this->traeAgentesParaEnvionMensual(0);
    //$v3=$this->load->database('V3',true);    
    $mes=(date('m'));
    $mes=$mes-1;
    $anio=date('Y');
    if($mes==0){$mes=12;$anio=$anio-1;}
    $fechaInicial='01/'.$mes.'/'.$anio;
    $fechaFinal=$this->devuelveUltimoDiaMes().'/'.$mes.'/'.$anio;
    $contador=0;  
    $fechaInicial='01/01/2020';
    $fechaFinal='31/01/2020';
    $correo=1;
    if(isset($_GET['mes']) and isset($_GET['anio'])){$mes=$_GET['mes'];$anio=$_GET['anio'];}
    if(isset($_GET['correo'])){$correo=$_GET['correo'];}
    foreach ($agentesEnvio['agentes'] as $datos) 
    {
      $documento='';
      $arreglo=[':'.$datos->nombres.' '.$datos->apellidoPaterno,':'.$datos->nombreTitulo,':'.$anio,''];
      $sumaImporte=0;
      $sumaImporteNuevo=0;$montoMeta=0;$sumaImporteNuevo=0;$contribucion=0;
      //$respuesta=$this->ws_sicas->envioMensualAgentes($datos->IDVend,$fechaInicial,$fechaFinal); 
      $consulta='select * from honorarios where anio='.$anio.' and mes='.$mes.' and IDVe='.$datos->IDVend;
        $respuesta=$this->db->query($consulta)->result();  
      if((count($respuesta))>0){      
      $borrado='delete from envioagentesbitacora where mesEAB='.$mes.' and anioEAB='.$anio.' and IDVendEAB='.$datos->IDVend;
       $this->db->query($borrado);
      foreach($respuesta as $valores)
      {
        $sumaImporte=$sumaImporte+floatval($valores->ImporteP);
        if($valores->Renovacion==0){if($valores->Periodo==1){$sumaImporteNuevo=$sumaImporteNuevo+floatval($valores->ImporteP);}}
      }
      $ingresosTotales=round($sumaImporte,2);
      $costoVenta=round($ingresosTotales*.7,2);
      $contribucionMarginal=round(floatval($ingresosTotales)-floatval($costoVenta),2);
      $gastosOperacion=floatval($agentesEnvio['gastoOperacion']);
      $utilidad=$contribucionMarginal-$gastosOperacion;
      $arregloEF=['$'.$ingresosTotales,'$'.$costoVenta,'$'.$contribucionMarginal,'$'.$gastosOperacion,'$'.$utilidad,''];
       
      $documento=$this->devuelveCabeceraExcel($arreglo,$agentesEnvio['cabecera']);
      /*SI SE VA MANDAR EL ESTADO FINANCIERO*/
      if(isset($agentesEnvio['estadoFinanciero']))
      {
         $documento=$documento.$this->devuelveEstadoFinancieroExcel($agentesEnvio['estadoFinanciero'],$arregloEF,$mes);
      }
      $montoMeta=$agentesEnvio['montoMeta'][0]->montoEAM;
      if($sumaImporteNuevo==0){$contribucion=0;}
      else{$contribucion=round(((floatval($sumaImporteNuevo)/floatval($montoMeta))*100),2);}
      $arregloMC=['$'.$montoMeta,'$'.$sumaImporteNuevo,'%'.$contribucion];
      $documento=$documento.$this->devuelveMetaComercialExcel($agentesEnvio['metaComercial'],$arregloMC,$mes);
      //$documento=$documento.'<tr><td>'.$agentesEnvio['leyenda'].'</td></tr>';
      $documento=$documento.'</table>';
      $documento=$documento.'<label style="background-color: #4af74a">'.$agentesEnvio['leyenda'].'<label>';       
      $this->load->library('email');
      $config['protocol'] = 'smtp';
      $config['smtp_host'] = 'agentecapital.com';
      $config['smtp_user'] = 'avisosgap@asesorescapital.com';
      $config['smtp_pass'] = 'avisosgap2018';
      $config["smtp_port"] = '587';
      $config['charset'] = 'utf-8';
      $config['wordwrap'] = TRUE;
      $config['validate'] = true;
      $this->email->initialize($config); 
      $this->email->clear(true);
      $this->email->from('avisosgap@asesorescapital.com');
      $this->email->to($datos->email);
      //$this->email->to($correoE);
      $this->email->message("Estado financiero ".$documento);
      
      $insertar['IDVendEAB']=$datos->IDVend ;
      $insertar['mesEAB']=$mes ;
      $insertar['anioEAB']=$anio ;
      $insertar['ingresoTotalesEAB']=$ingresosTotales ;
      $insertar['costoVentaEAB']=$costoVenta ;
      $insertar['contribucionMarginalEAB']=$contribucionMarginal ;
      $insertar['gastoOperacionEAB']=$gastosOperacion ;
      $insertar['utilidadPerdidaEAB']=$utilidad ;
      $insertar['enviadoEAB']=0 ;
      $insertar['metaComercialEAB']=$montoMeta ;
      $insertar['comisionVentaEAB']=$sumaImporteNuevo ;
      $insertar['contribucionEAB']=$contribucion ;
       $contador=$contador+1;  
      /*-----------------SE DESHABILITO ESTE TIPO DE ENVIO---------*/
        //   if($this->email->send()){$insertar['enviadoEAB']=1 ;}
        $guardaMensaje['desde']="Avisos de GAP<avisosgap@aserorescpital.com>";
        $guardaMensaje['para']=$datos->email;
        $guardaMensaje['asunto']="Estado Financiero";
        $guardaMensaje['mensaje']=$documento;
        $guardaMensaje['status']=1;
         $guardaMensaje['identificaModulo']='honorarios'.$mes.$anio;
       if($correo==1){$this->db->insert('envio_correos',$guardaMensaje);}
       $this->db->insert('envioagentesbitacora',$insertar);
      }  
        //$v3->insert('envio_correos',$guardaMensaje);
        //$v3->insert('envioagentesbitacora',$insertar);
    }


}
//------------------------------------------------------------------------------------------------------------------------------------------
/*==FUNCION QUE SE DEBE EJECUTAR EL PRIMER DIA DEL MES A LAS 7 HORAS ENVIA META COMERCIAL Y ESTADO FINANCIERO A AGENTES DIFERENTES DE BRONCE==*/
public function enviarMensualAgentesTodos()
{
  //for($i=0;$i<6;$i++){
    $this->load->library("WS_Sicas"); 
    for($i=0;$i<6;$i++)
    {
    $agentesEnvio=$this->traeAgentesParaEnvionMensual($i);
    //$v3=$this->load->database('V3',true);
    // $v3=$this->load->database('default',true);
    $mes=(date('m'));
     $mes=$mes-1;      
    $anio=date('Y');
    $correo=1;
    if(isset($_GET['mes']) and isset($_GET['anio'])){$mes=$_GET['mes'];$anio=$_GET['anio'];}
    if(isset($_GET['correo'])){$correo=$_GET['correo'];}
     if($mes==0){$mes=12;$anio=$anio-1;}
    $fechaInicial='01/'.$mes.'/'.$anio;
    $fechaFinal=$this->devuelveUltimoDiaMes().'/'.$mes.'/'.$anio;
    $contador=0;  
    foreach ($agentesEnvio['agentes'] as $datos) 
    {
      $documento='';
      $arreglo=[':'.$datos->nombres.' '.$datos->apellidoPaterno,':'.$datos->nombreTitulo,':'.$anio,''];
      $sumaImporte=0;
      $sumaImporteNuevo=0;$montoMeta=0;$sumaImporteNuevo=0;$contribucion=0;
     // $respuesta=$this->ws_sicas->envioMensualAgentes($datos->IDVend,$fechaInicial,$fechaFinal); 
         // 
         $consulta='select * from honorarios where anio='.$anio.' and mes='.$mes.' and IDVe='.$datos->IDVend;
            $respuesta=$this->db->query($consulta)->result();
    
      $borrado='delete from envioagentesbitacora where mesEAB='.$mes.' and anioEAB='.$anio.' and IDVendEAB='.$datos->IDVend;
       $this->db->query($borrado);         
          if((count($respuesta))>0){          
    
      foreach($respuesta as $valores)
      {
        $sumaImporte=$sumaImporte+floatval($valores->ImporteP);
        if($valores->Renovacion==0)
        {
            if($valores->Periodo==1){$sumaImporteNuevo=$sumaImporteNuevo+floatval($valores->ImporteP);}
        }
      }
      $ingresosTotales=round($sumaImporte,2);
      $costoVenta=round($ingresosTotales*.7,2);
      $contribucionMarginal=round(floatval($ingresosTotales)-floatval($costoVenta),2);
      $gastosOperacion=floatval($agentesEnvio['gastoOperacion']);
      $utilidad=$contribucionMarginal-$gastosOperacion;
      $arregloEF=['$'.$ingresosTotales,'$'.$costoVenta,'$'.$contribucionMarginal,'$'.$gastosOperacion,'$'.$utilidad,''];
      
      $documento=$this->devuelveCabeceraExcel($arreglo,$agentesEnvio['cabecera']);
      /*SI SE VA MANDAR EL ESTADO FINANCIERO*/
      if(isset($agentesEnvio['estadoFinanciero']))
      {
         $documento=$documento.$this->devuelveEstadoFinancieroExcel($agentesEnvio['estadoFinanciero'],$arregloEF,$mes);
      }
      $montoMeta=$agentesEnvio['montoMeta'][0]->montoEAM;
      if($sumaImporteNuevo==0)
      {
        $contribucion=0;
      }
      else
      {
        $contribucion=round(((floatval($sumaImporteNuevo)/floatval($montoMeta))*100),2);
      }
      $arregloMC=['$'.$montoMeta,'$'.$sumaImporteNuevo,'%'.$contribucion];
      $documento=$documento.$this->devuelveMetaComercialExcel($agentesEnvio['metaComercial'],$arregloMC,$mes);
      //$documento=$documento.'<tr><td>'..'</td></tr>';
      $documento=$documento.'</table>';
      $documento=$documento.'<label style="background-color: #4af74a">'.$agentesEnvio['leyenda'].'<label>';
           
      $this->load->library('email');
      $config['protocol'] = 'smtp';
      $config['smtp_host'] = 'agentecapital.com';///usr/sbin/sendmail';
      $config['smtp_user'] = 'avisosgap@asesorescapital.com';
      $config['smtp_pass'] = 'avisosgap2018';
      $config["smtp_port"] = '587';
      $config['charset'] = 'utf-8';
      $config['wordwrap'] = TRUE;
      $config['validate'] = true;
      $this->email->initialize($config); 
      $this->email->clear(true);
      $this->email->from('avisosgap@asesorescapital.com');
        
      $this->email->to($datos->email);
      //$this->email->to($correoE);
      $this->email->message("Estado financiero".$documento);
       //
         
      $insertar['IDVendEAB']=$datos->IDVend ;
      $insertar['mesEAB']=$mes ;
      $insertar['anioEAB']=$anio ;
      $insertar['ingresoTotalesEAB']=$ingresosTotales ;
      $insertar['costoVentaEAB']=$costoVenta ;
      $insertar['contribucionMarginalEAB']=$contribucionMarginal ;
      $insertar['gastoOperacionEAB']=$gastosOperacion ;
      $insertar['utilidadPerdidaEAB']=$utilidad ;
      $insertar['enviadoEAB']=0 ;
      $insertar['metaComercialEAB']=$montoMeta ;
      $insertar['comisionVentaEAB']=$sumaImporteNuevo ;
      $insertar['contribucionEAB']=$contribucion ;
       $contador=$contador+1;  
      /*-----------------SE DESHABILITO ESTE TIPO DE ENVIO---------*/
        //  if($this->email->send()){$insertar['enviadoEAB']=1 ;}
            
        $guardaMensaje['desde']="Avisos de GAP<avisosgap@aserorescpital.com>";
        $guardaMensaje['para']=$datos->email;
        $guardaMensaje['asunto']="Estado Financiero";
        $guardaMensaje['mensaje']=$documento;
        $guardaMensaje['status']=1;
        $guardaMensaje['identificaModulo']='honorarios'.$mes.$anio;
              //$fp = fopen('excelEnviaMensual.txt', 'a');fwrite($fp, print_r($documento,TRUE));fclose($fp);   
        //$v3->insert('envio_correos',$guardaMensaje);
       //$v3->insert('envioagentesbitacora',$insertar);
       if($correo==1){$this->db->insert('envio_correos',$guardaMensaje);}
       $this->db->insert('envioagentesbitacora',$insertar);
      }
      else
      {
      $insertar['IDVendEAB']=$datos->IDVend ;
      $insertar['mesEAB']=$mes ;
      $insertar['anioEAB']=$anio ;
      $insertar['ingresoTotalesEAB']=0 ;
      $insertar['costoVentaEAB']=0 ;
      $insertar['contribucionMarginalEAB']=0 ;
      $insertar['gastoOperacionEAB']=2500 ;
      $insertar['utilidadPerdidaEAB']=-2500 ;
      $insertar['enviadoEAB']=0 ;
      $insertar['metaComercialEAB']=$agentesEnvio['montoMeta'][0]->montoEAM; 
      $insertar['comisionVentaEAB']=0 ;
      $insertar['contribucionEAB']=0 ;
      $this->db->insert('envioagentesbitacora',$insertar);
      }
    }

     
  }

}

//------------------------------------------------------------------------------------------------------------------------------------------
/*==================ESTA FUNCION SE EMPLEA EN EL ENVIO MENSUAL DE ESTADO FINANCIERO Y META COMERCIAL DE CADA AGENTE========================*/
private function devuelveCabeceraExcel($arreglo,$cabecera){


  $cadena='<table width="200" border="1">';
  $i=0;
  foreach ($cabecera as  $datos) {
    $cadena=$cadena.'<tr><td style="background-color:green"><b>'.$datos->descripcionEAT.$arreglo[$i].'</td></tr>';
    $i++;
    
  }

    $cadena=$cadena.'</table>';
  $cadena= $cadena.'<table><tr><td style="background-color: gray;color:white;height:40px;width:200px; border:solid; border-color:black"></td><td  style="background-color: gray;color:white;height:40px;width:200px; border:solid; border-color:black"><b>Enero</td><td style="background-color: gray;color:white;width:200px;border:solid; border-color:black"><b>Febrero</td><td style="background-color: gray;color:white;width:200px;border:solid; border-color:black"><b>Marzo</td><td style="background-color: gray;color:white;width:200px;border:solid; border-color:black"><b>Abril</td><td style="background-color: gray;color:white;width:200px;border:solid; border-color:black"><b>Mayo</td><td style="background-color: gray;color:white;width:200px;border:solid; border-color:black"><b>Junio</td><td style="background-color: gray;color:white;width:200px;border:solid; border-color:black"><b>Julio</td><td style="background-color: gray;color:white;width:200px;border:solid; border-color:black"><b>Agosto</td><td style="background-color: gray;color:white;width:200px;border:solid; border-color:black"><b>Septiembre</td><td style="background-color: gray;color:white;width:200px;border:solid; border-color:black"><b>Octubre</td><td style="background-color: gray;color:white;width:200px;border:solid; border-color:black"><b>Noviembre</td><td style="background-color: gray;color:white;width:200px;border:solid; border-color:black"><b>Diciembre</td></tr>';

  return $cadena;
}
//------------------------------------------------------------------------------------------------------------------------------------------
/*==================ESTA FUNCION SE EMPLEA EN EL ENVIO MENSUAL DE ESTADO FINANCIERO Y META COMERCIAL DE CADA AGENTE========================*/
private function devuelveEstadoFinancieroExcel($estadoFinanciero,$arregloDatos,$mes){
    $cadena='';
   $i=0;$j=0;
   foreach ($estadoFinanciero as  $datos) {
   $bordeInf="";
   $cadena=$cadena.'<tr>';
    for($j=0;$j<13;$j++){ 
    if($i==1 or $i==3){$bordeInf=' style="border-bottom:solid"';}else{$bordeInf="";}
    if($j==0){$cadena=$cadena.'<td style=" border:solid; border-color:gray"><b>'.$datos->descripcionEAT.'</td>';}
    else{if($j==$mes){$cadena=$cadena.'<td'.$bordeInf.' >'.$arregloDatos[$i].'</td>';}else{$cadena=$cadena.'<td'.$bordeInf.'></td>';}}
    
   }
   $cadena=$cadena.'</tr>';
    $i++;
  
    }
    return $cadena;

}
//------------------------------------------------------------------------------------------------------------------------------------------
/*==================ESTA FUNCION SE EMPLEA EN EL ENVIO MENSUAL DE ESTADO FINANCIERO Y META COMERCIAL DE CADA AGENTE========================*/
private function devuelveMetaComercialExcel($estadoFinanciero,$arregloDatos,$mes){

  $cadena='';
  $i=0;$j=0;
   foreach ($estadoFinanciero as  $datos) {
   $bordeInf="";
   $cadena=$cadena.'<tr>';
    for($j=0;$j<13;$j++){ 
    if($i==1 or $i==3){$bordeInf=' style="border-bottom:solid;background-color:yellow"';}else{$bordeInf=" style=background-color:yellow";}
    if($j==0){$cadena=$cadena.'<td style=" border:solid; border-color:gray"><b>'.$datos->descripcionEAT.'</td>';}
    else{if($j==$mes){$cadena=$cadena.'<td'.$bordeInf.'>'.$arregloDatos[$i].'</td>';}else{$cadena=$cadena.'<td'.$bordeInf.'></td>';}}
    
   }
   $cadena=$cadena.'</tr>';
    $i++;
  
    }
    return $cadena;

}
//-------------------------------------------------------------------------------------------------------------------------------------------
public function devuelveUltimoDiaMes(){
      $mes = date('m');
      $anio = date('Y');
      if($mes==1){$mes=12;$anio=$anio-1;}
      $dia = date("d", mktime(0,0,0, $mes, 0, $anio));    
      return $dia;
}
//------------------------------------------------------------------------------------------------------------------------------------------


public function envioCorreos(){
/*========================ENVIA CADA 5 MINUTOS LOS CORREO QUE LLEGAN AL================================*/
$correosPendientesEnviar=$this->db->query("select * from envio_correos where status=0 limit 10")->result();
  $cantidad=count($correosPendientesEnviar);     
    // $correosPendientesEnviar = $this->capsysdre_envioCorreos->correosPendientesEnviar();
      if($correosPendientesEnviar != FALSE){
        $this->load->library('email');
        $config['protocol'] = 'smtp';
        $config['smtp_host'] = 'agentecapital.com';        
        $config['smtp_user'] = 'avisocapital@asesorescapital.com';
        $config['smtp_pass'] = ';uthbsm?m0^$';        
        $config["smtp_port"] = '587';
         $config['charset'] = 'utf-8';
         $config['wordwrap'] = TRUE;
         $config['validate'] = true;
       $prueba= $this->email->initialize($config);     
        for($i=0;$i<$cantidad;$i++){       
         $fromNombre = strstr($correosPendientesEnviar[$i]->desde, '<', true);
         $fromEmail = trim(substr(strstr($correosPendientesEnviar[$i]->desde, "<"), 1),'>');
               $this->email->from('avisosgap@asesorescapital.com',$fromNombre);
        $this->email->subject('Here is your info '. $fromNombre);
             $this->email->to($correosPendientesEnviar[$i]->para);
                 $this->email->subject($correosPendientesEnviar[$i]->asunto);
            $this->email->message($correosPendientesEnviar[$i]->mensaje);        
               if($this->email->send()){
 
               $actualizar="update envio_correos set status=1 where idCorreo=".$correosPendientesEnviar[$i]->idCorreo;
         #$v3->query($actualizar);
               $this->db->query($actualizar);
  
         
        }
        else
        {
              #$fp = fopen('erroresEmail.txt', 'a');fwrite($fp, print_r($this->email->print_debugger(),TRUE));fclose($fp);
        }
        }
      }
            

}



//---------------------------------------------------------------------
public function puntosALCprueba(){
   $this->load->library("libreriav3");$this->load->library("WS_Sicas");  $this->load->model('puntos_model');$this->load->model('personamodelo');
      $mes=(date('m'));$mes=$mes-1;$anio=date('Y');
     if($mes==0){$mes=12;$anio=$anio-1;}
    $fechaInicial='01/'.$mes.'/'.$anio;
    $fechaFinal=$this->devuelveUltimoDiaMes().'/'.$mes.'/'.$anio;
  $ultimoDiaMes=$this->libreriav3->devolverUltimoDiaDeMes('/','03','2019');
  $primerDiaMes='01/07/2019';$ultimoDiaMes='31/07/2019';
  $recibos=$this->ws_sicas->obtenerRecibosPorFecha($primerDiaMes,$ultimoDiaMes,null);

}
//--------------------------------------------------------------------
public function puntosAutomaticosLealtadClientes()
{
  /*EN CASO DE RECIBIR LOS PARAMETROS CON GET SE CALCULAN DE LA ANIO Y MES QUE SE MANDEN, PARA EL CASO DE LOS AUTOMATICOS SE CALCULA DEL MES ANTERIOR AL QUE SE ESTA EJECUTANDO*/
  $this->load->library("libreriav3");$this->load->library("WS_Sicas");  $this->load->model('puntos_model');$this->load->model('personamodelo');
      $mes=(date('m'));$mes=$mes-1;$anio=date('Y');
     if($mes==0){$mes=12;$anio=$anio-1;}
     if(isset($_GET['mes'])){$mes=$_GET['mes'];}
     if(isset($_GET['anio'])){$anio=$_GET['anio'];}
    $fechaInicial='01/'.$mes.'/'.$anio;
    //$fechaFinal=$this->devuelveUltimoDiaMes().'/'.$mes.'/'.$anio;
    $correoPuntos='';
     $fechaFinal=$this->libreriav3->devolverUltimoDiaDeMes('/',$mes,$anio);
  
  $primerDiaMes=$fechaInicial;$ultimoDiaMes=$fechaFinal;
  //$primerDiaMes='01/02/2020';$ultimoDiaMes='29/02/2020';
  $recibos=$this->ws_sicas->obtenerRecibosPorFecha($primerDiaMes,$ultimoDiaMes,null);
    
  $consulta="select * from punto where IDPUNTO<7 and statusPunto=1";
  $puntosLealtad=$this->db->query($consulta)->result();
  $cont=0;$pVida=0;$pAutos=0;$pAccidentes=0;$pDanios=0;$pFianzas=0;$pPolzaVerde=0;$pPolzaVerdeCliente=0;
  $idPuntos=0;
  foreach ($puntosLealtad as  $value) {
    switch ($value->IDPUNTO) {
      case '1':$pPolzaVerde=$value->PUNTO;break;
      case '2':$pAutos=$value->PUNTO;break;
      case '3':$pAccidentes=$value->PUNTO;break;
      case '4':$pVida=$value->PUNTO;break;
      case '5':$pDanios=$value->PUNTO;break;
      case '6':$pFianzas=$value->PUNTO;break;
      
    }
  }
  foreach ($recibos as  $value) 
  {  $insert="";
    
    $serie=explode('/',$value->Serie); $puntos=0;
/*============SI LA POLZA ESTA PAGADA COMPLETAMENTE========*/
    if((string)$serie[0]!=(string)$serie[1]){
        
           $consulta="select idPersona from clientelealtad c left join users u on u.idPersona=c.idPersonaP where u.IDVend=".$value->IDVend;
     $resultadoC=$this->db->query($consulta)->result();
       if((count($resultadoC)>0)){
              $f1=Strstr($value->FechaDocto,"T",true);
      $f2=Strstr($value->FLimPago,"T",true); 
       $insert['IDRecibo']=(string)$value->IDRecibo;
       $insert['PrimaNeta']=$value->PrimaNeta;
       $insert['renovacion']=$value->Renovacion;
       $insert['puntos']=0;
       $insert['FechaDocto']=$f1;
       $insert['FLimPago']=$f2;
       $insert['IDVend']=$value->IDVend;
       $insert['IDClie']=$value->IDCli;
       $insert['polzaVerde']=0;
      $insert['Periodo']=$value->Periodo;
      $insert['IDDocto']=$value->IDDocto;
      $insert['TCPago']=$value->TCPago;
      $insert['serieRecibo']=$serie[0];
      $insert['serieFinRecibo']=$serie[1];
      $insert['IDEnd']=$value->IDEnd;
       $this->db->insert('recibospuntos',$insert);
       }
    
    }
    else
    { 
/*=================SI AGENTE PARTICIPA EN PUNTOS LEALTAD===========*/
     $consulta="select idPersona from clientelealtad c left join users u on u.idPersona=c.idPersonaP where u.IDVend=".$value->IDVend;
     $resultadoC=$this->db->query($consulta)->result();
       if((count($resultadoC)>0)){
      $buscarIdRecibo=0;
      $consulta='select (count(IDRecibo)) as total from recibospuntos where IDRecibo="'.$value->IDRecibo.'"';
      $buscarIdRecibo=$this->db->query($consulta)->result();
/*=============SI RECIBO NO SE LE HAN DADO PUNTOS==========*/
      if($buscarIdRecibo[0]->total==0){
      $opcion;
      if((string)$value->RamosNombre=="Daños"){$opcion="Danios";}
      switch($value->RamosNombre){
        case 'Vida': $puntos=$pVida;$idPuntos=4; break;
        case 'Vehiculos': $puntos=$pAutos;$idPuntos=2; break;
        case 'Accidentes y Enfermedades':$puntos=$pAccidentes;$idPuntos=3;  break;
        case 'Daños': $puntos=$pDanios;$idPuntos=5; break;
        case 'Fianzas': $puntos=$pFianzas;$idPuntos=6; break;
      } 
      $f1=Strstr($value->FechaDocto,"T",true);
      $f2=Strstr($value->FLimPago,"T",true); 
      $consultaRecibos=$this->db->query('select sum(Primaneta*TCPago) as totalRecibos  from recibospuntos rp where rp.IDDocto='.$value->IDDocto.' and IDEnd='.$value->IDEnd)->result()[0];
      if($consultaRecibos->totalRecibos==""){$consultaRecibos->totalRecibos=0;}
      //$consultaRecibos->idDocto=$value->IDDocto;
      $totalPolza=($value->PrimaNeta*$value->TCPago)+$consultaRecibos->totalRecibos;
      $primaNeta=(int)((($value->PrimaNeta*$value->TCPago)+$consultaRecibos->totalRecibos)/1000) ;   
/*===========SI POLZA FUE PAGADA ANTES DE TIEMPO==================*/
  
      if($f2>=$f1)
      {   $pPolzaVerdeCliente=$pPolzaVerde;    
       if($value->Renovacion==0){$sumarPuntos=(double)$puntos*(double)$primaNeta;}
       else{          
            if($value->Renovacion==1 || $value->Renovacion==2){$sumarPuntos=(($puntos*2)*$primaNeta);}
            else{$sumarPuntos=(($puntos*3)*$primaNeta);}
           }
          
      }
/*==========SI POLZA FUE PAGADA DESPUES  DE TIEMPO=================*/
  else{$sumarPuntos=(($puntos/2)*$primaNeta);$pPolzaVerdeCliente=$pPolzaVerde/2;}
      /*LLAMAR A LA FUNCION DE SUMAR PUNTOS*/
       $idPersona=$this->personamodelo->obtenerIdPersona($value->IDVend);       
        $band=$this->puntos_model->verificaExistenciaClientPunto($value->IDCli);

      if($band){$this->puntos_model->sumaPuntos($value->IDCli,(float)$sumarPuntos,$idPersona[0]->idPersona);}
      else{$this->puntos_model->insertaClienteEnPunto($value->IDCli,(float)$sumarPuntos,$idPersona[0]->idPersona);}

      $datos['PUNTOS']=$sumarPuntos;
      $datos['IDCli']=$value->IDCli;
      $datos['idPersona']=$idPersona[0]->idPersona ;
      $datos['idPromocionPunto']=$idPuntos;
      $datos['IDRecibo']=$value->IDRecibo;
      $datos['Renovacion']=$value->Renovacion;
      $datos['primaNeta']=$value->PrimaNeta;
      $datos['FechaDocto']=$f1;
      $datos['FLimPago']=$f2;
      $datos['Periodo']=$value->Periodo;
      $datos['IDDocto']=$value->IDDocto;
      $datos['TCPago']=$value->TCPago;
      $datos['IDEnd']=$value->IDEnd;
      $datos['totalPolza']=$totalPolza;
      $this->puntos_model->guardarEnBitacora($datos);
      if($value->NombreCompleto!=""){$this->puntos_model->actualizarNombreCliente($value->IDCli,$value->NombreCompleto);}

      /*INSERTAR EN TABLA DE RECIBOS*/
       $insert['IDRecibo']=(string)$value->IDRecibo;
       $insert['PrimaNeta']=$value->PrimaNeta;
       $insert['renovacion']=$value->Renovacion;
       $insert['puntos']=$sumarPuntos;
       $insert['FechaDocto']=$f1;
       $insert['FLimPago']=$f2;
       $insert['IDVend']=$value->IDVend;
       $insert['IDClie']=$value->IDCli;
       $insert['polzaVerde']=0;
             $insert['Periodo']=$value->Periodo;
      $insert['IDDocto']=$value->IDDocto;
      $insert['TCPago']=$value->TCPago;
      $insert['serieRecibo']=$serie[0];
      $insert['serieFinRecibo']=$serie[1];
      $insert['IDEnd']=$value->IDEnd;
       $this->db->insert('recibospuntos',$insert);
 
       if(isset($value->Referencia3)){
        if($value->Referencia3=='1'){
          $update="update recibospuntos set polzaVerde=1 where IDRecibo=".(string)$value->IDRecibo;
          $this->db->query($update);
          $this->puntos_model->sumaPuntos($value->IDCli,(float)$pPolzaVerdeCliente,$idPersona[0]->idPersona);   
          $datos['PUNTOS']=(float)$pPolzaVerdeCliente;
          $datos['IDCli']=$value->IDCli;
          $datos['idPersona']=$idPersona[0]->idPersona ;
          $datos['idPromocionPunto']=1;
          $datos['IDRecibo']=$value->IDRecibo;
          $insert['IDEnd']=$value->IDEnd;
                $datos['Periodo']=$value->Periodo;
      $datos['IDDocto']=$value->IDDocto;
      $datos['TCPago']=$value->TCPago;
          $this->puntos_model->guardarEnBitacora($datos);
        }
       }   
     }
     }
    }

  }
}



//---------------------------------------------------------------------

public function puntosAutomaticosLealtadClientes2()
{
  $this->load->library("libreriav3");$this->load->library("WS_Sicas");  $this->load->model('puntos_model');$this->load->model('personamodelo');
      $mes=(date('m'));$mes=$mes-1;$anio=date('Y');
     if($mes==0){$mes=12;$anio=$anio-1;}
    $fechaInicial='01/'.$mes.'/'.$anio;
    $fechaFinal=$this->devuelveUltimoDiaMes().'/'.$mes.'/'.$anio;
  $ultimoDiaMes=$this->libreriav3->devolverUltimoDiaDeMes('/','03','2019');
  $primerDiaMes='01/02/2019';$ultimoDiaMes='28/02/2019';
//$primerDiaMes=$fechaInicial;$ultimoDiaMes='28/02/2019';

  $recibos=$this->ws_sicas->obtenerRecibosPorFecha($primerDiaMes,$ultimoDiaMes,null);

  $consulta="select * from punto where IDPUNTO<7 and statusPunto=1";
  $puntosLealtad=$this->db->query($consulta)->result();
  $cont=0;$pVida=0;$pAutos=0;$pAccidentes=0;$pDanios=0;$pFianzas=0;$pPolzaVerde=0;$pPolzaVerdeCliente=0;
  $idPuntos=0;
  foreach ($puntosLealtad as  $value) {
    switch ($value->IDPUNTO) {
      case '1':$pPolzaVerde=$value->PUNTO;break;
      case '2':$pAutos=$value->PUNTO;break;
      case '3':$pAccidentes=$value->PUNTO;break;
      case '4':$pVida=$value->PUNTO;break;
      case '5':$pDanios=$value->PUNTO;break;
      case '6':$pFianzas=$value->PUNTO;break;
      
    }
  }
  
  foreach ($recibos as  $value) 
  { 
    $serie=explode('/',$value->Serie); $puntos=0;
/*============SI LA POLZA ESTA PAGADA COMPLETAMENTE========*/
    if((string)$serie[0]==(string)$serie[1])
    { 
/*=================SI AGENTE PARTICIPA EN PUNTOS LEALTAD===========*/
     $consulta="select idPersona from clientelealtad c left join users u on u.idPersona=c.idPersonaP where u.IDVend=".$value->IDVend;
     $resultadoC=$this->db->query($consulta)->result();
       if((count($resultadoC)>0)){
      $buscarIdRecibo=0;
      $consulta='select (count(IDRecibo)) as total from recibospuntos where IDRecibo="'.$value->IDRecibo.'"';
      $buscarIdRecibo=$this->db->query($consulta)->result();
/*=============SI RECIBO NO SE LE HAN DADO PUNTOS==========*/
      if($buscarIdRecibo[0]->total==0){
      $opcion;
      if((string)$value->RamosNombre=="Daños"){$opcion="Danios";}
      switch($value->RamosNombre){
        case 'Vida': $puntos=$pVida;$idPuntos=4; break;
        case 'Vehiculos': $puntos=$pAutos;$idPuntos=2; break;
        case 'Accidentes y Enfermedades':$puntos=$pAccidentes;$idPuntos=3;  break;
        case 'Daños': $puntos=$pDanios;$idPuntos=5; break;
        case 'Fianzas': $puntos=$pFianzas;$idPuntos=6; break;
      } 
      $f1=Strstr($value->FechaDocto,"T",true);
      $f2=Strstr($value->FLimPago,"T",true); 
      $primaNeta=(int)(($value->PrimaNeta*$value->TCPago)/1000) ;   
/*===========SI POLZA FUE PAGADA ANTES DE TIEMPO==================*/
  
      if($f2>=$f1)
      {   $pPolzaVerdeCliente=$pPolzaVerde;    
       if($value->Renovacion==0){$sumarPuntos=(double)$puntos*(double)$primaNeta;}
       else{          
            if($value->Renovacion==1 || $value->Renovacion==2){$sumarPuntos=(($puntos*2)*$primaNeta);}
            else{$sumarPuntos=(($puntos*3)*$primaNeta);}
           }
          
      }
/*==========SI POLZA FUE PAGADA DESPUES  DE TIEMPO=================*/
  else
       {$sumarPuntos=(($puntos/2)*$primaNeta);$pPolzaVerdeCliente=$pPolzaVerde/2;}
      /*LLAMAR A LA FUNCION DE SUMAR PUNTOS*/
       $idPersona=$this->personamodelo->obtenerIdPersona($value->IDVend);       
          $band=$this->puntos_model->verificaExistenciaClientPunto($value->IDCli);

      if($band)
      {$this->puntos_model->sumaPuntos($value->IDCli,(float)$sumarPuntos,$idPersona[0]->idPersona);
      }
      else
      {$this->puntos_model->insertaClienteEnPunto($value->IDCli,(float)$sumarPuntos,$idPersona[0]->idPersona);
      }

      $datos['PUNTOS']=$sumarPuntos;
      $datos['IDCli']=$value->IDCli;
      $datos['idPersona']=$idPersona[0]->idPersona ;
      $datos['idPromocionPunto']=$idPuntos;
      $datos['IDRecibo']=$value->IDRecibo;
      $datos['Renovacion']=$value->Renovacion;
      $datos['primaNeta']=$value->PrimaNeta;
      $datos['FechaDocto']=$f1;
      $datos['FLimPago']=$f2;
      $this->puntos_model->guardarEnBitacora($datos);
      $this->puntos_model->actualizarNombreCliente($value->IDCli,$value->NombreCompleto);

      /*INSERTAR EN TABLA DE RECIBOS*/
       $insert['IDRecibo']=(string)$value->IDRecibo;
       $insert['PrimaNeta']=$value->PrimaNeta;
       $insert['renovacion']=$value->Renovacion;
       $insert['puntos']=$sumarPuntos;
       $insert['FechaDocto']=$f1;
       $insert['FLimPago']=$f2;
       $insert['IDVend']=$value->IDVend;
       $insert['IDClie']=$value->IDCli;
       $insert['polzaVerde']=0;
       $this->db->insert('recibospuntos',$insert);
       //$fp = fopen('resultadoJason.txt', 'a');fwrite($fp, print_r($primaNeta.'-'.$value->IDRecibo.'/',TRUE));fclose($fp);  
       if(isset($value->Referencia3)){
        if($value->Referencia3=='REFERENCIA 3'){
          $update="update recibospuntos set polzaVerde=1 where IDRecibo=".(string)$value->IDRecibo;
          $this->db->query($update);
          $this->puntos_model->sumaPuntos($value->IDCli,(float)$pPolzaVerdeCliente,$idPersona[0]->idPersona);   
          $datos['PUNTOS']=(float)$pPolzaVerdeCliente;
          $datos['IDCli']=$value->IDCli;
          $datos['idPersona']=$idPersona[0]->idPersona ;
          $datos['idPromocionPunto']=1;
          $datos['IDRecibo']=$value->IDRecibo;
          $this->puntos_model->guardarEnBitacora($datos);
        }
       }   
     }
     }
    }
  }
  

}

//------------------------------------------------------------------------------------------------------------------------------------------
function buscarDocumento(){
  //0880251451,0000256987-2
  $this->load->library("WS_Sicas");
  $this->ws_sicas->buscaDocumento('0000284642-1');
}

//------------------------------------------------------------------------------------------------------------------------------------------
function renovarUrgentesDeAgentes(){
/*SE EJECUTA CADA PRIMERO DE MES Y RENUEVA EL NUMERO DE URGENTES PARA LOS AGENTES
  6 PARA AGENTES ORO DEL CANAL DE ASESORES 
 10 PARA PLATINO DEL CANAL DE ASESORES  
*/

  $v3=$this->load->database('V3',true);
    $consulta="select persona.idPersona,persona.nombres,(if((concat(persona.nombres,' ',persona.apellidoPaterno,' ',persona.apellidoMaterno))is null,
persona.nombres,concat(persona.nombres,' ',persona.apellidoPaterno,' ',persona.apellidoMaterno))) as nombre, 
personatipoagente.personaTipoAgente,persona.idpersonarankingagente, 'activo' as lealtad,persona.id_catalog_canales,cc.nombreTitulo
from persona
left join users on users.idPersona=persona.idPersona
left join personatipoagente on personatipoagente.idPersonaTipoAgente=persona.personaTipoAgente
left join catalog_canales cc on cc.IdCanal=persona.id_catalog_canales
where persona.tipoPersona=3 and users.banned=0 and users.activated=1";
$agentes=$v3->query($consulta)->result();
    //$this->load->model('personamodelo');
    //$agentes=$this->personamodelo->obtenerVendActivos();
    //$this->db->query('update users set NumUrgentes=0');
     $v3->query('update users set NumUrgentes=0');
    foreach ($agentes as $value) 
    {
        if($value->id_catalog_canales==10 && ($value->idpersonarankingagente=='ORO' || $value->idpersonarankingagente=='PLATINO VIP')){
          $urgentesPermitidas=0;
          if($value->idpersonarankingagente=='ORO'){$urgentesPermitidas=6;}else{$urgentesPermitidas=10;}
           $v3->query('update users set NumUrgentes='.$urgentesPermitidas.' where idPersona='.$value->idPersona);
        }
    }
}
//-------------------------------------------------------------------------------------------------------------------------------
public function baneoAgentes(){
  /*========FUNCION QUE SE DEBE EJECUTAR TODOS LOS DIAS PARA VERIFICAR SI SE BANEAN LOS AGENTES============*/
          //$datosBaneo['idPersona']=0;
         //$this->db->insert('baneousuario',$datosBaneo);
         $this->load->library('Ws_sicas');
          $this->load->library('libreriaV3');
         $v3=$this->load->database('V3',true);
         $D_Cred=new stdClass();
         $datoCredenciales['username']="SISTEMAS@ASESORESCAPITAL.COM";
         $datoCredenciales['Password']="ECHAN2018";
         $datoCredenciales['CodeAuth']="codigo";
         $datos['TipoEntidad']='0';
         $datos['TypeDestinoCDigital']='CONTACT';
         $datos['IDValuePK']='0';
         $datos['ActionCDigital']='GETFiles';
         $datos['TypeFormat']='JSON';
         $datos['TProct']='Read_Data';
         $datos['KeyProcess']='REPORT';
         $datos['KeyCode']='H02930_003';
         $datos['Page']='1';
         $datos['ItemForPage']='1000';
         $datos['InfoSort']='DatHonRecibos.Status_TXT';
         $datos['IDRelation']='0';
        $datosConsulta=$v3->query('select (TIMESTAMPDIFF(MONTH, cast(persona.fecInicioBaneo as date), curdate() ) ) as difMeses,(cast(persona.fecAltaSistemPersona as date)) fechaAlta,persona.fecAltaSistemPersona,persona.IDVend,persona.idPersona,cast(now() as date) as fechaActual,persona.nombres,personatipoagente.personaTipoAgente from persona left join users on users.idPersona=persona.idPersona left join personatipoagente on personatipoagente.idPersonaTipoAgente=persona.personaTipoAgente where (persona.personaTipoAgente=1 or persona.personaTipoAgente=2 or persona.personaTipoAgente=7) and persona.idpersonarankingagente="BRONCE" and users.banned=0 and persona.id_catalog_canales!=3');

    $datosConsultaBaneados=$v3->query("select distinct(u.IDVend),u.name_complete,um.Ranking from users u left join user_miInfo um on um.IDVend=u.IDVend where u.banned=1 and  u.IdCanal=1 and um.Ranking='PROVISIONAL' and u.idTipoUser=12  order by u.name_complete");

    $totalRows=$datosConsulta->num_rows();
    $vendedor="";
    $i=0;
    $monto=0;
    $datosRestrinccion=array();
    $Importe="";$sumaImporte=0;
    $anioActual=date("Y");
    $anioAnterior=$anioActual-1;
     foreach ($datosConsulta->result() as $value) 
      {//resultadoJasonac
      $vendedor=$value->IDVend;
      $fechaDividida=explode("-",$value->fechaAlta);
      $fecIni=$fechaDividida[2].'/'.$fechaDividida[1].'/'.$anioAnterior;//$this->libreriav3->convierteFecha($value->fechaAlta);
      $fecAct=$fechaDividida[2].'/'.$fechaDividida[1].'/'.$anioActual;//$this->libreriav3->convierteFecha($value->fechaActual); 

     if($value->difMeses>0){   
      if(is_int($value->difMeses/3)){
        $datos['ConditionsAdd']='Recibos;0;0;1;Pagados;1;-1;DatHonRecibos.Pagado ! Desde|Hasta|Fecha de Pago;3;0;'.$fecIni.'|'.$fecAct.';'.$fecIni.'|'.$fecAct.';0;-1;DatHonDocto.FPago ! VendedorID;2;0;'.$vendedor.';'.$vendedor.';51;DatHonRecibos.IDVE' ;
      // $respuestaSicas=$this->webservice_sicas_soap->datosComisiones($datos);
        $respuestaSicas=$this->ws_sicas->envioMensualAgentes($vendedor,$fecIni,$fecAct);
   
         $sumaImporte=0;
         $bandEntrada=0;
          foreach ($respuestaSicas as $dato ) {$sumaImporte=$sumaImporte+floatval($dato->ImporteP);$bandEntrada=1;}
                   //$cantMes=$sumaImporte/$value->difMeses;
                   $cantMes=$sumaImporte/12;
                    //$fp = fopen('resultadoJason.txt', 'a');fwrite($fp, print_r($insertCorreo.'<>',TRUE));fclose($fp); 
        if($cantMes<2500)
        {              
          if($value->idPersona>0){
          if($bandEntrada==1)
          {            
          $actualizar['banned']=1;
          $actualizar['idTipoUser']=12;
          $actualizar['activated']=0;
          $actVendor['Status']=1;
          $actVendor['Status_TXT']="INACTIVO";
          $v3->where('idPersona',$value->idPersona);//
          $v3->update('users',$actualizar); 
          //$fp = fopen('resultadoJason.txt', 'a');fwrite($fp, print_r($value->idPersona,TRUE));fclose($fp); 
          //$fp = fopen('resultadoJason.txt', 'a');fwrite($fp, print_r($actVendor,TRUE));fclose($fp); 
          $v3->where('idPersona',$value->idPersona);
          $v3->update('catalog_vendedores',$actVendor);
          $insertar['idPersona']=$value->idPersona;
          $insertar['fecIniBaneoUsuario']=$value->fechaAlta;
          $insertar['fecFinBaneoUsuario']=$value->fechaActual;
          $v3->insert('baneousuario',$insertar);         
          $consulta="select * from persona where  idPersona=".$value->idPersona; 
          $datosPersona=$v3->query($consulta)->result()[0];
          //TRAER EL CORREO QUE ESTA EN LA TABLA DE USER
          $nombre=$datosPersona->apellidoPaterno.' '.$datosPersona->apellidoMaterno.' '.$datosPersona->nombres;
          $insertC="insert into envio_correos(fechacreacion,desde,para,copia,copiaoculta,asunto,mensaje,status,fechaenvio,identificaModulo)";
          $insertCorreo=$insertC.'values(now(), "Buzon de quejas<avisosgap@aserorescpital.com>","'.$datosPersona->userEmailCreacion.'" ,0,0,"Baneo","La cuenta de '.$nombre.'('.$datosPersona->emailUsers.') se deshabilito del V3",0,now(),"baneoMensual");';
          $v3->query($insertCorreo);
          $insertCorreo=$insertC.'values(now(), "Buzon de quejas<avisosgap@aserorescpital.com>","'.$datosPersona->emailUsers.'" ,0,0,"Baneo","Su cuenta se ha baneado del V3",0,now(),"baneoMensual");';
          $v3->query($insertCorreo);
          $insertCorreo=$insertC.'values(now(), "Buzon de quejas<avisosgap@aserorescpital.com>","DIRECTORGENERAL@AGENTECAPITAL.COM" ,0,0,"Baneo","La cuenta de '.$nombre.'('.$datosPersona->emailUsers.') se deshabilito del V3",0,now(),"baneoMensual");';
         $v3->query($insertCorreo);
        $insertCorreo=$insertC.'values(now(), "Buzon de quejas<avisosgap@aserorescpital.com>","AUDITORINTERNO@AGENTECAPITAL.COM" ,0,0,"Baneo","La cuenta de '.$nombre.'('.$datosPersona->emailUsers.') se deshabilito del V3",0,now(),"baneoMensual");';
         $v3->query($insertCorreo);
            //$this->operPersona->enviarCorreo($datosPersona->userEmailCreacion,"Baneo","La cuenta de ".$nombre.'('.$datosPersona->emailUsers.') se deshabilito del V3');
            //$this->operPersona->enviarCorreo($datosPersona->emailUsers,"Baneo","Su cuenta se ha baneado del V3");
            //$this->operPersona->enviarCorreo("DIRECTORGENERAL@AGENTECAPITAL.COM","Baneo","La cuenta de ".$nombre.'('.$datosPersona->emailUsers.') se deshabilito del V3');
            //$this->operPersona->enviarCorreo("AUDITORINTERNO@AGENTECAPITAL.COM","Baneo","La cuenta de ".$nombre.'('.$datosPersona->emailUsers.') se deshabilito del V3');
          }
         }
         }

      }

    }
   } 
 }

//-------------------------------------------------------------------------------------------------------------------------------

/*public function puntosAutomaticosLealtadClientes()
{
  $this->load->library("libreriav3");$this->load->library("WS_Sicas");$this->load->model('puntos_model');
  $ultimoDiaMes=$this->libreriav3->devolverUltimoDiaDeMes('/','03','2019');
  $ultimoDiaMes='08/02/2019';$primerDiaMes='05/02/2019';
  //
  $recibos=$this->ws_sicas->obtenerRecibosPorFecha($primerDiaMes,$ultimoDiaMes,null);
  $puntosAutomaticos=$this->puntos_model->devolverPuntosAutomaticos();

  $puntos="";
  foreach ($recibos as  $values) {
  # code...
}
  foreach ($puntosAutomaticos as  $value) {
    switch ($value->IDPUNTO) {
      case 1:$puntos['polzaVerde']=$value->PUNTO;break;
     case 2:$puntos['Vehiculos']=$value->PUNTO;break;
      case 3:$puntos['Vida']=$value->PUNTO;break;
      case 5:$puntos['Danos']=$value->PUNTO;break;
      case 6:$puntos['Fianzas']=$value->PUNTO;break;
    }
  }
$contador=0;



    /*Vehiculos=17,Vida=14,Daños=52,Fianzas=45,
}*/
  //----------------------------------------------------------------------
public function traeRecibosPagados(){
/*=====================FUNCION PARA TRAER RECIBOS PAGADOS POR FECHA Y VENDEDOR NO TIENE NINGUNA TAREA PROGRAMADA=======================*/
           $this->load->library('Ws_sicas');
          $this->load->library('libreriaV3');
  $fecIni="22/03/2018";
  $fecAct="22/03/2019";
  $vendedor=393;//245;
          $datos['ConditionsAdd']='Recibos;0;0;1;Pagados;1;-1;DatHonRecibos.Pagado ! Desde|Hasta|Fecha de Pago;3;0;'.$fecIni.'|'.$fecAct.';'.$fecIni.'|'.$fecAct.';0;-1;DatHonDocto.FPago ! VendedorID;2;0;'.$vendedor.';'.$vendedor.';51;DatHonRecibos.IDVE' ;
       //$respuestaSicas=$this->webservice_sicas_soap->datosComisiones($datos);
        $respuestaSicas=$this->ws_sicas->envioMensualAgentes($vendedor,$fecIni,$fecAct);
        $sumaImporte=0;
                foreach ($respuestaSicas as $dato ) {$sumaImporte=$sumaImporte+floatval($dato->ImporteP);}

}
//----------------------------------------------------------------------
public function buscarReciboIDUnico()
{
  $this->load->library('Ws_sicas');
  $this->load->library('libreriaV3'); 
  $respuestaSicas=$this->ws_sicas->obtenerReciboPorID('232165');     

}
public function buscarReciboID(){
  /*======BUSCAR EL RECIBO DE ACUERDO A SU ID DE RECIBO NO ESTA RELACIONADO A NINGUNA TAREA PROGRAMADA========*/
  
             $this->load->library('Ws_sicas');
          $this->load->library('libreriaV3');

              $v3=$this->load->database('V3',true);
          $sum=0;

         // $recibos=$v3->query("select * from recibospuntos order by IDRecibo limit 0,1000;")->result();
          //$recibos=$v3->query("select * from recibospuntos order by IDRecibo limit 1000,1000")->result();
          //$recibos=$v3->query("select * from recibospuntos order by IDRecibo limit 2000,1000")->result();
          //$recibos=$v3->query("select * from recibospuntos order by IDRecibo limit 3000,1000")->result();
          //$recibos=$v3->query("select * from recibospuntos order by IDRecibo limit 4000,1000")->result();
         // $recibos=$v3->query("select * from recibospuntos order by IDRecibo limit 5000,1000")->result();
          //$recibos=$v3->query("select * from recibospuntos order by IDRecibo limit 6000,1000")->result();
          //$recibos=$v3->query("select * from recibospuntos order by IDRecibo limit 7000,1000")->result();
          //$recibos=$v3->query("select * from recibospuntos order by IDRecibo limit 8000,1000")->result();
          $recibos=$v3->query("select * from recibospuntos order by IDRecibo limit 9000,700")->result();
          $IDRecibos="";
          $contador=0;
          $idM=0;
    foreach ($recibos as  $valueR) { $IDRecibos.=$valueR->IDRecibo;$IDRecibos.='|';}


                                
                  $respuestaSicas=$this->ws_sicas->obtenerReciboPorID($IDRecibos); 
 
                foreach ($respuestaSicas as $value) {
                 $sum=0;
                 $sum=((float)$value->Comision0+(float)$value->Comision1+(float)$value->Comision2+(float)$value->Comision3+(float)$value->Comision4+(float)$value->Comision5);
                 $sum=(float)$sum*(float)$value->TCPago;
                 $update['Comision0']=$value->Comision0;
                 $update['Comision1']=$value->Comision1;
                 $update['Comision2']=$value->Comision2;
                 $update['Comision3']=$value->Comision3;
                 $update['Comision4']=$value->Comision4;
                 $update['Comision5']=$value->Comision5;
                 $v3->where('IDRecibo',$value->IDRecibo);
                 $v3->update('recibospuntos',$update);
                 $actualizar="";
                 $actualizar='update clientelealtadbitacora set comisionTotal=(comisionTotal+'.$sum.') where IDDocto='.$value->IDDocto.' && IDEnd='.$value->IDEnd;
                  //$fp = fopen('resultadoJason.txt', 'a');fwrite($fp, print_r($actualizar,TRUE));fclose($fp);
                 $update1['Comision0']=$value->Comision0;
                 $update1['Comision1']=$value->Comision1;
                 $update1['Comision2']=$value->Comision2;
                 $update1['Comision3']=$value->Comision3;
                 $update1['Comision4']=$value->Comision4;
                 $update1['Comision5']=$value->Comision5;
                 $update1['IDDocto']=$value->IDDocto;
                 $update1['IDRecibo']=$value->IDRecibo;
                 $update1['IDEnd']=$value->IDEnd;
                //  $fp = fopen('resultadoJason.txt', 'a');fwrite($fp, print_r($update1,TRUE));fclose($fp);

                 $v3->query($actualizar);

          }

}
//------------------------------------------------------------------------------------------------------------------------------------------------------------
function actualizaClientesSicasParaV3(){
      $this->load->library('Ws_sicas');
      $cliente=$this->ws_sicas->obtenerClientePorID(40);
      $actualizaCliente['NombreCompleto']=(string)$cliente->TableInfo->NombreCompleto;
      $actualizaCliente['NombreCompleto']=(string)$cliente->TableInfo->NombreCompleto;

}

//-------------------------------------------------------------------------------------------------------------------------------------------------------------
function reporteCobranza(){
$this->load->library("WS_Sicas");  
$tableInfo=array(); 

      $fecha=getdate();
     $fechaHoy=$fecha['year'].'-'.$fecha['mon'].'-'.$fecha['mday'];
     $anioAnterior=$fecha['year']-1;
     $fechaInicial=$fecha['mday'].'/'.$fecha['mon'].'/'.$anioAnterior;
     $fecha1Final=$fecha['mday'].'/'.$fecha['mon'].'/'.$fecha['year'];
   $numeroPagina=10;
  do{    
     //$respuesta=$this->ws_sicas->cobranza('76','01/01/2019','31/12/2019',$numeroPagina);        
     $respuesta=$this->ws_sicas->cobranza('76',$fechaInicial,$fecha1Final,$numeroPagina);        
     $numeroPagina=$numeroPagina+1;
     //$fp = fopen('resultadoJason.txt', 'a');fwrite($fp, print_r($respuesta, TRUE));fclose($fp);
     foreach($respuesta->TableInfo as $value){ array_push($tableInfo,$value);}     
  //  }while((int)$respuesta->TableControl->Pages[0]>=(int)$respuesta->TableControl->Page[0]); 
  }while(2==1); 
    $i=0; 
    $insertMultiple="insert into reportecobranzaclientesprueba(fDesde,fHasta,fLimPago,fStatus,FDoctoPago,documento,endoso,periodo,serie,renovacion,status_TXT,primaNeta,recargos,derechos,impuesto1,primaTotal,
comision0,comision1,comision2,comision3,comision4,comision5,anterior,grupo,subGrupo,cCobro_TXT,statusDoc_TXT,concepto,nombreCompleto,email1,telefono1,nombreCompania,ejecutNombre,vendNombre,
fPago,moneda,sRamoNombre,ramosNombre,tipoDocto_TXT,abreviacionVend,IDVend,TCPago,IDRecibo,IDDocto,DespNombre) values";
$valoresIM="";
    $numeroVueltas=(count($tableInfo)/500); 
    $numeroVueltas=((int)$numeroVueltas)+1;
       // $v3=$this->load->database('V3',true);
    try{

    foreach ($tableInfo as $key => $value) 
    {    

     $insert="";
     $insert['fDesde']=Strstr($value->FDesde,"T",true);
     $insert['fHasta']=Strstr($value->FHasta,"T",true); 
     $insert['fLimPago']=Strstr($value->FLimPago,"T",true); 
     $insert['fStatus']=Strstr($value->FStatus,"T",true); 
     $insert['FDoctoPago']=Strstr($value->FDoctoPago,"T",true); 
     $insert['documento']=(string)$value->Documento;
     $insert['endoso']=(string)$value->Endoso;
     $insert['periodo']=$value->Periodo;
     $insert['serie']=(string)$value->Serie;
     $insert['renovacion']=$value->Renovacion;
     $insert['status_TXT']=(string)$value->Status_TXT;
     $insert['primaNeta']=$value->PrimaNeta;
     $insert['recargos']=$value->Recargos;
     $insert['derechos']=$value->Derechos;
     $insert['impuesto1']=$value->Impuesto1;
     $insert['primaTotal']=$value->PrimaTotal;
     $insert['comision0']=$value->Comision0;
     $insert['comision1']=$value->Comision1;
     $insert['comision2']=$value->Comision2;
     $insert['comision3']=$value->Comision3;
     $insert['comision4']=$value->Comision4;
     $insert['comision5']=$value->Comision5;
     $insert['anterior']=(string)$value->DAnterior;
     $insert['grupo']=(string)$value->Grupo;
     $insert['subGrupo']=(string)$value->SubGrupo;
     $insert['cCobro_TXT']=(string)$value->CCobro_TXT;
     $insert['statusDoc_TXT']=(string)$value->StatusDoc_Txt;
     $insert['concepto']=(string)$value->Concepto;
     $insert['nombreCompleto']=(string)$value->NombreCompleto;
     $insert['email1']=(string)$value->EMail1;     
     $insert['telefono1']=(string)$value->Telefono1;
     $insert['nombreCompania']=(string)$value->CiaNombre;
     //$insert['ciaAbreviacion']=(string)$value->;
     $insert['ejecutNombre']=(string)$value->EjecutNombre;
     $insert['vendNombre']=(string)$value->VendNombre;
     $insert['fPago']=(string)$value->FPago;
     $insert['moneda']=(string)$value->Moneda;
     $insert['sRamoNombre']=(string)$value->SRamoNombre;
     $insert['ramosNombre']=(string)$value->RamosNombre;
     $insert['tipoDocto_TXT']=(string)$value->TipoDocto_TXT;     
     $insert['abreviacionVend']=(string)$value->VendAbreviacion;
     $insert['IDVend']=$value->IDVend;
     $insert['TCPago']=(double)$value->TCPago;
     $insert['IDRecibo']=(string)$value->IDRecibo;
     $insert['IDDocto']=(string)$value->IDDocto;
     $insert['DespNombre']=(string)$value->DespNombre;

      
    $this->db->insert('reportecobranzaclientes',$insert);   
    }  
   $fecha=getdate();
   $insertar['nombreTabla']='reportecobranzaclientes';
   $insertar['fechaActualizacion']=$fecha['year'].'-'.$fecha['mon'].'-'.$fecha['mday'];
   $this->db->insert('actualizacionestablas',$insertar);
   //$v3->insert('actualizacionestablas',$insertar);
  }
 catch(exception $e){$fp = fopen('resultadoJason.txt', 'a');fwrite($fp, print_r($e, TRUE));fclose($fp);}

  }
//-------------------------------------------------------------------------------------------------------------------------------------------------------------
function reporteCobranzaSubeVida(){
/*SUBE SOLO VIDA*/
$informacion['datos']=$this->db->query('select * from reportecobranzaclientes r where r.ramosNombre="Vida"')->result();
$informacion['delete']='delete from reportecobranzaclientes  where ramosNombre="Vida"';
$informacion['actualizacionesTabla']="";
$this->reporteCobranzaSube($informacion);
}
//-------------------------------------------------------------------------------------------------------------------------------------------------------------
function reporteCobranzaSubeAccidentesEnfermedades(){
/*SUBE  ACCIDENTES Y ENFERMEDADES*/
$informacion['datos']=$this->db->query('select * from reportecobranzaclientes r where r.ramosNombre="Accidentes y Enfermedades"')->result();
$informacion['delete']='delete from reportecobranzaclientes  where ramosNombre="Accidentes y Enfermedades"';
$informacion['actualizacionesTabla']="";
$this->reporteCobranzaSube($informacion);
}
//-------------------------------------------------------------------------------------------------------------------------------------------------------------
function reporteCobranzaSubeFianzasDanios(){
/*SUBE FIANZAS Y ADEMANS DANIOS*/
$informacion['datos']=$this->db->query('select * from reportecobranzaclientes r where r.ramosNombre="Fianzas" ||  r.ramosNombre="Daños"')->result();
$informacion['delete']='delete from reportecobranzaclientes  where ramosNombre="Fianzas" ||  ramosNombre="Daños"';
$informacion['actualizacionesTabla']="";
$this->reporteCobranzaSube($informacion);
}
//-------------------------------------------------------------------------------------------------------------------------------------------------------------
function reporteCobranzaSubeVehiculosPP(){
/*SUBE VEHICULOS PAGADOS Y PENDIENTES*/
$informacion['datos']=$this->db->query('select * from reportecobranzaclientes r where (r.ramosNombre="Vehiculos" and r.status_TXT="Pagado") || (r.ramosNombre="Vehiculos" and r.status_TXT="Pendiente")')->result();
$informacion['delete']='delete from reportecobranzaclientes  where (ramosNombre="Vehiculos" and status_TXT="Pagado") || (ramosNombre="Vehiculos" and status_TXT="Pendiente")';
$informacion['actualizacionesTabla']="";
$this->reporteCobranzaSube($informacion);
}
//-------------------------------------------------------------------------------------------------------------------------------------------------------------
function reporteCobranzaSubeVehiculosLQTS(){
/*SUBE VEHICULOS LIQUIDADOS QUINCENAL,TRIMESTRAL Y SEMESTRAL*/
$informacion['datos']=$this->db->query('select * from reportecobranzaclientes r where (r.ramosNombre="Vehiculos" and r.status_TXT="Liquidado" and r.fPago="Quincenal") || (r.ramosNombre="Vehiculos" and r.status_TXT="Liquidado" and r.fPago="Trimestral") || (r.ramosNombre="Vehiculos" and r.status_TXT="Liquidado" and r.fPago="Semestral")')->result();
$informacion['delete']='delete from reportecobranzaclientes  where (ramosNombre="Vehiculos" and status_TXT="Liquidado" and fPago="Quincenal") || (ramosNombre="Vehiculos" and status_TXT="Liquidado" and fPago="Trimestral") || (ramosNombre="Vehiculos" and status_TXT="Liquidado" and fPago="Semestral")';
$informacion['actualizacionesTabla']="";
$this->reporteCobranzaSube($informacion);
}
//-------------------------------------------------------------------------------------------------------------------------------------------------------------
function reporteCobranzaSubeVehiculosLC(){
/*SUBE VEHICULOS LIQUIDADOS CONTADO*/
$informacion['datos']=$this->db->query('select * from reportecobranzaclientes r where r.ramosNombre="Vehiculos" and r.status_TXT="Liquidado" and r.fPago="Contado"')->result();
$informacion['delete']='delete from reportecobranzaclientes  where ramosNombre="Vehiculos" and status_TXT="Liquidado" and fPago="Contado"';
$informacion['actualizacionesTabla']="";
$this->reporteCobranzaSube($informacion);
}
//-------------------------------------------------------------------------------------------------------------------------------------------------------------
function reporteCobranzaSubeVehiculosLM(){
/*SUBE VEHICULOS LIQUIDADOS MENSUAL*/
$informacion['datos']=$this->db->query('select * from reportecobranzaclientes r where r.ramosNombre="Vehiculos" and r.status_TXT="Liquidado" and r.fPago="Mensual"')->result();
$informacion['delete']='delete from reportecobranzaclientes  where ramosNombre="Vehiculos" and status_TXT="Liquidado" and fPago="Mensual"';
$informacion['actualizacionesTabla']="";
$this->reporteCobranzaSube($informacion);
}
//-------------------------------------------------------------------------------------------------------------------------------------------------------------
function reporteCobranzaSubeVehiculosCCQTS(){
/*SUBE VEHICULOS CANCELADOS CONTADO,QUINCENAL,TRIMESTRAL,SEMESTRAL*/
$informacion['datos']=$this->db->query('select * from reportecobranzaclientes r where ( r.ramosNombre="Vehiculos" and r.status_TXT="Cancelado" and r.fPago="Contado") || (r.ramosNombre="Vehiculos" and r.status_TXT="Cancelado" and r.fPago="Semestral") || (r.ramosNombre="Vehiculos" and r.status_TXT="Cancelado" and r.fPago="Quincenal") || (r.ramosNombre="Vehiculos" and r.status_TXT="Cancelado" and r.fPago="Trimestral")')->result();
$informacion['delete']='delete from reportecobranzaclientes  where ( ramosNombre="Vehiculos" and status_TXT="Cancelado" and fPago="Contado") || (ramosNombre="Vehiculos" and status_TXT="Cancelado" and fPago="Semestral") || (ramosNombre="Vehiculos" and status_TXT="Cancelado" and fPago="Quincenal") || (ramosNombre="Vehiculos" and status_TXT="Cancelado" and fPago="Trimestral")';
$informacion['actualizacionesTabla']="";
$this->reporteCobranzaSube($informacion);
}
//-------------------------------------------------------------------------------------------------------------------------------------------------------------
function reporteCobranzaSubeVehiculosCM(){
/*SUBE VEHICULOS CANCELADOS MENSUAL*/
$informacion['datos']=$this->db->query('select * from reportecobranzaclientes r where r.ramosNombre="Vehiculos" and r.status_TXT="Cancelado" and r.fPago="Mensual"')->result();
$informacion['delete']='delete from reportecobranzaclientes  where ramosNombre="Vehiculos" and status_TXT="Cancelado" and fPago="Mensual"';
$informacion['actualizacionesTabla']=1;
$this->reporteCobranzaSube($informacion);
}
//-------------------------------------------------------------------------------------------------------------------------------------------------------------
function reporteCobranzaSube($informacion){
  $v3=$this->load->database('V3',true);
  
 // $v3->empty_table('reportecobranzaclientes');
 $consulta='select (cast(max(fechaActualizacion) as date)) as fecha from actualizacionestablas a where a.nombreTabla="reportecobranzaclientes"';
 $fechaActualizacion=$this->db->query('select (cast(max(fechaActualizacion) as date)) as fecha from actualizacionestablas a where a.nombreTabla="reportecobranzaclientes"')->result()[0]->fecha;

 $fecha=getdate();
 $fechaHoy=$fecha['year'].'-'.$fecha['mon'].'-'.$fecha['mday'];
 $fechaHoyString=strtotime($fechaHoy);
 $fechaActualizacionString=strtotime($fechaActualizacion);

 if($fechaActualizacionString==$fechaHoyString){
  $v3->query($informacion['delete']);
 foreach ($informacion['datos'] as  $value) 
    {    
     
     $insert="";
     $insert['fDesde']=$value->fDesde;
     $insert['fHasta']=$value->fHasta; 
     $insert['fLimPago']=$value->fLimPago; 
     $insert['fStatus']=$value->fStatus; 
     $insert['FDoctoPago']=$value->FDoctoPago; 
     $insert['documento']=(string)$value->documento;
     $insert['endoso']=(string)$value->endoso;
     $insert['periodo']=$value->periodo;
     $insert['serie']=(string)$value->serie;
     $insert['renovacion']=$value->renovacion;
     $insert['status_TXT']=(string)$value->status_TXT;
     $insert['primaNeta']=$value->primaNeta;
     $insert['recargos']=$value->recargos;
     $insert['derechos']=$value->derechos;
     $insert['impuesto1']=$value->impuesto1;
     $insert['primaTotal']=$value->primaTotal;
     $insert['comision0']=$value->comision0;
     $insert['comision1']=$value->comision1;
     $insert['comision2']=$value->comision2;
     $insert['comision3']=$value->comision3;
     $insert['comision4']=$value->comision4;
     $insert['comision5']=$value->comision5;
     $insert['anterior']=(string)$value->anterior;
     $insert['grupo']=(string)$value->grupo;
     $insert['subGrupo']=(string)$value->subGrupo;
     $insert['cCobro_TXT']=(string)$value->cCobro_TXT;
     $insert['statusDoc_TXT']=(string)$value->statusDoc_TXT;
     $insert['concepto']=(string)$value->concepto;
     $insert['nombreCompleto']=(string)$value->nombreCompleto;
     $insert['email1']=(string)$value->email1;     
     $insert['telefono1']=(string)$value->telefono1;
     $insert['nombreCompania']=(string)$value->nombreCompania;
     //$insert['ciaAbreviacion']=(string)$value->;
     $insert['ejecutNombre']=(string)$value->ejecutNombre;
     $insert['vendNombre']=(string)$value->vendNombre;
     $insert['fPago']=(string)$value->fPago;
     $insert['moneda']=(string)$value->moneda;
     $insert['sRamoNombre']=(string)$value->sRamoNombre;
     $insert['ramosNombre']=(string)$value->ramosNombre;
     $insert['tipoDocto_TXT']=(string)$value->tipoDocto_TXT;     
     $insert['abreviacionVend']=(string)$value->abreviacionVend;
     $insert['IDVend']=$value->IDVend;
     $insert['TCPago']=(double)$value->TCPago;
     $insert['IDRecibo']=(string)$value->IDRecibo;
     $insert['IDDocto']=(string)$value->IDDocto;
     $insert['DespNombre']=(string)$value->DespNombre;
     $v3->insert('reportecobranzaclientes',$insert);
   }
   if($informacion['actualizacionesTabla']!='')
   {
      $insertar['nombreTabla']='reportecobranzaclientes';
      $insertar['fechaActualizacion']=$fechaActualizacion;
      $v3->insert('actualizacionestablas',$insertar);
   }

  }
}

//--------------------------------------------------------------------------------------------------------------------------------------------------
function pagoCompania(){
$this->load->library("WS_Sicas"); 
$this->load->model('reportes_model'); 
$fechaActual=date('Y').'-'.date('m').'-'.date('d');
//$fechaInicio=strtotime('01-11-2019');//strtotime("31-12-2019");
//$fechaFin=strtotime('30-11-2019');//strtotime($fechaActual);//strtotime("2-12-2020");
//$fechaActual='2020-10-31';
$fecha="";$mes="";$anio="";
//$v3=$this->load->database('V3',true);
$v3=$this->load->database('default',true);
$fechaInicioDigito=strtotime($v3->query('select (max(pc.VDatPagosRec)) as ultimaFecha from pagocompania pc')->result()[0]->ultimaFecha);
$fechaInicio=$fechaInicioDigito+86400;
//$fechaInicio=date("d/m/Y", $fechaInicioDigito);
$fechaFin=strtotime($fechaActual);
 
for($i=$fechaInicio; $i<$fechaFin; $i+=86400){
    $fecha=date("Y-m-d", $i);
    $fechaConsultaSicas=date("d/m/Y", $i);
    $mes=date("m", $i);
    $anio=date("Y", $i);
    $recibos="";
    $recibos=$this->ws_sicas->obtenerRecibosPorFechaDia($fechaConsultaSicas,$fechaConsultaSicas,null);                   
   $companias=$v3->query("select *,0 as primaNetaPC,0 as comisionGeneradaPC from catalog_promotorias order by Promotoria")->result();
   foreach ($recibos->TableInfo as $value) 
 { 
 
  foreach ($companias as  $valueCompania) 
  {  
    if($valueCompania->idPromotoria==$value->IDCia)
    {
     $valueCompania->primaNetaPC=(double)$valueCompania->primaNetaPC+((double)$value->PrimaNeta*(double)$value->TCPago);
     $valueCompania->comisionGeneradaPC=(double)$valueCompania->comisionGeneradaPC+(((double)$value->Comision0+(double)$value->Comision1+(double)$value->Comision2+(double)$value->Comision3+(double)$value->Comision4)*(double)$value->TCPago);
     break;
    }
  }     
      }
             
        foreach ($companias as  $value) { 
      $insert['idPromotoriaCP']= $value->idPromotoria;
      $insert['anioPC']=$anio;
      $insert['mesPC']=$mes; 
      $insert['VDatPagosRec']=$fecha;
      $insert['primaNetaPC']=$value->primaNetaPC;
      $insert['comisionGeneradaPC']=$value->comisionGeneradaPC ;     
      $v3->insert('pagocompania',$insert);  
 }
}

}

//--------------------------------------------------------------------------------------------------------------------------------------------------
function clientes()
{
   $this->load->library("WS_Sicas"); 
   $clientes=$this->ws_sicas->obtenerClientePorID(null);
        
   // $clientes=$this->ws_sicas->obtenerClientePorID(33448);
       
   foreach ($clientes->TableInfo as  $value) 
   {
    $info="";
    $consulta='select (count(clp.IDCli)) as total from clientelealtadpuntos clp where clp.IDCli='.$value->IDCli;
       $info=$this->db->query($consulta)->result();
       //$update['IDCli']=(int)$value->IDCli; 
       $update="";      
    if($info[0]->total==0){
            $update['IDCli']=(int)$value->IDCli;
       $update['NombreCompleto']=(string)$value->NombreCompleto;
       $update['nombreCliente']=(string)$value->NombreCompleto;
       $update['Telefono1']=(string)$value->Telefono1;
       $update['idContacto']=(int)$value->IDCont;
       $update['EMail1']=(string)$value->EMail1;
       $update['ApellidoP']=(string)$value->ApellidoP;
       $update['ApellidoM']=(string)$value->ApellidoM;
       $update['Nombre']=(string)$value->Nombre;
       $update['RFC']=(string)$value->RFC;
       $update['Sexo']=(int)$value->Sexo;
       $update['tipoEntidad']=(string)$value->TipoEnt_TXT;
       $update['fecha_nacimiento']=(string)$value->FechaNac;
     // $this->db->('IDCli',$value->IDCli);
      $this->db->insert('clientelealtadpuntos',$update);

    }
    else
    {
       $update['NombreCompleto']=(string)$value->NombreCompleto;
       $update['nombreCliente']=(string)$value->NombreCompleto;
       $update['Telefono1']=(string)$value->Telefono1;
       $update['idContacto']=(int)$value->IDCont;
       $update['EMail1']=(string)$value->EMail1;
       $update['ApellidoP']=(string)$value->ApellidoP;
       $update['ApellidoM']=(string)$value->ApellidoM;
       $update['Nombre']=(string)$value->Nombre;
       $update['RFC']=(string)$value->RFC;
       $update['Sexo']=(int)$value->Sexo;
       $update['tipoEntidad']=(string)$value->TipoEnt_TXT;
       $update['fecha_nacimiento']=(string)$value->FechaNac;
      $this->db->where('IDCli',$value->IDCli);
      $this->db->update('clientelealtadpuntos',$update);
    }
    

   }

   
}

//-------------------------------------------------------------------------------------------------------------------------------------------------
function actualizaClientePorActividad(){
     $this->load->library("WS_Sicas"); 
    $v3=$this->load->database('V3',true);
  $fechaActual=date('Y').'-'.date('m').'-'.date('d');
  $fechaActual='2020-02-10'; 

  $fechaActualNumerico=strtotime($fechaActual);
  $fechaConsultaNumerico=$fechaActualNumerico-259200;
  $fechaConsulta=date("Y-m-d", $fechaConsultaNumerico);
  $consulta='select distinct(idCliente) from actividades a where (a.tipoActividad="Emision" || a.tipoActividad="Endoso" ||a.tipoActividad="CambiodeConducto" ) and cast(a.fechaCreacion as date)="'.$fechaConsulta.'"';
$informacion=$v3->query($consulta)->result();
foreach ($informacion as  $value) {
  $datos=$this->ws_sicas->obtenerClientePorID($value->idCliente);
  $consulta='select (count(clp.IDCli)) as total from clientelealtadpuntos clp where clp.IDCli='.$value->idCliente;
  $info=$v3->query($consulta)->result();
  
      $info=$v3->query($consulta)->result();
         $update="";      
    if($info[0]->total==0){
       $update['IDCli']=(int)$value->idCliente;
       $update['NombreCompleto']=(string)$datos->TableInfo->NombreCompleto;
       $update['nombreCliente']=(string)$datos->TableInfo->NombreCompleto;
       $update['Telefono1']=(string)$datos->TableInfo->Telefono1;
       $update['idContacto']=(int)$datos->TableInfo->IDCont;
       $update['EMail1']=(string)$datos->TableInfo->EMail1;
       $update['ApellidoP']=(string)$datos->TableInfo->ApellidoP;
       $update['ApellidoM']=(string)$datos->TableInfo->ApellidoM;
       $update['Nombre']=(string)$datos->TableInfo->Nombre;
       $update['RFC']=(string)$datos->TableInfo->RFC;
       $update['Sexo']=(int)$datos->TableInfo->Sexo;
       $update['tipoEntidad']=(string)$datos->TableInfo->TipoEnt_TXT;
       $update['fecha_nacimiento']=(string)$datos->TableInfo->FechaNac;
     // $this->db->('IDCli',$value->IDCli);
      $v3->insert('clientelealtadpuntos',$update);

    }
    else
    {
       $update['NombreCompleto']=(string)$datos->TableInfo->NombreCompleto;
       $update['nombreCliente']=(string)$datos->TableInfo->NombreCompleto;
       $update['Telefono1']=(string)$datos->TableInfo->Telefono1;
       $update['idContacto']=(int)$datos->TableInfo->IDCont;
       $update['EMail1']=(string)$datos->TableInfo->EMail1;
       $update['ApellidoP']=(string)$datos->TableInfo->ApellidoP;
       $update['ApellidoM']=(string)$datos->TableInfo->ApellidoM;
       $update['Nombre']=(string)$datos->TableInfo->Nombre;
       $update['RFC']=(string)$datos->TableInfo->RFC;
       $update['Sexo']=(int)$datos->TableInfo->Sexo;
       $update['tipoEntidad']=(string)$datos->TableInfo->TipoEnt_TXT;
       $update['fecha_nacimiento']=(string)$datos->TableInfo->FechaNac;
      $v3->where('IDCli',$value->idCliente);
      $v3->update('clientelealtadpuntos',$update);
    }

}
       $fecha=getdate();
      $fechaHoy=$fecha['year'].'-'.$fecha['mon'].'-'.$fecha['mday'];
      $insertar['nombreTabla']='clientelealtadpuntos';
      $insertar['fechaActualizacion']=$fechaHoy;
     $v3->insert('actualizacionestablas',$insertar);


}
//-------------------------------------------------------------------
function envioCobranzaPendienteSMS()
{
  /*===================ESTE ENVIO DE MENSAJE SE EJECUTARA TODOS LOS DIAS A LAS 9 DE LA MAÑANA ES COB RANZA PENDIENTE QUE ESTE PROXIMA A VENCER SEGUN ESTE CONFIGURADO EN EL MODULO DE PERMISOS OPERATIVOS==========================================================*/
  $this->load->library("WS_Sicas"); 
  $this->load->library("WhatsSMS");
  $this->load->model('reportes_model');
  $mensaje=$this->db->query('select * from tareasprogramadas where idTareasProgramadas=1')->result(0);
  if($mensaje[0]['activo']==1)
  {
    $fechaHoy=getdate();
    $fechaActual=$fechaHoy['year'].'/'.$fechaHoy['mon'].'/'.$fechaHoy['mday']; 
    $actual = strtotime($fechaActual);
    $fecBusqueda= date("d/m/Y", strtotime ($mensaje[0]['dias']." day", $actual));
    $arrayCobranza['fechaInicial']=$fecBusqueda;
    $arrayCobranza['fechaFinal']=$fecBusqueda;
    $arrayCobranza['vendedor']='0';
    $arrayCobranza['tipoReporte']='todos';
    $arrayCobranza['tipoFecha']=$mensaje[0]['tipoFecha'];         
    $cobranzaPendiente=$this->ws_sicas->cobranzareporte($arrayCobranza);

   foreach ($cobranzaPendiente as  $value) 
   {
    $telefono=$this->comprobarNumero($value->Telefono1); 
     if($telefono!=0) 
        {


            $envioArray['numbers']=$telefono;
            $envioArray['message']=$mensaje[0]['mensaje'];
           $res= $this->whatssms->enviarAutomaticamenteSMS($envioArray);
           if($res)
           {  $insert="";
             $insert['tipoEnvioCH']='envio_sms';
             $insert['hRefCH']='ENVIO GENERADO AUTOMATICAMENTE';
             $insert['idRecibo']=$value->IDRecibo;
             $insert['idSerie']=(string)$value->Serie;
             $insert['idDocto']=$value->IDDocto;
             $insert['IDCli']=$value->IDCli;
             $insert['documento']=(string)$value->Documento;
             if(isset($value->Endoso)){$insert['endoso']=(string)$value->Endoso;}
             else{$insert['endoso']="";}
             $insert['envioDestinoCH']=$telefono;
             //$insert['linkCorto']=$linkCorto;
             $insert['idCobranzaHistorial']=-1;
             $insert['email']='avisosgap@asesorescapital.com';
             $idCobranzaHistorial=$this->reportes_model->cobranzaHistorial($insert);
           }
           
        }  
    
   }
  }

}
//-------------------------------------------------------------------
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
//-------------------------------------------------------------------
function polizasContabilidad()
{
  $this->load->library("libreriav3");$this->load->library("WS_Sicas");  $this->load->model('puntos_model');$this->load->model('personamodelo');
      /*$mes=(date('m'));$mes=$mes-1;$anio=date('Y');
     if($mes==0){$mes=12;$anio=$anio-1;}
    $fechaInicial='01/'.$mes.'/'.$anio;
    $fechaFinal=$this->devuelveUltimoDiaMes().'/'.$mes.'/'.$anio;
  $ultimoDiaMes=$this->libreriav3->devolverUltimoDiaDeMes('/','03','2019');*/
  $primerDiaMes='01/04/2020';$ultimoDiaMes='2/04/2020';
  $recibos=$this->ws_sicas->obtenerRecibosPorFecha($primerDiaMes,$ultimoDiaMes,null);

  foreach ($recibos as  $value)
  {
   $insert=null; 
   $insert['mes']=4;
   $insert['anio']=2020;
   $insert['IDRecibo']=$value->IDRecibo;
   $insert['FechaPago']=Strstr($value->FechaPago,"T",true);
   $insert['TipoDocto']=(string)$value->TipoDocto;
   $insert['FechaDocto']=Strstr($value->FechaDocto,"T",true);
   $insert['FLiquidacion']=(isset($value->FLiquidacion))? Strstr($value->FLiquidacion,"T",true) : null;
   $insert['TCPago']=$value->TCPago;
   $insert['MonedaPago']=(string)$value->MonedaPago;
   $insert['Moneda']=(string)$value->Moneda;
   $insert['Documento']=(string)$value->Documento;
   $insert['Endoso']=(isset($value->Endoso))? (string)$value->Endoso : '';
   $insert['Letra']=(isset($value->Letra))? (string)$value->Letra : '';
   $insert['Periodo']=$value->Periodo;
   $insert['Serie']=(string)$value->Serie;
   $insert['FDesde']=Strstr($value->FDesde,"T",true);
   $insert['FHasta']=Strstr($value->FHasta,"T",true);
   $insert['FLimPago']=Strstr($value->FLimPago,"T",true);
$insert['FStatus']=(isset($value->FStatus))? Strstr($value->FStatus,"T",true) : null;

   //$insert['FStatus']=Strstr($value->FStatus,"T",true);   
   $insert['Status']=$value->Status;
   $insert['Status_TXT']=(string)$value->Status_TXT;
   $insert['PrimaNeta']=$value->PrimaNeta;
   $insert['Descuento']=$value->Descuento;
   $insert['Recargos']=$value->Recargos;
   $insert['Derechos']=$value->Derechos;
   $insert['GastosAdm']=$value->GastosAdm;
   $insert['Impuesto1']=$value->Impuesto1;
   $insert['Impuesto2']=$value->Impuesto2;
   $insert['FondoInv']=$value->FondoInv;
   $insert['PrimaTotal']=$value->PrimaTotal;
   $insert['Comision0']=$value->Comision0;
   $insert['Comision1']=$value->Comision1;
   $insert['Comision2']=$value->Comision2;
   $insert['Comision3']=$value->Comision3;
   $insert['Comision4']=$value->Comision4;
   $insert['Comision5']=$value->Comision5;
   $insert['Comision6']=$value->Comision6;
   $insert['Comision7']=$value->Comision7;
   $insert['Comision8']=$value->Comision8;
   $insert['Comision9']=$value->Comision9;
   $insert['Grupo']=(string)$value->Grupo;
   $insert['SubGrupo']=(string)$value->SubGrupo;
   $insert['NombreCompleto']=(string)$value->NombreCompleto;
   $insert['CAgente']=(string)$value->CAgente;
   $insert['AgenteNombre']=(string)$value->AgenteNombre;
   $insert['VendNombre']=(string)$value->VendNombre;
   $insert['OfnaNombre']=(string)$value->OfnaNombre;
   $insert['FPago']=(string)$value->FPago;
   $insert['RamosNombre']=(string)$value->RamosNombre;
   $insert['SRamoNombre']=(string)$value->SRamoNombre;
   $insert['CCobro_TXT']=(string)$value->CCobro_TXT;
   $insert['IDDocto']=$value->IDDocto;
   $insert['DespNombre']=(string)$value->DespNombre;
   $insert['ImportePago']=$value->ImportePago;
   $insert['ImporteReal']=$value->ImporteReal;
   $insert['ImportePagoTC']=$value->ImportePagoTC;
   $insert['Renovacion']=$value->Renovacion;
   $insert['ClasCia_TXT']=(string)$value->ClasCia_TXT;
   $insert['GerenciaNombre']=(string)$value->GerenciaNombre;
   $insert['RenovacionDocto']=$value->RenovacionDocto;
   $insert['VendAbreviacion']=(string)$value->VendAbreviacion;
   $insert['EjecutNombre']=(string)$value->EjecutNombre;   
   //(isset($value->FEmisionDocto))? $insert['FEmisionDocto']=Strstr($value->FEmisionDocto,"T",true);
   //$this->db->insert('estadofinanciero',$insert);   
  }

}
//------------------------------------------------------------------
function honorarios()
{
  set_time_limit(0);
  $this->load->library("libreriav3");$this->load->library("WS_Sicas");
  $this->load->model('puntos_model');$this->load->model('personamodelo');
  $mesActual=date('m');
  $mesActual=$mesActual-1;
  $anioActual=date('Y');
  if(isset($_GET['mes']) and isset($_GET['anio'])){$mesActual=$_GET['mes'];$anioActual=$_GET['anio'];}
     if($mesActual==0){$mesActual=12;$anioActual=$anioActual-1;}
  $buscar['mes']=$mesActual;
  $buscar['anio']=$anioActual;
  $ultimoDia=$this->libreriav3->diaDeMesFinal($buscar);
  $fechaInicial='01/'.$mesActual.'/'.$anioActual;
  $fechaFinal=$ultimoDia['dia'].'/'.$mesActual.'/'.$anioActual;
  $total=$this->ws_sicas->honorarios(7,$fechaInicial,$fechaFinal,'1','1');#----  
if(isset($total->TableControl))
{

  $totalRecords=(int)$total->TableControl->MaxRecords;
  $informacion=array();
  $finBandera=$ultimoDia['dia'];
  $paginacion="";
  for($i=1;$i<=$finBandera;$i++)
   {
     $fecha=$i.'/'.$mesActual.'/'.$anioActual;#----
     $info=$this->ws_sicas->honorarios(7,$fecha,$fecha,0,0);
     if(isset($info->TableInfo)){foreach ($info->TableInfo as $value) {array_push($informacion,$value);}}    
   }
   $totalInformacion=(count($informacion));
   
   if($totalRecords==(count($informacion)))
   {  $this->db->query('delete from honorarios where mes='.$mesActual.' and anio='.$anioActual);
       foreach ($informacion as $key => $value) 
       {
         # code...       
        $insert=null; 
        $insert['mes']=$mesActual;#----
        $insert['anio']=$anioActual;#----
          $insert['IDHon']=$value->IDHon;#----
        $insert['IDVE']=$value->IDVE;#----
       $insert['Documento']=(string)$value->Documento;
       $insert['Endoso']=(isset($value->Endoso))? (string)$value->Endoso : '';
       $insert['Tipo_TXT']=(string)$value->Tipo_TXT;
       $insert['Letra']=(string)$value->Letra;
       $insert['Periodo']=$value->Periodo;
       $insert['Serie']=(string)$value->Serie; 
      $insert['TipoComVE']=(string)$value->TipoComVE;    
      $insert['TipoValor']=(string)$value->TipoValor;
      $insert['PorPart']=$value->PorPart;    
      $insert['IDMonPago']=$value->IDMonPago;    
      $insert['TCDocto']=$value->TCDocto;    
      $insert['TCPago']=$value->TCPago;    
      $insert['ImporteP']=$value->ImporteP; 
      $insert['Importe']=$value->Importe;    
      $insert['Grupo']=(string)$value->Grupo;
      $insert['SubGrupo']=(string)$value->SubGrupo;
      $insert['CCobro_TXT']=(string)$value->CCobro_TXT;
     //$insert['TipoPago']=(string)$value->TipoPago;
      $insert['Renovacion']=$value->Renovacion;     
      //$insert['FAntiguedad']=Strstr($value->FAntiguedad,"T",true);
      $insert['FAntiguedad']=(isset($value->FAntiguedad))? Strstr($value->FAntiguedad,"T",true) : null;
      $insert['FPago']=Strstr($value->FPago,"T",true);
   $insert['FLiquidacion']=(isset($value->FLiquidacion))? Strstr($value->FLiquidacion,"T",true) : null;
      $insert['FDesde']=Strstr($value->FDesde,"T",true);      
      $insert['FHasta']=Strstr($value->FHasta,"T",true);
      //$insert['FCreate']=Strstr($value->FCreate,"T",true);
      $insert['FCreate']=(isset($value->FCreate))? Strstr($value->FCreate,"T",true) : null;
      $insert['FCreacion']=Strstr($value->FCreacion,"T",true);
      $insert['FolioRec']=(string)$value->FolioRec;
      //$insert['FStatus']=Strstr($value->FStatus,"T",true);
      $insert['FStatus']=(isset($value->FStatus))? Strstr($value->FStatus,"T",true) : null;
      $insert['Status_TXT']=(string)$value->Status_TXT;
      $insert['ReferenciaPago']=(string)$value->Status_TXT;
      $insert['PrimaNeta']=$value->PrimaNeta;
      $insert['Descuento']=$value->Descuento;
      $insert['PorDesc']=$value->PorDesc;
      //$insert['ExtraPrima']=$value->ExtraPrima;
      $insert['ExtraPrima']=(isset($value->ExtraPrima))? $value->ExtraPrima : null;
      $insert['ExtraPrimaP']=(isset($value->ExtraPrimaP))? $value->ExtraPrimaP : null;
      //$insert['ExtraPrimaP']=$value->ExtraPrimaP;
      $insert['Recargos']=$value->Recargos;
      $insert['PorRecargos']=$value->PorRecargos;
      $insert['Derechos']=$value->Derechos;
      $insert['GastosAdm']=$value->GastosAdm;      
      $insert['STotal']=$value->STotal;
      $insert['Impuesto1']=$value->Impuesto1;
      $insert['Impuesto1']=$value->PorImp1;
      $insert['Impuesto2']=$value->Impuesto2;
      $insert['PrimaTotal']=$value->PrimaTotal;
      //$insert['ComPagada']=$value->ComPagada;
      $insert['ComPagada']=(isset($value->ComPagada))? $value->ComPagada : null;
         $insert['Comision0']=$value->Comision0;
   $insert['Comision1']=$value->Comision1;
   $insert['Comision2']=$value->Comision2;
   $insert['Comision3']=$value->Comision3;
   $insert['Comision4']=$value->Comision4;
   $insert['Comision5']=$value->Comision5;
   $insert['Comision6']=$value->Comision6;
   $insert['Comision7']=$value->Comision7;
   $insert['Comision8']=$value->Comision8;
   $insert['Comision9']=$value->Comision9;
      $insert['PorCom0']=$value->PorCom0;
   $insert['PorCom1']=$value->PorCom1;
   $insert['PorCom2']=$value->PorCom2;
   $insert['PorCom3']=$value->PorCom3;
   $insert['PorCom4']=$value->PorCom4;
   $insert['PorCom5']=$value->PorCom5;
   $insert['PorCom6']=$value->PorCom6;
   $insert['PorCom7']=$value->PorCom7;
   $insert['PorCom8']=$value->PorCom8;
   $insert['PorCom9']=$value->PorCom9;
      $insert['Concepto']=(string)$value->Concepto;    
      $insert['NombreCompleto']=(string)$value->NombreCompleto;      
      $insert['SRamoNombre']=(string)$value->SRamoNombre;
      $insert['SRamoAbreviacion']=(string)$value->SRamoAbreviacion;
      $insert['VendNombre']=(string)$value->VendNombre;
      $insert['VendAbreviacion']=(string)$value->VendAbreviacion;
      $insert['AgenteNombre']=(string)$value->AgenteNombre;
      $insert['FormaPago']=(string)$value->FormaPago;
      $insert['Moneda']=(string)$value->Moneda;
      $insert['MonedaP']=(string)$value->MonedaP;
      $insert['TipoHon']=(string)$value->TipoHon;
      $insert['DoctoPago']=(string)$value->DoctoPago;
      $insert['FolioLiq']=(string)$value->FolioLiq;
      $insert['NLiquidacion']=(string)$value->NLiquidacion;
      $insert['Ramo']=(string)$value->Ramo;
      $insert['DespNombre']=(string)$value->DespNombre;
      $insert['IDRecibo']=$value->IDRecibo;
      $insert['IDDocto']=$value->IDDocto;
      $insert['CCobro_TXT']=(string)$value->CCobro_TXT;
      $insert['TCPago']=$value->TCPago;
      $insert['Moneda']=(string)$value->Moneda;      
      $insert['FondoInv']=$value->FondoInv;
      $insert['CAgente']=(string)$value->CAgente;
      $insert['OfnaNombre']=(string)$value->OfnaNombre;
      $insert['GerenciaNombre']=(string)$value->GerenciaNombre;
      $insert['VendAbreviacion']=(string)$value->VendAbreviacion;
      $insert['EjecutNombre']=(string)$value->EjecutNombre; 
 
       //$v3=$this->load->database('V3',true);              
        //$v3->insert('honorarios',$insert);

       $this->db->insert('honorarios',$insert);   
   }
 
    //$this->enviarMensualAgentesOtros();
    //$this->enviarAgentesBronceMensual();

   }
   else
   {

   }
  
 }

//echo "La ejecucion ha finalizado";


}
function honorarios2()
{
    set_time_limit(0);
  $this->load->library("libreriav3");$this->load->library("WS_Sicas");$this->load->model('puntos_model');$this->load->model('personamodelo');
  $mesActual=date('m');
  $mesActual=$mesActual-1;
  $anioActual=date('Y');
     if($mesActual==0){$mesActual=12;$anioActual=$anioActual-1;}
  $buscar['mes']=$mesActual;
  $buscar['anio']=$anioActual;
  $ultimoDia=$this->libreriav3->diaDeMesFinal($buscar);
  $fechaInicial='01/'.$mesActual.'/'.$anioActual;
  $fechaFinal=$ultimoDia['dia'].'/'.$mesActual.'/'.$anioActual;
  $total=$this->ws_sicas->honorarios(7,$fechaInicial,$fechaFinal,'1','2000');#----
  

}
//-----------------------------------------------------------------
function depuracionAutomaticaDeActividades()
{
  set_time_limit(0);
  $consulta='select * from actividades a  where a.`Status`=1 and (a.tipoActividad="Emision" || a.tipoActividad="Endoso" || a.tipoActividad="Sustitucion"  || a.tipoActividad="CambiodeConducto" || a.tipoActividad="Cotizacion")';

  $respuesta=$this->db->query($consulta)->result();
  
  /*======ACTIVIDADES DEL LADO DEL AGENTE==========*/
   foreach ($respuesta as $key => $value) 
   {
    $consulta='select a.* from actividadespartidas a where a.idPartida=(select max(idPartida) from actividadespartidas where idInterno='.$value->idInterno.')';
    $resp=$this->db->query($consulta)->result();
     $tipo=$value->tipoActividad;
    if((count($resp)>0)) 
    {  
     //if($resp[0]->motivoCambio==1)
     // {
       $date1 = new DateTime($resp[0]->fechaGrabado);  $date2 = new DateTime("now");  $diff = $date1->diff($date2);    
       $bandCerrado=0;
       if($diff->y>=1 || $diff->m>1){$bandCerrado=1;}
     else
     {
       $diasCant=$diff->d;  $diasMenos=0;      
       for($i=1;$i<=$diasCant;$i++)
       {       
         $dias = date("Y-m-d", strtotime($i." day", strtotime($resp[0]->fechaGrabado)));
         $diasFecha=getdate(strtotime($dias));
         if($diasFecha['wday']==0 || $diasFecha['wday']==6){$diasMenos++;}        
       }
       
       if($tipo=='Emision' || $tipo=='Endoso' || $tipo=='Sustitucion' || $tipo=='CambiodeConducto' )
       {
        if($resp[0]->motivoCambio==1)
        {
         if($diasCant-$diasMenos>=1){$bandCerrado=1;}
        }
       }
       else{if($diasCant-$diasMenos>=30){$bandCerrado=1;}}
      
      }              
      if($bandCerrado)
      {            
       $insert['idInterno']=$value->idInterno;
       $insert['tipoActividad']=$tipo;
       $insert['fechaGrabado']=$resp[0]->fechaGrabado;
       $insert['folioActividad']=$value->folioActividad;
       $insert['fechaCreacion']=$value->fechaCreacion;
       $this->db->insert('actividadescerrados',$insert);
       $actualizar = "Update `actividades` set `Status`= '6',comentarioTemporal='cierre automatico',depuracionAutomatica='1' Where `idInterno`=".$value->idInterno." limit 1";;
       $this->db->query($actualizar);
       
      }
      else
      {
 
      }
    // }
    }
    else
    {
      //$fp = fopen('resultadoJason.txt', 'a');fwrite($fp, print_r($value->idInterno.'Investigar-',TRUE));fclose($fp); 
    }
   }

}
//--------------------------------------------------------------
function actividadesRestablecer()
{
  $consulta='select ac.*,a.`Status`,a.comentarioActividad,a.comentarioTemporal,a.depuracionAutomatica,a.fechaCreacion from actividadescerrados ac left join actividades a on a.idInterno=ac.idInterno where cast(a.fechaCreacion as date)>="2020-06-01"';
  $datos=$this->db->query($consulta)->result();
foreach ($datos as $key => $value) {
                $actualizar = "Update `actividades` set `Status`= '1',comentarioTemporal='',depuracionAutomatica='0' Where `idInterno`=".$value->idInterno;
             $this->db->query($actualizar);
              
              $actualizarAC='update actividadescerrados set fechaCreacion="'.$value->fechaCreacion.'"';
              $this->db->query($actualizarAC);
              //print_r($value);
}
  
}

//-------------------------------------------------------------
public function envioCorreosMarketing(){
  $v3=$this->load->database('V3',true);
  $correosPendientesEnviar=$v3->query("select * from envio_correos where status=0 and desde='JIMENEZ ABURTO CLAUDIA <MARKETING@AGENTECAPITAL.COM>' limit 6 ")->result();    

  $cantidad=count($correosPendientesEnviar);         
      if($correosPendientesEnviar != FALSE){
        $this->load->library('email');
        $config['protocol'] = 'smtp';
        $config['smtp_host'] = 'agentecapital.com';///usr/sbin/sendmail';

                        $config['smtp_user'] = 'avisosmarketing@asesorescapital.com';
        $config['smtp_pass'] = 'avisosmarketing2020';
        $config["smtp_port"] = '587';
         $config['charset'] = 'utf-8';
         $config['wordwrap'] = TRUE;
         $config['validate'] = true;
       $prueba= $this->email->initialize($config);     
  
        for($i=0;$i<$cantidad;$i++){       
         $fromNombre = strstr($correosPendientesEnviar[$i]->desde, '<', true);
         $fromEmail = trim(substr(strstr($correosPendientesEnviar[$i]->desde, "<"), 1),'>');
               $this->email->from('avisosgap@asesorescapital.com',$fromNombre);
        $this->email->subject('Here is your info '. $fromNombre);
             $this->email->to($correosPendientesEnviar[$i]->para);
                 $this->email->subject($correosPendientesEnviar[$i]->asunto);
            $this->email->message($correosPendientesEnviar[$i]->mensaje);        
               if($this->email->send()){
 
               $actualizar="update envio_correos set status=1 where idCorreo=".$correosPendientesEnviar[$i]->idCorreo;
         $v3->query($actualizar);
  
         
        }
        else
        {               $actualizar="update envio_correos set status=1 where idCorreo=".$correosPendientesEnviar[$i]->idCorreo;
         $v3->query($actualizar);
              //$fp = fopen('erroresEmail.txt', 'a');fwrite($fp, print_r($this->email->print_debugger(),TRUE));fclose($fp);
        }
        }
      }
             $v3=$this->load->database('V3',false);

}
//----------------------------------------------------------



public function envioCorreosDennis(){
/*========================ENVIA CADA 5 MINUTOS LOS CORREO QUE LLEGAN AL================================*/
     //ini_set('smtp_port',25);
    // ini_set('smtp_host','ssl://smtp.agentecapital.com');
     //ini_set('protocol','smtp');
        /*$config = Array('protocol' => 'smtp','smtp_host' => 'mail.agentecapital.com','smtp_port' => 587,'smtp_user' => 'desarrollo@agentecapital.com', 'smtp_pass' => 'omarceja2018', 'mailtype' => 'html','charset' => 'iso-8859-1','wordwrap' => TRUE);
       $this->load->library('email',$config);
        $this->email->from('Capsys Web<do-not-reply@capsys.com.mx>');
     // $this->email->to('desarrollo@agentecapital.com');
      $this->email->to('luceme_23@yahoo.com');
      $this->email->subject("Actividad Importante ");
      $this->email->message('no pasa nada');
      /* Send Mail */
      /*$this->email->send();
      var_dump($this->email->print_debugger());*/
      $config['protocol'] = 'SMTP';
       $config['smtp_host'] = 'mail.capitalseguros.mx';        
       $config['smtp_user'] = 'test1@capitalseguros.mx';
       $config['smtp_pass'] = 'capital*.1';        
       $config["smtp_port"] = '587';
       $config['charset'] = 'UTF-8';
       //$config['charset'] = 'iso-8859-1';
       $config['wordwrap'] = TRUE;
       $config['validate'] = TRUE;
       $config['smtp_timeout'] = '40';
       $config['mailtype'] = 'html';
       #$config['newline']  = "\r\n";
        //$config['smtp_crypto']  = "ssl";
       $this->email->initialize($config);               
       $this->email->from('test1@capitalseguros.mx','Omar');
       $this->email->subject('Here is your info ');
            // $this->email->to('desarrollo@agentecapital.com');
      //$this->email->to('test2@capitalseguros.mx');
             $this->email->to('luceme_23@yahoo.com');
                 $this->email->subject('hola omar');
            $this->email->message('Prueba3');        
               
               $this->email->send();
               
                var_dump($this->email->print_debugger());
               
 

}
//---------------------------------------
public function envioCorreosDennis2()
{
    $config['protocol'] = 'sendmail';
        $config['mailpath'] = '/usr/sbin/sendmail';
        $config['charset'] = 'iso-8859-1';
        $config['wordwrap'] = TRUE;
        $config['mailtype'] = 'html';
    $this->load->library('email',$config);
            //  $this->CI->email->from("desarrollo@agentecapital.com", "Desarrollo");
              $this->CI->email->from("desarrollo@agentecapital.com", "Desarrollo");
          $this->CI->email->to("gerenteoerativo@agentecapital.com");
          //$this->CI->email->bcc("juanjose@dre-learning.com");
              $this->CI->emapil->subject("Semaforos Rojos");
              $this->CI->email->message($message);  
}
//-------------------------------------
function g()
{
  var_dump('ejemplo');
}
//------------------------------------
function pruebaDeCobranza()
{
set_time_limit(0);
 $this->load->library("ws_sicasomar"); 
  $array['fechaInicial']='25-09-2020';
  $array['fechaFinal']='30-09-2020';
  $array['filtroGrupo']=[10,14,16,3,1];
  $array['filtroDespacho']=[1,2,4,5,6,7,8,9];
  $array['filtroGerencia']=[5,6,9];
  $array['filtroRamo']=[1,2,3,4];
  $array['tipoReporte']='institucional';
  $array['tipoFecha']='FLimPago';/*FDesde,FHasta,FLimPago,FGeneracion,FStatus*/
  //$array['']
  
  $respuesta=$this->ws_sicasomar->recibosClientes($array);  
  var_dump($respuesta);
    
}
//----------------------------------------------------
//Envio de correos de felicitación de cumpleaños.
function avisoCumpleanio_tareaprogramada(){

  $this->load->model("personamodelo");
  $this->load->library("imgedit_cenis");
  $this->load->library("mailjet_api");;

  //date_default_timezone_set('America/Mexico_City');
  date_default_timezone_set('America/Mexico_City');

  $personas=$this->personamodelo->obtenerTodasLasPersonas();

  $dia=date("d"); //$_GET["dia"];
  $mes=date("n"); //$_GET["mes"];

  $festejados=array();

  if(!empty($_GET["dia"]) && !empty($_GET["dia"])){
      $dia=$_GET["dia"];
      $mes=$_GET["mes"];
  }

  $lunes_a_viernes=array(1,2,3,4,5);

  $pp=array();

  if(!empty($personas)){
    foreach($personas as $aa){
          
      if(empty($aa->fechaNacimiento)){
        $aa->fechaNacimiento="0000-00-00";
      }

      $f_c=explode("-",$aa->fechaNacimiento);
      $_dia=$f_c[2];
      $_mes=$f_c[1];

      $_datos_hb=array();
      
      //array_push($festejados,$_festejado);
      //$img_p_hb=base_url()."assets/"

      $_datos_hb["to"]=$aa->email;//emailUsers;
      $_datos_hb["titulo"]="¡Feliz Cumpleaños ".$aa->nombres."!";

      $mensaje="<html>
        <head>
        </head>
          <body>
            <div>
              <p style='font-family: helvetica; color: #2155B5; font-weight: bold'>Estimado ".$aa->nombres.":</p>
              <p style='font-family: helvetica; color: #2155B5; font-weight: bold'>Sabemos que el día de hoy es un día especial e importante, por lo que la Familia Capital Seguros y Fianzas quiere felicitarte esperando que disfrutes cada instante acompañado de tu familia y compañeros en la distancia.</p>
              <h2 style='font-family: helvetica; color: #2155B5; font-weight: bold'>¡Feliz Cumpleaños!<h2>
              <div style='margin-top: 30px'>
                <img src=\"cid:id1\"></img>  
              </div>
            </div>
          </body>
        </html>";
        //<img src=\'cid:id".$aa->idPersona."\'></img> 

      $_datos_hb["mensaje"]=$mensaje; //\'".base_url()."assets/plantillas_hb/".$mes.$dia."/".$aa->idPersona."_hb.png'
      $_datos_hb["nombre_archivo"]=$aa->idPersona."_hb.png";
      $_datos_hb["id_enbeded"]=$aa->idPersona;

      $fecha_cumple=date("N", mktime(0,0,0,$_mes,$_dia,date("Y")));
      $fecha_cumple_=date("Y-m-d", mktime(0,0,0,$_mes,$_dia,date("Y")));
      $semana=date("W", mktime(0,0,0,$_mes,$_dia,date("Y")));

      //Si el día de la iteración es igual al día actual y la fecha pertenece a la semana actual 
      //y si el día de iteración esta dentro del rango de lunes - 1 a viernes - 5.
      if($semana == date("W") && in_array($fecha_cumple,$lunes_a_viernes) && $dia == $_dia){ //Identifica si el día y el mes actual corresponde al de la persona.
        //$dia==$_dia && $mes==$_mes && in_array($fecha_cumple,$lunes_a_viernes)
        /*array_push($pp_,array(
          $fecha_cumple_ => $aa->nombres,
          "semana" => date("W", mktime(0,0,0,$_mes,$_dia,date("Y"))),
          "dia" => date("l", mktime(0,0,0,$_mes,$_dia,date("Y"))),
          "correo" => $aa->email
        ));*/

        $pp=$this->imgedit_cenis->crear_img_edit($aa,intval($_dia),intval($_mes)); //Ruta del archivo. Y ejecución de libreria de imagen.

        $_festejado=new stdClass; //Festejados
        $_festejado->nombre_festejado = ucwords($aa->nombres)." ".ucwords($aa->apellidoPaterno)." ".ucwords($aa->apellidoMaterno);
        $_festejado->idPersona= $aa->idPersona;

        array_push($festejados,$_festejado);

        $_datos_hb["ruta_archivo"]=$_SERVER["DOCUMENT_ROOT"]."/V3/assets/plantillas_hb/".intval($_mes).intval($_dia)."/".$aa->idPersona."_hb.png";//$aa->idPersona; //$_SERVER["DOCUMENT_ROOT"]."/V3/ --
        $_datos_hb["encode_base64"]=base64_encode(file_get_contents($_SERVER["DOCUMENT_ROOT"]."/V3/assets/plantillas_hb/".intval($_mes).intval($_dia)."/".$aa->idPersona."_hb.png")); //$aa->idPersona."_hb.png"; --
        //Ruta localhost: $_SERVER["DOCUMENT_ROOT"]."/Capsys/www/V3/assets/plantillas_hb/".$mes.$dia."/".$aa->idPersona."_hb.png"
        //var_dump($_datos_hb);

        if(filter_var($aa->email, FILTER_VALIDATE_EMAIL)){
         
          $emm=$this->mailjet_api->ejecuta_api_envio_de_correos($_datos_hb); //Ejecuta la api de correos.
          //var_dump($emm);
          //var_dump("Es valida ".$aa->email);
        } 
        
        //echo date("N", mktime(0,0,0,$_mes,$_dia,date("Y")));
      } 
      //Si en mes de iteración es igual al actual a su vez el día es 6 o 7, que sea viernes 
      //y la fecha de iteración sea de la semana actual semana 42 (L - D)
      elseif(!in_array($fecha_cumple,$lunes_a_viernes) && date("N") == 5 && $semana == date("W")){
        /*array_push($pp_,array(
          $fecha_cumple_ =>$aa->nombres,
          "semana" => date("W", mktime(0,0,0,$_mes,$_dia,date("Y"))),
          "dia" => date("l", mktime(0,0,0,$_mes,$_dia,date("Y"))),
          "correo" => $aa->email
        ));*/

        $pp=$this->imgedit_cenis->crear_img_edit($aa,intval($_dia),intval($_mes)); //Ruta del archivo. Y ejecución de libreria de imagen.
        
        $_festejado=new stdClass; //Festejados
        $_festejado->nombre_festejado = ucwords($aa->nombres)." ".ucwords($aa->apellidoPaterno)." ".ucwords($aa->apellidoMaterno);
        $_festejado->idPersona= $aa->idPersona;

        array_push($festejados,$_festejado);

        $_datos_hb["ruta_archivo"]=$_SERVER["DOCUMENT_ROOT"]."/V3/assets/plantillas_hb/".intval($_mes).intval($_dia)."/".$aa->idPersona."_hb.png";//$aa->idPersona; //$_SERVER["DOCUMENT_ROOT"]."/V3/ --
        $_datos_hb["encode_base64"]=base64_encode(file_get_contents($_SERVER["DOCUMENT_ROOT"]."/V3/assets/plantillas_hb/".intval($_mes).intval($_dia)."/".$aa->idPersona."_hb.png")); //$aa->idPersona."_hb.png";  --
        //Ruta localhost: $_SERVER["DOCUMENT_ROOT"]."/Capsys/www/V3/assets/plantillas_hb/".$mes.$dia."/".$aa->idPersona."_hb.png"
        //var_dump($_datos_hb);
        if(filter_var($aa->email, FILTER_VALIDATE_EMAIL)){

          $emm_=$this->mailjet_api->ejecuta_api_envio_de_correos($_datos_hb); //Ejecuta la api de correos.
          //var_dump($emm_);
          //var_dump("es valida ".$aa->email); 
        }
        
      }
    }
  }

  //var_dump($pp_);
  if(!empty($festejados)){

    $this->generaNotificacionCumpleanio($festejados,$mes,$dia);

  }
}
//----------------------------------------------------
function generaNotificacionCumpleanio($datos_festejados,$mes,$dia){

  $this->load->model("personamodelo", "persona");
  $this->load->model("notificacionmodel", "notificacion");

  $array_insert=array();
  $validador_agentes=array();
  $mensaje="Felicita a nuestros compañeros ";

  foreach($datos_festejados as $dato_cumplaniero){

    $mensaje.=$dato_cumplaniero->nombre_festejado.", ";
    array_push($validador_agentes, $dato_cumplaniero->idPersona);
  }

  $mensaje.="en su día de cumpleaños.";

  $array_insert["mensaje"] = trim($mensaje, ",");
  $array_insert["anio"] = date("Y");
  $array_insert["mes"] = $mes;
  $array_insert["dia"] = $dia;

  $notificacion_cumple=$this->persona->generaNotificacionCumpleanio($array_insert); //Guarda el aviso de cumpleaño en db y regresa el ID.

  $personas=$this->personamodelo->obtenerTodasLasPersonas();

  if(!empty($personas)){

    foreach($personas as $datos_personales){

      if(!in_array($datos_personales->idPersona, $validador_agentes)){

        $us=array();
        $data=new stdClass;
        $data->idPersona=$datos_personales->idPersona;
        $data->email=$datos_personales->email;
        $us[0]=$data;


        $this->notificacion->add($us, "email", "ENVIADO", "FELICITACION", "CUMPLEANIO", array("evaluacion_id" => $notificacion_cumple));
      } else{

        $this->personamodelo->crearRelacionFelicitacionPersona(array("idPersona_cumpleanio" => $datos_personales->idPersona, "id_notificacion_cumpleanio" => $notificacion_cumple));
      }

    }
  }

  echo $notificacion_cumple;
}
//----------------------------------------------------
function semaforoActividades()
{
 
  $respuesta=$this->verificarHorarioLaboral();
  
  if($respuesta['ejecutaRobot'])
  {
   
   $consulta='select * from actividades a where a.`Status` in (5,2)';
   $actividades=$this->db->query($consulta)->result();   

   foreach ($actividades as $value) 
   {
    $actualizar="update actividades set incrementoSemaforo=ADDDATE(incrementoSemaforo, INTERVAL '0 0 5' DAY_MINUTE),semaforoIncremento=ADDTIME(semaforoIncremento,'00:05:00') where idInterno=".$value->idInterno;
    //$fp =fopen('resultadoJason.txt', 'a');fwrite($fp, print_r($actualizar.';', TRUE));fclose($fp); 
    $this->db->query($actualizar);
   }
  }
  else
  {
    
  }

}
//---------------------------------------------------------------------------------------
function verificarHorarioLaboral()
{
  $respuesta=array();
  $respuesta['ejecutaRobot']=true;
   $consulta='select now(),(DAYOFWEEK(cast(now() as date))) as diaSemana,DATE_FORMAT(NOW( ), "%H:%i:%S" ), (if(DATE_FORMAT(NOW( ), "%H:%i:%S" )>"18:00:00",true,false)) as mayor18horas, (if(DATE_FORMAT(NOW( ), "%H:%i:%S" )<"09:00:00",true,false)) as menor09horas, (select dr.estaFuncionando from tareasrobot dr where dr.tipoRobot="semaforoActividad") as estadoRobot,(select count(d.diaNoLaboral) from dianolaboral d where d.diaNoLaboral=cast(now() as date)) as diaNoLaboral';
   $info=$this->db->query($consulta)->result()[0];
   if($info->mayor18horas)
    {$respuesta['ejecutaRobot']=false;
      if(!$info->estadoRobot)
      {
       $actualizar['estaFuncionando']=1;
       $this->db->where('tipoRobot','semaforoActividad');
       $this->db->update('tareasrobot',$actualizar);
      }
    }
   if($info->menor09horas){$respuesta['ejecutaRobot']=false;}
   if(!$info->estadoRobot){$respuesta['ejecutaRobot']=false;}
   if($info->diaNoLaboral>0){$respuesta['ejecutaRobot']=false;}
   if($info->diaSemana==1 || $info->diaSemana==7 ){$respuesta['ejecutaRobot']=false;}
  
  return $respuesta;

}
    
   
    //***Miguel Jaime 29-04-2021
     //Segmenta las renovacion de ejecutivos LineaPersonales en: Accidentes y Enfermedades y Vida

    function verificarRenovacionLineasPersonales($IDDocto){
      $sql="SELECT * from renovacionlineaspersonales where IDDocto='$IDDocto'";
      return $this->db->query($sql)->result();
    }

    function getRenovacionVida($IDDocto){
        $this->load->library('ws_sicas');
        $mes=date('m');$year=date('Y');
        $fechaI='01/'.$mes.'/'.$year;
        $fechaF=date("d/m/Y");
        $vendedor=$this->tank_auth->get_IDVend();
        $row=$this->ws_sicas->obtenerRenovacionesFecha($vendedor,$fechaI,$fechaF,$IDDocto,'0');
        if($row[0]->RamosNombre=="Vida"){
          return 0;
        }else {
          return 1;
        }
    }
  //-----------------------------------------------------------
    function segmentarRenovacionesLineasPersonales(){
       $mes=date('m');$year=date('Y');
       $sql="SELECT * from renovacion where  MONTH(fechaInsersion)='$mes' AND YEAR(fechaInsersion)='$year' AND EjecutNombre='LINEAS PERSONALES' ORDER BY FDesde DESC";
           $renovaciones=$this->db->query($sql)->result();
     foreach ($renovaciones as $row) {
          if(!($this->verificarRenovacionLineasPersonales($row->IDDocto))){
              $ramo=$this->getRenovacionVida($row->IDDocto);
              if($ramo==0){
                $sqlX="INSERT INTO renovacionlineaspersonales(IDDocto,RamosNombre) VALUES('$row->IDDocto','Vida')";
                 $this->db->query($sqlX);
              }else{
                 $sqlX="INSERT INTO renovacionlineaspersonales(IDDocto,RamosNombre) VALUES('$row->IDDocto','Accidentes y Enfermedades')";
                  $this->db->query($sqlX);
              }
          }
      }
    }
//----------------------------------------------------
function asignaCobranzaKpi($idPersona,$reporte,$tipoReporte){

  //$tipoReporte = PrimaYComision ó Cobranza
  //$reporte = institucional, etc.
  $this->load->model("crmproyecto_model");
  
  try{

    $tipoReport=array();
    array_push($tipoReport, strtolower($tipoReporte) == "prima_comision" ? explode("_",$tipoReporte) : array($tipoReporte));

    if(!empty($tipoReport)){
      foreach($tipoReport[0] as $pertenece){
        //$registro_reporte=$this->crmproyecto_model->devuelveRegistroCobranza($reporte,$pertenece,1);
        //var_dump($registro_reporte);
        $valida_existencia=$this->crmproyecto_model->devuelveRelacionKPI($idPersona,$reporte,$pertenece);

        if(empty($valida_existencia)){

          $registro_reporte=$this->crmproyecto_model->devuelveRegistroCobranza($reporte,$pertenece,1); //Recobra la informacion del tipo de tabla y reporte;

          if(!empty($registro_reporte)){

            $asigna=$this->crmproyecto_model->asignaRelacionKpi(array("idPersona" => $idPersona, "reporte" => $reporte, "id_referencia" => $registro_reporte->id_tipoReporte_avance, "tipo" => $pertenece));

            echo "Reporte ".$pertenece.": ". ($asigna == true ? "realizado" : "Hubo un detalle")."\n";
          }
        } else{
          echo "El registro ya existe";
        }
      }
    }

  } catch(Exception $e){
    echo "Excepcion capturada ", $e->getMessage(), "\n";
  }

  //$registro_reporte=$this->crmproyecto_model->devuelveRegistroCobranza($reporte,$tipoReporte);
  //$valida_existencia=$this->crmproyecto_model->devuelveRelacionKPI($idPersona,$reporte,$tipoReporte);
  //var_dump($tipoReport);
}
//------------------------------------ Dennis 2021-05-12 -> 2021-05-26 -> 2021-06-15 -> 2021-07-30 -> 2021-09-01
function generarAvanceCobranzaKpi(){ //[Obsoleto 2022-02-21]
  //Fecha entrada dia-mes-año Fecha final dia-mes-año. Ejemplo: 01-05-2021

  //set_time_limit(0); 
  
  date_default_timezone_set('America/Mexico_City');
  try{

    $this->load->library("ws_sicas");
    //$this->load->model("crmproyecto_model");
    
    $reportes=array(
      "institucional" => array(
        "filtros" => array(
          "filtroDespacho" => array(3), 
          "excepcionDespacho" => 1,
          "filtroRamo" =>  array(5,6), 
          "excepcionRamos" => 1,
          "filtroGrupo" => array(12),
          "excepcionGrupo" => 1,
          "filtroGerencia" => array(9), 
          "excepcionCanales" => 0,
          "filtroVendedor" => array(),
          "excepcionVendedor" => 0
        )
      ),
      "merida" => array(
        "filtros" => array(
          "filtroDespacho" => array(3), 
          "excepcionDespacho" => 1,
          "filtroRamo" =>  array(5,6), 
          "excepcionRamos" => 1,
          "filtroGrupo" => array(),
          "excepcionGrupo" => 0,
          "filtroGerencia" => array(9), 
          "excepcionCanales" => 1,
          "filtroVendedor" => array(7),
          "excepcionVendedor" => 1
        )
      ),
      "cancun" => array(
        "filtros" => array(
          "filtroDespacho" => array(3), 
          "excepcionDespacho" => 0,
          "filtroRamo" =>  array(5,6), 
          "excepcionRamos" => 1,
          "filtroGrupo" => array(),
          "excepcionGrupo" => 0,
          "filtroGerencia" => array(9), 
          "excepcionCanales" => 1,
          "filtroVendedor" => array(7),
          "excepcionVendedor" => 1
        )
      ),
      "fianzas" => array(
        "filtros" => array(
          "filtroDespacho" => array(), 
          "excepcionDespacho" => 0,
          "filtroRamo" =>  array(5), 
          "excepcionRamos" => 0,
          "filtroGrupo" => array(), //array(12),
          "excepcionGrupo" => 0, //1,
          "filtroGerencia" => array(), 
          "excepcionCanales" => 0,
          "filtroVendedor" => array(),
          "excepcionVendedor" => 0
        )
      )
    );

    $tipoReportes=array(
      "efectuada" => array("filtroStatus" => array(3,4), "tipoFecha" => "FDocto"), //filtroStatus //tipoFecha
      "pendiente" => array("filtroStatus" => array(0), "tipoFecha" => "FLimPago")
    );

    //$fechaDesde=date("d-m-Y", mktime(0,0,0,date("m"),01,date("Y")));
    //$fechaHasta=date("d-m-Y");

    $fechaDesde = !empty($_GET["fi"]) ? $_GET["fi"] : date("d-m-Y", mktime(0,0,0,date("m"),01,date("Y")));
    $fechaHasta= !empty($_GET["ff"]) ? $_GET["ff"] : date("d-m-Y", mktime(0,0,0,date("m") + 1,0, date("Y")));

    $firstDate = !empty($_GET["fi"]) ? date("Y-m-d", strtotime($_GET["fi"])) : date("Y-m-d");

    foreach($reportes as $c_nombre => $filtros){
        
      $cobranza_generada=array();

      $contador_efectuadas=0;
      $contador_pendientes=0;
      $contador_atrasadas=0;

      $sumatoria_prima_efectuadas=0;
      $sumatoria_prima_efectuadas_venta_nueva=0;
      $sumatoria_comision_efectuadas=0;
      $sumatoria_comision_efectuadas_venta_nueva=0;
      $contador_efectuadas_venta_nueva=0;

      $contador_efectuadas_subsecuentes = 0;
      $sumatoria_comision_efectuadas_subsecuentes = 0;
      $sumatoria_prima_efectuadas_subsecuentes = 0;

      $contador_cer = 0;
      $sumatoria_prima_cer = 0;
      $sumatoria_comision_cer = 0;

      $sumatoria_prima_pendiente=0;
      $sumatoria_comision_pendiente=0;

      $sumatoria_prima_pendiente_cer = 0;
      $sumatoria_comision_pendiente_cer = 0;

      $contador_pendientes_cer = 0;
      $contador_atrasadas_cer = 0;

      $contador_por_vencer = 0;
      $contador_por_vencer_cer = 0;

      $yy=0;

      $ramosArray = array();

      $clientes = array();
      $recibos_bxn = array();
      $recibos_bxn_atrasadas = array();
      //var_dump($filtros);
      foreach($tipoReportes as $tipo => $sub_sub_filtro){
            
        $filtros["filtros"]["tipoFecha"] = $sub_sub_filtro["tipoFecha"];
        $filtros["filtros"]["filtroStatus"] = $sub_sub_filtro["filtroStatus"]; //
        $filtros["filtros"]["fechaInicial"] = $fechaDesde; //$c_nombre == "fianzas" && $tipo == "pendiente" ? date("d-m-Y", mktime(0,0,0,12,1,2019)) : $fechaDesde; //$fechaDesde; //01-12-2019
        $filtros["filtros"]["fechaFinal"] = $fechaHasta; //$c_nombre == "fianzas" && $tipo == "pendiente" ? date("d-m-Y", mktime(0,0,0,date("n") + 2 ,0,date("Y"))) : $fechaHasta; // 30-06-2021
        //var_dump($c_nombre);
        //var_dump($tipo);
        //var_dump($filtros);
        
        $respuesta=$this->ws_sicas->recibosClientes($filtros["filtros"]); //Consulta a Sicas
        
        //var_dump($respuesta);
        if(array_key_exists("TableInfo", $respuesta)){ //efectuados
          foreach($respuesta->TableInfo as $datosSicas){

            //-------------Efectuados----------------------
            if((Int)$datosSicas->Status == 3 || (Int)$datosSicas->Status == 4){ //Recibos totales pagados.
              
              if((String)$datosSicas->Grupo != "GRUPO CER" && (float)$datosSicas->PrimaNeta > 0){ //Uso comercial y operativo en seguros
                  
                $contador_efectuadas++;
                $sumatoria_prima_efectuadas+=((Float)$datosSicas->PrimaNeta * (Float)$datosSicas->TCPago);
                $sumatoria_comision_efectuadas+=(((float)$datosSicas->Comision0+(float)$datosSicas->Comision1+(float)$datosSicas->Comision2+(float)$datosSicas->Comision3+(float)$datosSicas->Comision4+(float)$datosSicas->Comision5+(float)$datosSicas->Comision6+(float)$datosSicas->Comision7+(float)$datosSicas->Comision8+(float)$datosSicas->Comision9)*(Float)$datosSicas->TCPago);

                //-----------------
                //Cobranza BxN
                if($c_nombre == "merida" && ((String)$datosSicas->VendNombre == "CRUZ ALFONSO DANIEL" || (String)$datosSicas->VendNombre == "CRUZ NAMPULA RUBI")){

                  array_push($recibos_bxn, array(
                    "reporte" => $c_nombre,
                    "comision" => (((float)$datosSicas->Comision0+(float)$datosSicas->Comision1+(float)$datosSicas->Comision2+(float)$datosSicas->Comision3+(float)$datosSicas->Comision4+(float)$datosSicas->Comision5+(float)$datosSicas->Comision6+(float)$datosSicas->Comision7+(float)$datosSicas->Comision8+(float)$datosSicas->Comision9)*(Float)$datosSicas->TCPago),
                    "prima" => ((Float)$datosSicas->PrimaNeta * (Float)$datosSicas->TCPago),
                    "vend" => (Int)$datosSicas->IDVend,
                    "vendedorNombre" => (String)$datosSicas->VendNombre,
                    "tipoRecibo" => "pagado"
                  ));
                }
                //-----------------

                if((Int)$datosSicas->Periodo == 1 && (Int)$datosSicas->Renovacion == 0 && (Int)$datosSicas->RenovacionDocto==0 && $c_nombre != "fianzas"){ //Recibos nuevos seguros.
                
                  $contador_efectuadas_venta_nueva++;
                  $sumatoria_prima_efectuadas_venta_nueva+=((Float)$datosSicas->PrimaNeta * (Float)$datosSicas->TCPago);
                  $sumatoria_comision_efectuadas_venta_nueva+=(((float)$datosSicas->Comision0+(float)$datosSicas->Comision1+(float)$datosSicas->Comision2+(float)$datosSicas->Comision3+(float)$datosSicas->Comision4+(float)$datosSicas->Comision5+(float)$datosSicas->Comision6+(float)$datosSicas->Comision7+(float)$datosSicas->Comision8+(float)$datosSicas->Comision9)*(Float)$datosSicas->TCPago);

                  //--------------------------
                  //Gestión de clientes nuevos
                  //$clientes[(Int)$datosSicas->IDCli] = array(
                  //  "mes" => date("n"),
                  //  "canal" => $c_nombre
                  //);
                  //--------------------------
  
                } elseif($c_nombre == "fianzas"){ //Recibos pagados fianzas (Recibos nuevos).
  
                  $contador_efectuadas_venta_nueva++;
                  $sumatoria_prima_efectuadas_venta_nueva=$sumatoria_prima_efectuadas; //((Float)$datosSicas->PrimaNeta * (Float)$datosSicas->TCPago);
                  $sumatoria_comision_efectuadas_venta_nueva=$sumatoria_comision_efectuadas; //(((float)$datosSicas->Comision0+(float)$datosSicas->Comision1+(float)$datosSicas->Comision2+(float)$datosSicas->Comision3+(float)$datosSicas->Comision4+(float)$datosSicas->Comision5+(float)$datosSicas->Comision6+(float)$datosSicas->Comision7+(float)$datosSicas->Comision8+(float)$datosSicas->Comision9)*(Float)$datosSicas->TCPago);

                  array_push($ramosArray, array(
                    "category" => (String)$datosSicas->RamosNombre,
                    "value" => ((Float)$datosSicas->PrimaNeta * (Float)$datosSicas->TCPago))
                  );
                  //--------------------------
                  //Gestión de clientes nuevos
                  //$clientes[(Int)$datosSicas->IDCli] = array(
                  //  "mes" => date("n"),
                  //  "canal" => $c_nombre
                  //);
                  //--------------------------

                } 
                
                if((Int)$datosSicas->RenovacionDocto==0 && $c_nombre != "fianzas"){ //Recibo uno y subsecuentes
  
                  $contador_efectuadas_subsecuentes++;
                  $sumatoria_prima_efectuadas_subsecuentes += ((Float)$datosSicas->PrimaNeta * (Float)$datosSicas->TCPago);
                  $sumatoria_comision_efectuadas_subsecuentes+=(((float)$datosSicas->Comision0+(float)$datosSicas->Comision1+(float)$datosSicas->Comision2+(float)$datosSicas->Comision3+(float)$datosSicas->Comision4+(float)$datosSicas->Comision5+(float)$datosSicas->Comision6+(float)$datosSicas->Comision7+(float)$datosSicas->Comision8+(float)$datosSicas->Comision9)*(Float)$datosSicas->TCPago);

                  array_push($ramosArray, array(
                    "category" => (String)$datosSicas->RamosNombre,
                    "value" => ((Float)$datosSicas->PrimaNeta * (Float)$datosSicas->TCPago))
                  );
  
                } 
                /*if((Int)$datosSicas->RenovacionDocto==0){
                  //Aquí
                  array_push($ramosArray, array(
                    "category" => (String)$datosSicas->RamosNombre,
                    "value" => ((Float)$datosSicas->PrimaNeta * (Float)$datosSicas->TCPago)));
                }*/
              } else{ //Uso operativo en fianzas

                $contador_cer++;
                $sumatoria_prima_cer += ((Float)$datosSicas->PrimaNeta * (Float)$datosSicas->TCPago);
                $sumatoria_comision_cer += (((float)$datosSicas->Comision0+(float)$datosSicas->Comision1+(float)$datosSicas->Comision2+(float)$datosSicas->Comision3+(float)$datosSicas->Comision4+(float)$datosSicas->Comision5+(float)$datosSicas->Comision6+(float)$datosSicas->Comision7+(float)$datosSicas->Comision8+(float)$datosSicas->Comision9)*(Float)$datosSicas->TCPago);
              }
            } 
            //------------Pendientes-----------------------
            if((Int)$datosSicas->Status == 0){

              if((String)$datosSicas->Grupo != "GRUPO CER"){

                $sumatoria_prima_pendiente+=(Float)$datosSicas->PrimaNeta*(Float)$datosSicas->TCDay;
                $sumatoria_comision_pendiente+=((float)$datosSicas->Comision0+(float)$datosSicas->Comision1+(float)$datosSicas->Comision2+(float)$datosSicas->Comision3+(float)$datosSicas->Comision4+(float)$datosSicas->Comision5+(float)$datosSicas->Comision6+(float)$datosSicas->Comision7+(float)$datosSicas->Comision8+(float)$datosSicas->Comision9)*(Float)$datosSicas->TCDay;

              } else{

                $sumatoria_prima_pendiente_cer+=(Float)$datosSicas->PrimaNeta*(Float)$datosSicas->TCDay;
                $sumatoria_comision_pendiente_cer+=((float)$datosSicas->Comision0+(float)$datosSicas->Comision1+(float)$datosSicas->Comision2+(float)$datosSicas->Comision3+(float)$datosSicas->Comision4+(float)$datosSicas->Comision5+(float)$datosSicas->Comision6+(float)$datosSicas->Comision7+(float)$datosSicas->Comision8+(float)$datosSicas->Comision9)*(Float)$datosSicas->TCDay;
              }

              $yy++;

              $aa=date("d-m-Y", strtotime((String)$datosSicas->FLimPago));
              $bb=date("d-m-Y");

              $cc=(int)$aa-(int)$bb;
              //var_dump($cc);

              if($cc <= -10){

                //-----------------
                //Cobranza DxN
                if($c_nombre == "merida" && ((String)$datosSicas->VendNombre == "CRUZ ALFONSO DANIEL" || (String)$datosSicas->VendNombre == "CRUZ NAMPULA RUBI")){

                  array_push($recibos_bxn_atrasadas, array(
                    "reporte" => $c_nombre,
                    "comision" => (((float)$datosSicas->Comision0+(float)$datosSicas->Comision1+(float)$datosSicas->Comision2+(float)$datosSicas->Comision3+(float)$datosSicas->Comision4+(float)$datosSicas->Comision5+(float)$datosSicas->Comision6+(float)$datosSicas->Comision7+(float)$datosSicas->Comision8+(float)$datosSicas->Comision9)*(Float)$datosSicas->TCDay),
                    "prima" => ((Float)$datosSicas->PrimaNeta * (Float)$datosSicas->TCDay),
                    "vend" => (Int)$datosSicas->IDVend,
                    "vendedorNombre" => (String)$datosSicas->VendNombre,
                    "tipoRecibo" => "atrasado"
                  ));
                }
                //-----------------

                if((String)$datosSicas->Grupo != "GRUPO CER"){

                  $contador_atrasadas++;
                } else{
                  $contador_atrasadas_cer++;
                }

              } elseif($cc >-10 && $cc<=6){
                //$contador_pendientes++;
                if((String)$datosSicas->Grupo != "GRUPO CER"){

                  $contador_pendientes++;
                } else{
                  $contador_pendientes_cer++;
                }

              } elseif($cc > 6){

                if((String)$datosSicas->Grupo != "GRUPO CER"){

                  $contador_por_vencer++;
                } else{
                  $contador_por_vencer_cer++;
                }

              }
            }
            //-----------------------------------------
          }
        }
      }
      

      $cobranza_generada[$c_nombre]["recibos"]["recibos_efectuados"]=$contador_efectuadas;
      $cobranza_generada[$c_nombre]["recibos"]["recibos_pendientes"]=$contador_pendientes;
      $cobranza_generada[$c_nombre]["recibos"]["recibos_pendientes_cer"]=$contador_pendientes_cer;
      $cobranza_generada[$c_nombre]["recibos"]["recibos_atrasados"]=$contador_atrasadas;
      $cobranza_generada[$c_nombre]["recibos"]["recibos_atrasados_cer"]=$contador_atrasadas_cer;
      $cobranza_generada[$c_nombre]["recibos"]["recibos_por_vencer"]=$contador_por_vencer;
      $cobranza_generada[$c_nombre]["recibos"]["recibos_por_vencer_cer"]=$contador_por_vencer_cer;
      $cobranza_generada[$c_nombre]["recibos"]["recibos_efectuados_venta_nueva"]=$contador_efectuadas_venta_nueva;
      $cobranza_generada[$c_nombre]["recibos"]["recibos_efectuados_subsecuente"]=$contador_efectuadas_subsecuentes;
      $cobranza_generada[$c_nombre]["recibos"]["recibos_efectuados_grupo_cer"]=$contador_cer;

      $cobranza_generada[$c_nombre]["prima"]["efectuada"]=$sumatoria_prima_efectuadas;
      $cobranza_generada[$c_nombre]["prima"]["efectuada_venta_nueva"]=$sumatoria_prima_efectuadas_venta_nueva;
      $cobranza_generada[$c_nombre]["prima"]["efectuada_subsecuente"]=$sumatoria_prima_efectuadas_subsecuentes;
      $cobranza_generada[$c_nombre]["prima"]["efectuada_grupo_cer"]=$sumatoria_prima_cer;
      $cobranza_generada[$c_nombre]["prima"]["pendiente"]=$sumatoria_prima_pendiente;
      $cobranza_generada[$c_nombre]["prima"]["pendiente_grupo_cer"]=$sumatoria_prima_pendiente_cer;

      $cobranza_generada[$c_nombre]["comision"]["efectuada"]=$sumatoria_comision_efectuadas;
      $cobranza_generada[$c_nombre]["comision"]["efectuada_venta_nueva"]=$sumatoria_comision_efectuadas_venta_nueva;
      $cobranza_generada[$c_nombre]["comision"]["efectuada_subsecuente"]=$sumatoria_comision_efectuadas_subsecuentes;
      $cobranza_generada[$c_nombre]["comision"]["efectuada_grupo_cer"]=$sumatoria_comision_cer;
      $cobranza_generada[$c_nombre]["comision"]["pendiente"]=$sumatoria_comision_pendiente;
      $cobranza_generada[$c_nombre]["comision"]["pendiente_grupo_cer"]=$sumatoria_comision_pendiente_cer;
     
      $insert_update_data=$this->gestionaDatosDecobranza($cobranza_generada);
      $this->manageSecondGoal($ramosArray, $c_nombre, $firstDate);

      if($c_nombre == "merida"){
        $avance_bxn = $this->avanceDxN($recibos_bxn, $recibos_bxn_atrasadas);
      }
      //var_dump($insert_update_data[0] == 1 ? "Insertado" : "No insertado");
      //var_dump($c_nombre);
      //var_dump($clientes);
      //var_dump($cobranza_generada);
      //var_dump($insert_update_data);
      //var_dump($ramosArray);
    
    }
  } catch(Exception $e){

    echo "EXEPCION CAPTURADA...\n\n", $e->getMessage(), "\n";

  }
}
//-------------------------------------------
function avanceDxN($array1, $array2){

  //var_dump($array);
  //$fp =fopen('resultadoJason.txt', 'a');fwrite($fp, print_r($array, TRUE));fclose($fp);

  $newArray1 = array_reduce($array1, function($acc, $curr){

    if(array_key_exists($curr["vend"], $acc)){
      $acc[$curr["vend"]]["recibos"]++;
      $acc[$curr["vend"]]["prima"] += $curr["prima"];
      $acc[$curr["vend"]]["comision"] += $curr["comision"];

    } else{ //Inicializador de array
      $acc[$curr["vend"]]["reporte"] = $curr["reporte"];
      $acc[$curr["vend"]]["IDVend"] = $curr["vend"];
      $acc[$curr["vend"]]["recibos"] = 1;
      $acc[$curr["vend"]]["prima"] = $curr["prima"];
      $acc[$curr["vend"]]["comision"] = $curr["comision"];
      $acc[$curr["vend"]]["fechaConsulta"] = date("Y-m-d H:i:s"); //tipoRecibo
      $acc[$curr["vend"]]["tipoRecibo"] = "efectuado"; //tipoRecibo
    }
    
    return $acc;
  }, array());

  $newArray2 = array_reduce($array2, function($acc, $curr){

    if(array_key_exists($curr["vend"], $acc)){
      $acc[$curr["vend"]]["recibos"]++;
      $acc[$curr["vend"]]["prima"] += $curr["prima"];
      $acc[$curr["vend"]]["comision"] += $curr["comision"];

    } else{ //Inicializador de array
      $acc[$curr["vend"]]["reporte"] = $curr["reporte"];
      $acc[$curr["vend"]]["IDVend"] = $curr["vend"];
      $acc[$curr["vend"]]["recibos"] = 1;
      $acc[$curr["vend"]]["prima"] = $curr["prima"];
      $acc[$curr["vend"]]["comision"] = $curr["comision"];
      $acc[$curr["vend"]]["fechaConsulta"] = date("Y-m-d H:i:s");
      $acc[$curr["vend"]]["tipoRecibo"] = "atrasado"; //tipoRecibo
    }
    
    return $acc;
  }, array());
  
  $fullArray = array_merge(array_values($newArray1),array_values($newArray2));
  
  //Insert processing;
  if(!empty($fullArray)){
    $insertBatch = $this->db->insert_batch("avance_comercial_kpi_bxn", $fullArray);
  }
  //var_dump($fullArray);
}
//--------------------------------------------
function actualizaClientesNuevos($arr_){
  
  $this->load->model("clientemodelo");

  if(!empty($arr_)){

    foreach($arr_ as $idc => $data){

      $borrado = $this->clientemodelo->eliminarClienteNuevo(array(
        "IDCli" => $idc,
        "mes" => $data["mes"],
        "canal" => $data["canal"]
      ));
    
      if($borrado){
        $insertado = $this->clientemodelo->insertarClienteNuevo(array(
          "IDCli" => $idc,
          "mes" => $data["mes"],
          "canal" => $data["canal"]
        ));
      }
    }
  }
}
//--------------------------------------------
function manageSecondGoal($ary, $channel, $firsDate){
  
  $reduceCount = array_reduce($ary, function($acc, $current){

    if(array_key_exists($current["category"], $acc)){

      $acc[$current["category"]]["count"]++;
      $acc[$current["category"]]["bonus"] += $current["value"];
    } else{
      $acc[$current["category"]]["count"] = 1;
      $acc[$current["category"]]["bonus"] = $current["value"];
    } 
      return $acc;    
  }, array());

  foreach($reduceCount as $ramo => $data){
    
    $select = 'select * from meta_canal_ramo where canal="'.$channel.'" AND ramoSicas="'.strtolower($ramo).'"';
    $query = $this->db->query($select)->row();

    //var_dump($query);

    $insert = 'insert into meta_registro_avance_cantidad_y_prima(prima, cantidad, fechaRegistro, idCanalRamo) values('.$data["bonus"].', '.$data["count"].', "'.date("Y-m-d", strtotime($firsDate))." ".date("H:i:s").'", '.$query->idCanalRamo.')';
    $query_ = $this->db->query($insert);
  }

  //$select = 'select * from meta_canal_ramo where canal="" AND ramoSicas=""';
  //$getIdSecondGoal = 

  var_dump($reduceCount);
}
//--------------------------------------------
function gestionaDatosDecobranza($datos){ //[Obsoleto 2022-02-21]
  
  $this->load->model("crmproyecto_model");

  $res=array();

  if(!empty($datos)){

    foreach($datos as $reporte => $datosRegion){

      foreach($datosRegion as $tipoRecibo => $datosRecibo){

        if($tipoRecibo == "prima"){

          $valida_existencia=$this->crmproyecto_model->devuelveRegistroCobranza($reporte,$tipoRecibo,1);

          $i_u_array=array(
            "reporte" => $reporte,
            "prima_efectuada" => $datosRecibo["efectuada"],
            "prima_efectuada_venta_nueva" => $datosRecibo["efectuada_venta_nueva"],
            "prima_efectuada_subsecuente" => $datosRecibo["efectuada_subsecuente"],
            "prima_efectuada_grupo_cer" => $datosRecibo["efectuada_grupo_cer"],
            "prima_pendiente" => $datosRecibo["pendiente"],
            "prima_pendiente_grupo_cer" => $datosRecibo["pendiente_grupo_cer"],
            "fecha_consulta_sicas" => date("Y-m-d H:i:s")
          );

          if(empty($valida_existencia)){
            $inserta_avance_en_prima = $this->crmproyecto_model->insertaAvanceKPIEnPrima($i_u_array);
            $proce=$inserta_avance_en_prima == true ? "insertado" : "no insertado";

            array_push($res, array("prima" => $proce));
          } else{
            $actualiza_avance_en_prima = $this->crmproyecto_model->actualizaAvanceKPIEnPrima($i_u_array,$valida_existencia->id_tipoReporte_avance);
            $proce=$actualiza_avance_en_prima == true ? "actualizado" : "no actualizado";

            array_push($res, array("prima" => $proce));
          }
          
        } elseif($tipoRecibo == "comision"){

          $valida_existencia=$this->crmproyecto_model->devuelveRegistroCobranza($reporte,$tipoRecibo,1);

          $i_u_array=array(
            "reporte" => $reporte,
            "comision_efectuada" => $datosRecibo["efectuada"],
            "comision_efectuada_venta_nueva" => $datosRecibo["efectuada_venta_nueva"],
            "comision_efectuada_subsecuente" => $datosRecibo["efectuada_subsecuente"],
            "comision_efectuada_grupo_cer" => $datosRecibo["efectuada_grupo_cer"],
            "comision_pendiente" => $datosRecibo["pendiente"],
            "comision_pendiente_grupo_cer" => $datosRecibo["pendiente_grupo_cer"],
            "fecha_consulta_sicas" => date("Y-m-d H:i:s")
          );

          if(empty($valida_existencia)){
            $inserta_avance_en_comision = $this->crmproyecto_model->insertaAvanceKPIEnComision($i_u_array);
            $proce=$inserta_avance_en_comision == true ? "insertado" : "no insertado";

            array_push($res, array("comision" => $proce));
          } else{
            $actualiza_avance_en_comision = $this->crmproyecto_model->actualizaAvanceKPIEnComision($i_u_array,$valida_existencia->id_tipoReporte_avance);
            $proce=$actualiza_avance_en_comision == true ? "actualizado" : "no actualizado";

            array_push($res, array("comision" => $proce));
          }

        } elseif($tipoRecibo == "recibos"){

          $valida_existencia=$this->crmproyecto_model->devuelveRegistroCobranza($reporte,$tipoRecibo,1);

          $i_u_array=array(
            "reporte" => $reporte,
            "recibos_efectuados" => $datosRecibo["recibos_efectuados"],
            "recibos_efectuados_venta_nueva" => $datosRecibo["recibos_efectuados_venta_nueva"],
            "recibos_efectuados_subsecuente" => $datosRecibo["recibos_efectuados_subsecuente"],
            "recibos_efectuados_grupo_cer" => $datosRecibo["recibos_efectuados_grupo_cer"],
            "recibos_pendientes" => $datosRecibo["recibos_pendientes"],
            "recibos_pendientes_grupo_cer" => $datosRecibo["recibos_pendientes_cer"],
            "recibos_atrasados" => $datosRecibo["recibos_atrasados"],
            "recibos_atrasados_grupo_cer" => $datosRecibo["recibos_atrasados_cer"],
            "recibos_a_tiempo" => $datosRecibo["recibos_por_vencer"],
            "recibos_a_tiempo_cer" => $datosRecibo["recibos_por_vencer_cer"],
            "fecha_consulta_sicas" => date("Y-m-d H:i:s")
          );

          if(empty($valida_existencia)){
            $inserta_avance_en_recibos = $this->crmproyecto_model->inserta_avance_cobranza_kpi_por_region($i_u_array);
            $proce=$inserta_avance_en_recibos == true ? "insertado" : "no insertado";

            array_push($res, array("recibos" => $proce));
          } else{
            $actualiza_avance_en_recibos = $this->crmproyecto_model->actualizaAvanceKPIEnRecibos($i_u_array,$valida_existencia->id_tipoReporte_avance);
            $proce=$actualiza_avance_en_recibos == true ? "actualizado" : "no actualizado";

            array_push($res, array("recibos" => $proce));
          }
          //--------
          //$inserta_avance_en_comision = $this->crmproyecto_model->inserta_avance_cobranza_kpi_por_region();

          //array_push($res, array("recibos" => $inserta_avance_en_comision));
        }

      }
    }
  }

  return $res;
}
//------------------------------------
function obtenerClientesNuevos(){

  $this->load->library("FiltrosDeReportesSicas");
  $this->load->library("ws_sicas");
  $this->load->model("clientemodelo");

  $canales = array("institucional", "merida", "cancun", "fianzas"); //, "merida", "cancun", "fianzas"
  $array_ = array(); $fechas = array();

  $fechas["fechaInicial"] = date("d-m-Y", mktime(0,0,0,date("n"),1, date("Y")));
  $fechas["fechaFinal"] = date("d-m-Y", mktime(0,0,0,date("n") + 1,0, date("Y")));

  //var_dump($fechas);

  foreach($canales as $c){

    $clientes = array();

    $filtro = $this->filtrosdereportessicas->obtenerFiltro($c, 1, 3);

    $filtro_final = array_merge($fechas,$filtro);

    //var_dump($filtro_final);
    $sicas_response = $this->ws_sicas->recibosClientes($filtro_final);
    //$fp =fopen('resultadoJason.txt', 'a');fwrite($fp, print_r($sicas_response, TRUE));fclose($fp); 

    if(array_key_exists("TableInfo", $sicas_response)){
      foreach($sicas_response->TableInfo as $data){

        if((Int)$data->Periodo == 1 && (Int)$data->RenovacionDocto == 0){

          array_push($clientes, array(
            "Nombre" => (String)$data->NombreCompleto,
            "IDCli" => (Int)$data->IDCli
          ));

          //var_dump((String)$data->NombreCompleto);
          //Borrado de datos
          $borrado = $this->clientemodelo->eliminarClienteNuevo(array(
            "mes" => date("n"),
            "IDCli" => (Int)$data->IDCli,
            "canal" => $c
          ));

          $insertado = $this->clientemodelo->insertarClienteNuevo(array(
            "mes" => date("n"),
            "nombre" => (String)$data->NombreCompleto,
            "IDCli" => (Int)$data->IDCli,
            "canal" => $c
          ));
          //var_dump($borrado);
        }
      }
    }

    $array_[$c] = $clientes;
  }

  var_dump($array_);
}
//----------------------------------- // Obsoleto, será suplido por consultaComisionComercial_estadofinanciero
function consultaComisionComercial(){

  date_default_timezone_set('America/Mexico_City');
  $this->load->library("FiltrosDeReportesSicas");
  $this->load->library("ws_sicas");
  $this->load->model("metacomercial_modelo");

  $canales_ = $this->metacomercial_modelo->devuelveRegistroDeCanales();
  $array_ = array(); $fechas = array();
  $mesActivo = $this->metacomercial_modelo->devuelveActivacionComercial();

  if(!empty($mesActivo)){

    $fechas["fechaInicial"] = date("d-m-Y", mktime(0, 0, 0, $mesActivo[0]->mes_activado, 1, $mesActivo[0]->anio));
    $fechas["fechaFinal"] = date("d-m-Y", mktime(0, 0, 0, $mesActivo[0]->mes_activado + 1, 0, $mesActivo[0]->anio));

    foreach($canales_ as $key => $data){ //canales

      $filtro = $this->filtrosdereportessicas->obtenerFiltro($data->canal, 1, 3);
      $filtro_final = array_merge($fechas,$filtro);      
      $sicas_response = $this->ws_sicas->recibosClientes($filtro_final);
      $nuevo_o_total = $this->metacomercial_modelo->devuelveTipoComision($data->idUsuarioCanal);
      $comision = 0;
      $comisionRenovacion = 0;
      $comision_total = 0;

      var_dump($filtro_final);

      if(array_key_exists("TableInfo", $sicas_response)){

        foreach($sicas_response->TableInfo as $d_c){ //Recorrido de Sicas

          $comision_ = (Float)$d_c->Comision0 + (Float)$d_c->Comision1 + (Float)$d_c->Comision2 + (Float)$d_c->Comision3 + (Float)$d_c->Comision4 + (Float)$d_c->Comision5;
          
          //if($comision_ >= 0){

            if((Int)$d_c->RenovacionDocto == 0 && $comision_ >= 0){

              $comisionRenovacion += $comision_ * (Float)$d_c->TCPago;
            }
            
            $comision_total += $comision_ * (Float)$d_c->TCPago;
          //}
          //$comision_total += $data->canal != "fianzas" ? $comision_ * (Float)$d_c->TCPago : 0;
        }
        
        $comision = $data->canal != "fianzas" ? $comisionRenovacion : $comision_total;

        $update = "update consulta_comercial_registro a inner join consulta_comercial_comision b on a.idComision=b.idComision set a.activo=0 where a.idUsuarioCanal= ".$data->idUsuarioCanal." and b.mes=".$mesActivo[0]->mes_activado." and b.anio = ".$mesActivo[0]->anio."";
        $this->db->query($update);
        //$fp =fopen('resultadoJason.txt', 'a');fwrite($fp, print_r("tareaprogramada aqui", TRUE));fclose($fp);

        //Segmentar las comisiones a un tipo de reporte.
        foreach($nuevo_o_total as $d_nt){

          //var_dump($d_nt->tipo);

          $insert = $this->metacomercial_modelo->insertaRegistro(array(
            "fecha" => date("Y-m-d H:i:s"),
            "comision" => $d_nt->tipo == "nuevo" ? $comision : $comision_total,
            "id_tipo" => $d_nt->idTipoComision,
            "mes" => $mesActivo[0]->mes_activado,
            "anio" => $mesActivo[0]->anio,
          ), "consulta_comercial_comision");

          $insert_ = $this->metacomercial_modelo->insertaRegistro(array(
            "idReg" => $data->idUsuarioCanal,
            "idComision" => $insert,
            "idUsuarioCanal" => $data->idUsuarioCanal,
            "activo" => 1,
          ), "consulta_comercial_registro");
        }
      }
    }
  }
}
//-----------------------------------
function consultaComisionComercial_estadofinanciero(){ //Cambiar la solicitud de sicas al de la DB. Para ejecutar. Bueno //Dennis Castillo [2022-04-04]

  date_default_timezone_set('America/Mexico_City');
  $this->load->model(array("metacomercial_modelo", "crmproyecto_model"));

  $canales_ = $this->metacomercial_modelo->devuelveRegistroDeCanales();
  $mesActivo = $this->metacomercial_modelo->devuelveActivacionComercial();
  $response = array();

  $fechas["fechaInicial"] = date("d-m-Y", mktime(0, 0, 0, $mesActivo[0]->mes_activado, 1, $mesActivo[0]->anio));
  $fechas["fechaFinal"] = date("d-m-Y", mktime(0, 0, 0, $mesActivo[0]->mes_activado + 1, 0, $mesActivo[0]->anio));

  foreach($canales_ as $key => $data){ //channels

    $records = $this->crmproyecto_model->getEffectedRecordsFromFinancialState(array("canal" => $data->canal, "mes" => $mesActivo[0]->mes_activado, "anio" =>$mesActivo[0]->anio, "Grupo !=" => "GRUPO CER"));
    $newOrTotal = $this->metacomercial_modelo->devuelveTipoComision($data->idUsuarioCanal);
    $subsecuentComission = 0;
    $totalComission = 0;
    $newSaleComission = 0;

    if(!empty($records)){

      foreach($records as $dr){

        $comision_ = ($dr->Comision0 + $dr->Comision1 + $dr->Comision2 + $dr->Comision3 + $dr->Comision4 + $dr->Comision5 + $dr->Comision6);
        $totalComission += ($comision_ * $dr->TCPago);
  
        if($dr->RenovacionDocto == 0 && $comision_ >= 0){
  
          $subsecuentComission += $comision_ * $dr->TCPago;
        }
      }
			var_dump($subsecuentComission);
			var_dump($totalComission);
      $newSaleComission = $data->canal == "fianzas" ? $totalComission : $subsecuentComission;
  
      //---------------- Pass to inactive the actual records.
      $this->db->trans_begin();
      $this->db->where("a.idUsuarioCanal", $data->idUsuarioCanal);
      $this->db->where("b.mes", $mesActivo[0]->mes_activado); //$mesActivo[0]->mes_activado
      $this->db->where("b.anio", $mesActivo[0]->anio); //$mesActivo[0]->anio
      $this->db->update("consulta_comercial_registro a INNER JOIN consulta_comercial_comision b ON a.idComision = b.idComision", array("a.activo" => 0));
  
      if($this->db->trans_status() === FALSE){
        
        $this->db->trans_rollback();
        echo "Ha ocurrido un error en la actualización del canal: ". $data->canal."\n\n";
      }

      //---------------- //Insert news records
      foreach($newOrTotal as $d_nt){
  
        $insert1 = $this->metacomercial_modelo->insertaRegistroAvanceComercial(array(
          "fecha" => date("Y-m-d H:i:s"),
          "comision" => $d_nt->tipo == "nuevo" ? $newSaleComission : $totalComission,
          "id_tipo" => $d_nt->idTipoComision,
          "mes" => $mesActivo[0]->mes_activado, //$mesActivo[0]->mes_activado,
          "anio" => $mesActivo[0]->anio, //$mesActivo[0]->anio,
        ), "consulta_comercial_comision");
  
        $insert2 = $this->metacomercial_modelo->insertaRegistroAvanceComercial(array(
          "idReg" => $data->idUsuarioCanal,
          "idComision" => $insert1["lastId"], //lastId
          "idUsuarioCanal" => $data->idUsuarioCanal,
          "activo" => 1,
        ), "consulta_comercial_registro");
  
        $response[$data->canal]["comission"] = $insert1["success"] ? "Registro realizado con éxito" : "Ocurrió un error";
        $response[$data->canal]["register"] = $insert2["success"] ? "Registro realizado con éxito" : "Ocurrió un error";
      }
      //----------------
    } else{
      echo "No se encontraron registros en: ".$data->canal."\n\n";
    }
  }

  echo json_encode($response);
}
//----------Fin de la clase ----------------------
function envioCorreosMarketingPuntos()
{
    //$v3=$this->load->database('V3',true);
  //$correosPendientesEnviar=$v3->query("select * from envio_correosmarketing where status=0  limit 6 ")->result();    
  $correosPendientesEnviar=$this->db->query("select * from envio_correosmarketing e where e.status=0 order by e.idCorreo  desc limit 4")->result();    

        $this->load->library('PHPMailer_lib');
         $mail = $this->phpmailer_lib->load();
         $mail->isSMTP();
        $mail->protocol='mail';
        $mail->Host     = 'mail.asesorescapital.com';
        $mail->SMTPAuth = true;
        $mail->Username = 'avisocapital@asesorescapital.com';
        $mail->Password = ';uthbsm?m0^$';
        $mail->SMTPSecure = 'tsl';
        $mail->Port     = 587;
        $mail->SMTPDebug = 2;  
        $cantidad=count($correosPendientesEnviar);  
      foreach ($correosPendientesEnviar as $key => $value) 
        {  
          $mail->ClearAllRecipients();
          if($value->identificaModulo=='PuntosClientes')
          {
           $mail->setFrom('avisocapital@asesorescapital.com','');
           $tipoBarra="";
           if($value->puntos<=49){$tipoBarra='barraCapBronce.png';}
           else
           {
            if($value->puntos>49 && $value->puntos<=100){$tipoBarra='barraCapPlata.png';}
            else
            {
              if($value->puntos>100 && $value->puntos<=500){$tipoBarra='barraCapOro.png';}
              else
              {
                $tipoBarra='barraCapDiamante.png';
              }
            }
           }
           
           $mail->addAddress($value->para);
           $mail->Subject = 'CLUB CAP';           
           $mail->isHTML(true);
          $mail->AddEmbeddedImage('assets/images/envioPuntos/clubCap.png','logo_1');
          $mail->AddEmbeddedImage('assets/images/envioPuntos/tarjetaCap.png','logo_2');
          $mail->AddEmbeddedImage('assets/images/envioPuntos/'.$tipoBarra,'logo_3');
          $mail->AddEmbeddedImage('assets/images/envioPuntos/publicidadCap.png','logo_4');
           $mailContent=$value->mensaje;
           $mail->Body = $mailContent;       
           if($mail->send())
           { 
             $actualizar="update envio_correosmarketing set status=1 where idCorreo=".$value->idCorreo;
             $this->db->query($actualizar);  
           }
          else
          {               
           $actualizar="update envio_correosmarketing set status=1 where idCorreo=".$value->idCorreo;
             $this->db->query($actualizar);  
           
          }
          }   

        } 
}
//---------------------------------------------------------
function sendEventsNotifications(){

  $CI =& get_instance();
  $CI->load->model("calendar_model");
  $CI->load->library("sendmailforcalendarevents");
  $getMessages = $CI->calendar_model->getEventsNotification();

  if(!empty($getMessages)){
    foreach($getMessages as $d_m){

      $array = array();
      $array["from"] = array('Email' => "sistemas@agentecapital.com",'Name' => "Invitación");
      $array["to"] = array(
        array('Email' => $d_m->to, 'Name' => $d_m->to)
      );
      $array["cc"] = array();
      $array["bcc"] = array();
      $array["subject"] = $d_m->subject;
      $array["textPart"] = "Envio de notificación de evento";
      $array["htmlPart"] = $d_m->message;
      $array["attachments"] = array();
      $array["inlinedAttachments"] = array();

      $sendNotification = $CI->sendmailforcalendarevents->executeRequest($array);
      //var_dump($sendNotification);
      $status = $sendNotification ? 1 : -1;

      $update = $CI->calendar_model->updateNotificationStatus($d_m->id, array("status" => $status, "dateSend" => date("Y-m-d H:i:s")));
    }
  }

}
//---------------------------------------------------------
function tareasProximasParavencer()
{
  $tareasCreador=$this->db->query('select u.email,u.idPersona,p.idproyecto,(p.nombre) as nombreProyecto,t.idtarea,t.nombre from tareas t left join proyectos p on p.idproyecto=t.idproyecto left join users u on u.idPersona=p.usuario where DATEDIFF(t.fechaentrega,cast(now() as date))=1')->result();

foreach ($tareasCreador as $key => $value) 
{
   $comentario='EL PROYECTO '.$value->nombreProyecto.' TIENE LA TAREA '.$value->nombre.' A 1 DIA DE VENCER';
    $insertC="insert into envio_correos(fechacreacion,desde,para,copia,copiaoculta,asunto,mensaje,status,fechaenvio,identificaModulo)";
     $insertCorreo=$insertC.'values(now(), "Buzon de quejas<avisosgap@aserorescpital.com>","'.$value->email.'" ,0,0,"Entrega de tarea","'.$comentario.'",0,now(),"");';
          $this->db->query($insertCorreo);  
    $responsable=$this->db->query('select * from ptareas where idtarea='.$value->idtarea)->result();
    foreach ($responsable as $key => $val) 
    {
          $insertC="insert into envio_correos(fechacreacion,desde,para,copia,copiaoculta,asunto,mensaje,status,fechaenvio,identificaModulo)";
     $insertCorreo=$insertC.'values(now(), "Buzon de quejas<avisosgap@aserorescpital.com>","'.$val->correo.'" ,0,0,"Entrega de tarea","'.$comentario.'",0,now(),"");';
          $this->db->query($insertCorreo);  

    }
}
}
//-------------------------------------------------
//Dennis Castillo [2021-11-19] -> [2022-03-24]
function obtenerRenovacionesYaRenovadas(){

  $CI =& get_instance();
  $CI->load->library("ws_sicas");
  $getDocs = $CI->ws_sicas->renovacionesYaRenovadas();

  var_dump($getDocs->TableInfo);

  if(!empty($getDocs) && $getDocs != false){

    $truncate = "TRUNCATE TABLE renovaciones_ya_renovadas;";
    $execute = $this->db->query($truncate);

    $query = "SELECT * FROM renovaciones_ya_renovadas;";
    $executeQuery = $this->db->query($query);

    if(empty($executeQuery->result())){

      $insertArray = array();

      foreach($getDocs->TableInfo as $data){

        array_push($insertArray, array(
          "Documento" => (String)$data->Documento, 
          "NombreCompleto" => (String)$data->NombreCompleto, 
          "FDesde" => date("Y-m-d", strtotime((String)$data->FDesde)),
          "FHasta"  => date("Y-m-d", strtotime((String)$data->FHasta)), 
          "FEmision"  => !empty((String)$data->FEmision) ? date("Y-m-d", strtotime((String)$data->FEmision)) : null, 
          "Status_TXT" => (String)$data->Status_TXT, 
          "PrimaNeta" => (Float)$data->PrimaNeta, 
          "PorCom0" => (Float)$data->PorCom0, 
          "PorCom2" => (Float)$data->PorCom2, 
          "Grupo" => (String)$data->Grupo, 
          "SubGrupo" => (String)$data->SubGrupo, 
          "Nombre" => (String)$data->Nombre, 
          "Compañía" => (String)$data->Compañía, 
          "SRamoNombre" => (String)$data->SRamoNombre, 
          "RamosNombre" => (String)$data->RamosNombre, 
          "Renovacion" => (Int)$data->Renovacion, 
          "dateInserction" => date("Y-m-d H:i:s"),
        ));
      }
      //--------------- Insert Proccessing
      $this->db->trans_begin();
      $this->db->insert_batch("renovaciones_ya_renovadas", $insertArray);

      if ($this->db->trans_status() === FALSE)
      {
              $this->db->trans_rollback();
      }
      else
      {
              $this->db->trans_commit();
              var_dump("Insert Successfull");
      }
      //---------------------------------
    }
  }

  //var_dump($insertArray);
}
//-------------------------------------------------
function pruebaCron()
{
  $this->db->query("insert into pruebaDennis (prueb, insercion) VALUES ('1', '2021-10-05 14:39:49')");
}
//------------------------------------ Dennis Castillo [2022-02-17]
function kpiPerformed(){

  date_default_timezone_set('America/Mexico_City');
  $this->load->library("ws_sicas");
  $this->load->library("FiltrosDeReportesSicas");
  $this->load->model("metacomercial_modelo");
  $canales_ = $this->metacomercial_modelo->devuelveRegistroDeCanales();
  try{

    $fechas["fechaInicial"] = date("d-m-Y", mktime(0, 0, 0, date("n"), 1, date("Y")));
    $fechas["fechaFinal"] = date("d-m-Y", mktime(0, 0, 0, date("n") + 1, 0, date("Y")));
    $_res = array();
    foreach($canales_ as $key => $data)
    {
      $filtro = $this->filtrosdereportessicas->obtenerFiltro($data->canal, 1, 3); //Efectuadas
      $filtro["filtroGrupo"] = array();
      $filtro["excepcionGrupo"] = 0;

      $filtro_final = array_merge($fechas,$filtro);
      $sicas_response = $this->ws_sicas->recibosClientes($filtro_final);
  
      if(!is_bool($sicas_response) && array_key_exists("TableInfo", $sicas_response)){
        
        $change = $this->changeStatusInsectionInsertion("rojo", "mensual", $data->canal, date("Y-m-d H:i:s"), "proceso");
        $manageData = $this->manageKpi($sicas_response->TableInfo, "estado_financiero_ahora", $data->canal, $data->correo); // 1 de 4
      }
    }
    echo json_encode(array("Status" => 200 , "Message" => "Se ha cargado correctamente.", "Status_insert" => $manageData));

  } catch (Exception $e){
    echo "Excepción capturada". $e->getMessage();
  }
}
//------------------------------------ Dennis Castillo [2022-02-17]
function pendingKpi(){

  date_default_timezone_set('America/Mexico_City');
  $this->load->library("ws_sicas");
  $this->load->library("FiltrosDeReportesSicas");
  $this->load->model("metacomercial_modelo");

  $canales_ = $this->metacomercial_modelo->devuelveRegistroDeCanales();

  try{

    $fechas["fechaInicial"] = date("d-m-Y", mktime(0, 0, 0, date("n"), 1, date("Y")));
    $fechas["fechaFinal"] = date("d-m-Y", mktime(0, 0, 0, date("n") + 1, 0, date("Y")));
    $_res = array();
    
    foreach($canales_ as $key => $data){

      $filtro = $this->filtrosdereportessicas->obtenerFiltro($data->canal, 0, 0); //Pendientes por fecha limite de pago;
      $filtro["filtroGrupo"] = array();
      $filtro["excepcionGrupo"] = 0;

      $filtro_final = array_merge($fechas,$filtro);
      $sicas_response = $this->ws_sicas->recibosClientes($filtro_final); //Sicas query
      
      if(!is_bool($sicas_response) && array_key_exists("TableInfo", $sicas_response)){
        
        $change = $this->changeStatusInsectionInsertion("rojo", "mensual", $data->canal, date("Y-m-d H:i:s"), "proceso");
        $manageData = $this->manageKpi($sicas_response->TableInfo, "estado_financiero_pendiente", $data->canal, $data->correo); // 1 de 4
      }
    }
    echo json_encode(array("Status" => 200 , "Message" => "Se ha cargado correctamente.", "Status_insert" => $manageData));

  } catch (Exception $e){
    echo "Excepción capturada". $e->getMessage();
  }
}
//------------------------------------ Dennis Castillo [2022-02-17]
function manageKpi($data, $table, $channel, $email){

  $delete = $this->metacomercial_modelo->deleteRecords(array('canal' => $channel), $table);
  $columns = $this->db->list_fields($table);
  $res = array();
  $response = false;

  if($delete){
    foreach($data as $data_){

      $field = array();
      $toArray = $this->convertObjectToArray($data_);

      foreach($columns as $values){
        $field[$values] = isset($toArray[$values]) ? $toArray[$values] : null;
      }

      $field["canal"] = $channel;
      $field["anio"] = date("Y");
      $field["mes"] = date("n");
      $field["emailCanal"] = $email;
      $field["fechaInserccion"] = date("Y-m-d H:i:s");
      
      array_push($res, $field);
    }
    //----------------------
    $this->db->trans_begin();
    $this->db->insert_batch($table, $res);
    
    if($this->db->trans_status() === FALSE){

      $this->db->trans_rollback();
      $change = $this->changeStatusInsectionInsertion("rojo", "mensual", $channel, date("Y-m-d H:i:s"), "fallido");
      
    } else {
      $this->db->trans_commit();
      $change = $this->changeStatusInsectionInsertion("verde", "mensual", $channel, date("Y-m-d H:i:s"), "concluido");
      $response = true;
    }
    //----------------------
  }

  return $response;
}
//------------------------------------ Dennis Castillo [2022-02-17]
function changeStatusInsectionInsertion($colour, $query, $channel, $date, $status){
  
  $delete = $this->metacomercial_modelo->deleteRecords(array('canal' => $channel, "tipo_consulta" => "mensual"), "semaforo_consulta_sicas");
  $change = $this->metacomercial_modelo->insertSemaphoreChange(array(
    "color" => $colour, 
    "tipo_consulta" => $query, 
    "canal" => $channel, 
    "fecha_inserccion" => $date, 
    "status" => $status,
  ));

  return $change;
}
//------------------------------------ Dennis Castillo [2022-02-17]
function convertObjectToArray($object){

  $response = array();

  if(is_object($object)){
    foreach($object as $key => $value){

      $response[(String)$key] = (String)$value;
    }
  }

  return $response;
}
//------------------------------------ Dennis Castillo [2022-02-17]
function getKpiComercial(){

  $this->load->model(array("metacomercial_modelo", "crmproyecto_model"));

  $channels = $this->metacomercial_modelo->getChannels(null);

  if(!empty($channels)){

    foreach($channels as $data){

      //$receipts = $this->crmproyecto_model->getReceiptsPaidPerChannel($data->canal, "GRUPO CER", 1, 0, 0, false);
      $total = $this->crmproyecto_model->getReceiptsPaidPerChannel($data->canal, "GRUPO CER", null, null, null, true);
      $totalCer = $this->crmproyecto_model->getReceiptsPaidPerChannel($data->canal, null, null, null, null, true);
      $newSale = $data->canal !== "fianzas" ? $this->crmproyecto_model->getReceiptsPaidPerChannel($data->canal, "GRUPO CER", 1, 0, 0, true) : $total; //Canal, grupo, periodo, renovacion, renovacionDocto, usar negativos
      $subsequent = $this->crmproyecto_model->getReceiptsPaidPerChannel($data->canal, "GRUPO CER", null, null, 0, true);
      $pending = $this->crmproyecto_model->getPendingReciptsPerChannel($data->canal, null);
      $pendingInCer = array_filter($pending, function($arr){ return $arr->Grupo == "GRUPO CER" && $arr->PrimaNeta > 0; });
      $pendingOutCer = array_filter($pending, function($arr){ return $arr->Grupo !== "GRUPO CER" && $arr->PrimaNeta > 0; });

      $dataNewSale = array_reduce($newSale, function($acc, $curr){

        $allCommision = ($curr->Comision0 + $curr->Comision1 + $curr->Comision2 + $curr->Comision3 + $curr->Comision4 + $curr->Comision5 + $curr->Comision6 + $curr->Comision7 + $curr->Comision8 + $curr->Comision9);
        $acc["recibos_efectuados_venta_nueva"] ++;
        $acc["prima_efectuada_venta_nueva"] += $curr->PrimaNeta * $curr->TCPago;
        $acc["comision_efectuada_venta_nueva"] += $allCommision * $curr->TCPago;

        return $acc;
      }, array("recibos_efectuados_venta_nueva" => 0, "prima_efectuada_venta_nueva" => 0, "comision_efectuada_venta_nueva" => 0));

      $dataSubsequent = array_reduce($subsequent, function($acc, $curr){

        $allCommision = ($curr->Comision0 + $curr->Comision1 + $curr->Comision2 + $curr->Comision3 + $curr->Comision4 + $curr->Comision5 + $curr->Comision6 + $curr->Comision7 + $curr->Comision8 + $curr->Comision9);
        $acc["recibos_efectuados_subsecuente"] ++;
        $acc["prima_efectuada_subsecuente"] += $curr->PrimaNeta * $curr->TCPago;
        $acc["comision_efectuada_subsecuente"] += $allCommision * $curr->TCPago;

        return $acc;
      }, array("recibos_efectuados_subsecuente" => 0, "prima_efectuada_subsecuente" => 0, "comision_efectuada_subsecuente" => 0));

      $dataTotal = array_reduce($total, function($acc, $curr){

        $allCommision = ($curr->Comision0 + $curr->Comision1 + $curr->Comision2 + $curr->Comision3 + $curr->Comision4 + $curr->Comision5 + $curr->Comision6 + $curr->Comision7 + $curr->Comision8 + $curr->Comision9);
        $acc["recibos_efectuados"] ++;
        $acc["prima_efectuada"] += $curr->PrimaNeta * $curr->TCPago;
        $acc["comision_efectuada"] += $allCommision * $curr->TCPago;

        return $acc;
      }, array("recibos_efectuados" => 0, "prima_efectuada" => 0, "comision_efectuada" => 0));

      $dataCer = array_reduce($totalCer, function($acc, $curr){

        $allCommision = ($curr->Comision0 + $curr->Comision1 + $curr->Comision2 + $curr->Comision3 + $curr->Comision4 + $curr->Comision5 + $curr->Comision6 + $curr->Comision7 + $curr->Comision8 + $curr->Comision9);
        if($curr->Grupo == "GRUPO CER"){
          $acc["recibos_efectuados_grupo_cer"] ++;
          $acc["prima_efectuada_grupo_cer"] += $curr->PrimaNeta * $curr->TCPago;
          $acc["comision_efectuada_grupo_cer"] += $allCommision * $curr->TCPago;
        }
       
        return $acc;
      }, array("recibos_efectuados_grupo_cer" => 0, "prima_efectuada_grupo_cer" => 0, "comision_efectuada_grupo_cer" => 0));

      $dataPending = array_reduce($pendingOutCer, function($acc, $curr){

        $f1 = new DateTime(date("Y-m-d", strtotime($curr->FLimPago)));
        $f2 = new DateTime(date("Y-m-d"));
        $fdiff = $f2->diff($f1);
        $interval = (Int)$fdiff->format("%R%a");
        $allCommision = ($curr->Comision0 + $curr->Comision1 + $curr->Comision2 + $curr->Comision3 + $curr->Comision4 + $curr->Comision5 + $curr->Comision6 + $curr->Comision7 + $curr->Comision8 + $curr->Comision9);
        $acc["prima_pendiente"] = $curr->PrimaNeta * $curr->TCDay;
        $acc["comision_pendiente"] = $allCommision * $curr->TCDay;

        if($interval <= -10 ){
          $acc["recibos_atrasados"] ++;
        } elseif($interval > -10 && $interval <= 6){
          $acc["recibos_pendientes"] ++;
        } elseif($interval > 6){
          $acc["recibos_a_tiempo"] ++;
        }
        
        return $acc;
      }, array("recibos_a_tiempo" => 0, "recibos_pendientes" => 0, "recibos_atrasados" => 0, "prima_pendiente" => 0, "comision_pendiente" => 0));
      //"recibos_a_tiempo" => 0, "recibos_a_tiempo_cer" => 0, "recibos_pendientes" => 0, "recibos_pendientes_grupo_cer" => 0, "recibos_atrasados" => 0, "recibos_atrasados_grupo_cer" => 0

      $dataPendingInCer = array_reduce($pendingInCer, function($acc, $curr){

        $f1 = new DateTime(date("Y-m-d", strtotime($curr->FLimPago)));
        $f2 = new DateTime(date("Y-m-d"));
        $fdiff = $f2->diff($f1);
        $interval = (Int)$fdiff->format("%R%a");
        $allCommision = ($curr->Comision0 + $curr->Comision1 + $curr->Comision2 + $curr->Comision3 + $curr->Comision4 + $curr->Comision5 + $curr->Comision6 + $curr->Comision7 + $curr->Comision8 + $curr->Comision9);
        $acc["prima_pendiente_grupo_cer"] = $curr->PrimaNeta * $curr->TCDay;
        $acc["comision_pendiente_grupo_cer"] = $allCommision * $curr->TCDay;

        if($interval <= -10 ){
          $acc["recibos_atrasados_grupo_cer"] ++;

        } elseif($interval > -10 && $interval <= 6){

          $acc["recibos_pendientes_grupo_cer"] ++;
        } elseif($interval > 6){

          $acc["recibos_a_tiempo_cer"] ++;
        }
        
        return $acc;
      }, array("recibos_a_tiempo_cer" => 0, "recibos_pendientes_grupo_cer" => 0, "recibos_atrasados_grupo_cer" => 0, "prima_pendiente_grupo_cer" => 0, "comision_pendiente_grupo_cer" => 0));

      if($data->canal == "merida"){
       
        $dxnEffected = array_filter($total, function($arr){ return $arr->VendNombre == "CRUZ ALFONSO DANIEL" || $arr->VendNombre == "CRUZ NAMPULA RUBI"; });
        $dxnLate = array_filter($pending, function($arr){ return $arr->VendNombre == "CRUZ ALFONSO DANIEL" || $arr->VendNombre == "CRUZ NAMPULA RUBI"; });
        $arraydxnEf = array_reduce(array_values($dxnEffected), function($acc, $curr){ 
          $allCommision = ($curr->Comision0 + $curr->Comision1 + $curr->Comision2 + $curr->Comision3 + $curr->Comision4 + $curr->Comision5 + $curr->Comision6 + $curr->Comision7 + $curr->Comision8 + $curr->Comision9);
          $acc[] = array(
            "reporte" => $curr->canal,
            "comision" => $allCommision * $curr->TCPago,
            "prima" => $curr->PrimaNeta * $curr->TCPago,
            "vend" => $curr->IDVend,
            "vendedorNombre" => $curr->VendNombre,
            "tipoRecibo" => "pagado"
          );  return $acc;
        }, array());

        $arrayDxnLate = array_reduce(array_values($dxnLate), function($acc, $curr){
          $allCommision = ($curr->Comision0 + $curr->Comision1 + $curr->Comision2 + $curr->Comision3 + $curr->Comision4 + $curr->Comision5 + $curr->Comision6 + $curr->Comision7 + $curr->Comision8 + $curr->Comision9);

          $f1 = new DateTime(date("Y-m-d", strtotime($curr->FLimPago)));
          $f2 = new DateTime(date("Y-m-d"));
          $f3 = $f2->diff($f1);
          $interval = $f3->format("%R%a");

          if($interval <= - 10){
            $acc[] = array(
              //"id" => $curr->Documento,
              "reporte" => $curr->canal,
              "comision" => $allCommision * $curr->TCDay,
              "prima" => $curr->PrimaNeta * $curr->TCDay,
              "vend" => $curr->IDVend,
              "vendedorNombre" => $curr->VendNombre,
              "tipoRecibo" => "atrasado"
            );
          }

          return $acc;
        }, array());

        $insert = $this->avanceDxN($arraydxnEf, $arrayDxnLate);
      }

      $arrayMixed = $data->canal !== "fianzas" ? array_merge($dataNewSale, $dataSubsequent, $dataTotal, $dataCer, $dataPending, $dataPendingInCer) : array_merge($dataNewSale, $dataTotal, $dataPending, $dataPendingInCer);
      $update = $this->crmproyecto_model->updateKpi($arrayMixed, $data->canal);
      //var_dump($arrayMixed);
    }
  }
}
//---------------------------------------------- //Dennis Castillo [2022-03-24]
function obtenerRenovacionesPendientes(){

  $CI =& get_instance();
  $CI->load->library("ws_sicas");
  $columns = $CI->db->list_fields("renovaciones_pendientes_kpi");
  $FI = date("d-m-Y", mktime(0, 0, 0, date("n"), 1, date("Y")));
  $FF = date("d-m-Y", mktime(0, 0, 0, date("n") + 1, 0, date("Y")));
  $getDocs = $CI->ws_sicas->obtenerRenovacionesFecha(0, $FI, $FF, null, "vigente", null);
  $toInsert = array();
  //$checkCategory = array();

  if(!is_bool($getDocs) && property_exists($getDocs, "TableInfo")){

    foreach($getDocs->TableInfo as $data){

      $field = array();
      $toArray = $this->convertObjectToArray($data);
      //array_push($checkCategory, $toArray["RamosNombre"]);

      foreach($columns as $dc){

        $field[$dc] = isset($toArray[$dc]) ? $toArray[$dc] : null;
      }

      $field["dateInsert"] = date("Y-m-d H:i:s");
      array_push($toInsert, $field);
    }

    //if(!empty($checkCategory)){

      //$uniqueCategory = array_values(array_unique($checkCategory));
      //$CI->db->where_in("RamosNombre", $uniqueCategory);
      //$CI->db->delete("renovaciones_pendientes_kpi");
    //}
    $CI->db->truncate("renovaciones_pendientes_kpi");
    $CI->db->insert_batch("renovaciones_pendientes_kpi", $toInsert);

  }

  //$fp = fopen('resultadoJason.txt', 'a');fwrite($fp, print_r($getDocs,TRUE));fclose($fp);
  var_dump($toInsert);

}

//------------------------------------ //Dennis Castillo [2022-04-04]
function consultaComercialEstadoFinanciero(){

  set_time_limit(0);
  date_default_timezone_set('America/Mexico_City');
  $this->load->library("FiltrosDeReportesSicas");
  $this->load->library("ws_sicas");
  $this->load->model("metacomercial_modelo");

  //$columns = $this->db->list_fields("estadofinanciero");
  $canales_ = $this->metacomercial_modelo->devuelveRegistroDeCanales();
  $mesActivo = $this->metacomercial_modelo->devuelveActivacionComercial();
  $toInsert = array();
    $felicitacion=array();
  $deleteChannelsRecords = array();
  $totalCount = array();
  $sumDanios=0;$sumVehiculos=0;$sumAccidentesEnfermedades=0;$sumVida=0;$sumFianzas=0;

  if(empty($mesActivo) && (!isset($_GET['fechaInicial']) && !isset($_GET['fechaFinal']))){exit("No hay fechas disponibles para la consulta");}

  $fechas["fechaInicial"] = isset($_GET['fechaInicial']) ? $_GET['fechaInicial'] : date("d-m-Y", mktime(0, 0, 0, $mesActivo[0]->mes_activado, 1, $mesActivo[0]->anio));
  $fechas["fechaFinal"] = isset($_GET['fechaFinal']) ? $_GET['fechaFinal'] : date("d-m-Y", mktime(0, 0, 0, $mesActivo[0]->mes_activado + 1, 0, $mesActivo[0]->anio));
  $mes = date("n", strtotime($fechas["fechaInicial"]));
  $anio = date("Y", strtotime($fechas["fechaInicial"]));

  foreach($canales_ as $key => $data)
  {


    $filtro = $this->filtrosdereportessicas->obtenerFiltro($data->canal, 1, 3);
    $filtro["filtroGrupo"] = array(); // Pasa grupos como todos (Dennis Castillo)
    $filtro["excepcionGrupo"] = 0; // 0 es equivalente a igual y 1 a diferente (Dennis Castillo)
    $filtro_final = array_merge($fechas,$filtro);
    $sicas_response = $this->ws_sicas->recibosClientes($filtro_final);
    $totalCount[$data->canal] = 0;

    $primasPorCanal=array();
    $primasPorCanal[$data->canal]=array();
    $comision = 0;
    $comisionRenovacion = 0;
    $comision_total = 0; 
  
    if(!is_bool($sicas_response) && property_exists($sicas_response, "TableInfo"))
    {

      array_push($deleteChannelsRecords, $data->canal);
      foreach($sicas_response->TableInfo as $ds)
      {
        
        $field = array();
        
             if(!array_key_exists((string)$data->canal,$primasPorCanal)){$primasPorCanal[(string)$data->canal]=array();}           
             if(!array_key_exists((string)$ds->RamosNombre,$primasPorCanal[(string)$data->canal])){$primasPorCanal[(string)$data->canal][(string)$ds->RamosNombre]=array();}
             if(!array_key_exists((string)$ds->SRamoNombre,$primasPorCanal[(string)$data->canal][(string)$ds->RamosNombre]))
              {
                $primasPorCanal[(string)$data->canal][(string)$ds->RamosNombre][(string)$ds->SRamoNombre]=array();
                $primasPorCanal[(string)$data->canal][(string)$ds->RamosNombre][(string)$ds->SRamoNombre]['comision']=0;
              }

          $comision_ = (Float)$ds->Comision0 + (Float)$ds->Comision1 + (Float)$ds->Comision2 + (Float)$ds->Comision3 + (Float)$ds->Comision4 + (Float)$ds->Comision5;
          
          if($comision_ >= 0)
          {

            if((Int)$ds->RenovacionDocto == 0){$comisionRenovacion += $comision_ * (Float)$ds->TCPago;}            
            $comision_total += $comision_ * (Float)$ds->TCPago;
          }          
          $primasPorCanal[(string)$data->canal][(string)$ds->RamosNombre][(string)$ds->SRamoNombre]['comision']+=$comision_ * (Float)$ds->TCPago;


            if((Int)$ds->Status == 3 || (Int)$ds->Status == 4)
            { //Recibos totales pagados.
              
              switch ($ds->RamosNombre) 
              {
                case 'Daños':$sumDanios=(float)$sumDanios+((float)$ds->PrimaNeta*(float)$ds->TCPago);break;
                case 'Vehiculos':$sumVehiculos=(float)$sumVehiculos+((float)$ds->PrimaNeta*(float)$ds->TCPago);break;
                case 'Accidentes y Enfermedades':$sumAccidentesEnfermedades=(float)$sumAccidentesEnfermedades+((float)$ds->PrimaNeta*(float)$ds->TCPago);break;
                case 'Vida':$sumVida=(float)$sumVida+((float)$ds->PrimaNeta*(float)$ds->TCPago);break;
                case 'Fianzas':$sumFianzas=(float)$sumFianzas+((float)$ds->PrimaNeta*(float)$ds->TCPago);break;
        }
            }

        //foreach($columns as $dc){$field[$dc] = isset($toArray[$dc]) ? $toArray[$dc] : null;}

        $field["emailCanal"] = $data->correo;
        $field["canal"] = $data->canal;
        $field["mes"] = $mes;
        $field["anio"] = $anio;
          $field['IDRecibo']=(int)$ds->IDRecibo;
          $field['FechaPago']= date("Y-m-d", strtotime((String)$ds->FechaPago)); //Strstr($ds->FechaPago,"T",true);
          $field['TipoDocto']=(string)$ds->TipoDocto;
          $field['FechaDocto']=Strstr($ds->FechaDocto,"T",true);
          $field['FLiquidacion']=(isset($ds->FLiquidacion))? Strstr($ds->FLiquidacion,"T",true) : null;
          $field['TCPago']=$ds->TCPago;
          $field['MonedaPago']=(string)$ds->MonedaPago;
          $field['Moneda']=(string)$ds->Moneda;
          $field['Documento']=(string)$ds->Documento;
          $field['Endoso']=(isset($ds->Endoso))? (string)$ds->Endoso : '';
          $field['Letra']=(isset($ds->Letra))? (string)$ds->Letra : '';
          $field['Periodo']=$ds->Periodo;
          $field['Serie']=(string)$ds->Serie;#
          $field['FDesde']=Strstr($ds->FDesde,"T",true);
          $field['FHasta']=Strstr($ds->FHasta,"T",true);          
          //if(Strstr($ds->FLimPago,"T",true)!=''){$field['FLimPago']=Strstr($ds->FLimPago,"T",true);} //date("Y-m-d", strtotime((String)$ds->FechaPago));
          $field['FLimPago'] = date("Y-m-d", strtotime((String)$ds->FLimPago)); //Dennis Castillo [2022-06-06]
          $field['FStatus']=(isset($ds->FStatus))? Strstr($ds->FStatus,"T",true) : null;   
          $field['Status']=$ds->Status;
          $field['Status_TXT']=(string)$ds->Status_TXT;
          $field['PrimaNeta']=$ds->PrimaNeta;
          $field['Descuento']=$ds->Descuento;
          $field['Recargos']=$ds->Recargos;
          $field['Derechos']=$ds->Derechos;#
          $field['GastosAdm']=$ds->GastosAdm;
          $field['Impuesto1']=$ds->Impuesto1;
          $field['Impuesto2']=$ds->Impuesto2;
          $field['FondoInv']=$ds->FondoInv;
          $field['PrimaTotal']=$ds->PrimaTotal;
          $field['Comision0']=$ds->Comision0;
          $field['Comision1']=$ds->Comision1;
          $field['Comision2']=$ds->Comision2;
          $field['Comision3']=$ds->Comision3;
          $field['Comision4']=$ds->Comision4;
          $field['Comision5']=$ds->Comision5;
          $field['Comision6']=$ds->Comision6;
          $field['Comision7']=$ds->Comision7;
          $field['Comision8']=$ds->Comision8;
          $field['Comision9']=$ds->Comision9;
          $field['Grupo']=(string)$ds->Grupo;#
          $field['SubGrupo']=(string)$ds->SubGrupo;
          $field['NombreCompleto']=(string)$ds->NombreCompleto;
          $field['CAgente']=(string)$ds->CAgente;
          $field['AgenteNombre']=(string)$ds->AgenteNombre;
          $field['VendNombre']=(string)$ds->VendNombre;
          $field['OfnaNombre']=(string)$ds->OfnaNombre;
          $field['FPago']=(string)$ds->FPago;
          $field['RamosNombre']=(string)$ds->RamosNombre;
          $field['SRamoNombre']=(string)$ds->SRamoNombre;
          $field['CCobro_TXT']=(string)$ds->CCobro_TXT;
          $field['IDDocto']=$ds->IDDocto;
          $field['DespNombre']=(string)$ds->DespNombre;
          $field['ImportePago']=$ds->ImportePago;
          $field['ImporteReal']=$ds->ImporteReal;
          $field['ImportePagoTC']=$ds->ImportePagoTC;#
          $field['Renovacion']=$ds->Renovacion;
          $field['ClasCia_TXT']=(string)$ds->ClasCia_TXT;
          $field['GerenciaNombre']=(string)$ds->GerenciaNombre;
          $field['RenovacionDocto']=$ds->RenovacionDocto;
          $field['VendAbreviacion']=(string)$ds->VendAbreviacion;
          $field['EjecutNombre']=(string)$ds->EjecutNombre;
          $field['IDCli']=(int)$ds->IDCli;
          $field['IDAgente']=(int)$ds->IDAgente;
          $field['IDEjecut']=(int)$ds->IDEjecut;   
          $field['IDVend']=(int)$ds->IDVend;   
          $field['canal']=(string)$data->canal;   #
          $field['emailCanal']=(string)$data->correo;   
          $field['IDDespacho']=(int)$ds->IDDespacho;
          $field['TipoDocto_TXT']=(string)$ds->TipoDocto_TXT;
          /*$field['IDSRamo']=(int)$ds->IDSRamo;*/
          if($ds->RenovacionDocto==0 && $ds->Periodo==1 )
            {
              $inFelicitacion['yaFueFelicitado']=0;
              if($ds->RamosNombre=='Vehiculos'){$inFelicitacion['yaFueFelicitado']=1;}
              $inFelicitacion['IDVend']=(int)$ds->IDVend;
              $inFelicitacion['IDRecibo']=(int)$ds->IDRecibo;
              $inFelicitacion['Documento']=(string)$ds->Documento;
              $inFelicitacion['VendNombre']=(string)$ds->VendNombre;
              $inFelicitacion['NombreCompleto']=(string)$ds->NombreCompleto;                                         
              array_push($felicitacion,$inFelicitacion);
            }


          
        array_push($toInsert, $field);
        $totalCount[$data->canal] ++;
      }
    $this->guardarPrimasPagadasPorCanal($primasPorCanal,$anio,$mes);
    }
  }

  
    
  if(!empty($deleteChannelsRecords))
  {
	
    $this->db->trans_begin();
    $this->db->where_in("canal", $deleteChannelsRecords);
    $this->db->where("mes", date("n", strtotime($fechas["fechaInicial"])));
    $this->db->where("anio", date("Y", strtotime($fechas["fechaInicial"])));
    $this->db->delete("estadofinanciero"); //step 1: delete record from actual condition
    $this->db->insert_batch("estadofinanciero", $toInsert); //step 2: insert record from actual condition
      echo('pagina');

     foreach ($felicitacion as $valueFel) 
     {
       $insertString='insert ignore into enviofelicitacionventanueva (IDVend,IDRecibo,Documento,VendNombre,NombreCompleto,yaFueFelicitado) value ('.$valueFel['IDVend'].','.$valueFel['IDRecibo'].',"'.$valueFel['Documento'].'","'.$valueFel['VendNombre'].'","'.$valueFel['NombreCompleto'].'",'.$valueFel['yaFueFelicitado'].')';
       $this->db->query($insertString);
       echo($insertString);
     }
    #$this->db->insert_batch('enviofelicitacionventanueva',$felicitacion);
     
    if((float)$sumDanios>0){ $this->guardarAvancePrimasPagadas(1,'Danios',$sumDanios,$anio,$mes);}
    if((float)$sumVehiculos>0){ $this->guardarAvancePrimasPagadas(2,'Vehiculos',$sumVehiculos,$anio,$mes);}
    if((float)$sumAccidentesEnfermedades>0){ $this->guardarAvancePrimasPagadas(3,'Accidentes y Enfermedades',$sumAccidentesEnfermedades,$anio,$mes);}
    if((float)$sumVida>0){ $this->guardarAvancePrimasPagadas(4,'Vida',$sumVida,$anio,$mes);}
    if((float)$sumFianzas>0){ $this->guardarAvancePrimasPagadas(5,'Fianzas',$sumFianzas,$anio,$mes);}

    if($this->db->trans_status() === FALSE)
    {
      $this->db->trans_rollback();
      echo "Ocurrio un error en el proceso de actualización de los registros, inténtelo de nuevo";
    } 
    else
    {
      $this->db->trans_commit();
      echo "Registros almacenados con éxito\n\n";
      echo json_encode($totalCount);
    }

  } else{
    echo "El array de canales recolectados de la respuesta de Sicas esta vacío. Por lo tanto no se procede a eliminar e insertar datos.";
  }

}
//---------------------------------------------------------
function guardarPrimasPagadasPorCanal($array,$anio,$mes)
{
  //$fp =fopen('resultadoJason.txt', 'a');fwrite($fp, print_r($array, TRUE));fclose($fp);
  foreach ($array as $key => $canales) 
  {
    $this->db->where('anio',$anio);
    $this->db->where('mes',$mes);
    $this->db->where('canal',$key);
    $this->db->delete('avance_primas_pagadas_canal');

    foreach ($canales as $keyRamos => $ramos) 
    {
       foreach ($ramos as $keySubRamos => $subRamos) 
       {
          $insert=array();          
          $insert['RamosNombre']=$keyRamos;
          $insert['SRamoNombre']=$keySubRamos;
          //$insert['comision']=$sum;
          $insert['anio']=$anio;
          $insert['mes']=$mes;
          $insert['canal']=$key;
          $insert['comision']=(float)$subRamos['comision'];
          $this->db->insert('avance_primas_pagadas_canal',$insert);
       }
    }
  }
}
//-------------------------------------------
function guardarAvancePrimasPagadas($idRamo,$ramo,$sum,$anio,$mes)
{       $insert=array();
  $this->db->where('anio',$anio);
  $this->db->where('mes',$mes);
  $this->db->where('RamosNombre',$ramo);
  $this->db->delete('avance_primas_pagadas');
  $insert['idRamo']=$idRamo;
  $insert['RamosNombre']=$ramo;
  $insert['PrimaNeta']=$sum;
  $insert['anio']=$anio;
  $insert['mes']=$mes;
  $this->db->insert('avance_primas_pagadas',$insert);
}
//------------------------------------ //Dennis Castillo [2022-05-19]
function newClients(){
  
  try{

    $CI =& get_instance();
    $CI->load->library("ws_sicas");
    $CI->load->library("FiltrosDeReportesSicas");
    $dates["fechaInicial"] = date("d/m/Y", mktime(0,0,0, date("n"), 1, date("Y")));
    $dates["fechaFinal"] = date("d/m/Y", mktime(0,0,0,date("n") + 1, 1, date("Y")));
    $comercialChannels = array("institucional", "fianzas", "cancun", "merida");
    $forInsert = array();

    foreach($comercialChannels as $dch){

      $filters = $CI->filtrosdereportessicas->obtenerFiltro($dch, 1, 3);
      $filters["filtroStatus"] = [];
      $sicasQuery = $dch == "fianzas" ? $CI->ws_sicas->polizasEmitidasDeClientesFianzas(array_merge($filters, $dates)) : $CI->ws_sicas->polizasEmitidasDeClientes(array_merge($filters, $dates));
      $newArray = array();

      if(!is_bool($sicasQuery) && property_exists($sicasQuery, "TableInfo")){
        
        foreach($sicasQuery->TableInfo as $data){

          if($dch == "fianzas"){
          
            $clientData = $CI->ws_sicas->obtenerClientePorID((Int)$data->IDCli);
            $data->FechaCap = !is_bool($clientData) && property_exists($clientData, "TableInfo") ? (String)$clientData->TableInfo->FechaCap : date("Y-m-d");
          }

          $newArray[(Int)$data->IDCli]["nombreCliente"] = (String)$data->NombreCompleto;
          $newArray[(Int)$data->IDCli]["IDCli"] = (String)$data->IDCli;
          $newArray[(Int)$data->IDCli]["despacho"] = (String)$data->DespNombre;
          $newArray[(Int)$data->IDCli]["gerencia"] = (String)$data->GerenciaNombre;
          $newArray[(Int)$data->IDCli]["canal"] = $dch;
          $newArray[(Int)$data->IDCli]["fechaCaptura"] = date("Y-m-d", strtotime((String)$data->FechaCap));
          $newArray[(Int)$data->IDCli]["esNuevoCliente"] = date("Y", strtotime((String)$data->FechaCap)) == date("Y") && date("m", strtotime((String)$data->FechaCap)) == date("n");
          $newArray[(Int)$data->IDCli]["fechaConsulta"] = date("Y-m-d H:i:s");
          $newArray[(Int)$data->IDCli]["subGroup"] = (String)$data->SubGrupo;
          $newArray[(Int)$data->IDCli]["papers"][] = array(
            "IDDocto" => (Int)$data->IDDocto, 
            "emissionDate" => date("Y-m-d", strtotime((String)$data->FEmision)), 
            "catchDate" => date("Y-m-d", strtotime((String)$data->FCaptura)),
            "status" => (Int)$data->Status,
          );
        }
      }

      $arrayFilter = array_filter(array_values($newArray), function($arr){
	
        $trueDate = array();
        if($arr["subGroup"] == "DXN CHIAPAS"){
  
          $clientCatchDate = explode("-", $arr["fechaCaptura"]);
          $catchDate = explode("-", $arr["papers"][0]["catchDate"]);
          $trueDate[] = $catchDate[0] >= $clientCatchDate[0] && $catchDate[1] >= $clientCatchDate[1];
        }
  
        return !in_array(false, $trueDate);
      });

      $map = array_map(function($arr){ 
        $arr["polizasRecientes"] = count($arr["papers"]); 
        unset($arr["papers"], $arr["subGroup"]); 
        return $arr; 
      }, $arrayFilter);
      
      if(!empty($map)){
    
        $this->db->trans_begin();

        foreach($map as $k => $data){
  
          $this->db->delete("catalog_clientes_nuevos", array("IDCli" => $data["IDCli"], "canal" => $data["canal"]));
          $this->db->insert("catalog_clientes_nuevos", $data);
        }
  
        if($this->db->trans_status() === FALSE){
          $this->db->trans_rollback();
          echo "Ocurrio un error en la carga";
        } else{
          $this->db->trans_commit();
          echo "Insercción realizado con éxito canal: ".$dch."\n";
        }
      }
    }
  } catch(Exception $e){
    echo "Nueva exepción capturada: ".$e->getMessage();
  }

	//$fp = fopen('resultadoJason.txt', 'a');fwrite($fp, print_r($fiancesQuery, TRUE));fclose($fp);
	//var_dump($newArray);
}
//------------------------------------
function agregarPrimasCer()
{
  $mes=date("m");$anio=date("Y");

if(isset($_GET['mes']) and isset($_GET['anio'])){$mes=$_GET['mes'];$anio=$_GET['anio'];}

        
  $consulta='select ((sum(e.Comision0*e.TCPago)+sum(e.Comision1*e.TCPago)+sum(e.Comision2*e.TCPago)+sum(e.Comision3*e.TCPago)
+sum(e.Comision4*e.TCPago)+sum(e.Comision5*e.TCPago)+sum(e.Comision6*e.TCPago)+sum(e.Comision7*e.TCPago)+sum(e.Comision8*e.TCPago)
+sum(e.Comision9*e.TCPago))) as monto from estadofinanciero e where e.Grupo="grupo cer" and e.RamosNombre="FIANZAS" and anio='.$anio.' and mes='.$mes;

    $datos=$this->db->query($consulta)->result();
    $monto=0;
    $this->db->where('anio',$anio);
    $this->db->where('mes',$mes);
    $this->db->where('idGrupoCer',1);
    $this->db->delete('avance_primas_pagadas_cer');
    if(count($datos>0)){$monto=$datos[0]->monto;}
    $insert['anio']=$anio;
    $insert['mes']=$mes;
    $insert['monto']=$monto;
    $insert['idGrupoCer']=1;
    $this->db->insert('avance_primas_pagadas_cer',$insert);

  $consulta='select ((sum(e.Comision0*e.TCPago)+sum(e.Comision1*e.TCPago)+sum(e.Comision2*e.TCPago)+sum(e.Comision3*e.TCPago)
+sum(e.Comision4*e.TCPago)+sum(e.Comision5*e.TCPago)+sum(e.Comision6*e.TCPago)+sum(e.Comision7*e.TCPago)+sum(e.Comision8*e.TCPago)
+sum(e.Comision9*e.TCPago))) as monto from estadofinanciero e where e.Grupo="grupo cer" and e.RamosNombre in ("DAÑOS","DANOS","DANIOS","Accidentes y Enfermedades","Vida") and anio='.$anio.' and mes='.$mes;
    $datos=$this->db->query($consulta)->result();
    $monto=0;
    $this->db->where('anio',$anio);
    $this->db->where('mes',$mes);
    $this->db->where('idGrupoCer',2);
    $this->db->delete('avance_primas_pagadas_cer');
    if(count($datos>0)){$monto=$datos[0]->monto;}
    $insert['anio']=$anio;
    $insert['mes']=$mes;
    $insert['monto']=$monto;
    $insert['idGrupoCer']=2;
    $this->db->insert('avance_primas_pagadas_cer',$insert);


      $consulta='select ((sum(e.Comision0*e.TCPago)+sum(e.Comision1*e.TCPago)+sum(e.Comision2*e.TCPago)+sum(e.Comision3*e.TCPago)
+sum(e.Comision4*e.TCPago)+sum(e.Comision5*e.TCPago)+sum(e.Comision6*e.TCPago)+sum(e.Comision7*e.TCPago)+sum(e.Comision8*e.TCPago)
+sum(e.Comision9*e.TCPago))) as monto from estadofinanciero e where e.Grupo="grupo cer" and e.SRamoNombre in ("Flotilla de Vehiculos","Automoviles Individuales")  and e.NombreCompleto="ALQUILADORA DE VEHICULOS AUTOMOTORES S.A DE C.V." and anio='.$anio.' and mes='.$mes;
    $datos=$this->db->query($consulta)->result();
    $monto=0;
    $this->db->where('anio',$anio);
    $this->db->where('mes',$mes);
    $this->db->where('idGrupoCer',3);
    $this->db->delete('avance_primas_pagadas_cer');
    if(count($datos>0)){$monto=$datos[0]->monto;}
    $insert['anio']=$anio;
    $insert['mes']=$mes;
    $insert['monto']=$monto;
    $insert['idGrupoCer']=3;
    $this->db->insert('avance_primas_pagadas_cer',$insert);


    $this->db->where('anio',$anio);
    $this->db->where('mes',$mes);
    $this->db->where('idGrupoCer',4);
    $this->db->delete('avance_primas_pagadas_cer');

        $insert['anio']=$anio;
    $insert['mes']=$mes;
    $insert['monto']=0;
    $insert['idGrupoCer']=4;
    $this->db->insert('avance_primas_pagadas_cer',$insert);

      $consulta='select ((sum(e.Comision0*e.TCPago)+sum(e.Comision1*e.TCPago)+sum(e.Comision2*e.TCPago)+sum(e.Comision3*e.TCPago)
+sum(e.Comision4*e.TCPago)+sum(e.Comision5*e.TCPago)+sum(e.Comision6*e.TCPago)+sum(e.Comision7*e.TCPago)+sum(e.Comision8*e.TCPago)
+sum(e.Comision9*e.TCPago))) as monto from estadofinanciero e where e.Grupo="grupo cer" and e.SRamoNombre in ("Flotilla de Vehiculos","Automoviles Individuales") and e.NombreCompleto!="ALQUILADORA DE VEHICULOS AUTOMOTORES S.A DE C.V." and anio='.$anio.' and mes='.$mes;
    $datos=$this->db->query($consulta)->result();
    $monto=0;
    $this->db->where('anio',$anio);
    $this->db->where('mes',$mes);
    $this->db->where('idGrupoCer',5);
    $this->db->delete('avance_primas_pagadas_cer');
    if(count($datos>0)){$monto=$datos[0]->monto;}
    $insert['anio']=$anio;
    $insert['mes']=$mes;
    $insert['monto']=$monto;
    $insert['idGrupoCer']=5;
    $this->db->insert('avance_primas_pagadas_cer',$insert);


  $insert=null;
  $consulta='select ((sum(e.Comision0*e.TCPago)+sum(e.Comision1*e.TCPago)+sum(e.Comision2*e.TCPago)+sum(e.Comision3*e.TCPago)
+sum(e.Comision4*e.TCPago)+sum(e.Comision5*e.TCPago)+sum(e.Comision6*e.TCPago)+sum(e.Comision7*e.TCPago)+sum(e.Comision8*e.TCPago)
+sum(e.Comision9*e.TCPago))) as monto from estadofinanciero e where e.IDVend!=7 and  anio='.$anio.' and mes='.$mes;
    $datos=$this->db->query($consulta)->result();
    $monto=0;
    $this->db->where('anio',$anio);
    $this->db->where('mes',$mes);
    $this->db->where('idAvanceCostoVenta',1);
    $this->db->delete('avaces_primas_pagadas_costoventa');
    if(count($datos>0)){$monto=$datos[0]->monto;}
    $insert['anio']=$anio;
    $insert['mes']=$mes;
    $insert['monto']=($monto*.7);
    $insert['idAvanceCostoVenta']=1;
    $this->db->insert('avaces_primas_pagadas_costoventa',$insert);
 //   $fp = fopen('resultadoJason.txt', 'w');fwrite($fp, print_r($datos));fclose($fp);
}
//------------------------------------ //Dennis Castillo [2022-06-28]
function cancelPendingVacationsRequest(){

  $response = array();
  $request = $this->db->where(array("aprobado" => 1, "DATE(fecha_salida)" => date("Y-m-d")))->get("vacaciones")->result();

  if(!empty($request)){
    exit("No se encontraron solicitudes para cancelar");
  }

  $this->db->trans_begin();

  foreach($request as $dr){

    $this->db->where("id", $dr->id)->update("vacaciones", array("aprobado" => -2, "estado" => "cancelado por el sistema"));
  }

  $response["success"] = $this->db->trans_status();

  if($this->db->trans_status() === FALSE){

    $this->db->trans_rollback();
    $response["message"] = "Ocurrió un error en el proceso. Favor de validar.";
  } else{

    $this->db->trans_commit();
    $response["message"] = "Registros actualizado con éxito.";
  }

  echo $response;
  //$fp = fopen('resultadoJason.txt', 'w');fwrite($fp, print_r($persons, true));fclose($fp);
  //var_dump($request);
}
//------------------------------------ //Dennis Castillo [2022-06-28]
function sendVacationNotification($date = null){ //Tarea programada que avisa por email dos días habilies antes de que un colaborador salga de vacaciones
  
  $this->load->model("personamodelo");
  $batch = array();
  $response = array();

  $_date = !empty($date) ? $date : date("Y-m-d");

  $this->db->select("
    b.nombre, d.email, 
    f.colaboradorArea, 
    g.personaPuesto, 
    e.fotoUser,
    b.cantidad_dias,
    DATE_FORMAT(b.fecha_salida, '%d/%m/%Y') AS fecha_salida,
    DATE_FORMAT(b.fecha_retorno, '%d/%m/%Y') AS fecha_retorno", 
    false
  );
  $this->db->join("vacaciones b", "b.id = a.reference_id", "left"); //Obtener vacaciones de esta fecha.
  $this->db->join("persona c", "c.idPersona = b.idPersona", "left");
  $this->db->join("users d", "d.idPersona = c.idPersona", "left");
  $this->db->join("user_miInfo e", "e.idPersona = c.idPersona", "left");
  $this->db->join("colaboradorarea f", "f.idColaboradorArea = c.idColaboradorArea", "left");
  $this->db->join("personapuesto g", "g.idPuesto = c.idPersonaPuesto", "left");
  $this->db->where(array("DATE(a.preSendDate)" => $_date, "a.way" => "mail", "c.bajaPersona" => 0, "d.banned" => 0, "d.activated" => 1));
  $dates = $this->db->get("pre_vacation_notification a")->result();

  if(empty($dates)){
    exit("No se encontraron resultados");
  }

  $persons = array_filter($this->personamodelo->obtenerPersonas("SISTEMAS@ASESORESCAPITAL.COM", 1), function($arr){ return $arr->tipoPersona == 1 && filter_var($arr->email, FILTER_VALIDATE_EMAIL); });
  $message = $this->load->view("persona/vacationResponse/vacationAlert", array("persons" => $dates), true);

  $this->db->trans_begin();

  foreach($persons as $dp){
    
    $this->db->insert("envio_correos", array(
      "desde" => "Avisos de GAP<avisosgap@aserorescapital.com>",
      "para" => $dp->email,
      "asunto" => "Aviso de próximos colaboradores en salir de vacaciones",
      "mensaje" => $message
    ));
  }

  $response["succcess"] = $this->db->trans_status();

  if($this->db->trans_status() === FALSE){
    $this->db->trans_rollback();
    $response["message"] = "Ocurrió un detalle al momento de realizar la carga";
    //echo "Ocurrió un detalle al momento de realizar la carga";
  } else{
    $this->db->trans_commit();
    $response["message"] = "Aviso realizado con éxito";
    //echo "Aviso realizado con éxito";
  }

  echo json_encode($response);
 
  //var_dump($persons);
}
//-----------------------------------------------------------
function metaComercialCierreAutomaticoMensual()
{
  $this->load->model('metacomercial_modelo');
     $mes_asignacion=array(1=>"Enero", 2=>"Febrero", 3=>"Marzo", 4=>"Abril", 5=>"Mayo", 6=>"Junio", 7=>"Julio", 8=>"Agosto", 9=>"Septiembre", 10=>"Octubre", 11=>"Noviembre", 12=>"Diciembre");
    $mesComercialActivado=$this->metacomercial_modelo->devuelveActivacionComercial();
      $mes_anterior = !empty($mesComercialActivado[1]->mes_activado) ? $mes_asignacion[$mesComercialActivado[1]->mes_activado]. " - " . $mesComercialActivado[1]->anio : "Sin cierre";
      $mes_actual = !empty($mesComercialActivado[0]->mes_activado) ? $mes_asignacion[$mesComercialActivado[0]->mes_activado]. " - " . $mesComercialActivado[0]->anio : "Sin cierre";
      $mes_num = !empty($mesComercialActivado[0]->mes_activado) ? $mesComercialActivado[0]->mes_activado : 0;
      $fecha_cierre = !empty($mesComercialActivado[0]->fecha_activacion) ? $mesComercialActivado[0]->fecha_activacion : "Sin cierre";
      $anio_num = !empty($mesComercialActivado[0]->anio) ? $mesComercialActivado[0]->anio : date("Y");

    $mesCierre = ($mes_num == 12)?  1 : $mes_num + 1;
    $anioCierre = ($mes_num == 12)?  $anio_num + 1 : $anio_num;
  date_default_timezone_set('America/Mexico_City');
  $insert = $this->metacomercial_modelo->activacion_consulta_comercial(array(
    "fecha_activacion" => date("Y-m-d H:i:s"),
    "mes_activado" => $mesCierre,
    "anio" => $anioCierre,
    "cuenta_cierre" => 'AUTOMATICO',
    "cierre" =>  true 
  ));

  
}
//-----------------------------------------------------------
function envioRecordatorioMetaComercialMesAnterior()
{
          $guardaMensaje['desde']="Avisos de GAP<avisosgap@aserorescpital.com>";
        $guardaMensaje['para']='DATACENTER@AGENTECAPITAL.COM';
        $guardaMensaje['asunto']="Meta Comercial";
        $guardaMensaje['mensaje']='Despues de tu cierre los dias 18 de cada mes, no se te olvide refrescar las metas comerciales en CAPSYS';
        $guardaMensaje['status']=0;
         
       $this->db->insert('envio_correos',$guardaMensaje);
}
//-----------------------------------------------------------
function felicitacionesParaAgente()
{
   $this->load->model("notificacionmodel");
  $consulta="select * from enviofelicitacionventanueva where yaFueFelicitado=0";  
  $felicitaciones=$this->db->query($consulta)->result();
  foreach ($felicitaciones as  $value) 
  {
    $consulta='select u.email,u.idPersona from users u where u.banned=0 and u.activated=1 and u.IDVend='.$value->IDVend;
      $datosVendedor=$this->db->query($consulta)->result()[0];
     // $fp = fopen('resultadoJason.txt', 'a');fwrite($fp, print_r($datosVendedor, TRUE));fclose($fp);
     $email=$datosVendedor->email;//'DESARROLLO@AGENTECAPITAL.COM';
     $idPersona=$datosVendedor->idPersona;//25;
    $guardaMensaje['desde']="Avisos de GAP<avisosgap@aserorescpital.com>";
    $guardaMensaje['para']=$email;
    $guardaMensaje['asunto']="Pago de Venta nueva";
    $guardaMensaje['mensaje']='<div>Hola '.$value->VendNombre.' el primer recibo del documento '.$value->Documento.' ya se pago</div><div><h2>FELICIDADES YA TIENES UNA VENTA NUEVA</h2></div><div style="height:130px;background-image:url(https://capsys.com.mx/V3/assets/images/logo/B960X115.png);visibility: visible;    background-repeat: no-repeat;margin-bottom: 0px;
    background-color: white;"></div>';
        $guardaMensaje['status']=0;         
       $this->db->insert('envio_correos',$guardaMensaje);
       $update='update enviofelicitacionventanueva set yaFueFelicitado=1 where IDRecibo='.$value->IDRecibo;
       $this->db->query($update);
                          $notificacion['tabla']='enviofelicitacionventanueva';
                    $notificacion['idTabla']=$value->IDRecibo;
                    $notificacion['persona_id']=$idPersona;
                    $notificacion['email']=  '';
                    $notificacion['tipo_id']='email';
                    $notificacion['referencia']='Venta Nueva';
                    $notificacion['referencia_id']='1000';
                    $notificacion['check']=0;
                    $notificacion['comentarioAdicional']='Felicidades '.$value->VendNombre.' el primer recibo del documento '.$value->Documento.' ya se pago. Tienes una venta nueva';
                    $notificacion['id']=-1;
                    $notificacion['tipo']='OTRO';
                    $notificacion['controlador']='';
                    $this->notificacionmodel->notificacion($notificacion);   
  }
}
//-----------------------------------------------------------

}