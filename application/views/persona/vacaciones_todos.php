<? $this->load->view('headers/header');
	$this->load->view('headers/menu'); ?>
<script src="https://cdn.ckeditor.com/4.11.1/standard/ckeditor.js"></script>
<link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.10.21/css/jquery.dataTables.css">

<div class="container">
<br>
<h4><i class="fa fa-plane"></i>&nbsp;Listado de Vacaciones aprobadas del Personal en General</h4>
<p>

<div class="well" style="background-color: #fff;float: left;">
<?php if($this->tank_auth->get_usermail()=="DIRECTORGENERAL@AGENTECAPITAL.COM"){?>
<div style="text-align: right;">
	<label>Filtro Gerencia ó Coordinador:</label>
	<select>
		<?php foreach ($coordinadores as $coordinador) {?>
			<option value="<?php echo $coordinador->email;?>"><?php echo $coordinador->name_complete." (".$coordinador->email. ")";?></option>
		<?php } ?>
	</select>
<div>

<?php }?>
<br>
	 <table class="table table-responsive table-hover" id="table_id" style="font-size: 10px;width: 100%">
        <thead style="font-size: 9px">
            <tr>
                <th>
                    Nombre del Colabolador
                </th>
                <th>
                    Puesto
                </th>
                <th>
                    Antiguedad
                </th>
                <th>
                    Fecha de Solicitud
                </th>
                <th>
                    Primer dia de Ausencia
                </th>
                <th>
                    Ultimo dia de Ausencia
                </th>
                 <th>
                    Cantidad de Diás
                </th>
                 <th>
                    Fecha de Retorno
                </th>

                <th>Estado Actual</th>
                <th>
                    <i class="fa fa-cogs"></i>
                </th>
                <th>
                    <i class="fa fa-cogs"></i>
                </th>
            </tr>
        </thead>
        <tbody>
        <?php 
        function status($estado){
            switch ($estado) {
                case 1:
                    return "<span style='font-size:12px;font-weight:bold; '>Pendiente</span>";
                    break;
                case 0:
                    return "<span class='badge badge-primary' style='background-color: #39bc6d;color:#fff;'>Aprobada</span>";
                    break;
                case -1:
                    return "<span class='badge badge-danger' style='background-color: #ee563e;color:#fff;'>Negada</span>";
                    break;
                default:
                    return "<span class='badge badge-default'></span>";
                    break;
            }
        }
        
        foreach($vacaciones as $vacacion){
            $fecha_salida="";
            $fecha_retorno="";
            if($vacacion->fecha_salida!=''){
                $fecha_salida=date('d-m-Y', strtotime($vacacion->fecha_salida));
            }
            if($vacacion->fecha_retorno!=''){
                $fecha_retorno=date('d-m-Y', strtotime($vacacion->fecha_retorno));
            }
        ?>
            <tr>
                <td style="text-align: left;"><?php echo $vacacion->nombre;?></td>
                <?php
                    $cargo=$this->personamodelo->puestoDePersona($vacacion->idPersona);
                ?>
                <td style="text-align: left;"><?php echo $cargo[0]->personaPuesto;?></td>
                <td><?php echo $vacacion->antiguedad;?></td>
                  <td style="text-align: right;"><?php echo date('d-m-Y', strtotime($vacacion->fecha));?></td>
               
                <td style="text-align: right;"><?php echo $fecha_salida;?></td>
                <td style="text-align: right;"><?php echo $fecha_retorno;?></td>
                <td style="text-align: center;"><?php echo $vacacion->cantidad_dias;?></td>

                <td></td>
               
                <td><?php echo status($vacacion->aprobado)?></td>
                <td style="text-align: center;"><button class="btn btn-primary btn-xs" onclick="setAprobar('<?php echo $vacacion->id;?>','vacaciones')"><i class="fa fa-check"></i>&nbsp;Aprobar</button></td>
                <td style="text-align: center;"><button class="btn btn-warning btn-xs" onclick="setNegar('<?php echo $vacacion->id;?>','vacaciones')"><i class="fa fa-times-circle"></i>&nbsp;Negar</button></td>
        <?php }?>
            </tr>
        </tbody>
    </table>
</div>
</p>

<p>
<div style="width: 40%;float:left;background-color: #fff;" class="well">
	<table style="width: 100%" class="table table-striped">
		<thead>
			<tr>
				<th colspan="2" style="text-align: center;color: #fff;background-color: #1e4c82;padding: 2%;">TABLA DE VACACIONES</th>
			</tr>
			<tr>
				<th>Años</th>
				<th>Dias</th>
			</tr>
		</thead>
		<tbody>
			<tr>
				<td>1er</td>
				<td>6 dias</td>
			</tr>
			<tr>
				<td>2do</td>
				<td>8 dias</td>
			</tr>
			<tr>
				<td>3er</td>
				<td>10 dias</td>
			</tr>
			<tr>
				<td>4to</td>
				<td>12 dias</td>
			</tr>
			<tr>
				<td>5 - 9</td>
				<td>14 dias</td>
			</tr>
			<tr>
				<td>10 - 14</td>
				<td>16 dias</td>
			</tr>
			<tr>
				<td>15 - 19</td>
				<td>18 dias</td>
			</tr>
			<tr>
				<td>20 - 24</td>
				<td>20 dias</td>
			</tr>
		</tbody>
	</table>
</div>
</p>

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
	function setAprobar(id,tabla){
		var op=confirm("¿Es Ud. seguro de aprobar dicha solictud de vacaciones?");
		if(op==1){
			document.location.href='<?php echo base_url()?>fastFile/setAprobar?id='+id+"&tabla="+tabla;
		}
	}
	function setNegar(id,tabla){
		var op=confirm("¿Es Ud. seguro de negar dicha solictud de vacaciones?");
		if(op==1){
			document.location.href='<?php echo base_url()?>fastFile/setNegar?id='+id+"&tabla="+tabla;
		}
	}
</script>