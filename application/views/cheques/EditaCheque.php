<?php $this->load->view('headers/header'); ?>
<?php $this->load->view('headers/menu');?>
<script type="text/javascript">
	<?php if(isset($pestania)){ ?> manejoMenu(<?php echo('"'.$pestania.'"'); ?>); <?php } ?>
</script>
<link rel="stylesheet" href="http://code.jquery.com/ui/1.10.1/themes/base/jquery-ui.css" />
<script src="https://code.jquery.com/jquery-1.12.4.js"></script>
<script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
<meta name="viewport" content="width=900px"/>
<!--:::::::::: INICIO CONTENIDO ::::::::::-->
<section class="container-fluid breadcrumb-formularios">
    <div class="row">
        <div class="col-md-6 col-sm-5 col-xs-5"><h3 class="titulo-secciones">Editar Cheque</h3></div>
        <div class="col-md-6 col-sm-7 col-xs-7">
          
        </div>
    </div>
        <hr /> 
</section>
<section class="container-fluid breadcrumb-formularios">
  <form  class="form-horizontal" role="formreferidos"
            id="formreferidos" name="formreferidos"
            method="post" 
            action="<?=base_url()?>cheques/GuardaEditaCheque/" > 
       
          <pre>
          <?
        // var_dump($detalleCheque->result() ); 
         ?>
         </pre> 
         <?
         foreach ($detalleCheque->result() as $Registro) { ?>
       
           <input type="text"  name="IDCheq" id="IDCheq" 
            value="<?echo $Registro->IDCHEQUE?>" hidden = "" 
             >  
           <div class="col-md-3 col-sm-3 col-xs-3"> 
            <label>Banco:</label> 
             <select name="bancos" id="bancos"  required="" class="class=form-control input-sm">
             <?
             
              foreach($bancos->result() as $each)
               {
                 if(strcmp ($each->descripcionBancos , $Registro->bancos) == 0)
                 {
                 ?>
                  <option value="<?=$each->descripcionBancos ?>" selected ><?print $each->descripcionBancos?></option>
                 <?
                 }                 
                else
                 {
                 ?>
                 <option value="<?=$each->descripcionBancos ?>"> <? print $each->descripcionBancos?></option>
                 <?
                 } 
               }
          
            ?>
          </select>      
             </div> 
          <div class="col-md-3 col-sm-3 col-xs-3"> 
           <label>Movimientos:</label> 
            <select name="tipo" id="tipo" class="class=form-control input-sm" required="" >
            <?
            foreach($movimientos->result() as $each)
            {
               if(strcmp ($each->TIPOMOVIMIENTO , $Registro->movimiento) == 0)
                 {
                ?>
                <option value="<?=$each->TIPOMOVIMIENTO ?>" selected> <? print $each->TIPOMOVIMIENTO?></option>
                <?
                }
                else
                 {
                 ?>
                 <option value="<?=$each->TIPOMOVIMIENTO ?>"> <? print $each->TIPOMOVIMIENTO?></option>
                 <?
                 } 
            }
          ?>
          </select>
          </div>
         <div class="col-md-3 col-sm-3 col-xs-3"> 
           <label>Concepto:</label> 
            <select name="Concepto" id="Concepto" class="class=form-control input-sm" required="" >
            <?
            foreach($concepto->result() as $each)
            {
               if(strcmp ($each->concepto , $Registro->concepto) == 0)
                 {
                ?>
                <option value="<?=$each->concepto ?>" selected> <? print $each->concepto?></option>
                <?
                }
                else
                 {
                 ?>
                 <option value="<?=$each->concepto ?>"> <? print $each->concepto?></option>
                 <?
                 } 
            }
          ?>
          </select>
          </div> 
          </br> </br>
          <div class="col-md-3 col-sm-3 col-xs-3"> 
          <label for="fecha" class="form-group-inline">Fecha:</label>
           <input type="date"  name="fecha" id="fecha" placeholder="Fecha del Cheque" value = "<?=$Registro->FECHA?>" required="" size="20" class="form-control-width-small">
          </div> 
            <div  class="col-md-3 col-sm-3 col-xs-3">
           <label  class="form-group-inline"> Cantidad </label>  
            <input type="number" step="any"  name="total" id="total"  required="" size="20" value = "<?=$Registro->total?>" > 
           </div>  

          <? 
           }
     ?>
</br> </br>
 <div style="width: 330px; margin: 0 auto;"> 
   <div class="addthis_toolbox addthis_32x32_style addthis_default_style">
     
       <input type="submit" name="button" id="button" value="Actualiza Datos" align="left"  
                        onclick="">  
 </div>

  </form >      
 </section>        
<?php $this->load->view('footers/footer'); ?>
