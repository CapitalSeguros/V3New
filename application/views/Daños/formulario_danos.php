<link rel="stylesheet" href="<?=base_url()?>assets/gap/css/registros.css">
<script src="<?=base_url()?>/assets/gap/js/jquery.validate.js"></script>
<script src="<?=base_url()?>assets/js/jquery.easytree.min.js"></script>
<?php
    if(!empty($registro)){
        //var_dump($registro);
        $poliza=(array)json_decode($registro[0]['data_poliza']);
        $complemento=(array)json_decode($registro[0]['complemento_json']);
        //var_dump($complemento);
    }
    if(isset($Poliza_Carga->TableInfo)){
        $poliza=(array)$Poliza_Carga->TableInfo;
    }

?>
<section class="container-fluid breadcrumb-formularios">
    <a id="N" data-IdNotificacion='<?= $idNotificacion; ?>'></a>
    <div class="row">
        <div class="col-md-6 col-sm-5 col-xs-5">
            <h3 class="titulo-secciones"><?=$titulo?> Siniestro de daños</h3>
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
            <form action="<?= base_url() ?>Danos/AccionesDanos" method="POST" id="form_gmm" name="form_gmm" data-toggle="validator" autocomplete="off">
                <div class="panel-body">
                    <div class="row">
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
                            <!-- <input type="hidden" id="json_poliza" name="json_poliza" value="<?=isset($registro[0]['data_poliza'])?$registro[0]['data_poliza']:''?>"/>
                            <input type="hidden" id='idsicascliente' name='idsicascliente'>
                            <input type="hidden" id='idsicasvendedor' name='idsicasvendedor'> -->
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
                                <input  type="text" class="form-control" id="telefono_asegurado" name="telefono_asegurado" placeholder="Telefono" value="<?=isset($poliza['Telefono1'])?$poliza['Telefono1']:''?>" readonly />
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
                        <div class="col-lg-4">
                            <div class="form-group">
                                <label for="exampleInputEmail1">Sub Ramo</label>
                                <input type="text" class="form-control" id="sub_ramo" name="sub_ramo" placeholder="Sub Ramo" value="<?=isset($poliza['SRamoNombre'])?$poliza['SRamoNombre']:''?>" readonly />
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-lg-4">
                            <label for="exampleInputEmail1">Agente</label>
                            <input  type="text" class="form-control" id="agente" name="agente" placeholder="Agente" value="<?=isset($poliza['AgenteNombre'])?"[".$poliza['CAgente']."] ".$poliza['AgenteNombre']:''?>" readonly />
                        </div>
                        <div class="col-lg-4">
                            <div class="form-group">
                                <label for="tipo_cobertura">Tipo de poliza</label>
                                <input  type="text" class="form-control" id="tipo_poliza" name="tipo_poliza" placeholder="Tipo poliza" value="<?=isset($poliza['GerenciaNombre'])?$poliza['GerenciaNombre']:''?>" readonly />
                            </div>
                        </div>
                        <div class="col-lg-4">
                            <div class="form-group">
                                <label for="exampleInputEmail1">Estatus</label>
                                <input  type="text" class="form-control" id="estatus_poliza" name="estatus_poliza" placeholder="Estatus" value="<?=isset($poliza['Status_TXT'])?$poliza['Status_TXT']:''?>" readonly />
                            </div>
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
                                <input type="text" class="form-control" name="id" id="id" style="display:none" value="<?=isset($registro[0]['idregistro'])?$registro[0]['idregistro']:''?>" />
                                <span class="error" id="e_numero_siniestro"></span>
                            </div>
                        </div>
                        <div class="col-lg-4">
                            <div class="form-group" id="g_numero_siniestro">
                                <label class="control-label" for="numero_reporte">Número de Reporte </label>
                                <input onkeyup="javascript:this.value=this.value.toUpperCase();" type="text" class="form-control" id="numero_reporte" name="numero_reporte" placeholder="Número de Reporte" value="<?=isset($complemento['general']->num_reporte)?$complemento['general']->num_reporte:''?>"/>
                                <span class="error" id="e_numero_reporte"></span>
                            </div>
                        </div>
                        <div class="col-lg-4" id="g_fecha_ocurrencia">
                            <div class="form-group">
                                <?php 
                                    $fecha=date("Y-m-d");
                                ?>
                                <label for="exampleInputEmail1">Fecha de ocurrencia</label>
                                <input  type="date" class="form-control" id="fecha_ocurrencia" max="<?=$fecha?>" name="fecha_ocurrencia" placeholder="Fecha de ocurrencia" value="<?=isset($registro[0]['fecha_ocurrencia'])?date("Y-m-d", strtotime($registro[0]['fecha_ocurrencia'])):''?>" />
                                <span class="error" id="e_fecha_ocurrencia"></span>
                              <!--   <span class="help-block">Please correct the error</span> -->
                            </div>
                        </div>
                        <div class="col-lg-4" id="g_fecha_aviso">
                            <div class="form-group">
                                <?php 
                                    $fecha=date("Y-m-d");
                                ?>
                                <label for="exampleInputEmail1">Fecha de aviso</label>
                                <input  type="date" class="form-control" id="fecha_aviso" max="<?=$fecha?>" name="fecha_aviso" placeholder="Fecha del aviso" value="<?=isset($registro[0]['inicio_ajuste'])?date("Y-m-d", strtotime($registro[0]['inicio_ajuste'])):''?>" />
                                <span class="error" id="e_fecha_aviso"></span>
                              <!--   <span class="help-block">Please correct the error</span> -->
                            </div>
                        </div>
                        <div class="col-lg-4">
                            <div class="form-group">
                                <label for="exampleInputEmail1">Persona que Reporta</label>
                                <input onkeyup="javascript:this.value=this.value.toUpperCase();" type="text" class="form-control" id="persona_reporta" name="persona_reporta" placeholder="Persona que Reporta" value="<?=isset($complemento['general']->persona_reporta)?$complemento['general']->persona_reporta:''?>" />
                                <span class="error" id="e_persona_reporta"></span>
                            </div>
                        </div>
                        <div class="col-lg-4">
                            <div class="form-group">
                                <label for="exampleInputEmail1">Número de Persona que Reporta</label>
                                <input type="tel" class="form-control numeric" maxlength="10" id="numero_reporta" name="numero_reporta" placeholder="Número de Persona que Reporta" value="<?=isset($complemento['general']->numero_reporta)?$complemento['general']->numero_reporta:''?>" />
                                <span class="error" id="e_numero_reporta"></span>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-lg-4">
                            <div class="form-group">
                                <label for="exampleInputEmail1">Inciso</label>
                                <input onkeyup="javascript:this.value=this.value.toUpperCase();" type="text" class="form-control" id="inciso_a" name="inciso_a" placeholder="Inciso" value="<?=isset($complemento['general']->inciso)?$complemento['general']->inciso:'01'?>" />
                            </div>
                            <span class="error" id="e_inciso_a"></span>
                        </div>
                        <div class="col-lg-4">
                            <div class="form-group">
                                <label for="exampleInputEmail1">Responsable</label>
                                <input type="text" class="form-control" id="responsable" name="responsable" placeholder="Responsable" value="<?=isset($complemento['general']->responsable)?$complemento['general']->responsable:$usuario?>" readonly />
                                <!-- <span class="error" id="e_estado"></span> -->
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-lg-12">
                            <div class="form-group">
                                <label for="exampleInputEmail1">Dirección de ocurrencia del siniestro</label>
                                <textarea onkeyup="javascript:this.value=this.value.toUpperCase();" id="direccion" name="direccion" class="form-control" placeholder="Dirección de ocurrencia del siniestro"><?=isset($complemento['general']->direccion)?$complemento['general']->direccion:''?></textarea>
                                <span class="error" id="e_direccion"></span>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-lg-12">
                            <div class="form-group">
                                <label for="exampleInputEmail1">Descripción de lo Afectado</label>
                                <textarea onkeyup="javascript:this.value=this.value.toUpperCase();" class="form-control" name="descripcion_afectado" id="descripcion_afectado" placeholder="Descripción de lo Afectado" ><?=isset($complemento['general']->descripcion_afectado)?$complemento['general']->descripcion_afectado:''?></textarea>
                                <span class="error" id="e_descripcion_afectado"></span>
                            </div>
                        </div>
                        
                    </div>
                    <div class="row">
                        <div class="col-lg-4">
                            <div class="form-group">
                                <label for="exampleInputEmail1">Tipo</label>
                               <!--  <input type="text" class="form-control" id="riesgo_afectado" name="riesgo_afectado" placeholder="Riesgo Afectado" value="<?=isset($registro[0]['evento'])?$registro[0]['evento']:''?>" /> -->
                               <select class="form-control" name="tipo_c" id="tipo_c">
                                    <option value="">Seleccione uno</option>
                                    <option value="EXPRESS">EXPRESS</option>
                                    <option value="LÍNEA">LÍNEA</option>
                                    <option value="CATASTRÓFICO">CATASTRÓFICO</option>
                                </select>
                                <span class="error" id="e_tipo_c"></span>
                            </div>
                        </div>
                        <div class="col-lg-4">
                            <div class="form-group">
                                <label for="exampleInputEmail1">Riesgo Afectado</label>
                               <!--  <input type="text" class="form-control" id="riesgo_afectado" name="riesgo_afectado" placeholder="Riesgo Afectado" value="<?=isset($registro[0]['evento'])?$registro[0]['evento']:''?>" /> -->
                               <select class="form-control" name="cobertura_id" id="cobertura_id">
                                    <option value="">Seleccione uno</option>
                                </select>
                                <span class="error" id="e_cobertura_id"></span>
                            </div>
                        </div>
                        
                        <div class="col-lg-4">
                            <div class="form-group">
                                <label for="tipo_cobertura">Estado de ocurrencia</label>
                                <select class="form-control" name="estado" id="estado">
                                    <option value="">Seleccione uno</option>
                                    <?php foreach($estados as $value): 
                                         $est=isset($registro[0]['estado_id'])?$registro[0]['estado_id']:0;
                                        ?>
                                        <option value="<?=$value['clave'] ?>" <?=$value['clave']==$est?'selected':''?>><?=$value['estado'] ?></option>
                                    <?php endforeach; ?>
                                </select>
                                <span class="error" id="e_estado"></span>
                            </div>
                        </div>
                                     
                    </div>
                    <div class="row">
                        <div class="col-lg-12">
                            <div class="form-group">
                                <label for="exampleInputEmail1">Concepto del Siniestro</label>
                                <input onkeyup="javascript:this.value=this.value.toUpperCase();" type="text" class="form-control" id="concepto" name="concepto" placeholder="Concepto del Siniestro" value="<?=isset($complemento['general']->concepto)?$complemento['general']->concepto:''?>" />
                                <span class="error" id="e_concepto"></span>
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
                                <input onkeyup="javascript:this.value=this.value.toUpperCase();" type="tel" class="form-control numeric"  maxlength="10" id="telefono_coordinador" name="telefono_coordinador" placeholder="Telefono" value="<?=isset($complemento['cordinador']->telefono_coordinador)?$complemento['cordinador']->telefono_coordinador:''?>" />
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

<script src="<?=base_url()?>assets/gap/js/registro_danos.js"></script>
<script>
$(document).ready(function(){
    //En caso de que se editable un registro
    <?php if(isset($registro[0]['idregistro'])) : ?>
        $('select[name=tipo_poliza]').val('<?=$complemento['general']->tipo_p?>');
        $('select[name=tipo_c]').val('<?=$registro[0]['tipo_c']?>');
        Riesgos('<?=$registro[0]['tipo_c']?>',<?=$registro[0]['tipoC_id']?>);
    <?php endif; ?>

     //Actualizacion para ver las polizas 
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