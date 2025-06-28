<div class="tab-pane fade" id="datos-reparacion" role="tabpanel" aria-labelledby="datos-reparacion-tab">
    <form class="mt-3">
        <div class="row">
            <div class="col-sm-12 col-md-12">
                <fieldset class="border p-2">
                    <legend class="float-none w-auto p-2">Datos del proveedor </legend>
                    <div class="col-12">
                        <div class="form-group">
                            <label >Nombre</label>
                            <div class="input-group">
                                <input value="<?= !isset($siniestro_tramite["nombre_proveedor"]) ? "" : $siniestro_tramite["nombre_proveedor"] ?>" type="text" class="form-control form-control-sm siniestro-l" placeholder="Nombre" id="nombre_proveedor" name="nombre_proveedor" data-toggle="tooltip" data-placement="top" title="Nombre">
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
                            <label >Contacto</label>
                            <input value="<?= !isset($siniestro_tramite["contacto_proveedor"]) ? "" : $siniestro_tramite["contacto_proveedor"] ?>" type="email" class="form-control form-control-sm siniestro-l" placeholder="Contacto Proveedor" id="contacto_proveedor" name="contacto_proveedor" data-toggle="tooltip" data-placement="top" title="Contacto Proveedor">
                        </div>
                    </div>
                </fieldset>
            </div>
        </div>
        <div class="row mt-5">
            <div class="col-md-8">
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
            <div class="col-md-4">
                <div class="row">
                    <div class="col-md-12">
                        <div class="row">
                            <div class="col-12 mb-2 mb-sm-0">
                                <nav aria-label="breadcrumb">
                                    <ol class="breadcrumb breadcrumb-no-gutter">
                                        <li class="breadcrumb-item active" aria-current="page">Registro de valores</li>
                                    </ol>
                                </nav>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-12">
                                <div class="form-group">
                                    <div class="custom-date-2 no-show">
                                        <label class="">Costo total</label>
                                        <input value="<?= !isset($siniestro_tramite["costo_total"]) ? "" : $siniestro_tramite["costo_total"] ?>" type="text" class="form-control form-control-sm siniestro-l" id="costo_total" name="costo_total" data-toggle="tooltip" data-placement="top" title="Costo total">
                                    </div>
                                </div>
                            </div>
                            <div class="col-12">
                                <div class="form-group">
                                    <div class="custom-date-2 no-show">
                                        <label>Costo a cargo CIA</label>
                                        <input value="<?= !isset($siniestro_tramite["costo_carga_cia"]) ? "" : $siniestro_tramite["costo_carga_cia"] ?>" type="text" class="form-control form-control-sm siniestro-l" id="costo_carga_cia" name="costo_carga_cia" data-toggle="tooltip" data-placement="top" title="Costo a cargo CIA">
                                    </div>
                                </div>
                            </div>
                            <div class="col-12">
                                <div class="form-group">
                                    <div class="custom-date-2 no-show">
                                        <label>Costo a cargo NA</label>
                                        <input value="<?= !isset($siniestro_tramite["costo_carga_na"]) ? "" : $siniestro_tramite["costo_carga_na"] ?>" type="text" class="form-control form-control-sm siniestro-l" id="costo_carga_na" name="costo_carga_na" data-toggle="tooltip" data-placement="top" title="Costo a cargo NA">
                                    </div>
                                </div>
                            </div>
                            <div class="col-12">
                                <div class="form-group">
                                    <div class="custom-date-2 no-show">
                                        <label>Fecha de pago</label>
                                        <input value="<?= !isset($siniestro_tramite["fecha_pago"]) ? "" : ($siniestro_tramite["fecha_pago"] != "" ? date('Y-m-d', strtotime($siniestro_tramite["fecha_pago"])) : "") ?>" type="date" class="form-control form-control-sm siniestro-l" id="fecha_pago" name="fecha_pago" data-toggle="tooltip" data-placement="top" title="Fecha de pago">
                                    </div>
                                </div>
                            </div>
                            <div class="col-12">
                                <label>Estatus tramite reparación</label>
                                <select class="form-control form-control-sm siniestro-l" id="estatus_reparacion" name="estatus_reparacion" value="<?= !isset($siniestro_tramite["estatus_reparacion"]) ? "" : $siniestro_tramite["estatus_reparacion"] ?>" data-toggle="tooltip" data-placement="top" title="Estatus del trámite reparación">
                                    <option value="">Seleccione una opción</option>
                                    <?php foreach ($estatust as $value) : ?>
                                        <?php if ($value["modulo"] == "AV") : ?>
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
    </form>
</div>