<?php
include('../../config/funcionesDre.php');
$conexMySql = DreConectarDB();

echo "<pre>";

$sqlConsulta_ContSinc = "
	Select * From 
		`contactos_sinc`
	Where
		`actualizado` = '0'
	Order By 
		`CLAVECLIENTE`, `TIPO` Asc
	Limit 
		0,5000
				   ";
$resConsulta_ContSinc = DreQueryDB($sqlConsulta_ContSinc);
while($rowConsulta_ContSinc = mysql_fetch_assoc($resConsulta_ContSinc)){
/*echo*/ 	$sqlConsulta_Cont = "
		Select 
			* 
			, Count(*) As `ExisteNoArchivo`
		From 
			`contactos`
		Where
			`CLAVE` = '".$rowConsulta_ContSinc['CLAVECLIENTE']."'
			And
			`TIPO` = '".$rowConsulta_ContSinc['TIPO']."'
					   ";
	$resConsulta_Cont = DreQueryDB($sqlConsulta_Cont);
	$rowConsulta_Cont = mysql_fetch_assoc($resConsulta_Cont);
	
	if($rowConsulta_Cont['ExisteNoArchivo'] == 0){
		
/*echo*/		$sqlInsert_ImgSinc = "		
			Insert Into
				`contactos` 
						(
							`CLAVE`
							, `TIPO`
							, `NOMBRE`
							, `EMAIL`
							, `TELEFONO`
							, `DIRECCION`
							, `VENDEDOR`
							, `promotor`
							, `SUCURSAL`
							, `CLAVEWEB`
							, `fechaCreacion`
							, `actualizado`
							, `correoMasivo`
							, `ES_DIR_PRINCIPAL` 
						) 
						VALUES 
						(
							'".$rowConsulta_ContSinc['CLAVECLIENTE']."'
							,'".$rowConsulta_ContSinc['TIPO']."'
							,'".$rowConsulta_ContSinc['NOMBRE']."'
							,'".$rowConsulta_ContSinc['EMAIL']."'
							,'".$rowConsulta_ContSinc['TELEFONO']."'
							,'".$rowConsulta_ContSinc['DIRECCION']."'
							,'".$rowConsulta_ContSinc['VENDEDOR']."'
							,'".$rowConsulta_ContSinc['PROMOTOR']."'
							,'".$rowConsulta_ContSinc['SUCURSAL']."'
							,'".$rowConsulta_ContSinc['CLAVEWEB']."'
							,'".date('Y-m-d')."'
							,''
							,''
							,'".$rowConsulta_ContSinc['ES_DIR_PRINCIPAL']."'
						)
							 ";
	$resInsert_ImgSinc = DreQueryDB($sqlInsert_ImgSinc);
	}

	$sqlUpdate_ImgSinc = "
		Update
			`contactos_sinc`
		Set
			`actualizado` = '1'
		Where
			`CLAVECLIENTE` = '".$rowConsulta_ContSinc['CLAVECLIENTE']."'
			And
			`TIPO` = '".$rowConsulta_ContSinc['TIPO']."'
					   ";
	$resUpdate_ImgSinc = DreQueryDB($sqlUpdate_ImgSinc);
}

echo "Actualizacion de Correcta !!!";
include('CerrarVentana.php');

echo "</pre>";
DreDesconectarDB($conexMySql);
?>