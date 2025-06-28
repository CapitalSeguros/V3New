<div class="tab-pane fade" id="datos-legal" role="tabpanel" aria-labelledby="datos-legal-tab">
    <form class="mt-3">
        <div class="row">
            <div class="col-sm-12 col-md-6">
                <fieldset class="border p-2">
                    <legend class="float-none w-auto p-2">Datos del abogado</legend>
                    <div class="col-12">
                        <div class="form-group">
                            <label >Nombre del Abogado</label>
                            <div class="input-group">
                                <input value="<?= !isset($siniestro_tramite["nombre_abogado"]) ? "" : $siniestro_tramite["nombre_abogado"] ?>" type="text" class="form-control form-control-sm siniestro-l" placeholder="Nombre del Abogado" id="nombre_abogado" name="nombre_abogado" data-toggle="tooltip" data-placement="top" title="Nombre del Abogado">
                                <div class="input-group-append">
                                    <span class="input-group-text">
                                        <i class="fa fa-search"></i>
                                    </span>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-sm-12">
                        <div class="form-group">
                            <label >Correo del abogado</label>
                            <input value="<?= !isset($siniestro_tramite["correo_abogado"]) ? "" : $siniestro_tramite["correo_abogado"] ?>" type="email" class="form-control form-control-sm siniestro-l" placeholder="Correo del abogado" id="correo_abogado" name="correo_abogado" data-toggle="tooltip" data-placement="top" title="Correo del abogado">
                        </div>
                    </div>
                    <div class="col-sm-12">
                        <div class="form-group">
                            <label >Teléfono del abogado</label>
                            <div class="input-group">
                                <input value="<?= !isset($siniestro_tramite["telefono_abogado"]) ? "" : $siniestro_tramite["telefono_abogado"] ?>" type="text" class="form-control form-control-sm siniestro-l" placeholder="Teléfono del abogado" id="telefono_abogado" name="telefono_abogado" data-toggle="tooltip" data-placement="top" title="Teléfono del abogado">
                                <div class="input-group-append">
                                    <span class="input-group-text">
                                        <i class="fa fa-search"></i>
                                    </span>
                                </div>
                            </div>
                        </div>
                    </div>
                </fieldset>
            </div>
            <div class="col-sm-12 col-md-6">
                <fieldset class="border p-2">
                    <legend class="float-none w-auto p-2">Datos del apoderado</legend>
                    <div class="col-sm-12">
                        <div class="form-group">
                            <label >Nombre del apoderado</label>
                            <div class="input-group">
                                <input value="<?= !isset($siniestro_tramite["nombre_apoderado"]) ? "" : $siniestro_tramite["nombre_apoderado"] ?>" type="text" class="form-control form-control-sm siniestro-l" placeholder="Nombre del apoderado" id="nombre_apoderado" name="nombre_apoderado" data-toggle="tooltip" data-placement="top" title="Nombre del apoderado">
                                <div class="input-group-append">
                                    <span class="input-group-text">
                                        <i class="fa fa-search"></i>
                                    </span>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-sm-12">
                        <div class="form-group">
                            <label >Correo del apoderado</label>
                            <input value="<?= !isset($siniestro_tramite["correo_apoderado"]) ? "" : $siniestro_tramite["correo_apoderado"] ?>" type="email" class="form-control form-control-sm siniestro-l" placeholder="Correo del apoderado" id="correo_apoderado" name="correo_apoderado" data-toggle="tooltip" data-placement="top" title="Correo del apoderado">
                        </div>
                    </div>
                    <div class="col-sm-12">
                        <div class="form-group">
                            <label >Teléfono del apoderado</label>
                            <input value="<?= !isset($siniestro_tramite["telefono_apoderado"]) ? "" : $siniestro_tramite["telefono_apoderado"] ?>" type="text" class="form-control form-control-sm siniestro-l" placeholder="Teléfono del apoderado" id="telefono_apoderado" name="telefono_apoderado" data-toggle="tooltip" data-placement="top" title="Teléfono del apoderado">
                        </div>
                    </div>
                </fieldset>
            </div>
        </div>
        <div class="row mt-5">
            <div class="col-md-8">
                <div class="row">
                    <div class="col-12 mb-2 mb-sm-0">
                        <nav aria-label="breadcrumb">
                            <ol class="breadcrumb breadcrumb-no-gutter">
                                <li class="breadcrumb-item active" aria-current="page">Detalle</li>
                            </ol>
                        </nav>
                    </div>
                    <div class="col-sm-12 col-md-6">
                        <div class="form-group">
                            <label >Ubicación fisica de la unidad</label>
                            <input value="<?= !isset($siniestro_tramite["ubicacion_unidad"]) ? "" : $siniestro_tramite["ubicacion_unidad"] ?>" type="text" class="form-control form-control-sm siniestro-l" placeholder="Ubicación fisica de la unidad" id="ubicacion_unidad" name="ubicacion_unidad" data-toggle="tooltip" data-placement="top" title="Ubicación fisica de la unidad">
                        </div>
                    </div>
                    <div class="col-sm-12 col-md-6">
                        <div class="form-group">
                            <label >Autoridad</label>
                            <input value="<?= !isset($siniestro_tramite["autoridad"]) ? "" : $siniestro_tramite["autoridad"] ?>" type="text" class="form-control form-control-sm siniestro-l" placeholder="Autoridad" id="autoridad" name="autoridad" data-toggle="tooltip" data-placement="top" title="Autoridad">
                        </div>
                    </div>
                    <div class="col-sm-12">
                        <div class="control-group" id="fields">
                            <label class="control-label" for="field1">
                                Documento
                            </label>
                            <div class="controls" id="c_legal">
                                <div class="entry input-group upload-input-group">
                                    <input class="form-control fileL" name="legal" id="legal" type="file">
                                    <div class="input-group-append">
                                        <button class="input-group-text btn btn-sm btn-shadow btn-upload btn-success btn-add" data-parent="c_legal" type="button">
                                            <i class="fa fa-plus"></i>
                                        </button>
                                    </div>
                                </div>
                            </div>
                            <a class="btn btn-sm btn-shadow btn-primary mt-3" onclick="OpenDocs(this)" data-id="<?= !isset($siniestro_form["id"]) ? "" : $siniestro_form["id"] ?>" data-tramite="legal">
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
                                        <li class="breadcrumb-item active" aria-current="page">Registro de fechas</li>
                                    </ol>
                                </nav>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-12">
                                <div class="form-group">
                                    <div class="custom-date-2 no-show">
                                        <label>Fecha Localizacion</label>
                                        <input value="<?= !isset($siniestro_tramite["fecha_localizacion"]) ? "" : ($siniestro_tramite["fecha_localizacion"] != "" ? date('Y-m-d', strtotime($siniestro_tramite["fecha_localizacion"])) : "") ?>" type="date" class="form-control form-control-sm siniestro-l" id="fecha_localizacion" name="fecha_localizacion" data-toggle="tooltip" data-placement="top" title="Fecha localización">
                                    </div>
                                </div>
                            </div>
                            <div class="col-12">
                                <div class="form-group">
                                    <div class="custom-date-2 no-show">
                                        <label>Fecha Recuperacion</label>
                                        <input value="<?= !isset($siniestro_tramite["fecha_recuperacion"]) ? "" : ($siniestro_tramite["fecha_recuperacion"] != "" ? date('Y-m-d', strtotime($siniestro_tramite["fecha_recuperacion"])) : "") ?>" type="date" class="form-control form-control-sm siniestro-l" id="fecha_recuperacion" name="fecha_recuperacion" data-toggle="tooltip" data-placement="top" title="Fecha recuperación">
                                    </div>
                                </div>
                            </div>
                            <div class="col-12">
                                <div class="form-group">
                                    <div class="custom-date-2 no-show">
                                        <label>Fecha acreditacion</label>
                                        <input value="<?= !isset($siniestro_tramite["fecha_acreditacion"]) ? "" : ($siniestro_tramite["fecha_acreditacion"] != "" ? date('Y-m-d', strtotime($siniestro_tramite["fecha_acreditacion"])) : "") ?>" type="date" class="form-control form-control-sm siniestro-l" id="fecha_acreditacion" name="fecha_acreditacion" data-toggle="tooltip" data-placement="top" title="Fecha acreditación">
                                    </div>
                                </div>
                            </div>
                            <div class="col-12">
                                <div class="form-group">
                                    <div class="custom-date-2 no-show">
                                        <label>Fecha de dictamen</label>
                                        <input value="<?= !isset($siniestro_tramite["fecha_dictamen"]) ? "" : ($siniestro_tramite["fecha_dictamen"] != "" ? date('Y-m-d', strtotime($siniestro_tramite["fecha_dictamen"])) : "") ?>" type="date" class="form-control form-control-sm siniestro-l" id="fecha_dictamen" name="fecha_dictamen" data-toggle="tooltip" data-placement="top" title="Fecha dictamen">
                                    </div>
                                </div>
                            </div>
                            <div class="col-12">
                                <div class="form-group">
                                    <div class="custom-date-2 no-show">
                                        <label>Fecha de liberación</label>
                                        <input value="<?= !isset($siniestro_tramite["fecha_liberacion"]) ? "" : ($siniestro_tramite["fecha_liberacion"] != "" ? date('Y-m-d', strtotime($siniestro_tramite["fecha_liberacion"])) : "") ?>" type="date" class="form-control form-control-sm siniestro-l" id="fecha_liberacion" name="fecha_liberacion" data-toggle="tooltip" data-placement="top" title="Fecha liberación">
                                    </div>
                                </div>
                            </div>
                            <div class="col-12">
                                <div class="form-group">
                                    <div class="custom-date-2 no-show">
                                        <label>Fecha de Terminación</label>
                                        <input value="<?= !isset($siniestro_tramite["fecha_terminacion"]) ? "" : ($siniestro_tramite["fecha_terminacion"] != "" ? date('Y-m-d', strtotime($siniestro_tramite["fecha_terminacion"])) : "") ?>" type="date" class="form-control form-control-sm siniestro-l" id="fecha_terminacion" name="fecha_terminacion" data-toggle="tooltip" data-placement="top" title="Fecha de Terminación">
                                    </div>
                                </div>
                            </div>
                            <div class="col-12" style="display: none !important;">
                                <div class="form-group">
                                    <label>Estatus tramite legal</label>
                                    <select class="form-control form-control-sm siniestro-l" id="estatus_legal" name="estatus_legal" value="<?= !isset($siniestro_tramite["estatus_legal"]) ? "" : $siniestro_tramite["estatus_legal"] ?>" data-toggle="tooltip" data-placement="top" title="Estatus del trámite legal">
                                        <option value="">Seleccione el Tipo Siniestro</option>
                                        <?php foreach ($estatust as $value) : ?>
                                            <?php if ($value["modulo"] == "DE") : ?>
                                                <?php $valueSet = isset($siniestro_tramite["estatus_legal"]) ? $siniestro_tramite["estatus_legal"] : "" ?>
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
    </form>
</div>
<div class="tab-pane fade" id="datos-reparacion" role="tabpanel" aria-labelledby="datos-reparacion-tab">
    <div class="mt-3">
        <div class="row">
            <div class="col-sm-12 col-md-6">
                <fieldset class="border p-2">
                    <legend class="float-none w-auto p-2">Datos del taller</legend>
                    <div class="col-12">
                        <div class="form-group">
                            <label >Nombre</label>
                            <div class="input-group">
                                <input value="<?= !isset($siniestro_tramite["nombre_taller"]) ? "" : $siniestro_tramite["nombre_taller"] ?>" type="text" class="form-control form-control-sm siniestro-l" placeholder="Nombre" id="nombre_taller" name="nombre_taller" data-toggle="tooltip" data-placement="top" title="Nombre taller">
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
                            <label >Ciudad de reparación</label>
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
                            <input class="form-check-input check-t" type="checkbox" <?= !isset($siniestro_tramite["taller_check"]) ? "" : ($siniestro_tramite["taller_check"] != "0" && $siniestro_tramite["taller_check"] != "" ? "checked" : "") ?> id="taller_check" name="taller_check" data-toggle="tooltip" data-placement="top" title="Taller">
                            <label class="form-check-label">
                                Taller
                            </label>
                        </div>
                        <div class="form-check mt-2">
                            <input class="form-check-input check-t" type="checkbox" <?= !isset($siniestro_tramite["agencia_check"]) ? "" : ($siniestro_tramite["agencia_check"] != "0" && $siniestro_tramite["agencia_check"] != "" ? "checked" : "") ?> id="agencia_check" name="agencia_check" data-toggle="tooltip" data-placement="top" title="Agencia">
                            <label class="form-check-label">
                                Agencia
                            </label>
                        </div>
                    </div>
                    <div class="col-sm-12 mt-3">
                        <div class="form-group">
                            <label >Marca</label>
                            <input value="<?= !isset($siniestro_tramite["marca_reparacion"]) ? "" : $siniestro_tramite["marca_reparacion"] ?>" type="text" class="form-control form-control-sm siniestro-l" placeholder="Marca" id="marca_reparacion" name="marca_reparacion" data-toggle="tooltip" data-placement="top" title="Marca">
                        </div>
                    </div>
                </fieldset>
            </div>
        </div>
        <div class="row mt-5">
            <div class="col-md-8">
                <div class="row">
                    <div class="col-12">
                        <ul class="nav mb-3" id="pills-tab" role="tablist">
                            <li class="nav-item">
                                <a class="nav-link active" id="pills-valuacion-tab" data-toggle="pill" href="#pills-valuacion" role="tab" aria-controls="pills-valuacion" aria-selected="true">Valuación</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" id="pills-refacciones-tab" data-toggle="pill" href="#pills-refacciones" role="tab" aria-controls="pills-refacciones" aria-selected="false">Refacciones en BO</a>
                            </li>
                        </ul>
                        <div class="tab-content" id="pills-tabContent">
                            <div class="tab-pane fade active show in" id="pills-valuacion" role="tabpanel" aria-labelledby="pills-valuacion-tab">
                                <div class="row">
                                    <div class="col-sm-12 col-md-6">
                                        <div class="form-group">
                                            <label >Monto de valuación</label>
                                            <input value=" <?= !isset($siniestro_tramite["monto_valuacion"]) ? "" :"$" . number_format($siniestro_tramite["monto_valuacion"], 2, ".", ",")  ?>" type="text" class="form-control form-control-sm siniestro-l numeric porcentajeD moneyFormat" placeholder="Monto de valuación" id="monto_valuacion" name="monto_valuacion" data-toggle="tooltip" data-placement="top" title="Monto de valuación">
                                        </div>
                                    </div>
                                    <div class="col-sm-12 col-md-6">
                                        <div class="form-group">
                                            <?php
                                           /*  $mval=!isset($siniestro_tramite["monto_valuacion"]) ? 0 : $siniestro_tramite["monto_valuacion"];
                                            $sa=!isset($siniestro_reserva["suma_asegurada"]) ? 0 : $siniestro_reserva["suma_asegurada"];
                                            //<?= !isset($siniestro_tramite["porcentaje_dano"]) ? "" : $siniestro_tramite["porcentaje_dano"] 
                                            if($sa==""|| $sa==0){
                                                $sa=1;
                                            }
                                            $calculo= round((float)$mval/(float)$sa,2);
                                            $pd=!isset($siniestro_tramite["porcentaje_dano"])?"":$calculo; */
                                            ?>
                                            <label >Porcentaje de daño</label>
                                            <input value="<?= !isset($siniestro_tramite["porcentaje_dano"]) ? "0" : $siniestro_tramite["porcentaje_dano"] ?>" type="text" class="form-control form-control-sm siniestro-l numeric" placeholder="Porcentaje de daño" id="porcentaje_dano" name="porcentaje_dano" data-toggle="tooltip" data-placement="top" title="Porcentaje de daño">
                                        </div>
                                    </div>
                                    <div class="col-sm-12 mt-5">
                                        <div class="form-group">
                                            <label >Resultado de la valuación</label>
                                            <textarea rows="5" class="form-control form-control-sm siniestro" placeholder="Resultado de la valuación" id="resultado_valuacion" name="resultado_valuacion" data-toggle="tooltip" data-placement="top" title="Resultado de la valuación">
                                                <?= !isset($siniestro_tramite["resultado_valuacion"]) ? "" : $siniestro_tramite["resultado_valuacion"] ?>
                                            </textarea>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="tab-pane fade" id="pills-refacciones" role="tabpanel" aria-labelledby="pills-refacciones-tab">
                                <div class="row">
                                    <div class="col-12 mb-3" style="text-align: right;">
                                        <a class="btn btn-sm btn-shadow btn-primary" onclick="NewPieza()">
                                            <i class="fa fa-plus"></i> Nuevo
                                        </a>
                                    </div>
                                    <div class="col-12" id="data-refacciones">
                                        <?= $this->load->view("siniestroCorporativo/tablaRefacciones"); ?>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
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
                                        <li class="breadcrumb-item active" aria-current="page">Registro de fechas</li>
                                    </ol>
                                </nav>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-12">
                                <div class="form-group">
                                    <div class="custom-date-2 no-show">
                                        <label class="">Fecha ingreso</label>
                                        <input value="<?= !isset($siniestro_tramite["fecha_ingreso"]) ? "" : ($siniestro_tramite["fecha_ingreso"] != "" ? date('Y-m-d', strtotime($siniestro_tramite["fecha_ingreso"])) : "") ?>" type="date" class="form-control form-control-sm siniestro-l" id="fecha_ingreso" name="fecha_ingreso" data-toggle="tooltip" data-placement="top" title="Fecha ingreso">
                                    </div>
                                </div>
                            </div>
                            <div class="col-12">
                                <div class="form-group">
                                    <div class="custom-date-2 no-show">
                                        <label>Fecha de valuación</label>
                                        <input type="date" value="<?= !isset($siniestro_form["fecha_valuacion"]) ? "" : ($siniestro_form["fecha_valuacion"] != "" ? date('Y-m-d', strtotime($siniestro_form["fecha_valuacion"])) : "") ?>" class="form-control form-control-sm siniestro-f" id="fecha_valuacion" name="fecha_valuacion" data-toggle="tooltip" data-placement="top" title="Fecha valuacion">
                                    </div>
                                </div>
                            </div>
                            <div class="col-12">
                                <div class="form-group">
                                    <div class="custom-date-2 no-show">
                                        <label>Fecha de refacciones</label>
                                        <input value="<?= !isset($siniestro_tramite["fecha_refacciones"]) ? "" : ($siniestro_tramite["fecha_refacciones"] != "" ? date('Y-m-d', strtotime($siniestro_tramite["fecha_refacciones"])) : "") ?>" type="date" class="form-control form-control-sm siniestro-l" id="fecha_refacciones" name="fecha_refacciones" data-toggle="tooltip" data-placement="top" title="Fecha refacciones">
                                    </div>
                                </div>
                            </div>
                            <div class="col-12">
                                <div class="form-group">
                                    <div class="custom-date-2 no-show">
                                        <label>Fecha de notificación en BO</label>
                                        <input value="<?= !isset($siniestro_tramite["fecha_notificacion_bo"]) ? "" : ($siniestro_tramite["fecha_notificacion_bo"] != "" ? date('Y-m-d', strtotime($siniestro_tramite["fecha_notificacion_bo"])) : "") ?>" type="date" class="form-control form-control-sm siniestro-l" id="fecha_notificacion_bo" name="fecha_notificacion_bo" data-toggle="tooltip" data-placement="top" title="Fecha notificación BO">
                                    </div>
                                </div>
                            </div>
                            <div class="col-12">
                                <div class="form-group">
                                    <div class="custom-date-2 no-show">
                                        <label>Fecha de refacciones en BO</label>
                                        <input value="<?= !isset($siniestro_tramite["fecha_refacciones_bo"]) ? "" : ($siniestro_tramite["fecha_refacciones_bo"] != "" ? date('Y-m-d', strtotime($siniestro_tramite["fecha_refacciones_bo"])) : "") ?>" type="date" class="form-control form-control-sm siniestro-l" id="fecha_refacciones_bo" name="fecha_refacciones_bo" data-toggle="tooltip" data-placement="top" title="Fecha refacciones BO">
                                    </div>
                                </div>
                            </div>
                            <div class="col-12">
                                <div class="form-group">
                                    <div class="custom-date-2 no-show">
                                        <label>Fecha de termino de la reparación</label>
                                        <input value="<?= !isset($siniestro_tramite["fecha_termino_reparacion"]) ? "" : ($siniestro_tramite["fecha_termino_reparacion"] != "" ? date('Y-m-d', strtotime($siniestro_tramite["fecha_termino_reparacion"])) : "") ?>" type="date" class="form-control form-control-sm siniestro-l" id="fecha_termino_reparacion" name="fecha_termino_reparacion" data-toggle="tooltip" data-placement="top" title="Fecha termino de reparación">
                                    </div>
                                </div>
                            </div>
                            <div class="col-12">
                                <div class="form-group">
                                    <div class="custom-date-2 no-show">
                                        <label>Fecha de entrega de la unidad</label>
                                        <input value="<?= !isset($siniestro_tramite["fecha_entrega_unidad"]) ? "" : ($siniestro_tramite["fecha_entrega_unidad"] != "" ? date('Y-m-d', strtotime($siniestro_tramite["fecha_entrega_unidad"])) : "") ?>" type="date" class="form-control form-control-sm siniestro-l" id="fecha_entrega_unidad" name="fecha_entrega_unidad" data-toggle="tooltip" data-placement="top" title="Fecha entrega unidad">
                                    </div>
                                </div>
                            </div>
                            <div class="col-12" style="display: none !important;">
                                <div class="form-group">
                                    <label>Estatus del trámite reparación</label>
                                    <select class="form-control form-control-sm siniestro-l" id="estatus_reparacion" name="estatus_reparacion" value="<?= !isset($siniestro_tramite["estatus_reparacion"]) ? "" : $siniestro_tramite["estatus_reparacion"] ?>" data-toggle="tooltip" data-placement="top" title="Estatus del trámite reparación">
                                        <option value="">Seleccione una opcion</option>
                                        <?php foreach ($estatust as $value) : ?>
                                            <?php if ($value["modulo"] == "RE") : ?>
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
</div>
<div class="tab-pane fade" id="datos-perdida-total" role="tabpanel" aria-labelledby="datos-perdida-total-tab">
    <form class="mt-3">
        <div class="row">
            <div class="col-sm-8">
                <fieldset class="border p-2">
                    <legend class="float-none w-auto p-2">Seguimiento</legend>
                    <div class="col-sm-12">
                        <div class="control-group" id="fields">
                            <label class="control-label" for="field1">
                                Documento
                            </label>
                            <div class="controls" id="c_pt">
                                <div class="entry input-group upload-input-group">
                                    <input class="form-control fileL" name="pt" id="pt" type="file">
                                    <div class="input-group-append">
                                        <button class="input-group-text btn btn-sm btn-shadow btn-upload btn-success btn-add" data-parent="c_pt" type="button">
                                            <i class="fa fa-plus"></i>
                                        </button>
                                    </div>

                                </div>
                            </div>
                            <a class="btn btn-sm btn-shadow btn-primary mt-3" onclick="OpenDocs(this)" data-id="<?= !isset($siniestro_form["id"]) ? "" : $siniestro_form["id"] ?>" data-tramite="pt">
                                <i class="fa fa-file"> </i>
                                Mis documentos
                            </a>
                            <a class="btn btn-sm btn-shadow btn-primary mt-3" onclick="Seguimiento(this)" data-id="<?= !isset($siniestro_form["id"]) ? "" : $siniestro_form["id"] ?>" data-tramite="legal">
                                <i class="fa fa-file"> </i>
                                Seguimiento
                            </a>
                        </div>
                    </div>
                </fieldset>
            </div>
            <div class="col-sm-4">
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
                                        <label class="">Fecha de notificación</label>
                                        <input value="<?= !isset($siniestro_tramite["fecha_notificacion"]) ? "" : ($siniestro_tramite["fecha_notificacion"] != "" ? date('Y-m-d', strtotime($siniestro_tramite["fecha_notificacion"])) : "") ?>" type="date" class="form-control form-control-sm siniestro-l" id="fecha_notificacion" name="fecha_notificacion" data-toggle="tooltip" data-placement="top" title="Fecha de notificación">
                                    </div>
                                </div>
                            </div>
                            <div class="col-12">
                                <div class="form-group">
                                    <div class="custom-date-2 no-show">
                                        <label>Fecha de documentación</label>
                                        <input value="<?= !isset($siniestro_tramite["fecha_documentacion"]) ? "" : ($siniestro_tramite["fecha_documentacion"] != "" ? date('Y-m-d', strtotime($siniestro_tramite["fecha_documentacion"])) : "") ?>" type="date" class="form-control form-control-sm siniestro-l" id="fecha_documentacion" name="fecha_documentacion" data-toggle="tooltip" data-placement="top" title="Fecha de documentación">
                                    </div>
                                </div>
                            </div>
                            <div class="col-12">
                                <div class="form-group">
                                    <div class="custom-date-2 no-show">
                                        <label>Fecha de pago</label>
                                        <input value="<?= !isset($siniestro_tramite["fecha_pago"]) ? "" : ($siniestro_tramite["fecha_pago"] != "" ? date('Y-m-d', strtotime($siniestro_tramite["fecha_pago"])) : "") ?>" type="date" class="form-control form-control-sm siniestro-l penalizacionChange" id="fecha_pago" name="fecha_pago" data-toggle="tooltip" data-placement="top" title="Fecha de pago">
                                    </div>
                                </div>
                            </div>
                            <div class="col-12">
                                <div class="form-group">
                                    <div class="custom-date-2 no-show">
                                        <label>Fecha límite de pago</label>
                                        <input value="<?= !isset($siniestro_tramite["fecha_pago_limite"]) ? "" : ($siniestro_tramite["fecha_pago_limite"] != "" ? date('Y-m-d', strtotime($siniestro_tramite["fecha_pago_limite"])) : "") ?>" type="date" class="form-control form-control-sm siniestro-l penalizacionChange" id="fecha_pago_limite" name="fecha_pago_limite" data-toggle="tooltip" data-placement="top" title="Fecha límite de pago">
                                    </div>
                                </div>
                            </div>
                            <div class="col-12">
                                <div class="form-group">
                                    <div class="custom-date-2 no-show">
                                        <label>Fecha de entrega de BP</label>
                                        <input value="<?= !isset($siniestro_tramite["fecha_entrega_bp"]) ? "" : ($siniestro_tramite["fecha_entrega_bp"] != "" ? date('Y-m-d', strtotime($siniestro_tramite["fecha_entrega_bp"])) : "") ?>" type="date" class="form-control form-control-sm siniestro-l" id="fecha_entrega_bp" name="fecha_entrega_bp" data-toggle="tooltip" data-placement="top" title="Fecha de entrega de BP">
                                    </div>
                                </div>
                            </div>
                            <div class="col-12" style="display: none !important;">
                                <div class="form-group">
                                    <label>Estatus del trámite PT</label>
                                    <select class="form-control form-control-sm siniestro-l" id="estatus_pt" name="estatus_pt" value="<?= !isset($siniestro_tramite["estatus_pt"]) ? "" : $siniestro_tramite["estatus_pt"] ?>" data-toggle="tooltip" data-placement="top" title="Estatus del trámite PT">
                                        <option value="">Seleccione una opcion</option>
                                        <?php foreach ($estatust as $value) : ?>
                                            <?php if ($value["modulo"] == "PT") : ?>
                                                <?php $valueSet = isset($siniestro_tramite["estatus_pt"]) ? $siniestro_tramite["estatus_pt"] : "" ?>
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
        <div class="row mt-5">
            <div class="col-md-8">
                <div class="row">
                    <div class="col-12 mb-2 mb-sm-0">
                        <nav aria-label="breadcrumb">
                            <ol class="breadcrumb breadcrumb-no-gutter">
                                <li class="breadcrumb-item active" aria-current="page">Penalización</li>
                            </ol>
                        </nav>
                    </div>
                    <div class="col-sm-12 col-md-6">
                        <div class="form-group">
                            <label >Días por penalización</label>
                            <input value="<?= !isset($siniestro_tramite["dias_penalizacion"]) ? "" : $siniestro_tramite["dias_penalizacion"] ?>" type="number" class="form-control form-control-sm siniestro-l numeric moneyFormat" placeholder="Días por penalización" id="dias_penalizacion" name="dias_penalizacion" data-toggle="tooltip" data-placement="top" title="Días por penalización" readonly>
                        </div>
                    </div>
                    <div class="col-sm-12 col-md-6">
                        <div class="form-group">
                            <label >Monto por día</label>
                            <div class="input-group">
                                <div class="input-group-prepend">
                                    <span class="input-group-text">
                                        <i class="fa fa-dollar"></i>
                                    </span>
                                </div>
                                <input value="<?= !isset($siniestro_tramite["monto_dia"]) ? "1000" : $siniestro_tramite["monto_dia"] ?>" type="number" class="form-control form-control-sm siniestro-l numeric moneyFormat" placeholder="Monto por día" id="monto_dia" name="monto_dia" data-toggle="tooltip" data-placement="top" title="Monto por día">
                            </div>
                        </div>
                    </div>
                    <div class="col-sm-12 col-md-6">
                        <div class="form-group">
                            <label >Total de la penalización</label>
                            <input value="<?= !isset($siniestro_tramite["total_penalizacion"]) ? "" : $siniestro_tramite["total_penalizacion"] ?>" type="number" class="form-control form-control-sm siniestro-l numeric moneyFormat" placeholder="Total de la penalización" id="total_penalizacion" name="total_penalizacion" data-toggle="tooltip" data-placement="top" title="Total de la penalización" readonly>
                        </div>
                    </div>
                    <div class="col-sm-12 col-md-6">
                        <div class="form-group">
                            <div class="custom-date no-show">
                                <label>Fecha de pago</label>
                                <input value="<?= !isset($siniestro_tramite["fecha_pago_penalizacion"]) ? "" : ($siniestro_tramite["fecha_pago_penalizacion"] != "" ? date('Y-m-d', strtotime($siniestro_tramite["fecha_pago_penalizacion"])) : "") ?>" type="date" class="form-control form-control-sm siniestro-l" id="fecha_pago_penalizacion" name="fecha_pago_penalizacion" data-toggle="tooltip" data-placement="top" title="Fecha de pago">
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="row"></div>
            </div>
        </div>
    </form>
</div>