<div class="container">
    <div class="row app-ticc">
        <div class="col-12">
            <div class="card mt-5  mb-5">
                <!-- Header -->
                <div class="card-header">
                    <div class="row">
                        <div class="col-8">
                        </div>
                        <div class="col-4">
                            <!-- Dropdown -->
                            <div class="dropdown float-right">
                                <button type="button" class="btn btn-info btn-shadow btn-sm dropdown-toggle w-100" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                    <i class="bi-download me-2"></i> Acciones
                                </button>
                                <div class="dropdown-menu dropdown-menu-sm-end" aria-labelledby="dropdownMenuButton">
                                    <a class="nav-link" id="save_button">
                                        <i class="nav-link-icon fa fa-save"></i>
                                        <span> Guardar</span>
                                    </a>
                                    <a class="nav-link" href="<?= base_url() ?>siniestroCorporativo">
                                        <i class="nav-link-icon fa fa-plus"></i>
                                        <span> Cancelar</span>
                                    </a>
                                </div>
                            </div>
                            <!-- End Dropdown -->
                        </div>
                    </div>
                </div>
                <!-- End Header -->
                <form id="form-body" name="form-body">
                    <div class="card-body">
                        <div class="row">
                            <div class="col-12">
                                <ul class="nav nav-tabs nav-justified" id="general" role="tablist">
                                    <li class="nav-item">
                                        <a class="nav-link active" id="home-tab" data-toggle="tab" href="#datos-generales" role="tab" aria-controls="datos-generales" aria-selected="true">Datos Generales</a>
                                    </li>
                                    <?php if ($siniestro_form["tipo_siniestro_id"] != 0) : ?>
                                        <?php if ($template != "TIPO1") : ?>
                                            <li class="nav-item" data-modulo="reparacion">
                                                <a class="nav-link" id="contact-tab" data-toggle="tab" href="#datos-reparacion" role="tab" aria-controls="datos-reparacion" aria-selected="false">Reparación</a>
                                            </li>
                                        <?php else : ?>
                                            <li class="nav-item" data-modulo="legal">
                                                <a class="nav-link" id="profile-tab" data-toggle="tab" href="#datos-legal" role="tab" aria-controls="datos-legal" aria-selected="false">Legal</a>
                                            </li>
                                            <li class="nav-item" data-modulo="reparacion">
                                                <a class="nav-link" id="contact-tab" data-toggle="tab" href="#datos-reparacion" role="tab" aria-controls="datos-reparacion" aria-selected="false">Reparación</a>
                                            </li>
                                            <li class="nav-item" data-modulo="pt">
                                                <a class="nav-link" id="contact-tab" data-toggle="tab" href="#datos-perdida-total" role="tab" aria-controls="datos-perdida-total" aria-selected="false">Perdida Total</a>
                                            </li>
                                        <?php endif; ?>
                                    <?php endif; ?>

                                </ul>
                                <div class="tab-content" id="generalTabContent">
                                    <div class="tab-pane fade active show in" id="datos-generales" role="tabpanel" aria-labelledby="datos-generales-tab">
                                        <form class="mt-3">
                                            <div class="row">
                                                <div class="col-sm-12 col-md-4">
                                                    <div class="form-group">
                                                        <label>Póliza</label>
                                                        <div class="input-group">
                                                            <input type="text" value="<?= !isset($siniestro_poliza["Poliza"]) ? "" : $siniestro_poliza["Poliza"] ?>" class="form-control form-control-sm siniestro-p <?= !isset($siniestro_poliza["Id"]) ? "" : "inputdcss" ?>" placeholder="Póliza" id="Poliza" name="Poliza" data-toggle="tooltip" data-placement="top" title="Póliza">
                                                            <input type="hidden" value="<?= !isset($siniestro_poliza["Id"]) ? "0" : $siniestro_poliza["Id"] ?>" class="form-control form-control-sm siniestro-p id-input-poliza <?= !isset($siniestro_poliza["Id"]) ? "" : "inputdcss" ?>" id="Id" name="Id">
                                                            <div class="input-group-append">
                                                                <?php if (isset($siniestro_poliza["Id"])) : ?>
                                                                    <span class="input-group-text dbutton" style="cursor: pointer;" id="btn_cliente">
                                                                        <i class="fa fa-search"></i>
                                                                    </span>
                                                                    <!--  <span class="input-group-text">
                                                                        <i class="fa fa-search"></i>
                                                                    </span> -->
                                                                <?php else : ?>
                                                                    <span class="input-group-text " style="cursor: pointer;" id="btn_cliente">
                                                                        <i class="fa fa-search"></i>
                                                                    </span>
                                                                <?php endif; ?>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-sm-12 col-md-4 pt-4">
                                                    <div class="form-group">
                                                        <div class="custom-date no-show">
                                                            <label>Desde</label>
                                                            <input type="date" value="<?= !isset($siniestro_poliza["FDesde"]) ? "" : ($siniestro_poliza["FDesde"] != "" ? date('Y-m-d', strtotime($siniestro_poliza["FDesde"])) : "") ?>" class="form-control form-control-sm siniestro-p <?= !isset($siniestro_poliza["Id"]) ? "" : "inputdcss" ?>" id="FDesde" name="FDesde" data-toggle="tooltip" data-placement="top" title="Desde">
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-sm-12 col-md-4 pt-4">
                                                    <div class="form-group">
                                                        <div class="custom-date no-show">
                                                            <label>Hasta</label>
                                                            <input type="date" value="<?= !isset($siniestro_poliza["FHasta"]) ? "" : ($siniestro_poliza["FHasta"] != "" ? date('Y-m-d', strtotime($siniestro_poliza["FHasta"])) : "") ?>" class="form-control form-control-sm siniestro-p <?= !isset($siniestro_poliza["Id"]) ? "" : "inputdcss" ?>" id="FHasta" name="FHasta" data-toggle="tooltip" data-placement="top" title="Hasta">
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-sm-12 col-md-3">
                                                    <div class="form-group">
                                                        <label>Endoso</label>
                                                        <input type="text" value="<?= !isset($siniestro_poliza["Endoso"]) ? "" : $siniestro_poliza["Endoso"] ?>" class="form-control form-control-sm siniestro-p <?= !isset($siniestro_poliza["Id"]) ? "" : "inputdcss" ?>" placeholder="Endoso" id="Endoso" name="Endoso" data-toggle="tooltip" data-placement="top" title="Endoso">
                                                    </div>
                                                </div>
                                                <div class="col-sm-12 col-md-3">
                                                    <div class="form-group">
                                                        <label>Serie</label>
                                                        <input type="text" value="<?= !isset($siniestro_poliza["Serie"]) ? "" : $siniestro_poliza["Serie"] ?>" class="form-control form-control-sm siniestro-p <?= !isset($siniestro_poliza["Id"]) ? "" : "inputdcss" ?>" placeholder="Serie" id="Serie" name="Serie" data-toggle="tooltip" data-placement="top" title="Serie">
                                                    </div>
                                                </div>
                                                <div class="col-sm-12 col-md-3">
                                                    <div class="form-group">
                                                        <label>Modelo</label>
                                                        <input type="text" value="<?= !isset($siniestro_poliza["Modelo"]) ? "" : $siniestro_poliza["Modelo"] ?>" class="form-control form-control-sm siniestro-p <?= !isset($siniestro_poliza["Id"]) ? "" : "inputdcss" ?>" placeholder="Modelo" id="Modelo" name="Modelo" data-toggle="tooltip" data-placement="top" title="Modelo">
                                                    </div>
                                                </div>
                                                <div class="col-sm-12 col-md-3">
                                                    <div class="form-group">
                                                        <label>Economico</label>
                                                        <input type="text" value="<?= !isset($siniestro_poliza["Economico"]) ? "" : $siniestro_poliza["Economico"] ?>" class="form-control form-control-sm siniestro-p <?= !isset($siniestro_poliza["Id"]) ? "" : "inputdcss" ?>" placeholder="Economico" id="Economico" name="Economico" data-toggle="tooltip" data-placement="top" title="Economico">
                                                    </div>
                                                </div>
                                                <div class="col-sm-12 col-md-6">
                                                    <div class="form-group">
                                                        <label>Descripción</label>
                                                        <div class="input-group">
                                                            <input type="text" value="<?= !isset($siniestro_poliza["Descripcion"]) ? "" : $siniestro_poliza["Descripcion"] ?>" class="form-control form-control-sm siniestro-p <?= !isset($siniestro_poliza["Id"]) ? "" : "inputdcss" ?>" placeholder="Descripcion" id="Descripcion" name="Descripcion" data-toggle="tooltip" data-placement="top" title="Descripcion">
                                                           
                                                        </div>
                                                    </div>
                                                </div>
                                                
                                                <div class="col-sm-12 col-md-6 mt-5">
                                                    <div class="float-right" style="display: flex;">
                                                        <?php if (isset($siniestro_poliza["Id"])) : ?>
                                                            <span class="input-group-text" style="width: 25px; height: 25px;cursor: pointer;" id="editP" data-toggle="tooltip" data-placement="top" title="Editar Póliza">
                                                                <i class="fa fa-pencil"></i>
                                                            </span>
                                                            <span class="input-group-text" style="width: 25px; height: 25px;cursor: pointer;" id="addP" data-toggle="tooltip" data-placement="top" title="Nueva Póliza">
                                                                <i class="fa fa-plus"></i>
                                                            </span>

                                                        <?php else : ?>
                                                            <span class="input-group-text" style="width: 25px; height: 25px;cursor: pointer;" id="addP" data-toggle="tooltip" data-placement="top" title="Nueva Póliza">
                                                                <i class="fa fa-plus"></i>
                                                            </span>
                                                        <?php endif; ?>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="row mt-5">
                                                <div class="col-md-6">
                                                    <div class="row">
                                                        <div class="col-12 mb-2 mb-sm-0">
                                                            <nav aria-label="breadcrumb">
                                                                <ol class="breadcrumb breadcrumb-no-gutter">
                                                                    <li class="breadcrumb-item active" aria-current="page">Detalle del siniestro</li>
                                                                    <input type="hidden" class="siniestro-f" id="id" name="id" value="<?= !isset($siniestro_form["id"]) ? "" : $siniestro_form["id"] ?>" />
                                                                    <input type="hidden" class="siniestro-f" id="siniestro_poliza_id" name="siniestro_poliza_id" value="<?= !isset($siniestro_form["siniestro_poliza_id"]) ? "" : $siniestro_form["siniestro_poliza_id"] ?>" />
                                                                </ol>
                                                            </nav>
                                                        </div>
                                                        <div class="col-sm-12 col-md-4">
                                                            <div class="form-group">
                                                                <label>Número de reporte</label>
                                                                <input type="text" value="<?= !isset($siniestro_form["num_reporte"]) ? "" : $siniestro_form["num_reporte"] ?>" class="form-control form-control-sm siniestro-f" placeholder="Número de reporte" id="num_reporte" name="num_reporte" data-toggle="tooltip" data-placement="top" title="Número de reporte">
                                                            </div>
                                                        </div>
                                                        <div class="col-sm-12 col-md-4">
                                                            <div class="form-group">
                                                                <label>Número de siniestro</label>
                                                                <input type="text" value="<?= !isset($siniestro_form["num_siniestro"]) ? "" : $siniestro_form["num_siniestro"] ?>" class="form-control form-control-sm siniestro-f" placeholder="Número de siniestro" id="num_siniestro" name="num_siniestro" data-toggle="tooltip" data-placement="top" title="Número de siniestro">
                                                            </div>
                                                        </div>
                                                        <div class="col-sm-12 col-md-4">
                                                            <div class="form-group">
                                                                <label>Estatus</label>
                                                                <select class="form-control form-control-sm siniestro-f" value="<?= !isset($siniestro_form["siniestro_estatus"]) ? "" : $siniestro_form["siniestro_estatus"] ?>" id="siniestro_estatus" name="siniestro_estatus" data-toggle="tooltip" data-placement="top" title="Estatus">
                                                                    <option>Selecciona el estatus</option>
                                                                    <?php foreach ($estatus as $value) :
                                                                        $est = isset($siniestro_form["siniestro_estatus"]) ? $siniestro_form["siniestro_estatus"] : '';
                                                                    ?>
                                                                        <option value="<?= $value['nombre'] ?>" <?= $value['nombre'] == $est ? 'selected' : '' ?>><?= $value['nombre'] ?></option>
                                                                    <?php endforeach; ?>
                                                                </select>
                                                            </div>
                                                        </div>
                                                        <div class="col-sm-12 col-md-4">
                                                            <div class="form-group">
                                                                <label>Estado</label>
                                                                <select class="form-control form-control-sm siniestro-f" value="<?= !isset($siniestro_form["estado"]) ? "" : $siniestro_form["estado"] ?>" id="estado" name="estado" data-toggle="tooltip" data-placement="top" title="Estado">
                                                                    <option value="">Seleccione uno</option>
                                                                    <?php foreach ($estados as $value) :
                                                                        $est = isset($siniestro_form["estado"]) ? $siniestro_form["estado"] : '';
                                                                    ?>
                                                                        <option value="<?= $value['clave'] ?>" <?= $value['clave'] == $est ? 'selected' : '' ?>><?= $value['estado'] ?></option>
                                                                    <?php endforeach; ?>
                                                                </select>
                                                            </div>
                                                        </div>
                                                        <div class="col-sm-12 col-md-4">
                                                            <div class="form-group">
                                                                <label>Ciudad</label>
                                                                <input type="text" value="<?= !isset($siniestro_form["ciudad"]) ? "" : $siniestro_form["ciudad"] ?>" id="ciudad" name="ciudad" class="form-control form-control-sm siniestro-f" placeholder="Ciudad" data-toggle="tooltip" data-placement="top" title="Ciudad">
                                                            </div>
                                                        </div>
                                                        <div class="col-sm-12 col-md-4">
                                                            <div class="form-group">
                                                                <label>Estatus</label>
                                                                <select class="form-control form-control-sm siniestro-f" value="<?= !isset($siniestro_form["estatus_t"]) ? "" : $siniestro_form["estatus_t"] ?>" id="estatus_t" name="estatus_t" data-toggle="tooltip" data-placement="top" title="Estatus T">
                                                                    <option value="">Seleccione el Estatus T</option>
                                                                    <?php $value = isset($siniestro_form["estatus_t"]) ? $siniestro_form["estatus_t"] : "" ?>
                                                                    <option value="1" <?= $value == "1" ? "selected" : "" ?>>SI</option>
                                                                    <option value="0" <?= $value == "0" ? "selected" : "" ?>>NO</option>
                                                                </select>
                                                            </div>
                                                        </div>
                                                        <div class="col-sm-12 col-md-3">
                                                            <div class="form-group">
                                                                <label>Económico</label>
                                                                <input type="text" value="<?= !isset($siniestro_form["economico"]) ? "" : $siniestro_form["economico"] ?>" class="form-control form-control-sm siniestro-f" placeholder="Económico" id="economico" name="economico" data-toggle="tooltip" data-placement="top" title="Económico">
                                                            </div>
                                                        </div>
                                                        <div class="col-sm-12 col-md-3">
                                                            <div class="form-group">
                                                                <label>Marca</label>
                                                                <input type="text" value="<?= !isset($siniestro_form["marca"]) ? "" : $siniestro_form["marca"] ?>" class="form-control form-control-sm siniestro-f" placeholder="Marca" id="marca" name="marca" data-toggle="tooltip" data-placement="top" title="Marca">
                                                            </div>
                                                        </div>
                                                        <div class="col-sm-12 col-md-3">
                                                            <div class="form-group">
                                                                <label>Modelo</label>
                                                                <input type="text" value="<?= !isset($siniestro_form["modelo"]) ? "" : $siniestro_form["modelo"] ?>" class="form-control form-control-sm siniestro-f" placeholder="Modelo" id="modelo" name="modelo" data-toggle="tooltip" data-placement="top" title="Modelo">
                                                            </div>
                                                        </div>
                                                        <div class="col-sm-12 col-md-3">
                                                            <div class="form-group">
                                                                <label>Versión</label>
                                                                <input type="text" value="<?= !isset($siniestro_form["version"]) ? "" : $siniestro_form["version"] ?>" class="form-control form-control-sm siniestro-f" placeholder="Versión" id="version" name="version" data-toggle="tooltip" data-placement="top" title="Versión">
                                                            </div>
                                                        </div>
                                                        <div class="col-sm-12 col-md-3">
                                                            <div class="form-group">
                                                                <label>Año</label>
                                                                <input type="text" value="<?= !isset($siniestro_form["ano"]) ? "" : $siniestro_form["ano"] ?>" class="form-control form-control-sm siniestro-f numeric" placeholder="Año" id="ano" name="ano" data-toggle="tooltip" data-placement="top" title="Año">
                                                            </div>
                                                        </div>
                                                        <div class="col-sm-12 col-md-3">
                                                            <div class="form-group">
                                                                <label>Serie</label>
                                                                <input type="text" value="<?= !isset($siniestro_form["serie"]) ? "" : $siniestro_form["serie"] ?>" class="form-control form-control-sm siniestro-f" placeholder="Serie" id="serie" name="serie" data-toggle="tooltip" data-placement="top" title="Serie">
                                                            </div>
                                                        </div>
                                                        <div class="col-sm-12 col-md-3">
                                                            <div class="form-group">
                                                                <label>Uso</label>
                                                                <input type="text" value="<?= !isset($siniestro_form["uso"]) ? "" : $siniestro_form["uso"] ?>" class="form-control form-control-sm siniestro-f" placeholder="Uso" id="uso" name="uso" data-toggle="tooltip" data-placement="top" title="Uso">
                                                            </div>
                                                        </div>
                                                        <div class="col-sm-12 col-md-3">
                                                            <div class="form-group">
                                                                <label>Tipo siniestro</label>
                                                                <select class="form-control form-control-sm siniestro-f" id="tipo_siniestro_id" name="tipo_siniestro_id" value="<?= $siniestro_form["tipo_siniestro_id"] ?>" data-toggle="tooltip" data-placement="top" title="Tipo siniestro">
                                                                    <option value="">Seleccione el Tipo Siniestro</option>
                                                                    <?php foreach ($tipos as $value) : ?>
                                                                        <option value="<?= $value['id'] ?>" <?= $siniestro_form["tipo_siniestro_id"] == $value['id'] ? 'selected' : '' ?>><?= $value['nombre'] ?></option>
                                                                    <?php endforeach; ?>
                                                                </select>
                                                                <!-- <input type="text"  class="form-control form-control-sm siniestro-f" placeholder="Tipo siniestro" id="tipo_siniestro_id" name="tipo_siniestro_id"> -->
                                                            </div>
                                                        </div>
                                                        <div class="col-sm-12 col-md-4">
                                                            <div class="form-group">
                                                                <label>Causa siniestro</label>
                                                                <!--  <input type="text"  class="form-control form-control-sm siniestro-f" placeholder="Causa siniestro" id="causa_siniestro_id" name="causa_siniestro_id"> -->
                                                                <select class="form-control form-control-sm siniestro-f" id="causa_siniestro_id" name="causa_siniestro_id" value="<?= !isset($siniestro_form["causa_siniestro_id"]) ? "" : $siniestro_form["causa_siniestro_id"] ?>" data-toggle="tooltip" data-placement="top" title="Causa siniestro">
                                                                    <option value="">Seleccione la cuasa</option>
                                                                </select>
                                                            </div>
                                                        </div>
                                                        <div class="col-sm-12 col-md-4">
                                                            <div class="form-group">
                                                                <label>Responsabilidad</label>
                                                                <!-- <input type="text" value="<?= !isset($siniestro_form["responsabilidad"]) ? "" : $siniestro_form["responsabilidad"] ?>" class="form-control form-control-sm siniestro-f" placeholder="Responsabilidad" id="responsabilidad" name="responsabilidad" data-toggle="tooltip" data-placement="top" title="Responsabilidad"> -->
                                                                <select class="form-control form-control-sm siniestro-f" value="<?= !isset($siniestro_form["responsabilidad"]) ? "" : $siniestro_form["responsabilidad"] ?>" id="responsabilidad" name="responsabilidad" data-toggle="tooltip" data-placement="top" title="Responsabilidad">
                                                                    <option value="">Seleccione la Responsabilidad</option>
                                                                    <?php $value = !isset($siniestro_form["responsabilidad"]) ? "" : $siniestro_form["responsabilidad"] ?>
                                                                    <option value="SI" <?= $value == "SI" ? "selected" : "" ?>>SI</option>
                                                                    <option value="NO" <?= $value == "NO" ? "selected" : "" ?>>NO</option>
                                                                </select>
                                                            </div>
                                                        </div>
                                                        <div class="col-sm-12 col-md-4">
                                                            <div class="form-group">
                                                                <label>Recuperación</label>
                                                                <!-- <input type="text" value="<?= !isset($siniestro_form["recuperacion"]) ? "" : $siniestro_form["recuperacion"] ?>" class="form-control form-control-sm siniestro-f" placeholder="Recuperación" id="recuperacion" name="recuperacion" data-toggle="tooltip" data-placement="top" title="Recuperación"> -->
                                                                <select class="form-control form-control-sm siniestro-f" value="<?= !isset($siniestro_form["recuperacion"]) ? "" : $siniestro_form["recuperacion"] ?>" id="recuperacion" name="recuperacion" data-toggle="tooltip" data-placement="top" title="Recuperación">
                                                                    <option value="">Seleccione la Recuperación</option>
                                                                    <?php $value = !isset($siniestro_form["recuperacion"]) ? "" : $siniestro_form["recuperacion"] ?>
                                                                    <option value="SI" <?= $value == "SI" ? "selected" : "" ?>>SI</option>
                                                                    <option value="NO" <?= $value == "NO" ? "selected" : "" ?>>NO</option>
                                                                </select>
                                                            </div>
                                                        </div>
                                                        <div class="col-12 mb-2 mb-sm-0">
                                                            <nav aria-label="breadcrumb">
                                                                <ol class="breadcrumb breadcrumb-no-gutter">
                                                                    <li class="breadcrumb-item active" aria-current="page">Segumiento general</li>
                                                                </ol>
                                                            </nav>
                                                        </div>
                                                        <div class="col-sm-12 col-md-4">
                                                            <div class="form-group">
                                                                <label>Segumiento</label>
                                                                <select class="form-control form-control-sm siniestro-f" value="<?= !isset($siniestro_form["seguimiento_id"]) ? "" : $siniestro_form["seguimiento_id"] ?>" id="seguimiento_id" name="seguimiento_id" data-toggle="tooltip" data-placement="top" title="Seguimiento">
                                                                    <option value="">Seleccione uno</option>
                                                                    <?php foreach ($SeguimientoE as $value) :
                                                                        $est = isset($siniestro_form["seguimiento_id"]) ? $siniestro_form["seguimiento_id"] : '';
                                                                    ?>
                                                                        <option value="<?= $value['id'] ?>" <?= $value['id'] == $est ? 'selected' : '' ?>><?= $value['opcion'] ?></option>
                                                                    <?php endforeach; ?>
                                                                </select>
                                                            </div>
                                                        </div>
                                                        <div class="col-sm-12 col-md-4">
                                                            <div class="form-group">
                                                                <label>Etapa</label>
                                                                <select class="form-control form-control-sm siniestro-f" value="<?= !isset($siniestro_form["etapa_id"]) ? "" : $siniestro_form["etapa_id"] ?>" id="etapa_id" name="etapa_id" data-toggle="tooltip" data-placement="top" title="Etapa">
                                                                    <option value="">Seleccione uno</option>
                                                                    <?php foreach ($s_etapas as $value) :
                                                                        $est = isset($siniestro_form["etapa_id"]) ? $siniestro_form["etapa_id"] : '';
                                                                        $estPadre = isset($siniestro_form["seguimiento_id"]) ? $siniestro_form["seguimiento_id"] : '';
                                                                    ?>
                                                                        <?php if ($value["id_seguimiento"] == $estPadre && $value["id_seguimiento"] != "") : ?>
                                                                            <option value="<?= $value['id'] ?>" <?= $value['id'] == $est ? 'selected' : '' ?>><?= $value['nombre'] ?></option>
                                                                        <?php endif ?>
                                                                    <?php endforeach; ?>
                                                                </select>
                                                            </div>
                                                        </div>
                                                        <div class="col-sm-12 col-md-4">
                                                            <div class="form-group">
                                                                <label>Estatus trámite</label>
                                                                <select class="form-control form-control-sm siniestro-f" value="<?= !isset($siniestro_form["estatus_s_id"]) ? "" : $siniestro_form["estatus_s_id"] ?>" id="estatus_s_id" name="estatus_s_id" data-toggle="tooltip" data-placement="top" title="Estatus trámite">
                                                                    <option value="">Seleccione uno</option>
                                                                    <?php foreach ($estatust as $value) :
                                                                        $est = isset($siniestro_form["estatus_s_id"]) ? $siniestro_form["estatus_s_id"] : '';
                                                                        $estPadre = isset($siniestro_form["etapa_id"]) ? $siniestro_form["etapa_id"] : '';
                                                                    ?>
                                                                        <?php if ($value["id_etapa"] == $estPadre && $value["id_etapa"] != "") : ?>
                                                                            <option value="<?= $value['id'] ?>" <?= $value['id'] == $est ? 'selected' : '' ?>><?= $value['nombre'] ?></option>
                                                                        <?php endif ?>

                                                                    <?php endforeach; ?>
                                                                </select>
                                                                <input type="hidden" id="copia_id_tramite" value="<?= isset($siniestro_form["estatus_s_id"]) ? $siniestro_form["estatus_s_id"] : '' ?>">
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-md-6">
                                                    <div class="row">
                                                        <div class="col-md-6">
                                                            <div class="row">
                                                                <div class="col-12 mb-2 mb-sm-0">
                                                                    <nav aria-label="breadcrumb">
                                                                        <ol class="breadcrumb breadcrumb-no-gutter">
                                                                            <li class="breadcrumb-item active" aria-current="page">Reservas</li>
                                                                        </ol>
                                                                    </nav>
                                                                </div>
                                                            </div>
                                                            <div class="row">
                                                                <div class="col-12">
                                                                    <div class="form-group">
                                                                        <label>Daño Mat</label>
                                                                        <div class="input-group">
                                                                            <div class="input-group-prepend">
                                                                                <span class="input-group-text">
                                                                                    <i class="fa fa-dollar"></i>
                                                                                </span>
                                                                            </div>
                                                                            <input type="text" value="<?= !isset($siniestro_reserva["dano_material"]) ? "" : "$" . number_format($siniestro_reserva["dano_material"], 2, ".", ",")  ?>" class="form-control form-control-sm siniestro-r numeric moneyFormat" placeholder="Daño material" id="dano_material" name="dano_material" data-toggle="tooltip" data-placement="top" title="Daño material">
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                                <div class="col-12">
                                                                    <div class="form-group">
                                                                        <label>Robo</label>
                                                                        <div class="input-group">
                                                                            <div class="input-group-prepend">
                                                                                <span class="input-group-text">
                                                                                    <i class="fa fa-dollar"></i>
                                                                                </span>
                                                                            </div>
                                                                            <input type="text" value="<?= !isset($siniestro_reserva["robo"]) ? "" :  "$" . number_format($siniestro_reserva["robo"], 2, ".", ",")  ?>" class="form-control form-control-sm siniestro-r numeric moneyFormat" placeholder="Robo" id="robo" name="robo" data-toggle="tooltip" data-placement="top" title="Robo">
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                                <div class="col-12">
                                                                    <div class="form-group">
                                                                        <label>Resp. civil</label>
                                                                        <div class="input-group">
                                                                            <div class="input-group-prepend">
                                                                                <span class="input-group-text">
                                                                                    <i class="fa fa-dollar"></i>
                                                                                </span>
                                                                            </div>
                                                                            <input type="text" value="<?= !isset($siniestro_reserva["resp_civil"]) ? "" : "$" . number_format($siniestro_reserva["resp_civil"], 2, ".", ",")  ?>" class="form-control form-control-sm siniestro-r numeric moneyFormat" placeholder="Resp. civil" id="resp_civil" name="resp_civil" data-toggle="tooltip" data-placement="top" title="Resp. civil">
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                                <div class="col-12">
                                                                    <div class="form-group">
                                                                        <label>Gtos. Med.</label>
                                                                        <div class="input-group">
                                                                            <div class="input-group-prepend">
                                                                                <span class="input-group-text">
                                                                                    <i class="fa fa-dollar"></i>
                                                                                </span>
                                                                            </div>
                                                                            <input type="text" value="<?= !isset($siniestro_reserva["gastos_medicos"]) ? "" : "$" . number_format($siniestro_reserva["gastos_medicos"], 2, ".", ",")  ?>" class="form-control form-control-sm siniestro-r numeric moneyFormat" placeholder="Gtos. Med" id="gastos_medicos" name="gastos_medicos" data-toggle="tooltip" data-placement="top" title="Gtos. Med">
                                                                        </div>
                                                                    </div>
                                                                </div>

                                                            </div>
                                                        </div>
                                                        <div class="col-md-6">
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
                                                                            <label>Fecha reporte</label>
                                                                            <input type="date" value="<?= !isset($siniestro_form["fecha_reporte"]) ? "" : ($siniestro_form["fecha_reporte"] != "" ? date('Y-m-d', strtotime($siniestro_form["fecha_reporte"])) : "") ?>" class="form-control form-control-sm siniestro-f" id="fecha_reporte" name="fecha_reporte" data-toggle="tooltip" data-placement="top" title="Fecha reporte">
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                                <div class="col-12">
                                                                    <div class="form-group">
                                                                        <div class="custom-date-2 no-show">
                                                                            <label>Fecha siniestro</label>
                                                                            <input type="date" value="<?= !isset($siniestro_form["fecha_siniestro"]) ? "" : ($siniestro_form["fecha_siniestro"] != "" ? date('Y-m-d', strtotime($siniestro_form["fecha_siniestro"])) : "") ?>" class="form-control form-control-sm siniestro-f" id="fecha_siniestro" name="fecha_siniestro" data-toggle="tooltip" data-placement="top" title="Fecha sininestro">
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                                <div class="col-12">
                                                                    <div class="form-group">
                                                                        <div class="custom-date-2 no-show">
                                                                            <label>Fecha traslado</label>
                                                                            <input type="date" value="<?= !isset($siniestro_form["fecha_traslado"]) ? "" : ($siniestro_form["fecha_traslado"] != "" ? date('Y-m-d', strtotime($siniestro_form["fecha_traslado"])) : "") ?>" class="form-control form-control-sm siniestro-f" id="fecha_traslado" name="fecha_traslado" data-toggle="tooltip" data-placement="top" title="Fecha traslado">
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                                <!-- <div class="col-12">
                                                                    <div class="form-group">
                                                                        <div class="custom-date-2 no-show">
                                                                            <label>Fecha de valuación</label>
                                                                            <input type="date" value="<?= !isset($siniestro_form["fecha_valuacion"]) ? "" : ($siniestro_form["fecha_valuacion"] != "" ? date('Y-m-d', strtotime($siniestro_form["fecha_valuacion"])) : "") ?>" class="form-control form-control-sm siniestro-f" id="fecha_valuacion" name="fecha_valuacion" data-toggle="tooltip" data-placement="top" title="Fecha valuacion">
                                                                        </div>
                                                                    </div>
                                                                </div> -->
                                                                <div class="col-12">
                                                                    <div class="form-group">
                                                                        <div class="custom-date-2 no-show">
                                                                            <label>Fecha de Terminacion</label>
                                                                            <input type="date" value="<?= !isset($siniestro_form["fecha_terminacion"]) ? "" : ($siniestro_form["fecha_terminacion"] != "" ? date('Y-m-d', strtotime($siniestro_form["fecha_terminacion"])) : "") ?>" class="form-control form-control-sm siniestro-f" id="fecha_terminacion" name="fecha_terminacion" data-toggle="tooltip" data-placement="top" title="Fecha terminacion">
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="col-12">
                                                            <ul class="nav mb-3" id="pills-tab" role="tablist">
                                                                <li class="nav-item">
                                                                    <a class="nav-link active" id="pills-home-tab" data-toggle="pill" href="#pills-home" role="tab" aria-controls="pills-home" aria-selected="true">Registro de valores</a>
                                                                </li>
                                                                <li class="nav-item">
                                                                    <a class="nav-link" id="pills-profile-tab" data-toggle="pill" href="#pills-profile" role="tab" aria-controls="pills-profile" aria-selected="false">Estatus deducible</a>
                                                                </li>
                                                            </ul>
                                                            <div class="tab-content" id="pills-tabContent">
                                                                <div class="tab-pane fade active show in" id="pills-home" role="tabpanel" aria-labelledby="pills-home-tab">
                                                                    <div class="row">
                                                                        <div class="col-sm-12 col-md-8">
                                                                            <div class="row">
                                                                                <div class="col-12">
                                                                                    <div class="form-group">
                                                                                        <label>Suma asegurada</label>
                                                                                        <div class="input-group">
                                                                                            <div class="input-group-prepend">
                                                                                                <span class="input-group-text">
                                                                                                    <i class="fa fa-dollar"></i>
                                                                                                </span>
                                                                                            </div>
                                                                                            <input type="text" value="<?= !isset($siniestro_reserva["suma_asegurada"]) ? "" : "$" . number_format($siniestro_reserva["suma_asegurada"], 2, ".", ",")  ?>" class="form-control form-control-sm siniestro-r numeric moneyFormat porcentajeD" placeholder="Suma asegurada" id="suma_asegurada" name="suma_asegurada" data-toggle="tooltip" data-placement="top" title="Suma asegurada">
                                                                                        </div>
                                                                                    </div>
                                                                                </div>
                                                                                <div class="col-12">
                                                                                    <div class="form-group">
                                                                                        <label>Reclamado</label>
                                                                                        <div class="input-group">
                                                                                            <div class="input-group-prepend">
                                                                                                <span class="input-group-text">
                                                                                                    <i class="fa fa-dollar"></i>
                                                                                                </span>
                                                                                            </div>
                                                                                            <input type="text" value="<?= !isset($siniestro_reserva["reclamo"]) ? "" : "$" . number_format($siniestro_reserva["reclamo"], 2, ".", ",")  ?>" class="form-control form-control-sm siniestro-r numeric moneyFormat" placeholder="Reclamado" id="reclamo" name="reclamo" data-toggle="tooltip" data-placement="top" title="Reclamado">
                                                                                        </div>
                                                                                    </div>
                                                                                </div>
                                                                                <div class="col-12">
                                                                                    <div class="form-group">
                                                                                        <label>Deducible</label>
                                                                                        <div class="input-group">
                                                                                            <div class="input-group-prepend">
                                                                                                <span class="input-group-text">
                                                                                                    <i class="fa fa-dollar"></i>
                                                                                                </span>
                                                                                            </div>
                                                                                            <input type="text" value="<?= !isset($siniestro_reserva["deducible"]) ? "" : "$" . number_format($siniestro_reserva["deducible"], 2, ".", ",") ?>" class="form-control form-control-sm siniestro-r numeric moneyFormat" placeholder="Deducible" id="deducible" name="deducible" data-toggle="tooltip" data-placement="top" title="Deducible">
                                                                                        </div>
                                                                                    </div>
                                                                                </div>
                                                                                <div class="col-12">
                                                                                    <div class="form-group">
                                                                                        <label>Prima pendiente</label>
                                                                                        <div class="input-group">
                                                                                            <div class="input-group-prepend">
                                                                                                <span class="input-group-text">
                                                                                                    <i class="fa fa-dollar"></i>
                                                                                                </span>
                                                                                            </div>
                                                                                            <input type="text" value="<?= !isset($siniestro_reserva["prima_pendiente"]) ? "" : "$" . number_format($siniestro_reserva["prima_pendiente"], 2, ".", ",")  ?>" class="form-control form-control-sm siniestro-r numeric moneyFormat" placeholder="Prima pendiente" id="prima_pendiente" name="prima_pendiente" data-toggle="tooltip" data-placement="top" title="Prima pendiente">
                                                                                        </div>
                                                                                    </div>
                                                                                </div>
                                                                                <div class="col-12">
                                                                                    <div class="form-group">
                                                                                        <label>Pagado</label>
                                                                                        <div class="input-group">
                                                                                            <div class="input-group-prepend">
                                                                                                <span class="input-group-text">
                                                                                                    <i class="fa fa-dollar"></i>
                                                                                                </span>
                                                                                            </div>
                                                                                            <input type="text" value="<?= !isset($siniestro_reserva["pagado"]) ? "" : "$" . number_format($siniestro_reserva["pagado"], 2, ".", ",")  ?>" class="form-control form-control-sm siniestro-r numeric moneyFormat" placeholder="Pagado" id="pagado" name="pagado" data-toggle="tooltip" data-placement="top" title="Pagado">
                                                                                        </div>
                                                                                    </div>
                                                                                </div>
                                                                            </div>
                                                                        </div>
                                                                        <div class="col-sm-12 col-md-4">
                                                                            <div class="row">
                                                                                <div class="col-12">
                                                                                    <div class="form-group">
                                                                                        <div class="form-check">
                                                                                            <input class="form-check-input check-r" type="checkbox" id="factura" name="factura" <?= !isset($siniestro_reserva["factura"]) ? "" : ($siniestro_reserva["factura"] != "0" && $siniestro_reserva["factura"] != "" ? "checked" : "") ?> data-toggle="tooltip" data-placement="top" title="Factura">
                                                                                            <label class="form-check-label" for="invalidCheck2">
                                                                                                Factura
                                                                                            </label>
                                                                                        </div>
                                                                                    </div>
                                                                                </div>
                                                                                <div class="col-12">
                                                                                    <div class="form-group">
                                                                                        <div class="form-check">
                                                                                            <input class="form-check-input check-r" type="checkbox" id="venta_comercial" name="venta_comercial" <?= !isset($siniestro_reserva["venta_comercial"]) ? "" : ($siniestro_reserva["venta_comercial"] != "0" && $siniestro_reserva["venta_comercial"] != "" ? "checked" : "") ?> data-toggle="tooltip" data-placement="top" title="V. Comercial">
                                                                                            <label class="form-check-label" for="invalidCheck2">
                                                                                                V. Comercial
                                                                                            </label>
                                                                                        </div>
                                                                                    </div>
                                                                                </div>
                                                                            </div>
                                                                        </div>
                                                                    </div>

                                                                </div>
                                                                <div class="tab-pane fade" id="pills-profile" role="tabpanel" aria-labelledby="pills-profile-tab">
                                                                    <div class="row">
                                                                        <div class="col-12">
                                                                            <div class="row">
                                                                                <div class="col-12">
                                                                                    <div class="form-group">
                                                                                        <label>Deducible administrativo</label>
                                                                                        <input type="text" value="<?= !isset($siniestro_deducible["deducible_administrativo"]) ? "" : "$" . number_format($siniestro_deducible["deducible_administrativo"], 2, ".", ",")  ?>" class="form-control form-control-sm siniestro-d numeric moneyFormat" placeholder="Deducible administrativo" id="deducible_administrativo" name="deducible_administrativo" data-toggle="tooltip" data-placement="top" title="Deducible administrativo">
                                                                                    </div>
                                                                                </div>
                                                                                <div class="col-12 mb-3">
                                                                                    <div class="form-group">
                                                                                        <div class="custom-date no-show">
                                                                                            <label>Fecha solicitud</label>
                                                                                            <input type="date" value="<?= !isset($siniestro_deducible["fecha_solicitud"]) ? "" : ($siniestro_deducible["fecha_solicitud"] != "" ? date('Y-m-d', strtotime($siniestro_deducible["fecha_solicitud"])) : "") ?>" class="form-control form-control-sm siniestro-d" id="fecha_solicitud" name="fecha_solicitud" data-toggle="tooltip" data-placement="top" title="Fecha solicitud">
                                                                                        </div>
                                                                                    </div>
                                                                                </div>
                                                                                <div class="col-12">
                                                                                    <div class="form-group">
                                                                                        <label>Demérito</label>
                                                                                        <div class="input-group">
                                                                                            <div class="input-group-prepend">
                                                                                                <span class="input-group-text">
                                                                                                    <i class="fa fa-dollar"></i>
                                                                                                </span>
                                                                                            </div>
                                                                                            <input type="text" value="<?= !isset($siniestro_deducible["demerito"]) ? "" : "$" . number_format($siniestro_deducible["demerito"], 2, ".", ",")  ?>" class="form-control form-control-sm siniestro-d numeric moneyFormat" placeholder="Demérito" id="demerito" name="demerito" data-toggle="tooltip" data-placement="top" title="Demérito">
                                                                                        </div>
                                                                                    </div>
                                                                                </div>
                                                                                <div class="col-12">
                                                                                    <div class="form-group">
                                                                                        <label>Concepto demérito</label>
                                                                                        <input type="text" value="<?= !isset($siniestro_deducible["concepto_demerito"]) ? "" : $siniestro_deducible["concepto_demerito"] ?>" class="form-control form-control-sm siniestro-d" placeholder="Concepto demérito" id="concepto_demerito" name="concepto_demerito" data-toggle="tooltip" data-placement="top" title="Concepto demérito">
                                                                                    </div>
                                                                                </div>
                                                                                <div class="col-12">
                                                                                    <div class="form-group">
                                                                                        <div class="custom-date no-show">
                                                                                            <label>Fecha de pago</label>
                                                                                            <input type="date" value="<?= !isset($siniestro_deducible["fecha_pago_deducible"]) ? "" : ($siniestro_deducible["fecha_pago_deducible"] != "" ? date('Y-m-d', strtotime($siniestro_deducible["fecha_pago_deducible"])) : "") ?>" class="form-control form-control-sm siniestro-d" id="fecha_pago_deducible" name="fecha_pago_deducible" data-toggle="tooltip" data-placement="top" title="Fecha de pago">
                                                                                        </div>
                                                                                    </div>
                                                                                </div>
                                                                                <div class="col-12">
                                                                                    <div class="form-group">
                                                                                        <div class="custom-date no-show">
                                                                                            <label>Estatus deducible</label>
                                                                                            <select class="form-control form-control-sm siniestro-d" value="<?= !isset($siniestro_deducible["estatus_deducible"]) ? "" : $siniestro_deducible["estatus_deducible"] ?>" id="estatus_deducible" name="estatus_deducible" data-toggle="tooltip" data-placement="top" title="Estatus deducible">
                                                                                                <option value="">Seleccione una opción</option>
                                                                                                <?php $value = isset($siniestro_deducible["estatus_deducible"]) ? $siniestro_deducible["estatus_deducible"] : "" ?>
                                                                                                <option value="PENDIENTE" <?= $value == "PENDIENTE" ? "selected" : "" ?>>PENDIENTE</option>
                                                                                                <option value="EFECTUADO" <?= $value == "EFECTUADO" ? "selected" : "" ?>>EFECTUADO</option>
                                                                                                <option value="CANCELADO" <?= $value == "CANCELADO" ? "selected" : "" ?>>CANCELADO</option>
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
                                                    </div>
                                                </div>

                                            </div>
                                        </form>
                                    </div>
                                    <?php if ($siniestro_form["tipo_siniestro_id"] != 0) : ?>
                                        <?php if ($template == "TIPO1") : ?>
                                            <?php $this->load->view("siniestroCorporativo/reparacionT1"); ?>
                                        <?php elseif ($template == "TIPO2") : ?>
                                            <?php $this->load->view("siniestroCorporativo/reparacionT2"); ?>
                                        <?php else : ?>
                                            <?php $this->load->view("siniestroCorporativo/reparacionT3"); ?>
                                        <?php endif; ?>
                                    <?php endif; ?>

                                </div>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>