<?php
	$corte = 0;
	$columnas = 3;
    $totalProductos = 0;
    $totalPuntos=0;
?>
<?php 
	$this->load->view('headers/header'); 
?>
<!-- Navbar -->
<?php
	$this->load->view('headers/menu');
?>
<!-- End navbar -->

<section class="container-fluid breadcrumb-formularios">
        <div class="row">
            <div class="col-md-6 col-sm-5 col-xs-5"><h3 class="titulo-secciones">Tienda</h3></div>
            <div class="col-md-6 col-sm-7 col-xs-7">
                <ol class="breadcrumb text-right">
                    <li><a href="./">Inicio</a></li>
                    <li><a href="<?php echo base_url(); ?>tienda">Tienda</a></li>
                    <li class="active">Productos</li>
                </ol>
            </div>
        </div>
            <hr /> 
        <?php $this->load->view('tienda/tiendaestatus',$tiendaestatus); ?>
</section>
<br />
<section class="page-section">
	<div class="container">
		
        <div class="row">
            <div class="col-md-12">

                <table class="table">
                    <tbody>
                        <?php foreach ($misProductos as $value) { ?>
                            <tr>
                                <td><img src="<?php echo base_url()."assets/img/tienda/articulos/".$value['data'][0]->img_link; ?>" width="150" height="124" /></td>
                                <td>
                                    <div class="row">
                                        <div class="col-md-12">
                                            <?php echo urldecode($value['data'][0]->nombre); ?>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-12">
                                            Cantidad: <?php echo $value['cantidad'];?>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-12">
                                            Precio por unidad: <?php echo '$'.number_format($value['data'][0]->precio,2,'.',',');?>
                                        </div>
                                    </div>
                                </td>   
                                <td class="text-right">
                                    <div class="row">
                                        <div class="col-md-12">
                                            Eliminar: <a href="<?php echo "cancelarproducto/".$value['data'][0]->idArticulo; ?>" class="glyphicon glyphicon-trash" title="Cancelar Pedido" onClick="return validar('&iquest;Esta seguro que desea eliminar el producto?')"></a>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-12">
                                             <?php 
                                             $total = $value['cantidad'] * $value['data'][0]->precio;
                                             $totalProductos = $totalProductos + $total;
                                             echo '$'.number_format($total,2,'.',',');?>
                                        </div>
                                        <div class="col-md-12">
                                             <?php 
                                             $total = $value['cantidad'] * $value['data'][0]->puntos;
                                             $totalPuntos = $totalPuntos + $total;
                                             //echo '$'.number_format($total,2,'.',',');
                                               echo $total." puntos";
                                             ?>
                                        </div>
                                    </div>
                                </td>
                            </tr>
                        <?php } ?>
                    </tbody>
              <?php  if($this->tank_auth->get_usermail()=='AUDITORINTERNO@AGENTECAPITAL.COM' ||
$this->tank_auth->get_usermail()=='DIRECTORGENERAL@AGENTECAPITAL.COM' || $this->tank_auth->get_usermail()=='SISTEMAS@ASESORESCAPITAL.COM' || $this->tank_auth->get_usermail()=='MARKETING@AGENTECAPITAL.COM'){?>                    
                    <tfoot>
                        <tr>
                            <td><h4>
                                <label class="label label-primary" for="selectVendedores">Agentes:</label></h4>
                                <select id="selectVendedores" name="selectVendedores" onchange="conectaAJAX('traeClientes')" class="form-control selcls"></select><br>
                                <h4>
                                    <label class="label label-primary" for="selectClientes">Clientes:</label></h4>
                                    <select class="form-control selcls"  id="selectClientes" name="selectClientes" onchange="conectaAJAX('traePuntos')"></select><br><button class="btn-success btn-lg" onclick="cambiarPorPuntos(<?php echo ($totalPuntos);?>)">Cambiar por puntos</button></td>                        
                            <td><h1><label id="labelPuntos" class="label label-primary"></label></h1><h1><label class="label label-primary">Puntos</label></h1><br></td>
                            <td class="text-right" colspan="3">
                               Importe Total:  <?php echo '$'.number_format($totalProductos,2,'.',',');?><br>
                                Puntos Total:  <?php echo ($totalPuntos." puntos");?>
                               
                            </td>

                        </tr>
                     
                    </tfoot>
                       <?php } ?>
                </table>
       
                <div class="row">
                    <div class="col-md-2">
                        <input id="btnCrear" type="button" class="form-control input-sm" value="Crear pedido" /> 
                    </div>
                </div>
            </div>
        </div>		

	</div>            
</section>

<script type="text/javascript">
var url=<?php echo('"'.base_url().'";') ;?>
function onchangeSelectClientes(){
    document.getElementById("labelPuntos").innerHTML="Puntos";
}
function cambiarPorPuntos(puntos){

    
     if(parseInt(document.getElementById("labelPuntos").innerHTML)){
    var puntosDisponibles=parseInt(document.getElementById("labelPuntos").innerHTML);
     var puntosProducto=parseInt(puntos);
      conectaAJAX('cambiarPuntos');
    /*if(puntosProducto>puntosDisponibles){
        alert("No se tienen los puntos Disponibles");
    }
    else{
        alert("El cambio se realizo con exito");
        conectaAJAX('cambiarPuntos');
    }*/
  }
  else
  {if(document.getElementById("labelPuntos").innerHTML==0){alert("El cliente no tiene puntos");}
    else{alert("consulte los puntos del cliente");}
  }
}
function conectaAJAX(opcion){

    var direccionAJAX=url;
    switch(opcion){
        case 'traeClientes':direccionAJAX=direccionAJAX+'tienda/buscarPuntosPorAgente/?idPersona='+document.getElementById('selectVendedores').value; break;
        case 'traePuntos':direccionAJAX=direccionAJAX+'tienda/obtenerPuntosCliente/?IDVend='+document.getElementById('selectClientes').value; break;
        case 'cambiarPuntos':direccionAJAX=direccionAJAX+'tienda/cambiarProductosPorPuntos/?IDClie='+document.getElementById('selectClientes').value+"&idPersona="+document.getElementById('selectVendedores').value; break;
    }
  var req = new XMLHttpRequest();
  req.open('GET',direccionAJAX, true);
   req.onreadystatechange = function (aEvt) 
  {
    if (req.readyState == 4) {if(req.status == 200)
    {  var respuesta=JSON.parse(this.responseText);  
       
       
         switch(opcion){
            case 'traeClientes':
                          console.log(respuesta); 
              
             var cant=respuesta.length;
              var cadena="";
              cadena=cadena+'<option value="-1">Escoger cliente</option>';
                for(var i=0;i<cant;i++){
                  cadena=cadena+'<option value="'+respuesta[i].IDCli+'">'+respuesta[i].nombreCliente+'</option>';
                }
               
               document.getElementById('selectClientes').innerHTML=cadena;
            break;
            case 'traePuntos':

            document.getElementById("labelPuntos").innerHTML=respuesta;
             
            break;
            case 'cambiarPuntos':
                 console.log(respuesta);
                 alert(respuesta);
                 if(respuesta=="Cambio satisfactorio"){
               window.location.replace(url+'tienda/misproductos');}
            break;
         }
                                            
    }     
   }
  };
 req.send();
}



    $(document).ready(function(){
       $('#btnCrear').click(function(){
          $.ajax({
			url: "<?php echo base_url().'tienda/crearpedido'; ?>",
			type: 'POST',
			success: function (data) {
				if(data == 'true'){
                    alert("Se guardo con \u00e9xito");
                    location.href = "<?php echo base_url().'tienda'; ?>";
                }
                else{
                    alert('Error al guardar el pedido.');
                }
			}
		  });
       });
    });

<?php
$option="";  
if(isset($agentesPromocion)){
    $option=$option.'<option value=\'-1\'>Escoger agente</option>';
foreach ($agentesPromocion as  $value) {
   $option=$option.'<option value=\''.$value->idPersonaP.'\'>'.$value->nombres.' '.$value->apellidoPaterno.' '.$value->apellidoMaterno.'</option>';  
  }
  echo('document.getElementById("selectVendedores").innerHTML="'.$option.'";');
}
?>
  
</script>
<?php $this->load->view('footers/footer'); ?>