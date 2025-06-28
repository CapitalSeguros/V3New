<?php
    if(isset($data[0]["valores"])){
        $elemento=json_decode($data[0]["valores"],true);
    }
    //var_dump($data);
?>
<div class="row">
    <div class="col-md-12">
    <br id="salto_tramite">
    <strong>
        <span class="fa fa-info-circle" aria-hidden="true"></span>
        DATOS DEL TRÁMITE DETENIDOS
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
            <label for="exampleInputEmail1">Autoridad</label>
            <input onkeyup="javascript:this.value=this.value.toUpperCase();" type="text" class="form-control field" id="Autoridad" name="Autoridad" value="<?=isset($elemento['Autoridad'])?$elemento['Autoridad']:''?>"/>
        </div>
    </div>
    <div class="col-md-4">
        <div class="form-group">
            <label for="exampleInputEmail1">Ubicacion Fisica</label>
            <input onkeyup="javascript:this.value=this.value.toUpperCase();" type="text" class="form-control field" id="Ubicacion_Fisica" name="Ubicacion_Fisica" value="<?=isset($elemento['Ubicacion_Fisica'])?$elemento['Ubicacion_Fisica']:''?>"/>
        </div>
    </div>
</div>
<div class="row">
    <div class="col-md-4">
        <div class="form-group">
            <label for="exampleInputEmail1">Datos Abogado</label>
            <input onkeyup="javascript:this.value=this.value.toUpperCase();" type="text" class="form-control field" id="Datos_Abogado" name="Datos_Abogado" value="<?=isset($elemento['Datos_Abogado'])?$elemento['Datos_Abogado']:''?>"/>
        </div>
    </div>
    <div class="col-md-4">
        <div class="form-group">
            <label for="exampleInputEmail1">Fecha Acreditación</label>
            <input min="<?=isset($data[0]["fecha_ocurrencia"])?date("Y-m-d",strtotime($data[0]["fecha_ocurrencia"])):''?>" type="date" class="form-control field" id="Fecha_Acreditacion" name="Fecha_Acreditacion" value="<?=isset($elemento['Fecha_Acreditacion'])?$elemento['Fecha_Acreditacion']:''?>"/>
        </div>
    </div>
    <div class="col-md-4">
        <div class="form-group">
            <label for="exampleInputEmail1">Fecha Emisión Peritaje</label>
            <input min="<?=isset($data[0]["fecha_ocurrencia"])?date("Y-m-d",strtotime($data[0]["fecha_ocurrencia"])):''?>" type="date" class="form-control field" id="Fecha_Emision_Peritaje" name="Fecha_Emision_Peritaje" value="<?=isset($elemento['Fecha_Emision_Peritaje'])?$elemento['Fecha_Emision_Peritaje']:''?>"/>
        </div>
    </div>
</div>
<div class="row">
    <div class="col-md-4">
        <div class="form-group">
            <label for="exampleInputEmail1">Fecha Liberación</label>
            <input min="<?=isset($data[0]["fecha_ocurrencia"])?date("Y-m-d",strtotime($data[0]["fecha_ocurrencia"])):''?>" type="date" class="form-control field" id="Fecha_Liberacion" name="Fecha_Liberacion" value="<?=isset($elemento['Fecha_Liberacion'])?$elemento['Fecha_Liberacion']:''?>"/>
        </div>
    </div>
    <div class="col-md-4">
        <div class="form-group">
            <label for="exampleInputEmail1">Estatus Trámite</label>
            <select name="Estatus_Tramite" id="Estatus_Tramite" class='form-control field'>
                <option value=''>Seleccione una opción</option>
                <option value="ACREDITACIÓN" <?=isset($elemento["Estatus_Tramite"])?($elemento["Estatus_Tramite"]=="ACREDITACIÓN"?'selected':''):''?> >ACREDITACIÓN</option>
                <option value="PERITAJE" <?=isset($elemento["Estatus_Tramite"])?($elemento["Estatus_Tramite"]=="PERITAJE"?'selected':''):''?>>PERITAJE</option>
                <option value="LIBERACIÓN" <?=isset($elemento["Estatus_Tramite"])?($elemento["estatus_tramite"]=="LIBERACIÓN"?'selected':''):''?>>LIBERACIÓN</option>
                <option value="TRASLADO" <?=isset($elemento["Estatus_Tramite"])?($elemento["Estatus_Tramite"]=="TRASLADO"?'selected':''):''?>>TRASLADO</option>
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
