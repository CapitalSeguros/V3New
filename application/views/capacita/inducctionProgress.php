<?php 
    $this->load->view("headers/header");
    $this->load->view("headers/menu");
?>
<head>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.2/css/bootstrap.min.css">
    <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/v/dt/dt-1.11.5/datatables.min.css"/>
</head>
<div class="container-fluid">
    <div class="page-header">
    <h3>Progreso del alta de usuario</h3>
    </div>
    <div class="col-md-12">
        <div class="panel panel-body">
            <div role="tabpanel">
                <?php 
                    $tabs_ = array_reduce($tabs, function($acc, $cur){

                        $active = $cur == "colaboradores" ? "active" : "";
                        $acc .= "<li role='presentation' class='".$active."'><a href='#".$cur."' aria-controls='".$cur."' role='tab' data-toggle='tab'>".strtoupper($cur)."</a></li>";

                        return $acc;
                    }, "");
                ?>
                <ul class="nav nav-tabs" role="tablist" id="type-person"><?=$tabs_?></ul>
                <div class="tab-content">
                    <?php 
                        foreach($personsInduction as $data){ 
                            $active = $data["tab"] == "Colaboradores" ? "active" : "";
                        ?>
                        
                            
                        <div id="<?=strtolower($data["tab"])?>" role="tabpanel" class="tab-pane <?=$active?> table-responsive">
                            <h5>Proceso de inducción de <?=$data["tab"]?></h5>
                            <table class="table table-condensed table-sm table-content-new-users" id="table-content">
                                <thead>
                                    <tr>
                                        <th class="text-center">Nombre completo y usuario</th>
                                        <th class="text-center">Fecha de alta</th>
                                        <th class="text-center">Progreso de alta</th>
                                        <th class="text-center">Otros datos</th>
                                        <th class="text-center">Revisa</th>
                                        <th class="text-center">Opciones</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php foreach($data["values"] as $data_){?> 
                                        <tr data-id="<?=$data_->idPersona?>">
                                            <td>
                                                <div><?=$data_->nombres." ".$data_->apellidoPaterno." ".$data_->apellidoMaterno?></div>
                                                <div style="color: #2C3E50"><small>(<?=$data_->email?></small>)</div>
                                            </td>
                                            <td class="text-center"><?=date("d-m-Y", strtotime($data_->fecAltaSistemPersona))?></td>
                                            <td class="text-center"><?=$data_->avance?></td>
                                            <td>
                                                <a class="btn btn-link btn-xs show-more-info" href="javascript: void(0)" data-id="<?=$data_->idPersona?>" data-type="<?=$data_->tipoPersona?>" data-name="<?=$data_->nombres." ".$data_->apellidoPaterno." ".$data_->apellidoMaterno?>" data-email="<?=$data_->email?>">Ver más datos <span class="caret"></span></a>
                                            </td>
                                            <td>
                                                <?php foreach($data_->reviewer as $d_r){ 
                                                        $blocked = $this->tank_auth->get_usermail() != $d_r["reviewer_"] ? "disabled" : "";
                                                        
                                                    ?>
                                                    <div class="col-md-12">
                                                        <div class="row">
                                                            <div class="col-md-2 text-right" style="padding: 0px"><input type="checkbox" name="reviewer" class="reviewer" data-person="<?=$data_->idPersona?>" id="reviewer" value="<?=$d_r["reviewer_"]?>" <?=$d_r["check"]?> <?=$blocked?>></div>
                                                            <label class="col-md-10 control-label"><span class="label label-primary"><?=$d_r["label"]?></span></label>
                                                        </div>
                                                    </div>
                                                <?php }?>
                                            </td>
                                            <td><button class="btn btn-link btn-sm removeRegister" data-typePerson="<?=$data_->tipoPersona?>"><i class="fa fa-trash" aria-hidden="true"></i> Quitar</button></td>
                                        </tr>
                                    <?php }?>
                                </tbody>
                            </table>
                        </div>
                    <?php }
                    ?>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Modal -->
<div class="modal fade" id="show-more-data-modal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h4 class="modal-title" id="myModalLabel">Modal title</h4>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
      </div>
      <div class="modal-body insert-data"></div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button>
      </div>
    </div>
  </div>
</div>

<div><input type="hidden" id="base_url" data-url="<?=base_url()?>"></div>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.2/jquery.min.js"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.2/js/bootstrap.min.js"></script>
<script src="<?=base_url()."assets/js/jquery.inducctionProgress.js"?>"></script>
<script type="text/javascript" src="https://cdn.datatables.net/v/dt/dt-1.11.5/datatables.min.js"></script>
<!--<script type="text/javascript" src="https://cdn.datatables.net/rowgroup/1.1.4/js/dataTables.rowGroup.min.js"></script>-->