<div class="tab-pane fade" id="datos-reparacion" role="tabpanel" aria-labelledby="datos-reparacion-tab">
    <form class="mt-3">
        <div class="row">
            <div class="col-sm-12 col-md-6">
                <fieldset class="border p-2">
                    <legend class="float-none w-auto p-2">Datos del taller</legend>
                    <div class="col-12">
                        <div class="form-group">
                            <label>Nombre</label>
                            <div class="input-group">
                                <input value="<?= !isset($siniestro_tramite["nombre_taller"]) ? "" : $siniestro_tramite["nombre_taller"] ?>" type="text" class="form-control form-control-sm siniestro-l" placeholder="Nombre" id="nombre_taller" name="nombre_taller" data-toggle="tooltip" data-placement="top" title="nombre">
                                <div class="input-group-append">
                                    <span class="input-group-text">
                                        <i class="fa fa-search"></i>
                                    </span>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-12 mb-5">
                        <div class="form-group">
                            <label>Ciudad de reparación</label>
                            <input value="<?= !isset($siniestro_tramite["ciudad_reparacion"]) ? "" : $siniestro_tramite["ciudad_reparacion"] ?>" type="email" class="form-control form-control-sm siniestro-l" placeholder="Ciudad de reparación" id="ciudad_reparacion" name="ciudad_reparacion" data-toggle="tooltip" data-placement="top" title="Ciudad de reparación">
                        </div>
                    </div>
                </fieldset>
            </div>
            <div class="col-sm-12 col-md-6">
                <fieldset class="border p-2">
                    <legend class="float-none w-auto p-2">Complemento</legend>
                    <div class="col-sm-12">
                        <div class="form-check mt-2">
                            <input value="<?= !isset($siniestro_tramite["cambio_check"]) ? "" : $siniestro_tramite["cambio_check"] ?>" class="form-check-input siniestro-l check-t" type="checkbox" id="cambio_check" name="cambio_check" data-toggle="tooltip" data-placement="top" title="Cambio">
                            <label class="form-check-label">
                                Cambio
                            </label>
                        </div>
                        <div class="form-check mt-2">
                            <input value="<?= !isset($siniestro_tramite["agencia"]) ? "" : $siniestro_tramite["agencia"] ?>" class="form-check-input siniestro-l check-t" type="checkbox" id="reparacion_check" name="reparacion_check" data-toggle="tooltip" data-placement="top" title="Reparación">
                            <label class="form-check-label">
                                Reparacion
                            </label>
                        </div>
                    </div>
                    <div class="col-sm-12 mt-3">
                        <div class="form-group">
                            <label>Cristal en existencia</label>
                            <select class="form-control form-control-sm siniestro-l" id="exitencia_check" name="exitencia_check" value="<?= $siniestro_tramite_form["exitencia_check"] ?>" data-toggle="tooltip" data-placement="top" title="Cristal en existencia">
                                <option value="">Seleccione una opcion</option>
                                <option value="1">Si</option>
                                <option value="0">No</option>
                            </select>
                        </div>
                    </div>
                </fieldset>
            </div>
        </div>
        <div class="row mt-5">
            <div class="col-md-6">
                <div class="row">
                    <div class="col-sm-12">
                        <div class="control-group" id="fields">
                            <label class="control-label" for="field1">
                                Documento
                            </label>
                            <div class="controls" id="c_reparacion">
                                <div class="entry input-group upload-input-group">
                                    <input class="form-control fileL" name="reparacion" id="reparacion" type="file">
                                    <div class="input-group-append">
                                        <button class="input-group-text btn btn-sm btn-shadow btn-upload btn-success btn-add" data-parent="c_reparacion" type="button">
                                            <i class="fa fa-plus"></i>
                                        </button>
                                    </div>

                                </div>
                            </div>
                            <a class="btn btn-sm btn-shadow btn-primary mt-3" onclick="OpenDocs(this)" data-id="<?= !isset($siniestro_form["id"]) ? "" : $siniestro_form["id"] ?>" data-tramite="reparacion">
                                <i class="fa fa-file"> </i>
                                Mis documentos
                            </a>
                            <a class="btn btn-sm btn-shadow btn-primary mt-3" onclick="Seguimiento(this)" data-id="<?= !isset($siniestro_form["id"]) ? "" : $siniestro_form["id"] ?>" data-tramite="legal">
                                <i class="fa fa-file"> </i>
                                Seguimiento
                            </a>

                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-6">
                <div class="row">
                    <div class="col-md-12">
                        <div class="row">
                            <div class="col-12 mb-2 mb-sm-0">
                                <nav aria-label="breadcrumb">
                                    <ol class="breadcrumb breadcrumb-no-gutter">
                                        <li class="breadcrumb-item active" aria-current="page">Registro de fechas</li>
                                    </ol>
                                </nav>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-12">
                                <div class="form-group">
                                    <div class="custom-date-2 no-show">
                                        <label class="">Fecha surtido</label>
                                        <input value="<?= !isset($siniestro_tramite["fecha_surtido"]) ? "" : ($siniestro_tramite["fecha_surtido"] != "" ? date('Y-m-d', strtotime($siniestro_tramite["fecha_surtido"])) : "") ?>" type="date" class="form-control form-control-sm siniestro-l" id="fecha_surtido" name="fecha_surtido" data-toggle="tooltip" data-placement="top" title="Fecha surtido">
                                    </div>
                                </div>
                            </div>
                            <div class="col-12">
                                <div class="form-group">
                                    <div class="custom-date-2 no-show">
                                        <label>Fecha de surtido BO</label>
                                        <input value="<?= !isset($siniestro_tramite["fecha_surtido_bo"]) ? "" : ($siniestro_tramite["fecha_surtido_bo"] != "" ? date('Y-m-d', strtotime($siniestro_tramite["fecha_surtido_bo"])) : "") ?>" type="date" class="form-control form-control-sm siniestro-l" id="fecha_surtido_bo" name="fecha_surtido_bo" data-toggle="tooltip" data-placement="top" title="Fecha de surtido BO">
                                    </div>
                                </div>
                            </div>
                            <div class="col-12">
                                <div class="form-group">
                                    <div class="custom-date-2 no-show">
                                        <label>Fecha cita</label>
                                        <input value="<?= !isset($siniestro_tramite["fecha_cita"]) ? "" : ($siniestro_tramite["fecha_cita"] != "" ? date('Y-m-d', strtotime($siniestro_tramite["fecha_cita"])) : "") ?>" type="date" class="form-control form-control-sm siniestro-l" id="fecha_cita" name="fecha_cita" data-toggle="tooltip" data-placement="top" title="Fecha cita">
                                    </div>
                                </div>
                            </div>
                            <div class="col-12">
                                <div class="form-group">
                                    <div class="custom-date-2 no-show">
                                        <label>Fecha instalación</label>
                                        <input value="<?= !isset($siniestro_tramite["fecha_instalacion"]) ? "" : ($siniestro_tramite["fecha_instalacion"] != "" ? date('Y-m-d', strtotime($siniestro_tramite["fecha_instalacion"])) : "") ?>" type="date" class="form-control form-control-sm siniestro-l" id="fecha_instalacion" name="fecha_instalacion" data-toggle="tooltip" data-placement="top" title="Fecha instalación">
                                    </div>
                                </div>
                            </div>
                            <div class="col-12">
                                <div class="form-group">
                                    <div class="custom-date-2 no-show">
                                        <label>Fecha de entrega</label>
                                        <input value="<?= !isset($siniestro_tramite["fecha_entrega"]) ? "" : ($siniestro_tramite["fecha_entrega"] != "" ? date('Y-m-d', strtotime($siniestro_tramite["fecha_entrega"])) : "") ?>" type="date" class="form-control form-control-sm siniestro-l" id="fecha_entrega" name="fecha_entrega" data-toggle="tooltip" data-placement="top" title="Fecha de entrega">
                                    </div>
                                </div>
                            </div>
                            <div class="col-12" style="display: none !important;">
                                <div class="form-group">
                                    <label>Estatus tramite reparación</label>
                                    <select class="form-control form-control-sm siniestro-l" id="estatus_reparacion" name="estatus_reparacion" value="<?= !isset($siniestro_tramite["estatus_reparacion"]) ? "" : $siniestro_tramite["estatus_reparacion"] ?>" data-toggle="tooltip" data-placement="top" title="Estatus del trámite reparación">
                                        <option value="">Seleccione uan opción</option>
                                        <?php foreach ($estatust as $value) : ?>
                                            <?php if ($value["modulo"] == "CR") : ?>
                                                <?php $valueSet = isset($siniestro_tramite["estatus_reparacion"]) ? $siniestro_tramite["estatus_reparacion"] : "" ?>
                                                <option value="<?= $value['nombre'] ?>" <?= $valueSet == $value['nombre'] ? 'selected' : '' ?>><?= $value['nombre'] ?></option>
                                            <?php endif ?>
                                        <?php endforeach; ?>
                                    </select>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
</div>
</form>
</div>