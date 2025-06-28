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
         <i class="fa fa-money"></i><b>&nbsp;SEGUROS</b>
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
                <!--<div class="row">
                        <div class="col-md-8 mt-2"></div>
                        <div class="col-md-4 text-right">
                            <div class="dropdown">
                                <button class="btn btn-link dropdown-toggle btn-sm text-white" type="button" id="dropdownMenu1" data-toggle="dropdown" aria-expanded="true">
                                    Filtrar
                                </button>
                                <ul class="dropdown-menu" role="menu" aria-labelledby="dropdownMenu1">
                                    <li role="presentation"><a role="menuitem" tabindex="-1" href="javascript: void(0)">Trimestral</a></li>
                                    <li role="presentation"><a role="menuitem" tabindex="-1" href="javascript: void(0)">Mensual</a></li>
                                    <li role="presentation" class="dropdown-header">Anual</li>
                                    <li role="presentation"><a role="menuitem" tabindex="-1" href="javascript: void(0)"> <input type="radio" name="year-filter-comission" value="2021" checked> 2021</a></li>
                                    <li role="presentation"><a role="menuitem" tabindex="-1" href="javascript: void(0)"> <input type="radio" name="year-filter-comission" value="2020"> 2020</a></li>
                                    <li role="presentation"><a role="menuitem" tabindex="-1" href="javascript: void(0)"> <input type="radio" name="year-filter-comission" value="2019"> 2019</a></li>
                                </ul>
                            </div>
                        </div>
                    </div>-->
                 </div>
             </div>
             <div id="grafico" style="width: 100%;height:auto;">
                <div class="filter-past">
                    <a class="btn btn-primary btn-sm" data-toggle="collapse" href="#filter-past1" aria-expanded="false" aria-controls="filter-past1">
                        Filtros
                    </a>
                    <div class="collapse" id="filter-past1">
                        <div class="panel panel-body mt-2">
                            <div class="col-md-12 mb-2">
                                <div class="row">
                                    <div class="col-md-1">Años</div>
                                    <div class="col-md-4">
                                        <select id="past-years-comission" class="form-control form-control-sm">
                                            <option value="">Seleccione</option>
                                            <option value="2021">2021</option>
                                            <option value="2020">2020</option>
                                            <option value="2019">2019</option>
                                        </select>
                                    </div>
                                <div class="col-md-1">Meses</div>
                                <div class="col-md-4">
                                    <select id="past-months-comission" class="form-control form-control-sm">
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
                                        <select id="past-montly-type-comission" class="form-control form-control-sm">
                                            <option value="">Seleccione</option>
                                            <option value="trimestral">Trimestral</option>
                                            <option value="mensual">Mensual</option>
                                            <option value="total">Completo</option>
                                        </select>
                                    </div>
                                    <div class="col-md-2 text-center">
                                        <button class="btn btn-primary btn-sm filter-past-data" data-filter="budget">Filtrar</button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <canvas id="myChartPresupuestoComisionPasado"></canvas>
             </div>
             <div id="cuadro">
                 <table class="table table-responsive" style="font-size: 11px;"> 
                     <thead>
                     <tr>
                         <th><b>SEGUROS</b></th>
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
                     <tbody class="body-table-past-comission">
                     <tr>
                         <td>Bono <?php echo date('Y')-1;?></td>
                         <td><?php if(isset($bonoPasado->total)){echo $bonoPasado;}else{ echo '0,00';}?></td>
                         <td></td>
                         <td></td>
                         <td></td>
                         <td></td>
                         <td></td>
                         <td></td>
                         <td></td>
                         <td></td>
                         <td></td>
                         <td></td>
                     </tr>
                     <tr>
                         <td><b>Ingresos Totales:</b></td>
                         <td><?php echo  number_format((($comisionPasado1[0]->comision)+($comisionPasado1[1]->comision)+($comisionPasado1[2]->comision)+($comisionPasado1[3]->comision)),2)?></td>

                           <td><?php echo  number_format((($comisionPasado2[0]->comision)+($comisionPasado2[1]->comision)+($comisionPasado2[2]->comision)+($comisionPasado2[3]->comision)),2)?></td>

                           <td><?php echo  number_format((($comisionPasado3[0]->comision)+($comisionPasado3[1]->comision)+($comisionPasado3[2]->comision)+($comisionPasado3[3]->comision)),2)?></td>

                           <td><?php echo  number_format((($comisionPasado4[0]->comision)+($comisionPasado4[1]->comision)+($comisionPasado4[2]->comision)+($comisionPasado4[3]->comision)),2)?></td>

                           <td><?php echo  number_format((($comisionPasado5[0]->comision)+($comisionPasado5[1]->comision)+($comisionPasado5[2]->comision)+($comisionPasado5[3]->comision)),2)?></td>

                           <td><?php echo  number_format((($comisionPasado6[0]->comision)+($comisionPasado6[1]->comision)+($comisionPasado6[2]->comision)+($comisionPasado6[3]->comision)),2)?></td>

                           <td><?php echo  number_format((($comisionPasado7[0]->comision)+($comisionPasado7[1]->comision)+($comisionPasado7[2]->comision)+($comisionPasado7[3]->comision)),2)?></td>

                           <td><?php echo  number_format((($comisionPasado8[0]->comision)+($comisionPasado8[1]->comision)+($comisionPasado8[2]->comision)+($comisionPasado8[3]->comision)),2)?></td>

                           <td><?php echo  number_format((($comisionPasado9[0]->comision)+($comisionPasado9[1]->comision)+($comisionPasado9[2]->comision)+($comisionPasado9[3]->comision)),2)?></td>

                           <td><?php echo  number_format((($comisionPasado10[0]->comision)+($comisionPasado10[1]->comision)+($comisionPasado10[2]->comision)+($comisionPasado10[3]->comision)),2)?></td>
                          
                           <td><?php echo  number_format((($comisionPasado11[0]->comision)+($comisionPasado11[1]->comision)+($comisionPasado11[2]->comision)+($comisionPasado11[3]->comision)),2)?></td>

                           <td><?php echo  number_format((($comisionPasado12[0]->comision)+($comisionPasado12[1]->comision)+($comisionPasado12[2]->comision)+($comisionPasado12[3]->comision)),2)?></td>
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
                <div class="panel-heading" style="font-size: 12px"></i> REPORTE AÑO ACTUAL <?php echo date('Y');?><br></div>
             </div>
             <div id="grafico" style="width: 100%;height:auto;padding: 1%;">
                <div class="filter-present">
                    <a class="btn btn-primary btn-sm" data-toggle="collapse" href="#filter-present1" aria-expanded="false" aria-controls="filter-present1">
                        Filtros
                    </a>
                    <div class="collapse" id="filter-present1">
                        <div class="panel panel-body mt-2">
                            <div class="col-md-12 mb-2">
                                <div class="row">
                                    <div class="col-md-1">Meses</div>
                                    <div class="col-md-4">
                                        <select id="present-months-comission" class="form-control form-control-sm">
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
                                        <select id="present-montly-type-comission" class="form-control form-control-sm">
                                            <option value="">Seleccione</option>
                                            <option value="trimestral">Trimestral</option>
                                            <option value="mensual">Mensual</option>
                                            <option value="total">Completo</option>
                                        </select>
                                    </div>
                                    <div class="col-md-2 text-center">
                                        <button class="btn btn-primary btn-sm filter-present-data" data-filter="budget">Filtrar</button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <canvas id="myChartPresupuestoComision"></canvas>
             </div> 
             <div id="cuadro">
                 <table class="table table-responsive" style="font-size: 11px;"> 
                     <thead>
                     <tr>
                         <th><b>SEGUROS</b></th>
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
                     <tbody class="body-table-present-comission">
                     <tr>
                         <td>Bono <?php echo date('Y');?></td>
                         <td><?php if(isset($bonoActual->total)){echo $bonoActual;}else{ echo '0,00';}?></td>
                         <td></td>
                         <td></td>
                         <td></td>
                         <td></td>
                         <td></td>
                         <td></td>
                         <td></td>
                         <td></td>
                         <td></td>
                         <td></td>
                     </tr>
                     <tr>
                         <td><b>Ingresos Totales:</b></td>
                         <td><?php echo  number_format((($comisionActual1[0]->comision)+($comisionActual1[1]->comision)+($comisionActual1[2]->comision)+($comisionActual1[3]->comision)),2)?></td>

                           <td><?php echo  number_format((($comisionActual2[0]->comision)+($comisionActual2[1]->comision)+($comisionActual2[2]->comision)+($comisionActual2[3]->comision)),2)?></td>

                           <td><?php echo  number_format((($comisionActual3[0]->comision)+($comisionActual3[1]->comision)+($comisionActual3[2]->comision)+($comisionActual3[3]->comision)),2)?></td>

                           <td><?php echo  number_format((($comisionActual4[0]->comision)+($comisionActual4[1]->comision)+($comisionActual4[2]->comision)+($comisionActual4[3]->comision)),2)?></td>

                           <td><?php echo  number_format((($comisionActual5[0]->comision)+($comisionActual5[1]->comision)+($comisionActual5[2]->comision)+($comisionActual5[3]->comision)),2)?></td>

                           <td><?php echo  number_format((($comisionActual6[0]->comision)+($comisionActual6[1]->comision)+($comisionActual6[2]->comision)+($comisionActual6[3]->comision)),2)?></td>

                           <td><?php echo  number_format((($comisionActual7[0]->comision)+($comisionActual7[1]->comision)+($comisionActual7[2]->comision)+($comisionActual7[3]->comision)),2)?></td>

                           <td><?php echo  number_format((($comisionActual8[0]->comision)+($comisionActual8[1]->comision)+($comisionActual8[2]->comision)+($comisionActual8[3]->comision)),2)?></td>

                           <td><?php echo  number_format((($comisionActual9[0]->comision)+($comisionActual9[1]->comision)+($comisionActual9[2]->comision)+($comisionActual9[3]->comision)),2)?></td>

                           <td><?php echo  number_format((($comisionActual10[0]->comision)+($comisionActual10[1]->comision)+($comisionActual10[2]->comision)+($comisionActual10[3]->comision)),2)?></td>
                          
                           <td><?php echo  number_format((($comisionActual11[0]->comision)+($comisionActual11[1]->comision)+($comisionActual11[2]->comision)+($comisionActual11[3]->comision)),2)?></td>

                           <td><?php echo  number_format((($comisionActual12[0]->comision)+($comisionActual12[1]->comision)+($comisionActual12[2]->comision)+($comisionActual12[3]->comision)),2)?></td>
                     </tr>
                     </tbody>
                 </table>
             </div>
        </div> 
    </div>
    <!-- -->
</div>


<div class="row">
    <div class="col-md-12 col-lg-12">
        <div style="margin: 1%;">
        <h4>COSTO VENTA, GASTOS OPERACIONES, NOMINA</h4>
         <i class="fa fa-money"></i><b>&nbsp;SEGUROS</b>
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
             <div class="filter-past">
                    <a class="btn btn-primary btn-sm" data-toggle="collapse" href="#filter-past2" aria-expanded="false" aria-controls="fiter-past2">
                        Filtros
                    </a>
                    <div class="collapse" id="filter-past2">
                        <div class="panel panel-body mt-2">
                            <div class="col-md-12 mb-2">
                                <div class="row">
                                    <div class="col-md-1">Años</div>
                                    <div class="col-md-4">
                                        <select id="past-years-others" class="form-control form-control-sm">
                                            <option value="">Seleccione</option>
                                            <option value="2021">2021</option>
                                            <option value="2020">2020</option>
                                            <option value="2019">2019</option>
                                        </select>
                                    </div>
                                <div class="col-md-1">Meses</div>
                                <div class="col-md-4">
                                    <select id="past-months-others" class="form-control form-control-sm">
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
                                        <select id="past-montly-type-others" class="form-control form-control-sm">
                                            <option value="">Seleccione</option>
                                            <option value="trimestral">Trimestral</option>
                                            <option value="mensual">Mensual</option>
                                            <option value="total">Completo</option>
                                        </select>
                                    </div>
                                    <div class="col-md-2 text-center">
                                        <button class="btn btn-primary btn-sm filter-past-data" data-filter="other">Filtrar</button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <canvas id="myChartPresupuestoGastosPasado"></canvas>
             </div> 
             <div id="cuadro">
                 <table class="table table-responsive" style="font-size: 11px;"> 
                     <thead>
                     <tr>
                         <th><b>SEGUROS</b></th>
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
                     <tbody class="body-table-past-others">

                    
                     <tr>
                         <td><?php echo  number_format((($costoVentaPasado1[0]->total)+($gastoOperacionesPasado1[0]->total)+ ($nominaPasado1[0]->total)),2);?></td>

                           <td><?php echo  number_format((($costoVentaPasado2[0]->total)+($gastoOperacionesPasado2[0]->total)+ ($nominaPasado2[0]->total)),2);?></td>

                           <td><?php echo  number_format((($costoVentaPasado3[0]->total)+($gastoOperacionesPasado3[0]->total)+ ($nominaPasado3[0]->total)),2);?></td>

                           <td><?php echo  number_format((($costoVentaPasado4[0]->total)+($gastoOperacionesPasado4[0]->total)+ ($nominaPasado4[0]->total)),2);?></td>

                           <td><?php echo  number_format((($costoVentaPasado5[0]->total)+($gastoOperacionesPasado5[0]->total)+ ($nominaPasado5[0]->total)),2);?></td>

                           <td><?php echo  number_format((($costoVentaPasado6[0]->total)+($gastoOperacionesPasado6[0]->total)+ ($nominaPasado6[0]->total)),2);?></td>

                           <td><?php echo  number_format((($costoVentaPasado7[0]->total)+($gastoOperacionesPasado7[0]->total)+($nominaPasado7[0]->total)),2);?></td>

                           <td><?php echo  number_format((($costoVentaPasado8[0]->total)+($gastoOperacionesPasado8[0]->total)+ ($nominaPasado8[0]->total)),2);?></td>

                           <td><?php echo  number_format((($costoVentaPasado9[0]->total)+($gastoOperacionesPasado9[0]->total)+ ($nominaPasado9[0]->total)),2);?></td>
                          
                           <td><?php echo  number_format((($costoVentaPasado10[0]->total)+($gastoOperacionesPasado10[0]->total)+ ($nominaPasado10[0]->total)),2);?></td>

                           <td><?php echo  number_format((($costoVentaPasado11[0]->total)+($gastoOperacionesPasado11[0]->total)+ ($nominaPasado11[0]->total)),2);?></td>

                           <td><?php echo  number_format((($costoVentaPasado12[0]->total)+($gastoOperacionesPasado12[0]->total)+ ($nominaPasado12[0]->total)),2);?></td>
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
                    <a class="btn btn-primary btn-sm" data-toggle="collapse" href="#filter-present2" aria-expanded="false" aria-controls="filter-present2">
                        Filtros
                    </a>
                    <div class="collapse" id="filter-present2">
                        <div class="panel panel-body mt-2">
                            <div class="col-md-12 mb-2">
                                <div class="row">
                                    <div class="col-md-1">Meses</div>
                                    <div class="col-md-4">
                                        <select id="present-months-others" class="form-control form-control-sm">
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
                                        <select id="present-montly-type-others" class="form-control form-control-sm">
                                            <option value="">Seleccione</option>
                                            <option value="trimestral">Trimestral</option>
                                            <option value="mensual">Mensual</option>
                                            <option value="total">Completo</option>
                                        </select>
                                    </div>
                                    <div class="col-md-2 text-center">
                                        <button class="btn btn-primary btn-sm filter-present-data" data-filter="other">Filtrar</button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <canvas id="myChartPresupuestoGastos"></canvas>
             </div> 
             <div id="cuadro">
                 <table class="table table-responsive" style="font-size: 11px;"> 
                     <thead>
                     <tr>
                         <th><b>SEGUROS</b></th>
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
                     <tbody class="body-table-present-others">

                    
                     <tr>
                         <td>Gastos Totales:</td>
                         <td><?php echo  number_format((($costoVenta1[0]->total)+($gastoOperaciones1[0]->total)+ ($nomina1[0]->total)),2);?></td>

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
                     </tbody>
                 </table>
             </div> 

        </div> 
    </div>

</div>

<!--RESUMEN SEGUROS-->
 <div class="row">
    <!-- Reporte anio pasado-->
    <div class="col-sm-6 col-md-6">
        <div class="well" style="background-color: #fff;">
             <div class="panel panel-default">
                <div class="panel-heading" style="font-size: 12px">
                    <i class="fa fa-calendar-check-o"></i> RESUMEN SEGUROS AÑO PASADO <?php echo date('Y')-1;?><br>
                 </div>
                <table class="table table-responsive" style="font-size: 11px;">
                <thead>
                    <tr>
                         <th><b>SEGUROS</b></th>
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
                         <td><?php echo  number_format((($comisionPasado1[0]->comision)+($comisionPasado1[1]->comision)+($comisionPasado1[2]->comision)+($comisionPasado1[3]->comision)),2)?></td>

                           <td><?php echo  number_format((($comisionPasado2[0]->comision)+($comisionPasado2[1]->comision)+($comisionPasado2[2]->comision)+($comisionPasado2[3]->comision)),2)?></td>

                           <td><?php echo  number_format((($comisionPasado3[0]->comision)+($comisionPasado3[1]->comision)+($comisionPasado3[2]->comision)+($comisionPasado3[3]->comision)),2)?></td>

                           <td><?php echo  number_format((($comisionPasado4[0]->comision)+($comisionPasado4[1]->comision)+($comisionPasado4[2]->comision)+($comisionPasado4[3]->comision)),2)?></td>

                           <td><?php echo  number_format((($comisionPasado5[0]->comision)+($comisionPasado5[1]->comision)+($comisionPasado5[2]->comision)+($comisionPasado5[3]->comision)),2)?></td>

                           <td><?php echo  number_format((($comisionPasado6[0]->comision)+($comisionPasado6[1]->comision)+($comisionPasado6[2]->comision)+($comisionPasado6[3]->comision)),2)?></td>

                           <td><?php echo  number_format((($comisionPasado7[0]->comision)+($comisionPasado7[1]->comision)+($comisionPasado7[2]->comision)+($comisionPasado7[3]->comision)),2)?></td>

                           <td><?php echo  number_format((($comisionPasado8[0]->comision)+($comisionPasado8[1]->comision)+($comisionPasado8[2]->comision)+($comisionPasado8[3]->comision)),2)?></td>

                           <td><?php echo  number_format((($comisionPasado9[0]->comision)+($comisionPasado9[1]->comision)+($comisionPasado9[2]->comision)+($comisionPasado9[3]->comision)),2)?></td>

                           <td><?php echo  number_format((($comisionPasado10[0]->comision)+($comisionPasado10[1]->comision)+($comisionPasado10[2]->comision)+($comisionPasado10[3]->comision)),2)?></td>
                          
                           <td><?php echo  number_format((($comisionPasado11[0]->comision)+($comisionPasado11[1]->comision)+($comisionPasado11[2]->comision)+($comisionPasado11[3]->comision)),2)?></td>

                           <td><?php echo  number_format((($comisionPasado12[0]->comision)+($comisionPasado12[1]->comision)+($comisionPasado12[2]->comision)+($comisionPasado12[3]->comision)),2)?></td>
                     </tr>
                     <tr style="background-color: #F2F2F2;text-align: right;">
                         <td><b>Gastos Totales:</b></td>
                         <td><?php echo  number_format((($costoVentaPasado1[0]->total)+($gastoOperacionesPasado1[0]->total)+ ($nominaPasado1[0]->total)),2);?></td>

                           <td><?php echo  number_format((($costoVentaPasado2[0]->total)+($gastoOperacionesPasado2[0]->total)+ ($nominaPasado2[0]->total)),2);?></td>

                           <td><?php echo  number_format((($costoVentaPasado3[0]->total)+($gastoOperacionesPasado3[0]->total)+ ($nominaPasado3[0]->total)),2);?></td>

                           <td><?php echo  number_format((($costoVentaPasado4[0]->total)+($gastoOperacionesPasado4[0]->total)+ ($nominaPasado4[0]->total)),2);?></td>

                           <td><?php echo  number_format((($costoVentaPasado5[0]->total)+($gastoOperacionesPasado5[0]->total)+ ($nominaPasado5[0]->total)),2);?></td>

                           <td><?php echo  number_format((($costoVentaPasado6[0]->total)+($gastoOperacionesPasado6[0]->total)+ ($nominaPasado6[0]->total)),2);?></td>

                           <td><?php echo  number_format((($costoVentaPasado7[0]->total)+($gastoOperacionesPasado7[0]->total)+($nominaPasado7[0]->total)),2);?></td>

                           <td><?php echo  number_format((($costoVentaPasado8[0]->total)+($gastoOperacionesPasado8[0]->total)+ ($nominaPasado8[0]->total)),2);?></td>

                           <td><?php echo  number_format((($costoVentaPasado9[0]->total)+($gastoOperacionesPasado9[0]->total)+ ($nominaPasado9[0]->total)),2);?></td>
                          
                           <td><?php echo  number_format((($costoVentaPasado10[0]->total)+($gastoOperacionesPasado10[0]->total)+ ($nominaPasado10[0]->total)),2);?></td>

                           <td><?php echo  number_format((($costoVentaPasado11[0]->total)+($gastoOperacionesPasado11[0]->total)+ ($nominaPasado11[0]->total)),2);?></td>

                           <td><?php echo  number_format((($costoVentaPasado12[0]->total)+($gastoOperacionesPasado12[0]->total)+ ($nominaPasado12[0]->total)),2);?></td>
                     </tr>
                      <tr style="background-color: #08298A;color: #fff;text-align: right;">
                         <td><b>Utilidad/Pedida:</b></td>
                         <td><?php echo number_format( 
                            ((($comisionPasado1[0]->comision)+($comisionPasado1[1]->comision)+($comisionPasado1[2]->comision)+($comisionPasado1[3]->comision)) - (($costoVentaPasado1[0]->total)+($gastoOperacionesPasado1[0]->total)+ ($nominaPasado1[0]->total))),2);?></td>

                           <td><?php echo number_format( 
                            ((($comisionPasado2[0]->comision)+($comisionPasado2[1]->comision)+($comisionPasado2[2]->comision)+($comisionPasado2[3]->comision)) - (($costoVentaPasado2[0]->total)+($gastoOperacionesPasado2[0]->total)+ ($nominaPasado2[0]->total))),2);?></td>

                           <td><?php echo number_format( 
                            ((($comisionPasado3[0]->comision)+($comisionPasado3[1]->comision)+($comisionPasado3[2]->comision)+($comisionPasado3[3]->comision)) - (($costoVentaPasado3[0]->total)+($gastoOperacionesPasado3[0]->total)+ ($nominaPasado3[0]->total))),2);?></td>

                           <td><?php echo number_format( 
                            ((($comisionPasado4[0]->comision)+($comisionPasado4[1]->comision)+($comisionPasado4[2]->comision)+($comisionPasado4[3]->comision)) - (($costoVentaPasado4[0]->total)+($gastoOperacionesPasado4[0]->total)+ ($nominaPasado4[0]->total))),2);?></td>

                           <td><?php echo number_format( 
                            ((($comisionPasado5[0]->comision)+($comisionPasado5[1]->comision)+($comisionPasado5[2]->comision)+($comisionPasado5[3]->comision)) - (($costoVentaPasado5[0]->total)+($gastoOperacionesPasado5[0]->total)+ ($nominaPasado5[0]->total))),2);?></td>

                           <td><?php echo number_format( 
                            ((($comisionPasado6[0]->comision)+($comisionPasado6[1]->comision)+($comisionPasado6[2]->comision)+($comisionPasado6[3]->comision)) - (($costoVentaPasado6[0]->total)+($gastoOperacionesPasado6[0]->total)+ ($nominaPasado6[0]->total))),2);?></td>

                           <td><?php echo number_format( 
                            ((($comisionPasado7[0]->comision)+($comisionPasado7[1]->comision)+($comisionPasado7[2]->comision)+($comisionPasado7[3]->comision)) - (($costoVentaPasado7[0]->total)+($gastoOperacionesPasado7[0]->total)+ ($nominaPasado7[0]->total))),2);?></td>

                            <td><?php echo number_format( 
                            ((($comisionPasado8[0]->comision)+($comisionPasado8[1]->comision)+($comisionPasado8[2]->comision)+($comisionPasado8[3]->comision)) - (($costoVentaPasado8[0]->total)+($gastoOperacionesPasado8[0]->total)+ ($nominaPasado8[0]->total))),2);?></td>

                           <td><?php echo number_format( 
                            ((($comisionPasado9[0]->comision)+($comisionPasado9[1]->comision)+($comisionPasado9[2]->comision)+($comisionPasado9[3]->comision)) - (($costoVentaPasado9[0]->total)+($gastoOperacionesPasado9[0]->total)+ ($nominaPasado9[0]->total))),2);?></td>
                          
                            <td><?php echo number_format( 
                            ((($comisionPasado10[0]->comision)+($comisionPasado10[1]->comision)+($comisionPasado10[2]->comision)+($comisionPasado10[3]->comision)) - (($costoVentaPasado10[0]->total)+($gastoOperacionesPasado10[0]->total)+ ($nominaPasado10[0]->total))),2);?></td>

                           <td><?php echo number_format( 
                            ((($comisionPasado11[0]->comision)+($comisionPasado11[1]->comision)+($comisionPasado11[2]->comision)+($comisionPasado11[3]->comision)) - (($costoVentaPasado11[0]->total)+($gastoOperacionesPasado11[0]->total)+ ($nominaPasado11[0]->total))),2);?></td>

                            <td><?php echo number_format( 
                            ((($comisionPasado12[0]->comision)+($comisionPasado12[1]->comision)+($comisionPasado12[2]->comision)+($comisionPasado12[3]->comision)) - (($costoVentaPasado12[0]->total)+($gastoOperacionesPasado12[0]->total)+ ($nominaPasado12[0]->total))),2);?></td>
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
                    <i class="fa fa-calendar-check-o"></i> RESUMEN SEGUROS AÑO ACTUAL <?php echo date('Y');?><br>
                 </div>
            <table class="table table-responsive" style="font-size: 11px;">
                <thead>
                    <tr>
                         <th><b>SEGUROS</b></th>
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
                         <td><?php echo  number_format((($comisionActual1[0]->comision)+($comisionActual1[1]->comision)+($comisionActual1[2]->comision)+($comisionActual1[3]->comision)),2)?></td>

                           <td><?php echo  number_format((($comisionActual2[0]->comision)+($comisionActual2[1]->comision)+($comisionActual2[2]->comision)+($comisionActual2[3]->comision)),2)?></td>

                           <td><?php echo  number_format((($comisionActual3[0]->comision)+($comisionActual3[1]->comision)+($comisionActual3[2]->comision)+($comisionActual3[3]->comision)),2)?></td>

                           <td><?php echo  number_format((($comisionActual4[0]->comision)+($comisionActual4[1]->comision)+($comisionActual4[2]->comision)+($comisionActual4[3]->comision)),2)?></td>

                           <td><?php echo  number_format((($comisionActual5[0]->comision)+($comisionActual5[1]->comision)+($comisionActual5[2]->comision)+($comisionActual5[3]->comision)),2)?></td>

                           <td><?php echo  number_format((($comisionActual6[0]->comision)+($comisionActual6[1]->comision)+($comisionActual6[2]->comision)+($comisionActual6[3]->comision)),2)?></td>

                           <td><?php echo  number_format((($comisionActual7[0]->comision)+($comisionActual7[1]->comision)+($comisionActual7[2]->comision)+($comisionActual7[3]->comision)),2)?></td>

                           <td><?php echo  number_format((($comisionActual8[0]->comision)+($comisionActual8[1]->comision)+($comisionActual8[2]->comision)+($comisionActual8[3]->comision)),2)?></td>

                           <td><?php echo  number_format((($comisionActual9[0]->comision)+($comisionActual9[1]->comision)+($comisionActual9[2]->comision)+($comisionActual9[3]->comision)),2)?></td>

                           <td><?php echo  number_format((($comisionActual10[0]->comision)+($comisionActual10[1]->comision)+($comisionActual10[2]->comision)+($comisionActual10[3]->comision)),2)?></td>
                          
                           <td><?php echo  number_format((($comisionActual11[0]->comision)+($comisionActual11[1]->comision)+($comisionActual11[2]->comision)+($comisionActual11[3]->comision)),2)?></td>

                           <td><?php echo  number_format((($comisionActual12[0]->comision)+($comisionActual12[1]->comision)+($comisionActual12[2]->comision)+($comisionActual12[3]->comision)),2)?></td>
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
                            ((($comisionActual1[0]->comision)+($comisionActual1[1]->comision)+($comisionActual1[2]->comision)+($comisionActual1[3]->comision)) - (($costoVenta1[0]->total)+($gastoOperaciones1[0]->total)+ ($nomina1[0]->total))),2);?></td>

                           <td><?php echo number_format( 
                            ((($comisionActual2[0]->comision)+($comisionActual2[1]->comision)+($comisionActual2[2]->comision)+($comisionActual2[3]->comision)) - (($costoVenta2[0]->total)+($gastoOperaciones2[0]->total)+ ($nomina2[0]->total))),2);?></td>

                           <td><?php echo number_format( 
                            ((($comisionActual3[0]->comision)+($comisionActual3[1]->comision)+($comisionActual3[2]->comision)+($comisionActual3[3]->comision)) - (($costoVenta3[0]->total)+($gastoOperaciones3[0]->total)+ ($nomina3[0]->total))),2);?></td>

                           <td><?php echo number_format( 
                            ((($comisionActual4[0]->comision)+($comisionActual4[1]->comision)+($comisionActual4[2]->comision)+($comisionActual4[3]->comision)) - (($costoVenta4[0]->total)+($gastoOperaciones4[0]->total)+ ($nomina4[0]->total))),2);?></td>

                           <td><?php echo number_format( 
                            ((($comisionActual5[0]->comision)+($comisionActual5[1]->comision)+($comisionActual5[2]->comision)+($comisionActual5[3]->comision)) - (($costoVenta5[0]->total)+($gastoOperaciones5[0]->total)+ ($nomina5[0]->total))),2);?></td>

                           <td><?php echo number_format( 
                            ((($comisionActual6[0]->comision)+($comisionActual6[1]->comision)+($comisionActual6[2]->comision)+($comisionActual6[3]->comision)) - (($costoVenta6[0]->total)+($gastoOperaciones6[0]->total)+ ($nomina6[0]->total))),2);?></td>

                           <td><?php echo number_format( 
                            ((($comisionActual7[0]->comision)+($comisionActual7[1]->comision)+($comisionActual7[2]->comision)+($comisionActual7[3]->comision)) - (($costoVenta7[0]->total)+($gastoOperaciones7[0]->total)+ ($nomina7[0]->total))),2);?></td>

                            <td><?php echo number_format( 
                            ((($comisionActual8[0]->comision)+($comisionActual8[1]->comision)+($comisionActual8[2]->comision)+($comisionActual8[3]->comision)) - (($costoVenta8[0]->total)+($gastoOperaciones8[0]->total)+ ($nomina8[0]->total))),2);?></td>

                           <td><?php echo number_format( 
                            ((($comisionActual9[0]->comision)+($comisionActual9[1]->comision)+($comisionActual9[2]->comision)+($comisionActual9[3]->comision)) - (($costoVenta9[0]->total)+($gastoOperaciones9[0]->total)+ ($nomina9[0]->total))),2);?></td>
                          
                            <td><?php echo number_format( 
                            ((($comisionActual10[0]->comision)+($comisionActual10[1]->comision)+($comisionActual10[2]->comision)+($comisionActual10[3]->comision)) - (($costoVenta10[0]->total)+($gastoOperaciones10[0]->total)+ ($nomina10[0]->total))),2);?></td>

                           <td><?php echo number_format( 
                            ((($comisionActual11[0]->comision)+($comisionActual11[1]->comision)+($comisionActual11[2]->comision)+($comisionActual11[3]->comision)) - (($costoVenta11[0]->total)+($gastoOperaciones11[0]->total)+ ($nomina11[0]->total))),2);?></td>

                            <td><?php echo number_format( 
                            ((($comisionActual12[0]->comision)+($comisionActual12[1]->comision)+($comisionActual12[2]->comision)+($comisionActual12[3]->comision)) - (($costoVenta12[0]->total)+($gastoOperaciones12[0]->total)+ ($nomina12[0]->total))),2);?></td>
                     </tr>
                </tbody>
            </table>
        </div>
    </div>
</div>

</div>



<?php
function mesLetra($mes){
    switch ($mes) {
        case 1:return 'ENE';break;
        case 2:return 'FEB';break;
        case 3:return 'MAR';break;
        case 4:return 'ABR';break;
        case 5:return 'MAY';break;
        case 6:return 'JUN';break;
        case 7:return 'JUL';break;
        case 8:return 'AGO';break;
        case 9:return 'SEP';break;
        case 10:return 'OCT';break;
        case 11:return 'NOV';break;
        case 12:return 'DIC';break;
    }
}
function mesesActual(){
    $labelMes=null;
    for($i=1;$i<13;$i++){
        if($i==13){
            $labelMes.="'".mesLetra($i)."'";
        }else{
            $labelMes.="'".mesLetra($i)."',";
        }
    }
    return $labelMes;
}

function mesesTotales($obj){
    $lbCant=null;
    for($i=1;$i<13;$i++){
        foreach ($obj as $row) {
            if($i!=13){
                $lbCant.="'".number_format($row->comision,2)."',";
            }else{
                $lbCant.="'".number_format($row->comision,2)."'";
            }
        }
   }
   return $lbCant;
}
?>

<script type="text/javascript">
//Seguros
var ctx2 = document.getElementById('myChartPresupuestoComision').getContext('2d');
var chart2 = new Chart(ctx2, { //window.myBar
type: 'bar',
data: {
labels: [<?php echo mesesActual()?>],

    datasets: [
          {
            label: 'Asesores Merida',
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
            <?php echo $comisionActual1[0]->comision?>,
            <?php echo $comisionActual2[0]->comision;?>,
            <?php echo $comisionActual3[0]->comision;?>,
            <?php echo $comisionActual4[0]->comision;?>,
            <?php echo $comisionActual5[0]->comision;?>,
            <?php echo $comisionActual6[0]->comision;?>,
            <?php echo $comisionActual7[0]->comision;?>,
            <?php echo $comisionActual8[0]->comision;?>,
            <?php echo $comisionActual9[0]->comision;?>,
            <?php echo $comisionActual10[0]->comision;?>,
            <?php echo $comisionActual11[0]->comision;?>,
            <?php echo $comisionActual12[0]->comision;?>
            ]
        },
        {
            label: 'Asesores Cancun',
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
            <?php echo $comisionActual1[1]->comision;?>,
            <?php echo $comisionActual2[1]->comision;?>,
            <?php echo $comisionActual3[1]->comision;?>,
            <?php echo $comisionActual4[1]->comision;?>,
            <?php echo $comisionActual5[1]->comision;?>,
            <?php echo $comisionActual6[1]->comision;?>,
            <?php echo $comisionActual7[1]->comision;?>,
            <?php echo $comisionActual8[1]->comision;?>,
            <?php echo $comisionActual9[1]->comision;?>,
            <?php echo $comisionActual10[1]->comision;?>,
            <?php echo $comisionActual11[1]->comision;?>,
            <?php echo $comisionActual12[1]->comision;?>
            ]
        },
        {
            label: 'Instituciónal MID',
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
            <?php echo $comisionActual1[2]->comision;?>,
            <?php echo $comisionActual2[2]->comision;?>,
            <?php echo $comisionActual3[2]->comision;?>,
            <?php echo $comisionActual4[2]->comision;?>,
            <?php echo $comisionActual5[2]->comision;?>,
            <?php echo $comisionActual6[2]->comision;?>,
            <?php echo $comisionActual7[2]->comision;?>,
            <?php echo $comisionActual8[2]->comision;?>,
            <?php echo $comisionActual9[2]->comision;?>,
            <?php echo $comisionActual10[2]->comision;?>,
            <?php echo $comisionActual11[2]->comision;?>,
            <?php echo $comisionActual12[2]->comision;?>
            ]
        },
        {
            label: 'Instituciónal CAN',
            stack: 'Stack 3',
            backgroundColor: [
            'rgba(243, 156, 18, 0.6)',
            'rgba(243, 156, 18, 0.6)',
            'rgba(243, 156, 18, 0.6)',
            'rgba(243, 156, 18, 0.6)',
            'rgba(243, 156, 18, 0.6)',
            'rgba(243, 156, 18, 0.6)',
            'rgba(243, 156, 18, 0.6)',
            'rgba(243, 156, 18, 0.6)',
            'rgba(243, 156, 18, 0.6)',
            'rgba(243, 156, 18, 0.6)',
            'rgba(243, 156, 18, 0.6)',
            'rgba(243, 156, 18, 0.6)'
            ],
            data: [
            <?php echo $comisionActual1[3]->comision;?>,
            <?php echo $comisionActual2[3]->comision;?>,
            <?php echo $comisionActual3[3]->comision;?>,
            <?php echo $comisionActual4[3]->comision;?>,
            <?php echo $comisionActual5[3]->comision;?>,
            <?php echo $comisionActual6[3]->comision;?>,
            <?php echo $comisionActual7[3]->comision;?>,
            <?php echo $comisionActual8[3]->comision;?>,
            <?php echo $comisionActual9[3]->comision;?>,
            <?php echo $comisionActual10[3]->comision;?>,
            <?php echo $comisionActual11[3]->comision;?>,
            <?php echo $comisionActual12[3]->comision;?>
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



var ctx1 = document.getElementById('myChartPresupuestoComisionPasado').getContext('2d');
var chart1 = new Chart(ctx1, { //window.myBar
type: 'bar',
data: {
labels: [<?php echo mesesActual()?>],

    datasets: [
          {
            label: 'Asesores Merida',
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

            <?php echo $comisionPasado1[0]->comision;?>,
            <?php echo $comisionPasado2[0]->comision;?>,
            <?php echo $comisionPasado3[0]->comision;?>,
            <?php echo $comisionPasado4[0]->comision;?>,
            <?php echo $comisionPasado5[0]->comision;?>,
            <?php echo $comisionPasado6[0]->comision;?>,
            <?php echo $comisionPasado7[0]->comision;?>,
            <?php echo $comisionPasado8[0]->comision;?>,
            <?php echo $comisionPasado9[0]->comision;?>,
            <?php echo $comisionPasado10[0]->comision;?>,
            <?php echo $comisionPasado11[0]->comision;?>,
            <?php echo $comisionPasado12[0]->comision;?>
            ]
        },
        {
            label: 'Asesores Cancun',
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
            <?php echo $comisionPasado1[1]->comision;?>,
            <?php echo $comisionPasado2[1]->comision;?>,
            <?php echo $comisionPasado3[1]->comision;?>,
            <?php echo $comisionPasado4[1]->comision;?>,
            <?php echo $comisionPasado5[1]->comision;?>,
            <?php echo $comisionPasado6[1]->comision;?>,
            <?php echo $comisionPasado7[1]->comision;?>,
            <?php echo $comisionPasado8[1]->comision;?>,
            <?php echo $comisionPasado9[1]->comision;?>,
            <?php echo $comisionPasado10[1]->comision;?>,
            <?php echo $comisionPasado11[1]->comision;?>,
            <?php echo $comisionPasado12[1]->comision;?>
            ]
        },
        {
            label: 'Instituciónal MID',
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
            <?php echo $comisionPasado1[2]->comision;?>,
            <?php echo $comisionPasado2[2]->comision;?>,
            <?php echo $comisionPasado3[2]->comision;?>,
            <?php echo $comisionPasado4[2]->comision;?>,
            <?php echo $comisionPasado5[2]->comision;?>,
            <?php echo $comisionPasado6[2]->comision;?>,
            <?php echo $comisionPasado7[2]->comision;?>,
            <?php echo $comisionPasado8[2]->comision;?>,
            <?php echo $comisionPasado9[2]->comision;?>,
            <?php echo $comisionPasado10[2]->comision;?>,
            <?php echo $comisionPasado11[2]->comision;?>,
            <?php echo $comisionPasado12[2]->comision;?>
            ]
        },
        {
            label: 'Instituciónal CAN',
            stack: 'Stack 3',
            backgroundColor: [
            'rgba(243, 156, 18, 0.6)',
            'rgba(243, 156, 18, 0.6)',
            'rgba(243, 156, 18, 0.6)',
            'rgba(243, 156, 18, 0.6)',
            'rgba(243, 156, 18, 0.6)',
            'rgba(243, 156, 18, 0.6)',
            'rgba(243, 156, 18, 0.6)',
            'rgba(243, 156, 18, 0.6)',
            'rgba(243, 156, 18, 0.6)',
            'rgba(243, 156, 18, 0.6)',
            'rgba(243, 156, 18, 0.6)',
            'rgba(243, 156, 18, 0.6)'
            ],
            data: [
            <?php echo $comisionPasado1[3]->comision;?>,
            <?php echo $comisionPasado2[3]->comision;?>,
            <?php echo $comisionPasado3[3]->comision;?>,
            <?php echo $comisionPasado4[3]->comision;?>,
            <?php echo $comisionPasado5[3]->comision;?>,
            <?php echo $comisionPasado6[3]->comision;?>,
            <?php echo $comisionPasado7[3]->comision;?>,
            <?php echo $comisionPasado8[3]->comision;?>,
            <?php echo $comisionPasado9[3]->comision;?>,
            <?php echo $comisionPasado10[3]->comision;?>,
            <?php echo $comisionPasado11[3]->comision;?>,
            <?php echo $comisionPasado12[3]->comision;?>
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




var ctx = document.getElementById('myChartPresupuestoGastosPasado').getContext('2d');
var chart3 = new Chart(ctx, { //window.myBar
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
            <?php echo $costoVentaPasado1[0]->total;?>,
            <?php echo $costoVentaPasado2[0]->total;?>,
            <?php echo $costoVentaPasado3[0]->total;?>,
            <?php echo $costoVentaPasado4[0]->total;?>,
            <?php echo $costoVentaPasado5[0]->total;?>,
            <?php echo $costoVentaPasado6[0]->total;?>,
            <?php echo $costoVentaPasado7[0]->total;?>,
            <?php echo $costoVentaPasado8[0]->total;?>,
            <?php echo $costoVentaPasado9[0]->total;?>,
            <?php echo $costoVentaPasado10[0]->total;?>,
            <?php echo $costoVentaPasado11[0]->total;?>,
            <?php echo $costoVentaPasado12[0]->total;?>
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
            <?php echo $gastoOperacionesPasado1[0]->total;?>,
            <?php echo $gastoOperacionesPasado2[0]->total;?>,
            <?php echo $gastoOperacionesPasado3[0]->total;?>,
            <?php echo $gastoOperacionesPasado4[0]->total;?>,
            <?php echo $gastoOperacionesPasado5[0]->total;?>,
            <?php echo $gastoOperacionesPasado6[0]->total;?>,
            <?php echo $gastoOperacionesPasado7[0]->total;?>,
            <?php echo $gastoOperacionesPasado8[0]->total;?>,
            <?php echo $gastoOperacionesPasado9[0]->total;?>,
            <?php echo $gastoOperacionesPasado10[0]->total;?>,
            <?php echo $gastoOperacionesPasado11[0]->total;?>,
            <?php echo $gastoOperacionesPasado12[0]->total;?>
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
            <?php echo $nominaPasado1[0]->total;?>,
            <?php echo $nominaPasado2[0]->total;?>,
            <?php echo $nominaPasado3[0]->total;?>,
            <?php echo $nominaPasado4[0]->total;?>,
            <?php echo $nominaPasado5[0]->total;?>,
            <?php echo $nominaPasado6[0]->total;?>,
            <?php echo $nominaPasado7[0]->total;?>,
            <?php echo $nominaPasado8[0]->total;?>,
            <?php echo $nominaPasado9[0]->total;?>,
            <?php echo $nominaPasado10[0]->total;?>,
            <?php echo $nominaPasado11[0]->total;?>,
            <?php echo $nominaPasado12[0]->total;?>
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


var ctx = document.getElementById('myChartPresupuestoGastos').getContext('2d');
var chart4 = new Chart(ctx, { //window.myBar
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
            <?php echo $costoVenta1[0]->total;?>,
            <?php echo $costoVenta2[0]->total;?>,
            <?php echo $costoVenta3[0]->total;?>,
            <?php echo $costoVenta4[0]->total;?>,
            <?php echo $costoVenta5[0]->total;?>,
            <?php echo $costoVenta6[0]->total;?>,
            <?php echo $costoVenta7[0]->total;?>,
            <?php echo $costoVenta8[0]->total;?>,
            <?php echo $costoVenta9[0]->total;?>,
            <?php echo $costoVenta10[0]->total;?>,
            <?php echo $costoVenta11[0]->total;?>,
            <?php echo $costoVenta12[0]->total;?>
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
            <?php echo $gastoOperaciones1[0]->total;?>,
            <?php echo $gastoOperaciones2[0]->total;?>,
            <?php echo $gastoOperaciones3[0]->total;?>,
            <?php echo $gastoOperaciones4[0]->total;?>,
            <?php echo $gastoOperaciones5[0]->total;?>,
            <?php echo $gastoOperaciones6[0]->total;?>,
            <?php echo $gastoOperaciones7[0]->total;?>,
            <?php echo $gastoOperaciones8[0]->total;?>,
            <?php echo $gastoOperaciones9[0]->total;?>,
            <?php echo $gastoOperaciones10[0]->total;?>,
            <?php echo $gastoOperaciones11[0]->total;?>,
            <?php echo $gastoOperaciones12[0]->total;?>
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
            <?php echo $nomina1[0]->total;?>,
            <?php echo $nomina2[0]->total;?>,
            <?php echo $nomina3[0]->total;?>,
            <?php echo $nomina4[0]->total;?>,
            <?php echo $nomina5[0]->total;?>,
            <?php echo $nomina6[0]->total;?>,
            <?php echo $nomina7[0]->total;?>,
            <?php echo $nomina8[0]->total;?>,
            <?php echo $nomina9[0]->total;?>,
            <?php echo $nomina10[0]->total;?>,
            <?php echo $nomina11[0]->total;?>,
            <?php echo $nomina12[0]->total;?>
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