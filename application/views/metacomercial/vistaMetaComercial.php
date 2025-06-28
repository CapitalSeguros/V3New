<?php 
    //cabecera
    $this->load->view('headers/header');
    //lista de opciones
    $this->load->view('headers/menu');
?>

<style>
    /*#contenedor_principal{
        width: 100%;
        height: 100%;
        
    }*/
    /*#contMes{
        width: 100%;
        height: 100%;
        text-align: center;
        align-content: center;
        margin: 0 auto;
        text-align: center
    }*/

</style>
<div id="contenedor_principal" class="container-fluid" style="position: absolute">
    <h3>Asignación de monto mensual</h3>
    <hr>

    <?php 

        $meses=array();
        $meses[1]="ENERO";
        $meses[2]="FEBRERO";
        $meses[3]="MARZO";
        $meses[4]="ABRIL";
        $meses[5]="MAYO";
        $meses[6]="JUNIO";
        $meses[7]="JULIO";
        $meses[8]="AGOSTO";
        $meses[9]="SEPTIEMBRE";
        $meses[10]="OCTUBRE";
        $meses[11]="NOVIEMBRE";
        $meses[12]="DICIEMBRE";
    ?>

    <div id="contenedor_hijo" class="col-xs-12">

        <!---->
        <ul class="nav nav-tabs nav-info navbar-dark bg-primary" id="myTab" role="tablist">
            <li class="nav-item">
                <a class="nav-link" id="contenedor_panel_agentes-tab" data-toggle="tab" href="#contenedor_panel_agentes" role="tab" aria-controls="contenedor_panel_agentes" aria-selected="true" onclick="muestra_contenido('asignar'); return false;">Asignar meta comercial</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" id="contenedor_panel_asignados-tab" data-toggle="tab" href="#contenedor_panel_asignados" role="tab" aria-controls="contenedor_panel_asignados" aria-selected="false" onclick="muestra_contenido('ver'); return false;">Ver asignaciones</a>
            </li>
            <li class="nav-item dropdown text-center" >
                <!--<a class="nav-link" id="contact-tab" data-toggle="tab" href="#contact" role="tab" aria-controls="contact" aria-selected="false">Contact</a>-->
                <label for="" style="font-size: 9px;">Tipo de meta</label>
                <select name="operacion_tipo" id="operacion_tipo" class="form-control form-control-sm">
                    <option value="0">Seleccione un tipo de meta</option>
                    <option value="1">Comisión</option>
                    <option value="2">Por ramos (primas y cantidad de pólizas)</option>
                </select>
            </li>
            <li class="nav-item">
                <!--<a class="nav-link" href="#contendor_envio_correos" id="contendor_envio_correos-tab" data-toggle="tab" role="tab" aria-controls="contendor_envio_correos" aria-selected="false" >Panel de envío de correos</a>-->
                <a class="nav-link" id="contendor_envio_correos-tab" data-toggle="tab" href="#contendor_envio_correos" role="tab" aria-controls="contendor_envio_correos" aria-selected="false" onclick="muestra_contenido('correo'); return false;">Panel de correos electrónicos</a>
            </li>
        </ul>
        <div class="tab-content" id="myTabContent">
        <!--<div class="tab-pane fade show active" id="contenedor_panel_agentes" role="tabpanel" aria-labelledby="contenedor_panel_agentes-tab">

        </div>
        <div class="tab-pane fade" id="contenedor_panel_asignados" role="tabpanel" aria-labelledby="contenedor_panel_asignados-tab">2</div>-->
   


        <!---->
            <form id="formularioAsigna">
                <div class="row">
                    <div id="contMes" class="col-xs-2 col-sm-2">
                        <!--<div class="panel panel-primary">
                            <div class="panel-heading"><h5>Operación</h5></div>
                            <div class="panel-body">
                                <select name="operacion" id="operacion" class="form-control">
                                    <option value="0">Seleccione</option>
                                    <option value="1">Asignar meta</option>
                                    <option value="2">Ver asignaciones</option>
                                </select>
                            </div>
                        </div>-->
                        <!--<div class="panel panel-primary">
                            <div class="panel-heading"><h5>Tipo de meta</h5></div>
                            <div class="panel-body">
                                <select name="operacion_tipo" id="operacion_tipo" class="form-control">
                                    <option value="0">Seleccione</option>
                                    <option value="1">Comisión</option>
                                    <option value="2">Por ramos (primas y cantidad de pólizas)</option>
                                </select>
                            </div>
                        </div>-->
                        <div class="panel panel-primary text-center">
                            <div class="panel-heading">
                                <h5>Seleccione un mes para ver el monto.</h5>
                            </div>
                            <div class="panel-body ">
                                <input type="hidden" value="<?=$this->tank_auth->get_usermail()?>" name="coordinador" id="coordinador">
                                <input type="hidden" value="<?=$this->tank_auth->get_idPersona()?>" name="idCoordinador" id="idCoordinador">

                                <select name="ramosRes" id="ramosRes" class="form-control" style="display:none">
                                    <option value="0">Seleccione</option>
                                    <option value="autos">AUTOS</option>
                                    <option value="vida">VIDA</option>
                                    <option value="danios">DAÑOS</option>
                                    <option value="gmm">GMM</option>
                                    <option value="fianzas">FIANZAS</option>
                                </select>
                                <br>
                                <select name="mesMonto" id="mesMonto" class="form-control">
                                <option value="0">Seleccione</option>
                                <?php
                                $idMeta=0;
                                if(!empty($datosMontos)){
                                    foreach($datosMontos as $valor){
                                    $idMeta=$valor->idMetaComercial;?>
                                    <option value="<?=$valor->mes_num?>"><?=$meses[$valor->mes_num]?></option>
                                <?php } }?>
                                </select>
                                
                                <select name="mesRamoA" id="mesRamoA" class="form-control" style="display:none"> 
                                    <option value="0">Seleccione</option>
                                    <?php foreach($datosEnRamos as $mes){?> 
                                        <option value="<?=$mes?>"><?=$meses[$mes]?></option>
                                    <?php }?>
                                </select>
                                <br>
                                <input type="hidden" name="metaComercial" value="<?=$idMeta?>" id="metacomer">
                                <button class="btn btn-primary" id="btn_buscar" style="display:none">Buscar</button>
                                <button class="btn btn-primary" id="btn_buscar_por_ramo" style="display:none">Buscar</button>
                            </div>
                        </div>
                        <!--<div class="tab-pane fade show active" role="tabpanel" aria-labelledby="contenedor_panel_agentes-tab" id="contenedor_panel_agentes">-->
                            <div class="panel panel-primary text-center" id="ejecutaOperacion" style="display:none">
                                <div class="panel-body">
                                    <button class="btn btn-primary" id="submitOperation">Asignar meta mensual</button>
                                    <button class="btn btn-primary" id="submitOperationRamo" style="display:none">Asignar meta por ramo</button>
                                </div>
                            </div>
                        <!--</div>-->
                        <!--<div class="panel panel-primary" id="ejecutaOperacionRamo" style="display:none">
                            <div class="panel-body text-center">
                                <button class="btn btn-primary" id="submitOperationRamo">Asignar meta por ramo</button>
                            </div>
                        </div>-->
                    </div> 
                    <div class="col-xs-12 col-sm-10" > <!--col-xs-12 col-sm-10-->
                        <div class="tab-pane fade" role="tabpanel" aria-labelledby="contenedor_panel_agentes-tab" id="contenedor_panel_agentes">
                            <div class="panel panel-info" id="panel_agentes">
                                <div class="panel-heading"><h4>Lista de agentes para asignación</h4></div>

                                <input type="hidden" name="cantidadMes" value="0" id="cantidadMes">
                                <input type="hidden" name="cantidadMes_poliza" value="0" id="cantidadMes_poliza">
                                <input type="hidden" name="cantidadMes_prima" value="0" id="cantidadMes_prima">

                                <div class="panel-body"><h4 id="montoM" class="text-center"></h4><h4 id="montoMRest" class="text-center"></h4></div>
                                <div class="panel-body" style="overflow-y: scroll; height: 400px">
                                    <table class="table" id="tabla_asignar">
                                        <thead>
                                            <tr class="active"> <!--aqui-->
                                                <th style="color: #524B49">NOMBRES</th>
                                                <th style="color: #524B49">CORREO ELECTRONICO</th>
                                                <th style="color: #524B49; display: none" class="text-center on_check">ASIGNAR <br> <label for="allCheck">Asignar a todos</label>&nbsp<input type="checkbox" name="todos" id="allCheck"></th>
                                                <th style="color: #524B49; display:none" class="text-center" id="cantidad_comision">CANTIDAD</th>
                                                <th style="color: #524B49; display:none" class="text-center" id="cantidad_polizas">CANTIDAD EN PÓLIZAS</th>
                                                <th style="color: #524B49; display:none" class="text-center" id="cantidad_primas">CANTIDAD EN PRIMA</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                    <?php foreach($datosPersonal as $agentes) {?> 
                                        <tr>
                                            <input type="hidden" name="idVend" value=<?=$agentes->IDVend?>>
                                            <input type="hidden" name="generacion" id="generacion_<?=$agentes->idPersona?>" value="NAS">
                                            <input type="hidden" name="tipoAsigna" id="tipoAsigna_<?=$agentes->idPersona?>" value="nuevo">
                                            <td><?=strtoupper($agentes->nombre)." ".strtoupper($agentes->apellidoPaterno)." ".strtoupper($agentes->apellidoMaterno)?></td>
                                            <td><?=$agentes->email?></td>
                                            <td class="text-center on_check" style="display: none"><input type="checkbox" id="check_<?=$agentes->idPersona?>" value=<?=$agentes->idPersona?> name="idPersona[]" onchange="habilitaCampo(<?=$agentes->idPersona?>,this);"></td>
                                            <td class="text-center in_comision" style="display: none" id="in_comision"><input type="number" name="montoAsignado_<?=$agentes->idPersona?>" id="montoAsignado_<?=$agentes->idPersona?>" class="form-control" disabled></td>
                                            <td class="text-center in_ramoPoliza" style="display: none" id="in_ramoPoliza"><input type="number" name="montoAsignado_polizas_<?=$agentes->idPersona?>" id="montoAsignado_polizas_<?=$agentes->idPersona?>" class="form-control" disabled></td>
                                            <td class="text-center in_ramoPrima" style="display: none" id="in_ramoPrima"><input type="number" name="montoAsignado_prima_<?=$agentes->idPersona?>" id="montoAsignado_prima_<?=$agentes->idPersona?>" class="form-control" disabled></td>
                                        </tr>
                                    <?php }?>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                        <div class="tab-pane fade show active" role="tabpanel" aria-labelledby="contenedor_panel_asignados-tab" id="contenedor_panel_asignados" >
                            <div class="panel panel-info" style="display: none" id="panel_agentes_asignados">
                                <div class="panel-heading"><h4>Lista de agentes con meta asignado</h4></div>
                                <div class="panel-body">
                                    <table class="table" id="table_asignados">
                                        <thead>
                                            <tr class="active">
                                                <th style="color: #524B49" class="text-center">NOMBRES</th>
                                                <th style="color: #524B49" class="text-center">CORREO ELECTRONICO</th>
                                                <th style="color: #524B49" class="text-center">MONTO ASIGNADO</th>
                                                <th style="color: #524B49" class="text-center">INGRESOS</th>
                                                <th style="color: #524B49" class="text-center">ASIGNACIÓN</th>
                                                <th style="color: #524B49" class="text-center">OPERACIÓN</th>
                                                <!--<th style="color: #524B49" class="text-center">INGRESOS DEL MES</th>-->
                                            </tr>
                                        </thead>
                                        <tbody id="cuerpoRegistro"></tbody>
                                        <tfoot id="pieRegistro"></tfoot>
                                    </table>
                                </div>
                            </div>
                            <div class="panel panel-info"  id="panel_agentes_asignados_ramos" style="display: none"> <!--style="display: none"-->
                                <div class="panel-heading"><h4>Lista de agentes con meta asignado en ramos</h4></div>
                                <div class="panel-body">
                                    <button type="button" class="btn btn-dark" id="btn_consulta_Sicas" style="display:none">Consultar a Sicas</button>
                                    <br>
                                    <table class="table" id="table_asignados">
                                        <thead>
                                            <tr class="active">
                                                <th style="color: #524B49" class="text-center">NOMBRES</th>
                                                <th style="color: #524B49" class="text-center">CORREO ELECTRONICO</th>
                                                <th style="color: #524B49" class="text-center">RAMO</th>
                                                <th style="color: #524B49" class="text-center">PÓLIZAS ASIGNADAS</th>
                                                <th style="color: #524B49" class="text-center">PRIMA ASIGNADA</th>
                                                <th style="color: #524B49" class="text-center">PÓLIZAS GENERADA</th>
                                                <th style="color: #524B49" class="text-center">PRIMA GENERADA</th>
                                                <th style="color: #524B49" class="text-center">ASIGNACIÓN</th>
                                                <th style="color: #524B49" class="text-center"><i class="fa fa-cog" aria-hidden="true"></i></th>
                                            </tr>
                                        </thead>
                                        <tbody id="cuerpoRegistroRamo"></tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                        <div class="tab-pane fade text-center" role="tabpanel" aria-labelledby="contendor_envio_correos-tab" id="contendor_envio_correos">
                            <div class="panel panel-default">
                                <div class="panel-heading">Envío de correos de aviso</div>
                                <div class="panel-body">
                                    <div class="jumbotron text-center">
                                    <button type="button" class="btn btn-primary btn-lg" id="btn_send_mails">Ejecutar envío</button>
                                    </div>
                                    <div class="panel panel-default">
                                        <div class="panel-body table-responsive" id="contenedor_pre_correos">
                                        <table class="table ">
                                            <thead>
                                                <tr>
                                                    <th>Nombre del asignado</th>
                                                    <th>Correo electrónico</th>
                                                    <th>Resultado</th>
                                                </tr>
                                            </thead>
                                            <tbody id="contenedor_correos_para_envio">
                                                <?php foreach($datosEnvioCorreo as $idPersona=>$info){ ?>
                                                    <tr id_persona="<?=$idPersona?>" id="tr_<?=$idPersona?>">
                                                        <td><?=$info["Nombre"]?></td>
                                                        <td><?=$info["Correo"]?></td>
                                                        <td id="td_confirma_envio_<?=$idPersona?>"></td>
                                                    </tr>
                                                <?php } ?>
                                            </tbody>
                                        </table>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>     
                </div>
            </form>
        </div>
    </div> <!--contenedor panel-->
</div>
<div style="text-align:center; align-content: center; align-items: center; position: relative; margin-top: 15%; display: none" id="cont_img_carga">
    <img src="<?php echo(base_url().'assets\img\loading.gif')?>" alt="">
    <p style="font-weight: bold">Cargando información. Espere un momento</p>
</div>

<!--<link rel="stylesheet" href="//code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
<link rel="stylesheet" href="/resources/demos/style.css">-->
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
<script src="<?=base_url()."assets/js/js_metacomercialCoordinador.js"?>"></script>
<!--<script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>-->
<!--<link href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.4/css/bootstrap.min.css" rel="stylesheet" media="screen"> 
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.4/js/bootstrap.min.js"></script>
<script src="https://code.jquery.com/jquery-1.12.4.js"></script>
<script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>-->

<!--<script>
    
</script>-->