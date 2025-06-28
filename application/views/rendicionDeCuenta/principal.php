<?php 
    $this->load->view("headers/header");
    $this->load->view("headers/menu");
?>

<style>
    #contenedor{ /*2794 - 3311*/
        /*border: 1px red solid;*/
        margin: 0 auto;
        align-content: center;
        text-align:center;
    }
    .fechaPersona{
        width: 100%;
    }
    #contenedor_filtros{
        /*width:20%;*/
        /*border: 1px red solid;*/
        /*margin-left: 60px;*/
        display:inline-block;
        vertical-align: top;
    }
    #contenedor_resultado{
        width: 100%;
        /*border: 1px blue solid;*/
        display:inline-block;
        vertical-align: top;
        text-align: center;
    }
    #panelOpciones{
        width:16.2%;
        display: inline-block;
        /*height: 150px;*/
        vertical-align:top;
    }
    #contenedorOpciones{
        width:100%;
        vertical-align:top;
    }
    #reporte_mensual.nav-tabs>li>a {
        margin-right: 2px;
        line-height: 1.42857143;
        border: 1px solid transparent;
        border-radius: 0px 0px 0px 0px;
    }
    #reporte_mensual.nav-tabs > li > a:hover {
        background: #472380;
    }
    #reporte_mensual.nav-tabs > li > a.active, .nav-tabs > li.active > a:hover, .nav-tabs > li.active > a:focus {
        background: #60428f;
        border-bottom-color: transparent;
        border-radius: 0px 0px 0px 0px;
        color: white;
    }
    .nav-tabs.tabs >li > a {
        margin-right: 0px;
        border: 1px solid transparent;
    }
    .nav-tabs.tabs > li > a:hover {
        background: #472380;
        border: 1px solid #472380;
        border-bottom-color: transparent;
        border-radius: 0px 0px 0px 0px;
    }
    .tab-content {
        border-left: 1px solid #ddd;
        border-right: 1px solid #ddd;
        border-bottom: 1px solid #ddd;
    }

  /* Checkbox Style*/
    .checkbox-container{
      width: 20px;
      height: 20px;
      border-radius: 3px;
      display: flex;
      align-items: center;
      justify-content: center;
    }
    .checkbox-All {
      width: 15px;
      height: 15px;
      position: inherit;
    }
    input:checked ~ .checkmark {
      background-color: #0d6efd; /*#337ab7, #0d6efd*/
      border-color: #0d6efd;
    }
    /*input:active ~ .checkmark{
        filter:brightness(90%);
    }*/
    input:focus ~ .checkmark{
        border-color:#86b7fe;
        outline:0;
        box-shadow:0 0 0 .25rem rgba(13,110,253,.25);
    }
    .segment {
      display: block;
      position: relative;
      cursor: pointer;
      width: 18px;
      height: 18px;
      margin-bottom: 0px;
      padding-top: 2px;
      padding-left: 2px;
      margin-top: -3px;
      margin-left: -1px;
    }
    /* Checkbox original oculto */
    .segment input {
      position: absolute;
      opacity: 0;
      cursor: pointer;
      height: 0;
      width: 0;
    }
    /* Checkbox nuevo */
    .checkmark {
      display: flex;
      /* position: absolute; */
      /* top: 0px; */
      /* left: 0; */
      height: 18px;
      width: 18px;
      border-radius: 5px;
      border: 1px solid darkgray;
      margin-top: 0px;
    }
    /* Antes de seleccionar */
    .checkmark:after {
      content: "";
      position: absolute;
      display: none;
    }
    /* Después de seleccionar */
    .segment input:checked ~ .checkmark:after {
      display: block;
    }
    /* Marcador del checkbox */
    .segment .checkmark:after {
      left: 9px;
      top: 5px;
      width: 5px;
      height: 10px;
      border: solid white;
      border-width: 0 3px 3px 0;
      -webkit-transform: rotate(45deg);
      -ms-transform: rotate(45deg);
      transform: rotate(45deg);
    }

  /* Radio Bootstrap*/
    .form-check-input {
      width: 1em;
      height: 1em;
      margin-top: .25em;
      vertical-align: top;
      background-color: #fff;
      background-repeat: no-repeat;
      background-position: center;
      background-size: contain;
      border: 1px solid rgba(0,0,0,.25);
      -webkit-appearance: none;
      -moz-appearance: none;
      appearance: none;
      -webkit-print-color-adjust: exact;
      color-adjust: exact;
      position: inherit;
    }
    .form-check-input[type=radio] {
        border-radius: 50%;
        cursor: pointer;
    }
    .form-check .form-check-input {
        float: left;
        margin-left: -1.5em;
    }
    .form-check-input:active{
      filter:brightness(90%);
    }
    .form-check-input:focus{
      border-color:#86b7fe;
      outline:0;
      box-shadow:0 0 0 .25rem rgba(13,110,253,.25);
    }
    .form-check-input:checked[type=radio]{
      background-color:#0d6efd;
      border-color: #0d6efd;
    }
    .form-check-input:checked[type=radio] {
      background-image: url("data:image/svg+xml,%3csvg xmlns='http://www.w3.org/2000/svg' viewBox='-4 -4 8 8'%3e%3ccircle r='2' fill='%23fff'/%3e%3c/svg%3e");
    }
  /*Spinner*/
    .content-loading-data {
      width: 100%;
      height: -webkit-fill-available;
      position: absolute;
    }
    .container-spinner-content-recibos {
      text-align: center;
      /* margin: 10px; */
      color: #266093;
      width: 100%;
      height: -webkit-fill-available;
      align-items: center;
      display: flex;
      justify-content: center;
      flex-direction: column;
      position: relative;
      background-color: rgb(255 255 255 / 72%);
      z-index: 1001;
    }
</style>

<div id="contenedor" class="container-fluid" style=" position: absolute; ">

    <h3 class="text-left">Rendición de cuentas (reporte de cobranza)</h3>
    <hr>
    <div id="contenedor_filtros">
        <form action="" id="form_polizas">
            <div class="panel panel-info" >
                <div class="panel-heading" id="panel_opciones">
                    <h5 class="text-center">Filtros de búsqueda <span class="caret"></span></h5>
                </div>
                <input type="hidden" value="<?=$this->tank_auth->get_idPersona()?>" id="idPersona_reporte">
                <div class="panel-body">
                    <!--Opciones pre resultados-->
                    <div class="panel-body" id="contenedorOpciones">
                    <div class="panel panel-default" id="panelOpciones">
                            <div class="panel-heading text-center"><i class="fa fa-university" aria-hidden="true"></i>&nbspSucursal</div>
                            <div class="panel-body" style="overflow-y: scroll; height: 200px;">
                                <table class="table">
                                        <tbody>
                                            <!--<tr>
                                                <td ><input type="checkbox" name="despacho_todos" id="despacho_todos" value="0"></td>
                                                <td class="text-left">TODOS</td>
                                            </tr>-->
                                            <tr>
                                                <td colspan="2">
                                                    <div style="display: inline-block; padding: 0px 0px 0.5px">
                                                        <input class="form-check-input" type="radio" id="excepcion_sucursal_i" name="excepcion_sucursal" value="0" checked>&nbsp<label for="excepcion_sucursal" class="label label-success">Igual</label>
                                                    </div>
                                                    <div style="display: inline-block; padding: 0px 0px 1px;">
                                                        <input class="form-check-input" type="radio" id="excepcion_sucursal_d" name="excepcion_sucursal" value="1">&nbsp<label for="excepcion_sucursal" class="label label-danger">Diferente</label>
                                                    </div>
                                                </td>
                                            </tr>
                                            <?php foreach($sucursal as $valor){?>
                                                <tr>
                                                    <td>
                                                        <div class="checkbox-container">
                                                            <label class="segment">
                                                            <input class="form-check-input checkbox-All despachoS" type="checkbox" name="despachoSicas[]" id="despacho_<?=$valor->idDespachoSicas?>" value="<?=$valor->idDespachoSicas?>">
                                                                <span class="checkmark"></span>
                                                            </label>
                                                        </div>
                                                    </td>
                                                    <td class="text-left"><label for="<?=$valor->idDespachoSicas?>"><?=$valor->NombreSucursal?></label></td>
                                                </tr>
                                            <?php }?>
                
                                        </tbody>
                                    </table>
                                <!--<select name="tiposucursal" id="tiposucursal" class="form-control">
                                    <option value="inicio">Seleccione</option>
                                    <?php foreach($sucursal as $valor){?> 
                                        <option value="<?=$valor->idDespachoSicas?>"><?=$valor->NombreSucursal?></option>
                                    <?php }?>
                                </select>-->
                            </div>
                        </div>
                        <div class="panel panel-default" id="panelOpciones">
                            <div class="panel-heading text-center"><i class="fa fa-certificate" aria-hidden="true"></i>&nbspTipos de ramos</div>
                            <div class="panel-body" style="overflow-y: scroll; height: 200px">
                                <table class="table">
                                    <tbody>
                                        <!--<tr>
                                            <td><input type="checkbox" name="todos" id="todos" value="0"></td>
                                            <td class="text-left">TODOS</td>
                                        </tr>-->
                                        <tr>
                                            <td colspan="2">
                                                <div style="display: inline-block; padding: 0px 0px 0.5px">
                                                    <input class="form-check-input" type="radio" id="excepcion_ramos_i" name="excepcion_ramos" value="0" checked>&nbsp<label for="excepcion_ramos" class="label label-success">Igual</label>
                                                </div>
                                                <div style="display: inline-block; padding: 0px 0px 1px;">
                                                    <input class="form-check-input" type="radio" id="excepcion_ramos_d" name="excepcion_ramos" value="1">&nbsp<label for="excepcion_ramos" class="label label-danger">Diferente</label>
                                                </div>
                                            </td>
                                        </tr>
                                        <?php foreach($ramosSicas as $valor){?>
                                            <tr>
                                                <td>
                                                    <div class="checkbox-container">
                                                        <label class="segment">
                                                        <input class="form-check-input checkbox-All ramoS" type="checkbox" name="ramosSicas[]" id="ramo_<?=$valor["idSicas"]?>" value="<?=$valor["idSicas"]?>">
                                                            <span class="checkmark"></span>
                                                        </label>
                                                    </div>
                                                </td>
                                                <td class="text-left"><label for="<?=$valor["idSicas"]?>"><?=$valor["nombre"]?></label></td>
                                            </tr>
                                        <?php }?>
            
                                    </tbody>
                                </table>
                            </div>
                        </div>
                        <div class="panel panel-default" id="panelOpciones">
                            <div class="panel-heading text-center"><i class="fa fa-users" aria-hidden="true"></i>&nbspGrupos</div>
                            <div class="panel-body" style="overflow-y: scroll; height: 200px">
                                <table class="table">
                                    <tbody>
                                        <!--<tr>
                                            <td><input type="checkbox" name="todosGrupos" id="todosGrupos" value="0"></td>
                                            <td class="text-left">TODOS</td>
                                        </tr>-->
                                        <tr>
                                            <td colspan="2">
                                                <div style="display: inline-block; padding: 0px 0px 0.5px">
                                                    <input class="form-check-input" type="radio" id="excepcion_grupos_i" name="excepcion_grupos" value="0" checked>&nbsp<label for="excepcion_grupos" class="label label-success">Igual</label>
                                                </div>
                                                <div style="display: inline-block; padding: 0px 0px 1px;">
                                                    <input class="form-check-input" type="radio" id="excepcion_grupos_d" name="excepcion_grupos" value="1">&nbsp<label for="excepcion_grupos" class="label label-danger">Diferente</label>
                                                </div>
                                            </td>
                                        </tr>
                                        <?php foreach($grupos as $valor){?>
                                            <tr>
                                                <td>
                                                    <div class="checkbox-container">
                                                        <label class="segment">
                                                        <input class="form-check-input checkbox-All gruposS" type="checkbox" name="grupoSicas[]" id="grupo_<?=$valor->IDGrupo?>" value="<?=$valor->IDGrupo?>">
                                                            <span class="checkmark"></span>
                                                        </label>
                                                    </div>
                                                </td>
                                                <td class="text-left"><label for="<?=$valor->IDGrupo?>"><?=$valor->Grupo?></label></td>
                                            </tr>
                                        <?php }?>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                        <div class="panel panel-default" id="panelOpciones"><!-- idUser: MFERNANDEZ2016 -->
                            <div class="panel-heading text-center">
                                <i class="fa fa-users" aria-hidden="true"></i>&nbspSubGrupos
                            </div>
                            <div class="panel-body" style="overflow-y: scroll; height: 200px">
                                <table class="table">
                                    <tbody>
                                        <!--<tr>
                                            <td><input type="checkbox" name="todosGrupos" id="todosGrupos" value="0"></td>
                                            <td class="text-left">TODOS</td>
                                        </tr>-->
                                        <tr>
                                            <td colspan="2">
                                                <div style="display: inline-block; padding: 0px 0px 0.5px">
                                                    <input class="form-check-input" type="radio" id="excepcion_sugrupos_i" name="excepcion_subgrupos" value="0" checked>&nbsp<label for="excepcion_subgrupos" class="label label-success">Igual</label>
                                                </div>
                                                <div style="display: inline-block; padding: 0px 0px 1px;">
                                                    <input class="form-check-input" type="radio" id="excepcion_subgrupos_d" name="excepcion_subgrupos" value="1">&nbsp<label for="excepcion_subgrupos" class="label label-danger">Diferente</label>
                                                </div>
                                            </td>
                                        </tr>
                                        <?php foreach($subgrupos as $valor){?>
                                            <tr>
                                                <td>
                                                    <div class="checkbox-container">
                                                        <label class="segment">
                                                        <input class="form-check-input checkbox-All subgruposS" type="checkbox" name="subgrupoSicas[]" id="subgrupo_<?=$valor->SubGrupo?>" value="<?=$valor->SubGrupo?>">
                                                            <span class="checkmark"></span>
                                                        </label>
                                                    </div>
                                                </td>
                                                <td class="text-left"><label for="<?=$valor->SubGrupo?>"><?=$valor->SubGrupo?></label></td>
                                            </tr>
                                        <?php }?>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                        <div class="panel panel-default" id="panelOpciones">
                            <div class="panel-heading text-center"><i class="fa fa-sitemap" aria-hidden="true"></i>&nbspCanales</div>
                            <div class="panel-body" style="overflow-y: scroll; height: 200px;">
                                <table class="table">
                                        <tbody>
                                            <!--<tr>
                                                <td><input type="checkbox" name="todos_canal" id="todos_canal" value="0"></td>
                                                <td class="text-left">TODOS</td>
                                            </tr>-->
                                            <tr>
                                                <td colspan="2">
                                                    <div style="display: inline-block; padding: 0px 0px 0.5px">
                                                        <input class="form-check-input" type="radio" id="excepcion_canales_i" name="excepcion_canales" value="0" checked>&nbsp<label for="excepcion_canales" class="label label-success">Igual</label>
                                                    </div>
                                                    <div style="display: inline-block; padding: 0px 0px 1px;">
                                                        <input class="form-check-input" type="radio" id="excepcion_canales_d" name="excepcion_canales" value="1">&nbsp<label for="excepcion_canales" class="label label-danger">Diferente</label>
                                                    </div>
                                                </td>
                                            </tr>
                                            <?php foreach($canales as $valor){?>
                                                <tr>
                                                    <td>
                                                        <div class="checkbox-container">
                                                            <label class="segment">
                                                            <input class="form-check-input checkbox-All canalS" type="checkbox" name="canalSicas[]" id="canal_<?=$valor->IDGerenciaSICAS?>" value="<?=$valor->IDGerenciaSICAS?>">
                                                                <span class="checkmark"></span>
                                                            </label>
                                                        </div>
                                                    </td>
                                                    <td class="text-left"><label for="<?=$valor->IDGerenciaSICAS?>"><?=$valor->nombreTitulo?></label></td>
                                                </tr>
                                            <?php }?>
                                        </tbody>
                                    </table>
                               <!--<select name="tipocanal" id="tipocanal" class="form-control">
                                    <option value="inicio">Seleccione</option>
                                    <?php foreach($canales as $valor){?>
                                        <option value="<?=$valor->IDGerenciaSICAS?>"><?=$valor->nombreTitulo?></option>
                                    <?php }?>
                               </select>-->
                            </div>
                        </div>
                        <div class="panel panel-default" id="panelOpciones">
                            <div class="panel-heading text-center"><i class="fa fa-user" aria-hidden="true"></i>&nbspVendedores</div>
                            <div class="panel-body" style="overflow-y: scroll; height: 200px;">
                                <table class="table">
                                        <tbody>
                                            <tr>
                                                <td colspan="2">
                                                    <div style="display: inline-block; padding: 0px 0px 0.5px">
                                                        <input class="form-check-input" type="radio" id="excepcion_vendedor_i" name="excepcion_vendedor" value="0" checked>&nbsp<label for="excepcion_vendedor" class="label label-success">Igual</label>
                                                    </div>
                                                    <div style="display: inline-block; padding: 0px 0px 1px;">
                                                        <input class="form-check-input" type="radio" id="excepcion_vendedor_d" name="excepcion_vendedor" value="1">&nbsp<label for="excepcion_vendedor" class="label label-danger">Diferente</label>
                                                    </div>
                                                </td>
                                            </tr>
                                            <!--<tr>
                                                <td><input type="checkbox" name="todos_vendedores" id="todos_vendedores" value="0"></td>
                                                <td class="text-left">TODOS</td>
                                            </tr>-->
                                            <?php 
                                                if(!in_array(7, $id_vendedores)){ ?>
                                                <tr>
                                                    <td>
                                                        <div class="checkbox-container">
                                                            <label class="segment">
                                                            <input class="form-check-input checkbox-All vendS" type="checkbox" name="vendSicas[]" id="vend_7" value="7">
                                                                <span class="checkmark"></span>
                                                            </label>
                                                        </div>
                                                        <input type="checkbox" class="form-check-input" name="vendSicas[]" id="vend_7" value="7" class="vendS"></td>
                                                    <td class="text-left"><label for="7">G.A.P AGENTES DE SEG. Y FIANZAS</label></td>
                                                </tr>
                                            <?php }
                                            ?>
                                            <?php foreach($vendedores as $valor){?>
                                                <tr>
                                                    <td>
                                                        <div class="checkbox-container">
                                                            <label class="segment">
                                                            <input class="form-check-input checkbox-All vendS" type="checkbox" name="vendSicas[]" id="vend_<?=$valor->idVend?>" value="<?=$valor->idVend?>">
                                                                <span class="checkmark"></span>
                                                            </label>
                                                        </div>
                                                    </td>
                                                    <td class="text-left"><label for="<?=$valor->idVend?>"><?=$valor->nombre." ".$valor->apellidoPaterno." ".$valor->apellidoMaterno?></label></td>
                                                </tr>
                                            <?php }?>
                                        </tbody>
                                    </table>
                               <!--<select name="tipocanal" id="tipocanal" class="form-control">
                                    <option value="inicio">Seleccione</option>
                                    <?php foreach($canales as $valor){?>
                                        <option value="<?=$valor->IDGerenciaSICAS?>"><?=$valor->nombreTitulo?></option>
                                    <?php }?>
                               </select>-->
                            </div>
                        </div>
                        <div class="panel panel-default" id="panelOpciones" style="height: 171px;">
                            <div class="panel-heading text-center">
                                <i class="fa fa-calendar" aria-hidden="true"></i>&nbspRango de fechas</div>
                            <div class="panel-body" style="vertical-align:top">
                                <table >
                                    <tbody>
                                        <tr>
                                            <td class="text-left">
                                                <label for="fechaI">Fecha inicio:</label>
                                            </td>
                                            <td class="text-left">
                                                <input type="text" class="fechaPersona" id="fechaI" name="fechaI">
                                            </td>
                                        </tr>
                                        <tr>
                                            <td class="text-left">
                                                <label for="fechaI" style="margin-top:15px;">Fecha final:</label>
                                            </td>
                                            <td class="text-left">
                                                <input type="text" class="fechaPersona" id="fechaF" name="fechaF" style="margin-top:15px;">
                                            </td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                        <div class="panel panel-default" id="panelOpciones">
                            <div class="panel-heading text-center"><i class="fa fa-folder-open" aria-hidden="true"></i>&nbspTipo de reporte</div>
                            <div class="panel-body">
                                <select name="tipoReporte" id="tipoReporte" class="form-control">
                                    <option value="inicio">Seleccione</option>
                                    <option value="0">Pendiente</option>
                                    <option value="3">Efectuada</option>
                                    <option value="10">Emitido</option>
                                    <!--<option value="2">Cancelada</option>-->
                                    <!--<option value="4">Liquidado</option>-->
                                    <option value="-1">Toda la cobranza</option>
                                </select>
                            </div>
                            <div class="panel-body">
                                <select name="tipoFechaDoc" id="tipoFechaDoc" class="form-control">
                                    <option value="inicio"></i>Fechas del recibo</option>
                                    <option value="FLimPago" id_option="1">Limite de Pago</option>
                                    <option value="FDocto" id_option="3">Fecha documento</option>
                                    <option value="FEmision" id_option="10">Emisión</option>
                                    <!--<option value="FDoctoPago" id_option="1">Emisión Docto de Pago</option>-->
                                    <option value="FHasta" id_option="5">Hasta</option>
                                    <option value="FDesde" id_option="5">Desde</option>
                                </select>
                            </div>
                        </div>
                    </div>
                    <button type="button" class="btn btn-info text-center" id="btn_consulta"><i class="fa fa-paper-plane" aria-hidden="true"></i>&nbspGenerar reporte</button>
                    <div class="panel-footer hidden">
                    </div>
                    <!--------------------->
                    <hr>
                    <!--Opciones post resultados-->
                    <!--<div class="panel-body" id="contenedorOpciones">
                        <div class="panel panel-default" id="panelOpciones">
                            <div class="panel-heading text-center">Filtro de resultados</div>
                            <div class="panel-body">
                                <select name="tipoFiltro" id="tipoFiltro" class="form-control" disabled>
                                    <option value="inicio">Seleccione</option>
                                    <option value="personal">Vendedores</option>
                                    <option value="fechaFiltro">Fecha</option>
                                    <option value="fechaFiltro">Polizas</option>
                                </select>
                            </div>
                        </div>
                        <div class="panel panel-default" id="panelOpciones" style="display:none">
                            <div class="panel-heading text-center">Filtro de fechas</div>
                            <div class="panel-body">
                                <select name="selectIdFechaFiltro" id="selectIdFechaFiltro" class="form-control" disabled>
                                    <option value="inicio   ">Seleccione</option>
                                    <option value="fDoctoPago">DoctoPago</option>
                                    <option value="fHasta">Hasta</option>
                                    <option value="fDesde">Desde</option>
                                    <option value="fLimPago">Limite de pago</option>
                                </select>
                            </div>
                        </div>
                        <div class="panel-footer text-center" style="margin-top:40px;">
                            <button class="btn btn-info" disabled>General filtrado</button>
                        </div>
                    </div>-->
                    <!--------------------->
                    <!--<h6 class="text-center" >Rango de fechas</h6>-->
                </div>
            </div>
        </form>
    </div>
    <div id="contenedor_resultado" style="display:none">
      <div class="content-loading-data hidden" id="CargarDatos"></div>
        <div class="panel panel-success">
            <div class="panel panel-heading"><h5 class="text-center"><i class="fa fa-check" aria-hidden="true"></i>&nbspReporte de resultados</h5></div>
            <div class="panel panel-body">
                <div role="tabpanel" id="tab_panel" style="width: 100%">
                
                </div>
                <div style="border: 1px red solid; display:none">
                    <table id="tabla_excel" style="display:none">
                        <thead>
                            <tr>
                                <td>Documento</td>
                                <td>Inciso</td>
                                <td>Periodo</td>
                                <td>Serie</td>
                                <td>Renovacion</td>
                                <td>FechaDocto</td>
                                <td>FDesde</td>
                                <td>FHasta</td>
                                <td>FLimPago</td>
                                <td>FStatus</td>
                                <td>Status_TXT</td>
                                <td>PrimaNeta</td>
                                <td>Recargos</td>
                                <td>Derechos</td>
                                <td>Impuesto1</td>
                                <td>PrimaTotal</td>                                
                                <td>Comision0</td>
                                <td>Comision1</td>
                                <td>Comision2</td>
                                <td>Comision3</td>
                                <td>Comision4</td>
                                <td>Comision5</td>
                                <td>Comision6</td>
                                <td>Comision7</td>
                                <td>Comision8</td>
                                <td>Comision9</td>
                                <td>Grupo</td>
                                <td>SubGrupo</td>
                                <td>CCobro_TXT</td>
                                <td>StatusDoc_Txt</td>
                                <td>Concepto</td>
                                <td>NombreCompleto</td>
                                <td>VendNombre</td>
                                <td>VendAbreviacion</td>
                                <td>FPago</td>
                                <td>Moneda</td>
                                <td>SRamoNombre</td>
                                <td>RamosNombre</td>
                                <td>IDVend</td>
                                <td>TipoDocto_TXT</td>
                                <td>TCPago</td>
                                <td>RenovacionDocto</td>
                                <td>FDoctoPago</td>
                                <td>FEmision</td>
                            </tr>
                        </thead>
                        <tbody id="row_doc">
                        </tbody>
                    </table>
                </div>
                <div style="border: 1px red solid; display:none">
                    <table id="tabla_excel_e_fianzas" style="display:none">
                        <thead>
                            <tr>
                                <td>Documento</td>
                                <td>Inciso</td>
                                <td>Periodo</td>
                                <td>Serie</td>
                                <td>Renovacion</td>
                                <td>FechaDocto</td>
                                <td>FDesde</td>
                                <td>FHasta</td>
                                <td>FLimPago</td>
                                <td>FStatus</td>
                                <td>Status_TXT</td>
                                <td>PrimaNeta</td>
                                <td>Recargos</td>
                                <td>Derechos</td>
                                <td>Impuesto1</td>
                                <td>PrimaTotal</td>                                
                                <td>Comision0</td>
                                <td>Comision1</td>
                                <td>Comision2</td>
                                <td>Comision3</td>
                                <td>Comision4</td>
                                <td>Comision5</td>
                                <td>Comision6</td>
                                <td>Comision7</td>
                                <td>Comision8</td>
                                <td>Comision9</td>
                                <td>Grupo</td>
                                <td>SubGrupo</td>
                                <td>CCobro_TXT</td>
                                <td>StatusDoc_Txt</td>
                                <td>Concepto</td>
                                <td>NombreCompleto</td>
                                <td>VendNombre</td>
                                <td>VendAbreviacion</td>
                                <td>FPago</td>
                                <td>Moneda</td>
                                <td>SRamoNombre</td>
                                <td>RamosNombre</td>
                                <td>IDVend</td>
                                <td>TipoDocto_TXT</td>
                                <td>TCPago</td>
                                <td>RenovacionDocto</td>
                                <td>FDoctoPago</td>
                                <td>FEmision</td>
                            </tr>
                        </thead>
                        <tbody id="row_doc_emitidos_fianzas">
                        </tbody>
                    </table>
                </div>
                    <div style="border: 1px red solid; display:none">
                    <table id="tabla_excel_p_fianzas" style="display:none">
                        <thead>
                            <tr>
                                <td>Documento</td>
                                <td>Inciso</td>
                                <td>Periodo</td>
                                <td>Serie</td>
                                <td>Renovacion</td>
                                <td>FechaDocto</td>
                                <td>FDesde</td>
                                <td>FHasta</td>
                                <td>FLimPago</td>
                                <td>FStatus</td>
                                <td>Status_TXT</td>
                                <td>PrimaNeta</td>
                                <td>Recargos</td>
                                <td>Derechos</td>
                                <td>Impuesto1</td>
                                <td>PrimaTotal</td>                                
                                <td>Comision0</td>
                                <td>Comision1</td>
                                <td>Comision2</td>
                                <td>Comision3</td>
                                <td>Comision4</td>
                                <td>Comision5</td>
                                <td>Comision6</td>
                                <td>Comision7</td>
                                <td>Comision8</td>
                                <td>Comision9</td>
                                <td>Grupo</td>
                                <td>SubGrupo</td>
                                <td>CCobro_TXT</td>
                                <td>StatusDoc_Txt</td>
                                <td>Concepto</td>
                                <td>NombreCompleto</td>
                                <td>VendNombre</td>
                                <td>VendAbreviacion</td>
                                <td>FPago</td>
                                <td>Moneda</td>
                                <td>SRamoNombre</td>
                                <td>RamosNombre</td>
                                <td>IDVend</td>
                                <td>TipoDocto_TXT</td>
                                <td>TCPago</td>
                                <td>RenovacionDocto</td>
                                <td>FDoctoPago</td>
                                <td>FEmision</td>
                            </tr>
                        </thead>
                        <tbody id="row_doc_pendiente_fianzas">
                        </tbody>
                    </table>
                </div>
                </div>
            </div>
        </div>
    </div>
</div>
<div id="gif_carga" style="margin:0 auto; text-align:center; position: relative; width: 100%; height: 735px; z-index:2; background-color: rgba(192, 192, 192, 0.6); display:none">
    <img src="<?php echo(base_url().'assets\img\loading.gif')?>" alt="" style="margin:0 auto; margin-top: 300px">
    <p style="font-weight: bold">Cargando información. Espere un momento</p>
</div>

<link rel="stylesheet" href="//code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
<link rel="stylesheet" href="/resources/demos/style.css">
<link href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.4/css/bootstrap.min.css" rel="stylesheet" media="screen"> 
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.4/js/bootstrap.min.js"></script>
<script src="https://code.jquery.com/jquery-1.12.4.js"></script>
<script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
<script src="<?=base_url()."assets/js/js_reporteDeCobranzaV7.js"?>"></script>

<script>
    $(function () {$(".fechaPersona").datepicker({//GMMI-4033-15
        closeText: 'Cerrar',prevText: 'Anterior',nextText: 'Siguiente',currentText: 'Hoy',
        monthNames: ['Enero','Febrero','Marzo','Abril','Mayo','Junio','Julio','Agosto','Septiembre','Octubre','Noviembre','Diciembre'],
        dayNames:['Domingo','Lunes','Martes','Mi&eacute;rcoles','Jueves','Viernes','S&aacute;bado'] ,
        dayNamesShort:['Dom','Lun','Mar','Mi&eacute;','Juv','Vie','S&aacute;b'],
        dayNamesMin: ['Do','Lu','Ma','Mi','Ju','Vi','S&aacute;'],
        dateFormat: 'dd/mm/yy',
        monthNamesShort:['Ene','Feb','Mar','Abr','May','Jun','Jul','Ago','Sep','Oct','Nov','Dic'],
        firstDay: 1,  
            changeMonth: true,
            changeYear: true,     
        }); 
    });
</script>
