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
<?php 
	$this->load->view('headers/header'); 
?>
<!-- Navbar -->
<?php
	$this->load->view('headers/menu');
?>
<!-- End navbar -->
<!--section class="container-fluid breadcrumb-formularios">
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
		<div class="panel-body">

		<div class="row" style="padding-bottom:5px;">
			<div class="col-sm-12 col-md-12" align="right">
			</div>
		</div>

        <div class="row">
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
        

        
        <div class="row">
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
						<tr scope="row">
                        <div class="clearfix" style="float:left;">
                        	<font class="subTituloSeccione">
                            	Actividades Importantes:
                            </font>
						</div>
                        </tr>
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


		</div>

</div>
    </div>




</section-->
<section class="container-fluid breadcrumb-formularios">
<div class="row">

	<select id="selectPromotorias" onchange="filtroCompanias()"></select>
	<input type="checkbox" id="cbFiltroCompanias" onclick="filtroCompanias()">
</div>
</section>

      <div class="row"><!-- Trabajando en Agente Capital -->
        	<div class="col-sm-12 col-md-12">
				<table class="table table-striped table-bordered table-sm" id="tablaActividades">
					<thead>

						<tr scope="row" bgcolor="#A391C0" valign="top">
							<th scope="col">Folio</th>
							<th scope="col">Fecha recepcion</th>
							<th scope="col">Aseguradoras</th>
							<th scope="col" onclick="ordenaTabla(this,'tBodyActividades')" data-tipo="string" class="ordenaColumna">Estado↓↑</th>
                            <th scope="col">Fecha</th>
                            <th scope="col" onclick="ordenaTabla(this,'tBodyActividades')" data-tipo="string" class="ordenaColumna">Actividad↓↑</th>
                            <th scope="col">SubRamo</th>
                            <th scope="col">Cliente</th>
                        </tr>
                	</thead>
					<tbody id="tBodyActividades">

 <?php foreach ($ActividadesTrabajandose as $key => $value) { ?>
   					<? 
						foreach($ActividadesTrabajandose[$key] as $row){$semaforoNew="";							
							$clase=controlaSemaforos($row->tiempoSemaforo,$row->Status,$row->horasOficinaCP,$row->horasPortalCP,$row->tipoActividad);
						$bandImpresion=0;
						if($row->Status==2){$bandImpresion=1;}
						if($row->actividadImportante==1){$bandImpresion=1;}
						if($row->actividadUrgente==1){$bandImpresion=1;}
                        if($clase=='tiempoExcedido'){$bandImpresion=1;}
                       if($bandImpresion){
					?>
						<tr scope="row" style="font-size:12px;"  data-fp="<?=$row->filtroPromotorias; ?>" class="verObjeto">
							<td scope="col" align="center">
                            	<a href="<?=base_url()."actividades/ver/".$row->folioActividad?>" title="<?=$row->datosExpres?>">
                            	<div class="<?=$clase?>">
								<?=$row->folioActividad."<br />"?>
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
								                                <?
							if($siPuedeDesmarcar && $row->actividadImportante==1 ){
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

 <?php } ?>
                    </tbody>
				</table>
            </div>


 <
<?php $this->load->view('footers/footer'); ?>
<?php 


function  controlaSemaforos($tiempoSemaforo,$Status,$horasOficinaCP,$horasPortalCP,$tipoActividad){
	$tiempo='tiempoNormal';
	if($tipoActividad=="Emision" || $tipoActividad=="Cotizacion")
	{
      if($Status==5){
      	if($tiempoSemaforo!=NULL)
      	{
          if($tiempoSemaforo>$horasPortalCP){$tiempo="tiempoExcedido";}
          else{if((($tiempoSemaforo*100)/$horasPortalCP)>=70){$tiempo="tiempoAcabando";}}
        }
      else{$tiempo="sinTiempo";}

    }
    else{
      	 if($Status==2)
      	 {
           if($tiempoSemaforo!=NULL)
           { if($tiempoSemaforo>$horasOficinaCP){$tiempo="tiempoExcedido";}
             else{if((($tiempoSemaforo*100)/$horasOficinaCP)>=70){$tiempo="tiempoAcabando";}}
           }
           else{$tiempo="sinTiempo";}
      	 }
        }
	}
	return $tiempo;
}

?>

<script type="text/javascript">
var promotorias=[];
Array.prototype.unique=function(a){
  return function(){return this.filter(a)}}(function(a,b,c){return c.indexOf(a,b+1)<0
});

	var miTabla=document.getElementById('tablaActividades');
	var cantidad=miTabla.rows.length;
	for(var i=0;i<cantidad;i++){
		if(miTabla.rows[i].getAttribute('data-fp')!=null && miTabla.rows[i].getAttribute('data-fp')!=''){
		var dato=miTabla.rows[i].getAttribute('data-fp');
		// console.log(dato);
		var array=dato.split('|');
	    for(var j=0;j<array.length;j++){
	    	if(array[j]!=''){promotorias.push(array[j]);}
	    }
	  }
	}

promotorias=promotorias.unique();
var cadSelect=""
for(var i=0;i<promotorias.length;i++)
{
  cadSelect=cadSelect+'<option>'+promotorias[i]+'</option>';
}
document.getElementById('selectPromotorias').innerHTML=cadSelect;

function filtroCompanias()
{   var check=document.getElementById("cbFiltroCompanias");
	var select=document.getElementById('selectPromotorias');
	var selectValor=select.value;
	var tbody=document.getElementById('tBodyActividades');
	var cantTbody=tbody.rows.length;
	if(check.checked){
	for(var i=0;i<cantTbody;i++)
	{
	 var datafp=tbody.rows[i].getAttribute('data-fp');
	 var companias=datafp.split('|');
	 var cantCompanias=companias.length;
	 var band=0;
     if(companias[0]!=""){
	 for(var j=0;j<cantCompanias;j++){
	 	if(companias[j]==selectValor){
            band=1;
            j=cantCompanias;
	 	}
	 }
	 
	}
	 else{band=0;}
	 if(band){
       tbody.rows[i].classList.remove('ocultarObjeto');
       tbody.rows[i].classList.add('verObjeto');  
        //tbody.rows[i].classList.remove('verObjeto');
	 }
	 else{
	 	  tbody.rows[i].classList.add('ocultarObjeto');
     //  tbody.rows[i].classList.remove('verObjeto');  
	 }
	}
   }
   else{
   		for(var i=0;i<cantTbody;i++)
         {
       tbody.rows[i].classList.remove('ocultarObjeto');
       tbody.rows[i].classList.add('verObjeto');  
        //tbody.rows[i].classList.remove('verObjeto');

	}
   }

}




function ordenaTabla(cellObjeto,tablaString){
   var body=document.getElementById(tablaString);
   var n, i, k, aux;
   var formaOrdenar="";
   n = body.rows.length;
   var index=cellObjeto.cellIndex;
 
   if(cellObjeto.getAttribute('data-order')==''){formaOrdenar='Desc';}
   switch(cellObjeto.getAttribute('data-order'))
   {
    case 'Desc':formaOrdenar='Asc';break;
    case 'Asc':formaOrdenar='Desc';break;
    default : formaOrdenar='Desc'; break;
   }
   if(cellObjeto.getAttribute('data-tipo')=='digito')
   {
     for (k = 1; k < n; k++) {
      if(formaOrdenar=='Desc'){
        for (i = 0; i < (n - k); i++) {                
            if (parseFloat(body.rows[i].cells[index].getAttribute("data-valor") ) > parseFloat(body.rows[i+1].cells[index].getAttribute("data-valor"))){body.rows[i].parentNode.insertBefore(body.rows[i + 1], body.rows[i]);}
        }
      
       }
       else{
                for (i = 0; i < (n - k); i++) {                
            if (parseFloat(body.rows[i].cells[index].getAttribute("data-valor") ) < parseFloat(body.rows[i+1].cells[index].getAttribute("data-valor"))){body.rows[i].parentNode.insertBefore(body.rows[i + 1], body.rows[i]);}
        }
       }
    }
    }
    else{ 	 
          for (k = 1; k < n; k++) {
          	
              if(formaOrdenar=='Desc'){
        for (i = 0; i < (n - k); i++) {    
           if(body.rows[i].classList.contains('verObjeto')){
            if (body.rows[i].cells[index].innerHTML.toLowerCase() < body.rows[i+1].cells[index].innerHTML.toLowerCase()){body.rows[i].parentNode.insertBefore(body.rows[i + 1], body.rows[i]);}
          }
        }
      }else{
                 for (i = 0; i < (n - k); i++) {    
           if(body.rows[i].classList.contains('verObjeto')){
            if (body.rows[i].cells[index].innerHTML.toLowerCase() > body.rows[i+1].cells[index].innerHTML.toLowerCase()){body.rows[i].parentNode.insertBefore(body.rows[i + 1], body.rows[i]);}
           }
        }
      }
    }
    }
 cellObjeto.setAttribute('data-order',formaOrdenar);
} 



</script>
<style type="text/css">.tiempoExcedido{background-color: red;color:white}.tiempoAcabando{background-color: orange;color: white}.tiempoNormal{background-color: green;color:white}.sinNormal{background-color: white;color:black}.divPromotoria p {color: white;background-color:#0857b9;display: none}.divPromotoria div {color: white; background-color: #03345b;}.divPromotoria:hover {cursor:pointer;}.divPromotoria:hover  p{display: inline-flex;height:50px; width: 150px; overflow: auto;} .btnRam{padding: 2px; border: solid black 1px; color: black; background-color: #b4a5cb}.btnRamoDANOS{color: black;background-color:#fdd792;padding: 2px;border: solid black 1px;width: 110px;margin-left: 5px}.btnRamoVEHICULOS{color: black;background-color:#7474c3;padding: 2px;border: solid black 1px;width: 110px;margin-left: 5px}.btnRamoACCIDENTES_Y_ENFERMEDADES{color: black;background-color:#e26666;padding: 2px;border: solid black 1px;width: 110px;margin-left: 5px}.btnRamoVIDA{color: black;background-color:#7bdc77;padding: 2px;border: solid black 1px;width: 110px;margin-left: 5px}.btncotizaciones{color: black;background-color:#8762c8;padding: 2px;border: solid black 1px;width: 110px;margin-left: 5px}.btnotrasActividades{color: black;background-color:#afd584;padding: 2px;border: solid black 1px;width: 110px;margin-left: 5px}.btnAgente{color: black;background-color:#e68f6f;padding: 2px;border: solid black 1px;width: 110px}.btnEnCurso{color: black;background-color:#89cbd3;padding: 2px;border: solid black 1px;width: 110px}.divBotones{display: list-item; width: 300px}.menuFlotante{border: solid;width: 200px}.menuFlotante  a{display: block;}.contMenuFlotante{background: none repeat scroll 0 0 #FFFFFF;border: 1px solid #DDDDDD;border-radius: 6px 6px 6px 6px;bottom: 10px;right: 100px;margin-left: -10px;padding: 10px 0 0;position: fixed;text-align: center;width: 20px;z-index: 10000;padding: 0px; margin: 0px;}.vertical-menu {width: 10px;}.vertical-menu a {display: block;padding: 0px;text-decoration: none;}.vertical-menu a:hover {background-color: #ccc;}.vertical-menu a.active { color: red;}.tituloAgente{color: black;background-color:#e68f6f; font-size:1.5em; width: 100%; height: 30px}.tituloAgente > a{color: black;}.tituloEnCurso{color: black;background-color:#89cbd3; font-size:1.5em; width: 100%; height: 30px}
   .prueba:focus {color:pink;}
   a:active {color: blue;}
   .ordenaColumna{border: solid; font-size: large; color: red }
   .ordenaColumna:hover{background-color: #ac96ce; cursor: pointer;}
   .verObjeto{display:  table-row;}
   .ocultarObjeto{display:none;}

   
</style>