<?php 
    $this->load->view("headers/header");
    $this->load->view("headers/menu");

    //----------------------------
    function getBgColor($ramification){

        switch($ramification){
            case "Vida": return "background-color: rgba(229, 152, 102)";
            break;
            case "GMM" : return "background-color: rgba(93, 173, 226)";
            break;
            case "Vehiculos" : return "background-color: rgba(244, 208, 63)";
            break;
            case "Daños" : return "background-color: rgba(236, 112, 99)";
            break;
            case "Fianzas" : return "background-color: rgba(46, 204, 113)";
            break;
        }
    }
    //----------------------------
?>
<link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.11.3/css/jquery.dataTables.css">
<input type="hidden" id="base-url" data-url="<?=base_url()?>">
<div class="container-fluid">

    <div class="page-header">
        <div class="row">
            <div class="col-md-8"><h2>Gestión de clientes</h2></div>
            <div class="col-md-4">
                <ol class="breadcrumb">
                    <li><a href="<?=base_url()?>">Inicio</a></li>
                    <li class="active">Gestor de clientes</li>
                </ol>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="" style="width: 9%; display: inline-block; vertical-align: top; padding: 10px 10px 10px 10px;">
            <div style="border: 1px black solid; width: 100%; height: 100px; padding: 10px 3px 3px 3px; border-radius: 5px" class="text-center mb-3">
                <a href="javascript: void(0)" class="text-center select-option" type="button" data-show="create">
                    <img src="<?=base_url()?>assets/images/clients/customer.png" alt="" width="50%" height="60%">
                    <p>Crear unificación</p>
                </a>
            </div>
            <div style="border: 1px black solid; width: 100%; height: 100px; padding: 10px 3px 3px 3px; border-radius: 5px" class="text-center mb-3">
                <a href="javascript: void(0)" class="text-center select-option" type="button" data-show="view">
                    <img src="<?=base_url()?>assets/images/clients/esquema-de-bloques-cuadrados.png" alt="" width="50%" height="60%">
                    <p>Bloques</p>
                </a>
            </div>
        </div>
        <div class="" style="width: 90%; display: inline-block; vertical-align: top">
            <div class="contents hidden col-md-12" id="create">
                <h4>Buscar cliente</h4>
                <div class="row">
                    <div class="col-md-4">
                        <input type="text" class="form-control" id="find-client">
                    </div>
                    <div class="col-md-2">
                        <button class="btn btn-primary find-client">Buscar</button>
                    </div>
                    <div class="col-md-2">
                        <button class="btn btn-info unify-clients text-white" data-update="0" data-block="0">Unificar clientes</button>
                    </div>
                </div>
                <div class="col-md-12 mt-4">
                    <div class="panel panel-body">
                        <div class="row">
                            <div class="col-md-4">
                                <h4 class="text-center">Resultado de la búsqueda</h4>
                                <div id="search-results" style="height: 350px; overflow-y: auto"></div>
                            </div>
                            <div class="col-md-8">
                                <h4 class="text-center">Unificación de pólizas</h4>
                                <div class="row" id="container-of-selected">
                                    <div class="text-center center-block hidden loading-spinner" style="position: absolute; left: 30%">
                                        <img src="<?=base_url()?>assets/images/loadingSpinner.gif" width="350px" height="300px">
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="contents show col-md-12" id="view">
                <div class="col-md-12">
                    <div class="panel panel-body">
                        <h4>Unificaciones creadas</h4>
                        <?php if(!empty($blocks)){ ?>
                            <table class="table" id="blocks">
                                <thead>
                                    <tr>
                                        <th>Bloque</th>
                                        <th>Clientes (unificados)</th>
                                        <th>Ramos compartidos</th>
                                        <th>Opciones</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php foreach($blocks as $id => $data){?>
                                        <tr class="<?=$id?>">
                                            <td><?= ucwords($data["block"]) ?></td>
                                            <td>
                                                <?php $arr = array_values($data["clients"]);
                                                    echo array_reduce($arr, function($acc, $curr){
                                                        $acc .= '<div class="mb-2">'.$curr["name"].'</div>';
                                                        return $acc;
                                                    }, "");
                                                ?>
                                            </td>
                                            <td>
                                                <div class="show <?=$id?>_">
                                                <?= array_reduce($data["ramifications"], function($acc, $curr){
                                                    $bgColor = getBgColor($curr["name"]);
                                                    $acc .= '<div style="margin-right: 5px; margin-bottom: 5px; color: white; text-align:center; padding: 5px 5px 5px 5px; display: inline-block; vertical-align: top; '.$bgColor.'">'.$curr["name"].'</div>';
                                                    return $acc;
                                                }, ""); ?>
                                                </div>
                                                <?= array_reduce($arr, function($acc, $curr) use($id){
                                                    $acc .= '<div class="hidden mb-4 '.$id."-".$curr["idCli"].'"></div>';
                                                    return $acc;
                                                }, "");?>
                                            </td>
                                            <td>
                                                <div class="dropdown text-center">
                                                    <a href="javascript: void(0)" id="dpd-<?=$id?>" data-target="#" data-toggle="dropdown" aria-haspopup="true" role="button" aria-expanded="false"><i class="fa fa-ellipsis-v" aria-hidden="true"></i></a>
                                                    <ul class="dropdown-menu" role="menu" aria-labelledby="dpd-<?=$id?>">
                                                        <li role="presentation"><a role="menuitem" class="modify" tabindex="-1" href="javascript: void(0)" data-id="<?=$id?>">Modificar</a></li>
                                                        <li role="presentation"><a role="menuitem" class="delete" tabindex="-1" href="javascript: void(0)" data-id="<?=$id?>">Eliminar</a></li>
                                                        <li role="presentation" class="dropdown-header">Ver pólizas</li>
                                                        <?= array_reduce($arr, function($acc, $curr) use($id){
                                                            $acc .= '<li role="presentation"><a><input class="show-info" type="checkbox" value="'.$curr["idCli"].'" id-block="'.$id.'"> '.$curr["name"].'</a></li>';
                                                            return $acc;
                                                        }, "")?>
                                                    </ul>
                                                </div>
                                            </td>
                                        </tr>
                                    <?php }?>
                                </tbody>
                            </table>
                        <?php }?>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.2/jquery.min.js"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.2/js/bootstrap.min.js"></script>
<script type="text/javascript" charset="utf8" src="https://cdn.datatables.net/1.11.3/js/jquery.dataTables.js"></script>
<script src="<?=base_url()."assets/js/jquery.manageclients.js"?>"></script> <!--Dennis [2021-12-29] -->