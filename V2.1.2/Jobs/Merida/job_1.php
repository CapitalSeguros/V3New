<?php
include('../../includes/funcionesDre.php');
$conexion = DreConectarDB();
extract($_REQUEST);

	$sqljod = "
		Insert Into `agenda`
			(`cita`)
			Values
			('jobs')
			  ";
//	DreQueryDB($sqljod);
	
	DreMail('','juanjose@dre-learning.com','','','Jobsss','demo','','');
	echo "Envio Correo Ok!!!";
	

?>