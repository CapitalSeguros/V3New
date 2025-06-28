<?php
// Consulta Principal de la Actividad
$sqlActividad = "
		Select 
			*
			,date_format(`actividades`.`fechaCreacion`, '%d-%m-%Y %H:%i:%s') As `actividadFechaCreacion`
		From 
			`actividades` Inner Join `empresas` 
			On
			`actividades`.`idRef` = `empresas`.`CLAVE` Inner Join `contactos`
			On 
			`empresas`.`CLAVE` = `contactos`.`CLAVE` 
		Where 
			`actividades`.`recId` = '$_REQUEST[recId]'
			And 
			`contactos`.`TIPO` = `actividades`.`tipo`
		Order By
			`actividades`.`idInterno` Asc
					";
$resActividad = DreQueryDB($sqlActividad);
$rowActividad = mysql_fetch_assoc($resActividad);
	$idInterno = $rowActividad['idInterno']; 
	
// Consultas Adicionales
$sqlConsultaCotizacion = "
	Select * From
			`actividades_formularios` 
		Where
			`idActividad` = '$rowActividad[recId]'
						 ";
$existeCotizacionManual = mysql_num_rows(DreQueryDB($sqlConsultaCotizacion));
	
$sqlConsultaWs = "
	Select * From
			`ws_comparativo`
		Where
			`idActividad` = '$rowActividad[recId]'
				 ";
$existeCotizacionWs = mysql_num_rows(DreQueryDB($sqlConsultaWs));
	
$sqlConsultaActividadesImg = "
	Select * From
			`imagenes`
		Where
			`recId` = '$rowActividad[recId]'
				 ";
$existeImg = mysql_num_rows(DreQueryDB($sqlConsultaActividadesImg));
	
//-- --// Consulta para Seleccion de Formulario
$sqlDatosActividad = "
	Select * From 
		`actividades` 
	Where 
		`idInterno` = '$idInterno' 
					 ";
$resDatosActividad = DreQueryDB($sqlDatosActividad);
$rowDatosActividad = mysql_fetch_assoc($resDatosActividad);
	
$sqlDatosFormulario = "
	Select * From 
		`actividades_formularios` 
	Where 
		`idActividad` = '$rowDatosActividad[recId]' 
		And 
		`ramoInterno` = '$rowDatosActividad[ramoInterno]'
					  ";
$resDatosFormulario = DrequeryDB($sqlDatosFormulario);
$rowDatosFormulario = mysql_fetch_assoc($resDatosFormulario);
	
$sqlDatosEmisiones = "
	Select * From 
		`actividades_emision` 
	Where 
		`idActividad` = '$rowDatosActividad[recId]' 
		And 
		`tipoEmisiones` Like '%%' 
					 ";
$resDatosEmisiones = DrequeryDB($sqlDatosEmisiones);
$rowDatosEmisiones = mysql_fetch_assoc($resDatosEmisiones);
//-- --//

//** **//
// Calculo Usuario Bolita

$usuariosActividad[md5($rowActividad['usuario'])]=array('usuario' => $rowActividad['usuario']);
$usuariosActividad[md5($rowActividad['usuarioCreacion'])]=array('usuario' => $rowActividad['usuarioCreacion']);
	unset($usuariosActividad[md5($Usuario)]);

foreach($usuariosActividad as $usuarios){
	foreach($usuarios as $usu){
		$usuarioBolita = $usu;
	}
}


// Calculamos el texto del campo descripcion para cuando son vehiculos
if($rowActividad['ramoInterno'] == "AUTOS+INDIVIDUALES"){
	if($rowActividad['actividadInterno'] == "Cotizaci%F3n"){
		$sqlDescripcionVehiculo = "Select * From `actividades_formularios` Where `idActividad` = '$rowActividad[recId]'";
		$resDescripcionVehiculo = DreQueryDB($sqlDescripcionVehiculo);
		$rowDescripcionVehiculo = mysql_fetch_assoc($resDescripcionVehiculo);
			
		$descripcionVehiculo = $rowDescripcionVehiculo['marca_auto'];
		$descripcionVehiculo .= " - ";
		$descripcionVehiculo .= str_replace(',','',$rowDescripcionVehiculo['modelo_auto']);
		$descripcionVehiculo .= " - ";
		$descripcionVehiculo .=	$rowDescripcionVehiculo['year_auto'];
		if($descripcionVehiculo == " -  - "){ $descripcionVehiculo = ""; }
	} // fin del If cuando es cotizacion
		
	if($rowActividad['actividadInterno'] == "Emisi%F3n"){
		$sqlBuscamosActividad = "Select `recId` From `actividades` Where `idInterno` = '$rowActividad[cotizacionEmision]'";
		$resBuscamosActividad = DreQueryDB($sqlBuscamosActividad);
		$rowBuscamosActividad = mysql_fetch_assoc($resBuscamosActividad);
		
		$sqlDescripcionVehiculo = "Select * From `actividades_formularios` Where `idActividad` = '$rowBuscamosActividad[recId]'";
		$resDescripcionVehiculo = DreQueryDB($sqlDescripcionVehiculo);
		$rowDescripcionVehiculo = mysql_fetch_assoc($resDescripcionVehiculo);
		
		$descripcionVehiculo = $rowDescripcionVehiculo['marca_auto'];
		$descripcionVehiculo .= " - ";
		$descripcionVehiculo .= str_replace(',','',$rowDescripcionVehiculo['modelo_auto']);
		$descripcionVehiculo .= " - ";
		$descripcionVehiculo .=	$rowDescripcionVehiculo['year_auto'];
		if($descripcionVehiculo == " -  - "){ $descripcionVehiculo = ""; }
	} // fin del If cuando es Emision
		
} // fin del IF Descripcion Vehiculo
	
// Calculamos el Email del Usuario Responsable
$sqlResponsableUsuarioEmail = "Select * From `usuarios` Where `VALOR` = '$rowActividad[usuario]'";
$resResponsableUsuarioEmail = DreQueryDB($sqlResponsableUsuarioEmail);
$rowResposableUsuarioEmail = mysql_fetch_assoc($resResponsableUsuarioEmail);	
$responsableEmail =  $rowResposableUsuarioEmail['Email'];

// Consultas Imagenes Tipo de Documentacion
//-- 1 --//	
$sqlDocumentosCliente = "
	Select * From
		`imagenes`
	Where
		`CLIENTE_MPRO` = '$rowActividad[idRef]'
		And 
		(
			(
			`TIPO` = 'CL'
			And
			`recId` = ''
			)
			Or
			(
			`TIPO_IMG` = 'IFE'
			Or 
			`TIPO_IMG` = 'COMPROBANTE DOMICILIARIO'
			Or 
			`TIPO_IMG` = 'RFC'
			Or 
			`TIPO_IMG` = 'ACTA CONSTITUTIVA'
			)
		)
	Order By
		`TIPO_IMG` Asc
						";
$ExitenDocumentosCliente = mysql_num_rows(DreQueryDB($sqlDocumentosCliente));
							
//-- 2 --//	
$sqlDocumentosActividad = "
	Select * From
		`imagenes`
	Where 
		`CLIENTE_MPRO` = '$rowActividad[idRef]'
		And
			(
				`recId` = '$rowActividad[recId]'
				And
				(
					`TIPO_IMG` <> 'IFE'
					And
					`TIPO_IMG` <> 'COMPROBANTE DOMICILIARIO'
					And
					`TIPO_IMG` <> 'RFC'
					And
					`TIPO_IMG` <> 'ACTA CONSTITUTIVA'
				)
				And 
				`VALOR` = ''
			)
	Order By
		`TIPO_IMG` Asc
						";
$ExitenDocumentosActividad = mysql_num_rows(DreQueryDB($sqlDocumentosActividad));
						
//-- 3 --//
$sqlDocumentosPolizas = "
	Select * From
		`imagenes`
	Where 
		`CLIENTE_MPRO` = '$rowActividad[idRef]'
		And
		(
			(
				`TIPO` = 'PO'
				And 
				`recId` = ''
			)
			And
			`VALOR` != ''
		)
	Group By
		`VALOR`			
	Order By
		`VALOR` Asc
						";
$ExitenDocumentosPoliza = mysql_num_rows(DreQueryDB($sqlDocumentosPolizas));
//** **//

//>> <<//
	$sqlInformacionAdicional = "
	Select * From
		`actividades`
	Where 
		 `recId` = '$rowActividad[recId]'
		 And
		 `inicio` = '1'
	Order By 
		`idInterno` Desc
							  ";
//>> <<//
?>
<table width="950" cellpadding="0" cellspacing="0" border="0">
	<tr valign="top">
		<td colspan="3" align="right" style="font-size:12px;">
			<strong>Folio:</strong> <?php echo $rowActividad['recId']; ?> 
            <strong>Fecha:</strong> <?php echo $rowActividad['actividadFechaCreacion']; ?> 
            <strong>Status:</strong> <?php echo ($rowActividad['fin'] == 1)? " Terminada" : "Proceso"; ?> 
		</td>
	</tr>
    <tr valign="top">
    	<td colspan="3" align="right" style="font-size:12px;">
        	<strong>Datos Cliente: </strong>
            <a href="<?php echo "cliente.php?CLAVE=".$rowActividad['idRef']."&regreso=actividadesDetalle&recId=".$recId; ?>" style="text-decoration:none; color:#000" title="Clic para ver detalle">
            <?php 				
				echo "(".$rowActividad['idRef'].")&nbsp;";
				echo $rowActividad['RAZON_SOCIAL']."&nbsp;";
				echo "&lt;".$rowActividad['NOMBRE']."&gt;&nbsp;";
				echo ($rowActividad['EMAIL'] != "")? "&bull;$rowActividad[EMAIL]" : "";
			?>
            </a>
        </td>
    </tr>
    <tr height="9">
    	<td colspan="3"></td>
	</tr>
<!-- -->
<form name="formTerminarActividad" id="formTerminarActividad" method="post" action="includes/guardar.php?tipoGuardar=finalizarActividad">
    <tr valign="top">
    	<td colspan="3" align="">
        	<table width="900" cellpadding="1" cellspacing="1" border="0" align="center" style="font-size:12px;">
            	<tr>
                	<td colspan="2">&nbsp;</td>
                </tr>
            	<tr class="TextoTitulosSecciondivClic">
                	<td colspan="2">
                    	Informaci&oacute;n Actividad
                    </td>
                </tr>
            	<tr align="left">
                	<td colspan="2">
                    	<strong>Creador:</strong>
                        <? echo nombreUsuario($rowActividad['usuarioCreacion']); ?>
					</td>
				</tr>
				<tr align="left">
					<td width="450">
						<strong>Responsable:</strong>
						<?php echo nombreUsuario($rowActividad['usuario']); ?>
					</td>
					<td>
						<strong>Actividad:</strong>
						<?php echo $rowActividad['actividad']; ?>
					</td>    
				</tr>
<?php
if($rowActividad['actividadInterno'] == "Otras+Actividades"){
?>
				<tr>
					<td colspan="2">
						<strong>Comentario:</strong>
						<font style="font-style:italic">
						<?php echo $rowActividad['referencia']; ?>
						
					</td>
				</tr>
<?php
}
?>
				<tr>
					<td colspan="2" align="right">
<?php
	switch($regreso){
		default :
			$urlRegreso = "actividadesDetalle.php?recId=".$recId;
		break;	
	}
	
	$urlTerminarActividad = "";
?>
						<input type="button" value="Regresar" class="buttonGeneral" title="Regresar a Actividades" onclick="java:window.open('<?php echo $urlRegreso; ?>','_self');" />
                        
                    </td>
				</tr>
				<tr>
					<td colspan="2">&nbsp;</td>
				</tr>
			</table>
        </td>
	</tr>
    <tr height="9">
    	<td colspan="3"></td>
	</tr>
<!-- -->
    <tr>
    	<td>
        	Resultado:
            <select name="Resultado" id="Resultado">
            <option value="">-- Seleccione --</option>
            <?php
				$sqlResultados = "Select * From `configdre` Where `parametro` = 'tipoResultado'";
				$resResultados = DreQueryDB($sqlResultados);
				while($rowResultados = mysql_fetch_assoc($resResultados)){
			?>
           	<option value="<?php echo $rowResultados['valor']?>"><?php echo $rowResultados['titulo']?></option>
            <?php
				}
			?>
            </select>
            <br><br>
        </td>
    </tr>
<!-- -->
<!-- -->
    <tr>
    	<td>
            Comentario Resultado:
            <?php
				$tipo_toolbar = "Dre";
				$oFCKeditor = new FCKeditor('comenResultado') ;
				$oFCKeditor->BasePath = 'fckeditor/' ;
				$oFCKeditor->ToolbarSet = preg_replace("/[^a-z]/i", "", $tipo_toolbar);
				$oFCKeditor->Value = "";
				$oFCKeditor->Create();          
			?>
        </td>
    </tr>
<!-- -->
	<tr>
    	<td>
<table width="99%" align="left">
<?php
	$sqlWsAseguradoras = "
		Select * From 
			`ws_comparativo`
		Where
			`idActividad` = '$recId'
						 ";
	$resWsAseguradoras = DreQueryDB($sqlWsAseguradoras);
while($rowWsAseguradoras = mysql_fetch_assoc($resWsAseguradoras)){
?>

    <tr style="font-size:12px; font-style:italic;">
    	<td>&nbsp;</td>
    	<td align="left"><? echo "-".$rowWsAseguradoras['aseguradora']; ?></td>
    	<td align="left"><? echo $rowWsAseguradoras['formaPago']; ?></td>
    	<td align="right"><? echo "$".number_format($rowWsAseguradoras['total'],2,'.',','); ?></td>
    	<?php if($rowWsAseguradoras['formaPago'] != "Contado"){?>
        <td align="right"><? echo "$".number_format( $rowWsAseguradoras['primerRecibo'],2,'.',','); ?></td>
    	<td align="right"><? echo "$".number_format($rowWsAseguradoras['subSecuenteRecibo'],2,'.',','); ?></td>
        <?php }?>
        <td colspan="4"><input type="radio" name="emitirAseguradora" id="emitirAseguradora" value="<?php echo $rowWsAseguradoras['idComparativo']; ?>" /></td>
	</tr>    
    <tr style="font-size:8px; font-style:italic;">
    	<td colspan="10"><?php echo $rowWsAseguradoras['descripcion']; ?></td>
    </tr>
    <tr>
    	<td colspan="10"><hr></td>
    </tr>
<?php
}
?>
</table>
        </td>
    </tr>
    <tr>
    	<td>
        	<input type="button" value="TerminarActividad" onClick="validacionTerminarActividad();" />
        </td>
    </tr>
</form>
<!-- -->
    <tr height="9">
    	<td colspan="3"></td>
	</tr>
</table>
<br />
<?php DreDesconectarDB($conexion); ?>
<!-- -->