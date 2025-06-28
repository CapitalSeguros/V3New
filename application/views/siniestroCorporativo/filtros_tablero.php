<form id="formF" style="width: 100%;">
    <div class="col-sm-3">
        <label>Tipo de reporte </label><br>
        <select id="tipo_r" name="tipo_r" class=" form-control">
            <option value="">Seleccione una opción</option>
            <option value="ESTATUS_T" <?= $tipo_r == "ESTATUS_T" ? 'selected' : '' ?>>ESTATUS T</option>
            <!-- <option value="ACTIVOS" <?= $tipo_r == "ACTIVOS" ? 'selected' : '' ?>>SINIESTROS ACTIVOS</option> -->
            <option value="DEDUCIBLES" <?= $tipo_r == "DEDUCIBLES" ? 'selected' : '' ?>>DEDUCIBLE</option>
            <option value="PENALIZACION" <?= $tipo_r == "PENALIZACION" ? 'selected' : '' ?>>PENALIZACIÓN</option>
            <option value="PERDIDA_TOTAL" <?= $tipo_r == "PERDIDA_TOTAL" ? 'selected' : '' ?>>PERDIDAS TOTALES</option>
            <option value="ROBOS" <?= $tipo_r == "ROBOS" ? 'selected' : '' ?>>REPORTES ROBOS</option>
            <option value="DETENIDOS" <?= $tipo_r == "DETENIDOS" ? 'selected' : '' ?>>REPORTE DETENIDOS</option>
            <option value="VIAL" <?= $tipo_r == "VIAL" ? 'selected' : '' ?>>EXCEDENTE VIAL</option>
        </select>
    </div>
    <?php if ($tipo_r == "DEDUCIBLES") : ?>
        <div class="col-sm-3">
            <label>Estatus Deducible </label><br>
            <select id="estatus_d" name="estatus_d" class="multiselect-ui" multiple>
                <!-- <option>Seleccione una opción</option> -->
                <option>TODOS</option>
                <option>PENDIENTE</option>
                <option>EFECTUADO</option>
                <option>CANCELADO</option>
            </select>
        </div>
        <div class="col-sm-6">
            <label>Rango de fechas </label>
            <div style="display: flex;width: 100%;">
                <label style="margin-top: 8px ; margin-right: 5px;">Desde:</label>
                <input type="date" class="form-control f_filtro" name="f_inicio" id="f_inicio" style="width: 40%;display: block;">
                <label style="margin-top: 8px; margin-right: 5px; margin-left: 5px;">Hasta:</label>
                <input type="date" class="form-control f_filtro" name="f_fin" id="f_fin" style="width: 40%;display: block;">
            </div>
        </div>
        <div class="col-sm-12">
            <label style="padding-top: 5px;">Filtros adiciones </label>
            <div style="width: 100%; display: flex;">
                <div style="width: 32%;display: block; padding-right: 10px;">
                    <div class="control-group" id="fields">
                        <label class="control-label" for="field1">
                            Cliente
                        </label>
                        <div class="controls" id="p_cliente">
                            <div class="entry input-group upload-input-group">
                                <input class="form-control fileL f_cliente" placeholder="Cliente" name="cliente[]" id="cliente" type="text">
                                <div class="input-group-append">
                                    <button class="input-group-text btn btn-sm btn-shadow btn-upload btn-success btn-add" data-parent="p_cliente" type="button">
                                        <i class="fa fa-plus"></i>
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div style="width: 32%;display: block;padding-right: 10px;">
                    <div class="control-group" id="fields">
                        <label class="control-label" for="field1">
                            Poliza
                        </label>
                        <div class="controls" id="p_poliza">
                            <div class="entry input-group upload-input-group">
                                <input class="form-control fileL f_poliza" name="poliza[]" placeholder="Poliza" id="poliza" type="text">
                                <div class="input-group-append">
                                    <button class="input-group-text btn btn-sm btn-shadow btn-upload btn-success btn-add" data-parent="p_poliza" type="button">
                                        <i class="fa fa-plus"></i>
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div style="width: 32%;display: block;padding-right: 10px;">
                    <div class="control-group" id="fields">
                        <label class="control-label" for="field1">
                            Compañia
                        </label>
                        <div class="controls" id="p_compania">
                            <div class="entry input-group upload-input-group">
                                <input class="form-control fileL f_compania" placeholder="Compañia" name="compania[]" id="compania" type="text">
                                <div class="input-group-append">
                                    <button class="input-group-text btn btn-sm btn-shadow btn-upload btn-success btn-add" data-parent="p_compania" type="button">
                                        <i class="fa fa-plus"></i>
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    <?php elseif ($tipo_r == "ESTATUS_T") : ?>
        <div class="col-sm-2">
            <label># Unidades </label><br>
            <input type="text" class="form-control numeric" name="num_unidades" id="num_unidades">
        </div>
        <!-- <div class="col-sm-2">
            <label>Tipo</label><br>
            <label class="checkbox-inline"><input type="radio" name="subtipo" value="CRISTALES">Cristales</label><br>
            <label class="checkbox-inline"><input type="radio" name="subtipo" value="COLISIONES">Colisiones</label>
        </div> -->
        <div class="col-sm-7">
            <label>Rango de fechas </label>
            <div style="display: flex;width: 100%;">
                <label style="margin-top: 8px ; margin-right: 5px;">Desde:</label>
                <input type="date" class="form-control f_filtro" name="f_inicio" id="f_inicio" style="width: 40%;display: block;">
                <label style="margin-top: 8px; margin-right: 5px; margin-left: 5px;">Hasta:</label>
                <input type="date" class="form-control f_filtro" name="f_fin" id="f_fin" style="width: 40%;display: block;">
            </div>
        </div>
        <div class="col-sm-12">
            <label style="padding-top: 5px;">Filtros adiciones </label>
            <div style="width: 100%; display: flex;">
                <div style="width: 32%;display: block; padding-right: 10px;">
                    <div class="control-group" id="fields">
                        <label class="control-label" for="field1">
                            Cliente
                        </label>
                        <div class="controls" id="p_cliente">
                            <div class="entry input-group upload-input-group">
                                <input class="form-control fileL f_cliente" placeholder="Cliente" name="cliente[]" id="cliente" type="text">
                                <div class="input-group-append">
                                    <button class="input-group-text btn btn-sm btn-shadow btn-upload btn-success btn-add" data-parent="p_cliente" type="button">
                                        <i class="fa fa-plus"></i>
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div style="width: 32%;display: block;padding-right: 10px;">
                    <div class="control-group" id="fields">
                        <label class="control-label" for="field1">
                            Poliza
                        </label>
                        <div class="controls" id="p_poliza">
                            <div class="entry input-group upload-input-group">
                                <input class="form-control fileL f_poliza" name="poliza[]" placeholder="Poliza" id="poliza" type="text">
                                <div class="input-group-append">
                                    <button class="input-group-text btn btn-sm btn-shadow btn-upload btn-success btn-add" data-parent="p_poliza" type="button">
                                        <i class="fa fa-plus"></i>
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div style="width: 32%;display: block;padding-right: 10px;">
                    <div class="control-group" id="fields">
                        <label class="control-label" for="field1">
                            Compañia
                        </label>
                        <div class="controls" id="p_compania">
                            <div class="entry input-group upload-input-group">
                                <input class="form-control fileL f_compania" placeholder="Compañia" name="compania[]" id="compania" type="text">
                                <div class="input-group-append">
                                    <button class="input-group-text btn btn-sm btn-shadow btn-upload btn-success btn-add" data-parent="p_compania" type="button">
                                        <i class="fa fa-plus"></i>
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    <?php elseif ($tipo_r != "" && $tipo_r != "DEDUCIBLES" || $tipo_r == "ESTATUS_T") : ?>
        <div class="col-sm-9">
            <label>Rango de fechas </label>
            <div style="display: flex;width: 100%;">
                <label style="margin-top: 8px ; margin-right: 5px;">Desde:</label>
                <input type="date" class="form-control f_filtro" name="f_inicio" id="f_inicio" style="width: 40%;display: block;">
                <label style="margin-top: 8px; margin-right: 5px; margin-left: 5px;">Hasta:</label>
                <input type="date" class="form-control f_filtro" name="f_fin" id="f_fin" style="width: 40%;display: block;">
            </div>
        </div>
        <div class="col-sm-12">
            <label style="padding-top: 5px;">Filtros adiciones </label>
            <div style="width: 100%; display: flex;">
                <div style="width: 32%;display: block; padding-right: 10px;">
                    <div class="control-group" id="fields">
                        <label class="control-label" for="field1">
                            Cliente
                        </label>
                        <div class="controls" id="p_cliente">
                            <div class="entry input-group upload-input-group">
                                <input class="form-control fileL f_cliente" placeholder="Cliente" name="cliente[]" id="cliente" type="text">
                                <div class="input-group-append">
                                    <button class="input-group-text btn btn-sm btn-shadow btn-upload btn-success btn-add" data-parent="p_cliente" type="button">
                                        <i class="fa fa-plus"></i>
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div style="width: 32%;display: block;padding-right: 10px;">
                    <div class="control-group" id="fields">
                        <label class="control-label" for="field1">
                            Poliza
                        </label>
                        <div class="controls" id="p_poliza">
                            <div class="entry input-group upload-input-group">
                                <input class="form-control fileL f_poliza" name="poliza[]" placeholder="Poliza" id="poliza" type="text">
                                <div class="input-group-append">
                                    <button class="input-group-text btn btn-sm btn-shadow btn-upload btn-success btn-add" data-parent="p_poliza" type="button">
                                        <i class="fa fa-plus"></i>
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div style="width: 32%;display: block;padding-right: 10px;">
                    <div class="control-group" id="fields">
                        <label class="control-label" for="field1">
                            Compañia
                        </label>
                        <div class="controls" id="p_compania">
                            <div class="entry input-group upload-input-group">
                                <input class="form-control fileL f_compania" placeholder="Compañia" name="compania[]" id="compania" type="text">
                                <div class="input-group-append">
                                    <button class="input-group-text btn btn-sm btn-shadow btn-upload btn-success btn-add" data-parent="p_compania" type="button">
                                        <i class="fa fa-plus"></i>
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    <?php endif; ?>
</form>