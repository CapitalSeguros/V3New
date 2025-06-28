<?php 
    $this->load->view('capacita/menu_capacita');
    
//---------------------------------------------
  $ruta_documento="https://firebasestorage.googleapis.com/v0/b/v3plus-279402.appspot.com/o/documentosCapacita%2F";

  $docs=array();

  //var_dump($infoVideos);

  if(isset($documentos)){
    foreach($documentos as $valor){

      $ruta_local=str_replace("persona","",base_url())."assets/documentos/capitalHumano/";
      $ruta_documento="";

      if($valor->carpeta=="materialDidactico"){
        $ruta_documento=$ruta_local.$valor->carpeta."/".$valor->url;

        $docs[$valor->nombre]=$ruta_documento;
      }


      /*$rutaFirebase=$ruta_documento.str_replace(" ","%20",$valor->url_documento);

      if(file_contents_exist($rutaFirebase)){
        $datos_doc=json_decode(file_get_contents($rutaFirebase),true);
        $token=$datos_doc["downloadTokens"];
        $urlFinal=$rutaFirebase."?alt=media&token=".$token;

        $docs[$valor->nombre]=$urlFinal;
        //array_push($docs, array($valor->nombre,$urlFinal));
      }*/

    }
  }

  //$fp = fopen('resultadoJason.txt', 'w');fwrite($fp, print_r($docs, TRUE));fclose($fp);
//---------------------------------------------
?>
<div  style="height: 800px; overflow: scroll-y;">
  <div class="new-lateral-menu" style="width: 120px; vertical-align: top; display: inline-block; padding: 10px 5px 10px 5px"></div>
  <div style="width: 90%; vertical-align: top; display: inline-block">
    <div role="tabpanel">
      <ul class="nav nav-tabs" role="tablist">
      <li role="presentation" class="active"><a href="#newAgent" aria-controls="newAgent" role="tab" data-toggle="tab">Agentes nuevos</a></li>
      <li role="presentation"><a href="#newEmploye" aria-controls="newEmploye" role="tab" data-toggle="tab">Colaboradores nuevos</a></li>
      </ul>
      <form action="" id="formCaracteristicas" onSubmit="evitarEnvio(event)">
      <div class="tab-content">
        <div role="tabpanel" class="tab-pane active" id="newAgent"> 
          <?php 
            $agents = array_filter($personasEnProceso, function($arr){
              return $arr->tipoPersona == 3;
            });
            //var_dump($agents);
            echo imprimirTablaAgentesNuevos($agents,$permisoAgenteNuevo,$coordinadores,$docs,"Agentes", $headsAgent); //$personasEnProceso
          ?></div>
        <div role="tabpanel" class="tab-pane" id="newEmploye">
          <?php 
            $employe = array_filter($personasEnProceso, function($arr){
              return $arr->tipoPersona == 1;
            });
            //var_dump($employe);
            echo imprimirTablaAgentesNuevos($employe,$permisoAgenteNuevo ,$coordinadores,$docs,"Colaborador", $headsEmploye); //$personasEnProceso
          ?>
        </div>
      </div>
      </form>
    </div>
  </div>

</div>

<!--<div class="row" style="height:800px;overflow: scroll-y;">
  <form action="" id="formCaracteristicas" onSubmit="evitarEnvio(event)">
  <?=imprimirTablaAgentesNuevos($personasEnProceso,$permisoAgenteNuevo,$coordinadores,$docs);?>
  </form>
</div>-->

<div id="divModalGenericoComentarios" class="ocultarHijoModal" style="border:solid;">
  <div><button style="color: white;background-color:red; border:double;" onclick="cerrarModalHijo('divModalGenericoComentarios')">X</button><input type="hidden" id="textIdPersonaComentario"><input type="hidden" id="textTipoComentarioPN"><label id="labelNombrePersonaComentario"></label></div><hr>
  <div class="row"><div class="col-md-12"><input type="text" name="" id="comentarioParaAN" class="form-control" placeholder="agregar comentario"></div><div class="col-md-4"><button class="btn btn-success" onclick="grabaComentarioAgenteNuevo('')">Guardar</button></div><div class="col-md-12" style="height: 160px;width: 100%; overflow: auto;"><table class="table"><thead><tr><td>Comentario</td><td>Fecha</td><td>Modificar</td><td>Eliminar</td></tr></thead><tbody id="tablaBodyContieneComentarios"></tbody></table></div></div>
</div>

<div id="divModalGenericoSubirDocumentos" class="ocultarHijoModal" style="border:solid;">
  <div><button style="color: white;background-color:red; border:double;" onclick="cerrarModalHijo('divModalGenericoSubirDocumentos')">X</button><label id="labelNombrePersonaArchivo"></label></div><hr>
  <div class="row"><div class="col-md-12"><form id="formArchivoAgenteNuevo"><input type="file" id="subirArchivoAgenteNuevo" name="Archivo" style="" onchange="agregaArchivoAgenteNuevo('',this);"><input type="hidden" name="idPersona" id="textIdPersonaSubirDocumentoPN"><input type="hidden" name="idTipoArchivo" id="textTipoComentarioSubirDocumentoPN"></form></div><div class="col-md-12" style="height: 160px;width: 90%; overflow: auto;"><table class="table"><thead><tr><td>Documento</td><td>Eliminar</td></tr></thead><tbody id="tablaBodyContieneDocumentos"></tbody></table></div></div>
</div>

<script src="<?=base_url()."assets/js/js_manajeNewAgent.js"?>"></script>
<?php $this->load->view('footers/footer'); ?>

<script type="text/javascript">
function evitarEnvio(e)
{e.preventDefault()}
  function pasarComoAgente(datos,idPersona, table)
  {
    //-------------------------------------------
    //[Dennis 2020-10-09]
    var contador=0;
    var elementosCheck=document.getElementsByName("id_"+idPersona);
    var totalCheck = 0;

    for(var i=0; i<elementosCheck.length; i++){

      if(elementosCheck[i].type=="checkbox"){
          totalCheck++;

        if(elementosCheck[i].checked){

          contador++;
        }
      }
    }
    //-------------------------------------------

    if(datos=='')
   {
    //-------------------------------------------------------
    //[Dennis 2020-10-09]
    if(contador == totalCheck){

      let params='';
      params=params+'idPersona='+idPersona+'&type='+table;          
      controlador="persona/pasarComoAgente/?";
      peticionAJAX(controlador,params,'pasarComoAgente');

    } else{
      alert("El agente nuevo tiene que tener habilitado las "+totalCheck+" inducciones.");
    }

    //------------------------------------------------------
     /*let params='';
      params=params+'idPersona='+idPersona;          
      controlador="persona/pasarComoAgente/?";
      peticionAJAX(controlador,params,'pasarComoAgente');*/
    }   
    else
    {
      //let tablaBody=document.getElementById('tableBodyAgenteNuevo');
      var tablaBody=document.getElementById(`tableBody${datos.type}Nuevo`);
      var cant=tablaBody.rows.length;
      for(let i=0;i<cant;i++)
      { 
        if(tablaBody.rows[i].getAttribute('data-idpersona')==datos.idPersona)
        {
          tablaBody.deleteRow(i);
          i=cant;
        }
      }      
    }
  }


function abrirModalComentario(datos,objeto=null,tipo=null,idPersona=null){
  if(datos=='')
  { document.getElementById('labelNombrePersonaComentario').innerHTML=objeto.parentNode.parentNode.getAttribute('data-nombrepersona');   
    let cant=document.getElementsByClassName('verHijoModal').length;    

    if(cant==0)
     { 
     document.getElementById('divModalGenericoComentarios').classList.toggle('ocultarHijoModal');
     document.getElementById('divModalGenericoComentarios').classList.toggle('verHijoModal');   
     document.getElementById('textIdPersonaComentario').value=idPersona;
      document.getElementById('textTipoComentarioPN').value=tipo;
     document.getElementById("comentarioParaAN").removeAttribute('disabled');
          let params='';
      params=params+'idPersona='+document.getElementById('textIdPersonaComentario').value;
      params=params+'&tipoComentario='+document.getElementById('textTipoComentarioPN').value;
      controlador="persona/grabaComentarioAgenteNuevo/?";
      peticionAJAX(controlador,params,'abrirModalComentario');    

     }
     else{alert('Ya tiene abierto un modal');}
    }
    else
    {
      bodyComentariosAgenteNuevo(datos);
    }
}

function guardarCaracteristicasAgenteNuevo(datos,objeto=null)
{
 
  if(datos=='')
  {
     /*let params='';
      params=params+'idPersona='+objeto.getAttribute('data-idpersona');
      params=params+'&caracteristicaAgenteNuevo='+objeto.getAttribute('data-idtipoobservacion');
      if(objeto.checked){params=params+'&insertar=1';}
      else{params=params+'&insertar=0';}      
      controlador="persona/guardarCaracteristicasAgenteNuevo/?";*/
      //peticionAJAX(controlador,params,'guardarCaracteristicasAgenteNuevo');

      //------------------------------------------
      //Opción de [Dennis 2020-09-29]

      var idPersona=objeto.getAttribute("data-idpersona");
      var caracteristica=objeto.getAttribute("data-idtipoobservacion");
      var typePerson=objeto.getAttribute("data-type");
      var insertar=0;
      var url=window.location.href.replace("agentesEnProceso","");
      //var observaciones=[];

      if(objeto.checked){
        insertar=1;
      }

      var xmlhttp=new XMLHttpRequest();

      xmlhttp.onreadystatechange=function(){
        if(this.readyState==4 && this.status==200){

          console.log(this.responseText);
          var ul=document.getElementById("list_"+idPersona);

          if(objeto.checked && caracteristica!="miinfo"){
            var li=document.createElement("li");

            var liA=document.createAttribute("id");
            liA.value="li_"+idPersona+"_"+caracteristica;
            li.setAttributeNode(liA); //Insertar Id del elemento
            var li_idPersona=document.createAttribute("data-idPersona");
            var li_caracteristica=document.createAttribute("data-caracteristica");
            
            var a=document.createElement("a");

            li_idPersona.value=idPersona;
            li_caracteristica.value=caracteristica;

            li.setAttributeNode(li_idPersona);
            li.setAttributeNode(li_caracteristica);

            //li.textContent=caracteristica.replace("manualagente","Manual agente").replace("induccionempresa","Inducción empresa").replace("agenteideal","Agente ideal").replace("capacitacionsistema","Capacitación sistema").toUpperCase(); //Insertar Texto
            a.textContent=caracteristica.replace("manualagente","Manual agente").replace("induccionempresa","Inducción empresa").replace("agenteideal","Agente ideal").replace("capacitacionsistema","Capacitación sistema").toUpperCase(); //Insertar Texto
            li.setAttribute("onclick","solicitarEvaluacion(this)");
            li.appendChild(a);
            ul.appendChild(li);

          }else if(objeto.checked==false && caracteristica!="miinfo"){
            var li_d=document.getElementById("li_"+idPersona+"_"+caracteristica);
            var padre=li_d.parentNode;

            padre.removeChild(li_d);
            //console.log(li_d);
          }

        }
      }

      xmlhttp.open("POST", url+"guardarCaracteristicasAgenteNuevo", true);
      xmlhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
      xmlhttp.send("idPersona="+idPersona+"&caracteristicaAgenteNuevo="+caracteristica+"&tipoPersona="+typePerson+"&insertar="+insertar+"&envioSolicitudEvaluacion=0");
      //------------------------------------------
  }
}


function modficarComentarioAgenteNuevo(datos,idComentario=null,eliminar=null)
{
 if(datos=='')
 {
   let params='';
   params=params+'comentario='+document.getElementById('ComentarioTD'+idComentario).innerHTML;
   params=params+'&idComentarioAgenteNuevo='+idComentario;
   params=params+'&idPersona='+document.getElementById('textIdPersonaComentario').value;
   params=params+'&tipoComentario='+document.getElementById('textTipoComentarioPN').value;
   if(eliminar!=null)
   {
    params=params+'&activo=0';
   }

   controlador="persona/grabaComentarioAgenteNuevo/?";
   peticionAJAX(controlador,params,'modficarComentarioAgenteNuevo');    
 }
 else{bodyComentariosAgenteNuevo(datos); getComentArchivos('');}
}

 function abrirModalSubirArchivos(datos,objeto=null,tipo=null,idPersona=null){
  if(datos=='')
  {   document.getElementById('labelNombrePersonaArchivo').innerHTML=objeto.parentNode.parentNode.getAttribute('data-nombrepersona');    
    let cant=document.getElementsByClassName('verHijoModal').length;    
    if(cant==0)
     { 
     document.getElementById('divModalGenericoSubirDocumentos').classList.toggle('ocultarHijoModal');
     document.getElementById('divModalGenericoSubirDocumentos').classList.toggle('verHijoModal');   
     document.getElementById('textIdPersonaSubirDocumentoPN').value=idPersona;
      document.getElementById('textTipoComentarioSubirDocumentoPN').value=tipo;     
          let params='';
      params=params+'idPersona='+idPersona;
      params=params+'&idTipoArchivo='+tipo;
      controlador="persona/devolverArchivosAgenteNuevo/?";
      peticionAJAX(controlador,params,'abrirModalSubirArchivos');    

     }
     else{alert('Ya tiene abierto un modal');}
    }
    else
    {
      bodyArchivosAgenteNuevo(datos);
    }
}

function bodyComentariosAgenteNuevo(datos)
{
      let cant=datos.comentarios.length;
      let row=""; 
      for(let i=0;i<cant;i++)
      {let idComentario=datos.comentarios[i].idComentarioAgenteNuevo;
        row=row+'<tr><td contenteditable="true" id="ComentarioTD'+idComentario+'">'+datos.comentarios[i].comentario+'</td><td>'+datos.comentarios[i].fechaCreacion+'</td>';
        row=row+'<td><button onclick="modficarComentarioAgenteNuevo(\'\','+idComentario+')">...</button></td><td><button onclick="modficarComentarioAgenteNuevo(\'\','+idComentario+',1)">-</button></td></tr>';
      }
      document.getElementById('tablaBodyContieneComentarios').innerHTML=row;
}
function peticionAJAX(controlador,parametros,funcion){
  var req = new XMLHttpRequest();var direccionAJAX="<?= base_url();?>";
  var url=direccionAJAX+controlador;
 req.open('POST', url, true);
  req.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
   req.onreadystatechange = function (aEvt) 
  {
    if (req.readyState == 4) {
      if(req.status == 200)
        {           
         var respuesta=JSON.parse(this.responseText); 
         window[funcion](respuesta);                                                          
      }     
   }
  };
 req.send(parametros);
}


  function cerrarModalHijo(hijo)
  {
     document.getElementById(hijo).classList.toggle('ocultarHijoModal');
     document.getElementById(hijo).classList.toggle('verHijoModal');    
}

function cerrarModal(modal){
     document.getElementById(modal).classList.toggle('modalCierra');
     document.getElementById(modal).classList.toggle('modalAbre');   
}

    function grabaComentarioAgenteNuevo(datos)
  { 
   if(datos=='')
   {
    let params='';
   params=params+'comentario='+document.getElementById('comentarioParaAN').value;
   params=params+'&idPersona='+document.getElementById('textIdPersonaComentario').value;
   params=params+'&tipoComentario='+document.getElementById('textTipoComentarioPN').value;
   controlador="persona/grabaComentarioAgenteNuevo/?";

      peticionAJAX(controlador,params,'grabaComentarioAgenteNuevo');    
    }
    else{ bodyComentariosAgenteNuevo(datos);  getComentArchivos('');  }
  }
function agregaArchivoAgenteNuevo(datos,objeto=null)
{
  if(datos=='')
  {
    if(!objeto.value.length){idPromoBono='';}
    else
    {     enviarArchivoAJAX('formArchivoAgenteNuevo','subirArchivoAgenteNuevo','agregaArchivoAgenteNuevo');
    }
  }
  else{bodyArchivosAgenteNuevo(datos); getComentArchivos('');  }
}
function bodyArchivosAgenteNuevo(datos)
{
   let cant=datos.archivos.length;
   let row='';
   for(let i=0;i<cant;i++)
   {
    row=row+'<tr><td>'+datos.archivos[i].url+'</td><td><button onclick="eliminarArchivo(\'\',\''+datos.archivos[i].nombreArchivo+'\')">X</button></td></tr>';
   }
   document.getElementById('tablaBodyContieneDocumentos').innerHTML=row;
}

function eliminarArchivo(datos,archivo)
{
  if(datos=="")
  {      
      let params='';
      params=params+'idPersona='+document.getElementById('textIdPersonaSubirDocumentoPN').value;
      params=params+'&idTipoArchivo='+document.getElementById('textTipoComentarioSubirDocumentoPN').value;
      params=params+'&nombreArchivo='+archivo;
      controlador="persona/eliminarArchivo/?";
      peticionAJAX(controlador,params,'eliminarArchivo');    

  }
  else
  {
   bodyArchivosAgenteNuevo(datos);getComentArchivos('');
  }
}
function enviarArchivoAJAX(formulario,funcion,funcionJS){ 

      getComentArchivos(''); 
      var Data = new FormData(document.getElementById(formulario));  
    if(window.XMLHttpRequest) { var Req = new XMLHttpRequest();}
    else if(window.ActiveXObject) {var Req = new ActiveXObject("Microsoft.XMLHTTP");}  
    var direccion= <?php echo('"'.base_url().'persona/"');?>+funcion;
    Req.open("POST",direccion, true);     
    Req.onload = function(Event) {    
    var respuesta = JSON.parse(Req.responseText);   
    if (Req.status == 200 && Req.readyState == 4) 
    {     
                       
     window[funcionJS](respuesta);
    } 

  };   
  Req.send(Data);


}

function filtraTablaAgenteNuevo(objeto, type)
{
    var filtro=objeto.value;
    var tabla=document.getElementById(`tableBody${type}Nuevo`);    
    var cantidad=tabla.rows.length;
   var contador=0;
    if(filtro!='')
    {
     for(var i=0; i<cantidad;i++)
     {
        var texto=tabla.rows[i].getAttribute('data-usercreacion');                
        console.log(texto+'---'+filtro);
        if(texto==filtro)
          { 
            tabla.rows[i].classList.add("verElemento");           
            tabla.rows[i].classList.remove("ocultarElemento");                                   
           }
           else{ tabla.rows[i].classList.add("ocultarElemento");tabla.rows[i].classList.remove("verElemento");}
         
         
     }
    }
    else{
       for(var i=0; i<cantidad;i++){
          tabla.rows[i].classList.add("verElemento");            
            tabla.rows[i].classList.remove("ocultarElemento");            
            
       }
    }
  
}

<?=imprimirCaracteristicas($caracteristicas);?>
</script>

<style type="text/css">
	.ocultarHijoModal{display: none}
.verHijoModal{position: absolute;top:20%;left:30%;z-index:200000;background: #bfbac5;width: 600px;height: 400px;transition: all 1s;}
.modalCierra{background-color: rgba(0,0,0,.8);position:fixed;top:0;right:0;bottom:0px;left:0;opacity:0;transition: all 1s;display:none;z-index: 1000}
.dverHijoModal{background-color: rgba(0,0,0,.8);position:fixed;top:0;right:0;bottom:0px;left:-100;transition: all 2s;width:100%;height:900px;display:block;relative;z-index: 1000}
.ocultarElemento{display: none;}
.verElemento{display:  table-row; }
 
</style>

<?
function imprimirCaracteristicas($datos)
{
  $caracteristicas="";
  $cont = 0;
  foreach ($datos as $key => $value) 
  {
      $dat='
        var chk_'.$cont.' = document.getElementById("'.'cb'.$value->idPersona.$value->caracteristicaAgenteNuevo.'");
        if(document.body.contains(chk_'.$cont.')){
          chk_'.$cont.'.checked=true;
        }
      ';
        $caracteristicas.=$dat;
        $cont++;
  }

  return $caracteristicas;
}
/*function imprimirCaracteristicas($datos)
{
  $caracteristicas="";

  foreach ($datos as $key => $value) 
  {
      $dat='document.getElementById("'.'cb'.$value->idPersona.$value->caracteristicaAgenteNuevo.'").checked=true;';
        $caracteristicas.=$dat;

  }

  return $caracteristicas;
}*/
function imprimirTablaAgentesNuevos($datos,$permiso,$coordinadores,$docs_url,$type, $table){
//Modificacion Miguel Jaime 01/11/2018
	$option='<option value=""></option>';
	    foreach ($coordinadores as  $value) {
    $option=$option.'<option value="'.$value->email.'">'.$value->nombres.' '.$value->apellidoPaterno.' '.'('.$value->email.')</option>';
  }
 //Fin modficacion
  //---------
  // Dennis Castillo [2021-10-31]
  $thead = array_reduce($table, function($acc, $cur){

    $acc .= "<th>".$cur->caracteristicaAgenteNuevo."</th>";

    return $acc;
  }, "");
  //--------

  $tablaAgente='<table class="table"><thead><tr><th>Agente de Nuevo Ingreso</th><th><label>Usuario Creador<select class="form-control" onchange="filtraTablaAgenteNuevo(this, \''.$type.'\')">'.$option.'</select></label></th>'.$thead.'<th>Evaluación</th><th>Visto Bueno</th>'; //Dennis Castillo [2021-10-31]
  //$tablaAgente='<table class="table"><thead><tr><th>Agente de Nuevo Ingreso</th><th><label>Usuario Creador<select class="form-control" onchange="filtraTablaAgenteNuevo(this)">'.$option.'</select></label></th><th>My_Info</th><th >Induccion_empresa</th><th>Manual_Agente</th><th>Agente__Ideal</th><th>Capacitacion del Sistema</th><th>Evaluación</th><th>Visto Bueno</th>';
  //-----------------------------------------------------------------
  //[Dennis 2020-09-30]
  $tablaAgente.='
    <th>
        <div class="dropdown">
        <a id="Menu_doc" data-toggle="dropdown" data-target="#" aria-haspopup="true">
        &nbsp&nbsp&nbsp&nbsp
        <i style="font-size:20px" class="fa fa-ellipsis-v" aria-hidden="true" data-toogle="tooltip" data-html="true" title="Documentos didácticos"></i>
        &nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp
        </a>
        <ul class="dropdown-menu" aria-labelledby="Menu_doc">';

  if(isset($docs_url)){
    foreach($docs_url as $titulo=>$direccion){
      $tablaAgente.='<li><a href='.$direccion.' target="_blank"><i class="fa fa-files-o" aria-hidden="true"></i>&nbsp'.$titulo.'</a></li><li class="divider"></li>';
    }
  }
  $tablaAgente.='
        </ul>
        </div>
    </th>';
  //-----------------------------------------------------------------
  $tablaAgente.='</tr></thead><tbody id="tableBody'.$type.'Nuevo">'; //Dennis Castillo [2021-10-31]
  //$tablaAgente.='</tr></thead><tbody id="tableBodyAgenteNuevo">';

 foreach ($datos as $key => $value) 
 {

  
      	$idPersona=$value->idPersona;
        $tipoPersona=$value->tipoPersona;
         if($tipoPersona=='1'){$tipoPersona='(Colaborador)';}
         else{$tipoPersona='(Agente)';}
        //$id.=$value->idPersona.',';
          $fechaAlta=explode('-',$value->fecAltaSistemPersona);      
        $nombre=$value->apellidoPaterno.' '.$value->apellidoMaterno.' '.$value->nombres;
        $tablaAgente.='<tr style="text-align:center;" data-idpersona="'.$value->idPersona.'" data-usercreacion="'.$value->userEmailCreacion.'" data-nombrepersona="'.$nombre.'">
          <td>'.$nombre.$tipoPersona.'<br>Fecha de alta:'.$fechaAlta[2].'-'.$fechaAlta[1].'-'.$fechaAlta[0].'</td>
          <td>'.$value->userEmailCreacion.'</td>';

          foreach($table as $t_rd){ //Dennis Castillo [2021-10-31]

            if($t_rd->caracteristicaAgenteNuevo == "miinfo"){
              $tablaAgente .= '<td><input id="cb'.$value->idPersona.'miinfo" type="checkbox" data-idpersona="'.$value->idPersona.'" data-idtipoobservacion="'.$t_rd->caracteristicaAgenteNuevo.'" data-type="'.strtolower($type).'" onclick="guardarCaracteristicasAgenteNuevo(\'\',this)" name="id_'.$value->idPersona.'"></td>';
            } else{
              $tablaAgente .= '<td><button onclick="abrirModalComentario(\'\',this,\''.$t_rd->caracteristicaAgenteNuevo.'\','.$value->idPersona.')" class="btn btn-primary">...</button><button onclick="abrirModalSubirArchivos(\'\',this,\''.$t_rd->caracteristicaAgenteNuevo.'\','.$value->idPersona.')" class="btn btn-primary">↑</button><input id="cb'.$value->idPersona.$t_rd->caracteristicaAgenteNuevo.'" type="checkbox" data-idpersona="'.$value->idPersona.'" data-idtipoobservacion="'.$t_rd->caracteristicaAgenteNuevo.'" data-type="'.strtolower($type).'" onclick="guardarCaracteristicasAgenteNuevo(\'\',this)" name="id_'.$value->idPersona.'"></td>';
            }
          }
          //<td><input id="cb'.$value->idPersona.'miinfo" type="checkbox" data-idpersona="'.$value->idPersona.'" data-idtipoobservacion="miinfo" onclick="guardarCaracteristicasAgenteNuevo(\'\',this)" name="id_'.$value->idPersona.'"></td>
          //<td><button onclick="abrirModalComentario(\'\',this,\'induccionempresa\','.$value->idPersona.')" class="btn btn-primary">...</button><button onclick="abrirModalSubirArchivos(\'\',this,\'induccionempresa\','.$value->idPersona.')" class="btn btn-primary">↑</button><input id="cb'.$value->idPersona.'induccionempresa" type="checkbox" data-idpersona="'.$value->idPersona.'" data-idtipoobservacion="induccionempresa" onclick="guardarCaracteristicasAgenteNuevo(\'\',this)" name="id_'.$value->idPersona.'"></td>
          //<td><button onclick="abrirModalComentario(\'\',this,\'manualagente\','.$value->idPersona.')" class="btn btn-primary">...</button><button onclick="abrirModalSubirArchivos(\'\',this,\'manualagente\','.$value->idPersona.')" class="btn btn-primary">↑</button><input id="cb'.$value->idPersona.'manualagente" type="checkbox" data-idpersona="'.$value->idPersona.'" data-idtipoobservacion="manualagente" onclick="guardarCaracteristicasAgenteNuevo(\'\',this)" name="id_'.$value->idPersona.'"></td>
          //<td><button onclick="abrirModalComentario(\'\',this,\'agenteideal\','.$value->idPersona.')" class="btn btn-primary">...</button><button onclick="abrirModalSubirArchivos(\'\',this,\'agenteideal\','.$value->idPersona.')" class="btn btn-primary">↑</button><input id="cb'.$value->idPersona.'agenteideal" type="checkbox" data-idpersona="'.$value->idPersona.'" data-idtipoobservacion="agenteideal" onclick="guardarCaracteristicasAgenteNuevo(\'\',this)" name="id_'.$value->idPersona.'"></td>
          //<td><button onclick="abrirModalComentario(\'\',this,\'capacitacionsistema\','.$value->idPersona.')" class="btn btn-primary">...</button><button onclick="abrirModalSubirArchivos(\'\',this,\'capacitacionsistema\','.$value->idPersona.')" class="btn btn-primary">↑</button><input id="cb'.$value->idPersona.'capacitacionsistema" type="checkbox" data-idpersona="'.$value->idPersona.'" data-idtipoobservacion="capacitacionsistema" onclick="guardarCaracteristicasAgenteNuevo(\'\',this)" name="id_'.$value->idPersona.'"></td>';
        //---------------------------------------------------------------
        //Dennis[2020-09-28]
        $tablaAgente.= 
        '<td>
          <div class="dropdown">
            <button id="dLabel'.$value->idPersona.'" type="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="true">Solicitar</button>
            <ul class="dropdown-menu" role="menu" aria-labelledby="dLabel'.$value->idPersona.'" id="list_'.$value->idPersona.'"></ul>
          </div>
        </td>';
        //---------------------------------------------------------------
          if($permiso=='1')
          {
            //$tablaAgente.='<td><button id="btn_'.$value->idPersona.'" onclick="pasarComoAgente(\'\','.$value->idPersona.'); return false;">Aceptar</button>';
            $tablaAgente.='<td><button id="btn_'.$value->idPersona.'" onclick="pasarComoAgente(\'\','.$value->idPersona.', \''.$type.'\'); return false;">Aceptar</button>';

          }
          else
          {
            $tablaAgente.='<td></td></tr>';            
          }
      
      

      
 }
 $tablaAgente.='</tbody></table>';
 return $tablaAgente;
}
?>
<?php 
  //------------------------------------------------
  function file_contents_exist($url, $response_code = 200){
    $headers = get_headers($url);
    if (substr($headers[0], 9, 3) == $response_code){
        return TRUE;
    }else{
        return FALSE;
    }
  }
?>


<script src="<?=base_url()."/assets/js/js_agentesNuevos.js"?>"></script>
<script type="text/javascript">
  function getComentArchivos(datos='')
  {
    if(datos=='')
    {
      let arregloColaborador=Array.from(document.getElementById('tableBodyColaboradorNuevo').rows);
      let arregloAgente=Array.from(document.getElementById('tableBodyAgentesNuevo').rows);
      idColaborador='';
      idAgente='';
      arregloColaborador.forEach(a=>{idColaborador+=a.dataset.idpersona+','})
      arregloAgente.forEach(a=>{idAgente+=a.dataset.idpersona+','})
      let params='';
      params=params+'idColaborador='+idColaborador+'&idAgente='+idAgente;          
      controlador="persona/devuelveBanderaDePersonaComentarioArchivos/?";
      peticionAJAX(controlador,params,'getComentArchivos');
     
     
    }
    else
    {
       let band=0;
       datos.colaborador.forEach(c=>{

        band=c.induccionempresa ? 1:0;
        asignaClaseSiTienComentarioArchivo('tableBodyColaboradorNuevo',3,0,c.idPersona,band)
        band=c.capacitacionsistema ? 1:0;
        asignaClaseSiTienComentarioArchivo('tableBodyColaboradorNuevo',4,0,c.idPersona,band);
        band=c.reglamentointeriordetrabajo ? 1:0;
        asignaClaseSiTienComentarioArchivo('tableBodyColaboradorNuevo',5,0,c.idPersona,band);
        band=c.experienciacapital ? 1:0;
        asignaClaseSiTienComentarioArchivo('tableBodyColaboradorNuevo',6,0,c.idPersona,band);

        band=c.induccionempresaDoc ? 1:0;
        asignaClaseSiTienComentarioArchivo('tableBodyColaboradorNuevo',3,1,c.idPersona,band)
        band=c.capacitacionsistemaDoc ? 1:0;
        asignaClaseSiTienComentarioArchivo('tableBodyColaboradorNuevo',4,1,c.idPersona,band);
        band=c.reglamentointeriordetrabajoDoc ? 1:0;
        asignaClaseSiTienComentarioArchivo('tableBodyColaboradorNuevo',5,1,c.idPersona,band);
        band=c.experienciacapitalDoc ? 1:0;
        asignaClaseSiTienComentarioArchivo('tableBodyColaboradorNuevo',6,1,c.idPersona,band);
       })
        datos.agente.forEach(c=>{
        band=c.induccionempresa ? 1:0;
        asignaClaseSiTienComentarioArchivo('tableBodyAgentesNuevo',3,0,c.idPersona,band);
        band=c.manualagente ? 1:0;
        asignaClaseSiTienComentarioArchivo('tableBodyAgentesNuevo',4,0,c.idPersona,band);
        band=c.agenteideal ? 1:0;
        asignaClaseSiTienComentarioArchivo('tableBodyAgentesNuevo',5,0,c.idPersona,band);
        band=c.capacitacionsistema ? 1:0;
        asignaClaseSiTienComentarioArchivo('tableBodyAgentesNuevo',6,0,c.idPersona,band)

        band=c.induccionempresaDoc ? 1:0;
        asignaClaseSiTienComentarioArchivo('tableBodyAgentesNuevo',3,1,c.idPersona,band);
        band=c.manualagenteDoc ? 1:0;
        asignaClaseSiTienComentarioArchivo('tableBodyAgentesNuevo',4,1,c.idPersona,band);
        band=c.agenteidealDoc ? 1:0;
        asignaClaseSiTienComentarioArchivo('tableBodyAgentesNuevo',5,1,c.idPersona,band);
        band=c.capacitacionsistemaDoc ? 1:0;
        asignaClaseSiTienComentarioArchivo('tableBodyAgentesNuevo',6,1,c.idPersona,band)        
       })
    }
  }
function asignaClaseSiTienComentarioArchivo(tabla='',celda='',hijoCelda=0,idPersona='',add)
{
  let rows=Array.from(document.getElementById(tabla).rows);
  if(add){rows.forEach(r=>{if(r.dataset.idpersona==idPersona){r.cells[celda].children[hijoCelda].classList.add('tieneDocumentoArchivo')}})}
  else{rows.forEach(r=>{if(r.dataset.idpersona==idPersona){r.cells[celda].children[hijoCelda].classList.remove('tieneDocumentoArchivo')}})}
}
getComentArchivos('');
</script>
<style type="text/css">
  .tieneDocumentoArchivo{background-color: #49df69}
</style>