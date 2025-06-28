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
                <div class="col-md-12 pd-left pd-right">
                    <div class="col-md-12" style="display: none;">
                        <label class="textForm">ID:</label>
                        <input type="text" class="form-control" name="update-question" data-field="id_valoracion" value="1">
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
                            <select class="form-control" name="update-question" data-field="tipo" onchange="input_type_option(this.value,'update')">
                                <option value="1">Sí/No</option>
                                <option value="2">Opcional</option>
                                <option value="3">Selección</option>
                                <option value="4">Estrellas</option>
                                <option value="5">Respuesta Abierta</option>
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