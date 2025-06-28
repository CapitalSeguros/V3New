<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class daemon_notificaciones_prospectos extends CI_Controller{
	function __construct(){
		parent::__construct();
	}
function index(){
	//$this->notificaciones_leads();
	$this->test();
}


function test(){
	$fechaEnvio=date('Y-m-d H:m:s');
	$mensaje="<center><h1>Esta es un test</h1></center>";
	$email="migueload@gmail.com";
	$sql="INSERT INTO envio_correos(desde,para,asunto,mensaje,status,fechaEnvio) VALUE('Avisos de GAP<avisosgap@aserorescapital.com>','$email','Notificacion:Asigación de Prospecto','$mensaje','0','$fechaEnvio')";
	$this->db->query($sql);
}

function listar_notificaciones(){
	$this->notificaciones_primer_cita();
	$this->notificaciones_cierre();
	$this->notificaciones_leads();
	$data['primeracita']=$this->crmProyecto_Model->cliente_primera_cita_notificacion();
	$data['cierre']=$this->crmProyecto_Model->cliente_cierre_notificacion();
	$data['leads']=$this->crmProyecto_Model->cliente_leads_notificacion();
	$this->load->view('crmproyecto/listar_notificaciones',$data);

}

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
   	 			$ins="INSERT into clientes_actualiza_notificacion(IDCli,EstadoActual,fechaActualizacion,tipo_prospecto) values('$row->IDCli','$row->EstadoActual','$fechaActualizacion',0) ";
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
				$ins="INSERT into clientes_actualiza_notificacion(IDCli,EstadoActual,fechaActualizacion,tipo_prospecto) values('$row->IDCli','$row->EstadoActual','$fechaActualizacion',0) ";
   	 			$this->db->query($ins);
	 		}
 		}
	}
}

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
$email='';
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
$fechaEnvio=date('Y-m-d H:m:s');
$sql="INSERT INTO envio_correos(desde,para,asunto,mensaje,status,fechaEnvio) VALUE('Avisos de GAP<avisosgap@aserorescapital.com>','$email','Notificacion:Asignación de Prospecto','$mensaje','0','$fechaEnvio')";
$this->db->query($sql);
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
    		<b>Nota:</b>&nbsp; Favor comunicarse con el prospecto lo mas pronto posible, de lo contrario el mismo sera escalado a su jefe inmediato.
    	</td>
    </tr>
</table>
</body>
</html>";
$fechaEnvio=date('Y-m-d H:m:s');
$sql="INSERT INTO envio_correos(desde,para,asunto,mensaje,status,fechaEnvio) VALUE('Avisos de GAP<avisosgap@aserorescapital.com>','$email','Notificacion:Asignación de Prospecto','$mensaje','0','$fechaEnvio')";
$this->db->query($sql);
}

function notificaciones_leads(){
	//Primer Escala
	$sw=$this->crmProyecto_Model->existeNotificacion($row->IDCli);
	if(count($sw)>0){
		$hoy=date('d-m-Y H:m:s');
		$fecha_hora1=explode(' ',$hoy);
		$fecha1=$fecha_hora1[0];
		$hora1=$fecha_hora1[1];
		$hora1=explode(':',$hora1);
		$hora1=$hora1[0];
		$data=$this->crmProyecto_Model->cliente_leads();
		foreach ($data as $row){ 
			$fecha_hora2=explode(' ',$row->fechaActualizacion);
			$fecha2=$fecha_hora2[0];
			$hora2=$fecha_hora2[1];
			$hora2=explode(':',$hora2);
			$hora2=$hora2[0];
			if($fecha1==$fecha2){
				$t_hora=$hora2-$hora1;
				if($t_hora>=1){
					$ins="UPDATE clientes_actualiza_notificacion SET EstadoActual='$row->EstadoActual', escala='1' WHERE IDCli='$row->IDCli'";
	   	 			$this->db->query($ins);
				}else{
					$ins="INSERT into clientes_actualiza_notificacion(IDCli,EstadoActual,fechaActualizacion,tipo_prospecto) values('$row->IDCli','$row->EstadoActual','$hoy',3)";
	   	 			$this->db->query($ins);
	   	 			$this->enviarCorreo($this->tank_auth->get_idPersona(),$row->IDCli);
		 		}
			}
		}
	}
	//Segunda Escala
	$swX=$this->crmProyecto_Model->existeNotificacionEscala($row->IDCli);
	if(count($swX)>0){
		foreach ($data as $row){ 
			$fecha_hora2=explode(' ',$row->fechaActualizacion);
			$fecha2=$fecha_hora2[0];
			$hora2=$fecha_hora2[1];
			$hora2=explode(':',$hora2);
			$hora2=$hora2[0];
			if($fecha1==$fecha2){
				$t_hora=$hora2-$hora1;
				if($t_hora>=2){
				$ins="UPDATE clientes_actualiza_notificacion SET escala=2 WHERE IDCli='$row->IDCli'";
				 $this->db->query($ins);
				 $this->enviarCorreoEscalado($this->tank_auth->get_idPersona(),$row->IDCli);
				}
			}
		}
	}
}


}
