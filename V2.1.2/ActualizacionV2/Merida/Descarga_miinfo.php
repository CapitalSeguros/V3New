<?php
include('../Config/funcionesDreFireBird.php');
include('../../config/funcionesDre.php');

$conexFireBird = DreConectarDbFireBird();
$conexMySql = DreConectarDB();

$quitarCosas = array('&nbsp;'); 
$ponerCosas = array('');

	$sqlMysql_Validacion_Registros_MIINFO = "
		Select Count(*) As `existenRegistros` From
			`info_usuarios_vendedores`
		Where 
			`actualizado` = '1'
									 ";
	$resMysql_Validacion_Registros_MIINFO = DreQueryDB($sqlMysql_Validacion_Registros_MIINFO);
	$rowMysql_Validacion_Registros_MIINFO = mysql_fetch_assoc($resMysql_Validacion_Registros_MIINFO);
	
	if((int)$rowMysql_Validacion_Registros_MIINFO['existenRegistros'] > 0){
		echo "SI hay Registros a Procesar<br>";
		
		//--> Mantenimiento Tabla FireBird
		// si el registro tiene NO conservar de lo contrario borrar 
		$sqlFireBird_Mantenimiento_1_Tabla_MIINFO = "
			Delete From
				MIINFO_DESCARGA
			Where
				TOCADO != 'NO'
													   ";
//-->		$resFireBird_Mantenimiento_1_Tabla_MIINFO = DreQueryDbFireBird($sqlFireBird_Mantenimiento_1_Tabla_MIINFO);
//-->		DreFreeResultDbFireBird($resFireBird_Mantenimiento_1_Tabla_MIINFO);
		
		
		$sqlMysql_Registros_MIINFO = "
			Select * From
				`info_usuarios_vendedores`
			Where 
				`actualizado` = '1'
							  ";
		$resMysql_Registros_MIINFO = DreQueryDB($sqlMysql_Registros_MIINFO);
		while($rowMysql_Registros_MIINFO = mysql_fetch_assoc($resMysql_Registros_MIINFO)){

			
// VALOR
$var_SqlFireBird_VALOR
	= 
	($rowMysql_Registros_MIINFO['VALOR']!='')? "'".substr($rowMysql_Registros_MIINFO['VALOR'],0,15)."'" : " NULL";

// NOMBRE
$var_SqlFireBird_NOMBRE
	= 
	($rowMysql_Registros_MIINFO['NOMBRE']!='')? "'".substr($rowMysql_Registros_MIINFO['NOMBRE'],0,50)."'" : " NULL";

// APELLIDOS
$var_SqlFireBird_APELLIDOS
	= 
	($rowMysql_Registros_MIINFO['APELLIDOS']!='')? "'".substr($rowMysql_Registros_MIINFO['APELLIDOS'],0,50)."'" : " NULL";
	
// SUCURSAL
$var_SqlFireBird_SUCURSAL
	= 
	($rowMysql_Registros_MIINFO['SUCURSAL']!='')? "".substr((int)$rowMysql_Registros_MIINFO['SUCURSAL'],0,1)."" : " NULL";
	
// CALLE
$var_SqlFireBird_CALLE
	= 
	($rowMysql_Registros_MIINFO['CALLE']!='')? "'".substr($rowMysql_Registros_MIINFO['CALLE'],0,50)."'" : " NULL";

// NO_EXT
$var_SqlFireBird_NO_EXT
	= 
	($rowMysql_Registros_MIINFO['NO_EXT']!='')? "'".substr($rowMysql_Registros_MIINFO['NO_EXT'],0,10)."'" : " NULL";

// CRUZAMIENTO
$var_SqlFireBird_CRUZAMIENTO
	= 
	($rowMysql_Registros_MIINFO['CRUZAMIENTO']!='')? "'".substr($rowMysql_Registros_MIINFO['CRUZAMIENTO'],0,30)."'" : " NULL";

// COLONIA
$var_SqlFireBird_COLONIA
	= 
	($rowMysql_Registros_MIINFO['COLONIA']!='')? "'".substr($rowMysql_Registros_MIINFO['COLONIA'],0,50)."'" : " NULL";

// CP
$var_SqlFireBird_CP
	= 
	($rowMysql_Registros_MIINFO['CP']!='')? "'".substr($rowMysql_Registros_MIINFO['CP'],0,10)."'" : " NULL";

// CIUDAD_ID
$var_SqlFireBird_CIUDAD_ID
	= 
	($rowMysql_Registros_MIINFO['CIUDAD_ID']!='')? "".substr((int)$rowMysql_Registros_MIINFO['CIUDAD_ID'],0,11)."" : " NULL";

// RFC
$var_SqlFireBird_RFC
	= 
	($rowMysql_Registros_MIINFO['RFC']!='')? "'".substr($rowMysql_Registros_MIINFO['RFC'],0,13)."'" : " NULL";

// TELEFONO_CASA
$var_SqlFireBird_TELEFONO_CASA
	= 
	($rowMysql_Registros_MIINFO['TELEFONO_CASA']!='')? "'".substr($rowMysql_Registros_MIINFO['TELEFONO_CASA'],0,30)."'" : " NULL";

// TELEFONO_CELULAR
$var_SqlFireBird_TELEFONO_CELULAR
	= 
	($rowMysql_Registros_MIINFO['TELEFONO_CELULAR']!='')? "'".substr($rowMysql_Registros_MIINFO['TELEFONO_CELULAR'],0,30)."'" : " NULL";

// CIA_CEL
$var_SqlFireBird_CIA_CEL
	= 
	($rowMysql_Registros_MIINFO['']!='CIA_CEL')? "'".substr($rowMysql_Registros_MIINFO['CIA_CEL'],0,30)."'" : " NULL";

// TELEFONO_TRABAJO
$var_SqlFireBird_TELEFONO_TRABAJO
	= 
	($rowMysql_Registros_MIINFO['TELEFONO_TRABAJO']!='')? "'".substr($rowMysql_Registros_MIINFO['TELEFONO_TRABAJO'],0,30)."'" : " NULL";

// ESTADO_CIVIL
$var_SqlFireBird_ESTADO_CIVIL
	= 
	($rowMysql_Registros_MIINFO['ESTADO_CIVIL']!='')? "'".substr($rowMysql_Registros_MIINFO['ESTADO_CIVIL'],0,20)."'" : " NULL";

// FECHA_NACIMIENTO
$var_SqlFireBird_FECHA_NACIMIENTO
	= 
	($rowMysql_Registros_MIINFO['FECHA_NACIMIENTO']!='')? "'".substr($rowMysql_Registros_MIINFO['FECHA_NACIMIENTO'],0,10)."'" : " NULL";

// LUGAR_NACIMIENTO
$var_SqlFireBird_LUGAR_NACIMIENTO
	= 
	($rowMysql_Registros_MIINFO['LUGAR_NACIMIENTO']!='')? "'".substr($rowMysql_Registros_MIINFO['LUGAR_NACIMIENTO'],0,30)."'" : " NULL";

// ESCOLARIDAD
$var_SqlFireBird_ESCOLARIDAD
	= 
	($rowMysql_Registros_MIINFO['ESCOLARIDAD']!='')? "'".substr($rowMysql_Registros_MIINFO['ESCOLARIDAD'],0,20)."'" : " NULL";

// EMAIL
$var_SqlFireBird_EMAIL
	= 
	($rowMysql_Registros_MIINFO['EMAIL']!='')? "'".substr($rowMysql_Registros_MIINFO['EMAIL'],0,50)."'" : " NULL";

// VEHICULO_PROPIO
$var_SqlFireBird_VEHICULO_PROPIO
	= 
	($rowMysql_Registros_MIINFO['VEHICULO_PROPIO']!='')? "'".substr($rowMysql_Registros_MIINFO['VEHICULO_PROPIO'],0,1)."'" : " NULL";

// CUENTA_BANCARIA
$var_SqlFireBird_CUENTA_BANCARIA
	= 
	($rowMysql_Registros_MIINFO['CUENTA_BANCARIA']!='')? "'".substr($rowMysql_Registros_MIINFO['CUENTA_BANCARIA'],0,15)."'" : " NULL";

// BANCO
$var_SqlFireBird_BANCO
	= 
	($rowMysql_Registros_MIINFO['BANCO']!='')? "'".substr($rowMysql_Registros_MIINFO['BANCO'],0,20)."'" : " NULL";

// TIPO_CUENTA
$var_SqlFireBird_TIPO_CUENTA
	= 
	($rowMysql_Registros_MIINFO['TIPO_CUENTA']!='')? "'".substr($rowMysql_Registros_MIINFO['TIPO_CUENTA'],0,10)."'" : " NULL";

// CLABE
$var_SqlFireBird_CLABE
	= 
	($rowMysql_Registros_MIINFO['CLABE']!='')? "'".substr($rowMysql_Registros_MIINFO['CLABE'],0,18)."'" : " NULL";

// CEDULA_CNSF
$var_SqlFireBird_CEDULA_CNSF
	= 
	($rowMysql_Registros_MIINFO['CEDULA_CNSF']!='')? "'".substr($rowMysql_Registros_MIINFO['CEDULA_CNSF'],0,50)."'" : " NULL";

// VIGENCIA
$var_SqlFireBird_VIGENCIA
	= 
	($rowMysql_Registros_MIINFO['VIGENCIA']!='')? "'".substr($rowMysql_Registros_MIINFO['VIGENCIA'],0,10)."'" : " NULL";

// ACCIDENTE_AVISAR
$var_SqlFireBird_ACCIDENTE_AVISAR
	= 
	($rowMysql_Registros_MIINFO['ACCIDENTE_AVISAR']!='')? "'".substr($rowMysql_Registros_MIINFO['ACCIDENTE_AVISAR'],0,50)."'" : " NULL";

// TELEFONO_ACCIDENTE
$var_SqlFireBird_TELEFONO_ACCIDENTE
	= 
	($rowMysql_Registros_MIINFO['TELEFONO_ACCIDENTE']!='')? "'".substr($rowMysql_Registros_MIINFO['TELEFONO_ACCIDENTE'],0,20)."'" : " NULL";

// RECOMENDADO_POR
$var_SqlFireBird_RECOMENDADO_POR
	= 
	($rowMysql_Registros_MIINFO['RECOMENDADO_POR']!='')? "'".substr($rowMysql_Registros_MIINFO['RECOMENDADO_POR'],0,50)."'" : " NULL";

// IMAGEN
$var_SqlFireBird_IMAGEN
	= 
	($rowMysql_Registros_MIINFO['IMAGEN']!='')? "'".substr($rowMysql_Registros_MIINFO['IMAGEN'],0,50)."'" : " NULL";

// IMSS
$var_SqlFireBird_IMSS
	= 
	($rowMysql_Registros_MIINFO['IMSS']!='')? "'".substr($rowMysql_Registros_MIINFO['IMSS'],0,20)."'" : " NULL";

// REFERENCIAS
$var_SqlFireBird_REFERENCIAS
	= 
	($rowMysql_Registros_MIINFO['REFERENCIAS']!='')? "'".substr($rowMysql_Registros_MIINFO['REFERENCIAS'],0,100)."'" : " NULL";

// TIENE_HIJOS
$var_SqlFireBird_TIENE_HIJOS
	= 
	($rowMysql_Registros_MIINFO['TIENE_HIJOS']!='')? "'".substr($rowMysql_Registros_MIINFO['TIENE_HIJOS'],0,1)."'" : " NULL";

// GASTO_PROMEDIO_MENSUAL
$var_SqlFireBird_GASTO_PROMEDIO_MENSUAL
	= 
	($rowMysql_Registros_MIINFO['GASTO_PROMEDIO_MENSUAL']!='')? "".substr((float)$rowMysql_Registros_MIINFO['GASTO_PROMEDIO_MENSUAL'],0,18)."" : " NULL";

// CUANTO_TE_GUSTARIA_GANAR
$var_SqlFireBird_CUANTO_TE_GUSTARIA_GANAR
	= 
	($rowMysql_Registros_MIINFO['CUANTO_TE_GUSTARIA_GANAR']!='')? "".substr((float)$rowMysql_Registros_MIINFO['CUANTO_TE_GUSTARIA_GANAR'],0,18)."" : " NULL";

// CONSULTOR
$var_SqlFireBird_CONSULTOR
	= 
	($rowMysql_Registros_MIINFO['CONSULTOR']!='')? "".substr((int)$rowMysql_Registros_MIINFO['CONSULTOR'],0,11)."" : " NULL";

// MODELO_VEHICULO
$var_SqlFireBird_MODELO_VEHICULO
	= 
	($rowMysql_Registros_MIINFO['MODELO_VEHICULO']!='')? "'".substr($rowMysql_Registros_MIINFO['MODELO_VEHICULO'],0,30)."'" : " NULL";

// TIPO_AUT
$var_SqlFireBird_TIPO_AUT
	= 
	($rowMysql_Registros_MIINFO['TIPO_AUT']!='')? "'".substr($rowMysql_Registros_MIINFO['TIPO_AUT'],0,10)."'" : " NULL";

// COLOR_FAVORITO
$var_SqlFireBird_COLOR_FAVORITO
	= 
	($rowMysql_Registros_MIINFO['COLOR_FAVORITO']!='')? "'".substr($rowMysql_Registros_MIINFO['COLOR_FAVORITO'],0,50)."'" : " NULL";

// COMIDA_FAVORITA
$var_SqlFireBird_COMIDA_FAVORITA
	= 
	($rowMysql_Registros_MIINFO['COMIDA_FAVORITA']!='')? "'".substr($rowMysql_Registros_MIINFO['COMIDA_FAVORITA'],0,50)."'" : " NULL";

// ANIVERSARIO_BODAS
$var_SqlFireBird_ANIVERSARIO_BODAS
	= 
	($rowMysql_Registros_MIINFO['ANIVERSARIO_BODAS']!='')? "'".substr($rowMysql_Registros_MIINFO['ANIVERSARIO_BODAS'],0,10)."'" : " NULL";

// PASATIEMPO_FAVORITO
$var_SqlFireBird_PASATIEMPO_FAVORITO
	= 
	($rowMysql_Registros_MIINFO['PASATIEMPO_FAVORITO']!='')? "'".substr($rowMysql_Registros_MIINFO['PASATIEMPO_FAVORITO'],0,50)."'" : " NULL";

// CLUB_SOCIAL
$var_SqlFireBird_CLUB_SOCIAL
	= 
	($rowMysql_Registros_MIINFO['CLUB_SOCIAL']!='')? "'".substr($rowMysql_Registros_MIINFO['CLUB_SOCIAL'],0,50)."'" : " NULL";

// LICENCIA_MANEJAR
$var_SqlFireBird_LICENCIA_MANEJAR
	= 
	($rowMysql_Registros_MIINFO['LICENCIA_MANEJAR']!='')? "'".substr($rowMysql_Registros_MIINFO['LICENCIA_MANEJAR'],0,1)."'" : " NULL";

// VIGENCIA_LICENCIA_MANEJAR
$var_SqlFireBird_VIGENCIA_LICENCIA_MANEJAR
	= 
	($rowMysql_Registros_MIINFO['VIGENCIA_LICENCIA_MANEJAR']!='')? "'".substr($rowMysql_Registros_MIINFO['VIGENCIA_LICENCIA_MANEJAR'],0,10)."'" : " NULL";

// PASAPORTE
$var_SqlFireBird_PASAPORTE
	= 
	($rowMysql_Registros_MIINFO['PASAPORTE']!='')? "'".substr($rowMysql_Registros_MIINFO['PASAPORTE'],0,1)."'" : " NULL";

// VIGENCIA_PASAPORTE
$var_SqlFireBird_VIGENCIA_PASAPORTE
	= 
	($rowMysql_Registros_MIINFO['VIGENCIA_PASAPORTE']!='')? "'".substr($rowMysql_Registros_MIINFO['VIGENCIA_PASAPORTE'],0,10)."'" : " NULL";

// RANKING
$var_SqlFireBird_RANKING
	= 
	($rowMysql_Registros_MIINFO['RANKING']!='')? "'".substr($rowMysql_Registros_MIINFO['RANKING'],0,30)."'" : " NULL";

// CREDITO_TIENDA
$var_SqlFireBird_CREDITO_TIENDA
	= 
	($rowMysql_Registros_MIINFO['CREDITO_TIENDA']!='')? "".substr((float)$rowMysql_Registros_MIINFO['CREDITO_TIENDA'],0,18)."" : " NULL";

							
			$sqlFireBird_Insert_Registro_MIINFO = "
				Insert Into 
					MIINFO_DESCARGA
						(
							OPERADOR
							, NOMBRE
							, APELLIDOS
							, SUCURSAL
							, CALLE
							, NO_EXT
							, CRUZAMIENTO
							, COLONIA
							, CP
							, CIUDAD_ID
							, RFC
							, TELEFONO_CASA
							, TELEFONO_CELULAR
							, CIA_CEL
							, TELEFONO_TRABAJO
							, ESTADO_CIVIL
							, FECHA_NACIMIENTO
							, LUGAR_NACIMIENTO
							, ESCOLARIDAD
							, EMAIL
							, VEHICULO_PROPIO
							, CUENTA_BANCARIA
							, BANCO
							, TIPO_CUENTA
							, CLABE
							, CEDULA_CNSF
							, VIGENCIA
							, ACCIDENTE_AVISAR
							, TELEFONO_ACCIDENTE
							, RECOMENDADO_POR
							, IMAGEN
							, IMSS
							, REFERENCIAS
							, HIJOS
							, GASTO_MENSUAL
							, GUSTARIA_GANAR
							, CONSULTOR_ID
							, MODELO_VEHICULO
							, TIPO_AUTO
							, COLOR_FAVORITO
							, COMIDA_FAVORITA
							, ANIVERSARIO_BODA
							, PASATIEMPO
							, CLUB_SOCIAL
							, LICENCIA_MANEJAR
							, LICENCIA_VIGENCIA
							, PASAPORTE
							, PASAPORTE_VIGENCIA
							, RANKING
							, LIMITE
							, TOCADO
 							, FECHAPROCESO
						) 
						Values
						(
							".$var_SqlFireBird_VALOR."
							,".$var_SqlFireBird_NOMBRE."
							,".$var_SqlFireBird_APELLIDOS."
							,".$var_SqlFireBird_SUCURSAL."
							,".$var_SqlFireBird_CALLE."
							,".$var_SqlFireBird_NO_EXT."
							,".$var_SqlFireBird_CRUZAMIENTO."
							,".$var_SqlFireBird_COLONIA."
							,".$var_SqlFireBird_CP."
							,".$var_SqlFireBird_CIUDAD_ID."
							,".$var_SqlFireBird_RFC."
							,".$var_SqlFireBird_TELEFONO_CASA."
							,".$var_SqlFireBird_TELEFONO_CELULAR."
							,".$var_SqlFireBird_CIA_CEL."
							,".$var_SqlFireBird_TELEFONO_TRABAJO."
							,".$var_SqlFireBird_ESTADO_CIVIL."
							,".$var_SqlFireBird_FECHA_NACIMIENTO."
							,".$var_SqlFireBird_LUGAR_NACIMIENTO."
							,".$var_SqlFireBird_ESCOLARIDAD."
							,".$var_SqlFireBird_EMAIL."
							,".$var_SqlFireBird_VEHICULO_PROPIO."
							,".$var_SqlFireBird_CUENTA_BANCARIA."
							,".$var_SqlFireBird_BANCO."
							,".$var_SqlFireBird_TIPO_CUENTA."
							,".$var_SqlFireBird_CLABE."
							,".$var_SqlFireBird_CEDULA_CNSF."
							,".$var_SqlFireBird_VIGENCIA."
							,".$var_SqlFireBird_ACCIDENTE_AVISAR."
							,".$var_SqlFireBird_TELEFONO_ACCIDENTE."
							,".$var_SqlFireBird_RECOMENDADO_POR."
							,".$var_SqlFireBird_IMAGEN."
							,".$var_SqlFireBird_IMSS."
							,".$var_SqlFireBird_REFERENCIAS."
							,".$var_SqlFireBird_TIENE_HIJOS."
							,".$var_SqlFireBird_GASTO_PROMEDIO_MENSUAL."
							,".$var_SqlFireBird_CUANTO_TE_GUSTARIA_GANAR."
							,".$var_SqlFireBird_CONSULTOR."
							,".$var_SqlFireBird_MODELO_VEHICULO."
							,".$var_SqlFireBird_TIPO_AUT."
							,".$var_SqlFireBird_COLOR_FAVORITO."
							,".$var_SqlFireBird_COMIDA_FAVORITA."
							,".$var_SqlFireBird_ANIVERSARIO_BODAS."
							,".$var_SqlFireBird_PASATIEMPO_FAVORITO."
							,".$var_SqlFireBird_CLUB_SOCIAL."
							,".$var_SqlFireBird_LICENCIA_MANEJAR."
							,".$var_SqlFireBird_VIGENCIA_LICENCIA_MANEJAR."
							,".$var_SqlFireBird_PASAPORTE."
							,".$var_SqlFireBird_VIGENCIA_PASAPORTE."
							,".$var_SqlFireBird_RANKING."
							,".$var_SqlFireBird_CREDITO_TIENDA."
							,'XX'
							,'".date('Y-m-d g:i')."'
						);
												 ";
//			echo "<pre>";
	//			echo $sqlFireBird_Insert_Registro_MIINFO;
	//			echo $sqlMysql_Update_Registro_MIINFO;
//			echo "</pre>";
			
			$resFireBird_Insert_Registro_MIINFO = DreQueryDbFireBird($sqlFireBird_Insert_Registro_MIINFO);			
			DreFreeResultDbFireBird($resFireBird_Insert_Registro_MIINFO);
	
			$sqlMysql_Update_Registro_MIINFO = "
				Update
					`info_usuarios_vendedores`
				Set
					 `actualizado` = '0'
				Where 
					`VALOR` = '".$rowMysql_Registros_MIINFO['VALOR']."'
											  ";
			DreQueryDB($sqlMysql_Update_Registro_MIINFO);
			

		}		
		
		//-->
		
	} else { // ELSE If existenRegistrosMysql
		//echo "No hay Registros a Procesar<br>";
		
		//-->
				
	}// Fin If existenRegistrosMysql

echo "Actualizacion de Correcta !!!";
include('CerrarVentana.php');

DreDesconectarDbFireBird($conexFireBird);
DreDesconectarDB($conexMySql);
?>