<?php
	$this->load->view('headers/header');
?>

<section>
	<div class="container">
		<div class="row">
			<div class="col-md-12">
				<form method="post" action="<?php echo base_url().'validarinformacion/validardatos'; ?>">
					<div class="row">
						<div class="col-md-6">
							<label for="Datos">Datos: </label>
							<input type="text" class="form-control " name="dato">
						</div>
						<div class="col-md-4">
							<label for="">Operacion: </label>
							<select name="opcion" class="form-control required" id="opcion">
								<option value="0">Seleccione una opci&oacute;n</option>
								<!--<option value="1">P&oacute;liza</option>-->
								<!-- <option value="2">Agente</option>  -->
								<!--<option value="3">CLUBCAP</option>-->
								<option value="4">ID de Validaci&oacute;n</option>
								<option value="5">Usar código de acceso</option>
							</select>
						</div>
						<div class="col-md-2"><br><input type="submit" class="form-control " name="operacion" value="Validar"></div>
					</div>
				</form>
			</div>
		</div>
		<div class="row">
			<div class="col-md-12">
            	<center>
            	<h3>Para una busqueda mas efectiva sugerimos no usar espacios, parentesis y diagonales</h3>
                </center>
            </div>
        </div>
		<hr>
<?php $bandera=0; 
/*SE PIDIO QUE NO SE IMPRIMIERA LO DEJO COMO HISTORIAL*/
if($bandera==1){?>
		<div class="row">
			<div class="col-md-12">
				<h3>Solicitar Club CAP</h3>
				<form class="form-horizontal" action="<?php echo base_url().'validarinformacion/solicitarclubcap'; ?>" method="post">
					<div class="form-group">
				    	<label class="col-sm-2 control-label" for="nombre">Nombre:</label>
				    	<div class="col-sm-10">
				    		<input type="text" class="form-control" name="nombre" id="nombre" placeholder="Nombre">	
				    	</div>
			  		</div>
			  		<div class="form-group">
				    	<label class="col-sm-2 control-label" for="apellidop">Apellido Paterno</label>
			    		<div class="col-sm-10">
			    			<input type="text" class="form-control" name="apellidop" id="apellidop" placeholder="Apellido Paterno">
			    		</div>
			  		</div>
			  		<div class="form-group">
				    	<label class="col-sm-2 control-label" for="apellidom">Apellido Materno</label>
			    		<div class="col-sm-10">
			    			<input type="text" class="form-control" name="apellidom" id="apellidom" placeholder="Apellido Materno">
			    		</div>
			  		</div>
			  		<div class="form-group">
				    	<label class="col-sm-2 control-label" for="telefono">Tel&eacute;fono</label>
			    		<div class="col-sm-10">
			    			<input type="phone" class="form-control" name="telefono" id="telefono" placeholder="Tel&eacute;fono">
			    		</div>
			  		</div>
			  		<div class="form-group">
				    	<label class="col-sm-2 control-label" for="correo">Correo electr&oacute;nico</label>
			    		<div class="col-sm-10">
			    			<input type="email" class="form-control" name="correo" id="correo" placeholder="Correo electr&oacute;nico">
			    		</div>
			  		</div>
			  		<div class="form-group">
			    		<div class="col-sm-offset-10 col-sm-2">
			    			<input type="submit" class="form-control input-sm" id="btnSolicitar" value="Solicitar">
			    		</div>
			  		</div>
				</form>
			</div>
		</div>
		<?php } ?>
	</div>



</section>
<div style="display: flex;justify-content: center;">
<img  src="<?php echo base_url().'assets/images/bannerValidador.png' ?>" width="85%">
</div>

<?php $this->load->view('footers/footer'); ?>