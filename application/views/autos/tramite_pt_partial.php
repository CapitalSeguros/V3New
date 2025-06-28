<?php
    if(isset($data[0]["valores"])){
        $elemento=json_decode($data[0]["valores"],true);
    }
    $complemento_json=isset($data[0]['complemento_json'])?json_decode($data[0]['complemento_json'],true):[];
    $valor_unidad=0;$deducible=0;$total_neto=0;

    $tras_prop=isset($elemento['Transmision_Propiedad'])?$elemento['Transmision_Propiedad']:0;
    $iva_tras=($tras_prop*0.16);
    $prima_des=isset($elemento['Prima_Descontada'])?$elemento['Prima_Descontada']:0;
    //$total_neto=0;
    if(!empty($complemento_json)){
        //var_dump($complemento_json);
        if(isset($complemento_json['general']['valor_unidad'])){
            if($complemento_json['general']['valor_unidad']!=''){
                $valor_unidad=str_replace(',','',$complemento_json['general']['valor_unidad']);
                $deducible=str_replace(',','',$complemento_json['general']['deducible'])==''?0:str_replace(',','',$complemento_json['general']['deducible']);
                //var_dump($valor_unidad);
                $total_neto=($valor_unidad-$deducible-$prima_des)+$iva_tras;
            }
        }
        
                    //$monto_unidad=$complemento_json[]
    }
    
?>

<div class="row">
    <div class="col-md-12">
    <br id="salto_tramite">
    <strong>
        <span class="fa fa-info-circle" aria-hidden="true"></span>
        DATOS DEL TRÁMITE DE PERDIDA TOTAL
    </strong>
    </div>
</div>
<div class="row">
    <div class="col-md-4">
        <div class="form-group">
            <label for="exampleInputEmail1">Fecha Inicio</label>
            <input min="<?=isset($data[0]["fecha_ocurrencia"])?date("Y-m-d",strtotime($data[0]["fecha_ocurrencia"])):''?>" type="date" class="form-control field" id="fecha_inicio" name="fecha_inicio" value="<?=isset($data[0]["fecha_inicio"])?$data[0]["fecha_inicio"]:''?>"/>
            <span class="error" id="e_fecha_inicio"></span>
        </div>
    </div>
    <div class="col-md-4">
        <div class="form-group">
            <label for="exampleInputEmail1">Fecha Notificacion</label>
            <input min="<?=isset($data[0]["fecha_ocurrencia"])?date("Y-m-d",strtotime($data[0]["fecha_ocurrencia"])):''?>" type="date" class="form-control field" id="Fecha_Notificacion" name="Fecha_Notificacion" value="<?=isset($elemento['Fecha_Notificacion'])?$elemento['Fecha_Notificacion']:''?>"/>
        </div>
    </div>
    <div class="col-md-4">
        <div class="form-group">
            <label for="exampleInputEmail1">Fecha Documentación</label>
            <input min="<?=isset($data[0]["fecha_ocurrencia"])?date("Y-m-d",strtotime($data[0]["fecha_ocurrencia"])):''?>" type="date" class="form-control field" id="Fecha_documentacion" name="Fecha_documentacion" value="<?=isset($elemento['Fecha_documentacion'])?$elemento['Fecha_documentacion']:''?>"/>
        </div>
    </div>
    <div class="col-md-4">
        <div class="form-group">
            <label for="exampleInputEmail1">Fecha Avisado Cheque</label>
            <input min="<?=isset($data[0]["fecha_ocurrencia"])?date("Y-m-d",strtotime($data[0]["fecha_ocurrencia"])):''?>" type="date" class="form-control field" id="Fecha_Avisado_Cheque" name="Fecha_Avisado_Cheque" value="<?=isset($elemento['Fecha_Avisado_Cheque'])?$elemento['Fecha_Avisado_Cheque']:''?>"/>
        </div>
    </div>
    <div class="col-md-4">
        <div class="form-group">
            <label for="exampleInputEmail1">Num de Cheque Pago</label>
            <input onkeyup="javascript:this.value=this.value.toUpperCase();" type="text" class="form-control field" id="Num_Cheque_Pago" name="Num_Cheque_Pago" value="<?=isset($elemento['Num_Cheque_Pago'])?$elemento['Num_Cheque_Pago']:''?>"/>
        </div>
    </div>
    <div class="col-md-4">
        <div class="form-group">
            <label for="exampleInputEmail1">Factura Deducible</label>
            <input onkeyup="javascript:this.value=this.value.toUpperCase();" type="text" class="form-control field" id="Fecha_Deducible" name="Fecha_Deducible" value="<?=isset($elemento['Fecha_Deducible'])?$elemento['Fecha_Deducible']:''?>"/>
        </div>
    </div>
    <div class="col-md-4">
        <div class="form-group">
            <label for="exampleInputEmail1">Fecha Entrega Factura</label>
            <input min="<?=isset($data[0]["fecha_ocurrencia"])?date("Y-m-d",strtotime($data[0]["fecha_ocurrencia"])):''?>" type="date" class="form-control field" id="Fecha_Entrega_Factura" name="Fecha_Entrega_Factura" value="<?=isset($elemento['Fecha_Entrega_Factura'])?$elemento['Fecha_Entrega_Factura']:''?>"/>
        </div>
    </div>
    <div class="col-md-4">
        <div class="form-group">
            <label for="exampleInputEmail1">PT Indemnización</label>
            <input  onkeyup="javascript:this.value=this.value.toUpperCase();" type="text" class="form-control field" id="PT_Indemnizacion" name="PT_Indemnizacion" value="<?=isset($elemento['PT_Indemnizacion'])?$elemento['PT_Indemnizacion']:''?>"/>
            <span class="error" id="e_fecha_inicio"></span>
        </div>
    </div>
    <div class="col-md-4">
        <div class="form-group">
            <label for="exampleInputEmail1">Transmisión Propiedad</label>
            <input  onkeyup="javascript:this.value=this.value.toUpperCase();" type="text" class="form-control field Neto" id="Transmision_Propiedad" name="Transmision_Propiedad" value="<?=isset($elemento['Transmision_Propiedad'])?$elemento['Transmision_Propiedad']:'0'?>"/>
            <span class="error" id="e_fecha_inicio"></span>
        </div>
    </div>
    <div class="col-md-4">
        <div class="form-group">
            <label for="exampleInputEmail1">IVA Tras Propiedad</label>
            <input  onkeyup="javascript:this.value=this.value.toUpperCase();" type="text" class="form-control field" id="IVA_Tras_Propiedad" name="IVA_Tras_Propiedad" value="<?=isset($elemento['IVA_Tras_Propiedad'])?$elemento['IVA_Tras_Propiedad']:'0'?>" readonly/>
            <span class="error" id="e_IVA_Tras_Propiedad"></span>
        </div>
    </div>
    <div class="col-md-4">
        <div class="form-group">
            <label for="exampleInputEmail1">Valor Unidad</label>
            <input  onkeyup="javascript:this.value=this.value.toUpperCase();" name="Valor_Unidad" id="Valor_Unidad" type="text" class="form-control field"  value="<?=$valor_unidad?>" readonly/>
        </div>
    </div>
    <div class="col-md-4">
        <div class="form-group">
            <label for="exampleInputEmail1">Deducible</label>
            <input  onkeyup="javascript:this.value=this.value.toUpperCase();" name="Deducible" id="Deducible" type="text" class="form-control field"  value="<?=$deducible?>" readonly/>
        </div>
    </div>
    <div class="col-md-4">
        <div class="form-group">
            <label for="exampleInputEmail1">Prima Descontada</label>
            <input min="0"  type="number" class="form-control field numeric Neto" id="Prima_Descontada" name="Prima_Descontada" value="<?=isset($elemento['Prima_Descontada'])?$elemento['Prima_Descontada']:'0'?>"/>
        </div>
    </div>
    <div class="col-md-4">
        <div class="form-group">
            <label for="exampleInputEmail1">Total Neto</label>
            <input min="0"  type="number" class="form-control field numeric" id="Total_Neto" name="Total_Neto" value="<?=$total_neto?>" readonly/>
        </div>
    </div>
    <div class="col-md-4">
        <div class="form-group">
            <label for="exampleInputEmail1">Fecha Limite Pago</label>
            <input min="<?=isset($data[0]["fecha_ocurrencia"])?date("Y-m-d",strtotime($data[0]["fecha_ocurrencia"])):''?>" type="date" class="form-control field" id="Fecha_Limite_Pago" name="Fecha_Limite_Pago" value="<?=isset($elemento['Fecha_Limite_Pago'])?$elemento['Fecha_Limite_Pago']:''?>"/>
        </div>
    </div>
    <div class="col-md-4">
        <div class="form-group">
            <label for="exampleInputEmail1">Penalización</label>
            <input onkeyup="javascript:this.value=this.value.toUpperCase();" type="text" class="form-control field" id="Penalizacion" name="Penalizacion" value="<?=isset($elemento['Penalizacion'])?$elemento['Penalizacion']:''?>"/>
        </div>
    </div>
    <div class="col-md-4">
        <div class="form-group">
            <label for="exampleInputEmail1">Num de Cheque Penalización</label>
            <input onkeyup="javascript:this.value=this.value.toUpperCase();" type="text" class="form-control field" id="Num_Cheque_Penalizacion" name="Num_Cheque_Penalizacion" value="<?=isset($elemento['Num_Cheque_Penalizacion'])?$elemento['Num_Cheque_Penalizacion']:''?>"/>
        </div>
    </div>
    <div class="col-md-4">
        <div class="form-group">
            <label for="exampleInputEmail1">Fecha Pago Penalización</label>
            <input min="<?=isset($data[0]["fecha_ocurrencia"])?date("Y-m-d",strtotime($data[0]["fecha_ocurrencia"])):''?>" type="date" class="form-control field" id="Fecha_Pago_Penalizacion" name="Fecha_Pago_Penalizacion" value="<?=isset($elemento['Fecha_Pago_Penalizacion'])?$elemento['Fecha_Pago_Penalizacion']:''?>"/>
        </div>
    </div>
  <!--   <div class="col-md-4">
        <div class="form-group">
            <label for="exampleInputEmail1">Total A Pagar</label>
            <input onkeyup="javascript:this.value=this.value.toUpperCase();" type="text" class="form-control field" id="Total_A_Pagar" name="Total_A_Pagar" value="<?=isset($elemento['Total_A_Pagar'])?$elemento['Total_A_Pagar']:''?>"/>
        </div>
    </div> -->
    <div class="col-md-4">
        <div class="form-group">
            <label for="exampleInputEmail1">Estatus</label>
          <!--   <input  type="text" class="form-control field" id="Estatus" name="Estatus" value="<?=isset($elemento['Estatus'])?$elemento['Estatus']:''?>"/> -->
            <select id="Estatus" name="Estatus" class="form-control field">
                <option value="">Seleccione uno</option>
                <?php foreach($EstatusPT as $value): 
                    $esta=isset($elemento['Estatus'])?$elemento['Estatus']:'';
                ?>
                <option value="<?=$value['nombre'] ?>" <?=$value['nombre']==$esta?'selected':''?>><?=$value['nombre'] ?></option>
            <?php endforeach; ?>
            </select>
        </div>
    </div>
    
    

    
   
    
   
</div>
<div class="row">
    <div class="col-lg-12">
        <strong> <span class="fa fa-info-circle" aria-hidden="true"></span>Documentos</p></strong>
    </div>
</div>
<div class="row" id='bodyDocumentos'>
</div>
<div class="row">
    <div class="col-md-12 pull-right">
        <div class="form-group">
            <button class="btn btn-primary pull-right" id="btn_save">Guardar</button>
        </div>
    </div>
</div>