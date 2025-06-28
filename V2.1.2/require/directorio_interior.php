<?php if( obtenerNavegador($dm_usergent,$_SERVER['HTTP_USER_AGENT']) != 'Desconocido' ){ $movil = ""; /*echo "Dm";*/  }else{ /*echo "Pc";*/ } ?>
<?php

	$buscaEmpresa = rtrim(ltrim($buscaEmpresa));
	$buscaEmpresaArray  = explode(' ', $buscaEmpresa);
	$buscaEmpresaCount = count($buscaEmpresaArray);

	if($buscaEmpresaCount > 1){
		// echo "usamos Match";
		$buscaEmpresa = "+".str_replace(" ", " +", ltrim(rtrim($buscaEmpresa)));
		foreach($buscaEmpresaArray as $nombre){
			$nombreClean = str_replace("+","",ltrim(rtrim($nombre)));
			$nombreLength = strlen($nombreClean); 
			if($nombreLength <= 3){
				?>
                <script>
					var textoAlert = '';
						textoAlert += 'El Nombre: ';
						textoAlert += '\" <?php echo $nombreClean; ?> \"';
						textoAlert += 'Tiene Menos de 4 Letras !!! \r\n\r\n';
						textoAlert += 'Para efectuar la busqueda, el nombre debe de ser de mas de 4 letras.';
					alert(textoAlert);
				</script>
				<?
			}
		}
		$sqlBusquedaLikeMatch = "
			MATCH (`RAZON_SOCIAL`) AGAINST ('$buscaEmpresa' IN BOOLEAN MODE)
			And
								";
								
		$sqlBusquedaLikeMatchProveedores = "
	 	Where
			MATCH (`Nombre`) AGAINST ('$buscaEmpresa' IN BOOLEAN MODE)
										   ";
										   
		$sqlBusquedaLikeMatchContactos = "
	 	Where
			MATCH (`Nombre_misContactos`) AGAINST ('$buscaEmpresa' IN BOOLEAN MODE)
			And
			`userCreador` = '$Usuario'
										 ";

		$sqlBusquedaLikeMatchEmpleados = "
	 	Where
			MATCH (`Nombre`) AGAINST ('$buscaEmpresa' IN BOOLEAN MODE)
			And
			`status` = '0'
										 ";

	} else if($buscaEmpresaCount == 1){
		$sqlBusquedaLikeMatch = "
			`RAZON_SOCIAL` Like '%$buscaEmpresa%'
			And
								";
		$sqlBusquedaLikeMatchProveedores = "
		Where
			`Nombre` Like '%$buscaEmpresa%'
			Or
			`Nombre_organizacion` Like '%$buscaEmpresa%'
			Or
			`Nombre_contacto` Like '%$buscaEmpresa%'
			Or
			`categoria` Like '%$buscaEmpresa%'
										   ";
										   
		$sqlBusquedaLikeMatchContactos = "
		Where
			`Nombre_misContactos` Like '%$buscaEmpresa%'
			And
			`userCreador` = '$Usuario'
										 ";
										 
		$sqlBusquedaLikeMatchEmpleados = "
		Where
			`Nombre` Like '%$buscaEmpresa%'
			And
			`status` = '0'
										 ";
	}
				
switch($Nivel){ // New Version
//---- Sin Filtro --------------------//				
	case '5': // NIVEL 5
	if($buscaEmpresa == ""){
		$sqlClientesListado = "
			Select * From
				`empresas`
			Where
				`TIPO_REGISTRO` Like '%CL%'
				And 
				`estatusCliente` Like '%A%'
			Order By
				`RAZON_SOCIAL` Asc
							  ";
		$sqlProspectosListado = "
			Select * From
				`empresas`
			Where
				`TIPO_REGISTRO` Like '%PR%'
				And
				`estatusCliente` Like '%A%'
			Order By
				`RAZON_SOCIAL` Asc
								";
	} else {
		$sqlClientesListado = "
			Select * From
				`empresas`
			Where
				(
					$sqlBusquedaLikeMatch
					`TIPO_REGISTRO` Like '%CL%'
				)
				And 
				`estatusCliente` Like '%A%'
			Order By 
				`RAZON_SOCIAL` Asc
							  ";
		$sqlProspectosListado = "
			Select * From 
				`empresas`
			Where
				(
					$sqlBusquedaLikeMatch
					`TIPO_REGISTRO` Like '%PR%'
				)
				And 
				`estatusCliente` Like '%A%'
			Order By
				`RAZON_SOCIAL` Asc
								";
	}
	break;
				
//---- Filtra Sucursal --------------------//
	case '4': // NIVEL 4
	if(!isset($buscaEmpresa)){
		$sqlClientesListado = "
			Select * From
				`empresas`
			Where
				(
					`SUCURSAL` Like '%".$Sucursal."%'
					And
					`TIPO_REGISTRO` Like '%CL%'
				)
				And
				`estatusCliente` Like '%A%'
			Order By
				`RAZON_SOCIAL` Asc
							  ";
							  
		$sqlProspectosListado = "
			Select * From
				`empresas`
			Where
				(
					`SUCURSAL` Like '%".$Sucursal."%'
					And
					`TIPO_REGISTRO` Like '%PR%'
				)
				And
				`estatusCliente` Like '%A%'
			Order By
				`RAZON_SOCIAL` Asc
								";
	} else {
		$sqlClientesListado = "
			Select * From 
				`empresas`
			Where
				(
					$sqlBusquedaLikeMatch
					`SUCURSAL` Like '%".$Sucursal."%'
					And 
					`TIPO_REGISTRO` Like '%CL%'
				)
				And								
				`estatusCliente` Like '%A%'
			Order By 
				`RAZON_SOCIAL` Asc
							  ";
		$sqlProspectosListado = "
			Select * From 
				`empresas`
			Where
				(
					$sqlBusquedaLikeMatch
					`SUCURSAL` Like '%".$Sucursal."%'
					And 
					`TIPO_REGISTRO` Like '%PR%'
				)
				And
				`estatusCliente` Like '%A%'
			Order By 
				`RAZON_SOCIAL` Asc
								";
	}
	break;
				
//---- Filtra Vendedor y Promotor --------------------//
	case '3': // NIVEL 3
	if(!isset($buscaEmpresa)){
		$sqlClientesListado = "
			Select * From
				`empresas`
			Where
				(
					(
						`VENDEDOR` Like '%".$Vendedor."%' 
						Or 
						`PROMOTOR` Like '%".$Vendedor."%'
					)
					And
					`TIPO_REGISTRO` Like '%CL%'
				)
				And
				`estatusCliente` Like '%A%'
			Order By
				`RAZON_SOCIAL` Asc 
							  ";
		$sqlProspectosListado = "
			Select * From
				`empresas`
			Where
				(
					(
						`VENDEDOR` Like '%".$Vendedor."%' 
						Or
						`PROMOTOR` Like '%".$Vendedor."%'
					)
					And
					`TIPO_REGISTRO` Like '%PR%'
				)
				And								
				`estatusCliente` Like '%A%'
			Order By 
				`RAZON_SOCIAL` Asc 
								";
	} else {
		$sqlClientesListado = "
			Select * From
				`empresas`
			Where
				(
					$sqlBusquedaLikeMatch
					(
						`VENDEDOR` Like '%".$Vendedor."%' 
						Or 
						`PROMOTOR` Like '%".$Vendedor."%'
					)
					And
					`TIPO_REGISTRO` Like '%CL%'
				)
				And								
				`estatusCliente` Like '%A%'									
			Order By
				`RAZON_SOCIAL` Asc
							  ";
		$sqlProspectosListado = "
			Select * From
				`empresas`
			Where
				(
					$sqlBusquedaLikeMatch
					(
						`VENDEDOR` Like '%".$Vendedor."%' 
						Or 
						`PROMOTOR` Like '%".$Vendedor."%'
					)
					And
					`TIPO_REGISTRO` Like '%PR%'
				)
				And								
				`estatusCliente` Like '%A%'
			Order By
				`RAZON_SOCIAL`  Asc
								";
	}
	break;

//---- Filtra Vendedor --------------------//
	case '2': // NIVEL 2
	if(!isset($buscaEmpresa)){
		$sqlClientesListado = "
			Select * From
				`empresas`
			Where
				(
					`VENDEDOR` Like '%".$Vendedor."%'
					And
					`TIPO_REGISTRO` Like '%CL%'
				)
				And								
				`estatusCliente` Like '%A%'
			Order By
				`RAZON_SOCIAL` Asc
							  ";
		$sqlProspectosListado = "
			Select * From
				`empresas`
			Where
				(
					`VENDEDOR` Like '%".$Vendedor."%'
					And
					`TIPO_REGISTRO` Like '%PR%'
				)
				And								
				`estatusCliente` Like '%A%'
			Order By
				`RAZON_SOCIAL` Asc
								";
	} else {
		$sqlClientesListado = "
			Select * From
				`empresas`
			Where
				(
					$sqlBusquedaLikeMatch
					`VENDEDOR` Like '%".$Vendedor."%'
					And 
					`TIPO_REGISTRO` Like '%CL%'
				)
				And								
				`estatusCliente` Like '%A%'
			Order By
				`RAZON_SOCIAL` Asc
							  ";
		$sqlProspectosListado = "
			Select * From 
				`empresas`
			Where
				(
					$sqlBusquedaLikeMatch
					`VENDEDOR` Like '%".$Vendedor."%'
					And 
					`TIPO_REGISTRO` Like '%PR%'
				)
				And								
				`estatusCliente` Like '%A%'
			Order By 
				`RAZON_SOCIAL` Asc
								";
	}
	break;
}

	if(!isset($buscaEmpresa)){

		$sqlProveedoresListado = "
			Select * From 
				`organizaciones`
			Order By 
				`Nombre` Asc
								";
								
		$sqlMisContactosListado = "
			Select * From 
				`miinfo_miscontactos`
			Where
				`userCreador` = '$Usuario'
			Group By
				`Nombre_misContactos`
			Order By
				`Nombre_misContactos` Asc
								  ";

		$sqlEmpleadosListado = "
			Select * From 
				`miinfo_empleados`
			Where
				`status` = '0'
			Order By 
				`Nombre` Asc
								";
	} else {
		$sqlProveedoresListado = "
			Select * From 
				`organizaciones` Inner Join `miinfo_proveedores`
				On
				`organizaciones`.`id` = `miinfo_proveedores`.`organizacion_id`
			$sqlBusquedaLikeMatchProveedores
			Order By 
				`Nombre` Asc
								";

		$sqlMisContactosListado = "
			Select * From 
				`miinfo_miscontactos`
			$sqlBusquedaLikeMatchContactos
			Group By
				`Nombre_misContactos`
			Order By
				`Nombre_misContactos` Asc
								  ";
								  
		$sqlEmpleadosListado = "
			Select * From 
				`miinfo_empleados`
			$sqlBusquedaLikeMatchEmpleados
			Order By 
				`Nombre` Asc
								";
	}
//echo "<pre>";
	//print_r($_REQUEST);
	//echo $sqlProveedoresListado;
	//echo $sqlClientesListado;
	//echo $sqlProspectosListado;			
	//echo $sqlMisContactosListado;
	//echo $sqlProveedoresListado;
//echo "</pre>";
?>
<table width="950" cellpadding="0" cellspacing="0" border="0">
	<tr>
		<td colspan="4">
			<form name="formBuscaEmpresa" id="formBuscaEmpresa" method="post" action="<? echo $_SERVER['PHP_SELF']; ?>">
            	<input name="buscaEmpresa" type="text" id="buscaEmpresa" value="<? echo (isset($_REQUEST['buscaEmpresa']))? $_REQUEST['buscaEmpresa'] : "" ; ?>" style="width:880px;">
                <input type="hidden" name="Vendedor" id="Vendedor" value="<? echo (isset($_SESSION['WebDreTacticaWeb2']['Vendedor']))? $_SESSION['WebDreTacticaWeb2']['Vendedor'] : "" ; ?>">
                <input type="submit" name="button" id="button" value="Buscar" title="Clic">
			</form>
        </td>
    </tr>
    <tr align="center">
    	<td width="237">
        	<form name="formNuevaEmpresaFisica" id="formNuevaEmpresa" method="post" action="clienteAgregar.php?tipoPer=F">
            	<input type="submit" name="button" id="button" value="Agregar Prospecto PF"  title="Crear Prospectos"><!--Agregar Persona F&iacute;sica -->
			</form>        
        </td>
    	<td width="237">
        	<form name="formNuevaEmpresaMoral" id="formNuevaEmpresa" method="post" action="clienteAgregar.php?tipoPer=M">
            	<input type="submit" name="button" id="button" value="Agregar Prospecto PM"  title="Crear Prospectos"><!-- Persona Moral -->
			</form>
        </td>
        
    	<td width="237">
        <?php
			if($Grupo != "2" && $Nivel > 2){
		?>
        	<form name="formNuevaEmpresaFisica" id="formNuevaEmpresa" method="post" action="proveedorAgregar.php">
            	<input type="submit" name="button" id="button" value="Agregar Proveedor"  title="Crear Proveedor">
			</form>        
        <?php
			}
		?>
        </td>
    	<td width="239">
        	<form name="formNuevaEmpresaMoral" id="formNuevaEmpresa" method="post" action="misContactosAgregar.php">
            	<input type="submit" name="button" id="button" value="Agregar Contactos Personales"  title="Crear Contacto"><!-- Mis -->
			</form>
        </td>        
    </tr>
<?php
if($buscaEmpresa != ""){// Validacion No Mostrar Nada Hasta que no se Busque Algo
?>
    <tr>
    	<td colspan="4">
        	<strong>Clientes:</strong>
        </td>
    </tr>
    <?
//		echo "<pre>";
	//		echo $sqlClientesListado;
//		echo "</pre>";
	?>
<form name="formSelectEmpresa" id="formSelectEmpresa" method="post">
    <tr>
    	<td colspan="4">
        	<select name="idRef_Cliente" id="idRef_Cliente" <? echo (!isset($movil))? 'onDblClick="DetalleCliente(this.value, \'clientes\')" size="5"': 'onchange="DetalleCliente(this.value, \'clientes\')"'; ?> style="width:100%;">
            <?php
				$resClientesListado = DreQueryDB($sqlClientesListado);
				while($rowClientesListado = mysql_fetch_assoc($resClientesListado)){ 
			?>
            <option value="<? echo $rowClientesListado['CLAVE']; ?>" <? echo ($rowClientesListado['CLAVE']==$CLAVE)? "selected" : "" ;?> title="<?php echo "Vendedor: ".nombreVendedor($rowClientesListado['VENDEDOR']); ?>">
            	<?php  echo $rowClientesListado['RAZON_SOCIAL']; ?>
            </option>
            <?php
				}
			?>
        	</select>
        </td>
    </tr>
<?
	if(isset($movil)){
?>
    <tr>
    	<td colspan="4" align="right">
        	<input type="button" onClick="DetalleCliente(idRef_Cliente.value, 'clientes');" value="Seleccionar Cliente" class="buttonGeneral" />
            &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
		</td>
	</tr>
<?
	}
?>
    <tr>
    	<td colspan="4">&nbsp;</td>
	</tr>    
    <tr>
    	<td colspan="4">
			<strong>Prospectos:</strong>
        </td>
    </tr>
    <tr>
    	<td colspan="4">
        	<select name="idRef_Prospecto" id="idRef_Prospecto" <? echo (!isset($movil))? 'onDblClick="DetalleCliente(this.value, \'clientes\')" size="5"': 'onchange="DetalleCliente(this.value, \'clientes\')"'; ?> style="width:100%;">
            <?php 
				$resProspectosListado = DreQueryDB($sqlProspectosListado);
				while($rowProspectosListado = mysql_fetch_assoc($resProspectosListado)){ 
			?>
            <option value="<? echo $rowProspectosListado['CLAVE']; ?>" <? echo ($rowProspectosListado['CLAVE']==$CLAVE)? "selected" : "" ;?> title="<?php echo "Vendedor: ".nombreVendedor($rowProspectosListado['VENDEDOR']); ?>">
            	<?php  echo $rowProspectosListado['RAZON_SOCIAL']; ?>
			</option>
            <?php
				}
			?>
            </select>
        </td>
    </tr>
<?
	if(isset($movil)){
?>
    <tr>
    	<td colspan="4" align="right">
        	<input type="button" onClick="DetalleCliente(idRef_Prospecto.value, 'clientes');" value="Seleccionar Prospecto" class="buttonGeneral" />
            &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
		</td>
	</tr>
<?
	}
?>
<?php if($Nivel > 2){ ?>
    <tr>
    	<td colspan="4">&nbsp;</td>
	</tr>
<?php
	if($Grupo != "2"){
?>
    <tr>
    	<td colspan="4">
			<strong>Proveedores:</strong>
        </td>
    </tr>
    <tr>
    	<td colspan="4">

        	<select name="idRef_Proveedor" id="idRef_Proveedor" <? echo (!isset($movil))? 'onDblClick="DetalleCliente(this.value, \'proveedores\')" size="5"': 'onchange="DetalleCliente(this.value, \'proveedores\')"'; ?> style="width:100%;">
            <?php 
				$resProveedoresListado = DreQueryDB($sqlProveedoresListado);
				while($rowProveedoresListado = mysql_fetch_assoc($resProveedoresListado)){ 
			?>
            <option value="<? echo $rowProveedoresListado['id']; ?>" <? echo ($rowProveedoresListado['id']==$CLAVE)? "selected" : "" ;?> title="Clic Para Ver Contactos del Proveedor">
            	<?php  echo $rowProveedoresListado['Nombre']; ?>
			</option>
            <?php
				}
			?>
            </select>
        </td>
    </tr>
<?php } ?>
<?
	if(isset($movil)){
?>
    <tr>
    	<td colspan="4" align="right">
        	<input type="button" onClick="DetalleCliente(idRef_Proveedor.value, 'proveedores');" value="Seleccionar Proveedor" class="buttonGeneral" />
            &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
		</td>
	</tr>
<?
	}
?>
    <tr>
    	<td colspan="4">&nbsp;</td>
	</tr>
<?php
	} // fin de validacion grupo
?>
    <tr>
    	<td colspan="4">
			<strong>Mis Contactos:</strong>
        </td>
    </tr>
    <tr>
    	<td colspan="4">
        	<select name="idRef_Contactos" id="idRef_Contactos" <? echo (!isset($movil))? 'onDblClick="DetalleCliente(this.value, \'contactos\')" size="5"': 'onchange="DetalleCliente(this.value, \'contactos\')"'; ?> style="width:100%;">
            <?php 
				$resMisContactosListado = DreQueryDB($sqlMisContactosListado);
				while($rowMisContactosListado = mysql_fetch_assoc($resMisContactosListado)){ 
			?>
            <option value="<? echo $rowMisContactosListado['misContactos_id']; ?>" <? echo ($rowMisContactosListado['misContactos_id']==$CLAVE)? "selected" : "" ;?> title="Clic Para Ver Contactos del Contacto">
            	<?php  echo $rowMisContactosListado['Nombre_misContactos']; ?>
			</option>
            <?php
				}
			?>
            </select>
        </td>
    </tr>
<?
	if(isset($movil)){
?>
    <tr>
    	<td colspan="4" align="right">
        	<input type="button" onClick="DetalleCliente(idRef_Contactos.value, 'contactos');" value="Seleccionar Contacto" class="buttonGeneral" />
            &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
		</td>
	</tr>
<?
	}
?>
    <tr>
    	<td colspan="4">&nbsp;</td>
	</tr>
<?php
	if($Grupo != "2"){
?>
    <tr>
    	<td colspan="4">
			<strong>Empleados:</strong>
        </td>
    </tr>
    <tr>
    	<td colspan="4">
        	<select name="idRef_Empleados" id="idRef_Empleados" <? echo (!isset($movil))? 'onDblClick="DetalleCliente(this.value, \'empleados\')" size="5"': 'onchange="DetalleCliente(this.value, \'empleados\')"'; ?> style="width:100%;">
            <?php 
				$resEmpleadosListado = DreQueryDB($sqlEmpleadosListado);
				while($rowEmpleadosListado = mysql_fetch_assoc($resEmpleadosListado)){ 
			?>
            <option value="<? echo $rowEmpleadosListado['idEmpleado']; ?>" <? echo ($rowEmpleadosListado['idEmpleado']==$CLAVE)? "selected" : "" ;?> title="Clic Para Ver Empleado">
            	<?php  echo $rowEmpleadosListado['Nombre']; ?>
			</option>
            <?php
				}
			?>
            </select>
        </td>
    </tr>
    
<?php
	} // fin validacion grupo
	if(isset($movil)){
?>
    <tr>
    	<td colspan="4" align="right">
        	<input type="button" onClick="DetalleCliente(idRef_Empleados.value, 'empleados');" value="Seleccionar Empleado" class="buttonGeneral" />
            &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
		</td>
	</tr>
<?php
	}
?>
</form>
<?php } // Validacion No Mostrar Nada Hasta que no se Busque Algo ?>
</table>