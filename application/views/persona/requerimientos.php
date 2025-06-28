<?php $options = array_reduce(array(0,1,2,3,4,5,6,7,8,9,10), function($acc, $curr){ $acc .= "<option value='".$curr."' >".$curr."</option>"; return $acc; }, ""); ?>

<div class="divPersonSub ocultar">

	<!------------- Dennis Castillo [2022-05-06] ------------->
	<div class="row mb-2">
		<div class="col-md-2 mb-2">
			<div><label for="escolar" class="Responsivo lbEtiqueta mb-0">Escolar</label></div>
			<select class="formEnviar" name="escolar" id="escolar"><option value="">Seleccione</option><?= $options ?></select>
		</div>
		<div class="col-md-2 mb-2">
			<div><label for="escolar" class="Responsivo lbEtiqueta mb-0">Experiencia laboral</label></div>
			<select class="formEnviar" name="experienciaLaboral" id="experienciaLaboral"><option value="">Seleccione</option><?= $options ?></select>
		</div>
		<div class="col-md-2 mb-2">
			<div><label for="escolar" class="Responsivo lbEtiqueta mb-0">Psicométricas</label></div>
			<select class="formEnviar" name="psicometria" id="psicometria"><option value="">Seleccione</option><?= $options ?></select>
		</div>
		<div class="col-md-2 mb-2">
			<div><label for="escolar" class="Responsivo lbEtiqueta mb-0">Valor organizacional</label></div>
			<select class="formEnviar" name="valorOrganizacional" id="valorOrganizacional"><option value="">Seleccione</option><?= $options ?></select>
		</div>
		<!--<div class="col-md-2">
			<div><label for="escolar" class="Responsivo lbEtiqueta mb-0">Escolar</label></div>
			<select class="formEnviar" name="escolar" id="escolar"><option value="0">Seleccione</option><?= $options ?></select>
		</div>-->
		<div class="col-md-2 mb-2">
			<div><label for="escolar" class="Responsivo lbEtiqueta mb-0">Habilidad para tomar decisiones</label></div>
			<select class="formEnviar" name="habilidadDecision" id="habilidadDecision"><option value="">Seleccione</option><?= $options ?></select>
		</div>
		<div class="col-md-2 mb-2">
			<div><label for="escolar" class="Responsivo lbEtiqueta mb-0">Habilidad personal</label></div>
			<select class="formEnviar" name="habilidadPersonal" id="habilidadPersonal"><option value="">Seleccione</option><?= $options ?></select>
		</div>
		<div class="col-md-2 mb-2">
			<div><label for="escolar" class="Responsivo lbEtiqueta mb-0">Habilidad administrativa</label></div>
			<select class="formEnviar" name="habilidadAdministrativa" id="habilidadAdministrativa"><option value="">Seleccione</option><?= $options ?></select>
		</div>
		<div class="col-md-2 mb-2">
			<div><label for="escolar" class="Responsivo lbEtiqueta mb-0">Disponibilidad para viajar</label></div>
			<select class="formEnviar" name="viajar" id="viajar">
				<option value="0"></option>
      			<option value="SI">Si</option>
      			<option value="NO">No</option>
			</select>
		</div>
		<div class="col-md-12 mb-4">
			<div><label for="escolar" class="Responsivo lbEtiqueta mb-0">Experiencia en: </label></div>
			<select name="experienciaPuesto" id="experienciaPuesto" required> <!-- onchange="ActivarRequerimientos() -->
		 		<option value=''>Seleccione</option>
      		 	<?php foreach($experiencias as $experiencia){?>
                	<option value=<?=$experiencia->id?>><?php echo strtoupper($experiencia->titulo)?></option>
            	<?php }?>
    		</select>
		</div>
		<div class="col-md-8 center-block" id="divRequerimientos">
			<?= $this->load->view('persona/detalles_requerimientos'); ?>
		</div>
	</div>
	<!-------------------------------------------------------->

	<!--<div class="ResponsivoDiv">
		<label  class="Responsivo lbEtiqueta">Nivel de Ingles:
		<div>
		 <select class="formEnviar"  name="ingles" id="ingles" required>
		 	<option value="0">NO</option>
      		<option value="1">BASICO(Lectura y comprension)</option>
      		<option value="2">INTERMEDIO(Lectura, Escritura y Comprension)</option>
      		<option value="3">AVANZADO(Lectura, Ecritura y Conversacional)</option>
    	</select>
		</div>
		</label>
	</div>-->


	<!--<div class="ResponsivoDiv">
		<label  class="Responsivo lbEtiqueta">Post Grado:
		<div>
		<select class="formEnviar"  name="postgrado" id="postgrado" required>
      		<option value="0"></option>
      		<option value="SI">Si</option>
      		<option value="NO">No</option>
    	</select>
    	</div>
		</label>
	</div>-->
	<!--<div class="ResponsivoDiv">
		<label  class="Responsivo lbEtiqueta">Disponible para Viajar:
		<div>
		<select class="formEnviar"  name="viajar" id="viajar" required>
      		<option value="0"></option>
      		<option value="SI">Si</option>
      		<option value="NO">No</option>
    	</select>
    	</div>
		</label>
	</div>-->
	<!--<div class="ResponsivoDiv">
		<label  class="Responsivo lbEtiqueta">Herramientas de Paqueterias (Office):
		<div>
		<select class="formEnviar"  name="herramientas_office" id="herramientas_office" required>
      		<option value="0"></option>
      		<option value="SI">Si</option>
      		<option value="NO">No</option>
    	</select>
    	</div>
		</label>
	</div>-->

	<!--<div class="ResponsivoDiv">
		<label  class="Responsivo lbEtiqueta">Experiencia:
		<div>
		 <select class="formEnviar"  name="experiencia" id="experiencia" required onchange="ActivarRequerimientos()">
		 	 <option value='0'></option>
      		 <?php foreach($experiencias as $experiencia){?>
                <option value=<?=$experiencia->id?>><?php echo strtoupper($experiencia->titulo)?></option>
              <?php }?>
    	</select>
		</div>
		</label>
	</div>-->

	<!--<div class="ResponsivoDiv" style="width: 70%;margin-top: 2%;margin-bottom: 2%;">
		<div id="divRequerimientos">
		</div>
	</div>-->	
</div>
