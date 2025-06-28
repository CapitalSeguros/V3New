<table id="tb-final-result" class="display dataTable no-footer" style="width: 100%;" role="grid">
    <tbody>
       <!--  <?var_dump($persona[0])?> -->
        <?php if (empty($respuestas)) : ?>
            <tr class="group">
                <td><h3 class="text-center">Evaluación sin responder</h3></td>
            </tr>
        <?php endif; ?>
        <?php if (!empty($respuestas)) : 
            ?>

            <tr class="group">
                <td class="tb-padding" colspan="3"><strong>PERSONA EVALUADA: <?=$persona[0]["nombre"]?></strong> <strong style="margin-left: 70px;"><?=$persona[0]["puesto"]!='' && $persona[0]["puesto"]!=null?'PUESTO: '.$persona[0]["puesto"]:'RANK: '.$persona[0]["rank"] ?></strong><span class="pull-right"></strong></span></td>
            </tr>
        <?php endif; ?>
        <?php foreach ($respuestas as $key => $value) : ?>
            
            <tr class="group">
                <td class="tb-padding" colspan="3"><strong>COMPETENCIA: <?= $key ?></strong><span class="pull-right"><strong>Grado requerido: <?= $value[0]["grado"] ?></strong></span></td>
            </tr>
            <tr role="row" class="odd">
                <td class="tb-padding">
                    <table class="table table-condensed tb-table">
                        <?php foreach ($value as $k => $v) : ?>
                            <tbody>
                                <tr class="tb-ev-header">
                                    <th class="tb-head" colspan="6"><?= $v["pregunta"] ?></th>
                                </tr>
                                <?php if ($v["tipo"]==7) : ?>
                                <tr>
                                    <?php foreach (json_decode($v["json_content"]) as $jk => $jv) : ?>
                                        <td><?= $jv ?></td>
                                    <?php endforeach ?>
                                    <td class="text-center"><?= $v["respuesta"] ?></td>
                                    <td class="text-center"><?= $v["porcentaje"] ?>%</td>
                                </tr>
                                <tr class="tb-ev-footer">
                                    <td class="text-center <?= $v["respuesta"] == "A" ? "info" : "" ?>">A</td>
                                    <td class="text-center <?= $v["respuesta"] == "B" ? "info" : "" ?>">B</td>
                                    <td class="text-center <?= $v["respuesta"] == "C" ? "info" : "" ?>">C</td>
                                    <td class="text-center <?= $v["respuesta"] == "D" ? "info" : "" ?>">D</td>
                                </tr>
                                <?php elseif ($v["tipo"]==3||$v["tipo"]==4||$v["tipo"]==8) : ?>
                                   <tr>
                                   <?php $opciones=json_decode($v["json_content"])?>
                                   <!--  <?php var_dump($opciones)?> -->
                                    <?php foreach ($opciones->choices as $jk => $jv) : ?>
                                        <td class="text-center <?= $v["respuesta"] == $jv ? "info" : "" ?>"><?= $jv ?></td>
                                    <?php endforeach ?>
                                    <td class="text-center">Respuesta: <?= $v["respuesta"] ?></td>
                                    <td class="text-center" ><?= $v["porcentaje"] ?></td>
                                   </tr>
                                   <?php else : ?>
                                   <tr>
                                    <td class="text-center info">Respuesta: <?= $v["respuesta"] ?></td>
                                    <td class="text-center" ><?= $v["porcentaje"] ?></td>
                                   </tr>
                                <?php endif; ?>
                            </tbody>
                        <?php endforeach; ?>
                    </table>
                </td>
            </tr>
        <?php endforeach; ?>
    </tbody>
</table>