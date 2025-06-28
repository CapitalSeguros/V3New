<?php
include('../Config/funcionesDreFireBird.php');
include('../../config/funcionesDre.php');

$conexFireBird = DreConectarDbFireBird();
$conexMySql = DreConectarDB();

	$sqlFireBird_Validacion_Registros = "
		Select 
			Count(*) As EXISTEN_REGISTROS 
		From 
			USUARIOS_USUARIO
		Where 
			TOCADO Like '%XX%'
										";
	$resFireBird_Validacion_Registros = DreQueryDbFireBird($sqlFireBird_Validacion_Registros);
	$rowFirebird_Validacion_Registros = ibase_fetch_object($resFireBird_Validacion_Registros);
	DreFreeResultDbFireBird($rowFirebird_Validacion_Registros);
	
	if((int)$rowFirebird_Validacion_Registros->EXISTEN_REGISTROS > 0){
		echo "si hay registros a procesar";
	
		$sqlMysql_Truncate_USUARIOS_USUARIO = "Truncate Table `usuario_usuarios`";
		DreQueryDB($sqlMysql_Truncate_USUARIOS_USUARIO);
		
		$sqlFireBird = "
			Select * From 
				USUARIOS_USUARIO
			Where 
				TOCADO Like '%XX%'
					   ";
		$resFireBird = DreQueryDbFireBird($sqlFireBird);

		while ($fila = ibase_fetch_object($resFireBird)) {
			
			$sqlMysql_Insert_USUARIOS_USUARIO = "
				Insert Into
					`usuario_usuarios`
						(
							`Usuario`
							,`UsuarioValor`
						)
					Values
						(
							'".$fila->OPERADOR."'
							,'".$fila->OPERADOR_DEST."'
						);
										  ";
			echo "<pre>";
				echo $sqlMysql_Insert_USUARIOS_USUARIO;
			echo "</pre>";
			DreQueryDB($sqlMysql_Insert_USUARIOS_USUARIO);
		}

	$sqlFireBird_Update_USUARIOS_USUARIO = "
		Update 
			USUARIOS_USUARIO 
		Set 
			TOCADO = 'SI'
			,FECHAPROCESO = '".date('Y-m-d g:i')."'
												 ";
	$resFireBird_Update_USUARIOS_USUARIO = DreQueryDbFireBird($sqlFireBird_Update_USUARIOS_USUARIO);

	DreFreeResultDbFireBird($resFireBird_Update_USUARIOS_USUARIO);

		
	} else {

		echo "no hay registros a procesar";
		
	} // Fin  Validacion Existen Registros

echo "Actualizacion de Correcta !!!";
include('CerrarVentana.php');

DreDesconectarDbFireBird($conexFireBird);
DreDesconectarDB($conexMySql);
?>