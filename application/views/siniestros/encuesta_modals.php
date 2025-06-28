<div class="modal fade response-survey-modal" tabindex="-1" role="dialog" aria-labelledby="xd">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header column-select">
                <h4 class="title-result">Respuestas <span id="titleFolio"></span></h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close" style="margin-top:-10px;font-size:30px;color: lavender; padding:3px;">
                    <i class="fa fa-times-circle" aria-hidden="true"></i>
                </button>
            </div>
            <div class="modal-body brd-radius-modal-body" style="background: #f9f9f9;">
                <div class="col-md-12 column-flex-center-center pd-left pd-right">
                    <div class="pd-side">
                        <label class="textSizeLabel mg-right">Nombre Asegurado:</label>
                        <label class="textForm" id="nameAsegurado"></label>
                    </div>
                </div>
                <div class="container-table">
                    <table class="table table-striped" id="TableResponse">
                        <thead class="table-thead">
                            <tr class="tr-style">
                                <th>N°</th>
                                <th>Pregunta</th>
                                <th>Respuesta del Entrevistado</th>
                            </tr>
                        </thead>
                        <tbody id="bodyTableResponse">
                            <tr><td colspan="3"><center><strong>Sin resultados</strong></center></td></tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="modal fade answers-survey-modal" tabindex="-1" role="dialog" aria-labelledby="xd">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header column-select">
                <h4 class="title-result">Detalles Respuestas</h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close" style="margin-top:-10px;font-size:30px;color: lavender; padding:3px;">
                    <i class="fa fa-times-circle" aria-hidden="true"></i>
                </button>
            </div>
            <div class="modal-body brd-radius-modal-body" style="background: #f9f9f9;">
                <div class="col-md-12 column-flex-center-center pd-left pd-right">
                    <div class="pd-side">
                        <label class="textSizeLabel mg-right" style="font-size: 1.5rem;">Encuesta:</label>
                        <label class="textForm" id="nameSurvey" style="font-size: 1.5rem;"></label>
                    </div>
                </div>
                <div class="col-md-12 column-flex-center-start pd-items-table">
                    <div class="col-md-6 column-flex-center-start pd-left">
                        <div class="pd-side">
                            <form id="exportReportResult" method="get" action="<?=base_url()?>siniestros/getCompleteInformationSurvey">
                                <input type="hidden" class="form-control input-sm export-answers" name="tp" id="tp" value="2">
                                <input type="hidden" class="form-control input-sm export-answers" name="sv" id="sv">
                                <input type="hidden" class="form-control input-sm export-answers" name="mt" id="mt">
                                <input type="hidden" class="form-control input-sm export-answers" name="yr" id="yr">
                                <button class="btn btn-export-report" id="btnExportAnswer" disabled>
                                <i class="fas fa-file-excel"></i> Exportar</button>
                            </form>
                        </div>
                    </div>
                    <div class="col-md-6 column-flex-center-end pd-right">
                        <div class="column-flex-center-end pd-left pd-right input-group" style="width: 65%;">
                            <input class="form-control search-input" placeholder="Filtrar" id="filterTableAnswers"  onkeyup="filterSelectedTable(this,'bodyTableAnswers','show-answers')">
                            <div class="input-group-append">
                                <button class="btn btn-secondary" title="Limpiar Filtro" onclick="eraserFilterTable('filterTableAnswers')"><i class="fas fa-eraser"></i></button>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="container-table" id="contTableAnswers"></div>
            </div>
        </div>
    </div>
</div>

<div class="modal fade edit-survey-modal" tabindex="-1" role="dialog" aria-labelledby="xd">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header column-select">
                <h4 class="title-result">Editar Encuesta</h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close" style="margin-top:-10px;font-size:30px;color: lavender; padding:3px;">
                    <i class="fa fa-times-circle" aria-hidden="true"></i>
                </button>
            </div>
            <div class="modal-body" style="background: #f9f9f9;">
                <h4 class="titleSection" id="titleSurvey"></h4>
                <div class="col-md-12 pd-left pd-right">
                    <div class="col-md-6">
                        <div class="pd-side pd-items-table">
                            <label class="textForm">Título:</label>
                            <input type="text" class="form-control" name="update-survey" data-field="titulo">
                        </div>
                        <div class="pd-side pd-items-table">
                            <label class="textForm">Ramo:</label>
                            <select class="form-control" name="update-survey" data-field="idRamo">
                                <?= print_ramo($ramos); ?>
                            </select>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="pd-side pd-items-table">
                            <label class="textForm">Tipo de respuestas:</label>
                            <select class="form-control" name="update-survey" data-field="tipo">
                                <option value="1">Todas</option>
                                <option value="2">Numérico</option>
                                <option value="3">Verdadero/Falso</option>
                                <option value="4">Sí/No</option>
                                <option value="5">Selección</option>
                                <option value="6">Respuestas abiertas</option>
                            </select>
                        </div>
                        <div class="pd-side">
                            <label class="textForm">Descripción:</label>
                            <textarea class="form-control" name="update-survey" data-field="descripcion" placeholder="Una breve descripción." maxlength="200" style="height: 34px;" onkeyup="update_counter(this,'#crtsUpdateSurvey')"></textarea>
                            <label class="control-label">
                                Caracteres usados: <span id="crtsUpdateSurvey">0</span> de 200
                            </label>
                        </div>
                        <div class="pd-side pd-items-table" style="display: none;">
                            <label class="textForm">ID:</label>
                            <input type="text" class="form-control" name="update-survey" data-field="id">
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button class="btn btn-primary btn-load" id="btnActualizarEncuesta" title="Actualizar Encuesta" onclick="create_update_Survey(2,'update-survey')"><i class="fas fa-save"></i> Guardar</button>
                <button type="button" class="btn btn-default close-list" data-dismiss="modal">
                    Cerrar
                </button>
            </div>
        </div>
    </div>
</div>

<div class="modal fade edit-question-modal" tabindex="-1" role="dialog" aria-labelledby="xd">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header column-select">
                <h4 class="title-result">Editar Pregunta</h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close" style="margin-top:-10px;font-size:30px;color: lavender; padding:3px;">
                    <i class="fa fa-times-circle" aria-hidden="true"></i>
                </button>
            </div>
            <div class="modal-body" style="background: #f9f9f9;">
                <!-- <h4 class="titleSection" id="titleSurvey"></h4> -->
                <div class="col-md-12 pd-left pd-right">
                    <div class="col-md-12" style="display: none;">
                        <label class="textForm">IDEncuesta:</label>
                        <input type="text" class="form-control" name="update-question" data-field="idEncuesta">
                    </div>
                    <div class="col-md-12">
                        <label class="textForm">Pregunta:</label>
                        <textarea type="text" class="form-control" name="update-question" title="Pregunta" data-field="pregunta" maxlength="200" style="height: 34px;" onkeyup="update_counter(this,'#crtsUpdateQuestion')"></textarea>
                        <label class="control-label">
                            Caracteres usados: <span id="crtsUpdateQuestion">0</span> de 200
                        </label>
                    </div>
                    <div class="col-md-12 pd-items-table-top">
                        <div class="col-md-6 pd-left">
                            <label class="textForm">Tipo de respuesta:</label>
                            <select class="form-control" name="update-question" data-field="tipo" onchange="input_type_option(this.value,'update')" disabled>
                                <option value="1">Opcional (Crear opciones)</option>
                                <option value="2">Numérico (1...10)</option>
                                <option value="3">Verdadero/Falso</option>
                                <option value="4">Sí/No</option>
                                <option value="5">Selección</option>
                                <option value="6">Respuesta Abierta</option>
                            </select>
                        </div>
                        <div class="col-md-6 pd-right" id="contUpdateAnswer"></div>
                    </div>
                    <div class="col-md-12 pd-items-table-top" id="contOption"></div>
                    <div class="col-md-12">
                        <div class="pd-side pd-items-table" style="display: none;">
                            <label class="textForm">ID:</label>
                            <input type="text" class="form-control" name="update-question" data-field="id">
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button class="btn btn-primary btn-load" id="btnActualizarEncuesta" title="Actualizar Encuesta" onclick="create_update_Question(2,'update-question')"><i class="fas fa-save"></i> Guardar</button>
                <button type="button" class="btn btn-default close-list" data-dismiss="modal">
                    Cerrar
                </button>
            </div>
        </div>
    </div>
</div>