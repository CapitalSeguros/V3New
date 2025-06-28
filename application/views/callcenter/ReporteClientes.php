<?php
$busquedaUsuario = $this->input->get('busquedaUsuario', TRUE);
$totalResultados = $ListaClientes->num_rows();
?>
<?php
	$this->load->view('headers/header'); 
?>
<!-- Navbar -->
<?php
	$this->load->view('headers/menu');
?>

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
   MakeStaticHeader('Mitabla', 450, 1750, 40, false)
}
 </script>


<!-- End navbar -->
<section class="container-fluid breadcrumb-formularios">
        <div class="row">
            <div  class="col-md-3 col-sm-3 col-xs-3"><h3 class="titulo-secciones">Prospectos CallCenter</h3></div>
        </div>
 </section>    



 <section class="container-fluid breadcrumb-formularios"> 

    <form id="infoagente" method="GET" action="<?=base_url()?>callcenter/Reportes">   
        <div class="col-md-3 col-sm-3 col-xs-3">
              <select name="vendedorp" id="vendedorp" class="form-control input-sm" required="" >

                                     <option value="">Seleccione un Agente y haz click en Ver Detalle</option>
                                                <? 
                                                    if(!empty($ListaVendedores))
                                                    { 
                                                        foreach ($ListaVendedores->result() as $Registro) {   
                                                     ?> 

                                                    <option value="<?=$Registro->email ?>"  >   
                                                     <? print $Registro->name_complete?> </option>

                                                     <?
                                                        }
                                                        } else {
                                                        ?>
                                                            <option value="false">
                                                                Vendedor No encontrado !!!
                                                            </option>
                                                        <?
                                                        }
                                                        ?>          
              </select>       
        </div>

        <div class="col-md-3 col-sm-3 col-xs-3">
          <span class="input-group-btn">
                                                    <button class="btn btn-primary btn-sm search-trigger"><i class="fa fa-search fa-sm"></i>Ver Detalle</button>
                                </span>
                             
        </div>

    </form> 
 </section>


<section class="container-fluid breadcrumb-formularios">      

         <div class="col-md-3 col-sm-3 col-xs-3">   
         </div>

         <div class="col-md-3 col-sm-3 col-xs-3">   
         </div>           
              
   <div class="col-md-3 col-sm-3 col-xs-3">         
                      <div class="row">
                            	   <form id="form" method="GET" action="<?=base_url()?>callcenter/Reportes">
	                            	    <div class="input-group">
	                                    <input type="text" name="busquedaUsuario" id="busquedaUsuario" class="form-control input-sm" placeholder="Buscar entre la lista de Clientes">
	                                    <span class="input-group-btn"><button class="btn btn-primary btn-sm" title="Buscar"><i class="fa fa-search"></i>&nbsp;</button></span>
	                                </div>
								                </form>

                            
                      </div>

  </div>

  <div class="col-md-3 col-sm-3 col-xs-3">  


   <form id="ExportaClientes" method="GET" action="<?=base_url()?>callcenter/ExportaClientes">
                                     <button class="btn btn-primary btn-sm"
                                            name="ExportaAgentes" id="ExportaAgentes"
                                        >
                                            Exporta Clientes
                                    </button>
                                 </form>       
  
  </div>      
     
 </section>

<section class="container-fluid breadcrumb-formularios"> 
        <div>
 <label>Agente para asignar prospecto</label> <select id="emailUsuarioAsignar">
    
  </select>

</div>
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
                  <th>Eliminar</th>
                  <th>Editar</th>
                  <th>Cambiar de Agente</th>

                  <th>IDCliente</th>
									<th>ApellidoP</th>				                                
									<th>ApellidoM</th>			                                
									<th>Nombre</th>
									<th>RazonSocial</th>	
									<th>RFC</th>	
		              <th>Email1</th>
									<th>Telefono1</th>
                  <th>EdoActual</th>

                  <th>CP</th>  
                  <th>Edad</th>
                  <th>Presupuesto Desig.</th>
                  <th>Suma Asegurada</th>

              
									
								</tr>
							</thead>
							<tbody>   
							<?php
								if($ListaClientes != FALSE){
									foreach ($ListaClientes->result() as $row){
							?>
										<tr>

                                         <td>
                      <a href="<?=base_url()?>callcenter/Eliminar?EDOANT=<?php echo $row->EstadoActual?>&IDCL=<?php echo $row->IDCli?>"
                      .?IDCL=. class='btn btn-primary btn-xs contact-item' data-toggle="modal"  data-original-title><span class="glyphicon glyphicon-remove" ></span>Eliminar</a>
                      </td>

                     <td>
                      <a href="<?=base_url()?>callcenter/editPros?IDCLente=<?php echo $row->IDCli?>"
                      .?IDCL=. class='btn btn-primary btn-xs contact-item' data-toggle="modal"  data-original-title><span class="glyphicon glyphicon-pencil" ></span>Editar</a>
                      </td>
                                   <td>
                   
                            <button class='btn btn-primary btn-xs contact-item' onclick="asignarAgente('callcenter/asignaAgente',<?php echo $row->IDCli?>,'Desea reasignar a este prospecto')">Asignar a Agente</button>
                      </td>


                                            <td><?=$row->IDCli?></td> 
		                                      	<td><?=$row->ApellidoP?></td>
                                            <td><?=$row->ApellidoM?></td>
                                            <td><?=$row->Nombre?></td>
                                            <td><?=$row->RazonSocial?></td>
                                            <td><?=$row->RFC?></td>
                                            <td><?=$row->EMail1?></td>
                                            <td><?=$row->Telefono1?></td>
                                            <td><? //secambio la etiqueta a referido pero internamente l abase guarda dimension
                                             if($row->EstadoActual=='DIMENSION')
                                              {
                                                  echo "REFERIDO";
                                              }
                                              else
                                              {  
                                                echo $row->EstadoActual;

                                              }?>
                                              
                                            </td>

                                            <td><?=$row->CP?></td>
                                            <td><?=$row->edad?></td>
                                            <td><?=$row->presupuesto?></td>
                                            <td><?=$row->suma?></td>
                                           

                                          
											
		                                        <!--
		                                        <a href='".base_url()."index.php/bookmarks/eliminar/".$row->id."'>
													<span class='glyphicon glyphicon-trash'></span>
		                                    	</a>
		                                        -->
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
             <div class="col-md-12"><small><i>Total de resultados: <b><?=$totalResultados?></b></i></small></div>
 </div>

 

</section>




           
       
 
<?php $this->load->view('footers/footer'); ?>
<script type="text/javascript">
var p="";
 var direccion="<?php echo(base_url()) ;?>";
 function asignarAgente(controlador,id,mensaje){
  var confirmacion = confirm(mensaje);
  if(confirmacion){
       var formulario=document.createElement('form'); formulario.setAttribute('method','post'); formulario.action=direccion+controlador;
       formulario.id="formEnviarGeneral";  document.body.appendChild(formulario);
  switch(controlador){
    case 'callcenter/asignaAgente': 
         crearObjetosParaForm(id,"claseFormEnviar","idClie");
         crearObjetosParaForm(document.getElementById('emailUsuarioAsignar').value,"claseFormEnviar","emailAgenteAsignar");
        crearObjetosParaForm(document.getElementById('vendedorp').value,"claseFormEnviar","correoAgente");
    break;
    case 'defual': break;
  }

  //enviarFormGenerales("claseFormEnviar",direccion);
  formulario.submit();
 }
} 

function crearObjetosParaForm(datos,clase,nombre){
  var input=document.createElement('input');
  input.setAttribute('type','text');input.setAttribute('value',datos);input.setAttribute('class',clase);input.setAttribute('name',nombre);
  document.getElementById('formEnviarGeneral').appendChild(input);
}


<?php 

$option='';
 foreach ($vendedoresAsignar as  $value) {
   $option=$option.'<option value="'.$value->email.'">'.$value->nombres.' '.$value->apellidoPaterno.' '.$value->apellidoMaterno.'</option>';
 }
echo('document.getElementById("emailUsuarioAsignar").innerHTML=\''.$option.'\';');

if(isset($correoUsuario)){echo('document.getElementById("vendedorp").value=\''.$correoUsuario.'\';');}
if(isset($emailUsuarioAsignar)){echo('document.getElementById("emailUsuarioAsignar").value=\''.$emailUsuarioAsignar.'\';');}
if(isset($mensajeAlerta)){echo($mensajeAlerta);}
?>

</script>
