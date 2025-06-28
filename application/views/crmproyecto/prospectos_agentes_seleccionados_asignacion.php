
<?php 
$rs=json_decode($prospectos, true);
$this->load->model('crmproyecto_model');
$user=$this->tank_auth->get_usermail();
?>

<div class="well" style="margin-top: 10px;margin-right: 5px;margin-left: 5px; background: #fff;">
 
 <table style="width: 100%" border="0">
 	<tr>
 		<td><a href="<?php echo base_url()?>crmproyecto/prospectos_agentes"><button type="button" class="btn btn-primary btn-sm"><i class="fa fa-arrow-left"></i>&nbsp;Regresar</button></a></td>
 		<td align="right"><h5>Agente(s) Selecciónado(s) para Asignación</h5>&nbsp;</td>
 	</tr>
 </table>
<div class="well">
	<table style="width: 50%;" border="0">
			<td style="text-align: right;">Asignado a:&nbsp;</td>
			<td>
				<select name="asignado" id="asignado" class="form-control" style="font-size: 12px;height: 30px;">
					<option value="NINGUNO">NINGUNO</option>
                    <option value="COORDINADOR@CAPCAPITAL.COM.MX">COORDINADOR@CAPCAPITAL.COM.MX</option>
                    <option value="COORDINADORCOMERCIAL@CAPCAPITAL.COM.MX">COORDINADORCOMERCIAL@CAPCAPITAL.COM.MX</option>
                    <option value="EJECUTIVOCOMERCIAL@ASESORESCAPITAL.COM">EJECUTIVOCOMERCIAL@ASESORESCAPITAL.COM</option>
                     <option value="AUXILIARCOMERCIAL@CAPCAPITAL.COM.MX">AUXILIARCOMERCIAL@CAPCAPITAL.COM.MX</option>
				</select>
			</td>
			<td></td>
		</tr>
		<tr>
			<td colspan="2">&nbsp;</td>
		</tr>
		<tr>
			<td></td>
			<td>
				<?php if(($user=="MARKETING@AGENTECAPITAL.COM")||($user=="DIRECTORGENERAL@AGENTECAPITAL.COM")){?>
				<button class="btn btn-primary btn-md" onclick="modificar_agentes_seleccionados_asignacion()"><i class="fa fa-cogs"></i>&nbsp;Guardar Modificaciónes</button>
				<?php }?>
			</td>
		</tr>
	</table>
</div>

<table class="table table-condensed table-hover" style="font-size: 11px;">
<thead>
<tr>
	<th></th>
	<th>Nombre del Prospecto</th>
	<th>Status</th>
	<th>Medio</th>
	<th>Coordinación</th>
</tr>
</thead>
<tbody>
<?php 
$i=0;
foreach ($rs as $row) {
	$prospecto=$this->crmproyecto_model->get_prospecto_agente($row);
?>
	<tr>
		<td><i class="fa fa-check"></i></td>
		<td><?php echo $prospecto[$i]->prospecto;?></td>
		<td><?php echo $prospecto[$i]->status;?></td>
		<td><?php echo $prospecto[$i]->medio;?></td>
		<td><?php echo $prospecto[$i]->coordinacion;?></td>
	</tr>
<?php	
}
?>
</tbody>
</table>
</div>
