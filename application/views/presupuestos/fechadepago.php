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
</style>

<form  class="form-horizontal" role="formreferidos"
            id="formreferidos" name="formreferidos"
            method="post" 
            action="<?=base_url()?>VerEncuesta/MuestraEncuesta/" > 
     
<section class="container-fluid breadcrumb-formularios">
   </br>
    <div class="row">
            <div  class="col-md-3 col-sm-3 col-xs-3"><h4 class="titulo-secciones">Edita Fecha De Pago </h4></div>
              </br>
   <div id="DivRoot" align="left">
    <div style="overflow: hidden;" id="DivHeaderRow">
    </div>
    </br>
  </section>   
  <div id="DivRoot" align="left">
    <div style="overflow: hidden;" id="DivHeaderRow">
    </div>

    <div style="overflow:scroll; height: 200px" onscroll="OnScrollDiv(this)" id="DivMainContent ">
        <!--Place Your Table Heare-->
         </br>
         <div class="table-responsive">
         <table class="table" id='Mitabla'>
          <thead>
                      <tr>
                  <th>ID</th>
                  <th>FOLIO</th>
                  <th>CONCEPTO</th>
                  <th>TOTAL</th>
                  <th>Editar</th>
                                                         
                
                                               
                                </tr>
           </thead>
          <tbody>  
           <?php
          if($facturas != FALSE){
            foreach ($facturas as $row){
               ?>
                    <th><?=$row->id?></th>
                    <th><?=$row->folio_factura?></th>
                    <th><?=$row->concepto?></th> 
                    <th><?=$row->totalfactura?></th> 
                     <td><?                   
                     ?>
                         <a href="<?=base_url()?>fechadepago/editafechapago?IDcheq=<?php echo $row->id?>"
                         .?IDCL=. class='btn btn-primary btn-xs contact-item' data-toggle="modal"  data-original-title><span class="glyphicon glyphicon-pencil" ></span>Editar</a>
                                    
                                         <?     
                    ?></td>
                 </tr>
              <?php
              }
           }
         ?>        
        
           </tbody>
            </table>
                    </div>

    <div id="DivFooterRow" style="overflow:hidden">
    </div>
</div>


</form> 