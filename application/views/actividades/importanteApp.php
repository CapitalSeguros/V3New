<?
	$moduloConfiguraciones	= "";
	$nubeVehiculos			= "";
	$nubeDanos				= "";
	$nubeLineas				= "";
	foreach($configModulos as $modulos){
		//var_dump($modulos);
		if($modulos['modulo'] == "configuraciones"){ $moduloConfiguraciones.= TRUE; } else { $moduloConfiguraciones.= FALSE; }
		if($modulos['subModulo'].$modulos['permiso'] == "cotizadorNubeVEHICULOS"){ $nubeVehiculos .= TRUE; } else { $nubeVehiculos .= FALSE; }
		if($modulos['subModulo'].$modulos['permiso'] == "cotizadorNubeDANOS"){ $nubeDanos .= TRUE; } else { $nubeDanos .= FALSE; }
		if($modulos['subModulo'].$modulos['permiso'] == "cotizadorNubeLINEAS"){ $nubeLineas .= TRUE; } else { $nubeLineas .= FALSE; }		
	}
	$PermisoDesmarcarImportante = array();
	$sqlCorreosImportante = "
				Select
					`correo` 
				From 
					`catalog_correosImportantes`
				Where
					1
							";
	foreach($this->db->query($sqlCorreosImportante)->result() as $correoImportante){
		array_push($PermisoDesmarcarImportante,strtoupper($correoImportante->correo));
	}

	if(in_array($this->tank_auth->get_usermail(), $PermisoDesmarcarImportante)){
		$siPuedeDesmarcar = true;
	} else {
		$siPuedeDesmarcar = false;
	}
?>
<script>
function seleccionar_todo(nombreFormulario){ 
	var f = document.forms[nombreFormulario.name];
	for (i=0;i<f.elements.length;i++) 
		if(f.elements[i].type == "checkbox")	
			f.elements[i].checked=1
}

function deseleccionar_todo(nombreFormulario){
	var f = document.forms[nombreFormulario.name];
	for(i=0;i<f.elements.length;i++)
		if(f.elements[i].type == "checkbox")
			f.elements[i].checked=0 
}

function todas(nombreFormulario, tipoTodas){
	var f = document.forms[nombreFormulario.name];
	f.tipo.value = tipoTodas;
		
		f.submit();
}
</script>
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
				<li class="active"><strong>Importantes</strong></li>
			</ol>

			<hr />

			<div class="row">
				<div class="col-lg-12">
					<!-- <div class="panel panel-default"> -->
					<div class="panel panel-default">
						<!-- panel heading -->
						<div class="panel-heading clearfix">
							<div class="row" style="padding-bottom:5px;"><!--  -->
								<div class="col-sm-12 col-md-12" align="right">
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
								<div class="table-responsive">
				<table class="table table-striped table-bordered table-sm">
					<thead>
						<tr scope="row" bgcolor="#A391C0">
							<th scope="col" >Folio</th>
                            <th scope="col" >Fecha</th>
                            <th scope="col"	>Actividad</th>
                            <th scope="col" >SubRamo</th>
                            <th scope="col" >Status</th>
                            <th scope="col" >Cliente</th>
                        </tr>
                	</thead>
					<tbody>
					<?
					if($ActividadesImportantes != false){
						$contCheckbox = 0;
						foreach($ActividadesImportantes->result() as $row){
							$contCheckbox++;
							$infoCliente = $this->capsysdre_actividades->DetalleCliente($row->idCliente.'-'.$row->idContacto);
							$semaforoNew = $this->capsysdre_actividades->SemaforoActividadesJjHe($row->folioActividad);
					?>
						<tr scope="row" style="font-size:12px;">
							<td scope="col" align="center">
                            	<a 
                                	href="<?=base_url()."actividades/ver/".$row->folioActividad?>" 
                                	title="<?=$this->capsysdre_actividades->titleDatosExpres($row->datosExpres);?>"
                                >
                            	<div style=" <?=$this->capsysdre_actividades->semaforoActividad($semaforoNew); ?>">
								<?=$row->folioActividad."<br />"?>
                                <font style="font-size:9px;">
                                <?=($row->tipoActividadSicas=="tarea")?$row->idSicas:$row->NumSolicitud?>
                                </font>
                                </div>
                                </a>
                            </td>
							<td scope="col" title="<?="Fecha Actualizaci&oacute;n\n".$this->capsysdre_actividades->fechaHoraEspActividades($row->fechaActualizacion,'title')?>">
								<?=$this->capsysdre_actividades->fechaHoraEspActividades($row->fechaCreacion,'')?>
                            </td>
							<td scope="col">
                            	<?
									if($row->fechaEmite != ""){
								?>
								<font style="color:#00F;">
                            	<strong>Emision</strong>
								</font>
                                <?
									}
								?>
                                <br />
								<?=$row->tipoActividad?>
                                <font style="color:red; font-weight:bold;"/>
                                <?=($row->actividadUrgente==1)?" &bull; Urgente !!!":""?>
                                </font>
                                <?
							if($siPuedeDesmarcar){
								?>
								<a 
                                	href="<?=base_url().'actividades/desmarcarImportante?folioActividad='.$row->folioActividad; ?>"
									data-original-titletitle="Clic - Para quitar de la lista de importantes !!!"
                                    style="color:#FFF"
                                    class="btn btn-danger"
								>!!! REGRESAR !!!</a>
                                <?
							}
								?>
                            </td>
							<td scope="col"><?=$row->subRamoActividad?></td>
							<td scope="col"><?=$this->capsysdre_actividades->Status($row->Status)?></td>
							<td scope="col">
								<?
									print($row->nombreCliente);
									if($row->usuarioVendedor != Null){
										if($row->usuarioVendedor != $row->usuarioCreacion){
											print("<br /><b>Creador:</b>".$this->capsysdre->NombreUsuarioEmail($row->usuarioCreacion));
											print("&nbsp;[".$row->usuarioCreacion."]&nbsp;");
										}
										print("<br /><b>Vendedor:</b>".$this->capsysdre->NombreUsuarioEmail($row->usuarioVendedor));
										print("&nbsp;[".$row->usuarioVendedor."]&nbsp;");
										print("<br />".$this->capsysdre->RankingUsuarioEmail($row->usuarioVendedor));
										print($this->capsysdre->ClasificacionVendedor($row->usuarioVendedor));
										print("<br />".$this->capsysdre->CertificacionesVendedor($row->usuarioVendedor));
									} else {
										print("<br /><b>Creador:</b>".$this->capsysdre->NombreUsuarioEmail($row->usuarioCreacion));
										print("&nbsp;[".$row->usuarioCreacion."]&nbsp;");
										print("<br />".$this->capsysdre->RankingUsuarioEmail($row->usuarioCreacion));
										print($this->capsysdre->ClasificacionVendedor($row->usuarioCreacion));
										print("<br />".$this->capsysdre->CertificacionesVendedor($row->usuarioCreacion));
									}
								?>
                            </td><!--  //$infoCliente[0]->NombreCompleto -->
						</tr>
					<?
						}
					}
					?>
					</tbody>
				</table>
								</div>
							</div>
							<!-- -->
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

<? $this->load->view("footers/app/main_footer") ?>
</body>
<script type="text/javascript">
	function actualizar(){
		location.reload(true);
	}
	
	setInterval("actualizar()",300000);
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
	.tituloAgente{color: black;background-color:#e68f6f; font-size:1.5em; width: 100%; height: 30px}
	.tituloAgente > a{color: black;}
	.tituloEnCurso{color: black;background-color:#89cbd3; font-size:1.5em; width: 100%; height: 30px}
	.prueba:focus {color:pink;}
   	a:active {color: blue;}

</style>
</html>