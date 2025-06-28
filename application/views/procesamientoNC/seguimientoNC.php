<?php $this->load->view('headers/header'); ?>
<?php $this->load->view('headers/menu');   ?>
<link rel="stylesheet" href="http://code.jquery.com/ui/1.10.1/themes/base/jquery-ui.css" />
<script src="http://code.jquery.com/jquery-1.9.1.js"></script>
<script src="http://code.jquery.com/ui/1.10.1/jquery-ui.js"></script>

<div class="divPrincipal">
   <div class="divMenu">
    <div class="divBotonMenu" onclick="cambiaDivVista(0)">NC Activos</div>
    <div class="divBotonMenu" onclick="cambiaDivVista(1)">Reportes</div>

   </div>
   <div class="divContenido">
    <div class="divContenidoHijo verObjeto">
      <h1>Manejo de Inconformidades</h1>
      <hr>
      
      <div class="row">
        <table border="1">
          <thead id="theadNC">
            <tr>
              <th>Procedencia de inconformidad</th>
              <th>Fecha</th>
              <th>Persona inconforme</th>              
              <th>Persona responsable</th>
              <th>Descripcion</th>
              <th>Folio actividad</th>
              <th>Tipo actividad</th>
              <th>Datos alternos</th>
            </tr>
          </thead>
          <tbody id="tbodyNC" class="tbodyNC">
            <?= buzonInconformidad($tiposNC['calificaUsuario']);?>
            <?= validador($tiposNC['calificaCliente']);?>
            <?= inconformidadParaOperativos($tiposNC['calificaAgente']);?>
            <?= inconformidadParaAgentes($tiposNC['calificaOperativo']);?>
          </tbody>
          <tfoot>
            
          </tfoot>
        </table>
      </div>
    </div>
<div class="divContenidoHijo ocultarObjeto">
      <h1>Reportes</h1>
  <label>Fecha Inicial:<input  type="text" id="fechaInicial" name="fechaInicial" class="fecha form-control" ></label>
  <label>Fecha Final:<input type="text" id="fechaFinal" name="fechaFinal" class="fecha form-control" ></label>
  <!--select id="selectReporte" class="form-control">
    <option value='1' >Resueltos</option>
    <option value='0'>Pendientes</option>
    <option value='-1'>Todos</option>
  </select-->
  <button class="btn btn-primary" onclick="buscarReporte('')">Buscar</button>
      <hr>
<div style="width: 90%;height: 400px;overflow: scroll;">
  <table border="1">
          <thead id="theadReporte">
            <tr>
              <th>Procedencia de inconformidad</th>
              <th>fecha creacion</th>
              <th>Status de la inconformidad</th>
              <th>Veredicto</th>
              <th>Persona inconforme</th>              
              <th>Persona responsable</th>
              <th>Descripcion</th>
              <th>Folio actividad</th>
              <th>Tipo actividad</th>
              <th>Datos alternos</th>
              <th>Descripcion</th>
            </tr>
          </thead>
<tbody id="tbodyReporte">
  
</tbody>    
<tfoot>
  
</tfoot>
  </table>
</div>
<div id="divReporteResponsables"></div>
</div>

   </div>
   
</div>
<div id="divModalGenerico" class="modalCierra">
  <div style="width: 800px;height: 100%;overflow: scroll;margin-left: 20%; margin-top: 0%">
  <div class="modal-btnCerrar"><button onclick="cerrarModal('divModalGenerico')" style="color: white;background-color:red; border:double;">X</button>
    <hr>
    <div class="row" style="margin-left: 5%">
        <label>Causa raiz<select id="selectCausaRaiz" class="form-control"></select></label>
        <label>Accion correctiva<select id="selectAccionCorrectiva" class="form-control"></select></label>
        <label>Veredicto<select id="selectVeredicto" class="form-control"><option value="1">A favor</option><option value="0">En contra</option></select></label>
        <div class="row" >
          <div class="col-xs-8">
        <input type="text" id="textNombreNoConformidad" class="form-control" placeholder="agregar nombre a la no conformidad">
      </div>
        </div>

        <label>Persona<select id="selectTipoPersona" class="form-control" onchange="traerOperativo('')"><option></option><option>Agente</option><option>Operativo</option></select></label>
        <label>Persona<select id="selectPersona" class="form-control" class="btn"></select></label>
        <label><button class="btn" onclick="agregarPersona()">+</button></label>
        <div><button class="btn btn-primary" onclick="cerrarNoConformidad('')">Guardar</button><input type="hidden" id="textIdTablaNoConformidad"></div>
  </div></div>
    <div id="divModalContenidoGenerico" class="modal-contenido">      
      <div class="row" id="divSubModalContenidoGenerico"></div>
       <br>
      <div class="modal-contenido row" style="height: 100px;"><textarea style="width: 100%; height: 80px; max-height: 100px" placeholder="Añadir comentario" id="textComentario"></textarea></div>
      <h3>Responsables</h3>
      <div id="divContieneResponsables" style="border: solid black"></div>
      
    </div>    
</div>
</div>

<?php $this->load->view('footers/footer'); ?>
<script type="text/javascript">
  function ordenarFecha(body){
      body=document.getElementById(body);
      n=body.rows.length;

       for (k = 1; k < n; k++) {
              for (i = 0; i < (n - k); i++) {                
               fechaInner1=body.rows[i].cells[1].innerHTML;
              fechaInner2=body.rows[i+1].cells[1].innerHTML;  
              fecha1=Date.parse(fechaInner1);
              fecha2=Date.parse(fechaInner2);
            if(fecha1<fecha2){
              body.rows[i].parentNode.insertBefore(body.rows[i + 1], body.rows[i]);
            }
        }
      
       }


  }
  
  function cerrarNoConformidad(datos){    
   if(datos==''){
   parametros='idCausaRaiz='+document.getElementById('selectCausaRaiz').value;
   parametros=parametros+'&idAccionCorrectiva='+document.getElementById('selectAccionCorrectiva').value;
   parametros=parametros+'&comentario='+document.getElementById('textComentario').value;
   parametros=parametros+'&veredicto='+document.getElementById('selectVeredicto').value;
   parametros=parametros+'&idTablaNoConformidad='+document.getElementById('textIdTablaNoConformidad').value;
   parametros=parametros+'&nombreNoConformidad='+document.getElementById('textNombreNoConformidad').value;
   let idPersona="";
   let clase=document.getElementsByClassName('classPersona');
   let cantClase=clase.length;
   for(let i=0;i<cantClase;i++){
    console.log(clase[i]);
    idPersona=idPersona+clase[i].getAttribute('data-idPersona');
        if(clase[i].checked){idPersona=idPersona+'-1;';}
         else{idPersona=idPersona+'-0;';}
   }
    parametros=parametros+'&idPersona='+idPersona;
  
   peticionAJAX('procesamientoNC/cerrarNoConformidad',parametros,'cerrarNoConformidad');

   }
   else
   {
       let rowSeleccionado=document.getElementsByClassName('rowSeleccionado');
   document.getElementById('tbodyNC').deleteRow(rowSeleccionado[0].rowIndex-1);
   document.getElementById('textIdTablaNoConformidad').value='';
   document.getElementById('textNombreNoConformidad').value='';  
   document.getElementById('textComentario').value='';
     document.getElementById('divModalGenerico').classList.toggle('modalCierra');     
       document.getElementById('divModalGenerico').classList.toggle('modalAbre');
    alert(datos.mensaje);
   }
   
  }
function agregarPersona(){
  let select=document.getElementById('selectPersona');  
  let texto = select.options[select.selectedIndex].text;
  let valor=select.value;
  let clase=document.getElementsByClassName('classPersona');
  let cantClase=clase.length;
  let valorEncontrado=0;
  for(let i=0;i<cantClase;i++){
   if(clase[i].getAttribute('data-idPersona')==valor){valorEncontrado=1;i=cantClase;}
  }
  if(valorEncontrado==0){
  let div=document.createElement('div');
  div.text=texto;
  let input=document.createElement('input');
  input.setAttribute('type','checkbox');
  input.setAttribute('class', 'classPersona')   
  input.setAttribute('data-idPersona',valor);
  div.appendChild(input);
  let label=document.createElement('label');
  label.innerHTML=texto;
  div.appendChild(label);
  document.getElementById('divContieneResponsables').appendChild(div);
  }
}
function traerOperativo(datos)
{
if(datos!=''){
let option='';
cantDatos=datos.length;
 for(let i=0;i<cantDatos;i++){
  option=option+'<option value="'+datos[i].idPersona+'">'+datos[i].nombre+'</option>';
 }
 document.getElementById('selectPersona').innerHTML=option;
}
else{
  if(document.getElementById('selectTipoPersona').value=='Operativo'){
  peticionGetAJAX('crmproyecto/devolverOperativos/','','traerOperativo');
   }
   if(document.getElementById('selectTipoPersona').value=='Agente'){console
    peticionGetAJAX('crmproyecto/devolverAgentes/','','traerOperativo');
   }
}

}
function peticionGetAJAX(controlador,parametros,funcion){

  var req = new XMLHttpRequest();
  var direccionAJAX="<?= base_url();?>";
  var url=direccionAJAX+controlador+parametros;
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
          case 'traeAgentes':traeAgentes(respuesta);break;
          case 'traerOperativo':traerOperativo(respuesta);break;
         }                                                           
      }     
   }
  };
 req.send();
}
//----------------------------------------
function menejoDivGenerico(){
  document.getElementById('divModalGenerico').classList.toggle('modalCierra');
       document.getElementById('divModalGenerico').classList.toggle('modalAbre');
}
//----------------------------------------------------------------

  function buscaPersona(valor){
   alert(valor)
  }
  function cerrarInconformidad(){
    let rowSeleccionado=document.getElementsByClassName('rowSeleccionado');
    if(rowSeleccionado.length>0){
      
      document.getElementById('divSubModalContenidoGenerico').innerHTML='<table border="1" style="width: 85%;margin-left:5%">'+document.getElementById('theadNC').innerHTML+'<tbody><tr>'+rowSeleccionado[0].innerHTML+'</tr></tbody></table>';
       document.getElementById('divModalGenerico').classList.toggle('modalCierra');
       document.getElementById('divModalGenerico').classList.toggle('modalAbre');    
       document.getElementById('divContieneResponsables').innerHTML='';
       document.getElementById('textComentario').value='';
       console.log(rowSeleccionado[0].getAttribute('data-idTablaNoConformidad'));
       document.getElementById('textIdTablaNoConformidad').value=rowSeleccionado[0].getAttribute('data-idTablaNoConformidad');
  if(rowSeleccionado[0].getAttribute('data-idPersonaResponsable')!=''){
       let div=document.createElement('div');      
  let input=document.createElement('input');
  input.setAttribute('type','checkbox');
  input.setAttribute('class', 'classPersona')   
  input.setAttribute('data-idPersona',rowSeleccionado[0].getAttribute('data-idPersonaResponsable'));
  div.appendChild(input);
  let label=document.createElement('label');
  label.innerHTML=rowSeleccionado[0].getAttribute('data-nombre');
  div.appendChild(label);
  document.getElementById('divContieneResponsables').appendChild(div);
}

    }
    else{
      alert('Elegir inconformidad');
    }
  }
  function seleccionaRowInconformidad(trObjeto){
    let tbody=trObjeto.parentNode;
     cantRows=tbody.rows.length;
     for(let i=0;i<cantRows;i++){
      tbody.rows[i].classList.remove('rowSeleccionado');
     }
     trObjeto.classList.add('rowSeleccionado');
  }
  function cambiaDivVista(intVista){
    var divVista=document.getElementsByClassName('divContenidoHijo');    
    var cant=divVista.length;
    for(var i=0;i<cant;i++){
      divVista[i].classList.add('ocultarObjeto');
      divVista[i].classList.remove('verObjeto');
    }
    divVista[intVista].classList.add('verObjeto');

  }

function agregarCausaRaiz(datos){
 if(datos==""){
  let parametros='nombreCausaRaiz='+document.getElementById('textNombreACR').value;
  parametros=parametros+'&descripcionCausaRaiz='+document.getElementById('textDescripcionACR').value;
  peticionAJAX('procesamientoNC/causaRaiz',parametros,'agregarCausaRaiz');
 }else {
      
   document.getElementById('bodyACR').insertRow(0);
   document.getElementById('bodyACR').rows[0].setAttribute('data-idcausaraiz', datos.causaRaiz[0].idCausaRaiz)
   document.getElementById('bodyACR').rows[0].insertCell(0);
   document.getElementById('bodyACR').rows[0].insertCell(1);
  document.getElementById('bodyACR').rows[0].cells[0].innerHTML=datos.causaRaiz[0].causaRaiz;
  document.getElementById('bodyACR').rows[0].cells[1].innerHTML=datos.causaRaiz[0].descripcionCausaRaiz;
  llenaSelectCR();
 }
}
function agregarAccionCorrectiva(datos){
  if(datos==""){
  let parametros='nombreAccionCorrectiva='+document.getElementById('textNombreAAC').value;
  parametros=parametros+'&descripcionAccionCorrectiva='+document.getElementById('textDescripcionAAC').value;
  peticionAJAX('procesamientoNC/accionCorrectiva',parametros,'agregarAccionCorrectiva');
 }
 else {
     document.getElementById('bodyAAC').insertRow(0);  
   document.getElementById('bodyAAC').rows[0].setAttribute('data-idaccioncorrectiva', datos.accionCorrectiva[0].idAccionCorrectiva)
   document.getElementById('bodyAAC').rows[0].insertCell(0);
   document.getElementById('bodyAAC').rows[0].insertCell(1);
  document.getElementById('bodyAAC').rows[0].cells[0].innerHTML=datos.accionCorrectiva[0].accionCorrectiva;
  document.getElementById('bodyAAC').rows[0].cells[1].innerHTML=datos.accionCorrectiva[0].descripcionAccionCorrectiva;
  llenaSelectAC();
  }
}
function buscarReporte(datos){
 if(datos==""){
  let parametros='fechaInicial='+document.getElementById('fechaInicial').value;
  parametros=parametros+'&fechaFinal='+document.getElementById('fechaFinal').value;
  //parametros=parametros+'&selectReporte='+document.getElementById('selectReporte').value;
  peticionAJAX('procesamientoNC/buscarReporte',parametros,'buscarReporte');
 }else{
  
    if(datos.mensaje!='') {
      alert(datos.mensaje)
    }
    else{
      let rows="";
      let cantidad=datos.calificaUsuario.length;    
      
      if(datos.total==0){
        alert('No se encontraron NC en este rango de fechas');
        return false;
      }
  for(let i=0;i<cantidad;i++) {

  let select='<div>Responsables:<select>';  
    for(let j=0;j<datos.calificaUsuario[i].responsables.length;j++){
       select=select+'<option>'+datos.calificaUsuario[i].responsables[j].descricpioConformidadMala+'->'+datos.calificaUsuario[i].responsables[j].persona+'</option>'}
          select=select+'</select></div>';  

    rows=rows+'<tr>';
    rows=rows+'<td><div>Buzon inconformidad</div>'+select+'</td>';
    rows=rows+'<td>'+datos.calificaUsuario[i].fCreacion+'</td>';
    rows=rows+'<td>'+datos.calificaUsuario[i].descrNoConfomridadRevisada+'</td>';
    if(datos.calificaUsuario[i].noConformidadRevisada==1)
    {
      if(datos.calificaUsuario[i].aFavor==1){rows=rows+'<td>A favor</td>';}
      else{rows=rows+'<td>En contra</td>';}
     }
     else{rows=rows+'<td></td>'; }
    rows=rows+'<td>'+datos.calificaUsuario[i].personaInconforme+'</td>';
    rows=rows+'<td>'+datos.calificaUsuario[i].personaResponsable+'</td>';

    if(datos.calificaUsuario[i].descripcion){rows=rows+'<td>'+datos.calificaUsuario[i].descripcion+'</td>';}
    else{rows=rows+'<td></td>';}
    rows=rows+'<td></td>';
    rows=rows+'<td></td>';
   // rows=rows+'<td>'+datos.calificaUsuario[i].datosAlternos+'</td>';
let datosalternos=(datos.calificaUsuario[i].datosAlternos!=null) ? datos.calificaUsuario[i].datosAlternos : '';
   rows=rows+'<td>'+datosalternos+'</td>';
    rows=rows+'<td>'+datos.calificaUsuario[i].comentarioTNC+'</td>';
    rows=rows+'</tr>';
   /*rows=rows+'<tr>';
        rows=rows+'<td>';
          rows=rows+'<table border="1" class="ocultarObjeto" id="tablaReporte'+datos.calificaUsuario[i].idTablaNoConformidad+'">';
    
    for(let j=0;j<datos.calificaUsuario[i].responsables.length;j++){
                         rows=rows+'<tr>';
        rows=rows+'<td>';
        rows=rows+datos.calificaUsuario[i].responsables[j].persona;
        rows=rows+'</td>';
        rows=rows+'<td>';                                 
        rows=rows+datos.calificaUsuario[i].responsables[j].descricpioConformidadMala;
        rows=rows+'</td>';
                rows=rows+'</tr>';


    }
          rows=rows+'</table>';
        rows=rows+'</td>';

    rows=rows+'<tr>'; */

  }

       cantidad=datos.calificaCliente.length;          
  for(let i=0;i<cantidad;i++) {
    let select='<div>Responsables:<select>';  
    for(let j=0;j<datos.calificaCliente[i].responsables.length;j++){
       select=select+'<option>'+datos.calificaCliente[i].responsables[j].descricpioConformidadMala+'->'+datos.calificaCliente[i].responsables[j].persona+'</option>'}
          select=select+'</select></div>';  
    rows=rows+'<tr>';
    rows=rows+'<td><div>Validador</div>'+select+'</td>';
    rows=rows+'<td>'+datos.calificaUsuario[i].fCreacion+'</td>';
    rows=rows+'<td>'+datos.calificaCliente[i].descrNoConfomridadRevisada+'</td>';
    if(datos.calificaCliente[i].noConformidadRevisada==1)
    {
      if(datos.calificaCliente[i].aFavor){rows=rows+'<td>A favor</td>';}
      else{rows=rows+'<td>En contra</td>';}
     }
     else{rows=rows+'<td></td>'; }
    rows=rows+'<td>'+datos.calificaCliente[i].personaInconforme+'</td>';
    rows=rows+'<td>'+datos.calificaCliente[i].personaResponsable+'</td>';
    rows=rows+'<td>'+datos.calificaCliente[i].descripcion+'</td>';
    rows=rows+'<td></td>';
    rows=rows+'<td></td>';
    rows=rows+'<td>'+datos.calificaCliente[i].datosAlternos+'</td>';
    rows=rows+'<td>'+datos.calificaCliente[i].comentarioTNC+'</td>';
    rows=rows+'</tr>';
    /*rows=rows+'<tr>';
        rows=rows+'<td>';
          rows=rows+'<table border="1" class="ocultarObjeto" id="tablaReporte'+datos.calificaCliente[i].idTablaNoConformidad+'">';
    
    for(let j=0;j<datos.calificaCliente[i].responsables.length;j++){
                         rows=rows+'<tr>';
        rows=rows+'<td>';
        rows=rows+datos.calificaCliente[i].responsables[j].persona;
        rows=rows+'</td>';
        rows=rows+'<td>';                                 
        rows=rows+datos.calificaCliente[i].responsables[j].descricpioConformidadMala;
        rows=rows+'</td>';
                rows=rows+'</tr>';


    }
          rows=rows+'</table>';
        rows=rows+'</td>';

    rows=rows+'<tr>'; */

  }

       cantidad=datos.calificaAgente.length;          
  for(let i=0;i<cantidad;i++) {
    let select='<div>Responsables:<select>';  
    for(let j=0;j<datos.calificaAgente[i].responsables.length;j++){
       select=select+'<option>'+datos.calificaAgente[i].responsables[j].descricpioConformidadMala+'->'+datos.calificaAgente[i].responsables[j].persona+'</option>'}
          select=select+'</select></div>';  

    rows=rows+'<tr>';
    rows=rows+'<td><div>NC para operativos</div>'+select+'</td>';
    rows=rows+'<td>'+datos.calificaAgente[i].fCreacion+'</td>';
    rows=rows+'<td>'+datos.calificaAgente[i].descrNoConfomridadRevisada+'</td>';
    if(datos.calificaAgente[i].noConformidadRevisada==1)
    {                        
      if(datos.calificaAgente[i].aFavor){rows=rows+'<td>A favor</td>';}
      else{rows=rows+'<td>En contra</td>';}
     }
     else{rows=rows+'<td></td>'; }
    rows=rows+'<td>'+datos.calificaAgente[i].personaInconforme+'</td>';
    rows=rows+'<td>'+datos.calificaAgente[i].personaResponsable+'</td>';
    if(datos.calificaAgente[i].descripcion){rows=rows+'<td>'+datos.calificaAgente[i].descripcion+'</td>';}
    else{rows=rows+'<td></td>';}
    rows=rows+'<td></td>';
    rows=rows+'<td></td>';
    //rows=rows+'<td>'+datos.calificaAgente[i].datosAlternos+'</td>';
    let datosalternos=(datos.calificaAgente[i].datosAlternos!=null) ? datos.calificaAgente[i].datosAlternos : '';
   rows=rows+'<td>'+datosalternos+'</td>';
    rows=rows+'<td>'+datos.calificaAgente[i].comentarioTNC+'</td>';
    rows=rows+'</tr>';
  /*  rows=rows+'<tr>';
        rows=rows+'<td>';
          rows=rows+'<table border="1" class="ocultarObjeto" id="tablaReporte'+datos.calificaAgente[i].idTablaNoConformidad+'">';
    
    for(let j=0;j<datos.calificaAgente[i].responsables.length;j++){
                         rows=rows+'<tr>';
        rows=rows+'<td>';
        rows=rows+datos.calificaAgente[i].responsables[j].persona;
        rows=rows+'</td>';
        rows=rows+'<td>';                                 
        rows=rows+datos.calificaAgente[i].responsables[j].descricpioConformidadMala;
        rows=rows+'</td>';
                rows=rows+'</tr>';


    }
          rows=rows+'</table>';
        rows=rows+'</td>';

    rows=rows+'<tr>'; */

  }



       cantidad=datos.calificaOperativo.length;          
  for(let i=0;i<cantidad;i++) {
    let select='<div>Responsables:<select>';  
    for(let j=0;j<datos.calificaOperativo[i].responsables.length;j++){
       select=select+'<option>'+datos.calificaOperativo[i].responsables[j].descricpioConformidadMala+'->'+datos.calificaOperativo[i].responsables[j].persona+'</option>'}
          select=select+'</select></div>';  

let selectEstrella='<div>Estrellas:<select style="width:200px"><option>ver</option>';
for(let j=0;j<datos.calificaOperativo[i].estrellas.length;j++){
  let status='Mala';
  let clase='estrellaMala';
        
        
        if(datos.calificaOperativo[i].estrellas[j].calificacionActividad==1){status="Buena";clase="estrellaBuena"}
        selectEstrella=selectEstrella+'<option class="'+clase+'">'+status+'->'+datos.calificaOperativo[i].estrellas[j].calificacionAgente+'</option>';        
      }
selectEstrella=selectEstrella+'</select></div>';

    rows=rows+'<tr>';
    rows=rows+'<td><div>NC para Agentes<div>'+select+selectEstrella+'</td>';
    rows=rows+'<td>'+datos.calificaOperativo[i].fCreacion+'</td>';
    rows=rows+'<td>'+datos.calificaOperativo[i].descrNoConfomridadRevisada+'</td>';
    if(datos.calificaOperativo[i].noConformidadRevisada==1)
    {
      if(datos.calificaOperativo[i].aFavor){rows=rows+'<td>A favor</td>';}
      else{rows=rows+'<td>En contra</td>';}
     }
     else{rows=rows+'<td></td>'; }
    rows=rows+'<td>'+datos.calificaOperativo[i].personaInconforme+'</td>';
    rows=rows+'<td>'+datos.calificaOperativo[i].personaResponsable+'</td>';
    if(datos.calificaOperativo[i].descripcion){rows=rows+'<td>'+datos.calificaOperativo[i].descripcion+'</td>';}
    else{rows=rows+'<td></td>';}

    //rows=rows+'<td>'+datos.calificaOperativo[i].descripcion+'</td>';
    rows=rows+'<td></td>';
    rows=rows+'<td></td>';
    //rows=rows+'<td>'+datos.calificaOperativo[i].datosAlternos+'</td>';
    let datosalternos=(datos.calificaOperativo[i].datosAlternos!=null) ? datos.calificaOperativo[i].datosAlternos : '';
   rows=rows+'<td>'+datosalternos+'</td>';
    rows=rows+'<td>'+datos.calificaOperativo[i].comentarioTNC+'</td>';
    rows=rows+'</tr>';
    /*rows=rows+'<tr>';
        rows=rows+'<td>';
          rows=rows+'<table border="1" class="ocultarObjeto" id="tablaReporte'+datos.calificaOperativo[i].idTablaNoConformidad+'">';
    


    for(let j=0;j<datos.calificaOperativo[i].estrellas.length;j++){
                         rows=rows+'<tr>';
        rows=rows+'<td>';
        rows=rows+datos.calificaOperativo[i].estrellas[j].calificacionAgente;
        rows=rows+'</td>';
        if(datos.calificaOperativo[i].estrellas[j].calificacionActividad==1){
        rows=rows+'<td>Buena</td>';
        }else{
        rows=rows+'<td>Mala</td>';
                  
        }
        rows=rows+'</tr>';


    }
    for(let j=0;j<datos.calificaOperativo[i].responsables.length;j++){
                         rows=rows+'<tr>';
        rows=rows+'<td>';
        rows=rows+datos.calificaOperativo[i].responsables[j].persona;
        rows=rows+'</td>';
        rows=rows+'<td>';                                 
        rows=rows+datos.calificaOperativo[i].responsables[j].descricpioConformidadMala;
        rows=rows+'</td>';
                rows=rows+'</tr>';


    }
          rows=rows+'</table>';
        rows=rows+'</td>';

    rows=rows+'<tr>'; */

  }

   document.getElementById('tbodyReporte').innerHTML=rows;
   let tablaRevisadas="<table border='1'><tr><td>Persona</td><td>Buenas</td><td>malas</td><tr>";
   let totalRevisadas=datos.personaRevisada.length;
   console.log(datos);
   
  
   for(let i=0;i<totalRevisadas;i++){
    console.log(datos.personaRevisada[i]);
     tablaRevisadas=tablaRevisadas+'<tr>';
    tablaRevisadas=tablaRevisadas+'<td>'+datos.personaRevisada[i].nombre+'</td>';
    tablaRevisadas=tablaRevisadas+'<td>'+datos.personaRevisada[i].conformidaBuena.length+'</td>';
    tablaRevisadas=tablaRevisadas+'<td>'+datos.personaRevisada[i].conformidadMala.length+'</td>';
     tablaRevisadas=tablaRevisadas+'</tr>';
   
   }
   tablaRevisadas=tablaRevisadas+'</table>';
   document.getElementById('divReporteResponsables').innerHTML=tablaRevisadas;
   ordenarFecha('tbodyReporte');
    }

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
          case 'agregarCausaRaiz':agregarCausaRaiz(respuesta);break;
          case 'agregarAccionCorrectiva':agregarAccionCorrectiva(respuesta);break;
          case 'cerrarNoConformidad':cerrarNoConformidad(respuesta);break;
          case 'buscarReporte':buscarReporte(respuesta);break;

          
         }                                                           
      }     
   }
  };
 req.send(parametros);
}
function llenaSelectCR(){
  var tbody=document.getElementById('bodyACR');
  var option="";
  cantTbody=tbody.rows.length;
  for(let i=0;i<cantTbody;i++){
   option=option+'<option value="'+tbody.rows[i].getAttribute('data-idcausaraiz')+'">'+tbody.rows[i].cells[0].innerHTML+'</option>';
  }
  document.getElementById('selectCausaRaiz').innerHTML=option;  
}
function llenaSelectAC(){
  var tbody=document.getElementById('bodyAAC');
  var option="";
  cantTbody=tbody.rows.length;
  for(let i=0;i<cantTbody;i++){
   option=option+'<option value="'+tbody.rows[i].getAttribute('data-idaccioncorrectiva')+'">'+tbody.rows[i].cells[0].innerHTML+'</option>';
  }
  document.getElementById('selectAccionCorrectiva').innerHTML=option;  
}
function cerrarModal(modal){
     document.getElementById(modal).classList.toggle('modalCierra');
     document.getElementById(modal).classList.toggle('modalAbre');   
} 
function verGrid(id,objeto){
  
  let estado=document.getElementById('tabla'+id).classList.toggle('ocultarObjeto');
  if(estado){objeto.innerHTML="+";}else{objeto.innerHTML="-";}
}
function verDetalle(id,objeto){
  let estado=document.getElementById('tablaReporte'+id).classList.toggle('ocultarObjeto');
  if(estado){objeto.innerHTML="+";}else{objeto.innerHTML="-";}
}
llenaSelectCR();
llenaSelectAC();
</script>
<style>
 .divTD{width: 250px; overflow: auto;}
 .divTD100{width: 150px; overflow: auto;}
 .cabeceraOculta{opacity: 0; }
 .contTabla2{width: 100%; height:50px;overflow-x: hidden; overflow-y: hidden; }
 .contTabla{ width: 100%;height: 300px; overflow-x: hidden; overflow-y: scroll;}
 .tableV3{width: 100%}
 .tableV3>thead{background-color: #472380;color: white;}
 .rowActivo{background-color:#2ad52a; color:white;}
 .divPrincipal{width: 100%; display: flex; }
 .divMenu{min-width: 80px;  height: 350px;border: none; border-right: solid;border-bottom: solid;}
 .divContenido{width: 90%;margin-left: 30px  }
 .divBotonMenu{border:solid black .1em;background-color:  #e6e6e6}
 .divBotonMenu:active{color:red;background-color:#a373ef87}
 .divBotonMenu:hover{color:#a373ef87;cursor: pointer;}
  .ocultarObjeto{display: none}
  .verObjeto{display: block;}
  .tbodyNC > tr:hover{background-color: #85cc85}
  .rowSeleccionado{background-color: green}
  .modal-btnCerrar{background-color:white;width:800px;padding: 0% 0%;margin: 0% auto;position: relative;z-index: 1000 }
.modal-contenido{background-color:white;width:800px;height:100%;padding: 0% 0%;margin: 0% auto;position: relative;z-index: 1000 }
.modalCierra{background-color: rgba(0,0,0,.8);position:fixed;top:0;right:0;bottom:0px;left:0;opacity:0;transition: all 1s;display:none;z-index: 1000}
.modalAbre{background-color: rgba(0,0,0,.8);position:fixed;top:0;right:0;bottom:0px;left:-100;transition: all 1s;width:100%;height:100%;display:block;relative;z-index: 1000}
.labelEditar{display: block; }
.labelEditar input{width: 100%; border: solid 1px black; color: black; background-color: #d7d1e1}
.divEspera{width: 80px;height: 80px;margin-top: -23px;margin-left: -163px;left: 50%;top: 50%;position: absolute;}
  .estrellaMala{background-color: #F7DC6F; color:black; ; margin-left: 50px}
  .estrellaBuena{background-color: #52BE80;color:black;}
</style>
<?php
function validador($array){
  $datos="";
  foreach ($array as  $value) {
    $datos.='<tr onclick="seleccionaRowInconformidad(this)" data-idTablaNoConformidad="'.$value->idTablaNoConformidad;
    $datos.='" data-idPersonaResponsable="'.$value->idPersonaResponsable.'" data-nombre="'.$value->personaResponsable.'" data-nombre="'.$value->personaResponsable.'">';
     $datos.='<td>Validaddor</td>';
     $datos.='<td>'.$value->fCreacion.'</td>';
     $datos.='<td>'.$value->personaInconforme.'</td>';
     $datos.='<td>'.$value->personaResponsable.'</td>';
     $datos.='<td>'.$value->descripcion.'</td>';
     $datos.='<td></td>';
     $datos.='<td></td>';
    $datos.='<td>'.$value->datosAlternos.'</td>';
    $datos.='</tr>';
  }
  return $datos;
}
function inconformidadParaAgentes($array){
  $datos="";
  
  foreach ($array as  $value) {
    //$fp=fopen('resultadoJason.txt', 'a');fwrite($fp, print_r($value, TRUE));fclose($fp); 
    $select='<select style="width:150px"><option>Ver calificacion</option>';
        foreach ($value->estrellas as $valueEstrellas) {
      $tipoEstrella='estrellaBuena';
      if($valueEstrellas->calificacionActividad==0){$tipoEstrella='estrellaMala';}
    $select.='<option class="'.$tipoEstrella.'">'.$valueEstrellas->calificacionAgente.'</option>'; 
    }
    $select.='<select>';
    $datos.='<tr onclick="seleccionaRowInconformidad(this)" data-idTablaNoConformidad="'.$value->idTablaNoConformidad.'" data-idPersonaResponsable="'.$value->idPersonaResponsable.'" data-nombre="'.$value->personaResponsable.'" data-nombre="'.$value->personaResponsable.'">';
     $datos.='<td>NC para Agentes'.$select.'</td>';
     $datos.='<td>'.$value->fCreacion.'</td>';
     $datos.='<td>'.$value->personaInconforme.'</td>';
     $datos.='<td>'.$value->personaResponsable.'</td>';
     $datos.='<td></td>';
     $datos.='<td>'.$value->folioActividad.'</td>';
     $datos.='<td>'.$value->tipoActividad.'</td>';         
     $datos.='<td></td>';         
    $datos.='</tr>';
    /*$datos.='<tr><td><table border="1" class="ocultarObjeto" style="margin-left: 50px" id="tabla'.$value->idTablaNoConformidad.'">';
    foreach ($value->estrellas as $valueEstrellas) {
      $tipoEstrella='estrellaBuena';
      if($valueEstrellas->calificacionActividad==0){$tipoEstrella='estrellaMala';}
    $datos.='<tr class="'.$tipoEstrella.'"><td colspan="7">'.$valueEstrellas->calificacionAgente.'</td></tr>'; 
    }
    
    $datos.='</table></td></tr>'*/;         
  }
  return $datos; 
}
function inconformidadParaOperativos($array){
  $datos="";
  foreach ($array as  $value) {
    $datos.='<tr onclick="seleccionaRowInconformidad(this)" data-idTablaNoConformidad="'.$value->idTablaNoConformidad.'" data-idPersonaResponsable="'.$value->idPersonaResponsable.'" data-nombre="'.$value->personaResponsable.'" data-nombre="'.$value->personaResponsable.'">';
     $datos.='<td>NC para operativos</td>';
     $datos.='<td>'.$value->fCreacion.'</td>';
     $datos.='<td>'.$value->personaInconforme.'</td>';
     $datos.='<td>'.$value->personaResponsable.'</td>';
     $datos.='<td>'.$value->comentarioActividad.'</td>';
     $datos.='<td>'.$value->folioActividad.'</td>';
     $datos.='<td>'.$value->tipoActividad.'</td>';         
     $datos.='<td></td>';         
    $datos.='</tr>';
  }
  return $datos; 
}
function buzonInconformidad($array){
  $datos="";
  
  foreach ($array as  $value) {
    $datos.='<tr onclick="seleccionaRowInconformidad(this)" data-idTablaNoConformidad="'.$value->idTablaNoConformidad;
    $datos.='" data-idPersonaResponsable="'.$value->idPersonaResponsable.'" data-nombre="'.$value->personaResponsable.'" >';
     $datos.='<td>Buzon inconformidad</td>';
     $datos.='<td>'.$value->fCreacion.'</td>';
     $datos.='<td>'.$value->personaInconforme.'</td>';
     $datos.='<td>'.$value->personaResponsable.'</td>';
     $datos.='<td>'.$value->descripcion.'</td>';
     $datos.='<td></td>';
     $datos.='<td></td>';
     $datos.='<td>'.$value->datosAlternos.'</td>';

    $datos.='</tr>';
  }
  return $datos;
}
function imprimirCausaRaiz($datos){
$tbody="";
foreach ($datos as  $value) {
  $tbody.='<tr data-idcausaraiz="'.$value->idCausaRaiz.'">';
  $tbody.='<td>'.$value->causaRaiz.'</td>';
  $tbody.='<td>'.$value->descripcionCausaRaiz.'</td>';
  $tbody.='</tr>';
}
return $tbody;
}
function imprimirAccionCorrectiva($datos){
$tbody="";
foreach ($datos as  $value) {
  $tbody.='<tr data-idaccioncorrectiva="'.$value->idAccionCorrectiva.'">';
  $tbody.='<td>'.$value->accionCorrectiva.'</td>';
  $tbody.='<td>'.$value->descripcionAccionCorrectiva.'</td>';
  $tbody.='</tr>';
}
return $tbody;
}

?>
<script type="text/javascript">

$(function () {$(".fecha").datepicker({
  closeText: 'Cerrar',prevText: 'Anterior',nextText: 'Siguiente',currentText: 'Hoy',
  monthNames: ['Enero','Febrero','Marzo','Abril','Mayo','Junio','Julio','Agosto','Septiembre','Octubre','Noviembre','Diciembre'],
  dayNames:['Domingo','Lunes','Martes','Mi&eacute;rcoles','Jueves','Viernes','S&aacute;bado'] ,
  dayNamesShort:['Dom','Lun','Mar','Mi&eacute;','Juv','Vie','S&aacute;b'],
  dayNamesMin: ['Do','Lu','Ma','Mi','Ju','Vi','S&aacute;'],
  dateFormat: 'dd/mm/yy',
  firstDay: 1,       
});
});

var f = new Date();
//document.write(f.getDate() + "/" + (f.getMonth() +1) + "/" + f.getFullYear());
document.getElementById('fechaInicial').value="01/" + (f.getMonth() +1) + "/" + f.getFullYear();
document.getElementById('fechaFinal').value=f.getDate() + "/" + (f.getMonth() +1) + "/" + f.getFullYear();
ordenarFecha('tbodyNC');
</script>


