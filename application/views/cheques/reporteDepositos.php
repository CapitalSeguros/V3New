<?php $this->load->view('headers/header'); ?>
<?php $this->load->view('headers/menu');?>
<script src="https://code.jquery.com/jquery-3.2.1.js"></script>
<script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>
<script src="https://unpkg.com/xlsx@latest/dist/xlsx.full.min.js"></script>
<script type="text/javascript" src="https://unpkg.com/file-saverjs@latest/FileSaver.min.js"></script>
<script type="text/javascript" src="https://unpkg.com/tableexport@latest/dist/js/tableexport.min.js"></script>
<div id="divContenido"><br>
	<div id="contenedorHojasDiv" style="height: 300px;width: 100%;overflow: scroll;">
		<div id="reporteDiarioBancosDiv" name="divContenedorPestania">
	<div id="cabeceraDiv" class="row"><div class="col-sm-3 col-md-3"><input type="date" name="" id="fechaBusqueda" class="form-control" onchange="cambiaFecha(this.value)" value=<?=date('Y').'-'.date('m').'-'.date('d')?>></div><div class="col-sm-1 col-md-1"><button class="btn btn-success" onclick="depositosTbody('')">BUSCAR</button></div><div class="col-sm-1 col-md-1"><input  type="button" class="btn btn-success" onclick="tableToExcel('testTable', 'W3C Example Table')" value="Exportar" /></div><div class="col-sm-1 col-md-1"><input  type="button" class="btn btn-danger" onclick="guardarMontoInicial()" value="GUARDAR MONTO INICIAL" /></div><hr></div>

	<div id="datosDiv">
		<table border="1" class="ExcelTable2007" id="testTable">			
			<tbody id="depositosTbody" >


			</tbody>
		</table>

	</div>
	<div id="mydiv">
 <div id="mydivheader"><button onclick="borrarContenidoDivMovible()">&#128686</button></div>
  <div id="divMovibleContenido"></div>
</div>
</div>
<div id="posicionDiariaBancosResumen" name="divContenedorPestania" class="ocultarObjeto">
	<table class="table">
		<thead>
			<tr><th colspan="6">POSICION DIARIA DE BANCOS RESUMEN</th></tr>
			<tr><th colspan="6">FECHA</th></tr>
		</thead>
		<tbody>
			<tr><td>BANCO</td><td>TIPO DE CUENTA</td><td>SALDO ANTERIOR</td><td>DEPOSITOS</td><td>TRASFERENCIA<br>CHEQUES<br>CARGOS</td><td>SALDO ACTUAL</td></tr>
			<tr><td>BANCOMER</td><td>CHEQUES</td><td align="right"><label id="montoInicialResumen"></label></td><td align="right"><label id="depositosResumen"></label></td><td align="right"><label id="trasferenciaChequeCargosResumen"></label></td><td align="right"><label id="sumaResumen"></label></td></tr>
			<tr><td>VE POR MAS</td><td>INVERSION</td><td align="right"><label id="saldAnteriorPDBR"></label></td><td align="right"><label id="depositoAnteriorPDBR"></label></td><td align="right"><label id="bajaInversionResumen"></label></td><td align="right"><label id="sumaResumenBXM"></label></td></tr>
			<tr><td colspan="2">TOTALES</td><td align="right"><label id="sumTotalSAntPDBR"></label></td><td align="right"><label id="sumTotalDepPDBR"></label></td><td align="right"><label id="sumTotalTCCPDBR"></label></td><td align="right"><label id="sumTotalSActPDBR"></label></td></tr>
		</tbody>
	</table>
</div>

<div id="posicionDiariaBancos" name="divContenedorPestania" class="ocultarObjeto">
	<table class="posDiarioBanclsClass">
		<thead>
			               <tr><td colspan="6">GAP AGENTE DE SEGUROS Y DE FIANZAS</td></tr>
               <tr><td colspan="6">POSICION DIARIA DE BANCOS</td></tr>
               <tr><td colspan="6">VE POR MAS</td></tr>
               <tr><td colspan="6"></td></tr>
               <tr><td colspan="6">FECHA</td></tr>
               <tr><td colspan="4">SALDA ANTERIOR</td><td align="right"><label type="text" id="saldoAnteriorBX"></label></td><td></td></tr>
               <tr><td colspan="6"></td></tr>
               <tr><td colspan="6">DEPOSITOS</td></tr>
               <tr><td colspan="4">CONCEPTO</td><td>HOY</td><td>ACUMULADO DEL MES</td></tr>
         </thead>
        <tbody id="tbodyBX">

		</tbody>
	</table>
</div>
</div>

</div>
<div style="height: 20px;width: 100%"  >
	<button onclick="ocultarPestania('reporteDiarioBancosDiv')">REP DIARIO BANCOS</button>
	<button onclick="ocultarPestania('posicionDiariaBancos')">POSICION DIARIA BANCOS BX+</button>
	<button onclick="ocultarPestania('posicionDiariaBancosResumen')">POSICION DIARIA BANCOS RESUMEN</button>

</div>
</div>

<div id="miModalCD" class="modalCierraGenerico" ><div id="ModalcontenidoCD" class="modal-contenidoGenerico"  ><div><img src="<?=base_url()?>assets/img/loading.gif"></div></div></div>
<script type="text/javascript">
	let diaGlobal="";var mesGlobal="";var anioGlobal="";var anioPasadoGlobal="";
</script>
<script type="text/javascript">
	var fechaGlobal="<?=date('Y').'-'.date('m').'-'.date('d')?>";
function ocultarPestania(pestania)
{
  let pest=document.getElementsByName('divContenedorPestania');
  pest.forEach(p=>{p.classList.add('ocultarObjeto')})
 document.getElementById(pestania).classList.remove('ocultarObjeto'); 	
}	
function borrarContenidoDivMovible()
{
	document.getElementById('divMovibleContenido').innerHTML='';
	document.getElementById('divMovibleContenido').classList.remove("divMovibleContenido");
}


function depositosTbody(data='')
{
	if(data=='')
	{
      let parametros='';
    parametros=parametros+'?fecha='+document.getElementById('fechaBusqueda').value;
    //parametros=parametros+'&idPersona=0';
    peticionAJAX('cheques/bancosDepositos/',parametros,'depositosTbody');
	}	
	else{
		      diaGlobal=data.dia;
      mesGlobal=data.mes;
      anioGlobal=data.anio;
      anioPasadoGlobal=data.anioPasado;

		let sumHoy=0,sumMes=0,sumAnio=0,sumPasado=0;
		let montoInicialAnio=parseFloat(data.montoInicialAnio);
		let montoInicialBX=parseFloat(data.montoInicialAnioBX);;
		let facturasAnio=parseFloat(data.facturasAnio);
		let altaInversionAnio=parseFloat(data.altaInversionAnio);



		fechaGlobal=data.fecha;

	let tr=`<tr><td colspan="8" align="center">GAP AGENTE DE SEGUROS Y FIANZAS</td></tr><tr><td colspan="8" ></td></tr>`;
	tr+=`<tr><td colspan="8" align="center">POSICION DIARA DE BANCOS</td></tr>`;
	tr+=`<tr><td colspan="8"  align="center" color="yellow"><font color="yellow">CUENTA No. 0154834054     BANCOMER</font></td></tr>`;
	tr+=`<tr style="background-color:#FCD5B4"><td colspan="8" align="center">${data.fecha}</td></tr>`;

	//MONTO INICIAL DEL AÑO
	tr+=`<tr><td colspan="4" align="center">MONTO INICIAL DEL AÑO</td><td>$ <input type="text" id="montoInicialText" value="${montoInicialAnio.toFixed(2)}" style="width:80%"></td><td></td><td></td><td></td></tr>`;
	tr+=`<tr><td colspan="8" style="background-color: #00FF00" align="center">DEPOSITOS</td></tr>`;
	tr+=`<tr><td colspan="4">Concepto</td><td>HOY</td><td style="background-color: #0000FF">ACUMULADO DE MES</td><td style="background-color: #FFFF00">ACUMULADO DE MES A MES</td><td style="background-color: #FF00FF">ACUMULADO 2020</td></tr>`;

	//DEPOSITOS

	data.companias.forEach(c=>{
        let hoy=parseFloat(c.hoy);
        let mes=parseFloat(c.mes);
        let anio=parseFloat(c.anio)
        let anioPasado=parseFloat(c.anioPasado)

		tr+=`<tr data-idpromotoria="${c.idPromotoria}"><td>${data.fecha}</td><td>${c.tipo}</td><td>${c.Promotoria}</td><td>comision</td><td align="right"  data-busqueda="d" onclick="traerPartidas(this,'depositos')" class="tdComision">${devolverCantidad(hoy)}</td><td align="right" data-busqueda="m" onclick="traerPartidas(this,'depositos')" class="tdComision">${devolverCantidad(mes)}</td><td align="right" data-busqueda="a" onclick="traerPartidas(this,'depositos')" class="tdComision">${devolverCantidad(anio)}</td><td align="right" data-busqueda="ap" onclick="traerPartidas(this,'depositos')" class="tdComision">${devolverCantidad(anioPasado)}</td>`;
		sumHoy=parseFloat(sumHoy)+parseFloat(c.hoy);
		sumMes=parseFloat(sumMes)+parseFloat(c.mes);
		sumAnio=parseFloat(sumAnio)+parseFloat(c.anio);
		sumPasado=parseFloat(sumPasado)+parseFloat(c.anioPasado)

	})
	let bajaInversionHoy=parseFloat(data.bajaInversionHoy);
	let bajaInversionMes=parseFloat(data.bajaInversionMes);
	let bajaInversionAnio=parseFloat(data.bajaInversionAnio);
	let bajaInversionPasado=parseFloat(data.bajaInversionPasado);
	let altaInversionMes=parseFloat(data.altaInversionMes);

     let interesMenosRetencionHoy=parseFloat(data.interesPagadoHoy)-parseFloat(data.retencionSRHoy);
     
     

     tr+=`<tr style="background-color: #00FFFF"><td colspan="4">TOTAL DE INGRESO POR COMISION</td><td align="right">${devolverCantidad(sumHoy)}</td><td align="right">${devolverCantidad(sumMes)}</td><td align="right">${devolverCantidad(sumAnio)}</td><td align="right">${devolverCantidad(sumPasado)}</td>`;
     tr+=`<tr><td colspan="8" ></td></tr>`;
 
     tr+=`<tr style="background-color: #F2DCDB"><td></td><td></td><td>BX+</td><td>Se baja inversion</td><td align="right">${devolverCantidad(bajaInversionHoy)}</td><td align="right">${devolverCantidad(bajaInversionMes)}</td><td align="right">${devolverCantidad(bajaInversionAnio)}</td><td align="right">${devolverCantidad(bajaInversionPasado)}</td></tr>`;
     //EL TOTAL DE DEPOSITOS  QUE SON LAS COMISIONES+LA BAJA DE INVERSION    ((bajaInversionPasado+sumPasado)==0?'0.00':(new Intl.NumberFormat("en-MX")).format((bajaInversionPasado+sumPasado)
     tr+=`<tr style="background-color: #00FF00"><td colspan="4">TOTAL DE DEPOSITOS</td><td align="right">${devolverCantidad(bajaInversionHoy+sumHoy)}</td><td align="right">${devolverCantidad(bajaInversionMes+sumMes)}</td><td align="right">${devolverCantidad(bajaInversionAnio+sumAnio)}</td><td align="right">${devolverCantidad(bajaInversionPasado+sumPasado)}</td>`;

          tr+=`<tr><td colspan="8" ></td></tr>`;
          tr+=`<tr><td colspan="8" ></td></tr>`;
     //COMIENZA CHEQUES Y/O CARGOS QUE SON LAS FACTURAS+SUBIDA DE INVERSION
     tr+=`<tr><td colspan="5" style="background-color: #C4D79B" ><label style="color:black">CHEQUE Y/O CARGOS</label></td><td></td><td></td><td></td></tr>`;
	  let sumCargos=0;
	  let sumFacturas=0;
	
	 //FACTURAS DE LA FECHA CONSULTADA ES POR DIA
	  data.facturasHoyDocumentos.forEach(f=>{
	  	     tr+=`<tr><td>${data.fecha}</td><td></td><td>${f.NombreProveedor}</td><td>${f.concepto}</td><td align="right">${devolverCantidad(f.totalconiva)}</td><td></td><td></td><td></td></tr>`;
	  	     sumFacturas=parseFloat(sumFacturas)+parseFloat(f.totalconiva);

	  })
              
        let altaInversionHoy=parseFloat(data.altaInversionHoy);
        let facturasMes=parseFloat(data.facturasMes);

     //SUBIDA DE INVERSIO DE LA FECHA CONSULTADA ES POR DIA
	       tr+=`<tr style="background-color: #F2DCDB"><td>${data.fecha}</td><td></td><td>BX+</td><td>Se sube la inversion</td><td align="right">${devolverCantidad(altaInversionHoy)}</td><td align="right"></td><td align="right"></td><td align="right"></td></tr>`;        
     sumCargos=parseFloat(sumFacturas)+parseFloat(altaInversionHoy);
     tr+=`<tr><td colspan="4" style="background-color: #C4D79B" ><label style="color:black">TOTAL CHEQUE Y/O CARGOS</label></td><td align="right" style="background-color: #C4D79B">${devolverCantidad(sumCargos)}</td><td></td><td></td><td></td></tr>`;
     tr+=`<tr><td colspan="8" ></td></tr>`;
  //SALDO ACTUAL

     tr+=`<tr><td colspan="4" style="background-color: #00B0F0" ><label style="color:black">SALDO ACTUAL</label></td><td align="right" style="background-color: #00B0F0">${devolverCantidad(((bajaInversionHoy+sumHoy+montoInicialAnio)-(sumFacturas+altaInversionHoy)))}</td><td></td><td></td><td></td></tr>`;
   //TOTAL DE IGRESOS POR COMISION
     tr+=`<tr><td colspan="8" ></td></tr>`;
     tr+=`<tr><td colspan="4" style="background-color: #FFFF00" ><label style="color:black">TOTAL DE INGRESOS POR COMISIONES AL ${data.fecha}</label></td><td align="right" style="background-color: #FFFF00">${devolverCantidad(sumMes)}</td><td></td><td></td><td></td></tr>`;
     tr+=`<tr><td colspan="8" ></td></tr>`;
     //TOTAL DE PAGO A PROVEEDORES
     tr+=`<tr><td colspan="4" style="background-color: #FFC000" ><label style="color:black">TOTAL PAGO PROVEEDORES ${data.fecha}</label></td><td align="right" style="background-color: #FFC000">${devolverCantidad(facturasMes)}</td><td></td><td></td><td></td></tr>`;
     
     tr+=`<tr><td colspan="8" ></td></tr>`;
     tr+=`<tr><td colspan="8" ></td></tr>`;
     tr+=`<tr><td colspan="8" style="display:flex"><input type="text"  style="flex:6" id="montoInicialBX"><input type="date"  id="fechaInicialBX" style="flex:2" value="${fechaGlobal}"><button  style="flex:1;width:100%" onclick="guardarMontoInicialBX()" >&#128190</button></td></tr>`;


	document.getElementById('depositosTbody').innerHTML=tr;
	document.getElementById('montoInicialResumen').innerHTML=devolverCantidad(montoInicialAnio.toFixed(2));

	document.getElementById('depositosResumen').innerHTML=devolverCantidad(bajaInversionHoy+sumHoy);
	document.getElementById('trasferenciaChequeCargosResumen').innerHTML=devolverCantidad(sumCargos);
	document.getElementById('sumaResumen').innerHTML=devolverCantidad(montoInicialAnio+bajaInversionHoy+sumHoy-sumCargos);

	document.getElementById('bajaInversionResumen').innerHTML=devolverCantidad(parseFloat(bajaInversionHoy)+parseFloat(data.retencionSRHoy));
	
	document.getElementById('saldoAnteriorBX').innerHTML=devolverCantidad(data.montoInicialAnioBX);
	document.getElementById('saldAnteriorPDBR').innerHTML=devolverCantidad(parseFloat(data.montoInicialAnioBX));
	document.getElementById('depositoAnteriorPDBR').innerHTML=devolverCantidad(parseFloat(altaInversionHoy)+parseFloat(data.interesPagadoHoy));
	document.getElementById('sumaResumenBXM').innerHTML=devolverCantidad(parseFloat(data.montoInicialAnioBX)+parseFloat(altaInversionHoy)-parseFloat(bajaInversionHoy)+parseFloat(interesMenosRetencionHoy));

	let trBX='';
	  trBX=`<tr><td colspan="4">Se baja inversion</td><td align="right">${devolverCantidad(bajaInversionHoy)}</td><td align="right">${devolverCantidad(bajaInversionMes)}</td></tr>`;
	  trBX+=`<tr><td colspan="4">Se sube inversion</td><td align="right">${devolverCantidad(altaInversionHoy)}</td><td align="right">${devolverCantidad(altaInversionMes)}</td></tr>`;
	  document.getElementById('tbodyBX').innerHTML=trBX;

	  document.getElementById('sumTotalSAntPDBR').innerHTML=devolverCantidad(parseFloat(montoInicialAnio)+parseFloat(data.montoInicialAnioBX));
	  document.getElementById('sumTotalDepPDBR').innerHTML=devolverCantidad(parseFloat(bajaInversionHoy)+parseFloat(sumHoy)+parseFloat(altaInversionHoy)+parseFloat(data.interesPagadoHoy));
	  document.getElementById('sumTotalTCCPDBR').innerHTML=devolverCantidad(parseFloat(sumCargos)+parseFloat(bajaInversionHoy)+parseFloat(data.retencionSRHoy));
	  document.getElementById('sumTotalSActPDBR').innerHTML=devolverCantidad(parseFloat(altaInversionHoy)+parseFloat(montoInicialAnio)+parseFloat(bajaInversionHoy)+parseFloat(sumHoy)-parseFloat(sumCargos)+parseFloat(data.montoInicialAnioBX)-parseFloat(bajaInversionHoy)+parseFloat(interesMenosRetencionHoy));

    }
	
}
function devolverCantidad(cantidad=0)
{
	let cant=parseFloat(cantidad);
  cantidad=cant.toFixed(2);	
  
  let decimal=cantidad.split('.');return `$${(new Intl.NumberFormat("en-MX")).format(decimal[0])}.${decimal[1]}`;
}
function traerPartidas(objeto,param1)
{
	let parametros='';
    parametros='?busqueda='+param1;
    if(document.getElementsByClassName('rowSeleccionado')[0]){document.getElementsByClassName('rowSeleccionado')[0].classList.remove('rowSeleccionado')}
    objeto.parentNode.classList.add('rowSeleccionado');
	if(objeto.dataset.busqueda=='d'){parametros+=`&dia=${diaGlobal}&mes=${mesGlobal}&anio=${anioGlobal}&busqueda=d`}
    if(objeto.dataset.busqueda=='m'){parametros+=`&dia=${diaGlobal}&mes=${mesGlobal}&anio=${anioGlobal}&busqueda=m`}		
    if(objeto.dataset.busqueda=='a'){parametros+=`&dia=${diaGlobal}&mes=${mesGlobal}&anio=${anioGlobal}&busqueda=a`}
    if(objeto.dataset.busqueda=='ap'){parametros+=`&anio=${anioPasadoGlobal}&busqueda=ap`}
    if(objeto.parentNode.dataset.idpromotoria){parametros+='&idPromotoria='+objeto.parentNode.dataset.idpromotoria}
    
	          
    //parametros=parametros+'&idPersona=0';
    peticionAJAX('cheques/traePartidas/',parametros,'pintaDepositos');
	
}
function pintaDepositos(datos='')
{
	if(datos!='')
	{
		let sum=0;
		let tabla=`<table class="table">`
		tabla+=`<thead><tr><td>Promotoria</td><td>Fecha</td><td>Cantida</td></tr></thead>`;
		tabla+=`<tbody>`;
		datos.datos.forEach(d=>{
			let total=parseFloat(d.total);
          tabla+=`<tr><td>${d.promotoria}</td><td>${d.FECHA}</td><td align="right">${devolverCantidad(total)}</td></tr>`;
          sum=parseFloat(sum)+parseFloat(d.total);
		})
		tabla+=`<tr><td colspan="2"></td><td align="right">${devolverCantidad(sum)}</td>`
		tabla+=`</tbody>`;
		tabla+=`</table>`;
		document.getElementById('divMovibleContenido').innerHTML=tabla;
       document.getElementById('divMovibleContenido').classList.add("divMovibleContenido");  
	}
}

function guardarMontoInicial(datos="")
{
  if(datos=='')
  {
      let parametros='';
    parametros=parametros+'?montoInicial='+document.getElementById('montoInicialText').value;
    parametros=parametros+'&fecha='+document.getElementById('fechaBusqueda').value;
    parametros=parametros+'&tipo=I';
    peticionAJAX('cheques/guardarMontoInicial/',parametros,'guardarMontoInicial');
  }	
  else
  { alert(datos.mensaje)
  	
    if(datos.success==true)
    {       
      document.getElementById('fechaBusqueda').value=datos.fecha;	

      depositosTbody('');
    }
    
  }
}
function guardarMontoInicialBX(dato='')
{
	  if(dato=='')
  {
      let parametros='';
    parametros=parametros+'?montoInicial='+document.getElementById('montoInicialBX').value;
    parametros=parametros+'&fecha='+document.getElementById('fechaInicialBX').value;    
    parametros=parametros+'&tipo=BX';
    peticionAJAX('cheques/guardarMontoInicial/',parametros,'guardarMontoInicial');
  }	
  else
  { alert(datos.mensaje)
  	
    if(datos.success==true)
    {       
     // document.getElementById('fechaBusqueda').value=datos.fecha;	
      //depositosTbody('');
    }
    
  }
}
function peticionAJAX(controlador,parametros,funcion)
{
  var req = new XMLHttpRequest();var direccionAJAX="<?= base_url();?>";
  var url=direccionAJAX+controlador+parametros;  
  req.open('GET', url, true);
  req.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
  abrirCerrarCarga();
   req.onreadystatechange = function (aEvt) 
  {
    if (req.readyState == 4) {
    	if(req.status == 200)
        { 
         var respuesta=JSON.parse(this.responseText);
         window[funcion](respuesta);        
         abrirCerrarCarga();
      }     
   }
  };
 req.send();
}


depositosTbody();



// Make the DIV element draggable:
dragElement(document.getElementById("mydiv"));

function dragElement(elmnt) {
  var pos1 = 0, pos2 = 0, pos3 = 0, pos4 = 0;
  if (document.getElementById(elmnt.id + "header")) {
    // if present, the header is where you move the DIV from:
    document.getElementById(elmnt.id + "header").onmousedown = dragMouseDown;
  } else {
    // otherwise, move the DIV from anywhere inside the DIV:
    elmnt.onmousedown = dragMouseDown;
  }

  function dragMouseDown(e) {
    e = e || window.event;
    e.preventDefault();
    // get the mouse cursor position at startup:
    pos3 = e.clientX;
    pos4 = e.clientY;
    document.onmouseup = closeDragElement;
    // call a function whenever the cursor moves:
    document.onmousemove = elementDrag;
  }

  function elementDrag(e) {
    e = e || window.event;
    e.preventDefault();
    // calculate the new cursor position:
    pos1 = pos3 - e.clientX;
    pos2 = pos4 - e.clientY;
    pos3 = e.clientX;
    pos4 = e.clientY;
    // set the element's new position:
    elmnt.style.top = (elmnt.offsetTop - pos2) + "px";
    elmnt.style.left = (elmnt.offsetLeft - pos1) + "px";
  }

  function closeDragElement() {
    // stop moving when mouse button is released:
    document.onmouseup = null;
    document.onmousemove = null;
  }
}
function abrirCerrarCarga()
{
	document.getElementById('miModalCD').classList.toggle('modalCierraGenerico');
	document.getElementById('miModalCD').classList.toggle('modalAbreGenerico');
}
function cambiaFecha(valor)
{
	document.getElementById('fechaInicialBX').value=valor;
}
</script>
<style type="text/css">
.posDiarioBanclsClass{width: 100%;color: black;background-color: white;border-color: black}
.posDiarioBanclsClass td { border: 1px solid black;}
.ocultarObjeto{display: none}
#divContenido{display: flex;flex-direction: column;left: 5%;position: relative;overflow: auto;width: 90%}
  .ExcelTable2007 {
  	left: 100px
  border: 1px solid #B0CBEF;
  border-width: 1px 0px 0px 1px;
  font-size: 11pt;
  font-family: Calibri;
  font-weight: 100;
  border-spacing: 0px;
  border-collapse: collapse;
  width: 90%
}

.ExcelTable2007 TH {
  background-image: url(excel-2007-header-bg.gif);
  background-repeat: repeat-x; 
  font-weight: normal;
  font-size: 12px;
  border: 1px solid #9EB6CE;
  border-width: 0px 1px 1px 0px;
  height: 17px;  
  background: rgba(212,228,239,1);
  background: -moz-linear-gradient(top, rgba(212,228,239,1) 0%, rgba(212,228,239,1) 11%, rgba(212,228,239,1) 31%, rgba(183,195,204,1) 100%);
  background: -webkit-gradient(left top, left bottom, color-stop(0%, rgba(212,228,239,1)), color-stop(11%, rgba(212,228,239,1)), color-stop(31%, rgba(212,228,239,1)), color-stop(100%, rgba(183,195,204,1)));
  background: -webkit-linear-gradient(top, rgba(212,228,239,1) 0%, rgba(212,228,239,1) 11%, rgba(212,228,239,1) 31%, rgba(183,195,204,1) 100%);
  background: -o-linear-gradient(top, rgba(212,228,239,1) 0%, rgba(212,228,239,1) 11%, rgba(212,228,239,1) 31%, rgba(183,195,204,1) 100%);
  background: -ms-linear-gradient(top, rgba(212,228,239,1) 0%, rgba(212,228,239,1) 11%, rgba(212,228,239,1) 31%, rgba(183,195,204,1) 100%);
  background: linear-gradient(to bottom, rgba(212,228,239,1) 0%, rgba(212,228,239,1) 11%, rgba(212,228,239,1) 31%, rgba(183,195,204,1) 100%);
  filter: progid:DXImageTransform.Microsoft.gradient( startColorstr='#d4e4ef', endColorstr='#b7c3cc', GradientType=0 );
}
.ExcelTable2007 tr{min-height: 10px;height: 20px;border-color: black}
.ExcelTable2007 td {border: 0px;padding: 0px 4px 0px 2px;border: 1px solid #D0D7E5;border-width: 0px 1px 1px 0px;min-height:10px;height: 20px;color:black;border-color: black;font-size: 14px;}
.ExcelTable2007 TD B {border: 0px;background-color: white;font-weight: bold;}
.ExcelTable2007 TD.heading {background-color: #E4ECF7;text-align: center;border: 1px solid #9EB6CE;border-width: 0px 1px 1px 0px;}
.ExcelTable2007 tr:hover{background-color: green}
#mydiv {position: fixed;left: 5%;top:50%;z-index: 9;background-color: #f1f1f1;border: 1px solid #d3d3d3;text-align: center;}
.tdComision:hover{cursor: pointer;}
#mydivheader {padding: 10px;cursor: move;z-index: 10;background-color: #2196F3;color: #fff;}
.divMovibleContenido{min-width: 50px;min-height: 50px;	width: 500px;height: 300px;overflow: scroll;}
.rowSeleccionado{background: green}
.celdaCuenta{background-color: black}
td {
  border: 1px solid red;
}
.modal-contenidoGenerico{background-color:none  ;width:80%;height:100%;left: 50%;position: relative;z-index: 1000;top:50%; } 
.modalCierraGenerico{background-color: rgba(0,0,0,.8);position:fixed;top:0;right:0;bottom:0px;left:0;opacity:0;transition: all 1s;display:none;relative;z-index: 1000}
.modalAbreGenerico{background-color: rgba(0,0,0,.8);position:fixed;top:0;right:0;bottom:0px;left:0;transition: all 1s;width:100%;height:100%;display:block;relative;z-index: 10000}
</style>

<script type="text/javascript">
  
const $btnExportar = document.querySelector("#btnExportarEncuesta"),
    $tabla = document.querySelector("#testTable");
$btnExportar.addEventListener("click", function() {
    let tableExport = new TableExport($tabla, {
        exportButtons: false, // No queremos botones
        filename: "Mi tabla de Excel", //Nombre del archivo de Excel
        sheetname: "Mi tabla de Excel", //Título de la hoja
        addClass: "celdaCuenta",  
    });
    let datos = tableExport.getExportData();
    let preferenciasDocumento = datos.testTable.csv;
    tableExport.export2file(preferenciasDocumento.data, preferenciasDocumento.mimeType, preferenciasDocumento.filename, preferenciasDocumento.fileExtension, preferenciasDocumento.merges, preferenciasDocumento.RTL, preferenciasDocumento.sheetname);
});

</script>
    <script src="http://code.jquery.com/jquery-latest.min.js" type="text/javascript"></script>
    <script type="text/javascript">
        var tableToExcel = (function () {
            var uri = 'data:application/vnd.ms-excel;base64,'
                , template = '<html xmlns:o="urn:schemas-microsoft-com:office:office" xmlns:x="urn:schemas-microsoft-com:office:excel" xmlns="http://www.w3.org/TR/REC-html40"><head><!--[if gte mso 9]><xml><x:ExcelWorkbook><x:ExcelWorksheets><x:ExcelWorksheet><x:Name>{worksheet}</x:Name><x:WorksheetOptions><x:DisplayGridlines/></x:WorksheetOptions></x:ExcelWorksheet></x:ExcelWorksheets></x:ExcelWorkbook></xml><![endif]--></head><body><table>{table}</table></body></html>'
                , base64 = function (s) { return window.btoa(unescape(encodeURIComponent(s))) }
                , format = function (s, c) { return s.replace(/{(\w+)}/g, function (m, p) { return c[p]; }) }
            return function (table, name) {
                if (!table.nodeType) table = document.getElementById(table)
                var ctx = { worksheet: name || 'Worksheet', table: table.innerHTML }
                window.location.href = uri + base64(format(template, ctx))
            }
        })()
    </script>