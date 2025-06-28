<style>
    <?php if ($tipo == 1) : ?>
    table#tabla_r th,
    table#tabla_r td {
        border: 1.5px solid black;
        border-collapse: collapse;
    }
    table#tabla_r2 th,
    table#tabla_r2 td {
        border: 1.5px solid black;
        border-collapse: collapse;
    }
    <?php else : ?>
       /*  table#tabla_r td {
        border: 1.5px solid black;
        border-collapse: collapse;
    } */
    <?php endif ?>
</style>
<?php if ($tipo == 1) : ?>
    <div style="float: right; padding-top: 10px;">
        <a href="btn btn-primary" id="print_pdf" data-toggle="tooltip" data-placement="top" title="Descargar PDF"><i class="fa fa-file-pdf-o fa-2x" aria-hidden="true"></i></a>
        <a href="btn btn-primary" id="print_excel" data-toggle="tooltip" data-placement="top" title="Descargar EXCEL"><i class="fa fa-file-excel-o fa-2x" aria-hidden="true"></i></a>
    </div>
<?php endif ?>
<table style="width: 100%;">
    <tr style="width: 100%;">
        <td style="width: 30%;">
            <img src="https://www.capitalseguros.com.mx/wp-content/uploads/2018/02/logo.png" alt="logo" width="200px" height="80px">
        </td>
        <td style="width: 40%;text-align: center">
            <u> <?= mb_strtoupper(str_replace("_", " ", "ESTATUS_T")) ?></u> <br>
        </td>
        <td style="width: 30%;text-align: right ">
            Fecha y Hora <br>
            <?= date('d/m/Y H:i:s') ?>
        </td>
    </tr>
</table>
<table style="border:5px double #82afd9; width: 100%;text-align: center;">
    <tr >
        <td><strong>Unidades vigentes</strong></td>
        <td><strong>Siniestros (Acumulado anual)</strong></td>
        <td><strong>Estatus "t"</strong></td>
        <td><strong>% De Estatus "t" vs Flota Total</strong></td>
        <td><strong>% De Estatus t vs Siniestros acumulado</strong></td>
        <td><strong>Frecuencia</strong></td>
    </tr>
    <tr>
        <td><?=$full["TotalFlota"]?></td>
        <td><?=$full["TotalS"]?></td>
        <td><?=$full["TotalRET"]+$full["TotalCRT"]?></td>
        <td><?=round(($full["TotalRET"]/$full["TotalFlota"])*100,2)+round(($full["TotalCRT"]/$full["TotalFlota"])*100,2)?> %</td>
        <td><?=round(($full["TotalRET"]/$full["TotalS"]==0?1:$full["TotalS"])*100,2)+round(($full["TotalCRT"]/$full["TotalS"]==0?1:$full["TotalS"])*100,2)?> %</td>
        <td><?=round(($full["TotalRE"]/$full["TotalFlota"])*100,2)+round(($full["TotalC"]/$full["TotalFlota"])*100,2)?> %</td>
    </tr>
    <tr>
        <td><strong>Reparación</strong></td>
        <td><?=$full["TotalRE"]?></td>
        <td><?=$full["TotalRET"]?></td>
        <td><?=round(($full["TotalRET"]/$full["TotalFlota"])*100,2)?> %</td>
        <td><?=round(($full["TotalRET"]/$full["TotalS"]==0?1:$full["TotalS"])*100,2)?> %</td>
        <td><?=round(($full["TotalRE"]/$full["TotalFlota"])*100,2)?> %</td>
    </tr>
    <tr>
        <td><strong>Cristal</strong></td>
        <td><?=$full["TotalC"]?></td>
        <td><?=$full["TotalCRT"]?></td>
        <td><?=round(($full["TotalCRT"]/$full["TotalFlota"])*100,2)?> %</td>
        <td><?=round(($full["TotalCRT"]/$full["TotalS"]==0?1:$full["TotalS"])*100,2)?> %</td>
        <td><?=round(($full["TotalC"]/$full["TotalFlota"])*100,2)?> %</td>
    </tr>
</table>
<table style="width: 100%; padding-top: 10px;">
    <tr>
        <td colspan="6">REPARACIÓNES</td>
    </tr>
    <tr style="background-color: #82afd9; color:white; font-size: 12px;text-align: center;">
        <td>Surtido de refacciones con fecha</td>
        <td>Surtido de refacciones sin fecha</td>
        <td>Piezas completas con fecha de entrega</td>
        <td>Piezas completas sin fecha de entrega</td>
        <td>En proceso de valuacion</td>
        <td>Pendientes de Ingresar</td>
    </tr>
    <tr style="text-align: center;">
        <td><?=$full["SurtidoRefConFechaRE"]?></td>
        <td><?=$full["SurtidoRefSinFechaRE"]?></td>
        <td><?=$full["PiezasCompletasConFechaRE"]?></td>
        <td><?=$full["PiezasCompletasSinFechaRE"]?></td>
        <td><?=$full["ProcesoValuacionRE"]?></td>
        <td><?=$full["PendienteIngresoRE"]?></td>
    </tr>
</table>
<table style="width: 100%; padding-top: 10px;">
    <tr>
        <td colspan="6">CRISTALES</td>
    </tr>
    <tr style="background-color: #82afd9; color:white; font-size: 12px;text-align: center;">
        <td>Surtido de refacciones con fecha</td>
        <td>Surtido de refacciones sin fecha</td>
        <td>Piezas completas con fecha de entrega</td>
        <td>Piezas completas sin fecha de entrega</td>
        <td>En proceso de valuacion</td>
        <td>Pendientes de Ingresar</td>
    </tr>
    <tr style="text-align: center;">
        <td><?=$full["SurtidoRefConFechaCR"]?></td>
        <td><?=$full["SurtidoRefSinFechaCR"]?></td>
        <td><?=$full["PiezasCompletasConFechaCR"]?></td>
        <td><?=$full["PiezasCompletasSinFechaCR"]?></td>
        <td><?=$full["ProcesoValuacionCR"]?></td>
        <td><?=$full["PendienteIngresoCR"]?></td>
    </tr>
</table>

<div style="page-break-after:always;"></div>
<h5>REPARACIONES</h5>
<table <?= $tipo == 1 ? 'style="width: 90%;padding-top: 20px;font-size: 6px;"' : 'style="width: 100%;padding-top: 20px;  font-size: 10px;"' ?>  id="tabla_r" border=1 cellspacing=0 cellpadding=0 >
    <?php if (count($tabla1) > 0) : ?>
        <!--  headers -->
        <? $keys = array_keys((array)$tabla1[0]); ?>
        <tr style="background-color: black; color:white;">
            <?php foreach ($keys as $k_v) : ?>
                <td <?= $tipo == 1 ? 'style="padding: 10px 10px 10px 10px;text-align:center;"' : 'style="text-align:center;"' ?>><?= mb_strtoupper(str_replace("_", " ", $k_v)) ?></td>
            <?php endforeach; ?>
        </tr>
        <?php foreach ($tabla1 as $value) : ?>
            <tr>
                <?php foreach ($keys as $k_v) : ?>
                    <td style="text-align: center;"><?= $value[$k_v] ?></td>
                <?php endforeach; ?>
            </tr>
        <?php endforeach; ?>
    <?php else : ?>
        <tr>
            <th>No hay registros disponibles</th>
        </tr>
    <?php endif ?>
</table>

<div style="page-break-after:always;"></div>
<h5>CRISTALES</h5>
<table <?= $tipo == 1 ? 'style="width: 90%;padding-top: 20px;font-size: 7px;"' : 'style="width: 100%;padding-top: 20px;  font-size: 10px;"' ?>  id="tabla_r2" border=1 cellspacing=0 cellpadding=0 >
    <?php if (count($tabla2) > 0) : ?>
        <!--  headers -->
        <? $keys = array_keys((array)$tabla2[0]); ?>
        <tr style="background-color: black; color:white;">
            <?php foreach ($keys as $k_v) : ?>
                <td <?= $tipo == 1 ? 'style="padding: 10px 10px 10px 10px;text-align:center;"' : 'style="text-align:center;"' ?>><?= mb_strtoupper(str_replace("_", " ", $k_v)) ?></td>
            <?php endforeach; ?>
        </tr>
        <?php foreach ($tabla2 as $value) : ?>
            <tr>
                <?php foreach ($keys as $k_v) : ?>
                    <td style="text-align: center;"><?= $value[$k_v] ?></td>
                <?php endforeach; ?>
            </tr>
        <?php endforeach; ?>
    <?php else : ?>
        <tr>
            <th>No hay registros disponibles</th>
        </tr>
    <?php endif ?>
</table>

<script type="text/php">
    if (isset($pdf))
    {
      $font = Font_Metrics::get_font("Arial", "bold");
      $pdf->page_text(765, 550, "Pagina {PAGE_NUM} de {PAGE_COUNT}", $font, 9, array(0, 0, 0));
    }
</script>