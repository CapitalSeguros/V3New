<?php
session_start();
		session_unset();
		unset($_SESSION['WebDreTacticaWeb2']);
 		session_destroy();
	$version = "V2.1.2";
	//header("Location: http://www.capsys.com.mx/".$version."/indexLogin.php");
	header("Location: ../indexLogin.php");
		// header("Location: ../index.php");
?>