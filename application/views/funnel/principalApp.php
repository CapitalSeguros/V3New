<style type="text/css">html,body{ overflow-x: hidden;}</style>
<style>
.letra{width: 210px;background-color:black;display:block; margin-left:auto; margin-right:auto;position:relative; left:150px;top:30px;height:0px;background: black;font-size: 18px;color: black}
.trapecio-top {  width:210px;height:0px;border-right: 30px solid transparent;border-left: 30px solid transparent;
border-top: 50px solid #428bca;padding-left:50px;display:block; margin-left:auto; margin-right:auto}
.trapecio-top1 {width: 150px;height:0px;border-right: 30px solid transparent;border-left: 30px solid transparent;
border-top: 50px solid #428bca;padding-left:50px;display:block; margin-left:auto; margin-right:auto}
.trapecio-top2 {width: 90px;height:0px;border-right: 30px solid transparent;border-left: 30px solid transparent;
border-top: 50px solid #428bca;padding-left:50px;display:block; margin-left:auto; margin-right:auto}
.trapecio-top3 {width: 30px;height:0px;border-right: 30px solid transparent;border-left: 30px solid transparent;
border-top: 50px solid #428bca;padding-left:50px;display:block; margin-left:auto; margin-right:auto}
.trapecio-top4 {width: 10px;height:0px;border-right: 30px solid transparent;border-left: 30px solid transparent;
border-top: 50px solid #428bca;padding-left:50px;display:block; margin-left:auto; margin-right:auto}
.fondoSelecRow{background-color: blue;	}
.fondoClickRow{background-color: green;}
.fondoNoSelecRow{background-color: #737373;}
.fondoRowNuevo{background-color:#60abcb}
.fondoEditNuevo{background-color:#60abcb;width: 100px;}
.fondoEditExistente{background-color:white;width: 100px;}
.textPorcentaje{width: 100px;}
.ocultaTD{display: none;}
</style>

	<section><?= imprimirCoordinadores($coordinadores,$idCoordinador); ?><?= imprimirAgentes($agentes,$idAgente); ?></section><br>
	<section style="display:none">
		        <div class="row" align="right">
        	<div class="col-sm-12 col-md-12">
				<div class="form-group">
					<input type="button" value="Nuevo" onclick="F_append()" class="btn btn-primary"/>
					<input type="button" value="Guardar" onclick="F_guardar()"  class="btn btn-primary"/>
					<input type="button" value="Cancelar Nuevo" onclick="F_cancelar()"  class="btn btn-primary"/>
					<input type="button" value="borrar funnel" onclick="F_borrar()"  class="btn btn-primary"/>
                </div><!-- /form-group -->
       	  	</div><!-- /col -->
		</div><!-- /row -->
	</section>

    <section class="container-fluid" style="display:none"><!-- container-fluid -->
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
                </div><!-- /form-group -->
       	  	</div><!-- /col -->
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
                </div><!-- /form-group -->
       	  	</div><!-- /col -->
        	<div class="col-sm-3 col-md-3">
				<div class="form-group">
					<label for="VobjetivoMensual">objetivo mensual</label>
					<input  type="text" id="VobjetivoMensual" name="VobjetivoMensual" class="form-control" value="9000" />
                </div><!-- /form-group -->
       	  	</div><!-- /col -->
        	<div class="col-sm-3 col-md-3">
				<div class="form-group">
					<label for="VcontratoCerrar">contrato a cerrar</label>
                    <input type="text" id="VcontratoCerrar" name="VcontratoCerrar" class="form-control" />
                </div><!-- /form-group -->
       	  	</div><!-- /col -->
		</div><!-- /row -->
    </section>    



			<div style="display: inline-flexx;">
				<div style="width: 20%; margin-right:20%">
                	<div>
								<table style="display:none" border="1" id="t_Funnel">
									<tr style="width: 200px">
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
					<div>
						<?php echo(imprimeClientPorMes($clientesPorMes,$nombreMeses)); ?>
					</div>
				</div>

				<div style="width: 100%">
				
					<div class="divFunnel"><div class="divFunnel1"><label class="labelFunnel">Suspecto(Dimension)</label><br><input type="text" id="Vdimension" class="inputFunnel"><div class="ulFunnel" id="divDimension"></div></div></div>
					<div class="divFunnel"><div class="divFunnel2"><label class="labelFunnel">Prospectos(Perfilados)</label><br><input type="text" id="Vperfilado" class="inputFunnel"><div class="ulFunnel" id="divPerfilado"></div></div></div>
					<div class="divFunnel"><div class="divFunnel3"><label class="labelFunnel">Impacto(Contactado)</label><br><input type="text" id="Vcontactado" class="inputFunnel"><div class="ulFunnel" id="divContactado"></div></div></div>
					<div class="divFunnel"><div class="divFunnel4"><label class="labelFunnel">Seguimiento(Cotizado)</label><br><input type="text" id="Vcotizado" class="inputFunnel"><div class="ulFunnel" id="divCotizado"></div></div></div>
					<div class="divFunnel"><div class="divFunnel5"><label class="labelFunnel">Cierre(Pagado)</label><br><input type="text" id="Vpagado" class="inputFunnel"><div class="ulFunnel" id="divPagado"></div></div></div>
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
								<img style="height: 70%;width: 80%" src="<?php echo base_url(); ?>assets/images/funnel/FUNNEL1.jpg">
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
								<img style="height:70%; width:50%; display: block; margin-left: auto; margin-right: auto;" src="<?= base_url(); ?>assets/images/funnel/FUNNEL2.jpg">
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
                                <img style="height: 70%;width: 27%;display: block; margin-left: auto; margin-right: auto;" src="<?= base_url(); ?>assets/images/funnel/FUNNEL3.jpg">
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
								<img style="height: 70%;width: 13%;display: block; margin-left: auto; margin-right: auto; " src="<?= base_url(); ?>assets/images/funnel/FUNNEL4.jpg">
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
                                <img style="height: 30%;width: 9%;display: block; margin-left: auto; margin-right:auto;" src="<?php echo base_url(); ?>assets/images/funnel/FUNNEL2.jpg">
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
.labelFunnel{transform: scale(2,2);position:relative;left:-10px;top:-80px;z-index:1;color: black}
.inputFunnel{transform: scale(1.5,1);position:relative;left:-10px;top:-80px;z-index:1;color: black;border: solid}
.ulFunnel{transform: scale(1.5,1);position:relative;z-index:5;color: black;border: solid;width: 40%;top:-160px;left: 170px;height: 100px;overflow-y: scroll; ; border: none;}
.divFunnel{display:block}
.divFunnel1{width:700px;height:0px;border-top:solid 120px red; border-left:solid 100px transparent;border-right:solid 100px transparent; border-radius: 50px; }
.divFunnel1:hover{ border-top:solid 120px #e05353;}
.divFunnel2{width:500px;height:0px;border-top:solid 120px yellow;border-left:solid 50px transparent;border-right:solid 50px transparent;position:relative;left:100px;}
.divFunnel2:hover{ border-top:solid 120px #b6b664}
.divFunnel3{width:400px;height:0px;border-top:solid 120px green;  border-left:solid 25px transparent;border-right:solid 25px transparent;position:relative;left:150px;}
.divFunnel3:hover{ border-top:solid 120px #72e372}
.divFunnel4{width:350px;height:0px;border-top:solid 120px blue;border-left:solid 12.5px transparent;border-right:solid 12.5px transparent;position:relative;left:175px;}
.divFunnel4:hover{ border-top:solid 120px #8e8ee7}
.divFunnel5{width:325px;height:0px;border-top:solid 120px #593426;border-left:solid 6.25px transparent;border-right:solid 6.25px transparent;position:relative;left:187.5px;}
.divFunnel5:hover{ border-top:solid 120px #83695f}
.tableTr:hover{ background-color: green;   }
.tableTr:focus-within{ background-color: green;}
.classOprimir{ cursor: pointer; }
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
		if($value->anio!=$anio && $value->mes!=$mes)
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
	
	$select='<select id="selectPersonaCoordinador" onchange="traeFunnelCoordinadores(\'\')">';
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
$select.='</select>';
  	
return $select;
}
function imprimirAgentes($datos,$idAgente){
if((count($datos))>0){
	$select='<select id="selectAgentes" onchange="traeFunnelAgentes(\'\')">';
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
$select.='</select>';	
return $select;
 
}
}
?>