<?php
include('../../config/funcionesDre.php');

$file = "../../../syncronizacion/Merida/entrada/cancelaciones.txt"; //Definicion de archivo y ruta a cargar

if(filesize($file)==0){ unlink($file); }

if(file_exists($file) && filesize($file)!=0) 
{	//If Validacion Existe Archivo  y Tiene Informacion

$conexionDB = DreConectarDB(); // Efectuamos la Conexion a la DB

// Vaciamos la tabla --> para cargar la actualizacion
DreQueryDB("Truncate Table `cancelaciones`");

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
$FECHA_CAPTURA = ltrim(str_replace($quitar,$poner,$ColumFila[1]));
$FECHA_EMISION = ltrim(str_replace($quitar,$poner,$ColumFila[2]));
$POLIZA = ltrim(str_replace($quitar,$poner,$ColumFila[3]));
$POLIZA_ANTERIOR = ltrim(str_replace($quitar,$poner,$ColumFila[4]));
$ENDOSO = ltrim(str_replace($quitar,$poner,$ColumFila[5]));
$RAMO = ltrim(str_replace($quitar,$poner,$ColumFila[6]));
$SUBRAMO = ltrim(str_replace($quitar,$poner,$ColumFila[7]));
$DESCRIPCION = ltrim(str_replace($quitar,$poner,$ColumFila[8]));
$MODELO = ltrim(str_replace($quitar,$poner,$ColumFila[9]));
$NoSERIE = ltrim(str_replace($quitar,$poner,$ColumFila[10]));
$VENDEDOR = ltrim(str_replace($quitar,$poner,$ColumFila[11]));
$CONSULTOR = ltrim(str_replace($quitar,$poner,$ColumFila[12]));
$ASEGURADORA = ltrim(str_replace($quitar,$poner,$ColumFila[13]));
$GRUPO = ltrim(str_replace($quitar,$poner,$ColumFila[14]));
$SUBGRUPO = ltrim(str_replace($quitar,$poner,$ColumFila[15]));
$CLIENTE = ltrim(str_replace($quitar,$poner,$ColumFila[16]));
$PERSONA_F_M = ltrim(str_replace($quitar,$poner,$ColumFila[17]));
$COND_PAGO = ltrim(str_replace($quitar,$poner,$ColumFila[18]));
$CONDUCTO_COBRO = ltrim(str_replace($quitar,$poner,$ColumFila[19]));
$INICIO = ltrim(str_replace($quitar,$poner,$ColumFila[20]));
$FIN = ltrim(str_replace($quitar,$poner,$ColumFila[21]));
$MONEDA = ltrim(str_replace($quitar,$poner,$ColumFila[22]));
$TC = ltrim(str_replace($quitar,$poner,$ColumFila[23]));
$CAMBIO_CONDUCTO = ltrim(str_replace($quitar,$poner,$ColumFila[24]));
$PRIMA_NETA = ltrim(str_replace($quitar,$poner,$ColumFila[25]));
$RECARGO = ltrim(str_replace($quitar,$poner,$ColumFila[26]));
$GASTOS = ltrim(str_replace($quitar,$poner,$ColumFila[27]));
$IVA = ltrim(str_replace($quitar,$poner,$ColumFila[28]));
$PRIMA_TOTAL = ltrim(str_replace($quitar,$poner,$ColumFila[29]));
$PORCENTAJE = ltrim(str_replace($quitar,$poner,$ColumFila[30]));
$PRIMA_NETA_COMISION = ltrim(str_replace($quitar,$poner,$ColumFila[31]));
$RECARGO_COMISION = ltrim(str_replace($quitar,$poner,$ColumFila[32]));
$GASTOS_COMISION = ltrim(str_replace($quitar,$poner,$ColumFila[33]));
$TOTAL_COMISION = ltrim(str_replace($quitar,$poner,$ColumFila[34]));
$PCTJE_DISPERSION_VEND = ltrim(str_replace($quitar,$poner,$ColumFila[35]));
$IMPORTE_VEND = ltrim(str_replace($quitar,$poner,$ColumFila[36]));
$PCTJE_DISPERSION_CONS = ltrim(str_replace($quitar,$poner,$ColumFila[37]));
$IMPORTE_CONS = ltrim(str_replace($quitar,$poner,$ColumFila[38]));
$PCJTE_DISPERSION_COM = ltrim(str_replace($quitar,$poner,$ColumFila[39]));
$IMPORTE_COM = ltrim(str_replace($quitar,$poner,$ColumFila[40]));

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
Insert Into `cancelaciones` 
	(
		`SUCURSAL`
		, `FECHA_CAPTURA`
		, `FECHA_EMISION`
		, `POLIZA`
		, `POLIZA_ANTERIOR`
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
		, `MONEDA`
		, `TC`
		, `CAMBIO_CONDUCTO`
		, `PRIMA_NETA`
		, `RECARGO`
		, `GASTOS`
		, `IVA`
		, `PRIMA_TOTAL`
		, `PORCENTAJE`
		, `PRIMA_NETA_COMISION`
		, `RECARGO_COMISION`
		, `GASTOS_COMISION`
		, `TOTAL_COMISION`
		, `PCTJE_DISPERSION_VEND`
		, `IMPORTE_VEND`
		, `PCTJE_DISPERSION_CONS`
		, `IMPORTE_CONS`
		, `PCJTE_DISPERSION_COM`
		, `IMPORTE_COM`	
	)
Values 
	(
		'$SUCURSAL'
		, '$FECHA_CAPTURA'
		, '$FECHA_EMISION'
		, '$POLIZA'
		, '$POLIZA_ANTERIOR'
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
		, '$MONEDA'
		, '$TC'
		, '$CAMBIO_CONDUCTO'
		, '$PRIMA_NETA'
		, '$RECARGO'
		, '$GASTOS'
		, '$IVA'
		, '$PRIMA_TOTAL'
		, '$PORCENTAJE'
		, '$PRIMA_NETA_COMISION'
		, '$RECARGO_COMISION'
		, '$GASTOS_COMISION'
		, '$TOTAL_COMISION'
		, '$PCTJE_DISPERSION_VEND'
		, '$IMPORTE_VEND'
		, '$PCTJE_DISPERSION_CONS'
		, '$IMPORTE_CONS'
		, '$PCJTE_DISPERSION_COM'
		, '$IMPORTE_COM'	
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
		`cancelaciones`
	set
		`VENDEDOR` = Lpad(`VENDEDOR`,10,'0')
        ,`CONSULTOR` = Lpad(`CONSULTOR`,10,'0');
					";
					
$sqlMantenimiento2 = "
	Update 
		`cancelaciones` 
	Set 
		`CLIENTE_NOMBRE` = (Select `RAZON_SOCIAL` From `empresas` Where `empresas`.`CLAVE` = `cancelaciones`.`CLIENTE`)
		,`VENDEDOR_NOMBRE` = (Select `NOMBRE` From `vendedores` Where `vendedores`.`CLAVE` = `cancelaciones` .`VENDEDOR`)
		,`CONSULTOR_NOMBRE` = (Select `NOMBRE` From `usuarios` Where `usuarios`.`VALOR` = `cancelaciones` .`CONSULTOR`);
					";

DreQueryDB($sqlMantenimiento1);
DreQueryDB($sqlMantenimiento2);


DreDesconectarDB($conexionDB); // Cerramos la Conexion a la DB

// Mover  y renombrar archivo de texto ya Importado
$fileRename = 'cancelaciones_'.date("Y-m-d_g-i-s-a").".txt"; 
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