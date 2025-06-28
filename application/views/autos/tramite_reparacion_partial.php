<?php
if (isset($data[0]["valores"])) {
    $elemento = json_decode($data[0]["valores"], true);
}
?>

<div class="row">
    <div class="col-md-12">
        <br id="salto_tramite">
        <strong>
            <span class="fa fa-info-circle" aria-hidden="true"></span>
            DATOS DEL TRÁMITE REPARACIÓN
        </strong>
    </div>
</div>
<div class="row">
    <div class="col-md-4">
        <div class="form-group">
            <label for="exampleInputEmail1">Fecha Inicio</label>
            <input min="<?= isset($data[0]["fecha_ocurrencia"]) ? date("Y-m-d", strtotime($data[0]["fecha_ocurrencia"])) : '' ?>" type="date" class="form-control field" id="fecha_inicio" name="fecha_inicio" value="<?= isset($data[0]["fecha_inicio"]) ? $data[0]["fecha_inicio"] : '' ?>" />
            <span class="error" id="e_fecha_inicio"></span>
        </div>
    </div>
    <div class="col-md-4">
        <div class="form-group">
            <label for="exampleInputEmail1">Estatus Unidad</label>
            <!--  <input  type="text" class="form-control field" id="Resultado_Valuacion" name="Resultado_Valuacion" value="<?= isset($elemento['Resultado_Valuacion']) ? $elemento['Resultado_Valuacion'] : '' ?>"/> -->
            <select id="Estatus_Unidad" name="Estatus_Unidad" class="form-control field">
                <option value="">Seleccione uno</option>
                <option value="PENDEINTE DE INGRESAR" <?= isset($elemento["Estatus_Unidad"]) ? ($elemento["Estatus_Unidad"] == "PENDEINTE DE INGRESAR" ? 'selected' : '') : '' ?>>PENDIENTE DE INGRESAR</option>
                <option value="ELABORACIÓN DE PRESUPUESTO" <?= isset($elemento["Estatus_Unidad"]) ? ($elemento["Estatus_Unidad"] == "ELABORACIÓN DE PRESUPUESTO" ? 'selected' : '') : '' ?>>ELABORACIÓN DE PRESUPUESTO</option>
                <option value="ESPERA DE VALUACION" <?= isset($elemento["Estatus_Unidad"]) ? ($elemento["Estatus_Unidad"] == "ESPERA DE VALUACION" ? 'selected' : '') : '' ?>>ESPERA DE VALUACION</option>
                <option value="VALUACIÓN REALIZADA" <?= isset($elemento["Estatus_Unidad"]) ? ($elemento["Estatus_Unidad"] == "VALUACIÓN REALIZADA" ? 'selected' : '') : '' ?>>VALUACIÓN REALIZADA</option>
                <option value="NO APLICA" <?= isset($elemento["Estatus_Unidad"]) ? ($elemento["Estatus_Unidad"] == "NO APLICA" ? 'selected' : '') : '' ?>>NO APLICA</option>
            </select>
        </div>
    </div>
    <div class="col-md-4">
        <div class="form-group">
            <label for="exampleInputEmail1">Datos Agencia</label>
            <input onkeyup="javascript:this.value=this.value.toUpperCase();" type="text" class="form-control field validacion_1" id="Agencia" name="Agencia" value="<?= isset($elemento['Agencia']) ? $elemento['Agencia'] : '' ?>" />
        </div>
    </div>
    <div class="col-md-12">
        <div class="form-group">
            <label for="exampleInputEmail1">CIUDAD DE REPARACIÓN</label>
            <input onkeyup="javascript:this.value=this.value.toUpperCase();" type="text" class="form-control field validacion_1" id="Ciudad_Reparacion" name="Ciudad_Reparacion" value="<?= isset($elemento['Ciudad_Reparacion']) ? $elemento['Ciudad_Reparacion'] : '' ?>" />
        </div>
    </div>
    <div class="col-md-4">
        <div class="form-group">
            <label for="exampleInputEmail1">Fecha Ingreso Agencia</label>
            <input min="<?= isset($data[0]["fecha_ocurrencia"]) ? date("Y-m-d", strtotime($data[0]["fecha_ocurrencia"])) : '' ?>" type="date" class="form-control field validacion_1" id="Fecha_Ingreso" name="Fecha_Ingreso" value="<?= isset($elemento['Fecha_Ingreso']) ? $elemento['Fecha_Ingreso'] : '' ?>" />
        </div>
    </div>
    <div class="col-md-4">
        <div class="form-group">
            <label for="exampleInputEmail1">Fecha Valuación</label>
            <input min="<?= isset($data[0]["fecha_ocurrencia"]) ? date("Y-m-d", strtotime($data[0]["fecha_ocurrencia"])) : '' ?>" type="date" class="form-control field validacion_1" id="Fecha_Valuacion" name="Fecha_Valuacion" value="<?= isset($elemento['Fecha_Valuacion']) ? $elemento['Fecha_Valuacion'] : '' ?>" />
        </div>
    </div>
    <div class="col-md-4">
        <div class="form-group">
            <label for="exampleInputEmail1">Monto Valuación con IVA</label>
            <input onBlur="this.type=''; this.lastValue=this.value; this.value=this.value==''?'':(+this.value).toLocaleString('es-MX')" type="text" class="form-control field validacion_1 numeric" id="Monto_Iva" name="Monto_Iva" value="<?= isset($elemento['Monto_Iva']) ? $elemento['Monto_Iva'] : '' ?>" />
        </div>
    </div>

</div>
<div class="row">
    <div class="col-md-4">
        <div class="form-group">
            <label for="exampleInputEmail1">Porcentaje Daños</label>

            <? //var_dump($data)
            //acciones para poder buscar la parte del porcentaje de daños
            $complemento_json = isset($data[0]['complemento_json']) ? json_decode($data[0]['complemento_json'], true) : [];
            $valor_unidad = 0;
            $elemento_iva = isset($elemento['Monto_Iva']) ? $elemento['Monto_Iva'] : 0;
            $porcentaje = 0;
            $porcentajeDB = isset($elemento["Porcentaje_Danos"]) ? $elemento["Porcentaje_Danos"] : '';
            if (!empty($complemento_json)) {
                //var_dump($complemento_json);
                $convert_UnidVal=isset($complemento_json['general']['valor_unidad'])?$complemento_json['general']['valor_unidad']:'';
                if (isset($complemento_json['general']) && $convert_UnidVal != '') {
                    $valor_unidad = $complemento_json['general']['valor_unidad'];
                    //var_dump($valor_unidad);
                }
                //$monto_unidad=$complemento_json[]
            }
            if ($valor_unidad > 0 && $elemento_iva > 0) {
                //$floattest=floatval(preg_replace('/[^\d.]/', '', $valor_unidad));
                $porcentaje = round((floatval(preg_replace('/[^\d.]/', '', $elemento_iva)) * 100) / floatval(preg_replace('/[^\d.]/', '', $valor_unidad)), 2);
                //$porcentaje = round(($elemento_iva * 100) / $valor_unidad, 2);
            }
            //var_dump($porcentaje);
            ?>
            <p id="valor_unidad" class='hide' data-valor-unidad="<?= $valor_unidad ?>">valor unidad</p>
            <p id="test" class='hide' data-valor-unidad-test="<?= $porcentajeDB ?>">valor unidad</p>
            <!-- <input onkeyup="javascript:this.value=this.value.toUpperCase();" type="text" class="form-control field validacion_1 numeric" id="Porcentaje_Danos" name="Porcentaje_Danos" value="<?= isset($elemento['Porcentaje_Danos']) ? $elemento['Porcentaje_Danos'] : '' ?>" readonly/> -->
            <span class="fa fa-percent" style="position: absolute;right: 0;padding: 32px 25px;"></span><!-- padding: 12vh 10vh -->
            <!-- <input onkeyup="javascript:this.value=this.value.toUpperCase();" type="text" class="form-control field" id="Porcentaje_Danos" name="Porcentaje_Danos" value="<?= $porcentaje ?>" readonly /> -->
            <input onkeyup="javascript:this.value=this.value.toUpperCase();" type="text" class="form-control field" id="Porcentaje_Danos" name="Porcentaje_Danos" value="<?= $porcentaje == $porcentajeDB ? $porcentaje : $porcentajeDB ?>" />
            <input onclick="Calculate()" type="checkbox" id="validateFormula" <?= $porcentaje == $porcentajeDB ? "checked" : '' ?>> Habilitar Formula
        </div>
    </div>
    <div class="col-md-4">
        <div class="form-group">
            <label for="exampleInputEmail1">Resultado Valuación</label>
            <!--  <input  type="text" class="form-control field validacion_1" id="Resultado_Valuacion" name="Resultado_Valuacion" value="<?= isset($elemento['Resultado_Valuacion']) ? $elemento['Resultado_Valuacion'] : '' ?>"/> -->
            <select id="Resultado_Valuacion" name="Resultado_Valuacion" class="form-control field validacion_1">
                <option value="">Seleccione uno</option>
                <?php foreach ($ResultadoEvaluacion as $value) :
                    $eval = isset($elemento['Resultado_Valuacion']) ? $elemento['Resultado_Valuacion'] : '';
                ?>
                    <option value="<?= $value['nombre'] ?>" <?= $value['nombre'] == $eval ? 'selected' : '' ?>><?= $value['nombre'] ?></option>
                <?php endforeach; ?>
            </select>
        </div>
    </div>
    <div class="col-md-4">
        <div class="form-group">
            <label for="exampleInputEmail1">Fecha Autorización Reparación</label>
            <input min="<?= isset($data[0]["fecha_ocurrencia"]) ? date("Y-m-d", strtotime($data[0]["fecha_ocurrencia"])) : '' ?>" type="date" class="form-control field validacion_1 validacion_2" id="Fecha_Autorizacion_Reparacion" name="Fecha_Autorizacion_Reparacion" value="<?= isset($elemento['Fecha_Autorizacion_Reparacion']) ? $elemento['Fecha_Autorizacion_Reparacion'] : '' ?>" />
        </div>
    </div>

</div>
<div class="row">
    <div class="col-md-4">
        <div class="form-group">
            <label for="exampleInputEmail1">Fecha Arribo Refacciones</label>
            <input min="<?= isset($data[0]["fecha_ocurrencia"]) ? date("Y-m-d", strtotime($data[0]["fecha_ocurrencia"])) : '' ?>" type="date" class="form-control field validacion_1 validacion_2" id="Fecha_Arrivo_Refacciones" name="Fecha_Arrivo_Refacciones" value="<?= isset($elemento['Fecha_Arrivo_Refacciones']) ? $elemento['Fecha_Arrivo_Refacciones'] : '' ?>" />
        </div>
    </div>
    <div class="col-md-4">
        <div class="form-group">
            <label for="exampleInputEmail1">Fecha pedido Back Order</label>
            <input min="<?= isset($data[0]["fecha_ocurrencia"]) ? date("Y-m-d", strtotime($data[0]["fecha_ocurrencia"])) : '' ?>" type="date" class="form-control field validacion_1 validacion_2" id="Fecha_Pedido_Back_Order" name="Fecha_Pedido_Back_Order" value="<?= isset($elemento['Fecha_Pedido_Back_Order']) ? $elemento['Fecha_Pedido_Back_Order'] : '' ?>" />
        </div>
    </div>
    <div class="col-md-4">
        <div class="form-group">
            <label for="exampleInputEmail1">Fecha Arribo Back Order</label>
            <input min="<?= isset($data[0]["fecha_ocurrencia"]) ? date("Y-m-d", strtotime($data[0]["fecha_ocurrencia"])) : '' ?>" type="date" class="form-control field validacion_1 validacion_2" id="Fecha_Arrivo_Back_Order" name="Fecha_Arrivo_Back_Order" value="<?= isset($elemento['Fecha_Arrivo_Back_Order']) ? $elemento['Fecha_Arrivo_Back_Order'] : '' ?>" />
        </div>
    </div>
    <div class="col-md-12">
        <div class="form-group">
            <label for="exampleInputEmail1">Refacciones Back Order</label>
            <textarea onkeyup="javascript:this.value=this.value.toUpperCase();" type="text" class="form-control field validacion_1 validacion_2" id="Refaccion_Back_Order" name="Refaccion_Back_Order" value="<?= isset($elemento['Refaccion_Back_Order']) ? $elemento['Refaccion_Back_Order'] : '' ?>"><?= isset($elemento['Refaccion_Back_Order']) ? $elemento['Refaccion_Back_Order'] : '' ?></textarea>
        </div>
    </div>

    <!-- <div class="col-md-4">
        <div class="form-group">
            <label for="exampleInputEmail1">No. Refeccación Back Order</label>
            <input onkeyup="javascript:this.value=this.value.toUpperCase();" type="text" class="form-control field validacion_1 validacion_2" id="No_Refraccion_Back_Order" name="No_Refraccion_Back_Order" value="<?= isset($elemento['No_Refraccion_Back_Order']) ? $elemento['No_Refraccion_Back_Order'] : '' ?>"/>
        </div>
    </div> -->

    <div class="col-md-4">
        <div class="form-group">
            <label for="exampleInputEmail1">Fecha Promesa Entrega</label>
            <input min="<?= isset($data[0]["fecha_ocurrencia"]) ? date("Y-m-d", strtotime($data[0]["fecha_ocurrencia"])) : '' ?>" type="date" class="form-control field validacion_1 validacion_2" id="Fecha_Promesa_Entrega" name="Fecha_Promesa_Entrega" value="<?= isset($elemento['Fecha_Promesa_Entrega']) ? $elemento['Fecha_Promesa_Entrega'] : '' ?>" />
        </div>
    </div>
    <div class="col-md-4">
        <div class="form-group">
            <label for="exampleInputEmail1">Fecha Entrega unidad</label>
            <input min="<?= isset($data[0]["fecha_ocurrencia"]) ? date("Y-m-d", strtotime($data[0]["fecha_ocurrencia"])) : '' ?>" type="date" class="form-control field validacion_1 validacion_2" id="Fecha_Entrega_Unidad" name="Fecha_Entrega_Unidad" value="<?= isset($elemento['Fecha_Entrega_Unidad']) ? $elemento['Fecha_Entrega_Unidad'] : '' ?>" />
        </div>
    </div>
    <div class="col-md-4">
        <div class="form-group">
            <label for="exampleInputEmail1">Estatus Reparación</label>
            <input onkeyup="javascript:this.value=this.value.toUpperCase();" type="text" class="form-control field" id="Estatus_Reparacion" name="Estatus_Reparacion" value="<?= isset($elemento['Estatus_Reparacion']) ? $elemento['Estatus_Reparacion'] : '' ?>" />
            <!--  <select  id="Estatus_Reparacion" name="Estatus_Reparacion" class="form-control field">
                <option value="">Seleccione uno</option>
                <?php foreach ($EstatusReparacion as $value) :
                    $eval = isset($elemento['Estatus_Final']) ? $elemento['Estatus_Reparacion'] : '';
                ?>
                <option value="<?= $value['nombre'] ?>" <?= $value['nombre'] == $eval ? 'selected' : '' ?>><?= $value['nombre'] ?></option>
            <?php endforeach; ?>
            </select> -->
        </div>
    </div>
    <div class="col-md-4">
        <div class="form-group">
            <label for="exampleInputEmail1">Estatus Final</label>
            <!--  <input  type="text" class="form-control field validacion_1" id="Resultado_Valuacion" name="Resultado_Valuacion" value="<?= isset($elemento['Resultado_Valuacion']) ? $elemento['Resultado_Valuacion'] : '' ?>"/> -->
            <select id="Estatus_Final" name="Estatus_Final" class="form-control field">
                <option value="">Seleccione uno</option>
                <?php foreach ($EstatusFinal as $value) :
                    $eval = isset($elemento['Estatus_Final']) ? $elemento['Estatus_Final'] : '';
                ?>
                    <option value="<?= $value['nombre'] ?>" <?= $value['nombre'] == $eval ? 'selected' : '' ?>><?= $value['nombre'] ?></option>
                <?php endforeach; ?>
            </select>
        </div>
    </div>
    <div class="col-md-4">
        <div class="form-group">
            <label for="exampleInputEmail1">Deducible Administrativo</label>
            <select id="Deducible_Administrativo" name="Deducible_Administrativo" class="form-control  field">
                <!-- <option value="">Seleccione uno</option> -->
                <?php $evalD = isset($elemento['Deducible_Administrativo']) ? $elemento['Deducible_Administrativo'] : ''; ?>
                <option value="NO" <?= $evalD == "NO" ? 'selected' : '' ?>>NO</option>
                <option value="SI" <?= $evalD == "SI" ? 'selected' : '' ?>>SI</option>
            </select>
        </div>
    </div>
    <div class="col-md-4">
        <div class="form-group">
            <label for="exampleInputEmail1">Fecha Solicitud Deducible Administrativo</label>
            <input type="date" class="form-control  field" id="Fecha_Solicitud_Deducible_Administrativo" name="Fecha_Solicitud_Deducible_Administrativo" value="<?= isset($elemento['Fecha_Solicitud_Deducible_Administrativo']) ? $elemento['Fecha_Solicitud_Deducible_Administrativo'] : '' ?>" />
        </div>
    </div>
    <div class="col-md-4">
        <div class="form-group">
            <label for="exampleInputEmail1">Fecha Pago Deducible</label>
            <input type="date" class="form-control  field" id="Fecha_Pago_Deducible" name="Fecha_Pago_Deducible" value="<?= isset($elemento['Fecha_Pago_Deducible']) ? $elemento['Fecha_Pago_Deducible'] : '' ?>" />
        </div>
    </div>
</div>
<!-- <div class="row">
    <div class="col-lg-12">
        <strong> <span class="fa fa-info-circle" aria-hidden="true"></span>Documentos subidos</p></strong>
    </div>
</div>
<div class="row" id='bodyDocumentosCharge'>
    <?php if (empty($docs)): ?>
        <div class="col-md-12">
            <p>No hay documentos disponibles</p>
        </div>
    <?php endif; ?>
    <?php foreach ($docs as $value) : ?>
        <div class="col-md-3" id='doc_<?=$value["file_id"]?>'>
            <div class="form-group" style='text-align:center;white-space: nowrap;text-overflow: ellipsis;overflow: hidden;'>
                <img height='15' width='15' src='https://dl.dropboxusercontent.com/s/678nxrrg13fl745/trash.svg?dl=0' style='cursor:pointer;' onclick="delete_doc('<?=$value['file_id']?>','doc_<?=$value['file_id']?>')" /><br />
                <a data-nombre='<?=$value["nombre"]?>' style='cursor:pointer;' data-id='<?=$value["file_id"]?>' class='js-preview-item'><?=$value["nombre"]?></a>
            </div>
        </div>
    <?php endforeach; ?>
</div> -->

<div class="row">
    <div class="col-lg-12">
        <strong> <span class="fa fa-info-circle" aria-hidden="true"></span>Carga de Documentos</p></strong>
    </div>
</div>
<div class="row" id='bodyDocumentos'>
</div>
<!-- <div class="row">
    
    <div class="col-md-4">
        <div class="form-group">
            <label for="exampleInputEmail1">Estatus Reparación</label>
            <input  type="text" class="form-control validacion_1" id="Estatus_Reparacion" name="Estatus_Reparacion" value="<?= isset($elemento['Estatus_Reparacion']) ? $elemento['Estatus_Reparacion'] : '' ?>"/>
        </div>
    </div>
</div> -->
<div class="row hidden" id="ccomentario">
    <div class="col-lg-12">
        <strong> <span class="fa fa-info-circle" aria-hidden="true"></span>Comentario<p></p></strong>
    </div>
    <div class="col-lg-12">
        <div class="form-group">
            <!-- <label for="exampleInputEmail1">Comentario</label> -->
            <input onkeyup="javascript:this.value=this.value.toUpperCase();" type="text" class="form-control field" id="comentario" name="comentario" value="">
        </div>
    </div>
</div>
<div class="row">
    <div class="col-md-12 pull-right">
        <div class="form-group">
            <button class="btn btn-primary pull-right" id="btn_save">Guardar</button>
        </div>
    </div>
</div>