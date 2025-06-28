<?php
include('../../config/funcionesDre.php');
$conexMySql = DreConectarDB();

echo "<pre>";

$sqlConsulta_ImgSinc = "
	Select * From 
		`imagenes_sinc`
	Where
		`actualizado` = '0'
	Order By 
		`NO_ARCHIVO` Asc
	Limit 
		0,5000
				   ";
$resConsulta_ImgSinc = DreQueryDB($sqlConsulta_ImgSinc);
while($rowConsulta_ImgSinc = mysql_fetch_assoc($resConsulta_ImgSinc)){
/*echo*/	$sqlConsulta_Img = "
		Select 
			* 
			, Count(*) As `ExisteNoArchivo`
		From 
			`imagenes`
		Where
			`NO_ARCHIVO` = '".$rowConsulta_ImgSinc['NO_ARCHIVO']."'
					   ";
	$resConsulta_Img = DreQueryDB($sqlConsulta_Img);
	$rowConsulta_Img = mysql_fetch_assoc($resConsulta_Img);

//-->	echo $rowConsulta_Img['ExisteNoArchivo'];
//-->	print_r($rowConsulta_ImgSinc);
	
	if($rowConsulta_Img['ExisteNoArchivo'] == 0){
/*echo*/		$sqlInsert_ImgSinc = "		
			Insert Into
				`imagenes` 
						(
							`NO_ARCHIVO`
							, `EXTENSION`
							, `RUTA`
							, `DESCRIPCION`
							, `TIPO`
							, `POLIZA`
							, `VALOR`
							, `TIPO_IMG`
							, `ESTATUS`
							, `CLIENTE_MPRO`
							, `CLIENTE_TMP`
							, `NOMBRE_CLIENTE`
							, `FECHA_ALTA`
							, `SUCURSAL`
							, `recId`
							, `idUsuario`
							, `subRamo`
							, `actualizado` 
						) 
						VALUES 
						(
							'".$rowConsulta_ImgSinc['NO_ARCHIVO']."'
							,'".$rowConsulta_ImgSinc['EXTENSION']."'
							,'".$rowConsulta_ImgSinc['RUTA']."'
							,'".$rowConsulta_ImgSinc['DESCRIPCION']."'
							,'".$rowConsulta_ImgSinc['TIPO']."'
							,'".$rowConsulta_ImgSinc['POLIZA']."'
							,'".$rowConsulta_ImgSinc['VALOR']."'
							,'".$rowConsulta_ImgSinc['TIPO_IMG']."'
							,'".$rowConsulta_ImgSinc['ESTATUS']."'
							,'".$rowConsulta_ImgSinc['CLIENTE_MPRO']."'
							,'".$rowConsulta_ImgSinc['CLIENTE_TMP']."'
							,'".$rowConsulta_ImgSinc['NOMBRE_CLIENTE']."'
							,'".$rowConsulta_ImgSinc['FECHA_ALTA']."'
							,'".$rowConsulta_ImgSinc['SUCURSAL']."'
							,'".$rowConsulta_ImgSinc['recId']."'
							,'".$rowConsulta_ImgSinc['idUsuario']."'
							,'".$rowConsulta_ImgSinc['subRamo']."'
							,'".$rowConsulta_ImgSinc['actualizado']."'
						)
							 ";
		$resInsert_ImgSinc = DreQueryDB($sqlInsert_ImgSinc);


	}

	$sqlUpdate_ImgSinc = "
		Update
			`imagenes_sinc`
		Set
			`actualizado` = '1'
		Where
			`NO_ARCHIVO` = '".$rowConsulta_ImgSinc['NO_ARCHIVO']."'
					   ";
	$resUpdate_ImgSinc = DreQueryDB($sqlUpdate_ImgSinc);
}

echo "Actualizacion de Correcta !!!";
include('CerrarVentana.php');

echo "</pre>";
DreDesconectarDB($conexMySql);
?>