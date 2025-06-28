<?php
	$nombre=$cliente->Nombre.' '.$cliente->ApellidoP;
	$prima_minima=$datos->prima_minima;
	$buro_persona_moral=$datos->buro_moral;
	$buro_persona_fisica=$datos->buro_fisica;
	$buro_persona_moral=$datos->buro_moral;
	$sofimex=$datos->sofimex;
	$liberty=$datos->liberty;
	$chubb=$datos->chubb;
	$tokyo=$datos->tokyo;
	$berkley=$datos->berkley;

?>
<p>
<div class="container">
	<table border="0" style="width:80%;font-size: 12px;">
		<tr>
			<td colspan="2"><img src="<?php echo base_url()?>assets/img/logo_fianzas.png" style="width: 50%;"></td>
			<td colspan="5"></td>
		</tr>

		<tr>
			<td colspan="7" style="font-size: 12px;">
				<b>Nombre del Cliente:&nbsp;</b><?php echo strtoupper($nombre);?>
			</td>
		</tr>
		<tr>
			<td colspan="7">&nbsp;</td>
		</tr>
		<tr>
			<td style="width: 15%;">Contrato o Proyeccion Anual:</td>
			<td style="width: 10%;text-align: center;"><input type="text" name="contrato" id="contrato" style="text-align: right;background-color: #ffd866;width: 100px;" onkeyup="calcular(this)"></td>
			<td colspan="5"></td>
		</tr>
		<tr>
			<td>% a Afianzar</td>
			<td style="text-align: center;width: 10%;"><input type="text" name="por1" id="por1" value="10" style="width: 50px;text-align: right;background-color: #ffd866;" onkeyup="asignarPor(this)">%</td>

			<td style="text-align: center;width: 10%;"><input type="text" name="por2" id="por2" value="10" style="width: 50px;text-align: right;background-color: #ffd866;" onkeyup="asignarPor(this)">%</td>

			<td style="text-align: center;width: 10%;"><input type="text" name="por3" id="por3" value="10" style="width: 50px;text-align: right;background-color: #ffd866;" onkeyup="asignarPor(this)">%</td>

			<td colspan="3"></td>
		</tr>
		<tr style="text-align: right;">
			<td style="text-align: left;">MONTO **</td>
			<td style="text-align:center;"><input type="text" name="monto1" id="monto1" disabled="false" style="text-align: right;width: 100px;"></td>
			<td style="text-align:center;"><input type="text" name="monto2" id="monto2" disabled="false" style="text-align: right;width: 100px;"></td>
			<td style="text-align:center;"><input type="text" name="monto3" id="monto3" disabled="false" style="text-align: right;width: 100px;"></td>
			
			<td></td>
			<td></td>
			<td></td>
		</tr>
		<tr style="text-align: right;">
			<td style="text-align: left;">TARIFA </td>
			<td style="text-align: center;width: 10%;"><input type="text" name="tar1" id="tar1" value="1.2" style="width: 50px;text-align: right;background-color: #b5c5e6;">%</td>
			<td style="text-align: center;width: 10%;"><input type="text" name="tar2" id="tar2" value="1.2" style="width: 50px;text-align: right;background-color: #b5c5e6;">%</td>
			<td style="text-align: center;width: 10%;"><input type="text" name="tar3" id="tar3" value="1.2" style="width: 50px;text-align: right;background-color: #b5c5e6;">%</td>
			
			<td></td>
			<td></td>
			<td></td>
		</tr>
		<tr style="text-align: right;">
			<td style="text-align: left;">PRIMA </td>
			<td style="text-align:center;"><input type="text" name="prima1" id="prima1" disabled="false" style="text-align: right;width: 100px;"></td>
			<td style="text-align:center;"><input type="text" name="prima2" id="prima2" disabled="false" style="text-align: right;width: 100px;"></td>
			<td style="text-align:center;"><input type="text" name="prima3" id="prima3" disabled="false" style="text-align: right;width: 100px;"></td>
			
			<td><i class="fa fa-arrow-left fa-2x"></i></td>
			<td colspan="2"><b>Prima minima</b> no puede ser menor a 
				<input type="text" name="primaminima" id="primaminima" disabled="false" style="width:150px;text-align: right;" value="<?php echo number_format($prima_minima);?>">
				<button type="button" href="#" data-toggle="modal" data-target="#divPrimaMinima">
					<i class="fa fa-edit"></i>
				</button>
			</td>
		</tr>
		<tr style="text-align: right;">
			<td style="text-align: left;">DIV </td>
			<td style="text-align:center;"><input type="text" name="div1" id="div1" disabled="false" style="text-align: right;width: 100px;"></td>
			<td style="text-align:center;"><input type="text" name="div2" id="div2" disabled="false" style="text-align: right;width: 100px;"></td>
			<td style="text-align:center;"><input type="text" name="div3" id="div3" disabled="false" style="text-align: right;width: 100px;"></td>
			
			<td colspan="3"></td>
			
		</tr>
		<tr style="text-align: right;">
			<td style="text-align: left;">GAS. EXP. </td>
			<td style="text-align:center;"><input type="text" name="gas1" id="gas1" style="text-align: right;width: 100px;" disabled="false"></td>
			<td style="text-align:center;"><input type="text" name="gas2" id="gas2" style="text-align: right;width: 100px;" disabled="false"></td>
			<td style="text-align:center;"><input type="text" name="gas3" id="gas3" style="text-align: right;width: 100px;" disabled="false"></td>
			
			<td colspan="3"></td>
			
		</tr>
		<tr>
			<td colspan="7">&nbsp;</td>
		</tr>
		<tr style="text-align: right;">
			<td style="text-align: left;">BURO </td>
			<td style="text-align:center;"><input type="text" name="buro1" id="buro1" style="text-align: right;width: 100px;" disabled="false" value="0" onkeyup="subtotal()"></td>
			<td style="text-align:center;"><input type="text" name="buro2" id="buro2" style="text-align: right;width: 100px;" disabled="false" value="0" onkeyup="subtotal()"></td>
			<td style="text-align:center;"><input type="text" name="buro3" id="buro3" style="text-align: right;width: 100px;" disabled="false" value="0" onkeyup="subtotal()"></td>
			<td colspan="3"></td>
			
		</tr>
		<tr style="text-align: right;">
			<td style="text-align: left;">SUB TOTAL </td>
			<td style="text-align:center;"><input type="text" name="subtotal1" id="subtotal1" style="text-align: right;width: 100px;" disabled="false"></td>
			<td style="text-align:center;"><input type="text" name="subtotal2" id="subtotal2" style="text-align: right;width: 100px;" disabled="false"></td>
			<td style="text-align:center;"><input type="text" name="subtotal3" id="subtotal3" style="text-align: right;width: 100px;" disabled="false"></td>
			<td colspan="3"></td>
			
		</tr>
		<tr style="text-align: right;">
			<td style="text-align: left;">I.V.A </td>
			<td style="text-align:center;"><input type="text" name="iva1" id="iva1" style="text-align: right;width: 100px;" disabled="false"></td>
			<td style="text-align:center;"><input type="text" name="iva2" id="iva2" style="text-align: right;width: 100px;" disabled="false"></td>
			<td style="text-align:center;"><input type="text" name="iva3" id="iva3" style="text-align: right;width: 100px;" disabled="false"></td>
			
			<td></td>
			<td></td>
			<td></td>
		</tr>
		<tr style="text-align: right;font-weight: bold;font-size: 14px;">
			<td style="text-align: left;">TOTAL </td>
			<td style="text-align:center;"><input type="text" name="Total1" id="Total1" style="text-align: right;width: 100px;font-weight: bold;font-size: 14px;" disabled="false"></td>
			<td style="text-align:center;"><input type="text" name="Total2" id="Total2" style="text-align: right;width: 100px;font-weight: bold;font-size: 14px;" disabled="false"></td>
			<td style="text-align:center;"><input type="text" name="Total3" id="Total3" style="text-align: right;width: 100px;font-weight: bold;font-size: 14px;" disabled="false"></td>
			
			<td></td>
			<td></td>
			<td></td>


		<input type="hidden" name="prmaMinima" id="primaMinima" value="0">
		<input type="hidden" name="prmaMinimaX" id="primaMinimaX" value="0">
	    <input type="hidden" name="prmaMinimaY" id="primaMinimaY" value="0">


		<input type="hidden" name="Total4" id="Total4">
		<input type="hidden" name="Total5" id="Total5">
		<input type="hidden" name="Total6" id="Total6">
		</tr>
		<tr>
			<td colspan="7">&nbsp;</td>
		</tr>
		<tr>
			<td colspan="4"><b> GAST. EXP.<button type="button" href="#" data-toggle="modal" data-target="#divAfianzadora"><i class="fa fa-edit"></i></button></b></td>
			<td colspan="3"></td>
		</tr>
		<tr>
			
			<td colspan="2">
				<input type="radio" id="sofimex" name="afianzadora" checked onchange="calcular(document.getElementById('contrato'))">&nbsp;SOFIMEX</td>
			<td style="text-align:center;"><input type="text" name="TotalGas1" id="TotalGas1" style="text-align: right;width: 100px;" value="<?php echo $sofimex;?>" disabled="false"></td>
			<td style="text-align: right;"><input type="radio" name="persona"  id="personaMoral" value="moral" onchange="calcular(document.getElementById('contrato'))" checked></td>
			<td style="text-align:left;width: 10%">&nbsp;Persona moral</td>
			<td style="text-align: left;">
				<input type="text" name="costopersonaMoral" id="costopersonaMoral" value="<?php echo $buro_persona_moral;?>" style="text-align: right;width: 100px;" disabled="false" onchange="calcular(document.getElementById('contrato'))">
				<button type="button" href="#" data-toggle="modal" data-target="#divBuro"><i class="fa fa-edit"></i></button>
			</td>
			<td colspan="3"></td>
		</tr>
		<tr>
			<td colspan="2">
				<input type="radio" id="liberty" name="afianzadora"  onchange="calcular(document.getElementById('contrato'))">&nbsp;LIBERTY</td>
			<td style="text-align:center;"><input type="text" name="TotalGas2" id="TotalGas2" style="text-align: right;width: 100px;" value="<?php echo $liberty;?>" disabled="false"></td>
			<td style="text-align:right"><input type="radio" name="persona" id="personaFisica" value="fisica" onchange="calcular(document.getElementById('contrato'))"></td>

			<td style="text-align:left;">&nbsp;Persona física</td>
			<td style="text-align: left;"  colspan="2">
				<input type="text" name="costopersonaFisica" id="costopersonaFisica" value="<?php echo $buro_persona_fisica;?>" style="text-align: right;width: 100px;" disabled="false" onchange="calcular(document.getElementById('contrato'))">
			</td>
			<td>&nbsp;</td>
		</tr>
		<tr>
			<td colspan="2">
				<input type="radio" id="chubb" name="afianzadora"  onchange="calcular(document.getElementById('contrato'))">&nbsp;CHUBB</td>
			<td style="text-align:center;"><input type="text" name="TotalGas3" id="TotalGas3" style="text-align: right;width: 100px;" value="<?php echo $chubb;?>" disabled="false"></td>
			<td colspan="5">&nbsp;</td>
		</tr>
		<tr>
			<td colspan="2">
				<input type="radio" id="tokyo" name="afianzadora"  onchange="calcular(document.getElementById('contrato'))">&nbsp;TOKIO/ ASERTA /INSURGENTES</td>
			<td style="text-align:center;"><input type="text" name="TotalGas4" id="TotalGas4" style="text-align: right;width: 100px;" value="<?php echo $tokyo;?>" disabled="false"></td>
			<td colspan="5">&nbsp;</td>
		</tr>
		<tr>
			<td colspan="2">
				<input type="radio" id="berkley" name="afianzadora"  onchange="calcular(document.getElementById('contrato'))">&nbsp;BERKLEY</td>
			<td style="text-align:center;"><input type="text" name="TotalGas5" id="TotalGas5" style="text-align: right;width: 100px;" value="<?php echo $berkley;?>" disabled="false"></td>
			<td colspan="5">&nbsp;</td>
		</tr>
	</table>
</p>
<br><br>
<!--Modificacion-->
<form name="frmGenerar" id="frmGenerar" method="post" action="<?php echo base_url()."crmproyecto/RptCotizadorFianzas"?>">
<table style="font-size: 12px;width: 50%;" border="1">
<tr style="text-align: center;background-color: #000;color: #fff;">
	<td width="3%">Selección</td>
	<td style="width:5%">Fianza</td>
	<td style="width:5%">Contrato</td>
	<td style="width:5%">%</td>
	<td style="width:5%">Monto Afianzado</td>
	<td style="width:5%">Total Pagar</td>
</tr>
<tr>
	<td style="text-align:center;"><input type="checkbox" name="chkAnticipo" checked></td>
	<td style="text-align:center;">&nbsp;Anticipo</td>
	<td style="text-align:right;"><input type="text" name="contrato1" id="contrato1" style="text-align: right;width: 100px;font-weight: bold;font-size: 14px;"></td>
	<td style="text-align:center;"><input type="text" name="txtporrpt1" id="txtporrpt1" size="10" style="text-align:right;width: 40px;border-style: none;"></td>
	<td style="text-align:right;"><input type="text" name="montoAfianzado1" id="montoAfianzado1" style="text-align: right;width: 100px;font-weight: bold;font-size: 14px;"></td>
	<td style="text-align:right;font-weight: bold;"><input type="text" name="totalPagar1" id="totalPagar1" style="text-align: right;width: 100px;font-weight: bold;font-size: 14px;"td>
</tr>
<tr>
	<td style="text-align:center;"><input type="checkbox" name="chkCumplimiento" checked></td>
	<td style="text-align:center;">&nbsp;Cumplimiento</td>
	<td style="text-align:right;"><input type="text" name="contrato2" id="contrato2" style="text-align: right;width: 100px;font-weight: bold;font-size: 14px;"></td>
	<td style="text-align:center;"><input type="text" name="txtporrpt2" id="txtporrpt2" size="10" style="text-align:right;width: 40px;border-style: none;"></td>
	<td style="text-align:right;"><input type="text" name="montoAfianzado2" id="montoAfianzado2" style="text-align: right;width: 100px;font-weight: bold;font-size: 14px;" ></td>
	<td style="text-align:right;font-weight: bold;"><input type="text" name="totalPagar2" id="totalPagar2" style="text-align: right;width: 100px;font-weight: bold;font-size: 14px;"></td>
</tr>
<tr>
	<td style="text-align:center;"><input type="checkbox" name="chkVicios" checked></td>
	<td style="text-align:center;">&nbsp;Vicios Ocultos</td>
	<td style="text-align:right;"><input type="text" name="contrato3" id="contrato3" style="text-align: right;width: 100px;font-weight: bold;font-size: 14px;"></td>
	<td style="text-align:center;"><input type="text" name="txtporrpt3" id="txtporrpt3" size="10" style="text-align:right;width: 40px;border-style: none;"></td>
	<td style="text-align:right;"><input type="text" name="montoAfianzado3" id="montoAfianzado3" style="text-align: right;width: 100px;font-weight: bold;font-size: 14px;"></td>
	<td style="text-align:right;font-weight: bold;"><input type="text" name="totalPagar3" id="totalPagar3" style="text-align: right;width: 100px;font-weight: bold;font-size: 14px;"></td>
</tr>
<tr>
	<td colspan="6"><hr></td>
</tr>
<tr>
	<td colspan="4"></td>
	<td style="text-align:right;"><input type="text" name="totalMontoAfianzado1" id="totalMontoAfianzado1" style="text-align: right;width: 100px;font-weight: bold;font-size: 14px;" disabled="false"></td>
	<td style="text-align:right;font-weight: bold;"><input type="text" name="totalMontoPagar1" id="totalMontoPagar1" style="text-align: right;width: 100px;font-weight: bold;font-size: 14px;" disabled="false"></td>
</tr>
</table>

<br>
<div>
	<input type="hidden" name='nombre' id="nombre" value="<?php echo $nombre?>">
	<input type="hidden" name='PrimaMinima' id="PrimaMinima" value="<?php echo $prima_minima?>">
	<input type="hidden" name="IDCL" id="IDCL" value="<?php echo $IDCL?>">
	<input type="hidden" name="tipo" id="tipo">
	<input type="hidden" name="anticipo_contrato" id="anticipo_contrato">
	<input type="hidden" name="anticipo_monto" id="anticipo_monto">
	<input type="hidden" name="anticipo_total" id="anticipo_total">

	<input type="hidden" name="cumplimiento_contrato" id="cumplimiento_contrato">
	<input type="hidden" name="cumplimiento_monto" id="cumplimiento_monto">
	<input type="hidden" name="cumplimiento_total" id="cumplimiento_total">

	<input type="hidden" name="vicios_contrato" id="vicios_contrato">
	<input type="hidden" name="vicios_monto" id="vicios_monto">
	<input type="hidden" name="vicios_total" id="vicios_total">

<div id="mensajeCorizador" class="alert alert-info" style="width: 80%;" style="display:none;">
		<b>Nota:</b> recuerde que para poder generar la cotizacion la prima calculada debe ser mayor o igual a la prima minima
<div style="text-align: center;margin-top: 1%;">
	<!--<button class="btn btn-primary btn-sm" type="button" >
		<i class="fa fa-calc"></i>
		Ajustar los Calculos del cotizador con la prima minima
	</button>
-->
</div>
</div>
<button id="btnGenerar" class="btn btn-primary btn-md" type="button" style="display: none;" onclick="generarReportePdfFianzas()">
	<i class="fa fa-file"></i>&nbsp;Generar Documento
</button>

</form>

</div>

</div>

























