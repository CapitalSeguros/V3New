<link rel="stylesheet" href="<?=base_url()?>assets/gap/css/registros.css">
<script src="<?=base_url()?>/assets/gap/js/jquery.validate.js"></script>
<?php
    if(!empty($registro)){

        $complemento=(array)json_decode($registro[0]['complemento_json']);
        //var_dump($registro);
    }
?>
<section class="container-fluid breadcrumb-formularios">
    <a id="N" data-IdNotificacion='<?= $idNotificacion; ?>'></a>
    <div class="row">
        <div class="col-md-6 col-sm-5 col-xs-5">
            <h3 class="titulo-secciones"><?=$titulo?> Siniestro de Autos Coporativo</h3>
        </div>
        <div class="col-md-6 col-sm-7 col-xs-7 d-flex">
            <?= $breadcrumbs; ?>
        </div>
    </div>
    <hr />
</section>
<section class="container">
    <div style="float: left; width: 100%;">
        <div class="panel panel-default">
            <form action="<?= base_url() ?>Siniestros/AccionesAutos" method="POST" id="form_gmm" name="form_gmm" data-toggle="validator" autocomplete="off">
                <div class="panel-body">
					<div class="row">
                        <div class="col-lg-12">
                            <strong><p>Datos de la poliza</p><hr></strong>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-12">
                            <div class="form-group">
                                <label for="exampleInputEmail1">Nombre</label>
                                <input  type="text" class="form-control" id="nombres" name="nombres" placeholder="Nombres" value="<?=isset($registro[0]['asegurado_nombre'])?$registro[0]['asegurado_nombre']:''?>" readonly  />
                            </div>
                        </div>
                        <div class="col-lg-4">
                            <div class="form-group">
                                <label for="exampleInputEmail1">Número de Poliza</label>
                                <input  type="text" class="form-control" id="numero_poliza" name="numero_poliza" placeholder="Número de Poliza" value="<?=isset($registro[0]['poliza'])?$registro[0]['poliza']:''?>" readonly />
                            </div>
                        </div>
                        <div class="col-lg-4">
                            <div class="form-group">
                                <label for="exampleInputEmail1">Certificado</label>
                                <input type="text" class="form-control" id="Certificado" name="Certificado" placeholder="Certificado" value="<?=isset($registro[0]['certificado'])?$registro[0]['certificado']:''?>" readonly />
                            </div>
                        </div>
                        <div class="col-lg-4">
                            <div class="form-group">
                                <label for="exampleInputEmail1">Paquete</label>
                                <input  type="text" class="form-control" id="Paquete" name="Paquete" placeholder="Paquete" value=" <?=isset($registro[0]['paquete_descripcion'])?$registro[0]['paquete_descripcion']:''?>" readonly />
                            </div>
                        </div>
                        <div class="col-lg-4">
                            <div class="form-group">
                                <label for="exampleInputEmail1">Económico</label>
                                <input onkeyup="javascript:this.value=this.value.toUpperCase();" type="text" class="form-control" id="economico" name="economico" placeholder="Economico" value="<?=isset($complemento['general']->economico)?$complemento['general']->economico:''?>" />
                                <span class="error" id="e_economico"></span>
                            </div>
                        </div>
                        <div class="col-lg-4">
                            <div class="form-group">
                                <label for="exampleInputEmail1">Vehiculo</label>
                                <input onkeyup="javascript:this.value=this.value.toUpperCase();" type="text" class="form-control" id="vehiculo" name="vehiculo" placeholder="Vehiculo" value="<?=isset($complemento['general']->vehiculo)?$complemento['general']->vehiculo:''?>" />
                                <span class="error" id="e_vehiculo"></span>
                            </div>
                        </div>
                        <div class="col-lg-4">
                            <div class="form-group">
                                <label for="exampleInputEmail1">Módelo</label>
                                <input onkeyup="javascript:this.value=this.value.toUpperCase();" type="text" class="form-control" id="modelo" name="modelo" placeholder="Módelo" value="<?=isset($complemento['general']->modelo)?$complemento['general']->modelo:''?>" />
                                <span class="error" id="e_modelo"></span>
                            </div>
                        </div>
                        <div class="col-lg-4">
                            <div class="form-group">
                                <label for="exampleInputEmail1">Serie</label>
                                <input onkeyup="javascript:this.value=this.value.toUpperCase();" type="text" class="form-control" id="serie" name="serie" placeholder="Serie" value="<?=isset($complemento['general']->vehiculo)?$complemento['general']->vehiculo:''?>" />
                                <span class="error" id="e_serie"></span>
                            </div>
                        </div>
                        
                    </div>
                    <div class="row">
                        <div class="col-lg-12 text-center">
                            <span class="error" id="e_json_poliza"></span>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-lg-12">
                            <strong><p>Datos del siniestro</p><hr></strong>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-lg-4">
                            <div class="form-group" id="g_numero_siniestro">
                                <label class="control-label" for="numero_siniestro">Número del siniestro </label>
                                <input onkeyup="javascript:this.value=this.value.toUpperCase();"  type="text" class="form-control" id="numero_siniestro" name="numero_siniestro" placeholder="Número del siniestro" value="<?=isset($registro[0]['siniestro_id'])?$registro[0]['siniestro_id']:''?>" readonly />
                                <input type="text" class="form-control" name="id" id="id" style="display:none" value="<?=isset($registro[0]['id'])?$registro[0]['id']:''?>" />
                                <span class="error" id="e_numero_siniestro"></span>
                            </div>
                            
                        </div>
                        <div class="col-lg-4">
                            <div class="form-group" id="g_numero_siniestro">
                                <label class="control-label" for="numero_siniestro">Num Cabina </label>
                                <input onkeyup="javascript:this.value=this.value.toUpperCase();"  type="text" class="form-control" id="numero_siniestro" name="numero_siniestro" placeholder="Número del siniestro" value="<?=isset($registro[0]['cabina_id'])?$registro[0]['cabina_id']:''?>" readonly />
                            </div>
                            
                        </div>
                        <div class="col-lg-4" id="g_fecha_aviso">
                            <div class="form-group">
                                <?php 
                                    $fecha=date("Y-m-d");
                                ?>
                                <label for="exampleInputEmail1">Fecha inicio</label>
                                <input  type="date" class="form-control" id="fecha_aviso" name="fecha_aviso" placeholder="Fecha del aviso" max="<?=$fecha?>" value="<?=isset($registro[0]['fecha_repote'])?date("Y-m-d", strtotime($registro[0]['fecha_repote'])):''?>" readonly />
                                <span class="error" id="e_fecha_aviso"></span>
                              <!--   <span class="error" class="help-block">Please correct the error</span> -->
                            </div>
                        </div>
                        <div class="col-lg-4">
                            <div class="form-group" id="g_numero_siniestro">
                                <label class="control-label" for="numero_siniestro">Tipo de siniestro</label>
                                <input  type="text" class="form-control" id="tipo" name="tipo" placeholder="Fecha del aviso"  value="<?=isset($registro[0]['sub_evento'])?strtoupper($registro[0]['sub_evento']):''?>" readonly />
                                <span class="error" id="e_tipo_siniestro"></span>
                            </div>
                        </div>
                        <div class="col-lg-4">
                            <div class="form-group" id="g_numero_siniestro">
                                <label class="control-label" for="numero_siniestro">Causa</label>
                                <input  type="text" class="form-control" id="causa" name="causa" placeholder="Fecha del aviso"  value="<?=isset($registro[0]['causa_nombre'])?strtoupper($registro[0]['causa_nombre']):''?>" readonly />
                                <span class="error" id="e_causa"></span>
                            </div>
                        </div>
                        <div class="col-lg-4">
                            <div class="form-group" id="g_numero_siniestro">
                                <label class="control-label" for="numero_siniestro">Estado de ocurrencia</label>
                                <select name="estado" id="estado" class="form-control" disabled="true" readonly >
                                    <option value="">Seleccione uno</option>
                                    <?php foreach($estados as $value): 
                                         $est=isset($registro[0]['estado_id'])?$registro[0]['estado_id']:'';
                                        ?>
                                    <option value="<?=$value['clave'] ?>" <?=$value['clave']==$est?'selected':''?>><?=$value['estado'] ?></option>
                                    <?php endforeach; ?>
                                </select>
                                <span class="error" id="e_estado"></span>
                            </div>
                        </div>
                        <div class="col-lg-4">
                            <div class="form-group" id="g_numero_siniestro">
                                <label class="control-label" for="numero_siniestro">Autoridad presente</label>
                                <input  type="text" class="form-control" id="autoridad" name="autoridad" placeholder="Fecha del aviso"  value="<?=isset($registro[0]['autoridad_nombre'])?strtoupper($registro[0]['autoridad_nombre']):''?>" readonly/>
                                <span class="error" id="e_tipo_autoridad"></span>
                            </div>
                        </div>
                        <div class="col-lg-4">
                            <div class="form-group" id="g_numero_siniestro">
                                <label class="control-label" for="numero_siniestro">Tipo autoridad</label>
                                <input  type="text" class="form-control" id="segunAutoridad" name="segunAutoridad" placeholder="Fecha del aviso"  value="<?=isset($registro[0]['segunAutoridad'])?strtoupper($registro[0]['segunAutoridad']):''?>" readonly/>
                                <span class="error" id="e_autoridad_presente"></span>
                            </div>
                        </div>
                       
                        <div class="col-lg-4">
                            <div class="form-group" id="g_numero_siniestro">
                                <label class="control-label" for="numero_siniestro">Tipo ajustador</label>
                                <input  type="text" class="form-control" id="autoridad" name="autoridad" placeholder="Fecha del aviso"  value="<?=isset($registro[0]['segunAjustador'])?strtoupper($registro[0]['segunAjustador']):''?>" readonly />
                                <span class="error" id="e_tipo_ajustador"></span>
                            </div>
                        </div>
                        <div class="col-lg-4">
                            <div class="form-group">
                                <label for="exampleInputEmail1">Responsabilidad</label>
                               <!--  <input onkeyup="javascript:this.value=this.value.toUpperCase();" type="text" class="form-control" id="afectado" name="afectado" placeholder="Afectado" value="<?=isset($complemento['general']->afectado)?$complemento['general']->afectado:''?>" /> -->
                                <select name="afectado" id="afectado" class="form-control">
                                    <option value='' >Seleccione una opcion</option>
                                    <option value="AFECTADO" <?=isset($complemento['general']->afectado)?($complemento['general']->afectado=="AFECTADO"?'selected':''):''?> >AFECTADO</option>
                                    <option value="RESPONSABLE" <?=isset($complemento['general']->afectado)?($complemento['general']->afectado=="RESPONSABLE"?'selected':''):''?>>RESPONSABLE</option>
                                </select>
                                <span class="error" id="e_afectado"></span>
                            </div>
                        </div>
                        <div class="col-lg-4">
                            <div class="form-group">
                                <label for="exampleInputEmail1">Valor Unidad</label>
                                <input onBlur="fomatValue(this.value)"  type="text" class="form-control numeric" id="valor_unidad" name="valor_unidad" placeholder="Valor Unidad" value="<?=isset($complemento['general']->valor_unidad)?$complemento['general']->valor_unidad:''?>" />
                                <span class="error" id="e_valor_unidad"></span>
                            </div>
                        </div>
                        <div class="col-lg-4">
                            <div class="form-group">
                                <label for="exampleInputEmail1">Deducible</label>
                                <input onkeyup="javascript:this.value=this.value.toUpperCase();" type="text" class="form-control numeric" id="deducible" name="deducible" placeholder="Deducible" value="<?=isset($complemento['general']->deducible)?$complemento['general']->deducible:''?>" />
                                <span class="error" id="e_deducible"></span>
                            </div>
                        </div>
                        <div class="col-lg-4">
                            <div class="form-group">
                                <label for="exampleInputEmail1">Estatus Deducible</label>
                                <input onkeyup="javascript:this.value=this.value.toUpperCase();" type="text" class="form-control" id="estatus_deducible" name="estatus_deducible" placeholder="Estatus Deducible" value="<?=isset($complemento['general']->estatus_deducible)?$complemento['general']->estatus_deducible:''?>" />
                                <span class="error" id="e_estatus_deducible"></span>
                            </div>
                        </div>
                        <div class="col-lg-4">
                            <div class="form-group">
                                <label for="exampleInputEmail1">Tipo Recuperacion</label>
                                <input onkeyup="javascript:this.value=this.value.toUpperCase();" type="text" class="form-control" id="tipo_recuperacion" name="tipo_recuperacion" placeholder="Tipo Recuperacion" value="<?=isset($complemento['general']->tipo_recuperacion)?$complemento['general']->tipo_recuperacion:''?>" />
                                <span class="error" id="e_tipo_recuperacion"></span>
                            </div>
                        </div>
                        <div class="col-lg-4">
                            <div class="form-group">
                                <label for="exampleInputEmail1">Importe Reserva</label>
                                <input onkeyup="javascript:this.value=this.value.toUpperCase();" type="text" class="form-control numeric" id="importe_reserva" name="importe_reserva" placeholder="Importe Reserva" value="<?=isset($complemento['general']->importe_reserva)?$complemento['general']->importe_reserva:''?>" />
                                <span class="error" id="e_importe_reserva"></span>
                            </div>
                        </div>
                        <div class="col-lg-12">
                            <div class="form-group">
                                <label for="exampleInputEmail1">Lugar del Accidente</label>
                                <input onkeyup="javascript:this.value=this.value.toUpperCase();" type="text" class="form-control" id="lugar" name="lugar" placeholder="Lugar del Accidente" value="<?=isset($complemento['general']->lugar)?$complemento['general']->lugar:''?>" />
                                <span class="error" id="e_lugar"></span>
                            </div>
                        </div>
                    </div>
                   <!--  <div class="row">
                        <div class="col-lg-12">
                            <strong><p>Otros datos</p><hr></strong>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-lg-4">
                            <div class="form-group">
                                <label for="exampleInputEmail1">Vehiculo</label>
                                <input onkeyup="javascript:this.value=this.value.toUpperCase();" type="text" class="form-control" id="vehiculo" name="vehiculo" placeholder="Vehiculo" value="<?=isset($complemento['general']->vehiculo)?$complemento['general']->vehiculo:''?>" />
                                <span class="error" id="e_vehiculo"></span>
                            </div>
                        </div>
                        <div class="col-lg-4">
                            <div class="form-group">
                                <label for="exampleInputEmail1">Serie</label>
                                <input onkeyup="javascript:this.value=this.value.toUpperCase();" type="text" class="form-control" id="serie" name="serie" placeholder="Serie" value="<?=isset($complemento['general']->vehiculo)?$complemento['general']->vehiculo:''?>" />
                                <span class="error" id="e_serie"></span>
                            </div>
                        </div>
                        <div class="col-lg-4">
                            <div class="form-group">
                                <label for="exampleInputEmail1">Lugar del Accidente</label>
                                <input onkeyup="javascript:this.value=this.value.toUpperCase();" type="text" class="form-control" id="lugar" name="lugar" placeholder="Lugar del Accidente" value="<?=isset($complemento['general']->lugar)?$complemento['general']->lugar:''?>" />
                                <span class="error" id="e_lugar"></span>
                            </div>
                        </div>
                        <div class="col-lg-4">
                            <div class="form-group">
                                <label for="exampleInputEmail1">Afectado/Responsable</label>
                                <input onkeyup="javascript:this.value=this.value.toUpperCase();" type="text" class="form-control" id="afectado" name="afectado" placeholder="Afectado" value="<?=isset($complemento['general']->afectado)?$complemento['general']->afectado:''?>" />
                                <span class="error" id="e_afectado"></span>
                            </div>
                        </div>
                    </div> -->
                    <div class="row">
                        <div class="col-lg-12">
                            <strong><p>Datos del supervisor de calidad</p><hr></strong>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-lg-4">
                            <div class="form-group">
                                <label for="exampleInputEmail1">Nombre</label>
                                <input onkeyup="javascript:this.value=this.value.toUpperCase();" type="text" class="form-control" id="nombre_coordinador" name="nombre_coordinador" placeholder="Nombre" value="<?=isset($complemento['cordinador']->nombre_coordinador)?$complemento['cordinador']->nombre_coordinador:''?>" />
                            </div>
                        </div>
                        <div class="col-lg-4">
                            <div class="form-group">
                                <label for="exampleInputEmail1">Telefono</label>
                                <input  type="tel" maxlength="10" class="form-control numeric" id="telefono_coordinador" name="telefono_coordinador" placeholder="Telefono" value="<?=isset($complemento['cordinador']->telefono_coordinador)?$complemento['cordinador']->telefono_coordinador:''?>" />
                            </div>
                        </div>
                        <div class="col-lg-4">
                            <div class="form-group">
                                <label for="exampleInputEmail1">Correo electronico</label>
                                <input  type="email" class="form-control" id="correo_coordinador" name="correo_coordinador" placeholder="Correo electronico" value="<?=isset($complemento['cordinador']->correo_coordinador)?$complemento['cordinador']->correo_coordinador:''?>" />
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-12" style="padding-top:10px;">
                            <button type="submit" class="btn btn-primary pull-right">Guardar</button>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>

</section>

<script src="<?=base_url()?>assets/gap/js/registro_autos_c.js"></script>
