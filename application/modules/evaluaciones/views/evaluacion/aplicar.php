<style>
    .sv_q_matrix>thead>tr>th {
        text-align: center;
    }
</style>
<?
//Relaciones de los ranks
$ranks = array(
    1000,
    2000,
    3000,
);

$ranksRel = array(
    1000 => "BRONCE",
    2000 => "ORO",
    3000 => "PLATINO VIP"
);
?>
<section class="container-fluid breadcrumb-formularios">
    <div class="row">
        <div class="col-md-6 col-sm-5 col-xs-5">
            <h4 class="titulo-secciones">Persona evaluada: <?= $evaluacion->empleado ?> </h4>
            <?php if (in_array($evaluacion->puesto_id, $ranks)) : ?>
                <h5 class="titulo-secciones">Ranking:  <?= $ranksRel[$evaluacion->puesto_id]?> </h5>
            <?php else : ?>
                <h5 class="titulo-secciones">Puesto: <?= $evaluacion->puesto ?> </h5>
            <?php endif; ?>
           
            <input type="hidden" id="jsPeriodo" value="<?= $evaluacion->periodo_id ?>"><!-- modificar esta parte -->
            <input type="hidden" id="jsPuesto" value="<?= in_array($evaluacion->puesto_id, $ranks)?$evaluacion->puesto_id:$evaluacion->idPersonaPuesto ?>">
            <!-- <input type="hidden" id="jsPuesto" value="<?= $evaluacion->idPersonaPuesto ?>"> -->
            <input type="hidden" id="jsEvaluacionId" value="<?= $evaluacion->evaluacion_id ?>">
        </div>
        <div class="col-md-6 col-sm-7 col-xs-7">
            <ol class="breadcrumb text-right">
                <?= $breadcrumbs ?>
            </ol>
        </div>
    </div>
    <hr />
</section>
<section class="container">
    <div id="surveyElement" data-id-eva="<?= $id ?>"></div>
    <div id="js-container-control" class="hidden">
        <div class="progress">
            <div class="progress-bar progress-bar-info" role="progressbar" aria-valuenow="0" aria-valuemin="0" aria-valuemax="100" style="width: 0%">
                <span class="sr-only">0% Completado</span>
            </div>
        </div>
        <div class="row">
            <div class="col-md-2">
                <a id="surveyStart" href="#" style="display:none" class="btn btn-default btn-sm" onclick="doStartPage();">Comenzar</a>
                <a id="surveyNext" href="#" style="display:none" class="btn btn-default" onclick="doChangePage();">Siguiente</a>
                <a id="surveyComplete" href="#" class="btn btn-default" onclick="survey.completeLastPage();">Finalizar</a>
            </div>
            <div class="col-md-10">
                <p id="surveyProgress" class="text-right"></p>
            </div>
        </div>
    </div>
    <div id="js-container-control-result" class="hidden">
        <table id="js-result" class="display" style="width:100%">
            <thead>
                <tr>
                    <th>Resultados</th>
                </tr>
            </thead>
        </table>
    </div>
    <div id="surveyResult"></div>
    <!--Fin del row -->
    <div id="js-tipo-pregunta" data-tipo-pregunta='<?= json_encode($tipo_pregunta) ?>''></div>
</section>
<div style="height: 50px;">
</div>