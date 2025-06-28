<?php $this->load->view('actividades/actividadesComentariosOperativos');?>
<?php
$userResponsable=$this->tank_auth->get_usermail();
$permisoCambioResponsable=0;
$panelParaActivdadesEnRojo=false;
if($userResponsable=='SISTEMAS@ASESORESCAPITAL.COM' || $userResponsable=='COORDINADOROPERATIVO@ASESORESCAPITAL.COM' || $userResponsable=='GERENTECOMERCIAL@AGENTECAPITAL.COM'){$permisoCambioResponsable=1;}
if($userResponsable=='SISTEMAS@ASESORESCAPITAL.COM' || $userResponsable=='COORDINADOROPERATIVO@ASESORESCAPITAL.COM' || $userResponsable=='DIRECTORGENERAL@AGENTECAPITAL.COM' || $userResponsable=='GERENTEOPERATIVO@AGENTECAPITAL.COM' || $userResponsable=='GERENTECOMERCIAL@AGENTECAPITAL.COM'){$panelParaActivdadesEnRojo=true;}
?>

<style>
    #dragable { width: 200px; height: auto; padding: 0.5em;opacity: 0.9 }

</style>
<script type="text/javascript">
    var ct=0;
    function persiana(){
        if(ct==0){
            document.getElementById('dragable').style.height='30px';
            $('#flecha').toggleClass('fa-arrow-circle-o-up');
            ct=1;
       }else{
             document.getElementById('dragable').style.height='auto';
             $('#flecha').toggleClass('fa-arrow-circle-o-down');
             ct=0;
       } 
    }
</script>
<?php $this->load->view('headers/header'); ?><?php $this->load->view('headers/menu');?>
<section class="container-fluid breadcrumb-formularios">
	<div class="row"><div class="col-md-6 col-sm-5 col-xs-5"><h3 class="titulo-secciones">Actividades</h3></div><div class="col-md-6 col-sm-7 col-xs-7"><ol class="breadcrumb text-right"><li><a href="./">Inicio</a></li><li class="active">Actividades</li></ol></div></div><hr /> 
        <a href="https://www.dropbox.com/sh/3txhtwzoketivnz/AABSWpAhQXuqTpiPfv_rDvGxa/COTIZADORES?dl=0" title="Clic Aqui - Descargar Cotizadores"  charset="" target="_blank"><b>Cotizadores</b></a>
</section>
<section class="container-fluid">
<!--
<div class="contMenuFlotante"> <div class="vertical-menu"><?php echo(imprimirBotonesRamos($ramos,$totalesPorRamo,$personaTrabajaActividad)); ?></div></div>
-->
<!--Modificacion--> 
<div id="dragable" class="contMenuFlotante">
    <div style="text-align: right;"><a href="#" onclick="persiana()"><i id="flecha" class="fa fa-times-circle fa-2x"></i></a></div>
    <div class="vertical-menu"><?php echo(imprimirBotonesRamos($ramos,$totalesPorRamo,$personaTrabajaActividad)); ?>
    </div>
</div>
<!--Fin Modificacion-->
<div class="panel panel-default">
<div onscroll="moverScroll()" id="scrollTabla" style="overflow-x:scroll; overflow-y: scroll;" >
		<div class="panel-body">
		<div class="row" style="padding-bottom:5px;">
			<div class="col-sm-12 col-md-12" align="right">
            <div class="col-md-2 text-right">
                <?= $this->load->view("permisosOperativos/tutorialButton");?>
            </div>      			
			<input type="button" value="Exportar Historial" title="Exportar Historial de Activiades - Clic Aqu&iacute;" onclick="window.open('actividades/ExportaHistorial','_self');" class="btn btn-primary btn-sm"/>
			<input type="button" value="Actualizar Actividad" title="Actualizar Actividad - Clic Aqu&iacute;" onclick="window.open('actualizaActividades/actualizaactividadesporvendedor','_self');" class="btn btn-primary btn-sm"/>
			</div>
		</div>

        <div class="row"><!-- Buscador de Folio -->
			<div class="col-sm-12 col-md-12" align="right">
            <form class="form-horizontal" role="form" id="formActividadBuscarFolio" name="formActividadBuscarFolio" method="post" enctype="multipart/form-data" action="<?=base_url()?>actividades/busqueda">
				<div class="input-group" style="width:50%;">
					<input id="folioBuscado" name="folioBuscado" type="text" class="form-control input-sm" placeholder="Buscar Folio">
                    <span class="input-group-btn"><button class="btn btn-primary btn-sm search-trigger"><i class="fa fa-search fa-sm"></i>&nbsp;</button></span>
				</div>
                <input type="hidden" id="usuarioCreacion" name="usuarioCreacion" value="<?=$this->tank_auth->get_usermail()?>"/>
			</form>
            </div>            
        </div>
        
    </div>
   </div>
    <div>
    	<div><label class="tituloAgente"><a name="seccionAgente">Agentes</a></label></div>
    				  <form class="form-horizontal" role="form" name="formTrabajandoAgenteCapital" id="formTrabajandoAgenteCapital"  method="post" enctype="multipart/form-data" action="<?=base_url()?>actividades/todas"> 
                <input type="hidden" name="tipo" id="tipo" />
                                      	<div class="clearfix" style="float:left;"><font class="subTituloSeccione"></font></div>
                            <div><font style="float:right;"><input type="button" onclick="seleccionar_todo(this.form)" value="Marcar todos" class="btn btn-info" />&nbsp;<input type="button" onclick="deseleccionar_todo(this.form)" value="Marcar ninguno" class="btn btn-info" /><input type="button" onclick="todas(this.form, 'terminarTodas')" value="Cerrar las seleccionadas" class="btn btn-danger"/></font></div>
             <?php foreach ($actividadesNoTrabajandose as $key => $value) { ?>
				<table class="table table-striped table-bordered table-sm">
					<thead>
						<tr scope="row"><div class="clearfix" style="float:left;"><font class="subTituloSeccione"><a class="btn<?= $key; ?>" name="<?= $key; ?>"> <?= $key ?></a></font></div>
                            <div></div>
                        </tr>
						<tr scope="row" bgcolor="#A391C0" valign="top"><th scope="col">Folio</th><th scope="col">Fecha recepcion</th><th scope="col">Estado</th><th scope="col">Fecha</th><th scope="col">Actividad</th><th scope="col">SubRamo</th><th scope="col">Cliente</th>
							<th>Califica/Finaliza</th><th scope="col"></th>
                        </tr>
                	</thead>
					<tbody>
			    	              		<?  $contCheckbox = 0;
						foreach($actividadesNoTrabajandose[$key] as $row){$contCheckbox++;$semaforoNew="";	
						$clase="classParaAgente";						

					?>
						<tr scope="row" style="font-size:12px;">
							<td scope="col" align="center">
                            	<a onclick="nuevaVentana(event,this)" href="<?=base_url().'actividades/ver/'.$row->folioActividad?>" title="<?=$row->datosExpres?>">
                            	<div class="<?=$clase?>">
								<?=$row->folioActividad."<br />"?>
                                <font style="font-size:9px;"> <?=($row->tipoActividadSicas=="tarea")?$row->idSicas:$row->NumSolicitud?></font>
                                </div>
                                </a>
                            </td>
							<td scope="col"><?=$this->capsysdre_actividades->fechaHoraEspActividades($row->fechaActualizacionStatus,'')?></td>
                            <td scope="col"><?=$row->Status_Txt?></td>
                            <td scope="col" data-title="<?='Fecha'.$this->capsysdre_actividades->fechaHoraEspActividades($row->fechaCreacion,'title')?>"><?=$this->capsysdre_actividades->fechaHoraEspActividades($row->fechaCreacion,'')?>
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
                            </td>
							<td scope="col"><?=$row->subRamoActividad?></td>
							<td>
								<?php
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
							</td><!--  //$infoCliente[0]->NombreCompleto -->
							<td scope="col" align="center">
                            	<? if($row->satisfaccion == ""){ ?>								
								<a href="<?=base_url().'actividades/calificarActividad?folioActividad='.$row->folioActividad.'&satisfaccion=bueno&tipoActividad=Actividad&IDDocto='.$row->idSicas.'&ClaveBit='.$row->ClaveBit.'&idInterno='.$row->idInterno ?>" title="Califica Bien y Finaliza">
                                <span class="glyphicon glyphicon-thumbs-up" style="font-size: 35px; color: green; margin-right: 15px;margin-left: 0px" onmouseout="this.style.color='green';" onmouseover="this.style.color='#000000';"></span>
                                </a>
                                <a href="<?=base_url().'actividades/calificarActividad?folioActividad='.$row->folioActividad.'&satisfaccion=malo&tipoActividad=Actividad&IDDocto='.$row->idSicas.'&ClaveBit='.$row->ClaveBit.'&idInterno='.$row->idInterno ?>" title="Califica Mal y Finaliza" onclick="calificacionMala(event,this)">
                                <span class="glyphicon glyphicon-thumbs-down" style="font-size: 35px;color: red" onmouseout="this.style.color='red';" onmouseover="this.style.color='#000000';" ></span>
                                </a>
								<? } else { ?>
                    			<a title="Actividad Calificada">
                    			<span class="glyphicon glyphicon glyphicon-ok-sign"> </span>
                    			</a>
								<a href="<?=base_url()."actividades/terminar/".$row->folioActividad."?IDDocto=".$row->idSicas."&ClaveBit=".$row->ClaveBit?>" title="Terminar la Actividad del Sistema">
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
					}
					?>
                    </tbody>
				</table>
				</form>
    </div>

    <div>

       <div class="row"><div class="col-sm-2 col-md-2"><label class="tituloAgente"><a name="seccionEnCurso">En curso </a></label></div></div>
    	<div class="row"><div class="col-sm-2 col-md-2"><label class="tituloAgente">FILTROS:</label></div><div class="col-sm-3 col-md-3"><select id="selectTipoFiltro" class="form-control" onchange="escogerTipoFiltro(this.value)"><option value="">ESCOGER FILTRO</option><option value="ESTADO">ESTADO</option><option value="TIPO ACTIVIDAD">TIPO ACTIVIDAD</option><option value="SUB RAMO">SUB RAMO</option><option value="RESPONSABLE">RESPONSABLE</option></select></div><div class="col-sm-3 col-md-3"><select id="selectValorFiltro" class="form-control" onchange="escogerFiltroRows(this)"></select></div><div class="col-sm-3 col-md-3">Detener recarga:<input type="checkbox"  id="detenerRecargaChecked" ></div></div>
        <?php if($permisoCambioResponsable){ ?>
        <div class="row">
            <div class="col-sm-1 col-md-1">Escoger</div><div><select id="nuevoResponsableSelect" class="form-control"><?=imprimirResponsables($ejecutivos)?></select></div>
            <div class="col-sm-1 col-md-1"><button class="btn btn-primary" onclick="cambiarResponsablesNuevos()">Guardar</button></div>
        </div>
    <?php }?>
    <?php $filtroEstado=array();
          $filtroTipoActividad=array();
          $filtroSubRamoActividad=array();
          $filtroResponsable=array();
          $filtroVendedor=array();
          $filtroCreador=array();
    foreach ($ActividadesTrabajandose as $key => $value) { ?>
      <div class="row"><!-- Trabajando en Agente Capital -->
        	<div class="col-sm-12 col-md-12">
                <input type="hidden" name="tipo" id="tipo" />
				<table class="table table-striped table-bordered table-sm">
					<thead>
						<tr scope="row">
                        	<div class="clearfix" style="float:left;"><font class="subTituloSeccione"><a class="btnRamo<?= $key; ?>" name="<?= $key; ?>"> <?= $key ?></a></font><?php if($key=='VEHICULOS'){echo('<button class="btn btn-success"><a onclick="nuevaVentana(event,this)" href="'.base_url().'cotizador">Ir a Car Capital</a></button>');} ?></div>
                            <div></div>
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
					<?  if($ActividadesTrabajandose != false){ $contCheckbox = 0;
						foreach($ActividadesTrabajandose[$key] as $row){$contCheckbox++;$semaforoNew="";							
							//$clase=controlaSemaforos($row->tiempoSemaforo,$row->Status,$row->horasOficinaCP,$row->horasPortalCP,$row->tipoActividad);
                            
                            $nuevoSemaforo=controlaSemaforos($row->nuevoSemaforo,$row->Status,$row->horasOficinaCP,$row->horasPortalCP,$row->tipoActividad,$row->usuarioResponsable,$row->idInterno,$row->folioActividad);
                            $clase=$nuevoSemaforo['tiempo'];
                            
                        $filtroEstado[$row->Status_Txt]=0;
                        $filtroTipoActividad[$row->tipoActividad]=0;
                        $filtroSubRamoActividad[$row->subRamoActividad]=0;
                        $filtroResponsable[$row->usuarioResponsable]=0;

					?>

						<tr scope="row" style="font-size:12px;" data-estado="<?=$row->Status_Txt?>" data-tipoactividad="<?=$row->tipoActividad?>" data-subramo="<?=$row->subRamoActividad?>" data-responsable="<?=$row->usuarioResponsable?>" data-vendedor="" data-creador="" name="trEnCurso" onclick="seleccionarRow(this)" data-idinterno="<?= $row->idInterno?>" id="<?=$row->folioActividad?>link">
							<td scope="col" align="center">
                            	<div class="row">
                            	<a onclick="nuevaVentana(event,this)" href="<?=base_url()."actividades/ver/".$row->folioActividad?>" title="<?=$row->datosExpres?>">
                            	<div class="<?=$clase?>">
								<?=$row->folioActividad."<br />"?>
                                <font style="font-size:9px;"> <?=($row->tipoActividadSicas=="tarea")?$row->idSicas:$row->NumSolicitud?></font>
                                </div>
                                </a>
                                </div>
                                <? if($tipoUsuario==5 || $tipoUsuario==4 || $tipoUsuario==1){ ?>
                                <div class="row">
                                	<? if($row->trabajandoseActividad==1){?>
                                	<input type="checkbox" name="cbTrabajarActividad" value="<?= $row->idInterno?>" onclick="trabajarActividad('',this)" checked>
                                	<? } 
                                	else{?>
                                      <input type="checkbox" name="cbTrabajarActividad" value="<?= $row->idInterno?>" onclick="trabajarActividad('',this)">
                                	
                                	<? } ?>
                                </div>
                                <? } ?>
                                <button class="btn btn-info btnActividadComentariosOperativos" onclick="abrirVentanaComentariosOperativos('',<?=$row->idInterno?>,'<?=$row->folioActividad?>')">&#128172</button>
                            </td>
							<td scope="col"><?=$this->capsysdre_actividades->fechaHoraEspActividades($row->fechaActualizacionStatus,'')?></td>
                            

			<!-- Modificación Miguel Jaime 16/11/2020-->
                            <td scope="col"  class="divPromotoria" align="center">
                                <br>
                                <div style="width: 120px;border-radius: 3px;text-align: center;color: #fff;">  
                                <label style="color: #1a0977"><?php echo $nuevoSemaforo['porcentajeTiempo'];?>%</label> 
                                    <meter min="0" max="100" low="70" high="80" optimum="69" value="<?php echo $nuevoSemaforo['porcentajeTiempo'];?>" style="height: 50px;width: 100%"></meter>
                                
                                                                                                   
                                <p style="font-size: 11px;">
                                   <? if($row->usuarioResponsable=='COBRANZA@ASESORESCAPITAL.COM'){?>
                                    LAS ACTIVIDADES EN COBRANZA TIENEN UN LIMITE DE 14 DIAS.
                                    <?}else{?><?=$row->promotorias ;?><?}?>
                                </div>


                            </td>
                            <!-- fin-->




                            <td scope="col"><?=$row->Status_Txt?></td>
                            <td scope="col" data-title="<?="Fecha".$this->capsysdre_actividades->fechaHoraEspActividades($row->fechaCreacion,'title')?>"><?=$this->capsysdre_actividades->fechaHoraEspActividades($row->fechaCreacion,'')?>
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
        </div>
     <? } ?>
</div>
    </div>
</section>
<?php if($panelParaActivdadesEnRojo){?>
<div style="position: fixed;z-index: 2;top: 2%;left: 10%">
<div class="row">
    <div class="row" >
    <div class="col-md-11 col-sm-11 col-xs-11" style="overflow: scroll;height: auto;width: 100%" id="divActividadesEnRojo"><table class="table" style="background-color: white"><thead><tr><th colspan="4">Folio</th></tr></thead><tbody><?=imprimirActividadesEnRojo()?> </tbody></table></div>

</div>
    <div class="col-md-8 col-sm-8 col-xs-8"><button class="btn btn-danger" style="width: 100%" id="btnActividadesEnRojo" data-char="128071">&#128071</button></div>
</div>
 
</div>
<?}?>
<?php $this->load->view('footers/footer'); ?>


<?php 


function imprimirBotonesRamos($datosRamo,$totales,$personaTrabajaActividad){
	
$boton="";
$boton.='<a href="#seccionAgente" class="btnAgente">Agente</a>';
$boton.='<a href="#cotizaciones" class="btncotizaciones">Cotizaciones</a>';
$boton.='<a href="#otrasActividades" class="btnotrasActividades">Otras Actividades</a>';
$boton.='<a href="#seccionEnCurso" class="btnAgente">En curso</a>';
foreach ($datosRamo as $key => $value) {
	$abreviacion=$value->Abreviacion;
	$boton.='<a  href="#'.$value->Abreviacion.'" class="btnRamo'.$value->Abreviacion.' prueba">'.$value->Nombre.'<span class="spanTotal">'.$totales->$abreviacion.'</span></a>';
}
$boton.='<div id="divActividadTrabajandose">';
foreach ($personaTrabajaActividad as $key => $value) {
	$boton.='<div class="row actividadesTrabajandose" data-idInterno="'.$value['idInterno'].'">'.$value['usuarioTrabaja'].'->'.$key.' ('.$value['usuarioResponsable'].')</div>';
}
$boton.='</div>';
return $boton;
}
function  controlaSemaforos($tiempoSemaforo,$Status,$horasOficinaCP,$horasPortalCP,$tipoActividad,$responable='',$idInterno='',$folioActividad='')
{
    $imp=array();
    $imp['tiempoSemaforo']=$tiempoSemaforo;
    $imp['Status']=$Status;
    $imp['horasOficinaCP']=$horasOficinaCP;
    $imp['horasPortalCP']=$horasPortalCP;
    $imp['tipoActividad']=$tipoActividad;
    $imp['responable']=$responable;
    $imp['idInterno']=$idInterno;
    $imp['folioActividad']=$folioActividad;
    $ci = &get_instance();    
    $array=array();
    $array['tiempo']='tiempoNormal';
    $array['porcentajeTiempo']=0;
	$tiempo='tiempoNormal';
    $porcentajeTiempo=0;
    if($responable=='COBRANZA@ASESORESCAPITAL.COM')
    {
        $tipoActividad='Cotizacion';
        $horasPortalCP=336;

    }
	if($tipoActividad=="Emision" || $tipoActividad=="Cotizacion")
	{
      if($Status==5){
      	if($tiempoSemaforo!=NULL)
      	{
          if($tiempoSemaforo>$horasPortalCP){$tiempo="tiempoExcedido";$array['tiempo']="tiempoExcedido";}
          else{if((($tiempoSemaforo*100)/$horasPortalCP)>=70){$tiempo="tiempoAcabando";$array['tiempo']="tiempoAcabando";}}

          $array['porcentajeTiempo']=$horasPortalCP==0?100:($tiempoSemaforo*100)/$horasPortalCP;
        }
      else{$tiempo="sinTiempo";}

    }
    else{
      	 if($Status==2)
      	 {
           if($tiempoSemaforo!=NULL)
           { if($tiempoSemaforo>$horasOficinaCP){$tiempo="tiempoExcedido";$array['tiempo']="tiempoExcedido";}
             else{if((($tiempoSemaforo*100)/$horasOficinaCP)>=70){$tiempo="tiempoAcabando";$array['tiempo']="tiempoAcabando";}}
             $array['porcentajeTiempo']=$horasOficinaCP==0?100:(($tiempoSemaforo*100)/$horasOficinaCP);
           }
           else{$tiempo="sinTiempo";}
      	 }
        }
	}
    $ci->load->model("notificacionmodel");
    $notificacion['tabla']='actividadesenrojo';          
    $notificacion['tipo_id']='email';
    $notificacion['referencia']='COMENTARIO_ACTIVIDAD';
    $notificacion['referencia_id']='1002';
    $notificacion['check']=0;
    $notificacion['comentarioAdicional']='La actividad '.$folioActividad.' supero el limite permitido';
    $notificacion['id']=-1;        
    $notificacion['tipo']='OTRO';

    if($array['tiempo']=='tiempoNormal'){$semaforo='verde';}
    if($array['tiempo']=='tiempoAcabando')
    {

        $semaforo='amarillo';
     $consulta='select (count(idInterno)) as total from actividadesenrojo a where a.estaCerrado=0  and statusActividad="AMARILLO" and a.idInterno='.$idInterno;
     $result=$ci->db->query($consulta)->result()[0]->total;
             if($result==0)
        {

          $idPersona='1061';
          $email='GERENTECOMERCIAL@AGENTECAPITAL.COM';
          if($responable=='EJECUTIVOCOTIZACIONES@AGENTECAPITAL.COM'){$idPersona='552';$email='COORDINADOROPERATIVO@ASESORESCAPITAL.COM';}


     $i['idInterno']=$idInterno;
     $i['folioActividad']=$folioActividad;
         $i['notificacionPara']=$email;
     $i['statusActividad']='AMARILLO';
     $ci->db->insert('actividadesenrojo',$i);
         $last=$ci->db->insert_id();         

         $notificacion['idTabla']=$last;
         $notificacion['persona_id']=$idPersona;//'552';
         $notificacion['comentarioAdicional']='La actividad '.$folioActividad.' se encuentra en semaforo amarillo';
         $notificacion['email']= $email; //'COORDINADOROPERATIVO@ASESORESCAPITAL.COM';
         $ultimoId=$ci->notificacionmodel->notificacion($notificacion);
         $actualizar['id']=$ultimoId;
         $actualizar['controlador']='actividades/eliminaComentarioAcitividad?folioActividad='.$folioActividad.'&id='.$ultimoId;
         $ci->notificacionmodel->actualizarNotificacion($actualizar);
       }
    }
    if($array['tiempo']=='tiempoExcedido')
    {
        
        $semaforo='rojo';
        $consulta='select (count(idInterno)) as total from actividadesenrojo a where a.estaCerrado=0 and a.notificacionPara="COORDINADOROPERATIVO@ASESORESCAPITAL.COM" and statusActividad="ROJO" and a.idInterno='.$idInterno;
        $consultaParaNC='select (count(idInterno)) as total from actividadesenrojo a where  a.notificacionPara="DIRECTORGENERAL@AGENTECAPITAL.COM" and statusActividad="ROJO" and a.idInterno='.$idInterno;
        $resultParaNC=$ci->db->query($consultaParaNC)->result()[0]->total;
        if($resultParaNC==0)
        {
          /*$correoProcedente='DIRECTORGENERAL@AGENTECAPITAL.COM';
          $fecharegistro=date('Y').'-'.date('m').'-'.date('d');
          $nombreProcedente='Edgar chan';
          $descripcion="El folio de la actividad ".$folioActividad." quedo en rojo";    
          //$nombreProcedente=$this->capsysdre->NombreUsuarioEmail($correoProcedente);
           $sqlInsert_Referencia = "Insert Ignore Into `inconformidades` (`descripcion`, `correoProcedente`,`nombreProcedente`,`fechaRegistro`) Values('".$descripcion."', '".$correoProcedente."','".$nombreProcedente."','".$fecharegistro."');";
            $ci->db->query($sqlInsert_Referencia);
            $referencia = $ci->db->insert_id();
            $insertar['nombreTabla']='inconformidades';
            $insertar['idRowTabla']=$referencia;
            $insertar['idPersonaInconforme']=6;
            $ci->procesamientoncmodel->insertarNC($insertar);*/
            
        }
        

         $consulta='select (count(idInterno)) as total from actividadesenrojo a where a.estaCerrado=0 and a.notificacionPara="GERENTECOMERCIAL@AGENTECAPITAL.COM" and statusActividad="ROJO" and a.idInterno='.$idInterno;
        $result=$ci->db->query($consulta)->result()[0]->total;        
         if($result==0)
         {
          $i['idInterno']=$idInterno;
          $i['folioActividad']=$folioActividad;
          $i['notificacionPara']='GERENTECOMERCIAL@AGENTECAPITAL.COM';
          $i['statusActividad']='ROJO';
          $ci->db->insert('actividadesenrojo',$i);
          $last=$ci->db->insert_id();
         $notificacion['idTabla']=$last;
         $notificacion['persona_id']=1;
         $notificacion['email']=  'GERENTECOMERCIAL@AGENTECAPITAL.COM';
         $ultimoId=$ci->notificacionmodel->notificacion($notificacion);
         $actualizar['id']=$ultimoId;
         $actualizar['controlador']='actividades/eliminaComentarioAcitividad?folioActividad='.$folioActividad.'&id='.$ultimoId;
         $ci->notificacionmodel->actualizarNotificacion($actualizar);
         }

        if($tiempoSemaforo>=72)
        {
         $consulta='select (count(idInterno)) as total from actividadesenrojo a where a.estaCerrado=0 and a.notificacionPara="DIRECTORGENERAL@AGENTECAPITAL.COM" and statusActividad="ROJO" and a.idInterno='.$idInterno;
        $result=$ci->db->query($consulta)->result()[0]->total;        
         if($result==0)
         {
          $i['idInterno']=$idInterno;
          $i['folioActividad']=$folioActividad;
          $i['notificacionPara']='DIRECTORGENERAL@AGENTECAPITAL.COM';
          $i['statusActividad']='ROJO';
          $ci->db->insert('actividadesenrojo',$i);
          $last=$ci->db->insert_id();
          $notificacion['idTabla']=$last;
         $notificacion['persona_id']='6';
         $notificacion['email']=  'DIRECTORGENERAL@AGENTECAPITAL.COM';
         $ultimoId=$ci->notificacionmodel->notificacion($notificacion);
         $actualizar['id']=$ultimoId;
         $actualizar['controlador']='actividades/eliminaComentarioAcitividad?folioActividad='.$folioActividad.'&id='.$ultimoId;
         $ci->notificacionmodel->actualizarNotificacion($actualizar);
         }
        }
    }
    
    //$ci->setSemaforo($idInterno,$semaforo);
    $array['porcentajeTiempo']=number_format($array['porcentajeTiempo'],2);
	return $array;
}

function imprimirArreglosGlobales($array,$nombreVariable)
{

$valores="";
$respuesta='let '.$nombreVariable.'=[';
  foreach ($array as $key => $value) 
  {

    $respuesta.='"'.$key.'",';

  }
  $respuesta=trim($respuesta,',');
  $respuesta.=']';

  return $respuesta;
}

function imprimirResponsables($datos)
{
    $respuesta='';
    $respuesta='<option value="">ESCOGER NUEVO RESPONSABLE</option>';
    foreach ($datos as $value) {$respuesta.='<option>'.$value->email.'</option>';}
    return $respuesta;
}

function imprimirActividadesEnRojo()
{
    $ci = &get_instance();
    $ci->load->model("capsysdre_actividades");
    $result=$ci->capsysdre_actividades->actividadesenrojo();  
    $actividadesEnRojo=array();
    foreach ($result as  $value) {$actividadesEnRojo[$value->folioActividad]=array();}
    #$fp = fopen('resultadoJason.txt', 'a');fwrite($fp, print_r($actividadesenrojo,TRUE));fclose($fp);

    foreach ($result as  $value) 
    {
       
         
           foreach ($actividadesEnRojo as $key => $val) 
           {
            
              if($key==$value->folioActividad)
              {
                  array_push($actividadesEnRojo[$key], $value);
              }
           }
    }
    
    $tr='';
    foreach ($actividadesEnRojo as $key => $value) 
    {
      $tr.='<tr><td><button class="btn btn-success" name="btnFolioActRojo" data-folio="'.$key.'">+</button></td><td colspan="3"  ><a href="#'.$key.'link">'.$key.'</a></td></tr>';
      foreach ($value as  $val) 
      {
          $tr.='<tr name="'.$key.'CabRojo" class="ocultarObjeto"><td></td><td>Notificacion para:'.$val->notificacionPara.'</td><td>Responsable:'.$val->usuarioResponsable.'</td><td>fecha Aviso:'.$val->fechaInsercion.'</td></tr>';
      }
    }
    return $tr;
     
}

?>
<script type="text/javascript">
    function actualizar()
    {   
       if(!document.getElementById('detenerRecargaChecked').checked)
      {
       let val1=document.getElementById('selectTipoFiltro').value;
       let val2=document.getElementById('selectValorFiltro').value;
       let datos='selectTipoFiltro='+val1+'&selectValorFiltro='+val2;       
       let direccion='<?=base_url()?>actividades?'+datos;
       window.location.replace(direccion);
    }
    }
    setInterval("actualizar()",300000);
<?= imprimirArreglosGlobales($filtroEstado,'filtroEstado');?>;
<?= imprimirArreglosGlobales($filtroTipoActividad,'filtroTipoActividad');?>;
<?= imprimirArreglosGlobales($filtroSubRamoActividad,'filtroSubRamoActividad');?>;
<?= imprimirArreglosGlobales($filtroResponsable,'filtroResponsable');?>;
function escogerFiltroRows(objeto)
{
    let rows=document.getElementsByName('trEnCurso');
    let cantidad=rows.length;
    for(let i=0;i<cantidad;i++){rows[i].classList.remove('ocultarObjeto')}
    let data=objeto.dataset.tipofiltro;   
    if(objeto.value!='')
    {
     for(let i=0;i<cantidad;i++){if(rows[i].getAttribute('data-'+data)!=objeto.value){rows[i].classList.add('ocultarObjeto')}}
    }
       
}
function escogerTipoFiltro(value)
{
    let rows=document.getElementsByName('trEnCurso');
    let cantidad=rows.length;
    for(let i=0;i<cantidad;i++){rows[i].classList.remove('ocultarObjeto')}
    let opciones='';
    let cant;
    let opcionFiltro="";
    switch(value)
    {
        case 'NINGUNO':          
        
        break;
        case 'ESTADO':
        cant=filtroEstado.length
        opciones='<option value="NINGUNO">SELECCIONAR ESTADO</option>'
        for(let i=0;i<cant;i++){opciones=opciones+'<option value="'+filtroEstado[i]+'">'+filtroEstado[i]+'</option>';}
            opcionFiltro='estado';
        break;
        case 'TIPO ACTIVIDAD':
        cant=filtroTipoActividad.length
        opciones='<option value="NINGUNO">SELECCIONAR TIPO ACTIVIDAD</option>'
        for(let i=0;i<cant;i++){opciones=opciones+'<option value="'+filtroTipoActividad[i]+'">'+filtroTipoActividad[i]+'</option>';}
        opcionFiltro='tipoactividad';
        break;
        case 'SUB RAMO':
        cant=filtroSubRamoActividad.length
        opciones='<option value="NINGUNO">SELECCIONAR SUBRAMO</option>'
        for(let i=0;i<cant;i++){opciones=opciones+'<option value="'+filtroSubRamoActividad[i]+'">'+filtroSubRamoActividad[i]+'</option>';}        
        opcionFiltro="subramo";
        break;
        case 'RESPONSABLE':
        cant=filtroResponsable.length
        opciones='<option value="NINGUNO">SELECCIONAR RESPONSABLE</option>'
        for(let i=0;i<cant;i++){opciones=opciones+'<option value="'+filtroResponsable[i]+'">'+filtroResponsable[i]+'</option>';}        
        opcionFiltro="responsable";
        break;
    }
    selectValorFiltro.innerHTML=opciones;
    selectValorFiltro.dataset.tipofiltro=opcionFiltro;
}

function trabajarActividad(datos,objeto){
 if(datos==""){
  var checkbox=document.getElementsByName('cbTrabajarActividad');
  let cant=checkbox.length;
  var params = "idInterno="+objeto.value+"&ajax=1&status="+objeto.checked;
  //for(let i=0;i<cant;i++){checkbox[i].checked=false;}
     
    controlador="actividades/trabajarActividad/?";
   peticionAJAX(controlador,params,'trabajarActividad');

 }else{

     var checkbox=document.getElementsByName('cbTrabajarActividad');
     let cant=checkbox.length;
    for(let i=0;i<cant;i++){if(checkbox[i].value==datos.idInterno){checkbox[i].checked=datos.status;i=cant;}}

    if(datos.status==false){
    	let actTrabajar=document.getElementsByClassName('actividadesTrabajandose');
    	let cantidad=actTrabajar.length;
    	for (var i = 0; i < cantidad; i++) {
    		if(actTrabajar[i].getAttribute('data-idInterno')==datos.idInterno){
                let padre=actTrabajar[i].parentNode;
                padre.removeChild(actTrabajar[i]);
                i=cantidad;
    		} 	
    	}
    }
    else{
    	let actTrabajar=document.getElementsByClassName('actividadesTrabajandose');
    	let cantidad=actTrabajar.length;
    	let bandExistencia=0;
    	for (var i = 0; i < cantidad; i++) {
    		if(actTrabajar[i].getAttribute('data-idInterno')==datos.idInterno){
    			bandExistencia=1;
    		} 	
    	}
   
    	if(bandExistencia==0){
          	var div=document.createElement('div');
	       // actividadesTrabajandose
	        div.setAttribute('class','row actividadesTrabajandose');
	        div.setAttribute('id',datos.idInterno);
	        div.innerHTML=datos.usuarioTrabaja+'->'+datos.folioActividad+' ('+datos.usuarioResponsable+')';

	        document.getElementById('divActividadTrabajandose').appendChild(div);

    	}
    }
    if(datos.mensaje!=''){alert(datos.mensaje);}
 }

}


function peticionAJAX(controlador,parametros,funcion){
  var req = new XMLHttpRequest();var direccionAJAX="<?= base_url();?>";
  var url=direccionAJAX+controlador;//+parametros;
  //abreCierraEspera();
 req.open('POST', url, true);
  req.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
   req.onreadystatechange = function (aEvt) 
  {
    if (req.readyState == 4) {
      if(req.status == 200)
        { 
          
         var respuesta=JSON.parse(this.responseText);    
      
         switch(funcion){
          case 'trabajarActividad':trabajarActividad(respuesta,'');break;
          default:  window[funcion](respuesta);break; 

         }                                                           
      }     
   }
  };
 req.send(parametros);
}


 function nuevaVentana(e,objeto){
 	 	e.preventDefault();

 	window.open(objeto.getAttribute('href'));
 }
function calificacionMala(e,objeto){
 e.preventDefault();
var textoEscrito = prompt("Motivo de calificacion mala", "");
if(textoEscrito != null ){
	if(textoEscrito!=''){direccion=objeto.getAttribute('href')+'&comentario='+textoEscrito;window.location.href=direccion;}
    else{alert("El comentario es obligatorio");}
}
 


 
}
function seleccionar_todo(nombreFormulario)
{ var f = document.forms[nombreFormulario.name];for (i=0;i<f.elements.length;i++) {if(f.elements[i].type == "checkbox"){f.elements[i].checked=1}}}
function deseleccionar_todo(nombreFormulario)
{var f = document.forms[nombreFormulario.name];for(i=0;i<f.elements.length;i++){if(f.elements[i].type == "checkbox"){f.elements[i].checked=0 }}}
function todas(nombreFormulario, tipoTodas){var f = document.forms[nombreFormulario.name];f.tipo.value = tipoTodas;f.submit();}

</script>
<style type="text/css">.tiempoExcedido{background-color: red;color:white}.tiempoAcabando{background-color: orange;color: white}.tiempoNormal{background-color: green;color:white}.sinNormal{background-color: white;color:black}.divPromotoria p {color: white;background-color:#0857b9;display: none}.divPromotoria div {}.divPromotoria:hover {cursor:pointer;}.divPromotoria:hover  p{display: inline-flex;height:50px; width: 150px; overflow: auto;} .btnRam{padding: 2px; border: solid black 1px; color: black; background-color: #b4a5cb}.btnRamoFIANZAS{color: black;background-color:#fdd792;padding: 2px;border: solid black 1px;width: 140px;margin-left: 5px	}.btnRamoDANOS{color: black;background-color:#fdd792;padding: 2px;border: solid black 1px;width: 140px;margin-left: 5px}.btnRamoVEHICULOS{color: black;background-color:#7474c3;padding: 2px;border: solid black 1px;width: 140px;margin-left: 5px}.btnRamoACCIDENTES_Y_ENFERMEDADES{color: black;background-color:#e26666;padding: 2px;border: solid black 1px;width: 140px;margin-left: 5px}.btnRamoVIDA{color: black;background-color:#7bdc77;padding: 2px;border: solid black 1px;width: 140px;margin-left: 5px}.btncotizaciones{color: black;background-color:#8762c8;padding: 2px;border: solid black 1px;width: 140px;margin-left: 5px}.btnotrasActividades{color: black;background-color:#afd584;padding: 2px;border: solid black 1px;width: 140px;margin-left: 5px}.btnAgente{color: black;background-color:#e68f6f;padding: 2px;border: solid black 1px;width: 110px}.btnEnCurso{color: black;background-color:#89cbd3;padding: 2px;border: solid black 1px;width: 110px}.divBotones{display: list-item; width: 300px}.menuFlotante{border: solid;width: 200px}.menuFlotante  a{display: block;}.contMenuFlotante{background: none repeat scroll 0 0 #FFFFFF;border: 1px solid #DDDDDD;border-radius: 6px 6px 6px 6px;bottom: 10px;right: 140px;margin-left: -10px;padding: 10px 0 0;position: fixed;text-align: center;width: 20px;z-index: 10000;padding: 0px; margin: 0px;}.vertical-menu {width: 15px;}.vertical-menu a {display: block;padding: 0px;text-decoration: none;}.vertical-menu a:hover {background-color: #ccc;}.vertical-menu a.active { color: red;}.tituloAgente{color: black;background-color:#e68f6f; font-size:1.5em; width: 100%; height: 30px}.tituloAgente > a{color: black;}.tituloEnCurso{color: black;background-color:#89cbd3; font-size:1.5em; width: 100%; height: 30px}
   .prueba:focus {color:pink;}
   a:active {color: blue;}
   .spanTotal{    ; color:white;background-color: black; border: solid .01em black}
   .actividadesTrabajandose{width:300px;border-bottom:solid black; color:white; background-color:green; position:relative;left:-150px}
   .ocultarObjeto{display: none;}
   .seleccionRowCambioResponsable{color: white;background-color: green;}
   .seleccionRowCambioResponsable > td{color: white;background-color: green}
   
</style>
<?if(isset($selectTipoFiltro)){?>
<script type="text/javascript">
  document.getElementById('selectTipoFiltro').value="<?=$selectTipoFiltro?>"; 
  escogerTipoFiltro(document.getElementById('selectTipoFiltro').value); 
  document.getElementById('selectValorFiltro').value="<?=$selectValorFiltro?>";
  escogerFiltroRows(document.getElementById('selectValorFiltro'));
</script>

<?}?>
<script type="text/javascript">
function seleccionarRow(objeto){objeto.classList.toggle('seleccionRowCambioResponsable');}    
function cambiarResponsablesNuevos(datos='')
{
    if(datos=='')
  {
    let clase=document.getElementsByClassName('seleccionRowCambioResponsable');
    let cant=clase.length;
    let idInterno='';
    for(let i=0;i<cant;i++){idInterno+=clase[i].dataset.idinterno+',';}
    if(idInterno!='')
    {
     let valor=document.getElementById('nuevoResponsableSelect').value;
     if(valor!='')
     {      
      
      var params = "idInterno="+idInterno;    
      params+='&nuevoResponsable='+valor; 
      controlador="actividades/cambiarResponsablesNuevos/?";
      peticionAJAX(controlador,params,'cambiarResponsablesNuevos');      
     }
     else{alert('Escoger nuevo responsable')}

    }
    else{alert('Escoger actividad para cambiar de responsable');}



  }
  else
  {
    document.getElementById('detenerRecargaChecked').checked=false;
    actualizar();
  }

}
</script>
<style type="text/css">
    progress{height: 30px;color:red;width: 100%;background-color: black;}
    #folioBuscado{z-index: 0}
</style>
<script type="text/javascript">
    document.getElementById('btnActividadesEnRojo').addEventListener("click", function(){
        document.getElementById('divActividadesEnRojo').classList.toggle('ocultarObjeto');
        if(this.dataset.char==128071){this.dataset.char='128070';this.innerHTML='&#128070';}
        else{this.dataset.char=128071;this.innerHTML='&#128071';}
    })
    let actRojo=document.querySelectorAll('button[name=btnFolioActRojo]');
    actRojo.forEach(b=>{b.addEventListener("click",function(){
        
        let hijos=document.querySelectorAll(`tr[name=${b.dataset.folio}CabRojo]`);
        if(this.innerHTML=='+'){this.innerHTML='-';hijos.forEach(h=>{h.classList.remove('ocultarObjeto');})}else{this.innerHTML='+';hijos.forEach(h=>{h.classList.add('ocultarObjeto');})}
        
    })})
    
    document.getElementById('divActividadesEnRojo').classList.toggle('ocultarObjeto');
</script>

<script type="text/javascript">
  
  if(document.getElementById('divEjecutivosOperativos'))

  {
    document.getElementById('divEjecutivosOperativos').parentNode.removeChild(document.getElementById('divEjecutivosOperativos'));
  }
</script>