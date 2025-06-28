<?php $this->load->view('headers/header');?>
<?php $this->load->view('headers/menu');?>
<style type="text/css">
.buttonMenu{  border-color: #472380;clear: both;height: 100px;max-width: 25%;background-color: white;color: black;min-width: 100px;}
</style>
<script src="https://code.jquery.com/jquery-3.2.1.js"></script>
<script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>



<div id="divContenedor" style="display: flex;">

	<div id="divFoliosActividades" class="col-md-1 col-sm-1 col-xs-1" style="margin-right: 30px">
    
	<button id="btnVerComentarios" class="buttonMenu" onclick="manejoDePestanias('divActividadesConsulta')">Actividades</button>
  <button id="btnVerComentarios" class="buttonMenu" onclick="manejoDePestanias('divReportes')">Reportes</button>
  
  
	</div>
  <div id="divReportes" class=" col-md-11 col-sm-11 col-xs-11 ocultarPestania">
    <div class="row"><h2>Reportes</h2></div>
    <div class="row">
      <div class="col-md-1 col-sm-1"><button class="btn btn-success" onclick="devolverActividadesPartidas('')">Buscar</button></div>      
      <!--form method="POST" action="<?=base_url().'actividades/exportarActividadePorFecha'?>"-->
      <div class="row">
      <div class="col-md-4 col-sm-4"><!--input type="text" id="fInicial" class="form-control fecha" autocomplete="off"></div>
      <div class="col-md-2 col-sm-2"><input type="text" id="fFinal" class="form-control fecha" autocomplete="off"-->
      <input type="date" id="fInicial" name="fInicial" class="form-control" autocomplete="off"></div>
      <div class="col-md-4 col-sm-4"><input type="date" id="fFinal" name="fFinal" class="form-control" autocomplete="off">  

      </div>
       
      <div class="col-md-2 col-sm-2"><button onclick="exportarActividadesPartidas()" class="btn btn-success">Exportar</button></div>
      <div class="col-sm-2 col-md-3" id='actividadesCompletas'></div>
      
    </div>
    <!--/form-->
    <div></div>
    </div>
    <hr>


    <div class="row overflow-auto miTabla">
      <table class="table" class="ExcelTable2007" id='Mitabla'>
        <thead>
          <tr>
            <th><button  class="" style="width: 40px;height: 40px;background-color: white;border: none"  id="btnExportarEncuesta"><img style="width: 100%;height: 100%" src="<?=base_url()?>assets/images/iconoxls.png"></button></th><th id="thFolio"><label>Folio</label>
            </th><th id="thSubRamo" ><label>Sub Ramo<select id="selectSubRamoReporte" class="form-control" onchange="filtrarTablaReporte(this)" data-busqueda="subramo"></select></label></th>
            <th id="thUsuarioResponsable"><label>Usuario Responsable<select id="selectUsuarioResponsableReporte" class="form-control" onchange="filtrarTablaReporte(this)" data-busqueda="usuarioresponsable"></select></label></th>
            <th id="thNombreUsuarioVendedor"><label>Nombre Vendedor<select id="selectNombreUsuarioVendedorReporte" class="form-control" onchange="filtrarTablaReporte(this)" data-busqueda="nombreusuariovendedor"></select></label></th>
            <th id="thTipoActividad"><label>Tipo actividad<select id="selectTipoActividadReporte" class="form-control" onchange="filtrarTablaReporte(this)" data-busqueda="tipoactividad"></select></label></th>
            <th id="thStatus"><label>Status<select id="selectStatusReporte" class="form-control" onchange="filtrarTablaReporte(this)" data-busqueda="status"></select></label></th><th>COMPLETA</th></tr></thead>
         <tbody id="bodyActividadesReporte"></tbody>
      </table>
    </div> 
          <div style="display: flex;justify-content: space-between;flex-wrap: wrap;width: 90%"  id='divEstadisticasReporte'>
        <div  id="divSubRamoReporte"></div>
        <div  id="divUsuarioResponsableReporte"></div>
        <div  id="divTipoActividadReporte"></div>
        <div  id="divStatusReporte"></div>
        <div  id="divMotivoCambioReporte"></div>
        <div  id="divSatisfaccionReporte"></div>
        <div  id="divSatisfaccionEmisionReporte"></div>
      </div>
      <div style="width: 80%; overflow: scroll;margin-top: 34px">

        <div  id="divSemaforoActividades"></div>

      </div>
  </div>
	<div id="divActividadesConsulta" class="col-md-11 col-sm-11 col-xs-11 verPestania">
   <div class="row"><h2>Actividades</h2></div>
    <div class="row">
      <div class="col-md-1 col-sm-1"><button id="btnVerComentarios" class="btn btn-primary" onclick="verComentarios('')">Comentarios</button>  </div>
      <div class="col-md-1 col-sm-1"><button id="btnVerComentarios" class="btn btn-primary" onclick="verActividad('')">Ver Actividad</button></div>
    </div>
	  <div id="divTabla" class="row overflow-auto" style="overflow:scroll;height:400px; width: 90%;">
    	<div class="col-md-12 col-sm-12 col-xs-12" >
    	<table class="table"  ><?=imprimirTablaAgentes($actividades,$personas);?> </table>
    </div>
    <div class="row">
      <div class="col-md-3 col-sm-3 col-xs-3" > </div>
        <div class="col-md-3 col-sm-3 col-xs-3" ></div></div><hr>
      <input type="hidden" id="textIdInterno">
    </div>
    <div  class="row" >
      <div id="divComentarios" class="col-md-6 col-sm-6 col-xs-6" style="height: 400px;overflow: scroll;position:relative;left:5%;"> 
        
      </div>
      <div  class="col-md-1 col-sm-1 col-xs-1" > 
        
      </div>
      <div class="col-md-5 col-sm-5 col-xs-5">
        <table id="estadoActivdadesTabla" class="table">
        </table>
        
      </div>

    </div>
    </div>
	</div>
	
	
</div>
<table id="expReporte" style="display: none;"></table>
<div class="gifEspera ocultarObjeto" id="gifDeEspera1"><img src="<?php echo(base_url().'assets\img\loading.gif')?>"></div>

  <link rel="stylesheet" href="//code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
  <link rel="stylesheet" href="/resources/demos/style.css">
  <script src="https://code.jquery.com/jquery-1.12.4.js"></script>
  <script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>


<script type="text/javascript">
function filtrarTablaReporte(objeto)
{
  let index=objeto.parentNode.cellIndex;
  let tabla=document.getElementById('bodyActividadesReporte');
  let cant=tabla.rows.length;
  let dataBusqueda=objeto.getAttribute('data-busqueda')
  let data='data-'+dataBusqueda;
  if(objeto.value==''){for(let i=0;i<cant;i++){tabla.rows[i].classList.remove('ocultar'+dataBusqueda);} }
 else
  {
    for(let i=0;i<cant;i++)
    {
     if(tabla.rows[i].getAttribute(data)==objeto.value){tabla.rows[i].classList.remove('ocultar'+dataBusqueda);tabla.rows[i].cells[0].innerHTML='+'}
     else
     {
      if(tabla.rows[i].getAttribute('data-sof')=='0')
      {
       tabla.rows[i].classList.add('ocultarObjeto'); 
      }
      else
       { 
        tabla.rows[i].classList.add('ocultar'+dataBusqueda);

        }
     }
    }
  }
  
}


function abrirHijo(objeto)
{

  if(objeto.innerHTML=='+'){objeto.innerHTML='-';document.getElementById(objeto.getAttribute('data-rowhijo')).classList.remove('ocultarObjeto');}
  else{objeto.innerHTML='+';document.getElementById(objeto.getAttribute('data-rowhijo')).classList.add('ocultarObjeto');}
}
function exportarActividadesPartidas(datos='')
{
     if(datos=='')
 {
    let params='';
    params=params+'fInicial='+document.getElementById('fInicial').value;
    params=params+'&fFinal='+document.getElementById('fFinal').value;
    params=params+'&peticionAJAX=1';
    controlador="actividades/exportarActividadePorFecha/?";
    peticionAJAX(controlador,params,'exportarActividadesPartidas');
 }
 else
 {
    let cantidadActividad=datos.actividades.length


   for(let val of datos.partidas)
   {
          for(let i=0;i<cantidadActividad;i++)
    {
      if(datos.actividades[i].idInterno==val.idInterno)
      {
        val.subRamo_Actividad=datos.actividades[i].subRamoActividad;
        val.satisfaccion_Actividad=datos.actividades[i].satisfaccion;
        val.usuarioCreacion_Actividad=datos.actividades[i].usuarioCreacion;
        val.usuarioVendedor_Actividad=datos.actividades[i].usuarioVendedor;
        val.fechaCreacion_Actividad=datos.actividades[i].fechaCreacion;

      }
    }
   }
   
   let row='<tr><td>TIPO ACTIVIDAD</td><td>SUB RAMO</td><td>USUARIO RESPONSABLE</td><td>FOLIO</td><td>STATUS</td><td>SATISFACCION</td><td>USUARIO CREACION</td><td>USUARIO VENDEDOR</td><td>USUARIO RESPONSABLE</td><td>FECHA CREACION</td><td>MOTIVO DEL CAMBIO</td><td>FECHA DEL CAMBIO</td><td>ESTADO DEL CAMBIO</td></tr>'
     for(let val of datos.partidas)
   {
    let satisfaccion=val.satisfaccion_Actividad;
    if(satisfaccion===null){satisfaccion='';}
    row+=`<tr><td>${val.tipoActividad}</td><td>${val.subRamo_Actividad}</td><td>${val.usuarioResponsable}</td><td>${val.folioActividad}</td><td>${val.Nombre}</td><td>${satisfaccion}</td><td>${val.usuarioCreacion_Actividad}</td><td>${val.usuarioVendedor_Actividad}</td><td>${val.usuarioResponsable}</td><td>${val.fechaCreacion_Actividad}</td><td>${val.motivoCambio}</td><td>${val.fechaGrabado}</td><td>${val.Nombre}</td></tr>`
   }
   document.getElementById('expReporte').innerHTML=row;
   expReportePartidas();
  }
}


function exportarActividadePorFecha(datos='')
{
   if(datos=='')
 {
    let params='';
    params=params+'fInicial='+document.getElementById('fInicial').value;
    params=params+'&fFinal='+document.getElementById('fFinal').value;
    controlador="actividades/exportarActividadePorFecha/?";
    peticionAJAX(controlador,params,'exportarActividadePorFecha');
 }
 else
 {
  }
}
function devolverActividadesPartidas(datos)
{
 if(datos=='')
 {
    let params='';
    params=params+'fInicial='+document.getElementById('fInicial').value;
    params=params+'&fFinal='+document.getElementById('fFinal').value;
    controlador="actividades/devolverActividadesPartidas/?";
    peticionAJAX(controlador,params,'devolverActividadesPartidas');
 }
 else
 {

   let actividadCantidad=datos.actividad.length;
   let row='';
  let retrabajo=0;
   let completa=0; 

   let responsableSR=new Array();
   
   let idSR=new Array();

     for(let i=0;i<actividadCantidad;i++)
   {
      datos.actividad[i].partidas=datos.partidasTodas.filter(val=>{        
        return val.idInterno===datos.actividad[i].idInterno;
      })

       
      if(!idSR.includes(datos.actividad[i].idInterno))
      {
        datos.semaforosIdInterno.forEach(val=>{
          if(datos.actividad[i].idInterno==val.idInterno){
          idSR.push(datos.actividad[i].idInterno);
          responsableSR.push(datos.actividad[i].usuarioResponsable);}
        })
      }
   }
 

   for(let i=0;i<actividadCantidad;i++)
   {
    // Infromaci�n encabezado tabla
    if (datos.actividad[i].nombreUsuarioVendedor==null) 
    {
      row=row+'<tr data-subramo="'+datos.actividad[i].subRamoActividad+'" data-usuarioresponsable="'+datos.actividad[i].usuarioResponsable+'" data-nombreusuariovendedor="SIN INFORMACION" data-tipoactividad="'+datos.actividad[i].tipoActividad+'" data-status="'+datos.actividad[i].Status_Txt+'">';
    }
     else if (datos.actividad[i].nombreUsuarioVendedor==0) {
      row=row+'<tr data-subramo="'+datos.actividad[i].subRamoActividad+'" data-usuarioresponsable="'+datos.actividad[i].usuarioResponsable+'" data-nombreusuariovendedor="SIN REGISTRO" data-tipoactividad="'+datos.actividad[i].tipoActividad+'" data-status="'+datos.actividad[i].Status_Txt+'">';
     }
     else {
      row=row+'<tr data-subramo="'+datos.actividad[i].subRamoActividad+'" data-usuarioresponsable="'+datos.actividad[i].usuarioResponsable+'" data-nombreusuariovendedor="'+(datos.actividad[i].nombreUsuarioVendedor.trim())+'" data-tipoactividad="'+datos.actividad[i].tipoActividad+'" data-status="'+datos.actividad[i].Status_Txt+'">'; 
      
      }

      // Informaci�n de datos de tabla
     row=row+'<td onclick="abrirHijo(this)" data-rowhijo="rowHijo'+datos.actividad[i].idInterno+'">+</td>';
     row=row+'<td>'+datos.actividad[i].folioActividad+'</td>';
     row=row+'<td>'+datos.actividad[i].subRamoActividad+'</td>';
     row=row+'<td>'+datos.actividad[i].usuarioResponsable+'</td>';
     if (datos.actividad[i].nombreUsuarioVendedor==null) { //Campos nulos
        row=row+'<td>Sin información</td>';
     }
     else if (datos.actividad[i].nombreUsuarioVendedor==0) { //Campos vac�os
      row=row+'<td>Sin registro</td>';
     }
     else {
      row=row+'<td>'+datos.actividad[i].nombreUsuarioVendedor+'</td>';
     }
     row=row+'<td>'+datos.actividad[i].tipoActividad+'</td>';
     row=row+'<td>'+datos.actividad[i].Status_Txt+'</td>';
     let partidasCant=datos.actividad[i].partidas.length;
     if(datos.actividad[i].motivoCambio==1)
     {
      if(partidasCant<=2){row=row+'<td>COMPLETA</td>';completa++;}
      else{
           
                if(partidasCant==3)
                {   
                  let mat=["1","2","6"];
                  let bandCont=0;
                     if(mat.includes(datos.actividad[i].partidas[0].status)){bandCont++;}
                     if(mat.includes(datos.actividad[i].partidas[1].status)){bandCont++;}
                     if(mat.includes(datos.actividad[i].partidas[2].status)){bandCont++;}

                  if(bandCont==3)
                  {
                   row=row+'<td>COMPLETA</td>';completa++;
                  }
                  else
                  {
                    row=row+'<td>RETRABAJO</td>';retrabajo++;
                  }
                }
                else{row=row+'<td>RETRABAJO</td>';retrabajo++;}          }
     }
     else
      {
        if(datos.actividad[i].status==6)
        {
             if(partidasCant<=2){row=row+'<td>COMPLETA</td>';completa++;}
             else
              {
                if(partidasCant==3)
                {  //console.log(datos.actividad[i])
                  let mat=["1","2","6"];
                  let bandCont=0
                     if(mat.includes(datos.actividad[i].partidas[0].status)){bandCont++;}
                     if(mat.includes(datos.actividad[i].partidas[1].status)){bandCont++;}
                     if(mat.includes(datos.actividad[i].partidas[2].status)){bandCont++;}

                  if(bandCont==3)
                  {
                   row=row+'<td>COMPLETA</td>';completa++;
                  }
                  else{row=row+'<td>RETRABAJO</td>';retrabajo++;}
                }
             else{row=row+'<td>RETRABAJO</td>';retrabajo++;}
        }
        }
     else{row=row+'<td></td>';}
      }
     row=row+'</tr>';
    
      
      row=row+'<tr id="rowHijo'+datos.actividad[i].idInterno+'" class="ocultarObjeto" data-sof="0"><td></td><td><table class="table-dark" border="1">';
      for(let j=0;j<partidasCant;j++)
      {

       if(datos.actividad[i].partidas[j].status==6)
       {
                  row=row+'<tr class="info"><td>FINALIZADA</td><td>'+datos.actividad[i].partidas[j].fechaGrabado+'</td></tr>';
         
       }
       else{  
       row=row+'<tr class="info"><td>'+datos.actividad[i].partidas[j].motivoCambio+'</td><td>'+datos.actividad[i].partidas[j].fechaGrabado+'</td></tr>';
         }
      }               
      row=row+'</table></td></tr>';
     

   }
   // Secci�n final
   let subRamo='<h2>SubRamo</h2>';
   let usuarioResponsable='<h2>Usuario responsable</h2>';
   let tipoActividad='<h2>Tipo Actividad</h2>';
   let status='<h2>Status</h2>';
   let motivoCambio='<h2>Motivo de Cambio</h2>';
   let satisfaccion='<h2>Satisfaccion</h2>';
   //let satisfaccionEmision='<h2>Satisfaccion Emision</h2>';
   
 //for (var key in datos.subRamoActividad) { if (datos.subRamoActividad.hasOwnProperty(key)) { subRamo=subRamo+key+':'+datos.subRamoActividad[key]+'<br>';} }

  // Secci�n select del dropdown
  let optionSubRamo='<option></option>';
  let optionUsuarioResponsable='<option></option>';
  let optionNombreUsuarioVendedor='<option></option>'; 
  let optionTipoActividad='<option></option>';
  let optionStatus='<option></option>';


 for (var key in datos.subRamoActividad) { if (datos.subRamoActividad.hasOwnProperty(key)) { subRamo=subRamo+'<label style="width:100%;"><span class="badge pull-right">'+datos.subRamoActividad[key]+'</span>'+key+'</label><br>';} optionSubRamo=optionSubRamo+'<option>'+key+'</option>';}
  for (var key in datos.usuarioResponsable) { if (datos.usuarioResponsable.hasOwnProperty(key)) { usuarioResponsable=usuarioResponsable+'<label style="width:100%;"><span class="badge pull-right">'+datos.usuarioResponsable[key]+'</span>'+key+'</label><br>';} optionUsuarioResponsable=optionUsuarioResponsable+'<option>'+key+'</option>';}
  for (var key in datos.nombreUsuarioVendedor) { 
    if (datos.nombreUsuarioVendedor.hasOwnProperty(key)) optionNombreUsuarioVendedor=optionNombreUsuarioVendedor+'<option>'+key+'</option>'; 
      if (key==0) { // Campos vac�os
        optionNombreUsuarioVendedor=optionNombreUsuarioVendedor+'<option>SIN REGISTRO</option>';
      }
    }
  for (var key in datos.tipoActividad) { if (datos.tipoActividad.hasOwnProperty(key)) { tipoActividad=tipoActividad+'<label style="width:100%;"><span class="badge pull-right">'+datos.tipoActividad[key]+'</span>'+key+'</label><br>';} optionTipoActividad=optionTipoActividad+'<option>'+key+'</option>';}  
  for (var key in datos.statusTXT) { if (datos.statusTXT.hasOwnProperty(key)) { status=status+'<label style="width:100%;"><span class="badge pull-right">'+datos.statusTXT[key]+'</span>'+key+'</label><br>';}optionStatus=optionStatus+'<option>'+key+'</option>'; }
  for (var key in datos.motivoCambio) { if (datos.motivoCambio.hasOwnProperty(key)) { motivoCambio=motivoCambio+'<label style="width:100%;"><span class="badge pull-right">'+datos.motivoCambio[key]+'</span>'+key+'</label><br>';} }  
  for (var key in datos.satisfaccion) { if (datos.satisfaccion.hasOwnProperty(key)) { satisfaccion=satisfaccion+'<label style="width:100%;"><span class="badge pull-right">'+datos.satisfaccion[key]+'</span>'+key+'</label><br>';} } 
  //for (var key in datos.satisfaccionEmision) { if (datos.satisfaccionEmision.hasOwnProperty(key)) { satisfaccionEmision=satisfaccionEmision+'<label style="width:100%;"><span class="badge pull-right">'+datos.satisfaccionEmision[key]+'</span>'+key+'</label><br>';} } 

let motivosDeCambio=[];
for(let key of datos.motivosDeCambio)
{
  let mcArray=[{idMotivoCambio:key.idMotivaCambio,motivoCambio:key.motivoCambio,total:0}];
  motivosDeCambio.push(mcArray);
}

let partidas=datos.partidasTodas.length;
for(let i=0; i<partidas;i++)
{ 
  for(let val of motivosDeCambio)
  {    
    if(datos.partidasTodas[i].idMotivaCambio==val[0].idMotivoCambio){val[0].total++;}  
  }
}
for(let val of motivosDeCambio)
  {    
    
    motivoCambio+=`<label style="width:100%;"><span class="badge pull-right">${val[0].total}</span>${val[0].motivoCambio}</label><br>`;
  }

   document.getElementById('bodyActividadesReporte').innerHTML=row;
   document.getElementById('divSubRamoReporte').innerHTML=subRamo;
   document.getElementById('divUsuarioResponsableReporte').innerHTML=usuarioResponsable;
   document.getElementById('divTipoActividadReporte').innerHTML=tipoActividad;
   document.getElementById('divStatusReporte').innerHTML=status;
   document.getElementById('divMotivoCambioReporte').innerHTML=motivoCambio;
   document.getElementById('divSatisfaccionReporte').innerHTML=satisfaccion;
   document.getElementById('selectSubRamoReporte').innerHTML=optionSubRamo;
   document.getElementById('selectUsuarioResponsableReporte').innerHTML=optionUsuarioResponsable;
   document.getElementById('selectNombreUsuarioVendedorReporte').innerHTML=optionNombreUsuarioVendedor;
   document.getElementById('selectTipoActividadReporte').innerHTML=optionTipoActividad;
   document.getElementById('selectStatusReporte').innerHTML=optionStatus;
   document.getElementById('actividadesCompletas').innerHTML='Completas:'+completa+' - Retrabajo:'+retrabajo;
   //document.getElementById('actividadesRetrabajo').innerHTML=retrabajo;
   //document.getElementById('divSatisfaccionEmisionReporte').innerHTML=satisfaccionEmision;

    // Exportaci�n de los datos de tabla
      let tablaExportar=Array.from(document.getElementById('bodyActividadesReporte').rows);
    document.getElementById('tablaExportar').innerHTML='';
    let rowsExp='';
    tablaExportar.forEach(t=>{
      if(t.id===''){
        
        rowsExp+=`<tr><td>${t.cells[1].innerHTML}</td><td>${t.cells[2].innerHTML}</td><td>${t.cells[3].innerHTML}</td><td>${t.cells[4].innerHTML}</td><td>${t.cells[5].innerHTML}</td><td>${t.cells[6].innerHTML}</td><td>${t.cells[7].innerHTML}</td></tr>`;
        }
    })
    document.getElementById('tablaExportar').innerHTML='<thead><tr><td>Folio</td><td>subramo</td><td>usuarioresponsable</td><td>nombreusuariovendedor</td><td>tipoActividad</td><td>status</td><td>completa</td></tr></thead><tbody>'+rowsExp+'</tbody>';
  
  let responsablesNombres=Object.keys(datos.usuarioResponsable);
  let responsablesObjeto=new Array();


   responsablesNombres.forEach(val=>{
    let cantidadEncontrada=0
    
    responsableSR.forEach(res=>{
      if(res==val)
      {
        cantidadEncontrada++;
  
 }

    })
    responsablesObjeto.push({responsable:val,cantidad:cantidadEncontrada});
   })
   ;
  let tablaSemaforo='<table class="table"><thead><tr><th>RESPONSABLE</th><th>TOTAL ACTIVIDADES</th><th>TOTAL ROJOS</th><th>PORCENTAJE</th></tr></thead><tbody>';
  responsablesObjeto.forEach(val=>{
    let totalPorcentaje=0;
    if(val.cantidad>0){totalPorcentaje=(val.cantidad*100)/datos.usuarioResponsable[val.responsable]}
    tablaSemaforo+=`<tr><td>${val.responsable}</td><td align="right">${datos.usuarioResponsable[val.responsable]}</td><td align="right">${val.cantidad}</td><td align="right">${totalPorcentaje.toFixed(2)}%</td></tr>`
    
  })
  tablaSemaforo+='</tbody></table>';
  document.getElementById('divSemaforoActividades').innerHTML=tablaSemaforo;
 }
}

function manejoDePestanias(pestania)
{
  document.getElementsByClassName('verPestania')[0].classList.add('ocultarPestania');
  document.getElementsByClassName('verPestania')[0].classList.remove('verPestania');
  document.getElementById(pestania).classList.remove('ocultarPestania');
  document.getElementById(pestania).classList.add('verPestania');
}
function filtrarTabla(objeto)
{
  let index=objeto.parentNode.cellIndex;
  let tabla=document.getElementById('tbodyTablaActividades');
  let cant=tabla.rows.length;
  let dataBusqueda=objeto.getAttribute('data-busqueda')
  let data='data-'+dataBusqueda;
  if(objeto.value=='')
   {
    for(let i=0;i<cant;i++){tabla.rows[i].classList.remove('ocultar'+dataBusqueda);}
   }
 else
  {
    for(let i=0;i<cant;i++)
    {
     if(tabla.rows[i].getAttribute(data)==objeto.value){tabla.rows[i].classList.remove('ocultar'+dataBusqueda);}
     else{tabla.rows[i].classList.add('ocultar'+dataBusqueda);}
    }
  }
}
function textFiltroFolios(val)
{
   let body=document.getElementById('bodyActividades');
  let cant=body.rows.length;
  let textoFiltro=val.toUpperCase();  
  if(textoFiltro!='')
  {
   for(let i=0;i<cant;i++)
   {   
        if(body.rows[i].getAttribute('data-folioactividad').indexOf(textoFiltro)!==-1){body.rows[i].classList.remove('ocultarElemento');}
        else{body.rows[i].classList.add('ocultarElemento');}
   }
    }
  else{for(let i=0;i<cant;i++){body.rows[i].classList.add('verElemento');  }}

}
function verActividad(datos)
{ 
    let dir="<?echo(base_url());?>";
    dir=dir+'actividades/ver/';
    let folio="";   
    let radio=document.getElementsByName('radioActividad');
    let radioCant=radio.length;
    for(let i=0;i<radioCant;i++){if(radio[i].checked){folio=radio[i].parentNode.parentNode.getAttribute('data-folioactividad');i=radioCant;}}

    if(folio!='')
    {
     var a = document.createElement("a");
     a.target = "_blank";
     a.href = dir+folio;
     a.click();
    }
    else{alert('Seleccione una actividad');}
}
function verComentarios(datos)
{
  let params='';      
  if(datos=='')
  {
    let radio=document.getElementsByName('radioActividad');
    let radioCant=radio.length;
    for(let i=0;i<radioCant;i++){if(radio[i].checked){params=params+'idInterno='+radio[i].value;i=radioCant;}}
      if(params!='')
      {
       
       controlador="actividades/verComentarios/?";
       peticionAJAX(controlador,params,'verComentarios');
      }
      else
      {
        alert('Tiene que escoger alguna Actividad');
      }
   
  }
  else
  {
   let cant=datos.comentarios.length;
   let estadoActvidadesCantidad=datos.estadoActividades.length;
   let comentarios='';
   let estado='';
   for(let i=0;i<cant;i++){comentarios=comentarios+'<div class="row">'+datos.comentarios[i].FechaHora+'<br>'+datos.comentarios[i].Comentario+'</div><hr>';}
  for(let i=0;i<estadoActvidadesCantidad;i++)
   {
     estado=estado+'<tr><td>'+datos.estadoActividades[i].fechaGrabado+'</td><td>'+datos.estadoActividades[i].comentarioAP+'</td><td>'+datos.estadoActividades[i].motivoCambio+'</td><td>'+datos.estadoActividades[i].Nombre+'</td></tr>';
   }

    document.getElementById('estadoActivdadesTabla').innerHTML=estado;
   document.getElementById('divComentarios').innerHTML=comentarios;
  }
}
function consultarActividades(objeto=null)
{
  
 
  let seleccionado=document.getElementsByClassName('rowSeleccionado');
  if(seleccionado.length>0){seleccionado[0].classList.remove('rowSeleccionado');}
  objeto.classList.add('rowSeleccionado');
  let tr='<tr>';
  tr=tr+'<td>'+objeto.getAttribute('data-status')+'</td>';
  tr=tr+'<td>'+objeto.getAttribute('data-nombrecliente')+'</td>';
  tr=tr+'<td>'+objeto.getAttribute('data-ramoactividad')+'</td>';
  tr=tr+'<td>'+objeto.getAttribute('data-subramoactividad')+'</td>';
  tr=tr+'<td>'+objeto.getAttribute('data-usuariocreacion')+'</td>';
  tr=tr+'<td>'+objeto.getAttribute('data-usuariovendedor')+'</td>';
  tr=tr+'<td>'+objeto.getAttribute('data-usuarioresponsable')+'</td>'; 
  tr=tr+'<td>'+objeto.getAttribute('data-fechacreacion')+'</td>';
  tr=tr+'</tr>';
  let direccion="<?= base_url().'actividades/ver/'; ?>";
  direccion=direccion+objeto.getAttribute('data-folioactividad');
  document.getElementById('bodyActividadesConsulta').innerHTML=tr;
  document.getElementById('textIdInterno').value=objeto.getAttribute('data-idinterno');
  document.getElementById('btnVerComentarios').removeAttribute('disabled');
  document.getElementById('linkVerActividades').removeAttribute('disabled');
  document.getElementById('linkVerActividades').setAttribute('href',direccion);
  document.getElementById('divComentarios').innerHTML='';
}


function devolverActividades(datos,select=null)
{
	if(datos=='')
	{
      let params='';
      params=params+'idVend='+document.getElementById(select).value;
      controlador="actividades/devolverActividades/?";
      peticionAJAX(controlador,params,'devolverActividades');
	}
	else
	{
     let cant=datos.actividades.length;
     let rows="";
     for(let i=0;i<cant;i++)     	
     {

       rows=rows+'<tr data-idinterno="'+datos.actividades[i].idInterno+'" data-folioactividad="'+datos.actividades[i].folioActividad+'" data-status="'+datos.actividades[i].Status_Txt+'" data-nombrecliente="'+datos.actividades[i].nombreCliente+'" data-ramoactividad="'+datos.actividades[i].ramoActividad+'" data-subramoactividad="'+datos.actividades[i].subRamoActividad+'" data-usuariocreacion="'+datos.actividades[i].usuarioCreacion+'" data-usuariovendedor="'+datos.actividades[i].usuarioVendedor+'" data-usuarioresponsable="'+datos.actividades[i].usuarioResponsable+'" data-fechacreacion="'+datos.actividades[i].fechaCreacion+'" onclick="consultarActividades(this)"><td>'+datos.actividades[i].folioActividad+'</td><td>'+datos.actividades[i].tipoActividad+'</td>'
     }
     document.getElementById('bodyActividadesConsulta').innerHTML="";
     document.getElementById('bodyActividades').innerHTML=rows;
     document.getElementById('textIdInterno').value='';
     document.getElementById('divComentarios').innerHTML='';
     document.getElementById('btnVerComentarios').setAttribute('disabled','true');
     document.getElementById('linkVerActividades').setAttribute('disabled','true');
	}
	
}
 function peticionAJAX(controlador,parametros,funcion)
 {
 	  var req = new XMLHttpRequest();var direccionAJAX="<?= base_url();?>";
  var url=direccionAJAX+controlador;
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
        window[funcion](respuesta);
        document.getElementById('gifDeEspera1').classList.remove('verObjetoGif');
        document.getElementById('gifDeEspera1').classList.add('ocultarObjeto');
       }     
   }
  };
 req.send(parametros);

 }
 function filtrarSelect(texto,lista)
 {  let select=document.getElementById(lista);
 	let cant=select.length;
 	let textoFiltro=texto.toUpperCase(); 	
 	if(textoFiltro!='')
 	{
 	 for(let i=0;i<cant;i++)
 	 {   
        if(select[i].innerHTML.indexOf(textoFiltro)!==-1){select[i].classList.add('verElemento');select[i].classList.remove('ocultarElemento');}
        else{select[i].classList.remove('verElemento');select[i].classList.add('ocultarElemento');}
 	 }
    }
 	else{for(let i=0;i<cant;i++){select[i].classList.add('verElemento');  }}
 }
$(function () {
  

$(".fecha").datepicker({
  closeText: 'Cerrar',
  prevText: 'Anterior',
  nextText: 'Siguiente',
    currentText: 'Hoy',
    //currentDay:new Date(),
  monthNames: ['Enero','Febrero','Marzo','Abril','Mayo','Junio',
    'Julio','Agosto','Septiembre','Octubre','Noviembre','Diciembre'],
  dayNames:['Domingo','Lunes','Martes','Mi&eacute;rcoles','Jueves','Viernes','S&aacute;bado'] ,
  dayNamesShort:['Dom','Lun','Mar','Mi&eacute;','Juv','Vie','S&aacute;b'],
  dayNamesMin: ['Do','Lu','Ma','Mi','Ju','Vi','S&aacute;'],
  dateFormat: 'dd/mm/yy',
  firstDay: 1,       
});
});

function filtraSelect(valor,select){
 var filtro=valor.toUpperCase();
 var busqueda=document.getElementById(select);
 var contador=busqueda.length;var text="";
  for(var j=1;j<contador;j++)
    {text=busqueda[j].innerHTML.toUpperCase();

      if(text.indexOf(filtro)>=0){busqueda[j].classList.add('verElemento');busqueda[j].classList.remove('ocultarObjeto');}
      else{ busqueda[j].classList.add('ocultarObjeto'); busqueda[j].classList.remove('verElemento');}}
}


n =  new Date();
y = n.getFullYear();
m = n.getMonth() + 1;
d = n.getDate();

//Lo ordenas a gusto.
if(d<10){d='0'+d;}
if(m<10){m='0'+m;}
document.getElementById("fInicial").value =  y +'-'+ m + "-01" ;
document.getElementById("fFinal").value = y+ "-" + m + "-" + d;
</script>
<style type="text/css">
	.ocultarElemento{display: none}
	.verElemento{display: block;}
	.rowSeleccionado{background: green;color: white}
	.table  tbody>tr:hover{cursor: pointer;background: #c9f1c9}
  .gifEspera{position: absolute;left: 0%;top:0%;z-index: 10000000;width: 100%;height: 100%;background: none repeat scroll 0 0 #FFFFFF;border: 1px solid #DDDDDD;border-radius: 6px 6px 6px 6px;bottom: 200px;right: 10px;margin-left: 0px;padding: 0px 0 0;position: fixed;text-align: center;z-index: 10000;padding: 0px; margin: 0px; background-color: #FFFFFF; opacity: .5} 
  .ocultarObjeto{display: none;}
  .ocultarPestania{display: none}
  .verPestania{display: block}
  .ocultarstatustxt{display: none;} 
  .ocultarnombrecliente{display: none;} 
  .ocultarramoactividad{display: none;} 
  .ocultarsubramoactividad{display: none;}
  .ocultarusuariocreacion{display: none;} 
  .ocultarusuariovendedor{display: none;} 
  .ocultarusuarioresponsable{display: none;}
  .ocultaridpersona{display: none;}
  .ocultarfolioactividad{display: none;}
  .ocultarsubramo{display: none;}
  .ocultarnombreusuariovendedor{display: none;}
  .ocultarusuarioresponsable {display: none;}
  .ocultartipoactividad{display: none;}
  .ocultarstatus{display: none;}
  .form-control{min-width: 150px}
</style>


<?
#FUNCIONES PHP
$miVariable;
function imprimirAgentes($array)
{
	$option='<option value="" ></option>';
    foreach ($array as  $value) 
    {  if($value->idVend>0)
    	{$name=$value->nombres.' '.$value->apellidoPaterno.' '.$value->apellidoMaterno;
    	$option.='<option data-idpersona="'.$value->idPersona.'" value="'.$value->idPersona.'" >'.$name.'</option>';
    	}
    }
	return $option;
}
function imprimirTablaAgentes($array,$person)
{

 $rowCabecera='<thead>';
 $rowBody='<tbody id="tbodyTablaActividades">';
 //$status=new stdClass();
 $status=array();
 $nombreCliente=array();
 $ramoActividad=array();
 $subRamoActividad=array();
 $usuarioCreacion=array();
 $usuarioVendedor=array();
 $usuarioResponsable=array();
  
 foreach ($array as $key => $value) 
 {
   $val=(string)$value->Status_Txt;
   $status[$val]='';
   $nombreCliente[(string)$value->nombreCliente]='';
   $ramoActividad[(string)$value->ramoActividad]='';
   $subRamoActividad[(string)$value->subRamoActividad]='';
   $usuarioCreacion[(string)$value->usuarioCreacion]='';
   $usuarioVendedor[(string)$value->usuarioVendedor]='';
   $usuarioResponsable[(string)$value->usuarioResponsable]='';
   $rowBody.='<tr data-statustxt="'.$value->Status_Txt.'" data-nombrecliente="'.$value->nombreCliente.'" data-ramoactividad="'.$value->ramoActividad.'" data-subramoactividad="'.$value->subRamoActividad.'" data-usuariocreacion="'.$value->usuarioCreacion.'" data-usuariovendedor="'.$value->usuarioVendedor.'" data-usuarioresponsable="'.$value->usuarioResponsable.'" data-fechacreacion="'.$value->fechaCreacion.'" data-idpersona="'.$value->idPersona.'" data-folioactividad="'.$value->folioActividad.'">';
   $rowBody.='<td><input type="radio" value="'.$value->idInterno.'" name="radioActividad"></td>';    
   $rowBody.='<td>'.$value->folioActividad.'</td>';   
   $rowBody.='<td>'.$value->nombreVendedor.'</td>';   
   $rowBody.='<td>'.$value->Status_Txt.'</td>';
   $rowBody.='<td>'.$value->nombreCliente.'</td>';
   $rowBody.='<td>'.$value->ramoActividad.'</td>';
   $rowBody.='<td>'.$value->subRamoActividad.'</td>';
   $rowBody.='<td>'.$value->usuarioCreacion.'</td>';
   $rowBody.='<td>'.$value->usuarioVendedor.'</td>';
   $rowBody.='<td>'.$value->usuarioResponsable.'</td>';
   $rowBody.='<td>'.$value->fechaCreacion.'</td>';   
   $rowBody.='</tr>';
 }
 $rowBody.'</tbody>';
  
 $rowCabecera='<thead><tr><th></th><th><br><br><label>Folio<input type="text" class="form-control" onchange="filtrarTabla(this)" data-busqueda="folioactividad"></label></th><th><input type="text" class="form-control" placeholder="Filtro" onblur="filtraSelect(this.value,\'selectAgentesCabcecera\')"><label>Agente<select id="selectAgentesCabcecera" onchange="filtrarTabla(this)" data-busqueda="idpersona"  placeholder="Agente" class="form-control" >'.imprimirAgentes($person).'</select></label></th><th><br><br>'.armarFiltro($status,"statustxt","Estatus").'</th><th><input type="text" class="form-control" placeholder="Filtro" onblur="filtraSelect(this.value,\'selectClienteCabecera\')"><label>Cliente'.armarFiltro($nombreCliente,"nombrecliente","","selectClienteCabecera").'</label></th><th><br><br>'.armarFiltro($ramoActividad,"ramoactividad","Ramo").'</th><th><br><br>'.armarFiltro($subRamoActividad,"subramoactividad","Subramo").'</th><th><br><br>'.armarFiltro($usuarioCreacion,"usuariocreacion","Creador").'</th><th><br><br>'.armarFiltro($usuarioVendedor,"usuariovendedor","vendedor").'</th><th><br><br>'.armarFiltro($usuarioResponsable,"usuarioresponsable","Responsable").'</th><th></th></thead>';
 
 return $rowCabecera.$rowBody;
}

function armarFiltro($array,$data,$pleach='',$id='')
{ $idComponente="";
  if($id!=''){$idComponente='id="'.$id.'"';}
  $option='<label>'.$pleach.'<select '.$idComponente.' class="form-control" onchange="filtrarTabla(this)" data-busqueda="'.$data.'"  ><option></option>';
  foreach ($array as $key => $value) {$option.='<option>'.$key.'</option>';}
   $option.='</select></label>';
  return $option;
}


?>

<link rel="stylesheet" href="//code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
  <link rel="stylesheet" href="/resources/demos/style.css">
  <script src="https://code.jquery.com/jquery-1.12.4.js"></script>
  <script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
  <style type="text/css">
  .miTabla{width: 90%;height: 400px;display: block;;overflow: scroll;}
  

    select ::-webkit-scrollbar{width: 15px;}
  
  .table>thead{position: sticky;top:0px;z-index: 3}
  .table>thead>tr>th:nth-child(1){position: sticky;left:0px;z-index: 3;background: #472380;}
  .table>thead>tr>th:nth-child(2){position: sticky;left:75px;background: #472380;z-index: 3}


</style><table id="tablaExportar" style="display: none"></table>
<script type="text/javascript">
  
  
const $btnExportar = document.querySelector("#btnExportarEncuesta"),
    $tabla = document.querySelector("#tablaExportar");
$btnExportar.addEventListener("click", function() {
          document.getElementById('gifDeEspera1').classList.remove('verObjetoGif');
        
    let tableExport = new TableExport($tabla, {
        exportButtons: false, // No queremos botones
        filename: "Mi tabla de Excel", //Nombre del archivo de Excel
        sheetname: "Mi tabla de Excel", //Título de la hoja
    });
    
    let datos = tableExport.getExportData();
     
   let preferenciasDocumento = datos.tablaExportar.xlsx;
    tableExport.export2file(preferenciasDocumento.data, preferenciasDocumento.mimeType, preferenciasDocumento.filename, preferenciasDocumento.fileExtension, preferenciasDocumento.merges, preferenciasDocumento.RTL, preferenciasDocumento.sheetname);
    document.getElementById('gifDeEspera1').classList.add('ocultarObjeto');
});



function expReportePartidas()
{        table=document.getElementById('expReporte');
      let tableExport = new TableExport(table, {
        exportButtons: false, // No queremos botones
        filename: "PARTIDAS DE ACTIVIDADES", //Nombre del archivo de Excel
        sheetname: "ACTIVIDADES", //Título de la hoja
    });
    
    let datos = tableExport.getExportData();
     
         let preferenciasDocumento = datos.expReporte.xlsx;
    tableExport.export2file(preferenciasDocumento.data, preferenciasDocumento.mimeType, preferenciasDocumento.filename, preferenciasDocumento.fileExtension, preferenciasDocumento.merges, preferenciasDocumento.RTL, preferenciasDocumento.sheetname);
}
</script>
<style type="text/css">
  #bodyActividadesReporte>tr>td:nth-child(1){position: sticky;left:0px;;background: #50a7a7}
  #bodyActividadesReporte>tr>td:nth-child(2){position: sticky;left:70px;background: #50a7a7}
</style>
<script src="https://unpkg.com/xlsx@latest/dist/xlsx.full.min.js"></script>
<script src="https://unpkg.com/file-saverjs@latest/FileSaver.min.js"></script>
<script src="https://unpkg.com/tableexport@latest/dist/js/tableexport.min.js"></script>