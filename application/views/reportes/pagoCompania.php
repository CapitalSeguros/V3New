<?php 
  $this->load->view('headers/header');
  $this->load->view('headers/headerReportes'); 
?>
<?php
  $this->load->view('headers/menu');
?>
<style type="text/css">
.divPanel{border-bottom: solid;height: 100px;width: 100%}
.divPanel >div{float: left; margin-left: 20px}
.divPanelHojas{width: 800px}
</style>
<div id="divContenido">
  <div id="divCabecera" class="divPanel">
  	<div class="divPanelHojas">
   
    <select id="selectTipoComparasion" class="form-control" onchange="cambiarValor(this.value)" ><option value="">Seleccionar forma de comparacion año o mes</option><option>Año</option><option>Mes</option></select> 	
  	<div> <label><select id="selectAnio1" class="form-control"></select></label>
  		<label><select id="selectAnio2" class="form-control"></select></label>
  	  <label><select id="selectMes1" class="form-control"></select></label>
  	  <button onclick="enviaFormGenerales('comparar','reportes/compararPagoCompania')" class="btn btn-primary">Comparar</button>
    </div>
  	<div>

  	</div>
  	
  	</div>

  <div class="divPanelHojas">
      <?php if(2==1){?>
  	  <div class=""> 
  <select id="selectConfigComparacion" class="form-control" style="display: none"><option>Mes</option><option>Año</option></select>
  	  	<label><select id="selectAnioConfig" class="form-control"></select></label>
  	  <label><select id="selectMesConfig" class="form-control"></select></label>
  	  <button onclick="enviaFormGenerales('verificar','reportes/verificarPC')" class="btn-primary">Verificar</button>
  	  <button onclick="enviaFormGenerales('actualizar','reportes/actualizarPC')" class="btn-primary">Actualizar</button>
  </div>
  <?php } ?>
  </div>
</div>
  <div id="divDatos" style="height: 500px;overflow: scroll;width: 100%">
  	<table id="tablePagoCompania" class="table" border="1">
  	</table>
  </div>
</div>
<div class="gifEspera ocultarObjeto" id="gifDeEspera"><img src="<?php echo(base_url().'assets\img\loading.gif')?>"></div>

<script type="text/javascript">
function cambiarValor(valor)
{
  if(valor=='Mes'){document.getElementById('selectMes1').classList.remove('ocultarObjeto')}
  else{document.getElementById('selectMes1').classList.add('ocultarObjeto')}

}
<?php
  $option=armaSelect($meses);
 echo('document.getElementById("selectMes1").innerHTML="<option value=\'0\'>Seleccionar mes</option>'.$option.'";');
  //echo('document.getElementById("selectMes2").innerHTML="'.$option.'";');

  $option=armaSelect($anios);
  echo('document.getElementById("selectAnio1").innerHTML="<option value=\'0\'>Seleccionar primer año</option>'.$option.'";');
  echo('document.getElementById("selectAnio2").innerHTML="<option value=\'0\'>Seleccionar segundo año año</option>'.$option.'";');
   
?>

function enviaFormGenerales(accion,controlador){
 var direccion=<?php echo('"'.base_url().'"'); ?>;
  direccion=direccion+controlador;
	var formulario=document.createElement('form'); formulario.setAttribute('method','post'); formulario.action=direccion;
    
  if(document.getElementById('selectTipoComparasion').value==''){alert('ESCOGER UN TIPO DE BUSQUEDA');return 0;}
   if(document.getElementById('selectAnio1').value=='0' || document.getElementById('selectAnio2').value=='0'){alert('ESCOGER AÑO');return 0;}
  switch(accion){
  	case 'verificar': 
  	if(document.getElementById("selectConfigComparacion").value=="Mes"){formulario.appendChild(crearObjetosParaForm(document.getElementById("selectMesConfig").value,'classEnviaForm','selectMesConfig'));    }
  	formulario.appendChild(crearObjetosParaForm(document.getElementById("selectAnioConfig").value,'classEnviaForm','selectAnioConfig'));   
  
  	break;
  	case 'comparar': 	
  	if(document.getElementById("selectTipoComparasion").value=="Mes"){
     if(document.getElementById('selectMes1').value==0){alert('ESCOGER MES');return 0;}
      formulario.appendChild(crearObjetosParaForm(document.getElementById("selectMes1").value,'classEnviaForm','selectMes1'));   }
  	formulario.appendChild(crearObjetosParaForm(document.getElementById("selectAnio1").value,'classEnviaForm','selectAnio1'));formulario.appendChild(crearObjetosParaForm(document.getElementById("selectAnio2").value,'classEnviaForm','selectAnio2'));
  	formulario.appendChild(crearObjetosParaForm(document.getElementById("selectTipoComparasion").value,'classEnviaForm','selectTipoComparasion'));break;
  	case 'actualizar': 
       	if(document.getElementById("selectConfigComparacion").value=="Mes"){formulario.appendChild(crearObjetosParaForm(document.getElementById("selectMesConfig").value,'classEnviaForm','selectMesConfig'));    }
  	formulario.appendChild(crearObjetosParaForm(document.getElementById("selectAnioConfig").value,'classEnviaForm','selectAnioConfig'));   
  	break;
  }
   document.body.appendChild(formulario);
  formulario.submit();
}
function crearObjetosParaForm(datos,clase,nombre){
	var input=document.createElement('input');
	input.setAttribute('type','hidden');
	input.setAttribute('value',datos);
	input.setAttribute('class',clase);
	input.setAttribute('name',nombre);
	document.body.appendChild(input);
	return input;
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
function muestraGif(){
	document.getElementById('gifDeEspera').classList.add('verObjeto');
}

  <?php
  if(isset($tablePagoCompania)){echo('document.getElementById(\'tablePagoCompania\').innerHTML="'.$tablePagoCompania.'";');} 
    
    if(isset($selectAnio1)){echo('document.getElementById(\'selectAnio1\').value="'.$selectAnio1.'";');} 
    if(isset($selectAnio2)){echo('document.getElementById(\'selectAnio2\').value="'.$selectAnio2.'";');} 
    if(isset($selectMes1)){echo('document.getElementById(\'selectMes1\').value="'.$selectMes1.'";');} 
    if(isset($selectTipoComparasion)){echo('document.getElementById(\'selectTipoComparasion\').value="'.$selectTipoComparasion.'";');}
  
  if(isset($mensaje)){echo($mensaje);}
  ?>

window.onbeforeunload =  muestraGif;
cambiarValor(document.getElementById('selectTipoComparasion').value)
</script>
<?php
function armaSelect($objeto){
	$option="";
   foreach($objeto as $key => $value)
      {$option=$option.'<option value=\''.$key.'\'>'.$value.'</option>';
}
return $option;

 }

?>
<style type="text/css">



	table> thead{color: white}
	table > thead>tr:first-child {background:#f59f48; color: black;font-weight:bold;}
	table > thead>tr {border: solid black 1px ;}
	table > tbody{height: 300px; overflow-y: scroll;}
	table > tbody>tr{color: black;  font-size:1em;font-weight:bold;}
	table > tbody>tr:nth-child(even) { background: #859de4 }
	table > tbody>tr:nth-child(odd) { background: #fff}
	table > tbody>tr:hover{border: solid black 2px }
	table  {border: solid black 2px ;}
	.gifEspera{position: absolute;left: 50%;top:70%;}
	.ocultarObjeto{display: none}
	.verObjeto{display: block;}

</style>