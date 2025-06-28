<?php
$busquedaUsuario = $this->input->get('busquedaUsuario', TRUE);
$totalResultados = $Listafacturas->num_rows();
?>
<?php $this->load->view('headers/header'); ?>

<?php $this->load->view('headers/menu');?>

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



function Suma(){

    var sumita;
    var CargoFianzas= document.getElementById("CargoFianzas").value 
    var CargoInst= document.getElementById("CargoInst").value 
    var CargoGes= document.getElementById("CargoGes").value 
    var CargoPromMer= document.getElementById("CargoPromMer").value 
    var CargoPromCan= document.getElementById("CargoPromCan").value 
    var Corporativos= document.getElementById("Corporativos").value

    sumita=Number(CargoFianzas)+Number(CargoInst)+Number(CargoGes)+Number(CargoPromMer)+Number(CargoPromCan)+Number(Corporativos);

           document.getElementById("CargoTotal").value = sumita;
           document.getElementById("CargoTotalconIVA").value = sumita;

  }


 
 </script>

<script>
      
   <?php if(isset($Respuesta)){ ?>
    alert(<?php echo('"'.$Respuesta.'"'); ?>);
    <?php } ?>           

  function enviaArchivo(){

    $(function()
    {$("#formuploadajax").on("submit", function(e){
     e.preventDefault();
     var f = $(this);
     var formData = new FormData(document.getElementById("formuploadajax"));
     $.ajax({url:"<?php echo(base_url().'presupuestos/GuardarArchivo/')?>",
      type: "post",
      dataType: "html",
      data: formData,
      cache: false,
      contentType: false,
      processData: false
          })
      .done(function(res){
        $("#mensaje").html("Respuesta: " + res);
       });
      });
    });
  }



//alert(window.location.href );

 function cambiaForm(objeto)
 {
document.getElementById("miModal").classList.remove("modalCierra");
  document.getElementById("miModal").classList.add("modalAbre");
   document.getElementById("Modalcontenido").style.display="block";

   var formData = new FormData(objeto);
   $.ajax({url:"<?php echo(base_url().'presupuestos/GuardarArchivo/')?>",
     type: "post",dataType: "html",data: formData,cache: false,
     contentType: false,processData: false,
     success : function(datat)
     {
     
      var j=JSON.parse(datat);   
      if(j.status==0){             
      var cadena='<select><option value="'+j.ruta+'"">';
      cadena=cadena+'Descargar</option><option value="'+j.archivo+'"">';
      cadena=cadena+'Eliminar</option></select><button onclick="opcionesArchivo(this)">OK</button>';  
      objeto.parentNode.innerHTML=cadena;
       }
       else
       {
        alert(j.mensaje);        
        for(var i=0; i<objeto.childNodes.length;i++){
          if(objeto.childNodes[i].nodeName=="INPUT"){
           if(objeto.childNodes[i].type=="file"){
            objeto.childNodes[i].value="";
           }
          }
        }
       }
         document.getElementById("miModal").classList.add("modalCierra");
   document.getElementById("miModal").classList.remove("modalAbre");
     document.getElementById("Modalcontenido").style.display="none";
     }
  })
  
    
 }

 function opcionesArchivo(objeto){
var obj=objeto.parentNode;
for (i = 0; i < obj.childNodes.length; i++) 
{if( obj.childNodes[i].nodeName=="SELECT")
  {var sel=obj.childNodes[i].selectedIndex;
   if(obj.childNodes[i].options[sel].text=="Descargar")
   {
    //document.location=obj.childNodes[i].value;
    window.open(obj.childNodes[i].value, '_blank');
   }
   else
   {var parametros = {"id" :obj.childNodes[i].value};
    var direccion= "<?php echo(base_url().'presupuestos/modificaArchivo/')?>";
    $.ajax({method: "POST",data:parametros,url : direccion,dataType: "html",
    success : function(datat)
    { var j=JSON.parse(datat);   
      var cadena='<label class="EtiquetaFile" >Agregar'+j.tipo+'</label>';
      cadena=cadena+'<form onchange="cambiaForm(this)" enctype="multipart/form-data" method="post">';
      cadena=cadena+'<input type="hidden" value="'+j.id+'"name="id">';
      cadena=cadena+'<input type="hidden" value="'+j.tipo+'"name="tipo">';
      cadena=cadena+'<input type="file" name="Archivo" class="Archivo1"></form>';
      objeto.parentNode.innerHTML=cadena;
     }
    });
   }  
  }
}
}
</script>

 <div class="="row">
 <div  class="col-md-3 col-sm-3 col-xs-3"><h4 class="titulo-secciones">VALIDAR FACTURAS</h4></div>
  <div>TOTAL DE FACTURAS: <b><?=$totalResultados?></b></div>
 </div>


    
    <div   id="DivMainContent" style="height: 300px;width: 90%;overflow: scroll;">        
           
						<table class="table" id='Mitabla'>
							<thead style="position: sticky;top: 0px;z-index: 10">
		              <tr>
         
                  <th>Id</th>
                  <th>Fecha Factura</th>
									<th>Folio</th>				                                
									<th>Concepto</th>			                                
                  <th>Subtotal</th>                  
                  <th>Total a pagar</th>
                  <th>Validar</th>
                  <th>Usuario</th>
                  <th>Cuenta contable</th>
                  <th>Departamento</th>
                  <th>Proveedor</th>
                  <th>Agregar XML</th>
                  <th>Agregar PDF</th>
                  <th>Tipo Compra</th>

									
								</tr>
							</thead>
							<tbody>   
							<?php
								if($Listafacturas != FALSE){
									foreach ($Listafacturas->result() as $row){
							?>

                
                                           
                                            <td><?=$row->id?></td>
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
                                            
                                            <td>$<?=number_format($row->totalconiva,2)?></td>

                                            <td>
<!--
                                        <a href="<?=base_url()?>presupuestos/ValidaFactura?IDFact=<?php echo $row->id?>"
                      .?IDCL=. class='btn btn-primary btn-xs contact-item' data-toggle="modal"  data-original-title><span class="glyphicon glyphicon-pencil" ></span>Validar</a>
-->
<a href="<?=base_url()?>presupuestos/ValidaFactura?IDFact=<?php echo $row->id?>" class='btn btn-primary btn-xs contact-item' data-original-title><span class="glyphicon glyphicon-pencil" ></span>Validar</a>
                                              </td>
                                 

                                            <td><? echo $this->capsysdre->NombreUsuarioEmail($row->Usuario); ?></td>
                                            <td><?=($row->cuentaContable); ?></td>
                                            <td><?=($row->personaDepartamento); ?></td>
                                            <!--<td><?=$row->fecha_pago?></td>-->
                                            <td><? echo $this->capsysdre->GetNombreProveedor($row->idProveedor) ?></td>
                                                                                      <td>
                                              <?php if($row->archivoNombreXML!=""){ ?>
                                                <select>
                                                  <option value=<?php echo('"'.base_url().'ArchivosPresupuesto/'.$row->id.'/'.$row->archivoNombreXML.'"') ?>>Descargar</option>                                             
                                                  <option value=<?php echo('"'.$row->archivoNombreXML.'"') ?> >Eliminar</option>
                                                </select>
                                                <button onclick="opcionesArchivo(this)">OK</button>
                                              <?php }else{ ?>
                                              <div class="divContenedor">
                                              <label class="EtiquetaFile">Agregar XML</label>
                                              <form action="<?php echo(base_url().'presupuestos/GuardarArchivo/')?>"    enctype="multipart/form-data"  method="post"  >
                                                <input type="hidden" value=<?php echo('"'.$row->id.'"') ?> name="id"> 
                                                <input type="hidden" value="xml" name="tipo">
                                               <input type="file" name="Archivo"  class="Archivo1"  onchange="if(!this.value.length)return false; this.form.submit();">                                              
                                              </form>
                                               </div><?php } ?></td>
                                          <td>        <?php if($row->archivoNombrePDF!=""){ ?>
                                                <select>
                                                  <option value=<?php echo('"'.base_url().'ArchivosPresupuesto/'.$row->id.'/'.$row->archivoNombrePDF.'"') ?>>Descargar</option>                                             
                                                  <option value=<?php echo('"'.$row->archivoNombrePDF.'"') ?> >Eliminar</option>
                                                </select>
                                                <button onclick="opcionesArchivo(this)">OK</button>
                                              <?php }else{ ?>
                                              <div class="divContenedor">
                                              <label class="EtiquetaFile">Agregar PDF</label>
                                              <form action="<?php echo(base_url().'presupuestos/GuardarArchivo/')?>"  enctype="multipart/form-data"  method="post">
                                                <input type="hidden" value=<?php echo('"'.$row->id.'"') ?> name="id">
                                                <input type="hidden" value="xml" name="tipo">
                                               <input type="file" name="Archivo"  class="Archivo1" onchange="if(!this.value.length)return false; this.form.submit();">                                              
                                              </form>
                                               </div><?php } ?></td>
                                          <td><?
                                                if($row->posteriorapago=='0')
                                                    echo "Factura Pospuesta"; 
                                                if($row->posteriorapago=='1')
                                                    echo "Factura Normal"; 
                                                 if($row->posteriorapago=='2')
                                                    echo "Caja Chica"; 
                                                if($row->posteriorapago=='3')
                                                    echo "Toka";  
                                                if($row->posteriorapago=='4')
                                                    echo "Amex"; 
                                                if($row->posteriorapago=='5')
                                                    echo "Nomina y Otros";     

                                                 if($row->posteriorapago=='9')
                                                    echo "DINNERCAP";     

                                                  ?></td>     


										</tr>
							<?php
									}
								}
							?>
							</tbody>
                            <?
								if($totalResultados == 0){
							?>
                            <!--tfoot>
                            	<tr>
                                	<td colspan="4"><center><b>No se encontraron registros.</b></center></td>
                                </tr>
                            </tfoot-->
                            <?
								}
							?>
						</table>
               		
</div>

 <!--div class="row">
             <div class="col-md-12"><small><i>Total de resultados: <b><?=$totalResultados?></b></i></small></div>
 </div-->











  <style type="text/css">
 .EtiquetaFile{position: relative; top: 30px; width: 150px; border: solid; ;}
 .Archivo1{opacity: 0; width: 150px}
 .divContenedor{width: 150px}
 .divContenedor:hover label{background:#d8d8d8}
 body{overflow: scroll;}
 #DivMainContent::-webkit-scrollbar{width: 20px;border-radius: 0px;background-color: white}
 #DivMainContent::-webkit-scrollbar-track 
 {
  border-radius:0px;
  background: white;        /* color of the tracking area */
  border: 5 solid red
}

#DivMainContent::-webkit-scrollbar-thumb {
  background-color: background: #37383a;    /* color of the scroll thumb */
  border-radius: 0px;       /* roundness of the scroll thumb */
  border: 3px solid white;  /* creates padding around scroll thumb */
}
 </style>
<?php $this->load->view('footers/footer'); ?>

<script type="text/javascript">
  document.getElementById("miModal").classList.add("modalCierra");
   document.getElementById("miModal").classList.remove("modalAbre");
     document.getElementById("Modalcontenido").style.display="none";




</script>
