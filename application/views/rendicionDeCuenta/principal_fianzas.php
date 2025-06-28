<style>
    #contenedorF{
        width:100%;
        /*border: 1px red solid;*/
        margin: 0 auto;
        text-align:center;
        overflow: scroll;
    }
    .contenedor_personalF{
        width: 100%;
        /*border: 1px blue solid;*/
        margin: 0 auto;
        text-align: center;
    }
</style>

<div id="contenedorF">
    <div class="contenedor_personalF">
        <table class="table table-striped">
            <thead>
                <tr>
                    <th class="text-center text-danger" >Agente</th>
                    <th class="text-center text-success">Sem 1</th>
                    <th class="text-center">Prima Emitida</th>
                    <th class="text-center">Comisión</th>
                    <th class="text-center text-danger">Sem 2</th>
                     <th class="text-center">Prima Emitida</th>
                     <th class="text-center">Comisión</th>
                     <th class="text-center text-warning">Sem 3</th>
                     <th class="text-center">Prima Emitida</th>
                     <th class="text-center">Comisión</th>
                     <th class="text-center text-info">Sem 4</th>
                     <th class="text-center">Prima Emitida</th>
                    <th class="text-center">Comisión</th>
                    <th class="text-center">Emision semanal</th>
                    <th class="text-center">Emisión acumulada</th>
                    <th class="text-center">Comisión</th>
                </tr>
            </thead>
            <tbody id="tabla_cuerpo_colaborador">
            </tbody>
        </table>
    </div>
    <br>
    <div id="contenedor_informacion_fianzas">
        <table class="table table-bordered">
            <tbody>
                <tr>
                    <td id="conteoPolizas"></td>
                    <td></td>
                    <td>fecha 1</td>
                    <td>fecha 2</td>
                    <td>fecha 3</td>
                    <td>fecha 4</td>
                    <td>Total mensual</td>
                    <td></td>
                    <td>F.Inicio</td>
                    <td>Sem 1</td>
                    <td>Sem 2</td>
                    <td>Sem 3</td>
                    <td>Sem 4</td>
                    <td>Avance</td>
                </tr>
                <tr>
                    <td id="primasEmitidas"></td>
                    <td class="text-left">Pólizas emitidas</td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td id=""></td>
                </tr>
                <tr>
                    <td></td>
                    <td class="text-left">Prima emitida</td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td id="primasEmitidas"></td>
                </tr>
                <tr>
                    <td></td>
                    <td class="text-left">Prima cobrada</td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td id="primasCobradas"></td>
                    <td></td>
                    <td class="text-right">IDEAL</td>
                    <td id="Prima_ideal_sem_1"></td>
                    <td id="Prima_ideal_sem_2"></td>
                    <td id="Prima_ideal_sem_3"></td>
                    <td id="Prima_ideal_sem_4"></td>
                    <td></td>
                </tr>
                <tr>
                    <td></td>
                    <td class="text-left">Prima por cobrar</td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td id="primasPendientes"></td>
                    <td></td>
                    <td class="text-right">REAL</td>
                    <td id="Prima_real_sem_1"></td>
                    <td id="Prima_real_sem_2"></td>
                    <td id="Prima_real_sem_3"></td>
                    <td id="Prima_real_sem_4"></td>
                    <td></td>
                </tr>
                <tr>
                    <td></td>
                    <td class="text-left">Comisión generada</td>
                    <!--<td class="text-left warning" colspan="2">Recibo y subsecuente</td>-->
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td id="comisionEmitida"></td>
                    <td></td>
                    <td class="text-center" colspan="5">Proyección</td>
                    <td></td>
                </tr>
                <tr>
                    <td></td>
                    <td class="text-left">Comisión cobrada</td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td id="comisionCobrada"></td>
                </tr>
                <tr>
                    <td></td>
                    <td class="text-left">Comisión pendiente</td>
                    <!--<td class="text-right" colspan="2">IDEAL</td>-->
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td id="comisionPendiente"></td>
                    <td></td>
                </tr>
                <tr>
                    <td></td>
                    <td class="text-left">Comisión promedio</td>
                    <!--<td class="text-right" colspan="2">REAL</td>-->
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td id="comision_pendiente_mes"></td>
                    <td></td>
                </tr>
                <!--<tr>
                    <td></td>
                    <td class="text-left">Comisión promedio semana</td>
                </tr>-->
            </tbody>
        </table>
    </div>
</div>