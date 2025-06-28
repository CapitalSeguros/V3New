<?php $this->load->view('headers/header'); ?>
<?php $this->load->view('headers/menu');?>
<?php $this->load->view('generales/modalGenericoV3');?>

<link rel="stylesheet" href="https://releases.transloadit.com/uppy/v2.12.1/uppy.min.css">
<link rel="stylesheet" href="//code.jquery.com/ui/1.13.2/themes/base/jquery-ui.css">
<link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/v/dt/dt-1.12.1/fc-4.1.0/datatables.min.css"/>
<!--<script src="https://code.jquery.com/jquery-3.6.0.js"></script>-->

<div class="container-fluid">
  <div class="col-md-12">
    <div class="row">
      <div class="col-md-8"><h3>Buzón de inconformidades</h3></div>
      <div class="col-md-4">
        <ol class="breadcrumb">
          <li><a href="<?=base_url()?>">Inicio</a></li>
          <li class="active">Buzón de inconformidades</li>
        </ol>
      </div>
    </div>
    <hr>
  </div>
  <div class="col-md-12">
    <div class="row" role="tabpanel">
      <div style="" class="col-xs-12 col-md-1">
          <ul class="nav nav-pills nav-justified text-center" role="tablist">
            <li role="presentation" class="active" style="width: 100%"><a href="#create" aria-controls="create" role="tab" data-toggle="tab"><div><i class="fa fa-plus-circle fa-3x" aria-hidden="true"></i></div><div>Crear inconformidad</div></a></li>
            <li role="presentation" style="width: 100%"><a href="#list" aria-controls="list" role="tab" data-toggle="tab"><div><i class="fa fa-list-ol fa-3x" aria-hidden="true"></i></div><div>Lista</div></a></li>
          </ul>
      </div>

      <div class="col-md-11">
        <div class="tab-content">
          <div role="tabpanel" class="tab-pane fade in active well text-left" id="create">
            <div class="panel panel-default">
              <div class="panel-body">
                <h3><strong><small>Llene el formulario y seleccione las opciones que identifique la inconformidad que requiere reportar.</small></strong></h3>
                <form method="POST" id="inconformidadFormulario" class="form-horizontal" action="<?=base_url()?>binconformidad/crearInconformidad">
                  <h4><small>Nota: Los campos con esta anotación " * " son obligatorios.</small></h4>
                  <br>
                  <div class="form-group">
                    <label for="father-select" class="col-md-2 control-label" id="label-idCBITipo">INCONFORMIDAD *:</label>
                    <div class="col-md-10">
                      <select required class="form-control" onchange="traerHijosDeInconformidad('','idPadre')" id="tipoInconformidadSelect" name="idCBITipo"><?=imprimirTipoInconformidad($tipoInconformidad)?></select>
                    </div>
                  </div>
                  <div id="idHijoInconformidad"></div> <!--  class="Inconformidad" -->
                  <div class="form-group">
                    <label for="father-select" class="col-md-2 control-label" id="label-descripcion">COMENTARIO *:</label>
                    <div class="col-md-10">
                      <textarea id="descripcion" name="descripcion" rows="5" class="form-control" placeholder="Escriba aquí" required></textarea>
                    </div>
                  </div>
                  <div class="form-group">
                    <label for="father-select" class="col-md-2 control-label">ARCHIVOS DE EVIDENCIA:</label>
                    <div class="col-md-10">
                      <div class="example-two"> <!-- style="width: 100%; height: 10%; padding: 10px 10px 10px 10px" -->
                        <div class="for-DragDrop"></div>
                        <!--<div class="for-ProgressBar"></div>-->
                      </div>
                      <div class=" uploaded-files mt-4">
                        <div class="row">
                          <div class="col-md-4"><h4>Archivos pre cargados</h4></div>
                          <div class="mr-4">
                            <!--<input type="checkbox" id="select-all-files"><h4><label for="select-all-files"><a href="javascript: void(0)" id="all-selected" class="text-primary" all-selected="false"><i class="fa fa-check-circle" aria-hidden="true"></i> Seleccionar todos</a></label></h4>-->
                            <input type="checkbox" id="select-all-files" style="display: none;">
                            <label for="select-all-files" style="cursor: pointer"><h4><i class="fa fa-check-circle" aria-hidden="true"></i> <span class="change-selected-label"> Seleccionar todos</span></h4></label>
                          </div>
                          <div><h4><a href="#" id="delete-selected" class="text-danger"><i class="fa fa-times-circle" aria-hidden="true"></i> Descartar seleccionados</a></h4></div>
                        </div>
                        <div class="col-md-12 pre-upload-list">
                          <div class="row"></div>
                        </div>
                      </div>
                    </div>
                  </div>
                  <hr>
                  <div class="col-mc-12 text-center"><button class="btn btn-primary">Enviar al buzón</button></div>
                </form>
              </div>
            </div>
          </div>
          <div role="tabpanel" class="tab-pane fade" id="list">
            <div class="panel panel-default">
              <div class="panel-body">
                <div class="panel panel-default border">
                  <div class="panel-body">
                    <h4>Filtros de búsqueda</h4>
                    <form action="<?=base_url()?>binconformidad/getFilteredNonconformity" id="filter-form">
                      <div class="row">
                        <!--<div class="col-md-2 col-xs-12">
                          <label for="select-type-filter">Escoja un tipo de búsqueda</label>
                          <select id="select-type-filter" class="form-control">
                            <option value="nothing">Seleccione</option>
                            <option value="for-years">Rango de años</option>
                            <option value="for-months">Rango de meses</option>
                            <option value="for-date">Rango de fechas</option>
                          </select>
                        </div>-->
                        <div class="col-md-10 col-xs-12 col-sm-12 print-filters-selected">
                          <div class="col-md-2 col-xs-12 col-sm-10">
                              <label for="dateOne">Desde</label>
                              <input type="text" class="form-control datepicker-filter" name="dateOne" value="">
                          </div>
                          <div class="col-md-2 col-xs-12 col-sm-10">
                              <label for="dateTwo">Hasta</label>
                              <input type="text" class="form-control datepicker-filter" name="dateTwo" value="">
                          </div>
                          <div class="col-md-2 mt-4 text-center col-xs-12 col-sm-12">
                            <button type="submit" class="btn btn-primary">Filtrar</button>
                          </div>
                          <div class="col-md-2 mt-4 text-center col-xs-12 col-sm-12">
                            <button type="button" class="btn btn-primary show-all-elements">Mostrar todos</button>
                          </div>
                        </div>
                      </div>
                      <div class="show-alert" style="margin-top: 20px"></div>
                    </form>
                  </div>
                </div>
                <div class="panel panel-default border">
                  <div class="panel-body table-responsive">
                    <h4>Lista de contenido</h4>
                    <br>
                    <table class="table nc-list-table" style="width: 100%">
                      <thead>
                        <tr >
                          <th class="text-center">Folio</th>
                          <th class="text-center">Categoría</th>
                          <th class="text-center">Sub categoría</th>
                          <th class="text-center">Área o módulo</th>
                          <th class="text-center">Fecha de creación</th>
                          <th class="text-center">Descripción</th>
                          <th class="text-center">Estado actual</th>
                          <th class="text-center">Responsable</th>
                          <th class="text-center">Opciones</th>
                        </tr>
                      </thead>
                      <tbody class="nc-content text-center"></tbody>
                    </table>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>

    </div>
  </div>
</div>
<!---->
<div class="modal fade" id="pre-send-form" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h4 class="modal-title" id="myModalLabel">Importante</h4>
      </div>
      <div class="modal-body pre-send-info"></div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-send="false" data-dismiss="modal">Cancelar</button> <!-- data-dismiss="modal" -->
        <button type="button" class="btn btn-primary confirm-send-form" data-send="true">Confirmar</button>
      </div>
    </div>
  </div>
</div>
<!---->

<!-- Modal -->
<div class="modal fade" id="progress-modal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h4 class="modal-title" id="myModalLabel">Progreso de subida</h4>
      </div>
      <div class="modal-body progress-first-create"></div>
      <div class="modal-footer">
        <button class="btn btn-default close-and-continue" data-dismiss="modal" type="button" disabled>Cerrar</button> <!-- class="close-and-reload" -->
      </div>
    </div>
  </div>
</div>
<!--  -->
<!-- Modal -->
<div class="modal fade" id="modal-other-content" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h4 class="modal-title modal-title-others"></h4>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
      </div>
      <div class="modal-body modal-body-others"></div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button>
      </div>
    </div>
  </div>
</div>
<!-- Modal -->
<div class="modal fade" id="modal-upload-nc-file" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h4 class="modal-title modal-files-title">Subir archivos</h4>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
      </div>
      <div class="modal-body">
        <div class="row ml-2">
          <h5>Folio de inconformidad: </h5> <input type="text" readonly value="" id="folio" style="border: 0px; background-color: transparent">
          <input type="hidden" value="inconforme" id="root-folder" >
        </div>
        <div class="dragdrop-container">
          <div class="dragdrop-body"></div>
        </div>
        <div class="uploaded-files mt-4">
          <div class="row">
            <div class="col-md-4"><h5><span class="label label-info">Archivos pre cargados</span></h5></div>
            <div class="col-md-8">
              <div class="row">
                <div class="col-md-6">
                  <input type="checkbox" id="select-new-files" style="display: none;">
                  <label for="select-new-files" style="cursor: pointer"><h5><span class="change-selected-label-in-modal label label-primary"><i class="fa fa-check-circle" aria-hidden="true"></i> Seleccionar todos</span></h5></label>
                </div>
                <div>
                  <h5><a href="#" id="delete-selected-in-modal" class="text-danger"><span class="label label-danger"><i class="fa fa-times-circle" aria-hidden="true"></i> Descartar seleccionados</span></a></h5>
                </div>
              </div>
            </div>
          </div>
          <div class="col-md-12 modal-pre-upload">
            <div class="row"></div>
          </div>
          <div class="bar-progress-in-modal"></div>
        </div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button>
        <button type="button" class="btn btn-primary upload-more-to-cloud">Subir</button>
      </div>
    </div>
  </div>
</div>
<!--  -->


<style type="text/css">
  .Inconformidad>div{width: 100%;display: flex}
  .Inconformidad>div>label{flex: 1}
  /*.Inconformidad>div>select,textarea,input,button{flex: 4}*/
  .Inconformidad>div>div{flex: 100}
  

</style>
<script type="text/javascript">
  function traerHijosDeInconformidad(datos='',hijos='')
  {  
    //console.log(datos);

    if(datos=='')
    {          

     let params=`idCBI=${document.getElementById('tipoInconformidadSelect').value}&tipoBusqueda=${hijos}`;
     if(document.getElementById('tipoInconformidadSelect').value>0){
      controlador="binconformidad/devolverHijoCatalogoInconformidades/?";    
      peticionAJAXLib(controlador,params,'traerHijosDeInconformidad');
      }
      else{document.getElementById('idHijoInconformidad').innerHTML='';} 
    }
    else
    {
      let select='';
      let _select = [1, 2].includes(parseInt(datos.idCBI)) ? 
        ` <div class="form-group">
            <label for="select-1" class="col-md-2 control-label" id="label-idCBIOpcion">SUB-CATEGORIA *:</label>
            <div class="col-md-10">
              <select id="idCBIOpcion" name="idCBIOpcion" class="form-control" required>
                <option value="">Seleccione</option>
                ${(datos.informacion.reduce((acc, curr) => acc += `<option  value="${curr.idCBI}">${curr.catalogBuzonInconformidad}</option>`, ``))}
              </select>
            </div>
          </div>
          <div class="form-group">
            <label for="select-2" class="col-md-2 control-label" id="label-idCBIArea">ÁREA O MÓDULO *:</label>
            <div class="col-md-10">
              <select id="idCBIArea" name="idCBIArea" class="form-control" required>
                <option value="">Seleccione</option>
                ${(datos.catalogo.reduce((acc, curr) => acc += `<option  value="${curr.idCBI}">${curr.catalogBuzonInconformidad}</option>`, ``))}
              </select>
            </div>
          </div>` :
        ``;


      /*if(datos.idCBI==1 || datos.idCBI==2)
      {
       //select=`<div><label>OPCION INCONFORMIDAD</label><select name="opcionInconformidad"><option value="0">ESCOGER OPCION DE INCONFORMIDAD</option>`;
        select = `<div class="form-group">
          <label for="select-1" class="col-md-2 control-label">SUB-CATEGORIA:</label>
          <div class="col-md-10"></div>
        </div>`;
       datos.informacion.forEach(i=>{
        select+=`<option  value=${i.idCBI}>${i.catalogBuzonInconformidad}</option>`
      
      })
      select+=`</select></div>`;
             select+=`<div><label>ESCOGER AREA DE INCONFORMIDAD</label><select name="areaInconformidad"><option value="0">ESCOGER AREA DE INCONFORMIDAD</option>`;
       datos.catalogo.forEach(i=>{
        select+=`<option  value=${i.idCBI}>${i.catalogBuzonInconformidad}</option>`
      
      })
      select+=`</select></div>`;
      
      }*/
      //select+=`<div><label>AGREGAR COMENTARIOS</label><textarea name="smsText" style="height: 150px"></textarea></div>`;
      //select+=`<div><label>AGREGAR ARCHIVOS</label><input type="file" name="archivosInconformidad"></div>`;
      //select+=`<div><div></div><button onclick="guardarInconformidad()">Guardar</button></div>`;
      //document.getElementById('idHijoInconformidad').innerHTML=select;
      document.getElementById('idHijoInconformidad').innerHTML = _select;
      //document.getElementById('botonGuardarInconformidad').innerHTML=`<div><div></div><button onclick="guardarInconformidad()">Guardar</button></div>`;
      
      
    }
    
  }
</script>

	<?if(validation_errors() != false){?>
	<div class="alert alert-danger" role="alert">
		<?php echo validation_errors();?>
    </div>
    <?
		}  else if($alert=="success"){
	?>
	<div class="alert alert-success" role="alert">
		Su ticket de Inconformidad ha sido Registrado con el numero  <?echo $referencia; ?> tome nota para futuro seguimiento !!!
    </div>
    <?
		}
	?>


	<!--<section class="container-fluid" style="display:none">
        <form  role="form" id="form" name="form" action="<?=base_url()?>binconformidad/guardar" method="POST">

						<div class="bhoechie-tab-content active">

						
                            <div class="col-sm-8 col-md-8">
                                 <label>Escriba su Queja, Inconformidad  o Sugerencia</label> 
                             				
                             			<div class="row">
									       <textarea style="height: 150px" 
                                    	id="smsText" name="smsText" 
                                        class="form-control input-sm" placeholder="Escriba Aqui"
                                    ><?=$this->input->post('smsText',true)?></textarea>
									<p id="contSmsText">Caracteres usados: 0 de 300</p>

                            			</div>

                            			<div class="row">

                                  			 	<input type="submit" name="btnenviar" value="Enviar Inconformidad" />
									
						                </div>
                                    
							</div>
						</div>
		</form>
  </section>-->		


</div>

<script>
	function peticionAJAX(controlador,parametros,funcion){
  var req = new XMLHttpRequest();var direccionAJAX="<?= base_url();?>";
  var url=direccionAJAX+controlador;//+parametros;
  //abreCierraEspera();
 req.open('POST', url, true);
  req.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
   // document.getElementById('gifDeEspera').classList.toggle('verObjeto');
//document.getElementById('gifDeEspera').classList.toggle('ocultarObjeto');
   req.onreadystatechange = function (aEvt)
  {
    if (req.readyState == 4) {
      if(req.status == 200)
        {

         var respuesta=JSON.parse(this.responseText);
//         document.getElementById('gifDeEspera').classList.toggle('verObjeto');
         //document.getElementById('gifDeEspera').classList.toggle('ocultarObjeto');


          window[funcion](respuesta);


      }
   }
  };
 req.send(parametros);
}
function buscarReporteIncidencias(datos){
  if(datos=='')
  {
      let parametros='fecha='+document.getElementById('fechaReporte').value;  
    
  peticionAJAX('binconformidad/buscarReporte',parametros,'buscarReporteIncidencias');

  }
  else
  {      
    let rows="";
    let cantidad=datos.calificaUsuario.length;
    let indice=0;
    console.log(datos)
    if(datos.total==0){alert('No se encontraron NC en este rango de fechas');return false;}
  //BUZON DE INCONFOMIDAD
   for(let i=0;i<cantidad;i++) 
   {
    indice++;
    let comentarioInconforme='';
    let comentarioResponsable='';
    let select='<div>Responsables:<ul>';
    for(let j=0;j<datos.calificaUsuario[i].responsables.length;j++){
       select=select+'<li>'+datos.calificaUsuario[i].responsables[j].descricpioConformidadMala+'->'+datos.calificaUsuario[i].responsables[j].persona+'</li>'}
          select=select+'</ul></div>';
    for(let j=0;j<datos.calificaUsuario[i].comentarioInconforme.length;j++){comentarioInconforme=comentarioInconforme+datos.calificaUsuario[i].comentarioInconforme[j].comentarios+'<br>';}
        for(let j=0;j<datos.calificaUsuario[i].comentarioResponsable.length;j++){comentarioResponsable=comentarioResponsable+datos.calificaUsuario[i].comentarioResponsable[j].comentarios+'<br>';}
    rows=rows+'<tr>';
    rows=rows+'<td>'+indice+'</td>';
    rows=rows+'<td>Buzon Inconformidad</td>';
    rows=rows+'<td>'+datos.calificaUsuario[i].descripcion+'</td>';
    rows=rows+'<td>'+datos.calificaUsuario[i].ramoActividad+'</td>';
    rows=rows+'<td><label class="labelComentarioPrincipal">'+datos.calificaUsuario[i].personaResponsable+'<label><br>'+comentarioResponsable+'</td>';
    rows=rows+'<td><label class="labelComentarioPrincipal">'+datos.calificaUsuario[i].personaInconforme+'</label><br>'+comentarioInconforme+'</td>';
    rows=rows+'<td><label class="labelComentarioPrincipal">'+datos.calificaUsuario[i].causaRaiz+':</label><br><label>'+datos.calificaUsuario[i].comentarioCausaRaiz+'</label></td>';
    rows=rows+'<td><label class="labelComentarioPrincipal">'+datos.calificaUsuario[i].accionCorrectiva+':</label><br><label>'+datos.calificaUsuario[i].comentarioAccionCorrectiva+'</label></td>';    
    if(datos.calificaUsuario[i].noConformidadRevisada==1){if(datos.calificaUsuario[i].aFavor==1){rows=rows+'<td><label class="labelComentarioPrincipal">RESUELTO</label><br>'+datos.calificaUsuario[i].comentarioCierre+'</td>';}else{rows=rows+'<td><label class="labelComentarioPrincipal">PENDIENTE</label><br>'+datos.calificaUsuario[i].comentarioCierre+'</td>';}}
     else{rows=rows+'<td></td>'; }
    rows=rows+'</tr>';
  }

       cantidad=datos.calificaCliente.length;
  //VALIDADOR     
  for(let i=0;i<cantidad;i++) {
    indice++;
    let comentarioInconforme='';
    let comentarioResponsable='';
    let select='<div>Responsables:<ul>';
    for(let j=0;j<datos.calificaCliente[i].responsables.length;j++){
       select=select+'<li>'+datos.calificaCliente[i].responsables[j].descricpioConformidadMala+'->'+datos.calificaCliente[i].responsables[j].persona+'</li>'}
          select=select+'</ul></div>';
                 for(let j=0;j<datos.calificaCliente[i].comentarioInconforme.length;j++){comentarioInconforme=comentarioInconforme+datos.calificaCliente[i].comentarioInconforme[j].comentarios+'<br>';}
            for(let j=0;j<datos.calificaCliente[i].comentarioResponsable.length;j++){comentarioResponsable=comentarioResponsable+datos.calificaCliente[i].comentarioResponsable[j].comentarios+'<br>';}
    rows=rows+'<tr>';
    rows=rows+'<td>'+indice+'</td>';
    rows=rows+'<td>Validador</td>';
    rows=rows+'<td>'+datos.calificaCliente[i].descripcion+'</td>';
    rows=rows+'<td>'+datos.calificaCliente[i].ramoActividad+'</td>';
    rows=rows+'<td><label class="labelComentarioPrincipal">'+datos.calificaCliente[i].personaResponsable+'</label><br>'+comentarioResponsable+'</td>';
    rows=rows+'<td><label class="labelComentarioPrincipal">'+datos.calificaCliente[i].personaInconforme+'</label><br>'+comentarioInconforme+'</td>';
    rows=rows+'<td><label class="labelComentarioPrincipal>'+datos.calificaCliente[i].causaRaiz+':</label><br><label>'+datos.calificaCliente[i].comentarioCausaRaiz+'</label></td>';
    rows=rows+'<td><label class="labelComentarioPrincipal">'+datos.calificaCliente[i].accionCorrectiva+':</label><br><label>'+datos.calificaCliente[i].comentarioAccionCorrectiva+'</label></td>'; 
    if(datos.calificaCliente[i].noConformidadRevisada==1)
    { let veredicto='RESUELTO';
      if(datos.calificaCliente[i].aFavor){veredicto='PENDIENTE';}
      rows=rows+'<td><label class="labelComentarioPrincipal">'+veredicto+'</label><br>'+datos.calificaCliente[i].comentarioCierre+'</td>';
      
     }
          else{rows=rows+'<td></td>'; }
    rows=rows+'</tr>';
  }

       cantidad=datos.calificaAgente.length;
       //NC PARA OPERATIVOS
  for(let i=0;i<cantidad;i++) 
  {
    let select='<div>Responsables:<ul>';
    indice++;
    let comentarioInconforme='';
     let comentarioResponsable='';
    for(let j=0;j<datos.calificaAgente[i].responsables.length;j++){
       select=select+'<li>'+datos.calificaAgente[i].responsables[j].descricpioConformidadMala+'->'+datos.calificaAgente[i].responsables[j].persona+'</li>'}
          select=select+'</ul></div>';

       for(let j=0;j<datos.calificaAgente[i].comentarioInconforme.length;j++){comentarioInconforme=comentarioInconforme+datos.calificaAgente[i].comentarioInconforme[j].comentarios+'<br>';}
      for(let j=0;j<datos.calificaAgente[i].comentarioResponsable.length;j++){comentarioResponsable=comentarioResponsable+datos.calificaAgente[i].comentarioResponsable[j].comentarios+'<br>';}
    rows=rows+'<tr>';
    rows=rows+'<td>'+indice+'</td>';
    rows=rows+'<td>'+datos.calificaAgente[i].folioActividad+'</td>';
    rows=rows+'<td>'+datos.calificaAgente[i].descripcion+'</td>';
    rows=rows+'<td>'+datos.calificaAgente[i].ramoActividad+'</td>';
    rows=rows+'<td><label class="labelComentarioPrincipal">'+datos.calificaAgente[i].personaResponsable+'</label><br>'+comentarioResponsable+'</td>';
    rows=rows+'<td><label class="labelComentarioPrincipal">'+datos.calificaAgente[i].personaInconforme+'</label><br>'+comentarioInconforme+'</td>';
    rows=rows+'<td><label class="labelComentarioPrincipal">'+datos.calificaAgente[i].causaRaiz+':</label><br><label>'+datos.calificaAgente[i].comentarioCausaRaiz+'</label></td>';
    rows=rows+'<td><label class="labelComentarioPrincipal">'+datos.calificaAgente[i].accionCorrectiva+':</label><br><label>'+datos.calificaAgente[i].comentarioAccionCorrectiva+'</label></td>';
    if(datos.calificaAgente[i].noConformidadRevisada==1)
    {
          if(datos.calificaAgente[i].noConformidadRevisada==1)
    { let veredicto='RESUELTO';
      if(datos.calificaAgente[i].aFavor){veredicto='PENDIENTE';}
      rows=rows+'<td><label class="labelComentarioPrincipal">'+veredicto+'</label><br>'+datos.calificaAgente[i].comentarioCierre+'</td>';
      
     }
      else{rows=rows+'<td>RESUELTO</td>';}
     }
     else{rows=rows+'<td></td>'; }
    rows=rows+'</tr>';  
  }
  cantidad=datos.calificaOperativo.length;
       //NC PARA AGENTES
  for(let i=0;i<cantidad;i++) 
  {
    let select='<div>Responsables:<ul>';
    indice++;
    let comentarioInconforme='';
     let comentarioResponsable='';
    for(let j=0;j<datos.calificaOperativo[i].responsables.length;j++){
       select=select+'<li>'+datos.calificaOperativo[i].responsables[j].descricpioConformidadMala+'->'+datos.calificaOperativo[i].responsables[j].persona+'</li>'}
          select=select+'</ul></div>';
           for(let j=0;j<datos.calificaOperativo[i].comentarioInconforme.length;j++){comentarioInconforme=comentarioInconforme+datos.calificaOperativo[i].comentarioInconforme[j].comentarios+'<br>';}
           for(let j=0;j<datos.calificaOperativo[i].comentarioResponsable.length;j++){comentarioResponsable=comentarioResponsable+datos.calificaOperativo[i].comentarioResponsable[j].comentarios+'<br>';}
    let selectEstrella='<div>Estrellas:<ul style="width:200px">';
    for(let j=0;j<datos.calificaOperativo[i].estrellas.length;j++){
    let status='Mala';
    let clase='estrellaMala';
        if(datos.calificaOperativo[i].estrellas[j].calificacionActividad==1){status="Buena";clase="estrellaBuena"}
        selectEstrella=selectEstrella+'<li class="'+clase+'">'+status+'->'+datos.calificaOperativo[i].estrellas[j].calificacionAgente+'</li>';
      }
    selectEstrella=selectEstrella+'</ul></div>';
    rows=rows+'<tr>';
    rows=rows+'<td>'+indice+'</td>';
    rows=rows+'<td>'+datos.calificaOperativo[i].folioActividad+'</td>';
    rows=rows+'<td>'+datos.calificaOperativo[i].desciprcion+'</td>';
    rows=rows+'<td>'+datos.calificaOperativo[i].ramoActividad+'</td>';
    rows=rows+'<td><label class="labelComentarioPrincipal">'+datos.calificaOperativo[i].personaResponsable+'</label><br>'+comentarioResponsable+'</td>';
    rows=rows+'<td><label class="labelComentarioPrincipal">'+datos.calificaOperativo[i].personaInconforme+'</label><br>'+comentarioInconforme+'</td>';
    rows=rows+'<td><label class="labelComentarioPrincipal">'+datos.calificaOperativo[i].causaRaiz+':</label><br><label>'+datos.calificaOperativo[i].comentarioCausaRaiz+'</label></td>';
    rows=rows+'<td><label class="labelComentarioPrincipal">'+datos.calificaOperativo[i].accionCorrectiva+':</label><br><label>'+datos.calificaOperativo[i].comentarioAccionCorrectiva+'</label></td>';
 
    if(datos.calificaOperativo[i].noConformidadRevisada==1)
    {
          if(datos.calificaOperativo[i].noConformidadRevisada==1)
    { let veredicto='RESUELTO';
      if(datos.calificaOperativo[i].aFavor){veredicto='PENDIENTE';}
      rows=rows+'<td><label class="labelComentarioPrincipal">'+veredicto+'</label><br>'+datos.calificaOperativo[i].comentarioCierre+'</td>';
      
     }
      else{rows=rows+'<td></td>';}
     }
     else{rows=rows+'<td></td>'; }
    rows=rows+'</tr>';

  }
   document.getElementById('bodyReporteIncidencias').innerHTML=rows;
  }
}


	init_contadorSmsText("smsText","contSmsText", 300);

	function init_contadorSmsText(idtextarea, idcontador,max){
		$("#"+idtextarea).keyup(function(){
			updateContadorTa(idtextarea, idcontador,max);
		});
    
		$("#"+idtextarea).change(function(){
			updateContadorTa(idtextarea, idcontador,max);
		});
	}

	function updateContadorTa(idtextarea, idcontador,max){
    	var contador = $("#"+idcontador);
    	var ta =     $("#"+idtextarea);
		contador.html("Caracteres usados: "+"0 de "+max);
		contador.html("Caracteres usados: "+ta.val().length+" de "+max);
		if(parseInt(ta.val().length)>max){
			ta.val(ta.val().substring(0,max-1));
			contador.html("Caracteres usados: "+max+" de "+max);
		}

	}
//buscarReporteIncidencias('');

function guardarInconformidad(datos="")
{
  if(datos=="")
  {
   enviarFormularioMGGenerales("inconformidadFormulario","guardarInconformidad","binconformidad/guardarInconformidad");
  }
  else
  {
    //console.log(datos)
    document.getElementById('ticketInconformidad').innerHTML=`<label>SU TICKET SE GUARDO CON EL FOLIO ${datos.folio}</label>`

  }
}

	</script>
<?php $this->load->view('footers/footer'); ?>

<?
/*function imprimirAnios($datos,$anioSeleccion=null)
{  $option="";
  
  foreach ($datos as  $value) 
  { $seleccion='';
  	if($value==$anioSeleccion){$seleccion='selected';}
  	$option.='<option '.$seleccion.'>'.$value.'</option>';

  }
  return $option;
}*/
//-------------------------------------------------
function imprimirInconformidades($info)
{  $rows="";
	foreach ($info['calificaUsuario'] as  $datos) 
	{
		$select='';
		foreach ($datos->responsables as  $value) 
		{
			$select.='<div class="row"><label>'.$value->descricpioConformidadMala.'->'.$value->persona.'</label></div>';  
 		}
       
      $rows.='<tr>';
    $rows.='<td><div>Buzon inconformidad</div></td>';
    $rows.='<td>'.$datos->fCreacion.'</td>';
    $rows.='<td>'.$datos->descrNoConfomridadRevisada.'</td>';
    if($datos->noConformidadRevisada==1)
    {
      if($datos->aFavor==1){$rows.='<td>RESUELTO</td>';}
      else{$rows.='<td>PENDIENTE</td>';}
     }
     else{$rows.='<td></td>'; }
   $rows.='<td>'.$datos->personaInconforme.'</td>';
    $rows.='<td>'.$select.'</td>';

    if($datos->descripcion){$rows.='<td>'.$datos->descripcion.'</td>';}
    else{$rows.='<td></td>';}
   // rows=rows+'<td>'+datos.calificaUsuario[i].datosAlternos+'</td>';
   $datosalternos="";

   $rows.='<td>'.$datos->comentarioTNC.'</td>';
   $rows.='</tr>';

	}
	return $rows;
}
function imprimirTipoInconformidad($array)
{
  $option='<option value="" style="color:red">Escoger tipo inconformidad</option>';
  foreach ($array as $key => $value) {$option.='<option value="'.$value->idCBI.'">'.$value->catalogBuzonInconformidad.'</option>';}
  return $option;
}
?>
<script src="https://code.jquery.com/ui/1.13.2/jquery-ui.js"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.2/js/bootstrap.min.js"></script>
<script type="text/javascript" src="https://cdn.datatables.net/v/dt/dt-1.12.1/fc-4.1.0/datatables.min.js"></script>

<!-- Cargamos el bundle agregandole un query string para forzar al navegador a descargar siempre la version mas reciente del archivo -->
<script src="<?= base_url('assets/js/binconformidad_app/bundle/bundle.inconformidad.js') . '?v=' . filemtime('assets/js/binconformidad_app/bundle/bundle.inconformidad.js'); ?>" type="module"></script>

<!-- Script para modificar la tabla del buzon de inconformidades y mostrar la columna de <Responsbale> con el nuevo formato - Angel Leon -->
<script>

  /**
  * Muestra una alerta basica utilizando SweetAlert 1.x
  * 
  * @param {string} title - El titulo de la alerta
  * @param {string} message - El mensaje que se mostrara en la alerta
  * @param {string} [icon='success'] - El icono de la alerta (opcional, valor por defecto 'success').
  */
  function showSwal(title, message, icon = 'success') {
    swal({
      title: title,
      text: message,
      icon: icon
    });
  }

  /**
  * Verifica si un objeto no esta vacio
  * 
  * @param {Object} obj - El objeto a verificar
  * @return {boolean} `true` si el objeto no esta vacio; `false` en caso contrario
  */
  function isObjectNotEmpty(obj) {
    return Object.keys(obj).length > 0;
  }

  /**
  * Inserta un salto de linea despues de cada direccion de correo electronico que termina en ".com" o ".COM"
  * 
  * @param {string} correos - La cadena que contiene las direcciones de correo electronico
  * @return {string} La cadena modificada con saltos de linea y en mayusculas
  */
  function insertarSaltoDeLinea(correos) {
    let nuevo_string = correos.replace(/\.com(?=[a-zA-Z]|$)|\.COM(?=[a-zA-Z]|$)/g, '.COM<br>');
    return nuevo_string.toUpperCase();
  }

  /**
  * Obtiene una lista de IDs de datos desde la tabla en el buzon de inconformidades
  * 
  * @return {Array<string>} Un arreglo que contiene los IDs extraidos de la tabla
  */
  function obtenerListaDataId() {
    let ids = [];
    $('#DataTables_Table_0 tbody tr').each(function () {
      let td_actual = $(this).find('td').eq(5);
      let data_id = td_actual.find('a').attr('data-id');
      if (data_id) {
        data_id = data_id.trim();
        ids.push(data_id);
      }
    });
    return ids;
  }

  /**
  * Verifica si la columna deseada contiene la subcadena "Seguimiento:"
  *  
  * @return {boolean} Devuelve `true` si el texto de la columna contiene la subcadena que nos interesa, `false` en caso contrario
  */
  function esTablaActualizada() {
    let txtResponsable = $('#DataTables_Table_0 tbody tr:eq(0) td:eq(7)').text().trim(); // Obtenemos el texto de la primera fila, octava columna
    return txtResponsable.includes("Seguimiento:");
  }

  /**
  * Actualiza la columna de 'Responsables' en la tabla con los datos obtenidos
  * 
  * @param {number} checkTable - El identificador del intervalo de verificacion periodica
  */
  function actualizarColumnaResponsables(checkTable) {
    return new Promise(function (resolve, reject) {
      let data_ids = obtenerListaDataId();

      $.ajax({
        url: '<?= base_url("binconformidad/obtenerListaEvaluadoresNC") ?>',
        type: 'POST',
        data: { data_ids: data_ids },
        success: function (responseString) {
          let response = {};

          try {
            response = JSON.parse(responseString);
          } catch (error) {
            console.error('Error al tratar de hacer: JSON.parse(responseString)');
            console.error(error);
          }

          $('#DataTables_Table_0 tbody tr').each(function () {
            let td_descripcion = $(this).find('td').eq(5);
            let td_responsable = $(this).find('td').eq(7);

            let data_id = td_descripcion.find('a').attr('data-id');
            data_id = data_id.trim();

            let old_text = td_responsable.text().trim();
            let new_text = "";

            new_text += "<b>Seguimiento:</b><br>";
            if (response.hasOwnProperty(data_id)) {
              new_text += response[data_id];
            } else {
              new_text += "SIN EVALUADOR(ES)<br>";
            }
            new_text += "<b>Incidencia:</b><br>";
            new_text += insertarSaltoDeLinea(old_text);

            td_responsable.html(new_text);
          });

          resolve();
        },
        error: function (xhr, status, error) {
          showSwal('Error', "Estado: " + status + "\nCódigo de estado: " + xhr.status + "\nMensaje: " + "Error al comunicarse con la siguiente URL: " + '<?= base_url("binconformidad/obtenerListaEvaluadoresNC") ?>', 'error');
          reject(error);
        }
      });
    });
  }

  /**
  * Inicia el proceso de verificacion continua para actualizar la tabla apenas sea posible 
  */
  function inicializarActualizacionTabla() {
    let tablaYaActualizada = false;

    // Verificamos periodicamente si la tabla no esta vacia
    let checkTable = setInterval(function () {
      let row_count = $('#DataTables_Table_0 tbody tr').length;

      // Verificamos si el contenido de la tabla aun no ha sido actualizada
      tablaYaActualizada = esTablaActualizada();

      if (row_count > 0 && !tablaYaActualizada) {
        actualizarColumnaResponsables(checkTable).then(function () {
        }).catch(function (error) {
          console.error("Error durante la actualización de la tabla: ", error);
        });
      }
    }, 1500);
  }

  $(document).ready(function () {
    inicializarActualizacionTabla();
  });

</script>