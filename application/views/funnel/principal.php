<?
	//$this->load->view('headers/header');
	$this->load->view('headers/headerReportes');
	
	//Modificacion Miguel 10/02/2020
	$ctSuspectos=0;
	$ctPerfilados=0;
	$ctContactados=0;
	$ctCotizados=0;
	$ctPagados=0;
        $ctEmision=0;
	foreach ($suspectos as $sus) {$ctSuspectos++;}
	foreach ($perfilados as $per) {$ctPerfilados++;}
	foreach ($contactados as $con) {$ctContactados++;}
	foreach ($cotizados as $cot) {$ctCotizados++;}
	foreach ($pagados as $pag) {$ctPagados++;}
	foreach ($emision as $pag) {$ctEmision++;}
?>
<style type="text/css">html,body{ overflow-x: hidden;}</style>
<style>
.letra{width: 350px;background-color:black;display:block; margin-left:auto; margin-right:auto;position:relative; left:150px;top:30px;height:0px;background: black;font-size: 18px;color: black}
.trapecio-top {  width:350px;height:0px;border-right: 30px solid transparent;border-left: 30px solid transparent;
border-top: 50px solid #428bca;padding-left:50px;display:block; margin-left:auto; margin-right:auto}
.trapecio-top1 {width: 290px;height:0px;border-right: 30px solid transparent;border-left: 30px solid transparent;
border-top: 50px solid #428bca;padding-left:50px;display:block; margin-left:auto; margin-right:auto}
.trapecio-top2 {width: 230px;height:0px;border-right: 30px solid transparent;border-left: 30px solid transparent;
border-top: 50px solid #428bca;padding-left:50px;display:block; margin-left:auto; margin-right:auto}
.trapecio-top3 {width: 170px;height:0px;border-right: 30px solid transparent;border-left: 30px solid transparent;
border-top: 50px solid #428bca;padding-left:50px;display:block; margin-left:auto; margin-right:auto}
.trapecio-top4 {width: 110px;height:0px;border-right: 30px solid transparent;border-left: 30px solid transparent;
border-top: 50px solid #428bca;padding-left:50px;display:block; margin-left:auto; margin-right:auto}
.fondoSelecRow{background-color: blue;	}
.fondoClickRow{background-color: green;}
.fondoNoSelecRow{background-color: #737373;}
.fondoRowNuevo{background-color:#60abcb}
.fondoEditNuevo{background-color:#60abcb;width: 100px;}
.fondoEditExistente{background-color:white;width: 100px;}
.textPorcentaje{width: 100px;}
.ocultaTD{display: none;}
.funnelEscogerUsuario1{display: flex;justify-content: space-between;}
.funnelGrafica{display: flex}
   			@media only screen and (min-width:768px)
   			{
              	.divFunnel1{width:800px;}
              	.divFunnel2{width:600px;}
                .divFunnel3{width:500px;}
                .divFunnel4{width:450px;}
                .divFunnel4Emitido{width:425px;}
                .divFunnel5{width:401px;}

   			}
   			@media only screen and (max-width:768px)
   			{
   				.divFunnel5{width: 31%}
   				.divFunnel4Emitido{width: 35%}
   				.divFunnel4{width: 39%}
   				.divFunnel5{width:100px;}
   				.divFunnel4Emitido{width:125px;}
   				.divFunnel4{width:150px;}
   				.divFunnel3{width:200px;}
   				.divFunnel2{width:300px;}
   				.divFunnel1{width:500px;}


   				.funnelEscogerUsuario1{flex-direction: column;width: 100%}
   				.funnelGrafica{flex-direction: column;width: 100%}
   				.funnelGrafica>div:first-child{width: 100%;height: 150px;overflow: scroll;max-height: 150px}
   				.funnelGrafica>div:nth-child(1){width: 100%;height: 150px;overflow: scroll;max-height: 150px}   				
   				.form-control{width: 80%}
   			}
</style>
	<!--section class="container-fluid breadcrumb-formularios" >
		<div class="row">
			<div class="col-md-6 col-sm-5 col-xs-5"><h3 class="titulo-secciones">Prospeccion de negocios: Funnel de ventas</h3></div>
			
        </div>
		<hr /> 
	</section-->
	<div class="funnelEscogerUsuario1"><?= imprimirCoordinadores($coordinadores,$idCoordinador); ?><?= imprimirAgentes($agentes,$idAgente); ?></div><br>
	<!--section style="display:none">
		        <div class="row" align="right">
        	<div class="col-sm-12 col-md-12">
				<div class="form-group">
					<input type="button" value="Nuevo" onclick="F_append()" class="btn btn-primary"/>
					<input type="button" value="Guardar" onclick="F_guardar()"  class="btn btn-primary"/>
					<input type="button" value="Cancelar Nuevo" onclick="F_cancelar()"  class="btn btn-primary"/>
					<input type="button" value="borrar funnel" onclick="F_borrar()"  class="btn btn-primary"/>
                </div>
       	  	</div>
		</div>
	</section-->

    <!--section class="container-fluid" style="display:none">
        <div class="row">
        	<div class="col-sm-3 col-md-3">
				<div class="form-group">
					<label for="Vanio">año</label>
					<select id="Vanio" name="Vanio" class="form-control">
						<option value="2017">2017</option>
						<option value="2018">2018</option>
						<option value="2019">2019</option>
						<option value="2020">2020</option>
						<option value="2021">2021</option>
					</select>
                </div>
       	  	</div>
        	<div class="col-sm-3 col-md-3">
				<div class="form-group">
					<label for="Vmes">mes</label>
					<select id="Vmes" name="Vmes" class="form-control">
						<option>Enero</option>
						<option>Febrero</option>
						<option>Marzo</option>
						<option>Abril</option>
						<option>Mayo</option>
						<option>Junio</option>
						<option>Julio</option>
						<option>Agosto</option>
						<option>Septiembre</option>
						<option>Octubre</option>
						<option>Noviembre</option>
						<option>Diciembre</option>
					</select>
                </div>
       	  	</div>
        	<div class="col-sm-3 col-md-3">
				<div class="form-group">
					<label for="VobjetivoMensual">objetivo mensual</label>
					<input  type="text" id="VobjetivoMensual" name="VobjetivoMensual" class="form-control" value="9000" />
                </div>
       	  	</div>
        	<div class="col-sm-3 col-md-3">
				<div class="form-group">
					<label for="VcontratoCerrar">contrato a cerrar</label>
                    <input type="text" id="VcontratoCerrar" name="VcontratoCerrar" class="form-control" />
                </div>
       	  	</div>
		</div>
    </section-->    

			<!--div style="display: inline-flex;">
				<div style="width: 20%; margin-right:20%">
					<div>
								<table style="display:none" border="1" id="t_Funnel">
									<tr style="width: 300px">
										<td id="id" style="">id</td>
                                        <td id="anio">año</td>
										<td id="mes">mes</td>
										<td id="ticketProm" class="ocultaTD">ticket promedio</td>
										<td id="comision"  class="ocultaTD">comision</td>
										<td id="prospecto"  class="ocultaTD">prospecto</td>
										<td id="impacto"  class="ocultaTD">impacto</td>
										<td id="seguimiento"  class="ocultaTD">seguimiento</td>
										<td id="objetivoMensual"  class="ocultaTD">objetivo mensual</td>
										<td id="contratoCerrar"  class="ocultaTD">contrato cerrar</td>
										<td id="suspecto"  class="ocultaTD">suspecto</td>
										<td id="contactado"  class="ocultaTD">contactado</td>
										<td id="cotizado"  class="ocultaTD">cotizado</td>
										<td id="pagado"  class="ocultaTD">pagado</td>
										<td  class="ocultaTD" id="perfilado">perfilado</td>
										<td  class="ocultaTD" id="dimension">dimension</td>
									</tr>
									<? foreach ($datosfunnel as $informacion): ?>
									<tr onmouseover="cambiaFocoTabla(this)" class="fondoNoSelecRow" onclick="cambiaClickTabla(this)">
										<td><?= ($informacion->id) ?></td>
										<td><?= ($informacion->anio) ?></td>
										<td><?= ($informacion->mes) ?></td>
                                        <td class="ocultaTD"><?= ($informacion->ticketProm) ?></td>
										<td class="ocultaTD"><?= ($informacion->comision) ?></td>
										<td class="ocultaTD"><?= ($informacion->prospecto) ?></td>
										<td class="ocultaTD"><?= ($informacion->impacto) ?></td>
										<td class="ocultaTD"><?= ($informacion->seguimiento) ?></td>
										<td class="ocultaTD"><?= ($informacion->objetivoMensual) ?></td>
										<td class="ocultaTD"><?= ($informacion->contratoCerrar) ?></td>
										<td class="ocultaTD"><?= ($informacion->suspecto) ?></td>
										<td class="ocultaTD"><?= ($informacion->contactado) ?></td>
										<td class="ocultaTD"><?= ($informacion->cotizado) ?></td>
										<td class="ocultaTD"><?= ($informacion->pagado) ?></td>
										<td class="ocultaTD"><?= ($informacion->perfilado) ?></td>
										<td class="ocultaTD"><?= ($informacion->dimension) ?></td>
									</tr>
									<? endforeach ?>
								</table>
				</div>
				<div-->
                   
				</div>
			</div>
<div class="funnelGrafica">
	<div style="flex: 1">
<?php echo(imprimeClientPorMes($clientesPorMes,$nombreMeses)); ?>
</div>
			<div style="flex: 2">
				
<div class="divFunnel"><div class="divFunnel1"><!--label class="labelFunnel">Suspecto(Dimension)</label><br><input type="text" id="Vdimension" class="inputFunnel" value="<?php echo $ctSuspectos;?>"--><div class="ulFunnel" id="divDimension"></div></div></div>
<div class="divFunnel"><div class="divFunnel2"><!--label class="labelFunnel">Prospectos(Perfilados)</label><br><input type="text" id="Vperfilado" class="inputFunnel" value="<?php echo $ctPerfilados;?>"--><div class="ulFunnel" id="divPerfilado"></div></div></div>
<div class="divFunnel"><div class="divFunnel3"><!--label class="labelFunnel">Impacto(Contactado)</label><br><input type="text" id="Vcontactado" class="inputFunnel" value="<?php echo $ctContactados;?>"--><div class="ulFunnel" id="divContactado"></div></div></div>
<div class="divFunnel"><div class="divFunnel4"><!--label class="labelFunnel">Seguimiento(Cotizado)</label><br><input type="text" id="Vcotizado" class="inputFunnel" value="<?php echo $ctCotizados;?>"--><div class="ulFunnel" id="divCotizado"></div></div></div>
<div class="divFunnel"><div class="divFunnel4Emitido"><!--label class="labelFunnel">Seguimiento(Emitido)</label><br><input type="text" id="VcotizadoEmitido" class="inputFunnel" value="<?php echo $ctEmision;?>"--><div class="ulFunnel" id="divCotizadoEmitido"></div></div></div>
<div class="divFunnel"><div class="divFunnel5"><!--label class="labelFunnel">Cierre(Pagado)</label><br><input type="text" id="Vpagado" class="inputFunnel" value="<?php echo $ctPagados;?>"--><div class="ulFunnel" id="divPagado"></div></div></div>
</div>		    

</div>                               
</div>                      
<section style="display: none;">                                
					<table class="table">
						<tr>
							<td rowspan="5">
							</td>
							<td rowspan="5"></td>
							<td rowspan="5">
								<!--label style="font-size:250px">{</label-->
							</td>
							<td rowspan="5" style="width:auto">
								<!--select size="8" style="font-size:30px; overflow:hidden;">
									<option></option>
									<option id="Otn1">100%{</option>
									<option></option>
									<option id="Otn2">100%{</option>
									<option></option>
									<option id="Otn3">100%{</option>
									<option id="Otn4">100%{</option>
								</select-->
							</td>
							<td>
								<label class="letra">SUSPECTO</label>
								<img style="height: 70%;width: 100%" src="<?php echo base_url(); ?>assets/images/funnel/FUNNEL1.jpg">
							</td>
							<td>Suspecto</td>
							<td id="suspect"></td>
							<td><input type="text" id="Vsuspecto" class="textPorcentaje" />%</td>
							<!--td rowspan="5"><label style="font-size:200px">}</label--></td>
							<td rowspan="5" id="porFinal"></td>
							<td>Dimension</td>
							<td><input type="text" id="Vdimension"></td>
						</tr>
						<tr>
							<td>
								<label class="letra">PROSPECTO</label>
								<img style="height:70%; width:60%; display: block; margin-left: auto; margin-right: auto;" src="<?= base_url(); ?>assets/images/funnel/FUNNEL2.jpg">
							</td>
							<td>Prospecto</td>
							<td id="prospect"></td>
							<td><input type="text" id="Vprospecto" class="textPorcentaje"  />%</td>
							<td>Perfilados</td>
							<td><input type="text" id="Vperfilado"></td>
						</tr>
						<tr>
							<td>
								<label class="letra">IMPACTO</label>
                                <img style="height: 70%;width: 37%;display: block; margin-left: auto; margin-right: auto;" src="<?= base_url(); ?>assets/images/funnel/FUNNEL3.jpg">
							</td>
							<td>Impacto</td>
							<td id="impact"></td>
							<td><input type="text" id="Vimpacto" class="textPorcentaje"  />%</td>
							<td>Registrado/Contactado</td>
							<td><input type="text" id="Vcontactado"></td>
						</tr>
						<tr>
							<td>
								<label class="letra">SEGUIMIENTO</label>
								<img style="height: 70%;width: 23%;display: block; margin-left: auto; margin-right: auto; " src="<?= base_url(); ?>assets/images/funnel/FUNNEL4.jpg">
							</td>
							<td>Seguimiento</td>
							<td id="seguimient"></td>
							<td><input type="text" id="Vseguimiento" class="textPorcentaje" />%</td>
							<td>Cotizado</td>
							<td><input type="text" id="Vcotizado"></td>
						</tr>
						<tr>
							<td >
                            	<label class="letra">CIERRE</label>
                                <img style="height: 30%;width: 14%;display: block; margin-left: auto; margin-right:auto;" src="<?php echo base_url(); ?>assets/images/funnel/FUNNEL2.jpg">
							</td>
							<td>Cierre</td>
							<td id="cerrar"></td>
							<td></td>
							<td>Pagado</td>
							<td><input type="text" id="Vpagado"></td>
						</tr>
					</table>
				</div><!-- /table-responsive --> 
            </div><!-- panel-body -->
		</div><!-- panel-default -->
        
        <div class="row">
        	<div class="col-sm-4 col-md-4">
				<div class="form-group">
                </div><!-- /form-group -->
       	  	</div><!-- /col -->
        	<div class="col-sm-4 col-md-4">
				<div class="form-group">
					<label for="VticketProm">ticket promedio</label>
					<input id="VticketProm" name="VticketProm"  type="text" value="60000" class="form-control" />
                </div><!-- /form-group -->
       	  	</div><!-- /col -->
        	<div class="col-sm-4 col-md-4">
				<div class="form-group">
					<label for="Vcomision">comision</label>
					<div class="input-group">
					<input type="text" id="Vcomision" name="Vcomision" value="15" class="form-control" />
					<span class="input-group-btn">
						<button class="btn btn-primary">%</button>
					</span>
                    </div>
                </div><!-- /form-group -->
       	  	</div><!-- /col -->
		</div><!-- /row -->                
	</section><!-- /container-fluid -->
<?php $this->load->view('footers/footer'); ?>
<style>
.labelFunnel{transform: scale(2,2);position:relative;left:-100px;top:-80px;z-index:1;color: black}
.inputFunnel{transform: scale(1.5,1);position:relative;left:-100px;top:-80px;z-index:1;color: black;border: solid}
.ulFunnel{transform: scale(1.5,1);position:relative;z-index:5;color: black;border: solid;width: 50%;top:-180px;left: 10%;height: 100px ; border: none;}
.divFunnel{display:block}
.divFunnel1{height:0px;border-top:solid 180px red; border-left:solid 100px transparent;border-right:solid 100px transparent; border-radius: 50px; }
.divFunnel1:hover{ border-top:solid 180px #e05353;}
.divFunnel2{height:0px;border-top:solid 180px yellow;border-left:solid 50px transparent;border-right:solid 50px transparent;position:relative;left:100px;}
.divFunnel2:hover{ border-top:solid 180px #b6b664}
.divFunnel3{height:0px;border-top:solid 180px green;  border-left:solid 25px transparent;border-right:solid 25px transparent;position:relative;left:150px;}
.divFunnel3:hover{ border-top:solid 180px #72e372}
.divFunnel4{height:0px;border-top:solid 180px blue;border-left:solid 12.5px transparent;border-right:solid 12.5px transparent;position:relative;left:175px;}
.divFunnel4:hover{ border-top:solid 180px #8e8ee7}

.divFunnel4Emitido{height:0px;border-top:solid 180px #263859;border-left:solid 12.5px transparent;border-right:solid 12.5px transparent;position:relative;left:187px;}
.divFunnel4Emitido:hover{ border-top:solid 180px #264b59}

.divFunnel5{height:0px;border-top:solid 180px #593426;border-left:solid 6.25px transparent;border-right:solid 6.25px transparent;position:relative;left:199px;}
.divFunnel5:hover{ border-top:solid 180px #83695f}
.tableTr:hover{ background-color: green;   }
.tableTr:focus-within{ background-color: green;}
.classOprimir{ cursor: pointer; }
.contenedorProspectoFunnel{height:120px;width:auto;overflow-y:scroll;overflow-x: auto;display:flex;flex-direction:column}
</style>
<?php
function imprimeClientPorMes($datos,$nomMeses){

	    $anio=date("Y");$mes=date("m");
	    
	     if($mes!=10){$mes = str_replace("0","",$mes);}
	    
     $tabla='<table class="table"><thead><tr><th>Año</th><th style="display:none">Mes</th><th>Mes</th><th></th></tr></thead><tbody>';
     $tabla.='<tr class="tableTr">';
	     $tabla.='<td>'.$anio.'</td>';
	     $tabla.='<td style="display:none">'.$mes.'</td>';
	     $tabla.='<td>'.$nomMeses[$mes].'</td>';
	        $tabla.='<td><input type="radio" name="oprimir" class="classOprimir"  onclick="traerDatosFunnelMes('.$anio.','.$mes.',0)"></td>';
	     $tabla.='</tr>';
	foreach ($datos as  $value) 
	{
		if($value->anio!=$anio || $value->mes!=$mes)
		{
	     $tabla.='<tr class="tableTr" >';
	     $tabla.='<td>'.$value->anio.'</td>';
	     $tabla.='<td style="display:none">'.$value->mes.'</td>';
	     $tabla.='<td>'.$nomMeses[$value->mes].'</td>';
	        $tabla.='<td><input type="radio" name="oprimir" class="classOprimir" onclick="traerDatosFunnelMes('.$value->anio.','.$value->mes.',1)"></td>';
	     $tabla.='</tr>';		
		}

	}
	$tabla.='</tbody></table>';
	   
	return $tabla;
}
function imprimirCoordinadores($datos,$idCoordinador){
	
	$select='<div><select class="form-control" id="selectPersonaCoordinador" onchange="traeFunnelCoordinadores(\'\')">';
		$select.='<option value="0" >Escoge Coordinador</option>';
foreach ($datos as  $value) 
	{   
		if($value->idPersona==$idCoordinador)
		{
			$select.='<option value="'.$value->idPersona.'" selected>'.$value->nombres.' '.$value->apellidoPaterno.' ('.$value->email.')'.'</option>';
	    }
	    else{
	$select.='<option value="'.$value->idPersona.'">'.$value->nombres.' '.$value->apellidoPaterno.' ('.$value->email.')'.'</option>';
    }
}
$select.='</select></div>';
  	
return $select;
}
function imprimirAgentes($datos,$idAgente){
if((count($datos))>0){
	$select='<div><select class="form-control" id="selectAgentes" onchange="traeFunnelAgentes(\'\')">';
		$select.='<option value="0" >Escoge Agente</option>';

foreach ($datos as  $value) {
   if($value->idPersona==$idAgente)
   {$select.='<option value="'.$value->idPersona.'" selected>'.$value->nombres.' '.$value->apellidoPaterno.' ('.$value->email.')'.'</option>';

  	
   }
   else
   {
   	$select.='<option value="'.$value->idPersona.'" >'.$value->nombres.' '.$value->apellidoPaterno.' ('.$value->email.')'.'</option>';
   }
     
 }  
$select.='</select></div>';	
return $select;
 
}
}
?>
<?php
	function label_fecha_prospeccion($mes){
		$label='';
		$year=date('Y');
		switch($mes){
			case '01';
				$label='ENERO, '.$year;
				break;
			case '02';
				$label='FEBRERO, '.$year;
				break;
			case '03';
				$label='MARZO, '.$year;
				break;
			case '04';
				$label='ABRIL, '.$year;
				break;
			case '05';
				$label='MAYO, '.$year;
				break;
			case '06';
				$label='JUNIO, '.$year;
				break;
			case '07';
				$label='JULIO, '.$year;
				break;
			case '08';
				$label='AGOSTO, '.$year;
				break;
			case '09';
				$label='SEPTIEMBRE, '.$year;
				break;
			case '10';
				$label='OCTUBRE, '.$year;
				break;
			case '11';
				$label='NOVIEMBRE, '.$year;
				break;
			case '12';
				$label='DICIEMBRE, '.$year;
				break;
		}
		return $label;
	}
?>
<br>
<hr>
<br>
<?php 
 $usermail=$this->tank_auth->get_usermail();  
 if(($usermail=="DIRECTORGENERAL@AGENTECAPITAL.COM")||($usermail=='COORDINADORCOMERCIAL@FIANZASCAPITAL.COM')){?>
<section class="container-fluid breadcrumb-formularios" >
	<div class="row">
		<div class="col-md-6 col-sm-6 col-xs-6">
			<h3 class="titulo-secciones">Prospección de Fianzas</h3>
			<br>
			<p>
				<label>Seleccione un mes:</label>
				<select id="mesFianzas" name="mes" onchange="filtroProspeccionFianzas(this)">
					<option value="<?php echo date('m');?>"><?php echo label_fecha_prospeccion(date('m'));?></option>
					<option value="01">ENERO<?php echo ', '.date('Y')?></option>
					<option value="02">FEBRERO<?php echo ', '.date('Y')?></option>
					<option value="03">MARZO<?php echo ', '.date('Y')?></option>
					<option value="04">ABRIL<?php echo ', '.date('Y')?></option>
					<option value="05">MAYO<?php echo ', '.date('Y')?></option>
					<option value="06">JUNIO<?php echo ', '.date('Y')?></option>
					<option value="07">JULIO<?php echo ', '.date('Y')?></option>
					<option value="08">AGOSTO<?php echo ', '.date('Y')?></option>
					<option value="09">SEPTIEMBRE<?php echo ', '.date('Y')?></option>
					<option value="10">OCTUBRE<?php echo ', '.date('Y')?></option>
					<option value="11">NOVIEMBRE<?php echo ', '.date('Y')?></option>
					<option value="12">DICIEMBRE<?php echo ', '.date('Y')?></option>
				</select>
			</p>
		</div>
		<div class="col-md-6 col-sm-6 col-xs-6">
			<br><br><br><br><br><br>
			<div id="divFunnelFianzas" style="width:100%;">
				<?php $this->load->view('funnel/fianzas')?>
			</div>
		</div>
    </div>
</section>

<br><br>
<br>
<hr>
<br>
<br><br>

<?php 
}
 if(($usermail=="DIRECTORGENERAL@AGENTECAPITAL.COM")||($usermail=='DIRECTORCOMERCIAL@AGENTECAPITAL.COM')||
($usermail=='MARKETING@AGENTECAPITAL.COM') || ($usermail=='SISTEMAS@ASESORESCAPITAL.COM') || ($usermail=='COORDINADOR@CAPCAPITAL.COM.MX') || ($usermail=='CORDINADORCOMERCIAL@CAPCAPITAL.COM.MX')){?>
<section class="container-fluid breadcrumb-formularios" >
	<div class="row">
		<div class="col-md-6 col-sm-6 col-xs-6">
			<h3 class="titulo-secciones">Prospección de Agentes</h3>
			<br>
			<div class="col-md-12">
				<div class="form-group">
					<label for="coordinator" class="control-label">Seleccione a un coordinador</label>
					<select name="selectCoordinator" id="selectCoordinator">
						<?php if(count($coor) > 1){ echo '<option value="">TODOS</option>'; }?>
						<!--<option value="">TODOS</option>-->
						<?= array_reduce($coor, function($acc, $cur){
							$acc .= "<option value='".strtolower($cur)."'>".$cur."</option>";
							return $acc;
						}, ""); ?>
					</select>
				</div>
			</div>
			<div class="col-md-12">
				<p>
					<label>Seleccione un mes:</label>
					<select id="mesAgentes" name="mes">
					<!--<select id="mesAgentes" name="mes" onchange="filtroProspeccionAgentes(this)">-->
						<option value="<?php echo date('m');?>"><?php echo label_fecha_prospeccion(date('m'));?></option>
						<option value="01">ENERO<?php echo ', '.date('Y')?></option>
						<option value="02">FEBRERO<?php echo ', '.date('Y')?></option>
						<option value="03">MARZO<?php echo ', '.date('Y')?></option>
						<option value="04">ABRIL<?php echo ', '.date('Y')?></option>
						<option value="05">MAYO<?php echo ', '.date('Y')?></option>
						<option value="06">JUNIO<?php echo ', '.date('Y')?></option>
						<option value="07">JULIO<?php echo ', '.date('Y')?></option>
						<option value="08">AGOSTO<?php echo ', '.date('Y')?></option>
						<option value="09">SEPTIEMBRE<?php echo ', '.date('Y')?></option>
						<option value="10">OCTUBRE<?php echo ', '.date('Y')?></option>
						<option value="11">NOVIEMBRE<?php echo ', '.date('Y')?></option>
						<option value="12">DICIEMBRE<?php echo ', '.date('Y')?></option>
					</select>
				</p>
			</div>
			<div class="col-md-12">
				<button class="btn btn-primary btn-xs" id="prospectiveAgentsFilter" onclick="executeFilter()">Realizar filtrado</button>
			</div>
			<div class="col-md-12 progress-content table-responsive">
				<?php if(!empty($progressProspective)){?>
					<br>
				<h6>Progreso de los agentes en prospección</h6>
				<table class="table">
					<tbody>
						<tr>
							<?php foreach($progressProspective as $type => $data){?>
								<td class="<?=strtolower($type)?>">
									<div class="col-md-12">
										<h6><?=$type?></h6>
									</div>
									<div class="col-md-12">
										
											<table class="table table-sm">
												<thead>
													<tr>
														<th>Nombre</th>
														<th><?=($type != "ACTUALIZAR" ? "Fecha de actualización" : "Pendiente")?></th>
													</tr>
												</thead>
												<tbody>
												<?php foreach($data as $d_pa){?>
													<tr>
														<td><p style="font-size: 10px"><?=$d_pa["name"]?></p></td>
														<td><p style="font-size: 10px"><?=($type != "ACTUALIZAR" ? $d_pa["date"] : "Formulario")?></p></td>
													</tr>
												<?php }?>
												</tbody>
											</table>
										
									</div>
								</td>
							<?php }?>
						</tr>
					</tbody>
				</table>
				<?php } else{ 
					echo "No hay agentes en categoria de avance en documentación o inducción."; 
					}?>
			</div>
			<!--<p>
				<label>Seleccione un mes:</label>
				<select id="mesAgentes" name="mes" onchange="filtroProspeccionAgentes(this)">
					<option value="<?php echo date('m');?>"><?php echo label_fecha_prospeccion(date('m'));?></option>
					<option value="01">ENERO<?php echo ', '.date('Y')?></option>
					<option value="02">FEBRERO<?php echo ', '.date('Y')?></option>
					<option value="03">MARZO<?php echo ', '.date('Y')?></option>
					<option value="04">ABRIL<?php echo ', '.date('Y')?></option>
					<option value="05">MAYO<?php echo ', '.date('Y')?></option>
					<option value="06">JUNIO<?php echo ', '.date('Y')?></option>
					<option value="07">JULIO<?php echo ', '.date('Y')?></option>
					<option value="08">AGOSTO<?php echo ', '.date('Y')?></option>
					<option value="09">SEPTIEMBRE<?php echo ', '.date('Y')?></option>
					<option value="10">OCTUBRE<?php echo ', '.date('Y')?></option>
					<option value="11">NOVIEMBRE<?php echo ', '.date('Y')?></option>
					<option value="12">DICIEMBRE<?php echo ', '.date('Y')?></option>
				</select>
			</p>-->
		</div>
		<div class="col-md-6 col-sm-6 col-xs-6">
			<br><br><br><br><br><br>
			<div id="divFunnelAgentes" style="width:100%;">
				<?php $this->load->view('funnel/agentes')?>
			</div>
		</div>
    </div>
</section>
<?php }
?>

<br><br>
<hr><br>
<br><br>

<?php 

 if(($usermail=="DIRECTORGENERAL@AGENTECAPITAL.COM")||($usermail=='DIRECTORCOMERCIAL@AGENTECAPITAL.COM')||
($usermail=='MARKETING@AGENTECAPITAL.COM')){?>
<section class="container-fluid breadcrumb-formularios" >
<div class="row">
	<div class="col-md-6 col-sm-6 col-xs-6">
			<h3 class="titulo-secciones">Prospección de Marketing</h3>
			<br>
			<p>
				<label>Seleccione un mes:</label>
				<select id="mesMarketing" name="mes" onchange="filtroEstadisticaMarketing(this)">
					<option value="<?php echo date('m');?>"><?php echo label_fecha_prospeccion(date('m'));?></option>
					<option value="01">ENERO<?php echo ', '.date('Y')?></option>
					<option value="02">FEBRERO<?php echo ', '.date('Y')?></option>
					<option value="03">MARZO<?php echo ', '.date('Y')?></option>
					<option value="04">ABRIL<?php echo ', '.date('Y')?></option>
					<option value="05">MAYO<?php echo ', '.date('Y')?></option>
					<option value="06">JUNIO<?php echo ', '.date('Y')?></option>
					<option value="07">JULIO<?php echo ', '.date('Y')?></option>
					<option value="08">AGOSTO<?php echo ', '.date('Y')?></option>
					<option value="09">SEPTIEMBRE<?php echo ', '.date('Y')?></option>
					<option value="10">OCTUBRE<?php echo ', '.date('Y')?></option>
					<option value="11">NOVIEMBRE<?php echo ', '.date('Y')?></option>
					<option value="12">DICIEMBRE<?php echo ', '.date('Y')?></option>
				</select>
			</p>
		</div>
<div class="col-md-12 col-sm-12 col-xs-12">
<p>
<div id="divEstadisticaMarketing" style="width:100%;">
	<?php $this->load->view('funnel/estadistica_marketing');?>
</div>
</p>
	
</section>

<?php 
}?>

