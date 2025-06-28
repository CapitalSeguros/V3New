<div class="col-md-12">
    <ul class="nav nav-pills mb-3" id="pills-tab" role="tablist">
        <li class="nav-item">
            <a class="nav-link active" id="pills-filter-result-tab" data-toggle="pill" href="#pills-filter-result" role="tab" aria-controls="pills-filter-result" aria-selected="true">Capacitaciones - Ramos</a>
        </li>
        <li class="nav-item">
            <a class="nav-link" id="pills-channel-tab" data-toggle="pill" href="#pills-channel" role="tab" aria-controls="pills-channel" aria-selected="false">Registros mensuales</a>
        </li>
    </ul>
    <div class="tab-content" id="pills-tabContent">
        <div class="tab-pane active" id="pills-filter-result" role="tabpanel" aria-labelledby="pills-filter-result-tab">
            <?php $this->load->view("capacita/trainingSubtrainingCategoryReport");?>
        </div>
        <div class="tab-pane" id="pills-channel" role="tabpanel" aria-labelledby="pills-channel-tab">
            <div class="col-md-12 table-responsive">
                <table class="all-persons">
                    <thead>
                        <tr>
                            <th>Agente - colaborador</th>
                            <th>ENERO</th>
                            <th>FEBRERO</th>
                            <th>MARZO</th>
                            <th>ABRIL</th>
                            <th>MAYO</th>
                            <th>JUNIO</th>
                            <th>JULIO</th>
                            <th>AGOSTO</th>
                            <th>SEPTIEMBRE</th>
                            <th>OCTUBRE</th>
                            <th>NOVIEMBRE</th>
                            <th>DICIEMBRE</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach($peopleWithTraining as $dpt){?>
                            <tr>
                                <td><?=$dpt["name"]?></td>
                                <?php foreach($dpt["data"] as $da){?> 
                                    <td class="text-center"><?=$da?></td>
                                <?php }?>
                            </tr>
                        <?php }?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
