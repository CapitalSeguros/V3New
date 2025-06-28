<?php
session_start();
extract($_REQUEST);
if(	$seccion != "index"){
	if(!isset($_SESSION['WebDreTacticaWeb2'])){ header("Location: index.php"); }
	if(!isset($_SESSION['WebDreTacticaWeb2']['Usuario'])){ header("Location: index.php"); }
}

include('../config/funcionesDre.php');
	$conexion = DreConectarDB();

// tipoAgregar Actividad
if($_REQUEST['tipoTarjeta'] == 'general'){

	$yerarExpira = "20".substr($EXPIRA, 2, 2);
	$monthExpira = substr($EXPIRA, 0, 2);
	$dayExpira = "01";
	
$expiraFecha = $yerarExpira."-".$monthExpira."-".$dayExpira;
	
	
	
	$sqlInsert_Tarjeta = "
		Insert Into
			`clientes_tarjeta` 
				(
					`CLAVE_CLIENTE`
					, `NUMERO_TARJETA`
					, `CODIGO_SEGURIDAD`
					, `EXPIRA`
					, `TIPO`
					, `BANCO`
					, `NOMBRE_TITULAR`
				) VALUES (
					'$idRefCliente'
					, '$NUMERO_TARJETA'
					, '$CODIGO_SEGURIDAD'
					, '$expiraFecha' -- EXPIRA
					, '$TIPO'
					, '$BANCO'
					, '$NOMBRE_TITULAR'
				);
						 ";
	DreQueryDB($sqlInsert_Tarjeta);
	$idClienteTarjeta = mysql_insert_id();

	$return = "../actividadesAgregar.php?";
	$return.= "idRefCliente=".$idRefCliente;
	$return.= "&usuarioCreacion=".$usuarioCreacion;
	$return.= "&Actividad=".$Actividad;
	$return.= "&Ramo=".$Ramo;
	$return.= "&SubRamo=".$SubRamo;
	$return.= "&tipoCliente=".$tipoCliente;
	$return.= "&condicionesPago=".$condicionesPago;
	$return.= "&conductoCobro=".$conductoCobro;
	$return.= "&idClienteTarjeta=".$idClienteTarjeta
?>
<script>
	alert('Su tarjeta ha sido agregada con exito: <? echo $recId; ?>');
	window.open('<? echo $return; ?>','_self');
</script>
<?
}

DreDesconectarDB($conexion);
?>