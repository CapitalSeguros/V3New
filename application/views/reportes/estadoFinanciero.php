
<?php 
  $this->load->view('headers/header');
  $this->load->view('headers/headerReportes'); 
?>
<?php
  $this->load->view('headers/menu');
?>
<link rel="stylesheet" href="http://code.jquery.com/ui/1.10.1/themes/base/jquery-ui.css" />
<script src="https://code.jquery.com/jquery-1.9.1.js"></script>
<script src="https://code.jquery.com/ui/1.10.1/jquery-ui.js"></script>
<style type="text/css">
  .btn:hover{
    background-color: #DBA901;
    border-color: #DBA901;
  }
</style>
<!--script src="https://capsys.com.mx/V3/assets/js/jquery.easytree.min.js"></script-->
<div><h1>ESTADO FINANCIERO</h1></div><hr>
<table>
	<tr id="trPestania">
		<td onclick="onChangeCambiaPestania(this)" style="display: none">Estado Financiero Mensual</td>
		<td onclick="onChangeCambiaPestania(this)" style="display: none">Avance Estado Financiero</td>
    <td onclick="onChangeCambiaPestania(this)" style="display: none">Reporte Clientes</td>
	</tr>
</table>
<div id="divContenidoPestanias" class="divContenidoPestanias">
	<div>


<div style="background-color: #E6E6E6;border-radius: 8px; margin-left: 1%;padding: 10px;margin-right: 1%;">
  
  <label><i class="fa fa-filter"></i> Filtro: </label><select id="selectCoordinadoresEF" class="buscarEF"></select>
  <br>
  <label><i class="fa fa-calendar"></i> Mes<select id="selectMes" class="buscarEF"></select>
</label>
<label><i class="fa fa-calendar"></i> Año<select id="selectAnio" class="buscarEF">
  <option>1</option>
</select>
</label>
<button onclick="enviarFormGenerales(1);" class="btn btn-primary btn-md" style="border-radius: 8px;"><i class="fa fa-search"></i> Buscar</button>

<div>
<label><i class="fa fa-calendar"></i> Año por agente:<select id="selectAnioPorAgente">
</select></label>
</div>
</div>

<br>
<div style="margin-left:10px;overflow:scroll;height:400px;width:98%; ">
	<table id="tableEstadoFinanciero" border="1" class="tableEFClass table table-responsive"></table>
</div>
</div>
<div>
	
	<div><label>Filtro</label><select id="selectCoordinadores" class="buscarAvanceEF"></select></div>
	<div>
	 <input type="text" class="fechaEstadoFinanciero buscarAvanceEF" name="fecInicialAvanceEF" id="fecInicialAvanceEF" autocomplete="off">     
     <input type="text" class="fechaEstadoFinanciero  buscarAvanceEF" id="fecFinalAvanceEF" autocomplete="off">
     <button onclick="enviarFormGenerales(2)">Buscar</button>
   </div>
   <div style="margin-left:20%;overflow:scroll;height:500px;width:60%; ">
   	 <table id="tableAvanceEF" class="tableEFClass"></table>
   </div>
</div>
<div ><h3>La ultima actualizacion fue el:<?=  $ultimaActualizacion['ultimaActualizacion'][0]->ultimaActualizacion?></h3>
<select id="selectCoordinadoresReporteClientes" class="buscarEF"></select>
<div style="border: solid"><h4>Filtros</h4> <label>Renovacion</label><select id="selectrenovacion"><option value='0'>Nuevas</option><option value='1'>Renovadas</option><option value="-1">Todas</option></select>
<label>Fecha Inicial</label><input type="text" id="fechaInicial" class="fechaPersona" autocomplete="off" value="<?= $fechaInicial;?>">
<label>Fecha Final</label><input type="text" id="fechaFinal" class="fechaPersona" autocomplete="off" value="<?= $fechaFinal;?>">
<label>Liquidado<input type="checkbox" id="checkedLiquidado" checked></label>
<label>Cancelado<input type="checkbox" id="checkedCancelado" checked></label>
<label>Pagado<input type="checkbox" id="checkedPagado" checked></label>
<label>Pendiente<input type="checkbox" id="checkedPendiente" checked></label>
<button onclick="reporteCobranzaCliente('')">Mostrar</button><button onclick="exportar()">Exportar</button>
<label>Fecha filtro:<select id="selectIdFechaFiltro"><option>fDoctoPago</option><option>fHasta</option><option>fDesde</option><option>fLimPago</option><option></option></select></label>
</div>
<hr/>

<div style="width:80%; height: 500px;overflow:scroll; margin-left: 10%">
<table border="1" class="tableEFClass">
  <thead>
    <tr style="height: 50px">
      <th class="divTD50"></th>
      <th class="divTD150">documento</th>
      <th class="divTD150">endoso</th>
      <th class="divTD50">periodo</th>
      <th class="divTD100">serie</th>
      <th class="divTD75">renovacion</th>
      <th class="divTD100">fDesde</th>
      <th class="divTD100">fHasta</th>
      <th class="divTD100">fLimPago</th>
      <th class="divTD100">fStatus</th>
      <th class="divTD100">fDoctoPago</th>
      <th class="divTD100">status_TXT</th>
      <th class="divTD100">primaNeta</th>
      <th class="divTD100">recargos</th>
      <th class="divTD100">derechos</th>
      <th class="divTD100">impuesto1</th>
      <th class="divTD100">primaTotal</th>
      <th class="divTD100">comision0</th>
      <th class="divTD150">anterior</th>
      <th class="divTD100">grupo</th>
      <th class="divTD150">subGrupo</th>
      <th class="divTD150">cCobro_TXT</th>
      <th class="divTD100">statusDoc_TXT</th>
      <th class="divTD400">concepto</th>
      <th class="divTD400">nombreCompleto</th>
      <th class="divTD100">email1</th>
      <th class="divTD150">telefono1</th>
      <th class="divTD400">nombreCompania</th>
      <th class="divTD150">ejecutNombre</th>
      <th class="divTD400">vendNombre</th>
      <th class="divTD75">fPago</th>
      <th class="divTD150">moneda</th>
      <th class="divTD150">sRamoNombre</th>
      <th class="divTD150">ramosNombre</th>
      <th class="divTD100">tipoDocto_TXT</th>
      <th class="divTD100">abreviacionVend</th>
      <th class="divTD75">TCPago</th>

    </tr>
  </thead>
  <tbody id="tbodyReporteClientes"></tbody>
   <tfoot id="tfootReporteClientes"></tfoot>
</table>
</div>
</div>
</div>
<div class="gifEspera ocultarObjeto" id="gifDeEspera"><img src="<?php echo(base_url().'assets\img\loading.gif')?>"></div>

<div id="divModalGenerico" class="modalCierra">
  <div class="modal-btnCerrar"><button onclick="cerrarModal('divModalGenerico')" style="color: white;background-color:red; border:double;">X</button></div>
    <div id="divModalContenidoGenerico" class="modal-contenido"  >

</div>
</div>


<?php 
	$this->load->view('footers/footer'); 
?>
<script type="text/javascript">


  function estadoFinancieroAgente(datos){

   if(datos==-1){   
   var radio=document.getElementsByName('radioBuscarEF');
   var cant=radio.length;
   var valor;
   for(let i=0;i<cant;i++){if(radio[i].checked){valor=radio[i].value;i=cant;}}
    var params = "idPersona="+valor+"&anio="+document.getElementById('selectAnioPorAgente').value+"&ajax=1";
    controlador="reportes/estadoFinancieroAgente/?";
   peticionAJAX(controlador,params,'estadoFinancieroAgente');
   }
   else{
    let total=datos['estadoFinanciero'].length;
    
    let tabla='<table border="1" class="tableEFClass">';
    let mes="mes";
    //let nombre="";
     tabla=tabla+'<thead><tr>';
     tabla=tabla+'<th>'+mes+'</th>';
     tabla=tabla+'<th>Ingresos Totales</th>';
     tabla=tabla+'<th>Costo de Venta</th>';
     tabla=tabla+'<th>Contribucion marginal</th>';
     tabla=tabla+'<th>Gasto de Operacion</th>';
     tabla=tabla+'<th>Utilidad/Perdida</th>';
     tabla=tabla+'<th>Meta de Equipo</th>';
     tabla=tabla+'<th>Comision de venta nueva</th>';     
     tabla=tabla+'</tr></thead><tbody>';
     let sumIT=0;
    for(let i=0;i<total;i++){
     tabla=tabla+'<tr>';
     tabla=tabla+'<td class="EdoFinAgenteClass">'+datos['meses'][datos['estadoFinanciero'][i].mesEAB]+'</td>';
     tabla=tabla+'<td align="right" class="EdoFinIngresoaClass">$'+datos['estadoFinanciero'][i].ingresoTotalesEABFormato+'</td>';
     sumIT=sumIT+datos['estadoFinanciero'][i].ingresoTotalesEAB;
     tabla=tabla+'<td align="right" class="EdoFinIngresoaClass">$'+datos['estadoFinanciero'][i].costoVentaEABFormato+'</td>';
     tabla=tabla+'<td align="right" class="EdoFinIngresoaClass">$'+datos['estadoFinanciero'][i].contribucionMarginalEABFormato+'</td>';
     tabla=tabla+'<td align="right" class="EdoFinIngresoaClass">$'+datos['estadoFinanciero'][i].gastoOperacionEABFormato+'</td>';
     tabla=tabla+'<td align="right" class="EdoFinIngresoaClass">$'+datos['estadoFinanciero'][i].utilidadPerdidaEABFormato+'</td>';
     tabla=tabla+'<td align="right" class="EdoFinMetaClass">$'+datos['estadoFinanciero'][i].metaComercialEABFormato+'</td>';
     tabla=tabla+'<td align="right" class="EdoFinMetaClass">$'+datos['estadoFinanciero'][i].comisionVentaEABFormato+'</td>';
     tabla=tabla+'</tr>';
     nombre=datos['estadoFinanciero'][i].apellidoPaterno+' '+datos['estadoFinanciero'][i].nombres;
    }
    tabla=tabla+'</tbody>';
    tabla=tabla+'<tfoot border="1">';
    tabla=tabla+'<td>SUMA</td>';
    tabla=tabla+'<td align="right">$'+datos.ingresoTotalesEAB+'</td>';
    tabla=tabla+'<td align="right">$'+datos.costoVentaEAB+'</td>';
    tabla=tabla+'<td align="right">$'+datos.contribucionMarginalEAB+'</td>';
    tabla=tabla+'<td align="right">$'+datos.gastoOperacionEAB+'</td>';
    tabla=tabla+'<td align="right">$'+datos.utilidadPerdidaEAB+'</td>';
    tabla=tabla+'<td align="right">$'+datos.metaComercialEAB+'</td>';
    tabla=tabla+'<td align="right">$'+datos.comisionVentaEAB+'</td>';
    tabla=tabla+'</tfoot>';
    tabla=tabla+'</table>';
    document.getElementById('divModalContenidoGenerico').innerHTML='<div>'+nombre+'</div><hr><div>'+tabla+'</div>';
    cerrarModal('divModalGenerico');

   }
  }


  function cerrarModal(modal){
     document.getElementById(modal).classList.toggle('modalCierra');
     document.getElementById(modal).classList.toggle('modalAbre');   
}
function exportar(){
    let liquidado=0,cancelado=0,pagado=0,pendiente=0;
     controlador="reportes/reporteCobranzaCliente/"
     parametros="idPersona="+document.getElementById('selectCoordinadoresReporteClientes').value;
     parametros=parametros+'&fechaInicial='+document.getElementById('fechaInicial').value;
     parametros=parametros+'&fechaFinal='+document.getElementById('fechaFinal').value;
     parametros=parametros+'&renovacion='+document.getElementById('selectrenovacion').value;
     if(document.getElementById('checkedLiquidado').checked){liquidado=1;}
     if(document.getElementById('checkedCancelado').checked){cancelado=1;}
     if(document.getElementById('checkedPagado').checked){pagado=1;}
     if(document.getElementById('checkedPendiente').checked){pendiente=1;}
     parametros=parametros+'&Liquidado='+liquidado;
     parametros=parametros+'&Cancelado='+cancelado;
     parametros=parametros+'&Pagado='+pagado;
     parametros=parametros+'&Pendiente='+pendiente;
     parametros=parametros+'&fechaFiltro='+document.getElementById('selectIdFechaFiltro').value;
 //let url="http://192.168.0.100/Capsys/www/V3/reportes/exportarReporteCobranzaCliente/?idPersona="+document.getElementById('selectCoordinadoresReporteClientes').value;
// let url="http://192.168.0.100/Capsys/www/V3/reportes/exportarReporteCobranzaCliente/?idPersona="+parametros;
 let url="http://192.168.0.100/Capsys/www/V3/reportes/reporteCobranzaCliente/?"+parametros;
 var win = window.open(url, '_blank');

}
function mostrarGifEspera(){
  document.getElementById('gifDeEspera').classList.toggle('ocultarObjeto');document.getElementById('gifDeEspera').classList.toggle('verObjeto');
}
function reporteCobranzaCliente(datos){
  
  if(datos==''){
    let liquidado=0,cancelado=0,pagado=0,pendiente=0;
     controlador="reportes/reporteCobranzaCliente/"
     parametros="idPersona="+document.getElementById('selectCoordinadoresReporteClientes').value;
     parametros=parametros+'&fechaInicial='+document.getElementById('fechaInicial').value;
     parametros=parametros+'&fechaFinal='+document.getElementById('fechaFinal').value;
     parametros=parametros+'&renovacion='+document.getElementById('selectrenovacion').value;
     if(document.getElementById('checkedLiquidado').checked){liquidado=1;}
     if(document.getElementById('checkedCancelado').checked){cancelado=1;}
     if(document.getElementById('checkedPagado').checked){pagado=1;}
     if(document.getElementById('checkedPendiente').checked){pendiente=1;}
     parametros=parametros+'&Liquidado='+liquidado;
     parametros=parametros+'&Cancelado='+cancelado;
     parametros=parametros+'&Pagado='+pagado;
     parametros=parametros+'&Pendiente='+pendiente;
     parametros=parametros+'&fechaFiltro='+document.getElementById('selectIdFechaFiltro').value;
     mostrarGifEspera();
     peticionAJAX(controlador,parametros,'reporteCobranzaCliente');
  }
  else{

   let cantidad=datos.reportecobranzaclientes.length;
   let primaNeta=0,recargos=0,derechos=0,impuesto1=0,primaTotal=0,comision0=0;
   let body="";
   for(let i=0;i<cantidad;i++){
    body=body+'<tr>';
    body=body+'<td>'+(i+1)+'</td>';
    body=body+'<td>'+datos.reportecobranzaclientes[i].documento+'</td>';
    body=body+'<td>'+datos.reportecobranzaclientes[i].endoso+'</td>';
    body=body+'<td>'+datos.reportecobranzaclientes[i].periodo+'</td>';
    body=body+'<td>'+datos.reportecobranzaclientes[i].serie+'</td>';
    body=body+'<td>'+datos.reportecobranzaclientes[i].renovacion+'</td>';
    body=body+'<td>'+datos.reportecobranzaclientes[i].fDesde+'</td>';
    body=body+'<td>'+datos.reportecobranzaclientes[i].fHasta+'</td>';
    body=body+'<td>'+datos.reportecobranzaclientes[i].fLimPago+'</td>';
    body=body+'<td>'+datos.reportecobranzaclientes[i].FDoctoPago+'</td>';
    body=body+'<td>'+datos.reportecobranzaclientes[i].fStatus+'</td>';
    body=body+'<td>'+datos.reportecobranzaclientes[i].status_TXT+'</td>';
    body=body+'<td align="right">'+datos.reportecobranzaclientes[i].primaNeta+'</td>';
    primaNeta=primaNeta+parseFloat(datos.reportecobranzaclientes[i].primaNeta) ;
    body=body+'<td align="right">'+datos.reportecobranzaclientes[i].recargos+'</td>';
    recargos=recargos+parseFloat(datos.reportecobranzaclientes[i].recargos) ;
    body=body+'<td align="right">'+datos.reportecobranzaclientes[i].derechos+'</td>';
    derechos=derechos+parseFloat(datos.reportecobranzaclientes[i].derechos) ;
    body=body+'<td align="right">'+datos.reportecobranzaclientes[i].impuesto1+'</td>';
    impuesto1=impuesto1+parseFloat(datos.reportecobranzaclientes[i].impuesto1) ;
    body=body+'<td align="right">'+datos.reportecobranzaclientes[i].primaTotal+'</td>';
    primaTotal=primaTotal+parseFloat(datos.reportecobranzaclientes[i].primaTotal) ;
    body=body+'<td align="right">'+datos.reportecobranzaclientes[i].comision0+'</td>';
    comision0=comision0+parseFloat(datos.reportecobranzaclientes[i].comision0) ;
    body=body+'<td>'+datos.reportecobranzaclientes[i].anterior+'</td>';
    body=body+'<td>'+datos.reportecobranzaclientes[i].grupo+'</td>';
    body=body+'<td>'+datos.reportecobranzaclientes[i].subGrupo+'</td>';
    body=body+'<td>'+datos.reportecobranzaclientes[i].cCobro_TXT+'</td>';
    body=body+'<td>'+datos.reportecobranzaclientes[i].statusDoc_TXT+'</td>';
    body=body+'<td>'+datos.reportecobranzaclientes[i].concepto+'</td>';
    body=body+'<td>'+datos.reportecobranzaclientes[i].nombreCompleto+'</td>';
    body=body+'<td>'+datos.reportecobranzaclientes[i].email1+'</td>';
    body=body+'<td>'+datos.reportecobranzaclientes[i].telefono1+'</td>';
    body=body+'<td>'+datos.reportecobranzaclientes[i].nombreCompania+'</td>';
    body=body+'<td>'+datos.reportecobranzaclientes[i].ejecutNombre+'</td>';
    body=body+'<td>'+datos.reportecobranzaclientes[i].vendNombre+'</td>';
    body=body+'<td>'+datos.reportecobranzaclientes[i].fPago+'</td>';
    body=body+'<td>'+datos.reportecobranzaclientes[i].moneda+'</td>';
    body=body+'<td>'+datos.reportecobranzaclientes[i].sRamoNombre+'</td>';
    body=body+'<td>'+datos.reportecobranzaclientes[i].ramosNombre+'</td>';
    body=body+'<td>'+datos.reportecobranzaclientes[i].tipoDocto_TXT+'</td>';
    body=body+'<td>'+datos.reportecobranzaclientes[i].abreviacionVend+'</td>';
    body=body+'<td align="right">'+datos.reportecobranzaclientes[i].TCPago+'</td>';
    body=body+'</tr>'; 
   }
     document.getElementById('tbodyReporteClientes').innerHTML=body;
     body='';
   body=body+'<tr>';
    body=body+'<td>Sum</td>';
    body=body+'<td></td>';
    body=body+'<td></td>';
    body=body+'<td></td>';
    body=body+'<td></td>';
    body=body+'<td></td>';
    body=body+'<td></td>';
    body=body+'<td></td>';
    body=body+'<td></td>';
    body=body+'<td></td>';
    body=body+'<td></td>';
    body=body+'<td></td>';
    body=body+'<td align="right" style="color:white;background-color:green">'+primaNeta.toFixed(2)+'</td>';
    body=body+'<td align="right" style="color:white;background-color:green">'+recargos.toFixed(2)+'</td>';
    body=body+'<td align="right" style="color:white;background-color:green">'+derechos.toFixed(2)+'</td>';
    body=body+'<td align="right" style="color:white;background-color:green">'+impuesto1.toFixed(2)+'</td>';
    body=body+'<td align="right" style="color:white;background-color:green">'+primaTotal.toFixed(2)+'</td>';
    body=body+'<td align="right" style="color:white;background-color:green">'+comision0.toFixed(2)+'</td>';
    body=body+'<td></td>';
    body=body+'<td></td>';
    body=body+'<td></td>';
    body=body+'<td></td>';
    body=body+'<td></td>';
    body=body+'<td></td>';
    body=body+'<td></td>';
    body=body+'<td></td>';
    body=body+'<td></td>';
    body=body+'<td></td>';
    body=body+'<td></td>';
    body=body+'<td></td>';
    body=body+'<td></td>';
    body=body+'<td></td>';
    body=body+'<td></td>';
    body=body+'<td></td>';
    body=body+'<td></td>';
    body=body+'<td></td>';
    body=body+'<td align="right"></td>';
    body=body+'</tr>'; 
   document.getElementById('tfootReporteClientes').innerHTML=body;
   mostrarGifEspera();
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
          case 'estadoFinancieroAgente':estadoFinancieroAgente(respuesta);break;
          case 'reporteCobranzaCliente':reporteCobranzaCliente(respuesta);break;

         }                                                           
      }     
   }
  };
 req.send(parametros);
}




function onChangeCambiaPestania(elemento)
{
 var contenido=document.getElementById("divContenidoPestanias");
 var cantContenido=contenido.childNodes.length;
 for(var i=0;i<cantContenido;i++){contenido.childNodes[i].classList.remove('verObjeto');contenido.childNodes[i].classList.add('ocultarObjeto');}
 	contenido.childNodes[elemento.cellIndex].classList.add('verObjeto');
  contenido=elemento.parentNode;

 cantContenido=elemento.parentNode.childNodes.length;
 for(var i=0;i<cantContenido;i++){
  contenido.childNodes[i].classList.add('pestaniaSuelta');contenido.childNodes[i].classList.remove('pestaniaOprimida')
 }
 contenido.childNodes[elemento.cellIndex].classList.add('pestaniaOprimida');
  contenido.childNodes[elemento.cellIndex].classList.remove('pestaniaSuelta');
}

function aplicarFiltro(objeto,select)
{var tablaBody=objeto.parentNode.parentNode.parentNode,cantRows=tablaBody.childNodes.length,cellCheck=objeto.parentNode.cellIndex,textBuscar=select.value;
	if(objeto.checked){
		  for(var i=1;i<cantRows;i++)
	  {	var cadena=tablaBody.childNodes[i].cells[cellCheck].innerHTML;	 
	 	
	  	if(cadena.indexOf(textBuscar)==0)
	  	{tablaBody.childNodes[i].classList.add('verObjetoTabla'); tablaBody.childNodes[i].classList.remove('ocultarObjeto');}
	  	else
	  	{tablaBody.childNodes[i].classList.add('ocultarObjeto');tablaBody.childNodes[i].classList.remove('verObjetoTabla');}
	  }
	}
	else{
	  for(var i=1;i<cantRows;i++){
	  	tablaBody.childNodes[i].classList.remove('ocultarObjeto');
	  	  	tablaBody.childNodes[i].classList.add('verObjetoTabla')
	  }
	}

}
	function enviarFormGenerales(accion){
  var direccion="";var clase="";
  switch(accion){
  case 1:direccion=<?php echo('"'.base_url().'reportes/buscarEstadoFinanciero"'); ?>;clase="buscarEF";break;
  case 2:direccion=<?php echo('"'.base_url().'reportes/buscarAvanceEstadoFinanciero"')?>;clase="buscarAvanceEF";document.getElementById('gifDeEspera').classList.remove('ocultarObjeto');document.getElementById('gifDeEspera').classList.add('verObjeto');break; 
    }
  var formulario=document.createElement('form'); formulario.setAttribute('method','post'); formulario.action=direccion;
  objetosForm=document.getElementsByClassName(clase);objetos="";cant=objetosForm.length;
  for(var i=0;i<cant;i++){
  tipo=objetosForm[i].nodeName;
  var objeto=document.createElement('input');
      objeto.setAttribute('type','hidden'); 
      objeto.name=objetosForm[i].id;objeto.value=objetosForm[i].value;formulario.appendChild(objeto);
 
  }
  document.body.appendChild(formulario);
  formulario.submit();
}

	<?php 
	$cad="";
  $fechaActual=getdate()['year'];
	foreach ($meses as $key => $value) {$cad=$cad.'<option value="'.$key.'">'.$value.'</option>';} 
	echo('document.getElementById("selectMes").innerHTML=\''.$cad.'\';');

	$cad="";

	foreach ($anios as $key => $value) {$cad=$cad.'<option value="'.$key.'">'.$value.'</option>';} 
	echo('document.getElementById("selectAnio").innerHTML=\''.'<option value='.$fechaActual.'>'.$fechaActual.'</option>'.$cad.'\';');
    $cad="";
  foreach ($anios as $key => $value) {($key==$fechaActual) ? $cad=$cad.'<option value="'.$key.'" selected>'.$value.'</option>':$cad=$cad.'<option value="'.$key.'">'.$value.'</option>';} 
  echo('document.getElementById("selectAnioPorAgente").innerHTML=\''.$cad.'\';');

   $cad="";

	foreach ($coordinadoresReportes as  $value) {$cad=$cad.'<option>'.$value->email.'</option>';} 
	echo('document.getElementById("selectCoordinadores").innerHTML=\''.$cad.'\';');
	echo('document.getElementById("selectCoordinadoresEF").innerHTML=\''.$cad.'\';');
  echo('document.getElementById("selectCoordinadoresReporteClientes").innerHTML=\''.$cad.'\';');
  
   if(isset($idPersona)){echo('document.getElementById("selectCoordinadores").value="'.$idPersona.'";');echo('document.getElementById("selectCoordinadoresEF").value="'.$idPersona.'";');}

	?>
	
	<?php 
	  $option="";
     if(isset($anioEscogido)){echo('document.getElementById("selectAnio").value='.$anioEscogido.';');}
     if(isset($mesEscogido)){echo('document.getElementById("selectMes").value='.$mesEscogido.';');}
      
     echo('document.getElementById("fecInicialAvanceEF").value=\''.$fecInicialAvance.'\';');
     echo('document.getElementById("fecFinalAvanceEF").value=\''.$fecFinalAvance.'\';');
     if(isset($estadoFinanciero)){
     	$row="";
      
     	//modificar miguel jaime 20/07/2020
     	$row=$row.'<thead><tr>';
      $row=$row.'<th>#</th>';
      $row=$row.'<th data-order="" data-tipo="string" onclick="ordenaTabla(this)" class="celdaOrdena">Agente</th>';
      $row=$row.'<th data-order="" data-tipo="digito" onclick="ordenaTabla(this)" class="celdaOrdena">Ingresos totales</th>';
      $row=$row.'<th data-order="" data-tipo="digito" onclick="ordenaTabla(this)" class="celdaOrdena">Costo de venta</th>';
      $row=$row.'<th data-order="" data-tipo="digito" onclick="ordenaTabla(this)" class="celdaOrdena">Contribucion Marginal</th>';
      $row=$row.'<th data-order="" data-tipo="digito" onclick="ordenaTabla(this)" class="celdaOrdena">Gastos de operacion</th>';
      $row=$row.'<th data-order="" data-tipo="digito" onclick="ordenaTabla(this)" class="celdaOrdena">Utilidad/Perdida</th>';
      $row=$row.'<th data-order="" data-tipo="digito" onclick="ordenaTabla(this)" class="celdaOrdena">META DE EQUIPO</th>';
      $row=$row.'<th data-order="" data-tipo="digito" onclick="ordenaTabla(this)" class="celdaOrdena">Comision por venta nueva</th>';
      $row=$row.'<th data-order="" data-tipo="digito" onclick="ordenaTabla(this)" class="celdaOrdena">% contribucion</th>';
      $row=$row.'<th data-order="" data-tipo="string" onclick="ordenaTabla(this)" class="celdaOrdena">Ranking</th>';
      $row=$row.'<th data-order="" data-tipo="string" onclick="ordenaTabla(this)" class="celdaOrdena">Tipo agente</th>';
      $row=$row.'<th><label>Canal</label><select id="selectFiltroCanal"  onchange="aplicarFiltro(this.nextSibling,this)" class="selectFiltroTabla"></select><input type="checkbox" id="cc" onclick="aplicarFiltro(this,selectFiltroCanal)" ><label>Filtro</label></th>';
      $row=$row.'<th data-order="" data-tipo="string" onclick="ordenaTabla(this)" class="celdaOrdena">Sucursal</th></tr></thead><tbody>';
     	$cont=0;
     	$row=$row.'</tr>';
     	$sumIT=0;
     	$sumCV=0;
     	$sumCM=0;
     	$sumGO=0;
     	$sumU=0;
     	$sumCVN=0;
    //$row=$row.'<tbody>';class="cbFiltroTabla"
 
     foreach ($estadoFinanciero as  $value) {
      	$cont++;
       $row=$row.'<tr>';
       $row=$row.'<td class="EdoFinAgenteClass"><input type="radio" name="radioBuscarEF" id="radioBuscarEF" value="'.$value->idPersona.'" onclick="estadoFinancieroAgente(-1)"></td>';
        $row=$row.'<td class="EdoFinAgenteClass" >'.$value->nombres.'</td>';
        $row=$row.'<td align="right" class="EdoFinIngresoaClass" data-valor="'.$value->ingresoTotalesEAB.'">$'.number_format($value->ingresoTotalesEAB,2).'</td>';
        $sumIT=$sumIT+$value->ingresoTotalesEAB;
        $row=$row.'<td align="right" class="EdoFinIngresoaClass" data-valor="'.$value->costoVentaEAB.'">$'.number_format($value->costoVentaEAB,2).'</td>';
        $sumCV=$sumCV+$value->costoVentaEAB;
        $row=$row.'<td align="right" class="EdoFinIngresoaClass" data-valor="'.$value->contribucionMarginalEAB.'">$'.number_format($value->contribucionMarginalEAB,2).'</td>';
        $sumCM=$sumCM+$value->contribucionMarginalEAB;
        $row=$row.'<td align="right" class="EdoFinIngresoaClass" data-valor="'.$value->gastoOperacionEAB.'">$'.number_format($value->gastoOperacionEAB,2).'</td>';
        $sumGO=$sumGO+$value->gastoOperacionEAB;
        $row=$row.'<td align="right" class="EdoFinIngresoaClass" data-valor="'.$value->utilidadPerdidaEAB.'">$'.number_format($value->utilidadPerdidaEAB,2).'</td>';
        $sumU=$sumU+$value->utilidadPerdidaEAB;
        $row=$row.'<td align="right" class="EdoFinMetaClass" data-valor="'.$value->metaComercialEAB.'">$'.number_format($value->metaComercialEAB,2).'</td>';
  
        $row=$row.'<td align="right" class="EdoFinMetaClass" data-valor="'.$value->comisionVentaEAB.'">$'.number_format($value->comisionVentaEAB,2).'</td>';
              $sumCVN=$sumCVN+$value->comisionVentaEAB;
        $row=$row.'<td align="right" class="EdoFinMetaClass" data-valor="'.$value->contribucionEAB.'">'.$value->contribucionEAB.'%</td>';
        $row=$row.'<td align="right" class="EdoFinAgenteClass">'.$value->idpersonarankingagente.'</td>';
        $row=$row.'<td align="right" class="EdoFinAgenteClass">'.$value->personaTipoAgente.'</td>';
         $row=$row.'<td align="right" class="EdoFinAgenteClass">'.$value->nombreTitulo.'</td>';
          $row=$row.'<td align="right" class="EdoFinAgenteClass">'.$value->NombreSucursal.'</td>';
       $row=$row.'</tr>';		
     }
     //$row=$row.'</tbody>';
      $row=$row.'</tbody><tfoot><tr>';
        $row=$row.'<td>Total: '.$cont.' Agentes</td>';
        $row=$row.'<td></td>';
        $row=$row.'<td align="right">$'.number_format($sumIT,2).'</td>';
        $row=$row.'<td align="right">$'.number_format($sumCV,2).'</td>';
        $row=$row.'<td align="right">$'.number_format($sumCM,2).'</td>';
        $row=$row.'<td align="right">$'.number_format($sumGO,2).'</td>';
        $row=$row.'<td align="right">$'.number_format($sumU,2).'</td>';
        $row=$row.'<td></td>';
        $row=$row.'<td align="right">$'.number_format($sumCVN,2).'</td>';
        $row=$row.'<td></td>';
        $row=$row.'<td></td>';
        $row=$row.'<td></td>';
        $row=$row.'<td></td>';
        $row=$row.'<td></td>';
      $row=$row.'</tr></tfoot>';
     	echo('document.getElementById("tableEstadoFinanciero").innerHTML=\''.$row.'\';');
	?>
	<?php
    
     foreach ($canales as  $value) {
     	$option=$option.'<option>';
        $option=$option.$value->nombreTitulo;  
     	$option=$option.'</option>';
     }
     echo('document.getElementById(\'selectFiltroCanal\').innerHTML="'.$option.'";');}
      if(isset($avanceEF)){echo('document.getElementById(\'tableAvanceEF\').innerHTML='."'".$avanceEF."';");
    
     foreach ($canales as  $value) {
     	$option=$option.'<option>';
        $option=$option.$value->nombreTitulo;  
     	$option=$option.'</option>';
     }
      echo('document.getElementById(\'selectFiltroCanalAvance\').innerHTML="'.$option.'";');}
	?>


 function borrarNodosText(elemento){
 	for(var i=0;i<document.getElementById(elemento).childNodes.length;i++){if(document.getElementById(elemento).childNodes[i].nodeName=="#text"){document.getElementById(elemento).removeChild(document.getElementById(elemento).childNodes[i]);}}}
 borrarNodosText("divContenidoPestanias");
 borrarNodosText("trPestania");
</script>
  <link rel="stylesheet" href="//code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
  <link rel="stylesheet" href="/resources/demos/style.css">
  <script src="https://code.jquery.com/jquery-1.12.4.js"></script>
  <script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>

<script type="text/javascript">
$(function () {$(".fechaEstadoFinanciero").datepicker({
  closeText: 'Cerrar',prevText: 'Anterior',nextText: 'Siguiente',currentText: 'Hoy',
  monthNames: ['Enero','Febrero','Marzo','Abril','Mayo','Junio','Julio','Agosto','Septiembre','Octubre','Noviembre','Diciembre'],
  dayNames:['Domingo','Lunes','Martes','Mi&eacute;rcoles','Jueves','Viernes','S&aacute;bado'] ,
  dayNamesShort:['Dom','Lun','Mar','Mi&eacute;','Juv','Vie','S&aacute;b'],
  dayNamesMin: ['Do','Lu','Ma','Mi','Ju','Vi','S&aacute;'],
  dateFormat: 'dd/mm/yy',
  firstDay: 1,       
});
});
<?php echo('onChangeCambiaPestania(document.getElementById("trPestania").cells['.$trPestania.']);');	?>

function ordenaTabla(objeto){
    var lista =objeto.parentNode.parentNode.parentNode;//document.getElementById("tableEstadoFinanciero");
    var body=objeto.parentNode.parentNode.nextSibling;
    var n, i, k, aux;
    var formaOrdenar="";
    n = body.rows.length;
    var index=objeto.cellIndex;
   
      if(objeto.getAttribute('data-order')==''){formaOrdenar='Desc';}

switch(objeto.getAttribute('data-order')){
  case 'Desc':formaOrdenar='Asc';break;
  case 'Asc':formaOrdenar='Desc';break;
  default : formaOrdenar='Desc'; break;

}

    if(objeto.getAttribute('data-tipo')=='digito'){
  
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

            if (body.rows[i].cells[index].innerHTML.toLowerCase() < body.rows[i+1].cells[index].innerHTML.toLowerCase()){body.rows[i].parentNode.insertBefore(body.rows[i + 1], body.rows[i]);}
        }
      }else{
                 for (i = 0; i < (n - k); i++) {    

            if (body.rows[i].cells[index].innerHTML.toLowerCase() > body.rows[i+1].cells[index].innerHTML.toLowerCase()){body.rows[i].parentNode.insertBefore(body.rows[i + 1], body.rows[i]);}
        }
      }
    }
    }
 objeto.setAttribute('data-order',formaOrdenar);
}


$(function () {$(".fechaPersona").datepicker({
  closeText: 'Cerrar',prevText: 'Anterior',nextText: 'Siguiente',currentText: 'Hoy',
  monthNames: ['Enero','Febrero','Marzo','Abril','Mayo','Junio','Julio','Agosto','Septiembre','Octubre','Noviembre','Diciembre'],
  dayNames:['Domingo','Lunes','Martes','Mi&eacute;rcoles','Jueves','Viernes','S&aacute;bado'] ,
  dayNamesShort:['Dom','Lun','Mar','Mi&eacute;','Juv','Vie','S&aacute;b'],
  dayNamesMin: ['Do','Lu','Ma','Mi','Ju','Vi','S&aacute;'],
  dateFormat: 'dd/mm/yy',
  monthNamesShort:['Ene','Feb','Mar','Abr','May','Jun','Jul','Ago','Sep','Oct','Nov','Dic'],
  firstDay: 1,  
     changeMonth: true,
    changeYear: true,     
});
});


</script>

<style type="text/css">


	.tableEFClass tr:nth-child(even) { background: #ddd }
	.tableEFClass tr>th{background-color: #472280; color:white; }
	.tableEFClass tr:nth-child(odd) { background: #fff}
	.headTabla{background-color: #472280}
  .celdaOrdena{color:green;background-color: #472280}
  .celdaOrdena:hover {background-color: #d9cded;cursor: pointer;}
	.EdoFinAgenteClass{border: groove 2px black;;background-color:#fbfbfb;color: black;font-weight:lighter;}	
	.EdoFinIngresoaClass{border: groove 2px green;background-color:#9ddc9d;color: black;font-weight:lighter;}
	.EdoFinMetaClass{border: groove 2px red;background-color:#ff9090;color: black;font-weight:lighter;}
	.ocultarObjeto{display: none}
	.verObjeto{display: block;}
	.verObjetoTabla{display: table-row;}
	.pestaniaOprimida{   border: outset 2px #1b073c; background-color: #fff; z-index: 1000; display: block;width: 150px;height: 20px;font-size: .9em;  }
	.pestaniaSuelta{border: outset 3px #7858a9; color: #0275d8; background-color: #ffffff; width: 150px; cursor: pointer;font-size: .9em;}
	.divContenidoPestanias{border:solid 1px #dddddd;position: relative;top: 10px}
	.gifEspera{position: absolute;left: 50%;top:70%;}
	.selectFiltroTabla{color: black}
.modal-btnCerrar{background-color:white;width:800px;padding: 0% 0%;margin: 0% auto;position: relative;z-index: 1000 }
.modal-contenido{background-color:white;width:800px;height:100%;padding: 0% 0%;margin: 0% auto;position: relative;z-index: 1000 }
.modalCierra{background-color: rgba(0,0,0,.8);position:fixed;top:0;right:0;bottom:0px;left:0;opacity:0;transition: all 1s;display:none;z-index: 1000}
.modalAbre{background-color: rgba(0,0,0,.8);position:fixed;top:0;right:0;bottom:0px;left:-100;transition: all 1s;width:100%;height:100%;display:block;relative;z-index: 1000}
.labelEditar{display: block; }
.labelEditar input{width: 100%; border: solid 1px black; color: black; background-color: #d7d1e1}

  .divTD50{width:50px;max-width: 50px;min-width: 50px}
  .divTD75{width:75px;max-width: 75px;min-width: 75px}
  .divTD100{width:100px;max-width: 100px;min-width: 100px}
  .divTD150{width:150px;max-width: 150px;min-width: 150px}
  .divTD150{width:200px;max-width: 200px;min-width: 200px}
  .divTD150{width:300px;max-width: 300px;min-width: 300px}
  .divTD400{width:400px;max-width: 400px;min-width: 400px}

  #tbodyReporteClientes > tr{color:black;height: 10px}



</style>
