<?
?>
<!DOCTYPE html>
<html lang="es">
<script>
</script>
<? $this->load->view("headers/app/main_header") ?>

<body>

<!-- Page container -->
<div class="page-container">

	<? $this->load->view("headers/app/page_sidebar") ?>
  
	<!-- Main container -->
	<div class="main-container gray-bg">
  
		<!-- Main header -->
		<div class="main-header row">
			<div class="col-sm-6 col-xs-7">
			<? $this->load->view("headers/app/user_info") ?>
			</div>
			
			<div class="col-sm-6 col-xs-5">
			<div class="pull-right">
			<? $this->load->view("headers/app/user_alerts") ?>
			</div>
			</div>
		</div>
		<!-- /main header -->
		
		<!-- Main content -->
		<div class="main-content">
        
			<h1 class="page-title">Actividades</h1>
			<!-- Breadcrumb -->
			<ol class="breadcrumb breadcrumb-2"> 
				<li><a href="<?= base_url();?>"><i class="fa fa-home"></i>Home</a></li> 
				<li>Actividades</li>
				<li class="active"><strong>Consultar</strong></li>
			</ol>
			<hr />
			<a href="https://www.dropbox.com/sh/3txhtwzoketivnz/AABSWpAhQXuqTpiPfv_rDvGxa/COTIZADORES?dl=0" title="Clic Aqui - Descargar Cotizadores" target="_blank"><b>Cotizadores</b></a>
			<hr />

			<div class="row">
				<div class="col-lg-12">
					<!-- <div class="panel panel-default"> -->
					<div class="panel panel-default">
						<!-- panel heading -->
						<div class="panel-heading clearfix">
							<div class="row" style="padding-bottom:5px;"><!-- Botones de Accion General -->
								<div class="col-sm-12 col-md-12" align="right">
									<input 
										type="button" value="Exportar Historial" 
										title="Exportar Historial de Activiades - Clic Aqu&iacute;" 
										onclick="window.open('actividades/ExportaHistorial','_self');" 
										class="btn btn-primary btn-sm"
									/>
                                    &nbsp;
									<input
										type="button" value="Actualizar Actividad"
										title="Actualizar Actividad - Clic Aqu&iacute;"                                               
										onclick="window.open('actualizaActividades/actualizaactividadesporvendedor','_self');"
										class="btn btn-primary btn-sm"
									/>
                                </div>
							</div>
                            
							<div class="row"><!-- Buscador de Folio -->
								<div class="col-sm-12 col-md-12" align="right">
									<form
										class="form-horizontal" role="form"
										id="formActividadBuscarFolio" name="formActividadBuscarFolio"
										method="post" enctype="multipart/form-data"
										action="<?=base_url()?>actividades/busqueda"
									>
									<div class="input-group" style="width:50%;">
										<input
											id="folioBuscado" name="folioBuscado" 
											type="text" class="form-control input-sm"
											placeholder="Buscar Folio"
										>
										<span class="input-group-btn">
											<button class="btn btn-primary btn-sm search-trigger"><i class="fa fa-search fa-sm"></i>&nbsp;</button>
										</span>
									</div>
									<input
										type="hidden"
										id="usuarioCreacion" name="usuarioCreacion"
										value="<?=$this->tank_auth->get_usermail()?>"
									/>
									</form>
								</div>
							</div>
						</div><!-- /panel-heading -->

						<!-- panel body -->
						<div class="panel-body">
<!-- -->
							<div class="row">
								<div>
                                	<label class="tituloAgente"><a name="seccionAgente">Agentes</a></label>
                                </div>
                            </div>
							<div class="row">
								<div class="table-responsive">
									<!--
                                    <form
										role="form" class="form-horizontal" name="formTrabajandoAgenteCapital" id="formTrabajandoAgenteCapital"  
										method="post" enctype="multipart/form-data" 
										action="<?=base_url()?>actividades/todas"
									>
										<input type="hidden" name="tipo" id="tipo" />
										<div class="clearfix" style="float:left;">
                                        	<font class="subTituloSeccione"></font>
										</div>
									-->
                                        <!--
										<div>
											<font style="float:right;">
											<input type="button" onclick="seleccionar_todo(this.form)" value="Marcar todos" class="btn btn-info" />
											&nbsp;
											<input type="button" onclick="deseleccionar_todo(this.form)" value="Marcar ninguno" class="btn btn-info" />
											&nbsp;
											<input type="button" onclick="todas(this.form, 'terminarTodas')" value="Cerrar las seleccionadas" class="btn btn-danger"/>
											</font>
										</div>
                                        -->
									<?
										// <!-- Agentes -->
										foreach($actividadesNoTrabajandose as $key => $value){
									?>
										<table class="table table-striped table-bordered table-sm">
											<thead>
												<tr scope="row">
													<div class="clearfix" style="float:left;">
														<font class="subTituloSeccione">
															<a class="btn<?= $key; ?>" name="<?= $key; ?>"> <?= $key ?></a>
														</font>
													</div>
												</tr>
												<tr scope="row" bgcolor="#A391C0" valign="top">
                                                	<th scope="col">Folio</th>
                                                    <th scope="col">Fecha recepcion</th>
                                                    <th scope="col">Estado</th>
                                                    <th scope="col">Fecha</th>
                                                    <th scope="col">Actividad</th>
                                                    <th scope="col">SubRamo</th>
                                                    <th scope="col">Cliente</th>
													<th scope="col">Califica/Finaliza</th>
												</tr>
											</thead>
											<tbody>
											<?
											$contCheckbox = 0;
											foreach($actividadesNoTrabajandose[$key] as $row){
												$contCheckbox++;
												$semaforoNew	= "";
												$clase			= "classParaAgente";						

											?>
												<tr scope="row" style="font-size:12px;">
													<td scope="col" align="center">
														<a href="<?= base_url().'actividades/ver/'.$row->folioActividad?>" title="<?=$row->datosExpres ?>">
															<div class="<?= $clase ?>">
																<?= $row->folioActividad."<br />" ?>
                                								<font style="font-size:9px;"><?= ($row->tipoActividadSicas=="tarea")?$row->idSicas:$row->NumSolicitud ?></font>
                                							</div>
														</a>
													</td>
													<td scope="col"><?= $this->capsysdre_actividades->fechaHoraEspActividades($row->fechaActualizacionStatus,'')?></td>
													<td scope="col"><?=$row->Status_Txt?></td>
													<td 
														scope="col" 
														title="<?= 'Fecha Actualizaci&oacute;n\n'.$this->capsysdre_actividades->fechaHoraEspActividades($row->fechaActualizacion,'title') ?>"
													>
														<?= $this->capsysdre_actividades->fechaHoraEspActividades($row->fechaCreacion,'') ?>
													</td>	
													<td scope="col">
														<? if($row->inicio==1){?><font style="color:blue; font-weight:bold;"/>Cotizacion</font><? } ?>
														<? if($row->fechaEmite != ""){ ?><font style="color:#00F;"><strong>Emision</strong></font><? } ?>
														<br />
														<?= $row->tipoActividad ?>
														<font style="color:red; font-weight:bold;"/><?=($row->actividadUrgente==1)?" &bull; Urgente !!!":""?></font>
														<? if( $row->actividadImportante == "1" ){ ?>
														<br />
														<font style="color:red; font-weight:bold;">!!! ACTIVIDAD IMPORTANTE !!!</font>
														<? } ?>
													</td>
													<td scope="col"><?=$row->subRamoActividad?></td>
													<td>
														<?
														print($row->nombreCliente);
														if($row->usuarioVendedor != Null){
															if($row->usuarioVendedor != $row->usuarioCreacion){
																print('<br /><b>Creador:</b>'.$row->nombreUsuarioCreacion);
																print('&nbsp;['.$row->usuarioCreacion.']&nbsp;');
															}
															print('<br /><b>Vendedor:</b>'.$row->nombreUsuarioVendedor);
															print('&nbsp;['.$row->usuarioVendedor.']&nbsp;');
															$informacion=$this->capsysdre->devolverDatosActividades($row->usuarioVendedor);
															if(count($informacion)>0){
																print('<br />('.$informacion[0]->idpersonarankingagente.')');
																print($informacion[0]->personaTipoAgente);
															}
														} else {
															print('<br /><b>Creador:</b>'.$row->usuarioCreacion);
															print('&nbsp;['.$row->usuarioCreacion.']&nbsp;');
															$informacion=$this->capsysdre->devolverDatosActividades($row->usuarioCreacion);
															if(count($informacion)>0){
																print('<br />('.$informacion[0]->idpersonarankingagente.')');
																print($informacion[0]->personaTipoAgente); 
															}
														}
														?>
													</td>
													<td scope="col" align="center">
														<? if($row->satisfaccion == ""){ ?>
															<a 
                                                            	href="
																		<?=
																		base_url()
																		.'actividades/calificarActividad?folioActividad='
																		.$row->folioActividad
																		.'&satisfaccion=bueno&tipoActividad=Actividad&IDDocto='
																		.$row->idSicas
																		.'&ClaveBit='
																		.$row->ClaveBit 
																		?>
																	" 
                                                                data-toggle="modal" 
                                                                title="Califica Bien y Finaliza"
															>
															<span 
																class="glyphicon glyphicon-thumbs-up" 
																style="font-size: 35px; color: green; margin-right: 15px;margin-left: 0px" 
																onmouseout="this.style.color='green';" 
                                                                onmouseover="this.style.color='#000000';"
															>
															</span>
															</a>
                                                            
															<a 
																href="
																		<?=
																		base_url()
																		.'actividades/calificarActividad?folioActividad='
																		.$row->folioActividad
																		.'&satisfaccion=malo&tipoActividad=Actividad&IDDocto='
																		.$row->idSicas
																		.'&ClaveBit='
																		.$row->ClaveBit
																		?>
																	" 
																data-toggle="modal" 
																title="Califica Mal y Finaliza" 
																onclick="calificacionMala(event,this)"
															>
															<span 
																class="glyphicon glyphicon-thumbs-down" 
																style="font-size: 35px;color: red" 
																onmouseout="this.style.color='red';" 
																onmouseover="this.style.color='#000000';" 
															>
															</span>
															</a>
														<? } else { ?>
															<a 
																title="Actividad Calificada"
															>
																<span class="glyphicon glyphicon glyphicon-ok-sign"> </span>
															</a>
															<a 
																href="<?=base_url()."actividades/terminar/".$row->folioActividad."?IDDocto=".$row->idSicas."&ClaveBit=".$row->ClaveBit?>" 
																title="Terminar la Actividad del Sistema"
															>
																<span class="glyphicon glyphicon-trash"></span> 
															</a>
														<? } ?>
													</td>
													<td scope="col" align="center">
														<input type="checkbox" name="ch[]" value="<?=$row->idSicas."|".$row->ClaveBit."|".$row->folioActividad?>">
													</td>
												</tr>
											<?
											}
											?>
											</tbody>
										</table>
									<?
										}
									?>
                                    <!--
                                    </form>
                                    -->
								</div>
							</div>
							<!-- -->
                            <br>
							<!-- -->
							<div class="row">
								<div>
									<label class="tituloAgente"><a name="seccionEnCurso">En curso</a></label>
                                </div>
							</div>
                            <div class="row">
                                <div class="table-responsive">
                                <!--
								<input type="hidden" name="tipo" id="tipo" />
                                -->
								<?
									// <!-- En curso -->
									foreach ($ActividadesTrabajandose as $key => $value) { 
								?>
									<table class="table table-striped table-bordered table-sm">
										<thead>
											<tr scope="row">
												<div class="clearfix" style="float:left;">
													<font class="subTituloSeccione">
														<a class="btnRamo<?= $key; ?>" name="<?= $key; ?>"> <?= $key ?></a>
													</font>
												</div>
											</tr>
											<tr scope="row" bgcolor="#A391C0" valign="top">
												<th scope="col">Folio</th>
												<th scope="col">Fecha recepcion</th>
												<th scope="col">Aseguradoras</th>
												<th scope="col">Estado</th>
												<th scope="col">Fecha</th>
												<th scope="col">Actividad</th>
												<th scope="col">SubRamo</th>
												<th scope="col">Cliente</th>
											</tr>
										</thead>
										<tbody>
										<?
											if($ActividadesTrabajandose != false){
												$contCheckbox = 0;
												foreach($ActividadesTrabajandose[$key] as $row){
													$contCheckbox++;
													$semaforoNew	= "";
													$clase			= controlaSemaforos($row->tiempoSemaforo,$row->Status,$row->horasOficinaCP,$row->horasPortalCP,$row->tipoActividad);
										?>
											<tr scope="row" style="font-size:12px;">
												<td scope="col" align="center">
													<a href="<?=base_url()."actividades/ver/".$row->folioActividad?>" title="<?=$row->datosExpres?>">
                            							<div class="<?= $clase ?>">
															<?= $row->folioActividad."<br />" ?>
															<font style="font-size:9px;"> <?=($row->tipoActividadSicas=="tarea")?$row->idSicas:$row->NumSolicitud?></font>
														</div>
													</a>
												</td>
												<td scope="col"><?=$this->capsysdre_actividades->fechaHoraEspActividades($row->fechaActualizacionStatus,'')?></td>
												<td scope="col"  class="divPromotoria"><div>Aseguradoras</div><p><?=$row->promotorias ;?></p></td>
												<td scope="col"><?=$row->Status_Txt?></td>
												<td scope="col" title="<?="Fecha Actualizaci&oacute;n\n".$this->capsysdre_actividades->fechaHoraEspActividades($row->fechaActualizacion,'title')?>"><?=$this->capsysdre_actividades->fechaHoraEspActividades($row->fechaCreacion,'')?>
												</td>	
												<td scope="col">
								<? if($row->inicio==1){?><font style="color:blue; font-weight:bold;"/>Cotizacion</font><?php } ?>
                            	<? if($row->fechaEmite != ""){ ?><font style="color:#00F;"><strong>Emision</strong></font><? } ?>
                                <br />
								<?=$row->tipoActividad?>
                                <font style="color:red; font-weight:bold;"/><?=($row->actividadUrgente==1)?" &bull; Urgente !!!":""?></font>
								<? if( $row->actividadImportante == "1" ){ ?>
                                <br />
                                <font style="color:red; font-weight:bold;">!!! ACTIVIDAD IMPORTANTE !!!</font>
                                <?php } ?>
                                <?
									if( $row->actividadImportante == "0" && $clase=="tiempoExcedido"){
										if($row->RamosNombre!='VEHICULOS'){
								?>
                                <br />
                                <font style="color:red; font-weight:bold; font-size:8px;">
								<a 
                                	href="<?=base_url().'actividades/marcarImportante?folioActividad='.$row->folioActividad; ?>"
									data-original-titletitle="Clic - Para convertir la actividad en Importante !!!"
                                    style="color:#FFF"
                                    class="btn btn-danger"
								>!!! ESCALAR !!!</a>
                                </font>
                                <?
									}}
								?>
												</td>
												<td scope="col"><?=$row->subRamoActividad?></td>
												<td>
								<?
									print($row->nombreCliente);
									if($row->usuarioVendedor != Null){
										if($row->usuarioVendedor != $row->usuarioCreacion){
										print("<br /><b>Creador:</b>".$row->nombreUsuarioCreacion);
											print("&nbsp;[".$row->usuarioCreacion."]&nbsp;");
										}
										print("<br /><b>Vendedor:</b>".$row->nombreUsuarioVendedor);
										print("&nbsp;[".$row->usuarioVendedor."]&nbsp;");
										$informacion=$this->capsysdre->devolverDatosActividades($row->usuarioVendedor);
										if(count($informacion)>0){
										print("<br />(".$informacion[0]->idpersonarankingagente.")");
										print($informacion[0]->personaTipoAgente);                                            
                                           }
									} else {
										print("<br /><b>Creador:</b>".$row->usuarioCreacion);
										print("&nbsp;[".$row->usuarioCreacion."]&nbsp;");
										$informacion=$this->capsysdre->devolverDatosActividades($row->usuarioCreacion);
										if(count($informacion)>0){
										print("<br />(".$informacion[0]->idpersonarankingagente.")");
										print($informacion[0]->personaTipoAgente); 
                                       }
									}
								?>
												</td>
											</tr>
										<?
												}
											}
										?>
										</tbody>
									</table>


								<? } ?>
                                </div>
							</div>
<!-- -->
						</div><!-- /panel-body -->
					</div>
                        
				</div>
			</div>
            
		<? $this->load->view("footers/app/div_footer-main") ?>
		
	  </div>
	  <!-- /main content -->
	  
  </div>
  <!-- /main container -->
  
</div>
<!-- /page container -->

<!-- Menu Flotante -->
<div class="contMenuFlotante"> 
	<div class="vertical-menu"><?= (imprimirBotonesRamos($ramos)); ?></div>
</div>
<!-- /Menu Flotante -->

<? $this->load->view("footers/app/main_footer") ?>
</body>
<?php

	function imprimirBotonesRamos($datosRamo)
	{
		$boton="";
		$boton.='<a href="#seccionAgente" class="btnAgente">Agente</a>';
		$boton.='<a href="#cotizaciones" class="btncotizaciones">Cotizaciones</a>';
		$boton.='<a href="#otrasActividades" class="btnotrasActividades">Otras Actividades</a>';
		$boton.='<a href="#seccionEnCurso" class="btnAgente">En curso</a>';
		foreach($datosRamo as $key => $value){
			$boton.='<a  href="#'.$value->Abreviacion.'" class="btnRamo'.$value->Abreviacion.' prueba">'.$value->Nombre.'</a>';
		}

		return 
			$boton;
	}

	function  controlaSemaforos($tiempoSemaforo,$Status,$horasOficinaCP,$horasPortalCP,$tipoActividad)
	{
		$tiempo='tiempoNormal';
		if($tipoActividad=="Emision" || $tipoActividad=="Cotizacion"){
			if($Status==5){
				if($tiempoSemaforo != NULL){
					if($tiempoSemaforo>$horasPortalCP){
						$tiempo = "tiempoExcedido";
					} else {
						if((($tiempoSemaforo*100)/$horasPortalCP)>=70){
							$tiempo = "tiempoAcabando";
						}
					}
				} else {
					$tiempo="sinTiempo";
				}
			} else {
				if($Status==2){
					if($tiempoSemaforo!=NULL){
						if($tiempoSemaforo>$horasOficinaCP){
							$tiempo="tiempoExcedido";
						} else {
							if((($tiempoSemaforo*100)/$horasOficinaCP)>=70){
								$tiempo="tiempoAcabando";
							}
						}
					} else {
						$tiempo="sinTiempo";
					}
				}
			}
		}
		return $tiempo;
	}

?>
<script type="text/javascript">
	function actualizar(){
		location.reload(true);
	}
	
	setInterval("actualizar()",300000);
	
	function calificacionMala(e,objeto){
		e.preventDefault();
		var textoEscrito = prompt("Motivo de calificacion mala", "");
		
		if(textoEscrito != null ){
			if(textoEscrito!=''){
				direccion=objeto.getAttribute('href')+'&comentario='+textoEscrito;
				window.location.href=direccion;
			} else {
				alert("El comentario es obligatorio");
			}
		}
	}
	
	function seleccionar_todo(nombreFormulario){ var f = document.forms[nombreFormulario.name];for (i=0;i<f.elements.length;i++) {if(f.elements[i].type == "checkbox"){f.elements[i].checked=1}}}
	
	function deseleccionar_todo(nombreFormulario){
		var f = document.forms[nombreFormulario.name];
		for(i=0;i<f.elements.length;i++){
			if(f.elements[i].type == "checkbox"){
				f.elements[i].checked=0 
			}
		}
	}
	
	function todas(nombreFormulario, tipoTodas){
		var f = document.forms[nombreFormulario.name];
		f.tipo.value = tipoTodas;f.submit();
	}
</script>
<style type="text/css">

	.tiempoExcedido{background-color: red;color:white}
	.tiempoAcabando{background-color: orange;color: white}
	.tiempoNormal{background-color: green;color:white}
	.sinNormal{background-color: white;color:black}
	.divPromotoria p {color: white;background-color:#0857b9;display: none}
	.divPromotoria div {color: white; background-color: #03345b;}
	.divPromotoria:hover {cursor:pointer;}
	.divPromotoria:hover  p{display: inline-flex;height:50px; width: 150px; overflow: auto;} 
	.btnRam{padding: 2px; border: solid black 1px; color: black; background-color: #b4a5cb}
	.btnRamoDANOS{color: black;background-color:#fdd792;padding: 2px;border: solid black 1px;width: 110px;margin-left: 5px}
	.btnRamoVEHICULOS{color: black;background-color:#7474c3;padding: 2px;border: solid black 1px;width: 110px;margin-left: 5px}
	.btnRamoACCIDENTES_Y_ENFERMEDADES{color: black;background-color:#e26666;padding: 2px;border: solid black 1px;width: 110px;margin-left: 5px}
	.btnRamoVIDA{color: black;background-color:#7bdc77;padding: 2px;border: solid black 1px;width: 110px;margin-left: 5px}
	.btncotizaciones{color: black;background-color:#8762c8;padding: 2px;border: solid black 1px;width: 110px;margin-left: 5px}
	.btnotrasActividades{color: black;background-color:#afd584;padding: 2px;border: solid black 1px;width: 110px;margin-left: 5px}
	.btnAgente{color: black;background-color:#e68f6f;padding: 2px;border: solid black 1px;width: 110px}
	.btnEnCurso{color: black;background-color:#89cbd3;padding: 2px;border: solid black 1px;width: 110px}
	.divBotones{display: list-item; width: 300px}
	.menuFlotante{border: solid;width: 200px}
	.menuFlotante  a{display: block;}
	.contMenuFlotante{background: none repeat scroll 0 0 #FFFFFF;border: 1px solid #DDDDDD;border-radius: 6px 6px 6px 6px;bottom: 10px;right: 100px;margin-left: -10px;padding: 10px 0 0;position: fixed;text-align: center;width: 20px;z-index: 10000;padding: 0px; margin: 0px;}
	.vertical-menu {width: 10px;}
	.vertical-menu a {display: block;padding: 0px;text-decoration: none;}
	.vertical-menu a:hover {background-color: #ccc;}
	.vertical-menu a.active { color: red;}
	.tituloAgente{color: black;background-color:#e68f6f; font-size:1.5em; width: 100%; height: 30px}
	.tituloAgente > a{color: black;}
	.tituloEnCurso{color: black;background-color:#89cbd3; font-size:1.5em; width: 100%; height: 30px}
	.prueba:focus {color:pink;}
   	a:active {color: blue;}

</style>
</html>