<?php foreach ($videos as $video){?>
<section>
	<div style="margin-bottom: 2%; padding: 2%;background-color: #F2F2F2;border-radius: 9px;">
      <form method="post" id="formulario" name="formulario" action="<?=base_url()?>capacita/modificarvideo">
        <input type="hidden" name="id" id="id" value="<?php echo $video->id;?>">
        <table style="width: 100%;" border="0">
          <tr>
           <td class="celda1"><label><i class="fa fa-tag"></i>&nbsp;SELECCIONE CAPACITACIÓN:</label></td>
           <td class="celda2">
              <select class="form-control" name="categoria" id="categoria" onchange="filtrar_categoria()">
                <?php 
                foreach ($categorias as $categoria){
                  if ($video->categoria == $categoria->id_capacitacion) {?>
                  <option value="<?php echo $video->categoria;?>" selected><?php echo $video->tipoCapacitacion;?></option>
                <?} else {?>
                  <option value="<?php echo $categoria->id_capacitacion;?>"><?php echo $categoria->tipoCapacitacion;?></option>
                <?php }}?>
              </select>
            </td>
            <td class="celda1"><label class="label-text"><i class="fa fa-tag"></i>&nbsp;SELECCIONE CERTIFICACIÓN:</label></td>
            <td class="celda2">
              <div id="div_subcategoria">
                <select class="form-control" name="subcategoria" id="subcategoria">
                  <option value="<?php echo $video->subcategoria;?>">
                    <?php echo $this->capacita_modelo->get_subcategoria($video->subcategoria);?> 
                  </option>
                  <?  foreach ($subcategorias as $subcategoria){?>
                    <option value="<?php echo $subcategoria->id_certificado;?>" ><?php echo $subcategoria->nombreCertificado;?></option>
                  <?  } ?>
                </select>
              </div>
            </td>
          </tr>
          <tr>
           <td class="celda1">
             <div id="lbramos">
                <label><i class="fa fa-tag"></i>&nbsp;SELECCIONE RAMOS:</label>
             </div>
            </td>
           <td class="celda2">
            <div id="ramos">
              <select class="form-control" name="ramo" id="ramo">
                <option value="0">NINGUNA</option>
                <?php foreach ($ramos as $ramo){
                  if ($video->ramo == $ramo->IDRamo) {?>
                  <option value="<?php echo $ramo->IDRamo;?>" selected><?php echo $ramo->Nombre;?></option>
                <?} else {?>
                  <option value="<?php echo $ramo->IDRamo;?>" ><?php echo $ramo->Nombre;?></option>  
                <?php }}?>
              </select>
            </div>
            </td>
            <td colspan="2"></td>
          </tr>

          <tr>
            <td class="celda1"><label><i class="fa fa-graduation-cap"></i>&nbsp;NOMBRE DEL CURSO</label></td>
            <td class="celda2"><input type="text" name="nombre" id="nombre" class="form-control" value="<?php echo $video->nombre;?>"></td>
            <td class="celda1"><label class="label-text"><i class="fas fa-book-open"></i>&nbsp;LECCIONES</label></td>
            <td class="celda2"><input type="text" name="lecciones" class="form-control"  value="<?php echo $video->lecciones;?>"></td>
          </tr>

          <tr>
            <td class="celda1"><label><i class="fa fa-pencil-square-o" aria-hidden="true"></i>&nbsp;DESCRIPCIÓN</label></td>
            <td class="celda2"><input type="text" name="descripcion" class="form-control"  value="<?php echo $video->descripcion;?>"></td>
            <td class="celda1"><label class="label-text"><i class="fa fa-clock-o" aria-hidden="true"></i>&nbsp;DURACIÓN</label></td>
            <td class="celda2"><input type="number" name="duracion" class="form-control"  value="<?php echo $video->duracion;?>"></td>
          </tr>

           <tr>
            <td class="celda1"><label><i class="fa fa-file-text" aria-hidden="true"></i>&nbsp;EXAMEN</label></td>
            <td class="celda2"><select class="form-control select-max" name="examen">
              <? if ($video->examen == "NO") { ?>
                <option value="<?php echo $video->examen;?>" selected><?php echo $video->examen;?></option>
                <option>SI</option>
              <? } else { ?>
                <option>NO</option>
                <option value="<?php echo $video->examen;?>" selected><?php echo $video->examen;?></option>
              <? } ?>
            </select></td>
             <td class="celda1"><label class="label-text"><i class="fas fa-user-graduate"></i>&nbsp;ESTUDIANTES</label></td>
            <td class="celda2"><input type="number" name="estudiantes" class="form-control"  value="<?php echo $video->estudiantes;?>"></td>
          </tr>

           <tr>
            <td class="celda1"><label><i class="fas fa-certificate"></i>&nbsp;CERTIFICADO</label></td>
            <td class="celda2"><select class="form-control select-max" name="certificado">
              <? if ($video->certificado == "NO") { ?>
                <option value="<?php echo $video->certificado;?>" selected><?php echo $video->certificado;?></option>
                <option>SI</option>
              <? } else { ?>
                <option>NO</option>
                <option value="<?php echo $video->certificado;?>" selected><?php echo $video->certificado;?></option>
              <? } ?>
            </select></td>
           
          </tr>

          <tr>
            <td colspan="4"><hr></td>
          </tr>
          <tr>
            <td colspan="4" style="text-align: right;">
              <button type="button" class="btn btn-nuevo" name="modificar" id="modificar" onclick="nuevo_curso()">
                <i class="fa fa-graduation-cap"></i> Nuevo Curso</button>
              <button type="submit" class="btn btn-success" name="modificar" id="modificar" style="border-radius: 5px;"><i class="fas fa-save"></i> Guardar Cambios</button>
            </td>
          </tr>
        </table>
      </form>
  
    </div>        
</section>
<?php }?>
