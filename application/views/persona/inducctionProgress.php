<?php 
    $this->load->view("headers/header");
    $this->load->view("headers/menu");
?>
<head>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.2/css/bootstrap.min.css">

    <!-- Optional theme -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.2/css/bootstrap-theme.min.css">
</head>
<div class="container-fluid">
    <div class="page-header">
    <h3>Progreso de inducción</h3>
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
                <ul class="nav nav-tabs" role="tablist"><?=$tabs_?></ul>
                <div class="tab-content">
                    <?php 
                        foreach($personsInduction as $data){ 
                            $active = $data["tab"] == "Colaboradores" ? "active" : "";
                        ?>
                        
                            
                        <div id="<?=strtolower($data["tab"])?>" role="tabpanel" class="tab-pane <?=$active?> table-responsive">
                            <h5>Proceso de inducción de <?=$data["tab"]?></h5>
                            <table class="table">
                                <thead>
                                    <tr>
                                        <th class="text-center">Nombre completo</th>
                                        <th class="text-center">Correo (usuario de inducción)</th>
                                        <th class="text-center">Creador</th>
                                        <th class="text-center">Fecha de alta en inducción</th>
                                        <th>Documentación</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php foreach($data["values"] as $data_){?> 
                                        <tr>
                                            <td><?=$data_->nombres." ".$data_->apellidoPaterno." ".$data_->apellidoMaterno?></td>
                                            <td><?=$data_->email?></td>
                                            <td><?=$data_->userEmailCreacion?></td>
                                            <td class="text-center"><?=date("d-m-Y", strtotime($data_->fecAltaSistemPersona))?></td>
                                            <td>
                                                <div class="dropdown">
                                                    <button class="btn btn-primary btn-sm dropdown-toggle" type="button" id="dropdownMenu1" data-toggle="dropdown" aria-expanded="true">
                                                        Ver docs
                                                    </button>
                                                    <ul class="dropdown-menu" role="menu" aria-labelledby="dpm">
                                                        <li role="presentation" class="dropdown-header">Documentación de <?=$data_->nombres." ".$data_->apellidoPaterno." ".$data_->apellidoMaterno?></li>
                                                        <?php foreach($data_->documents as $docs){
                                                                $url = $docs["layout"] == "FOTO DE PERFIL" ? "assets/img/miInfo/userPhotos" : "archivosPersona/".$data_->idPersona."";
                                                            ?>
                                                            <li role="presentation" class="<?=$docs["disabled"]?>"><a role="menuitem" tabindex="-1" href="<?=base_url().$url?>/<?=$docs["docUploaded"]?>" target="_blank"><?=$docs["layout"]?></a></li>
                                                        <?php }?>
                                                    </ul>
                                                </div>
                                            </td>
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

<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.2/jquery.min.js"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.2/js/bootstrap.min.js"></script>