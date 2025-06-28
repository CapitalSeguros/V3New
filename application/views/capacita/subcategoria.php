
<div id="div_subcategoria">
	<select class="form-control" name="subcategoria" id="subcategoria">
		<?php 
		foreach ($subcategorias as $subcategoria){?>
		  <option value="<?php echo $subcategoria->id_certificado;?>" ><?php echo $subcategoria->nombreCertificado;?></option>
		<?php }?>
	</select>
</div>