<?php 
	$this->load->view('headers/header'); 
	$this->load->view('headers/menu');
?>
<link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.10.21/css/jquery.dataTables.css">

<script src="https://cdn.jsdelivr.net/npm/chart.js@2.8.0"></script>
<style type="text/css">
.principal{
  	float: left;
  	width: 100%;
  	margin-top: 2%;
  }
  #table_id{
  	font-size: 12px;
  }
</style>
<input type="hidden" name="base" id="base" value="<?php echo base_url()?>">
<div class="container">
		<div class="row">
			<div class="col-md-10 col-sm-10 col-xs-10">
				<h3 class="titulo-secciones">
					<br>
    				<i class="fa fa-list"></i> Citas Online Asesores Capital (Enviados) 
				</h3>
			</div>
		</div>
		<hr/> 
     <div class="row">
      <div class="col-md-10 col-sm-10 col-xs-10"></div>
      <div class="col-md-1 col-sm-1 col-xs-1">
        <a href="crear_liga_asesores_enviados"><i class="fa fa-user"></i> Enviados</a>
      </div>
      <div class="col-md-1 col-sm-1 col-xs-1">
        <a href="crear_liga_asesores"><i class="fa fa-user"></i> Pendientes</a>
      </div>
    </div>
    <hr/> 
    <table  id="table_id" class="display" width="100%" style="font-size: 11px;">
      	<thead>
      		<tr style="background-color: #361666;color: #fff;">
      			<th>Nombre del Asesor</th>
            <th>Fecha</th>
            <th>Hora</th>
      			<th>Nombre del Cliente</th>
      			<th>Estado</th>
            <th>Medio</th>
            <th>Liga Video Conferencia</th>
            <th>Codigo Acceso</th>
      		</tr>
      	</thead>
      	<tbody>
          <?php foreach ($citas as $cita){?>
            <tr>
              <td><?php echo strtoupper($cita->nombre);?></td>
	          <td><?php echo $cita->fecha;?></td>
              <td><?php echo $cita->hora;?></td>
              <td><?php echo strtoupper($cita->cliente);?></td>
              <td>
                <?php echo "ENVIADO";?>
              </td>
              <td><?php echo strtoupper($cita->medio);?></td>
              <td><a href="<?php echo $cita->liga_zoom;?>"><?php echo $cita->liga_zoom;?></a></td>
              <td><?php echo $cita->password_liga;?></td>
            </tr>
          <?php }?>
      	</tbody>
      </table>
</div>
<hr>

</div>


<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/js/bootstrap.min.js" integrity="sha384-OgVRvuATP1z7JjHLkuOU7Xw704+h835Lr+6QL9UvYjZE3Ipu6Tp75j7Bh/kR0JKI" crossorigin="anonymous"></script>
<script type="text/javascript" charset="utf8" src="https://cdn.datatables.net/1.10.21/js/jquery.dataTables.js"></script>
<script type="text/javascript">
	$(document).ready( function () {
     $('#table_id').DataTable( {
        "language": {
            "lengthMenu": "Mostrar _MENU_ Registros por Pagina",
            "zeroRecords": "No se encontraron registros",
            "info": "Mostrar Pagina por Pagina",
            "infoEmpty": "No hay registros disponibles",
            "infoFiltered": "(Filtrado de _MAX_ total registros)",
            "search":"Buscar",
            "paginate": {
      			"previous": "Anterior",
      			"next": "Siguiente"
    		}
        }
    } );
} );
</script>
<script type="text/javascript">
/* Ajax*/
function objetoAjax(){
var oHttp=false;
        var asParsers=["Msxml2.XMLHTTP.5.0", "Msxml2.XMLHTTP.4.0",
        "Msxml2.XMLHTTP.3.0", "Msxml2.XMLHTTP", "Microsoft.XMLHTTP"];
        for (var iCont=0; ((!oHttp) && (iCont<asParsers.length)); iCont++){
            try{
                oHttp=new ActiveXObject(asParsers[iCont]);
            }
            catch(e){
                oHttp=false;
            }
        }
        if ((!oHttp) && (typeof XMLHttpRequest!='undefined')){
        oHttp=new XMLHttpRequest();
    }
return oHttp;
}

function setDatos(id,nombre,fecha,hora,cliente){
  document.getElementById('id').value=id;
  document.getElementById('asesor').innerHTML=nombre;
  document.getElementById('fechaHora').innerHTML=fecha+"  "+hora;
  document.getElementById('cliente').innerHTML=cliente;
}

</script>

 

