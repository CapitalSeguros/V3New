<link rel="stylesheet" href="<?=base_url()?>assets/gap/css/registros.css">
<script src="<?=base_url()?>assets/gap/js/jquery.validate.js"></script>
<script src="<?=base_url()?>assets/js/jquery.easytree.min.js"></script>
<?php
    if(!empty($registro)){
        /* var_dump($registro); */
        $poliza=(array)json_decode($registro[0]['data_poliza']);
        $complemento=(array)json_decode($registro[0]['complemento_json']);
        
    }
    if(isset($Poliza_Carga->TableInfo)){
        $poliza=(array)$Poliza_Carga->TableInfo;
    }
    //var_dump($Poliza_Carga);
?>
<section class="container-fluid breadcrumb-formularios">
    <a id="N" data-IdNotificacion='<?= $idNotificacion; ?>'></a>
    <div class="row">
        <div class="col-md-6 col-sm-5 col-xs-5">
            <h3 class="titulo-secciones"><?=$titulo?> Siniestro de autos</h3>
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
        <!-- <?var_dump($registro)?> -->
            <form action="<?= base_url() ?>Autos/AccionesAutos" method="POST" id="form_gmm" name="form_gmm" data-toggle="validator" autocomplete="off">
                <div class="panel-body">
                    <div class="row">
                       <!--  <div class="col-lg-6">
                            <strong><em><p><span class="fa fa-info-circle"></span> Opción para buscar una poliza</p></em></strong>
                        </div> -->
                       
                        <div class="col-lg-12"><!-- data-toggle="modal" data-target="#modal_tipos" -->
                        <?php if(empty($poliza)) : ?>
                            <a class="btn btn-primary pull-right" id='open'><span class="fa fa-search" ></span> Buscar póliza</a>
                        <?php endif; ?>
                            <a class="btn btn-primary pull-right" id='open_d'><span class="fa fa-eye" ></span> Datos póliza</a>
                        </div>
                       
                    </div>
                    <div class="row">
                        <div class="col-lg-12">
                            <strong><p>Datos del asegurado</p><hr></strong>
                            <input type="hidden" id="json_poliza" name="json_poliza"  value='<?=isset($poliza)?json_encode($poliza):""?>'/>
                            <input type="hidden" id='idsicascliente' name='idsicascliente'  value='<?=isset($poliza['IDCli'])?$poliza['IDCli']:''?>'>
                            <input type="hidden" id='idsicasvendedor' name='idsicasvendedor' value='<?=isset($poliza['IDVend'])?$poliza['IDVend']:""?>'>
                            <input type="hidden" id='aseguradora_id' name='aseguradora_id' value='<?=isset($poliza['IDCia'])?$poliza['IDCia']:""?>'>
                            <input type="hidden" id='fecha_fin' name='fecha_fin'>
                            
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-4">
                            <div class="form-group">
                                <label for="exampleInputEmail1">Nombre</label>
                                <input  type="text" class="form-control" id="nombres" name="nombres" placeholder="Nombres" value="<?=isset($poliza['NombreCompleto'])?$poliza['NombreCompleto']:''?>" readonly />
                            </div>
                        </div>
                        <div class="col-lg-4">
                            <div class="form-group">
                                <label for="exampleInputEmail1">Telefono</label>
                                <!--  -->
                                <input  type="text" class="form-control" id="telefono_asegurado" name="telefono_asegurado" placeholder="Telefono" value="<?=isset($poliza['Telefono1'])?(is_object($poliza['Telefono1'])?'':$poliza['Telefono1']):''?>" readonly />
                            </div>
                        </div>
                        <div class="col-lg-4">
                            <div class="form-group">
                                <label for="exampleInputEmail1">Correo electronico</label>
                                <input type="text" class="form-control" id="correo_asegurado" name="correo_asegurado" placeholder="Correo electronico" value="<?=isset($poliza['EMail1'])?is_object($poliza['EMail1'])?'':$poliza['EMail1']:''?>" readonly/>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-lg-12">
                            <strong><p>Datos de la poliza</p><hr></strong>
                        </div>
                    </div>
                    <div class="row">
                    <div class="col-lg-4">
                            <div class="form-group">
                                <label for="exampleInputEmail1">Número de Poliza</label>
                                <input  type="text" class="form-control" id="numero_poliza" name="numero_poliza" placeholder="Número de Poliza" value="<?=isset($poliza['Documento'])?$poliza['Documento']:''?>" readonly />
                            </div>
                        </div>
                        <div class="col-lg-4">
                            <div class="form-group">
                                <label for="exampleInputEmail1">Inciso</label>
                                <input type="text" class="form-control" id="inciso_p" name="inciso_p" placeholder="Inciso" value="<?=isset($poliza['ejecutivo'])?$poliza['ejecutivo']:''?>" readonly />
                            </div>
                        </div>
                        <div class="col-lg-4">
                            <div class="form-group">
                                <label for="exampleInputEmail1">Compañia de seguros</label>
                                <input  type="text" class="form-control" id="compania_seguros" name="compania_seguros" placeholder="Compañia de seguros" value=" <?=isset($poliza['CiaNombre'])?$poliza['CiaNombre']:''?>" readonly />
                            </div>
                        </div>
                        <div class="col-lg-4">
                            <div class="form-group">
                                <label for="exampleInputEmail1">Ejecutivo</label>
                                <input type="text" class="form-control" id="ejecutivo" name="ejecutivo" placeholder="Ejecutivo" value="<?=isset($poliza['EjecutNombre'])?$poliza['EjecutNombre']:''?>" readonly />
                            </div>
                        </div>
                        <div class="col-lg-4">
                            <div class="form-group">
                                <label for="exampleInputEmail1">Grupo</label>
                                <input type="text" class="form-control" id="grupo" name="grupo" placeholder="Grupo" value="<?=isset($poliza['Grupo'])?$poliza['Grupo']:''?>" readonly />
                            </div>
                        </div>
                        <div class="col-lg-4">
                            <div class="form-group">
                                <label for="exampleInputEmail1">Sub Grupo</label>
                                <input type="text" class="form-control" id="sub_grupo" name="sub_grupo" placeholder="Sub Grupo" value="<?=isset($poliza['SubGrupo'])?$poliza['SubGrupo']:''?>" readonly />
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-lg-4">
                            <div class="form-group">
                                <label for="exampleInputEmail1">Sub Ramo</label>
                                <input type="text" class="form-control" id="sub_ramo" name="sub_ramo" placeholder="Sub Ramo" value="<?=isset($poliza['SRamoNombre'])?$poliza['SRamoNombre']:''?>" readonly />
                            </div>
                        </div>
                        <div class="col-lg-4">
                            <div class="form-group">
                                <label for="exampleInputEmail1">Estatus</label>
                                <input  type="text" class="form-control" id="estatus_poliza" name="estatus_poliza" placeholder="Estatus" value="<?=isset($poliza['Status_TXT'])?$poliza['Status_TXT']:''?>" readonly />
                            </div>
                        </div>
                        <div class="col-lg-4">
                            <div class="form-group">
                                <label for="tipo_cobertura">Tipo de poliza</label>
                                <input  type="text" class="form-control" id="tipo_poliza" name="tipo_poliza" placeholder="Tipo poliza" value="<?=isset($poliza['GerenciaNombre'])?$poliza['GerenciaNombre']:''?>" readonly />
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-lg-6">
                            <label for="exampleInputEmail1">Agente</label>
                            <input  type="text" class="form-control" id="agente" name="agente" placeholder="Agente" value="<?=isset($poliza['AgenteNombre'])?"[".$poliza['CAgente']."] ".$poliza['AgenteNombre']:''?>" readonly />
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
                                <input onkeyup="javascript:this.value=this.value.toUpperCase();" type="text" class="form-control" id="numero_siniestro" name="numero_siniestro" placeholder="Número del siniestro" value="<?=isset($registro[0]['siniestro_id'])?$registro[0]['siniestro_id']:''?>"/>
                                <input type="text" class="form-control" name="id" id="id" style="display:none" value="<?=isset($registro[0]['id'])?$registro[0]['id']:''?>" />
                                <span class="error" id="e_numero_siniestro"></span>
                            </div>
                        </div>
                        <div class="col-lg-4">
                            <div class="form-group" id="g_numero_siniestro">
                                <label class="control-label" for="numero_siniestro">Certificado </label>
                                <input  type="text" class="form-control" id="certificado" name="certificado" placeholder="Número del siniestro" value="<?=isset($registro[0]['certificado'])?$registro[0]['certificado']:''?>"/>
                                <span class="error" id="e_certificado"></span>
                            </div>
                        </div>
                        <div class="col-lg-4">
                                <?php 
                                    $fecha=date("Y-m-d");
                                ?>
                            <div class="form-group" id="g_numero_siniestro">
                                <label class="control-label" for="numero_siniestro">Fecha de inicio</label>
                                <input  type="date" class="form-control" id="fecha_aviso" max="<?=$fecha?>" name="fecha_aviso" placeholder="Número del siniestro" value="<?=isset($registro[0]['inicio_ajuste'])?date("Y-m-d",strtotime($registro[0]['inicio_ajuste'])):''?>"/>
                                <span class="error" id="e_fecha_aviso"></span>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-lg-4">
                            <div class="form-group" id="g_numero_siniestro">
                                <label class="control-label" for="numero_siniestro">Tipo de siniestro</label>
                                <select name="tipo_siniestro" id="tipo_siniestro" class="form-control">
                                    <option value="">Seleccione uno</option>
                                    <?php foreach($tipo_s as $value): 
                                            $est=isset($registro[0]['tipo_siniestro_id'])?$registro[0]['tipo_siniestro_id']:'';
                                            ?>
                                            <option value="<?=$value['id'] ?>" <?=$value['id']==$est?'selected':''?>><?=$value['nombre'] ?></option>
                                    <?php endforeach; ?>
                                </select>
                                <span class="error" id="e_tipo_siniestro"></span>
                            </div>
                        </div>
                        <div class="col-lg-4">
                            <div class="form-group" id="g_numero_siniestro">
                                <label class="control-label" for="numero_siniestro">Causa</label>
                                <select name="causa" id="causa" class="form-control">
                                <option value="">Seleccione uno</option>
                                </select>
                                <span class="error" id="e_causa"></span>
                            </div>
                        </div>
                        <div class="col-lg-4">
                            <div class="form-group" id="g_numero_siniestro">
                                <label class="control-label" for="numero_siniestro">Estado de ocurrencia</label>
                                <select name="estado" id="estado" class="form-control">
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
                    </div>
                    <div class="row">
                        <div class="col-lg-4">
                            <div class="form-group" id="g_numero_siniestro">
                                <!-- <label class="control-label" for="numero_siniestro">Tipo autoridad</label>
                                <select name="tipo_autoridad" id="tipo_autoridad" class="form-control"> -->
                                <label class="control-label" for="numero_siniestro">Autoridad presente</label>
                                <select name="autoridad_presente" id="autoridad_presente" class="form-control">
                                    <option value="">Seleccione uno</option>
                                    <?php foreach($autoridad_t as $value): 
                                            $est=isset($registro[0]['autoridad_id'])?$registro[0]['autoridad_id']:'';
                                    ?>
                                    <option value="<?=$value['id'] ?>" <?=$value['id']==$est?'selected':''?>><?=$value['nombre'] ?></option>
                                    <?php endforeach; ?>
                                </select>
                                <span class="error" id="e_tipo_autoridad"></span>
                            </div>
                        </div>
                        <div class="col-lg-4">
                            <div class="form-group" id="g_numero_siniestro">
                                <!-- <label class="control-label" for="numero_siniestro">Autoridad presente</label>
                                <select name="autoridad_presente" id="autoridad_presente" class="form-control"> -->
                                <label class="control-label" for="numero_siniestro">Tipo autoridad</label>
                                <select name="tipo_autoridad" id="tipo_autoridad" class="form-control">
                                    <option value="">Seleccione uno</option>
                                    <?php foreach($ajustador_tipo as $value): 
                                        $est=isset($registro[0]['responsable_autoridad'])?$registro[0]['responsable_autoridad']:'';
                                    ?>
                                    <option value="<?=$value['id'] ?>" <?=$value['id']==$est?'selected':''?>><?=$value['nombre'] ?></option>
                                    <?php endforeach; ?>
                                </select>
                                <span class="error" id="e_autoridad_presente"></span>
                            </div>
                        </div>
                       
                        <div class="col-lg-4">
                            <div class="form-group" id="g_numero_siniestro">
                                <label class="control-label" for="numero_siniestro">Tipo ajustador</label>
                                <select name="tipo_ajustador" id="tipo_ajustador" class="form-control">
                                    <option value="">Seleccione uno</option>
                                    <?php foreach($ajustador as $value): 
                                        $est=isset($registro[0]['responsable_ajustador'])?$registro[0]['responsable_ajustador']:'';
                                    ?>
                                    <option value="<?=$value['id'] ?>" <?=$value['id']==$est?'selected':''?>><?=$value['nombre'] ?></option>
                                    <?php endforeach; ?>
                                </select>
                                <span class="error" id="e_tipo_ajustador"></span>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-lg-4">
                            <div class="form-group" id="g_numero_siniestro">
                                <label class="control-label" for="numero_siniestro">Declaración</label>
                                <select name="declaracion" id="declaracion" class="form-control">
                                    <option value="">Seleccione uno</option>
                                    <option value="1">SI</option>
                                    <option value="0">NO</option>
                                </select>
                                <span class="error" id="e_declaracion"></span>
                            </div>
                        </div>
                        <div class="col-lg-4">
                            <div class="form-group" id="g_numero_siniestro">
                                <label class="control-label" for="numero_siniestro">Atención en el lugar</label>
                                <select name="atencion" id="atencion" class="form-control">
                                    <option value="">Seleccione uno</option>
                                    <option value="1">SI</option>
                                    <option value="0">NO</option>
                                </select>
                                <span class="error" id="e_atencion"></span>
                            </div>
                        </div>
                    </div>
                    <div class="row">
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
                                <input onkeyup="javascript:this.value=this.value.toUpperCase();" type="text" class="form-control" id="serie" name="serie" placeholder="Serie" value="<?=isset($complemento['general']->serie)?$complemento['general']->serie:''?>" />
                                <span class="error" id="e_serie"></span>
                            </div>
                        </div>
                        <div class="col-lg-4">
                            <div class="form-group">
                                <label for="exampleInputEmail1">Valor Unidad</label>
                                <input onBlur="fomatValue(this.value)" type="text" class="form-control numeric" id="valor_unidad" name="valor_unidad" placeholder="Valor Unidad" value="<?=isset($complemento['general']->valor_unidad)?$complemento['general']->valor_unidad:''?>" />
                                <span class="error" id="e_valor_unidad"></span>
                            </div>
                        </div>
                        <div class="col-lg-4">
                            <div class="form-group">
                                <label for="exampleInputEmail1">Deducible</label>
                                <input onkeyup="javascript:this.value=this.value.toUpperCase();" type="text" class="form-control" id="deducible" name="deducible" placeholder="Deducible" value="<?=isset($complemento['general']->deducible)?$complemento['general']->deducible:''?>" />
                                <span class="error" id="e_deducible"></span>
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
                    </div>
                    <div class="row">
                        <div class="col-lg-12">
                            <strong><p>Datos del ajustador</p><hr></strong>
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
                                <input  type="text" class="form-control numeric"  maxlength="10" id="telefono_coordinador" name="telefono_coordinador" placeholder="Telefono" value="<?=isset($complemento['cordinador']->telefono_coordinador)?$complemento['cordinador']->telefono_coordinador:''?>" />
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

<div class="modal fade" id="modal_tipos" tabindex="-1" role="dialog" data-backdrop="static" data-keyboard="false" aria-labelledby="modalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <form id="form_cobertura" action="<?= base_url() ?>GMM/AccionesTiposCobertura" method="POST" autocomplete="off">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title" id="modalLabel">Busqueda de póliza</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                    </button>
                  
                </div>
                <div class="modal-body">
                    <div class="row">
                        <div class="col-lg-5">
                            <div class="form-group">
                                <label for="exampleInputEmail1">Número de póliza</label>
                                <input onkeyup="javascript:this.value=this.value.toUpperCase();" type="text" class="form-control" id="num_poliza_m" name="num_poliza_m" placeholder="Num póliza"  />
                            </div>
                        </div>
                        <div class="col-md-5">
                            <div class="form-group">
                                <label for="exampleInputEmail1">Nombres</label>
                                <input onkeyup="javascript:this.value=this.value.toUpperCase();" type="text" class="form-control" id="nombres_m" name="nombres_m" placeholder="Nombres" />
                            </div>
                        </div>
                        <div class="col-md-2">
                            <div class="form-group">
                                <label class="checkbox-inline" style="margin-top:25px;"><input type="checkbox" value="" name="moral" id="moral" style="margin-top:px;">Persona Moral</label>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-5">
                            <div class="form-group">
                                <label for="exampleInputEmail1">Apellido Paterno</label>
                                <input onkeyup="javascript:this.value=this.value.toUpperCase();" type="text" class="form-control" id="apellido_p_m" name="apellido_p_m" placeholder="Apellido paterno"  />
                            </div>
                        </div>
                        <div class="col-md-5">
                            <div class="form-group">
                                <label for="exampleInputEmail1">Apellido Materno</label>
                                <input onkeyup="javascript:this.value=this.value.toUpperCase();" type="text" class="form-control" id="apellido_m_m" name="apellido_m_m" placeholder="Apellido materno"  />
                            </div>
                        </div>
                        <div class="col-md-2" style="padding-top:20px;">
                            <a class="btn btn-primary pull-right" onclick="seachPoliza()"><span class="fa fa-search"></span> Buscar póliza</a>
                        </div>
                    </div>
                    <div class="row">
					    <div class="col-md-12">
                            <table class="table" id="example">
                                <thead>
                                    <tr>
                                    <th scope="col" style="display:none;">Numero poliza</th>
                                    <th scope="col" style="display:none;">Compañia</th>
                                    <th scope="col" style="display:none;">Estatus</th>
                                    <th>Póliza</th>
                                    </tr>
                                </thead>
                                <tbody>
                                </tbody>
                            </table>
                        </div>
					</div>
                </div>
                <div class="modal-footer">
                    <!-- <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button> -->
                    <a class="btn btn-primary"  data-dismiss="modal">Aceptar</a>
                </div>
            </div>
        </form>
    </div>
</div>

<!-- modal de la informacion de la poliza -->

<div class="modal bs-example-modal-lg" id="modal_info" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel">
  <div class="modal-dialog modal-lg modal-dialog-centered">
    <div class="modal-content">
		<div class="modal-header">
			<h4 class="modal-title" id="gridSystemModalLabel">Información de la Póliza</h4>
			<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
		</div>
		<div class="modal-body">
    		<div class="row">
    	           <div class="col-md-12">
                        <div class="row">
                            <div class="col-md-4">
                                <label for="tipodoc"><strong>Tipo Documento</strong></strong></label>
                                <p id="TipoDocto_TXT"></p>
                            </div>
                            <div class="col-md-4">
                                <label for="solicitud"><strong>Solicitud</strong></label>
                                <p id="Solicitud"></p>
                            </div>
                            <div class="col-md-4">
                                <label for="anterior"><strong>Anterior</strong></label>
                                <p id="DAnterior"></p>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-4">
                                <label for="polizamaestra"><strong>P&oacute;liza Maestra</strong></label>                       
                                <p id="pMaestra"></p>
                            </div>
                            <div class="col-md-4">
                                <label for="documento"><strong>Documento</strong></label>
                                <p id="Documento"></p>
                            </div>
                            <div class="col-md-4">
                                <label for="posterior"><strong>Posterior</strong></label>
                                <p id="DPosterior"></p>
                            </div>
                        </div>
                   </div>
    		</div>
            <div class="row">
                <div class="col-md-12" style="padding-bottom:15px;">
                   <strong><span class="fa fa-info-circle" aria-hidden="true"></span> Información General</strong>
                </div>
            </div>
            <div class="row">
                <div class="col-md-6">
                    <label for="cliente"><strong>Cliente</strong></label>
                    <p id="NombreCompleto"></p>
                </div>
                <div class="col-md-6">
                    <label for="direccion"><strong>Direcci&oacute;n</strong></label>
                    <p id="direccion"></p>
                </div>
                <div class="col-md-4">
                    <label for="agente"><strong>Agente</strong></label>
                    <p id="CAgente"></p>
                </div>
                <div class="col-md-8">
                    <p id="AgenteNombre"></p>
                    <p id="CiaNombre"></p>
                </div>
                <div class="col-md-12">
                    <label for="ejecutivo"><strong>Ejecutivo de Compa&ntilde;ia</strong></label>
                    <p id="ejecutivo"></p>
                </div>
                <div class="col-md-3">
                    <label for="fechaini"><strong>Desde</strong></label>
                    <p id="desde"></p>
                </div>
                <div class="col-md-3">
                    <label for="fechaini"><strong>Hasta</strong></label>
                    <p id="hasta"></p>
                </div>
                <div class="col-md-3">
                    <label for="fechaini"><strong>Fecha de antiguedad</strong></label>
                    <p id="fechaantiguedad"></p>
                </div>
                <div class="col-md-3">
                    <label for="renovacion"><strong>Renovaci&oacute;n</strong></label>
                    <p id="Renovacion"></p>
                </div>
                <div class="col-md-3">
                    <label for="renovacion"><strong>Moneda</strong></label>
                    <p id="Moneda"></p>
                </div>
                <div class="col-md-3">
                    <label for="renovacion"><strong>Forma de pago</strong></label>
                    <p id="FPago"></p>
                </div>
                <div class="col-md-3">
                    <label for="grupo"><strong>Grupo</strong></label>
                    <p id="Grupo"></p>
                </div>
                <div class="col-md-3">
                    <label for="cejecutivo"><strong>Ejecutivo</strong></label>
                    <p id="EjecutNombre"></p>
                </div>
                <div class="col-md-12">
                    <label for="cvendedor"><strong>Vendedor</strong></label>
                    <p id="VendNombre"></p>
                </div>
                <div class="col-md-12">
                    <label for="concepto"><strong>Concepto</strong></label>
                    <p id="Concepto"></p>
                </div>
                <div class="col-md-12" style="padding-bottom:15px;">
                   <strong><span class="fa fa-info-circle" aria-hidden="true"></span> Documentos</strong><br>
                </div>
                <div id="tree_menu" class="col-md-12">
            	</div>
            </div>
		</div>
		<div class="modal-footer">
			<button type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button>
			<!--<button type="button" class="btn btn-primary">Save changes</button>-->
		</div>
    </div>
  </div>
</div>

<script src="<?=base_url()?>assets/gap/js/registro_autos.js?v=1.0"></script>
<script>
$(document).ready(function(){
    <?php if(isset($registro[0]['declara_conductor'])) : ?>
    Causas('<?=$registro[0]['tipo_siniestro_id']?>','<?=$registro[0]['causa_siniestro_id']?>');
    $('#declaracion').val('<?=$registro[0]['declara_conductor']?>');
    $('#atencion').val('<?=$registro[0]['atencion_lugar']?>');
    <?php endif; ?>

    $(document).on("click", "#open_d", function() {
        var is_json=$("#json_poliza").val();
       
        if(is_json!=''){
            var info_d=JSON.parse($("#json_poliza").val());
            Object.keys(info_d).forEach(key =>{
                if(info_d[key]!=''){
                    $(`#${key}`).html(info_d[key]);
                }else{
                    $(`#${key}`).html("N/A");
                }
            });
            $('#agente').html(`[${getValue(info_d.CAgente)}] ${getValue(info_d.AgenteNombre)}`);
            $('#sub_ramo').html(getValue(info_d.SRamoNombre));
            //otros datos
            $('#direccion').html(getValue(info_d.Calle) +' '+ getValue(info_d.NOExt) +' '+getValue(info_d.NOInt)+ ' ' +getValue(info_d.Colonia)+ ' '+getValue(info_d.CPostal)+ ' '+getValue(info_d.Poblacion) + ' '+ getValue(info_d.Ciudad) + ' ' + getValue(info_d.Pais));
            $('#hasta').html(moment(info_d.FHasta).format("YYYY-MM-DD"));
            $('#desde').html(moment(info_d.FDesde).format("YYYY-MM-DD"));
            $('#fechaantiguedad').html(moment(info_d.FAntiguedad).format("YYYY-MM-DD"));
            console.log("info",info_d);
            var IDDocto=info_d.IDDocto;
            $.ajax({
                        method: "POST",
                        data: { "IDDocto": IDDocto },
                        url : "<?php echo base_url()?>directorio/LoadCentroDigital",
                        dataType: "html",
                        success : function(data){
                                $('#tree_menu').easytree({					
                                    // data: arbol,
                                    data: [JSON.parse(data)],
                                });
                                $('#modal_info').modal('handleUpdate'); 
                        }
                    
            });
            $("#modal_info").modal("show");
        }else{
            toastr.error("No se ha seleccionado alguna poliza");
        }
    });

    
	window.getValue=function(data){
		var resl = '';
		if(data != null){
			if(typeof data == 'object'){
				resl = '';
			}
			else{
				resl = data;
			}
		}else{
			resl = '';
		}

		return resl;
	}
    var opt=0;
    $(document).on("click", ".easytree-node", function() {
            /* $('ul:not(.ui-easytree)').each(function(i){
                $(this).css('display', ''); // This is your rel value
            }); */
        if(opt==0){
            $('ul:not(.ui-easytree)').each(function(i){
                $(this).css('display', ''); // This is your rel value
            });
            opt=1;
        }else{
            $('ul:not(.ui-easytree)').each(function(i){
                $(this).css('display', 'none'); // This is your rel value
            });
            opt=0;
        }
        $('#modal_info').modal('handleUpdate'); 
        
    });
});
</script>
