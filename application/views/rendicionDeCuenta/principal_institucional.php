<style>
    #contenedorI{
        width:100%;
        /*border: 1px red solid;*/
        margin: 0 auto;
        text-align:center;
    }
    .contenedor_personal{
        /*width: 85%;*/
        /*border: 1px blue solid; */
        margin: 0 auto;
        text-align: center;
    }
    .img{
        width:30%;
        height:30%;
    }
</style>

<div id="contenedorI">
    <h5 class="text-center">Tablero de equipo intitucional</h5>
    <div class="contenedor_personal">
        <table class="table table-striped">
            <thead>
                <tr class="active">
                    <td class="text-center text-danger"><br><br> Colaborador</td>
                    <td class="text-center text-success"><img class="img" src="<?=base_url()."assets/images/images_reportes/estetoscopio.png"?>" alt=""><br>GMM</td>
                    <td class="text-center text-danger"><img class="img" src="<?=base_url()."assets/images/images_reportes/latido-del-corazon.png"?>" alt=""><br>VIDA</td>
                    <td class="text-center text-warning"><img class="img" src="<?=base_url()."assets/images/images_reportes/hogar.png"?>" alt=""><br>DAÑOS</td>
                    <td class="text-center text-info"><img class="img" src="<?=base_url()."assets/images/images_reportes/coche.png"?>" alt=""><br>AUTOS</td>
                    <td class="text-center text-default"><img class="img" src="<?=base_url()."assets/images/images_reportes/persona-cayendo-escaleras.png"?>" alt=""><br>AP</td>
                    <td class="text-center text-warning"><br>TOTAL SEMANAL</td>
                    <td class="text-center text-warning"><br>TOTAL ACUMULADO</td>
                </tr>
            </thead>
            <tbody id="tabla_cuerpo_colaborador">
            </tbody>
        </table>
    </div>
    <div class="contenedor_personal">
        <table class="table table-striped">
            <thead>
                <tr class="active">
                    <td class="text-center text-danger"><br><br>Agentes</td>
                    <td class="text-center text-success"><img class="img" src="<?=base_url()."assets/images/images_reportes/estetoscopio.png"?>" alt=""><br>GMM</td>
                    <td class="text-center text-danger"><img class="img" src="<?=base_url()."assets/images/images_reportes/latido-del-corazon.png"?>" alt=""><br>VIDA</td>
                    <td class="text-center text-warning"><img class="img" src="<?=base_url()."assets/images/images_reportes/hogar.png"?>" alt=""><br>DAÑOS</td>
                    <td class="text-center text-info"><img class="img" src="<?=base_url()."assets/images/images_reportes/coche.png"?>" alt=""><br>AUTOS</td>
                    <td class="text-center text-default"><img class="img" src="<?=base_url()."assets/images/images_reportes/persona-cayendo-escaleras.png"?>" alt=""><br>AP</td>
                    <td class="text-center text-warning"><br>TOTAL SEMANAL</td>
                    <td class="text-center text-warning"><br>TOTAL ACUMULADO</td>
                </tr>
            </thead>
            <tbody id="tabla_cuerpo_agente">
            </tbody>
        </table>
    </div>
    <br>
    <div id="contenedor_informacion">
        <table class="table table-bordered">
            <tbody>
                <tr>
                    <td id="conteoPolizas"></td>
                    <td>Pólizas emitidas</td>
                    <td>Meta comercial</td>
                    <td>Fecha Inicio</td>
                    <td>Sem 1</td>
                    <td>Sem 2</td>
                    <td>Sem 3</td>
                    <td>Sem 4</td>
                    <td>Sem 5</td>
                    <td>Avance</td>
                </tr>
                <tr>
                    <td id="primasEmitidas" class="text-left"></td>
                    <td class="text-left">Prima emitida</td>
                    <?php foreach($metaComercial as $valor){?>
                        <td><?="$ ".number_format($valor->monto_al_mes)?></td>
                    <?php }?>
                    <td class="FI"></td>
                    <td id="sem1_1"></td>
                    <td id="sem1_2"></td>
                    <td id="sem1_3"></td>
                    <td id="sem1_4"></td>
                    <td id="sem1_5"></td>
                </tr>
                <tr>
                    <td id="primasCobradas" class="text-left"></td>
                    <td class="text-left">Prima cobrada</td>
                    <td class="text-right" colspan="2">IDEAL</td>
                    <td id="Prima_ideal_sem_1"></td>
                    <td id="Prima_ideal_sem_2"></td>
                    <td id="Prima_ideal_sem_3"></td>
                    <td id="Prima_ideal_sem_4"></td>
                    <td id="Prima_ideal_sem_5"></td>
                    <td></td>
                </tr>
                <tr>
                    <td id="primasPendientes" class="text-left"></td>
                    <td class="text-left">Prima por cobrar</td>
                    <td class="text-right" colspan="2">REAL</td>
                    <td id="Prima_real_sem_1"></td>
                    <td id="Prima_real_sem_2"></td>
                    <td id="Prima_real_sem_3"></td>
                    <td id="Prima_real_sem_4"></td>
                    <td id="Prima_real_sem_5"></td>
                    <td></td>
                </tr>
                <tr>
                    <td id="comisionEmitida" class="text-left"></td>
                    <td class="text-left">Comisión generada</td>
                    <td class="text-left warning" colspan="2">Recibo y subsecuente</td>
                </tr>
                <tr>
                    <td id="comisionCobrada" class="text-left"></td>
                    <td class="text-left">Comisión cobrada</td>
                    <?php foreach($metaComercial as $valor){?>
                        <td><?="$ ".number_format($valor->monto_al_mes)?></td>
                    <?php }?>
                    <!--<td><?="$ ".number_format($metaComercial->monto_al_mes)?></td>-->
                    <td class="FI"></td>
                </tr>
                <tr>
                    <td id="comisionPendiente" class="text-left"></td>
                    <td class="text-left">Comisión pendiente</td>
                    <td class="text-right" colspan="2">IDEAL</td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                </tr>
                <tr>
                    <td id="comision_pendiente_mes" class="text-left"></td>
                    <td class="text-left">Comisión promedio mes</td>
                    <td class="text-right" colspan="2">REAL</td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                </tr>
                <tr>
                    <td></td>
                    <td class="text-left">Comisión promedio semana</td>
                </tr>
            </tbody>
        </table>
    </div>
</div>