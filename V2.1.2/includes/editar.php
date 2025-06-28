<?php
session_start();
extract($_REQUEST);
if(	$seccion != "index"){
	if(!isset($_SESSION['WebDreTacticaWeb2'])){ header("Location: index.php"); }
	if(!isset($_SESSION['WebDreTacticaWeb2']['Usuario'])){ header("Location: index.php"); }
}
include('../config/funcionesDre.php');
	$conexion = DreConectarDB();
		
// Edicion Contacto
if($_REQUEST['tipoEdicion'] == 'Contacto'){
	$sqlEditarContacto = "
		Update 
			`contactos` 
		Set
			`CLAVE` = '$CLAVE'
			,`TIPO` = '$TIPO'
			,`NOMBRE` = '".strtoupper($NOMBRE)."'
			,`EMAIL` = '".strtoupper($EMAIL)."'
			,`TELEFONO` = '$TELEFONO'
			,`DIRECCION` = '".strtoupper($DIRECCION)."'
			,`actualizado` = '1'
			,`correoMasivo` = '$correoMasivo'
		Where
			`idContacto` = '$idContacto'
						 ";

DreQueryDB($sqlEditarContacto);

	$return = "../cliente.php?CLAVE=".$CLAVE."&muestra=Contactos#".$TIPO;
	?>
    <script language="javascript" type="text/javascript">
		alert('Contacto Editado Con Exito !!!');
		window.open('<?php echo $return; ?>','_self');
	</script>
	<?php
}


// Edicion MiContactoNombre
if($_REQUEST['tipoEdicion'] == 'MiContactoNombre'){
	$sqlEditarContactoProveedor = "
		Update
			`miinfo_miscontactos` 
		Set
			`Nombre_misContactos` = '$Nombre_misContactos'
		Where
			`misContactos_id` = '$misContactos_id';
									 ";
DreQueryDB($sqlEditarContactoProveedor);

	// proveedor.php?CLAVE=10&muestra=Contactos#3
	$return = "../misContactos.php?CLAVE=".$misContactos_id;
	?>
    <script language="javascript" type="text/javascript">
		alert('Mi Contacto Editado Con Exito !!!');
		window.open('<?php echo $return; ?>','_self');
	</script>
	<?php
}

// Edicion ContactoProveedor
if($_REQUEST['tipoEdicion'] == 'ProveedorNombre'){
	$sqlEditarContactoProveedor = "
		Update
			`organizaciones` 
		Set
			`Nombre` = '$Nombre'
		Where
			`id` = '$id';
									 ";
DreQueryDB($sqlEditarContactoProveedor);

	// proveedor.php?CLAVE=10&muestra=Contactos#3
	$return = "../proveedor.php?CLAVE=".$id;
	?>
    <script language="javascript" type="text/javascript">
		alert('Proveedor Editado Con Exito !!!');
		window.open('<?php echo $return; ?>','_self');
	</script>
	<?php
}

// Edicion ContactoProveedor
if($_REQUEST['tipoEdicion'] == 'ContactoProveedor'){
	$sqlEditarContactoProveedor = "
		Update
			`miinfo_proveedores` 
		Set
			`Nombre_contacto` = '$Nombre_contacto'
			,`puesto` = '$puesto'
			,`telefono1` = '$telefono1'
			,`telefono2` = '$telefono2'
			,`telefono3` = '$telefono3'
			,`telefono4` = '$telefono4'
			,`extension` = '$extension'
			,`telefono_movil` = '$telefono_movil'
			,`email` = '$email'
			,`direccion` = '$direccion'
			,`banco` = '$banco'
			,`cuenta` = '$cuenta'
			,`clabe` = '$clabe'
		Where
			`organizacion_id` = '$organizacion_id' 
			And
			`id_contacto` = '$id_contacto';
									 ";
DreQueryDB($sqlEditarContactoProveedor);

	// proveedor.php?CLAVE=10&muestra=Contactos#3
	$return = "../proveedor.php?CLAVE=".$CLAVE."&muestra=Contactos#".$TIPO;
	?>
    <script language="javascript" type="text/javascript">
		alert('Contacto Editado Con Exito !!!');
		window.open('<?php echo $return; ?>','_self');
	</script>
	<?php
}

// Edicion ContactoMiContacto
if($_REQUEST['tipoEdicion'] == 'ContactoMiContacto'){
	$sqlEditarContactoProveedor = "
		Update
			`miinfo_miscontactos` 
		Set
			`Nombre_contacto` = '$Nombre_contacto'
			,`puesto` = '$puesto'
			,`telefono1` = '$telefono1'
			,`telefono2` = '$telefono2'
			,`telefono3` = '$telefono3'
			,`telefono4` = '$telefono4'
			,`extension` = '$extension'
			,`telefono_movil` = '$telefono_movil'
			,`email` = '$email'
			,`direccion` = '$direccion'
			,`banco` = '$banco'
			,`cuenta` = '$cuenta'
			,`clabe` = '$clabe'
		Where
			`misContactos_id` = '$misContactos_id' 
			And
			`id_contacto` = '$id_contacto';
									 ";
DreQueryDB($sqlEditarContactoProveedor);

	// proveedor.php?CLAVE=10&muestra=Contactos#3
	$return = "../misContactos.php?CLAVE=".$CLAVE."&muestra=Contactos#".$TIPO;
	?>
    <script language="javascript" type="text/javascript">
		alert('Contacto Editado Con Exito !!!');
		window.open('<?php echo $return; ?>','_self');
	</script>
	<?php
}

// Edicion Empresa
if($_REQUEST['tipoEdicion'] == 'Empresa'){
	$PROMOTOR = "";
	if($EDAD <= 0){
		$EDAD = calculaedad($FECHA_NACIMIENTO);	
	}	
	// 			,`SUCURSAL` = '$SUCURSAL'

	$sqlEditarEmpresa = "
		Update 
			`empresas` 
		Set
			`APELLIDO_PATERNO` = '".strtoupper($APELLIDO_PATERNO)."' 
			,`APELLIDO_MATERNO` = '".strtoupper($APELLIDO_MATERNO)."'
			,`NOMBRES` = '".strtoupper($NOMBRES)."'
			,`RAZON_SOCIAL` = '".strtoupper($RAZON_SOCIAL)."'
			,`TIPO_PERSONA` = '$TIPO_PERSONA'
			,`RFC` = '".strtoupper($RFC)."'
			,`CURP` = '".strtoupper($CURP)."'
			,`CALLE` = '".strtoupper($CALLE)."'
			,`NOEXTERIOR` = '".strtoupper($NOEXTERIOR)."'
			,`NOINTERIOR` = '".strtoupper($NOINTERIOR)."'
			,`REFERENCIA` = '".strtoupper($REFERENCIA)."'
			, `REFERENCIA2` = '".strtoupper($REFERENCIA2)."'
			,`COLONIA` = '".strtoupper($COLONIA)."'
			,`CODIGO_POSTAL` = '".strtoupper($CODIGO_POSTAL)."'
			,`LOCALIDAD` = '".strtoupper($LOCALIDAD)."'
			,`MUNICIPO` = '".strtoupper($MUNICIPO)."'
			,`ESTADO` = '$ESTADO'
			,`PAIS` = '".strtoupper($PAIS)."'
			,`FECHA_NACIMIENTO` = '$FECHA_NACIMIENTO'
			,`NACIONALIDAD` = '".strtoupper($NACIONALIDAD)."'
			,`NIVEL_ESTUDIOS` = '$NIVEL_ESTUDIOS'
			,`AUTOMOVIL` = '$AUTOMOVIL'
			,`EDAD` = '$EDAD'
			,`ESTADO_CIVIL` = '$ESTADO_CIVIL'
			,`GENERO` = '$GENERO'
			,`VENDEDOR` = '$VENDEDOR'
			,`LIMITE_FIANZA` = '$LIMITE_FIANZA'
			,`TELEFONO_PARTICULAR` = '$TELEFONO_PARTICULAR'
			,`TELEFONO_OFICINA` = '$TELEFONO_OFICINA'
			,`TELEFONO_MOVIL` = '$TELEFONO_MOVIL'
			,`SITIO_WEB` = '$SITIO_WEB'
			,`TWITTER` = '$TWITTER'
			,`FACEBOOK` = '$FACEBOOK'
			
            ,`PROMOTOR` = '$PROMOTOR'
            ,`Club_Cap` = '$Club_Cap'
            ,`Poliza_Electronica` = '$Poliza_Electronica'
			
			,`SUCURSAL` = '$SUCURSAL'
			
			,`actualizado` = '1'
		Where 
			`CLAVE` = '$CLAVE'
						";
	DreQueryDB($sqlEditarEmpresa);

	$return = "../cliente.php?CLAVE=".$CLAVE;
	
	?>
    <script language="javascript" type="text/javascript">
	alert('Cliente Editado Con Exito !!!');
	window.open('<?php echo $return; ?>','_self');
	</script>
	<?php
}

// Edicion Empresa
if($_REQUEST['tipoEdicion'] == 'MiInfo'){	
	$sqlEditarMiInfo = "
		Update
			`info_usuarios_vendedores`
		Set
			`NOMBRE` = '".strtoupper($NOMBRE)."'
			,`APELLIDOS` = '".strtoupper($APELLIDOS)."'
			,`CALLE` = '".strtoupper($CALLE)."'
			,`NO_EXT` = '".strtoupper($NO_EXT)."'
			,`CRUZAMIENTO` = '".strtoupper($CRUZAMIENTO)."'
			,`COLONIA` = '".strtoupper($COLONIA)."'
			,`CP` = '".strtoupper($CP)."'
			,`CIUDAD_ID` = '".strtoupper($CIUDAD_ID)."'
			,`RFC` = '".strtoupper($RFC)."'
			,`TELEFONO_CASA` = '$TELEFONO_CASA'
			,`TELEFONO_CELULAR` = '$TELEFONO_CELULAR'
			,`CIA_CEL` = '$CIA_CEL'
			,`TELEFONO_TRABAJO` = '$TELEFONO_TRABAJO'
			,`ESTADO_CIVIL` = '$ESTADO_CIVIL'
			,`FECHA_NACIMIENTO` = '$FECHA_NACIMIENTO'
			,`LUGAR_NACIMIENTO` = '".strtoupper($LUGAR_NACIMIENTO)."'
			,`ESCOLARIDAD` = '$ESCOLARIDAD'
			,`EMAIL` = '$EMAIL'
			,`VEHICULO_PROPIO` = '$VEHICULO_PROPIO'
			,`CUENTA_BANCARIA` = '".strtoupper($CUENTA_BANCARIA)."'
			,`BANCO` = '".strtoupper($BANCO)."'
			,`TIPO_CUENTA` = '".strtoupper($TIPO_CUENTA)."'
			,`CLABE` = '".strtoupper($CLABE)."'
			,`CEDULA_CNSF` = '".strtoupper($CEDULA_CNSF)."'
			,`VIGENCIA` = '$VIGENCIA'
			,`ACCIDENTE_AVISAR` = '".strtoupper($ACCIDENTE_AVISAR)."'
			,`TELEFONO_ACCIDENTE` = '$TELEFONO_ACCIDENTE'
			,`RECOMENDADO_POR` = '".strtoupper($RECOMENDADO_POR)."'
			,`IMSS` = '".strtoupper($IMSS)."'
			,`REFERENCIAS` = '".strtoupper($REFERENCIAS)."'
			,`TIENE_HIJOS` = '$TIENE_HIJOS'
			,`GASTO_PROMEDIO_MENSUAL` = '".strtoupper($GASTO_PROMEDIO_MENSUAL)."'
			,`CUANTO_TE_GUSTARIA_GANAR` = '".strtoupper($CUANTO_TE_GUSTARIA_GANAR)."'
			,`CONSULTOR` = '$CONSULTOR'
			,`MODELO_VEHICULO` = '".strtoupper($MODELO_VEHICULO)."'
			,`TIPO_AUT` = '$TIPO_AUT'
			,`COLOR_FAVORITO` = '".strtoupper($COLOR_FAVORITO)."'
			,`COMIDA_FAVORITA` = '".strtoupper($COMIDA_FAVORITA)."'
			,`ANIVERSARIO_BODAS` = '$ANIVERSARIO_BODAS'
			,`PASATIEMPO_FAVORITO` = '".strtoupper($PASATIEMPO_FAVORITO)."'
			,`CLUB_SOCIAL` = '".strtoupper($CLUB_SOCIAL)."'
			,`LICENCIA_MANEJAR` = '".strtoupper($LICENCIA_MANEJAR)."'
			,`VIGENCIA_LICENCIA_MANEJAR` = '$VIGENCIA_LICENCIA_MANEJAR'
			,`PASAPORTE` = '".strtoupper($PASAPORTE)."'
			,`VIGENCIA_PASAPORTE` = '$VIGENCIA_PASAPORTE'
			,`actualizado` = '1'
		Where
			`VALOR` = '$VALOR'
					   ";
	DreQueryDB($sqlEditarMiInfo);					   
	
		if(!$_FILES['IMAGEN']['error'] == UPLOAD_ERR_NO_FILE){
			$IMAGENPath = "../img/usuarios/".$source;
			if (file_exists($IMAGENPath)) { unlink($IMAGENPath); } // Borramos el archivo si existe
			if(copy($_FILES['IMAGEN']['tmp_name'], $IMAGENPath)) {
				// Actualizamos
					$sqlImg = "
						Update
							`info_usuarios_vendedores`
						Set
							`IMAGEN` = '$sourceImagen'
						Where
							`VALOR` = '$VALOR'
							 ";
				DreQueryDB($sqlImg);		
			}
		}
		
	$return = "../miInfo.php";
	?>
    <script>
		alert('Mi Info Editado Con Exito !!!');
		window.open('<?php echo $return; ?>','_self');
	</script>
    <?php
}

// Edicion Empleado
if($_REQUEST['tipoEdicion'] == 'Empleado'){
	$sqlEditarEmpleado = "
		Update
			`miinfo_empleados` 
		Set
			`Nombre` = '$Nombre'
			,`Puesto` = '$Puesto'
			,`Ext` = '$Ext'
			,`Correo` = '$Correo'
			,`Cumple` = '$Cumple'
			,`Sucursal` = '$Sucursal'
			,`JefeInmediato` = '$JefeInmediato'
			,`Celular` = '$Celular'
			,`TipoEmpleado` = '$TipoEmpleado'
		Where
			`idEmpleado` = '$idEmpleado';
									 ";
	DreQueryDB($sqlEditarEmpleado);

	$return = "../empleados.php?CLAVE=".$idEmpleado;
	?>
    <script language="javascript" type="text/javascript">
		alert('Empleado Editado Con Exito !!!');
		window.open('<?php echo $return; ?>','_self');
	</script>
	<?php
}
DreDesconectarDB($conexion);
?>
