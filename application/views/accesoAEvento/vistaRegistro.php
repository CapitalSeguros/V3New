<h6 class="text-center liga">Registro al evento</h6>

<?php if($solicitud == 1){?>
<p>Para tener el acceso al evento favor de llenar el siguiente formulario</p>
<div class="text-center">
    <button class="btn btn-primary btn-sm" data-toggle="modal" data-target=".bd-registro-modal-lg">Registrarme</button>
</div>

<div class="modal fade bd-registro-modal-lg" id="modalRegistro" tabindex="-1" role="dialog" aria-labelledby="registroLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="registroLabel">Registro al evento</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <form id="formRegistro">
            <p>Llene el formulario para enviar la petición al organizador del evento</p>
            <div class="card card-body">
                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group row">
                            <label for="nombre" class="col-md-4">Nombre</label>
                            <div><input type="text" class="form-control" name="nombre" id="nombre" required></div>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group row">
                            <label for="nombre" class="col-md-4">Apellido paterno</label>
                            <div><input type="text" class="form-control" name="apellidoP" id="apellidoP" required></div>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group row">
                            <label for="nombre" class="col-md-4">Apellido materno</label>
                            <div><input type="text" class="form-control" name="apellidoM" id="apellidoM" required></div>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group row">
                            <label for="nombre" class="col-md-4">Correo electrónico</label>
                            <div><input type="email" name="correo" id="correo" class="form-control" required></div>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group row">
                            <label for="nombre" class="col-md-4">Telefóno</label>
                            <div><input type="tel" name="telefono" id="telefono" class="form-control" required></div>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group row">
                            <label for="nombre" class="col-md-4">Ciudad</label>
                            <div><input type="text" class="form-control" name="ciudad" id="ciudad" required></div>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group row">
                            <label for="nombre" class="col-md-4">Organización</label>
                            <div><input type="text" class="form-control" name="organizacion" id="organizacion" required></div>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group row">
                            <label for="nombre" class="col-md-4">Puesto</label>
                            <div><input type="text" class="form-control" name="puesto" id="puesto" required></div>
                        </div>
                    </div>
                </div>
            </div>
            <input type="hidden" name="evento" id="evento" value="<?=$evento?>">
            <input type="hidden" name="tipo" id="tipo" value="<?=$tipo?>">
            <input type="hidden" name="invitado" id="invitado" value="<?=$invitado?>">
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary btn-sm" data-dismiss="modal">Cerrar</button>
        <button type="submit" class="btn btn-primary btn-sm" >Registrarme</button>
      </div>
      </form>
    </div>
  </div>
</div>
<?php } else{ ?>
    <p>Su solicitud ha sido enviada. Espere la respuesta del organizador</p>
    <?php }?>