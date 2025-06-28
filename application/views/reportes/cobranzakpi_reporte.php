<?php
$ingresoTotal=0;
$ventaNueva=0;
$recibosCobranza=0;
$meta=0;
$metaComercialRecibos=0;
$CT_PCO=0;
$ventaNuevaPCO=0;
$CT_PENDIENTE=0;
$acumDF=0;
$acumDC=0;
$indicadorDC=0;
$indicadorDF=0;
$df2=0;
$ctDf=0;
$ctDc=0;
$ctCancel=0;
$ctCancelFP=0;
$FStatus=0;
$indicadorPCO=0;
$acumCancelFP=0;
$difPC=0;
$PC;
$acumComisionFP=0;
$acumComision=0;
$acumCancel=0;

//*** Cobranza Pendiente
foreach ($cobranzaPendiente as $rowPendiente){
		$CT_PENDIENTE++;//Todos los Recibos Pendiente por Cobrar en el mes
}


//*** Cobranza Cancelada
foreach ($cobranzaCancelada as $rowCancelada){
	$ctCancel++;//Todos los Recibos cancelados en el Mes
	if($rowCancelada->MotStatus=='FALTA DE PAGO'){
    	$acumCancel=$acumCancel+$rowCancelada->PrimaNeta;
    	$acumComision=$acumComision+($rowCancelada->Comision0+$rowCancelada->Comision1+$rowCancelada->Comision2+$rowCancelada->Comision3+$rowCancelada->Comision4+$rowCancelada->Comision5+$rowCancelada->Comision6+$rowCancelada->Comision7+$rowCancelada->Comision8+$rowCancelada->Comision9+$rowCancelada->Comision10+$rowCancelada->Comision11+$rowCancelada->Comision12+$rowCancelada->Comision11+$rowCancelada->Comision12+$rowCancelada->Comision13+$rowCancelada->Comision14+$rowCancelada->Comision15+$rowCancelada->Comision16);
    $ctCancelFP++;//Polizas canceladas por falta de pago 
	$FStatus=substr($rowCancelada->FStatus, 0, -15);
    $year = explode("-", $FStatus);
    	if ($year[0]==2021){
    		$acumCancelFP=$acumCancelFP+$rowCancelada->PrimaNeta;
			$acumComisionFP=$acumComisionFP+($rowCancelada->Comision0+$rowCancelada->Comision1+$rowCancelada->Comision2+$rowCancelada->Comision3+$rowCancelada->Comision4+$rowCancelada->Comision5+$rowCancelada->Comision6+$rowCancelada->Comision7+$rowCancelada->Comision8+$rowCancelada->Comision9+$rowCancelada->Comision10+$rowCancelada->Comision11+$rowCancelada->Comision12+$rowCancelada->Comision11+$rowCancelada->Comision12+$rowCancelada->Comision13+$rowCancelada->Comision14+$rowCancelada->Comision15+$rowCancelada->Comision16);
		
		}
	}
}

//*** Cobranza Efectuada
foreach ($cobranzaEfectuada as $rowEfectuada){
	$ingresoTotal=$ingresoTotal+$rowEfectuada->PrimaNeta;
	$recibosCobranza++;//Todos los recibos ya cobrados en el Mes(Efectuada)
	if($rowEfectuada->Renovacion==0){
		$ventaNueva=$ventaNueva+$rowEfectuada->PrimaNeta;

	}
	// *** Diferimiento de pagos
	foreach ($renovacioneskpi as $rowKpi) {
		if($rowEfectuada->Documento==$rowKpi->Documento){
			if($rowEfectuada->FPago!=$rowKpi->FPagoNueva){
				$acumDF=$acumDF+$rowKpi->PrimaNeta;
				$ctDf++;
			}
		}				
	}
	// Descuentos por competencia
	foreach ($renovaciones as $rowR) {
		if($rowEfectuada->Documento==$rowR->Documento){
			$DC=$rowR->PrimaNeta-$rowR->PrimaNetaNueva;
			if($DC>0){
				$acumDC=$acumDC+$rowR->PrimaNetaNueva;
				$ctDc++;
			}
		}				
	}


}

//*** Indicador de Diferimiento
$indicadorDF=($ctDf*100)/$recibosCobranza;

//*** Indicador de Descuento por competencia
$indicadorDC=($ctDc*100)/$recibosCobranza;

//** Indicador Polizas Canceladas de Origen
$indicadorPC=($ctCancelFP*100)/$ctCancel;
//** Indicador Polizas Canceladas

$meta=$ingresoTotal-$ventaNueva;


$df2=((abs($meta-$ventaNuevaPCO))*$indicadorPCO)/100;

//Polizas canceladas
$difPC=$ingresoTotal-$acumCancelFP;



?>
<section>

<div class="well" style="margin-right: 3%;float: left;width: 100%">
	<table width="80%" border="0">
			<tr>
				<td colspan="4" style="background-color: #E2E2E2;padding-left: 5px;"><i class="fa fa-calendar"></i>&nbsp;RANGO DE CONSULTA</td>
				<td>&nbsp;&nbsp;&nbsp;&nbsp;</td>
				<td colspan="5" style="background-color: #E2E2E2;padding-left: 5px;"><i class="fa fa-search"></i>&nbsp;CONSULTAR</td>
			</tr>
			<tr>
				<td><b>Desde:</b> </td>
				<td><?php echo $fechaInicial;?></td>
				<td><b>Hasta:</b></td>
				<td><?php echo $fechaFinal;?></td>
				<td>&nbsp;&nbsp;&nbsp;&nbsp;</td>
				<td><b>Desde:</b></td>
				<td><input type="date" name="fechInicial" id="fechInicial" class="form-control" style="width: 200px;"></td>
				<td><b>Hasta:</b></td>
				<td><input type="date" name="fechFinal" id="fechFinal" class="form-control"  style="width: 200px;"></td>
				<td style="text-align: left;"><button type="button"  name="filtrar" id="filtrar" style="border-radius: 8px;" onclick="consultaKpi()">Consulta</button></td>
			</tr>
	</table>
</div>
	
	<div class="row">
		<div class="col-md-12 col-sm-12">
			<table style="width: 100%;font-size: 10px" border="0">
				<tr style="text-align: center;">
					<td colspan="11"><h3>KPIS   COBRANZA CAPITAL</h3></td>
				</tr>
				<tr style="text-align: center;">
					<td colspan="2">
						<select name="despacho" class="form-control">
							<? $option="";
						      foreach ($permisosCanales as  $value) {
						      	$seleccion="";
						      	if($opcion==$value->value){$seleccion='selected="selected"';}
						      	$option.='<option value="'.$value->value.'" '.$seleccion.'>'.$value->texto.'</option>';
						      }
						      echo $option;
							?>
						</select>
					</td>
					<td colspan="9"></td>
				</tr>
				<tr style="text-align: center;">
					<td colspan="4"></td>
					<td colspan="5" style="background-color: #472480;color: #fff;"><h5>INDICADORES VARIABLES POR CONTINGENCIA</h5></td>
					<td colspan="2"></td>
				</tr>
				<tr style="text-align: center;">
					<td style="background-color: #d0e2e2;">INGRESO TOTAL(Cobranza Efectuada)</td>
					<td style="background-color: #d0e2e2;">VENTA NUEVA</td>
					<td style="background-color: #d0e2e2;">META</td>
					<td>&nbsp;&nbsp;&nbsp;&nbsp;</td>

					<td style="background-color: #d0e2e2;">Cobranza Efectuada - Polizas Canceladas 2021</td>
					<td style="background-color: #d0e2e2;">
					<a href="#" data-toggle="modal" data-target="#exampleModal">
  					<i class="fa fa-bars"></i></a>&nbsp;POLIZAS CANCELADAS 2021 (Total Prima Neta)</td>
  					<td style="background-color: #d0e2e2;">
					<a href="#" data-toggle="modal" data-target="#exampleModal">
  					<i class="fa fa-bars"></i></a>&nbsp;POLIZAS CANCELADAS 2021 (Total Comision)</td>
					<td style="background-color: #d0e2e2;"><a href="#"><i class="fa fa-bars"></i></a>&nbsp;DESCUENTO POR COMPETENCIA</td>
					<td style="background-color: #d0e2e2;"><a href="#"><i class="fa fa-bars"></i></a>&nbsp;DIFERIMIENTO DE PAGOS</td>
					<td colspan="4"></td>
				</tr>
				<tr style="text-align: center;">
					<td><input type="text" name="ingresoTotal" value="<?php echo number_format($ingresoTotal,2);?>" class="form-control"></td>
					<td><input type="text" name="ventaNueva" value="<?php echo number_format($ventaNueva,2);?>" class="form-control"></td>
					<td><input type="text" name="meta" value="<?php echo number_format($meta,2);?>" class="form-control"></td>
					<td>&nbsp;&nbsp;&nbsp;&nbsp;</td>
					<td><input type="text" name="cobranzaEfectuada" value="<?php echo number_format($difPC,2);?>" class="form-control"></td>
					<td><input  type="text" name="pco" id="pco" value="<?php echo  number_format($acumCancelFP,2);?>" class="form-control"></td>
					<td><input  type="text" name="pco" id="pco" value="<?php echo  number_format($acumComisionFP,2);?>" class="form-control"></td>
					<td><input  type="text" name="dc" id="dc" value="<?php echo number_format($indicadorDC).'%';?>" class="form-control"></td>
					<td><input  type="text" name="df" id="df" value="<?php echo number_format($indicadorDF).'%';?>" class="form-control"></td>
					<td colspan="4"></td>
				</tr>
				

				

				<tr>
					<td colspan="11"><h4>PUNTOS CRITICOS</h4></td>
				</tr>

				<tr>
					<td colspan="11"><hr></td>
				</tr>

				<tr style="text-align: center;">
					<td colspan="2" style="background-color: #472480;color: #fff;"><h5>DINERO</h5></td>
					<td style="background-color: #3fbedb;">&nbsp;</td>
					<td>&nbsp;&nbsp;&nbsp;&nbsp;</td>
					<td colspan="3" style="background-color: #472480;color: #fff;"><h5>INDICADORES VARIABLES POR CONTINGENCIA</h5></td>
					<td>&nbsp;&nbsp;&nbsp;&nbsp;</td>
					<td colspan="3" style="background-color: #472480;color: #fff;"><h5>SEMAFOROS</h5></td>
				</tr>

				<tr style="text-align: center;">
					<td style="background-color: #d0e2e2;">META COMERCIAL</td>
					<td style="background-color: #d0e2e2;">PC</td>
					<td style="background-color: #d0e2e2;">META NETA EJECUTIVO COMERCIAL</td>
					<td>&nbsp;&nbsp;&nbsp;&nbsp;</td>
					<td style="background-color: #d0e2e2;">DESCUENTO POR COMPETENCIAS</td>
					<td style="background-color: #d0e2e2;">DIFERIMIENTO DE PAGOS</td>
					<td style="background-color: #d0e2e2;">BASE KPI INGRESO DINERO</td>
					<td>&nbsp;&nbsp;&nbsp;&nbsp;</td>
					<td style="background-color: #9CCC65;font-weight: bold;font-size: 12px;">VERDE 95%</td>
					<td style="background-color: #FFF59D;font-weight: bold;font-size: 12px;">AMARILLO 80%</td>
					<td style="background-color: #FF5722;font-weight: bold;font-size: 12px;">ROJO 70%</td>
				</tr>
				<tr style="text-align: center;">
					<td><input type="text" name="mc1" id="mc1" value="<?php echo number_format($meta,2)?>" class="form-control"></td>
					<td><input type="text" name="pco1" id="pco1" value="<?php echo number_format($acumCancel,2);?>" class="form-control"></td><td><input type="text" name="mnec1" id="mnec1" value="<?php echo number_format(($meta-$acumCancel),2)?>" class="form-control"></td>
					<td>&nbsp;&nbsp;&nbsp;&nbsp;</td>
					<?php 
						$metaX=abs($meta-$ventaNuevaPCO);
						$dc1=($metaX*$indicadorDC)/100;
						$dp1=($metaX*$indicadorDF)/100;
						$base=abs($metaX-$dc1);
						$base=abs($base-$dp1);
					?>
					<td><input type="text" name="dc1" id="dc1" value="<?php echo  number_format($dc1,2);?>" class="form-control"></td>
					<td><input type="text" name="dp1" id="dp1" value="<?php echo number_format($dp1,2);?>" class="form-control"></td>
					<td><input type="text" name="base" id="base" value="<?php echo number_format($base,2);?>" class="form-control"></td>
					<td>&nbsp;&nbsp;&nbsp;&nbsp;</td>
					<td><input type="text" name="" id="" value="<?php echo ($metaX*95)/100;?>" class="form-control"></td>
					<td><input type="text" name="" id="" value="<?php echo ($metaX*80)/100;?>" class="form-control"></td>
					<td><input type="text" name="" id="" value="<?php echo ($metaX*70)/100;?>" class="form-control"></td>
				</tr>


				<tr>
					<td colspan="11">&nbsp;</td>
				</tr>

				<tr style="text-align: center;">
					<td colspan="2" style="background-color: #472480;color: #fff;"><h5>KPI COBRANZA RECIBOS</h5></td>
					<td style="background-color: #3fbedb;">&nbsp;</td>
					<td>&nbsp;&nbsp;&nbsp;&nbsp;</td>
					<td colspan="3" style="background-color: #472480;color: #fff;"><h5>SEMAFOROS</h5></td>
					<td colspan="4"></td>
				</tr>

				<tr style="text-align: center;">
					<td style="background-color: #d0e2e2;">META COMERCIAL</td>
					<td style="background-color: #d0e2e2;">PC</td>
					<td style="background-color: #d0e2e2;">META NETA EJECUTIVO COMERCIAL</td>
					<td>&nbsp;&nbsp;&nbsp;&nbsp;</td>
					<td style="background-color: #9CCC65;font-weight: bold;font-size: 12px;">VERDE 95%</td>
					<td style="background-color: #FFF59D;font-weight: bold;font-size: 12px;">AMARILLO 80%</td>
					<td style="background-color: #FF5722;font-weight: bold;font-size: 12px;">ROJO 70%</td>
					<td colspan="4"></td>
				</tr>
				<tr style="text-align: center;">
					<td><input type="text" name="mc2" id="mc2" value="<?php echo $CT_PENDIENTE;?>" class="form-control"></td>
					<td><input  type="text" name="pco2" id="pco2" value="<?php echo $ctCancelFP?>" class="form-control"></td>
					<td><input  type="text" name="mnce2" id="mnce2" value="<?php echo abs($CT_PENDIENTE-$ctCancelFP);?>" class="form-control"></td>
					<td>&nbsp;&nbsp;&nbsp;&nbsp;</td>
					<td><input type="text" name="" id="" value="<?php echo round(abs($CT_PENDIENTE-$ctCancelFP)*0.95);?>" class="form-control"></td>
					<td><input type="text" name="" id="" value="<?php echo round(abs($CT_PENDIENTE-$ctCancelFP)*0.80)?>" class="form-control"></td>
					<td><input type="text" name="" id="" value="<?php echo round((abs($CT_PENDIENTE-$ctCancelFP))*0.70);?>" class="form-control"></td>
					<td colspan="4"></td>
				</tr>


				<tr>
					<td colspan="11"><br></td>
				</tr>
				
				<tr>
					<td colspan="2"><b>ACCIONES</b></td>
					<td colspan="9"><?php echo$FStatus; ?></td>
				</tr>
				<tr>
					<td colspan="2">ORDEN DE LISTADO DE RECIBOS SEGÚN MONTO</td>
					<td colspan="9"></td>
				</tr>
				<tr>
					<td colspan="2">REPORTE DE JUSTIFICACION DE CUENTAS NO COBRADAS</td>
					<td colspan="9"></td>
				</tr>
				<tr>
					<td colspan="2">APLICACIÓN 80/20</td>
					<td colspan="9"></td>
				</tr>
				<tr>
					<td colspan="2">RENDICION DE CUENTAS SEGÚN ACCOUNTABILITY</td>
					<td colspan="9"></td>
				</tr>
				<tr>
					<td colspan="2">RECORRIDO DE RECIBOS POR PERIODO DE GRACIA</td>
					<td colspan="9"></td>
				</tr>

				<tr>
					<td colspan="11"><br></td>
				</tr>

				<td>
					<td colspan="3"></td>
					<td style="background-color: #472480;color: #fff;text-align: center;" colspan="3"><h5>&nbsp;SEMAFOROS</h5></td>
					<td colspan="5"></td>
				</td>
				<tr>
					<td style="background-color: #472480;color: #fff;" colspan="3"><h5>&nbsp;KPI INDICADORES VARIABLES</h5></td>
					<td>&nbsp;&nbsp;&nbsp;&nbsp;</td>
					<td style="text-align: center;background-color: #9CCC65;font-weight: bold;font-size: 12px;">VERDE 95%</td>
					<td style="text-align: center;background-color: #FFF59D;font-weight: bold;font-size: 12px;">AMARILLO 80%</td>
					<td style="text-align: center;background-color: #FF5722;font-weight: bold;font-size: 12px;">ROJO 70%</td>
					<td colspan="4"></td>
				</tr>
				<tr>
					<td colspan="3">POLIZAS CANCELADAS</td>
					<td>&nbsp;&nbsp;&nbsp;&nbsp;</td>
					<td><input type="text" name="" id="" value="<?php echo $ctCancelFP;?>" class="form-control"></td>
					<td><input type="text" name="" id="" value="" class="form-control"></td>
					<td><input type="text" name="" id="" value="" class="form-control"></td>
					<td colspan="4"></td>
				</tr>
				<tr>
					<td colspan="3">DESCUENTO POR COMPETENCIA</td>
					<td>&nbsp;&nbsp;&nbsp;&nbsp;</td>
					<td><input type="text" name="" id="" value="<?php echo number_format($indicadorDC)."%";?>" class="form-control"></td>
					<td><input type="text" name="" id="" value="" class="form-control"></td>
					<td><input type="text" name="" id="" value="" class="form-control"></td>
					<td colspan="4"></td>
				</tr>
				<tr>
					<td colspan="3">DIFERIMIENTO DE PAGOS</td>
					<td>&nbsp;&nbsp;&nbsp;&nbsp;</td>
					<td><input type="text" name="" id="" value="<?php echo number_format($indicadorDF)."%";?>" class="form-control"></td>
					<td><input type="text" name="" id="" value="" class="form-control"></td>
					<td><input type="text" name="" id="" value="" class="form-control"></td>
					<td colspan="4"></td>
				</tr>
				<tr>
					<td colspan="3">CANCELACIONES (MERMA)</td>
					<td>&nbsp;&nbsp;&nbsp;&nbsp;</td>
					<td><input type="text" name="" id="" value="<?php echo $ctCancelFP?>" class="form-control"></td>
					<td><input type="text" name="" id="" value="" class="form-control"></td>
					<td><input type="text" name="" id="" value="" class="form-control"></td>
					<td colspan="4"></td>
				</tr>
			</table>
		</div>
	</div>
</div>
</section>

