<? $this->load->view('headers/header');
    $this->load->view('headers/menu'); ?>

<script src="https://cdn.ckeditor.com/4.11.1/standard/ckeditor.js"></script>
<link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.10.21/css/jquery.dataTables.css">

<div class="container">

<!--Boton de uso exclusivo para director, gerentes y coordinadores-->
    <?php
    /*if(in_array($this->tank_auth->get_usermail(),$correosDirectivos)){?>
        <div style="margin-top: 1%;width:90;text-align: right;">
            <a href="<?php echo base_url()?>fastFile/getAllVacaciones">
                <button type="button" name="btn_vacaciones" id="btn_vacaciones" class="btn btn-primary btn-md">
                <i class='fa fa-eye'></i>&nbsp;Ver Todos
                </button>
            </a>
        </div>
    <?php }*/
?>


<br>
<div class="row">
    <div class="col-md-8"><h3><i class="fa fa-plane"></i>&nbsp;Solicitudes de vacaciónes del personal a su cargo</h3></div>
    <div class="col-md-4">
        <ol class="breadcrumb">
            <li><a href="<?=base_url()?>">Inicio</a></li>
            <li class="active">Vacaciones</li>
        </ol>
    </div>
</div>
<hr>
            <div class="card">
                <div class="card-body">
                    <ul class="nav nav-tabs">
                        <li class="nav-item">
                            <a class="nav-link active" href="#L1" data-toggle="tab">
                            <i class="fa fa-file-o" aria-hidden="true"></i> Solicitudes
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="#L2" data-toggle="tab">
                            <i class="fa fa-table" aria-hidden="true"></i> Tablas de vacaciones
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="#L3" data-toggle="tab">
                            <i class="fa fa-list-ol" aria-hidden="true"></i> Reportes
                            </a>
                        </li>
                    </ul>
                    <div class="tab-content">
                    <div class="well table-responsive tab-pane active" style="background-color: #fff;" id="L1">

<br>
    <?php if($downloadList) {?>
        <button type="button" class="btn btn-primary pull-right mb-4 export-xls">Exportar solicitudes</button>
    <?php }?>
     <table class="table table-hover data-table-1" id="table_id" style="font-size: 11px;width: 100%">
        <thead>
            <tr>
                <th>Nombre del Solicitante</th>
                <th>Área</th>
                <th>Puesto</th>
                <th>Fecha de ingreso</th>
                <th>Periodo (antiguedad)</th>
                <th>Solicitudes aprobadas periodo anterior</th>
                <th>Solicitudes aprobadas periodo actual</th>
                <th>Ver solicitudes</th>
                <!--<th>
                    <i class="fa fa-cogs"></i>
                </th>
                <th>
                    <i class="fa fa-cogs"></i>
                </th>-->
            </tr>
        </thead>
        <tbody>
            <?php foreach($requesters as $dr) {
                
                $requests = array_reduce($dr["request"], function($acc, $curr){

                    if($curr["status"] == 1){
                        $acc["countPending"] ++;
                    } else{
                        $acc["totalCount"] ++;
                    }

                    return $acc;
                }, array("countPending" => 0, "totalCount" => 0));
                
                if(isset($dr["vacacionessolicitadas"]["anio2v"])){
                    $vacasanterior=$dr["vacacionessolicitadas"]["anio2v"];
                }else{
                    $vacasanterior=0;
                }
                if(isset($dr["vacacionessolicitadas"]["anio1v"])){
                    $vacasactual=$dr["vacacionessolicitadas"]["anio1v"];
                }else{
                    $vacasactual=0;
                }
                for($i=1; $i<=10; $i++){
                if(isset($dr["vacacionessolicitadas"]["anio".$i."v"])){
                    $vacas[$i]=$dr["vacacionessolicitadas"]["anio".$i."v"];
                }else{
                    $vacas[$i]=0;
                }
            }
            ?>
                <tr>
                    <td><?=$dr["requester"]?></td>
                    <td><?=strtoupper($dr["area"])?></td>
                    <td><?=strtoupper($dr["job"])?></td>
                    <td class="text-center"><?=$dr["initialJobDate"]?></td>
                    <td class="text-center"><?=$dr["period"]?></td>
                    <td class="text-center"><?=$vacasanterior?></td>
                    <td class="text-center"><?=$vacasactual?></td>
                    <td>
                        <button class="btn btn-default btn-sm get-vacation-request" data-id="<?=$dr["person"]?>" data-person="<?= $dr["requester"] ?>" data-show-all="false"><?= !empty($requests["countPending"]) ? "Pendientes" : "Solicitudes" ?> <span class="badge <?= !empty($requests["countPending"]) ? "bg-danger" : "" ?>"> <?= !empty($requests["countPending"]) ? $requests["countPending"] : $requests["totalCount"] ?> </span> </button>
                    </td>
                </tr>
            <?php }?>
        </tbody>
    </table>
    <table class="hidden border" id="for-export">
    <thead>
        <tr>
            <th>Nombre</th>
            <th>Area</th>
            <th>Puesto</th>
            <th>Fecha de ingreso</th>
            <th>Antiguedad</th>
            <th>Fecha de solicitud</th>
            <th>Primera fecha de descanso</th>
            <th>Fecha de retorno</th>
            <th>Dias solicitados</th>
            <th>Solicitudes 9 periodos anteriores</th>
            <th>Solicitudes 8 periodos anteriores</th>
            <th>Solicitudes 7 periodos anteriores</th>
            <th>Solicitudes 6 periodos anteriores</th>
            <th>Solicitudes 5 periodos anteriores</th>
            <th>Solicitudes 4 periodos anteriores</th>
            <th>Solicitudes 3 periodos anteriores</th>
            <th>Solicitudes 2 periodos anteriores</th>
            <th>Solicitudes periodo anterior</th>
            <th>Solicitudes periodo actual</th>
            <th>Respuesta</th>
        </tr>
    </thead>
    <tbody>
        <?php foreach($allRequest as $val){ 
            
                ?>
            <tr>
                <td><?= ucwords($val->nombre) ?></td>
                <td><?=$val->colaboradorArea?></td>
                <td><?=$val->personaPuesto?></td>
                <td><?= date("d/m/Y", strtotime($val->fecAltaSistemPersona)) ?></td>
                <td><?=$val->antiguedad?></td>
                <td><?= date("d/m/Y", strtotime($val->fecha)) ?></td>
                <td><?= date("d/m/Y", strtotime($val->fecha_salida)) ?></td>
                <td><?= date("d/m/Y", strtotime($val->fecha_retorno)) ?></td>
                <td><?=$val->cantidad_dias?></td>
                <td><?if(isset($requesters[$val->idPersona]["vacacionessolicitadas"]["anio10v"])){echo $requesters[$val->idPersona]["vacacionessolicitadas"]["anio10v"];}else{echo("0");}?></td>
                <td><?if(isset($requesters[$val->idPersona]["vacacionessolicitadas"]["anio9v"])){echo $requesters[$val->idPersona]["vacacionessolicitadas"]["anio9v"];}else{echo("0");}?></td>
                <td><?if(isset($requesters[$val->idPersona]["vacacionessolicitadas"]["anio8v"])){echo $requesters[$val->idPersona]["vacacionessolicitadas"]["anio8v"];}else{echo("0");}?></td>
                <td><?if(isset($requesters[$val->idPersona]["vacacionessolicitadas"]["anio7v"])){echo $requesters[$val->idPersona]["vacacionessolicitadas"]["anio7v"];}else{echo("0");}?></td>
                <td><?if(isset($requesters[$val->idPersona]["vacacionessolicitadas"]["anio6v"])){echo $requesters[$val->idPersona]["vacacionessolicitadas"]["anio6v"];}else{echo("0");}?></td>
                <td><?if(isset($requesters[$val->idPersona]["vacacionessolicitadas"]["anio5v"])){echo $requesters[$val->idPersona]["vacacionessolicitadas"]["anio5v"];}else{echo("0");}?></td>
                <td><?if(isset($requesters[$val->idPersona]["vacacionessolicitadas"]["anio4v"])){echo $requesters[$val->idPersona]["vacacionessolicitadas"]["anio4v"];}else{echo("0");}?></td>
                <td><?if(isset($requesters[$val->idPersona]["vacacionessolicitadas"]["anio3v"])){echo $requesters[$val->idPersona]["vacacionessolicitadas"]["anio3v"];}else{echo("0");}?></td>
                <td><?if(isset($requesters[$val->idPersona]["vacacionessolicitadas"]["anio2v"])){echo $requesters[$val->idPersona]["vacacionessolicitadas"]["anio2v"];}else{echo("0");}?></td>
                <td><?if(isset($requesters[$val->idPersona]["vacacionessolicitadas"]["anio1v"])){echo $requesters[$val->idPersona]["vacacionessolicitadas"]["anio1v"];}else{echo("0");}?></td>
                <td><?=$val->estado?></td>
            </tr>
        <?php }?>
    </tbody>
                    </table>
</div>
                <div class="tab-pane" id="L2">
                                    
                  

                    <div class="vacacionesTablaDiv">
    <table class="table">
        <thead>
            <tr>
                <th colspan="2">TABLA DE VACACIONES PARA PERIODOS 2022</th>
            </tr>
            <tr>
                <th>Años</th>
                <th>Dias</th>
            </tr>
        </thead>
        <tbody>
            <tr>
                <td>1er</td>
                <td>6 dias</td>
            </tr>
            <tr>
                <td>2do</td>
                <td>8 dias</td>
            </tr>
            <tr>
                <td>3er</td>
                <td>10 dias</td>
            </tr>
            <tr>
                <td>4to</td>
                <td>12 dias</td>
            </tr>
            <tr>
                <td>5 - 9</td>
                <td>14 dias</td>
            </tr>
            <tr>
                <td>10 - 14</td>
                <td>16 dias</td>
            </tr>
            <tr>
                <td>15 - 19</td>
                <td>18 dias</td>
            </tr>
            <tr>
                <td>20 - 24</td>
                <td>20 dias</td>
            </tr>
        </tbody>
    </table>
    <table class="table">
            <thead>
                <tr><th colspan="2">TABLA DE VACACIONES PARA PERIODOS 2023 O SUPERIORES</th></tr>
                <tr><th>Años</th><th>Dias</th></tr>
            </thead>
            <tbody>
                <?=imprimirVacacionesNuevas($nuevasVacaciones)?>
            </tbody>
    </table>
                    </div>
                </div>
                <div class="tab-pane" id="L3">
                            <!--Tabla reporte aniversario-->
                <h4 class="titleSection"><i class="fa fa-table" aria-hidden="true"></i> Reporte aniversario vacaciones</h4>
                <hr class="title-hr">
                <div class="row">
                    <div class="col-md-12" style="font-size:16px;">
                        Busqueda por: &nbsp;&nbsp;&nbsp;
                    
                        <input type="radio"  style="height:16px; width:16px;" value="1" name="tipoBusqueda" id="radioColaborador">
                        <label for="radioColaborador" style="font-size: 16px;">Colaborador</label>
                        &nbsp;&nbsp;
                        <input type="radio" style="height:16px; width:16px;" value="2" name="tipoBusqueda" id="radioFecha" >
                        <label for="radioFecha" style="font-size: 16px;"> Fecha</label>
                        &nbsp;&nbsp;
                        <input type="radio" style="height:16px; width:16px;" value="3" name="tipoBusqueda" id="radioAmbos" >
                        <label for="radioAmbos" style="font-size: 16px;"> Ambos</label>
  
                </div>
                    <div class="col-md-6"><select class="form-control" id="selectColaborador">
                    <?php foreach($reporteAniversario as $vac){ ?> 
                        <option value="<?=$vac->idPersona?>"><?=$vac->apellidoPaterno." ".$vac->apellidoMaterno." ".$vac->nombres?></option>
                        <?php }?> 
                    </select></div>
                    <div class="col-md-3"><input type="date" class="form-control " id="FchaFiltroVacas"></div>
                    <div class="col-md-3"><button type="button" class="btn btn-primary" onclick="buscarReportes()" >Buscar</button></div>
                </div>
                <button type="button" class="btn btn-primary pull-right mb-4 export-xls-aniversario">Exportar reporte</button>
                <!--<?=var_dump($reporteAniversario)?>-->
                    <table class="table table-hover data-table-3" id="tablaAniversario" style="font-size: 12px; width: 100% !important">
                        <thead>
                            <tr>
                                <th>Nombre</th>
                                <th style="text-align: center !important">Fecha de ingreso</th>
                                <th style="text-align: center !important">Antiguedad cumplida</th>
                                <th style="text-align: center !important">Mes antiguedad</th>
                                <th style="text-align: center !important">D&iacute;as del periodo anual</th>
                                <th style="text-align: center !important">D&iacute;as aprobados</th>
                                <th style="text-align: center !important">D&iacute;as faltantes</th>

                            </tr>
                        </thead>
                        <tbody id="tbodyAniversario">
                            <?php foreach($reporteAniversario as $vac){ 
                                if($vac->dias==null){
                                    $dias=0;
                                    $diasFaltantes=0;
                                }else{
                                    $dias=$vac->dias;
                                    $diasFaltantes=$vac->diasFaltantes;
                                }
                                    ?>
                                <tr class="text-center">
                                    <td style="text-align: left !important"><?=$vac->apellidoPaterno." ".$vac->apellidoMaterno." ".$vac->nombres?></td>
                                    <td><?=$vac->fecha_alta?></td>
                                    <td><?=$vac->antiguedad?></td>
                                    <td><?=$vac->mes_antiguedad?></td>
                                    <td><?=$dias?></td>
                                    <td><?=$vac->diasAprobados?></td>
                                    <td><?=$diasFaltantes?></td>
                                </tr>
                            <?php }?>    
                        </tbody>
                    </table>
                    <table class="hidden" id="for-export-aniversario" >
                        <thead>
                            <tr>
                                <th>Id</th>
                                <th>Apellido Paterno</th>
                                <th>Apellido Materno</th>
                                <th>Nombres</th>
                                <th>Fecha de ingreso</th>
                                <th>Antiguedad cumplida</th>
                                <th>Mes antiguedad</th>
                                <th>Dias del periodo anual</th>
                                <th>Dias aprobados</th>
                                <th>Dias faltantes</th>

                            </tr>
                        </thead>
                        <tbody id="tbodyAniversario_xls">
                            <?php foreach($reporteAniversario as $vac){ 
                                if($vac->dias==null){
                                    $dias=0;
                                    $diasFaltantes=0;
                                }else{
                                    $dias=$vac->dias;
                                    $diasFaltantes=$vac->diasFaltantes;
                                }
                                    ?>
                                <tr>
                                    <td><?=$vac->idPersona?></td>
                                    <td><?=$vac->apellidoPaterno?></td>
                                    <td><?=$vac->apellidoMaterno?></td>
                                    <td><?=$vac->nombres?></td>
                                    <td><?=$vac->fecha_alta?></td>
                                    <td><?=$vac->antiguedad?></td>
                                    <td><?=$vac->mes_antiguedad?></td>
                                    <td><?=$dias?></td>
                                    <td><?=$vac->diasAprobados?></td>
                                    <td><?=$diasFaltantes?></td>
                                </tr>
                            <?php }?>    
                        </tbody>
                    </table>
                    <br><br>
                            <!--Tabla reporte vacaciones solicitud-->
                        <h4 class="titleSection"><i class="fa fa-table" aria-hidden="true"></i> Reporte solicitud vacaciones</h4>
                        <hr class="title-hr">
                        <button type="button" class="btn btn-primary pull-right mb-4 export-xls-solicitud">Exportar reporte</button>
                        <table class="table table-hover data-table-4" id="tablaSolicitud" style="font-size: 12px; width: 100% !important">
                        <thead>
                            <tr>
                                <th>Nombre</th>
                                <th style="text-align: center !important">Antiguedad</th>
                                <th style="text-align: center !important">Cantidad de d&iacute;as</th>
                                <th style="text-align: center !important">Fecha solicitud</th>
                                <th style="text-align: center !important">Primer d&iacute;a de descanso</th>
                                <th style="text-align: center !important">Fecha retorno</th>
                                <th style="text-align: center !important">Estado</th>
                                <th style="text-align: center !important">Autoriz&oacute;</th>

                            </tr>
                        </thead>
                        <tbody id="tbodySolicitud">
                            <?php foreach($reporteSolicitadas as $sol){ 
                                    ?>
                                <tr class="text-center">
                                    <td style="text-align: left !important"><?=$sol->nombre?></td>
                                    <td><?=$sol->antiguedad?></td>
                                    <td><?=$sol->cantidad_dias?></td>
                                    <td><?=$sol->fecha?></td>
                                    <td><?=$sol->fecha_salida?></td>
                                    <td><?=$sol->fecha_retorno?></td>
                                    <td><?=$sol->estado?></td>
                                    <td><?=$sol->correoJefeDirecto?></td>
                                </tr>
                            <?php }?>    
                        </tbody>
                    </table>
                    <table class="hidden" id="for-export-solicitud" >
                        <thead>
                            <tr>
                                <th>Id</th>
                                <th>Nombre</th>
                                <th>Antiguedad</th>
                                <th>Cantidad de dias</th>
                                <th>Fecha solicitud</th>
                                <th>Primer dia de descanso</th>
                                <th>Fecha retorno</th>
                                <th>Estado</th>
                                <th>Autorizo</th>

                            </tr>
                        </thead>
                        <tbody id="tbodySolicitud_xls">
                            <?php foreach($reporteSolicitadas as $sol){ 
                                
                                    ?>
                                <tr>
                                    <td><?=$sol->idPersona?></td>
                                    <td><?=$sol->nombre?></td>
                                    <td><?=$sol->antiguedad?></td>
                                    <td><?=$sol->cantidad_dias?></td>
                                    <td><?=$sol->fecha?></td>
                                    <td><?=$sol->fecha_salida?></td>
                                    <td><?=$sol->fecha_retorno?></td>
                                    <td><?=$sol->estado?></td>
                                    <td><?=$sol->correoJefeDirecto?></td>
                                </tr>
                            <?php }?>    
                        </tbody>
                    </table>
                            </div>
            </div>

        </div>
    </div>



</div>

<!------------------------------->
<div class="modal fade vacation-list" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">
      <div class="modal-header">
        <h4 class="modal-title" id="myModalLabel">Solicitud(es) de: <span class="requester"></span></h4>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
      </div>
      <div class="modal-body request-list">
        <!--<div class="request-list"></div>-->
        <!--<div class="preview-file-content mt-4"></div>-->
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button>
      </div>
    </div>
  </div>
</div>
<!------------------------------->
<input type="hidden" id="base_url" data-base-url="<?=base_url()?>">

<script type="text/javascript" charset="utf8" src="https://cdn.datatables.net/1.10.21/js/jquery.dataTables.js"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.2/js/bootstrap.min.js"></script>
<script type="text/javascript" src="<?= base_url() ?>assets/js/jquery.vacations.js"></script> <!-- Dennis Castillo [2022-06-16] -->
<style type="text/css">
    .vacacionesTablaDiv{display: flex;}
    .vacacionesTablaDiv>table{margin-right: 5px}
</style>
<!--<script type="text/javascript">
  $(document).ready( function () {
     $('#table_id').DataTable( {
        "language": {
            "lengthMenu": "Mostrar _MENU_ Registros por Pagina",
            "zeroRecords": "No se encontraron registros",
            "info": "Mostrar Pagina por Pagina",
            "infoEmpty": "No hay registros disponibles",
            "infoFiltered": "(Filtrado de _MAX_ total registros)",
            "search":"Buscar",
            "paginate": {
            "previous": "Anterior",
            "next": "Siguiente"
        }
        }
    } );
} );
</script>
<script type="text/javascript">
    function setAprobar(id,tabla){
        var op=confirm("¿Es Ud. seguro de aprobar dicha solictud de vacaciones?");
        if(op==1){
            document.location.href='<?php echo base_url()?>fastFile/setAprobar?id='+id+"&tabla="+tabla;
        }
    }
    function setNegar(id,tabla){
        var op=confirm("¿Es Ud. seguro de negar dicha solictud de vacaciones?");
        if(op==1){
            document.location.href='<?php echo base_url()?>fastFile/setNegar?id='+id+"&tabla="+tabla;
        }
    }
</script>-->
<?
function imprimirVacacionesNuevas($array)
{
    $tr='';
    foreach ($array as  $value) 
    {
      $tr.='<tr><td>'.$value->anio.'</td><td>'.$value->dias.'</td></tr>';
    }
    return $tr;
}
?>
<script>
    function buscarReportes(){
        const seleccion = document.querySelector('input[name="tipoBusqueda"]:checked');
        if (seleccion) {
            const colaborador=document.getElementById("selectColaborador").value;
            const fecha = document.getElementById("FchaFiltroVacas").value;
            const url = `<?=base_url()?>fastFile/busquedaVacaciones`;
            let formData = new FormData();
            formData.append('tipo',seleccion.value);
            formData.append('colaborador',colaborador);
            formData.append('fecha',fecha);

            $.ajax({
            type: 'POST',
            url: url,
            dataType: 'html',
            data: formData,
            cache: false,
            contentType: false, 
            processData: false,
            beforeSend: (load) => {
                $('#tbodyAniversario').html(`
                   	<td colspan="7" class="container-spinner-content-loading text-center" style="height: 650px;">
                   	    <div class="bd-spinner spinner-border" role="status">
                   	        <span class="visually-hidden"></span>
                   	    </div>
                   	    <p class="bd-cargando" style="font-size:18px;">Cargando...</p>
                   	</td>
                `);
                $('#tbodySolicitud').html(`
                   	<td colspan="7" class="container-spinner-content-loading text-center" style="height: 650px;">
                   	    <div class="bd-spinner spinner-border" role="status">
                   	        <span class="visually-hidden"></span>
                   	    </div>
                   	    <p class="bd-cargando" style="font-size:18px;">Cargando...</p>
                   	</td>
                `);
                
            },
            success: (data) => {
                const r = JSON.parse(data);
                console.log(r);
                aniversario=r["reporteAniversario"];
                solicitadas=r["reporteSolicitadas"];
                trtd=``;
                trtd_xls=``;
                trtdSoli=``;
                trtdSoli_xls=``;
                for (const a in aniversario) {
                    let dias = aniversario[a].dias ?? 0;
                    let diasFaltantes = aniversario[a].diasFaltantes ?? 0;
                                trtd+=`<tr class="text-center">
                                    <td style="text-align: left !important">${aniversario[a].apellidoPaterno} ${aniversario[a].apellidoMaterno} ${aniversario[a].nombres}</td>
                                    <td>${aniversario[a].fecha_alta}</td>
                                    <td>${aniversario[a].antiguedad}</td>
                                    <td>${aniversario[a].mes_antiguedad}</td>
                                    <td>${dias}</td>
                                    <td>${aniversario[a].diasAprobados}</td>
                                    <td>${diasFaltantes}</td>'
                                </tr>`;
                                trtd_xls+= `<tr>
                                    <td>${aniversario[a].idPersona}</td>
                                    <td>${aniversario[a].apellidoPaterno}</td>
                                    <td>${aniversario[a].apellidoMaterno}</td>
                                    <td>${aniversario[a].nombres}</td>
                                    <td>${aniversario[a].fecha_alta}</td>
                                    <td>${aniversario[a].antiguedad}</td>
                                    <td>${aniversario[a].mes_antiguedad}</td>
                                    <td>${dias}</td>
                                    <td>${aniversario[a].diasAprobados}</td>
                                    <td>${diasFaltantes}</td>
                                </tr>`
                }
                for (const s in solicitadas) {
                                trtdSoli+=`<tr class="text-center">
                                    <td style="text-align: left !important">${solicitadas[s].nombre}</td>
                                    <td>${solicitadas[s].antiguedad}</td>
                                    <td>${solicitadas[s].cantidad_dias}</td>
                                    <td>${solicitadas[s].fecha}</td>
                                    <td>${solicitadas[s].fecha_salida}</td>
                                    <td>${solicitadas[s].fecha_retorno}</td>
                                    <td>${solicitadas[s].estado}</td>
                                    <td>${solicitadas[s].correoJefeDirecto}</td>
                                </tr>`;
                                trtdSoli_xls+= `<tr>
                                    <td>${solicitadas[s].idPersona}</td>
                                    <td>${solicitadas[s].nombre}</td>
                                    <td>${solicitadas[s].antiguedad}</td>
                                    <td>${solicitadas[s].cantidad_dias}</td>
                                    <td>${solicitadas[s].fecha}</td>
                                    <td>${solicitadas[s].fecha_salida}</td>
                                    <td>${solicitadas[s].fecha_retorno}</td>
                                    <td>${solicitadas[s].estado}</td>
                                    <td>${solicitadas[s].correoJefeDirecto}</td>
                                </tr>`
                }
                $('#tbodyAniversario').html(trtd);
                $('#tbodyAniversario_xls').html(trtd_xls);
                $('#tbodySolicitud').html(trtdSoli);
                $('#tbodySolicitud_xls').html(trtdSoli_xls);
                
            },
            error: (error) => {
                console.log(error);
            }
        });
            console.log(seleccion.value, colaborador, fecha);
        } else {
            alert("Por favor selecciona un tipo de busqueda.");
        }
        

    }
</script>
