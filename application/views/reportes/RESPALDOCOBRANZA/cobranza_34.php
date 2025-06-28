<?php $this->load->view('headers/header');$this->load->view('headers/headerReportes'); ?>
<?php $this->load->view('headers/menu');?>

 

<? $filtros['cliente']='selectCobPenCliente';$filtros['vendedor']='selectCobPenVend';$filtros['subRamo']='selectCobPenSubRamo';$filtros['fechaLimite']='selectCobPenFecLim';$filtros['documento']='selectCobPenDocumento' ;$filtros['endoso']='selectEndosoCobPen';$filtros['ramosnombre']='selectCobPenRamosNombre';$filtros['cianombre']='selectCobPenCiaNombre';$filtros['ccobro_txt']='selectCobPenCCobro_TXT';$filtros['serie']='selectCobPenSerie';$cobranzaPendienteArmado=imprimirCobranzaPendiente($cobranzaPendiente,'cbSeleccionCP','bodyTablaCobPen',$filtros,$opcionFecha,$envioEmail); ?>
    
<? $filtros['cliente']='selectCobAtraCliente';$filtros['vendedor']='selectCobAtraVend';$filtros['subRamo']='selectCobAtraSubRamo';$filtros['fechaLimite']='selectCobAtraFecLim'; $filtros['documento']='selectCobAtraDocumento';$filtros['endoso']='selectCobAtraEndoso';$filtros['ramosnombre']='selectCobAtraRamosNombre';$filtros['cianombre']='selectCobAtraCiaNombre';$filtros['ccobro_txt']='selectCobAtraCCobro_TXT';$filtros['serie']='selectCobAtraSerie';$cobranzaAtrasadaArmado=imprimirCobranzaPendiente($cobranzaAtrasada,'cbSeleccionCA','bodyTablaCobAtrasada',$filtros,$opcionFecha,$envioEmail); ?>
  <link rel="stylesheet" href="//code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
  <script src="https://code.jquery.com/jquery-1.12.4.js"></script>
  <script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
<!-- Modificacion Miguel Jaime 30/11/2020 - Estilo de Div de Notificaciones Flotante-->
 <style type="text/css">
	.alerta{
		position:fixed;
        left: 75%;
		width: 20%;
		height: 180px;
		border-radius: 8px;
		background-color:#fff; 
		bottom: 5%;
		z-index: 1;
	}
	.notificacion{
		text-align: center;
		height: auto;
		background-color: #E2E2E2;
	}
	.cobranzaAtrasada{
		margin: 5px;
		border-radius: 4px;
		width: 95%;
		height: 20px;
		background-color: red;
		color: white;
	}
	.cobranzaPendiente{
		margin: 5px;
		border-radius: 4px;
		width: 95%;
		height: 20px;
		background-color: yellow;	
	}
	.cobranzaEfectuada{
		margin: 5px;
		border-radius: 4px;
		width: 95%;
		height: 20px;
		background-color: green;
		color: #fff;	
	}
    .renovacionPendiente
    {

        margin: 5px;
        border-radius: 4px;
        width: 95%;
        height: 20px;
        background-color: #5e5db7;
        color: #fff;    
    }

	.cerrar{
		text-align: right;
	}
</style>
<!-- Fin del Estilo del Div de Notificaciones Flotante-->

<div class="divPrincipal">
<div class="divMenu">
 <div>
 	<div  class="divMenuBoton" >     
 		<form id="formDocumentoRecibo" action="javascript: enviarArchivoAJAX('formDocumentoRecibo','subirRecibo')" style="display: inline-flex;">
       <label  for="archivoProc" id="labelArchivoProc"  >Recibo</label> 
  

      </form>
  </div>
 	<div class="divMenuBoton"> <form id="formDocumentoComprobante" action="javascript: enviarArchivoAJAX('formDocumentoComprobante','subirComprobante')" style="display: inline-flex;">
       <label  for="archivoProc"  id="labelArchivoComprobante">Comprobante</label> 

      </form></div>
 	
 	<div class="divMenuBoton" ><button id="btnAgregarComentario" class="btnLateralCobranza" onclick="agregarComentario('')">Agregar comentario</button></div>
 	<div class="divMenuBoton"  ><button id="btnCorreoPendiente" class="btnLateralCobranza" onclick="enviarCorreos('','cbSeleccionCP','bodyTablaCobPen')">Correo</button></div>
<? if($idVendedor==0){?>
 	<div class="divMenuBoton" ><button id="btnWhats" class="btnLateralCobranza" onclick="enviarWhats('','cbSeleccionCP','bodyTablaCobPen')">Whats</button></div>
 	<div class="divMenuBoton" ><button id="btnSMS" class="btnLateralCobranza" onclick="enviarSMS('','cbSeleccionCP','bodyTablaCobPen')">SMS</button></div>
<? }else{
	if($saldo>5){?>
<div class="divMenuBoton" ><button id="btnWhats" class="btnLateralCobranza" onclick="enviarWhats('','cbSeleccionCP','bodyTablaCobPen')">Whats</button></div>
 	<div class="divMenuBoton" ><button id="btnSMS" class="btnLateralCobranza" onclick="enviarSMS('','cbSeleccionCP','bodyTablaCobPen')">SMS</button></div>

	<?}else{?>
<div class="divMenuBoton" ><label id="btnWhats" class="btnLateralCobranza" style="background-color: #c1bdbd" title="No tienes saldo">Whats</label></div>
 	<div class="divMenuBoton" ><label id="btnSMS" class="btnLateralCobranza" style="background-color: #c1bdbd" title="No tienes saldo">SMS</label></div>

	<?}
	
	?>
   
<?}?>

 	<div class="divMenuBoton" ><button class="btnLateralCobranza" id="btnExportar" onclick="exportarExcel('')">Exp. Cobranza</button>

 	</div>
  <div class="divMenuBoton" ><button class="btnLateralCobranza" id="btnBuscarPoliza" onclick="buscarPoliza('')">Buscar Poliza</button>

 	</div>
    <div class="divMenuBoton" ><button class="btnLateralCobranza" id="btnBuscarPolizaCliente" onclick="buscarPorCliente('')">Buscar por Cliente</button>    	
 	</div>
   <div class="divMenuBoton" ><button class="btnLateralCobranza" id="btnGuionTelefonico"data-toggle="collapse" href="#guion_tel" aria-expanded="false" aria-controls="guion_tef" >Guión telefónico</button>    	
 	</div>
    <div class="divMenuBoton" ><button class="btnLateralCobranza" id="btnRenovacion" onclick="ventanaRenovacion('')">Renovacion</button></div>
<?if($permisoCancelarCobranza==1) {?> 	    <div class="divMenuBoton" ><button class="btnLateralCobranza" id="btnBuscarPoliza" onclick="cerrarModal('divModalParaFacturar')">Cancelacion</button>

 	</div>
 <? } ?>
 <div class="divMenuBoton" ><button class="btnLateralCobranza" id="btnActividades">Actividades</button>
  <div class="submenuBoton"><button onclick="crearActividades('Endoso','A')" title="Tipo A .- El endoso A genera primas adicionales para cobro, como ejemplo cambio de suma asegurada, agregar a un asegurado a una póliza existente.">Endoso tipo A</button><button onclick="crearActividades('Endoso','B')" title="Tipo B .- El endoso B, es cualquier cambio a la póliza que no genera primas, como cambio de dirección, cambio de placas.">Endoso tipo B</button><button onclick="crearActividades('Endoso','D')" title="Tipo D .- El endoso D cualquier cambio que genera disminución como eliminación de coberturas, baja de algún asegurado o incremento de deducible. El endoso D genera una nota de crédito.">Endoso tipo D</button>
<button onclick="crearActividades('Cancelacion','Cancelacion')">Cancelacion</button>
  </div>
 </div>
 </div>


</div>

<input type="hidden" name="base" id="base" value="<?php echo base_url();?>">
<div class="divContenido">
 
<div class="container">

	<ul class="tabs">
		<li class="tab-link current" data-tab="tab-1"><h4 style="font-size: 16px;">COBRANZA PENDIENTE</h4></li>
		<!--li class="tab-link" data-tab="tab-6" style="display: none"><h4 style="font-size: 16px;">RENOVACIONES</h4></li-->
		
	</ul>

	<div id="tab-1" class="tab-content current">
		<div ><form method="post" action="<?=base_url()?>cobranza" id="formCobranzaPendiente">
	<? if((count($permisosCanales))>0){ ?><label>COBRANZA:
	<select class="form-control" name="opcion" value="institucional">
	<? $option="";
      foreach ($permisosCanales as  $value) {
      	$seleccion="";
      	if($opcion==$value->value){$seleccion='selected="selected"';}
      	$option.='<option value="'.$value->value.'" '.$seleccion.'>'.$value->texto.'</option>';
      }
      echo $option;
	?>

	</select></label>
<? }?>
    <label>FECHA:<select name="opcionFecha" class="form-control">
    	<option value="FLimPago" <? if($opcionFecha=='FLimPago'){echo('selected="selected"')  ;} ?>>FLimPago</option>
    	<option value="FDesde" <? if($opcionFecha=='FDesde'){echo('selected="selected"')  ;} ?>>FDesde</option>
    	<option value="FHasta" <? if($opcionFecha=='FHasta'){echo('selected="selected"')  ;} ?>>FHasta</option>
    </select></label>
    	<label>FECHA INICIAL:<input type="text" name="fechaInicial" class="form-control fechaBusqueda" id="fechaInicial" autocomplete="off"></label><label>FECHA FINAL:<input type="text" name="fechaFinal" id="fechaFinal" class="form-control fechaBusqueda" autocomplete="off"></label>
    	<label style="display: none;">DIAS DE COBRANZA ATRASADA<select name="selecDiaCobAtra" id="selecDiaCobAtra" class="form-control"><option>0</option><option>5</option><option>10</option><option>15</option><option>20</option><option>25</option><option>30</option><option>60</option></select></label>
	   <label><input type="submit" name="enviar" class="btn btn-primary form-control"></label>

</form>

<!------------------->
<div class="collapse mt-4 mb-4" id="guion_tel">
					<div class="card card-body">
						<h4>Guión telefónico</h4>
						<div class="row">
							<div class="col-md-2">
								<div class="list-group" id="myList" role="tablist">
									<?php if(!empty($guionTelefonico)){ 
										foreach($guionTelefonico as $id => $d_g){?>
											<a class="list-group-item list-group-item-action" data-toggle="list" href="#g_<?=$id?>" role="tab"><?=$d_g["nombre"]?></a>
									<?php }
										}?>
								</div>
							</div>
							<div class="col-md-10">
								<!-- Tab panes -->
								<div class="tab-content d-block">
									<div class="tab-pane bg-white active" id="inicio" role="tabpanel">
										<h3 class="text-center mt-12 mb-10">Visualice cualquier de los ejemplos del lado izquierdo</h3>
									</div>
									<?php if(!empty($guionTelefonico)){ 
										foreach($guionTelefonico as $id => $d_g){?>
										<div class="tab-pane bg-white" id="g_<?=$id?>" role="tabpanel">
										<h4>Ejemplo de guía telefónica (Guión de Cobranza)</h4>
										<br>
										<div class="ml-4">
											<?php foreach($d_g["mensaje"] as $conversacion){?>
												<span class="badge badge-primary mb-2"><?=$conversacion["etiqueta"]?></span><br>
												<p class="text-dark font-italic"><?=$conversacion["texto"]?></p><br>
											<?php }?>
										</div>
									</div>
									<?php }
										}?>
								</div>
							</div>
						</div>
					</div>
				</div>
			<!------------------->
</div>


</div>


	<div style="display: inline-flex;border: solid">
		<div id="divTotalCob"><h4><span id="spanTotalCob" class="badge pull-right"></span>COBRANZA PENDIENTE:</h4></div>
		<div style="border:solid;">
		<div id="divTotalCobPenSinDoc">TOTALES</div>
		<div id="divTotalCobranzaConDoc"></div>
		<div id="divTotalCobranzaConDocRec"></div>
		</div>
	</div>

  <div id="divContenedorTabla" style="overflow-x: scroll; width: 80%; margin-left: 20px;margin-right: 20px">
	<div style="width:100%;border:double;overflow:hidden" id="scrollCabeceraCP">
      <table border="1" id="">
	    <thead>
		  <tr valign="top">
			<th class="divTD15" ><input type="checkBox"  onclick="seleccionarCB(this,'bodyTablaCobPen','cbSeleccionCP')" class="cbSeleccionCP"></th>
			<th class="divTD150" ><div>Documento</div><div><?= $cobranzaPendienteArmado['filtroDocumento']?></div></th>
			<th class="divTD75">
				<div><br><input type="text" class="form-control" onblur="filtraSelect(this.value,'selectFiltroDocumento')"><br><select class="form-control" id="selectFiltroDocumento" onchange="aplicarFiltro(this,'bodyTablaCobPen','selectFiltroDocumento','ocultarObjetoEndoso')"><option value=""></option><option value="sindocumentos">SIN DOCUMENTO</option><option value="recibo">RECIBO</option><option value="comprobante">COMPROBANTE</option><option value="recibocomprobante">RECIBO Y COMPROBANTE</option></select></div>
			</th>
			<th class="divTD25"></th>
			<th class="divTD100 ocultarObjeto">Recibo</th>
			<th class="divTD75"><div>Periodo</div><div><?= $cobranzaPendienteArmado['filtroSerie']?></div></th>
			<th class="divTD150"><div>Endoso</div><div><?= $cobranzaPendienteArmado['filtroEndoso']?></div></th>
			<th class="divTD400"><div>Cliente</div><div><?= $cobranzaPendienteArmado['filtroCliente']?></div></th>
			<th class="divTD400"><div>Vendedor</div><div><?= $cobranzaPendienteArmado['filtroVendedor']?></div></th>
			<th class="divTD150"><div>Ramo</div><div><?= $cobranzaPendienteArmado['filtroRamosNombre']?></div></th>
			<th class="divTD150 ocultarCelda"><div>SubRamo</div><div><?php echo($cobranzaPendienteArmado['filtroSubramo']);?></div></th>
			
			<th class="divTD150">Email</th>
			<th class="divTD150">Telefono</th>
			<th class="divTD125"><div><?=$opcionFecha ?></div><div><?php echo($cobranzaPendienteArmado['filtroFecLimPago']);?></div></th>
			<th class="divTD125"><div>Compania</div><div><?= $cobranzaPendienteArmado['filtroCiaNombre']?></div></th>
			<th class="divTD125"><div>Conducto</div><div><?= $cobranzaPendienteArmado['filtroCCobro_TXT'] ?></div></th>
			<th class="divTD125">Prima total</th>
			<th class="divTD150">Pref. Comunic.</th>
			<th class="divTD150">Hr. Comunic.</th>
			<th class="divTD150">Dia Comunic.</th>
			<th class="divTD50" style="color: white; border: none;"></th>
		 </tr>
	    </thead>
 </table></div>
   <div onscroll="moverScroll(this,'scrollCabeceraCP')" id="scrollTabla" style="width:100%;overflow-x:scroll;overflow-y: scroll;height: 400px;border:double; float: left">			
    <table border="1" id="tableCobranzaPendiente">
	<tbody id="bodyTablaCobPen"><?php echo($cobranzaPendienteArmado['tabla']);?></tbody>
	<tfoot style="" id="tfootCobranzaPendiente">

	  </tfoot>
     </table>
    </div>
  </div>
  <div id="contenedorActividades">
  	<table class="table"><thead><tr><th>Folio</th><th>Comentario</th><th>Status</th></tr></thead><tbody id="seguimientoActividadesTbody"></tbody></table>
	</div>

	<div id="tab-2" class="tab-content">
	<div style="display: inline-flex;border: solid">
		<div id="divTotalCobAtrasada"><h4><span id="spanTotalCobAtrasada" class="badge pull-right"></span>COBRANZA ATRASADA:</h4></div>
		<div style="border:solid;">
		<div id="divTotalCobAtrasadaSinDoc">TOTALES</div>
		<div id="divTotalCobranzaAtrasadaConDoc"></div>
		<div id="divTotalCobranzaAtrasadaConDocRec"></div>
		</div>
	</div>
			<div id="divContenedorTablaAtrasada" style="overflow-x: scroll; width: 80%; margin-left: 20px;margin-right: 20px">
		<div style="width:100%;border:double;overflow:hidden" id="scrollCabeceraCA">
				<table border="1" id="">
	<thead>
		<tr>	
		    <th class="divTD15"><input type="checkBox" onclick="seleccionarCB(this,'bodyTablaCobAtrasada','cbSeleccionCA')" class="cbSeleccionCP"></th>		
			<th class="divTD150"><div>Documento</div><div><?= $cobranzaAtrasadaArmado['filtroDocumento']?></div></th>
			<th class="divTD75">
				<div><br><input type="text" class="form-control" onblur="filtraSelect(this.value,'selectCobAtraFiltroDocumento')"><br><select class="form-control" id="selectCobAtraFiltroDocumento" onchange="aplicarFiltro(this,'bodyTablaCobAtrasada','selectCobAtraFiltroDocumento','ocultarObjetoEndoso')"><option value=""></option><option value="sindocumentos">SIN DOCUMENTO</option><option value="recibo">RECIBO</option><option value="comprobante">COMPROBANTE</option><option value="recibocomprobante">RECIBO Y COMPROBANTE</option></select></div>
			</th>
			<th class="divTD25"></th>
			<th class="divTD100 ocultarObjeto">Recibo</th>
			<th class="divTD75"><div>Periodo</div><div><?= $cobranzaAtrasadaArmado['filtroSerie']?></div></th>
			<th class="divTD150"><div>Endoso</div><div><?= $cobranzaAtrasadaArmado['filtroEndoso']?></div></th>
			<th class="divTD400"><div>Cliente</div><div><?= $cobranzaAtrasadaArmado['filtroCliente']?></div></th>
			<th class="divTD400"><div>Vendedor</div><div><?= $cobranzaAtrasadaArmado['filtroVendedor']?></div></th>
			<th class="divTD150"><div>Ramo</div><div><?= $cobranzaPendienteArmado['filtroRamosNombre']?></div></th>
			<th class="divTD150 ocultarCelda"><div>SubRamo</div><div><?php echo($cobranzaAtrasadaArmado['filtroSubramo']);?></div></th>
			
			<th class="divTD150">Email</th>
			<th class="divTD150">Telefono</th>
			<th class="divTD125"><div><?=$opcionFecha ?></div><div><?php echo($cobranzaAtrasadaArmado['filtroFecLimPago']);?></div></th>
			<th class="divTD125"><div>Compania</div><div><?= $cobranzaAtrasadaArmado['filtroCiaNombre']?></div></th>
			<th class="divTD125"><div>Conducto</div><div><?= $cobranzaAtrasadaArmado['filtroCCobro_TXT'] ?></div></th>
			<th class="divTD125">Prima total</th>
			<th class="divTD150">Pref. Comunic.</th>
			<th class="divTD150">Hr. Comunic.</th>
			<th class="divTD150">Dia Comunic.</th>
			<th class="divTD50" style="color: white; border: none;"></th>
		</tr>
			</thead>
</table></div>
<div onscroll="moverScroll(this,'scrollCabeceraCA')" id="scrollTablaCA" style="width:100%;overflow-x:scroll;overflow-y: scroll;height: 400px;border:double; float: left">			
<table border="1" id="tableCobranzaAtrasada">
	<tbody id="bodyTablaCobAtrasada"><?php echo($cobranzaAtrasadaArmado['tabla']);?></tbody>
	<tfoot style="" id="tfootCobranzaAtrasada">

	</tfoot>
</table>
</div>
</div></div>

<div id="tab-6" class="tab-content">
	<div id="divRenovaciones">
	<div class="row">
		<label>FECHA INICIAL:<input type="text" name="fechaInicial" class="form-control fechaBusqueda" id="fechaInicialRenovacion" autocomplete="off"></label><label>FECHA FINAL:<input type="text" name="fechaFinal" id="fechaFinalRenovacion" class="form-control fechaBusqueda" autocomplete="off"></label>
		<button class="btn btn-primary" onclick="traerRenovaciones()">Enviar</button>
		<button class="btn btn-primary" onclick="renovarPre('')">Renovar igual</button>
		<button class="btn btn-primary" onclick="buscarPolizaVigente('')">Buscar Poliza</button>
	 <? if($idVendedor==0){?><button class="btn btn-warning" onclick="polizaNoRenovada()">No Renovar</button><?}?>	
	</div>	
     <div id="divContenedorTablaRenovaciones row" style="overflow-x: scroll; width: 100%; margin-left: 20px;margin-right: 20px">
	<div style="width:100%;border:double;overflow:hidden;" id="scrollCabeceraRenovaciones">
      <table border="1" id="">
	    <thead>
		  <tr valign="top">
			<th class="divTD50" ><input type="checkBox"  onclick="seleccionarCB(this,'bodyTablaRenovaciones','cbSeleccionRenovaciones')" class="cbSeleccionCP"></th>
			<th class="divTD150" ><div>Documento</div><div></div></th>
			<th class="divTD150"><div>Cliente</div><div></div></th>
			<th class="divTD150"><div>Vendedor</div><div><input type="text" id="textFiltrarVendedorRenovacion" class="form-control" onblur="filtraSelect(this.value,'selectFiltrarVendedorRenovacion')"><select id="selectFiltrarVendedorRenovacion" class="form-control" onchange="aplicarFiltro(this,'bodyTablaRenovaciones','selectFiltrarVendedorRenovacion','ocultarRowRenVend')"></select></div></th>
			<th class="divTD150"><div>Ramo</div><div><input type="text" id="textFiltrarRamoRenovacion" class="form-control" onblur="filtraSelect(this.value,'selectFiltrarRamoRenovacion')"><select id="selectFiltrarRamoRenovacion" class="form-control" onchange="aplicarFiltro(this,'bodyTablaRenovaciones','selectFiltrarRamoRenovacion','ocultarRowRenRamo')"></select></div></th>
					
			<th class="divTD150">Email</th>
			<th class="divTD150">Telefono</th>
			<th class="divTD150"><div>Compania</div><div><input type="text" id="textFiltrarCompaniaRenovacion" class="form-control" onblur="filtraSelect(this.value,'selectFiltrarCompaniaRenovacion')"><select id="selectFiltrarCompaniaRenovacion" class="form-control" onchange="aplicarFiltro(this,'bodyTablaRenovaciones','selectFiltrarCompaniaRenovacion','ocultarRowRenRamo')"></select></div></th>
			<th class="divTD150">Total</th>
			<th class="divTD150"><div>Forma de Pago</div><div><input type="text" id="textFiltrarFormaPagoRenovacion" class="form-control" onblur="filtraSelect(this.value,'selectFiltrarFormaPagoRenovacion')"><select id="selectFiltrarFormaPagoRenovacion" class="form-control" onchange="aplicarFiltro(this,'bodyTablaRenovaciones','selectFiltrarFormaPagoRenovacion','ocultarRowRenFormaPago')"></select></div></th>
			<th class="divTD150">Status</th><th class="divTD150">Fecha Hasta</th>
			<th class="divTD25" style="color: white; border: none;"></th>
		 </tr>
	    </thead>
 </table></div>
   <div onscroll="moverScroll(this,'scrollCabeceraRenovaciones')" id="scrollTablaRenovaciones" style="width:100%;overflow-x:scroll;overflow-y: scroll;height: 400px;border:double; float: left">			
    <table border="1" id="tableRenovaciones">
	<tbody id="bodyTablaRenovaciones "></tbody>
	<tbody id="bodyTablaVigentesCab"></tbody>
	<tbody id="bodyTablaVigentes"></tbody>
	<tfoot style="" id="tfootCobranzaRenovaciones">
  <tr><td class="divTD50"></td><td class="divTD150"></td><td class="divTD150"></td><td class="divTD150"></td><td class="divTD150"></td><td class="divTD150"></td><td class="divTD150"></td><td class="divTD150"></td><td class="divTD150"></td><td class="divTD50"></td></tr>
	  </tfoot>
     </table>
    </div>
  </div>

  </div>

</div>
<div id="miModal" >
	<div><button onclick="cerrar()" style="color: white;float:right;background-color:red; border:double;  ">Cerrar</button></div>
    <div id="Modalcontenido" class="modal-contenido"  >
    	 
</div>
</div>
<div class="contMenuFlotanteMinimizado" id="divMenuFlotante"><div><button class="buttonContMenuFlotante" onclick="maxminContMenuFlotante()">&#128070</button></div><hr><div><h3 id="labelNombreClienteMF"></h3><div><button onclick="verOcultarPanel(0)" class="btn btn-primary">DOCUMENTOS</button><button onclick="verOcultarPanel(7);traerDocumentosCliente()" class="btn btn-primary">DOC. PERSONALES</button><button onclick="verOcultarPanel(1)" class="btn btn-primary">ALTA TARJETA</button><button onclick="verOcultarPanel(2);mostrarTarjeta('')" class="btn btn-primary">TARJETAS</button><button onclick="verOcultarPanel(3);mostrarHistorial('')" class="btn btn-primary">HISTORIAL</button><button onclick="verOcultarPanel(4);mostrarComentarios('')" class="btn btn-primary">COMENTARIOS</button></button><button onclick="verOcultarPanel(6)" class="btn btn-primary">SOLIC. DE COBRO</button></button>
<?if($permisoAplicacionPago){ ?><button onclick="verOcultarPanel(5)" class="btn btn-primary">PAGO</button><?}?></div><hr>
<div class="panelMenuFlotante" id="divLinksDocumentos" name="panelMenuFlotante"></div><div class="panelMenuFlotante ocultarObjeto" id="divTarjetaClienteAlta" name="panelMenuFlotante">

		<input type="hidden" id="hiddenIDCliMF">
		<table class="table">
		<tr>
		<td align="left"><label class="etiquetaSimple">Numero de Tarjeta:</label></td>
		<td><div><span class="badge pull-right" id="spanNumeroTarjeta">0</span><input type="text" id="numeroTarjeta" class="form-control" onkeyup="totalCaracteres(this,'spanNumeroTarjeta')" ></div></td>
	    </tr>
	    <tr>
			<td align="left"><label class="etiquetaSimple">Vencimiento:</label></td>
			<td>
			<select id="mesTarjeta"  class="form-control"><option value="">Mes</option><option value="01">01</option><option value="02">02</option><option value="03">03</option><option value="04">04</option><option value="05">05</option><option value="06">06</option><option value="07">07</option><option value="08">08</option><option value="09">09</option><option value="10">10</option><option value="11">11</option><option value="12">12</option>
            </select>
           </td>
         </tr>
         <tr>
		<td align="left"><label class="etiquetaSimple">Año:</label></td>
		<td>
			<select id="yearTarjeta"  class="form-control input-sm">
                        	<option value="">Año</option><option value="2018">2018</option><option value="2019">2019</option><option value="2020">2020</option><option value="2021">2021</option><option value="2022">2022</option><option value="2023">2023</option><option value="2024">2024</option><option value="2025">2025</option><option value="2026">2026</option><option value="2027">2027</option><option value="2028">2028</option><option value="2029">2029</option><option value="2030">2030</option>
             </select>
            </td>
         </tr>
         <tr>
         <td align="left"><label class="etiquetaSimple">Codigo de seguridad:</label></td>
         <td><div><span class="badge pull-right" id="spanCodigoSeguridad">0</span><input type="text" id="codigoSeguridad"  class="form-control input-sm" onkeyup="totalCaracteres(this,'spanCodigoSeguridad')"></div></td>
         </tr>
         <tr>
         <td align="left"><label class="etiquetaSimple">Titular de la Tarjeta</label></td>
         <td><input type="text" id="titularTarjeta" name="titularTarjeta" class="form-control input-sm" placeholder="Como aparece en la tarjeta"></td>
        </tr>
        <tr>
         <td align="left"><label class="etiquetaSimple">Tipo de tarjeta:</label></td>
         <td><select id="tipoTarjeta" name="tipoTarjeta" class="form-control selectSimple"><option value="Visa">Visa</option><option value="Master Card">Master Card</option>
         <option value="American express">American Express</option>
             </select>
           </td>
          </tr>
         <tr>
       <td align="left"><label class="etiquetaSimple">Banco Emisor</label></td>
       <td><input type="text" id="bancoTarjeta" name="bancoTarjeta" class="form-control input-sm" placeholder="Banco emisor"></td>
   </tr>
   <tr>
       <td align="left"><label class="etiquetaSimple">Tipo de Aplicacion de pago:</label></td>
       <td><select id="tipoPagoTarjeta" name="tipoPagoTarjeta" class="form-control input-sm selectSimple">
                        	<option value="Un solo cargo">Un solo cargo</option>
                        	<option value="Domiciliada">Domiciliada</option>
                        	<option value="Meses sin intereses">Meses sin intereses</option>
                        </select></td>
      </tr>
       <tr>
          <td></td>
          <td align="right"><button class="btn btn-primary botonSimple" onclick="guardarTarjeta('')">Guardar</button></td>
        </tr>
      </table>

  </div>
  <div class="panelMenuFlotante ocultarObjeto" id="divTarjetaClientes" name="panelMenuFlotante">
  	
  	<table class="table">
  		<tr><td colspan="2"><select id="selectEscogerTarjeta" onchange="verTarjetas(this)" class="form-control"></select></td></tr>
        <tr><td><label class="etiquetaSimple">Numero de tarjeta</label></td><td><input type="text" id="numeroTarjeta2" class="form-control"></td></tr>
        <tr><td><label class="etiquetaSimple">Vencimiento</label></td><td><input type="text" id="vencimiento2" class="form-control"></td></tr>
        <tr><td><label class="etiquetaSimple">Año</label></td><td><input type="text" id="anio2" class="form-control"></td></tr>
        <tr><td><label class="etiquetaSimple">Codigo de seguridad</label></td><td><input type="text" id="codigoSeguridad2" class="form-control"></td></tr>
        <tr><td><label class="etiquetaSimple">Titular de tarjeta</label></td><td><input type="text" id="titularTarjeta2" class="form-control"></td></tr>
        <tr><td><label class="etiquetaSimple">Tipo de tarjeta</label></td><td><input type="text" id="tipoTarjeta2" class="form-control"></td></tr>
        <tr><td><label class="etiquetaSimple">Banco</label></td><td><input type="text" id="banco2" class="form-control"></td></tr>
        <tr><td><label class="etiquetaSimple">Tipo de Pago</label></td><td><input type="text" id="tipoPagoTarjeta2" class="form-control"></td></tr>
        <tr><td colspan="2"><button class="btn btn-danger botonSimple" onclick="cancelarTarjeta('')">Cancelar Tarjeta</button></td></tr>
  	</table>
  </div>
  <div class="panelMenuFlotante ocultarObjeto" id="divHistorialClientes" name="panelMenuFlotante"></div>
  <div class="panelMenuFlotante" id="divComentarios" name="panelMenuFlotante">
  	<div class="row">         	
  	  <div class="col-sm-2 col-md-2" ><label class="labelResponsivo"> Agregar Comentario:</label></div>
       <div class="col-sm-6 col-md-6" ><input type="" name="" id="comentarioAdicionalCobranzaUno" class="form-control" style="text-align: left"></div>
         <div class="col-sm-1 col-md-1" ><button class="btn btn-primary" onclick="agregarComentario('')">&#128172</button></div>
</div><hr>
 <div id="divComentariosContenedor" class="row"></div>
</div>
  <div class="panelMenuFlotante ocultarObjeto" id="divPagoCobranza" name="panelMenuFlotante">
  	<div style="display: flex;">
  		<div class="row col-sm-4 col-md-4" style="width: 50%; border-left: solid red 1px;background-color: white" >  		  	
  		  	<table class="table table-bordered"  style="background: #b3e6f9; background-color: white">
  		<tr>
  			<td align="left"><label class="etiquetaSimple">Fecha de Pago:</label></td>
  			<td align="left"><input type="text" name="" class="form-control fecha" id="textFecPago"></td>
  		</tr>
  		  <tr>
  			<td align="left"><label class="etiquetaSimple">Folio de Cheque:</label></td>
  			<td align="left"><input type="text" name="" class="form-control" id="textFolCheque"></td>
  		</tr>
  		  <tr>
  			<td align="left"><label class="etiquetaSimple">Tipo de Documento:</label></td>
  			<td align="left"><select name="" class="form-control" id="selectTipoDocto"><option>Cheque</option><option>CONCILIACION</option><option>Deposito</option><option>Efectivo</option><option>MESES SIN INTERESES</option><option>TARJETA DE CREDITO Y/O DEBITO</option><option>Transferencia</option></select></td>
  		</tr>
  		  		  <tr>
  			<td align="left"><label class="etiquetaSimple">Banco:</label></td>
  			<td align="left"><select  name="" class="form-control" id="selectBancos"><?= armaSelects($bancos,'','descripcionBancos'); ?></select></td>
  		</tr>
  		  		  <tr>
  			<td align="left"><label class="etiquetaSimple">No. Documento:</label></td>
  			<td align="left"><input type="text" name="" class="form-control" id="textNoDocto"></td>
  		</tr>
  		<tr>
  			<td align="left"><label class="etiquetaSimple">Fecha Documento:</label></td>
  			<td align="left"><input type="text" name="" class="form-control fecha" id="textFecDocumento"></td>
  		</tr>
  		<tr>
  			<td align="left"><label class="etiquetaSimple">Tipo de Pago:</label></td>
  			<td align="left"><select id="selectTipoPago" class="form-control"><option value="0">Directo</option><option value="1">Tarjeta</option></select></td>
  		</tr>
  	</table>
  	</div>
  	<div style="width: 50%;background-color: white" class="row col-sm-4 col-md-4">  		  	
  		<table class="table" style="background: #acecc0">
  		<tr>
  			<td align="left"><label class="etiquetaSimple">Importe de Pago:</label></td>
  			<td align="left"><input type="text" id="inputImportePago" class="form-control inputSimpleNumero"></td>
  		</tr>

  		  <tr>
  			<td align="left"><label class="etiquetaSimple">Moneda Pago:</label></td>
  			<td align="left"><select id="selectMonedaPago" class="form-control" enabled="true"></select></td>
  		</tr>


  		<tr>
  		 <tr>
  			<td align="left"><label class="etiquetaSimple">Tipo de Cambio:</label></td>
  			<td align="left"><input type="text" id="inputTipoCambio" class="form-control  inputSimpleNumero"></td>

  	</table></div>
  	  	<div style="width: 50%;background-color: white" class="row col-sm-4 col-md-4">  		  	
  		<table class="table">

  		  <tr style="background: #acecc0">
  			<td align="left"><label class="etiquetaSimple">Importe Real:</label></td>
  			<td align="left"><input type="text" id="inputImporteReal" class="form-control inputSimpleNumero"></td>
  		</tr>

  		<tr style="background: #acecc0">
  			<td align="left"><label class="etiquetaSimple">Moneda del Docto:</label></td>
  			<td align="left"><select type="text" id="selectMonedaDocto" class="form-control" enabled="false"></select></td>
  		</tr>



  		<tr style="background: #acecc0">
  			<td align="left"><label class="etiquetaSimple">Tipo de Cambio:</label></td>
  			<td align="left"><input type="text" id="inputTipoCambioDocto" class="form-control inputSimpleNumero"></td>
  		</tr>
  		<tr style="background: #b3e6f9">
  			<td align="left"><label class="etiquetaSimple">Prima Pendiente:</label></td>
  			<td align="left"><input type="text" id="inputPrimaPendiente" class="form-control inputSimpleNumero"></td>
  		</tr>
  		  <tr style="background: #b3e6f9">
  			<td align="left"></td>
  			<td align="left"><button type="text" id="buttonAplicaPago" class="btn btn-success" onclick="aplicarPago('')"><label class="etiquetaSimple">Aplicar pago</label></button><div id="divNoAplicaPago" class="ocultarObjeto"><label class="etiquetaSimple">No se puede aplicar pago no cuenta con recibo</label></div></td>
  		</tr>
  	</table></div>
  </div>
</div>
 <div class="panelMenuFlotante"  id="divSolicitudDeCobro" name="panelMenuFlotante">

  	       		<div class="row">
       		 <div class="col-md-3 col-sm-3"><label>Aplicacion de Pago</label></div>
       		 <div class="col-md-1 col-sm-1"><input type="checkBox" name="checkSolicitudDeCobro" class="form-control" value="0"></div>
       		 <div class="col-md-6 col-sm-6"><input type="text" id="comentarioSolicitudDeCobro0" class="form-control" style="text-align: left" placeholder="agregar comentario"></div>
       		</div>
       		<div class="row">
       		<div class="col-md-3 col-sm-3"><label>Rehabilitacion de poliza</label></div>
       		<div class="col-md-1 col-sm-1">	<input type="checkBox" name="checkSolicitudDeCobro" value="1" class="form-control"></div>
          	<div class="col-md-6 col-sm-6">		<input type="text" id="comentarioSolicitudDeCobro1" style="text-align: left" placeholder="agregar comentario" class="form-control"></div>
            </div>
            <div class="row">
       		<div class="col-md-3 col-sm-3"><label>Cobro de recibo</label></div>
       		<div class="col-md-1 col-sm-1">	<input type="checkBox" name="checkSolicitudDeCobro" value="2" class="form-control"></div>
       		<div class="col-md-6 col-sm-6">	<input type="text" id="comentarioSolicitudDeCobro2" style="text-align: left" placeholder="agregar comentario" class="form-control"></div>
       	   </div>
       	   <div class="row">
             
       		<div class="col-md-3 col-sm-3"><label>Solicitud de referencia</label></div>
       		<div class="col-md-1 col-sm-1"><input type="checkBox" name="checkSolicitudDeCobro" value="3" class="form-control"></div>
       		<div class="col-md-6 col-sm-6"><input type="text" id="comentarioSolicitudDeCobro3" style="text-align: left" placeholder="agregar comentario" class="form-control"></div>       		
       	</div>

       		
       		<div class="row">
             <div class="col-md-3 col-sm-3">
             	<button onclick="GuardarSolicitudDeCobro('')" class="btn btn-primary btn-xs">Guardar Solicitud</button>
             	
             	
             </div>
             <div class="col-md-3 col-sm-3"><button  class="btn btn-danger btn-xs" onclick="cambiarStatus('',1)">Pasar Agente</button></div>
             	<div class="col-md-3 col-sm-3"><button  class="btn btn-success btn-xs" onclick="cambiarStatus('',5)">Pasar Ejecutivo</button></div>
         <input type="hidden" id="iddoctoSolicitudComentario">
         <input type="hidden" id="idreciboSolicitudComentario">
         <input type="hidden" id="documentoSolicitudComentario">
         <input type="hidden" id="documentoSolicitudIDCli">
         <input type="hidden" id="documentoSolicitudidSerie">
         <input type="hidden" id="documentoSolicitudEndoso">
         
         </div>
         

         <hr>
         <div class="row">
         	<div class="col-sm-2 col-md-2" ><label class="labelResponsivo"> Agregar Comentario:</label></div>
         	<div class="col-sm-6 col-md-6" ><input type="" name="" id="comentarioAdicionalCobranza" class="form-control" style="text-align: left"></div>
         <div class="col-sm-1 col-md-1" ><button class="btn btn-primary" onclick="agregarComentario('')">&#128172</button></div>

     </div>
     <hr>
    <div class="row">
     	<div class="col-sm-12 col-md-12md"><h2>AREA PARA AGREGAR DOCUMENTOS</h2></div>
     </div>
    <div class="row">
    	        <div class="col-sm-2 col-md-2" align="right"><label class="labelResponsivo"> Agregar Documento:</label></div>
        <div class="col-sm-6 col-md-6"><?= imprimirTipoDocumentos($tipoDocumentos);?></div>
         <div class="col-sm-1 col-md-1"><button name="" onclick ="crearArchivoEnvio(this)" class="btn btn-primary">&#128195</button></div>

    </div>
      <div class="row">
        <div class="col-sm-2 col-md-2" align="right"><label class="labelResponsivo"> Contenedor de Archivos:</label></div>
        <form id="formDocumentosParaCobranza" action="javascript: enviarArchivoAJAXCobranza('formDocumentosParaCobranza','subirDocumentosDeCobranza')">
        <input  type="hidden" name="inputIdDocto" id="inputIdDocto">
         <input  type="hidden" name="inputSerie" id="inputSerie">
         <input  type="hidden" name="inputIdCliente" id="inputIdCliente">
         <input  type="hidden" name="inputRecibo" id="inputRecibo">
          <input   type="hidden" name="inputDocumento" id="inputDocumento">
           <input  type="hidden" name="inputPeriodo" id="inputPeriodo">
           <input  type="hidden" name="inputBody" id="inputBody">
           <input  type="hidden" name="inputEndoso" id="inputEndoso">
           <input  type="hidden" name="inputIdEndoso" id="inputIdEndoso">           
           <input  type="hidden" name="inputIdEnviarCorreo" id="inputIdEnviarCorreo">
           <input  type="hidden" name="inputIdDocto" id="inputIdDoctoComp">
         <input  type="hidden" name="inputSerie" id="inputSerieComp">
          <input  type="hidden" name="inputRecibo" id="inputReciboComp">
           <input type="hidden" name="inputDocumento" id="inputDocumentoComp">
           <input  type="hidden" name="inputPeriodo" id="inputPeriodoComp">
           <input  type="hidden" name="inputBody" id="inputBodyComp">
           <input  type="hidden" name="inputEndoso" id="inputEndosoComp">
           <input  type="hidden" name="inputIdEndoso" id="inputIdEndosoComp">
           <input  type="hidden" name="inputIdEnviarCorreo" id="inputIdEnviarCorreoComp">
           <input  type="hidden" name="inputIndexCobranza" id="inputIndexCobranza">
        <div class="col-sm-10 col-md-10"><div id="divContenedorArchivos"  style=" background-color: #9f93b3;border: solid;color:white;min-height: 100px"></div>
        </div>
   
      </div>
      <div class="row">
        <div class="col-sm-12 col-md-12" align="right"><button class="btn btn-success"  style="font-size:20px">&#128190</button></div>
      </div>
 </form>
  </div><!-- FIN divSolicitudDeCobro -->
  <div class="panelMenuFlotante ocultarObjeto" id="divDocClientes" name="panelMenuFlotante">
  	<div class="row"><div class="class="col-md-4 col-sm-4"><h3>Contacto</h3></div></div>
  	<div class="row">
    <div class="class="col-md-4 col-sm-4">Telefono<select class="form-control" id="telefonosClienteSelect"></select></div>
    <div class="class="col-md-2 col-sm-2"><button class="btn-chico" onclick="cambiarTelefono()">+</button></div>
    <div class="class="col-md-4 col-sm-4">Email<select class="form-control" id="correosClientesSelect"></select></div><div class="class="col-md-2 col-sm-2"><button class="btn-chico" onclick="cambiarCorreo()">+</button></div>
  	</div>
  	<hr>
  	<div><h3>Documentos</h3><div id="contenedorDocumentosPersonalesDiv"></div></div>
  </div><!--Fin divDocClientes-->
</div>
</div>
<div class="gifEspera ocultarObjeto" id="gifDeEspera1"><img src="<?php echo(base_url().'assets\img\loading.gif')?>"></div>
<table id="tablaExportar" border="2" class="ocultarObjeto"></table>
<div class="ocultarObjeto" id="divBuscarPoliza" style="overflow: scroll;"></div>






</div>
<div id="divModalGenerico" class="modalCierra">

    <div id="divModalContenidoGenerico" class="modal-contenido"  >
      <div class="row">
      <div class="col-md-12 col-sm-12">
      <button onclick="cerrarModal('divModalGenerico')" style="color: white;background-color:red; border:double;position: relative;left: 95%">X</button>
      </div>
    </div>  
<hr>
  
</div>
<div class="row"></div>
</div>
<div id="divModalParaFacturar" class="modalCierraCont">

    <div id="divModalContenidoParaFacturar" class="modal-cont"  >
    	  <div class="row">
  	<button onclick="cerrarModal('divModalParaFacturar')"  style="color: white;background-color:red; border:double;position: relative;left: 90%; height: 20px">X</button>
  </div>
      <div class="row">
      <div class="col-md-3 col-sm-3"><label>Poliza para buscar: </label><input type="text" name="textReciboParaCancelacion" id="textReciboParaCancelacion" class="form-control" ></div>
      <div class="col-md-3 col-sm-3"><button class="btn btn-success" onclick="traerRecibosPagados('')">Buscar</button></div>            
    </div>
    <hr>
    <div class="row">
    	<div class="col-md-12 col-sm-12" id="divRecibosPagados" style="width:90%;height: 200px;overflow:scroll;position:relative;left:20px">
 
        </div>
    </div>
    <div class="row">
    	<div class="col-md-10 col-sm-10"><label>Comentario</label><input type="text" id="textComentarioDeCancelacion" class="form-control"></div>
    	<div class="col-md-2 col-sm-2"><button class="btn btn-danger" onclick="cancelarReciboPagado('')">Cancelar</button></div>
    </div>
 </div>
 </div>
 <div id="divModalComentariosRenovacion" class="modalCierraCont">
 	<div style="display: flex;flex-direction: column; position: relative;">
 		<div style="background-color: white">
    	<button onclick="cerrarModal('divModalComentariosRenovacion')"  style="color: white;background-color:red; border:double;position: relative;left: 90%; height: 20px">X</button></div>
       	<div  id="divComentariosRenovacion" style="width:auto;height: 200px;overflow:scroll;position:relative;left:2;top:30%;background-color: white">
 
        </div>
     </div>
 </div>
 <div id="divModalRenovacion" class="modalCierraCont">
 	<div style="display: flex;flex-direction: column; position: relative;top:20%;left: 25%;width: 50%">
 		<div style="background-color: #d4e2f4;  display: flex; flex-wrap: wrap;flex-grow: 1;justify-content: center;">
        <div style="flex:3; text-align: center;">Renovacion de Documento</div>
    	<div><button onclick="cerrarModal('divModalRenovacion')"  style="color: white;background-color:red; border:double;position: relative;width: 30px; height: 5px">X</button></div>
    </div>
       	<div  id="divRenovacionPoliza" class="cssRenovacionPoliza">
       		<div style="display: none"><label>Agente</label><span id="spanNombreAgente"></span></div>
             <div style="display: none"><label>Agente a Renovar</label><select id="selectAgenteRenovar"></select></div>
             <div><label>Vendedor:</label><span id="spanNombreVendedor">Nombre del vendedor</span></div>
             <div><label>Vendedor a Renovar:</label><select id="selectVendedorRenovar"><?= imprimirVendedores($vendedores);?></select></div>
             <div><label>Prima actual:</label><input step="any" type="number" name="" id="inputMontoActual"></div>
             <div><label>Prima Nueva:</label><input step="any" type="number" name="" id="inputMontoNuevo"></div>
             <input type="hidden" id="inputIDDocumento">
             <div><button onclick="aplicarRenovacion('')">Aceptar</button></div>
        </div>
     </div>
 </div>


 <div id="divModalCancelarRenovacion" class="modalCierraCont">
 	<div style="display: flex;flex-direction: column; position: relative;top:20%;left: 25%;width: 50%">
 		<div style="background-color: #d4e2f4;  display: flex; flex-wrap: wrap;flex-grow: 1;justify-content: center;">
        <div style="flex:3; text-align: center;">Cancelar</div>
    	<div><button onclick="cerrarModal('divModalCancelarRenovacion')"  style="color: white;background-color:red; border:double;position: relative;width: 30px; height: 5px">X</button></div>
    </div>
       	<div  id="divRenovacionPoliza" class="cssRenovacionPoliza">
             <div><label>Fecha:</label><input  type="text"  id="inputFechaMotStatusCancel" class="fechaBusqueda"></div>
             <div><label>Motivo de Estatus:</label><input  type="text" name="" id="inputMotStatusCancel"></div>
             <div><label>Sub Motivo:</label><input  type="text" name="" id="inputSubMotStatusCancel"></div>
             <input type="hidden" id="inputIDDocumentoCancelacion">
             <div><button onclick="cancelarRenovacion('')" class="btn btn-danger btn-xs">Aceptar</button></div>
        </div>
     </div>
 </div>


 <div id="divModalSolicitudDeCobro" class="modalCierraCont">
 	<div style="display: flex;flex-direction: column; position: relative;top:20%;left: 25%;width: 50%">
 		<div style="background-color: #d4e2f4;  display: flex; flex-wrap: wrap;flex-grow: 1;justify-content: center;">
        <div style="flex:3; text-align: center;">Cancelar</div>
    	<div><button onclick="cerrarModal('divModalSolicitudDeCobro')"  style="color: white;background-color:red; border:double;position: relative;width: 30px; height: 5px">X</button></div>
    </div>
       	<div  id="divSolicitudDeCobro1" class="cssRenovacionPoliza">
           </div>
        </div>
     </div>
 




 <div id="divDigitalVigente" class="modalCierraCont">
 	<div style="display: flex;flex-direction: column; position: relative;top:20%;left: 25%;width: 50%">
 		<div style="background-color: #d4e2f4;  display: flex; flex-wrap: wrap;flex-grow: 1;justify-content: center;">
        <div style="flex:3; text-align: center;">Digital</div>
    	<div><button onclick="cerrarModal('divDigitalVigente')"  style="color: white;background-color:red; border:double;position: relative;width: 30px; height: 5px">X</button></div>
    </div>
       	<div  id="divDigital" class="cssRenovacionPoliza">

        </div>
     </div>
 </div>

 <div id="divComentariosSC" class="modalCierraCont">
 	<div style="display: flex;flex-direction: column; position: relative;top:20%;left: 25%;width: 50%">
 		<div style="background-color: #d4e2f4;  display: flex; flex-wrap: wrap;flex-grow: 1;justify-content: center;">
        <div style="flex:3; text-align: center;">Digital</div>
    	<div><button onclick="cerrarModal('divComentariosSC')"  style="color: white;background-color:red; border:double;position: relative;width: 30px; height: 5px">X</button></div>
    </div>
       	<div  id="divComentariosSCContenido" class="cssRenovacionPoliza">

        </div>
     </div>
 </div>
<div>
	
</div>
<div style="position: fixed;z-index: 2;top: 94%;left: 2%">
<div class="row">
	    <div class="col-md-9 col-sm-9 col-xs-9"><button class="btn btn-warning" style="width: 100%" id="btnHistorialDeCorreos" data-char="128071">&#128071</button></div>
    <div class="row" >
    <div class="col-md-11 col-sm-11 col-xs-11 ocultarObjeto" style="overflow: scroll;height: auto;width: 800px;height: 400px;background-color: white" id="divHistorialDeCorreos"><!--table class="table" style="background-color: white"><thead><tr><th><input type="text" placeholder="Escribir el año"></th><th><select></select></th></tr></thead><tbody> </tbody></table-->
    	<div style="display: flex; width: 100%;flex-direction: column;">
    		<div style="display: flex; flex-direction: row;width: 100%">
    			<div style="flex:2"><input type="number" id="anioEnvioSelect" min="2020" value="<?=$anioActual?>" placeholder="Escribir el año" class="controlHistorial" style="height: 5px;width: 100%" ></div>
    			<div style="flex:1"><select id="meseEnvioSelect" class="controlHistorial" ><?=imprimirMeses($meses);?></select></div>
    			<div style="flex:1"><button class="controlHistorial" onclick="historialEnviosPorUsuario('')">Buscar</button></div>
    </div>
    		<div id="contenidoEnvioHistorialDiv" style="width: 100%;height: 300px;overflow: scroll;"></div>
    </div>
    </div>

</div>

</div>
 
</div>
<?php $this->load->view('footers/footerSinSegurin'); ?>

<!--Dennis [2021-03-17]-->
<script type="text/javascript">
  $(function(){

    var flotante=document.getElementById("flotante_contenedor");

    if(document.body.contains(flotante)){
      
      var padre=flotante.parentNode;
      padre.removeChild(flotante);
    }

  });
</script>
<!--------------------->

<script type="text/javascript">
var fechaActual="<?=$fechaActual;?>";

function borrarArchivo(objeto)
{
	let padre=objeto.parentNode.parentNode.parentNode;
	padre.removeChild(objeto.parentNode.parentNode);
}
function crearArchivoEnvio()
{
	if(tipoImg_0.value==''){alert('Necesita escoger un tipo de archivo')}
	else
	{
	 var combo = document.getElementById("tipoImg_0");
     var selected = combo.options[combo.selectedIndex].text;
     var valueSelect=combo.options[combo.selectedIndex].value;
     let objeto='file'+selected;
     let nombreObjeto=valueSelect;
      if(!document.getElementById(objeto))
      {
      	let divPadre=document.createElement('div');
      	let divFile=document.createElement('div');
      	let divLabel=document.createElement('div');      	
      	let divBoton=document.createElement('div')
      	divPadre.classList.add('row');
      	divLabel.classList.add('col-md-2');
      	divLabel.classList.add('col-sm-2');
      	divFile.classList.add('col-md-8')
      	divFile.classList.add('col-sm-8')
	   	divBoton.classList.add('col-md-2');
      	divBoton.classList.add('col-sm-2');

      	let boton=document.createElement('button');
      	boton.innerHTML='&#10060;';
        boton.setAttribute('style','background-color:white')
        boton.setAttribute('onclick','borrarArchivo(this)');
	    let input=document.createElement('input');
	    input.type='file';
	    input.name=nombreObjeto;
	    input.id=objeto;
	    input.classList.add('form-control');
	    let label=document.createElement('label');
	    label.innerHTML=selected+':';
	    label.classList.add('form-label');
	    label.setAttribute('for',objeto)
	    divFile.append(input);
	    divLabel.append(label);	    
	    divBoton.append(boton);	   
	    divPadre.append(divLabel);
	    divPadre.append(divFile);
        divPadre.append(divBoton);
	    divContenedorArchivos.append(divPadre);
	  }
	  else{alert('Ya existe un componente para cargar este archivo')}
     }

}


function ocultarHijosCP(objeto)
{

	let index=objeto.parentNode.parentNode.rowIndex;
	let tabla=objeto.parentNode.parentNode.parentNode;
	let cant=tabla.rows.length;
	if(objeto.innerHTML=='-'){objeto.innerHTML='+';}
	else{objeto.innerHTML='-';}
	for(let i=index+1;i<cant;i++)
	{
		if(tabla.rows[i].dataset.value==1){i=cant;}
		else{tabla.rows[i].classList.toggle('ocultarObjeto');}
	}

}
function polizaNoRenovada(datos='')
{
  if(datos=='')
	{
		
	   let clase=document.getElementsByClassName('seleccionRenovacion');	  
    if(clase.length>0)
     {	let confirmacion = confirm("La poliza pasara en estado No Renovada");   
     	if(confirmacion){
    	   let params = 'IDDocto='+clase[0].getAttribute('data-iddocto');    	       	   
          controlador="cobranza/polizaNoRenovada/?";          
           peticionAJAX(controlador,params,'polizaNoRenovada'); 
       }
  }
  else{alert("Selecciona una ot");}
  }
  else
  {
  	    alert(datos.mensaje);     
     if(datos.success)
     {
     	let tabla=document.getElementById('bodyTablaRenovaciones')
     	let cantidad=tabla.rows.length;
     	for(let i=0;i<cantidad;i++)
     	{
     	  if(datos.IDDocto==tabla.rows[i].getAttribute('data-iddocto'))
     	  {
     	  	document.getElementById('bodyTablaRenovaciones').deleteRow(i);
     	  	i=cantidad;
     	  }	
     	}
       let tr='<tr onclick="seleccionOtVigente(this)" data-iddocto="'+datos.renovacion.IDDocto+'"><td>'+datos.renovacion.Documento+'</td><td>'+datos.renovacion.DAnterior+'</td></tr>';
         let tableVigente=document.getElementById('bodyTablaVigentes').innerHTML;
         document.getElementById('bodyTablaVigentes').innerHTML=tr+tableVigente;
         
         seleccionOtVigente(document.getElementById('bodyTablaVigentes').rows[0]);
     }   
   }
  }

function crearActividades(tipoActividad,tipo)
{
  let url='<?=base_url();?>'+'actividades/agregar/'+tipoActividad;
  let ramo='';
  let subramo='';
  let idcliente='';
  let iddocto='';
  let documento='';
  let idvend='';
  let fpago='';
  switch(bodyTableComentario)
  {
  	case 'bodyTablaRenovaciones': 
    if(document.getElementsByClassName('seleccionRenovacion').length>0)
  	{
      ramo=document.getElementsByClassName('seleccionRenovacion')[0].getAttribute('data-ramonombre').toUpperCase();
      ramo=ramo.replace(/ /gi ,'_');
      ramo=ramo.replace(/Ñ/gi ,'N');
      subramo=document.getElementsByClassName('seleccionRenovacion')[0].getAttribute('data-idsramo');
      idcliente=document.getElementsByClassName('seleccionRenovacion')[0].getAttribute('data-idcli');
      iddocto=document.getElementsByClassName('seleccionRenovacion')[0].getAttribute('data-iddocto');
      documento=document.getElementsByClassName('seleccionRenovacion')[0].getAttribute('data-documento');
      idvend=document.getElementsByClassName('seleccionRenovacion')[0].getAttribute('data-idvend');
      fpago=document.getElementsByClassName('seleccionRenovacion')[0].getAttribute('data-fpago');
      url=url+'/'+ramo+'/'+subramo+'/Existente?idCliente='+idcliente+'-'+documento+'&documento='+documento+'&tipoEndoso='+tipo+'&idvend='+idvend+'&iddocto='+iddocto+'&fpago='+fpago;

  	}
  	else{alert('seleccione una renovacion');return 0;} 
  	break;
  	case 'tableCobranzaPendiente': 
  	if(document.getElementsByClassName('rowSeleccionado').length>0)
  	{
      ramo=document.getElementsByClassName('rowSeleccionado')[0].getAttribute('data-ramo').toUpperCase();
      ramo=ramo.replace(/ /gi ,'_');
      ramo=ramo.replace(/Ñ/gi ,'N');
      subramo=document.getElementsByClassName('rowSeleccionado')[0].getAttribute('data-idsramo');
      idcliente=document.getElementsByClassName('rowSeleccionado')[0].getAttribute('data-idcli');
      iddocto=document.getElementsByClassName('rowSeleccionado')[0].getAttribute('data-iddocto');
      documento=document.getElementsByClassName('rowSeleccionado')[0].getAttribute('data-documento');
      idvend=document.getElementsByClassName('rowSeleccionado')[0].getAttribute('data-idvend');
      fpago=document.getElementsByClassName('rowSeleccionado')[0].getAttribute('data-fpago');
      url=url+'/'+ramo+'/'+subramo+'/Existente?idCliente='+idcliente+'-'+documento+'&documento='+documento+'&tipoEndoso='+tipo+'&idvend='+idvend+'&iddocto='+iddocto+'&fpago='+fpago;;


  	}
  	else{alert('Seleccione una cobranza');return 0;  }
  	
  	break;
  	default: return 0;break;

  }

	   var a = document.createElement("a");
		a.target = "_blank";
		a.href = url;
		a.click();

}
function ponerlaComoLista(datos='')
{
	if(datos=='')
	{
	   let clase=document.getElementsByClassName('seleccionOtVigente');
	   
  if(clase.length>0)
  {	   
    	   var params = 'IDDocto='+clase[0].getAttribute('data-iddocto');    	       	   
          controlador="cobranza/ponerlaComoLista/?";          
           peticionAJAX(controlador,params,'ponerlaComoLista'); 
  }
  else{alert("Selecciona una ot");}
  }
  else
  {
    alert(datos.mensaje);
    let tabla=document.getElementById('bodyTablaVigentes')
    let cantidad=tabla.rows.length;
    for(let i=0;i<cantidad;i++)
    {
      if(datos.IDDocto==tabla.rows[i].getAttribute('data-iddocto'))
      {
      	document.getElementById('bodyTablaVigentes').deleteRow(i);
      	i=cantidad;
      }	
    }
  }
}
function ventanaCancelarRenovacion()
{
	   let clase=document.getElementsByClassName('seleccionOtVigente');
  if(clase.length>0)
  {	

   document.getElementById('inputIDDocumentoCancelacion').value=clase[0].getAttribute('data-iddocto');
   cerrarModal('divModalCancelarRenovacion')
  }
  else{alert("Selecciona una ot");}

}
function cancelarRenovacion(datos='')
{
	if(datos=='')
	{  

         var confirmacion = confirm("Deseas cancelar la poliza:"+document.getElementsByClassName('seleccionOtVigente')[0].cells[0].innerHTML);

        if(confirmacion)
        {
    	   var params = 'IDDocto='+document.getElementById('inputIDDocumentoCancelacion').value;
    	   params=params+'&fecha='+document.getElementById('inputFechaMotStatusCancel').value;
    	   params=params+'&motivo='+document.getElementById('inputMotStatusCancel').value;
    	   params=params+'&submotivo='+document.getElementById('inputSubMotStatusCancel').value;
          controlador="cobranza/cancelarRenovacion/?";
           peticionAJAX(controlador,params,'cancelarRenovacion'); 
            
        } 
	}
	else
	{
      	let tabla=document.getElementById('bodyTablaVigentes')
     	let cantidad=tabla.rows.length;
     	for(let i=0;i<cantidad;i++)
     	{
     	  if(datos.IDDocto==tabla.rows[i].getAttribute('data-iddocto'))
     	  {
     	  	document.getElementById('bodyTablaVigentes').deleteRow(i);
     	  	i=cantidad;
     	  }	
     	}

	}
}

function buscarPolizaVigente(datos)
{
    if(datos=='')
  {
  	var textoEscrito = prompt("Poliza a buscar vigente", "");
   if(textoEscrito != null && textoEscrito!=''){
   	  let params='poliza='+textoEscrito;
	      controlador="cobranza/buscarPolizaVigente/?";
    peticionAJAX(controlador,params,'buscarPolizaVigente');
   
     } 
    else {alert("No has escrito nada");}
  }
  else
  {
  	if(datos.mensaje){alert(datos.mensaje);return 0;}
  	
  	let IDDocto=datos.poliza.IDDocto;
  	let cantRows=bodyTablaRenovaciones.rows.length;
  	let bandBusqueda=false;
  	for(let i=0;i<cantRows;i++)
  	{
  		if(bodyTablaRenovaciones.rows[i].getAttribute('data-iddocto')==IDDocto)
  		{
  			seleccionRowRenovacion(bodyTablaRenovaciones.rows[i]);
  			bandBusqueda=true;
  			i=cantRows;

  		}
  	}
  	if(!bandBusqueda)
  	{
      let r=bodyTablaRenovaciones.insertRow(1);
      r.setAttribute('onclick','seleccionRowRenovacion(this)');
      r.setAttribute('class','rowRenovacion');
      r.setAttribute('name','renovacion');
      r.setAttribute('data-documento',datos.poliza.Documento);
      r.setAttribute('data-nombre',datos.poliza.NombreCompleto);
      r.setAttribute('data-vendedor',datos.poliza.VendNombre);
      r.setAttribute('data-ramonombre',datos.poliza.RamosNombre);
      r.setAttribute('data-cagente',datos.poliza.CAgente);
      r.setAttribute('data-cianombre',datos.poliza.CiaNombre);
      r.setAttribute('data-vendnombre',datos.poliza.VendNombre);
      r.setAttribute('data-idvend',datos.poliza.IDVend);
      r.setAttribute('data-primaneta',datos.poliza.PrimaNetaDocto);
      r.setAttribute('data-fhasta',datos.poliza.FHastaDocto);
      r.setAttribute('data-iddocto',datos.poliza.IDDocto);
      r.setAttribute('data-idsramo',datos.poliza.IDSRamo);
      r.setAttribute('data-idcli',datos.poliza.IDCli);
      r.setAttribute('data-fpago',datos.poliza.FPago);
      r.setAttribute('data-esagentecolaborador',datos.poliza.esAgenteColaborador);
      
      let c0=r.insertCell(0);
      let c1=r.insertCell(1);
      let c2=r.insertCell(2);
      let c3=r.insertCell(3);
      let c4=r.insertCell(4);
      let c5=r.insertCell(5);
      let c6=r.insertCell(6);
      let c7=r.insertCell(7);
      let c8=r.insertCell(8);
      let c9=r.insertCell(9);
      let c10=r.insertCell(10);
      let c11=r.insertCell(11);
      c0.setAttribute('class','divTD50');
      c1.setAttribute('class','divTD150');
      c2.setAttribute('class','divTD150');
      c3.setAttribute('class','divTD150');
      c4.setAttribute('class','divTD150');
      c5.setAttribute('class','divTD150');
      c6.setAttribute('class','divTD150');
      c7.setAttribute('class','divTD150');
      c8.setAttribute('class','divTD150');
      c9.setAttribute('class','divTD150');
      c10.setAttribute('class','divTD150');
      c11.setAttribute('class','divTD150');
      c0.innerHTML='<input type="checkbox" name="cbSeleccionRenovaciones" class="cbSeleccionRenovaciones">';
      c1.innerHTML=datos.poliza.Documento;
      c2.innerHTML=datos.poliza.NombreCompleto;
      c3.innerHTML=datos.poliza.VendNombre;
      c4.innerHTML=datos.poliza.RamosNombre;
      c5.innerHTML=datos.poliza.EMail1;
      c6.innerHTML=datos.poliza.Telefono1;
      c7.innerHTML=datos.poliza.CiaNombre;
      c8.innerHTML=datos.poliza.PrimaNetaDocto;
      c9.innerHTML=datos.poliza.FPago;
      c10.innerHTML=datos.poliza.StatusDoc_Txt;
      c11.innerHTML=datos.poliza.FHastaDocto;
      seleccionRowRenovacion(r);
  	}
  }
 
}

function aplicarRenovacion(datos='')
{
   if(datos=='')
   { if(document.getElementById('inputMontoNuevo').value!=''){
   	   var params = 'IDDocto='+document.getElementById('inputIDDocumento').value;
   	   params=params+'&primaNueva='+document.getElementById('inputMontoNuevo').value;
        controlador="cobranza/aplicarRenovacion/?";
          peticionAJAX(controlador,params,'aplicarRenovacion'); 
          }
          else{alert('Es necesario poner el monto nuevo')}  
   }
   else
   {
     alert(datos.mensaje);
     
     if(datos.success)
     {
     	let tabla=document.getElementById('bodyTablaRenovaciones')
     	let cantidad=tabla.rows.length;
     	for(let i=0;i<cantidad;i++)
     	{
     	  if(datos.IDDocto==tabla.rows[i].getAttribute('data-iddocto'))
     	  {
     	  	document.getElementById('bodyTablaRenovaciones').deleteRow(i);
     	  	i=cantidad;
     	  }	
     	}
       let tr='<tr onclick="seleccionOtVigente(this)" data-iddocto="'+datos.renovacion.IDDocto+'"><td>'+datos.renovacion.Documento+'</td><td>'+datos.renovacion.DAnterior+'</td></tr>';
         let tableVigente=document.getElementById('bodyTablaVigentes').innerHTML;
         document.getElementById('bodyTablaVigentes').innerHTML=tr+tableVigente;
         cerrarModal('divModalRenovacion');
         seleccionOtVigente(document.getElementById('bodyTablaVigentes').rows[0]);
     }   
   }
}
function seleccionOtVigente(objeto)
{
	if(document.getElementsByClassName('seleccionOtVigente').length>0)
	{
		document.getElementsByClassName('seleccionOtVigente')[0].classList.remove('seleccionOtVigente');
	}
	objeto.classList.add('seleccionOtVigente')
	document.getElementById('polizaVigente').value=objeto.getAttribute('data-iddocto');
}
function verDigitalVigente(datos='')
{
	if(datos==''){
	let clase=document.getElementsByClassName('seleccionOtVigente');
	let cant=clase.length;
	if(cant>0)
	{
               var params ='IDDocto='+document.getElementsByClassName('seleccionOtVigente')[0].getAttribute('data-iddocto');
             controlador="cobranza/traerDigitalVigente/?";
          peticionAJAX(controlador,params,'verDigitalVigente');   
         
 
    }
    else
    {
    alert("seleccione una ot");
    }
    }
    else
    {
    	
    	let cant=0;
    	if(datos.children){cant=datos.children.length;}
    	let ul='<ul class="ulDocumentos">';
    	for(let i=0;i<cant;i++)
    	{
           let extension=datos.children[i].href.slice((datos.children[i].href.lastIndexOf(".") - 1 >>> 0) + 2);  
           let clase='';
             	extension=extension.toUpperCase();                 	
                 	switch(extension)
                 	{
                 		case 'PDF':clase='iconopdf';break;
                 		case 'MSG':clase='iconomsg';break;
                 		case 'JPG':clase='iconojpg';break;
                 		case 'JPEG':clase='iconojpg';break;
                 		case 'WORD':clase='iconoword';break;
                 		case 'XLS':clase='iconoxls';break;
                 		case 'XLSX':clase='iconoxls';break;
                 		case 'XML':clase='iconoxml';break;
                 		case 'DOCX':clase='iconoword';break;
                 		case 'PNG':clase='iconopdf';break;
                        default: clase='iconoblanco';break;
                 	}
           ul=ul+'<li class="liArchivos"><div class="'+clase+' iconogenerico"><a href="'+datos.children[i].href+'" target="_blank">'+datos.children[i].text+'</a></div></li>';
    	}
    	ul=ul+'</ul>';
    	document.getElementById('divDigital').innerHTML=ul;
    	cerrarModal('divDigitalVigente');	
    }
}
function ventanaRenovacion()
{
  let clase=document.getElementsByClassName('seleccionRenovacion');
  if(clase.length>0)
  {	
   document.getElementById('spanNombreAgente').innerHTML=clase[0].getAttribute('data-cianombre');   
   document.getElementById('spanNombreVendedor').innerHTML=clase[0].getAttribute('data-vendedor');
   if(clase[0].getAttribute('data-esagentecolaborador')==1){document.getElementById('selectVendedorRenovar').value=7;}
   else{document.getElementById('selectVendedorRenovar').value=clase[0].getAttribute('data-idvend');}
   document.getElementById('inputMontoActual').value=clase[0].getAttribute('data-primaneta');
   document.getElementById('inputIDDocumento').value=clase[0].getAttribute('data-iddocto');
   inputMontoNuevo.value=0;
   cerrarModal('divModalRenovacion')
  }
  else{alert("Selecciona una renovacion");}
}
let bodyTableComentario='tableCobranzaPendiente';
function cerrarModal(modal)
{
     document.getElementById(modal).classList.toggle('modalCierraCont');
     document.getElementById(modal).classList.toggle('modalAbreCont');   
}
var cabeceraTabla='<tr>	<th></th><th>Documento</th><th></th><th></th><th>Recibo</th><th>Periodo</th><th>Endoso</th><th>Cliente</th><th>Vendedor</th><th>Ramo</th><th>SubRamo</th><th>Email</th><th>Telefono</th><th>Fecha</th><th>Compania</th><th>Conducto</th><th>Prima total</th><th>Pref. Comunic.</th><th>Hr. Comunic.</th><th>Dia Comunic.</th><th></th></tr>';
function verOcultarDivPoliza(){
	document.getElementById('divBuscarPoliza').classList.toggle('ocultarObjeto');
	document.getElementById('divBuscarPoliza').classList.toggle('contMenuFlotanteBuscaPoliza');
	if(document.getElementById('divBuscarPoliza').classList.contains('ocultarObjeto'))
	{
		document.getElementById('divBuscarPoliza').innerHTML=''
	}
}
function borraReciboPagado()
{
 document.getElementById('divLinksDocumentos').innerHTML="";
 document.getElementById('selectMonedaPago').innerHTML='';
 document.getElementById('inputImportePago').value='';
 document.getElementById('inputImporteReal').value='';
 document.getElementById('inputTipoCambio').value='';
 document.getElementById('selectMonedaDocto').innerHTML='';
 document.getElementById('labelNombreClienteMF').innerHTML='';
 document.getElementById('divHistorialClientes').innerHTML='';
 row=document.getElementsByClassName('rowSeleccionado')[0];
 row.parentNode.deleteRow(row.rowIndex);
}


function mostrarComentarios(datos){
	/*if(datos==''){
      if(document.getElementsByClassName('rowSeleccionado').length>0) {
         var params = 'IDRecibo='+document.getElementsByClassName('rowSeleccionado')[0].getAttribute('data-idrecibo');
         params = params+'&buscar=0';
             controlador="cobranza/comentarios/?";
          peticionAJAX(controlador,params,'mostrarComentarios');      
      }
	}
	else{

		let tabla='<table class="table"><thead>';
        let cant=datos.comentarios.length;
        tabla=tabla+'<tr>';
        tabla=tabla+'<th>Comentario</th><th>fecha</th>';
        tabla=tabla+'</tr></thead><tbody>';
        for(let i=0;i<cant;i++)
        {
          tabla=tabla+'<tr>';
           tabla=tabla+'<td>'+datos.comentarios[i].cobranzaComentarios+'</td><td>'+datos.comentarios[i].fechaCreacionCC+'</td>';
          tabla=tabla+'</tr>';
        }
	   tabla=tabla+'</tbody></table>';
	   document.getElementById('divComentariosContenedor').innerHTML=tabla;
	}	*/
	if(document.getElementsByClassName('rowSeleccionado').length>0) 
	{
	 let rowSeleccionado=document.getElementsByClassName('rowSeleccionado')[0];
     traerComentarioSolicitudCobro('',rowSeleccionado.dataset.iddocto,rowSeleccionado.dataset.documento,rowSeleccionado.dataset.idrecibo,'divComentariosContenedor');
	}
	
}


function enviarSMS(datos,nameCB,bodyTabla){
if(datos=='')
 {

   let datos="";	
   var arrayProperties = new Array();
   let cb=document.getElementsByName(nameCB);
   let cantCB=cb.length;
   for(let i=0;i<cantCB;i++){
   let bandEntrada=0;
   let cant=cb[i].parentElement.parentElement.classList.length;
        if(cant==1){bandEntrada=1;}
        else{if(cant==2){if(cb[i].parentElement.parentElement.classList.contains('rowSeleccionado')){bandEntrada=1}}}
        //if(bandEntrada){
          if(cb[i].checked)
          { 
        	   let dataEmail=cb[i].parentElement.parentElement.getAttribute('data-email');
        	   let dataHref=cb[i].parentElement.parentElement.getAttribute('data-href');
        	   let dataHrefComprobante=cb[i].parentElement.parentElement.getAttribute('data-hrefcomprobante');
        	   let dataIdRecibo=cb[i].parentElement.parentElement.getAttribute('data-idrecibo');
        	   let dataIdSerie=cb[i].parentElement.parentElement.getAttribute('data-serie');
        	   let dataIdDocto=cb[i].parentElement.parentElement.getAttribute('data-iddocto');
        	   let dataIdCli=cb[i].parentElement.parentElement.getAttribute('data-idcli');        	   
            	let celular=cb[i].parentElement.parentElement.getAttribute('data-telefono').replace(' ','');
    	        let nombre =cb[i].parentElement.parentElement.getAttribute('data-nombre');  
    	       let documento =cb[i].parentElement.parentElement.getAttribute('data-documento');
    	       let endoso =cb[i].parentElement.parentElement.getAttribute('data-endoso');
    	       let flimpago =cb[i].parentElement.parentElement.getAttribute('data-flimpago');
    	            let properties = new Object();
        	  		properties.email=dataEmail;
        	  		properties.href=dataHref;
        	  		properties.idRecibo=dataIdRecibo; 
        	  		properties.idSerie=dataIdSerie; 
        	  		properties.idDocto=dataIdDocto;         	  		
        	  		properties.IDCli=dataIdCli;
        	  		properties.hrefComprobante =dataHrefComprobante;
        	  		properties.celular=celular;
        	  		properties.nombre=nombre;
        	  		properties.documento=documento;
        	  		properties.endoso=endoso;
        	  		properties.flimpago=flimpago;
        	  		arrayProperties.push(properties);   


        }
  }
 var params = 'valores='+JSON.stringify(arrayProperties)+'&bodyTabla='+bodyTabla;
    controlador="cobranza/enviarSMS/?";
    peticionAJAX(controlador,params,'enviarSMS');
 }else
 {

   let cantidad=datos.idRecibo.length;
   let tablaBody=document.getElementById(datos.bodyTabla);
   let cantidadRows=tablaBody.rows.length;
   for(let i=0;i<cantidad;i++)   	
   {
    for(let j=0;j<cantidadRows;j++)
    {
      if(datos.idRecibo[i].idRecibo==tablaBody.rows[j].getAttribute('data-idrecibo'))
      {
      	if(datos.idRecibo[i].status==1)
      	{
          tablaBody.rows[j].cells[3].classList.add('iconoemail');
          tablaBody.rows[j].cells[0].classList.remove('noEnviadoClass');
          j=cantidadRows; 
        }
        else
        {
         tablaBody.rows[j].cells[0].classList.add('noEnviadoClass');
          j=cantidadRows; 
        }
      }
    } 
   }
   historialEnviosPorUsuario('');
 }
}





function enviarWhats(datos,nameCB,bodyTabla)
{
if(datos=='')
 {

   let datos="";	
   var arrayProperties = new Array();
   let cb=document.getElementsByName(nameCB);
   let cantCB=cb.length;
   for(let i=0;i<cantCB;i++){
   let bandEntrada=0;
   let cant=cb[i].parentElement.parentElement.classList.length;
        if(cant==1){bandEntrada=1;}
        else{if(cant==2){if(cb[i].parentElement.parentElement.classList.contains('rowSeleccionado')){bandEntrada=1}}}
        //if(bandEntrada){
          if(cb[i].checked)
          { 
        	   let dataEmail=cb[i].parentElement.parentElement.getAttribute('data-email');
        	   let dataHref=cb[i].parentElement.parentElement.getAttribute('data-href');
        	   let dataHrefComprobante=cb[i].parentElement.parentElement.getAttribute('data-hrefcomprobante');
        	   let dataIdRecibo=cb[i].parentElement.parentElement.getAttribute('data-idrecibo');
        	   let dataIdSerie=cb[i].parentElement.parentElement.getAttribute('data-serie');
        	   let dataIdDocto=cb[i].parentElement.parentElement.getAttribute('data-iddocto');
        	   let dataIdCli=cb[i].parentElement.parentElement.getAttribute('data-idcli');        	   
            	let celular=cb[i].parentElement.parentElement.getAttribute('data-telefono').replace(' ','');
    	        let nombre =cb[i].parentElement.parentElement.getAttribute('data-nombre');  
    	       let documento =cb[i].parentElement.parentElement.getAttribute('data-documento');
    	       let endoso =cb[i].parentElement.parentElement.getAttribute('data-endoso');
    	       let flimpago =cb[i].parentElement.parentElement.getAttribute('data-flimpago');
    	            let properties = new Object();
        	  		properties.email=dataEmail;
        	  		properties.href=dataHref;
        	  		properties.idRecibo=dataIdRecibo; 
        	  		properties.idSerie=dataIdSerie; 
        	  		properties.idDocto=dataIdDocto;         	  		
        	  		properties.IDCli=dataIdCli;
        	  		properties.hrefComprobante =dataHrefComprobante;
        	  		properties.celular=celular;
        	  		properties.nombre=nombre;
        	  		properties.documento=documento;
        	  		properties.endoso=endoso;
        	  		properties.flimpago=flimpago;
        	  		arrayProperties.push(properties);   


        }
  }
  
 var params = 'valores='+JSON.stringify(arrayProperties)+'&bodyTabla='+bodyTabla;
    controlador="cobranza/mandarWhats/?";
    peticionAJAX(controlador,params,'enviarWhats');
 }else
 {

   let cantidad=datos.idRecibo.length;
   let tablaBody=document.getElementById(datos.bodyTabla);
   let cantidadRows=tablaBody.rows.length;
   for(let i=0;i<cantidad;i++)   	
   {
    for(let j=0;j<cantidadRows;j++)
    {
      if(datos.idRecibo[i].idRecibo==tablaBody.rows[j].getAttribute('data-idrecibo'))
      {
      	if(datos.idRecibo[i].status==1)
      	{
          tablaBody.rows[j].cells[3].classList.add('iconoemail');
          tablaBody.rows[j].cells[0].classList.remove('noEnviadoClass');
          j=cantidadRows; 
        }
        else
        {
         tablaBody.rows[j].cells[0].classList.add('noEnviadoClass');
          j=cantidadRows; 
        }
      }
    } 
   }
   historialEnviosPorUsuario('');
 }	
}



function agregarComentariosRenovacion(datos)
{
	
	if(datos=='')
	{
		let rowSeleccionado=document.getElementsByClassName('seleccionRenovacion');
		let fecha=rowSeleccionado[0].getAttribute('data-fhasta').split('T');//'2020-10-15T00:00:00-06:00'.split('T');
         let fecha2=fecha[0];
        var date_1 = new Date(fechaActual);
        var date_2 = new Date(fecha2);
        var day_as_milliseconds = 86400000;
        var diff_in_millisenconds = date_2 - date_1;
        var diff_in_days = diff_in_millisenconds / day_as_milliseconds;
        
        if(diff_in_days<11){alert('No puede agregar comentarios ya entro en renovacion. Contactar al ejecutivo por medio telefonico');return 0;}

	if(rowSeleccionado.length>0)
	{
        var textoEscrito = prompt("Escribe un texto", "");
     if(textoEscrito != null && textoEscrito!='')
     {	 
	     var params = 'Documento='+rowSeleccionado[0].getAttribute('data-documento');
	     var params =params+'&comentario='+textoEscrito;
	     controlador="cobranza/comentariosRenovacion/?";
	     //alert(params);
         peticionAJAX(controlador,params,'agregarComentariosRenovacion');

    } 
    else {alert("Para guardar un comentario necesitas agregar un texto");}
}
else{alert('Escoger poliza');}

	}
}
//function actualizar(){location.reload(true);}

function mostrarComentariosRenovacion(datos,objeto=null)
{
	if(datos=='')
	{
		
		     var params = 'Documento='+objeto.value;	 
	 controlador="cobranza/mostrarComentariosRenovacion/?";
	 peticionAJAX(controlador,params,'mostrarComentariosRenovacion');      
	}
	else
	{
	  	
      cerrarModal('divModalComentariosRenovacion');
      let cantDatos=datos.datos.length;
      let table='<table class="table"><thead><tr><th colspan="3">'+datos.Documento+'</th></tr><tr><th>Usuario</th><th>Comentario</th><th>Fecha</th><tr></thead><tbody>';
      for(let i=0;i<cantDatos;i++)
      {
        table=table+'<tr><td>'+datos.datos[i].nombres+' '+datos.datos[i].apellidoPaterno+' '+datos.datos[i].apellidoMaterno+'( '+datos.datos[i].email+' )</td><td>'+datos.datos[i].comentario+'</td><td>'+datos.datos[i].fecha+'</td></tr>';
      }
      table=table+'</tbody></table>'
      document.getElementById('divComentariosRenovacion').innerHTML=table;
	}
}
function peticionSinPrecargaAJAX(controlador,parametros,funcion){

  var req = new XMLHttpRequest();var direccionAJAX="<?= base_url();?>";
  var url=direccionAJAX+controlador;

 req.open('POST', url, true);
  req.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
   req.onreadystatechange = function (aEvt) 
  {
   
    if (req.readyState == 4) {    	
      if(req.status == 200)
        { var respuesta=JSON.parse(this.responseText); 
          window[funcion](respuesta);                                         
        }     
      if(req.status==500)
      	{
      		//alert('El proceso presento un error favor de notificar a sistemas error 006');
        }      
   }

  };
 req.send(parametros);
}


function buscarComentariosRenovacionBorrar(datos)
{
 if(datos=='')
  {
     let body=document.getElementById('bodyTablaRenovaciones');
     let cantidad=body.rows.length;
     
     let documentos=[];
     for(let i=0;i<cantidad;i++){documentos[i]=body.rows[i].getAttribute('data-documento');}
     var params = 'Documento='+documentos;	 
	 controlador="cobranza/buscarComentariosRenovacion/?";
     peticionSinPrecargaAJAX(controlador,params,'buscarComentariosRenovacion');      
  }
  else
  {
  
         let body=document.getElementById('bodyTablaRenovaciones');
     let cantidad=body.rows.length;
     let documentos=[];
     let cantidadDatos=datos.datos.length;
     
     for(let i=0;i<cantidad;i++)
     {
     	documentos=body.rows[i].getAttribute('data-documento');
        for(let j=0;j<cantidadDatos;j++)
        {
         if(documentos==datos.datos[j].Documento)
         {
         	let comentario='<div class="renovaDoc"><div>'+datos.datos[j].Documento+'</div><div class="renovDocComentario"><button  value="'+datos.datos[j].Documento+'" onclick="mostrarComentariosRenovacion(\'\',this)">C</button>';
         	if(datos.datos[j].comentarioNuevo>0)
         	{
         		comentario=comentario+'<label>New</label></div>';
         	}
         	comentario=comentario+'</div>';
         	j=cantidadDatos;
         	body.rows[i].cells[1].innerHTML=comentario;	
         } 
        }
     }
  }

}
function comprobarCobranzaSeleccionada()
{
	let rowSeleccionado=document.getElementsByClassName('rowSeleccionado');
	if(rowSeleccionado.length>0){return true;}else{alert('Escoger un cobranza');return false;}
}
function cambiarStatus(datos,status)
{	
 if(datos=='')
 {
 	if(comprobarCobranzaSeleccionada()){
   let params='idRecibo='+idreciboSolicitudComentario.value+'&status='+status;
   controlador="cobranza/cambiarStatusSolicitudDeCobro/?";
   peticionAJAX(controlador,params,'cambiarStatus');
  }
 }
 else
 {
   alert(datos.mensaje);
   
   if(datos.success)
   {
   	
   	document.getElementsByClassName('rowSeleccionado')[0].classList.remove(datos.classRemover);
   	document.getElementsByClassName('rowSeleccionado')[0].classList.add(datos.classAgregar);
   }
 }
}
function GuardarSolicitudDeCobro(datos='')
{
  if(datos=='')
  {
  		let rowSeleccionado=document.getElementsByClassName('rowSeleccionado');
	if(rowSeleccionado.length>0)
	{
  let check=document.getElementsByName('checkSolicitudDeCobro')
  let cadena='';
   let cant= check.length;
   for(let i=0;i<cant;i++)
   {
    if(check[i].checked)
    {
      let valor=check[i].value;
      cadena=cadena+valor+'-'+document.getElementById('comentarioSolicitudDeCobro'+valor).value+';';
    }
   }
   if(cadena==''){alert('Escoger un tipo de solicitud de pago')}
   	else
   	{
   		
      
     
   		let params='datos='+cadena+'&idDocto='+iddoctoSolicitudComentario.value+'&idRecibo='+idreciboSolicitudComentario.value+'&documento='+documentoSolicitudComentario.value+'&idSerie='+documentoSolicitudidSerie.value+'&endoso='+documentoSolicitudEndoso.value+'&IDCli='+documentoSolicitudIDCli.value;
   		controlador="cobranza/GuardarSolicitudDeCobro/?";
         peticionAJAX(controlador,params,'GuardarSolicitudDeCobro');
   	}
  }
    else{alert("Escoger una cobranza")}
  }
  else
  {
  	let cadena=datos.documento+'<br>'+'<button class="btn-chico" onclick="traerComentarioSolicitudCobro(\'\','+datos.idDocto+',\''+datos.documento+'\','+datos.idRecibo+')">&#9998</button>';
  //document.getElementsByClassName('rowSeleccionado')[0].cells[1].innerHTML=cadena;	
   let rowSeleccionado=document.getElementsByClassName('rowSeleccionado')[0];   
   let cant=bodyTablaCobPen.rows.length;
   cant=cant-1;      
   rowSeleccionado.cells[1].innerHTML=cadena;
   bodyTablaCobPen.rows[cant].parentNode.insertBefore(rowSeleccionado,bodyTablaCobPen.rows[cant].nextSibling);
   bodyTablaCobPen.rows[cant].cells[1].innerHTML=cadena;
   //seleccionRow();
  }
}
function ventanaSolicitudDeCobro()
{
	   	let rowSeleccionado=document.getElementsByClassName('rowSeleccionado');
  if(rowSeleccionado.length>0)
  {	
    
    iddoctoSolicitudComentario.value='';
   document.getElementById('iddoctoSolicitudComentario').value=rowSeleccionado[0].getAttribute('data-iddocto');
   document.getElementById('idreciboSolicitudComentario').value=rowSeleccionado[0].getAttribute('data-idrecibo');
   documentoSolicitudComentario.value=rowSeleccionado[0].getAttribute('data-documento');
   cerrarModal('divModalSolicitudDeCobro');
  }
  else{alert("Selecciona una cobranza");}

}


function agregarComentario(datos){
 if(bodyTableComentario=='bodyTablaRenovaciones'){agregarComentariosRenovacion('');return 0;}
if(datos=='')
{
	let rowSeleccionado=document.getElementsByClassName('rowSeleccionado');
	if(rowSeleccionado.length>0)
	{
        //var textoEscrito = prompt("Escribe un texto", "");
        let textoEscrito='';
        if(comentarioAdicionalCobranzaUno.value!=''){textoEscrito=comentarioAdicionalCobranzaUno.value;}
        else{if(comentarioAdicionalCobranza.value!=''){textoEscrito=comentarioAdicionalCobranza.value;}}
        
     if(textoEscrito != null && textoEscrito!='')
     {	 comentarioAdicionalCobranzaUno.value='';
         comentarioAdicionalCobranza.value='';
	     var params = 'IDRecibo='+rowSeleccionado[0].getAttribute('data-idrecibo');
	     var params =params+'&comentario='+textoEscrito;
	     var params =params+'&idDocto='+rowSeleccionado[0].getAttribute('data-iddocto');
	     var params =params+'&serie='+rowSeleccionado[0].getAttribute('data-serie');
	     var params =params+'&IDCli='+rowSeleccionado[0].getAttribute('data-idcli');
	     var params =params+'&endoso='+rowSeleccionado[0].getAttribute('data-endoso');
	     controlador="cobranza/comentarios/?";
         peticionAJAX(controlador,params,'agregarComentario');

    } 
    else {alert("Para guardar un comentario necesitas agregar un texto");}
}
else{alert('Escoger poliza');}
 }
 else{alert(datos.mensaje); mostrarComentarios(''); }
}


function aplicarPago(datos)
{
  if(datos=='')
  {
    var params = 'IDRecibo='+document.getElementsByClassName('rowSeleccionado')[0].getAttribute('data-idrecibo');
    params=params+'&Fpago='+document.getElementById('textFecPago').value;  
    params=params+'&FolioCh='+document.getElementById('textFolCheque').value;
    params=params+'&TipoDocto='+document.getElementById('selectTipoDocto').value;
    params=params+'&Banco='+document.getElementById('selectBancos').value;
    params=params+'&FolioDocto='+document.getElementById('textNoDocto').value;
    params=params+'&FDocto='+document.getElementById('textFecDocumento').value;
    params=params+'&TPago='+document.getElementById('selectTipoPago').value;
    params=params+'&ImporteP='+document.getElementById('inputImportePago').value;
    params=params+'&IDMonPago='+document.getElementById('selectMonedaPago').value;
    params=params+'&TCPago='+document.getElementById('inputTipoCambio').value;
    //params=params+'&TCPagoDocto='+document.getElementById('inputTipoCambioDocto').value;
    params=params+'&Importe='+document.getElementById('inputImporteReal').value;
    params=params+'&TCDocto='+document.getElementById('inputTipoCambioDocto').value;
    //params=params+'&enviarCorreo='+document.getElementsByClassName('rowSeleccionado')[0].getAttribute('data-idrecibo');
   // params=params+'&='+document.getElementById('').value;
   // params=params+'&='+document.getElementById('').value;    
    controlador="cobranza/aplicarPago/?";
    peticionAJAX(controlador,params,'aplicarPago');
  }
  else
  {
    alert(datos.mensaje);
    if(datos.bandera==1){
    	borraReciboPagado();
    	maxminContMenuFlotante();
    }
  }
}
function totalCaracteres(objeto,span)
{
  let valor=objeto.value;
  cantidad=valor.length;
   
  /*if(document.getElementById('tipoTarjeta').value=='Visa' || document.getElementById('tipoTarjeta').value=='Master Card')
  {
    if(cantidad>17)
    {
     let cadena=valor.substr(0,15);
      objeto.value=cadena;
    }
  }*/
  document.getElementById(span).innerHTML=cantidad;
}
function filtraSelect(valor,select){
 var filtro=valor.toUpperCase();
 var busqueda=document.getElementById(select);
 var contador=busqueda.length;var text="";
  for(var j=1;j<contador;j++)
    {text=busqueda[j].innerHTML.toUpperCase();

      if(text.indexOf(filtro)>=0){busqueda[j].classList.add('verElemento');busqueda[j].classList.remove('ocultarObjeto');}
      else{ busqueda[j].classList.add('ocultarObjeto'); busqueda[j].classList.remove('verElemento');}}
}

function filtrarBusqueda(valor){
  var busqueda=document.getElementById('idPersonas');
  var filtro=document.getElementById('txtBuscarFiltro').value.toUpperCase();
  var contador=busqueda.length;var text="";
  for(var j=2;j<contador;j++)
    {text=busqueda[j].innerHTML;
      if(text.indexOf(filtro)>=0){busqueda[j].classList.add('verElemento');busqueda[j].classList.remove('ocultarElemento');}
      else{ busqueda[j].classList.add('ocultarElemento'); busqueda[j].classList.remove('verElemento');}}
}


function traeDocumento(parametros,respuesta)
{
	if(respuesta=='')
	{
	   //document.getElementById('inputImporteReal').value='';
       //document.getElementById('selectMonedaDocto').value='';
       document.getElementById('inputTipoCambioDocto').value='';
       var params = 'IDDocto='+parametros[0]+'&serie='+parametros[1]+'&TCPago='+parametros[2];
       controlador="cobranza/buscarDocumento/?";

       peticionAJAX(controlador,params,'traeDocumento');
	}
	else
	{

       //document.getElementById('inputImporteReal').value=respuesta.Pago;
       //document.getElementById('inputMonedaDocto').value=respuesta.monedaDelDocto;
       document.getElementById('inputTipoCambioDocto').value=respuesta.TCPago;
       document.getElementById('inputPrimaPendiente').value=0;

	}
}

function mostrarHistorial(datos){
	if(datos=='')
	{
      if(document.getElementsByClassName('rowSeleccionado').length>0) 
      {
         var params = 'IDRecibo='+document.getElementsByClassName('rowSeleccionado')[0].getAttribute('data-idrecibo');
             controlador="cobranza/mostrarHistorial/?";
          peticionAJAX(controlador,params,'mostrarHistorial');      
      }
	}
	else
	{
       let cantidad=datos.historialCobranza.length
       let tabla='<table class="table"><thead><tr><th>fecha</th><th>Tipo</th><th>destino</th><th>archivo</th><th>Comentario</th></tr></thead><tbody>';
       for(let i=0;i<cantidad;i++)
       {
         tabla=tabla+'<tr>';
         tabla=tabla+'<td>'+datos.historialCobranza[i].tipoEnvioCH+'</td>';
         tabla=tabla+'<td>'+datos.historialCobranza[i].fechaCreacionCH+'</td>';
         tabla=tabla+'<td>'+datos.historialCobranza[i].envioDestinoCH+'</td>';
         tabla=tabla+'<td>'+datos.historialCobranza[i].hRefCH+'</td>';
         tabla=tabla+'<td>'+datos.historialCobranza[i].comentarioDelEnvio+'</td>';
         tabla=tabla+'</tr>';
       }
       tabla=tabla+'</tbody></table>';
       document.getElementById('divHistorialClientes').innerHTML=tabla;
	}
}
function cancelarReciboPagado(datos)
{
 if(datos=='')
 {
  if(document.getElementById('textComentarioDeCancelacion').value!='')
  {
  var confirmacion = confirm("Deseas cancelar el recibo pagado");
  if(confirmacion){
	     let radio=document.getElementsByName('cbSeleccionCancelarRecibo');
         let cant=radio.length;
         let recibo='';
         let iddocto='';
         let serie='';
         let documento='';
         let comentario='';
     for(let i=0;i<cant;i++)
     {
     	if(radio[i].checked)
      {
     	recibo=radio[i].parentNode.parentNode.getAttribute('data-idrecibo');
     	iddocto=radio[i].parentNode.parentNode.getAttribute('data-iddocto');
     	serie=radio[i].parentNode.parentNode.getAttribute('data-serie');
     	documento=radio[i].parentNode.parentNode.getAttribute('data-documento');
     	i=cant;
      }
     }
      var params = 'recibo='+recibo+'&iddocto='+iddocto+'&serie='+serie+'&documento='+documento+'&comentario='+document.getElementById('textComentarioDeCancelacion').value;
     controlador="cobranza/cancelarReciboPagado/?"; 
      peticionAJAX(controlador,params,'cancelarReciboPagado');}
   else {alert("La cancelacion no se realizo");}
    } 
    
     else{alert('Agrega un comentario');}
   }
    else
    { 
    	if(datos.bandera==1)
      {
      	let numeroRow;
        let cantRow=document.getElementById("bodyRecibosPagados").rows.length;
        for(let i=0;i<cantRow;i++)
        {
      	 if(document.getElementById("bodyRecibosPagados").rows[i].getAttribute('data-idrecibo')==datos.IDRecibo){numeroRow=i;i=cantRow;}
        }
      document.getElementById('bodyRecibosPagados').deleteRow(numeroRow);
     }
      alert(datos.mensaje);
    }
 }


function cancelarTarjeta(datos)
{
	if(datos==''){
  let select=document.getElementById('selectEscogerTarjeta');
  let numTarjeta=select.options[select.selectedIndex].getAttribute('data-numerotarjeta');
  let codSeguridad=select.options[select.selectedIndex].getAttribute('data-codigoseguridad');
  let idPersonaTarjeta=select.options[select.selectedIndex].getAttribute('data-idpersonatarjeta');
  let IDCli=select.options[select.selectedIndex].getAttribute('data-idcli');
  var params = 'numeroTarjeta='+numTarjeta+'&codigoSeguridad='+codSeguridad+'&idPersonaTarjeta='+idPersonaTarjeta+'&IDCli='+IDCli;
  controlador="cobranza/cancelarTarjeta/?"; 
  peticionAJAX(controlador,params,'cancelarTarjeta');}
  else{
  	mostrarTarjeta('');
  	alert(datos.mensaje);
  }
}
function mostrarTarjeta(datos){
 if(datos==''){
  let IDCli=document.getElementById('hiddenIDCliMF').value;
   var params = 'IDCli='+IDCli;
    controlador="cobranza/mostrarTarjeta/?";
     document.getElementById('numeroTarjeta2').value='';
     document.getElementById('vencimiento2').value='';
     document.getElementById('anio2').value='';
     document.getElementById('codigoSeguridad2').value='';
     document.getElementById('titularTarjeta2').value='';
     document.getElementById('tipoTarjeta2').value='';
     document.getElementById('banco2').value='';
     document.getElementById('tipoPagoTarjeta2').value='';
    peticionAJAX(controlador,params,'mostrarTarjeta');
 }else{
 
    if(datos.mensaje==''){

      let rows='';
      let cantidad=datos.datos.length;
      let cantRS=cantidad+1;

       let inputs='Numero de tarjeta<input type="text" id="numeroTarjeta2" class="form-control"><br>Vencimiento <input type="text" id="vencimiento2" class="form-control"><br>Año<input type="text" id="anio2" class="form-control"><br>Codigo de seguridad<input type="text" id="codigoSeguridad2" class="form-control"><br>Titular de tarjeta<input type="text" id="titularTarjeta2" class="form-control"><br>Tipo de tarjeta<input type="text" id="tipoTarjeta2" class="form-control"><br>Banco<input type="text" id="banco2" class="form-control"><br>Tipo de Pago<input type="text" id="tipoPagoTarjeta2" class="form-control">';

         let tabla='<table border="1"><tr><td></td><td rowspan="'+cantRS+'">'+inputs+'</td></tr>';
         rows=rows+'<tr><td>';
         let option='<option value="0">Escoger Tarjeta</option>';
      for(let i=0;i<cantidad;i++)
      {
         rows=rows+'<button onclick="verTarjetas(this)" data-numerotarjeta="'+datos.datos[i].numeroTarjeta+'" data-codigoseguridad="'+datos.datos[i].codigoSeguridad+'" data-vencimiento="'+datos.datos[i].vencimiento+'" data-anio="'+datos.datos[i].anio+'" data-titulartarjeta="'+datos.datos[i].titularTarjeta+'" data-tipotarjeta="'+datos.datos[i].tipoTarjeta+'" data-banco="'+datos.datos[i].banco+'" data-tipoPago="'+datos.datos[i].tipoPago+'">tarjeta '+i+'</button><br>';
         option=option+'<option data-numerotarjeta="'+datos.datos[i].numeroTarjeta+'" data-codigoseguridad="'+datos.datos[i].codigoSeguridad+'" data-vencimiento="'+datos.datos[i].vencimiento+'" data-anio="'+datos.datos[i].anio+'" data-titulartarjeta="'+datos.datos[i].titularTarjeta+'" data-tipotarjeta="'+datos.datos[i].tipoTarjeta+'" data-banco="'+datos.datos[i].banco+'" data-tipoPago="'+datos.datos[i].tipoPago+'" data-idpersonatarjeta="'+datos.datos[i].idPersonaTarjeta+'" data-idcli="'+datos.datos[i].IDCli+'">'+datos.datos[i].banco+'->'+datos.datos[i].numeroTarjeta+'</option>';
      }
      rows=rows+'</td><td></td></tr>';
     
      document.getElementById('selectEscogerTarjeta').innerHTML=option;
    //  document.getElementById('divTarjetaClientes').innerHTML=tabla+rows+'</table>';

    }
    else{
    	document.getElementById('selectEscogerTarjeta').innerHTML='<option value="-1">No hay Tarjetas</option>';
        // document.getElementById('divTarjetaClientes').innerHTML='Sin tarjetas';
    }
 }
}
function verTarjetas(objeto){

	numeroTarjeta2.value=objeto.options[objeto.selectedIndex].getAttribute('data-numerotarjeta');
	codigoSeguridad2.value=objeto.options[objeto.selectedIndex].getAttribute('data-codigoseguridad');
	vencimiento2.value=objeto.options[objeto.selectedIndex].getAttribute('data-vencimiento');
	anio2.value=objeto.options[objeto.selectedIndex].getAttribute('data-anio');
	titularTarjeta2.value=objeto.options[objeto.selectedIndex].getAttribute('data-titulartarjeta');
	tipoTarjeta2.value=objeto.options[objeto.selectedIndex].getAttribute('data-tipotarjeta');
	banco2.value=objeto.options[objeto.selectedIndex].getAttribute('data-banco');
	tipoPagoTarjeta2.value=objeto.options[objeto.selectedIndex].getAttribute('data-tipoPago');
}
function guardarTarjeta(datos)
{
 if(datos=='')
  {
   let numeroTarjeta=document.getElementById('numeroTarjeta').value;
   let vencimiento=document.getElementById('mesTarjeta').value;
   let anio=document.getElementById('yearTarjeta').value;
   let codigoSeguridad=document.getElementById('codigoSeguridad').value;
   let titularTarjeta=document.getElementById('titularTarjeta').value;
   let tipoTarjeta=document.getElementById('tipoTarjeta').value;
   let banco=document.getElementById('bancoTarjeta').value;
   let tipoPago=document.getElementById('tipoPagoTarjeta').value;
   let IDCli=document.getElementById('hiddenIDCliMF').value;
   var params = 'numeroTarjeta='+numeroTarjeta+'&vencimiento='+vencimiento+'&anio='+anio+'&codigoSeguridad='+codigoSeguridad+'&titularTarjeta='+titularTarjeta+'&tipoTarjeta='+tipoTarjeta+'&banco='+banco+'&tipoPago='+tipoPago+'&IDCli='+IDCli;
    controlador="cobranza/guardarTarjeta/?";
    peticionAJAX(controlador,params,'guardarTarjeta');
  }else{
    alert(datos.mensaje);
  }
}
function buscarPorCliente(datos)
{
    if(datos=='')
  {
  	var textoEscrito = prompt("Poliza por cliente", "");
   if(textoEscrito != null && textoEscrito!=''){
   	  let params='nombre='+textoEscrito;
	      controlador="cobranza/buscarPolizaPorNombreCliente/?";
    peticionAJAX(controlador,params,'buscarPorCliente');  
     } else {alert("No has escrito nada");}


  }
  else
  {    
  	let cantDatos=datos.TableInfo.length;
   let tabla='<table class="table" border="1"><thead><tr ><td align="left" colspan="20"><button onclick=verOcultarDivPoliza() style="color:white;background-color:red">X</button><h2>Seleccionar Recibo</h2></td></tr><tr><th class="divTD15 ocultarObjeto"></th><th class="divTD150">DOCUMENTO</th><th class="divTD75"></th><th class="divTD25"></th><th class="ocultarObjeto divTD100" >RECIBO</th><th class="divTD75">SERIE</th><th class="divTD150">ENDOSO</th><th class="divTD400">NOMBRE</th><th class="divTD400">VENDEDOR</th><th class="divTD150">RAMO</th><th class="divTD150 ocultarObjeto">RAMO</th><th class="divTD150">EMAIL</th><th class="divTD150">TELEFONO</th><td class="divTD125"><th class="divTD125">COMPANIA</th><th class="divTD125">COBRO</th><th class="divTD125"></th><th class="divTD150"></th><th class="divTD150"></th><th class="divTD150">PRIMA</th><th class="divTD125">STATUS</th></tr></thead><tbody>';

  	for(let i=0;i<cantDatos;i++)
  	{ let envio="";
       if(datos.TableInfo[i].Status==0){
       	if(datos.TableInfo[i].IDDespacho==3){envio='cancun';}
       else
       {
       	if(datos.TableInfo[i].TipoDocto_TXT=='Fianza'){envio='fianzas';}
       	else
       	{
          if(datos.TableInfo[i].Grupo=='GRUPO CER'){envio='grupocer';}
          else
          {
            if(datos.TableInfo[i].IDSRamo==20){envio="grupoflotillas";}
            else
            {
            	if(datos.TableInfo[i].GerneciaNombre=='INSTITUCIONAL'){envio='institucional';}
            	else{envio='merida';}
            }
          }
       	}
       }
  		let endoso="";
        let primaTotal=parseFloat(Math.round(datos.TableInfo[i].PrimaTotal * 100) / 100).toFixed(2);
       if(datos.TableInfo[i].Endoso){endoso=datos.TableInfo[i].Endoso}     
       	let email='';
        let telefono='';
       if(datos.TableInfo[i].EMail1){email=datos.TableInfo[i].EMail1;}
       if(datos.TableInfo[i].Telefono1){telefono=datos.TableInfo[i].Telefono1;}
       let flimpago=datos.TableInfo[i].FLimPago.substr(0,10); 
      tabla=tabla+'<tr ondblclick="agregarParaCobranzaEfectuada(this)" class="tablaBuscarPoliza" data-iddocto="'+datos.TableInfo[i].IDDocto+'" data-serie="'+datos.TableInfo[i].Serie+'" data-IDRecibo="'+datos.TableInfo[i].IDRecibo+'" data-email="'+email+'" data-periodo="'+datos.TableInfo[i].Periodo+'" data-nombre="'+datos.TableInfo[i].NombreCompleto+'" data-IDCli="'+datos.TableInfo[i].IDCli+'" data-documento="'+datos.TableInfo[i].Documento+'" data-idmon="'+datos.TableInfo[i].IDMon+'" data-moneda="'+datos.TableInfo[i].Moneda+'" data-primatotal="'+primaTotal+'" data-tcday="'+datos.TableInfo[i].TCDay+'" data-endoso="'+endoso+'" data-idendoso="'+datos.TableInfo[i].IDEnd+'" data-telefono="'+telefono+'" data-enviarcorreo="'+envio+'" data-flimpago="'+flimpago+'">';
      tabla=tabla+'<td class="divTD15 ocultarObjeto" ><input type="checkbox" name="cbSeleccionCP" class="cbSeleccionCP"></td>'; 
      tabla=tabla+'<td data-value="'+datos.TableInfo[i].Documento+'" class="divTD150" >'+datos.TableInfo[i].Documento+'</td>';
      tabla=tabla+'<td class="divTD75"></td>';
      tabla=tabla+'<td class="divTD25"></td>';
      tabla=tabla+'<td class="ocultarObjeto divTD100">'+datos.TableInfo[i].IDRecibo+'</td>';
      tabla=tabla+'<td class="divTD75" data-value="'+datos.TableInfo[i].Serie+'">'+datos.TableInfo[i].Serie+'</td>';
      tabla=tabla+'<td class="divTD150" data-value="'+endoso+'">'+endoso+'</td>';
      tabla=tabla+'<td class="divTD400" data-value="'+datos.TableInfo[i].IDCli+'">'+datos.TableInfo[i].NombreCompleto+'</td>';
      tabla=tabla+'<td class="divTD400" data-value="'+datos.TableInfo[i].IDVend+'">'+datos.TableInfo[i].VendNombre+'</td>';
      tabla=tabla+'<td class="divTD150" data-value="'+datos.TableInfo[i].RamosNombre+'">'+datos.TableInfo[i].RamosNombre+'</td>';
      tabla=tabla+'<td class="divTD150 ocultarCelda" data-value="'+datos.TableInfo[i].SRamoNombre+'">'+datos.TableInfo[i].SRamoNombre+'</td>';
      tabla=tabla+'<td class="divTD150"><div class="divCell divCellEditable" contenteditable="true" onfocusout="cambiaContenidoCelda(this,\'email\')">'+email+'</div></td>';
      tabla=tabla+'<td class="divTD150"><div class="divCell divCellEditable" contenteditable="true" onfocusout="cambiaContenidoCelda(this,\'tel\')">'+telefono+'</div></td>';
      tabla=tabla+'<td class="divTD125"></td>';
      tabla=tabla+'<td class="divTD125" data-value="'+datos.TableInfo[i].CiaNombre+'">'+datos.TableInfo[i].CiaNombre+'</td>';
      tabla=tabla+'<td class="divTD125" data-value="'+datos.TableInfo[i].CCobro_TXT+'">'+datos.TableInfo[i].CCobro_TXT+'</td>';
      tabla=tabla+'<td class="divTD125" align="right">$'+primaTotal+'</td>';
 
      tabla=tabla+'<td class="divTD150" align="right"></td>';
      tabla=tabla+'<td class="divTD150" align="right"></td>';
      tabla=tabla+'<td class="divTD150" align="right"></td>';     
           tabla=tabla+'<td class="divTD125" align="right">'+datos.TableInfo[i].Status_TXT+'</td>';
      tabla=tabla+'</tr>';
      }
  	}
  	tabla=tabla+'</tbody></table>';
  	   
      document.getElementById('divBuscarPoliza').innerHTML=tabla;
       verOcultarDivPoliza();

  }	
}
function traerRecibosPagados(datos)
{
	if(datos=='')
	{
	  let params='poliza='+document.getElementById('textReciboParaCancelacion').value;
	  controlador="cobranza/traerRecibosPagados/?";
      peticionAJAX(controlador,params,'traerRecibosPagados');
	}
	else

	{
		
		  	let cantDatos=datos.TableInfo.length;
  	let tabla='<table class="table"><tbody id="bodyRecibosPagados"><tr colspan="6" ><td align="left"></td></tr>';

  	for(let i=0;i<cantDatos;i++)
  	{ let envio="";
       if(datos.TableInfo[i].Status==3)
       {
       	if(datos.TableInfo[i].IDDespacho==3){envio='cancun';}
       else
       {
       	if(datos.TableInfo[i].TipoDocto_TXT=='Fianza'){envio='fianzas';}
       	else
       	{
          if(datos.TableInfo[i].Grupo=='GRUPO CER'){envio='grupocer';}
          else
          {
            if(datos.TableInfo[i].IDSRamo==20){envio="grupoflotillas";}
            else
            {
            	if(datos.TableInfo[i].GerneciaNombre=='INSTITUCIONAL'){envio='institucional';}
            	else{envio='merida';}
            }
          }
       	}
       }
  		let endoso="";
        let primaTotal=parseFloat(Math.round(datos.TableInfo[i].PrimaTotal * 100) / 100).toFixed(2);
       if(datos.TableInfo[i].Endoso){endoso=datos.TableInfo[i].Endoso}     
       	let email='';
        let telefono='';
       if(datos.TableInfo[i].EMail1){email=datos.TableInfo[i].EMail1;}
       if(datos.TableInfo[i].Telefono1){telefono=datos.TableInfo[i].Telefono1;}
      tabla=tabla+'<tr ondblclick="agregarParaCobranzaEfectuada(this)" class="tablaBuscarPoliza" data-iddocto="'+datos.TableInfo[i].IDDocto+'" data-serie="'+datos.TableInfo[i].Serie+'" data-IDRecibo="'+datos.TableInfo[i].IDRecibo+'" data-email="'+email+'" data-periodo="'+datos.TableInfo[i].Periodo+'" data-nombre="'+datos.TableInfo[i].NombreCompleto+'" data-IDCli="'+datos.TableInfo[i].IDCli+'" data-documento="'+datos.TableInfo[i].Documento+'" data-idmon="'+datos.TableInfo[i].IDMon+'" data-moneda="'+datos.TableInfo[i].Moneda+'" data-primatotal="'+primaTotal+'" data-tcday="'+datos.TableInfo[i].TCDay+'" data-endoso="'+endoso+'" data-idendoso="'+datos.TableInfo[i].IDEnd+'" data-telefono="'+telefono+'" data-enviarcorreo="'+envio+'">';

      tabla=tabla+'<td class="divTD15" ><input type="radio" name="cbSeleccionCancelarRecibo"></td>'; 
      tabla=tabla+'<td data-value="'+datos.TableInfo[i].Documento+'" class="divTD150" >'+datos.TableInfo[i].Documento+'</td>';
      tabla=tabla+'<td class="divTD75"></td>';
      tabla=tabla+'<td class="divTD25"></td>';
      tabla=tabla+'<td class="ocultarObjeto divTD100">'+datos.TableInfo[i].IDRecibo+'</td>';
      tabla=tabla+'<td class="divTD75" data-value="'+datos.TableInfo[i].Serie+'">'+datos.TableInfo[i].Serie+'</td>';
      tabla=tabla+'<td class="divTD150" data-value="'+endoso+'">'+endoso+'</td>';
      tabla=tabla+'<td class="divTD400" data-value="'+datos.TableInfo[i].IDCli+'">'+datos.TableInfo[i].NombreCompleto+'</td>';
      tabla=tabla+'<td class="divTD400" data-value="'+datos.TableInfo[i].IDVend+'">'+datos.TableInfo[i].VendNombre+'</td>';
      tabla=tabla+'<td class="divTD150" data-value="'+datos.TableInfo[i].RamosNombre+'">'+datos.TableInfo[i].RamosNombre+'</td>';
      tabla=tabla+'<td class="divTD150 ocultarCelda" data-value="'+datos.TableInfo[i].SRamoNombre+'">'+datos.TableInfo[i].SRamoNombre+'</td>';
      tabla=tabla+'<td class="divTD150"><div class="divCell">'+email+'</div></td>';
      tabla=tabla+'<td class="divTD150"><div class="divCell">'+telefono+'</div></td>';
      tabla=tabla+'<td class="divTD125"></td>';
      tabla=tabla+'<td class="divTD125" data-value="'+datos.TableInfo[i].CiaNombre+'">'+datos.TableInfo[i].CiaNombre+'</td>';
      tabla=tabla+'<td class="divTD125" data-value="'+datos.TableInfo[i].CCobro_TXT+'">'+datos.TableInfo[i].CCobro_TXT+'</td>';
     
 tabla=tabla+'<td class="divTD125" align="right">$'+primaTotal+'</td>';

 tabla=tabla+'<td class="divTD125" align="right">'+datos.TableInfo[i].Status_TXT+'</td>';    
      tabla=tabla+'</tr>';
      }
  	}
  	tabla=tabla+'</tbody></table>';
  	   
      document.getElementById('divRecibosPagados').innerHTML=tabla;

	}
}
function buscarPoliza(datos)
{
  if(datos=='')
  {
  	var textoEscrito = prompt("Poliza a buscar", "");
   if(textoEscrito != null && textoEscrito!=''){
   	  let params='poliza='+textoEscrito;
	      controlador="cobranza/buscarPoliza/?";
    peticionAJAX(controlador,params,'buscarPoliza');
   
     } 
    else {alert("No has escrito nada");}


  }
  else
  {

  	let cantDatos=datos.TableInfo.length;
  	let tabla='<table class="table" border="1"><thead><tr ><td align="left" colspan="20"><button onclick=verOcultarDivPoliza() style="color:white;background-color:red">X</button><h2>Seleccionar Recibo</h2></td></tr><tr><th class="divTD15 ocultarObjeto"></th><th class="divTD150">DOCUMENTO</th><th class="divTD75"></th><th class="divTD25"></th><th class="ocultarObjeto divTD100" >RECIBO</th><th class="divTD75">SERIE</th><th class="divTD150">ENDOSO</th><th class="divTD400">NOMBRE</th><th class="divTD400">VENDEDOR</th><th class="divTD150">RAMO</th><th class="divTD150 ocultarObjeto">RAMO</th><th class="divTD150">EMAIL</th><th class="divTD150">TELEFONO</th><td class="divTD125"><th class="divTD125">COMPANIA</th><th class="divTD125">COBRO</th><th class="divTD125"></th><th class="divTD150"></th><th class="divTD150"></th><th class="divTD150">PRIMA</th><th class="divTD125">STATUS</th></tr></thead>';

  	for(let i=0;i<cantDatos;i++)
  	{ let envio="";
       if(datos.TableInfo[i].Status==0){
       	if(datos.TableInfo[i].IDDespacho==3){envio='cancun';}
       else
       {
       	if(datos.TableInfo[i].TipoDocto_TXT=='Fianza'){envio='fianzas';}
       	else
       	{
          if(datos.TableInfo[i].Grupo=='GRUPO CER'){envio='grupocer';}
          else
          {
            if(datos.TableInfo[i].IDSRamo==20){envio="grupoflotillas";}
            else
            {
            	if(datos.TableInfo[i].GerneciaNombre=='INSTITUCIONAL'){envio='institucional';}
            	else{envio='merida';}
            }
          }
       	}
       }
  		let endoso="";
        let primaTotal=parseFloat(Math.round(datos.TableInfo[i].PrimaTotal * 100) / 100).toFixed(2);
       if(datos.TableInfo[i].Endoso){endoso=datos.TableInfo[i].Endoso}     
       	let email='';
        let telefono='';
       if(datos.TableInfo[i].EMail1){email=datos.TableInfo[i].EMail1;}
       if(datos.TableInfo[i].Telefono1){telefono=datos.TableInfo[i].Telefono1;}
       let flimpago=datos.TableInfo[i].FLimPago.substr(0,10); 
      tabla=tabla+'<tr ondblclick="agregarParaCobranzaEfectuada(this)" class="tablaBuscarPoliza" data-iddocto="'+datos.TableInfo[i].IDDocto+'" data-serie="'+datos.TableInfo[i].Serie+'" data-IDRecibo="'+datos.TableInfo[i].IDRecibo+'" data-email="'+email+'" data-periodo="'+datos.TableInfo[i].Periodo+'" data-nombre="'+datos.TableInfo[i].NombreCompleto+'" data-IDCli="'+datos.TableInfo[i].IDCli+'" data-documento="'+datos.TableInfo[i].Documento+'" data-idmon="'+datos.TableInfo[i].IDMon+'" data-moneda="'+datos.TableInfo[i].Moneda+'" data-primatotal="'+primaTotal+'" data-tcday="'+datos.TableInfo[i].TCDay+'" data-endoso="'+endoso+'" data-idendoso="'+datos.TableInfo[i].IDEnd+'" data-telefono="'+telefono+'" data-enviarcorreo="'+envio+'" data-flimpago="'+flimpago+'">';
      tabla=tabla+'<td class="divTD15 ocultarObjeto" ><input type="checkbox" name="cbSeleccionCP" class="cbSeleccionCP"></td>'; 
      tabla=tabla+'<td data-value="'+datos.TableInfo[i].Documento+'" class="divTD150" >'+datos.TableInfo[i].Documento+'</td>';
      tabla=tabla+'<td class="divTD75"></td>';
      tabla=tabla+'<td class="divTD25"></td>';
      tabla=tabla+'<td class="ocultarObjeto divTD100">'+datos.TableInfo[i].IDRecibo+'</td>';
      tabla=tabla+'<td class="divTD75" data-value="'+datos.TableInfo[i].Serie+'">'+datos.TableInfo[i].Serie+'</td>';
      tabla=tabla+'<td class="divTD150" data-value="'+endoso+'">'+endoso+'</td>';
      tabla=tabla+'<td class="divTD400" data-value="'+datos.TableInfo[i].IDCli+'">'+datos.TableInfo[i].NombreCompleto+'</td>';
      tabla=tabla+'<td class="divTD400" data-value="'+datos.TableInfo[i].IDVend+'">'+datos.TableInfo[i].VendNombre+'</td>';
      tabla=tabla+'<td class="divTD150" data-value="'+datos.TableInfo[i].RamosNombre+'">'+datos.TableInfo[i].RamosNombre+'</td>';
      tabla=tabla+'<td class="divTD150 ocultarCelda" data-value="'+datos.TableInfo[i].SRamoNombre+'">'+datos.TableInfo[i].SRamoNombre+'</td>';
      tabla=tabla+'<td class="divTD150"><div class="divCell divCellEditable" contenteditable="true" onfocusout="cambiaContenidoCelda(this,\'email\')">'+email+'</div></td>';
      tabla=tabla+'<td class="divTD150"><div class="divCell divCellEditable" contenteditable="true" onfocusout="cambiaContenidoCelda(this,\'tel\')">'+telefono+'</div></td>';
      tabla=tabla+'<td class="divTD125"></td>';
      tabla=tabla+'<td class="divTD125" data-value="'+datos.TableInfo[i].CiaNombre+'">'+datos.TableInfo[i].CiaNombre+'</td>';
      tabla=tabla+'<td class="divTD125" data-value="'+datos.TableInfo[i].CCobro_TXT+'">'+datos.TableInfo[i].CCobro_TXT+'</td>';
     
      tabla=tabla+'<td class="divTD150" align="right"></td>';
      tabla=tabla+'<td class="divTD150" align="right"></td>';
      tabla=tabla+'<td class="divTD150" align="right"></td>';
 tabla=tabla+'<td class="divTD125" align="right">$'+primaTotal+'</td>';

 tabla=tabla+'<td class="divTD125" align="right">'+datos.TableInfo[i].Status_TXT+'</td>';    
      tabla=tabla+'</tr>';
      }
  	}
  	tabla=tabla+'</table>';
  	   
      document.getElementById('divBuscarPoliza').innerHTML=tabla;
       verOcultarDivPoliza();
   
  }
}
function agregarParaCobranzaEfectuada(objeto){
	//alert(objeto.rowIndex);
	let tabla=document.getElementById('bodyTablaCobPen');
	let cantRows=tabla.rows.length;
	let bandEntrada=0;
	let recibo=objeto.getAttribute('data-IDRecibo');
	for(let i=0;i<cantRows;i++)
	{
		if(tabla.rows[i].getAttribute('data-IDRecibo')==recibo){bandEntrada=1;i=cantRows;}
	}
	if(bandEntrada==0)
	{  
		cantCells=objeto.cells.length;
		cantCells=cantCells-1;
		objeto.deleteCell(cantCells);
		let doc=objeto.cells[1].innerHTML+'<br><button class="btn-chico" onclick="abrirVentanaOpciones(this)">&#128070</button><br>';
    //objeto.cells[1].innerHTML=doc;
	objeto.removeAttribute('class');
	objeto.removeAttribute('ondblclick');
	objeto.cells[0].classList.remove('ocultarObjeto');
	objeto.setAttribute('onclick','seleccionRow(this)')
	document.getElementById('bodyTablaCobPen').insertBefore(objeto,document.getElementById('bodyTablaCobPen').rows[1]);
	seleccionRow(document.getElementById('bodyTablaCobPen').rows[1]);
	traerCobranzaPolizaAgregada();
	document.getElementById('bodyTablaCobPen').rows[1].cells[1].innerHTML=doc;
	verOcultarDivPoliza();
    }
    else{alert('El recibo ya esta dentro de la cobranza pendiente');}
}
function abrirVentanaOpciones(objeto)
{
	seleccionRow(objeto.parentElement.parentElement);
	document.getElementById("divMenuFlotante").classList.remove('contMenuFlotanteMinimizado');
	document.getElementById("divMenuFlotante").classList.add('contMenuFlotante');
}
</script>


<?php


function armaSelects($array,$valor,$descripcion)
{
  $option="";
  if($valor==''){foreach ($array as  $value) {$option.='<option>'.$value->$descripcion.'</option>';}}
  return $option;
}

  	 	
function imprimirCobranzaPendiente($cobranzaPendiente,$classNombre,$idBody,$filtros,$opcionFecha,$envioEmail)
{

 $info="";$filtroSubRamo=array();$filtroVendedor=array();$filtroCliente=array();$filtroFecLimPago=array();$cont=0;  $filtroEndoso=array(); $filtroCiaNombre=array();$filtroCCobro_TXT=array();$filtroSerie=array();
 $CabSinSolicitud='<tr data-value="0"><td><button class="btn-chico" onclick="ocultarHijosCP(this)">-</button></td><td colspan="17">COBRANZA PENDIENTE</td></tr>';
 $solicitudCobranza='';
 $sinSolicitudDeCobranza='';
if(isset($cobranzaPendiente->TableControl)){
if((int)$cobranzaPendiente->TableControl->MaxRecords>0)
 {
  foreach ($cobranzaPendiente->TableInfo as  $value) {
  	$info='';
  	$envio="";
  	if($envioEmail!='')
  	{$envio=$envioEmail;}
     else
     {      
       if($value->IDDespacho==3){$envio='cancun';}
       else
       {
       	if($value->TipoDocto_TXT=='Fianza'){$envio='fianzas';}
       	else
       	{
          if($value->Grupo=='GRUPO CER'){$envio='grupocer';}
          else
          {
            if($value->IDSRamo==20){$envio="grupoflotillas";}
            else
            {
            	if($value->GerneciaNombre=='INSTITUCIONAL'){$envio='institucional';}
            	else{$envio='merida';}
            }
          }
       	}
       }
     }
  	$primaTotal=round((float)$value->PrimaTotal,2);
  	if($opcionFecha=='FLimPago'){$fecha=Strstr($value->FLimPago,"T",true);}
  	if($opcionFecha=='FDesde'){$fecha=Strstr($value->FDesde,"T",true);}
  	if($opcionFecha=='FHasta'){$fecha=Strstr($value->FHasta,"T",true);}
  	$fechaLimite=$fecha=Strstr($value->FLimPago,"T",true);
  	$btnSolCobranza='';
  	$claseStatus='';

  	if($value->cobranzaConSolicitud>0 || $value->cobranzaSinSolicitud>0 || $value->cobranzaComenatarios>0)
  		{$btnSolCobranza='<button class="btn-chico" onclick="traerComentarioSolicitudCobro(\'\','.$value->IDDocto.',\''.$value->Documento.'\','.$value->IDRecibo.')">&#9998</button>';
  	     switch ($value->estatusConSolicitud) 
  	     {  	     	
  	     	case 1:$claseStatus='classTieneAgente';break;
  	     	case 5:$claseStatus='classTieneEjecutivo';break;
  	     }
        }

	$info.='<tr onclick="seleccionRow(this)" class="rowTabla '.$claseStatus.'" data-iddocto="'.$value->IDDocto.'" data-serie="'.$value->Serie.'" data-IDRecibo="'.$value->IDRecibo.'" data-email="'.$value->EMail1.'" data-periodo="'.$value->Periodo.'" data-nombre="'.$value->NombreCompleto.'" data-IDCli="'.$value->IDCli.'" data-documento="'.$value->Documento.'" data-idmon="'.$value->IDMon.'" data-moneda="'.$value->Moneda.'" data-primatotal="'.$primaTotal.'" data-tcday="'.$value->TCDay.'" data-endoso="'.$value->Endoso.'" data-idendoso="'.$value->IDEnd.'" data-telefono="'.$value->Telefono1.'" data-enviarcorreo="'.$envio.'" data-flimpago="'.$fechaLimite.'" data-ramo="'.$value->RamosNombre.'" data-idsramo="'.$value->IDSRamo.'" data-idvend="'.$value->IDVend.'" data-fpago="'.$value->FPago.'">';
	// $info.='<td class="divTD50" ><input type="radio" name="radioCobranzaPendiente"></td>';
    $info.='<td class="divTD15"><input type="checkbox" name="'.$classNombre.'" class="'.$classNombre.'"></td>';
    //$info.='<td class="divTD150"   data-iddocto="'.$value->IDDocto.'" data-serie="'.$value->Serie.'" data-IDRecibo="'.$value->IDRecibo.'">'.$value->Documento.'</td>';
   $info.='<td class="divTD150"   data-value="'.$value->Documento.'">'.$value->Documento.'<br>'.$btnSolCobranza.'<button class="btn-chico" onclick="abrirVentanaOpciones(this)">&#128070</button><br>'.$value->tipoSolicitud.'</td>';
    $info.='<td class="divTD75"></td>';
    $info.='<td class="divTD25"></td>';
    $info.='<td class="divTD100 ocultarObjeto">'.$value->IDRecibo.'</td>';  
    $info.='<td class="divTD75" data-value="'.$value->Serie.'">'.$value->Serie.'</td>';
    $info.='<td class="divTD150" align="center" data-value="'.$value->Endoso.'">'.$value->Endoso.'</td>';
    $info.='<td class="divTD400" data-value="'.$value->IDCli.'">'.$value->NombreCompleto.'</td>';
    $info.='<td class="divTD400" data-value="'.$value->IDVend.'">'.$value->VendNombre.'</td>';
    $info.='<td class="divTD150" data-value="'.$value->RamosNombre.'">'.$value->RamosNombre.'</td>';
    $info.='<td class="divTD150 ocultarCelda" data-value="'.$value->SRamoNombre.'">'.$value->SRamoNombre.'</td>';
    $info.='<td class="divTD150"><div class="divCell divCellEditable" contentEditable="true" onfocusout="cambiaContenidoCelda(this,\'email\')">'.$value->EMail1.'</div></td>';
    $info.='<td class="divTD150"><div class="divCell divCellEditable" contentEditable="true" onfocusout="cambiaContenidoCelda(this,\'tel\')">'.$value->Telefono1.'</div></td>';    
    $info.='<td class="divTD125" data-value="'.$fecha.'">'.$fecha.'</td>';
    $info.='<td class="divTD125" data-value="'.$value->CiaNombre.'">'.$value->CiaNombre.'</td>';
    $info.='<td class="divTD125" data-value="'.$value->CCobro_TXT.'">'.$value->CCobro_TXT.'</td>';
    $info.='<td class="divTD125" align="right">$'.$primaTotal.'</td>';
    $info.='<td class="divTD150" align="right"></td>';
    $info.='<td class="divTD150" align="right"></td>';
    $info.='<td class="divTD150" align="right"></td>';
	$info.='</tr>';

	$nombre=(string)$value->SRamoNombre	;
	$vendedor=(string)$value->VendNombre;
	$Documento=(string)$value->Documento;
	$Endoso=(string)$value->Endoso;
	$ramosnombre=(string)$value->RamosNombre;	
	$CiaNombre=(string)$value->CiaNombre;
	$CCobro_TXT=(string)$value->CCobro_TXT;
	$Serie=$value->Serie;
   if($nombre!=''){$filtroSubRamo[$nombre]=$nombre;}
   if($Endoso!=''){$filtroEndoso[$Endoso]=$Endoso;}
     $filtroVendedor[(string)$value->IDVend]=$vendedor;
     $filtroCliente[(string)$value->IDCli]=(string)$value->NombreCompleto;
     $filtroFecLimPago[(string)$fecha]=(string)$fecha;
     $filtroDocumento[(string)$value->Documento]=(string)$Documento;
     $filtroRamosNombre[(string)$value->RamosNombre]=(string)$ramosnombre;
     $filtroCiaNombre[(string)$value->CiaNombre]=(string)$CiaNombre;
     $filtroCCobro_TXT[(string)$value->CCobro_TXT]=(string)$CCobro_TXT;
     $filtroSerie[(string)$value->Serie]=(string)$Serie;
     if($value->cobranzaConSolicitud>0){$solicitudCobranza.=$info;}
     else{$sinSolicitudDeCobranza.=$info;}
}
$info='';
$info=$CabSinSolicitud;
$info.=$sinSolicitudDeCobranza;
$info.='<tr data-value="1"><td><button class="btn-chico" onclick="ocultarHijosCP(this)">-</button></td><td colspan="17">SOLICITUD DE COBRO</td></tr>';
$info.=$solicitudCobranza;
$datos['tabla']=$info; 
asort($filtroSubRamo);
asort($filtroVendedor);
asort($filtroCliente);
asort($filtroFecLimPago);
asort($filtroDocumento);
asort($filtroEndoso);
asort($filtroRamosNombre);
asort($filtroCiaNombre);
asort($filtroCCobro_TXT);
asort($filtroSerie);
$array['bodyTablaId']=$idBody;


$array['selectId']=$filtros['subRamo'];//'selectCobPenSubRamo';
$array['class']='ocultarObjetoSubRamo';
$datos['filtroSubramo']=armaFiltros($filtroSubRamo,$array);
$array['selectId']=$filtros['vendedor'];//'selectCobPenVend';
$array['class']='ocultarObjetoVendedor';
$datos['filtroVendedor']=armaFiltros($filtroVendedor,$array);
$array['selectId']=$filtros['cliente'];//'selectCobPenCliente';
$array['class']='ocultarObjetoCliente';
$datos['filtroCliente']=armaFiltros($filtroCliente,$array);
$array['selectId']=$filtros['fechaLimite'];//selectCobPenFecLim';
$array['class']='ocultarObjetoFecLim';
$datos['filtroFecLimPago']=armaFiltros($filtroFecLimPago,$array);
$array['selectId']=$filtros['documento'];//'selectCobPenSubRamo';
$array['class']='ocultarObjetoSubRamo';
$datos['filtroDocumento']=armaFiltros($filtroDocumento,$array);
$array['selectId']=$filtros['endoso'];//'selectEndoso';
$array['class']='ocultarObjetoEndoso';
$datos['filtroEndoso']=armaFiltros($filtroEndoso,$array);
$array['selectId']=$filtros['ramosnombre'];//'';
$array['class']='ocultarObjetoRamosNombre';
$datos['filtroRamosNombre']=armaFiltros($filtroRamosNombre,$array);
$array['selectId']=$filtros['cianombre'];//'';
$array['class']='ocultarObjetoCiaNombre';
$datos['filtroCiaNombre']=armaFiltros($filtroCiaNombre,$array);
$array['selectId']=$filtros['ccobro_txt'];//'';
$array['class']='ocultarObjetoCCobro_TXT';
$datos['filtroCCobro_TXT']=armaFiltros($filtroCCobro_TXT,$array);
$array['selectId']=$filtros['serie'];//'';
$array['class']='ocultarObjetoSerie';
$datos['filtroSerie']=armaFiltros($filtroSerie,$array);

return $datos;
 }
  }
}

function armaFiltros($info,$array){
$filtros='<input type="text" class="form-control" onblur="filtraSelect(this.value,\''.$array['selectId'].'\')" ><br><select class="form-control" id="'.$array['selectId'].'"  onchange="aplicarFiltro(this,\''.$array['bodyTablaId'].'\',\''.$array['selectId'].'\',\''.$array['class'].'\')"><option value="" ></option>';
 foreach ($info as $key => $value) {$filtros.='<option value="'.$key.'">'.$value.'</option>';}
 $filtros.='</select>';//<input type="checkBox" onclick="aplicarFiltro(this,\''.$array['bodyTablaId'].'\',\''.$array['selectId'].'\',\''.$array['class'].'\')">';
return $filtros;

}


?>
<script type="text/javascript">
//JavaScript para Div de Notificaciones Flotante
var ct=0;
function cerrarAlerta(){
	if(ct==0){
		document.getElementById('alerta').style.display="none";
		ct=1;
	}
}
 $( function() {
    $( "#alerta" ).draggable();
  } );


	function verOcultarPanel(index)
{
  let cb=document.getElementsByName('panelMenuFlotante');
  let cant=cb.length;    
  for(let i=0;i<cant;i++){
  	cb[i].classList.remove('verObjeto');
  	cb[i].classList.add('ocultarObjeto');
  }
  cb[index].classList.remove('ocultarObjeto');
  cb[index].classList.add('verObjeto');
  if(index==5)
  {
  	objeto=document.getElementsByClassName('rowSeleccionado')[0];
  	document.getElementById('selectTipoPago').value=0;
  	if(objeto){
    $(function () {$(".fecha").datepicker({}).datepicker("setDate", new Date());
	if(objeto.getAttribute('data-class')=='divConDocRecibo'){document.getElementById('buttonAplicaPago').classList.remove('ocultarObjeto')}
	else{}
	let parametrosDocumentos=[objeto.getAttribute('data-iddocto'),objeto.getAttribute('data-serie'),objeto.getAttribute('data-tcday')];
	traeDocumento(parametrosDocumentos,'');
	
    });
   }
   else{
   	alert('seleccion un recibo para el pago')
   	verOcultarPanel(0);
   }
  }
}

function seleccionarCB(objeto,tbody,nameCB)
{
  let cb=document.getElementsByName(nameCB);
  let cantCB=cb.length;
  let estado=false;
  if(objeto.checked){estado=true;}
  for(let i=0;i<cantCB;i++)
  {
  	cb[i].checked=estado;
    /*let cant=cb[i].parentElement.parentElement.classList.length;
        if(cant==1){cb[i].checked=estado;}
        else{if(cant==2){if(cb[i].parentElement.parentElement.classList.contains('rowSeleccionado')){cb[i].checked=estado;}}}*/
  }

}

function enviarCorreos(datos,nameCB,bodyTabla){
	if(datos==''){
	let  emailRegex = /^[-\w.%+]{1,64}@(?:[A-Z0-9-]{1,63}\.){1,125}[A-Z]{2,63}$/i;
	let datos="";
	
	var arrayProperties = new Array();
   let cb=document.getElementsByName(nameCB);
  let cantCB=cb.length;

  for(let i=0;i<cantCB;i++){

  	let bandEntrada=0;
   let cant=cb[i].parentElement.parentElement.classList.length;
        if(cant==1){bandEntrada=1;}
        else{if(cant==2){if(cb[i].parentElement.parentElement.classList.contains('rowSeleccionado')){bandEntrada=1}}}
        //if(bandEntrada){
          if(cb[i].checked)
          { 
        	   let dataEmail=cb[i].parentElement.parentElement.getAttribute('data-email');
        	   let dataHref=cb[i].parentElement.parentElement.getAttribute('data-href');
        	   let dataHrefComprobante=cb[i].parentElement.parentElement.getAttribute('data-hrefcomprobante');
        	   let dataIdRecibo=cb[i].parentElement.parentElement.getAttribute('data-idrecibo');
        	   let dataIdSerie=cb[i].parentElement.parentElement.getAttribute('data-serie');
        	   let dataIdDocto=cb[i].parentElement.parentElement.getAttribute('data-iddocto');
        	   let dataIdCli=cb[i].parentElement.parentElement.getAttribute('data-idcli');
        	   let documento=cb[i].parentElement.parentElement.getAttribute('data-documento');
        	   let endoso=cb[i].parentElement.parentElement.getAttribute('data-endoso');
        	   let flimpago=cb[i].parentElement.parentElement.getAttribute('data-flimpago');
        	  if (emailRegex.test(dataEmail))
        	  {
        	  	if(dataHref!='')
        	  	{
        	  	}
        	  	else{cb[i].checked=false;}
        	  }
        	  else{cb[i].checked=false;}
        	       let properties = new Object();
        	  properties.email=dataEmail;
        	  properties.href=dataHref;
        	  		properties.idRecibo=dataIdRecibo; 
        	  		properties.idSerie=dataIdSerie; 
        	  		properties.idDocto=dataIdDocto;         	  		
        	  		properties.IDCli=dataIdCli;
        	  		properties.hrefComprobante =dataHrefComprobante;
        	  		properties.documento =documento;
        	  		properties.endoso =endoso;
        	  		properties.flimpago =flimpago;
        	  		arrayProperties.push(properties);                 

          }
       // }
  }

 var params = 'valores='+JSON.stringify(arrayProperties)+'&bodyTabla='+bodyTabla;
    controlador="cobranza/enviarCorreos/?";
    peticionAJAX(controlador,params,'enviarCorreos');
 }else
 {
   
   let cantidad=datos.idRecibo.length;
   let tablaBody=document.getElementById(datos.bodyTabla);
   let cantidadRows=tablaBody.rows.length;
   for(let i=0;i<cantidad;i++)   	
   {
    for(let j=0;j<cantidadRows;j++)
    {
      if(datos.idRecibo[i].idRecibo==tablaBody.rows[j].getAttribute('data-idrecibo'))
      {
      	if(datos.idRecibo[i].status==1)
      	{
          tablaBody.rows[j].cells[3].classList.add('iconoemail');
          tablaBody.rows[j].cells[0].classList.remove('noEnviadoClass');
          j=cantidadRows; 
        }
        else
        {
         tablaBody.rows[j].cells[0].classList.add('noEnviadoClass');
          j=cantidadRows; 
        }
      }
    } 
   }
   historialEnviosPorUsuario('');
 }

}

	function despliegueGrid(objeto,tabla){		
		if(objeto.innerHTML=='+'){document.getElementById(tabla).classList.remove('ocultarObjeto');objeto.innerHTML="-";}
		else{document.getElementById(tabla).classList.add('ocultarObjeto');objeto.innerHTML="+";}
	}
function moverScroll(objeto,cabecera){var elmnt = objeto;var x = elmnt.scrollLeft;document.getElementById(cabecera).scrollLeft=x;}

function muestraArchivosEnBox(objeto){
document.getElementById('divLinksDocumentos').innerHTML=objeto.nextSibling.innerHTML;

}
function seleccionRowRenovacion(row)
{
  let tabla=document.getElementById('bodyTablaRenovaciones');
  let cantidad=tabla.rows.length;
  for(let i=0;i<cantidad;i++){tabla.rows[i].classList.remove('seleccionRenovacion');}
  row.classList.add('seleccionRenovacion');
}
function seleccionRow(objeto){

	let cant=0;
	if(objeto){cant=objeto.parentNode.rows.length;}
	
	let cantCP=document.getElementById('bodyTablaCobPen').rows.length;
	let cantCA=document.getElementById('bodyTablaCobAtrasada').rows.length;
	for(let i=0;i<cantCP;i++){document.getElementById('bodyTablaCobPen').rows[i].classList.remove('rowSeleccionado');}	
	for(let i=0;i<cantCA;i++){document.getElementById('bodyTablaCobAtrasada').rows[i].classList.remove('rowSeleccionado');}	
	objeto.classList.add('rowSeleccionado');
	if(document.getElementById("ul"+objeto.getAttribute('data-idrecibo')))
	{document.getElementById('divLinksDocumentos').innerHTML=document.getElementById("ul"+objeto.getAttribute('data-idrecibo')).innerHTML;}
	else{document.getElementById('divLinksDocumentos').innerHTML="";}
	document.getElementById('labelNombreClienteMF').innerHTML=objeto.getAttribute('data-nombre');
	document.getElementById('hiddenIDCliMF').value=objeto.getAttribute('data-idcli');
	//document.getElementById('inputMonedaPago').value=objeto.getAttribute('data-moneda');

     let tipoCambio=objeto.getAttribute('data-idmon');
     let pesosAct='';
     let dolaresAct='';
     let eurosAct='';
     if(tipoCambio==1){pesosAct='Selected';}
     if(tipoCambio==2){dolaresAct='Selected';}
     if(tipoCambio==3){eurosAct='Selected';}
    let option='<option value="1" '+pesosAct+'>Pesos Mexicanos</option><option value="2" '+dolaresAct+'>Dolares</option><option value="3" '+eurosAct+'>Euros</option>';    
    document.getElementById('selectMonedaPago').innerHTML=option;
	document.getElementById('inputImportePago').value=objeto.getAttribute('data-primatotal');
	document.getElementById('inputImporteReal').value=objeto.getAttribute('data-primatotal');
	document.getElementById('inputTipoCambio').value=objeto.getAttribute('data-tcday');
	document.getElementById('selectMonedaDocto').innerHTML=option;
	document.getElementById('divHistorialClientes').innerHTML='';
	document.getElementById('telefonosClienteSelect').innerHTML='';
	document.getElementById('correosClientesSelect').innerHTML='';
	document.getElementById('contenedorDocumentosPersonalesDiv').innerHTML=''; 	 
	iddoctoSolicitudComentario.value='';
   document.getElementById('iddoctoSolicitudComentario').value=objeto.getAttribute('data-iddocto');
   document.getElementById('idreciboSolicitudComentario').value=objeto.getAttribute('data-idrecibo');
   documentoSolicitudComentario.value=objeto.getAttribute('data-documento');
   documentoSolicitudIDCli.value=objeto.dataset.idcli;
   documentoSolicitudidSerie.value=objeto.dataset.serie;
   documentoSolicitudEndoso.value=objeto.dataset.endoso;
	verOcultarPanel(0);
	
}
function aplicarFiltro(objeto,tabla,select,clase){	
	let tablaFiltro=document.getElementById(tabla);
	let totalRows=tablaFiltro.rows.length;
	let valorComparar=document.getElementById(select).value;
	if(objeto.value!=''){
	for(let i=0;i<totalRows;i++){
		if(tablaFiltro.rows[i].getAttribute('data-value')!='-1' && tablaFiltro.rows[i].getAttribute('data-value')!='0' && tablaFiltro.rows[i].getAttribute('data-value')!='1')
		{
		if(tablaFiltro.rows[i].cells[objeto.parentNode.parentNode.cellIndex].getAttribute('data-value')!=valorComparar)
			{tablaFiltro.rows[i].classList.add(clase);}
		else{tablaFiltro.rows[i].classList.remove(clase);}
	  }

	}
   }
   else{for(let i=0;i<totalRows;i++){tablaFiltro.rows[i].classList.remove(clase);}}
	//
}
function mostrarHijosRenovacion(objeto)
{
	let name=objeto.getAttribute('data-renovacion');
	let elementos=document.getElementsByName(name);
	let cant=elementos.length;
	if(objeto.innerHTML=='+')
	{
		for(let i=0;i<cant;i++)
		{
			elementos[i].classList.remove('trRenovacionOcultarHijo');
		}
		objeto.innerHTML='-';
	}
	else
	{
	  for(let i=0;i<cant;i++)
		{
			elementos[i].classList.add('trRenovacionOcultarHijo');
		}
		objeto.innerHTML='+';
	}
}
function agregarArchivosVigentes(objeto)
{
  let cant=objeto.files.length;
  let nombres='';
  for(let i=0;i<cant;i++)
  {
    nombres=nombres+objeto.files[i].name;
  }
  
}
function enviarArchivoAJAXCobranza(formulario,funcion){
  
   document.getElementById('gifDeEspera1').classList.remove('ocultarObjeto');
   document.getElementById('gifDeEspera1').classList.add('verObjetoGif');
   //=====PARA RECIBO
  	document.getElementById('inputIdDocto').value=document.getElementsByClassName('rowSeleccionado')[0].getAttribute('data-iddocto');
    document.getElementById('inputSerie').value=document.getElementsByClassName('rowSeleccionado')[0].getAttribute('data-serie');
	document.getElementById('inputRecibo').value=document.getElementsByClassName('rowSeleccionado')[0].getAttribute('data-idrecibo');
	document.getElementById('inputDocumento').value=document.getElementsByClassName('rowSeleccionado')[0].getAttribute('data-documento');
	document.getElementById('inputPeriodo').value=document.getElementsByClassName('rowSeleccionado')[0].getAttribute('data-periodo');
	document.getElementById('inputBody').value=document.getElementsByClassName('rowSeleccionado')[0].parentNode.id;
	document.getElementById('inputEndoso').value=document.getElementsByClassName('rowSeleccionado')[0].getAttribute('data-endoso');
	document.getElementById('inputIdEndoso').value=document.getElementsByClassName('rowSeleccionado')[0].getAttribute('data-idendoso');
	document.getElementById('inputIdEnviarCorreo').value=document.getElementsByClassName('rowSeleccionado')[0].getAttribute('data-enviarcorreo');
    //====PARA COMPROBANTE
	document.getElementById('inputIdDoctoComp').value=document.getElementsByClassName('rowSeleccionado')[0].getAttribute('data-iddocto');
    document.getElementById('inputSerieComp').value=document.getElementsByClassName('rowSeleccionado')[0].getAttribute('data-serie');
	document.getElementById('inputReciboComp').value=document.getElementsByClassName('rowSeleccionado')[0].getAttribute('data-idrecibo');
	document.getElementById('inputDocumentoComp').value=document.getElementsByClassName('rowSeleccionado')[0].getAttribute('data-documento');
	document.getElementById('inputPeriodoComp').value=document.getElementsByClassName('rowSeleccionado')[0].getAttribute('data-periodo');
	document.getElementById('inputEndosoComp').value=document.getElementsByClassName('rowSeleccionado')[0].getAttribute('data-endoso');
    document.getElementById('inputIdEndosoComp').value=document.getElementsByClassName('rowSeleccionado')[0].getAttribute('data-idendoso');
	document.getElementById('inputBodyComp').value=document.getElementsByClassName('rowSeleccionado')[0].parentNode.id;
	document.getElementById('inputIdEnviarCorreoComp').value=document.getElementsByClassName('rowSeleccionado')[0].getAttribute('data-enviarcorreo');
	document.getElementById('inputIdCliente').value=document.getElementsByClassName('rowSeleccionado')[0].getAttribute('data-idcli');
    document.getElementById('inputIndexCobranza').value=document.getElementsByClassName('rowSeleccionado')[0].rowIndex;
   
    var Data = new FormData(document.getElementById(formulario));  
  if(window.XMLHttpRequest) { var Req = new XMLHttpRequest();}
  else if(window.ActiveXObject) {var Req = new ActiveXObject("Microsoft.XMLHTTP");}
  var direccion= <?php echo('"'.base_url().'cobranza/"');?>+funcion;
  Req.open("POST",direccion, true);  
  Req.onload = function(Event) {  
    if (Req.status == 200) 
    {
      var respuesta = JSON.parse(Req.responseText);      
      document.getElementById('gifDeEspera1').classList.remove('verObjetoGif');
      document.getElementById('gifDeEspera1').classList.add('ocultarObjeto');
      document.getElementById('divContenedorArchivos').innerHTML='';
      

       let cantidad=respuesta.children.length;
                      let cadena="";
               let cadenaDocumentos="";
              for(let t=0;t<cantidad;t++)
              { let bandEntrada=0;
              	if(respuesta.children[t].isFolder!=1)
              	{
                 if(respuesta.endoso!='')
                 {  
                 	let textEndoso=respuesta.endoso+'_'+respuesta.periodo;
                 	let textEndosoComprobante=respuesta.endoso+'_'+respuesta.periodo+'Comprobante';
                 	
                 	if(respuesta.children[t].text==textEndoso || respuesta.children[t].text==textEndosoComprobante)
                 	{bandEntrada=1;}
                     if(respuesta.children[t].text==textEndoso){dataHref=respuesta.children[t].href;}
                 	if(respuesta.children[t].text==textEndosoComprobante){dataHrefComprobante=respuesta.children[t].href;}
                 }
                 else
                 {
                    let textEndoso=respuesta.inner+'_'+respuesta.periodo;
                 	let textEndosoComprobante=respuesta.inner+'_'+respuesta.periodo+'Comprobante';                 	
                 	if(respuesta.children[t].text==textEndoso || respuesta.children[t].text==textEndosoComprobante){bandEntrada=1;}
                 	if(respuesta.children[t].text==textEndoso){dataHref=respuesta.children[t].href;}
                 	if(respuesta.children[t].text==textEndosoComprobante){dataHrefComprobante=respuesta.children[t].href;}
                 }

                   let clase=devolverTipoArchivo(respuesta.children[t].href);                 	
                  if(bandEntrada){                  	
                  cadena+=`<li class="liArchivos liReciboComprobante"><div class="${clase} iconogenerico"><a href="${respuesta.children[t].href}" target="_blank">${respuesta.children[t].text}</a></div></li>`; }
                  else{
                  	      if(respuesta.children[t].href.indexOf(respuesta.IDRecibo)!=-1)
                  	    {
                  cadenaDocumentos+=`<li class="liArchivos"><div class="${clase} iconogenerico"><a href="${respuesta.children[t].href}" target="_blank">${respuesta.children[t].text}</a></div></li>`;}                  	
                     }                	                
                 }
              	}


               if(cadena!="" || cadenaDocumentos!="")
               {      
                    if(cadena!="")
                    {
                    	  bandRecibo1="divConDocRecibo";
                    	bandRecibo2="divCDRCP";
                	cadena='<div class="divDocumentos"><ul class="ulDocumentos" id="ul'+respuesta.IDRecibo+'"><div class="iconocarpeta"><label></label><h3>'+respuesta.inner+'('+respuesta.endoso+')</h3></div><li class="liArchivos"><ul class="ulDocumentos">'+cadena+cadenaDocumentos+'</ul></li></ul></div>';
                	            document.getElementById('bodyTablaCobPen').rows[respuesta.rowIndex].cells[2].classList.add(bandRecibo1);
     	        document.getElementById('bodyTablaCobPen').rows[respuesta.rowIndex].cells[2].classList.add(bandRecibo2);           

                   }
                   else
                   {
                        cadena='<div class="divDocumentosSinRecibo"><ul class="ulDocumentos" id="ul'+respuesta.IDRecibo+'"><div class="iconocarpeta"><label></label><h3>'+respuesta.inner+'('+respuesta.endoso+')</h3></div><li class="liArchivos"><ul class="ulDocumentos">'+cadenaDocumentos+'</ul></li></ul></div>';
                   }
               }    
               
	 		document.getElementById('bodyTablaCobPen').rows[respuesta.rowIndex].cells[2].innerHTML=cadena;
           seleccionRow(document.getElementById('bodyTablaCobPen').rows[respuesta.rowIndex]);



    } 
    else 
    { 
      if(Req.status==500)
      {
        document.getElementById('gifDeEspera1').classList.remove('verObjetoGif');
        document.getElementById('gifDeEspera1').classList.add('ocultarObjeto');
       alert('El proceso presento un error favor de notificar a sistemas error 006');                                 
      }
      
    }
  };    
  Req.send(Data);
}


function enviarArchivoAJAXVigente(formulario,funcion){
  
   document.getElementById('gifDeEspera1').classList.remove('ocultarObjeto');
   document.getElementById('gifDeEspera1').classList.add('verObjetoGif');
  
    var Data = new FormData(document.getElementById(formulario));  
  if(window.XMLHttpRequest) { var Req = new XMLHttpRequest();}
  else if(window.ActiveXObject) {var Req = new ActiveXObject("Microsoft.XMLHTTP");}
  var direccion= <?php echo('"'.base_url().'cobranza/"');?>+funcion;
  Req.open("POST",direccion, true);  
  Req.onload = function(Event) {  
    if (Req.status == 200) 
    {
      var st = JSON.parse(Req.responseText);      
      document.getElementById('gifDeEspera1').classList.remove('verObjetoGif');
      document.getElementById('gifDeEspera1').classList.add('ocultarObjeto');

      if(st.success){}
      else{}
    } 
    else 
    { 
      if(Req.status==500)
      {
        document.getElementById('gifDeEspera1').classList.remove('verObjetoGif');
        document.getElementById('gifDeEspera1').classList.add('ocultarObjeto');
       alert('El proceso presento un error favor de notificar a sistemas error 006');                                 
      }
      
    }
  };      
  Req.send(Data);
}



function renovarPre(datos='')
{
 if(datos=='')
 {
 	let check=document.getElementsByName('cbSeleccionRenovaciones');
 	let cant=check.length;
 	let iddocto=[];
 	if(cant>0)
 	{
 		for(let i=0;i<cant;i++)
 		{
           if(check[i].checked){iddocto[i]=check[i].parentNode.parentNode.getAttribute('data-iddocto'); }
 		}
 		if(iddocto.length>0)
 		{
 			         var params = 'IDDocto='+iddocto;;              
             controlador="cobranza/renovarPre/?";
          peticionAJAX(controlador,params,'renovarPre');      

 		}

 	}
 	else
 	{
 		alert('Elegir renovacion')
 	}
 }
 else
 {

  traerRenovaciones('');
 }
}
function cambiarSolicitudCobro(datos='',idCobranzaSolicitudCobro,idDocto)
{
	if(datos=='')
	{
        var params = 'idCobranzaSolicitudCobro='+idCobranzaSolicitudCobro;    
        params=params+'&idDocto='+idDocto;
        controlador="cobranza/cambiarSolicitudCobro/?";	
        peticionAJAX(controlador,params,'cambiarSolicitudCobro');
	}
	else
	{
		alert(datos.mensaje);
	 if(datos.existeCobranzaConSolicitud==0)
	 {
        let cant=bodyTablaCobPen.rows.length;
        for(let i=0;i<cant;i++)
        {
        	if(bodyTablaCobPen.rows[i].dataset.iddocto==datos.idDocto)
        	{
        		let row=bodyTablaCobPen.rows[i];
        		bodyTablaCobPen.insertBefore(row,bodyTablaCobPen.rows[1]);
        		
        	}
        }
        cerrarModal('divComentariosSC');
	 }
	 else{
     let cantRows=tbodyComentarioSC.rows.length;     
     for(let i=0;i<cantRows;i++)
     {
      if(tbodyComentarioSC.rows[i].dataset.id==datos.idCobranzaSolicitudCobro && tbodyComentarioSC.rows[i].dataset.tabla=='cobranzasolicitudcobro')
      {
        tbodyComentarioSC.rows[i].cells[4].innerHTML='';
        i=cantRows;	
      }
     }
     }
	}
}
function cambiaContenidoCelda(objeto,tipo)
{
	if(tipo=='tel'){objeto.parentNode.parentNode.dataset.telefono=objeto.innerHTML;}
	else{objeto.parentNode.parentNode.dataset.email=objeto.innerHTML;}
	//alert(objeto.parentNode.parentNode.dataset.email);
}
function traerComentarioSolicitudCobro(datos='',idDocto='',documento='',idRecibo='',contenedor='')
{
	
  if(datos=='')
  {
   var params = 'idDocto='+idDocto;
    params=params+'&documento='+documento;
    params=params+'&idRecibo='+idRecibo;
    params=params+'&contenedor='+contenedor;
    controlador="cobranza/traerComentarioSolicitudCobro/?";	
   peticionAJAX(controlador,params,'traerComentarioSolicitudCobro')

  }
  else
  {
   
   cant=datos.comentarios.length;     
   let tabla='<table class="table" id="tableComentarioSC"><thead><thead><tr><th colspan="5">'+datos.documento+'</th></tr></thead><tr><th>TIPO SOLICITUD</th><th>COMENTARIO</th><th>USUARIO</th><th>FECHA</th><th></th></tr></thead>';
   tabla=tabla+'<tbody id="tbodyComentarioSC">';
   for(let i=0;i<cant;i++)
   {
   	tabla=tabla+'<tr data-id="'+datos.comentarios[i].id+'" data-tabla="'+datos.comentarios[i].tabla+'">';
   	tabla=tabla+'<td>'+datos.comentarios[i].SolicitudCobro+'</td>';
   	tabla=tabla+'<td>'+datos.comentarios[i].comentario+'</td>';
   	tabla=tabla+'<td>'+datos.comentarios[i].emailUser+'</td>';
   	tabla=tabla+'<td>'+datos.comentarios[i].fecha+'</td>';
   	if(datos.comentarios[i].estaResuelta==0){tabla=tabla+'<td><button class="btn-chico" onclick="cambiarSolicitudCobro(\'\','+datos.comentarios[i].id+','+datos.idDocto+')">&#10004</button></td>';}   		
   	else{tabla=tabla+'<td></td>';}
   	
   	tabla=tabla+'</tr>';
   }
   tabla=tabla+'</table>';
   if(datos.contenedor!=''){document.getElementById(datos.contenedor).innerHTML=tabla}
   else{divComentariosSCContenido.innerHTML=tabla;cerrarModal('divComentariosSC');}
 
  }
}
function traerRenovaciones(datos='')
{
	
 if(datos=='')
 {
   var params = 'fechaInicial='+document.getElementById('fechaInicialRenovacion').value;//JSON.stringify(arrayProperties)+'&bodyTabla='+bodyTabla;
    params = params+'&fechaFinal='+document.getElementById('fechaFinalRenovacion').value;
    controlador="cobranza/traerRenovaciones/?";	
   peticionAJAX(controlador,params,'traerRenovaciones')
 }
 else
 {
 	
   let cant=datos.renovaciones.TableInfo.length;
   let tbody="";   
   let ramo=[];
   let vendedor=[];
   let compania=[];
   let formaPago=[];
    let tr='<tr class="trRenovacion " data-value="-1" ><td class="divTD50"><button class="btn btn-primary btn-sm" onclick="mostrarHijosRenovacion(this)" data-renovacion="renovacion">+</button></td><td  colspan="11">Renovaciones</td></tr>';
     let trpre='<tr class="trRenovacion " data-value="-1"><td class="divTD50"><button class="btn btn-primary btn-sm" onclick="mostrarHijosRenovacion(this)" data-renovacion="renovacionpre">+</button></td><td  colspan="11">Renovar Igual</td></tr>';
   for(let i=0;i<cant;i++)
   {
     let name='renovacion';
          if(datos.renovaciones.TableInfo[i].renovacionpre=='1'){name='renovacionpre'}
     tbody="";
     tbody=tbody+'<tr onclick="seleccionRowRenovacion(this)" class="rowRenovacion trRenovacionOcultarHijo" name="'+name+'" data-documento="'+datos.renovaciones.TableInfo[i].Documento+'" data-nombre="'+datos.renovaciones.TableInfo[i].NombreCompleto+'" data-vendedor="'+datos.renovaciones.TableInfo[i].VendNombre+'" data-ramonombre="'+datos.renovaciones.TableInfo[i].RamosNombre+'" data-cagente="'+datos.renovaciones.TableInfo[i].CAgente+'" data-cianombre="'+datos.renovaciones.TableInfo[i].CiaNombre+'" data-VendNombre="'+datos.renovaciones.TableInfo[i].VendNombre+'" data-idvend="'+datos.renovaciones.TableInfo[i].IDVend+'" data-primaneta="'+datos.renovaciones.TableInfo[i].PrimaNeta+'" data-fhasta="'+datos.renovaciones.TableInfo[i].FHasta+'" data-iddocto="'+datos.renovaciones.TableInfo[i].IDDocto+'" data-idsramo="'+datos.renovaciones.TableInfo[i].IDSRamo+'" data-idcli="'+datos.renovaciones.TableInfo[i].IDCli+'" data-fpago="'+datos.renovaciones.TableInfo[i].FPago+'" data-esagentecolaborador="'+datos.renovaciones.TableInfo[i].esAgenteColaborador+'">';
     tbody=tbody+'<td class="divTD50"><input type="checkbox" name="cbSeleccionRenovaciones" class="cbSeleccionRenovaciones"></td>';
     
     tbody=tbody+'<td class="divTD150">'+datos.renovaciones.TableInfo[i].Documento+'</td>';
     tbody=tbody+'<td class="divTD150">'+datos.renovaciones.TableInfo[i].NombreCompleto+'</td>';
     tbody=tbody+'<td class="divTD150" data-value="'+datos.renovaciones.TableInfo[i].VendNombre+'">'+datos.renovaciones.TableInfo[i].VendNombre+'</td>';
     tbody=tbody+'<td class="divTD150" data-value="'+datos.renovaciones.TableInfo[i].RamosNombre+'">'+datos.renovaciones.TableInfo[i].RamosNombre+'</td>';
     tbody=tbody+'<td class="divTD150">'+datos.renovaciones.TableInfo[i].EMail1+'</td>';
     tbody=tbody+'<td class="divTD150">'+datos.renovaciones.TableInfo[i].Telefono1+'</td>';            
     tbody=tbody+'<td class="divTD150" data-value="'+datos.renovaciones.TableInfo[i].CiaNombre+'">'+datos.renovaciones.TableInfo[i].CiaNombre+'</td>';     
     tbody=tbody+'<td class="divTD150">'+datos.renovaciones.TableInfo[i].PrimaTotal+'</td>';     
     tbody=tbody+'<td class="divTD150" data-value="'+datos.renovaciones.TableInfo[i].FPago+'">'+datos.renovaciones.TableInfo[i].FPago+'</td>';
     tbody=tbody+'<td class="divTD150">'+datos.renovaciones.TableInfo[i].Status_TXT+'</td>';
     tbody=tbody+'<td class="divTD150">'+datos.renovaciones.TableInfo[i].FHasta+'</td>';
     tbody=tbody+'</tr>';
     ramo[datos.renovaciones.TableInfo[i].RamosNombre]="";
     vendedor[datos.renovaciones.TableInfo[i].VendNombre]="";
     compania[datos.renovaciones.TableInfo[i].CiaNombre]="";
     formaPago[datos.renovaciones.TableInfo[i].FPago]="";
     if(datos.renovaciones.TableInfo[i].renovacionpre=='0')
     {
     	tr=tr+tbody;
     }
     else
     {
     	trpre=trpre+tbody;
     }
   } 
   document.getElementById('bodyTablaRenovaciones').innerHTML=tr+trpre;

   let trVigentesCab='<tr style="background-color:#85ff00; color:black"><td colspan="11"><div class="divCabeceraVigentes">OT-Vigentes<form id="formDocumentoVigente" action="javascript: enviarArchivoAJAXVigente(\'formDocumentoVigente\',\'subirDocumentosVigente\')"><input type="file" multiple="true"  id="inputArchivosVigentes" onchange="if(!this.value.length)return false;document.getElementById(\'formDocumentoVigente\').submit();" name="imagenes[]"><input type="hidden" name="polizaVigente" id="polizaVigente"> </form><button class="btn btn-info" onclick="verDigitalVigente()">Digital</button><button class="btn btn-warning" onclick="ponerlaComoLista(\'\')">OT Lista</button><button class="btn btn-danger" onclick="ventanaCancelarRenovacion(\'\')">Cancelar OT</button></div></div><div></td></tr>';

   document.getElementById('bodyTablaVigentesCab').innerHTML=trVigentesCab;


     let cantVigente=datos.renovacionvigente.length;
     let trVigente="";
     for(let i=0;i<cantVigente;i++)
     {
              trVigente=trVigente+'<tr onclick="seleccionOtVigente(this)" data-iddocto="'+datos.renovacionvigente[i].IDDocto+'"><td>'+datos.renovacionvigente[i].Documento+'</td><td>'+datos.renovacionvigente[i].DAnterior+'</td></tr>';
     }


         document.getElementById('bodyTablaVigentes').innerHTML=trVigente;

           var keys=(Object.keys(ramo));
      let optionRamos="<option></option>";      
        for(var i=0;i<keys.length;i++){optionRamos=optionRamos+'<option>'+keys[i]+'</option>';}
       document.getElementById('selectFiltrarRamoRenovacion').innerHTML=optionRamos;
   let optionVendedor="<option></option>";
   keys=(Object.keys(vendedor));
        for(var i=0;i<keys.length;i++){optionVendedor=optionVendedor+'<option>'+keys[i]+'</option>';}
       document.getElementById('selectFiltrarVendedorRenovacion').innerHTML=optionVendedor;

   let optionCompania="<option></option>";
   keys=(Object.keys(compania));
        for(var i=0;i<keys.length;i++){optionCompania=optionCompania+'<option>'+keys[i]+'</option>';}
       document.getElementById('selectFiltrarCompaniaRenovacion').innerHTML=optionCompania;

      let optionFormaPago="<option></option>";
   keys=(Object.keys(formaPago));
        for(var i=0;i<keys.length;i++){optionFormaPago=optionFormaPago+'<option>'+keys[i]+'</option>';}
       document.getElementById('selectFiltrarFormaPagoRenovacion').innerHTML=optionFormaPago;

   let cantRP=datos.renovacionpendiente.length;
   let div='<table class="table"><tbody>';
   let totalRP=0;
   let totalRPHechas=0;
   let totalDiferencia=0;
   
   for(let i=0;i<cantRP;i++)
   {
    div=div+'<tr><td>'+datos.renovacionpendiente[i].EjecutNombre+'</td><td>'+datos.renovacionpendiente[i].cantidad+'</td><td>'+datos.renovacionpendiente[i].totalRenovadas+'</td><td>'+datos.renovacionpendiente[i].diferencia+'</td></tr>';
    totalRP=parseFloat(totalRP)+ parseFloat(datos.renovacionpendiente[i].cantidad);
   }
   div=div+'</tbody>';
   div=div+'<tfoot><tr><td>Totales:</td><td>'+totalRP+'</td><td>'+totalRPHechas+'</td><td>'+totalDiferencia+'</td></tr></tfoot>';
   div=div+'</table>';
   document.getElementById('infoRenovacionDiv').innerHTML=div;
 }
}

function peticionAJAX(controlador,parametros,funcion){

  var req = new XMLHttpRequest();var direccionAJAX="<?= base_url();?>";
  var url=direccionAJAX+controlador;//+parametros;
  //abreCierraEspera();
 req.open('POST', url, true);
  req.setRequestHeader("Content-type", "application/x-www-form-urlencoded");

document.getElementById('gifDeEspera1').classList.add('verObjetoGif');
document.getElementById('gifDeEspera1').classList.remove('ocultarObjeto');
   req.onreadystatechange = function (aEvt) 
  {
   
    if (req.readyState == 4) {
    	
      if(req.status == 200)
        {           
         var respuesta=JSON.parse(this.responseText); 
          document.getElementById('gifDeEspera1').classList.remove('verObjetoGif');
        document.getElementById('gifDeEspera1').classList.add('ocultarObjeto');           
         switch(funcion)
         {
           case 'traeArchivos':traeArchivos(respuesta);break;
           case 'enviarCorreos':enviarCorreos(respuesta);break;
           case 'guardarTarjeta':guardarTarjeta(respuesta);break;
           case 'mostrarTarjeta':mostrarTarjeta(respuesta);break;
           case 'mostrarHistorial':mostrarHistorial(respuesta);break;
           case 'traeDocumento' : traeDocumento('',respuesta);break;
           case 'cancelarTarjeta' : cancelarTarjeta(respuesta);break;
           case 'aplicarPago' : aplicarPago(respuesta);break;
           case 'agregarComentario' : agregarComentario(respuesta);break;
           case 'mostrarComentarios' : mostrarComentarios(respuesta);break;
           case 'enviarWhats' : enviarWhats(respuesta);break;
           case 'enviarSMS' : enviarSMS(respuesta,'','');break;
           case 'buscarPoliza' : buscarPoliza(respuesta);break;
           case 'buscarPorCliente': buscarPorCliente(respuesta);break;
           case 'traerRecibosPagados': traerRecibosPagados(respuesta);break;
           case 'cancelarReciboPagado': cancelarReciboPagado(respuesta);break;
           default:  window[funcion](respuesta);        break;            
         }     
                                 
      }     
      if(req.status==500)
      {
        document.getElementById('gifDeEspera1').classList.remove('verObjetoGif');
        document.getElementById('gifDeEspera1').classList.add('ocultarObjeto');
       alert('El proceso presento un error favor de notificar a sistemas error 006');                                 
      }
      
   }

  };
 req.send(parametros);
}

function addPreloader() {
  // if the preloader doesn't already exist, add one to the page
  let img='<img class="gifEspera" src="<?php echo(base_url().'assets/img/loading.gif')?>">';
   var preloaderHTML = img;
    document.querySelector('body').innerHTML += preloaderHTML;
       
}


let totalRowsCP=document.getElementById('bodyTablaCobPen').rows.length;
let tablaCP=document.getElementById('bodyTablaCobPen');
document.getElementById('spanTotalCob').innerHTML=totalRowsCP-2;
    document.getElementById('gifDeEspera1').classList.add('verObjetoGif');
document.getElementById('gifDeEspera1').classList.remove('ocultarObjeto');
//if(totalRowsCP==0){ traeCobranzaAtrasada();}
for(let i=0;i<totalRowsCP;i++)
{
  divTotalCobPenSinDocS=0;
  let idDocto=tablaCP.rows[i].getAttribute('data-iddocto');
  let serie=tablaCP.rows[i].getAttribute('data-serie');
  let recibo=tablaCP.rows[i].getAttribute('data-IDRecibo');
  let periodo=tablaCP.rows[i].getAttribute('data-periodo');
  let idcli=tablaCP.rows[i].getAttribute('data-idcli');
  let endoso=tablaCP.rows[i].getAttribute('data-endoso');
  let inner=tablaCP.rows[i].cells[1].dataset.value;
    var parametros = "IDDocto="+idDocto+"&rowIndex="+i+'&inner='+inner+'&serie='+serie+'&IDRecibo='+recibo+'&periodo='+periodo+'&idcli='+idcli+'&endoso='+endoso
    controlador="cobranza/traeArchivos/?";
  if(recibo!=null){
  var req = new XMLHttpRequest();var direccionAJAX="<?= base_url();?>";
  var url=direccionAJAX+controlador;
 req.open('POST', url, true); req.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
   req.onreadystatechange = function (aEvt) 
  { 

	 if(this.responseText!=''){	
	 	var respuesta=JSON.parse(this.responseText); 
	 	if(respuesta.text=="No cuenta con documentos")
	 	{  let dataHref='';	        
            document.getElementById('bodyTablaCobPen').rows[respuesta.rowIndex].cells[2].classList.add('divSinDocumento');
            document.getElementById('bodyTablaCobPen').rows[respuesta.rowIndex].cells[2].classList.add('divSDCP');	 
	 		document.getElementById('bodyTablaCobPen').rows[respuesta.rowIndex].cells[2].innerHTML='<ul class="divDocumentos" id="ul'+respuesta.IDRecibo+'"><li>Sin Documentos</li></ul>';
	 		  document.getElementById('bodyTablaCobPen').rows[respuesta.rowIndex].cells[2].setAttribute('data-value','sindocumentos');
	 		  document.getElementById('bodyTablaCobPen').rows[respuesta.rowIndex].setAttribute('title','SIN DOCUMENTOS');
	 	    document.getElementById('bodyTablaCobPen').rows[respuesta.rowIndex].setAttribute('data-href',dataHref);
	 	    document.getElementById('bodyTablaCobPen').rows[respuesta.rowIndex].setAttribute('data-class','divSDCP');
	 	}
	 	else{                 
              let cantidad=respuesta.children.length
               let cadena="";
               let cadenaDocumentos="";
               let cadenaPrincipio="";
               let bandRecibo1="divConDocumento";
               let bandRecibo2="divCDCP";
               let dataHref='';
               let dataHrefComprobante='';
               let hrefRecibo="";
               let idRecibo_periodo=respuesta.text+'_'+respuesta.periodo;
               let banderaCierre=0;
               let banderaFolderRecibo=0;               
              for(let t=0;t<cantidad;t++)
              { 
              	let bandEntrada=0;              	
              	if(respuesta.children[t].isFolder!=1)              	
              	{
                 if(respuesta.endoso!='')
                 {  
                 	let textEndoso=respuesta.endoso+'_'+respuesta.periodo;
                 	let textEndosoComprobante=respuesta.endoso+'_'+respuesta.periodo+'Comprobante';                 	
                 	if(respuesta.children[t].text==textEndoso || respuesta.children[t].text==textEndosoComprobante){bandEntrada=1;}
                     if(respuesta.children[t].text==textEndoso){dataHref=respuesta.children[t].href;}
                 	if(respuesta.children[t].text==textEndosoComprobante){dataHrefComprobante=respuesta.children[t].href;}
                 }
                 else
                 {
                    let textEndoso=respuesta.inner+'_'+respuesta.periodo;
                 	let textEndosoComprobante=respuesta.inner+'_'+respuesta.periodo+'Comprobante';                 	
                 	if(respuesta.children[t].text==textEndoso || respuesta.children[t].text==textEndosoComprobante){bandEntrada=1;}
                 	if(respuesta.children[t].text==textEndoso){dataHref=respuesta.children[t].href;}
                 	if(respuesta.children[t].text==textEndosoComprobante){dataHrefComprobante=respuesta.children[t].href;}
                 }

                   let clase="";
                   clase=devolverTipoArchivo(respuesta.children[t].href);
                  if(bandEntrada){                  	
                  cadena+=`<li class="liArchivos liReciboComprobante"><div class="${clase} iconogenerico"><a href="${respuesta.children[t].href}" target="_blank">${respuesta.children[t].text}</a></div></li>`; }
                  else{
                  	    if(respuesta.children[t].href.indexOf(respuesta.IDRecibo)!=-1)
                  	    {
                          cadenaDocumentos+=`<li class="liArchivos"><div class="${clase} iconogenerico"><a href="${respuesta.children[t].href}" target="_blank">${respuesta.children[t].text}</a></div></li>`;
              	}
                     }                  	
                   
                 }
              	}
                  
            if(respuesta.historialCobranza!="0"){document.getElementById('bodyTablaCobPen').rows[respuesta.rowIndex].cells[3].innerHTML='<div class="iconoemail">  </div>';}
               if(cadena!="" || cadenaDocumentos!="")
               {      
               if(cadena!="")
                    {
                    	  bandRecibo1="divConDocRecibo";
                    	bandRecibo2="divCDRCP";
                	cadena='<div class="divDocumentos"><ul class="ulDocumentos" id="ul'+respuesta.IDRecibo+'"><div class="iconocarpeta"><label></label><h3>'+respuesta.inner+'('+respuesta.endoso+')</h3></div><li class="liArchivos"><ul class="ulDocumentos">'+cadena+cadenaDocumentos+'</ul></li></ul></div>';
                   }
                   else
                   {
                        cadena='<div class="divDocumentosSinRecibo"><ul class="ulDocumentos" id="ul'+respuesta.IDRecibo+'"><div class="iconocarpeta"><label></label><h3>'+respuesta.inner+'('+respuesta.endoso+')</h3></div><li class="liArchivos"><ul class="ulDocumentos">'+cadenaDocumentos+'</ul></li></ul></div>';
                   }
               }    
            document.getElementById('bodyTablaCobPen').rows[respuesta.rowIndex].cells[2].classList.add(bandRecibo1);
	        document.getElementById('bodyTablaCobPen').rows[respuesta.rowIndex].cells[2].classList.add(bandRecibo2);           
	 		document.getElementById('bodyTablaCobPen').rows[respuesta.rowIndex].cells[2].innerHTML=cadena;
	 		document.getElementById('bodyTablaCobPen').rows[respuesta.rowIndex].setAttribute('data-href',dataHref);
             
             let titulo="SIN DOCUMENTOS";let dataValue="sindocumentos";              
	 		
	 		if(dataHrefComprobante!='' && dataHref==''){titulo="CON COMPROBANTE";dataValue="comprobante";document.getElementById('bodyTablaCobPen').rows[respuesta.rowIndex].cells[2].classList.add('divConDocComprobante');}
	 		if(dataHrefComprobante=='' && dataHref!=''){titulo="CON RECIBO";dataValue="recibo";}
	 		if(dataHref!='' && dataHrefComprobante!=''){titulo="CON RECIBO Y COMPROBANTE";dataValue="recibocomprobante";document.getElementById('bodyTablaCobPen').rows[respuesta.rowIndex].cells[2].classList.add('divConDocReciboComprobante');}

	 		  document.getElementById('bodyTablaCobPen').rows[respuesta.rowIndex].cells[2].setAttribute('data-value',dataValue);
	 		  document.getElementById('bodyTablaCobPen').rows[respuesta.rowIndex].setAttribute('title',titulo);
	 		document.getElementById('bodyTablaCobPen').rows[respuesta.rowIndex].setAttribute('data-hrefcomprobante',dataHrefComprobante);
	 		document.getElementById('bodyTablaCobPen').rows[respuesta.rowIndex].setAttribute('data-class',bandRecibo1);
	 		
	 	}
	 	document.getElementById('bodyTablaCobPen').rows[respuesta.rowIndex].setAttribute('data-preferenciacomunicacion',respuesta.preferenciaComunicacion);
	 		document.getElementById('bodyTablaCobPen').rows[respuesta.rowIndex].cells[17].innerHTML=respuesta.preferenciaComunicacion;
	 			 		document.getElementById('bodyTablaCobPen').rows[respuesta.rowIndex].setAttribute('data-horariocomunicacion',respuesta.preferenciaComunicacion);
	 		document.getElementById('bodyTablaCobPen').rows[respuesta.rowIndex].cells[18].innerHTML=respuesta.horarioComunicacion;	 		
	 		document.getElementById('bodyTablaCobPen').rows[respuesta.rowIndex].setAttribute('data-diacomunicacion',respuesta.diaComunicacion);
	 		document.getElementById('bodyTablaCobPen').rows[respuesta.rowIndex].cells[19].innerHTML=respuesta.diaComunicacion;
	 	if(req.readyState == 4) {
      if(req.status == 200) {
      		total=document.getElementsByClassName('divSDCP').length+document.getElementsByClassName('divCDCP').length;
                document.getElementById('divTotalCobPenSinDoc').innerHTML='Sin documento='+total;       
        document.getElementById('divTotalCobranzaConDocRec').innerHTML='Con Recibo='+document.getElementsByClassName('divCDRCP').length;
      }
    }

  }
  };
 
 req.send(parametros);
 }
}
function traerCobranzaPolizaAgregada()
{
  //let totalRowsCP=document.getElementById('bodyTablaCobPen').rows[0];
let tablaCP=document.getElementById('bodyTablaCobPen').rows[1];
    document.getElementById('gifDeEspera1').classList.add('verObjetoGif');
document.getElementById('gifDeEspera1').classList.remove('ocultarObjeto');
  divTotalCobPenSinDocS=0;
  let idDocto=tablaCP.getAttribute('data-iddocto');
  let serie=tablaCP.getAttribute('data-serie');
  let recibo=tablaCP.getAttribute('data-IDRecibo');
  let periodo=tablaCP.getAttribute('data-periodo');
  let idcli=tablaCP.getAttribute('data-idcli');
  let endoso=tablaCP.getAttribute('data-endoso');
  let inner=tablaCP.cells[1].innerHTML;
  let i=1;
    var parametros = "IDDocto="+idDocto+"&rowIndex="+i+'&inner='+inner+'&serie='+serie+'&IDRecibo='+recibo+'&periodo='+periodo+'&idcli='+idcli+'&endoso='+endoso
    controlador="cobranza/traeArchivos/?";
  var req = new XMLHttpRequest();var direccionAJAX="<?= base_url();?>";
  var url=direccionAJAX+controlador;
 req.open('POST', url, true); req.setRequestHeader("Content-type", "application/x-www-form-urlencoded");

   req.onreadystatechange = function (aEvt) 
  { 
    	 	if(req.readyState == 4) {
      if(req.status == 200) {
       var respuesta=JSON.parse(this.responseText); 
       	 	if(respuesta.text=="No cuenta con documentos")
	 	{  let dataHref='';	        
            document.getElementById('bodyTablaCobPen').rows[1].cells[2].classList.add('divSinDocumento');
            document.getElementById('bodyTablaCobPen').rows[1].cells[2].classList.add('divSDCP');	 
	 		document.getElementById('bodyTablaCobPen').rows[1].cells[2].innerHTML='<ul class="divDocumentos" id="ul'+respuesta.IDRecibo+'"><li>Sin Documentos</li></ul>';
	 	    document.getElementById('bodyTablaCobPen').rows[1].setAttribute('data-href',dataHref);
	 	    document.getElementById('bodyTablaCobPen').rows[1].setAttribute('data-class','divSDCP');
	 	}
	 	else
	 	{
             let cantidad=respuesta.children.length
               let cadena="";
               let cadenaDocumentos="";
               let cadenaPrincipio="";
               let bandRecibo1="divConDocumento";
               let bandRecibo2="divCDCP";
               let dataHref='';
               let dataHrefComprobante='';
               let hrefRecibo="";
               let idRecibo_periodo=respuesta.text+'_'+respuesta.periodo;
               let banderaCierre=0;
               let banderaFolderRecibo=0;            
              for(let i=0;i<cantidad;i++)
              { 
              	let bandEntrada=0;              	
              	if(respuesta.children[i].isFolder!=1)
              	{
                 if(respuesta.endoso!='')
                 {  
                 	let textEndoso=respuesta.inner+'_'+respuesta.endoso+'_'+respuesta.periodo;
                 	let textEndosoComprobante=respuesta.inner+'_'+respuesta.endoso+'_'+respuesta.periodo+'Comprobante';
                 	
                 	if(respuesta.children[i].text==textEndoso || respuesta.children[i].text==textEndosoComprobante)
                 	{bandEntrada=1;}
                     if(respuesta.children[i].text==textEndoso){dataHref=respuesta.children[i].href;}
                 	if(respuesta.children[i].text==textEndosoComprobante){dataHrefComprobante=respuesta.children[i].href;}
                 }
                 else
                 {
                    let textEndoso=respuesta.inner+'_'+respuesta.periodo;
                 	let textEndosoComprobante=respuesta.inner+'_'+respuesta.periodo+'Comprobante';                 	
                 	if(respuesta.children[i].text==textEndoso || respuesta.children[i].text==textEndosoComprobante){bandEntrada=1;}
                 	if(respuesta.children[i].text==textEndoso){dataHref=respuesta.children[i].href;}
                 	if(respuesta.children[i].text==textEndosoComprobante){dataHrefComprobante=respuesta.children[i].href;}
                 }
                   let clase="";                   
                  clase=devolverTipoArchivo(respuesta.children[i].href);
                  if(bandEntrada){                  	
                  cadena+=`<li class="liArchivos liReciboComprobante"><div class="${clase} iconogenerico"><a href="${respuesta.children[i].href}" target="_blank">${respuesta.children[i].text}</a></div></li>`; }
                  else{
                  	if(respuesta.children[i].href.indexOf(respuesta.IDRecibo)!=-1){
                  cadenaDocumentos+=`<li class="liArchivos"><div class="${clase} iconogenerico"><a href="${respuesta.children[i].href}" target="_blank">${respuesta.children[i].text}</a></div></li>`;}
                    }                 
              	}


              }   //for          


                   
            if(respuesta.historialCobranza!="0"){document.getElementById('bodyTablaCobPen').rows[1].cells[3].innerHTML='<div class="iconoemail">  </div>';}
               if(cadena!="" || cadenaDocumentos!="")
               {      
                    if(cadena!="")
                    {
                    	  bandRecibo1="divConDocRecibo";
                    	bandRecibo2="divCDRCP";
                	cadena='<div class="divDocumentos"><ul class="ulDocumentos" id="ul'+respuesta.IDRecibo+'"><div class="iconocarpeta"><label></label><h3>'+respuesta.inner+'('+respuesta.endoso+')</h3></div><li class="liArchivos"><ul class="ulDocumentos">'+cadena+cadenaDocumentos+'</ul></li></ul></div>';
                   }
                   else
                   {
                        cadena='<div class="divDocumentosSinRecibo"><ul class="ulDocumentos" id="ul'+respuesta.IDRecibo+'"><div class="iconocarpeta"><label></label><h3>'+respuesta.inner+'('+respuesta.endoso+')</h3></div><li class="liArchivos"><ul class="ulDocumentos">'+cadenaDocumentos+'</ul></li></ul></div>';
                   }
               }
                     /*cadenaPrincipio=cadenaPrincipio+'<div class="divDocumentos"><ul class="ulDocumentos" id="ul'+respuesta.IDRecibo+'"><div class="iconocarpeta"><label><h3>'+respuesta.inner+'</h3></label></div>';   
               if(cadena!="")
               {                  	bandRecibo1="divConDocRecibo";
                    	bandRecibo2="divCDRCP";
               	cadena='<div class="divDocumentos"><ul class="ulDocumentos" id="ul'+respuesta.IDRecibo+'"><div class="iconocarpeta"><label></label><h3>'+respuesta.inner+'('+respuesta.endoso+')</h3></div><li class="liArchivos"><ul class="ulDocumentos">'+cadena+'</ul></li></ul></div>';
               }  */  
    	  
             let titulo="SIN DOCUMENTOS";let dataValue="sindocumentos";              
	 		
	 		if(dataHrefComprobante!='' && dataHref==''){titulo="CON COMPROBANTE";dataValue="comprobante";document.getElementById('bodyTablaCobPen').rows[respuesta.rowIndex].cells[2].classList.add('divConDocComprobante');}
	 		if(dataHrefComprobante=='' && dataHref!=''){titulo="CON RECIBO";dataValue="recibo";}
	 		if(dataHref!='' && dataHrefComprobante!=''){titulo="CON RECIBO Y COMPROBANTE";dataValue="recibocomprobante";document.getElementById('bodyTablaCobPen').rows[respuesta.rowIndex].cells[2].classList.add('divConDocReciboComprobante');}

	 		  document.getElementById('bodyTablaCobPen').rows[respuesta.rowIndex].cells[2].setAttribute('data-value',dataValue);
	 		  document.getElementById('bodyTablaCobPen').rows[respuesta.rowIndex].setAttribute('title',titulo);
    	    document.getElementById('bodyTablaCobPen').rows[1].cells[2].classList.add(bandRecibo1);
	        document.getElementById('bodyTablaCobPen').rows[1].cells[2].classList.add(bandRecibo2);           
	 		document.getElementById('bodyTablaCobPen').rows[1].cells[2].innerHTML=cadena;
	 		document.getElementById('bodyTablaCobPen').rows[1].setAttribute('data-href',dataHref);
	 		document.getElementById('bodyTablaCobPen').rows[1].setAttribute('data-hrefcomprobante',dataHrefComprobante);
	 		document.getElementById('bodyTablaCobPen').rows[1].setAttribute('data-class',bandRecibo1);

	 	}
	 	document.getElementById('bodyTablaCobPen').rows[1].setAttribute('data-preferenciacomunicacion',respuesta.preferenciaComunicacion);
	 		document.getElementById('bodyTablaCobPen').rows[1].cells[17].innerHTML=respuesta.preferenciaComunicacion;
	 	    document.getElementById('bodyTablaCobPen').rows[1].setAttribute('data-horariocomunicacion',respuesta.preferenciaComunicacion);
	 		document.getElementById('bodyTablaCobPen').rows[1].cells[18].innerHTML=respuesta.horarioComunicacion;	 		
	 		document.getElementById('bodyTablaCobPen').rows[1].setAttribute('data-diacomunicacion',respuesta.diaComunicacion);
	 		document.getElementById('bodyTablaCobPen').rows[1].cells[19].innerHTML=respuesta.diaComunicacion;
            document.getElementById('gifDeEspera1').classList.remove('verObjetoGif');
        document.getElementById('gifDeEspera1').classList.add('ocultarObjeto');
       seleccionRow(document.getElementById('bodyTablaCobPen').rows[1]);
      }
    }
  }

  req.send(parametros);	 
}

function traeCobranzaAtrasada(){

}


 function cerrar(){document.getElementById("miModal").classList.add("modalCierra");document.getElementById("miModal").classList.remove("modalAbre");document.getElementById("Modalcontenido").style.display="none";
 }
 function abrir(){
document.getElementById("miModal").classList.remove("modalCierra");document.getElementById("miModal").classList.add("modalAbre");document.getElementById("Modalcontenido").style.display="block";
 }
 cerrar();


function enviarArchivoAJAX(formulario,funcion){ 

if(document.getElementsByClassName('rowSeleccionado').length>0) 
{
	/*if(funcion=='subirRecibo')
	{
      if(document.getElementsByClassName('rowSeleccionado')[0].parentNode.id!='bodyTablaCobPen'){alert('Escoger recibo');return 0;}     
	}*/
	document.getElementById('inputIdDocto').value=document.getElementsByClassName('rowSeleccionado')[0].getAttribute('data-iddocto');
    document.getElementById('inputSerie').value=document.getElementsByClassName('rowSeleccionado')[0].getAttribute('data-serie');
	document.getElementById('inputRecibo').value=document.getElementsByClassName('rowSeleccionado')[0].getAttribute('data-idrecibo');
	document.getElementById('inputDocumento').value=document.getElementsByClassName('rowSeleccionado')[0].getAttribute('data-documento');
	document.getElementById('inputPeriodo').value=document.getElementsByClassName('rowSeleccionado')[0].getAttribute('data-periodo');
	document.getElementById('inputBody').value=document.getElementsByClassName('rowSeleccionado')[0].parentNode.id;
	document.getElementById('inputEndoso').value=document.getElementsByClassName('rowSeleccionado')[0].getAttribute('data-endoso');
	document.getElementById('inputIdEndoso').value=document.getElementsByClassName('rowSeleccionado')[0].getAttribute('data-idendoso');
	document.getElementById('inputIdEnviarCorreo').value=document.getElementsByClassName('rowSeleccionado')[0].getAttribute('data-enviarcorreo');
	if(funcion=='subirComprobante')
	{
		     
	document.getElementById('inputIdDoctoComp').value=document.getElementsByClassName('rowSeleccionado')[0].getAttribute('data-iddocto');
    document.getElementById('inputSerieComp').value=document.getElementsByClassName('rowSeleccionado')[0].getAttribute('data-serie');
	document.getElementById('inputReciboComp').value=document.getElementsByClassName('rowSeleccionado')[0].getAttribute('data-idrecibo');
	document.getElementById('inputDocumentoComp').value=document.getElementsByClassName('rowSeleccionado')[0].getAttribute('data-documento');
	document.getElementById('inputPeriodoComp').value=document.getElementsByClassName('rowSeleccionado')[0].getAttribute('data-periodo');
	document.getElementById('inputEndosoComp').value=document.getElementsByClassName('rowSeleccionado')[0].getAttribute('data-endoso');
    document.getElementById('inputIdEndosoComp').value=document.getElementsByClassName('rowSeleccionado')[0].getAttribute('data-idendoso');
	document.getElementById('inputBodyComp').value=document.getElementsByClassName('rowSeleccionado')[0].parentNode.id;
	document.getElementById('inputIdEnviarCorreoComp').value=document.getElementsByClassName('rowSeleccionado')[0].getAttribute('data-enviarcorreo');

	}
    var Data = new FormData(document.getElementById(formulario));  
    if(window.XMLHttpRequest) { var Req = new XMLHttpRequest();}
    else if(window.ActiveXObject) {var Req = new ActiveXObject("Microsoft.XMLHTTP");}  
    var direccion= <?php echo('"'.base_url().'cobranza/"');?>+funcion;
    Req.open("POST",direccion, true); 
    document.getElementById('gifDeEspera1').classList.add('verObjetoGif');
    document.getElementById('gifDeEspera1').classList.remove('ocultarObjeto');
    Req.onload = function(Event) {  	
    var respuesta = JSON.parse(Req.responseText);   
    if (Req.status == 200 && Req.readyState == 4) 
    {     
         let cantidad=respuesta.children.length
         let cadena="";
               let cadenaPrincipio="";
               let bandRecibo1="divConDocumento";
               let bandRecibo2="divCDCA";
               let dataHref='';
               let dataHrefComprobante='';
               let hrefRecibo="";
               let idRecibo_periodo=respuesta.text+'_'+respuesta.periodo;
               let banderaCierre=0;
               let banderaFolderRecibo=0;
                
              for(let i=0;i<cantidad;i++)
              {

              let bandEntrada=0;
              	let esCarpetaDeRecibo=false;
              	if(respuesta.children[i].href){if(respuesta.children[i].href.indexOf(respuesta.serie)!=-1){esCarpetaDeRecibo=true;}}
              	if(respuesta.children[i].isFolder!=1 && esCarpetaDeRecibo==true)              	
              	{
              		
                 if(respuesta.endoso!='')
                 {  
                 	let textEndoso=respuesta.inner+'_'+respuesta.endoso+'_'+respuesta.periodo;
                 	let textEndosoComprobante=respuesta.inner+'_'+respuesta.endoso+'_'+respuesta.periodo+'Comprobante';
                 	
                 	if(respuesta.children[i].text==textEndoso || respuesta.children[i].text==textEndosoComprobante)
                 	{bandEntrada=1;}
                     if(respuesta.children[i].text==textEndoso){dataHref=respuesta.children[i].href;}
                 	if(respuesta.children[i].text==textEndosoComprobante){dataHrefComprobante=respuesta.children[i].href;}
                 }
                 else
                 {
                    let textEndoso=respuesta.inner+'_'+respuesta.periodo;
                 	let textEndosoComprobante=respuesta.inner+'_'+respuesta.periodo+'Comprobante';                 	
                 	if(respuesta.children[i].text==textEndoso || respuesta.children[i].text==textEndosoComprobante){bandEntrada=1;}
                 	                 	if(respuesta.children[i].text==textEndoso){dataHref=respuesta.children[i].href;}
                 	if(respuesta.children[i].text==textEndosoComprobante){dataHrefComprobante=respuesta.children[i].href;}
                 }
                 if(bandEntrada)
                 { let clase="";
                 	                 	let extension=respuesta.children[i].href.split('.').pop();                 	
                 	extension=extension.toUpperCase();                 	
                 	switch(extension)
                 	{
                 		case 'PDF':clase='iconopdf';break;
                 		case 'MSG':clase='iconomsg';break;
                 		case 'JPG':clase='iconojpg';break;
                 		case 'JPEG':clase='iconojpg';break;
                 		case 'WORD':clase='iconoword';break;
                 		case 'XLS':clase='iconoxls';break;
                 		case 'XLSX':clase='iconoxls';break;
                 		case 'XML':clase='iconoxml';break;
                 		case 'DOCX':clase='iconoword';break;
                 		case 'PNG':clase='iconopdf';break;
                        default: clase='iconoblanco';break;
                 	}
                  cadena=cadena+'<li class="liArchivos"><div class="'+clase+' iconogenerico"><a href="'+respuesta.children[i].href+'" target="_blank" >'+respuesta.children[i].text+'</a></div></li>'; 
                 }
              	}

              }             

             let rowsTabla=document.getElementById(respuesta.bodyTable).rows.length;
                               
             for(let i=0;i<rowsTabla;i++){
                               
             	if(document.getElementById(respuesta.bodyTable).rows[i].getAttribute('data-idrecibo')==respuesta.IDRecibo)
             	{


                   if(cadena!="")
                   {       
               	    bandRecibo1="divConDocRecibo";
                    bandRecibo2="divCDRCA";  
               	    cadena='<div class="divDocumentos"><ul class="ulDocumentos" id="ul'+respuesta.IDRecibo+'"><div class="iconocarpeta"><label></label><h3>'+respuesta.inner+'('+respuesta.endoso+')</h3></div><li class="liArchivos"><ul class="ulDocumentos">'+cadena+'</ul></li></ul></div>';
                   }    

              
             	  document.getElementById(respuesta.bodyTable).rows[i].cells[2].classList.add(bandRecibo1);
	              document.getElementById(respuesta.bodyTable).rows[i].cells[2].classList.add(bandRecibo2);  
               //   cadenaPrincipio='<div class="divDocumentos"><br><ul class="ulDocumentos" id="ul'+respuesta.IDRecibo+'"><div class="iconocarpeta"><label><h3>'+respuesta.documento+'</h3></label></div>';
                 // document.getElementById(respuesta.bodyTable).rows[i].cells[2].innerHTML=cadenaPrincipio+cadena;	 	
                  document.getElementById(respuesta.bodyTable).rows[i].cells[2].innerHTML=cadena;
	 		      document.getElementById(respuesta.bodyTable).rows[i].cells[2].innerHTML=cadenaPrincipio+cadena;	
	 		      document.getElementById(respuesta.bodyTable).rows[i].setAttribute('data-href',dataHref);
	 		      document.getElementById(respuesta.bodyTable).rows[i].setAttribute('data-hrefcomprobante',dataHrefComprobante);
	 		      seleccionRow(document.getElementById(respuesta.bodyTable).rows[i]);
             	}

             }
                       document.getElementById('gifDeEspera1').classList.remove('verObjetoGif');
             document.getElementById('gifDeEspera1').classList.add('ocultarObjeto');
    } 

  };   
  Req.send(Data);
}
else{alert('Seleccione un recibo para el envio de recibo');}
}

function maxminContMenuFlotante(){
	document.getElementById("divMenuFlotante").classList.toggle('contMenuFlotante');
		document.getElementById("divMenuFlotante").classList.toggle('contMenuFlotanteMinimizado');
}
</script>
<script type="text/javascript">

$(function () {$(".fecha").datepicker({
  closeText: 'Cerrar',prevText: 'Anterior',nextText: 'Siguiente',currentText: 'Hoy',
  monthNames: ['Enero','Febrero','Marzo','Abril','Mayo','Junio','Julio','Agosto','Septiembre','Octubre','Noviembre','Diciembre'],
  dayNames:['Domingo','Lunes','Martes','Mi&eacute;rcoles','Jueves','Viernes','S&aacute;bado'] ,
  dayNamesShort:['Dom','Lun','Mar','Mi&eacute;','Juv','Vie','S&aacute;b'],
  dayNamesMin: ['Do','Lu','Ma','Mi','Ju','Vi','S&aacute;'],
  dateFormat: 'dd/mm/yy',
  firstDay: 1,       
}).datepicker("setDate", new Date());
});

$(function () {$(".fechaBusqueda").datepicker({
  closeText: 'Cerrar',prevText: 'Anterior',nextText: 'Siguiente',currentText: 'Hoy',
  monthNames: ['Enero','Febrero','Marzo','Abril','Mayo','Junio','Julio','Agosto','Septiembre','Octubre','Noviembre','Diciembre'],
  dayNames:['Domingo','Lunes','Martes','Mi&eacute;rcoles','Jueves','Viernes','S&aacute;bado'] ,
  dayNamesShort:['Dom','Lun','Mar','Mi&eacute;','Juv','Vie','S&aacute;b'],
  dayNamesMin: ['Do','Lu','Ma','Mi','Ju','Vi','S&aacute;'],
  dateFormat: 'dd/mm/yy',
      
}).datepicker();
});




function exportarExcel(){	
   var downloadLink;
    var dataType = 'application/vnd.ms-excel';
    let tablaCobranza=document.getElementById('tableCobranzaPendiente');
    var tableSelect = document.getElementById('tablaExportar');
    tableSelect.innerHTML=cabeceraTabla+tablaCobranza.innerHTML;
   let cant=tableSelect.rows.length;
   for(let i=0;i<cant;i++){if(tableSelect.rows[i].dataset.value===undefined){tableSelect.rows[i].cells[0].innerHTML='';tableSelect.rows[i].cells[2].innerHTML='';tableSelect.rows[i].cells[0].setAttribute('align','right');}}
  let tableHTML='';  
  
if(navigator.userAgent.indexOf('Chrome')>-1 || navigator.userAgent.indexOf('Safari')>-1 || navigator.userAgent.indexOf('OPR')>-1 || navigator.userAgent.indexOf('Firefox')>-1){
	if(navigator.userAgent.indexOf('Edge')>-1){
     tableHTML = '<table id="miTabla">'+tableSelect.innerHTML+'</table>';    	
	}
	else{tableHTML = tableSelect.outerHTML.replace(/ /g, '%20');}
}
else{tableHTML = '<table id="miTabla" border="2">'+tableSelect.innerHTML+'</table>';}

    // Specify file name
    let filename="cobranza";
    filename = filename?filename+'.xls':'excel_data.xls';
    
    // Create download link element
    downloadLink = document.createElement("a");
    
    document.body.appendChild(downloadLink);
    
    if(navigator.msSaveOrOpenBlob)
    {
        var blob = new Blob(['', tableHTML], {type: dataType});
        navigator.msSaveOrOpenBlob( blob, filename);
    }else{        
        downloadLink.href = 'data:' + dataType + ', ' + tableHTML;    
        downloadLink.download = filename;        
        downloadLink.click();
    }
}

	  

</script>
<style type="text/css">
.renovaDoc{display: flex;flex-wrap: wrap;flex-direction: column;}
.renovDocComentario{display: flex;}
.renovDocComentario button{border: solid;background-color: blue;color: white;font-size: 1rem;border-radius: 50px;}
.renovDocComentario button:hover{background-color: #c0c0e6;color: black;}
.renovDocComentario label{border: solid;background-color: green;color: white;font-size: 2rem;}
.botonDeshabilitado{background-color: #c1bdbd;}
.contColumna{background-color: #a3a2a5; color:black;}
.gifEspera{position: absolute;left: 0%;top:0%;z-index: 10000000;width: 100%;height: 100%;background: none repeat scroll 0 0 #FFFFFF;border: 1px solid #DDDDDD;border-radius: 6px 6px 6px 6px;bottom: 200px;right: 10px;margin-left: 0px;padding: 0px 0 0;position: fixed;text-align: center;z-index: 10000;padding: 0px; margin: 0px; background-color: #FFFFFF; opacity: .5}	
.verObjetoGif{display: block;}
.ocultarCelda{display: none;}
.ocultarObjeto{display: none;}
.ocultarObjetoSubRamo{display: none;}
.ocultarObjetoVendedor{display: none;}
.ocultarObjetoCliente{display: none;}
.ocultarObjetoFecLim{display: none;}
.ocultarObjetoEndoso{display: none;} 
.ocultarObjetoRamosNombre{display: none;}
.ocultarObjetoCCobro_TXT{display: none;}
.ocultarObjetoCiaNombre{display: none;}
.ocultarObjetoSerie{display: none;}
.ocultarRowRenVend{display: none;}
.ocultarRowRenRamo{display: none;}
.ocultarRowRenCompania{display: none;}
.ocultarRowRenFormaPago{display: none;}
.divTD25{width:15px;max-width: 15px;min-width: 15px}
.divTD25{width:25px;max-width: 25px;min-width: 25px}
.divTD50{width:50px;max-width: 50px;min-width: 50px}
.divTD75{width:75px;max-width: 75px;min-width: 75px}
.divTD100{width:100px;max-width: 100px;min-width: 100px}
.divTD125{width:125px;max-width: 125px;min-width: 125px}
.divTD150{width:150px;max-width: 150px;min-width: 150px}
.divTD200{width:200px;max-width: 200px;min-width: 200px}
.divTD300{width:300px;max-width: 300px;min-width: 300px}
.divTD400{width:400px;max-width: 400px;min-width: 400px}
.divTD500{width:500px;max-width: 500px;min-width: 500px}
.rowSeleccionado{background-color:  #ffc107; color:white;border: black groove 6px;}
.seleccionRenovacion{background-color:  green; color:white;}
.seleccionOtVigente{background-color:  #80cc80; color:white;}
.divPrincipal{width: 100%; display: flex; }
.divMenu{min-width: 60px; width: 80px ; height: auto;border: none; border-right: solid;border-bottom: solid;}
.divContenido{width: 90%  }
.buttonMenu{color: green;}
.buttonMenu>label{width: 50px;font-size: .8em;}
.buttonMenu>label:hover{  cursor: pointer; }
.ulMenu{list-style-type: none}
.ulMenu > li{position: relative; left:-30px;border: solid;min-width:50px;font-size: 14px}
.ulMenu li:hover {color: red; cursor: pointer }
.rowTabla:hover{ cursor: pointer; background-color: #cef3ce }
.divDocumentos{display: none;}
.divDocumentosSinRecibo{display: none;}
.divSinDocumento{width: 25px; height:25px;background: url(<?echo(base_url().'assets/images/iconoblanco.png') ;?>) no-repeat;}
.divConDocumento{width: 25px; height:25px;background: url(<?echo(base_url().'assets/images/iconoblanco.png') ;?>) no-repeat;}
.divConDocRecibo{  background: url(<?echo(base_url().'assets/images/reciboIcono.png') ;?>) ;background-repeat: no-repeat;background-size: 50% 100%;}
.divConDocComprobante{background: url(<?echo(base_url().'assets/images/comporbantePagoIcono.png') ;?>) no-repeat;background-size: 50% 100%;position: relative;left: 1%}
.divConDocReciboComprobante{background: url(<?echo(base_url().'assets/images/recibocomprobanteIcono.png') ;?>) no-repeat;background-size: 100% 100%;}

.divConDocumento:hover{cursor: alias; width: 50px; height: 30px; background-color: blue}
.divSinDocumento:hover{cursor: not-allowed; width: 50px; height: 30px; background-color: red}
.modal-contenido{background-color:white;width:800px;height:100%;padding: 0% 0%;margin: 0% auto;position: relative; }
.modalCierra{background-color: rgba(0,0,0,.8);position:fixed;top:0;right:0;bottom:0px;left:0;opacity:0;transition: all 1s;display:none;relative;z-index: 1000}
.modalAbre{background-color: rgba(0,0,0,.8);position:fixed;top:0;right:0;bottom:0px;left:-100;transition: all 1s;width:20%;height:20%;z-index: 10000}


  .modal-cont{background-color:white;width:800px;height:100%;padding: 0% 0%;margin: 0% auto;position: relative;z-index: 1000 }
  .modalCierraCont{background-color: rgba(0,0,0,.8);position:fixed;top:0;right:0;bottom:0px;left:0;opacity:0;transition: all 1s;display:none;z-index: 1000}
  .modalAbreCont{background-color: rgba(0,0,0,.8);position:fixed;top:0;right:0;bottom:0px;left:-100;transition: all 1s;width:100%;height:100%;display:block;relative;z-index: 1000}




.contMenuFlotanteBuscaPoliza{background: none repeat scroll 0 0 #FFFFFF;border: 1px solid #DDDDDD;border-radius: 6px 6px 6px 6px;bottom: 0px;right: 0px;margin-left: 100px;position: fixed;text-align: center;z-index: 10000;padding: 0px; margin: 0px; width: 100%; height: 100%;background-color: #FFFFFF }
.contMenuFlotante{background: none repeat scroll 0 0 #FFFFFF;border: 1px solid #DDDDDD;border-radius: 6px 6px 6px 6px;bottom: 200px;right: 10px;margin-left: 100px;padding: 10px 0 0;position: fixed;text-align: center;z-index: 10000;padding: 0px; margin: 0px; width: 800px; height: 400px;background-color: #FFFFFF }

.contMenuFlotante{background: none repeat scroll 0 0 #FFFFFF;border: 1px solid #DDDDDD;border-radius: 6px 6px 6px 6px;bottom: 200px;right: 10px;margin-left: 100px;padding: 10px 0 0;position: fixed;text-align: center;z-index: 10000;padding: 0px; margin: 0px; width: 800px; height: 400px;background-color: #FFFFFF }
.contMenuFlotanteMinimizado{background: none repeat scroll 0 0 #FFFFFF;border: 1px solid #DDDDDD;border-radius: 6px 6px 6px 6px;bottom: 20px;right: 0px;margin-left: 100px;padding: 10px 0 0;position: fixed;text-align: center;z-index: 10000;padding: 0px; margin: 0px; width: 30px; height: 10px; overflow: none;}
.contMenuFlotanteMinimizado > div{width: 30px; height: 30px}
.buttonContMenuFlotante{display:flex;height: 30px;width: 30px; }
.panelMenuFlotante{width: 100%;height: 400px;overflow: scroll;background-color: white}
/*.divMenu{min-width:50;min-height: 50px;width: 50px;height: 50px}
.divMenu > form > input{min-width:50;min-height: 50px;width: 50px;height: 50px;position: relative;top: -55px;cursor: pointer;background: red}*/
.divMenuBoton button{min-width:50;min-height: 50px;width: 70px;height: 50px;background: #00b900; text-align: center;color: white;margin-bottom: 6px; text-transform: uppercase; font-size: 70%}
.divMenuBoton > label,button{min-width:50;min-height: 50px;width: 70px;height: 50px;background: #00b900; text-align: center;color: white}
.divMenuBoton > form > label,input{min-width:50;width: 70px;height: 50px;background: #00b900; text-align: center; color:white;text-transform: uppercase;font-size: 70%}

.divMenuBoton:hover  > form > label,input{background-color: blue; cursor: pointer;}
.divMenuBoton:hover  > label,input{background-color: blue; cursor: pointer;}
.divMenuBoton:hover  button{background-color: blue; cursor: pointer;}


.iconocarpeta{width: 100%; height:40px;background: url(<?echo(base_url().'assets/images/iconocarpeta.png') ;?>) no-repeat;}
.iconocarpeta > label{display: flex;align-items: center;position: relative;left: 35px;top:-20px;}
.iconocarpetasub{width: 100%; height:40px;background: url(<?echo(base_url().'assets/images/iconocarpeta.png') ;?>) no-repeat;}
.iconocarpetasub > label{display: flex;align-items: center;position: relative;left: 35px;top:-5px;}
.iconojpg{width: 100%; height:40px;background: url(<?echo(base_url().'assets/images/iconojpj.png') ;?>) no-repeat;}
.iconopdf{width: 100%; height:40px;background: url(<?echo(base_url().'assets/images/iconopdf.png') ;?>) no-repeat; border: solid}
.iconoword{width: 100%; height:40px;background: url(<?echo(base_url().'assets/images/iconoword.png') ;?>) no-repeat;}
.iconoxls{width: 100%; height:40px;background: url(<?echo(base_url().'assets/images/iconoxls.png') ;?>) no-repeat;}
.iconoxml{width: 100%; height:40px;background: url(<?echo(base_url().'assets/images/iconoxml.png') ;?>) no-repeat;}
.iconomsg{width: 100%; height:40px;background: url(<?echo(base_url().'assets/images/iconomsg.png') ;?>) no-repeat;}
.iconoblanco{width: 100%; height:40px;background: url(<?echo(base_url().'assets/images/iconoblanco.png') ;?>) no-repeat;}
.iconoemail{width: 25px; height:25px;background: url(<?echo(base_url().'assets/images/iconoEmail.png') ;?>) no-repeat;}
.iconogenerico > a{position: relative;left: 35px;  display: flex;align-items: center; text-decoration: underline;}
.ulDocumentos{list-style-type: none; }
.tableCPCADocumentes>tr{width: 200px}
.ulSubmenu{position: relative;border: solid; list-style: none;display: none}
.liConSubmenu:hover > ul{display: block;}

.liArchivos{font-size: 12px;list-style:none;border: solid white; color: black}
.liReciboComprobante{background-color: #4ac34aa3}
.inputSimpleNumero{text-align: right}
.table> tbody{background-color: white}
.btnEmail{position: relative;left :250px;top:-15px;}
.divCell{width: inherit; overflow: auto;}
.divCellEditable:focus{background: white;background-color: blue}
.container{width: 1200px;margin: 0 auto; background-color:  #c1bdbd}
ul.tabs{margin: 0px;padding: 0px;list-style: none;}
ul.tabs li{color: black;display: inline-block;padding: 10px 15px;cursor: pointer;}
ul.tabs li.current{background: #ededed}
.tab-content{display: none;background: #ededed;padding: 15px;}
.tab-content.current{display: inherit;}
.cbSeleccionCP{width: 12px;height: 12px}
.cbSeleccionRenovaciones{width: 12px;height: 12px}
.cbSeleccionGeneral{width: 12px;height: 12px}
.cbSeleccionCA{width: 12px;height: 12px}
.tablaBuscarPoliza:hover {background-color: green; cursor: pointer;}
.btn{margin-left: 1px; width: auto;}
.etiquetaSimple{text-transform: uppercase;}
.botonSimple{text-transform: uppercase;text-decoration: underline;}
.selectSimple > option {text-transform:uppercase;}
.selectSimple  {text-transform:uppercase;}
.trRenovacion{color: white;background-color: blue}
.trRenovacionOcultarHijo{display: none}
.divCabeceraVigentes{display: flex}
.divCabeceraVigentes input{width: 100px}
.divMenuBoton:hover  div {display: block;margin:0px;flex-wrap: wrap;}
.submenuBoton button:hover{color: black; text-decoration-line:underline; }
.submenuBoton{position: relative;left: 60px;top:-120px;display: none}
.classTieneEjecutivo{background-color:#1e7e34;color: black}
.classTieneAgente{background-color:#bd2130;color: black}
.noEnviadoClass{background-color: red;}
</style>
<script type="text/javascript">


</script>
<script type="text/javascript">
	document.getElementById('fechaInicial').value="<?= $fechaInicial; ?>";
	document.getElementById('fechaInicialRenovacion').value="<?= $fechaInicial; ?>";
	document.getElementById('fechaFinal').value="<?= $fechaFinal; ?>"
	document.getElementById('fechaFinalRenovacion').value="<?=	$fechaFinalRenovacion; ?>"
	$(document).ready(function(){
	
	$('ul.tabs li').click(function(){
		var tab_id = $(this).attr('data-tab');
		$('ul.tabs li').removeClass('current');
		$('.tab-content').removeClass('current');
		$(this).addClass('current');
		$("#"+tab_id).addClass('current');
         manejoDeTabs(tab_id);
	})

})

function manejoDeTabs(tab_id)
{
		let cant=document.getElementsByClassName('divMenuBoton').length;
		for(let i=0;i<cant;i++){document.getElementsByClassName('divMenuBoton')[i].classList.add('ocultarObjeto');}
		divMenuFlotante.classList.add('ocultarObjeto');
        switch(tab_id)
        {
        	case 'tab-1':
             document.getElementById('btnCorreoPendiente').parentNode.classList.remove('ocultarObjeto');
             document.getElementById('btnWhats').parentNode.classList.remove('ocultarObjeto');
             document.getElementById('btnSMS').parentNode.classList.remove('ocultarObjeto');
             document.getElementById('btnExportar').parentNode.classList.remove('ocultarObjeto');
             document.getElementById('btnBuscarPoliza').parentNode.classList.remove('ocultarObjeto');
             document.getElementById('btnBuscarPolizaCliente').parentNode.classList.remove('ocultarObjeto');
             document.getElementById('btnGuionTelefonico').parentNode.classList.remove('ocultarObjeto');    
             //document.getElementById('DocumentoFiles').parentNode.parentNode.classList.remove('ocultarObjeto');          
             //document.getElementById('DocumentoFilesRecibo').parentNode.parentNode.classList.remove('ocultarObjeto');            
             divMenuFlotante.classList.remove('ocultarObjeto');
             bodyTableComentario='tableCobranzaPendiente';
        	break;
        	case 'tab-6':                      	
             document.getElementById('btnAgregarComentario').parentNode.classList.remove('ocultarObjeto');             
             document.getElementById('btnRenovacion').parentNode.classList.remove('ocultarObjeto');             
             document.getElementById('btnActividades').parentNode.classList.remove('ocultarObjeto');             
             bodyTableComentario='bodyTablaRenovaciones';
        	;break;
        }
}
manejoDeTabs('tab-1');
document.getElementById('selecDiaCobAtra').value="<?= $selecDiaCobAtra ;?>";
</script>
<style type="text/css">
.div1{height: 10px;width: 200px}

</style>
<script type="text/javascript">
	    window.addEventListener("resize",redimensionarCabecera);
	    redimensionarCabecera();
function redimensionarCabecera()
{var w = window.outerWidth;var h = window.outerHeight;w=w-230; 
 document.getElementById('divContenedorTabla').style.width=w+'px';
}

//traerRenovaciones('');
</script>
 <style type="text/css">
 	.cssRenovacionPoliza{display: flex;flex-direction: column;flex-grow: 1;width:auto;height: 400px;overflow:scroll;position:relative;left:2;top:30%;background-color: #dfe8f6}
 	.cssRenovacionPoliza div{display: flex;}
 	.cssRenovacionPoliza div label{flex:1;}
 	.cssRenovacionPoliza >div select,input,span{flex:3;background-color: white;color: black; min-height: 50px;font-size: 1.2rem;text-align: right;}	
 </style>

 <?
 function imprimirMeses($array)
 {
   $option='<option value="">-</option>';
   $mesActual=date('m');
   foreach ($array as $key => $value) 
   {
   	if($key==$mesActual){$option.='<option value="'.$key.'" selected>'.$value.'</option>';}
   	else{$option.='<option value="'.$key.'">'.$value.'</option>';}
   }
   return $option;
 }
function imprimirVendedores($array)
{
	
	$option='<option value="1"></option>';
	foreach ($array as $value) 
	{
		if($value->IDVend>0){$option.='<option value="'.$value->IDVend.'">'.$value->nombre.'</option>';}
	}
	return $option;
}

function imprimirTipoDocumentos($array)
{
	$select='<select name="tipoImg_0" id="tipoImg_0" class="form-control input-sm"><option value="">-- Seleccione --</option>';
    foreach ($array as  $value) {$select.='<option value="'.$value->idTipoImg.'">'.$value->nombre.'</option>';}
	$select.='</select>';
	return $select;
}

 ?>

<style type="text/css">
 
   .btn-chico{	
   	background-color:#44c767;
	border-radius:6px;
	border:1px solid #18ab29;
	display:inline-block;
	cursor:pointer;
	color:#ffffff;
	font-family:Arial;
	font-size:12px;	
	text-shadow:0px 0px 12px #2f6627;
	width: 25px;
	height: 25px;
   min-width: 25px;
   min-height: 25px;
 }  
.btn-chico:hover {background-color:#5cbf2a;}
.btn-chico:active {position:relative;top:1px;}

div:: -webkit-scrollbar{display: block;width: 10em;overflow: scroll;}
</style>

<script type="text/javascript">
function peticionAJAXSinBloqueo(controlador,parametros,funcion){
  var req = new XMLHttpRequest();var direccionAJAX="<?= base_url();?>";
  var url=direccionAJAX+controlador;//+parametros;
 req.open('POST', url, true);
  req.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
   req.onreadystatechange = function (aEvt) 
  {
   
    if (req.readyState == 4) {    	
      if(req.status == 200)
        {           
         var respuesta=JSON.parse(this.responseText); 
          document.getElementById('gifDeEspera1').classList.remove('verObjetoGif');
        document.getElementById('gifDeEspera1').classList.add('ocultarObjeto');           
         switch(funcion)
         {
           default:  window[funcion](respuesta);        break;            
         }     
                                 
      }     
      if(req.status==500)
      {
       
      }
      
   }

  };
 req.send(parametros);
}

function traerSeguimientoActividades(datos='')
{
	
 if(datos=='')
 {
 	let params='';
    controlador="cobranza/obtenerSeguimientoActividades/?";	
   peticionAJAXSinBloqueo(controlador,params,'traerSeguimientoActividades')
 }
 else
 {
 	let tabla=document.getElementById('seguimientoActividadesTbody');
 	tabla.innerHTML='';
 	let cant=tabla.rows.length;
   datos.seguimientoActividades.forEach(s=>{
     let band=false;
     let dir="<?=base_url();?>";

     	let row=document.createElement('tr');
     	let cell1=document.createElement('td');
     	let cell2=document.createElement('td');
     	let cell3=document.createElement('td');
     	let cell4=document.createElement('td');
     	let link=document.createElement('a');
     	let button=document.createElement('button');
     	button.innerHTML='Eliminar';
     	button.classList.add('btn');
     	button.classList.add('btn-danger');
     	button.dataset.valor=s.folioActividad;
     	button.setAttribute('onclick','eliminarActividadEndoso(\'\',this)')
     	link.href=`${dir}actividades/ver/${s.folioActividad}`;
     	link.innerHTML=s.folioActividad;
     	link.target='_blank';
     	cell1.appendChild(link);
     	cell2.innerHTML=s.comentario;
     	cell3.innerHTML=s.Status_Txt;     	
     	row.dataset.folioactividad=s.folioActividad;
     	cell4.appendChild(button);
     	row.appendChild(cell1);
     	row.appendChild(cell2);
     	row.appendChild(cell3);
     	row.appendChild(cell4);
     	tabla.appendChild(row);
     
   })
 }
}

function traerDocumentosCliente(datos='')
{
	if(datos=='')
	{
 	if(comprobarCobranzaSeleccionada()){
   let params='IDCli='+documentoSolicitudIDCli.value;
   controlador="cobranza/traerDocumentosCliente/?";
   peticionAJAX(controlador,params,'traerDocumentosCliente');
  }
	}
    else
    {
    let correos='';  
    let telefonos=""  
    datos.emailCliente.forEach(e=>{correos+=`<option>${e}</option>`;})
    document.getElementById('correosClientesSelect').innerHTML=correos;
    datos.telCliente.forEach(e=>{telefonos+=`<option>${e}</option>`;})
    document.getElementById('telefonosClienteSelect').innerHTML=telefonos;
    let archivos='<ul>';
    datos.documentosCliente.forEach(d=>{
      let tipo=devolverTipoArchivo(d.href);
     archivos+=`<li class="liArchivos"><div class="${tipo}"> <a href="${d.href}" target="_blank">${d.text}</a></div></li>`;

    })
    archivos+='</ul>';
    document.getElementById('contenedorDocumentosPersonalesDiv').innerHTML=archivos;
                      //cadena=cadena+'<li class="liArchivos"><div class="'+clase+' iconogenerico"><a href="'+respuesta.children[i].href+'" target="_blank" >'+respuesta.children[i].text+'</a></div></li>'; 
 }
}

function devolverTipoArchivo(archivo)
{
 let extension=archivo.split('.').pop();                 	
     extension=extension.toUpperCase();                 	
     switch(extension)
     {
        case 'PDF':clase='iconopdf';break;
        case 'MSG':clase='iconomsg';break;
        case 'JPG':clase='iconojpg';break;
        case 'JPEG':clase='iconojpg';break;
        case 'WORD':clase='iconoword';break;
        case 'XLS':clase='iconoxls';break;
        case 'XLSX':clase='iconoxls';break;
        case 'XML':clase='iconoxml';break;
        case 'DOCX':clase='iconoword';break;
        case 'PNG':clase='iconopdf';break;
        default: clase='iconoblanco';break;
    }
     return clase;
}

function devolverRowSeleccionado()
{
	let rowSeleccionado=document.getElementsByClassName('rowSeleccionado');
	if(rowSeleccionado.length>0){return rowSeleccionado[0];}else{alert('Escoger un cobranza');return false;}
}
function cambiarCorreo()
{
  let row=devolverRowSeleccionado();
  if(row)
  {
    let val=document.getElementById('correosClientesSelect').value;
  	row.dataset.email=val;
  	row.cells[11].innerHTML=`<div class="divCell divCellEditable" contenteditable="true" onfocusout="cambiaContenidoCelda(this,'email')">${val}</div>`
  
  }
}
function cambiarTelefono()
{
  let row=devolverRowSeleccionado();
  if(row)
  {
    let val=document.getElementById('telefonosClienteSelect').value;
  	row.dataset.telefono=val;
  	row.cells[12].innerHTML=`<div class="divCell divCellEditable" contenteditable="true" onfocusout="cambiaContenidoCelda(this,'tel')">${val}</div></div>`
  
  }
}

function eliminarActividadEndoso(datos='',objeto)
{
	
  if(datos=='')
  {
  	   let params = 'folioActividad='+objeto.dataset.valor;    	       	   
          controlador="cobranza/eliminarActividadEndoso/?";          
           peticionAJAX(controlador,params,'eliminarActividadEndoso'); 
    
  }	
  else
  {
  if(datos.mensaje){alert(datos.mensaje);}
   traerSeguimientoActividades();  	
  }
}


traerSeguimientoActividades();
setInterval("traerSeguimientoActividades()",30000);
	
</script>
<script type="text/javascript">
    document.getElementById('btnHistorialDeCorreos').addEventListener("click", function(){
        document.getElementById('divHistorialDeCorreos').classList.toggle('ocultarObjeto');
        if(this.dataset.char==128071){this.dataset.char='128070';this.innerHTML='&#128070';
        btnHistorialDeCorreos.parentNode.parentNode.parentNode.style.top="20%";
    }
        else{this.dataset.char=128071;this.innerHTML='&#128071';btnHistorialDeCorreos.parentNode.parentNode.parentNode.style.top="80%";}
    })
    let actRojo=document.querySelectorAll('button[name=btnHistorialDeCorreos]');
    actRojo.forEach(b=>{b.addEventListener("click",function(){
                
    })})
    
    
</script>
<style type="text/css">
	.controlHistorial{width: 100%;height: 50px}
</style>
<script type="text/javascript">
function historialEnviosPorUsuario(datos)	
{
  if(datos=='')
  {
     let params='IDCli='+documentoSolicitudIDCli.value;	
     params=`anio=${document.getElementById('anioEnvioSelect').value}&mes=${document.getElementById('meseEnvioSelect').value}`;
     controlador="cobranza/historialEnviosPorUsuario/?";
    peticionAJAXSinBloqueo(controlador,params,'historialEnviosPorUsuario');
  }
  else
  {
  	if(datos.mensajeAnio){alert(datos.mensajeAnio);}
  	let tablaBody='';
    let tabla='<table id="historilEnvioPorUsuarioTable" class="table" ><thead><tr><th>CLIENTE</th><th>PARA</th><th>DOCUMENTO</th><th>FECHA ENVIO</th><th>ENVIO</th></tr>'; 	
    
    let arrayEnvio=[];
    let arrayNombre=[];
    let arrayFecha=[];
    let arrayComentario=[];
    datos.envios.forEach(e=>{
     tablaBody+=`<tr data-filtropara="${e.envioDestinoCH}" data-filtrofecha="${e.fechaCreacion}" data-filtronombre="${e.NombreCompleto}" data-filtrocomentario="${e.comentarioDelEnvio}"><td>${e.NombreCompleto}</td><td>${e.envioDestinoCH}</td><td><a href="${e.hRefCH}" target="_blank">DOCUMENTO:${e.documento} RECIBO:${e.idSerie}</a></td><td>${e.fechaCreacionHora}</td><td>${e.comentarioDelEnvio}</td>`;
     bandEnvio=true;
     bandNombre=true;
     bandFecha=true;
     bandComentario=true;
     if(e.envioDestinoCH===null || e.envioDestinoCH==''){e.envioDestinoCH='SIN DATO';}
     arrayEnvio.forEach(en=>{if(en==e.envioDestinoCH){bandEnvio=false;}})
     if(bandEnvio){arrayEnvio.push([e.envioDestinoCH]);}
     
     if(e.NombreCompleto===null || e.NombreCompleto==''){e.NombreCompleto='SIN DATO';}
     arrayNombre.forEach(en=>{if(en==e.NombreCompleto){bandNombre=false;}})
     if(bandNombre){arrayNombre.push([e.NombreCompleto]);}
     
     if(e.fechaCreacion===null || e.fechaCreacion==''){e.fechaCreacion='SIN DATO';}
     arrayFecha.forEach(en=>{if(en==e.fechaCreacion){bandFecha=false;}})
     if(bandFecha){arrayFecha.push([e.fechaCreacion]);}     
     
     if(e.comentarioDelEnvio===null || e.comentarioDelEnvio==''){e.comentarioDelEnvio='-';}
     arrayComentario.forEach(en=>{if(en==e.comentarioDelEnvio){bandComentario=false;}})     
     if(bandComentario){arrayComentario.push([e.comentarioDelEnvio]);}
     
    })
    
    let optionEnvio="<option></option>";
    let optionNombre="<option></option>";
    let optionFecha="<option></option>";
    let optionComentario="<option></option>";
    arrayEnvio.forEach(a=>{optionEnvio+=`<option>${a}</option>`})
    arrayNombre.forEach(a=>{optionNombre+=`<option>${a}</option>`})
    arrayFecha.forEach(a=>{optionFecha+=`<option>${a}</option>`})
    arrayComentario.forEach(a=>{optionComentario+=`<option>${a}</option>`})
    tabla+=`<tr><th><select class="form-control" onchange="filtroHistorial(this)" data-classfiltro="nombreClass">${optionNombre}</select></th><th><select class="form-control" onchange="filtroHistorial(this)" data-classfiltro="envioClass">${optionEnvio}</select></th><th></th><th><select class="form-control" onchange="filtroHistorial(this)" data-classfiltro="fechaClass">${optionFecha}</select></th><th><select class="form-control" onchange="filtroHistorial(this)" data-classfiltro="comentarioClass">${optionComentario}</select></th></tr>`;
    tabla+=`</thead>`
    tabla+=`<tbody>${tablaBody}</tbody><table>`;
    if(datos.envios.length==0){tabla=`${tablaBody}<tr><th colspan="4">SIN RESULTADOS</th></tr></thead></table>`}
    document.getElementById('contenidoEnvioHistorialDiv').innerHTML=tabla;
  }

}
function filtroHistorial(objeto)
{
   let clase=objeto.dataset.classfiltro;
   let valComparacion="";
   switch(clase)
   {
   	case 'nombreClass':valComparacion='data-filtronombre'; break;
   	case 'envioClass':valComparacion='data-filtropara'; break;
   	case 'fechaClass':valComparacion='data-filtrofecha'; break;
   	case 'comentarioClass':valComparacion='data-filtrocomentario'; break;
   }
   
   let index=objeto.parentNode.cellIndex;
   let tbody=objeto.parentNode.parentNode.parentNode.nextSibling;
   
   let valor=objeto.value;
   let cadBody=Array.from(tbody.rows); 
   if(valor==''){cadBody.forEach(c=>{c.classList.remove(clase)})}
   else
   {
   	cadBody.forEach(c=>{ 
   		if(valor.indexOf(c.getAttribute(valComparacion))>=0){c.classList.remove(clase)}
   		else{c.classList.add(clase)}
   	})
   }

}
historialEnviosPorUsuario('');
</script>
<style type="text/css">
	.nombreClass{display: none}
	.envioClass{display: none}
	.fechaClass{display: none}
	.comentarioClass{display: none}
</style>