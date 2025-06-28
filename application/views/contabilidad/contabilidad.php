<style type="text/css">
     .conScroll :: -webkit-scrollbar{width: 35px;}
  div :: -webkit-scrollbar{width: 25px;}
</style>
<?php $this->load->view('headers/header'); ?>
<?php $this->load->view('headers/menu');?>
<?
  $permisosMenu=false;
  if($usuarioEmail=='DIRECTORGENERAL@AGENTECAPITAL.COM' || $usuarioEmail== 'SISTEMAS@ASESORESCAPITAL.COM' || $usuarioEmail=='CONTABILIDAD@AGENTECAPITAL.COM' || $usuarioEmail== 'AUXILIARCONTABLE@AGENTECAPITAL.COM' || $usuarioEmail=='GERENTEFINANCIERO@CAPITALSEGUROS.COM.MX'){$permisosMenu=true;}
?>
<div style="display: flex; height: 800px; width: 100%">
	<div style=" width: 10%; border-right: solid">
  <?if ($permisosMenu){?>
		<button class="buttonMenu" onclick="manejoMenu('cuentasContables',this)">Cuentas contable</button>
    <button class="buttonMenu" onclick="manejoMenu('AsignacioncuentasContables',this)">Asignacion de Cuenta Contable</button>
		<button class="buttonMenu" onclick="manejoMenu('aperturaContable',this)">Asignacion de recursos</button>		
  <?}?>
    <button class="buttonMenu" onclick="manejoMenu('divPromoBono',this)" data-tipocaptura="PROMOBONO">Captura de Promom Bono</button>
    <button class="buttonMenu" onclick="manejoMenu('divPromoBono',this)" data-tipocaptura="CCO">Captura de cco</button>
    <?if ($permisosMenu){?>
    <button class="buttonMenu" onclick="manejoMenu('divSincronizaCobranzaPendiente',this)">Cobranza Efectuada</button>
    <button class="buttonMenu" onclick="manejoMenu('divGraficaEr',this)">Grafica Er</button>
    <button class="buttonMenu" onclick="manejoMenu('divTarjetas',this)">Tarjetas</button>

		<button class="buttonMenu btn-danger" onclick="manejoMenu('cierreContable',this)"><a href="<?=base_url()?>contabilidad/aperturaContable" title="Proveedores">Cierre contable</a></button>
    <?}?>
	</div>
    <div style="width: 90%; margin-left:5%" id="divContenido">

<div class="subContenido ocultarObjeto" id="aperturaContable"><h1>Asignacion de Recursos</h1><hr><?php if(isset($aperturaCierre)){echo(imprimirAperturaCierre($aperturaCierre));} ?></div>
<div class="subContenido ocultarObjeto" id="cierreContable"><?php if(isset($aperturaContable)){echo(imprimirModalContable($aperturaContable));} ?></div>
<div class="subContenido ocultarObjeto" id="AsignacioncuentasContables">
  <div><h1>Asignacion de cuentas contables por persona</h1></div>
  <select class="form-control conScroll" id="selectEmpleadoAsginarCC" onchange="escogerEmpleadoCC(this)"><?= imprimirEmpleados($empleados)?> </select><button class="btn btn-success" onclick="guardarAsignacionCC('')">Guardar</button>
  <div><?php if(isset($cuentasPorDepartamento)){echo(imprimirCuentasPorDepartamentosParaAsinagcion($cuentasPorDepartamento));} ?></div>
</div>
<div class="subContenido verObjeto" id="cuentasContables">
  <h1>Cuentas Contables</h1><hr>
  <div class="row">
  <div class="col-sm-3 col-md-3"><input type="text" id="inputCC" class="form-control"><button class="btn btn-success btn-sm" onclick="guardarCC()">Guardar</button></div>
  <div class="col-sm-3 col-md-3"><?php if(isset($departamentos)){echo(imprimirDepartamentos($departamentos));} ?></div>
  <div class="col-sm-3 col-md-3"><button class="btn btn-success btn-sm" onclick="capturaPorcentaje()">Porcentaje de cargo</button></div>
  </div>
  <div class="row">
 <div class="col-sm-3 col-md-3 divConBorder">
  <label class="etiquetaSimple">Fianzas:</label><label id="labelFianzas" class="etiquetaSimple badge pull-right"></label></div>
 <div class="col-sm-3 col-md-3 divConBorder"> <label class="etiquetaSimple">Institucional:</label><label id="labelInstitucional" class="etiquetaSimple badge pull-right"></label></div>
  <div class="col-sm-3 col-md-3 divConBorder"><label class="etiquetaSimple">Coorporativo:</label><label id="labelCoorporativo" class="etiquetaSimple badge pull-right"></label></div>
  <div class="col-sm-3 col-md-3 divConBorder"><label class="etiquetaSimple">Asesores:</label><label id="labelGestion" class="etiquetaSimple badge pull-right"></label></div>
  </div>
<?php if(isset($cuentasPorDepartamento)){echo(imprimirCuentasPorDepartamentos($cuentasPorDepartamento));} ?>
  <div class="row">
    <h3>Configuracion de reportes</h3>
  </div>
  <div class="row">
    <div class="contieneTablaGrupoDiv">
      <table class="table">
          <thead name="theadReporte"><tr><th><button class="btn btn-primary" name="ocultarHijosGrupoBTN">-</button></th><th><input type="radio" onclick="habilitarOpcionesCabecera(this)" name="radioCabecera">GASTOS DE OPERACION</th><th><button onclick="guardarAsignacionGrupocuentaContable('',this)" data-valor='0' data-grupo='gastosOperacion' class="btn btn-warning">&#9196</button></th><th colspan="2"><input type="" id="gastosOperacionInput" placeholder="AGREGAR GRUPO" style="color: black"><button onclick="guardaGrupoCuentaContable('gastosOperacionInput','gastosOperacion')" class="btn btn-warning">&#9196</button></th></tr></thead>
      <tbody id="tbodyGastosOperacion" name="tBodyReportes"></tbody>
    </table>  </div></div>
    <div class="row">
      <div class="contieneTablaGrupoDiv">
      <table class="table">
          <thead name="theadReporte"><tr><th><button class="btn btn-primary" name="ocultarHijosGrupoBTN">-</button></th><th><input type="radio" onclick="habilitarOpcionesCabecera(this)" name="radioCabecera"> GASTOS VARIABLES</th><th><button onclick="guardarAsignacionGrupocuentaContable('',this)" data-valor='0' data-grupo='gastosVariables' class="btn btn-warning">&#9196</button></th><th colspan="2"><input type="" id="gastosVariablesInput" placeholder="AGREGAR GRUPO" style="color: black"><button onclick="guardaGrupoCuentaContable('gastosVariablesInput','gastosVariables')" class="btn btn-warning">&#9196</button></th></tr></thead>
      <tbody id="tbodyGastosVariables"  name="tBodyReportes"></tbody>
    </table></div>
  </div>
    <div class="row">
      <div class="contieneTablaGrupoDiv">
      <table class="table">
      <thead name="theadReporte"><tr><th><button class="btn btn-primary" name="ocultarHijosGrupoBTN">-</button></th><th><input type="radio" onclick="habilitarOpcionesCabecera(this)" name="radioCabecera"> GASTOS FINANCIEROS</th><th><button onclick="guardarAsignacionGrupocuentaContable('',this)" data-valor='0' data-grupo='gastosFinancieros' class="btn btn-warning">&#9196</button></th><th colspan="2"><input type="" id="gastosFinancierosInput" placeholder="AGREGAR GRUPO" style="color: black"><button onclick="guardaGrupoCuentaContable('gastosFinancierosInput','gastosFinancieros')" class="btn btn-warning">&#9196</button></th></tr></thead>
      <tbody id="tbodyGastosFinancieros"  name="tBodyReportes"></tbody>
    </table></div>
  </div>


    <div class="row">
      <div class="contieneTablaGrupoDiv">
      <table class="table">
      <thead name="theadReporte"><tr><th><button class="btn btn-primary" name="ocultarHijosGrupoBTN">-</button></th><th><input type="radio" onclick="habilitarOpcionesCabecera(this)" name="radioCabecera"> ACTIVOS</th><th><button onclick="guardarAsignacionGrupocuentaContable('',this)" data-valor='0' data-grupo='gastosActivos' class="btn btn-warning">&#9196</button></th><th colspan="2"><input type="" id="gastosActivosInput" placeholder="AGREGAR GRUPO" style="color: black"><button onclick="guardaGrupoCuentaContable('gastosActivosInput','gastosActivos')" class="btn btn-warning">&#9196</button></th></tr></thead>
      <tbody id="tbodyGastosActivos"  name="tBodyReportes"></tbody>
    </table></div>
  </div>


    <div class="row">
      <div class="contieneTablaGrupoDiv">
      <table class="table">
      <thead name="theadReporte"><tr><th><button class="btn btn-primary" name="ocultarHijosGrupoBTN">-</button></th><th><input type="radio" onclick="habilitarOpcionesCabecera(this)" name="radioCabecera"> IMPUESTOS</th><th><button onclick="guardarAsignacionGrupocuentaContable('',this)" data-valor='0' data-grupo='gastosImpuestos' class="btn btn-warning">&#9196</button></th><th colspan="2"><input type="" id="gastosImpuestosInput" placeholder="AGREGAR GRUPO" style="color: black"><button onclick="guardaGrupoCuentaContable('gastosImpuestosInput','gastosImpuestos')" class="btn btn-warning">&#9196</button></th></tr></thead>
      <tbody id="tbodyGastosImpuestos"  name="tBodyReportes"></tbody>
    </table></div>
  </div>

</div>
<div id="divPromoBono" class="ocultarObjeto">
  <h1 id="tituloCapturaH">Captura de Promo Bono</h1>
  <hr>
  <div class="row">
  <div class="col-sm-3 col-md-3"><label class="etiquetaSimple">Anio:<select id="selectAnioPB" class="form-control"><?=imprimirAnios($anios);?></select></label></div>
  <div class="col-sm-3 col-md-3"><label class="etiquetaSimple">Mes:<select id="selectMesPB" class="form-control"><?=imprimirMeses($meses)?></select></label></div>
  <div class="col-sm-3 col-md-3"><label class="etiquetaSimple">Tipo:<select id="selectTipoPB" class="form-control"><option>Promo</option><option>Bono</option><option>CCO</option></select></label></div>  
  <div><label class="etiquetaSimple">Canal:<select id="selectCanalPB" class="form-control">
    <option value="fianzas">Fianzas</option>
    <option value="institucional">Seguros</option>
    <option value="coorporativo">Coorporativo</option>
    <!--option value="gestion">Gestion</option-->
  </select></label></div>  
  </div> 
  <div class="row">
    <div class="col-sm-4 col-md-4"><label class="etiquetaSimple">Cantidad:<input type="text" id="inputCantidadPB" class="form-control"></select><button class="form-control btn-success" onclick="guardarPromoBono('')">Guardar</button></label></div>
    <div class="col-sm-2 col-md-2"><label class="etiquetaSimple">Anio:<select id="selectAnioBusquedaPB" class="form-control"><?=imprimirAnios($anios);?></select><button onclick="buscarPromoBono('')" class="form-control btn-success">Buscar</button></label></div>
  </div>
  <hr>
  <div class="row" id="divTablaPromobono">

  </div>
  </div>



<div id="divCCO" class="subContenido ocultarObjeto">
<h1>Captura CCO</h1>
<hr>
</div>

<div id="divTarjetas" class="ocultarObjeto">
  <h1>Tarjetas</h1><hr>
  <div class="row">
    <div class="col-sm-3"><label>Tarjeta:</label><select class="form-control" id="selectTarjetas"><?= imprimirTarjetas($tarjetasFormaDePago);?></select></div>
    <div class="col-sm-6"><label>Numero Tarjeta:</label><input type="text" id="tarjetaNueva" class="form-control"></div>
      <div class="col-sm-2"><br><button class="btn btn-success" onclick="guardarTarjeta('')">Guardar</button></div>

  </div>
<hr>
<div class="row">
  <div class="col-sm-3 col-md-3"><label>Tarjetas:</label><select class="form-control input-sm" id="selectTarjetasParaAsignar"><?= imprimirTarjetasParaAsignar($tarjetas);  ?> </select></div>
  <div class="col-sm-6 col-md-6"><label>Asignar:</label><select class="form-control input-sm" id="selectEmpleadoAsginarTarjeta" onchange="cambiarPersonaTarjeta('',this)"><?= imprimirEmpleados($empleados)?> </select></div>
  <div class="col-sm-3 col-md-3"><br><button class="btn btn-success" onclick="asignarTarjeta('')">Asignar tarjeta</button>
</div>
  </div>
  <br>
  <div class="row"><div class="col-sm-12 col-md-12"><label class="label label-info">ASIGNACION DE FORMAS DE PAGO</label><hr></div></div>
  <div class="row" style="width: 80%;height: 100px;overflow: scroll;">    
    <? foreach ($catalogoFormaPago as $value) {?>    
    <div class="col-sm-3 col-md-3"><label class="label label-warning"><input type="checkbox" style="position: relative;top:8%;left: -1%" value="<?=$value->idFormaPago?>" name="checkFormaPago"><?=$value->formaPago?>
  </label></div>

    <? }?>

  </div>
  <div class="row"><div class="col-sm-3 col-md-3"><button class="btn btn-warning" onclick="guardarFormaPago()">GUARDAR FORMA DE PAGO</button></div></div>
  <div class="row">
    <div class="col-md-12 col-sm-12">
     <table class="table">
       <thead>
         <tr>
           <th>Tarjeta</th>
           <th>Numero Tarjeta</th>
           <th>Persona</th>
           <th>Eliminar</th>
         </tr>
       </thead>
       <tbody id="tbodyTarjetasAsignadas">
         <?= imprimirTarjetasAsignadas($tarjetas);?>
       </tbody>
     </table>
    </div>
  </div>
</div>
<div id="divSincronizaCobranzaPendiente" class="ocultarObjeto">
  <h1>Cobranza Efectuada</h1><hr>
  <div class="row">
    <div class="col-sm-3 col-md-3"><label class="etiquetaSimple">Anio:<select id="selectAnioCobranzaPendiente" class="form-control"><?=imprimirAnios($anios);?></select></label></div>
    <div class="col-sm-3 col-md-3"><label class="etiquetaSimple">Mes:<select id="selectMesCobranzaPendiente" class="form-control"><?=imprimirMeses($meses)?></select></label></div>
    <div class="col-sm-2 col-md-2"><br><button class="btn btn-success" onclick="buscarCobranzaEfectuada('')">Buscar</button></div>
    <div class="col-sm-2 col-md-2"><br><button class="btn btn-success" onclick="exportarExcel('tablaCobranzaEfectuada')">Exportar</button></div>
    <div class="col-sm-2 col-md-2"><br><button class="btn btn-warning" onclick="sincronizarCobranzaEfectuada('')">Sincronizar</button></div>
  </div>
  <hr>
  <div id="divTablaCobranzaPendiente" style="width: 95%; height: 400px;overflow: scroll;">

  </div>
   </div>
 <!--Creamos la grafica para Er-->
<div class="ocultarObjeto" id="divGraficaEr" style="overflow: scroll;">
  <h1>Grafica ER</h1><hr>
  <div class = "graficaEr">
  
  </div>
  <div class = "graficaEr-texto">
    <div  class= "grafica-dividir">
    <label for="graficaERmes">Mes</label>
    <select name="graficaERmes" id="graficaERmes">
    <option  selected disabled value="">..Selecione el Mes</option>
       <option value="1">ENERO</option>
       <option value="2">FEBRERO</option>
       <option value="3">MARZO</option>
       <option value="4">ABRIL</option>
       <option value="5">MAYO</option>
       <option value="6">JUNIO</option>
       <option value="7">JULIO</option>
       <option value="8">AGOSTO</option>
       <option value="9">SEPTIEMBRE</option>
       <option value="10">OCTUBRE</option>
       <option value="11">NOVIEMBRE</option>
       <option value="12">DICIEMBRE</option>
    </select>
    </div>
    <div class= "grafica-dividir">
     <label for="graficaERano">Ano</label><input type="number" id="graficaERano" class="form-control">
     </div>
  </div>
  <div class= "grafica-boton">
      <a class="grafica-boton-buscar">Buscar</a>
  </div>
  <div class= "grafica-respuesta">
    <div class= "tablaseguros">
      <p class="pseguros" name="paseguros" id="paseguros"></p>
      <table class="propiedades"  id="tabla-seguros" name="tabla-seguros">
      <tbody  id="tabla-seg" name="tabla-seg">
      </tbody>
      </table>
    </div>    
    <div id= "graficaseguros">
    </div>
    <!--finaza-->
    <div class= "tablaseguros">
      <p class="pseguros" name="pfianzas" id="pfianzas"></p>
      <table class="propiedades"  id="tabla-fianzas" name="tabla-fianzas">
      <tbody  id="tabla-fian" name="tabla-fian">
      </tbody>
      </table>
    </div>    
    <div id= "graficaFianzas">
    </div>
    <!--Termina Fianzas-->
    <!--cORPORATIVA-->
    <div class= "tablaseguros">
       <p class="pseguros" name="pCorporativa" id="pCorporativa"></p>
       <table class="propiedades"  id="tabla-Corporativa" name="tabla-Corporativa">
       <tbody  id="tabla-Cor" name="tabla-Cor">
       </tbody>
       </table>
    </div>    
    <div id= "graficaCorporativa">
    </div>
    <!--Termina cOORPORATIVA-->
   </div>
</div>
<!--Termina  Er-->
 </div>
 
 </div>
<div id="divModalGenerico" class="modalCierra">
	<div class="modal-btnCerrar"><button onclick="cerrarModalGenerico('divModalGenerico')" style="color: white;background-color:red; border:double;">X</button></div>
    <div id="divModalContenidoGenerico" class="modal-contenido"  >
    
</div>
</div>

<div id="modalParaRecursos" class="modalCierra">
  <div class="modal-btnCerrar"><button onclick="cerrarModalGenerico('modalParaRecursos')" style="color: white;background-color:red; border:double;">X</button></div>
    <div id="divModalMesesRecursos" class="modal-contenido">
    
</div>
</div>

<div class="ocultarObjeto" id="divCapturaPorcentaje" style="overflow: scroll;">
  <div style="width: 100%;height: 100%;display: flex;flex-direction: column;">
  <div style="flex: 1;text-align: 1;text-align: end"><button class="btn btn-warning" onclick ="verOcultarPorcentaje()">X</button></div>
  <div style="display: flex;flex: 5">
  <label>Porcentaje de Fianzas:<input type="text" name="fianzasPorcentaje" id="fianzasPorcentaje" class="form-control"></label>
  <label>Porcentaje de Institucional<input type="text" name="institucionalPorcentaje" id="institucionalPorcentaje" class="form-control"></label>
  <label>Porcentaje Coorporativo<input type="text" name="coorporativoPorcentaje" id="coorporativoPorcentaje" class="form-control"></label>
  <label>Porcentaje Asesores<input type="text" name="asesoresPorcentaje" id="asesoresPorcentaje" class="form-control"></label>
  <label style="display: none;">Porcentaje de Gestion<input type="text" name="gestionPorcentaje" id="gestionPorcentaje" class="form-control"></label>
</div style="flex: 1;text-align: 1">
  <div><button class="btn btn-success" onclick="guardarPorcentaje('')">Guardar</button></div>
</div>
</div>
<form id="formArchivoPromobono">
<input type="file" name="Archivo" id="inputFile" onchange="agregarArchivo(this)" style="display: none">
<input type="hidden" name="idPromoBono" id="idPromoBonoArchivo">
</form>
<table id="tablaExportar"></table>

<script type="text/javascript">
var tipoCaptura=['Promo','Bono','CCO','Otros'];
var idPromoBono="";
var idCuentaContableGruposGlobal=0;
var presupuestoGrupo=[];
function escogerEmpleadoCC(objeto)
{  
  let opciones=selectEmpleadoAsginarCC.options[selectEmpleadoAsginarCC.selectedIndex].getAttribute('data-permisoscc').split(',');
  let cantOpciones=opciones.length;
  let check=document.getElementsByClassName('checkParaSignacion');
  let cantCheck=check.length;
  for(let i=0;i<cantCheck;i++){check[i].checked=false;}
  for(let i=0;i<cantCheck;i++){for(let j=0;j<cantOpciones;j++){if(opciones[j]==check[i].value){check[i].checked=true;j=cantOpciones}}      
    }

}
function desAsignarTarjeta(datos,idTarjetas=null)
{
  if(datos=='')
  { let parametros='';
    parametros=parametros+'?idTarjetas='+idTarjetas;
    parametros=parametros+'&idPersona=0';
    peticionAJAX('contabilidad/asignarTarjeta/',parametros,'asignarTarjeta');
  }
}
function asignarTarjeta(datos)
{
  if(datos=='')
  {
   let parametros='';
    parametros=parametros+'?idTarjetas='+document.getElementById('selectTarjetasParaAsignar').value;
    parametros=parametros+'&idPersona='+document.getElementById('selectEmpleadoAsginarTarjeta').value;
    peticionAJAX('contabilidad/asignarTarjeta/',parametros,'asignarTarjeta');
 
  }
  else
  {
    let cant=datos.tarjetas.length
    let option='';
    let row='';
    for(let i=0;i<cant;i++)
    {   
      if(datos.tarjetas[i].idPersona=='0'){option=option+'<option value="'+datos.tarjetas[i].idTarjetas+'">'+datos.tarjetas[i].numeroTarjeta+'('+datos.tarjetas[i].formaPago+')'+'</option>';}
      else{
        let nombre=datos.tarjetas[i].apellidoPaterno+' '+datos.tarjetas[i].apellidoMaterno+' '+datos.tarjetas[i].nombres;
        row=row+'<tr><td>'+datos.tarjetas[i].formaPago+'</td><td>'+datos.tarjetas[i].numeroTarjeta+'</td><td>'+nombre+'</td><td><button class="btn btn-warning" onclick="desAsignarTarjeta(\'\','+datos.tarjetas[i].idTarjetas+')">X</button>';
      }
    }    
    document.getElementById('selectTarjetasParaAsignar').innerHTML=option;
    document.getElementById('tbodyTarjetasAsignadas').innerHTML=row;
   alert(datos.mensaje);

  }
}
function guardarTarjeta(datos)
{
  if(datos=='')
  {
    let parametros='';
    parametros=parametros+'?idFormaPago='+document.getElementById('selectTarjetas').value;
    parametros=parametros+'&numeroTarjeta='+document.getElementById('tarjetaNueva').value;
    peticionAJAX('contabilidad/guardarTarjeta/',parametros,'guardarTarjeta');
  }
  else
  {   
    let cant=datos.tarjetas.length
    let option='';
    for(let i=0;i<cant;i++)
    {   
      if(datos.tarjetas[i].idPersona=='0'){option=option+'<option value="'+datos.tarjetas[i].idTarjetas+'">'+datos.tarjetas[i].numeroTarjeta+'('+datos.tarjetas[i].formaPago+')</option>';}
    }    
    document.getElementById('selectTarjetasParaAsignar').innerHTML=option;
   alert(datos.mensaje);
  }
}
  function mostrarFile(id){document.getElementById('idPromoBonoArchivo').value=id;$("#inputFile").trigger("click");}
  function agregarArchivo(objeto)
  {
    if(!objeto.value.length){idPromoBono='';}
    else
    {     enviarArchivoAJAX('formArchivoPromobono','subirArchivoPromoBono');
    }
  }

function guardarPorcentaje(datos)
{   
  if(datos=="")
  {

    let cadena='';
   let parametros='fianzasPorcentaje='+document.getElementById("fianzasPorcentaje").value;

   parametros=parametros+'&institucionalPorcentaje='+document.getElementById("institucionalPorcentaje").value;
   parametros=parametros+'&coorporativoPorcentaje='+document.getElementById("coorporativoPorcentaje").value;
   parametros=parametros+'&gestionPorcentaje='+document.getElementById("gestionPorcentaje").value;
   parametros=parametros+'&asesoresPorcentaje='+document.getElementById("asesoresPorcentaje").value;

      
   let checkbox=document.getElementsByClassName('checkPorcentaje');
   let cant=checkbox.length;
   for(let i=0;i<cant;i++){if(checkbox[i].checked){cadena=cadena+checkbox[i].value+',';}}
   parametros=parametros+'&cuentas='+cadena;
   //peticionAJAX('contabilidad/guardarPorcentaje/?',parametros,'capturaPorcentaje');

            crearObjetosParaForm(document.getElementById("fianzasPorcentaje").value,'fianzasPorcentaje');
            crearObjetosParaForm(document.getElementById('institucionalPorcentaje').value,'institucionalPorcentaje');
            crearObjetosParaForm(document.getElementById('coorporativoPorcentaje').value,'coorporativoPorcentaje');
            crearObjetosParaForm(document.getElementById('gestionPorcentaje').value,'gestionPorcentaje');
            crearObjetosParaForm(document.getElementById('asesoresPorcentaje').value,'asesoresPorcentaje');
            crearObjetosParaForm(cadena,'cuentas');
            
            enviarFormGenerales('contabilidad/guardarPorcentaje');


  }
  else{

  alert(datos.mensaje);
   verOcultarPorcentaje()
  }

}

function capturaPorcentaje()
{
  document.getElementById("fianzasPorcentaje").value=0;
  document.getElementById("institucionalPorcentaje").value=0;
  document.getElementById("coorporativoPorcentaje").value=0;
  document.getElementById("gestionPorcentaje").value=0;
  document.getElementById("asesoresPorcentaje").value=0;
 verOcultarPorcentaje();
}
function verOcultarPorcentaje(){
  document.getElementById('divCapturaPorcentaje').classList.toggle('ocultarObjeto');
  document.getElementById('divCapturaPorcentaje').classList.toggle('contMenuPorcentaje');
}
function manejoMenu(nombre,objeto)
{
 
 var contenido=document.getElementById("divContenido").childNodes;
 var cantidad=contenido.length;
 let menu=Array.from(document.getElementsByClassName('buttonMenu'));

 for(var i=0;i<cantidad;i++){
  if(contenido[i].nodeName=="DIV"){contenido[i].classList.add('ocultarObjeto');contenido[i].classList.remove('verObjeto')}}
  document.getElementById(nombre).classList.add('verObjeto');
  document.getElementById(nombre).classList.remove('ocultarObjeto');
menu.forEach(m=>{m.classList.remove('buttonSeleccionado');})
objeto.classList.add('buttonSeleccionado');
if(objeto.dataset.tipocaptura){
  let cadOption="";
  let title="Cpatura CCO";
  if(objeto.dataset.tipocaptura=='CCO'){tipoCaptura.forEach(t=>{if(t=='CCO'){cadOption+=`<option>${t}</option>`}})}
  else{tipoCaptura.forEach(t=>{if(t!='CCO'){cadOption+=`<option>${t}</option>`}});title="Captura de Promo Bono"}  
    document.getElementById('selectTipoPB').innerHTML=cadOption;
    document.getElementById('tituloCapturaH').innerHTML=title;
    buscarPromoBono('');
  }
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
function calcularMonto(mensaje,idAperturaContable){

if(mensaje==1){
      $mensaje='<div style="align:right; padding:15%;border:solid; color:black; background-color:#3b64d9"><div><h1 style="color:black">El cambio del total del monto modificara los montos por departamento</h1></div><div><h1 style="color:black">¿Desea continuar?</h1></div><div><button class="btn btn-success btn-lg" onclick="calcularMonto(0,'+idAperturaContable+')">Continuar</button><button onclick="cerrarModalGenerico(\'divModalGenerico\')" class="btn btn-danger btn-lg">Cancelar</button></div>';
      document.getElementById('divModalContenidoGenerico').innerHTML=$mensaje;
      document.getElementById('divModalGenerico').classList.toggle('modalCierra');
      document.getElementById('divModalGenerico').classList.toggle('modalAbre');
    }
    else{
      crearObjetosParaForm(idAperturaContable,'idAperturaContable');
      crearObjetosParaForm(document.getElementById('textMT'+idAperturaContable).value,'montoContable');
       enviarFormGenerales('contabilidad/asignarPresupuestoContable');
    }



}
<?php if(isset($pestania)){ ?> manejoMenu(<?php echo('"'.$pestania.'"'); ?>); <?php } ?>
</script>
<script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>
<style>
.modal-btnCerrar{background-color:white;width:50%;padding: 0% 0%;margin: 0% auto;position: relative;z-index: 1000; }
.modal-contenido{background-color:white;width:50%;height:500px;padding: 0% 0%;margin: 0% auto;position: relative;z-index: 1000; overflow: scroll;  }
.modalCierra{background-color: rgba(0,0,0,.8);position:fixed;top:0;right:0;bottom:0px;left:0;opacity:0;transition: all 1s;display:none;z-index: 1000;}
.modalAbre{background-color: rgba(0,0,0,.8);position:fixed;top:0;right:0;bottom:0px;left:-100;transition: all 1s;width:100%;height:100%;display:block;relative;z-index: 1000}
.labelEditar{display: block; }
.labelEditar input{width: 100%; border: solid 1px black; color: black; background-color: #d7d1e1}
.divEspera{width: 80px;height: 80px;margin-top: -23px;margin-left: -163px;left: 50%;top: 50%;position: absolute;}
.verObjeto{display: block;}
.ocultarObjeto{display: none}
.formProspecto > label{color: black; text-decoration: underline;}
.contieneTablaGrupoDiv{height: auto;max-height: 350px;width: 90%;overflow: scroll;}
.contieneTablaGrupoDiv table{height: auto;max-height: 300px;width: 100%}
.contieneTablaGrupoDiv table thead{position: sticky;top:0px;}

</style>

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
    .buttonMenu:hover{background-color: #87e89d}
    .buttonSeleccionado{background-color: #87e89d}
    .subContenido{display: none}
    .ocultarObjeto{display: none}
    .verObjeto{display: block;}
    .graficaEr{display:flex;
     
    }  
    .graficaEr-texto
    {
      display:grid;
      grid-template-columns:repeat(2,1fr);
      justify-content:flex-end;
    }
    .graficaEr-texto label 
    {
      display:block;
      text-align:center;
    }
    .graficaEr-texto select
    {
      display:block; 
      align-items:center;
      margin:0 auto;
      padding:5px;
    }
    .graficaEr-texto input
    {
      display:block; 
      align-items:center;
      margin:0 auto;
      padding:5px;
      width:10rem;
      height:3rem;
    }
    .grafica-boton
    {
      margin:2rem auto;
      display : flex;
      justify-content:center;
    }
    .grafica-boton a
    {
       background-color:rgb(255, 87, 51 );
       padding:5px 10px;
       color:white;
    }
    .grafica-boton a:hover{
      cursor:pointer;
    }
    .grafica-respuesta
    {
      display:grid;
      grid-template-columns:repeat(2,1fr);
      align-items:center; 
      gap:1rem;
    }
    .propiedades {
      width: 100%;
    margin-top: 1rem;
    border-collapse: collapse;
    }
    .propiedades tbody td {
    padding: 0.5rem;
    border: black 2px solid;
    color : black;
}
.propiedades tbody tr:nth-child(5) td
{
  padding-top:2rem;
}
.propiedades tbody tr:nth-child(5) td:nth-child(1)  {
  border:none;
}
.propiedades tbody tr:nth-child(5) td:nth-child(2)  {
  border:none;
}
.propiedades tbody tr:nth-child(5) td:nth-child(3)  {
  border:none;
}
.pseguros{
  text-align:center;
  background-color:rgb(26, 160, 28);
  color:white;
}
.pseguros p{
  padding:5px 10px;
}
.grafica-dividir
{
  margin-right:10px;
  margin-left:auto;
}
.grafica-dividir:nth-child(2)
{
  margin-right:auto;
  margin-left:10px;
}
</style>
<link rel="stylesheet" href="<?php echo base_url();?>css/sweetalert2.min.css">  
<script src="https://code.jquery.com/jquery-1.12.4.js"></script>
<script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@9"></script>
<script type="text/javascript">

const grafica = document.querySelector(".grafica-boton-buscar");
grafica.addEventListener('click',function(e){
  //console.log('LLego');
  e.preventDefault();
  let graficaano = document.querySelector("#graficaERano").value;
  let graficames = document.querySelector("#graficaERmes").value;
  let mes = $("#graficaERmes option:selected").text();
  //console.log(graficaano);
  console.log(mes);
  //var_dump(graficames);
 
  if(graficames == '')
  {
    //document.getElementById('graficames').focus();
    Swal.fire(
         'Mes!',
         'El mes no puede estar vacio',
         'warning'
      );
    return;
  }
  if(graficaano == '')
  {
    //document.getElementById('graficaano').focus();
    Swal.fire(
         'Año!',
         'El Año no puede estar vacio',
         'warning'
      );
    return;
  }
  //Buscamos Los resulatado a grfaicar
  //var ultimo = document.getElementById('paseguros');
      //$("paseguros").empty();
    //console.log('HOLA');
    //ultimo.parentNode.removeChild(ultimo);    
  xhr = new XMLHttpRequest();
  var datos =new FormData();
  datos.append('mes',graficames);
  datos.append('ano',graficaano);
  xhr.open('POST',"<?php echo base_url();?>contabilidad/devuelveEstadoEr",true);
  xhr.onload=function()
  {
    if(this.status === 200)
    {
      var respuesta = JSON.parse(xhr.responseText);
       console.log(respuesta);
       var usuario = respuesta['usuario'];
       if((usuario =='27') || (usuario =='29') )
       {
         document.getElementById('paseguros').innerHTML ='SEGUROS '+mes;
         var tabla= document.getElementById("tabla-seg");
         var rowCount = tabla.rows.length; 
         //console.log(rowCount);
         for (var x=rowCount-1; x>=0; x--) { 
          tabla.deleteRow(x); 
          } 
        //for(let i = 0; i < respuesta.length; i++) {
       //  number_format($cantidad, 2,',','.');
          var fila="<tr><td>Costo de Venta</td><td>$ "+(respuesta['costo']).toFixed(3).replace(/\d(?=(\d{3})+\.)/g, '$&,')+"</td><td>"+ ((respuesta['costo']/respuesta['total'])*(100)).toFixed(0) +"%</td></tr>";
          var btn = document.createElement("TR");
          btn.innerHTML=fila;
          document.getElementById("tabla-seg").appendChild(btn);
          fila="<tr><td>Gasto</td><td>$ "+(respuesta['gasto']).toFixed(3).replace(/\d(?=(\d{3})+\.)/g, '$&,')+"</td><td>"+((respuesta['gasto']/respuesta['total'])*(100)).toFixed(0)+"%</td></tr>";
          var btn = document.createElement("TR");
          btn.innerHTML=fila;
          document.getElementById("tabla-seg").appendChild(btn);
          fila="<tr><td>Nomina</td><td>$ "+(respuesta['nomina']).toFixed(3).replace(/\d(?=(\d{3})+\.)/g, '$&,')+"</td><td>"+((respuesta['nomina']/respuesta['total'])*(100)).toFixed(0)+"%</td></tr>";
           btn = document.createElement("TR");
          btn.innerHTML=fila;
          document.getElementById("tabla-seg").appendChild(btn);
          fila="<tr><td>Total Ingreso</td><td>$ "+(respuesta['total']).toFixed(3).replace(/\d(?=(\d{3})+\.)/g, '$&,')+"</td><td>  </td></tr>";
           btn = document.createElement("TR");
          btn.innerHTML=fila;
          document.getElementById("tabla-seg").appendChild(btn);   
          var neg = (respuesta['total']-respuesta['costo']-respuesta['gasto']-respuesta['nomina']);
          var costodeventa = (respuesta['costo']);
          var gastos = (respuesta['gasto']);
          var nomina = (respuesta['nomina']);
          if(neg < 0)   
          {
            fila="<tr><td>Utilidad/Perdida</td><td><font color='red'>$ "+(respuesta['total']-respuesta['costo']-respuesta['gasto']-respuesta['nomina']).toFixed(3).replace(/\d(?=(\d{3})+\.)/g, '$&,')+"</td><td>"+((respuesta['total']-respuesta['costo']-respuesta['gasto']-respuesta['nomina'])/(respuesta['total'])*(100)).toFixed(0)+"%</td></tr>";
          }
         else
          {
           fila="<tr><td>Utilidad/Perdida</td><td><font color='blue'>$ "+(respuesta['total']-respuesta['costo']-respuesta['gasto']-respuesta['nomina']).toFixed(3).replace(/\d(?=(\d{3})+\.)/g, '$&,')+"</td><td>"+((respuesta['total']-respuesta['costo']-respuesta['gasto']-respuesta['nomina'])/(respuesta['total'])*(100)).toFixed(0)+"%</td></tr>";
          }
         btn = document.createElement("TR");
         btn.innerHTML=fila;
         document.getElementById("tabla-seg").appendChild(btn);      
         //funcion para graficar
          google.charts.load("visualization", "1", {'packages':['corechart']});
         google.charts.setOnLoadCallback(drawChart);
         function drawChart() {
          var data = google.visualization.arrayToDataTable([
          ['COSTOS', 'PESOS'],
          ['Costo de venta',  costodeventa],
          ['Gastos',      gastos],
          ['Nomina',  nomina]          
          ]);
          var options = {
          title: 'Equivalente de Gastos',
          backgroundColor: {fill: '#637164',
                           fillOpacity: 0.8},
          };
          var chart = new google.visualization.PieChart(document.getElementById('graficaseguros'));
          chart.draw(data, options);
        }
      }  
     // FIANZAS
    if((usuario =='27') || (usuario =='29')) 
    {
     document.getElementById('pfianzas').innerHTML ='FIANZA '+mes;
     var tabla= document.getElementById("tabla-fian");
    //Borramos la tabla si existe    
      var rowCount = tabla.rows.length; 
       console.log(rowCount);
       for (var x=rowCount-1; x>=0; x--) { 
        tabla.deleteRow(x); 
         } 
       var fila="<tr><td>Costo de Venta</td><td>$ "+(respuesta['costofianza']).toFixed(3).replace(/\d(?=(\d{3})+\.)/g, '$&,')+"</td><td>"+ ((respuesta['costofianza']/respuesta['totalfianza'])*(100)).toFixed(0) +"%</td></tr>";
       var btn = document.createElement("TR");
       btn.innerHTML=fila;
       document.getElementById("tabla-fian").appendChild(btn); 
       var fila="<tr><td>Gasto</td><td>$ "+(respuesta['gastofianza']).toFixed(3).replace(/\d(?=(\d{3})+\.)/g, '$&,')+"</td><td>"+ ((respuesta['gastofianza']/respuesta['totalfianza'])*(100)).toFixed(0) +"%</td></tr>";
       var btn = document.createElement("TR");
       btn.innerHTML=fila;
       document.getElementById("tabla-fian").appendChild(btn); 
       var fila="<tr><td>Nomina</td><td>$ "+(respuesta['nominafianza']).toFixed(3).replace(/\d(?=(\d{3})+\.)/g, '$&,')+"</td><td>"+ ((respuesta['nominafianza']/respuesta['totalfianza'])*(100)).toFixed(0) +"%</td></tr>";
       var btn = document.createElement("TR");
       btn.innerHTML=fila;
       document.getElementById("tabla-fian").appendChild(btn); 
       var fila="<tr><td>Total Ingreso</td><td>$ "+(respuesta['totalfianza']).toFixed(3).replace(/\d(?=(\d{3})+\.)/g, '$&,')+"</td><td>  </td></tr>";
       var btn = document.createElement("TR");
       btn.innerHTML=fila;
       document.getElementById("tabla-fian").appendChild(btn); 
       var negfianza = (respuesta['totalfianza']-respuesta['costofianza']-respuesta['gastofianza']-respuesta['nominafianza']);
        var costodefianza = (respuesta['costofianza']);
        var gastofianza = (respuesta['gastofianza']);
        var nominafianza = (respuesta['nominafianza']);
        if(negfianza < 0)   
        {
            fila="<tr><td>Utilidad/Perdida</td><td><font color='red'>$ "+(respuesta['totalfianza']-respuesta['costofianza']-respuesta['gastofianza']-respuesta['nominafianza']).toFixed(3).replace(/\d(?=(\d{3})+\.)/g, '$&,')+"</td><td>"+((respuesta['total']-respuesta['costo']-respuesta['gasto']-respuesta['nomina'])/(respuesta['total'])*(100)).toFixed(0)+"%</td></tr>";
        }
        else
        {
          fila="<tr><td>Utilidad/Perdida</td><td><font color='blue'>$ "+(respuesta['tottotalfianzaal']-respuesta['costofianza']-respuesta['gastofianza']-respuesta['nominafianza']).toFixed(3).replace(/\d(?=(\d{3})+\.)/g, '$&,')+"</td><td>"+((respuesta['total']-respuesta['costo']-respuesta['gasto']-respuesta['nomina'])/(respuesta['total'])*(100)).toFixed(0)+"%</td></tr>";
        }
        btn = document.createElement("TR");
        btn.innerHTML=fila;
        document.getElementById("tabla-fian").appendChild(btn);  
      google.charts.load('current', {'packages':['corechart']});
      google.charts.setOnLoadCallback(drawChart2);
      function drawChart2() {

        var data = google.visualization.arrayToDataTable([
          ['COSTOS', 'PESOS'],
          ['Costo de venta',  costodefianza],
          ['Gastos',      gastofianza],
          ['Nomina',  nominafianza]          
          ]);

        var options = {
          title: 'Equivalente de Gastos',
          backgroundColor: {fill: '#637164',
                           fillOpacity: 0.8}

          };

          var chart = new google.visualization.PieChart(document.getElementById('graficaFianzas'));
         chart.draw(data, options);
         }
      }  
      // corporativa
      if((usuario =='29')||(usuario =='30'))
     { 
      document.getElementById('pCorporativa').innerHTML ='COORPORATIVA '+mes;
      var tabla= document.getElementById("tabla-Cor");
    //Borramos la tabla si existe    
      var rowCount = tabla.rows.length; 
       console.log(rowCount);
       for (var x=rowCount-1; x>=0; x--) { 
        tabla.deleteRow(x); 
         } 
       var fila="<tr><td>Costo de Venta</td><td>$ "+(respuesta['costoCor']).toFixed(3).replace(/\d(?=(\d{3})+\.)/g, '$&,')+"</td><td>"+ ((respuesta['costoCor']/respuesta['totalCor'])*(100)).toFixed(0) +"%</td></tr>";
       var btn = document.createElement("TR");
       btn.innerHTML=fila;
       document.getElementById("tabla-Cor").appendChild(btn); 
       var fila="<tr><td>Gasto</td><td>$ "+(respuesta['gastoCor']).toFixed(3).replace(/\d(?=(\d{3})+\.)/g, '$&,')+"</td><td>"+ ((respuesta['gastoCor']/respuesta['totalCor'])*(100)).toFixed(0) +"%</td></tr>";
       var btn = document.createElement("TR");
       btn.innerHTML=fila;
       document.getElementById("tabla-Cor").appendChild(btn); 
       var fila="<tr><td>Nomina</td><td>$ "+(respuesta['nominaCor']).toFixed(3).replace(/\d(?=(\d{3})+\.)/g, '$&,')+"</td><td>"+ ((respuesta['nominaCor']/respuesta['totalCor'])*(100)).toFixed(0) +"%</td></tr>";
       var btn = document.createElement("TR");
       btn.innerHTML=fila;
       document.getElementById("tabla-Cor").appendChild(btn);   
       var fila="<tr><td>Total Ingresos</td><td>$ "+(respuesta['totalCor']).toFixed(3).replace(/\d(?=(\d{3})+\.)/g, '$&,')+"</td><td>  </td></tr>";
       var btn = document.createElement("TR");
       btn.innerHTML=fila;
       document.getElementById("tabla-Cor").appendChild(btn); 
       var negCor = (respuesta['totalCor']-respuesta['costoCor']-respuesta['gastoCor']-respuesta['nominaCor']);
       var costoCor = (respuesta['costoCor']);
       var gastoCor = (respuesta['gastoCor']);
       var nominaCor = (respuesta['nominaCor']);
        if(negCor < 0)   
        {
            fila="<tr><td>Utilidad/Perdida</td><td><font color='red'>$ "+(respuesta['totalCor']-respuesta['costoCor']-respuesta['gastoCor']-respuesta['nominaCor']).toFixed(3).replace(/\d(?=(\d{3})+\.)/g, '$&,')+"</td><td>"+((respuesta['total']-respuesta['costo']-respuesta['gasto']-respuesta['nomina'])/(respuesta['total'])*(100)).toFixed(0)+"%</td></tr>";
        }
        else
        {
          fila="<tr><td>Utilidad/Perdida</td><td><font color='blue'>$ "+(respuesta['totalCor']-respuesta['costoCor']-respuesta['gastoCor']-respuesta['nominaCor']).toFixed(3).replace(/\d(?=(\d{3})+\.)/g, '$&,')+"</td><td>"+((respuesta['total']-respuesta['costo']-respuesta['gasto']-respuesta['nomina'])/(respuesta['total'])*(100)).toFixed(0)+"%</td></tr>";
        }
        btn = document.createElement("TR");
        btn.innerHTML=fila;
        document.getElementById("tabla-Cor").appendChild(btn); 
        google.charts.load('current', {'packages':['corechart']});
      google.charts.setOnLoadCallback(drawChart3);
      function drawChart3() {

        var data = google.visualization.arrayToDataTable([
          ['COSTOS', 'PESOS'],
          ['Costo de venta',  costoCor],
          ['Gastos',      gastoCor],
          ['Nomina',  nominaCor]          
          ]);

        var options = {
          title: 'Equivalente de Gastos',
          backgroundColor: {fill: '#637164',
                           fillOpacity: 0.8}
           
          };

          var chart = new google.visualization.PieChart(document.getElementById('graficaCorporativa'));
         chart.draw(data, options);
         } 
      } 
    }    
  }
  xhr.send(datos);
  
});



//termina funcion
function guardarMesesDepartamento(datos){
	if(datos==''){
      var valores=document.getElementsByClassName('data-idACMM');
      var cantValores=valores.length;
      var parametros='?valores=';
      var sumMonto=0;var bandVerde=1;
      for(var i=0;i<cantValores;i++){
      	if(isNaN(valores[i].value)==false){
        parametros=parametros+valores[i].getAttribute('data-idACMM')+'-'+valores[i].value+';';
        sumMonto=sumMonto+parseFloat(valores[i].value);}
        else{i=cantValores;bandVerde=0;}
        
      }
      if(bandVerde){
      	if(parseInt(sumMonto)==parseInt(document.getElementById('inputMontoDAC').value))
      	{
      		parametros=parametros+'&idPersonaDepartamento='+document.getElementById('inputIdPDMeses').value;
      		parametros=parametros+'&idAperturaContable='+document.getElementById('inputIdACMeses').value;
      		peticionAJAX('contabilidad/guardarMontoMesesDepartamento/',parametros,'guardarMesesDepartamento');
      	}
      	else{alert('La suma de los montos mensuales no corresponde al monto total asignado al departamento');}
      }
      else{alert('Hay datos que no se pueden procesar');}
      
	}
	else
	{
      alert(datos.mensaje);
	}

}
function sumaParaTotal(){
	var valores=document.getElementsByClassName('data-idACMM');
	 var cantValores=valores.length;var sumMonto=0;
	   for(var i=0;i<cantValores;i++){
      	if(isNaN(valores[i].value)==false){        
        sumMonto=sumMonto+parseFloat(valores[i].value);}
        
      }
      document.getElementById('inputTotalPorMeses').value=sumMonto;
      
   
}
function comprobarNumerico(objeto){if(isNaN(objeto.value)==true){objeto.value=0;}}
function mesesDepartamento(datos,idAperturaContable,idPersonaDepartamento){
   if(datos=='')
       {
    	 var parametros="?";
	     parametros=parametros+'idAperturaContable='+idAperturaContable+'&idPersonaDepartamento='+idPersonaDepartamento;	     
	     peticionAJAX('contabilidad/devolverMontoMeses/',parametros,'mesesDepartamento');
        }
    else{  
     var tabla='<div><label>Monto total de departamento:'+datos.montoDepartamento[0].montoDAC+'</label><input type="hidden" value="'+datos.montoDepartamento[0].montoDAC+'" id="inputMontoDAC">';var sum=0;
     tabla=tabla+'<input type="hidden" value="'+datos.montoDepartamento[0].idPersonaDepartamento+'" id="inputIdPDMeses">';
     tabla=tabla+'<input type="hidden" value="'+datos.montoDepartamento[0].idAperturaContable+'" id="inputIdACMeses">';
     tabla=tabla+'<table border="1" class="table"><tr><td>Mes</td><td>Monto</td></tr>';
     for(var i=0;i<datos.mesesApertura.length;i++)
     {
      tabla=tabla+'<tr><td>'+datos.meses[i+1]+'</td><td><input type="text" value="'+datos.mesesApertura[i].montoMes+'" class="form-control data-idACMM" style="text-align:right" data-idACMM="'+datos.mesesApertura[i].idAperturaContableMontoMes+'" onchange="comprobarNumerico(this);sumaParaTotal()"></td></tr>';
       sum=sum+parseFloat(datos.mesesApertura[i].montoMes);
     }
     tabla=tabla+'<tr><td>Total</td><td style="text-align:right"><input type="text" class="form-control input-sm" style="text-align:right" id="inputTotalPorMeses" value="'+sum+'" readOnly></td></tr>';
     tabla=tabla+'</table><div><button class="btn btn-success" onclick="guardarMesesDepartamento(\'\')">Guardar</button></div>';
     document.getElementById('divModalContenidoGenerico').innerHTML=tabla;
      document.getElementById('divModalGenerico').classList.toggle('modalCierra');
      document.getElementById('divModalGenerico').classList.toggle('modalAbre');	
    }


}
function GuardarMontoDepartamento(idAperturaContable)
{
  var aperturas=document.getElementsByClassName('aperturaContable'+idAperturaContable);
  var cantApertura=aperturas.length;var sum=0;var cadena="";
  for(var i=0;i<cantApertura;i++){cadena=cadena+aperturas[i].getAttribute('data-idPersonaDepartamento')+'-'+aperturas[i].value+',';}
   crearObjetosParaForm(idAperturaContable,'idAperturaContable');
   crearObjetosParaForm(cadena,'personaDepartamento');
   enviarFormGenerales('contabilidad/asignarPresupuestoDepartamento');
}

function cerrarModalGenerico(modal){
     document.getElementById(modal).classList.toggle('modalCierra');
     document.getElementById(modal).classList.toggle('modalAbre');   
}
function guardarPromoBono(datos)
{
  if(datos=='')
  {     
        let parametros="?";
        parametros=parametros+'anio='+document.getElementById('selectAnioPB').value;
        parametros=parametros+'&mes='+document.getElementById('selectMesPB').value;
        parametros=parametros+'&tipo='+document.getElementById('selectTipoPB').value;
        parametros=parametros+'&canal='+document.getElementById('selectCanalPB').value;
        parametros=parametros+'&cantidad='+document.getElementById('inputCantidadPB').value;
          peticionAJAX('contabilidad/guardarPromoBono/',parametros,'guardarPromoBono');  
  }
  else
  {
   alert(datos.mensaje);
   if(datos.seGuardo==1){buscarPromoBono('');}
  }
}

function buscarPromoBono(datos)
{
  if(datos=='')
  {
    let parametros="?";
        parametros=parametros+'anio='+document.getElementById('selectAnioBusquedaPB').value+'&tipoCaptura='+document.getElementById('selectTipoPB').value;        
       peticionAJAX('contabilidad/buscarPromoBono/',parametros,'buscarPromoBono');
  }
  else
  {
      cantidad=datos.informacion.length;    
      let tabla='<table class="table"><tbody class="tbodyPromoBono">';
      for(let i=0;i<cantidad;i++)
      {
        tabla=tabla+'<tr onclick="seleccionRow(this)">';
        tabla=tabla+'<td>'+datos.informacion[i].idPromoBono+'</td>';
        tabla=tabla+'<td>'+datos.informacion[i].anio+'</td>';
        tabla=tabla+'<td>'+datos.informacion[i].mesMX+'</td>';
        tabla=tabla+'<td>'+datos.informacion[i].tipo+'</td>';
        tabla=tabla+'<td>'+datos.informacion[i].canal+'</td>';
        tabla=tabla+'<td>'+datos.informacion[i].canal+'</td>';        
        tabla=tabla+'<td>$'+datos.informacion[i].cantidad+'</td>';        
        tabla=tabla+'<td><button class="btn btn-success btn-xs" onclick="mostrarFile('+datos.informacion[i].idPromoBono+')">↑</button></td>';
        tabla=tabla+'<td><button onclick="eliminarPromoBono(\'\','+datos.informacion[i].idPromoBono+')" class="btn btn-danger btn-xs">X</button></td>';
        tabla=tabla+'</tr>';
      }
    tabla=tabla+'</tbody></table>';
    document.getElementById('divTablaPromobono').innerHTML=tabla;
  }
}
function eliminarPromoBono(datos,idPromoBono)
{
  if(datos=='')
  {   
   let confirmacion = window.confirm("Deseas eliminar esta informacion");
   if(confirmacion)
   {
    let parametros="?";
    parametros=parametros+'idPromoBono='+idPromoBono;        
    peticionAJAX('contabilidad/eliminarPromoBono/',parametros,'eliminarPromoBono'); 
   }
   
  }
  else
  {
    alert(datos.mensaje);
    buscarPromoBono('');
  }

}
function buscarCobranzaEfectuada(datos)
{
 if(datos=='')
 {  let parametros='?';
    parametros=parametros+'anio='+document.getElementById('selectAnioCobranzaPendiente').value;
    parametros=parametros+'&mes='+document.getElementById('selectMesCobranzaPendiente').value;
    peticionAJAX('contabilidad/buscarCobranzaEfectuada/',parametros,'buscarCobranzaEfectuada'); 
   
 }
 else
 {
  let cantidad=datos.respuesta.length;
  let tabla='<table class="table table-bordered table-striped" id="tablaCobranzaEfectuada"><thead><tr>';
  let cabecera;
  for(let i=0;i<1;i++){cabecera=Object.keys(datos.respuesta[i]);}  
  let cantCabecera=cabecera.length;
  for(let i=0;i<cantCabecera; i++){tabla=tabla+'<th>'+cabecera[i]+'</th>'};
    tabla=tabla+'</tr></thead><tbody>';

  for(let i=0;i<cantidad;i++)
   {
    
   //Object.keys(datos.respuesta[i]).forEach(key => console.log(key, obj[key]))    
   tabla=tabla+'<tr>';
   for(let j=0;j<cantCabecera; j++){
    
    tabla=tabla+'<td>'+datos.respuesta[i][cabecera[j]]+'</td>';
    }
    tabla=tabla+'</tr>';
  }
  tabla=tabla+'</tbody></table>';
   document.getElementById('divTablaCobranzaPendiente').innerHTML=tabla;
 }
}

function sincronizarCobranzaEfectuada(datos)
{
  
  if(datos=='')
  {
    let parametros='?';
    parametros=parametros+'anio='+document.getElementById('selectAnioCobranzaPendiente').value;
    parametros=parametros+'&mes='+document.getElementById('selectMesCobranzaPendiente').value;
    peticionAJAX('contabilidad/sincronizarCobranzaEfectuada/',parametros,'sincronizarCobranzaEfectuada'); 

  }
  else
  {
    if(datos.status){buscarCobranzaEfectuada('');}
  }

}
function exportarExcel(tabla){
   var downloadLink;
    var dataType = 'application/vnd.ms-excel';
    let tablaCobranza=document.getElementById(tabla);
    var tableSelect = document.getElementById('tablaExportar');
    tableSelect.innerHTML=cabeceraTabla+tablaCobranza.innerHTML;
   let cant=tableSelect.rows.length;
   for(let i=0;i<cant;i++){tableSelect.rows[i].cells[0].innerHTML='';tableSelect.rows[i].cells[2].innerHTML='';tableSelect.rows[i].cells[0].setAttribute('align','right');}
  let tableHTML='';  
if(navigator.userAgent.indexOf('Chrome')>-1 || navigator.userAgent.indexOf('Safari')>-1 || navigator.userAgent.indexOf('OPR')>-1){
  if(navigator.userAgent.indexOf('Edge')>-1){tableHTML = '<table id="miTabla">'+tableSelect.innerHTML+'</table>';     }
  else{tableHTML = tableSelect.outerHTML.replace(/ /g, '%20');    }
}
else{tableHTML = '<table id="miTabla" border="2">'+tableSelect.innerHTML+'</table>';     }
    // Specify file name
    let filename="cobranzaEfectuada";
    filename = filename?filename+'.xls':'excel_data.xls';
    
    // Create download link element
    downloadLink = document.createElement("a");
    
    document.body.appendChild(downloadLink);
    
    if(navigator.msSaveOrOpenBlob){
        var blob = new Blob(['', tableHTML], {
            type: dataType
        });
        navigator.msSaveOrOpenBlob( blob, filename);
    }else{

        downloadLink.href = 'data:' + dataType + ', ' + tableHTML;    

        downloadLink.download = filename;        

        downloadLink.click();
    }
}
  function guardarAsignacionCC(datos)
  {
   if(datos=='')
   {
    let checkbox=document.getElementsByClassName('checkParaSignacion');
    let cant=checkbox.length;
    let parametros='';
    let cadena='';
    parametros='persona='+selectEmpleadoAsginarCC.value;
    for(let i=0;i<cant;i++)
    {
     if(checkbox[i].checked){cadena=cadena+checkbox[i].value+',';}
    }
    parametros=parametros+'&cuentas='+cadena;    
    peticionAJAX('contabilidad/guardarAsignacionCC/?',parametros,'guardarAsignacionCC');
   }
   else
   {
    alert(datos.mensaje);
    let cant=selectEmpleadoAsginarCC.options.length;
    for(let i=0;i<cant;i++)
    {
      if(selectEmpleadoAsginarCC.options[i].value==datos.idPersona)
      {
       selectEmpleadoAsginarCC.options[i].setAttribute('data-permisoscc',datos.cuentas); 
      }
    }
   }
  }
function peticionAJAX(controlador,parametros,funcion){
  var req = new XMLHttpRequest();var direccionAJAX="<?= base_url();?>";
  var url=direccionAJAX+controlador+parametros;
  //abreCierraEspera();
  console.log(url)
 req.open('POST', url, true);
  req.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
   req.onreadystatechange = function (aEvt) 
  {
    if (req.readyState == 4) {
    	if(req.status == 200)
        { 
         var respuesta=JSON.parse(this.responseText);
         switch(funcion){
         	case 'mesesDepartamento':mesesDepartamento(respuesta,'','');break;
         	case 'guardarMesesDepartamento':guardarMesesDepartamento(respuesta);break;
          case 'guardarPorcentaje':guardarPorcentaje(respuesta);break;
          case 'guardarPromoBono':guardarPromoBono(respuesta);break;
          case 'buscarPromoBono':buscarPromoBono(respuesta);break;
          case 'eliminarPromoBono':eliminarPromoBono(respuesta,'');break;
          case 'buscarCobranzaEfectuada':buscarCobranzaEfectuada(respuesta);break;
          case 'sincronizarCobranzaEfectuada':sincronizarCobranzaEfectuada(respuesta);break;
          case 'guardarTarjeta':guardarTarjeta(respuesta);break;
          case 'asignarTarjeta':asignarTarjeta(respuesta);break;
          default:  window[funcion](respuesta);        break;            
         }   
      }     
   }
  };
 req.send();
}

function seleccionRow(objeto)
{ 
  let rowSeleccionado=document.getElementsByClassName('rowSeleccionado');
  let cant=rowSeleccionado.length;
  for(let i=0;i<cant;i++){rowSeleccionado[i].classList.remove('rowSeleccionado');}
  objeto.classList.add('rowSeleccionado');
window.setTimeout(0)
  return 1;
}

		function formatoMoneda2(objeto){
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
function x(objeto){
var valor=objeto.value;
var montoEntero=0;var montoFlotante=00;
var montoDivision=valor.split('.');
var numeroFlotantes=2;bandFlotantes=0;
var parteEntera="";var parteFlotante="";var bandPunto=0;
for(var i=0;i<valor.length;i++){
 if(bandPunto==0){
	if(valor[i]=="0" || valor[i]=="1" || valor[i]=="2" || valor[i]=="3" || valor[i]=="4" || valor[i]=="5" || valor[i]=="6" || valor[i]=="7" || valor[i]=="8" || valor[i]=="9")
	{
		if(valor[i]=="0")
		parteEntera=parteEntera+valor[i];
	}
	else{
	 if(valor[i]=='.'){bandPunto=1;}	
	}
   }
   else{	if(valor[i]=="0" || valor[i]=="1" || valor[i]=="2" || valor[i]=="3" || valor[i]=="4" || valor[i]=="5" || valor[i]=="6" || valor[i]=="7" || valor[i]=="8" || valor[i]=="9")
	{
		if(bandFlotantes<=1){
     	parteFlotante=parteFlotante+valor[i];bandFlotantes++;}
      }
   }
}

	var cantEntero=parteEntera.length;var enteroInverso="";var	entero="";
	cantEntero=cantEntero-1;

	if(cantEntero>2){var bandComa=0;
		for(var i=cantEntero;i>=0;i--){			
           if(bandComa>2){enteroInverso=enteroInverso+","+parteEntera[i];bandComa=1;}
           else{enteroInverso=enteroInverso+parteEntera[i];bandComa=bandComa+1;}           
		}
		cantInverso=enteroInverso.length;cantInverso=cantInverso-1;
		for(var i=cantInverso;i>=0;i--){entero=entero+enteroInverso[i];}
	}else{entero=parteEntera;}

if(parteEntera=='' && parteFlotante==''){objeto.value='$'+'0'+'.00';}
if(parteEntera!='' && parteFlotante==''){objeto.value='$'+parteEntera+'.00';}
if(parteEntera=='' && parteFlotante!=''){objeto.value='$0'+parteFlotante;}
if(parteEntera!='' && parteFlotante!=''){objeto.value='$'+parteEntera+'.'+parteFlotante;}

}
function muestraPorcentaje(objeto)
{
  document.getElementById('labelFianzas').innerHTML=objeto.getAttribute('data-fianzas');
  document.getElementById('labelInstitucional').innerHTML=objeto.getAttribute('data-institucional');
  document.getElementById('labelCoorporativo').innerHTML=objeto.getAttribute('data-coorporativo');
  document.getElementById('labelGestion').innerHTML=objeto.getAttribute('data-asesores');
}
function labelPorcentaje()
{
   document.getElementById('labelFianzas').innerHTML=0;
  document.getElementById('labelInstitucional').innerHTML=0;
  document.getElementById('labelCoorporativo').innerHTML=0;
  document.getElementById('labelGestion').innerHTML=0;

}
var fecha = new Date();
var ano = fecha.getFullYear();
console.log(ano);
document.getElementById('selectAnioBusquedaPB').value=ano;
buscarPromoBono('');

</script>
<?php
/*CODIGO PHP*/
function imprimirTarjetasAsignadas($datos)
{

  $option='';
  foreach ($datos as  $value) 
    {if($value->idPersona!=0)
      { $nombre=$value->apellidoPaterno.' '.$value->apellidoMaterno.' '.$value->nombres;
        $option.='<tr><td>'.$value->formaPago.'</td><td>'.$value->numeroTarjeta.'</td><td>'.$nombre.'</td><td><button class="btn btn-warning" onclick="desAsignarTarjeta(\'\','.$value->idTarjetas.')">X</button></td>';
      }
    }
  return $option;
}
//---------------------------------------------------------
function imprimirTarjetasParaAsignar($datos)
{
  $option='';
  foreach ($datos as  $value) {if($value->idPersona==0){$option.='<option value="'.$value->idTarjetas.'">'.$value->numeroTarjeta.'('.$value->formaPago.')</option>';}}
  return $option;
} 
//-------------------------------------------
function imprimirEmpleados($datos)
{
  $option="";
 /* foreach ($datos as  $value) {
        $option.='<option value="'.$value->idPersona.'" data-correo="'.$value->email.'">'.$value->email.'->'.$value->nombres.' '.$value->apellidoPaterno.' '.$value->apellidoMaterno.'</option>';
  }*/
 // $fp = fopen('resultadoJason.txt', 'a');fwrite($fp, print_r($datos, TRUE));fclose($fp);
    foreach ($datos as $key1 => $value1) {
  

  
    $option.='<optgroup label="'.$value1['Name'].'">';
    foreach ($value1['Data'] as $key => $value) 
    {
            $permisos='';
              
    foreach($value['permisosCC'] as $permisosCC)
      {
        $permisos.=$permisosCC['idCuentaContable'].',';
      }
      $permisos=trim($permisos,',');
     $nombres=$value['apellidoPaterno'].' '.$value['apellidoMaterno'].' '.$value['nombres'];
   $option.='<option value="'.$value['idPersona'].'" data="'.$value['email'].'" data-permisoscc="'.$permisos.'")>'.$nombres.' <label>     ('.$value['email'].' </label></option>';  
    }
    $option.='</optgroup>';
  
  }
  return $option;
}
function imprimirTarjetas($datos)
{
  $option="";
  foreach ($datos as  $value) {
    $option.='<option value="'.$value->idFormaPago.'">'.$value->formaPago.'</option>';
  }
  return $option;
}
function imprimirCuentasPorDepartamentosParaAsinagcion($informacion){
  $lista="";$lista.='<div style="display:flex;margin-left:0px">';
  foreach ($informacion as $key => $value) {
    $lista.='<ul style="border-right:solid; width:250px;height:350px;overflow:scroll">'.$key;
    foreach ($informacion[$key] as  $valueDepartamento) {
      $clase='liGenericoCC';
      if($valueDepartamento->sumPorcentaje>0){$clase.=' conPorciento';}


      $lista.='<li style="display:flex"  class="'.$clase.'" data-fianzas="'.$valueDepartamento->fianzasPorcentaje.'" data-institucional="'.$valueDepartamento->institucionalPorcentaje.'" data-coorporativo="'.$valueDepartamento->coorporativoPorcentaje.'" data-gestion="'.$valueDepartamento->gestionPorcentaje.'" data-asesores="'.$valueDepartamento->AsesoresPorcentaje.'" data-permiso=""><button  style="width:20px;height:20px"  onclick=eliminarCC('.$valueDepartamento->idCuentaContable.')>-</button><label class="etiquetaSimple" style="width:150px;height:auto;">'.$valueDepartamento->cuentaContable.'</label><input style="width:150px;height:auto"  type="checkbox" class="checkParaSignacion" value="'.$valueDepartamento->idCuentaContable.'"  >
      </li><br>';
    }
    $lista.='</ul>';
  }
  $lista.='</div>';
  return $lista;
  

}
function imprimirCuentasPorDepartamentos($informacion){
	$lista="";$lista.='<div style="display:flex;margin-left:0px">';
	foreach ($informacion as $key => $value) {
		$lista.='<ul style="border-right:solid; width:250px;height:350px;overflow:scroll">'.$key;
		foreach ($informacion[$key] as  $valueDepartamento) {
      $clase='liGenerico';
      if($valueDepartamento->sumPorcentaje>0){$clase.=' conPorciento';}
			$lista.='<li style="display:flex" onmouseover="muestraPorcentaje(this)" onmouseout="labelPorcentaje()" class="'.$clase.'" data-fianzas="'.$valueDepartamento->fianzasPorcentaje.'" data-institucional="'.$valueDepartamento->institucionalPorcentaje.'" data-coorporativo="'.$valueDepartamento->coorporativoPorcentaje.'" data-gestion="'.$valueDepartamento->gestionPorcentaje.'" data-asesores="'.$valueDepartamento->asesoresPorcentaje.'"><button  style="width:20px;height:20px"  onclick=eliminarCC('.$valueDepartamento->idCuentaContable.')>-</button><label class="etiquetaSimple" style="width:150px;height:auto;">'.$valueDepartamento->cuentaContable.'</label><input style="width:150px;height:auto"  type="checkbox" class="checkPorcentaje" value="'.$valueDepartamento->idCuentaContable.'"  >
			</li><input type="text" value="0" style="text-align:right" name="guardarPresupuesto" data-id="'.$valueDepartamento->idCuentaContable.'"><br><hr>';
		}
		$lista.='</ul>';
	}
	$lista.='</div><div><button>Guardar Presupuesto</button></div>';
	return $lista;
	

}
function imprimirAperturaCierre($informacion){
	$datos="";
	
	foreach ($informacion as  $value) {
		$datos.='<div class="divDepartamento"><label>'.$value->anioAC.'</label><br>';
		$datos.='<input type="input" id="textMT'.$value->idAperturaContable.'" value="'.$value->inicialAC.'"  style="text-align:right"><br>';
		         if($value->statusAbiertoAC){
         $datos.='<button onclick=calcularMonto(1,'.$value->idAperturaContable.') class="btn btn-success">Guardar</button>';}
		$datos.='<div style="display:flex; margin: 20px; padding:2px">';
         foreach ($value->departamentos as  $valorDpto) {
         	$datos.='<div class="cabeceraDepartamento">';         	
         	$datos.='<label>'.$valorDpto->personaDepartamento.'</label><br>';
         	$datos.='<input class="inputGenerico aperturaContable'.$value->idAperturaContable.'" data-idPersonaDepartamento="'.$valorDpto->idPersonaDepartamento.'" type="text"  value="'.$valorDpto->montoDAC.'"><button class="btn btn-warning btn-sm" onclick=mesesDepartamento("",'.$value->idAperturaContable.','.$valorDpto->idPersonaDepartamento.')>Meses</button>';
         	$datos.='<div class="contenidoDepartamento">';
         	foreach ($valorDpto->cuentaContable as $valorCC) {

         		$datos.='<label class="etiquetaSimple">->'.$valorCC->cuentaContable.'</label><br>';
         	}
         	$datos.='</div></div>';
         }

         $datos.='</div>';
         if($value->statusAbiertoAC){
   $datos.='<div class="pieDepartamento"><button class="btn btn-success" onclick="GuardarMontoDepartamento('.$value->idAperturaContable.')">Guardar por Departamento</button></div>';}
		$datos.='</div>';

	}
	return $datos;
}
function imprimirModalContable($informacion){
	
	$modal='<div id="miModalGenerico" class="modalAbreGenerico" ><div id="ModalcontenidoGenerico" class="modal-contenidoGenerico"  >';
	$modal.='<div class="contenidoModal">';
	$modal.='<div><button onclick="cerrarModal()" class="botonCierre">X</button></div>';
	$modal.='<div class="infoModal"><div><label class="labelModal">¿Desea cerrar la cuenta contable '.$informacion['anioAc'].' y abrir '.$informacion['anioSiguiente'].'? </div>';
	$modal.='<div style="border:solid"><button class="btn btn-success" onclick="abrirCerrarCC()">Aceptar</button><button onclick="cerrarModal()" class="btn btn-danger botonCancelar" >Cancelar</button></div>';
	$modal.='</div></div></div></div>';
	return $modal;
}
function imprimirDepartamentos($informacion){
	$select='<select id="selectCC" class="form-control"><option value="-1">Escoger departamento</option>';
    foreach ($informacion as  $value) {$select.='<option value="'.$value->idPersonaDepartamento.'">'.$value->personaDepartamento.'</option>';}
	$select.='</select>';
	return $select;
}

function imprimirMeses($informacion){
  $option='';
  foreach ($informacion as $key => $value) {$option.='<option value="'.$key.'">'.$value.'</option>';}
  return $option;
}
function imprimirAnios($informacion){
  $option='';
  foreach ($informacion as  $value) {$option.='<option>'.$value.'</option>';}
  return $option;
}
?>

<script type="text/javascript">
	<?php
if(isset($mensaje)){echo('alert("'.$mensaje.'");');}
if(!$permisosMenu){echo("manejoMenu('divPromoBono');");}
?>
	document.getElementById('selectCC').value=2;
</script>
<style type="text/css">
    .divDepartamento{width: 100%;overflow: scroll;border:solid;}
	.cabeceraDepartamento{margin-left: 20px;text-align:left;border:solid black;color: white;background-color: #361866}
	.contenidoDepartamento{height:200px;overflow: scroll;background-color: white;border:double;}
	.pieDepartamento{position: relative;top: -20px; left: 45%}
	.inputGenerico{background-color: white;color: black}
	.colorAceptar{background-color: green}
	.colorNoAceptar{background-color: red}
  .contMenuPorcentaje{background: none repeat scroll 0 0 #FFFFFF;border: 1px solid #DDDDDD;border-radius: 6px 6px 6px 6px;bottom: 100px;right: 200px;margin-left: 100px;padding: 10px 0 0;position: fixed;text-align: center;z-index: 10000;padding: 0px; margin: 0px; width: 800px; height: 400px;background-color: #FFFFFF }
  .conPorciento{border:solid;}
  .liGenerico:hover{background-color: green}
  .rowSeleccionado{background-color: green}
  .tbodyPromoBono tr:hover{background-color: #8dd28d}
  .divConBorder{border:solid black 1px;color: blue; background-color: #361866}
  .divConBorder>label{color: white}
  .ccGruposHijos{color:black;background-color: #e0f79e}
  .ccGruposHijos >td:nth-child(1){color:brown;background-color: red;visibility: hidden;}
  .ccGrupos{color:black;background-color: #d5c2f3}
  .ccGrupos:hover{color:black;background-color: #d5f39c}
  .ccGruposClick{background-color: #8dff8c}
</style>
<script type="text/javascript">
  var  esCargaPagina=1;
  function escogerCCGrupos(objeto)
  {
    let ccGruposClick=document.getElementsByClassName('ccGruposClick');
    if(ccGruposClick.length>0){ccGruposClick[0].classList.remove('ccGruposClick');}
    objeto.classList.add('ccGruposClick');    
    
    let check=Array.from(document.getElementsByClassName('checkPorcentaje'));

    check.forEach(c=>{c.checked=false;c.parentNode.classList.remove('fondoParaHijosReporte')})          


            let matriz=objeto.dataset.idcuentacontable.split(',');
            matriz.forEach(m=>{
              if(m!='' && m!='0')
              {
                check.forEach(c=>{if(c.value==m){c.checked=true;c.parentNode.classList.add('fondoParaHijosReporte')}})
              }
            })
  }
  function inicializaValores()
  {
    document.getElementById('selectAnioCobranzaPendiente').value="<?=$anioActual;?>";
    document.getElementById('selectAnioPB').value="<?=$anioActual;?>";
    document.getElementById('selectMesPB').value="<?=$mesActual;?>";
    //document.getElementById('selectMesCobranzaPendiente').value="<?=$mesActual;?>";
    let btn=Array.from(document.getElementsByName('ocultarHijosGrupoBTN'));
    btn.forEach(b=>{
      b.addEventListener("click",function(){
        let hijos=this.parentNode.parentNode.parentNode.nextElementSibling.childNodes;
       (b.innerHTML=='+')?b.innerHTML='-':b.innerHTML='+';      
        hijos.forEach(h=>{h.classList.toggle('ocultarObjeto')})        
      })
     //hijosOcultar.forEach(h=>{h.classList.toggle('ocultarObjeto')})        
     //b.innerHTML=''
    })
  }
inicializaValores();
</script>

<script>

function enviarArchivoAJAX(formulario,funcion){ 

  
      var Data = new FormData(document.getElementById(formulario));  
    if(window.XMLHttpRequest) { var Req = new XMLHttpRequest();}
    else if(window.ActiveXObject) {var Req = new ActiveXObject("Microsoft.XMLHTTP");}  
    var direccion= <?php echo('"'.base_url().'contabilidad/"');?>+funcion;
    Req.open("POST",direccion, true); 
    //document.getElementById('gifDeEspera1').classList.add('verObjetoGif');
    //document.getElementById('gifDeEspera1').classList.remove('ocultarObjeto');
    Req.onload = function(Event) {    
    var respuesta = JSON.parse(Req.responseText);   
    if (Req.status == 200 && Req.readyState == 4) 
    {     
                

    } 

  };   
  Req.send(Data);


}
function guardarFormaPago(datos='')
{
  if(datos=='')
  {  let parametros='';
    let check=document.getElementsByName('checkFormaPago');
    let idFormaPago="";
    check.forEach(c=>{if(c.checked){idFormaPago+=c.value+';'}})
    let email=selectEmpleadoAsginarTarjeta.options[selectEmpleadoAsginarTarjeta.selectedIndex].getAttribute('data');
    parametros=parametros+'?idFormaPago='+idFormaPago;
    parametros=parametros+'&idPersona='+selectEmpleadoAsginarTarjeta.value;
    parametros=parametros+'&email='+email;
    peticionAJAX('contabilidad/guardarFormaPago/',parametros,'guardarFormaPago');
    
   }
  else{alert('CAMBIOS GUARDADOS CORRECTAMENTE');}
}
function cambiarPersonaTarjeta(datos,objeto)
{
  if(datos=='')
  {
     let parametros='';
     parametros=parametros+'?email='+objeto.options[objeto.selectedIndex].getAttribute('data');
     peticionAJAX('contabilidad/permisosFormaPago/',parametros,'cambiarPersonaTarjeta');
  }
  else
  {
    let check=document.getElementsByName('checkFormaPago');
    check.forEach(c=>{
      let band=false;
      datos.idFormaPago.forEach(i=>{if(i.idFormaPago==c.value){band=true;}})
      if(!band){c.checked=false;}else{c.checked=true;}
    })
    
  }
}

//--------------------------------------------------

function devolverRowTablaGrupos(array,mes='',anio='')
{
    let row='';    
    let clase=''; 
    let botonGuardarHijo='';   
     if(array.length==0){row='<tr><td></td><td colspan="2">NO HAY CUENTA CONTABLE PARA ESTE REPORTE</td></tr>';}
     else
     {
      array.forEach(g=>{
        let hijo='';
        let rowHijo='';
        let dataIdGrupo=0;
        let idCuentaContable='';
        let idCuentaContableGrupo=0;
        let monto='';
        let montoDig=0;
          let dataICC=0;
          (g.idCuentaContable===null)?dataIdGrupo=g.idCuentaContableGrupos:dataICC=g.idCuentaContable;
        if(g.idCuentaContable===null)
          {
            botonGuardarHijo=`<button class="btn btn-success" onclick="guardarAsignacionGrupocuentaContable('',this)" data-valor="${g.idCuentaContableGrupos}">&#128190</button>`;
            hijo=`<button class="btn btn-info" onclick="cerrarHijosGrupo(this)" data-identificahijo="trHijos${g.idCuentaContableGrupos}" >-</button>`
            //hijo=`<button class="btn btn-info" onclick="asignarRecursosHijosGrupo(this)" data-identificahijo="trHijos${g.idCuentaContableGrupos}" >$</button>`
            g.hijos.forEach(h=>{
              rowHijo+=`<tr class="ccGruposHijos ${clase}" name="trHijos${g.idCuentaContableGrupos}"><td></td><td colspan="2">${h.cuentaContable}</td><td><button class="btn btn-danger" data-idcuentacontable="${h.idCuentaContable}" data-idcuentacontablegrupo="0" onclick="eliminarCCReporte(this)">-</button></td></tr>`;
              idCuentaContable+=`${h.idCuentaContable},`;
            })
          }                
          if(g.monto.length>0){
           g.monto.forEach(m=>{
            monto+=`${m.monto},`;montoDig+=parseFloat(m.monto);
          })
          }
          else
          {
            monto='0,0,0,0,0,0,0,0,0,0,0,0';montoDig='0';
          }
       idCuentaContable+=`${dataICC},`;   
        row+=`<tr id="${g.idCuentaContableGrupos}CCGRow" class="ccGrupos ${clase}" data-monto="${monto}" data-mes="${mes}" data-anio="${anio}" data-idcuentacontable="${idCuentaContable}" onclick="escogerCCGrupos(this)"><td>${hijo}</td><td>${g.cuentaContableGrupos}</td><td>${botonGuardarHijo}</td><td><button class="btn btn-danger" data-idcuentacontable="${dataICC}" data-idcuentacontablegrupo="${dataIdGrupo}" onclick="eliminarCCReporte(this)">-</button></td><td><label id="${g.idCuentaContableGrupos}CCGLabel">MONTO ASIGNADO $ ${montoDig}</label><button class="btn btn-success" data-idcuentacontable="${dataICC}" data-idcuentacontablegrupo="${dataIdGrupo}" onclick="asignarRecursosParaGrupos(this)">$</button></td></tr>${rowHijo}`

      })
     }
     return row;  
}
//-----------------------------------
function datosConfiguracionreportes(datos='')
{
  if(datos=='')
  {  
    let parametros='';
    peticionAJAX('contabilidad/datosConfiguracionreportes/',parametros,'datosConfiguracionreportes');    
  }
   else
   {
    
    let row=[];
    row=devolverRowTablaGrupos(datos.gastosOperacion,datos.mes,datos.anio);    
    document.getElementById('tbodyGastosOperacion').innerHTML=row;
    row=null;
    row=devolverRowTablaGrupos(datos.gastosVariables,datos.mes,datos.anio);
    document.getElementById('tbodyGastosVariables').innerHTML=row;
    row=null;
    row=devolverRowTablaGrupos(datos.gastosFinancieros,datos.mes,datos.anio);
    document.getElementById('tbodyGastosFinancieros').innerHTML=row;
    row=null;
    row=devolverRowTablaGrupos(datos.gastosImpuestos,datos.mes,datos.anio);
    document.getElementById('tbodyGastosImpuestos').innerHTML=row;
        row=null;
    row=devolverRowTablaGrupos(datos.gastosActivos,datos.mes,datos.anio);
    document.getElementById('tbodyGastosActivos').innerHTML=row;
   }

}
function guardaGrupoCuentaContable(input,tipo)
{
 
    if(document.getElementById(input).value!='')
    {
     let parametros='?grupoCuentaContable='+document.getElementById(input).value+'&tipo='+tipo;
     peticionAJAX('contabilidad/guardaGrupoCuentaContable/',parametros,'datosConfiguracionreportes');    
    }
    else{alert('ESCRIBA EL NOMBRE DEL GRUPO');}


}
function guardarAsignacionGrupocuentaContable(datos='',objeto)
{
  if(datos=='')
  {
    let check=Array.from(document.getElementsByClassName('checkPorcentaje'));
    let id='';
    let parametros='';
    check.forEach(c=>{if(c.checked){id+=c.value+',';}})   
    if(id==''){alert('ESCOGER CUENTAS CONTABLES');return 0;}
    if(objeto.dataset.valor==0){ parametros='?tipoGrupo='+objeto.dataset.grupo+'&idCuentaContable='+id;}
    else{ parametros='?idCuentaContableGrupo='+objeto.dataset.valor+'&idCuentaContable='+id;}
     peticionAJAX('contabilidad/guardaCuentasContablesGrupoRelacion/',parametros,'datosConfiguracionreportes');    
  }
}
datosConfiguracionreportes();

function cerrarHijosGrupo(objeto)
{
  let hijos=Array.from(document.getElementsByName(objeto.dataset.identificahijo));

   let inner='';
  if(objeto.innerHTML=='-')
  {
    inner='+';
     hijos.forEach(h=>{h.classList.add('ocultarObjeto');})
  }
  else
  {
    inner='-';
     hijos.forEach(h=>{h.classList.remove('ocultarObjeto');})
  }
  objeto.innerHTML=inner;
}
function eliminarCCReporte(objeto)
{
  
  let parametros='';
  parametros='?idCuentaContableGrupo='+objeto.dataset.idcuentacontablegrupo+'&idCuentaContable='+objeto.dataset.idcuentacontable;
   peticionAJAX('contabilidad/eliminarCCReporte/',parametros,'datosConfiguracionreportes');    
  
}
function habilitarOpcionesCabecera(objeto='')
{
  let cabeceras=Array.from(document.getElementsByName("theadReporte"));
  cabeceras.forEach(c=>{
    let obj=Array.from(c.getElementsByTagName('button'));
      obj.forEach(o=>{
        o.classList.add('inhabilitaOpciones');
      })
    let objInput=Array.from(c.getElementsByTagName('input'));
          objInput.forEach(o=>{
            if(o.name!='radioCabecera'){o.classList.add('inhabilitaOpciones');}
      })
  })
  if(objeto)
  {
    let obj=Array.from(objeto.parentNode.parentNode.parentNode.getElementsByTagName('button'));
    
    let bro=Array.from(objeto.parentNode.parentNode.parentNode.nextElementSibling.getElementsByTagName('tr'));
    let check=Array.from(document.getElementsByClassName('checkPorcentaje'));

    check.forEach(c=>{c.checked=false;c.parentNode.classList.remove('fondoParaHijosReporte')})
          obj.forEach(o=>{o.classList.remove('inhabilitaOpciones');})
              let objInput=Array.from(objeto.parentNode.parentNode.parentNode.getElementsByTagName('input'))
          objInput.forEach(o=>{o.classList.remove('inhabilitaOpciones');})
       bro.forEach(b=>{
        if(b.dataset.idcuentacontable)
          {
            let matriz=b.dataset.idcuentacontable.split(',');
            matriz.forEach(m=>{
              if(m!='' && m!='0')
              {
                check.forEach(c=>{if(c.value==m){c.checked=true;c.parentNode.classList.add('fondoParaHijosReporte')}})
              }
            })
          }
       })
  }
}
function asignarRecursosParaGrupos(obj)
{
      document.getElementById('modalParaRecursos').classList.toggle('modalCierra');
      document.getElementById('modalParaRecursos').classList.toggle('modalAbre');
      let row=obj.parentNode.parentNode;

      idCuentaContableGruposGlobal=obj.dataset.idcuentacontablegrupo;
      let monto=row.dataset.monto.split(',');
      let sum=0;
      monto.slice();
      monto.forEach(m=>{if(m!=''){sum=sum+parseFloat(m)};});
      presupuestoGrupo[0]=monto[0];
      presupuestoGrupo[1]=monto[1];
      presupuestoGrupo[2]=monto[2];
      presupuestoGrupo[3]=monto[3];
      presupuestoGrupo[4]=monto[4];
      presupuestoGrupo[5]=monto[5];
      presupuestoGrupo[6]=monto[6];
      presupuestoGrupo[7]=monto[7];
      presupuestoGrupo[8]=monto[8];
      presupuestoGrupo[9]=monto[9];
      presupuestoGrupo[10]=monto[10];
      presupuestoGrupo[11]=monto[11];

  let tabla=`<table class="table"><tr><td>ENERO</td><td><input name="montoTotalGrupos" class="form-control" style="text-align:right" value="${monto[0]}" onchange="sumTotal(this)"></td></tr>`;
      tabla+=`<tr><td>FEBRERO</td><td><input name="montoTotalGrupos" class="form-control" value="${monto[1]}" style="text-align:right" onchange="sumTotal(this)"></td></tr>`;
      tabla+=`<tr><td>MARZO</td><td><input name="montoTotalGrupos" class="form-control" value="${monto[2]}" style="text-align:right" onchange="sumTotal(this)"></td></tr>`;
      tabla+=`<tr><td>ABRIL</td><td><input name="montoTotalGrupos" class="form-control" value="${monto[3]}" style="text-align:right" onchange="sumTotal(this)"></td></tr>`;
      tabla+=`<tr><td>MAYO</td><td><input name="montoTotalGrupos" class="form-control" value="${monto[4]}" style="text-align:right" onchange="sumTotal(this)"></td></tr>`;
      tabla+=`<tr><td>JUNIO</td><td><input name="montoTotalGrupos" class="form-control" value="${monto[5]}" style="text-align:right" onchange="sumTotal(this)"></td></tr>`;
      tabla+=`<tr><td>JULIO</td><td><input name="montoTotalGrupos" class="form-control" value="${monto[6]}" style="text-align:right" onchange="sumTotal(this)"></td></tr>`;
      tabla+=`<tr><td>AGOSTO</td><td><input name="montoTotalGrupos" class="form-control" value="${monto[7]}" style="text-align:right" onchange="sumTotal(this)"></td></tr>`;
      tabla+=`<tr><td>SEPTIEMBRE</td><td><input name="montoTotalGrupos" class="form-control" value="${monto[8]}" style="text-align:right" onchange="sumTotal(this)"></td></tr>`;
      tabla+=`<tr><td>OCTUBRE</td><td><input name="montoTotalGrupos" class="form-control" value="${monto[9]}" style="text-align:right" onchange="sumTotal(this)"></td></tr>`;
      tabla+=`<tr><td>NOVIEMBRE</td><td><input name="montoTotalGrupos" class="form-control" value="${monto[10]}" style="text-align:right" onchange="sumTotal(this)"></td></tr>`;
      tabla+=`<tr><td>DICIEMBRE</td><td><input name="montoTotalGrupos" class="form-control" value="${monto[11]}" style="text-align:right" onchange="sumTotal(this)"></td></tr>`;
      tabla+=`<tr><td>TOTAL</td><td><input  class="form-control" value="${sum}" style="text-align:right" id="totalCuentasGrupos"></td></tr>`;
      tabla+=`<tr><td></td><td><button class="btn btn-success" onclick="guardarPresupuestoGrupos('',${row.dataset.anio})">GUARDAR</button></td></tr>`;
      tabla+=`</table>`;
      document.getElementById('divModalMesesRecursos').innerHTML=tabla;

}
function sumTotal(obj)
{  
      var RE = /^\d*\.?\d*$/;
    if (RE.test(obj.value)) 
    {   let sum=0;
         let arr=Array.from(document.getElementsByName('montoTotalGrupos'))
        arr.forEach(p=>{sum=sum+parseFloat(p.value);})
        document.getElementById('totalCuentasGrupos').value=sum;
    }
    else{alert('DEBE AGREGAR UN NUMERO DECIMAL');obj.value=0;}
}
function guardarPresupuestoGrupos(datos='',anio='')
{ 
  if(datos=='')
  {
    let parametros='';
    let val='';
    let bandNoNumero=true;
         let arr=Array.from(document.getElementsByName('montoTotalGrupos'))
        arr.forEach(p=>{val+=p.value+';';if(p.value==''){bandNoNumero=false;}})

     if(bandNoNumero){
    parametros='?idCuentaContableGrupo='+idCuentaContableGruposGlobal+'&val='+val+'&anio='+anio;  
   peticionAJAX('contabilidad/guardarPresupuestoGrupos/',parametros,'guardarPresupuestoGrupos');    
     }
     else{alert('HAY UN PARAMETRO QUE NO ES NUMERO')}

  }
  else
  {
    if(datos.mensaje){alert(datos.mensaje);}
    document.getElementById(datos.idCuentaContableGrupos+'CCGRow').dataset.monto=datos.montoCad;
    document.getElementById(datos.idCuentaContableGrupos+'CCGLabel').innerHTML='MONTO ASIGNADO $ '+datos.monto;
  }
}
habilitarOpcionesCabecera('');

</script>
<style type="text/css">
  .conScroll ::-webkit-scrollbar{width: 15px;}
  div ::webkit-scrollbar{width: 25px;}
  .inhabilitaOpciones{
        cursor: not-allowed;
        background-color: rgb(229, 229, 229) !important;
        pointer-events:none;
    }
  .fondoParaHijosReporte{background-color: #a5a5fd}
 

</style>