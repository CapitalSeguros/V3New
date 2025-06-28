<?php
$busquedaUsuario = $this->input->get('busquedaUsuario', TRUE);
$totalResultados = $Listafacturas->num_rows();
$sumapre = $presuma;

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
   MakeStaticHeader('Mitabla', 550, 1750, 40, false)
}

 function traeInfo() {
    //var valor=document.getElementById("usuariosPresupuestosSelect").value;
    //
    //   /*$.ajax({url:"<?php //echo(base_url().'presupuestos/devuelveFacturasUsuario/')?>",
     //type: "POST",dataType: "html",data: {parametros},/
    //
    //
   
   var parametros = {"id" :document.getElementById("usuariosPresupuestosSelect").value};
   var direccion="<?php echo(base_url().'presupuestos/devuelveFacturasUsuario/'); ?>";
   $.ajax({method: "POST",data: parametros ,url : direccion,dataType: "html",
     success : function(datat)
     {    
     
       j=JSON.parse(datat);   
      //console.log(j.tabla);  
        //alert(j.totalFacturas[0]['mes']);  
        var objInsertar='<table border="1" class="tablaReporte">';
        objInsertar=objInsertar+'<thead><tr class="cabecera"><td>Mes</td><td>Presupuesto total</td><td>Autorizado</td><td>Pagado</td><td>Gastos totales</td><td>Saldo mes</td></tr></thead>';
         objInsertar=objInsertar+'<tbody>';
        var tamanio=j.tabla.length;
        var sumPresupuestos=0;
        var sumGastos=0;
        var sumAutorizado=0;
        var sumPagado=0;
        var sumSaldo=0;
        for(var i=0;i<tamanio;i++){
         objInsertar=objInsertar+'<tr>';
         objInsertar=objInsertar+'<td  class="tdPrimerCol">'+j.tabla[i][0]+'</td>';
         objInsertar=objInsertar+'<td align="right" class="tdCol">'+'$'+new Intl.NumberFormat('es-MX').format(j.tabla[i][1])+'</td>';
          objInsertar=objInsertar+'<td align="right" class="tdCol">'+'$'+new Intl.NumberFormat('es-MX').format(j.tabla[i][3])+'</td>'
                objInsertar=objInsertar+'<td align="right" class="tdCol">'+'$'+new Intl.NumberFormat('es-MX').format(j.tabla[i][4])+'</td>'
         objInsertar=objInsertar+'<td align="right" class="tdCol">'+'$'+new Intl.NumberFormat('es-MX').format(j.tabla[i][2])+'</td>';
         objInsertar=objInsertar+'<td align="right" class="tdSegundaCol">'+'$'+new Intl.NumberFormat('es-MX').format((j.tabla[i][1]-j.tabla[i][2]))+'</td>'
         objInsertar=objInsertar+'</tr>'; 
         sumPresupuestos=sumPresupuestos+parseFloat(j.tabla[i][1]);
         sumGastos=sumGastos+parseFloat(j.tabla[i][2]);
         sumAutorizado=sumAutorizado+parseFloat(j.tabla[i][3]);
         sumPagado=sumPagado+parseFloat(j.tabla[i][4]);
         sumSaldo=sumSaldo+(j.tabla[i][1]-j.tabla[i][2]);
        }
         objInsertar=objInsertar+'<tr>';
         objInsertar=objInsertar+'<td class="tdPrimerCol">TOTALES</td>'
         //objInsertar=objInsertar+'<td class="tdPrimerCol">'+sumPresupuestos+'</td>'
         objInsertar=objInsertar+'<td align="right" class="tdPrimerCol">'+'$'+new Intl.NumberFormat('es-MX').format(sumPresupuestos)+'</td>'
         objInsertar=objInsertar+'<td align="right" class="tdPrimerCol">'+'$'+new Intl.NumberFormat('es-MX').format(sumAutorizado)+'</td>'
         objInsertar=objInsertar+'<td align="right" class="tdPrimerCol">'+'$'+new Intl.NumberFormat('es-MX').format(sumPagado)+'</td>'
         objInsertar=objInsertar+'<td align="right" class="tdPrimerCol">'+'$'+new Intl.NumberFormat('es-MX').format(sumGastos)+'</td>'
         objInsertar=objInsertar+'<td align="right" class="tdPrimerCol">'+'$'+new Intl.NumberFormat('es-MX').format(sumSaldo)+'</td>'
        objInsertar=objInsertar+'</tr>'; 
       objInsertar=objInsertar+'</tbody>';
        objInsertar=objInsertar+'</table>';
        document.getElementById('tablaReporte').innerHTML=objInsertar;



    }
    })
  }
 </script>
<div style="width: 99%; height: 200px;border: double;overflow: scroll;">
<div>
  <select id="usuariosPresupuestosSelect">
     <option>TODOS</option>
      <?php foreach ($usuariosPresupuestos->result() as $row){ ?>

          <option><?php echo($row->usuario); ?></option>
      <?php } ?>}
  </select><button onclick="traeInfo()" class='btn btn-primary btn-xs contact-item'>Buscar</button>
</div>
<div id="tablaReporte" >

</div>
</div>

 <section class="container-fluid breadcrumb-formularios">
 <div  class="col-md-3 col-sm-3 col-xs-3"><h4 class="titulo-secciones">Autoriza Pagos</h4></div>
 </section>



<section class="container-fluid breadcrumb-formularios">

<div id="DivRoot" align="left">


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
									<th>FolioFac</th>				                                
									<th>Concepto</th>			                                
									<!--<th>Fianzas</th>
									<th>Institucional</th>	
									<th>Gestion</th>	
		              <th>PromoMID</th>
									<th>PromoCUN</th>
                  <th>Corporativo</th>-->
                  <th>SubTotal</th>
               

                  <th>AcumuladoMes</th>
                  <th>LimiteMes</th>
                  <th>AcumuladoAnual</th>
                  <th>LimiteAnual</th>

                  <th>Autorizado</th>
                  <th>Proveedor</th>

									
								</tr>
							</thead>
							<tbody>   
							<?php
								if($Listafacturas != FALSE){
									foreach ($Listafacturas->result() as $row){
							?>
										<tr>

                    
                    <!-- <td>
                      <a href="<?=base_url()?>presupuestos/editFactura?IDFact=<?php echo $row->id?>"
                      .?IDCL=. class='btn btn-primary btn-xs contact-item' data-toggle="modal"  data-original-title><span class="glyphicon glyphicon-pencil" ></span>Editar</a>
                      </td>-->
                                            <td><?=$row->id?></td>
                                            <td><? echo $this->capsysdre->NombreUsuarioEmail($row->Usuario); ?></td>
                                            <td><?=$row->fecha_factura?></td> 
		                                      	<td><?=$row->folio_factura?></td>
                                            <td><?=$row->concepto?></td>
                                            <!--<td>$<?=$row->montofianzas?></td>
                                            <td>$<?=$row->montoinstitucional?></td>
                                            <td>$<?=$row->gestion?></td>
                                            <td>$<?=$row->promomid?></td>
                                            <td>$<?=$row->promocun?></td>
                                            <td>$<?=$row->corporativo?></td>-->

                                            <td>$<?=number_format($row->totalfactura,2)?></td>
                                        

                                            <td>$<?
                                            if($row->posteriorapago=='1')
                                            { 
                                                $cadena=$row->fecha_factura;

                                                $mes = substr("$cadena", 5, 2);
                                                $ano = substr("$cadena", 0, 4);
                                                

                                              $acumuladoMes=$this->capsysdre->GetAcumuladoMes($row->Usuario,$mes,$ano);
                                              echo (number_format($acumuladoMes,2));
                                            }
                                            ?></td>


                                            <td>$<?

                                            if($row->posteriorapago=='1')
                                            { 
                                                $cadena=$row->fecha_factura;

                                                $mes = substr("$cadena", 5, 2);
                                                

                                              $LimiteMes=$this->capsysdre->GetLimiteMes($row->Usuario,$mes);
                                              echo (number_format($LimiteMes,2));
                                            }

                                            ?></td>


                                            <td>$<?
                                            if($row->posteriorapago=='1')
                                            { 

                                                $cadena=$row->fecha_factura;

                                                $ano = substr("$cadena", 0, 4);
                                              
                                              $acumuladoAno=$this->capsysdre->GetAcumuladoAno($row->Usuario,$ano);
                                              echo (number_format($acumuladoAno,2));
                                            }
                                            ?></td>


                                           <td>$<?

                                            if($row->posteriorapago=='1')
                                            { 
                                              
                                              $LimiteAno=$this->capsysdre->GetLimiteAno($row->Usuario);
                                              echo (number_format($LimiteAno,2));
                                            }

                                            ?></td>




                                            <td>

                                             <a href="<?=base_url()?>presupuestos/AutorizaFactura?IDFact=<?php echo $row->id?>"
                      .?IDCL=. class='btn btn-primary btn-xs contact-item' data-toggle="modal"  data-original-title><span class="glyphicon glyphicon-pencil" ></span>Autorizar</a>


                                            </td>
                                            <td><? echo $this->capsysdre->GetNombreProveedor($row->idProveedor) ?></td>


										</tr>
							<?php
									}
								}
							?>
							</tbody>
                            <?
								if($totalResultados == 0){
							?>
                            <tfoot>
                            	<tr>
                                	<td colspan="4"><center><b>No se encontraron registros.</b></center></td>
                                </tr>
                            </tfoot>
                            <?
								}
							?>
						</table>
               		</div>

    <div id="DivFooterRow" style="overflow:hidden">
    </div>
</div>

 <div class="row">
            <!-- <div class="col-md-12"><small><i>Total de resultados: <b><?=$totalResultados?></b></i></small></div>-->
               <div class="col-md-12"><i>Suma de SubTotales a Autorizar: <b><? echo "$"; echo number_format($sumapre,2); ?></b></i></div>
 </div>


</section>

 
<?php $this->load->view('footers/footer'); ?>
<style type="text/css">
  .cabecera{background-color: rgba(197,217,241,1);color: rgba(0,0,0,1);}
  .tablaReporte{padding: 2px;border: 1px solid #4CAF50; margin-left: 50px}
  .tdPrimerCol{background-color: rgba(220,230,241,1);color: rgba(0,0,0,1);}
  .tdSegundaCol{background-color: rgba(198,239,206,1);color: rgba(0,97,0,1);}
  .tdCol{background-color: rgba(255,255,255,1);color: rgba(0,0,0,1);}

</style>