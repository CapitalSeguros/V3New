<?php
	$this->load->view('headers/header'); 
?>
<!-- Navbar -->
<?php
	$this->load->view('headers/menu');
?>
<meta name="viewport" content="width=900px"/>
<!--:::::::::: INICIO CONTENIDO ::::::::::-->
<section class="container-fluid breadcrumb-formularios">
    <div class="row">
        <div class="col-md-6 col-sm-5 col-xs-5"><h3 class="titulo-secciones">Editar Proveedor</h3></div>
        <div class="col-md-6 col-sm-7 col-xs-7">
          
        </div>
    </div>
        <hr /> 
</section>

<section class="container-fluid breadcrumb-formularios">
  

  <form  class="form-horizontal" role="formreferidos"
            id="formreferidos" name="formreferidos"
            method="post" 
            action="<?=base_url()?>presupuestos/actualizaproveedor/" > 

        <?    
             foreach ($detalleproveedor->result() as $Registro) { ?>            
            <input type="text"  name="idprovee" id="idprovee" value="<?echo $Registro->id?>" hidden="">  
    
      <div class="row">
         <div class="col-md-3 col-sm-3 col-xs-3"> 
            <label class="etiquetaSimple">Nombre de Proveedor:</label>
            <input type="text"  name="nombre" id="nombre" value="<?echo $Registro->NombreProveedor?>" class="form-control">  
        </div>

         <div class="col-md-3 col-sm-3 col-xs-3"> 
            <label class="etiquetaSimple">Nombre de Contacto:</label>
            <input type="text"  name="nombrecon" id="nombrecon" value="<?echo $Registro->Nombre_contacto?>" class="form-control">  
        </div>

          <div class="col-md-3 col-sm-3 col-xs-3"> 
            <label class="etiquetaSimple">Telefono:</label>
            <input type="text"  name="telefono" id="telefono" value="<?echo $Registro->telefono1?>" onKeypress="if (event.keyCode < 45 || event.keyCode > 57) event.returnValue = false;" class="form-control">  
        </div>

        <div class="col-md-3 col-sm-3 col-xs-3"> 
            <label class="etiquetaSimple">Extension</label>
            <input type="text"  name="ext" id="ext" value="<?echo $Registro->extension?>" onKeypress="if (event.keyCode < 45 || event.keyCode > 57) event.returnValue = false;" class="form-control">  
        </div>
      </div>
      <div>
        <div class="col-md-3 col-sm-3 col-xs-3"> 
         </br>   
            <label class="etiquetaSimple">Celular:</label>
            <input type="cel"  name="cel" id="cel" value="<?echo $Registro->telefono_movil?>" onKeypress="if (event.keyCode < 45 || event.keyCode > 57) event.returnValue = false;" class="form-control">  
        </div>
        

        <div class="col-md-3 col-sm-3 col-xs-3"> 
            </br>  
            <label class="etiquetaSimple">Email:</label>
            <input type="text"  name="email" id="email" value="<?echo $Registro->email?>" pattern="[a-zA-Z0-9_]+([.][a-zA-Z0-9_]+)*@[a-zA-Z0-9_]+([.][a-zA-Z0-9_]+)*[.][a-zA-Z]{1,5}" class="form-control">  
        </div>

          <div class="col-md-3 col-sm-3 col-xs-3"> 
            </br>  
            <label class="etiquetaSimple">Direccion:</label>
            <input type="text"  name="direccion" id="direccion" value="<?echo $Registro->direccion?>" class="form-control">  
        </div>

          <div class="col-md-3 col-sm-3 col-xs-3"> 
            </br>  
            <label class="etiquetaSimple">Banco:</label>
            <input type="text"  name="banco" id="banco" value="<?echo $Registro->banco?>" class="form-control">  
        </div>
   </div>
   <div class="row">
          <div class="col-md-3 col-sm-3 col-xs-3"> 
            </br>  
            <label class="etiquetaSimple">Cuenta:</label>
            <input type="text"  name="cuenta" id="cuenta" value="<?echo $Registro->cuenta?>" class="form-control">  
        </div>

          <div class="col-md-3 col-sm-3 col-xs-3"> 
            </br>  
            <label class="etiquetaSimple">Clabe Int:</label>
            <input type="text"  name="clave" id="clave" value="<?echo $Registro->clabe?>" class="form-control">  
        </div>

         <div class="col-md-3 col-sm-3 col-xs-3"> 
            </br>  
             <label class="etiquetaSimple">Dias de Credito:</label>
            <input type="text"  name="dias" id="dias" value="<?echo $Registro->DiasCredito?>" onKeypress="if (event.keyCode < 45 || event.keyCode > 57) event.returnValue = false;" class="form-control">  
         </div>

       <?  } 
       ?>
<div class="col-md-3 col-sm-3 col-xs-3"><br>
           <label class="etiquetaSimple">Giros</label><select id="giroCliente" name="giroCliente" class="form-control" ><?= catalogGiros($giros);?></select>
         </div>
</div>
<div class="row"> 
<div class="col-md-3 col-sm-3 col-xs-3"><input type="submit" name="button" id="button" value="Modifica Datos" align="left"  oclick="" class="btn-primary">
 </div>
</div>
  </form >  
  
 </section>    
<!--:::::::::: FIN CONTENIDO ::::::::::-->

<?php $this->load->view('footers/footer'); ?>
<style type="text/css"> body{overflow: scroll;}</style>

  <?php  
  function catalogGiros($datos){
    $option="";
      foreach ($datos as  $value) {$option.='<option value="'.$value->idGiro.'" >'.$value->giro.'</option>';}
      return $option;
  }

  ?>