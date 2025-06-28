<?php
$busquedaUsuario = $this->input->get('busquedaUsuario', TRUE);
$totalResultados = $ListaProveedores->num_rows();
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
   MakeStaticHeader('Mitabla', 350, 1450, 40, false)
}
 </script>


<section class="container-fluid breadcrumb-formularios">
   </br>
    <div class="row">
            <div  class="col-md-3 col-sm-3 col-xs-3"><h4 class="titulo-secciones">Alta Proveedor</h4></div>

     </div>
   </br>

  <form  class="form-horizontal" role="formreferidos"
            id="formreferidos" name="formreferidos"
            method="post" 
            action="<?=base_url()?>presupuestos/Guardar/" > 

<div class="row">
         <div class="col-sm-6 col-md-6"> 
            <label class="etiquetaSimple">Razon de Proveedor:</label>
            <input type="text"  name="nombre" id="nombre" placeholder="Razon del Proveedor" class="form-control" required="">  
        </div>

         <div class="col-sm-6 col-md-6"> 
            <label class="etiquetaSimple">Nombre de Contacto:</label>
            <input type="text"  name="nombrecon" id="nombrecon" placeholder="Nombre de Contacto" class="form-control" required="">  
        </div>
</div>
<br>
<div class="row">
            <div class="col-md-3 col-sm-3 col-xs-3"> 
            
            <label class="etiquetaSimple">Direccion:</label>
            <input type="text"  name="direccion" id="direccion" placeholder="Direccion" class="form-control" required="">  
        </div>
          <div class="col-md-3 col-sm-3 col-xs-3"> 
            <label class="etiquetaSimple">Telefono:</label>
            <input type="text"  name="telefono" id="telefono" placeholder="Telefono" onKeypress="if (event.keyCode < 45 || event.keyCode > 57) event.returnValue = false;" class="form-control" required="">  
        </div>

        <div class="col-md-3 col-sm-3 col-xs-3"> 

            <label class="etiquetaSimple">Celular:</label>
            <input type="text"  name="cel" id="cel" placeholder="Telefono Celular" onKeypress="if (event.keyCode < 45 || event.keyCode > 57) event.returnValue = false;" class="form-control" required="">  
        </div>
        
    <div class="col-md-3 col-sm-3 col-xs-3"> 

            <label class="etiquetaSimple">Email:</label>
            <input type="text"  name="email" id="email" placeholder="Email" pattern="[a-zA-Z0-9_]+([.][a-zA-Z0-9_]+)*@[a-zA-Z0-9_]+([.][a-zA-Z0-9_]+)*[.][a-zA-Z]{1,5}" class="form-control" required="">  
        </div>

</div>
<br>
<div class="row"> 

          <div class="col-md-3 col-sm-3 col-xs-3"> 
            </br>  
            <label class="etiquetaSimple">Banco:</label>
            <input type="text"  name="banco" id="banco" placeholder="Banco" class="form-control" required="">  
        </div> 

          <div class="col-md-3 col-sm-3 col-xs-3"> 
            </br>  
            <label class="etiquetaSimple">Cuenta:</label>
            <input type="text"  name="cuenta" id="cuenta" placeholder="Cuenta" class="form-control" required="">  
        </div>

          <div class="col-md-3 col-sm-3 col-xs-3"> 
            </br>  
            <label class="etiquetaSimple">Clave Interbancario:</label>
            <input type="text"  name="clave" id="clave" placeholder="Clave" class="form-control" required="">  
        </div>
 
</div>
<br>
<div class="row">
        <div class="col-md-3 col-sm-3 col-xs-3"> 
            <label class="etiquetaSimple">Extension:</label>
            <input type="text"  name="ext" id="ext" placeholder="Extension" class="form-control" onKeypress="if (event.keyCode < 45 || event.keyCode > 57) event.returnValue = false;">  
        </div>
         <div class="col-md-3 col-sm-3 col-xs-3"> 
             <label class="etiquetaSimple">Dias de Credito</label>
            <input type="text"  name="dias" id="dias" placeholder="Dias de Credito" onKeypress="if (event.keyCode < 45 || event.keyCode > 57) event.returnValue = false;" class="form-control" required="">  
         </div>
         <div class="col-md-3 col-sm-3 col-xs-3">
           <label class="etiquetaSimple">Giros</label><select id="giroCliente" name="giroCliente" class="form-control" ><?= catalogGiros($giros);?></select>
         </div>
  <div class="col-md-1 col-sm-3 col-xs-8">
           <button class="btn-primary btn-sm btn-xs" onclick="abrirModal(event)">Agregar giro</button>
         </div>
</div>


<div class="col-md-3 col-sm-3 col-xs-3"> 
     </br><input type="submit" name="button" id="button" value="Guardar Datos" align="left"  onclick="" class="btn-primary">
 </div>

  </form >      
 </section>    
<div>
  <br>
  
</div>

<!-- End navbar -->
<section class="container-fluid breadcrumb-formularios">
  </br>
  <hr />   
 </section>    



<section class="container-fluid breadcrumb-formularios">      

         <div class="col-md-3 col-sm-3 col-xs-3">   
         </div>

         <div class="col-md-3 col-sm-3 col-xs-3">   
         </div>  


         <div class="col-md-3 col-sm-3 col-xs-3">   
         </div>           
              
   <div class="col-md-3 col-sm-3 col-xs-3">         
                      <div class="row">
                            	   <form id="form" method="GET" action="<?=base_url()?>presupuestos/buscarProveedores">
	                            	    <div class="input-group">
	                                    <input type="text" name="busquedaUsuario" id="busquedaUsuario" class="form-control input-sm" placeholder="Buscar Proveedor">
	                                    <span class="input-group-btn"><button class="btn btn-primary btn-sm" title="Buscar"><i class="fa fa-search"></i>&nbsp;</button></span>
	                                </div>
								                </form>

                            
                      </div>

  </div>

   
 </section>
<div>
  <form method="post" action="<?=base_url()?>presupuestos/reporteProveedores">

    <label>Fecha Inicial:</label><input type="text" name="fechaInicial" class="fechaPersona" autocomplete="off">
    <label>Fecha Final</label><input type="text" name="fechaFinal" class="fechaPersona" autocomplete="off">

    <button class="btn btn-primary">Consultar</button>

  </form>
</div>


<section class="container-fluid breadcrumb-formularios">

      <div style="width: 90%;height: 400px;overflow: scroll;">
						<table class="table" id='Mitabla'>
							<thead>
		              <tr>
                      <th>Editar</th>
									    <th>NombreProv</th>	
                      <th>Celular</th> 
                      <th>Email</th> 
                      <th>DiasCredito</th> 
                      <th>NombreContacto</th> 
                      <th>Telefono</th>
                      <th>Extension</th>
                      <th>Direccion</th>
                      <th>Banco</th>
                      <th>Cuenta</th>
                      <th>Clave Interbancaria</th>
                      <th>Giro</th>
								</tr>
							</thead>
							<tbody>   
							<?php
								if($ListaProveedores != FALSE){
									foreach ($ListaProveedores->result() as $row){
							?>
										<tr>
                     <td>
                      <a href="<?=base_url()?>presupuestos/editProvee?idprovee=<?php echo $row->id?>".?IDCL=. class='btn btn-primary btn-xs contact-item'  data-original-title><span class="glyphicon glyphicon-pencil" ></span>Editar</a>
                      </td>
		                  <td><?=$row->NombreProveedor?></td>
                      <td><?=$row->telefono_movil?></td>
                      <td><?=$row->email?></td>
                      <td><?=$row->DiasCredito?></td>
                      <td><?=$row->Nombre_contacto?></td>
                      <td><?=$row->telefono1?></td>
                      <td><?=$row->extension?></td>
                      <td><?=$row->direccion?></td>
                      <td><?=$row->banco?></td>
                      <td><?=$row->cuenta?></td>
                      <td><?=$row->clabe?></td>
                      <td><?=$row->giroProveedor?></td>
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


</div>

 <div class="row">
             <div class="col-md-12"><small><i>Total de resultados: <b><?=$totalResultados?></b></i></small></div>
 </div>


</section>
    

 <div id="miModalGenerico" class="modalCierraGenerico"><div id="ModalcontenidoGenerico" class="modal-contenidoGenerico"><div class="contenidoModal"><div><button onclick="cerrarModal()" class="botonCierre">X</button></div><div><label>Nuevo giro:<input type="text" id="inputNuevoGiro" class="form-control input-sm"></label></div><div><button onclick="grabaNuevoGiro(null)">Guardar</button></div></div></div></div>



<?php $this->load->view('footers/footer'); ?>
<style type="text/css">  
   body{overflow: scroll;}
</style>
<style type="text/css">
.botonCierre{background-color: red;color:white;}
.modal-contenidoGenerico{background-color:none  ;width:80%;height:100%;left: 20%;margin: 5% auto;position: relative;z-index: 1000 } 
.modalCierraGenerico{background-color: rgba(0,0,0,.8);position:fixed;top:0;right:0;bottom:0px;left:0;opacity:0;transition: all 1s;display:none;relative;z-index: 1000}
.modalAbreGenerico{background-color: rgba(0,0,0,.8);position:fixed;top:0;right:0;bottom:0px;left:0;transition: all 1s;width:100%;height:100%;display:block;relative;z-index: 10000}
.botonCierre{background-color: red;color:white;}
.contenidoModal{border: solid;background-color: white;width: 50%;height: 60%; position: relative;left: -0%;top: -5%}
  .divTD400{width:25px;max-width: 25px;min-width: 25px}
  .divTD50{width:50px;max-width: 50px;min-width: 50px}
  .divTD75{width:75px;max-width: 75px;min-width: 75px}
  .divTD100{width:100px;max-width: 100px;min-width: 100px}
  .divTD150{width:150px;max-width: 150px;min-width: 150px}
  .divTD150{width:200px;max-width: 200px;min-width: 200px}
  .divTD150{width:300px;max-width: 300px;min-width: 300px}
  .divTD400{width:400px;max-width: 400px;min-width: 400px}


</style>
<script type="text/javascript">
       function cerrarModal(){document.getElementById("miModalGenerico").classList.add("modalCierraGenerico");document.getElementById("miModalGenerico").classList.remove("modalAbreGenerico");document.getElementById("ModalcontenidoGenerico").classList.remove("verObjeto");document.getElementById("ModalcontenidoGenerico").classList.add("ocultarObjeto");  }
 function abrirModal(e){e.preventDefault();document.getElementById("miModalGenerico").classList.remove("modalCierraGenerico");document.getElementById("miModalGenerico").classList.add("modalAbreGenerico");document.getElementById("ModalcontenidoGenerico").classList.add("verObjeto");document.getElementById("ModalcontenidoGenerico").classList.remove("ocultarObjeto");  document.getElementById('inputNuevoGiro').focus()}
</script>

<script type="text/javascript">
     function moverScroll(){
   var elmnt = document.getElementById("scrollTabla");
    var x = elmnt.scrollLeft;
document.getElementById("scrollCabecera").scrollLeft=x;
}

function grabaNuevoGiro(procesoDatos){
    
    if(procesoDatos==null){
    var datos='';
   if(document.getElementById('inputNuevoGiro').value!=''){  datos="giro="+document.getElementById('inputNuevoGiro').value;mandaAJAX('presupuestos/nuevoGiro',datos,0);}
   }else{
    var total=procesoDatos.catalogo.length;
    var opciones="";
     for(var i=0;i<total;i++){
        if(procesoDatos.catalogo[i].idGiro==procesoDatos.activo){
      opciones=opciones+'<option value="'+procesoDatos.catalogo[i].idGiro+'" selected>'+procesoDatos.catalogo[i].giro+'</option>'
        }else{
        opciones=opciones+'<option value="'+procesoDatos.catalogo[i].idGiro+'">'+procesoDatos.catalogo[i].giro+'</option>';}      
     }
 
     document.getElementById('giroCliente').innerHTML=opciones;
     cerrarModal();
   }
}
function mandaAJAX(controlador,datos,manejoRespuesta){
    //var url="http://capsys.com.mx/V3/";
    var url="<?= base_url() ;?>";
    url=url+controlador;
 var xhttp = new XMLHttpRequest();
  xhttp.onreadystatechange = function() {
    if (this.readyState == 4 && this.status == 200) {     
      var respuesta=JSON.parse(this.responseText);
      grabaNuevoGiro(respuesta);
    }
  };
  xhttp.open("POST", url, true);
  xhttp.setRequestHeader("Content-type","application/x-www-form-urlencoded");
  xhttp.send(datos);
}
</script><script type="text/javascript">
  <?php  
  function catalogGiros($datos){
    $option="";
      foreach ($datos as  $value) {$option.='<option value="'.$value->idGiro.'" >'.$value->giro.'</option>';}
      return $option;
  }

  ?>
$(function () {$(".fechaPersona").datepicker({
  closeText: 'Cerrar',prevText: 'Anterior',nextText: 'Siguiente',currentText: 'Hoy',
  monthNames: ['Enero','Febrero','Marzo','Abril','Mayo','Junio','Julio','Agosto','Septiembre','Octubre','Noviembre','Diciembre'],
  dayNames:['Domingo','Lunes','Martes','Mi&eacute;rcoles','Jueves','Viernes','S&aacute;bado'] ,
  dayNamesShort:['Dom','Lun','Mar','Mi&eacute;','Juv','Vie','S&aacute;b'],
  dayNamesMin: ['Do','Lu','Ma','Mi','Ju','Vi','S&aacute;'],
  dateFormat: 'dd/mm/yy',
  monthNamesShort:['Ene','Feb','Mar','Abr','May','Jun','Jul','Ago','Sep','Oct','Nov','Dic'],
  firstDay: 1,  
     changeMonth: true,
    changeYear: true,     
});
});

</script>

  <link rel="stylesheet" href="//code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
  <link rel="stylesheet" href="/resources/demos/style.css">
  <script src="https://code.jquery.com/jquery-1.12.4.js"></script>
  <script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>

