<?
  $permission_training_hc = 0;
  if ($userEmail == "DIRECTORCOMERCIAL@AGENTECAPITAL.COM" || $userEmail == "SISTEMAS@ASESORESCAPITAL.COM") {
    $permission_training_hc = 1;
  }
?>
<div class="col-md-12">
    <section class="container-fluid breadcrumb-formularios pd-left pd-right">
        <div class="row">
            <div class="col-md-6 column-flex-center-start">
                <h3 class="title-section-module">Horas Compañía</h3>
            </div>
        </div>
        <hr/>
    </section>
    <div>
        <div class="panel panel-default" style="margin-bottom: 80px;">
            <div class="panel-body">
                <div class="col-md-12 column-flex-items-center pd-items-table">
                    <label class="textSizeLabel mg-right" style="text-wrap: nowrap;">Filtrar por:</label>
                    <div class="column-flex-center-start container-filter-input">
                        <div class="pd-side">
                            <label class="subtitleSeg">Promotoria:</label>
                            <select class="form-control input-sm" id="hrPromo" onchange="selectFilterHoraRamoPromotoria('1',this.value)">
                                <option class="dropdown-item" value="todos">Todos</option>
                                <?= print_Promotorias($promotorias); ?>
                            </select>
                        </div>
                        <div class="pd-side">
                            <label class="subtitleSeg">Ramo:</label>
                            <select class="form-control input-sm" id="hrRamo" onchange="selectFilterHoraRamoPromotoria('2',this.value)">
                                <option class="dropdown-item" value="todos">Todos</option>
                                <?= print_Ramos($ramos); ?>
                            </select>
                        </div>
                        <div class="pd-side">
                            <label class="subtitleSeg">SubRamo:</label>
                            <select class="form-control input-sm" id="hrSubRamo" onchange="selectFilterHoraRamoPromotoria('3',this.value)">
                                <option class="dropdown-item" value="todos">Todos</option>
                                <?= print_SubRamos($subramos); ?>
                            </select>
                        </div>
                    </div>
                </div>
                <div class="col-md-12 pd-items-table column-flex-bottom">
                    <div class="col-md-6 column-flex-center-start pd-left">
                        <div class="pd-side brd-right" style="padding-right: 15px;">
                            <label class="textForm">Resultados: <b id="totalFilterTableHRP"></b></label>
                        </div>
                        <div class="pd-side column-flex-center-start" title="Seleccionado" style="padding-left: 15px;">
                            <i class="fas fa-circle mg-right indicator-circle-selected"></i>
                            <label class="subtitleSeg">Seleccionado</label>
                        </div>
                        <div class="pd-side column-flex-center-start" title="Editados">
                            <i class="fas fa-circle mg-right indicator-circle-edited"></i>
                            <label class="subtitleSeg">Editados</label>
                        </div>
                        <div class="pd-side column-flex-center-start" title="Actualizados hace un momento">
                            <i class="fas fa-circle mg-right indicator-circle-updated"></i>
                            <label class="subtitleSeg">Actualizados</label>
                        </div>
                    </div>
                    <div class="col-md-6 column-flex-center-end pd-right">
                        <? if ($permission_training_hc == 1) { ?>
                        <div class="pd-side brd-right" style="padding-right: 15px;">
                            <button class="btn btn-primary" title="Ver todos los cambios realizados" onclick="seguimientoHoraRamoPromotoria()">
                                <i class="fas fa-shoe-prints"></i> Seguimiento
                            </button>
                        </div>
                        <? } ?>
                        <div class="pd-side" style="padding-left: 15px;">
                            <button class="btn btn-primary" title="Guardar Todos Los Cambios" onclick="guardarHoraRamoPromotoria()">
                                <i class="fas fa-save"></i> Guardar Todo
                            </button>
                        </div>
                    </div>
                </div>
                <div class="col-md-12">
                    <div class="col-md-12 container-table">
                        <table class="table table-striped" id="tableHoraCompania">
                            <?= (devuelveRamoPromotoria($ramoPromotoria,$permission_training_hc)); ?> 
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<?
    function print_Ramos($data) {
        $option = '';
        foreach ($data as $key => $val) {
            $option .= '<option class="dropdown-item" value="'.$val['idRamo'].'">'.$val['nombre'].'</option>';
        }
        return $option;
    }

    function print_SubRamos($data) {
        $option = '';
        foreach ($data as $key => $val) {
            $option .= '<option class="dropdown-item" value="'.$val['IDSRamo'].'">'.$val['nombre'].'</option>';
        }
        return $option;
    }

    function print_Promotorias($data) {
        $option = '';
        foreach ($data as $key => $val) {
            $option .= '<option class="dropdown-item" value="'.$val->idPromotoria.'">'.$val->Promotoria.'</option>';
        }
        return $option;
    }
?>