<section class="container-fluid breadcrumb-formularios">
    <div class="row">
        <div class="col-md-6 col-sm-5 col-xs-5">
            <h3 class="titulo-secciones">Perfil</h3>
        </div>
        <div class="col-md-6 col-sm-7 col-xs-7">
            <?= $breadcrumbs; ?>
        </div>
    </div>
    <hr />
</section>
<section class="container-fluid">
    <div class="row">
        <div class="col-md-3">
            <div class="panel panel-default">
                <div class="panel-heading">
                    <i class="fa fa-bank fa-lg"></i> Banco
                </div>
                <div class="panel-body">
                    <p><b>Nombre:</b> Banamex</p>
                    <p><b>Clabe:</b> 00000000000000000000</p>
                    <p><b>Cuenta:</b> Cuenta</p>
                    <p><b>Tipo cuenta:</b> Tipo cuenta</p>
                </div>
            </div>
            <div class="panel panel-default">
                <div class="panel-heading">
                    <i class="fa fa-heartbeat fa-lg"></i> En caso de accidente
                </div>
                <div class="panel-body">
                    <p><b>Avisar a:</b> Familiar</p>
                    <p><b>Recomendado por:</b> Familiar</p>
                    <p><b>Teléfono accidente:</b> 0199999999</p>
                    <p><b>IMSS:</b> Número de seguro</p>
                    <p><b>Referencias:</b> Referencias</p>
                    <p><b>Tiene hijos:</b> 2</p>
                </div>
            </div>
            <div class="panel panel-default">
                <div class="panel-heading">
                    <i class="fa fa-angellist fa-lg"></i> Otros
                </div>
                <div class="panel-body">
                    <p><b>Gasto mensual:</b> $0.00</p>
                    <p><b>C.T.G. Ganar</b> $0.00</p>
                    <p><b>Comida favorita:</b> Comida favorita</p>
                    <p><b>Color favorito:</b> Color</p>
                    <p><b>Pasatiempo favorito:</b> Pasatiempo</p>
                    <p><b>Club social:</b> Club</p>
                </div>
            </div>
        </div>
        <div class="col-md-9">

            <!-- Nav tabs -->
            <ul class="nav nav-tabs" role="tablist">
                <li role="presentation" class="active"><a href="#profile" aria-controls="profile" role="tab" data-toggle="tab">Perfil</a></li>
                <li role="presentation"><a href="#incidencias" aria-controls="incidencias" role="tab" data-toggle="tab">Incidencias</a></li>
                <li role="presentation"><a href="#evaluaciones" aria-controls="evaluaciones" role="tab" data-toggle="tab">Evaluaciones</a></li>
                <li role="presentation"><a href="#otros" aria-controls="otros" role="tab" data-toggle="tab">Otros</a></li>
                <li role="presentation" class="pull-right dropdown">
                    <a class="dropdown-toggle" data-toggle="dropdown" href="#" role="button" aria-haspopup="true" aria-expanded="false">
                        Periodo <?= $periodoName ?><span class="caret"></span>
                    </a>
                    <ul class="dropdown-menu">
                        <?php foreach ($periodos as $key => $value) : ?>
                            <li><a href="<?= base_url() . "personas/perfil/$id?periodo=$value[id]" ?>"><?= $value["titulo"] ?></a></li>
                        <?php endforeach; ?>
                    </ul>
                </li>
            </ul>

            <!-- Tab panes -->
            <div class="tab-content">
                <div role="tabpanel" class="tab-pane active" id="profile">

                </div>
                <div role="tabpanel" class="tab-pane" id="incidencias">
                    <div class="row">
                        <div class="col-md-12">
                            <?php if ($puedo_solicitar) : ?>
                                <div id="vOptions" data-min-date="<?= $minDayVacation ?>" data-start-block="<?= $startBlock ?>" data-days-block="<?= $daysBlock ?>"></div>
                                <button class="openModal btn-primary btn-sm btn pull-right" data-in-id="0" data-in-eid="<?= $id; ?>" data-in-name="<?= $name_complete; ?>" data-in-mode="vacaciones" data-in-ty="1" data-in-days="<?= $dias_vacaciones ?>">Solicitar</button>
                            <?php endif; ?>
                            <p class="h4"><i class="fa fa-file-text"></i> Vacaciones</p>
                            <hr />
                        </div>
                        <div class="col-md-12">
                            <?= $this->load->view("mis_vacaciones") ?>
                        </div>
                        <div class="col-md-12">
                            <p class="h4"><i class="fa fa-file-text"></i> Mis incidencias</p>
                            <hr />
                        </div>
                        <div class="col-md-12">
                            <?= $this->load->view("mis_incidencias") ?>
                        </div>
                    </div>
                </div>
                <div role="tabpanel" class="tab-pane" id="evaluaciones">
                    <div class="row">
                        <div class="col-md-12">
                            <p class="h4"><i class="fa fa-file-text"></i> Mi evaluación</p>
                            <hr />
                        </div>
                        <div class="col-md-12">
                            <?= $this->load->view("mi_evaluacion") ?>
                        </div>
                        <div class="col-md-12">
                            <p class="h4"><i class="fa fa-file-text"></i> Pendientes por responder</p>
                            <hr />
                        </div>
                        <div class="col-md-12">
                            <?= $this->load->view("evaluaciones_pendientes") ?>
                        </div>
                    </div>
                </div>
                <div role="tabpanel" class="tab-pane" id="otros">
                    <div class="row">
                        <div class="col-md-12">
                            <?php if ($puedo_solicitar) : ?>
                                <button class="bn-sol-bono btn-primary btn-sm btn pull-right" data-in-id="0" data-in-eid="<?= $id; ?>" data-in-name="<?= $name_complete; ?>">Solicitar</button>
                            <?php endif; ?>
                            <p class="h4"><i class="fa fa-file-text"></i> Solicitud de sueldos</p>
                            <hr />
                        </div>
                        <div class="col-md-12">
                            <?= $this->load->view("mis_bonos") ?>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-12">
                            <p class="h4"><i class="fa fa-file-text"></i> Seguimiento performance improvement plan</p>
                            <hr />
                        </div>
                        <div class="col-md-12">
                            <?= $this->load->view("mis_pip") ?>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<div id="mdDetail" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="mdDetailLabel">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title" id="myModalLabel">Modal title</h4>
            </div>
            <div class="modal-body">
                ...
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">Cancelar</button>
            </div>
        </div>
    </div>
</div>
<div class="js-incidencias"></div>
<div class="md-detalle"></div>
<div id="bonos-container"></div>
<div class="modal-seguimiento-container"></div>