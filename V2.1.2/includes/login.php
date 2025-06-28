<?php
session_start();
include('../config/funcionesDre.php');
	if(DreLogin($_REQUEST['user'],$_REQUEST['pass'])){
		$loginData = DreLoginData($_REQUEST['user'],$_REQUEST['pass']);
		
		$_SESSION['WebDreTacticaWeb2'] = array(
			'Usuario'=>$loginData['Usuario']
			,'Vendedor'=>$loginData['Vendedor']
			,'Nivel'=>$loginData['Nivel']
			,'Nombre'=>$loginData['Nombre']
			,'Sucursal'=>$loginData['Sucursal']
			,'Promotor'=>$loginData['Promotor']
			,'Email'=>$loginData['Email']
			,'Telefono'=>$loginData['Telefono']
			,'Movil'=>$loginData['Movil']
			,'Tipo'=>$loginData['Tipo']
			,'Integral'=>$loginData['Integral']
			,'MailMasivo'=>$loginData['MailMasivo']
			,'Ranking'=>$loginData['Ranking']
			,'Grupo'=>$loginData['Grupo']
			,'usuarioCotiza'=>''
			,'arregloPermisos'=>$loginData['arregloPermisos']
											 );		
		header("Location: ../inicio.php");
	} else {
		session_unset();
		unset($_SESSION['WebDreTacticaWeb2']);
 		session_destroy();
	$version = "V2.1.2";
	//header("Location: http://www.capsys.com.mx/".$version."/indexLogin.php");
	header("Location: ../indexLogin.php");
	}
?>