<?php

    $title_ = $tipo == "Siniestros" ? "Siniestros" : "";
?>
<div id="base_url" data-base-url="http://localhost/Capsys/www/V3/"></div>
<div class="container-fluid">
    <div class="row">
        <div class="col-md-6"><h3 class="titulo-secciones">Mis notas</h3></div>
    </div>
    <hr>
</div>
<div class="container">
    <?= $this->load->view('siniestro_catalogo/sidemenu2', array("tipo" => $tipo));?>
    <div style="float: left; width: 90%;">
        <div class="panel panel-body">
            <h4>Notas de siniestros tipo: SINIESTROS AUTOS CORPORATIVOS</h4>
            <?php if(!empty($notes)){
                foreach($notes as $date => $dnote){?>
                    <div class="col-md-12 border mb-4" id="<?=$date?>">
                        <div class="col-md-12"><h3><?=$date?></h3><hr></div>
                        <div class="col-md-12 table-responsive">
                            <table class="table">
                                <tbody>
                                    <tr class="text-center font-weight-bold"><td>Detalles del siniestro</td><td>Asegurado</td><td>Creado por</td><td>Hora de creación</td><td>Estado</td><td>Detalle de nota</td></tr>
                                    <? foreach($dnote as $dasssig){?>
                                        <tr class="text-center">
                                            <td>
                                                <div class="text-left"><p><span class="font-weight-bold">Póliza:</span> <?=$dasssig->poliza?></p></div>
                                                <div class="text-left"><p><span class="font-weight-bold">No. de siniestro:</span> <?=$dasssig->siniestro_id?></p></div>
                                                <div class="text-left"></div>
                                            </td>
                                            <td><?=$dasssig->asegurado_nombre?></td>
                                            <td>
                                                <div><?=$dasssig->nombres." ".$dasssig->apellidoPaterno." ".$dasssig->apellidoMaterno?></div>
                                                <div><?=$dasssig->creator?></div>
                                            </td>
                                            <td><?= date("g:i a", strtotime($dasssig->dateCreate))?></td>
                                            <td></td>
                                            <td>
                                                <button type="button" class="btn btn-link btn-sm show-info" data-toggle="modal" data-target="#show-note" data-backdrop="" data-idnote="<?=$dasssig->id?>" data-policy="<?=$dasssig->poliza?>" data-controller="autos corporativo">
                                                    Ver nota
                                                </button>
                                            </td>
                                        </tr>
                                    <?php }?>
                                </tbody>
                            </table>
                        </div>
                    </div>
            <?php } 
                } else{?>
                <h3>Sin notas asignadas</h3>
            <?php }?>
        </div>
    </div>
    <!-------------------------------->
<div class="modal fade" id="show-note" tabindex="-1" role="dialog" aria-labelledby="xd" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title" id="title-policy">Descripción de la nota</h4>
      </div>
      <div class="modal-body">
        <div class="panel panel-body border note-description">

        </div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button>
      </div>
    </div>
  </div>
</div>
<!-------------------------------->
</div>
<!--<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.2/jquery.min.js"></script>-->
<!--<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.2/js/bootstrap.min.js"></script>-->
<script src="<?=base_url()."assets/js/jquery.notesforclaimsmodule.js"?>"></script> <!--Dennis [2021-12-08] -->