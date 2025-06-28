<?php $this->load->view('headers/header');$this->load->view('headers/headerReportes'); ?>
<?php $this->load->view('headers/menu');?>

 

<? $filtros['cliente']='selectCobPenCliente';$filtros['vendedor']='selectCobPenVend';$filtros['subRamo']='selectCobPenSubRamo';$filtros['fechaLimite']='selectCobPenFecLim';$filtros['documento']='selectCobPenDocumento' ;$filtros['endoso']='selectEndosoCobPen';$filtros['ramosnombre']='selectCobPenRamosNombre';$filtros['cianombre']='selectCobPenCiaNombre';$filtros['ccobro_txt']='selectCobPenCCobro_TXT';$filtros['serie']='selectCobPenSerie';$cobranzaPendienteArmado=imprimirCobranzaPendiente($cobranzaPendiente,'cbSeleccionCP','bodyTablaCobPen',$filtros,$opcionFecha,$envioEmail); ?>
    
<? $filtros['cliente']='selectCobAtraCliente';$filtros['vendedor']='selectCobAtraVend';$filtros['subRamo']='selectCobAtraSubRamo';$filtros['fechaLimite']='selectCobAtraFecLim'; $filtros['documento']='selectCobAtraDocumento';$filtros['endoso']='selectCobAtraEndoso';$filtros['ramosnombre']='selectCobAtraRamosNombre';$filtros['cianombre']='selectCobAtraCiaNombre';$filtros['ccobro_txt']='selectCobAtraCCobro_TXT';$filtros['serie']='selectCobAtraSerie';$cobranzaAtrasadaArmado=imprimirCobranzaPendiente($cobranzaAtrasada,'cbSeleccionCA','bodyTablaCobAtrasada',$filtros,$opcionFecha,$envioEmail); ?>
  <link rel="stylesheet" href="//code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
  <script src="https://code.jquery.com/jquery-1.12.4.js"></script>
  <script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>


<div class="divPrincipal">
<div class="divMenu">
 <div>
 	<div  class="divMenuBoton" >     

 		<form id="formDocumentoRecibo" action="javascript: enviarArchivoAJAX('formDocumentoRecibo','subirRecibo')" style="display: inline-flex;">
       <label  for="archivoProc" id="labelArchivoProc"  >Recibo</label> 
         <input type="file"  name="DocumentoFiles" id="DocumentoFilesRecibo" onchange="if(!this.value.length)return false;document.getElementById('formDocumentoRecibo').submit();" style="opacity: 0; position: relative; left: -70px "/>
         <input class="btn" type="hidden" name="inputIdDocto" id="inputIdDocto">
         <input class="btn" type="hidden" name="inputSerie" id="inputSerie">
         <input class="btn" type="hidden" name="inputRecibo" id="inputRecibo">
          <input class="btn" type="hidden" name="inputDocumento" id="inputDocumento">
           <input class="btn" type="hidden" name="inputPeriodo" id="inputPeriodo">
           <input class="btn" type="hidden" name="inputBody" id="inputBody">
           <input class="btn" type="hidden" name="inputEndoso" id="inputEndoso">
           <input class="btn" type="hidden" name="inputIdEndoso" id="inputIdEndoso">
           
           <input class="btn" type="hidden" name="inputIdEnviarCorreo" id="inputIdEnviarCorreo">
      </form>
  </div>
 	<div class="divMenuBoton"> <form id="formDocumentoComprobante" action="javascript: enviarArchivoAJAX('formDocumentoComprobante','subirComprobante')" style="display: inline-flex;">
       <label  for="archivoProc"  id="labelArchivoComprobante">Comprobante</label> 
         <input type="file"  name="DocumentoFiles" id="DocumentoFiles" onchange="if(!this.value.length)return false;document.getElementById('formDocumentoComprobante').submit();" style="opacity: 0;position: relative; left: -70px  "/>
         <input class="btn" type="hidden" name="inputIdDocto" id="inputIdDoctoComp">
         <input class="btn" type="hidden" name="inputSerie" id="inputSerieComp">
          <input class="btn" type="hidden" name="inputRecibo" id="inputReciboComp">
           <input class="btn" type="hidden" name="inputDocumento" id="inputDocumentoComp">
           <input class="btn" type="hidden" name="inputPeriodo" id="inputPeriodoComp">
           <input class="btn" type="hidden" name="inputBody" id="inputBodyComp">
           <input class="btn" type="hidden" name="inputEndoso" id="inputEndosoComp">
           <input class="btn" type="hidden" name="inputIdEndoso" id="inputIdEndosoComp">
           <input class="btn" type="hidden" name="inputIdEnviarCorreo" id="inputIdEnviarCorreoComp">
      </form></div>
 	<div class="divMenuBoton"  ><button id="btnCorreoPendiente" onclick="enviarCorreos('','cbSeleccionCP','bodyTablaCobPen')">Correo-Pendientes</button></div>
 	<div class="divMenuBoton" ><button id="btnCorreoAtrasado" onclick="enviarCorreos('','cbSeleccionCA','bodyTablaCobAtrasada')">Correo-Atrasados</button></div>
 	<div class="divMenuBoton ocultarObjeto"  ><label onclick=" borraReciboPagado()">Borrar</label></div>
 	<div class="divMenuBoton" ><button id="btnAgregarComentario" onclick="agregarComentario('')">Agregar comentario</button></div>
<? if($idVendedor==0){?>
 	<div class="divMenuBoton" ><button id="btnWhats" onclick="enviarWhats('')">Whats</button></div>
 	<div class="divMenuBoton" ><button id="btnSMS" onclick="enviarSMS('','cbSeleccionCP','bodyTablaCobPen')">SMS</button></div>
<? }else{
	if($saldo>5){?>
<div class="divMenuBoton" ><button id="btnWhats" onclick="enviarWhats('')">Whats</button></div>
 	<div class="divMenuBoton" ><button id="btnSMS" onclick="enviarSMS('','cbSeleccionCP','bodyTablaCobPen')">SMS</button></div>

	<?}else{?>
<div class="divMenuBoton" ><label id="btnWhats" style="background-color: #c1bdbd" title="No tienes saldo">Whats</label></div>
 	<div class="divMenuBoton" ><label id="btnSMS"  style="background-color: #c1bdbd" title="No tienes saldo">SMS</label></div>

	<?}
	
	?>
   
<?}?>

 	<div class="divMenuBoton" ><button id="btnExportar" onclick="exportarExcel('')">Exp. Cobranza</button>

 	</div>
  <div class="divMenuBoton" ><button id="btnBuscarPoliza" onclick="buscarPoliza('')">Buscar Poliza</button>

 	</div>
  
 </div>


</div>

<div class="divContenido">
 
<div class="container">

	<ul class="tabs">
		<li class="tab-link current" data-tab="tab-1"><h4>COBRANZA PENDIENTE</h4></li>
		<li class="tab-link" data-tab="tab-2"><h4>COBRANZA ATRASADA</h4></li>
		<li class="tab-link" data-tab="tab-3"><h4>ACTIVIDADES</h4></li>
		
	</ul>

	<div id="tab-1" class="tab-content current">
		<div ><form method="post" action="<?=base_url()?>cobranza">
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
    	<label>DIAS DE COBRANZA ATRASADA<select name="selecDiaCobAtra" id="selecDiaCobAtra" class="form-control"><option>0</option><option>5</option><option>10</option><option>15</option><option>20</option><option>25</option><option>30</option><option>60</option></select></label>
	   <label><input type="submit" name="enviar" class="btn btn-primary form-control"></label>

</form>

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

</div>

	</div>

<div id="tab-3" class="tab-content"><div id="divContenido">	</div></div>

</div>
<div id="miModal" >
	<div><button onclick="cerrar()" style="color: white;float:right;background-color:red; border:double;  ">Cerrar</button></div>
    <div id="Modalcontenido" class="modal-contenido"  >
    	 
</div>
</div>
<div class="contMenuFlotanteMinimizado" id="divMenuFlotante"><div><button class="buttonContMenuFlotante" onclick="maxminContMenuFlotante()"></button></div><hr><div><h3 id="labelNombreClienteMF"></h3><div><button onclick="verOcultarPanel(0)" class="btn btn-primary">DOCUMENTOS</button><button onclick="verOcultarPanel(1)" class="btn btn-primary">ALTA TARJETA</button><button onclick="verOcultarPanel(2);mostrarTarjeta('')" class="btn btn-primary">TARJETAS</button><button onclick="verOcultarPanel(3);mostrarHistorial('')" class="btn btn-primary">HISTORIAL</button><button onclick="verOcultarPanel(4);mostrarComentarios('')" class="btn btn-primary">COMENTARIOS</button></button>
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
  <div class="panelMenuFlotante" id="divComentarios" name="panelMenuFlotante"></div>
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
</div>
</div>
<div class="gifEspera ocultarObjeto" id="gifDeEspera1"><img src="<?php echo(base_url().'assets\img\loading.gif')?>"></div>
<table id="tablaExportar" border="2" class="ocultarObjeto"></table>
<div class="ocultarObjeto" id="divBuscarPoliza" style="overflow: scroll;"></div>

<?php //imprimirCobranzaAtrasada($cobranzaAtrasada);?>
<?php $this->load->view('footers/footerSinSegurin'); ?>




<script type="text/javascript">

var cabeceraTabla='<tr>	<th></th><th>Documento</th><th></th><th></th><th>Recibo</th><th>Periodo</th><th>Endoso</th><th>Cliente</th><th>Vendedor</th><th>Ramo</th><th>SubRamo</th><th>Email</th><th>Telefono</th><th>Fecha</th><th>Compania</th><th>Conducto</th><th>Prima total</th><th>Pref. Comunic.</th><th>Hr. Comunic.</th><th>Dia Comunic.</th><th></th></tr>';
function verOcultarDivPoliza(){
	document.getElementById('divBuscarPoliza').classList.toggle('ocultarObjeto');
	document.getElementById('divBuscarPoliza').classList.toggle('contMenuFlotanteBuscaPoliza');
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
	if(datos==''){
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
	   document.getElementById('divComentarios').innerHTML=tabla;
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
        if(bandEntrada){
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

        	  	if(dataHref!=''){
        	  		if(celular!='')
              	{  
              		           let dato=celular.split(':');
              		         
           if(dato.length==2)
           {
              if(dato[0].toUpperCase()=='CELULAR') 
              {
              	if((parseInt(dato[1]))==dato[1])
              	{
         	  		let properties = new Object();
        	  		properties.email=dataEmail;
        	  		properties.href=dataHref;
        	  		properties.idRecibo=dataIdRecibo; 
        	  		properties.idSerie=dataIdSerie; 
        	  		properties.idDocto=dataIdDocto;         	  		
        	  		properties.IDCli=dataIdCli;
        	  		properties.hrefComprobante =dataHrefComprobante;
        	  		properties.celular=dato[1];
        	  		properties.nombre=nombre;
        	  		properties.documento=documento;
        	  		properties.endoso=endoso;
        	  		properties.flimpago=flimpago;
        	  		arrayProperties.push(properties);   
              	}
              	else{ cb[i].checked=false; }
              }
              else{cb[i].checked=false;}	
           }else{cb[i].checked=false;}

        	  	 }              
        	  	 else{cb[i].checked=false;}
        	  	}
        	  	else{cb[i].checked=false;}

          }
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
      if(datos.idRecibo[i]==tablaBody.rows[j].getAttribute('data-idrecibo'))
      {
       tablaBody.rows[j].cells[3].classList.add('iconoemail');
       j=cantidadRows; 
      }
    } 
   }
 }
}





function enviarWhats(datos){
	if(datos=="")
	{
	  let rowSeleccionado=document.getElementsByClassName('rowSeleccionado');
	  if(rowSeleccionado.length>0)
	  {
	 
	     var params = 'IDRecibo='+rowSeleccionado[0].getAttribute('data-idrecibo');
	     var params =params+'&idDocto='+rowSeleccionado[0].getAttribute('data-iddocto');
	     var params =params+'&serie='+rowSeleccionado[0].getAttribute('data-serie');
	     var params =params+'&IDCli='+rowSeleccionado[0].getAttribute('data-idcli');
	     var params =params+'&endoso='+rowSeleccionado[0].getAttribute('data-endoso');
	     var params =params+'&telefono='+rowSeleccionado[0].getAttribute('data-telefono').replace(' ','');
	     var params =params+'&linkLargo='+rowSeleccionado[0].getAttribute('data-href');
	     var params =params+'&nombreCliente='+rowSeleccionado[0].getAttribute('data-nombre');
	     var params =params+'&documento='+rowSeleccionado[0].getAttribute('data-documento');
	     var params =params+'&flimpago='+rowSeleccionado[0].getAttribute('data-flimpago');
	     let nombre=rowSeleccionado[0].getAttribute('data-nombre');
    	let celular=rowSeleccionado[0].getAttribute('data-telefono').replace(' ','');
    	if(celular!='')
    	{  
             if(rowSeleccionado[0].getAttribute('data-href')==""){alert('No hay un recibo para enviar'); return 0;}
             let controlador="cobranza/mandarWhats/?";

    	  if((parseInt(celular))==celular)
    	  {
           let confirmacion = confirm("Es correcto el numero: "+celular+' '+nombre);
            if(confirmacion){ peticionAJAX(controlador,params,'enviarWhats');}
    	  }
    	  else
    	  {
           let dato=celular.split(':');
           if(dato.length==2)
           {
              if(dato[0].toUpperCase()=='CELULAR') 
              {
              	if((parseInt(dato[1]))==dato[1])
              	{
              	   let confirmacion = confirm("Se enviara el recibo al : "+celular+'  del cliente '+nombre);
                    if(confirmacion){  peticionAJAX(controlador,params,'enviarWhats');}
              	}
              	else{alert('No se pudo procesar el envio reportarlo a sistemas error 0000') ; }
              }
              else
              {
              	if((parseInt(dato[1]))==dato[1])
              	{
                 var confirmacion = confirm("El numero al parecer no es un celular si no un "+ dato[0]+": ¿deseas enviarlo?");
                 if(confirmacion){ peticionAJAX(controlador,params,'enviarWhats');}
              	}
              	else{alert('No se pudo procesar el envio reportarlo a sistemas error 0001');}
              }	
           }
           else{alert('No se pudo procesar el envio reportarlo a sistemas error 0002')}
    	  }
         
    	}
    	else
    	{alert('No tiene registro de celular el cliente');}
    	
      } 
       else {alert("Para enviar un whats necesitas escoger una recibo con numero de celular");}
      }
 
	else
	{
       alert(datos.mensaje);
	}
}


function agregarComentario(datos){
if(datos==''){
	let rowSeleccionado=document.getElementsByClassName('rowSeleccionado');
	if(rowSeleccionado.length>0)
	{
        var textoEscrito = prompt("Escribe un texto", "");
if(textoEscrito != null && textoEscrito!='')
{
	 
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
 else
 {
  alert(datos.mensaje); 
  mostrarComentarios(''); 
 }
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
	if(datos==''){
      if(document.getElementsByClassName('rowSeleccionado').length>0) {
         var params = 'IDRecibo='+document.getElementsByClassName('rowSeleccionado')[0].getAttribute('data-idrecibo');
             controlador="cobranza/mostrarHistorial/?";
          peticionAJAX(controlador,params,'mostrarHistorial');
      

      }
	}
	else
	{
       let cantidad=datos.historialCobranza.length
       let tabla='<table class="table"><tr><td>fecha</td><td>destino</td><td>archivo</td></tr>';
       for(let i=0;i<cantidad;i++)
       {
         tabla=tabla+'<tr>';
         tabla=tabla+'<td>'+datos.historialCobranza[i].fechaCreacionCH+'</td>';
         tabla=tabla+'<td>'+datos.historialCobranza[i].envioDestinoCH+'</td>';
         tabla=tabla+'<td>'+datos.historialCobranza[i].hRefCH+'</td>';
         tabla=tabla+'</tr>';
       }
       tabla=tabla+'</table>';
       document.getElementById('divHistorialClientes').innerHTML=tabla;


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
function buscarPoliza(datos)
{
  if(datos=='')
  {
  	var textoEscrito = prompt("Poliza a buscar", "");
   if(textoEscrito != null && textoEscrito!=''){
   	  let params='poliza='+textoEscrito;
	      controlador="cobranza/buscarPoliza/?";
    peticionAJAX(controlador,params,'buscarPoliza');
   
     } else {
	 alert("No has escrito nada");}


  }
  else
  {


  	let cantDatos=datos.TableInfo.length;
  	let tabla='<table class="table"><tr colspan="6" ><td align="left"><button onclick=verOcultarDivPoliza() style="color:white;background-color:red">X</button></td></tr>';

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
      tabla=tabla+'<tr ondblclick="agregarParaCobranzaEfectuada(this)" class="tablaBuscarPoliza" data-iddocto="'+datos.TableInfo[i].IDDocto+'" data-serie="'+datos.TableInfo[i].Serie+'" data-IDRecibo="'+datos.TableInfo[i].IDRecibo+'" data-email="'+email+'" data-periodo="'+datos.TableInfo[i].Periodo+'" data-nombre="'+datos.TableInfo[i].NombreCompleto+'" data-IDCli="'+datos.TableInfo[i].IDCli+'" data-documento="'+datos.TableInfo[i].Documento+'" data-idmon="'+datos.TableInfo[i].IDMon+'" data-moneda="'+datos.TableInfo[i].Moneda+'" data-primatotal="'+primaTotal+'" data-tcday="'+datos.TableInfo[i].TCDay+'" data-endoso="'+endoso+'" data-idendoso="'+datos.TableInfo[i].IDEnd+'" data-telefono="'+telefono+'" data-enviarcorreo="'+envio+'">';
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
      tabla=tabla+'<td class="divTD150"><div class="divCell">'+email+'</div></td>';
      tabla=tabla+'<td class="divTD150"><div class="divCell">'+telefono+'</div></td>';
      tabla=tabla+'<td class="divTD125"></td>';
      tabla=tabla+'<td class="divTD125" data-value="'+datos.TableInfo[i].CiaNombre+'">'+datos.TableInfo[i].CiaNombre+'</td>';
      tabla=tabla+'<td class="divTD125" data-value="'+datos.TableInfo[i].CCobro_TXT+'">'+datos.TableInfo[i].CCobro_TXT+'</td>';
      tabla=tabla+'<td class="divTD125" align="right">$'+primaTotal+'</td>';
      tabla=tabla+'<td class="divTD150" align="right"></td>';
      tabla=tabla+'<td class="divTD150" align="right"></td>';
      tabla=tabla+'<td class="divTD150" align="right"></td>';

     
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
	objeto.removeAttribute('class');
	objeto.removeAttribute('ondblclick');
	objeto.cells[0].classList.remove('ocultarObjeto');
	objeto.setAttribute('onclick','seleccionRow(this)')
	document.getElementById('bodyTablaCobPen').insertBefore(objeto,document.getElementById('bodyTablaCobPen').rows[0]);
	seleccionRow(document.getElementById('bodyTablaCobPen').rows[0]);
	traerCobranzaPolizaAgregada();
	verOcultarDivPoliza()
    }
    else{alert('El recibo ya esta dentro de la cobranza pendiente');}
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
if(isset($cobranzaPendiente->TableControl)){
if((int)$cobranzaPendiente->TableControl->MaxRecords>0)
 {
  foreach ($cobranzaPendiente->TableInfo as  $value) {
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
	$info.='<tr onclick="seleccionRow(this)" class="rowTabla" data-iddocto="'.$value->IDDocto.'" data-serie="'.$value->Serie.'" data-IDRecibo="'.$value->IDRecibo.'" data-email="'.$value->EMail1.'" data-periodo="'.$value->Periodo.'" data-nombre="'.$value->NombreCompleto.'" data-IDCli="'.$value->IDCli.'" data-documento="'.$value->Documento.'" data-idmon="'.$value->IDMon.'" data-moneda="'.$value->Moneda.'" data-primatotal="'.$primaTotal.'" data-tcday="'.$value->TCDay.'" data-endoso="'.$value->Endoso.'" data-idendoso="'.$value->IDEnd.'" data-telefono="'.$value->Telefono1.'" data-enviarcorreo="'.$envio.'" data-flimpago="'.$fechaLimite.'">';
	// $info.='<td class="divTD50" ><input type="radio" name="radioCobranzaPendiente"></td>';
    $info.='<td class="divTD15"><input type="checkbox" name="'.$classNombre.'" class="'.$classNombre.'"></td>';
    //$info.='<td class="divTD150"   data-iddocto="'.$value->IDDocto.'" data-serie="'.$value->Serie.'" data-IDRecibo="'.$value->IDRecibo.'">'.$value->Documento.'</td>';
   $info.='<td class="divTD150"   data-value="'.$value->Documento.'">'.$value->Documento.'</td>';
    $info.='<td class="divTD75"></td>';
    $info.='<td class="divTD25"></td>';
    $info.='<td class="divTD100 ocultarObjeto">'.$value->IDRecibo.'</td>';  
    $info.='<td class="divTD75" data-value="'.$value->Serie.'">'.$value->Serie.'</td>';
    $info.='<td class="divTD150" align="center" data-value="'.$value->Endoso.'">'.$value->Endoso.'</td>';
    $info.='<td class="divTD400" data-value="'.$value->IDCli.'">'.$value->NombreCompleto.'</td>';
    $info.='<td class="divTD400" data-value="'.$value->IDVend.'">'.$value->VendNombre.'</td>';
    $info.='<td class="divTD150" data-value="'.$value->RamosNombre.'">'.$value->RamosNombre.'</td>';
    $info.='<td class="divTD150 ocultarCelda" data-value="'.$value->SRamoNombre.'">'.$value->SRamoNombre.'</td>';
    $info.='<td class="divTD150"><div class="divCell">'.$value->EMail1.'</div></td>';
    $info.='<td class="divTD150"><div class="divCell">'.$value->Telefono1.'</div></td>';
    
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
}
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
  for(let i=0;i<cantCB;i++){
   let cant=cb[i].parentElement.parentElement.classList.length;
        if(cant==1){cb[i].checked=estado;}
        else{if(cant==2){if(cb[i].parentElement.parentElement.classList.contains('rowSeleccionado')){cb[i].checked=estado;}}}
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
        	  	else{cb[i].checked=false;}
        	  }
        	  else{cb[i].checked=false;}
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
      if(datos.idRecibo[i]==tablaBody.rows[j].getAttribute('data-idrecibo'))
      {
       tablaBody.rows[j].cells[3].classList.add('iconoemail');
       j=cantidadRows; 
      }
    } 
   }
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
function seleccionRow(objeto){
	let cant=objeto.parentNode.rows.length;

	let cantCP=document.getElementById('bodyTablaCobPen').rows.length;
	let cantCA=document.getElementById('bodyTablaCobAtrasada').rows.length;
	for(let i=0;i<cantCP;i++){document.getElementById('bodyTablaCobPen').rows[i].classList.remove('rowSeleccionado');}	
	for(let i=0;i<cantCA;i++){document.getElementById('bodyTablaCobAtrasada').rows[i].classList.remove('rowSeleccionado');}	

	objeto.classList.add('rowSeleccionado');
	if(document.getElementById("ul"+objeto.getAttribute('data-idrecibo'))){
  
	document.getElementById('divLinksDocumentos').innerHTML=document.getElementById("ul"+objeto.getAttribute('data-idrecibo')).innerHTML;}
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
	//document.getElementById('inputMonedaDocto').value=objeto.getAttribute('data-moneda');
	//document.getElementById('divTarjetaClientes').innerHTML='';
	document.getElementById('divHistorialClientes').innerHTML='';
	verOcultarPanel(0);
	
}
function aplicarFiltro(objeto,tabla,select,clase){	
	let tablaFiltro=document.getElementById(tabla);
	let totalRows=tablaFiltro.rows.length;
	let valorComparar=document.getElementById(select).value;
	if(objeto.value!=''){
	for(let i=0;i<totalRows;i++){
		if(tablaFiltro.rows[i].cells[objeto.parentNode.parentNode.cellIndex].getAttribute('data-value')!=valorComparar)
			{tablaFiltro.rows[i].classList.add(clase);}
		else{tablaFiltro.rows[i].classList.remove(clase);}

	}
   }
   else{for(let i=0;i<totalRows;i++){tablaFiltro.rows[i].classList.remove(clase);}}
	//
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
           
         }     
        document.getElementById('gifDeEspera1').classList.remove('verObjetoGif');
        document.getElementById('gifDeEspera1').classList.add('ocultarObjeto');                                 
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
document.getElementById('spanTotalCob').innerHTML=totalRowsCP;
    document.getElementById('gifDeEspera1').classList.add('verObjetoGif');
document.getElementById('gifDeEspera1').classList.remove('ocultarObjeto');
if(totalRowsCP==0){ traeCobranzaAtrasada();}
for(let i=0;i<totalRowsCP;i++)
{
  divTotalCobPenSinDocS=0;
  let idDocto=tablaCP.rows[i].getAttribute('data-iddocto');
  let serie=tablaCP.rows[i].getAttribute('data-serie');
  let recibo=tablaCP.rows[i].getAttribute('data-IDRecibo');
  let periodo=tablaCP.rows[i].getAttribute('data-periodo');
  let idcli=tablaCP.rows[i].getAttribute('data-idcli');
  let endoso=tablaCP.rows[i].getAttribute('data-endoso');
  let inner=tablaCP.rows[i].cells[1].innerHTML;
    var parametros = "IDDocto="+idDocto+"&rowIndex="+i+'&inner='+inner+'&serie='+serie+'&IDRecibo='+recibo+'&periodo='+periodo+'&idcli='+idcli+'&endoso='+endoso

    controlador="cobranza/traeArchivos/?";
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
              { let bandEntrada=0;
              	if(respuesta.children[i]!=1)
              	{
                 if(respuesta.endoso!='')
                 {  
                 	let textEndoso=respuesta.endoso+'_'+respuesta.periodo;
                 	let textEndosoComprobante=respuesta.endoso+'_'+respuesta.periodo+'Comprobante';
                 	
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
                 {  let clase="";
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


                   
            if(respuesta.historialCobranza!="0"){document.getElementById('bodyTablaCobPen').rows[respuesta.rowIndex].cells[3].innerHTML='<div class="iconoemail">  </div>';}

                     cadenaPrincipio=cadenaPrincipio+'<div class="divDocumentos"><ul class="ulDocumentos" id="ul'+respuesta.IDRecibo+'"><div class="iconocarpeta"><label><h3>'+respuesta.inner+'</h3></label></div>';   
               if(cadena!="")
               {        bandRecibo1="divConDocRecibo";
                    	bandRecibo2="divCDRCP";
                	cadena='<div class="divDocumentos"><ul class="ulDocumentos" id="ul'+respuesta.IDRecibo+'"><div class="iconocarpeta"><label></label><h3>'+respuesta.inner+'('+respuesta.endoso+')</h3></div><li class="liArchivos"><ul class="ulDocumentos">'+cadena+'</ul></li></ul></div>';
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
	 		document.getElementById('bodyTablaCobPen').rows[respuesta.rowIndex].cells[18].innerHTML=respuesta.horarioComunicacion;	 		document.getElementById('bodyTablaCobPen').rows[respuesta.rowIndex].setAttribute('data-diacomunicacion',respuesta.diaComunicacion);
	 		document.getElementById('bodyTablaCobPen').rows[respuesta.rowIndex].cells[19].innerHTML=respuesta.diaComunicacion;
	 	if(req.readyState == 4) {
      if(req.status == 200) {
      		total=document.getElementsByClassName('divSDCP').length+document.getElementsByClassName('divCDCP').length;
                document.getElementById('divTotalCobPenSinDoc').innerHTML='Sin documento='+total;
       // document.getElementById('divTotalCobranzaConDoc').innerHTML='Con documento='+;
        document.getElementById('divTotalCobranzaConDocRec').innerHTML='Con Recibo='+document.getElementsByClassName('divCDRCP').length;
        traeCobranzaAtrasada();

      }
    }

  }
  };
 req.send(parametros);
}
function traerCobranzaPolizaAgregada()
{
  //let totalRowsCP=document.getElementById('bodyTablaCobPen').rows[0];
let tablaCP=document.getElementById('bodyTablaCobPen').rows[0];
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
  let i=0;
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
            document.getElementById('bodyTablaCobPen').rows[0].cells[2].classList.add('divSinDocumento');
            document.getElementById('bodyTablaCobPen').rows[0].cells[2].classList.add('divSDCP');	 
	 		document.getElementById('bodyTablaCobPen').rows[0].cells[2].innerHTML='<ul class="divDocumentos" id="ul'+respuesta.IDRecibo+'"><li>Sin Documentos</li></ul>';
	 	    document.getElementById('bodyTablaCobPen').rows[0].setAttribute('data-href',dataHref);
	 	    document.getElementById('bodyTablaCobPen').rows[0].setAttribute('data-class','divSDCP');
	 	}
	 	else
	 	{
             let cantidad=respuesta.children.length
               let cadena="";
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
              { let bandEntrada=0;
              	if(respuesta.children[i]!=1)
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


              }   //for          


                   
            if(respuesta.historialCobranza!="0"){document.getElementById('bodyTablaCobPen').rows[0].cells[3].innerHTML='<div class="iconoemail">  </div>';}

                     cadenaPrincipio=cadenaPrincipio+'<div class="divDocumentos"><ul class="ulDocumentos" id="ul'+respuesta.IDRecibo+'"><div class="iconocarpeta"><label><h3>'+respuesta.inner+'</h3></label></div>';   
               if(cadena!="")
               {                  	bandRecibo1="divConDocRecibo";
                    	bandRecibo2="divCDRCP";
               	cadena='<div class="divDocumentos"><ul class="ulDocumentos" id="ul'+respuesta.IDRecibo+'"><div class="iconocarpeta"><label></label><h3>'+respuesta.inner+'('+respuesta.endoso+')</h3></div><li class="liArchivos"><ul class="ulDocumentos">'+cadena+'</ul></li></ul></div>';
               }    
    	  
             let titulo="SIN DOCUMENTOS";let dataValue="sindocumentos";              
	 		
	 		if(dataHrefComprobante!='' && dataHref==''){titulo="CON COMPROBANTE";dataValue="comprobante";document.getElementById('bodyTablaCobPen').rows[respuesta.rowIndex].cells[2].classList.add('divConDocComprobante');}
	 		if(dataHrefComprobante=='' && dataHref!=''){titulo="CON RECIBO";dataValue="recibo";}
	 		if(dataHref!='' && dataHrefComprobante!=''){titulo="CON RECIBO Y COMPROBANTE";dataValue="recibocomprobante";document.getElementById('bodyTablaCobPen').rows[respuesta.rowIndex].cells[2].classList.add('divConDocReciboComprobante');}

	 		  document.getElementById('bodyTablaCobPen').rows[respuesta.rowIndex].cells[2].setAttribute('data-value',dataValue);
	 		  document.getElementById('bodyTablaCobPen').rows[respuesta.rowIndex].setAttribute('title',titulo);


    	    document.getElementById('bodyTablaCobPen').rows[0].cells[2].classList.add(bandRecibo1);
	        document.getElementById('bodyTablaCobPen').rows[0].cells[2].classList.add(bandRecibo2);           
	 		document.getElementById('bodyTablaCobPen').rows[0].cells[2].innerHTML=cadena;
	 		document.getElementById('bodyTablaCobPen').rows[0].setAttribute('data-href',dataHref);
	 		document.getElementById('bodyTablaCobPen').rows[0].setAttribute('data-hrefcomprobante',dataHrefComprobante);
	 		document.getElementById('bodyTablaCobPen').rows[0].setAttribute('data-class',bandRecibo1);

	 	}
	 	document.getElementById('bodyTablaCobPen').rows[0].setAttribute('data-preferenciacomunicacion',respuesta.preferenciaComunicacion);
	 		document.getElementById('bodyTablaCobPen').rows[0].cells[17].innerHTML=respuesta.preferenciaComunicacion;
	 			 		document.getElementById('bodyTablaCobPen').rows[0].setAttribute('data-horariocomunicacion',respuesta.preferenciaComunicacion);
	 		document.getElementById('bodyTablaCobPen').rows[0].cells[18].innerHTML=respuesta.horarioComunicacion;	 		document.getElementById('bodyTablaCobPen').rows[0].setAttribute('data-diacomunicacion',respuesta.diaComunicacion);
	 		document.getElementById('bodyTablaCobPen').rows[0].cells[19].innerHTML=respuesta.diaComunicacion;

            document.getElementById('gifDeEspera1').classList.remove('verObjetoGif');
document.getElementById('gifDeEspera1').classList.add('ocultarObjeto');
       seleccionRow(document.getElementById('bodyTablaCobPen').rows[0]);
      }
    }
  }

  req.send(parametros);
	 

}
function traeCobranzaAtrasada(){

let totalRowsCA=document.getElementById('bodyTablaCobAtrasada').rows.length;
let tablaCA=document.getElementById('bodyTablaCobAtrasada');
document.getElementById('spanTotalCobAtrasada').innerHTML=totalRowsCA;
if(totalRowsCA==0){document.getElementById('gifDeEspera1').classList.remove('verObjetoGif');
document.getElementById('gifDeEspera1').classList.add('ocultarObjeto');}
for(let i=0;i<totalRowsCA;i++)
{
  divTotalCobPenSinDocS=0;
  let idDocto=tablaCA.rows[i].getAttribute('data-iddocto');
  let serie=tablaCA.rows[i].getAttribute('data-serie');
  let recibo=tablaCA.rows[i].getAttribute('data-IDRecibo');
  let periodo=tablaCA.rows[i].getAttribute('data-periodo');  
  let idcli=tablaCA.rows[i].getAttribute('data-idcli');
  let endoso=tablaCA.rows[i].getAttribute('data-endoso');
  let inner=tablaCA.rows[i].cells[1].innerHTML;
    var parametros = "IDDocto="+idDocto+"&rowIndex="+i+'&inner='+inner+'&serie='+serie+'&IDRecibo='+recibo+'&periodo='+periodo+'&idcli='+idcli+'&endoso='+endoso;

    controlador="cobranza/traeArchivos/?";
  var req = new XMLHttpRequest();var direccionAJAX="<?= base_url();?>";
  var url=direccionAJAX+controlador;
 req.open('POST', url, true); req.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
   req.onreadystatechange = function (aEvt) 
  { 

	 if(this.responseText!=''){
	 	var respuesta=JSON.parse(this.responseText); 
	 	if(respuesta.text=="No cuenta con documentos")
	 	{  let dataHref='';
	       
	        document.getElementById('bodyTablaCobAtrasada').rows[respuesta.rowIndex].cells[2].classList.add('divSinDocumento');
	        document.getElementById('bodyTablaCobAtrasada').rows[respuesta.rowIndex].cells[2].classList.add('divSDCA');
	 		document.getElementById('bodyTablaCobAtrasada').rows[respuesta.rowIndex].cells[2].innerHTML='<ul class="divDocumentos" id="ul'+respuesta.IDRecibo+'"><li>Sin Documentos</li></ul>';
	 		document.getElementById('bodyTablaCobAtrasada').rows[respuesta.rowIndex].setAttribute('data-href',dataHref);
	 			 		  document.getElementById('bodyTablaCobAtrasada').rows[respuesta.rowIndex].cells[2].setAttribute('data-value','sindocumentos');
	 		  document.getElementById('bodyTablaCobAtrasada').rows[respuesta.rowIndex].setAttribute('title','SIN DOCUMENTOS');

	 	}
	 	else{
                 
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
              	if(respuesta.children[i]!=1)
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

              if(respuesta.historialCobranza!="0"){document.getElementById('bodyTablaCobAtrasada').rows[respuesta.rowIndex].cells[3].innerHTML='<div class="iconoemail">  </div>';}

               if(cadena!="")
               {       
               	bandRecibo1="divConDocRecibo";
                bandRecibo2="divCDRCA";  
               	cadena='<div class="divDocumentos"><ul class="ulDocumentos" id="ul'+respuesta.IDRecibo+'"><div class="iconocarpeta"><label></label><h3>'+respuesta.inner+'('+respuesta.endoso+')</h3></div><li class="liArchivos"><ul class="ulDocumentos">'+cadena+'</ul></li></ul></div>';
               }    

             let titulo="SIN DOCUMENTOS";let dataValue="sindocumentos";              
	 		
	 		if(dataHrefComprobante!='' && dataHref==''){titulo="CON COMPROBANTE";dataValue="comprobante";document.getElementById('bodyTablaCobPen').rows[respuesta.rowIndex].cells[2].classList.add('divConDocComprobante');}
	 		if(dataHrefComprobante=='' && dataHref!=''){titulo="CON RECIBO";dataValue="recibo";}
	 		if(dataHref!='' && dataHrefComprobante!=''){titulo="CON RECIBO Y COMPROBANTE";dataValue="recibocomprobante";document.getElementById('bodyTablaCobPen').rows[respuesta.rowIndex].cells[2].classList.add('divConDocReciboComprobante');}

	 		  document.getElementById('bodyTablaCobAtrasada').rows[respuesta.rowIndex].cells[2].setAttribute('data-value',dataValue);
	 		  document.getElementById('bodyTablaCobAtrasada').rows[respuesta.rowIndex].setAttribute('title',titulo);








             document.getElementById('bodyTablaCobAtrasada').rows[respuesta.rowIndex].cells[2].classList.add(bandRecibo1);
	        document.getElementById('bodyTablaCobAtrasada').rows[respuesta.rowIndex].cells[2].classList.add(bandRecibo2);  
             document.getElementById('bodyTablaCobAtrasada').rows[respuesta.rowIndex].cells[2].innerHTML=cadena;
	 		document.getElementById('bodyTablaCobAtrasada').rows[respuesta.rowIndex].cells[2].innerHTML=cadenaPrincipio+cadena;
	 		document.getElementById('bodyTablaCobAtrasada').rows[respuesta.rowIndex].setAttribute('data-href',dataHref);
           	document.getElementById('bodyTablaCobAtrasada').rows[respuesta.rowIndex].setAttribute('data-hrefcomprobante',dataHrefComprobante);
	 	
	 	}
	 	document.getElementById('bodyTablaCobAtrasada').rows[respuesta.rowIndex].setAttribute('data-preferenciacomunicacion',respuesta.preferenciaComunicacion);
	 	document.getElementById('bodyTablaCobAtrasada').rows[respuesta.rowIndex].cells[17].innerHTML=respuesta.preferenciaComunicacion;
	 	document.getElementById('bodyTablaCobAtrasada').rows[respuesta.rowIndex].setAttribute('data-horariocomunicacion',respuesta.preferenciaComunicacion);
	 	document.getElementById('bodyTablaCobAtrasada').rows[respuesta.rowIndex].cells[18].innerHTML=respuesta.horarioComunicacion;	 		document.getElementById('bodyTablaCobAtrasada').rows[respuesta.rowIndex].setAttribute('data-diacomunicacion',respuesta.diaComunicacion);
	 	document.getElementById('bodyTablaCobAtrasada').rows[respuesta.rowIndex].cells[19].innerHTML=respuesta.diaComunicacion;
	 	if(req.readyState == 4) {
      if(req.status == 200) {

            document.getElementById('gifDeEspera1').classList.remove('verObjetoGif');
document.getElementById('gifDeEspera1').classList.add('ocultarObjeto');
      	let total;
      	total=document.getElementsByClassName('divSDCA').length+document.getElementsByClassName('divCDCA').length;
        document.getElementById('divTotalCobAtrasadaSinDoc').innerHTML='Sin Recibo='+total;
        document.getElementById('divTotalCobranzaAtrasadaConDocRec').innerHTML='Con Recibo='+document.getElementsByClassName('divCDRCA').length;
       

      }
    }

  }
  };
 req.send(parametros);
}

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
		     // if(document.getElementsByClassName('rowSeleccionado')[0].parentNode.id!='bodyTablaCobAtrasada'){alert('Escoger comprobante');return 0;}  
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
              	if(respuesta.children[i]!=1)
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



cargarPagina('actividades/verActividades');
function exportarExcel(){
	

   var downloadLink;
    var dataType = 'application/vnd.ms-excel';
    let tablaCobranza=document.getElementById('tableCobranzaPendiente');
    var tableSelect = document.getElementById('tablaExportar');
    tableSelect.innerHTML=cabeceraTabla+tablaCobranza.innerHTML;
   let cant=tableSelect.rows.length;
   for(let i=0;i<cant;i++){tableSelect.rows[i].cells[0].innerHTML='';tableSelect.rows[i].cells[2].innerHTML='';tableSelect.rows[i].cells[0].setAttribute('align','right');}
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
        // Create a link to the file
        downloadLink.href = 'data:' + dataType + ', ' + tableHTML;    
        // Setting the file name
        downloadLink.download = filename;        
        //triggering the function
        downloadLink.click();
    }
}
function cargarPagina(controlador){	
   if(controlador!=""){  
  // document.getElementById('imgEspera').classList.toggle('ocultarObjeto');
   //document.getElementById('imgEspera').classList.toggle('verObjeto');      
	    var xhr=new XMLHttpRequest();url=<?='"'.base_url().'"'?>+controlador;xhr.open('POST',url,true);
        xhr.onload=function(){if(this.status==200){
        if(<?='"'.base_url().'auth/login"'?>==xhr.responseURL){window.location.replace(xhr.responseURL);}
   divContenido.innerHTML=xhr.responseText;
   if(document.getElementsByClassName('contMenuFlotante').length>0){
      document.getElementsByClassName('contMenuFlotante')[0].classList.add('ocultarObjeto');}
     if(document.getElementsByClassName('fondoCabeceraMenuGeneral').length>1){
      document.getElementsByClassName('fondoCabeceraMenuGeneral')[1].classList.add('ocultarObjeto');}
      if(document.getElementsByClassName('marquesinaGeneral').length>1){
      document.getElementsByClassName('marquesinaGeneral')[1].classList.add('ocultarObjeto');}
      if(document.getElementsByClassName('menuPrincipal').length>1){
      document.getElementsByClassName('menuPrincipal')[1].classList.add('ocultarObjeto');}
      if(document.getElementById('panelBusqueda')){      
      document.getElementById('panelBusqueda').classList.add('ocultarObjeto');}
      let ch=document.getElementsByName('ch[]');let cantidad=0;
      cantidad=ch.length;
      for(let i=0;i<cantidad;i++){ch[i].setAttribute('class','cbSeleccionCP');}
      let ch1=document.getElementsByName('cbTrabajarActividad');
       cantidad=0;
      cantidad=ch1.length;
      for(let i=0;i<cantidad;i++){ch1[i].setAttribute('class','cbSeleccionCP');}

}}
        xhr.send();}
}


	  
//Función para actualizar cada 4 segundos(4000 milisegundos)
  setInterval("cargarPagina('actividades/verActividades')",300000);

</script>
<style type="text/css">
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

/*.divTD25{width:15%;max-width: 15%;min-width: 15%}
.divTD25{width:25%;max-width: 25%;min-width: 25%}
.divTD50{width:50%;max-width: 50%;min-width: 50%}
.divTD75{width:75%;max-width: 75%;min-width: 75%}
.divTD100{width:100%;max-width: 100%;min-width: 100%}
.divTD125{width:125%;max-width: 125%;min-width: 125%}
.divTD150{width:150%;max-width: 150%;min-width: 150%}
.divTD200{width:200%;max-width: 200%;min-width: 200%}
.divTD300{width:300%;max-width: 300%;min-width: 300%}
.divTD400{width:400%;max-width: 400%;min-width: 400%}
.divTD500{width:500%;max-width: 500%;min-width: 500%}*/

.rowSeleccionado{background-color:  green; color:white;}


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

.contMenuFlotanteBuscaPoliza{background: none repeat scroll 0 0 #FFFFFF;border: 1px solid #DDDDDD;border-radius: 6px 6px 6px 6px;bottom: 100px;right: 200px;margin-left: 100px;padding: 10px 0 0;position: fixed;text-align: center;z-index: 10000;padding: 0px; margin: 0px; width: 800px; height: 400px;background-color: #FFFFFF }
.contMenuFlotante{background: none repeat scroll 0 0 #FFFFFF;border: 1px solid #DDDDDD;border-radius: 6px 6px 6px 6px;bottom: 200px;right: 10px;margin-left: 100px;padding: 10px 0 0;position: fixed;text-align: center;z-index: 10000;padding: 0px; margin: 0px; width: 800px; height: 400px;background-color: #FFFFFF }

.contMenuFlotante{background: none repeat scroll 0 0 #FFFFFF;border: 1px solid #DDDDDD;border-radius: 6px 6px 6px 6px;bottom: 200px;right: 10px;margin-left: 100px;padding: 10px 0 0;position: fixed;text-align: center;z-index: 10000;padding: 0px; margin: 0px; width: 800px; height: 400px;background-color: #FFFFFF }
.contMenuFlotanteMinimizado{background: none repeat scroll 0 0 #FFFFFF;border: 1px solid #DDDDDD;border-radius: 6px 6px 6px 6px;bottom: 20px;right: 0px;margin-left: 100px;padding: 10px 0 0;position: fixed;text-align: center;z-index: 10000;padding: 0px; margin: 0px; width: 30px; height: 10px; overflow: none;}
.contMenuFlotanteMinimizado > div{width: 30px; height: 30px}
.buttonContMenuFlotante{display:flex;height: 30px;width: 30px; background: url(<?echo(base_url().'assets/images/iconomaxmin.png') ;?>) no-repeat;}
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
.inputSimpleNumero{text-align: right}
.table> tbody{background-color: white}
.btnEmail{position: relative;left :250px;top:-15px;}
.divCell{width: inherit; overflow: auto;}
	
.container{width: 1200px;margin: 0 auto; background-color:  #c1bdbd}
ul.tabs{margin: 0px;padding: 0px;list-style: none;}
ul.tabs li{color: black;display: inline-block;padding: 10px 15px;cursor: pointer;}
ul.tabs li.current{background: #ededed}
.tab-content{display: none;background: #ededed;padding: 15px;}
.tab-content.current{display: inherit;}
.cbSeleccionCP{width: 12px;height: 12px}
.cbSeleccionGeneral{width: 12px;height: 12px}
.cbSeleccionCA{width: 12px;height: 12px}
.tablaBuscarPoliza:hover {background-color: green; cursor: pointer;}
.btn{margin-left: 1px; width: auto;}
.etiquetaSimple{text-transform: uppercase;}
.botonSimple{text-transform: uppercase;text-decoration: underline;}
.selectSimple > option {text-transform:uppercase;}
.selectSimple  {text-transform:uppercase;}
</style>
<script type="text/javascript">


</script>
<script type="text/javascript">




	document.getElementById('fechaInicial').value="<?= $fechaInicial; ?>";
	document.getElementById('fechaFinal').value="<?= $fechaFinal; ?>"
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
        switch(tab_id)
        {
        	case 'tab-1':
             document.getElementById('btnCorreoPendiente').removeAttribute('disabled');
             document.getElementById('btnCorreoPendiente').removeAttribute('style');
             document.getElementById('btnWhats').removeAttribute('disabled');
             document.getElementById('btnWhats').removeAttribute('style');
             document.getElementById('btnSMS').removeAttribute('disabled');
             document.getElementById('btnSMS').removeAttribute('style');
             document.getElementById('btnExportar').removeAttribute('disabled');
             document.getElementById('btnExportar').removeAttribute('style');
             document.getElementById('btnBuscarPoliza').removeAttribute('disabled');
             document.getElementById('btnBuscarPoliza').removeAttribute('style');
             document.getElementById('btnCorreoAtrasado').setAttribute('disabled',true);
             document.getElementById('btnCorreoAtrasado').setAttribute('style','background-color: #c1bdbd');
             document.getElementById('DocumentoFiles').removeAttribute('disabled');
             document.getElementById('labelArchivoComprobante').removeAttribute('style');
             document.getElementById('DocumentoFilesRecibo').removeAttribute('disabled');
             document.getElementById('labelArchivoProc').removeAttribute('style');


        	;break;
        	case 'tab-2':
             
             document.getElementById('btnCorreoPendiente').setAttribute('disabled',true);             
             document.getElementById('btnCorreoPendiente').setAttribute('style','background-color: #c1bdbd');
             document.getElementById('btnWhats').setAttribute('disabled',true);             
             document.getElementById('btnWhats').setAttribute('style','background-color: #c1bdbd');
             document.getElementById('btnSMS').setAttribute('disabled',true);             
             document.getElementById('btnSMS').setAttribute('style','background-color: #c1bdbd');
             document.getElementById('btnExportar').setAttribute('disabled',true);
             document.getElementById('btnExportar').setAttribute('style','background-color: #c1bdbd');
             document.getElementById('btnBuscarPoliza').setAttribute('disabled',true);
             document.getElementById('btnBuscarPoliza').setAttribute('style','background-color: #c1bdbd');
             document.getElementById('btnCorreoAtrasado').removeAttribute('disabled');
             document.getElementById('btnCorreoAtrasado').removeAttribute('style');
             document.getElementById('DocumentoFiles').removeAttribute('disabled');
             document.getElementById('labelArchivoComprobante').removeAttribute('style');
document.getElementById('DocumentoFilesRecibo').removeAttribute('disabled');
             document.getElementById('labelArchivoProc').removeAttribute('style');


        	;break;
        	case 'tab-3':
              
         document.getElementById('btnCorreoPendiente').setAttribute('disabled',true);             
             document.getElementById('btnCorreoPendiente').setAttribute('style','background-color: #c1bdbd');
             document.getElementById('btnWhats').setAttribute('disabled',true);             
             document.getElementById('btnWhats').setAttribute('style','background-color: #c1bdbd');
             document.getElementById('btnSMS').setAttribute('disabled',true);             
             document.getElementById('btnSMS').setAttribute('style','background-color: #c1bdbd');
             document.getElementById('btnExportar').setAttribute('disabled',true);
             document.getElementById('btnExportar').setAttribute('style','background-color: #c1bdbd');
             document.getElementById('btnBuscarPoliza').setAttribute('disabled',true);
             document.getElementById('btnBuscarPoliza').setAttribute('style','background-color: #c1bdbd');
                          document.getElementById('btnCorreoAtrasado').setAttribute('disabled',true);
             document.getElementById('btnCorreoAtrasado').setAttribute('style','background-color: #c1bdbd');

             document.getElementById('btnAgregarComentario').setAttribute('disabled',true);
             document.getElementById('btnAgregarComentario').setAttribute('style','background-color: #c1bdbd');
             document.getElementById('DocumentoFiles').setAttribute('disabled',true);
             document.getElementById('labelArchivoComprobante').setAttribute('style','background-color: #c1bdbd');
             document.getElementById('DocumentoFilesRecibo').setAttribute('disabled',true);
             document.getElementById('labelArchivoProc').setAttribute('style','background-color: #c1bdbd');
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
{var w = window.outerWidth;var h = window.outerHeight;
	w=w-230; 
 document.getElementById('divContenedorTabla').style.width=w+'px';
}
</script>