<?php
	if(
		(
			$idRefCliente == ""
			&&
			$idRefProspecto == ""
		)
		&&
		(
			$tipoCliente == "SEARCH"
		)
	){ //-> If Buscador Clientes INICIO
?>
<form name="formBuscaEmpresa" id="formBuscaEmpresa" method="post" action="<? echo $_SERVER['PHP_SELF']; ?>">
    <tr align="left">
    	<td colspan="2">
	<input 
    	type="text" name="buscaEmpresa" id="buscaEmpresa" style="width:72%;"
        value="<? echo (isset($_REQUEST['buscaEmpresa']))? $_REQUEST['buscaEmpresa'] : "" ; ?>"
    >
	<input type="hidden" name="usuarioCreacion" id="usuarioCreacion" value="<?php echo $usuarioCreacion; ?>" />
	<input type="hidden" name="Actividad" id="Actividad" value="<?php echo $Actividad; ?>" />
	<input type="hidden" name="Ramo" id="Ramo" value="<?php echo $Ramo; ?>" />
	<input type="hidden" name="SubRamo" id="SubRamo" value="<?php echo $SubRamo; ?>" />
	<?
		if($tipoCliente != ""){
	?>
    <input type="hidden" name="tipoCliente" id="tipoCliente" value="<?php echo $tipoCliente; ?>" />
    <?
		}
	?>
    <input type="submit" name="button" id="button" value="Buscar" class="buttonGeneral" title="Clic">
        </td>
	</tr>
</form>
<?php
	} else if(($idRefCliente != "" || $idRefProspecto != "" ) && $Actividad != "Diligencias") {
?>
	<tr>
    	<td>
			<strong>Cliente / Prospecto:</strong>
		</td>
    	<td>
			<input type="text" style="width:99%;" readonly name="idRefMuestra" id="idRefMuestra"
            	value="<?php echo ($idRefCliente != "")? DreNombreCliente($idRefCliente) : DreNombreCliente($idRefProspecto); ?>" 
            />
			<input type="hidden" name="idRef" id="idRef" value="<?php echo ($idRefCliente != "")? $idRefCliente : $idRefProspecto; ?>" />
        </td>
    </tr>
<?php
	} //-> If Buscador Clientes INICIO

// Resultados de las Busqueda
	if(
		(
			isset($buscaEmpresa) 
			&& 
			$buscaEmpresa != ""
		)
	){ // If buscados Empresa
?>
<!-- Clientes Existentes -->
<form name="formBuscadorCliente" id="formBuscadorCliente" method="post" action="<? echo $_SERVER['PHP_SELF']; ?>" >
<?php
		
		switch($Actividad){ // Switch Tipos de Resultados Busquedas Inicio
		
			case "Cambio+de+Conducto-Old":
?>
	<tr>
    	<td colspan="2">&nbsp;</td>
    </tr>
	<tr>
    	<td colspan="2"><strong>Clientes: <cambioConducto> </strong></td>
    </tr>
    <tr>
		<td colspan="2">
<!-- Clientes -->
	<?php
	$resClientesListado = DreQueryDB($sqlClientesListado);
	while($rowClientesListado = mysql_fetch_assoc($resClientesListado)){ 
	?>
		&nbsp;&nbsp;&nbsp;
        <input type="radio" name="idRef" id="idRef" <? echo ($rowClientesListado['CLAVE']==$CLAVE)? "checked" : "" ;?> value="<? echo $rowClientesListado['CLAVE']; ?>" title="<?php echo "Vendedor: ".nombreVendedor($rowClientesListado['VENDEDOR']); ?>" /><?php  echo $rowClientesListado['RAZON_SOCIAL']; ?>
        <br>
	<?php 
	}
	?>
		</td>
	</tr>    
	<tr>
		<td colspan="2"><strong>Prospectos:</strong></td>
    </tr>
    <tr>
		<td colspan="2">
	<?php 
	$resProspectosListado = DreQueryDB($sqlProspectosListado);
	while($rowProspectosListado = mysql_fetch_assoc($resProspectosListado)){ 
	?>
    	&nbsp;&nbsp;&nbsp;
		<input type="radio" name="idRef" id="idRef" value="<? echo $rowProspectosListado['CLAVE']; ?>" <? echo ($rowProspectosListado['CLAVE']==$CLAVE)? "checked" : "" ;?> title="<?php echo "Vendedor: ".nombreVendedor($rowProspectosListado['VENDEDOR']); ?>" /><?php  echo $rowProspectosListado['RAZON_SOCIAL']; ?>
        <br>
	<?php 
	}
	?>
		</td>
	</tr>    
<?php
			break;
			
			// Resultados de Busqueda Standar
			case "Cambio+de+Conducto":
			default:
?>
	<tr>
    	<td colspan="2"><strong>Clientes:</strong></td>
    </tr>
    <tr>
		<td colspan="2">
	<select 
    	name="idRefCliente" id="idRefCliente" style="width:100%;" 
		<? echo (!isset($movil))? 'onDblClick="validacionBuscadorClientes();" size="6"': 'onchange="validacionBuscadorClientes();"'; ?>
    >
    <?php
		if(isset($movil)){
	?>
    	<option value="">-- Seleccione un Cliente --</option>
	<?php
		}

	$resClientesListado = DreQueryDB($sqlClientesListado);
	while($rowClientesListado = mysql_fetch_assoc($resClientesListado)){ 
	?>
		<option 
        	value="<? echo $rowClientesListado['CLAVE']; ?>" 
			<? echo ($rowClientesListado['CLAVE']==$CLAVE)? "selected" : "" ;?> 
            title="<?php echo "Vendedor: ".nombreVendedor($rowClientesListado['VENDEDOR']); ?>"
        >
			<?php  echo $rowClientesListado['RAZON_SOCIAL']; ?>
		</option>
	<?php 
	}
	?>
	</select>
      </td>
    </tr>    
	<tr>
    	<td colspan="2"><strong>Prospectos:</strong></td>
    </tr>
    <tr>
    	<td colspan="2">
	<select 
    	name="idRefProspecto" id="idRefProspecto" style="width:100%;"
		<? echo (!isset($movil))? 'onDblClick="validacionBuscadorClientes();" size="6"': 'onchange="validacionBuscadorClientes();"'; ?>
    >
    <?php
		if(isset($movil)){
	?>
    	<option value="">-- Seleccione un Prospecto --</option>
	<?php
		}

	$resProspectosListado = DreQueryDB($sqlProspectosListado);
	while($rowProspectosListado = mysql_fetch_assoc($resProspectosListado)){ 
	?>
		<option 
        	value="<? echo $rowProspectosListado['CLAVE']; ?>" 
			<? echo ($rowProspectosListado['CLAVE']==$CLAVE)? "selected" : "" ;?>
	        title="<?php echo "Vendedor: ".nombreVendedor($rowProspectosListado['VENDEDOR']); ?>"
        >
			<?php  echo $rowProspectosListado['RAZON_SOCIAL']; ?>
		</option>
	<?php 
	}
	?>
	</select>
		</td>
    </tr>
    <tr align="right">
    	<td colspan="2">
			<input type="hidden" name="usuarioCreacion" id="usuarioCreacion" value="<?php echo $usuarioCreacion; ?>" />
			<input type="hidden" name="Actividad" id="Actividad" value="<?php echo $Actividad; ?>" />
			<input type="hidden" name="Ramo" id="Ramo" value="<?php echo $Ramo; ?>" />
			<input type="hidden" name="SubRamo" id="SubRamo" value="<?php echo $SubRamo; ?>" /><!-- -->
			<input type="hidden" name="tipoCliente" id="tipoCliente" value="<?php echo $tipoCliente; ?>" />
			<input type="button" value="Cancelar" onclick="java:window.open('actividades.php','_self');" class="buttonGeneral" />
		<?php
			if(isset($movil)){
		?>
            <input type="button" value="Continuar" onClick="validacionBuscadorClientes();" class="buttonGeneral" />
			&nbsp;&nbsp;&nbsp;&nbsp;
		<?php
			}
		?>
      </td>
    </tr>
<?php
			break;
		} // Switch Tipos de Resultados Busquedas Inicio
	} // If buscados Empresa
?>
</form>
<!-- Clientes Existentes -->