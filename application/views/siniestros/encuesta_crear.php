<div class="panel panel-default" style="margin-bottom: 80px;">
    <div class="panel-body">
    	<div class="col-md-12" style="margin-bottom: 20px;">
            <h5 class="titleSection">Encuesta Nueva</h5>
            <hr class="title-hr">
            <div class="col-md-12 column-flex-start segment-section pd-left pd-right pd-top pd-bottom">
            	<div class="col-md-6">
            		<div class="pd-side pd-items-table">
            			<label class="textForm">Título:</label>
            			<input type="text" class="form-control" name="create-survey" title="Título" data-field="titulo">
            		</div>
            		<div class="pd-side pd-items-table">
            			<label class="textForm">Ramo:</label>
            			<select class="form-control" name="create-survey" title="Ramo" data-field="idRamo">
            				<?= print_ramo($ramos); ?>
            			</select>
            		</div>
            		<div class="pd-side">
            			<label class="textForm">Creado por:</label>
            			<input type="text" class="form-control" value="<?=$email?>" disabled>
            		</div>
            	</div>
            	<div class="col-md-6">
            		<div class="pd-side pd-items-table">
            			<label class="textForm">Tipo de respuestas:</label>
            			<select class="form-control" name="create-survey" title="Tipo de respuestas" data-field="tipo">
            				<option value="1">Todas</option>
            				<option value="2">Numérico (1...10)</option>
            				<option value="3">Verdadero/Falso</option>
            				<option value="4">Sí/No</option>
            				<option value="5">Selección</option>
            				<option value="6">Respuestas abiertas</option>
            			</select>
            		</div>
            		<div class="pd-side pd-items-table">
            			<label class="textForm">Fecha Creación:</label>
            			<input type="date" class="form-control" value="<?=date('Y-m-d')?>" disabled>
            		</div>
            		<div class="pd-side">
            			<label class="textForm">Descripción (Opcional):</label>
            			<textarea class="form-control" name="create-survey" title="Descripción" data-field="descripcion" placeholder="Una breve descripción." maxlength="200" style="height: 34px;" onkeyup="update_counter(this,'#caracteres')"></textarea>
            			<label class="control-label">
                            Caracteres usados: <span id="caracteres">0</span> de 200
                        </label>
            		</div>
            	</div>
            </div>
            <div class="col-md-12 column-flex-center-end pd-items-table-top">
            	<button class="btn btn-primary btn-load" id="btnCrearEncuesta" title="Crear Encuesta" onclick="create_update_Survey(1,'create-survey')">
            		<i class="fas fa-save"></i> Guardar</button>
            </div>
        </div>
        <div class="col-md-12" style="margin-bottom: 20px;">
            <h5 class="titleSection">Encuestas Creadas</h5>
            <hr class="title-hr">
            <div class="col-md-12">
            	<div class="col-md-12 column-flex-center-end pd-items-table pd-left pd-right">
            		<div class="column-flex-center-end pd-left pd-right input-group" style="width: 35%;">
                  			<input class="form-control search-input" name="filter-input" placeholder="Filtrar" id="filterTableSurvey" onkeyup="filterSelectedTable(this,'bodyTableSurvey','show-survey')">
                    	<div class="input-group-append">
                      		<button class="btn btn-secondary" title="Limpiar Filtro" onclick="eraserFilterTable('filterTableSurvey')"><i class="fas fa-eraser"></i></button>
                  		</div>
                 	</div>
            	</div>
            	<div class="container-table">
            		<table class="table table-striped table-hover" id="TableSurvey">
            			<thead>
            				<tr class="table-tr">
            					<th>Id Encuesta</th>
            					<th>Título</th>
            					<th>Ramo</th>
            					<th>Tipo Respuesta</th>
            					<th>Decripción</th>
            					<th>Fecha Creación</th>
            					<th colspan="2">Activo</th>
            					<th>Vista Previa</th>
            					<th>Preguntas</th>
            					<th>Editar</th>
            				</tr>
            			</thead>
            			<tbody id="bodyTableSurvey"></tbody>
            		</table>
            	</div>
            </div>
        </div>
        <div class="col-md-12" id="Crear" style="margin-bottom: 20px;">
            <h5 class="titleSection">Crear Preguntas</h5>
            <hr class="title-hr">
            <div class="col-md-12 pd-items-table">
          		<label class="subTitleSection">
          			Encuesta seleccionada (Título): <strong id="SelectedSurvey">Ninguna</strong>
          		</label>
        	</div>
            <div class="col-md-12 column-grid-start segment-section pd-left pd-right pd-top pd-bottom">
                <div class="col-md-12" style="display: none;">
                    <label class="textForm">ID:</label>
                    <input type="text" class="form-control" name="create-question" data-field="idEncuesta">
                </div>
            	<div class="col-md-12">
            		<label class="textForm">Pregunta (No es necesario ponerle numeración):</label>
            		<textarea type="text" class="form-control" name="create-question" title="Pregunta" data-field="pregunta" maxlength="200" style="height: 34px;" onkeyup="update_counter(this,'#crtsQuestion')"></textarea>
            		<label class="control-label">
                        Caracteres usados: <span id="crtsQuestion">0</span> de 200
                    </label>
            	</div>
            	<div class="col-md-12" id="contQuestion">
            		<div class="col-md-6 pd-left">
            			<label class="textForm">Tipo de respuesta:</label>
            			<select class="form-control" id="selectAnswer" name="create-question" data-field="tipo" onchange="input_type_option(this.value,'create')">
            				<option value="1">Opcional (Crear opciones)</option>
            				<option value="2">Numérico (1...10)</option>
            				<option value="3">Verdadero/Falso</option>
            				<option value="4">Sí/No</option>
            				<!-- <option value="5">Selección</option> -->
            				<option value="6">Respuesta Abierta</option>
            			</select>
            		</div>
            		<div class="col-md-6 pd-right" id="contAnswer"></div>
            	</div>
            	<div class="col-md-12 pd-items-table-top">
            		<label class="textForm">Ejemplo tipo de opciones de la respuesta:</label>
            		<div class="column-flex-space-evenly container-example-answer" id="contAnswerExample"></div>
            	</div>
            </div>
            <div class="col-md-12 column-flex-center-end pd-items-table-top">
            	<button class="btn btn-primary btn-load" id="btnCrearPregunta" title="Crear Pregunta" onclick="create_update_Question(1,'create-question')" disabled>
            		<i class="fas fa-save"></i> Guardar</button>
            </div>
            <div class="col-md-12 pd-items-table-top">
            	<div class="col-md-12 column-flex-center-end pd-items-table pd-left pd-right">
            		<div class="column-flex-center-end pd-left pd-right input-group" style="width: 35%;">
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
            					<th>Respuesta</th>
            					<th>Fecha Creación</th>
                                <th>Fecha Modificación</th>
            					<th>Editar</th>
                                <th>Eliminar</th>
            				</tr>
            			</thead>
            			<tbody id="bodyTableQuestion">
            				<tr>
            					<td colspan="10">
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