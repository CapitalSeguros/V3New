<section class="container-fluid">
    <table class="table table-striped issue-tracker" id="tbPip">
        <tbody>
            <?php $own=0?>
            <?php foreach ($pips as $key => $value) : ?>
                <?php 
                    if($this->tank_auth->get_idPersona() == $value["empleado_id"] &&  $value["estatus"]=="BORRADOR"){
                        $own++;
                    }
                ?>
                <?php if ($this->tank_auth->get_idPersona()==$value['empleado_id'] && $value['estatus']=="BORRADOR" ) : ?>

                <?php else : ?>
                <tr id="PIP_<?=$value["id"]?>">
                    <td class="issue-info">
                        <b>  Seguimiento a :</b> <?= $value["nombre"] ?> <br>
                        <b>Fecha:</b> <?=date('d/m/Y', strtotime($value["created"]))?> <b> Periodo:  </b><?= $value["titulo"]==''?'Sin periodo':$value["titulo"] ?>. <b>Estatus: </b><?= $value["estatus"] ?>
                       
                    </td>
                    <td width="70">
                        <div style="text-align: center;">
                            <div class="dropdown">
                                <button class="btn btn-link dropdown-toggle" type="button" id="dpPIP<?= $value["id"] ?>" data-toggle="dropdown" aria-haspopup="true" aria-expanded="true">
                                    <i class="fa fa-ellipsis-v" aria-hidden="true"></i>
                                </button>
                                <ul class="dropdown-menu dropdown-menu-right" aria-labelledby="dpPIP<?= $value["id"] ?>">
                                    <li><a href="<?= base_url() . "PIP/MonitoreoPIP?id=".$value["id"] ?>" style="cursor: pointer;" data-in-id="<?= $value["id"] ?>">Seguimiento</a></li>
                                    <?php if ($this->tank_auth->get_idPersona() != $value["empleado_id"]) : ?>
                                        <li><a href="<?= base_url() . "PIP/AgregarPIP?id=".$value["empleado_id"]."&idp=".$value["id"]."&idpp=0" ?>" style="cursor: pointer;" data-in-id="<?= $value["id"] ?>">Editar</a></li>
                                        <li><a onclick="clickDeletePIP(<?= $value['id'] ?>)" style="cursor: pointer;" data-in-id="<?= $value["id"] ?>">Eliminar</a></li>
                                    <?php endif; ?>
                                    
                                </ul>
                            </div>
                        </div>
                    </td>
                </tr>
                <?php endif; ?>
            <?php endforeach ?>
            <?php if ($own== count($pips)) : ?>
                <tr>
                    <td class="issue-info">
                        No hay registros de seguimiento
                    </td>
                </tr>
            <?php endif; ?>
        </tbody>
    </table>
</section>