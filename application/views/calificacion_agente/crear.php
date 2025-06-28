<div class="panel panel-default" style="margin-bottom: 80px;">
    <div class="panel-body">
        <div class="col-md-12" style="margin-bottom: 20px;">
            <h5 class="titleSection">Crear Preguntas
                <button class="btn-view-cont" data-toggle="collapse" href="#segInfCrear" aria-expanded="true"><i class="fa fa-info-circle" title="Ver Información"></i>
                </button>
            </h5>
            <hr class="title-hr">
            <div class="col-md-12" style="margin-bottom: 10px;">
                <div class="col-md-12 collapse" id="segInfCrear">
                    <div class="alert alert-primary" role="alert" style="margin: 0px;">
                        <h4><i class="fas fa-info-circle"></i> Información</h4>
                        <p>Administra las preguntas y respuestas para la evaluación de los agentes, podrá crear, editar y eliminar. También podrá obtener una vista previa con el botón <b style="text-wrap: nowrap;"><i class="far fa-eye"></i> Ver Evaluación de prueba</b>.</p>
                    </div>
                </div>
            </div>
            <div class="col-md-12 column-grid-start segment-section pd-left pd-right pd-top pd-bottom">
                <div class="col-md-12" style="display: none;">
                    <label class="textForm">ID:</label>
                    <input type="text" class="form-control" name="create-question" data-field="id_valoracion" value="1">
                </div>
                <div class="col-md-12">
                    <label class="textForm">Pregunta (No ponerle numeración):</label>
                    <textarea type="text" class="form-control" name="create-question" title="Pregunta" data-field="pregunta" maxlength="200" style="height: 34px;" onkeyup="update_counter(this,'#crtsQuestion')"></textarea>
                    <label class="control-label">
                        Caracteres usados: <span id="crtsQuestion">0</span> de 200
                    </label>
                </div>
                <div class="col-md-12" id="contQuestion">
                    <div class="col-md-6 pd-left">
                        <label class="textForm">Tipo de respuesta:</label>
                        <select class="form-control" id="selectAnswer" name="create-question" data-field="tipo_pregunta" onchange="input_type_option(this.value,'create')">
                            <option value="1">Sí/No</option>
                            <option value="2">Opcional</option>
                            <option value="3">Selección</option>
                            <option value="4">Estrellas</option>
                            <option value="5">Respuesta Abierta</option>
                        </select>
                    </div>
                    <div class="col-md-6 pd-left pd-right" id="contAnswer"></div>
                </div>
                <div class="col-md-12 pd-items-table-top">
                    <label class="textForm">Ejemplo tipo de respuesta:</label>
                    <div class="column-flex-space-evenly container-example-answer" id="contAnswerExample">
                        <div class="form-check column-flex-center-center">
                            <input type="radio" class="form-check-input" name="example" value="1">
                            <label class="form-check-label">Sí</label>
                        </div>
                        <div class="form-check column-flex-center-center">
                            <input type="radio" class="form-check-input" name="example" value="2">
                            <label class="form-check-label">No</label>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-12 column-flex-center-end pd-items-table-top">
                <button class="btn btn-primary btn-load" id="btnCrearPregunta" title="Crear Pregunta" onclick="create_update_Question(1,'create-question')">
                    <i class="fas fa-save"></i> Guardar</button>
            </div>
            <div class="col-md-12 pd-items-table-top">
                <div class="col-md-6 column-flex-center-start pd-items-table pd-left pd-right">
                    <a class="btn btn-primary" href="<?=base_url()?>calificacionAgente/evaluacion_vista_ejemplo?id=1" target="_blank"><i class="far fa-eye"></i> Ver Evaluación de prueba</a>
                </div>
                <div class="col-md-6 column-flex-center-end pd-items-table pd-left pd-right">
                    <div class="column-flex-center-end pd-left pd-right input-group" style="width: 65%;">
                        <input class="form-control search-input" name="filter-input" placeholder="Filtrar" id="filterTableQuestion" onkeyup="filterSelectedTable(this,'bodyTableQuestion','show-question')">
                        <div class="input-group-append">
                            <button class="btn btn-secondary" title="Limpiar Filtro" onclick="eraserFilterTable('filterTableQuestion')"><i class="fas fa-eraser"></i></button>
                        </div>
                    </div>
                </div>
                <div class="container-table">
                    <table class="table table-striped table-hover" id="TableQuestion">
                        <thead>
                            <tr class="table-tr">
                                <th>N°</th>
                                <th>Pregunta</th>
                                <th>Tipo Respuesta</th>
                                <th>Fecha Creación</th>
                                <th>Fecha Modificación</th>
                                <th>Editar</th>
                                <th>Eliminar</th>
                            </tr>
                        </thead>
                        <tbody id="bodyTableQuestion">
                            <tr>
                                <td colspan="8">
                                    <center>Seleccione la opción <b class="seg-info-btn"><i class="fas fa-sticky-note"></i> Crear</b> de la tabla <i>Encuestas Creadas</i> para ver esta información.</center>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>