
<?
$permisos=false;
$usuarioConPermiso=$this->tank_auth->get_usermail();
if($usuarioConPermiso=='SISTEMAS@ASESORESCAPITAL.COM' || $usuarioConPermiso=='DIRECTORGENERAL@AGENTECAPITAL.COM' || $usuarioConPermiso=='GERENTEOPERATIVO@AGENTECAPITAL.COM' || $usuarioConPermiso=='COORDINADOROPERATIVO@ASESORESCAPITAL.COM')
 {$permisos=true;}
?>
<?if($permisos){?>
<div id="divModalGenerico" class="modalCierra">
<input type="hidden" id="folioActividadACO"><input type="hidden" id="idInternoACO">
    <div id="divModalContenidoGenerico" class="modal-contenido"  >
      <div class="row">
      <div class="col-md-11 col-sm-11"><h3><label class="label label-info" id="folioActividadLabelACO"></label></h3></div>
      <div class="col-md-1 col-sm-1">
      <button onclick="cerrarModal('divModalGenerico')" style="color: white;background-color:red; border:double;">X</button>
      </div>
    </div>  
<hr>
  
<div class="row"><div class="col-sm-11 col-sm-11"><input type="text" class="form-control" id="agregarComentarioACOText" placeholder="Agregar comentario"></div><div class="col-sm-1 col-md-1"><button class="btn btn-succes" onclick=" guardarComentarioACO()">&#128190</button></div></div>
<div id="contenidoInfoDiv"></div>
</div>
</div>

<script type="text/javascript">
  var folioActividadACO='';
  var idInternoACO='';
function cerrarModal(modal)
{
     document.getElementById(modal).classList.toggle('modalCierra');
     document.getElementById(modal).classList.toggle('modalAbreCont');   
}
function guardarComentarioACO(datos='')
{
 if(datos=='')
 {
   let params=`idACO=-1&idInterno=${idInternoACO}&folioActividad=${folioActividadACO}&comentario=${document.getElementById('agregarComentarioACOText').value}`;
   controlador="actividades/guardarComentarioOperativo/?";
   peticionAJAXLib(controlador,params,'guardarComentarioACO');
 }
 else
 {
  pintarTablaComentariosACO(datos.comentarios);
 }
}
function pintarTablaComentariosACO(datos)
{
  let tabla=`<table class="table"><thead><tr><th>Comentario</th><th>Fecha</th></tr></thead><tbody>`;
  datos.forEach(d=>{
   tabla+=`<tr><td>${d.comentario}<br><br><label class="label label-info">${d.userEmail}</label></td><td>${d.fechaInsercion}</td></tr>`;
  })
  tabla+=`</tbody></tbody>`;
  document.getElementById('contenidoInfoDiv').innerHTML=tabla;
}
function abrirVentanaComentariosOperativos(datos='',idInterno,folioActividad)
{
  if(datos=='')
  {
    console.log(event)
    event.stopPropagation();
   //let params='idEncuesta='+idEncuesta;
   //controlador="verEncuesta/verEncuestados/?";
   //peticionAJAXLib(controlador,params,'verEncuestados');
    document.getElementById('contenidoInfoDiv').innerHTML='';
   idInternoACO=idInterno;
   folioActividadACO=folioActividad;
   document.getElementById('folioActividadLabelACO').innerHTML=folioActividad;
      let params=`folioActividad=${folioActividadACO}&comentario=${document.getElementById('agregarComentarioACOText').value}`;
   controlador="actividades/guardarComentarioOperativo/?";
   peticionAJAXLib(controlador,params,'guardarComentarioACO');

   cerrarModal('divModalGenerico')
  }
  else
  {
    
  	pintarTablaComentariosACO(datos.comentarios);
  }

}

function peticionAJAXLib(controlador,parametros,funcion){
  var req = new XMLHttpRequest();var direccionAJAX="<?= base_url();?>";
  var url=direccionAJAX+controlador;//+parametros;
  //abreCierraEspera();
 req.open('POST', url, true);
  req.setRequestHeader("Content-type", "application/x-www-form-urlencoded");

//document.getElementById('gifDeEspera1').classList.add('verObjetoGif');
//document.getElementById('gifDeEspera1').classList.remove('ocultarObjeto');
   req.onreadystatechange = function (aEvt) 
  {
   
    if (req.readyState == 4) {
    	
      if(req.status == 200)    
        {           
         var respuesta=JSON.parse(this.responseText); 
          //document.getElementById('gifDeEspera1').classList.remove('verObjetoGif');
        //document.getElementById('gifDeEspera1').classList.add('ocultarObjeto');                    
          window[funcion](respuesta);                                            
      }     
      if(req.status==500)
      {
        //document.getElementById('gifDeEspera1').classList.remove('verObjetoGif');
        //document.getElementById('gifDeEspera1').classList.add('ocultarObjeto');
       //alert('El proceso presento un error favor de notificar a sistemas error 006');                                 
      }
      
   }

  };
 req.send(parametros);
}



</script>

<style type="text/css">
	.modal-contenido{background-color:white;width:800px;height:100%;padding: 0% 0%;margin: 0% auto;position: relative;overflow: scroll; }
.modalCierra{background-color: rgba(0,0,0,.8);position:fixed;top:0;right:0;bottom:0px;left:0;opacity:0;transition: all 1s;display:none;relative;z-index: 1000}
.modalAbre{background-color: rgba(0,0,0,.8);position:fixed;top:0;right:0;bottom:0px;left:-100;transition: all 1s;width:20%;height:20%;z-index: 10000}


  .modal-cont{background-color:white;width:800px;height:100%;padding: 0% 0%;margin: 0% auto;position: relative;z-index: 1000 }
  .modalCierraCont{background-color: rgba(0,0,0,.8);position:fixed;top:0;right:0;bottom:0px;left:0;opacity:0;transition: all 1s;display:none;z-index: 1000}
  .modalAbreCont{background-color: rgba(0,0,0,.8);position:fixed;top:0;right:0;bottom:0px;left:-100;transition: all 1s;height:100%;display:block;z-index: 1000}
  .encuestaContestada{background-color:#a4a4a4 ;}
</style>
<?}else{?>
<script type="text/javascript">
  document.addEventListener("DOMContentLoaded", function(){
 let btn=Array.from(document.getElementsByClassName('btnActividadComentariosOperativos'));    //....
  btn.forEach(b=>{
    b.parentNode.removeChild(b);
  })
});
<?}?>
</script>