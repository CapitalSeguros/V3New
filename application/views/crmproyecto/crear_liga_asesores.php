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
#generar {
    background-color: rgba(0, 0, 0, 0.7);
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
    				<i class="fa fa-list"></i> Citas Online Asesores Capital (Pendientes) - Generar Liga Video Conferencia
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
            <th colspan="2" style="text-align: center"><i class="fa fa-cogs"></i></th>
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
                <?php echo "PENDIENTE";?>
              </td>
              <td><?php echo strtoupper($cita->medio);?></td>
              <td><a href="<?php echo $cita->liga_zoom;?>"><?php echo $cita->liga_zoom;?></a></td>
              <td><?php echo $cita->password_liga;?></td>
              <td><a href="#" data-toggle="modal" data-target="#generar"><button class="btn btn-primary" onclick="setDatos('<?php echo $cita->id;?>','<?php echo strtoupper($cita->nombre);?>','<?php echo $cita->fecha;?>','<?php echo $cita->hora;?>','<?php echo strtoupper($cita->cliente);?>')"><i class="fa fa-cogs"></i> Generar</button></a></td>
               <td>
                <?php if(($cita->liga_zoom!="") AND ($cita->enviado==0)){?>
                <a href="<?php echo base_url()?>crearLiga/enviarCorreoLiga?id=<?php echo $cita->id;?>"><button class="btn btn-success"><i class="fa fa-send"></i> Enviar</button></a>
              <?php }?>
              </td>
            </tr>
          <?php }?>
      	</tbody>
      </table>
</div>
<hr>

</div>

<div id="generar" class="modal" role="dialog">
  <div class="modal-dialog" style="width: 100%;font-size: 14px;">
  <!-- Modal content-->
    <div class="modal-content">
      <div class="modal-header">
        <h3 class="modal-title" style="color: #fff;"><i class="fa fa-details"></i>&nbsp;Asignar Liga de Video Conferencia</h3>
      </div>
      <div class="modal-body" style="width: 100%;">
        <br>
        <div class="well">
        <form name="frm" method="post" action="guardar_liga_asesores">
        <table style="width: 100%">
          <input type="hidden" name="id" id="id">
          <tr>
            <td><span style="font-weight: bold;font-size: 12px;">Nombre del Asesor:</span></td>
            <td><span><div id="asesor"></div></span></td>
          </tr>
          <tr>
            <td><span style="font-weight: bold;font-size: 12px;">Nombre del Cliente:</span></td>
            <td><span><div id="cliente"></div></span></td>
          </tr>
          <tr>
            <td><span style="font-weight: bold;font-size: 12px;">Fecha y Hora:</span></td>
            <td><span><div id="fechaHora"></div></span></td>
          </tr>
          <tr><td colspan="2"><hr></td></tr>
          <tr>
            <td><label style="font-size: 16px;">Liga Reunion:</label></td>
            <td><input type="text" name="liga" class="form-control"></td>
          </tr>
           <tr>
            <td><label style="font-size: 16px;">Codigo de Acceso:</label></td>
            <td><input type="text" name="password" class="form-control"></td>
          </tr>
        </table>
        </div>
      </div>
       <div class="modal-footer">
        <table>
          <tr>
            <td><button type="button" class="btn btn-warning btn-xs" data-dismiss="modal">Cancelar
            <td>&nbsp;</td>
            <td><button type="submit" class="btn btn-primary btn-xs">Aceptar</button></td>
            </button>
            </td>
          </tr>
        </table>
         </form>
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

function setDatos(id,nombre,fecha,hora,cliente){
  document.getElementById('id').value=id;
  document.getElementById('asesor').innerHTML=nombre;
  document.getElementById('fechaHora').innerHTML=fecha+"  "+hora;
  document.getElementById('cliente').innerHTML=cliente;
}

</script>

 

