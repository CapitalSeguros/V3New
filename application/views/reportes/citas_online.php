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
#detalles{
  position: fixed;
   top: 0;
   left: 0;
   width: 100%;
   height: 100%;
   z-index: 1050;
}
</style>
<input type="hidden" name="base" id="base" value="<?php echo base_url()?>">
<div class="container">
		<div class="row">
			<div class="col-md-10 col-sm-10 col-xs-10">
				<h3 class="titulo-secciones">
					<br>
    				<i class="fa fa-list"></i> Reporte Administrativo - Citas Online Asesores Capital
				</h3>
			</div>
		</div>
		<hr/> 
    <table  id="table_id" class="display" width="100%">
      	<thead>
      		<tr style="background-color: #361666;color: #fff;">
      			<th width="10%"><i class="fa fa-cog"></i>Ver Resumen</th>
      			<th>Id</th>
      			<th><i class="fa fa-image"></i></th>
      			<th>Nombre del Agente</th>
      			<th>Email Usuario</th>
      			<th>Estado</th>
      		</tr>
      	</thead>
      	<tbody>
      		<?php foreach ($AgentesActivos as $row) {
					$path_foto = "https://www.capsys.com.mx/V3/assets/img/miInfo/userPhotos/";
      		?>
      		<tr>
      			<td style="text-align: center;"><a href="#" data-toggle="modal" data-target="#detalles" onclick="detallesCitas('<?php echo $row->id_user;?>')"><i class="fa fa-list"></i></a></td>
      			<td><?php echo $row->id_user;?></td>
      			<td><img src="<?php echo $path_foto.$row->fotoUser;?>" style="width: 40px;" class="img-circle"></td>
      			<td><?php echo $row->nombre.' '.$row->apellidoP;?></td>
      			<td><?php echo $row->emailUser;?></td>
      			<td><div class="badge badge-default" style="font-size: 12px;">Activo</div></td>

      		</tr>
      	<?php }?>
      	</tbody>
      </table>
</div>
<hr>

<div style="margin: 5%;">
  <div class="row">
    <div class="col-xs-4 col-md-4 col-lg-4">
      <table class="table table-condensed table-hover" style="font-size: 12px;">
        <thead>
          <tr style="color: #fff;background-color: #8370a1;">
            <td>MESES</td>
            <td>TOTAL CITAS ONLINE</td>
          </tr>
        </thead>
        <tbody>
          <tr>
            <td>ENERO</td>
            <td style="text-align:center;font-weight:bold;"><?php echo $enero;?></td>
          </tr>
          <tr>
            <td>FEBRERO</td>
            <td style="text-align:center;font-weight:bold;"><?php echo $febrero;?></td>
          </tr>
          <tr>
            <td>MARZO</td>
            <td style="text-align:center;font-weight:bold;"><?php echo $marzo;?></td>
          </tr>
          <tr>
            <td>ABRIL</td>
            <td style="text-align:center;font-weight:bold;"><?php echo $abril;?></td>
          </tr>
          <tr>
            <td>MAYO</td>
            <td style="text-align:center;font-weight:bold;"><?php echo $mayo;?></td>
          </tr>
          <tr>
            <td>JUNIO</td>
            <td style="text-align:center;font-weight:bold;"><?php echo $junio;?></td>
          </tr>
          <tr>
            <td>JULIO</td>
            <td style="text-align:center;font-weight:bold;"><?php echo $julio;?></td>
          </tr>
          <tr>
            <td>AGOSTO</td>
            <td style="text-align:center;font-weight:bold;"><?php echo $agosto;?></td>
          </tr>
          <tr>
            <td>SEPTIEMBRE</td>
            <td style="text-align:center;font-weight:bold;"><?php echo $septiembre;?></td>
          </tr>
           <tr>
            <td>OCTUBRE</td>
            <td style="text-align:center;font-weight:bold;"><?php echo $octubre;?></td>
          </tr>
          <tr>
            <td>NOVIEMBRE</td>
            <td style="text-align:center;font-weight:bold;"><?php echo $noviembre;?></td>
          </tr>
          <tr>
            <td>DICIEMBRE</td>
            <td style="text-align:center;font-weight:bold;"><?php echo $diciembre;?></td>
          </tr>
        </tbody>
      </table>
    </div>

    <div class="col-xs-8 col-md-8 col-lg-8">
      <div id="grafico" style="width: 100%;height:auto;padding: 1%;">
        <canvas id="myChart"></canvas>
      </div>
    </div>

  </div>

</div>




<div id="detalles" class="modal" role="dialog">
  <div class="modal-dialog" style="width: 100%;">
  <!-- Modal content-->
    <div class="modal-content">
      <div class="modal-header">
        <h4 class="modal-title"><i class="fa fa-details"></i>&nbsp;Resumen General de Asesor Online</h4>
        <div style="text-align: right;">
        <button type="button" class="btn btn-warning btn-xs" data-dismiss="modal">Cerrar<i class="fa fa-times"></i></button>
        </div>
      </div>
      <div class="modal-body">
       <div id="visor"></div>
      </div>
      <div class="modal-footer">
      </div>
    </div>
  </div>
</div>


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
function detallesCitas(id){
 	divResultado = document.getElementById('visor'); 
    ajax=objetoAjax();   
    var URL=document.getElementById('base').value+"reportes/detalleCitas?id="+id;
    ajax.open("GET", URL);
    ajax.onreadystatechange=function() {
        if (ajax.readyState==4) {
           divResultado.innerHTML = ajax.responseText
        }
    }
      ajax.send(null) 
}
</script>
<script type="text/javascript">

var ctx = document.getElementById('myChart').getContext('2d');
var myChart = new Chart(ctx, {
    type: 'line',
    data: {
        labels: ['Enero', 'Febrero', 'Marzo', 'Abril', 'Mayo', 'Junio','Julio','Agosto','Septiembre','Octubre','Noviembre','Diciembre'],
        datasets: [{
            label: 'Reporte Mensual de Citas Online Año <?php echo date('Y');?>',
            data: [<?php echo $enero;?>,<?php echo $febrero;?>,<?php echo $marzo;?>,<?php echo $abril;?>,<?php echo $mayo;?>,<?php echo $junio;?>,<?php echo $julio;?>,<?php echo $agosto;?>,<?php echo $septiembre;?>,<?php echo $octubre;?>,<?php echo $noviembre;?>,<?php echo $diciembre;?>],
            backgroundColor: [
                '#EFF2FB',
            ],
            borderColor: [
                'blue',
            ],
            borderWidth: 1
        }]
    },
    options: {
        scales: {
            yAxes: [{
                stacked: true
            }]
        }
    }
});
</script>

