<?php 
    $this->load->view("headers/header");
    $this->load->view("headers/menu");
?>

<head>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.2/css/bootstrap.min.css">
</head>
<div class="container-fluid">
    <div class="page-header">
        <h3>Proceso de alta de prospección de agentes</h3>
    </div>
    <div class="tabpanel">
        <ul class="nav nav-tabs" role="tablist">
            <?php  $tabs =  array_keys($prospectives);
                foreach($tabs as $t){?>
                    <li role="presentation"><a href="#<?=strtolower(str_replace(" ", "-", str_replace("@","-", str_replace(".", "-", $t))))?>" aria-controls="<?=strtolower(str_replace(" ", "-", str_replace("@","-", str_replace(".", "-", $t))))?>" role="tab" data-toggle="tab"><?=$t?></a></li>
            <?php }?>
        </ul>
        <div class="tab-content">
            <?php foreach($prospectives as $area => $agents){?> 
                <div role="tabpanel" class="tab-pane fade" id="<?=strtolower(str_replace(" ", "-", str_replace("@","-", str_replace(".", "-", $area))))?>">
                    <div class="col-md-12">
                        <div class="row">
                            <div class="col-md-3"><h5>Lista de prospecto de agentes</h5></div>
                            <div class="col-md-2" style="border-right: 1px #D5D8DC solid"><button class="btn btn-primary btn-sm btn-selected" data-check="0" data-class="<?=strtolower(str_replace(" ", "-", str_replace("@","-", str_replace(".", "-", $area))))?>">Seleccionar todos</button></div>
                            <div class="col-md-6">
                                <div class="row">
                                    <div class="col-md-2">
                                        <div class="dropdown">
                                            <button id="dLabel" type="button" class="btn btn-info btn-sm" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                                Asignar a
                                                <span class="caret"></span>
                                            </button>
                                            <ul class="dropdown-menu" role="menu" aria-labelledby="dLabel">
                                                <?= array_reduce($accounts, function($acc, $curr) use($area){
                                                    $acc .= '<li role="presentation"><a role="menuitem" tabindex="-1" href="javascript: void(0)" class="earmarked-to" data-mail="'.$curr.'" data-class="'.strtolower(str_replace(" ", "-", str_replace("@","-", str_replace(".", "-", $area)))).'">'.$curr.'</a></li>';
                                                    return $acc;
                                                }, ""); ?>
                                            </ul>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="row">
                                            <label for="earmarked" class="control-label col-md-4 mt-3">Asignado a: </label>
                                            <div class="col-md-8">
                                                <input type="text" name="earmarked-<?=strtolower(str_replace(" ", "-", str_replace("@","-", str_replace(".", "-", $area))))?>" id="earmarked-<?=strtolower(str_replace(" ", "-", str_replace("@","-", str_replace(".", "-", $area))))?>" class="form-control" readonly>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-3">
                                        <button class="btn btn-success btn-sm confirm" data-tab="<?=strtolower(str_replace(" ", "-", str_replace("@","-", str_replace(".", "-", $area))))?>" id="earmarked-<?=strtolower(str_replace(" ", "-", str_replace("@","-", str_replace(".", "-", $area))))?>">Confirmar</button>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <hr>
                    </div>
                    <div class="row">
                        <div class="col-md-7 table-responsive">
                            <div style="height: 500px; overflow-y: scroll;">
                                <table class="table table-sm">
                                    <thead>
                                        <tr>
                                            <th>DNI</th>
                                            <th>Prospecto</th>
                                            <th>Estado</th>
                                            <th></th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php foreach($agents as $data){?>
                                            <tr>
                                                <td><input type="checkbox" name="prospectives[]" value="<?=$data->id?>" id="prospective-<?=$data->id?>" class="check-<?=strtolower(str_replace(" ", "-", str_replace("@","-", str_replace(".", "-", $area))))?>"></td>
                                                <td><?=$data->prospecto?></td>
                                                <td><?=$data->status?></td>
                                                <td>
                                                    <button class="btn btn-link btn-sm agent-details" data-id="<?=$data->id?>" data-content="<?=strtolower(str_replace(" ", "-", str_replace("@","-", str_replace(".", "-", $area))))?>">Ver detalle</button>
                                                </td>
                                            </tr>
                                        <?php }?>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                        <div class="col-md-5 data-panel-<?=strtolower(str_replace(" ", "-", str_replace("@","-", str_replace(".", "-", $area))))?>" role="tabpanel"></div>
                    </div>
                </div>
            <?php }?>
        </div>
    </div>
    <!--<div class="col-md-12">
        <div class="row">
            <div class="col-md-7">
                <?php 
                    
                    foreach($prospectives as $area => $agents){?>
                    <div class=" col-md-12 table-responsive" style="padding-bottom: 15px;">
                        <h5><?=strtoupper($area)?></h5>
                        <div style="height: 300px; overflow-y: scroll;">
                            <table class="table table-sm">
                                <thead>
                                    <tr>
                                        <th>DNI</th>
                                        <th>Prospecto</th>
                                        <th>Estado</th>
                                        <th></th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php foreach($agents as $data){?>
                                        <tr>
                                            <td><input type="checkbox" name="prospectives[]" id="prospective-<?=$data->id?>"></td>
                                            <td><?=$data->prospecto?></td>
                                            <td><?=$data->status?></td>
                                            <td>
                                                <button class="btn btn-link btn-sm agent-details" data-id="<?=$data->id?>">Ver detalle</button>
                                            </td>
                                        </tr>
                                    <?php }?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                <?php }?>
            </div>
            <div class="col-md-5 data-panel" role="tabpanel">
                
            </div>
        </div>
    </div>-->
</div>
<input type="hidden" name="url" id="url" data-url="<?=base_url()?>">
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.2/js/bootstrap.min.js"></script>
<script src="<?=base_url()."assets/js/jquery.manageProspectiveAgent.js"?>"></script>