<?php
class email_model extends CI_Model{
var $emailUser;
	var $idPersona;
	function __construct(){
		parent::__construct();
     $this->emailUser=$this->tank_auth->get_usermail();
     $this->idPersona=$this->tank_auth->get_idPersona();

	}
function clienteParaCapitalRisk($array){
	$correo['para'] ='CONSULTOR@CAPITALRISK.COM.MX';
    $correo['asunto']='Nuevo cliente!';
    $mensaje='<div>Un cliente con caracteristicas para capital risk se ha detectado</div>';
    $mensaje.='<div>Correo del usuario creador:'.$array['usuarioCreacion'].'</div>';
    $mensaje.='<div>Ramo:'.$array['subRamo'].'</div>';
    $mensaje.='<div>Nombre del cliente:'.$array['nombreCliente'].'</div>';
    $mensaje.='<div>Telefono:'.$array['Telefono1'].'</div>';
    $mensaje.='<div>Correo:'.$array['EMail1'].'</div>';
     $correo['mensaje']=$mensaje;
    $correo['identificaModulo']="clienteParaCapitalRisk";
    $this->enviarCorreo($correo);

}
//------------------------------------------------------------
function clienteParaFianzas($array){
	//$correo['para'] ='GERENTE@FIANZASCAPITAL.COM';
    $correo['para'] ='COORDINADORCOMERCIAL@FIANZASCAPITAL.COM';
    $correo['asunto']='Nuevo cliente!';
    $mensaje='<div>Un cliente se ha detectado</div>';
    $mensaje.='<div>Correo del usuario creador:'.$array['usuarioCreacion'].'</div>';
    $mensaje.='<div>Sub ramo:'.$array['ramo'].'</div>';
    $mensaje.='<div>Sub ramo:'.$array['subRamo'].'</div>';
    $mensaje.='<div>Nombre del cliente:'.$array['nombreCliente'].'</div>';
    $mensaje.='<div>Telefono:'.$array['Telefono1'].'</div>';
    $mensaje.='<div>Correo:'.$array['EMail1'].'</div>';
    $mensaje.='<div>Giro:'.$array['nombreGiro'].'</div>';
    $mensaje.='<div>Actividad:'.$array['giroActividad'].'</div>';
    $mensaje.='<div>Estado:'.$array['nombreEstado'].'</div>';
     $correo['mensaje']=$mensaje;
    $correo['identificaModulo']="clienteParaFianzas";
    $this->enviarCorreo($correo);	
}
//------------------------------------------------------------
function clientesParaServiciosEspeciales($array)
{
 
    $correo['para'] ='serviciosespeciales@agentecapital.com';
    $correo['asunto']='Nuevo cliente!';
    $mensaje='<div>Un cliente se ha detectado</div>';
    $mensaje.='<div>Correo del usuario creador:'.$array['usuarioCreacion'].'</div>';
    $mensaje.='<div>Sub ramo:'.$array['ramo'].'</div>';
    $mensaje.='<div>Sub ramo:'.$array['subRamo'].'</div>';
    $mensaje.='<div>Nombre del cliente:'.$array['nombreCliente'].'</div>';
    $mensaje.='<div>Telefono:'.$array['Telefono1'].'</div>';
    $mensaje.='<div>Correo:'.$array['EMail1'].'</div>';
    $mensaje.='<div>Giro:'.$array['nombreGiro'].'</div>';
    $mensaje.='<div>Actividad:'.$array['giroActividad'].'</div>';
    $mensaje.='<div>Estado:'.$array['nombreEstado'].'</div>';
     $correo['mensaje']=$mensaje;
    $correo['identificaModulo']="clienteServiciosEspeciales";
    $this->enviarCorreo($correo);   

}
//------------------------------------------------------------
function enviarCorreo($array)
{

	        $guardaMensaje['desde']="Avisos de GAP<avisosgap@aserorescpital.com>";
        $guardaMensaje['para']=$array['para'];
        $guardaMensaje['asunto']=$array['asunto'];
        $guardaMensaje['mensaje']=$array['mensaje'];
           $guardaMensaje['identificaModulo']=$array['identificaModulo']; 
        $guardaMensaje['status']=0;
        if(isset($array['tabla'])){$guardaMensaje['tabla']=$array['tabla'];}
        if(isset($array['idTabla'])){$guardaMensaje['idTabla']=$array['idTabla'];}

     
        $guardaMensaje['fechaEnvio']='1900-01-01 00:00:00';
        $this->db->insert('envio_correos',$guardaMensaje);
}

    function SendEmail($email) {
        $this->db->insert('envio_correos',$email);
        return "Enviado";
    }
}
?>