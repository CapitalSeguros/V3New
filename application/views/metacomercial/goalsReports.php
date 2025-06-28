<?php 
    $this->load->view("headers/header");
    $this->load->view("headers/menu");
?>
<div class="container-fluid">
    <div class="">
        <div>
            <div class="row">
                <div class="col-md-8">
                    <h3>Detalle de metas comerciales</h3>
                </div>
                <div class="col-md-4">
                    <ol class="breadcrumb">
                        <li class="active"><a href="<?=base_url()?>">Inicio</a></li>
                        <li><a href="<?=base_url()."reportes/cuadroMando"?>">Cuadro de mando</a></li>
                        <li>Detalle de metas comerciales</li>
                    </ol>
                </div>
            </div>
        </div>
        <!--------Bloque 1---------------->
        <div class="col-md-12 mt-6">
            <div role="tabpanel">
                <!-- Nav tabs -->
                <ul class="nav nav-tabs" role="tablist">
                    <!--<li role="presentation" class="active"><a href="#principal" aria-controls="principal" role="tab" data-toggle="tab">Principal</a></li>-->
                    <li role="presentation"><a href="#institucional" aria-controls="institucional" role="tab" data-toggle="tab">Institucional</a></li>
                    <li role="presentation"><a href="#merida" aria-controls="merida" role="tab" data-toggle="tab">Mérida</a></li>
                    <li role="presentation"><a href="#cancun" aria-controls="cancun" role="tab" data-toggle="tab">Cancún</a></li>
                    <li role="presentation"><a href="#fianzas" aria-controls="fianzas" role="tab" data-toggle="tab">Fianzas</a></li>
                </ul>
                <!-- Tab panes -->
                <div class="tab-content">
                    <div role="tabpanel" class="tab-pane fade in active" id="principal">
                        <h2 class="text-center">Seleccione una de las opciones de arriba para desplegar información.</h2>
                    </div>
                    <?php $channels = array("institucional", "merida", "cancun", "fianzas"); 
                        foreach($channels as $data){
                    ?>  
                        <div role="tabpanel" class="tab-pane fade" id="<?=$data?>">
                            <div class="page-header">
                                <h4>Avance del canal: <?=strtoupper($data)?></h4>
                            </div>
                            <div class="panel panel-default">
                                <div class="panel-heading">Gráfica de avance mensual</div>
                                <div class="panel-body">
                                    <div class="col-md-12">
                                        <div class="row">
                                            <div class="col-md-8">
                                                <div class="well">
                                                    <canvas id="canvas-count-<?=$data?>"></canvas>
                                                </div>
                                            </div>
                                            <div class="col-md-4 table-responsive">
                                                <table class="table table-sm">
                                                    <thead>
                                                        <tr>
                                                            <th class="text-center">MES</th>
                                                            <th class="text-center">AVANCE</th>                                                    
                                                        </tr>
                                                    </thead>
                                                    <tbody id="month-count-<?=$data?>"></tbody>
                                                </table>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-12">
                                        <div class="row">
                                            <div class="col-md-8">
                                                <div class="well">
                                                    <canvas id="canvas-bonus-<?=$data?>"></canvas>
                                                </div>
                                            </div>
                                            <div class="col-md-4 table-responsive">
                                            <table class="table table-sm">
                                                    <thead>
                                                        <tr>
                                                            <th class="text-center">MES</th>
                                                            <th class="text-center">AVANCE</th>                                                    
                                                        </tr>
                                                    </thead>
                                                    <tbody id="month-bonus-<?=$data?>"></tbody>
                                                </table>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="panel panel-default">
                                <div class="panel-heading">Gráfica de avance por ramos.</div>
                                <div class="panel-body">
                                    <div class="col-md-12">
                                        <div class="row">
                                            <div class="col-md-8">
                                                <div class="well">
                                                    <canvas id="canvas-category-count-<?=$data?>"></canvas>
                                                </div>
                                            </div>
                                            <div class="col-md-4">
                                                <div class="list-group list-count-<?=$data?>"></div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-12">
                                        <div class="row">
                                            <div class="col-md-8">
                                                <div class="well">
                                                    <canvas id="canvas-category-bonus-<?=$data?>"></canvas>
                                                </div>
                                            </div>
                                            <div class="col-md-4">
                                                <div class="list-group list-bonus-<?=$data?>"></div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    <?php }?>
                </div>                                                                      
            </div>
        </div>
            <!--------Final bloque 1---------->   
    </div>
</div>
<input type="hidden" value="<?=base_url()?>" id="base_url">
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.2/js/bootstrap.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/axios/dist/axios.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/chart.js@2.8.0"></script>
<script src="<?=base_url()."assets/js/jquery_categoryGoalsManage.js"?>"></script>