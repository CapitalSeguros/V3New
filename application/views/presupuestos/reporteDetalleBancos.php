<?php $this->load->view('headers/header'); ?>
<?php $this->load->view('headers/menu');?>
<? $saldoInicialEstilo='style="color:white;background-color: #1CB0A9"'; 
   $ingresosRamosEstilos='style="color:black;background-color: #FFF2CC"';
   $datosFecha=['mes'=>'12','anioAnterior'=>$anioAnterior,'anioActual'=>$anioActual];
   $ramoAutos='AUTOS INDIVIDUALES';
   $ramoVida='VIDA';
   $ramoFlotillas='FLOTILLAS';
   $ramoLineasPersonales='LINEAS PERSONALES';
   $ramoDaniosIndividual='DAÑOS INDIVIDUAL';
   $bonoAnterior='BONOS AÑOS ANTERIOR';
   $bonoActual='BONOS AÑOS ACTUAL';
   $subTotal='SUBTOTAL';

?>
<div id="contenedorTablaDiv">
	<table  class="tableDetalleBancos" border='1' >
		<thead style="z-index: 5">
			<tr style="z-index: 5"><th style="z-index: 6">GAP SEGUROS Y FIANZAS</th><?=imprimirCabecera($datosFecha,$meses)?></tr>
			<tr style="z-index: 5"><?=imprimirSegundaCabecera($datosFecha,$meses)?></tr>
		</thead>
		<tbody style="z-index: 2">
			<tr>
				<td  style="z-index: 4"><br><label class="tituloCabecera">SALDO INICIAL</label></td>
				<td colspan="20"  style="z-index: 1"></td>
			</tr>
			<tr class="trColumnaEstatica">
				<td class="saldoInicial" <?=$saldoInicialEstilo?>  style="z-index: 4">BANCOMER</td>
				<td ></td>
				<td ></td>
				<td ></td>
				<td ></td>
				<td ></td>
				<td ></td>
				<td ></td>
				<td ></td>
				<td ></td>
				<td ></td>
			    <td ></td>
				<td ></td>
				<td ></td>
				<td ></td>
				<td "></td>
				<td ></td>
				<td ></td>
				<td ></td>
				<td ></td>
				<td ></td>

			</tr>
			<tr class="trColumnaEstatica">
				<td class="saldoInicial" <?=$saldoInicialEstilo?> >B X +</td>
				<td></td>
				<td ></td>
				<td ></td>
				<td ></td>
				<td "></td>
				<td ></td>
				<td ></td>
				<td ></td>
				<td ></td>
				<td ></td>
								<td ></td>
				<td ></td>
				<td ></td>
				<td ></td>
				<td "></td>
				<td ></td>
				<td ></td>
				<td ></td>
				<td ></td>
				<td ></td>

			</tr>		
			<tr class="trColumnaEstatica"><td class="saldoInicial" <?=$saldoInicialEstilo?>></td><td colspan="27"></td></tr>
			<tr class="trColumnaEstatica">
				<td ><label class="tituloCabecera">SALDO DISPONIBLE</label></td>
				<td ></td>
				<td ></td>
				<td ></td>
				<td ></td>
				<td "></td>
				<td ></td>
				<td ></td>
				<td ></td>
				<td ></td>
				<td ></td>
				<td ></td>
				<td ></td>
				<td ></td>
				<td ></td>
				<td "></td>
				<td ></td>
				<td ></td>
				<td ></td>
				<td ></td>
				<td ></td>

			</tr>	
						<tr><td ></td><td colspan="20"></td></tr>
			  <tr><td ><label class="tituloCabecera">INGRESOS POR CANALES</label></td><td colspan="20"></td></tr>
			  <tr><td ></td><td colspan="20"></td></tr>
		
          <?=imprimirMetasComerciales($meses,$canales,$grupoCer,$costoVenta,$gastosOperacion,$gastosVariables,$gastosFinancieros,$gastosImpuestos);?>			  


		</tbody>
	</table>
</div>	


<style type="text/css">

    .tableDetalleBancos>thead tr:first-child th:nth-child(2n){background: -webkit-linear-gradient(top, white, blue);color: white}
	.tableDetalleBancos{border: solid;border-color: white;font-size: 11px}
	.tableDetalleBancos th{min-width: 80px;min-height: 10px border-color: white;height:  }
	.tableDetalleBancos tr{min-width: 80px;min-height: 10px}
	.tableDetalleBancos>thead>tr:first-child{color:blue;position: sticky;top: 0;background-color: white}
	.tableDetalleBancos>thead>tr:nth-child(2)>th:nth-child(4n+2){background-color: #833C0C;color: white}
.tableDetalleBancos>thead>tr:nth-child(2)>th:nth-child(4n+3){background-color: #222B35;color: white}
.tableDetalleBancos>thead>tr:nth-child(2)>th:nth-child(4n+4){background-color: #222B35;color: white}
	.tableDetalleBancos>thead>tr:nth-child(2){color:blue;position: sticky;top: 15px;background-color: white}
	.tableDetalleBancos>tbody>tr> td{color: black;position: sticky;left: 0;/*background-color: white;*/}
	.tableDetalleBancos>thead>tr> th:first-child{color: black;position: sticky;left: 0;background-color: white;z-index: ;min-width: 250px}
	.tableDetalleBancos>tbody>tr> td:first-child{color: black;position: sticky;left: 0;background-color: white;z-index: ;min-width: 250px}
	#contenedorTablaDiv{max-width: 100%;overflow: scroll;height: 350px}
	.saldoInicial {color: pink;background-color: red}
	.tituloCabecera{font-weight: 700}
	button{z-index: 20}
	.trColumnaEstatica td:nth-child(1){z-index: 4;border-left: blue}
	.trColumnaEstatica td:nth-child(1):hover{background-color: red;color:blue;}
.ocultarObjeto{display: none}
.btnVisibilidadHijos{background-color: #5cf15c;color: black;cursor: pointer;border: none;margin-left: 2px;margin-right: 5px;min-width: 21px}
.btnVisibilidadHijos:hover{background-color: #1ef71e;color: white}
.trEscogerColumna:hover  td{background-color: #b8fbbaa8}
.totalesCanalTD{background-color: #e5e50e}
.trColumnaEstatica:hover td {background-color: red;color:blue;}
</style>


<?
function imprimirCabecera($datosFecha,$mesesDelAnio)
{
	$th='';

				
   $th='<th colspan="3">ENERO</th><th></th>';
   for($i=2;$i<=$datosFecha['mes'];$i++)
   {
    $th.='<th colspan="3">'.$mesesDelAnio[$i].'</th><th></th>';
    $th.='<th colspan="3">ACUMULADO DE '.$mesesDelAnio[$i].'</th><th></th>';
   }
   return $th;
}

function imprimirSegundaCabecera($datosFecha,$mesesDelAnio)
{

				
	$th='<th></th><th>Real '.$datosFecha['anioAnterior'].'</th>';
	$th.='<th>Presupuesto '.$datosFecha['anioActual'].'</th>';
	$th.='<th>Real '.$datosFecha['anioActual'].'</th>';
				   
   for($i=2;$i<=$datosFecha['mes'];$i++)
   {
    $th.='<th></th><th>Real '.$datosFecha['anioAnterior'].'</th>';
    $th.='<th>Presupuesto '.$datosFecha['anioActual'].'</th>';
    $th.='<th>Real '.$datosFecha['anioActual'].'</th>';
    $th.='<th></th><th>Real '.$datosFecha['anioAnterior'].'</th>';
    $th.='<th>Presupuesto '.$datosFecha['anioActual'].'</th>';
    $th.='<th>Real '.$datosFecha['anioActual'].'</th>';

   }
   return $th;

}
function imprimirIngresosPorCanalRamo($nombre)
{
	$tr='';
  	$tr='<tr >
				<td style="color:black;background-color: #FFF2CC">'.$nombre.'</td>
				<td ></td>
				<td ></td>
				<td ></td>
				<td ></td>
				<td ></td>
				<td ></td>
				<td ></td>
				<td ></td>
				<td ></td>
				<td ></td>
				<td ></td>
				<td ></td>
				<td ></td>
				<td ></td>
				<td ></td>
				<td ></td>
				<td ></td>
				<td ></td>
				<td ></td>
				<td ></td>

			</tr>	';
		return $tr;	 

}
function imprimirMetasComerciales($meses,$canales,$grupoCer,$costoVenta,$gastosOperacion,$gastosVariables,$gastosFinancieros,$gastosImpuestos)
{
   //$anioActual,$anioAnterior
   //
   
   $tr='';
   $arraySumasTotales=array();
   $tdsDespositosEntransito='';
      foreach ($canales as $keyCanal => $valueCanal) 
      {

       $tr.='<tr class="trColumnaEstatica"><td style="background-color:#A1ABDF"><button onclick="visibilidadHijos(this)" data-identificahijos="'.$valueCanal->canal.'SubRamos" class="btnVisibilidadHijos">-</button><label class="tituloCabecera">'.$keyCanal.'('.$valueCanal->canal.')</label></td>';
       $i=0;
       $acumuladoPresupuesto=0;
       $acumuladoComision=0;
       $acumuladoComisionAnterior=0;
       
       //==============================  CABECERAS DE LOS CANALES ======================================// 
       foreach ($meses as $key => $value) 
       {   	
   	    $i++;
   	    //$arraySumasTotales[$key]->anioActual[$valueCanal->anioActualMonto]->montoTotal+=$valueCanal->anioActualMonto;
   	    (double)$acumuladoPresupuesto+=(double)$valueCanal->anioActualMonto[$key]->monto_al_mes;
   	    (double)$acumuladoComision+=(double)$valueCanal->anioActualMonto[$key]->comision_actual;
   	    (double)$acumuladoComisionAnterior+=(double)$valueCanal->anioAnteriorMonto[$key]->comision_actual;
        $tr.='<td align="right" style="background-color:#A1ABDF" >$'.number_format($valueCanal->anioAnteriorMonto[$key]->comision_actual,2).'</td>';   	
   	    $tr.='<td align="right" style="background-color:#A1ABDF">$'.number_format($valueCanal->anioActualMonto[$key]->monto_al_mes,2).'</td>'; 	
   	    $tr.='<td align="right" style="background-color:#A1ABDF">$'.number_format($valueCanal->anioActualMonto[$key]->comision_actual,2).'</td>';
   	    $tr.='<td style="background-color:#A1ABDF"></td>';
   	    if($i>=2)
   	    {
         $tr.='<td align="right" style="background-color:#A1ABDF">$'.number_format($acumuladoComisionAnterior,2).'</td>';   	
   	     $tr.='<td align="right" style="background-color:#A1ABDF">$'.number_format($acumuladoPresupuesto,2).'</td>'; 	
   	     $tr.='<td align="right" style="background-color:#A1ABDF">$'.number_format($acumuladoComision,2).'</td>';
   	     $tr.='<td style="background-color:#A1ABDF"></td>';
   	   }
        
       }
   $tr.='</tr>';
   //=============================================================================================


    //===================================  SUBRAMOS DE LOS CANALES ====================================
   foreach ($valueCanal->subRamosActualComision as $keySR => $valueSR) 
   {
   	 $tr.='<tr name="'.$valueCanal->canal.'SubRamos" class="trColumnaEstatica trEscogerColumna "><td style="background-color:#FFFF99">'.$keySR.'</td>';
   	  $i=0;
   	   $sumActual=0;
   	   $sumAnterior=0;
   	    foreach ($meses as $key => $value) 
       {  

   	    if(!isset($arraySumasTotales[$keyCanal][$key]))
   	    	{
   	    		$arraySumasTotales[$keyCanal][$key]=array();
   	    		$arraySumasTotales[$keyCanal][$key]['anioAnterior']=0;
   	    		$arraySumasTotales[$keyCanal][$key]['anioActual']=0;
   	    		

                   //new \stdclass;
   	    	}
   	    		$arraySumasTotales[$keyCanal][$key]['anioAnterior']+=$valueCanal->subRamosAnteriorComision[$keySR][$key];
   	    		$arraySumasTotales[$keyCanal][$key]['anioActual']+=$valueCanal->subRamosActualComision[$keySR][$key];


         $i++;
         $sumActual=$sumActual+$valueCanal->subRamosActualComision[$keySR][$key];
         $sumAnterior=$sumAnterior+$valueCanal->subRamosAnteriorComision[$keySR][$key] ;
   	     $tr.='<td align="right">$'.number_format($valueCanal->subRamosAnteriorComision[$keySR ][$key],2).'</td>';
   	     $tr.='<td></td>';
   	     $tr.='<td align="right">$'.number_format($valueCanal->subRamosActualComision[$keySR ][$key],2).'</td>';
   	     $tr.='<td></td>';
          if($i>=2)
   	      {
           $tr.='<td align="right">$'.number_format($sumAnterior,2).'</td>';   	
   	       $tr.='<td align="right"></td>'; 	
   	       $tr.='<td align="right">$'.number_format($sumActual,2).'</td>';
   	       $tr.='<td></td>';
   	      }
   	   }
   	   $tr.='</tr>';
    }

//====================================================================================

//============================= TOTALES POR CADA CANAL ===================================

  $sumAcumuladoActual=0;
  $sumAcumuladoAnterior=0;
      $tdSum='';
$i=0;

   foreach ($arraySumasTotales[$keyCanal] as $keyST => $valueST) 
   {
      $i++;

      $sumAcumuladoActual+=$valueST['anioActual'];
      $sumAcumuladoAnterior+=$valueST['anioAnterior'];
      $tdSum.='<td align="right" class="totalesCanalTD">$'.number_format($valueST['anioAnterior'],2).'</td><td class="totalesCanalTD"></td><td align="right" class="totalesCanalTD">$'.number_format($valueST['anioActual'],2).'</td><td></td>';
      if($i>1){      $tdSum.='<td align="right" class="totalesCanalTD">$'.number_format($sumAcumuladoAnterior,2).'</td><td></td><td align="right">$'.number_format($sumAcumuladoActual,2).'</td><td class="totalesCanalTD"></td>';}
   	
   }


   //$tr.='<tr name="'.$valueCanal->canal.'SubRamos" class="trColumnaEstatica"><td style="background-color:#e5e56d">TOTALES DE '.$keyCanal.':</td>'.$tdSum.'</tr>'; 
   $tr.='<tr  class="trColumnaEstatica"><td style="background-color:#e5e56d">TOTALES DE '.$keyCanal.':</td>'.$tdSum.'</tr>'; 
   
      $tr.='<tr style="height:10px"><td style="background-color:#fffff" colspan="30"></tr>'; 
//========================================================================================================  
}


    
//================= DEPOSITOS EN TRANSITO=============================//
$i=0;
   	    foreach ($meses as $key => $value) 
       {  
         $i++;
   	     
   	     $tdsDespositosEntransito.='<td align="right">$0</td>';
   	     $tdsDespositosEntransito.='<td></td>';
   	     $tdsDespositosEntransito.='<td align="right">$0</td>';
   	     $tdsDespositosEntransito.='<td></td>';
          if($i>=2)
   	      {
   	       $tdsDespositosEntransito.='<td align="right">$0</td>';
   	       $tdsDespositosEntransito.='<td></td>';
   	       $tdsDespositosEntransito.='<td align="right">$0</td>';
   	       $tdsDespositosEntransito.='<td></td>';
   	      }
   	   }

  $trDepositoEnTransito='<tr class="trColumnaEstatica"><td style="background-color:#A1ABDF">DEPOSITOS EN TRANSITO</td>'.$tdsDespositosEntransito.'<tr>';
  $tr.=$trDepositoEnTransito;

  $tr.='<tr style="height:10px"><td style="background-color:#fffff" colspan="30"></tr>'; 
//=====================================================================//



//===================================  TOTALES DE LOS CANALES==============================
    $sumAcumuladoActual=0;
  $sumAcumuladoAnterior=0;
      $tdSum='';
  $tr.='<tr class="trColumnaEstatica"><td style="background-color:#A1ABDF">TOTAL INGRESOS CANALES</td>';
	for ($j=1; $j <=12 ; $j++) 
	{ 
       $sumAnioActual=0;
       $sumAnioAnterior=0;
       foreach ($arraySumasTotales as $keyST => $valueST) 
      {
		
        $sumAcumuladoActual+=$valueST[$j]['anioActual'];
        $sumAcumuladoAnterior+=$valueST[$j]['anioAnterior'];
        $sumAnioActual+=$valueST[$j]['anioActual'];
        $sumAnioAnterior+=$valueST[$j]['anioAnterior'];         			
	}

	$tdSum.='<td align="right" class="totalesCanalTD">$'.number_format($sumAnioAnterior,2).'</td><td class="totalesCanalTD"></td><td align="right" class="totalesCanalTD">$'.number_format($sumAnioActual,2).'</td><td></td>';
      if($j>1){      $tdSum.='<td align="right" class="totalesCanalTD">$'.number_format($sumAcumuladoAnterior,2).'</td><td></td><td align="right">$'.number_format($sumAcumuladoActual,2).'</td><td class="totalesCanalTD"></td>';}
	
}
$tr.=$tdSum.'</tr>';
  $tr.='<tr style="height:10px"><td style="background-color:#fffff" colspan="30"></tr>'; 
//=====================================================================//



//==================  INGRESOS INSTITUCIONALES COORPORATIVAS ================-------//
       
$tr.='<tr class="trColumnaEstatica"><td style="background-color:#A1ABDF" colspan="25"><button onclick="visibilidadHijos(this)" data-identificahijos="ingresosCoorporativosSubRamos" class="btnVisibilidadHijos">-</button><label class="tituloCabecera">INGRESOS INST COORPORATIVAS</label></td></tr>';

 foreach ($grupoCer as $key => $value) 
 {
 	$i=0;
 	  $sumAcumuladoActual=0;
      $sumAcumuladoAnterior=0;
 	$tr.='<tr name="ingresosCoorporativosSubRamos" class="trColumnaEstatica"><td style="background-color:#FFFF99">'.$key.'</td>';
 	   	foreach ($meses as $keyMeses => $valueMeses) 
       {


   	    if(!isset($arraySumasTotales['ingresosInstitucionalesCoorp'][$keyMeses]))
   	    	{
   	    		$arraySumasTotales['ingresosInstitucionalesCoorp'][$keyMeses]=array();
   	    		$arraySumasTotales['ingresosInstitucionalesCoorp'][$keyMeses]['anioAnterior']=0;
   	    		$arraySumasTotales['ingresosInstitucionalesCoorp'][$keyMeses]['anioActual']=0;   	    		                   
   	    	}
   	    		$arraySumasTotales['ingresosInstitucionalesCoorp'][$keyMeses]['anioAnterior']+=$value->anioAnterior[$keyMeses]->monto;
   	    		$arraySumasTotales['ingresosInstitucionalesCoorp'][$keyMeses]['anioActual']+=$value->anioActual[$keyMeses]->monto;

       	$i++;
       	  $sumAcumuladoActual+=$value->anioActual[$keyMeses]->monto;
         $sumAcumuladoAnterior+=$value->anioAnterior[$keyMeses]->monto;
          $tr.='<td align="right">$'.number_format($value->anioAnterior[$keyMeses]->monto,2).'</td>';
   	     $tr.='<td></td>';
   	     $tr.='<td align="right">$'.number_format($value->anioActual[$keyMeses]->monto,2).'</td>';
   	     $tr.='<td></td>';
          if($i>=2)
   	      {
   	       $tr.='<td align="right">$'.$sumAcumuladoAnterior.'</td>';
   	       $tr.='<td></td>';
   	       $tr.='<td align="right">$'.$sumAcumuladoActual.'</td>';
   	       $tr.='<td></td>';
   	      }  
       }
      $tr.='</tr>';
 }
        $tr.='<tr name="ingresosCoorporativosSubRamosVisible" class="trColumnaEstatica"><td style="background-color:#e5e56d">TOTALES DE INGRESOS INSTITUCIONAL:</td>';
        $tr.=devolverMontosFinales($arraySumasTotales['ingresosInstitucionalesCoorp'] );
        $tr.='</tr>';

      $tr.='<tr style="height:10px"><td style="background-color:#fffff" colspan="30"></tr>';

//==========================================================================
//====================COSTO DE VENTAS======================================
//$fp = fopen('resultadoJason.txt', 'w');fwrite($fp, print_r($costoVenta, TRUE));fclose($fp);
$tr.='<tr class="trColumnaEstatica"><td style="background-color:#A1ABDF" colspan="25"><button onclick="visibilidadHijos(this)" data-identificahijos="costoVentaSubRamos" class="btnVisibilidadHijos">-</button><label class="tituloCabecera">COSTOS DE VENTA</label></td></tr>';

 foreach ($costoVenta as $key => $value) 
 {
 	$i=0;
 	$tr.='<tr name="costoVentaSubRamos" class="trColumnaEstatica"><td style="background-color:#FFFF99">'.$key.'</td>';
 	   	foreach ($meses as $keyMeses => $valueMeses) 
       {

       	$i++;

       	   	    if(!isset($arraySumasTotales['costoDeVenta'][$keyMeses]))
   	    	{
   	    		$arraySumasTotales['costoDeVenta'][$keyMeses]=array();
   	    		$arraySumasTotales['costoDeVenta'][$keyMeses]['anioAnterior']=0;
   	    		$arraySumasTotales['costoDeVenta'][$keyMeses]['anioActual']=0;   	    		                   
   	    	}
   	    		$arraySumasTotales['costoDeVenta'][$keyMeses]['anioAnterior']+=$value->anioAnterior[$keyMeses]->monto;
   	    		$arraySumasTotales['costoDeVenta'][$keyMeses]['anioActual']+=$value->anioActual[$keyMeses]->monto;
          $tr.='<td align="right">$'.number_format($value->anioAnterior[$keyMeses]->monto,2).'</td>';
   	     $tr.='<td></td>';
   	     $tr.='<td align="right">$'.number_format($value->anioActual[$keyMeses]->monto,2).'</td>';
   	     $tr.='<td></td>';
          if($i>=2)
   	      {
   	       $tr.='<td align="right">$</td>';
   	       $tr.='<td></td>';
   	       $tr.='<td align="right">$</td>';

   	       $tr.='<td></td>';
   	      }  
       }
      $tr.='</tr>';
 }

    $sumAcumuladoActual=0;
  $sumAcumuladoAnterior=0;
      $tdSum='';

        $tr.='<tr name="costrVentaSubRamos" class="trColumnaEstatica"><td style="background-color:#e5e56d">TOTALES DE COSTO DE VENTA:</td>';
        $tr.=devolverMontosFinales($arraySumasTotales['costoDeVenta'] );
    $tr.='</tr>';


  $tr.='<tr style="height:10px"><td style="background-color:#fffff" colspan="30"></tr>'; 


//=========================================================================
//$fp = fopen('resultadoJason.txt', 'a');fwrite($fp, print_r($arraySumasTotales,TRUE));fclose($fp);
//======================= CONTRIBUCION MARGINAL============================
$tr.='<tr class="trColumnaEstatica"><td style="background-color:#A1ABDF" colspan="25"><button onclick="visibilidadHijos(this)" data-identificahijos="contribucionMarginalSubRamos" class="btnVisibilidadHijos">-</button><label class="tituloCabecera">CONTRIBUCION MARGINAL</label></td></tr>';
   $tdConMargCanales='<tr class="trColumnaEstatica" name="contribucionMarginalSubRamos"><td style="background-color:#FFFF99">CANALES</td>';
   $tdConMargCoor='<tr class="trColumnaEstatica" name="contribucionMarginalSubRamos"><td style="background-color:#FFFF99">COORPORATIVAS</td>';
   $sumAcumuladoCanalAnterior=0;
   $sumAcumuladoCanalActual=0;
   $sumAcumuladoCoorpAnterior=0;
   $sumAcumuladoCoorpActual=0;
   $sumTotalAcumuladoAnterior=0;
   $sumTotalAcumuladoActual=0;
   $tdTotal='';

   for ($i=1; $i <=12 ; $i++) 
   {
     $sumCanalAnterior=0;
     $sumCoorpAnterior=0;
     $sumCanalActual=0;
     $sumCoorpActual=0; 
     $sumTotalAnterior=0;
     $sumTotalActual=0;

    
      //  CANAL
   	 $sumCanalAnterior=$arraySumasTotales['COORDINADORINSTITUCIONAL@AGENTECAPITAL.COM'][$i]['anioAnterior']+$arraySumasTotales['COORDINADOR@CAPCAPITAL.COM.MX'][$i]['anioAnterior']
   	 +$arraySumasTotales['COORDINADORCOMERCIAL@FIANZASCAPITAL.COM'][$i]['anioAnterior']+$arraySumasTotales['COORDINADORCOMERCIAL@CAPCAPITAL.COM.MX'][$i]['anioAnterior']-$costoVenta['Agentes']->anioAnterior[$i]->monto-$costoVenta['Agentes Bono Anual']->anioAnterior[$i]->monto;


   	  $sumCanalActual=$arraySumasTotales['COORDINADORINSTITUCIONAL@AGENTECAPITAL.COM'][$i]['anioActual']+$arraySumasTotales['COORDINADOR@CAPCAPITAL.COM.MX'][$i]['anioActual']
   	 +$arraySumasTotales['COORDINADORCOMERCIAL@FIANZASCAPITAL.COM'][$i]['anioActual']+$arraySumasTotales['COORDINADORCOMERCIAL@CAPCAPITAL.COM.MX'][$i]['anioActual']-$costoVenta['Agentes']->anioActual[$i]->monto-$costoVenta['Agentes']->anioActual[$i]->monto-$costoVenta['Agentes Bono Anual']->anioActual[$i]->monto;;
$tdConMargCanales.='<td align="right">$'.number_format($sumCanalAnterior,2).'</td><td></td><td align="right">$'.number_format($sumCanalActual,2).'</td><td></td>';

       // COORPORATIVO
   	   $sumCoorpAnterior=$arraySumasTotales['ingresosInstitucionalesCoorp'][$i]['anioAnterior'];
       $sumCoorpActual=$arraySumasTotales['ingresosInstitucionalesCoorp'][$i]['anioActual'];    	 
   	 $tdConMargCoor.='<td align="right">$'.number_format($sumCoorpAnterior,2).'</td><td></td><td align="right">$'.number_format($sumCoorpActual,2).'</td><td></td>';


     //PARA EL TOTAL
   $sumTotalAnterior=$sumCanalAnterior+$sumCoorpAnterior;
   $sumTotalActual=$sumCanalActual+$sumCoorpActual;
          $tdTotal.='<td align="right">$'.number_format($sumTotalAnterior,2).'</td><td></td><td align="right">$'.number_format($sumTotalActual,2).'</td><td></td>';


        $sumAcumuladoCanalAnterior+=$sumCanalAnterior;
        $sumAcumuladoCanalActual+=$sumCanalActual;
        $sumAcumuladoCoorpAnterior+=$sumCoorpAnterior;
        $sumAcumuladoCoorpActual+=$sumCoorpActual;            
         $sumTotalAcumuladoAnterior+=$sumTotalAnterior;
         $sumTotalAcumuladoActual+=$sumTotalActual;


   	    	 if($i>1)
   	 	{
   	 		$tdConMargCanales.='<td align="right">$'.number_format($sumAcumuladoCanalAnterior,2).'</td><td></td><td align="right">$'.number_format($sumAcumuladoCanalActual,2).'</td><td></td>';
   	 		$tdConMargCoor.='<td align="right">$'.number_format($sumAcumuladoCoorpAnterior,2).'</td><td></td><td align="right">$'.number_format($sumAcumuladoCoorpActual,2).'</td><td></td>';
   	       $tdTotal.='<td align="right">$'.number_format($sumTotalAcumuladoAnterior,2).'</td><td></td><td align="right">$'.number_format($sumTotalAcumuladoActual,2).'</td><td></td>';

   	 	}
   	 
   }
   $tdConMargCanales.='</tr>';
   $tdConMargCoor.='</tr>';

$tr.=$tdConMargCanales;
$tr.=$tdConMargCoor;
  $tr.='<tr  class="trColumnaEstatica"><td style="background-color:#e5e56d">TOTALES DE CONTRIBUCION MARGINAL:</td>'.$tdTotal.'</tr>';    
   $tr.='<tr style="height:10px"><td style="background-color:#fffff" colspan="30"></tr>';
//=========================================================================
//======================= GASTOS DE OPERACION ============================
$tr.='<tr class="trColumnaEstatica"><td style="background-color:#A1ABDF" colspan="25"><button onclick="visibilidadHijos(this)" data-identificahijos="gastosOperacionSubRamos" class="btnVisibilidadHijos">-</button><label class="tituloCabecera">GASTOS DE OPERACION</label></td></tr>';

         
//$fp = fopen('resultadoJason.txt', 'a');fwrite($fp, print_r($gastosOperacion,true));fclose($fp);         
foreach ($gastosOperacion as $key => $value) 
 {
 	$i=0;
 	$option='';
 	$sumAnioAnteriorMonto=0;
 	$sumPresupuestoReal=0;
 	$sumAnioActualMonto=0;

 	 	    $optionArray= explode(',', $value->cuentasContableName);
 	 	    
 	    foreach ($optionArray as  $valueOA) 
 	    {
 	    	$option.='<option>'.$valueOA.'</option>';
 	    }
 	$tr.='<tr name="gastosOperacionSubRamos" class="trColumnaEstatica"><td style="background-color:#FFFF99;display:flex"><label style="flex:25">'.$key.'</label><select style="flex:1;width:3px">'.$option.'</select></td>';

 	   	foreach ($meses as $keyMeses => $valueMeses) 
       {

       	$i++;

       	   	    if(!isset($arraySumasTotales['gastosOperacion'][$keyMeses]))
   	    	{
   	    		$arraySumasTotales['gastosOperacion'][$keyMeses]=array();
   	    		$arraySumasTotales['gastosOperacion'][$keyMeses]['anioAnterior']=0;
   	    		$arraySumasTotales['gastosOperacion'][$keyMeses]['anioActual']=0;   	    		                   
   	    		$arraySumasTotales['gastosOperacion'][$keyMeses]['presupuesto']=0;
   	    	}
   	    		$arraySumasTotales['gastosOperacion'][$keyMeses]['anioAnterior']+=$value->anioAnterior[$keyMeses]->monto;
   	    		$arraySumasTotales['gastosOperacion'][$keyMeses]['anioActual']+=$value->anioActual[$keyMeses]->monto;
   	    		$arraySumasTotales['gastosOperacion'][$keyMeses]['presupuesto']+=$value->anioActual[$keyMeses]->montoPresupuestoReal;
          $tr.='<td align="right">$'.number_format($value->anioAnterior[$keyMeses]->monto,2).'</td>';
   	     $tr.='<td align="right">$'.number_format($value->anioActual[$keyMeses]->montoPresupuestoReal,2).'</td>';
   	     $tr.='<td align="right">$'.number_format($value->anioActual[$keyMeses]->monto,2).'</td>';
   	     $tr.='<td></td>';
   	     $sumAnioAnteriorMonto=$sumAnioAnteriorMonto+$value->anioAnterior[$keyMeses]->monto;
   	     $sumPresupuestoReal=$sumPresupuestoReal+$value->anioActual[$keyMeses]->montoPresupuestoReal;
   	     $sumAnioActualMonto=$sumAnioActualMonto+$value->anioActual[$keyMeses]->monto;
   	     
          if($i>=2)
   	      {
   	       $tr.='<td align="right">$'.number_format($sumAnioAnteriorMonto,2).'</td>';
   	       $tr.='<td align="right">$'.number_format($sumPresupuestoReal,2).'</td>';
   	       $tr.='<td align="right">$'.number_format($sumAnioActualMonto,2).'</td>';

   	       $tr.='<td></td>';
   	      }  
       }
      $tr.='</tr>';
 }

    $sumAcumuladoActual=0;
  $sumAcumuladoAnterior=0;
      $tdSum='';

        $tr.='<tr name="costrVentaSubRamos" class="trColumnaEstatica"><td style="background-color:#e5e56d">TOTALES DE GASTOS DE OPERACION:</td>';
        $tr.=devolverMontosFinales($arraySumasTotales['gastosOperacion'],1 );
    $tr.='</tr>';


  $tr.='<tr style="height:10px"><td style="background-color:#fffff" colspan="30"></tr>'; 

//==============================================================================
//====================== GASTOS VARIABLES ============================
$tr.='<tr class="trColumnaEstatica"><td style="background-color:#A1ABDF" colspan="25"><button onclick="visibilidadHijos(this)" data-identificahijos="gastosVariablesSubRamos" class="btnVisibilidadHijos">-</button><label class="tituloCabecera">GASTOS VARIABLES</label></td></tr>';

foreach ($gastosVariables as $key => $value) 
 {
 	$i=0;
 	$option='';
 	$sumAnioAnteriorMonto=0;
 	$sumPresupuestoReal=0;
 	$sumAnioActualMonto=0;

 	 	    $optionArray= explode(',', $value->cuentasContableName);
 	 	    
 	    foreach ($optionArray as  $valueOA) 
 	    {
 	    	$option.='<option>'.$valueOA.'</option>';
 	    }
 	$tr.='<tr name="gastosVariablesSubRamos" class="trColumnaEstatica"><td style="background-color:#FFFF99;display:flex"><label style="flex:25">'.$key.'</label><select style="flex:1;width:3px"><option>NOMINA</option></select></td>';

 	
 	   	foreach ($meses as $keyMeses => $valueMeses) 
       {

       	$i++;

       	   	    if(!isset($arraySumasTotales['gastosVariables'][$keyMeses]))
   	    	{
   	    		$arraySumasTotales['gastosVariables'][$keyMeses]=array();
   	    		$arraySumasTotales['gastosVariables'][$keyMeses]['anioAnterior']=0;
   	    		$arraySumasTotales['gastosVariables'][$keyMeses]['anioActual']=0;   	    		                   
   	    		$arraySumasTotales['gastosVariables'][$keyMeses]['presupuesto']=0;
   	    	}
   	    		$arraySumasTotales['gastosVariables'][$keyMeses]['anioAnterior']+=$value->anioAnterior[$keyMeses]->monto;
   	    		$arraySumasTotales['gastosVariables'][$keyMeses]['anioActual']+=$value->anioActual[$keyMeses]->monto;
   	    		$arraySumasTotales['gastosVariables'][$keyMeses]['presupuesto']+=$value->anioActual[$keyMeses]->montoPresupuestoReal;
          $tr.='<td align="right">$'.number_format($value->anioAnterior[$keyMeses]->monto,2).'</td>';
   	     $tr.='<td align="right">$'.number_format($value->anioActual[$keyMeses]->montoPresupuestoReal,2).'</td>';
   	     $tr.='<td align="right">$'.number_format($value->anioActual[$keyMeses]->monto,2).'</td>';
   	     $tr.='<td></td>';
   	        	     $sumAnioAnteriorMonto=$sumAnioAnteriorMonto+$value->anioAnterior[$keyMeses]->monto;
   	     $sumPresupuestoReal=$sumPresupuestoReal+$value->anioActual[$keyMeses]->montoPresupuestoReal;
   	     $sumAnioActualMonto=$sumAnioActualMonto+$value->anioActual[$keyMeses]->monto;

          if($i>=2)
   	      {
   	       $tr.='<td align="right">$'.number_format($sumAnioAnteriorMonto,2).'</td>';
   	       $tr.='<td align="right">$'.number_format($sumPresupuestoReal,2).'</td>';
   	       $tr.='<td align="right">$'.number_format($sumAnioActualMonto,2).'</td>';
   	       $tr.='<td></td>';
   	      }  
       }
      $tr.='</tr>';
 }

    $sumAcumuladoActual=0;
  $sumAcumuladoAnterior=0;
      $tdSum='';

        $tr.='<tr name="costrVentaSubRamos" class="trColumnaEstatica"><td style="background-color:#e5e56d">TOTALES DE GASTOS DE VARIABLES:</td>';
        $tr.=devolverMontosFinales($arraySumasTotales['gastosVariables'],1 );
    $tr.='</tr>';


  $tr.='<tr style="height:10px"><td style="background-color:#fffff" colspan="30"></tr>'; 


//==============================================================================
//====================== GASTOS FINANCIEROS ============================
$tr.='<tr class="trColumnaEstatica"><td style="background-color:#A1ABDF" colspan="25"><button onclick="visibilidadHijos(this)" data-identificahijos="gastosFinancierosSubRamos" class="btnVisibilidadHijos">-</button><label class="tituloCabecera">GASTOS FINANCIEROS</label></td></tr>';


foreach ($gastosFinancieros as $key => $value) 
 {
 	$i=0;
 	 	$option='';$sumAnioAnteriorMonto=0;$sumPresupuestoReal=0;$sumAnioActualMonto=0;
 	 	$optionArray= explode(',', $value->cuentasContableName);
 	 	    
 	    foreach ($optionArray as  $valueOA) 
 	    {
 	    	$option.='<option>'.$valueOA.'</option>';
 	    }
 	
 	 	$tr.='<tr name="gastosFinancierosSubRamos" class="trColumnaEstatica"><td style="background-color:#FFFF99;display:flex"><label style="flex:25">'.$key.'</label><select style="flex:1;width:3px">'.$option.'</select></td>';
 	   	foreach ($meses as $keyMeses => $valueMeses) 

       {

       	$i++;

       	   	    if(!isset($arraySumasTotales['gastosFinancieros'][$keyMeses]))
   	    	{
   	    		$arraySumasTotales['gastosFinancieros'][$keyMeses]=array();
   	    		$arraySumasTotales['gastosFinancieros'][$keyMeses]['anioAnterior']=0;
   	    		$arraySumasTotales['gastosFinancieros'][$keyMeses]['anioActual']=0;   	    		                   
   	    		$arraySumasTotales['gastosFinancieros'][$keyMeses]['presupuesto']=0;
   	    	}
   	    		$arraySumasTotales['gastosFinancieros'][$keyMeses]['anioAnterior']+=$value->anioAnterior[$keyMeses]->monto;
   	    		$arraySumasTotales['gastosFinancieros'][$keyMeses]['anioActual']+=$value->anioActual[$keyMeses]->monto;
   	    		$arraySumasTotales['gastosFinancieros'][$keyMeses]['presupuesto']+=$value->anioActual[$keyMeses]->montoPresupuestoReal;
          $tr.='<td align="right">$'.number_format($value->anioAnterior[$keyMeses]->monto,2).'</td>';
   	     $tr.='<td align="right">$'.number_format($value->anioActual[$keyMeses]->montoPresupuestoReal,2).'</td>';
   	     $tr.='<td align="right">$'.number_format($value->anioActual[$keyMeses]->monto,2).'</td>';
   	     $tr.='<td></td>';

   	     $sumAnioAnteriorMonto=$sumAnioAnteriorMonto+$value->anioAnterior[$keyMeses]->monto;
   	     $sumPresupuestoReal=$sumPresupuestoReal+$value->anioActual[$keyMeses]->montoPresupuestoReal;
   	     $sumAnioActualMonto=$sumAnioActualMonto+$value->anioActual[$keyMeses]->monto;

          if($i>=2)
   	      {
   	       $tr.='<td align="right">$'.number_format($sumAnioAnteriorMonto,2).'</td>';
   	       $tr.='<td align="right">$'.number_format($sumPresupuestoReal,2).'</td>';
   	       $tr.='<td align="right">$'.number_format($sumAnioActualMonto,2).'</td>';

   	       $tr.='<td></td>';
   	      }  
       }
      $tr.='</tr>';
 }

    $sumAcumuladoActual=0;
  $sumAcumuladoAnterior=0;
      $tdSum='';

        $tr.='<tr name="costrVentaSubRamos" class="trColumnaEstatica"><td style="background-color:#e5e56d">TOTALES DE GASTOS FINANCIEROS:</td>';
        $tr.=devolverMontosFinales($arraySumasTotales['gastosFinancieros'],1 );
    $tr.='</tr>';


  $tr.='<tr style="height:10px"><td style="background-color:#fffff" colspan="30"></tr>'; 


//==============================================================================

//====================== GASTOS IMPUESTOS ============================
$tr.='<tr class="trColumnaEstatica"><td style="background-color:#A1ABDF" colspan="25"><button onclick="visibilidadHijos(this)" data-identificahijos="gastosImpuestosSubRamos" class="btnVisibilidadHijos">-</button><label class="tituloCabecera">GASTOS IMPUESTOS</label></td></tr>';
foreach ($gastosImpuestos as $key => $value) 
 {
 	$i=0;
 	 	$option='';$sumAnioAnteriorMonto=0;$sumPresupuestoReal=0;$sumAnioActualMonto=0;
 	 	$optionArray= explode(',', $value->cuentasContableName);
 	 	    
 	    foreach ($optionArray as  $valueOA) {$option.='<option>'.$valueOA.'</option>';}
 	
 	 	$tr.='<tr name="gastosImpuestosSubRamos" class="trColumnaEstatica"><td style="background-color:#FFFF99;display:flex"><label style="flex:25">'.$key.'</label><select style="flex:1;width:3px">'.$option.'</select></td>';

 	
 	   	foreach ($meses as $keyMeses => $valueMeses) 
       {

       	$i++;

       	   	    if(!isset($arraySumasTotales['gastosImpuestos'][$keyMeses]))
   	    	{
   	    		$arraySumasTotales['gastosImpuestos'][$keyMeses]=array();
   	    		$arraySumasTotales['gastosImpuestos'][$keyMeses]['anioAnterior']=0;
   	    		$arraySumasTotales['gastosImpuestos'][$keyMeses]['anioActual']=0;   	    		                   
   	    		$arraySumasTotales['gastosImpuestos'][$keyMeses]['presupuesto']=0;
   	    	}
   	    		$arraySumasTotales['gastosImpuestos'][$keyMeses]['anioAnterior']+=$value->anioAnterior[$keyMeses]->monto;
   	    		$arraySumasTotales['gastosImpuestos'][$keyMeses]['anioActual']+=$value->anioActual[$keyMeses]->monto;
   	    		$arraySumasTotales['gastosImpuestos'][$keyMeses]['presupuesto']+=$value->anioActual[$keyMeses]->montoPresupuestoReal;
          $tr.='<td align="right">$'.number_format($value->anioAnterior[$keyMeses]->monto,2).'</td>';
   	     $tr.='<td align="right">$'.number_format($value->anioActual[$keyMeses]->montoPresupuestoReal,2).'</td>';
   	     $tr.='<td align="right">$'.number_format($value->anioActual[$keyMeses]->monto,2).'</td>';
   	     $tr.='<td></td>';
   	     $sumAnioAnteriorMonto=$sumAnioAnteriorMonto+$value->anioAnterior[$keyMeses]->monto;
   	     $sumPresupuestoReal=$sumPresupuestoReal+$value->anioActual[$keyMeses]->montoPresupuestoReal;
   	     $sumAnioActualMonto=$sumAnioActualMonto+$value->anioActual[$keyMeses]->monto;   	     
          if($i>=2)
   	      {
   	       $tr.='<td align="right">$'.number_format($sumAnioAnteriorMonto,2).'</td>';
   	       $tr.='<td align="right">$'.number_format($sumPresupuestoReal,2).'</td>';
   	       $tr.='<td align="right">$'.number_format($sumAnioActualMonto,2).'</td>';

   	       $tr.='<td></td>';
   	      }  
       }
      $tr.='</tr>';
 }

    $sumAcumuladoActual=0;
  $sumAcumuladoAnterior=0;
      $tdSum='';

        $tr.='<tr name="costrImpuestosSubRamos" class="trColumnaEstatica"><td style="background-color:#e5e56d">TOTALES DE GASTOS IMPUESTOS:</td>';
        $tr.=devolverMontosFinales($arraySumasTotales['gastosImpuestos'] ,1);
    $tr.='</tr>';


  $tr.='<tr style="height:10px"><td style="background-color:#fffff" colspan="30"></tr>'; 


//==============================================================================


   return $tr;
}

function devolverMontosFinales($array,$presupuesto=0)
{
 $tr='';
 $i=0;
 $sumAcumuladoAnterior=0;
 $sumAcumuladoPresupuesto=0;
 $sumAcumuladoActual=0;
if($presupuesto==1)
{
 foreach ($array as $key => $value) 
    {
       	$i++;
       	  $sumAcumuladoActual+=$value['anioActual'];
         $sumAcumuladoAnterior+=$value['anioAnterior'];
          $tr.='<td align="right">$'.number_format($value['anioAnterior'],2).'</td>';
   	     $tr.='<td align="right">$'.number_format($value['presupuesto'],2).'</td>';
   	     $tr.='<td align="right">$'.number_format($value['anioActual'],2).'</td>';
   	     $tr.='<td></td>';
          if($i>=2)
   	      {
   	       $tr.='<td align="right">$'.number_format($sumAcumuladoAnterior,2).'</td>';
   	       $tr.='<td align="right">$'.number_format($sumAcumuladoPresupuesto,2).'</td>';
   	       $tr.='<td align="right">$'.number_format($sumAcumuladoActual,2).'</td>';
   	       $tr.='<td></td>';
   	      }  

    }


}
else{
 foreach ($array as $key => $value) 
    {
       	$i++;
       	  $sumAcumuladoActual+=$value['anioActual'];
         $sumAcumuladoAnterior+=$value['anioAnterior'];
          $tr.='<td align="right">$'.number_format($value['anioAnterior'],2).'</td>';
   	     $tr.='<td></td>';
   	     $tr.='<td align="right">$'.number_format($value['anioActual'],2).'</td>';
   	     $tr.='<td></td>';
          if($i>=2)
   	      {
   	       $tr.='<td align="right">$'.number_format($sumAcumuladoAnterior,2).'</td>';
   	       $tr.='<td></td>';
   	       $tr.='<td align="right">$'.number_format($sumAcumuladoActual,2).'</td>';
   	       $tr.='<td></td>';
   	      }  

    }
   }
   return $tr;
}

?>
<script type="text/javascript">
	function visibilidadHijos(objeto)
	{
		let identifica=objeto.dataset.identificahijos;
		let hijo=document.getElementsByName(identifica);
		if(objeto.innerHTML=='-')
		{   
			hijo.forEach(h=>{h.classList.add('ocultarObjeto')})

			objeto.innerHTML='+';
		}
		else
		{
		   hijo.forEach(h=>{h.classList.remove('ocultarObjeto')})
			objeto.innerHTML='-';
		}
	}
let botCerrados=Array.from(document.getElementsByClassName('btnVisibilidadHijos'));
botCerrados.forEach(b=>{visibilidadHijos(b)})
console.log(botCerrados);
</script>