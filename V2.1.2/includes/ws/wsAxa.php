<!--
<script language='javascript' src='../js/jquery-1.5.1.min.js'></script>
<script language='javascript' src='../js/jquery-ui-1.8.13.custom.min.js'></script>
<link rel='stylesheet' type='text/css' href='../css/jquery-ui-1.8.13.custom.css'/>
-->
<?php
// Aqui reenviamos a la sig. aseguradora.
$wsModelo = $_REQUEST['wsModelo'];
$estado = $_REQUEST['estado'];
$codigo_postal = $_REQUEST['codigo_postal'];
$tipo_uso = $_REQUEST['tipo_uso'];
$cobertura_auto = $_REQUEST['cobertura_auto'];
$valor_factura = $_REQUEST['valor_factura'];
$forma_pago = $_REQUEST['forma_pago'];
$idEmpresa = $_REQUEST['idEmpresa'];
$idUsuario = $_REQUEST['idUsuario'];
$ramoInterno = $_REQUEST['ramoInterno'];
$idInterno = $_REQUEST['idInterno'];
$idActividad = $_REQUEST['idActividad'];
$tipoLineaPersonal = $_REQUEST[''];
$recId = $_REQUEST['recId'];
$ver = $_REQUEST['ver'];
$tipoForm = $_REQUEST['tipoForm'];
$wsMarca = $_REQUEST['wsMarca'];
$wsYear = $_REQUEST['wsYear'];
$wsAseguradoraParticular = "FIN";

$urlReturnActividad = $_SERVER['PHP_SELF'];
$urlReturnActividad .= "?wsModelo=".$wsModelo;
$urlReturnActividad .= "&estado=".$estado;
$urlReturnActividad .= "&codigo_postal=".$codigo_postal;
$urlReturnActividad .= "&tipo_uso=".$tipo_uso;
$urlReturnActividad .= "&cobertura_auto=".$cobertura_auto;
$urlReturnActividad .= "&valor_factura=".$valor_factura;
$urlReturnActividad .= "&forma_pago=".$forma_pago;
$urlReturnActividad .= "&idEmpresa=".$idEmpresa;
$urlReturnActividad .= "&idUsuario=".$idUsuario;
$urlReturnActividad .= "&ramoInterno=".$ramoInterno;
$urlReturnActividad .= "&idInterno=".$idInterno;
$urlReturnActividad .= "&idActividad=".$idActividad;
$urlReturnActividad .= "&tipoLineaPersonal=".$tipoLineaPersonal;
$urlReturnActividad .= "&recId=".$recId;
$urlReturnActividad .= "&ver=".$ver;
$urlReturnActividad .= "&tipoForm=".$tipoForm;
$urlReturnActividad .= "&wsMarca=".$wsMarca;
$urlReturnActividad .= "&wsYear=".$wsYear;
$urlReturnActividad .= "&wsAseguradoraParticular=".$wsAseguradoraParticular;

//header("Location: $urlReturnActividad");
?>