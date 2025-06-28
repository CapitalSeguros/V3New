<?php
include('../Config/funcionesDreFireBird.php');
include('../../config/funcionesDre.php');

$conexFireBird = DreConectarDbFireBird();
$conexMySql = DreConectarDB();

echo "<pre>";

/*echo*/ $sqlMysqlConsulta_Img = "
	Select 
		* 
	From
		`imagenes`
	Limit
		10000, 5000
						";
$resMysqlConsulta_Img = DreQueryDB($sqlMysqlConsulta_Img);
$cont = 0;
while($rowMysqlConsulta_Img = mysql_fetch_assoc($resMysqlConsulta_Img)){
//	echo $cont++;
//	echo "<br>";

// NO_ARCHIVO	
$var_SqlFireBird_NO_ARCHIVO 
	= 
	"'".substr($rowMysqlConsulta_Img['NO_ARCHIVO'],0,50)."'";
// EXTENSION
$var_SqlFireBird_EXTENSION 
	= 
	"'".substr($rowMysqlConsulta_Img['EXTENSION'],0,20)."'";

// RUTA
$var_SqlFireBird_RUTA
	= 
	($rowMysqlConsulta_Img['RUTA']!='')? "'".substr($rowMysqlConsulta_Img['RUTA'],0,200)."'" : " NULL";

// DESCRIPCION
$var_SqlFireBird_DESCRIPCION
	=
	($rowMysqlConsulta_Img['DESCRIPCION']!='')? "'".substr($rowMysqlConsulta_Img['DESCRIPCION'],0,100)."'" : " NULL";
	
// TIPO
$var_SqlFireBird_TIPO
	=
	($rowMysqlConsulta_Img['TIPO']!='')? "'".substr($rowMysqlConsulta_Img['TIPO'],0,2)."'" : " NULL";
	
// POLIZA
$var_SqlFireBird_POLIZA
	=
	($rowMysqlConsulta_Img['POLIZA']!='')? "'".substr($rowMysqlConsulta_Img['POLIZA'],0,50)."'" : " NULL";
	
// VALOR
$var_SqlFireBird_VALOR
	=
	($rowMysqlConsulta_Img['VALOR']!='')? "'".substr($rowMysqlConsulta_Img['VALOR'],0,50)."'" : " NULL";

// TIPO_IMG
$var_SqlFireBird_TIPO_IMG
	=
	($rowMysqlConsulta_Img['TIPO_IMG']!='')? "'".substr($rowMysqlConsulta_Img['TIPO_IMG'],0,30)."'" : " NULL";
	
// ESTATUS
$var_SqlFireBird_ESTATUS
	=
	($rowMysqlConsulta_Img['ESTATUS']!='')? "'".substr($rowMysqlConsulta_Img['ESTATUS'],0,2)."'" : " NULL";

// CLIENTE_MPRO
$var_SqlFireBird_CLIENTE_MPRO
	=
	($rowMysqlConsulta_Img['CLIENTE_MPRO']!='')? "'".substr($rowMysqlConsulta_Img['CLIENTE_MPRO'],0,10)."'" : " NULL";
	
// CLIENTE_TMP
$var_SqlFireBird_CLIENTE_TMP
	=
	($rowMysqlConsulta_Img['CLIENTE_TMP']!='')? "'".substr($rowMysqlConsulta_Img['CLIENTE_TMP'],0,10)."'" : " NULL";
	
// NOMBRE_CLIENTE
$var_SqlFireBird_NOMBRE_CLIENTE
	=
	($rowMysqlConsulta_Img['NOMBRE_CLIENTE']!='')? "'".substr($rowMysqlConsulta_Img['NOMBRE_CLIENTE'],0,80)."'" : " NULL";

// FECHA_ALTA
$var_SqlFireBird_FECHA_ALTA
	=
	($rowMysqlConsulta_Img['FECHA_ALTA']!='')? "'".substr($rowMysqlConsulta_Img['FECHA_ALTA'],0,16)."'" : " NULL";

// SUCURSAL
$var_SqlFireBird_SUCURSAL
	=
	($rowMysqlConsulta_Img['SUCURSAL']!='')? "'".substr($rowMysqlConsulta_Img['SUCURSAL'],0,1)."'" : " NULL";
	
// recId
$var_SqlFireBird_recId
	=
	($rowMysqlConsulta_Img['recId']!='')? "'".substr($rowMysqlConsulta_Img['recId'],0,10)."'" : " NULL";

// subRamo
$var_SqlFireBird_subRamo
	=
	($rowMysqlConsulta_Img['subRamo']!='')? "'".substr($rowMysqlConsulta_Img['subRamo'],0,50)."'" : " NULL";
	
//-->	if($rowMysqlConsulta_Img['existenRegistros'] != 0){
/*echo*/		$sqlFireBirdInsert_ImgLocal = "
			INSERT INTO 
				IMAGENES_SINC_WEB 
			(
				NO_ARCHIVO
				, EXTENSION
				, RUTA
				, DESCRIPCION
				, TIPO
				, POLIZA
				, VALOR
				, TIPO_IMG
				, ESTATUS
				, CLIENTEM
				, CLIENTED
				, NOMBRE_CLIENTE
				, FECHA_HORA_ALTA
				, SUCURSAL
				, REC_ID
				, SUBRAMO
				, TOCADO
				, FECHAPROCESO
			)
			VALUES 
			(
				".$var_SqlFireBird_NO_ARCHIVO."
				,".$var_SqlFireBird_EXTENSION."
				,".$var_SqlFireBird_RUTA."
				,".$var_SqlFireBird_DESCRIPCION."
				,".$var_SqlFireBird_TIPO."
				,".$var_SqlFireBird_POLIZA."
				,".$var_SqlFireBird_VALOR."
				,".$var_SqlFireBird_TIPO_IMG."
				,".$var_SqlFireBird_ESTATUS."
				,".$var_SqlFireBird_CLIENTE_MPRO."
				,".$var_SqlFireBird_CLIENTE_TMP."
				,".$var_SqlFireBird_NOMBRE_CLIENTE."
				,".$var_SqlFireBird_FECHA_ALTA."
				,".$var_SqlFireBird_SUCURSAL."
				,".$var_SqlFireBird_recId."
				,".$var_SqlFireBird_subRamo."
				,'XX'
				,'".date('Y-m-d g:i')."'
			);
									  ";

		$resFireBirdInsert_ImgLocal = DreQueryDbFireBird($sqlFireBirdInsert_ImgLocal);
		$rowFireBirdInsert_ImgLocal = ibase_fetch_object($resFireBirdInsert_ImgLocal);
		DreFreeResultDbFireBird($rowFireBirdInsert_ImgLocal);

//-->	}
	
}

echo "Actualizacion de Correcta !!!";
include('CerrarVentana.php');

echo "</pre>";

DreDesconectarDbFireBird($conexFireBird);
DreDesconectarDB($conexMySql);
?>