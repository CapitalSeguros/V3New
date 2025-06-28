
<?php $this->load->view('generales/modalGenericoV3');?>
<?php $this->load->view('headers/header');?>
<?php $this->load->view('headers/menu');?>
<style type="text/css">
	.subListaNoVisible{display: none}
	.subListaVisible{display: block;position: absolute;top:90%;}
	.listaDesplegableDiv{background-color: white;width: 100%;height: 200px;overflow: scroll;}
	.listaDesplegableDiv>div:hover{background-color: #cfe6eb;cursor: pointer;}

	 .filtrarListaAP{display: none}
	 .opcionSubMenu{width: 100%}
	 .filtrarListaNombre{display: none}
	 .table>tbody>tr:hover{background-color: #91c78b;}
	 .rowSeleccionado{background-color:#368023}
	 .table>thead{z-index: 1}
	 .table>tbody>tr>td:nth-child(1){position: sticky;left: 0px;background-color: #78af69;z-index: 0}
	 .table>tbody>tr>td:nth-child(2){position: sticky;left: 60px;background-color: #4aa532;z-index: 0}
	 .table>thead>tr>td:nth-child(1){position: sticky;left: 0px;z-index: 3;background-color: #472380}
	 .table>thead>tr>td:nth-child(2){position: sticky;left: 60px;z-index: 3;background-color: #472380}
	 .table>thead>tr>td:nth-child(3n){z-index: 3}
	 .dropdown-item{z-index: 10}
	 .btnAbrirCerrar{background-image: url(<?=base_url()?>assets/images/ocultar.png);width: 30px;height: 30px}
	 .btnDeshacer{background-image: url(<?=base_url()?>assets/images/deshacer.png);width: 30px;height: 30px}
	 .btnGuardar{background-image: url(<?=base_url()?>assets/images/guardarArchivo.png);width: 30px;height: 30px}

</style>
<div class="contenedorTabsInfo">
	<div class="contenedorTabs"><?=imprimirTabs($tabs)?></div><!--FIN DE cT-->
	<div class="contenedorInfo"><table class="table"><thead id="contenedorClientesHead"><tr><td><div ><button title="OCULTAR BARRA" onclick="ocultarBarra()" class="btnAbrirCerrar"></button></div></td><td style="display: flex;flex-direction: column;"><div style="display: flex;justify-content: space-around;"><button class="btnDeshacer" onclick="restablecerValoresRow()"></button><button class="btnGuardar" onclick="guardarCambiosClientes()"></button></div><div><progress id="barraProgreso" value="" max=""></div></td><td colspan="8"></td></tr><tr><td><div></div></td><td>NOMBRE COMPLETO <div><div style="display: flex"><input id="filtrarListaNombre" oninput="cambiaValorInput(this)" type="text" name="" class="filtro-SM"><button onclick="filtrarTabla(this,'filtrarListaNombre')" class="btn btn-info">...</button></div><div class="subListaNoVisible listaDesplegableDiv" id="listaNombre" ></div></div></td><td><label>APELLIDO PATERNO</label></td><td>APELLIDO MATERNO</td><td>NOMBRES</td><td>TELEFONO</td><td>CORREO</td><td>RFC</td><td>FECHA NACIMIENTO</td><td>RAZON SOCIAL</td></tr></thead><tbody id="contenedorClientesBody"></tbody></table></div><!--FIN DE cI-->
</div><!--FIN DE cTI-->

<script type="text/javascript">
	let rowSeleccionadoGlobal='',clientesGlobal=[];
	let arrayAM=[],arrayAP=[],arrayTel=[],arrayEmail=[],arrayRFC=[];

	class clienteModificar{

	  oldValueAP='';newValueAP='';
	  oldValueAM='';newValueAM='';
	  oldValueN='';newValueN='';
	  oldValueTel='';newValueTel='';
	  oldValueEmail='';newValueEmail='';
	  oldValueRFC='';newValueRFC='';
	  oldValueFN='';newValueFN='';
	  oldValueRS='';newValueRS='';
	  aplicarCambio=false;
	  id='';
	  IDCont='';
	  $tipoEntidad='';
	  constructor(id,apellidoP='',apellidoM='',nombre='',telefono='',correo='',rfc,fecNacimiento,razonSocial,IDCont,tipoEntidad='')
	  { this.id=id;
        this.oldValueAP=this.newValueAP=apellidoP;
        this.oldValueAM=this.newValueAM=apellidoM;
        this.oldValueN=this.newValueN=nombre;
        this.oldValueEmail=this.newValueEmail=correo;
        this.oldValueRFC=this.newValueRFC=rfc;
        this.oldValueFN=this.newValueFN=fecNacimiento 
        this.oldValueTel=this.newValueTel=telefono;  
        this.oldValueRS=this.newValueRS=razonSocial; 
        this.IDCont=IDCont;  
        this.tipoEntidad=tipoEntidad;
        
	  }
	  change(tipo,value)
	  {
         switch(tipo)
         {
         	case 'ap':this.newValueAP=value; this.aplicarCambio=true;break;
         	case 'am':this.newValueAM=value;this.aplicarCambio=true; break;
         	case 'n':this.newValueN=value;this.aplicarCambio=true; break;
         	case 'tel':this.newValueTel=value;this.aplicarCambio=true; break;
         	case 'email':this.newValueEmail=value;this.aplicarCambio=true; break;
         	case 'rfc':this.newValueRFC=value;this.aplicarCambio=true; break;
         	case 'fecNac':this.newValueFN=value;this.aplicarCambio=true; break;
         	case 'ac':this.aplicarCambio=value;break
         	case 'rs':this.newValueRS=value;this.aplicarCambio=value;break
         }
	  }
	  restaurarValores(rowSeleccionado)
	  {
	  	
       this.aplicarCambio=false;
	   for(let row of rowSeleccionado.getElementsByClassName('cellInputCliente'))
	   {
            row.removeAttribute('data-nv');
	   	 switch(row.dataset.tipo)
         {
         	case 'ap':row.value=this.newValueAP=this.oldValueAP; break;
         	case 'am':row.value=this.newValueAM=this.oldValueAM; break;
         	case 'n':row.value=this.newValueN=this.oldValueN; break;
         	case 'tel':row.value=this.newValueTel=this.oldValueTel; break;
         	case 'email':row.value=this.newValueEmail=this.oldValueEmail;break;
         	case 'rfc':row.value=this.newValueRFC=this.oldValueRFC; break;
         	case 'fecNac':row.value=this.newValueFN=this.oldValueFN; break;
         	case 'rs':row.value=this.newValueRS=this.oldValueRS; break;
         	
         }
	   }

	  }
	  actualizarOldValue(array,arrayError,errorMensaje)
	  {
	  	let idCli=array['IDCli'];
        
	  	for(let i in array)
	  	{
	  		if(i!='IDCli' && i!='IDCont' && i!='NombreCompleto')
	  		{
	  			if(arrayError.indexOf(i)==-1){document.getElementById(i+idCli).removeAttribute('data-nv');}
	  			else
	  			{
	  				let mensaje='';
	  				errorMensaje.forEach(e=>{
                        mensaje+=`[ ${e} ], `;
	  				})
	  				document.getElementById('CB'+idCli).setAttribute('title',mensaje);
	  				document.getElementById('CB'+idCli).setAttribute('data-info','');
	  			}
	  		
           }
        }
        if(arrayError.length==0)
        {
        	let td=document.getElementById('CB'+idCli).parentNode;
        	td.removeChild(document.getElementById('CB'+idCli));
        	td.innerHTML='<div></div>';
        }
        // this.newValueAP=this.oldValueAP=array['ApellidoM'];
         // cambiaValorInput(document.getElementById('ap'+array['IDCli']));  
	  }

	}

   function refrescarTabla(datos)
    {
           
    	let incrementador=document.getElementById('barraProgreso').value;
    	incrementador++;
    	document.getElementById('barraProgreso').value=incrementador;
    	array=[];    
    	
    	clientesGlobal[datos.clienteDatos.IDCli].actualizarOldValue(datos.clienteDatos,datos.errorInfo,datos.errorMensaje)

    }
function guardarCambiosClientes()
{  

	arrayEnviar=[];
	document.getElementById('barraProgreso').value=0;
	for(let clientes in clientesGlobal)
	{
	 if(clientesGlobal[clientes].aplicarCambio)
	 {
	 	cad='IDCli='+clientes+'&IDCont='+clientesGlobal[clientes].IDCont+'&tipoEntidad='+clientesGlobal[clientes].tipoEntidad;
	 
	 
if(clientesGlobal[clientes].oldValueAP!=clientesGlobal[clientes].newValueAP){cad+=`&ApellidoP=${clientesGlobal[clientes].newValueAP}&oldApellidoP=${clientesGlobal[clientes].oldValueAP}`}
if(clientesGlobal[clientes].oldValueAM!=clientesGlobal[clientes].newValueAM){cad+=`&ApellidoM=${clientesGlobal[clientes].newValueAM}&oldApellidoM=${clientesGlobal[clientes].oldValueAM}`}
if(clientesGlobal[clientes].oldValueN!=clientesGlobal[clientes].newValueN){cad+=`&Nombre=${clientesGlobal[clientes].newValueN}&oldNombre=${clientesGlobal[clientes].oldValueN}`}
if(clientesGlobal[clientes].oldValueTel!=clientesGlobal[clientes].newValueTel){cad+=`&Telefono1=${clientesGlobal[clientes].newValueTel}&oldTelefono1=${clientesGlobal[clientes].oldValueTel}`}
if(clientesGlobal[clientes].oldValueEmail!=clientesGlobal[clientes].newValueEmail){cad+=`&Email1=${clientesGlobal[clientes].newValueEmail}&oldEmail1=${clientesGlobal[clientes].oldValueEmail}`}
if(clientesGlobal[clientes].oldValueRFC!=clientesGlobal[clientes].newValueRFC){cad+=`&RFC=${clientesGlobal[clientes].newValueRFC}&oldRFC=${clientesGlobal[clientes].oldValueRFC}`}
if(clientesGlobal[clientes].oldValueFN!=clientesGlobal[clientes].newValueFN){cad+=`&fecha_nacimiento=${clientesGlobal[clientes].newValueFN}&oldfecha_nacimiento=${clientesGlobal[clientes].oldValueFN}`}
if(clientesGlobal[clientes].oldValueRS!=clientesGlobal[clientes].newValueRS){cad+=`&RazonSocial=${clientesGlobal[clientes].newValueRS}&oldRazonSocial=${clientesGlobal[clientes].oldValueRS}`}
arrayEnviar.push(cad);
peticionAJAXLib('clientes/guardarModificacionClientes',cad,'refrescarTabla');
} } if(arrayEnviar.length>0) {
document.getElementById('barraProgreso').max=arrayEnviar.length;

//arrayEnviar.forEach(a=>{peticionAJAXLib('clientes/guardarModificacionClientes',a,'refrescarTabla');})

	}
	else
	{
		alert('NO HAY INFORMACION PARA MODIFICAR')
	}

}



	function ocultarBarra()
	{
		(document.getElementsByClassName('contenedorTabs')[0].style.flex=='')? document.getElementsByClassName('contenedorTabs')[0].style.flex=0 : document.getElementsByClassName('contenedorTabs')[0].style.flex='';
	}
	function filtrarTabla(objeto,filtro)
	{
      let rows=document.getElementById('contenedorClientesBody').rows;
      let index='';
      let val='';
      if(objeto.nodeName=='BUTTON')
      {
      	index=objeto.parentNode.parentNode.parentNode.cellIndex;
      	val=objeto.previousElementSibling.value;
      }
      else
      {
       index=objeto.parentNode.parentNode.parentNode.cellIndex;      
       val=objeto.parentElement.previousElementSibling.firstChild.value;
      }
     val=val.toLowerCase();
     if(val=='')
     {
        for(let r of rows){r.classList.remove('filtrarListaNombre')}
     }
     else{
      for(let r of rows){if(r.cells[index].firstChild.innerHTML.toLowerCase().indexOf(val)=== -1 ){  r.classList.add('filtrarListaNombre')}else{r.classList.remove('filtrarListaNombre')}}
      }

	}
	function cambiaValorInput(objeto)
	{ 
       let hijos=objeto.parentElement.nextElementSibling.childNodes;
          
       if(objeto.value=='')
       	{  for(let val of hijos)
          {
                val.classList.remove('filtrarListaNombre');
         }}         
       else{
       for(let val of hijos)
       {
          if(val.innerHTML.toLowerCase().indexOf(objeto.value) !== -1 ){val.classList.remove('filtrarListaNombre')}
          	else{{val.classList.add('filtrarListaNombre')}}
       }
      }
	} 
	function desplegarSubMenu()
	{

     event.stopPropagation();
     this.parentElement.classList.add('subListaNoVisible')
     this.parentElement.classList.remove('subListaVisible')
     filtrarTabla(this)
	}

	function escogerTab(objeto)
	{
	  if(document.getElementsByClassName('tabSeleccionado')[0]){document.getElementsByClassName('tabSeleccionado')[0].classList.remove('tabSeleccionado')}
      objeto.childNodes[0].childNodes[1].classList.add('tabSeleccionado')   
     peticionAJAXLib('clientes/obtenerClientesPorLetraInicial','letraInicial='+objeto.childNodes[0].childNodes[0].innerHTML,'pintarTablaClientes');

	}

function pintarTablaClientes(datos)
{
	let row='';	
	arrayAM=[];
	arrayAP=[];
	arrayTel=[];
	arrayEmail=[];
	arrayRFC=[];
    arrayNombre=[];
    clientesGlobal=[];

	datos.datos.forEach(d=>{
		let fecNac='';		
		if(d.fecha_nacimiento!=null)
			{
			 let fecha=d.fecha_nacimiento.split(' ');
				d.fecha_nacimiento=fecha[0];
			}
		if(d.RazonSocial==null){d.RazonSocial='';}

		if(!arrayNombre.includes(d.NombreCompleto)){arrayNombre.push(d.NombreCompleto)}
     row+=`<tr data-value='${d.IDCli}'><td><div></div></td><td><div>${d.NombreCompleto}</div></td><td><input id="ApellidoP${d.IDCli}" value="${d.ApellidoP}" class="cellInputCliente" data-tipo="ap"><div></div></td><td><input id="ApellidoM${d.IDCli}" value="${d.ApellidoM}" class="cellInputCliente" data-tipo="am"><div></div></td><td><input id="Nombre${d.IDCli}" value="${d.Nombre}" class="cellInputCliente" data-tipo="n"><div></div></td><td><input id="Telefono1${d.IDCli}" value="${d.Telefono1}" class="cellInputCliente" data-tipo="tel"><div></div></td><td><input id="Email1${d.IDCli}" value="${d.EMail1}" class="cellInputCliente" data-tipo="email"><div></div></td><td><input id="RFC${d.IDCli}" value="${d.RFC}" class="cellInputCliente" data-tipo="rfc"><div></div></td><td><input id="Fecha_Nacimiento${d.IDCli}" type="date" value="${d.fecha_nacimiento}" class="cellInputCliente" data-tipo="fecNac"><div></div></td><td><input id="RazonSocial${d.IDCli}" type="input" value="${d.RazonSocial}" class="cellInputCliente" data-tipo="rs"><div></div></td></tr>`;
      	 clientesGlobal[d.IDCli]=new clienteModificar(d.IDCli,d.ApellidoP,d.ApellidoM,d.NombreCompleto,d.Telefono1,d.EMail1,d.RFC,d.fecha_nacimiento,d.RazonSocial,d.idContacto,d.tipoEntidad);

	})
	document.getElementById('contenedorClientesBody').innerHTML= row;

	//llenarListaDesplegable(arrayAP,'listaAP');
	llenarListaDesplegable(arrayNombre,'listaNombre');
	let opcionSM=document.getElementsByClassName('opcionSubMenu');
	for(let div of opcionSM)
	{   
		div.addEventListener('click',clickOpcionSubMenu)
		div.addEventListener('click',desplegarSubMenu)
	}
     let inputColeccion=document.getElementsByClassName('cellInputCliente');
     for(let input of inputColeccion)
     {
      input.addEventListener('click',permitirEditarCelda)
      input.addEventListener('change',cambiarValorInput);
     }
     let rowsBody=document.getElementById('contenedorClientesBody').rows;
     for(let rows of rowsBody)
     {
     	rows.addEventListener('click',seleccionarFila);
     }
}
function restablecerValoresRow()
{
  if(rowSeleccionadoGlobal)
  {
  	rowSeleccionadoGlobal.cells[0].removeChild(rowSeleccionadoGlobal.cells[0].firstChild)
  	rowSeleccionadoGlobal.cells[0].innerHTML="<div></div>";
  	clientesGlobal[rowSeleccionadoGlobal.dataset.value].restaurarValores(rowSeleccionadoGlobal)
  }
}
function seleccionarFila()
{
    if(document.getElementsByClassName('rowSeleccionado').length>0){document.getElementsByClassName('rowSeleccionado')[0].classList.remove('rowSeleccionado')}
    	this.classList.add('rowSeleccionado')
	rowSeleccionadoGlobal=this;
	
}
function clickOpcionSubMenu()
{    
	event.stopPropagation();
	this.parentElement.previousElementSibling.firstChild.value=this.innerHTML;
	this.parentElement.previousElementSibling.firstChild.focus(); 
	let elementos=this.parentElement.childNodes;
	let id=this.parentElement.previousElementSibling.firstChild.id;
	for(el of elementos){el.classList.remove(id)}

    
}
function llenarListaDesplegable(array,lista)
{
  array.sort((a, b) => {if (a == b) {return 0;}if (a < b) {return -1;}return 1;});
	let div='';
	array.forEach(a=>{div+=`<div class='opcionSubMenu' >${a}</div>`})
	document.getElementById(lista).innerHTML=div
}
function pierdoFocoInputDesplegable()
{
	
	let subLista=document.getElementsByClassName('subListaVisible');
	for(let val of subLista)
	{
		val.classList.remove('subListaVisible');
		val.classList.add('subListaNoVisible')
	}
}

function cambiarValorInput()
{
  if(this.type=='date'){	this.setAttribute('data-nv','date')}
  	else{this.setAttribute('data-nv','text')}
	//this.parentElement.parentElement.setAttribute('data-mody','');
if(this.parentElement.parentElement.cells[0].firstChild.nodeName!='INPUT')
	{	
		this.parentElement.parentElement.cells[0].innerHTML=`<input  id="CB${this.parentElement.parentElement.dataset.value}" type="checkbox" data-tipo="ac" checked >`;
         this.parentElement.parentElement.cells[0].firstChild.addEventListener('click',cambiarValorInput)
    }
      let val='';
      (this.type=='checkbox')? val=this.checked : val=this.value;
	clientesGlobal[this.parentElement.parentElement.dataset.value].change(this.dataset.tipo,val)
     
	
	
}
function permitirEditarCelda()
{
        	let inputEditar='';
        
        	
      	let cellEditable=Array.from(document.getElementsByClassName('cellEditable'));
      	cellEditable.forEach(cE=>{    		
      		cE.style.border='';

      		cE.style.backgroundColor='';
      		cE.classList.remove('cellEditable');})
       if(this.id!='contenedorClientesHead'){
       	inputEditar=this.parentElement.parentElement.querySelectorAll('input');
      	for(let iE of inputEditar)
      	{
      		iE.style.border='solid';
      		iE.style.backgroundColor='white'
      		iE.classList.add('cellEditable');
      	}
      }
}
document.getElementById('contenedorClientesHead').addEventListener('click',permitirEditarCelda);
document.addEventListener('click',function(){
         objeto=document.activeElement;
       
	 if(objeto.classList.contains("filtro-SM"))
	 {   
	   	 objeto.parentElement.nextElementSibling.classList.remove('subListaNoVisible')
         objeto.parentElement.nextElementSibling.classList.add('subListaVisible')	
	 }
	 else
	 {
	 		let subLista=document.getElementsByClassName('subListaVisible');
	     for(let val of subLista)
	    {
		 val.classList.remove('subListaVisible');
		 val.classList.add('subListaNoVisible')
	    }
	 }
})
</script>

<style type="text/css">
	.contenedorTabsInfo{display: flex;}
	.contenedorTabs{display: flex;flex-direction: column;flex:1;overflow: scroll;height: 600px;transition-duration: .8s}	
	.contenedorInfo{flex:12;overflow: scroll;height: 600px;width: 100%;z-index: 0}	
	.divTabs{display: flex;flex-direction: column;border-right: solid;}
	.divTabs:hover{background-color: #97d1e3;cursor: pointer;}
	.divTabs:active>div{background-color: #6593a1;border:none;}
	.divTabNombreCant{display: flex;border-bottom: solid 1px;justify-content: space-around}
	.divTabNombre{background-color: #97d1e3;width: 100%;flex:1;font-size: 18px}
	.divTabCant{text-align: right;flex: 2}
	.tabSeleccionado{background-color:#2d8fad}
	.table>thead{position: sticky;top: 0px;max-height: 50px;height: 50px}
	.table>thead>tr{max-height: 50px;height: 50px}
	.table>thead>tr>td{max-height: 50px;height: 50px}
	.table>tbody>tr>td>input{border:none;background-color: #f5f5f5;border-bottom: solid 1px}
    .cellEditable{border:solid;}    
    input[data-nv='text']+div{content:url(<?=base_url()?>assets/images/lapizIcono.png);width: 15px;position: static;top: -30px;left: 185px;z-index: 0	}
      input[data-nv='date']+div{content:url(<?=base_url()?>assets/images/lapizIcono.png);width: 15px;position: static;top:-42px;left: 138px;z-index: 0	}
    tr[data-mody]>td:nth-child(1)>div:nth-child(1){content:url(<?=base_url()?>assets/images/editarIcono.png);width: 25px;position: static;top:30px;left: -5px;;z-index: 0}
    input[data-info='']::after{content: '*';font-weight: 10px;font-size: 50px;color: #fff700;position: relative;left: 15px;top:-12px;}

   
</style>


<?
function imprimirTabs($tabs)
{
 $t='';
 foreach ($tabs as $key => $value) 
 {
  if($value->total>0){	$t.='<div class="divTabs" onclick="escogerTab(this)"><div class="divTabNombreCant"><div class="divTabNombre">'.$value->Nombre.'</div><div class="divTabCant"> '.$value->total.'</div></div></div>';}
 }
 return $t;
}
?>