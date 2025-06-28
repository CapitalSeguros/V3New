<? $this->load->view('headers/header'); ?><? $this->load->view('headers/menu'); ?>
<div class="divPrincipal">
<div class="divMenu">
    <button id="btnGuardarActualizacion" class="buttonMenu " onclick="guardarActualizacionAJAX('')" ><label>Guardar Actualizacion </label></button><br>
    <button id="btnCancelarActualizacion" class="buttonMenu " onclick="cancelarActualizacionAJAX('')"><label>Cancelar Actualizacion</label></button><br>
    <button id="btnActualizarCliente" class="buttonMenu " onclick="actualizarClienteAJAX('')"><label>Actualizar Cliente</label></button><br>
</div>
  <div id="divContenido" class="divContenido">
    <div id="divContenedorTabla" style="overflow-x: scroll; width: 100%; margin-left: 20px;margin-right: 20px">

</div>
  </div>

</div>

<div class="gifEspera ocultarObjeto" id="gifDeEspera"><img src="<?php echo(base_url().'assets\img\loading.gif')?>"></div>



<script type="text/javascript">
  
		var url="<?=base_url();?>";
var rowActivoGlobal;

function actualizarClienteAJAX(datos)
{
 if(datos=='')
 {
   var rowActivo=document.getElementsByClassName('rowActivo');
   rowActivoGlobal=rowActivo[0].rowIndex;
   var params = "idClienteVerificar="+rowActivo[0].getAttribute('data-clienteverifica')+"&ajax=1";
   params=params+'&IDCli='+rowActivo[0].getAttribute('data-idcli');
   controlador="clientes/datosClienteSICAS/?";
   peticionAJAX(controlador,params,'actualizarClienteAJAX');
   
 }
 else
 {
   document.getElementById('tablaClientes').rows[rowActivoGlobal].cells[1].innerHTML=datos.datosCliente.NombreCompleto;
   document.getElementById('tablaClientes').rows[rowActivoGlobal].cells[2].innerHTML=datos.datosCliente.Telefono1;
   document.getElementById('tablaClientes').rows[rowActivoGlobal].cells[3].innerHTML=datos.datosCliente.EMail1;
     abreCierraEspera();
 }

}
function guardarActualizacionAJAX(datos){

  if(datos==''){
   var rowActivo=document.getElementsByClassName('rowActivo');
   if(rowActivo.length==1)
   {   
   rowActivoGlobal=rowActivo[0].rowIndex;
   var params = "idClienteVerificar="+rowActivo[0].getAttribute('data-clienteverifica')+"&ajax=1";
   params=params+'&IDCli='+rowActivo[0].getAttribute('data-idcli');
   controlador="clientes/guardarActualizacion/?";
   peticionAJAX(controlador,params,'guardarActualizacionAJAX');

   }
   else{alert('Escoger un row');}
  }
  else
  {

   alert(datos.mensajeV3);
   document.getElementById("tablaClientes").deleteRow(rowActivoGlobal);
     abreCierraEspera();
  }
}
function cancelarActualizacionAJAX(datos){
  if(datos==''){
   var rowActivo=document.getElementsByClassName('rowActivo');
   if(rowActivo.length==1){
   
   rowActivoGlobal=rowActivo[0].rowIndex;
   var params = "idClienteVerificar="+rowActivo[0].getAttribute('data-clienteverifica')+"&ajax=1";
   controlador="clientes/cancelarActualizacion/?";
   peticionAJAX(controlador,params,'cancelarActualizacionAJAX');
  
   }
   else{alert('Escoger un row');}
  }
  else
  {
   alert(datos.mensaje);
   document.getElementById("tablaClientes").deleteRow(rowActivoGlobal);
     abreCierraEspera();
  }
}

function peticionAJAX(controlador,parametros,funcion){
  var req = new XMLHttpRequest();var direccionAJAX="<?= base_url();?>";
  var url=direccionAJAX+controlador;//+parametros;
  abreCierraEspera();
 req.open('POST', url, true);
  req.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
   req.onreadystatechange = function (aEvt) 
  {
    if (req.readyState == 4) {
      if(req.status == 200)
        { 
         var respuesta=JSON.parse(this.responseText);    
         switch(funcion){
          case 'cancelarActualizacionAJAX':cancelarActualizacionAJAX(respuesta);break;
          case 'guardarActualizacionAJAX':guardarActualizacionAJAX(respuesta);break;
          case 'actualizarClienteAJAX':actualizarClienteAJAX(respuesta);break;
         }                                                           
      }     
   }
  };
 req.send(parametros);
}
function abreCierraEspera(){
  document.getElementById('gifDeEspera').classList.toggle('verObjeto');
document.getElementById('gifDeEspera').classList.toggle('ocultarObjeto');

}
 
//ajustaTamanioCabecera();
function cancelarActualizacion(idClienteVerificar){
crearObjetosParaForm(idClienteVerificar,'claseForm','idClienteVerificar');
enviarFormGenerales('claseForm','clientes/cancelarActualizacion');
}
function guardarActualizacion(IDCli,idClienteVerificar){
 crearObjetosParaForm(IDCli,'claseForm','IDCli');
 crearObjetosParaForm(idClienteVerificar,'claseForm','idClienteVerificar');
 enviarFormGenerales('claseForm','clientes/guardarActualizacion');

}
function enviarFormGenerales(clase,controlador){
  var direccion=<?php echo('"'.base_url().'";'); ?>;
  direccion=direccion+controlador;
  var formulario=document.createElement('form'); formulario.setAttribute('method','post'); formulario.action=direccion;formulario.setAttribute('name','miFormulario');formulario.setAttribute('id','miFormulario');
  objetosForm=document.getElementsByClassName(clase);objetos="";cant=objetosForm.length;
  for(var i=0;i<cant;i++)
  {var objeto=document.createElement('input'); 
   objeto.setAttribute('value',objetosForm[i].value);
   objeto.setAttribute('name',objetosForm[i].name);
   objeto.setAttribute('type','hidden');
   formulario.appendChild(objeto); 
  }
  var objeto=document.createElement('input'); 
   objeto.setAttribute('name','idFormEnvio');
   objeto.setAttribute('type','hidden');
   formulario.appendChild(objeto);
  document.body.appendChild(formulario);
  formulario.submit();
}
function crearObjetosParaForm(datos,clase,nombre){
	var input=document.createElement('input');
	input.setAttribute('type','hidden');input.setAttribute('value',datos);input.setAttribute('class',clase);input.setAttribute('name',nombre);document.body.appendChild(input);
}
function ocultarHijos(objetoTD)
{
  let padre=objetoTD.parentNode;
  let val=padre.dataset.val;
  let elementos=document.getElementsByName(val);
  let cant=elementos.length;
  if(objetoTD.innerHTML=='-'){objetoTD.innerHTML='+';}
  else{objetoTD.innerHTML='-';}
  for(let i=0;i<cant;i++)
  {
   elementos[i].classList.toggle('ocultarObjeto');

  }
}

<?php 
$tabla="";
$tabla.='<div style="width:1000;height: 30px;border:double;overflow:hidden;" id="scrollCabecera"><table style="width: 1000px"><thead style="width: 1000px;  background-color:#472380; color:white;"><tr><td classList="divTD10">vobn</td><td><div class="divTD">Usuario que modifica</div></td><td><div class="divTD">Nombre</div></td><td><div class="divTD">telefono actual</div></td><td><div class="divTD">email actual</div></td><td><div class="divTD">datos para modificar</div></td><td><div class="divTD"></div></td><td><div class="divTD"></div> </td></tr></thead></table></div>';
$tabla.='<div onscroll="moverScroll()" id="scrollTabla" style="width:1000;overflow-x:scroll;overflow-y: scroll;height: 400px;border:double;"><table style="width:1000px" border="1"  id="tablaClientes"><thead style="width: 1000px;visibility: hidden;" ><tr><td classList="divTD10">vddon</td><td><div class="divTD">Usuario que modifica</div></td><td><div class="divTD">Nombre</div></td><td><div class="divTD100">telefono actual</div></td><td><div class="divTD">email actual</div></td><td><div class="divTD">datos para modificar</div></td></tr></thead><tbody style="width: 1000px;"><tr class="trCabBody" data-val="trCab0"><td onclick="ocultarHijos(this)" id="tdCab0">-</td><td colspan="5">DATOS MODIFICADOS EN ACTIVIDADES</td></tr>';
foreach ($clienteVerificar as  $value) {
  $tabla=$tabla.'<tr onclick="activarRow(this)" data-IDCli="'.$value->IDCli.'" data-ClienteVerifica="'.$value->idClienteVerificar.'" name="trCab0" >';
  $tabla=$tabla.'<td classList="divTD10"></td>';
  $tabla=$tabla.'<td><div class="divTD">'.$value->emailUsuario.'</div></td>';
  $tabla=$tabla.'<td><div class="divTD">'.$value->NombreCompleto.'</div></td>';
  $tabla=$tabla.'<td><div class="divTD100">'.$value->Telefono1.'</div></td>';
  $tabla=$tabla.'<td><div class="divTD">'.$value->EMail1.'</div></td>';

  $datosMod=explode(";", $value->campos);
  $datos="";
    foreach ($datosMod as  $valueDatosMod) {
      $datos=$datos.$valueDatosMod.'<br>';
    }

    $tabla=$tabla.'<td>'.$datos.'</td>';
  
  $tabla=$tabla.'</tr>';
  }
$tabla=$tabla.'<tr class="trCabBody" data-val="trCab1"><td onclick="ocultarHijos(this)" id="tdCab1">-</td><td colspan="5">CLIENTES QUE NO TIENEN ACTUALIZACION</td></tr>';
foreach ($clientesConDetalle as  $value) {
  
   $tabla=$tabla.'<tr onclick="activarRow(this)" data-IDCli="'.$value->IDCli.'" class="'.$value->detalle.' " name="trCab1" >';
  $tabla=$tabla.'<td class="divTD10"><div></div></td>';
  $tabla=$tabla.'<td><div class="divTD"></div></td>';
  $tabla=$tabla.'<td><div class="divTD">'.$value->nombreCliente.'</div></td>';
  $tabla=$tabla.'<td><div class="divTD100">'.$value->Telefono1.'</div></td>';
  $tabla=$tabla.'<td><div class="divTD">'.$value->EMail1.'</div></td>';

    $tabla=$tabla.'<td></td>';
    //$tabla=$tabla.'<td><button onclick="guardarActualizacion('.$value->IDCli.','.$value->idClienteVerificar.')">Guardar actualizacion</button></td>';
    //$tabla=$tabla.'<td><button onclick="cancelarActualizacion('.$value->idClienteVerificar.')">Cancelar actualizacion</button></td>';
  $tabla=$tabla.'</tr>';
}
 $tabla=$tabla.'</tbody></table>';






echo('document.getElementById(\'divContenedorTabla\').innerHTML=\''.$tabla.'\';');
?>

ocultarHijos(tdCab0);
ocultarHijos(tdCab1);
function activarRow(trObjeto){
  var tabla=document.getElementById('tablaClientes');
  var totalRows=tabla.rows.length;
  if(trObjeto.getAttribute('data-clienteverifica')==null){

    document.getElementById('btnCancelarActualizacion').setAttribute('disabled','');
    document.getElementById('btnCancelarActualizacion').setAttribute('style','color:silver');
       document.getElementById('btnGuardarActualizacion').setAttribute('disabled','');
    document.getElementById('btnGuardarActualizacion').setAttribute('style','color:silver');
  }else{
        document.getElementById('btnCancelarActualizacion').removeAttribute('disabled','');
    document.getElementById('btnCancelarActualizacion').removeAttribute('style','color:silver');
    document.getElementById('btnGuardarActualizacion').removeAttribute('disabled','');
    document.getElementById('btnGuardarActualizacion').removeAttribute('style','color:silver');
  }

  for(var i=0; i<totalRows;i++){
  tabla.rows[i].classList.remove('rowActivo');
  }
  
trObjeto.classList.add('rowActivo');
}
function moverScroll(){
   var elmnt = document.getElementById("scrollTabla");
    var x = elmnt.scrollLeft;
document.getElementById("scrollCabecera").scrollLeft=x;
}

</script>
<script type="text/javascript">
<?php if(isset($mensajeV3)){echo('alert("'.$mensajeV3.'");');}?>
</script>
<style type="text/css">

.divTD{width: 250px; overflow: auto;}
.divTD10{max-width: 10px; }
.divTD100{width: 150px; overflow: auto;}
.cabeceraOculta{opacity: 0; }
.contTabla2{width: 100%; height:50px;overflow-x: hidden; overflow-y: hidden; }
.contTabla{ width: 100%;height: 300px; overflow-x: hidden; overflow-y: scroll;}
.tableV3{width: 100%}
.tableV3>thead{background-color: #472380;color: white;}
.rowActivo{background-color:#2ad52a; color:white;}
.divPrincipal{width: 100%; display: flex; }
.divMenu{width:  10%; min-width: 100px;  height: 350px;border: none; border-right: solid;border-bottom: solid;}
.divMenu button{ width: 100% }
.divContenido{width: 90%  }
.buttonMenu{color: black;background-color: white}
.buttonMenu>label{width: 50px;font-size: .8em;}
.buttonMenu>label:hover{  cursor: pointer; }
.classEmailSF{color:black;}
.classEmailDeAgente{color: red;}
.classEmailVacio{color: blue; }
  .gifEspera{position: absolute;left: 0%;top:0%;border:solid;width: 100%;height: 900px;}
  .gifEspera>img{position: relative;left: 50%;top: 50%}
  .ocultarObjeto{display: none}
  .verObjeto{display: block;}
  .trCabBody{background-color: blue;color: white}

</style>