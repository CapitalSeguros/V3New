<?php
include('../../config/funcionesDre.php');

$file = "../../../syncronizacion/Merida/entrada/comisionesli.txt"; //Definicion de archivo y ruta a cargar

if(filesize($file)==0){ unlink($file); }

if(file_exists($file) && filesize($file)!=0) 
{	//If Validacion Existe Archivo  y Tiene Informacion

$conexionDB = DreConectarDB(); // Efectuamos la Conexion a la DB

// Vaciamos la tabla --> para cargar la actualizacion
DreQueryDB("Truncate Table `comisionesli`");

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
$POLIZA = ltrim(str_replace($quitar,$poner,$ColumFila[1]));
$ENDOSO = ltrim(str_replace($quitar,$poner,$ColumFila[2]));
$CLIENTE = ltrim(str_replace($quitar,$poner,$ColumFila[3]));
$RAMO = ltrim(str_replace($quitar,$poner,$ColumFila[4]));
$SUBRAMO = ltrim(str_replace($quitar,$poner,$ColumFila[5]));
$VENDEDOR = ltrim(str_replace($quitar,$poner,$ColumFila[6]));
$CONSULTOR = ltrim(str_replace($quitar,$poner,$ColumFila[7]));
$ASEGURADORA = ltrim(str_replace($quitar,$poner,$ColumFila[8]));
$GRUPO = ltrim(str_replace($quitar,$poner,$ColumFila[9]));
$SUBGRUPO = ltrim(str_replace($quitar,$poner,$ColumFila[10]));
$COND_PAGO = ltrim(str_replace($quitar,$poner,$ColumFila[11]));
$CONDUCTO_COBRO = ltrim(str_replace($quitar,$poner,$ColumFila[12]));
$COMENTARIO = ltrim(str_replace($quitar,$poner,$ColumFila[13]));
$RECIBO = ltrim(str_replace($quitar,$poner,$ColumFila[14]));
$INICIO = ltrim(str_replace($quitar,$poner,$ColumFila[15]));
$FIN = ltrim(str_replace($quitar,$poner,$ColumFila[16]));
$FORMA_PAGO = ltrim(str_replace($quitar,$poner,$ColumFila[17]));
$FECHA_PAGO = ltrim(str_replace($quitar,$poner,$ColumFila[18]));
$FECHA_APLIC = ltrim(str_replace($quitar,$poner,$ColumFila[19]));
$IMPORTE_PAGO = ltrim(str_replace($quitar,$poner,$ColumFila[20]));
$MONEDA = ltrim(str_replace($quitar,$poner,$ColumFila[21]));
$TC = ltrim(str_replace($quitar,$poner,$ColumFila[22]));
$PRIMA_NETA = ltrim(str_replace($quitar,$poner,$ColumFila[23]));
$RECARGO = ltrim(str_replace($quitar,$poner,$ColumFila[24]));
$GASTOS = ltrim(str_replace($quitar,$poner,$ColumFila[25]));
$IVA = ltrim(str_replace($quitar,$poner,$ColumFila[26]));
$PRIMA_TOTAL = ltrim(str_replace($quitar,$poner,$ColumFila[27]));
$PRIMA_NETA_COMISION = ltrim(str_replace($quitar,$poner,$ColumFila[28]));
$RECARGO_COMISION = ltrim(str_replace($quitar,$poner,$ColumFila[29]));
$GASTOS_COMISION = ltrim(str_replace($quitar,$poner,$ColumFila[30]));
$TOTAL_COMISION = ltrim(str_replace($quitar,$poner,$ColumFila[31]));
$PCTJE_DISPERSION_VEND = ltrim(str_replace($quitar,$poner,$ColumFila[32]));
$IMPORTE_VEND = ltrim(str_replace($quitar,$poner,$ColumFila[33]));
$LIQUIDADO_VEND = ltrim(str_replace($quitar,$poner,$ColumFila[34]));
$FECHA_LIQ_VEND = ltrim(str_replace($quitar,$poner,$ColumFila[35]));
$PENDIENTE_VEND = ltrim(str_replace($quitar,$poner,$ColumFila[36]));
$PCTJE_DISPERSION_CONS = ltrim(str_replace($quitar,$poner,$ColumFila[37]));
$IMPORTE_CONS = ltrim(str_replace($quitar,$poner,$ColumFila[38]));
$LIQUIDADO_CONS = ltrim(str_replace($quitar,$poner,$ColumFila[39]));
$FECHA_CONS = ltrim(str_replace($quitar,$poner,$ColumFila[40]));
$PENDIENTE_CONS = ltrim(str_replace($quitar,$poner,$ColumFila[41]));
$PCJTE_DISPERSION_COM = ltrim(str_replace($quitar,$poner,$ColumFila[42]));
$IMPORTE_COM = ltrim(str_replace($quitar,$poner,$ColumFila[43]));
$LIQUIDADO_COM = ltrim(str_replace($quitar,$poner,$ColumFila[44]));
$FECHA_COM = ltrim(str_replace($quitar,$poner,$ColumFila[45]));
$PENDIENTE_COM = ltrim(str_replace($quitar,$poner,$ColumFila[46]));

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
Insert Into `comisionesli` 
	(
		`SUCURSAL`
		, `POLIZA`
		, `ENDOSO`
		, `CLIENTE`
		, `RAMO`
		, `SUBRAMO`
		, `VENDEDOR`
		, `CONSULTOR`
		, `ASEGURADORA`
		, `GRUPO`
		, `SUBGRUPO`
		, `COND_PAGO`
		, `CONDUCTO_COBRO`
		, `COMENTARIO`
		, `RECIBO`
		, `INICIO`
		, `FIN`
		, `FORMA_PAGO`
		, `FECHA_PAGO`
		, `FECHA_APLIC`
		, `IMPORTE_PAGO`
		, `MONEDA`
		, `TC`
		, `PRIMA_NETA`
		, `RECARGO`
		, `GASTOS`
		, `IVA`
		, `PRIMA_TOTAL`
		, `PRIMA_NETA_COMISION`
		, `RECARGO_COMISION`
		, `GASTOS_COMISION`
		, `TOTAL_COMISION`
		, `PCTJE_DISPERSION_VEND`
		, `IMPORTE_VEND`
		, `LIQUIDADO_VEND`
		, `FECHA_LIQ_VEND`
		, `PENDIENTE_VEND`
		, `PCTJE_DISPERSION_CONS`
		, `IMPORTE_CONS`
		, `LIQUIDADO_CONS`
		, `FECHA_CONS`
		, `PENDIENTE_CONS`
		, `PCJTE_DISPERSION_COM`
		, `IMPORTE_COM`
		, `LIQUIDADO_COM`
		, `FECHA_COM`
		, `PENDIENTE_COM`
	)
Values 
	(
		'$SUCURSAL'
		, '$POLIZA'
		, '$ENDOSO'
		, '$CLIENTE'
		, '$RAMO'
		, '$SUBRAMO'
		, '$VENDEDOR'
		, '$CONSULTOR'
		, '$ASEGURADORA'
		, '$GRUPO'
		, '$SUBGRUPO'
		, '$COND_PAGO'
		, '$CONDUCTO COBRO'
		, '$COMENTARIO'
		, '$RECIBO'
		, '$INICIO'
		, '$FIN'
		, '$FORMA_PAGO'
		, '$FECHA_PAGO'
		, '$FECHA_APLIC'
		, '$IMPORTE_PAGO'
		, '$MONEDA'
		, '$TC'
		, '$PRIMA_NETA'
		, '$RECARGO'
		, '$GASTOS'
		, '$IVA'
		, '$PRIMA_TOTAL'
		, '$PRIMA_NETA_COMISION'
		, '$RECARGO_COMISION'
		, '$GASTOS_COMISION'
		, '$TOTAL_COMISION'
		, '$PCTJE_DISPERSION_VEND'
		, '$IMPORTE_VEND'
		, '$LIQUIDADO_VEND'
		, '$FECHA_LIQ_VEND'
		, '$PENDIENTE_VEND'
		, '$PCTJE_DISPERSION_CONS'
		, '$IMPORTE_CONS'
		, '$LIQUIDADO_CONS'
		, '$FECHA_CONS'
		, '$PENDIENTE_CONS'
		, '$PCJTE_DISPERSION_COM'
		, '$IMPORTE_COM'
		, '$LIQUIDADO_COM'
		, '$FECHA_COM'
		, '$PENDIENTE_COM'	
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
		`comisionesli`
	set
		`VENDEDOR` = Lpad(`VENDEDOR`,10,'0')
        ,`CONSULTOR` = Lpad(`CONSULTOR`,10,'0');
					";
					
$sqlMantenimiento2 = "
	Update 
		`comisionesli` 
	Set 
		`CLIENTE_NOMBRE` = (Select `RAZON_SOCIAL` From `empresas` Where `empresas`.`CLAVE` = `comisionesli`.`CLIENTE`)
		,`VENDEDOR_NOMBRE` = (Select `NOMBRE` From `vendedores` Where `vendedores`.`CLAVE` = `comisionesli` .`VENDEDOR`)
		,`CONSULTOR_NOMBRE` = (Select `NOMBRE` From `usuarios` Where `usuarios`.`VALOR` = `comisionesli` .`CONSULTOR`);
					";
					
DreQueryDB($sqlMantenimiento1);
DreQueryDB($sqlMantenimiento2);


DreDesconectarDB($conexionDB); // Cerramos la Conexion a la DB

// Mover  y renombrar archivo de texto ya Importado
$fileRename = 'comisionespl_'.date("Y-m-d_g-i-s-a").".txt"; 
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