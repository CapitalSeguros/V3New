<?php 
    $ci =& get_instance();
    $ci->load->library("libreriav3");
    $months4 = $ci->libreriav3->devolverMeses();
    //var_dump($months);
?>

<div class="row">
    <div class="col-md-12 col-lg-12">
        <div style="margin: 1%;">
        <h4>COMISIÓN</h4>        
         <i class="fa fa-money"></i><b>&nbsp;FIANZAS</b>
        </div>
    </div>
</div>

<div class="row">
    <!-- Reporte anio pasado-->
    <div class="col-sm-6 col-md-6">
        <div class="well" style="background-color: #fff;">
             <div class="panel panel-default">
                <div class="panel-heading" style="font-size: 12px">
                    <i class="fa fa-calendar-check-o"></i> REPORTE AÑO PASADO <?php echo date('Y')-1;?><br>
                 </div>
             </div>
             <div id="grafico" style="width: 100%;height:auto;">
                <div class="filter-past-fianzas">
                    <a class="btn btn-primary btn-sm" data-toggle="collapse" href="#filter-past1-fianzas" aria-expanded="false" aria-controls="filter-past1-fianzas">
                        Filtros
                    </a>
                    <div class="collapse" id="filter-past1-fianzas">
                        <div class="panel panel-body mt-2">
                            <div class="col-md-12 mb-2">
                                <div class="row">
                                    <div class="col-md-1">Años</div>
                                    <div class="col-md-4">
                                        <select id="past-years-comission-fianzas" class="form-control form-control-sm">
                                            <option value="">Seleccione</option>
                                            <option value="2021">2021</option>
                                            <option value="2020">2020</option>
                                            <option value="2019">2019</option>
                                        </select>
                                    </div>
                                <div class="col-md-1">Meses</div>
                                <div class="col-md-4">
                                    <select id="past-months-comission-fianzas" class="form-control form-control-sm">
                                        <option value="">Seleccione</option>
                                        <?php foreach($months4 as $num => $name){?>
                                            <option value="<?=$num?>"><?=$name?></option>
                                        <?php }?>
                                    </select>
                                </div>
                                </div>
                            </div>
                            <div class="col-md-12">
                                <div class="row">
                                    <div class="col-md-1">Ver</div>
                                    <div class="col-md-4">
                                        <select id="past-montly-type-comission-fianzas" class="form-control form-control-sm">
                                            <option value="">Seleccione</option>
                                            <option value="trimestral">Trimestral</option>
                                            <option value="mensual">Mensual</option>
                                            <option value="total">Completo</option>
                                        </select>
                                    </div>
                                    <div class="col-md-2 text-center">
                                        <button class="btn btn-primary btn-sm filter-past-data-fianzas" data-filter="budget-fianzas">Filtrar</button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <canvas id="myChartPresupuestoComisionPasadoFianzas"></canvas>
             </div> 
             <div id="cuadro">
                 <table class="table table-responsive" style="font-size: 11px;"> 
                     <thead>
                     <tr>
                         <th><b>FIANZAS</b></th>
                         <th>ENE</th>
                         <th>FEB</th>
                         <th>MAR</th>
                         <th>ABR</th>
                         <th>MAY</th>   
                         <th>JUN</th>
                         <th>JUL</th>
                         <th>AGO</th>
                         <th>SEP</th>
                         <th>OCT</th>
                         <th>NOV</th>
                         <th>DIC</th>
                     </tr>
                     </thead>
                     <tbody class="body-table-past-comission-fianzas">
                        <tr>
                         <td><b>IngresosTotales:</b></td>
                         <td><?php echo number_format((($comisionPasadoFianzas1[0]->Fianzas)+($comisionPasadoFianzas1[1]->Fianzas)+($comisionPasadoFianzas1[2]->Fianzas)),2);?></td>
                         <td><?php echo number_format((($comisionPasadoFianzas2[0]->Fianzas)+($comisionPasadoFianzas2[1]->Fianzas)+($comisionPasadoFianzas2[2]->Fianzas)),2);?></td>
                        <td><?php echo number_format((($comisionPasadoFianzas3[0]->Fianzas)+($comisionPasadoFianzas3[1]->Fianzas)+($comisionPasadoFianzas3[2]->Fianzas)),2);?></td>
                         <td><?php echo number_format((($comisionPasadoFianzas4[0]->Fianzas)+($comisionPasadoFianzas4[1]->Fianzas)+($comisionPasadoFianzas4[2]->Fianzas)),2);?></td>
                          <td><?php echo number_format((($comisionPasadoFianzas5[0]->Fianzas)+($comisionPasadoFianzas5[1]->Fianzas)+($comisionPasadoFianzas5[2]->Fianzas)),2);?></td>
                         <td><?php echo number_format((($comisionPasadoFianzas6[0]->Fianzas)+($comisionPasadoFianzas6[1]->Fianzas)+($comisionPasadoFianzas6[2]->Fianzas)),2);?></td>
                         <td><?php echo number_format((($comisionPasadoFianzas7[0]->Fianzas)+($comisionPasadoFianzas7[1]->Fianzas)+($comisionPasadoFianzas7[2]->Fianzas)),2);?></td>
                         <td><?php echo number_format((($comisionPasadoFianzas8[0]->Fianzas)+($comisionPasadoFianzas8[1]->Fianzas)+($comisionPasadoFianzas8[2]->Fianzas)),2);?></td>
                         <td><?php echo number_format((($comisionPasadoFianzas9[0]->Fianzas)+($comisionPasadoFianzas9[1]->Fianzas)+($comisionPasadoFianzas9[2]->Fianzas)),2);?></td>
                         <td><?php echo number_format((($comisionPasadoFianzas10[0]->Fianzas)+($comisionPasadoFianzas10[1]->Fianzas)+($comisionPasadoFianzas10[2]->Fianzas)),2);?></td>
                         <td><?php echo number_format((($comisionPasadoFianzas11[0]->Fianzas)+($comisionPasadoFianzas11[1]->Fianzas)+($comisionPasadoFianzas11[2]->Fianzas)),2);?></td>
                         <td><?php echo number_format((($comisionPasadoFianzas12[0]->Fianzas)+($comisionPasadoFianzas12[1]->Fianzas)+($comisionPasadoFianzas12[2]->Fianzas)),2);?></td>
                     </tr>
                    </tbody>
                </table>
            </div>

        </div> 
    </div>
    <!-- -->
    <!-- Reporte anio actual-->
    <div class="col-sm-6 col-md-6">
        <div class="well" style="background-color: #fff;">
             <div class="panel panel-default">
                <div class="panel-heading" style="font-size: 12px">
                    <i class="fa fa-calendar-check-o"></i> REPORTE AÑO ACTUAL <?php echo date('Y');?><br>
                 </div>
             </div>
             <div id="grafico" style="width: 100%;height:auto;padding: 1%;">
                <div class="filter-present">
                    <a class="btn btn-primary btn-sm" data-toggle="collapse" href="#filter-present1-fianzas" aria-expanded="false" aria-controls="filter-present1-fianzas">
                        Filtros
                    </a>
                    <div class="collapse" id="filter-present1-fianzas">
                        <div class="panel panel-body mt-2">
                            <div class="col-md-12 mb-2">
                                <div class="row">
                                    <div class="col-md-1">Meses</div>
                                    <div class="col-md-4">
                                        <select id="present-months-comission-fianzas" class="form-control form-control-sm">
                                            <option value="">Seleccione</option>
                                            <?php foreach($months4 as $num => $name){?>
                                                <option value="<?=$num?>"><?=$name?></option>
                                            <?php }?>
                                        </select>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-12">
                                <div class="row">
                                    <div class="col-md-1">Ver</div>
                                    <div class="col-md-4">
                                        <select id="present-montly-type-comission-fianzas" class="form-control form-control-sm">
                                            <option value="">Seleccione</option>
                                            <option value="trimestral">Trimestral</option>
                                            <option value="mensual">Mensual</option>
                                            <option value="total">Completo</option>
                                        </select>
                                    </div>
                                    <div class="col-md-2 text-center">
                                        <button class="btn btn-primary btn-sm filter-present-data-fianzas" data-filter="budget-fianzas">Filtrar</button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <canvas id="myChartPresupuestoComisionFianzas"></canvas>
             </div> 
             <div id="cuadro">
                 <table class="table table-responsive" style="font-size: 11px;"> 
                     <thead>
                     <tr>
                         <th><b>FIANZAS</b></th>
                         <th>ENE</th>
                         <th>FEB</th>
                         <th>MAR</th>
                         <th>ABR</th>
                         <th>MAY</th>   
                         <th>JUN</th>
                         <th>JUL</th>
                         <th>AGO</th>
                         <th>SEP</th>
                         <th>OCT</th>
                         <th>NOV</th>
                         <th>DIC</th>
                     </tr>
                     </thead>
                    <tbody class="body-table-present-comission-fianzas">
                        <tr>
                         <td><b>IngresosTotales:</b></td>
                         <td><?php echo number_format((($comisionActualFianzas1[0]->Fianzas)+($comisionActualFianzas1[1]->Fianzas)+($comisionActualFianzas1[2]->Fianzas)),2);?></td>
                         <td><?php echo number_format((($comisionActualFianzas2[0]->Fianzas)+($comisionActualFianzas2[1]->Fianzas)+($comisionActualFianzas2[2]->Fianzas)),2);?></td>
                        <td><?php echo number_format((($comisionActualFianzas3[0]->Fianzas)+($comisionActualFianzas3[1]->Fianzas)+($comisionActualFianzas3[2]->Fianzas)),2);?></td>
                         <td><?php echo number_format((($comisionActualFianzas4[0]->Fianzas)+($comisionActualFianzas4[1]->Fianzas)+($comisionActualFianzas4[2]->Fianzas)),2);?></td>
                          <td><?php echo number_format((($comisionActualFianzas5[0]->Fianzas)+($comisionActualFianzas5[1]->Fianzas)+($comisionActualFianzas5[2]->Fianzas)),2);?></td>
                         <td><?php echo number_format((($comisionActualFianzas6[0]->Fianzas)+($comisionActualFianzas6[1]->Fianzas)+($comisionActualFianzas6[2]->Fianzas)),2);?></td>
                         <td><?php echo number_format((($comisionActualFianzas7[0]->Fianzas)+($comisionActualFianzas7[1]->Fianzas)+($comisionActualFianzas7[2]->Fianzas)),2);?></td>
                         <td><?php echo number_format((($comisionActualFianzas8[0]->Fianzas)+($comisionActualFianzas8[1]->Fianzas)+($comisionActualFianzas8[2]->Fianzas)),2);?></td>
                         <td><?php echo number_format((($comisionActualFianzas9[0]->Fianzas)+($comisionActualFianzas9[1]->Fianzas)+($comisionActualFianzas9[2]->Fianzas)),2);?></td>
                         <td><?php echo number_format((($comisionActualFianzas10[0]->Fianzas)+($comisionActualFianzas10[1]->Fianzas)+($comisionActualFianzas10[2]->Fianzas)),2);?></td>
                         <td><?php echo number_format((($comisionActualFianzas11[0]->Fianzas)+($comisionActualFianzas11[1]->Fianzas)+($comisionActualFianzas11[2]->Fianzas)),2);?></td>
                         <td><?php echo number_format((($comisionActualFianzas12[0]->Fianzas)+($comisionActualFianzas12[1]->Fianzas)+($comisionActualFianzas12[2]->Fianzas)),2);?></td>
                     </tr>
                    </tbody>
                </table>
            </div>
        </div> 
    </div>
    <!-- -->
</div>

<!--GASTOS-->
<div class="row">
    <div class="col-md-12 col-lg-12">
        <div style="margin: 1%;">
        <h4>COSTO VENTA, GASTOS OPERACIONES, NOMINA</h4>
         <i class="fa fa-money"></i><b>&nbsp;FIANZAS</b>
        </div>
    </div>
</div>
<div class="row">
    <!-- Reporte anio pasado-->
    <div class="col-sm-6 col-md-6">
        <div class="well" style="background-color: #fff;">
             <div class="panel panel-default">
                <div class="panel-heading" style="font-size: 12px">
                    <i class="fa fa-calendar-check-o"></i> REPORTE AÑO PASADO <?php echo date('Y')-1;?><br>
                 </div>
             </div>
             <div id="grafico" style="width: 100%;height:auto;">
                <div class="filter-past-fianzas">
                    <a class="btn btn-primary btn-sm" data-toggle="collapse" href="#filter-past2-fianzas" aria-expanded="false" aria-controls="filter-past2-fianzas">
                        Filtros
                    </a>
                    <div class="collapse" id="filter-past2-fianzas">
                        <div class="panel panel-body mt-2">
                            <div class="col-md-12 mb-2">
                                <div class="row">
                                    <div class="col-md-1">Años</div>
                                    <div class="col-md-4">
                                        <select id="past-years-others-fianzas" class="form-control form-control-sm">
                                            <option value="">Seleccione</option>
                                            <option value="2021">2021</option>
                                            <option value="2020">2020</option>
                                            <option value="2019">2019</option>
                                        </select>
                                    </div>
                                <div class="col-md-1">Meses</div>
                                <div class="col-md-4">
                                    <select id="past-months-others-fianzas" class="form-control form-control-sm">
                                        <option value="">Seleccione</option>
                                        <?php foreach($months4 as $num => $name){?>
                                            <option value="<?=$num?>"><?=$name?></option>
                                        <?php }?>
                                    </select>
                                </div>
                                </div>
                            </div>
                            <div class="col-md-12">
                                <div class="row">
                                    <div class="col-md-1">Ver</div>
                                    <div class="col-md-4">
                                        <select id="past-montly-type-others-fianzas" class="form-control form-control-sm">
                                            <option value="">Seleccione</option>
                                            <option value="trimestral">Trimestral</option>
                                            <option value="mensual">Mensual</option>
                                            <option value="total">Completo</option>
                                        </select>
                                    </div>
                                    <div class="col-md-2 text-center">
                                        <button class="btn btn-primary btn-sm filter-past-data-fianzas" data-filter="other-fianzas">Filtrar</button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <canvas id="myChartPresupuestoGastosPasadoFianzas"></canvas>
             </div>
             <div id="cuadro">
                 <table class="table table-responsive" style="font-size: 11px;"> 
                     <thead>
                     <tr>
                         <th><b>FIANZAS</b></th>
                         <th>ENE</th>
                         <th>FEB</th>
                         <th>MAR</th>
                         <th>ABR</th>
                         <th>MAY</th>   
                         <th>JUN</th>
                         <th>JUL</th>
                         <th>AGO</th>
                         <th>SEP</th>
                         <th>OCT</th>
                         <th>NOV</th>
                         <th>DIC</th>
                     </tr>
                     </thead>
                     <tbody class="body-table-past-others-fianzas">
                        <tr>
                         <td><b>Gastos Totales:</b></td>
                         <td><?php echo (($costoVentaPasadoFianzas1[0]->total)+($gastoOperacionesPasadoFianzas1[0]->total)+($nominaPasadoFianzas1[0]->total))?></td>
                         <td><?php echo (($costoVentaPasadoFianzas2[0]->total)+($gastoOperacionesPasadoFianzas2[0]->total)+($nominaPasadoFianzas2[0]->total))?></td>
                         <td><?php echo (($costoVentaPasadoFianzas3[0]->total)+($gastoOperacionesPasadoFianzas3[0]->total)+($nominaPasadoFianzas3[0]->total))?></td>
                         <td><?php echo (($costoVentaPasadoFianzas4[0]->total)+($gastoOperacionesPasadoFianzas4[0]->total)+($nominaPasadoFianzas4[0]->total))?></td>
                         <td><?php echo (($costoVentaPasadoFianzas5[0]->total)+($gastoOperacionesPasadoFianzas5[0]->total)+($nominaPasadoFianzas5[0]->total))?></td>
                         <td><?php echo (($costoVentaPasadoFianzas6[0]->total)+($gastoOperacionesPasadoFianzas6[0]->total)+($nominaPasadoFianzas6[0]->total))?></td>
                         <td><?php echo (($costoVentaPasadoFianzas7[0]->total)+($gastoOperacionesPasadoFianzas7[0]->total)+($nominaPasadoFianzas7[0]->total))?></td>
                         <td><?php echo (($costoVentaPasadoFianzas8[0]->total)+($gastoOperacionesPasadoFianzas8[0]->total)+($nominaPasadoFianzas8[0]->total))?></td>
                         <td><?php echo (($costoVentaPasadoFianzas9[0]->total)+($gastoOperacionesPasadoFianzas9[0]->total)+($nominaPasadoFianzas9[0]->total))?></td>
                         <td><?php echo (($costoVentaPasadoFianzas10[0]->total)+($gastoOperacionesPasadoFianzas10[0]->total)+($nominaPasadoFianzas10[0]->total))?></td>
                         <td><?php echo (($costoVentaPasadoFianzas11[0]->total)+($gastoOperacionesPasadoFianzas11[0]->total)+($nominaPasadoFianzas11[0]->total))?></td>
                         <td><?php echo (($costoVentaPasadoFianzas12[0]->total)+($gastoOperacionesPasadoFianzas12[0]->total)+($nominaPasadoFianzas12[0]->total))?></td>
                     </tr>
                    </tbody>
                </table>
            </div> 
        </div> 
    </div>
    <!-- Reporte anio actual-->
    <div class="col-sm-6 col-md-6">
        <div class="well" style="background-color: #fff;">
             <div class="panel panel-default">
                <div class="panel-heading" style="font-size: 12px">
                    <i class="fa fa-calendar-check-o"></i> REPORTE AÑO ACTUAL <?php echo date('Y');?><br>
                 </div>
             </div>
             <div id="grafico" style="width: 100%;height:auto;padding: 1%;">
                <div class="filter-present">
                    <a class="btn btn-primary btn-sm" data-toggle="collapse" href="#filter-present2-fianzas" aria-expanded="false" aria-controls="filter-present2-fianzas">
                        Filtros
                    </a>
                    <div class="collapse" id="filter-present2-fianzas">
                        <div class="panel panel-body mt-2">
                            <div class="col-md-12 mb-2">
                                <div class="row">
                                    <div class="col-md-1">Meses</div>
                                    <div class="col-md-4">
                                        <select id="present-months-others-fianzas" class="form-control form-control-sm">
                                            <option value="">Seleccione</option>
                                            <?php foreach($months4 as $num => $name){?>
                                                <option value="<?=$num?>"><?=$name?></option>
                                            <?php }?>
                                        </select>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-12">
                                <div class="row">
                                    <div class="col-md-1">Ver</div>
                                    <div class="col-md-4">
                                        <select id="present-montly-type-others-fianzas" class="form-control form-control-sm">
                                            <option value="">Seleccione</option>
                                            <option value="trimestral">Trimestral</option>
                                            <option value="mensual">Mensual</option>
                                            <option value="total">Completo</option>
                                        </select>
                                    </div>
                                    <div class="col-md-2 text-center">
                                        <button class="btn btn-primary btn-sm filter-present-data-fianzas" data-filter="other-fianzas">Filtrar</button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <canvas id="myChartPresupuestoGastosFianzas"></canvas>
             </div> 
              <div id="cuadro">
                 <table class="table table-responsive" style="font-size: 11px;"> 
                     <thead>
                     <tr>
                         <th><b>FIANZAS</b></th>
                         <th>ENE</th>
                         <th>FEB</th>
                         <th>MAR</th>
                         <th>ABR</th>
                         <th>MAY</th>   
                         <th>JUN</th>
                         <th>JUL</th>
                         <th>AGO</th>
                         <th>SEP</th>
                         <th>OCT</th>
                         <th>NOV</th>
                         <th>DIC</th>
                     </tr>
                     </thead>
                     <tbody class="body-table-present-others-fianzas">
                        <tr>
                         <td><b>Gastos Totales:</b></td>
                         <td><?php echo (($costoVentaFianzas1[0]->total)+($gastoOperacionesFianzas1[0]->total)+($nominaFianzas1[0]->total))?></td>
                         <td><?php echo (($costoVentaFianzas2[0]->total)+($gastoOperacionesFianzas2[0]->total)+($nominaFianzas2[0]->total))?></td>
                         <td><?php echo (($costoVentaFianzas3[0]->total)+($gastoOperacionesFianzas3[0]->total)+($nominaFianzas3[0]->total))?></td>
                         <td><?php echo (($costoVentaFianzas4[0]->total)+($gastoOperacionesFianzas4[0]->total)+($nominaFianzas4[0]->total))?></td>
                         <td><?php echo (($costoVentaFianzas5[0]->total)+($gastoOperacionesFianzas5[0]->total)+($nominaFianzas5[0]->total))?></td>
                         <td><?php echo (($costoVentaFianzas6[0]->total)+($gastoOperacionesFianzas6[0]->total)+($nominaFianzas6[0]->total))?></td>
                          <td><?php echo (($costoVentaFianzas7[0]->total)+($gastoOperacionesFianzas7[0]->total)+($nominaFianzas7[0]->total))?></td>
                         <td><?php echo (($costoVentaFianzas8[0]->total)+($gastoOperacionesFianzas8[0]->total)+($nominaFianzas8[0]->total))?></td>
                         <td><?php echo (($costoVentaFianzas9[0]->total)+($gastoOperacionesFianzas9[0]->total)+($nominaFianzas9[0]->total))?></td>
                         <td><?php echo (($costoVentaFianzas10[0]->total)+($gastoOperacionesFianzas10[0]->total)+($nominaFianzas10[0]->total))?></td>
                         <td><?php echo (($costoVentaFianzas11[0]->total)+($gastoOperacionesFianzas11[0]->total)+($nominaFianzas11[0]->total))?></td>
                          <td><?php echo (($costoVentaFianzas12[0]->total)+($gastoOperacionesFianzas12[0]->total)+($nominaFianzas12[0]->total))?></td>
                     </tr>
                    </tbody>
                </table>
            </div>
        </div> 
    </div>
    <!-- -->
</div>


<!--RESUMEN FIANZAS-->
 <div class="row">
    <!-- Reporte anio pasado-->
    <div class="col-sm-6 col-md-6">
        <div class="well" style="background-color: #fff;">
             <div class="panel panel-default">
                <div class="panel-heading" style="font-size: 12px">
                    <i class="fa fa-calendar-check-o"></i> RESUMEN FIANZAS AÑO PASADO <?php echo date('Y')-1;?><br>
                 </div>
                <table class="table table-responsive" style="font-size: 11px;">
                <thead>
                    <tr>
                         <th><b>FIANZAS</b></th>
                         <th>ENE</th>
                         <th>FEB</th>
                         <th>MAR</th>
                         <th>ABR</th>
                         <th>MAY</th>   
                         <th>JUN</th>
                         <th>JUL</th>
                         <th>AGO</th>
                         <th>SEP</th>
                         <th>OCT</th>
                         <th>NOV</th>
                         <th>DIC</th>
                    </tr>
                </thead>
                <tbody>
                     <tr style="background-color: #FAFAFA;text-align: right;">
                         <td><b>Ingres. Totales:</b></td>
                         <td><?php echo  number_format((($comisionPasadoFianzas1[0]->Fianzas)+($comisionPasadoFianzas1[1]->Fianzas)+($comisionPasadoFianzas1[2]->Fianzas)),2)?></td>

                           <td><?php echo  number_format((($comisionPasadoFianzas2[0]->Fianzas)+($comisionPasadoFianzas2[1]->Fianzas)+($comisionPasadoFianzas2[2]->Fianzas)),2)?></td>

                           <td><?php echo  number_format((($comisionPasadoFianzas3[0]->Fianzas)+($comisionPasadoFianzas3[1]->Fianzas)+($comisionPasadoFianzas3[2]->Fianzas)),2)?></td>

                           <td><?php echo  number_format((($comisionPasadoFianzas4[0]->Fianzas)+($comisionPasadoFianzas4[1]->Fianzas)+($comisionPasadoFianzas4[2]->Fianzas)),2)?></td>

                           <td><?php echo  number_format((($comisionPasadoFianzas5[0]->Fianzas)+($comisionPasadoFianzas5[1]->Fianzas)+($comisionPasadoFianzas5[2]->Fianzas)),2)?></td>

                           <td><?php echo  number_format((($comisionPasadoFianzas6[0]->Fianzas)+($comisionPasadoFianzas6[1]->Fianzas)+($comisionPasadoFianzas6[2]->Fianzas)),2)?></td>

                           <td><?php echo  number_format((($comisionPasadoFianzas7[0]->Fianzas)+($comisionPasadoFianzas7[1]->Fianzas)+($comisionPasadoFianzas7[2]->Fianzas)),2)?></td>

                           <td><?php echo  number_format((($comisionPasadoFianzas8[0]->Fianzas)+($comisionPasadoFianzas8[1]->Fianzas)+($comisionPasadoFianzas8[2]->Fianzas)),2)?></td>

                           <td><?php echo  number_format((($comisionPasadoFianzas9[0]->Fianzas)+($comisionPasadoFianzas9[1]->Fianzas)+($comisionPasadoFianzas9[2]->Fianzas)),2)?></td>

                           <td><?php echo  number_format((($comisionPasadoFianzas10[0]->Fianzas)+($comisionPasadoFianzas10[1]->Fianzas)+($comisionPasadoFianzas10[2]->Fianzas)),2)?></td>
                          
                           <td><?php echo  number_format((($comisionPasadoFianzas11[0]->Fianzas)+($comisionPasadoFianzas11[1]->Fianzas)+($comisionPasadoFianzas11[2]->Fianzas)),2)?></td>

                           <td><?php echo  number_format((($comisionPasadoFianzas12[0]->Fianzas)+($comisionPasadoFianzas12[1]->Fianzas)+($comisionPasadoFianzas12[2]->Fianzas)),2)?></td>
                     </tr>
                     <tr style="background-color: #F2F2F2;text-align: right;">
                         <td><b>Gastos Totales:</b></td>
                         <td><?php echo  number_format((($costoVentaPasadoFianzas1[0]->total)+($gastoOperacionesPasadoFianzas1[0]->total)+ ($nominaPasadoFianzas1[0]->total)),2);?></td>

                           <td><?php echo  number_format((($costoVentaPasadoFianzas2[0]->total)+($gastoOperacionesPasadoFianzas2[0]->total)+ ($nominaPasadoFianzas2[0]->total)),2);?></td>

                           <td><?php echo  number_format((($costoVentaPasadoFianzas3[0]->total)+($gastoOperacionesPasadoFianzas3[0]->total)+ ($nominaPasadoFianzas3[0]->total)),2);?></td>

                           <td><?php echo  number_format((($costoVentaPasadoFianzas4[0]->total)+($gastoOperacionesPasadoFianzas4[0]->total)+ ($nominaPasadoFianzas4[0]->total)),2);?></td>

                           <td><?php echo  number_format((($costoVentaPasadoFianzas5[0]->total)+($gastoOperacionesPasadoFianzas5[0]->total)+ ($nominaPasadoFianzas5[0]->total)),2);?></td>

                           <td><?php echo  number_format((($costoVentaPasadoFianzas6[0]->total)+($gastoOperacionesPasadoFianzas6[0]->total)+ ($nominaPasadoFianzas6[0]->total)),2);?></td>

                           <td><?php echo  number_format((($costoVentaPasadoFianzas7[0]->total)+($gastoOperacionesPasadoFianzas7[0]->total)+($nominaPasadoFianzas7[0]->total)),2);?></td>

                           <td><?php echo  number_format((($costoVentaPasadoFianzas8[0]->total)+($gastoOperacionesPasadoFianzas8[0]->total)+ ($nominaPasadoFianzas8[0]->total)),2);?></td>

                           <td><?php echo  number_format((($costoVentaPasadoFianzas9[0]->total)+($gastoOperacionesPasadoFianzas9[0]->total)+ ($nominaPasadoFianzas9[0]->total)),2);?></td>
                          
                           <td><?php echo  number_format((($costoVentaPasadoFianzas10[0]->total)+($gastoOperacionesPasadoFianzas10[0]->total)+ ($nominaPasadoFianzas10[0]->total)),2);?></td>

                           <td><?php echo  number_format((($costoVentaPasadoFianzas11[0]->total)+($gastoOperacionesPasadoFianzas11[0]->total)+ ($nominaPasadoFianzas11[0]->total)),2);?></td>

                           <td><?php echo  number_format((($costoVentaPasadoFianzas12[0]->total)+($gastoOperacionesPasadoFianzas12[0]->total)+ ($nominaPasadoFianzas12[0]->total)),2);?></td>
                     </tr>
                      <tr style="background-color: #08298A;color: #fff;text-align: right;">
                         <td><b>Utilidad/Pedida:</b></td>
                         <td><?php echo number_format( 
                            ((($comisionPasadoFianzas1[0]->Fianzas)+($comisionPasadoFianzas1[1]->Fianzas)+($comisionPasadoFianzas1[2]->Fianzas)) - (($costoVentaPasadoFianzas1[0]->total)+($gastoOperacionesPasadoFianzas1[0]->total)+ ($nominaPasadoFianzas1[0]->total))),2);?></td>

                           <td><?php echo number_format( 
                            ((($comisionPasadoFianzas2[0]->Fianzas)+($comisionPasadoFianzas2[1]->Fianzas)+($comisionPasadoFianzas2[2]->Fianzas)) - (($costoVentaPasadoFianzas2[0]->total)+($gastoOperacionesPasadoFianzas2[0]->total)+ ($nominaPasadoFianzas2[0]->total))),2);?></td>

                           <td><?php echo number_format( 
                            ((($comisionPasadoFianzas3[0]->Fianzas)+($comisionPasadoFianzas3[1]->Fianzas)+($comisionPasadoFianzas3[2]->Fianzas)) - (($costoVentaPasadoFianzas3[0]->total)+($gastoOperacionesPasadoFianzas3[0]->total)+ ($nominaPasadoFianzas3[0]->total))),2);?></td>

                           <td><?php echo number_format( 
                            ((($comisionPasadoFianzas4[0]->Fianzas)+($comisionPasadoFianzas4[1]->Fianzas)+($comisionPasadoFianzas4[2]->Fianzas)) - (($costoVentaPasadoFianzas4[0]->total)+($gastoOperacionesPasadoFianzas4[0]->total)+ ($nominaPasadoFianzas4[0]->total))),2);?></td>

                           <td><?php echo number_format( 
                            ((($comisionPasadoFianzas5[0]->Fianzas)+($comisionPasadoFianzas5[1]->Fianzas)+($comisionPasadoFianzas5[2]->Fianzas)) - (($costoVentaPasadoFianzas5[0]->total)+($gastoOperacionesPasadoFianzas5[0]->total)+ ($nominaPasadoFianzas5[0]->total))),2);?></td>

                           <td><?php echo number_format( 
                            ((($comisionPasadoFianzas6[0]->Fianzas)+($comisionPasadoFianzas6[1]->Fianzas)+($comisionPasadoFianzas6[2]->Fianzas)) - (($costoVentaPasadoFianzas6[0]->total)+($gastoOperacionesPasadoFianzas6[0]->total)+ ($nominaPasadoFianzas6[0]->total))),2);?></td>

                           <td><?php echo number_format( 
                            ((($comisionPasadoFianzas7[0]->Fianzas)+($comisionPasadoFianzas7[1]->Fianzas)+($comisionPasadoFianzas7[2]->Fianzas)) - (($costoVentaPasadoFianzas7[0]->total)+($gastoOperacionesPasadoFianzas7[0]->total)+ ($nominaPasadoFianzas7[0]->total))),2);?></td>

                            <td><?php echo number_format( 
                            ((($comisionPasadoFianzas8[0]->Fianzas)+($comisionPasadoFianzas8[1]->Fianzas)+($comisionPasadoFianzas8[2]->Fianzas)) - (($costoVentaPasadoFianzas8[0]->total)+($gastoOperacionesPasadoFianzas8[0]->total)+ ($nominaPasadoFianzas8[0]->total))),2);?></td>

                           <td><?php echo number_format( 
                            ((($comisionPasadoFianzas9[0]->Fianzas)+($comisionPasadoFianzas9[1]->Fianzas)+($comisionPasadoFianzas9[2]->Fianzas)) - (($costoVentaPasadoFianzas9[0]->total)+($gastoOperacionesPasadoFianzas9[0]->total)+ ($nominaPasadoFianzas9[0]->total))),2);?></td>
                          
                            <td><?php echo number_format( 
                            ((($comisionPasadoFianzas10[0]->Fianzas)+($comisionPasadoFianzas10[1]->Fianzas)+($comisionPasadoFianzas10[2]->Fianzas)) - (($costoVentaPasadoFianzas10[0]->total)+($gastoOperacionesPasadoFianzas10[0]->total)+ ($nominaPasadoFianzas10[0]->total))),2);?></td>

                           <td><?php echo number_format( 
                            ((($comisionPasadoFianzas11[0]->Fianzas)+($comisionPasadoFianzas11[1]->Fianzas)+($comisionPasadoFianzas11[2]->Fianzas)) - (($costoVentaPasadoFianzas11[0]->total)+($gastoOperacionesPasadoFianzas11[0]->total)+ ($nominaPasadoFianzas11[0]->total))),2);?></td>

                            <td><?php echo number_format( 
                            ((($comisionPasadoFianzas12[0]->Fianzas)+($comisionPasadoFianzas12[1]->Fianzas)+($comisionPasadoFianzas12[2]->Fianzas)) - (($costoVentaPasadoFianzas12[0]->total)+($gastoOperacionesPasadoFianzas12[0]->total)+ ($nominaPasadoFianzas12[0]->total))),2);?></td>
                     </tr>
                </tbody>
            </table>
            </div>
        </div>
    </div>
     <!-- Reporte anio pasado-->
    <div class="col-sm-6 col-md-6">
        <div class="well" style="background-color: #fff;">
             <div class="panel panel-default">
                <div class="panel-heading" style="font-size: 12px">
                    <i class="fa fa-calendar-check-o"></i> RESUMEN FIANZAS AÑO ACTUAL <?php echo date('Y');?><br>
                 </div>
            <table class="table table-responsive" style="font-size: 11px;">
                <thead>
                    <tr>
                         <th><b>FIANZAS</b></th>
                         <th>ENE</th>
                         <th>FEB</th>
                         <th>MAR</th>
                         <th>ABR</th>
                         <th>MAY</th>   
                         <th>JUN</th>
                         <th>JUL</th>
                         <th>AGO</th>
                         <th>SEP</th>
                         <th>OCT</th>
                         <th>NOV</th>
                         <th>DIC</th>
                    </tr>
                </thead>
                <tbody>
                     <tr style="background-color: #FAFAFA;text-align: right;">
                         <td><b>Ingres. Totales:</b></td>
                         <td><?php echo  number_format((($comisionActualFianzas1[0]->Fianzas)+($comisionActualFianzas1[1]->Fianzas)+($comisionActualFianzas1[2]->Fianzas)),2)?></td>

                           <td><?php echo  number_format((($comisionActualFianzas2[0]->Fianzas)+($comisionActualFianzas2[1]->Fianzas)+($comisionActualFianzas2[2]->Fianzas)),2)?></td>

                           <td><?php echo  number_format((($comisionActualFianzas3[0]->Fianzas)+($comisionActualFianzas3[1]->Fianzas)+($comisionActualFianzas3[2]->Fianzas)),2)?></td>

                           <td><?php echo  number_format((($comisionActualFianzas4[0]->Fianzas)+($comisionActualFianzas4[1]->Fianzas)+($comisionActualFianzas4[2]->Fianzas)),2)?></td>

                           <td><?php echo  number_format((($comisionActualFianzas5[0]->Fianzas)+($comisionActualFianzas5[1]->Fianzas)+($comisionActualFianzas5[2]->Fianzas)),2)?></td>

                           <td><?php echo  number_format((($comisionActualFianzas6[0]->Fianzas)+($comisionActualFianzas6[1]->Fianzas)+($comisionActualFianzas6[2]->Fianzas)),2)?></td>

                           <td><?php echo  number_format((($comisionActualFianzas7[0]->Fianzas)+($comisionActualFianzas7[1]->Fianzas)+($comisionActualFianzas7[2]->Fianzas)),2)?></td>

                           <td><?php echo  number_format((($comisionActualFianzas8[0]->Fianzas)+($comisionActualFianzas8[1]->Fianzas)+($comisionActualFianzas8[2]->Fianzas)),2)?></td>

                           <td><?php echo  number_format((($comisionActualFianzas9[0]->Fianzas)+($comisionActualFianzas9[1]->Fianzas)+($comisionActualFianzas9[2]->Fianzas)),2)?></td>

                           <td><?php echo  number_format((($comisionActualFianzas10[0]->Fianzas)+($comisionActualFianzas10[1]->Fianzas)+($comisionActualFianzas10[2]->Fianzas)),2)?></td>
                          
                           <td><?php echo  number_format((($comisionActualFianzas11[0]->Fianzas)+($comisionActualFianzas11[1]->Fianzas)+($comisionActualFianzas11[2]->Fianzas)),2)?></td>

                           <td><?php echo  number_format((($comisionActualFianzas12[0]->Fianzas)+($comisionActualFianzas12[1]->Fianzas)+($comisionActualFianzas12[2]->Fianzas)),2)?></td>
                     </tr>
                     <tr style="background-color: #F2F2F2;text-align: right;">
                         <td><b>Gastos Totales:</b></td>
                         <td><?php echo  number_format(
                            (($costoVenta1[0]->total)+($gastoOperaciones1[0]->total)+ ($nomina1[0]->total)),2);?></td>

                           <td><?php echo  number_format((($costoVenta2[0]->total)+($gastoOperaciones2[0]->total)+ ($nomina2[0]->total)),2);?></td>

                           <td><?php echo  number_format((($costoVenta3[0]->total)+($gastoOperaciones3[0]->total)+ ($nomina3[0]->total)),2);?></td>

                           <td><?php echo  number_format((($costoVenta4[0]->total)+($gastoOperaciones4[0]->total)+ ($nomina4[0]->total)),2);?></td>

                           <td><?php echo  number_format((($costoVenta5[0]->total)+($gastoOperaciones5[0]->total)+ ($nomina5[0]->total)),2);?></td>

                           <td><?php echo  number_format((($costoVenta6[0]->total)+($gastoOperaciones6[0]->total)+ ($nomina6[0]->total)),2);?></td>

                           <td><?php echo  number_format((($costoVenta7[0]->total)+($gastoOperaciones7[0]->total)+ ($nomina7[0]->total)),2);?></td>

                           <td><?php echo  number_format((($costoVenta8[0]->total)+($gastoOperaciones8[0]->total)+ ($nomina8[0]->total)),2);?></td>

                           <td><?php echo  number_format((($costoVenta9[0]->total)+($gastoOperaciones9[0]->total)+ ($nomina9[0]->total)),2);?></td>
                          
                           <td><?php echo  number_format((($costoVenta10[0]->total)+($gastoOperaciones10[0]->total)+ ($nomina10[0]->total)),2);?></td>

                           <td><?php echo  number_format((($costoVenta11[0]->total)+($gastoOperaciones11[0]->total)+ ($nomina11[0]->total)),2);?></td>

                           <td><?php echo  number_format((($costoVenta12[0]->total)+($gastoOperaciones12[0]->total)+ ($nomina12[0]->total)),2);?></td>
                     </tr>
                      <tr style="background-color: #08298A;color: #fff;text-align: right;">
                         <td><b>Utilidad/Perdida:</b></td>
                         <td><?php echo number_format( 
                            ((($comisionActualFianzas1[0]->Fianzas)+($comisionActualFianzas1[1]->Fianzas)+($comisionActualFianzas1[2]->Fianzas)) - (($costoVenta1[0]->total)+($gastoOperaciones1[0]->total)+ ($nomina1[0]->total))),2);?></td>

                           <td><?php echo number_format( 
                            ((($comisionActualFianzas2[0]->Fianzas)+($comisionActualFianzas2[1]->Fianzas)+($comisionActualFianzas2[2]->Fianzas)) - (($costoVenta2[0]->total)+($gastoOperaciones2[0]->total)+ ($nomina2[0]->total))),2);?></td>

                           <td><?php echo number_format( 
                            ((($comisionActualFianzas3[0]->Fianzas)+($comisionActualFianzas3[1]->Fianzas)+($comisionActualFianzas3[2]->Fianzas)) - (($costoVenta3[0]->total)+($gastoOperaciones3[0]->total)+ ($nomina3[0]->total))),2);?></td>

                           <td><?php echo number_format( 
                            ((($comisionActualFianzas4[0]->Fianzas)+($comisionActualFianzas4[1]->Fianzas)+($comisionActualFianzas4[2]->Fianzas)) - (($costoVenta4[0]->total)+($gastoOperaciones4[0]->total)+ ($nomina4[0]->total))),2);?></td>

                           <td><?php echo number_format( 
                            ((($comisionActualFianzas5[0]->Fianzas)+($comisionActualFianzas5[1]->Fianzas)+($comisionActualFianzas5[2]->Fianzas)) - (($costoVenta5[0]->total)+($gastoOperaciones5[0]->total)+ ($nomina5[0]->total))),2);?></td>

                           <td><?php echo number_format( 
                            ((($comisionActualFianzas6[0]->Fianzas)+($comisionActualFianzas6[1]->Fianzas)+($comisionActualFianzas6[2]->Fianzas)) - (($costoVenta6[0]->total)+($gastoOperaciones6[0]->total)+ ($nomina6[0]->total))),2);?></td>

                           <td><?php echo number_format( 
                            ((($comisionActualFianzas7[0]->Fianzas)+($comisionActualFianzas7[1]->Fianzas)+($comisionActualFianzas7[2]->Fianzas)) - (($costoVenta7[0]->total)+($gastoOperaciones7[0]->total)+ ($nomina7[0]->total))),2);?></td>

                            <td><?php echo number_format( 
                            ((($comisionActualFianzas8[0]->Fianzas)+($comisionActualFianzas8[1]->Fianzas)+($comisionActualFianzas8[2]->Fianzas)) - (($costoVenta8[0]->total)+($gastoOperaciones8[0]->total)+ ($nomina8[0]->total))),2);?></td>

                           <td><?php echo number_format( 
                            ((($comisionActualFianzas9[0]->Fianzas)+($comisionActualFianzas9[1]->Fianzas)+($comisionActualFianzas9[2]->Fianzas)) - (($costoVenta9[0]->total)+($gastoOperaciones9[0]->total)+ ($nomina9[0]->total))),2);?></td>
                          
                            <td><?php echo number_format( 
                            ((($comisionActualFianzas10[0]->Fianzas)+($comisionActualFianzas10[1]->Fianzas)+($comisionActualFianzas10[2]->Fianzas)) - (($costoVenta10[0]->total)+($gastoOperaciones10[0]->total)+ ($nomina10[0]->total))),2);?></td>

                           <td><?php echo number_format( 
                            ((($comisionActualFianzas11[0]->Fianzas)+($comisionActualFianzas11[1]->Fianzas)+($comisionActualFianzas11[2]->Fianzas)) - (($costoVenta11[0]->total)+($gastoOperaciones11[0]->total)+ ($nomina11[0]->total))),2);?></td>

                            <td><?php echo number_format( 
                            ((($comisionActualFianzas12[0]->Fianzas)+($comisionActualFianzas12[1]->Fianzas)+($comisionActualFianzas12[2]->Fianzas)) - (($costoVenta12[0]->total)+($gastoOperaciones12[0]->total)+ ($nomina12[0]->total))),2);?></td>
                     </tr>
                </tbody>
            </table>
        </div>
    </div>
</div>

</div>

<script type="text/javascript">
    //Fianzas Comision
var ctx = document.getElementById('myChartPresupuestoComisionFianzas').getContext('2d');
var chartf2 = new Chart(ctx, { //window.myBar
type: 'bar',
data: {
labels: [<?php echo mesesActual()?>],

    datasets: [
          {
            label: 'Instituciónal',
            stack: 'Stack 0',
            backgroundColor: [
            'rgba(115, 198, 182, 0.6)',
            'rgba(115, 198, 182, 0.6)',
            'rgba(115, 198, 182, 0.6)',
            'rgba(115, 198, 182, 0.6)',
            'rgba(115, 198, 182, 0.6)',
            'rgba(115, 198, 182, 0.6)',
            'rgba(115, 198, 182, 0.6)',
            'rgba(115, 198, 182, 0.6)',
            'rgba(115, 198, 182, 0.6)',
            'rgba(115, 198, 182, 0.6)',
            'rgba(115, 198, 182, 0.6)',
            'rgba(115, 198, 182, 0.6)'
            ],
            data: [
            <?php echo $comisionActualFianzas1[0]->Fianzas;?>,
            <?php echo $comisionActualFianzas2[0]->Fianzas;?>,
            <?php echo $comisionActualFianzas3[0]->Fianzas;?>,
            <?php echo $comisionActualFianzas4[0]->Fianzas;?>,
            <?php echo $comisionActualFianzas5[0]->Fianzas;?>,
            <?php echo $comisionActualFianzas6[0]->Fianzas;?>,
            <?php echo $comisionActualFianzas7[0]->Fianzas;?>,
            <?php echo $comisionActualFianzas8[0]->Fianzas;?>,
            <?php echo $comisionActualFianzas9[0]->Fianzas;?>,
            <?php echo $comisionActualFianzas10[0]->Fianzas;?>,
            <?php echo $comisionActualFianzas11[0]->Fianzas;?>,
            <?php echo $comisionActualFianzas12[0]->Fianzas;?>
            ]
        },
        {
            label: 'Corporativo',
            stack: 'Stack 1',
            backgroundColor: [
            'rgba(127, 179, 213, 0.6)',
            'rgba(127, 179, 213, 0.6)',
            'rgba(127, 179, 213, 0.6)',
            'rgba(127, 179, 213, 0.6)',
            'rgba(127, 179, 213, 0.6)',
            'rgba(127, 179, 213, 0.6)',
            'rgba(127, 179, 213, 0.6)',
            'rgba(127, 179, 213, 0.6)',
            'rgba(127, 179, 213, 0.6)',
            'rgba(127, 179, 213, 0.6)',
            'rgba(127, 179, 213, 0.6)',
            'rgba(127, 179, 213, 0.6)'
            ],
             data: [
            <?php echo $comisionActualFianzas1[1]->Fianzas;?>,
            <?php echo $comisionActualFianzas2[1]->Fianzas;?>,
            <?php echo $comisionActualFianzas3[1]->Fianzas;?>,
            <?php echo $comisionActualFianzas4[1]->Fianzas;?>,
            <?php echo $comisionActualFianzas5[1]->Fianzas;?>,
            <?php echo $comisionActualFianzas6[1]->Fianzas;?>,
            <?php echo $comisionActualFianzas7[1]->Fianzas;?>,
            <?php echo $comisionActualFianzas8[1]->Fianzas;?>,
            <?php echo $comisionActualFianzas9[1]->Fianzas;?>,
            <?php echo $comisionActualFianzas10[1]->Fianzas;?>,
            <?php echo $comisionActualFianzas11[1]->Fianzas;?>,
            <?php echo $comisionActualFianzas12[1]->Fianzas;?>
            ]
        },
        {
            label: 'Asesores',
            stack: 'Stack 2',
            backgroundColor: [
            'rgba(255, 206, 86, 0.6)',
            'rgba(255, 206, 86, 0.6)',
            'rgba(255, 206, 86, 0.6)',
            'rgba(255, 206, 86, 0.6)',
            'rgba(255, 206, 86, 0.6)',
            'rgba(255, 206, 86, 0.6)',
            'rgba(255, 206, 86, 0.6)',
            'rgba(255, 206, 86, 0.6)',
            'rgba(255, 206, 86, 0.6)',
            'rgba(255, 206, 86, 0.6)',
            'rgba(255, 206, 86, 0.6)',
            'rgba(255, 206, 86, 0.6)'
            ],
            data: [
            <?php echo $comisionActualFianzas1[2]->Fianzas;?>,
            <?php echo $comisionActualFianzas2[2]->Fianzas;?>,
            <?php echo $comisionActualFianzas3[2]->Fianzas;?>,
            <?php echo $comisionActualFianzas4[2]->Fianzas;?>,
            <?php echo $comisionActualFianzas5[2]->Fianzas;?>,
            <?php echo $comisionActualFianzas6[2]->Fianzas;?>,
            <?php echo $comisionActualFianzas7[2]->Fianzas;?>,
            <?php echo $comisionActualFianzas8[2]->Fianzas;?>,
            <?php echo $comisionActualFianzas9[2]->Fianzas;?>,
            <?php echo $comisionActualFianzas10[2]->Fianzas;?>,
            <?php echo $comisionActualFianzas11[2]->Fianzas;?>,
            <?php echo $comisionActualFianzas12[2]->Fianzas;?>
            ]
        }

    ]
},
options: {
    plugins: {
        tooltip: {
            mode: 'index'
        }
    },
    responsive: true,
}
});



var ctx = document.getElementById('myChartPresupuestoComisionPasadoFianzas').getContext('2d');
var chartf1 = new Chart(ctx, { //window.myBar
type: 'bar',
data: {
labels: [<?php echo mesesActual()?>],

    datasets: [
          {
            label: 'Instituciónal',
            stack: 'Stack 0',
            backgroundColor: [
            'rgba(115, 198, 182, 0.6)',
            'rgba(115, 198, 182, 0.6)',
            'rgba(115, 198, 182, 0.6)',
            'rgba(115, 198, 182, 0.6)',
            'rgba(115, 198, 182, 0.6)',
            'rgba(115, 198, 182, 0.6)',
            'rgba(115, 198, 182, 0.6)',
            'rgba(115, 198, 182, 0.6)',
            'rgba(115, 198, 182, 0.6)',
            'rgba(115, 198, 182, 0.6)',
            'rgba(115, 198, 182, 0.6)',
            'rgba(115, 198, 182, 0.6)'
            ],
            data: [

            <?php echo $comisionPasadoFianzas1[0]->Fianzas;?>,
            <?php echo $comisionPasadoFianzas2[0]->Fianzas;?>,
            <?php echo $comisionPasadoFianzas3[0]->Fianzas;?>,
            <?php echo $comisionPasadoFianzas4[0]->Fianzas;?>,
            <?php echo $comisionPasadoFianzas5[0]->Fianzas;?>,
            <?php echo $comisionPasadoFianzas6[0]->Fianzas;?>,
            <?php echo $comisionPasadoFianzas7[0]->Fianzas;?>,
            <?php echo $comisionPasadoFianzas8[0]->Fianzas;?>,
            <?php echo $comisionPasadoFianzas9[0]->Fianzas;?>,
            <?php echo $comisionPasadoFianzas10[0]->Fianzas;?>,
            <?php echo $comisionPasadoFianzas11[0]->Fianzas;?>,
            <?php echo $comisionPasadoFianzas12[0]->Fianzas;?>
            ]
        },
        {
            label: 'Corporativo',
            stack: 'Stack 1',
            backgroundColor: [
            'rgba(127, 179, 213, 0.6)',
            'rgba(127, 179, 213, 0.6)',
            'rgba(127, 179, 213, 0.6)',
            'rgba(127, 179, 213, 0.6)',
            'rgba(127, 179, 213, 0.6)',
            'rgba(127, 179, 213, 0.6)',
            'rgba(127, 179, 213, 0.6)',
            'rgba(127, 179, 213, 0.6)',
            'rgba(127, 179, 213, 0.6)',
            'rgba(127, 179, 213, 0.6)',
            'rgba(127, 179, 213, 0.6)',
            'rgba(127, 179, 213, 0.6)'
            ],
             data: [
            <?php echo $comisionPasadoFianzas1[1]->Fianzas;?>,
            <?php echo $comisionPasadoFianzas2[1]->Fianzas;?>,
            <?php echo $comisionPasadoFianzas3[1]->Fianzas;?>,
            <?php echo $comisionPasadoFianzas4[1]->Fianzas;?>,
            <?php echo $comisionPasadoFianzas5[1]->Fianzas;?>,
            <?php echo $comisionPasadoFianzas6[1]->Fianzas;?>,
            <?php echo $comisionPasadoFianzas7[1]->Fianzas;?>,
            <?php echo $comisionPasadoFianzas8[1]->Fianzas;?>,
            <?php echo $comisionPasadoFianzas9[1]->Fianzas;?>,
            <?php echo $comisionPasadoFianzas10[1]->Fianzas;?>,
            <?php echo $comisionPasadoFianzas11[1]->Fianzas;?>,
            <?php echo $comisionPasadoFianzas12[1]->Fianzas;?>
            ]
        },
        {
            label: 'Asesores',
            stack: 'Stack 2',
            backgroundColor: [
            'rgba(255, 206, 86, 0.6)',
            'rgba(255, 206, 86, 0.6)',
            'rgba(255, 206, 86, 0.6)',
            'rgba(255, 206, 86, 0.6)',
            'rgba(255, 206, 86, 0.6)',
            'rgba(255, 206, 86, 0.6)',
            'rgba(255, 206, 86, 0.6)',
            'rgba(255, 206, 86, 0.6)',
            'rgba(255, 206, 86, 0.6)',
            'rgba(255, 206, 86, 0.6)',
            'rgba(255, 206, 86, 0.6)',
            'rgba(255, 206, 86, 0.6)'
            ],
            data: [
            <?php echo $comisionPasadoFianzas1[2]->Fianzas;?>,
            <?php echo $comisionPasadoFianzas2[2]->Fianzas;?>,
            <?php echo $comisionPasadoFianzas3[2]->Fianzas;?>,
            <?php echo $comisionPasadoFianzas4[2]->Fianzas;?>,
            <?php echo $comisionPasadoFianzas5[2]->Fianzas;?>,
            <?php echo $comisionPasadoFianzas6[2]->Fianzas;?>,
            <?php echo $comisionPasadoFianzas7[2]->Fianzas;?>,
            <?php echo $comisionPasadoFianzas8[2]->Fianzas;?>,
            <?php echo $comisionPasadoFianzas9[2]->Fianzas;?>,
            <?php echo $comisionPasadoFianzas10[2]->Fianzas;?>,
            <?php echo $comisionPasadoFianzas11[2]->Fianzas;?>,
            <?php echo $comisionPasadoFianzas12[2]->Fianzas;?>
            ]
        }
    ]
},
options: {
    plugins: {
        tooltip: {
            mode: 'index'
        }
    },
    responsive: true,
}
});

//************** Fianzas Gastos
var ctx = document.getElementById('myChartPresupuestoGastosPasadoFianzas').getContext('2d');
var chartf3 = new Chart(ctx, { //window.myBar
type: 'bar',
data: {
labels: [<?php echo mesesActual()?>],

    datasets: [
          {
            label: 'Costo Venta',
            stack: 'Stack 0',
            backgroundColor: [
            'rgba(54, 162, 235, 0.6)',
            'rgba(54, 162, 235, 0.6)',
            'rgba(54, 162, 235, 0.6)',
            'rgba(54, 162, 235, 0.6)',
            'rgba(54, 162, 235, 0.6)',
            'rgba(54, 162, 235, 0.6)',
            'rgba(54, 162, 235, 0.6)',
            'rgba(54, 162, 235, 0.6)',
            'rgba(54, 162, 235, 0.6)',
            'rgba(54, 162, 235, 0.6)',
            'rgba(54, 162, 235, 0.6)',
            'rgba(54, 162, 235, 0.6)'
            ],
            data: [
            <?php echo $costoVentaPasadoFianzas1[0]->total;?>,
            <?php echo $costoVentaPasadoFianzas2[0]->total;?>,
            <?php echo $costoVentaPasadoFianzas3[0]->total;?>,
            <?php echo $costoVentaPasadoFianzas4[0]->total;?>,
            <?php echo $costoVentaPasadoFianzas5[0]->total;?>,
            <?php echo $costoVentaPasadoFianzas6[0]->total;?>,
            <?php echo $costoVentaPasadoFianzas7[0]->total;?>,
            <?php echo $costoVentaPasadoFianzas8[0]->total;?>,
            <?php echo $costoVentaPasadoFianzas9[0]->total;?>,
            <?php echo $costoVentaPasadoFianzas10[0]->total;?>,
            <?php echo $costoVentaPasadoFianzas11[0]->total;?>,
            <?php echo $costoVentaPasadoFianzas12[0]->total;?>
            ]
        },
        {
            label: 'Gastos Operaciones',
            stack: 'Stack 1',
            backgroundColor: [
            'rgba(153, 102, 255, 1)',
            'rgba(153, 102, 255, 1)',
            'rgba(153, 102, 255, 1)',
            'rgba(153, 102, 255, 1)',
            'rgba(153, 102, 255, 1)',
            'rgba(153, 102, 255, 1)',
            'rgba(153, 102, 255, 1)',
            'rgba(153, 102, 255, 1)',
            'rgba(153, 102, 255, 1)',
            'rgba(153, 102, 255, 1)',
            'rgba(153, 102, 255, 1)',
            'rgba(153, 102, 255, 1)'
            ],
             data: [
            <?php echo $gastoOperacionesPasadoFianzas1[0]->total;?>,
            <?php echo $gastoOperacionesPasadoFianzas2[0]->total;?>,
            <?php echo $gastoOperacionesPasadoFianzas3[0]->total;?>,
            <?php echo $gastoOperacionesPasadoFianzas4[0]->total;?>,
            <?php echo $gastoOperacionesPasadoFianzas5[0]->total;?>,
            <?php echo $gastoOperacionesPasadoFianzas6[0]->total;?>,
            <?php echo $gastoOperacionesPasadoFianzas7[0]->total;?>,
            <?php echo $gastoOperacionesPasadoFianzas8[0]->total;?>,
            <?php echo $gastoOperacionesPasadoFianzas9[0]->total;?>,
            <?php echo $gastoOperacionesPasadoFianzas10[0]->total;?>,
            <?php echo $gastoOperacionesPasadoFianzas11[0]->total;?>,
            <?php echo $gastoOperacionesPasadoFianzas12[0]->total;?>
            ]
        },
        {
            label: 'Nomina',
            stack: 'Stack 2',
            backgroundColor: [
            'rgba(210, 180, 222  , 1)',
            'rgba(210, 180, 222  , 1)',
            'rgba(210, 180, 222  , 1)',
            'rgba(210, 180, 222  , 1)',
            'rgba(210, 180, 222  , 1)',
            'rgba(210, 180, 222  , 1)',
            'rgba(210, 180, 222  , 1)',
            'rgba(210, 180, 222  , 1)',
            'rgba(210, 180, 222  , 1)',
            'rgba(210, 180, 222  , 1)',
            'rgba(210, 180, 222  , 1)',
            'rgba(210, 180, 222  , 1)'
            ],
            data: [
            <?php echo $nominaPasadoFianzas1[0]->total;?>,
            <?php echo $nominaPasadoFianzas2[0]->total;?>,
            <?php echo $nominaPasadoFianzas3[0]->total;?>,
            <?php echo $nominaPasadoFianzas4[0]->total;?>,
            <?php echo $nominaPasadoFianzas5[0]->total;?>,
            <?php echo $nominaPasadoFianzas6[0]->total;?>,
            <?php echo $nominaPasadoFianzas7[0]->total;?>,
            <?php echo $nominaPasadoFianzas8[0]->total;?>,
            <?php echo $nominaPasadoFianzas9[0]->total;?>,
            <?php echo $nominaPasadoFianzas10[0]->total;?>,
            <?php echo $nominaPasadoFianzas11[0]->total;?>,
            <?php echo $nominaPasadoFianzas12[0]->total;?>
            ]
        }
    ]
},
options: {
    plugins: {
        tooltip: {
            mode: 'index'
        }
    },
    responsive: true,
}
});


var ctx = document.getElementById('myChartPresupuestoGastosFianzas').getContext('2d');
var chartf4 = new Chart(ctx, { //window.myBar
type: 'bar',
data: {
labels: [<?php echo mesesActual()?>],

    datasets: [
          {
            label: 'Costo Venta',
            stack: 'Stack 0',
            backgroundColor: [
            'rgba(54, 162, 235, 0.6)',
            'rgba(54, 162, 235, 0.6)',
            'rgba(54, 162, 235, 0.6)',
            'rgba(54, 162, 235, 0.6)',
            'rgba(54, 162, 235, 0.6)',
            'rgba(54, 162, 235, 0.6)',
            'rgba(54, 162, 235, 0.6)',
            'rgba(54, 162, 235, 0.6)',
            'rgba(54, 162, 235, 0.6)',
            'rgba(54, 162, 235, 0.6)',
            'rgba(54, 162, 235, 0.6)',
            'rgba(54, 162, 235, 0.6)'
            ],
            data: [
            <?php echo $costoVentaFianzas1[0]->total;?>,
            <?php echo $costoVentaFianzas2[0]->total;?>,
            <?php echo $costoVentaFianzas3[0]->total;?>,
            <?php echo $costoVentaFianzas4[0]->total;?>,
            <?php echo $costoVentaFianzas5[0]->total;?>,
            <?php echo $costoVentaFianzas6[0]->total;?>,
            <?php echo $costoVentaFianzas7[0]->total;?>,
            <?php echo $costoVentaFianzas8[0]->total;?>,
            <?php echo $costoVentaFianzas9[0]->total;?>,
            <?php echo $costoVentaFianzas10[0]->total;?>,
            <?php echo $costoVentaFianzas11[0]->total;?>,
            <?php echo $costoVentaFianzas12[0]->total;?>
            ]
        },
        {
            label: 'Gastos Operaciones',
            stack: 'Stack 1',
            backgroundColor: [
            'rgba(153, 102, 255, 1)',
            'rgba(153, 102, 255, 1)',
            'rgba(153, 102, 255, 1)',
            'rgba(153, 102, 255, 1)',
            'rgba(153, 102, 255, 1)',
            'rgba(153, 102, 255, 1)',
            'rgba(153, 102, 255, 1)',
            'rgba(153, 102, 255, 1)',
            'rgba(153, 102, 255, 1)',
            'rgba(153, 102, 255, 1)',
            'rgba(153, 102, 255, 1)',
            'rgba(153, 102, 255, 1)'
            ],
             data: [
            <?php echo $gastoOperacionesFianzas1[0]->total;?>,
            <?php echo $gastoOperacionesFianzas2[0]->total;?>,
            <?php echo $gastoOperacionesFianzas3[0]->total;?>,
            <?php echo $gastoOperacionesFianzas4[0]->total;?>,
            <?php echo $gastoOperacionesFianzas5[0]->total;?>,
            <?php echo $gastoOperacionesFianzas6[0]->total;?>,
            <?php echo $gastoOperacionesFianzas7[0]->total;?>,
            <?php echo $gastoOperacionesFianzas8[0]->total;?>,
            <?php echo $gastoOperacionesFianzas9[0]->total;?>,
            <?php echo $gastoOperacionesFianzas10[0]->total;?>,
            <?php echo $gastoOperacionesFianzas11[0]->total;?>,
            <?php echo $gastoOperacionesFianzas12[0]->total;?>
            ]
        },
        {
            label: 'Nomina',
            stack: 'Stack 2',
            backgroundColor: [
            'rgba(210, 180, 222  , 1)',
            'rgba(210, 180, 222  , 1)',
            'rgba(210, 180, 222  , 1)',
            'rgba(210, 180, 222  , 1)',
            'rgba(210, 180, 222  , 1)',
            'rgba(210, 180, 222  , 1)',
            'rgba(210, 180, 222  , 1)',
            'rgba(210, 180, 222  , 1)',
            'rgba(210, 180, 222  , 1)',
            'rgba(210, 180, 222  , 1)',
            'rgba(210, 180, 222  , 1)',
            'rgba(210, 180, 222  , 1)'
            ],
            data: [
            <?php echo $nominaFianzas1[0]->total;?>,
            <?php echo $nominaFianzas2[0]->total;?>,
            <?php echo $nominaFianzas3[0]->total;?>,
            <?php echo $nominaFianzas4[0]->total;?>,
            <?php echo $nominaFianzas5[0]->total;?>,
            <?php echo $nominaFianzas6[0]->total;?>,
            <?php echo $nominaFianzas7[0]->total;?>,
            <?php echo $nominaFianzas8[0]->total;?>,
            <?php echo $nominaFianzas9[0]->total;?>,
            <?php echo $nominaFianzas10[0]->total;?>,
            <?php echo $nominaFianzas11[0]->total;?>,
            <?php echo $nominaFianzas12[0]->total;?>
            ]
        }
    ]
},
options: {
    plugins: {
        tooltip: {
            mode: 'index'
        }
    },
    responsive: true,
}
});
</script>
