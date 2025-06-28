<?php
	$sqlAddPersonasAdicionales = "
		Select * From 
			`actividades_formularios_add` 
		Where
			`idFormulario` = '$rowLineasPersonales_accidentesPersonales[idInterno]'			
								 ";							 
	$resAddPersonasAdicionales = DreQueryDB($sqlAddPersonasAdicionales);	
	(int)$primerAsegurado = mysql_num_rows($resAddPersonasAdicionales);
?>
	<table width="550" cellpadding="2" cellspacing="0" border="0" align="center">
<?php
	while($rowAddPersonasAdicionales = mysql_fetch_assoc($resAddPersonasAdicionales)){
?>
 		<tr>
        	<td align="left" style="font-size:12px;">
            <?php
		echo "&bull;";
		echo "<strong>".$rowAddPersonasAdicionales['nombre_add']."</strong>";
		echo "&nbsp;[".$rowAddPersonasAdicionales['fecha_nacimiento_add']."]";
		echo "&nbsp;(".$rowAddPersonasAdicionales['edad_add'].")";
		echo "&nbsp;\"".$rowAddPersonasAdicionales['sexo_add']."\"";
		echo "&nbsp;-".$rowAddPersonasAdicionales['parentesco_add'];
			?>
            </td>
		</tr>
<?php
	}
	$sqlInformacionAsegurados = "
		Select * From 
			`empresas`
		Where
			`CLAVE` = '$rowActividad[CLAVE]'
								";
	$resInformacionAsegurados = DreQueryDB($sqlInformacionAsegurados);
	$rowInformacionAsegurados = mysql_fetch_assoc($resInformacionAsegurados);
	
		$fechaNacimientoFormat = explode('-', $rowInformacionAsegurados['FECHA_NACIMIENTO']);		
	$fecha_nacimiento = $fechaNacimientoFormat[2]."-".$fechaNacimientoFormat[1]."-".$fechaNacimientoFormat[0];
	if($rowInformacionAsegurados['GENERO'] == "F"){ $sexo_add = "Femenino"; } else { $sexo_add = "Masculino"; }
?>
	</table>
<br><br>
<table width="590" cellpadding="2" cellspacing="0" style="border:solid #CCC 1px;">
<form name="formAddPersonaAdicional" id="formAddPersonaAdicional" method="post" action="includes/agregar.php?tipoAgregar=AddPersonaAdicional">
	<tr>
    	<td width="140" align="right">
        	Fecha de nacimiento:
		</td>
    	<td align="left">
            <input type="text" name="fecha_nacimiento_add" id="fecha_nacimiento_add" <?php echo ($primerAsegurado==0)?"value='$fecha_nacimiento'":""; ?>/>
			<img src="img/cal.gif" id="fecha_nacimiento_add_Btn"  title="Clic">
            &nbsp;&nbsp;&nbsp;
            Edad:
            <input type="text" name="edad_add" id="edad_add" size="5" <?php echo ($primerAsegurado==0)?"value='$rowInformacionAsegurados[EDAD]'":""; ?>/>
        </td>
    </tr>
	<tr>
    	<td align="right">
      		Nombre:
		</td>
    	<td align="left">
        	<input type="text" name="nombre_add" id="nombre_add" size="60" <?php echo ($primerAsegurado==0)?"value='$rowInformacionAsegurados[RAZON_SOCIAL]'":""; ?>/>
        </td>
  </tr>
	<tr>
    	<td align="right">
      		Sexo:
		</td>
    	<td align="left">
			<?php echo SelectSexo(($primerAsegurado==0)?"$sexo_add":"",'','sexo_add'); ?>
            &nbsp;&nbsp;&nbsp;
        	Parentesco:
            <input name="parentesco_add" id="parentesco_add" <?php echo ($primerAsegurado==0)?"Value='Titular' readonly":""; ?>/>
        </td>
  </tr>
	<tr>
	  <td align="right">&nbsp;</td>
	  <td align="right">
      <input type="hidden" name="idActividad" id="idActividad" value="<?php echo $rowDatosActividad['idInterno'] ?>" />
      	<input type="hidden" name="idFormulario" id="idFormulario" value="<?php echo $rowLineasPersonales_accidentesPersonales['idInterno'] ?>" />
        <?php if(mysql_num_rows(DreQueryDB($sqlExisteFormularioActividad))>0){ ?>
      	<input type="button" value="Guardar Persona" onClick="ValidarAddPersonaAdicional();" />
        <?php } ?>
        &nbsp;&nbsp;&nbsp;
      </td>
  </tr>
  <input type="hidden" name="tipoLineaPersonal" id="tipoLineaPersonal" value="<? echo $tipoLineaPersonal; ?>" />
  <input type="hidden" name="recId" id="recId" value="<? echo $recId; ?>" />
</form>
<!--
    <input type="date" name="user_date" id="user_date" />
    <input type="button" value="Calcular edad" onclick="javascript:calcularEdad();" />
    <div id="result"></div>
-->
</table>
<script type="text/javascript">
	Calendar.setup({
		inputField : "fecha_nacimiento_add",
		trigger    : "fecha_nacimiento_add_Btn",
		onSelect   : function() { this.hide() },
		dateFormat : "%d-%m-%Y"
	});
	
/**
 * Funcion que devuelve true o false dependiendo de si la fecha es correcta.
 * Tiene que recibir el dia, mes y año
 */
function isValidDate(day,month,year)
{
    var dteDate;
    
    // En javascript, el mes empieza en la posicion 0 y termina en la 11 
    //   siendo 0 el mes de enero
    // Por esta razon, tenemos que restar 1 al mes
    month=month-1;
    // Establecemos un objeto Data con los valore recibidos
    // Los parametros son: año, mes, dia, hora, minuto y segundos
    // getDate(); devuelve el dia como un entero entre 1 y 31
    // getDay(); devuelve un num del 0 al 6 indicando siel dia es lunes,
    //   martes, miercoles ...
    // getHours(); Devuelve la hora
    // getMinutes(); Devuelve los minutos
    // getMonth(); devuelve el mes como un numero de 0 a 11
    // getTime(); Devuelve el tiempo transcurrido en milisegundos desde el 1
    //   de enero de 1970 hasta el momento definido en el objeto date
    // setTime(); Establece una fecha pasandole en milisegundos el valor de esta.
    // getYear(); devuelve el año
    // getFullYear(); devuelve el año
    dteDate=new Date(year,month,day);
    
    //Devuelva true o false...
    return ((day==dteDate.getDate()) && (month==dteDate.getMonth()) && (year==dteDate.getFullYear()));
}

/**
 * Funcion para validar una fecha
 * Tiene que recibir:
 *  La fecha en formato ingles yyyy-mm-dd
 * Devuelve:
 *  true-Fecha correcta
 *  false-Fecha Incorrecta
 */
function validate_fecha(fecha)
{
    var patron=new RegExp("^(19|20)+([0-9]{2})([-])([0-9]{1,2})([-])([0-9]{1,2})$");


    if(fecha.search(patron)==0)
    {
        var values=fecha.split("-");
        if(isValidDate(values[2],values[1],values[0]))
        {
            return true;
        }
    }
    return false;
}

function calcularEdad()
{
    var fecha=document.getElementById("user_date").value;
    if(validate_fecha(fecha)==true)
    {
        // Si la fecha es correcta, calculamos la edad
        var values=fecha.split("-");
        var dia = values[2];
        var mes = values[1];
        var ano = values[0];

        // cogemos los valores actuales
        var fecha_hoy = new Date();
        var ahora_ano = fecha_hoy.getYear();
        var ahora_mes = fecha_hoy.getMonth();
        var ahora_dia = fecha_hoy.getDate();
        
        // realizamos el calculo
        var edad = (ahora_ano + 1900) - ano;
        if ( ahora_mes < (mes - 1))
        {
            edad--;
        }
        if (((mes - 1) == ahora_mes) && (ahora_dia < dia))
        {
            edad--;
        }
        if (edad > 1900)
        {
            edad -= 1900;
        }

        document.getElementById("result").innerHTML="Tienes "+edad+" años";
    }else{
        document.getElementById("result").innerHTML="La fecha "+fecha+" es incorrecta";
    }
}
</script>