<?php
$total = array_sum(array_map(function ($it) {
    return $it["total"];
}, $evaluacion_incidencias));

$total = 100 - $total;
?>

<section class="container">

    <button class="bn-open-filter" data-chart-name="INCIDENCIAS_MENSUALES" data-filter="fecha,puesto,colaborador" data-filter-default="periodo:3" data-uri-filter="<?= base_url() . "evaluaciones/updateChart" ?>">Filtros</button>
    
</section>


<div class="js-modal-filter"></div>