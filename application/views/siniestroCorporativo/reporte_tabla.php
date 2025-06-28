<style>
    <?php if ($tipo == 1) : ?>
    table#tabla_r th,
    table#tabla_r td {
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
            <u> <?= mb_strtoupper(str_replace("_", " ", $titulo)) ?></u> <br>
            Desde: <?=$rango['desde']?> - Hasta: <?=$rango['hasta']?>
        </td>
        <td style="width: 30%;text-align: right ">
            Fecha y Hora <br>
            <?= date('d/m/Y H:i:s') ?>
        </td>
    </tr>
</table>
<table <?= $tipo == 1 ? 'style="width: 100%;padding-top: 20px;"' : 'style="width: 100%;padding-top: 20px;"' ?>  id="tabla_r" border=1 cellspacing=0 cellpadding=0 >
    <?php if (count($tabla) > 0) : ?>
        <!--  headers -->
        <? $keys = array_keys((array)$tabla[0]); ?>
        <tr style="background-color: black; color:white; font-size: 12px;">
            <?php foreach ($keys as $k_v) : ?>
                <td <?= $tipo == 1 ? 'style="padding: 10px 10px 10px 10px;text-align:center;"' : 'style="text-align:center;"' ?>><?= mb_strtoupper(str_replace("_", " ", $k_v)) ?></td>
            <?php endforeach; ?>
        </tr>
        <?php foreach ($tabla as $value) : ?>
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