<div class="panel panel-default" style="margin-bottom: 80px;">
    <div class="panel-body">
        <div class="col-md-12" style="margin-bottom: 20px;">
            <h5 class="titleSection">Crear Evaluación por Agente
                <button class="btn-view-cont" data-toggle="collapse" href="#segInfGen" aria-expanded="true"><i class="fa fa-info-circle" title="Ver Información"></i>
                </button>
            </h5>
            <hr class="title-hr">
            <div class="col-md-12" style="margin-bottom: 10px;">
                <div class="col-md-12 collapse" id="segInfGen">
                    <div class="alert alert-primary" role="alert" style="margin: 0px;">
                        <h4><i class="fas fa-info-circle"></i> Información</h4>
                        <p>Para crear el link de Evaluación del Agente utiliza el buscador para mostrar la dirección URL en el segmento con el ícono <b><i class="fas fa-link"></i></b>.</p>
                    </div>
                </div>
            </div>
            <div class="col-md-12 column-flex-bottom pd-items-table">
                <div class="pd-side" style="min-width: 70%;">
                    <label class="form-check-label">Agente:</label>
                    <select class="form-control selectpicker" id="evAgent" data-show-subtext="false" data-live-search="true">
                        <?=$empleados?>
                        <?=$agentes?>
                    </select>
                </div>
                <div class="pd-side">
                    <button class="btn btn-primary" id="btnEv" onclick="getInformationAgent()">
                        <i class="fas fa-search"></i> Buscar</button>
                </div>
            </div>
            <div class="col-md-12">
                <div class="col-md-12 container-link">
                    <div class="input-group flex-nowrap">
                        <span class="input-group-text"><i class="fas fa-link"></i></span>
                        <input type="text" class="form-control" id="evLink" placeholder="..." disabled>
                        <a class="btn btn-group-second" href="" id="btnExternalLink" target="_blank" disabled>
                            <i class="fas fa-external-link-alt"></i> Ver
                        </a>
                        <button class="btn btn-group-right" id="btnLink" onclick="copy_clipboard('evLink')" disabled>
                            <i class="fas fa-copy"></i> Copiar
                        </button>
                    </div>
                </div>
            </div>
            <div class="col-md-12">
                <div class="col-md-12 container-info-agent">
                    <h5 class="form-check-label mg-top-cero">Nombre: <b class="info-agent"></b></h5>
                    <h5 class="form-check-label mg-top-cero">Email: <b class="info-agent"></b></h5>
                    <h5 class="form-check-label mg-top-cero">ID Vendedor: <b class="info-agent"></b></h5>
                    <h5 class="form-check-label mg-top-cero">Ranking: <b class="info-agent"></b></h5>
                    <h5 class="form-check-label mg-top-cero">Canal: <b class="info-agent"></b></h5>
                    <h5 class="form-check-label mg-top-cero">Coordinador: <b class="info-agent"></b></h5>
                </div>
            </div>
        </div>
    </div>
</div>