	<form method="post" class="form" role="formdimension" id="formdimension" name="formdimension" action="<?= base_url()?>crmproyecto/InsertaDimension/">
    	<div class="row">
			<div class="col-sm-12 col-md-12">
				<div class="radio">
					<label for="tipo">
                    	<input type="radio" name="tipo" id="tipo" value="Moral"><span style="font-size:16px;"><strong>Persona Moral</strong></span>
                    </label>
				</div>
			</div><!-- /col -->
		</div><!-- /row -->

		<div class="row">
        	<div class="col-sm-6 col-md-6">
				<label for="razon">Razón:</label>
                <input type="text"  name="razon" id="razon" class="form-control" placeholder="Razón Social">
             </div><!-- /col -->
           
        	<div class="col-sm-6 col-md-6">
				<label for="rfc">RFC:</label>
                <input type="text"  name="rfc" id="rfc" class="form-control" placeholder="RFC">
       	  	</div><!-- /col -->
		</div><!-- /row -->
        
		<div class="row">
        	<div class="col-sm-12 col-md-12">
				<div class="radio">
					<label for="tipo2">
                    	<input type="radio" name="tipo2" id="tipo2" value="Fisica"><span style="font-size:16px;"><strong>Persona fisica</strong></span>
                    </label>
				</div>
       	  	</div><!-- /col -->
		</div><!-- /row -->

		<div class="row">
			<div class="col-sm-12 col-md-12">
				<label for="nombre">Nombres:</label>
				<input type="text"  name="nombre" id="nombre" class="form-control" placeholder="Nombre">
			</div><!-- /col -->
		</div><!-- /row -->
        
		<div class="row">
			<div class="col-sm-6 col-md-6">
				<label for="apellidop">A. Paterno:</label>
				<input type="text"  name="apellidop" id="apellidop" class="form-control" placeholder="Apellido Paterno">
			</div><!-- /col -->
            
        	<div class="col-sm-6 col-md-6">
				<label for="apellidom">A. Materno:</label>
				<input type="text"  name="apellidom" id="apellidom" class="form-control" placeholder="Apellido Materno">
			</div><!-- /col -->
		</div><!-- /row -->
        
		<div class="row">
			<div class="col-sm-6 col-md-6">	
				<label for="email">Email:</label>
				<input
					type="email" name="email" id="email"
					placeholder="Email xx@yy.com" class="form-control"
					pattern="[a-zA-Z0-9_]+([.][a-zA-Z0-9_]+)*@[a-zA-Z0-9_]+([.][a-zA-Z0-9_]+)*[.][a-zA-Z]{1,5}"
				/>
			</div><!-- /col -->
           
			<div class="col-sm-6 col-md-6">	
				<label for="celular">Tel Cel:</label>
				<input 
					type="text"  name="celular" id="celular" 
					placeholder="10 Digitos" maxlength="10" class="form-control"
					onKeypress="if (event.keyCode < 45 || event.keyCode > 57) event.returnValue = false;"
				>
       	  	</div><!-- /col -->
		</div><!-- /row -->
        
		<div class="row">
			<div class="col-sm-12 col-md-12" align="right">
				<br />
				<input 
					type="button" name="button" id="button" 
					value="Agregar Prospecto" class="btn btn-primary" 
					onclick="SendForm_JjHe()" 
				/>
			</div><!-- /col -->
		</div><!-- /row -->
	</form>