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
<?php 
	$this->load->view('headers/header'); 
?>
<!-- Navbar -->
<?php
	$this->load->view('headers/menu');
?>
<!-- End navbar -->
<section class="container-fluid breadcrumb-formularios">
	<div class="row">
		<div class="col-md-6 col-sm-5 col-xs-5"><h3 class="titulo-secciones">Actividades</h3></div>
        <div class="col-md-6 col-sm-7 col-xs-7">
			<ol class="breadcrumb text-right">
                <li><a href="./">Inicio</a></li>
                <li class="active">Actividades</li>
            </ol>
        </div>
    </div>
        <hr /> 
        <a href="https://www.dropbox.com/sh/3txhtwzoketivnz/AABSWpAhQXuqTpiPfv_rDvGxa/COTIZADORES?dl=0" title="Clic Aqui - Descargar Cotizadores" target="_blank"><b>Cotizadores</b></a>
</section>
<section class="container-fluid">
	<div class="panel panel-default">
<div onscroll="moverScroll()" id="scrollTabla" style="overflow-x:scroll; overflow-y: scroll;" ><!-- width:1000; height: 200px;border:solid; -->

		<div class="panel-body">

		<div class="row" style="padding-bottom:5px;"><!-- Botones de Accion General -->
			<div class="col-sm-12 col-md-12" align="right">
			<!--  /*===================== SE OCULTO NUEVO BOTON. LA OPCION SE AGREGO EN EL SUBMENU DE ACTIVIDADES==================*/ -->
			<? $oculto=0;  if($oculto==1){?>
            	<input
                	type="button" value="Crear Actividad" 
                    title="Crear Actividad - Clic Aqu&iacute;" 
                    onclick="window.open('actividades/agregar','_self');" 
					class="btn btn-primary btn-sm"
                />
			<? } ?>               
			<!-- /*==============================================================================================================*/ -->
			<input
				type="button" value="Exportar Historial" 
				title="Exportar Historial de Activiades - Clic Aqu&iacute;"                                               
				onclick="window.open('actividades/ExportaHistorial','_self');" 
				class="btn btn-primary btn-sm"
			/>
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
        
        <div class="row"><!-- Modal -->
        	<div class="col-sm-12 col-md-12">
			<?
			if($ActividadesCerrar>0){
			?>
				<div id="miModal">
					<!-- vfrewgfre -->
					<div id="Modalcontenido" class="modal-contenido">
						<table style="border:5px double #361866; width:360px; float:left; position:relative; top:-60px; left:-130px">
							<tr>
								<td style="background-color:white">
				                	<button onclick="cerrar()" style="color: white;float:right;background-color:red; border:double; position:relative; top:0px">
			                    	Cerrar
				                	</button>
				                </td>
							</tr>
							<tr>
								<td style="background-color:white">
									<p>Estimado Agente se han detectado actividades que estan a dias de ser finalizadas automaticamente, le invitamos a que las finalice antes de los 60 dias.</p>
								</td>
							</tr>
						</table>
					</div>
				</div><!-- miModal -->
			<?
			}
			?>
            </div>
		</div>
        
        <div class="row"><!-- Mis Pendientes -->
        	<div class="col-sm-12 col-md-12">
			<form
				class="form-horizontal" role="form"
               	name="formMisPendientes" id="formMisPendientes" 
				method="post" enctype="multipart/form-data"
				action="<?=base_url()?>actividades/todas"
			>
			<input type="hidden" name="tipo" id="tipo" />
				<table class="table table-striped table-bordered table-sm">
					<thead>
						<tr scope="row"><!-- align="right" -->
                        <div class="clearfix" style="float:left;">
                        	<font class="subTituloSeccione">
                            	Mis Pendientes:
                            </font>
                            <font style="color:red; font-weight:bold;"/>
                            	Al Calificar se Finaliza Automaticamente la Actividad (No califique si no va Finalizar)
							</font>
						</div>
                        <!-- ESTABA MARCADO -->
						<div>
                            <font style="float:right;">
								<input type="button" onclick="seleccionar_todo(this.form)" value="Marcar todos" class="btn btn-primary btn-sm" />
                                &nbsp;
                                <input type="button" onclick="deseleccionar_todo(this.form)" value="Marcar ninguno" class="btn btn-primary btn-sm" />
                                	<input
                                    	type="button"
                                        onclick="todas(this.form, 'terminarTodas')" value="Cerrar las seleccionadas" class="btn btn-primary btn-sm"
                                   />
							</font>
						</div>
                        <!-- -->
                        </tr>
						<tr scope="row" bgcolor="#A391C0">
							<th scope="col" >Folio</th><!-- width="100" -->
                            <th scope="col" >Fecha</th><!-- width="90" -->
                            <th scope="col"	>Actividad</th><!--  width="140" -->
                            <th scope="col" >SubRamo</th><!-- width="200" -->
                            <th scope="col" >Cliente</th>
                            <th scope="col" >Califica/Finaliza</th><!-- width="50" -->
                            <th scope="col" >Finaliza Masivamente</th>
                        </tr>
                	</thead>
					<tbody>
					<?
					if($ActividadesPendientes != false){
						$contCheckbox = 0;
						foreach($ActividadesPendientes->result() as $row){
							$contCheckbox++;
							//$infoCliente = $this->capsysdre_actividades->DetalleCliente($row->idCliente.'-'.$row->idContacto);
							$semaforoNew = $this->capsysdre_actividades->SemaforoActividadesJjHe($row->folioActividad);
					?>
						<tr scope="row" style="font-size:12px;">
							<td scope="col" align="center">
                            	<a 
                                	href="<?=base_url()."actividades/ver/".$row->folioActividad?>" 
                                	title="<?=$row->datosExpres;?>"
                                >
                            	<div style=" <?=$this->capsysdre_actividades->semaforoActividad($semaforoNew); /*$row->semaforo*/?>">
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
									if($semaforoNew == "Red" && $row->actividadImportante == "0" ){
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
									}
								?>
                            </td>
							<td scope="col"><?=$row->subRamoActividad?></td>
							<td scope="col">
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
										print("<br />(".$informacion[0]->idpersonarankingagente.")");
										print($informacion[0]->Giro);     
                                       
										//print("<br />".$this->capsysdre->RankingUsuarioEmail($row->usuarioVendedor));
										//print($this->capsysdre->ClasificacionVendedor($row->usuarioVendedor));
										//print("<br />".$this->capsysdre->CertificacionesVendedor($row->usuarioVendedor));
									} else {
										print("<br /><b>Creador:</b>".$row->usuarioCreacion);
										print("&nbsp;[".$row->usuarioCreacion."]&nbsp;");
										$informacion=$this->capsysdre->devolverDatosActividades($row->usuarioCreacion);
										print("<br />(".$informacion[0]->idpersonarankingagente.")");
										print($informacion[0]->Giro); 


										//print("<br />".$this->capsysdre->RankingUsuarioEmail($row->usuarioCreacion));
										//print($this->capsysdre->ClasificacionVendedor($row->usuarioCreacion));
										//print("<br />".$this->capsysdre->CertificacionesVendedor($row->usuarioCreacion));
									}
								?>
                            </td><!--  //$infoCliente[0]->NombreCompleto -->
							<td scope="col" align="center">
                            	<? //aca muestro las opciones para calificar si no esta calificado el campo satisfaccion
								if($row->satisfaccion == ""){
								?>
								<!-- <div class="row"> -->
								<a 
                                	href="<?=base_url().'actividades/calificarActividad?folioActividad='.$row->folioActividad.'&satisfaccion=bueno&tipoActividad=Actividad&IDDocto='.$row->idSicas.'&ClaveBit='.$row->ClaveBit ?>"
                                    data-toggle="modal"
                                    title="Califica Bien y Finaliza"
								>
                                <span class="glyphicon glyphicon-thumbs-up"></span>
                                </a>
                                &nbsp;
								<!-- </div>
                				<div class="row"> -->
								<a 
                                	  href="<?=base_url().'actividades/calificarActividad?folioActividad='.$row->folioActividad.'&satisfaccion=regular&tipoActividad=Actividad&IDDocto='.$row->idSicas.'&ClaveBit='.$row->ClaveBit ?>"
                                    data-toggle="modal"
                                    title="Califica Regular y Finaliza"
								>
                                <span class="glyphicon glyphicon-record"></span>
                                </a>
                                &nbsp;
                                <!-- </div>
                                <div class="row"> -->
                                <a 
                                href="<?=base_url().'actividades/calificarActividad?folioActividad='.$row->folioActividad.'&satisfaccion=malo&tipoActividad=Actividad&IDDocto='.$row->idSicas.'&ClaveBit='.$row->ClaveBit ?>"
                                    data-toggle="modal"
                                    title="Califica Mal y Finaliza"
								>
                                <span class="glyphicon glyphicon-thumbs-down"></span>
                                </a>
								<!-- </div> -->
								<?
								} else {
								?>
                    			<a 
                                	title="Actividad Calificada"
                                >
                    			<span class="glyphicon glyphicon glyphicon-ok-sign"> </span>
                    			</a>
								<a 
                                	href="<?=base_url()."actividades/terminar/".$row->folioActividad."?IDDocto=".$row->idSicas."&ClaveBit=".$row->ClaveBit?>" title="Terminar la Actividad del Sistema"
                                >
								<span class="glyphicon glyphicon-trash"></span> 
                    			</a>
								<?
								}
								?>
							</td>
							<td><input type="checkbox" name="ch[]" value="<?=$row->idSicas."|".$row->ClaveBit."|".$row->folioActividad?>"></td>
						</tr>
					<?
						}
					}


					?>
					</tbody>
				</table>
			</form>
			</div>
		</div>
<!-- -->
        <div class="row"><!-- Trabajando en Agente Capital -->
        	<div class="col-sm-12 col-md-12">
			  <form
					class="form-horizontal" role="form"
                	name="formTrabajandoAgenteCapital" id="formTrabajandoAgenteCapital" 
                    method="post" enctype="multipart/form-data"
                    action="<?=base_url()?>actividades/todas"
                > 
                <input type="hidden" name="tipo" id="tipo" />
				<table class="table table-striped table-bordered table-sm">
					<thead>
						<tr scope="row"><!-- align="right" -->
                        	<div class="clearfix" style="float:left;">
	                        	<font class="subTituloSeccione">Trabajando en Agente Capital:</font>
                            </div>
                            <div>
    	                        <font style="float:right;">
        	                        <input type="button" onclick="seleccionar_todo(this.form)" value="Marcar todos" class="btn btn-sm" />
            	                    &nbsp;
                	                <input type="button" onclick="deseleccionar_todo(this.form)" value="Marcar ninguno" class="btn btn-sm" />
								</font>
                            </div>
                        </tr>
						<tr scope="row" bgcolor="#A391C0" valign="top">
							<th scope="col">Folio</th><!--  width="100" -->
                            <th scope="col">Fecha</th><!-- width="90" -->
                            <th scope="col">Actividad</th><!-- width="140" -->
                            <th scope="col">SubRamo</th><!-- width="200" -->
                            <th scope="col">Cliente</th>
                            <th scope="col"><!-- align="center" -->
								<center>
                            	Acciones
                                <br />
								<button
									type="button" style="border:none; background:none;"
									onclick="todas(this.form, 'posponerTodas')"
								>
									<span class="glyphicon glyphicon-pause"></span>
								</button>
                                </center>
                            </th><!-- width="50"  -->
                        </tr>
                	</thead>
					<tbody>
					<?
					if($ActividadesTrabajandose != false){
						$contCheckbox = 0;
						foreach($ActividadesTrabajandose->result() as $row){
							$contCheckbox++;
							//$infoCliente = $this->capsysdre_actividades->DetalleCliente($row->idCliente.'-'.$row->idContacto);
							$semaforoNew = $this->capsysdre_actividades->SemaforoActividadesJjHe($row->folioActividad);
					?>
						<tr scope="row" style="font-size:12px;">
							<td scope="col" align="center">
                            	<a 
                                	href="<?=base_url()."actividades/ver/".$row->folioActividad?>" 
                                	title="<?=$row->datosExpres?>"
                                >
                            	<div style=" <?=$this->capsysdre_actividades->semaforoActividad($semaforoNew); /*$row->semaforo*/?>">
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
									if($semaforoNew == "Red" && $row->actividadImportante == "0" ){
								?>
                                <br />
                                <font style="color:red; font-weight:bold;">
								<a 
                                	href="<?=base_url().'actividades/marcarImportante?folioActividad='.$row->folioActividad; ?>"
									data-original-titletitle="Clic - Para calificar"
                                    style="color:#F00"
								>
                                	!!! ESCALAR !!!
								</a>
                                </font>
                                <?
									}
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
										print("<br />(".$informacion[0]->idpersonarankingagente.")");
										print($informacion[0]->Giro);     
                                       
										//print("<br />".$this->capsysdre->RankingUsuarioEmail($row->usuarioVendedor));
										//print($this->capsysdre->ClasificacionVendedor($row->usuarioVendedor));
										//print("<br />".$this->capsysdre->CertificacionesVendedor($row->usuarioVendedor));
									} else {
										print("<br /><b>Creador:</b>".$row->usuarioCreacion);
										print("&nbsp;[".$row->usuarioCreacion."]&nbsp;");
										$informacion=$this->capsysdre->devolverDatosActividades($row->usuarioCreacion);
										print("<br />(".$informacion[0]->idpersonarankingagente.")");
										print($informacion[0]->Giro); 


										//print("<br />".$this->capsysdre->RankingUsuarioEmail($row->usuarioCreacion));
										//print($this->capsysdre->ClasificacionVendedor($row->usuarioCreacion));
										//print("<br />".$this->capsysdre->CertificacionesVendedor($row->usuarioCreacion));
									}
								?>
							</td><!--  //$infoCliente[0]->NombreCompleto -->
							<td scope="col" align="center">
								<a href="<?=base_url()."actividades/posponer/".$row->idSicas?>" title="Pausa la Actividad del Sistema">
									<span class="glyphicon glyphicon-pause"></span>
								</a>
								<!-- <a href="<?=base_url()."actividades/terminar/".$row->folioActividad."?IDDocto=".$row->idSicas."&ClaveBit=".$row->ClaveBit?>" title="Terminar la Actividad del Sistema">
									<span class="glyphicon glyphicon-trash"></span>
								</a> -->
                                &nbsp;
                                <input type="checkbox" name="ch[]" value="<?=$row->idSicas."|".$row->ClaveBit?>">
							</td>
						</tr>
					<?
						}
					}
					?>
                    </tbody>
				</table>
				</form>
            </div>
        </div>
<!-- -->
        <div class="row"><!-- Pospuestas -->
        	<div class="col-sm-12 col-md-12">
			  <form
					class="form-horizontal" role="form"
                	name="formPospuestas" id="formPospuestas" 
                    method="post" enctype="multipart/form-data"
                    action="<?=base_url()?>actividades/todas"
                > 
                <input type="hidden" name="tipo" id="tipo" />
				<table class="table table-striped table-bordered table-sm">
					<thead>
						<tr scope="row" align="right">
                        	<div class="clearfix" style="float:left;">
	                        	<font class="subTituloSeccione">Pospuestas:</font>
                            </div>
                            <div>
    	                        <font style="float:right;">
	                                <input type="button" onclick="seleccionar_todo(this.form)" value="Marcar todos" class="btn btn-sm" />
    	                            &nbsp;
        	                        <input type="button" onclick="deseleccionar_todo(this.form)" value="Marcar ninguno" class="btn btn-sm" />
								</font>
                            </div>
                        </tr>
						<tr scope="row" bgcolor="#A391C0" valign="top">
							<th scope="col">Folio</th><!-- width="100" -->
                            <th scope="col">Fecha</th><!-- width="90" -->
                            <th scope="col">Actividad</th><!-- width="140" -->
                            <th scope="col">SubRamo</th><!-- width="200" -->
                            <th scope="col">Cliente</th>
                            <th scope="col">
                            	<center>
                            	Acciones
                                <br />
								<button
									type="button" style="border:none; background:none;"
									onclick="todas(this.form, 'posponerTodas')"
								>
									<span class="glyphicon glyphicon-pause"></span>
								</button>
								</center>
                            </th><!-- width="50" align="center" -->
                        </tr>
                	</thead>
					<tbody>
					<?
					if($ActividadesPospuestas != false){
						$contCheckbox = 0;
						foreach($ActividadesPospuestas->result() as $row){
							$contCheckbox++;
							//$infoCliente = $this->capsysdre_actividades->DetalleCliente($row->idCliente.'-'.$row->idContacto);
					?>
						<tr scope="row" style="font-size:12px;">
							<td scope="col" align="center">
                            	<a 
                                	href="<?=base_url()."actividades/ver/".$row->folioActividad?>" 
                                	title="<?=$this->capsysdre_actividades->titleDatosExpres($row->datosExpres);?>"
                                >
                            	<div style=" <?=$this->capsysdre_actividades->semaforoActividad($semaforoNew); /*$row->semaforo*/?>">
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
                            </td>
							<td scope="col"><?=$row->subRamoActividad?></td>
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
							<td scope="col" align="center">
								<a href="<?=base_url()."actividades/posponer/".$row->idSicas?>" title="Pausa la Actividad del Sistema">
									<span class="glyphicon glyphicon-pause"></span>
								</a>
								<!--<a href="<?=base_url()."actividades/terminar/".$row->folioActividad."?IDDocto=".$row->idSicas."&ClaveBit=".$row->ClaveBit."&ClaveBit=".$row->ClaveBit?>" title="Terminar la Actividad del Sistema">
									<span class="glyphicon glyphicon-trash"></span>
								</a>-->
                                &nbsp;
                                <input type="checkbox" name="ch[]" value="<?=$row->idSicas."|".$row->ClaveBit?>">
							</td>   
						</tr>
					<?
						}
					}
					?>
                    </tbody>
				</table>
				</form>
            </div>
        </div>
<?
if($nubeVehiculos){
?>
<!-- Nube Autos -->
        <div class="row">
        	<div class="col-sm-12 col-md-12">
			  <form
					class="form-horizontal" role="form"
                	name="formNubeAutos" id="formNubeAutos" 
                    method="post" enctype="multipart/form-data"
                    action="<?=base_url()?>actividades/todas"
                > 
                <input type="hidden" name="tipo" id="tipo" />
				<table class="table table-striped table-bordered table-sm">
					<thead>
						<tr align="right">
                        	<div class="clearfix" style="float:left;">
                        	<font class="subTituloSeccione">Nube Autos:</font>
                            </div>
                            <div>
                            <font style="float:right;">
                                <input type="button" onclick="seleccionar_todo(this.form)" value="Marcar todos" />
                                &nbsp;
                                <input type="button" onclick="deseleccionar_todo(this.form)" value="Marcar ninguno" />

							</font>
                            </div>
                        </tr>
						<tr bgcolor="#A391C0" valign="top">
							<th width="100">Folio</th>
                            <th width="90">Fecha</th>
                            <th width="140">Actividad</th>
                            <th width="200">SubRamo</th>
                            <th width="80">Status</th>
                            <th>Cliente</th>
                            <th width="50" align="center">
                            	Acciones
                                <br />
									<button
                                    	type="button" style="border:none; background:none;"
                                        onclick="todas(this.form, 'posponerTodas')"
                                    >
										<span class="glyphicon glyphicon-pause"></span>
									</button>
                                    
									<button
                                    	type="button" style="border:none; background:none;"
                                        onclick="todas(this.form, 'terminarTodas')"
                                    >
										<span class="glyphicon glyphicon-trash"></span>
									</button>
                            </th>
                        </tr>
                	</thead>
					<tbody>
					<?
					if($ActividadesNubeAutos != false){
						$contCheckbox = 0;
						foreach($ActividadesNubeAutos->result() as $row){
							$contCheckbox++;
							//$infoCliente = $this->capsysdre_actividades->DetalleCliente($row->idCliente.'-'.$row->idContacto);
							$semaforoNew = $this->capsysdre_actividades->SemaforoActividadesJjHe($row->folioActividad);
					?>
						<tr style="font-size:12px;">
							<td align="center">
                            	<a 
                                	href="<?=base_url()."actividades/ver/".$row->folioActividad?>" 
                                	title="<?=$this->capsysdre_actividades->titleDatosExpres($row->datosExpres);?>"
                                >
                            	<div style=" <?=$this->capsysdre_actividades->semaforoActividad($semaforoNew); /*$row->semaforo*/?>">
								<?=$row->folioActividad."<br />"?>
                                <font style="font-size:9px;">
                                <?=($row->tipoActividadSicas=="tarea")?$row->idSicas:$row->NumSolicitud?>
                                </font>
                                </div>
                                </a>
                            </td>
							<td title="<?="Fecha Actualizaci&oacute;n\n".$this->capsysdre_actividades->fechaHoraEspActividades($row->fechaActualizacion,'title')?>">
								<?=$this->capsysdre_actividades->fechaHoraEspActividades($row->fechaCreacion,'')?>
                            </td>
							<td>
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
                            </td>
							<td><?=$row->subRamoActividad?></td>
							<td><?=$this->capsysdre_actividades->Status($row->Status)?></td>
							<td>
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
							<td align="center">
								<a href="<?=base_url()."actividades/posponer/".$row->idSicas?>" title="Pausa la Actividad del Sistema">
									<span class="glyphicon glyphicon-pause"></span>
								</a>
								<a href="<?=base_url()."actividades/terminar/".$row->folioActividad."?IDDocto=".$row->idSicas."&ClaveBit=".$row->ClaveBit."&ClaveBit=".$row->ClaveBit?>" title="Terminar la Actividad del Sistema">
									<span class="glyphicon glyphicon-trash"></span>
								</a>
                                &nbsp;
                                <input type="checkbox" name="ch[]" value="<?=$row->idSicas."|".$row->ClaveBit?>">
							</td>   
						</tr>
					<?
						}
					}
					?>
                    </tbody>
				</table>
				</form>
            </div>
        </div>
<!--* Nube Autos -->
<?
}
?>

<?
if($nubeLineas){
?>
<!-- Nube LineasPersonales -->
        <div class="row">
        	<div class="col-sm-12 col-md-12">
			  <form
					class="form-horizontal" role="form"
                	name="formNubeAutos" id="formNubeAutos" 
                    method="post" enctype="multipart/form-data"
                    action="<?=base_url()?>actividades/todas"
                > 
                <input type="hidden" name="tipo" id="tipo" />
				<table class="table table-striped table-bordered table-sm">
					<thead>
						<tr align="right">
                        	<div class="clearfix" style="float:left;">
                        	<font class="subTituloSeccione">Nube L&iacute;neas Personales:</font>
                            </div>
                            <div>
                            <font style="float:right;">
                                <input type="button" onclick="seleccionar_todo(this.form)" value="Marcar todos" />
                                &nbsp;
                                <input type="button" onclick="deseleccionar_todo(this.form)" value="Marcar ninguno" />

							</font>
                            </div>
                        </tr>
						<tr bgcolor="#A391C0" valign="top">
							<th width="100">Folio</th>
                            <th width="90">Fecha</th>
                            <th width="140">Actividad</th>
                            <th width="200">SubRamo</th>
                            <th width="80">Status</th>
                            <th>Cliente</th>
                            <th width="50" align="center">
                            	Acciones
                                <br />
									<button
                                    	type="button" style="border:none; background:none;"
                                        onclick="todas(this.form, 'posponerTodas')"
                                    >
										<span class="glyphicon glyphicon-pause"></span>
									</button>
                                    
									<button
                                    	type="button" style="border:none; background:none;"
                                        onclick="todas(this.form, 'terminarTodas')"
                                    >
										<span class="glyphicon glyphicon-trash"></span>
									</button>
                            </th>
                        </tr>
                	</thead>
					<tbody>
					<?
					if($ActividadesNubeLineasPersonales != false){
						$contCheckbox = 0;
						foreach($ActividadesNubeLineasPersonales->result() as $row){
							$contCheckbox++;
							//$infoCliente = $this->capsysdre_actividades->DetalleCliente($row->idCliente.'-'.$row->idContacto);
							$semaforoNew = $this->capsysdre_actividades->SemaforoActividadesJjHe($row->folioActividad);
					?>
						<tr style="font-size:12px;">
							<td align="center">
                            	<a 
                                	href="<?=base_url()."actividades/ver/".$row->folioActividad?>" 
                                	title="<?=$this->capsysdre_actividades->titleDatosExpres($row->datosExpres);?>"
                                >
                            	<div style=" <?=$this->capsysdre_actividades->semaforoActividad($semaforoNew); /*$row->semaforo*/?>">
								<?=$row->folioActividad."<br />"?>
                                <font style="font-size:9px;">
                                <?=($row->tipoActividadSicas=="tarea")?$row->idSicas:$row->NumSolicitud?>
                                </font>
                                </div>
                                </a>
                            </td>
							<td title="<?="Fecha Actualizaci&oacute;n\n".$this->capsysdre_actividades->fechaHoraEspActividades($row->fechaActualizacion,'title')?>">
								<?=$this->capsysdre_actividades->fechaHoraEspActividades($row->fechaCreacion,'')?>
                            </td>
							<td>
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
                            </td>
							<td><?=$row->subRamoActividad?></td>
							<td><?=$this->capsysdre_actividades->Status($row->Status)?></td>
							<td>
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
							<td align="center">
								<a href="<?=base_url()."actividades/posponer/".$row->idSicas?>" title="Pausa la Actividad del Sistema">
									<span class="glyphicon glyphicon-pause"></span>
								</a>
								<a href="<?=base_url()."actividades/terminar/".$row->folioActividad."?IDDocto=".$row->idSicas."&ClaveBit=".$row->ClaveBit."&ClaveBit=".$row->ClaveBit?>" title="Terminar la Actividad del Sistema">
									<span class="glyphicon glyphicon-trash"></span>
								</a>
                                &nbsp;
                                <input type="checkbox" name="ch[]" value="<?=$row->idSicas."|".$row->ClaveBit?>">
							</td>   
						</tr>
					<?
						}
					}
					?>
                    </tbody>
				</table>
				</form>
            </div>
        </div>
<!--* Nube LineasPersonales -->
<?
}
?>

<?
if($nubeDanos){
?>
<!-- Nube DAños -->
        <div class="row">
        	<div class="col-sm-12 col-md-12">
			  <form
					class="form-horizontal" role="form"
                	name="formNubeAutos" id="formNubeAutos" 
                    method="post" enctype="multipart/form-data"
                    action="<?=base_url()?>actividades/todas"
                > 
                <input type="hidden" name="tipo" id="tipo" />
				<table class="table table-striped table-bordered table-sm">
					<thead>
						<tr align="right">
                        	<div class="clearfix" style="float:left;">
                        	<font class="subTituloSeccione">Nube Da&ntilde;os:</font>
                            </div>
                            <div>
                            <font style="float:right;">
                                <input type="button" onclick="seleccionar_todo(this.form)" value="Marcar todos" />
                                &nbsp;
                                <input type="button" onclick="deseleccionar_todo(this.form)" value="Marcar ninguno" />

							</font>
                            </div>
                        </tr>
						<tr bgcolor="#A391C0" valign="top">
							<th width="100">Folio</th>
                            <th width="90">Fecha</th>
                            <th width="140">Actividad</th>
                            <th width="200">SubRamo</th>
                            <th width="80">Status</th>
                            <th>Cliente</th>
                            <th width="50" align="center">
                            	Acciones
                                <br />
									<button
                                    	type="button" style="border:none; background:none;"
                                        onclick="todas(this.form, 'posponerTodas')"
                                    >
										<span class="glyphicon glyphicon-pause"></span>
									</button>
                                    
									<button
                                    	type="button" style="border:none; background:none;"
                                        onclick="todas(this.form, 'terminarTodas')"
                                    >
										<span class="glyphicon glyphicon-trash"></span>
									</button>
                            </th>
                        </tr>
                	</thead>
					<tbody>
					<?
					if($ActividadesNubeDanos != false){
						$contCheckbox = 0;
						foreach($ActividadesNubeDanos->result() as $row){
							$contCheckbox++;
							//$infoCliente = $this->capsysdre_actividades->DetalleCliente($row->idCliente.'-'.$row->idContacto);
							$semaforoNew = $this->capsysdre_actividades->SemaforoActividadesJjHe($row->folioActividad);
					?>
						<tr style="font-size:12px;">
							<td align="center">
                            	<a 
                                	href="<?=base_url()."actividades/ver/".$row->folioActividad?>" 
                                	title="<?=$this->capsysdre_actividades->titleDatosExpres($row->datosExpres);?>"
                                >
                            	<div style=" <?=$this->capsysdre_actividades->semaforoActividad($semaforoNew); /*$row->semaforo*/?>">
								<?=$row->folioActividad."<br />"?>
                                <font style="font-size:9px;">
                                <?=($row->tipoActividadSicas=="tarea")?$row->idSicas:$row->NumSolicitud?>
                                </font>
                                </div>
                                </a>
                            </td>
							<td title="<?="Fecha Actualizaci&oacute;n\n".$this->capsysdre_actividades->fechaHoraEspActividades($row->fechaActualizacion,'title')?>">
								<?=$this->capsysdre_actividades->fechaHoraEspActividades($row->fechaCreacion,'')?>
                            </td>
							<td>
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
                            </td>
							<td><?=$row->subRamoActividad?></td>
							<td><?=$this->capsysdre_actividades->Status($row->Status)?></td>
							<td>
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
							<td align="center">
								<a href="<?=base_url()."actividades/posponer/".$row->idSicas?>" title="Pausa la Actividad del Sistema">
									<span class="glyphicon glyphicon-pause"></span>
								</a>
								<a href="<?=base_url()."actividades/terminar/".$row->folioActividad."?IDDocto=".$row->idSicas."&ClaveBit=".$row->ClaveBit."&ClaveBit=".$row->ClaveBit?>" title="Terminar la Actividad del Sistema">
									<span class="glyphicon glyphicon-trash"></span>
								</a>
                                &nbsp;
                                <input type="checkbox" name="ch[]" value="<?=$row->idSicas."|".$row->ClaveBit?>">
							</td>   
						</tr>
					<?
						}
					}
					?>
                    </tbody>
				</table>
				</form>
            </div>
        </div>
<!--* Nube Daños -->
<?
}
?>
		</div>
        <!--
		<div class="row">
        	<div class="col-sm-1 col-md-1" >&nbsp;</div>
        	<div
            	class="col-sm-1 col-md-1"
                style="background-color:#008000; border:#063 solid 2px; color:#FFFFFF;" 
            	title="Actividad Finalizada Atendida en Menos de 2Hrs"
            >
            	<strong>&nbsp;</strong> //Verde
            </div>
        	<div class="col-sm-1 col-md-1" >&nbsp;</div>
        	<div
            	class="col-sm-1 col-md-1"
                style="background-color:#800080; border:#909 solid 2px; color:#FFFFFF;" 
            	title="Actividad Finalizada Atendida en Mas de 2Hrs"
            >
            	<strong>&nbsp;</strong> // Morado
            </div>
        	<div class="col-sm-1 col-md-1" >&nbsp;</div>
        	<div
            	class="col-sm-1 col-md-1"
                style="background-color:#FF0000; border:#D43F3A solid 2px; color:#FFFFFF;" 
            	title="Actividad en Curso con mas de 2Hrs esperando Ser Atendida"
            >
            	<strong>&nbsp;</strong> // Rojo
            </div>
        	<div class="col-sm-1 col-md-1" >&nbsp;</div>
        	<div
            	class="col-sm-1 col-md-1"
                style="background-color:#FFA500; border:#EEA236 solid 2px; color:#FFFFFF;" 
            	title="Actividad en Curso entre 30 min y 2Hrs esperando Ser Atendida"
            >
            	<strong>&nbsp;</strong> // Naranja
            </div>
        	<div class="col-sm-1 col-md-1" >&nbsp;</div>
        	<div
            	class="col-sm-1 col-md-1"
                style="background-color:#0000FF; border:#00C solid 2px; color:#FFFFFF;"
            	title="Actividad en Curso con Menos de 30 Min esperando Ser Atendida"
            >
            	<strong>&nbsp;</strong> // Azul
            </div>
        	<div class="col-sm-1 col-md-1" >&nbsp;</div>
        </div>
        -->
</div>
    </div><!-- /container-fluid -->
</section><!-- /panel panel-default -->
<?php $this->load->view('footers/footer'); ?>

<? if($ActividadesCerrar>0){ ?>
<style>
	.modal-contenido{
		background-color:none;
		width: 100px;
		height: 100%;
		padding: 5% 10%;
		margin: 10% auto;
		position: relative;
		z-index: 1000;
	}
 
	.modalCierra{
		background-color: rgba(0,0,0,.8);
		position: fixed;
		top: 0;
		right: 0;
		bottom: 0px;
		left: 0;
		opacity: 0;
		transition: all 1s;
		display: none;
		z-index: 1000;
	}
	.modalAbre{
		background-color: rgba(0,0,0,.8);
		position:fixed;
		top:0;
		right:0;
		bottom:0px;
		left:0;
		transition: all 1s;
		width:100%;
		height:100%;
		display:block;
		relative;z-index: 1000;
	}
</style>

<script type="text/javascript">
	function cerrar(){
		document.getElementById("miModal").classList.add("modalCierra");
		document.getElementById("miModal").classList.remove("modalAbre");
		document.getElementById("Modalcontenido").style.display="none";
	}
	function abrir(){
		document.getElementById("miModal").classList.remove("modalCierra");
		document.getElementById("miModal").classList.add("modalAbre");
		document.getElementById("Modalcontenido").style.display="block";
	}
	// cerrar();
	abrir();
</script>
<? } ?>