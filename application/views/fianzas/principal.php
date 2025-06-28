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
		<div class="col-md-6 col-sm-5 col-xs-5">
			<h3 class="titulo-secciones">Fianzas</h3>
		</div>
		<div class="col-md-6 col-sm-7 col-xs-7">
			<!--
            <ol class="breadcrumb text-right">
				<li><a href="./">Inicio</a></li>
				<li class="active">Tienda</li>
			</ol>
            -->
		</div>
	</div>
	<hr /> 
<!-- Menu de Administracion Tienda -->


<!--
	<div class="row">
			<div class="col-md-4 col-sm-4 col-xs-4">
            	Categorias
            </div>
			<div class="col-md-4 col-sm-4 col-xs-4">
            	Articulos
            </div>
			<div class="col-md-4 col-sm-4 col-xs-4">
            	<a href="<?=base_url()?>tienda/pedidosSurtir">Surtir Pedidos</a>
            </div>
	</div>
	<hr />
-->
        
</section>

<!-- Fianzas Actividad -->
		<section class="container-fluid">
			<div class="panel panel-default">
				<div class="panel-body">
			
        			<div class="row">
						<div class="form-group col-sm-12 col-md-12">
                        	<label><h3>Fiado</h3></label>
                        </div>
					</div>
                    
        			<div class="row">
						<div class="form-group col-sm-6 col-md-6">
                        	<label for="fiado">Nombre</label>
                            <select name="fiado" id="fiado" class="form-control">
                            </select>
                        </div>
						<div class="form-group col-sm-6 col-md-6">
                        	<label for="fiado">Direccion</label>
                            <select name="fiado" id="fiado" class="form-control">
                            </select>
                        </div>
					</div>
					<hr />
                    
        			<div class="row">
						<div class="form-group col-sm-12 col-md-12">
                        	<label><h3>Compañia</h3></label>
                        </div>
					</div>

        			<div class="row">
						<div class="form-group col-sm-6 col-md-6">
                        	<label for="fiado">Nombre</label>
                            <select name="fiado" id="fiado" class="form-control">
                            </select>
                        </div>
						<div class="form-group col-sm-2 col-md-2">
                        	<label for="fiado">Moneda</label>
                            <select name="fiado" id="fiado" class="form-control">
                            </select>
                        </div>
                        
						<div class="form-group col-sm-2 col-md-2">
                        	<label for="fiado">T. de Cambio</label>
                            <select name="fiado" id="fiado" class="form-control">
                            </select>
                        </div>
                        
						<div class="form-group col-sm-2 col-md-2">
                        	<label for="fiado">Forma de Pago</label>
                            <select name="fiado" id="fiado" class="form-control">
                            </select>
                        </div>
                        
					</div>
                    <hr />
                    
        			<div class="row">
						<div class="form-group col-sm-12 col-md-12">
                        	<label><h3>Vigencia</h3></label>
                        </div>
					</div>
                    
        			<div class="row">
						<div class="form-group col-sm-2 col-md-2">
                        	<label for="fiado">Desde</label>
												<div id="fecha-reembolso" class="input-group date">
													<input 
														type="text" maxlength="10" class="form-control" 
														placeholder="Fecha del Reembolso" title="Fecha del Reembolso"
														name="fecha_reembolso" id="fecha_reembolso"
														value="<?= date("d/m/Y");?>" required
													/>
													<span class="input-group-addon"><i class="fa fa-calendar"></i></span> 
												</div>
                        </div>
						<div class="form-group col-sm-2 col-md-2">
                        	<label for="fiado">Hasta</label>
												<div id="fecha-reembolso" class="input-group date">
													<input 
														type="text" maxlength="10" class="form-control" 
														placeholder="Fecha del Reembolso" title="Fecha del Reembolso"
														name="fecha_reembolso" id="fecha_reembolso"
														value="<?= date("d/m/Y");?>" required
													/>
													<span class="input-group-addon"><i class="fa fa-calendar"></i></span> 
												</div>
                        </div>
                        
						<div class="form-group col-sm-2 col-md-2">
                        	<label for="fiado">Fecha de Antiguedad</label>
												<div id="fecha-reembolso" class="input-group date">
													<input 
														type="text" maxlength="10" class="form-control" 
														placeholder="Fecha del Reembolso" title="Fecha del Reembolso"
														name="fecha_reembolso" id="fecha_reembolso"
														value="<?= date("d/m/Y");?>" required
													/>
													<span class="input-group-addon"><i class="fa fa-calendar"></i></span> 
												</div>
                        </div>
                        
						<div class="form-group col-sm-1 col-md-1">
                        	<label for="fiado">Renovación</label>
                            <input type="text" maxlength="5" class="form-control" style="text-align:right" value="0" />
                        </div>
                        
					</div>
                    <hr  />
                    
        			<div class="row">
						<div class="form-group col-sm-12 col-md-12">
                        	<label><h3>Control</h3></label>
                        </div>
					</div>
                    
        			<div class="row">
						<div class="form-group col-sm-3 col-md-3">
                        	<label for="fiado">Vendedor</label>
							<select class="form-control">
                            </select>
                        </div>
						<div class="form-group col-sm-3 col-md-3">
                        	<label for="fiado">Ejecutivo</label>
							<select class="form-control">
                            </select>
                        </div>
                        
						<div class="form-group col-sm-3 col-md-3">
                        	<label for="fiado">Grupo</label>
							<select class="form-control">
                            </select>
                        </div>
                        
						<div class="form-group col-sm-3 col-md-3">
                        	<label for="fiado">Sub Grupo</label>
							<select class="form-control">
                            </select>
                        </div>
                        
					</div>
                    <hr />
                    
        			<div class="row">
						<div class="form-group col-sm-12 col-md-12">
                        	<label><h3>Detalle de Primas</h3></label>
                        </div>
					</div>
                    
        			<div class="row">
						<div class="form-group col-sm-3 col-md-3">
                        	<label for="fiado">Prima Neta</label>
							<input type="text" class="form-control" />
                        </div>
						<div class="form-group col-sm-3 col-md-3">
                        	<label for="fiado">Descuento</label>
							<input type="text" class="form-control" /><input type="text" class="form-control" style="text-align:right" value="%" />
                        </div>
                        
						<div class="form-group col-sm-3 col-md-3">
                        	<label for="fiado">Derechos</label>
							<input type="text" class="form-control" /><input type="text" class="form-control" style="text-align:right" value="%" />
                        </div>
                        
						<div class="form-group col-sm-3 col-md-3">
                        	<label for="fiado">Gastos Maq</label>
							<input type="text" class="form-control" />
                        </div>
                        
					</div>
                    
        			<div class="row">
						<div class="form-group col-sm-3 col-md-3">
                        	<label for="fiado">Gastos Admin.</label>
							<input type="text" class="form-control" />
                        </div>
						<div class="form-group col-sm-3 col-md-3">
                        	<label for="fiado">Sub Total</label>
							<input type="text" class="form-control" />
                        </div>
                        
						<div class="form-group col-sm-3 col-md-3">
                        	<label for="fiado">IVA</label>
							<input type="text" class="form-control" /><input type="text" class="form-control" style="text-align:right" value="%" />
                        </div>
                        
						<div class="form-group col-sm-3 col-md-3">
                        	<label for="fiado">Prima Total</label>
							<input type="text" class="form-control" />
                        </div>
                        
					</div>
                    <hr />
                    
        			<div class="row">
						<div class="form-group col-sm-12 col-md-12">
                        	<label><h3>Detalle de Comisiones</h3></label>
                        </div>
					</div>
                    
        			<div class="row">
						<div class="form-group col-sm-2 col-md-2">
                        	<label for="fiado">Neta</label>
							<input type="text" class="form-control" /><input type="text" class="form-control" style="text-align:right"/>
                        </div>
						<div class="form-group col-sm-2 col-md-2">
                        	<label for="fiado">Derechos</label>
							<input type="text" class="form-control" /><input type="text" class="form-control" style="text-align:right"/>
                        </div>
                        
						<div class="form-group col-sm-2 col-md-2">
                        	<label for="fiado">Gastos Maq.</label>
							<input type="text" class="form-control" /><input type="text" class="form-control" style="text-align:right"/>
                        </div>
                        
						<div class="form-group col-sm-2 col-md-2">
                        	<label for="fiado">Cancelacion</label>
							<input type="text" class="form-control" /><input type="text" class="form-control" style="text-align:right"/>
                        </div>
                        
						<div class="form-group col-sm-2 col-md-2">
                        	<label for="fiado">Especial</label>
							<input type="text" class="form-control" /><input type="text" class="form-control" style="text-align:right"/>
                        </div>

					</div>
                    <hr />
                    
        			<div class="row">
						<div class="form-group col-sm-12 col-md-12">
                        	<label><h3>Registro de Fechas</h3></label>
                        </div>
					</div>
                    
        			<div class="row">
						<div class="form-group col-sm-2 col-md-2">
                        	<label for="fiado">Solicitud</label>
							<input type="text" class="form-control" />
                        </div>
						<div class="form-group col-sm-2 col-md-2">
                        	<label for="fiado">Captura</label>
							<input type="text" class="form-control" />
                        </div>
                        
						<div class="form-group col-sm-2 col-md-2">
                        	<label for="fiado">Recepcion</label>
							<input type="text" class="form-control" />
                        </div>
                        
						<div class="form-group col-sm-2 col-md-2">
                        	<label for="fiado">Emision</label>
							<input type="text" class="form-control" />
                        </div>
                        
						<div class="form-group col-sm-2 col-md-2">
                        	<label for="fiado">Entrega</label>
							<input type="text" class="form-control" />
                        </div>
                        
						<div class="form-group col-sm-2 col-md-2">
                        	<label for="fiado">No de Folio</label>
							<input type="text" class="form-control" />
                        </div>

					</div>
                    <hr />
                    
        			<div class="row">
						<div class="form-group col-sm-8 col-md-8" align="right">
                        	<button class="btn btn-primary">Guardar</button>
                        </div>
						<div class="form-group col-sm-4 col-md-4" align="right">
                        </div>
					</div>
                    
				</div>
			</div>
		</section>
<!-- Fianzas Actividad -->

<script>
$(document).ready(main);
 
var contador = 1;
 
function main () {
	$('.menu_bar').click(function(){
		if (contador == 1) {
			$('nav').animate({
				left: '0'
			});
			contador = 0;
		} else {
			contador = 1;
			$('nav').animate({
				left: '-100%'
			});
		}
	});
 
	// Mostramos y ocultamos submenus
	$('.submenu').click(function(){
		$(this).children('.children').slideToggle();
	});
}
</script>
<?php $this->load->view('footers/footer'); ?>