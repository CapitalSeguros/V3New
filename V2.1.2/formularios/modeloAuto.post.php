<?php
extract($_REQUEST);

function DreConectarDB(){
    $host = "localhost";
    $usuariodb = "gapsegur_tactica";
    $pwddb = "viki52";
    $db = "gapsegur_webdre_tactica";
    $enlace = mysql_connect($host,$usuariodb,$pwddb) or die("No pudo conectarse : " . mysql_error());
    if (!$enlace) {
        die('No conectado : ' . mysql_error());
    }
    $seldb = mysql_select_db($db,$enlace);
    if (!$seldb) {
        die ('No se puede usar la base de datos' . mysql_error());
    }
    return $enlace;
}

function DreDesconectarDB($conexion){
    mysql_close($conexion);
}

function DreQueryDB($sql){
    $res = mysql_query($sql) or die (mysql_error());
    return $res;
}

	$conexion = DreConectarDB();


function SelectModelo($MarcaRequest, $campoBloqueado, $ModeloRequest){
	$sqlSelectModelo = "Select * From `catalogo_modelo` Where `marca` = '$MarcaRequest' Group By `modelo` Order By `modelo` Asc";
	$resSelectModelo = DreQueryDB($sqlSelectModelo);
		$select = "";
	if($campoBloqueado == 0){
		$select .= "<select name='modelo_auto' id='modelo_auto'>";
		$select .= "<option value=''> -Seleccione- </option>";
		while($rowSelectModelo = mysql_fetch_assoc($resSelectModelo)){
			$selectedModelo = ($ModeloRequest == $rowSelectModelo['modelo'])? "selected":"";
			$select.= "<option value='$rowSelectModelo[modelo]'".$selectedEstado.">$rowSelectModelo[modelo]</option>";
		}
		$select .= "</select>";
	} else {
		$select .= "<select name='modelo_auto' id='modelo_auto'>";
		$select .= "<option value='$ModeloRequest'>$ModeloRequest</option>";
		$select .= "</select>";
	}

return
	$select;
}

echo SelectModelo($marca_autoPost,'','');
?>
