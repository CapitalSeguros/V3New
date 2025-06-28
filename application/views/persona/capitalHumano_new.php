<? $this->load->view('headers/header'); ?>
<!-- Navbar -->
<? $this->load->view('headers/menu'); ?>
<script type="text/javascript">
 window.onload=function() {
    document.body.setAttribute('onpaste','manejarCopiado()');}
   function manejarCopiado(){


</script>
<style type="text/css">
   #archivoImagen {
      display: none;
    }
    #archivoDocumento {
      display: none;
    }
   .btn-primary {
    color: #fff;
    background-color: #67439f;
    border-color: #57348c;
  }
  .btn-primary:hover{
    background-color: #DBA901;
    border-color: #DBA901;
  }
</style>
<link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.10.21/css/jquery.dataTables.css">
<div class="container">
<div style="margin-top: 5px;">
	<button onclick="nuevoPuesto()" class="btn btn-primary"><i class="fa fa-plus-circle"></i> Nuevo puesto</button>
	<button onclick="modificarPuesto()" class="btn btn-primary"><i class="fa fa-edit"></i> Modificar puesto</button>
	<button onclick="enviaForm(1)"  class="btn btn-primary"><i class="fa fa-folder"></i> Guardar</button>

  <hr>
</div>

<div class="row">
<div class="col-md-4">
<label><i class="fa fa-filter" aria-hidden="true"></i> Puestos</label><select id="buscarIdPuesto" class="buscarPuesto form-control"></select> <button class="btn btn-primary btn-sm" onclick="enviaForm(2)"><i class="fa fa-search"></i>Buscar</button>
</div>
<div class="col-md-4">  
  <input type="hidden" class="puesto" id="idPuesto">
  <label><i class="fa fa-filter" aria-hidden="true"></i> Nombre del Puesto</label><input class="puesto form-control" id="personaPuesto" type="text" name="" style="width: 300px">
</div>
<div class="col-md-4">  
  <label><i class="fa fa-filter" aria-hidden="true"></i> Depende</label><select class="puesto form-control" id="padrePuesto"></select>
</div>
</div>


</div>
<br>
<div>
  <button class="btn" onclick="manejoPestanias('divOrganigrama')"><i class="fa fa-sitemap" aria-hidden="true"></i> Organigrama</button> 
  <button class="btn" onclick="manejoPestanias('divManual')"><i class="fa fa-file-text" aria-hidden="true"></i> Manual</button>  
  <button class="btn" onclick="manejoPestanias('divProcesos')"><i class="fa fa-th-large" aria-hidden="true"></i> Procedimientos</button> 
  <button class="btn" onclick="manejoPestanias('divFunciones')"><i class="fa fa-plus-square" aria-hidden="true"></i> Funciones</button> 
  <button class="btn" onclick="manejoPestanias('divMatrizProc')"><i class="fa fa-th" aria-hidden="true"></i> Matrices de Procedimientos</button>
  <button class="btn" onclick="manejoPestanias('divMatrizDoc')"><i class="fa fa-file" aria-hidden="true"></i> Documentos</button>
</div>

</div>
	
<hr>
<div id="divBarTool" class="ocultarObjeto" style="">
	<div class="divBarTool">
 <button class="btn" onclick="insertaObjetos('p')">Parrafo </button>
 <button class="btn" onclick="insertaObjetos('ul')">Lista</button>
 <button class="btn" onclick="insertaObjetos('check')">Checkbox</button>
 <button class="btn" onclick="insertaObjetos('a')">Link</button>
 <button class="btn" onclick="insertaObjetos('table')">Tabla</button>
 <button class="btn" onclick="insertaObjetos('tr')">fila</button>
 <button class="btn" onclick="insertaObjetos('td')">columna</button>
  </div>
  <div class="divBarTool">
 <button class="btn" onclick="eliminarFila()">Eliminar Fila</button>
 <button class="btn" onclick="eliminarColumna()">Eliminar Columna</button>
 <button class="btn" onclick="eliminarObjeto()">Eliminar</button>
  <!--button class="btn" onclick="tamanioCeldas()">+</button-->
  <!--button class="btn" onclick="tamanioCeldas()">-</button-->
 </div>
 <div class="divBarTool">
 <button class="btn" onclick="formatoTexto('bold')">Negrita</button>
 <button class="btn" onclick="formatoTexto('underline')">Subrayado</button>
 <button class="btn" onclick="formatoTexto('foreColor')">Color</button>
 <button class="btn" onclick="formatoTexto('backColor')">Fondo</button>
 <input type="color" id="colorTextMU">
</div>
 <div>
 	<!--button class="btn"  onclick="datosParaPlantilla()">Datos para plantilla</button-->
 <button class="btn"  onclick="imprimirManualUsuario()">Imprimir</button>
  <button class="btn"  onclick="imprimirTodoElManual()">Imprimir Todo</button>

 <button class="btn"  onclick="guardarManualUsuario()">Guardar</button>
 </div>
 </div>
<div id="divOrganigrama" style="width: 1200px;height: auto;overflow-x: scroll;" class="divPestania varObjeto">
<div style="margin-left: 2%;">
<button data-toggle="modal" data-target="#subir_organigrama" class="btn btn-primary"><i class="fa fa-upload"></i> Subir Organigrama</button></div>
<br>
<div style="width: 100%;height: auto;margin: 10px;">
<?php 
$ruta_imagen="https://firebasestorage.googleapis.com/v0/b/v3plus-279402.appspot.com/o/organigrama%2F";?>
<div class="row">
<?php
foreach($mapa as $recurso){
  $data_imagen = json_decode(file_get_contents($ruta_imagen.$recurso->url_imagen), true );
  $token= $data_imagen['downloadTokens'];
  $url_imagen=$ruta_imagen.$recurso->url_imagen."?alt=media&token=".$token;
?>

  <div class="col-md-6">
    <a href="<?php echo $url_imagen;?>"><img src="<?php echo $url_imagen;?>" style="width: 100%;"></a>
  </div>
<?php }?>
</div>
</div>
</div>



<div id="divOrganigrama" style="width: 1200px;height: auto;overflow-x: scroll;" class="divPestania varObjeto">
<div id="divOrganigramaContenedor"  class="tree" style="width: 4500px;height:auto;min-height: 400px;display: none;"></div>
</div>

<div style="" id="divFuncionesAsignar">

</div>
<div style="clear: both; margin-left: 2%;margin-right: 2%">
<br>
<input type="hidden" id="sw" value="0">
<div id="divManual" class="divPestania ocultarObjeto divAparienciaManuales" >

	<div  class="divPadreContMU"><div><label class="labelTitContMU"  onclick='manejoVistaContenido("divContenidoPRP")' >PRINCIPALES REQUERIMIENTOS DEL PUESTO</label></div>
	    <div   id="divContenidoPRP" class="divContMU" style="display: none;"></div>
	</div>
	<div  class="divPadreContMU"><div><label class="labelTitContMU"  onclick='manejoVistaContenido("divContenidoPP")' >PERFIL DE PUESTO</label></div>
	    <div   id="divContenidoPP" class="divContMU" style="display: none;"></div>
	</div>
	<div  class="divPadreContMU"><div><label class="labelTitContMU"  onclick='manejoVistaContenido("divContenidoMP")' >MISION DEL PUESTO</label></div>
	    <div   id="divContenidoMP" class="divContMU" style="display: none;"></div>
	</div>
	<div  class="divPadreContMU"><div><label class="labelTitContMU"  onclick='manejoVistaContenido("divContenidoFPR")' >FUNCIONES PROPIETARIAS Y RESPONSABILIDADES</label></div>
	    <div   id="divContenidoFPR" class="divContMU" style="display: none;"></div>
	</div>
	<div  class="divPadreContMU"><div><label class="labelTitContMU"  onclick='manejoVistaContenido("divContenidoEC")' >ESQUEMA DE COMUNICACIONES</label></div>
	    <div   id="divContenidoEC" class="divContMU" style="display: none;"></div>
	</div>
	<div  class="divPadreContMU"><div><label class="labelTitContMU"  onclick='manejoVistaContenido("divContenidoAGT")' >AREAS GEOGRAFICAS DE TRABAJO</label></div>
	    <div   id="divContenidoAGT" class="divContMU" style="display: none;"></div>
	</div>
<div  class="divPadreContMU"><div><label class="labelTitContMU"  onclick='manejoVistaContenido("divContenidoCTD")' >CAPACITACION, TALLERES O DIPLOMADOS NECESARAS PUESTO</label></div>
	    <div   id="divContenidoCTD" class="divContMU" style="display: none;"></div>
	</div>
	<div  class="divPadreContMU"><div><label class="labelTitContMU"  onclick='manejoVistaContenido("divContenidoPER")'>PRINCIPALES ENLACES Y REPORTES</label></div>
	    <div   id="divContenidoPER" class="divContMU" style="display: none;"></div>
	</div>
	<div  class="divPadreContMU"><div><label class="labelTitContMU"  onclick='manejoVistaContenido("divContenidoNCBC")' >NORMAS DE INGRESOS, COMISIONES, BONOS Y COMPENSACIONES</label></div>
	    <div   id="divContenidoNCBC" class="divContMU" style="display: none;"></div>
	</div>

	<div  class="divPadreContMU"><div><label class="labelTitContMU"  onclick='manejoVistaContenido("divContenidoPO")' >POSICION ORGANIZACIONAL</label></div>
	    <div   id="divContenidoPO" class="divContMU" style="display: none;"></div>
	</div>
	<div  class="divPadreContMU"><div><label class="labelTitContMU"  onclick='manejoVistaContenido("divContenidoDIO")' >DOCUMENTOS PARA INGRESO A LA ORGANIZACION</label></div>
	    <div   id="divContenidoDIO" class="divContMU" style="display: none;"></div>
	</div>


  </div>
 <div id="divProcesos" class="divPestania ocultarObjeto divAparienciaManuales">	
 	 	<div><select id="selectOpcionProc" onchange="selectOpcionProc(this)"><option value="-1"></option><option value="divCapturaFuncion">Funcion</option><option value="divCapturaMP">Matriz procedimiento</option></select>
 	 		<div id="divCapturaFuncion" class="ocultarObjeto"><select id="selectCapturaFuncion" onchange="selectCapturaFuncion(this)"></select><select onchange="selectCapturaProc(this)" id="selectCapturaProc" style="width: 50%"></select></div>
 	 		<div id="divCapturaMP" class="ocultarObjeto"><select id="selectCapturaMP" onchange="selectCapturaMP(this)"></select></div>
 	 	</div>
    	<div class="divPadreContMU">
	     <div><label class="labelTitContMU" onclick='manejoVistaContenido("divContODPProc")'>OBJETIVO DEL PROCEDIMIENTO</label></div>
	    <div  id="divContODPProc" class="divContMU" style="display: none;"></div>
    </div>
    <div class="divPadreContMU">
	     <div><label class="labelTitContMU" onclick='manejoVistaContenido("divContAPProc")'>ALCANCE DEL PROCEDIMIENTO</label></div>
	    <div  id="divContAPProc" class="divContMU" style="display: none;"></div>
    </div>
       <div class="divPadreContMU">
	     <div><label class="labelTitContMU" onclick='manejoVistaContenido("divContRAProc")'>RESPONSABILIDAD Y AUTORIDAD</label></div>
	    <div  id="divContRAProc" class="divContMU" style="display: none;"></div>
	</div>
	        <div class="divPadreContMU">
	     <div><label class="labelTitContMU" onclick='manejoVistaContenido("divContDTAProc")'>DEFINICIONES, TERMINOS Y ACRONIMOS</label></div>
	    <div  id="divContDTAProc" class="divContMU" style="display: none;"></div>
    </div>
         <div class="divPadreContMU">
	     <div><label class="labelTitContMU" onclick='manejoVistaContenido("divContPPProc")'>POLITICAS DE PROCEDIMIENTO</label></div>
	    <div  id="divContPPProc" class="divContMU" style="display: none;"></div>
    </div>
        <div class="divPadreContMU">
       <div><label class="labelTitContMU" onclick='manejoVistaContenido("divContDiagrama")'>DIAGRAMA DE PROCEDIMIENTOS</label></div>
      <div  id="divContDiagrama" class="divContMU" style="display: none;"></div>
    </div>
    <div class="divPadreContMU">
	     <div><label class="labelTitContMU" onclick='manejoVistaContenido("divContDPProc")'>DESCRIPCION DEL PROCEDIMIENTO</label></div>
	    <div  id="divContDPProc" class="divContMU" style="display: none;"></div>
    </div>
    <div id="archivosDelProcedimiento"></div>
</div>

</div>
<div id="divFunciones" class="divPestania ocultarObjeto">
	<div class="divPrincipal">

<div>
	<div style="border:solid;width: 30%;float: left; margin-right: 5%">


    <input type="hidden" id="idFuncionProceso" class="funcionProceso">
	<input type="text" id="inputFunciones" class="funcionProceso" placeholder="Agregar Funcion">
	<label>Clasificacion:</label><select id="tipoFuncion" class="funcionProceso"><option value="0">Descriptiva</option><option value="1">Medible</option></select>
    <button class="btn-primary" onclick="direccionAJAX(0,null)">Guardar Funcion</button>
  <hr>


   <table id="tablaFunciones" class="tableFunciones" border="1"></table>

   </div>
	<div style="border:solid;width: 30%;float: left;margin-right: 5%">	
  
	<textarea id="inputProcedimientos" ></textarea>
    <button class="btn-primary" onclick="direccionAJAX(1,null)">Guardar Procedimiento</button>  
    
 <form id="formDocumento" action="javascript: enviarArchivoAJAX('formDocumento','guardaDocumentoProc')">
  <label  for="archivoProc" class="btn-primary">Agregar Documento</label>
  <input type="file" class="custom-file-input" name="documentos" id="archivoProc" onchange="if(!this.value.length)return false;document.getElementById('formDocumento').submit();" style="opacity: 0; width: 5px"/>
  <input class="btn" type="hidden" name="idFuncionProcedimiento" id="idArchivoProc">
</form>
<form id="formDiagrama" action="javascript: enviarArchivoAJAX('formDiagrama','guardarDiagrama')">
  <label  for="archivoDiagrama" class="btn-primary">Agregar Diagrama</label>
  <input type="file" class="custom-file-input" name="documentos" id="archivoDiagrama" onchange="if(!this.value.length)return false;this.form.submit();" style="opacity: 0; width: 5px"/>
  <input class="btn" type="hidden" name="idFuncionProcedimiento" id="idArchivoProcDiagrama">
</form>
<hr>
   <div style="width:100%px;height:400px;overflow:scroll"><table style="width: 100%" id="tablaProcedimientos" border="1"></table></div>

   </div>
   	<div style="border:solid;width: 30%;float: left;">

   <textarea id="inputPasos" ></textarea>
    <button class="btn-primary" onclick="direccionAJAX(4,null)">Guardar Pasos</button>
    <hr>
  <table id="tablaPasos" border="1"></table>
	  </div>

</div>
</div>
</div>
<div id="divMatrizProc" class="divPestania ocultarObjeto">
<div  style="float: left;border:solid;margin-right: 5%; width: 40%;overflow: scroll;">
 <div >
 	<select id="SelectparaMP"></select><button onclick="direccionAJAX(7,null)" class="btn btn-primary"><i class="fa fa-search"></i>Buscar procedimientos</button>
 </div>
 <hr><hr>
 <div id="listaProc"></div>
</div>
<div   style="float: left; border:solid;width: 50%;overflow: scroll;">
	<button class="btn-primary" onclick="direccionAJAX(8,null)">Matriz Procedimientos</button>    	
	<textarea  id="inputNuevoMP" placeholder="Agregar matriz procedimientos"></textarea>
	<select id="selectMP" onchange="onchangeSelectMP(this)"></select>
   <hr> <hr> 
	<div id="contFuncionAsignadasMP"></div>
</div>	
</div>
<div id="cuadroDialogo" class="ocultarObjeto">
 <div><button class="btn btn-primary btn-xs contact-item" onclick="cuadroDeDialogoOnCLick(this)">Cerrar</button></div>
 <div id="cuadroDialogoContenido">Contenido</div>
</div>

<div id="divMatrizDoc" class="divPestania ocultarObjeto" style="height: 350px;margin-left: 2%;width: 90%">
   <button data-toggle="modal" data-target="#subir_documento" class="btn btn-primary"><i class="fa fa-plus-circle"></i> Nuevo</button>
    <br><br>
   <table class="table table-responsive table-hover">
    <thead>
       <tr>
         <th>Nombre del Propietario</th>
         <th>Nombre del Documento</th>
         <th>Ver</th>
         <th style="text-align: center;"><i class="fa fa-cog"><i/></th>
       </tr>
    </thead>
     <tbody>
      <?php 
       $ruta_documento="https://firebasestorage.googleapis.com/v0/b/v3plus-279402.appspot.com/o/documentos%2F";
        foreach ($documentos as $documento){?>
       <tr>
         <td><?php echo $documento->propietario;?></td>
         <td><?php echo $documento->nombre;?></td>
        <?php
         $data_documento = json_decode(file_get_contents($ruta_documento.$documento->url), true );
          $token= $data_documento['downloadTokens'];
          $url_documento=$ruta_documento.$documento->url."?alt=media&token=".$token;
          ?>

         <td><a href="<?php echo $url_documento;?>"><?php echo $documento->url;?></a></td>
         <td style="text-align: center;"><a href="#"  onclick="eliminar_documento('<?php echo $documento->id;?>')"><i class="fa fa-trash"></i></a></td>
       </tr>
      <?php }?>
     </tbody>
   </table>
 </div>



<!-- Modal Subir Imagen Organigrama-->
<div id="subir_organigrama" class="modal fade" role="dialog">
  <div class="modal-dialog" style="width: 60%">
   <input type="hidden" name="base" id="base" value="<?php echo base_url()?>">
    <!-- Modal content-->
    <input type="hidden" name="id" id="id">
    <div class="modal-content">
      <div class="modal-header">
        <h4 class="modal-title"><i class="fa fa-upload"></i>&nbsp;Subir Imagen de Organigrama</h4>
      </div>
      <div class="modal-body">
          <table border="0" width="100%">
          <tr>
            <td><label><i class="fa fa-image fa-2x"></i>&nbsp; ORGANIGRAMA</label></td>
            <td> <input type="file" id="imagen"></td>
          </tr>
          <tr>
            <td colspan="2">
              <div id="mensajeImagen"></div>
              <div id="archivoImagen">
                Archivo subido: <a href="" id="enlaceImagen">Click para ver</a>
              </div>
            </td>
          </tr>
          </table>
      </div>
      <div class="modal-footer">
         <button type="button" class="btn btn-warning" data-dismiss="modal">Cerrar<i class="fa fa-times"></i></button>
      </div>
    </div>
  </div>
</div>




<!-- Modal Subir Documento -->
<div id="subir_documento" class="modal fade" role="dialog">
  <form name="frmGuardar" method="post" action="<?php echo base_url()?>capitalHumano/guardar_documento">
  <div class="modal-dialog" style="width: 60%">
   <!-- Modal content-->
    <div class="modal-content">
      <div class="modal-header">
        <h4 class="modal-title"><i class="fa fa-file-text"></i>&nbsp;Guardar Documento</h4>
      </div>
      <div class="modal-body">
          <table border="0" width="100%">
          <tr>
            <td>Nombre del propietario</td>
            <td><input type="text" name="propietario" value="<?php echo $this->tank_auth->get_usernamecomplete();?>" class="form-control"></td>
          </tr>
          <tr>
            <td><label>Nombre del Documento</label></td>
            <td><input type="text" name="nombre" class="form-control"></td>
          </tr>
          <tr>
            <td></td>
            <td> <input type="file" id="documento" name="url"></td>
          </tr>
          <tr>
            <td colspan="2">
              <div id="mensajeDocumento"></div>
              <div id="archivoDocumento">
                Archivo subido: <a href="" id="enlaceDocumento">Click para ver</a>
              </div>
            </td>
          </tr>
          </table>
      </div>
      <div class="modal-footer">
         <button type="submit" class="btn btn-primary">Guardar<i class="fa fa-check"></i></button>
         <button type="button" class="btn btn-warning" data-dismiss="modal">Cerrar<i class="fa fa-times"></i></button>
      </div>
    </div>
  </div>
</form>
</div>







<?php $this->load->view('adicional/espera'); ?>
<?php $this->load->view('footers/footer'); ?>


<script type="text/javascript">
	var nombreDivActivo="";var objetoFoco="";var vistaAnterior="";var bandBorrado=0;var rowIndex="";var cellIndex="";var objetoEliminar=null;var varCapturaProc=-1;

function cuadroDeDialogoOnCLick(objeto){
  objeto.parentNode.parentNode.classList.remove('ventanaFPStyle');
  objeto.parentNode.parentNode.classList.add('ocultarObjeto');
}
function enviarArchivoAJAX(formulario,funcion){
  
    var Data = new FormData(document.getElementById(formulario));
  
  /* Creamos el objeto que hara la petición AJAX al servidor, debemos de validar si existe el   objeto “ XMLHttpRequest” ya que en internet explorer viejito no esta, y si no esta usamos 
  “ActiveXObject” */
  
  if(window.XMLHttpRequest) { 
    var Req = new XMLHttpRequest();
  }else if(window.ActiveXObject) {
    var Req = new ActiveXObject("Microsoft.XMLHTTP");
  }
  
  //Pasándole la url a la que haremos la petición
  var direccion= <?php echo('"'.base_url().'capitalHumano/"');?>+funcion;
  Req.open("POST",direccion, true);
  
  /* Le damos un evento al request, esto quiere decir que cuando
  termine de hacer la petición, se ejecutara este fragmento de
  código */
  
  Req.onload = function(Event) {
    //Validamos que el status http sea  ok
    if (Req.status == 200) {
      /*Como la info de respuesta vendrá en JSON 
      la parseamos */
      var st = JSON.parse(Req.responseText);

        alert(st);

      if(st.success){
        /* Código si el return fue true */
            }else{
        /* Código si el return fue false */
      }
    } else {
          //console.log(Req.status); //Vemos que paso.
    }
  };    
  
  //Enviamos la petición
  Req.send(Data);
}


function crearObjetosParaForm(datos,clase,nombre){

	var input=document.createElement('input');
	input.setAttribute('type','hidden');
	input.setAttribute('value',datos);
	input.setAttribute('class',clase);
	input.setAttribute('name',nombre);

	document.body.appendChild(input);
}
function enviarFormGenerales(clase,controlador){
  var direccion=<?php echo('"'.base_url().'"'); ?>;
  direccion=direccion+controlador;
  var formulario=document.createElement('form'); formulario.setAttribute('method','post'); formulario.action=direccion;
  objetosForm=document.getElementsByClassName(clase);objetos="";cant=objetosForm.length;
  for(var i=0;i<cant;i++){
  var objeto=document.createElement('input'); 
      objeto.setAttribute('value',objetosForm[i].value);
      objeto.setAttribute('name',objetosForm[i].name);
      objeto.setAttribute('type','hidden');
      formulario.appendChild(objeto);    
  }
  document.body.appendChild(formulario);
  formulario.submit();
}
function selectCapturaMP(objeto){
	var tipoObjeto=typeof(objeto);var numero=1;
  if(Array.isArray(objeto)){
    var cant=objeto.length;var option="";
     document.getElementById("divContODPProc").innerHTML="";
  document.getElementById("divContAPProc").innerHTML="";
  document.getElementById("divContRAProc").innerHTML="";
  document.getElementById("divContDTAProc").innerHTML="";
  document.getElementById("divContPPProc").innerHTML="";
    tabla='<table border="1"><tr><td># Act.</td><td>Responsable</td><td>Actividad</td><td>Formato o Anexo</td></tr>';
    
    for(var i=0;i<cant;i++){
      var linkDoc="";
    	  	if(objeto[i].funcion==0){
            if(Array.isArray(objeto[i].documento)){           
              var cantDoc=objeto[i].documento.length;
              for(var j=0;j<cantDoc;j++){
                 linkDoc=linkDoc+'<a href="<?php echo(base_url()."ArchivosProcedimientos/");?>'+objeto[i].idFuncionFP+'/'+objeto[i].documento[j]+'">'+objeto[i].documento[j]+'</a><br>';
              }
            }
    	tabla=tabla+'<tr>';
    	tabla=tabla+'<td>'+numero+'</td>';
    	tabla=tabla+'<td>'+objeto[i].personaPuesto+'</td>';
    	tabla=tabla+'<td>'+objeto[i].descripcionFP+'</td>';
    	tabla=tabla+'<td>'+linkDoc+'</td>';
    	tabla=tabla+'</tr>';
          }
    	 //value="'+objeto[i].idFuncionProceso+'">'+objeto[i].descripcionFP+'</option>';
    	else{
    		if(document.getElementById(objeto[i].idFuncionFP)){
    		document.getElementById(objeto[i].idFuncionFP).innerHTML=objeto[i].descripcionFP;}
    	}
     numero++;
    }
   tabla=tabla+'</table>';
    
   document.getElementById("divContDPProc").innerHTML=tabla;
   // document.getElementById("selectCapturaProc").innerHTML=option;
  }
  else{direccionAJAX(16,objeto.value);}
}
function selectCapturaProc(objeto){
	var tipoObjeto=typeof(objeto);var numero=1;

  if(Array.isArray(objeto)){
  document.getElementById("divContODPProc").innerHTML="";
  document.getElementById("divContAPProc").innerHTML="";
  document.getElementById("divContRAProc").innerHTML="";
  document.getElementById("divContDTAProc").innerHTML="";
  document.getElementById("divContPPProc").innerHTML="";
    var cant=objeto.length;var option="";
    var responsable=document.getElementById("personaPuesto").value;
    var tabla='<table border="1"><tr><td># Act.</td><td>Responsable</td><td>Actividad</td><td>Formato o Anexo</td></tr>';
    var tr="<tr><td  colspan='4'>";
    var cad="";
    
    for(var i=0;i<(cant);i++){
    	if(objeto[i].funcion==0){/*SI ES PROCEDIMIENTOS*/
    	tabla=tabla+'<tr>';
    	tabla=tabla+'<td>'+numero+'</td>';
    	tabla=tabla+'<td>'+responsable+'</td>';
    	tabla=tabla+'<td>'+objeto[i].descripcionFP+'</td>';
    	tabla=tabla+'<td></td>';
    	tabla=tabla+'</tr>';
    	 //value="'+objeto[i].idFuncionProceso+'">'+objeto[i].descripcionFP+'</option>';
   
    	 }
    	else{ 
        if(objeto[i].funcion==1){ 
    		if(document.getElementById(objeto[i].idFuncionProceso)){/*SI SON DESCRIPCIONES DEL MANUAL*/
    		document.getElementById(objeto[i].idFuncionProceso).innerHTML=objeto[i].descripcionFP;}
        }
        else{

          /*SI SON ARCHIVOS DEL PROCEDIMIENTO*/
          if(objeto[i].funcion==2){ 
          var idFuncionProceso=objeto[i].idFuncionProceso;
          var f=objeto[i].archivos;
          var canArchivos=objeto[i].cantidad;
          for(var j=0;j<canArchivos;j++){
            if(objeto[i].archivos[j]!='Diagrama'){
            cad=cad+'<a href="<?php echo(base_url()."ArchivosProcedimientos/");?>'+idFuncionProceso+'/'+objeto[i].archivos[j]+'">'+objeto[i].archivos[j]+'</a><br>';}
            
          }
           
          //document.getElementById('archivosDelProcedimiento').innerHTML=cad;
         }else{
          /*SI ES DIAGRAMA*/
          document.getElementById('divContDiagrama').innerHTML='<img src="'+objeto[i].diagrama+'">';
         }
        }
    	}
     numero++;
    }

    tr=tr+cad+"</td></tr>";
    tabla=tabla+tr;
   tabla=tabla+'</table>';
   document.getElementById("divContDPProc").innerHTML=tabla;
  }
  else{direccionAJAX(15,objeto.value);}
}
function selectCapturaFuncion(objeto)
{
	var tipoObjeto=typeof(objeto);
  if(Array.isArray(objeto)){
    var cant=objeto.length;var option="";
    option='<option value="-1"></option>'
    for(var i=0;i<cant;i++){
    	option=option+'<option value="'+objeto[i].idFuncionProceso+'">'+objeto[i].descripcionFP+'</option>';
     
    }
    document.getElementById("selectCapturaProc").innerHTML=option;
    if(varCapturaProc>0){document.getElementById("selectCapturaProc").value=varCapturaProc;selectCapturaProc(document.getElementById("selectCapturaProc"));}
  }
  else{direccionAJAX(14,objeto.value);}
}
function selectOpcionProc(objeto){
	var cantidad=objeto.length;

document.getElementById("selectCapturaFuncion").value=-1;
document.getElementById("selectCapturaProc").innerHTML="";
  document.getElementById("divContODPProc").innerHTML="";
  document.getElementById("divContAPProc").innerHTML="";
  document.getElementById("divContRAProc").innerHTML="";
  document.getElementById("divContDTAProc").innerHTML="";
  document.getElementById("divContPPProc").innerHTML="";
	for(var i=1;i<cantidad;i++){
		document.getElementById(objeto[i].value).classList.add("ocultarObjeto");
		document.getElementById(objeto[i].value).classList.remove("verObjeto");
	}
	 if(objeto.value!='-1'){
	document.getElementById(objeto.value).classList.remove('ocultarObjeto');
	document.getElementById(objeto.value).classList.add('verObjeto');
   }
}
function eliminarFuncionMP(idProcesoFuncion,objeto){
 direccionAJAX(11,idProcesoFuncion);
 objeto.parentNode.parentNode.removeChild(objeto.parentNode);
}
function subirFuncionMP(idProcesoFuncion,objeto){direccionAJAX(12,idProcesoFuncion);}
function bajarFuncionMP(idProcesoFuncion,objeto){direccionAJAX(13,idProcesoFuncion);}
function onchangeSelectMP(objeto){
 if(objeto.value>-1){direccionAJAX(10,objeto.value);}
 else{document.getElementById("contFuncionAsignadasMP").innerHTML="";}
}
function asignarMP(idFuncionProceso){direccionAJAX(9,idFuncionProceso);}
function eliminarFP(objeto,e){
	e.stopPropagation();
	if(objetoEliminar==null){
	objetoEliminar=objeto.parentNode.parentNode;
	direccionAJAX(6,objeto.parentNode.parentNode.cells[0].innerHTML);
    }
    else{var tabla="";
      if(objetoEliminar.classList.contains('rowFuncion')){
        	document.getElementById("tablaProcedimientos").innerHTML="";
        	document.getElementById("tablaPasos").innerHTML="";
       }else{if(objetoEliminar.classList.contains('rowProcedimientos')){document.getElementById("tablaPasos").innerHTML="";}}   
    	objetoEliminar.parentNode.removeChild(objetoEliminar);
    	objetoEliminar=null;
    }
}

function enviarAJAX(controlador,parametros){
  var req = new XMLHttpRequest();
  var direccionAJAX="<?= base_url();?>";
  var url=direccionAJAX+controlador+parametros;
 req.open('POST', url, true);
  document.getElementById('imgEspera').classList.toggle('ocultarObjeto');
   document.getElementById('imgEspera').classList.toggle('verObjeto');
  req.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
   req.onreadystatechange = function (aEvt) 
  {
    if (req.readyState == 4) {if(req.status == 200)
    { 
         var respuesta=JSON.parse(this.responseText);
        //procesaRespuestaAJAX(respuesta,nombreTabla,opcionAjax,nombreClass);
                
        procesaRespuestaAJAX(respuesta.datos,respuesta.tabla,respuesta.opcionTabla,'classRATProcedimiento');
          document.getElementById('imgEspera').classList.toggle('ocultarObjeto');
   document.getElementById('imgEspera').classList.toggle('verObjeto');
                                                  
      }     
   }
  };
 req.send();
}
function ejemplo(){
  alert("");
}


function moverProcedimiento(tipoMovimiento,idProcesoFuncion){
  var datos='/?idProcesoFuncion='+idProcesoFuncion+"&tipoMovimiento="+tipoMovimiento;
  enviarAJAX('capitalHumano/moverProcedimiento',datos);
}
function guardarModificacionFP(objeto,e){
     e.stopPropagation();
        objetoEliminar=objeto.parentNode.parentNode;
        var datos=objeto.parentNode.parentNode.cells[0].innerHTML+"&descripcionFP="+objeto.parentNode.parentNode.cells[1].innerHTML;
        
       direccionAJAX(19,datos);
}

function verDocumentos(objeto,e){
  
  e.stopPropagation();
  guardaIdFuncion(3,objeto.parentNode.parentNode,"classRATProcedimiento")
 direccionAJAX(17,objeto.parentNode.parentNode.cells[0].innerHTML);
  
}
function mostrarEnlacesDoc(objeto){
       cant=objeto.length;
     var link="";
      if(objeto.bandera==0)
       {
         link=objeto.datos;
       }
     else{
       var cant=objeto.datos.length;
       for(var i=0;i<cant;i++){
       link=link+'<a target="_blank" href="<?php echo(base_url()."ArchivosProcedimientos/");?>'+objeto.idFuncionProceso+'/'+objeto.datos[i]+'">'+objeto.datos[i]+'</a><button class="btn" onclick=eliminarDocumento("'+objeto.idFuncionProceso+'","'+objeto.datos[i]+'")>Elimnar</button><br>';
       }
     }
  
    document.getElementById('cuadroDialogo').classList.remove('ocultarObjeto');
    document.getElementById('cuadroDialogo').classList.add('ventanaFPStyle');
    document.getElementById('cuadroDialogoContenido').innerHTML=link;

}
function eliminarDocumento(idFuncionProceso,nombreDocumento){
direccionAJAX(18,idFuncionProceso+";"+nombreDocumento);
}
function guardaIdFuncion(opcionAjax,objeto,classRow){	
	//document.getElementById('idFuncionProceso').value=objeto.cells[0].innerHTML;
	var rowActivo=document.getElementsByClassName(classRow);
	if(rowActivo.length>0){rowActivo[0].classList.remove(classRow);}
	objeto.classList.add(classRow);
	if(opcionAjax!=5){direccionAJAX(opcionAjax,objeto.cells[0].innerHTML);}
  if(objeto.classList.contains('rowProcedimientos')){document.getElementById('idArchivoProc').value=objeto.cells[0].innerHTML;document.getElementById('idArchivoProcDiagrama').value=objeto.cells[0].innerHTML;}
}
function direccionAJAX(opcion,id){
 var direccionAJAX="<?php echo(base_url().'capitalHumano/');?>";
 var datos="";
 var bandConectar=1;
 var nombreTabla=null;
 var nombreClass=null;

  switch(opcion){
     case 0:
        datos='idFuncionProceso='+document.getElementById('idFuncionProceso').value;
       datos=datos+"&descripcionFP="+document.getElementById('inputFunciones').value;
       datos=datos+"&clasificacionFP=0";
       datos=datos+"&tipoFP="+document.getElementById('tipoFuncion').value;
       datos=datos+"&idPuesto="+document.getElementById('idPuesto').value;
       direccionAJAX=direccionAJAX+'operacionFuncionProceso/'; 
       nombreTabla='Funciones';
       opcion=2;nombreClass="classRATFuncion";
     break;
     case 1:
        var row=document.getElementsByClassName('classRATFuncion');
        if(row.length>0){
        datos=datos+"padreFP="+row[0].cells[0].innerHTML;
        datos=datos+'&descripcionFP='+document.getElementById('inputProcedimientos').value;
        datos=datos+'&clasificacionFP=2';
        direccionAJAX=direccionAJAX+'agregarProcedimientos/'; 
         nombreTabla='Procedimientos';nombreClass="classRATProcedimiento";
         opcion=3;
      }
      else{
      	alert("Escoge una Funcion");
      	bandConectar=0;
      }
     break;
     case 2:
       datos=datos+"idFuncionProceso="+id;
       direccionAJAX=direccionAJAX+'devolverProcedimientosFuncion/';
       nombreTabla="Procedimientos" ;nombreClass="classRATProcedimiento";
       opcion=3;
     break;
  case 3:
             datos=datos+"idFuncionProceso="+id;
       direccionAJAX=direccionAJAX+'devolverProcedimientosFuncion/';
       nombreTabla="Pasos" ;nombreClass="classRATPasos";
       opcion=5;
     break;
     case 4:
       var row=document.getElementsByClassName('classRATProcedimiento');
        if(row.length>0){
        datos=datos+"padreFP="+row[0].cells[0].innerHTML;
        datos=datos+'&descripcionFP='+document.getElementById('inputPasos').value;
        datos=datos+'&clasificacionFP=3';
        direccionAJAX=direccionAJAX+'agregarProcedimientos/'; 
         nombreTabla='Pasos';nombreClass="classRATPasos";
         opcion=5;
         }
     break;
     case 5:

     break;
     case 6:
            datos=datos+"idFuncionProceso="+id;
            direccionAJAX=direccionAJAX+'EliminarPF/';
            nombreTabla=null;opcion="Eliminar";nombreClass=null;       
     break;
     case 7:datos=datos+"idFuncionProceso="+document.getElementById("SelectparaMP").value;
            direccionAJAX=direccionAJAX+'traePFParaMatriz/';
            nombreTabla=null;opcion="traeProc";nombreClass=null; 
            break;
     case 8:datos=datos+"descripcionFP="+document.getElementById("inputNuevoMP").value ;
                datos=datos+'&clasificacionFP=4&tipoFP=1';datos=datos+"&idPuesto="+document.getElementById('idPuesto').value;
              direccionAJAX=direccionAJAX+'nuevoMP/';
            nombreTabla=null;opcion="nuevoMP";nombreClass=null; 
     break;
     case 9: datos='idFuncionProceso='+id;datos=datos+'&idFuncionMP='+document.getElementById("selectMP").value;direccionAJAX=direccionAJAX+'asignarFPU/';
     
            nombreTabla=null;opcion="asignarFPU";nombreClass=null; break;
     case 10: datos='idFuncionMP='+id;direccionAJAX=direccionAJAX+'devolverFPU/';nombreTabla=null;opcion="asignarFPU";nombreClass=null; break;
      case 11: datos='idFuncionProceso='+id;datos=datos+'&idFuncionMP='+document.getElementById("selectMP").value;direccionAJAX=direccionAJAX+'eliminarProcMP/';
      nombreTabla=null;opcion="eliminarProcMP";nombreClass=null; break;
        case 12: datos='idFuncionProceso='+id;datos=datos+'&idFuncionMP='+document.getElementById("selectMP").value;datos=datos+'&direccion=0';direccionAJAX=direccionAJAX+'cambioPosicionFuncion/';
      nombreTabla=null;opcion="procArriba";nombreClass=null; break;
      case 13: datos='idFuncionProceso='+id;datos=datos+'&idFuncionMP='+document.getElementById("selectMP").value;datos=datos+'&direccion=1';direccionAJAX=direccionAJAX+'cambioPosicionFuncion/';
      nombreTabla=null;opcion="procAbajo";nombreClass=null; break;
      case 14:       datos=datos+"idFuncionProceso="+id;
       direccionAJAX=direccionAJAX+'devolverProcedimientosFuncion/';    nombreTabla=null;opcion="procCaptura";nombreClass=null; break;
      case 15:       datos=datos+"idFuncionProceso="+id;
       direccionAJAX=direccionAJAX+'devolverDescripPF/';
       nombreTabla=null;opcion="pasosCaptura";nombreClass=null;
     break;
     case 16:datos='idFuncionMP='+id;direccionAJAX=direccionAJAX+'devolverFPUDatos/';nombreTabla=null;opcion="procPasosMP";nombreClass=null; break;
     case 17:datos='idFuncionMP='+id;direccionAJAX=direccionAJAX+'verDocumentos/';nombreTabla=null;opcion="verDocumentos";nombreClass=null; break;
     case 18:datos='idFuncionMP='+id;direccionAJAX=direccionAJAX+'eliminarDocumento/';nombreTabla=null;opcion="verDocumentos";nombreClass=null; break;
     case 19:datos='idFuncionProceso='+id;direccionAJAX=direccionAJAX+'modificarFP/';nombreTabla=null;opcion="eliminarDocumentos";nombreClass=null; break;

  } 


  if(bandConectar){conectaAJAX(direccionAJAX,datos,nombreTabla,opcion,nombreClass);};
}
function traeProc(respuesta){document.getElementById("listaProc").innerHTML=respuesta;}
function nuevoMP(respuesta){
	var select=document.getElementById("selectMP");
	select.innerHTML=respuesta;
select.value=select.options[select.length-1].value;

}
function asignaFuncionesMP(respuesta){
	document.getElementById("contFuncionAsignadasMP").innerHTML=respuesta;
}
function conectaAJAX(url,parametros,nombreTabla,opcionAjax,nombreClass){
  var req = new XMLHttpRequest();
 req.open('POST', url, true);
  req.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
    document.getElementById('imgEspera').classList.toggle('ocultarObjeto');
   document.getElementById('imgEspera').classList.toggle('verObjeto');
   req.onreadystatechange = function (aEvt) 
  {
    if (req.readyState == 4) {if(req.status == 200)
    {   document.getElementById('imgEspera').classList.toggle('ocultarObjeto');
   document.getElementById('imgEspera').classList.toggle('verObjeto');
      if(nombreTabla!=null)
       {
         var respuesta=JSON.parse(this.responseText);
        procesaRespuestaAJAX(respuesta,nombreTabla,opcionAjax,nombreClass);
       } 
       else
       {
          
       	var respuesta=JSON.parse(this.responseText);
           
         switch(opcionAjax){
         	case 'Eliminar':eliminarFP(null,event);  break;
         	case 'traeProc':traeProc(respuesta);break;
         	case 'nuevoMP':nuevoMP(respuesta);break;
         	case 'asignarFPU': asignaFuncionesMP(respuesta);break;
         	case 'eliminarProcMP': break;
         	case 'procArriba':document.getElementById("contFuncionAsignadasMP").innerHTML=respuesta; break;
         	case 'procAbajo':document.getElementById("contFuncionAsignadasMP").innerHTML=respuesta; break;
         	case 'procCaptura':selectCapturaFuncion(respuesta); 
         	case 'pasosCaptura': selectCapturaProc(respuesta); break;
         	case 'procPasosMP':selectCapturaMP(respuesta) ;break;
          case 'verDocumentos':mostrarEnlacesDoc(respuesta); ;break;
          case 'eliminarDocumentos':alert(respuesta) ;break;
         }
       }                                              
      }     
   }
  };
 req.send(parametros);
}
function procesaRespuestaAJAX(respuesta,nombreTabla,opcionAjax,nombreClass){
 var cant=respuesta.length;
 var rows="";
 var claseRow="";
 if(nombreTabla=="Funcion"){claseRow="rowFuncion";}else{if(nombreTabla=="Procedimientos"){claseRow="rowProcedimientos"}else{claseRow="rowPasos"}}
 if(typeof(respuesta)=='number'){
 	rows=document.createElement('tr');
 	rows.setAttribute('onclick','guardaIdFuncion('+opcionAjax+',this,"'+nombreClass+'")');
 	cell1=document.createElement('td')
 	cell1.innerHTML=respuesta;
 	cell2=document.createElement('td');
 	cell2.innerHTML=document.getElementById("input"+nombreTabla).value;
  cell3=document.createElement('td');
  cell3.innerHTML='<button class="btn" onclick=\'eliminarFP(this,event)\'>Eliminar</button>';

 	rows.appendChild(cell1);
 	rows.appendChild(cell2);
  rows.appendChild(cell3);
  if(nombreTabla=="Procedimientos"){cell4=document.createElement('td');cell4.innerHTML='<button class="btn" onclick=\'verDocumentos(this,event)\'>Documentos</button>'; rows.appendChild(cell4); }
    cell4=document.createElement('td');
    cell4.innerHTML='<button class="btn" onclick=\'guardarModificacionFP(this,event)\'>Guardar</button>';
     rows.appendChild(cell4);

 	document.getElementById('tabla'+nombreTabla).appendChild(rows)

 }else{

 for(var i=0;i<cant;i++)
  { 
  	rows=rows+'<tr onclick=\'guardaIdFuncion('+opcionAjax+',this,\"'+nombreClass+'\")\' class=\"'+claseRow+'\">';
    rows=rows+'<td>'+respuesta[i].idFuncionProceso+'</td>';
    rows=rows+'<td contenteditable="true">'+respuesta[i].descripcionFP+'</td>';
    rows=rows+ '<td ><button class="btn" onclick=\'eliminarFP(this,event)\'>Eliminar</button></td>';
    if(nombreTabla=="Procedimientos" ){rows=rows+ '<td><button class="btn" onclick=\'verDocumentos(this,event)\'>Documentos</button></td>';}
     rows=rows+ '<td ><button class="btn" onclick=\'guardarModificacionFP(this,event)\'>Guardar</button></td>';
     if(nombreTabla=="Procedimientos" || nombreTabla=="Pasos"){rows=rows+ '<td><button class="btn" onclick=\'moverProcedimiento(1,'+respuesta[i].idFuncionProceso+')\'>▲</button></td>';rows=rows+ '<td><button class="btn" onclick=\'moverProcedimiento(0,'+respuesta[i].idFuncionProceso+')\'>▼</button></td>';}
    rows=rows+'<tr>';
  }
  document.getElementById("tabla"+nombreTabla).innerHTML=rows;
 }
  
}

function crerFuncionProceso(){
	document.getElementById("idFuncionProceso").value=0;
	document.getElementById("descripcionFP").value="";
	//document.getElementById("clasificacionFP").value=0;
}
function tamanioCeldas(){
	if(objetoFoco.nodeName.toUpperCase()=='TABLE')
    { 
    	objetoFoco.rows[0].cells[cellIndex].setAttribute('style','width:200px');

    }
}
function datosParaPlantilla(){
	document.getElementById('divContenidoPP').innerHTML='<ul contenteditable="true" class="estlGnralMU" onclick="objetoFocoEvent(this)" onkeyup="eliminarDirecto(this)"><li onkeyup="eliminarDirecto(this)"></li></ul>';
	document.getElementById('divContenidoMP').innerHTML='<p contenteditable="true" class="estlGnralMU" onclick="objetoFocoEvent(this,event)" onkeyup="eliminarDirecto(this)"></p>';
	document.getElementById('divContenidoFPR').innerHTML='<ul contenteditable="true" class="estlGnralMU" onclick="objetoFocoEvent(this)" onkeyup="eliminarDirecto(this)"><li onkeyup="eliminarDirecto(this)"></li></ul>';
	document.getElementById('divContenidoEC').innerHTML='<p contenteditable="true" class="estlGnralMU" onclick="objetoFocoEvent(this,event)" onkeyup="eliminarDirecto(this)"><u>Con Dirección Administrativa:</u></p><ul contenteditable="true" class="estlGnralMU" onclick="objetoFocoEvent(this)" onkeyup="eliminarDirecto(this)"><li onkeyup="eliminarDirecto(this)"></li></ul><p contenteditable="true" class="estlGnralMU" onclick="objetoFocoEvent(this,event)" onkeyup="eliminarDirecto(this)"><u>Con Dirección Operativa:</u></p><ul contenteditable="true" class="estlGnralMU" onclick="objetoFocoEvent(this)" onkeyup="eliminarDirecto(this)"><li onkeyup="eliminarDirecto(this)"></li></ul><p contenteditable="true" class="estlGnralMU" onclick="objetoFocoEvent(this,event)" onkeyup="eliminarDirecto(this)"><u>Con Dirección Comercial:</u></p><ul contenteditable="true" class="estlGnralMU" onclick="objetoFocoEvent(this)" onkeyup="eliminarDirecto(this)"><li onkeyup="eliminarDirecto(this)"></li></ul><p contenteditable="true" class="estlGnralMU" onclick="objetoFocoEvent(this,event)" onkeyup="eliminarDirecto(this)"><u>Con Clientes:</u></p><ul contenteditable="true" class="estlGnralMU" onclick="objetoFocoEvent(this)" onkeyup="eliminarDirecto(this)"><li onkeyup="eliminarDirecto(this)"></li></ul><p contenteditable="true" class="estlGnralMU" onclick="objetoFocoEvent(this,event)" onkeyup="eliminarDirecto(this)"><u>Con Proveedores:</u></p>';
	document.getElementById('divContenidoPRP').innerHTML='<p contenteditable="true" class="estlGnralMU" onclick="objetoFocoEvent(this,event)" onkeyup="eliminarDirecto(this)"><b>EXPERIENCIA:</b></p><p contenteditable="true" class="estlGnralMU" onclick="objetoFocoEvent(this,event)" onkeyup="eliminarDirecto(this)"><b>HABILIDADES:</b></p><ul contenteditable="true" class="estlGnralMU" onclick="objetoFocoEvent(this)" onkeyup="eliminarDirecto(this)"><li onkeyup="eliminarDirecto(this)"></li></ul><p contenteditable="true" class="estlGnralMU" onclick="objetoFocoEvent(this,event)" onkeyup="eliminarDirecto(this)"><b>COMPETENCIAS CLAVES DEL PUESTO:</b></p><ul contenteditable="true" class="estlGnralMU" onclick="objetoFocoEvent(this)" onkeyup="eliminarDirecto(this)"><li onkeyup="eliminarDirecto(this)"></li></ul>';
	document.getElementById('divContenidoCTD').innerHTML='<ul contenteditable="true" class="estlGnralMU" onclick="objetoFocoEvent(this)" onkeyup="eliminarDirecto(this)"><li onkeyup="eliminarDirecto(this)"></li></ul>';
	document.getElementById('divContenidoPER').innerHTML='<p contenteditable="true" class="estlGnralMU" onclick="objetoFocoEvent(this,event)" onkeyup="eliminarDirecto(this)">PUESTOS <u>AL QUE REPORTA:</u><div><u>FRECUENCIA DE REPORTE:</u></div><div><u>INFORMACION QUE REPORTA:</u></div></p><ul contenteditable="true" class="estlGnralMU" onclick="objetoFocoEvent(this)" onkeyup="eliminarDirecto(this)"><li onkeyup="eliminarDirecto(this)"></li></ul><p contenteditable="true" class="estlGnralMU" onclick="objetoFocoEvent(this,event)" onkeyup="eliminarDirecto(this)"><u>PUESTO QUE LE REPORTAN:</u><div><u>FRECUENCIA DE REPORTE:</u></div><div>I<u>NFORMACION QUE REPORTA:</u></div></p><ul contenteditable="true" class="estlGnralMU" onclick="objetoFocoEvent(this)" onkeyup="eliminarDirecto(this)"><li onkeyup="eliminarDirecto(this)"></li></ul>';
	document.getElementById('divContenidoNCBC').innerHTML='<p contenteditable="true" class="estlGnralMU" onclick="objetoFocoEvent(this,event)" onkeyup="eliminarDirecto(this)"><b>Tipo de Nómina: Semanal() Quincenal(x) Otro()</b><div><b>Sueldo: $</b></div><div><b>Comisiones:$</b></div><div><b>Bonos en especie:</b></div><div><b>Otro tipo de ingreso:</b></div></p>';
	document.getElementById('divContenidoPO').innerHTML='<ul contenteditable="true" class="estlGnralMU" onclick="objetoFocoEvent(this)" onkeyup="eliminarDirecto(this)"><li onkeyup="eliminarDirecto(this)"><b>UBICACIO DE TRABAJO:</b></li><li onkeyup="eliminarDirecto(this)"><b>DIRECCION DE ÁREA PERTENECIENTE:</b></li><li onkeyup="eliminarDirecto(this)"><b>POSICION EN ORGANIGRAMA:</b></li></ul>';
	document.getElementById('divContODPProc').innerHTML='<p contenteditable="true" class="estlGnralMU" onclick="objetoFocoEvent(this,event)" onkeyup="eliminarDirecto(this)"><div><br></div></p>';
	document.getElementById('divContAPProc').innerHTML='<p contenteditable="true" class="estlGnralMU" onclick="objetoFocoEvent(this,event)" onkeyup="eliminarDirecto(this)"></p>';
	document.getElementById('divContRAProc').innerHTML='<p contenteditable="true" class="estlGnralMU" onclick="objetoFocoEvent(this,event)" onkeyup="eliminarDirecto(this)"></p>';
	document.getElementById('divContDTAProc').innerHTML='<p contenteditable="true" class="estlGnralMU" onclick="objetoFocoEvent(this,event)" onkeyup="eliminarDirecto(this)">4.1 Acrónimos</p><table border="2" contenteditable="true" class="estlGnralMU" onclick="objetoFocoEvent(this)"><tr onclick="guardaIndexTabla(this)"><td class="celdaTabla" onclick="guardaIndexTabla(this)">Acrónimo</td><td class="celdaTabla" onclick="guardaIndexTabla(this)">Descripción</td></tr><tr onclick="guardaIndexTabla(this)"><td class="celdaTabla" onclick="guardaIndexTabla(this)"></td><td class="celdaTabla" onclick="guardaIndexTabla(this)"></td></tr><tr onclick="guardaIndexTabla(this)"><td class="celdaTabla" onclick="guardaIndexTabla(this)"></td><td class="celdaTabla" onclick="guardaIndexTabla(this)"></td></tr><tr onclick="guardaIndexTabla(this)"><td class="celdaTabla" onclick="guardaIndexTabla(this)"></td><td class="celdaTabla" onclick="guardaIndexTabla(this)"></td></tr></table><p contenteditable="true" class="estlGnralMU" onclick="objetoFocoEvent(this,event)" onkeyup="eliminarDirecto(this)">4.2 Definiciones y Términos</p><table border="2" contenteditable="true" class="estlGnralMU" onclick="objetoFocoEvent(this)"><tr onclick="guardaIndexTabla(this)"><td class="celdaTabla" onclick="guardaIndexTabla(this)">Término</td><td class="celdaTabla" onclick="guardaIndexTabla(this)">Descripción</td></tr><tr onclick="guardaIndexTabla(this)"><td class="celdaTabla" onclick="guardaIndexTabla(this)"></td><td class="celdaTabla" onclick="guardaIndexTabla(this)"></td></tr><tr onclick="guardaIndexTabla(this)"><td class="celdaTabla" onclick="guardaIndexTabla(this)"></td><td class="celdaTabla" onclick="guardaIndexTabla(this)"></td></tr></table>';
	document.getElementById('divContPPProc').innerHTML='<p contenteditable="true" class="estlGnralMU" onclick="objetoFocoEvent(this,event)" onkeyup="eliminarDirecto(this)">5.1 Políticas Generales y Específicas</p><table border="2" contenteditable="true" class="estlGnralMU" onclick="objetoFocoEvent(this)"><tr onclick="guardaIndexTabla(this)"><td class="celdaTabla" onclick="guardaIndexTabla(this)">Politica #</td><td class="celdaTabla" onclick="guardaIndexTabla(this)">Descripcion</td></tr><tr onclick="guardaIndexTabla(this)"><td class="celdaTabla" onclick="guardaIndexTabla(this)"></td><td class="celdaTabla" onclick="guardaIndexTabla(this)"></td></tr><tr onclick="guardaIndexTabla(this)"><td class="celdaTabla" onclick="guardaIndexTabla(this)"></td><td class="celdaTabla" onclick="guardaIndexTabla(this)"></td></tr><tr onclick="guardaIndexTabla(this)"><td class="celdaTabla" onclick="guardaIndexTabla(this)"></td><td class="celdaTabla" onclick="guardaIndexTabla(this)"></td></tr></table>';
}
function manejoPestanias(nombre){
	var pestania=document.getElementsByClassName("divPestania")
	var contPestania=pestania.length;
	for(var i=0;i<contPestania;i++){
		pestania[i].classList.add("ocultarObjeto");
		pestania[i].classList.add("pestaniaOff")
		pestania[i].classList.remove("verObjeto");
        pestania[i].classList.remove("pestaniaOn");
	}
	if(nombre=="divOrganigrama" || nombre=="divFunciones" || nombre=="divMatrizProc" || nombre=="divMatrizDoc"){document.getElementById('divBarTool').classList.remove('verObjeto');document.getElementById('divBarTool').classList.add('ocultarObjeto');}
	else{
		document.getElementById('divBarTool').classList.add('verObjeto');
		document.getElementById('divBarTool').classList.remove('ocultarObjeto');
	}
	document.getElementById(nombre).classList.remove("ocultarObjeto");
	document.getElementById(nombre).classList.add("verObjeto");
	   document.getElementById(nombre).classList.add("pestaniaOn");
	   document.getElementById(nombre).classList.remove("pestaniaOff")
}
function formatoTexto(accion){
	var valor=null;
 if(accion=='foreColor' || accion=='backColor'){valor=document.getElementById('colorTextMU').value;}
	
  //	document.execCommand("foreColor", false, 'Red');
	document.execCommand(accion,false,valor);
	//document.execCommand("foreColor",'black');
}
function objetoFocoEvent(objeto,e){
 
  objetoFoco=objeto;
 
  activaPestania(objetoFoco.parentNode,'h');
}
function guardaIndexTabla(objeto){
	if(objeto.nodeName.toUpperCase()=='TR'){
      {rowIndex=objeto.rowIndex;}
	}
    else{cellIndex=objeto.cellIndex;}
}
function eliminarFila(){
 if(objetoFoco.nodeName=='TABLE'){
 	objetoFoco.deleteRow(rowIndex);rowIndex=rowIndex-1;
 	if(objetoFoco.childNodes.length==0){eliminarObjeto();}
 }
}
function eliminarColumna(){
  if(objetoFoco.nodeName=='TABLE'){
     rows=objetoFoco.rows.length;
     for(var i=0;i<rows;i++){
     	objetoFoco.rows[i].deleteCell(cellIndex);
     }
     cellIndex=cellIndex-1;
     if(objetoFoco.rows[0].childNodes.length==0){eliminarObjeto();}
     //objetoFoco.rows[0].deleteCell(cellIndex);
 	//objetoFoco.deleteRow(rowIndex);rowIndex=rowIndex-1;
 	//if(objetoFoco.childNodes.length==0){eliminarObjeto();}
   }
}
function eliminarObjeto(){
  padre=objetoFoco.parentNode;
  padre.removeChild(objetoFoco);	
}

function manejoVistaContenido(nombreObjeto){
  var objeto=document.getElementById(nombreObjeto);
  var sw=document.getElementById('sw').value;
  if(sw==0){
    objeto.style.display="block";  
    document.getElementById('sw').value=1;
  }else{
    objeto.style.display="none";  
    document.getElementById('sw').value=0;
  }
  
  if(objeto.childNodes.length>0){ objetoFoco=objeto;}
  else{objetoFoco=null;}
 contieneElementoActivo=nombreObjeto;
    activaPestania(objeto,'p');
   vistaAnterior=objeto;
}

function activaPestania(objeto,llamado){
	
   if(vistaAnterior==""){objeto.parentNode.classList.remove('divPadreContMU');objeto.parentNode.classList.add('divPadreContMUActivo');}
   else{if(objeto.id==vistaAnterior.id){objeto.parentNode.classList.remove('divPadreContMU');objeto.parentNode.classList.add('divPadreContMUActivo');}
        else{objeto.parentNode.classList.remove('divPadreContMU');objeto.parentNode.classList.add('divPadreContMUActivo');vistaAnterior.parentNode.classList.add('divPadreContMU');vistaAnterior.parentNode.classList.remove('divPadreContMUActivo');if(objeto.childNodes.length>0){if(llamado=='p'){objeto.childNodes[0].focus();objetoFoco=objeto.childNodes[0];}}}}
        vistaAnterior=objeto;
       contieneElementoActivo=objeto.id;
 
}
function eliminarDirecto(tipoObjeto){
 tipoObjeto=tipoObjeto.nodeName;
 if(document.activeElement.innerHTML.length==0){bandBorrado=bandBorrado+1;}
 if(tipoObjeto=='UL' && document.activeElement.innerHTML.length==0){bandBorrado=2;}

 if(bandBorrado==2){
 	var padre=document.activeElement.parentNode;
 	switch(tipoObjeto){
 	case 'LABEL':padre.removeChild(document.activeElement.previousSibling);
 	padre.removeChild(document.activeElement);
 	if(padre.childNodes.length==0)
 	{objetoFoco=padre;eliminarObjeto();}break;
   case 'DIV':eliminarObjeto();break;
   case 'UL':if(objetoFoco.childNodes.length==0){eliminarObjeto();}break;
    }

    bandBorrado=0;
   }

}
function onclickCheck(objeto){
 if(objeto.checked){
  objeto.setAttribute('checked','');
 }
 else{ objeto.removeAttribute('checked');}
}
function insertaObjetos(tipoObjeto){
	var objetoEnCreacion;
	
  switch (tipoObjeto){
 	case 'p':objetoEnCreacion=document.createElement('div') ; 
 	         objetoEnCreacion.setAttribute('contentEditable','true'); 
 	         objetoEnCreacion.setAttribute('class','estlGnralMU');
            objetoEnCreacion.classList.add('estiloParrafo');
             objetoEnCreacion.setAttribute('onclick','objetoFocoEvent(this,event)');

             objetoEnCreacion.setAttribute('onkeyup','eliminarDirecto(this)');
    break;
 	case 'ul': objetoEnCreacion=document.createElement('ul'); 

 	           objetoEnCreacion.setAttribute('contentEditable','true'); 
 	           objetoEnCreacion.setAttribute('class','estlGnralMU');
             objetoEnCreacion.classList.add('estiloLista');
               objetoEnCreacion.setAttribute('onclick','objetoFocoEvent(this)');
               objetoEnCreacion.setAttribute('onkeyup','eliminarDirecto(this)');
               objetoLI=document.createElement('li');  
                objetoLI.setAttribute('onkeyup','eliminarDirecto(this)');
      objetoEnCreacion.appendChild(objetoLI);break;
     
 	case 'check':
 	  	objetoCheck=document.createElement('input'); 
 	    objetoCheck.setAttribute('type','checkbox');
     // objetoCheck.setAttribute('checked','false');
      objetoCheck.setAttribute('onclick','onclickCheck(this)');
 	    objetoCheck.setAttribute('class','estlGnralMU');
 	    objetoLabel=document.createElement('label');
 	    objetoLabel.setAttribute('contentEditable','true');
 	    objetoLabel.setAttribute('class','labelDeCheck');
 	    objetoLabel.setAttribute('onkeyup','eliminarDirecto(this)');
 	    objetoLabel.innerHTML="Click";
 
  if(objetoFoco){
 	  if(!objetoFoco.classList.contains('contCheck'))
 	  {
 	  	objetoEnCreacion=document.createElement('div');
 	    objetoEnCreacion.appendChild(objetoCheck);
 	    objetoEnCreacion.appendChild(objetoLabel);     
 	     objetoEnCreacion.setAttribute('class','estlGnralMU');
       objetoEnCreacion.setAttribute('onclick','objetoFocoEvent(this)');
       objetoEnCreacion.classList.add('contCheck')

 	  }
    else
 	  {
 	    objetoFoco.appendChild(objetoCheck);
 	    objetoFoco.appendChild(objetoLabel);   
 	    tipoObjeto='insertado';  
 	  }
    }else{
            objetoEnCreacion=document.createElement('div');
      objetoEnCreacion.appendChild(objetoCheck);
      objetoEnCreacion.appendChild(objetoLabel);     
       objetoEnCreacion.setAttribute('class','estlGnralMU');
       objetoEnCreacion.setAttribute('onclick','objetoFocoEvent(this)');
       objetoEnCreacion.classList.add('contCheck')
    }
 	break; 
 	case 'table':
 	            //objetoEnCreacion=document.createElement('div');
 	            objetoEnCreacion=document.createElement('table');
 	            objetoEnCreacion.setAttribute('class','celdaTabla');
 	            objetoTR=document.createElement('tr');
 	            objetoTR.setAttribute('onclick','guardaIndexTabla(this)');
 	            objetoTR.setAttribute('class','rowTabla');
 	            objetoTD=document.createElement('td');

 	            objetoTD.setAttribute('class','celdaTabla');
 	            objetoTD.setAttribute('onclick','guardaIndexTabla(this)');
                objetoTD.setAttribute('style','');

 	            objetoTR.appendChild(objetoTD);
 	            objetoEnCreacion.appendChild(objetoTR);
 	            objetoEnCreacion.setAttribute('border','2');
                objetoEnCreacion.setAttribute('contentEditable','true');
 	            objetoEnCreacion.setAttribute('class','estlGnralMU');
 	            objetoEnCreacion.classList.add('classTabla');
                objetoEnCreacion.setAttribute('onclick','objetoFocoEvent(this)');
               break;
    case 'tr':tipoObjeto='insertado';
              if(objetoFoco.nodeName.toUpperCase()=='TABLE')
              {
              	var columnas=objetoFoco.rows[0].cells.length;
              	objetoTR=document.createElement('tr');
              	 objetoTR.setAttribute('class','rowTabla');
              	objetoTR.setAttribute('onclick','guardaIndexTabla(this)');
              	for(var i=1;i<=columnas;i++){
              		objetoTD=null;
              		objetoTD=document.createElement('td');
              		objetoTD.setAttribute('class','celdaTabla');
              		objetoTD.setAttribute('onclick','guardaIndexTabla(this)');
              		objetoTD.setAttribute('style','');
              		objetoTR.appendChild(objetoTD);

              	}
              	objetoFoco.appendChild(objetoTR);
              }
              break;
     case 'td':
     tipoObjeto='insertado';
              if(objetoFoco.nodeName.toUpperCase()=='TABLE')
              {
              	var filas=objetoFoco.rows.length;
              	for(var i=0;i<filas;i++)
              	{
              		 objetoTD=document.createElement('td');
              	     objetoTD.setAttribute('class','celdaTabla')
              		objetoTD.setAttribute('onclick','guardaIndexTabla(this)');
              		objetoTD.setAttribute('style','');
              		objetoFoco.rows[i].appendChild(objetoTD);
              	}

              }
              break;
        case 'a':
             var link=prompt('link','direccion web');
             objetoA="";
            if (link != null && link != "") 
            {
              objetoEnCreacion=document.createElement('div') ; 
           objetoEnCreacion.setAttribute('class','estlGnralMU');
             objetoEnCreacion.setAttribute('onclick','objetoFocoEvent(this,event)');

             objetoEnCreacion.setAttribute('onkeyup','eliminarDirecto(this)');
              objetoA=document.createElement('a') ; 
              objetoA.setAttribute('class','estlGnralMU');
             objetoA.setAttribute('onclick','objetoFocoEvent(this,event)');
             objetoA.setAttribute('href',link);
             objetoA.setAttribute('target','_blank');
              objetoA.innerHTML=link;
              objetoA.setAttribute('oncontextmenu','eliminarTagA(this)')
              objetoEnCreacion.appendChild(objetoA);
            }            
         break;

 }
   if(tipoObjeto!='insertado'){
     if(objetoFoco==""){document.getElementById(contieneElementoActivo).appendChild(objetoEnCreacion);}
     else
     {
    	
    	  if(document.getElementById(contieneElementoActivo).childNodes.length>0)
    	  {document.getElementById(contieneElementoActivo).insertBefore(objetoEnCreacion,objetoFoco.nextSibling);}
    	  else{document.getElementById(contieneElementoActivo).appendChild(objetoEnCreacion);}
     }
  objetoFoco=objetoEnCreacion;
  objetoEnCreacion.focus();}
}
	  <?php

   $opciones="";
   foreach ($puestos as $key => $value) {$opciones=$opciones.'<option value="'.$value->idPuesto.'">'.$value->personaPuesto.'</option>';}
  
   echo('document.getElementById("buscarIdPuesto").innerHTML=\''.$opciones.'\';');
   echo('document.getElementById("padrePuesto").innerHTML=\''.$opciones.'\';');
   echo('document.getElementById("SelectparaMP").innerHTML=\''.$opciones.'\';');
 ?>
function eliminarTagA(objeto){
  var padre=objeto.parentNode;
  var padrePadre=padre.parentNode;
   padre.removeChild(objeto);
   padrePadre.removeChild(padre); 
}
 function funcionesPuesto(objeto){
 	if(objeto.checked){objeto.classList.add("asignaFPEstilo");}
 	else{objeto.classList.remove("asignaFPEstilo");}
 }
function imprimirManualUsuario(){
  if(document.getElementsByClassName("pestaniaOn")[0].id=="divManual"){
  crearObjetosParaForm(document.getElementById("idPuesto").value,'classImprimir','idPuesto');
   enviarFormGenerales('classImprimir','capitalHumano/generaPDF');
 }else{
  if(document.getElementById("selectOpcionProc").value!=-1 && document.getElementById("selectCapturaFuncion").value!=-1 && document.getElementById("selectCapturaProc").value!=-1  ){
    crearObjetosParaForm(document.getElementById("selectOpcionProc").value,'classImprimir','selectOpcionProc');
    crearObjetosParaForm(document.getElementById("selectCapturaFuncion").value,'classImprimir','selectCapturaFuncion');
    crearObjetosParaForm(document.getElementById("selectCapturaProc").value,'classImprimir','selectCapturaProc');
     crearObjetosParaForm(document.getElementById("idPuesto").value,'classImprimir','idPuesto');
   enviarFormGenerales('classImprimir','capitalHumano/generaPDF');

  }else{alert("Seleccion los datos completos");}
 }
}
function imprimirTodoElManual(){

  if(document.getElementById("selectOpcionProc").value!=-1  ){
    crearObjetosParaForm(document.getElementById("selectOpcionProc").value,'classImprimir','selectOpcionProc');
     crearObjetosParaForm(document.getElementById("idPuesto").value,'classImprimir','idPuesto');
   enviarFormGenerales('classImprimir','capitalHumano/imprimirTodoElManual');

  }else{alert("Escoger Funcion o Matriz de Procesos");}
 
}





 function guardarManualUsuario(){
 if(document.getElementsByClassName("pestaniaOn")[0].id=="divManual"){
	/*var contenido=objetoFoco.parentNode.innerHTML;
	var idDiv=objetoFoco.parentNode.id;
	var idPuesto=document.getElementById("idPuesto").value;
	var url=capitalHumano/guardarManualUsuario/';
	var params='contenido='+contenido;
	var params=params+'&divContenido='+idDiv+'&idPuesto='+idPuesto
	grabarMUAJAX(url,params)*/
		crearObjetosParaForm(document.getElementById("divContenidoPRP").innerHTML,'classProcManus','divContenidoPRP');
		crearObjetosParaForm(document.getElementById("divContenidoPP").innerHTML,'classProcManus','divContenidoPP');
		crearObjetosParaForm(document.getElementById("divContenidoMP").innerHTML,'classProcManus','divContenidoMP');
		crearObjetosParaForm(document.getElementById("divContenidoFPR").innerHTML,'classProcManus','divContenidoFPR');
		crearObjetosParaForm(document.getElementById("divContenidoEC").innerHTML,'classProcManus','divContenidoEC');
		crearObjetosParaForm(document.getElementById("divContenidoAGT").innerHTML,'classProcManus','divContenidoAGT');		
		crearObjetosParaForm(document.getElementById("divContenidoCTD").innerHTML,'classProcManus','divContenidoCTD');
		crearObjetosParaForm(document.getElementById("divContenidoPER").innerHTML,'classProcManus','divContenidoPER');
		crearObjetosParaForm(document.getElementById("divContenidoNCBC").innerHTML,'classProcManus','divContenidoNCBC');
		crearObjetosParaForm(document.getElementById("divContenidoPO").innerHTML,'classProcManus','divContenidoPO');
		crearObjetosParaForm(document.getElementById("divContenidoDIO").innerHTML,'classProcManus','divContenidoDIO');
		crearObjetosParaForm(document.getElementById("buscarIdPuesto").value,'classProcManus','idPuesto');

	   enviarFormGenerales('classProcManus','capitalHumano/guardarManualUsuario');
	
	}
	else{
		if(document.getElementById("selectOpcionProc").value!="-1"){
		if(document.getElementById("selectOpcionProc").value=="divCapturaFuncion"){
		crearObjetosParaForm(document.getElementById("divContODPProc").innerHTML,'classProcManus','divContODPProc');
		crearObjetosParaForm(document.getElementById("divContAPProc").innerHTML,'classProcManus','divContAPProc');
		crearObjetosParaForm(document.getElementById("divContRAProc").innerHTML,'classProcManus','divContRAProc');
		crearObjetosParaForm(document.getElementById("divContDTAProc").innerHTML,'classProcManus','divContDTAProc');
		crearObjetosParaForm(document.getElementById("divContPPProc").innerHTML,'classProcManus','divContPPProc');
		crearObjetosParaForm(document.getElementById("selectCapturaProc").value,'classProcManus','idFuncionProceso');
		crearObjetosParaForm(document.getElementById("buscarIdPuesto").value,'classProcManus','buscarIdPuesto');
		crearObjetosParaForm(document.getElementById("selectOpcionProc").value,'classProcManus','selectOpcionProc');
		crearObjetosParaForm(document.getElementById("selectOpcionProc").value,'classProcManus','selectOpcionProc');
		crearObjetosParaForm(document.getElementById("selectCapturaFuncion").value,'classProcManus','selectCapturaFuncion');
	    enviarFormGenerales('classProcManus','capitalHumano/grabarManualProcedimiento');
	   }else{
		crearObjetosParaForm(document.getElementById("divContODPProc").innerHTML,'classProcManus','divContODPProc');
		crearObjetosParaForm(document.getElementById("divContAPProc").innerHTML,'classProcManus','divContAPProc');
		crearObjetosParaForm(document.getElementById("divContRAProc").innerHTML,'classProcManus','divContRAProc');
		crearObjetosParaForm(document.getElementById("divContDTAProc").innerHTML,'classProcManus','divContDTAProc');
		crearObjetosParaForm(document.getElementById("divContPPProc").innerHTML,'classProcManus','divContPPProc');
		crearObjetosParaForm(document.getElementById("selectOpcionProc").value,'classProcManus','selectOpcionProc');
		crearObjetosParaForm(document.getElementById("selectCapturaMP").value,'classProcManus','idFuncionProceso');
		crearObjetosParaForm(document.getElementById("buscarIdPuesto").value,'classProcManus','buscarIdPuesto');
		enviarFormGenerales('classProcManus','capitalHumano/grabarManualProcedimientoMP');

	   }

	   }
	
	}
}
 function grabarMUAJAX(url,parametros){
 	  var req = new XMLHttpRequest();
  req.open('POST', url, true);
  req.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
  req.onreadystatechange = function (aEvt) 
  {     
     if (req.readyState == 4) {if(req.status == 200)
       {                                               
      }     
   }
 };
 req.send(parametros);
 }
function devuelveFuncionesAJAX(opcion,id,objeto){
  
  objetoClick=objeto.parentNode;
  
  var cantidadHijosClick=objetoClick.childNodes.length;
for(var i=0;i<cantidadHijosClick;i++){
  if(objetoClick.childNodes[i].classList.contains('verObjeto') && !objetoClick.classList.contains('inicialClass') && objetoClick.childNodes[i].nodeName!="LABEL" )
  {objetoClick.childNodes[i].classList.add('ocultarObjeto');objetoClick.childNodes[i].classList.remove('verObjeto');}
  else{
    objetoClick.childNodes[i].classList.remove('ocultarObjeto');objetoClick.childNodes[i].classList.add('verObjeto');
  }

    if(objetoClick.childNodes[i].nodeName=='DIV'){
      for(var j=0;j<objetoClick.childNodes[i].childNodes.length;j++){
         
           if(objetoClick.childNodes[i].childNodes[j].classList.contains('verObjeto') ){
objetoClick.childNodes[i].childNodes[j].classList.remove('verObjeto');
objetoClick.childNodes[i].childNodes[j].classList.add('ocultarObjeto');
           }else{
objetoClick.childNodes[i].childNodes[j].classList.add('verObjeto');objetoClick.childNodes[i].childNodes[j].classList.remove('ocultarObjeto');
           }
      }
    }
  }

  



  //objeto.parentNode.childNodes[1].classList.add('verObjeto');
  //for(var i=0;i<cantidadHijos;i++){
    //objeto.parentNode.childNodes[i].classList.add('verObjeto');
  //}
	/*var url="";
	switch(opcion){
		case 0: var idPuesto=document.getElementById('idPuesto').value ;url='<?=base_url()?>capitalHumano/devuelveFunciones/?idPuesto='+idPuesto;  break;
		case 1: ;url='<?=base_url()?>capitalHumano/devolverFuncionesAsignadas/?idPuesto='+id;break;
	}
  var req = new XMLHttpRequest();
  req.open('GET', url, true);
  req.onreadystatechange = function (aEvt) 
  {     
     if (req.readyState == 4) {if(req.status == 200)
       {var datos=JSON.parse(this.responseText);   
         document.getElementById("divFuncionesAsignar").classList.add('ventanaFPStyle');
         document.getElementById("divFuncionesAsignar").innerHTML=datos;                                                
      }     
   }
 };
 req.send();*/

}
 function enviaForm(accion){
 	  var direccion="";var clase="";var id="";
    switch(accion){
  case 1:direccion=<?php echo('"'.base_url().'capitalHumano/puesto"'); ?>;clase="puesto";break;
  case 2:direccion=<?php echo('"'.base_url().'capitalHumano/buscarPuesto"'); ?>;clase="buscarPuesto";break;
  case 3:direccion=<?php echo('"'.base_url().'capitalHumano/asignarFuncionesPuesto"'); ?>;clase="asignaFPEstilo";break;
  case 4:direccion=<?php echo('"'.base_url().'capitalHumano/guardarManualUsuario"'); ?>;
    }
  var formulario=document.createElement('form'); formulario.setAttribute('method','post'); formulario.action=direccion;formulario.id="miFormulario";
  objetosForm=document.getElementsByClassName(clase);objetos="";cant=objetosForm.length;
  for(var i=0;i<cant;i++){
  tipo=objetosForm[i].nodeName;
  var objeto=document.createElement('input'); 
      objeto.name=objetosForm[i].id;objeto.value=objetosForm[i].value;formulario.appendChild(objeto);
  }

  document.body.appendChild(formulario);
  formulario.submit();
 }
 function habilitarCaptura(){
 objetosForm=document.getElementsByClassName(clase);objetos="";cant=objetosForm.length;
  for(var i=0;i<cant;i++){
  	//objetosForm[i].
  }
 }
 function deshabilitarCaptura(){
 objetosForm=document.getElementsByClassName(clase);objetos="";cant=objetosForm.length;
  for(var i=0;i<cant;i++){
  	//objetosForm[i].
  }
 }
  function listaMatrizProc(objeto){
	 if(objeto.parentNode.classList.contains('mpOcultar')){objeto.parentNode.classList.add('verHijos');objeto.parentNode.classList.remove('mpOcultar');objeto.innerHTML="-";}
	 else{
		 objeto.parentNode.classList.remove('verHijos');objeto.parentNode.classList.add('mpOcultar');objeto.innerHTML="+";
		 }
 
 }
 function nuevoPuesto(){document.getElementById("idPuesto").value=0;document.getElementById("padrePuesto").value=1;}


<?php  if(isset($personaPuesto)){
	  //$fp = fopen('resultadoJason.txt', 'a');fwrite($fp, print_r($contenidoMU, TRUE));fclose($fp); 
	foreach ($contenidoMU as  $value) {
?>
     document.getElementById('<?php echo($value->idDivContenedor);?>').innerHTML=<?php echo("'".$value->contenido."'"); ?>;
  	<?php
  }
  ?>
    document.getElementById("buscarIdPuesto").value=<?php echo('"'.$personaPuesto->idPuesto.'";') ;?>;
	document.getElementById("personaPuesto").value=<?php echo('"'.$personaPuesto->personaPuesto.'";') ;?>
	document.getElementById("idPuesto").value=<?php echo('"'.$personaPuesto->idPuesto.'";') ;?>;
 	document.getElementById("padrePuesto").value=<?php echo('"'.$personaPuesto->padrePuesto.'";') ;?>;

<?php
}
if(isset($matrizProcesos)){
?>
document.getElementById("selectMP").innerHTML=<?php echo("'".$matrizProcesos."'"); ?>;
document.getElementById("selectCapturaMP").innerHTML=<?php echo("'".$matrizProcesos."'"); ?>;

<?php
}


 if(isset($mensaje)){ echo($mensaje);}	
?>
 document.getElementById("divOrganigramaContenedor").innerHTML=<?php echo('"'.$organigrama.';"'); ?>
 <?php   if(!isset($personaPuesto->idPuesto)){ ?> 
 	document.getElementById("divBarTool").innerHTML=""; 
 <?php ;} ?>




<?php
$datos='';
$datosSelect=''; 
  if(isset($funcionesPuesto)){
  	$datosSelect="<option value='-1'></option>";
  	foreach ($funcionesPuesto as  $value) {
  	$datos=$datos.'<tr onclick=\'guardaIdFuncion(2,this,\"classRATFuncion\")\' class=\"rowFuncion\">';
    $datos=$datos.'<td>'.$value->idFuncionProcesoFP.'</td>';
    $datos=$datos.'<td contentEditable=\"true\">'.$value->descripcionFP.'</td>';
   $datos=$datos.'<td >  <button class=\'btn\' onclick=\'eliminarFP(this,event)\'>Eliminar</button></td>';
   $datos=$datos.'<td >  <button class=\'btn\' onclick=\'guardarModificacionFP(this,event)\'>Guardar</button></td>';

  	$datos=$datos.'</tr>';
  	$datosSelect=$datosSelect.'<option value=\''.$value->idFuncionProcesoFP.'\'>'.$value->descripcionFP.'</option>';
  	}
  }
?>
document.getElementById('tablaFunciones').innerHTML=" <?php echo($datos); ?>";
document.getElementById("selectCapturaFuncion").innerHTML=" <?php echo($datosSelect); ?>";
<?php if(isset($pestania)){ ?>
manejoPestanias(<?php echo('"'.$pestania.'"'); ?>)
<?php } ?>
<?php if(isset($selectOpcionProc)){  if($selectOpcionProc=="divCapturaFuncion"){ ?>
document.getElementById("selectOpcionProc").value=<?php echo('"'.$selectOpcionProc.'"'); ?>;
var objeto=document.getElementById("selectOpcionProc");
selectOpcionProc(objeto);
document.getElementById("selectCapturaFuncion").value=<?php echo('"'.$selectCapturaFuncion.'"') ;?>;
selectCapturaFuncion(document.getElementById("selectCapturaFuncion"));
document.getElementById("selectCapturaProc").value=<?php echo('"'.$selectCapturaProc.'"') ;?>;
varCapturaProc=<?php echo('"'.$selectCapturaProc.'"') ; }else {?>;
document.getElementById("selectOpcionProc").value=<?php echo('"'.$selectOpcionProc.'"'); ?>;
selectOpcionProc(document.getElementById("selectOpcionProc"));
 document.getElementById('selectCapturaMP').value=<?php echo($selectCapturaMP); ?>;
 selectCapturaMP(document.getElementById('selectCapturaMP'));
<?php }} ?>

</script>


  <script src="https://www.gstatic.com/firebasejs/3.6.7/firebase.js"></script>
  <script>
    // Initialize Firebase
    var config = {
        apiKey: "AIzaSyBa6S-7_FtZE_cMxNz33e1Tvil3PGnON_4",
        authDomain: "v3plus-279402.firebaseapp.com",
        databaseURL: "https://v3plus-279402.firebaseio.com",
        projectId: "v3plus-279402",
        storageBucket: "v3plus-279402.appspot.com",
        messagingSenderId: "4568272251",
        appId: "1:4568272251:web:483a7b036920897138c1de",
        measurementId: "G-8EJP31SQZ7"
    };
    firebase.initializeApp(config);
  </script>
<script type="text/javascript">

 // Servicios de APIs Firebase
    var authService = firebase.auth();
    var storageService = firebase.storage();

    window.onload = function() {
      authService.signInAnonymously()
        .catch(function(error) {
          console.error('Detectado error de autenticación', error);
        });

      //manejador de evento para el input file
      document.getElementById('imagen').addEventListener('change', function(evento){
        evento.preventDefault();
        var archivo  = evento.target.files[0];
        subirImagen(archivo);
      });

       document.getElementById('documento').addEventListener('change', function(evento){
        evento.preventDefault();
        var archivo  = evento.target.files[0];
        subirDocumento(archivo);
      });
     
    
    };

    // defino el uploadTask como variable global, porque lo voy a necesitar
    var uploadTaskImagen;
    function subirImagen(archivo) {
      var refStorage = storageService.ref('organigrama').child(archivo.name);
      uploadTaskImagen = refStorage.put(archivo);

      // El evento donde comienza el control del estado de la subida
      uploadTaskImagen.on('state_changed', registrandoEstadoSubidaImagen, errorSubidaImagen, finSubidaImagen);

      //Callbacks para controlar los distintos instantes de la subida
      function registrandoEstadoSubidaImagen(uploadSnapshot) {
        var calculoPorcentaje = (uploadSnapshot.bytesTransferred / uploadSnapshot.totalBytes) * 100;
        calculoPorcentaje = Math.round(calculoPorcentaje);
        registrarPorcentajeImagen (calculoPorcentaje);
      }
      function errorSubidaImagen(err) {
        console.log('Error al subir el archivo', err);
      }
      function finSubidaImagen(){
        console.log('Subida completada');
        console.log('el archivo está subido. Su ruta: ', uploadTaskImagen.snapshot.downloadURL);
        enlaceSubidoImagen(uploadTaskImagen.snapshot.downloadURL);
      }

    }

     // mostramos el porcentaje en cada instante de la subida de imagen
    function registrarPorcentajeImagen(porcentaje) {
      var elMensaje = document.getElementById('mensajeImagen');
      var textoMensaje = '<p style="font-size:16px;font-weight:bold;">Porcentaje de subida: ' + porcentaje + '%</p>';
      elMensaje.innerHTML = textoMensaje;
    }
     //mostramos el link para acceso al archivo al final de la subida
    function enlaceSubidoImagen(enlace) {
      document.getElementById('enlaceImagen').href = enlace;
      document.getElementById('archivoImagen').style.display = 'block';
      var imagen=($('#imagen'))[0].files[0];
      guardar_organigrama(imagen);
      
    }  

    function guardar_organigrama(imagen){
       var url=$('#base').val()+"capitalHumano/guardar_organigrama";
      $.ajax({
          type: "POST",
          dataType: 'html',
          url: url,
          data: "imagen="+imagen.name,
          success: function(resp){
          }
      });
    }   

//Guardar Documento
     var uploadTaskDocumento;
     function subirDocumento(archivo) {
      var refStorage = storageService.ref('documentos').child(archivo.name);
      uploadTaskDocumento = refStorage.put(archivo);

      // El evento donde comienza el control del estado de la subida
      uploadTaskDocumento.on('state_changed', registrandoEstadoSubidaDocumento, errorSubidaDocumento, finSubidaDocumento);

      //Callbacks para controlar los distintos instantes de la subida
      function registrandoEstadoSubidaDocumento(uploadSnapshot) {
        var calculoPorcentaje = (uploadSnapshot.bytesTransferred / uploadSnapshot.totalBytes) * 100;
        calculoPorcentaje = Math.round(calculoPorcentaje);
        registrarPorcentajeDocumento (calculoPorcentaje);
      }
      function errorSubidaDocumento(err) {
        console.log('Error al subir el archivo', err);
      }
      function finSubidaDocumento(){
        console.log('Subida completada');
        console.log('el archivo está subido. Su ruta: ', uploadTaskDocumento.snapshot.downloadURL);
        enlaceSubidoImagen(uploadTaskDocumento.snapshot.downloadURL);
      }

    }



     // mostramos el porcentaje en cada instante de la subida de imagen
    function registrarPorcentajeDocumento(porcentaje) {
      var elMensaje = document.getElementById('mensajeDocumento');
      var textoMensaje = '<p style="font-size:16px;font-weight:bold;">Porcentaje de subida: ' + porcentaje + '%</p>';
      elMensaje.innerHTML = textoMensaje;
    }
     //mostramos el link para acceso al archivo al final de la subida
    function enlaceSubidoDocumento(enlace) {
      document.getElementById('enlaceDocumento').href = enlace;
      document.getElementById('archivoDocumento').style.display = 'block';
      var documento=($('#documento'))[0].files[0];
      guardar_documento(documento);
    }
      
    
   

     function guardar_documento(imagen){
       var url=$('#base').val()+"capitalHumano/guardar_documento";
      $.ajax({
          type: "POST",
          dataType: 'html',
          url: url,
          data: "imagen="+imagen.name,
          success: function(resp){
          }
      });
    }   


</script>
<style type="text/css">
/*.tree{overflow: scroll;width: 800px; height: 300px; overflow-x: 1000px; border: solid; }*/
 /*Now the CSS*/
  * {margin: 0; padding: 0;}
 .tree ul {padding-top: 20px; position: relative;transition: all 0.5s;-webkit-transition: all 0.5s;-moz-transition: all 0.5s;}
 .tree li {float: left; text-align: center;list-style-type: none;position: relative;padding: 20px 5px 0 5px;transition: all 0.5s;-webkit-transition: all 0.5s;-moz-transition: all 0.5s;	}
 /*Usaremos :: before y :: after para dibujar los conectores*/
 .tree li::before, .tree li::after{content: '';position: absolute; top: 0; right: 0%;border-top: 1px solid #ccc;width: 100%; height: 20px;}
 .tree li::after{right: auto; left: 50%;border-left: 1px solid #ccc;}
 /*Necesitamos eliminar los conectores izquierdo-derecho de los elementos sin hermanos*/
 .tree li:only-child::after, .tree li:only-child::before {display: none;}
 /*Eliminar el espacio de la parte superior de los nodos solos*/
 .tree li:only-child{ padding-top: 0;}
 /*Retira el conector izquierdo del primer hijo y el conector derecho del último hijo*/
 .tree li:first-child::before, .tree li:last-child::after{
	border: 0 none;
 }
 /*Agregar de nuevo el conector vertical a los últimos nodos*/
 .tree li:last-child::before{border-right: 1px solid #ccc;border-radius: 0 5px 0 0;-webkit-border-radius: 0 5px 0 0;-moz-border-radius: 0 5px 0 0;}
 .tree li:first-child::after{border-radius: 5px 0 0 0;-webkit-border-radius: 5px 0 0 0;-moz-border-radius: 5px 0 0 0;
 }
 /*Time to add downward connectors from parents*/
 .tree ul ul::before{content: '';position: absolute; top: 0; left: 50%;border-left: 1px solid #ccc;width: 1500; height: 20px;
 }
 .tree li label{border: 1px solid #ccc;padding: 2px 5px;text-decoration: none;color: #666;font-family: arial, verdana, tahoma;font-size: 8px;display: inline-block;border-radius: 1px;-webkit-border-radius: 5px;-moz-border-radius: 5px;transition: all 0.5s;-webkit-transition: all 0.5s;-moz-transition: all 0.5s; background-color: #68d668; color: black;width: 100px}
 .tree li a{
	border: 1px solid #ccc;padding: 5px 10px;text-decoration: none;color: #666;font-family: arial, verdana, tahoma;font-size: 11px;display: inline-block;border-radius: 5px;-webkit-border-radius: 5px;-moz-border-radius: 5px;transition: all 0.5s;-webkit-transition: all 0.5s;-moz-transition: all 0.5s;
 }
 /*Time for some hover effects*/
 /*We will apply the hover effect the the lineage of the element also*/
 .tree li a:hover, .tree li a:hover+ul li a {background: #c8e4f8; color: #000; border: 1px solid #94a0b4;}
 /*Connector styles on hover*/
 .tree li a:hover+ul li::after, 
 .tree li a:hover+ul li::before, 
 .tree li a:hover+ul::before, 
 .tree li a:hover+ul ul::before{border-color:  #94a0b4;}
 /*Thats all. I hope you enjoyed it.Thanks :)*/
  .ventanaFPStyle {border: 4px solid #472380; background-color: white;color:black;position:fixed;top:50%;left:40%;font-size:20px;z-index:100}
  .labelFAP{font-size: large;color: black; background-color: white; }
  .verObjeto{display: block;}
  .ocultarObjeto{display: none;}
  .estlGnralMU{color: black;border:none;border:double; margin:0;}
  p[class="estlGnralMU"]{color:black;}
  ul[class="estlGnralMU"]{color:black;}
  .centrarContenido{margin-left: 25%;margin-right: 25%;border: solid}
.divContMU{border:solid; border-color: #6197cd;background-color: white}
 .divPadreContMU{background-color: #6b6b6b;margin-top: 0%;clear: both}
 .divPadreContMUActivo{background-color: #55b171;margin-top: 0%;  }
  .labelTitContMU{color: white; width: 100%;margin-top: 1%; border: solid; border-color:black; position: relative; top: -10px; height: auto; }
  .labelDeCheck{width: 100px;height: 20px;border: thin;color: black}
  .celdaTabla{height: 12px;border: solid; width: 100px}
  .divBarTool{float: left;border-right: solid;margin-right: 20px}
  .classTabla{width: 100%}
  .classTabla td{width: auto;}
  .classDiv{resize:right;border:solid; }
  .tablaFunciones tr:hover {color: orange}
  .classRATFuncion {background-color: green}
  .classRATProcedimiento {background-color: green}
  .classRATPasos {background-color: green}
  .mpOcultar li {display:none}
.verHijos  li{display:block}
.labelLlave{border:solid 1px blue}
.labelLlaveMP:hover {background-color:#7171cc}
.labelMP{margin-left:5px}
.ulMP{margin-left: 25px}
.divAparienciaManuales{height: 400px; overflow: scroll;"}
.buttonMP{position: relative;top:-10px}
.labelParaMP{width:300px;overflow:scroll;height:60px}
</style>
<script type="text/javascript" charset="utf8" src="https://cdn.datatables.net/1.10.21/js/jquery.dataTables.js"></script>
<script type="text/javascript">
  $(document).ready(function() {
    $('#table_documento').DataTable( {
        "scrollY":        "200px",
        "scrollCollapse": true,
        "paging":         false,
        "language": {
            "lengthMenu": "Mostrar _MENU_ Reigistro por pagina",
            "zeroRecords": "No se encontraron registros",
            "info": "Mostrar pagina _PAGINA_ de _PAGINA_",
            "infoEmpty": "No hay registros disponibles",
            "infoFiltered": "(filtrado por _MAX_ registros total)"
        }
    } );
} );
</script>
<script type="text/javascript">
   function eliminar_documento(id){
    var op=confirm("¿Esta seguro de eliminar este documento?");
    if(op==1){
      document.location.href="capitalHumano/borrar_documento/"+id;  
    }
  }
</script>