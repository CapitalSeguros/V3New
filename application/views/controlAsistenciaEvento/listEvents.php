<?php 
    $this->load->view("headers/header");
    $this->load->view("headers/menu");


    function validateCheckRadio($status = null){

        $response = "";
        switch($status){
            case "activo" : $response = "checked";
            break;
            case "inactivo" : $response = "checked";
            break;
            default: $response;
            break;
        }

        return $response;
    }

?>
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">

<div class="container-fluid">
    <br>
    <h3>Lista de asistencia a capacitaciones</h3>
    <hr>
    <div class="row">
        <div class="col-md-3">
            <div class="mb-3">
                <div class="card mt-3">
                    <div class="card-header text-center">Eventos</div>
                        <div class="card-body">
                            <div class="list-group" id="list-tab" role="tablist">
                        <?php if(!empty($events)){
                        foreach($events["listEvents"] as $timeEvent => $eventData){?>
                            <a class="list-group-item list-group-item-action" id="list-<?=$timeEvent?>-list" data-toggle="list" href="#list-<?=$timeEvent?>" role="tab" aria-controls="<?=$timeEvent?>"><?=$eventData["title"]." (".$eventData["status"].")"?></a>
                                <?php } ?>
                            </div>
                        </div>
                    </div>
                <?php } else{?>
                    <h5>No hay eventos para mostrar</h5>
                <?php }?>
            </div>
            <div class="text-center m-auto" >
                <h4 class="text-center">Referencias:</h4>
                <p class="text-center">Validación de asistencia de agentes a una capacitación por colores.</p>
                <ul class="list-group">
                    <li class="list-group-item list-group-item-success">El organizador confirmó asistencia presencial (clic al botón confirmar en asistencia)</li>
                    <li class="list-group-item list-group-item-info">Aun queda pendiente la asistencia del agente</li>
                    <li class="list-group-item list-group-item-danger">El agente no asistió a la reunión de capacitación (clic al botón confirmar en ausencia)</li>
                </ul>
            </div>
        </div>
        <div class="col-md-9">
            <div class="tab-content" id="nav-tabContent">
                <?php foreach($events["events"] as $key => $dataEvent){?> 
                    <div class="tab-pane fade" id="list-<?=$key?>" role="tabpanel" aria-labelledby="list-<?=$key?>-list">
                        <div class="card card-body">
                            <h4 class="mb-4">Datos del evento</h4>
                            <div class="row">
                                <div class="col-md-2"><p>Título:</p></div>
                                <div class="col-md-8"><p><b><?=$dataEvent["title"]?></b></p></div>
                            </div>
                            <div class="row">
                                <div class="col-md-2"><p>Descripción:</p></div>
                                <div class="col-md-8"><p><b><?=$dataEvent["description"]?></b></p></div>
                            </div>
                            <div class="row">
                                <div class="col-md-2"><p>Fecha/Hora de inicio:</p></div>
                                <div class="col-md-8"><p><b><?=$dataEvent["startDate"]?> hrs</b></p></div>
                            </div>
                            <div class="row">
                                <div class="col-md-2"><p>Fecha/Hora de termino:</p></div>
                                <div class="col-md-8"><p><b><?=$dataEvent["endDate"]?> hrs</b></p></div>
                            </div>
                            <div class="row">
                                <div class="col-md-2"><label for="hours" class="label-control">Horas consideradas</label></p></div>
                                <div class="col-md-8"><p><input type="text" id="hours-<?=$key?>" name="hours-<?=$key?>" value="<?=$dataEvent["totalHours"]?>" class="form-control-plaintext" readonly></div>
                            </div>
                            <hr>
                            <h4 class="mb-4">Lista de asistencia</h4>
                            <div class="card-group">
                                <?php if(array_key_exists("guest", $dataEvent)){
                                    foreach($dataEvent["guest"] as $dataGuest){
                                        if($dataGuest["status"] == "aceptado") {?>
                                        <div class="col-md-4 text-center mb-4">
                                            <div class="card card-body border border-info text-info">
                                                <form class="guest-form">
                                                <h5><i class="fa fa-user" aria-hidden="true"></i> <?=strtoupper($dataGuest["name"])?></h5>
                                                <hr>
                                                <div class="row">
                                                    <input type="hidden" name="event" value="<?=$key?>">
                                                    <label for="register" class="col-md-5 text-left">No. registro</label>
                                                    <div class="col-md-6">
                                                        <input type="text" id="reg-<?=$dataGuest["idGuest"]?>" name="reg" value="<?=$dataGuest["idGuest"]?>" class="form-control-plaintext" readonly>
                                                        <input type="hidden" name="recordTraining" id="recordTraining-<?=$dataGuest["idGuest"]?>" value="<?=$dataGuest["trainingRecord"]?>">
                                                    </div>
                                                </div>
                                                <div class="row">
                                                    <label for="register" class="col-md-5 text-left">Invitado</label>
                                                    <div class="col-md-6">
                                                        <input type="text" name="type" id="reg-guest-<?=$dataGuest["idGuest"]?>" value="<?=strtoupper($dataGuest["type"])?>" class="form-control-plaintext" readonly>
                                                        
                                                    </div>
                                                </div>
                                                <hr>
                                                <div class="row">
                                                    <div class="col-md-6 text-success">
                                                        <div class="form-group row">
                                                            <div class="col-md-1">
                                                                <input type="radio" value="aceptado" name="confirma" <?= $dataGuest["checkAssist"] == "activo" ? "checked" : "" ?>>
                                                            </div>
                                                            <label for="asistencia" class="col-md-8 label-control"><i class="fa fa-check" aria-hidden="true"></i>Asistencia</label>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-5 text-danger">
                                                        <div class="form-group row">
                                                            <div class="col-md-1">
                                                                <input type="radio" value="ausencia" name="confirma" <?= $dataGuest["checkAssist"] == "inactivo" ? "checked" : "" ?>>
                                                            </div>
                                                            <label for="ausencia" class="col-md-8 label-control"><i class="fa fa-times" aria-hidden="true"></i>Ausencia</label>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="text-center" id="response-<?=$dataGuest["idGuest"]?>">
                                                    <?php if(!empty($dataGuest["checkAssist"])){
                                                        $label = $dataGuest["checkAssist"] == "activo" ? '<h4><span class="badge badge-success">Registrado</span></h4>' : '<h4><span class="badge badge-danger">Removido</span></h4>'; 
                                                        echo $label; 
                                                    }?>
                                                </div>
                                                <div class="text-center mt-4">
                                                    <button type="submit" class="btn btn-primary">Confirmar</button>
                                                </div>
                                                </form>
                                            </div>
                                        </div>
                                <?php } }
                                }?>
                            </div>
                        </div>
                    </div>
                <?php }?>
            </div>
        </div>
    </div>
</div>
<input type="hidden" name="base_url" id="base_url" data-url="<?=base_url()?>">
<script src="https://code.jquery.com/jquery-3.2.1.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>
<script src="<?=base_url()."assets/js/jquery.manageListEvents.js"?>"></script>