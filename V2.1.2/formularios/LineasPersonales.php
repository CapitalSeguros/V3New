<?php 
if(isset($_REQUEST['tipoLineaPersonal'])){
	$tipoLineaPersonal = $_REQUEST['tipoLineaPersonal']; 
} else {
	$tipoLineaPersonal = $rowDatosFormulario['tipoLineaPersonal']; 
}

if($tipoLineaPersonal == ""){
?>
<form name="formLineasPersonales" id="formLineasPersonales" method="get" action="<?php echo $_SERVER['PHP_SELF']; ?>" >

<select name="tipoLineaPersonal" id="tipoLineaPersonal" onchange="java: document.formLineasPersonales.submit()">
	<option> -Seleccione- </option>
    <?php
	$sqlTipoLineaPersonal = "Select * From `configdre`  Where `parametro` = 'tipoLineaPersonal' Order By `titulo`";
	$resTipoLineaPersonal = DreQueryDB($sqlTipoLineaPersonal);
	while($rowTipoLineaPersonal = mysql_fetch_assoc($resTipoLineaPersonal)){
	?>
    <option value="<?php  echo $rowTipoLineaPersonal['valor']?>"><?php echo $rowTipoLineaPersonal['titulo']; ?></option>
    <?php
	}
	?>
</select>
<input type="hidden" name="recId" id="recId" value="<?php echo $recId; ?>" />
<input type="hidden" name="muestra" id="muestra" value="<? echo $muestra; ?>" />
</form>
<?php
}

switch($tipoLineaPersonal){
	case 'AccidentesPersonales':
		require('LineasPersonales_AccidentesPersonales.php');
	break;
	case 'AccidentesPersonalesEscolares':
		require('LineasPersonales_AccidentesPersonalesEscolares.php');
	break;
	case 'Dental':
		require('LineasPersonales_Dental.php');
	break;
	case 'AhorroDotal':
		require('LineasPersonales_AhorroDotal.php');
	break;
	case 'GMM':
		require('LineasPersonales_GMM.php');
	break;
	case 'VidaProteccion':
		require('LineasPersonales_VidaProteccion.php');
	break;
	case 'PlanRetiro':
		require('LineasPersonales_PlanRetiro.php');
	break;
	case 'VidaEducacional':
		require('LineasPersonales_VidaEducacional.php');
	break;
	
}
?>