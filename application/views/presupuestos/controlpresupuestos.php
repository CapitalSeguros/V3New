<script src="<?php echo(base_url())?>assets/js/bGenericV1.js"></script>
<?php $this->load->view('headers/header'); ?>
<?php $this->load->view('headers/menu');?>

<link rel="stylesheet" href="http://code.jquery.com/ui/1.10.1/themes/base/jquery-ui.css" />
<script src="https://code.jquery.com/jquery-1.12.4.js"></script>
<script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
<div class="row"><div class="col-md-6 col-sm-3 col-xs-3">
  <div style="display: none;"><label class="etiquetaSimple">Departamentos</label><?= imprimirDepartamentos($departamentos);?></div><div class="col-md-10 col-sm-10 col-xs-10"><label class="etiquetaSimple" >Apertura contable</label><?= imprimirAperturaContable($aperturaContable);?><!--button onclick="traeInfoAperturaContable()" class='btn btn-primary btn-xs contact-item'>Buscar</button--></div></div></div>
  <br><hr>
<div style="width: 99%; height: 400px;border: double;overflow: scroll; ">
  <h3>REPORTE POR AREAS</h3>
<div class="row">
	<div id="tablaReporte" class="col-md-6 col-sm-3 col-xs-3">
    	<?php if(isset($reporte)){echo(imprimirGridAperturaContable($reporte,$nomina));} ?>
    </div>
	
</div>

  <div class="row"><div class="col-sm-8"><h3><label class="label label-info">EN ESTA GRAFICA LOS GASTOS ESPECIALES NO SON CONSIDERADOS</label></h3></div></div>
<div  class="col-md-6 col-sm-3 col-xs-3">
      <canvas height="300px" width="1300px" style="" id="lienzo" ">   </canvas>
    </div>

</div>
<div style="width: 99%; height: 400px;border: double;overflow: scroll; ">
  <h3>REPORTE POR CANAL</h3>
  <div class="row">
	<div id="tablaReporte" class="col-md-6 col-sm-3 col-xs-3">
      <?php if(isset($reporte)){echo(imprimirGridCuentas($reporteCuentas,$nominaCanal));} ?>
    </div>
	
</div>
</div>


<script type="text/javascript">
function mostrarInfo(clase,objeto){
	if(objeto.innerHTML=="+"){objeto.innerHTML="-";}
	else{objeto.innerHTML="+"}
	var rows=document.getElementsByClassName(clase);
    var cant=rows.length;
    for(var i=0;i<cant;i++){
    	rows[i].classList.toggle('ocultarObjeto');
    	rows[i].classList.toggle('verObjeto');
    	rows[i].classList.toggle('verObjeto');
    	console.log()
    }
}
function traeInfoAperturaContable(){
	
		//crearObjetosParaForm(document.getElementById("usuariosPresupuestosSelect").value,'id');
			crearObjetosParaForm(document.getElementById("selectDepartamentos").value,'idPersonaDepartamento');
	
		crearObjetosParaForm(document.getElementById("selectAperturaContable").value,'aperturaContable');
	
		//crearObjetosParaForm(document.getElementById("selectFechaFactura").value,'fechaFactura');
	
		//crearObjetosParaForm(document.getElementById("idPersonaDepartamento").value,'idPersonaDepartamento');
        enviarFormGenerales('presupuestos/devuelveFacturasUsuarioAC');
	}
function crearObjetosParaForm(datos,nombre){var input=document.createElement('input');input.setAttribute('type','hidden');input.setAttribute('value',datos);input.setAttribute('class',"formEnviar");input.setAttribute('name',nombre);document.body.appendChild(input);}
function enviarFormGenerales(controlador){
  var direccion=<?php echo('"'.base_url().'";'); ?>;
  direccion=direccion+controlador;
  var formulario=document.createElement('form'); formulario.setAttribute('method','post'); formulario.action=direccion;formulario.setAttribute('name','miFormulario');formulario.setAttribute('id','miFormulario');
  objetosForm=document.getElementsByClassName('formEnviar');objetos="";cant=objetosForm.length;
  for(var i=0;i<cant;i++)
  {var objeto=document.createElement('input'); 
   objeto.setAttribute('value',objetosForm[i].value);
   objeto.setAttribute('name',objetosForm[i].name);
   objeto.setAttribute('type','hidden');
   formulario.appendChild(objeto); 
  }
  document.body.appendChild(formulario);
  formulario.submit();
}



function enviarAJAX(controlador,parametros){
  var req = new XMLHttpRequest();
  var direccionAJAX="<?= base_url();?>";
  var url=direccionAJAX+controlador+parametros;
 req.open('POST', url, true);
  req.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
   req.onreadystatechange = function (aEvt) 
  {
    if (req.readyState == 4) {if(req.status == 200)
    { 
         var respuesta=JSON.parse(this.responseText);
                                                         
      }     
   }
  };
 req.send();
}
function traeInfoAperturaContable2(){
	var datos="/?id="+document.getElementById("usuariosPresupuestosSelect").value+"&aperturaContable="+document.getElementById("selectAperturaContable").value+"&fechaFactura="+document.getElementById("selectFechaFactura").value+"&idPersonaDepartamento="+document.getElementById("selectDepartamentos").value;
  //var datos='/?idProcesoFuncion='+idProcesoFuncion+"&tipoMovimiento="+tipoMovimiento;
  enviarAJAX('presupuestos/devuelveFacturasUsuarioAC',datos);
    
   
  }

</script>
<?php 
function imprimirAperturaContable($datos){
  $select='<select class="form-control" id="selectAperturaContable" onchange="traeInfoAperturaContable()">';
    foreach ($datos as $value) {$select.='<option value="'.$value->idAperturaContable.'">'.$value->idAperturaContable.'('.$value->anioAC.')</option>';}
    $select.='</select>';
  return $select;
}
function imprimirDepartamentos($datos){
  
  $select='<select class="form-control" id="selectDepartamentos"><option value="0">Todos</option>';
    foreach ($datos as $value) {$select.='<option value="'.$value->idPersonaDepartamento.'">'.$value->personaDepartamento.'</option>';}
    $select.='</select>';
  return $select;
}
function imprimirGridAperturaContable($datos,$nomina=''){
	$tabla="";	
	$tabla='<table border="1" class="tablaReporte">';
    $tabla.='<thead><tr class="cabecera"><td></td><td>MES</td><td>Presupuesto total</td><td>Autorizado</td><td>Pagado</td><td >Saldo mes</td><td style="background-color:yellow;color:black">Gastos CCC</td><td style="background-color:green;color:black">Gastos CCO</td><td style="background-color:red;color:black">Gastos Institucionales</td></tr></thead>';
    $sumTotalP=0;$sumTotalPA=0;$sumTotalPP=0;$sumTotalSM=0;$sumTotalCCC=0;$sumTotalCCO=0;$sumTotalInversion=0;
    $numeroAnio=0;
    foreach ($datos as $key => $value) {
    	$numeroAnio++;
    	 $sumP=0;$sumPA=0;$sumPP=0;$sumSM=0;$tablaHija="";$sumCCC=0;$sumCCO=0;$sumInversion=0;
    	foreach ($value as  $valueMes) {
    		$tablaHija.='<tr class="'.$key.' ocultarObjeto"><td colspan="2">'.$valueMes['personaDepartamento'].'</td><td align="right">$'.number_format($valueMes['presupuesto'],2).'</td><td align="right">$'.number_format($valueMes['presupuestoAutorizado'],2).'</td><td align="right">$'.number_format($valueMes['presupuestoPagado'],2).'</td><td align="right">$'.number_format($valueMes['saldoMes'],2).'</td><td align="right" style="background-color:yellow;color:black">$'.number_format($valueMes['gastoCCC'],2).'</td><td align="right" style="background-color:green;color:black">$'.number_format($valueMes['gastoCCO'],2).'</td><td align="right" style="background-color:red;color:black">$'.number_format($valueMes['gastoInversion'],2).'</td></tr>';
    		$sumP=$sumP+$valueMes['presupuesto'];
    		$sumPA=$sumPA+$valueMes['presupuestoAutorizado'];
    		$sumPP=$sumPP+$valueMes['presupuestoPagado'];
    		$sumSM=$sumSM+$valueMes['saldoMes'];
        $sumCCC=$sumCCC+$valueMes['gastoCCC'];
        $sumCCO=$sumCCO+$valueMes['gastoCCO'];
        $sumInversion=$sumInversion+$valueMes['gastoInversion'];
    	}
    	$tabla.='<tr><td><button onclick="mostrarInfo(\''.$key.'\',this)">+</button></td><td class="tdPrimerCol">'.$key.'</td><td align="right">$'.number_format($sumP,2).'</td><td align="right">$'.number_format($sumPA,2).'</td><td align="right">$'.number_format($sumPP,2).'</td><td align="right">$'.number_format($sumSM,2).'</td><td align="right">$'.number_format($sumCCC,2).'</td><td align="right">$'.number_format($sumCCO,2).'</td><td align="right">$'.number_format($sumInversion,2).'</td></tr>';
    $tabla.='<tr class="'.$key.' cabeceraDetalle ocultarObjeto"><td colspan="2">Departamento</td><td>Presupuesto total</td><td>Autorizado</td><td>Pagado</td><td>Saldo mes</td><td>Gastos CCC</td><td>Gastos CCO</td><td>Gastos Institucionales</td></tr>';
    $tabla.=$tablaHija;
    $tabla.='<tr class="'.$key.' ocultarObjeto"><td colspan="2"><label class="label label-info">TOTAL POR DEPARTAMENTO</label></td><td align="right">$'.number_format($sumP,2).'</td><td align="right">$'.number_format($sumPA,2).'</td><td align="right">$'.number_format($sumPP,2).'</td><td align="right">$'.number_format($sumSM,2).'</td><td align="right">$'.number_format($sumCCC,2).'</td><td align="right">$'.number_format($sumCCO,2).'</td><td align="right">$'.number_format($sumInversion,2).'</td></tr>';


    $tabla.='<tr class="'.$key.' ocultarObjeto"><td colspan="2"><label style="width:100%;color: black;
    background-color: aqua">NOMINA</label></td><td align="right">$0</td><td align="right">$0</td><td align="right">$'.number_format($nomina[$numeroAnio][0]->totalconiva,2).'</td><td align="right">$0</td><td align="right">$0</td><td align="right">$0</td><td align="right">$0</td></tr>';


    $tabla.='<tr class="'.$key.' ocultarObjeto"><td colspan="2"><label style="width:100%;color: black;
    background-color: aqua">COSTO DE VENTA</label></td><td align="right">$0</td><td align="right">$0</td><td align="right">$'.number_format(0,2).'</td><td align="right">$0</td><td align="right">$0</td><td align="right">$0</td><td align="right">$0</td></tr>';

    $tabla.='<tr class="'.$key.' ocultarObjeto"><td colspan="2"><label class="label label-info">TOTAL </label></td><td align="right">$'.number_format($sumP,2).'</td><td align="right">$'.number_format($sumPA,2).'</td><td align="right">$'.number_format($sumPP+$nomina[$numeroAnio][0]->totalconiva,2).'</td><td align="right">$'.number_format($sumSM,2).'</td><td align="right">$'.number_format($sumCCC,2).'</td><td align="right">$'.number_format($sumCCO,2).'</td><td align="right">$'.number_format($sumInversion,2).'</td></tr>';



    $sumTotalP=$sumTotalP+$sumP;
    $sumTotalPA=$sumTotalPA+$sumPA;
    $sumTotalPP=$sumTotalPP+$sumPP;
    $sumTotalSM=$sumTotalSM+$sumSM;
        $sumTotalCCC=$sumTotalCCC+$sumCCC;
        $sumTotalCCO=$sumTotalCCO+$sumCCO;
        $sumTotalInversion=$sumTotalInversion+$sumInversion;    
    }
    $tabla.='<tr class="tdPrimerCol"><td colspan="2">Totales</td><td align="right">$'.number_format($sumTotalP,2).'</td><td align="right">$'.number_format($sumTotalPA,2).'</td><td align="right">$'.number_format($sumTotalPP,2).'</td><td align="right">$'.number_format($sumTotalSM,2).'</td><td align="right">$'.number_format($sumTotalCCC,2).'</td><td align="right">$'.number_format($sumTotalCCO,2).'</td><td align="right">$'.number_format($sumTotalInversion,2).'</td></tr>';
    $tabla.='</table>';
    return $tabla;

}



function imprimirGridCuentas($datos,$nominaCanal){
  $tabla="";  
  $tabla='<table border="1" class="tablaReporte">';
    $tabla.='<thead><tr class="cabecera"><td></td><td>MES</td><td>AUTORIZADO</td><td>PAGADO</td></tr></thead>';
    $sumAutorizadoAnio=0;
    $sumPagadoAnio=0;
    $mes=0;
    foreach ($datos as $key => $value) {
      $mes++;
      $sumMesAutorizado=0;
      $sumMesPagado=0;
  //$fp = fopen('resultadoJason.txt', 'a');fwrite($fp, print_r($value['pagado']->sumaFianzas, TRUE));fclose($fp);    
       /*$sumP=0;$sumPA=0;$sumPP=0;$sumSM=0;$tablaHija="";$sumCCC=0;$sumCCO=0;$sumInversion=0;
      foreach ($value as  $valueMes) {
        $tablaHija.='<tr class="'.$key.' ocultarObjeto"><td colspan="2">'.$valueMes['personaDepartamento'].'</td><td align="right">$'.number_format($valueMes['presupuesto'],2).'</td><td align="right">$'.number_format($valueMes['presupuestoAutorizado'],2).'</td><td align="right">$'.number_format($valueMes['presupuestoPagado'],2).'</td><td align="right">$'.number_format($valueMes['saldoMes'],2).'</td><td align="right" style="background-color:yellow;color:black">$'.number_format($valueMes['gastoCCC'],2).'</td><td align="right" style="background-color:green;color:black">$'.number_format($valueMes['gastoCCO'],2).'</td><td align="right" style="background-color:red;color:black">$'.number_format($valueMes['gastoInversion'],2).'</td></tr>';
        $sumP=$sumP+$valueMes['presupuesto'];
        $sumPA=$sumPA+$valueMes['presupuestoAutorizado'];
        $sumPP=$sumPP+$valueMes['presupuestoPagado'];
        $sumSM=$sumSM+$valueMes['saldoMes'];
        $sumCCC=$sumCCC+$valueMes['gastoCCC'];
        $sumCCO=$sumCCO+$valueMes['gastoCCO'];
        $sumInversion=$sumInversion+$valueMes['gastoInversion'];
      }*/
        $sumMesAutorizado=(double)$sumMesAutorizado+((double)$value['autorizado']->sumaFianzas+(double)$value['autorizado']->sumaInstitucional+(double)$value['autorizado']->sumaCorporativo);
     $sumMesPagado=$sumMesPagado+($value['pagado']->sumaFianzas+$value['pagado']->sumaInstitucional+$value['pagado']->sumaCorporativo+$nominaCanal[$mes]['montoFianzas']+$nominaCanal[$mes]['montoInstitucional']+$nominaCanal[$mes]['montoCorporativo']);
        $sumAutorizadoAnio=$sumAutorizadoAnio+$sumMesAutorizado;
        $sumPagadoAnio=$sumPagadoAnio+$sumMesPagado;
      $tabla.='<tr><td><button onclick="mostrarInfo(\''.$key.'Cuentas\',this)">+</button></td><td class="tdPrimerCol">'.$key.'</td><td align="right">$'.number_format($sumMesAutorizado,2).'</td><td align="right">$'.number_format($sumMesPagado,2).'</td></tr>';
            $tabla.='<tr class="'.$key.'Cuentas ocultarObjeto cabeceraDetalle"><td></td><td>CANAL</td><td>AUTORIZADO</td><td>PAGADO</td><tr>';
      $tabla.='<tr class="'.$key.'Cuentas ocultarObjeto"><td></td><td>Fianzas</td><td align="right">$'.number_format($value['autorizado']->sumaFianzas,2).'</td><td align="right">$'.number_format($value['pagado']->sumaFianzas,2).'</td><tr>';
      
      $tabla.='<tr class="'.$key.'Cuentas ocultarObjeto"><td></td><td>Nomina Fianzas</td><td align="right">$0</td><td align="right">$'.number_format($nominaCanal[$mes]['montoFianzas'],2).'</td><tr>';

      $tabla.='<tr class="'.$key.'Cuentas ocultarObjeto"><td></td><td>Seguros</td><td align="right">$'.number_format($value['autorizado']->sumaInstitucional,2).'</td><td align="right">$'.number_format($value['pagado']->sumaInstitucional,2).'</td><tr>';
            $tabla.='<tr class="'.$key.'Cuentas ocultarObjeto"><td></td><td>Nomina Seguros</td><td align="right">$0</td><td align="right">$'.number_format($nominaCanal[$mes]['montoInstitucional'],2).'</td><tr>';
      
      $tabla.='<tr class="'.$key.'Cuentas ocultarObjeto"><td></td><td>Coorporativo</td><td align="right">$'.number_format($value['autorizado']->sumaCorporativo,2).'</td><td align="right">$'.number_format($value['pagado']->sumaCorporativo,2).'</td><tr>';
   
         $tabla.='<tr class="'.$key.'Cuentas ocultarObjeto"><td></td><td>Nomina Coorporativo</td><td align="right">$0</td><td align="right">$'.number_format($nominaCanal[$mes]['montoCorporativo'],2).'</td><tr>';
   
      $tabla.='<tr class="'.$key.'Cuentas ocultarObjeto"><td></td><td>TOTAL DEL MES</td><td align="right">$'.number_format($sumMesAutorizado,2).'</td><td align="right">$'.number_format($sumMesPagado,2).'</td><tr>';


    /*$tabla.='<tr class="'.$key.' cabeceraDetalle ocultarObjeto"><td colspan="2">Departamento</td><td>Presupuesto total</td><td>Autorizado</td><td>Pagado</td><td>Saldo mes</td><td>Gastos CCC</td><td>Gastos CCO</td><td>Gastos Institucionales</td></tr>';*/
    /*$tabla.=$tablaHija;
    $sumTotalP=$sumTotalP+$sumP;
    $sumTotalPA=$sumTotalPA+$sumPA;
    $sumTotalPP=$sumTotalPP+$sumPP;
    $sumTotalSM=$sumTotalSM+$sumSM;
        $sumTotalCCC=$sumTotalCCC+$sumCCC;
        $sumTotalCCO=$sumTotalCCO+$sumCCO;
        $sumTotalInversion=$sumTotalInversion+$sumInversion;    */
    }
    /*$tabla.='<tr class="tdPrimerCol"><td colspan="2">Totales</td><td align="right">$'.number_format($sumTotalP,2).'</td><td align="right">$'.number_format($sumTotalPA,2).'</td><td align="right">$'.number_format($sumTotalPP,2).'</td><td align="right">$'.number_format($sumTotalSM,2).'</td><td align="right">$'.number_format($sumTotalCCC,2).'</td><td align="right">$'.number_format($sumTotalCCO,2).'</td><td align="right">$'.number_format($sumTotalInversion,2).'</td></tr>';*/
  $tabla.='<tr class="tdPrimerCol"><td></td><td>TOTAL DEL ANIO</td><td align="right">$'.number_format($sumAutorizadoAnio,2).'</td><td align="right">$'.number_format($sumPagadoAnio,2).'</td><tr>';
    $tabla.='</table>';
    return $tabla;

}


?>

<style type="text/css">
	.verObjeto{display: table}
	.ocultarObjeto{display: none}
</style>
<script type="text/javascript">
<?php 
$presupuestoAutorizado="";$presupuesto="";
$sumP="";$sumPA="";
 foreach ($reporte as $key => $value) {
 	$presupuesto=0;$presupuestoAutorizado=0;
   	foreach ($value as  $valueMes) {
    		$presupuesto=(double)$presupuesto+$valueMes['presupuesto'];
        $presupuesto=(string)$presupuesto.'-';
    		$presupuestoAutorizado=(double)$presupuestoAutorizado+$valueMes['presupuestoAutorizado'];
        $presupuestoAutorizado=(string)$presupuestoAutorizado.'-';
    	}
    	$sumP.=$presupuesto;
    	$sumPA.=$presupuestoAutorizado;
 }
 echo('limpiaCanvas();cargarGrafica("'.$sumP.'","'.$sumPA.'");');
?>
document.getElementById('selectAperturaContable').value=<?=$idAperturaContable;?>
</script>
<style type="text/css">
	.tablaReporte{padding: 2px;border: 1px solid #4CAF50; margin-left: 50px}
	.tdPrimerCol{background-color: rgba(220,230,241,1);color: rgba(0,0,0,1);}
	.cabeceraDetalle{background-color: rgba(145,209,152,1);color: rgba(0,0,0,1);}
	.tdSegundaCol{background-color: rgba(198,239,206,1);color: rgba(0,97,0,1);}
  
</style>