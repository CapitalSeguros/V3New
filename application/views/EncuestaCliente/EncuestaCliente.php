




<style type="text/css">
body {overflow-x: hidden;}

.fondoCabeceraMenuGeneral{height: 130px;visibility: visible;background-repeat: no-repeat;margin-bottom: 0px;background-color: white;background-image: url("<?php echo base_url(); ?>assets/images/logo/B1366x100.png");}
.boton{
  margin : 10px 50%;
  padding: 5px 10px;
  background: RGB(89, 211, 56);
  color:white;
  
}

.boton:hover{
 cursor: pointer;
}
</style>
<link rel="stylesheet" href="http://code.jquery.com/ui/1.10.1/themes/base/jquery-ui.css" />
<script src="http://code.jquery.com/jquery-1.9.1.js"></script>
<script src="http://code.jquery.com/ui/1.10.1/jquery-ui.js"></script>
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Document</title>
</head>
  <meta charset="UTF-8">
<div id="fondoCabeceraMenu" class="fondoCabeceraMenuGeneral"></div>
<section class="container-fluid breadcrumb-formularios">
	
   
    <hr />
    <div class="row">
            <div  class="col-md-3 col-sm-3 col-xs-3"><h1 class="titulo-secciones">Encuesta Clientes</h1></div>

     </div>

 <hr />
 <div class="row">
  <div class="col-xs-12 col-sm-12 col-md-12">
      <form  
            id="formencuestas" name="formencuestas"
            method="post" 
            action="javascript: enviarFormAjax('formencuestas','asigna','GrabaExtra')" > 
         <input type="hidden" name="idenc" id="idenc"  value="<?php echo $ide?>" />
         <table class="table">
          <thead>
            <tr><th>Pregunta</th><th>Respuesta</th></tr>
          </thead>
          <tbody>
         <?php
         
           $valor=0;   

          if($Pre != FALSE){ 
             foreach ($Pre as $row){
              //$fp = fopen('resultadoJason.txt', 'a');fwrite($fp, print_r($Pre, TRUE));fclose($fp);
                   if($valor==0)
                   {
                    ?>
       
                    <?
                   }
                    ?>
                   
                   <tr><td>
                   <label class="etiquetaLabel1" for="<?$row->idencuesta?>">&nbsp;&nbsp;<?php echo ltrim($row->pregunta) ?> </label>  
                  </td>
                  <td>
                   <?
                    if($row->tipo == 1)
                    {
                     ?>
       
                     
                     <label class="etiqueta1">&nbsp;&nbsp;Respuesta &nbsp;</label>
                      <select name="<?php echo $row->idencuesta?>" 
                       id="<?php echo $row->idencuesta?>" 
                        class="form-control-width-small input-sm" required="">
                      <option value="1">1</option>
                      <option value="2">2</option>                                 
                      <option value="3">3</option>                                 
                      <option value="4">4</option>                                 
                      <option value="5">5</option>                                 
                      <option value="6">6</option>                                 
                      <option value="7">7</option>                                 
                      <option value="8">8</option>                                 
                      <option value="9">9</option>                                 
                      <option value="10">10</option>                                 
                     </select>
                     </td></tr>
                     <?
                     }
                     else
                     {
                      ?>
       
                      <label class="etiquetaSimple">&nbsp;&nbsp;&nbsp;Respuesta &nbsp;</label>
                      <select name="<?php echo $row->idencuesta?>" 
                       id="<?php echo $row->idencuesta?>" 
                        class="form-control-width-small input-sm" required="">
                      <option value="V">V</option>
                      <option value="F">F</option>
                      </select>
                    </td></tr >
                     <?
                     }                
              $valor=$valor+1; 

              }          
      }
      ?>
      </tbody>
      <tfoot><tr><td colspan="2"><button type = "submit" class = "boton">Grabar</button> </td></tr> </tfoot>
      </table>     
       </br>
       <label class="">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; &nbsp;</label>    
    
      </form>
    </div>
     </div>
    
    </div>
     </div>

    </div>  
</div>  
</html>
<?php
 // alert($ide);
  if($enc > 0){ 
?>  	
  <script language="javascript" type="text/javascript">
  $( document ).ready(function() {
    $('#myModal').modal('toggle')
  });
 
 function enviarFormAjax(formulario,controlador,funcionControlador){
 	 var Data = new FormData(document.getElementById(formulario));  

  if(window.XMLHttpRequest) { var Req = new XMLHttpRequest();}

  else if(window.ActiveXObject) {var Req = new ActiveXObject("Microsoft.XMLHTTP");}    

  var direccion= <?php echo('"'.base_url().'"');?>+controlador+'/'+funcionControlador;

    Req.open("POST",direccion, true);

  

  Req.onload = function(Event) {

     console.log(Req.status);

    if (Req.status == 200) {

      var respuesta = JSON.parse(Req.responseText);      
        //print_r(array_keys($respuesta));
       alert(respuesta);
       window.open('location', '_self', ''); window.close(); 
      // CierraPopup();
       //window.close();
  //***
    } else {      }

  };    

  //Enviamos la petición

  Req.send(Data);

}


function CierraPopup() {
  // window.close();
$('#cerrar').click(); //Esto simula un click sobre el botón close de la modal, por lo que no se debe preocupar por qué clases agregar o qué clases sacar.
$('.formencuestas').remove();//eliminamos el backdrop del modal
}

  </script>
 <?}?>          
        