<?php 
    $this->load->view("capacita/menu_capacita");
?>
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">

<div class="container">
    <h4 class="mt-3">Edición de registro de capacitación.</h4>
    <small>Edite la informacion del registro de capacitación del usuario. Llene todos los campos pertinentes</small>
    <div class="card card-body mt-4">
        <p class="text-danger">Campos obligatorios: *</p>
        <form id="form-edit" data-form="<?=$datosCapacitacion->tipoRegistro?>">
            <div class="col-md-12">
                <div class="row">
                    <div class="col-md-2">Nombre</div>
                    <div class="col-md-8"><?=$datosCapacitacion->nombres." ".$datosCapacitacion->apellidoPaterno." ".$datosCapacitacion->apellidoMaterno?></div>
                </div>
                <div class="row">
                    <div class="col-md-2">Correo</div>
                    <div class="col-md-8"><?=$datosCapacitacion->email?></div>
                </div>
                <div class="row">
                    <div class="col-md-2">No. registro</div>
                    <div class="col-md-8"><input type="number" class="form-control-plaintext" name="idRegistro" id="idRegistro" readonly value="<?=$datosCapacitacion->idRegistro?>"></div>
                </div>
                <hr>
                <h6>Datos generales</h6>
                <div class="row mt-4">
                    <div class="col-md-4">
                        <div class="form-group row">
                            <label for="capacitacion" class="col-md-5">Capacitación<span class="text-danger">*</span></label>
                            <div class="col-md-6">
                                <select name="capacitacion" id="capacitacion" class="form-control form-control-sm" required>
                                    <option value="0">Seleccione</option>
                                    <?php foreach($capacitacion as $d_c){?> 
                                        <option value="<?=$d_c->id_capacitacion?>" <?=($d_c->id_capacitacion == $datosCapacitacion->id_capacitacion) ? "selected" : ""?>><?=$d_c->tipoCapacitacion?></option>
                                    <?php }?>
                                </select>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-group row">
                            <label for="sub-capacitacion" class="col-md-5">Sub-capacitación <span class="text-danger">*</span></label>
                            <div class="col-md-6">
                                <select name="sub-capacitacion" id="sub-capacitacion" class="form-control form-control-sm" required>
                                    <option value="0">Seleccione</option>
                                    <option value="<?=$datosCapacitacion->id_certificado?>" selected><?=$datosCapacitacion->nombreCertificado?></option>
                                </select>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-group row">
                            <label for="ramo" class="col-md-5">Ramo <span class="text-danger">*</span></label>
                            <div class="col-md-6">
                                <select name="ramo" id="ramo" class="form-control form-control-sm" required>
                                    <option value="0">Seleccione</option>
                                    <?php foreach($ramo as $d_r){?> 
                                        <option value="<?=$d_r->idR?>" <?=($d_r->idR == $datosCapacitacion->idR) ? "selected" : ""?>><?=strtoupper($d_r->nombre_ramo)?></option>
                                    <?php }?>
                                </select>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-group row">
                            <label for="ramo" class="col-md-5">Horas <span class="text-danger">*</span></label>
                            <div class="col-md-4">
                                <input type="number" class="form-control" name="horas" id="horas" value="<?=$datosCapacitacion->horas?>" required>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group row">
                            <label for="creador" class="col-md-3">Creador<span class="text-danger">*</span></label>
                            <div class="col-md-6">
                                <input type="text" name="creador" id="creador" value="<?=$datosCapacitacion->creadorAlta?>" class="form-control-sm form-control-plaintext"  readonly>
                            </div>
                        </div>
                    </div>
                </div>
                <hr>
                <?php if($datosCapacitacion->tipoRegistro == "externo"){?>
                <div class="col-md-8">
                    <h6>Capacitación registrada de manera externa</h6>
                    <div class="form-group row">
                        <label for="creador" class="col-md-3">Archivo<span class="text-danger">*</span></label>
                        <div class="col-md-8">
                            <input type="file" name="archivo" id="archivo" value="<?=$anexos->archivo?>" class="form-control" required>
                        </div>
                        <input type="hidden" 
                            data-url="<?=base_url()?>" 
                            id="base_url" 
                            data-archivo="<?=$anexos->archivo?>" 
                            data-idPersona="<?=$datosCapacitacion->idPersona?>"
                            data-capacitacion="<?=$datosCapacitacion->tipoCapacitacion?>"
                            data-subcapacitacion="<?=$datosCapacitacion->nombreCertificado?>"
                            data-ramo="<?=str_replace("daños", "danios", $datosCapacitacion->nombre_ramo)?>"
                        >
                        <div>
                            <h6>Progreso</h6>
                            <div class="bajaArchivo"></div>
                            <div class="subidaArchivo"></div>
                            <div class="actualizaInformacion"></div>
                            <div class="completado"></div>
                        </div>
                    </div>
                </div>
                <?php } elseif($datosCapacitacion->tipoRegistro == "interno"){?>
                    <div>
                        <h6>Capacitación registrada de manera interna</h6>
                        <div class="row mt-4">
                            <div class="col-md-4">
                                <h6>Seleccione a un responsable</h6>
                                <div class="col-md-12 mt-4">
                                    <select name="responsable_" id="responsable_" class="form-control">
                                        <option value="0">Seleccione</option>
                                        <?php foreach($puestos_y_personas as $group => $people){?>
                                            <optgroup label="<?=$group?>">
                                                <?php foreach($people as $d_p){?>
                                                    <option value="<?=$d_p->idPersona?>"><?=$d_p->nombres." ".$d_p->apellidoPaterno." ".$d_p->apellidoMaterno." (".$d_p->email.")"?></option>
                                                    <?php }?>
                                            </optgroup>
                                        <?php }?>
                                    </select>
                                </div>
                                <div class="text-center col-md-12 mt-4">
                                    <button class="btn btn-primary add">Anexar a la lista</button>
                                </div>
                            </div>
                            <div class="col-md-8 table-responsive">
                                <h6>Responsables seleccionados</h6>
                                <table class="table" id="table-responsable">
                                    <thead>
                                        <tr>
                                            <th>Activo</th>
                                            <th>Nombre</th>
                                            <th>Correo</th>
                                            <th>Opciones</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php foreach($anexos as $d_a){?>
                                            <tr class="<?=$d_a["idPersona"]?>">
                                                <td class="text-center"><input type="checkbox" name="responsable[]" id="resposable-<?=$d_a["idPersona"]?>" value="<?=$d_a["idPersona"]?>" data-responsable="noNuevo" checked disabled></td>
                                                <td><?=$d_a["nombre"]?></td>
                                                <td><?=$d_a["email"]?></td>
                                                <td class="text-center"><a class="text-danger delete" href="javascript: void(0)" data-id="<?=$d_a["idPersona"]?>" data-register="<?=$d_a["DNI"]?>">Eliminar</a></td>
                                            </tr>    
                                        <?php }?>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                    <input type="hidden" data-url="<?=base_url()?>" id="base_url" >
                <?php }?>
            </div>
            <hr>
            <div class="text-center"><button class=" btn btn-info" id="send">Actualizar registro</button></div>
        </form>
    </div>
</div>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.2/jquery.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>
<script src="https://www.gstatic.com/firebasejs/8.8.1/firebase-app.js"></script>
<script src="https://www.gstatic.com/firebasejs/8.8.1/firebase-auth.js"></script>
<script src="https://www.gstatic.com/firebasejs/8.8.1/firebase-storage.js"></script>
<script src="<?=base_url()."assets/js/jQuery.editarCapacitacion.js"?>"></script>

