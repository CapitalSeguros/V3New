<?php
require_once('../includes/funcionesDre.php');
require_once('../nusoap-0.9.5/lib/nusoap.php');
extract($_REQUEST);

$conex = DreConectarDB();


echo $FileXML = "../xmlTodos/hdi/10012014_182615.xml"; 

if(file_exists($FileXML)){ // el archivo es necesario que se depuere hasta dejarlo lo mas limpio en Formato XML
	echo "<br>Si Existe el Archivo<br>";
	
	 $datosCotizacion  =  simplexml_load_file($FileXML); 
	if($datosCotizacion){
		echo "Si Cargamos el XML";

		foreach($datosCotizacion->getpackagesResult as $cotizacion){
//--> Guardamos Info en la Tabla Comparativa

$idActividad = $idActividad;
$idCliente = $idEmpresa;
$idUsuario = $idUsuario;
$descripcion = $wsMarca." - ".$wsModelo;
$modelo = $wsYear;
$uso = $tipo_uso;
$aseguradora = "aba";
$prima_danosMateriales = "VCMS";
$prima_roboTotal = "VCMS";
$prima_rc = "3000000";
$prima_gastosMedicos = "200000";
$prima_asesoriaJuridica = "AMPARADA";
$prima_asistenciaVial = "AMPARADA";
$prima_extensionRc = "EXCLUIDO";
$prima_muertaAccConducto = "100000";
$prima_rcMuerteTerceros = "AMPARADO EN  RC";
$total_contado = $primaTotal;
$total_mensual = "";
$total_trimestral = "";
$total_semestral = "";

$sqlComparativaInsert = "
	Insert Into 
		`ws_comparativo`
			(
				`idActividad`
				,`idCliente`
				,`idUsuario`
				,`descripcion`
				,`modelo`
				,`uso`								
				,`aseguradora`
				,`prima_danosMateriales`
				,`prima_roboTotal`
				,`prima_rc`
				,`prima_gastosMedicos`
				,`prima_asesoriaJuridica`
				,`prima_asistenciaVial`
				,`prima_extensionRc`
				,`prima_muertaAccConducto`
				,`prima_rcMuerteTerceros`
				,`total_contado`
				,`total_mensual`
				,`total_trimestral`
				,`total_semestral`
			)
			Values
			(
				'$idActividad'
				,'$idCliente'
				,'$idUsuario'
				,'$descripcion'
				,'$modelo'
				,'$uso'
				,'$aseguradora'
				,'$prima_danosMateriales'
				,'$prima_roboTotal'
				,'$prima_rc'
				,'$prima_gastosMedicos'
				,'$prima_asesoriaJuridica'
				,'$prima_asistenciaVial'
				,'$prima_extensionRc'
				,'$prima_muertaAccConducto'
				,'$prima_rcMuerteTerceros'
				,'$total_contado'
				,'$total_mensual'
				,'$total_trimestral'
				,'$total_semestral'
			)
						";

//DreQueryDB($sqlComparativaInsert);
			echo "<pre>";
//			echo "<br><br>:".$cotizacion['InformacionPaquetes']['ListaPaquetes']['PaqueteCoberturas']['Clave']; //->Movimiento[0]->NoCotizacion;
echo "<br><br>Danos Materiales:".$cotizacion->InformacionPaquetes->ListaPaquetes->PaqueteCoberturas->CoberturasObligatorias->Cobertura[0]->Deducible;
echo "<br>Robo Total:".$cotizacion->InformacionPaquetes->ListaPaquetes->PaqueteCoberturas->CoberturasObligatorias->Cobertura[1]->Deducible;
echo "<br>Suma Asegurada:".$cotizacion->InformacionPaquetes->ListaPaquetes->PaqueteCoberturas->CoberturasObligatorias->Cobertura[2]->SumaAsegurada;
echo "<br>Responsabilidad Civil:".$cotizacion->InformacionPaquetes->ListaPaquetes->PaqueteCoberturas->CoberturasObligatorias->Cobertura[2]->SumaAsegurada;
echo "<br>Gastos Medicos Ocupantes:".$cotizacion->InformacionPaquetes->ListaPaquetes->PaqueteCoberturas->CoberturasObligatoriasOpcionales->Cobertura[0]->SumaAsegurada;
echo "<br>Asesoria Juridica:".$cotizacion->InformacionPaquetes->ListaPaquetes->PaqueteCoberturas->CoberturasObligatorias->Cobertura[3]->SumaAsegurada; // si es cero es amparada
echo "<br>Extencion RC:".$cotizacion->InformacionPaquetes->ListaPaquetes->PaqueteCoberturas->CoberturasObligatoriasOpcionales->Cobertura[1]->SumaAsegurada; // si es cero es amparada
echo "<br>Muerte Acc Conductor:".$cotizacion->InformacionPaquetes->ListaPaquetes->PaqueteCoberturas->CoberturasOpcionales->Cobertura[6]->Descripcion; // si es cero es amparada
echo "<br>RC Exceso Muerte Ter:".$cotizacion->InformacionPaquetes->ListaPaquetes->PaqueteCoberturas->CoberturasObligatoriasOpcionales->Cobertura[2]->SumaAsegurada; // si es cero es amparada

echo "<br>PrimaTotal:".$cotizacion->InformacionPaquetes->ListaPaquetes->PaqueteCoberturas->Totales->PrimaTotal; // si es cero es amparada


echo "<br><br>---<br>";
//			echo $sqlComparativaInsert;
			//echo "Prima Total:".$cotizacion->DG->PTOTAL;
//			echo "<br>";
//			echo $cotizacion->Recibos->PrimaTotal;
			//echo "<br>";
			//echo "1 Recibo:".$cotizacion->DG->PRIMER_PAGO;
			//echo "<br>";
			//echo "SubSecuente Recibo:".$cotizacion->DG->PAGO_SUBSEC;
			//echo "<br>";
			//echo "No Cotizacion:".$cotizacion['NoCotizacion'];
			//echo "<br>";
			//echo $cotizacion[0];
			//echo "<br>";
			print_r($cotizacion);

			echo "</pre>";

		}// foreach $marcas
	}// if $vehiculos
}// if file_exists


DreDesconectarDB($conex);
?>
<!--
<iframe src="http://docs.google.com/gview?url=agentecapital.com/Capsys/reportes/cuadroComparativo.php?idActividad=w1375&idCliente=000000W610&embedded=true" style="width:600px; height:500px;" frameborder="0"></iframe>
-->