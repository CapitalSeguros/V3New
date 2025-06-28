<?php $options = array_reduce(array(0,1,2,3,4,5,6,7,8,9,10), function($acc, $curr){ $acc .= "<option value='".$curr."' >".$curr."</option>"; return $acc; }, ""); ?>

<div style="border-radius: 8px;background-color: #fff;padding: 2%;">
  <table border="0">
  <tr>
  <td><b>Requerimiento en Experiencia: </b>
    <div class="alert alert-info"><?php //echo $experiencia[0]->detalle;?></div>
  </td>
  <td>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</td>
  <td>
    <div class="alert alert-info">
      <b>Seleccione</b> el % que se ajusta a la experiencia requerida:
      <select class="formEnviar" name="experiencia" id="experiencia"><option value="">Seleccione</option><?= $options ?></select>
    </div>
  </td>
  </tr>
  </table>
</div>

<div style="border-radius: 8px;background-color: #fff;padding: 2%;margin-top: 1%;">
    <table style="width: 100%;">
      <tr><td><b>Requerimientos en Habilidades</b></td>
        <td><b>Requerimientos en Competencias</b></td>
      </tr>
      <tr>
        <td>
          <table><select name="habilidades" class="formEnviar" id="habilidades"><option value="">Seleccione</option><?=$options?></select></table>
      </td>
      <td>
      <table><select name="competencias" class="formEnviar" id="competencias"><option value="">Seleccione</option><?=$options?></select></table>
      </td>
    </tr>
  </table>
</div>