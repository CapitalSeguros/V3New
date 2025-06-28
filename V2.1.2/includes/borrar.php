<?php
session_start();
extract($_REQUEST);
if(	$seccion != "index"){
	if(!isset($_SESSION['WebDreTacticaWeb2'])){ header("Location: index.php"); }
	if(!isset($_SESSION['WebDreTacticaWeb2']['Usuario'])){ header("Location: index.php"); }
}
include('../config/funcionesDre.php');
	$conexion = DreConectarDB();
		
// Edicion Contacto
if($_REQUEST['tipoEliminar'] == 'Empleado'){	
	$sqlUpdateBorrarEmpleado = "
		Update
			`miinfo_empleados`
		Set
			`status` = '1'
		Where
			`idEmpleado` = '$CLAVE'
							   ";
	DreQueryDB($sqlUpdateBorrarEmpleado);
	

	$return = "../directorio.php";
	?>
    <script language="javascript" type="text/javascript">
		alert('Empleado Eliminado Con Exito !!!');
		window.open('<?php echo $return; ?>','_self');
	</script>
	<?php
}
DreDesconectarDB($conexion);
?>
