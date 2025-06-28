<?php 
    $this->load->view("headers/header");
    $this->load->view("headers/menu");
?>

<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">

<div class="container-fluid">
    <div class="card-body"><h3>Reporte de pendientes de fianzas</h3></div>
    <hr>
    <div class="row card-body">
        <div class="col-md-4">
            <ul class="nav nav-tabs" id="tab_consulta" role="tablist">
                <li class="nav-item">
                    <a class="nav-link active" id="fecha-tab" data-toggle="tab" href="#fecha" role="tab" aria-controls="fecha" aria-selected="true">Fecha</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" id="canal-tab" data-toggle="tab" href="#canal" role="tab" aria-controls="canal" aria-selected="false">Canal</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" id="despacho-tab" data-toggle="tab" href="#despacho" role="tab" aria-controls="despacho" aria-selected="false">Despacho</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" id="ramo-tab" data-toggle="tab" href="#ramo" role="tab" aria-controls="ramo" aria-selected="false">Ramo</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" id="grupo-tab" data-toggle="tab" href="#grupo" role="tab" aria-controls="grupo" aria-selected="false">Grupo</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" id="reporte-tab" data-toggle="tab" href="#reporte" role="tab" aria-controls="reporte" aria-selected="false">Reporte</a>
                </li>
            </ul>
            <div class="tab-content" id="contenido_consulta">
                <!--<form action="#" id="form_">-->
                    <div class="tab-pane fade show active" id="fecha" role="tabpanel" aria-labelledby="fecha-tab">
                        <div class="card">
                            <div class="card-header text-center"><h4>Fecha</h4></div>
                            <div class="card-body table-reponsive">
                                <p>Seleccione un rango de fechas</p>
                                <table class="table table-sm">
                                    <tbody>
                                        <tr>
                                            <td>Fecha inicial</td>
                                            <td><input type="text" class="fechaPersona form-control form-control-sm" id="fechaI" name="fechaI"></td>
                                        </tr>
                                        <tr>
                                            <td>Fecha final</td>
                                            <td><input type="text" class="fechaPersona form-control form-control-sm" id="fechaF" name="fechaF"></td>
                                        </tr>
                                    </tbody>
                                </table>
                                <!--<div class="text-center"><button class="b_ff btn btn-primary btn-sm text-center">Seleccionar</button></div>-->
                            </div>
                        </div>
                    </div>
                    <div class="tab-pane fade" id="canal" role="tabpanel" aria-labelledby="canal-tab">
                        <div class="card">
                            <div class="card-header text-center"><h4>Canal</h4></div>
                            <div class="card-body table-responsive">
                                <p>Seleccione uno o varios canales</p>
                                <table class="table table-sm">
                                    <tbody>
                                        <tr>
                                            <td class="text-center">
                                                <input type="radio" value="0" name="valid_canal" checked>
                                                <label><span class="badge badge-success">Igual</span></label>
                                            </td>
                                            <td>
                                                <input type="radio" value="1" name="valid_canal">
                                                <label><span class="badge badge-danger">Diferente</span></label>
                                            </td>
                                        </tr>
                                        <?php foreach($canales as $d_c){ if($d_c->activo == 1){?>
                                            <tr>
                                                <td class="text-center"><input type="checkbox" name="ck_canal[]" id="canal_<?=$d_c->IdCanal?>" value="<?=$d_c->IDGerenciaSICAS?>" data-nombre="<?=$d_c->nombreTitulo?>"></td>
                                                <td><?=$d_c->nombreTitulo?></td>
                                            </tr>
                                        <?php }
                                        }?>
                                    </tbody>
                                </table>
                                <!--<div class="text-center">
                                    <button class="btn btn-primary btn-sm b_c">Seleccionar</button>
                                </div>-->
                            </div>
                        </div>
                    </div>
                    <div class="tab-pane fade" id="despacho" role="tabpanel" aria-labelledby="despacho-tab">
                        <div class="card">
                            <div class="card-header text-center"><h4>Despacho</h4></div>
                            <div class="card-body table-responsive">
                                <p>Seleccione uno o varios despachos</p>
                                <table class="table table-sm">
                                    <tbody>
                                        <tr>
                                            <td class="text-center">
                                                <input type="radio" value="0" name="valid_despacho" checked>
                                                <label><span class="badge badge-success">Igual</span></label>
                                            </td>
                                            <td>
                                                <input type="radio" value="1" name="valid_despacho">
                                                <label><span class="badge badge-danger">Diferente</span></label>
                                            </td>
                                        </tr>
                                        <?php foreach($sucursal as $valor){?>
                                            <tr>
                                                <td class="text-center"><input type="checkbox" name="despachoSicas[]" id="despacho_<?=$valor->idDespachoSicas?>" value="<?=$valor->idDespachoSicas?>" class="despachoS"></td>
                                                <td class="text-left"><label for="<?=$valor->idDespachoSicas?>"><?=$valor->NombreSucursal?></label></td>
                                            </tr>
                                        <?php }?>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                    <div class="tab-pane fade" id="ramo" role="tabpanel" aria-labelledby="ramo-tab">
                        <div class="card">
                            <div class="card-header text-center"><h4>Ramo</h4></div>
                            <div class="card-body table-responsive">
                                <p>Seleccione uno o varias opciones</p>
                                <table class="table table-sm">
                                    <tbody>
                                        <tr>
                                            <td class="text-center">
                                                <input type="radio" value="0" name="valid_ramo" checked>
                                                <label><span class="badge badge-success">Igual</span></label>
                                            </td>
                                            <td>
                                                <input type="radio" value="1" name="valid_ramo">
                                                <label><span class="badge badge-danger">Diferente</span></label>
                                            </td>
                                        </tr>
                                        <?php foreach($ramosSicas as $valor){?>
                                            <tr>
                                                <td class="text-center"><input type="checkbox" name="ramosSicas[]" id="ramo_<?=$valor["idSicas"]?>" value="<?=$valor["idSicas"]?>" class="ramoS"></td>
                                                <td class="text-left"><label for="<?=$valor["idSicas"]?>"><?=$valor["nombre"]?></label></td>
                                            </tr>
                                        <?php }?>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                    <div class="tab-pane fade" id="grupo" role="tabpanel" aria-labelledby="grupo-tab">
                        <div class="card">
                            <div class="card-header text-center"><h4>Grupo</h4></div>
                            <div class="card-body">
                                <p>Seleccione uno o varias opciones</p>
                                <table class="table table-sm">
                                    <tbody>
                                        <tr>
                                            <td class="text-center">
                                                <input type="radio" value="0" name="valid_grupo" checked>
                                                <label><span class="badge badge-success">Igual</span></label>
                                            </td>
                                            <td>
                                                <input type="radio" value="1" name="valid_grupo">
                                                <label><span class="badge badge-danger">Diferente</span></label>
                                            </td>
                                        </tr>
                                    <?php foreach($grupos as $valor){?>
                                        <tr>
                                            <td class="text-center"><input type="checkbox" name="grupoSicas[]" id="grupo_<?=$valor->IDGrupo?>" value="<?=$valor->IDGrupo?>" class="gruposS"></td>
                                            <td class="text-left"><label for="<?=$valor->IDGrupo?>"><?=$valor->Grupo?></label></td>
                                        </tr>
                                    <?php }?>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                    <div class="tab-pane fade" id="reporte" role="tabpanel" aria-labelledby="reporte-tab">
                        <div class="card">
                            <div class="card-header text-center"><h4>Tipos de reporte</h4></div>
                            <div class="card-body">
                                <label for="repote_select">Seleccione un tipo de reporte</label>
                                <select name="repote_select" id="repote_select" class="form-control">
                                    <option value="Inicio">Seleccione</option>
                                    <option value="0">Pendiente</option>
                                    <!--<option value="-1">Toda la cobranza</option>-->
                                </select>
                                <br>
                                <label for="fecha_docto">Seleccione un tipo fecha de documento</label>
                                <select name="fecha_docto" id="fecha_docto" class="form-control">
                                    <option value="Inicio">Seleccione</option>
                                    <option value="FLimPago">Fecha Limite de Pago</option>
                                </select>
                                <div class="text-center mt-3">
                                    <button class="btn btn-success envia_form">Generar reporte</button>
                                </div>
                            </div>
                        </div>
                    </div>
                <!--</form>-->
            </div>
        </div>
        <div class="col-md-7 ml-4 border border-dark">
            <div class="mt-3">
                <!--<div class="col-md-12">
                    <h4>Seguimiento seleccionado</h4>
                    
                        <div class="col-md-2"></div>
                        <div class="col-md-2"></div>
                        <div class="col-md-2"></div>
                        <div class="col-md-2"></div>
                        <div class="col-md-2"></div>
                        <div class="col-md-2"></div>
                </div>-->
                <div class="col-md-12 mt-3">
                    <h4>Resultado de Sicas</h4>
                    <div id="contenedor_agentes"></div>
                </div>
            </div>
        </div>
    </div>
</div>


<link rel="stylesheet" href="//code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
<link rel="stylesheet" href="/resources/demos/style.css">
<!--<script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous"></script>-->
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>
<!--<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>-->
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.2/js/bootstrap.min.js"></script>
<script src="https://code.jquery.com/jquery-1.12.4.js"></script>
<script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
<script src="<?=base_url()."assets/js/jQuery.reportePendientesFianzas.js"?>"></script>

<script>
    $(function () {$(".fechaPersona").datepicker({
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