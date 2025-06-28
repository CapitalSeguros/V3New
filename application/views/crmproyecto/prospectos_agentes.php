
<?php
$this->load->view('headers/menu');
$this->load->view('headers/headerReportes');
$user=$this->tank_auth->get_usermail();
?>
<style type="text/css">
#table_id{
      font-size: 10px;
    margin-left: -10px;
    border-style: solid;
    border-color: silver;
    width: 100%;

}
#table_id tr td{
    max-width: 10%;
}
#pantalla{
   height: auto;
   overflow-y: scroll;
   margin-top: -8px;
}
.form-control{
    font-size: 11px;
}
#editar_comentarios {
    background-color: rgba(0, 0, 0, 0.7);
    position: fixed;
    top: 0;
    left: 0;
    width: 100%;
    height: 100%;
    z-index: 1050;
}
</style>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/js/bootstrap.min.js" integrity="sha384-OgVRvuATP1z7JjHLkuOU7Xw704+h835Lr+6QL9UvYjZE3Ipu6Tp75j7Bh/kR0JKI" crossorigin="anonymous"></script>
<script src="https://code.jquery.com/jquery-3.5.1.min.js" integrity="sha256-9/aliU8dGd2tb6OSsuzixeV4y/faTqgFtohetphbbj0=" crossorigin="anonymous"></script>
<input type="hidden" id="base" value="<?php echo base_url()?>">
<div class="well" style="width: 50%;padding: 10px;margin-top: 8px;margin-left: 5px;">
    <input type="text" name="nombre" class="form-control" placeholder="Busqueda por nombre de prospecto"  onkeyup="filtroProspectoAgenteKey(this,'prospecto')">
</div>

<!--<section>
    <h3 class="titulo-secciones" style="font-size: 18px;">&nbsp;&nbsp;&nbsp;Seguimiento Prospección de Agentes</h3>
    <div style="margin-bottom: 9px;">&nbsp;
        <a href="<?php echo base_url()?>crmproyecto/seguimiento_prospecto"><button class="btn btn-primary" type="button"><i class="fa fa-arrow-left"></i>&nbsp;&nbsp;Volver</button></a>
        <button class="btn btn-primary" type="button" onclick="enviar_status()"><i class="fa fa-edit"></i>&nbsp;&nbsp;Actualizar Status</button>
        <button class="btn btn-primary" type="button" onclick="enviar_asignacion()" style="background-color: #4387af;"><i class="fa fa-arrow-right"></i>&nbsp;&nbsp;Asignar</button>
    </div>
</section>-->
<div id="pantalla">
    <!--<?php include('prospectos_agentes_filtrado.php');?>-->
    <?php $this->load->view("crmproyecto/manageProspectiveAgent");?>
</div>

<!--Modal de Modificacion-->

<div id="editar_comentarios" class="modal" role="dialog">
  <div class="modal-dialog" style="width: 100%;font-size: 12px;">
  <!-- Modal content-->
    <div class="modal-content" style="width: 130%;">
      <div class="modal-header">
        <h5 class="modal-title" style="color: #fff;"><i class="fa fa-edit"></i>&nbsp;Editar Comentarios</h5>
      </div>
      <div class="modal-body" style="width: 100%;">
        <br>
        <div class="well">
        <table style="width: 100%">
          <input type="hidden" name="id_edit" id="id_edit">
          <tr>
              <td><span style="font-weight: bold;font-size: 12px;">Nombre Prospecto:</span></td>
              <td><span id="nombre_edit"></span></td>
          </tr>
          <tr>
            <td><span style="font-weight: bold;font-size: 12px;">Comentarios: </span></td>
            <td><textarea name="comentarios_edit" id="comentarios_edit" cols="50" rows="4"></textarea></td>
          </tr>
        </table>
        </div>
      </div>
       <div class="modal-footer">
        <table>
          <tr>
            <td><button type="button" class="btn btn-warning btn-md" data-dismiss="modal"><i class="fa fa-times"></i> Cancelar
            <td>&nbsp;</td>
            <td><button type="button" class="btn btn-primary btn-md" onclick="guardar_comentarios()" data-dismiss="modal"><i class="fa fa-check"></i> Aceptar</button></td>
            </button>
            </td>
          </tr>
        </table>
       </div>
    </div>
  </div>
</div>

<script type="text/javascript">

/* Ajax*/
function objetoAjax(){
var oHttp=false;
        var asParsers=["Msxml2.XMLHTTP.5.0", "Msxml2.XMLHTTP.4.0",
        "Msxml2.XMLHTTP.3.0", "Msxml2.XMLHTTP", "Microsoft.XMLHTTP"];
        for (var iCont=0; ((!oHttp) && (iCont<asParsers.length)); iCont++){
            try{
                oHttp=new ActiveXObject(asParsers[iCont]);
            }
            catch(e){
                oHttp=false;
            }
        }
        if ((!oHttp) && (typeof XMLHttpRequest!='undefined')){
        oHttp=new XMLHttpRequest();
    }
return oHttp;
}


function guardar_agente_temporal(nombres,apellidoP,apellidoM,email,telefono,fechaRegistro){
   var op=confirm("¿Esta seguro de traspasar este agente a capital humano?");
   if(op==1){
   var url=document.getElementById('base').value;
    document.location.href=url+"crmproyecto/guardar_agente_temporal?nombres="+nombres+"&apellidoP="+apellidoP+"&apellidoM="+apellidoM+"&email="+email+"&telefono="+telefono+"&fechaRegistro="+fechaRegistro;
    }
 }


//Modificacion actualizacion prospectos 02/02/2021
 function actualizarProspectos(){
    var tipo=document.getElementById('tipo_prospecto').value;
    if(tipo!=2){
        const prospectos=[];
        var hasta=document.getElementById('ct').value;
        for(i=0;i<hasta;i++){
            var chk=document.getElementById('check'+i).checked;
            if(chk==true){
                var id=document.getElementById('check'+i).value;
                prospectos.push(id);
            }
        }
        if(prospectos.length>0){
            ids=JSON.stringify(prospectos);
            var url="<?php echo base_url()?>crmproyecto/setProspecto";
            document.location.href=url+'?tipo='+tipo+'&ids='+ids;
        }else{
            alert("Debe seleccionar al menos un prospecto");
        }
     }else{
        alert("Debe seleccionar un tipo de prospecto para actualizar");
     }

 }

const prospectos_agentes=[];
function seleccionar_agentes(id){
  prospectos_agentes.push(id);
}


function enviar_status() {
  if(prospectos_agentes.length>0){
      divResultado = document.getElementById('pantalla');
      ajax=objetoAjax();
      var base=document.getElementById('base').value;
      var URL=base+"crmproyecto/actualizar_prospectos_agentes?p="+JSON.stringify(prospectos_agentes);
      ajax.open("GET", URL);
      ajax.onreadystatechange=function() {
          if (ajax.readyState==4) {
              divResultado.innerHTML = ajax.responseText
          }
       }
       ajax.send(null)
  }else{
      alert("Debe seleccionar al menos un Agente");
  }
}

function enviar_asignacion(){
  if(prospectos_agentes.length>0){
      divResultado = document.getElementById('pantalla');
      ajax=objetoAjax();
      var base=document.getElementById('base').value;
      var URL=base+"crmproyecto/actualizar_prospectos_agentes_asignacion?p="+JSON.stringify(prospectos_agentes);
      ajax.open("GET", URL);
      ajax.onreadystatechange=function() {
          if (ajax.readyState==4) {
              divResultado.innerHTML = ajax.responseText
          }
       }
       ajax.send(null)
  }else{
      alert("Debe seleccionar al menos un Agente");
  }
}


function modificar_agentes_seleccionados(){
    var base=document.getElementById('base').value;
    var url=base+"crmproyecto/modificar_agentes_seleccionados";
    var status=document.getElementById('status').value;
    var URL=url+'?status='+status+'&prospectos='+prospectos_agentes;
    divResultado = document.getElementById('pantalla');
    ajax=objetoAjax();
     ajax.open("GET", URL);
    ajax.onreadystatechange=function() {
        if (ajax.readyState==4) {
            divResultado.innerHTML = ajax.responseText
            prospectos_agentes.length=0;
        }
     }
     ajax.send(null)
}

function modificar_agentes_seleccionados_asignacion(){
    var base=document.getElementById('base').value;
    var url=base+"crmproyecto/modificar_agentes_seleccionados_asignacion";
    var asignado=document.getElementById('asignado').value;
    var URL=url+'?status='+status+'&asignado='+asignado+'&prospectos='+prospectos_agentes;
    
    divResultado = document.getElementById('pantalla');
    ajax=objetoAjax();
     ajax.open("GET", URL);
    ajax.onreadystatechange=function() {
        if (ajax.readyState==4) {
            divResultado.innerHTML = ajax.responseText
            prospectos_agentes.length=0;
        }
     }
     ajax.send(null)
}

function eliminar_prospecto_agente(id){
    var opt=confirm("¿Esta seguro de eliminar este Prospecto de Agente?");
    if(opt==1){
        divResultado = document.getElementById('pantalla');
        ajax=objetoAjax();
        var base=document.getElementById('base').value;
        var URL=base+'crmproyecto/EliminarProspectoAgente?id='+id;
        ajax.open("GET", URL);
        ajax.onreadystatechange=function() {
            if (ajax.readyState==4) {
                divResultado.innerHTML = ajax.responseText
            }
         }
         ajax.send(null)
    }
}

function filtroProspectoAgente(valor,param){
    divResultado = document.getElementById('pantalla');
    ajax=objetoAjax();
    valor=valor.value;
    var base=document.getElementById('base').value;
    var URL=base+"crmproyecto/prospectos_agentes_filtrado?param="+param+"&valor="+valor;
    ajax.open("GET", URL);
    ajax.onreadystatechange=function() {
        if (ajax.readyState==4) {
            divResultado.innerHTML = ajax.responseText
        }
     }
     ajax.send(null)
}

function filtroProspectoAgenteKey(valor,param){
    divResultado = document.getElementById('pantalla');
    ajax=objetoAjax();
    valor=valor.value;
    var base=document.getElementById('base').value;
    var URL=base+"crmproyecto/prospectos_agentes_filtradoKey?param="+param+"&valor="+valor;
    ajax.open("GET", URL);
    ajax.onreadystatechange=function() {
        if (ajax.readyState==4) {
            divResultado.innerHTML = ajax.responseText
        }
     }
     ajax.send(null)
}

function editar_prospecto_agente(id,comentarios,nombre){
    document.getElementById('id_edit').value=id;
    document.getElementById('comentarios_edit').value=comentarios;
    document.getElementById('nombre_edit').innerHTML=nombre;
}


function guardar_comentarios(){
    var id=document.getElementById('id_edit').value;
    var comentario=document.getElementById('comentarios_edit').value;
    divResultado = document.getElementById('pantalla');
    ajax=objetoAjax();
    var base=document.getElementById('base').value;
    var URL=base+'crmproyecto/actualiza_comentario?comentario='+comentario+'&id='+id;
    ajax.open("GET", URL);
    ajax.onreadystatechange=function() {
        if (ajax.readyState==4) {
            divResultado.innerHTML = ajax.responseText

        }
     }
     ajax.send(null)
}


</script>




