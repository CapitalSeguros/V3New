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
        <div class="col-md-6 col-sm-5 col-xs-5"><h3 class="titulo-secciones">Editar Pregunta</h3></div>
        <div class="col-md-6 col-sm-7 col-xs-7">
          
        </div>
    </div>
        <hr /> 
</section>
<section class="container-fluid breadcrumb-formularios">
  <form  class="form-horizontal" role="formreferidos"
            id="formreferidos" name="formreferidos"
            method="post" 
            action="<?=base_url()?>pregunta/GuardaEditaPregunta" > 
       
         <? 
          ?>
          </br> </br>
          <?    
         foreach ($detallepregunta->result() as $Registro) { ?>
           <input type="text"  name="idpregunta" id="idpregunta" 
            value="<?echo $Registro->idpregunta?>" hidden = "" 
             >  
                
          <div class="col-md-3 col-sm-3 col-xs-3"> 
          <label for="pregunta" class="form-group-inline">Pregunta :</label>
            <input type="text"  name="pregunta" id="pregunta" size = "80"
            value="<?echo $Registro->pregunta?>"     > 

          </div>
       </br> </br></br> 
          <div class="col-md-3 col-sm-3 col-xs-3"">
            <label class="form-group-inline" >Tipo de Respueta</label>                    
              <select name="TipoRespuesta" 
              id="TipoRespuesta" 
              class="form-control-width-small input-sm"required="">
              
              <?
              if($Registro->tipo == 1 ) {?>
                  <option value="NUMERO">1..10</option>           
                  <option value="VOF">V o F</option>  
               <?
                }
                 else { ?>
                          <option value="VOF">V o F</option>  
                          <option value="NUMERO">1..10</option>                         
                                          
               <?
               } ?>
                </select>
        </div> 



          <?} 
       ?>
       
     </br> 
     </br>
     </br>
     <div class="col-md-6 col-sm-7 col-xs-7">
       <input type="submit" name="button" id="button" value="Guarda Datos"  
                        onclick="">
     </div>

          </select> 
          </form >      
 </section>        
<?php $this->load->view('footers/footer'); ?>