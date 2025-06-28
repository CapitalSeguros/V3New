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
        <div class="col-md-6 col-sm-5 col-xs-5"><h3 class="titulo-secciones">Aplicar Pago</h3></div>
        <div class="col-md-6 col-sm-7 col-xs-7">
          
        </div>
    </div>
        <hr /> 
</section>

<section class="container-fluid breadcrumb-formularios">
  

  <form  class="form-horizontal" role="formreferidos"
            id="formreferidos" name="formreferidos"
            method="post" 
            action="<?=base_url()?>presupuestos/AplicaPago/" > 

        <?    
             foreach ($detallefactpag->result() as $Registro) { ?>


            
            <input type="text"  name="IDFact" id="IDFact" 
            value="<?echo $Registro->id?>" 
            hidden="" >  
    

         <div class="col-md-3 col-sm-3 col-xs-3"> 
            <label>Fecha de Pago:</label>
            <input type="text"  name="1fNacimiento" id="1fNacimiento"  required=""  size="12" class="fecha"
            
            >  
        </div>

        
       <?  } 
       ?>

<div class="col-md-3 col-sm-3 col-xs-3"> 
     </br> 
         <input type="submit" name="button" id="button" value="Aplica Pago" align="left"  
                        onclick="">
 </div>

  </form >      
 </section>    
<!--:::::::::: FIN CONTENIDO ::::::::::-->

<?php $this->load->view('footers/footer'); ?>