<?php
$busquedaUsuario = $this->input->get('busquedaUsuario', TRUE);
$totalResultados = $Listafacturas->num_rows();
?>
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



<?  
    $colorRef[0] = "5";
    $colorRef[1] = "8";
    $colorRef[2] = "11";
    $colorRef[3] = "14";
    $colorRef[4] = "17";
    $colorRef[5] = "20";
    $colorRef[6] = "23";
    $colorRef[7] = "26";
    $colorRef[8] = "29";
    $colorRef[9] = "32";
    $colorRef[10] = "33"; //solo llegan a 34 los colores de la libreira
    $colorRef[11] = "34";
    $colorRef[12] = "";
    $colorRef[13] = "";
    $colorRef[14] = "";

    $graficaRef     = base_url().'assets/plugins/GraPHPico_0-0-3/graphref.php?ref=';
    $graficaBarras  = base_url()."assets/plugins/GraPHPico_0-0-3/graphbarras.php?dat=";
    $graficaPastel  = base_url()."assets/plugins/GraPHPico_0-0-3/graphpastel.php?dat=";
    $graficaPorcen  = base_url()."assets/plugins/GraPHPico_0-0-3/graphporcentaje.php?fil=";
?>

<meta name="viewport" content="width=900px"/>

<script language="javascript" type="text/javascript">


    function MakeStaticHeader(gridId, height, width, headerHeight, isFooter) {
        var tbl = document.getElementById(gridId);
        if (tbl) {
        var DivHR = document.getElementById('DivHeaderRow');
        var DivMC = document.getElementById('DivMainContent');
        var DivFR = document.getElementById('DivFooterRow');

        //*** Set divheaderRow Properties ****
        DivHR.style.height = headerHeight + 'px';
        DivHR.style.width = (parseInt(width) - 16) + 'px';
        DivHR.style.position = 'relative';
        DivHR.style.top = '0px';
        DivHR.style.zIndex = '10';
        DivHR.style.verticalAlign = 'top';

        //*** Set divMainContent Properties ****
        DivMC.style.width = width + 'px';
        DivMC.style.height = height + 'px';
        DivMC.style.position = 'relative';
        DivMC.style.top = -headerHeight + 'px';
        DivMC.style.zIndex = '1';

        //*** Set divFooterRow Properties ****
        DivFR.style.width = (parseInt(width) - 16) + 'px';
        DivFR.style.position = 'relative';
        DivFR.style.top = -headerHeight + 'px';
        DivFR.style.verticalAlign = 'top';
        DivFR.style.paddingtop = '2px';

        if (isFooter) {
         var tblfr = tbl.cloneNode(true);
      tblfr.removeChild(tblfr.getElementsByTagName('tbody')[0]);
         var tblBody = document.createElement('tbody');
         tblfr.style.width = '100%';
         tblfr.cellSpacing = "0";
         //*****In the case of Footer Row *******
         tblBody.appendChild(tbl.rows[tbl.rows.length - 1]);
         tblfr.appendChild(tblBody);
         DivFR.appendChild(tblfr);
         }
        //****Copy Header in divHeaderRow****
        DivHR.appendChild(tbl.cloneNode(true));
     }
    }


    function OnScrollDiv(Scrollablediv) {
    document.getElementById('DivHeaderRow').scrollLeft = Scrollablediv.scrollLeft;
    document.getElementById('DivFooterRow').scrollLeft = Scrollablediv.scrollLeft;
    }

    window.onload = function() {
   MakeStaticHeader('Mitabla', 350, 1750, 40, false)
}


 </script>

<section >
</br>
</br>
<form method="post" action="<?=base_url()?>presupuestos/ExportaFacturas">
  <div style="display: flex;">
    <label class="label label-info label-xs">Fecha Inicial:</label>
    <input type="date" name="fec_inicial" id="fec_inicial" style="height: 20px;max-height: 20px;line-height:18px">
    <label>Fecha Final:</label>
    <input type="date" name="fec_final" id="fec_final" style="height: 20px;max-height: 20px;line-height:18px">

    <button class='btn btn-primary btn-xs contact-item' placeholder="e"><span class="glyphicon glyphicon-th-large" >EXPORTAR</span></button>
  </div>
</form>
 <a href="<?=base_url()?>presupuestos/ExportaFacturas"
                      .?IDCL=. class='btn btn-primary btn-xs contact-item'><span class="glyphicon glyphicon-th-large" ></span>Exportar Facturas</a>
</section>


 <section class="container-fluid breadcrumb-formularios">
 <div  class="col-md-3 col-sm-3 col-xs-3"><h4 class="titulo-secciones">Aplicar Pagos</h4></div>

 </section>






<section class="container-fluid breadcrumb-formularios">

<div id="DivRoot" align="left">
    <div style="overflow: hidden;" id="DivHeaderRow">
    </div>

    <div style="overflow:scroll;" onscroll="OnScrollDiv(this)" id="DivMainContent">
        <!--Place Your Table Heare-->
                    <div class="table-responsive">
						<table class="table" id='Mitabla'>
							<thead>
		              <tr>
                 <!-- <th>Editar</th>-->
                  <th>Id</th>
                  <th>Solicitado por</th>
                  <th>Fecha Factura</th>
									<th>Folio</th>				                                
									<th>Concepto</th>			                                
									
                  <th>SubTotal</th>
                  <th>Total a Pagar</th>
                  <th>Accion</th>
   
                  <th>Proveedor</th>
                  <th>descarga XML</th>
                  <th>descarga PDF </th>
                  <th>Tipo Compra</th>
									
								</tr>
							</thead>
							<tbody>   
							<?php
								if($Listafacturas != FALSE){
									foreach ($Listafacturas->result() as $row){
							?>
										<tr data-usuario="<?=$row->Usuario?>" data-id="<?=$row->id?>" data-folio="<?=$row->folio_factura?>">
                                            <td><?=$row->id?></td> 
                                            <td><? echo $this->capsysdre->NombreUsuarioEmail($row->Usuario) ?></td>
                                            <td><?=$row->fecha_factura?></td> 
		                                      	<td><?=$row->folio_factura?></td>
                                            <td><?=$row->concepto?></td>                                           
                                            <td>$<?=$row->totalfactura?></td>
                                            <td>$<?=$row->totalconiva?></td>
                                            <?
                                            if($row->posteriorapago!='6')
                                            {?>
                                              
                                            <td>
                                             <button data-href="<?=base_url()?>presupuestos/AplicaPago?>"
                      .?IDCL=. class='btn btn-primary btn-xs contact-item'   onclick="abrirModalFecha(this)"><span class="glyphicon glyphicon-pencil" ></span>Pagar</button>
                                            </td>
                                           <? 
                                            }else
                                            {

                                           ?>
                                            <td>
                                             <button data-href="<?=base_url()?>presupuestos/PagarReembolso?"
                      .?IDCL=. class='btn btn-primary btn-xs contact-item'  onclick="abrirModalFecha(this)"><span class="glyphicon glyphicon-pencil" ></span>Rembolsar</button>
                                            </td>

                                            <? 
                                            }

                                           ?>
                                            <td><? echo $this->capsysdre->GetNombreProveedor($row->idProveedor) ?></td>
                                            <td>                                     <?php if($row->archivoNombreXML!=""){ ?>
                                                
                                                  <a target="_blank" class="btn btn-primary btn-xs contact-item" href=<?php echo('"'.base_url().'ArchivosPresupuesto/'.$row->id.'/'.$row->archivoNombreXML.'"') ?>>Descargar XML</a>                                             
                                                
                                              <?php }else{ ?>
                                              No hay XML<?php } ?></td>
                                            <td>
                                        <?php if($row->archivoNombrePDF!=""){ ?>
                                                
                                                  <a target="_blank" class="btn btn-primary btn-xs contact-item" href=<?php echo('"'.base_url().'ArchivosPresupuesto/'.$row->id.'/'.$row->archivoNombrePDF.'"') ?>>Descargar PDF</a>                                                                                             
                                              <?php }else{ ?> No hay PDF<?php } ?>
                                            </td>

                                             <td><?
                                                if($row->posteriorapago=='0'){echo "Factura Pospuesta"; }
                                                if($row->posteriorapago=='1'){echo "Factura Normal"; }
                                                 if($row->posteriorapago=='2'){echo "Caja Chica"; }
                                                if($row->posteriorapago=='3'){echo "Toka";  }
                                                if($row->posteriorapago=='4'){echo "Amex"; }
                                                if($row->posteriorapago=='5'){echo "Nomina y Otros";  }
                                                if($row->posteriorapago=='6'){echo "Suma Caja Chica";  }          
                                                if($row->posteriorapago=='9'){echo "DINNERCAP"; }
                                                  ?></td>   


										</tr>
							<?php
									}
								}
							?>
							</tbody>
                            <?
								if($totalResultados == 0){?><tfoot><tr><td colspan="4"><center><b>No se encontraron registros.</b></center></td></tr></tfoot><?}
							?>
						</table>
               		</div>

    <div id="DivFooterRow" style="overflow:hidden"></div></div>
 <div class="row"><div class="col-md-12"><small><i>Total de resultados: <b><?=$totalResultados?></b></i></small></div></div>
</section>

 
<div id="divModalGenerico" class="modalCierra">

    <div id="divModalContenidoGenerico" class="modal-contenido"  >
      <div class="row" >
      <div class="col-md-2 col-sm-2" >
      <button onclick="abrirModalFecha(this)" style="color: white;background-color:red; border:double;">X</button>
 </div>
      <div class="col-md-10 col-sm-10">
       <h2>CAPTURA DE FECHA</h2>
      </div>
    </div>  
<hr>
<div class="row" ><div class="col-md-4 col-sm-4"><label class="label label-info">ID DE FACTURA</label></div><div class="col-md-6 col-sm-6"><label id="usuarioFacturaID" class="label label-warning"></label></div> <br> </div>
<div class="row"><div class="col-md-4 col-sm-4"><label class="label label-info">USUARIO</label></div><div class="col-md-6 col-sm-6"><label id="usuarioFacturaFolio" class="label label-warning"></label></div><br>  </div>
<div class="row" ><div class="col-md-4 col-sm-4"><label class="label label-info">FOLIO DE FACTURA</label></div><div class="col-md-6 col-sm-6"><label id="usuarioFacturaEmail" class="label label-warning"></label></div><br> <br><br> </div>
<div class="row">

  <form id="grabarFechaForm" method="GET" action="">
  <input type="hidden" name="IDFact" id="IDFact">
  <input type="hidden" name="IDUser" id="IDUser">
  <div class="col-md-8 col-sm-8"> <input type="date" name="1fNacimiento" class="form-control"></div>
  <div class="col-md-4 col-sm-4"><button class="btn btn-success">Guardar</button></div>

  </form>
</div>
</div>

</div>

<?php $this->load->view('footers/footer'); ?>
<style type="text/css"> body{overflow: scroll;}
.modalCierra{background-color: rgba(0,0,0,.8);position:fixed;top:0;right:0;bottom:0px;left:0;opacity:0;transition: all 1s;display:none;relative;z-index: 1000}
.modalAbre{background-color: rgba(0,0,0,.8);position:fixed;top:0;right:0;bottom:0px;transition: all 1s;width:100%;height:100%;z-index: 10000}
.modal-contenido{background-color:white;width:40%;height:70%;padding: 0% 0%;margin: 0% auto;position: relative;top: 20%;bottom: -20% }
</style>
<script type="text/javascript">
  function abrirModalFecha(objeto)
  {
      document.getElementById('divModalGenerico').classList.toggle('modalCierra');
      document.getElementById('divModalGenerico').classList.toggle('modalAbre');
      let row=objeto.parentNode.parentNode;
      document.getElementById('usuarioFacturaID').innerHTML=row.dataset.id;
      document.getElementById('usuarioFacturaFolio').innerHTML=row.dataset.usuario;
      document.getElementById('IDFact').value=row.dataset.id;
      document.getElementById('IDUser').value=row.dataset.usuario;
      document.getElementById('usuarioFacturaEmail').innerHTML=row.dataset.folio;
      document.getElementById('grabarFechaForm').setAttribute('action',objeto.dataset.href)
  }
  console.log("<?=$fec_inicio?>")
document.getElementById('fec_inicial').value="<?=$fec_inicio;?>"
document.getElementById('fec_final').value="<?=$fec_final;?>"
</script>