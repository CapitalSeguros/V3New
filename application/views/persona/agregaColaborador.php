<? $this->load->view('headers/header'); ?>
<!-- Navbar -->
<? $this->load->view('headers/menu'); ?>
<link rel="stylesheet" href="http://code.jquery.com/ui/1.10.1/themes/base/jquery-ui.css" />
<script src="http://code.jquery.com/jquery-1.9.1.js"></script>
<script src="http://code.jquery.com/ui/1.10.1/jquery-ui.js"></script> 
<div style="height: auto; width: 90%;"  class="center-block">
    <label class="Responsivo lbEtiqueta " style=" margin-left: 60%" >Colaboradores</label>
<form action="<?=base_url();?>persona/colaborador"  method="post" id="formBuscarAgente">

<select class="objetosResponsivos"  name="idPersonas" id="idPersonas" >
     <option value="-1">Selecciona colaborador </option>
  <?php 
  
foreach ($agentesTemporales as $value) {
   ?>
     <option value="<?php echo($value->idPersona) ?>" > <?php echo($value->nombres.' '.$value->apellidoPaterno.' '.$value->apellidoMaterno);  ?> </option>

<?php
      }
  ?>  
  </select>
 <br>
<button class="objetosResponsivos btn-primary">Buscar</button>


</form>
</div>
<div style="height: auto; width: 90%;"  class="center-block">
<form action="<?=base_url();?>persona/colaborador"  method="post" id="formDatosAgentes">

<button class="objetosResponsivos  btn-primary" onclick="nuevoAgente(this)">Nuevo</button><button class="objetosResponsivos  btn-secondary">Guardar</button> 

<div class="divPerson"><button  onclick="Verdatos(this,'Datos')" class="objetosResponsivos btn-success objetosResponsivoGrande ">ocultar Datos</button>
<div class="divPersonSub ver">
<input type="hidden" name="idPersona" id="idPersona">
<div class="ResponsivoDiv"><label class="Responsivo lbEtiqueta">Nombre<div><input  type="text" name="nombres" id="nombres"></div></label></div>
<div class="ResponsivoDiv"><label class="Responsivo lbEtiqueta">Apellido Pat.<div><input  type="text" name="apellidoPaterno" id="apellidoPaterno"></div></label></div>
<div class="ResponsivoDiv"><label class="Responsivo lbEtiqueta">Apellido Mat.<div><input type="text" name="apellidoMaterno" id="apellidoMaterno"></div></label></div>
<div class="ResponsivoDiv"><label class="Responsivo lbEtiqueta">RFC<div><input  type="text" name="rfc" id="rfc"></div></label></div>
</div>
<div class="divPersonSub ver">
<div class="ResponsivoDiv"><label class="Responsivo lbEtiqueta">Fecha Nac.<div><input  class="fecha" type="text" name="fechaNacimiento" id="fechaNacimiento"></div></label></div>
<div class="ResponsivoDiv"><label class="Responsivo lbEtiqueta">Pais Nac.<div><input  type="text" name="paisNacimiento" id="paisNacimiento"></div></label></div>
<div class="ResponsivoDiv"><label class="Responsivo lbEtiqueta">Estado Nac.<div><input  type="text" name="estadoNacimiento" id="estadoNacimiento"></div></label></div>
<div class="ResponsivoDiv"><label class="Responsivo lbEtiqueta">Municipio Nac.<div><input   type="text" name="municipioNacimiento" id="municipioNacimiento"></div></label></div>
</div>
<div class="divPersonSub ver">
<div class="ResponsivoDiv"><label class="Responsivo lbEtiqueta">Estado Civil<div><select  type="text" name="estadoCivil" id="estadoCivil"></select></div></label></div>
<div class="ResponsivoDiv"><label class="Responsivo lbEtiqueta">Escolaridad<div><select   type="text" name="escolaridad" id="escolaridad"></select></div></label></div>
<div class="ResponsivoDiv"><label class="Responsivo lbEtiqueta">Departamento<div><select   type="text" name="personaDepartamento" id="personaDepartamento"></select></div></label></div>
<div class="ResponsivoDiv"><label class="Responsivo lbEtiqueta">Puesto<div><select   type="text" name="personaPuesto" id="personaPuesto"></select></div></label></div>
</div>
</div>






<div class="divPerson"><button onclick="Verdatos(this,'Domicilio')" class="objetosResponsivos btn-success objetosResponsivoGrande ">mostrar Domicilio</button>
<div class="divPersonSub ocultar">
<div class="ResponsivoDiv"><label class="Responsivo lbEtiqueta">Calle<div><input  type="text" name="calle" id="calle"></div></label></div>
<div class="ResponsivoDiv"><label class="Responsivo lbEtiqueta">Cruzamiento<div><input   type="text" name="cruzamiento" id="cruzamiento"></div></label></div>
<div class="ResponsivoDiv"><label class="Responsivo lbEtiqueta">Colonia<div><input  type="text" name="colonia" id="colonia"></div></label></div>
<div class="ResponsivoDiv"><label class="Responsivo lbEtiqueta">Numero<div><input   type="text" name="numero" id="numero"></div></label></div>
</div>
<div class="divPersonSub ocultar">
<div class="ResponsivoDiv"><label class="Responsivo lbEtiqueta">Codigo Postal<div><input   type="text" name="codigoPostal" id="codigoPostal"></div></label></div>
<div class="ResponsivoDiv"><label class="Responsivo lbEtiqueta">Pais<div><input  type="text" name="paisDomicilio" id="paisDomicilio"></div></label></div>
<div class="ResponsivoDiv"><label class="Responsivo lbEtiqueta">Estado<div><input   type="text" name="estadoDomicilio" id="estadoDomicilio"></div></label></div>
<div class="ResponsivoDiv"><label class="Responsivo lbEtiqueta">Municipio <div><input   type="text" name="municipioDomicilio" id="municipioDomicilio"></div></label></div>
</div>
</div>


<div class="divPerson"><button onclick="Verdatos(this,'Contacto')" class="objetosResponsivos btn-success objetosResponsivoGrande">mostrar Contacto</button>
<div class="divPersonSub ocultar">
<div class="ResponsivoDiv"><label  class="Responsivo lbEtiqueta">Tel. Casa<div><input  type="text" name="telCasa" id="telCasa"></div></label></div>
<div class="ResponsivoDiv"><label class="Responsivo lbEtiqueta">Tel. Oficina<div><input   type="text" name="telOficina" id="telOficina"></div></label></div>
<div class="ResponsivoDiv"><label class="Responsivo lbEtiqueta">Cel. Personal<div><input   type="text" name="celPersonal" id="celPersonal" ></div></label></div>
<div class="ResponsivoDiv"><label class="Responsivo lbEtiqueta">Cel. Oficina<div><input   type="text" name="celOficina" id="celOficina"></div></label></div>
</div>
<div class="divPersonSub ocultar">
<div class="ResponsivoDiv"><label class="Responsivo lbEtiqueta">Corre Electronico<div><input  type="text" name="emailPersonal" id="emailPersonal"></div></label></div>
</div>
</div>

<div class="divPerson"><button onclick="Verdatos(this,'Otros')" class="objetosResponsivos btn-success objetosResponsivoGrande">mostrar Otros</button>
  <div class="divPersonSub ocultar">
<div class="ResponsivoDiv"><label  class="Responsivo lbEtiqueta">Accidente Avisar<div><input  type="text" name="accidtePersonaAvisa" id="accidtePersonaAvisa"></div></label></div>
<div class="ResponsivoDiv"><label class="Responsivo lbEtiqueta">Tel. Accidente<div><input   type="text" name="telPersonaAvisa" id="telPersonaAvisa"></div></label></div>
<div class="ResponsivoDiv"><label class="Responsivo lbEtiqueta">Recomendado<div><input   type="text" name="recomendarPerosna" id="recomendarPerosna" ></div></label></div>
<div class="ResponsivoDiv"><label class="Responsivo lbEtiqueta">Referencia<div><input   type="text" name="referenciaPersona" id="referenciaPersona"></div></label></div>
</div>
<div class="divPersonSub ocultar">
<div class="ResponsivoDiv"><label class="Responsivo lbEtiqueta">IMSS<div><input  type="text" name="imssPersona" id="imssPersona"></div></label></div>
<div class="ResponsivoDiv"><label class="Responsivo lbEtiqueta">Tiene Hijos<div><select   name="hijosPersona" id="hijosPersona">
  <option value="S">Si</option><option value="N"> No</option>
</select></div></label></div>
<div class="ResponsivoDiv"><label class="Responsivo lbEtiqueta">Gasto Mensual<div><input  type="text" name="gastoMenPersona" id="gastoMenPersona"></div></label></div>
<div class="ResponsivoDiv"><label class="Responsivo lbEtiqueta">Meta<div><input  type="text" name="metaPersona" id="metaPersona"></div></label></div>
</div>
<div class="divPersonSub ocultar">
<div class="ResponsivoDiv"><label class="Responsivo lbEtiqueta">Comida Favorita<div><input  type="text" name="comidaFavPersona" id="comidaFavPersona"></div></label></div>
<div class="ResponsivoDiv"><label class="Responsivo lbEtiqueta">Color Favorito<div><input  type="text" name="colorFavPersona" id="colorFavPersona"></div></label></div>
<div class="ResponsivoDiv"><label class="Responsivo lbEtiqueta">Pasatiempo Favorito<div><input  type="text" name="pasatiempoFavPersona" id="pasatiempoFavPersona"></div></label></div>
<div class="ResponsivoDiv"><label class="Responsivo lbEtiqueta">Club Social<div><input  type="text" name="clubSocialPersona" id="clubSocialPersona"></div></label></div>
</div>
</div>

</form>
</div>

<script>
  function Verdatos(object,texto){
   this.event.preventDefault();
 //  alert(object.parentNode.parentNode);
 //object.parentNode.parentNode.classList.add('ocultar')
 cantidad=object.parentNode.parentNode.childNodes.length;

 for(var i=0;i<cantidad;i++){
if(object.parentNode.childNodes[i]){
  if(object.parentNode.childNodes[i].nodeName=="DIV"){
    if(object.parentNode.childNodes[i].classList.contains("ocultar")){object.parentNode.childNodes[i].classList.remove("ocultar");object.parentNode.childNodes[i].classList.add("ver");object.innerHTML="ocultar "+texto}
    else{object.parentNode.childNodes[i].classList.remove("ver");object.parentNode.childNodes[i].classList.add("ocultar");object.innerHTML="mostrar "+texto}
  }
  }
 }

  }

   var mMeses=['Enero','Febrero','Marzo','Abril','Mayo','Junio',
    'Julio','Agosto','Septiembre','Octubre','Noviembre','Diciembre'];
  var mDias=['Domingo','Lunes','Martes','Mi&eacute;rcoles','Jueves','Viernes','S&aacute;bado'];
  var mDiasCortos=['Dom','Lun','Mar','Mi&eacute;','Juv','Vie','S&aacute;b'];
$(function () {

$("#fechaNacimiento").datepicker({
  closeText: 'Cerrar',
  prevText: 'Anterior',
  nextText: 'Siguiente',
    currentText: 'Hoy',
    currntDay:new Date(),
  monthNames: mMeses,
  dayNames:mDias ,
  dayNamesShort:mDiasCortos,
  dayNamesMin: ['Do','Lu','Ma','Mi','Ju','Vi','S&aacute;'],
  dateFormat: 'dd/mm/yy',
  firstDay: 1,       
});
});
</script>


<? $this->load->view('footers/footer'); ?>
<style type="text/css">
body{overflow-x: hidden;  }
.divPerson{width: 100%;height: auto; margin-top:20px;}
.divPersonSub{width: 100%;height: auto; margin-top:10px;}
.divPersonCab{width: 100%;height: 30px;  }
.lbCabPersona{width: 100%;height: 30px;  clear: both;}
.ResponsivoDiv{float: left;}
.ResponsivoDivMe600{width: 100%;height: 160px }
.ResponsivoDivMe900{width: 50%; height: 180px }
.ResponsivoDivMa901{width: 25%;  }

.lbEtiquetaMe600{font-size: 36px;height: 160px}
.lbEtiquetaMe900{font-size: 24px; height: 180px}
.lbEtiquetaMa901{font-size: 12px;}
.objetosResponsivos{ }
.objetosResponsivoGrande{width: 100%;height: 100%}
.objectResp600{font-size: 36px;height: auto;width: 100%;margin-bottom: 30px }
.objectResp900{font-size: 24px; height: 50px;width: 100%;}
.objectResp901{font-size: 12px;}
.ver{display: block;}
.ocultar{display: none; height: 200px}
</style>


<script>


window.addEventListener("resize",redimensionar);
redimensionar();
function redimensionar(){
var responsivo=document.getElementsByClassName('Responsivo');
var responsivoDiv=document.getElementsByClassName('ResponsivoDiv');
var objetosResponsivos=document.getElementsByClassName('objetosResponsivos');

  var cantidad=responsivo.length;
  var cantidadDiv=responsivoDiv.length;
  var cantObjetosResponsivos=objetosResponsivos.length;

var w = window.outerWidth;var h = window.outerHeight;
if(w<600)
{for(i=0;i<cantObjetosResponsivos;i++){objetosResponsivos[i].classList.remove('objectResp900');objetosResponsivos[i].classList.remove('objectResp901');objetosResponsivos[i].classList.add('objectResp600');}
    for(i=0;i<cantidadDiv;i++){responsivoDiv[i].classList.remove('ResponsivoDivMe900');responsivoDiv[i].classList.remove('ResponsivoDivMa901');responsivoDiv[i].classList.add('ResponsivoDivMe600');}
  for(i=0;i<cantidad;i++){responsivo[i].classList.remove('lbEtiquetaMe900');responsivo[i].classList.remove('lbEtiquetaMa901');responsivo[i].classList.add('lbEtiquetaMe600');}
}
else
{
   if(w>601 && w<700)
   {
    for(i=0;i<cantObjetosResponsivos;i++){objetosResponsivos[i].classList.remove('objectResp901');objetosResponsivos[i].classList.remove('objectResp600');objetosResponsivos[i].classList.add('objectResp900');}
    for(i=0;i<cantidadDiv;i++){responsivoDiv[i].classList.remove('ResponsivoDivMa901');responsivoDiv[i].classList.remove('ResponsivoDivMe600');responsivoDiv[i].classList.add('ResponsivoDivMe900');}
    for(i=0;i<cantidad;i++){responsivo[i].classList.remove('lbEtiquetaMa901');responsivo[i].classList.remove('lbEtiquetaMe600');responsivo[i].classList.add('lbEtiquetaMe900');}
   }
  else
  {for(i=0;i<cantObjetosResponsivos;i++){objetosResponsivos[i].classList.remove('objectResp900');objetosResponsivos[i].classList.remove('objectResp600');objetosResponsivos[i].classList.add('objectResp901');}
   for(i=0;i<cantidadDiv;i++){responsivoDiv[i].classList.remove('ResponsivoDivMe900');responsivoDiv[i].classList.remove('ResponsivoDivMe600');responsivoDiv[i].classList.add('ResponsivoDivMa901');}
  for(i=0;i<cantidad;i++){responsivo[i].classList.remove('lbEtiquetaMe900');responsivo[i].classList.remove('lbEtiquetaMe600');responsivo[i].classList.add('lbEtiquetaMa901');}
  }
 }
}


</script>


<script>


  <?php
  $total=count($escolaridad);
  $options='document.getElementById("escolaridad").innerHTML=\'';
  for($i=0;$i<$total;$i++){$options=$options.'<option value="'.$escolaridad[$i]->idEscolaridad.'">'.$escolaridad[$i]->escolaridad.'</option>';}
  $options=$options.'\';';
  echo($options);
  $total=count($estadoCivil);
  $options='document.getElementById("estadoCivil").innerHTML=\'';
  for($i=0;$i<$total;$i++){$options=$options.'<option value="'.$estadoCivil[$i]->idEstadoCivil.'">'.$estadoCivil[$i]->estadoCivil.'</option>';}
  $options=$options.'\';';
  echo($options);

    $total=count($personaPuesto);
  $options='document.getElementById("personaPuesto").innerHTML=\'';
  for($i=0;$i<$total;$i++){$options=$options.'<option value="'.$personaPuesto[$i]->idPersonaPuesto.'">'.$personaPuesto[$i]->personaPuesto.'</option>';}
  $options=$options.'\';';
  echo($options);

    $total=count($personaDepartamento);
  $options='document.getElementById("personaDepartamento").innerHTML=\'';
  for($i=0;$i<$total;$i++){$options=$options.'<option value="'.$personaDepartamento[$i]->idPersonaDepartamento.'">'.$personaDepartamento[$i]->personaDepartamento.'</option>';}
  $options=$options.'\';';
  echo($options);
  ?>


<?php 
  //$fp = fopen('resultadoJason.txt', 'w');fwrite($fp, print_r($options, TRUE));fclose($fp);
if(isset($datosAgente)){

?>

document.getElementById('idPersona').value="<?php echo($datosAgente->idPersona); ?>";
document.getElementById('idPersonas').value="<?php echo($datosAgente->idPersona); ?>";
document.getElementById('nombres'). value="<?php echo($datosAgente->nombres); ?>";
document.getElementById('apellidoPaterno').value="<?php echo($datosAgente->apellidoPaterno); ?>";
document.getElementById('apellidoMaterno').value="<?php echo($datosAgente->apellidoMaterno); ?>";
document.getElementById('rfc').value="<?php echo($datosAgente->rfc); ?>";
document.getElementById('fechaNacimiento').value="<?php echo($datosAgente->fechaNacimiento); ?>";
document.getElementById('estadoNacimiento').value="<?php echo($datosAgente->estadoNacimiento); ?>";
document.getElementById('municipioNacimiento').value="<?php echo($datosAgente->municipioNacimiento); ?>";
document.getElementById('paisNacimiento').value="<?php echo($datosAgente->paisNacimiento); ?>";
document.getElementById('estadoCivil').value="<?php echo($datosAgente->estadoCivil); ?>"
document.getElementById('escolaridad').value="<?php echo($datosAgente->escolaridad); ?>"
document.getElementById('calle').value="<?php echo($datosAgente->calle); ?>";
document.getElementById('cruzamiento').value="<?php echo($datosAgente->cruzamiento); ?>";
document.getElementById('colonia').value="<?php echo($datosAgente->colonia); ?>";
document.getElementById('numero').value="<?php echo($datosAgente->numero); ?>";
document.getElementById('codigoPostal').value="<?php echo($datosAgente->codigoPostal); ?>";
document.getElementById('estadoDomicilio').value="<?php echo($datosAgente->estadoDomicilio); ?>";
document.getElementById('municipioDomicilio').value="<?php echo($datosAgente->municipioDomicilio); ?>";
document.getElementById('paisDomicilio').value="<?php echo($datosAgente->paisDomicilio); ?>";
document.getElementById('telCasa').value="<?php echo($datosAgente->telCasa); ?>";
document.getElementById('telOficina').value="<?php echo($datosAgente->telOficina); ?>";
document.getElementById('celPersonal').value="<?php echo($datosAgente->celPersonal); ?>";
document.getElementById('celOficina').value="<?php echo($datosAgente->celOficina); ?>";
document.getElementById('emailPersonal').value="<?php echo($datosAgente->emailPersonal); ?>";

document.getElementById('accidtePersonaAvisa').value="<?php echo($datosAgente->accidtePersonaAvisa); ?>";
document.getElementById('telPersonaAvisa').value="<?php echo($datosAgente->telPersonaAvisa); ?>";
document.getElementById('recomendarPerosna').value="<?php echo($datosAgente->recomendarPerosna); ?>";
document.getElementById('referenciaPersona').value="<?php echo($datosAgente->referenciaPersona); ?>";
document.getElementById('imssPersona').value="<?php echo($datosAgente->imssPersona); ?>";
document.getElementById('hijosPersona').value="<?php echo($datosAgente->hijosPersona); ?>";
document.getElementById('gastoMenPersona').value="<?php echo($datosAgente->gastoMenPersona); ?>";
document.getElementById('metaPersona').value="<?php echo($datosAgente->metaPersona); ?>";
document.getElementById('comidaFavPersona').value="<?php echo($datosAgente->comidaFavPersona); ?>";
document.getElementById('colorFavPersona').value="<?php echo($datosAgente->colorFavPersona); ?>";
document.getElementById('pasatiempoFavPersona').value="<?php echo($datosAgente->pasatiempoFavPersona); ?>";
document.getElementById('clubSocialPersona').value="<?php echo($datosAgente->clubSocialPersona); ?>";
document.getElementById('personaPuesto').value="<?php echo($idPersonaPuesto); ?>";
document.getElementById('personaDepartamento').value="<?php echo($idPersonaDepartamento); ?>";



<?php
}
?>
function nuevoAgente(){event.preventDefault();
document.getElementById('idPersona').value=0;
document.getElementById('idPersonas').value="";
document.getElementById('nombres'). value="";
document.getElementById('apellidoPaterno').value="";
document.getElementById('apellidoMaterno').value="";
document.getElementById('rfc').value="";
document.getElementById('fechaNacimiento').value="";
document.getElementById('estadoNacimiento').value="";
document.getElementById('municipioNacimiento').value="";
document.getElementById('paisNacimiento').value="";
document.getElementById('estadoCivil').value=""
document.getElementById('escolaridad').value=""
document.getElementById('calle').value="";
document.getElementById('cruzamiento').value="";
document.getElementById('colonia').value="";
document.getElementById('numero').value="";
document.getElementById('codigoPostal').value="";
document.getElementById('estadoDomicilio').value="";
document.getElementById('municipioDomicilio').value="";
document.getElementById('paisDomicilio').value="";
document.getElementById('telCasa').value="";
document.getElementById('telOficina').value="";
document.getElementById('celPersonal').value="";
document.getElementById('celOficina').value="";
document.getElementById('emailPersonal').value="";
document.getElementById('accidtePersonaAvisa').value="";
document.getElementById('telPersonaAvisa').value="";
document.getElementById('recomendarPerosna').value="";
document.getElementById('referenciaPersona').value="";
document.getElementById('imssPersona').value="";
document.getElementById('hijosPersona').value="";
document.getElementById('gastoMenPersona').value="";
document.getElementById('metaPersona').value="";
document.getElementById('comidaFavPersona').value="";
document.getElementById('colorFavPersona').value="";
document.getElementById('pasatiempoFavPersona').value="";
document.getElementById('clubSocialPersona').value="";

}
<?php  if(isset($mensajePersona)){echo $mensajePersona;} ?>
</script>


