<?php
include('../../config/funcionesDre.php');
$conexMySql = DreConectarDB();
echo "<pre>";

$sqlConsulta_EmpSinc = "
	Select * From 
		`empresas_sinc`
	Where
		`actualizado` = '0'
	Order By 
		`CLAVECLIENTE` Asc
	Limit 
		0,5000
				   ";
$resConsulta_EmpSinc = DreQueryDB($sqlConsulta_EmpSinc);
while($rowConsulta_EmpSinc = mysql_fetch_assoc($resConsulta_EmpSinc)){
	$sqlConsulta_Emp = "
		Select 
			* 
			, Count(*) As `ExisteNoArchivo`
		From 
			`empresas`
		Where
			`CLAVE` = '".$rowConsulta_EmpSinc['CLAVECLIENTE']."'
					   ";
	$resConsulta_Emp = DreQueryDB($sqlConsulta_Emp);
	$rowConsulta_Emp = mysql_fetch_assoc($resConsulta_Emp);
	
	if($rowConsulta_Emp['ExisteNoArchivo'] == 0){
		$sqlInsert_EmpSinc = "		
			Insert Into
				`empresas` 
						(
							`CLAVE`
							, `APELLIDO_PATERNO`
							, `APELLIDO_MATERNO`
							, `NOMBRES`
							, `RAZON_SOCIAL`
							, `TIPO_PERSONA`
							, `RFC`
							, `CURP`
							, `CALLE`
							, `NOEXTERIOR`
							, `NOINTERIOR`
							, `REFERENCIA`
							, `REFERENCIA2`
							, `COLONIA`
							, `CODIGO_POSTAL`
							, `LOCALIDAD`
							, `MUNICIPO`
							, `ESTADO`
							, `PAIS`
							, `FECHA_NACIMIENTO`
							, `NACIONALIDAD`
							, `NIVEL_ESTUDIOS`
							, `AUTOMOVIL`
							, `EDAD`
							, `ESTADO_CIVIL`
							, `GENERO`
							, `VENDEDOR`
							, `VENDEDOR1`
							, `VENDEDOR2`
							, `VENDEDOR3`
							, `LIMITE_FIANZA`
							, `TELEFONO_PARTICULAR`
							, `TELEFONO_OFICINA`
							, `TELEFONO_MOVIL`
							, `SITIO_WEB`
							, `TWITTER`
							, `FACEBOOK`
							, `CLAVEWEB`
							, `SUCURSAL`
							, `PROMOTOR`
							, `TIPO_REGISTRO`
							, `Club_Cap`
							, `Poliza_Electronica`
							, `Tipo_Cliente`
							, `estatusCliente`
							, `email`
							, `RANKING`
						) 
						VALUES 
						(
							'".$rowConsulta_EmpSinc['CLAVECLIENTE']."'
							,'".$rowConsulta_EmpSinc['APELLIDOPATERNO']."'
							,'".$rowConsulta_EmpSinc['APELLIDOMATERNO']."'
							,'".$rowConsulta_EmpSinc['NOMBRE']."'
							,'".$rowConsulta_EmpSinc['RAZONSOCIAL']."'
							,'".$rowConsulta_EmpSinc['TIPOPERSONA']."'
							,'".$rowConsulta_EmpSinc['RFC']."'
							,'".$rowConsulta_EmpSinc['CURP']."'
							,'".$rowConsulta_EmpSinc['CALLE']."'
							,'".$rowConsulta_EmpSinc['NOEXTERIOR']."'
							,'".$rowConsulta_EmpSinc['NOINTERIOR']."'
							,'".$rowConsulta_EmpSinc['REFERENCIA']."'
							,'".$rowConsulta_EmpSinc['REFERENCIA2']."'
							,'".$rowConsulta_EmpSinc['COLONIA']."'
							,'".$rowConsulta_EmpSinc['CODIGOPOSTAL']."'
							,'".$rowConsulta_EmpSinc['LOCALIDAD']."'
							,'".$rowConsulta_EmpSinc['MUNICIPIO']."'
							,'".$rowConsulta_EmpSinc['ESTADO']."'
							,'".$rowConsulta_EmpSinc['PAIS']."'
							,'".$rowConsulta_EmpSinc['FECHANACIMIENTO']."'
							,'".$rowConsulta_EmpSinc['NACIONALIDAD']."'
							,'".$rowConsulta_EmpSinc['NIVELESTUDIOS']."'
							,'".$rowConsulta_EmpSinc['AUTOMOVIL']."'
							,'".$rowConsulta_EmpSinc['EDAD']."'
							,'".$rowConsulta_EmpSinc['ESTADOCIVIL']."'
							,'".$rowConsulta_EmpSinc['GENERO']."'
							,'".$rowConsulta_EmpSinc['VENDEDOR']."'
							,'".$rowConsulta_EmpSinc['VENDEDOR2']."'
							,'".$rowConsulta_EmpSinc['VENDEDOR3']."'
							,'".$rowConsulta_EmpSinc['VENDEDOR4']."'
							,'".$rowConsulta_EmpSinc['LIMITEFIANZA']."'
							,'".$rowConsulta_EmpSinc['TELEFONOPARTICULAR']."'
							,'".$rowConsulta_EmpSinc['TELEFONOOFICINA']."'
							,'".$rowConsulta_EmpSinc['TELEFONOMOVIL']."'
							,'".$rowConsulta_EmpSinc['SITIOWEB']."'
							,'".$rowConsulta_EmpSinc['TWITTER']."'
							,'".$rowConsulta_EmpSinc['FACEBOOK']."'
							,'".$rowConsulta_EmpSinc['CLAVEWEB']."'
							,'".$rowConsulta_EmpSinc['SUCURSAL']."'
							,'".$rowConsulta_EmpSinc['PROMOTOR']."'
							,'".$rowConsulta_EmpSinc['TIPO']."'
							,'".$rowConsulta_EmpSinc['CLUB_CAP']."'
							,'".$rowConsulta_EmpSinc['POLIZAELECTRONICA']."'
							,'".$rowConsulta_EmpSinc['TIPOCLIENTE']."'
							,'".$rowConsulta_EmpSinc['ESTATUS']."'
							,'".$rowConsulta_EmpSinc['EMAIL']."'
							,'".$rowConsulta_EmpSinc['RANKING']."'
						)
							 ";
		$resInsert_ImgSinc = DreQueryDB($sqlInsert_EmpSinc);
	}

$sqlUpdate_ImgSinc = "
		Update
			`empresas_sinc`
		Set
			`actualizado` = '1'
		Where
			`CLAVECLIENTE` = '".$rowConsulta_EmpSinc['CLAVECLIENTE']."'
					   ";
	$resUpdate_ImgSinc = DreQueryDB($sqlUpdate_ImgSinc);
}

echo "Actualizacion de Correcta !!!";
include('CerrarVentana.php');

echo "</pre>";
DreDesconectarDB($conexMySql);
?>