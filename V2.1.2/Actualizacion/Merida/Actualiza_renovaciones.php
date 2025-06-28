<?php
include('../../config/funcionesDre.php');

$file = "../../../syncronizacion/Merida/entrada/renovaciones.txt"; //Definicion de archivo y ruta a cargar

if(filesize($file)==0){ unlink($file); }

if(file_exists($file) && filesize($file)!=0) 
{	//If Validacion Existe Archivo  y Tiene Informacion

$conexionDB = DreConectarDB(); // Efectuamos la Conexion a la DB

// Vaciamos la tabla --> para cargar la actualizacion
DreQueryDB("Truncate Table `renovaciones`");

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

$SUCURSAL = ltrim(str_replace($quitar,$poner,$ColumFila[0]));
$EMISION = ltrim(str_replace($quitar,$poner,$ColumFila[1]));
$POLIZA = ltrim(str_replace($quitar,$poner,$ColumFila[2]));
$ENDOSO = ltrim(str_replace($quitar,$poner,$ColumFila[3]));
$RAMO = ltrim(str_replace($quitar,$poner,$ColumFila[4]));
$SUBRAMO = ltrim(str_replace($quitar,$poner,$ColumFila[5]));
$DESCRIPCION = ltrim(str_replace($quitar,$poner,$ColumFila[6]));
$MODELO = ltrim(str_replace($quitar,$poner,$ColumFila[7]));
$NoSERIE = ltrim(str_replace($quitar,$poner,$ColumFila[8]));
$VENDEDOR = ltrim(str_replace($quitar,$poner,$ColumFila[9]));
$CONSULTOR = ltrim(str_replace($quitar,$poner,$ColumFila[10]));
$ASEGURADORA = ltrim(str_replace($quitar,$poner,$ColumFila[11]));
$GRUPO = ltrim(str_replace($quitar,$poner,$ColumFila[12]));
$SUBGRUPO = ltrim(str_replace($quitar,$poner,$ColumFila[13]));
$CLIENTE = ltrim(str_replace($quitar,$poner,$ColumFila[14]));
$PERSONA_F_M = ltrim(str_replace($quitar,$poner,$ColumFila[15]));
$COND_PAGO = ltrim(str_replace($quitar,$poner,$ColumFila[16]));
$CONDUCTO_COBRO = ltrim(str_replace($quitar,$poner,$ColumFila[17]));
$INICIO = ltrim(str_replace($quitar,$poner,$ColumFila[18]));
$FIN = ltrim(str_replace($quitar,$poner,$ColumFila[19]));
$PRIMA_NETA = ltrim(str_replace($quitar,$poner,$ColumFila[20]));
$RECARGO = ltrim(str_replace($quitar,$poner,$ColumFila[21]));
$GASTOS = ltrim(str_replace($quitar,$poner,$ColumFila[22]));
$IVA = ltrim(str_replace($quitar,$poner,$ColumFila[23]));
$PRIMA_TOTAL = ltrim(str_replace($quitar,$poner,$ColumFila[24]));
$PRIMA_NETA_COMISION = ltrim(str_replace($quitar,$poner,$ColumFila[25]));
$RECARGO_COMISION = ltrim(str_replace($quitar,$poner,$ColumFila[26]));
$GASTOS_COMISION = ltrim(str_replace($quitar,$poner,$ColumFila[27]));
$TOTAL_COMISION = ltrim(str_replace($quitar,$poner,$ColumFila[28]));
$COMENTARIOS = ltrim(str_replace($quitar,$poner,$ColumFila[29]));

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
Insert Into `renovaciones` 
	(
		`SUCURSAL`
		, `EMISION`
		, `POLIZA`
		, `ENDOSO`
		, `RAMO`
		, `SUBRAMO`
		, `DESCRIPCION`
		, `MODELO`
		, `NoSERIE`
		, `VENDEDOR`
		, `CONSULTOR`
		, `ASEGURADORA`
		, `GRUPO`
		, `SUBGRUPO`
		, `CLIENTE`
		, `PERSONA_F_M`
		, `COND_PAGO`
		, `CONDUCTO_COBRO`
		, `INICIO`
		, `FIN`
		, `PRIMA_NETA`
		, `RECARGO`
		, `GASTOS`
		, `IVA`
		, `PRIMA_TOTAL`
		, `PRIMA_NETA_COMISION`
		, `RECARGO_COMISION`
		, `GASTOS_COMISION`
		, `TOTAL_COMISION`
		, `COMENTARIOS`
	)
Values 
	(
		'$SUCURSAL'
		, '$EMISION'
		, '$POLIZA'
		, '$ENDOSO'
		, '$RAMO'
		, '$SUBRAMO'
		, '$DESCRIPCION'
		, '$MODELO'
		, '$NoSERIE'
		, '$VENDEDOR'
		, '$CONSULTOR'
		, '$ASEGURADORA'
		, '$GRUPO'
		, '$SUBGRUPO'
		, '$CLIENTE'
		, '$PERSONA_F_M'
		, '$COND_PAGO'
		, '$CONDUCTO_COBRO'
		, '$INICIO'
		, '$FIN'
		, '$PRIMA_NETA'
		, '$RECARGO'
		, '$GASTOS'
		, '$IVA'
		, '$PRIMA_TOTAL'
		, '$PRIMA_NETA_COMISION'
		, '$RECARGO_COMISION'
		, '$GASTOS_COMISION'
		, '$TOTAL_COMISION'
		, '$COMENTARIOS'
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
		`renovaciones`
	set
		`VENDEDOR` = Lpad(`VENDEDOR`,10,'0')
        ,`CONSULTOR` = Lpad(`CONSULTOR`,10,'0');
					";
					
$sqlMantenimiento2 = "
	Update 
		`renovaciones` 
	Set 
		`CLIENTE_NOMBRE` = (Select `RAZON_SOCIAL` From `empresas` Where `empresas`.`CLAVE` = `renovaciones`.`CLIENTE`)
		,`VENDEDOR_NOMBRE` = (Select `NOMBRE` From `vendedores` Where `vendedores`.`CLAVE` = `renovaciones` .`VENDEDOR`)
		,`CONSULTOR_NOMBRE` = (Select `NOMBRE` From `usuarios` Where `usuarios`.`VALOR` = `renovaciones` .`CONSULTOR`);
					";

DreQueryDB($sqlMantenimiento1);
DreQueryDB($sqlMantenimiento2);

DreDesconectarDB($conexionDB); // Cerramos la Conexion a la DB

// Mover  y renombrar archivo de texto ya Importado
$fileRename = 'renovaciones_'.date("Y-m-d_g-i-s-a").".txt"; 
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