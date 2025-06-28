<?php
extract($_REQUEST);
include('../config/funcionesDre.php');
	$conexion = DreConectarDB();
		
// tipoAgregar Contacto
if($_REQUEST['tipoSending'] == "todo"){

	$sqlConsultaEnvioPendiente = "
	Select * From 
		`tmp_envio_correos`
	Where 
		`para` != ''
		And
		`status` = '0'
	Limit 0, 10
								 ";
	$resConsultaEnvioPendiente = DreQueryDB($sqlConsultaEnvioPendiente);
	while($rowConsultaEnvioPendiente = mysql_fetch_assoc($resConsultaEnvioPendiente)){
		extract($rowConsultaEnvioPendiente);
		
		DreMail($desde,$para,$copia,$copiaOculta,$asunto,$mensaje,$fileAdjunto,$nameAdjunto);
		
		$sqlMarcamosCorreo = "
			Update 
				`tmp_envio_correos`
			Set
				  `status` = '1'
				, `fechaEnvio` = '".date('Y-m-d h:i:s')."'
			Where 
				`idCorreo` = '$idCorreo'
							 ";
		DreQueryDB($sqlMarcamosCorreo);
		echo "Enviando Correo Id=>".$idCorreo."<br>";
		//sleep(1);
	}
	
	echo "Envio de Correcta !!!";
	include('CerrarVentana.php');	
}

DreDesconectarDB($conexion);
?>