<?php
	if(
		(
			isset($tipoCliente) 
			&& 
			$tipoCliente != "" 
			&& 
			$tipoCliente == "NEW"
		) 
	){
?>
<!-- formNewProspecto -->
<form name="formCotizadorExpres" id="formCotizadorExpres" method="post" enctype="multipart/form-data" action="includes/agregarActividades.php?tipoAgregar=Actividad" >
<!-- New Cliente -->
	<tr>
    	<td>
        	Nombre &oacute; Raz&oacute;n Social:
        </td>
		<td>
        	<input type="text" name="NOMBRES" id="NOMBRES" style="width:99%;" />
        </td>
	</tr>
	<tr>
    	<td>
        	Celular:
        </td>
		<td>
        	<input type="text" name="TELEFONO_MOVIL" id="TELEFONO_MOVIL" style="width:50%"/>
		</td>
	</tr>
	<tr>
		<td>
			Email:
		</td>
        <td>
			<input type="text" name="EMAIL" id="EMAIL" style="width:50%"/>
        </td>
	</tr>
	<tr>
		<td colspan="2"><hr /></td>
	</tr>
	<tr>
    	<td>
        	Vendedor:
        </td>
		<td>
		<?php
			switch($Nivel){
				case 5:
				case 4:
					if($Grupo != "2"){
		?>
			<select name="VENDEDOR" id="VENDEDOR" style="width:99%">
				<option value="0000007979">G.A.P. AGENTE DE SEGUROS Y DE FIANZAS S.A. DE C.V.</option>
		<?
			$resListadoVendedores = DreQueryDB($sqlListadoVendedores);
			while($rowListadoVendedores = mysql_fetch_assoc($resListadoVendedores)){
		?>
				<option value="<? echo $rowListadoVendedores['User']; ?>"><? echo $rowListadoVendedores['nombreVendedor']; ?></option>
		<?
			}
		?>
			</select>
		<?
					} else if($Grupo == "2"){
		?>
			<select name="VENDEDOR" id="VENDEDOR" style="width:99%;">
				<option value="0000040756">FINANCIERA BEPENSA</option>
			</select>
		<?php			
					}
				break;
				
				case 3:
		?>
			<select name="VENDEDOR" id="VENDEDOR" style="width:99%">
		<?
			$resListadoVendedores = DreQueryDB($sqlListadoVendedores);
			while($rowListadoVendedores = mysql_fetch_assoc($resListadoVendedores)){
		?>
				<option value="<? echo $rowListadoVendedores['User']; ?>" <? echo ($Usuario == $rowListadoVendedores['User'])? 'selected':''; ?>>
		<? echo $rowListadoVendedores['nombreVendedor']; ?>
        		</option>
		<?
			}
		?>
			</select>
		<?
			break;
				
			case 2:
				$resListadoVendedores = DreQueryDB($sqlListadoVendedores);
				$rowListadoVendedores = mysql_fetch_assoc($resListadoVendedores);
				$sizeText = 5+strlen($rowListadoVendedores['nombreVendedor']);
		?>
			<input type="text" style="width:99%;" value="<? echo $rowListadoVendedores['nombreVendedor']; ?>" size="<?php echo $sizeText; ?>"/>
			<input type="hidden" name="VENDEDOR" id="VENDEDOR" value="<? echo $rowListadoVendedores['User']; ?>"/>
		<?
			break;	
			}
		?>
		</td>
	</tr>                
<!-- Cotizador Expres -->
	<tr>
    	<td colspan="2">
        
			<table width="100%" cellpadding="2" cellspacing="2" border="0">
				<tr>
    				<td colspan="4"><hr /></td>
				</tr>
				<tr>
					<td colspan="4">
					<?php
						switch($Actividad){
							case "Cotizaci%F3n":
								echo "Datos Cotizaci&oacute;n Expr&eacute;s:";
							break;
							
							case "Emisi%F3n":
								echo "Datos Emisi&oacute;n Expr&eacute;s:";
							break;
							
							case "Cambio+de+Conducto";
								echo "Referencia Cambio de Conducto:";
							break;
						}
					?>  
                   		<blockquote>
							<?php
								$tipo_toolbar = "Dre";
								$oFCKeditor = new FCKeditor('Referencia') ;
								$oFCKeditor->BasePath = 'fckeditor/' ;
								$oFCKeditor->ToolbarSet = preg_replace("/[^a-z]/i", "", $tipo_toolbar);
								$oFCKeditor->Value = $txtFormulario;
								$oFCKeditor->Create();
							?>
						</blockquote>
					</td>
				</tr>
				<tr>
					<td>
					<?php
						echo $txtAsteriscos;
					?>
                    </td>
				</tr>
				<tr>
					<td colspan="4"><hr></td>
				</tr>
				<tr>
					<td colspan="4">
<!-- Multi Archivos -->
						<? require('expresImgRequisitos.php');?>
<!-- Multi Archivos -->
					</td>
				</tr>
			</table>
		</td>
	</tr>
    <tr>
		<td colspan="2" align="right">
<?php
	if(
		$Actividad == "Emisi%F3n"
		||
		$Actividad == "Cotizaci%F3n"
	){
?>
			<input name="actividadUrgente" id="actividadUrgente" type="checkbox" title="Clic Para Seleccionar" value="1" />
			<? echo urldecode($Actividad); ?> Urgente !!!
            &nbsp;
<?php
	}
?>
			<input type="hidden" name="usuarioCreacion" id="usuarioCreacion" value="<?php echo $usuarioCreacion; ?>" />
			<input type="hidden" name="Actividad" id="Actividad" value="<?php echo $Actividad; ?>" />
			<input type="hidden" name="Ramo" id="Ramo" value="<?php echo $Ramo; ?>" />
			<input type="hidden" name="SubRamo" id="SubRamo" value="<?php echo $SubRamo; ?>" /><!-- -->
			<input type="hidden" name="tipoCliente" id="tipoCliente" value="<?php echo $tipoCliente; ?>" />
			<input type="hidden" name="TIPO" id="TIPO" value="CONTACTO1" />
		    <input type="hidden" name="IDUsuarioCreacion" id="IDUsuarioCreacion" value="<?php echo (isset($_POST['Usuario']) && $_POST['Usuario']!="")? $_POST['Usuario']:$Usuario; ?>"  />
			<input type="button" value="Cancelar" onclick="java:window.open('actividades.php','_self');" class="buttonGeneral" />    
		    <input type="button" value="Guardar <? echo urldecode($Actividad); ?>" onclick="ValidarCotizadorExpresNewProspecto()" class="buttonGeneral" /><!-- ValidarAgregarActividadNewProspecto Guardar New  ValidarCotizadorExpres-->
			&nbsp;&nbsp;&nbsp;&nbsp;
        </td>
    </tr>
	<!-- Cotizador Expres -->
<!-- New Cliente -->
</form>
<?php
	}
?>