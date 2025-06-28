<?php
	$this->load->view('headers/header'); 
?>
<!-- Navbar -->
<?php
	$this->load->view('headers/menu');
?>

<link rel="stylesheet" href="http://code.jquery.com/ui/1.10.1/themes/base/jquery-ui.css" />
<script src="https://code.jquery.com/jquery-1.12.4.js"></script>
<script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
<script>
  
    $( function(){$( "#1fNacimiento" ).datepicker({          
            dateFormat: 'yy-mm-dd',});} );

     $(document).ready(function () {
   $('.fecha').datepicker();
 });

</script>

<meta name="viewport" content="width=900px"/>
<!--:::::::::: INICIO CONTENIDO ::::::::::-->
<section class="container-fluid breadcrumb-formularios">
    <div class="row">
        <div class="col-md-6 col-sm-5 col-xs-5"><h3 class="titulo-secciones">Agrega Fecha Pago</h3></div>
        <div class="col-md-6 col-sm-7 col-xs-7">
          
        </div>
    </div>
        <hr />

  <form  class="form-horizontal" role="formreferidos"
            id="formreferidos" name="formreferidos"
            method="post" 
            action="<?=base_url()?>fechadepago/Grabafechapago/" > 
       
         <? 
         foreach ($detalleCheque as $Registro) { ?>
       
           <input type="text"  name="IDCheq" id="IDCheq" 
            value="<?echo $Registro->id?>" hidden = "" 
             >  
            
          </br>
          <div class="col-md-3 col-sm-3 col-xs-3"> 
          <label for="fecha">Folio</label>
           <input type="text"  name="folio" id="folio" placeholder="Folio de la factura" value = "<?=$Registro->folio_factura?>" required="" size="20" >               
          </div> 
          </br>
          </br>
         <div > 
          <label for="fecha" >Concepto</label>
           <input type="text"  name="concepto" id="concepto" placeholder="Concepto de la factura" value = "<?=$Registro->concepto?>" required="" size="80" class="form-control-width-small">
          </div>
           </br> 
          <div class="col-md-3 col-sm-3 col-xs-3"> 
          <label for="fecha" class="form-group-inline">Fecha:</label>
           <input type="date"  name="fecha" id="fecha" placeholder="Fecha de Pago" value = "<?=$Registro->fecha_pago?>" required="" size="20" class="form-control-width-small">
          </div>
           </br> 
            <div  class="col-md-3 col-sm-3 col-xs-3">
           <label  class="form-group-inline"> Cantidad </label>  
            <input type="number" step="any"  name="total" id="total"  required="" size="20" value = "<?=$Registro->totalfactura?>" > 
           </div>   

          <? 
           }
     ?>
</br> 
 </br>
  </br>
 <div style="text-align: right;width:220px"> 
   
     
       <input type="submit" name="button" id="button" value="Actualiza Datos" align="center"  
                        onclick="">  
 </div>

  </form >      
        

   

</section>
