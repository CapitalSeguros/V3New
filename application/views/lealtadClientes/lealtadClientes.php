<?php $this->load->view('headers/header'); ?>
<?php $this->load->view('headers/menu');?>
<?
$entidadesArray=array();
$rankingArray=array();
array_push($entidadesArray, '');
array_push($rankingArray, '');
foreach ($puntosDeLosClientes as  $value) 
{


      ($value->tipoEntidad!='Fisica' && $value->tipoEntidad!='Moral')? array_push($entidadesArray, '"S/E"'):array_push($entidadesArray, '"'.$value->tipoEntidad.'"');
      ($value->clienteRanking=='')? array_push($rankingArray, '"S/R"'):array_push($rankingArray, '"'.$value->clienteRanking.'"');
      
}
?>
<script type="text/javascript"><?php if(isset($mensaje)){echo('alert("'.$mensaje.'");');} ?>;</script>
<script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>

<div class="divPrincipal">
<div class="divMenu">
	<button style="background-image:url(<?php echo(base_url().'assets/images/lealtadClientes1/agentes.png'); ?>);background-position:center; background-size: 100px;background-repeat: no-repeat;" class="buttonMenu btn-primary" onclick="manejoMenu('divAgentes')"><label>Agentes</label></button>
	<button style="background-image:url(<?php echo(base_url().'assets/images/lealtadClientes1/crearPromocion.png'); ?>);background-position:center; background-size: 100px;background-repeat: no-repeat;" class="buttonMenu btn-primary" onclick="manejoMenu('divCrear')"><label>Crear Promociones</label></button>
	<button style="background-image:url(<?php echo(base_url().'assets/images/lealtadClientes1/puntos.png'); ?>);background-position:center; background-size: 100px;background-repeat: no-repeat;" class="buttonMenu btn-primary" onclick="manejoMenu('divAsignarPuntos')"><label>Asignar Puntos</label></button>
	<button style="background-image:url(<?php echo(base_url().'assets/images/lealtadClientes1/consultar.png'); ?>);background-position:center; background-size: 100px;background-repeat: no-repeat;" class="buttonMenu btn-primary" onclick="manejoMenu('divConsultarPuntos')"><label>Consultar Puntos</label></button>
	<button style="background-image:url(<?php echo(base_url().'assets/images/lealtadClientes1/ranking.png'); ?>);background-position:center; background-size: 100px;background-repeat: no-repeat;" class="buttonMenu btn-primary" onclick="manejoMenu('divRanking')"><label>Ranking</label></button>	
	<button style="background-image:url(<?php echo(base_url().'assets/images/lealtadClientes1/bitacora.png'); ?>);background-position:center; background-size: 100px;background-repeat: no-repeat;" class="buttonMenu btn-primary" onclick="exportarBitacora()"><label>Exportar</label></button>
 <button style="background-image:url(<?php echo(base_url().'assets/images/lealtadClientes1/reportes.png'); ?>);background-position:center; background-size: 100px;background-repeat: no-repeat;" class="buttonMenu btn-primary" onclick="MuestraForma()"><label>Reporte</label></button> 
 <button style="background-image:url(<?php echo(base_url().'assets/images/lealtadClientes1/bitacora.png'); ?>);background-position:center; background-size: 100px;background-repeat: no-repeat;" class="buttonMenu btn-primary" data-toggle="collapse" href="#guion_tel" role="button" aria-expanded="false" aria-controls="guion_tef"><label>Guion Telefonico</label></button>
</div>
<div id="divContenido" class="divContenido">

  <!------------------->
  <div class="collapse mt-4 mb-4 m-0" id="guion_tel">
					<div class="card card-body">
						<h4>Guión telefónico</h4>
						<div class="row">
							<div class="col-md-2">
								<div class="list-group" id="myList" role="tablist">
									<?php if(!empty($guionTelefonico)){ 
										foreach($guionTelefonico as $id => $d_g){?>
											<a class="list-group-item list-group-item-action" data-toggle="list" href="#g_<?=$id?>" role="tab"><?=$d_g["nombre"]?></a>
									<?php }
										}?>
								</div>
							</div>
							<div class="col-md-10">
								<!-- Tab panes -->
								<div class="tab-content">
									<div class="tab-pane bg-white active" id="inicio" role="tabpanel">
										<h3 class="text-center mt-12 mb-10">Visualice cualquier de los ejemplos del lado izquierdo</h3>
									</div>
									<?php if(!empty($guionTelefonico)){ 
										foreach($guionTelefonico as $id => $d_g){?>
										<div class="tab-pane bg-white" id="g_<?=$id?>" role="tabpanel">
										<h4>Ejemplo de guía telefónica (Guión de CLUB CAP)</h4>
										<br>
										<div class="ml-4">
											<?php foreach($d_g["mensaje"] as $conversacion){?>
												<span class="badge badge-primary mb-2"><?=$conversacion["etiqueta"]?></span><br>
												<p class="text-dark font-italic"><?=$conversacion["texto"]?></p><br>
											<?php }?>
										</div>
									</div>
									<?php }
										}?>
								</div>
							</div>
						</div>
					</div>
				</div>
			<!------------------->

  <div id="divAgentes" class="divAgenteClass">
  <button class="btn btn-success btn-md" onclick="guardaPromocionAgente()">Guardar</button>
  <div>
<div id="DivRoot" align="left"><div style="overflow: hidden; height: 40px; width: 1334px; position: relative; top: 0px; z-index: 10; vertical-align: top;" id="DivHeaderRow" disabled="true"></div>
 <div style="overflow:scroll;" onscroll="OnScrollDiv(this)" id="DivMainContent" disabled="true">
<table  border="1" id="tablaAgentes" class="tablaAgentesClass table"></table>
</div>
<div id="DivFooterRow" style="overflow: scroll;"></div>
</div>
</div>
</div>

 <div id="divConsultarPuntos" class="divAgenteClass" >
 	<h4><label for="selectAgentesConsultaPuntos"  class="label label-primary">Agente</label></h4><select id="selectAgentesConsultaPuntos" name="selectAgentesConsultaPuntos" class="form-control selcls"></select>
 	<button onclick="consultarPuntosPorAgente()"  class="btn btn-success btn-md">Consultar</button><br><br>

<div id="divContenedorTabla" style="overflow-x: scroll; width: 100%; margin-left: 20px;margin-right: 20px">
<div class="row"><div class="col-md-2 col-sm-2 col-xs-2"><button class="btn btn-success" onclick="puntosCanjeados()">P.Canjeados</button></div><div class="col-md-2 col-sm-2 col-xs-2"><button class="btn btn-success" onclick="puntosOtorgados()">P. Otorgados</button></div><div class="col-md-2 col-sm-2 col-xs-2"><button class="btn btn-success" onclick="historial()">Historial</button></div><div class="col-md-2 col-sm-2 col-xs-2"><button class="btn btn-success" onclick="consultarProductos()">Productos</button></div></div>
<div  style="border:6px groove #ccc;background:#cecece;height: 50px">
<label>Fecha Inicial</label><input type="date" id="fInicialBitacora" value="<?=$primerDiaMes;?>">
<label>Fecha Inicial</label><input type="date" id="fFinalBitacora" value="<?=$diaActual;?>">
<button class="btn btn-success" onclick="consultarBitacoraDeCorreos()">&#128270</button>
</div>
<fieldset style="border:6px groove #ccc;background:#cecece;">
  <legend style="margin-bottom: 0px;width: auto;border-bottom: none;background:#cecece;font-size: 12px; ">ENVIO DE PUNTOS</legend>
  <button onclick="enviarPuntosClientesEmail('')" class="btn btn-success">Enviar Puntos</button>
  <input type="email" id="inputCorreoDePrueba">
  <input type="checkbox" id="inputPermiteEnvio">
</fieldset>
<div></div>
<!--div style="width:100%;height: 25px;border:double;overflow:hidden;" id="scrollCabecera"><?= imprimeTablaCabecera();?></div-->
<div onscroll="moverScroll()" id="scrollTabla" style="width:100%;overflow-x:scroll;overflow-y: scroll;height: 400px;border:double;"><?=imprimneTablaCuerpo($puntosDeLosClientes);?></div>
</div>

<br>


<br>


</div>

<div id="divCrear" class="divClienteClass" style="margin-left: 20%">  
	<form action="<?=base_url("lealtadClientes/add");?>" method = "post">
		<br>
		<label class="label label-primary" for="tipo">Nombre de Promocion</label><br><input  type="text" name = "tipo" class="form-control"  autocomplete="off"  /> <br><br>
		<label class="label label-primary" for="punto">Punto por Promocion</label><input  type="text" name = "punto"  class="form-control" autocomplete="off"/>
		 <input  type="submit" name = "submit" value="Guardar Promocion" class="btn-success"><br><br> 
	  </form>
<div id="DivRootCP" align="left"><div style="overflow: hidden;" id="DivHeaderRowCP"></div>
<div style="overflow:scroll;" onscroll="OnScrollDiv(this)" id="DivMainContentCP"><table border = "1"  id="tableCrearPuntos" class="tablaAgentesClass table"></table></div>
<div id="DivFooterRowCP" style="overflow:hidden"></div>
</div>

   
</div>
<div id="divRanking" class="tablaOtorgaPuntos divAgenteClass">
<button class="btn btn-success btn-md" onclick="agregarRanking()">Agregar ranking</button>
<input type="text" id="clienteRanking">
<button class="btn btn-info btn-md" onclick="calcularRanking()">Calcular ranking</button>
<table id="tableRanking" border="1 "></table>
</div>
<div id="divClienteRanking"></div>
<div id="divAsignarPuntos" class="tablaOtorgaPuntos divAgenteClass">
  
  
	<form id="iiojver" method="POST" action="<?php echo(base_url());?>lealtadClientes/obtenerClientesDeSicas">
	<select id="selectAgentesClub" name="selectAgentesClub" class="form-control selcls"></select><br>
    <input type="text" id="nombreCliente" name="nombreCliente" placeholder="nombre cliente" class="form-control" autocomplete="off">
	<button onmousedown="this.parenNode.submit()" class="btn btn-info btn-md">Buscar Clientes</button><br><br>
   </form>
   <table>
   	<tr>
   		<td>
<div id="DivRootAP" align="left"><div style="overflow: hidden;" id="DivHeaderRowAP"></div>
<div style="overflow:scroll;" onscroll="OnScrollDiv(this)" id="DivMainContentAP">
 <table border = 1 class="tablaAgentesClass table" id="tableAsignarPuntos"></table>
   
</div>
<div id="DivFooterRowAP" style="overflow:hidden"></div>
</div>
<button class="btn btn-success btn-md" onclick="otorgarPuntos()">otorgar puntos</button>
</td>
   		<td>
   <div id="DivRootC" align="left" style="float: left;"><div style="overflow: hidden;" id="DivHeaderRowC">   	
   </div>
 <div style="overflow:scroll;" onscroll="OnScrollDiv(this)" id="DivMainContentC"><table border = 1 class="tablaAgentesClass table" id="tableOtorgarPuntos"></table></div>
<div id="DivFooterRowC" style="overflow:hidden">
	
</div>
</div>
</td>
</tr>
</table>
</div>   
</div>
</div>
</div>
<div id="miModal" >
  <div id="Modalcontenido" class="modal-contenido"  >
   <?php if(isset($mod)){ ?>
   	<div style="border:5px double #361866;padding: 30px ;width:360px; float:left; position:relative; top:0px; left:-130px; background-color: #238073">
     <form id="formGuardarMod"  action="<?php echo(base_url()) ?>lealtadClientes/guardarMod" method="POST">	
 	<?php foreach ($mod as $fila){ ?>
 	<input type="hidden" name="IDPUNTO" value="<?=$fila->IDPUNTO?>"/>
<label>Nombre:<input type="text" name="TIPO" class="form-control"  value="<?=$fila->TIPO?>" autocomplete="off"/></label>
<label>Cantidad:<input type="text" class="form-control"  name="PUNTO" value="<?=$fila->PUNTO?>" autocomplete="off"/></label>

<?php } ?>
 </form>
 <form action="<?php echo(base_url()) ?>lealtadClientes/cancelarMod" id="formCancelarMod" method="POST">
 </form>
 <button onclick="document.getElementById('formGuardarMod').submit();">Guardar</button><button onclick="document.getElementById('formCancelarMod').submit();">Cancelar</button>
</div>
   <?php } ?>
  </div> 

</div>

<div id="miModalGenerico" >
  <div id="ModalcontenidoGenerico" class="modal-contenidoGenerico"  >

  </div> 
</div>

<div class="gifEspera ocultarObjeto" id="gifDeEspera"><img src="<?php echo(base_url().'assets\img\loading.gif')?>"></div>
<script type="text/javascript">
	var idPunto="";
	var url="<?=base_url();?>";
function enviarPuntosClientesEmail(datos)
{
 if(datos=='')
 {
   if(document.getElementById('inputPermiteEnvio').checked)
   {
    var confirmacion = confirm("ENVIARAS UN CORREO DE PRUEBA  ¿DESEAS CONTINUAR?");
     if(confirmacion)
      {
      if(comprobarClienteEscogido())
      {
         let params = 'IDCli='+document.getElementsByClassName('rowSeleccionadoClientes')[0].dataset.idcli; 
         params=params+';&correoPrueba='+document.getElementById('inputCorreoDePrueba').value;
        params = params+'&AJAX=1';
      controlador="lealtadClientes/enviarPuntosClientesEmail/?";
      peticionAJAX(controlador,params,'enviarPuntosClientesEmail'); 

      }        
      } 
    
    return 1;  
   }
   let cb=document.getElementsByClassName('cbEnviaCorreoPuntos');
  let cant=cb.length;
  let IDCli="";  
  for(let i=0;i<cant;i++){if(cb[i].checked){IDCli=IDCli+cb[i].value+';'}} 
    if(IDCli==""){alert('Escoger Clientes')}
    else
    {
      var params = 'IDCli='+IDCli;
      params = params+'&AJAX=1';
      controlador="lealtadClientes/enviarPuntosClientesEmail/?";
      peticionAJAX(controlador,params,'enviarPuntosClientesEmail'); 
    }
  }
  else{alert(datos.mensaje);}
}
function activarClientesEnvioPuntos(objeto)
{
  let cb=document.getElementsByClassName('cbEnviaCorreoPuntos');
  let cant=cb.length;
  let activo=false;
  if(objeto.checked){activo=true;}
  for(let i=0;i<cant;i++){cb[i].checked=activo;}
}

</script>
<style>
.modal
{
 position: fixed; 
 
 background:  rgba(255,255,255,255.81);
 display: none;
}
#frmReporte
{
  width: 600px;
  height:100vh;
  text-align: center;
  background: rgba(255,255,255,255.81);
}

</style>
  <div class="modal" id='reportes' style="overflow-y: scroll;">      
  <div class="bodymodal" >      
     
      <form  action ="" method ="post" name ="frmreporte" id="frmreporte">
            
              
      <h2 class = "tipodegasto"  align="center">Reporte de Antiguedad de Clientes</h1>
      <div align="right">  
         <a href="#" class="button blue">
         <button type="button" align="center" class="btn btn-default btn-lg active" onclick="coloseModal();"><i class="glyphicon glyphicon-remove"></i> </button>    
      </div> 
       <label>CLIENTES MENOR DE 3 AÑOS DE ANTIGUEDAD</label>
        <div style="overflow:scroll; height: 200px" onscroll="OnScrollDiv(this)" id="DivMainContent ">
         <div class="table-responsive">
          <table class="table">
           <thead>
            <tr>
             <th>NOMBRE</th>
             <th>FECHA</th>
            </tr>
            </thead>
            <tbody id="mitabla1">               
           </tbody>
           
         </table>     
         </div>
       </div>  
       <label>CLIENTES DE ENTRE 3 Y 5 AÑOS DE ANTIGUEDAD</label>
       <div style="overflow:scroll; height: 200px" onscroll="OnScrollDiv(this)" id="DivMainContent ">
         <div class="table-responsive">
          <table class="table">
           <thead>
            <tr>
             <th>NOMBRE</th>
             <th>FECHA</th>
            </tr>
            </thead>
            <tbody id="mitabla2">               
           </tbody>
           
         </table>     
         </div>
       </div>  
        <label>CLIENTES DE ENTRE 5 Y 10 AÑOS DE ANTIGUEDAD</label>
       <div style="overflow:scroll; height: 200px" onscroll="OnScrollDiv(this)" id="DivMainContent ">
         <div class="table-responsive">
          <table class="table">
           <thead>
            <tr>
             <th>NOMBRE</th>
             <th>FECHA</th>
            </tr>
            </thead>
            <tbody id="mitabla3">               
           </tbody>
           
         </table>     
         </div>
       </div>  
       <label>CLIENTES DE ENTRE 10 Y 15 AÑOS DE ANTIGUEDAD</label>
       <div style="overflow:scroll; height: 200px" onscroll="OnScrollDiv(this)" id="DivMainContent ">
         <div class="table-responsive">
          <table class="table">
           <thead>
            <tr>
             <th>NOMBRE</th>
             <th>FECHA</th>
            </tr>
            </thead>
            <tbody id="mitabla4">               
           </tbody>
           
         </table>     
         </div>
       </div>  
         <label>CLIENTES MAYOR DE 15 AÑOS DE ANTIGUEDAD</label>
       <div style="overflow:scroll; height: 200px" onscroll="OnScrollDiv(this)" id="DivMainContent ">
         <div class="table-responsive">
          <table class="table">
           <thead>
            <tr>
             <th>NOMBRE</th>
             <th>FECHA</th>
            </tr>
            </thead>
            <tbody id="mitabla5">               
           </tbody>
           
         </table>     
         </div>
       </div>  
      <div id="chart_div" align="center"></div>
       <!-- Creamos la tabla de 3 años-->   
      
      <!-- <a href="#" class="btn_new" onclick="coloseModal();"><i class="fas fa-ban"></i>Cerrar</a> -->  
      
      </form>      
   </div>  

         
  </div> 


<script type="text/javascript">
  var entidadesGlobal=['',<?=implode(',', array_unique($entidadesArray,SORT_STRING))?>]
 let rankingGlobal=['',<?=implode(',', array_unique($rankingArray,SORT_STRING))?>];
  let options='';
  entidadesGlobal.forEach(function(val){options+=`<option>${val}</option>`;})
   document.getElementById('entidadesSelect').innerHTML=options;
   options="";
rankingGlobal.forEach(function(val){options+=`<option>${val}</option>`;})
 document.getElementById('rankingSelect').innerHTML=options;
 

</script>
<!--Termina Reporte-->
<script type="text/javascript">
	var idPunto="";
	var url="<?=base_url();?>";


function ordenaTabla(cellObjeto,tablaString){
    //var lista =objeto.parentNode.parentNode.parentNode;//document.getElementById("tableEstadoFinanciero");
//var respuesta=abrirGifEspera();



    var body=document.getElementById(tablaString);
    var n, i, k, aux;
    var formaOrdenar="";
    n = body.rows.length;
    var index=cellObjeto.cellIndex;
      if(cellObjeto.getAttribute('data-order')==''){formaOrdenar='Desc';}
   switch(cellObjeto.getAttribute('data-order')){
       case 'Desc':formaOrdenar='Asc';break;
       case 'Asc':formaOrdenar='Desc';break;
      default : formaOrdenar='Desc'; break;
   }
    if(cellObjeto.getAttribute('data-tipo')=='digito'){
  
    for (k = 1; k < n; k++) {
      if(formaOrdenar=='Desc'){
        for (i = 0; i < (n - k); i++) {  
              if(body.rows[i].classList.contains('verObjeto')){        
            if (parseFloat(body.rows[i].cells[index].getAttribute("data-valor") ) > parseFloat(body.rows[i+1].cells[index].getAttribute("data-valor"))){body.rows[i].parentNode.insertBefore(body.rows[i + 1], body.rows[i]);}
          }
        }
      
       }
       else{
                for (i = 0; i < (n - k); i++) {   
            if(body.rows[i].classList.contains('verObjeto')){             
            if (parseFloat(body.rows[i].cells[index].getAttribute("data-valor") ) < parseFloat(body.rows[i+1].cells[index].getAttribute("data-valor"))){body.rows[i].parentNode.insertBefore(body.rows[i + 1], body.rows[i]);}
          }
        }
       }
    }
    }
    else{
          for (k = 1; k < n; k++) {
              if(formaOrdenar=='Desc'){
        for (i = 0; i < (n - k); i++) {    
           if(body.rows[i].classList.contains('verObjeto')){
            if (body.rows[i].cells[index].innerHTML.toLowerCase() < body.rows[i+1].cells[index].innerHTML.toLowerCase()){body.rows[i].parentNode.insertBefore(body.rows[i + 1], body.rows[i]);}
          }
        }
      }else{
                 for (i = 0; i < (n - k); i++) {    
           if(body.rows[i].classList.contains('verObjeto')){
            if (body.rows[i].cells[index].innerHTML.toLowerCase() > body.rows[i+1].cells[index].innerHTML.toLowerCase()){body.rows[i].parentNode.insertBefore(body.rows[i + 1], body.rows[i]);}
           }
        }
      }
    }
    }
 cellObjeto.setAttribute('data-order',formaOrdenar);

 

}
function MuestraForma()
{
   $(".modal").fadeIn();   
       $.ajax({
    url: <?php echo('"'.base_url().'"');?>+'lealtadClientes/GetClientes',
     type: 'POST',
    async: true,
    //data:{act},
    success:function(response){
      //alert (response);
      var info = JSON.parse(response);   
       
      //var elmtTable = document.getElementById('mitabla1');  
      //var tableRows = elmtTable.getElementsByTagName('tr');
      //var rowCount = tableRows.length;
     
      for (var i=0; i<info.tres.length; i++) 
      {
        //console.log(info.tres[i].nombre);
        fila="<tr id = fila><td>"+info.tres[i].nombre+"</td><td>"+info.tres[i].fecha+"</td></tr>";
       var btn = document.createElement("TR");
          btn.innerHTML=fila;
         document.getElementById("mitabla1").appendChild(btn); 
      }
      for (var i=0; i<info.cinco.length; i++) 
      {
        //console.log(info.tres[i].nombre);
        fila="<tr id = fila><td>"+info.cinco[i].nombre+"</td><td>"+info.cinco[i].fecha+"</td></tr>";
       var btn = document.createElement("TR");
          btn.innerHTML=fila;
         document.getElementById("mitabla2").appendChild(btn); 
      }
      for (var i=0; i<info.diez.length; i++) 
      {
        //console.log(info.tres[i].nombre);
        fila="<tr id = fila><td>"+info.diez[i].nombre+"</td><td>"+info.diez[i].fecha+"</td></tr>";
       var btn = document.createElement("TR");
          btn.innerHTML=fila;
         document.getElementById("mitabla3").appendChild(btn); 
      }
       for (var i=0; i<info.quince.length; i++) 
      {
        //console.log(info.tres[i].nombre);
        fila="<tr id = fila><td>"+info.quince[i].nombre+"</td><td>"+info.quince[i].fecha+"</td></tr>";
       var btn = document.createElement("TR");
          btn.innerHTML=fila;
         document.getElementById("mitabla4").appendChild(btn); 
      }
       for (var i=0; i<info.mayquince.length; i++) 
      {
        //console.log(info.tres[i].nombre);
        fila="<tr id = fila><td>"+info.mayquince[i].nombre+"</td><td>"+info.mayquince[i].fecha+"</td></tr>";
       var btn = document.createElement("TR");
          btn.innerHTML=fila;
         document.getElementById("mitabla5").appendChild(btn); 
      }
      dibujaReporteCanal(info);    
    },
    error:function(error){
      console.log('error');
    }
   });
  // alert (datosv['tres']);
     
   

 }

 function coloseModal()
{
  
  $(".modal").fadeOut();
  document.getElementById('CargoGes').value = 0.0;
  var elmtTable = document.getElementById('mitabla'); 
  if(elmtTable !== null){
        while (elmtTable.hasChildNodes()){
            elmtTable.removeChild(elmtTable.lastChild);
        }
    }
 } 



google.charts.load('current', {'packages':['bar']});
google.charts.load("current", {packages:["corechart"]});
google.charts.load('current', {'packages':['line']});

function dibujaReporteCanal(info)
{
    var stres =0,scinco =0,sdiez =0,squince=0,smquince=0;  
   if(info.tres.length != '')
      stres = info.tres.length;
   if(info.cinco.length != '')
      scinco = info.cinco.length; 
    if(info.diez.length != '')
      sdiez = info.diez.length; 
    if(info.quince.length != '')
      squince = info.quince.length; 
    if(info.mayquince.length != '')
      smquince = info.mayquince.length; 
    
    var data = new google.visualization.DataTable();
        data.addColumn('string', 'Topping');
        data.addColumn('number', 'Slices');
        data.addRows([
          ['TRESAÑOS',stres],
          ['CINCOAÑOS',scinco],
          ['DIEZAÑOS', sdiez],
          ['QUINCEAÑOS', squince],
          ['MASQUINCEAÑOS', smquince]
         // ['QUINCEAÑOS', info.quince.length],
         // ['MAYOQUINCE', info.mayorquince.length]
        ]);
        var options = {'title':'Antiguedad de Clientes',
                       'width':400,
                       'height':500};

  var chart = new google.visualization.PieChart(document.getElementById('chart_div'));
  chart.draw(data,options );  
}





function buscarEnTabla(inputObjeto,tablaString)
{
        var texto = inputObjeto.value.toUpperCase();
        let textoCliente=texto.replace(/ /g, "");//inputObjeto.value.toUpperCase();
        var tabla=document.getElementById(tablaString);
      var r=0;
      var totalRows=tabla.rows.length;
    let count=0;
  if(tablaString=='bodyConsultarPuntos')
  {
    if(texto==''){for(var i=0;i<totalRows;i++){tabla.rows[i].classList.remove('nombre');count++; }}
  else{
      for(var i=0;i<totalRows;i++)
      {  let nombre=tabla.rows[i].dataset.nombre.toUpperCase();

       if(nombre.indexOf(textoCliente)>=0){tabla.rows[i].classList.remove('nombre')}
       else{tabla.rows[i].classList.add('nombre');}

      }
     }
     //document.getElementById('footTablaConsultarPuntos').innerHTML=count;
  }
  else{
  if(texto==''){for(var i=0;i<totalRows;i++){tabla.rows[i].classList.remove('ocultarObjeto');tabla.rows[i].classList.add('verObjeto'); }}
  else{ 
      for(var i=0;i<totalRows;i++)
      {       
        if ( tabla.rows[i].innerText.toLowerCase().indexOf(texto) !== -1 )
         {  tabla.rows[i].classList.remove('ocultarObjeto');tabla.rows[i].classList.add('verObjeto'); }
        else
          { tabla.rows[i].classList.add('ocultarObjeto');tabla.rows[i].classList.remove('verObjeto'); }
      }
     }
   }
 }
	 function filtrarTablas(objeto){
 	var contenido=objeto.parentNode.previousSibling.childNodes[1];
 	var bodyContenido=contenido.childNodes[1];
 	var cabecera=objeto.parentNode.previousSibling.previousSibling.childNodes[0];
 	var bodyCabecera=cabecera.childNodes[1];
 	var cantidad=contenido.childNodes[1].childNodes.length;
 	var texto=objeto.value.toLowerCase();

 	for(var i=0;i<cantidad;i++){
 		 if(bodyContenido.childNodes[i].innerText.toLowerCase().indexOf(texto) !== -1){
 		 	bodyContenido.childNodes[i].style.display=null;
 		 	bodyCabecera.childNodes[i].style.display=null;
 		 }
 		 else{bodyContenido.childNodes[i].style.display='none';bodyCabecera.childNodes[i].style.display='none';}
 	}
 	//console.log(contenido.childNodes[1].childNodes.length);console.log(cabecera.childNodes[1].childNodes.length);
 }
 function consultarPuntosCanjeados(IDCli){
	//alert(IDCli);
		crearObjetosParaForm(IDCli,'formGeneral','IDCli');
	enviarFormGenerales('formGeneral','lealtadClientes/consultarPuntosCanjeados');
}
function agregarRanking(){
	crearObjetosParaForm(document.getElementById('clienteRanking').value,'formGeneral','clienteRanking');
	enviarFormGenerales('formGeneral','lealtadClientes/agregarRanking');
}
function eliminarRanking(id){
	crearObjetosParaForm(id,'formGeneral','idClienteRanking');
enviarFormGenerales('formGeneral','lealtadClientes/eliminarRanking');
}
function modificarRanking(id){
	crearObjetosParaForm(document.getElementById('inputRango1'+id).value,'formGeneral','rango1');
	crearObjetosParaForm(document.getElementById('inputRango2'+id).value,'formGeneral','rango2');
	crearObjetosParaForm(id,'formGeneral','idClienteRanking');
enviarFormGenerales('formGeneral','lealtadClientes/modificarRanking');
}
function generaPDFRecibo(IDTicket,IDCli){
	//alert(IDCli);
	crearObjetosParaForm(IDTicket,'formGeneral','IDTicket');
		crearObjetosParaForm(IDCli,'formGeneral','IDCli');
	enviarFormGenerales('formGeneral','lealtadClientes/generaPDFRecibo');
}
function calcularRanking(){enviarFormGenerales('formGeneral','lealtadClientes/calcularRanking');	
}
function consultarHistorial(IDCli){

		crearObjetosParaForm(IDCli,'formGeneral','IDCli');
	enviarFormGenerales('formGeneral','lealtadClientes/consultarHistorial');

}
function productos(IDCli){
		crearObjetosParaForm(IDCli,'formGeneral','IDCli');
	enviarFormGenerales('formGeneral','lealtadClientes/productos');

}
function exportarBitacora(){
enviarFormGenerales('formGeneral','lealtadClientes/exportarBitacora');	
}
function exportarHistorial(IDCli){
	crearObjetosParaForm(IDCli,'formGeneral','IDCli');
	
	enviarFormGenerales('formGeneral','lealtadClientes/exportarHistorial');
}
function exportarSeleccionProductos(IDCli){
	crearObjetosParaForm(IDCli,'formGeneral','IDCli');	
	enviarFormGenerales('formGeneral','lealtadClientes/exportarSeleccionProductos');
}
function consultarPuntosOtorgados(IDCli){
		crearObjetosParaForm(IDCli,'formGeneral','IDCli');
	enviarFormGenerales('formGeneral','lealtadClientes/consultarPuntosOtorgados');
}
function consultarPuntosPorAgente(){
	crearObjetosParaForm(document.getElementById("selectAgentesConsultaPuntos").value,'formGeneral','idPersona');
	enviarFormGenerales('formGeneral','lealtadClientes/buscarPuntosPorAgente');
}
function otorgarPuntos(){
	var cbOtorgar=document.getElementsByClassName('cbClientes');	
	rowActivo=document.getElementsByClassName("rowActivo");
	if(rowActivo.length>0){
	var cantidad=cbOtorgar.length;
	var IDCli="";
	for(var i=0;i<cantidad;i++){
      if(cbOtorgar[i].checked){
       IDCli=IDCli+cbOtorgar[i].value
       var nombreCliente=cbOtorgar[i].parentNode.previousSibling.innerHTML;
       IDCli=IDCli+"|"+nombreCliente;
       IDCli=IDCli+";";
      }
	}
	crearObjetosParaForm(IDCli,'otorgarPuntos',"IDCli");
	crearObjetosParaForm(rowActivo[0].cells[2].innerHTML,'otorgarPuntos',"PUNTOS");
	crearObjetosParaForm(rowActivo[0].cells[0].innerHTML,'otorgarPuntos',"IDPUNTOS");
	crearObjetosParaForm(document.getElementById('selectAgentesClub').value,'otorgarPuntos',"idPersona");
	enviarFormGenerales('otorgarPuntos','lealtadClientes/otorgarPuntos');
  }else{alert("Escoger una promocion");}

}
function guardaPromocionAgente(){
 var activados=document.getElementsByClassName('classActivaPromocion');
 var cant=activados.length;
 cad='';
 for(var i=0;i<cant;i++){
if(activados[i].parentNode.parentNode.parentNode.parentNode.parentNode.id=='DivMainContent'){
 	cad=cad+activados[i].id+";"; }}
 //var datos="";
// datos="idPunto=1&idPersona="+cad;
 //direccion=url+"lealtadClientes/guardaPromocionAgentes";	
 crearObjetosParaForm('1','otorgarPuntos',"idPunto");
 crearObjetosParaForm(cad,'otorgarPuntos',"idPersona");
 enviarFormGenerales('otorgarPuntos','lealtadClientes/guardaPromocionAgentes')
  //mandaAJAX(direccion,datos,"agentesPermiso");
}
function enviarFormGenerales(clase,controlador){
  var direccion=<?php echo('"'.base_url().'";'); ?>;
  var idForm=<?php echo('"'.$idFormEnvio.'";')?>
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
   objeto.setAttribute('value',idForm);
   objeto.setAttribute('name','idFormEnvio');
   objeto.setAttribute('type','hidden');
   formulario.appendChild(objeto);
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
}
 function cerrarModal(){
   document.getElementById("miModalGenerico").classList.add("modalCierraGenerico");
   document.getElementById("miModalGenerico").classList.remove("modalAbreGenerico");
   document.getElementById("ModalcontenidoGenerico").style.display="none";  
 }
 function abrirModal(){
document.getElementById("miModalGenerico").classList.remove("modalCierraGenerico");
  document.getElementById("miModalGenerico").classList.add("modalAbreGenerico");
   document.getElementById("ModalcontenidoGenerico").style.display="block";
 }

function escogePuntos(objeto){
	var rowOtorgaPuntos=document.getElementsByClassName("rowOtorgaPuntos");
	var cantidad=rowOtorgaPuntos.length;
	for(var i=0;i<cantidad;i++){rowOtorgaPuntos[i].classList.remove("rowActivo");}
	objeto.classList.add("rowActivo");

}
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
function desactivaCB(){
  var activados=document.getElementsByClassName('cbActivaPromo');
  var cant=activados.length;
  cad='';
 for(var i=0;i<cant;i++){
 	activados[i].checked=false;
    activados[i].classList.remove('classActivaPromocion')
 }
}
function mostrarComentarios(datos,IDCli){
  if(datos==''){
      if(document.getElementsByClassName('rowSeleccionado').length>0) {
         var params = 'IDCli='+IDCli;
         params = params+'&AJAX=1';
        controlador="lealtadClientes/comentarios/?";
          peticionAJAX(controlador,params,'mostrarComentarios');      
      }
  }
  else{
}
}
function consultarBitacoraDeCorreos(datos='')
{
 if(datos==='')
 {
    let params = '';
    params = params+'&AJAX=1';
    params = params+'&fechaInicial='+document.getElementById('fInicialBitacora').value;
    params = params+'&fechaFinal='+document.getElementById('fFinalBitacora').value;
    controlador="lealtadClientes/consultarBitacoraCorreos/?";
    peticionAJAX(controlador,params,'consultarBitacoraDeCorreos');     
 } 
 else
 {
  console.log(datos);
  let tablaP='<table border="1" class="table"><thead><tr><th colspan="3"><button onclick="cerrarModal()"" class="botonCierre">X</button></th></tr><tr><th colspan="3">CORREOS EN BANDEJA</th></tr><tr><th>PARA</th><th>FECHA CREACION</th><th>FECHA ENVIO</th></tr></thead>';
  let tablaE='<table border="1" class="table"><thead><tr><th colspan="3"><tr><th colspan="3">CORREOS ENVIADOS</th></tr><tr><th>PARA</th><th>FECHA CREACION</th><th>FECHA ENVIO</th></tr></thead>';
  let tablaPendiente='<tbody>'+tablaP;
  let tablaEnviados='<tbody>'+tablaE;
  let cantPendiente=datos.correosPendientes.length;
  let cantEnviados=datos.correosEnviados.length;
  for(let i=0;i<cantPendiente;i++)
  {
     tablaPendiente=tablaPendiente+'<tr><td>'+datos.correosPendientes[i].para+'</td>';
     tablaPendiente=tablaPendiente+'<td>'+datos.correosPendientes[i].fechaCreacion+'</td>';
     tablaPendiente=tablaPendiente+'<td></td>';
  }

  for(let i=0;i<cantEnviados;i++)
  {
     tablaEnviados=tablaEnviados+'<tr><td>'+datos.correosEnviados[i].para+'</td>';
     tablaEnviados=tablaEnviados+'<td>'+datos.correosEnviados[i].fechaCreacion+'</td>';
     tablaEnviados=tablaEnviados+'<td>'+datos.correosEnviados[i].fechaEnvio+'</td>';
  }
  
  tablaPendiente=tablaPendiente+'</tbody></table>';
  tablaEnviados=tablaEnviados+'</tbody></table>';
  document.getElementById('ModalcontenidoGenerico').innerHTML=tablaPendiente+'</br>'+tablaEnviados;
  abrirModal();
 }
}
function consultarProductos(datos='')
{
  if(datos=='')
 {
  if(comprobarClienteEscogido())
  {   
    var params = 'IDCli='+document.getElementsByClassName('rowSeleccionadoClientes')[0].dataset.idcli;
    params = params+'&AJAX=1';
    controlador="lealtadClientes/productos/?";
    peticionAJAX(controlador,params,'puntosCanjeados'); 
  }
 
 } 

}

function historial(datos='')
{
  if(datos=='')
 {
  if(comprobarClienteEscogido())
  {   
    var params = 'IDCli='+document.getElementsByClassName('rowSeleccionadoClientes')[0].dataset.idcli;
    params = params+'&AJAX=1';
    controlador="lealtadClientes/consultarHistorial/?";
    peticionAJAX(controlador,params,'puntosCanjeados'); 
  }
  
 } 

}

function puntosOtorgados(datos='')
{
  if(datos=='')
 {
  if(comprobarClienteEscogido())
  {   
    var params = 'IDCli='+document.getElementsByClassName('rowSeleccionadoClientes')[0].dataset.idcli;
    params = params+'&AJAX=1';
    controlador="lealtadClientes/consultarPuntosOtorgados/?";
    peticionAJAX(controlador,params,'puntosCanjeados'); 
  }
  
 }
 

}
function puntosCanjeados(datos='')
{
 if(datos=='')
 {
  if(comprobarClienteEscogido())
  {
   
    let params = 'IDCli='+document.getElementsByClassName('rowSeleccionadoClientes')[0].dataset.idcli;
         params = params+'&AJAX=1';
        controlador="lealtadClientes/consultarPuntosCanjeados/?";
       peticionAJAX(controlador,params,'puntosCanjeados'); 
  }
  
 }
 else
 {
  
  document.getElementById('ModalcontenidoGenerico').innerHTML=datos;
  abrirModal();
 }
}
function comprobarClienteEscogido()
{
  cant=document.getElementsByClassName('rowSeleccionadoClientes').length;
  if(cant>0){return true;}
  else{alert('ESCOGE UN CLIENTE')}
  return false;
}
function peticionAJAX(controlador,parametros,funcion)
{
  var req = new XMLHttpRequest();var direccionAJAX="<?= base_url();?>";
  var url=direccionAJAX+controlador;    
  req.open('POST', url, true);
  req.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
  req.onreadystatechange = function (aEvt) 
  {
  if (req.readyState == 4){ if(req.status == 200){var respuesta=JSON.parse(this.responseText);window[funcion](respuesta);}}
  }
  req.send(parametros);
}
function mandaAJAX(url,datos,manejoRespuesta){
 var xhttp = new XMLHttpRequest();
  xhttp.onreadystatechange = function() {
    if (this.readyState == 4 && this.status == 200) {     
    	switch (manejoRespuesta){
    		case 'agentesPermiso': 
            var respuesta=JSON.parse(this.responseText);
            alert(respuesta);
    		break;
    	}
    }
  };
  xhttp.open("POST", url, true);
  xhttp.setRequestHeader("Content-type","application/x-www-form-urlencoded");
  xhttp.send(datos);
}
function activaPromocion(objeto){
  if(objeto.checked){objeto.classList.add('classActivaPromocion');}
  else{objeto.classList.remove('classActivaPromocion');}
}
function selecRow(){
	//RECIBIA UN ROW COMO OBJETO	
	idPunto=1;
	 direccion=url+"lealtadClientes/buscaAgentePromocion";
	 cadPromocion="idPunto="+idPunto;	 
    buscaAgentesPromocionAJAX(direccion,cadPromocion);
	
}
function buscaAgentesPromocionAJAX(direccion,id){
	 var req = new XMLHttpRequest();	 
  req.open('POST',direccion, true);
    req.setRequestHeader("Content-type","application/x-www-form-urlencoded");
   req.onreadystatechange = function (aEvt) 
  {
    if (req.readyState == 4) {if(req.status == 200)
    {

       var respuesta=JSON.parse(this.responseText);
       var cant=respuesta.length;
       desactivaCB();
       for(var i=0;i<cant;i++) {
       	//respuesta[i].idPersonaP);
       	document.getElementById(respuesta[i].idPersonaP).checked=true;
       	document.getElementById(respuesta[i].idPersonaP).classList.add("classActivaPromocion");
       }                                             
      }     
   }
  };
 req.send(id);
}

function cambiaFiltro(objeto){if(objeto.nextSibling.childNodes[1].checked){}else{}}
function aplicarFiltro(objeto,combo){
	var nombreCombo="";
	switch(combo)
	{
      case 0: sCombo="selectAgente";break;
      case 1: sCombo="selectRanking";break;
	}
	var index=objeto.parentNode.parentNode.cellIndex;
	var cant=objeto.parentNode.parentNode.parentNode.parentNode.rows.length;
   for(var j=1;j<cant;j++)
    {
    	text=objeto.parentNode.parentNode.parentNode.parentNode.rows[j].cells[index].innerHTML;
    	var cadena="";
    	cadena=document.getElementById(sCombo).value;
      if(text.indexOf(cadena)>=0){
      	objeto.parentNode.parentNode.parentNode.parentNode.rows[j].classList.add('verObjeto');objeto.parentNode.parentNode.parentNode.parentNode.rows[j].classList.remove('ocultarObjeto');

      	}
      else{ objeto.parentNode.parentNode.parentNode.parentNode.rows[j].classList.add('ocultarObjeto'); objeto.parentNode.parentNode.parentNode.parentNode.rows[j].classList.remove('verObjeto');}
      }
    
}
function seleccionarRow(row)
{
  tabla=row.parentNode;
  if(document.getElementsByClassName('rowSeleccionadoClientes').length>0)
  {
   document.getElementsByClassName('rowSeleccionadoClientes')[0].classList.remove('rowSeleccionadoClientes'); 
  }
  row.classList.add('rowSeleccionadoClientes');
}
document.getElementById("tablaAgentes").innerHTML= <?php  echo("'".$tablaAgentes."'");?>;
//selecRow();
<?php
$selectAgentesClub="";
$todos='<option value="-1">TODOS</option>';
foreach ($agentesClub as  $value) {
	$selectAgentesClub=$selectAgentesClub.'<option value="'.$value->idPersonaP.'">';
	$selectAgentesClub=$selectAgentesClub.$value->nombres.' '.$value->apellidoPaterno.' '.$value->apellidoMaterno.'</option>';
?>
   document.getElementById(<?php echo('"'.$value->idPersonaP.'"') ?>).checked="true";
   document.getElementById(<?php echo('"'.$value->idPersonaP).'"' ?>).classList.add("classActivaPromocion");
<?
}
?>
document.getElementById("selectAgentesClub").innerHTML=<?php echo("'".$selectAgentesClub."'");?>;
document.getElementById("selectAgentesConsultaPuntos").innerHTML=<?php echo("'".$todos.$selectAgentesClub."'");?>;
<?php
$row='<thead><tr><th>ID </th><th>NOMBRE </th><th>CANTIDAD</th></tr></thead><tbody>';
$rowCrearPuntos='<thead><tr><th>ID</th><th>NOMBRE</th><th>CANTIDAD</th><th>Opciones</th><th>Eliminar</th></tr></thead><tbody>';

if(isset($ver)){
	foreach($ver as $fila){
  
  $rowCrearPuntos=$rowCrearPuntos.'<tr>';
  $rowCrearPuntos=$rowCrearPuntos.'<td>'.$fila->IDPUNTO.'</td>';
  $rowCrearPuntos=$rowCrearPuntos.'<td>'.$fila->TIPO.'</td>';
  $rowCrearPuntos=$rowCrearPuntos.'<td align="right">'.$fila->PUNTO.'</td>';
  $rowCrearPuntos=$rowCrearPuntos.'<td><a href="'.base_url().'lealtadClientes/mod/'.$fila->IDPUNTO.'">Modificar</a></td>';
  if($fila->IDPUNTO>6){
  $rowCrearPuntos=$rowCrearPuntos.'<td><a href="'.base_url().'lealtadClientes/eliminar/'.$fila->IDPUNTO.'">Eliminar</a></td>';$row=$row.'<tr onclick="escogePuntos(this)" class="rowOtorgaPuntos">';
  $row=$row.'<td>'.$fila->IDPUNTO.'</td>';
  $row=$row.'<td>'.$fila->TIPO.'</td>';
  $row=$row.'<td align="right">'.$fila->PUNTO.'</td>';
  $row=$row.'</tr>';}
  else{
  	$rowCrearPuntos=$rowCrearPuntos.'<td></td>';
  }

  $rowCrearPuntos=$rowCrearPuntos.'</tr>';

    }
}
$row=$row.'</tbody>';$rowCrearPuntos=$rowCrearPuntos.'</tbody>';
echo('document.getElementById("tableAsignarPuntos").innerHTML=\''.$row.'\';');
echo('document.getElementById("tableCrearPuntos").innerHTML=\''.$rowCrearPuntos.'\';');
$tablaClientes="";
if(isset($clientesPorAgente)){
  // $tablaClientes='<table ID=\'tableOtorgarPuntos\' border=\'2\' class=\'tablaAgentesClass table\'>';
      $tablaClientes=$tablaClientes.'<thead><tr><th>IDCli</th><th>Nombre</th><th></th></tr></thead>';
	foreach ($clientesPorAgente as  $value) {
		$tablaClientes=$tablaClientes.'<tr>';
		$tablaClientes=$tablaClientes.'<td>'.$value['IDCli'].'</td>';
		$tablaClientes=$tablaClientes.'<td>'.$value['NombreCompleto'].'</td>';
		$tablaClientes=$tablaClientes.'<td><input class="cbClientes" type="checkbox" value="'.$value['IDCli'].'"></td>';
		$tablaClientes=$tablaClientes.'</tr>';
	}	
  echo('document.getElementById("tableOtorgarPuntos").innerHTML=\''.$tablaClientes.'\';');
	//$tablaClientes=$tablaClientes.'</table>';

}

?>
<?php
function imprimeTablaCabecera(){

 $tabla='<table border="1" class="table" id="tablaConsultarPuntos"><thead><tr><th  onclick=\'ordenaTabla(this,"tablaConsultarPuntos")\' data-tipo="string" data-order="Desc"><label>Nombre</label><div></div></th><th  onclick=\'ordenaTabla(this,"tablaConsultarPuntos")\' data-tipo="string" data-order="Desc">Ranking</th><th  data-tipo="digito" onclick=\'ordenaTabla(this,"tablaConsultarPuntos")\' data-order="Desc">Puntos</th><th >Entidad</th><th  ><input type="checkbox" style="margin-left:45%" onclick="activarClientesEnvioPuntos(this)"></th></tr></thead>';
 return $tabla;
}
function imprimneTablaCuerpo($puntosDeLosClientes)
{
  
$puntoClientes="";

$puntosClientes.='<table border="1" class="table" id="tablaConsultarPuntos"><thead style="position:sticky;top:0px"><tr><th  onclick=\'ordenaTabla(this,"tablaConsultarPuntos")\' data-tipo="string" data-order="Desc"><label>Nombre</label><div><input class="inputFiltra form-control" placeholder="Buscar" onchange="buscarEnTabla(this,\'bodyConsultarPuntos\')"></div></th><th  onclick=\'ordenaTabla(this,"tablaConsultarPuntos")\' data-tipo="string" data-order="Desc"><label>Ranking</label><div><select id="rankingSelect" class="form-control" onchange="filtroTablaPuntos(this)" data-filtro="ranking"></select></div></th><th  data-tipo="digito" onclick=\'ordenaTabla(this,"tablaConsultarPuntos")\' data-order="Desc"><label>Entidad</label><div><select id="entidadesSelect" class="form-control" onchange="filtroTablaPuntos(this)" data-filtro="entidad"></select></div></th><th >Puntos</th><th  ><input type="checkbox" style="margin-left:45%" onclick="activarClientesEnvioPuntos(this)"></th></tr></thead>';
  $puntosClientes.='<tbody id="bodyConsultarPuntos">';
  $count=0;
  //$fp=fopen('resultadoJason.txt','w');fwrite($fp,print_r($puntosDeLosClientes,true));fclose($fp);
 foreach ($puntosDeLosClientes as  $value) 
 {

      $entidad=$value->tipoEntidad;
      $ranking=$value->clienteRanking;

   
      if($value->tipoEntidad!='Fisica' && $value->tipoEntidad!='Moral'){ $entidad="S/E";}
      if($value->clienteRanking==''){$ranking="S/R";}
   

  $count++;
  $puntosClientes.='<tr  data-nombre="'.str_replace(' ','',$value->nombre).'" data-idcli="'.$value->IDCli.'" onclick="seleccionarRow(this)" data-ranking="'.$ranking.'" data-entidad="'.$entidad.'">';
    $puntosClientes.='<td>'.$value->nombre.'</td>';
    $puntosClientes.='<td>'.$ranking.'</td>';
    $puntosClientes.='<td>'.$entidad.'</td>';
  $puntosClientes.='<td  data-valor="'.$value->puntosObtenidos.'" align="right">'.$value->puntosObtenidos.'</td>';
  $puntosClientes.='<td align="center"><input type="checkbox" class="btnTabla cbEnviaCorreoPuntos" value="'.$value->IDCli.'"><br></td>';
  $puntosClientes.='</tr>';
  
 }
 $puntosClientes.='</tbody></table>';

return $puntosClientes;
}


 $ranking="";
 $ranking='<thead><tr><td>Ranking</td><td>Rango 1</td><td>Rango 2</td><td></td></tr></thead><tbody>';
 foreach ($rankingCliente as $value) {
 	$ranking=$ranking.'<tr>';
    $ranking=$ranking.'<td>'.$value->clienteRanking.'</td>';
    $ranking=$ranking.'<td><input id=\'inputRango1'.$value->idClienteRanking.'\' value=\''.$value->rango1.'\'></td>';
    $ranking=$ranking.'<td><input id=\'inputRango2'.$value->idClienteRanking.'\' value=\''.$value->rango2.'\'></td>';
    $ranking=$ranking.'<td><button onclick=\'modificarRanking('.$value->idClienteRanking.')\'>Guardar</button></td>';
    $ranking=$ranking.'<td><button onclick=\'eliminarRanking('.$value->idClienteRanking.')\'>Eliminar</button></td>';
 	$ranking=$ranking.'</tr>';
 }
 $ranking=$ranking.'</tbody>';
echo('document.getElementById(\'tableRanking\').innerHTML="'.$ranking.'";');
?>
	

<?php if(isset($idPersona)){?> document.getElementById('selectAgentesClub').value=<?php echo($idPersona);?>;
 document.getElementById('selectAgentesConsultaPuntos').value=<?php echo($idPersona);?>
<?php } ?>;  
manejoMenu('divAgentes')
<?php if(isset($mod)){?>
 function cerrar(){
   document.getElementById("miModal").classList.add("modalCierra");
   document.getElementById("miModal").classList.remove("modalAbre");
   document.getElementById("Modalcontenido").style.display="none";  
 }
 function abrir(){
document.getElementById("miModal").classList.remove("modalCierra");
  document.getElementById("miModal").classList.add("modalAbre");
   document.getElementById("Modalcontenido").style.display="block";
 }
abrir();
<?php }?>
<?php
if(isset($tablaCanjePuntos)){
 echo('document.getElementById(\'ModalcontenidoGenerico\').innerHTML="'.$tablaCanjePuntos.'";');
 echo('abrirModal();');
}
if(isset($productosDeCanje)){
 echo('document.getElementById(\'ModalcontenidoGenerico\').innerHTML="'.$productosDeCanje.'";');
 echo('abrirModal();');
}
?>



<?php if(isset($pestania)){ ?> manejoMenu(<?php echo('"'.$pestania.'"'); ?>); <?php } ?>


</script>
<style type="text/css">
  .entidad{display: none}
  .ranking{display: none}
  .nombre{display: none}
</style>
<script type="text/javascript">
function filtroTablaPuntos(obj)
{
  let rows=document.getElementById('bodyConsultarPuntos').rows;
  let tipoFiltro=obj.dataset.filtro;
  let valor=obj.value;
  for(let r of rows)
  { 
    if(valor!='')
    {
    if(r.getAttribute(`data-${tipoFiltro}`)!=valor){r.classList.add(tipoFiltro)}
    else{r.classList.remove(tipoFiltro)}
    }
   else{r.classList.remove(tipoFiltro)}
  }

}
	 function borrarNodosText(elemento){
 	for(var i=0;i<document.getElementById(elemento).childNodes.length;i++){if(document.getElementById(elemento).childNodes[i].nodeName=="#text"){document.getElementById(elemento).removeChild(document.getElementById(elemento).childNodes[i]);}}}

	function MakeStaticHeader(gridId, height, width, headerHeight, isFooter,cabecera,contenido,pie) {
        var tbl = document.getElementById(gridId);
        //var tr=

        if (tbl) {
        //var DivHR = document.getElementById('DivHeaderRow');
        //var DivMC = document.getElementById('DivMainContent');
        //var DivFR = document.getElementById('DivFooterRow');
        var DivHR = document.getElementById(cabecera);
        var DivMC = document.getElementById(contenido);
        var DivFR = document.getElementById(pie);
        if(tbl.childNodes.length>0){
        var cant=tbl.rows[0].cells.length;
        var rowNuevo=document.createElement('tr');
        var cellNuevo=document.createElement('td');
        var input=document.createElement('input');
        input.setAttribute('class','inputFiltra');
        input.setAttribute('placeholder','Buscar');
        input.setAttribute('onchange','filtrarTablas(this)');
        cellNuevo.appendChild(input);
        cellNuevo.setAttribute('colspan',cant);        
        //cellNuevo.setAttribute('contenteditable','true');   
        rowNuevo.appendChild(cellNuevo);
        ////tbl.childNodes[0].insertBefore(rowNuevo,tbl.childNodes[0].childNodes[0]);

        tbl.parentNode.nextSibling.insertBefore(input,tbl.parentNode.nextSibling.childNodes[0]);
        //tbl.childNodes[0]
        
        }
        //*** Set divheaderRow Properties ****
        DivHR.style.height = headerHeight + 'px';
        DivHR.style.width = (parseInt(width) - 16) + 'px';
        DivHR.style.position = 'relative';
        DivHR.style.top = '0px';
        DivHR.style.zIndex = '10';
        DivHR.style.verticalAlign = 'top';
        
        //*** Set divMainContent Properties ****
        DivMC.style.width = width + 'px';
        DivMC.style.height = height + 'px';
        DivMC.style.position = 'relative';
        //headerHeight=headerHeight-25;
        DivMC.style.top = -headerHeight + 'px';
        DivMC.style.zIndex = '0';

        //*** Set divFooterRow Properties ****
        DivFR.style.width = (parseInt(width) - 16) + 'px';
        DivFR.style.position = 'relative';
        DivFR.style.top = -headerHeight + 'px';
        DivFR.style.verticalAlign = 'top';
        DivFR.style.paddingtop = '2px';

        if (isFooter) {
         var tblfr = tbl.cloneNode(true);
      tblfr.removeChild(tblfr.getElementsByTagName('tbody')[0]);
         var tblBody = document.createElement('tbody');
         tblfr.style.width = '100%';
         tblfr.cellSpacing = "0";
         //*****In the case of Footer Row *******
         tblBody.appendChild(tbl.rows[tbl.rows.length - 1]);
         tblfr.appendChild(tblBody);
         DivFR.appendChild(tblfr);
         }
        //****Copy Header in divHeaderRow****
        //elemento.classList.add('form-control');
        //elemento.classList.add('selcls') ; 
        //elemento.setAttribute('placeholder','Buscar');
       // DivHR.appendChild(elemento);


        DivHR.appendChild(tbl.cloneNode(true));
     }
    }




    function OnScrollDiv(Scrollablediv) {
    document.getElementById('DivHeaderRow').scrollLeft = Scrollablediv.scrollLeft;
    document.getElementById('DivHeaderRowTC').scrollLeft = Scrollablediv.scrollLeft;
    document.getElementById('DivHeaderRowAP').scrollLeft = Scrollablediv.scrollLeft;
    document.getElementById('DivHeaderRowC').scrollLeft = Scrollablediv.scrollLeft;
    document.getElementById('DivHeaderRowCP').scrollLeft = Scrollablediv.scrollLeft;

    //document.getElementById('DivFooterRow').scrollLeft = Scrollablediv.scrollLeft;
    }

    window.onload = function() {
   MakeStaticHeader('tablaAgentes', 400, 1050, 40, false,'DivHeaderRow','DivMainContent','DivFooterRow');
   MakeStaticHeader('tablePuntosPorCliente', 400, 1050, 40, false,'DivHeaderRowTC','DivMainContentTC','DivFooterRowTC');
   MakeStaticHeader('tableAsignarPuntos', 400, 400, 40, false,'DivHeaderRowAP','DivMainContentAP','DivFooterRowAP');
   MakeStaticHeader('tableOtorgarPuntos', 400, 650, 40, false,'DivHeaderRowC','DivMainContentC','DivFooterRowC');
      MakeStaticHeader('tableCrearPuntos', 400, 650, 40, false,'DivHeaderRowCP','DivMainContentCP','DivFooterRowCP');
   //MakeStaticHeader('tablePuntosPorCliente', 100, 1050, 40, false);
}
borrarNodosText('DivRootC');borrarNodosText('DivRoot');borrarNodosText('DivRootCP');borrarNodosText('DivRootTC');borrarNodosText('DivRootAP');
borrarNodosText('DivHeaderRow');borrarNodosText('DivHeaderRowC');borrarNodosText('DivHeaderRowCP');borrarNodosText('DivHeaderRowAP');borrarNodosText('DivHeaderRowTC');
borrarNodosText('DivMainContent');borrarNodosText('DivMainContentC');borrarNodosText('DivMainContentCP');borrarNodosText('DivMainContentAP');borrarNodosText('DivMainContentTC');

  function moverScroll(){
   var elmnt = document.getElementById("scrollTabla");
    var x = elmnt.scrollLeft;
document.getElementById("scrollCabecera").scrollLeft=x;
}

</script>

<?php $this->load->view('footers/footer'); ?>
<style type="text/css">
  .verObjeto{display: inline-table;}
  .ocultarObjeto{display: none;}
  .tableLealtad{border:double;}
  .tableLealtad tr:hover {opacity: .5}
  .promocionSeleccionada{color:green;}
  .tablaAgentesClass{margin-left:0%;}
  .divPrincipal{width: 100%}
  .divMenu{width: 12%; float: left; height: 350px;border: none}
  .divContenido{width: 90% ;height: 600px }
  .buttonMenu{border-color: #472380; clear: both;height: 140px;width: 100%;background-color: white; color:black;margin-top: 5%}
  .buttonMenu>label{color:black;background-color: #361866;font-weight: bold;position: relative;top:2.5px;left: 50%;width: 100%;height: auto;border:none;transform: rotate(90deg);text-decoration: underline;}
  .divAgenteClass{display: none; margin-left: 25%}
  .verObjeto{display: block;}
  .ocultarObjeto{display: none} 
  .rowOtorgaPuntos:hover{background: #7aec72}
  .rowActivo{background-color: green}
  .modal-contenido{background-color:none  ;width:30%;height:400px;padding: 2% 10%;margin: 5% auto;position: relative;z-index: 1000 } 
    .modalCierra{background-color: rgba(0,0,0,.8);position:fixed;top:0;right:0;bottom:0px;left:0;opacity:0;transition: all 1s;display:none;relative;z-index: 1000}
    .modalAbre{background-color: rgba(0,0,0,.8);position:fixed;top:0;right:0;bottom:0px;left:0;transition: all 1s;width:100%;height:100%;display:block;relative;z-index: 1000}
    .inputFiltra{width: 100%}
    .tableGenerico{border:5px double #361866 ;width:1000px; float:left; position:relative; top:0px; left:0px; background-color: white;color:black; height: 10px}
    .tableGenerico > thead{background-color: #472380;color:white;}
    .tableGenerico > tfoot{background-color: #bdb6b6;color:black;}
    .botonCierre{background-color: red;color:white;}
    .modal-contenidoGenerico{background-color:white;display: none; ;width:1000px;height:400px; overflow:scroll;left: 0%;margin: 5% auto;position: relative;z-index: 1000 } 
    .modalCierraGenerico{background-color: rgba(0,0,0,.8);position:fixed;top:0;right:0;bottom:0px;left:0;opacity:0;transition: all 1s;display:none;relative;z-index: 1000}
    .modalAbreGenerico{background-color: rgba(0,0,0,.8);position:fixed;top:0;right:0;bottom:0px;left:0;transition: all 1s;width:100%;height:100%;display:block;relative;z-index: 1000}
      
  .tablaCabecera{background-color:#472380; color: white}
  .divTD50{width:50px;max-width: 70px;min-width: 70px;}
  .divTD100{width:100px;max-width: 100px;min-width: 100px;}
  .divTD150{width:150px;max-width: 150px;min-width: 150px;}
  .divTD400{width:400px;max-width: 400px;min-width: 400px;}
  .btnTabla{background-color: #5cb85c; border:none;}
  .btnTabla:hover{color:white;}
  .gifEspera{position: absolute;left: 50%;top:70%;z-index: 100000}
  .rowSeleccionadoClientes{background-color: green}
#scrollTabla::-webkit-scrollbar:vertical{width: 13px}
#scrollTabla::-webkit-scrollbar:horizontal{width: 13px}
#scrollTabla::-webkit-scrollbar{border-radius: 0px}
#scrollTabla::-webkit-scrollbar-thumb {border-radius: 0px}
</style>