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
<section class="container-fluid">
    <table class="table table-striped issue-tracker" id="tbEvaluacion">
        <tbody>
            <?php foreach ($evaluaciones_pendientes as $key => $value) : ?>
                <tr>
                    <td width="100" style="text-align: center;">
                        <span class="label <?= ($value->fecha_finalizacion == null ? "label-success" : "label-primary") ?>">
                            <?= ($value->fecha_finalizacion == null ? "PENDIENTE" : "COMPLETADO") ?>
                        </span>
                        <?php if (isset($value->padre_id)) : ?>
                            <?php if ($value->padre_id == $this->tank_auth->get_idPersona()) : ?>
                                <div style="font-size: 8px; padding-top: 5px;"><b>Seguimiento surbordinado</b></div>
                            <?php endif; ?>
                        <?php endif; ?>

                    </td>
                    <td class="issue-info">
                        <a>Evaluación: <?= $value->titulo ?></a>
                        <small>Colaborador: <?= $value->empleado ?></small>
                        <small>Puesto: <?= in_array(isset($value->puesto_id) ? $value->puesto_id : 0, $ranks) ? $ranksRel[$value->puesto_id] : $value->puesto ?></small>
                    </td>
                    <td>
                        <small>Inicio de evaluación: <?= date("d/m/Y", strtotime($value->FechaInicio)) ?></small>
                        <br />
                        <small>Fin de evaluación: <?= date("d/m/Y", strtotime($value->FechaFin)) ?></small>
                    </td>
                    <td>
                        <small>Aplicación: <?= (!isset($value->fecha_aplicacion) ? "N/A" : date("d/m/Y, g:i a", strtotime($value->fecha_aplicacion))) ?></small>
                        <br />
                        <small>Finalización: <?= (!isset($value->fecha_finalizacion) ? "N/A" : date("d/m/Y, g:i a", strtotime($value->fecha_finalizacion))) ?></small>
                    </td>
                    <td>Resultado: <br><?= $value->calificacion != null ? $value->calificacion : 0 ?> %</td>
                    <td width="100">
                        <?php if ($this->tank_auth->get_idPersona() == $id && $value->fecha_finalizacion == null &&  date("Y-m-d") >= date("Y-m-d", strtotime($value->FechaInicio)) && date("Y-m-d") <= date("Y-m-d", strtotime($value->FechaFin)) && $value->padre_id != $this->tank_auth->get_idPersona()) : ?>
                            <a data-usuarioE="<?= $value->empleado_id ?>" data-tipoE="<?= $value->tipo_evaluacion_id ?>" data-seguimientoE="NA" id="btn_anterior_eval" class="btn btn-default btn-sm">Ver anteriores</a>
                            <a href="<?= base_url() . "evaluaciones/aplicar/$value->id" ?>" class="btn btn-default btn-sm">Comenzar</a>
                        <?php else : ?>
                            <?php if (($value->calificacion != NULL || $value->calificacion != '') /* && $value->padre_id!=$this->tank_auth->get_idPersona() */) : ?>
                                <?php if (isset($value->padre_id)) : ?>
                                    <?php if ($value->padre_id == $this->tank_auth->get_idPersona()) : ?>
                                        <?php if (isset($value->tipo_evaluacion_id)) : ?>
                                            <?php if ($value->tipo_evaluacion_id == "5") : ?>
                                                <a data-usuarioE="<?= $value->empleado_id ?>" data-tipoE="<?= $value->tipo_evaluacion_id ?>" data-seguimientoE="<?= $value->id ?>" id="btn_anterior_eval" class="btn btn-default btn-sm">Ver anteriores </a>
                                            <?php endif; ?>
                                        <?php endif; ?>
                                    <?php endif; ?>
                                <?php endif; ?>


                                <a href="<?= base_url() . "evaluaciones/aplicar/$value->id" ?>" target="_blank" class="btn btn-default btn-sm">ver resultado </a>
                            <?php endif; ?>
                        <?php endif; ?>
                    </td>
                    <!-- <?php if ($this->tank_auth->get_idPersona() == $id && $value->fecha_finalizacion == null &&  date("Y-m-d") >= date("Y-m-d", strtotime($value->FechaInicio)) && date("Y-m-d") <= date("Y-m-d", strtotime($value->FechaFin))) : ?>
                    <td width="100" >
                        <a href="<?= base_url() . "evaluaciones/aplicar/$value->id" ?>" class="btn btn-default btn-sm">Comenzar</a>
                    </td>
                    <?php else : ?> -->
                    <td></td>
                    <!-- <?php endif; ?> -->

                </tr>
            <?php endforeach ?>
            <?php if (empty($evaluaciones_pendientes)) : ?>
                <tr class="text-center">
                    <td>No hay registros</td>
                </tr>
            <?php endif; ?>
        </tbody>
    </table>
</section>