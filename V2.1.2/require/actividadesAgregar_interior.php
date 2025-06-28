<script type="text/javascript" src="js/validacionesAgregarActividad.js" ></script>
<?php
// ** validacion tipo de vista
	if( obtenerNavegador($dm_usergent,$_SERVER['HTTP_USER_AGENT']) != 'Desconocido' ){ $movil = ""; /*echo "Dm";*/  }else{ /*echo "Pc";*/ } 

// ** Complemento y ajuste buscador cliente Endosos
	$buscaPolCli = $buscadorPolizaCliente; //--> buscadorPolizaCliente
	$buscaPolCli = rtrim(ltrim($buscaPolCli));
	$buscaPolCliArray  = explode(' ', $buscaPolCli);
	$buscaPolCliCount = count($buscaPolCliArray);

	if($buscaPolCliCount > 1){
		// echo "usamos Match";
		$buscaPolCli = "+".str_replace(" ", " +", ltrim(rtrim($buscaPolCli)));
		foreach($buscaPolCliArray as $nombre){
			$nombreClean = str_replace("+","",ltrim(rtrim($nombre)));
			$nombreLength = strlen($nombreClean);
		}
		$sqlBusquedaPolCliLikeMatch = "
					Match (`RAZON_SOCIAL`) Against ('$buscaPolCli' In Boolean Mode)
								";
	} else if($buscaPolCliCount == 1){
		$sqlBusquedaPolCliLikeMatch = "
					`RAZON_SOCIAL` Like '%$buscaPolCli%'
								";
	}
	
// ** Complemento y ajuste buscador clientes 
	$buscaEmpresa = rtrim(ltrim($buscaEmpresa));
	$buscaEmpresaArray  = explode(' ', $buscaEmpresa);
	$buscaEmpresaCount = count($buscaEmpresaArray);

	if($buscaEmpresaCount > 1){
		// echo "usamos Match";
		$buscaEmpresa = "+".str_replace(" ", " +", ltrim(rtrim($buscaEmpresa)));
		foreach($buscaEmpresaArray as $nombre){
			$nombreClean = str_replace("+","",ltrim(rtrim($nombre)));
			$nombreLength = strlen($nombreClean); 
		}
		$sqlBusquedaLikeMatch = "
			Match (`RAZON_SOCIAL`) Against ('$buscaEmpresa' In Boolean Mode)
								";
	} else if($buscaEmpresaCount == 1){
		// echo "usamos Like";
		$sqlBusquedaLikeMatch = "
			`RAZON_SOCIAL` Like '%$buscaEmpresa%'
								";
	}

include('includes/Nivel.php');
?>
<table width="950" cellpadding="2" cellspacing="2" border="0" align="center">
<?php
// ** Seleccion de Subordinado [inicio]
	if($Nivel == "3"){
?>
<form name="formUsuarioCreacion" id="formUsuarioCreacion" method="post" action="<? echo $_SERVER['PHP_SELF']; ?>">
	<tr>
    	<td colspan="2">
        	Creador:
            <?php
				if(!isset($_POST['usuarioCreacion'])){
			?>
        	<select 
            	name="selectUsuarioCreacion" id="selectUsuarioCreacion" style="width:85%; " 
	            onChange="cambioUsuarioCreacion('formUsuarioCreacion'); "
            >
				<option value="">-- Seleccione --</option>
                <?
					$resUsuarioCreacion = DreQueryDB($sqlUsuarioCreacion);
					while($rowUsuarioCreacion = mysql_fetch_assoc($resUsuarioCreacion)){		
					?>
                    <option 
                    	title="<? echo "[".$rowUsuarioCreacion['VALOR']."]";?>"
                        value="<? echo $rowUsuarioCreacion['VALOR']; ?>" 
						<? 
							echo 
							(
								$rowUsuarioCreacion['VALOR'] == $_POST['selectUsuarioCreacion'] 
								|| 
								$rowUsuarioCreacion['VALOR'] == $_POST['usuarioCreacion']
							)? 
							"selected":""; 
						?>
					>
						<? echo $rowUsuarioCreacion['NOMBRE']; ?>
                    </option>
                    <?
					}
				?>
            </select>
            <?php
				} else {
			?>
			<input 
            	type="text" style="width:85%;" readonly
                name="usuarioCreacionMuestra" id="usuarioCreacionMuestra" 
            	value="<?php echo ($usuarioCreacion != "")? nombreUsuario($usuarioCreacion) : nombreUsuario($Usuario); ?>" 
            />
			<input type="hidden" name="usuarioCreacion" id="usuarioCreacion" value="<?php echo $usuarioCreacion; ?>" />
            <?php
				}
			?>
        </td>
	</tr>
</form>
<?php
	}
// ** Seleccion de Subordinado [fin]
?>

<!-- Primer Paso Seleccion de TipoActividad -->
<form name="formSelectActividad" id="formSelectActividad" method="post" action="<? echo $_SERVER['PHP_SELF']; ?>">
	<tr>
    	<td colspan="2">
		<?php
			if(!isset($Actividad)){
				SelectActividadDinamico($_SERVER['PHP_SELF'], $CLAVE, $TIPO, $Grupo, 'formSelectActividad');
			} else if(isset($Actividad)){
		?>
			Actividad:
			<input name="ActividadMuestra" type="text" id="ActividadMuestra" value="<?php echo urldecode($Actividad); ?>" readonly style="width:30%;"/>
			<input type="hidden" name="Actividad" id="Actividad" value="<?php echo $Actividad; ?>" />
		<?php
			}

			if(
				isset($Actividad)
				&&
				(
					$Actividad == "Cotizaci%F3n" 
					|| 
					$Actividad == "Emisi%F3n" 
					|| 
					$Actividad == "Diligencias"
					||
					$Actividad == "Cambio+de+Conducto"
				)
			){ //=> If SelectRamoDinamico INICIO
				echo "&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;";
				SelectRamoDinamico($Ramo, $Grupo);
			} else if(!isset($Actividad)) {
		?>
			<input type="hidden" name="Ramo" id="Ramo" value="N/A" />
		<?php
			} //=> If SelectRamoDinamico FIN
		?>
		<input 
        	type="hidden" name="usuarioCreacion" id="usuarioCreacion"
            value="<? echo (isset($selectUsuarioCreacion))? $selectUsuarioCreacion : $usuarioCreacion; ?>"
		/>
        </td>
    </tr>
</form>
<!-- Primer Paso Seleccion de TipoActividad -->
<!-- -->
<?php
	if(
		$Ramo == "L%EDneas+Personales"
		||
		$Ramo == "Da%F1os"
	){		
?>
<form name="formSubRamo" id="formSubRamo" method="post" action="<? echo $_SERVER['PHP_SELF']; ?>">
	<tr>
		<td colspan="2">
			<?php
				if(
					!isset($_GET['SUBRAMO'])
					&&
					$Actividad != "Pago+Cobranza"
				){
					SelectSubRamoDinamico($SubRamo, $Ramo, $Grupo);
				} else if($Actividad != "Pago+Cobranza"){
			?>
				SubRamo: <input type="text" name="SubRamo" id="SubRamo" value="<? echo $SubRamoLocal; ?>" style="width:40%;"/>
            <?php
				}
			?>
			<input type="hidden" name="Actividad" id="Actividad" value="<?php echo $Actividad; ?>" />
			<input type="hidden" name="Ramo" id="Ramo" value="<?php echo $Ramo; ?>" />
			<input 
        		type="hidden" name="usuarioCreacion" id="usuarioCreacion"
	            value="<? echo (isset($selectUsuarioCreacion))? $selectUsuarioCreacion : $usuarioCreacion; ?>"
			/>
        </td>
    </tr>
</form>
<?php
	}
?>
<!-- -->
<!--  Segundo Paso Seleccion de Tipo Cliente -->
<?php
	if(
		(
			isset($Actividad)
			&& 
			isset($Ramo)
		)
		&&
		(
			$Ramo != "N/A"
		)
		&&
		(
			$Actividad != "Otras+Actividades"
			&&
			$Actividad != "Aclaraci%F3n+de+Comisiones"
			&&
			$Actividad != "Solicitud+de+tarjetas+Club+Cap"
		)
	){ // If Tipo Cliente Inicio
	
			switch($Actividad){
				case "Cotizaci%F3n":
				case "Emisi%F3n":
				case "Cambio+de+Conducto":
					if(
						(
							$Ramo == "L%EDneas+Personales"
							&&
							(
								isset($SubRamo)
								&&
								$SubRamo != ""
							)
						)
						||
						(
							$Ramo == "Da%F1os"
							&&
							(
								isset($SubRamo)
								&&
								$SubRamo != ""
							)
						)
						||
						(
							$Ramo == "Autos+Individuales"
							||
							$Ramo == "Fianzas"
							||
							$Ramo == "Flotillas"
						)
					
					){
?>
<form name="formSelectCliente" id="formSelectCliente" method="post" action="<? echo $_SERVER['PHP_SELF']; ?>" >
	<input type="hidden" name="usuarioCreacion" id="usuarioCreacion" value="<?php echo $usuarioCreacion; ?>" />
    <tr>
    	<td width="205">
			Tipo Cliente / Prospecto:
        </td>    
    	<td width="745">
	<select name="tipoCliente" id="tipoCliente" onchange="JavaScript: document.formSelectCliente.submit();">
    	<option value="">-- Seleccione --</option>
    	<option value="NEW" <? echo ($tipoCliente == "NEW")? "selected":""; ?>>Nuevo</option>
    	<option value="SEARCH" <? echo ($tipoCliente == "SEARCH")? "selected":""; ?>>Existente</option>
    </select>
	<input type="hidden" name="Actividad" id="Actividad" value="<?php echo $Actividad; ?>" />
	<input type="hidden" name="Ramo" id="Ramo" value="<?php echo $Ramo; ?>" />
	<input type="hidden" name="SubRamo" id="SubRamo" value="<?php echo $SubRamo; ?>" />
    	</td>
	</tr>
</form>
<?php
					}
				break;
			}
	} // If Tipo Cliente FIN
?>	

<!-- Segundo Paso 1 -->
	<!-- Buscador de Clientes Empresas -->
	<?php include('require/actividadesAgregar_buscadorClientesEmpresas.php'); ?>
	<!-- Buscador de Clientes Empresas -->

<!-- Segundo Paso 2 -->
	<!-- Nuevo de Clientes Empresas -->
    <?php include('require/actividadesAgregar_nuevoClientesEmpresas.php'); ?>
	<!-- Nuevo de Clientes Empresas -->
    
<?php
	switch($Actividad){
		
		case "Cotizaci%F3n":
			include('require/actividadesAgregar_actividadCotizacion.php');
		break;
		
		case "Emisi%F3n":
			include('require/actividadesAgregar_actividadEmision.php');
		break;

		case "Diligencias": // 3
			include('require/actividadesAgregar_actividadDiligencias.php');
		break;
				
		case "Cambio+de+Conducto": // 4
			include('require/actividadesAgregar_actividadCambioConducto.php');			
		break;

		case "Endoso": // 5
			include('require/actividadesAgregar_actividadEndoso.php');
		break;

		case "Cancelacion": // 6
			include('require/actividadesAgregar_actividadCancelaciones.php');
		break;

		case "Siniestros": // 7
			include('require/actividadesAgregar_actividadSiniestros.php');
		break;
		
		case "Otras+Actividades": // 8
			include('require/actividadesAgregar_actividadOtrasActividades.php');
		break;
		
		case "Aclaraci%F3n+de+Comisiones": // 9
			include('require/actividadesAgregar_aclaracionComisiones.php');
		break;
		
		case "Solicitud+de+tarjetas+Club+Cap": // 10
			include('require/actividadesAgregar_solicitudTarjetasClubCap.php');
		break;
		
		case "Pago+Cobranza": // 11
			include('require/actividadesAgregar_pagoCobranza.php');
		break;
		
		case "comentarioCobranza": // 12
			include('require/actividadesAgregar_comentarioCobranza.php');
		break;
	}
?>
</table>
<script>
	Calendar.setup(
		{
		inputField : "FECHA_NACIMIENTO",
		trigger    : "FECHA_NACIMIENTO_Btn",
		onSelect   : function() { this.hide(), cambiaDatosFechaFin() },  //,CambiaFechaFin(),cambiaDatosFechaIni()
		dateFormat : "%Y-%m-%d"
		}
		);
</script>
<?
	//echo "<pre>";
		//print_r($_REQUEST);
	//echo "</pre>";
?>