<?php
include('../../config/funcionesDre.php');

$file = "../../../syncronizacion/Merida/entrada/cobranzapendiente.txt"; //Definicion de archivo y ruta a cargar

if(filesize($file)==0){ unlink($file); }

if(file_exists($file) && filesize($file)!=0) 
{	//If Validacion Existe Archivo  y Tiene Informacion

$conexionDB = DreConectarDB(); // Efectuamos la Conexion a la DB

// Vaciamos la tabla --> para cargar la actualizacion
DreQueryDB("Truncate Table `cobranzapendiente`");

// Variables para el siclo While 
$filas = file($file); 
$i = 0; // contador de filas en el archivo
$totalFilas = count($filas);  // Total de filas de registros en el archivo

$quitar = array('(',')','"', '\'', ',', ';' );
$poner = array('','','','','', ' ');

while($i < $totalFilas){	// Siclo While Insert Into Tabla
//$arrayStrinQuitar = array( "\'", "\n", "\r", "\n\r", "\r\n", chr(10), chr(11), chr(12), chr(13), chr(10).chr(13), chr(13).chr(10),  "/");
//$arrayStrinPoner = array("'", "", "", "", "", "", "", "", "", "", "", "-");
	//$newFila = str_replace($arrayStrinQuitar, $arrayStrinPoner,$filas[$i++]);
	set_time_limit(0);

$newFila = $filas[$i++];
$ColumFila = explode(",", $newFila);

$poliza = ltrim(str_replace($quitar,$poner,$ColumFila[0]));
$endoso = ltrim(str_replace($quitar,$poner,$ColumFila[1]));
$Nombre_cliente = ltrim(str_replace($quitar,$poner,$ColumFila[2]));
$nombre_vendedor = ltrim(str_replace($quitar,$poner,$ColumFila[3]));
$aseguradora = ltrim(str_replace($quitar,$poner,$ColumFila[4]));
$condicion_pago = ltrim(str_replace($quitar,$poner,$ColumFila[5]));
$Numero_Recibo = ltrim(str_replace($quitar,$poner,$ColumFila[6]));
$inicio_vigencia = ltrim(str_replace($quitar,$poner,$ColumFila[7]));
$fin_vigencia = ltrim(str_replace($quitar,$poner,$ColumFila[8]));
$vencimiento = ltrim(str_replace($quitar,$poner,$ColumFila[9]));
$importe = ltrim(str_replace($quitar,$poner,$ColumFila[10]));
$subgrupo = ltrim(str_replace($quitar,$poner,$ColumFila[11]));
$subramo = ltrim(str_replace($quitar,$poner,$ColumFila[12]));
$conducto_cobro = ltrim(str_replace($quitar,$poner,$ColumFila[13]));
$color_linea = ltrim(str_replace($quitar,$poner,$ColumFila[14]));

/*
$sqlValidacionUsuarioVendedor = "Select * From `info_usuarios_vendedores` Where `VALOR` = '$VALOR'";
if(mysql_num_rows(DreQueryDB($sqlValidacionUsuarioVendedor)) > 0){ // validamos que no exista la empresa
	$sqlDeleteImagenes = "
		Delete From 
			`info_usuarios_vendedores`
		Where 
			`VALOR` = '$VALOR';
						 ";
	DreQueryDB($sqlDeleteImagenes);
}
*/

$sql = "
Insert Into `cobranzapendiente` 
	(
		`poliza`
		, `endoso`
		, `CLIENTE`
		, `VENDEDOR`
		, `aseguradora`
		, `condicion_pago`
		, `Numero_Recibo`
		, `inicio_vigencia`
		, `fin_vigencia`
		, `vencimiento`
		, `importe`
		, `subgrupo`
		, `subramo`
		, `conducto_cobro`
		, `color_linea`
	)
Values 
	(
		'$poliza'
		, '$endoso'
		, '$Nombre_cliente'
		, '$nombre_vendedor'
		, '$aseguradora'
		, '$condicion_pago'
		, '$Numero_Recibo'
		, '$inicio_vigencia'
		, '$fin_vigencia'
		, '$vencimiento'
		, '$importe'
		, '$subgrupo'
		, '$subramo'
		, '$conducto_cobro'
		, '$color_linea'
	)
	   ";

//$sql.= $newFila; // Fila con los datos para insertar

echo "<pre>";
	echo $sql;
echo "</pre>";
DreQueryDB($sql); // Ejecutamos el Query
	}	// Siclo While Insert Into Tabla


$sqlMantenimiento1 = "
	Update 
		`cobranzapendiente`
	set
		`VENDEDOR` = Lpad(`VENDEDOR`,10,'0');
					";
					
$sqlMantenimiento2 = "
	Update 
		`cobranzapendiente` 
	Set 
		`CLIENTE_NOMBRE` = (Select `RAZON_SOCIAL` From `empresas` Where `empresas`.`CLAVE` = `cobranzapendiente`.`CLIENTE`)
		,`VENDEDOR_NOMBRE` = (Select `NOMBRE` From `vendedores` Where `vendedores`.`CLAVE` = `cobranzapendiente` .`VENDEDOR`);
					";

DreQueryDB($sqlMantenimiento1);
DreQueryDB($sqlMantenimiento2);

DreDesconectarDB($conexionDB); // Cerramos la Conexion a la DB

// Mover  y renombrar archivo de texto ya Importado
$fileRename = 'cobranzapendiente_'.date("Y-m-d_g-i-s-a").".txt"; 
$filePath = '../../../syncronizacion/Merida/procesados/'; 

// Copiamos el arhivo de entrada a la carpeta de procesados y eliminamos el original de la carpeta de entradas
copy($file,$filePath.$fileRename); 
unlink($file);

echo "Actualizacion de Correcta !!!";
include('CerrarVentana.php');

}	//If Validacion Existe Archivo  y Tiene Informacion
else
{	//If Validacion Existe Archivo  y Tiene Informacion

echo "No existe el Archivo";
include('CerrarVentana.php');	

}	//If Validacion Existe Archivo  y Tiene Informacion

?>