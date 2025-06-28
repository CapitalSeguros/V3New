<?php $this->load->view('headers/header'); ?>
<?php $this->load->view('headers/menu');?>
<script src="https://code.jquery.com/jquery-3.2.1.js"></script>
<script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.1/jquery.min.js"></script>
<script type="text/javascript">
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
    .buttonMenu {border-color: #472380;clear: both;height: 100px;max-width: 25%;background-color: white;color: black;min-width: 100px;
    }
    .labelButton{max-width: 10px; height: 50px; solid;margin:0%;position: relative;left: -50px}
 .deposito
 {   
   display:grid;
   grid-template-columns:repeat(3, 1fr);
  
 }
 .deposito-ano {
   display:flex;
   flex-direction:column;
   align-items:center;
   padding:1rem;
 }
 .deposito-ano label{
   color:black;
   font-size:1.8rem;
 }
 .deposito-mes label{
   color:black;
   font-size:1.8rem;
 }
 .deposito-afianzador label{
   color:black;
   font-size:1.8rem;
 }
 .deposito-ano select{
   width:15rem;
   height:2.5rem;
 }
 .deposito-mes select{
   width:15rem;
   height:2.5rem;
 }
 .deposito-afianzador select{
   width:15rem;
   height:2.5rem;
 }
 .deposito-mes {
   display:flex;
   flex-direction:column;
   align-items:center;
   padding:1rem;
 }
 .deposito-afianzador {
   display:flex;
   flex-direction:column;
   align-items:center;
   padding:1rem;
 }
 .deposito button {
   grid-column: 2 / 2;
   margin:0 18px;
   color:white;
 }
 .buscador-proveedor{
   width:500px;
   display:flex;
   justify-content:space-between;
   text-align:center;
   align-items:center:
 }
 .buscador-proveedor input
  {
   margin-right: 2rem;
   margin-top: 2.3rem;

 }
 .buscador-proveedor select{
    width: 43rem;
    margin-top: 2.4rem;
 }
 .buscador-proveedor label{
  height: 20px;
  margin-top: 2.4rem;
  margin-right: 0.5rem;
 }
 
 .contable
 {
   width:450px;
   display :flex;
   align-items:center; 
   margin:0;
   height: 50px;
   
 }
 .contable select{
  width:10rem;
  margin:10px 10px;
  height:30px;
 }
 .contable label{
   font-size:15px;
}
.boton-contable
{
  
  background-color:green;
  margin:20px auto;
   color:white;
  padding:8px 20px;
  
}
.contenedor-tabla
{
  margin-left:150px;
  width: 850px;
  height:200px
}
.tabla-propiedades
{
  width: 800px;
  border-collapse: collapse;
  margin-right:0px;
}
.tabla-propiedades tr{
  
}
.tabla-propiedades thead th{
  background-color:green;
  
}
.tabla-propiedades th{
 padding:2rem;
 color:white;
}
.tabla-propiedades tbody{
  width:100px;
}

.body-contable td {
    padding: 0.5rem;
    text-align:center;
    color:black;
}
.body-contable tr {
    border-bottom:1px solid black;
}
.body-contable  {
    border-left:1px solid black;
    border-right:1px solid black;
}
.completo{
  font-size:16px;
  color:green;
}
.completo:hover{
  cursor:pointer;
  color:blue;
}
.modalContable
{
    background-color: rgba(0,0,0,.8);
    position:fixed;
    display:none;
    height: 100vh;
    width: 100vw;
    transition: all .5s; 
          top: 0;
    right: 0;
    bottom: 0;
    left: 0;
    z-index: 1040;
    overflow: hidden;
    outline: 0;
}

.contenedor-modalcontable
{
  background-color: rgb(221, 241, 241);   
    align-items: center;   
    width: 800px;
    margin-left: auto;
    margin-right:auto;
    margin-top: 50px;
    height: 600px;
    overflow: scroll;
    overflow-y: scroll;
}
.bdydetalles{

}    
.bdydetalles td {
    padding: 0.5rem;
    text-align:center;
    color:black;
}
.bdydetalles tr {
    border-bottom:1px solid black;
}
.bdydetalles  {
    border-left:1px solid black;
    border-right:1px solid black;
}
.btncierra
{
  display: flex;
    justify-content: flex-end;   
    padding:5px;
    margin-right: 20px; 
    
}
.btncierra button{
 background-color:red;
}
.cabeceramodal
{
  text-align:center;
  border-bottom: 1px solid #fe4918;
  margin-top:0px;
}
.cabeceramodal h2 {
  padding: 1px 0;
}
.tbldetalleCuentas
{
  width: 100%;
  border-collapse: collapse;
  margin-right:0px; 
 
}
.tbldetalleCuentas thead{
  background-color:blue;
}
.tbldetalleCuentas th{
 padding:2rem;
 color:white;
}
.GastosEspeciales
{
  width:400px;
  margin-left:0;
  display:flex;
  justify-content:space-between;
  text-align:center;
  align-items:center;
  
}
.GastosEspeciales{
  padding:10px;
}
.ExportaGastos
{
  display:flex; 
  padding:20px 190px;
}
.ExportaGastos button{
  margin:0;
}
</style>
<div class="row">
 <div class="col-md-12 col-xs-12"> <h1 id="h1Titulo" class="titulo-secciones">Reporte de Presupuesto :Anual</h1><hr></div>

</div>
<div class="row">
  <div class="col-md-2 col-xs-2">
    <button class="buttonMenu" onclick="verDiv('divPresupuestoAnual','Anual')"><label>Presupuesto Anual</label></button><br>
    <button class="buttonMenu" onclick="verDiv('divGastosDepositos','Gastos y Depositos')">Gastos y Depositos</button><br>  
    <button class="buttonMenu" onclick="verDiv('divCanalesNegocio','Canales de  Negocios')">Canales de  Negocios</button><br>  
    <button class="buttonMenu" onclick="verDiv('divDepositoAseguradoras','Depositos por Aseguradoras')">Depositos por Aseguradoras</button><br>
    <button class="buttonMenu" onclick="verDiv('divEntreGastosDepositos','Entre Gasto y Deposito')">Entre Gasto y Deposito</button><br>
    <button class="buttonMenu" onclick="verDiv('divDepositos','Depositos')">Ingresos</button><br>
    <button class="buttonMenu" onclick="verDiv('divReporteEspecial','Reporte Especial')">Reporte Especial</button><br>
    <button class="buttonMenu" onclick="verDiv('divProveedor','Proveedor')">Proveedor</button><br>  
    <button class="buttonMenu" onclick="verDiv('divCuentasContables','Cuentas Contables')">Detalle de CC</button><br> 
    <button class="buttonMenu" onclick="verDiv('divGastosEspeciales','Gastos Especiales')">Gastos Especiales</button><br> 
  </div>
  <div class="col-md-8 col-xs-8">
    <div id="divPresupuestoAnual" class="divContenido verObjeto">
      
      <div>
      <form   id="formreferidos"  method="post"  action="<?=base_url()?>ReportePresupuesto/ReporteExcelPresupuesto" > 
       <div class="row">
        <div class="col-xs-4 col-md-4"> <label class="etiquetaLabel1"><h3>Año Del Reporte</h3></label> 
        <select name="ano" id="ano" required="" class="form-control" ><?= imprimirFecha() ?></select><button class="btn btn-success" onclick="mostrarPresupuestoAnual(event)">Buscar</button>      </div>
        </div>
      </form>
    
    </div>
   </div>
    <div id="divGastosDepositos" class="divContenido ocultarObjeto">
      <div class="row">
        
            <div class="col-xs-4 col-md-4"> 
              <label class="etiquetaLabel1"><h3>Año Del Reporte</h3></label> 
              <select name="anodepo" id="anodepo" required="" class="form-control"><?=  imprimirFecha()  ?></select>  
              <button class="btn btn-success" onclick="mostrarGastoDepositos('')">Buscar</button>      
            </div>
        
      </div>
      <div  id="divPaginaGastosDepositos" style="width: 100%;height: 400px;overflow: auto">
        
      </div>
    </div>
    <div id="divCanalesNegocio" class="divContenido ocultarObjeto">
      <div>
  
            <div class="col-xs-4 col-md-4"> 
              <label class="etiquetaLabel1"><h3>Año Del Reporte</h3></label> 
              <select name="anocanal" id="anocanal" required="" class="form-control"><?=  imprimirFecha()  ?></select>  
              <button class="btn btn-success" onclick="mostrarCanalesDeNegocios('')">Buscar</button>      
            </div>
      
      </div>
    <div  id="divPaginaCanalesDeNegocios" style="width: 100%;height: 400px;overflow: auto">
        
      </div>
    </div>
    <div id="divDepositoAseguradoras" class="divContenido ocultarObjeto">
      <div>
         
            <!--div class="col-xs-4 col-md-4"!--> 
              <div class = "deposito">
                 <div class="deposito-ano">
                   <label>Año Del Reporte</label> 
                   <select name="anodeposito" id="anodeposito" required=""><?=  imprimirFecha()  ?></select>  
                </div>
                <!--04-03-2021Agregamos el mes a escoger-->
                <div class="deposito-mes">                
                <label for="mesDeposito">Mes</label>
                <select name="mesDeposito" id="mesDeposito">
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
                 <div class="deposito-afianzador">
                  <label for="Afianzadora">Afianzadora/Aseguradora</label>
                   <select name="Afianzadora" id="Afianzadora">
                   <option  selected disabled value="">..Selecione al Tipo</option>
                   <option value="AFIANZADORA">AFIANZADORA</option>
                   <option value="ASEGURADORA">ASEGURADORA</option>              
                   </select>
                 </div>
              <!--/div-->  
              <button class="btn btn-success" onclick="mostrarDepositosPorAseguradoras('')">Buscar</button>      
            </div>
         </div>      
      <div  id="divPaginaDepositosPorAseguradoras" style="width: 100%;height: 400px;overflow: auto">
        
      </div>
    </div>
    <div id="divEntreGastosDepositos" class="divContenido ocultarObjeto">
    <div>
        
            <div class="col-xs-4 col-md-3"> 
              <label class="etiquetaLabel1"><h3>Del </h3></label> 
              <select name="anodepuno" id="anodepuno" required="" class="form-control"><?=  imprimirFecha()  ?></select>
            </div>
            <div class="col-xs-4 col-md-3"> 
          <label class="etiquetaLabel1"><h3>Al </h3></label> 
              <select name="anodepdos" id="anodepdos" required="" class="form-control"><?=  imprimirFecha()  ?></select> </div> 
           <div class="col-xs-8 col-md-2"><br><br><br>    
              <button class="btn btn-success"  onclick="mostrarEntreGastosDepositos('')">Buscar</button>      
            </div>
            </div>
         <div  id="divPaginaEntreGastosDepositos" style="width: 100%;height: 400px;overflow: auto">
        
      </div>
        
    </div>
        <div id="divDepositos" class="divContenido ocultarObjeto">
       <div>
    
            <div class="col-xs-4 col-md-3"> 
              <label class="etiquetaLabel1"><h3>Del </h3></label> 
              <select id="anogasuno" required="" class="form-control"><?=  imprimirFecha()  ?></select>
            </div>
            <div class="col-xs-4 col-md-3"> 
          <label class="etiquetaLabel1"><h3>Al </h3></label> 
              <select name="anodepdos" id="anogasdos" required="" class="form-control"><?=  imprimirFecha()  ?></select> </div> 
           <div class="col-xs-8 col-md-2"><br><br><br>    
              <button class="btn btn-success"  onclick="mostrarDepositos('')">Buscar</button>      
            </div>
            </div>
         <div  id="divPaginaDepositos" style="width: 100%;height: 400px;overflow: auto">
        
      </div>
        
    </div>
    <div id="divReporteEspecial" class="divContenido ocultarObjeto">
      
      <form  class="form-horizontal" role="formreferidos"
            id="formreferidos" name="formreferidos"> 
     
     </br>
      <div class="row">
        <div class="col-xs-3 col-md-3">
            <label class="etiquetaLabel1">Fecha </label> <?
              $fecha = date("Y-m-d"); //formato solo fecha
           ?>
            <input type="date"  name="fecha" id="fecha" class="form-control" value="<?php echo $fecha;?>"  required=""  >

         </div>   
          <div class="col-xs-3 col-md-3">
          <br><button class="btn btn-success" onclick="MuestraForma()" type="button">CEspecial</button>     
          </div>  
      </div>        
  
</form> 
    </div>
   </div> 
<div id="divProveedor" class="divContenido ocultarObjeto">
<form  class="form-horizontal" role="formreferidos"
            id="formreferidos" name="formreferidos">
   
      <div class="row">
          
         <!--div class="col-xs-3 col-md-3"-->
         <div class="buscador-proveedor">
          
           <label for="listaProveedor">Buscar</label>
           <input type="text" id='listaProveedor' name = "listaProveedor" onkeyup="onKeyUp(event)">
          
           <label >Provedor</label><select name="idprovee" id="idprovee"  required=""> 
           <option value="">Seleccione un Proveedor</option> 
              <? if(!empty($ListaProveedores))
              { foreach ($ListaProveedores->result() as $Registro) {  ?> 
                <option value="<?=$Registro->id ?>"  ><? print $Registro->NombreProveedor?> </option>
                <? }} else {?><option value="false">Proveedor No encontrado !!!</option><?}?>          
            </select>          
            </div> 
          <!--/div-->       
          <br>
          <div class="col-xs-3 col-md-3">
             <button class="btn btn-success" onclick="MuestraFormaProveedor()" type="button">Proveedores</button>     
          </div>  
      </div>    
   </form> 
   </div>  
    <!--16-03.2021-->
    <div id="divCuentasContables" class="divContenido ocultarObjeto">      
      <div class="contable">
        <label for="">Selecione El Año</label>
        <select name="anocontable" id="anocontable" required=""><?= imprimirFecha() ?></select>
        <label for="">Mes</label>
        <select name="mescontable" id="mescontable" disableb select>
        <option disableb select value=""> --Selecione</option>
        <option value="1">Enero</option>
        <option value="2">Febrero</option>
        <option value="3">Marzo</option>
        <option value="4">Abril</option>
        <option value="5">Mayo</option>
        <option value="6">Junio</option>
        <option value="7">Julio</option>
        <option value="8">Agosto</option>
        <option value="9">Septiembre</option>
        <option value="10">Octubre</option>
        <option value="11">Noviembre</option>
        <option value="12">Diciembre</option>        
        </select>
      </div>
      <div class="contable">
      <button class="boton-contable" onclick="mostrarCuentasContable()">Buscar</button>  
      <input type="hidden" id="idapertura" name ="idapertura">    
       <!--div class="col-xs-4 col-md-4"> <label class="etiquetaLabel1"><h3>Seleciona El Año</h3></label> 
       <select name="ano" id="ano" required="" class="form-control" ><?= imprimirFecha() ?></select><button class="btn btn-success" onclick="mostrarPresupuestoAnual(event)">Buscar</button>      </div-->
       </div>
       <!--div class="contenedor-tabla"-->
       <table class="tabla-propiedades" id="tabla-contable" >
       <thead>
        <tr>
        <th>MontoFianza</th>
        <th>MontoSeguros</th>
        <th>MontoGestion</th>
        <th>MontoCorporativo</th>
        <th>TotalFactura</th>
        <th>Contables</th>
        <th>MontoMes</th>
        <th>Detalle</th>
        </tr>
       </thead>
       <tbody id="tablecontactos" class="body-contable">
       </tbody>
       </table>
       <!--/div-->
     </div>
    <!--Termina-->  
    <!--Gastos especiales-->
     
    <div id="divGastosEspeciales" class="divContenido ocultarObjeto">  
    <form  class="form-horizontal" role="formreferidos"
            id="formreferidos" name="formreferidos"
            method="post" 
            action="<?=base_url()?>ReportePresupuesto/exportaGastos" >
      <div class="GastosEspeciales">
        <p>Gastos Del</p>
         <input type="date" name="fechagastos1" id= "fechagastos1">
         <p>Al</p>
         <input type="date"name="fechagastos2" id= "fechagastos2">
      </div> 
      <div class="ExportaGastos">
      <button class="boton-contable" onclick="">Exportar</button>  
      </div>
    </div> 
    </form>  
    <!--Termina Gastos Especiales-->
 </div>
 
</div>
<form  class="form-horizontal" role="formreferidos"
            id="formreferidos" name="formreferidos"
            method="post" 
            action="<?=base_url()?>ReportePresupuesto/ReporteExcelPresupuesto" > 
     
<section class="container-fluid breadcrumb-formularios ocultarObjeto">
   </br>
    <div class="row">
            <div  class="col-md-3 col-sm-3 col-xs-3"><h4 class="titulo-secciones">Reporte de Presupuesto</h4></div>
              </br>
   <div id="DivRoot" align="left">
    <div style="overflow: hidden;" id="DivHeaderRow">
    </div>
    </br>
    <div id="DivRoot" align="left">
    </div>
     </br>
    <label class="etiquetaLabel1"> &nbsp;&nbsp;</label>
            <label class="etiquetaLabel1">Año Del Reporte</label> 
              <select name="ano" id="ano" required="" class="etiquetasimple" onChange="imprimirValor()">
            <?php for($i=2018;$i<=date("Y");$i++){echo "<option value='".$i."'>".$i."</option>";}
           ?>
              </select>  
    
    
     <label class="etiquetaLabel1"> &nbsp;&nbsp;</label>
       <input type="submit" name="Generar"  id="button" value=" Reporte de Presupuesto Anual" align="center"   style="background:#43BD55;color: #FFFFFF;"
              class="glyphicon glyphicon-file btn btn-sucess bullet bullet-verde"     target="_blank"     onclick="">      
     
     </div>
     </div> 
  </section> 
</form> 
<form  class="form-horizontal" role="formreferidos"
            id="formreferidos" name="formreferidos"
            method="post" 
            action="<?=base_url()?>ReportePresupuesto/reportebarras" > 
     
<section class="container-fluid breadcrumb-formularios ocultarObjeto">
     </br>
   
            <label class="etiquetaLabel1">Año Del Reporte</label> 
              <select name="anodepo" id="anodepo" required="" class="etiquetasimple" onChange="">
            <?php
           for($i=2018;$i<=date("Y");$i++){echo "<option value='".$i."'>".$i."</option>";}
           ?>
              </select>  
    
     
          <input type="submit" name="Generar"  id="button" value=" Reporte de Gastos y Depositos" align="center"   style="background:#43BD55;color: #FFFFFF;"
              class="glyphicon glyphicon-file btn btn-sucess bullet bullet-verde"          onclick="">      
     
     </div>
     </div> 
  </section> 
</form> 
<form  class="form-horizontal" role="formreferidos"
            id="formreferidos" name="formreferidos"
            method="post" 
            action="<?=base_url()?>ReportePresupuesto/reportecanal" > 
     
<section class="container-fluid breadcrumb-formularios ocultarObjeto">
     </br>
   
            <label class="etiquetaLabel1">Año Del Reporte</label> 

              <select name="anocanal" id="anocanal" required="" class="etiquetasimple" onChange="">
            <?php

           for($i=2018;$i<=date("Y");$i++)
           {
             echo "<option value='".$i."'>".$i."</option>";
            }
           ?>
              </select>  
    
      
          <input type="submit" name="Generar"  id="button" value=" Reporte de Canales de Negocio" align="center"   style="background:#43BD55;color: #FFFFFF;"
              class="glyphicon glyphicon-file btn btn-sucess bullet bullet-verde"          onclick="">      
     
     </div>
     </div> 
  </section> 
</form> 
<section class="col-xs-3 col-md-3">
<form  class="form-horizontal ocultarObjeto" role="formreferidos"
            id="formreferidos" name="formreferidos"
            method="post" 
            action="<?=base_url()?>ReportePresupuesto/reportexdeposito" >  
            </br>
             <label class="etiquetaLabel1"> &nbsp;&nbsp;</label>

            <label class="etiquetaLabel1">Año Del Reporte</label> 

              <select name="anodeposito" id="anodeposito" required="" class="etiquetasimple" onChange="">
            <?php

           for($i=2018;$i<=date("Y");$i++)
           {
             echo "<option value='".$i."'>".$i."</option>";
            }
           ?>
              </select>      
                    <label class="etiquetaLabel1"> &nbsp;</label>
          <input type="submit" name="Generar"  id="button" value="Despositos Por Aseguradora" align="center"   style="background:#43BD55;color: #FFFFFF;"
              class="glyphicon glyphicon-file btn btn-sucess bullet bullet-verde"          onclick="">      
     
     </div>
     </div> 
     </form> 
  </section> 

<form  class="form-horizontal" role="formreferidos"
            id="formreferidos" name="formreferidos"
            method="post" 
            action="<?=base_url()?>ReportePresupuesto/reportelinealuno" > 
     
<section class="container-fluid breadcrumb-formularios ocultarObjeto">
     </br>
   
            <label class="etiquetaLabel1">Año Del </label> 

              <select name="anodepuno" id="anodepuno" required="" class="etiquetasimple" onChange="">
            <?php

           for($i=2018;$i<=date("Y");$i++)
           {
             echo "<option value='".$i."'>".$i."</option>";
            }
           ?>
              </select>  

            <label class="etiquetaLabel1">Al </label> 
    
        <select name="anodepdos" id="anodepdos" required="" class="etiquetasimple" onChange="">
            <?php

           for($i=2018;$i<=date("Y");$i++)
           {
             echo "<option value='".$i."'>".$i."</option>";
            }
           ?>
              </select>  
          <input type="submit" name="Generar"  id="button" value=" Reporte Entre Gasto y Depositos" align="center"   style="background:#43BD55;color: #FFFFFF;"
              class="glyphicon glyphicon-file btn btn-sucess bullet bullet-verde"          onclick="">      
     
     </div>
     </div> 
  </section> 
</form> 
<form  class="form-horizontal" role="formreferidos"
            id="formreferidos" name="formreferidos"
            method="post" 
            action="<?=base_url()?>ReportePresupuesto/reportelinealdos" > 
     
<section class="container-fluid breadcrumb-formularios ocultarObjeto">
     </br>
   
            <label class="etiquetaLabel1">Año Del </label> 

              <select name="anogasuno" id="anogasuno" required="" class="etiquetasimple" onChange="">
            <?php

           for($i=2018;$i<=date("Y");$i++)
           {
             echo "<option value='".$i."'>".$i."</option>";
            }
           ?>
              </select>  

            <label class="etiquetaLabel1">Al </label> 
    
        <select name="anogasdos" id="anogasdos" required="" class="etiquetasimple" onChange="">
            <?php

           for($i=2018;$i<=date("Y");$i++)
           {
             echo "<option value='".$i."'>".$i."</option>";
            }
           ?>
              </select>  
          <input type="submit" name="Generar"  id="button" value=" Reporte de Despositos " align="center"   style="background:#43BD55;color: #FFFFFF;"
              class="glyphicon glyphicon-file btn btn-sucess bullet bullet-verde"          onclick="">      
     
     </div>
     </div> 
  </section> 
</form> 


<style>
.modal
{
 position: fixed; 
 width: 100%;
 height:100vh;
 background: rgba(0,0,0,0.81);
 display: none;
}
.bodymodal
{
  width: 100%;
  height: 100%;
  display: -webkit-inline-flex;
 display: -moz-inline-flex;
  display: -ms-inline-flex;
  display: -o-inline-flex;
  display: inline-flex;
  justify-content: center;
  align-items: center;
  
}
#frmReporte
{
  width: 600px;
  text-align: center;
  background: rgba(255,255,255,255.81);
}
.modal h2
{
  color :#0E7250;
  text-transform: uppercase;
}
.parent-div img {
   width: 24px;
   height: 24px;
}

</style>
<div class="modal" id='report'>      
  <div class="bodymodal">      
      <form  action ="" method ="post" name ="frmReporte" id="frmReporte" onsubmit="event.preventDefault(); sendDataProduct();">           
              
      <h2 class = "tipodegasto"  align="center">Prueba</h1>
                  
         <!-- tabla de cuentas de los gastos-->  
       <div style="overflow:scroll; height: 200px" onscroll="OnScrollDiv(this)" id="DivMainContent ">
         <div class="table-responsive">
          <table class="table">
           <thead>
            <tr>
             <th>BANCO</th>
             <th>TPO CUENTA</th>
             <th>SAL ANT</th>
             <th>DEPOSITOS</th>
             <th>TRAN,CHEQ,CAGS</th>
             <th>SAL ACT</th>
            </tr>
            </thead>
            <tbody id="mitabla">               
           </tbody>
           
         </table>     
         </div>
       </div>  
         
       <a href="#" class="button blue">
              <button type="button" class="btn btn-default btn-lg active" onclick="coloseModal();"><i class="glyphicon glyphicon-remove"></i> </button>
      </form>      
   </div>     
  </div> 

<div class="modal" id='modprove'>      
  <div class="bodymodal">      
      <form  action ="" method ="post" name ="frmReporte" id="frmReporte" onsubmit="event.preventDefault(); sendDataProduct();">           
              
      <h2 class = "tipodegasto"  align="center">Prueba</h1>
                  
         <!-- tabla de cuentas de los gastos-->  
         <div style="overflow:scroll; height: 200px" onscroll="OnScrollDiv(this)" id="DivMainContent ">
         <div class="table-responsive">
          <table class="table">
           <thead>
            <tr>
             <th>FOLIO</th>
             <th>FECHA</th>
             <th>TOTAL</th>
             <th>PAGO</th>             
            </tr>
            </thead>
            <tbody id="mitabla2">               
           </tbody>
           
         </table>     
         </div>
       </div>  
         
       <a href="#" class="button blue">
              <button type="button" class="btn btn-default btn-lg active" onclick="coloseModal();"><i class="glyphicon glyphicon-remove"></i> </button>
      </form>      
   </div>     
  </div> 

  <div class="modalContable" id='modal-Contable'>      
  <div class="bodymodal">    
  <div class="contenedor-modalcontable">   
         <div class="btncierra">
         <button class ="cierra-modalTarea" onclick="cierramodalContable()"><i class="fas fa-times"></i></button>             
        </div>
        <div class="cabeceramodal">
          <h2>Detalle de Cuentas</h2>
        </div> 
          <table class="tbldetalleCuentas" id="tblcontable">
           <thead>
            <tr>
             <th>FOLIO</th>
             <th>FIANZAS</th>
             <th>INSTITUCIONAL</th>
             <th>GESTION</th>     
             <th>COOPORATIVO</th>         
             <th>TOTAL</th> 
             <th>CCONTABLE</th> 
            </tr>
            </thead>
            <tbody id="bdydetalleCuentas" class="bdydetalles">               
           </tbody>           
         </table>
    </div>     
  </div>   
  </div> 
  
      <!--form  action ="" method ="post" name ="frmReporte" id="frmReporte" onsubmit="event.preventDefault(); sendDataProduct();">           
              
      <h2 class = "tipodegasto"  align="center">Prueba</h1>
            
         <div style="overflow:scroll; height: 200px" onscroll="OnScrollDiv(this)" id="DivMainContent ">
         <div class="table-responsive">
          <table class="table">
           <thead>
            <tr>
             <th>FOLIO</th>
             <th>FECHA</th>
             <th>TOTAL</th>
             <th>PAGO</th>             
            </tr>
            </thead>
            <tbody id="mitabla2">               
           </tbody>
           
         </table-->     
         </div>       
   </div>     
  </div> 



<script type="text/javascript">
  /**huricm 09-03-2021 */
  /*eventListener();
  function eventListener()
  {
    var el = document.getElementById('id');
    console.log(el);
    if(el)
    {
    document.querySelector('#id').addEventListener('click',muestraDetalle);
    }
  }*/
function cierramodalContable()
{
  $(".modalContable").fadeOut();
}


  function muestraDetalle(e)
  {
    //e.preventDefault();
    //console.log(e.target.parentElement.parentElement);
    var nom = e.target.parentElement.parentElement;
    let anoconta= document.querySelector('#anocontable').value;//$('#anocontable').value;
    let mesconta= document.querySelector('#mescontable').value;
    let apertura= document.querySelector('#idapertura').value; 
    
    console.log(apertura);
 
   if(nom.id > 0)
    {
             xhr = new XMLHttpRequest();
             datos = new FormData();
             datos.append('ano',anoconta);
             datos.append('mes',mesconta);
             datos.append('apertura',apertura); 
             datos.append('id',nom.id); 
             xhr.open('POST',"<?php echo base_url();?>ReportePresupuesto/devuelvedetalleContables",true);
             xhr.onload = function(){
             if(xhr.status ===200)
               {
                var respuesta = JSON.parse(xhr.responseText);
                //console.log(respuesta);
                
                 var borratabla = document.getElementById('tblcontable');
                 var rowCount = borratabla.rows.length; 
                for (var x=rowCount-1; x>0; x--) { 
                  borratabla.deleteRow(x); 
                  }

                  for(let i = 0; i < respuesta.length; i++) {
                     var fila="<tr><td>"+respuesta[i]['folio_factura']+"<tr><td>"+respuesta[i]['fianzas']+"</td><td>"+respuesta[i]['intitucional']+"</td><td>"+respuesta[i]['gestion']+"</td><td>"+respuesta[i]['coorporativo']+"</td><td>"+respuesta[i]['total']+"</td><td>"+respuesta[i]['cuentaContable']+"</td>";
                     var btn = document.createElement("TR");
                      btn.innerHTML=fila;
                     document.getElementById("bdydetalleCuentas").appendChild(btn); 
                    }
                    $(".modalContable").fadeIn(); 
               } 
              }
               xhr.send(datos);
    }
  }
 function onKeyUp(e)
 {
  const buscaProveedor = $('#listaProveedor').val();
  var select=document.getElementById("idprovee");
  console.log(buscaProveedor);
  for(var i=1;i<select.length;i++)
	{
    if(select.options[i].text !="")
    {
      //if(registros.childNodes[1].text.replace(/\s/g," ").search(buscaProveedor)!= -1)
    if(select.options[i].text.includes(buscaProveedor))
	  	{
			  console.log(select.selectedIndex);
			  //select.selectedIndex=i;
        //if(select.options[i].text.length == buscaProveedor.length)
        //{
          select.selectedIndex=i;
          return;      
        //}
		 }
     
    }
	}
  //$("#idprovee option:selected").text()=buscaProveedor;
 }
 /*********************** */
 function mostrarCuentasContable()
 {
   //console.log('llego');anocontable
    let anoconta= document.querySelector('#anocontable').value;//$('#anocontable').value;
    let mesconta= document.querySelector('#mescontable').value;
    //comprobamos si exite el cierre
    //document.querySelector('#idapertura').value()    
    
    xhr = new XMLHttpRequest();
 
     datos = new FormData();
     datos.append('ano',anoconta);
     xhr.open('POST',"<?php echo base_url();?>ReportePresupuesto/devuelveAnoContable",true);
    
    xhr.onload = function(){
      
         if(xhr.status ===200)
         {
           var respuesta = JSON.parse(xhr.responseText);
           //console.log(respuesta);
           if(respuesta >0)
           {
             $("#idapertura").val(respuesta);
             xhr1 = new XMLHttpRequest();
             datos = new FormData();
             datos.append('ano',anoconta);
             datos.append('mes',mesconta);
             datos.append('apertura',respuesta); 
             xhr1.open('POST',"<?php echo base_url();?>ReportePresupuesto/devuelveCuentasContables",true);
             xhr1.onload = function(){
             if(xhr1.status ===200)
               {
                var respuesta1 = JSON.parse(xhr1.responseText);
                //console.log(respuesta1);
                 var borratabla = document.getElementById('tabla-contable');
                 var rowCount = borratabla.rows.length; 
                for (var x=rowCount-1; x>0; x--) { 
                  borratabla.deleteRow(x); 
                  }

                  for(let i = 0; i < respuesta1.length; i++) {
                     var fila="<tr><td>"+respuesta1[i]['fianzas']+"</td><td>"+respuesta1[i]['intitucional']+"</td><td>"+respuesta1[i]['gestion']+"</td><td>"+respuesta1[i]['coorporativo']+"</td><td>"+respuesta1[i]['total']+"</td><td>"+respuesta1[i]['contabilidad']+"</td><td>"+respuesta1[i]['monto']+"</td><td id ='"+respuesta1[i]['id']+"'> <a class='identifica' onclick='muestraDetalle(event)' ><i  class='far fa-check-circle completo'></i> </a></td></tr>";
                     var btn = document.createElement("TR");
                      btn.innerHTML=fila;
                     document.getElementById("tablecontactos").appendChild(btn); 
                    }
                 }  
                }
               xhr1.send(datos);
            }
         }
    }
    xhr.send(datos);
    //console.log(anoconta);
 }
 /*********************** */
 function ExportarGastos()
 {
  
  let fechagastos1= document.querySelector('#fechagastos1').value;
  let fechagastos2= document.querySelector('#fechagastos2').value;
  //console.log(fechagastos1);
  //console.log(fechagastos2);
             xhr1 = new XMLHttpRequest();
             datos = new FormData();
             datos.append('fecha1',fechagastos1);
             datos.append('fecha2',fechagastos2);
            // datos.append('apertura',respuesta); 
             xhr1.open('POST',"<?php echo base_url();?>ReportePresupuesto/exportaGastos",true);
             xhr1.onload = function(){
              if(xhr1.status ===200)
               {
                //var respuesta1 = JSON.parse(xhr1.responseText);
                //console.log(respuesta1);
               }
             }
             xhr1.send(datos);       
 }
/**termina 09-03-2021 */
  function exportarPresupuestoAnual(datos)
  {
     if(datos=='')
    {
      let params='';
      params=params+'anocanal='+document.getElementById('ano').value;
      params=params+'&ajax=1';
      controlador="ReportePresupuesto/ReporteExcelPresupuesto/?";
      peticionAJAX(controlador,params,'exportarPresupuestoAnual');   
    }
    else{
      
      
    }  
  }

  function mostrarDepositos(datos)
  {
   if(datos=='')
    {
      let params='';
      params=params+'anogasuno='+document.getElementById('anogasuno').value;
      params=params+'&anogasdos='+document.getElementById('anogasdos').value;
      params=params+'&ajax=1';
      controlador="ReportePresupuesto/reportelinealdos/?";
      peticionAJAX(controlador,params,'mostrarDepositos');   
    }
    else
    {
      dibujaDepositos(datos);
    }

  }

  function mostrarDepositosPorAseguradoras(datos)
  {
  // console.log(datos); 
   if(datos=='')
    {
      let params='';
      params=params+'anodeposito='+document.getElementById('anodeposito').value;
      params=params+'&mesdeposito='+document.getElementById('mesDeposito').value;
      params=params+'&tipodeposito='+document.getElementById('Afianzadora').value;
      params=params+'&ajax=1';
      controlador="ReportePresupuesto/reportexdeposito/?";
      peticionAJAX(controlador,params,'mostrarDepositosPorAseguradoras');   
    }
    else
    {
      dibujarReportePorAseguradoras(datos);
    }

  }
  function mostrarEntreGastosDepositos(datos)
  {
   if(datos=='')
    {
      let params='';
      params=params+'anodepuno='+document.getElementById('anodepuno').value;
      params=params+'&anodepdos='+document.getElementById('anodepdos').value;
      params=params+'&ajax=1';
      controlador="ReportePresupuesto/reportelinealuno/?";
      peticionAJAX(controlador,params,'mostrarEntreGastosDepositos');   
    }
    else{dibujaEntreGastosDepositos(datos);}    
  }
  function mostrarCanalesDeNegocios(datos)
  {
   if(datos=='')
    {
      let params='';
      params=params+'anocanal='+document.getElementById('anocanal').value;
      params=params+'&ajax=1';
      controlador="ReportePresupuesto/reportecanal/?";
      peticionAJAX(controlador,params,'mostrarCanalesDeNegocios');   
    }
    else{dibujaReporteCanal(datos);}
  }
  function mostrarGastoDepositos(datos)
  {
    if(datos=='')
    {
      let params='';
      params=params+'anodepo='+document.getElementById('anodepo').value;
      params=params+'&ajax=1';
      controlador="ReportePresupuesto/reportebarras/?";
      peticionAJAX(controlador,params,'mostrarGastoDepositos');   
    }
    else{drawChart(datos);}
  }
  function verDiv(VisibleDiv,titulo=null)
  {
    let div=document.getElementsByClassName('divContenido');

    let cantDiv=div.length;
    for(let i=0;i<cantDiv;i++){div[i].classList.add('ocultarObjeto');div[i].classList.remove('verObjeto');}
      document.getElementById(VisibleDiv).classList.remove('ocultarObjeto');
    document.getElementById(VisibleDiv).classList.add('verObjeto');
  document.getElementById('h1Titulo').innerHTML='Reporte de Presupuesto :'+titulo;

  }
function cargarPagina(controlador,div)
{ 
   if(controlador!="")
   {  
    //  document.getElementById('imgEspera').classList.toggle('ocultarObjeto');
    // document.getElementById('imgEspera').classList.toggle('verObjeto');      
      var xhr=new XMLHttpRequest();url=<?='"'.base_url().'"'?>+controlador;xhr.open('POST',url,true);
        xhr.onload=function()
        {
          if(this.status==200)
          {
            //document.getElementById('imgEspera').classList.toggle('ocultarObjeto');
            if(<?='"'.base_url().'auth/login"'?>==xhr.responseURL){window.location.replace(xhr.responseURL);}
           //document.getElementById('imgEspera').classList.toggle('verObjeto');
           //divContenido.innerHTML=xhr.responseText;
           document.getElementById(div).innerHTML=xhr.responseText;
           document.getElementById('s').innerHTML=document.getElementById('k').innerHTML;
          }
       }
        xhr.send();
    }
}

</script>

<?php
function imprimirFecha()
{ $option="";

  for($i=date("Y");$i>=2018;$i--){ $option.="<option value='".$i."'>".$i."</option>";}
    return $option;
}
?>
<style type="text/css">
  .modal-contenidoGenerico{background-color:none  ;width:90%;height:100%;left: 20%;margin: 5% auto;position: relative;z-index: 1000 } 
    .modalCierraGenerico{background-color: rgba(0,0,0,.8);position:fixed;top:0;right:0;bottom:0px;left:0;opacity:0;transition: all 1s;display:none;relative;z-index: 1000}
    .modalAbreGenerico{background-color: rgba(0,0,0,.8);position:fixed;top:0;right:0;bottom:0px;left:0;transition: all 1s;width:100%;height:100%;display:block;relative;z-index: 1000}
    .botonCierre{background-color: red;color:white;}
    .contenidoModal{border: solid; color: black; background-color: white;width: 50%;height: 50%}
    .infoModal{position: relative; left: 0%;top: 30%}
    .labelModal{color: red;background-color: white; font-size: 18px;}
    .botonCancelar{border-left: 5px;left: 40%;position: relative;}
    .buttonMenu{width: 80%}
     .buttonMenu:hover {background: green}
    .buttonMenu > label{width: 60%}
    .subContenido{display: none}
    .ocultarObjeto{display: none}
    .verObjeto{display: block;}
</style>
   <script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>
   
 <script src="https://code.jquery.com/jquery-3.2.1.js"></script>
<script type="text/javascript">
  

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


 google.charts.load('current', {'packages':['bar']});
 google.charts.load("current", {packages:["corechart"]});
 google.charts.load('current', {'packages':['line']});
      function drawChart(datos) {
       let cantDatos=datos.Asig.length;        
        var dataArray=[['meses','gastos','depositos']]
        /*for(let i=0;i<cantDatos;i++){dataArray.push([datos.Asig[i].mes,{ v : datos.Asig[i].gasto ,f:"'$ "+ datos.Asig[i].gasto+"'" ,datos.Asig[i].deposito]);
        }
        //{ v: 12345, f: '$12,345' }*/
        var gasto=0; deposito =0;
        for(let i=0;i<cantDatos;i++){
           gasto=0; deposito =0;
          if((datos.Asig[i].gasto)== null)
          {             
          gasto = 0.00;
          }
          else
          {
            gasto = (datos.Asig[i].gasto).replace(',','');

          }
          if((datos.Asig[i].deposito)== null)
          {             
          deposito = 0.00;
          }
          else
          {
            deposito = (datos.Asig[i].deposito).replace(',','');

          }
          dataArray.push([datos.Asig[i].mes,gasto,deposito]);
          //dataArray.push([datos.Asig[i].mes,datos.Asig[i].gasto,datos.Asig[i].deposito]);
         // console.log(gasto+', '+deposito); 
         /* if((datos.Asig[i].gasto)== null)
          {
           console.log('0.0 , '+datos.Asig[i].deposito); 
          }
           else
           { 
          console.log((datos.Asig[i].gasto).replace(',','') +' , '+datos.Asig[i].deposito);
          }*/
        }
        var data = google.visualization.arrayToDataTable(dataArray);             
        var options = {chart: {title: 'Depositos y Gastos',subtitle: '',},
        bars: 'vertical',
         vAxis: {
          title: 'Depositos (Pesos)',
          format: '$#',
          minValue: 0,
          maxValue: 100000
        }
        };
       var chart = new google.charts.Bar(document.getElementById('divPaginaGastosDepositos'));
        chart.draw(data, google.charts.Bar.convertOptions(options));

   

      }
function dibujaReporteCanal(datos)
{
  let cantDatos=datos.Asig.length;                  
  var dataArray=[['Gastos','Canal']];
  for(let i=0;i<cantDatos;i++)
  {
    dataArray.push(['Fianzas',datos.Asig[i].Fianzas]);
    dataArray.push(['Institucional',datos.Asig[i].Institucional]);
    dataArray.push(['Coorporativo',datos.Asig[i].Coorporativo]);
  }
  var data = google.visualization.arrayToDataTable([['Gastos','Canal'],['Fianzas',parseFloat(datos.Asig[0].Fianzas)],['Institucional',parseFloat(datos.Asig[0].Institucional)],['Coorporativo',parseFloat(datos.Asig[0].Coorporativo)]]);   
   //var options = {chart: {title: 'Depositos y Gastos',subtitle: '',}};          
  var options = {title: 'GASTOS ENTRE CANALES DE NEGOCIO',is3D: true,};
  var chart = new google.visualization.PieChart(document.getElementById('divPaginaCanalesDeNegocios'));
  chart.draw(data,options );  
}
function dibujarReportePorAseguradoras(datos)
{
  let cantDatos=datos.Asig.length;                  
  var dataArray=[['Gastos','Canal']];
  
    var data = new google.visualization.DataTable(); 
    data.addColumn('string', 'Canal');
    data.addColumn('number', 'Gastos'); 
    
  for(let i=0;i<cantDatos;i++){data.addRow([datos.Asig[i].promo,parseFloat(datos.Asig[i].total)]); }

   var options = {title: 'DEPOSITOS POR ASEGURADORA',is3D: true,};
   new google.visualization.PieChart(document.getElementById('divPaginaDepositosPorAseguradoras')). 
    draw(data,options );
  
}
function dibujaEntreGastosDepositos(datos)
{
  
  let mes=["Enero","Febrero","Marzo","Abril","Mayo","Junio","Julio","Agosto","Septiembre","Octubre","Noviembre","Diciembre"];
  var data = new google.visualization.DataTable();

  data.addColumn('string', 'Mes');
  data.addColumn('number', datos.ano[0]);
  data.addColumn('number', datos.ano[1]);
  for(let i=0;i<12;i++){data.addRow([mes[i],{v:+parseFloat(datos.valor[datos.ano[0]][i]),f:"'$ "+parseFloat(datos.valor[datos.ano[0]][i]) },{v:+parseFloat(datos.valor[datos.ano[1]][i]),f:"'$ "+parseFloat(datos.valor[datos.ano[1]][i])}   ]); }
  
      var options = {
        chart: {
          title: 'COMPARACION DE GASTOS ENTRE AÑOS ANTERIORES',
          subtitle: ''
        },
        width: 880,
        height: 380,
        vAxis: {
          title: 'Depositos (Pesos)',
          format: '$#,###.##'
        },
        axes: {
          x: {
            0: {side: 'top'}
          }
        }
      };
          var chart = new google.charts.Line(document.getElementById('divPaginaEntreGastosDepositos'));
      chart.draw(data, google.charts.Line.convertOptions(options));
  
}
function dibujaDepositos(datos)
{
    let mes=["Enero","Febrero","Marzo","Abril","Mayo","Junio","Julio","Agosto","Septiembre","Octubre","Noviembre","Diciembre"];
  var data = new google.visualization.DataTable();

  data.addColumn('string', 'Mes');
  data.addColumn('number', datos.ano[0]);
  data.addColumn('number', datos.ano[1]);
  for(let i=0;i<12;i++){data.addRow([mes[i],parseFloat(datos.valor[datos.ano[0]][i]),parseFloat(datos.valor[datos.ano[1]][i])]); }
  
      var options = {
       chart: {
          title: 'Comparacion Entre Deposito',
          subtitle: 'En Pesos'
        },
        width: 880,
        height: 380,
         vAxis: {
          title: 'Depositos (Pesos)',
          format: '$#,###.##'
        },
        axes: {
          x: {
            0: {side: 'top'}
          }
        }
      };
          var chart = new google.charts.Line(document.getElementById('divPaginaDepositos'));
      chart.draw(data, google.charts.Line.convertOptions(options));
}
</script>
<script type="text/javascript">
function MuestraFormaProveedor()
{
  
   var cod = document.getElementById("idprovee").value;
   var combo = document.getElementById("idprovee");
   var selected = combo.options[combo.selectedIndex].text;
    $('.tipodegasto').html(selected);
   $("#modprove").fadeIn();
 
   $.ajax({
    url: <?php echo('"'.base_url().'"');?>+'ReportePresupuesto/reporteProveedor',
    type: 'POST',
    async: true,
    data:{action:cod},
    success:function(response){
 
      var info = JSON.parse(response);
 
      
      var str =""; 
      for (var i=0; i<info.length; i++) 
      {
       
        str = info[i].folio_factura;
        if(str != null){
        str = str.replace(/ /g, "");
         }
        
         fila="<tr id = fila> <td>"+str+"<td>"+info[i].fecha_factura+"</td><td>"+parseFloat(info[i].totalfactura).toFixed(2)+"</td><td>"+info[i].PAGO+"<td> </tr>";
         
      
         var btn = document.createElement("TR");
          btn.innerHTML=fila;
         document.getElementById("mitabla2").appendChild(btn);         
       
      }
    
    },
    error:function(error){
      
    }
   });
  
 
  
}
function MuestraForma()
{
 $("#report").fadeIn();
   //var valor = valor;
   // $('#myModal').modal('show')
  var cod = document.getElementById("fecha").value;
  var parts = cod.split('-');
  
  var fecha = new Date(parts[0], parts[1] - 1, parts[2]);
   
  var meses = new Array ("Enero","Febrero","Marzo","Abril","Mayo","Junio","Julio","Agosto","Septiembre","Octubre","Noviembre","Diciembre");
   var m =meses[fecha.getMonth()]+" "+ parts[2]+" " +parts[0];
   var sumadeposito=0;
   var sumacheque=0;
   var sumatotal=0;
   
   $('.tipodegasto').html(m)  
   $.ajax({
    url: <?php echo('"'.base_url().'"');?>+'ReportePresupuesto/reporteDiariaBco',
    type: 'POST',
    async: true,
    data:{action:cod},
    success:function(response){
      
      var info = JSON.parse(response);
      var elmtTable = document.getElementById('mitabla');  
      var tableRows = elmtTable.getElementsByTagName('tr');
      var rowCount = tableRows.length;
     
       var stotal = 0;
      for (var i=0; i<info.length; i++) 
      {
         if(i==0)
         { 
          sumadeposito = sumadeposito+Number(info[i].deposito);
          sumacheque = sumacheque+Number(info[i].cheques);
          sumatotal = sumadeposito-sumacheque;
         fila="<tr id = fila> <td> BANCOS</td><td>CHEQUES</td><td> </td><td>"+parseFloat(info[i].deposito).toFixed(2)+"<td>"+parseFloat(info[i].cheques).toFixed(2)+"</td><td>"+parseFloat(sumatotal).toFixed(2)+"</td></tr>";
         
         }
         else
         {
          sumadeposito = sumadeposito+Number(info[i].deposito);
          sumacheque = sumacheque+Number(info[i].cheques);
          sumatotal = sumadeposito-sumacheque;
         fila= "<tr id = fila><td> VE X MAS</td><td>INVERSION</td><td> </td><td>"+parseFloat(info[i].deposito).toFixed(2)+"<td>"+parseFloat(info[i].cheques).toFixed(2)+"</td><td>"+parseFloat(Number(info[i].deposito)-Number(info[i].cheques)).toFixed(2)+"</td></tr>";
          
         }
         var btn = document.createElement("TR");
          btn.innerHTML=fila;
         document.getElementById("mitabla").appendChild(btn);         
       
      }
       sumatotal = sumadeposito-sumacheque;
      fila="<tr id = fila> <td> total</td><td> </td><td> </td><td>"+parseFloat(sumadeposito).toFixed(2)+"<td>"+parseFloat(sumacheque).toFixed(2)+"</td><td>"+parseFloat(sumatotal).toFixed(2)+"</td></tr>";
      var btn = document.createElement("TR");
          btn.innerHTML=fila;
         document.getElementById("mitabla").appendChild(btn);   

       
    },
    error:function(error){
      
    }
   });
  } 
   
 function coloseModal()
{
  
  $(".modal").fadeOut();
  //document.getElementById('CargoGes').value = 0.0;
  var elmtTable = document.getElementById('mitabla'); 
  if(elmtTable !== null){
        while (elmtTable.hasChildNodes()){
            elmtTable.removeChild(elmtTable.lastChild);
        }
    }
 } 
  </script>
