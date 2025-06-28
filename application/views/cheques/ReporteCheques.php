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
<section class="container-fluid breadcrumb-formularios">
   </br>
    <div class="row">
            <div  class="col-md-3 col-sm-3 col-xs-3"><h4 class="titulo-secciones">Reporte de Cheques</h4></div>

     </div>
   </br>

   </section>
 <section class="container-fluid breadcrumb-formularios">
<a href="<?=base_url()?>cheques/excel?fecha=<?php echo $fec?>" style="background:#43BD55;color: #FFFFFF;" class="glyphicon glyphicon-file btn btn-sucess bullet bullet-verde" target="_blank"> Generar excel </a>
<a href="<?=base_url()?>cheques/excelDepositos?fecha=<?php echo $fec?>"" style="background:#43BD55;color: #FFFFFF;margin-left: 15px" class="glyphicon glyphicon-file btn btn-sucess bullet bullet-verde" target="_blank">Depositos_Capturados </a>         
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
                  <th>BANCO</th>
                  <th>FECHA</th>
                  <th>MOVIMIENTO</th>
                  <th>CONCEPTO</th>
                  <th>HOY</th>                                              
                  <th>ACUMULAMES</th>                                           
                
                                               
                                </tr>
           </thead>
          <tbody>          
         <?php
          if($consultaCheque != FALSE){
            foreach ($consultaCheque->result() as $row){
               ?>
                    <th><?=$row->descripcionbancos?></th>
                    <th><?=$row->FECHA?></th>
                    <th><?=$row->movimiento?></th> 
                    <th><?=$row->concepto?></th> 
                    <th><?=$row->total?></th> 
                    <th><?=$row->ACUMANOPASADO?></th> 
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
 
  <style type="text/css">
 .EtiquetaFile{position: relative; top: 30px; width: 150px; border: solid; ;}
 .Archivo1{opacity: 0; width: 150px}
 .divContenedor{width: 150px}
 .divContenedor:hover label{background:#d8d8d8}
  body{overflow: scroll;}
 </style>
<?php $this->load->view('footers/footer'); ?>

<script type="text/javascript">
  document.getElementById("miModal").classList.add("modalCierra");
   document.getElementById("miModal").classList.remove("modalAbre");
     document.getElementById("Modalcontenido").style.display="none";
</script>