<?php

    //$this->load->view("headers/header");
    //$this->load->view("headers/menu");

    $title_ =  "";
    switch($tipo){
        case "A": $title_ = "AUTOS";
        break;
        case "G": $title_ = "GMM";
        break;
        case "D": $title_ = "DAÑOS";
        break;
        case "S": $title_ = "SINIESTROS AUTOS CORPORATIVO";
        break;
    }
    //var_dump($info["coment"]);
?>
<div class="container-fluid">
    <div class="col-md-12">
        <div class="row">
            <div class="col-md-9">
                <h3>Editar nota del siniestro</h3>
            </div>
            <div class="col-md-3 text-right">
            <ol class="breadcrumb">
                <li><a href="#">Inicio</a></li>
                <li><a href="#">Autos</a></li>
                <li class="active">Editar nota de autos</li>
            </ol>
            </div>
        </div>
        <hr>
    </div>
    <div class="col-md-12">
        <div class="col-md-10" style="margin-left: 6%">
            <div class="panel panel-body">
              <form action="#" id="sinister-note">
                <input type="hidden" name="id-row" id="id-row" value="<?=$info["sinister"]?>">
                <div class="col-md-12">
                  <div class="row">
                    <div class="col-md-12">
                      <p>Detalle de la póliza</p>
                      <div class="details-content">
                        <div class="row">
                          <div class="col-md-6">
                            <div class="row mb-2">
                              <div class="col-md-3">
                                <p>Póliza</p>
                              </div>
                              <div class="col-md-9">
                                <input type="text" name="number-policy" id="number-policy" class="form-control-plaintext input-sm" value="<?=$info["numberpolicy"]?>" readonly>
                              </div>
                            </div>
                          </div>
                          <div class="col-md-6">
                            <div class="row mb-2">
                              <div class="col-md-3">
                                <p>Asegurado</p>
                              </div>
                              <div class="col-md-9">
                                <input type="text" name="client-policy" id="client-policy" class="form-control-plaintext input-sm" value="<?=$info["clientPolicy"]?>" readonly>
                              </div>
                            </div>
                          </div>
                        </div>
                        <div class="row">
                          <div class="col-md-6">
                            <div class="row mb-2">
                              <div class="col-md-3">
                                <p>Siniestro</p>
                              </div>
                              <div class="col-md-9">
                                <input type="text" name="sinister-type" id="sinister-type" class="form-control-plaintext input-sm" value="<?=$title_?>" readonly>
                              </div>
                            </div>
                          </div>
                          <div class="col-md-6">
                            <div class="row mb-2">
                              <div class="col-md-3">
                                <p>Tipo</p>
                              </div>
                              <div class="col-md-9">
                                <input type="text" name="sinister-type-child" id="sinister-type-child" class="form-control-plaintext input-sm" value="<?=$info["sinisterTypeChild"]?>" readonly>
                              </div>
                            </div>
                          </div>
                        </div>
                        <div class="row">
                          <div class="col-md-6">
                            <div class="row mb-2">
                              <div class="col-md-3">
                                <p>No. de siniestro</p>
                              </div>
                              <div class="col-md-9">
                                <input type="text" name="number-sinister" id="number-sinister" class="form-control-plaintext input-sm" value="<?=$info["numberSinister"]?>" readonly>
                              </div>
                            </div>
                          </div>
                          <div class="col-md-6">
                            <div class="row mb-2">
                              <div class="col-md-3">
                                <p>No. de nota</p>
                              </div>
                              <div class="col-md-9">
                                <input type="text" name="id-note" id="id-note" class="form-control-plaintext input-sm" value="<?=$info["id"]?>" readonly>
                              </div>
                            </div>
                          </div>
                        </div>                  
                      </div>
                    </div>
                    <div class="col-md-12 mb-4" style="border-top: 1px #D5D8DC solid">
                      <p class="mt-2">Ingresar comentario de la nota</p>
                      <div class="col-md-12">
                        <textarea name="coment" id="coment" class="form-control" rows="3" placeholder="Ingrese comentario aquí."><?=htmlentities($info["coment"])?></textarea>
                      </div>
                    </div>
                    <div class="col-md-12" style="border-top: 1px #D5D8DC solid">
                      <p class="mt-2">Seleccione a un asignado</p>
                      <div class="col-md-12">
                        <div>
                          <div style="width: 150px; height: 400px; overflow-y: auto; display: inline-block; vertical-align: top;">
                            <div class="list-group">
                              <?php foreach($notes["agentsToAssing"] as $ar => $data){ $rename = str_replace(" ", "-", $ar); $active = strtolower($rename) == "bronce" ? "active" : ""; ?>
                                <a href="#<?= strtolower($rename); ?>" aria-controls="<?= strtolower($rename); ?>" role="tab" data-toggle="tab" class="list-group-item <?=$active?>">
                                  <h4 class="list-group-item-heading"><?= $ar?></h4>
                                  <p class="list-group-item-text">Con <?= count($data)?> miembros</p>
                                </a>
                              <?php }?>
                            </div>
                          </div>
                          <div style="width: 800px; height: 400px; overflow-y: auto; display: inline-block; vertical-align: top;">
                            <div class="panel panel-body tab-content" style="border: 1px #D5D8DC solid; border-radius: 3px;">
                                <?php foreach($notes["agentsToAssing"] as $ar => $data){ $rename = str_replace(" ", "-", $ar);  $active = strtolower($rename) == "bronce" ? "active" : ""; ?>
                                  <div role="tabpanel" class="tab-pane table-responsive <?=$active?>" id="<?= strtolower($rename); ?>">
                                    <p class="lead text-center"><?= $ar ?></p>
                                    <div class="col-md-12">
                                      <div class="row">
                                        <div class="col-md-1 text-left"><input type="checkbox" name="selected-all" class="selected-all" data-group="<?= strtolower($rename); ?>"></div>
                                        <div class="col-md-8"><p>Seleccionar a todos <?= $ar?></p></div>
                                      </div>
                                    </div>
                                    <table class="table table-sm">
                                      <thead>
                                        <tr>
                                          <th>Seleccionar</th>
                                          <th>Nombre</th>
                                          <th>Correo</th>
                                        </tr>
                                      </thead>
                                      <tbody>
                                        <?php foreach($data as $dca){ $cheked = in_array($dca->idPersona, $info["assigned"]) ? "checked" : ""; ?>
                                          <tr>
                                            <td class="text-center"><input type="checkbox" class="check-<?= strtolower($rename); ?>" name="person-selected[]" value="<?=$dca->idPersona?>" <?=$cheked?>></td>
                                            <td><?=$dca->name_complete?></td>
                                            <td><?=$dca->email?></td>
                                          </tr>
                                        <?php }?>
                                      </tbody>
                                    </table>
                                  </div>
                                <?php }?>
                            </div>
                          </div>
                        </div>
                      </div>
                    </div>
                    <div class="col-md-12 border-top mt-4 text-right pt-4">
                      <button class="btn btn-primary create-note">Actualizar nota</button>
                    </div>
                  </div>
                </div>
              </form>
            </div>
        </div>
    </div>
</div>
<script src="<?=base_url()."assets/js/jquery.editnoteofsinister.js"?>"></script> <!--Dennis [2021-12-08] -->