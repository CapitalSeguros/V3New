<?php 
  $buttons = array_keys($notes["agentsToAssing"]);
  //var_dump($notes["agentsToAssing"]);
?>

<div class="modal fade notes-modal" tabindex="-1" role="dialog" aria-labelledby="xd1" aria-hidden="true">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">
      <div class="modal-header"> <h4>Crear notas</h4> </div>
      <div class="modal-body">
        <form action="#" id="sinister-note">
          <input type="hidden" name="id-row" id="id-row" value="0">
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
                          <input type="text" name="number-policy" id="number-policy" class="form-control-plaintext input-sm" readonly>
                        </div>
                      </div>
                    </div>
                    <div class="col-md-6">
                      <div class="row mb-2">
                        <div class="col-md-3">
                          <p>Asegurado</p>
                        </div>
                        <div class="col-md-9">
                          <input type="text" name="client-policy" id="client-policy" class="form-control-plaintext input-sm" readonly>
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
                          <input type="text" name="sinister-type" id="sinister-type" class="form-control-plaintext input-sm" readonly>
                        </div>
                      </div>
                    </div>
                    <div class="col-md-6">
                      <div class="row mb-2">
                        <div class="col-md-3">
                          <p>Tipo</p>
                        </div>
                        <div class="col-md-9">
                          <input type="text" name="sinister-type-child" id="sinister-type-child" class="form-control-plaintext input-sm" readonly>
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
                          <input type="text" name="number-sinister" id="number-sinister" class="form-control-plaintext input-sm" readonly>
                        </div>
                      </div>
                    </div>
                    <div class="col-md-6">
                      <div class="row mb-2">
                        <div class="col-md-3">
                          <p>No. de nota</p>
                        </div>
                        <div class="col-md-9">
                          <input type="text" name="id-note" id="id-note" class="form-control-plaintext input-sm" value="0" readonly>
                        </div>
                      </div>
                    </div>
                  </div>                  
                </div>
              </div>
              <div class="col-md-12 mb-4" style="border-top: 1px #D5D8DC solid">
                <p class="mt-2">Ingresar comentario de la nota</p>
                <div class="col-md-12">
                  <textarea name="coment" id="coment" class="form-control" rows="3" placeholder="Ingrese comentario aquí."></textarea>
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
                    <div style="width: 550px; height: 400px; overflow-y: auto; display: inline-block; vertical-align: top;">
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
                                  <?php foreach($data as $dca){ ?>
                                    <tr>
                                      <td class="text-center"><input type="checkbox" class="check-<?= strtolower($rename); ?>" name="person-selected[]" value="<?=$dca->idPersona?>"></td>
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
            </div>
          </div>
        </form>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default close-modal" data-dismiss="modal">Cerrar</button>
        <button type="button" class="btn btn-primary create-note">Crear nota</button>
      </div>
    </div>
  </div>
</div>