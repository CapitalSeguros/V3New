        
    <?php if($estado == "pendiente"){?>

        <h6 class="text-center liga">Datos de conexión</h6>
        <p>Para obtener la liga de reunión favor de indicar que acepta participar en la reunión presentado anteriormente.</p>
        <div class="row">
            <div class="col-md-6">
                <select name="aceptacion" id="aceptacion" class="form-control" data-invitado="<?=$invitado?>">
                    <option value="0">Seleccione</option>
                    <option value="aceptado">Aceptar participación</option>
                    <option value="rechazado">Rechazar participación</option>
                </select>
             </div>
            <div class="col-md-6"><button class="btn btn-primary btn-sm" id="confirma">Confirmar</button></div>
        </div>

    <?php } elseif($estado == "aceptado"){?>

        <h6 class="text-center liga">Datos de conexión</h6>
        <div class="row">
            <div class="col-md-6">Liga de Zoom:</div>
            <div class="col-md-6"><a href="<?=$liga?>" target="_blank" rel="noopener noreferrer"><?=$liga?></a></div>
        </div>
        <div class="row">
            <div class="col-md-6">ID:</div>
            <div class="col-md-6"><?=$idReunion?></div>
        </div>
        <div class="row">
            <div class="col-md-6">Contraseña:</div>
            <div class="col-md-6"><?=$contrasena?></div>
        </div><!--idReunion-->
        <div class="row">
            <div class="col-md-6">
                <div class="dropdown">
                    <a class="dropdown-toggle text-info" href="javascript: void(0)" id="dropdown-calendar" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">Agendar al calendario</a>
                    <div class="dropdown-menu">
                        <a class="dropdown-item icsFile" href="javascript: void(0)" data-event="<?=$evento?>" data-type="<?=$tipo?>" data-guest="<?=$invitado?>">Descargar .ics para Outlook</a>
                    </div>
                </div>
            </div>
        </div>

    <?php } elseif($estado == "rechazado"){?>
        <h6 class="text-center liga">Datos de conexión</h6>
        <div class="text-center"><p class="text-danger">Usted ha rechazado la invitación a la reunión.</p></div>
    <?php }?>