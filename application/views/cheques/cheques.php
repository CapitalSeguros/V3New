<?php $this->load->view('headers/header'); ?>
<?php $this->load->view('headers/menu');?>
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
    .editar {background-color :rgb(35, 224, 48 );width:7rem;padding:5px 10px;color : white;text-align:center;}
    .editar:hover{cursor:pointer;}
    .eliminar {background-color :rgb(255, 87, 51 );padding:5px 10px;color : white;}
    .iden{border:0;text-align:center;background:transparent;}
    .buton-grabacr{display:flex;justify-content:center;text-align:center;align-items:center;margin-top:50px;}
</style>
<section class="container-fluid breadcrumb-formularios">

   <div class="row"><br>
 <form  class="form-horizontal" role="formreferidos" id="formreferidos" name="formreferidos" method="post" action="<?=base_url()?>cheques/GuardarCheque/" > 
  <fieldset>
    <legend><label class="label label-info">ALTA DE CHEQUES</label></legend>
     <div  class="col-md-2 col-sm-2 col-xs-2">
      <input type="hidden" name="idBancosHidden" id="idBancosHidden">
            <label for="fecha" class="etiquetaSimple">Fecha:</label>
            <? $fecha = date("Y-m-d");?>
           <input type="date"  name="fecha" id="fecha" value="<?php echo $fecha;?>" placeholder="Fecha del Cheque" required="" size="20" class="form-control input-sm">
       </div>  
     <div  class="col-md-2 col-sm-2 col-xs-2" style="display: none">
            <label for="fecha" class="etiquetaSimple">Hasta:</label>            
           <input type="date"  name="fechaHasta" id="fechaHast" value="<?=date("Y-m-d"); ?>"  size="20" class="form-control input-sm">
       </div>       
       <div class="col-md-2 col-sm-2 col-xs-2" >
            <label class="etiquetaSimple">Companias:</label> 
             <select name="companias" id="companias"  required="" class="form-control input-sm">
             <?
              foreach($companias as $each){ if($each->idPromotoria!=51 && $each->idPromotoria!=52){ ?><option value="<?=$each->idPromotoria ?>"> <? print $each->Promotoria;} ?></option><?}
            ?>
          </select>      
          </div>  
       <div  class="col-md-2 col-sm-2 col-xs-2">
           <label  class="etiquetaSimple"> Tipo mov </label>   
            <select name="tipo" id="tipo" class="form-control input-sm" required="" >
            <?
            foreach($movimientos->result() as $each){?><option value="<?=$each->TIPOMOVIMIENTO ?>"> <? print $each->TIPOMOVIMIENTO?></option><?}
          ?>
          </select>
       </div>    
        <div class="col-md-2 col-sm-2 col-xs-2" style="display: none">
            <label class="etiquetaSimple">Banco:</label> 
             <select name="bancos" id="bancos"   class="form-control input-sm" data-identificador='1' onchange="escogeBanco(this)">
             <?
              foreach($bancos->result() as $each)
              { ?>
                <option value="<?=$each->descripcionBancos ?>" data-idbanco="<?=$each->idBanco?>"> <? print $each->descripcionBancos?></option><?
               }
            ?>
          </select>      
          </div>  
    <div  class="col-md-2 col-sm-2 col-xs-2">
           <label  class="etiquetaSimple"> Concepto </label>   
           <select name="Concepto" id="Concepto" class="form-control input-sm" required="" >
            <?
             foreach($concepto->result() as $each)
             {
                ?>
                <option value="<?=$each->concepto ?>"> <? print $each->concepto?></option>
                <?
             }
          ?>
      </select>
       </div>  
    <div  class="col-md-2 col-sm-2 col-xs-2">
           <label  class="etiquetaSimple"> Cantidad </label>  
            <input type="number" step="any"  name="total" id="fecha" class="form-control input-sm" required="" size="20" > 
     </div>   
    
    <div class="col-md-2 col-sm-2 col-xs-2" style="display: none">
            <label class="etiquetaSimple" >Cargo/Depsto</label>                    
              <select name="TipoCargo" 
              id="TipoCargo" 
              class="form-control input-sm" required="">
                  <option value="DEPOSITO">DEPOSITO</option>
                  <option value="CARGO">CARGO</option>   
                  <option value="XCOMISION">XCOMISION</option>                 
                </select>
        </div> 
    <div class="col-md-2 col-sm-2 col-xs-2">
            <label for="seguro" class="etiquetaSimple" >Seguro/Afzdra</label>                    
              <select name="seguro" id="seguro" class="form-control input-sm" >                  
                  <option value="SEGURO" selected="">SEGURO</option>
                  <option va
                  lue="AFIANZADORA">AFIANZADORA</option>   
                  <option value="OTROS">OTROS</option>                 
                </select>
  </div> 
       <div  class="col-md-2 col-sm-2 col-xs-2">     
        <br>
       <input type="submit" name="button" id="button" value="Guardar Datos" class="btn btn-success"  onclick="">               
  </div>   
   
  
   </fieldset>                                  
  </form > 
  <div  class="col-md-3 col-sm-3 col-xs-3">          
    <br>
      <button style="background:#43BD55;color: #FFFFFF;" class="glyphicon glyphicon-file btn btn-sucess bullet bullet-verde" onclick="enviarReporte()">Reporte</button>
   </div>                                
</div>  
  </section> 
<br>
<section class="container-fluid breadcrumb-formularios">
  <div class="row">
  <form class="form-horizontal" style="width: 100%" method="post" action="<?=base_url()?>cheques/GuardarCheque/">
    <input type="hidden" name="idBancosHidden" id="idBancoDesdeHidden">
    <input type="hidden" name="idBancoDestinoHidden" id="idBancoDestinoHidden">
    <input type="hidden" name="seguro" value="OTROS">
   <fieldset><legend><label class="label label-info">BAJA Y ALTA INVERSION</label></legend>
   <div  class="col-md-2 col-sm-2 col-xs-2"><label for="fecha" class="etiquetaSimple">Fecha:</label><input type="date" name="fecha" class="form-control input-sm " value="<?=date("Y-m-d"); ?>"> </div>
   <div  class="col-md-2 col-sm-2 col-xs-2"><label class="etiquetaSimple">Inversion:</label><select class="form-control input-sm" name="companias"><option value="51">BX-ALTA INVERSION</option><option value="52">BX-BAJA INVERISON</option><option value="-3">INTERES PAGADO</option><option value="-4">RETENCION SR</option></select> </div>
<div  class="col-md-2 col-sm-2 col-xs-2" style="display: none"><label class="etiquetaSimple">MOVIMIENTO:</label><select class=" input-sm" name="tipo"><option value="TRANSFERENCIA"> TRANSFERENCIA</option></select> </div>
        <div class="col-md-2 col-sm-2 col-xs-2" >
            <label class="etiquetaSimple">DEL BANCO:</label> 
             <select name="bancos"   required="" class="form-control input-sm" id="selectBandoDesde" data-identificador='2' onchange="escogeBanco(this)">
             <? foreach($bancos->result() as $each) { if($each->idBanco==3 || $each->idBanco==17){?>
                <option value="<?=$each->descripcionBancos ?>" data-idbanco="<?=$each->idBanco?>"> <? print $each->descripcionBancos?></option>
            <?}}?>
          </select>      
          </div>  
        <div class="col-md-2 col-sm-2 col-xs-2" >
            <label class="etiquetaSimple">AL BANCO:</label> 
             <select name="idBancoDestino" id="selectBancoDestino"   required="" class="form-control input-sm" data-identificador='3' onchange="escogeBanco(this)">
             <? foreach($bancos->result() as $each) { if($each->idBanco==3 || $each->idBanco==17){?>
                <option value="<?=$each->descripcionBancos ?>" data-idbanco="<?=$each->idBanco?>" > <? print $each->descripcionBancos?></option>
            <?}}?>
          </select>      
          </div>
              <div  class="col-md-2 col-sm-2 col-xs-2">
           <label  class="etiquetaSimple"> Cantidad </label>  
            <input type="number" step="any"  name="total"  class="form-control input-sm" required="" size="20" > 
     </div>
        <div class="col-md-2 col-sm-2 col-xs-2">
            <label class="etiquetaSimple" >Cargo/Deposito</label>                    
              <select name="TipoCargoInversion" 
              id="CargoDepositoInversion" 
              class="form-control input-sm" required="">
                  <option value="DEPOSITO">DEPOSITO</option>
                  <option value="RETIRO">RETIRO</option>   
                  
                </select>
    </div> 
            <div  class="col-md-2 col-sm-2 col-xs-2">     
        <br>
       <input type="submit" name="button" id="button" value="Guardar" class="btn btn-success btn-ms"  onclick="">               
  </div>       
    </div>    
 
 </fieldset>
  </form>
</div>
</section>
<!-- End navbar -->
<section class="container-fluid breadcrumb-formularios">
  </br>
  <hr />   
 </section>

<div style="height: 300px;width: 100%;overflow: scroll;">
         <table class="table table-sm" id='Mitabla'>
          <thead>
                      <tr>
                  <th>EDITAR</th>
                  <th>ELIMINAR</th>
                  <th style="display: none">ID</th>
                  <th>FECHA</th>
                  <th>COMPANIA</th>
                  <th>TIPO MOVIMIENTO</th>
                  <th>CONCEPTO</th>                                              
                  <th>INVERSION</th> 
                  <th>DEL BANCO</th>                                           
                  <th>AL BANCO</th>                                           
                  <th>CANTIDAD </th>
                  <th>CARGO/DEPOSITO</th>                  
                  
                  <th style="display: none">SEGURO/AFIANZADORA </th>                             
                                </tr>
           </thead>
          <tbody>          
         <?php
          if($Cheque != FALSE){
            foreach ($Cheque->result() as $row){
                            $promotoria='';
              $inversion='';
              if($row->idPromotoria=='51' || $row->idPromotoria=='52' || $row->idPromotoria=='-3' || $row->idPromotoria=='-4')
                {
                  $inversion=$row->promotoria;
                  if($row->idPromotoria==-3){$inversion='INTERES PAGADO';}
                  if($row->idPromotoria==-4){$inversion='RETENCION SR';}
                }
              else{$promotoria=$row->promotoria;}
               ?>
                  <tr>
                   <form method="post" action ="<?=base_url()?>cheques/editcheque/">              
                    <td><button  class="editar btn btn-warning" value="<?=$row->IDCHEQUE?>" name="IDCheq" id="IDCheq">Editar</td>
                    </form>
                    <form method="post" action ="<?=base_url()?>cheques/eliminacheque/">       
                    <td><button  class="eliminar btn btn-danger" value="<?=$row->IDCHEQUE?>" name="elimina" id="elimina">Eliminar</td>
                    </form>
                     <td name ="<?=$row->IDCHEQUE?>" style="display: none"><?=$row->IDCHEQUE?></td>                     
                    <td><?=$row->FECHA?></td>
                    <td><?=$promotoria?></td>
                    <td><?=$row->movimiento?></td>
                    <td><?=$row->concepto?></td>
                    <td><?=$inversion?></td>
                    <td><?=$row->bancos?></td>                                              
                    <td><?=$row->bancoDestino?></td>
                    <td align="right">$<?=number_format($row->total,2)?></td>                                               
                    <td><?=$row->tipoInversion?></td>                                           
                     
                    <td style="display: none"><?=$row->seguro?></td>                                    
                 </tr>
              <?php
              }
           }
         ?>
           </tbody>
            </table>

    </div>
  <style type="text/css">
 .EtiquetaFile{position: relative; top: 30px; width: 150px; border: solid; ;}
 .Archivo1{opacity: 0; width: 150px}
 .divContenedor{width: 150px}
 .divContenedor:hover label{background:#d8d8d8}
 .etiquetaSimple{text-transform: uppercase;}
  body{overflow: scroll;}
 </style>


<script type="text/javascript">
  function enviarReporte(){
    crearObjetosParaForm(document.getElementById('fecha').value,'fecha');
    enviarFormGenerales('cheques/ReporteCheques');
  }
  
  function crearObjetosParaForm(datos,nombre){var input=document.createElement('input');input.setAttribute('type','hidden');input.setAttribute('value',datos);input.setAttribute('class',"formEnviar");input.setAttribute('name',nombre);document.body.appendChild(input);}

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

function escogeBanco(objeto)
{
  objeto.dataset.identificador;
  let val=objeto.options[objeto.selectedIndex].dataset.idbanco; 
  if(objeto.dataset.identificador==1){document.getElementById('idBancosHidden').value=val;}
  if(objeto.dataset.identificador==2){document.getElementById('idBancoDesdeHidden').value=val;}
  if(objeto.dataset.identificador==3){document.getElementById('idBancoDestinoHidden').value=val;}
}
escogeBanco(document.getElementById('bancos'));
escogeBanco(document.getElementById('selectBandoDesde'));
escogeBanco(document.getElementById('selectBancoDestino'));
</script>
 <?php $this->load->view('footers/footerSinSegurin'); ?>