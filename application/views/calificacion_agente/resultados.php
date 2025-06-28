<ul class="nav nav-tabs tab_capa" role="tablist">
    <li class="nav-item">
        <a class="nav-link active" data-toggle="tab" id="tab_table" role="tab" aria-selected="true" href="#tabResult">
            <i class="fa fa-check-square-o" aria-hidden="true"></i> Resultados</a>
    </li>
    <li class="nav-item">
        <a class="nav-link" data-toggle="tab" id="tab_statistics" role="tab" aria-selected="true" href="#tabCount">
            <i class="fa fa-check-square-o" aria-hidden="true"></i> Conteo</a>
    </li>
</ul>
<div class="tab-content contenedor_capa" style="margin-bottom: 80px;">
    <!-- Tablas -->
    <div class="tab-pane active" id="tabResult" role="tabpanel" aria-labeledby="tab_table">
        <div class="panel-body" style="padding: 0px;">
            <div class="col-md-12" style="margin-bottom: 25px;">
                <h5 class="titleSection">Evaluaciones Resueltas</h5>
                <hr class="title-hr">
                <div class="col-md-12 column-flex-bottom pd-items-table">
                    <div class="pd-side" style="width: 60%;">
                        <label class="form-check-label">Agente:</label>
                        <select class="form-control selectpicker" id="searchAgent" data-show-subtext="false" data-live-search="true">
                            <option value="todos">TODOS</option>
                            <?=$empleados?>
                            <?=$agentes?>
                        </select>
                    </div>
                    <div class="pd-side">
                        <label class="form-check-label">Mes:</label>
                        <select class="form-control" id="searchMonth">
                            <?=$months?>
                            <option class="todos">TODOS</option>
                        </select>
                    </div>
                    <div class="pd-side">
                        <label class="form-check-label">Año:</label>
                        <select class="form-control" id="searchYear">
                            <?=$years?>
                        </select>
                    </div>
                    <div class="pd-side">
                        <button class="btn btn-primary" id="btnSearch" onclick="getEvaluations()">
                            <i class="fas fa-search"></i> Buscar</button>
                    </div>
                </div>
                <div class="col-md-12 column-flex-center-start pd-items-table">
                    <div class="col-md-6 column-flex-center-start pd-left">
                        <div class="pd-side">
                            <form id="exportReportResult" method="get" action="<?=base_url()?>calificacionAgente/getCompleteInformationEvaluation">
                                <input type="hidden" class="form-control input-sm export-answers" name="tp" id="tp" value="2">
                                <input type="hidden" class="form-control input-sm export-answers" name="em" id="em">
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
                <div class="col-md-12"><div class="container-table" id="contTableAnswers"></div></div>
            </div>
        </div>
    </div>
    <div class="tab-pane" id="tabCount" role="tabpanel" aria-labeledby="tab_table">
        <div class="panel-body" style="padding: 0px;">
            <div class="col-md-12" style="margin-bottom: 25px;">
                <h5 class="titleSection">Conteo de Respuestas</h5>
                <hr class="title-hr">
                <div class="col-md-12 column-flex-bottom pd-items-table">
                    <div class="pd-side" style="width: 60%;">
                        <label class="form-check-label">Agente:</label>
                        <select class="form-control selectpicker" id="searchAgentGraphic" data-show-subtext="false" data-live-search="true">
                            <option value="todos">TODOS</option>
                            <?=$empleados?>
                            <?=$agentes?>
                        </select>
                    </div>
                    <div class="pd-side">
                        <label class="form-check-label">Mes:</label>
                        <select class="form-control" id="searchMonthGraphic">
                            <?=$months?>
                        </select>
                    </div>
                    <div class="pd-side">
                        <label class="form-check-label">Año:</label>
                        <select class="form-control" id="searchYearGraphic">
                            <?=$years?>
                        </select>
                    </div>
                    <div class="pd-side">
                        <button class="btn btn-primary" id="btnSearch" onclick="getCountResponseEvaluation()">
                            <i class="fas fa-search"></i> Buscar</button>
                    </div>
                </div>
                <div class="col-md-12 pd-left pd-right pd-top pd-bottom">
                    <div class="col-md-12 pd-left pd-right" id="navTablesResponseGraphic"></div>
                    <div class="tab-content bg-tab-content-nav cont-spinner-general" id="tabsTablesResponseGraphic" style="min-height: 400px;"></div>
                </div>
                <div class="col-md-12" id="graphicResponse"></div>
            </div>
        </div>
    </div>
</div>