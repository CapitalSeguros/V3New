<script type="text/javascript" src="js/validacionesAgregarActividad.js" ></script>
<script>
function validacionTipoTermino(recId, tipoEmision){
	var url = "<? echo $_SERVER['PHP_SELF']."?recId="; ?>"+recId+"<? echo "&tipoEmision="; ?>"+tipoEmision;
	window.open(url,'_self');
}
</script>
<?php
// Consulta Principal de la Actividad
$sqlActividad = "
		Select 
			*
			,date_format(`actividades`.`fechaCreacion`, '%d-%m-%Y %H:%i:%s') As `actividadFechaCreacion`
		From 
			`actividades`
		Where 
			`actividades`.`recId` = '$_REQUEST[recId]'
		Order By
			`actividades`.`idInterno` Asc
					";
$resActividad = DreQueryDB($sqlActividad);
$rowActividad = mysql_fetch_assoc($resActividad);
	$idInterno = $rowActividad['idInterno'];
	
switch($regreso){
	default :
		$urlRegreso = "actividadesDetalle.php?recId=".$recId;
	break;	
}

switch($tipoEmision){
	case "conEmisionManual":
		$textoTipoEmision = "Emisi&oacute;n";
		$Actividad = "Emisi%F3n"; //$rowActividad['actividadInterno'];
	break;
	
	case "recotizar":
		$textoTipoEmision = "Recotizar";
		$Actividad = "Cotizaci%F3n"; //$rowActividad['actividadInterno'];
	break;
}

	$Ramo = $rowActividad['ramoInterno'];
	$SubRamo = $rowActividad['subRamoInterno'];
	
// Consultas Adicionales
$sqlConsultaCotizacion = "
	Select * From
			`actividades_formularios` 
		Where
			`idActividad` = '$rowActividad[recId]'
						 ";
//*-* $existeCotizacionManual = mysql_num_rows(DreQueryDB($sqlConsultaCotizacion));
	
$sqlConsultaWs = "
	Select * From
			`ws_comparativo`
		Where
			`idActividad` = '$rowActividad[recId]'
				 ";
//*-* $existeCotizacionWs = mysql_num_rows(DreQueryDB($sqlConsultaWs));
	
$sqlConsultaActividadesImg = "
	Select * From
			`imagenes`
		Where
			`recId` = '$rowActividad[recId]'
				 ";
//*-* $existeImg = mysql_num_rows(DreQueryDB($sqlConsultaActividadesImg));
	
//-- --// Consulta para Seleccion de Formulario
$sqlDatosActividad = "
	Select * From 
		`actividades` 
	Where 
		`idInterno` = '$idInterno' 
					 ";
//*-* $resDatosActividad = DreQueryDB($sqlDatosActividad);
//*-* $rowDatosActividad = mysql_fetch_assoc($resDatosActividad);
	
$sqlDatosFormulario = "
	Select * From 
		`actividades_formularios` 
	Where 
		`idActividad` = '$rowDatosActividad[recId]' 
		And 
		`ramoInterno` = '$rowDatosActividad[ramoInterno]'
					  ";
//*-* $resDatosFormulario = DrequeryDB($sqlDatosFormulario);
//*-* $rowDatosFormulario = mysql_fetch_assoc($resDatosFormulario);
	
$sqlDatosEmisiones = "
	Select * From 
		`actividades_emision` 
	Where 
		`idActividad` = '$rowDatosActividad[recId]' 
		And 
		`tipoEmisiones` Like '%%' 
					 ";
//*-* $resDatosEmisiones = DrequeryDB($sqlDatosEmisiones);
//*-* $rowDatosEmisiones = mysql_fetch_assoc($resDatosEmisiones);
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
	include('expresTextoRequisitos.php');
?>
<table width="950" cellpadding="0" cellspacing="0" border="0">
	<tr align="right" style="font-size:12px;" valign="top">
		<td colspan="3">
			<strong>Folio: </strong><font style="color:#F00; font-size:14px;"><?php echo $rowActividad['recId']; ?></font>
        </td>
	</tr>
	<tr align="right" style="font-size:12px;" valign="top">
		<td colspan="3">
            <strong>Fecha Creaci&oacute;n : </strong><?php echo $rowActividad['actividadFechaCreacion']; ?>
        </td>
	</tr>
	<tr align="right" style="font-size:12px;" valign="top">
		<td colspan="3">
            <strong>Status: </strong><?php DreStatusActividadV2($rowActividad['recId']); ?>
		</td>
	</tr>
    <tr valign="top">
    	<td colspan="3" align="right" style="font-size:12px;">
        	<strong>Datos Cliente: </strong>
            <a href="<?php echo "cliente.php?CLAVE=".$rowActividad['idRef']."&regreso=actividadesDetalle&recId=".$recId; ?>" style="text-decoration:none; color:#000" title="Clic para ver detalle">
            <?php 				
				echo "(".$rowActividad['idRef'].")&nbsp;";
				echo DreNombreCliente($rowActividad['idRef'])."&nbsp;";
				echo "&lt;".DreNombreClienteContacto($rowActividad['idRef'],$rowActividad['tipo'])."&gt;&nbsp;";
				echo (DreEmailClienteContacto($rowActividad['idRef'],$rowActividad['tipo']) != "")? "&bull;".DreEmailClienteContacto($rowActividad['idRef'],$rowActividad['tipo']) : "";
			?>
            </a>
        </td>
    </tr>
    <tr height="9">
    	<td colspan="3"></td>
	</tr>
<!-- -->
<form 
	name="formTerminarActividad" id="formTerminarActividad" 
	method="post" enctype="multipart/form-data" 
	action="includes/guardar.php?tipoGuardar=finalizarActividad"
>
    <tr valign="top">
    	<td colspan="3" align="">
        	<table width="900" cellpadding="1" cellspacing="1" border="0" align="center" style="font-size:12px;">
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
				<tr>
					<td colspan="2">
						<strong>Comentario:</strong>
						<font style="font-style:italic">
						<?php echo $rowActividad['referencia']; ?>
                        </font>
					</td>
				</tr>
				<tr>
					<td colspan="2" align="right">
						<input 
                        	type="button" class="buttonGeneral"
                            value="Regresar" title="Regresar a Actividades" 
                            onclick="java:window.open('<?php echo $urlRegreso; ?>','_self');" 
                        />
                    </td>
				</tr>
			</table>
        </td>
	</tr>
    <tr height="9">
    	<td colspan="3"></td>
	</tr>
<!-- -->
<?php
if(
	$rowActividad['actividadInterno'] == "Cotizaci%F3n" 
	&& 
	(
		$rowActividad['ramoInterno'] == "Autos+Individuales" 
		|| 
		$rowActividad['ramoInterno'] == "AUTOS+INDIVIDUALES+NUEVOS" 
		|| 
		$rowActividad['ramoInterno'] == "AUTOS+INDIVIDUALES+RENOVACION"
		|| 
		$rowActividad['ramoInterno'] == "L%EDneas+Personales"
		|| 
		$rowActividad['ramoInterno'] == "DA%D1OS"
		|| 
		$rowActividad['ramoInterno'] == "Da%F1os"
		|| 
		$rowActividad['ramoInterno'] == "FLOTILLAS"
		|| 
		$rowActividad['ramoInterno'] == "FIANZAS"
		|| 
		$rowActividad['ramoInterno'] == "LINEAS+PERSONALES"
		|| 
		$rowActividad['ramoInterno'] == "SINIESTROS"
	)
){

?>
    <tr>
    	<td>
        	<table width="900" cellpadding="2" cellspacing="2" border="0" align="left">
            <?
				if(isset($tipoEmision)){
			?>
            	<tr>
                	<td>
                    	<strong>Resultado:</strong>
                        <?
							echo $textoTipoEmision; 
						?>
                    </td>
                </tr>
            <?
				} else {
			?>
            	<tr>
                	<td><strong>Resultado:</strong></td>
                </tr>
            	<tr>
                	<td>
						<input 
                        	type="radio" name="Resultado" id="Resultado"  
                            style="width:20px; height:20px;"
							onChange="validacionTipoTermino('<? echo $recId; ?>',this.value);" 
							<? echo ($tipoEmision == "conEmisionManual")? "checked" : "";?>
                            value="conEmisionManual"
                        />
						Emisi&oacute;n
                    </td>
                </tr>
            	<tr>
                	<td>
                    	<input 
                        	type="radio" name="Resultado" id="Resultado"
                            style="width:20px; height:20px;" 
                            onChange="validacionTipoTermino('<? echo $recId; ?>',this.value);" 
							<? echo ($tipoEmision == "recotizar")? "checked" : "";?> 
							value="recotizar"
                        />
                        Recotizar
                    </td>
                </tr>
            <?
				}
			?>
            </table>
        </td>
    </tr>
    <tr height="9">
    	<td colspan="3"></td>
	</tr>
<?
} else {
	$tipoEmision = "N/A";
	?><input type="hidden" name="Resultado" id="Resultado" value="N/A" /><?php
}

//** TipoEmision
if(isset($tipoEmision)){
?>    
    <tr>
    	<td>
            <?php
				echo "Datos ".$textoTipoEmision." Expr&eacute;s:";
				$tipo_toolbar = "Dre";
				$oFCKeditor = new FCKeditor('comenResultado') ;
				$oFCKeditor->BasePath = 'fckeditor/' ;
				$oFCKeditor->ToolbarSet = preg_replace("/[^a-z]/i", "", $tipo_toolbar);
				$oFCKeditor->Value = "";
				$oFCKeditor->Create();          
			?>
        </td>
    </tr>
	<tr>
		<td colspan="3">
        	<!-- Textos de Emision -->
            <?
				echo $txtAsteriscos;
            ?>
		</td>
	</tr>
	<tr>
		<td colspan="3">
        	<hr>
    	</td>
	</tr>
    <tr>
    	<td colspan="3">
		<?	require('expresImgRequisitos.php'); ?>
    	</td>
	</tr>
    <tr align="right">
    	<td colspan="3">
        	<input type="hidden" name="recId" id="recId" value="<? echo $recId; ?>" />
            <input type="hidden" name="existeCotizacionWs" id="existeCotizacionWs" value="<? echo $existeCotizacionWs; ?>" />
			<input type="hidden" name="tipoEmisionEmision" id="tipoEmisionEmision" value="<? echo $tipoEmision; ?>" />
			<input type="hidden" name="Resultado" id="Resultado" value="<? echo $tipoEmision; ?>" />
			<input type="hidden" name="usuarioBolita" id="usuarioBolita" value="<? echo $rowActividad['usuario']; //$usuarioBolita; ?>" />
			<input type="hidden" name="idRef" id="idRef" value="<? echo $rowActividad['idRef'];  ?>" />
            
            <input type="hidden" name="idInternoRespuesta" id="idInternoRespuesta" value="<? echo $idInterno; ?>" />
        	<input type="button" value="<? echo $textoTipoEmision?> Actividad" class="buttonGeneral" onClick="validacionTerminarActividad();" />
            &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
        </td>
    </tr>
<?
} //** TipoEmision
?>
</form>
<!-- -->
    <tr height="9">
    	<td colspan="3"></td>
	</tr>
</table>
<br />
<?php DreDesconectarDB($conexion); ?>