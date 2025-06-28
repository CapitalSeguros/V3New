
<section class="container-fluid breadcrumb-formularios">
    <div class="row">
        <div class="col-md-12">
            <h3 class="title-section-module">Puntos de Valoración</h3>
        </div>
    </div>
    <hr/>
</section>
<div class="col-md-12" style="text-align: left;">
    <div class="alert alert-info">
		<i class="fa fa-info-circle"></i>&nbsp; Descripción de los puntos de valoración de los clientes hacia los representantes ó asesores
	</div>
</div>
<div class="col-md-12">
	<div class="panel panel-default segment-sms" style="margin: 0px;">
        <div class="panel-body">
        	<div class="col-md-12 column-flex-center" style="margin-bottom: 5px;">
        		<label class="textLabel">Ingrese nuevo punto de valoración:</label>
			<input type="hidden" name="base" id="base" value="<?php echo base_url();?>">
        		<input type="text" name="punto" id="punto" class="form-control" style="width: 30%;">
        		<button class="btn btn-primary btn-sm" onclick="guardarPuntos()" style="margin-left: 5px;">
        			<i class="fa fa-plus-circle"></i>
        			Agregar Nuevo
        		</button>
        	</div>
        	<div class="col-md-12">
				<table class="table table-hover">
			<thead>
				<tr>
					<th>Puntos de Valoración </th>
					<th><i class="fa fa-cogs"></i></th>
				</tr>
			</thead>
			<tbody>
				<?php foreach ($puntos as $punto) {?>
				<tr>
					<td><?php echo $punto->descripcion?></td>
					<td><a href="#" onclick="eliminarPunto('<?php echo $punto->id?>')">Eliminar</a></td>
				</tr>
				<?php }?>
			</tbody>
		</table>
	</div>
		</div>
	</div>
</div>