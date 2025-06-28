<?php $this->load->view('headers/header'); ?>
<?php $this->load->view('headers/menu');?>
<div style="display: flex; height: 800px; width: 100%">
	<div style=" width: 10%; border-right: solid">
		<button class="buttonMenu" onclick="manejoMenu('cuentasContables')">Cuentas contable</button>
		<button class="buttonMenu" onclick="manejoMenu('aperturaContable')">Asignacion de recursos</button>
		<button class="buttonMenu" onclick="manejoMenu('cierreContable')"><a href="<?=base_url()?>contabilidad/aperturaContable" title="Proveedores">Cierre contable</a></button>
	</div>
    <div style="width: 90%; margin-left:5%" id="divContenido">
<div class="subContenido ocultarObjeto" id="aperturaContable"><?php if(isset($aperturaCierre)){echo(imprimirAperturaCierre($aperturaCierre));} ?></div>
<div class="subContenido ocultarObjeto" id="cierreContable"><?php if(isset($aperturaContable)){echo(imprimirModalContable($aperturaContable));} ?></div>

<div class="subContenido verObjeto" id="cuentasContables"><input type="text" id="inputCC"><button onclick="guardarCC()">Guardar</button>
<?php if(isset($departamentos)){echo(imprimirDepartamentos($departamentos));} ?>
<?php if(isset($cuentasPorDepartamento)){echo(imprimirCuentasPorDepartamentos($cuentasPorDepartamento));} ?>
</div>
   </div>
</div>
<script type="text/javascript">

function manejoMenu(nombre)
{
 var contenido=document.getElementById("divContenido").childNodes;
 var cantidad=contenido.length
 for(var i=0;i<cantidad;i++){
  if(contenido[i].nodeName=="DIV"){
 	contenido[i].classList.add('ocultarObjeto');contenido[i].classList.remove('verObjeto')}
 	
  }
  document.getElementById(nombre).classList.add('verObjeto');
  document.getElementById(nombre).classList.remove('ocultarObjeto');
}
	function formatoMoneda(objeto){
	var valor=objeto.value;var entero="";var decimal="";
	if(valor[0]!='$'){valor='$'+valor;}
	var cantidad=valor.length;	var bandEntero=1;
	for(var i=1;i<cantidad;i++){
       if(valor[i]=='.'){bandEntero=0}
       	if(valor[i]!=",")
       	{
       	 if(bandEntero){entero=entero+valor[i];}
       	 else{decimal=decimal+valor[i];}
       }
	}
	var cantEntero=entero.length;var enteroInverso="";
	cantEntero=cantEntero-1;
	if(cantEntero>2){var bandComa=0;
		for(var i=cantEntero;i>=0;i--){			
           if(bandComa>2){enteroInverso=enteroInverso+","+entero[i];bandComa=1;}
           else{enteroInverso=enteroInverso+entero[i];bandComa=bandComa+1;}           
		}
		cantInverso=enteroInverso.length;cantInverso=cantInverso-1;	entero="";
		for(var i=cantInverso;i>=0;i--){entero=entero+enteroInverso[i];}
	}
    if(decimal.length==0){decimal='.00'}
    if(decimal.length==1){decimal='.00'}
    if(decimal.length==2){decimal=decimal+'0'}
     objeto.value="$"+entero+decimal;        
	}
	function abrirCerrarCC(){enviarFormGenerales('contabilidad/abrirCerrarCC');}
	function guardarCC(){
		if(document.getElementById('selectCC').value>0){
          if(document.getElementById('inputCC').value!=''){
            crearObjetosParaForm(document.getElementById('selectCC').value,'idPersonaDepartamento');
            crearObjetosParaForm(document.getElementById('inputCC').value,'cuentaContable');
            enviarFormGenerales('contabilidad/crearCuentaContable');
          }
          else{alert("Escribir nombre de cuenta contable");}
		}
		else{alert("Seleccion un departamento");}
	}
	function eliminarCC($idCuentaContable){
		crearObjetosParaForm($idCuentaContable,'idCuentaContable');
        enviarFormGenerales('contabilidad/eliminarCuentaContable');
	}
	function enviarFormGenerales(controlador){
  var direccion=<?php echo('"'.base_url().'";'); ?>;
  direccion=direccion+controlador;
  var formulario=document.createElement('form'); formulario.setAttribute('method','post'); formulario.action=direccion;formulario.setAttribute('name','miFormulario');formulario.setAttribute('id','miFormulario');
  objetosForm=document.getElementsByClassName('formEnviar');objetos="";cant=objetosForm.length;
  for(var i=0;i<cant;i++)
  {var objeto=document.createElement('input'); 
   objeto.setAttribute('value',objetosForm[i].value);
   objeto.setAttribute('name',objetosForm[i].name);
   objeto.setAttribute('type','hidden');
   formulario.appendChild(objeto); 
  }

  document.body.appendChild(formulario);
  formulario.submit();
}

	function crearObjetosParaForm(datos,nombre){var input=document.createElement('input');input.setAttribute('type','hidden');input.setAttribute('value',datos);input.setAttribute('class',"formEnviar");input.setAttribute('name',nombre);document.body.appendChild(input);}
	 function cerrarModal(){document.getElementById("miModalGenerico").classList.add("modalCierraGenerico");document.getElementById("miModalGenerico").classList.remove("modalAbreGenerico");document.getElementById("ModalcontenidoGenerico").style.display="none";}
 function abrirModal(){document.getElementById("miModalGenerico").classList.remove("modalCierraGenerico");document.getElementById("miModalGenerico").classList.add("modalAbreGenerico");document.getElementById("ModalcontenidoGenerico").style.display="block";}
function calcularMonto(idAperturaContable){
crearObjetosParaForm(idAperturaContable,'idAperturaContable');
crearObjetosParaForm(document.getElementById('textMT'+idAperturaContable).value,'montoContable');
enviarFormGenerales('contabilidad/asignarPresupuestoContable');

}
<?php if(isset($pestania)){ ?> manejoMenu(<?php echo('"'.$pestania.'"'); ?>); <?php } ?>
</script>
<style type="text/css">
	.modal-contenidoGenerico{background-color:none	;width:90%;height:100%;left: 20%;margin: 5% auto;position: relative;z-index: 1000 } 
    .modalCierraGenerico{background-color: rgba(0,0,0,.8);position:fixed;top:0;right:0;bottom:0px;left:0;opacity:0;transition: all 1s;display:none;relative;z-index: 1000}
    .modalAbreGenerico{background-color: rgba(0,0,0,.8);position:fixed;top:0;right:0;bottom:0px;left:0;transition: all 1s;width:100%;height:100%;display:block;relative;z-index: 1000}
    .botonCierre{background-color: red;color:white;}
    .contenidoModal{border: solid; color: black; background-color: white;width: 50%;height: 50%}
    .infoModal{position: relative; left: 0%;top: 30%}
    .labelModal{color: red;background-color: white; font-size: 18px;}
    .botonCancelar{border-left: 5px;left: 40%;position: relative;}
    .buttonMenu{width: 100%}
    .subContenido{display: none}
    .ocultarObjeto{display: none}
    .verObjeto{display: block;}
</style>
<?php 
function imprimirCuentasPorDepartamentos($informacion){
	$lista="";$lista.='<div style="display:flex">';
	foreach ($informacion as $key => $value) {
		$lista.='<ul>'.$key;
		foreach ($informacion[$key] as  $valueDepartamento) {
			$lista.='<li><button style="align:right" onclick=eliminarCC('.$valueDepartamento->idCuentaContable.')>-</button><label>'.$valueDepartamento->cuentaContable.'</label></li>';
		}
		$lista.='</ul>';
	}
	$lista.='</div>';
	return $lista;
	

}
function imprimirAperturaCierre($informacion){
	$datos="";
	foreach ($informacion as  $value) {
		$datos.='<div><label>'.$value->anioAC.'</label><br>';
		$datos.='<input type="input" id="textMT'.$value->idAperturaContable.'" value="'.$value->inicialAC.'" onchange="formatoMoneda(this)" style="text-align:right"><br>';
		$datos.='<div style="display:flex; margin: 20px; padding:2px">';
         foreach ($value->departamentos as  $valorDpto) {
         	$datos.='<div style="margin-left: 20px;text-align:right;border:solid black">';         	
         	$datos.='<label>'.$valorDpto->personaDepartamento.'</label><br>';
         	$datos.='<label style="color:black; background-color:white"">$'.$valorDpto->montoDAC.'</label>';
         	$datos.='</div>';
         }
         $datos.='<button onclick=calcularMonto('.$value->idAperturaContable.')>Guardar</button>';
         $datos.='</div>';
		$datos.='</div>';
	}
	return $datos;
}
function imprimirModalContable($informacion){
	  // $fp=fopen('resultadoJason.txt','a');fwrite($fp,print_r($informacion,true));fclose($fp);
	$modal='<div id="miModalGenerico" class="modalAbreGenerico" ><div id="ModalcontenidoGenerico" class="modal-contenidoGenerico"  >';
	$modal.='<div class="contenidoModal">';
	$modal.='<div><button onclick="cerrarModal()" class="botonCierre">X</button></div>';
	$modal.='<div class="infoModal"><div><label class="labelModal">¿Desea cerrar la cuenta contable '.$informacion['anioAc'].' y abrir '.$informacion['anioSiguiente'].'? </div>';
	$modal.='<div style="border:solid"><button class="btn btn-success" onclick="abrirCerrarCC()">Aceptar</button><button onclick="cerrarModal()" class="btn btn-danger botonCancelar" >Cancelar</button></div>';
	$modal.='</div></div></div></div>';
	return $modal;
}
function imprimirDepartamentos($informacion){
	$select='<select id="selectCC"><option value="-1">Escoger departamento</option>';
    foreach ($informacion as  $value) {$select.='<option value="'.$value->idPersonaDepartamento.'">'.$value->personaDepartamento.'</option>';}
	$select.='</select>';
	return $select;
}
?>
<?php
if(isset($mensaje)){echo('alert("'.$mensaje.'")');}
?>
