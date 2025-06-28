<?php
	//var_dump($ListaAgenda);
?>
<style type="text/css">
	.table th, .table td { 
        border-top: none !important;
        border-left: none !important;
    }
	.table tbody tr td{
		font-size: 12px;
	}
	#details input{
		font-size: 12px;
	}
	.card{
		margin-bottom: 5px;
	}
	#generar{
		z-index: 2000;
	}

</style>
<link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.10.21/css/jquery.dataTables.css">

<div class="container">
<div class="row">
    <div class="col-md-8"><h3><i class="fa fa-cog"></i>&nbsp;Administración de Citas</h3></div>
</div>
</div>
<br>
<div class="row">
    <div class="col-8">
		<div class="card" id="details" style="display: none;font-size: 12px;">
			<table class="table table-responsive" id="tabla-detail">
				<tr>
					<td colspan="5">
						<h4><i class="fa fa-edit"></i> Detalles de la Cita</h4>
					</td>
					<td style="text-align: right;">
						<a href="#" onclick="closeDetails()"><i class="fa fa-times-circle fa-2x"></i></a>
					</td>
				</tr>
				<tr>
					<td><b>Nombre Cliente</b></td>
					<td><input type="text" class="form-control" id="cli"></td>
					<td><b>E-mail</b></td>
					<td><input type="text" class="form-control" id="ema"></td>
					<td><b>Telefono</b></td>
					<td><input type="text" class="form-control" id="tel"></td>
				</tr>
				<tr>
					<td><b>Dia</b></td>
					<td><input type="text" class="form-control" id="dia"></td>
					<td><b>Fecha</b></td>
					<td><input type="text" class="form-control" id="fec"></td>
					<td><b>Hora</b></td>
					<td><input type="text" class="form-control" id="hor"></td>
				</tr>
				<tr>
					<td><b>Enlace Liga</b></td>
					<td><input type="text" class="form-control" id="enl"></td>
					<td><b>Password</b></td>
					<td><input type="text" class="form-control" id="pas"></td>
					<td><b>Medio</b></td>
					<td><input type="text" class="form-control" id="con"></td>
				</tr>
				<tr>
					<td><b>Detalles</b></td>
					<td colspan="5"><input type="text" class="form-control" id="det"></td>
				</tr>

			</table>
		</div>
	</div>
</div>

<div class="well table-responsive" style="background-color: #fff;">

<br>
     <table class="table table-hover data-table-1" id="table_id" style="font-size: 11px;width: 100%">
        <thead>
            <tr>
            	<th>Ver Detalles</th>
                <th>Dia</th>
                <th>Fecha</th>
                <th>Hora</th>
                <th>Nombre del Cliente</th>
                <th>E-mail</th>
                <th>Telefono</th>
                <th>Estado</th>
                <th><i class="fa fa-cogs"></i></th>
                <th><i class="fa fa-cogs"></i></th>
            </tr>
        </thead>
        <tbody>
         <?php foreach ($ListaAgenda as $lista) {?>
        	<tr>
                <td><a href="#" onclick="showDetail('<?php echo $lista->cliente?>','<?php echo $lista->correo?>','<?php echo $lista->telefono?>','<?php echo $lista->dia?>','<?php echo $lista->fecha?>','<?php echo $lista->hora?>','<?php echo $lista->liga_zoom?>','<?php echo $lista->password_liga?>','<?php echo $lista->medio?>','<?php echo $lista->detalle?>')"><?php echo $lista->id;?></a></td>
                <td><?php echo $lista->dia;?></td>
                <td><?php echo $lista->fecha;?></td>
                <td><?php echo $lista->hora;?></td>
                <td><?php echo $lista->cliente;?></td>
                <td><?php echo $lista->correo;?></td>
                <td><?php echo $lista->telefono;?></td>
                <?php if($lista->liga_zoom!=''){?>
                	<td>Confirmado</td>
                <?php }else{?>
                	<td>Pendiente</td>
                <?php }?>
                <td>
                	<?php if($lista->liga_zoom!=''){?>
                		<button class="btn btn-primary btn-sm" disabled><i class="fa fa-cogs"></i> Confirmar</button>
                	<?php }else{?>
                		<a href="#" data-toggle="modal" data-target="#generar">
                			<button class="btn btn-primary btn-sm" onclick="setDatos('<?php echo $lista->id;?>','<?php echo $lista->fecha;?>','<?php echo $lista->hora;?>','<?php echo strtoupper($lista->cliente);?>', '<?php echo $lista->medio;?>', '<?php echo $lista->telefono;?>')"><i class="fa fa-cogs"></i> Confirmar</button>
                		</a>
                	<?php }?>
                </td>
                <td>
                	<a href="#" class="btn btn-warning btn-sm" onclick="cancelarCita('<?php echo $lista->id;?>')"><i class="fa fa-times-circle"></i> Cancelar</a>
                </td>
            </tr>
       <?php }?>
        </tbody>
    </table>
</div>


</div>

<div id="generar" class="modal" role="dialog">
  <div class="modal-dialog" style="width: 100%;font-size: 14px;">
  <!-- Modal content-->
    <div class="modal-content">
      <div class="modal-header">
        <h4 class="modal-title" style="color: #fff;"><i class="fa fa-details"></i>&nbsp;Asignar Liga de Video Conferencia</h4>
      </div>
      <div class="modal-body" style="width: 100%;">
        <br>
        <div class="well">
       <input type="hidden" id="base" value="<?php echo base_url()?>">
        <table style="width: 100%">
          <input type="hidden" name="id" id="id">
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
            <td><input type="text" id="liga" class="form-control"></td>
          </tr>
           <tr id="show-row">
            <td><label style="font-size: 16px;">Codigo de Acceso:</label></td>
            <td><input type="text" id="password" class="form-control"></td>
          </tr>
        </table>
        </div>
      </div>
       <div class="modal-footer">
        <table>
          <tr>
          	<td><button type="button" class="btn btn-primary btn-xs" onclick="guardarLiga()" data-dismiss="modal">Aceptar</button></td>
            <td>&nbsp;</td>
          	<td><button type="button" class="btn btn-warning btn-xs" data-dismiss="modal">Cancelar</button></td>
          </tr>
        </table>
       </div>
    </div>
  </div>
</div>


<!------------------------------->
<input type="hidden" id="base_url" data-base-url="<?=base_url()?>">
<script type="text/javascript">

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

	function guardarLiga(){
		var id=document.getElementById('id').value;
		var liga=document.getElementById('liga').value;
		var password=document.getElementById('password').value;
		if((liga!='')&&(password!='')){
		    var base=document.getElementById('base').value;
		    divResultado = document.getElementById('pantalla');  
		    ajax=objetoAjax();
		    var url="crearLiga/guardar_liga_asesores_capital?id="+id+"&liga="+liga+"&password="+password;          
		    var URL=base+url;
		    ajax.open("GET", URL);
		    ajax.onreadystatechange=function() {
		        if (ajax.readyState==4) {
		        		alert("Se ha enviado un correo electronico a su contacto con los datos y confirmacion de su cita");
		            divResultado.innerHTML = ajax.responseText
		        }
		    }
		    ajax.send(null)
		 }else{
		 	alert("Los datos de la liga y el password de la sesion de videollamada son obligatorios");
		 }
	}

	function cancelarCita(id){
		var op=confirm("Esta Ud. seguro de cancelar esta cita?");
		if(op==1){
			var base=document.getElementById('base').value;
			divResultado = document.getElementById('pantalla');  
			ajax=objetoAjax();
			var url="crearLiga/enviarCorreoLigaCapitalCancelacion?id="+id;          
			var URL=base+url;
			ajax.open("GET", URL);
			ajax.onreadystatechange=function() {
			    if (ajax.readyState==4) {
			    		alert("Se ha enviado un correo electronico a su contacto con los datos  y cancelacion de la cita");
			        divResultado.innerHTML = ajax.responseText
			    }
			}
			ajax.send(null)
		}		
	}

	function showDetail(cli,ema,tel,dia,fec,hor,enl,pas,con,det){
		document.getElementById('cli').value=cli;
		document.getElementById('ema').value=ema;
		document.getElementById('tel').value=tel;
		document.getElementById('dia').value=dia;
		document.getElementById('fec').value=fec;
		document.getElementById('hor').value=hor;
		document.getElementById('enl').value=enl;
		document.getElementById('pas').value=pas;
		document.getElementById('con').value=con;
		document.getElementById('det').value=det;
		document.getElementById('details').style.display="block";

	}
	function closeDetails(){
		document.getElementById('details').style.display="none";
	}
</script>

<script type="text/javascript" charset="utf8" src="https://cdn.datatables.net/1.10.21/js/jquery.dataTables.js"></script>
<!-- <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.2/js/bootstrap.min.js"></script> -->
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

 function setDatos(id,fecha,hora,cliente, medio, telefono){
  document.getElementById('id').value=id;
  document.getElementById('fechaHora').innerHTML=fecha+"  "+hora;
  document.getElementById('cliente').innerHTML=cliente;

  if(["whatsapp", "telefono", "phone"].includes(medio.toLowerCase())){

		document.getElementById('liga').value = telefono;
		document.getElementById('password').value = "Contacto via " + medio.toLowerCase();
		document.getElementById('show-row').style.display = "none";
	}
}
 </script>