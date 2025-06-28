<style type="text/css">
	body{
		font-size: 12px;
	}
</style>
<br>
<?php 
$this->load->model('crmProyecto_Model');
$path_foto = "https://www.capsys.com.mx/V3/assets/img/miInfo/userPhotos/";
$ct=0;$sw=0;$calificacion=0;
$foto_agente='noPhoto.png';
$id_userInfo='';
foreach ($citas_online as $rowX){
	$id_userInfo=$rowX->id_userInfo;
	$foto_agente=$rowX->fotoUser;
	$nombre_agente=$rowX->nombre.' '.$rowX->apellidoP;
	$email_agente=$rowX->emailUser;
	$ct++;
	$fecha_ultima=$rowX->fecha;
	$sw=1;
} 
$cuantos=$this->crmProyecto_Model->cuantos($id_userInfo);
?>
<div class="row">
	<div class="col-md-2 col-sm-2">
		<img src="<?php echo $path_foto.$foto_agente;?>" style="width: 100%" class="img-circle">
	</div>
	<div class="col-md-10 col-sm-10">
		<h4><i class="fa fa-list"></i>&nbsp;Resumen General de Citas por Agente</h4>
	</div>
</div>
<?php if($sw==1){?>
<div class="well" style="margin: 1%;">
	<div class="row">
		<div class="col-md-12 col-lg-12">
			<label><b>Nombre:&nbsp;</b></label><?php echo $nombre_agente;?>
		</div>
	</div>
	<div class="row">
		<div class="col-md-12 col-lg-12">
			<label><b>Email Usuario:&nbsp;</b></label><?php echo $email_agente;?>
		</div>
	</div>
</div>
<div class="well" style="margin-bottom: -25px;">
<table style="width: 100%;background-color: #FAFAFA;margin-top: -15px;border-style: solid;border-color: #E5E6E6;border-width: 0.5px;" class="table table-condensed table-hover">
	<tbody>
	<tr>
		<td>&nbsp;Total de Citas Online</td>
		<td><b><?php echo $ct;?></b></td>
	</tr>
	<tr>
		<td>&nbsp;Total de Citas Online Atendidas</td>
		<td><b><?php echo $ct;?></b></td>
	</tr>
	<tr>
		<td>&nbsp;Ultima Interacción en Linea:</td>
		<td><b><?php echo date('d-m-Y', strtotime($fecha_ultima));?></b></td>
	</tr>
	<tr>
		<td>&nbsp;Clientes que han Calificado:</td>
		<td><b><?php echo $cuantos;?></b></td>
	</tr>
	<tr>
		<td>&nbsp;Calificación General:</td>
		<td><b><?if($promedio[0]->sumTotal>0){echo(round(($promedio[0]->sumTotal*100)/$promedio[0]->total,2));}else{echo 0;}?>&nbsp;%</b></td>
	</tr>
	</tbody>
</table>
</div>
<div style="width: 100%;height: 200px;overflow-y: scroll;">
<table class="table table-bordered" style="width: 100%;border-style: solid;border-color: silver;border-width: 1px;font-size: 11px;">
<thead>
	<tr style="background-color: #361666;color: #fff;">
		<th>&nbsp;NOMBRE DEL CLIENTE</th>
		<th>&nbsp;FECHA</th>
		<th>&nbsp;DIA</th>
		<th>&nbsp;HORA</th>
	</tr>
</thead>
<tbody>
	<?php foreach ($citas_online as $row) {?>
		<td><?php echo $row->cliente;?></td>
		<td><?php echo $row->fecha;?></td>
		<td><?php echo $row->dia;?></td>
		<td><?php echo $row->hora;?></td>
		
	</tr>
<?php }?>
</tbody>
</table>
</div>
<?php }else{?>
	<div class="alert alert-success"><i class="fa fa-info-circle fa-2x"></i>&nbsp;<b>No se Encontro</b> un Calendario Configurado</div>
<?php } ?>

