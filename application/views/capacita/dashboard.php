<style type="text/css">
    th{
        color: black !important;
        font-weight: bold !important;
    }
        .adjust {
  height: 30em;
  line-height: 1em;
  overflow-x: auto;
  overflow-y: scroll;
  width: 100%;

}
</style>
<script type="text/javascript" src="<?= site_url('assets/js/jquery-1.12.3.min.js'); ?>"></script>
<script type="text/javascript" src="<?= site_url('assets/js/bootstrap.min.js'); ?>"></script>
<div class="col-md-12" style="margin-top: 20px">
    <div class="col-md-12 mb-4">
        <button id="BotonColapsa" class="btn btn-primary btn-sm" type="button" data-toggle="collapse" data-target="#filter-content" aria-expanded="false" aria-controls="collapseExample">
            Filtrar contenido
        </button>
        <div class="collapse mt-2" id="filter-content">
            <div class="card card-body content-for-filter">
                <div class="row mb-2">
                    <div class="col-md-2"><p>Seleccione un mes</p></div>
                    <div class="col-md-2"><select class="form-control" id="month-filter"><option value="0">Seleccione</option></select></div>
                </div>
                <div class="row mb-2">
                    <div class="col-md-2"><p>Seleccione un año</p></div>
                    <div class="col-md-2"><select class="form-control" id="year-filter"><option value="0">Seleccione</option></select></div>
                </div>
                <div class="row mb-2">
                    <div class="col-md-2"><p>Mostrar información de manera: </p></div>
                    <div class="col-md-2">
                        <select class="form-control" id="type-filter">
                            <option value="0">Seleccione</option>
                            <option value="mensual">Mensual</option>
                            <option value="trimestral">Trimestral</option>
                            <option value="total">Completo</option>
                        </select>
                    </div>
                </div>
                <div class="col-md-4 text-center"><button class="btn btn-info btn-sm execute-filter">Filtrar</button></div>
            </div>
        </div>
    </div>
    <h4 class="display-4">Conteo de horas <span class="filter-result">(General)</span></h4>
    <div class="col-md-12 mb-4">
        <div class="card mb-2">
            <div class="card-body general-graph"></div>
        </div>
        <div class="card mb-2">
            <div class="card-body general-info-table table-responsive"></div>
        </div>
    </div>
    <div class="col-md-12 mb-4">
        <div class="row">
            <div class="col-md-6 pie-graph">
                <div class="card">
                    <div class="card-header">Concentrado de horas de capacitación</div>
                    <div class="card-body pie-container"></div>
                </div>
            </div>
            <div class="col-md-6">
                <div class="card">
                    <div class="card-body pie-info table-responsive"></div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-md-12">
        <div class="row">
            <div class="col-md-6 line-graph">
                <div class="card">
                    <div class="card-body">
                        <div class="text-right filter-training"></div>
                        <div class="bar-container"></div>
                    </div>
                </div>
            </div>
            <div class="col-md-6">
                <div class="card">
                    <div class="card-body info-subtraining"></div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-md-12 mb-4">
        <div class="row">
            <div class="col-md-6"></div>
            <div class="col-md-6"></div>
        </div>
    </div>
    <h4 class="display-4">Conteo de personal <span class="filter-result">(General)</span></h4>
    <div class="col-md-12 mb-4">
        <div class="card mb-2">
            <div class="card-body general-graph1"></div>
        </div>
        <div class="card mb-2">
            <div class="card-body general-info-table-1 table-responsive"></div>
        </div>
    </div>
    <div class="col-md-12 mb-4">
        <div class="row">
            <div class="col-md-6 pie-graph">
                <div class="card">
                    <div class="card-header">Concentrado de participantes que tomaron capacitación</div>
                    <div class="card-body pie-container2"></div>
                </div>
            </div>
            <div class="col-md-6">
                <div class="card">
                    <div class="card-body pie-info2 table-responsive"></div>
                </div>
            </div>
        </div>
    </div>

         <div class="col-md-12 contenedor_colab_nombres mb-4">
               

            </div>

            <div class="col-md-12 contenedor_agent mb-4">
               

            </div>
    <div class="col-md-12">
        <div class="row">
            <div class="col-md-6 line-graph">
                <div class="card">
                    <div class="card-body">
                        <div class="text-right filter-training-1"></div>
                        <div class="bar-container-1"></div>
                    </div>
                </div>
            </div>
            <div class="col-md-6">
                <div class="card">
                    <div class="card-body info-subtraining-1"></div>
                </div>
            </div>
        </div>
    </div>
</div>