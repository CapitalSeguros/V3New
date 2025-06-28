<div class="col-md-12">
    <div class="card">
        <div class="card-body">
            <p><span class="text-danger">* Campos obligatorios</span></p>
            <div class="row">
                <div class="col-md-2">* Seleccione una categoría</div>
                <div class="col-md-4">
                    <select id="training-for-report-agent" class="form-control">
                        <option value="">Seleccione</option>
                        <?php foreach($training as $dt){?>
                            <option value="<?=$dt->id_capacitacion?>"><?=$dt->tipoCapacitacion?></option>
                        <?php }?>
                    </select>
                </div>
                <div class="col-md-2">Seleccione una sub-categoría</div>
                <div class="col-md-4">
                    <select id="sub-training-for-report-agent" class="form-control">
                        <option value="">Seleccione</option>
                    </select>
                </div>
                <div class="col-md-2 mt-2">Seleccione una mes</div>
                <div class="col-md-2 mt-2">
                    <select id="month-for-report-agent" class="form-control">
                        <option value="">Seleccione</option>
                        <?php foreach($months as $num => $name){?>
                            <option value="<?=$num?>"><?=$name?></option>
                        <?php }?>
                    </select>
                </div>
                <div class="col-md-2 mt-2">* Seleccione un año</div>
                <div class="col-md-2 mt-2">
                    <select id="year-for-report-agent" class="form-control">
                        <option value="">Seleccione</option>
                        <?php foreach($years1 as $namex){?>
                            <option value="<?=$namex->dateTraining?>"><?=$namex->dateTraining?></option>
                        <?php }?>
                        <option value="total">Acumulado</option>
                    </select>
                </div>
                <div class="col-md-2 mt-2 text-center">
                    <button class="btn btn-info btn-sm apply-search-agent">Aplicar</button>
                </div>
                <div class="col-md-2 mt-2 text-center">
                    <button class="btn btn-info btn-sm" onclick="exportarxls('report-agent')">Exportar</button>
                </div>
            </div>
        </div>
    </div>
    <div class="content-training-2 mt-4"></div>
</div>