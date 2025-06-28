<div id="divModalGenericoV3" class="modalCierraV3">
    <div id="divModalContenidoGenerico" class="modal-contenidoV3"  >
      <div class="row">
      <div class="col-md-1 col-sm-1">
      <button onclick="manejoDivModalV3('divModalGenericoV3')"  style="color: white;background-color:red; border:double;" id="btnCerrarModalGenericoGeneral">X</button>
      </div>

    </div>  
<hr>  
  <div id="contenidoModalGenericoV3">
  
  </div>
 </div>
</div>
<div class="gifEspera ocultarObjetoDivContenido" id="gifDeEsperaModalGenerico"><img src="<?php echo(base_url().'assets\img\loading.gif')?>"></div>
<script type="text/javascript">
var contieneAntiguoDiv='';
var idContieneAntiguoDiv='';

/*
//FORMA DE HACER UNA PETICION AJAX CON ESTE MODAL
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

* LOS DIV QUE SE INSERTAN EN ESTE MODAL DEBEN TENER LA CLASS modalGenericoContenidoV3

}*/

function peticionAJAXLib(controlador,parametros,funcion,div=''){
  var req = new XMLHttpRequest();var direccionAJAX="<?= base_url();?>";
  var url=direccionAJAX+controlador;//+parametros;
manejoGif();
 req.open('POST', url, true);
  req.setRequestHeader("Content-type", "application/x-www-form-urlencoded");

  if(div!='')
  {
   contieneAntiguoDiv=document.getElementById(div).innerHTML;
   idContieneAntiguoDiv=document.getElementById(div).id;
  }
   req.onreadystatechange = function (aEvt) 
  {
   
    if (req.readyState == 4) {    	
      if(req.status == 200)    
        {   

         var respuesta=JSON.parse(this.responseText); 
          window[funcion](respuesta);                                   
                                               
            if(div!='')
          {            
          document.getElementById('contenidoModalGenericoV3').innerHTML=document.getElementById(div).innerHTML;          
          document.getElementById(div).innerHTML='';
          manejoDivModalV3();

          
         }
         manejoGif();
      }     
      
   }

  };
 req.send(parametros);
}
function enviarFormularioMGGenerales(formulario,funcion,controlador)
{

    var Data = new FormData(document.getElementById(formulario));  
  if(window.XMLHttpRequest) { var Req = new XMLHttpRequest();}
  else if(window.ActiveXObject) {var Req = new ActiveXObject("Microsoft.XMLHTTP");}
  var direccion= <?php echo('"'.base_url().'"');?>+controlador;
  Req.open("POST",direccion, true);  
  manejoGif();
  Req.onload = function(Event) {  
    if (Req.status == 200) 
    {
      var respuesta = JSON.parse(Req.responseText); 
      window[funcion](respuesta);          
      manejoGif();
    } 
    else 
    { 
      if(Req.status==500)
      { manejoGif();

        alert('El proceso presento un error favor de notificar a sistemas error 006');                                 
      }
      
    }
  };    
  Req.send(Data);

}
function sinPeticionAjax(div)
{
  contieneAntiguoDiv=document.getElementById(div).innerHTML;
  idContieneAntiguoDiv=document.getElementById(div).id;
  document.getElementById('contenidoModalGenericoV3').innerHTML=document.getElementById(div).innerHTML;
  document.getElementById(div).innerHTML='';
  manejoDivModalV3();
}

function manejoGif(){document.getElementById('gifDeEsperaModalGenerico').classList.toggle('ocultarObjetoDivContenido');}
document.addEventListener("DOMContentLoaded", ()=>{ocultaDivParaModalGenericoV3();})

function ocultaDivParaModalGenericoV3()
{

  let div=Array.from(document.getElementsByClassName('modalGenericoContenidoV3'));
  div.forEach(d=>{d.classList.add('ocultarObjetoDivContenido');})
}
function manejoDivModalV3()
{
  if(document.getElementById('divModalGenericoV3').classList.toggle('modalCierraV3')){document.getElementById(idContieneAntiguoDiv).innerHTML=contieneAntiguoDiv; document.getElementById('contenidoModalGenericoV3').innerHTML='';}
  document.getElementById('divModalGenericoV3').classList.toggle('modalAbreV3');
}
</script>

<style type="text/css">
.modal-contenidoV3{background-color:white;width:90%px;height:90%;padding: 0% 0%;margin: 0% auto;position: relative;overflow: scroll;top:3%;left: 3%;margin-right: 5% }
.modalCierraV3{background-color: rgba(0,0,0,.8);position:fixed;top:0;right:0;bottom:0px;left:0;opacity:0;transition: all 1s;display:none;z-index: 1000}
.modalAbreV3{background-color: rgba(0,0,0,.8);position:fixed;top:0;right:0;bottom:0px;transition: all 1s;width:100%;height:100%;z-index: 10000}
.modal-contV3{background-color:white;width:800px;height:100%;padding: 0% 0%;margin: 0% auto;position: relative;z-index: 1000 }
.modalCierraContV3{background-color: rgba(0,0,0,.8);position:fixed;top:0;right:0;bottom:0px;left:0;opacity:0;transition: all 1s;display:none;z-index: 1000}
.modalAbreContV3{background-color: rgba(0,0,0,.8);position:fixed;top:0;right:0;bottom:0px;left:-100;transition: all 1s;height:100%;display:block;z-index: 1000}
.ocultarObjetoDivContenido{display: none}
.gifEspera{position: fixed;left: 50%;top:50%;z-index: 100000}
</style>

