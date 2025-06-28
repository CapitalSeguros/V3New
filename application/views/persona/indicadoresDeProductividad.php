<?
$userResponsable=$this->tank_auth->get_usermail();
    $permisoAltaKPI=['GERENTEFINANCIERO@CAPITALSEGUROS.COM.MX','DESARROLLO@AGENTECAPITAL.COM','DIRECTORGENERAL@AGENTECAPITAL.COM','ASISTENTEDIRECCION@AGENTECAPITAL.COM'];

?>

<?
if(isset($imprimirMenu)){?>
<? $this->load->view('headers/header'); ?>
<? $this->load->view('headers/menu'); ?>	
<? } ?>
<style type="text/css" id="filtrosStyle">
	.area{display:none;color:red}
	.puestoIDP{display:none}
	.nombre{display:none}
	.nombrekpi{display:none}

</style>
<style type="text/css">
		.divEspera{width: 80px;height: 80px;margin-top: -23px;margin-left: -163px;left: 60%;top: 55%;position: fixed;z-index: 10000}	
	.divPrincipalIDP{border: 1px;display: flex;width: 100%;min-height: 300px;max-height: 500px;flex-direction: column;}	
	.divPrincipalIDP1>div:nth-child(1){width: 25%;border: solid 1px blue;display: flex;}
	.divPrincipalIDP1>div:nth-child(1)>div:nth-child(1){width: 95%;border: solid 1px blue;height: 100%;overflow: scroll;}
	.divPrincipalIDP1>div:nth-child(1)>div:nth-child(2){width: 10%;border: solid 1px blue;height: 100%}
	.divPrincipalIDP1>div:nth-child(2){width: 75%;border: solid 1px green;}
	.ocultarObjeto{display: none}
	.puestosClass:hover{background-color:#90cbd5;cursor: pointer;}
	.rowSeleccionado{background-color: #36b3c8}
	#pestaniasIP{display: flex;border-bottom: 2px solid black}
	#pestaniasIP>div{margin-right: 5px}
	.pestaniaSeleccionada{text-decoration: underline;}
	.pestaniaSeleccionadaOcultar{display: none}
	.divAltaKPI{overflow: scroll;height: 300px;width: 95%}
	.divAltaKPI>table>thead{position: sticky;top: 0px}
	.divAltaKPI>table>tbody>tr:hover{background-color: #a7fda7;cursor: pointer;}
	.rowKPISeleccionado{background-color: #a7fda7}
	.tbodyKpiPuestoSeleccionado{background-color: #a7fda7}
	.tdEditable{background-color: white;color: gray}
	#tbodyKpiPuesto>tr:hover{background-color: #a7fda7;cursor: pointer;}
	#divPuestosTripIDP{max-height: 355px;max-width: 34%;min-width: 34%;overflow: scroll;}
	.modal-btnCerrar{background-color:white;width:50%;padding: 0% 0%;margin: 0% auto;position: relative;z-index: 1000; }
    .modal-contenido{background-color:white;width:50%;height:500px;padding: 0% 0%;margin: 0% auto;position: relative;z-index: 1000; overflow: scroll;  }
    .modalCierra{background-color: rgba(0,0,0,.8);position:fixed;top:0;right:0;bottom:0px;left:0;opacity:0;transition: all 1s;display:none;z-index: 1000;}
    .modalAbre{background-color: rgba(0,0,0,.8);position:fixed;top:0;right:0;bottom:0px;left:-100;transition: all 1s;width:100%;height:100%;display:block;z-index: 1000}
    #pestaniasContenidoIP>div{min-height: 400px;height: 400px;;overflow: scroll;}
    #pestaniasContenidoIP>div>table>thead{position: sticky;top:0px;}
	.esperaGif{position: absolute;z-index: 2;width: 100%;height: 100%;background-color: white;opacity: .5;background-image: url(<?=base_url().'assets/img/esperaBlue.gif' ?>);	
</style>
<div>
<div class="divPrincipalIDP" id="divPrincipalIDP">
			<div id="pestaniasIP">
			<div><button class="btn btn-primary btnPestania pestaniaSeleccionada" data-pestania="pestaniasContenidoIP">Inidcadores de Productividad</button></div>
		<?if(in_array($userResponsable,$permisoAltaKPI)!=''){?>
			<div><button class="btn btn-primary btnPestania"  data-pestania="pestaniasAltaKPI">Alta de kpi</button></div>
		<? } ?>
		</div>
		<div>
		 <div id="pestaniasContenidoIP" class="pestaniaInfo">

		 	<div>
		 		<table class="table">
		 			<thead>

		 				<tr><th><div>Puesto</div><div><select id="selectPuestoKpiPuesto" name="filtroKpiPuesto" class="form-control" data-filtro="puestoIDP" onchange="filtroTabla(this,'tbodyKpiPuesto')"></select></div></th><th><div>Area</div><div><select id="selectAreaKpiPuesto" name="filtroKpiPuesto" class="form-control" data-filtro="area" onchange="filtroTabla(this,'tbodyKpiPuesto')"></select></div></th><th><div>Nombre</div><div><select id="selectNombreKpiPuesto" name="filtroKpiPuesto" data-filtro="apellidos" class="form-control" data-nombre="filtronombre" onchange="filtroTabla(this,'tbodyKpiPuesto')"></select></div></th><th><div>KPI</div><div><select id="selectKPIKpiPuesto" name="filtroKpiPuesto" class="form-control" data-filtro="nombrekpi" onchange="filtroTabla(this,'tbodyKpiPuesto')"></select></div></th><th>Variable 1</th><th>Variable 2</th><th>Porcentaje</th><th>Referencia</th><th>Manual</th></tr>
		 			<tr>
		 				<th colspan="9">
		 					<div style="display: flex;justify-content: space-between;">
		 					<div style="display: flex;justify-content: start;" id="botoneraModificacionIP">
		 					
	
		 					</div>

		 						 							<div style="display: flex;align-items: stretch;">
		 						 										 					<div id="calendarizarPorMes">
		 						<?if(in_array($userResponsable,$permisoAltaKPI)!=''){?>
		 						<div style="margin-right: 13px"><button class="btn btn-danger" onclick="asignarParametrosVariable1()" title="CALENDARIZAR POR MES">&#128197</button></div>
		 					<? } ?>
		 					</div>
		 						 								<div><input type="month" id="mesKpiPuesto" step="1" min="2014-01" max="" value="2014-05" value="<?echo(date('Y').'-'.date('M'))?>" dataset="5" style="color: black"></div><div><button onclick="devolverKPIPuestoAnioMes()" class="btn btn-info" style="height: 100%" title="BUSCAR">&#128269</button></div></div>
		 					</div>
		 				</th>
		 			</tr>
		 			</thead>
		 			<tbody id="tbodyKpiPuesto"></tbody>

		 		</table>
		 	</div>
		</div>
	</div>
	<?if(in_array($userResponsable,$permisoAltaKPI)!=''){?>
	   <div  id="pestaniasAltaKPI" class="pestaniaInfo pestaniaSeleccionadaOcultar">
		 	<div id="divPuestosTripIDP"><div id="divPuestosIDP"></div></div>
		 	<div>
		 	<div style="display: flex;justify-content: space-between;">
		 		<div><div><label>KPI</label></div><div><input type="text" class="form-control" id="nombreDelKPI"></div></div>
		 		<div><div><label>Variable 1:</label></div><div><input type="text" class="form-control" id="variableUnoKPI" value="0" readOnly></div></div>
		 		<div><div><label>Variable 2:</label></div><div><input type="text" class="form-control" id="variableDosKPI" ></div></div>
		 		<div><div><label>Referencia</label></div><div><input type="text" class="form-control" id="referenciaKPI"></div></div>
		 		<div><div><label>Comentario:</label></div><div><input type="text" class="form-control" id="comentarioKPI"></div></div>

		 		<div><button class="btn btn-success" style="margin-top: 25%" onclick="guardarKPI()">Guardar</button></div>
		 		
		 	</div>
		 	<div class="divAltaKPI">
		 		<table class="table">
		 			<thead><tr><th>KPI</th><th>Variable 1</th><th>Variable 2</th><th>Referencia</th><th>Comentario</th></tr><tr><th colspan="5" ><div style="display: flex"><div style="flex: 2"><button class="btn btn-warning" onclick="rowEditable()" title="EDITAR" style="margin-right: 13px">&#9997</button><button class="btn btn-warning" onclick="rowEditable(1)" title="CANCELAR EDICION" style="margin-right: 13px">&#10060</button><button class="btn btn-success" onclick="guardarActualizacionKPI()" title="GUARDAR CAMBIOS" style="margin-right: 13px">&#128190</button><button class="btn btn-danger" title="ELIMINAR KPI" onclick="eliminarKPI()">&#9940</button></div><div><button class="btn btn-primary" onclick="unirPuestoParaKPI()" title="UNIR KPI CON PUESTO">&#128257</button></div></div></th></tr></thead>
		 		    <tbody id="kpiTbody"></tbody>
		 		    
		 		</table>
		 	</div>
		 </div>
		</div>
	<? } ?>

</div>
<div id="divModalGenerico" class="modalCierra"><div><div style="background-color: #6f42c1;display: flex;justify-content: flex-end;" class="modal-btnCerrar"><button onclick="cerrarModalGenerico('divModalGenerico')" style="color: white;background-color:red; border:double;width: 5%">X</button></div><div id="divModalContenidoGenerico" class="modal-contenido"  ></div> </div></div>
</div>
<div id="divImgEspera"  class="divEspera ocultarObjeto"><img id="imgEspera" src="<?php echo(base_url().'assets/img/loading.gif');?>"></div>
<script type="text/javascript">
function divEspera()
{
  document.getElementById('divImgEspera').classList.toggle('ocultarObjeto');
}

function peticionAJAX(controlador,parametros,funcion){
  var req = new XMLHttpRequest();var direccionAJAX="<?= base_url();?>";
  var url=direccionAJAX+controlador;//+parametros;
 req.open('POST', url, true);
  req.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
  document.getElementById('divImgEspera').classList.toggle('ocultarObjeto');
   req.onreadystatechange = function (aEvt) 
  {   
    if (req.readyState == 4) 
    {      
      if(req.status == 200)
        { document.getElementById('divImgEspera').classList.toggle('ocultarObjeto');
         var respuesta=JSON.parse(this.responseText); 
         window[funcion](respuesta);                                               
      }           
   }
  };
 req.send(parametros);
}
function guardarKPIPuestoMesAnio(datos='')
{
	if(datos=='')
	{
		let rowEnEdicion=document.getElementsByClassName('puestoKpiMesAnioEnEdicion');
		if(rowEnEdicion.length>0)
		{
         	let arrayGuardar=[];

         	for(let val of rowEnEdicion)
         	{
         	  let arrayHijo=new Object();
         	  arrayHijo['idPuesto']=val.dataset.idpuesto;
         	  arrayHijo['idKPI']=val.dataset.kpi;
              arrayHijo['variable1']=document.getElementById(`${val.dataset.idpuesto}variable1${val.dataset.kpi}`).value;
              arrayHijo['variable2']=document.getElementById(`${val.dataset.idpuesto}variable2${val.dataset.kpi}`).value;
              arrayGuardar.push(arrayHijo);
         	}
         		let json=JSON.stringify(arrayGuardar);
	controlador="indicadoresDeProductividad/guardarKPIPuestoMesAnio/?"; 
	let params=`kpiPuestoMesAnio=${json}&mesAnio=${document.getElementById('mesKpiPuesto').value}`
	  peticionAJAX(controlador,params,'guardarKPIPuestoMesAnio')

		}
		else
		{
			alert('NINGUN INDICADOR ESTA EN EDICION')
		}
	}
	else
	{
		devolverKpiPuesto();
	}
}
function editarKPIPuestoMesAnio(cancelarEdicion=0)
{
	let seleccionado=document.getElementsByClassName('tbodyKpiPuestoSeleccionado');
    if(seleccionado.length>0)
    {console.log(seleccionado[0]);
    	if(seleccionado[0].dataset.automatico>0){alert('Los KPI automaticos no se pueden editar o cancelar edicion');return 0;}
       if(cancelarEdicion)
       {
     	document.getElementById(`${seleccionado[0].dataset.idpuesto}variable1${seleccionado[0].dataset.kpi}`).setAttribute('disabled','true')
       	/*document.getElementById(`${seleccionado[0].dataset.idpuesto}variable2${seleccionado[0].dataset.kpi}`).setAttribute('disabled','true')*/
       	seleccionado[0].classList.remove('puestoKpiMesAnioEnEdicion')
       }
       else
       {
       	if(idPuestoGlobal!=seleccionado[0].dataset.idpuesto){
       	document.getElementById(`${seleccionado[0].dataset.idpuesto}variable1${seleccionado[0].dataset.kpi}`).removeAttribute('disabled')
       /*	document.getElementById(`${seleccionado[0].dataset.idpuesto}variable2${seleccionado[0].dataset.kpi}`).removeAttribute('disabled')*/
       	seleccionado[0].classList.add('puestoKpiMesAnioEnEdicion')}
       	else{alert('NO PUEDE EDITAR SU PROPIO PUESTO')}

       }
    }
    else
    {
    	alert("SELECCIONE UN INDICADOR DE PRODUCTIVIDAD")
    }
}
function devolverKpiPuesto(datos='')
{
	if(datos=='')
	{
     	          let params=`mesAnio=${document.getElementById('mesKpiPuesto').value}`;

          controlador="indicadoresDeProductividad/kpiUnionPuesto/?";          
           peticionAJAX(controlador,params,'devolverKpiPuesto'); 
 
	}
	else
	{
      
      let tr='';
      document.getElementById('mesKpiPuesto').value=`${datos.anio}-${datos.mes}`;
      let filtroApellidos=[];
      let filtroKPI=[];
      let filtroArea=[];
      let filtroPuesto=[];
      for(let val of datos.kpiPuesto)
      {
      	let apellidos=val.apellidoPaterno+' '+val.apellidoMaterno;
      	let porciento=0;
      	//if(val.variable2>0){(val.variable1*100)/val.variable2;}
        
        tr+=`<tr data-kpi="${val.idKPI}" data-idpuesto="${val.idPuesto}" data-puesto="${val.personaPuesto}" data-apellidos="${apellidos}" data-nombrekpi="${val.kpi}" data-area="${val.colaboradorArea}" data-automatico="${val.idAutomatico}"><td>${val.personaPuesto}</td><td>${val.colaboradorArea}</td><td><div><div>${apellidos}</div><div>${val.nombres}</div><div>${val.email}</div></div></td><td>${val.kpi}</td><td><div style="display:flex;;flex-direction:column"><div style="display:none">${val.variable1}</div><div><input type="text" class="form-control" id="${val.idPuesto}variable1${val.idKPI}" disabled></div></div></td><td><div style="display:flex;flex-direction:column"><div style="display:none">${val.variable2}</div><div><input type="text" class="form-control" id="${val.idPuesto}variable2${val.idKPI}"  disabled></div></div></td><td id="${val.idPuesto}porcentajeTD${val.idKPI}"></td><td>${val.referenciaKPI}</td></tr>`
         filtroApellidos.push(apellidos);
         filtroKPI.push(val.kpi)
         filtroArea.push(val.colaboradorArea);
         filtroPuesto.push(val.personaPuesto);
      }
      armaSelectFiltro(filtroApellidos,'selectNombreKpiPuesto');
      armaSelectFiltro(filtroKPI,'selectKPIKpiPuesto');
      armaSelectFiltro(filtroArea,'selectAreaKpiPuesto');
      armaSelectFiltro(filtroPuesto,'selectPuestoKpiPuesto');
      document.getElementById('tbodyKpiPuesto').innerHTML=tr;
      document.getElementById('botoneraModificacionIP').innerHTML=datos.botonesModificacion;
      

      devolverKPIPuestoAnioMes();
      insertaEstilosFiltros();

	}
}
function armaSelectFiltro(array='',select,nombreFiltro)
{
	let arrayFiltros=[...new Set(array)];
	let option='';
	option='<option value="-1"></option>'
  for(let val of arrayFiltros){option+=`<option>${val}</option>`}
   document.getElementById(select).innerHTML=option;
}
function devolverKPIPuestoAnioMes(datos='') 
{
	
	if(datos=='')
	{
	 let params=`mesAnio=${document.getElementById('mesKpiPuesto').value}`;
          controlador="indicadoresDeProductividad/devolverKPIPuestoAnioMes/?";          
           peticionAJAX(controlador,params,'devolverKPIPuestoAnioMes'); 
	}
	else
	{
		
		let row=document.getElementById('tbodyKpiPuesto').childNodes;
	     
		for(let val of row)
		{	let bandBuscoMesAnio=false;
			let var1=0;
			let var2=0;
			let porciento=0;
			datos.kpiPuestosMesAnio.forEach(kpiVal=>{
				
			if(val.dataset.idpuesto==kpiVal.idPuesto && val.dataset.kpi==kpiVal.idKPI)
			{
				document.getElementById(`${val.dataset.idpuesto}variable1${val.dataset.kpi}`).value=kpiVal.variable1;
				document.getElementById(`${val.dataset.idpuesto}variable2${val.dataset.kpi}`).value=kpiVal.variable2;
				bandBuscoMesAnio=true;
				var1=kpiVal.variable1;
				var2=kpiVal.variable2;
			}	
			})
			if(var2>0 && var1!=0){porciento=100-((var1*100)/var2);var1=var2-var1;}
			else
				{
					if(var1=='0' && var2>0){porciento=100;var1=var2;}
					else{
					if(var1=='0' ){porciento=0;var2=0}
					else{porciento=100;var2=var1;}
				}
				}
			document.getElementById(`${val.dataset.idpuesto}porcentajeTD${val.dataset.kpi}`).innerHTML=`<div style="text-align:center;">${porciento.toFixed(2)}%</div><div><progress value="${var1}" max="${var2}">${porciento}%</progress></div>`
		  if(!bandBuscoMesAnio)
		   {
			document.getElementById(`${val.dataset.idpuesto}variable1${val.dataset.kpi}`).value=0;
			document.getElementById(`${val.dataset.idpuesto}variable2${val.dataset.kpi}`).value=0;
		   }
             
		   //<progress value="${val.variable2}" max="${val.variable1}">
		   val.addEventListener('click',function(){
               let seleccionado=document.getElementsByClassName('tbodyKpiPuestoSeleccionado');
               if(seleccionado.length>0){seleccionado[0].classList.remove('tbodyKpiPuestoSeleccionado')}
               	this.classList.add('tbodyKpiPuestoSeleccionado')
		   })
		}

	}
}
function borrarPuestoParaKPI(datos='')
{

  if(datos=='')
  {
	let kpiPuesto=document.getElementsByClassName('tbodyKpiPuestoSeleccionado');

	if(kpiPuesto.length>0)
	{
     if(kpiPuesto[0].dataset.automatico>0){alert('Los KPI automaticos no se puede eliminar');return 0;}

      let afirmacion=confirm(`Se eliminara la union del puesto: ${kpiPuesto[0].dataset.puesto} con el KPI ${kpiPuesto[0].dataset.kpi}. ¿Desea continuar?`)
      if(afirmacion)
      {
      	          let params=`idPuesto=${kpiPuesto[0].dataset.idpuesto}&idKPI=${kpiPuesto[0].dataset.kpi}&mesAnio=${document.getElementById('mesKpiPuesto').value}`;
          controlador="indicadoresDeProductividad/borrarPuestoParaKPI/?";          
           peticionAJAX(controlador,params,'devolverKpiPuesto'); 
      }
	}
	else
	{
		alert('SELECCION KPI ASIGNADO');
	}
  }
 

}
function unirPuestoParaKPI(datos='')
{
	if(datos==''){
	let puesto=document.getElementsByClassName('rowSeleccionado');
	let kpi=document.getElementsByClassName('rowKPISeleccionado');

	if(puesto.length>0 && kpi.length>0)
	{
		if(kpi[0].dataset.automatico>0){alert('Los KPI automaticos no se pueden asignar a colaboradores manualmente');return 0;}		
      let afirmacion=confirm(`Al puesto ${puesto[0].dataset.puesto} se le asignara el KPI ${kpi[0].dataset.kpi}. ¿Desea continuar?`)
      if(afirmacion)
      {
      	          let params=`idPuesto=${puesto[0].dataset.idpuesto}&idKPI=${kpi[0].dataset.idkpi}`;
          controlador="indicadoresDeProductividad/unirPuestoKPI/?";
          let hijos=kpi[0].childNodes;
          for(let val of hijos)
          {
          	if(val.dataset.campo=='variable1')
          	{
          		params+=`&variable1=${val.innerHTML}`;
          	}
          	else
          	{
          		if(val.dataset.campo=='variable2')
          		{
          		  params+=`&variable2=${val.innerHTML}`;	
          		}
          	}
          }          
          
           peticionAJAX(controlador,params,'unirPuestoParaKPI'); 
      }
	}
	else
	{
		alert('SELECCION UN PUESTO Y UN KPI');
	}
  }
  else
  {
    if(datos.success)
    {
    	alert(datos.mensaje)
    	devolverKpiPuesto();	
    }  	
  }
}
function devolverPuestos(datos='')
{
	if(datos=='')
	{
          //params+='&idPuesto='+document.getElementById('idPuesto').value;
          let params='';
          controlador="indicadoresDeProductividad/devolverPuestos/?";          
           peticionAJAX(controlador,params,'devolverPuestos'); 
	}
	else
	{
		
		let tables='';
		for(const [key, value] of Object.entries(datos.puestos))
		{

          tables+=`<table class="table" ><thead><tr><th><button class="btn btn-primary" data-padre="${key}" onclick="abrirCerraHijos(this)">+</button></th><th colspan="2">${key}</th></tr></thead><tbody>`;

          value.forEach(val=>{
          	tables+=`<tr class="ocultarObjeto ${key} puestosClass" data-idpuesto="${val.idPuesto}" data-puesto="${val.personaPuesto}" onclick='seleccionarRow(this)'><td>${val.personaPuesto}</td><td>${val.apellidoPaterno} ${val.apellidoMaterno} ${val.nombres}</td><td>${val.email}</td></tr>`
          })
          tables+=`</tbody></table>`;
        }

		document.getElementById('divPuestosIDP').innerHTML=tables;

	}
}

function devolverKPI(datos='')
{
	if(datos=='')
	{
         let params='';
          controlador="indicadoresDeProductividad/manejoKPI/?";          
           peticionAJAX(controlador,params,'devolverKPI'); 

	}
	else
	{
     if(datos.success)
     {
     let body='';
       for(let val of datos.kpi)
       {
        body+=`<tr data-idkpi="${val.idKPI}" data-kpi="${val.kpi}" onclick="escogerRowKPI(this)" data-automatico="${val.idAutomatico}"><td data-campo="kpi" data-editable="1" >${val.kpi}</td><td data-campo="variable1" data-editable="0">${val.variable1}</td><td data-campo="variable2" data-editable="1">${val.variable2}</td><td data-campo="referenciaKPI" data-editable="1">${val.referenciaKPI}</td><td data-campo="comentarioKPI" data-editable="1" >${val.comentarioKPI}</td></tr>`
       }
       document.getElementById('kpiTbody').innerHTML=body;
      }
      else
      {
      alert(datos.mensaje);
      }
	}
}

function rowEditable(cancelar=0)
{

  let row=document.getElementsByClassName('rowKPISeleccionado');

	if(row.length>0)
		{
if(row[0].dataset.automatico>0){alert('Los KPI automaticos no se pueden editar o eliminar');return 0;}		
			let hijos=row[0].childNodes;

		  if(!cancelar)
		  {row[0].classList.add('rowEditado')
		   for(let td of hijos)
		   	{
		   		if(td.dataset.editable=='1')
		   		{
		   		td.setAttribute('contenteditable','true');td.classList.add('tdEditable');
		   	   }
		   	}
		   }
		  else
		  {row[0].classList.remove('rowEditado')
		  	   for(let td of hijos){td.removeAttribute('contenteditable');td.classList.remove('tdEditable');}
		  }

		 }	
}
function escogerRowKPI(objeto)
{
	let row=document.getElementsByClassName('rowKPISeleccionado');
	if(row.length>0)
		{
		
			row[0].classList.remove('rowKPISeleccionado');

		
        }
	objeto.classList.add('rowKPISeleccionado');	

     
			
}
function eliminarKPI(datos='')
{
	if(datos=='')
	{
       let row=document.getElementsByClassName('rowKPISeleccionado');
	  if(row.length>0)
	   {
if(row[0].dataset.automatico>0){alert('Los KPI automaticos no se pueden eliminar');return 0;}			   	
      let afirmacion=confirm(`Eliminara el indicador de productividad "${row[0].dataset.kpi}". ¿Desea continuar?`)
      if(afirmacion)
      {
      	  let params=`idKPI=${row[0].dataset.idkpi}`;
          controlador="indicadoresDeProductividad/eliminarKPI/?";
          	  peticionAJAX(controlador,params,'eliminarKPI');
	  }
	}
      else
      {
      	alert('SELECCIONE UN KPI')
      }
	
  }
  else
  {
  	alert(datos.mensaje);
  	if(datos.success){devolverKPI();}
  }
}
function guardarActualizacionKPI(datos='')
{
	if(datos==''){
	let editado=document.getElementsByClassName('rowEditado');
	let arrayGuardar=[];
	for(let val of editado)
	{
		let hijos=val.childNodes;
		let arrayHijo=new Object();
		for(let valHijos of hijos)
		{
			if(valHijos.dataset.campo)
			{ 
				arrayHijo[valHijos.dataset.campo]=valHijos.innerHTML
				
			}
		}
		arrayHijo['idKPI']=val.dataset.idkpi;
       arrayGuardar.push(arrayHijo);

	}
	let json=JSON.stringify(arrayGuardar);
	controlador="indicadoresDeProductividad/guardarActualizacionKPI/?"; 
	let params=`kpi=${json}`
	  peticionAJAX(controlador,params,'devolverKPI');
	}

}
function guardarKPI(datos='')
{
	if(datos=='')
	{
         let params=`idKPI=-1&kpi=${document.getElementById('nombreDelKPI').value}&variable1=${document.getElementById('variableUnoKPI').value}&variable2=${document.getElementById('variableDosKPI').value}&comentarioKPI=${document.getElementById('comentarioKPI').value}&referenciaKPI=${document.getElementById('referenciaKPI').value}`;

          controlador="indicadoresDeProductividad/manejoKPI/?";          
           peticionAJAX(controlador,params,'devolverKPI'); 
	}
	
}

function abrirCerraHijos(objeto)
{
	let padre=objeto.dataset.padre;
	let lista=document.getElementsByClassName(objeto.dataset.padre);	
	if(objeto.innerHTML=='+'){objeto.innerHTML='-';for(val of lista){val.classList.remove('ocultarObjeto')}}
	else{objeto.innerHTML='+';for(val of lista){val.classList.add('ocultarObjeto')}}
}
function seleccionarRow(objeto)
{
 let rowSeleccionado=document.getElementsByClassName('rowSeleccionado');
 if(rowSeleccionado.length>0)
 {
 	rowSeleccionado[0].classList.remove('rowSeleccionado')
 }
 objeto.classList.add('rowSeleccionado');
}
function index()
{
  let pestanias=document.getElementsByClassName('btnPestania');

  for(let val of pestanias)
  {
  	val.addEventListener('click',function()
  	{  		
  		document.getElementsByClassName('pestaniaSeleccionada')[0].classList.remove('pestaniaSeleccionada');
  		this.classList.add('pestaniaSeleccionada');  		
  		let pestania=document.getElementsByClassName('pestaniaInfo');
  		for(let val of pestania){val.style.display='none';val.classList.add('pestaniaSeleccionadaOcultar')}
  		
  		document.getElementById(this.dataset.pestania).classList.remove('pestaniaSeleccionadaOcultar');
  	
  	document.getElementById(this.dataset.pestania).style.display='flex'
  	if('pestaniasContenidoIP'==this.dataset.pestania){document.getElementById(this.dataset.pestania).style.flexDirection='column';}
  	else{document.getElementById(this.dataset.pestania).style.flexDirection='row';}
  	    /*if(this.dataset.pestania=='pestaniasAltaKPI'){document.getElementById('divPuestosTripIDP').style.width='25%';}
  	    else{document.getElementById('divPuestosTripIDP').style.width='0%'}*/

  	})
  }
}
function asignarParametrosVariable1(datos='') 
{
  if(datos=='')
  {
  //document.getElementById('divModalContenidoGenerico').innerHTML=tabla;

  	let seleccionado=document.getElementsByClassName('tbodyKpiPuestoSeleccionado');
    if(seleccionado.length>0)
    {
    	if(seleccionado[0].dataset.automatico>0){alert('Los KPI automaticos no se les puede asignar valores automaticos');return 0;}
     
      let params=`anio=${document.getElementById('mesKpiPuesto').value}&kpi=${seleccionado[0].dataset.kpi}&idPuesto=${seleccionado[0].dataset.idpuesto}`;
      controlador="indicadoresDeProductividad/devolverKPIPuestoAnioMes/?";          

      peticionAJAX(controlador,params,'asignarParametrosVariable1'); 
    } 
    else
    {
    	alert("SELECCIONE UN INDICADOR DE PRODUCTIVIDAD")
    }
  }
  else
  {
  	 
    let meses='';
      for(let val in datos.meses)
      {
        let value=0;
        let variable2=0;//datos.variable2;        
        for(let i of datos.kpiPuestosMesAnio){if(val==i.mes){variable2=i.variable2;}
        }
       meses+=`<div style="display:flex;width:100%;;margin-bottom:2%"><div style="flex:1"><label>${datos.meses[val]}</label></div><div style="flex:3"><input type="text" class="form-control" style="text-align:right" name="mesesKpiPuesto" value=${variable2} data-mes=${val} id="${datos.meses[val]}-${val}"></div></div>`

      }
     meses+=`<div style="display:flex;width:100%;margin-bottom:2%;text-align:right"><div style="flex:1"><label></label></div><div style="flex:3"><button class="btn btn-success" onclick="guardarCadaKpiPuestoPorMesAnio()">&#128190</button></div></div>`
     document.getElementById('divModalContenidoGenerico').innerHTML=meses;     
      cerrarModalGenerico('divModalGenerico')
  }
}

function cerrarModalGenerico(modal){
     document.getElementById(modal).classList.toggle('modalCierra');
     document.getElementById(modal).classList.toggle('modalAbre');   
}
function guardarCadaKpiPuestoPorMesAnio(datos='')
{
  if(datos=='')
  {
  	let rowKpiPuesto=document.getElementsByClassName('tbodyKpiPuestoSeleccionado');


  	  if(rowKpiPuesto.length>0)		
  	  {
  	  	let meses=document.getElementsByName('mesesKpiPuesto');
  	    let params=`idKPI=${rowKpiPuesto[0].dataset.kpi}&idPuesto=${rowKpiPuesto[0].dataset.idpuesto}`;
        let arrayGuardar=[];
        for(let val of meses)
        {
        	let arrayHijo=new Object();
        	arrayHijo.mes=val.dataset.mes;
        	arrayHijo.valor=val.value;
        	 arrayGuardar.push(arrayHijo);
        	
        }
        let json=JSON.stringify(arrayGuardar);
         params+=`&kpiPuestoMes=${json}&mesAnio=${document.getElementById('mesKpiPuesto').value}`
    controlador="indicadoresDeProductividad/guardarCadaKpiPuestoPorMesAnio/?"; 
        peticionAJAX(controlador,params,'guardarCadaKpiPuestoPorMesAnio')
         
	
	
   }

 }
 else
 {
   devolverKpiPuesto();
 }
}
function insertaEstilosFiltros()
{
	let filtros=document.getElementsByName('filtroKpiPuesto');
	
	let estilos='';
	for(let val of filtros){estilos+=`.${val.dataset.filtro}{display:none}`;}
	document.getElementById('filtrosStyle').innerHTML=estilos;
}
function filtroTabla(objeto,tbody)
{
  let row=document.getElementById(tbody).rows;
  let valor=objeto.value;
  let filtro='data-'+objeto.dataset.filtro;
  if(valor==-1){for(let val of row){val.classList.remove(objeto.dataset.filtro);} }
  else{
  for(let val of row)
  {
  	if(val.getAttribute(filtro)!=valor){val.classList.add(objeto.dataset.filtro);}
  	else{val.classList.remove(objeto.dataset.filtro);}
  }
 }
}
document.getElementById('mesKpiPuesto').value="<?=date('Y').'-'.date('m')?>";
index();
devolverPuestos();	
devolverKPI();
devolverKpiPuesto();
let idPuestoGlobal=<?=$this->tank_auth->get_idPersonaPuesto();?>
</script>
